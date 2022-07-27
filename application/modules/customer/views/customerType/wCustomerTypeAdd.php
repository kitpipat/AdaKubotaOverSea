<?php
if($aResult['rtCode'] == "1"){
    $tCstTypeCode       = $aResult['raItems']['rtCstTypeCode'];
    $tCstTypeName       = $aResult['raItems']['rtCstTypeName'];
    $tCstTypeRmk        = $aResult['raItems']['rtCstTypeRmk'];
    $tRoute         = "customerTypeEventEdit";
}else{
    $tCstTypeCode       = "";
    $tCstTypeName       = "";
    $tCstTypeRmk        = "";
    $tRoute         = "customerTypeEventAdd";
}
?>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCstType">
    <button style="display:none" type="submit" id="obtSubmitCstType" onclick="JSnAddEditCstType('<?= $tRoute?>')"></button>
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('customer/customertype/customertype','tCstTypeCode')?><?= language('customer/customertype/customertype','tCstTypeTitle')?></label>
                    <div id="odvCstTypeAutoGenCode" class="form-group">
                        <div class="validate-input">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbCstTypeAutoGenCode" name="ocbCstTypeAutoGenCode" checked="true" value="1">
                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                            </label>
                        </div>
                    </div>
                    <div id="odvCustomerTypeCodeForm" class="form-group">
                        <input type="hidden" id="ohdCheckDuplicateCstTypeCode" name="ohdCheckDuplicateCstTypeCode" value="1"> 
                        <div class="validate-input">
                            <input 
                                type="text" 
                                class="form-control xCNGenarateCodeTextInputValidate" 
                                maxlength="5" 
                                id="oetCstTypeCode" 
                                name="oetCstTypeCode"
                                data-is-created="<?php echo $tCstTypeCode;?>"
                                placeholder="<?= language('customer/customertype/customertype','tCstTypeTBCode')?>"
                                value="<?php echo $tCstTypeCode; ?>" 
                                data-validate-required = "<?= language('customer/customertype/customertype','tCstTypeValidCode')?>"
                                data-validate-dublicateCode = "<?= language('customer/customertype/customertype','tCstTypeValidCheckCode')?>"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="validate-input" data-validate="<?= language('customer/customertype/customertype','tCstTypeValidName')?>">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('customer/customertype/customertype','tCstTypeName')?><?= language('customer/customertype/customertype','tCstTypeTitle')?></label>
                        <input type="text" class="input100" maxlength="100" id="oetCstTypeName" name="oetCstTypeName" value="<?= $tCstTypeName ?>"
                        placeholder="<?= language('customer/customertype/customertype','tCstTypeValidName')?>"
                        data-validate-required = "<?= language('customer/customertype/customertype','tCstTypeValidName')?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><?= language('customer/customertype/customertype','tCstTypeNote')?></label>
                                <textarea maxlength="100" rows="4" id="otaCstTypeRemark" name="otaCstTypeRemark"><?= $tCstTypeRmk ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php include "script/jCustomerTypeAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script type="text/javascript">
$('.xWTooltipsBT').tooltip({'placement': 'bottom'});
$('[data-toggle="tooltip"]').tooltip({'placement': 'top'});

$('#oimCstTypeBrowseProvince').click(function(){
	JCNxBrowseData('oPvnOption');
});

if(JCNbCstTypeIsUpdatePage()){
    $("#obtGenCodeCstType").attr("disabled", true);
}
</script>
