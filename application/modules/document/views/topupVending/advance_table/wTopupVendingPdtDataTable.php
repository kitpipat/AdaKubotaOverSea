<div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" id="otbDOCPdtTable">
        <thead>
            <tr>
                <th width="5%" class="text-center"><?php echo language('document/TopupVending/TopupVending', 'tTBNo'); ?></th>
                <th width="15%" class="text-left"><?php echo language('document/TopupVending/TopupVending', 'tTFXVDPdtCodeName'); ?></th>
                <th width="20%" class="text-left"><?php echo language('document/TopupVending/TopupVending', 'tTFXVDPdtName'); ?></th>
                <th width="20%" class="text-left"><?php echo language('document/TopupVending/TopupVending', 'tChannelGroup'); ?></th>
                <th width="5%" class="text-center"><?php echo language('document/TopupVending/TopupVending', 'tRow'); ?></th>
                <th width="5%"class="text-center"><?php echo language('document/TopupVending/TopupVending', 'tColumn'); ?></th>
                <th width="10%" class="text-right"><?php echo language('document/TopupVending/TopupVending', 'tTFXVDPdtBalance'); ?></th>
                <th width="10%" class="text-right"><?php echo language('document/TopupVending/TopupVending', 'tTFXVDPdtMaxTransfer'); ?></th>
                <th width="10%" class="text-right"><?php echo language('document/TopupVending/TopupVending', 'tRefillQty'); ?></th>
                <th><?php echo language('document/TopupVending/TopupVending', 'tTBDelete'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($aDataList['rtCode'] == 1) { ?>
                <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                    <tr class="xCNTextDetail2 xCNTopUpVendingPdtLayoutRow" data-seq-no="<?php echo $aValue['FNXtdSeqNo']; ?>">
                        <td class="text-center"><?php echo $key+1; ?></td>
                        <td class="text-left xCNTopUpVendingPdtLayoutPdtCode"><?php echo $aValue['FTPdtCode']; ?></td>
                        <td class="text-left"><?php echo $aValue['FTXtdPdtName']; ?></td>
                        <td class="text-left"><?php echo $aValue['FTCabNameForTWXVD']; ?></td>
                        <td class="text-center"><?php echo $aValue['FNLayRowForTWXVD']; ?></td>
                        <td class="text-center"><?php echo $aValue['FNLayColForTWXVD']; ?></td>
                        <td class="text-right xCNTopUpVendingPdtLayoutStkQty"><?php echo $aValue['FCStkQty']; ?></td>
                        <td class="text-right xCNTopUpVendingPdtLayoutMaxQty"><?php echo $aValue['FCLayColQtyMaxForTWXVD']; ?></td>
                        <td class="text-right">
                            <input 
                            type="text" 
                            class="xCNTopUpVendingQty xCNInputNumericWithoutDecimal xCNInputLength xCNApvOrCanCelDisabledQty" 
                            data-length="3"
                            value="<?php echo $aValue['FCXtdQty']; ?>">
                        </td>
                        <td>
                            <img class="xCNIconTable xCNIconDel" src="<?= base_url('application/modules/common/assets/images/icons/delete.png') ?>">
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                </tr>
            <?php }; ?>
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPage btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvTopUpVendignPdtDataTableClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvTopUpVendignPdtDataTableClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvTopUpVendignPdtDataTableClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<?php include('script/jTopupVendingPdtDataTable.php'); ?>