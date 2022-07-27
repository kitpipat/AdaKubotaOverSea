<?php
if($aResult['rtCode'] == "1"){
    $tCstGrpCode       = $aResult['raItems']['rtCstGrpCode'];
    $tCstGrpName       = $aResult['raItems']['rtCstGrpName'];
    $tCstGrpRmk        = $aResult['raItems']['rtCstGrpRmk'];
    $tRoute         = "customerGroupEventEdit";
}else{
    $tCstGrpCode       = "";
    $tCstGrpName       = "";
    $tCstGrpRmk        = "";
    $tRoute         = "customerGroupEventAdd";
}
?>
<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCstGrp">
    <button style="display:none" type="submit" id="obtSubmitCstGrp" onclick="JSnAddEditCstGrp('<?= $tRoute?>')"></button>
    <div style="margin-top:15px;">
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('customer/customergroup/customergroup','tCstGrpCode'); ?><?= language('customer/customergroup/customergroup','tCstGrpTitle')?></label>
                <div id="odvCstGrpAutoGenCode" class="form-group">
                <div class="validate-input">
                <label class="fancy-checkbox">
                    <input type="checkbox" id="ocbCustomerGroupAutoGenCode" name="ocbCustomerGroupAutoGenCode" checked="true" value="1">
                    <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                </label>
            </div>
        </div>
        <div id="odvCstGrpCodeForm" class="form-group">
                <input type="hidden" id="ohdCheckDuplicateCstGrpCode" name="ohdCheckDuplicateCstGrpCode" value="1">  
                    <div class="validate-input">
                        <input 
                        type="text" 
                        class="form-control xCNGenarateCodeTextInputValidate" 
                        maxlength="5" 
                        id="oetCstGrpCode" 
                        name="oetCstGrpCode"
                        data-is-created="<?php echo $tCstGrpCode;?>"
                        placeholder="<?php echo language('customer/customergroup/customergroup','tCstGrpTBCode'); ?>"
                        value="<?= $tCstGrpCode; ?>" 
                        autocomplete="off"
                        data-validate-required = "<?= language('customer/customergroup/customergroup','tCstValidCode')?>"
                        data-validate-dublicateCode = "<?= language('customer/customergroup/customergroup','tCstValidCheckCode')?>"
                        >
                    </div>
            </div>
        </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <div class="validate-input"  data-validate="<?php echo language('customer/customergroup/customergroup','tCstName'); ?>">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('customer/customergroup/customergroup','tCstGrpName')?><?= language('customer/customergroup/customergroup','tCstGrpTitle')?></label>
                        <input type="text" 
                        class="form-control" 
                        maxlength="100" 
                        id="oetCstGrpName" 
                        name="oetCstGrpName" 
                        placeholder="<?= language('customer/customergroup/customergroup','tCstGrpName')?><?= language('customer/customergroup/customergroup','tCstGrpTitle')?>"
                        autocomplete="off"
                        value="<?= $tCstGrpName ?>"
                        data-validate-required="<?= language('customer/customergroup/customergroup','tCstValidName')?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><?= language('customer/customergroup/customergroup','tCstGrpRemark')?></label>
                                <textarea maxlength="100" rows="4" id="otaCstGrpRemark" name="otaCstGrpRemark"><?= $tCstGrpRmk ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include "script/jCustomerGroupAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script type="text/javascript">
$('.xWTooltipsBT').tooltip({'placement': 'bottom'});
$('[data-toggle="tooltip"]').tooltip({'placement': 'top'});

$('#oimCstGrpBrowseProvince').click(function(){
	JCNxBrowseData('oPvnOption');
});

if(JCNCstGrpIsUpdatePage()){
    $("#obtGenCodeCstGrp").attr("disabled", true);
}
</script>
