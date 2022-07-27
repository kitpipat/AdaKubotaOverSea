<?php 
defined('BASEPATH') or exit('No direct script access allowed');
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
class Adatools_controller extends MX_Controller {

    /**
     * ภาษาที่เกี่ยวข้อง
     * @var array
    */
    public $aTextLang   = [];

    public function __construct() {
        $this->load->model('tool/tool/Adatools_model');
        $this->FSxCInitParams();
        parent::__construct();
    }

        // Functionality: เซทค่าพารามิเตอร์
    // Parameters: Ajax and Function Parameter
    // Creator: 14/01/2020 wasin(Yoshi)
    // Return: None
    // ReturnType: none
    private function FSxCInitParams(){
        // Text Lang
        $this->aTextLang    = [
            // Lang Title Panel
            'tSMTSALTitleMenu'              => language('sale/salemonitor/salemonitor','tSMTSALTitleMenu'),
            'tSMTSALDateDataFrom'           => language('sale/salemonitor/salemonitor','tSMTSALDateDataFrom'),
            'tSMTSALDateDataTo'             => language('sale/salemonitor/salemonitor','tSMTSALDateDataTo'),
            'tSMTSALBillQty'                => language('sale/salemonitor/salemonitor','tSMTSALBillQty'),
            'tSMTSALBillTotalAll'           => language('sale/salemonitor/salemonitor','tSMTSALBillTotalAll'),
       
            'tSMTSALSaleData'               => language('sale/salemonitor/salemonitor','tSMTSALSaleData'),
            'tSMTSALAPIData'                => language('sale/salemonitor/salemonitor','tSMTSALAPIData'),
            // Lang Data
            'tSMTSALSaleBill'               => language('sale/salemonitor/salemonitor','tSMTSALSaleBill'),
            'tSMTSALRefundBill'             => language('sale/salemonitor/salemonitor','tSMTSALRefundBill'),
            'tSMTSALTotalBill'              => language('sale/salemonitor/salemonitor','tSMTSALTotalBill'),
            'tSMTSALTotalSale'              => language('sale/salemonitor/salemonitor','tSMTSALTotalSale'),
            'tSMTSALTotalRefund'            => language('sale/salemonitor/salemonitor','tSMTSALTotalRefund'),
            'tSMTSALTotalGrand'             => language('sale/salemonitor/salemonitor','tSMTSALTotalGrand'),
            // Label Chart
            'tSMTSALXsdNet'                 => language('sale/salemonitor/salemonitor','tSMTSALXsdNet'),
            'tSMTSALStkQty'                 => language('sale/salemonitor/salemonitor','tSMTSALStkQty'),
            // Lang Not Found Data
            'tSMTSALNotFoundTopTenNewPdt'   => language('sale/salemonitor/salemonitor','tSMTSALNotFoundTopTenNewPdt'),
            // Lang Modal Title
            'tSMTSALModalTitleFilter'       => language('sale/salemonitor/salemonitor','tSMTSALModalTitleFilter'),
            'tSMTSALModalBtnCancel'         => language('sale/salemonitor/salemonitor','tSMTSALModalBtnCancel'),
            'tSMTSALModalBtnSave'           => language('sale/salemonitor/salemonitor','tSMTSALModalBtnSave'),
            // Form Input Filter
            'tSMTSALModalAppType'           => language('sale/salemonitor/salemonitor','tSMTSALModalAppType'),
            'tSMTSALModalAppType1'          => language('sale/salemonitor/salemonitor','tSMTSALModalAppType1'),
            'tSMTSALModalAppType2'          => language('sale/salemonitor/salemonitor','tSMTSALModalAppType2'),
            'tSMTSALModalAppType3'          => language('sale/salemonitor/salemonitor','tSMTSALModalAppType3'),
            'tSMTSALModalBranch'            => language('sale/salemonitor/salemonitor','tSMTSALModalBranch'),
            'tSMTSALModalMerchant'          => language('sale/salemonitor/salemonitor','tSMTSALModalMerchant'),
            'tSMTSALModalShop'              => language('sale/salemonitor/salemonitor','tSMTSALModalShop'),
            'tSMTSALModalPos'               => language('sale/salemonitor/salemonitor','tSMTSALModalPos'),
            'tSMTSALModalProduct'           => language('sale/salemonitor/salemonitor','tSMTSALModalProduct'),
            'tSMTSALModalStatusCst'         => language('sale/salemonitor/salemonitor','tSMTSALModalStatusCst'),
            'tSMTSALModalStatusCst1'        => language('sale/salemonitor/salemonitor','tSMTSALModalStatusCst1'),
            'tSMTSALModalStatusCst2'        => language('sale/salemonitor/salemonitor','tSMTSALModalStatusCst2'),
            'tSMTSALModalStatusPayment'     => language('sale/salemonitor/salemonitor','tSMTSALModalStatusPayment'),
            'tSMTSALModalStatusPayment1'    => language('sale/salemonitor/salemonitor','tSMTSALModalStatusPayment1'),
            'tSMTSALModalStatusPayment2'    => language('sale/salemonitor/salemonitor','tSMTSALModalStatusPayment2'),
            'tSMTSALModalStatusAll'         => language('sale/salemonitor/salemonitor','tSMTSALModalStatusAll'),
            'tSMTSALModalRecive'            => language('sale/salemonitor/salemonitor','tSMTSALModalRecive'),
            'tSMTSALModalPdtGrp'            => language('sale/salemonitor/salemonitor','tSMTSALModalPdtGrp'),
            'tSMTSALModalPdtPty'            => language('sale/salemonitor/salemonitor','tSMTSALModalPdtPty'),
            'tSMTSALModalWah'               => language('sale/salemonitor/salemonitor','tSMTSALModalWah'),
            'tSMTSALModalTopLimit'          => language('sale/salemonitor/salemonitor','tSMTSALModalTopLimit'),
        ];
        $this->aAlwEvent        = FCNaHCheckAlwFunc('tool');
        $this->nOptDecimalShow  = FCNxHGetOptionDecimalShow();
        $this->nOptDecimalSave  = FCNxHGetOptionDecimalSave();
        $this->nLangEdit        = $this->session->userdata("tLangEdit");
        $this->tSesUserCode     = $this->session->userdata('tSesUserCode');
        $this->tSesUserName     = $this->session->userdata('tSesUsername');
        $this->aDataWhere       = [
            'nLngID'            => $this->nLangEdit,
            'tDateDataForm'     => (!empty($this->input->post('ptDateDataForm')))? $this->input->post('ptDateDataForm') : '',
            'tDateDataTo'       => (!empty($this->input->post('ptDateDataTo')))? $this->input->post('ptDateDataTo')     : '',
            // Sale Type Key
            'tSMTSALTypeKey'    => (!empty($this->input->post('ohdSMTSALFilterKey')))? $this->input->post('ohdSMTSALFilterKey') : '',
            // Branch Filter
            'bFilterBchStaAll'  => (!empty($this->input->post('oetSMTSALFilterBchStaAll')) && ($this->input->post('oetSMTSALFilterBchStaAll') == 1))? true : false,
            'tFilterBchCode'    => (!empty($this->input->post('oetSMTSALFilterBchCode')))? $this->input->post('oetSMTSALFilterBchCode') : "",
            'tFilterBchName'    => (!empty($this->input->post('oetSMTSALFilterBchName')))? $this->input->post('oetSMTSALFilterBchName') : "",
            // Merchant Filter
            'bFilterMerStaAll'  => (!empty($this->input->post('oetSMTSALFilterMerStaAll')) && ($this->input->post('oetSMTSALFilterMerStaAll') == 1))? true : false,
            'tFilterMerCode'    => (!empty($this->input->post('oetSMTSALFilterMerCode')))? $this->input->post('oetSMTSALFilterMerCode') : "",
            'tFilterMerName'    => (!empty($this->input->post('oetSMTSALFilterMerName')))? $this->input->post('oetSMTSALFilterMerName') : "",
            // Shop Filter
            'bFilterShpStaAll'  => (!empty($this->input->post('oetSMTSALFilterShpStaAll')) && ($this->input->post('oetSMTSALFilterShpStaAll') == 1))? true : false,
            'tFilterShpCode'    => (!empty($this->input->post('oetSMTSALFilterShpCode')))? $this->input->post('oetSMTSALFilterShpCode') : "",
            'tFilterShpName'    => (!empty($this->input->post('oetSMTSALFilterShpName')))? $this->input->post('oetSMTSALFilterShpName') : "",
            // Pos Filter
            'bFilterPosStaAll'  => (!empty($this->input->post('oetSMTSALFilterPosStaAll')) && ($this->input->post('oetSMTSALFilterPosStaAll') == 1))? true : false,
            'tFilterPosCode'    => (!empty($this->input->post('oetSMTSALFilterPosCode')))? $this->input->post('oetSMTSALFilterPosCode') : "",
            'tFilterPosName'    => (!empty($this->input->post('oetSMTSALFilterPosName')))? $this->input->post('oetSMTSALFilterPosName') : "",
            // Warehouse Filter
            'bFilterWahStaAll'  => (!empty($this->input->post('oetSMTSALFilterWahStaAll')) && ($this->input->post('oetSMTSALFilterWahStaAll') == 1))? true : false,
            'tFilterWahCode'    => (!empty($this->input->post('oetSMTSALFilterWahCode')))? $this->input->post('oetSMTSALFilterWahCode') : "",
            'tFilterWahName'    => (!empty($this->input->post('oetSMTSALFilterWahName')))? $this->input->post('oetSMTSALFilterWahName') : "",
            // Product Filter
            'bFilterPdtStaAll'  => (!empty($this->input->post('oetSMTSALFilterPdtStaAll')) && ($this->input->post('oetSMTSALFilterPdtStaAll') == 1))? true : false,
            'tFilterPdtCode'    => (!empty($this->input->post('oetSMTSALFilterPdtCode')))? $this->input->post('oetSMTSALFilterPdtCode') : "",
            'tFilterPdtName'    => (!empty($this->input->post('oetSMTSALFilterPdtName')))? $this->input->post('oetSMTSALFilterPdtName') : "",
            // Recive Filter
            'bFilterRcvStaAll'  => (!empty($this->input->post('oetSMTSALFilterRcvStaAll')) && ($this->input->post('oetSMTSALFilterRcvStaAll') == 1))? true : false,
            'tFilterRcvCode'    => (!empty($this->input->post('oetSMTSALFilterRcvCode')))? $this->input->post('oetSMTSALFilterRcvCode') : "",
            'tFilterRcvName'    => (!empty($this->input->post('oetSMTSALFilterRcvName')))? $this->input->post('oetSMTSALFilterRcvName') : "",
            // Product Group Filter
            'bFilterPgpStaAll'  => (!empty($this->input->post('oetSMTSALFilterPgpStaAll')) && ($this->input->post('oetSMTSALFilterPgpStaAll') == 1))? true : false,
            'tFilterPgpCode'    => (!empty($this->input->post('oetSMTSALFilterPgpCode')))? $this->input->post('oetSMTSALFilterPgpCode') : "",
            'tFilterPgpName'    => (!empty($this->input->post('oetSMTSALFilterPgpName')))? $this->input->post('oetSMTSALFilterPgpName') : "",
            // Product Type Filter
            'bFilterPtyStaAll'  => (!empty($this->input->post('oetSMTSALFilterPtyStaAll')) && ($this->input->post('oetSMTSALFilterPtyStaAll') == 1))? true : false,
            'tFilterPtyCode'    => (!empty($this->input->post('oetSMTSALFilterPtyCode')))? $this->input->post('oetSMTSALFilterPtyCode') : "",
            'tFilterPtyName'    => (!empty($this->input->post('oetSMTSALFilterPtyName')))? $this->input->post('oetSMTSALFilterPtyName') : "",
            // Top Limit Select
            'tFilterTopLimit'   => (!empty($this->input->post('ocmSMTSALFilterTopLimit')))? $this->input->post('ocmSMTSALFilterTopLimit')   : 5,
            // Status Customer
            'tFilterStaCst'     => (!empty($this->input->post('orbSMTSALStaCst')))? $this->input->post('orbSMTSALStaCst')   : '',
            // Status Payment
            'tFilterStaPayment' => (!empty($this->input->post('orbSMTSALStaPayment')))? $this->input->post('orbSMTSALStaPayment')   : '',
            // App Type
            'aStaAppType'       => (!empty($this->input->post('ocbSMTSALAppType')))? $this->input->post('ocbSMTSALAppType') : explode(",",'1,2,3')
        ];
    }
 
    // Functionality: Index DashBoard
    // Parameters: Ajax and Function Parameter
    // Creator: 14/01/2020 wasin(Yoshi)
    // Return: None
    // ReturnType: none
    public function index(){

        $this->load->view('tool/tool/wAdaTool');
    }

    // Functionality : ฟังก์ชั่น ดึงข้อมูลจากฐานข้อมูล เมื่อแรกเข้าสู่หน้า
    // Parameters : Ajax and Function Parameter
    // Creator : 14/01/2019 wasin
    // Return : String View
    // Return Type : View
    public function FSvCATLSALMainPage(){
    
        $aDataConfigView    =  [
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave(),
            'aTextLang'         => $this->aTextLang,
        ];

        $this->load->view('tool/tool/wAdaToolMain',$aDataConfigView);
    }



    public function FSvCATLCallSaleDataTable(){

        $nPage          = ($this->input->post('nPageCurrent') == '' || null) ? 1 : $this->input->post('nPageCurrent');   // Check Number Page

        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
        );

        $aListData = array(
            'aTotalSaleByBranchData' => $this->Adatools_model->FSaMATLGetDataSalFalseStock($aData),
            'nPage'         => $nPage,
            'tSort' => $this->input->post('oetDSHSALSort'),
            'tfild' => $this->input->post('oetDSHSALFild'),
        );

        $this->load->view('tool/tool/panel/wAdaToolPanelSaleData',$aListData);

    }


    // Functionality : ฟังก์ชั่น Call View Modal Filter
    // Parameters : Ajax and Function Parameter
    // Creator : 14/01/2019 wasin
    // Return : String View
    // Return Type : View
    public function FSvCATLSALCallModalFilter(){
        $aDataConfigView    = [
            'tFilterDataKey'    => $this->input->post('ptFilterDataKey'),
            'aFilterDataGrp'    => explode(",",$this->input->post('ptFilterDataGrp')),
            'aTextLang'         =>$this->aTextLang
        ];
        $this->load->view('tool/tool/viewmodal/wAdaToolModalFilter',$aDataConfigView);
    }




    // Functionality : ฟังก์ชั่น Call View Modal Filter
    // Parameters : Ajax and Function Parameter
    // Creator : 14/01/2019 wasin
    // Return : String View
    // Return Type : View
    public function FSvCATLSALConfirmFilter(){
        // Switch Case ประเภท Dash Board
        $tDSHSALTypeKey = $this->aDataWhere['tDSHSALTypeKey'];
        switch($tDSHSALTypeKey){
            case 'FBA' : {
                // DashBoard Filter จำนวนบิลขาย
                $tFilesCountBillAll = APPPATH."modules\sale\assets\sysdshtemp\\".$this->tSesUserCode."\\db_countbillall_tmp.txt";
                $aDataCountBillAll  = $this->mDashBoardSale->FSaNDSHSALCountBillAll($this->aDataWhere);
                $oFileCountBillAll  = fopen($tFilesCountBillAll,'w');
                rewind($oFileCountBillAll);
                fwrite($oFileCountBillAll,json_encode($aDataCountBillAll));
                fclose($oFileCountBillAll);
                break;
            }
            case 'FTS' : {
                // DashBoard Filter ยอดขายรวม
                $tFileTotalSaleAll  = APPPATH."modules\sale\assets\sysdshtemp\\".$this->tSesUserCode."\\db_totalsaleall_tmp.txt";
                $aDataTotalSaleAll  = $this->mDashBoardSale->FSaNDSHSALCountTotalSaleAll($this->aDataWhere);
                $oFileTotalSaleAll  = fopen($tFileTotalSaleAll,'w');
                rewind($oFileTotalSaleAll);
                fwrite($oFileTotalSaleAll, json_encode($aDataTotalSaleAll));
                fclose($oFileTotalSaleAll);
                break;
            }
    
        }
        $aDataReturn    = [
            'rtDSHSALTypeKey'   => $tDSHSALTypeKey,
            'rtCode'            => '1',
            'rtDesc'            => 'success',
        ];
        echo json_encode($aDataReturn);
    }


    // Functionality : ฟังก์ชั่น MQ Request Sale Data
    // Parameters : Ajax and Function Parameter
    // Creator : 20/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSvCATLCallMqForRepairStk(){
        try{
            $nListAll = $this->input->post('nListAll');
            $oListItem = $this->input->post('oListItem');
            
            // echo '<pre>';
            // print_r($this->input->post());
            // die();
        if($nListAll==2){
            if(!empty($oListItem)){

                foreach($oListItem as $nKey => $aData){
                    $aMQParams = [
                        "queueName" => "SALEPOS",
                        "params"    => [
                            "pnXihDocType"  => 1,
                            "ptBchCode"     => $aData['tBchCode'],
                            "ptPosCode"     => $aData['tPosCode'],
                            "ptXihDocNo"    => $aData['tDocNo'],
                        ]
                    ];
                    $this->FSxCATLRabbitMQRequest($aMQParams);
                }

                        $aReturn = array(
                            'nStaEvent'    => '1',
                            'tStaMessg'    => 'ok'
                        );

            }else{
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => language('tool/tool/tool', 'tToolMassageError')
                );
            }
        }else{
           $tAdaToolSQLQuery = $this->session->userdata('tAdaToolSQLQuery');
           $oQuery = $this->db->query($tAdaToolSQLQuery);
           if($oQuery->num_rows() > 0) {
              $aList = $oQuery->result_array();
              foreach($aList as $nKey => $aData){
                  if($aData['FTXshStaPrcStk']!='1'){
                        $aMQParams = [
                            "queueName" => "SALEPOS",
                            "params"    => [
                                "pnXihDocType"  => 1,
                                "ptBchCode"     => $aData['FTBchCode'],
                                "ptPosCode"     => $aData['FTPosCode'],
                                "ptXihDocNo"    => $aData['FTXshDocNo'],
                            ]
                        ];
                        $this->FSxCATLRabbitMQRequest($aMQParams);
                }
            }
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg'    => 'ok'
            );
           }else{
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => language('tool/tool/tool', 'tToolMassageError')
            );
           }
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



    public function FSxCATLRabbitMQRequest($paParams){

    $tQueueName = $paParams['queueName'];
    $aParams = $paParams['params'];
    // $aParams['ptConnStr'] = DB_CONNECT;
    $aParams['ptConnStr'] = 'Data Source='.DATABASE_IP.';Initial Catalog='.BASE_DATABASE.';User ID='.DATABASE_USERNAME.';Password='.DATABASE_PASSWORD.';Connection Timeout=30;Connection Lifetime=0;Min Pool Size=30;Max Pool Size=100;Pooling=true;';
    $tExchange = '';

    $oConnection = new AMQPStreamConnection(MQ_Sale_HOST, MQ_Sale_PORT, MQ_Sale_USER, MQ_Sale_PASS, MQ_Sale_VHOST);
    $oChannel = $oConnection->channel();
    $oChannel->queue_declare($tQueueName, false, false, false, false);
    $oMessage = new AMQPMessage(json_encode($aParams));
    $oChannel->basic_publish($oMessage, "", $tQueueName);
    $oChannel->close();
    $oConnection->close();
        return 1; /** Success */
    }



    function FSxCATLRabbitMQDeclareQName($paParams){

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




    // Functionality : ฟังก์ชั่น MQ Request Api Data
    // Parameters : Ajax and Function Parameter
    // Creator : 20/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSvCATLCallMQRequestApiData(){

      $tBchCode = $this->input->post('ptBchCode');
      $tUrlType = $this->input->post('ptUrlType');
      $tAddress = $this->input->post('ptAddress');

        try{
       
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg'    => 'ok'
            );
            echo json_encode($aReturn);
        }catch(Exception $Error){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => 'Error'
            );
            echo json_encode($aReturn);
            return;
        }
       
    }




    // Functionality : ฟังก์ชั่น Check Online API
    // Parameters : Ajax and Function Parameter
    // Creator : 24/04/2020 Nale
    // Return : array
    // Return Type : array
    public function FSaCATLRequestAPIIsOnLine(){

         $tUrlRequest = $this->input->post('ptUrlRequest');
         $tUri = $tUrlRequest."/CheckOnline/IsOnline";
         $oResponse = \Httpful\Request::get($tUri)->send();

         echo $oResponse;

    }

}