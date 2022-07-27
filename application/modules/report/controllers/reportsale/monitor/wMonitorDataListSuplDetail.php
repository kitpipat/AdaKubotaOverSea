<?= language('monitor/monitor/monitor','tMONlabelLowtable')?>
<table class="table table-striped table-hover">
  <thead>
    <tr class="bg-primary">
      <th class="text-center"><?= language('monitor/monitor/monitor','tMONLowtableThCol1')?></th>
      <th class="text-left"><?= language('monitor/monitor/monitor','tMONLowtableThCol2')?></th>
      <th class="text-left"><?= language('monitor/monitor/monitor','tMONLowtableThCol3')?></th>
      <th class="text-left"><?= language('monitor/monitor/monitor','tMONLowtableThCol4')?></th>
      <th class="text-left"><?= language('monitor/monitor/monitor','tMONLowtableThCol5')?></th>
      <th class="text-left"><?= language('monitor/monitor/monitor','tMONLowtableThCol6')?></th>
      <th class="text-left"><?= language('monitor/monitor/monitor','tMONLowtableThCol7')?></th>
      <th class="text-left"><?= language('monitor/monitor/monitor','tMONLowtableThCol8')?></th>
      <th class="text-left"><?= language('monitor/monitor/monitor','tMONLowtableThCol9')?></th>
      <th class="text-right"><?= language('monitor/monitor/monitor','tMONLowtableThCol10')?></th>
      <th class="text-right"><?= language('monitor/monitor/monitor','tMONLowtableThCol11')?></th>
      <th class="text-right"><?= language('monitor/monitor/monitor','tMONLowtableThCol12')?></th>
      <th class="text-right"><?= language('monitor/monitor/monitor','tMONLowtableThCol13')?></th>
      <th class="text-center"><?= language('monitor/monitor/monitor','tMONLowtableThCol14')?></th>
    </tr>
  </thead>
  <tbody>

    <?php
    if (isset($aMONDataList['raItems'])) {
      foreach ($aMONDataList['raItems'] as $nKey => $aValue) {
        if ($aValue['FNXphDueQtyLate']>0) {
          $tTextColor = "#FF0000";
        }else {
          $tTextColor = "#000000";
        }

         ?>

        <tr>
          <td class="text-center"><font color="<?php echo $tTextColor; ?>"><?php echo $nKey+1; ?></font></td>
          <td class="text-left"><font color="<?php echo $tTextColor; ?>"><?php echo $aValue['FTBchName']; ?></font></td>
          <td class="text-left"><font color="<?php echo $tTextColor; ?>"><?php echo $aValue['FTXphDocNo']; ?></font></td>
          <td class="text-center"><font color="<?php echo $tTextColor; ?>"><?php echo $aValue['FDXphDocDate']; ?></font></td>
          <td class="text-left"><font color="<?php echo $tTextColor; ?>"><?php echo $aValue['FTXshRefInt']; ?></font></td>
          <td class="text-left"><font color="<?php echo $tTextColor; ?>"><?php echo $aValue['FTXshRefDocNoInt']; ?></font></td>
          <td class="text-left"><font color="<?php echo $tTextColor; ?>"><?php echo $aValue['FTXshBillingNote']; ?></font></td>
          <td class="text-center"><font color="<?php echo $tTextColor; ?>"><?php echo $aValue['FDXshBillingNoteDate']; ?></font></td>
          <td class="text-center"><font color="<?php echo $tTextColor; ?>"><?php echo $aValue['FDXphDueDate']; ?></font></td>
          <td class="text-right"><font color="<?php echo $tTextColor; ?>"><?php echo $aValue['FNXphDueQtyLate']; ?></font></td>
          <td class="text-right"><font color="<?php echo $tTextColor; ?>"><?php echo number_format($aValue['FCXphGrand'],2); ?></font></td>
          <td class="text-right"><font color="<?php echo $tTextColor; ?>"><?php echo number_format($aValue['FCXphPaid'],0); ?></font></td>
          <td class="text-right"><font color="<?php echo $tTextColor; ?>"><?php echo number_format($aValue['FCXphLeft'],2); ?></font></td>
          <td class="text-center">
            <img class="xCNIconTable" style="text-align: center;"
            src="<?php echo  base_url().'/application/modules/common/assets/images/icons/view2.png'?>"
            onclick="JSvIVCallPageEdit('<?php echo $aValue['FTXphDocNo']; ?>')">
          </td>
        </tr>
        <?php
      }
    }else {
      ?>
       <tr>
         <td colspan="14" class="text-center"><?php echo language('bank/bank/bank','tBnkNoData'); ?></td>
       </tr><?php
    } ?>
  </tbody>
</table>
