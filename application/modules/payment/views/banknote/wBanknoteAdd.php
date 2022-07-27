<?php
    //Decimal Save
    $tDecSave = FCNxHGetOptionDecimalShow();
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute         = "banknoteEventEdit"; 
        $tBntCode       = $aBntData['raItems']['rtBntCode'];
        $tBntName       = $aBntData['raItems']['rtBntName'];
        $tBnnAmt        = number_format($aBntData['raItems']['rtBntAmt'],$tDecSave);
        $tBntRmk        = $aBntData['raItems']['rtBntRmk'];
    }else{
        $tRoute         = "banknoteEventAdd";
        $tBntCode       = "";
        $tBntName       = "";
        $tBnnAmt        = "0.00";
        $tBntRmk        = "";
    }
?>
<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddBnt">
    <button style="display:none" type="submit" id="obtSubmitBnt" onclick="JSxBanknoteValidateForm('<?= $tRoute?>')"></button>
    <div class="panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
        <div class="row">   
            <div class="col-md-4">
                <div class="form-group">
                    <div id="odvBntImage">
                        <?php 
                            if(isset($tImgObjAll) && !empty($tImgObjAll)){
                                $tFullPatch = './application/modules/'.$tImgObjAll;                        
                                if (file_exists($tFullPatch)){
                                    $tPatchImg = base_url().'/application/modules/'.$tImgObjAll;
                                }else{
                                    $tPatchImg = base_url().'application/modules/common/assets/images/300x60.png';
                                }
                            }else{
                                $tPatchImg = base_url().'application/modules/common/assets/images/300x60.png';
                            }
                        ?>
                        <img id="oimImgMasterBanknote" class="img-responsive xCNImgCenter" src="<?php echo @$tPatchImg;?>">
                    </div>
                    <div class="form-group">
                        <div class="xCNUplodeImage">
                            <input type="text" class="xCNHide" id="oetImgInputBanknote"     name="oetImgInputBanknote"      value="<?php echo @$tImgName;?>">
                            <input type="text" class="xCNHide" id="oetImgInputBanknoteOld"  name="oetImgInputBanknoteOld"   value="<?php echo @$tImgName;?>">
                            <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('','','Banknote')">
                                <i class="fa fa-picture-o xCNImgButton"></i> <?php echo language('common/main/main','tSelectPic');?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-5 col-lg-5">
                <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('payment/banknote/banknote','tBNTFrmBntCode')?></label>
                <div class="from-group" id="odvBanknoteAutoGenCode">
                    <div class="validate-input">
                        <label class="fancy-checkbox">
                            <input type="checkbox" id="ocbBanknoteAutoGenCode" name="ocbBanknoteAutoGenCode" checked="true" value="1">
                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                        </label>
                    </div>
                </div>
                <div class="form-group" id="odvBanknoteCodeForm">
                    <input type="hidden" id="ohdCheckDuplicateBntCode" name="ohdCheckDuplicateBntCode" value="1">
                    <div class="validate-input">
                        <input
                            type="text"
                            class="form-control xCNInputWithoutSpcNotThai"
                            maxlength="5"
                            id="oetBntCode"
                            name="oetBntCode"
                            data-is-created="<?php echo $tBntCode; ?>"
                            placeholder ="#####"
                            value="<?php echo $tBntCode;?>"
                            data-validate-required = "<?php echo language('payment/banknote/banknote','tBNTValidCode')?>"
                            data-validate-dublicateCode ="<?php echo language('payment/banknote/banknote','tBNTValidCodeDup');?>"
                        >
                    </div>
                </div>
                <div class="form-group">
                    <div class="validate-input">
                    <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('payment/banknote/banknote','tRTEFrmBntName')?></label> 
                        <input 
                            type="text"
                            class="form-control xCNInputWithoutSpc"
                            maxlength="200"
                            id="oetBntName"
                            name="oetBntName"
                            value="<?php echo $tBntName;?>"
                            data-validate-required="<?php echo language('payment/banknote/banknote','tBNTValidName')?>"
                        >
                    </div>
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('payment/banknote/banknote','tAmount')?></label> <!-- เปลี่ยนชื่อ Class  --> <!-- onfocusout="JCNdValidatelength8Decimal('oetBntAmt','FC',4,'<?php echo $tDecSave?>')" --> <!-- onclick="JCNdValidateComma('oetBntAmt',4, 'FC');" -->
                    <input type="text" class="form-control xCNInputNumericWithDecimal text-right" maxlength="50" id="oetBntAmt" name="oetBntAmt"  value="<?=$tBnnAmt?>" 
                    data-validate="<?= language('payment/banknote/banknote','tBntValidName')?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                </div>
                <div class="form-group">
                    <div class="validate-input">
                        <label class="xCNLabelFrm"><?= language('payment/banknote/banknote','tBNTFrmBNTRmk')?></label>
                        <textarea class="form-control" maxlength="100" rows="4" id="otaBntRemark" name="otaBntRemark"><?php echo $tBntRmk; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php include 'script/jBanknoteAdd.php';?>

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
<script>
    $('#obtGenCodeBnt').click(function(){
        JStGenerateBntCode();
    });
</script>