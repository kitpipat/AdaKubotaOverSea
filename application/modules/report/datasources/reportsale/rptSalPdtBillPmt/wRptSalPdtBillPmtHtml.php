<?php
$aDataFilterReport = $aDataViewRpt['aDataFilter'];
$aDataTextRef = $aDataViewRpt['aDataTextRef'];
$aDataReport = $aDataViewRpt['aDataReport'];
$nTotalPage = $aDataReport['aPagination']['nTotalPage'];
$nDisplayPage = $aDataReport['aPagination']['nDisplayPage'];

// print_r($aCompanyInfo);
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
        border-bottom: 1px solid black !important;

        /* background-color: #CFE2F3 !important; */
    }

    .table>tbody>tr.xCNTrSubFooter {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
        /* background-color: #CFE2F3 !important; */
    }

    .table>tbody>tr.xCNTrFooter {
        /* background-color: #CFE2F3 !important; */
        /* border-bottom : 6px double black !important; */
        /* border-top: dashed 1px #333 !important; */
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .table tbody tr.xCNHeaderGroup,
    .table>tbody>tr.xCNHeaderGroup>td {
        /* color: #232C3D !important; */
        font-size: 18px !important;
        font-weight: 600;
    }

    .table>tbody>tr.xCNHeaderGroup>td:nth-child(4),
    .table>tbody>tr.xCNHeaderGroup>td:nth-child(5) {
        text-align: right;
    }

    /*แนวนอน*/
    @media print {
        @page {
            size: A4 landscape;
            margin: 5mm 5mm 5mm 5mm;
        }
    }

    /*แนวตั้ง*/
    /* @media print{@page {size: portrait}} */
</style>

<div id="odvRptSaleByProductHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <!-- <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>
                </div>
            </div> -->
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>

                        <div class="text-left">
                            <label class="xCNRptCompany"><?= $aCompanyInfo['FTCmpName'] ?></label>
                        </div>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') { // ที่อยู่แบบแยก 
                        ?>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi'] ?>
                                    <?= $aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode'] ?></label>
                            </div>
                        <?php } ?>


                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') { // ที่อยู่แบบรวม 
                        ?>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTAddV2Desc1'] ?></label>
                            </div>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTAddV2Desc2'] ?></label>
                            </div>
                        <?php } ?>

                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptTaxSalePosTel'] . $aCompanyInfo['FTCmpTel'] ?>
                                <?= $aDataTextRef['tRptTaxSalePosFax'] . $aCompanyInfo['FTCmpFax'] ?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptTaxSalePosBch'] . $aCompanyInfo['FTBchName'] ?></label>
                        </div>

                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptTaxSalePosTaxId'] . $aCompanyInfo['FTAddTaxNo'] ?></label>
                        </div>

                    <?php } ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>
                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) : ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label class="xCNRptLabel"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom'] . ' : </span>' . date('d/m/Y', strtotime($aDataFilter['tDocDateFrom'])); ?></label>
                                    <label class="xCNRptLabel"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo'] . ' : </span>' . date('d/m/Y', strtotime($aDataFilter['tDocDateTo'])); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label class="xCNRptLabel"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom'] . ' : </span>' . $aDataFilter['tBchNameFrom']; ?></label>
                                    <label class="xCNRptLabel"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo'] . ' : </span>' . $aDataFilter['tBchNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>
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
            <div id="odvRptTableAdvance" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:5%;border-bottom: dashed 1px #333 !important;"><?php echo language('report/report/report', 'tRptDocBill') ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:5%;border-bottom: dashed 1px #333 !important;"><?php echo language('report/report/report', 'tRptDocRef') ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:5%;border-bottom: dashed 1px #333 !important;"><?php echo language('report/report/report', 'tRptSalPdtBillPmtSOKADSNumber') ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:5%;border-bottom: dashed 1px #333 !important;"><?php echo language('report/report/report', 'tChannel') ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:5%;border-bottom: dashed 1px #333 !important;"><?php echo language('report/report/report', 'tRptCustCode') ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:5%;border-bottom: dashed 1px #333 !important;"><?php echo language('report/report/report', 'tRptCustName') ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:5%;border-bottom: dashed 1px #333 !important;"><?php echo language('report/report/report', 'tRptDate') ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="vertical-align : middle;text-align:right; width:5%;" rowspan="2"><?php echo language('report/report/report', 'tRptSales') ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="vertical-align : middle;text-align:right; width:5%;" rowspan="2"><?php echo language('report/report/report', 'tRptDiscount') ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="vertical-align : middle;text-align:right; width:5%;" rowspan="2"><?php echo language('report/report/report', 'tRptSalPdtBillSalDis') ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="vertical-align : middle;text-align:right; width:5%;" rowspan="2"><?php echo language('report/report/report', 'tRptSalPdtBillPmtNamePmt') ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="vertical-align : middle;text-align:right; width:5%;" rowspan="2"><?php echo language('report/report/report', 'tRptGrandSale') ?></th>
                        </tr>
                        <tr style="border-bottom : 1px solid black !important;">
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:5%;"><?php echo language('report/report/report', 'tRptSalPdtBillPmtPdtCode') ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:5%;"><?php echo language('report/report/report', 'tRptPdtName') ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:5%;"></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:5%;"><?php echo language('report/report/report', 'tRptQty') ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:5%;"><?php echo language('report/report/report', 'tRptPrice') ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:5%;" colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>
                            <?php
                            $paFooterSumData1 = 0;
                            $paFooterSumData2 = 0;
                            $paFooterSumData3 = 0;
                            $nSeq = "";
                            $tGroupping = "";
                            $tPosCodeSub = "";
                            $nCountBch = 0;
                            $nPosCodeOld = "";
                            $tPdtCodeOld = "";
                            $tPdtAmtOld  = "";
                            ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) { ?>
                                <?php
                                // Step 1 เตรียม Parameter สำหรับการ Groupping
                                // $tXrcNet = 0;
                                // $tDocNo   = $aValue["FTXshDocNo"];
                                // $tPosCode = $aValue["FTPosCode"];
                                // $tBchCode = $aValue["FTBchCode"];
                                // $tBchName = $aValue["FTBchName"];
                                // $tPosRegNo = $aValue["FTPosRegNo"];
                                $tDocDate = date("d/m/Y", strtotime($aValue['FDXshDocDate']));
                                $nRowPartID = $aValue["PartID"];
                                // $nGroupMember = $aValue['FNRptGroupMember'];

                                // $nBchXshAmt =  number_format($aValue["FCXshAmt_SUMBCH"], $nOptDecimalShow);
                                // $nBchXshVat =  number_format($aValue["FCXshVat_SUMBCH"], $nOptDecimalShow);
                                // $nBchXshAmtNV =  number_format($aValue["FCXshAmtNV_SUMBCH"], $nOptDecimalShow);
                                // $nBchXshGrandTotal =  number_format($aValue["FCXshGrandTotal_SUMBCH"], $nOptDecimalShow);

                                // $nPosXshAmt =  number_format($aValue["FCXshAmt_SUMPOS"], $nOptDecimalShow);
                                // $nPosXshVat =  number_format($aValue["FCXshVat_SUMPOS"], $nOptDecimalShow);
                                // $nPosXshAmtNV =  number_format($aValue["FCXshAmtNV_SUMPOS"], $nOptDecimalShow);
                                // $nPosXshGrandTotal =  number_format($aValue["FCXshGrandTotal_SUMPOS"], $nOptDecimalShow);
                                ?>

                                <?php
                                $aCstName = explode(" ", $aValue['FTCstName']);
                                $nCstName = count($aCstName);
                                switch($nCstName) {
                                    case 2 : {
                                        if(isset($aCstName[0]) && isset($aCstName[1])) {
                                            $tCstName = $aCstName[0];
                                        }
                                        break;
                                    }
                                    case 3 : {
                                        if(isset($aCstName[0]) && isset($aCstName[1])) {
                                            $tCstName = $aCstName[0].' '.$aCstName[1];
                                        }
                                        break;
                                    }
                                    case 4 : {
                                        if(isset($aCstName[0]) && isset($aCstName[1]) && isset($aCstName[2])) {
                                            $tCstName = $aCstName[0].' '.$aCstName[1].' '.$aCstName[2];
                                        }
                                        break;
                                    }
                                    default : {
                                        $tCstName = $aValue['FTCstName'];
                                    }
                                }
                                
                                $aGrouppingData = array($aValue["FTXshDocNo"], $aValue["FTXshRefInt"], $aValue["FTXshSOKADS"], $aValue["FTChnName"], $aValue["FTCstCode"], $tCstName, $tDocDate);

                                if ($tGroupping != $aValue["FTXshDocNo"]) {
                                    if ($nRowPartID == 1) {
                                        $tPdtCodeOld = "";
                                        $tPdtAmtOld  = "";
                                        echo "<tr>";
                                        for ($i = 0; $i < count($aGrouppingData); $i++) {
                                            if ($aGrouppingData[$i] == $aGrouppingData[0]) {
                                                echo "<td class='xCNRptGrouPing  text-left' style='padding: 5px;'>" . $aGrouppingData[$i] . "</td>";
                                            } else {
                                                echo "<td class='xCNRptGrouPing text-left'  style='padding: 5px;'>" . $aGrouppingData[$i] . "</td>";
                                            }
                                        }
                                        echo "</tr>";
                                    }
                                    $tGroupping = $aValue["FTXshDocNo"];
                                    $nSeq = 1;
                                    $nXshDisPnt = $aValue['FCXshDisPnt'];
                                    $nXshDis =  $aValue["FCXshDis"] + ($nXshDisPnt);
                                    $nXdtDisPmt = $aValue['FCXdtDisPmt'];
                                    $nXshVatable = $aValue['FCXshVatable'];
                                    $nVat = $aValue['FCXshVat'];
                                    $nXshRnd = $aValue['FCXshRnd'];
                                    $nXshGrand = $aValue['FCXshGrand'];
                                }
                                ?>


                                <?php 
                                    if($aValue["FNType"] == '2'){
                                        $i = intval($aValue['PartID']) - 1;
                                        if ( $tPdtAmtOld == "" ){
                                            $tPdtAmtOld  = ( $aValue['FCXsdAmt'] + ($aValue['FCXsdDis']) + ($aValue['FCXdtDisPmt']) );
                                        }else{
                                            $tPdtAmtOld  = ( $tPdtAmtOld + ($aValue['FCXsdDis']) + ($aValue['FCXdtDisPmt']) );
                                        }

                                        $tWithVate = ($aValue['FTXsdVatType'] == "1")? ' V' : ''; 
                                        if( $aValue['FTRowMax'] > 1 && ( $aValue['FTRowByPdt'] == $aValue['FTRowMax'] ) ){
                                            $cNetSum    = number_format($tPdtAmtOld, $nOptDecimalShow).$tWithVate;
                                        }else if( $aValue['FTRowMax'] == '1' ){
                                            $cNetSum    = number_format($tPdtAmtOld, $nOptDecimalShow).$tWithVate;
                                        }else{
                                            $cNetSum    = '';
                                        }

                                        if( $aValue['FTRowByPdt'] == $aValue['FTRowMax'] ){
                                            $tPdtAmtOld = '';
                                        }

                                        if( $tPdtCodeOld == $aValue['FTPdtCode'] ){
                                ?>
                                            <tr>
                                                <td colspan="8"></td>
                                                <td class="text-right xCNRptDetail"><?php echo number_format($aValue['FCXsdDis'], $nOptDecimalShow); ?></td>
                                                <td class="text-right xCNRptDetail"><?php echo number_format($aValue['FCXdtDisPmt'], $nOptDecimalShow); ?></td>
                                                <td class="text-right xCNRptDetail"><?php echo $aValue['FTPmhName']; ?></td>
                                                <td class="text-right xCNRptDetail"><?php echo $cNetSum; ?></td>
                                            </tr>
                                <?php   }else{ ?>
                                    <tr>
                                        <td class="text-left xCNRptDetail"><?php echo $aValue['FTRowDisplay'] . ' ' . $aValue['FTPdtCode']; ?></td>
                                        <td class="text-left xCNRptDetail" colspan="2"><?php echo $aValue['FTPdtName']; ?></td>
                                        <td class="text-left xCNRptDetail"><?php echo number_format($aValue["FCXsdQty"], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptDetail"><?php echo number_format($aValue['FCXsdSetPrice'], $nOptDecimalShow); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right xCNRptDetail"><?php echo number_format($aValue['FCXsdAmt'], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptDetail"><?php echo number_format($aValue['FCXsdDis'], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptDetail"><?php echo number_format($aValue['FCXdtDisPmt'], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptDetail"><?php echo $aValue['FTPmhName']; ?></td>
                                        <td class="text-right xCNRptDetail"><?php echo $cNetSum; ?></td>
                                    </tr>
                                <?php
                                        }
                                        $tPdtCodeOld = $aValue['FTPdtCode'];
                                        
                                    } 
                                ?>
                                <?php if ($aValue["FNType"] == '3') {
                                    $tFCXsdNet_SubTotal = $aValue['FCXsdAmt_SubTotal'] + ($aValue['FCXsdDis_SubTotal']) + ($aValue['FCXdtDisPmt_SubTotal']);
                                ?>
                                    <tr>
                                        <td class="text-left xCNRptGrouPing" style="padding: 5px;" colspan="7"><?php echo $aValue['FTRcvName'] . ': ' . number_format($aValue["FCXrcNet"], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue['FCXsdAmt_SubTotal'], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue['FCXsdDis_SubTotal'], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue['FCXdtDisPmt_SubTotal'], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptGrouPing" colspan="2"><?php echo number_format(/*$aValue['FCXsdNet_SubTotal']*/$tFCXsdNet_SubTotal, $nOptDecimalShow); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left xCNRptGrouPing"></td>
                                        <td class="text-left xCNRptGrouPing"></td>
                                        <td class="text-right xCNRptGrouPing"></td>
                                        <td class="text-right xCNRptGrouPing" colspan="4"><?php echo language('report/report/report', 'tRptPdtHaveTaxPerTax') ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo language('report/report/report', 'tRptSalPdtBillPmtPdtDiscount') ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($nXshDis, $nOptDecimalShow); ?></td>
                                        <td class="text-left xCNRptGrouPing"></td>
                                        <td class="text-right xCNRptGrouPing"></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($tFCXsdNet_SubTotal + $nXshDis, $nOptDecimalShow); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left xCNRptGrouPing"></td>
                                        <td class="text-left xCNRptGrouPing"></td>
                                        <td class="text-right xCNRptGrouPing"></td>
                                        <td class="text-right xCNRptGrouPing" colspan="4"></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo language('report/report/report', 'tRptSalPdtBillPmtDisPnt') ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($nXshDisPnt, $nOptDecimalShow); ?></td>

                                        <td class="text-left xCNRptGrouPing"></td>
                                        <td class="text-right xCNRptGrouPing"></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format(($tFCXsdNet_SubTotal + $nXshDis) - $nXshDisPnt, $nOptDecimalShow); ?></td>
                                    </tr>
                                    <tr style="border-bottom: dashed 1px #ccc !important;">
                                        <td class="text-left xCNRptGrouPing"></td>
                                        <td class="text-left xCNRptGrouPing"></td>
                                        <td class="text-right xCNRptGrouPing"></td>
                                        <td class="text-right xCNRptGrouPing" colspan="4"><?php echo number_format($nXshVatable, $nOptDecimalShow) . '/' . number_format($nVat, $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo language('report/report/report', 'tRptRndVal') ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($nXshRnd, $nOptDecimalShow); ?></td>
                                        <td class="text-left xCNRptGrouPing"></td>
                                        <td class="text-left xCNRptGrouPing"></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($nXshGrand, $nOptDecimalShow); ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            <?php
                            if ($nTotalPage == $nDisplayPage) {
                                $nXshDis_SumFooter      = $aValue["FCXshDis_SumFooter"];
                                $nXshDisPnt_SumFooter   = $aValue['FCXshDisPnt_SumFooter'];
                                $tXsdNet_SumFooter      = $aValue['FCXsdAmt_SumFooter'] + ($aValue['FCXsdDis_SumFooter']) + ($aValue['FCXdtDisPmt_SumFooter']);
                            ?>
                                <tr style="border-top: solid 1px #111 !important;">
                                    <td class="text-left xCNRptGrouPing" style="padding: 5px;" colspan="7"><?php echo language('report/report/report', 'tRptTotalFooter') ?></td>
                                    <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue['FCXsdAmt_SumFooter'], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue['FCXsdDis_SumFooter'], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue['FCXdtDisPmt_SumFooter'], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptGrouPing" colspan="4"><?php echo number_format($tXsdNet_SumFooter, $nOptDecimalShow); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-left xCNRptGrouPing"></td>
                                    <td class="text-left xCNRptGrouPing"></td>
                                    <td class="text-right xCNRptGrouPing"></td>
                                    <td class="text-right xCNRptGrouPing" colspan="4"><?php echo language('report/report/report', 'tRptPdtHaveTaxPerTax') ?></td>
                                    <td class="text-right xCNRptGrouPing"><?php echo language('report/report/report', 'tRptSalPdtBillPmtPdtDiscount') ?></td>
                                    <td class="text-right xCNRptGrouPing"><?php echo number_format($nXshDis_SumFooter, $nOptDecimalShow); ?></td>
                                    <td class="text-left xCNRptGrouPing"></td>
                                    <td class="text-right xCNRptGrouPing"></td>
                                    <td class="text-right xCNRptGrouPing"><?php echo number_format($tXsdNet_SumFooter + $nXshDis_SumFooter, $nOptDecimalShow); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-left xCNRptGrouPing"></td>
                                    <td class="text-left xCNRptGrouPing"></td>
                                    <td class="text-right xCNRptGrouPing"></td>
                                    <td class="text-right xCNRptGrouPing" colspan="4"></td>
                                    <td class="text-right xCNRptGrouPing"><?php echo language('report/report/report', 'tRptSalPdtBillPmtDisPnt') ?></td>
                                    <td class="text-right xCNRptGrouPing"><?php echo number_format($nXshDisPnt_SumFooter, $nOptDecimalShow); ?></td>
                                    <td class="text-left xCNRptGrouPing"></td>
                                    <td class="text-right xCNRptGrouPing"></td>
                                    <td class="text-right xCNRptGrouPing"><?php echo number_format(($tXsdNet_SumFooter + $nXshDis_SumFooter) - $nXshDisPnt_SumFooter, $nOptDecimalShow); ?></td>
                                </tr>
                                <tr style="border-bottom: solid 1px #111 !important;">
                                    <td class="text-left xCNRptGrouPing"></td>
                                    <td class="text-left xCNRptGrouPing"></td>
                                    <td class="text-right xCNRptGrouPing"></td>
                                    <td class="text-right xCNRptGrouPing" colspan="4"><?php echo number_format($aValue['FCXshVatable_SumFooter'], $nOptDecimalShow) . '/' . number_format($aValue['FCXshVat_SumFooter'], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptGrouPing"><?php echo language('report/report/report', 'tRptRndVal') ?></td>
                                    <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue['FCXshRnd_SumFooter'], $nOptDecimalShow); ?></td>
                                    <td class="text-left xCNRptGrouPing"></td>
                                    <td class="text-left xCNRptGrouPing"></td>
                                    <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue['FCXshGrand_SumFooter'], $nOptDecimalShow); ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptTaxSalePosNoData']; ?></td>
                            </tr>
                        <?php }; ?>
                    </tbody>
                </table>
            </div>

            <!--เเสดงหน้า-->
            <div class="xCNRptFilterTitle">
                <div class="text-right">
                    <label><?= language('report/report/report', 'tRptPage') ?> <?= $aDataReport["aPagination"]["nDisplayPage"] ?> <?= language('report/report/report', 'tRptTo') ?> <?= $aDataReport["aPagination"]["nTotalPage"] ?> </label>
                </div>
            </div>

            <div class="xCNRptFilterTitle">
                <div class="text-left">
                    <label class="xCNTextConsOth"><?= $aDataTextRef['tRptConditionInReport']; ?></label>
                </div>
            </div>

            <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
            <?php if (isset($aDataFilter['tBchCodeSelect']) && !empty($aDataFilter['tBchCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo ($aDataFilter['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tBchNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มธุรกิจ ============================ -->
            <?php if ((isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantFrom'] . ' : </span>' . $aDataFilter['tMerNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantTo'] . ' : </span>' . $aDataFilter['tMerNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['tMerCodeSelect']) && !empty($aDataFilter['tMerCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerFrom']; ?> : </span> <?php echo ($aDataFilter['bMerStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tMerNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
            <?php if ((isset($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeFrom'])) && (isset($aDataFilter['tShpCodeTo']) && !empty($aDataFilter['tShpCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopFrom'] . ' : </span>' . $aDataFilter['tShpNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopTo'] . ' : </span>' . $aDataFilter['tShpNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['tShpCodeSelect']) && !empty($aDataFilter['tShpCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopFrom']; ?> : </span> <?php echo ($aDataFilter['bShpStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tShpNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล จุดขาย ============================ -->
            <?php if ((isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosFrom'] . ' : </span>' . $aDataFilter['tPosCodeFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosTo'] . ' : </span>' . $aDataFilter['tPosCodeTo']; ?></label>
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

            <!-- ============================ ฟิวเตอร์ข้อมูล ช่องทางการขาย ============================ -->
            <?php if ((isset($aDataFilter['tChannelCodeFrom']) && !empty($aDataFilter['tChannelCodeFrom'])) && (isset($aDataFilter['tChannelCodeTo']) && !empty($aDataFilter['tChannelCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptFilterChannelFrom'] . ' : </span>' . $aDataFilter['tChannelNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptFilterChannelTo'] . ' : </span>' . $aDataFilter['tChannelNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทจุดขาย ============================ -->
            <?php if (isset($aDataFilter['tPosType'])) { ?>

                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTypeName'] . ' : </span>' . $aDataTextRef['tRptPosType' . $aDataFilter['tPosType']]; ?></label>
                    </div>
                </div>

            <?php } ?>

        </div>
        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <?php if ($aDataReport["aPagination"]["nTotalPage"] > 0) : ?>
                            <label class="xCNRptLabel"><?php echo $aDataReport["aPagination"]["nDisplayPage"] . ' / ' . $aDataReport["aPagination"]["nTotalPage"]; ?></label>
                        <?php endif; ?>
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