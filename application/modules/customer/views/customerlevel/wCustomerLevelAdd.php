<?php
if($aResult['rtCode'] == "1"){
    $tCstLevCode       = $aResult['raItems']['rtCstLevCode'];
    $tCstLevName       = $aResult['raItems']['rtCstLevName'];
    $tCstLevRmk        = $aResult['raItems']['rtCstLevRmk'];
    $tRoute         = "customerLevelEventEdit";
}else{
    $tCstLevCode       = "";
    $tCstLevName       = "";
    $tCstLevRmk        = "";
    $tRoute         = "customerLevelEventAdd";
}
?>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCstLev">
    <button style="display:none" type="submit" id="obtSubmitCstLev" onclick="JSnAddEditCstLev('<?= $tRoute?>')"></button>
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('customer/customerlevel/customerlevel','tCstLevCode'); ?><?= language('customer/customerlevel/customerlevel','tCstLevTitle')?></label>
                <div id="odvCstLevAutoGenCode" class="form-group">
                <div class="validate-input">
                <label class="fancy-checkbox">
                    <input type="checkbox" id="ocbCustomerLevelAutoGenCode" name="ocbCustomerLevelAutoGenCode" checked="true" value="1">
                    <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                </label>
            </div>
        </div>
            <div id="odvCstLevCodeForm" class="form-group">
                <input type="hidden" id="ohdCheckDuplicateCstLevCode" name="ohdCheckDuplicateCstLevCode" value="1">  
                        <div class="validate-input">
                        <input 
                        type="text" 
                        class="form-control xCNGenarateCodeTextInputValidate" 
                        maxlength="5" 
                        id="oetCstLevCode" 
                        name="oetCstLevCode"
                        data-is-created="<?php echo $tCstLevCode;?>"
                        placeholder="<?php echo language('customer/customerlevel/customerlevel','tCstLevTBCode'); ?>"
                        value="<?= $tCstLevCode; ?>" 
                        data-validate-required = "<?= language('customer/customerlevel/customerlevel','tCstLevValidCode')?>"
                        data-validate-dublicateCode = "<?= language('customer/customerlevel/customerlevel','tCstLevValidCheckCode')?>"
                    >
                </div>
            </div>
        </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="validate-input" data-validate="Please Insert Name">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('customer/customerlevel/customerlevel','tCstLevName')?><?= language('customer/customerlevel/customerlevel','tCstLevCustomer')?></label>
                        <input type="text" class="input100" maxlength="100" id="oetCstLevName" name="oetCstLevName" value="<?= $tCstLevName ?>"
                        data-validate-required = "<?= language('customer/customerlevel/customerlevel','tCstLevvalidateName')?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><?= language('customer/customerlevel/customerlevel','tCstLevNote')?></label>
                                <textarea maxlength="100" rows="4" id="otaCstLevRemark" name="otaCstLevRemark"><?= $tCstLevRmk ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js');?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js');?>"></script>
<?php include "script/jCustomerLevelAdd.php";?>
<script type="text/javascript">
    $('.xWTooltipsBT').tooltip({'placement': 'bottom'});
    $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});

    $('#oimCstLevBrowseProvince').click(function(){
        JCNxBrowseData('oPvnOption');
    });

    if(JCNCstLevIsUpdatePage()){
        $("#obtGenCodeCstLev").attr("disabled", true);
    }
</script>
