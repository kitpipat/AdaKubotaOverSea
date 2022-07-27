<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transferwarehouseout_controller extends MX_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('document/transferwarehouseout/Transferwarehouseout_model');
        $this->load->model('company/company/Company_model');
        $this->load->model('payment/rate/Rate_model');

    }

    public function index($nBrowseType, $tBrowseOption ,$nDocType){
        $aDataConfigView    = array(
            'nBrowseType'       => $nBrowseType,  
            'tBrowseOption'     => $tBrowseOption, 
            'nDocType'          => $nDocType,
            'aPermission'       => FCNaHCheckAlwFunc('TWO/0/0/'.$nDocType),
            'vBtnSave'          => FCNaHBtnSaveActiveHTML('TWO/0/0/'.$nDocType), 
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(), 
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave() 
        );
   
        $this->load->view('document/transferwarehouseout/wTransferwarehouseout',$aDataConfigView);
    }

    //Page - List
    public function FSxCTWOTransferwarehouseoutList(){
        $this->load->view('document/transferwarehouseout/wTransferwarehouseoutSearchList');    
    }

    //Page - DataTable
    public function FSxCTWOTransferwarehouseoutDataTable(){
        $tAdvanceSearchData     = $this->input->post('oAdvanceSearch');
        $nPage                  = $this->input->post('nPageCurrent');
        $nTWODocType            = $this->input->post('nTWODocType');
        $aAlwEvent              = FCNaHCheckAlwFunc('TWO/0/0/'.$nTWODocType);
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
            'aAdvanceSearch'    => $tAdvanceSearchData,
            'nTWODocType'       => $nTWODocType
        );

        $aResList   = $this->Transferwarehouseout_model->FSaMTWOList($aData);
        $aGenTable  = array(
            'aAlwEvent'         => $aAlwEvent,
            'aDataList'         => $aResList,
            'nPage'             => $nPage,
            'nOptDecimalShow'   => $nOptDecimalShow
        );

        $tTWOViewDataTable = $this->load->view('document/transferwarehouseout/wTransferwarehouseoutDataTable', $aGenTable ,true);
        $aReturnData = array(
            'tViewDataTable'    => $tTWOViewDataTable,
            'nStaEvent'         => '1',
            'tStaMessg'         => 'Success'
        );
        echo json_encode($aReturnData);
    }

    //Page - Add
    public function FSvCTWOTransferwarehouseoutPageAdd(){
        try{
            // Clear Product List IN Doc Temp
            $tTblSelectData = "TCNTPdtTwoHD";
            $this->Transferwarehouseout_model->FSxMTWOClearPdtInTmp($tTblSelectData);

            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            // Get Option Doc Save
            $nOptDocSave        = FCNnHGetOptionDocSave();
            // Get Option Scan SKU
            $nOptScanSku        = FCNnHGetOptionScanSku();
            //Lang ภาษา
            $nLangEdit          = $this->session->userdata("tLangEdit");

            // VAT
            $aDataWhere         = array('FNLngID' => $nLangEdit);
            $tAPIReq            = "";
            $tMethodReq         = "GET";
            $aCompData          = $this->Company_model->FSaMCMPList($tAPIReq,$tMethodReq,$aDataWhere);  

 
            $tCmpCode           = $aCompData['raItems']['rtCmpCode'];

            if($aCompData['rtCode'] == '1'){
                $tBchCode       = $aCompData['raItems']['rtCmpBchCode'];
                $tCmpRteCode    = $aCompData['raItems']['rtCmpRteCode'];
                $tVatCode       = $aCompData['raItems']['rtVatCodeUse'];
                $aVatRate       = FCNoHCallVatlist($tVatCode); 
                $cVatRate       = $aVatRate['FCVatRate'][0];
                $aDataRate      = array(
                    'FTRteCode' => $tCmpRteCode,
                    'FNLngID'   => $nLangEdit
                );
                $aResultRte     = $this->Rate_model->FSaMRTESearchByID($aDataRate);
                if($aResultRte['rtCode'] == 1){
                    $cXthRteFac = $aResultRte['raItems']['rcRteRate'];
                }else{
                    $cXthRteFac = "";
                }
            }else{
                $tBchCode       = FCNtGetBchInComp();
                $tCmpRteCode    = "";
                $tVatCode       = "";
                $cVatRate       = "";
                $cXthRteFac     = "";
            }

            // Get Department Code
            $tUsrLogin  = $this->session->userdata('tSesUsername');
            $tDptCode   = FCNnDOCGetDepartmentByUser($tUsrLogin);

            // Get ข้อมูลสาขา และ ร้านค้าของ User ที่ login
            $aDataShp   = array(
                'FNLngID'   => $nLangEdit,
                'tUsrLogin' => $tUsrLogin
            );
            $aDataUserGroup = $this->Transferwarehouseout_model->FSaMASTGetShpCodeForUsrLogin($aDataShp);
    
            if(empty($aDataUserGroup)){
                $tBchCode   = "";
                $tBchName   = "";
                $tMerCode   = "";
                $tMerName   = "";
                $tShpType   = "";
                $tShpCode   = "";
                $tShpName   = "";
                $tWahCode   = "";
                $tWahName   = "";
            }else{
                $tBchCode   = $tBchCode;
                $tBchName   = "";
                $tMerCode   = "";
                $tMerName   = "";
                $tShpType   = "";
                $tShpCode   = "";
                $tShpName   = "";
                $tWahCode   = "";
                $tWahName   = "";

                // เช็ค user ว่ามีการผูกสาขาไว้หรือไม่
                if(isset($aDataUserGroup["FTBchCode"]) && !empty($aDataUserGroup["FTBchCode"])){
                    $tBchCode   = $aDataUserGroup["FTBchCode"];
                    $tBchName   = $aDataUserGroup["FTBchName"];
                }

                // เช็ค user ว่ามีการผูกกลุ่มร้านค้าไว้หรือไม่
                if(isset($aDataUserGroup["FTMerCode"]) && !empty($aDataUserGroup["FTMerCode"])){
                    $tMerCode   = $aDataUserGroup["FTMerCode"];
                    $tMerName   = $aDataUserGroup["FTMerName"];
                }

                // เช็ค user ว่ามีการผูกร้านค้าไว้หรือไม่
                $tShpType   = $aDataUserGroup["FTShpType"];
                if(isset($aDataUserGroup["FTShpCode"]) && !empty($aDataUserGroup["FTShpCode"])){
                    $tShpCode   = $aDataUserGroup["FTShpCode"];
                    $tShpName   = $aDataUserGroup["FTShpName"];
                }

                if(isset($aDataUserGroup["FTWahCode"]) && !empty($aDataUserGroup["FTWahCode"])){
                    $tWahCode   = $aDataUserGroup["FTWahCode"];
                    $tWahName   = $aDataUserGroup["FTWahName"];
                }
            }

            $aDataConfigViewAdd = array(
                'nOptDecimalShow'   => $nOptDecimalShow,
                'nOptDocSave'       => $nOptDocSave,
                'nOptScanSku'       => $nOptScanSku,
                'tCmpRteCode'       => $tCmpRteCode,
                'tVatCode'          => $tVatCode,
                'cVatRate'          => $cVatRate,
                'cXthRteFac'        => $cXthRteFac,
                'tDptCode'          => $tDptCode,
                'tBchCode'          => $tBchCode,
                'tBchName'          => $tBchName,
                'tMerCode'          => $tMerCode,
                'tMerName'          => $tMerName,
                'tShpType'          => $tShpType,
                'tShpCode'          => $tShpCode,
                'tShpName'          => $tShpName,
                'tWahCode'          => $tWahCode,
                'tWahName'          => $tWahName,
                'aDataDocHD'        => array('rtCode'=>'99'),
                'tBchCompCode'      => FCNtGetBchInComp(),
                'tBchCompName'      => FCNtGetBchNameInComp(),
                'tCmpCode'          => $tCmpCode  
            );

            $tViewPageAdd       = $this->load->view('document/transferwarehouseout/wTransferwarehouseoutPageAdd',$aDataConfigViewAdd,true);
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

    //Page - Edit
    public function FSvCTWOTransferwarehouseoutPageEdit(){
        try {

            $tTWODocNo   = $this->input->post('ptDocNumber');
            $nTWODocType = $this->input->post('nTWODocType');
            
            // Clear Data In Doc DT Temp
            $aWhereClearTemp = [
                'FTXthDocNo'    => $tTWODocNo,
                'FTXthDocKey'   => 'TCNTPdtTwoHD',
                'FTSessionID'   => $this->session->userdata('tSesSessionID')
            ];
            $this->Transferwarehouseout_model->FSxMTWOClearPdtInTmp($aWhereClearTemp);

            $aAlwEvent          = FCNaHCheckAlwFunc('TWO/0/0/'.$nTWODocType);
            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            // Get Option Doc Save
            $nOptDocSave        = FCNnHGetOptionDocSave();
            // Get Option Scan SKU
            $nOptScanSku        = FCNnHGetOptionScanSku();
            //Lang ภาษา
            $nLangEdit          = $this->session->userdata("tLangEdit");

            // Get Department Code
            $tUsrLogin  = $this->session->userdata('tSesUsername');
            $tDptCode   = FCNnDOCGetDepartmentByUser($tUsrLogin);

            // Get ข้อมูลสาขา และ ร้านค้าของ User ที่ login
            $tUsrLogin = $this->session->userdata('tSesUsername');
            $aDataShp = array(
                'FNLngID'   => $nLangEdit,
                'tUsrLogin' => $tUsrLogin
            );

            // VAT
            $aDataWhere         = array('FNLngID' => $nLangEdit);
            $tAPIReq            = "";
            $tMethodReq         = "GET";
            $aCompData          = $this->Company_model->FSaMCMPList($tAPIReq,$tMethodReq,$aDataWhere);  
            $tCmpCode           = $aCompData['raItems']['rtCmpCode'];
            if($aCompData['rtCode'] == '1'){
                $tBchCode       = $aCompData['raItems']['rtCmpBchCode'];
                $tCmpRteCode    = $aCompData['raItems']['rtCmpRteCode'];
                $tVatCode       = $aCompData['raItems']['rtVatCodeUse'];
                $aVatRate       = FCNoHCallVatlist($tVatCode); 
                $cVatRate       = $aVatRate['FCVatRate'][0];
                $aDataRate      = array(
                    'FTRteCode' => $tCmpRteCode,
                    'FNLngID'   => $nLangEdit
                );
                $aResultRte     = $this->Rate_model->FSaMRTESearchByID($aDataRate);
                if($aResultRte['rtCode'] == 1){
                    $cXthRteFac = $aResultRte['raItems']['rcRteRate'];
                }else{
                    $cXthRteFac = "";
                }
            }else{
                $tBchCode       = FCNtGetBchInComp();
                $tCmpRteCode    = "";
                $tVatCode       = "";
                $cVatRate       = "";
                $cXthRteFac     = "";
            }

            $aDataUserGroup = $this->Transferwarehouseout_model->FSaMASTGetShpCodeForUsrLogin($aDataShp);
            if (isset($aDataUserGroup) && empty($aDataUserGroup)) {
                $tUsrBchCode    = "";
                $tUsrBchName    = "";
                $tUsrMerCode    = "";
                $tUsrMerName    = "";
                $tUsrShopType   = "";
                $tUsrShopCode   = "";
                $tUsrShopName   = "";
                $tUsrWahCode    = "";
                $tUsrWahName    = "";
            } else {
                $tUsrBchCode    = $aDataUserGroup["FTBchCode"];
                $tUsrBchName    = $aDataUserGroup["FTBchName"];
                $tUsrMerCode    = $aDataUserGroup["FTMerCode"];
                $tUsrMerName    = $aDataUserGroup["FTMerName"];
                $tUsrShopType   = $aDataUserGroup["FTShpType"];
                $tUsrShopCode   = $aDataUserGroup["FTShpCode"];
                $tUsrShopName   = $aDataUserGroup["FTShpName"];
                $tUsrWahCode    = $aDataUserGroup["FTWahCode"];
                $tUsrWahName    = $aDataUserGroup["FTWahName"];
            }

            // Data Table Document
            $aTableDocument = array(
                'tTableHD'      => 'TCNTPdtTwoHD',
                'tTableHDCst'   => '',
                'tTableHDDis'   => '',
                'tTableDT'      => 'TCNTPdtTwODT',
                'tTableDTDis'   => ''
            );

            // Array Data Where Get (HD,HDSpl,HDDis,DT,DTDis)
            $aDataWhere = array(
                'FTXthDocNo'    => $tTWODocNo,
                'FTXthDocKey'   => 'TCNTPdtTwoHD',
                'FNLngID'       => $nLangEdit,
                'nRow'          => 10000,
                'nPage'         => 1,
            );
            $this->db->trans_begin();

            // Get Data Document HD
            $aDataDocHD = $this->Transferwarehouseout_model->FSaMTWOGetDataDocHD($aDataWhere);

            if(!empty($aDataDocHD['raItems']['FTXthShopTo'])){
                $aDataWhereAddress = array(
                    'FTAddGrpType' => 4,
                    'FTAddRefCode' => $aDataDocHD['raItems']['FTXthShopTo']
                );
            }else{
                $aDataWhereAddress = array(
                    'FTAddGrpType' => 1,
                    'FTAddRefCode' => $aDataDocHD['raItems']['FTBchCode']
                );
            }
     
            // Get Data Document HDRef
            $aDataDocHDRef = $this->Transferwarehouseout_model->FSaMTWOGetDataDocHDRef($aDataWhere,$aDataWhereAddress);

            // Move Data DT TO DTTemp
            $this->Transferwarehouseout_model->FSxMTWOMoveDTToDTTemp($aDataWhere);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Query Call Edit Page.'
                );
            } else {
                $this->db->trans_commit();
                $tTWOVATInOrEx = ($aDataDocHD['rtCode'] == '1') ? $aDataDocHD['raItems']['FTXthVATInOrEx'] : 1;
                $aCalcDTTempParams = array(
                    'tDataDocEvnCall'   => '1',
                    'tDataVatInOrEx'    => $tTWOVATInOrEx,
                    'tDataDocNo'        => $tTWODocNo,
                    'tDataDocKey'       => 'TCNTPdtTwoHD',
                    'tDataSeqNo'        => ""
                );
                FCNbHCallCalcDocDTTemp($aCalcDTTempParams);

                $aDataConfigViewAdd = array(
                    'nOptDecimalShow'   => $nOptDecimalShow,
                    'nOptDocSave'       => $nOptDocSave,
                    'nOptScanSku'       => $nOptScanSku,
                    'tCmpRteCode'       => $tCmpRteCode,
                    'tVatCode'          => $tVatCode,
                    'cVatRate'          => $cVatRate,
                    'cXthRteFac'        => $cXthRteFac,
                    'tDptCode'          => $tDptCode,
                    'tBchCode'          => $tUsrBchCode,
                    'tBchName'          => $tUsrBchName,
                    'tMerCode'          => $tUsrMerCode,
                    'tMerName'          => $tUsrMerName,
                    'tShpType'          => $tUsrShopType,
                    'tShpCode'          => $tUsrShopCode,
                    'tShpName'          => $tUsrShopName,
                    'tWahCode'          => $tUsrWahCode,
                    'tWahName'          => $tUsrWahName,
                    'aDataDocHD'        => $aDataDocHD,
                    'aDataDocHDRef'     => $aDataDocHDRef,
                    'tBchCompCode'      => FCNtGetBchInComp(),
                    'tBchCompName'      => FCNtGetBchNameInComp(),
                    'tCmpCode'          => $tCmpCode ,
                    'aAlwEvent'         => $aAlwEvent
                );

                $tViewPageAdd   = $this->load->view('document/transferwarehouseout/wTransferwarehouseoutPageAdd', $aDataConfigViewAdd, true);
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
    public function FSoCTWOPdtAdvTblLoadData() {
        try {
            $tTWODocNo                = $this->input->post('ptTWODocNo');
            $tTWOStaApv               = $this->input->post('ptTWOStaApv');
            $tTWOStaDoc               = $this->input->post('ptTWOStaDoc');
            $nTWOPageCurrent          = $this->input->post('pnTWOPageCurrent');
            $tSearchPdtAdvTable       = $this->input->post('ptSearchPdtAdvTable');
            $tVat                     = 1;
            // Edit in line
            $tTWOPdtCode              = '';
            $tTWOPunCode              = '';

            //Get Option Show Decimal
            $nOptDecimalShow            = FCNxHGetOptionDecimalShow();

            // Call Advance Table
            $tTableGetColumeShow        = 'TCNTPdtTwODT';
            $aColumnShow                = FCNaDCLGetColumnShow($tTableGetColumeShow);
            
            $aDataWhere = array(
                'tSearchPdtAdvTable'    => $tSearchPdtAdvTable,
                'FTXthDocNo'            => $tTWODocNo,
                'FTXthDocKey'           => 'TCNTPdtTwoHD',
                'nPage'                 => $nTWOPageCurrent,
                'nRow'                  => 10,
                'FTSessionID'           => $this->session->userdata('tSesSessionID'),
            );

            // Calcurate Document DT Temp Array Parameter
            $aCalcDTParams = [
                'tDataDocEvnCall'       => '1',
                'tDataVatInOrEx'        => $tVat,
                'tDataDocNo'            => $tTWODocNo,
                'tDataDocKey'           => 'TCNTPdtTwoHD',
                'tDataSeqNo'            => ''
            ];
            FCNbHCallCalcDocDTTemp($aCalcDTParams);

            // $aDataDocDTTemp     = $this->Transferwarehouseout_model->FSaMTWOGetDocDTTempListPage($aDataWhere);
            // $aDataDocDTTempSum  = $this->Transferwarehouseout_model->FSaMTWOSumDocDTTemp($aDataWhere);

            $aDataDocDTTemp     = $this->Transferwarehouseout_model->FSaMTWOGetDocDTTempListPage($aDataWhere);
            $aDataDocDTTempSum  = '';

            $nLangEdit          = $this->session->userdata("tLangEdit");
            $aDataWhere = array(
                'FTXthDocNo'    => $tTWODocNo,
                'FTXthDocKey'   => 'TCNTPdtTwoHD',
                'FNLngID'       => $nLangEdit,
                'nRow'          => 10000,
                'nPage'         => 1,
            );
            
            // Get Data Document HD
            $aDataDocHD = $this->Transferwarehouseout_model->FSaMTWOGetDataDocHD($aDataWhere);
            if($aDataDocHD['rtCode'] == "800"){
                $tBchCode = $this->input->post('tBCHCode');
            }else{
                $tBchCode = $aDataDocHD['raItems']['FTBchCode'];
            }
            
            $aDataView = array(
                'nOptDecimalShow'       => $nOptDecimalShow,
                'tTWOStaApv'            => $tTWOStaApv,
                'tTWOStaDoc'            => $tTWOStaDoc,
                'tTWOPdtCode'           => @$tTWOPdtCode,
                'tTWOPunCode'           => @$tTWOPunCode,
                'nPage'                 => $nTWOPageCurrent,
                'aColumnShow'           => $aColumnShow,
                'aDataDocDTTemp'        => $aDataDocDTTemp,
                'aDataDocDTTempSum'     => $aDataDocDTTempSum
            );

            $tTWOPdtAdvTableHtml = $this->load->view('document/transferwarehouseout/wTransferwarehouseoutPdtAdvTableData', $aDataView, true);

            // Call Footer Document
            $aEndOfBillParams = array(
                'tSplVatType'   => $tVat,
                'tDocNo'        => $tTWODocNo,
                'tDocKey'       => 'TCNTPdtTwoHD',
                'nLngID'        => FCNaHGetLangEdit(),
                'tSesSessionID' => $this->session->userdata('tSesSessionID'),
                'tBchCode'      => $tBchCode
            );

            // $aTWOEndOfBill['aEndOfBillVat']  = FCNaDOCEndOfBillCalVat($aEndOfBillParams);
            // $aTWOEndOfBill['aEndOfBillCal']  = FCNaDOCEndOfBillCal($aEndOfBillParams);
            // $aTWOEndOfBill['tTextBath']      = FCNtNumberToTextBaht($aTWOEndOfBill['aEndOfBillCal']['cCalFCXphGrand']);
            $aReturnData = array(
                'tTWOPdtAdvTableHtml'   => $tTWOPdtAdvTableHtml,
                'aTWOEndOfBill'         => '',
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
    public function FSoCTWOAdvTblShowColList() {
        try {
            $tTableShowColums = 'TCNTPdtTwODT';
            $aAvailableColumn = FCNaDCLAvailableColumn($tTableShowColums);
            $aDataViewAdvTbl = array(
                'aAvailableColumn' => $aAvailableColumn
            );
            $tViewTableShowCollist = $this->load->view('document/transferwarehouseout/advancetable/wTransferrenceiptNewTableShowColList', $aDataViewAdvTbl, true);
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
    public function FSoCTWOAdvTalShowColSave() {
        try {
            $this->db->trans_begin();

            $nTWOStaSetDef       = $this->input->post('pnTWOStaSetDef');
            $aTWOColShowSet      = $this->input->post('paTWOColShowSet');
            $aTWOColShowAllList  = $this->input->post('paTWOColShowAllList');
            $aTWOColumnLabelName = $this->input->post('paTWOColumnLabelName');
            
            $tTableShowColums    = "TCNTPdtTwODT";
            FCNaDCLSetShowCol($tTableShowColums, '', '');
            if ($nTWOStaSetDef == '1') {
                FCNaDCLSetDefShowCol($tTableShowColums);
            } else {
                for ($i = 0; $i < count($aTWOColShowSet); $i++) {
                    FCNaDCLSetShowCol($tTableShowColums, 1, $aTWOColShowSet[$i]);
                }
            }

            // Reset Seq Advannce Table
            FCNaDCLUpdateSeq($tTableShowColums, '', '', '');
            $q = 1;
            for ($n = 0; $n < count($aTWOColShowAllList); $n++) {
                FCNaDCLUpdateSeq($tTableShowColums, $aTWOColShowAllList[$n], $q, $aTWOColumnLabelName[$n]);
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
    public function FSoCTWOAddPdtIntoDocDTTemp() {
        try {
            $tTWOUserLevel       = $this->session->userdata('tSesUsrLevel');
            $tTWODocNo           = $this->input->post('tTWODocNo');
            $tTWOBchCode         = $this->input->post('tBchCode'); //($tTWOUserLevel == 'HQ') ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCode")
            $tTWOPdtData         = $this->input->post('tTWOPdtData');
            $aTWOPdtData         = JSON_decode($tTWOPdtData);
            $tTWOVATInOrEx       = 1;
            $tTypeInsPDT         = $this->input->post('tType');

            $aDataWhere = array(
                'FTBchCode'     => $tTWOBchCode,
                'FTXthDocNo'    => $tTWODocNo,
                'FTXthDocKey'   => 'TCNTPdtTwoHD',
            );
            $this->db->trans_begin();

            // ทำทีรายการ ตามรายการสินค้าที่เพิ่มเข้ามา
            for ($nI = 0; $nI<count($aTWOPdtData); $nI++) {

                $aItem       = $aTWOPdtData[$nI];
                if($tTypeInsPDT == 'CN'){
                    $tDocRefSO      = $aItem->tDocNo;
                    $tSeqItemSO     = $aItem->ptSeqItem;
                }else if($tTypeInsPDT == 'PDT'){
                    $tDocRefSO      = '';
                    $tSeqItemSO     = '';
                }

                $tTWOPdtCode = $aItem->pnPdtCode;
                $tTWOBarCode = $aItem->ptBarCode;
                $tTWOPunCode = $aItem->ptPunCode;

                $cTWOPrice    = $this->Transferwarehouseout_model->FSaMTWOGetPriceBYPDT($tTWOPdtCode);
                if($cTWOPrice[0]->PDTCostSTD == null){
                    $nPrice = 0;
                }else{
                    $nPrice = $cTWOPrice[0]->PDTCostSTD;
                }

                $nTWOMaxSeqNo = $this->Transferwarehouseout_model->FSaMTWOGetMaxSeqDocDTTemp($aDataWhere);
                $aDataPdtParams = array(
                    'tDocNo'            => $tTWODocNo,
                    'tBchCode'          => $tTWOBchCode,
                    'tPdtCode'          => $tTWOPdtCode,
                    'tBarCode'          => $tTWOBarCode,
                    'tPunCode'          => $tTWOPunCode,
                    'cPrice'            => $nPrice,
                    'nMaxSeqNo'         => $nTWOMaxSeqNo + 1,
                    'nLngID'            => $this->session->userdata("tLangID"),
                    'tSessionID'        => $this->session->userdata('tSesSessionID'),
                    'tDocKey'           => 'TCNTPdtTwoHD',
                    'tDocRefSO'         => $tDocRefSO
                );

                // Data Master Pdt ข้อมูลรายการสินค้าที่เพิ่มเข้ามา
                $aDataPdtMaster     = $this->Transferwarehouseout_model->FSaMTWOGetDataPdt($aDataPdtParams);
                // นำรายการสินค้าเข้า DT Temp
                $nStaInsPdtToTmp    = $this->Transferwarehouseout_model->FSaMTWOInsertPDTToTemp($aDataPdtMaster, $aDataPdtParams);

                //ถ้าเลือกนำเข้าข้อมูล จะต้องไปทำให้สินค้าใน CN ว่าถูกใช้งานแล้ว
                if($tTypeInsPDT == 'CN'){
                    //$this->Transferwarehouseout_model->FSaMTWOUpdatePDTInCN($tDocRefSO,$tSeqItemSO);
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
                    'tDataVatInOrEx'    => $tTWOVATInOrEx,
                    'tDataDocNo'        => $tTWODocNo,
                    'tDataDocKey'       => 'TCNTPdtTwoHD',
                    'tDataSeqNo'        => ''
                ];
                $tStaCalcuRate = FCNbHCallCalcDocDTTemp($aCalcDTParams);
                if ($tStaCalcuRate === TRUE) {
                    // Prorate HD
                    FCNaHCalculateProrate('TCNTPdtTwoHD', $tTWODocNo);
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
    public function FSoCTWODeleteEventDoc(){
        try{    
            $tTWODocNo  = $this->input->post('tTWODocNo');
            $aDataMaster = array(
                'tTWODocNo'     => $tTWODocNo
            );
            $aResDelDoc = $this->Transferwarehouseout_model->FSnMTWODelDocument($aDataMaster);
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
    public function FSvCTWORemovePdtInDTTmp() {
        try {
            $this->db->trans_begin();

            $aDataWhere = array(
                // 'tBchCode'      => $this->session->userdata('tSesUsrLevel') == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata('tSesUsrBchCode'),
                'tBchCode'      => $this->input->post('tBchCode'),
                'tDocNo'        => $this->input->post('tDocNo'),
                'tPdtCode'      => $this->input->post('tPdtCode'),
                'nSeqNo'        => $this->input->post('nSeqNo'),
                'tVatInOrEx'    => $this->input->post('tVatInOrEx'),
                'tSessionID'    => $this->session->userdata('tSesSessionID')
            );
            $this->Transferwarehouseout_model->FSnMTWODelPdtInDTTmp($aDataWhere);
            
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
                    'tDataDocKey'       => 'TCNTPdtTwoHD',
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
    public function FSvCTWORemovePdtInDTTmpMulti() {
        try {
            $this->db->trans_begin();
            $aDataWhere = array(
                // 'tBchCode'      => $this->session->userdata('tSesUsrLevel') == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata('tSesUsrBchCode'),
                'tBchCode'      => $this->input->post('ptTWOBchCode'),
                'tDocNo'        => $this->input->post('ptTWODocNo'),
                'tVatInOrEx'    => $this->input->post('ptTWOVatInOrEx'),
                'aDataPdtCode'  => $this->input->post('paDataPdtCode'),
                'aDataPunCode'  => $this->input->post('paDataPunCode'),
                'aDataSeqNo'    => $this->input->post('paDataSeqNo')
            );

            $this->Transferwarehouseout_model->FSnMTWODelMultiPdtInDTTmp($aDataWhere);

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
                    'tDataDocKey'       => 'TCNTPdtTwoHD',
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
    public function FSoCTWOAddEventDoc(){
        try {
            $aDataDocument   = $this->input->post();
            $tTWOAutoGenCode = (isset($aDataDocument['ocbTWOStaAutoGenCode'])) ? 1 : 0;
            $tTWODocNo       = (isset($aDataDocument['oetTWODocNo'])) ? $aDataDocument['oetTWODocNo'] : '';
            $tTWODocDate     = $aDataDocument['oetTWODocDate'] . " " . $aDataDocument['oetTWODocTime'];
            $tTWOVATInOrEx   = 1;
            $tTWOSessionID   = $this->session->userdata('tSesSessionID');
            $tTWOStaDocAct          = (isset($aDataDocument['ocbTWOStaDocAct'])) ? 1 : 0;

            // Get Data Comp.
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aDataWhereComp = array('FNLngID' => $nLangEdit);
            $tAPIReq        = "";
            $tMethodReq     = "GET";
            $aCompData      = $this->Company_model->FSaMCMPList($tAPIReq, $tMethodReq, $aDataWhereComp);

            $aCalDTTempParams = [
                'tDocNo'        => '',
                // 'tBchCode'      => $this->session->userdata('tSesUsrLevel') == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata('tSesUsrBchCode'),
                'tBchCode'      => $aDataDocument['oetSOFrmBchCode'],
                'tSessionID'    => $tTWOSessionID,
                'tDocKey'       => 'TCNTPdtTwoHD'
            ];
            $aCalDTTempForHD = $this->FSaCTWOCalDTTempForHD($aCalDTTempParams);

            // Array Data Table Document
            $aTableAddUpdate = array(
                'tTableHD'      => 'TCNTPdtTwoHD',
                'tTableHDDis'   => '-',
                'tTableHDSpl'   => '-',
                'tTableDT'      => 'TCNTPdtTwoDT',
                'tTableDTDis'   => '-',
                'tTableStaGen'  => $aDataDocument['ocmSelectTransferDocument']
            );

            // Array Data Where Insert
            $aDataWhere = array(
                // 'FTBchCode'         => $this->session->userdata('tSesUsrLevel') == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata('tSesUsrBchCode'),
                'FTBchCode'         => $aDataDocument['oetSOFrmBchCode'],
                'FTXthDocNo'        => $tTWODocNo,
                'FDLastUpdOn'       => date('Y-m-d'),
                'FDCreateOn'        => date('Y-m-d'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FTSessionID'       => $this->session->userdata('tSesSessionID'),
                'FTXthVATInOrEx'    => $tTWOVATInOrEx
            );

            //เงือนไขของ HD
            if($aDataDocument['ocmSelectTransferDocument'] == 4){
                //ประเภทคลังสินค้า
                $tRsnType = 1;

                //ร้านค้า
                $tShopFrm = $aDataDocument['oetTROutShpFromCode']  == '' ? null : $aDataDocument['oetTROutShpFromCode'];
                $tShopTo  = $aDataDocument['oetTROutShpToCode']  == '' ? null : $aDataDocument['oetTROutShpToCode'];

                //คลัง
                $tWahFrm  = $aDataDocument['oetTROutWahFromCode']  == '' ? null : $aDataDocument['oetTROutWahFromCode'];
                $tWahTo   = $aDataDocument['oetTROutWahToCode']  == '' ? null : $aDataDocument['oetTROutWahToCode'];

                //เครื่องจุดขาย
                // $tPosFrm  = $aDataDocument['oetTROutPosFromCode']  == '' ? null : $aDataDocument['oetTROutPosFromCode'];
                // $tPosTo   = $aDataDocument['oetTROutPosToCode']  == '' ? null : $aDataDocument['oetTROutPosToCode'];

                //ผู้จำหน่าย
                $tSplCode = null;

                //แหล่งอื่น
                $tOther   = null;
            }else{
                   //ร้านค้า
                   $tShopFrm = $aDataDocument['oetTROutShpFromCode']  == '' ? null : $aDataDocument['oetTROutShpFromCode'];
                     //คลัง
                   $tWahFrm  = $aDataDocument['oetTROutWahFromCode']  == '' ? null : $aDataDocument['oetTROutWahFromCode'];
                    //เครื่องจุดขาย
                //    $tPosFrm  = $aDataDocument['oetTROutPosFromCode']  == '' ? null : $aDataDocument['oetTROutPosFromCode'];

                if($aDataDocument['ocmSelectTransTypeIN'] == 'SPL'){
                    //ประเภทคลังสินค้า
                    $tRsnType = 3;

                    //ร้านค้า
                    $tShopFrm = $aDataDocument['oetTRINShpFromCode'] == '' ? null : $aDataDocument['oetTRINShpFromCode'];
                    $tShopTo  = null;

                    //คลัง
                  
                    $tWahTo   = null;

                    //ผู้จำหน่าย
                    $tSplCode = $aDataDocument['oetTRINSplFromCode'] == '' ? null : $aDataDocument['oetTRINSplFromCode'];

                    //แหล่งอื่น
                    $tOther   = null;
                }else{
                    //ประเภทคลังสินค้า
                    $tRsnType = 4;

                    //ร้านค้า
                    // $tShopFrm = null;
                    $tShopTo  = null;

                    //คลัง
             
                    $tWahTo   = null;

                    //ผู้จำหน่าย
                    $tSplCode = null;

                    //แหล่งอื่น
                    $tOther   = $aDataDocument['oetTWOINEtc'] == '' ? null : $aDataDocument['oetTWOINEtc'];
                }

                //เครื่องจุดขาย
           
                $tPosTo   = null;
            }

            // Array Data HD Master
            $aDataMaster = array(
                // 'FTBchCode'             => $this->session->userdata('tSesUsrLevel') == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata('tSesUsrBchCode'),
                'FTBchCode'             => $aDataDocument['oetSOFrmBchCode'],
                'FTXthDocNo'            => $tTWODocNo,
                'FNXthDocType'          => $aDataDocument['ocmSelectTransferDocument'],
                'FTXthRsnType'          => $tRsnType,
                'FDXthDocDate'          => (!empty($tTWODocDate)) ? $tTWODocDate : NULL,
                'FTXthVATInOrEx'        => $tTWOVATInOrEx,
                'FTDptCode'             => $this->session->userdata('tSesUsrDptCode') == '' ? null : $this->session->userdata('tSesUsrDptCode'),
                'FTXthMerCode'          => '',
                'FTXthShopFrm'          => $tShopFrm,
                'FTXthShopTo'           => $tShopTo,
                'FTXthWhFrm'            => $tWahFrm,
                'FTXthWhTo'             => $tWahTo,
                // 'FTXthPosFrm'           => $tPosFrm,
                // 'FTXthPosTo'            => $tPosTo,
                'FTSplCode'             => $tSplCode,
                'FTXthOther'            => $tOther,
                'FTUsrCode'             => $this->session->userdata('tSesUserCode'),
                'FTSpnCode'             => null,
                'FTXthApvCode'          => $this->session->userdata('tSesUsername'),
                'FTXthRefExt'           => $aDataDocument['oetTWORefExtDoc'],
                'FDXthRefExtDate'       => $aDataDocument['oetTWORefExtDocDate'],
                'FTXthRefInt'           => $aDataDocument['oetTWORefIntDoc'],
                'FDXthRefIntDate'       => $aDataDocument['oetTWORefIntDocDate'],
                'FNXthDocPrint'         => 0,
                'FCXthTotal'            => $aCalDTTempForHD['FCXphTotal'],
                'FCXthVat'              => $aCalDTTempForHD['FCXphVat'],
                'FCXthVatable'          => $aCalDTTempForHD['FCXphVatable'],
                'FTXthRmk'              => $aDataDocument['otaTWOFrmInfoOthRmk'],
                'FTXthStaDoc'           => 1, //สถานะ เอกสาร  1:สมบูรณ์, 2:ไม่สมบูรณ์, 3:ยกเลิก
                'FTXthStaApv'           => !empty($aDataDocument['ohdTWOStaApv']) ? $aDataDocument['ohdTWOStaApv'] : '',
                'FTXthStaPrcStk'        => !empty($aDataDocument['ohdTWOStaPrcStk']) ? $$aDataDocument['ohdTWOStaPrcStk'] : '',
                'FTXthStaDelMQ'         => !empty($aDataDocument['ohdTWOStaDelMQ']) ? $aDataDocument['ohdTWOStaDelMQ'] : NULL,
                // 'FNXthStaDocAct'        => $aDataDocument['ocbTWOStaDocAct'] == '' ? 0 : 1,
                'FNXthStaDocAct'        => $tTWOStaDocAct,
                'FNXthStaRef'           => 0,
                'FTRsnCode'             => $aDataDocument['oetTWOReasonCode'] == '' ? null : $aDataDocument['oetTWOReasonCode'],
                'FDLastUpdOn'           => date('Y-m-d'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                'FDCreateOn'            => date('Y-m-d'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername')
            );

            $aDataPdtTwoHDRef = array(
                'FTXthCtrName'        => $aDataDocument['oetTWOTransportCtrName'],
                'FDXthTnfDate'        => $aDataDocument['oetTWOTransportTnfDate'],
                'FTXthRefTnfID'       => $aDataDocument['oetTWOTransportRefTnfID'],
                'FTXthRefVehID'       => $aDataDocument['oetTWOTransportRefVehID'],
                'FTXthQtyAndTypeUnit' => $aDataDocument['oetTWOTransportQtyAndTypeUnit'],
                'FNXthShipAdd'        => $aDataDocument['ohdTWOShipAddSeqNo'],
                'FTViaCode'           => $aDataDocument['oetTWOUpVendingViaCode'],
            );

            $this->db->trans_begin();

            // Check Auto GenCode Document
            if ($tTWOAutoGenCode == '1') {
                $aStoreParam = array(
                    "tTblName"   => 'TCNTPdtTwoHD',                           
                    "tDocType"   => $aDataDocument['ocmSelectTransferDocument'],                                          
                    "tBchCode"   => $aDataDocument['oetSOFrmBchCode'],                                 
                    "tShpCode"   => "",                               
                    "tPosCode"   => "",                     
                    "dDocDate"   => date("Y-m-d H:i:s")       
                );
                $aAutogen   	          = FCNaHAUTGenDocNo($aStoreParam);
                $aDataWhere['FTXthDocNo'] = $aAutogen[0]["FTXxhDocNo"];
            } else {
                $aDataWhere['FTXthDocNo'] = $tTWODocNo;
            }

            // Add Update Document HD
            $this->Transferwarehouseout_model->FSxMTWOAddUpdateHD($aDataMaster, $aDataWhere, $aTableAddUpdate);

            // Add Update Document HDRef
            $this->Transferwarehouseout_model->FSxMTWOAddUpdateHDRef($aDataPdtTwoHDRef, $aDataWhere);

            // Update Doc No Into Doc Temp
            $this->Transferwarehouseout_model->FSxMTWOAddUpdateDocNoToTemp($aDataWhere, $aTableAddUpdate);

            // Move Doc DTTemp To DT
            $this->Transferwarehouseout_model->FSaMTWOMoveDtTmpToDt($aDataWhere, $aTableAddUpdate);

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
    public function FSoCTWOEditEventDoc(){
        try {
            $aDataDocument          = $this->input->post();
            $tTWOAutoGenCode        = (isset($aDataDocument['ocbTWOStaAutoGenCode'])) ? 1 : 0;
            $tTWODocNo              = (isset($aDataDocument['oetTWODocNo'])) ? $aDataDocument['oetTWODocNo'] : '';
            $tTWODocDate            = $aDataDocument['oetTWODocDate'] . " " . $aDataDocument['oetTWODocTime'];
            $tTWOStaDocAct          = (isset($aDataDocument['ocbTWOStaDocAct'])) ? 1 : 0;
            $tTWOVATInOrEx          = $aDataDocument['ohdTWOFrmSplInfoVatInOrEx'];
            $tTWOSessionID          = $this->session->userdata('tSesSessionID');

            // Get Data Comp.
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aDataWhereComp = array('FNLngID' => $nLangEdit);
            $tAPIReq        = "";
            $tMethodReq     = "GET";
            $aCompData      = $this->Company_model->FSaMCMPList($tAPIReq, $tMethodReq, $aDataWhereComp);

            $aCalDTTempParams = [
                'tDocNo'        => '',
                'tBchCode'      => $aDataDocument['ohdTWOBchCode'],
                'tSessionID'    => $tTWOSessionID,
                'tDocKey'       => 'TCNTPdtTwoHD'
            ];

            $aCalDTTempForHD    = $this->FSaCTWOCalDTTempForHD($aCalDTTempParams);

            // Array Data Table Document
            $aTableAddUpdate = array(
                'tTableHD'      => 'TCNTPdtTwoHD',
                'tTableHDDis'   => '-',
                'tTableHDSpl'   => '-',
                'tTableDT'      => 'TCNTPdtTwoDT',
                'tTableDTDis'   => '-',
                'tTableStaGen'  => 5
            );

            // Array Data Where Insert
            $aDataWhere = array(
                'FTBchCode'         => $aDataDocument['ohdTWOBchCode'],
                'FTXthDocNo'        => $tTWODocNo,
                'FDLastUpdOn'       => date('Y-m-d'),
                'FDCreateOn'        => date('Y-m-d'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FTSessionID'       => $this->session->userdata('tSesSessionID'),
                'FTXthVATInOrEx'    => $tTWOVATInOrEx
            );

               //เงือนไขของ HD
               if($aDataDocument['ocmSelectTransferDocument'] == 4){
                //ประเภทคลังสินค้า
                $tRsnType = 1;

                //ร้านค้า
                $tShopFrm = $aDataDocument['oetTROutShpFromCode']  == '' ? null : $aDataDocument['oetTROutShpFromCode'];
                $tShopTo  = $aDataDocument['oetTROutShpToCode']  == '' ? null : $aDataDocument['oetTROutShpToCode'];

                //คลัง
                $tWahFrm  = $aDataDocument['oetTROutWahFromCode']  == '' ? null : $aDataDocument['oetTROutWahFromCode'];
                $tWahTo   = $aDataDocument['oetTROutWahToCode']  == '' ? null : $aDataDocument['oetTROutWahToCode'];

                //เครื่องจุดขาย
                // $tPosFrm  = $aDataDocument['oetTROutPosFromCode']  == '' ? null : $aDataDocument['oetTROutPosFromCode'];
                // $tPosTo   = $aDataDocument['oetTROutPosToCode']  == '' ? null : $aDataDocument['oetTROutPosToCode'];

                //ผู้จำหน่าย
                $tSplCode = null;

                //แหล่งอื่น
                $tOther   = null;
            }else{
                   //ร้านค้า
                   $tShopFrm = $aDataDocument['oetTROutShpFromCode']  == '' ? null : $aDataDocument['oetTROutShpFromCode'];
                     //คลัง
                   $tWahFrm  = $aDataDocument['oetTROutWahFromCode']  == '' ? null : $aDataDocument['oetTROutWahFromCode'];
                    //เครื่องจุดขาย
                //    $tPosFrm  = $aDataDocument['oetTROutPosFromCode']  == '' ? null : $aDataDocument['oetTROutPosFromCode'];

                if($aDataDocument['ocmSelectTransTypeIN'] == 'SPL'){
                    //ประเภทคลังสินค้า
                    $tRsnType = 3;

                    //ร้านค้า
                    $tShopTo = $aDataDocument['oetTRINShpFromCode'] == '' ? null : $aDataDocument['oetTRINShpFromCode'];
             

                    //คลัง
                  
                    $tWahTo   = null;

                    //ผู้จำหน่าย
                    $tSplCode = $aDataDocument['oetTRINSplFromCode'] == '' ? null : $aDataDocument['oetTRINSplFromCode'];

                    //แหล่งอื่น
                    $tOther   = null;
                }else{
                    //ประเภทคลังสินค้า
                    $tRsnType = 4;

                    //ร้านค้า
                    // $tShopFrm = null;
                    $tShopTo  = null;

                    //คลัง
             
                    $tWahTo   = null;

                    //ผู้จำหน่าย
                    $tSplCode = null;

                    //แหล่งอื่น
                    $tOther   = $aDataDocument['oetTWOINEtc'] == '' ? null : $aDataDocument['oetTWOINEtc'];
                }

                //เครื่องจุดขาย
           
                $tPosTo   = null;
            }

            // Array Data HD Master
            $aDataMaster = array(
                'FTBchCode'             => $aDataDocument['ohdTWOBchCode'],
                'FTXthDocNo'            => $tTWODocNo,
                'FNXthDocType'          => $aDataDocument['ocmSelectTransferDocument'] ,
                'FTXthRsnType'          => $tRsnType,
                'FDXthDocDate'          => (!empty($tTWODocDate)) ? $tTWODocDate : NULL,
                'FTXthVATInOrEx'        => $tTWOVATInOrEx,
                'FTDptCode'             => $this->session->userdata('tSesUsrDptCode') == '' ? null : $this->session->userdata('tSesUsrDptCode'),
                'FTXthMerCode'          => '',
                'FTXthShopFrm'          => $tShopFrm,
                'FTXthShopTo'           => $tShopTo,
                'FTXthWhFrm'            => $tWahFrm,
                'FTXthWhTo'             => $tWahTo,
                // 'FTXthPosFrm'           => $tPosFrm,
                // 'FTXthPosTo'            => $tPosTo,
                'FTSplCode'             => $tSplCode,
                'FTXthOther'            => $tOther,
                'FTUsrCode'             => $this->session->userdata('tSesUserCode'),
                'FTSpnCode'             => null,
                'FTXthApvCode'          => $this->session->userdata('tSesUsername'),
                'FTXthRefExt'           => $aDataDocument['oetTWORefExtDoc'],
                'FDXthRefExtDate'       => $aDataDocument['oetTWORefExtDocDate'],
                'FTXthRefInt'           => $aDataDocument['oetTWORefIntDoc'],
                'FDXthRefIntDate'       => $aDataDocument['oetTWORefIntDocDate'],
                'FNXthDocPrint'         => 0,
                'FCXthTotal'            => $aCalDTTempForHD['FCXphTotal'],
                'FCXthVat'              => $aCalDTTempForHD['FCXphVat'],
                'FCXthVatable'          => $aCalDTTempForHD['FCXphVatable'],
                'FTXthRmk'              => $aDataDocument['otaTWOFrmInfoOthRmk'],
                'FTXthStaDoc'           => 1, //สถานะ เอกสาร  1:สมบูรณ์, 2:ไม่สมบูรณ์, 3:ยกเลิก
                'FTXthStaApv'           => !empty($aDataDocument['ohdTWOStaApv']) ? $aDataDocument['ohdTWOStaApv'] : '',
                'FTXthStaPrcStk'        => !empty($aDataDocument['ohdTWOStaPrcStk']) ? $$aDataDocument['ohdTWOStaPrcStk'] : '',
                'FTXthStaDelMQ'         => !empty($aDataDocument['ohdTWOStaDelMQ']) ? $aDataDocument['ohdTWOStaDelMQ'] : NULL,
                // 'FNXthStaDocAct'        => $aDataDocument['ocbTWOStaDocAct'] == '' ? 0 : 1,
                'FNXthStaDocAct'        =>$tTWOStaDocAct,
                'FNXthStaRef'           => 0,
                'FTRsnCode'             => $aDataDocument['oetTWOReasonCode'] == '' ? null : $aDataDocument['oetTWOReasonCode'],
                'FDLastUpdOn'           => date('Y-m-d'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
            );

            $aDataPdtTwoHDRef = array(
                'FTXthCtrName'        => $aDataDocument['oetTWOTransportCtrName'],
                'FDXthTnfDate'        => $aDataDocument['oetTWOTransportTnfDate'],
                'FTXthRefTnfID'       => $aDataDocument['oetTWOTransportRefTnfID'],
                'FTXthRefVehID'       => $aDataDocument['oetTWOTransportRefVehID'],
                'FTXthQtyAndTypeUnit' => $aDataDocument['oetTWOTransportQtyAndTypeUnit'],
                'FNXthShipAdd'        => $aDataDocument['ohdTWOShipAddSeqNo'],
                // 'FTViaCode'           => $aDataDocument['oetTWORefTransportNumber'],
            );

            $this->db->trans_begin();

            // Check Auto GenCode Document
            if ($tTWOAutoGenCode == '1') {
                $aStoreParam = array(
                    "tTblName"   => 'TCNTPdtTwoHD',                           
                    "tDocType"   => $aDataDocument['ocmSelectTransferDocument'],                                          
                    "tBchCode"   => $aDataDocument['ohdTWOBchCode'],                                 
                    "tShpCode"   => "",                               
                    "tPosCode"   => "",                     
                    "dDocDate"   => date("Y-m-d H:i:s")       
                );
                $aAutogen   	          = FCNaHAUTGenDocNo($aStoreParam);
                $aDataWhere['FTXthDocNo'] = $aAutogen[0]["FTXxhDocNo"];
            } else {
                $aDataWhere['FTXthDocNo'] = $tTWODocNo;
            }

            // Add Update Document HD
            $this->Transferwarehouseout_model->FSxMTWOAddUpdateHD($aDataMaster, $aDataWhere, $aTableAddUpdate);
       
            // Add Update Document HDRef
            $this->Transferwarehouseout_model->FSxMTWOAddUpdateHDRef($aDataPdtTwoHDRef, $aDataWhere);

            // Update Doc No Into Doc Temp
            $this->Transferwarehouseout_model->FSxMTWOAddUpdateDocNoToTemp($aDataWhere, $aTableAddUpdate);

            // Move Doc DTTemp To DT
            $this->Transferwarehouseout_model->FSaMTWOMoveDtTmpToDt($aDataWhere, $aTableAddUpdate);

         

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
    private function FSaCTWOCalDTTempForHD($paParams) {
        $aCalDTTemp = $this->Transferwarehouseout_model->FSaMTWOCalInDTTemp($paParams);
        if (isset($aCalDTTemp) && !empty($aCalDTTemp)) {
            $aCalDTTempItems = $aCalDTTemp[0];
            // คำนวณหา ยอดปัดเศษ ให้ HD(FCXphRnd)
            $pCalRoundParams = [
                'FCXphAmtV'     => $aCalDTTempItems['FCXphAmtV'],
                'FCXphAmtNV'    => $aCalDTTempItems['FCXphAmtNV']
            ];
            $aRound = $this->FSaCTWOCalRound($pCalRoundParams);
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
    private function FSaCTWOCalRound($paParams) {
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
    public function FSoCTWOEventCancel(){
        $tTWODocNo = $this->input->post('tTWODocNo');

        $aDataUpdate = array(
            'FTXthDocNo' => $tTWODocNo,
        );
        $aStaApv    = $this->Transferwarehouseout_model->FSvMTWOCancel($aDataUpdate); 
        
        //  //อัพเดทใน CN ให้กลับไปใช้งานได้
        // $this->Transferwarehouseout_model->FSvMCheckDocumentInCN('CANCEL',$aDataUpdate); 

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
    public function FSoCTWOEditPdtIntoDocDTTemp(){
        try {
            $tTWOBchCode    = $this->input->post('tTWOBchCode');
            $tTWODocNo      = $this->input->post('tTWODocNo');
            $tTWOVATInOrEx  = $this->input->post('tTWOVATInOrEx');
            $nTWOSeqNo      = $this->input->post('nTWOSeqNo');
            $tTWOFieldName  = $this->input->post('tTWOFieldName');
            $tTWOValue      = $this->input->post('tTWOValue');
            $tTWOSessionID  = $this->session->userdata('tSesSessionID');

            $aDataWhere = array(
                'tTWOBchCode'   => $tTWOBchCode,
                'tTWODocNo'     => $tTWODocNo,
                'nTWOSeqNo'     => $nTWOSeqNo,
                'tTWOSessionID' => $this->session->userdata('tSesSessionID'),
                'tDocKey'       => 'TCNTPdtTwoHD',
            );
            // print_r($aDataWhere);exit;
            $aDataUpdateDT = array(
                'tTWOFieldName'  => $tTWOFieldName,
                'tTWOValue'      => $tTWOValue
            );

            $this->db->trans_begin();
            $this->Transferwarehouseout_model->FSaMTWOUpdateInlineDTTemp($aDataUpdateDT, $aDataWhere);

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
                    'tDataVatInOrEx'    => $tTWOVATInOrEx,
                    'tDataDocNo'        => $tTWODocNo,
                    'tDataDocKey'       => 'TCNTPdtTwoHD',
                    'tDataSeqNo'        => $nTWOSeqNo
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
    public function FSoCTWOSelectPDTInCN(){
        $tBCHCode = $this->input->post('tBCHCode');
        $tSHPCode = $this->input->post('tSHPCode');
        $tWAHCode = $this->input->post('tWAHCode');

        $aWhere = array(
            'tBCHCode' => $tBCHCode ,
            'tSHPCode' => $tSHPCode ,
            'tWAHCode' => $tWAHCode ,
            'FNLngID'  => $this->session->userdata("tLangEdit")
        );

        $aDataCN = $this->Transferwarehouseout_model->FSaMTWOGetPDTInCN($aWhere);
        $aDataViewCN = array(
            'aDataCN'       => $aDataCN
        );
        $tViewCN            = $this->load->view('document/transferwarehouseout/wTransferwarehouseoutCN',$aDataViewCN,true);
        $aReturnData        = array(
            'tViewPageAdd'  => $tViewCN,
            'nStaEvent'     => '1',
            'tStaMessg'     => 'Success'
        );
        echo json_encode($aReturnData);
    }

    //อนุมัติ
    public function FSoCTWOApproved(){
        $tXthDocNo      = $this->input->post('tXthDocNo');
        $tXthStaApv     = $this->input->post('tXthStaApv');
        $tXthDocType     = $this->input->post('tXthDocType');
        $tXthBchCode     = $this->input->post('tXthBchCode');
        $tUsrBchCode    = FCNtGetBchInComp();

        $aDataUpdate = array(
            'FTXthDocNo'    => $tXthDocNo,
            'FTXthApvCode'  => $this->session->userdata('tSesUsername')
        );
        $aStaApv = $this->Transferwarehouseout_model->FSvMTWOApprove($aDataUpdate);
        
        try{

            
            $aMQParams = [
                "queueName" => "TNFWAREHOSEOUT",
                "exchangname" => "",
                "params"    => [
                    "ptBchCode"     => $tXthBchCode,
                    "ptDocNo"       => $tXthDocNo,
                    "ptDocType"     => $tXthDocType,
                    "ptUser"        => $this->session->userdata('tSesUsername')
                ]
            ];
            FCNxCallRabbitMQ($aMQParams);

            // die();
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

    
}
