
<?= language('monitor/monitor/monitor','tMONlabelToptable')?>
<table class="table table-striped">
  <thead>
    <tr class="bg-primary">
      <th class="text-center"><?= language('monitor/monitor/monitor','tMONToptableThCol1')?></th>
      <th><?= language('monitor/monitor/monitor','tMONToptableThCol2')?></th>
      <th><?= language('monitor/monitor/monitor','tMONToptableThCol3')?></th>
      <th><?= language('monitor/monitor/monitor','tMONToptableThCol4')?></th>
      <th><?= language('monitor/monitor/monitor','tMONToptableThCol5')?></th>
      <th><?= language('monitor/monitor/monitor','tMONToptableThCol6')?></th>
      <th class="text-right"><?= language('monitor/monitor/monitor','tMONToptableThCol7')?></th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($aMONDataList['raItems'])) {
      foreach ($aMONDataList['raItems'] as $nKey => $aValue) { ?>
        <tr onclick="JSxMONListDetail('<?php echo $aValue['FTSplCode']; ?>')">
          <td class="text-center"><?php echo $nKey+1; ?></td>
          <td><?php echo $aValue['FTSplCode']; ?></td>
          <td><?php echo $aValue['FTSplName']; ?></td>
          <td><?php echo $aValue['FTAddV2Desc1']; ?></td>
          <td><?php echo $aValue['FTAddTaxNo']; ?></td>
          <td><?php echo $aValue['FTSplEmail']; ?></td>
          <td class="text-right"><?php echo number_format($aValue['FCXphLeft'],2); ?></td>
        </tr>
        <?php
      }
    }else { ?>
      <tr>
        <td colspan="7" class="text-center"><?php echo language('bank/bank/bank','tBnkNoData'); ?></td>
      </tr><?php
    } ?>
  </tbody>
</table>
