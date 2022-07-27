<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Topupvending_controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('company/company/Company_model');
        $this->load->model('document/topupVending/Topupvending_model');
        $this->load->model('payment/rate/Rate_model');
        $this->load->model('company/vatrate/Vatrate_model');
        $this->load->model('company/branch/Branch_model');
        $this->load->model('company/shop/Shop_model');
        $this->load->model('authen/login/Login_model');
    }

    public function index($nBrowseType, $tBrowseOption)
    {
        $aData['nBrowseType'] = $nBrowseType;
        $aData['tBrowseOption'] = $tBrowseOption;
        $aData['aAlwEvent'] = FCNaHCheckAlwFunc('TWXVD/0/0');
        $aData['vBtnSave'] = FCNaHBtnSaveActiveHTML('TWXVD/0/0');
        $aData['nOptDecimalShow'] = FCNxHGetOptionDecimalShow();
        $aData['nOptDecimalSave'] = FCNxHGetOptionDecimalSave();
        $this->load->view('document/topupVending/wTopupVending', $aData);
    }

    /**
     * Functionality : Main Page List
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : List Page
     * Return Type : View
     */
    public function FSxCTUVTopupVendingList()
    {
        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");
        $aData = array(
            'FTBchCode'    => $this->session->userdata("tSesUsrBchCode"),
            'FTShpCode'    => '',
            'nPage' => 1,
            'nRow' => 20,
            'FNLngID' => $nLangEdit,
            'tSearchAll' => ''
        );

        $aBchData = $this->Branch_model->FSnMBCHList($aData);
        $aShpData = $this->Shop_model->FSaMSHPList($aData);
        $aDataMaster = array(
            'aBchData' => $aBchData,
            'aShpData' => $aShpData
        );

        $this->load->view('document/topupVending/wTopupVendingList', $aDataMaster);
    }

    /**
     * Functionality : Get HD Table List
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : HD Table List
     * Return Type : View
     */
    public function FSxCTUVTopupVendingDataTable()
    {
        $tAdvanceSearchData = $this->input->post('oAdvanceSearch');
        $nPage = $this->input->post('nPageCurrent');
        $aAlwEvent = FCNaHCheckAlwFunc('TWXVD/0/0');
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();



        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }

        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");
        $aData = array(
            'FNLngID' => $nLangEdit,
            'nPage' => $nPage,
            'nRow' => 10,
            'aAdvanceSearch' => json_decode($tAdvanceSearchData, true)
        );

        $aResList = $this->Topupvending_model->FSaMHDList($aData);
        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow
        );

        $this->load->view('document/topupVending/wTopupVendingDatatable', $aGenTable);
    }

    /**
     * Functionality : Add Page
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Add Page
     * Return Type : View
     */
    public function FSxCTUVTopupVendingAddPage()
    {
        $tUserSessionID = $this->session->userdata('tSesSessionID');

        $aInfoWhere = array(
            "tBchCode" => $this->input->post("tBchCode"),
            "FTXthDocKey" => "TCNTPdtAdjStkHD"
        );
        $this->Topupvending_model->FSxMDeleteDoctemForNewEvent($aInfoWhere);

        $aClearPdtLayoutInTmpParams = [
            'tUserSessionID' => $tUserSessionID,
            'tDocKey' => 'TVDTPdtTwxHD'
        ];
        $this->Topupvending_model->FSxMClearPdtLayoutInTmp($aClearPdtLayoutInTmpParams);

        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $nOptDocSave = FCNnHGetOptionDocSave();
        $nOptScanSku = FCNnHGetOptionScanSku();
        // $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aDataWhere  = array(
            'FNLngID' => $nLangEdit
        );

        $tAPIReq = "";
        $tMethodReq = "GET";
        $aResList = $this->Company_model->FSaMCMPList($tAPIReq, $tMethodReq, $aDataWhere);

        if ($aResList['rtCode'] == '1') {
            $tBchCode = $aResList['raItems']['rtCmpBchCode'];
            $tCompCode = $aResList['raItems']['rtCmpCode'];
            $tCmpRteCode = $aResList['raItems']['rtCmpRteCode'];
            $tVatCode = $aResList['raItems']['rtVatCodeUse'];
            $aVatRate = FCNoHCallVatlist($tVatCode);
            if (count($aVatRate) != 0) {
                $cVatRate = $aVatRate['FCVatRate'][0];
            } else {
                $cVatRate = "";
            }

            $aDataRate = array(
                'FTRteCode' => $tCmpRteCode,
                'FNLngID' => $nLangEdit
            );

            $aResultRte = $this->Rate_model->FSaMRTESearchByID($aDataRate);
            $cXthRteFac = $aResultRte['raItems']['rcRteRate'];
        } else {
            $tBchCode = "";
            $tCompCode = "";
            $tCmpRteCode = "";
            $tVatCode = "";
            $cVatRate = "";
            $cXthRteFac = "";
        }

        $tUsrLogin = $this->session->userdata('tSesUsername');
        $tDptCode = FCNnDOCGetDepartmentByUser($tUsrLogin);

        $aDataShp  = array(
            'FNLngID'   => $nLangEdit,
            'tUsrLogin' => $tUsrLogin
        );
        $aDataUserGroup = $this->Topupvending_model->FStTFWGetShpCodeForUsrLogin($aDataShp);

        if ($aDataUserGroup == '') {
            $tBchCode = '';
            $tBchName = '';
            $tMchCode = '';
            $tMchName = '';
            $tShpCodeStart = "";
            $tShpNameStart = "";
            $tShpCodeEnd = "";
            $tShpNameEnd = "";
            $tWahCodeStart = "";
            $tWahNameStart = "";
            $tWahCodeEnd = "";
            $tWahNameEnd = "";
            $tShpTypeStart = "";
        } else {
            $tShpTypeStart = $aDataUserGroup["FTShpType"];
            // เช็ค user ว่ามีการผูกสาขาไว้หรือไม่
            if ($aDataUserGroup["FTBchCode"] == '') {
                // ถ้าว่าง ให้ Get Option Def
                $tBchCode = '';
                $tBchName = '';
            } else {
                $tBchCode = $aDataUserGroup["FTBchCode"];
                $tBchName = $aDataUserGroup["FTBchName"];
            }
            // เช็ค user ว่ามีการผูกสาขาไว้หรือไม่
            $tMchCode = $aDataUserGroup["FTMerCode"];
            $tMchName = $aDataUserGroup["FTMerName"];
            // เช็ค user ว่ามีการผูกร้านค้าไว้หรือไม่
            if ($aDataUserGroup["FTShpCode"] == '') {
                // ถ้าว่าง ให้ Get Option Def
                $tShpCodeStart = "";
                $tShpNameStart = "";
                $tShpCodeEnd = "";
                $tShpNameEnd = "";
                $tWahCodeStart = "";
                $tWahNameStart = "";
                $tWahCodeEnd = "";
                $tWahNameEnd = "";
            } else {
                $tShpCodeStart      = $aDataUserGroup["FTShpCode"];
                $tShpNameStart      = $aDataUserGroup["FTShpName"];
                $tShpCodeEnd        = "";
                $tShpNameEnd        = "";
                $tWahCodeStart      = $aDataUserGroup["FTWahCode"];
                $tWahNameStart      = $aDataUserGroup["FTWahName"];
                $tWahCodeEnd        = "";
                $tWahNameEnd        = "";
            }
        }

        $aDataAdd = array(
            'aResult'           =>  array('rtCode' => '99'),
            'aResultOrdDT'      =>  array('rtCode' => '99'),
            'nOptDecimalShow'   =>  $nOptDecimalShow,
            'nOptScanSku'       =>  $nOptScanSku,
            'nOptDocSave'       =>  $nOptDocSave,
            'tCmpRteCode'       =>  $tCmpRteCode,
            'tVatCode'          =>  $tVatCode,
            'cVatRate'          =>  $cVatRate,
            'cXthRteFac'        =>  $cXthRteFac,
            'tDptCode'          =>  $tDptCode,
            'tMchCode'          =>  $tMchCode,
            'tMchName'          =>  $tMchName,
            'tShpCodeStart'     =>  $tShpCodeStart,
            'tShpNameStart'     =>  $tShpNameStart,
            'tShpTypeStart'     =>  $tShpTypeStart,
            'tShpCodeEnd'       =>  $tShpCodeEnd,
            'tShpNameEnd'       =>  $tShpNameEnd,
            'tWahCodeStart'     =>  $tWahCodeStart,
            'tWahNameStart'     =>  $tWahNameStart,
            'tWahCodeEnd'       =>  $tWahCodeEnd,
            'tWahNameEnd'       =>  $tWahNameEnd,
            'tCompCode'         =>  $tCompCode,
            'tBchCode'          =>  $tBchCode,
            'tBchName'          =>  $tBchName,
            'tBchCompCode'      =>  FCNtGetBchInComp(),
            'tBchCompName'      =>  FCNtGetBchNameInComp()
        );
        $this->load->view('document/topupVending/wTopupVendingPageadd', $aDataAdd);
    }

    /**
     * Functionality : Add Event
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCTUVTopupVendingAddEvent()
    {
        try {
            $tUserSessionID = $this->session->userdata('tSesSessionID');
            $dXthDocDate = $this->input->post('oetTopUpVendingDocDate') . " " . $this->input->post('oetTopUpVendingDocTime');
            $aDataMaster = array(
                'tIsAutoGenCode'        => $this->input->post('ocbTopUpVendingAutoGenCode'),
                'FTBchCode'             => $this->input->post('oetTopUpVendingBCHCode'),
                'FTXthDocNo'            => $this->input->post('oetTopUpVendingDocNo'),
                'FDXthDocDate'          => $dXthDocDate,
                'FTXthVATInOrEx'        => '',
                'FTDptCode'             => $this->input->post('ohdTopUpVendingDptCode'),
                'FTXthMerCode'          => $this->input->post('oetTopUpVendingMchCode'),
                'FTXthShopFrm'          => $this->input->post('oetTopUpVendingShpCode'),
                'FTXthShopTo'           => $this->input->post('oetTopUpVendingShpCode'),
                'FTXthPosFrm'           => $this->input->post('oetTopUpVendingPosCode'),
                'FTXthPosTo'            => $this->input->post('oetTopUpVendingPosCode'),
                'FTUsrCode'             => $this->input->post('oetTopUpVendingUsrCode'),
                'FTSpnCode'             => '',
                'FTXthApvCode'           => '',  // สถานะ อนุมัติ เอกสาร ว่าง:ยังไม่ทำ, 1:อนุมัติแล้ว 
                'FTXthRefExt'           => $this->input->post('oetXthRefExt'),
                'FDXthRefExtDate'       => $this->input->post('oetXthRefExtDate') != '' ? $this->input->post('oetXthRefExtDate') : NULL,
                'FTXthRefInt'           => $this->input->post('oetXthRefInt'),
                'FDXthRefIntDate'       => $this->input->post('oetXthRefIntDate') != '' ? $this->input->post('oetXthRefIntDate') : NULL,
                'FNXthDocPrint'         => 0,
                'FCXthTotal'            => 0, // ยอดรวมก่อนลด
                'FCXthVat'              => '',
                'FCXthVatable'          => '',
                'FTXthRmk'              => $this->input->post('otaTopUpVendingRmk'),
                'FTXthStaDoc'           => 1,   // 1 after save
                'FTXthStaApv'           => '',
                'FTXthStaPrcStk'        => '',  // สถานะ ประมวลผลสต๊อก ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FTXthStaDelMQ'         => '',
                'FNXthStaDocAct'        => $this->input->post('ocbTopUpVendingXthStaDocAct'), // สถานะ ประมวลผลสต๊อก ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FNXthStaRef'           => $this->input->post('ostTopUpVendingXthStaRef'),   // Default 0
                'FTRsnCode'             => "",

                // 'FTXthWhFrm'            => $this->input->post('ohdWahCodeStart'),
                // 'FTXthWhTo'             => $this->input->post('ohdWahCodeEnd'),

                'FDLastUpdOn'           => date('Y-m-d'),
                'FDCreateOn'            => date('Y-m-d'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername')
            );

            $this->db->trans_begin();

            // Setup Doc No.
            if ($aDataMaster['tIsAutoGenCode'] == '1') { // Check Auto Gen Reason Code?
                // Auto Gen Reason Code
                $aGenCode = FCNaHGenCodeV5('TVDTPdtTwxHD', '1');
                if ($aGenCode['rtCode'] == '1') {
                    $aDataMaster['FTXthDocNo'] = $aGenCode['rtXthDocNo'];
                }
            }

            // ข้อมูลการขนส่ง
            $aAddUpdateHDRefParams = array(
                'FTBchCode' => $aDataMaster['FTBchCode'],
                'FTXthDocNo' => $aDataMaster['FTXthDocNo'],
                'FTXthCtrName' => $this->input->post('oetTopUpVendingXthCtrName'),
                'FDXthTnfDate' => $this->input->post('oetTopUpVendingXthTnfDate'),
                'FTXthRefTnfID' => $this->input->post('oetTopUpVendingXthRefTnfID'),
                'FTXthRefVehID' => $this->input->post('oetTopUpVendingXthRefVehID'),
                'FTXthQtyAndTypeUnit' => $this->input->post('oetTopUpVendingXthQtyAndTypeUnit'),
                'FNXthShipAdd' => $this->input->post('ohdTopUpVendingXthShipAdd'),
                'FTViaCode' => $this->input->post('oetTopUpVendingViaCode'),
            );

            $this->Topupvending_model->FSaMAddUpdateHD($aDataMaster);
            $this->Topupvending_model->FSaMAddUpdateHDRef($aAddUpdateHDRefParams);

            $aUpdateDocNoInTmpParams = [
                'FTXthDocNo' => $aDataMaster['FTXthDocNo'],
                'FTXthDocKey' => 'TVDTPdtTwxHD',
                'tUserSessionID' => $tUserSessionID
            ];
            $this->Topupvending_model->FSaMUpdateDocNoInTmp($aUpdateDocNoInTmpParams); // Update DocNo ในตาราง Doctemp

            $aTempToDTParams = [
                'tDocNo' => $aDataMaster['FTXthDocNo'],
                'tBchCode' => $aDataMaster['FTBchCode'],
                'tDocKey' => 'TVDTPdtTwxHD',
                'tUserSessionID' => $tUserSessionID
            ];
            $this->Topupvending_model->FSaMTempToDT($aTempToDTParams); // คัดลอกข้อมูลจาก Temp to DT

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack' => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn' => $aDataMaster['FTXthDocNo'],
                    'nStaEvent'    => '1',
                    'tStaMessg' => 'Success Add'
                );
            }

            $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    /**
     * Functionality : Edit Page
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Edit Page
     * Return Type : View
     */
    public function FSvCTUVTopupVendingEditPage()
    {
        $tDocNo = $this->input->post('tDocNo');
        $nLangEdit = $this->session->userdata("tLangEdit");
        $nLangResort = $this->session->userdata("tLangID");
        $aLangHave = FCNaHGetAllLangByTable('TFNMRate_L');
        $tUsrLogin = $this->session->userdata('tSesUsername');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserSessionDate = $this->session->userdata("tSesSessionDate");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCode");

        $aAlwEvent = FCNaHCheckAlwFunc('TWXVD/0/0'); //Control Event
        // Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        // Get Option Scan SKU
        $nOptDocSave = FCNnHGetOptionDocSave();
        //Get Option Scan SKU
        $nOptScanSku = FCNnHGetOptionScanSku();

        // Lang ภาษา

        $nLangHave = count($aLangHave);
        if ($nLangHave > 1) {
            if ($nLangEdit != '') {
                $nLangEdit = $nLangEdit;
            } else {
                $nLangEdit = $nLangResort;
            }
        } else {
            if (@$aLangHave[0]->nLangList == '') {
                $nLangEdit = '1';
            } else {
                $nLangEdit = $aLangHave[0]->nLangList;
            }
        }

        // Get Data
        $aGetHDParams = array(
            'tDocNo' => $tDocNo,
            'nLngID' => $nLangEdit,
            'tDocKey' => 'TVDTPdtTwxHD',
        );
        $aResult = $this->Topupvending_model->FSaMGetHD($aGetHDParams); // Data TVDTPdtTwxHD

        $aGetHDRefParams = [
            'tDocNo' => $tDocNo
        ];
        $aDataHDRef = $this->Topupvending_model->FSaMGetHDRef($aGetHDRefParams); // Data TVDTPdtTwxHDRef

        $aGetWahInDTParams = [
            'tBchCode' => isset($aResult['raItems']['FTBchCode']) ? $aResult['raItems']['FTBchCode'] : '',
            'tDocNo' => $tDocNo
        ];
        $aWahInDT = $this->Topupvending_model->FSaMGetWahInDT($aGetWahInDTParams);

        $aDTToTempParams = [
            'tDocNo' => $tDocNo,
            'tDocKey' => 'TVDTPdtTwxHD',
            'tBchCode' => isset($aResult['raItems']['FTBchCode']) ? $aResult['raItems']['FTBchCode'] : '',
            'tUserSessionID' => $tUserSessionID,
            'tUserSessionDate' => $tUserSessionDate,
            'nLngID' => $nLangEdit
        ];
        $this->Topupvending_model->FSaMDTToTemp($aDTToTempParams);

        $aWahCodeInDT = [];
        $aWahNameInDT = [];

        foreach ($aWahInDT as $aValue) {
            $aWahCodeInDT[] = $aValue['FTWahCode'];
            $aWahNameInDT[] = $aValue['FTWahName'];
        }

        $aDataEdit = array(
            'nOptDecimalShow' => $nOptDecimalShow,
            'nOptDocSave' => $nOptDocSave,
            'nOptScanSku' => $nOptScanSku,
            'aResult' => $aResult,
            'aDataHDRef' => $aDataHDRef,
            'aAlwEvent' => $aAlwEvent,
            'tUserBchCode' => '', // $tBchCode,
            'tUserMchCode' => '', // $tMchCode,
            'tUserShpCode' => '', // $tShpCode,
            'tCompCode' => '', // $tCompCode,
            'tBchCompCode' => FCNtGetBchInComp(),
            'tBchCompName' => FCNtGetBchNameInComp(),
            'tWahCodeInDT' => FCNtArrayToString($aWahCodeInDT),
            'tWahNameInDT' => FCNtArrayToString($aWahNameInDT)
        );
        $this->load->view('document/topupVending/wTopupVendingPageadd', $aDataEdit);
    }

    /**
     * Functionality : Edit Event
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCTUVTopupVendingEditEvent()
    {
        try {
            $tUserSessionID = $this->session->userdata('tSesSessionID');
            $dXthDocDate = $this->input->post('oetTopUpVendingDocDate') . " " . $this->input->post('oetTopUpVendingDocTime');
            $aDataMaster = array(
                'tIsAutoGenCode'        => $this->input->post('ocbTopUpVendingAutoGenCode'),
                'FTBchCode'             => $this->input->post('oetTopUpVendingBCHCode'),
                'FTXthDocNo'            => $this->input->post('oetTopUpVendingDocNo'),
                'FDXthDocDate'          => $dXthDocDate,
                'FTXthVATInOrEx'        => '',
                'FTDptCode'             => $this->input->post('ohdTopUpVendingDptCode'),
                'FTXthMerCode'          => $this->input->post('oetTopUpVendingMchCode'),
                'FTXthShopFrm'          => $this->input->post('oetTopUpVendingShpCode'),
                'FTXthShopTo'           => $this->input->post('oetTopUpVendingShpCode'),
                'FTXthPosFrm'           => $this->input->post('oetTopUpVendingPosCode'),
                'FTXthPosTo'            => $this->input->post('oetTopUpVendingPosCode'),
                'FTUsrCode'             => $this->input->post('oetTopUpVendingUsrCode'),
                'FTSpnCode'             => '',
                'FTXthApvCode'           => '',  // สถานะ อนุมัติ เอกสาร ว่าง:ยังไม่ทำ, 1:อนุมัติแล้ว 
                'FTXthRefExt'           => $this->input->post('oetXthRefExt'),
                'FDXthRefExtDate'       => $this->input->post('oetXthRefExtDate') != '' ? $this->input->post('oetXthRefExtDate') : NULL,
                'FTXthRefInt'           => $this->input->post('oetXthRefInt'),
                'FDXthRefIntDate'       => $this->input->post('oetXthRefIntDate') != '' ? $this->input->post('oetXthRefIntDate') : NULL,
                'FNXthDocPrint'         => 0,
                'FCXthTotal'            => 0, // ยอดรวมก่อนลด
                'FCXthVat'              => '',
                'FCXthVatable'          => '',
                'FTXthRmk'              => $this->input->post('otaTopUpVendingRmk'),
                'FTXthStaDoc'           => 1,   // 1 after save
                'FTXthStaApv'           => '',
                'FTXthStaPrcStk'        => '',  // สถานะ ประมวลผลสต๊อก ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FTXthStaDelMQ'         => '',
                'FNXthStaDocAct'        => $this->input->post('ocbTopUpVendingXthStaDocAct'), // สถานะ ประมวลผลสต๊อก ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FNXthStaRef'           => $this->input->post('ostTopUpVendingXthStaRef'),   // Default 0
                'FTRsnCode'             => "",

                // 'FTXthWhFrm'            => $this->input->post('ohdWahCodeStart'),
                // 'FTXthWhTo'             => $this->input->post('ohdWahCodeEnd'),

                'FDLastUpdOn'           => date('Y-m-d'),
                'FDCreateOn'            => date('Y-m-d'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername')
            );

            $this->db->trans_begin();

            // ข้อมูลการขนส่ง
            $aAddUpdateHDRefParams = array(
                'FTBchCode' => $aDataMaster['FTBchCode'],
                'FTXthDocNo' => $aDataMaster['FTXthDocNo'],
                'FTXthCtrName' => $this->input->post('oetTopUpVendingXthCtrName'),
                'FDXthTnfDate' => $this->input->post('oetTopUpVendingXthTnfDate'),
                'FTXthRefTnfID' => $this->input->post('oetTopUpVendingXthRefTnfID'),
                'FTXthRefVehID' => $this->input->post('oetTopUpVendingXthRefVehID'),
                'FTXthQtyAndTypeUnit' => $this->input->post('oetTopUpVendingXthQtyAndTypeUnit'),
                'FNXthShipAdd' => $this->input->post('ohdTopUpVendingXthShipAdd'),
                'FTViaCode' => $this->input->post('oetTopUpVendingViaCode'),
            );

            $this->Topupvending_model->FSaMAddUpdateHD($aDataMaster);
            $this->Topupvending_model->FSaMAddUpdateHDRef($aAddUpdateHDRefParams);

            $aUpdateDocNoInTmpParams = [
                'FTXthDocNo' => $aDataMaster['FTXthDocNo'],
                'FTXthDocKey' => 'TVDTPdtTwxHD',
                'tUserSessionID' => $tUserSessionID
            ];
            $this->Topupvending_model->FSaMUpdateDocNoInTmp($aUpdateDocNoInTmpParams); // Update DocNo ในตาราง Doctemp

            $aTempToDTParams = [
                'tDocNo' => $aDataMaster['FTXthDocNo'],
                'tBchCode' => $aDataMaster['FTBchCode'],
                'tDocKey' => 'TVDTPdtTwxHD',
                'tUserSessionID' => $tUserSessionID
            ];
            $this->Topupvending_model->FSaMTempToDT($aTempToDTParams); // คัดลอกข้อมูลจาก Temp to DT

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack' => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn' => $aDataMaster['FTXthDocNo'],
                    'nStaEvent'    => '1',
                    'tStaMessg' => 'Success Edit'
                );
            }

            $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    /**
     * Functionality : Insert PDT Layout to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCTUVTopupVendingInsertPdtLayoutToTmp()
    {
        $tDocNo = $this->input->post('tDocNo');
        $tBchCode = $this->input->post('tBchCode');
        $tShpCode = $this->input->post('tShpCode');
        $tPosCode = $this->input->post('tPosCode');
        $tWahCodeInShop = $this->input->post('tWahCodeInShop');
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserSessionDate = $this->session->userdata("tSesSessionDate");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCode");

        $aPdtlayoutToTempParams = [
            'tDocNo' => $tDocNo,
            'tDocKey' => 'TVDTPdtTwxHD',
            'tBchCode' => $tBchCode,
            'tShpCode' => $tShpCode,
            'tPosCode' => $tPosCode,
            'tWahCodeInShop' => $tWahCodeInShop,
            'tBchCodeLogin' => $tBchCodeLogin,
            'tUserSessionID' => $tUserSessionID,
            'tUserSessionDate' => $tUserSessionDate,
            'tUserLoginCode' => $tUserLoginCode,
            'nLngID' => $nLangEdit
        ];
        $this->Topupvending_model->FSaMPdtlayoutToTemp($aPdtlayoutToTempParams);
    }

    /**
     * Functionality : Get PDT Layout in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSxCTUVTopupVendingGetPdtLayoutDataTableInTmp()
    {
        $tSearchAll = $this->input->post('tSearchAll');
        $nPage = $this->input->post('nPageCurrent');
        $aAlwEvent = FCNaHCheckAlwFunc('TWXVD/0/0');
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aGetPdtLayoutInTmpParams  = array(
            'FNLngID' => $nLangEdit,
            'nPage' => $nPage,
            'nRow' => 20,
            'tSearchAll' => $tSearchAll,
            'tUserSessionID' => $tUserSessionID
        );
        $aResList = $this->Topupvending_model->FSaMGetPdtLayoutInTmp($aGetPdtLayoutInTmpParams);

        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow
        );
        $this->load->view('document/topupVending/advance_table/wTopupVendingPdtDatatable', $aGenTable);
    }

    /**
     * Functionality : Check Doc No. Duplicate
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStCTopUpVendingUniqueValidate()
    {
        $aStatus = ['bStatus' => false];

        if ($this->input->is_ajax_request()) { // Request check
            $tTopUpVendingDocCode = $this->input->post('tTopUpVendingCode');
            $bIsDocNoDup = $this->Topupvending_model->FSbMCheckDuplicate($tTopUpVendingDocCode);

            if ($bIsDocNoDup) { // If have record
                $aStatus['bStatus'] = true;
            }
        } else {
            echo 'Method Not Allowed';
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aStatus));
    }

    /**
     * Functionality : Cancel Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStCTopUpVendingDocCancel()
    {

        $tDocNo = $this->input->post('tDocNo');

        $this->db->trans_begin();

        $aDocCancelParams = array(
            'tDocNo' => $tDocNo,
        );
        $aStaCancel = $this->Topupvending_model->FSaMDocCancel($aDocCancelParams);

        if ($aStaCancel['rtCode'] == 1) {
            $this->db->trans_commit();
            $aCancel = array(
                'nSta' => 1,
                'tMsg' => "Cancel Success",
            );
        } else {
            $this->db->trans_rollback();
            $aCancel = array(
                'nSta' => 2,
                'tMsg' => "Cancel Fail",
            );
        }
        echo json_encode($aCancel);
    }

    /**
     * Functionality : Approve Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStCTopUpVendingDocApprove()
    {

        $tDocNo  = $this->input->post('tDocNo');
        // $tStaApv = $this->input->post('tStaApv');
        $tDocType = $this->input->post('tDocType');
        $tUsrBchCode = FCNtGetBchInComp();

        $this->db->trans_begin();

        $aDocApproveParams = array(
            'tDocNo' => $tDocNo,
            'tApvCode' => $this->session->userdata('tSesUsername')
        );
        $this->Topupvending_model->FSaMDocApprove($aDocApproveParams);

        try {
            $aMQParams = [
                "queueName" => "TNFWAREHOSEVD",
                "params" => [
                    "ptBchCode" => $tUsrBchCode,
                    "ptDocNo" => $tDocNo,
                    "ptDocType" => $tDocType,
                    "ptUser" => $this->session->userdata('tSesUsername')
                ]
            ];
            FCNxCallRabbitMQ($aMQParams);

            $this->db->trans_commit();
        } catch (\ErrorException $err) {

            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => language('common/main/main', 'tApproveFail')
            );
            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aReturn));
        }
    }

    /**
     * Functionality : Delete Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStTopUpVendingDeleteDoc()
    {

        $tDocNo = $this->input->post('tDocNo');

        $this->db->trans_begin();

        $aDelMasterParams = [
            'tDocNo' => trim($tDocNo)
        ];
        $this->Topupvending_model->FSaMDelMaster($aDelMasterParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Cannot Delete Item.',
            );
        } else {
            $this->db->trans_commit();
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Delete Complete.',
            );
        }
        return json_encode($aStatus);
    }

    /**
     * Functionality : Delete Multiple Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStTopUpVendingDeleteMultiDoc()
    {
        $aDocNo = $this->input->post('aDocNo');

        $this->db->trans_begin();

        foreach ($aDocNo as $aItem) {
            $aDelMasterParams = [
                'tDocNo' => trim($aItem)
            ];
            $this->Topupvending_model->FSaMDelMaster($aDelMasterParams);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Cannot Delete Item.',
            );
        } else {
            $this->db->trans_commit();
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Delete Complete.',
            );
        }
        return json_encode($aStatus);
    }

    /**
     * Functionality : Update PDT Layout in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCTUVTopupVendingUpdatePdtLayoutInTmp()
    {
        $nQty = $this->input->post('nQty');
        $nSeqNo = $this->input->post('nSeqNo');
        $tPdtCode = $this->input->post('tPdtCode');
        $tPosCode = $this->input->post('tPosCode');
        $tBchCode = $this->input->post('tBchCode');
        $tWahCode = $this->input->post('tWahCode');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");

        $aGetWahByShopParams = [
            'tRefCode' => $tPosCode,
            'tBchCode' => $tBchCode
        ];
        $aWahByPos = $this->Topupvending_model->FSaMGetWahByRefCode($aGetWahByShopParams);

        $aGetPdtStkBalWithCheckInTmp = [
            'tBchCode' => $tBchCode,
            'tWahCode' => FCNtAddSingleQuote($tWahCode), // คลังสินค้าต้นทาง เพื่อใช้ในการเติมให้กับ คลังตู้สินค้า
            'tPdtCode' => $tPdtCode,
            'tUserSessionID' => $tUserSessionID,
            'nNotInSelfSeqNo' => $nSeqNo
        ];
        $nStkBal = $this->Topupvending_model->FSnGetPdtStkBalWithCheckInTmp($aGetPdtStkBalWithCheckInTmp);
        
        if ($nQty <= $nStkBal) {

            $aUpdateQtyInTmpBySeqParams = [
                'cQty' => $nQty,
                'tUserLoginCode' => $tUserLoginCode,
                'tUserSessionID' => $tUserSessionID,
                'nSeqNo' => $nSeqNo,
            ];
            $this->Topupvending_model->FSbUpdateQtyInTmpBySeq($aUpdateQtyInTmpBySeqParams);
        } else {
            $aUpdateQtyInTmpBySeqParams = [
                'cQty' => ($nStkBal<0)?0:$nStkBal,
                'tUserLoginCode' => $tUserLoginCode,
                'tUserSessionID' => $tUserSessionID,
                'nSeqNo' => $nSeqNo,
            ];
            $this->Topupvending_model->FSbUpdateQtyInTmpBySeq($aUpdateQtyInTmpBySeqParams);
        }
    }

    /**
     * Functionality : Delete PDT Layout in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCTUVTopupVendingDeletePdtLayoutInTmp()
    {
        $nSeqNo = $this->input->post('nSeqNo');
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $aDeleteInTmpBySeqParams = [
            'tUserSessionID' => $tUserSessionID,
            'nSeqNo' => $nSeqNo,
        ];
        $this->Topupvending_model->FSbDeleteInTmpBySeq($aDeleteInTmpBySeqParams);
    }

    /**
     * Functionality : Get Wah by Shp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Wah Data
     * Return Type : String
     */
    public function FStGetWahByShop()
    {
        $tShpCode = $this->input->post('tShpCode');
        $tBchCode = $this->input->post('tBchCode');

        $aGetWahByShopParams = [
            'tRefCode' => $tShpCode,
            'tBchCode' => $tBchCode
        ];
        $aWahByShp = $this->Topupvending_model->FSaMGetWahByRefCode($aGetWahByShopParams);
        
        // $aDataDT = $this->Topupvending_model->FSaMTFWGetDT($aDataWhere); // Data TVDTPdtTwxDT
        // $aStaIns = $this->Topupvending_model->FSaMTFWInsertDTToTemp($aDataDT,$aDataWhere); // Insert Data DocTemp

        $aWahCodeByShp = [];
        $aWahNameByShp = [];

        foreach ($aWahByShp as $aValue) {
            $aWahCodeByShp[] = $aValue['FTWahCode'];
            $aWahNameByShp[] = $aValue['FTWahName'];
        }

        $tWahCodeByShp = FCNtArrayToString($aWahCodeByShp);
        $tWahNameByShp = FCNtArrayToString($aWahNameByShp);

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode(['tWahCodeByShp' => $tWahCodeByShp, 'tWahNameByShp' => $tWahNameByShp]));
    }
}
