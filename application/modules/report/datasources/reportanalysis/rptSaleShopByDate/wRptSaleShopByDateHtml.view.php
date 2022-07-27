<?php

use \koolreport\widgets\koolphp\Table;

$nCurrentPage = $this->params['nCurrentPage'];
$nAllPage = $this->params['nAllPage'];
$aDataTextRef = $this->params['aDataTextRef'];
$aDataFilter = $this->params['aFilterReport'];
$aDataReport = $this->params['aDataReturn'];
$aCompanyInfo = $this->params['aCompanyInfo'];
$nOptDecimalShow = $this->params['nOptDecimalShow'];
$aSumDataReport = $this->params['aDataReturn']['aDataSumFooterReport'];
?>

<style>
    /*แนวนอน*/
    @media print{@page {size: landscape}} 
    /*แนวตั้ง*/
    /*@media print{@page {size: portrait}}*/
</style>

<div id="odvRptSaleShopByDateHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <!--  Create By Witsarut (Bell) แก้ไขเรื่องที่อยู่ และ Fillter -->
                    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>

                        <div class="text-left">
                            <label class="xCNRptLabel"><?php echo $aCompanyInfo['FTCmpName']; ?></label>
                        </div>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') { // ที่อยู่แบบแยก ?>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?=$aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Village'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi']; ?></label>
                            </div>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?=$aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode']; ?></label>
                            </div>
                        <?php } ?>


                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') { // ที่อยู่แบบรวม ?>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?=$aCompanyInfo['FTAddV2Desc1'];?></label>
                            </div>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?=$aCompanyInfo['FTAddV2Desc2'];?></label>
                            </div>
                        <?php } ?>

                        <div class="text-left">
                            <label class="xCNRptLabel"><?=$aDataTextRef['tRptTel'] . $aCompanyInfo['FTCmpTel'];?> <?=$aDataTextRef['tRptFaxNo'] . $aCompanyInfo['FTCmpFax'];?></label>
                        </div>
                        <div class="text-left">
                            <label class="xCNRptLabel"><?=$aDataTextRef['tRptBranch'] . $aCompanyInfo['FTBchName'];?></label>
                        </div>

                    <?php } ?>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 report-filter">
                    <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptBchFrom'] . ' ' . $aDataFilter['tBchNameFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptBchTo'] . ' ' . $aDataFilter['tBchNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ((isset($aDataFilter['tShopCodeFrom']) && !empty($aDataFilter['tShopCodeFrom'])) && (isset($aDataFilter['tShopCodeTo']) && !empty($aDataFilter['tShopCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptShopFrom'] . ' ' . $aDataFilter['tShopNameFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptShopTo'] . ' ' . $aDataFilter['tShopNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้าง report ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptDateFrom'] . ' ' . $aDataFilter['tDocDateFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptDateTo'] . ' ' . $aDataFilter['tDocDateTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tRptTimePrint'] . ' ' . date('H:i:s'); ?></label>
                    </div>
                </div>
            </div>
        </div>

        <div class="xCNContentReport">
            <div id="odvTableKoolReport" class="table-responsive">
                <?php if (isset($aDataReport['rtCode']) && !empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == '1') { ?>
                    <?php 
                        $bShowFooter = false;
                        if(($aDataReport['rnCurrentPage'] == $aDataReport['rnAllPage'])) {
                            $bShowFooter = true;
                        } 
                    ?>
                    <?php
                        Table::create(array(
                            "dataSource" => $this->dataStore("RptSaleShopByDate"),
                            "cssClass" => array(
                                "table" => "table table-bordered",
                            ),
                            "showFooter" => $bShowFooter,
                            "headers" => array(
                                array(
                                    "$aDataTextRef[tRPA1TBBarchCode]" => array(
                                        "style" => "text-align:center",
                                        "rowSpan" => 2
                                    ),
                                    "$aDataTextRef[tRPA1TBBarchName]" => array(
                                        "style" => "text-align:center",
                                        "rowSpan" => 2
                                    ),
                                    "$aDataTextRef[tRPA1TBDocDate]" => array(
                                        "style" => "text-align:center",
                                        "rowSpan" => 2
                                    ),
                                    "$aDataTextRef[tRPA1TBShopCode]" => array(
                                        "style" => "text-align:center",
                                        "rowSpan" => 2
                                    ),
                                    "$aDataTextRef[tRPA1TBShopName]" => array(
                                        "style" => "text-align:center",
                                        "rowSpan" => 2
                                    ),
                                    "$aDataTextRef[tRPA1TBAmount]" => array(
                                        "style" => "text-align:center",
                                        "colSpan" => 3
                                    ),
                                )
                            ),
                            "columns" => array(
                                'rtBchCode' => array(
                                    "cssStyle"=>array(
                                        "th" => "display:none",
                                    ),
                                ),
                                'rtBchName' => array(
                                    "cssStyle" => array(
                                        "th" => "display:none",
                                    ),
                                ),
                                'rtTxnDocDate' => array(
                                    "cssStyle"=>array(
                                        "th" => "display:none",
                                    ),
                                ),
                                'rtShpCode' => array(
                                    "cssStyle"=>array(
                                        "th" => "display:none",
                                    ),
                                ),
                                'rtShpName' => array(
                                    "footerText" => $bShowFooter ? $aDataTextRef['tRPA1TBTotalAllSale'] : '',
                                    "cssStyle" => array(
                                        "th" => "display:none"
                                    ),
                                ),
                                'rcTxnSaleVal' => array(
                                    "label" => $aDataTextRef['tRPA1TBSale'],
                                    "type" => "number",
                                    "decimals" => 2,
                                    "footer" => '',
                                    "footerText" => $bShowFooter ? number_format($aSumDataReport[0]['rcTxnSaleVal'], 2) : '',
                                    "cssStyle" => "text-align:right",
                                ),
                                'rcTxnCancelSaleVal' => array(
                                    "label" => $aDataTextRef['tRPA1TBCancelSale'],
                                    "type" => "number",
                                    "decimals" => 2,
                                    "footer" => '',
                                    "footerText" => $bShowFooter ? number_format($aSumDataReport[0]['rcTxnCancelSaleVal'], 2) : '',
                                    "cssStyle" => "text-align:right",
                                ),
                                'rcTotalSale' => array(
                                    "label" => $aDataTextRef['tRPA1TBTotalSale'],
                                    "type" => "number",
                                    "decimals"  => 2,
                                    "footer" => '',
                                    "footerText" => $bShowFooter ? number_format($aSumDataReport[0]['rcTotalSale'], 2) : '',
                                    "cssStyle" => "text-align:right",
                                )
                            ),
                            "cssClass" => array(
                                "th" => "xCNReportTBHeard",
                                "td" => "xCNReportTBData"
                            ),
                            "removeDuplicate" => array("rtBchCode","rtBchName","rtTxnDocDate")
                        ));
                    ?>
                <?php } else { ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="text-align:center" rowspan="2"><?php echo $aDataTextRef['tRPA1TBBarchCode']; ?></th>
                                <th style="text-align:center" rowspan="2"><?php echo $aDataTextRef['tRPA1TBBarchName']; ?></th>
                                <th style="text-align:center" rowspan="2"><?php echo $aDataTextRef['tRPA1TBDocDate']; ?></th>
                                <th style="text-align:center" rowspan="2"><?php echo $aDataTextRef['tRPA1TBShopCode']; ?></th>
                                <th style="text-align:center" rowspan="2"><?php echo $aDataTextRef['tRPA1TBShopName']; ?></th>
                                <th style="text-align:center" colspan="3"><?php echo $aDataTextRef['tRPA1TBAmount']; ?></th>
                            </tr>
                            <tr>
                                <th style="display:none" class="xCNReportTBHeard"></th>
                                <th style="display:none" class="xCNReportTBHeard"></th>
                                <th style="display:none" class="xCNReportTBHeard"></th>
                                <th style="display:none" class="xCNReportTBHeard"></th>
                                <th style="display:none" class="xCNReportTBHeard"></th>
                                <th style="text-align:right" class="xCNReportTBHeard"><?php echo $aDataTextRef['tRPA1TBSale']; ?></th>
                                <th style="text-align:right" class="xCNReportTBHeard"><?php echo $aDataTextRef['tRPA1TBCancelSale']; ?></th>
                                <th style="text-align:right" class="xCNReportTBHeard"><?php echo $aDataTextRef['tRPA1TBTotalSale']; ?></th>			
                            </tr>
		                </thead>
                        <tbody>
                            <tr>
                                <td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php }?>
            </div>
        </div>

        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptLabel"><?php echo $nCurrentPage . ' / ' . $nAllPage; ?></label>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        var oFilterLabel = $('.report-filter .text-left label:first-child');
        var nMaxWidth = 0;
        oFilterLabel.each(function(index) {
            var nLabelWidth = $(this).outerWidth();
            if (nLabelWidth > nMaxWidth) {
                nMaxWidth = nLabelWidth;
            }
        });
        $('.report-filter .text-left label:first-child').width(nMaxWidth + 50);
    });
</script>