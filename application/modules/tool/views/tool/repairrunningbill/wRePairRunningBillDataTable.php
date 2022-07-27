<?php
if ($aTotalSaleByBranchData['rtCode'] == '1') {
    $nCurrentPage = $aTotalSaleByBranchData['rnCurrentPage'];
} else {
    $nCurrentPage = '1';
}
?>
<style>
    .xWRowSort {
        cursor: pointer;
    }

    .xWSpanSort {
        cursor: pointer;
    }
</style>

 <div class="table-responsive "  style="margin-top: 22px;">
<?php 
    if(!empty($aTotalSaleByBranchData['raDataFindDup'][0]['FTXshDocNoDup'])){
        $tXshDocNoDup =  $aTotalSaleByBranchData['raDataFindDup'][0]['FTXshDocNoDup'];
      }else{
        $tXshDocNoDup = '';
      }
  
      if(!empty($aTotalSaleByBranchData['raDataFindNotCloseShf'][0]['FTXshDocNo'])){
          if($tXshDocNoDup!=''){
              $tXshDocNoDup .=','; 
          }
          $tXshDocNoDup .=  $aTotalSaleByBranchData['raDataFindNotCloseShf'][0]['FTXshDocNo'];
        }else{
          $tXshDocNoDup .= '';
        }
    $tRpnUUID = uniqid();
?>
<script>   $('#obtRpRnSaleRepair').attr('disabled',true); </script>
    <?php if($tXshDocNoDup!=''){ ?>
    <span  class="" style="color:red"><b><?php echo language('tool/tool/tool', 'tSMTSALDressCrip1'); ?> <?=$tXshDocNoDup?>,... </b></span>
    <?php }else{ ?>
        <?php if (!empty($aTotalSaleByBranchData['raItems'])) { ?>
    <span  class="" style="color:green" ><b><?php echo language('tool/tool/tool', 'tSMTSALRefUUID'); ?> #<?=$tRpnUUID;?></b></span>
    <input type="hidden" name="oetRpRnDocUUID" id="oetRpRnDocUUID" value="<?=$tRpnUUID;?>" >
    <script>   $('#obtRpRnSaleRepair').attr('disabled',false); </script>
        <?php } ?>
    <?php } ?>
    <table id="" class="table table-striped">
        <thead>
            <tr>
                <th nowarp class="text-center xCNTextBold xWRowSort" ><?php echo language('tool/tool/tool', 'tToolBranchCode'); ?></th>
                <th nowarp class="text-center xCNTextBold xWRowSort" ><?php echo language('tool/tool/tool', 'tToolBranchName'); ?></th>
                <th nowarp class="text-center xCNTextBold xWRowSort" ><?php echo language('tool/tool/tool', 'tToolPosCode'); ?></th>
                <th nowarp class="text-center xCNTextBold xWRowSort" ><?php echo language('tool/tool/tool', 'tToolDocDate'); ?></th>
                <th nowarp class="text-center xCNTextBold xWRowSort" ><?php echo language('tool/tool/tool', 'tSMTSALModalBillOld'); ?></th>
                <th nowarp class="text-center xCNTextBold xWRowSort" ><?php echo language('tool/tool/tool', 'tSMTSALModalBillNews'); ?></th>
                <th nowarp class="text-center xCNTextBold xWRowSort" ><?php echo language('tool/tool/tool', 'tSMTSALModalBillStaRun'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($aTotalSaleByBranchData['raItems'])) { ?>
                <?php foreach ($aTotalSaleByBranchData['raItems'] as $nKey => $aValue) :
                                 if($aValue['tStaShfClose']=='2' || $aValue['tDocDup']=='1'){
                                    $tDocDup = '<span style="color:red">'.language('tool/tool/tool', 'tSMTSALModalBillStaRun2').'</span>';
                                }else{
                                    $tDocDup = '<span style="color:green">'.language('tool/tool/tool', 'tSMTSALModalBillStaRun1').'</span>';
                                }
  
                ?>
                    <tr>
                        <td nowarp><?php echo $aValue['FTBchCode'] ?></td>
                        <td nowarp><?php echo $aValue['FTBchName'] ?></td>
                        <td nowarp class="text-center"><?php echo $aValue['FTPosCode'] ?></td>
                        <td nowarp  class="text-center"><?php echo $aValue['FDXshDocDate'] ?></td>
                        <td nowarp class="text-center"><?php echo $aValue['FTXshDocNo'] ?></td>
                        <td nowarp class="text-center"><?php echo $aValue['FTXshDocNoNew'] ?></td>
                        <td nowarp class="text-left"><?php echo $tDocDup ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php }else{ ?>
                <tr>
                    <td colspan="8" align="center"><?php echo language('tool/tool/tool', 'tToolDataNotFound'); ?></td>    
                <tr>
          <?php  } ?>
        </tbody>
    </table>
</div>


<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main', 'tResultTotalRecord') ?> <?php echo $aTotalSaleByBranchData['rnAllRow'] ?> <?php echo language('common/main/main', 'tRecord') ?> <?php echo $aTotalSaleByBranchData['rnCurrentPage'] ?> / <?php echo $aTotalSaleByBranchData['rnAllPage'] ?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageTotalByBranchRunning btn-toolbar pull-right">
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvATLRePairRunningBillClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for ($i = max($nPage - 2, 1); $i <= max(0, min($aTotalSaleByBranchData['rnAllPage'], $nPage + 2)); $i++) { ?>
                <?php
                if ($nPage == $i) {
                    $tActive = 'active';
                    $tDisPageNumber = 'disabled';
                } else {
                    $tActive = '';
                    $tDisPageNumber = '';
                }
                ?>
                <button onclick="JSvATLRePairRunningBillClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aTotalSaleByBranchData['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvATLRePairRunningBillClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<script>
$('#ocbListItemAll').click(function(){
            if($("#ocbListItemAll:checkbox:checked").is(':checked')==true){
                $('.ocbATLListItem').not(':disabled').prop('checked',true);
            }else{
                $('.ocbATLListItem').not(':disabled').prop('checked',false);
            }
});

$('.ocbATLListItem').click(function(){
            if($(this).is(':checked')==false){
                $('#ocbListItemAll').prop('checked',false);
            }
});

</script>


