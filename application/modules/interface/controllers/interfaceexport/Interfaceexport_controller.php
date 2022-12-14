<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );


require_once(APPPATH.'libraries/rabbitmq/vendor/autoload.php');
require_once(APPPATH.'config/rabbitmq.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Interfaceexport_controller extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('interface/interfaceexport/Interfaceexport_model');
        // $this->load->model('interface/interfaceimport/Interfaceimport_model');
    }

    public function index($nBrowseType,$tBrowseOption){

        $tUserCode = $this->session->userdata('tSesUserCode');
        $tLangEdit = $this->session->userdata("tLangEdit");
        $aParams = [
            'prefixQueueName' => 'LK_RPTransferResponseSAP',
            'ptUsrCode' => $tUserCode
        ];
        $this->FSxCIFXRabbitMQDeleteQName($aParams);
        $this->FSxCIFXRabbitMQDeclareQName($aParams);

        $aPackData = array(
            'nBrowseType'                   => $nBrowseType,
            'tBrowseOption'                 => $tBrowseOption,
            'aAlwEventInterfaceExport'      => FCNaHCheckAlwFunc('interfaceexport/0/0'), //Controle Event
            'vBtnSave'                      => FCNaHBtnSaveActiveHTML('interfaceexport/0/0'), //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
            'aDataMasterImport'             => $this->Interfaceexport_model->FSaMIFXGetHD($tLangEdit)
        );
        $this->load->view('interface/interfaceexport/wInterfaceExport',$aPackData);

    }

    public function FSxCIFXRabbitMQDeclareQName($paParams){

        $tPrefixQueueName = $paParams['prefixQueueName'];
        $tQueueName = $tPrefixQueueName;

        $oConnection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
        $oChannel = $oConnection->channel();
        $oChannel->queue_declare($tQueueName, false, true, false, false);
        $oChannel->close();
        $oConnection->close();
        return 1; /** Success */
    }

    public function FSxCIFXRabbitMQDeleteQName($paParams) {

        $tPrefixQueueName = $paParams['prefixQueueName'];
        $tQueueName = $tPrefixQueueName;
        // $oConnection = new AMQPStreamConnection('172.16.30.28', '5672', 'admin', '1234', 'Pandora_PPT1');
        $oConnection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
        $oChannel = $oConnection->channel();
        $oChannel->queue_delete($tQueueName);
        $oChannel->close();
        $oConnection->close();
        return 1; /** Success */
    }

    public function FSxCIFXCallRabitMQ(){
        $tTypeEvent = $this->input->post('ptTypeEvent');
        $nReqpairExport = $this->input->post('ocbReqpairExport');

                if($tTypeEvent == 'getpassword'){
                    $aResult = $this->Interfaceexport_model->FSaMINMGetDataConfig();
                    if($aResult['rtCode'] != 1){
                        $aConnect = array(
                            'tHost'      => '',
                            'tPort'      => '',
                            'tPassword'  => '',
                            'tUser'      => '',
                            'tVHost'     => '',
                            
                        );
                    }else{
                        $aConnect = array(
                            'tHost'      => $aResult['tLK_NotiHost']['FTCfgStaUsrValue'],
                            'tPort'      => $aResult['tLK_NotiPort']['FTCfgStaUsrValue'],
                            'tPassword'  => $aResult['tLK_NotiPwd']['FTCfgStaUsrValue'],
                            'tUser'      => $aResult['tLK_NotiUsr']['FTCfgStaUsrValue'],
                            'tVHost'     => $aResult['tLK_NotiVHost']['FTCfgStaUsrValue']
                        );
                    }
                    echo json_encode($aConnect);
                }else{


                    if($nReqpairExport!=1){
                    $aIFXExport     = $this->input->post('ocmIFXExport');
                    $tPassword      = $this->input->post('tPassword');
                    if(!empty($aIFXExport)){
                        $aPackData = array(
                            // Sale
                            'tBchCodeSale'          => $this->input->post('oetIFXBchCodeSale'),
                            'dDateFromSale'         => $this->input->post('oetITFXDateFromSale'),
                            'dDateToSale'           => $this->input->post('oetITFXDateToSale'),
                            'tDocNoFrom'            => $this->input->post('oetITFXXshDocNoFrom'),
                            'tDocNoTo'              => $this->input->post('oetITFXXshDocNoTo'),

                            // Fin
                            'tBchCodeFin'           => $this->input->post('oetIFXBchCodeFin'),
                            'dDateFromFinance'      => $this->input->post('oetITFXDateFromFinance'),
                            'dDateToFinance'        => $this->input->post('oetITFXDateToFinance'),
                            'tPasswordMQ'           => $tPassword
                        );

                        foreach($aIFXExport as $nKey => $nValue){
                            $this->FSaCIFXGetFormatParam($nValue,$aPackData);
                        }
                    }
                    return;


                    }else{


                        $this->FSxCINFCallPreapairExport($this->input->post('tPassword'));


                    }


                }

    }

    public function FCNxCallRabbitMQSale($paParams,$pbStaUse = true,$ptPasswordMQ) {

        $aVal = $this->Interfaceexport_model->FSaMINMGetDataConfig();
        $tHost      = $aVal['tLK_NotiHost']['FTCfgStaUsrValue'];
        $tPort      = $aVal['tLK_NotiPort']['FTCfgStaUsrValue'];
        $tPassword  = $aVal['tLK_NotiPwd']['FTCfgStaUsrValue'];
        // $tQueueName = $aVal[4]['FTCfgStaUsrValue'];
        $tUser      = $aVal['tLK_NotiUsr']['FTCfgStaUsrValue'];
        $tVHost     = $aVal['tLK_NotiVHost']['FTCfgStaUsrValue'];

        $tQueueName             = $paParams['queueName'];
        $aParams                = $paParams['params'];
        if($pbStaUse == true){
            $aParams['ptConnStr']   = DB_CONNECT;
        }
        $tExchange              = EXCHANGE; // This use default exchange


        $oConnection = new AMQPStreamConnection($tHost, $tPort,  $tUser, $ptPasswordMQ, $tVHost);
        $oChannel = $oConnection->channel();
        $oChannel->queue_declare($tQueueName, false, false, false, false);
        $oMessage = new AMQPMessage(json_encode($aParams));
        $oChannel->basic_publish($oMessage, "", $tQueueName);

        $oChannel->close();
        $oConnection->close();
        return 1; /** Success */
    }

    public function FSaCIFXGetFormatParam($pnFormat,$paPackData){
        $aResult = $this->Interfaceexport_model->FSaMINMGetDataBranch($paPackData['tBchCodeSale']);
        
        if(!empty($paPackData['dDateFromSale'])){
            $aDateFromSale = explode("-", $paPackData['dDateFromSale']);
            $paPackData['dDateFromSale'] = $aDateFromSale[0].'-'.$aDateFromSale[1].'-'.$aDateFromSale[2];
        }


        if(!empty($paPackData['dDateToSale'])){
            $aDateToSale = explode("-", $paPackData['dDateToSale']);
            $paPackData['dDateToSale'] = $aDateToSale[0].'-'.$aDateToSale[1].'-'.$aDateToSale[2];
        }


        if(!empty($paPackData['dDateFromFinance'])){
            $aDateFromFinance = explode("-", $paPackData['dDateFromFinance']);
            $paPackData['dDateFromFinance'] = $aDateFromFinance[0].'-'.$aDateFromFinance[1].'-'.$aDateFromFinance[2];
        }


        if(!empty($paPackData['dDateToFinance'])){
            $aDateToFinance = explode("-", $paPackData['dDateToFinance']);
            $paPackData['dDateToFinance'] = $aDateToFinance[0].'-'.$aDateToFinance[1].'-'.$aDateToFinance[2];
        }


        //ถ้าไม่เลือกเลขที่เอกสารมา จะต้องส่งไปหาแบบช่วง วันที่ ทั้งหมด
        if(($paPackData['tDocNoFrom'] == '' || $paPackData['tDocNoFrom'] == null) && ($paPackData['tDocNoTo'] == '' || $paPackData['tDocNoTo'] == null)){
            $aMQParams[1] = [
                "queueName"     => "LK_QSale2Vender".$aResult->FTAgnCode,
                "exchangname"   => "",
                "params"        => [
                    "ptFunction"    =>  "SalePos",//ชื่อ Function
                    "ptSource"      =>  "AdaStoreBack", //ต้นทาง
                    "ptDest"        =>  "MQAdaLink",  //ปลายทาง
                    "ptData"        =>  json_encode([
                        "ptFilter"      => $paPackData['tBchCodeSale'],
                        "ptDateFrm"     => $paPackData['dDateFromSale'],
                        "ptDateTo"      => $paPackData['dDateToSale'],
                        "ptDocNoFrm"    => '',
                        "ptDocNoTo"     => '',
                        "ptWaHouse"     => '',
                        "ptPosCode"     => '',
                        "ptRound"       => '1'
                    ])
                ]
            ];
            $this->FCNxCallRabbitMQSale($aMQParams[$pnFormat],false,$paPackData['tPasswordMQ']);
        }else{
            //ถ้าไม่เลือกวันที่มา จะต้อส่งไปหาแบบช่วง เลขที่เอกสาร
            $aGetDataDocNo = $this->Interfaceexport_model->FSaMINMGetDataDocNo($paPackData['tDocNoFrom'],$paPackData['tDocNoTo']);
            foreach($aGetDataDocNo as $aValue){
                $aMQParams[1] = [
                    "queueName"     => "LK_QSale2Vender".$aResult->FTAgnCode,
                    "exchangname"   => "",
                    "params"        => [
                        "ptFunction"    =>  "SalePos",//ชื่อ Function
                        "ptSource"      =>  "AdaStoreBack", //ต้นทาง
                        "ptDest"        =>  "MQAdaLink",  //ปลายทาง
                        "ptData"        =>  json_encode([
                            "ptFilter"      => $paPackData['tBchCodeSale'],
                            "ptDateFrm"     => $paPackData['dDateFromSale'],
                            "ptDateTo"      => $paPackData['dDateToSale'],
                            "ptDocNoFrm"    => $aValue['FTXshDocNo'],
                            "ptDocNoTo"     => $aValue['FTXshDocNo'],
                            "ptWaHouse"     => '',
                            "ptPosCode"     => '',
                            "ptRound"       => '1'
                        ])
                    ]
                ];
                $this->FCNxCallRabbitMQSale($aMQParams[$pnFormat],false,$paPackData['tPasswordMQ']);
            }
        }
    }


//ส่งคิวตามรายการบิล เฉพาะการติ๊กว่า ส่งไม่สำเร็จ
 public function FSxCINFCallPreapairExport($ptPasswordMQ){
     $aDocNoPrepair= $this->Interfaceexport_model->FSaMINMGetLogHisError();

        if(!empty($aDocNoPrepair)){
            foreach($aDocNoPrepair as $aValue){
                $aResult = $this->Interfaceexport_model->FSaMINMGetDataBranch($aValue['FTBchCode']);

                $aMQParams = [
                    "queueName"     => "LK_QSale2Vender".$aResult->FTAgnCode,
                    "exchangname"   => "",
                    "params"        => [
                        "ptFunction"    =>  "SalePos",//ชื่อ Function
                        "ptSource"      =>  "AdaStoreBack", //ต้นทาง
                        "ptDest"        =>  "MQAdaLink",  //ปลายทาง
                        "ptData"        =>  json_encode([
                            "ptFilter"      => $aValue['FTBchCode'],
                            "ptDateFrm"     => '',
                            "ptDateTo"      => '',
                            "ptDocNoFrm"    => $aValue['FTLogTaskRef'],
                            "ptDocNoTo"     => $aValue['FTLogTaskRef'],
                            "ptWaHouse"     => '',
                            "ptPosCode"     => '',
                            "ptRound"       => '1'
                        ])
                    ]
                ];


                $this->FCNxCallRabbitMQSale($aMQParams,false,$ptPasswordMQ);
            }
        }

 }

}
?>
