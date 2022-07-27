<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold text-left" style="width:20%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBBranchCode'); ?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:35%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBDocNo'); ?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:10%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBDocDate'); ?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:10%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBCardNumber'); ?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:10%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBDocStatus'); ?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:10%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBApproveStatus'); ?></th>
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaEdit'] == 1 || $aAlwEvent['tAutStaRead'] == 1))  : ?>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBEdit'); ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key => $aValue) : ?>
                        <tr class="text-center xCNTextDetail2 otrCardShiftNewCard">
                            <td nowrap class="text-left"><?php echo @$aValue['rtCardShiftNewCardBchCode']?></td>
                            <td nowrap class="text-left"><?php echo @$aValue['rtCardShiftNewCardDocNo']; ?></td>
                            <td nowrap class="text-left"><?php echo date('Y-m-d', strtotime(@$aValue['rtCardShiftNewCardDocDate'])); ?></td>
                            <td nowrap class="text-left"><?php echo @number_format($aValue['rtCardShiftNewCardCshCardQty'], 0); ?></td>
                            <?php
                            $tCshStaDoc = "";
                            if(@$aValue['rtCardShiftNewCardCshStaDoc'] == "1"){$tCshStaDoc = language('document/card/newcard','tCardShiftNewCardTBComplete');}
                            if(@$aValue['rtCardShiftNewCardCshStaDoc'] == "2"){$tCshStaDoc = language('document/card/newcard','tCardShiftNewCardTBIncomplete');}
                            if(@$aValue['rtCardShiftNewCardCshStaDoc'] == "3"){$tCshStaDoc = language('document/card/newcard','tCardShiftNewCardTBCancel');}
                            ?>
                            <td nowrap class="text-left"><?php echo $tCshStaDoc; ?></td>
                            <?php 
                            $tCshStaPrcDoc = "";
                            if(empty($aValue['rtCardShiftNewCardCshStaPrcDoc'])){$tCshStaPrcDoc = language('document/card/newcard','tCardShiftNewCardTBPending');}
                            if(empty($aValue['rtCardShiftNewCardCshStaPrcDoc']) && @$aValue['rtCardShiftNewCardCshStaDoc'] == "3"){$tCshStaPrcDoc = "N/A";}
                            if(@$aValue['rtCardShiftNewCardCshStaPrcDoc'] == "2"){$tCshStaPrcDoc = language('document/card/newcard','tCardShiftNewCardTBProcessing');}
                            if(@$aValue['rtCardShiftNewCardCshStaPrcDoc'] == "1"){$tCshStaPrcDoc = language('document/card/newcard','tCardShiftNewCardTBApproved');}
                            ?>
                            <td nowrap class="text-left"><?php echo $tCshStaPrcDoc; ?></td>
                            <?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaEdit'] == 1 || $aAlwEvent['tAutStaRead'] == 1)) : ?>
                            <td nowrap>
                                <!-- เปลี่ยน -->
                                <img class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/edit.png'); ?>" onClick="JSvCardShiftNewCardCallPageCardShiftNewCardEdit('<?php echo @$aValue['rtCardShiftNewCardDocNo']; ?>')">
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
        <p><?php echo language('common/main/main','tResultTotalRecord'); ?> <?php echo $aDataList['rnAllRow']; ?> <?php echo language('common/main/main','tRecord'); ?> <?php echo language('common/main/main','tCurrentPage'); ?> <?php echo $aDataList['rnCurrentPage']; ?> / <?php echo $aDataList['rnAllPage']; ?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPageCardShiftNewCard btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvCardShiftNewCardClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvCardShiftNewCardClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCardShiftNewCardClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>


