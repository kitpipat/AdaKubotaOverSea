<?php
    $aCompanyInfo = $aDataViewRpt['aCompanyInfo'];
    $aDataFilter = $aDataViewRpt['aDataFilter'];
    $aDataTextRef = $aDataViewRpt['aDataTextRef'];
    $aDataReport = $aDataViewRpt['aDataReport'];
?>


<style>
    .xCNFooterRpt {
        border-bottom: 7px double #ddd;
    }
    .table thead th,
    .table>thead>tr>th,
    .table tbody tr,
    .table>tbody>tr>td {
        border: 0px transparent !important;
    }

    .table>thead:first-child>tr:first-child>td,
    .table>thead:first-child>tr:first-child>th {
        border-top: 1px solid black !important;
        border-bottom: 0px transparent !important;
        /*border-bottom : 1px solid black !important;
        background-color: #CFE2F3 !important;*/
    }

    .table>thead:first-child>tr:first-child>td:nth-child(1),
    .table>thead:first-child>tr:first-child>th:nth-child(1),
    .table>thead:first-child>tr:first-child>td:nth-child(2),
    .table>thead:first-child>tr:first-child>th:nth-child(2),
    .table>thead:first-child>tr:first-child>td:nth-child(3),
    .table>thead:first-child>tr:first-child>th:nth-child(3) {
        border-bottom: 1px dashed #ccc !important;
    }

    .table>thead:first-child>tr:last-child>td,
    .table>thead:first-child>tr:last-child>th {
        /*border-top: 1px solid black !important;*/
        border-bottom: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
    }

    .table>tbody>tr.xCNTrSubFooter {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
    }

    .table>tbody>tr.xCNTrFooter {
        border-top: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
        border-bottom: 6px double black !important;
    }

    .xWRptMSODlinetablemenu {

border-right: 1px dashed #ccc !important;
}
    .xWRptMSODUnderline {

border-bottom: 1px dashed #ccc !important;
}
    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(3),
    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(4),
    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(5),
    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(6),
    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(7) {
        border: 0px solid black !important;
        border-bottom: 1px dashed #ccc !important;
    }

    .table tbody tr.xCNRptLastGroupTr,
    .table>tbody>tr.xCNRptLastGroupTr>td {
        border: 0px solid black !important;
        border-bottom: 1px dashed #ccc !important;
    }

    .table tbody tr.xCNRptSumFooterTrTop,
    .table>tbody>tr.xCNRptSumFooterTrTop>td {
        border: 0px solid black !important;
        border-top: 1px solid black !important;
    }

    .table tbody tr.xCNRptSumFooterTrBottom,
    .table>tbody>tr.xCNRptSumFooterTrBottom>td {
        border: 0px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .table>tfoot>tr {
        border-top: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
        border-bottom: 6px double black !important;
    }

    /*แนวนอน*/
    @media print{@page {size: landscape}}
    /*แนวตั้ง*/
    /* @media print {
        @page {
            size: portrait
        }
    } */
</style>

<div id="odvRptAdjustStockVendingHtml">
    <div class="container-fluid xCNLayOutRptHtml">

        <div class="xCNHeaderReport">
         
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>

                        <div class="text-left">
                            <label class="xCNRptCompany"><?= $aCompanyInfo['FTCmpName'] ?></label>
                        </div>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') { // ที่อยู่แบบแยก ?>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi'] ?> <?= $aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode'] ?></label>
                            </div>
                        <?php } ?>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') { // ที่อยู่แบบรวม ?>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTAddV2Desc1'] ?><?= $aCompanyInfo['FTAddV2Desc2'] ?></label>
                            </div>
                        <?php } ?>

                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptAddrTel'] . $aCompanyInfo['FTCmpTel'] ?></label>
                            <label><?= $aDataTextRef['tRptAddrFax'] . $aCompanyInfo['FTCmpFax'] ?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptAddrBranch'] . $aCompanyInfo['FTBchName'] ?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?=$aDataTextRef['tRptTaxSalePosTaxId'] . $aCompanyInfo['FTAddTaxNo']?></label>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 report-filter">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                            </div>
                        </div>
                    </div>

                    <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                    <?php if (isset($aDataFilter['tBchCodeSelect']) && !empty($aDataFilter['tBchCodeSelect'])) : ?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo ($aDataFilter['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tBchNameSelect']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom'] ?> : </label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateFrom'])); ?></label>
                                   <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo'] ?> : </label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateTo'])); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom'] ?> : </label>   <label><?=$aDataFilter['tBchNameFrom']; ?></label>
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo'] ?> : </label>   <label><?=$aDataFilter['tBchNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>

                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    &nbsp;
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptDataPrint"><?php echo $aDataTextRef['tDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tTimePrint'] . ' ' . date('H:i:s'); ?></label>
                    </div>
                </div>
            </div>
        </div>
 
        <div class="xCNContentReport">
            <div id="odvRptTableShotOverHtml" class="table-responsive">
            <table class="table">
                    <thead>
                        <tr class="xWRptMSODUnderline">
                            <th class="text-center xCNRptColumnHeader" style= "width:3%;"><?php echo $aDataTextRef['tRptMnyDairyPos']; ?></th>
                            <th class="text-center xCNRptColumnHeader" style= "width:3%;"><?php echo $aDataTextRef['tRptMnyDairyUsrId']; ?></th>
                            <th class="text-center xCNRptColumnHeader" style= "width:3%;"><?php echo $aDataTextRef['tRptDate']; ?></th>
                            <th colspan="4" class="text-center xCNRptColumnHeader" style ="border-right: 1px dashed #ccc !important; border-left: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyDairyAmt']; ?></th>
                            <th colspan="2" class="text-center xCNRptColumnHeader" style ="border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyDairyCash']; ?></th>
                            <th colspan="2" class="text-center xCNRptColumnHeader" style ="border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyDairyCredit']; ?></th>
                            <th colspan="2" class="text-center xCNRptColumnHeader" style ="border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyDairyVouchers']; ?></th>
                            <th colspan="2" class="text-center xCNRptColumnHeader" style ="border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyDairyCoupon']; ?></th>
                            <th colspan="2" class="text-center xCNRptColumnHeader" style ="border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyDairyCheck']; ?></th>
                            <th colspan="2" class="text-center xCNRptColumnHeader" style ="border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyDairyPromptPay']; ?></th>
                            <th colspan="2" class="text-center xCNRptColumnHeader" style ="border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyDairyOther']; ?></th>
                            <th colspan="2" class="text-center xCNRptColumnHeader" style ="border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyDairySales']; ?></th>
                        </tr>
                        
                        <tr>
                            <th colspan="3"></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style= "width:5%; border-left: 1px dashed #ccc !important; "><?php echo $aDataTextRef['tRptMnyCashIn'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style ="width:5%; border-right: 1px dashed #ccc !important; "><?php echo $aDataTextRef['tRptMnyCashOut'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style= "border-left: 1px dashed #ccc !important; "><?php echo $aDataTextRef['tRptMnyDairyMM']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style ="border-right: 1px dashed #ccc !important; "><?php echo $aDataTextRef['tRptMnyDairyOM']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptMnyDairyCloseshift']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style ="border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyDairyFromSystem']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptMnyDairyCloseshift']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style ="border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyDairyFromSystem']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptMnyDairyCloseshift']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style ="border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyDairyFromSystem']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptMnyDairyCloseshift']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style ="border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyDairyFromSystem']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptMnyDairyCloseshift']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style ="border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyDairyFromSystem']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptMnyDairyCloseshift']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style ="border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyDairyFromSystem']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptMnyDairyCloseshift']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style ="border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyDairyFromSystem']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptMnyDairyCloseshift']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style ="border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyDairyFromSystem']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                     if(!empty($aDataReport['aRptData'])){
                         foreach($aDataReport['aRptData'] as $aData){
                    ?>
                        <tr>
                            <td  class="text-left xCNRptDetail" style="width:5%;"><?php echo $aData['FTPosCode']; ?></td>
                            <td  class="text-left xCNRptDetail" style="width:5%;"><?php echo $aData['FTUsrCode']; ?></td>
                            <td  class="text-left xCNRptDetail" style="width:5%;"><?php echo date('d/m/Y',strtotime($aData['FDShdSaleDate'])); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;"><?php echo number_format($aData['FCSvnCashIn'],2);?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;"><?php echo number_format($aData['FCSvnCashOut'],2);?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;"><?php echo number_format($aData['FCMnyShot']*(-1),2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;"><?php echo number_format($aData['FCMnyOver'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;"><?php echo number_format($aData['FCKbnAmtCash'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;"><?php echo number_format($aData['FCRcvPayCash'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;"><?php echo number_format($aData['FCKbnAmtCredit'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;"><?php echo number_format($aData['FCRcvPayCredit'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;"><?php echo number_format($aData['FCKbnAmtVouchers'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;"><?php echo number_format($aData['FCRcvPayVouchers'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;"><?php echo number_format($aData['FCKbnAmtCoupon'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;"><?php echo number_format($aData['FCRcvPayCoupon'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;"><?php echo number_format($aData['FCKbnAmtChque'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;"><?php echo number_format($aData['FCRcvPayChque'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;"><?php echo number_format($aData['FCKbnAmtPromptpay'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;"><?php echo number_format($aData['FCRcvPayPromptpay'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;"><?php echo number_format($aData['FCKbnAmtOther'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;"><?php echo number_format($aData['FCRcvPayOther'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:3%;"><?php echo number_format($aData['FCAmtShipClose'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:3%;"><?php echo number_format($aData['FCAmtSystem'],2); ?></td>
                        </tr>
                    <?php
                            }
                            ?>
                            <?php  
                                $nPageNo    = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                                if ($nPageNo == $nTotalPage) { ?>

                                <?php $FCMnyOver_Footer             = $aData['FCMnyOver_Footer']; ?>
                                <?php $FCMnyShot_Footer             = $aData['FCMnyShot_Footer']; ?>
                                <?php $FCKbnAmtCash_Footer          = $aData['FCKbnAmtCash_Footer']; ?>
                                <?php $FCRcvPayCash_Footer          = $aData['FCRcvPayCash_Footer']; ?>
                                <?php $FCKbnAmtCredit_Footer        = $aData['FCKbnAmtCredit_Footer']; ?>
                                <?php $FCRcvPayCredit_Footer        = $aData['FCRcvPayCredit_Footer']; ?>
                                <?php $FCKbnAmtVouchers_Footer      = $aData['FCKbnAmtVouchers_Footer']; ?>
                                <?php $FCRcvPayVouchers_Footer      = $aData['FCRcvPayVouchers_Footer']; ?>
                                <?php $FCKbnAmtCoupon_Footer        = $aData['FCKbnAmtCoupon_Footer']; ?>
                                <?php $FCRcvPayCoupon_Footer        = $aData['FCRcvPayCoupon_Footer']; ?>
                                <?php $FCKbnAmtChque_Footer         = $aData['FCKbnAmtChque_Footer']; ?>
                                <?php $FCRcvPayChque_Footer         = $aData['FCRcvPayChque_Footer']; ?>
                                <?php $FCKbnAmtPromptpay_Footer     = $aData['FCKbnAmtPromptpay_Footer']; ?>
                                <?php $FCRcvPayPromptpay_Footer     = $aData['FCRcvPayPromptpay_Footer']; ?>
                                <?php $FCKbnAmtOther_Footer         = $aData['FCKbnAmtOther_Footer']; ?>
                                <?php $FCRcvPayOther_Footer         = $aData['FCRcvPayOther_Footer']; ?>
                                <?php $FCAmtShipClose_Footer        = $aData['FCAmtShipClose_Footer']; ?>
                                <?php $FCAmtSystem_Footer           = $aData['FCAmtSystem_Footer']; ?>
                                <?php $FCSvnCashIn_Footer           = $aData['FCSvnCashIn_Footer']; ?>
                                <?php $FCSvnCashOut_Footer          = $aData['FCSvnCashOut_Footer']; ?>

                                <tr class="xCNTrFooter">    
                                    <td colspan="3" class="text-center xCNRptSumFooter" ><?php echo $aDataTextRef['tRptTotalFooter']; ?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCSvnCashIn_Footer,2);?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCSvnCashOut_Footer,2);?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCMnyShot_Footer*(-1),2);?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCMnyOver_Footer,2);?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCKbnAmtCash_Footer,2);?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCRcvPayCash_Footer,2);?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCKbnAmtCredit_Footer,2);?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCRcvPayCredit_Footer,2);?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCKbnAmtVouchers_Footer,2);?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCRcvPayVouchers_Footer,2);?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCKbnAmtCoupon_Footer,2);?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCRcvPayCoupon_Footer,2);?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCKbnAmtChque_Footer,2);?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCRcvPayChque_Footer,2);?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCKbnAmtPromptpay_Footer,2);?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCRcvPayPromptpay_Footer,2);?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCKbnAmtOther_Footer,2);?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCRcvPayOther_Footer,2);?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCAmtShipClose_Footer,2);?></td>
                                    <td class="text-right xCNRptDetail" style="width:5%; font-weight: bold;"><?=number_format($FCAmtSystem_Footer,2);?></td>
                                </tr>

                    <?php 
                            } 
                    ?>
                     <?php   }else{ 
                            ?>
                        <tr>
                            <td  colspan="17"  class="text-center xCNRptColumnFooter"   ><?php echo $aDataTextRef['tRptNoData']; ?></td>
                        </tr>
                    <?php   
                    }
                    ?>
                    </tbody>
                </table>
            </div>

            <?php if( ((isset($aDataFilter['tCashierCodeFrom']) && !empty($aDataFilter['tCashierCodeFrom'])) && (isset($aDataFilter['tCashierCodeTo']) && !empty($aDataFilter['tCashierCodeTo'])))
                      || ((isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo'])))
                    ) : ?>
            <div class="xCNRptFilterTitle">
                <div class="text-left">
                    <label class="xCNTextConsOth"><?=$aDataTextRef['tRptConditionInReport'];?></label>
                </div>
            </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล ลูกค้า ============================ -->
            <?php if ((isset($aDataFilter['tCashierCodeFrom']) && !empty($aDataFilter['tCashierCodeFrom'])) && (isset($aDataFilter['tCashierCodeTo']) && !empty($aDataFilter['tCashierCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstFrom'].' : </span>'.$aDataFilter['tCashierNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstTo'].' : </span>'.$aDataFilter['tCashierNameTo'];?></label>
                    </div>
                </div>
            <?php endif; ?>    
            <?php if (isset($aDataFilter['tCashierCodeSelect']) && !empty($aDataFilter['tCashierCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstFrom']; ?> : </span> <?php echo ($aDataFilter['bCashierStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tCashierNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>  

            <!-- ============================ ฟิวเตอร์ข้อมูล จุดขาย ============================ -->
            <?php if ((isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosFrom'].' : </span>'.$aDataFilter['tPosCodeFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosTo'].' : </span>'.$aDataFilter['tPosCodeTo'];?></label>
                    </div>
                </div>
            <?php endif; ?> 
            <?php if (isset($aDataFilter['tPosCodeSelect']) && !empty($aDataFilter['tPosCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosFrom']; ?> : </span> <?php echo ($aDataFilter['bPosStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tPosCodeSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>             
        
        </div>
        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <?php if ($aDataReport["aPagination"]["nTotalPage"] > 0): ?>
                            <label class="xCNRptLabel"><?php echo $aDataReport["aPagination"]["nDisplayPage"] . ' / ' . $aDataReport["aPagination"]["nTotalPage"]; ?></label>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        var oFilterLabel = $('.report-filter .text-left label:first-child');
        var nMaxWidth = 0;
        oFilterLabel.each(function(index){
            var nLabelWidth = $(this).outerWidth();
            if(nLabelWidth > nMaxWidth){
                nMaxWidth = nLabelWidth;
            }
        });
        $('.report-filter .text-left label:first-child').width(nMaxWidth + 50);
    });
</script>













