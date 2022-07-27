<style>
    .xCNBTNPrimeryDisChgPlus{
        border-radius: 50%;
        float: left;
        width: 20px;
        height: 20px;
        line-height: 20px;
        background-color: #1eb32a;
        text-align: center;
        margin-top: 6px;
        /* margin-right: -15px; */
        font-size: 22px;
        color: #ffffff;
        cursor: pointer;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
    }
</style>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="table-responsive">
        <input type="text" class="xCNHide" id="ohdBrowseDataPdtCode" value="">
        <input type="text" class="xCNHide" id="ohdBrowseDataPunCode" value="">
        <input type="text" class="xCNHide" id="ohdEditInlinePdtCode" value="<?php echo $tPIPdtCode;?>">
        <input type="text" class="xCNHide" id="ohdEditInlinePunCode" value="<?php echo $tPIPunCode;?>">
        <table id="otbPIDocPdtAdvTableList" class="table xWPdtTableFont">
            <thead>
                <tr class="xCNCenter">
                    <th><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBChoose')?></th>
                    <th><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBNo')?></th>
                    <?php foreach($aColumnShow as $HeaderColKey => $HeaderColVal):?>
                        <th nowrap title="<?php echo iconv_substr($HeaderColVal->FTShwNameUsr, 0,30,"UTF-8");?>">
                            <?php echo iconv_substr($HeaderColVal->FTShwNameUsr, 0,30, "UTF-8");?>
                        </th>
                    <?php endforeach;?>
                    <th class="xCNPIBeHideMQSS"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPITBDelete');?></th>
                    <th class="xCNPIBeHideMQSS xWPIDeleteBtnEditButtonPdt"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBEdit');?></th>
                </tr>
            </thead>
            <tbody id="odvTBodyPIPdtAdvTableList">
                <?php $nNumSeq  = 0;?>
                <?php if($aDataDocDTTemp['rtCode'] == 1):?>
                    <?php foreach($aDataDocDTTemp['raItems'] as $DataTableKey => $aDataTableVal): ?>
                        <tr
                            class="text-center xCNTextDetail2 nItem<?php echo $nNumSeq?> xWPdtItem"
                            data-index="<?php echo $aDataTableVal['rtRowID'];?>"
                            data-docno="<?php echo $aDataTableVal['FTXthDocNo'];?>"
                            data-seqno="<?php echo $aDataTableVal['FNXtdSeqNo']?>"
                            data-pdtcode="<?php echo $aDataTableVal['FTPdtCode'];?>" 
                            data-pdtname="<?php echo $aDataTableVal['FTXtdPdtName'];?>"
                            data-puncode="<?php echo $aDataTableVal['FTPunCode'];?>"
                            data-qty="<?php echo $aDataTableVal['FCXtdQty'];?>"
                            data-setprice="<?php echo $aDataTableVal['FCXtdSetPrice'];?>"
                            data-stadis="<?php echo $aDataTableVal['FTXtdStaAlwDis']?>"
                            data-netafhd="<?php echo $aDataTableVal['FCXtdNetAfHD'];?>"
                        >
                        <td class="text-center">
                            <label class="fancy-checkbox">
                                <input id="ocbListItem<?php echo $aDataTableVal['rtRowID']?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                <span></span>
                            </label>
                            <td><label><?php echo $aDataTableVal['rtRowID']?></label></td>
                            <?php foreach($aColumnShow as $DataKey => $DataVal): ?>
                            <?php
                                $tColumnName        = $DataVal->FTShwFedShw;
                                $nColWidth          = $DataVal->FNShwColWidth;
                                $tColumnDataType    = substr($tColumnName, 0, 2);
                                if($tColumnDataType == 'FC'){
                                    $tMaxlength     = '11';
                                    $tAlignFormat   = 'text-right';
                                    $tDataCol       =  $aDataTableVal[$tColumnName] != '' ? number_format($aDataTableVal[$tColumnName], $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow,'.',',');
                                    $InputType      = 'text';
                                    $tValidateType  = 'xCNInputNumericWithDecimal';
                                }
                                if($tColumnDataType == 'FN'){
                                    $tMaxlength     = '';
                                    $tAlignFormat   = 'text-right';
                                    $tDataCol       = $aDataTableVal[$tColumnName] != '' ? number_format($aDataTableVal[$tColumnName], $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow,'.',',');
                                    $InputType      = 'number';
                                    $tValidateType  = '';
                                }
                                if($tColumnDataType == 'FD'){
                                    $tMaxlength     = '';
                                    $tAlignFormat   = 'text-left';
                                    $tDataCol       = date('Y-m-d H:i:s');
                                    $InputType      = 'text';
                                    $tValidateType  = '';
                                }
                                if($tColumnDataType == 'FT'){
                                    $tMaxlength     = '';
                                    $tAlignFormat   = 'text-left';
                                    $tDataCol       = $aDataTableVal[$tColumnName];
                                    $InputType      = 'text';
                                    $tValidateType  = '';
                                }
                            ?>
                                <td nowrap class="<?php echo $tAlignFormat?>">
                                    <?php if($DataVal->FTShwStaAlwEdit == 1 && in_array($tColumnName, ['FCXtdQty', 'FCXtdSetPrice', 'FTXtdDisChgTxt']) && (empty($tPIStaApv) && $tPIStaDoc != 3)):?>
                                        <?php if($tColumnName == 'FTXtdDisChgTxt' && $aDataTableVal['FTXtdStaAlwDis'] == '1'):?>
                                            <div class="xWPIDisChgDTForm">
                                                <button class="xCNBTNPrimeryDisChgPlus" onclick="JCNvPICallModalDisChagDT(this)" type="button">+</button>
                                                <label class="xWPIDisChgDT" id="olbPIDisChgDT<?php echo $aDataTableVal['rtRowID']?>">&nbsp;<?php echo $aDataTableVal[$tColumnName];?></label>
                                            </div>
                                        <?php else:?>
                                            <label 
                                                data-field="<?php echo $tColumnName?>"
                                                data-seq="<?php echo $aDataTableVal['FNXtdSeqNo']?>"
                                                data-demo="TextDEmo"
                                                class="xCNPdtFont xWShowInLine<?php echo $aDataTableVal['rtRowID']?> xWShowValue<?php echo $tColumnName?><?php echo $aDataTableVal['rtRowID']?>"
                                            >
                                            <?php if($tColumnName != 'FTXtdDisChgTxt'){ ?>
                                                <?php echo  $tDataCol != '' ? "".$tDataCol : '1'; ?>
                                                <?php }else {  echo  language('document/saleorder/saleorder','tSODiscountisnotallowed');  } ?>
                                            </label>
                                            <?php if($tColumnName != 'FTXtdDisChgTxt'){ ?>
                                            <div class="xCNHide xWEditInLine<?php echo $aDataTableVal['FNXtdSeqNo']?>">
                                                <input 
                                                    type="<?php echo $InputType?>" 
                                                    class="form-control xCNPdtEditInLine xWValueEditInLine<?php echo $aDataTableVal['rtRowID']?> <?php echo $tValidateType?> <?php echo $tAlignFormat;?>"
                                                    id="ohd<?php echo $tColumnName?><?php echo $aDataTableVal['rtRowID']?>" 
                                                    name="ohd<?php echo $tColumnName?><?php echo $aDataTableVal['rtRowID']?>" 
                                                    maxlength="<?php echo $tMaxlength?>" 
                                                    value="<?php echo $tDataCol;?>"
                                                    <?php echo $tColumnName == 'FTXtdDisChgTxt' ? 'readonly' : '' ?> <?php echo  $tColumnName == 'FCXtdQty'; ?>>
                                            </div>     
                                            <?php } ?>                         
                                        <?php endif;?>
                                    <?php else: ?>
                                        <label class="xCNPdtFont xWShowInLine xWShowValue<?php echo $tColumnName?><?php echo $aDataTableVal['rtRowID']?>"><?php echo $tDataCol?></label>
                                    <?php endif;?>                  
                                </td>
                            <?php endforeach; ?>
                            <td nowrap class="text-center xCNPIBeHideMQSS">
                                <label class="xCNTextLink">
                                    <img class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" title="Remove" onclick="JSnPIDelPdtInDTTempSingle(this)">
                                </label>
                            </td>
                            <td class="xCNPIBeHideMQSS"></td>
                        </tr>
                        <?php $nNumSeq++; ?>
                    <?php endforeach;?>
                <?php else:?>
                    <tr><td class="text-center xCNTextDetail2 xWPITextNotfoundDataPdtTable" colspan="100%"><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php endif;?>
            </tbody>
        </table>
    </div>
</div>
<?php if($aDataDocDTTemp['rnAllPage'] > 1) : ?>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aDataDocDTTemp['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aDataDocDTTemp['rnCurrentPage']?> / <?php echo $aDataDocDTTemp['rnAllPage']?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPagePIPdt btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvPIPDTDocDTTempClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataDocDTTemp['rnAllPage'],$nPage+2)); $i++){?> 
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvPIPDTDocDTTempClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataDocDTTemp['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvPIPDTDocDTTempClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
<?php endif;?>

<!-- ============================================ Modal Confirm Delete Documet Detail Dis ============================================ -->
    <div id="odvPIModalConfirmDeleteDTDis" class="modal fade" style="z-index: 7000;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?= language('common/main/main', 'tPIMsgNotificationChangeData') ?></label>
                </div>
                <div class="modal-body">
                    <label><?php echo language('document/purchaseinvoice/purchaseinvoice','tPIMsgTextNotificationChangeData');?></label>
                </div>
                <div class="modal-footer">
                    <button id="obtPIConfirmDeleteDTDis" type="button"  class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tModalConfirm');?></button>
                    <button id="obtPICancelDeleteDTDis" type="button" class="btn xCNBTNDefult"><?php echo language('common/main/main', 'ยกเลิก');?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ================================================================================================================================= -->

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php  include("script/jPurchaseInvoicePdtAdvTableData.php");?>
