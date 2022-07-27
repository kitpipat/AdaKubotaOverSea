<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="table-responsive">
        <table id="otbASTDocPdtAdvTable" class="table table-striped xWPdtTableFont">
            <thead>
                <tr class="xCNCenter">
                    <?php if (empty($tASTStaApv) && $tASTStaDoc != 3) : ?>
                        <th><?php echo language('document/adjuststock/adjuststock', 'tASTTBChoose') ?></th>
                    <?php endif; ?>
                    <th><?php echo language('document/adjuststock/adjuststock', 'tSeq') ?></th>
                    <th><?php echo language('document/adjuststock/adjuststock', 'tPdtCode') ?></th>
                    <th><?php echo language('document/adjuststock/adjuststock', 'tPdtName') ?></th>
                    <th><?php echo language('document/adjuststock/adjuststock', 'tPdtBarcode') ?></th>
                    <th><?php echo language('document/adjuststock/adjuststock', 'tRatio') ?></th>

                    <?php if (!empty($tASTStaApv) && $tASTStaDoc != 3) { ?>
                        <th><?php echo language('document/adjuststock/adjuststock', 'tBeforeCounting') ?></th>
                    <?php } ?>

                    <th><?php echo language('document/adjuststock/adjuststock', 'tCounting') ?></th>

                    <?php if (!empty($tASTStaApv) && $tASTStaDoc != 3) { ?>
                        <th><?php echo language('document/adjuststock/adjuststock', 'tAfterCounting') ?></th>
                    <?php } ?>  

                    <?php if ($tASTStaApv == '' && $tASTStaDoc != 3) { ?>
                        <th><?php echo language('document/adjuststock/adjuststock', 'tASTTBDelete') ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $nNumSeq = 0;
                ?>
                <?php if ($aDataDTList['rtCode'] == 1) : ?>
                    <?php foreach ($aDataDTList['raItems'] as $DataTableKey => $aDataTableVal) : ?>
                        <tr 
                        class="text-center xCNTextDetail2 xCNDOCPdtItem nItem<?php echo $nNumSeq; ?>" 
                        data-index="<?php echo $aDataTableVal['rtRowID']; ?>" 
                        data-pdtcode="<?php echo $aDataTableVal['FTPdtCode']; ?>" 
                        data-seqno="<?php echo $aDataTableVal['FNXtdSeqNo']; ?>">

                            <?php if (empty($tASTStaApv) && $tASTStaDoc != 3) { ?>
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?php echo $aDataTableVal['FNXtdSeqNo'] ?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                            <?php } ?>

                            <td class="text-center"><?= $aDataTableVal['rtRowID']; ?></td>
                            <td><?= $aDataTableVal['FTPdtCode']; ?></td>
                            <td><?= $aDataTableVal['FTXtdPdtName']; ?></td>
                            <td><?= $aDataTableVal['FTXtdBarCode']; ?></td>
                            <td><?= number_format($aDataTableVal['FCPdtUnitFact'],0); ?></td>

                            <?php $tDataCol = number_format($aDataTableVal['FCAjdUnitQtyC1'],0); ?>    
                            <?php if(empty($tASTStaApv) && $tASTStaDoc != 3) { ?>
                                <td>
                                    <label class="xCNHide xCNPdtFont xWShowInLine<?php echo $aDataTableVal['FNXtdSeqNo'];?> xWShowValueFCAjdUnitQtyC1<?php echo $aDataTableVal['FNXtdSeqNo'];?>">
                                        <?php echo  $tDataCol != '' ? "".$tDataCol : '-'; ?>
                                    </label>
                                    <div class="xWEditInLine<?php echo $aDataTableVal['FNXtdSeqNo']?>">
                                        <input
                                            type="text"
                                            class="form-control text-right xWASTDisabledOnApv xCNPdtEditInLine xWFCAjdUnitQtyC1"
                                            id="ohdASTFCAjdUnitQtyC1<?php echo $aDataTableVal['FNXtdSeqNo'];?>"
                                            name="ohdASTFCAjdUnitQtyC1<?php echo $aDataTableVal['FNXtdSeqNo'];?>"
                                            maxlength="14"
                                            value="<?php echo  $tDataCol != '' ? "".$tDataCol : '-'; ?>"
                                            data-field="FCAjdUnitQtyC1"
                                            style=" background: rgb(249, 249, 249);
                                                    box-shadow: 0px 0px 0px inset;
                                                    border-top: 0px !important;
                                                    border-left: 0px !important;
                                                    border-right: 0px !important;
                                                    padding: 0px !important;
                                                    "
                                            autocomplete="off"
                                        >
                                    </div>
                                </td>
                            <?php } ?>

                            <?php if (!empty($tASTStaApv) && $tASTStaDoc != 3) { ?>
                                <td><?= number_format($aDataTableVal['FCAjdWahB4Adj'],0); ?></td>
                                <td><?= number_format($aDataTableVal['FCAjdUnitQtyC1'],0); ?></td>
                                <td><?= number_format($aDataTableVal['FCAjdUnitQtyC1'],0); ?></td>
                            <?php } ?>

                            <?php if (empty($tASTStaApv) && $tASTStaDoc  != 3) { ?>
                                <td nowrap class="text-center">
                                    <img class="xCNIconTable xCNIconDel" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" title="Remove" onclick="JSxASTRemoveRowDTTmp(this)">
                                </td>
                            <?php } ?>
                        </tr>
                        <?php $nNumSeq++; ?>
                    <?php endforeach ?>

                    
                <?php else : ?>
                    <tr>
                        <td class='text-center xCNTextDetail2 xWTextNotfoundDataTablePdt' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData'); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <p><?php echo language('common/main/main', 'tResultTotalRecord'); ?> <?php echo $aDataDTList['rnAllRow'] ?> <?php echo language('common/main/main', 'tRecord') ?> <?php echo language('common/main/main', 'tCurrentPage') ?> <?php echo $aDataDTList['rnCurrentPage'] ?> / <?php echo $aDataDTList['rnAllPage'] ?></p>
</div>

<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <div class="xWPageASTPdt btn-toolbar pull-right">
        <?php if ($aDataDTList['rnCurrentPage'] == 1) {
            $tASTDisabledLeft = 'disabled';
        } else {
            $tASTDisabledLeft = '-';
        } ?>
        <button onclick="JSvASTPdtDTClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tASTDisabledLeft ?>>
            <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
        </button>

        <?php for ($i = max($aDataDTList['rnCurrentPage'] - 2, 1); $i <= max(0, min($aDataDTList['rnAllPage'], $aDataDTList['rnCurrentPage'] + 2)); $i++) : ?>
            <?php
            if ($aDataDTList['rnCurrentPage'] == $i) {
                $tActive = 'active';
                $tDisPageNumber = 'disabled';
            } else {
                $tActive = '';
                $tDisPageNumber = '';
            }
            ?>
            <button onclick="JSvASTPdtDTClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
        <?php endfor; ?>

        <?php if ($aDataDTList['rnCurrentPage'] >= $aDataDTList['rnAllPage']) {
            $tDisabledRight = 'disabled';
        } else {
            $tDisabledRight = '-';
        } ?>
        <button onclick="JSvASTPdtDTClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
            <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
        </button>
    </div>
</div>

<div id="odvASTModalDelPdtDTTemp" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospASTConfirmDelPdtDTTemp"> - </span>
                <input type='hidden' id="ohdASTConfirmSeqDelete">
                <input type='hidden' id="ohdASTConfirmPdtDelete">
                <input type='hidden' id="ohdASTConfirmPunDelete">
                <input type='hidden' id="ohdASTConfirmDocDelete">
            </div>
            <div class="modal-footer">
                <button id="osmASTConfirmPdtDTTemp" type="button" class="btn xCNBTNPrimery" onClick="JSoASTPdtDelChoose('<?= @$nCurrentPage ?>')"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- <script type="text/javascript">
    $(document).ready(function(){
        var oParameterEditInLine    = {
            "DocModules"                    : "",
            "FunctionName"                  : "JSnSaveDTEditNewInline",
            "DataAttribute"                 : [],
            "TableID"                       : "otbASTDocPdtAdvTable",
            "NotFoundDataRowClass"          : "xWTextNotfoundDataTablePdt",
            "EditInLineButtonDeleteClass"   : "xWDeleteBtnEditButton",
            "LabelShowDataClass"            : "xWShowInLine",
            "DivHiddenDataEditClass"        : "xWEditInLine"
        }
        JCNxSetNewEditInline(oParameterEditInLine);

        $(".xWEditInlineElement").eq(nIndexInputEditInline).focus();
        $($(".xWEditInlineElement").eq(nIndexInputEditInline)).select();

        setTimeout(function(){
            $(".xWEditInlineElement").eq(nIndexInputEditInline).focus();
        }, 300);

        $(".xWEditInlineElement").removeAttr("disabled");
        let oElement = $(".xWEditInlineElement"); 
        for(let nI=0;nI<oElement.length;nI++){ 
            $($(oElement).eq(nI)).val($($(oElement).eq(nI)).val().trim());
        }
    });
</script> -->
<?php include("script/jAdjustStockPdtAdvTableData.php"); ?>
<!-- ========================================================================================================================================================================================================================= -->