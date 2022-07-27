<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "pdtunitEventEdit";
        $tPunCode   = $aPunData['raItems']['rtPunCode'];
        $tPunName   = $aPunData['raItems']['rtPunName'];
    }else{
        $tRoute     = "pdtunitEventAdd";
        $tPunCode   = "";
        $tPunName   = "";
    }
?>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddPdtUnit">
    <button style="display:none" type="submit" id="obtSubmitPdtUnit" onclick="JSoAddEditPdtUnit('<?php echo $tRoute?>')"></button>
    <input type="hidden" id="ohdPdtunitRoute" value="<?php echo $tRoute; ?>">
        <div class="panel-body" style="padding-top:20px !important;">
                <div class="col-xs-12 col-md-5 col-lg-5">
                    <input type="hidden" value="0" id="ohdCheckPunClearValidate" name="ohdCheckPunClearValidate"> 
                    <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('product/pdtunit/pdtunit','tPUNFrmPunCode')?></label>
                    <?php
                    if($tRoute=="pdtunitEventAdd"){
                    ?>
                    <div class="form-group" id="odvPunAutoGenCode">
                        <div class="validate-input">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbPunAutoGenCode" name="ocbPunAutoGenCode" checked="true" value="1">
                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group" id="odvPunCodeForm">
                        <input 
                            type="text" 
                            class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                            maxlength="5" 
                            id="oetPunCode" 
                            name="oetPunCode"
                            data-is-created="<?php echo $tPunCode; ?>"
                            placeholder="<?= language('product/pdtunit/pdtunit','tPUNFrmPunCode')?>"
                            value="<?php echo $tPunCode; ?>" 
                            data-validate-required="<?php echo language('product/pdtunit/pdtunit','tPunVldCode')?>"
                            data-validate-dublicateCode="<?php echo language('product/pdtunit/pdtunit','tPunVldCodeDuplicate')?>"
                            readonly
                            onfocus="this.blur()">
                        <input type="hidden" value="2" id="ohdCheckDuplicatePunCode" name="ohdCheckDuplicatePunCode"> 
                    </div>
                    <?php
                    }else{
                    ?>
                    
                    <div class="form-group" id="odvPunCodeForm">
                        <input 
                            type="text" 
                            class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                            maxlength="5" 
                            id="oetPunCode" 
                            name="oetPunCode"
                            data-is-created="<?php echo $tPunCode; ?>"
                            placeholder="<?= language('product/pdtunit/pdtunit','tPUNFrmPunCode')?>"
                            value="<?php echo $tPunCode; ?>" 
                            data-validate-required="<?php echo language('product/pdtunit/pdtunit','tPunVldCode')?>"
                            data-validate-dublicateCode="<?php echo language('product/pdtunit/pdtunit','tPunVldCodeDuplicate')?>"
                            readonly
                            onfocus="this.blur()">
                        <input type="hidden" value="2" id="ohdCheckDuplicatePunCode" name="ohdCheckDuplicatePunCode"> 
                    </div>
                    <?php
                    }
                    ?>

                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('product/pdtunit/pdtunit','tPUNFrmPunName')?></label>
                        <input type="text" class="form-control" maxlength="50" id="oetPunName" name="oetPunName" 
                        placeholder="<?php echo language('product/pdtunit/pdtunit','tPUNFrmPunName')?>"
                        autocomplete="off"
                        data-validate-required="<?php echo language('product/pdtunit/pdtunit','tPUNVldName')?>" value="<?php echo $tPunName ?>">
                    </div>
                </div>
            </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('#obtGenCodePdtUnit').click(function(){
        JStGeneratePdtUnitCode();
    });
</script>

