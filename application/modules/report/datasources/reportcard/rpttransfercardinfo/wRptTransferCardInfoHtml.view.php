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
                        <?php } ?>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') {; // ที่อยู่แบบรวม ?>
                            <div class="text-left xCNRptAddress">
                                <label>
                                    <?=$aCompanyInfo['FTAddV2Desc1'];?>
                                    <?=$aCompanyInfo['FTAddV2Desc2'];?>
                                </label>
                            </div>
                        <?php }?>

                        <div class="text-left xCNRptAddress">
                            <label><?=$aDataTextRef['tRptAddrTel'] . $aCompanyInfo['FTCmpTel'];?> <?=$aDataTextRef['tRptAddrFax'] . $aCompanyInfo['FTCmpFax'];?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?=$aDataTextRef['tRptAddrBranch'] . $aCompanyInfo['FTBchName'];?></label>
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
                            "dataSource"    => $this->dataStore("RptTransferCardInfo"),
                            "cssClass"      => array(
                                "table"     => "table table-bordered",
                                "th" => "xCNRptColumnHeader",
                                "td" => "xCNRptDetail",
                                "tf"=>"xCNRptSumFooter",
                            ),
                            "columns"       => array(
                                'rtRowID'       => array(
                                    "label"     => $aDataTextRef['tRPC3TBRowNuber'],
                                    "cssStyle" => "text-align:left"
                                ),
                                'FDDocDate'     => array(
                                    "label"     => $aDataTextRef['tRPC3TBDocDate'],
                                    "cssStyle" => array(
                                        "th" => "text-align:center",
                                        "td" => "text-align:center"
                                    ),
                                    "formatValue"=>function($value, $row){
                                        return empty($value) ? '' : date("Y-m-d H:i:s", strtotime($value));
                                    },
                                ),
                                'FTCvdOldCode'  => array(
                                    "label"     => $aDataTextRef['tRPC3TBOldCardCode'],
                                    "cssStyle" => "text-align:left"
                                ),
                                'FTOldCtyName'  => array(
                                    "label"     => $aDataTextRef['tRPC3TBOldCardType'],
                                    "cssStyle" => "text-align:left"
                                ),
                                'FTCvdNewCode'  => array(
                                    "label"     => $aDataTextRef['tRPC3TBNewCardCode'],
                                    "cssStyle" => "text-align:left"
                                ),
                                'FTNewCtyName'  => array(
                                    "label"     => $aDataTextRef['tRPC3TBNewCardType'],
                                    "cssStyle" => "text-align:left"
                                ),
                                'FTCrdName'     => array(
                                    "label"     => $aDataTextRef['tRPC3TBCardName'],
                                    "cssStyle" => "text-align:left"
                                ),
                                'FTUsrName'  => array(
                                    "label"         => $aDataTextRef['tRPCOperator'],
                                    "cssStyle" => "text-align:left"
                                ),
                                'FCOldCrdValue' => array(
                                    "label"     => $aDataTextRef['tRPC3TBOldCrdValue'],
                                    "type"      => "number",
                                    "decimals"  => 2,
                                    "cssStyle" => array(
                                        "th" => "text-align:right",
                                        "td" => "text-align:right"
                                    ),
                                ),
                                'FCNewCrdValue' => array(
                                    "label"     => $aDataTextRef['tRPC3TBNewCrdValue'],
                                    "type"      => "number",
                                    "decimals"  => 2,
                                    "cssStyle" => array(
                                        "th" => "text-align:right",
                                        "td" => "text-align:right"
                                    ),
                                ),
                            )
                        ));
                    ?>
                <?php } else {?>
                    <table class="table">
                    <thead>
						<tr>
                            <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC3TBRowNuber']; ?></th>
                            <th class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC3TBDocDate']; ?></th>
                            <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC3TBOldCardCode']; ?></th>
                            <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC3TBOldCardType']; ?></th>
                            <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC3TBNewCardCode']; ?></th>
                            <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC3TBNewCardType']; ?></th>
                            <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC3TBCardName']; ?></th>
                            <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPCOperator']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC3TBOldCrdValue']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC3TBNewCrdValue']; ?></th>			
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
                <?php if ((isset($aDataFilter['tCardTypeCodeOldFrom']) && !empty($aDataFilter['tCardTypeCodeOldFrom'])) && (isset($aDataFilter['tCardTypeCodeOldTo']) && !empty($aDataFilter['tCardTypeCodeOldTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทบัตรเดิม ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTypeOldFrom']; ?> : </span> <?php echo $aDataFilter['tCardTypeNameOldFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTypeOldTo']; ?> : </span> <?php echo $aDataFilter['tCardTypeNameOldTo']; ?></label>
                        </div>
                    </div>
                <?php }?>

                <?php if ((isset($aDataFilter['tCardTypeCodeNewFrom']) && !empty($aDataFilter['tCardTypeCodeNewFrom'])) && (isset($aDataFilter['tCardTypeCodeNewTo']) && !empty($aDataFilter['tCardTypeCodeNewTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทบัตรใหม่ ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTypeNewFrom']; ?> : </span> <?php echo $aDataFilter['tCardTypeNameNewFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTypeNewTo']; ?> : </span> <?php echo $aDataFilter['tCardTypeNameNewTo']; ?></label>
                        </div>
                    </div>
                <?php }?>

                <?php if ((isset($aDataFilter['tCardCodeOldFrom']) && !empty($aDataFilter['tCardCodeOldFrom'])) && (isset($aDataFilter['tCardCodeOldTo']) && !empty($aDataFilter['tCardCodeOldTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล เลขขัตรเดิม ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdOldFrom']; ?> : </span> <?php echo $aDataFilter['tCardNameOldFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdOldTo']; ?> : </span> <?php echo $aDataFilter['tCardNameOldTo']; ?></label>
                        </div>
                    </div>
                <?php }?>

                <?php if ((isset($aDataFilter['tCardCodeNewFrom']) && !empty($aDataFilter['tCardCodeNewFrom'])) && (isset($aDataFilter['tCardCodeNewTo']) && !empty($aDataFilter['tCardCodeNewTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล เลขขัตรใหม่ ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdNewFrom']; ?> : </span> <?php echo $aDataFilter['tCardNameNewFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdNewTo']; ?> : </span> <?php echo $aDataFilter['tCardNameNewTo']; ?></label>
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