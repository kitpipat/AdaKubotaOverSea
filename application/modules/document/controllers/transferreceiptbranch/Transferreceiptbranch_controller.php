<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transferreceiptbranch_controller extends MX_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('document/transferreceiptbranch/Transferreceiptbranch_model');
        $this->load->model('company/company/Company_model');
        $this->load->model('payment/rate/Rate_model');

    }

    public function index($nBrowseType, $tBrowseOption ,$nDocType){
        $aDataConfigView    = array(
            'nBrowseType'       => $nBrowseType,  
            'tBrowseOption'     => $tBrowseOption, 
            'nDocType'          => $nDocType,
            'aPermission'       => FCNaHCheckAlwFunc('docTBI/0/0/'.$nDocType),
            'vBtnSave'          => FCNaHBtnSaveActiveHTML('docTBI/0/0/'.$nDocType), 
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(), 
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave() 
        );
        $this->load->view('document/transferreceiptbranch/wTransferreceiptbranch',$aDataConfigView);
    }

    //Page - List
    public function FSxCTBIPageList(){
        $this->load->view('document/transferreceiptbranch/wTransferreceiptbranchSearchList');    
    }

    //Page - DataTable
    public function FSxCTBIPageDataTable(){
        $tAdvanceSearchData     = $this->input->post('oAdvanceSearch');
        $nPage                  = $this->input->post('nPageCurrent');
        $nTBIDocType            = $this->input->post('nTBIDocType');
        $aAlwEvent              = FCNaHCheckAlwFunc('docTBI/0/0/'.$nTBIDocType);
        $nOptDecimalShow        = FCNxHGetOptionDecimalShow();

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }

        $nLangResort            = $this->session->userdata("tLangID");
        $nLangEdit              = $this->session->userdata("tLangEdit");
        $aData = array(
            'FNLngID'           => $nLangEdit,
            'nPage'             => $nPage,
            'nRow'              => 10,
            'nTBIDocType'       => $nTBIDocType,
            'aAdvanceSearch'    => $tAdvanceSearchData
        );

        $aResList   = $this->Transferreceiptbranch_model->FSaMTBIList($aData);
        $aGenTable  = array(
            'aAlwEvent'         => $aAlwEvent,
            'aDataList'         => $aResList,
            'nPage'             => $nPage,
            'nOptDecimalShow'   => $nOptDecimalShow
        );

        $tTBIViewDataTable = $this->load->view('document/transferreceiptbranch/wTransferreceiptbranchDataTable', $aGenTable ,true);
        $aReturnData = array(
            'tViewDataTable'    => $tTBIViewDataTable,
            'nStaEvent'         => '1',
            'tStaMessg'         => 'Success'
        );
        echo json_encode($aReturnData);
    }

    //Page - Add
    public function FSvCTBIPageAdd(){
        try{
            // Clear Product List IN Doc Temp
            $tTblSelectData = "TCNTPdtTBIHD";
            $this->Transferreceiptbranch_model->FSxMTBIClearPdtInTmp($tTblSelectData);

            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            // Get Option Doc Save
            $nOptDocSave        = FCNnHGetOptionDocSave();
            // Get Option Scan SKU
            $nOptScanSku        = FCNnHGetOptionScanSku();
            //Lang ภาษา
            // $nLangEdit          = $this->session->userdata("tLangEdit");

            // VAT
            // $aDataWhere         = array('FNLngID' => $nLangEdit);
            // $tAPIReq            = "";
            // $tMethodReq         = "GET";
            // $aCompData          = $this->Company_model->FSaMCMPList($tAPIReq,$tMethodReq,$aDataWhere);  
            // $tCmpCode           = $aCompData['raItems']['rtCmpCode'];

            // if($aCompData['rtCode'] == '1'){
            //     $tBchCode       = $aCompData['raItems']['rtCmpBchCode'];
            //     $tCmpRteCode    = $aCompData['raItems']['rtCmpRteCode'];
            //     $tVatCode       = $aCompData['raItems']['rtVatCodeUse'];
            //     $aVatRate       = FCNoHCallVatlist($tVatCode); 
            //     $cVatRate       = $aVatRate['FCVatRate'][0];
            //     $aDataRate      = array(
            //         'FTRteCode' => $tCmpRteCode,
            //         'FNLngID'   => $nLangEdit
            //     );
            //     $aResultRte     = $this->Rate_model->FSaMRTESearchByID($aDataRate);
            //     if($aResultRte['rtCode'] == 1){
            //         $cXthRteFac = $aResultRte['raItems']['rcRteRate'];
            //     }else{
            //         $cXthRteFac = "";
            //     }
            // }else{
            //     $tBchCode       = FCNtGetBchInComp();
            //     $tCmpRteCode    = "";
            //     $tVatCode       = "";
            //     $cVatRate       = "";
            //     $cXthRteFac     = "";
            // }

            // Get Department Code
            // $tUsrLogin  = $this->session->userdata('tSesUsername');
            // $tDptCode   = FCNnDOCGetDepartmentByUser($tUsrLogin);

            // Get ข้อมูลสาขา และ ร้านค้าของ User ที่ login
            // $aDataShp   = array(
            //     'FNLngID'   => $nLangEdit,
            //     'tUsrLogin' => $tUsrLogin
            // );
            // $aDataUserGroup = $this->Transferreceiptbranch_model->FSaMTBIGetShpCodeForUsrLogin($aDataShp);

            // if(empty($aDataUserGroup)){
            //     $tBchCode   = "";
            //     $tBchName   = "";
            //     $tMerCode   = "";
            //     $tMerName   = "";
            //     $tShpType   = "";
            //     $tShpCode   = "";
            //     $tShpName   = "";
            //     $tWahCode   = "";
            //     $tWahName   = "";
            // }else{
            //     $tBchCode   = "";
            //     $tBchName   = "";
            //     $tMerCode   = "";
            //     $tMerName   = "";
            //     $tShpType   = "";
            //     $tShpCode   = "";
            //     $tShpName   = "";
            //     $tWahCode   = "";
            //     $tWahName   = "";

            //     // เช็ค user ว่ามีการผูกสาขาไว้หรือไม่
            //     if(isset($aDataUserGroup["FTBchCode"]) && !empty($aDataUserGroup["FTBchCode"])){
            //         $tBchCode   = $aDataUserGroup["FTBchCode"];
            //         $tBchName   = $aDataUserGroup["FTBchName"];
            //     }

            //     // เช็ค user ว่ามีการผูกกลุ่มร้านค้าไว้หรือไม่
            //     if(isset($aDataUserGroup["FTMerCode"]) && !empty($aDataUserGroup["FTMerCode"])){
            //         $tMerCode   = $aDataUserGroup["FTMerCode"];
            //         $tMerName   = $aDataUserGroup["FTMerName"];
            //     }

            //     // เช็ค user ว่ามีการผูกร้านค้าไว้หรือไม่
            //     $tShpType   = $aDataUserGroup["FTShpType"];
            //     if(isset($aDataUserGroup["FTShpCode"]) && !empty($aDataUserGroup["FTShpCode"])){
            //         $tShpCode   = $aDataUserGroup["FTShpCode"];
            //         $tShpName   = $aDataUserGroup["FTShpName"];
            //     }

            //     if(isset($aDataUserGroup["FTWahCode"]) && !empty($aDataUserGroup["FTWahCode"])){
            //         $tWahCode   = $aDataUserGroup["FTWahCode"];
            //         $tWahName   = $aDataUserGroup["FTWahName"];
            //     }
            // }
            
            if($this->session->userdata("tSesUsrLevel") != "HQ"){
                $tBchCode = $this->session->userdata("tSesUsrBchCode");
                $tBchName = $this->session->userdata("tSesUsrBchName");
            }else{
                $tBchCode = $this->session->userdata("tSesUsrBchCom");
                $tBchName = $this->session->userdata("tSesUsrBchNameCom");
            }

            $aDataConfigViewAdd = array(
                'nOptDecimalShow'   => $nOptDecimalShow,
                'nOptDocSave'       => $nOptDocSave,
                'nOptScanSku'       => $nOptScanSku,
                // 'tCmpRteCode'       => $tCmpRteCode,
                // 'tVatCode'          => $tVatCode,
                // 'cVatRate'          => $cVatRate,
                // 'cXthRteFac'        => $cXthRteFac,
                'tDptCode'          => $this->session->userdata("tSesUsrDptCode"),
                'tBchCode'          => $tBchCode,
                'tBchName'          => $tBchName,
                // 'tMerCode'          => $tMerCode,
                // 'tMerName'          => $tMerName,
                // 'tShpType'          => $tShpType,
                // 'tShpCode'          => $tShpCode,
                // 'tShpName'          => $tShpName,

                'aDataDocHD'        => array('rtCode'=>'99'),
                // 'tBchCompCode'      => FCNtGetBchInComp(),
                // 'tBchCompName'      => FCNtGetBchNameInComp(),
                // 'tCmpCode'          => $this->session->userdata("tSesUsrBchCom") 
            );

            $tViewPageAdd       = $this->load->view('document/transferreceiptbranch/wTransferreceiptbranchPageAdd',$aDataConfigViewAdd,true);
            $aReturnData        = array(
                'tViewPageAdd'      => $tViewPageAdd,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    public function FSxCTBIEventClearTemp(){
        $aWhereClearTemp = [
            'FTXthDocNo'    => $tTBIDocNo,
            'FTXthDocKey'   => 'TCNTPdtTBIHD',
            'FTSessionID'   => $this->session->userdata('tSesSessionID')
        ];
        $this->Transferreceiptbranch_model->FSxMTBIClearPdtInTmp($aWhereClearTemp);
    }

    //Page - Edit
    public function FSvCTBIPageEdit(){
        try {
            $tTBIDocNo      = $this->input->post('ptDocNumber');
            $tTBIDocType    = $this->input->post('ptTBIDocType');

            // Clear Data In Doc DT Temp
            $aWhereClearTemp = [
                'FTXthDocNo'    => $tTBIDocNo,
                'FTXthDocKey'   => 'TCNTPdtTBIHD',
                'FTSessionID'   => $this->session->userdata('tSesSessionID')
            ];
            $this->Transferreceiptbranch_model->FSxMTBIClearPdtInTmp($aWhereClearTemp);

            $aAlwEvent          = FCNaHCheckAlwFunc('docTBI/0/0/'.$tTBIDocType);
            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            // Get Option Doc Save
            $nOptDocSave        = FCNnHGetOptionDocSave();
            // Get Option Scan SKU
            $nOptScanSku        = FCNnHGetOptionScanSku();
            //Lang ภาษา
            $nLangEdit          = $this->session->userdata("tLangEdit");

            // Get Department Code
            // $tUsrLogin  = $this->session->userdata('tSesUsername');
            // $tDptCode   = FCNnDOCGetDepartmentByUser($tUsrLogin);

            // Get ข้อมูลสาขา และ ร้านค้าของ User ที่ login
            // $tUsrLogin = $this->session->userdata('tSesUsername');
            // $aDataShp = array(
            //     'FNLngID'   => $nLangEdit,
            //     'tUsrLogin' => $tUsrLogin
            // );

            // VAT
            // $aDataWhere         = array('FNLngID' => $nLangEdit);
            // $tAPIReq            = "";
            // $tMethodReq         = "GET";
            // $aCompData          = $this->Company_model->FSaMCMPList($tAPIReq,$tMethodReq,$aDataWhere);  
            // $tCmpCode           = $aCompData['raItems']['rtCmpCode'];
            // if($aCompData['rtCode'] == '1'){
            //     $tBchCode       = $aCompData['raItems']['rtCmpBchCode'];
            //     $tCmpRteCode    = $aCompData['raItems']['rtCmpRteCode'];
            //     $tVatCode       = $aCompData['raItems']['rtVatCodeUse'];
            //     $aVatRate       = FCNoHCallVatlist($tVatCode); 
            //     $cVatRate       = $aVatRate['FCVatRate'][0];
            //     $aDataRate      = array(
            //         'FTRteCode' => $tCmpRteCode,
            //         'FNLngID'   => $nLangEdit
            //     );
            //     $aResultRte     = $this->Rate_model->FSaMRTESearchByID($aDataRate);
            //     if($aResultRte['rtCode'] == 1){
            //         $cXthRteFac = $aResultRte['raItems']['rcRteRate'];
            //     }else{
            //         $cXthRteFac = "";
            //     }
            // }else{
            //     $tBchCode       = FCNtGetBchInComp();
            //     $tCmpRteCode    = "";
            //     $tVatCode       = "";
            //     $cVatRate       = "";
            //     $cXthRteFac     = "";
            // }

            // $aDataUserGroup = $this->Transferreceiptbranch_model->FSaMTBIGetShpCodeForUsrLogin($aDataShp);
            // if (isset($aDataUserGroup) && empty($aDataUserGroup)) {
            //     $tUsrBchCode    = "";
            //     $tUsrBchName    = "";
            //     $tUsrMerCode    = "";
            //     $tUsrMerName    = "";
            //     $tUsrShopType   = "";
            //     $tUsrShopCode   = "";
            //     $tUsrShopName   = "";
            //     $tUsrWahCode    = "";
            //     $tUsrWahName    = "";
            // } else {
            //     $tUsrBchCode    = $aDataUserGroup["FTBchCode"];
            //     $tUsrBchName    = $aDataUserGroup["FTBchName"];
            //     $tUsrMerCode    = $aDataUserGroup["FTMerCode"];
            //     $tUsrMerName    = $aDataUserGroup["FTMerName"];
            //     $tUsrShopType   = $aDataUserGroup["FTShpType"];
            //     $tUsrShopCode   = $aDataUserGroup["FTShpCode"];
            //     $tUsrShopName   = $aDataUserGroup["FTShpName"];
            //     $tUsrWahCode    = $aDataUserGroup["FTWahCode"];
            //     $tUsrWahName    = $aDataUserGroup["FTWahName"];
            // }

            // Data Table Document
            $aTableDocument = array(
                'tTableHD'      => 'TCNTPdtTBIHD',
                'tTableHDCst'   => '',
                'tTableHDDis'   => '',
                'tTableDT'      => 'TCNTPdtTBIDT',
                'tTableDTDis'   => ''
            );

            // Array Data Where Get (HD,HDSpl,HDDis,DT,DTDis)
            $aDataWhere = array(
                'FTXthDocNo'    => $tTBIDocNo,
                'FTXthDocKey'   => 'TCNTPdtTBIHD',
                'FNLngID'       => $nLangEdit,
                'nRow'          => 10000,
                'nPage'         => 1,
            );
            $this->db->trans_begin();

            // Get Data Document HD
            $aDataDocHD = $this->Transferreceiptbranch_model->FSaMTBIGetDataDocHD($aDataWhere);
            
            // Move Data DT TO DTTemp
            $this->Transferreceiptbranch_model->FSxMTBIMoveDTToDTTemp($aDataWhere);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Query Call Edit Page.'
                );
            } else {
                $this->db->trans_commit();
                // $tTBIVATInOrEx = ($aDataDocHD['rtCode'] == '1') ? $aDataDocHD['raItems']['FTXthVATInOrEx'] : 1;
                $aCalcDTTempParams = array(
                    'tDataDocEvnCall'   => '1',
                    'tDataVatInOrEx'    => '1', //$tTBIVATInOrEx
                    'tDataDocNo'        => $tTBIDocNo,
                    'tDataDocKey'       => 'TCNTPdtTbiHD',
                    'tDataSeqNo'        => ""
                );
                FCNbHCallCalcDocDTTemp($aCalcDTTempParams);

                $aDataConfigViewAdd = array(
                    'nOptDecimalShow'   => $nOptDecimalShow,
                    'nOptDocSave'       => $nOptDocSave,
                    'nOptScanSku'       => $nOptScanSku,
                    // 'tCmpRteCode'       => $tCmpRteCode,
                    // 'tVatCode'          => $tVatCode,
                    // 'cVatRate'          => $cVatRate,
                    // 'cXthRteFac'        => $cXthRteFac,

                    // 'tDptCode'          => $aDataDocHD['FTDptCode'],
                    // 'tBchCode'          => $tUsrBchCode,
                    // 'tBchName'          => $tUsrBchName,
                    // 'tMerCode'          => $tUsrMerCode,
                    // 'tMerName'          => $tUsrMerName,
                    // 'tShpType'          => $tUsrShopType,
                    // 'tShpCode'          => $tUsrShopCode,
                    // 'tShpName'          => $tUsrShopName,
                    // 'tWahCode'          => $tUsrWahCode,
                    // 'tWahName'          => $tUsrWahName,

                    'aDataDocHD'        => $aDataDocHD,
                    // 'tBchCompCode'      => FCNtGetBchInComp(),
                    // 'tBchCompName'      => FCNtGetBchNameInComp(),
                    // 'tCmpCode'          => $tCmpCode,

                    'aAlwEvent'         => $aAlwEvent
                );

                $tViewPageAdd   = $this->load->view('document/transferreceiptbranch/wTransferreceiptbranchPageAdd', $aDataConfigViewAdd, true);
                $aReturnData    = array(
                    'tViewPageAdd'      => $tViewPageAdd,
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

    //Page - Product Table
    public function FSoCTBIPagePdtAdvTblLoadData() {
        try {
            $tTBIBchCode              = $this->input->post('ptTBIBchCode');
            $tTBIDocNo                = $this->input->post('ptTBIDocNo');
            $tTBIStaApv               = $this->input->post('ptTBIStaApv');
            $tTBIStaDoc               = $this->input->post('ptTBIStaDoc');
            $nTBIPageCurrent          = $this->input->post('pnTBIPageCurrent');
            $tSearchPdtAdvTable       = $this->input->post('ptSearchPdtAdvTable');
            $tVat                     = 1;
            // Edit in line
            $tTBIPdtCode              = '';
            $tTBIPunCode              = '';

            //Get Option Show Decimal
            $nOptDecimalShow            = FCNxHGetOptionDecimalShow();

            // Call Advance Table
            $tTableGetColumeShow        = 'TCNTPdtTBIDT';
            $aColumnShow                = FCNaDCLGetColumnShow($tTableGetColumeShow);
            

            $aDataWhere = array(
                'tSearchPdtAdvTable'    => $tSearchPdtAdvTable,
                'FTXthDocNo'            => $tTBIDocNo,
                'FTXthDocKey'           => 'TCNTPdtTbiHD',
                'nPage'                 => $nTBIPageCurrent,
                'nRow'                  => 10,
                'FTSessionID'           => $this->session->userdata('tSesSessionID'),
            );

            // Calcurate Document DT Temp Array Parameter
            $aCalcDTParams = [
                'tDataDocEvnCall'       => '1',
                'tDataVatInOrEx'        => $tVat,
                'tDataDocNo'            => $tTBIDocNo,
                'tDataDocKey'           => 'TCNTPdtTbiHD',
                'tDataSeqNo'            => ''
            ];
            FCNbHCallCalcDocDTTemp($aCalcDTParams);

            $aDataDocDTTemp     = $this->Transferreceiptbranch_model->FSaMTBIGetDocDTTempListPage($aDataWhere);
            $aDataDocDTTempSum  = $this->Transferreceiptbranch_model->FSaMTBISumDocDTTemp($aDataWhere);

            $aDataView = array(
                'nOptDecimalShow'       => $nOptDecimalShow,
                'tTBIStaApv'            => $tTBIStaApv,
                'tTBIStaDoc'            => $tTBIStaDoc,
                'tTBIPdtCode'           => @$tTBIPdtCode,
                'tTBIPunCode'           => @$tTBIPunCode,
                'nPage'                 => $nTBIPageCurrent,
                'aColumnShow'           => $aColumnShow,
                'aDataDocDTTemp'        => $aDataDocDTTemp,
                'aDataDocDTTempSum'     => $aDataDocDTTempSum
            );

            $tTBIPdtAdvTableHtml = $this->load->view('document/transferreceiptbranch/wTransferreceiptbranchPdtAdvTableData', $aDataView, true);

            // Call Footer Document
            $aEndOfBillParams = array(
                'tSplVatType'   => $tVat,
                'tDocNo'        => $tTBIDocNo,
                'tDocKey'       => 'TCNTPdtTBIHD',
                'nLngID'        => FCNaHGetLangEdit(),
                'tSesSessionID' => $this->session->userdata('tSesSessionID'),
                'tBchCode'      => $tTBIBchCode, //$this->session->userdata('tSesUsrLevel') == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata('tSesUsrBchCode')
            );

            $aTBIEndOfBill['aEndOfBillVat']  = FCNaDOCEndOfBillCalVat($aEndOfBillParams);
            $aTBIEndOfBill['aEndOfBillCal']  = FCNaDOCEndOfBillCal($aEndOfBillParams);
            $aTBIEndOfBill['tTextBath']      = FCNtNumberToTextBaht($aTBIEndOfBill['aEndOfBillCal']['cCalFCXphGrand']);
            $aReturnData = array(
                'tTBIPdtAdvTableHtml'   => $tTBIPdtAdvTableHtml,
                'aTBIEndOfBill'         => $aTBIEndOfBill,
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

    //กดเลือกว่า หน้าต่างจะให้โชว์อะไรบ้าง 
    public function FSoCTBIPageAdvTblShowColList() {
        try {
            $tTableShowColums = 'TCNTPdtTbiDT';
            $aAvailableColumn = FCNaDCLAvailableColumn($tTableShowColums);
            $aDataViewAdvTbl = array(
                'aAvailableColumn' => $aAvailableColumn
            );
            $tViewTableShowCollist = $this->load->view('document/transferreceiptbranch/advancetable/wTransferrenceiptbranchTableShowColList', $aDataViewAdvTbl, true);
            $aReturnData = array(
                'tViewTableShowCollist' => $tViewTableShowCollist,
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

    //บันทึกข้อมูลหน้าจอที่ให้โชว์อะไรบ้าง
    public function FSoCTBIEventAdvTalShowColSave() {
        try {
            $this->db->trans_begin();

            $nTBIStaSetDef       = $this->input->post('pnTBIStaSetDef');
            $aTBIColShowSet      = $this->input->post('paTBIColShowSet');
            $aTBIColShowAllList  = $this->input->post('paTBIColShowAllList');
            $aTBIColumnLabelName = $this->input->post('paTBIColumnLabelName');
            
            $tTableShowColums    = "TCNTPdtTBIDT";
            FCNaDCLSetShowCol($tTableShowColums, '', '');
            if ($nTBIStaSetDef == '1') {
                FCNaDCLSetDefShowCol($tTableShowColums);
            } else {
                for ($i = 0; $i < count($aTBIColShowSet); $i++) {
                    FCNaDCLSetShowCol($tTableShowColums, 1, $aTBIColShowSet[$i]);
                }
            }

            // Reset Seq Advannce Table
            FCNaDCLUpdateSeq($tTableShowColums, '', '', '');
            $q = 1;
            for ($n = 0; $n < count($aTBIColShowAllList); $n++) {
                FCNaDCLUpdateSeq($tTableShowColums, $aTBIColShowAllList[$n], $q, $aTBIColumnLabelName[$n]);
                $q++;
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Eror Not Save Colums'
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success'
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

    //เพิ่มสินค้าลงตาราง Tmp
    public function FSoCTBIEventAddPdtIntoDocDTTemp() {
        try {
            // $tTBIUserLevel       = $this->session->userdata('tSesUsrLevel');
            $tTBIDocNo           = $this->input->post('tTBIDocNo');
            $tTBIBchCode         = $this->input->post('tTBIBchCode'); //($tTBIUserLevel == 'HQ') ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCode");
            $tTBIPdtData         = $this->input->post('tTBIPdtData');
            $aTBIPdtData         = JSON_decode($tTBIPdtData);
            $tTBIVATInOrEx       = 1;
            $tTypeInsPDT         = $this->input->post('tType');

            $aDataWhere = array(
                'FTBchCode'     => $tTBIBchCode,
                'FTXthDocNo'    => $tTBIDocNo,
                'FTXthDocKey'   => 'TCNTPdtTbiHD',
            );
            $this->db->trans_begin();

            // ทำทีรายการ ตามรายการสินค้าที่เพิ่มเข้ามา
            for ($nI = 0; $nI<count($aTBIPdtData); $nI++) {

                $aItem       = $aTBIPdtData[$nI];
                if($tTypeInsPDT == 'CN'){
                    $tDocRefSO      = $aItem->tDocNo;
                    $tSeqItemSO     = $aItem->ptSeqItem;
                }else if($tTypeInsPDT == 'PDT'){
                    $tDocRefSO      = '';
                    $tSeqItemSO     = '';
                }

                $tTBIPdtCode = $aItem->pnPdtCode;
                $tTBIBarCode = $aItem->ptBarCode;
                $tTBIPunCode = $aItem->ptPunCode;

                $cTBIPrice    = $this->Transferreceiptbranch_model->FSaMTBIGetPriceBYPDT($tTBIPdtCode);
                if($cTBIPrice[0]->PDTCostSTD == null){
                    $nPrice = 0;
                }else{
                    $nPrice = $cTBIPrice[0]->PDTCostSTD;
                }

                $nTBIMaxSeqNo = $this->Transferreceiptbranch_model->FSaMTBIGetMaxSeqDocDTTemp($aDataWhere);
                $aDataPdtParams = array(
                    'tDocNo'            => $tTBIDocNo,
                    'tBchCode'          => $tTBIBchCode,
                    'tPdtCode'          => $tTBIPdtCode,
                    'tBarCode'          => $tTBIBarCode,
                    'tPunCode'          => $tTBIPunCode,
                    'cPrice'            => $nPrice,
                    'nMaxSeqNo'         => $nTBIMaxSeqNo + 1,
                    'nLngID'            => $this->session->userdata("tLangID"),
                    'tSessionID'        => $this->session->userdata('tSesSessionID'),
                    'tDocKey'           => 'TCNTPdtTBIHD',
                    'tDocRefSO'         => $tDocRefSO
                );

                // Data Master Pdt ข้อมูลรายการสินค้าที่เพิ่มเข้ามา
                $aDataPdtMaster     = $this->Transferreceiptbranch_model->FSaMTBIGetDataPdt($aDataPdtParams);
                // นำรายการสินค้าเข้า DT Temp
                $nStaInsPdtToTmp    = $this->Transferreceiptbranch_model->FSaMTBIInsertPDTToTemp($aDataPdtMaster, $aDataPdtParams);

                //ถ้าเลือกนำเข้าข้อมูล จะต้องไปทำให้สินค้าใน CN ว่าถูกใช้งานแล้ว
                if($tTypeInsPDT == 'CN'){
                    //$this->Transferreceiptbranch_model->FSaMTBIUpdatePDTInCN($tDocRefSO,$tSeqItemSO);
                }
            }

            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Insert Product Error Please Contact Admin.'
                );
            }else{
                $this->db->trans_commit();
                // Calcurate Document DT Temp Array Parameter
                $aCalcDTParams = [
                    'tDataDocEvnCall'   => '1',
                    'tDataVatInOrEx'    => $tTBIVATInOrEx,
                    'tDataDocNo'        => $tTBIDocNo,
                    'tDataDocKey'       => 'TCNTPdtTbiHD',
                    'tDataSeqNo'        => ''
                ];
                $tStaCalcuRate = FCNbHCallCalcDocDTTemp($aCalcDTParams);
                if ($tStaCalcuRate === TRUE) {
                    // Prorate HD
                    FCNaHCalculateProrate('TCNTPdtTbiHD', $tTBIDocNo);
                    FCNbHCallCalcDocDTTemp($aCalcDTParams);
                    $aReturnData = array(
                        'nStaEvent' => '1',
                        'tStaMessg' => 'Success Add Product Into Document DT Temp.'
                    );
                } else {
                    $aReturnData = array(
                        'nStaEvent' => '500',
                        'tStaMessg' => 'Error Calcurate Document DT Temp Please Contact Admin.'
                    );
                }
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //ลบข้อมูลใน HD (DATATABLE) - ตัวเดียว
    public function FSoCTBIEventDelete(){
        try{    
            $tTBIDocNo  = $this->input->post('tTBIDocNo');
            $aDataMaster = array(
                'tTBIDocNo'     => $tTBIDocNo
            );
            $aResDelDoc = $this->Transferreceiptbranch_model->FSnMTBIDelDocument($aDataMaster);
            if($aResDelDoc['rtCode'] == '1'){
                $aDataStaReturn  = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success'
                );
            }else{
                $aDataStaReturn  = array(
                    'nStaEvent' => $aResDelDoc['rtCode'],
                    'tStaMessg' => $aResDelDoc['rtDesc']
                );
            }
        }catch(Exception $Error){
            $aDataStaReturn = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataStaReturn);
    }

    //ลบสินค้าใน Tmp (ตารางสินค้า) - ตัวเดียว
    public function FSvCTBIEventRemovePdtInDTTmp() {
        try {
            $this->db->trans_begin();

            $aDataWhere = array(
                'tBchCode'      => $this->input->post('tBchCode'), //$this->session->userdata('tSesUsrLevel') == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata('tSesUsrBchCode'),
                'tDocNo'        => $this->input->post('tDocNo'),
                'tPdtCode'      => $this->input->post('tPdtCode'),
                'nSeqNo'        => $this->input->post('nSeqNo'),
                'tVatInOrEx'    => $this->input->post('tVatInOrEx'),
                'tSessionID'    => $this->session->userdata('tSesSessionID')
            );
            $this->Transferreceiptbranch_model->FSnMTBIDelPdtInDTTmp($aDataWhere);
            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Cannot Delete Item.',
                );
            } else {
                $this->db->trans_commit();
                $aCalcDTParams = [
                    'tDataDocEvnCall'   => '',
                    'tDataVatInOrEx'    => $aDataWhere['tVatInOrEx'],
                    'tDataDocNo'        => $aDataWhere['tDocNo'],
                    'tDataDocKey'       => 'TCNTPdtTbiHD',
                    'tDataSeqNo'        => ''
                ];
                FCNbHCallCalcDocDTTemp($aCalcDTParams);
                $aReturnData = array(
                    'nStaEvent'         => '1',
                    'tStaMessg'         => 'Success Delete Product'
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

    //ลบสินค้าใน Tmp (ตารางสินค้า) - หลายตัว
    public function FSvCTBIEventRemovePdtInDTTmpMulti() {
        try {
            $this->db->trans_begin();
            $aDataWhere = array(
                'tBchCode'      => $this->input->post('ptTBIBchCode'), //$this->session->userdata('tSesUsrLevel') == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata('tSesUsrBchCode'),
                'tDocNo'        => $this->input->post('ptTBIDocNo'),
                'tVatInOrEx'    => $this->input->post('ptTBIVatInOrEx'),
                'aDataPdtCode'  => $this->input->post('paDataPdtCode'),
                'aDataPunCode'  => $this->input->post('paDataPunCode'),
                'aDataSeqNo'    => $this->input->post('paDataSeqNo')
            );

            $this->Transferreceiptbranch_model->FSnMTBIDelMultiPdtInDTTmp($aDataWhere);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Cannot Delete Item.',
                );
            } else {
                $this->db->trans_commit();
                $aCalcDTParams = [
                    'tDataDocEvnCall'   => '',
                    'tDataVatInOrEx'    => $aDataWhere['tVatInOrEx'],
                    'tDataDocNo'        => $aDataWhere['tDocNo'],
                    'tDataDocKey'       => 'TCNTPdtTbiHD',
                    'tDataSeqNo'        => ''
                ];
                FCNbHCallCalcDocDTTemp($aCalcDTParams);
                $aReturnData = array(
                    'nStaEvent'         => '1',
                    'tStaMessg'         => 'Success Delete Product'
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

    //Event เพิ่ม HD - DT
    public function FSoCTBIEventAdd(){
        try {
            $aDataDocument   = $this->input->post();
            $tTBIAutoGenCode = (isset($aDataDocument['ocbTBIStaAutoGenCode'])) ? 1 : 0;
            // $tTBIDocNo       = (isset($aDataDocument['oetTBIDocNo'])) ? $aDataDocument['oetTBIDocNo'] : '';
            $tTBIDocDate     = $aDataDocument['oetTBIDocDate'] . " " . $aDataDocument['oetTBIDocTime'];
            $tTBIVATInOrEx   = 1;
            $tTBISessionID   = $this->session->userdata('tSesSessionID');

            $aCalDTTempParams = [
                'tDocNo'        => '',
                'tBchCode'      => $this->input->post('oetTBIBchCode'),
                'tSessionID'    => $tTBISessionID,
                'tDocKey'       => 'TCNTPdtTbiHD'
            ];
            $aCalDTTempForHD = $this->FSaCTBICalDTTempForHD($aCalDTTempParams);
        
            // Array Data Table Document
            $aTableAddUpdate = array(
                'tTableHD'      => 'TCNTPdtTbiHD',
                'tTableHDDis'   => '-',
                'tTableHDSpl'   => '-',
                'tTableDT'      => 'TCNTPdtTbiDT',
                'tTableDTDis'   => '-',
                'tTableStaGen'  => $aDataDocument['ohdTBIFrmDocType'],
                'tTableHDRef'   => 'TCNTPdtTbiHDRef'
            );

            // Array Data Where Insert
            $aDataWhere = array(
                'FTBchCode'         => $this->input->post('oetTBIBchCode'),
                'FTXthDocNo'        => '',
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FTSessionID'       => $this->session->userdata('tSesSessionID'),
                'FTXthVATInOrEx'    => $tTBIVATInOrEx,
                'FTXtdBchRef'       => $this->input->post('oetTBIBchCodeFrom')
            );

            if($this->input->post('ohdTBIFrmDocType') == '1' && $this->input->post('ocmSelectTransTypeIN') == '3'){          // DocType = 1 and ผู้จำหน่าย
                $tRsnType   = $this->input->post('ocmSelectTransTypeIN');
                $tSplCode   = $this->input->post('oetTBISplCode');
                $tOther     = NULL;
            }else if($this->input->post('ohdTBIFrmDocType') == '1' && $this->input->post('ocmSelectTransTypeIN') == '4'){     // DocType = 1 and แหล่งอื่น
                $tRsnType   = $this->input->post('ocmSelectTransTypeIN');
                $tSplCode   = NULL;
                $tOther     = $this->input->post('oetTBIINEtc');
            }else{                                                                                                            // DocType = 5 and คลัง
                $tRsnType   = '1';
                $tSplCode   = NULL;
                $tOther     = NULL;
            }

            // Array Data HD Master
            $aDataMaster = array(
                'FTBchCode'             => $this->input->post('oetTBIBchCode'),
                // 'FTXthDocNo'            => $tTBIDocNo,
                'FNXthDocType'          => $aDataDocument['ohdTBIFrmDocType'],
                // 'FTXthTypRefFrm'        => $tRsnType,
                'FDXthDocDate'          => (!empty($tTBIDocDate)) ? $tTBIDocDate : NULL,
                'FTXthVATInOrEx'        => $tTBIVATInOrEx,
                'FTDptCode'             => $this->session->userdata('tSesUsrDptCode') == '' ? null : $this->session->userdata('tSesUsrDptCode'),
                // 'FTXthMerCode'          => '',

                'FTXthBchFrm'           => $this->input->post('oetTBIBchCodeFrom'),
                'FTXthBchTo'            => $this->input->post('oetTBIBchCodeTo'),

                // 'FTXthShopFrm'          => NULL,
                // 'FTXthShopTo'           => NULL,
                // 'FTXthWhFrm'            => NULL,
                'FTXthWhTo'             => $this->input->post('oetTBIWahCodeTo'),

                // 'FTXthPosFrm'           => NULL,
                // 'FTXthPosTo'            => NULL,

                'FTXthRsnType'          => $tRsnType,
                'FTSplCode'             => $tSplCode,
                'FTXthOther'            => $tOther,

                'FTUsrCode'             => $this->session->userdata('tSesUserCode'),
                'FTSpnCode'             => NULL,
                'FTXthApvCode'          => $this->session->userdata('tSesUsername'),
                'FTXthRefExt'           => $aDataDocument['oetTBIRefExtDoc'],
                'FDXthRefExtDate'       => $aDataDocument['oetTBIRefExtDocDate'],
                'FTXthRefInt'           => $aDataDocument['oetTBIRefIntDoc'],
                'FDXthRefIntDate'       => date('Y-m-d H:i:s'), //$aDataDocument['oetTBIRefIntDocDate']
                'FNXthDocPrint'         => 0,
                'FCXthTotal'            => $aCalDTTempForHD['FCXphTotal'],
                'FCXthVat'              => $aCalDTTempForHD['FCXphVat'],
                'FCXthVatable'          => $aCalDTTempForHD['FCXphVatable'],
                'FTXthRmk'              => $aDataDocument['otaTBIFrmInfoOthRmk'],
                'FTXthStaDoc'           => 1, //สถานะ เอกสาร  1:สมบูรณ์, 2:ไม่สมบูรณ์, 3:ยกเลิก
                'FTXthStaApv'           => !empty($aDataDocument['ohdTBIStaApv']) ? $aDataDocument['ohdTBIStaApv'] : NULL,
                'FTXthStaPrcStk'        => !empty($aDataDocument['ohdTBIStaPrcStk']) ? $$aDataDocument['ohdTBIStaPrcStk'] : NULL,
                'FTXthStaDelMQ'         => !empty($aDataDocument['ohdTBIStaDelMQ']) ? $aDataDocument['ohdTBIStaDelMQ'] : NULL,
                'FNXthStaDocAct'        => $aDataDocument['ocbTBIStaDocAct'] == '' ? 0 : 1,
                'FNXthStaRef'           => NULL,
                'FTRsnCode'             => $aDataDocument['oetTBIReasonCode'] == '' ? null : $aDataDocument['oetTBIReasonCode'],
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername')
            );

            $aDataHDRef = array(
                'FTXthCtrName'          => $this->input->post('oetTBITransportCtrName'),
                'FDXthTnfDate'          => $this->input->post('oetTBITransportTnfDate'),
                'FTXthRefTnfID'         => $this->input->post('oetTBITransportRefTnfID'),
                'FTXthRefVehID'         => $this->input->post('oetTBITransportRefVehID'),
                'FTXthQtyAndTypeUnit'   => $this->input->post('oetTBITransportQtyAndTypeUnit'),
                'FNXthShipAdd'          => $this->input->post('ohdTBIFrmShipAdd'),
                'FTViaCode'             => $this->input->post('oetTBIUpVendingViaCode'),
            );

            $this->db->trans_begin();

            // Check Auto GenCode Document
            if ($tTBIAutoGenCode == '1') {
                // $aTBIGenCode = FCNaHGenCodeV5($aTableAddUpdate['tTableHD'], $aTableAddUpdate['tTableStaGen']);
                // if ($aTBIGenCode['rtCode'] == '1') {
                //     if($aDataDocument['ohdTBIFrmDocType'] == '5'){
                //         $aDataWhere['FTXthDocNo'] = $aTBIGenCode['rtXthDocNo'];
                //     }else{
                //         $aDataWhere['FTXthDocNo'] = $aTBIGenCode['rtXthDocNo'];
                //     }
                // }

                // Update new gencode
                // 18/05/2020 Napat(Jame)
                $aStoreParam = array(
                    "tTblName"    => $aTableAddUpdate['tTableHD'],                           
                    "tDocType"    => $aTableAddUpdate['tTableStaGen'],                                          
                    "tBchCode"    => $aDataMaster['FTBchCode'],                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d H:i:s")       
                );
                $aAutogen                   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataWhere['FTXthDocNo']   = $aAutogen[0]["FTXxhDocNo"];
            } else {
                $aDataWhere['FTXthDocNo'] = $this->input->post('oetTBIDocNo');
            }

          

            // Add Update Document HD
            $this->Transferreceiptbranch_model->FSxMTBIAddUpdateHD($aDataMaster, $aDataWhere, $aTableAddUpdate);
            $this->Transferreceiptbranch_model->FSaMTBIAddUpdateHDRef($aDataHDRef, $aDataWhere, $aTableAddUpdate);

            // Update Doc No Into Doc Temp
            $this->Transferreceiptbranch_model->FSxMTBIAddUpdateDocNoToTemp($aDataWhere, $aTableAddUpdate);

            // Move Doc DTTemp To DT
            $this->Transferreceiptbranch_model->FSaMTBIMoveDtTmpToDt($aDataWhere, $aTableAddUpdate);

            // Check Status Transection DB
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Error Unsucess Add Document."
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

    //Event แก้ไข HD - DT
    public function FSoCTBIEventEdit(){
        try {
            $aDataDocument          = $this->input->post();
            $tTBIAutoGenCode        = (isset($aDataDocument['ocbTBIStaAutoGenCode'])) ? 1 : 0;
            $tTBIDocNo              = (isset($aDataDocument['oetTBIDocNo'])) ? $aDataDocument['oetTBIDocNo'] : '';
            $tTBIDocDate            = $aDataDocument['oetTBIDocDate'] . " " . $aDataDocument['oetTBIDocTime'];
            $tTBIStaDocAct          = (isset($aDataDocument['ocbTBIStaDocAct'])) ? 1 : 0;
            // $tTBIVATInOrEx          = $aDataDocument['ohdTBIFrmSplInfoVatInOrEx'];
            $tTBISessionID          = $this->session->userdata('tSesSessionID');

            $aCalDTTempParams = [
                'tDocNo'        => '',
                'tBchCode'      => $aDataDocument['ohdTBIBchCode'],
                'tSessionID'    => $tTBISessionID,
                'tDocKey'       => 'TCNTPdtTBIHD'
            ];

            $aCalDTTempForHD    = $this->FSaCTBICalDTTempForHD($aCalDTTempParams);

            // Array Data Table Document
            $aTableAddUpdate = array(
                'tTableHD'      => 'TCNTPdtTBIHD',
                'tTableHDDis'   => '-',
                'tTableHDSpl'   => '-',
                'tTableDT'      => 'TCNTPdtTBIDT',
                'tTableDTDis'   => '-',
                'tTableStaGen'  => 5,
                'tTableHDRef'   => 'TCNTPdtTbiHDRef'
            );

            // Array Data Where Insert
            $aDataWhere = array(
                'FTBchCode'         => $aDataDocument['ohdTBIBchCode'],
                'FTXthDocNo'        => $tTBIDocNo,
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FTSessionID'       => $this->session->userdata('tSesSessionID'),
                // 'FTXthVATInOrEx'    => $tTBIVATInOrEx
            );

            if($this->input->post('ocmSelectTransTypeIN') == '3'){          // DocType = 1 and ผู้จำหน่าย
                $tRsnType   = $this->input->post('ocmSelectTransTypeIN');
                $tSplCode   = $this->input->post('oetTBISplCode');
                $tOther     = '';
            }else if($this->input->post('ocmSelectTransTypeIN') == '4'){     // DocType = 1 and แหล่งอื่น
                $tRsnType   = $this->input->post('ocmSelectTransTypeIN');
                $tSplCode   = NULL;
                $tOther     = $this->input->post('oetTBIINEtc');
            }else{                                                          // DocType = 5 and คลัง
                $tRsnType   = '1';
                $tSplCode   = NULL;
                $tOther     = NULL;
            }

            // Array Data HD Master
            $aDataMaster = array(
                'FTBchCode'             => $aDataDocument['ohdTBIBchCode'],
                // 'FTXthDocNo'            => $tTBIDocNo,
                'FNXthDocType'          => $this->input->post('ohdTBIFrmDocType'),
                // 'FTXthTypRefFrm'        => $tRsnType,
                'FDXthDocDate'          => (!empty($tTBIDocDate)) ? $tTBIDocDate : NULL,
                'FTXthVATInOrEx'        => '1',
                'FTDptCode'             => $this->session->userdata('tSesUsrDptCode') == '' ? null : $this->session->userdata('tSesUsrDptCode'),
                // 'FTXthMerCode'          => '',

                'FTXthBchFrm'           => $this->input->post('oetTBIBchCodeFrom'),
                'FTXthBchTo'            => $this->input->post('oetTBIBchCodeTo'),

                // 'FTXthShopFrm'          => $tShopFrm,
                // 'FTXthShopTo'           => $tShopTo,
                // 'FTXthWhFrm'            => $tWahFrm,
                'FTXthWhTo'             => $this->input->post('oetTBIWahCodeTo'),
                // 'FTXthPosFrm'           => $tPosFrm,
                // 'FTXthPosTo'            => $tPosTo,
                // 'FTSplCode'             => $tSplCode,

                'FTXthRsnType'          => $tRsnType,
                'FTSplCode'             => $tSplCode,
                'FTXthOther'            => $tOther,

                'FTUsrCode'             => $this->session->userdata('tSesUserCode'),
                'FTSpnCode'             => null,
                'FTXthApvCode'          => $this->session->userdata('tSesUsername'),
                'FTXthRefExt'           => $aDataDocument['oetTBIRefExtDoc'],
                'FDXthRefExtDate'       => $aDataDocument['oetTBIRefExtDocDate'],
                'FTXthRefInt'           => $aDataDocument['oetTBIRefIntDoc'],
                'FDXthRefIntDate'       => date('Y-m-d H:i:s'), //$aDataDocument['oetTBIRefIntDocDate']
                'FNXthDocPrint'         => 0,
                'FCXthTotal'            => $aCalDTTempForHD['FCXphTotal'],
                'FCXthVat'              => $aCalDTTempForHD['FCXphVat'],
                'FCXthVatable'          => $aCalDTTempForHD['FCXphVatable'],
                'FTXthRmk'              => $aDataDocument['otaTBIFrmInfoOthRmk'],
                'FTXthStaDoc'           => 1, //สถานะ เอกสาร  1:สมบูรณ์, 2:ไม่สมบูรณ์, 3:ยกเลิก
                'FTXthStaApv'           => !empty($aDataDocument['ohdTBIStaApv']) ? $aDataDocument['ohdTBIStaApv'] : NULL,
                'FTXthStaPrcStk'        => !empty($aDataDocument['ohdTBIStaPrcStk']) ? $$aDataDocument['ohdTBIStaPrcStk'] : NULL,
                'FTXthStaDelMQ'         => !empty($aDataDocument['ohdTBIStaDelMQ']) ? $aDataDocument['ohdTBIStaDelMQ'] : NULL,
                'FNXthStaDocAct'        => $aDataDocument['ocbTBIStaDocAct'] == '' ? 0 : 1,
                'FNXthStaRef'           => null,
                'FTRsnCode'             => $aDataDocument['oetTBIReasonCode'] == '' ? null : $aDataDocument['oetTBIReasonCode'],
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
            );

            $aDataHDRef = array(
                'FTXthCtrName'          => $this->input->post('oetTBITransportCtrName'),
                'FDXthTnfDate'          => $this->input->post('oetTBITransportTnfDate'),
                'FTXthRefTnfID'         => $this->input->post('oetTBITransportRefTnfID'),
                'FTXthRefVehID'         => $this->input->post('oetTBITransportRefVehID'),
                'FTXthQtyAndTypeUnit'   => $this->input->post('oetTBITransportQtyAndTypeUnit'),
                'FNXthShipAdd'          => $this->input->post('ohdTBIFrmShipAdd'),
                'FTViaCode'             => $this->input->post('oetTBIUpVendingViaCode'),
            );

            $this->db->trans_begin();

            // Add Update Document HD
            $this->Transferreceiptbranch_model->FSxMTBIAddUpdateHD($aDataMaster, $aDataWhere, $aTableAddUpdate);
            $this->Transferreceiptbranch_model->FSaMTBIAddUpdateHDRef($aDataHDRef, $aDataWhere, $aTableAddUpdate);

            // Update Doc No Into Doc Temp
            $this->Transferreceiptbranch_model->FSxMTBIAddUpdateDocNoToTemp($aDataWhere, $aTableAddUpdate);

            // Move Doc DTTemp To DT
            $this->Transferreceiptbranch_model->FSaMTBIMoveDtTmpToDt($aDataWhere, $aTableAddUpdate);

            // Check Status Transection DB
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Error Unsucess Add Document."
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

    //คำนวณค่าจาก DT Temp ให้ HD
    private function FSaCTBICalDTTempForHD($paParams) {
        $aCalDTTemp = $this->Transferreceiptbranch_model->FSaMTBICalInDTTemp($paParams);
        if (isset($aCalDTTemp) && !empty($aCalDTTemp)) {
            $aCalDTTempItems = $aCalDTTemp[0];
            // คำนวณหา ยอดปัดเศษ ให้ HD(FCXphRnd)
            $pCalRoundParams = [
                'FCXphAmtV'     => $aCalDTTempItems['FCXphAmtV'],
                'FCXphAmtNV'    => $aCalDTTempItems['FCXphAmtNV']
            ];
            $aRound = $this->FSaCTBICalRound($pCalRoundParams);
            // คำนวณหา ยอดรวม ให้ HD(FCXphGrand)
            $nRound = $aRound['nRound'];
            $cGrand = $aRound['cAfRound'];

            // จัดรูปแบบข้อความ จากตัวเลขเป็นข้อความ HD(FTXphGndText)
            $tGndText = FCNtNumberToTextBaht(number_format($cGrand, 2));
            $aCalDTTempItems['FCXphRnd']        = $nRound;
            $aCalDTTempItems['FCXphGrand']      = $cGrand;
            $aCalDTTempItems['FTXphGndText']    = $tGndText;
            return $aCalDTTempItems;
        }
    }

    //หาค่าปัดเศษ HD(FCXphRnd)
    private function FSaCTBICalRound($paParams) {
        $tOptionRound = '1';  // ปัดขึ้น
        $cAmtV  = $paParams['FCXphAmtV'];
        $cAmtNV = $paParams['FCXphAmtNV'];
        $cBath  = $cAmtV + $cAmtNV;
        // ตัดเอาเฉพาะทศนิยม
        $nStang = explode('.', number_format($cBath, 2))[1];
        $nPoint = 0;
        $nRound = 0;
        /* ====================== ปัดขึ้น ================================ */
        if ($tOptionRound == '1') {
            if ($nStang >= 1 and $nStang < 25) {
                $nPoint = 25;
                $nRound = $nPoint - $nStang;
            }
            if ($nStang > 25 and $nStang < 50) {
                $nPoint = 50;
                $nRound = $nPoint - $nStang;
            }
            if ($nStang > 50 and $nStang < 75) {
                $nPoint = 75;
                $nRound = $nPoint - $nStang;
            }
            if ($nStang > 75 and $nStang < 100) {
                $nPoint = 100;
                $nRound = $nPoint - $nStang;
            }
        }
        /* ====================== ปัดขึ้น ================================ */

        /* ====================== ปัดลง ================================ */
        if ($tOptionRound != '1') {
            if ($nStang >= 1 and $nStang < 25) {
                $nPoint = 1;
                $nRound = $nPoint - $nStang;
            }
            if ($nStang > 25 and $nStang < 50) {
                $nPoint = 25;
                $nRound = $nPoint - $nStang;
            }
            if ($nStang > 50 and $nStang < 75) {
                $nPoint = 50;
                $nRound = $nPoint - $nStang;
            }
            if ($nStang > 75 and $nStang < 100) {
                $nPoint = 75;
                $nRound = $nPoint - $nStang;
            }
        }
        /* ====================== ปัดลง ================================ */
        $cAfRound = floatval($cBath) + floatval($nRound / 100);
        return [
            'tRoundType' => $tOptionRound,
            'cBath' => $cBath,
            'nPoint' => $nPoint,
            'nStang' => $nStang,
            'nRound' => $nRound,
            'cAfRound' => $cAfRound
        ];
    }

    //ยกเลิกเอกสาร
    public function FSoCTBIEventCancel(){
        $tTBIDocNo = $this->input->post('tTBIDocNo');

        $aDataUpdate = array(
            'FTXthDocNo' => $tTBIDocNo,
        );
        $aStaApv    = $this->Transferreceiptbranch_model->FSvMTBICancel($aDataUpdate); 
        
         //อัพเดทใน CN ให้กลับไปใช้งานได้
        $this->Transferreceiptbranch_model->FSvMTBICheckDocumentInCN('CANCEL',$aDataUpdate); 

        if($aStaApv['rtCode'] == 1){
            $aApv = array(
                'nSta' => 1,
                'tMsg' => "Cancel done.",
            );
        }else{
            $aApv = array(
                'nSta' => 2,
                'tMsg' => "Not Cancel.",
            );
        }
        echo json_encode($aApv);
    }

    //อัพเดทข้อมูล เป็นเเถว
    public function FSoCTBIEventEditPdtIntoDocDTTemp(){
        try {
            $tTBIBchCode    = $this->input->post('tTBIBchCode');
            $tTBIDocNo      = $this->input->post('tTBIDocNo');
            $tTBIVATInOrEx  = $this->input->post('tTBIVATInOrEx');
            $nTBISeqNo      = $this->input->post('nTBISeqNo');
            $tTBIFieldName  = $this->input->post('tTBIFieldName');
            $tTBIValue      = $this->input->post('tTBIValue');
            $tTBISessionID  = $this->session->userdata('tSesSessionID');

            $aDataWhere = array(
                'tTBIBchCode'   => $tTBIBchCode,
                'tTBIDocNo'     => $tTBIDocNo,
                'nTBISeqNo'     => $nTBISeqNo,
                'tTBISessionID' => $this->session->userdata('tSesSessionID'),
                'tDocKey'       => 'TCNTPdtTbiHD',
            );
            $aDataUpdateDT = array(
                'tTBIFieldName'  => $tTBIFieldName,
                'tTBIValue'      => $tTBIValue
            );

            // echo "<pre>";
            // print_r($aDataWhere);
            // print_r($aDataUpdateDT);
            // exit;

            $this->db->trans_begin();
            $this->Transferreceiptbranch_model->FSaMTBIUpdateInlineDTTemp($aDataUpdateDT, $aDataWhere);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent'     => '500',
                    'tStaMessg'     => "Error Update Inline Into Document DT Temp."
                );
            } else {
                $this->db->trans_commit();

                $aCalcDTTempParams = array(
                    'tDataDocEvnCall'   => '1',
                    'tDataVatInOrEx'    => '1',
                    'tDataDocNo'        => $tTBIDocNo,
                    'tDataDocKey'       => 'TCNTPdtTbiHD',
                    'tDataSeqNo'        => $nTBISeqNo
                );
                $tStaCalDocDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTTempParams);
                if ($tStaCalDocDTTemp === TRUE) {
                    $aReturnData = array(
                        'nStaEvent'     => '1',
                        'tStaMessg'     => "Update And Calcurate Process Document DT Temp Success."
                    );
                } else {
                    $aReturnData = array(
                        'nStaEvent'     => '500',
                        'tStaMessg'     => "Error Cannot Calcurate Document DT Temp."
                    );
                }
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //เลือกสินค้าจากตาราง CN - ใบสั้งขาย
    public function FSoCTBIPageSelectPDTInCN(){
        $tBCHCode = $this->input->post('tBCHCode');
        $tSHPCode = $this->input->post('tSHPCode');
        $tWAHCode = $this->input->post('tWAHCode');

        $aWhere = array(
            'tBCHCode' => $tBCHCode ,
            'tSHPCode' => $tSHPCode ,
            'tWAHCode' => $tWAHCode ,
            'FNLngID'  => $this->session->userdata("tLangEdit")
        );

        $aDataCN = $this->Transferreceiptbranch_model->FSaMTBIGetPDTInCN($aWhere);
        $aDataViewCN = array(
            'aDataCN'       => $aDataCN
        );
        $tViewCN            = $this->load->view('document/transferreceiptbranch/wTransferreceiptbranchCN',$aDataViewCN,true);
        $aReturnData        = array(
            'tViewPageAdd'  => $tViewCN,
            'nStaEvent'     => '1',
            'tStaMessg'     => 'Success'
        );
        echo json_encode($aReturnData);
    }

    //อนุมัติ
    public function FSoCTBIEventApproved(){
        $tXthDocNo      = $this->input->post('tXthDocNo');
        $tXthStaApv     = $this->input->post('tXthStaApv');
        $tXthDocType    = $this->input->post('tXthDocType');
        $tXthBchCode    = $this->input->post('tXthBchCode');
        
        $tUsrBchCode    = FCNtGetBchInComp();

        $aDataUpdate = array(
            'FTXthDocNo'    => $tXthDocNo,
            'FTXthApvCode'  => $this->session->userdata('tSesUsername')
        );
        $aStaApv = $this->Transferreceiptbranch_model->FSvMTBIApprove($aDataUpdate); 
        try{
            $aMQParams = [
                "queueName" => "TNFBRANCHIN",
                "params"    => [
                    "ptBchCode"     => $tXthBchCode,
                    "ptDocNo"       => $tXthDocNo,
                    "ptDocType"     => $tXthDocType,
                    "ptUser"        => $this->session->userdata('tSesUsername')
                ]
            ];
            FCNxCallRabbitMQ($aMQParams);
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg'    => 'ok'
            );
            echo json_encode($aReturn);
        }catch(Exception $Error){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => language('common/main/main', 'tApproveFail')
            );
            echo json_encode($aReturn);
            return;
        }
    }

    public function FSoCTBIEventGetPdtIntDTBch(){
        try{
            $tTBODocNo =  $this->input->post('tTBODocNo');
            $tTBIDocNo =  $this->input->post('tTBIDocNo');
            $tTBIBchCodeTo =  $this->input->post('tTBIBchCode');

            $tTblSelectData = "TCNTPdtTBIHD";
            $this->Transferreceiptbranch_model->FSxMTBIClearPdtInTmp($tTblSelectData);


            $aDataTBIGetPdtIntBch = array(
                'tTBODocNo' => $tTBODocNo ,
                'tTBIDocNo' => $tTBIDocNo ,
                'tTBIBchCodeTo' => $tTBIBchCodeTo,
                'tTBISesUsername' => $this->session->userdata('tSesUsername'),
                'tTBISessionID' => $this->session->userdata('tSesSessionID'),
            );
            $aPdtDataResult = $this->Transferreceiptbranch_model->FSoMTBIEventGetPdtIntDTBch($aDataTBIGetPdtIntBch); 
              
            $aDataWhere = array(
                'FTBchCode'     => $tTBIBchCodeTo,
                'FTXthDocNo'    => $tTBIDocNo,
                'FTXthDocKey'   => 'TCNTPdtTbiHD',
            );

            if(!empty($aPdtDataResult)){
                foreach($aPdtDataResult AS $aData){


                    $cTBIPrice    = $this->Transferreceiptbranch_model->FSaMTBIGetPriceBYPDT($aData['FTPdtCode']);
                    if($cTBIPrice[0]->PDTCostSTD == null){
                        $nPrice = 0;
                    }else{
                        $nPrice = $cTBIPrice[0]->PDTCostSTD;
                    }

            $aDataPdtParams = array(
                'tPdtCode'          => $aData['FTPdtCode'],
                'tBarCode'          => $aData['FTXtdBarCode'],
                'tPunCode'          => $aData['FTPunCode'],
                'FCXtdQty'          => $aData['FCXtdQty'],
                'FCXtdQtyAll'       => $aData['FCXtdQtyAll'],
                'nLngID'            => $this->session->userdata("tLangEdit")
            );


            $nTBIMaxSeqNo = $this->Transferreceiptbranch_model->FSaMTBIGetMaxSeqDocDTTemp($aDataWhere);

            $aDataPdtParams = array(
                'tDocNo'            => $tTBIDocNo,
                'tBchCode'          => $tTBIBchCodeTo,
                'tPdtCode'          => $aData['FTPdtCode'],
                'tBarCode'          => $aData['FTXtdBarCode'],
                'tPunCode'          => $aData['FTPunCode'],
                'FCXtdQty'          => $aData['FCXtdQty'],
                'FCXtdQtyAll'       => $aData['FCXtdQtyAll'],
                'cPrice'            => $nPrice,
                'nMaxSeqNo'         => $nTBIMaxSeqNo + 1,
                'nLngID'            => $this->session->userdata("tLangID"),
                'tSessionID'        => $this->session->userdata('tSesSessionID'),
                'tDocKey'           => 'TCNTPdtTbiHD',
                'tDocRefSO'         => $tTBODocNo
            );


            // Data Master Pdt ข้อมูลรายการสินค้าที่เพิ่มเข้ามา
            $aDataPdtMaster  = $this->Transferreceiptbranch_model->FSaMTBIGetDataPdt($aDataPdtParams);
            // INSERT Pdt INT To Temp
            $aDocDTTmpResult    = $this->Transferreceiptbranch_model->FSoMTBIEventInsertPdtIntDTBchToTemp($aDataPdtMaster,$aDataPdtParams); 

            }
        }

          

            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg'    => 'ok'
            );
            echo json_encode($aReturn);
        }catch(Exception $Error){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => 'Fail'
            );
            echo json_encode($aReturn);
            return;
        }
    }
    
}
