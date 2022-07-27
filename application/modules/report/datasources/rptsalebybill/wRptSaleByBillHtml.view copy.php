<?php

use \koolreport\widgets\koolphp\Table;

$nCurrentPage = $this->params['nCurrentPage'];
$nAllPage = $this->params['nAllPage'];
$aDataTextRef = $this->params['aDataTextRef'];
$aDataFilter = $this->params['aFilterReport'];
$aDataReport = $this->params['aDataReturn'];
$aDataSumFoot = $this->params['aDataSumFoot'];
$aCompanyInfo = $this->params['aCompanyInfo'];
$nOptDecimalShow = $this->params['nOptDecimalShow'];
?>

<style>
    .xCNFooterRpt {
        border-bottom : 7px double #ddd;
    }

    .table thead th, .table>thead>tr>th, .table tbody tr, .table>tbody>tr>td {
        border: 0px transparent !important;
    }

    .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
        border-top: 1px solid black !important;
        border-bottom: 0px transparent !important;
        /*border-bottom : 1px solid black !important;
        background-color: #CFE2F3 !important;*/
    }

    .table>thead:first-child>tr:first-child>td:nth-child(1), .table>thead:first-child>tr:first-child>th:nth-child(1),
    .table>thead:first-child>tr:first-child>td:nth-child(2), .table>thead:first-child>tr:first-child>th:nth-child(2),
    .table>thead:first-child>tr:first-child>td:nth-child(3), .table>thead:first-child>tr:first-child>th:nth-child(3) {
        border-bottom: 1px dashed #ccc !important;
    }

    .table>thead:first-child>tr:last-child>td, .table>thead:first-child>tr:last-child>th {
        /*border-top: 1px solid black !important;*/
        border-bottom : 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
    }
    
    .table>tbody>tr.xCNTrSubFooter{
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
    }

    .table>tbody>tr.xCNTrFooter{
        border-top: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
        border-bottom : 6px double black !important;
    }

    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(3),
    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(4),
    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(5),
    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(6),
    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(7) {
        border: 0px solid black !important;
        border-bottom: 1px dashed #ccc !important;
    }

    .table tbody tr.xCNRptLastGroupTr, .table>tbody>tr.xCNRptLastGroupTr>td {
        border: 0px solid black !important;
        border-bottom: 1px dashed #ccc !important;
    }

    .table tbody tr.xCNRptSumFooterTrTop, .table>tbody>tr.xCNRptSumFooterTrTop>td {
        border: 0px solid black !important;
        border-top: 1px solid black !important;
    }
    .table tbody tr.xCNRptSumFooterTrBottom, .table>tbody>tr.xCNRptSumFooterTrBottom>td {
        border: 0px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .table>tfoot>tr{
        border-top: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
        border-bottom : 6px double black !important;
    }
    /*แนวนอน*/
    /* @media print{@page {size: landscape}} */ 
    /*แนวตั้ง*/
    @media print{@page {size: portrait}}
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
                    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>

                        <div class="text-left">
                            <label class="xCNRptCompany"><?= $aCompanyInfo['FTCmpName'] ?></label>
                        </div>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') { // ที่อยู่แบบแยก  ?>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Village'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi'] ?></label>
                            </div>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode'] ?></label>
                            </div>
                        <?php } ?>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') { // ที่อยู่แบบรวม  ?>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTAddV2Desc1'] ?></label>
                            </div>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTAddV2Desc2'] ?></label>
                            </div>
                        <?php } ?>

                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptTel'] . $aCompanyInfo['FTCmpTel'] ?> <?= $aDataTextRef['tRptFaxNo'] . $aCompanyInfo['FTCmpFax'] ?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?= /*$aDataTextRef['tRptBranch'] .*/ $aCompanyInfo['FTBchName'] ?></label>
                        </div>

                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptTaxNo'] .' : '. $aCompanyInfo['FTAddTaxNo'] ?></label>
                        </div>    
                    <?php } ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 report-filter">
                    <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><?php echo $aDataTextRef['tRptBchFrom'] . ' ' . $aDataFilter['tBchCodeFrom']; ?></label>
                                    <label><?php echo $aDataTextRef['tRptBchTo'] . ' ' . $aDataFilter['tBchCodeTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>

                    <?php if ((isset($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeFrom'])) && (isset($aDataFilter['tShpCodeTo']) && !empty($aDataFilter['tShpCodeTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><?php echo $aDataTextRef['tRptShopFrom'] . ' ' . $aDataFilter['tShpCodeFrom']; ?></label>
                                    <label><?php echo $aDataTextRef['tRptShopTo'] . ' ' . $aDataFilter['tShpCodeTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><?php echo $aDataTextRef['tRptDateFrom'] . ' ' . $aDataFilter['tDocDateFrom']; ?></label>
                                    <label><?php echo $aDataTextRef['tRptDateTo'] . ' ' . $aDataFilter['tDocDateTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 report-filter"></div>
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
                <?php if (isset($aDataReport['rtCode']) && !empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == '1' || true) { ?>
                    <table class="table">
                    <thead>
                        <tr>
                            <th class="text-left xCNRptColumnHeader" width="17%">เลขที่บิล</th>
                            <th class="text-left xCNRptColumnHeader" width="20%">อ้างอิงเอกสาร</th>
                            <th class="text-left xCNRptColumnHeader" width="15%">ลูกค้า</th>
                            <th class="text-left xCNRptColumnHeader" colspan="2" width="20%">วันที่</th>
                            <th class="text-left xCNRptColumnHeader" colspan="3" width="30%"></th>
                        </tr>
                        <tr>
                            <th class="text-left xCNRptColumnHeader">ลำดับ รหัสสินค้า</th>
                            <th class="text-left xCNRptColumnHeader" colspan="2">ชื่อสินค้า</th>
                            <th class="text-left xCNRptColumnHeader">จำนวน</th>
                            <th class="text-right xCNRptColumnHeader">ราคา/หน่วย</th>
                            <th class="text-right xCNRptColumnHeader">ยอดขาย</th>
                            <th class="text-right xCNRptColumnHeader">ส่วนลด</th>
                            <th class="text-right xCNRptColumnHeader">ยอดขายรวม</th>			
                        </tr>
                    </thead>
                        <tbody>
                        <?php for($a=1; $a<=4; $a++) { ?>
                            <tr>
                                <td class="xCNRptGrouPing">S18080001001-0000001</td>
                                <td class="xCNRptGrouPing">K0002154241</td>
                                <td class="xCNRptGrouPing">Prawin Deejung</td>
                                <td class="xCNRptGrouPing" colspan="2">21/08/2018</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php for($b=1; $b<=3; $b++) { ?>
                                <?php 
                                    $tLastPdtList = '';
                                    if($b == 3){
                                        $tLastPdtList = 'xCNRptLastPdtList';
                                    }
                                ?>
                            <tr class="<?php echo $tLastPdtList; ?>">
                                <td class="xCNRptDetail">1 BBMAAJKSLZ</td>
                                <td class="xCNRptDetail" colspan="2">BOSSMAN/ALTJACKET/SHTLGT</td>
                                <td class="xCNRptDetail">1.00 คู่</td>
                                <td class="text-right xCNRptDetail">100.00</td>
                                <td class="text-right xCNRptDetail">100.00</td>
                                <td class="text-right xCNRptDetail">0.00</td>
                                <td class="text-right xCNRptDetail">100.00 V</td>
                            </tr>
                            <?php } ?>

                            <tr>
                                <td class="xCNRptGrouPing" colspan="5">เงินสด : 200.00 บาท</td>
                                <td class="text-right xCNRptGrouPing">100.00</td>
                                <td class="text-right xCNRptGrouPing">0.00</td>
                                <td class="text-right xCNRptGrouPing">100.00</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="xCNRptGrouPing" colspan="2"></td>
                                <td class="xCNRptGrouPing" colspan="2">มูลค่าสินค้ามีภาษี / ภาษี:</td>
                                <td class="text-right xCNRptGrouPing">ยอดปัดเศษ</td>
                                <td class="text-right xCNRptGrouPing">0.00</td>
                                <td class="text-right xCNRptGrouPing">200.00</td>
                            </tr>
                            <tr class="xCNRptLastGroupTr">
                                <td></td>
                                <td colspan="2"></td>
                                <td class="xCNRptGrouPing" colspan="2">186 / 13.08</td>
                                <td class="text-right xCNRptGrouPing">ส่วนลด</td>
                                <td class="text-right xCNRptGrouPing">0.00</td>
                                <td class="text-right xCNRptGrouPing">200.00</td>
                            </tr>
                        <?php } ?>

                            <tr class="xCNRptSumFooterTrTop">
                                <td class="xCNRptGrouPing" colspan="5">รวม</td>
                                <td class="text-right xCNRptGrouPing">100.00</td>
                                <td class="text-right xCNRptGrouPing">0.00</td>
                                <td class="text-right xCNRptGrouPing">100.00</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="xCNRptGrouPing" colspan="2"></td>
                                <td class="xCNRptGrouPing" colspan="2">มูลค่าสินค้ามีภาษี / ภาษี:</td>
                                <td class="text-right xCNRptGrouPing">ยอดปัดเศษ</td>
                                <td class="text-right xCNRptGrouPing">0.00</td>
                                <td class="text-right xCNRptGrouPing">200.00</td>
                            </tr>
                            <tr class="xCNRptSumFooterTrBottom">
                                <td></td>
                                <td colspan="2"></td>
                                <td class="xCNRptGrouPing" colspan="2">186 / 13.08</td>
                                <td class="text-right xCNRptGrouPing">ส่วนลด</td>
                                <td class="text-right xCNRptGrouPing">0.00</td>
                                <td class="text-right xCNRptGrouPing">200.00</td>
                            </tr>  

                            <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData']) || false) { ?>
                                <?php
                                    // Set ตัวแปร Sum - SubFooter
                                    $nSumSubXsdQty = 0;
                                    $cSumSubXsdAmtB4DisChg = 0;
                                    $cSumSubXsdDis = 0;
                                    $cSumSubXsdVat = 0;
                                    $cSumSubXsdNetAfHD = 0;
                                    // Set ตัวแปร SumFooter
                                    $nSumFootXsdQty = 0;
                                    $cSumFootXsdAmtB4DisChg = 0;
                                    $cSumFootXsdDis = 0;
                                    $cSumFootXsdVat = 0;
                                    $cSumFootXsdNetAfHD = 0;
                                ?> 
                                <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) { ?>
                                    <?php
                                        // Step 1 เตรียม Parameter สำหรับการ Groupping
                                        $tRptDocNo = $aValue["FTXshDocNo"];
                                        $tRptDocDate = date('Y-m-d H:i:s', strtotime($aValue["FDCreateOn"]));
                                        $nGroupMember = $aValue["FNRptGroupMember"];
                                        $nRowPartID = $aValue["FNRowPartID"];
                                    ?>
                                    <?php
                                        // Step 2 Groupping data
                                        $aGrouppingData = array($tRptDocNo, $tRptDocDate);
                                        // Parameter
                                        // $nRowPartID = ลำดับตามกลุ่ม
                                        // $aGrouppingData = ข้อมูลสำหรับ Groupping
                                        FCNtHRPTHeadGroupping($nRowPartID, $aGrouppingData);
                                    ?>
                                    <!--  Step 2 แสดงข้อมูลใน TD  -->
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><?php echo @$aValue["FTXsdPdtName"];?></td>
                                        <td class="text-right"><?php echo number_format($aValue["FCXsdQty"], 0);?></td>
                                        <td class="text-right"><?php echo number_format($aValue["FCXsdSetPrice"], $nOptDecimalShow);?></td>
                                        <td class="text-right"><?php echo number_format($aValue["FCXsdAmtB4DisChg"], $nOptDecimalShow);?></td>
                                        <td class="text-right"><?php echo number_format($aValue["FCXsdDis"], $nOptDecimalShow);?></td>
                                        <td class="text-right"><?php echo number_format($aValue["FCXsdVat"], $nOptDecimalShow);?></td>
                                        <td class="text-right"><?php echo number_format($aValue["FCXsdNetAfHD"], $nOptDecimalShow);?></td>
                                    </tr>

                                    <?php
                                        // Step 3 : เตรียม Parameter สำหรับ Summary Sub Footer
                                        $nSumSubXsdQty = number_format($aValue["FCXsdQty_SubTotal"], 0);
                                        $cSumSubXsdAmtB4DisChg  = number_format($aValue["FCXsdAmtB4DisChg_SubTotal"], $nOptDecimalShow);
                                        $cSumSubXsdDis = number_format($aValue["FCXsdDis_SubTotal"], $nOptDecimalShow);
                                        $cSumSubXsdVat = number_format($aValue["FCXsdVat_SubTotal"], $nOptDecimalShow);
                                        $cSumSubXsdNetAfHD = number_format($aValue["FCXsdNetAfHD_SubTotal"], $nOptDecimalShow);

                                        $aSubSumFooter = array($aDataTextRef['tRptTotalSub'],'N','N',$nSumSubXsdQty,'N',$cSumSubXsdAmtB4DisChg,$cSumSubXsdDis,$cSumSubXsdVat,$cSumSubXsdNetAfHD);

                                        // Step 4 : สั่ง Summary SubFooter
                                        /*Parameter
                                        $nGroupMember = จำนวนข้อมูลทั้งหมดในกลุ่ม
                                        $nRowPartID = ลำดับข้อมูลในกลุ่ม
                                        $aSubSumFooter =  ข้อมูล Summary SubFooter*/
                                        FCNtHRPTSumSubFooter($nGroupMember, $nRowPartID, $aSubSumFooter);

                                        // Step 5 เตรียม Parameter สำหรับ SumFooter
                                        $nSumFootXsdQty = number_format($aValue["FCXsdQty_Footer"], 0);
                                        $cSumFootXsdAmtB4DisChg = number_format($aValue["FCXsdAmtB4DisChg_Footer"], $nOptDecimalShow);
                                        $cSumFootXsdDis = number_format($aValue["FCXsdDis_Footer"], $nOptDecimalShow);
                                        $cSumSubXsdVat = number_format($aValue["FCXsdVat_Footer"], $nOptDecimalShow);
                                        $cSumFootXsdNetAfHD = number_format($aValue["FCXsdNetAfHD_Footer"], $nOptDecimalShow);
                                        $paFooterSumData = array($aDataTextRef['tRptTotalFooter'],'N','N',$nSumFootXsdQty,'N',$cSumFootXsdAmtB4DisChg,$cSumFootXsdDis,$cSumSubXsdVat,$cSumFootXsdNetAfHD);
                                    ?>
                                <?php } ;?>
                                <?php
                                    // Step 6 : สั่ง Summary Footer
                                    $nPageNo = $aDataReport["aPagination"]["nDisplayPage"];
                                    $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                                    FCNtHRPTSumFooter($nPageNo, $nTotalPage, $paFooterSumData);
                                ?>
                            <?php }else{ ?>
                                <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo @$aDataTextRef['tRptNoData'];?></td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-left xCNRptColumnHeader" width="17%">เลขที่บิล</th>
                                <th class="text-left xCNRptColumnHeader" width="20%">อ้างอิงเอกสาร</th>
                                <th class="text-left xCNRptColumnHeader" width="15%">ลูกค้า</th>
                                <th class="text-left xCNRptColumnHeader" colspan="2" width="20%">วันที่</th>
                                <th class="text-left xCNRptColumnHeader" colspan="3" width="30%"></th>
                            </tr>
                            <tr>
                                <th class="text-left xCNRptColumnHeader">ลำดับ รหัสสินค้า</th>
                                <th class="text-left xCNRptColumnHeader" colspan="2">ชื่อสินค้า</th>
                                <th class="text-left xCNRptColumnHeader">จำนวน</th>
                                <th class="text-right xCNRptColumnHeader">ราคา/หน่วย</th>
                                <th class="text-right xCNRptColumnHeader">ยอดขาย</th>
                                <th class="text-right xCNRptColumnHeader">ส่วนลด</th>
                                <th class="text-right xCNRptColumnHeader">ยอดขายรวม</th>			
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td></tr>
                        </tbody>
                    </table>
                <?php }; ?>
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
















































