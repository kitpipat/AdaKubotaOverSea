<div class="xCNtableFixHead">
    <table class="table xRefIntTable" id="otbPAMRefPoDocDetail">
        <thead >
            <tr>
                <th class="xRefIntTh text-center">
                    <label class="fancy-checkbox ">
                        <input id="ocbRefIntDocDTAll" type="checkbox" class="ocbRefIntDocDTAll" name="ocbListItem[]"  checked>
                        <span class="">&nbsp;</span>
                    </label>
                </th>
                <th class="xRefIntTh text-center"><?php echo language('document/purchaseorder/purchaseorder','tPOTBNo');?></th>
                <th class="xRefIntTh"><?php echo language('document/purchaseorder/purchaseorder','tPOTable_pdtcode');?></th>
                <th class="xRefIntTh"><?php echo language('document/purchaseorder/purchaseorder','tPOTable_pdtname');?></th>
                <th class="xRefIntTh"><?php echo language('document/purchaseorder/purchaseorder','tPOTable_barcode');?></th>
                <th class="xRefIntTh"><?php echo language('document/purchaseorder/purchaseorder','tPOTable_unit');?></th>
                <th class="xRefIntTh text-right">จำนวน</th>
            </tr>
        </thead>
        <tbody>
            <?php if($aDataList['rtCode'] == 1 ):?>
                <?php foreach($aDataList['raItems'] AS $nKey => $aValue): ?>
                    <tr class="xCNTextDetail2 xCNCheckQTY"
                        data-qtyall="<?=number_format(@$aValue['FCXpdQtyAll'],0);?>"
                    >
                        <td class="xRefIntTd text-center">
                            <label class="fancy-checkbox ">
                                <input type="checkbox" class="ocbRefIntDocDT" name="ocbRefIntDocDT[]" value="<?=$aValue['FNXpdSeqNo']?>" checked>
                                <span>&nbsp;</span>
                            </label>
                        </td>
                        <td class="xRefIntTd text-center"><?=$nKey+1?></td>
                        <td class="xRefIntTd"><?=$aValue['FTPdtCode']?></td>
                        <td class="xRefIntTd"><?=$aValue['FTXpdPdtName']?></td>
                        <td class="xRefIntTd"><?=$aValue['FTXpdBarCode']?></td>
                        <td class="xRefIntTd"><?=$aValue['FTPunName']?></td>
                        <td class="xRefIntTd text-right"><?=number_format($aValue['FCXpdQtyAll'],$nOptDecimalShow)?></td>
                    </tr>
                <?php endforeach;?>
            <?php else:?>
                <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
            <?php endif;?>
        </tbody>
    </table>
</div>
<script>
//เลือกทั้งหมด
$('#ocbRefIntDocDTAll').click(function(){
    if($(this).is(':checked')==true){
        $('#otbPAMRefPoDocDetail > tbody  > tr').each(function() {
            let nQtyLeft = $(this).data('qtyleft');
            if(nQtyLeft != '0'){
                $(this).find('.ocbRefIntDocDT').prop('checked',true);
            }else{
                $(this).find('.ocbRefIntDocDT').prop('checked',false);
            }
        });
    }else{
        $('.ocbRefIntDocDT').prop('checked',false);
    }
});

$('.ocbRefIntDocDT').click(function(){
    if($(this).is(':checked')==false){
        $('#ocbRefIntDocDTAll').prop('checked',false);
    }
});
</script>
