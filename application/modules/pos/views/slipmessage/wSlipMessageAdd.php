<?php

if($aResult['rtCode'] == "1"){
    $tSmgCode = $aResult['raHDItems']['rtSmgCode'];
    $oSmgFonts = $aResult['raHDItems']['rtSmgFonts'];
    $tSmgTitle = $aResult['raHDItems']['rtSmgTitle'];
    $tSmgLngID = $aResult['raHDItems']['rtSmgLngID'];
    $aSmgHeadItems = $aResult['raDTHeadItems'];
    $aSmgEndItems = $aResult['raDTEndItems'];
    $tRoute = "slipMessageEventEdit";
    $tSmgFonts = explode(",",$oSmgFonts)[0];
    $tSmgFontsSize = explode(",",$oSmgFonts)[1];
    $tSmgFontsStyle = explode(",",$oSmgFonts)[2];
    if(empty($tSmgFontsStyle)){
        $tSmgFontsStyle = explode(",",$oSmgFonts)[3];
        if(empty($tSmgFontsStyle)){
            $tSmgFontsStyle = explode(",",$oSmgFonts)[4];
        }
    }
    
}else{
    $tSmgCode = "";
    $tSmgTitle = "";
    $oSmgFonts = "";
    $tSmgLngID = "";
    $aSmgHeadItems = [];
    $aSmgEndItems = [];
    $tSmgName = "";
    $tRoute = "slipMessageEventAdd";
    $tSmgFonts = "";
    $tSmgFontsStyle = "";
    $tSmgFontsSize = "";
}
$tLang = "";
$tHeadReceiptPlaceholder = language('pos/slipmessage/slipmessage','tSMGHeadReceiptPlaceholder');
$tEndReceiptPlaceholder = language('pos/slipmessage/slipmessage','tSMGEndReceiptPlaceholder');
?>
<style>
.xWSmgMoveIcon {
    cursor: move !important;
    border-radius: 0px;
    box-shadow: none;
    padding: 0px 10px;
}
.dragged {
    position: absolute;
    opacity: 0.5;
    z-index: 2000;
}
.xWSmgDyForm {
    border-radius: 0px;
    border: 0px;
}
.xWSmgBtn {
    box-shadow: none;
}
button.btn.dropdown-toggle.btn-default {
    height: 34px;
}

.filter-option-inner-inner{
    font-size: 17px !important;
    margin-top: 1px;
    padding-left: 10px;
}
.xWSmgItemSelect {
    margin-bottom: 5px;
}
.alert-validate::before, 
.alert-validate::after{
    z-index: 100;
}
.input-group-addon:not(:first-child):not(:last-child), 
.input-group-btn:not(:first-child):not(:last-child), 
.input-group 
.form-control:not(:first-child):not(:last-child) {
    border-radius: 4px;
}
</style>
<div class="panel panel-headline">
    <div class="panel-body">
        <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddSlipMessage">
            <button style="display:none" type="submit" id="obtSubmitSlipMessage" onclick="JSnAddEditSlipMessage('<?= $tRoute?>')"></button>
            <div class="panel-body"  style="padding-top:20px !important;">
                <div class="row">
                    <div class="col-xs-12 col-md-5 col-lg-5">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/slipmessage/slipmessage','tSMGCode'); ?></label>
                        <div class="form-group" id="odvSlipmessageAutoGenCode">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbSlipmessageAutoGenCode" name="ocbSlipmessageAutoGenCode" checked="true" value="1">
                                    <span><?php echo language('common/main/main', 'tGenerateAuto');?></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group" id="odvSlipmessageCodeForm">
                            <input type="hidden" id="ohdCheckDuplicateSmgCode" name="ohdCheckDuplicateSmgCode" value="1">
                            <div class="validate-input">
                                <input
                                    type="text"
                                    class="form-control xCNInputWithoutSpcNotThai"
                                    maxlength ="5"
                                    id="oetSmgCode"
                                    name="oetSmgCode"
                                    data-is-created="<?php echo $tSmgCode; ?>"
                                    placeholder ="<?php echo language('pos/slipmessage/slipmessage','tSMGCode'); ?>"
                                    autocomplete="off"
                                    value="<?php echo $tSmgCode;?>"
                                    data-validate-required = "<?php echo language('pos/slipmessage/slipmessage','tSMGValidCode')?>"
                                    data-validate-dublicateCode ="<?php echo language('pos/slipmessage/slipmessage','tSMGValidCodeDup');?>"
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos/slipmessage/slipmessage','tSMGLang');?></label>
                            <select class="selectpicker form-control" id="ocmSmgLngID" name="ocmSmgLngID" value="<?=@$tSmgLngID?>">
                                <?php 
                                    foreach($aLang as $aData){ 
                                        if($aData['FNLngID']==$tSmgLngID){
                                            $tSel = 'selected';
                                        }else{
                                            $tSel = '';
                                        }                    
                                ?>
                              	<option value="<?=$aData['FNLngID']?>"<?php echo $tSel;?>>
                                    <?php echo $aData['FTLngNameEng'];?>
                                </option>
                            <?php } ?>
                            </select>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="xCNLabelFrm"><?php echo language('pos/slipmessage/slipmessage','tSMGFont'); ?></label>
                                        <select class="selectpicker form-control" id="ocmSmgFonts" name="ocmSmgFonts" value="<?=@$tSmgFontsStyle?>">
                                           <?php 
                                           if(isset($aFonts) && !empty($aFonts)){
                                                foreach($aFonts AS $aFonts){ 
                                                if($tSmgFonts == $aFonts['FTFntName']){
                                                    $tSel = 'selected';
                                                }else{
                                                    $tSel = '';
                                                }    
                                            ?>
                                                <option value="<?= $aFonts['FTFntName'];?>"<?= $tSel;?>>
                                                    <?php echo $aFonts['FTFntName'];?>
                                                </option> 
                                           <?php }}else{ ?>
                                                <option>
                                                    <?php echo 'Not Found Data';?>
                                                </option> 
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="xCNLabelFrm"><?php echo language('pos/slipmessage/slipmessage','tSMGFontType'); ?></label>
                                        <select class="selectpicker form-control" id="ocmSmgFontsStyle" name="ocmSmgFontsStyle" value="<?=@$tSmgFontsStyle?>">
                                            <option value="1"<?php echo (@$tSmgFontsStyle == '')?  "selected" : "";?> >
                                                Normal
                                            </option> 
                                            <option value="2"<?php echo (@$tSmgFontsStyle == 'B')?  "selected" : "";?>>
                                                Bold
                                            </option>
                                            <option value="3"<?php echo (@$tSmgFontsStyle == 'I')?  "selected" : "";?>>
                                                Italic 
                                            </option>
                                            <option value="4"<?php echo (@$tSmgFontsStyle == 'U')?  "selected" : "";?>>
                                                Underline        
                                            </option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="validate-input">
                                            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/slipmessage/slipmessage','tSMGFontSize'); ?></label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                maxlength="2"
                                                id="oetSmgFontsSize"
                                                name="oetSmgFontsSize"
                                                autocomplete="off"
                                                placeholder ="<?php echo language('pos/slipmessage/slipmessage','tSMGFontSize'); ?>"
                                                value="<?=@$tSmgFontsSize?>"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                data-validate-required ="<?php echo language('pos/slipmessage/slipmessage','tSMGValidFontSize');?>"
                                            >
                                            </div>
                                        </div>                                  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>                                              

                        <div class="form-group">
                            <div class="validate-input">
                            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/slipmessage/slipmessage','tSMGName'); ?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="50"
                                    id="oetSmgTitle"
                                    name="oetSmgTitle"
                                    autocomplete="off"
                                    placeholder ="<?php echo language('pos/slipmessage/slipmessage','tSMGName'); ?>"
                                    value="<?php echo $tSmgTitle;?>"
                                    data-validate-required="<?php echo language('pos/slipmessage/slipmessage','tSMGValidName');?>"
                                >
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-md-5 col-lg-5">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/slipmessage/slipmessage','tSMGSlipHead'); ?></label>
                        <div class="xWSmgSortContainer" id="odvSmgSlipHeadContainer">

                            <?php foreach($aSmgHeadItems as $nHIndex => $oHeadItem) : $nHIndex++; ?>
                                <div class="form-group xWSmgItemSelect" id="<?php echo $nHIndex; ?>">
                                    <div class="input-group validate-input">
                                        <span class="input-group-btn">
                                            <div class="btn xWSmgMoveIcon" type="button"><i class="icon-move fa fa-arrows"></i></div>
                                        </span>
                                        <input type="text" class="form-control xWSmgDyForm" maxlength="50" id="oetSmgSlipHead<?php echo $nHIndex; ?>" name="oetSmgSlipHead[<?php echo $nHIndex; ?>]" value="<?php echo $oHeadItem; ?>" placeholder="<?php echo $tHeadReceiptPlaceholder; ?> <?php echo $nHIndex; ?>"  data-validate-required="<?php echo language('pos/slipmessage/slipmessage','tSMGValidName');?>">
                                        <span class="input-group-btn">
                                            <button class="btn pull-right xWSmgBtn xWSmgBtnDelete" onclick="JSxSlipMessageDeleteRowHead(this, event)"><?php echo language('pos/slipmessage/slipmessage','tSMGDeleteRow'); ?></button>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                        <div class="wrap-input100">
                            <button type="button" class="btn pull-right xWSmgBtn xWSmgBtnAdd" id="xWSmgAddHeadRow" onclick="JSxSlipMessageAddHeadReceiptRow()"><i class="fa fa-plus"></i> <?php echo language('pos/slipmessage/slipmessage','tSMGAddRow'); ?></button>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-md-5 col-lg-5">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/slipmessage/slipmessage','tSMGSlipEnd'); ?></label>
                        <div class="xWSmgSortContainer" id="odvSmgSlipEndContainer">

                            <?php foreach($aSmgEndItems as $nEIndex => $oEndItem) : $nEIndex++ ?>
                                <div class="form-group xWSmgItemSelect" id="<?php echo $nEIndex; ?>">
                                    <div class="input-group validate-input">
                                        <span class="input-group-btn">
                                            <div class="btn xWSmgMoveIcon" type="button"><i class="icon-move fa fa-arrows"></i></div>
                                        </span>
                                        <input type="text" class="form-control xWSmgDyForm" maxlength="50" id="oetSmgSlipEnd<?php echo $nEIndex; ?>" name="oetSmgSlipEnd[<?php echo $nEIndex; ?>]" value="<?php echo $oEndItem; ?>" placeholder="<?php echo $tEndReceiptPlaceholder; ?> <?php echo $nEIndex; ?>">
                                        <span class="input-group-btn">
                                            <button class="btn pull-right xWSmgBtn xWSmgBtnDelete" onclick="JSxSlipMessageDeleteRowEnd(this, event)"><?= language('pos/slipmessage/slipmessage','tSMGDeleteRow')?></button>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                        <div class="wrap-input100">
                            <button type="button" class="btn pull-right xWSmgBtn xWSmgBtnAdd" id="xWSmgAddEndRow" onclick="JSxSlipMessageAddEndReceiptRow()"><i class="fa fa-plus"></i> <?php echo language('pos/slipmessage/slipmessage','tSMGAddRow'); ?></button>
                        </div>
                    </div>
                </div>
                
            </div>
        </form>
    </div>
</div>

<script type="text/html" id="oscSlipHeadRowTemplate">
    <div class="form-group xWSmgItemSelect" id="{0}">
        <div class="input-group validate-input">
            <span class="input-group-btn">
                <div class="btn xWSmgMoveIcon" type="button"><i class="icon-move fa fa-arrows"></i></div>
            </span>
            <input type="text" class="form-control xWSmgDyForm" maxlength="50" id="oetSmgSlipHead{0}" name="oetSmgSlipHead[{0}]" value="" placeholder="<?php echo $tHeadReceiptPlaceholder; ?> {0}" data-validate="<?php echo language('pos/slipmessage/slipmessage','tSMGValidHead'); ?>">
            <span class="input-group-btn">
                <button class="btn pull-right xWSmgBtn xWSmgBtnDelete" onclick="JSxSlipMessageDeleteRowHead(this, event)"><?php echo language('pos/slipmessage/slipmessage','tSMGDeleteRow'); ?></button>
            </span>
        </div>
    </div>
</script>
<script type="text/html" id="oscSlipEndRowTemplate">
    <div class="form-group xWSmgItemSelect" id="{0}">
        <div class="input-group validate-input">
            <span class="input-group-btn">
                <div class="btn xWSmgMoveIcon" type="button"><i class="icon-move fa fa-arrows"></i></div>
            </span>
            <input type="text" class="form-control xWSmgDyForm" maxlength="50" id="oetSmgSlipEnd{0}" name="oetSmgSlipEnd[{0}]" value="" placeholder="<?php echo $tEndReceiptPlaceholder; ?> {0}">
            <span class="input-group-btn">
                <button class="btn pull-right xWSmgBtn xWSmgBtnDelete" onclick="JSxSlipMessageDeleteRowEnd(this, event)"><?php echo language('pos/slipmessage/slipmessage','tSMGDeleteRow'); ?></button>
            </span>
        </div>
    </div>
</script>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include 'script/jSlipMessageAdd.php';?>

<script type="text/javascript">
$(function() {
    if(JCNbSlipMessageIsCreatePage()){ // For create page
        
        // Set head of receipt default
        JSxSlipMessageRowDefualt('head', 1);
        // Set end of receipt default
        JSxSlipMessageRowDefualt('end', 1);
        
    }else{ // for update page
        
        if(JCNnSlipMessageCountRow('head') <= 0){
            // Set head of receipt default
            JSxSlipMessageRowDefualt('head', 1);
        }
        if(JCNnSlipMessageCountRow('end') <= 0){
            // Set end of receipt default
            JSxSlipMessageRowDefualt('end', 1);
        }
        
    }
    JSaSlipMessageGetSortData('head');
    // Remove sort data
    JSxSlipMessageRemoveSortData('all');
    
    $('#odvSmgSlipHeadContainer').sortable({
        items: '.xWSmgItemSelect',
        opacity: 0.7,
        axis: 'y',
        handle: '.xWSmgMoveIcon',
        update: function(event, ui) {
            var aToArray = $(this).sortable('toArray');
            var aSerialize = $(this).sortable('serialize', {key:".sort"});
            // JSxSlipMessageSetRowSortData('head', aToArray);
            // JSoSlipMessageSortabled('head', true);
        }
    });

    $('#odvSmgSlipEndContainer').sortable({
        items: '.xWSmgItemSelect',
        opacity: 0.7,
        axis: 'y',
        handle: '.xWSmgMoveIcon',
        update: function(event, ui) {
            var aToArray = $(this).sortable('toArray');
            var aSerialize = $(this).sortable('serialize', {key:".sort"});
            // JSxSlipMessageSetRowSortData('end', aToArray);
            // JSoSlipMessageSortabled('end', true);
        }
    });
    
    $('.xWTooltipsBT').tooltip({'placement': 'bottom'});
    $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});

    $('#oimSmgBrowseProvince').click(function(){
        JCNxBrowseData('oPvnOption');
    });
    
    if(JCNbSlipMessageIsUpdatePage()){
        $("#obtGenCodeSlipMessage").attr("disabled", true);
    }
});
</script>

<?php include 'script/wSlipMessageScript.php'; ?>