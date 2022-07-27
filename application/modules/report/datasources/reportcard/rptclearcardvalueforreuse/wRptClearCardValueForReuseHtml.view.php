<?php

use \koolreport\widgets\koolphp\Table;

$nCurrentPage = $this->params['nCurrentPage'];
$nAllPage = $this->params['nAllPage'];
$aDataTextRef = $this->params['aDataTextRef'];
$aDataFilter = $this->params['aFilterReport'];
$aDataReport = $this->params['aDataReturn'];
$aCompanyInfo = $this->params['aCompanyInfo'];
$nOptDecimalShow = $this->params['nOptDecimalShow'];

$bIsLastPage = ($nAllPage == $nCurrentPage);
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
                    <div class="report-filter">
                        <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) {?>
                            <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="text-center xCNRptFilter">
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCDateFrom']; ?> : </span> <?php echo $aDataFilter['tDocDateFrom']; ?></label>
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCDateTo']; ?> : </span> <?php echo $aDataFilter['tDocDateTo']; ?></label>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    </div>
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
                            "dataSource" => $this->dataStore("RptClearCardValueForReuse"),
                            "cssClass" => array(
                                "table" => "table table-bordered",
                                "th" => "xCNRptColumnHeader",
                                "td" => "xCNRptDetail"
                            ),
                            "columns" => array(
                                'rtRowID' => array(
                                    "label" => $aDataTextRef['tRPC5TBRowNuber'],
                                ),
                                'FDTxnDocDate' => array(
                                    "label" => $aDataTextRef['tRPC5TBDocDate'],
                                    "cssStyle"  => array(
                                        "th"    => "text-align:center",
                                        "td"    => "text-align:center"
                                    ),
                                    "formatValue" => function($tValue,$aRow){
                                        return empty($tValue) ? '' : date('Y-m-d H:i:s', strtotime($tValue));
                                    }
                                ),
                                'FTCrdCode' => array(
                                    "label" => $aDataTextRef['tRPC5TBCardCode'],
                                ),
                                'FTCtyName' => array(
                                    "label" => $aDataTextRef['tRPC5TBCardType'],
                                ),
                                'FTCrdName' => array(
                                    "label" => $aDataTextRef['tRPC5TBCardName'],
                                ),
                                'FCTxnValue' => array(
                                    "label" => $aDataTextRef['tRPC5TBCardTxnValue'],
                                    "type" => "number",
                                    "decimals" => $nOptDecimalShow,
                                    "cssStyle"  => array(
                                        "th"    => "text-align:right",
                                        "td"    => "text-align:right"
                                    ),
                                ),
                            )
                        ));
                    ?>
                <?php } else { ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC5TBRowNuber']; ?></th>
                                <th class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC5TBDocDate']; ?></th>
                                <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC5TBCardCode']; ?></th>
                                <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC5TBCardType']; ?></th>
                                <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC5TBCardName']; ?></th>
                                <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC5TBCardTxnValue']; ?></th>			
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class='text-center xCNRptDetail' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php }?>
            </div>

            <?php if ($bIsLastPage) { // Display Last Page ?>        
                <div class="xCNRptFilterTitle">
                    <label><u><?php echo $aDataTextRef['tRptConditionInReport']; ?></u></label>
                </div>
                <?php if ((isset($aDataFilter['tCardTypeCodeFrom']) && !empty($aDataFilter['tCardTypeCodeFrom'])) && (isset($aDataFilter['tCardTypeCodeTo']) && !empty($aDataFilter['tCardTypeCodeTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทบัตร ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTypeFrom']; ?> : </span> <?php echo $aDataFilter['tCardTypeNameFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTypeTo']; ?> : </span> <?php echo $aDataFilter['tCardTypeNameTo']; ?></label>
                        </div>
                    </div>
                <?php }?>

                <?php if ((isset($aDataFilter['tCardCodeFrom']) && !empty($aDataFilter['tCardCodeFrom'])) && (isset($aDataFilter['tCardCodeTo']) && !empty($aDataFilter['tCardCodeTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล หมายเลขบัตร ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdFrom']; ?> : </span> <?php echo $aDataFilter['tCardNameFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTo']; ?> : </span> <?php echo $aDataFilter['tCardNameTo']; ?></label>
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