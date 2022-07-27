<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "pdtmodelEventEdit"; 
        $tPmoCode   = $aPmoData['raItems']['rtPmoCode'];
        $tPmoName   = $aPmoData['raItems']['rtPmoName'];
        $tPmoRmk    = $aPmoData['raItems']['rtPmoRmk'];
    }else{
        $tRoute     = "pdtmodelEventAdd";
        $tPmoCode   = "";
        $tPmoName   = "";
        $tPmoRmk    = "";
    }
?>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddPdtPmo">
    <button style="display:none" type="submit" id="obtSubmitPdtPmo" onclick="JSoAddEditPdtPmo('<?= $tRoute?>')"></button>
    <input type="hidden" id="ohdPmoRoute" value="<?php echo $tRoute; ?>">
    <div class="panel panel-headline"><!-- เพิ่มมาใหม่ --> 
        <div class="panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5"> <!-- เปลี่ยน Col Class -->
                    <div class="form-group">
                        <input type="hidden" value="0" id="ohdCheckPmoClearValidate" name="ohdCheckPmoClearValidate"> 
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdtmodel/pdtmodel','tPMOFrmPmoCode')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <?php
                        if($tRoute=="pdtmodelEventAdd"){
                        ?>
                        <div class="form-group" id="odvPgpAutoGenCode">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbPmoAutoGenCode" name="ocbPmoAutoGenCode" checked="true" value="1">
                                    <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group" id="odvPunCodeForm">
                            <input 
                                type="text" 
                                class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                                maxlength="5" 
                                id="oetPmoCode" 
                                name="oetPmoCode"
                                data-is-created="<?php  ?>"
                                placeholder="<?= language('product/pdtmodel/pdtmodel','tPMOFrmPmoCode')?>"
                                value="<?php  ?>" 
                                data-validate-required="<?php echo language('product/pdtmodel/pdtmodel','tPMOValidCode')?>"
                                data-validate-dublicateCode="<?php echo language('product/pdtmodel/pdtmodel','tPMOValidDuplicateCode')?>"
                                readonly
                                onfocus="this.blur()">
                            <input type="hidden" value="2" id="ohdCheckDuplicatePmoCode" name="ohdCheckDuplicatePmoCode"> 
                        </div>
                        <?php
                        }else{
                        ?>
                        <div class="form-group" id="odvPunCodeForm">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                <input 
                                    type="text" 
                                    class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                                    maxlength="5" 
                                    id="oetPmoCode" 
                                    name="oetPmoCode"
                                    data-is-created="<?php  ?>"
                                    placeholder="<?= language('product/pdtmodel/pdtmodel','tPMOFrmPmoCode')?>"
                                    value="<?php echo $tPmoCode; ?>" 
                                    readonly
                                    onfocus="this.blur()">
                                </label>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdtmodel/pdtmodel','tPMOFrmPmoName')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="text" class="form-control" 
                        placeholder="<?= language('product/pdtmodel/pdtmodel','tPMOFrmPmoName')?>"
                        autocomplete="off"
                        maxlength="50" id="oetPmoName" name="oetPmoName" value="<?=$tPmoName?>" 
                        data-validate-required="<?= language('product/pdtmodel/pdtmodel','tPMOValidName')?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('product/pdtmodel/pdtmodel','tPMOFrmPmoRmk')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <textarea class="form-control" maxlength="100" rows="4" id="otaPmoRmk" name="otaPmoRmk"><?=$tPmoRmk?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('#obtGenCodePdtPmo').click(function(){
        JStGeneratePdtPmoCode();
    });
</script>