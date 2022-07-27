<?php

    $aDataReport    = $aDataViewRpt['aDataReport'];
    $aDataTextRef   = $aDataViewRpt['aDataTextRef'];
    $aDataFilter    = $aDataViewRpt['aDataFilter'];

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
        border-bottom : 1px solid black !important;
        
        /* background-color: #CFE2F3 !important; */
    }

    .table>tbody>tr.xCNTrSubFooter{
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
        /* background-color: #CFE2F3 !important; */
    }

    .table>tbody>tr.xCNTrFooter{
        /* background-color: #CFE2F3 !important; */
        /* border-bottom : 6px double black !important; */
        /* border-top: dashed 1px #333 !important; */
        border-top: 1px solid black !important;
        border-
         : 1px solid black !important;
    }
    .table tbody tr.xCNHeaderGroup, .table>tbody>tr.xCNHeaderGroup>td {
        /* color: #232C3D !important; */
        font-size: 18px !important;
        font-weight: 600;
    }
    .table>tbody>tr.xCNHeaderGroup>td:nth-child(4), .table>tbody>tr.xCNHeaderGroup>td:nth-child(5) {
        text-align: right;
    }

    /*แนวนอน*/
    @media print{@page {
        size: A4 landscape;
        /*margin: 5mm 5mm 5mm 5mm;*/
        }}

    } 
    /*แนวตั้ง*/
    /*@media print{@page {size: portrait}}*/
</style>
<div id="odvRptProductTransferHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <?php if(isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>
                        <div class="text-left">
                            <label class="xCNRptCompany"><?=$aCompanyInfo['FTCmpName']?></label>
                        </div>

                        <?php if($aCompanyInfo['FTAddVersion'] == '1'){ // ที่อยู่แบบแยก ?>
                            <div class="text-left xCNRptAddress">
                                <label ><?=$aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi']?>
                                <?=$aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode']?></label>
                            </div>
                        <?php } ?>

                        <?php if($aCompanyInfo['FTAddVersion'] == '2'){ // ที่อยู่แบบรวม ?>
                            <div class="text-left xCNRptAddress">
                                <label><?=$aCompanyInfo['FTAddV2Desc1']?></label>
                            </div>
                            <div class="text-left xCNRptAddress">
                                <label><?=$aCompanyInfo['FTAddV2Desc2']?></label>
                            </div>
                        <?php } ?>

                        
                        <div class="text-left xCNRptAddress">
                            <label><?=$aDataTextRef['tRptAddrTel'] . $aCompanyInfo['FTCmpTel']?> <?=$aDataTextRef['tRptAddrFax'] . $aCompanyInfo['FTCmpFax']?></label>
                        </div>

                        <div class="text-left xCNRptAddress">
                            <label><?=$aDataTextRef['tRptAddrBranch'] . $aCompanyInfo['FTBchName']?></label>
                        </div>

                        <div class="text-left xCNRptAddress">
                            <label><?=$aDataTextRef['tRptTaxSalePosTaxId'] . $aCompanyInfo['FTAddTaxNo']?></label>
                        </div>
                       



                    <?php } ?>   
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo @$aDataTextRef['tTitleReport'];?></label>
                            </div>
                        </div>
                    </div>

                    <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']?> : </label>   <label><?=$aDataFilter['tBchNameFrom'];?></label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo']?> : </label>     <label><?=$aDataFilter['tBchNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
                    <div class="text-right">
                        <?php date_default_timezone_set('Asia/Bangkok'); ?>
                        <label class="xCNRptDataPrint"><?php echo $aDataTextRef['tDatePrint'].' '.date('d/m/Y').' '.$aDataTextRef['tTimePrint'].' '.date('H:i:s');?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="xCNContentReport">
            <div id="odvRptTableAdvance" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th  class="text-left xCNRptColumnHeader" width="7%"><?php echo @$aDataTextRef['tRptProductRefillBranch'];?></th>
                            <th  class="text-left xCNRptColumnHeader" width="7%"><?php echo @$aDataTextRef['tRptProductRefillShop'];?></th>
                            <th  class="text-left xCNRptColumnHeader"  width="7%"><?php echo @$aDataTextRef['tRptProductRefillTosVD'];?></th>
                            <th  class="text-center xCNRptColumnHeader"  width="7%"><?php echo @$aDataTextRef['tRptProductRefillDocNo'];?></th>
                            <th  class="text-center xCNRptColumnHeader"  width="7%"><?php echo @$aDataTextRef['tRptProductRefillDate'];?></th>
                            <th  class="text-left xCNRptColumnHeader"  width="7%" ><?php echo @$aDataTextRef['tRptProductRefillFromsWah'];?></th>
                            <th  class="text-left xCNRptColumnHeader"  width="7%"><?php echo @$aDataTextRef['tRptProductRefillChannelgroup'];?></th>
                            <th  class="text-left xCNRptColumnHeader"  width="7%"><?php echo @$aDataTextRef['tRptProductRefillID'];?></th>
                            <th  class="text-left xCNRptColumnHeader"  width="7%"><?php echo @$aDataTextRef['tRptProductRefillName'];?></th>
                            <th  class="text-right xCNRptColumnHeader"  width="7%"><?php echo @$aDataTextRef['tRptProductRefillfloor'];?></th>
                            <th  class="text-right xCNRptColumnHeader"  width="7%"><?php echo @$aDataTextRef['tRptProductRefillspiral'];?></th>
                            <th  class="text-right xCNRptColumnHeader"  width="7%"><?php echo @$aDataTextRef['tRptProductRefillAmounttofill'];?></th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])):?>
                            <?php
                                // Set ตัวแปร SumSubFooter และ ตัวแปร SumFooter
                                $nSubSumAjdWahB4Adj     = 0;
                                $nSubSumAjdUnitQty      = 0;

                                $nSumFooterAjdWahB4Adj  = 0;
                                $nSumFooterAjdUnitQty   = 0;
                                
                            ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey=>$aValue): ?>
                                <?php
                                    // Step 1 เตรียม Parameter สำหรับการ Groupping
                                    // $tPosCode     = $aValue["FTPdtCode"];  

                                    $tBchCode     = $aValue["FTBchCode"];
                                    $tShopCode    = $aValue["FTXthShopTo"];
                                    $tWahCode     = $aValue["FTWahNameTo"];
                                    $tDocCode     = $aValue["FTXthDocNo"];

                                    $nGroupMember   = $aValue["FNRptGroupMember"]; 
                                    $nRowPartID     = $aValue["FNRowPartID"]; 
                                ?>
                                <?php
                                    //Step 2 Groupping data
                                    // $aGrouppingData = array($tDocCode,$tShopCode);
                                    // if ($nRowPartID == 1) {
                                    //     echo "<tr>";
                                    //     for ($i = 0; $i < count($aGrouppingData); $i++) {
                                    //         if ($aGrouppingData[$i] !== 'N') {
                                    //             echo "<td class='xCNRptGrouPing  text-left' style='padding: 5px;' colspan='1'>" . $aGrouppingData[$i] . "</td>";
                                    //         } else {
                                    //             echo "<td></td>";
                                    //         }
                                    //     }
                                    //     echo "</tr>";
                                    // }
                                
                                ?>

                                <?php
                                    $tDocDate = date('Y-m-d', strtotime($aValue["FDXthDocDate"]));
                                ?>

                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <?php  if ($nRowPartID == 1) { ?>
                                    <tr>
                                        <td nowrap class="text-left xCNRptDetail"><?php echo $tBchCode?></td>
                                        <td nowrap class="text-left xCNRptDetail"><?php echo $tShopCode?></td>
                                        <td nowrap class="text-left xCNRptDetail"><?php echo $tWahCode;?></td>
                                        <td nowrap class="text-left xCNRptDetail"><?php echo $tDocCode;?></td>
                                        <td nowrap class="text-left xCNRptDetail"><?php echo $tDocDate;?></td>
                                        <td nowrap class="text-left xCNRptDetail"><?php echo $aValue["FTWahNameFrm"];?></td>
                                        <td nowrap class="text-left xCNRptDetail"><?php echo $aValue["FTCabName"];?></td>
                                        <td nowrap class="text-left xCNRptDetail"><?php echo $aValue["FTPdtCode"];?></td>
                                        <td nowrap class="text-left xCNRptDetail"><?php echo $aValue["FTPdtName"];?></td>
                                        <td nowrap class="text-right xCNRptDetail"><?php echo $aValue["FNLayRow"];?></td>
                                        <td nowrap class="text-right xCNRptDetail"><?php echo $aValue["FNLayCol"];?></td>
                                        <td nowrap class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXtdQty"],2);?></td>
                                    </tr>
                                <?php }else{ ?>
                                    <tr>
                                        <td nowrap class="text-left xCNRptDetail"></td>
                                        <td nowrap class="text-left xCNRptDetail"></td>
                                        <td nowrap class="text-left xCNRptDetail"></td>
                                        <td nowrap class="text-left xCNRptDetail"></td>
                                        <td nowrap class="text-left xCNRptDetail"><?php echo $tDocDate;?></td>
                                        <td nowrap class="text-left xCNRptDetail"><?php echo $aValue["FTWahNameFrm"];?></td>
                                        <td nowrap class="text-left xCNRptDetail"><?php echo $aValue["FTCabName"];?></td>
                                        <td nowrap class="text-left xCNRptDetail"><?php echo $aValue["FTPdtCode"];?></td>
                                        <td nowrap class="text-left xCNRptDetail"><?php echo $aValue["FTPdtName"];?></td>
                                        <td nowrap class="text-right xCNRptDetail"><?php echo $aValue["FNLayRow"];?></td>
                                        <td nowrap class="text-right xCNRptDetail"><?php echo $aValue["FNLayCol"];?></td>
                                        <td nowrap class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXtdQty"],2);?></td>
                                    </tr>
                                <?php } ?>
                                <?php
                                    //Step 3 : เตรียม Parameter สำหรับ Summary Sub Footer
                                    $nSubSumFCXtdQty = number_format($aValue["FCXtdQty_SubTotal"],2);

                                    $aSumFooter         = array($aDataTextRef['tRptTotal'],'N','N','N','N','N','N','N','N','N',$nSubSumFCXtdQty);
                                    $tXthDocNo = $aValue["FTXthDocNo"] ;

                                    //Step 4 : สั่ง Summary SubFooter
                                    //Parameter 
                                    //$nGroupMember     = จำนวนข้อมูลทั้งหมดในกลุ่ม
                                    //$nRowPartID       = ลำดับข้อมูลในกลุ่ม
                                    //$aSumFooter       =  ข้อมูล Summary SubFooter
                                    if($nRowPartID == $nGroupMember){
                                        echo '<tr>';
                                        for($i = 0;$i<count($aSumFooter);$i++){
                                            if($aSumFooter[$i] !='N'){
                                                $tFooterVal =   $aSumFooter[$i];           
                                            }else{
                                                $tFooterVal =   '';
                                            }
    
                                            if(intval($i) == 0){
                                                $tClassCss = "text-left";
                                            }else{
                                                $tClassCss = "text-right";
                                            }

                                            if(intval($i) == 0){
                                                $nColspan = "colspan=2";
                                            }else{
                                                $nColspan = "colspan=0";
                                            }
                                            echo "<td class='xCNRptGrouPing $tClassCss' $nColspan style='border-top: dashed 1px #333 !important;'>".$tFooterVal."</td>";
                                        }
                                        echo "</tr>";
    
    
                                        $nCountDataAll = count($aDataReport['aRptData']);
                                        if($nCountDataAll - 1 != $nKey){
                                            echo "<tr><td class='xCNRptGrouPing' colspan='12' style='border-top: dashed 1px #333 !important;'></td></tr>";
                                        }
                                    
                                    }
                                    // Step 5 เตรียม Parameter สำหรับ SumFooter
                                    $nSumFooterFCXtdQty  = number_format($aValue["FCXtdQty_Footer"],2);
                                    
                                    $paFooterSumData        = array($aDataTextRef['tRptFooterSumAll'],'N','N','N','N','N','N','N','N','N','N',$nSumFooterFCXtdQty);
                                ?>
                            <?php endforeach;?>
                            <?php
                                //Step 6 : สั่ง Summary Footer
                                $nPageNo    = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                                FCNtHRPTSumFooter($nPageNo,$nTotalPage,$paFooterSumData);
                            ?>
                        <?php else:?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo @$aDataTextRef['tRptAdjStkNoData'];?></td></tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>

            <!-- ============================ ฟิวเตอร์ข้อมูล ============================ -->
            <?php if ((isset($aDataFilter['tWahNameFrom']) && !empty($aDataFilter['tWahNameFrom'])) && (isset($aDataFilter['tWahNameTo']) && !empty($aDataFilter['tWahNameTo']))
                        || (isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo']))
                        || (isset($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeFrom'])) && (isset($aDataFilter['tShpCodeTo']) && !empty($aDataFilter['tShpCodeTo']))
                        || (isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))
                        || (isset($aDataFilter['tWahCodeFrom']) && !empty($aDataFilter['tWahCodeFrom'])) && (isset($aDataFilter['tWahCodeTo']) && !empty($aDataFilter['tWahCodeTo']))
                        || (isset($aDataFilter['tBchCodeSelect']))
                        || (isset($aDataFilter['tMerCodeSelect']))
                        || (isset($aDataFilter['tShpCodeSelect'])) 
                        || (isset($aDataFilter['tPosCodeSelect'])) 
                        || (isset($aDataFilter['tWahCodeSelect']))
                        ){ ?>
            <div class="xCNRptFilterTitle">
                <div class="text-left">
                    <label class="xCNTextConsOth"><?=$aDataTextRef['tRptConditionInReport'];?></label>
                </div>
            </div>
            <?php } ;?>

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
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantFrom'].' : </span>'.$aDataFilter['tMerNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantTo'].' : </span>'.$aDataFilter['tMerNameTo'];?></label>
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
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopFrom'].' : </span>'.$aDataFilter['tShpNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopTo'].' : </span>'.$aDataFilter['tShpNameTo'];?></label>
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

            <!-- ============================ ฟิวเตอร์ข้อมูล คลังสินค้า ============================ -->
            <?php if ((isset($aDataFilter['tWahCodeFrom']) && !empty($aDataFilter['tWahCodeFrom'])) && (isset($aDataFilter['tWahCodeTo']) && !empty($aDataFilter['tWahCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjWahFrom'].' : </span>'.$aDataFilter['tWahNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjWahTo'].' : </span>'.$aDataFilter['tWahNameTo'];?></label>
                    </div>
                </div>
            <?php endif; ?> 
            <?php if (isset($aDataFilter['tWahCodeSelect']) && !empty($aDataFilter['tWahCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjWahFrom']; ?> : </span> <?php echo ($aDataFilter['bWahStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tWahNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?> 
        </div>
        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <?php if($aDataReport["aPagination"]["nTotalPage"] > 0):?>
                            <label class="xCNRptLabel"><?php echo $aDataReport["aPagination"]["nDisplayPage"].' / '.$aDataReport["aPagination"]["nTotalPage"]; ?></label>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



