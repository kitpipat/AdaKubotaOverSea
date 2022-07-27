<?php

use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;

defined('BASEPATH') or exit('No direct script access allowed');

class cSaleOrder extends MX_Controller {

    public function __construct() {
        $this->load->model('company/company/mCompany');
        $this->load->model('company/branch/mBranch');
        $this->load->model('company/shop/mShop');
        $this->load->model('payment/rate/mRate');
        $this->load->model('company/vatrate/mVatRate');
        $this->load->model('document/saleorder/mSaleOrder');
        $this->load->model('document/saleorder/mSaleOrderDisChgModal');
        parent::__construct();
    }

    public function index($nSOBrowseType, $tSOBrowseOption) {
        $aDataConfigView = array(
            'nSOBrowseType'     => $nSOBrowseType,
            'tSOBrowseOption'   => $tSOBrowseOption,
            'aAlwEvent'         => FCNaHCheckAlwFunc('dcmSO/0/0'), // Controle Event
            'vBtnSave'          => FCNaHBtnSaveActiveHTML('dcmSO/0/0'), // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave()
        );
        $this->load->view('document/saleorder/wSaleOrder', $aDataConfigView);
    }

    // Functionality : Function Call Page From Search List
    // Parameters : Ajax and Function Parameter
    // Creator : 17/06/2019 wasin (Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return : String View
    // Return Type : View
    public function FSvCSOFormSearchList() {
        $this->load->view('document/saleorder/wSaleOrderFormSearchList');
    }

    // Functionality : Function Call Page Data Table
    // Parameters : Ajax and Function Parameter
    // Creator : 19/06/2018 wasin (Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return : Object View Data Table
    // Return Type : object
    public function FSoCSODataTable() {
        try {
            $aAdvanceSearch = $this->input->post('oAdvanceSearch');
            $nPage = $this->input->post('nPageCurrent');
            $aAlwEvent = FCNaHCheckAlwFunc('dcmSO/0/0');

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
                'FNLngID' => $nLangEdit,
                'nPage' => $nPage,
                'nRow' => 10,
                'aDatSessionUserLogIn' => $this->session->userdata("tSesUsrInfo"),
                'aAdvanceSearch' => $aAdvanceSearch
            );
            $aDataList = $this->mSaleOrder->FSaMSOGetDataTableList($aDataCondition);

            $aConfigView = array(
                'nPage' => $nPage,
                'nOptDecimalShow' => $nOptDecimalShow,
                'aAlwEvent' => $aAlwEvent,
                'aDataList' => $aDataList,
            );
            $tSOViewDataTableList = $this->load->view('document/saleorder/wSaleOrderDataTable', $aConfigView, true);
            $aReturnData = array(
                'tSOViewDataTableList' => $tSOViewDataTableList,
                'nStaEvent' => '1',
                'tStaMessg' => 'Success'
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Function Delete Document Purchase Invoice
    // Parameters : Ajax and Function Parameter
    // Creator : 19/06/2019 wasin (Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return : Object View Data Table
    // Return Type : object
    public function FSoCSODeleteEventDoc() {
        try {
            $tDataDocNo = $this->input->post('tDataDocNo');
            $aDataMaster = array(
                'tDataDocNo' => $tDataDocNo
            );
            $aResDelDoc = $this->mSaleOrder->FSnMSODelDocument($aDataMaster);
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

    // Functionality : Function Call Page Add Tranfer Out
    // Parameters : Ajax and Function Parameter
    // Creator : 19/06/2019 wasin (Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCSOAddPage() {
        try {

            // Clear Data Product IN Doc Temp
            $aWhereClearTemp = [
                'FTXthDocNo' => '',
                'FTXthDocKey' => 'TARTSoHD',
                'FTSessionID' => $this->session->userdata('tSesSessionID')
            ];

            $tUserBchCode = $this->session->userdata('tSesUsrBchCom');
            // echo $tUserBchCode;die();
            if(!empty($tUserBchCode)){
                $aDataBch = $this->mSaleOrder->FSaMSOGetDetailUserBranch($tUserBchCode);
                $tSOPplCode = $aDataBch['item']['FTPplCode'];
            }else{
                $tSOPplCode = '';
            }
     

            $this->mSaleOrder->FSaMCENDeletePDTInTmp($aWhereClearTemp);
            $this->mSaleOrder->FSxMSOClearDataInDocTemp($aWhereClearTemp);

            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            // Get Option Doc Save
            $nOptDocSave = FCNnHGetOptionDocSave();
            // Get Option Scan SKU
            $nOptScanSku = FCNnHGetOptionScanSku();
            // Lang ภาษา
            $nLangEdit = $this->session->userdata("tLangEdit");

            $aWhereHelperCalcDTTemp = array(
                'tDataDocEvnCall' => "",
                'tDataVatInOrEx' => 1,
                'tDataDocNo' => '',
                'tDataDocKey' => 'TARTSoHD',
                'tDataSeqNo' => ''
            );
            FCNbHCallCalcDocDTTemp($aWhereHelperCalcDTTemp);

            $aDataWhere = array(
                'FNLngID' => $nLangEdit
            );

            $tASOReq = "";
            $tMethodReq = "GET";
            $aCompData = $this->mCompany->FSaMCMPList($tASOReq, $tMethodReq, $aDataWhere);

            if (isset($aCompData) && $aCompData['rtCode'] == '1') {
                $tBchCode = $aCompData['raItems']['rtCmpBchCode'];
                $tCmpRteCode = $aCompData['raItems']['rtCmpRteCode'];
                $tVatCode = $aCompData['raItems']['rtVatCodeUse'];
                $tCmpRetInOrEx = $aCompData['raItems']['rtCmpRetInOrEx'];
                $aVatRate = FCNoHCallVatlist($tVatCode);
                if (isset($aVatRate) && !empty($aVatRate)) {
                    $cVatRate = $aVatRate['FCVatRate'][0];
                } else {
                    $cVatRate = "";
                }
                $aDataRate = array(
                    'FTRteCode' => $tCmpRteCode,
                    'FNLngID' => $nLangEdit
                );
                $aResultRte = $this->mRate->FSaMRTESearchByID($aDataRate);
                if (isset($aResultRte) && $aResultRte['rtCode']) {
                    $cXthRteFac = $aResultRte['raItems']['rcRteRate'];
                } else {
                    $cXthRteFac = "";
                }
            } else {
                $tBchCode = FCNtGetBchInComp();
                $tCmpRteCode = "";
                $tVatCode = "";
                $cVatRate = "";
                $cXthRteFac = "";
                $tCmpRetInOrEx ="1";
            }

            // Get Department Code
            $tUsrLogin = $this->session->userdata('tSesUsername');
            $tDptCode = FCNnDOCGetDepartmentByUser($tUsrLogin);

            // Get ข้อมูลสาขา และ ร้านค้าของ User ที่ login
            $aDataShp = array(
                'FNLngID' => $nLangEdit,
                'tUsrLogin' => $tUsrLogin
            );
            $aDataUserGroup = $this->mSaleOrder->FSaMSOGetShpCodeForUsrLogin($aDataShp);
            if (isset($aDataUserGroup) && empty($aDataUserGroup)) {
                $tBchCode = "";
                $tBchName = "";
                $tMerCode = "";
                $tMerName = "";
                $tShopType = "";
                $tShopCode = "";
                $tShopName = "";
                $tWahCode = "";
                $tWahName = "";
            } else {
                $tBchCode = $aDataUserGroup["FTBchCode"];
                $tBchName = $aDataUserGroup["FTBchName"];
                $tMerCode = $aDataUserGroup["FTMerCode"];
                $tMerName = $aDataUserGroup["FTMerName"];
                $tShopType = $aDataUserGroup["FTShpType"];
                $tShopCode = $aDataUserGroup["FTShpCode"];
                $tShopName = $aDataUserGroup["FTShpName"];
                $tWahCode = $aDataUserGroup["FTWahCode"];
                $tWahName = $aDataUserGroup["FTWahName"];
            }

            // ดึงข้อมูลที่อยู่คลัง Defult ในตาราง TSysConfig
            $aConfigSys = [
                'FTSysCode' => 'tPS_Warehouse',
                'FTSysSeq' => 3,
                'FNLngID' => $nLangEdit
            ];
            $aConfigSysWareHouse = $this->mSaleOrder->FSaMSOGetDefOptionConfigWah($aConfigSys);

            
            $aDataConfigViewAdd = array(
                'nOptDecimalShow' => $nOptDecimalShow,
                'nOptDocSave' => $nOptDocSave,
                'nOptScanSku' => $nOptScanSku,
                'tCmpRteCode' => $tCmpRteCode,
                'tVatCode' => $tVatCode,
                'cVatRate' => $cVatRate,
                'cXthRteFac' => $cXthRteFac,
                'tDptCode' => $tDptCode,
                'tBchCode' => $tBchCode,
                'tBchName' => $tBchName,
                'tMerCode' => $tMerCode,
                'tMerName' => $tMerName,
                'tShopType' => $tShopType,
                'tShopCode' => $tShopCode,
                'tShopName' => $tShopName,
                'tWahCode' => $tWahCode,
                'tWahName' => $tWahName,
                'tBchCompCode' => FCNtGetBchInComp(),
                'tBchCompName' => FCNtGetBchNameInComp(),
                'aConfigSysWareHouse' => $aConfigSysWareHouse,
                'aDataDocHD' => array('rtCode' => '800'),
                'aDataDocHDSpl' => array('rtCode' => '800'),
                'tCmpRetInOrEx' => $tCmpRetInOrEx,
                'tSOPplCode'  => $tSOPplCode
            );
            $tSOViewPageAdd = $this->load->view('document/saleorder/wSaleOrderAdd', $aDataConfigViewAdd, true);
            $aReturnData = array(
                'tSOViewPageAdd' => $tSOViewPageAdd,
                'nStaEvent' => '1',
                'tStaMessg' => 'Success'
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }


    // Functionality : Function Call Page Edit Tranfer Out
    // Parameters : Ajax and Function Parameter
    // Creator : 19/06/2019 wasin (Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCSOEditPage() {


        try {
            $tSODocNo = $this->input->post('ptSODocNo');

            // Clear Data In Doc DT Temp
            $aWhereClearTemp = [
                'FTXthDocNo' => $tSODocNo,
                'FTXthDocKey' => 'TARTSoHD',
                'FTSessionID' => $this->session->userdata('tSesSessionID')
            ];
            $this->mSaleOrder->FSxMSOClearDataInDocTemp($aWhereClearTemp);

            $tUserBchCode = $this->session->userdata('tSesUsrBchCom');
            // echo $tUserBchCode;die();
            if(!empty($tUserBchCode)){
                $aDataBch = $this->mSaleOrder->FSaMSOGetDetailUserBranch($tUserBchCode);
                $tSOPplCode = $aDataBch['item']['FTPplCode'];
            }else{
                $tSOPplCode = '';
            }
            // Get Autentication Route
            $aAlwEvent = FCNaHCheckAlwFunc('dcmSO/0/0');
            // Get Option Show Decimal
            $nOptDecimalShow = FCNxHGetOptionDecimalShow();
            // Get Option Doc Save
            $nOptDocSave = FCNnHGetOptionDocSave();
            // Get Option Scan SKU
            $nOptScanSku = FCNnHGetOptionScanSku();
            // Lang ภาษา
            $nLangEdit = $this->session->userdata("tLangEdit");

            // Get ข้อมูลสาขา และ ร้านค้าของ User ที่ login
            $tUsrLogin = $this->session->userdata('tSesUsername');
            $aDataShp = array(
                'FNLngID' => $nLangEdit,
                'tUsrLogin' => $tUsrLogin
            );

            $aDataUserGroup = $this->mSaleOrder->FSaMSOGetShpCodeForUsrLogin($aDataShp);
            if (isset($aDataUserGroup) && empty($aDataUserGroup)) {
                $tUsrBchCode = "";
                $tUsrBchName = "";
                $tUsrMerCode = "";
                $tUsrMerName = "";
                $tUsrShopType = "";
                $tUsrShopCode = "";
                $tUsrShopName = "";
                $tUsrWahCode = "";
                $tUsrWahName = "";
            } else {
                $tUsrBchCode = $aDataUserGroup["FTBchCode"];
                $tUsrBchName = $aDataUserGroup["FTBchName"];
                $tUsrMerCode = $aDataUserGroup["FTMerCode"];
                $tUsrMerName = $aDataUserGroup["FTMerName"];
                $tUsrShopType = $aDataUserGroup["FTShpType"];
                $tUsrShopCode = $aDataUserGroup["FTShpCode"];
                $tUsrShopName = $aDataUserGroup["FTShpName"];
                $tUsrWahCode = $aDataUserGroup["FTWahCode"];
                $tUsrWahName = $aDataUserGroup["FTWahName"];
            }

            // Data Table Document
            $aTableDocument = array(
                'tTableHD' => 'TARTSoHD',
                'tTableHDCst' => 'TARTSoHDCst',
                'tTableHDDis' => 'TARTSoHDDis',
                'tTableDT' => 'TARTSoDT',
                'tTableDTDis' => 'TARTSoDTDis'
            );

            // Array Data Where Get (HD,HDSpl,HDDis,DT,DTDis)
            $aDataWhere = array(
                'FTXthDocNo' => $tSODocNo,
                'FTXthDocKey' => 'TARTSoHD',
                'FNLngID' => $nLangEdit,
                'nRow' => 10000,
                'nPage' => 1,
            );

            $this->db->trans_begin();

            // Get Data Document HD
            $aDataDocHD = $this->mSaleOrder->FSaMSOGetDataDocHD($aDataWhere);

                    // echo '<pre>';
                    // print_r($aDataWhere);
                    // echo '</pre>';
                    // die();
            // Move Data HD DIS To HD DIS Temp
            $this->mSaleOrder->FSxMSOMoveHDDisToTemp($aDataWhere);

            // Move Data DT TO DTTemp
            $this->mSaleOrder->FSxMSOMoveDTToDTTemp($aDataWhere);

            // Move Data DTDIS TO DTDISTemp
            $this->mSaleOrder->FSxMSOMoveDTDisToDTDisTemp($aDataWhere);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Query Call Edit Page.'
                );
            } else {
                $this->db->trans_commit();
                // Prorate HD
                FCNaHCalculateProrate('TARTSoHD', $tSODocNo);
                $tSOVATInOrEx = ($aDataDocHD['rtCode'] == '1') ? $aDataDocHD['raItems']['FTXshVATInOrEx'] : 1;
                $aCalcDTTempParams = array(
                    'tDataDocEvnCall' => '1',
                    'tDataVatInOrEx' => $tSOVATInOrEx,
                    'tDataDocNo' => $tSODocNo,
                    'tDataDocKey' => 'TARTSoHD',
                    'tDataSeqNo' => ""
                );
               $tUserBchCode = $aDataDocHD['raItems']['FTBchCode'];
                if(!empty($tUserBchCode)){
                    $aDataBch = $this->mSaleOrder->FSaMSOGetDetailUserBranch($tUserBchCode);
                    $tSOPplCode = $aDataBch['item']['FTPplCode'];
                }else{
                    $tSOPplCode = '';
                }

                
                $tStaCalDocDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTTempParams);
                $aDataConfigViewAdd = array(
                    'nOptDecimalShow' => $nOptDecimalShow,
                    'nOptDocSave' => $nOptDocSave,
                    'nOptScanSku' => $nOptScanSku,
                    'tUserBchCode' => $tUsrBchCode,
                    'tUserBchName' => $tUsrBchName,
                    'tUsrMerCode' => $tUsrMerCode,
                    'tUsrMerName' => $tUsrMerName,
                    'tUsrShopType' => $tUsrShopType,
                    'tUsrShopCode' => $tUsrShopCode,
                    'tUsrShopName' => $tUsrShopName,
                    'tBchCompCode' => FCNtGetBchInComp(),
                    'tBchCompName' => FCNtGetBchNameInComp(),
                    'aDataDocHD' => $aDataDocHD,
                    'aAlwEvent' => $aAlwEvent,
                    'tSOPplCode' => $tSOPplCode
                );
                $tSOViewPageEdit = $this->load->view('document/saleorder/wSaleOrderAdd', $aDataConfigViewAdd, true);
                $aReturnData = array(
                    'tSOViewPageEdit' => $tSOViewPageEdit,
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



     // Functionality : Function Call Page Edit Tranfer Out
    // Parameters : Ajax and Function Parameter
    // Creator : 19/06/2019 wasin (Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCSOEditPageMonitor() {
        try {
            $tSODocNo = $this->input->post('ptSODocNo');

            // Clear Data In Doc DT Temp
            $aWhereClearTemp = [
                'FTXthDocNo' => $tSODocNo,
                'FTXthDocKey' => 'TARTSoHD',
                'FTSessionID' => $this->session->userdata('tSesSessionID')
            ];
            $this->mSaleOrder->FSxMSOClearDataInDocTemp($aWhereClearTemp);

            // Get Autentication Route
            $aAlwEvent = FCNaHCheckAlwFunc('dcmSO/0/0');
            // Get Option Show Decimal
            $nOptDecimalShow = FCNxHGetOptionDecimalShow();
            // Get Option Doc Save
            $nOptDocSave = FCNnHGetOptionDocSave();
            // Get Option Scan SKU
            $nOptScanSku = FCNnHGetOptionScanSku();
            // Lang ภาษา
            $nLangEdit = $this->session->userdata("tLangEdit");

            // Get ข้อมูลสาขา และ ร้านค้าของ User ที่ login
            $tUsrLogin = $this->session->userdata('tSesUsername');
            $aDataShp = array(
                'FNLngID' => $nLangEdit,
                'tUsrLogin' => $tUsrLogin
            );

            $aDataUserGroup = $this->mSaleOrder->FSaMSOGetShpCodeForUsrLogin($aDataShp);
            if (isset($aDataUserGroup) && empty($aDataUserGroup)) {
                $tUsrBchCode = "";
                $tUsrBchName = "";
                $tUsrMerCode = "";
                $tUsrMerName = "";
                $tUsrShopType = "";
                $tUsrShopCode = "";
                $tUsrShopName = "";
                $tUsrWahCode = "";
                $tUsrWahName = "";
            } else {
                $tUsrBchCode = $aDataUserGroup["FTBchCode"];
                $tUsrBchName = $aDataUserGroup["FTBchName"];
                $tUsrMerCode = $aDataUserGroup["FTMerCode"];
                $tUsrMerName = $aDataUserGroup["FTMerName"];
                $tUsrShopType = $aDataUserGroup["FTShpType"];
                $tUsrShopCode = $aDataUserGroup["FTShpCode"];
                $tUsrShopName = $aDataUserGroup["FTShpName"];
                $tUsrWahCode = $aDataUserGroup["FTWahCode"];
                $tUsrWahName = $aDataUserGroup["FTWahName"];
            }

            // Data Table Document
            $aTableDocument = array(
                'tTableHD' => 'TARTSoHD',
                'tTableHDCst' => 'TARTSoHDCst',
                'tTableHDDis' => 'TARTSoHDDis',
                'tTableDT' => 'TARTSoDT',
                'tTableDTDis' => 'TARTSoDTDis'
            );

            // Array Data Where Get (HD,HDSpl,HDDis,DT,DTDis)
            $aDataWhere = array(
                'FTXthDocNo' => $tSODocNo,
                'FTXthDocKey' => 'TARTSoHD',
                'FNLngID' => $nLangEdit,
                'nRow' => 10000,
                'nPage' => 1,
            );

            $this->db->trans_begin();

            // Get Data Document HD
            $aDataDocHD = $this->mSaleOrder->FSaMSOGetDataDocHD($aDataWhere);

            $nNextSeq = $aDataDocHD['raItems']['LastSeq']+1; //หาลำดับต่อไป

            $aDataSetStrPrc = array(
                'FTDatRefCode' => $tSODocNo,
                'tBchCode' => $aDataDocHD['raItems']['FTBchCode'],
                'FNDatApvSeq' => $nNextSeq,
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn' => date('Y-m-d H:i:s')
            );
          $nCheckNumBook =  $this->mSaleOrder->FSnMSOCheckStrPrcLastUpdate($aDataSetStrPrc);
         
           if($nCheckNumBook>0){//ตรวจสอบว่าในขณะนี้มีผู้จองเอกสารใช้อยู่หรือไม่ 0 = มีผู้จองใช้อยู่ , >0 = เอกสารว่างในขณะนี้

            $this->mSaleOrder->FSaMSOUpdateStrPrcLastUpdate($aDataSetStrPrc);

                    // echo '<pre>';
                    // print_r($aDataWhere);
                    // echo '</pre>';
                    // die();
            // Move Data HD DIS To HD DIS Temp
            $this->mSaleOrder->FSxMSOMoveHDDisToTemp($aDataWhere);

            // Move Data DT TO DTTemp
            $this->mSaleOrder->FSxMSOMoveDTToDTTemp($aDataWhere);

            // Move Data DTDIS TO DTDISTemp
            $this->mSaleOrder->FSxMSOMoveDTDisToDTDisTemp($aDataWhere);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Query Call Edit Page.'
                );
            } else {
                $this->db->trans_commit();
                // Prorate HD
                FCNaHCalculateProrate('TARTSoHD', $tSODocNo);
                $tSOVATInOrEx = ($aDataDocHD['rtCode'] == '1') ? $aDataDocHD['raItems']['FTXshVATInOrEx'] : 1;
                $aCalcDTTempParams = array(
                    'tDataDocEvnCall' => '1',
                    'tDataVatInOrEx' => $tSOVATInOrEx,
                    'tDataDocNo' => $tSODocNo,
                    'tDataDocKey' => 'TARTSoHD',
                    'tDataSeqNo' => ""
                );
                $tStaCalDocDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTTempParams);

                $aDataCalTnx = array(
                    'tDocNo' => $tSODocNo,
                    'tApvCode'=> "",
                    'tTableDocHD' => 'TARTSoHD',
                    'tBchCode' =>$aDataDocHD['raItems']['FTBchCode']
    
                );
               $aDataSOTnx = FNaDOHNCheckSeqAprve($aDataCalTnx);//หาประวัติการบันทึกอนุมัติก่อน
                

              $nSecondTimeCountDonw = $this->mSaleOrder->FSnMSOGetTimeCountDown($aDataSetStrPrc);
                
                $aDataConfigViewAdd = array(
                    'nOptDecimalShow' => $nOptDecimalShow,
                    'nOptDocSave' => $nOptDocSave,
                    'nOptScanSku' => $nOptScanSku,
                    'tUserBchCode' => $tUsrBchCode,
                    'tUserBchName' => $tUsrBchName,
                    'tUsrMerCode' => $tUsrMerCode,
                    'tUsrMerName' => $tUsrMerName,
                    'tUsrShopType' => $tUsrShopType,
                    'tUsrShopCode' => $tUsrShopCode,
                    'tUsrShopName' => $tUsrShopName,
                    'tBchCompCode' => FCNtGetBchInComp(),
                    'tBchCompName' => FCNtGetBchNameInComp(),
                    'aDataDocHD' => $aDataDocHD,
                    'aAlwEvent' => $aAlwEvent,
                    'aDataSOTnx' => $aDataSOTnx,
                    'nSecondTimeCountDonw' => ($nSecondTimeCountDonw*1000)
                );
                $tSOViewPageEdit = $this->load->view('document/saleorder/wSaleOrderAddMonitor', $aDataConfigViewAdd, true);
                $aReturnData = array(
                    'tSOViewPageEdit' => $tSOViewPageEdit,
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success'
                );
            }
        }else{
            $aReturnData = array(
                'nStaEvent' => '3',
                'tStaMessg' => 'This document is in use.'
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




    // Functionality : Call View Table Data Doc DT Temp
    // Parameters : Ajax and Function Parameter
    // Creator : 28/06/2018 wasin(Yoshi AKA: Mr.JW)
    // Return : Object  View Table Data Doc DT Temp
    // Return Type : object
    public function FSoCSOPdtAdvTblLoadData() {
        try {
            $bStaSession    =   $this->session->userdata('bSesLogIn');
            if(isset($bStaSession) && $bStaSession === TRUE){
                //ยังมี Session อยู่
            }else{
                $aReturnData = array(
                    'checksession' => 'expire'
                );
                echo json_encode($aReturnData);
                exit;
            }

            $tSODocNo = $this->input->post('ptSODocNo');
            $tSOStaApv = $this->input->post('ptSOStaApv');
            $tSOStaDoc = $this->input->post('ptSOStaDoc');
            $tSOVATInOrEx = $this->input->post('ptSOVATInOrEx');
            $nSOPageCurrent = $this->input->post('pnSOPageCurrent');
            $tSearchPdtAdvTable = $this->input->post('ptSearchPdtAdvTable');
            // Edit in line
            $tSOPdtCode = $this->input->post('ptSOPdtCode');
            $tSOPunCode = $this->input->post('ptSOPunCode');

            //Get Option Show Decimal
            $nOptDecimalShow = FCNxHGetOptionDecimalShow();

            // Call Advance Table
            $tTableGetColumeShow = 'TARTSoDT';
            $aColumnShow = FCNaDCLGetColumnShow($tTableGetColumeShow);
            
            $aDataWhere = array(
                'tSearchPdtAdvTable' => $tSearchPdtAdvTable,
                'FTXthDocNo' => $tSODocNo,
                'FTXthDocKey' => 'TARTSoHD',
                'nPage' => $nSOPageCurrent,
                'nRow' => 10,
                'FTSessionID' => $this->session->userdata('tSesSessionID'),
            );

            // Calcurate Document DT Temp Array Parameter
            $aCalcDTParams = [
                'tDataDocEvnCall' => '1',
                'tDataVatInOrEx' => $tSOVATInOrEx,
                'tDataDocNo' => $tSODocNo,
                'tDataDocKey' => 'TARTSoHD',
                'tDataSeqNo' => ''
            ];
            FCNbHCallCalcDocDTTemp($aCalcDTParams);

            $aDataDocDTTemp = $this->mSaleOrder->FSaMSOGetDocDTTempListPage($aDataWhere);
            $aDataDocDTTempSum = $this->mSaleOrder->FSaMSOSumDocDTTemp($aDataWhere);
            // echo '<pre>';
            //         print_r($aColumnShow);
            // echo '</pre>';
            $aDataView = array(
                'nOptDecimalShow' => $nOptDecimalShow,
                'tSOStaApv' => $tSOStaApv,
                'tSOStaDoc' => $tSOStaDoc,
                'tSOPdtCode' => $tSOPdtCode,
                'tSOPunCode' => $tSOPunCode,
                'nPage' => $nSOPageCurrent,
                'aColumnShow' => $aColumnShow,
                'aDataDocDTTemp' => $aDataDocDTTemp,
                'aDataDocDTTempSum' => $aDataDocDTTempSum,
            );

            $tSOPdtAdvTableHtml = $this->load->view('document/saleorder/wSaleOrderPdtAdvTableData', $aDataView, true);

            // Call Footer Document
            $aEndOfBillParams = array(
                'tSplVatType'   => $tSOVATInOrEx,
                'tDocNo'        => $tSODocNo,
                'tDocKey'       => 'TARTSoHD',
                'nLngID'        => FCNaHGetLangEdit(),
                'tSesSessionID' => $this->session->userdata('tSesSessionID'),
                'tBchCode'      => $this->session->userdata('tSesUsrLevel') == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata('tSesUsrBchCode')
            );

            //คำนวณส่วนลดใหม่อีกครั้ง ถ้าหากมีส่วนลดท้ายบิล supawat 03-04-2020       
            $aSOEndOfBill['aEndOfBillVat']  = FCNaDOCEndOfBillCalVat($aEndOfBillParams);
            $aSOEndOfBill['aEndOfBillCal']  = FCNaDOCEndOfBillCal($aEndOfBillParams);
            $aSOEndOfBill['tTextBath']      = FCNtNumberToTextBaht($aSOEndOfBill['aEndOfBillCal']['cCalFCXphGrand']);

            $aPackDataCalCulate = array(
                'tDocNo'        => $tSODocNo,
                'tBchCode'      => '',
                'nB4Dis'        => $aSOEndOfBill['aEndOfBillCal']['cSumFCXtdNet'],
                'tSplVatType'   => $tSOVATInOrEx
            );
            $tCalculateAgain = FSaCCNDocumentUpdateHDDisAgain($aPackDataCalCulate);
            if($tCalculateAgain == 'CHANGE'){
                $aStaCalcDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTParams);
                if($aStaCalcDTTemp === TRUE){
                    FCNaHCalculateProrate('TARTSoHD',$aPackDataCalCulate['tDocNo']);
                    FCNbHCallCalcDocDTTemp($aCalcDTParams);
                }
                $aSOEndOfBill['aEndOfBillVat']  = FCNaDOCEndOfBillCalVat($aEndOfBillParams);
                $aSOEndOfBill['aEndOfBillCal']  = FCNaDOCEndOfBillCal($aEndOfBillParams);
                $aSOEndOfBill['tTextBath']      = FCNtNumberToTextBaht($aSOEndOfBill['aEndOfBillCal']['cCalFCXphGrand']);
            }

            $aReturnData = array(
                'tSOPdtAdvTableHtml' => $tSOPdtAdvTableHtml,
                'aSOEndOfBill' => $aSOEndOfBill,
                'nStaEvent' => '1',
                'tStaMessg' => "Fucntion Success Return View."
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }


    

    // Functionality : Call View Table Data Doc DT Temp
    // Parameters : Ajax and Function Parameter
    // Creator : 28/06/2018 wasin(Yoshi AKA: Mr.JW)
    // Return : Object  View Table Data Doc DT Temp
    // Return Type : object
    public function FSoCSOPdtAdvTblLoadDataMonitor() {
        try {
            $tSODocNo = $this->input->post('ptSODocNo');
            $tSOStaApv = $this->input->post('ptSOStaApv');
            $tSOStaDoc = $this->input->post('ptSOStaDoc');
            $tSOVATInOrEx = $this->input->post('ptSOVATInOrEx');
            $nSOPageCurrent = $this->input->post('pnSOPageCurrent');
            $tSearchPdtAdvTable = $this->input->post('ptSearchPdtAdvTable');
            // Edit in line
            $tSOPdtCode = $this->input->post('ptSOPdtCode');
            $tSOPunCode = $this->input->post('ptSOPunCode');
            $nSOLastSeq = $this->input->post('nSOLastSeq');
            

            //Get Option Show Decimal
            $nOptDecimalShow = FCNxHGetOptionDecimalShow();

            // Call Advance Table
            $tTableGetColumeShow = 'TARTSoDT';
            $aColumnShow = FCNaDCLGetColumnShow($tTableGetColumeShow);
            
            $aDataWhere = array(
                'tSearchPdtAdvTable' => $tSearchPdtAdvTable,
                'FTXthDocNo' => $tSODocNo,
                'FTXthDocKey' => 'TARTSoHD',
                'nPage' => $nSOPageCurrent,
                'nRow' => 10,
                'FTSessionID' => $this->session->userdata('tSesSessionID'),
            );

            // Calcurate Document DT Temp Array Parameter
            $aCalcDTParams = [
                'tDataDocEvnCall' => '1',
                'tDataVatInOrEx' => $tSOVATInOrEx,
                'tDataDocNo' => $tSODocNo,
                'tDataDocKey' => 'TARTSoHD',
                'tDataSeqNo' => ''
            ];
            FCNbHCallCalcDocDTTemp($aCalcDTParams);

            $aDataDocDTTemp = $this->mSaleOrder->FSaMSOGetDocDTTempListPage($aDataWhere);
            $aDataDocDTTempSum = $this->mSaleOrder->FSaMSOSumDocDTTemp($aDataWhere);
      
            // echo '<pre>';
            //         print_r($aColumnShow);
            // echo '</pre>';
            // die();
            $aDataView = array(
                'nOptDecimalShow' => $nOptDecimalShow,
                'tSOStaApv' => $tSOStaApv,
                'tSOStaDoc' => $tSOStaDoc,
                'tSOPdtCode' => $tSOPdtCode,
                'tSOPunCode' => $tSOPunCode,
                'nPage' => $nSOPageCurrent,
                'aColumnShow' => $aColumnShow,
                'aDataDocDTTemp' => $aDataDocDTTemp,
                'aDataDocDTTempSum' => $aDataDocDTTempSum,
                'nSOLastSeq' => $nSOLastSeq
            );
            if($nSOLastSeq!=4){
              $tSOPdtAdvTableHtml = $this->load->view('document/saleorder/wSaleOrderPdtAdvTableDataMonitor', $aDataView, true);
            }else{
              $tSOPdtAdvTableHtml = $this->load->view('document/saleorder/wSaleOrderPdtAdvTableDataMonitorIMG', $aDataView, true);
            }
            
            // Call Footer Document
            $aEndOfBillParams = array(
                'tSplVatType' => $tSOVATInOrEx,
                'tDocNo' => $tSODocNo,
                'tDocKey' => 'TARTSoHD',
                'nLngID' => FCNaHGetLangEdit(),
                'tSesSessionID' => $this->session->userdata('tSesSessionID'),
                'tBchCode' => $this->session->userdata('tSesUsrLevel') == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata('tSesUsrBchCode')
            );

            $aSOEndOfBill['aEndOfBillVat'] = FCNaDOCEndOfBillCalVat($aEndOfBillParams);
            $aSOEndOfBill['aEndOfBillCal'] = FCNaDOCEndOfBillCal($aEndOfBillParams);
            $aSOEndOfBill['tTextBath'] = FCNtNumberToTextBaht($aSOEndOfBill['aEndOfBillCal']['cCalFCXphGrand']);
            // echo '<pre>';
            // print_r($aSOEndOfBill);
            // echo '</pre>';
            // die();
            $aReturnData = array(
                'tSOPdtAdvTableHtml' => $tSOPdtAdvTableHtml,
                'aSOEndOfBill' => $aSOEndOfBill,
                'nStaEvent' => '1',
                'tStaMessg' => "Fucntion Success Return View."
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }



    // Function: Call View Table Manage Advance Table
    // Parameters: Document Type
    // Creator: 01/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object View Advance Table
    // ReturnType: Object
    public function FSoCSOAdvTblShowColList() {
        try {
            $tTableShowColums = 'TARTSoDT';
            $aAvailableColumn = FCNaDCLAvailableColumn($tTableShowColums);

            // print_r($aAvailableColumn);
            // die();
            $aDataViewAdvTbl = array(
                'aAvailableColumn' => $aAvailableColumn
            );
            $tViewTableShowCollist = $this->load->view('document/saleorder/advancetable/wSaleOrderTableShowColList', $aDataViewAdvTbl, true);
            $aReturnData = array(
                'tViewTableShowCollist' => $tViewTableShowCollist,
                'nStaEvent' => '1',
                'tStaMessg' => 'Success'
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function: Save Columns Advance Table
    // Parameters: Data Save Colums Advance Table
    // Creator: 01/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Sta Save Advance Table
    // ReturnType: Object
    public function FSoCSOAdvTalShowColSave() {
        try {
            $this->db->trans_begin();

            $nSOStaSetDef = $this->input->post('pnSOStaSetDef');
            $aSOColShowSet = $this->input->post('paSOColShowSet');
            $aSOColShowAllList = $this->input->post('paSOColShowAllList');
            $aSOColumnLabelName = $this->input->post('paSOColumnLabelName');
            // Table Set Show Colums
            $tTableShowColums = "TARTSoDT";
            FCNaDCLSetShowCol($tTableShowColums, '', '');
            if ($nSOStaSetDef == '1') {
                FCNaDCLSetDefShowCol($tTableShowColums);
            } else {
                for ($i = 0; $i < count($aSOColShowSet); $i++) {
                    FCNaDCLSetShowCol($tTableShowColums, 1, $aSOColShowSet[$i]);
                }
            }
            // Reset Seq Advannce Table
            FCNaDCLUpdateSeq($tTableShowColums, '', '', '');
            $q = 1;
            for ($n = 0; $n < count($aSOColShowAllList); $n++) {
                FCNaDCLUpdateSeq($tTableShowColums, $aSOColShowAllList[$n], $q, $aSOColumnLabelName[$n]);
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

    // Function: Add สินค้า ลง Document DT Temp
    // Parameters: Document Type
    // Creator: 02/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Status Add Pdt To Doc DT Temp
    // ReturnType: Object
    public function FSoCSOAddPdtIntoDocDTTemp() {
        try {
            $tSOUserLevel = $this->session->userdata('tSesUsrLevel');
            $tSODocNo = $this->input->post('tSODocNo');
            $tSOVATInOrEx = $this->input->post('tSOVATInOrEx');
            $tSOBchCode = ($tSOUserLevel == 'HQ') ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCode");
            $tSOOptionAddPdt = $this->input->post('tSOOptionAddPdt');
            $tSOPdtData = $this->input->post('tSOPdtData');
            $aSOPdtData = json_decode($tSOPdtData);
            $tSOPplCodeBch=$this->input->post('tSOPplCodeBch');//กลุ่มราคาตามสาขา
            $tSOPplCodeCst=$this->input->post('tSOPplCodeCst');//กลุ่มราคาตามลูกค้า

            $aDataWhere = array(
                'FTBchCode' => $tSOBchCode,
                'FTXthDocNo' => $tSODocNo,
                'FTXthDocKey' => 'TARTSoHD',
            );

            $this->db->trans_begin();

            // ทำทีรายการ ตามรายการสินค้าที่เพิ่มเข้ามา
            for ($nI = 0; $nI < count($aSOPdtData); $nI++) {
                $tSOPdtCode = $aSOPdtData[$nI]->pnPdtCode;
                $tSOBarCode = $aSOPdtData[$nI]->ptBarCode;
                $tSOPunCode = $aSOPdtData[$nI]->ptPunCode;
                $aDataGetprice = array(
                    'tSOPplCodeCst' => $tSOPplCodeCst,
                    'tSOPplCodeBch' => $tSOPplCodeCst,
                    'tSOPdtCode'   => $tSOPdtCode,
                    'tSOBarCode'   => $tSOBarCode,
                    'tSOPunCode'  => $tSOPunCode
                );
                $cSOPrice = $this->mSaleOrder->FScMSOGetPricePdt4CstOrPdtBYPplCode($aDataGetprice);
                // $cSOPrice = $aSOPdtData[$nI]->packData->PriceRet;
                $nSOMaxSeqNo = $this->mSaleOrder->FSaMSOGetMaxSeqDocDTTemp($aDataWhere);
                $aDataPdtParams = array(
                    'tDocNo' => $tSODocNo,
                    'tBchCode' => $tSOBchCode,
                    'tPdtCode' => $tSOPdtCode,
                    'tBarCode' => $tSOBarCode,
                    'tPunCode' => $tSOPunCode,
                    'cPrice' => $cSOPrice,
                    'nMaxSeqNo' => $nSOMaxSeqNo + 1,
                    'nLngID' => $this->session->userdata("tLangID"),
                    'tSessionID' => $this->session->userdata('tSesSessionID'),
                    'tDocKey' => 'TARTSoHD',
                    'tSOOptionAddPdt' => $tSOOptionAddPdt
                );
                // Data Master Pdt ข้อมูลรายการสินค้าที่เพิ่มเข้ามา
                $aDataPdtMaster = $this->mSaleOrder->FSaMSOGetDataPdt($aDataPdtParams);
                // นำรายการสินค้าเข้า DT Temp
                $nStaInsPdtToTmp = $this->mSaleOrder->FSaMSOInsertPDTToTemp($aDataPdtMaster, $aDataPdtParams);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Insert Product Error Please Contact Admin.'
                );
            } else {
                $this->db->trans_commit();
                // Calcurate Document DT Temp Array Parameter
                $aCalcDTParams = [
                    'tDataDocEvnCall' => '1',
                    'tDataVatInOrEx' => $tSOVATInOrEx,
                    'tDataDocNo' => $tSODocNo,
                    'tDataDocKey' => 'TARTSoHD',
                    'tDataSeqNo' => ''
                ];
                $tStaCalcuRate = FCNbHCallCalcDocDTTemp($aCalcDTParams);
                if ($tStaCalcuRate === TRUE) {
                    // Prorate HD
                    FCNaHCalculateProrate('TARTSoHD', $tSODocNo);
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

    // Function: Edit Inline สินค้า ลง Document DT Temp
    // Parameters: Document Type
    // Creator: 02/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Status Edit Pdt To Doc DT Temp
    // ReturnType: Object
    public function FSoCSOEditPdtIntoDocDTTemp() {
        try {

            $bStaSession    =   $this->session->userdata('bSesLogIn');
            if(isset($bStaSession) && $bStaSession === TRUE){
                //ยังมี Session อยู่
            }else{
                echo 'expire';
                exit;
            }
            
            $tSOBchCode = $this->input->post('tSOBchCode');
            $tSODocNo = $this->input->post('tSODocNo');
            $tSOVATInOrEx = $this->input->post('tSOVATInOrEx');
            $nSOSeqNo = $this->input->post('nSOSeqNo');
            $tSOFieldName = $this->input->post('tSOFieldName');
            $tSOValue = $this->input->post('tSOValue');
            $nSOIsDelDTDis = $this->input->post('nSOIsDelDTDis');
            $tSOSessionID = $this->session->userdata('tSesSessionID');

            $aDataWhere = array(
                'tSOBchCode' => $tSOBchCode,
                'tSODocNo' => $tSODocNo,
                'nSOSeqNo' => $nSOSeqNo,
                'tSOSessionID' => $this->session->userdata('tSesSessionID'),
                'tDocKey' => 'TARTSoHD',
            );
            $aDataUpdateDT = array(
                'tSOFieldName' => $tSOFieldName,
                'tSOValue' => $tSOValue
            );

            $this->db->trans_begin();

            $this->mSaleOrder->FSaMSOUpdateInlineDTTemp($aDataUpdateDT, $aDataWhere);

            if ($nSOIsDelDTDis == '1') {
                // ยืนยันการลบ DTDis ส่วนลดรายการนี้
                $this->mSaleOrderDisChgModal->FSaMSODeleteDTDisTemp($aDataWhere);
                $this->mSaleOrderDisChgModal->FSaMSOClearDisChgTxtDTTemp($aDataWhere);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => "Error Update Inline Into Document DT Temp."
                );
            } else {
                $this->db->trans_commit();
                // Prorate HD
                FCNaHCalculateProrate('TARTSoHD', $tSODocNo);

                $aCalcDTTempParams = array(
                    'tDataDocEvnCall' => '1',
                    'tDataVatInOrEx' => $tSOVATInOrEx,
                    'tDataDocNo' => $tSODocNo,
                    'tDataDocKey' => 'TARTSoHD',
                    'tDataSeqNo' => $nSOSeqNo
                );
                $tStaCalDocDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTTempParams);
                if ($tStaCalDocDTTemp === TRUE) {
                    $aReturnData = array(
                        'nStaEvent' => '1',
                        'tStaMessg' => "Update And Calcurate Process Document DT Temp Success."
                    );
                } else {
                    $aReturnData = array(
                        'nStaEvent' => '500',
                        'tStaMessg' => "Error Cannot Calcurate Document DT Temp."
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

    // Function: Remove Product In Documeny Temp
    // Parameters: Document Type
    // Creator: 14/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Status Edit Pdt To Doc DT Temp
    // ReturnType: Object
    public function FSvCSORemovePdtInDTTmp() {
        try {
            $this->db->trans_begin();

            $aDataWhere = array(
                'tBchCode' => $this->input->post('tBchCode'),
                'tDocNo' => $this->input->post('tDocNo'),
                'tPdtCode' => $this->input->post('tPdtCode'),
                'nSeqNo' => $this->input->post('nSeqNo'),
                'tVatInOrEx' => $this->input->post('tVatInOrEx'),
                'tSessionID' => $this->session->userdata('tSesSessionID'),
            );

            $aStaDelPdtDocTemp = $this->mSaleOrder->FSnMSODelPdtInDTTmp($aDataWhere);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Cannot Delete Item.',
                );
            } else {
                $this->db->trans_commit();

                //ถ้าลบสินค้า ต้องวิ่งไปเช็คด้วยว่า มีท้ายบิล ไหม ถ้าสินค้าที่เหลืออยู่ไม่อนุญาติลด ท้ายบิลก็ต้องลบทิ้งด้วย
                $aPackDataCalCulate = array(
                    'tDocNo'        => $this->input->post('tDocNo'),
                    'tBchCode'      => $this->input->post('tBchCode'),
                    'nB4Dis'        => '',
                    'tSplVatType'   => $this->input->post('tVatInOrEx')
                );
                FSaCCNDocumentUpdateHDDisAgain($aPackDataCalCulate);

                // Prorate HD
                FCNaHCalculateProrate('TARTSoHD', $aDataWhere['tDocNo']);
                $aCalcDTParams = [
                    'tDataDocEvnCall' => '',
                    'tDataVatInOrEx' => $aDataWhere['tVatInOrEx'],
                    'tDataDocNo' => $aDataWhere['tDocNo'],
                    'tDataDocKey' => 'TARTSoHD',
                    'tDataSeqNo' => ''
                ];
                FCNbHCallCalcDocDTTemp($aCalcDTParams);
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

    // Function: Remove Product In Documeny Temp Multiple
    // Parameters: Document Type
    // Creator: 26/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Status Event Delte
    // ReturnType: Object
    public function FSvCSORemovePdtInDTTmpMulti() {
        try {
            $this->db->trans_begin();
            $aDataWhere = array(
                'tBchCode' => $this->input->post('ptSOBchCode'),
                'tDocNo' => $this->input->post('ptSODocNo'),
                'tVatInOrEx' => $this->input->post('ptSOVatInOrEx'),
                'aDataPdtCode' => $this->input->post('paDataPdtCode'),
                'aDataPunCode' => $this->input->post('paDataPunCode'),
                'aDataSeqNo' => $this->input->post('paDataSeqNo')
            );

            $aStaDelPdtDocTemp = $this->mSaleOrder->FSnMSODelMultiPdtInDTTmp($aDataWhere);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Cannot Delete Item.',
                );
            } else {
                $this->db->trans_commit();

                //ถ้าลบสินค้า ต้องวิ่งไปเช็คด้วยว่า มีท้ายบิล ไหม ถ้าสินค้าที่เหลืออยู่ไม่อนุญาติลด ท้ายบิลก็ต้องลบทิ้งด้วย
                $aPackDataCalCulate = array(
                    'tDocNo'        => $this->input->post('tDocNo'),
                    'tBchCode'      => $this->input->post('tBchCode'),
                    'nB4Dis'        => '',
                    'tSplVatType'   => $this->input->post('tVatInOrEx')
                );
                FSaCCNDocumentUpdateHDDisAgain($aPackDataCalCulate);
                
                // Prorate HD
                FCNaHCalculateProrate('TARTSoHD', $aDataWhere['tDocNo']);
                $aCalcDTParams = [
                    'tDataDocEvnCall' => '',
                    'tDataVatInOrEx' => $aDataWhere['tVatInOrEx'],
                    'tDataDocNo' => $aDataWhere['tDocNo'],
                    'tDataDocKey' => 'TARTSoHD',
                    'tDataSeqNo' => ''
                ];
                FCNbHCallCalcDocDTTemp($aCalcDTParams);
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

    // =================================================================================== Add / Edit Document ===================================================================================
    // Function: Check Product Have In Temp For Document DT
    // Parameters: Ajex Event Before Save DT
    // Creator: 03/07/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Object Status Check Product DT Temp
    // ReturnType: Object
    public function FSoCSOChkHavePdtForDocDTTemp() {
        try {
            $tSODocNo = $this->input->post("ptSODocNo");
            $tSOSessionID = $this->session->userdata('tSesSessionID');
            $aDataWhere = array(
                'FTXthDocNo' => $tSODocNo,
                'FTXthDocKey' => 'TARTSoHD',
                'FTSessionID' => $tSOSessionID
            );
            $nCountPdtInDocDTTemp = $this->mSaleOrder->FSnMSOChkPdtInDocDTTemp($aDataWhere);
            if ($nCountPdtInDocDTTemp > 0) {
                $aReturnData = array(
                    'nStaReturn' => '1',
                    'tStaMessg' => 'Found Data In Doc DT.'
                );
            } else {
                $aReturnData = array(
                    'nStaReturn' => '800',
                    'tStaMessg' => language('document/saleorder/saleorder', 'tSOPleaseSeletedPDTIntoTable')
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

    // Function: คำนวณค่าจาก DT Temp ให้ HD
    // Parameters: Ajex Event Add Document
    // Creator: 04/07/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Array Data Calcurate DocDTTemp For HD
    // ReturnType: Array
    private function FSaCSOCalDTTempForHD($paParams) {
        $aCalDTTemp = $this->mSaleOrder->FSaMSOCalInDTTemp($paParams);
        if (isset($aCalDTTemp) && !empty($aCalDTTemp)) {
            $aCalDTTempItems = $aCalDTTemp[0];
            // คำนวณหา ยอดปัดเศษ ให้ HD(FCXphRnd)
            $pCalRoundParams = [
                'FCXshAmtV' => $aCalDTTempItems['FCXshAmtV'],
                'FCXshAmtNV' => $aCalDTTempItems['FCXshAmtNV']
            ];
            $aRound = $this->FSaCSOCalRound($pCalRoundParams);
            // คำนวณหา ยอดรวม ให้ HD(FCXphGrand)
            $nRound = $aRound['nRound'];
            $cGrand = $aRound['cAfRound'];

            // จัดรูปแบบข้อความ จากตัวเลขเป็นข้อความ HD(FTXphGndText)
            $tGndText = FCNtNumberToTextBaht(number_format($cGrand, 2));
            $aCalDTTempItems['FCXshRnd'] = $nRound;
            $aCalDTTempItems['FCXshGrand'] = $cGrand;
            $aCalDTTempItems['FTXshGndText'] = $tGndText;
            return $aCalDTTempItems;
        }
    }

    // Function: หาค่าปัดเศษ HD(FCXphRnd)
    // Parameters: Ajex Event Add Document
    // Creator: 04/07/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Array ค่าปักเศษ
    // ReturnType: Array
    private function FSaCSOCalRound($paParams) {
        $tOptionRound = '1';  // ปัดขึ้น
        $cAmtV = $paParams['FCXshAmtV'];
        $cAmtNV = $paParams['FCXshAmtNV'];
        $cBath = $cAmtV + $cAmtNV;
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

    // Function: Add Document 
    // Parameters: Ajex Event Add Document
    // Creator: 03/07/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Object Status Add Document
    // ReturnType: Object
    public function FSoCSOAddEventDoc() {
        try {
            $aDataDocument = $this->input->post();
            $tSOAutoGenCode = (isset($aDataDocument['ocbSOStaAutoGenCode'])) ? 1 : 0;
            $tSODocNo = (isset($aDataDocument['oetSODocNo'])) ? $aDataDocument['oetSODocNo'] : '';
            $tSODocDate = $aDataDocument['oetSODocDate'] . " " . $aDataDocument['oetSODocTime'];
            $tSOStaDocAct = (isset($aDataDocument['ocbSOFrmInfoOthStaDocAct'])) ? 1 : 0;
            // $tSOVATInOrEx = $aDataDocument['ocmSOFrmSplInfoVatInOrEx'];
            $tSOSessionID = $this->session->userdata('tSesSessionID');

            // Get Data Comp.
            $nLangEdit = $this->session->userdata("tLangEdit");
            $aDataWhereComp = array('FNLngID' => $nLangEdit);
            $tASOReq = "";
            $tMethodReq = "GET";
            $aCompData = $this->mCompany->FSaMCMPList($tASOReq, $tMethodReq, $aDataWhereComp);
      
            $tSOVATInOrEx = $aCompData['raItems']['rtCmpRetInOrEx'];//ภาษีขายปลีก ดูตามบริษัท

            $aCalDTTempParams = [
                'tDocNo' => '',
                'tBchCode' => $aDataDocument['oetSOFrmBchCode'],
                'tSessionID' => $tSOSessionID,
                'tDocKey' => 'TARTSoHD'
            ];
            $aCalDTTempForHD = $this->FSaCSOCalDTTempForHD($aCalDTTempParams);
            $aCalInHDDisTemp = $this->mSaleOrder->FSaMSOCalInHDDisTemp($aCalDTTempParams);

            // Array Data Table Document
            $aTableAddUpdate = array(
                'tTableHD' => 'TARTSoHD',
                'tTableHDDis' => 'TARTSoHDDis',
                'tTableHDCst' => 'TARTSoHDCst',
                'tTableDT' => 'TARTSoDT',
                'tTableDTDis' => 'TARTSoDTDis',
                'tTableStaGen' => 1,
                // 'tTableStaGen' => ($aDataDocument['ocmSOFrmSplInfoPaymentType'] == 1) ? 4 : 5,
            );

            // Array Data Where Insert
            $aDataWhere = array(
                'FTBchCode' => $aDataDocument['oetSOFrmBchCode'],
                'FTXshDocNo' => $tSODocNo,
                'FDLastUpdOn' => date('Y-m-d'),
                'FDCreateOn' => date('Y-m-d'),
                'FTCreateBy' => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FTSessionID' => $this->session->userdata('tSesSessionID'),
                'FTXthVATInOrEx' => $tSOVATInOrEx
            );


            //array Data Customer 
            $aDataCustomer = array(
                'FTXshCardID' => $aDataDocument['oetSOFrmCstCtzID'],
                'FTXshCstName' => $aDataDocument['oetSOFrmCustomerName'],
                'FTXshCstTel' =>$aDataDocument['oetSOFrmCstTel'],
                'FTXshStaAlwPosCalSo' =>  empty($aDataDocument['ocbSOStaAlwPosCalSo']) ? 2 : $aDataDocument['ocbSOStaAlwPosCalSo'],
              );

              $nDocType = $this->mSaleOrder->FSnMSOGetDocType();
           
            // Array Data HD Master
            $aDataMaster = array(
                'FTShpCode' => $aDataDocument['oetSOFrmShpCode'],
                // 'FNXphDocType' => intval($aDataDocument['ocmSOFrmSplInfoPaymentType'] == 1 ? 4 : 5),
                'FTCstCode' => $aDataDocument['oetSOFrmCstHNNumber'],
              //  'FTXshCtrName' => $aDataDocument['oetSOFrmCstTel'],
                'FTPosCode' => $aDataDocument['oetSOFrmPosCode'],
                'FTShfCode' => '',
                'FTSpnCode' => $aDataDocument['ohdSOUsrCode'],

                'FNXshDocType' => $nDocType['FNSdtDocType'] ,
                'FDXshDocDate' => (!empty($tSODocDate)) ? $tSODocDate : NULL,
                'FTXshCshOrCrd' => $aDataDocument['ocmSOFrmSplInfoPaymentType'],
                // 'FTXshCshOrCrd' => $aDataDocument['ocmSOFrmSplInfoPaymentType'],
                'FTXshVATInOrEx' => $tSOVATInOrEx,
                'FTDptCode' => $aDataDocument['ohdSODptCode'],
                'FTWahCode' => $aDataDocument['oetSOFrmWahCode'],
                'FTUsrCode' => $aDataDocument['ohdSOUsrCode'],
               // 'FTSplCode' => $aDataDocument['oetSOFrmSplCode'],
                'FTXshRefExt' => $aDataDocument['oetSORefExtDoc'],
                'FDXshRefExtDate' => (!empty($aDataDocument['oetSORefExtDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetSORefExtDocDate'])) : NULL,
                'FTXshRefInt' => $aDataDocument['oetSORefIntDoc'],
                'FDXshRefIntDate' => (!empty($aDataDocument['oetSORefIntDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetSORefIntDocDate'])) : NULL,
                'FNXshDocPrint' => $aDataDocument['ocmSOFrmInfoOthDocPrint'],
                'FTRteCode' => $aDataDocument['ohdSOCmpRteCode'],
                'FCXshRteFac' => $aDataDocument['ohdSORteFac'],
                'FCXshTotal' => $aCalDTTempForHD['FCXshTotal'],
                'FCXshTotalNV' => $aCalDTTempForHD['FCXshTotalNV'],
                'FCXshTotalNoDis' => $aCalDTTempForHD['FCXshTotalNoDis'],
                'FCXshTotalB4DisChgV' => $aCalDTTempForHD['FCXshTotalB4DisChgV'],
                'FCXshTotalB4DisChgNV' => $aCalDTTempForHD['FCXshTotalB4DisChgNV'],
                'FTXshDisChgTxt' => isset($aCalInHDDisTemp['FTXshDisChgTxt']) ? $aCalInHDDisTemp['FTXshDisChgTxt'] : '',
                'FCXshDis' => isset($aCalInHDDisTemp['FCXshDis']) ? $aCalInHDDisTemp['FCXshDis'] : NULL,
                'FCXshChg' => isset($aCalInHDDisTemp['FCXshChg']) ? $aCalInHDDisTemp['FCXshChg'] : NULL,
                'FCXshTotalAfDisChgV' => $aCalDTTempForHD['FCXshTotalAfDisChgV'],
                'FCXshTotalAfDisChgNV' => $aCalDTTempForHD['FCXshTotalAfDisChgNV'],
                'FCXshAmtV' => $aCalDTTempForHD['FCXshAmtV'],
                'FCXshAmtNV' => $aCalDTTempForHD['FCXshAmtNV'],
                'FCXshVat' => $aCalDTTempForHD['FCXshVat'],
                'FCXshVatable' => $aCalDTTempForHD['FCXshVatable'],
                'FTXshWpCode' => $aCalDTTempForHD['FTXshWpCode'],
                'FCXshWpTax' => $aCalDTTempForHD['FCXshWpTax'],
                'FCXshGrand' => $aCalDTTempForHD['FCXshGrand'],
                'FCXshRnd' => $aCalDTTempForHD['FCXshRnd'],
                'FTXshGndText' => $aCalDTTempForHD['FTXshGndText'],
                'FTXshRmk' => $aDataDocument['otaSOFrmInfoOthRmk'],
                'FTXshStaRefund' => $aDataDocument['ohdSOStaRefund'],
                'FTXshStaDoc' => $aDataDocument['ohdSOStaDoc'],
                'FTXshStaApv' => !empty($aDataDocument['ohdSOStaApv']) ? $aDataDocument['ohdSOStaApv'] : NULL,
                'FTXshStaPaid' => $aDataDocument['ohdSOStaPaid'],
                'FNXshStaDocAct' => $tSOStaDocAct,
                'FNXshStaRef' => $aDataDocument['ocmSOFrmInfoOthRef']
            );



            $this->db->trans_begin();

            // Check Auto GenCode Document
            if ($tSOAutoGenCode == '1') {
                $aSOGenCode = FCNaHGenCodeV5($aTableAddUpdate['tTableHD'], $aTableAddUpdate['tTableStaGen']);
                // echo '<pre>';
                // print_r($aSOGenCode);
                // echo '</pre>';
                // die();
                if ($aSOGenCode['rtCode'] == '1') {
                    $aDataWhere['FTXshDocNo'] = $aSOGenCode['rtXshDocNo'];
                }
            } else {
                $aDataWhere['FTXshDocNo'] = $tSODocNo;
            }

            // Add Update Document HD
            $this->mSaleOrder->FSxMSOAddUpdateHD($aDataMaster, $aDataWhere, $aTableAddUpdate);

            // Add Update HD Cst
            $this->mSaleOrder->FSxMSOAddUpdateHDCst($aDataCustomer,$aDataWhere, $aTableAddUpdate);

            // Update Doc No Into Doc Temp
            $this->mSaleOrder->FSxMSOAddUpdateDocNoToTemp($aDataWhere, $aTableAddUpdate);

            // Move Doc HD Dis Temp To HDDis
            $this->mSaleOrder->FSaMSOMoveHdDisTempToHdDis($aDataWhere, $aTableAddUpdate);

            // Move Doc DTTemp To DT
            $this->mSaleOrder->FSaMSOMoveDtTmpToDt($aDataWhere, $aTableAddUpdate);

            // Move Doc DTDisTemp To DTTemp
            $this->mSaleOrder->FSaMSOMoveDtDisTempToDtDis($aDataWhere, $aTableAddUpdate);

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
                    'nStaCallBack' => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn' => $aDataWhere['FTXshDocNo'],
                    'nStaReturn' => '1',
                    'tStaMessg' => 'Success Add Document.'
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

    // Function: Edit Document 
    // Parameters: Ajex Event Add Document
    // Creator: 03/07/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Object Status Add Document
    // ReturnType: Object
    public function FSoCSOEditEventDoc() {
        try {
            $aDataDocument = $this->input->post();
            $tSOAutoGenCode = (isset($aDataDocument['ocbSOStaAutoGenCode'])) ? 1 : 0;
            $tSODocNo = (isset($aDataDocument['oetSODocNo'])) ? $aDataDocument['oetSODocNo'] : '';
            $tSODocDate = $aDataDocument['oetSODocDate'] . " " . $aDataDocument['oetSODocTime'];
            $tSOStaDocAct = (isset($aDataDocument['ocbSOFrmInfoOthStaDocAct'])) ? 1 : 0;
            // $tSOVATInOrEx = $aDataDocument['ocmSOFrmSplInfoVatInOrEx'];
            $tSOSessionID = $this->session->userdata('tSesSessionID');

            // Get Data Comp.
            $nLangEdit = $this->session->userdata("tLangEdit");
            $aDataWhereComp = array('FNLngID' => $nLangEdit);
            $tASOReq = "";
            $tMethodReq = "GET";
            $aCompData = $this->mCompany->FSaMCMPList($tASOReq, $tMethodReq, $aDataWhereComp);
            $tSOVATInOrEx = $aCompData['raItems']['rtCmpRetInOrEx'];//ภาษีขายปลีก ดูตามบริษัท
        
            $aCalDTTempParams = [
                'tDocNo' => '',
                'tBchCode' => $aDataDocument['oetSOFrmBchCode'],
                'tSessionID' => $tSOSessionID,
                'tDocKey' => 'TARTSoHD'
            ];
            $aCalDTTempForHD = $this->FSaCSOCalDTTempForHD($aCalDTTempParams);
            $aCalInHDDisTemp = $this->mSaleOrder->FSaMSOCalInHDDisTemp($aCalDTTempParams);

            // Array Data Table Document
            $aTableAddUpdate = array(
                'tTableHD' => 'TARTSoHD',
                'tTableHDDis' => 'TARTSoHDDis',
                'tTableHDCst' => 'TARTSoHDCst',
                'tTableDT' => 'TARTSoDT',
                'tTableDTDis' => 'TARTSoDTDis',
                'tTableStaGen' => 1,
            );

          //array Data Customer 
           $aDataCustomer = array(
              'FTXshCardID' => $aDataDocument['oetSOFrmCstCtzID'],
              'FTXshCstName' => $aDataDocument['oetSOFrmCustomerName'],
              'FTXshCstTel' =>$aDataDocument['oetSOFrmCstTel'],
              'FTXshStaAlwPosCalSo' =>  empty($aDataDocument['ocbSOStaAlwPosCalSo']) ? 2 : $aDataDocument['ocbSOStaAlwPosCalSo'],
            );

            // Array Data Where Insert
            $aDataWhere = array(
                'FTBchCode' => $aDataDocument['oetSOFrmBchCode'],
                'FTXshDocNo' => $tSODocNo,
                'FDLastUpdOn' => date('Y-m-d'),
                'FDCreateOn' => date('Y-m-d'),
                'FTCreateBy' => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FTSessionID' => $this->session->userdata('tSesSessionID'),
                'FTXthVATInOrEx' => $tSOVATInOrEx
            );

            $nDocType = $this->mSaleOrder->FSnMSOGetDocType();
            // Array Data HD Master
            $aDataMaster = array(
                'FTShpCode' => $aDataDocument['oetSOFrmShpCode'],
                'FNXshDocType' => $nDocType['FNSdtDocType'],
                'FDXshDocDate' => (!empty($tSODocDate)) ? $tSODocDate : NULL,
                'FTXshCshOrCrd' => $aDataDocument['ocmSOFrmSplInfoPaymentType'],
                'FTXshVATInOrEx' => $tSOVATInOrEx,
                'FTDptCode' => $aDataDocument['ohdSODptCode'],
                'FTWahCode' => $aDataDocument['oetSOFrmWahCode'],
                'FTUsrCode' => $aDataDocument['ohdSOUsrCode'],
          //      'FTSplCode' => $aDataDocument['oetSOFrmSplCode'],
                'FTCstCode' => $aDataDocument['oetSOFrmCstHNNumber'],
                //  'FTXshCtrName' => $aDataDocument['oetSOFrmCstTel'],
                'FTPosCode' => $aDataDocument['oetSOFrmPosCode'],
                'FTShfCode' => '',
                'FTSpnCode' => $aDataDocument['ohdSOUsrCode'],

                'FTXshRefExt' => $aDataDocument['oetSORefExtDoc'],
                'FDXshRefExtDate' => (!empty($aDataDocument['oetSORefExtDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetSORefExtDocDate'])) : NULL,
                'FTXshRefInt' => $aDataDocument['oetSORefIntDoc'],
                'FDXshRefIntDate' => (!empty($aDataDocument['oetSORefIntDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetSORefIntDocDate'])) : NULL,
                'FNXshDocPrint' => $aDataDocument['ocmSOFrmInfoOthDocPrint'],
                'FTRteCode' => $aDataDocument['ohdSOCmpRteCode'],
                'FCXshRteFac' => $aDataDocument['ohdSORteFac'],
                'FCXshTotal' => $aCalDTTempForHD['FCXshTotal'],
                'FCXshTotalNV' => $aCalDTTempForHD['FCXshTotalNV'],
                'FCXshTotalNoDis' => $aCalDTTempForHD['FCXshTotalNoDis'],
                'FCXshTotalB4DisChgV' => $aCalDTTempForHD['FCXshTotalB4DisChgV'],
                'FCXshTotalB4DisChgNV' => $aCalDTTempForHD['FCXshTotalB4DisChgNV'],
                'FTXshDisChgTxt' => isset($aCalInHDDisTemp['FTXshDisChgTxt']) ? $aCalInHDDisTemp['FTXshDisChgTxt'] : '',
                'FCXshDis' => isset($aCalInHDDisTemp['FCXshDis']) ? $aCalInHDDisTemp['FCXshDis'] : NULL,
                'FCXshChg' => isset($aCalInHDDisTemp['FCXshChg']) ? $aCalInHDDisTemp['FCXshChg'] : NULL,
                'FCXshTotalAfDisChgV' => $aCalDTTempForHD['FCXshTotalAfDisChgV'],
                'FCXshTotalAfDisChgNV' => $aCalDTTempForHD['FCXshTotalAfDisChgNV'],
                'FCXshAmtV' => $aCalDTTempForHD['FCXshAmtV'],
                'FCXshAmtNV' => $aCalDTTempForHD['FCXshAmtNV'],
                'FCXshVat' => $aCalDTTempForHD['FCXshVat'],
                'FCXshVatable' => $aCalDTTempForHD['FCXshVatable'],
                'FTXshWpCode' => $aCalDTTempForHD['FTXshWpCode'],
                'FCXshWpTax' => $aCalDTTempForHD['FCXshWpTax'],
                'FCXshGrand' => $aCalDTTempForHD['FCXshGrand'],
                'FCXshRnd' => $aCalDTTempForHD['FCXshRnd'],
                'FTXshGndText' => $aCalDTTempForHD['FTXshGndText'],
                'FTXshRmk' => $aDataDocument['otaSOFrmInfoOthRmk'],
                'FTXshStaRefund' => $aDataDocument['ohdSOStaRefund'],
                'FTXshStaDoc' => !empty($aDataDocument['ohdSOStaDoc']) ? $aDataDocument['ohdSOStaDoc'] : NULL,
                'FTXshStaApv' => !empty($aDataDocument['ohdSOStaApv']) ? $aDataDocument['ohdSOStaApv'] : NULL,
                'FTXshStaPaid' => $aDataDocument['ohdSOStaPaid'],
                'FNXshStaDocAct' => $tSOStaDocAct,
                'FNXshStaRef' => $aDataDocument['ocmSOFrmInfoOthRef']
            );

            // Array Data HD Supplier date('Y-m-d H:i:s', $old_date_timestamp);
      
            $this->db->trans_begin();

            // Check Auto GenCode Document
            if ($tSOAutoGenCode == '1') {
                $aSOGenCode = FCNaHGenCodeV5($aTableAddUpdate['tTableHD'], $aTableAddUpdate['tTableStaGen']);
                if ($aSOGenCode['rtCode'] == '1') {
                    $aDataWhere['FTXshDocNo'] = $aSOGenCode['rtXshDocNo'];
                }
            } else {
                $aDataWhere['FTXshDocNo'] = $tSODocNo;
            }
      
            // Add Update Document HD
            $this->mSaleOrder->FSxMSOAddUpdateHD($aDataMaster, $aDataWhere, $aTableAddUpdate);

            // Add Update HD Cst
            $this->mSaleOrder->FSxMSOAddUpdateHDCst($aDataCustomer,$aDataWhere, $aTableAddUpdate);

            // Update Doc No Into Doc Temp
            $this->mSaleOrder->FSxMSOAddUpdateDocNoToTemp($aDataWhere, $aTableAddUpdate);

            // Move Doc HD Dis Temp To HDDis
            $this->mSaleOrder->FSaMSOMoveHdDisTempToHdDis($aDataWhere, $aTableAddUpdate);

            // Move Doc DTTemp To DT
            $this->mSaleOrder->FSaMSOMoveDtTmpToDt($aDataWhere, $aTableAddUpdate);

            // Move Doc DTDisTemp To DTTemp
            $this->mSaleOrder->FSaMSOMoveDtDisTempToDtDis($aDataWhere, $aTableAddUpdate);


            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Error Unsucess Add Document."
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaCallBack' => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn' => $aDataWhere['FTXshDocNo'],
                    'nStaReturn' => '1',
                    'tStaMessg' => 'Success Add Document.'
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

    // =================================================================================== Cancel / Approve / Print  ===================================================================================
    // Function: Cancel Document
    // Parameters: Ajex Event Add Document
    // Creator: 09/07/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Object Status Cancel Document
    // ReturnType: Object
    public function FSvCSOCancelDocument() {
        try {
            $tSODocNo = $this->input->post('ptSODocNo');
            $aDataUpdate = array(
                'tDocNo' => $tSODocNo,
            );

            $aStaApv = $this->mSaleOrder->FSaMSOCancelDocument($aDataUpdate);
            $aReturnData = $aStaApv;
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }


    // Function: Approve Document
    // Parameters: Ajex Event Add Document
    // Creator: 09/07/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Object Status Cancel Document
    // ReturnType: Object
    public function FSvCSOApproveDocument() {
        $tSODocNo = $this->input->post('ptSODocNo');
        $tSOBchCode = $this->input->post('ptSOBchCode');
        $tSOStaApv = $this->input->post('ptSOStaApv');
        $tSOSplPaymentType = $this->input->post('ptSOSplPaymentType');
        $tSOInfoOthRmkAprov = $this->input->post('tSOInfoOthRmkAprov');
        $tSOtiemNotApr = json_decode($this->input->post('thdSOtiemNotApr'), true);

        $aDataDelObj = array(
            'tSOtiemNotApr' => $tSOtiemNotApr,
            'tDocNo'      => $tSODocNo
        );

        // die();
    //    $this->db->trans_begin();
        try {



            $aDataUpdate = array(
                'tDocNo'      => $tSODocNo,
                'tApvCode'    => $this->session->userdata('tSesUsername'),
                'tTableDocHD' => 'TARTSoHD',
                'tBchCode'    => $tSOBchCode
            );

            $tCheckAprLeve = FSnDOHCheckLevelApr($aDataUpdate);//ตรวจสอบผู้อนุมัติเอกสาร

            // echo '<pre>';
            // print_r($tCheckAprSeq);
            // echo '</pre>';
            // die();
            if($tCheckAprLeve['tReturnCode']=='200'){
                //Do some thing for event multi aprove
                $aDataSet = array(
                    'FTDatRefCode' => $tSODocNo,
                    'FTBchCode'    => $tSOBchCode,
                    'FTDatUsrApv'  => $this->session->userdata('tSesUsername'),
                    'FDDatDateApv' => date('Y-m-d H:i:s'),
                    'FTDatRmk'     => $tSOInfoOthRmkAprov,
                    'tRoleCode'    => $this->session->userdata('tSesUsrRoleCode'),
                    'tTableDocHD' => 'TARTSoHD',
                );
              $aReturn = FSnDOHAInsertForMultiAprve($aDataSet);

              $tCheckAprSeq = FNaDOHNCheckSeqAprve($aDataUpdate);//ตรวจสอบข้อมูลสถานะอนุมัติ

              $nTotalDocApr = count($tCheckAprSeq);//จำนวนที่ต้องอนุมัติ
              $LastAprSeq = $tCheckAprSeq[0]['LastApvSeq'];//ลำดับอนุมัติปัจจุบัน

              if($nTotalDocApr==$LastAprSeq){//หากอนุมัติครบจำนวนแล้วให้อัพเดทตาราง HD
                $aDataUpdate['nStaApv']=1;//success จบเลย
                $aStaApv = $this->mSaleOrder->FSaMSOApproveDocument($aDataUpdate);
                $aReturn = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success Document Approve.'
                );
            }else{
                $aDataUpdate['nStaApv']=2;//อยู่ระหว่างการอนุมัติ
                $aStaApv = $this->mSaleOrder->FSaMSOApproveDocument($aDataUpdate);
            }


                
        if(!empty($tSOtiemNotApr)){ //เฉพาะการอนุมัติรูปภาพ เพิ่มสินค้าที่ไม่ได้อนุมัติในตาราง DelOject
            $aDataDelObj = array(
                'tSOtiemNotApr' => $tSOtiemNotApr,
                'tDocNo'      => $tSODocNo,
                'tBchCode'    => $tSOBchCode,
                'tSesUsername'    => $this->session->userdata('tSesUsername'),
            );
            $this->mSaleOrder->FSxMSONotAproveItem($aDataDelObj);
        }

            }else{

                if($tCheckAprLeve['tReturnCode']=='202'){
                //do some this for normal aprove 
                     $aDataUpdate['nStaApv']=1;//success จบเลย
                    $aStaApv = $this->mSaleOrder->FSaMSOApproveDocument($aDataUpdate);
                    $aReturn = array(
                        'nStaEvent' => '1',
                        'tStaMessg' => 'Success Document Approve.'
                    );
                }else{
                    // $aReturn=$tCheckAprLeve;

                    $aReturn = array(
                        'nStaEvent' => $tCheckAprLeve['tReturnCode'],
                        'tStaMessg' => $tCheckAprLeve['tReturnMsg']
                    );
                }

            }

    

            echo json_encode($aReturn);
           
            $aMQParams = [
                "queuesname" => "MQAPROVE".$this->session->userdata('tSesSessionID'),
                "exchangname" => "EX_MQApprove",
                "params" => [
                    "ptBchCode" => $tSOBchCode,
                    "ptDocNo" => $tSODocNo,
                    "ptDocType" => 1,
                    "ptUser" => $this->session->userdata('tSesUsername'),
                    "ptConnStr" => 0
                ]
            ];
            FCNxSendExchange($aMQParams);
            return;
        } catch (ErrorException $err) {
            // $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => language('common/main/main', 'tApproveFail')
            );
            echo json_encode($aReturn);
            return;
        }
    }

    // Function: Function Searh And Add Pdt In Tabel Temp
    // Parameters: Ajex Event Add Document
    // Creator: 30/07/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Object Status Searh And Add Pdt In Tabel Temp
    // ReturnType: Object
    public function FSoCSOSearchAndAddPdtIntoTbl() {
        try {
            $tSOBchCode = $this->input->post('ptSOBchCode');
            $tSODocNo = $this->input->post('ptSODocNo');
            $tSODataSearchAndAdd = $this->input->post('ptSODataSearchAndAdd');
            $tSOStaReAddPdt = $this->input->post('ptSOStaReAddPdt');
            $tSOSessionID = $this->session->userdata('tSesSessionID');
            $nLangEdit = $this->session->userdata("tLangID");
            // เช็คข้อมูลในฐานข้อมูล
            $aDataChkINDB = array(
                'FTBchCode' => $tSOBchCode,
                'FTXthDocNo' => $tSODocNo,
                'FTXthDocKey' => 'TARTSoHD',
                'FTSessionID' => $tSOSessionID,
                'tSODataSearchAndAdd' => trim($tSODataSearchAndAdd),
                'tSOStaReAddPdt' => $tSOStaReAddPdt,
                'nLangEdit' => $nLangEdit
            );

            $aCountDataChkInDTTemp = $this->mSaleOrder->FSaCSOCountPdtBarInTablePdtBar($aDataChkINDB);
            $nCountDataChkInDTTemp = isset($aCountDataChkInDTTemp) && !empty($aCountDataChkInDTTemp) ? count($aCountDataChkInDTTemp) : 0;
            if ($nCountDataChkInDTTemp == 1) {
                // สินค้าหรือ BarCode ทีกรอกมี 1 ตัวให้เอาลง หรือ เช็ค สถานะ Appove ได้เลย
            } else if ($nCountDataChkInDTTemp > 1) {
                // มี Bar Code มากกว่า 1 ให้แสดง Modal
            } else {
                // ไม่พบข้อมูลบาร์โค๊ดกับรหัสสินค้าในระบบ 
                $aReturnData = array(
                    'nStaEvent' => 800,
                    'tStaMessg' => language('document/saleorder/saleorder', 'tSONotFoundPdtCodeAndBarcode')
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

    // Function: Clear Data In DocTemp
    // Parameters: Ajex Event Add Document
    // Creator: 13/08/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Object Status Clear Data In Document Temp
    // ReturnType: Object
    public function FSoCSOClearDataInDocTemp() {
        try {
            $this->db->trans_begin();

            // Clear Data Product IN Doc Temp
            $aWhereClearTemp = [
                'FTXthDocNo' => $this->input->post('ptSODocNo'),
                'FTXthDocKey' => 'TARTSoHD',
                'FTSessionID' => $this->session->userdata('tSesSessionID')
            ];
            $this->mSaleOrder->FSxMSOClearDataInDocTemp($aWhereClearTemp);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaReturn' => 900,
                    'tStaMessg' => "Error Not Delete Document Temp."
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn' => 1,
                    'tStaMessg' => 'Success Delete Document Temp.'
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaReturn' => 500,
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }
    
    /**
     * Function: Print Document
     * Parameters: Ajax Event Add Document
     * Creator: 27/08/2019 Piya
     * LastUpdate: -
     * Return: Object Status Print Document
     * ReturnType: Object
     */
    public function FSoCSOPrintDoc() {
        
    }

}



