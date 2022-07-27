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
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom']; ?> : </span> <?php echo $aDataFilter['tDocDateFrom']; ?></label>
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo']; ?> : </span> <?php echo $aDataFilter['tDocDateTo']; ?></label>
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
                            "dataSource" => $this->dataStore("RptCardBalance"),
                            "showFooter" => $bShowFooter,
                            "cssClass" => array(
                                "table" => "table table-bordered",
                                "th" => "xCNRptColumnHeader",
                                "td" => "xCNRptDetail",
                                "tf"=>"xCNRptSumFooter",
                            ),
                            "headers" => array(
                                array(
                                    "$aDataTextRef[tRPC8TBCardStatus]" => array(
                                        "class" => "xCNRptColumnHeader",
                                        "style" => "text-align:center",
                                        "rowSpan" => 2
                                    ),
                                    "$aDataTextRef[tRPC8TBCardBalance]" => array(
                                        "class" => "xCNRptColumnHeader",
                                        "style" => "text-align:center",
                                        "colSpan" => 2
                                    ),
                                    "$aDataTextRef[tRPC8TBCardInputOutputUpdate]" => array(
                                        "class" => "xCNRptColumnHeader",
                                        "style" => "text-align:center",
                                        "colSpan" => 2
                                    ),
                                    "$aDataTextRef[tRPC8TBCardSale]" => array(
                                        "class" => "xCNRptColumnHeader",
                                        "style" => "text-align:center",
                                        "colSpan" => 2
                                    ),
                                    "$aDataTextRef[tRPC8TBCardReturn]" => array(
                                        "class" => "xCNRptColumnHeader",
                                        "style" => "text-align:center",
                                        "colSpan" => 2
                                    ),
                                    "$aDataTextRef[tRPC8TBCardSpending]" => array(
                                        "class" => "xCNRptColumnHeader",
                                        "style" => "text-align:center",
                                        "colSpan" => 2
                                    ),
                                    "$aDataTextRef[tRPC8TBCardExpValue]" => array(
                                        "class" => "xCNRptColumnHeader",
                                        "style" => "text-align:center",
                                        "colSpan" => 2
                                    ),
                                )
                            ),
                            "columns" => array(
                                'FTCrdStaActiveText' => array(
                                    "label" => $aDataTextRef['tRPC8TBCardStatus'],
                                    /*"formatValue"   => function($tValue, $aData) use ($aDataTextRef){
                                        if($tValue == 1 || $tValue == 2 || $tValue == 3){
                                            return $aDataTextRef['tRPC8TBCardCheckStaActive'.$tValue];
                                        }else{
                                            return $aDataTextRef['tReportInvalidSta'];
                                        }
                                    },*/
                                    "footerText" => $bShowFooter ? $aDataTextRef['tRPCTBFooterSumAll'] : '', 
                                    "cssStyle" => array(
                                        "th" => "display:none",
                                    )        
                                ),
                                'FNCrdBalanceQty' => array(
                                    "label" => $aDataTextRef['tRPC8TBQty'],
                                    "type" => "number",
                                    "decimals" => 0,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right",
                                        "td"    => "text-align:right"
                                    ),
                                ),
                                'FCCrdBalanceValue' => array(
                                    "label" => $aDataTextRef['tRPC8TBValue'],
                                    "type" => "number",
                                    "decimals" => 2,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right",
                                        "td"    => "text-align:right"
                                    ),
                                ),
                                'FNCrdInOutAdjQty' => array(
                                    "label" => $aDataTextRef['tRPC8TBQty'],
                                    "type" => "number",
                                    "decimals" => 0,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right",
                                        "td"    => "text-align:right"
                                    ),
                                ),            
                                'FCCrdInOutAdjValue' => array(
                                    "label" => $aDataTextRef['tRPC8TBValue'],
                                    "type" => "number",
                                    "decimals" => 2,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right",
                                        "td"    => "text-align:right"
                                    ),
                                ),
                                'FNCrdSaleQty' => array(
                                    "label" => $aDataTextRef['tRPC8TBQty'],
                                    "type" => "number",
                                    "decimals" => 0,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right",
                                        "td"    => "text-align:right"
                                    ),
                                ),            
                                'FCCrdSaleValue' => array(
                                    "label" => $aDataTextRef['tRPC8TBValue'],
                                    "type" => "number",
                                    "decimals" => 2,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right",
                                        "td"    => "text-align:right"
                                    ),
                                ),
                                'FNCrdRetQty' => array(
                                    "label" => $aDataTextRef['tRPC8TBQty'],
                                    "type" => "number",
                                    "decimals" => 0,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right",
                                        "td"    => "text-align:right"
                                    ),
                                ),            
                                'FNCrdRetValue' => array(
                                    "label" => $aDataTextRef['tRPC8TBValue'],
                                    "type" => "number",
                                    "decimals" => 2,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right",
                                        "td"    => "text-align:right"
                                    ),
                                ),'FNCrdSpendQty' => array(
                                    "label" => $aDataTextRef['tRPC8TBQty'],
                                    "type" => "number",
                                    "decimals" => 0,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right",
                                        "td"    => "text-align:right"
                                    ),
                                ),            
                                'FCCrdSpendValue' => array(
                                    "label" => $aDataTextRef['tRPC8TBValue'],
                                    "type" => "number",
                                    "decimals" => 2,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right",
                                        "td"    => "text-align:right"
                                    ),
                                ),
                                'FNCrdExpireQty' => array(
                                    "label" => $aDataTextRef['tRPC8TBQty'],
                                    "type" => "number",
                                    "decimals" => 0,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right",
                                        "td"    => "text-align:right"
                                    ),
                                ),            
                                'FCCrdExpireValue' => array(
                                    "label" => $aDataTextRef['tRPC8TBValue'],
                                    "type" => "number",
                                    "decimals" => 2,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right",
                                        "td"    => "text-align:right"
                                    ),
                                )
                            )
                        ));
                    ?>
                <?php } else { ?>
                    <table class="table">
                    <thead>
						<tr>
                            <th class="text-center xCNRptColumnHeader" rowspan="2"><?php echo $aDataTextRef['tRPC8TBCardStatus']; ?></th>
                            <th class="text-center xCNRptColumnHeader" colspan="2"><?php echo $aDataTextRef['tRPC8TBCardBalance']; ?></th>
                            <th class="text-center xCNRptColumnHeader" colspan="2"><?php echo $aDataTextRef['tRPC8TBCardInputOutputUpdate']; ?></th>
                            <th class="text-center xCNRptColumnHeader" colspan="2"><?php echo $aDataTextRef['tRPC8TBCardSale']; ?></th>
                            <th class="text-center xCNRptColumnHeader" colspan="2"><?php echo $aDataTextRef['tRPC8TBCardReturn']; ?></th>
                            <th class="text-center xCNRptColumnHeader" colspan="2"><?php echo $aDataTextRef['tRPC8TBCardSpending']; ?></th>
                            <th class="text-center xCNRptColumnHeader" colspan="2"><?php echo $aDataTextRef['tRPC8TBCardExpValue']; ?></th>
                        </tr>
						<tr>
                            <th style="display:none" class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBQty']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBValue']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBQty']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBValue']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBQty']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBValue']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBQty']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBValue']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBQty']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBValue']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBQty']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBValue']; ?></th>		
                        </tr>
		            </thead>
                        <tbody>
                            <tr>
                                <td class='text-center xCNRptDetail' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php } ?>
            </div>

            <?php if ($bIsLastPage) { // Display Last Page ?>        
                <div class="xCNRptFilterTitle">
                    <label><u><?php echo $aDataTextRef['tRptConditionInReport']; ?></u></label>
                </div>
                <?php if ((isset($aDataFilter['tStaCardFrom']) && !empty($aDataFilter['tStaCardFrom'])) && (isset($aDataFilter['tStaCardTo']) && !empty($aDataFilter['tStaCardTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล สถานะบัตร ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCStaCrdFrom']; ?> : </span> <?php echo $aDataFilter['tCrdStaNameFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCStaCrdTo']; ?> : </span> <?php echo $aDataFilter['tCrdStaNameTo']; ?></label>
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