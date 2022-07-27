<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

class Rptcardprinciple_controller extends MX_Controller {
    /**
     * ภาษา
     * @var array
     */
    public $aText = [];

    /**
     * จำนวนต่อหน้าในรายงาน
     * @var int 
     */
    public $nPerPage = 100;

    /**
     * Page number
     * @var int
     */
    public $nPage = 1;

    /**
     * จำนวนทศนิยม
     * @var int
     */
    public $nOptDecimalShow = 2;

    /**
     * จำนวนข้อมูลใน Temp
     * @var int
     */
    public $nRows = 0;

    /**
     * Computer Name
     * @var string
     */
    public $tCompName;

    /**
     * User Login on Bch
     * @var string
     */
    public $tBchCodeLogin;

    /**
     * Report Code
     * @var string
     */
    public $tRptCode;

    /**
     * Report Group
     * @var string
     */
    public $tRptGroup;

    /**
     * System Language
     * @var int
     */
    public $nLngID;

    /**
     * User Session ID
     * @var string
     */
    public $tUserSessionID;

    /**
     * Report route
     * @var string
     */
    public $tRptRoute;

    /**
     * Report Export Type
     * @var string
     */
    public $tRptExportType;

    /**
     * Filter for Report
     * @var array 
     */
    public $aRptFilter = [];

    /**
     * Company Info
     * @var array
     */
    public $aCompanyInfo = [];

    /**
     * User Login Session
     * @var string 
     */
    public $tUserLoginCode;

    /**
     * Sys Bch Code
     * @var string 
     */
    public $tSysBchCode;

    public function __construct() {
        $this->load->model('report/report/Report_model');
        $this->load->model('company/company/Company_model');
        $this->load->model('report/reportcard/Rptcardprinciple_model');

        // Init Report
        $this->init();

        parent::__construct();
    }

    private function init() {
        $this->aText = [
            
            'tTitleReport'              => language('report/report/report','tRPCTitleRptCardPrinciple'),
            'tRptTaxNo'                 => language('report/report/report', 'tRptTaxNo'),
            'tRptDatePrint'             => language('report/report/report', 'tRptDatePrint'),
            'tRptDateExport'            => language('report/report/report', 'tRptDateExport'),
            'tRptTimePrint'             => language('report/report/report', 'tRptTimePrint'),
            'tRptPrintHtml'             => language('report/report/report', 'tRptPrintHtml'),
            'tRptBranch'                => language('report/report/report', 'tRptAddrBranch'),
            'tRptFaxNo'                 => language('report/report/report', 'tRptAddrFax'),
            'tRptTel'                   => language('report/report/report', 'tRptAddrTel'),

            /** Filter */
            'tRPCYearFrom'              => language('report/report/report','tRPCYearFrom'),
            'tRPCYearTo'                => language('report/report/report','tRPCYearTo'),
            'tRPCCrdTypeFrom'           => language('report/report/report','tRPCCrdTypeFrom'),
            'tRPCCrdTypeTo'             => language('report/report/report','tRPCCrdTypeTo'),

            /** Table Report */
            'tRPC10TBCardTxnYear'       => language('report/report/report','tRPC10TBCardTxnYear'),
            'tRPC10TBCardTypeName'      => language('report/report/report','tRPC10TBCardTypeName'),
            'tRPC10TBCardTxnCountCard'  => language('report/report/report','tRPC10TBCardTxnCountCard'),
            'tRPC10TBCardValue'         => language('report/report/report','tRPC10TBCardValue'),
            'tRptConditionInReport' => language('report/report/report', 'tRptConditionInReport'),
            'tRPCTBFooterSumAll'        => language('report/report/report','tRPCTBFooterSumAll')

        ];

        $this->tSysBchCode     = SYS_BCH_CODE;
        $this->tBchCodeLogin   = (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'));
        $this->nPerPage        = 100;
        $this->nOptDecimalShow = FCNxHGetOptionDecimalShow();
        
        $tIP             = $this->input->ip_address();
        $tFullHost       = gethostbyaddr($tIP);
        $this->tCompName = $tFullHost;
        
        $this->nLngID         = FCNaHGetLangEdit();
        $this->tRptCode       = $this->input->post('ohdRptCode');
        $this->tRptGroup      = $this->input->post('ohdRptGrpCode');
        $this->tUserSessionID = $this->session->userdata('tSesSessionID');
        $this->tRptRoute      = $this->input->post('ohdRptRoute');
        $this->tRptExportType = $this->input->post('ohdRptTypeExport');
        $this->nPage          = empty($this->input->post('ohdRptCurrentPage')) ? 1 : $this->input->post('ohdRptCurrentPage');
        $this->tUserLoginCode = $this->session->userdata('tSesUsername');

        // Report Filter
        $this->aRptFilter = [
            'tUserSession'        => $this->tUserSessionID,
            'tCompName'           => $this->tCompName,
            'tRptCode'            => $this->tRptCode,
            'nLangID'             => $this->nLngID,
            
            // ปี
            'tRptYearCode'        => !empty($this->input->post('oetRptYearFrom')) ? $this->input->post('oetRptYearFrom') : '',
            'tRptYearCodeTo'      => !empty($this->input->post('oetRptYearTo')) ? $this->input->post('oetRptYearTo') : '',

            // ประเภทบัตร
            'tRptCardTypeCode'    => !empty($this->input->post('oetRptCardTypeCodeFrom')) ? $this->input->post('oetRptCardTypeCodeFrom') : '',
            'tRptCardTypeName'    => !empty($this->input->post('oetRptCardTypeNameFrom')) ? $this->input->post('oetRptCardTypeNameFrom') : '',
            'tRptCardTypeCodeTo'  => !empty($this->input->post('oetRptCardTypeCodeTo')) ? $this->input->post('oetRptCardTypeCodeTo') : '',
            'tRptCardTypeNameTo'  => !empty($this->input->post('oetRptCardTypeNameTo')) ? $this->input->post('oetRptCardTypeNameTo') : '',
            
            
        ];
  
        // ดึงข้อมูลบริษัทฯ
        $aCompInfoParams   = [
            'nLngID'    => $this->nLngID,
            'tBchCode'  => $this->tBchCodeLogin
        ];
        $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
    }

    public function index() {

        if (!empty($this->tRptExportType) && !empty($this->tRptCode)) {

            // Execute Stored Procedure
            $this->Rptcardprinciple_model->FSnMExecStoreReport($this->aRptFilter);
         
            $aDataSwitchCase = array(
                'ptRptRoute'      => $this->tRptRoute,
                'ptRptCode'       => $this->tRptCode,
                'ptRptTypeExport' => $this->tRptExportType,
                'paDataFilter'    => $this->aRptFilter
            );
      
            switch ($this->tRptExportType) {
                case 'html':
                    $this->FSvCCallRptViewBeforePrint($aDataSwitchCase);
                    break;
                case 'excel':
                    $this->FSoCChkDataReportInTableTemp($aDataSwitchCase);
                    break;
                case 'pdf':
                    $this->FSvCCallRptRenderExcel($aDataSwitchCase);
                    break;    
            }
        }
    }

     /**
     * Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 10/10/2019 Piya
     * LastUpdate: 5/11/2019 Saharat(GolF)
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrint($paDataSwitchCase) {
        $aDataWhere = array(
            'tUserSession' => $this->tUserSessionID,
            'tUserCode'    => $this->tUserLoginCode,
            'tCompName'    => $this->tCompName,
            'tRptCode'     => $this->tRptCode,
            'nPage'        => 1, // เริ่มทำงานหน้าแรก
            'nRow'         => $this->nPerPage,

            // 'tCompName'    => 'ADA-DEV',
            // 'tRptCode'     => '004001015',
        );
   
        // Get Data Report
        $aDataReport = $this->Rptcardprinciple_model->FSaMGetDataReport($aDataWhere, $this->aRptFilter);

        // Call View Report
        $tViewRenderKool = $this->FCNvCRenderKoolReportHtml($aDataReport, $this->aRptFilter);

        $aDataView = array(
            'aCompanyInfo'    => $this->aCompanyInfo,
            'tTitleReport'    => $this->aText['tTitleReport'],
            'tRptTypeExport'  => $this->tRptExportType,
            'tRptCode'        => $this->tRptCode,
            'tRptRoute'       => $this->tRptRoute,
            'tViewRenderKool' => $tViewRenderKool,
            'aDataFilter'     => $this->aRptFilter,
            'aDataReport'     => $aDataReport
        );
        $this->load->view('report/report/wReportViewer', $aDataView);
    }

    /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 10/10/2019 Piya
     * LastUpdate: 5/11/2019 Saharat(GolF)
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrintClickPage() {

        /*===== Begin Init Variable ====================================================*/
        $aDataFilter = json_decode($this->input->post('ohdRptDataFilter'), true);
        /*===== End Init Variable ======================================================*/
        
        $aDataWhere = array(
            'tUserSession' => $this->tUserSessionID,
            'tUserCode'    => $this->tUserLoginCode,
            'tCompName'    => $this->tCompName,
            'tRptCode'     => $this->tRptCode,
            'nPage'        => $this->nPage,
            'nRow'         => $this->nPerPage,

            // 'tCompName'    => 'ADA-DEV',
            // 'tRptCode'     => '004001015',
        );
        $aDataReport = $this->Rptcardprinciple_model->FSaMGetDataReport($aDataWhere, $aDataFilter);

        if (!empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == 1) {
            $tViewRenderKool = $this->FCNvCRenderKoolReportHtml($aDataReport, $aDataFilter);
        } else {
            $tViewRenderKool = "";
        }

        $aDataView = array(
            'tTitleReport'      => $this->aText['tTitleReport'],
            'tRptTypeExport'    => $this->tRptExportType,
            'tRptCode'          => $this->tRptCode,
            'tRptRoute'         => $this->tRptRoute,
            'tViewRenderKool'   => $tViewRenderKool,
            'aDataFilter'       => $aDataFilter,
            'aDataReport'       => $aDataReport
        );
        $this->load->view('report/report/wReportViewer', $aDataView);
    }

     /**
     * Functionality: Call Rpt Table Kool Report
     * Parameters:  Function Parameter
     * Creator: 29/10/2019 saharat(GolF)
     * LastUpdate: -
     * Return: View Kool Report
     * ReturnType: View
     */
    public function FCNvCRenderKoolReportHtml($paDataReport, $paDataFilter) {

        $aDataWhere = array(
            'tUserSession' => $this->tUserSessionID,
            'tUserCode'    => $this->tUserLoginCode,
            'tCompName'    => $this->tCompName,
            'tRptCode'     => $this->tRptCode,
            'nPage'        => $this->nPage,
            'nRow'         => $this->nPerPage,

            // 'tCompName'    => 'ADA-DEV',
            // 'tRptCode'     => '004001015',
        );
        $aDataReport = $this->Rptcardprinciple_model->FSaMGetDataReport($aDataWhere, $this->aRptFilter);

        if(@$aDataReport['rnCurrentPage'] == @$aDataReport['rnAllPage']){ 
            // เรียก Summary เฉพาะหน้าสุดท้าย
            @$aSumDataReport = $this->Rptcardprinciple_model->FSaMRPTCRDGetDataRptCardPrincipleSum($aDataWhere);
        }


        // Ref File Kool Report
        require_once APPPATH . 'modules\report\datasources\reportcard\rptcardprinciple\rRptCardPrinciple.php';

        // Set Parameter To Report
            $oRptPrinciple      = new rRptCardPrinciple(array(
            'nCurrentPage'      => $paDataReport['rnCurrentPage'],
            'nAllPage'          => $paDataReport['rnAllPage'],
            'aCompanyInfo'      => $this->aCompanyInfo,
            'aFilterReport'     => $paDataFilter,
            'aDataTextRef'      => $this->aText,
            'aDataReturn'       => $paDataReport,
            'nOptDecimalShow'   => $this->nOptDecimalShow,
            'aSumDataReport'    => isset($aSumDataReport) ? $aSumDataReport : []

        ));

        $oRptPrinciple->run();
        $tHtmlViewReport = $oRptPrinciple->render('wRptCardPrincipleHtml', true);
        return $tHtmlViewReport;
    }

     /**
     * Functionality: Get Count Data in Temp
     * Parameters:  Function Parameter
     * Creator: 10/10/2019 Piya
     * LastUpdate: 30/10/2019 Saharat(GolF)
     * Return: object Status Count Data Report
     * ReturnType: Object
     */
    public function FSoCChkDataReportInTableTemp($paDataSwitchCase) {

        try {
            $aDataCountData = [
                'tCompName'    => $paDataSwitchCase['paDataFilter']['tCompName'],
                'tRptCode'     => $paDataSwitchCase['paDataFilter']['tRptCode'],
                'tUserSession' => $paDataSwitchCase['paDataFilter']['tUserSession'],
            ];

            $nDataCountPage = $this->Rptcardprinciple_model->FSaMCountDataReportAll($aDataCountData);

            $aResponse = array(
                'nCountPageAll' => $nDataCountPage,
                'nStaEvent' => 1,
                'tMessage' => 'Success Count Data All'
            );
        } catch (ErrorException $Error) {
            $aResponse = array(
                'nStaEvent' => 500,
                'tMessage' => $Error->getMessage()
            );
        }
        echo json_encode($aResponse);
    }

    /**
     * Functionality: Send Rabbit MQ Report
     * Parameters:  Function Parameter
     * Creator: 10/10/2019 Piya
     * LastUpdate: 30/10/2019 Saharat(GolF)
     * Return: object Send Rabbit MQ Report
     * ReturnType: Object
     */
    public function FSvCCallRptExportFile() {
        try {
            $tDateSendMQ = date('Y-m-d');
            $tTimeSendMQ = date('H:i:s');
            $tDateSubscribe = date('Ymd');
            $tTimeSubscribe = date('His');

            // Set Parameter Send MQ
            $tRptQueueName = 'RPT_'.$tSysBchCode . '_' . $this->tRptGroup . '_' . $this->tRptCode;

            $aDataSendMQ = [
                'tQueueName' => $tRptQueueName,
                'aParams'    => [
                    'ptRptCode'       => $this->tRptCode,
                    'pnPerFile'       => 20000,
                    'ptUserCode'      => $this->tUserLoginCode,
                    'ptUserSessionID' => $this->tUserSessionID,
                    'pnLngID'         => $this->nLngID,
                    'ptFilter'        => $this->aRptFilter,
                    'ptRptExpType'    => $this->tRptExportType,
                    'ptComName'       => $this->tCompName,
                    'ptDate'          => $tDateSendMQ,
                    'ptTime'          => $tTimeSendMQ,
                    'ptBchCode'       => $this->tBchCodeLogin
                ]
            ];

            FCNxReportCallRabbitMQ($aDataSendMQ);

            $aResponse = array(
                'nStaEvent' => 1,
                'tMessage' => 'Success Send Rabbit MQ.',
                'aDataSubscribe' => array(
                    'ptSysBchCode' => $this->tSysBchCode,
                    'ptComName'  => $this->tCompName,
                    'ptRptCode'  => $this->tRptCode,
                    'ptUserCode' => $this->tUserLoginCode,
                    'ptUserSessionID' => $this->tUserSessionID,
                    'pdDateSubscribe' => $tDateSubscribe,
                    'pdTimeSubscribe' => $tTimeSubscribe,
                )
            );
        } catch (Exception $Error) {
            $aResponse = array(
                'nStaEvent' => 500,
                'tMessage' => $Error->getMessage()
            );
        }
        echo json_encode($aResponse);
    }



    

  
}



