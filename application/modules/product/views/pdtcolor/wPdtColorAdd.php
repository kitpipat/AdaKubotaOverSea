<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute      = "pdtcolorEventEdit"; 
        $tClrCode    = $aClrData['raItems']['rtClrCode'];
        $tClrIdColor = $aClrData['raItems']['rtClrIdColor'];
        $tClrName    = $aClrData['raItems']['rtClrName'];
        $tClrRmk     = $aClrData['raItems']['rtClrRmk'];
    }else{
        $tRoute      = "pdtcolorEventAdd";
        $tClrCode    = "";
        $tClrIdColor = "";
        $tClrName    = "";
        $tClrRmk     = "";
    }
?>


<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddPdtClr">
    <button style="display:none" type="submit" id="obtSubmitPdtClr" onclick="JSoAddEditPdtClr('<?= $tRoute?>')"></button>
    <input type="hidden" id="ohdClrRoute" value="<?php echo $tRoute; ?>">
    <div class="panel panel-headline"><!-- เพิ่มมาใหม่ --> 
        <div class="panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5"> <!-- เปลี่ยน Col Class -->
                    <div class="form-group">
                        <input type="hidden" value="0" id="ohdCheckClrClearValidate" name="ohdCheckClrClearValidate"> 
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdtcolor/pdtcolor','tCLRFrmClrCode')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <?php
                        if($tRoute=="pdtcolorEventAdd"){
                        ?>
                        <div class="form-group" id="odvPgpAutoGenCode">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbClrAutoGenCode" name="ocbClrAutoGenCode" checked="true" value="1">
                                    <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group" id="odvPunCodeForm">
                            <input 
                                type="text" 
                                class="form-control xCNGenarateCodeTextInputValidate" 
                                maxlength="5" 
                                id="oetClrCode" 
                                name="oetClrCode"
                                data-is-created="<?php  ?>"
                                placeholder="<?= language('product/pdtcolor/pdtcolor','tCLRFrmClrCode')?>"
                                value="<?php  ?>" 
                                data-validate-required="<?= language('product/pdtcolor/pdtcolor','tCLRValidCode')?>"
                                data-validate-dublicateCode="<?php echo language('product/pdtcolor/pdtcolor','tCLRValidDuplicateCode')?>"
                                readonly
                                onfocus="this.blur()">
                            <input type="hidden" value="2" id="ohdCheckDuplicateClrCode" name="ohdCheckDuplicateClrCode"> 
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
                                    id="oetClrCode" 
                                    name="oetClrCode"
                                    data-is-created="<?php  ?>"
                                    placeholder="<?= language('product/pdtcolor/pdtcolor','tCLRFrmClrCode')?>"
                                    value="<?php echo $tClrCode; ?>" 
                                    readonly
                                    onfocus="this.blur()">
                                </label>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('product/pdtcolor/pdtcolor','tCLRFrmClrName')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="text" class="form-control" maxlength="50" id="oetClrName" name="oetClrName" value="<?=$tClrName?>" 
                        autocomplete="off"
                        placeholder="<?php echo language('product/pdtcolor/pdtcolor','tCLRFrmClrName')?>"
                        data-validate-required="<?= language('product/pdtcolor/pdtcolor','tCLRValidName')?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                    </div>

                    <div class="form-group">
                        <input type="color" id="oetClrIdCode" name="oetClrIdCode" value="<?=$tClrIdColor?>">
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('product/pdtcolor/pdtcolor','tCLRFrmClrRmk')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <textarea class="form-control" maxlength="100" rows="4" id="otaClrRmk" name="otaClrRmk"><?=$tClrRmk?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('#obtGenCodePdtClr').click(function(){
        JStGeneratePdtClrCode();
    });
</script>