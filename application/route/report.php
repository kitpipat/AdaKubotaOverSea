<?php

date_default_timezone_set('Asia/Bangkok');

// ** Center Route
$route['rptReport/(:any)/(:any)/(:any)']    = 'report/report/Report_controller/index/$1/$2/$3';
$route['rptReportMain']                     = 'report/report/Report_controller/FCNoCRPTViewPageMain';
$route['rptReportCondition']                = 'report/report/Report_controller/FCNoCRPTViewCondition';
$route['rptReportChkDataInTSysHisExport']   = 'report/report/Report_controller/FCNoCRPTChkDataInTSysHisExport';
$route['rptReportConfirmDownloadFile']      = 'report/report/Report_controller/FCNoCRPTConfirmDownloadFile';
$route['rptReportCancelDownloadFile']       = 'report/report/Report_controller/FCNoCRPTCancelDownloadFile';
$route['rptReportGetBchByAgenCode']       = 'report/report/Report_controller/FCNtGetBchByAgenCode';

// รายงานยอดขายตามการชำระเงิน
$route['rptRptSaleToPayment'] = 'report/reportsale/Rptsalepayment_controller/index';
$route['rptRptSaleToPaymentClickPage']  = 'report/reportsale/Rptsalepayment_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptSaleToPaymentCallExportFile'] = "report/reportsale/Rptsalepayment_controller/FSvCCallRptExportFile";
/** =============================================================================== รายงานการขาย =============================================================================== */
// รายงานยอดขายตามบิล (Pos)
$route['rptRptSaleByBill'] = "report/reportsale/Rptsalebybill_controller/index";
$route['rptRptSaleByBillClickPage'] = "report/reportsale/Rptsalebybill_controller/FSvCCallRptViewBeforePrintClickPage";
$route['rptRptSaleByBillCallExportFile'] = "report/reportsale/Rptsalebybill_controller/FSvCCallRptExportFile";

// รายงานยอดขายตามสินค้า
$route['rptRptSaleByProduct'] = "report/reportsale/Rptsalebyproduct_controller/index";
$route['rptRptSaleByProductClickPage'] = "report/reportsale/Rptsalebyproduct_controller/FSvCCallRptViewBeforePrintClickPage";
$route['rptRptSaleByProductCallExportFile'] = "report/reportsale/Rptsalebyproduct_controller/FSvCCallRptExportFile";

// รายงานภาษีขาย (POS)
$route['rptRptTaxSalePos'] = "report/reportsale/Rpttaxsalepos_controller/index";
$route['rptRptTaxSalePosClickPage'] = "report/reportsale/Rpttaxsalepos_controller/FSvCCallRptViewBeforePrintClickPage";
$route['rptRptTaxSalePosCallExportFile'] = "report/reportsale/Rpttaxsalepos_controller/FSvCCallRptExportFile";

// รายงานภาษีขายตามวันที่ (POS)
$route['rptRptTaxSalePosByDate'] = "report/reportsale/Rpttaxsaleposbydate_controller/index";
$route['rptRptTaxSalePosByDateClickPage'] = "report/reportsale/Rpttaxsaleposbydate_controller/FSvCCallRptViewBeforePrintClickPage";
$route['rptRptTaxSalePosByDateCallExportFile'] = "report/reportsale/Rpttaxsaleposbydate_controller/FSvCCallRptExportFile";

//รายงานความเคลื่อนไหวสินค้า Pos+VD
$route['rtpMovePosVD'] = 'report/reportmoveposvd/Rptmoveposvd_controller/index';
$route['rtpMovePosVDClickPage'] = 'report/reportmoveposvd/Rptmoveposvd_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rtpMovePosVDCallExportFile'] = "report/reportmoveposvd/Rptmoveposvd_controller/FSvCCallRptExportFile";

/** ========================================= รายงานสินค้าคงคลัง (Pos) =============================================================================== */
$route['rptRptInventoryPos'] = 'report/reportinventorypos/Rptinventorypos_controller/index';
$route['rptRptInventoryPosClickPage'] = 'report/reportinventorypos/Rptinventorypos_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptInventoryPosCallExportFile'] = 'report/reportinventorypos/Rptinventorypos_controller/FSvCCallRptExportFile';
/** ===================================================================================================================================================================================== */

/** =============================================================================== รายงานตู้สินค้า (Vending) =============================================================================== */
/** ======================= รายงานการขาย ====================== */
//รายงานยอดขายตามการชำระเงินแบบสรุป  (Vending)
$route['rptSalePaymentSummary'] = 'report/reportsalepaymentsummary/Rptsalepaymentsummary_controller/index';
$route['rptRptSalePaymentSummaryClickPage'] = 'report/reportsalepaymentsummary/Rptsalepaymentsummary_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptSalePaymentSummaryCallExportFile'] = "report/reportsalepaymentsummary/Rptsalepaymentsummary_controller/FSvCCallRptExportFile";

/** ===================== รายงานสินค้าคงคลัง ================================================ */
// รายงานการตรวจนับสต็อก (Vending)
$route['rptRptAdjStockVending'] = 'report/reportstkvd/Rptadjstockvending_controller/index';
$route['rptRptAdjStockVendingClickPage'] = 'report/reportstkvd/Rptadjstockvending_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptAdjStockVendingCallExportFile'] = "report/reportstkvd/Rptadjstockvending_controller/FSvCCallRptExportFile";

/** ===================== รายงานสินค้าขายดี (Vending) ======================================== */
$route['rptRptBestSaleVending'] = 'report/reportbestsalevd/Rptbestsalevending_controller/index';
$route['rptRptBestSaleVendingClickPage'] = 'report/reportbestsalevd/Rptbestsalevending_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptBestSaleVendingCallExportFile'] = "report/reportbestsalevd/Rptbestsalevending_controller/FSvCCallRptExportFile";

/** ===================== รายงานยอดขายตามการชำระเงินแบบละเอียด (Vending) ===================== */
$route['rptRptSalePayDetailVending'] = 'report/reportsalerecivevd/Rptsalerecivevd_controller/index';
$route['rptRptSalePayDetailVendingClickPage'] = 'report/reportsalerecivevd/Rptsalerecivevd_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptSalePayDetailVendingCallExportFile'] = "report/reportsalerecivevd/Rptsalerecivevd_controller/FSvCCallRptExportFile";

// รายงาน POS มีเลข SO KADS (POS)
$route['rptSalDailySOKADE'] = "report/reportsale/Rptsaldailysokade_controller/index";
$route['rptSalDailySOKADEClickPage'] = "report/reportsale/Rptsaldailysokade_controller/FSvCCallRptViewBeforePrintClickPage";
$route['rptSalDailySOKADECallExportFile'] = "report/reportsale/Rptsaldailysokade_controller/FSvCCallRptExportFile";


// รายงาน การขายตาม Channel
$route['rptSalDailyChannel'] = "report/reportsale/Rptsaldailychannel_controller/index";
$route['rptSalDailyChannelClickPage'] = "report/reportsale/Rptsaldailychannel_controller/FSvCCallRptViewBeforePrintClickPage";
$route['rptSalDailyChannelCallExportFile'] = "report/reportsale/Rptsaldailychannel_controller/FSvCCallRptExportFile";
/** ===================================================================================================================================================================================== */

/** =============================================================================== รายงานตู้สินค้า (Vending) =============================================================================== */

/** ===================================================================================================================================================================================== */

/** =============================================================================== รายงานตู้ฝากของ (Locker) =============================================================================== */

// =============================================================================== รายงานตู้ฝากของ ===============================================================================
// รายงานเปลี่ยนสถานะช่องฝากขาย
$route['rptRptChangeStaSale'] = 'report/reportlocker/Rptchangestasale_controller/index';
$route['rptRptChangeStaSaleClickPage'] = 'report/reportlocker/Rptchangestasale_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptChangeStaSaleCallExportFile'] = "report/reportlocker/Rptchangestasale_controller/FSvCCallRptExportFile";

// รายงานการเปิดตู้โดยผู้ดูแลระบบ
$route['rptRptOpenSysAdmin'] = 'report/reportlocker/Rptopensysadmin_controller/index';
$route['rptRptOpenSysAdminClickPage'] = 'report/reportlocker/Rptopensysadmin_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptOpenSysAdminCallExportFile'] = "report/reportlocker/Rptopensysadmin_controller/FSvCCallRptExportFile";

// รายงานภาษีขาย (Locker)
$route['rptRptTaxSaleLocker'] = 'report/reportlocker/Rpttaxsalelocker_controller/index';
$route['rptRptTaxSaleLockerClickPage'] = 'report/reportlocker/Rpttaxsalelocker_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptTaxSaleLockerCallExportFile'] = "report/reportlocker/Rpttaxsalelocker_controller/FSvCCallRptExportFile";

// รายงานยอดขายตามการชำระเงินแบบละเอียด (Locker)
$route['rptRptSaleByPaymentDetail'] = 'report/reportlocker/Rptsalebypaymentdetail_controller/index';
$route['rptRptSaleByPaymentDetailClickPage'] = 'report/reportlocker/Rptsalebypaymentdetail_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptSaleByPaymentDetailCallExportFile'] = "report/reportlocker/Rptsalebypaymentdetail_controller/FSvCCallRptExportFile";
// Create By Witsarut 6/12/2019
// รายงานการฝากตามขนาดช่อง
$route['rptDepositAccSlotSize'] = 'report/reportdepositaccslotsize/Rptdepositaccslotsize_controller/index';
$route['rptDepositAccSlotSizeClickPage'] = 'report/reportdepositaccslotsize/Rptdepositaccslotsize_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptDepositAccSlotSizeCallExportFile'] = "report/reportdepositaccslotsize/Rptdepositaccslotsize_controller/FSvCCallRptExportFile";

// รายงานยอดฝากตามบริษัทขนส่ง (Locker)
$route['rptRentAmountFollowCourier'] = 'report/reportlocker/Rptrentamountfollowecourier_controller/index';
$route['rptRentAmountFollowCourierClickPage'] = 'report/reportlocker/Rptrentamountfollowecourier_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRentAmountFollowCourierCallExportFile'] = "report/reportlocker/Rptrentamountfollowecourier_controller/FSvCCallRptExportFile";

// รายงานยอดฝากแบบละเอียด (Locker)
$route['rptRentAmountDetail'] = 'report/reportlocker/Rptrentamountdetail_controller/index';
$route['rptRentAmountDetailClickPage'] = 'report/reportlocker/Rptrentamountdetail_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRentAmountDetailCallExportFile'] = "report/reportlocker/Rptrentamountdetail_controller/FSvCCallRptExportFile";

// Create By Witsarut 03122019
// รายงานการฝากตามช่วงเวลา (Locker)
$route['rptTimeDeposit'] = 'report/reportlocker/Rpttimedeposit_controller/index';
$route['rptTimeDepositClickPage'] = 'report/reportlocker/Rpttimedeposit_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptTimeDepositCallExportFile'] = "report/reportlocker/Rpttimedeposit_controller/FSvCCallRptExportFile";

// รายงานการฝากตามช่วงเวลา แบบละเอียด (Locker)
$route['rptRptLockerDropByDate'] = 'report/reportlocker/Rptdropbydate_controller/index';
$route['rptRptLockerDropByDateClickPage'] = 'report/reportlocker/Rptdropbydate_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptLockerDropByDateCallExportFile'] = "report/reportlocker/Rptdropbydate_controller/FSvCCallRptExportFile";

// รายงานการรับตามช่วงเวลา แบบละเอียด (Locker)
$route['rptRptLockerPickByDate'] = 'report/reportlocker/Rptpickbydate_controller/index';
$route['rptRptLockerPickByDateClickPage'] = 'report/reportlocker/Rptpickbydate_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptLockerPickByDateCallExportFile'] = "report/reportlocker/Rptpickbydate_controller/FSvCCallRptExportFile";

// รายงาน - การจองช่องฝากของ
$route['rptRptBookingLocker']               = 'report/reportlocker/Rptbookinglocker_controller/index';
$route['rptRptBookingLockerClickPage']      = 'report/reportlocker/Rptbookinglocker_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptBookingLockerCallExportFile'] = "report/reportlocker/Rptbookinglocker_controller/FSvCCallRptExportFile";

// รายงาน - ยอดฝากแบบละเอียด
$route['rptLockerDetailDepositAmount'] = 'report/reportlocker/Rptdetaildepositamount_controller/index';
$route['rptLockerDetailDepositAmountClickPage'] = 'report/reportlocker/Rptdetaildepositamount_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptLockerDetailDepositAmountCallExportFile'] = "report/reportlocker/Rptdetaildepositamount_controller/FSvCCallRptExportFile";

// รายงาน - การชำระเงิน ตามบิล
$route['rptLockerPaymentByBill'] = 'report/reportlocker/Rptpaymentbybill_controller/index';
$route['rptLockerPaymentByBillClickPage'] = 'report/reportlocker/Rptpaymentbybill_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptLockerPaymentByBillCallExportFile'] = "report/reportlocker/Rptpaymentbybill_controller/FSvCCallRptExportFile";

// รายงาน - การชำระเงิน (New Create By Wasin 09-12-2019)
$route['rptLockerPayment']                  = 'report/reportlocker/Rptlockerpayment_controller/index';
$route['rptLockerPaymentClickPage']         = 'report/reportlocker/Rptlockerpayment_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptLockerPaymentCallExportFile']    = "report/reportlocker/Rptlockerpayment_controller/FSvCCallRptExportFile";

/** ============================================================================================================================================= */

/** ======================================== รายงานการโอนสินค้า (ตู้ Vending) ============================================================================ */
$route['rptRptProductTransfer'] = 'report/reportproducttransfer/Rptproducttransfer_controller/index';
$route['rptRptProductTransferClickPage'] = 'report/reportproducttransfer/Rptproducttransfer_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptProductTransferCallExportFile'] = 'report/reportproducttransfer/Rptproducttransfer_controller/FSvCCallRptExportFile';

/** ================================================================================================================================================== */

/** ======================================== รายงานยอดขายตามการชำระเงินแบบละเอียด (Pos) ================================================================= */
$route['rptRptSaleRecive'] = 'report/reportsale/Rptsalerecive_controller/index';
$route['rptRptSaleReciveClickPage'] = 'report/reportsale/Rptsalerecive_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptSaleReciveCallExportFile'] = 'report/reportsale/Rptsalerecive_controller/FSvCCallRptExportFile';
/** ================================================================================================================================================== */

/** ========================================= รายงานสินค้าคงคลัง (Vending) =============================================================================== */
$route['rptRptInventory'] = 'report/reportinventory/Rptinventory_controller/index';
$route['rptRptInventoryClickPage'] = 'report/reportinventory/Rptinventory_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptInventoryCallExportFile'] = 'report/reportinventory/Rptinventory_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ========================================= รายงานภาษีขายตามกลุ่มร้านค้า (Vending) ======================================================================== */
$route['rptRptSaleShopGroup'] = 'report/reportsaleshopgroup/Rptsaleshopgroup_controller/index';
$route['rptRptSaleShopGroupClickPage'] = 'report/reportsaleshopgroup/Rptsaleshopgroup_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptSaleShopGroupCallExportFile'] = 'report/reportsaleshopgroup/Rptsaleshopgroup_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ========================================= รายงานยอดขายตามบิล (Vending) ======================================================================== */
$route['rptRptSalesbyBill'] = 'report/reportsalesbybill/Rptsalesbybill_controller/index';
$route['rptRptSalesbyBillClickPage'] = 'report/reportsalesbybill/Rptsalesbybill_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptSalesbyBillCallExportFile'] = 'report/reportsalesbybill/Rptsalesbybill_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ========================================= รายงานยอดขายตามสินค้า (Vending) ======================================================================== */
$route['rptRptSaleByProductVD'] = 'report/reportsalebyproductvd/Rptsalebyproductvd_controller/index';
$route['rptRptSaleByProductVDClickPage'] = 'report/reportsalebyproductvd/Rptsalebyproductvd_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptSaleByProductVDCallExportFile'] = 'report/reportsalebyproductvd/Rptsalebyproductvd_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ========================================= รายงานวิเคราะห์กำไรขาดทุนตามสินค้า (Vending) ======================================================================== */
$route['rptRptAnalysisProfitLossProductVending'] = 'report/reportanalysisprofitlossproductvending/Rptanalysisprofitlossproductvending_controller/index';
$route['rptRptAnalysisProfitLossProductVendingClickPage'] = 'report/reportanalysisprofitlossproductvending/Rptanalysisprofitlossproductvending_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptAnalysisProfitLossProductVendingCallExportFile'] = 'report/reportanalysisprofitlossproductvending/Rptanalysisprofitlossproductvending_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ========================================= รายงานวิเคราะห์กำไรขาดทุนตามสินค้า (Pos) ======================================================================== */
$route['rptRptAnalysisProfitLossProductPos'] = 'report/reportanalysisprofitlossproductpos/Rptanalysisprofitlossproductpos_controller/index';
$route['rptRptAnalysisProfitLossProductPosClickPage'] = 'report/reportanalysisprofitlossproductpos/Rptanalysisprofitlossproductpos_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptAnalysisProfitLossProductPosCallExportFile'] = 'report/reportanalysisprofitlossproductpos/Rptanalysisprofitlossproductpos_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

// รายงานยอดขายตามการชำระเงิน Locker
$route['rptRptLocToPayment'] = 'report/reportlocker/Rptlocpayment_controller/index';
$route['rptRptLocToPaymentCallExportFile'] = 'report/reportlocker/Rptlocpayment_controller/FSvCCallRptExportFile';
// $route ['rptRptSaleShopByDateClickPage']    = 'report/reportsale/Rptsaleshopbydate_controller/FSvCCallRptViewBeforePrintClickPage';

// รายงาน - สินค้าขายดีตามจำนวน
$route['rptBestSell'] = 'report/rptbestsell/Rptbestsell_controller/index';
$route['rptBestSellClickPage'] = 'report/rptbestsell/Rptbestsell_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptBestSellCallExportFile'] = 'report/rptbestsell/Rptbestsell_controller/FSvCCallRptExportFile';

// รายงาน - สินค้าขายดีตามมูลค่า
$route['rptBestSellByValue'] = 'report/rptbestsellbyvalue/Rptbestsellbyvalue_controller/index';
$route['rptBestSellByValueClickPage'] = 'report/rptbestsellbyvalue/Rptbestsellbyvalue_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptBestSellByValueCallExportFile'] = 'report/rptbestsellbyvalue/Rptbestsellbyvalue_controller/FSvCCallRptExportFile';

/*===== Begin Card Report ==============================================================*/
// 1. รายงานข้อมูลการใช้บัตร 004001001 rptCrdUseCard1
$route['rptCrdUseCard1'] = 'report/reportcard/Rptusecard1_controller/index';
$route['rptCrdUseCard1ClickPage'] = 'report/reportcard/Rptusecard1_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdUseCard1CallExportFile'] = 'report/reportcard/Rptusecard1_controller/FSvCCallRptExportFile';

// 2. รายงานตรวจสอบสถานะบัตร 004001002 rptCrdCheckStatusCard
$route['rptCrdCheckStatusCard'] = 'report/reportcard/Rptcheckstatuscard_controller/index';
$route['rptCrdCheckStatusCardClickPage'] = 'report/reportcard/Rptcheckstatuscard_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdCheckStatusCardCallExportFile'] = 'report/reportcard/Rptcheckstatuscard_controller/FSvCCallRptExportFile';

// 3. รายงานโอนข้อมูลบัตร 004001003 rptCrdTransferCardInfo
$route['rptCrdTransferCardInfo'] = 'report/reportcard/Rpttransfercardinfo_controller/index';
$route['rptCrdTransferCardInfoClickPage'] = 'report/reportcard/Rpttransfercardinfo_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdTransferCardInfoCallExportFile'] = 'report/reportcard/Rpttransfercardinfo_controller/FSvCCallRptExportFile';

// 4. รายงานการปรับมูลค่าเงินสดในบัตร 004001004 rptCrdAdjustCashInCard
$route['rptCrdAdjustCashInCard'] = 'report/reportcard/Rptadjustcashincard_controller/index';
$route['rptCrdAdjustCashInCardClickPage'] = 'report/reportcard/Rptadjustcashincard_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdAdjustCashInCardCallExportFile'] = 'report/reportcard/Rptadjustcashincard_controller/FSvCCallRptExportFile';

// 5. รายงานการล้างมูลค่าบัตรเพื่อกลับมาใช้งานใหม่ 004001005 rptCrdClearCardValueForReuse
$route['rptCrdClearCardValueForReuse'] = 'report/reportcard/Rptclearcardvalueforreuse_controller/index';
$route['rptCrdClearCardValueForReuseClickPage'] = 'report/reportcard/Rptclearcardvalueforreuse_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdClearCardValueForReuseCallExportFile'] = 'report/reportcard/Rptclearcardvalueforreuse_controller/FSvCCallRptExportFile';

// 6. รายงานการลบข้อมูลบัตรที่ไม่ใช้งาน 004001006 rptCrdCardNoActive
$route['rptCrdCardNoActive'] = 'report/reportcard/Rptcardnoactive_controller/index';
$route['rptCrdCardNoActiveClickPage'] = 'report/reportcard/Rptcardnoactive_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdCardNoActiveCallExportFile'] = 'report/reportcard/Rptcardnoactive_controller/FSvCCallRptExportFile';

// 7. รายงานจำนวนรอบการใช้บัตร 004001007 rptCrdCardTimesUsed
$route['rptCrdCardTimesUsed'] = 'report/reportcard/Rptcardtimesused_controller/index';
$route['rptCrdCardTimesUsedClickPage'] = 'report/reportcard/Rptcardtimesused_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdCardTimesUsedCallExportFile'] = 'report/reportcard/Rptcardtimesused_controller/FSvCCallRptExportFile';

// 8. รายงานบัตรคงเหลือ 004001008 rptCrdCardBalance
$route['rptCrdCardBalance'] = 'report/reportcard/Rptcardbalance_controller/index';
$route['rptCrdCardBalanceClickPage'] = 'report/reportcard/Rptcardbalance_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdCardBalanceCallExportFile'] = 'report/reportcard/Rptcardbalance_controller/FSvCCallRptExportFile';

// 9. รายงานยอดสะสมบัตรหมดอายุ 004001009 rptCrdCollectExpireCard
$route['rptCrdCollectExpireCard'] = 'report/reportcard/Rptcollectexpirecard_controller/index';
$route['rptCrdCollectExpireCardClickPage'] = 'report/reportcard/Rptcollectexpirecard_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdCollectExpireCardCallExportFile'] = 'report/reportcard/Rptcollectexpirecard_controller/FSvCCallRptExportFile';

// 10. รายงานรายการต้นงวดบัตรและเงินสด 004001010 rptCrdPrinciple
$route['rptCrdCardPrinciple'] = 'report/reportcard/Rptcardprinciple_controller/index';
$route['rptCrdCardPrincipleClickPage'] = 'report/reportcard/Rptcardprinciple_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdCardPrincipleCallExportFile'] = 'report/reportcard/Rptcardprinciple_controller/FSvCCallRptExportFile';

// 11. รายงานข้อมูลบัตร 004001011 rptCrdCardDetail
$route['rptCrdCardDetail'] = 'report/reportcard/Rptcarddetail_controller/index';
$route['rptCrdCardDetailClickPage'] = 'report/reportcard/Rptcarddetail_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdCardDetailCallExportFile'] = 'report/reportcard/Rptcarddetail_controller/FSvCCallRptExportFile';

// 12. รายงานตรวจสอบการเติมเงิน 004001012 rptCrdCheckPrepaid
$route['rptCrdCheckPrepaid'] = 'report/reportcard/Rptcheckprepaid_controller/index';
$route['rptCrdCheckPrepaidClickPage'] = 'report/reportcard/Rptcheckprepaid_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdCheckPrepaidCallExportFile'] = 'report/reportcard/Rptcheckprepaid_controller/FSvCCallRptExportFile';

// 13. รายงานตรวจสอบข้อมูลการใช้บัตร 004001013 rptCrdCheckCardUseInfo
$route['rptCrdCheckCardUseInfo'] = 'report/reportcard/Rptcheckcarduseinfo_controller/index';
$route['rptCrdCheckCardUseInfoClickPage'] = 'report/reportcard/Rptcheckcarduseinfo_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdCheckCardUseInfoCallExportFile'] = 'report/reportcard/Rptcheckcarduseinfo_controller/FSvCCallRptExportFile';

// 14. รายงานการเติมเงิน 004001014 rptCrdTopUp
$route['rptCrdTopUp'] = 'report/reportcard/Rpttopup_controller/index';
$route['rptCrdTopUpClickPage'] = 'report/reportcard/Rpttopup_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdTopUpCallExportFile'] = 'report/reportcard/Rpttopup_controller/FSvCCallRptExportFile';

// 15. รายงานข้อมูลการใช้บัตร 004001015 (แบบละเอียด) rptCrdUseCard2
$route['rptCrdUseCard2'] = 'report/reportcard/Rptusecard2_controller/index';
$route['rptCrdUseCard2ClickPage'] = 'report/reportcard/Rptusecard2_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptCrdUseCard2CallExportFile'] = 'report/reportcard/Rptusecard2_controller/FSvCCallRptExportFile';
/*===== End Card Report ================================================================*/


/*===== Begin Analysis Report ==========================================================*/
// 1. รายงานยอดขายร้านค้า-ตามวันที่ 005001001 rptSaleShopByDate
$route['rptSaleShopByDate'] = 'report/reportanalysis/Rptsaleshopbydate_controller/index';
$route['rptSaleShopByDateClickPage'] = 'report/reportanalysis/Rptsaleshopbydate_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptSaleShopByDateCallExportFile'] = 'report/reportanalysis/Rptsaleshopbydate_controller/FSvCCallRptExportFile';

// 2. รายงานยอดขายร้านค้า-ตามร้านค้า 005001002 rptSaleShopByShop
$route['rptSaleShopByShop'] = 'report/reportanalysis/Rptsaleshopbyshop_controller/index';
$route['rptSaleShopByShopClickPage'] = 'report/reportanalysis/Rptsaleshopbyshop_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptSaleShopByShopCallExportFile'] = 'report/reportanalysis/Rptsaleshopbyshop_controller/FSvCCallRptExportFile';

// 3. รายงานการเคลื่อนไหวบัตร-แบบสรุป 005001003 rptCrdCardActiveSummary
// 4. รายงานการเคลื่อนไหวบัตร-แบบละเอียด 005001004 rptCrdCardActiveDetail
// 5. รายงานสรุปยอดเงินคงเหลือบัตรไม่ได้แลกคืน 005001005 rptCrdUnExchangeBalance
/*===== End Analysis Report ============================================================*/

/** ========================================= รายงาน - การฝากที่ยังไม่มารับ (Locker) ======================================================================== */
$route['rptRptDepositsNotPicked']               = 'report/reportlocker/Rptdepositsnotpicked_controller/index';
$route['rptRptDepositsNotPickedClickPage']      = 'report/reportlocker/Rptdepositsnotpicked_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptDepositsNotPickedCallExportFile'] = 'report/reportlocker/Rptdepositsnotpicked_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ========================================= รายงาน - การรับตามช่วงเวลา (Locker) ======================================================================== */
$route['rptRptRecePtionByTime']               = 'report/reportlocker/Rptreceptionbytime_controller/index';
$route['rptRptRecePtionByTimeClickPage']      = 'report/reportlocker/Rptreceptionbytime_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptRecePtionByTimeCallExportFile'] = 'report/reportlocker/Rptreceptionbytime_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ========================================= รายงาน - การรับ-ฝากแบบละเอียด (Locker) ======================================================================== */
$route['rptRptDetailReceiveDeposit']               = 'report/reportlocker/Rptdetailreceivedeposit_controller/index';
$route['rptRptDetailReceiveDepositClickPage']      = 'report/reportlocker/Rptdetailreceivedeposit_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptDetailReceiveDepositCallExportFile'] = 'report/reportlocker/Rptdetailreceivedeposit_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */


// Create By Witsarut  18/12/2019
/** ===================== กลุ่มรายงาน พิเศษ ===================== */
$route['rptCRSaleTaxByWeekly']               = 'report/reportsalespecial/Rptcrsaletaxbyweekly_controller/index';
$route['rptCRSaleTaxByWeeklyClickPage']      = 'report/reportsalespecial/Rptcrsaletaxbyweekly_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptCRSaleTaxByWeeklyCallExportFile'] = 'report/reportsalespecial/Rptcrsaletaxbyweekly_controller/FSvCCallRptExportFile';


/** ======================================== รายงานยอดขาย (Pos Service) ================================================================= */
$route['rptRptCrSale'] = 'report/reportsalespecial/Rptcrsale_controller/index';
$route['rptRptCrSaleClickPage'] = 'report/reportsalespecial/Rptcrsale_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptCrSaleCallExportFile'] = 'report/reportsalespecial/Rptcrsale_controller/FSvCCallRptExportFile';
/** ================================================================================================================================================== */

/** ========================================= รายงาน - ยอดขาย (POS+VD) ======================================================================== */
$route['rptRptSalePosVD']                        = 'report/reportsalespecial/Rptsaleposvd_controller/index';
$route['rptRptSalePosVDClickPage']               = 'report/reportsalespecial/Rptsaleposvd_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptSalePosVDCallExportFile']          = 'report/reportsalespecial/Rptsaleposvd_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ========================================= รายงาน - รายงานยอดขายผลิตภัณฑ์ของวัน (POS Vending) ========================================================== */
$route['rptRptCrSaleProductByDay']                          = 'report/reportsalespecial/Rptsaleproductbyday_controller/index';
$route['rptRptCrSaleProductByDayClickPage']                 = 'report/reportsalespecial/Rptsaleproductbyday_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptCrSaleProductByDayCallExportFile']            = 'report/reportsalespecial/Rptsaleproductbyday_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ========================================= รายงาน - รายงานยอดขายผลิตภัณฑ์ของเดือน (POS Vending) ========================================================== */
$route['rptRptCrSaleProductByMonth']                        = 'report/reportsalespecial/Rptsaleproductbymonth_controller/index';
$route['rptRptCrSaleProductByMonthClickPage']               = 'report/reportsalespecial/Rptsaleproductbymonth_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptCrSaleProductByMonthCallExportFile']          = 'report/reportsalespecial/Rptsaleproductbymonth_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงานภาษีขาย (วัน) ==================================================================== */
$route['rptDailySalesTax']                  = 'report/reportsalespecial/Rptdailysalestax_controller/index';
$route['rptDailySalesTaxClickPage']        = 'report/reportsalespecial/Rptdailysalestax_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptDailySalesTaxCallExportFile']   = 'report/reportsalespecial/Rptdailysalestax_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงานภาษีขาย (รายเดือน) ==================================================================== */
$route['rptRptSpecialSaleTaxByMonthly']                 = 'report/reportsalespecial/Rptsaletaxbymonthly_controller/index';
$route['rptRptSpecialSaleTaxByMonthlyClickPage']        = 'report/reportsalespecial/Rptsaletaxbymonthly_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptSpecialSaleTaxByMonthlyCallExportFile']   = 'report/reportsalespecial/Rptsaletaxbymonthly_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

// รายงานยอดขายผลิตภัณฑ์ของสัปดาห์ (POS Vending) 001003012 rptProductSaleOfWeek
$route['rptProductSaleOfWeek'] = "report/reportproductsaleofweek/Rptproductsaleofweek_controller/index";
$route['rptProductSaleOfWeekClickPage'] = "report/reportproductsaleofweek/Rptproductsaleofweek_controller/FSvCCallRptViewBeforePrintClickPage";
$route['rptProductSaleOfWeekCallExportFile'] = "report/reportproductsaleofweek/Rptproductsaleofweek_controller/FSvCCallRptExportFile";

/** ======================================================= (CR) รายงานยอดขายรายวัน (POS Service) ==================================================================== */
$route['rptRptDailySalesPosSv']                         = 'report/reportsalespecial/Rptdailysalespossv_controller/index';
$route['rptRptDailySalesPosSvClickPage']                = 'report/reportsalespecial/Rptdailysalespossv_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptDailySalesPosSvCallExportFile']           = 'report/reportsalespecial/Rptdailysalespossv_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= (CR) รายงานยอดขายรายสัปดาห์ (POS Service) ==================================================================== */
$route['rptRptWeeklySale']                         = 'report/reportsalespecial/Rptweeklysale_controller/index';
$route['rptRptWeeklySaleClickPage']                = 'report/reportsalespecial/Rptweeklysale_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptWeeklySaleCallExportFile']           = 'report/reportsalespecial/Rptweeklysale_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================== รายงานยอดขายรายเดือน (Pos Service) ================================================================= */
$route['rptRptCrSaleMonth'] = 'report/reportsalespecial/Rptcrsalemonth_controller/index';
$route['rptRptCrSaleMonthClickPage'] = 'report/reportsalespecial/Rptcrsalemonth_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptCrSaleMonthCallExportFile'] = 'report/reportsalespecial/Rptcrsalemonth_controller/FSvCCallRptExportFile';
/** ================================================================================================================================================== */

/** ======================================================= (CR) รายงานยอดขายผลิตภัณฑ์ (POS Vending) (แบบรายละเอียดรายวัน) ==================================================================== */
$route['rptProductSalesPosVD']                         = 'report/reportsalespecial/Rptproductsalesposvd_controller/index';
$route['rptProductSalesPosVDClickPage']                = 'report/reportsalespecial/Rptproductsalesposvd_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptProductSalesPosVDCallExportFile']           = 'report/reportsalespecial/Rptproductsalesposvd_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงานการนำฝากแบบละเอียด สาขา ==================================================================== */
$route['rptBankDepositBch']                         = 'report/reportlocker/Rptbankdepositbch_controller/index';
$route['rptBankDepositBchClickPage']                = 'report/reportlocker/Rptbankdepositbch_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptBankDepositBchCallExportFile']           = 'report/reportlocker/Rptbankdepositbch_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงาน ยอดเงินขาด/เงินเกิน ของแคชเชียร์ (ประจำวัน) ==================================================================== */
$route['rptMnyShotOver']                         = 'report/reportsale/Rptmnyshotover_controller/index';
$route['rptMnyShotOverClickPage']                = 'report/reportsale/Rptmnyshotover_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptMnyShotOverCallExportFile']           = 'report/reportsale/Rptmnyshotover_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงาน ยอดเงินขาด/เงินเกิน ของแคชเชียร์ ประจำวัน(ละเอียด) ==================================================================== */
$route['rptMnyShotOverDairy']                         = 'report/reportsale/Rptmnyshotoverdaily_controller/index';
$route['rptMnyShotOverDairyClickPage']                = 'report/reportsale/Rptmnyshotoverdaily_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptMnyShotOverDairyCallExportFile']           = 'report/reportsale/Rptmnyshotoverdaily_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงาน ยอดเงินขาด/เงินเกิน ของแคชเชียร์ รายเดือน(ละเอียด) ==================================================================== */
$route['rptMnyShotOverMonthly']                         = 'report/reportsale/Rptmnyshotovermonthly_controller/index';
$route['rptMnyShotOverMonthlyClickPage']                = 'report/reportsale/Rptmnyshotovermonthly_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptMnyShotOverMonthlyCallExportFile']           = 'report/reportsale/Rptmnyshotovermonthly_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงานยอดขาย - ตามจุดขาย ==================================================================== */
$route['rptsaledailybypos']                         = 'report/rptsaledailybypos/Rptsaledailybypos_controller/index';
$route['rptsaledailybyposClickPage']                = 'report/rptsaledailybypos/Rptsaledailybypos_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptsaledailybyposCallExportFile']           = 'report/rptsaledailybypos/Rptsaledailybypos_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงานยอดขาย - ตามแคชเชียร์ ==================================================================== */
$route['rptSalesDailyByCashier']                         = 'report/reportsale/Rptsalesdailybycashier_controller/index';
$route['rptSalesDailyByCashierClickPage']                = 'report/reportsale/Rptsalesdailybycashier_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptSalesDailyByCashierCallExportFile']           = 'report/reportsale/Rptsalesdailybycashier_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงาน - จำนวนขายประจำเดือน - ตามสินค้า ==================================================================== */
$route['rptSMP']                         = 'report/reportsale/Rptsalesmonthproduct_controller/index';
$route['rptSMPClickPage']                = 'report/reportsale/Rptsalesmonthproduct_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptSMPCallExportFile']           = 'report/reportsale/Rptsalesmonthproduct_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** ======================================================= รายงาน - การคืนสินค้าตามวันที่ ==================================================================== */
$route['rptRPD']                         = 'report/reportsale/Rptreturnproductbydate_controller/index';
$route['rptRPDClickPage']                = 'report/reportsale/Rptreturnproductbydate_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRPDCallExportFile']           = 'report/reportsale/Rptreturnproductbydate_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */


// Report For AdaStatDose
// Create By Witsarut 12/02/2020

/** ======================================================= รายางานการเติมสินค้า ==================================================================== */
$route['rptProductRefill']                  = 'report/reportproductrefill/Rptproductrefill_controller/index';
$route['rptProductRefillClickPage']         = 'report/reportproductrefill/Rptproductrefill_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptProductRefillCallExportFile']    = 'report/reportproductrefill/Rptproductrefill_controller/FSvCCallRptExportFile';

/** ======================================== รายงานสินค้าคงคลังตามสินค้าตามตู้  ================================================================= */
$route['rptProductByCabinet']               = 'report/reportproductbycabinet/Rptpdtbycabinet_controller/index';
$route['rptProductByCabinetClickPage']      = 'report/reportproductbycabinet/Rptpdtbycabinet_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptProductByCabinetCallExportFile'] = 'report/reportproductbycabinet/Rptpdtbycabinet_controller/FSvCCallRptExportFile';

/** ======================================== รายงานการสั่งขาย  ================================================================= */
$route['rptSaleOrder']                      = 'report/reportsale/Rptsaleorder_controller/index';
$route['rptSaleOrderClickPage']             = 'report/reportsale/Rptsaleorder_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptSaleOrderCallExportFile']        = 'report/reportsale/Rptsaleorder_controller/FSvCCallRptExportFile';

//report Create by nonpawich 17/2/2020

/** ======================================== รายงานสินค้าไม่ผ่านอนุมัติ  ================================================================= */
$route['rptSaleSoNotPass']                      = 'report/reportsalesonotpass/Rptsalesonotpass_controller/index';
$route['rptSaleSoNotPassClickPage']             = 'report/reportsalesonotpass/Rptsalesonotpass_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptSaleSoNotPassCallExportFile']        = 'report/reportsalesonotpass/Rptsalesonotpass_controller/FSvCCallRptExportFile';
/** =================================================================================================================================================== */

/** =================================================================================================================================================== */
// Create By Witsarut 29/04/2020
// รายงานยอดขายสิ้นวัน
$route['rptRptDayEndSales']               = 'report/reportsale/Rptdayendsales_controller/index';
$route['rptRptDayEndSalesClickPage']      = 'report/reportsale/Rptdayendsales_controller/FSvCCallRptViewBeforePrintClickPage';
$route['rptRptDayEndSalesCallExportFile'] = "report/reportsale/Rptdayendsales_controller/FSvCCallRptExportFile";
/** =================================================================================================================================================== */

// Create By Witsarut 29/04/2020
// รายงาน- ภาษีขาย (เต็มรูป)
$route['rptRptTaxSaleFull']                 = "report/reportsale/Rpttaxsalefull_controller/index";
$route['rptRptTaxSaleFullClickPage']        = "report/reportsale/Rpttaxsalefull_controller/FSvCCallRptViewBeforePrintClickPage";
$route['rptRptTaxSaleFullCallExportFile']   = "report/reportsale/Rpttaxsalefull_controller/FSvCCallRptExportFile";

// Create By Saharat 04/05/2020
// รายงาน- ภาษีขายตามวันที่ (เต็มรูป)
$route['rptRptTaxSalePosByDateFull']                 = "report/reportsale/Rpttaxsaleposbydatefull_controller/index";
$route['rptRptTaxSalePosByDateFullClickPage']        = "report/reportsale/Rpttaxsaleposbydatefull_controller/FSvCCallRptViewBeforePrintClickPage";
$route['rptRptTaxSalePosByDateFullCallExportFile']   = "report/reportsale/Rpttaxsaleposbydatefull_controller/FSvCCallRptExportFile";

// รายงาน ยอดขายตามแคชเชียร์ - ตามเครื่องจุดขาย
$route['rptSaleByCashierAndPos'] = "report/reportsale/Rptsalebycashierandpos_controller/index";
$route['rptSaleByCashierAndPosClickPage'] = "report/reportsale/Rptsalebycashierandpos_controller/FSvCCallRptViewBeforePrintClickPage";
$route['rptSaleByCashierAndPosCallExportFile'] = "report/reportsale/Rptsalebycashierandpos_controller/FSvCCallRptExportFile";

// Create By Nattakit 09/07/2020
// รายงาน - ยกเลิกบิลตามวันที่
$route['rptCancelBillByDate'] = "report/reportsale/Rptcancelbillbydate_controller/index";
$route['rptCancelBillByDateClickPage'] = "report/reportsale/Rptcancelbillbydate_controller/FSvCCallRptViewBeforePrintClickPage";
$route['rptCancelBillByDateCallExportFile'] = "report/reportsale/Rptcancelbillbydate_controller/FSvCCallRptExportFile";

// Create By Nattakit 09/07/2020
// รายงาน - ยกเลิกรายการตามวันที่
$route['rptCancelPdtDetailByDate'] = "report/reportsale/Rptcancelpdtdetailbydate_controller/index";
$route['rptCancelPdtDetailByDateClickPage'] = "report/reportsale/Rptcancelpdtdetailbydate_controller/FSvCCallRptViewBeforePrintClickPage";
$route['rptCancelPdtDetailByDateCallExportFile'] = "report/reportsale/Rptcancelpdtdetailbydate_controller/FSvCCallRptExportFile";


//Create By Witsarut 21/07/2020
//รายงาน - ยอดขายตามสมาชิก
$route['rptSaleMember']                 = "report/reportsale/Rptsalemember_controller/index";
$route['rptSaleMemberClickPage']        = "report/reportsale/Rptsalemember_controller/FSvCCallRptViewBeforePrintClickPage";
$route['rptSaleMemberCallExportFile']   = "report/reportsale/Rptsalemember_controller/FSvCCallRptExportFile";


//Create By Witsarut 21/07/2020
//รายงาน - แต้มแบบสรุป (Point By Customer)
$route['rptPointByCst']                 = "report/reportsale/Rptpointbycst_controller/index";
$route['rptPointByCstClickPage']        = "report/reportsale/Rptpointbycst_controller/FSvCCallRptViewBeforePrintClickPage";
$route['rptPointByCstCallExportFile']   = "report/reportsale/Rptpointbycst_controller/FSvCCallRptExportFile";


// Create By Witsarut 24/08/2020
// รายงาน - ภาษีตามสินค้า
$route['rptTaxByProduct']               = "report/reportsale/Rpttaxbyproduct_controller/index";
$route['rptTaxByProductClickPage']      = "report/reportsale/Rpttaxbyproduct_controller/FSvCCallRptViewBeforePrintClickPage";
$route['rptTaxByProductCallExportFile'] = "report/reportsale/Rpttaxbyproduct_controller/FSvCCallRptExportFile";


// Create By Sooksanti 24/08/2020
// รายงาน - ส่วนลดโปรโมชั่นตามบิล
$route['rptSalPdtBillPmt']               = "report/reportsale/Rptsalpdtbillpmt_controller/index";
$route['rptSalPdtBillPmtClickPage']      = "report/reportsale/Rptsalpdtbillpmt_controller/FSvCCallRptViewBeforePrintClickPage";
$route['rptSalPdtBillPmtCallExportFile'] = "report/reportsale/Rptsalpdtbillpmt_controller/FSvCCallRptExportFile";
