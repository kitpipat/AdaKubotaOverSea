<?php 
defined('BASEPATH') or exit('No direct script access allowed');
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
class cSaleMonitor extends MX_Controller {

    /**
     * ภาษาที่เกี่ยวข้อง
     * @var array
    */
    public $aTextLang   = [];

    /**
     * Role User
     * @var array
    */
    public $aAlwEvent   = [];

    /**
     * Option Decimal Show
     * @var int
    */
    public $nOptDecimalShow = 0;

    /**
     * Option Decimal Save
     * @var int
    */
    public $nOptDecimalSave = 0;

    /**
     * Status Select Lang In DB
     * @var int
    */
    public $nLangEdit   = 1;

    /**
     * Text Html Button Save
     * @var string
    */
    public $tSesUserCode    = '';

    /**
     * Text Html Button Save
     * @var string
    */
    public $tSesUserName    = '';

    /**
     * Text Html Button Save
     * @var array
    */
    public $aDataWhere  = [];

    public function __construct() {
        $this->load->model('company/branch/mBranch');
        $this->FSxCInitParams();
        $this->load->model('sale/salemonitor/mSaleMonitor');
        if(!is_dir('./application/modules/sale/assets/koolreport')){
            mkdir('./application/modules/sale/assets/koolreport');
        }
        // เช็ค Folder Systemtemp
        if(!is_dir('./application/modules/sale/assets/sysdshtemp')){
            mkdir('./application/modules/sale/assets/sysdshtemp');
        }
        include('httpful.phar');
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
        $this->aAlwEvent        = FCNaHCheckAlwFunc('salemonitor/0/0');
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
    public function index($nSMTSALBrowseType,$tSMTSALBrowseOption){
        $aDataConfigView    = [
            'nSMTSALBrowseType'     => $nSMTSALBrowseType,
            'tSMTSALBrowseOption'   => $tSMTSALBrowseOption,
            'aAlwEvent'             => $this->aAlwEvent,
            'aTextLang'             => $this->aTextLang
        ];
        // $tQGetPepairing = "AR_GetPepairing".$this->session->userdata('tSesSessionID');
        // $aMQParamsDeclare = [
        //     "exchangeName" => "AR_XSaleMonitorRealTime",
        //     "prefixQueueName" => $tQGetPepairing,
        //     "params"    => [
        //     ]
        // ];
        // $this->FSxCSMTRabbitMQDeclareQName($aMQParamsDeclare);

        $this->load->view('sale/salemonitor/wSaleMonitor',$aDataConfigView);
    }

    // Functionality : ฟังก์ชั่น ดึงข้อมูลจากฐานข้อมูล เมื่อแรกเข้าสู่หน้า
    // Parameters : Ajax and Function Parameter
    // Creator : 14/01/2019 wasin
    // Return : String View
    // Return Type : View
    public function FSvCSMTSALMainPage(){
    
        $aDataConfigView    =  [
            'nOptDecimalShow'   => $this->nOptDecimalShow,
            'nOptDecimalSave'   => $this->nOptDecimalSave,
            'aAlwEvent'         => $this->aAlwEvent,
            'aTextLang'         => $this->aTextLang,
        ];

        $this->load->view('sale/salemonitor/wSaleMonitorMain',$aDataConfigView);
    }



    public function FSvCSMTCallSaleDataTable(){

        $nPage          = ($this->input->post('nPageCurrent') == '' || null) ? 1 : $this->input->post('nPageCurrent');   // Check Number Page

        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
        );


        $aTextLangTotalByBranch   = array(
            'tDSHSALModalBranch'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalBranch'),
            'tDSHSALModalPos'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalPos'),
            'tDSHSALType'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALType'),
            'tDSHSALFromBill'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALFromBill'),
            'tDSHSALToBill'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALToBill'),
            'tDSHSALQtyBill'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALQtyBill'),
            'tDSHSALValue'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALValue'),
            'tDSHSALCheckOut'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALCheckOut'),
            'tDSHSALSale'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALSale'),
            'tDSHSALReturn'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALReturn'),
            'tDSHSALDiff'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALDiff'),
            'tDSHSALDateTBB'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALDateTBB'),
            'tDSHSALSalesCycle'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALSalesCycle'),
            'tSMTSign-in'   => language('sale/salemonitor/salemonitor', 'tSMTSign-in'),
            'tSMTSign-out'   => language('sale/salemonitor/salemonitor', 'tSMTSign-out'),

        );

        $aListData = array(
            'aTotalSaleByBranchData' => $this->mSaleMonitor->FSaMSMTSALTotalSaleByBranch($aData),
            'aTextLangTotalByBranchShow' => $aTextLangTotalByBranch,
            'nPage'         => $nPage,
            'tSort' => $this->input->post('oetDSHSALSort'),
            'tfild' => $this->input->post('oetDSHSALFild'),
        );

        $this->load->view('sale/salemonitor/panel/wSaleMonitorPanelSaleData',$aListData);

    }

    // Functionality : ฟังก์ชั่น Call View Modal Filter
    // Parameters : Ajax and Function Parameter
    // Creator : 15/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSvCSMTCallApiDataTable(){

        $aDataWhere = $this->aDataWhere;

        $nPage      = $this->input->post('nPageCurrent');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}

        $nLangEdit      = $this->session->userdata("tLangEdit");
 
        $aData  = array(
            'FTBchCode'		=> $this->session->userdata("tSesUsrBchCodeOld"),
            'nPage'         => $nPage,
            'nRow'          => 99999,
            'FNLngID'       => $nLangEdit,
            'tFilterBchCode'  => $aDataWhere['tFilterBchCode'],
        
        );

        $aUrlObject = $this->mSaleMonitor->FSaMSMTCallObjectData($aData);

        // echo '<pre>';
        //     print_r($aUrlObject);
        // echo '</pre>';

            $aUrlObjectDataResult=array();
            if(!empty($aUrlObject['raItems'])){
                    foreach($aUrlObject['raItems'] AS $aData){
                        $rtServiceName = $this->FStSMTCallUrlTypeName($aData['FNUrlType']);
                        if($aData['FNUrlType']!=3){
                             @$aUrlObjectDataResult['API'][] = array(
                                 'rnID' => $aData['FNUrlID'],
                                 'rtBchCode' => $aData['rtBchCode'],
                                 'rtBchName' => $aData['rtBchName'],
                                 'rtUrlType' => $aData['FNUrlType'],
                                 'rtServiceName' => $rtServiceName,
                                 'rtAddress' => $aData['FTUrlAddress'],
                                 'rtPort'  => $aData['FTUrlPort'],
                                 'tServerName' => '',
                                 'tDataBase' => '',
                                 'tStatusServer' => '<i class="fa fa-circle" style="color:green"></i> <b>Online</b>'
                             );

                        }else{
                            @$aUrlObjectDataResult['MQ-Process'][] = array(
                                'rnID' => $aData['FNUrlID'],
                                'rtBchCode' => $aData['rtBchCode'],
                                'rtBchName' => $aData['rtBchName'],
                                'rtUrlType' => $aData['FNUrlType'],
                                'rtServiceName' => $rtServiceName,
                                'rtAddress' => $aData['FTUrlAddress'],
                                'rtPort'  => $aData['FTUrlPort'],
                                'tConApi' => '',
                                'tServerName' => '',
                                'tDataBase' => '',
                                'tStatusServer' => '<i class="fa fa-circle" style="color:green"></i> <b>Online</b>'
                            );
                        }
                    
                    }
            }

        //     echo '<pre>';
        //     print_r($aUrlObjectDataResult);
        // echo '</pre>';

        $aDataConfigView    = [
            'tFilterDataKey'    => $this->input->post('ptFilterDataKey'),
            'aFilterDataGrp'    => explode(",",$this->input->post('ptFilterDataGrp')),
            'aTextLang'         => $this->aTextLang,
            'aUrlObjectDataResult' => $aUrlObjectDataResult,
            'aUrlObject'       => $aUrlObject,
            'nPage'    		    => $nPage,
        ];

        $this->load->view('sale/salemonitor/panel/wSaleMonitorPanelApiData',$aDataConfigView);

    }

    // Functionality : ฟังก์ชั่น Call View Modal Filter
    // Parameters : Ajax and Function Parameter
    // Creator : 15/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FStSMTCallUrlTypeName($pnUrlType){
        $aUrlType = array(
                1 => 'URL',
                2 => 'URL + Authorized',
                3 => 'URL + MQ',
                4 => 'API2PSMaster',
                5 => 'API2PSSale',
                6 => 'API2RTMaster',
                7 => 'API2RTSale',
                8 => 'API2FNWallet',
                12 => 'API2ARDoc',
                13 => 'MQMember',
        );
        return $aUrlType[$pnUrlType];
    }
    // Functionality : ฟังก์ชั่น Call View Modal Filter
    // Parameters : Ajax and Function Parameter
    // Creator : 14/01/2019 wasin
    // Return : String View
    // Return Type : View
    public function FSvCSMTSALCallModalFilter(){
        $aDataConfigView    = [
            'tFilterDataKey'    => $this->input->post('ptFilterDataKey'),
            'aFilterDataGrp'    => explode(",",$this->input->post('ptFilterDataGrp')),
            'aTextLang'         => $this->aTextLang
        ];
        $this->load->view('sale/salemonitor/viewmodal/wSaleMonitorModalFilter',$aDataConfigView);
    }




    
    // Functionality : ฟังก์ชั่น Call View Modal Filter
    // Parameters : Ajax and Function Parameter
    // Creator : 14/01/2019 wasin
    // Return : String View
    // Return Type : View
    public function FSvCSMTSALConfirmFilter(){
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
    public function FSvCSMTCallMQRequestSaleData(){

        $tBchCode = $this->input->post('ptBchCode');
        $tPosCode = $this->input->post('ptPosCode');
        $tShiftCode = $this->input->post('ptShiftCode');
        $ptDateRequest = $this->input->post('ptDateRequest');
        $pnType = $this->input->post('pnType');
        $tQGetPepairing = "AR_GetPepairing".$this->session->userdata('tSesSessionID');

        try{
            $aMQParams = [
                "exchangeName" => "AR_XPepairingSale",
                "queueName" => "",
                "params"    => [
                    "ptBchCode"     => $tBchCode,
                    "ptPosCode"     => $tPosCode,
                    "ptShiftCode"   => $tShiftCode,
                    'ptDateRequest' => $ptDateRequest,
                    "pnType"        => $pnType,
                    "ptQGetPepairing" => $tQGetPepairing,
                    "ptUser"        => $this->session->userdata('tSesUsername')
                ]
            ];
 
            $this->FSxCSMTRabbitMQRequest($aMQParams);

            
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



    public function FSxCSMTRabbitMQRequest($paParams){

    $tQueueName = $paParams['queueName'];
    $aParams = $paParams['params'];
    $aParams['ptConnStr'] = DB_CONNECT;
    $tExchange = $paParams['exchangeName'];
    
    $oConnection = new AMQPStreamConnection(MQ_Sale_HOST, MQ_Sale_PORT, MQ_Sale_USER, MQ_Sale_PASS, MQ_Sale_VHOST);
    $oChannel = $oConnection->channel();
    $oChannel->queue_declare($tQueueName, false, false, false, false);
    $oChannel->exchange_declare($tExchange, 'direct', false, false, false);
    $oChannel->queue_bind($tQueueName, $tExchange);
    $oMessage = new AMQPMessage(json_encode($aParams));

    $tRouting = '';
    if(!empty($aParams['ptBchCode'])){
        $tRouting .= $aParams['ptBchCode'];   
    }
    if(!empty($aParams['ptPosCode'])){
        $tRouting .= $aParams['ptPosCode'];   
    }
    $oChannel->basic_publish($oMessage, $tExchange,$tRouting);

    $oChannel->close();
    $oConnection->close();
        return 1; /** Success */
    }



    function FSxCSMTRabbitMQDeclareQName($paParams){

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
    public function FSvCSMTCallMQRequestApiData(){

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
    public function FSaCSMTRequestAPIIsOnLine(){

         $tUrlRequest = $this->input->post('ptUrlRequest');
         $tUri = $tUrlRequest."/CheckOnline/IsOnline";
         $oResponse = \Httpful\Request::get($tUri)->send();

         echo $oResponse;

    }

}