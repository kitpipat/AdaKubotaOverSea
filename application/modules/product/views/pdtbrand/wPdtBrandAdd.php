<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "pdtbrandEventEdit"; 
        $tPbnCode   = $aPbnData['raItems']['rtPbnCode'];
        $tPbnName   = $aPbnData['raItems']['rtPbnName'];
        $tPbnRmk    = $aPbnData['raItems']['rtPbnRmk'];
    }else{
        $tRoute     = "pdtbrandEventAdd";
        $tPbnCode   = "";
        $tPbnName   = "";
        $tPbnRmk    = "";
    }
?>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddPdtPbn">
    <input type="hidden" id="ohdPbnRoute" value="<?php echo $tRoute; ?>">
    <button style="display:none" type="submit" id="obtSubmitPdtPbn" onclick="JSoAddEditPdtPbn('<?= $tRoute?>')"></button>
    <div class="panel panel-headline"><!-- เพิ่มมาใหม่ --> 
        <div class="panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5"> <!-- เปลี่ยน Col Class -->
                    <div class="form-group">
                        <input type="hidden" value="0" id="ohdCheckPbnClearValidate" name="ohdCheckPbnClearValidate"> 
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdtbrand/pdtbrand','tPBNFrmPbnCode')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <?php
                        if($tRoute=="pdtbrandEventAdd"){
                        ?>
                        <div class="form-group" id="odvPgpAutoGenCode">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbPbnAutoGenCode" name="ocbPbnAutoGenCode" checked="true" value="1">
                                    <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group" id="odvPunCodeForm">
                            <input 
                                type="text" 
                                class="form-control xCNInputWithoutSpcNotThai" 
                                maxlength="5" 
                                id="oetPbnCode" 
                                name="oetPbnCode"
                                data-is-created="<?php  ?>"
                                placeholder="<?= language('product/pdtbrand/pdtbrand','tPBNFrmPbnCode')?>"
                                value="<?php  ?>" 
                                data-validate-required="<?php echo language('product/pdtbrand/pdtbrand','tPBNValidCode')?>"
                                data-validate-dublicateCode="<?php echo language('product/pdtbrand/pdtbrand','tPBNValidDuplicate')?>"
                                readonly
                                onfocus="this.blur()">
                            <input type="hidden" value="2" id="ohdCheckDuplicatePbnCode" name="ohdCheckDuplicatePbnCode"> 
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
                                    id="oetPbnCode" 
                                    name="oetPbnCode"
                                    autocomplete="off"
                                    data-is-created="<?php  ?>"
                                    placeholder="<?= language('product/pdtbrand/pdtbrand','tPBNFrmPbnCode')?>"
                                    value="<?php echo $tPbnCode; ?>" 
                                    readonly
                                    onfocus="this.blur()">
                                </label>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdtbrand/pdtbrand','tPBNFrmPbnName')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="text" class="form-control" maxlength="50" id="oetPbnName" name="oetPbnName" value="<?=$tPbnName?>" 
                        placeholder="<?= language('product/pdtbrand/pdtbrand','tPBNFrmPbnName')?>"
                        autocomplete="off"
                        data-validate-required="<?= language('product/pdtbrand/pdtbrand','tPBNValidName')?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('product/pdtbrand/pdtbrand','tPBNFrmPbnRmk')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <textarea class="form-control" maxlength="100" rows="4" id="otaPbnRmk" name="otaPbnRmk"><?=$tPbnRmk?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('#obtGenCodePdtPbn').click(function(){
        JStGeneratePdtPbnCode();
    });
</script>