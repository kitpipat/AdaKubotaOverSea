<?php
    //Decimal Save
    $tDecSave = FCNxHGetOptionDecimalShow();
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute         = "banknoteEventEdit"; 
        $tBntCode       = $aBntData['raItems']['rtBntCode'];
        $tBntName       = $aBntData['raItems']['rtBntName'];
        $tBnnAmt        = number_format($aBntData['raItems']['rtBntAmt'],$tDecSave);
        $tBntRmk        = $aBntData['raItems']['rtBntRmk'];
        $tBntStaShw     = $aBntData['raItems']['rtBntStaShw'];

        $tBntAgnCode       = $aBntData['raItems']['rtAgnCode'];
        $tBntAgnName       = $aBntData['raItems']['rtAgnName'];

        $tBntCurrencyCode  = $aBntData['raItems']['rtRteCode'];
        $tBntCurrencyName  = ($aBntData['raItems']['rtRteName']) ? $aBntData['raItems']['rtRteName'] : 'Thai baht';
    }else{
        $tRoute         = "banknoteEventAdd";
        $tBntCode       = "";
        $tBntName       = "";
        $tBnnAmt        = "0.00";
        $tBntRmk        = "";
        $tBntStaShw     = ""; 

        $tBntAgnCode    = $tSesAgnCode;
        $tBntAgnName    = $tSesAgnName;

        $tBntCurrencyCode  = "";
        $tBntCurrencyName  = "";
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

                <?php 
                    if($tRoute == "banknoteEventAdd"){
                        $tBntAgnCode   = $tSesAgnCode;
                        $tBntAgnName   = $tSesAgnName;
                        $tDisabled     = '';
                        $tNameElmIDAgn = 'oimBrowseAgn';
                    }else{
                        $tBntAgnCode    = $tBntAgnCode;
                        $tBntAgnName    = $tBntAgnName;
                        $tDisabled      = '';
                        $tNameElmIDAgn  = 'oimBrowseAgn';
                    }
                ?>

                <!-- เพิ่ม AD Browser -->
                <div class="form-group ">
                    <label class="xCNLabelFrm"><?php echo language('payment/banknote/banknote','tBNTAgency')?></label>
                    <div class="input-group"><input type="text" class="form-control xCNHide" id="oetBntAgnCode" name="oetBntAgnCode" maxlength="5" value="<?=@$tBntAgnCode;?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetBntAgnName" name="oetBntAgnName"
                        maxlength="100" placeholder="<?php echo language('interface/connectionsetting/connectionsetting','tTBAgency')?>" value="<?=@$tBntAgnName;?>"readonly>
                        <span class="input-group-btn">
                            <button id="<?=@$tNameElmIDAgn;?>" type="button" class="btn xCNBtnBrowseAddOn <?=@$tDisabled?>">
                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>

                <!-- เพิ่ม สกุลเงิน -->
                <div class="form-group ">
                    <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('payment/recive/recive','tRCVCurrency1'); ?></label>
                    <div class="input-group">
                        <input type="text" autocomplete="off" class="form-control xCNHide" id="oetBntRateCode" name="oetBntRateCode" value="<?= $tBntCurrencyCode; ?>">
                        <div class="validate-input">
                            <input type="text" class="form-control xWPointerEventNone" id="oetBntRateName" name="oetBntRateName" placeholder="" 
                            value="<?= $tBntCurrencyName; ?>" 
                            data-validate-required="<?php echo language('payment/recive/recive', 'tRCVValidCurrencyName') ?>" readonly>
                        </div>
                        <span class="input-group-btn">
                            <button id="obtBntRateBrowse" type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="validate-input">
                    <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('payment/banknote/banknote','tRTEFrmBntName')?></label> 
                        <input 
                            type="text"
                            class="form-control"
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

                <div class="form-group">
                    <label class="fancy-checkbox">
                        <?php
                            if(isset($tBntStaShw) && $tBntStaShw == 1){
                                $tCheckedStaAlwShw  = 'checked';
                            }else{
                                $tCheckedStaAlwShw  = '';
                            }
                        ?>
                        <input type="checkbox" id="ocbBntStaShw" name="ocbBntStaShw" value="1" <?php echo $tCheckedStaAlwShw;?>>
                        <span> <?php echo language('payment/banknote/banknote','tBntStaShw')?></span>
                    </label>
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