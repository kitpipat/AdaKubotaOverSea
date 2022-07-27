<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

class Rpttransfercardinfo_controller extends MX_Controller {

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
        $this->load->model('report/reportcard/Rpttransfercardinfo_model');

        // Init Report
        $this->init();

        parent::__construct();
    }

    private function init() {
        $this->aText = [
            'tTitleReport' => language('report/report/report', 'tRPCTitleRptTransferCardInfo'),
            'tRptTaxNo' => language('report/report/report', 'tRptTaxNo'),
            'tRptDatePrint' => language('report/report/report', 'tRptDatePrint'),
            'tRptDateExport' => language('report/report/report', 'tRptDateExport'),
            'tRptTimePrint' => language('report/report/report', 'tRptTimePrint'),
            'tRptPrintHtml' => language('report/report/report', 'tRptPrintHtml'),
            'tRptAddrBranch' => language('report/report/report', 'tRptAddrBranch'),
            'tRptAddrFax' => language('report/report/report', 'tRptAddrFax'),
            'tRptAddrTel' => language('report/report/report', 'tRptAddrTel'),
            /** Filter */
            'tRPCCrdTypeOldFrom' => language('report/report/report','tRPCCrdTypeOldFrom'),
            'tRPCCrdTypeOldTo' => language('report/report/report','tRPCCrdTypeOldTo'),
            'tRPCCrdTypeNewFrom' => language('report/report/report','tRPCCrdTypeNewFrom'),
            'tRPCCrdTypeNewTo' => language('report/report/report','tRPCCrdTypeNewTo'),
            'tRPCCrdOldFrom' => language('report/report/report','tRPCCrdOldFrom'),
            'tRPCCrdOldTo' => language('report/report/report','tRPCCrdOldTo'),
            'tRPCCrdNewFrom' => language('report/report/report','tRPCCrdNewFrom'),
            'tRPCCrdNewTo' => language('report/report/report','tRPCCrdNewTo'),
            'tRPCDateFrom' => language('report/report/report','tRPCDateFrom'),
            'tRPCDateTo' => language('report/report/report','tRPCDateTo'),
            /** Table Report */
            'tRPC3TBRowNuber' => language('report/report/report','tRPC3TBRowNuber'),
            'tRPC3TBDocDate' => language('report/report/report','tRPC3TBDocDate'),
            'tRPC3TBOldCardCode' => language('report/report/report','tRPC3TBOldCardCode'),
            'tRPC3TBOldCardType' => language('report/report/report','tRPC3TBOldCardType'),
            'tRPC3TBNewCardCode' => language('report/report/report','tRPC3TBNewCardCode'),
            'tRPC3TBNewCardType' => language('report/report/report','tRPC3TBNewCardType'),
            'tRPC3TBCardName' => language('report/report/report','tRPC3TBCardName'),
            'tRPC3TBOldCrdValue' => language('report/report/report','tRPC3TBOldCrdValue'),
            'tRPC3TBNewCrdValue' => language('report/report/report','tRPC3TBNewCrdValue'),
            'tRptConditionInReport' => language('report/report/report', 'tRptConditionInReport'),
            'tRPCOperator' => language('report/report/report','tRPCOperator')
        ];

        $this->tSysBchCode     = SYS_BCH_CODE;
        $this->tBchCodeLogin   = (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'));
        $this->nPerPage        = 100;
        $this->nOptDecimalShow = FCNxHGetOptionDecimalShow();

        $tIP = $this->input->ip_address();
        $tFullHost = gethostbyaddr($tIP);
        $this->tCompName = $tFullHost;

        $this->nLngID = FCNaHGetLangEdit();
        $this->tRptCode = $this->input->post('ohdRptCode');
        $this->tRptGroup = $this->input->post('ohdRptGrpCode');
        $this->tUserSessionID = $this->session->userdata('tSesSessionID');
        $this->tRptRoute = $this->input->post('ohdRptRoute');
        $this->tRptExportType = $this->input->post('ohdRptTypeExport');
        $this->nPage = empty($this->input->post('ohdRptCurrentPage')) ? 1 : $this->input->post('ohdRptCurrentPage');
        $this->tUserLoginCode = $this->session->userdata('tSesUsername');

        // Report Filter
        $this->aRptFilter = [
            'tUserSessionID' => $this->tUserSessionID,
            'tCompName' => $this->tCompName,
            'tRptCode' => $this->tRptCode,
            'nLngID' => $this->nLngID,

            // ประเภทบัตรเดิม
            'tCardTypeCodeOldFrom' => !empty($this->input->post('oetRptCardTypeCodeOldFrom')) ? $this->input->post('oetRptCardTypeCodeOldFrom') : '',
            'tCardTypeNameOldFrom' => !empty($this->input->post('oetRptCardTypeNameOldFrom')) ? $this->input->post('oetRptCardTypeNameOldFrom') : '',
            'tCardTypeCodeOldTo' => !empty($this->input->post('oetRptCardTypeCodeOldTo')) ? $this->input->post('oetRptCardTypeCodeOldTo') : '',
            'tCardTypeNameOldTo' => !empty($this->input->post('oetRptCardTypeNameOldTo')) ? $this->input->post('oetRptCardTypeNameOldTo') : '',
            // ประเภทบัตรใหม่
            'tCardTypeCodeNewFrom' => !empty($this->input->post('oetRptCardTypeCodeNewFrom')) ? $this->input->post('oetRptCardTypeCodeNewFrom') : '',
            'tCardTypeNameNewFrom' => !empty($this->input->post('oetRptCardTypeNameNewFrom')) ? $this->input->post('oetRptCardTypeNameNewFrom') : '',
            'tCardTypeCodeNewTo' => !empty($this->input->post('oetRptCardTypeCodeNewTo')) ? $this->input->post('oetRptCardTypeCodeNewTo') : '',
            'tCardTypeNameNewTo' => !empty($this->input->post('oetRptCardTypeNameNewTo')) ? $this->input->post('oetRptCardTypeNameNewTo') : '',
            // เลขขัตรเดิม
            'tCardCodeOldFrom' => !empty($this->input->post('oetRptCardCodeOldFrom')) ? $this->input->post('oetRptCardCodeOldFrom') : '',
            'tCardNameOldFrom' => !empty($this->input->post('oetRptCardNameOldFrom')) ? $this->input->post('oetRptCardNameOldFrom') : '',
            'tCardCodeOldTo' => !empty($this->input->post('oetRptCardCodeOldTo')) ? $this->input->post('oetRptCardCodeOldTo') : '',
            'tCardNameOldTo' => !empty($this->input->post('oetRptCardNameOldTo')) ? $this->input->post('oetRptCardNameOldTo') : '',
            // เลขขัตรใหม่
            'tCardCodeNewFrom' => !empty($this->input->post('oetRptCardCodeNewFrom')) ? $this->input->post('oetRptCardCodeNewFrom') : '',
            'tCardNameNewFrom' => !empty($this->input->post('oetRptCardNameNewFrom')) ? $this->input->post('oetRptCardNameNewFrom') : '',
            'tCardCodeNewTo' => !empty($this->input->post('oetRptCardCodeNewTo')) ? $this->input->post('oetRptCardCodeNewTo') : '',
            'tCardNameNewTo' => !empty($this->input->post('oetRptCardNameNewTo')) ? $this->input->post('oetRptCardNameNewTo') : '',
            // วันที่เอกสาร(DocNo)
            'tDocDateFrom' => !empty($this->input->post('oetRptDocDateFrom')) ? $this->input->post('oetRptDocDateFrom') : "",
            'tDocDateTo' => !empty($this->input->post('oetRptDocDateTo')) ? $this->input->post('oetRptDocDateTo') : "",
        ];

        // ดึงข้อมูลบริษัทฯ
        $aCompInfoParams = [
            'nLngID' => $this->nLngID,
            'tBchCode' => $this->tBchCodeLogin
        ];
        $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
    }

    public function index() {

        if (!empty($this->tRptExportType) && !empty($this->tRptCode)) {

            // Execute Stored Procedure
            $this->Rpttransfercardinfo_model->FSnMExecStoreReport($this->aRptFilter);

            $aDataSwitchCase = array(
                'ptRptRoute' => $this->tRptRoute,
                'ptRptCode' => $this->tRptCode,
                'ptRptTypeExport' => $this->tRptExportType,
                'paDataFilter' => $this->aRptFilter
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
     * Creator: 04/11/2019 Piya
     * LastUpdate: -
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrint($paDataSwitchCase = []) {

        $aDataWhere = array(
            'tUserSessionID' => $this->tUserSessionID,
            'tCompName' => $this->tCompName,
            'tUserCode' => $this->tUserLoginCode,
            'tRptCode' => $this->tRptCode,
            'nPage' => 1, // เริ่มทำงานหน้าแรก
            'nRow' => $this->nPerPage,
        );

        // Get Data Report
        $aDataReport = $this->Rpttransfercardinfo_model->FSaMGetDataReport($aDataWhere, $this->aRptFilter);

        // Call View Report
        $tViewRenderKool = $this->FCNvCRenderKoolReportHtml($aDataReport, $this->aRptFilter);

        $aDataView = array(
            'aCompanyInfo' => $this->aCompanyInfo,
            'tTitleReport' => $this->aText['tTitleReport'],
            'tRptTypeExport' => $this->tRptExportType,
            'tRptCode' => $this->tRptCode,
            'tRptRoute' => $this->tRptRoute,
            'tViewRenderKool' => $tViewRenderKool,
            'aDataFilter' => $this->aRptFilter,
            'aDataReport' => $aDataReport
        );
        $this->load->view('report/report/wReportViewer', $aDataView);
    }

    /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 04/11/2019 Piya
     * LastUpdate: -
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrintClickPage() {

        /*===== Begin Init Variable ====================================================*/
        $aDataFilter = json_decode($this->input->post('ohdRptDataFilter'), true);
        /*===== End Init Variable ======================================================*/

        $aDataWhere = array(
            'tUserSessionID' => $this->tUserSessionID,
            'tCompName' => $this->tCompName,
            'tUserCode' => $this->tUserLoginCode,
            'tRptCode' => $this->tRptCode,
            'nPage' => $this->nPage,
            'nRow' => $this->nPerPage,
        );
        $aDataReport = $this->Rpttransfercardinfo_model->FSaMGetDataReport($aDataWhere, $aDataFilter);

        if (!empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == 1) {
            $tViewRenderKool = $this->FCNvCRenderKoolReportHtml($aDataReport, $aDataFilter);
        } else {
            $tViewRenderKool = "";
        }

        $aDataView = array(
            'tTitleReport' => $this->aText['tTitleReport'],
            'tRptTypeExport' => $this->tRptExportType,
            'tRptCode' => $this->tRptCode,
            'tRptRoute' => $this->tRptRoute,
            'tViewRenderKool' => $tViewRenderKool,
            'aDataFilter' => $aDataFilter,
            'aDataReport' => $aDataReport
        );
        $this->load->view('report/report/wReportViewer', $aDataView);
    }

    /**
     * Functionality: Call Rpt Table Kool Report
     * Parameters:  Function Parameter
     * Creator: 04/11/2019 Piya
     * LastUpdate: -
     * Return: View Kool Report
     * ReturnType: View
     */
    public function FCNvCRenderKoolReportHtml($paDataReport = [], $paDataFilter = []) {

        // Ref File Kool Report
        require_once APPPATH . 'modules\report\datasources\reportcard\rpttransfercardinfo\rRptTransferCardInfo.php';

        // Set Parameter To Report
        $oRptKoolReportHtml = new rRptTransferCardInfo(array(
            'nCurrentPage' => $paDataReport['rnCurrentPage'],
            'nAllPage' => $paDataReport['rnAllPage'],
            'aCompanyInfo' => $this->aCompanyInfo,
            'aFilterReport' => $paDataFilter,
            'aDataTextRef' => $this->aText,
            'aDataReturn' => $paDataReport,
            'nOptDecimalShow' => $this->nOptDecimalShow
        ));

        $oRptKoolReportHtml->run();
        $tHtmlViewReport = $oRptKoolReportHtml->render('wRptTransferCardInfoHtml', true);
        return $tHtmlViewReport;
    }

    /**
     * Functionality: Get Count Data in Temp
     * Parameters:  Function Parameter
     * Creator: 04/11/2019 Piya
     * LastUpdate: -
     * Return: object Status Count Data Report
     * ReturnType: Object
     */
    public function FSoCChkDataReportInTableTemp($paDataSwitchCase = []) {

        try {
            $aDataCountData = [
                'tCompName' => $this->tCompName,
                'tRptCode' => $this->tRptCode,
                'tUserSessionID' => $this->tUserSessionID,
            ];

            $nDataCountPage = $this->Rpttransfercardinfo_model->FSaMCountDataReportAll($aDataCountData);

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
     * Creator: 04/11/2019 Piya
     * LastUpdate: -
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
            $tRptQueueName = 'RPT_' .$this->tSysBchCode . '_' . $this->tRptGroup . '_' . $this->tRptCode;

            $aDataSendMQ = [
                'tQueueName' => $tRptQueueName,
                'aParams' => [
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
                    'ptSysBchCode'    => $this->tSysBchCode,
                    'ptComName'       => $this->tCompName,
                    'ptRptCode'       => $this->tRptCode,
                    'ptUserCode'      => $this->tUserLoginCode,
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
