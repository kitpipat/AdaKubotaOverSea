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
                    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>

                        <div class="text-left">
                            <label class="xCNRptCompany"><?=$aCompanyInfo['FTCmpName'];?></label>
                        </div>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') { // ที่อยู่แบบแยก ?>
                            <div class="text-left xCNRptAddress">
                                <label>
                                    <?=$aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Village'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi'];?>
                                    <?=$aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode'];?>
                                </label>
                            </div>
                        <?php } ?>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') { // ที่อยู่แบบรวม ?>
                            <div class="text-left xCNRptAddress">
                                <label>
                                    <?=$aCompanyInfo['FTAddV2Desc1'];?>
                                    <?=$aCompanyInfo['FTAddV2Desc2'];?>
                                </label>
                            </div>
                        <?php } ?>

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
                            "dataSource" => $this->dataStore("RptCheckCardUseInfo"),
                            "showFooter" => $bShowFooter,
                            "cssClass" => array(
                                "table" => "table table-bordered",
                                "th" => "xCNRptColumnHeader",
                                "td" => "xCNRptDetail",
                                "tf" => "xCNRptSumFooter"
                            ),
                            "columns" => array(
                                'rtCrdCode' => array(
                                    "label" => $aDataTextRef['tRPC13TBCardCode'],
                                    "cssStyle" => array("th" => "text-align:left","td" => "text-align:left"),
                                ),
                                'rtCtyName' => array(
                                    "label" => $aDataTextRef['tRPC13TBCardTypeName'],
                                    "cssStyle" => array("th" => "text-align:left","td" => "text-align:left"),
                                    "formatValue" => function($tValue,$aData){
                                        $aExplodeCtyName = explode(";",$tValue);
                                        return $aExplodeCtyName[1];
                                    }
                                ),
                                'rtCrdHolderID' => array(
                                    "label" => $aDataTextRef['tRPC13TBCardHolderID'],
                                    "cssStyle" => array("th" => "text-align:left","td" => "text-align:left"),
                                    "formatValue" => function($tValue,$aData){
                                        $aExplodeCrdHolderID = explode(";",$tValue);
                                        return $aExplodeCrdHolderID[1];
                                    }
                                ),
                                'rtCrdName' => array(
                                    "label" => $aDataTextRef['tRPC13TBCardName'],
                                    "cssStyle" => array("th" => "text-align:left","td" => "text-align:left"),
                                    "formatValue" => function($tValue,$aData){
                                        $aExplodeCrdName = explode(";",$tValue);
                                        return $aExplodeCrdName[1];
                                    }
                                ),
                                'rtCrdStaActive' => array(
                                    "label" => $aDataTextRef['tRPC13TBCardStaActive'],
                                    "cssStyle" => array("th" => "text-align:left","td" => "text-align:left"),
                                    "formatValue" => function($tValue){
                                        $aExplodeCrdStaActive = explode(";",$tValue);
                                        $aDataTextRef = $this->params['aDataTextRef'];
                                        switch($aExplodeCrdStaActive[1]){
                                            case '1':
                                                return $aDataTextRef['tRPC13CardDetailStaActive1'];
                                            break;
                                            case '2':
                                                return $aDataTextRef['tRPC13CardDetailStaActive2'];
                                            break;
                                            case '3':
                                                return $aDataTextRef['tRPC13CardDetailStaActive3'];
                                            break;
                                            default:
                                                return $aDataTextRef['tRPC13CardDetailStaActive'];
                                        }
                                    }
                                ),
                                'rtDptName' => array(
                                    "label" => $aDataTextRef['tRPC13TBDptName'],
                                    "cssStyle" => "text-align:center",
                                    "formatValue" => function($tValue){
                                        $aExplodeDptName = explode(";",$tValue);
                                        return $aExplodeDptName[1];
                                    }
                                ),
                                'rtTxnPosCode' => array(
                                    "label" => $aDataTextRef['tRPC13TBCardPosCode'],
                                    "cssStyle" => array("th" => "text-align:left","td" => "text-align:left"),
                                    "formatValue" => function($tValue, $aRow){
                                        $aExplodeTxnPosCode = explode(";",$tValue);
                                        if($aRow['FNLngID'] == 1){
                                            return $aExplodeTxnPosCode[0];
                                        }else{
                                            return $aExplodeTxnPosCode[1];
                                        }
                                    }
                                ),
                                'rtTxnDocNoRef' => array(
                                    "label" => $aDataTextRef['tRPC13TBCardTxnDocNoRef'],
                                    "cssStyle" => array("th" => "text-align:left","td" => "text-align:left"),
                                    "formatValue" => function($tValue){
                                        $aExplodeTxnDocNoRef = explode(";",$tValue);
                                        return $aExplodeTxnDocNoRef[1];
                                    }
                                ),
                                'rtTxnDocTypeName' => array(
                                    "label" => $aDataTextRef['tRPC13TBCardTxnDocTypeName'],
                                    "cssStyle" => array("th" => "text-align:left","td" => "text-align:left"),
                                    "formatValue" => function($tValue){
                                        $aExplodeTxnDocTypeName = explode(";",$tValue);
                                        return $aExplodeTxnDocTypeName[1];
                                    }
                                ),
                                'rtTxnDocCreateBy' => array(
                                    "label" => $aDataTextRef['tRPCOperator'],
                                    "formatValue" => function($tValue,$aRow){
                                        $aExplodeTxtDocOperatorName = explode(";",$tValue);
                                        if($aRow['FNLngID'] == 1){
                                            return $aExplodeTxtDocOperatorName[0];
                                        }else{
                                            return $aExplodeTxtDocOperatorName[1];
                                        }
                                    },
                                    "cssStyle" => array("th" => "text-align:left","td" => "text-align:left"),
                                ),         
                                'rtTxnDocDate' => array(
                                    "label" => $aDataTextRef['tRPC13TBCardTxnDocDate'],
                                    "footerText" => $bShowFooter ? $aDataTextRef['tRPCTBFooterSumAll'] : '', 
                                    "cssStyle" => array("th" => "text-align:left","td" => "text-align:left"),
                                    'formatValue' => function($tDateTime){
                                        return date('Y-m-d H:i:s ',strtotime($tDateTime));
                                    },
                                ),
                                'rtTxnValue' => array(
                                    "label" => $aDataTextRef['tRPC13TBCardTxnValue'],
                                    /*"formatValue"   => function($tValue){
                                        $aExplodeTxnValue   = explode(";",$tValue);
                                        // return number_format($aExplodeTxnValue[1],2);
                                    },*/
                                    //"footerText"=>"$rtTotalTxnValue",

                                    "footer" => 'sum',
                                    "footerText" => $bShowFooter ? number_format(@$aSumDataReport[0]['FCTxnValueSum'], 2) : '',
                                    "type" => "number",
                                    "decimals" => 2,
                                    // "footer"        => "sum",
                                    // "footerText"    => "@value",        
                                    "cssStyle" => array("th" => "text-align:right","td" => "text-align:right"),
                                ),
                                'rtCrdAftTrans' => array(
                                    "label" => $aDataTextRef['tRPC13TBCardTxnCrdAftTrans'],
                                    "formatValue" => function($tValue){
                                        $aExplodeCrdAftTrans = explode(";",$tValue);
                                        if($aExplodeCrdAftTrans[1] == '' || $aExplodeCrdAftTrans[1] == null){
                                            return number_format(0,2);
                                        }else{
                                            $aExplodeCrdAftTrans = explode(";",$tValue);
                                            return number_format($aExplodeCrdAftTrans[1], 2);
                                        }
                                    },
                                    "cssStyle" => array("th" => "text-align:right","td" => "text-align:right"),
                                ),
                                'rtCrdBalance' => array(
                                    "label" => $aDataTextRef['tRPC13TBCardBalance'],
                                    "formatValue" => function($tValue){
                                        $aExplodeCrdBalance = explode(";",$tValue);
                                        if($aExplodeCrdBalance[1] != ''){
                                            return number_format($aExplodeCrdBalance[1], 2);
                                        }else{
                                            return number_format(0 , 2);
                                        }
                                    },
                                    "cssStyle" => array("th" => "text-align:right","td" => "text-align:right"),
                                )
                            ),
                            "removeDuplicate" => array('rtCrdCode','rtCtyName','rtCrdHolderID','rtCrdName','rtCrdStaActive','rtDptName','rtCrdBalance')
                        ));

                    ?>
                <?php } else {?>
                    <table class="table">
                        <thead>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC13TBCardCode']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC13TBCardTypeName']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC13TBCardHolderID']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC13TBCardName']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC13TBCardStaActive']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC13TBDptName']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC13TBCardPosCode']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC13TBCardTxnDocNoRef']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC13TBCardTxnDocTypeName']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPCOperator']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC13TBCardTxnDocDate']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC13TBCardTxnValue']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC13TBCardTxnCrdAftTrans']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC13TBCardBalance']; ?></th>
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
                <?php if ((isset($aDataFilter['tRptCardCode']) && !empty($aDataFilter['tRptCardCode'])) && (isset($aDataFilter['tRptCardCodeTo']) && !empty($aDataFilter['tRptCardCodeTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล หมายเลขบัตร ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCardCodeFrom']; ?> : </span> <?php echo $aDataFilter['tRptCardName']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCardCodeTo']; ?> : </span> <?php echo $aDataFilter['tRptCardNameTo']; ?></label>
                        </div>
                    </div>
                <?php }?>

                <?php if ((isset($aDataFilter['tRptEmpCode']) && !empty($aDataFilter['tRptEmpCode'])) && (isset($aDataFilter['tRptEmpCodeTo']) && !empty($aDataFilter['tRptEmpCodeTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล รหัสพนักงาน ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCEmpCodeFrom']; ?> : </span> <?php echo $aDataFilter['tRptEmpName']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCEmpCodeTo']; ?> : </span> <?php echo $aDataFilter['tRptEmpNameTo']; ?></label>
                        </div>
                    </div>
                <?php }?>

                <?php if ((isset($aDataFilter['ocmRptStaCardFrom']) && !empty($aDataFilter['ocmRptStaCardFrom'])) && (isset($aDataFilter['ocmRptStaCardTo']) && !empty($aDataFilter['ocmRptStaCardTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล สถานะบัตร ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCStaCrdFrom']; ?> : </span> <?php echo $aDataFilter['tRptStaCardFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCStaCrdTo']; ?> : </span> <?php echo $aDataFilter['tRptStaCardTo']; ?></label>
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





































