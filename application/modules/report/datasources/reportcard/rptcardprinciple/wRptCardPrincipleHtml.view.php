<?php

use \koolreport\widgets\koolphp\Table;

$nCurrentPage    = $this->params['nCurrentPage'];
$nAllPage        = $this->params['nAllPage'];
$aDataTextRef    = $this->params['aDataTextRef'];
$aDataFilter     = $this->params['aFilterReport'];
$aDataReport     = $this->params['aDataReturn'];
$aCompanyInfo    = $this->params['aCompanyInfo'];
$nOptDecimalShow = $this->params['nOptDecimalShow'];
$aSumDataReport = $this->params['aSumDataReport'];

$bIsLastPage = ($nAllPage == $nCurrentPage);
?>

<style>
    /*แนวนอน*/
    @media print{@page {size: landscape}} 
    /*แนวตั้ง*/
    /*@media print{@page {size: portrait}}*/
</style>

<div id="odvRptTopUpHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">

            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <!--  Create By Witsarut (Bell) แก้ไขเรื่องที่อยู่ และ Fillter -->
                    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>

                        <div class="text-left">
                            <label class="xCNRptCompany"><?=$aCompanyInfo['FTCmpName'];?></label>
                        </div>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') {; // ที่อยู่แบบแยก ?>
                            <div class="text-left xCNRptAddress">
                                <label>
                                    <?=$aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Village'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi'];?>
                                    <?=$aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode'];?>
                                </label>
                            </div>
                        <?php }?>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') {; // ที่อยู่แบบรวม ?>
                            <div class="text-left xCNRptAddress">
                                <label>
                                    <?=$aCompanyInfo['FTAddV2Desc1'];?>
                                    <?=$aCompanyInfo['FTAddV2Desc2'];?>
                                </label>
                            </div>
                        <?php }?>

                        <div class="text-left xCNRptAddress">
                            <label><?=$aDataTextRef['tRptTel'] . $aCompanyInfo['FTCmpTel'];?> <?=$aDataTextRef['tRptFaxNo'] . $aCompanyInfo['FTCmpFax'];?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?=$aDataTextRef['tRptBranch'] . $aCompanyInfo['FTBchName'];?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptTaxNo'] . ' : ' . $aCompanyInfo['FTAddTaxNo'] ?></label>
                        </div>
                    <?php }?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>
                    <div class="report-filter"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptDataPrint"><?php echo $aDataTextRef['tRptDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tRptTimePrint'] . ' ' . date('H:i:s'); ?></label>
                    </div>
                </div>
            </div>
        </div>

        <div class="xCNContentReport">
            <div id="odvTableKoolReport" class="table-responsive">
                <?php if (isset($aDataReport['rtCode']) && !empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == '1') {?>
                    <?php 
                        $bShowFooter = false;
                        if(($aDataReport['rnCurrentPage'] == $aDataReport['rnAllPage'])) {
                            $bShowFooter = true;
                        } 
                    ?>
                    <?php
                            Table::create(array(
                            "dataSource"    => $this->dataStore("RptCardPrinciple"),
                            "showFooter"    => $bShowFooter,
                            "cssClass" => array(
                                "table" => "table table-bordered",
                                "th" => "xCNRptColumnHeader",
                                "td" => "xCNRptDetail",
                                "tf" => "xCNRptSumFooter"
                            ),
                            "columns"       => array(
                                'FTTxnYear'         => array(
                                    "label"         => $aDataTextRef['tRPC10TBCardTxnYear'],
                                    "cssStyle"      => array(
                                        "th" => "text-align:center",
                                        "td" => "text-align:center"
                                    ), 
                                ),
                                'FTCtyName'         => array(
                                    "label"         => $aDataTextRef['tRPC10TBCardTypeName'],
                                    "footerText"    => $bShowFooter ? $aDataTextRef['tRPCTBFooterSumAll'] : '', 
                                    "cssStyle"      => "text-align:left"
                                ),
                                'FNTxnCountCard'    => array(
                                    "label"         => $aDataTextRef['tRPC10TBCardTxnCountCard'],
                                    "type"          => "number",
                                    "decimals"      => 0,
                                    "footer"        => '',
                                    "footerText"    => $bShowFooter ? number_format(@$aSumDataReport[0]['FNTxnCountCard'], 0) : '',
                                    "cssStyle"      => "text-align:right"
                                ),
                                'FCCrdValue'        => array(
                                    "label"         => $aDataTextRef['tRPC10TBCardValue'],
                                    "type"          => "number",
                                    "decimals"      => 2,
                                    "footer"        => '',
                                    "footerText"    => $bShowFooter ?  number_format(@$aSumDataReport[0]['FCCrdValue'], 2) : '',
                                    "cssStyle"      => "text-align:right"
                                ),
                            )
                        ));

                    ?>
                <?php } else {?>
                    <table class="table">
                        <thead>
                            <th nowrap class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC10TBCardTxnYear']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC10TBCardTypeName']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC10TBCardTxnCountCard']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC10TBCardValue']; ?></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class='text-center xCNRptDetail' colspan='100%'><?php echo language('report/report/report', 'tCMNNotFoundData'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php }?>
            </div>

            <?php if ($bIsLastPage) { // Display Last Page ?>        
                <div class="xCNRptFilterTitle">
                    <label><u><?php echo $aDataTextRef['tRptConditionInReport']; ?></u></label>
                </div>
                <?php if ((isset($aDataFilter['tRptYearCode']) && !empty($aDataFilter['tRptYearCode'])) && (isset($aDataFilter['tRptYearCodeTo']) && !empty($aDataFilter['tRptYearCodeTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล ปี ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCYearFrom']; ?> : </span> <?php echo $aDataFilter['tRptYearCode']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCYearTo']; ?> : </span> <?php echo $aDataFilter['tRptYearCodeTo']; ?></label>
                        </div>
                    </div>
                <?php }?>

                <?php if ((isset($aDataFilter['tRptCardTypeCode']) && !empty($aDataFilter['tRptCardTypeCode'])) && (isset($aDataFilter['tRptCardTypeCodeTo']) && !empty($aDataFilter['tRptCardTypeCodeTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทบัตร ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTypeFrom']; ?> : </span> <?php echo $aDataFilter['tRptCardTypeName']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTypeTo']; ?> : </span> <?php echo $aDataFilter['tRptCardTypeNameTo']; ?></label>
                        </div>
                    </div>
                <?php }?>
            <?php } ?>

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
    $(document).ready(function(){
        var tFoot = $('tfoot').html();
        $('tfoot').remove();
        $('tbody').append(tFoot);
    });
</script>