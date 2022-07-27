<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold text-left" style="width:20%;"><?php echo language('document/card/cardtopup', 'tCardShiftTopUpTBBranchCode'); ?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:35%;"><?php echo language('document/card/cardtopup', 'tCardShiftTopUpTBDocNo'); ?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:10%;"><?php echo language('document/card/cardtopup', 'tCardShiftTopUpTBDocDate'); ?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:10%;"><?php echo language('document/card/cardtopup', 'tCardShiftTopUpTBCardNumber'); ?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:10%;"><?php echo language('document/card/cardtopup', 'tCardShiftTopUpTBDocStatus'); ?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:10%;"><?php echo language('document/card/cardtopup', 'tCardShiftTopUpTBApproveStatus'); ?></th>
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaEdit'] == 1 || $aAlwEvent['tAutStaRead'] == 1))  : ?>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('document/card/cardtopup','tCardShiftTopUpTBEdit'); ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key => $aValue) : ?>
                        <tr class="text-center xCNTextDetail2 otrCardShiftTopUp">
                            <td nowrap class="text-left"><?php echo @$aValue['rtCardShiftTopUpBchCode']?></td>
                            <td nowrap class="text-left"><?php echo @$aValue['rtCardShiftTopUpDocNo']; ?></td>
                            <td nowrap class="text-left"><?php echo date('Y-m-d', strtotime(@$aValue['rtCardShiftTopUpDocDate'])); ?></td>
                            <td nowrap class="text-left"><?php echo @number_format($aValue['rtCardShiftTopUpCthCardQty'], 0); ?></td>
                            <?php
                            $tCthStaDoc = "";
                            if(@$aValue['rtCardShiftTopUpCthStaDoc'] == "1"){$tCthStaDoc = language('document/card/cardtopup', 'tCardShiftTopUpTBComplete');}
                            if(@$aValue['rtCardShiftTopUpCthStaDoc'] == "2"){$tCthStaDoc = language('document/card/cardtopup', 'tCardShiftTopUpTBIncomplete');}
                            if(@$aValue['rtCardShiftTopUpCthStaDoc'] == "3"){$tCthStaDoc = language('document/card/cardtopup', 'tCardShiftTopUpTBCancel');}
                            ?>
                            <td nowrap class="text-left"><?php echo $tCthStaDoc; ?></td>
                            <?php 
                            $tCthStaPrcDoc = "";
                            if(empty($aValue['rtCardShiftTopUpCthStaPrcDoc'])){$tCthStaPrcDoc = language('document/card/cardtopup','tCardShiftTopUpTBPending');}
                            if(empty($aValue['rtCardShiftTopUpCthStaPrcDoc']) && @$aValue['rtCardShiftTopUpCthStaDoc'] == "3"){$tCthStaPrcDoc = "N/A";}
                            if(@$aValue['rtCardShiftTopUpCthStaPrcDoc'] == "2"){$tCthStaPrcDoc = language('document/card/cardtopup','tCardShiftTopUpTBProcessing');}
                            if(@$aValue['rtCardShiftTopUpCthStaPrcDoc'] == "1"){$tCthStaPrcDoc = language('document/card/cardtopup','tCardShiftTopUpTBApproved');}
                            ?>
                            <td nowrap class="text-left"><?php echo $tCthStaPrcDoc; ?></td>
                            <?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaEdit'] == 1 || $aAlwEvent['tAutStaRead'] == 1))  : ?>
                            <td nowrap>
                                <!-- เปลี่ยน -->
                                <img class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/edit.png'); ?>" onClick="JSvCardShiftTopUpCallPageCardShiftTopUpEdit('<?php echo @$aValue['rtCardShiftTopUpDocNo']; ?>')">
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else:?>
                    <tr><td nowrap class='text-center xCNTextDetail2' colspan='7'><?php echo language('common/main/main','tCMNNotFoundData'); ?></td></tr>
                <?php endif;?>
                </tbody>
			</table>
        </div>
    </div>
</div>

<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p><?php echo language('common/main/main','tResultTotalRecord'); ?> <?=$aDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord'); ?> <?php echo language('common/main/main','tCurrentPage'); ?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPageCardShiftTopUp btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvCardShiftTopUpClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <button onclick="JSvCardShiftTopUpClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCardShiftTopUpClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

