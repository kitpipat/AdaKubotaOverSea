<?php 
defined('BASEPATH') or exit('No direct script access allowed');
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
class Repairrunningbill_controller extends MX_Controller {

    /**
     * ภาษาที่เกี่ยวข้อง
     * @var array
    */
    public $aTextLang   = [];

    public function __construct() {
        $this->load->model('tool/tool/Repairrunningbill_model');
        parent::__construct();
    }

    // Functionality : ฟังก์ชั่น ดึงข้อมูลจากฐานข้อมูล เมื่อแรกเข้าสู่หน้า
    // Parameters : Ajax and Function Parameter
    // Creator : 14/01/2019 wasin
    // Return : String View
    // Return Type : View
    public function FSvCRPNMainPage(){
    
        $aDataConfigView    =  [
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave(),
            'aTextLang'         => $this->aTextLang,
        ];

        $this->load->view('tool/tool/repairrunningbill/wRePairRunningBillMain',$aDataConfigView);
    }



    public function FSvCRPNDataTable(){

        $nPage          = ($this->input->post('nPageCurrent') == '' || null) ? 1 : $this->input->post('nPageCurrent');   // Check Number Page

        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
        );

        $aListData = array(
            'aTotalSaleByBranchData' => $this->Repairrunningbill_model->FSaMRPNDataTable($aData),
            'nPage'         => $nPage,
        );
  
        $this->load->view('tool/tool/repairrunningbill/wRePairRunningBillDataTable',$aListData);

    }





    // Functionality : ฟังก์ชั่น MQ Request Sale Data
    // Parameters : Ajax and Function Parameter
    // Creator : 20/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSvCRPNCallMQPrc(){
        try{

            $tRpRnDocUUID = $this->input->post('tRpRnDocUUID');
            if($tRpRnDocUUID!=''){
                $aReults = $this->Repairrunningbill_model->FSaMRPNUpdateUUIDToGTRegen($tRpRnDocUUID);

                if($aReults['rtCode']=='1'){

                    $tRpRnDocUUID = $this->input->post('tRpRnDocUUID');
                    $aMQParams = [
                        "queueName" => "Tool_RunningBillServer",
                        "params"    => [
                            "ptUUID"  => $tRpRnDocUUID
                        ]
                    ];
                    $this->FSxCRPNRabbitMQRequest($aMQParams);

                    $aReturn = array(
                        'nStaEvent'    => '1',
                        'tStaMessg'    => 'ok'
                    );
                }else{
                    $aReturn = array(
                        'nStaEvent'    => '99',
                        'tStaMessg'    => 'Try to try again.'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '99',
                    'tStaMessg'    => 'UUID Not Found'
                );
            }

            echo json_encode($aReturn);
        }catch(Exception $Error){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => language('tool/tool/tool', 'tToolMassageError')
            );
            echo json_encode($aReturn);
            return;
        }

    }



    public function FSxCRPNRabbitMQRequest($paParams){

    $tQueueName = $paParams['queueName'];
    $aParams = $paParams['params'];
    // $aParams['ptConnStr'] = DB_CONNECT;
    $aParams['ptConnStr'] = 'Data Source='.DATABASE_IP.';Initial Catalog='.BASE_DATABASE.';User ID='.DATABASE_USERNAME.';Password='.DATABASE_PASSWORD.';Connection Timeout=30;Connection Lifetime=0;Min Pool Size=30;Max Pool Size=100;Pooling=true;';
    $tExchange = '';

    $oConnection = new AMQPStreamConnection(MQ_Sale_HOST, MQ_Sale_PORT, MQ_Sale_USER, MQ_Sale_PASS, MQ_Sale_VHOST);
    $oChannel = $oConnection->channel();
    $oChannel->queue_declare($tQueueName, false, true, false, false);
    $oMessage = new AMQPMessage(json_encode($aParams));
    $oChannel->basic_publish($oMessage, "", $tQueueName);
    $oChannel->close();
    $oConnection->close();
        return 1; /** Success */
    }



    function FSxCRPNRabbitMQDeclareQName($paParams){

        // $tPrefixQueueName = $paParams['prefixQueueName'];
        // $tQueueName = $tPrefixQueueName;
        
        // $oConnection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
        // $oChannel = $oConnection->channel();
        // $oChannel->queue_declare($tQueueName, false, true, false, false);
        // $oChannel->close();
        // $oConnection->close();

        $tQueueName = $paParams['prefixQueueName'];
        $aParams = $paParams['params'];
        $aParams['ptConnStr'] = DB_CONNECT;
        $tExchange = $paParams['exchangeName'];
        
        $oConnection = new AMQPStreamConnection(MQ_Sale_HOST, MQ_Sale_PORT, MQ_Sale_USER, MQ_Sale_PASS, MQ_Sale_VHOST);
        $oChannel = $oConnection->channel();
        $oChannel->queue_declare($tQueueName, false, true, false, false);
        $oChannel->exchange_declare($tExchange, 'fanout', false, false, false);
        $oChannel->queue_bind($tQueueName, $tExchange);
        // $oMessage = new AMQPMessage(json_encode($aParams));
        // $oChannel->basic_publish($oMessage, $tExchange);

        // echo "[x] Sent $tQueueName Success";

        $oChannel->close();
        $oConnection->close();

        return 1; /** Success */
    }


    function FSxCINMRabbitMQDeleteQName($paParams) {

        $tPrefixQueueName = $paParams['prefixQueueName'];
        $tQueueName = $tPrefixQueueName;
        // $oConnection = new AMQPStreamConnection('172.16.30.28', '5672', 'admin', '1234', 'Pandora_PPT1');
        $oConnection = new AMQPStreamConnection(MQ_Sale_HOST, MQ_Sale_PORT, MQ_Sale_USER, MQ_Sale_PASS, MQ_Sale_VHOST);
        $oChannel = $oConnection->channel();
        $oChannel->queue_delete($tQueueName);
        $oChannel->close();
        $oConnection->close();
        return 1; /** Success */
    
        
    }






 

}