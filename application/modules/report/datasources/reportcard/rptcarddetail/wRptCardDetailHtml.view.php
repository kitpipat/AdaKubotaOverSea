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
    @media print {
        @page {
            size: landscape
        }
    }

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
                            <label class="xCNRptCompany"><?= $aCompanyInfo['FTCmpName']; ?></label>
                        </div>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') {; // ที่อยู่แบบแยก 
                                ?>
                            <div class="text-left xCNRptAddress">
                                <label>
                                    <?= $aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Village'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi']; ?>
                                    <?= $aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode']; ?>
                                </label>
                            </div>
                        <?php } ?>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') {; // ที่อยู่แบบรวม 
                                ?>
                            <div class="text-left xCNRptAddress">
                                <label>
                                    <?= $aCompanyInfo['FTAddV2Desc1']; ?>
                                    <?= $aCompanyInfo['FTAddV2Desc2']; ?>
                                </label>
                            </div>
                        <?php } ?>

                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptTel'] . $aCompanyInfo['FTCmpTel']; ?> <?= $aDataTextRef['tRptFaxNo'] . $aCompanyInfo['FTCmpFax']; ?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptBranch'] . $aCompanyInfo['FTBchName']; ?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptTaxNo'] . ' : ' . $aCompanyInfo['FTAddTaxNo'] ?></label>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-12 col-lg-4">
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
                <?php if (isset($aDataReport['rtCode']) && !empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == '1') { ?>
                    <?php
                    $bShowFooter = false;
                    if (($aDataReport['rnCurrentPage'] == $aDataReport['rnAllPage'])) {
                        $bShowFooter = true;
                    }
                    ?>
                    <?php
                        Table::create(array(
                            "dataSource" => $this->dataStore("RptCardDetail"),
                            "showFooter" => $bShowFooter,
                            "cssClass" => array(
                                "table" => "table table-bordered",
                                "th" => "xCNRptColumnHeader",
                                "td" => "xCNRptDetail",
                                "tf" => "xCNRptSumFooter"
                            ),
                            "columns"       => array(
                                'FTCrdCode'         => array(
                                    "label"         => $aDataTextRef['tRPC11TBCardCode'],
                                    "cssStyle"      => array("th" => "text-align:left", "td" => "text-align:left"),
                                ),
                                'FTCrdName'         => array(
                                    "label"         => $aDataTextRef['tRPC11TBCardName'],
                                    "cssStyle"      => array("th" => "text-align:left", "td" => "text-align:left"),
                                ),
                                'FTCrdStaType'      => array(
                                    "label"         => $aDataTextRef['tRPC11TBCardFormat'],
                                    "formatValue"   => function ($tValue) {
                                        $aDataTextRef   = $this->params['aDataTextRef'];
                                        if ($tValue == '1') {
                                            return $aDataTextRef['tRPCCardDetailStaType1'];
                                        } else if ($tValue == '2') {
                                            return $aDataTextRef['tRPCCardDetailStaType2'];
                                        } else {
                                            return '-';
                                        }
                                    },
                                    "cssStyle"      => array("th" => "text-align:left", "td" => "text-align:left"),
                                ),
                                'FTCtyName'         => array(
                                    "label"         => $aDataTextRef['tRPC11TBCardType'],
                                    "cssStyle"      => array("th" => "text-align:left", "td" => "text-align:left"),
                                ),
                                'FDCrdStartDate'    => array(
                                    "label"         => $aDataTextRef['tRPC11TBCardDateStart'],
                                    "cssStyle"      => "text-align:center"
                                ),
                                'FDCrdExpireDate'   => array(
                                    "label"         => $aDataTextRef['tRPC11TBCardDateExpire'],
                                    "cssStyle"      => "text-align:center"
                                ),
                                'FTCrdStaActive'    => array(
                                    "label"         => $aDataTextRef['tRPC11TBCardStatus'],
                                    "cssStyle"      => array("th" => "text-align:left", "td" => "text-align:left"),
                                    "formatValue"   => function ($tValue) {
                                        $aDataTextRef   = $this->params['aDataTextRef'];
                                        switch ($tValue) {
                                            case '1':
                                                return $aDataTextRef['tRPCCardDetailStaActive1'];
                                                break;
                                            case '2':
                                                return $aDataTextRef['tRPCCardDetailStaActive2'];
                                                break;
                                            case '3':
                                                return $aDataTextRef['tRPCCardDetailStaActive3'];
                                                break;
                                        }
                                    }
                                ),
                                'FNCrdStaExpr'      => array(
                                    "label"         => $aDataTextRef['tRPC11TBCardStatusExpire'],
                                    "cssStyle"      => array("th" => "text-align:left", "td" => "text-align:left"),
                                    "footerText"    => $bShowFooter ? $aDataTextRef['tRPCTBFooterSumAll'] : '',
                                    "formatValue"   => function ($tValue) {
                                        $aDataTextRef   = $this->params['aDataTextRef'];
                                        switch ($tValue) {
                                            case '1':
                                                return $aDataTextRef['tRPCCardDetailStaExpr1'];
                                                break;
                                            case '2':
                                                return $aDataTextRef['tRPCCardDetailStaExpr2'];
                                                break;
                                        }
                                    }
                                ),
                                'FCCrdValue'        => array(
                                    "label"         => $aDataTextRef['tRPC11TBCardBalance'],
                                    "type"          => "number",
                                    "cssStyle"      => "text-align:right",
                                    "decimals"      => 2,
                                    "footer"        => '',
                                    "footerText"    => $bShowFooter ? number_format(@$aSumDataReport[0]['FCCrdValue'], 2) : '',
                                ),
                            )
                        ));

                        ?>
                        <?php } else { ?>
                            <table class="table">
                                <thead>
                                    <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC11TBCardCode']; ?></th>
                                    <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC11TBCardName']; ?></th>
                                    <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC11TBCardFormat']; ?></th>
                                    <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC11TBCardType']; ?></th>
                                    <th nowrap class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC11TBCardDateStart']; ?></th>
                                    <th nowrap class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC11TBCardDateExpire']; ?></th>
                                    <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC11TBCardStatus']; ?></th>
                                    <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC11TBCardStatusExpire']; ?></th>
                                    <th nowrap class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC11TBCardBalance']; ?></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class='text-center xCNRptDetail' colspan='100%'><?php echo language('report/report/report', 'tCMNNotFoundData'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php } ?>
            </div>

            <?php if ($bIsLastPage) { // Display Last Page 
                ?>
                <div class="xCNRptFilterTitle">
                    <label><u><?php echo $aDataTextRef['tRptConditionInReport']; ?></u></label>
                </div>
                <?php if ((isset($aDataFilter['tRptCardTypeCodeFrom']) && !empty($aDataFilter['tRptCardTypeCodeFrom'])) && (isset($aDataFilter['tRptCardTypeCodeTo']) && !empty($aDataFilter['tRptCardTypeCodeTo']))) { ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทบัตร ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTypeFrom']; ?> : </span> <?php echo $aDataFilter['tRptCardTypeNameFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTypeTo']; ?> : </span> <?php echo $aDataFilter['tRptCardTypeNameTo']; ?></label>
                        </div>
                    </div>
                <?php } ?>

                <?php if ((isset($aDataFilter['tRptCardCode']) && !empty($aDataFilter['tRptCardCode'])) && (isset($aDataFilter['tRptCardCodeTo']) && !empty($aDataFilter['tRptCardCodeTo']))) { ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล หมายเลขบัตร ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCardCodeFrom']; ?> : </span> <?php echo $aDataFilter['tRptCardName']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCardCodeTo']; ?> : </span> <?php echo $aDataFilter['tRptCardNameTo']; ?></label>
                        </div>
                    </div>
                <?php } ?>

                <?php if ((isset($aDataFilter['ocmRptStaCardFrom']) && !empty($aDataFilter['ocmRptStaCardFrom'])) && (isset($aDataFilter['ocmRptStaCardTo']) && !empty($aDataFilter['ocmRptStaCardTo']))) { ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล สถานะบัตร ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCStaCrdFrom']; ?> : </span> <?php echo $aDataFilter['tRptStaCardFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCStaCrdTo']; ?> : </span> <?php echo $aDataFilter['tRptStaCardTo']; ?></label>
                        </div>
                    </div>
                <?php } ?>

                <?php if ((isset($aDataFilter['tRptDateStartFrom']) && !empty($aDataFilter['tRptDateStartFrom'])) && (isset($aDataFilter['tRptDateStartTo']) && !empty($aDataFilter['tRptDateStartTo']))) { ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล จากวันที่เริ่มต้นใช้งาน ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateStarFrom']; ?> : </span> <?php echo $aDataFilter['tRptDateStartFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateStarTo']; ?> : </span> <?php echo $aDataFilter['tRptDateStartTo']; ?></label>
                        </div>
                    </div>
                <?php } ?>

                <?php if ((isset($aDataFilter['tRptDateExpireFrom']) && !empty($aDataFilter['tRptDateExpireFrom'])) && (isset($aDataFilter['tRptDateExpireTo']) && !empty($aDataFilter['tRptDateExpireTo']))) { ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล จากวันที่หมดอายุ ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateExpireFrom']; ?> : </span> <?php echo $aDataFilter['tRptDateExpireFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateExpireTo']; ?> : </span> <?php echo $aDataFilter['tRptDateExpireTo']; ?></label>
                        </div>
                    </div>
                <?php } ?>
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