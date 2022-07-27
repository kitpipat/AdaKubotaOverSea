<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "pdtsizeEventEdit"; 
        $tPszCode   = $aPszData['raItems']['rtPszCode'];
        $tPszName   = $aPszData['raItems']['rtPszName'];
        $tPszRmk    = $aPszData['raItems']['rtPszRmk'];
    }else{
        $tRoute     = "pdtsizeEventAdd";
        $tPszCode   = "";
        $tPszName   = "";
        $tPszRmk    = "";
    }
?>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddPdtPsz">
    <!-- <input type="hidden" id="ohdPdtGroupRoute" value="<?php echo $tRoute; ?>"> -->
    <button style="display:none" type="submit" id="obtSubmitPdtPsz" onclick="JSoAddEditPdtPsz('<?= $tRoute?>')"></button>
    <div class="panel panel-headline"><!-- เพิ่มมาใหม่ --> 
        <div class="panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5"> <!-- เปลี่ยน Col Class -->
                <div class="form-group">
                        <input type="hidden" value="0" id="ohdCheckPszClearValidate" name="ohdCheckPszClearValidate"> 
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdtsize/pdtsize','tPSZCode')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <?php
                        if($tRoute=="pdtsizeEventAdd"){
                        ?>
                        <div class="form-group" id="odvPgpAutoGenCode">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbPszAutoGenCode" name="ocbPszAutoGenCode" checked="true" value="1">
                                    <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group" id="odvPunCodeForm">
                            <input 
                                type="text" 
                                class="form-control xCNInputWithoutSpcNotThai" 
                                maxlength="5" 
                                id="oetPszCode" 
                                name="oetPszCode"
                                data-is-created="<?php  ?>"
                                placeholder="<?= language('product/pdtsize/pdtsize','tPSZCode')?>"
                                value="<?php  ?>" 
                                data-validate-required="<?php echo language('product/pdtgroup/pdtgroup','tPSZValidCode')?>"
                                data-validate-dublicateCode="<?php echo language('product/pdtsize/pdtsize','tPSZVldCodeDuplicate')?>"
                                readonly
                                onfocus="this.blur()">
                            <input type="hidden" value="2" id="ohdCheckDuplicatePszCode" name="ohdCheckDuplicatePszCode"> 
                        </div>
                        <?php
                        }else{
                        ?>
                        <div class="form-group" id="odvPunCodeForm">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                <input 
                                    type="text" 
                                    class="form-control xCNInputWithoutSpcNotThai" 
                                    maxlength="5" 
                                    id="oetPszCode" 
                                    name="oetPszCode"
                                    data-is-created="<?php  ?>"
                                    placeholder="<?= language('product/pdtsize/pdtsize','tPSZCode')?>"
                                    value="<?php echo $tPszCode; ?>" 
                                    readonly
                                    onfocus="this.blur()">
                                </label>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdtsize/pdtsize','tPSZFrmPszName')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="text" class="form-control xCNInputWithoutSingleQuote" maxlength="50" id="oetPszName" name="oetPszName" autocomplete="off"  value="<?=$tPszName?>" 
                        placeholder="<?= language('product/pdtsize/pdtsize','tPSZFrmPszName')?>"
                        autocomplete="off"
                        data-validate-required="<?= language('product/pdtsize/pdtsize','tPSZValidName')?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('product/pdtsize/pdtsize','tPSZFrmPszRmk')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <textarea class="form-control" maxlength="100" rows="4" id="otaPszRmk" name="otaPszRmk"><?=$tPszRmk?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('#obtGenCodePdtPsz').click(function(){
        JStGeneratePdtPszCode();
    });
</script>