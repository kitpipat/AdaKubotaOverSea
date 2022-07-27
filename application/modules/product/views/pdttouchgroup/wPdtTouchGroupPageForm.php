<?php
    if(isset($aDataResult) && $aDataResult['rtCode'] == '1'){
        $tRoute     = "pdtTouchGroupEventEdit";
        $tTCGCode   = $aDataResult['raItems']['FTTcgCode'];
        $tTCGName   = $aDataResult['raItems']['FTTcgName'];
        $tTCGStaUse = $aDataResult['raItems']['FTTcgStaUse'];
        $tTCGRmk    = $aDataResult['raItems']['FTTcgRmk'];
    }else{
        $tRoute     = "pdtTouchGroupEventAdd";
        $tTCGCode   = "";
        $tTCGName   = "";
        $tTCGStaUse = 1;
        $tTCGRmk    = "";
    }
?>
<form id="ofmPdtTouchGroupAddEditForm" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <input type="hidden" id="ohdTCGCheckClearValidate" name="ohdTCGCheckClearValidate" value="0">
    <input type="hidden" id="ohdTCGCheckSubmitByButton" name="ohdTCGCheckSubmitByButton" value="0">
    <input type="hidden" id="ohdTCGCheckDuplicateCode" name="ohdTCGCheckDuplicateCode" value="2">
    <input type="hidden" id="ohdTCGRouteEvent" value="<?php echo @$tRoute;?>">
    <button style="display:none" type="submit" id="obtTCGEventSubmitForm" onclick="JSxTCGCheckValidateForm()"></button>
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                    <div id="odvTCGImage">
                        <?php
                            if(isset($tImgObj) && !empty($tImgObj)){
                                $tFullPatch = './application/modules/'.$tImgObj;
                                if (file_exists($tFullPatch)){
                                    $tPatchImg = base_url().'/application/modules/'.$tImgObj;
                                }else{
                                    $tPatchImg = base_url().'application/modules/common/assets/images/200x200.png';
                                }
                            }else{
                                $tPatchImg = base_url().'application/modules/common/assets/images/200x200.png';
                            }
                        ?>
                        <img id="oimImgMasterTCG" class="img-responsive xCNImgCenter" src="<?php echo @$tPatchImg;?>">
                    </div>
                    <div class="xCNUplodeImage">
                        <input type="text" class="xCNHide" id="oetImgInputTCGOld"  name="oetImgInputTCGOld"   value="<?php echo @$tImgName;?>">
                        <input type="text" class="xCNHide" id="oetImgInputTCG"     name="oetImgInputTCG"      value="<?php echo @$tImgName;?>">
                        <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('','','TCG')">
                            <i class="fa fa-picture-o xCNImgButton"></i> <?php echo language('common/main/main','tSelectPic')?>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
                <label class="xCNLabelFrm"><span style = "color:red">* </span><?php echo @$aTextLang['tTCGCode'];?></label>
                <?php if(isset($tTCGCode) && empty($tTCGCode)):?>
                <div class="form-group">
                    <label class="fancy-checkbox">
                        <input type="checkbox" id="ocbTCGStaAutoGenCode" name="ocbTCGStaAutoGenCode" maxlength="1" checked="checked">
                        <span>&nbsp;</span>
                        <span class="xCNLabelFrm"><?php echo @$aTextLang['tGenerateAuto'];?></span>
                    </label>
                </div>
                <?php endif;?>
                <div class="form-group" style="cursor:not-allowed">
                    <input
                        type="text"
                        class="form-control xCNGenarateCodeTextInputValidate"
                        id="oetTCGCode"
                        name="oetTCGCode"
                        maxlength="5"
                        value="<?php echo @$tTCGCode;?>"
                        data-validate-required="<?php echo @$aTextLang['tTCGPlsEnterOrRunCode'];?>"
                        data-validate-duplicate="<?php echo @$aTextLang['tTCGPlsCodeDuplicate'];?>"
                        placeholder="<?php echo @$aTextLang['tTCGCodePaceholder'];?>"
                        style="pointer-events:none"
                        readonly
                    >
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><span style="color:red">* </span><?php echo @$aTextLang['tTCGName'];?></label>
                    <input
                        type="text"
                        class="form-control"
                        id="oetTCGName"
                        name="oetTCGName"
                        maxlength="100"
                        data-validate-required="<?php echo @$aTextLang['tTCGPlsEnterOrRunName'];?>"
                        value="<?php echo @$tTCGName;?>"
                        placeholder="<?php echo @$aTextLang['tTCGNamePaceholder'];?>"
                    >
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo @$aTextLang['tTCGRemark'];?></label>
                    <textarea class="form-control" id="otaTCGRemark" name="otaTCGRemark" rows="2" maxlength="100"><?php echo @$tTCGRmk;?></textarea>
                </div>
                <div class="form-group">
                    <label class="fancy-checkbox">
                        <?php
                            if(isset($tTCGStaUse) && $tTCGStaUse == 1){
                                $tChecked   = 'checked';
                            }else{
                                $tChecked   = '';
                            }
                        ?>
                        <input type="checkbox" id="ocbTCGStatusUse" name="ocbTCGStatusUse" <?php echo $tChecked;?>>
                        <span> <?php echo @$aTextLang['tTCGStatusUse'];?></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    // Event Control Date Default
    $('#ocbTCGStaAutoGenCode').on('change', function (e) {
        if($('#ocbTCGStaAutoGenCode').is(':checked')){
            $("#oetTCGCode").val('');
            $("#oetTCGCode").attr("readonly", true);
            $('#oetTCGCode').parents(".form-group").css("cursor","not-allowed");
            $('#oetTCGCode').css("pointer-events","none");
            $("#oetTCGCode").attr("onfocus", "this.blur()");
            $('#ofmPdtTouchGroupAddEditForm').removeClass('has-error');
            $('#ofmPdtTouchGroupAddEditForm .form-group').closest('.form-group').removeClass("has-error");
            $('#ofmPdtTouchGroupAddEditForm em').remove();
        }else{
            $('#oetTCGCode').parents(".form-group").css("cursor","");
            $('#oetTCGCode').css("pointer-events","");
            $('#oetTCGCode').attr('readonly',false);
            $("#oetTCGCode").removeAttr("onfocus");
        }
    });
</script>