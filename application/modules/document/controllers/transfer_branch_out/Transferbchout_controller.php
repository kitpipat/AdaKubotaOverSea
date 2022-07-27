<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transferbchout_controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('company/company/Company_model');
        $this->load->model('document/transfer_branch_out/Transferbchout_model');
        $this->load->model('document/transfer_branch_out/Transferbchoutpdt_model');
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
        $aData['aAlwEvent'] = FCNaHCheckAlwFunc('docTransferBchOut/0/0');
        $aData['vBtnSave'] = FCNaHBtnSaveActiveHTML('docTransferBchOut/0/0');
        $aData['nOptDecimalShow'] = FCNxHGetOptionDecimalShow();
        $aData['nOptDecimalSave'] = FCNxHGetOptionDecimalSave();
        $this->load->view('document/transfer_branch_out/wTransferBchOut', $aData);
    }

    /**
     * Functionality : Main Page List
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : List Page
     * Return Type : View
     */
    public function FSxCTransferBchOutList()
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

        $this->load->view('document/transfer_branch_out/wTransferBchOutList', $aDataMaster);
    }

    /**
     * Functionality : Get HD Table List
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : HD Table List
     * Return Type : View
     */
    public function FSxCTransferBchOutDataTable()
    {
        $tAdvanceSearchData = $this->input->post('oAdvanceSearch');
        $nPage = $this->input->post('nPageCurrent');
        $aAlwEvent = FCNaHCheckAlwFunc('docTransferBchOut/0/0');
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

        $aResList = $this->Transferbchout_model->FSaMHDList($aData);
        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow
        );

        $this->load->view('document/transfer_branch_out/wTransferBchOutDatatable', $aGenTable);
    }

    /**
     * Functionality : Add Page
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Add Page
     * Return Type : View
     */
    public function FSxCTransferBchOutAddPage()
    {
        $tUserSessionID = $this->session->userdata('tSesSessionID');
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $nOptDocSave = FCNnHGetOptionDocSave();
        $nOptScanSku = FCNnHGetOptionScanSku();

        $aClearInTmpParams = [
            'tUserSessionID' => $tUserSessionID,
            'tDocKey' => 'TCNTPdtTboHD'
        ];
        $this->Transferbchout_model->FSxMClearInTmp($aClearInTmpParams);

        $aDataAdd = array(
            'aResult'           =>  array('rtCode' => '99'),
            'aResultOrdDT'      =>  array('rtCode' => '99'),
            'nOptDecimalShow'   =>  $nOptDecimalShow,
            'nOptScanSku'       =>  $nOptScanSku,
            'nOptDocSave'       =>  $nOptDocSave,
            'tBchCompCode'      =>  FCNtGetBchInComp(),
            'tBchCompName'      =>  FCNtGetBchNameInComp()
        );
        $this->load->view('document/transfer_branch_out/wTransferBchOutPageadd', $aDataAdd);
    }

    /**
     * Functionality : Add Event
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCTransferBchOutAddEvent()
    {
        try {
            $tUserSessionID = $this->session->userdata('tSesSessionID');
            $tUserLoginCode = $this->session->userdata('tSesUsername');
            $tDocDate = $this->input->post('oetTransferBchOutDocDate') . " " . $this->input->post('oetTransferBchOutDocTime');
            $tUserLevel = $this->session->userdata('tSesUsrLevel');
            $tBchCode = $this->input->post('oetTransferBchOutBchCode');

            $aEndOfBillParams = [
                'tSplVatType' => '2', // ภาษีรวมใน
                'tDocNo' => 'TBODOCTEMP',
                'tDocKey' => 'TCNTPdtTboHD',
                'nLngID' => FCNaHGetLangEdit(),
                'tSesSessionID' => $tUserSessionID,
                'tBchCode' => $tBchCode
            ];
            $aEndOfBillCal = FCNaDOCEndOfBillCal($aEndOfBillParams);

            $aDataMaster = array(
                'tIsAutoGenCode' => $this->input->post('ocbTransferBchOutAutoGenCode'),
                'FTBchCode' => $tBchCode, // สาขาสร้าง
                'FTXthDocNo' => $this->input->post('oetTransferBchOutDocNo'), // เลขที่เอกสาร  XXYYMM-1234567
                'FDXthDocDate' => $tDocDate, // วันที่/เวลา เอกสาร dd/mm/yyyy H:mm:ss
                'FTXthVATInOrEx' => $this->input->post(''), // ภาษีมูลค่าเพิ่ม 1:รวมใน, 2:แยกนอก
                'FTDptCode' => $this->input->post(''), // แผนก
                'FTXthBchFrm' => $this->input->post('oetTransferBchOutXthBchFrmCode'), // รหัสสาขาต้นทาง
                'FTXthBchTo' => $this->input->post('oetTransferBchOutXthBchToCode'), // รหัสสาขาปลายทาง
                'FTXthMerchantFrm' => $this->input->post('oetTransferBchOutXthMerchantFrmCode'), // รหัสตัวแทน/เจ้าของดำเนินการ(ต้นทาง)
                'FTXthMerchantTo' => $this->input->post(''), // รหัสตัวแทน/เจ้าของดำเนินการ(ปลายทาง)
                'FTXthShopFrm' => $this->input->post('oetTransferBchOutXthShopFrmCode'), // ร้านค้า(ต้นทาง)
                'FTXthShopTo' => $this->input->post(''), // ร้านค้า(ปลายทาง)
                'FTXthWhFrm' => $this->input->post('oetTransferBchOutXthWhFrmCode'), // รหัสคลัง(ต้นทาง)
                'FTXthWhTo' => $this->input->post('oetTransferBchOutXthWhToCode'), // รหัสคลัง(ปลายทาง)
                'FTUsrCode' => $tUserLoginCode, // พนักงาน Key
                'FTSpnCode' => '', // พนักงานขาย
                'FTXthApvCode' => '', // ผู้อนุมัติ
                'FTXthRefExt' => $this->input->post('oetTransferBchOutXthRefExt'), // อ้างอิง เลขที่เอกสาร ภายนอก
                'FDXthRefExtDate' => empty($this->input->post('oetTransferBchOutXthRefExtDate'))?NULL:$this->input->post('oetTransferBchOutXthRefExtDate'), // อ้างอิง วันที่เอกสาร ภายนอก
                'FTXthRefInt' => $this->input->post('oetTransferBchOutXthRefInt'), // อ้างอิง เลขที่เอกสาร ภายใน
                'FDXthRefIntDate' => empty($this->input->post('oetTransferBchOutXthRefIntDate'))?NULL:$this->input->post('oetTransferBchOutXthRefIntDate'), // อ้างอิง วันที่เอกสาร ภายใน
                'FNXthDocPrint' => 0, // จำนวนครั้งที่พิมพ์
                'FCXthTotal' => floatval(str_replace(',','',$aEndOfBillCal['cSumFCXtdNet'])), // ยอดรวมก่อนลด
                'FCXthVat' => floatval(str_replace(',','',$aEndOfBillCal['cSumFCXtdVat'])), // ยอดภาษี
                'FCXthVatable' => floatval(str_replace(',','',$aEndOfBillCal['cSumFCXtdNet'])), // ยอดแยกภาษี
                'FTXthRmk' => $this->input->post('otaTransferBchOutXthRmk'), // หมายเหตุ
                'FTXthStaDoc' => '1', // สถานะ เอกสาร  1:สมบูรณ์, 2:ไม่สมบูรณ์, 3:ยกเลิก
                'FTXthStaApv' => '', // สถานะ อนุมัติ เอกสาร ว่าง:ยังไม่ทำ, 1:อนุมัติแล้ว
                'FTXthStaPrcStk' => '', // สถานะ ประมวลผลสต๊อก ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FTXthStaDelMQ' => '', // สถานะลบ MQ ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FNXthStaDocAct' => ($this->input->post('ocbTransferBchOutXthStaDocAct') == "1")?1:0, // สถานะ เคลื่อนไหว 0:NonActive, 1:Active
                'FNXthStaRef' => intval($this->input->post('ostTransferBchOutXthStaRef')), // สถานะ อ้างอิง 0:ไม่เคยอ้างอิง, 1:อ้างอิงบางส่วน, 2:อ้างอิงหมดแล้ว
                'FTRsnCode' => $this->input->post('oetTransferBchOutRsnCode'), // รหัสเหตุผล

                // การขนส่ง(TCNTPdtTboHDRef)
                'FTXthCtrName' => $this->input->post('oetTransferBchOutXthCtrName'), // ชื่อผู้ตืดต่อ
                'FDXthTnfDate' => empty($this->input->post('oetTransferBchOutXthTnfDate'))?NULL:$this->input->post('oetTransferBchOutXthTnfDate'), // วันที่ส่งของ
                'FTXthRefTnfID' => $this->input->post('oetTransferBchOutXthRefTnfID'), // อ้างอิง เลขที่ ใบขนส่ง
                'FTXthRefVehID' => $this->input->post('oetTransferBchOutXthRefVehID'), // อ้างอิง เลขที่ ยานพาหนะ ขนส่ง
                'FTXthQtyAndTypeUnit' => $this->input->post('oetTransferBchOutXthQtyAndTypeUnit'), // จำนวนและลักษณะหีบห่อ
                'FNXthShipAdd' => 0, // อ้างอิง ที่อยู่ ส่งของ null หรือ 0 ไม่กำหนด
                'FTViaCode' => $this->input->post('oetTransferBchOutShipViaCode'), // รหัสการขนส่ง

                'FDLastUpdOn' => date('Y-m-d'), // วันที่ปรับปรุงรายการล่าสุด
                'FTLastUpdBy' => $tUserLoginCode, // ผู้ปรับปรุงรายการล่าสุด
                'FDCreateOn' => date('Y-m-d'), // วันที่สร้างรายการ
                'FTCreateBy' => $tUserLoginCode, // ผู้สร้างรายการ
            );

            $this->db->trans_begin();

            // Setup Doc No.
            if ($aDataMaster['tIsAutoGenCode'] == '1') { // Check Auto Gen Reason Code?
                // Call Auto Gencode Helper
                $aStoreParam = array(
                    "tTblName" => 'TCNTPdtTboHD',
                    "tDocType" => 6,
                    "tBchCode" => $aDataMaster["FTBchCode"],
                    "tShpCode" => "",
                    "tPosCode" => "",
                    "dDocDate" => date("Y-m-d")
                );
                $aAutogen = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTXthDocNo'] = $aAutogen[0]["FTXxhDocNo"];

                // Auto Gen Code
                /* $aGenCode = FCNaHGenCodeV5('TCNTPdtTboHD', '6');
                if ($aGenCode['rtCode'] == '1') {
                    $aDataMaster['FTXthDocNo'] = $aGenCode['rtXthDocNo'];
                } */
            }

            $this->Transferbchout_model->FSaMAddUpdateHD($aDataMaster);
            $this->Transferbchout_model->FSaMAddUpdateHDRef($aDataMaster);

            $aUpdateDocNoInTmpParams = [
                'tDocNo' => $aDataMaster['FTXthDocNo'],
                'tDocKey' => 'TCNTPdtTboHD',
                'tUserSessionID' => $tUserSessionID
            ];
            $this->Transferbchout_model->FSaMUpdateDocNoInTmp($aUpdateDocNoInTmpParams); // Update DocNo ในตาราง Doctemp

            $aTempToDTParams = [
                'tDocNo' => $aDataMaster['FTXthDocNo'],
                'tBchCode' => $aDataMaster['FTBchCode'],
                'tDocKey' => 'TCNTPdtTboHD',
                'tUserSessionID' => $tUserSessionID,
                'tUserLoginCode' => $tUserLoginCode
            ];
            $this->Transferbchout_model->FSaMTempToDT($aTempToDTParams); // คัดลอกข้อมูลจาก Temp to DT

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
    public function FSvCTransferBchOutEditPage()
    {
        $tDocNo = $this->input->post('tDocNo');
        $nLangEdit = $this->session->userdata("tLangEdit");
        $nLangResort = $this->session->userdata("tLangID");
        $aLangHave = FCNaHGetAllLangByTable('TFNMRate_L');
        // $tUsrLogin = $this->session->userdata('tSesUsername');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        // $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCode");

        $aAlwEvent = FCNaHCheckAlwFunc('docTransferBchOut/0/0'); // Access Control
        // Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        // Get Option Scan SKU
        $nOptDocSave = FCNnHGetOptionDocSave();
        //Get Option Scan SKU
        $nOptScanSku = FCNnHGetOptionScanSku();

        $aClearInTmpParams = [
            'tUserSessionID' => $tUserSessionID,
            'tDocKey' => 'TCNTPdtTboHD'
        ];
        $this->Transferbchout_model->FSxMClearInTmp($aClearInTmpParams);

        // Get Data
        $aGetHDParams = array(
            'tDocNo' => $tDocNo,
            'nLngID' => $nLangEdit,
            'tDocKey' => 'TCNTPdtTboHD',
        );
        $aResult = $this->Transferbchout_model->FSaMGetHD($aGetHDParams); // Data TCNTPdtTboHD

        $aDTToTempParams = [
            'tDocNo' => $tDocNo,
            'tDocKey' => 'TCNTPdtTboHD',
            'tBchCode' => isset($aResult['raItems']['FTBchCode']) ? $aResult['raItems']['FTBchCode'] : '',
            'tUserSessionID' => $tUserSessionID,
            'nLngID' => $nLangEdit
        ];
        $this->Transferbchout_model->FSaMDTToTemp($aDTToTempParams);

        $aDataEdit = array(
            'nOptDecimalShow' => $nOptDecimalShow,
            'nOptDocSave' => $nOptDocSave,
            'nOptScanSku' => $nOptScanSku,
            'aResult' => $aResult,
            'aAlwEvent' => $aAlwEvent,
            'tBchCompCode' => FCNtGetBchInComp(),
            'tBchCompName' => FCNtGetBchNameInComp()
        );
        $this->load->view('document/transfer_branch_out/wTransferBchOutPageadd', $aDataEdit);
    }

    /**
     * Functionality : Edit Event
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCTransferBchOutEditEvent()
    {
        try {
            $tUserSessionID = $this->session->userdata('tSesSessionID');
            $tUserLoginCode = $this->session->userdata('tSesUsername');
            $tDocDate = $this->input->post('oetTransferBchOutDocDate') . " " . $this->input->post('oetTransferBchOutDocTime');
            $tUserLevel = $this->session->userdata('tSesUsrLevel');
            $tBchCode = $this->input->post('oetTransferBchOutBchCode');

            $aEndOfBillParams = [
                'tSplVatType' => '2', // ภาษีรวมใน
                'tDocNo' => 'TBODOCTEMP',
                'tDocKey' => 'TCNTPdtTboHD',
                'nLngID' => FCNaHGetLangEdit(),
                'tSesSessionID' => $tUserSessionID,
                'tBchCode' => $tBchCode
            ];
            $aEndOfBillCal = FCNaDOCEndOfBillCal($aEndOfBillParams);
            
            $aDataMaster = array(
                'tIsAutoGenCode' => $this->input->post('ocbTransferBchOutAutoGenCode'),
                'FTBchCode' => $tBchCode, // สาขาสร้าง
                'FTXthDocNo' => $this->input->post('oetTransferBchOutDocNo'), // เลขที่เอกสาร  XXYYMM-1234567
                'FDXthDocDate' => $tDocDate, // วันที่/เวลา เอกสาร dd/mm/yyyy H:mm:ss
                'FTXthVATInOrEx' => $this->input->post(''), // ภาษีมูลค่าเพิ่ม 1:รวมใน, 2:แยกนอก
                'FTDptCode' => $this->input->post(''), // แผนก
                'FTXthBchFrm' => $this->input->post('oetTransferBchOutXthBchFrmCode'), // รหัสสาขาต้นทาง
                'FTXthBchTo' => $this->input->post('oetTransferBchOutXthBchToCode'), // รหัสสาขาปลายทาง
                'FTXthMerchantFrm' => $this->input->post('oetTransferBchOutXthMerchantFrmCode'), // รหัสตัวแทน/เจ้าของดำเนินการ(ต้นทาง)
                'FTXthMerchantTo' => $this->input->post(''), // รหัสตัวแทน/เจ้าของดำเนินการ(ปลายทาง)
                'FTXthShopFrm' => $this->input->post('oetTransferBchOutXthShopFrmCode'), // ร้านค้า(ต้นทาง)
                'FTXthShopTo' => $this->input->post(''), // ร้านค้า(ปลายทาง)
                'FTXthWhFrm' => $this->input->post('oetTransferBchOutXthWhFrmCode'), // รหัสคลัง(ต้นทาง)
                'FTXthWhTo' => $this->input->post('oetTransferBchOutXthWhToCode'), // รหัสคลัง(ปลายทาง)
                'FTUsrCode' => $tUserLoginCode, // พนักงาน Key
                'FTSpnCode' => '', // พนักงานขาย
                'FTXthApvCode' => '', // ผู้อนุมัติ
                'FTXthRefExt' => $this->input->post('oetTransferBchOutXthRefExt'), // อ้างอิง เลขที่เอกสาร ภายนอก
                'FDXthRefExtDate' => empty($this->input->post('oetTransferBchOutXthRefExtDate'))?NULL:$this->input->post('oetTransferBchOutXthRefExtDate'), // อ้างอิง วันที่เอกสาร ภายนอก
                'FTXthRefInt' => $this->input->post('oetTransferBchOutXthRefInt'), // อ้างอิง เลขที่เอกสาร ภายใน
                'FDXthRefIntDate' => empty($this->input->post('oetTransferBchOutXthRefIntDate'))?NULL:$this->input->post('oetTransferBchOutXthRefIntDate'), // อ้างอิง วันที่เอกสาร ภายใน
                'FNXthDocPrint' => 0, // จำนวนครั้งที่พิมพ์
                'FCXthTotal' => floatval(str_replace(',','',$aEndOfBillCal['cSumFCXtdNet'])), // ยอดรวมก่อนลด
                'FCXthVat' => floatval(str_replace(',','',$aEndOfBillCal['cSumFCXtdVat'])), // ยอดภาษี
                'FCXthVatable' => floatval(str_replace(',','',$aEndOfBillCal['cSumFCXtdNet'])), // ยอดแยกภาษี
                'FTXthRmk' => $this->input->post('otaTransferBchOutXthRmk'), // หมายเหตุ
                'FTXthStaDoc' => '1', // สถานะ เอกสาร  1:สมบูรณ์, 2:ไม่สมบูรณ์, 3:ยกเลิก
                'FTXthStaApv' => '', // สถานะ อนุมัติ เอกสาร ว่าง:ยังไม่ทำ, 1:อนุมัติแล้ว
                'FTXthStaPrcStk' => '', // สถานะ ประมวลผลสต๊อก ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FTXthStaDelMQ' => '', // สถานะลบ MQ ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FNXthStaDocAct' => ($this->input->post('ocbTransferBchOutXthStaDocAct') == "1")?1:0, // สถานะ เคลื่อนไหว 0:NonActive, 1:Active
                'FNXthStaRef' => intval($this->input->post('ostTransferBchOutXthStaRef')), // สถานะ อ้างอิง 0:ไม่เคยอ้างอิง, 1:อ้างอิงบางส่วน, 2:อ้างอิงหมดแล้ว
                'FTRsnCode' => $this->input->post('oetTransferBchOutRsnCode'), // รหัสเหตุผล

                // การขนส่ง(TCNTPdtTboHDRef)
                'FTXthCtrName' => $this->input->post('oetTransferBchOutXthCtrName'), // ชื่อผู้ตืดต่อ
                'FDXthTnfDate' => empty($this->input->post('oetTransferBchOutXthTnfDate'))?NULL:$this->input->post('oetTransferBchOutXthTnfDate'), // วันที่ส่งของ
                'FTXthRefTnfID' => $this->input->post('oetTransferBchOutXthRefTnfID'), // อ้างอิง เลขที่ ใบขนส่ง
                'FTXthRefVehID' => $this->input->post('oetTransferBchOutXthRefVehID'), // อ้างอิง เลขที่ ยานพาหนะ ขนส่ง
                'FTXthQtyAndTypeUnit' => $this->input->post('oetTransferBchOutXthQtyAndTypeUnit'), // จำนวนและลักษณะหีบห่อ
                'FNXthShipAdd' => 0, // อ้างอิง ที่อยู่ ส่งของ null หรือ 0 ไม่กำหนด
                'FTViaCode' => $this->input->post('oetTransferBchOutShipViaCode'), // รหัสการขนส่ง

                'FDLastUpdOn' => date('Y-m-d'), // วันที่ปรับปรุงรายการล่าสุด
                'FTLastUpdBy' => $tUserLoginCode, // ผู้ปรับปรุงรายการล่าสุด
                'FDCreateOn' => date('Y-m-d'), // วันที่สร้างรายการ
                'FTCreateBy' => $tUserLoginCode, // ผู้สร้างรายการ
            );

            $this->db->trans_begin();

            $this->Transferbchout_model->FSaMAddUpdateHD($aDataMaster);
            $this->Transferbchout_model->FSaMAddUpdateHDRef($aDataMaster);

            $aUpdateDocNoInTmpParams = [
                'tDocNo' => $aDataMaster['FTXthDocNo'],
                'tDocKey' => 'TCNTPdtTboHD',
                'tUserSessionID' => $tUserSessionID
            ];
            $this->Transferbchout_model->FSaMUpdateDocNoInTmp($aUpdateDocNoInTmpParams); // Update DocNo ในตาราง Doctemp

            $aTempToDTParams = [
                'tDocNo' => $aDataMaster['FTXthDocNo'],
                'tBchCode' => $aDataMaster['FTBchCode'],
                'tDocKey' => 'TCNTPdtTboHD',
                'tUserSessionID' => $tUserSessionID,
                'tUserLoginCode' => $tUserLoginCode
            ];
            $this->Transferbchout_model->FSaMTempToDT($aTempToDTParams); // คัดลอกข้อมูลจาก Temp to DT

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
     * Functionality : Check Doc No. Duplicate
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStCTransferBchOutUniqueValidate()
    {
        $aStatus = ['bStatus' => false];

        if ($this->input->is_ajax_request()) { // Request check
            $tTransferBchOutDocCode = $this->input->post('tTransferBchOutCode');
            $bIsDocNoDup = $this->Transferbchout_model->FSbMCheckDuplicate($tTransferBchOutDocCode);

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
    public function FStCTransferBchOutDocCancel()
    {

        $tDocNo = $this->input->post('tDocNo');

        $this->db->trans_begin();

        $aDocCancelParams = array(
            'tDocNo' => $tDocNo,
        );
        $aStaCancel = $this->Transferbchout_model->FSaMDocCancel($aDocCancelParams);

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
    public function FStCTransferBchOutDocApprove()
    {

        $tDocNo  = $this->input->post('tDocNo');
       
        $tDocType = $this->input->post('tDocType');
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCode = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCode");
        $tUserLoginCode = $this->session->userdata('tSesUsername');
        $tBchCode = $this->input->post('tBchCode');
        $this->db->trans_begin();

        $aDocApproveParams = array(
            'tDocNo' => $tDocNo,
            'tApvCode' => $tUserLoginCode
        );
        $this->Transferbchout_model->FSaMDocApprove($aDocApproveParams);

        try {
            $aMQParams = [
                "queueName" => "TNFBRANCHOUT",
                "params" => [
                    "ptBchCode" => $tBchCode,
                    "ptDocNo" => $tDocNo,
                    "ptDocType" => "6",
                    "ptUser" => $tUserLoginCode,
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
    public function FStTransferBchOutDeleteDoc()
    {

        $tDocNo = $this->input->post('tDocNo');

        $this->db->trans_begin();

        $aDelMasterParams = [
            'tDocNo' => trim($tDocNo)
        ];
        $this->Transferbchout_model->FSaMDelMaster($aDelMasterParams);

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
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aStatus));
    }

    /**
     * Functionality : Delete Multiple Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStTransferBchOutDeleteMultiDoc()
    {
        $aDocNo = $this->input->post('aDocNo');

        $this->db->trans_begin();

        foreach ($aDocNo as $aItem) {
            $aDelMasterParams = [
                'tDocNo' => trim($aItem)
            ];
            $this->Transferbchout_model->FSaMDelMaster($aDelMasterParams);
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
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aStatus));
    }
}
