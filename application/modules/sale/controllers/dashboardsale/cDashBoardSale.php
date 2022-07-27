<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cDashBoardSale extends MX_Controller
{

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

    public function __construct()
    {
        $this->FSxCInitParams();
        $this->load->model('sale/dashboardsale/mDashBoardSale');
        if (!is_dir('./application/modules/sale/assets/koolreport')) {
            mkdir('./application/modules/sale/assets/koolreport');
        }
        // เช็ค Folder Systemtemp
        if (!is_dir('./application/modules/sale/assets/sysdshtemp')) {
            mkdir('./application/modules/sale/assets/sysdshtemp');
        }
        parent::__construct();
    }

    // Functionality: เซทค่าพารามิเตอร์
    // Parameters: Ajax and Function Parameter
    // Creator: 14/01/2020 wasin(Yoshi)
    // Return: None
    // ReturnType: none
    private function FSxCInitParams()
    {
        // Text Lang
        $this->aTextLang    = [
            // Lang Title Panel
            'tDSHSALTitleMenu'              => language('sale/dashboardsale/dashboardsale', 'tDSHSALTitleMenu'),
            'tDSHSALDateDataFrom'           => language('sale/dashboardsale/dashboardsale', 'tDSHSALDateDataFrom'),
            'tDSHSALDateDataTo'             => language('sale/dashboardsale/dashboardsale', 'tDSHSALDateDataTo'),
            'tDSHSALBillQty'                => language('sale/dashboardsale/dashboardsale', 'tDSHSALBillQty'),
            'tDSHSALBillTotalAll'           => language('sale/dashboardsale/dashboardsale', 'tDSHSALBillTotalAll'),
            'tDSHSALTotalSaleByPayment'     => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalSaleByPayment'),
            'tDSHSALValueOfInventories'     => language('sale/dashboardsale/dashboardsale', 'tDSHSALValueOfInventories'),
            'tDSHSALNewProductTopTen'       => language('sale/dashboardsale/dashboardsale', 'tDSHSALNewProductTopTen'),
            'tDSHSALTotalSaleByPdtGrp'      => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalSaleByPdtGrp'),
            'tDSHSALTotalSaleByPdtType'     => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalSaleByPdtType'),
            'tDSHSALBestSaleProductTopTen'  => language('sale/dashboardsale/dashboardsale', 'tDSHSALBestSaleProductTopTen'),
            'tDSHSALTotalByBranch'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalByBranch'),
            'tDSHSALBestSaleProductTopTenByValue'  => language('sale/dashboardsale/dashboardsale', 'tDSHSALBestSaleProductTopTenByValue'),
            // Lang Data
            'tDSHSALSaleBill'               => language('sale/dashboardsale/dashboardsale', 'tDSHSALSaleBill'),
            'tDSHSALRefundBill'             => language('sale/dashboardsale/dashboardsale', 'tDSHSALRefundBill'),
            'tDSHSALTotalBill'              => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalBill'),
            'tDSHSALTotalSale'              => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalSale'),
            'tDSHSALTotalRefund'            => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalRefund'),
            'tDSHSALTotalGrand'             => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalGrand'),
            // Label Chart
            'tDSHSALXsdNet'                 => language('sale/dashboardsale/dashboardsale', 'tDSHSALXsdNet'),
            'tDSHSALStkQty'                 => language('sale/dashboardsale/dashboardsale', 'tDSHSALStkQty'),
            // Lang Not Found Data
            'tDSHSALNotFoundTopTenNewPdt'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALNotFoundTopTenNewPdt'),
            // Lang Modal Title
            'tDSHSALModalTitleFilter'       => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalTitleFilter'),
            'tDSHSALModalBtnCancel'         => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalBtnCancel'),
            'tDSHSALModalBtnSave'           => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalBtnSave'),
            // Form Input Filter
            'tDSHSALModalAppType'           => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalAppType'),
            'tDSHSALModalAppType1'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalAppType1'),
            'tDSHSALModalAppType2'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalAppType2'),
            'tDSHSALModalAppType3'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalAppType3'),
            'tDSHSALModalBranch'            => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalBranch'),
            'tDSHSALModalMerchant'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalMerchant'),
            'tDSHSALModalShop'              => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalShop'),
            'tDSHSALModalPos'               => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalPos'),
            'tDSHSALModalProduct'           => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalProduct'),
            'tDSHSALModalStatusCst'         => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusCst'),
            'tDSHSALModalStatusCst1'        => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusCst1'),
            'tDSHSALModalStatusCst2'        => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusCst2'),
            'tDSHSALModalStatusPayment'     => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusPayment'),
            'tDSHSALModalStatusPayment1'    => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusPayment1'),
            'tDSHSALModalStatusPayment2'    => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusPayment2'),
            'tDSHSALModalStatusAll'         => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusAll'),
            'tDSHSALModalRecive'            => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalRecive'),
            'tDSHSALModalPdtGrp'            => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalPdtGrp'),
            'tDSHSALModalPdtPty'            => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalPdtPty'),
            'tDSHSALModalWah'               => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalWah'),
            'tDSHSALModalTopLimit'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalTopLimit'),

            'tDSHSALDataDiff'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALDataDiff'),
            'tDSHSALOverLapZero'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALOverLapZero'),

        ];
        $this->aAlwEvent        = FCNaHCheckAlwFunc('dashboardsale/0/0');
        $this->nOptDecimalShow  = FCNxHGetOptionDecimalShow();
        $this->nOptDecimalSave  = FCNxHGetOptionDecimalSave();
        $this->nLangEdit        = $this->session->userdata("tLangEdit");
        $this->tSesUserCode     = $this->session->userdata('tSesUserCode');
        $this->tSesUserName     = $this->session->userdata('tSesUsername');
        $this->aDataWhere       = [
            'nLngID'            => $this->nLangEdit,
            'tDateDataForm'     => (!empty($this->input->post('ptDateDataForm'))) ? $this->input->post('ptDateDataForm') : '',
            'tDateDataTo'       => (!empty($this->input->post('ptDateDataTo'))) ? $this->input->post('ptDateDataTo')     : '',
            // Sale Type Key
            'tDSHSALTypeKey'    => (!empty($this->input->post('ohdDSHSALFilterKey'))) ? $this->input->post('ohdDSHSALFilterKey') : '',
            // Branch Filter
            'bFilterBchStaAll'  => (!empty($this->input->post('oetDSHSALFilterBchStaAll')) && ($this->input->post('oetDSHSALFilterBchStaAll') == 1)) ? true : false,
            'tFilterBchCode'    => (!empty($this->input->post('oetDSHSALFilterBchCode'))) ? $this->input->post('oetDSHSALFilterBchCode') : "",
            'tFilterBchName'    => (!empty($this->input->post('oetDSHSALFilterBchName'))) ? $this->input->post('oetDSHSALFilterBchName') : "",
            // Merchant Filter
            'bFilterMerStaAll'  => (!empty($this->input->post('oetDSHSALFilterMerStaAll')) && ($this->input->post('oetDSHSALFilterMerStaAll') == 1)) ? true : false,
            'tFilterMerCode'    => (!empty($this->input->post('oetDSHSALFilterMerCode'))) ? $this->input->post('oetDSHSALFilterMerCode') : "",
            'tFilterMerName'    => (!empty($this->input->post('oetDSHSALFilterMerName'))) ? $this->input->post('oetDSHSALFilterMerName') : "",
            // Shop Filter
            'bFilterShpStaAll'  => (!empty($this->input->post('oetDSHSALFilterShpStaAll')) && ($this->input->post('oetDSHSALFilterShpStaAll') == 1)) ? true : false,
            'tFilterShpCode'    => (!empty($this->input->post('oetDSHSALFilterShpCode'))) ? $this->input->post('oetDSHSALFilterShpCode') : "",
            'tFilterShpName'    => (!empty($this->input->post('oetDSHSALFilterShpName'))) ? $this->input->post('oetDSHSALFilterShpName') : "",
            // Pos Filter
            'bFilterPosStaAll'  => (!empty($this->input->post('oetDSHSALFilterPosStaAll')) && ($this->input->post('oetDSHSALFilterPosStaAll') == 1)) ? true : false,
            'tFilterPosCode'    => (!empty($this->input->post('oetDSHSALFilterPosCode'))) ? $this->input->post('oetDSHSALFilterPosCode') : "",
            'tFilterPosName'    => (!empty($this->input->post('oetDSHSALFilterPosName'))) ? $this->input->post('oetDSHSALFilterPosName') : "",
            // Warehouse Filter
            'bFilterWahStaAll'  => (!empty($this->input->post('oetDSHSALFilterWahStaAll')) && ($this->input->post('oetDSHSALFilterWahStaAll') == 1)) ? true : false,
            'tFilterWahCode'    => (!empty($this->input->post('oetDSHSALFilterWahCode'))) ? $this->input->post('oetDSHSALFilterWahCode') : "",
            'tFilterWahName'    => (!empty($this->input->post('oetDSHSALFilterWahName'))) ? $this->input->post('oetDSHSALFilterWahName') : "",
            // Product Filter
            'bFilterPdtStaAll'  => (!empty($this->input->post('oetDSHSALFilterPdtStaAll')) && ($this->input->post('oetDSHSALFilterPdtStaAll') == 1)) ? true : false,
            'tFilterPdtCode'    => (!empty($this->input->post('oetDSHSALFilterPdtCode'))) ? $this->input->post('oetDSHSALFilterPdtCode') : "",
            'tFilterPdtName'    => (!empty($this->input->post('oetDSHSALFilterPdtName'))) ? $this->input->post('oetDSHSALFilterPdtName') : "",
            // Recive Filter
            'bFilterRcvStaAll'  => (!empty($this->input->post('oetDSHSALFilterRcvStaAll')) && ($this->input->post('oetDSHSALFilterRcvStaAll') == 1)) ? true : false,
            'tFilterRcvCode'    => (!empty($this->input->post('oetDSHSALFilterRcvCode'))) ? $this->input->post('oetDSHSALFilterRcvCode') : "",
            'tFilterRcvName'    => (!empty($this->input->post('oetDSHSALFilterRcvName'))) ? $this->input->post('oetDSHSALFilterRcvName') : "",
            // Product Group Filter
            'bFilterPgpStaAll'  => (!empty($this->input->post('oetDSHSALFilterPgpStaAll')) && ($this->input->post('oetDSHSALFilterPgpStaAll') == 1)) ? true : false,
            'tFilterPgpCode'    => (!empty($this->input->post('oetDSHSALFilterPgpCode'))) ? $this->input->post('oetDSHSALFilterPgpCode') : "",
            'tFilterPgpName'    => (!empty($this->input->post('oetDSHSALFilterPgpName'))) ? $this->input->post('oetDSHSALFilterPgpName') : "",
            // Product Type Filter
            'bFilterPtyStaAll'  => (!empty($this->input->post('oetDSHSALFilterPtyStaAll')) && ($this->input->post('oetDSHSALFilterPtyStaAll') == 1)) ? true : false,
            'tFilterPtyCode'    => (!empty($this->input->post('oetDSHSALFilterPtyCode'))) ? $this->input->post('oetDSHSALFilterPtyCode') : "",
            'tFilterPtyName'    => (!empty($this->input->post('oetDSHSALFilterPtyName'))) ? $this->input->post('oetDSHSALFilterPtyName') : "",
            // Top Limit Select
            'tFilterTopLimit'   => (!empty($this->input->post('ocmDSHSALFilterTopLimit'))) ? $this->input->post('ocmDSHSALFilterTopLimit')   : 5,
            // Status Customer
            'tFilterStaCst'     => (!empty($this->input->post('orbDSHSALStaCst'))) ? $this->input->post('orbDSHSALStaCst')   : '',
            // Status Payment
            'tFilterStaPayment' => (!empty($this->input->post('orbDSHSALStaPayment'))) ? $this->input->post('orbDSHSALStaPayment')   : '',
            // App Type
            'aStaAppType'       => (!empty($this->input->post('ocbDSHSALAppType'))) ? $this->input->post('ocbDSHSALAppType') : explode(",", '1,2,3')
        ];
    }

    // Functionality: Index DashBoard
    // Parameters: Ajax and Function Parameter
    // Creator: 14/01/2020 wasin(Yoshi)
    // Return: None
    // ReturnType: none
    public function index($nDSHSALBrowseType, $tDSHSALBrowseOption)
    {
        $aDataConfigView    = [
            'nDSHSALBrowseType'     => $nDSHSALBrowseType,
            'tDSHSALBrowseOption'   => $tDSHSALBrowseOption,
            'aAlwEvent'             => $this->aAlwEvent,
            'aTextLang'             => $this->aTextLang
        ];


        //Set Cookie กำหนดสิทธิ์ใช้มองเห็นหน้า DashboardSale
        $aSetCookieRole = [];
        $tValueCookie = $this->input->cookie("Cookie_SKC" . $this->session->userdata("tSesUserCode"), true);
        $aValCheck = json_decode($tValueCookie);

        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB01", "tGhdApp" => "SB"];
        $bChkRolePanelLeft1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);


        if ($bChkRolePanelLeft1 != 1) {
            $aSetCookieRole[0] = 0;
        } else {
            if (isset($aValCheck[0]) ? $aValCheck[0] != 0 : 1) {
                $aSetCookieRole[0] = 1;
            } else {
                $aSetCookieRole[0] = 0;
            }
        }

        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB02", "tGhdApp" => "SB"];
        $bChkRolePanelLeft1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
        if ($bChkRolePanelLeft1 != 1) {
            $aSetCookieRole[1] = 0;
        } else {
            if (isset($aValCheck[1]) ? $aValCheck[1] != 0 : 1) {
                $aSetCookieRole[1] = 1;
            } else {
                $aSetCookieRole[1] = 0;
            }
        }
        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB03", "tGhdApp" => "SB"];
        $bChkRolePanelLeft1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
        if ($bChkRolePanelLeft1 != 1) {
            $aSetCookieRole[2] = 0;
        } else {
            if (isset($aValCheck[2]) ? $aValCheck[2] != 0 : 1) {
                $aSetCookieRole[2] = 1;
            } else {
                $aSetCookieRole[2] = 0;
            }
        }

        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB04", "tGhdApp" => "SB"];
        $bChkRolePanelLeft1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
        if ($bChkRolePanelLeft1 != 1) {
            $aSetCookieRole[3] = 0;
        } else {
            if (isset($aValCheck[3]) ? $aValCheck[3] != 0 : 1) {
                $aSetCookieRole[3] = 1;
            } else {
                $aSetCookieRole[3] = 0;
            }
        }

        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB05", "tGhdApp" => "SB"];
        $bChkRolePanelLeft1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
        if ($bChkRolePanelLeft1 != 1) {
            $aSetCookieRole[4] = 0;
        } else {
            if (isset($aValCheck[4]) ? $aValCheck[4] != 0 : 1) {
                $aSetCookieRole[4] = 1;
            } else {
                $aSetCookieRole[4] = 0;
            }
        }
        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB06", "tGhdApp" => "SB"];
        $bChkRolePanelLeft1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
        if ($bChkRolePanelLeft1 != 1) {
            $aSetCookieRole[5] = 0;
        } else {
            if (isset($aValCheck[5]) ? $aValCheck[5] != 0 : 1) {
                $aSetCookieRole[5] = 1;
            } else {
                $aSetCookieRole[5] = 0;
            }
        }

        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB07", "tGhdApp" => "SB"];
        $bChkRolePanelLeft1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
        if ($bChkRolePanelLeft1 != 1) {
            $aSetCookieRole[6] = 0;
        } else {
            if (isset($aValCheck[6]) ? $aValCheck[6] != 0 : 1) {
                $aSetCookieRole[6] = 1;
            } else {
                $aSetCookieRole[6] = 0;
            }
        }

        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB08", "tGhdApp" => "SB"];
        $bChkRolePanelLeft1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
        if ($bChkRolePanelLeft1 != 1) {
            $aSetCookieRole[7] = 0;
        } else {
            if (isset($aValCheck[7]) ? $aValCheck[7] != 0 : 1) {
                $aSetCookieRole[7] = 1;
            } else {
                $aSetCookieRole[7] = 0;
            }
        }

        $aCookie = array(
            'name'   => "Cookie_SKC" . $this->session->userdata("tSesUserCode"),
            'value'  => json_encode($aSetCookieRole),
            'expire' =>  31556926,
        );

        $this->input->set_cookie($aCookie);




        $this->load->view('sale/dashboardsale/wDashBoardSale', $aDataConfigView);
    }

    // Functionality : ฟังก์ชั่น ดึงข้อมูลจากฐานข้อมูล เมื่อแรกเข้าสู่หน้า
    // Parameters : Ajax and Function Parameter
    // Creator : 14/01/2019 wasin
    // Return : String View
    // Return Type : View
    public function FSvCDSHSALMainPage()
    {
        // เช็ค Folder Systemtemp User Code
        if (!is_dir('./application/modules/sale/assets/sysdshtemp/' . $this->tSesUserCode)) {
            mkdir('./application/modules/sale/assets/sysdshtemp/' . $this->tSesUserCode);
        }

        // จำนวนบิลขาย
        $tFilesCountBillAll = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_countbillall_tmp.txt";
        $aDataCountBillAll  = $this->mDashBoardSale->FSaNDSHSALCountBillAll($this->aDataWhere);
        $oFileCountBillAll  = fopen($tFilesCountBillAll, 'w');
        rewind($oFileCountBillAll);
        fwrite($oFileCountBillAll, json_encode($aDataCountBillAll));
        fclose($oFileCountBillAll);

        // ยอดขายรวม
        $tFileTotalSaleAll  = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_totalsaleall_tmp.txt";
        $aDataTotalSaleAll  = $this->mDashBoardSale->FSaNDSHSALCountTotalSaleAll($this->aDataWhere);
        $oFileTotalSaleAll  = fopen($tFileTotalSaleAll, 'w');
        rewind($oFileTotalSaleAll);
        fwrite($oFileTotalSaleAll, json_encode($aDataTotalSaleAll));
        fclose($oFileTotalSaleAll);

        // ยอดขายตามการชำะเงิน
        $tFileTotalSaleByRcv    = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_totalsalebyrcv_tmp.txt";
        $aDataTotalSaleByRcv    = $this->mDashBoardSale->FSaMDSHSALTotalSaleByRcv($this->aDataWhere);
        $oFileTotalSaleByRcv    = fopen($tFileTotalSaleByRcv, 'w');
        rewind($oFileTotalSaleByRcv);
        fwrite($oFileTotalSaleByRcv, json_encode($aDataTotalSaleByRcv));
        fclose($oFileTotalSaleByRcv);

        // มูลค่าสินค้าคงเหลือ
        $tFilePdtStkBal = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_pdtstkbal_tmp.txt";
        $aDataPdtStkBal = $this->mDashBoardSale->FSaMDSHSALPdtStkBal($this->aDataWhere);
        $oFilePdtStkBal = fopen($tFilePdtStkBal, 'w');
        rewind($oFilePdtStkBal);
        fwrite($oFilePdtStkBal, json_encode($aDataPdtStkBal));
        fclose($oFilePdtStkBal);

        // ยอดขายตามกลุ่มสินค้า
        $tFileTotalSaleByPdtGrp = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_totalsalebypdtgrp_tmp.txt";
        $aDataTotalSaleByPdtGrp = $this->mDashBoardSale->FSaMDSHSALTotalSaleByPdtGrp($this->aDataWhere);
        $oFileTotalSaleByPdtGrp = fopen($tFileTotalSaleByPdtGrp, 'w');
        rewind($oFileTotalSaleByPdtGrp);
        fwrite($oFileTotalSaleByPdtGrp, json_encode($aDataTotalSaleByPdtGrp));
        fclose($oFileTotalSaleByPdtGrp);

        // ยอดขายตามประเภทสินค้า
        $tFileTotalSaleByPdtPty = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_totalsalebypdtpty_tmp.txt";
        $aDataTotalSaleByPdtPty = $this->mDashBoardSale->FSaMDSHSALTotalSaleByPdtPty($this->aDataWhere);
        $oFileTotalSaelByPdtPty = fopen($tFileTotalSaleByPdtPty, 'w');
        rewind($oFileTotalSaelByPdtPty);
        fwrite($oFileTotalSaelByPdtPty, json_encode($aDataTotalSaleByPdtPty));
        fclose($oFileTotalSaelByPdtPty);

        // 10 รายการสินค้าใหม่
        $tFileTopTenNewPdt  = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_toptennewpdt_tmp.txt";
        $aDataTopTenNewPdt  = $this->mDashBoardSale->FSaMDSHSALTopTenNewProduct($this->aDataWhere);
        $oFileTopTenNewPdt  = fopen($tFileTopTenNewPdt, 'w');
        rewind($oFileTopTenNewPdt);
        fwrite($oFileTopTenNewPdt, json_encode($aDataTopTenNewPdt));
        fclose($oFileTopTenNewPdt);

        // 10 อันดับสินค้าขายดีตามจำนวน
        $tFileTopTenBestSeller  = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_toptenbestseller_tmp.txt";
        $aDataTopTenBestSeller  = $this->mDashBoardSale->FSaMDSHSALTopTenBestSeller($this->aDataWhere);
        $oFileTopTenBestSeller  = fopen($tFileTopTenBestSeller, 'w');
        rewind($oFileTopTenBestSeller);
        fwrite($oFileTopTenBestSeller, json_encode($aDataTopTenBestSeller));
        fclose($oFileTopTenBestSeller);


        // 10 อันดับสินค้าขายดีตามมูลค่า
        $tFileTopTenBestSellerByValue  = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_toptenbestsellerbyvalue_tmp.txt";
        $aDataTopTenBestSellerByValue  = $this->mDashBoardSale->FSaMDSHSALTopTenBestSellerByValue($this->aDataWhere);
        $oFileTopTenBestSellerByValue  = fopen($tFileTopTenBestSellerByValue, 'w');
        rewind($oFileTopTenBestSellerByValue);
        fwrite($oFileTopTenBestSellerByValue, json_encode($aDataTopTenBestSellerByValue));
        fclose($oFileTopTenBestSellerByValue);

        $aDataConfigView    =  [
            'nOptDecimalShow'   => $this->nOptDecimalShow,
            'nOptDecimalSave'   => $this->nOptDecimalSave,
            'aAlwEvent'         => $this->aAlwEvent,
            'aTextLang'         => $this->aTextLang,
        ];

        // ลบตัวแปรที่ใช้งานแล้ว
        unset($tFilesCountBillAll);
        unset($aDataCountBillAll);
        unset($oFileCountBillAll);

        unset($tFileTotalSaleAll);
        unset($aDataTotalSaleAll);
        unset($oFileTotalSaleAll);

        unset($tFileTotalSaleByRcv);
        unset($aDataTotalSaleByRcv);
        unset($oFileTotalSaleByRcv);

        unset($tFileTotalSaleByPdtGrp);
        unset($aDataTotalSaleByPdtGrp);
        unset($oFileTotalSaleByPdtGrp);

        unset($tFileTotalSaleByPdtPty);
        unset($aDataTotalSaleByPdtPty);
        unset($oFileTotalSaelByPdtPty);

        unset($tFileTopTenNewPdt);
        unset($aDataTopTenNewPdt);
        unset($oFileTopTenNewPdt);

        unset($tFileTopTenBestSeller);
        unset($aDataTopTenBestSeller);
        unset($oFileTopTenBestSeller);

        $this->load->view('sale/dashboardsale/wDashBoardSaleMain', $aDataConfigView);
    }

    // Functionality : ฟังก์ชั่น Call View Modal Filter
    // Parameters : Ajax and Function Parameter
    // Creator : 14/01/2019 wasin
    // Return : String View
    // Return Type : View
    public function FSvCDSHSALCallModalFilter()
    {
        $aDataConfigView    = [
            'tFilterDataKey'    => $this->input->post('ptFilterDataKey'),
            'aFilterDataGrp'    => explode(",", $this->input->post('ptFilterDataGrp')),
            'aTextLang'         => $this->aTextLang
        ];
        $this->load->view('sale/dashboardsale/viewmodal/wDashBoardModalFilter', $aDataConfigView);
    }

    // Functionality : ฟังก์ชั่น Call View Modal Filter
    // Parameters : Ajax and Function Parameter
    // Creator : 14/01/2019 wasin
    // Return : String View
    // Return Type : View
    public function FSvCDSHSALConfirmFilter()
    {
        // Switch Case ประเภท Dash Board
        $tDSHSALTypeKey = $this->aDataWhere['tDSHSALTypeKey'];
        switch ($tDSHSALTypeKey) {
            case 'FBA': {
                    // DashBoard Filter จำนวนบิลขาย
                    $tFilesCountBillAll = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_countbillall_tmp.txt";
                    $aDataCountBillAll  = $this->mDashBoardSale->FSaNDSHSALCountBillAll($this->aDataWhere);
                    $oFileCountBillAll  = fopen($tFilesCountBillAll, 'w');
                    rewind($oFileCountBillAll);
                    fwrite($oFileCountBillAll, json_encode($aDataCountBillAll));
                    fclose($oFileCountBillAll);
                    break;
                }
            case 'FTS': {
                    // DashBoard Filter ยอดขายรวม
                    $tFileTotalSaleAll  = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_totalsaleall_tmp.txt";
                    $aDataTotalSaleAll  = $this->mDashBoardSale->FSaNDSHSALCountTotalSaleAll($this->aDataWhere);
                    $oFileTotalSaleAll  = fopen($tFileTotalSaleAll, 'w');
                    rewind($oFileTotalSaleAll);
                    fwrite($oFileTotalSaleAll, json_encode($aDataTotalSaleAll));
                    fclose($oFileTotalSaleAll);
                    break;
                }
            case 'FSR': {
                    // DashBoard Filter ยอดขายตามการชำระเงิน
                    $tFileTotalSaleByRcv    = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_totalsalebyrcv_tmp.txt";
                    $aDataTotalSaleByRcv    = $this->mDashBoardSale->FSaMDSHSALTotalSaleByRcv($this->aDataWhere);
                    $oFileTotalSaleByRcv    = fopen($tFileTotalSaleByRcv, 'w');
                    rewind($oFileTotalSaleByRcv);
                    fwrite($oFileTotalSaleByRcv, json_encode($aDataTotalSaleByRcv));
                    fclose($oFileTotalSaleByRcv);
                    break;
                }
            case 'FSB': {
                    // DashBoard Filter มูลค่าสินค้าคงเหลือ
                    $tFilePdtStkBal = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_pdtstkbal_tmp.txt";
                    $aDataPdtStkBal = $this->mDashBoardSale->FSaMDSHSALPdtStkBal($this->aDataWhere);
                    $oFilePdtStkBal = fopen($tFilePdtStkBal, 'w');
                    rewind($oFilePdtStkBal);
                    fwrite($oFilePdtStkBal, json_encode($aDataPdtStkBal));
                    fclose($oFilePdtStkBal);
                    break;
                }
            case 'FNP': {
                    // DashBoard Filter 10 รายการสินค้าใหม่
                    $tFileTopTenNewPdt  = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_toptennewpdt_tmp.txt";
                    $aDataTopTenNewPdt  = $this->mDashBoardSale->FSaMDSHSALTopTenNewProduct($this->aDataWhere);
                    $oFileTopTenNewPdt  = fopen($tFileTopTenNewPdt, 'w');
                    rewind($oFileTopTenNewPdt);
                    fwrite($oFileTopTenNewPdt, json_encode($aDataTopTenNewPdt));
                    fclose($oFileTopTenNewPdt);
                    break;
                }
            case 'FPG': {
                    // DashBoard Filter ยอดขายตามกลุ่มสินค้า
                    $tFileTotalSaleByPdtGrp = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_totalsalebypdtgrp_tmp.txt";
                    $aDataTotalSaleByPdtGrp = $this->mDashBoardSale->FSaMDSHSALTotalSaleByPdtGrp($this->aDataWhere);
                    $oFileTotalSaleByPdtGrp = fopen($tFileTotalSaleByPdtGrp, 'w');
                    rewind($oFileTotalSaleByPdtGrp);
                    fwrite($oFileTotalSaleByPdtGrp, json_encode($aDataTotalSaleByPdtGrp));
                    fclose($oFileTotalSaleByPdtGrp);
                    break;
                }
            case 'FPT': {
                    // DashBoard Filter ยอดขายตามประเภทสินค้า
                    $tFileTotalSaleByPdtPty = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_totalsalebypdtpty_tmp.txt";
                    $aDataTotalSaleByPdtPty = $this->mDashBoardSale->FSaMDSHSALTotalSaleByPdtPty($this->aDataWhere);
                    $oFileTotalSaelByPdtPty = fopen($tFileTotalSaleByPdtPty, 'w');
                    rewind($oFileTotalSaelByPdtPty);
                    fwrite($oFileTotalSaelByPdtPty, json_encode($aDataTotalSaleByPdtPty));
                    fclose($oFileTotalSaelByPdtPty);
                    break;
                }
            case 'FTB': {
                    // DashBoard Filter 10 อันดับสินค้าขายดีตามจำนวน
                    $tFileTopTenBestSeller  = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_toptenbestseller_tmp.txt";
                    $aDataTopTenBestSeller  = $this->mDashBoardSale->FSaMDSHSALTopTenBestSeller($this->aDataWhere);
                    $oFileTopTenBestSeller  = fopen($tFileTopTenBestSeller, 'w');
                    rewind($oFileTopTenBestSeller);
                    fwrite($oFileTopTenBestSeller, json_encode($aDataTopTenBestSeller));
                    fclose($oFileTopTenBestSeller);
                    break;
                }
            case 'FTV': {
                    // DashBoard Filter 10 อันดับสินค้าขายดีตามมูลค่า
                    $tFileTopTenBestSellerByValue  = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_toptenbestsellerbyvalue_tmp.txt";
                    $aDataTopTenBestSellerByValue  = $this->mDashBoardSale->FSaMDSHSALTopTenBestSellerByValue($this->aDataWhere);
                    $oFileTopTenBestSellerByValue  = fopen($tFileTopTenBestSellerByValue, 'w');
                    rewind($oFileTopTenBestSellerByValue);
                    fwrite($oFileTopTenBestSellerByValue, json_encode($aDataTopTenBestSellerByValue));
                    fclose($oFileTopTenBestSellerByValue);
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

    // ============================================================= Call View Chart Data DashBoard Sale =============================================================

    // Functionality : ฟังก์ชั่น  Call View Data จำนวนบิลขาย,ยอดขายรวม
    // Parameters : Function Parameter
    // Creator : 23/01/2019 wasin
    // Return : None
    // Return Type : None
    public function FSoCDSHSALViewBillAllAndTotalSale()
    {
        // Open Files Bill All
        $tFileOpenPathBillAll   = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_countbillall_tmp.txt";
        $oFilesOpenBillAll      = fopen($tFileOpenPathBillAll, 'r');
        $aDataFilesBillAll      = json_decode(fread($oFilesOpenBillAll, filesize($tFileOpenPathBillAll)), true);
        fclose($oFilesOpenBillAll);
        // Open File Total Sale
        $tFileOpenPathTotalSale = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_totalsaleall_tmp.txt";
        $oFilesOpenTotalSale    = fopen($tFileOpenPathTotalSale, 'r');
        $aDataFilesTotalSale    = json_decode(fread($oFilesOpenTotalSale, filesize($tFileOpenPathTotalSale)), true);
        fclose($oFilesOpenTotalSale);
        $aDataReturn    = [
            'nOptDecimalShow'       => $this->nOptDecimalShow,
            'aDataFilesBillAll'     => $aDataFilesBillAll,
            'aDataFilesTotalSale'   => $aDataFilesTotalSale,
        ];
        unset($tFileOpenPathBillAll);
        unset($oFilesOpenBillAll);
        unset($aDataFilesBillAll);
        unset($tFileOpenPathTotalSale);
        unset($oFilesOpenTotalSale);
        unset($aDataFilesTotalSale);
        echo json_encode($aDataReturn);
        unset($aDataReturn);
    }

    // Functionality : ฟังก์ชั่น  Call View Data Total Sale By Payment
    // Parameters : Function Parameter
    // Creator : 23/01/2019 wasin
    // Return : None
    // Return Type : None
    public function FSvCDSHSALViewTotalSaleByRecive()
    {
        $tFilesOpenPath = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_totalsalebyrcv_tmp.txt";
        $oFilesOpen     = fopen($tFilesOpenPath, 'r');
        $aDataFiles     = json_decode(fread($oFilesOpen, filesize($tFilesOpenPath)), true);
        fclose($oFilesOpen);
        // Check ข้อมูลใน Array ว่าค่าหรือไม่
        if (count($aDataFiles) == 0) {
            $aInfoDataReder = array(array("FTRcvName" => "N/A", "FCXsdNet" => "0.01"));
        } else {
            $aInfoDataReder = $aDataFiles;
        }
        require_once APPPATH . 'modules\sale\datasources\charttotalsalebyrecive\rChartTotalSaleByRecive.php';
        $oChartTotalSaleByRecive    = new rChartTotalSaleByRecive(array(
            'aDataReturn'   => $aInfoDataReder,
            'aTextLang'     => $this->aTextLang
        ));
        $oChartTotalSaleByRecive->run();
        $tHtmlViewChart     = $oChartTotalSaleByRecive->render('wChartTotalSaleByRecive', true);
        $aDataConfigView    = [
            'tHtmlViewChart'    => $tHtmlViewChart
        ];
        $this->load->view('sale/dashboardsale/wDashBoardChartCenter', $aDataConfigView);
    }

    // Functionality : ฟังก์ชั่น  Call View Data Total Sale By Payment
    // Parameters : Function Parameter
    // Creator : 04/02/2019 wasin
    // Return : None
    // Return Type : None
    public function FSvCDSHSALViewPdtStockBarlance()
    {
        $tFilesOpenPath = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_pdtstkbal_tmp.txt";
        $oFilesOpen     = fopen($tFilesOpenPath, 'r');
        $aDataFiles     = json_decode(fread($oFilesOpen, filesize($tFilesOpenPath)), true);
        fclose($oFilesOpen);
        // Check ข้อมูลใน Array ว่าค่าหรือไม่
        if (count($aDataFiles) == 0) {
            $aInfoDataReder = array(array("FTPdtCode" => "", "FTPdtName" => "", "FCStkQty" => "0"));
        } else {
            $aInfoDataReder = $aDataFiles;
        }
        require_once APPPATH . 'modules\sale\datasources\chartpdtstockbarlance\rChartPdtStockBarlance.php';
        $oChartPdtStockBarlance = new rChartPdtStockBarlance(array(
            'aDataReturn'   => $aInfoDataReder,
            'aTextLang'     => $this->aTextLang
        ));
        $oChartPdtStockBarlance->run();
        $tHtmlViewChart     = $oChartPdtStockBarlance->render('wChartPdtStockBarlance', true);
        $aDataConfigView    = [
            'tHtmlViewChart'    => $tHtmlViewChart
        ];
        $this->load->view('sale/dashboardsale/wDashBoardChartCenter', $aDataConfigView);
    }


    // Functionality : ฟังก์ชั่น  Call View Data Top 10 New Product
    // Parameters : Function Parameter
    // Creator : 23/01/2019 wasin
    // Return : None
    // Return Type : None
    public function FSvCDSHSALViewTopTenNewPdt()
    {
        $tFilesOpenPath = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_toptennewpdt_tmp.txt";
        $oFilesOpen     = fopen($tFilesOpenPath, 'r');
        $aDataFiles     = json_decode(fread($oFilesOpen, filesize($tFilesOpenPath)), true);
        fclose($oFilesOpen);
        $aDataConfigView    =  [
            'nOptDecimalShow'   => $this->nOptDecimalShow,
            'nOptDecimalSave'   => $this->nOptDecimalSave,
            'aAlwEvent'         => $this->aAlwEvent,
            'aTextLang'         => $this->aTextLang,
            'aDataFiles'        => $aDataFiles
        ];
        $this->load->view('sale/dashboardsale/viewchart/wDashBoardTopTenNewPdt', $aDataConfigView);
    }

    // Functionality : ฟังก์ชั่น  Call View Data Total Sale Product Group
    // Parameters : Function Parameter
    // Creator : 23/01/2019 wasin
    // Return : None
    // Return Type : None
    public function FSvCDSHSALViewTotalSaleByPdtGrp()
    {
        $tFilesOpenPath = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_totalsalebypdtgrp_tmp.txt";
        $oFilesOpen     = fopen($tFilesOpenPath, 'r');
        $aDataFiles     = json_decode(fread($oFilesOpen, filesize($tFilesOpenPath)), true);
        fclose($oFilesOpen);
        // Check ข้อมูลใน Array ว่าค่าหรือไม่
        if (count($aDataFiles) == 0) {
            $aInfoDataReder = array(array("FTPgpChainName" => "", "FCXsdNet" => "0"));
        } else {
            $aInfoDataReder = $aDataFiles;
        }
        require_once APPPATH . 'modules\sale\datasources\charttotalsalebypdtgrp\rChartTotalSaleByPdtGrp.php';
        $oChartTotalSaleByPdtGrp    = new rChartTotalSaleByPdtGrp(array(
            'aDataReturn'   => $aInfoDataReder,
            'aTextLang'     => $this->aTextLang
        ));
        $oChartTotalSaleByPdtGrp->run();
        $tHtmlViewChart     = $oChartTotalSaleByPdtGrp->render('wChartTotalSaleByPdtGrp', true);
        $aDataConfigView    = [
            'tHtmlViewChart'    => $tHtmlViewChart
        ];
        $this->load->view('sale/dashboardsale/wDashBoardChartCenter', $aDataConfigView);
    }

    // Functionality : ฟังก์ชั่น  Call View Data Total Sale Product Type
    // Parameters : Function Parameter
    // Creator : 23/01/2019 wasin
    // Return : None
    // Return Type : None
    public function FSvCDSHSALViewTotalSaleByPdtPty()
    {
        $tFilesOpenPath = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_totalsalebypdtpty_tmp.txt";
        $oFilesOpen     = fopen($tFilesOpenPath, 'r');
        $aDataFiles     = json_decode(fread($oFilesOpen, filesize($tFilesOpenPath)), true);
        fclose($oFilesOpen);
        // Check ข้อมูลใน Array ว่าค่าหรือไม่
        if (count($aDataFiles) == 0) {
            $aInfoDataReder = array(array("FTPtyName" => "", "FCXsdNet" => "0"));
        } else {
            $aInfoDataReder = $aDataFiles;
        }
        require_once APPPATH . 'modules\sale\datasources\charttotalsalebypdtpty\rChartTotalSaleByPdtPty.php';
        $oChartTotalSaleByPdtPty    = new rChartTotalSaleByPdtPty(array(
            'aDataReturn'   => $aInfoDataReder,
            'aTextLang'     => $this->aTextLang
        ));
        $oChartTotalSaleByPdtPty->run();
        $tHtmlViewChart     = $oChartTotalSaleByPdtPty->render('wChartTotalSaleByPdtPty', true);
        $aDataConfigView    = [
            'tHtmlViewChart'    => $tHtmlViewChart
        ];
        $this->load->view('sale/dashboardsale/wDashBoardChartCenter', $aDataConfigView);
    }

    // Functionality : ฟังก์ชั่น  Call View Data Top 10 Best Seller
    // Parameters : Function Parameter
    // Creator : 23/01/2019 wasin
    // Return : None
    // Return Type : None
    public function FSvCDSHSALViewTopTenBestSaller()
    {
        $tFilesOpenPath = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_toptenbestseller_tmp.txt";
        $oFilesOpen     = fopen($tFilesOpenPath, 'r');
        $aDataFiles     = json_decode(fread($oFilesOpen, filesize($tFilesOpenPath)), true);
        fclose($oFilesOpen);
        // Check ข้อมูลใน Array ว่าค่าหรือไม่
        if (count($aDataFiles) == 0) {
            $aInfoDataReder = array(array("FTPdtName" => "", "FCXsdNet" => "0"));
        } else {
            $aInfoDataReder = $aDataFiles;
        }
        require_once APPPATH . 'modules\sale\datasources\charttoptenbestsaller\rChartToptenBestSeller.php';
        $oChartToptenBestSeller = new rChartToptenBestSeller(array(
            'aDataReturn'   => $aInfoDataReder,
            'aTextLang'     => $this->aTextLang
        ));
        $oChartToptenBestSeller->run();
        $tHtmlViewChart     = $oChartToptenBestSeller->render('wChartToptenBestSeller', true);
        $aDataConfigView    = [
            'tHtmlViewChart'    => $tHtmlViewChart
        ];
        unset($tFilesOpenPath);
        unset($oFilesOpen);
        unset($aDataFiles);
        unset($aInfoDataReder);
        unset($oChartToptenBestSeller);
        unset($tHtmlViewChart);
        $this->load->view('sale/dashboardsale/wDashBoardChartCenter', $aDataConfigView);
    }


    // Functionality : ฟังก์ชั่น  Call View Data Top 10 Best Seller By Value
    // Parameters : Function Parameter
    // Creator : 17/07/2020 Worakorn
    // Return : None
    // Return Type : None
    public function FSvCDSHSALViewTopTenBestSallerByValue()
    {
        $tFilesOpenPath = APPPATH . "modules/sale/assets/sysdshtemp/" . $this->tSesUserCode . "/db_toptenbestsellerbyvalue_tmp.txt";
        $oFilesOpen     = fopen($tFilesOpenPath, 'r');
        $aDataFiles     = json_decode(fread($oFilesOpen, filesize($tFilesOpenPath)), true);
        fclose($oFilesOpen);
        // Check ข้อมูลใน Array ว่าค่าหรือไม่
        if (count($aDataFiles) == 0) {
            $aInfoDataReder = array(array("FTPdtName" => "", "FCXsdNet" => "0"));
        } else {
            $aInfoDataReder = $aDataFiles;
        }
        require_once APPPATH . 'modules\sale\datasources\charttoptenbestsallerbyvalue\rChartToptenBestSellerByValue.php';
        $oChartToptenBestSellerByValue = new rChartToptenBestSellerByValue(array(
            'aDataReturn'   => $aInfoDataReder,
            'aTextLang'     => $this->aTextLang
        ));
        $oChartToptenBestSellerByValue->run();
        $tHtmlViewChart     = $oChartToptenBestSellerByValue->render('wChartToptenBestSellerByValue', true);
        $aDataConfigView    = [
            'tHtmlViewChart'    => $tHtmlViewChart
        ];
        unset($tFilesOpenPath);
        unset($oFilesOpen);
        unset($aDataFiles);
        unset($aInfoDataReder);
        unset($oChartToptenBestSellerByValue);
        unset($tHtmlViewChart);
        $this->load->view('sale/dashboardsale/wDashBoardChartCenter', $aDataConfigView);



    }

    // Functionality : ฟังก์ชั่น  Call View Data Total By Bracnh
    // Parameters : Function Parameter
    // Creator : 10/06/2020 Worakorn
    // Return : None
    // Return Type : None
    public function  FSvCDSHSALViewTotalByBranch()
    {
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


        );

        $aListData = array(
            'aTotalSaleByBranchData' => $this->mDashBoardSale->FSaMDSHSALTotalSaleByBranch($aData),
            'aTextLangTotalByBranchShow' => $aTextLangTotalByBranch,
            'nPage'         => $nPage,
            'tSort' => $this->input->post('oetDSHSALSort'),
            'tfild' => $this->input->post('oetDSHSALFild'),
        );

        $aDataConfigView = array(
            'aListViewTotalByBranch' => $this->load->view('sale/dashboardsale/viewchart/wDashBoardTotalByBranch', $aListData),
        );

        $tHtmlViewChart     = $this->load->view('sale/dashboardsale/wDashBoardChartCenter', $aDataConfigView);

        $aDataConfigView    = [
            'tHtmlViewChart'    => $tHtmlViewChart
        ];

        $this->load->view('sale/dashboardsale/wDashBoardChartCenter', $aDataConfigView);
    }


    // Functionality : ฟังก์ชั่น Call View Modal Config Page
    // Parameters : Ajax and Function Parameter
    // Creator : 11/06/2020 Worakorn
    // Return : String View
    // Return Type : View
    public function FSvCDSHSALCallModalConfigPage()
    {

        $aTextLang   = array(
            'tDSHSALModalBtnCancel'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalBtnCancel'),
            'tDSHSALModalBtnSave'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalBtnSave'),
            'tDSHSALBillQty'                => language('sale/dashboardsale/dashboardsale', 'tDSHSALBillQty'),
            'tDSHSALBillTotalAll'                => language('sale/dashboardsale/dashboardsale', 'tDSHSALBillTotalAll'),
            'tDSHSALTotalSaleByPayment'     => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalSaleByPayment'),
            'tDSHSALNewProductTopTen'       => language('sale/dashboardsale/dashboardsale', 'tDSHSALNewProductTopTen'),
            'tDSHSALTotalSaleByPdtGrp'      => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalSaleByPdtGrp'),
            'tDSHSALTotalSaleByPdtType'     => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalSaleByPdtType'),
            'tDSHSALBestSaleProductTopTen'  => language('sale/dashboardsale/dashboardsale', 'tDSHSALBestSaleProductTopTen'),
            'tDSHSALTotalByBranch'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalByBranch'),
            'tDSHSALConfigPage'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALConfigPage'),
            'tDSHSALBestSaleProductTopTenByValue'  => language('sale/dashboardsale/dashboardsale', 'tDSHSALBestSaleProductTopTenByValue'),

        );

        $aDataConfigView    = [
            'aTextLang'    =>  $aTextLang
        ];

        $this->load->view('sale/dashboardsale/viewmodal/wDashBoardConfigPage', $aDataConfigView);
    }

    // Functionality : ฟังก์ชั่น Set Cookie Config Page
    // Parameters : Ajax and Function Parameter
    // Creator : 11/06/2020 Worakorn
    // Return : -
    // Return Type : -
    public function FSvCDSHSALCallModalConfigPageSaveCookie()
    {
        $aResultString = $this->input->post('aResultString');
        // print_r($aResultString);
        // die();
        $tPrefixCookie = "Cookie_SKC";

        $nCookieName = $tPrefixCookie . $this->session->userdata("tSesUserCode");
        $tCookieValue = json_encode($aResultString);


        $aCookie = array(
            'name'   => $nCookieName,
            'value'  => $tCookieValue,
            'expire' =>  31556926,
        );

        $this->input->set_cookie($aCookie);
    }
}
