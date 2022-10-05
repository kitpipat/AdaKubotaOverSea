<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class arrangementproduct_controller extends MX_Controller {

    public $tRouteMenu  = 'docPAM/0/0';

    public function __construct(){
        $this->load->model('document/arrangementproduct/arrangementproduct_model');
        parent::__construct();
    }

    public function index($nPAMBrowseType, $tPAMBrowseOption){
        $aDataConfigView = array(
            'nPAMBrowseType'     => $nPAMBrowseType,
            'tPAMBrowseOption'   => $tPAMBrowseOption,
            'aAlwEvent'          => FCNaHCheckAlwFunc($this->tRouteMenu), 
            'vBtnSave'           => FCNaHBtnSaveActiveHTML($this->tRouteMenu), 
            'nOptDecimalShow'    => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'    => FCNxHGetOptionDecimalSave()
        );
        $this->load->view('document/arrangementproduct/wArrangementProduct', $aDataConfigView);
    }

    // แสดง Form Search ข้อมูลในตารางหน้า List
    public function FSvCPAMFormSearchList() {
        $aDataConfigView = array(
            'aAlwEvent'          => FCNaHCheckAlwFunc($this->tRouteMenu)
        );
        $this->load->view('document/arrangementproduct/wArrangementProductFormSearchList', $aDataConfigView);
    }

    // แสดงตารางในหน้า List
    public function FSoCPAMDataTable() {
        try {
            $aAdvanceSearch = $this->input->post('oAdvanceSearch');
            $nPage          = $this->input->post('nPageCurrent');

            // Get Option Show Decimal
            $nOptDecimalShow = FCNxHGetOptionDecimalShow();

            // Page Current
            if ($nPage == '' || $nPage == null) {
                $nPage = 1;
            } else {
                $nPage = $this->input->post('nPageCurrent');
            }
            // Lang ภาษา
            $nLangEdit = $this->session->userdata("tLangEdit");

            // Data Conditon Get Data Document
            $aDataCondition = array(
                'FNLngID'                   => $nLangEdit,
                'nPage'                     => $nPage,
                'nRow'                      => 20,
                'aAdvanceSearch'            => $aAdvanceSearch
            );
            $aDataList = $this->arrangementproduct_model->FSaMPAMGetDataTableList($aDataCondition);

            $aConfigView = array(
                'nPage'             => $nPage,
                'nOptDecimalShow'   => $nOptDecimalShow,
                'aAlwEvent'         => FCNaHCheckAlwFunc($this->tRouteMenu),
                'aDataList'         => $aDataList
            );
            $tPAMViewDataTableList = $this->load->view('document/arrangementproduct/wArrangementProductDataTable', $aConfigView, true);
            $aReturnData = array(
                'tPAMViewDataTableList' => $tPAMViewDataTableList,
                'nStaEvent'             => '1',
                'tStaMessg'             => 'Success'
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // เรียกหน้าเพิ่มข้อมูล
    public function FSoCPAMPageAdd() {
        try {
            // Clear Data Product IN Doc Temp
            $this->arrangementproduct_model->FSxMPAMClearDataInDocTemp();

            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

            // Get Option Doc Save
            $nOptDocSave        = FCNnHGetOptionDocSave();

            //อนุญาตจัดสินค้าไม่เท่ากับจำนวนสั่ง
            $aWhere = array(
                'FTUfrGrpRef'   => '068',
                'FTUfrRef'      => 'KB038'
            );
            $bAlwQtyPickNotEqQtyOrd = FCNbGetUsrFuncRpt($aWhere);

            $aDataConfigViewAdd = array(
                'nOptDecimalShow'           => $nOptDecimalShow,
                'nOptDocSave'               => $nOptDocSave,
                'aDataDocHD'                => array('rtCode' => '800'),
                'bAlwQtyPickNotEqQtyOrd'    => $bAlwQtyPickNotEqQtyOrd,
                'aAlwEvent'         => FCNaHCheckAlwFunc($this->tRouteMenu),

            );

            $tPAMViewPageAdd = $this->load->view('document/arrangementproduct/wArrangementProductPageAdd', $aDataConfigViewAdd, true);
            $aReturnData = array(
                'tPAMViewPageAdd'   => $tPAMViewPageAdd,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // ข้อมูลใน Temp
    public function FSoCPAMPdtAdvTblLoadData() {
        try {
            $tPAMDocNo           = $this->input->post('ptPAMDocNo');
            $aDataWhere = array(
                'FTXthDocNo'            => $tPAMDocNo,
                'FTXthDocKey'           => 'TCNTPdtPickDT',
                'FTSessionID'           => $this->session->userdata('tSesSessionID'),
            );
            $aDataDocDTTemp     = $this->arrangementproduct_model->FSaMPAMGetDocDTTempListPage($aDataWhere);

            $aDataView = array(
                'aDataDocDTTemp'    => $aDataDocDTTemp,
                'nOptDecimalShow'   => FCNxHGetOptionDecimalShow()
            );
            $tPAMPdtAdvTableHtml = $this->load->view('document/arrangementproduct/wArrangementProductPdtAdvTableData', $aDataView, true);
            $aReturnData = array(
                'tPAMPdtAdvTableHtml'   => $tPAMPdtAdvTableHtml,
                'nStaEvent'             => '1',
                'tStaMessg'             => "Fucntion Success Return View."
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // เพิ่มสินค้า ลง Document DT Temp
    public function FSoCPAMAddPdtIntoDocDTTemp() {
        try {
            $tPAMDocNo           = $this->input->post('tPAMDocNo');
            $tPAMOptionAddPdt    = $this->input->post('tPAMOptionAddPdt');
            $tBCHCode            = $this->input->post('tSelectBCH');
            $tPAMPdtData         = $this->input->post('tPAMPdtData');
            $aPAMPdtData         = json_decode($tPAMPdtData);

            $this->db->trans_begin();

            // ทำทีรายการ ตามรายการสินค้าที่เพิ่มเข้ามา
            for ($nI = 0; $nI < FCNnHSizeOf($aPAMPdtData); $nI++) {
                $tPAMPdtCode = $aPAMPdtData[$nI]->pnPdtCode;
                $tPAMBarCode = $aPAMPdtData[$nI]->ptBarCode;
                $tPAMPunCode = $aPAMPdtData[$nI]->ptPunCode;
                
                $aDataPdtParams = array(
                    'tDocNo'            => $tPAMDocNo,
                    'tBchCode'          => $tBCHCode,
                    'tPdtCode'          => $tPAMPdtCode,
                    'tBarCode'          => $tPAMBarCode,
                    'tPunCode'          => $tPAMPunCode,
                    'cPrice'            => 0,
                    'nMaxSeqNo'         => $this->input->post('tSeqNo'),
                    'nLngID'            => $this->session->userdata("tLangEdit"),
                    'tSessionID'        => $this->session->userdata('tSesSessionID'),
                    'tDocKey'           => 'TCNTPdtPickDT',
                    'tPAMOptionAddPdt'  => $tPAMOptionAddPdt,
                    'tPAMUsrCode'       => $this->session->userdata('tSesUsername')
                );
                // Data Master Pdt ข้อมูลรายการสินค้าที่เพิ่มเข้ามา
                $aDataPdtMaster = $this->arrangementproduct_model->FSaMPAMGetDataPdt($aDataPdtParams);
                $this->arrangementproduct_model->FSaMPAMInsertPDTToTemp($aDataPdtMaster, $aDataPdtParams);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Insert Product Error Please Contact Admin.'
                );
            } else {
                $this->db->trans_commit();
                    $aReturnData = array(
                        'nStaEvent' => '1',
                        'tStaMessg' => 'Success Add Product Into Document DT Temp.'
                    );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Edit Inline สินค้า ลง Document DT Temp
    public function FSoCPAMEditPdtIntoDocDTTemp() {
        try {
            $tPAMBchCode         = $this->input->post('tPAMBchCode');
            $tPAMDocNo           = $this->input->post('tPAMDocNo');
            $nPAMSeqNo           = $this->input->post('nPAMSeqNo');
            $tPAMType            = $this->input->post('tPAMType');
            $tPAMValue           = $this->input->post('tPAMValue');
            $cPAMFactor          = $this->input->post('cPAMFactor');
            $tPAMSessionID       = $this->session->userdata('tSesSessionID');

            $aDataWhere = array(
                'tPAMBchCode'    => $tPAMBchCode,
                'tPAMDocNo'      => $tPAMDocNo,
                'nPAMSeqNo'      => $nPAMSeqNo,
                'tPAMSessionID'  => $tPAMSessionID,
                'tDocKey'        => 'TCNTPdtPickDT',
            );

            if( $tPAMType == 'Qty' ){
                $aDataUpdateDT = array(
                    'FCXtdQty'          => floatval($tPAMValue),
                    'FCXtdQtyAll'       => floatval($tPAMValue) * floatval($cPAMFactor)
                );
            }else{
                $aDataUpdateDT = array(
                    'FTXtdRmk'          => strval($tPAMValue)
                );
            }

            $this->db->trans_begin();
            $this->arrangementproduct_model->FSaMPAMUpdateInlineDTTemp($aDataUpdateDT, $aDataWhere);

            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => "Error Update Inline Into Document DT Temp."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => "Update Inline Into Document DT Temp."
                );
            }

        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // ลบสินค้า Temp (ตัวเดียว)
    public function FSvCPAMRemovePdtInDTTmp() {
        try {
            $this->db->trans_begin();

            $aDataWhere = array(
                'tPAMDocNo'         => $this->input->post('tDocNo'),
                'tBchCode'          => $this->input->post('tBchCode'),
                'tPdtCode'          => $this->input->post('tPdtCode'),
                'nSeqNo'            => $this->input->post('nSeqNo'),
                'tDocKey'           => 'TCNTPdtPickDT',
                'tSessionID'        => $this->session->userdata('tSesSessionID'),
            );
            $this->arrangementproduct_model->FSnMPAMDelPdtInDTTmp($aDataWhere);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Cannot Delete Item.',
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success Delete Product'
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // [เอกสารอ้างอิง] ข้อมูลเอกสารอ้างอิง table
    public function FSoCPAMPageHDDocRefList(){
        try{
            $tDocNo = ( !empty($this->input->post('ptDocNo')) ? $this->input->post('ptDocNo') : '');

            $aDataWhere = [
                'tTableHDDocRef'    => 'TCNTPdtPickHDDocRef',
                'tTableTmpHDRef'    => 'TCNTDocHDRefTmp',
                'FTXthDocNo'        => $tDocNo,
                'FTXthDocKey'       => 'TCNTPdtPickHD',
                'FTSessionID'       => $this->session->userdata('tSesSessionID')
            ];

            $aDataDocHDRef = $this->arrangementproduct_model->FSaMPAMGetDataHDRefTmp($aDataWhere);
            $aDataConfig = array(
                'aDataDocHDRef' => $aDataDocHDRef
            );
            $tViewPageHDRef = $this->load->view('document/arrangementproduct/refintdocument/wArrangementProductRefDocList', $aDataConfig, true);
            $aReturnData = array(
                'tViewPageHDRef'    => $tViewPageHDRef,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // [เอกสารอ้างอิง] เลขที่เอกสารอ้างอิงมาแสดงในตาราง browse
    public function FSoCPAMCallRefIntDoc(){
        $tBCHCode   = $this->input->post('tBCHCode');
        $tBCHName   = $this->input->post('tBCHName');
        $tRefDoc   = $this->input->post('tRefDoc');
        $aDataParam = array(
            'tBCHCode'  => $tBCHCode,
            'tBCHName'  => $tBCHName,
            'tRefDoc'   => $tRefDoc
        );

        $this->load->view('document/arrangementproduct/refintdocument/wArrangementProductRefDoc', $aDataParam);
    }

    // [เอกสารอ้างอิง] เลขที่เอกสารอ้างอิงมาแสดงในตาราง browse & Search
    public function FSoCPAMCallRefIntDocDataTable(){
        $nPage                   = $this->input->post('nPAMRefIntPageCurrent');
        $tPAMRefIntBchCode       = $this->input->post('tPAMRefIntBchCode');
        $tPAMRefIntDocNo         = $this->input->post('tPAMRefIntDocNo');
        $tPAMRefIntDocDateFrm    = $this->input->post('tPAMRefIntDocDateFrm');
        $tPAMRefIntDocDateTo     = $this->input->post('tPAMRefIntDocDateTo');
        $tPAMRefIntStaDoc        = $this->input->post('tPAMRefIntStaDoc');
        $tPAMRefIntIntRefDoc     = $this->input->post('tPAMRefIntIntRefDoc');
        $tTypeRef                = $this->input->post('tTypeRef');
        if ($nPage == '' || $nPage == null || $nPage == "NaN") {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPAMRefIntPageCurrent');
        }
        $nLangEdit = $this->session->userdata("tLangEdit");
        $aDataParamFilter = array(
            'tPAMRefIntBchCode'      => $tPAMRefIntBchCode,
            'tPAMRefIntDocNo'        => $tPAMRefIntDocNo,
            'tPAMRefIntDocDateFrm'   => $tPAMRefIntDocDateFrm,
            'tPAMRefIntDocDateTo'    => $tPAMRefIntDocDateTo,
            'tPAMRefIntStaDoc'       => $tPAMRefIntStaDoc,
            'tPAMRefIntIntRefDoc'    => $tPAMRefIntIntRefDoc
        );

        $aDataCondition = array(
            'FNLngID'           => $nLangEdit,
            'nPage'             => $nPage,
            'nRow'              => 10,
            'aAdvanceSearch'    => $aDataParamFilter
        );

        if ($tTypeRef==1) {
            //ใบจ่ายโอน - สาขา
            $aDataParam = $this->arrangementproduct_model->FSoMPAMCallRefIntDoc_TBO_DataTable($aDataCondition);
        }else {
            //ใบสั่งขาย
            $aDataParam = $this->arrangementproduct_model->FSoMPAMCallRefIntDoc_SO_DataTable($aDataCondition);
        }

        $aConfigView = array(
            'nPage'     => $nPage,
            'aDataList' => $aDataParam,
        );
        $this->load->view('document/arrangementproduct/refintdocument/wArrangementProductRefDocDataTable', $aConfigView);
    }

    // [เอกสารอ้างอิง] เอารายการจากเอกสารอ้างอิงมาแสดงในตาราง browse
    public function FSoCPAMCallRefIntDocDetailDataTable(){
        $nLangEdit          = $this->session->userdata("tLangEdit");
        $tBchCode           = $this->input->post('ptBchCode');
        $tDocNo             = $this->input->post('ptDocNo');
        $tRefDoc            = $this->input->post('ptRefDoc');
        $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
        $aDataCondition     = array(
            'FNLngID'   => $nLangEdit,
            'tBchCode'  => $tBchCode,
            'tDocNo'    => $tDocNo
        );

        if ($tRefDoc == 1) {
            //ใบจ่ายโอน - สาขา
            $aDataParam = $this->arrangementproduct_model->FSoMPAMCallRefIntDocDT_TBO_DataTable($aDataCondition);
        }else {
            //ใบสั่งขาย
            $aDataParam = $this->arrangementproduct_model->FSoMPAMCallRefIntDocDT_SO_DataTable($aDataCondition);
        }

        $aConfigView = array(
            'aDataList'         => $aDataParam,
            'nOptDecimalShow'   => $nOptDecimalShow
        );
        $this->load->view('document/arrangementproduct/refintdocument/wArrangementProductRefDocDetailDataTable', $aConfigView);
    }

    // [เอกสารอ้างอิง] เอารายการที่เลือกจากเอกสารอ้างอิงภายในลงตาราง temp dt
    public function FSoCPAMCallRefIntDocInsertDTToTemp(){
        $tPAMDocNo          =  $this->input->post('tPAMDocNo');
        $tPAMFrmBchCode     =  $this->input->post('tPAMFrmBchCode');
        $tRefIntDocNo       =  $this->input->post('tRefIntDocNo');
        $tRefIntBchCode     =  $this->input->post('tRefIntBchCode');
        $aSeqNo             =  $this->input->post('aSeqNo');
        $tRefDoc            =  $this->input->post('tRefDoc');
        $tInsertOrUpdateRow = $this->input->post('tInsertOrUpdateRow'); 

        $aDataParam = array(
            'tPAMDocNo'          => $tPAMDocNo,
            'tPAMFrmBchCode'     => $tPAMFrmBchCode,
            'tRefIntDocNo'       => $tRefIntDocNo,
            'tRefIntBchCode'     => $tRefIntBchCode,
            'aSeqNo'             => $aSeqNo,
            'tInsertOrUpdateRow' => $tInsertOrUpdateRow
        );

        if ($tRefDoc == 1) {
            //ใบจ่ายโอน - สาขา
            $aDataResult = $this->arrangementproduct_model->FSoMPAMCallRefIntDocInsert_TBO_DTToTemp($aDataParam);
        }else {
            //ใบสั่งขาย
            $aDataResult = $this->arrangementproduct_model->FSoMPAMCallRefIntDocInsert_SO_DTToTemp($aDataParam);
        }
        return $aDataResult;
    }

    // [เอกสารอ้างอิง] เพิ่ม หรือ เเก้ไข
    public function FSoCPAMEventAddEditHDDocRef(){
        try {
            $aDataWhere = [
                'FTXthDocNo'        => $this->input->post('ptDocNo'),
                'FTXthDocKey'       => 'TCNTPdtPickHD',
                'FTSessionID'       => $this->session->userdata('tSesSessionID'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
            ];
            $aDataAddEdit = [
                'FTXthRefDocNo'     => $this->input->post('ptRefDocNo'),
                'FTXthRefType'      => $this->input->post('ptRefType'),
                'FTXthRefKey'       => $this->input->post('ptRefKey'),
                'FDXthRefDocDate'   => $this->input->post('pdRefDocDate'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
            ];
            // $aReturnData = $this->arrangementproduct_model->FSaMPAMAddEditHDRefTmp($aDataWhere,$aDataAddEdit);
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // [เอกสารอ้างอิง] ลบ
    public function FSoCPRSEventDelHDDocRef(){
        try {
            $aData = [
                'FTXshDocNo'        => $this->input->post('ptDocNo'),
                'FTXshRefDocNo'     => $this->input->post('ptRefDocNo'),
                'FTXshDocKey'       => 'TCNTPdtPickHD',
                'FTSessionID'       => $this->session->userdata('tSesSessionID')
            ];
            $aReturnData = $this->arrangementproduct_model->FSaMPAMDelHDDocRef($aData);
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // ฟังก์ชั่นเช็คว่ามีสินค้าไหม
    public function FSoCPAMChkHavePdtForDocDTTemp() {
        try {
            $tPAMDocNo      = $this->input->post("ptPAMDocNo");
            $tPAMSessionID  = $this->input->post('tPAMSesSessionID');
            $aDataWhere     = array(
                'FTXthDocNo'    => $tPAMDocNo,
                'FTXthDocKey'   => 'TCNTPdtPickDT',
                'FTSessionID'   => $tPAMSessionID
            );
            $nCountPdtInDocDTTemp = $this->arrangementproduct_model->FSnMPAMChkPdtInDocDTTemp($aDataWhere);

            if ($nCountPdtInDocDTTemp > 0) {
                $aReturnData = array(
                    'nStaReturn'    => '1',
                    'tStaMessg'     => 'Found Data In Doc DT.'
                );
            } else {
                $aReturnData = array(
                    'nStaReturn'    => '800',
                    'tStaMessg'     => language('document/productarrangement/productarrangement', 'tPAMPleaseSeletedPDTIntoTable')
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaReturn'    => '500',
                'tStaMessg'     => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // ฟังก์ชั่นเพิ่มข้อมูล ในฐานข้อมูล
    public function FSoCPAMAddEventDoc() {
        try {
            $aDataDocument      = $this->input->post();
            $tPAMAutoGenCode    = (isset($aDataDocument['ocbPAMStaAutoGenCode'])) ? 1 : 0;
            $tPAMDocNo          = (isset($aDataDocument['oetPAMDocNo'])) ? $aDataDocument['oetPAMDocNo'] : '';
            $tPAMDocDate        = $aDataDocument['oetPAMDocDate'] . " " . $aDataDocument['oetPAMDocTime'];
            $tPAMVATInOrEx      = '';

            // Check Auto GenCode Document
            if ($tPAMAutoGenCode == '1') {
                $aStoreParam = array(
                    "tTblName"      => 'TCNTPdtPickHD',
                    "tDocType"      => $aDataDocument['ocmPAMPackType'],
                    "tBchCode"      => $aDataDocument['oetPAMBchCode'],
                    "tShpCode"      => "",
                    "tPosCode"      => "",
                    "dDocDate"      => date("Y-m-d H:i:s")
                );

                $aAutogen       = FCNaHAUTGenDocNo($aStoreParam);
                $tPAMDocNo      = $aAutogen[0]["FTXxhDocNo"];
            } else {
                $tPAMDocNo      = $tPAMDocNo;
            }

            // Array Data Table Document
            $aTableAddUpdate = array(
                'tTableHD'          => 'TCNTPdtPickHD',
                'tTableDT'          => 'TCNTPdtPickDT',
                'tTableStaGen'      => $aDataDocument['ocmPAMPackType']
            );

            // Array Data Where Insert
            $aDataWhere = array(
                "FTAgnCode"         => $aDataDocument['oetPAMAgnCode'],
                'FTBchCode'         => $aDataDocument['oetPAMBchCode'],
                "FTXshBchTo"        => $aDataDocument['oetPAMBchCodeTo'],
                'FTXthDocNo'        => $tPAMDocNo,
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FTSessionID'       => $this->input->post('ohdSesSessionID'),
                'FTXthVATInOrEx'    => $tPAMVATInOrEx
            );

            // Array Data HD Master
            $aDataMaster = array(
                "FTAgnCode"         => $aDataDocument['oetPAMAgnCode'],
                "FTXshBchTo"        => $aDataDocument['oetPAMBchCodeTo'],
                // 'FTAgnCode'         =>  $this->session->userdata("tSesUsrAgnCode"),
                'FDXthDocDate'      => (!empty($tPAMDocDate)) ? $tPAMDocDate : NULL,
                'FTDptCode'         => '',
                'FTWahCode'         => '',
                'FTUsrCode'         => $this->session->userdata('tSesUsername'),
                'FTSplCode'         => '',
                'FNXthDocType'      => $aDataDocument['ocmPAMPackType'],
                'FNXthDocPrint'     => $aDataDocument['ocmPAMFrmInfoOthDocPrint'],
                'FTXthRmk'          => $aDataDocument['otaPAMFrmInfoOthRmk'],
                'FTXthStaDoc'       => $aDataDocument['ohdPAMStaDoc'],
                'FTXthStaApv'       => !empty($aDataDocument['ohdPAMStaApv']) ? $aDataDocument['ohdPAMStaApv'] : NULL,
                'FTXthStaDelMQ'     => null,
                'FNXthStaRef'       => $aDataDocument['ocmPAMFrmInfoOthRef'],
                'FTPlcCode'         => $aDataDocument['oetPAMPlcCode'],
                'FTXthCat1'         => $aDataDocument['oetPAMCat1Code'],
                'FTXthCat2'         => $aDataDocument['oetPAMCat2Code'],
                'FNXthStaDocAct'    => (isset($aDataDocument['ocbPAMFrmInfoOthStaDocAct'])) ? 1 : 0,

            );

            $this->db->trans_begin();
            $aDataWheres = [
                'FTBchCode'     => $aDataWhere['FTBchCode'],
                'FTXthDocNo'    => $aDataWhere['FTXthDocNo'],
                // 'FTAgnCode'     => $this->session->userdata("tSesUsrAgnCode"),
                "FTAgnCode"         => $aDataDocument['oetPAMAgnCode']
            ];

            // [Update] DocNo -> Temp
            $this->arrangementproduct_model->FSxMPAMAddUpdateDocNoToTemp($aDataWhere, $aTableAddUpdate);

            // [Move] HDDocRef -> HDDocRef
            $this->arrangementproduct_model->FSxMPCKMoveHDRefTmpToHDRef($aDataWheres);

            // [Move] Update Document HD
            $this->arrangementproduct_model->FSxMPAMAddUpdateHD($aDataMaster, $aDataWhere, $aTableAddUpdate);

            // [Move] Doc DTTemp To DT
            $this->arrangementproduct_model->FSaMPAMMoveDtTmpToDt($aDataWhere, $aTableAddUpdate);

            // Check Status Transection DB
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent'     => '900',
                    'tStaMessg'     => "Error Unsucess Add Document."
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'   => $aDataWhere['FTXthDocNo'],
                    'nStaReturn'    => '1',
                    'tStaMessg'     => 'Success Add Document.'
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaReturn' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // หน้าจอแก้ไข
    public function FSvCPAMEditPage(){
        try {
            $ptDocumentNumber = $this->input->post('ptPAMDocNo');

            // Clear Data Product IN Doc Temp
            $this->arrangementproduct_model->FSxMPAMClearDataInDocTemp();

            // Array Data Where Get
            $aDataWhere = array(
                'FTXthDocNo'    => $ptDocumentNumber,
                'FTXthDocKey'   => 'TCNTPdtPickDT',
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername')
            );

            $nOptDecimalShow   = FCNxHGetOptionDecimalShow();

            $this->db->trans_begin();

            // Get Data Document HD
            $aDataDocHD = $this->arrangementproduct_model->FSaMPAMGetDataDocHD($aDataWhere);

            // [Move] Data DT TO DTTemp
            $this->arrangementproduct_model->FSxMPAMMoveDTToDTTemp($aDataWhere);

            // [Move] Data HDDocRef TO HDRefTemp
            $this->arrangementproduct_model->FSxMPAMMoveHDRefToHDRefTemp($aDataWhere);
            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Query Call Edit Page.'
                );

            } else {
                $this->db->trans_commit();

                //อนุญาตจัดสินค้าไม่เท่ากับจำนวนสั่ง
                $aWhere = array(
                    'FTUfrGrpRef'   => '068',
                    'FTUfrRef'      => 'KB038' 
                );
                $bAlwQtyPickNotEqQtyOrd = FCNbGetUsrFuncRpt($aWhere);

                $aDataConfigViewEdit = array(
                    'nOptDecimalShow'           => $nOptDecimalShow,
                    'nOptDocSave'               => $nOptDecimalShow,
                    'aDataDocHD'                => $aDataDocHD,
                    'bAlwQtyPickNotEqQtyOrd'    => $bAlwQtyPickNotEqQtyOrd,
                    'aAlwEvent'         => FCNaHCheckAlwFunc($this->tRouteMenu),

                );
                $tViewPageEdit           = $this->load->view('document/arrangementproduct/wArrangementProductPageAdd',$aDataConfigViewEdit,true);
                $aReturnData = array(
                    'tViewPageEdit'      => $tViewPageEdit,
                    'nStaEvent'         => '1',
                    'tStaMessg'         => 'Success'
                );
            }

        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // ฟังก์ชั่นแก้ไขข้อมูล ในฐานข้อมูล
    public function FSoCPAMEditEventDoc() {
        try {
            $aDataDocument      = $this->input->post();
            $tPAMDocNo          = (isset($aDataDocument['oetPAMDocNo'])) ? $aDataDocument['oetPAMDocNo'] : '';
            $tPAMStaDocAct      = (isset($aDataDocument['ocbPAMFrmInfoOthStaDocAct'])) ? 1 : 0;

            if($aDataDocument['ohdPAMStaApv'] == 1 || $aDataDocument['ohdPAMStaDoc'] == 3 ){ //ถ้าอนุมัติแล้ว อัพเดทแค่หมายเหตุได้อย่างเดียว

                // Array Data update
                $aDataUpdate = array(
                    'FTBchCode'             => $aDataDocument['oetPAMBchCode'],
                    'FTXthDocNo'            => $tPAMDocNo,
                    'FTXthRmk'              => $aDataDocument['otaPAMFrmInfoOthRmk'],
                );

                $this->db->trans_begin();

                // [Update] update หมายเหตุ
                $this->arrangementproduct_model->FSaMPAMUpdateRmk($aDataUpdate);

            } else {

                // Array Data Table Document
                $aTableAddUpdate = array(
                    'tTableHD'      => 'TCNTPdtPickHD',
                    'tTableDTSN'    => 'TCNTPdtPickDTSN',
                    'tTableDT'      => 'TCNTPdtPickDT'
                );

                // Array Data Where Insert
                $aDataWhere = array(
                    "FTAgnCode"     => $aDataDocument['oetPAMAgnCode'],
                    'FTBchCode'     => $aDataDocument['oetPAMBchCode'],
                    'FNXthDocType'  => $aDataDocument['ocmPAMPackType'],
                    'FTXthDocNo'    => $tPAMDocNo,
                    'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                    'FDCreateOn'    => date('Y-m-d H:i:s'),
                    'FTCreateBy'    => $this->input->post('ohdPAMUsrCode'),
                    'FTLastUpdBy'   => $this->input->post('ohdPAMUsrCode'),
                    'FTSessionID'   => $this->input->post('ohdSesSessionID')
                );

                // Array Data HD Master
                $aDataMaster = array(
                    "FTAgnCode"      => $aDataDocument['oetPAMAgnCode'],
                    "FTXshBchTo"     => $aDataDocument['oetPAMBchCodeTo'],
                    'FTXthRmk'       => $aDataDocument['otaPAMFrmInfoOthRmk'],
                    'FNXthStaDocAct' => $tPAMStaDocAct,
                    'FNXthDocType'   => $aDataDocument['ocmPAMPackType'],
                    'FTPlcCode'      => $aDataDocument['oetPAMPlcCode'],
                    'FTXthCat1'      => $aDataDocument['oetPAMCat1Code'],
                    'FTXthCat2'      => $aDataDocument['oetPAMCat2Code']
                );

                $this->db->trans_begin();

                // [Update] Document HD
                $this->arrangementproduct_model->FSxMPAMAddUpdateHD($aDataMaster, $aDataWhere, $aTableAddUpdate);

                // [Update] DocNo -> Temp
                $this->arrangementproduct_model->FSxMPAMAddUpdateDocNoToTemp($aDataWhere, $aTableAddUpdate);
                 
                // [Move] HDDocRef -> HDDocRef
                $this->arrangementproduct_model->FSxMPCKMoveHDRefTmpToHDRef($aDataWhere);

                // [Move] Doc DTTemp To DT
                $this->arrangementproduct_model->FSaMPAMMoveDtTmpToDt($aDataWhere, $aTableAddUpdate);
            }

            // Check Status Transection DB
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Error Unsucess Edit Document."
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'   => $tPAMDocNo,
                    'nStaReturn'    => '1',
                    'tStaMessg'     => 'Success Edit Document.'
                );
            }

        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaReturn' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // ยกเลิกเอกสาร
    public function FSvCPAMCancelDocument() {
        try {
            $this->db->trans_begin();

            $aDataUpdate = array(
                'tDocNo'        => $this->input->post('ptPAMDocNo'),
                'tDocType'      => $this->input->post('ptPAMDocType'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername')
            );
            $this->arrangementproduct_model->FSxMPAMCancelDocument($aDataUpdate);

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => $this->db->error()['message']
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => "Cancel Success."
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // [ลบข้อมูล] เอกสาร HD
    public function FSoCPAMDeleteEventDoc() {
        try {
            $tDataDocNo  = $this->input->post('tDataDocNo');
            $tBchCode    = $this->input->post('tBchCode');
            $aDataMaster = array(
                'tDataDocNo'    => $tDataDocNo,
                'tBchCode'      => $tBchCode
            );
            $aResDelDoc = $this->arrangementproduct_model->FSnMPAMDelDocument($aDataMaster);
            if ($aResDelDoc['rtCode'] == '1') {
                $aDataStaReturn = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success'
                );
            } else {
                $aDataStaReturn = array(
                    'nStaEvent' => $aResDelDoc['rtCode'],
                    'tStaMessg' => $aResDelDoc['rtDesc']
                );
            }
        } catch (Exception $Error) {
            $aDataStaReturn = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataStaReturn);
    }

    //อนุมัติเอกสาร
    public function FSoCPAMApproveEvent(){
        try{
            $aDataUpdate = array(
                'FTBchCode'         => $this->input->post('tBchCode'),
                'FTXthDocNo'        => $this->input->post('tDocNo'),
                'FNXthDocType'      => $this->input->post('tDocType'),
                'FTXthStaApv'       => 1,
                'FTXthUsrApv'       => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s')
            );

            $this->db->trans_begin();
            $this->arrangementproduct_model->FSxMPAMApproveDocument($aDataUpdate);

            if( $this->db->trans_status() === FALSE ){
                $this->db->trans_rollback();
                $aReturnData     = array(
                    'nStaEvent'    => '905',
                    'tStaMessg'    => $this->db->error()['message'],
                );
            }else{
                $this->db->trans_commit();
                $aReturnData     = array(
                    'nStaEvent'    => '1',
                    'tStaMessg'    => 'Approve Success.',
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }
}
