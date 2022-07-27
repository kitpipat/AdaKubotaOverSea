<?php
$tRcvSpcCode    = $aRcvSpcCode['tRcvSpcCode'];
$tRcvSpcName    = $aRcvSpcName['tRcvSpcName'];


// echo '<pre>';
// print_r($aResult);
// echo '</pre>';
// ตรวจสอบโหมดการทำงานว่าเป็น โหมดเพิ่มใหม่ หรือแก้ไข
if ($aResult['rtCode'] == 1) {

    $tRcvSpcAppCodeOld         = $aResult['raItems']['FTAppCode'];
    $tRcvSpcRcvSeqOld          = $aResult['raItems']['FNRcvSeq'];
    $tRcvCodeOld               = $aResult['raItems']['FTRcvCode'];

    $tRcvSpcAppCode         = $aResult['raItems']['FTAppCode'];
    $tRcvSpcAppName         = $aResult['raItems']['FTAppName'];
    $tRcvSpcBchCode         = $aResult['raItems']['FTBchCode'];
    $tRcvSpcBchName         = $aResult['raItems']['FTBchName'];
    $tRcvSpcMerCode         = $aResult['raItems']['FTMerCode'];
    $tRcvSpcMerName         = $aResult['raItems']['FTMerName'];
    $tRcvSpcShpCode         = $aResult['raItems']['FTShpCode'];
    $tRcvSpcShpName         = $aResult['raItems']['FTShpName'];
    $tRcvSpcShpType         = $aResult['raItems']['FTShpType'];
    $tRcvSpcAggCode         = $aResult['raItems']['FTAggCode'];
    $tRcvSpcAggName         = $aResult['raItems']['FTAgnName'];
    $tRcvSpcPosCode         = $aResult['raItems']['FTPosCode'];
    $tRcvSpcPosName         = $aResult['raItems']['FTPosName'];
    $tRemark                = $aResult['raItems']['FTPdtRmk'];
    // $tRcvSpcStaAlwRet       = $aResult['raItems']['FTAppStaAlwRet'];
    // $tRcvSpcStaAlwCancel    = $aResult['raItems']['FTAppStaAlwCancel'];
    // $tRcvSpcStaPayLast      = $aResult['raItems']['FTAppStaPayLast'];
    $tRcvSpcRcvSeq          = $aResult['raItems']['FNRcvSeq'];
    if (!empty($aResultConfig)) {
        $tRcvFmtStaAlwCfg         =  $aResultConfig[0]['FTFmtStaAlwCfg'];
    } else {
        $tRcvFmtStaAlwCfg         =  99;
    }


    //route for edit
    $tRoute             = "recivespcEventEdit";
} else {
    $tRcvSpcAppCodeOld         = "";
    $tRcvSpcAppCode         = "";
    $tRcvSpcAppName         = "";
    $tRcvSpcBchCode         = "";
    $tRcvSpcBchName         = "";
    $tRcvSpcMerCode         = "";
    $tRcvSpcMerName         = "";
    $tRcvSpcShpCode         = "";
    $tRcvSpcShpName         = "";
    $tRcvSpcShpType         = "";
    // $tRcvSpcAggCode         = "";
    // $tRcvSpcAggName         = "";
    $tRemark                = "";
    // $tRcvSpcStaAlwRet       = "1";
    // $tRcvSpcStaAlwCancel    = "1";
    // $tRcvSpcStaPayLast      = "1";
    $tRcvSpcRcvSeq          = "";
    $tRcvFmtStaAlwCfg         = "";
    //route for add
    $tRoute             = "recivespcEventAdd";

    $tUserLevel = $this->session->userdata("tSesUsrLevel");



    if (isset($tUserLevel) && !empty($tUserLevel) && $tUserLevel == "BCH") {
        $tRcvSpcAggCode = $this->session->userdata("tSesUsrAgnCode");
        $tRcvSpcAggName = $this->session->userdata("tSesUsrAgnName");
        $tRcvSpcBchCode = $this->session->userdata("tSesUsrBchCodeDefault");
        $tRcvSpcBchName = $this->session->userdata("tSesUsrBchNameDefault");

    
        // $tUsrBchCodeDefult =  $this->session->userdata("tSesUsrBchCodeDefault");
        // $tUsrBchNameDefult = $this->session->userdata("tSesUsrBchNameDefault");
    } else {
        $tRcvSpcAggCode = '';
        $tRcvSpcAggName =     '';
    }

}


// print_r($aResult['raItems']);
// print_r($aDataList); die();
?>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddEditRcvSpc">
    <input type="hidden" id="ohdRcvSpcIsShpEnabled" value="<?= FCNbGetIsShpEnabled() ? 1 : 0; ?>">
    <input type="hidden" id="ohdTRoute" name="ohdTRoute" value="<?php echo @$tRoute; ?>">
    <input type="hidden" id="ohdRcvSpcCode" name="ohdRcvSpcCode" value="<?php echo @$tRcvSpcCode ?>">
    <input type="hidden" id="ohdRcvSpcAppCodeOld" name="ohdRcvSpcAppCodeOld" value="<?= $tRcvSpcAppCodeOld ?>">

    <input type="hidden" id="ohdRcvSpcRcvSeq" name="ohdRcvSpcRcvSeq" value="<?php echo @$tRcvSpcRcvSeq ?>">
    <input type="hidden" id="ohdValidateDuplicate" name="ohdValidateDuplicate" value="0">


    <input type="hidden" id="ohdRcvSpcAppCode" name="ohdRcvSpcAppCode" value="<?php echo @$tRcvSpcAppCode ?>">
    <input type="hidden" id="ohdRcvSpcBchCode" name="ohdRcvSpcBchCode" value="<?php echo @$tRcvSpcBchCode ?>">
    <input type="hidden" id="ohdRcvSpcMerCode" name="ohdRcvSpcMerCode" value="<?php echo @$tRcvSpcMerCode ?>">
    <input type="hidden" id="ohdRcvSpcShpCode" name="ohdRcvSpcShpCode" value="<?php echo @$tRcvSpcShpCode ?>">
    <input type="hidden" id="ohdRcvSpcAggCode" name="ohdRcvSpcAggCode" value="<?php echo @$tRcvSpcAggCode ?>">
    <input type="hidden" id="ohdRcvSpcPosCode" name="ohdRcvSpcPosCode" value="<?php echo @$tRcvSpcPosCode ?>">

    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <label class="xCNLabelFrm" style="color: #179bfd !important; cursor:pointer;" onclick="JSxRcvSpcGetContent();"><?php echo language('payment/recivespc/recivespc', 'tDetailManagepayment') ?></label>
            <label class="xCNLabelFrm">
                <?php if ($aResult['rtCode'] == 1) { ?>
                    <label class="xCNLabelFrm" style="color: #aba9a9 !important;"> / <?php echo language('payment/recivespc/recivespc', 'tRcvSpcEdit') ?> </label>
                <?php } else { ?>
                    <label class="xCNLabelFrm xWPageAdd" style="color: #aba9a9 !important;"> / <?php echo language('payment/recivespc/recivespc', 'tRcvSpcAdd') ?> </label>
                <?php } ?>
        </div>

        <!--ปุ่มเพิ่ม-->
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  text-right">
            <button type="button" onclick="JSxRcvSpcGetContent();" class="btn" style="background-color: #D4D4D4; color: #000000;">
                <?php echo language('common/main/main', 'tCancel') ?>
            </button>
            <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" id="obtCrdloginSave" onclick="JSxRcvSpvSaveAddEdit('<?= $tRoute ?>')"> <?php echo  language('common/main/main', 'tSave') ?></button>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <hr>
    </div>
    <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
            <!-- รหัสประเภทการชำระเงิน -->
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcPaymentCategoryID'); ?></label>
                <input type="text" class="form-control" id="oetRcvSpcCode" name="oetRcvSpcCode" value="<?php echo $tRcvSpcCode; ?>" readonly="readonly">
                <!-- <div class="input-group">
                </div> -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
            <!-- ชื่อประเภทการชำระเงิน -->
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcPaymentCategoryName'); ?></label>
                <input type="text" class="form-control" id="oetRcvSpcName" name="oetRcvSpcName" value="<?php echo $tRcvSpcName; ?>" readonly="readonly">
                <!-- <div class="input-group">
                   
                </div> -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
            <!-- ระบบบัตร -->
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRCVSpcBrwApp'); ?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNHide" id="oetRcvSpcAppCode" name="oetRcvSpcAppCode" value="<?php echo @$tRcvSpcAppCode; ?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetRcvSpcAppName" name="oetRcvSpcAppName" placeholder="<?php echo language('payment/recivespc/recivespc', 'tRcvSpcholdersystem'); ?>" value="<?php echo @$tRcvSpcAppName; ?>" data-validate="<?php echo  language('payment/recivespc/recivespc', 'tRCVSPCValidName'); ?>" readonly>
                    <span class="input-group-btn">
                        <!-- <button id="oimRcvSpcBrowseApp" type="button" class="btn xCNBtnBrowseAddOn" <?= $aResult['rtCode'] == 1 ? 'disabled' : ''; ?>><img class="xCNIconFind"></button> -->
                        <button id="oimRcvSpcBrowseApp" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="ohdRcvSpc">
    <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
            <!-- กลุ่มตัวแทน -->
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRCVSpcBrwAgg'); ?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNHide" id="oetRcvSpcAggCode" name="oetRcvSpcAggCode" value="<?php echo @$tRcvSpcAggCode; ?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetRcvSpcAggName" name="oetRcvSpcAggName" placeholder="<?php echo language('payment/recivespc/recivespc', 'tRcvSpcholdeAgg'); ?>" value="<?php echo @$tRcvSpcAggName; ?>" readonly>
                    <span class="input-group-btn">
                        <button id="oimRcvSpcBrowseAgg" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="ohdRcvAgg">
    <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
            <!-- สาขา -->
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRCVSpcBrwBch'); ?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNHide" id="oetRcvSpcBchCode" name="oetRcvSpcBchCode" value="<?php echo @$tRcvSpcBchCode; ?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetRcvSpcBchName" name="oetRcvSpcBchName" placeholder="<?php echo language('payment/recivespc/recivespc', 'tRcvSpcholdeBch'); ?>" value="<?php echo @$tRcvSpcBchName; ?>" data-validate="<?php echo  language('payment/recivespc/recivespc', 'tRCVSPCValidBchName'); ?>" readonly>
                    <span class="input-group-btn">
                        <button id="oimRcvSpcBrowseBch" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="ohdRcvSpcBch">
    <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
            <!-- กลุ่มธุรกิจ -->
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRCVSpcBrwMer'); ?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNHide" id="oetRcvSpcMerCode" name="oetRcvSpcMerCode" value="<?php echo @$tRcvSpcMerCode; ?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetRcvSpcMerName" name="oetRcvSpcMerName" placeholder="<?php echo language('payment/recivespc/recivespc', 'tRcvSpcholdeMer'); ?>" value="<?php echo @$tRcvSpcMerName; ?>" readonly>
                    <span class="input-group-btn">
                        <button id="oimRcvSpcBrowseMer" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="ohdRcvSpcMer">
    <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
            <!-- ร้านค้า -->
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRCVSpcBrwShp'); ?></label>
                <div class="input-group">

                    <input type="text" class="form-control xCNHide" id="ohdRcvSpcShpType" name="ohdRcvSpcShpType" value="<?php echo @$tRcvSpcShpType; ?>">
                    <input type="text" class="form-control xCNHide" id="oetRcvSpcShpCode" name="oetRcvSpcShpCode" value="<?php echo @$tRcvSpcShpCode; ?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetRcvSpcShpName" name="oetRcvSpcShpName" placeholder="<?php echo language('payment/recivespc/recivespc', 'tRcvSpcholdeShp'); ?>" value="<?php echo @$tRcvSpcShpName; ?>" data-validate="<?php echo  language('payment/recivespc/recivespc', 'tRCVSPCValidShpName'); ?>" readonly>
                    <span class="input-group-btn">
                        <button id="oimRcvSpcBrowseShp" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- <input type="hidden" id="ohdRcvSpcShp"> -->
    <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
            <!-- จุดขาย -->
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcholdePos'); ?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNHide" id="oetRcvSpcPosCode" name="oetRcvSpcPosCode" value="<?php echo @$tRcvSpcPosCode; ?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetRcvSpcPosName" name="oetRcvSpcPosName" placeholder="<?php echo language('payment/recivespc/recivespc', 'tRcvSpcholdePos'); ?>" value="<?php echo @$tRcvSpcPosName; ?>" readonly>
                    <span class="input-group-btn">
                        <button id="oimRcvSpcBrowsePos" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- การเชื่อมต่อ -->
    <?php

    // if (!empty($aResultConfig)) { 
    if ($nResultConfig > 0) {
    ?>
        <div class="row" id="odvRcvSpcConfigChk">
            <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcConnection'); ?></label>
                    <select class="form-control" id="oetRcvSpcConfig" name="oetRcvSpcConfig">
                        <?php
                        foreach ($aResultConfigSelect as $aVale) { ?>
                            <option value="<?php echo $aVale['FNRcvSeq']; ?>" <?php if ($aVale['FNRcvSeq'] ==  $tRcvSpcRcvSeq) {
                                                                                    echo 'selected';
                                                                                } ?>><?php echo language('payment/recivespc/recivespc', 'tRcvSpcConnection'); ?> <?php echo $aVale['FNRcvSeq']; ?></option>
                        <?php  } ?>
                    </select>
                </div>
            </div>
        </div>
    <?php }
    ?>
    <!-- หมายเหตุ -->
    <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label class="xCNLabelFrm"><?= language('payment/cardlogin/cardlogin', 'tCrdLRemark'); ?></label>
                <textarea class="form-group" rows="4" maxlength="50" id="oetRcvSpcRemark" name="oetRcvSpcRemark" autocomplete="off" placeholder="<?php echo language('payment/cardlogin/cardlogin', 'tCrdLRemark') ?>"><?php echo @$tRemark; ?></textarea>
            </div>
        </div>
    </div>





    <?php //if ($aResult['rtCode'] == 1 && $tRcvFmtStaAlwCfg  == 1) { 
    ?>
    <!-- <label class="xCNLabelFrm"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcSetPaymentType'); ?></label> -->

    <!-- <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcNo'); ?></th>
                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcSetupList'); ?></th>
                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcUserConfiguration'); ?></th>
                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcReferenceValue'); ?></th>

                            </tr>
                        </thead>
                        <tbody id="odvRGPList"> -->
    <?php //if ($aResultConfigNum > 0) { 
    ?>
    <?php //foreach ($aResultConfigValue as $key => $aValue) { 
    ?>
    <tr>
        <!-- <input type="hidden" id="ohdFmtCode" name="ohdFmtCode[]" value="<?php echo $aValue['FTFmtCode']; ?>"> -->
        <!-- <input type="hidden" id="ohdFNSysSeq<?= $key ?>" name="ohdFNSysSeq[]" value="<?php echo $aValue['FNSysSeq']; ?>">
                                        <input type="hidden" id="ohdFTSysKey<?= $key ?>" name="ohdFTSysKey[]" value="<?php echo $aValue['FTSysKey']; ?>">
                                        <td nowrap class="text-left xWTdBody"><?= $aValue['FNSysSeq']; ?></td>
                                        <td nowrap class="text-left xWTdBody"><?= $aValue['FTSysKey']; ?></td>
                                        <td nowrap class="text-left xWTdBody"><input id="oetFTSysStaUsrValue<?= $key ?>" class="form-control" type="input" name="oetFTSysStaUsrValue[]" value="<?php echo $aValue['FTSysStaUsrValue']; ?>"></td>
                                        <td nowrap class="text-left xWTdBody"><input id="oetFTSysStaUsrRef<?= $key ?>" class="form-control" type="input" name="oetFTSysStaUsrRef[]" value="<?php echo $aValue['FTSysStaUsrRef']; ?>"></td>
                                    </tr> -->
        <?php //} 
        ?>
        <?php //} else { 
        ?>
        <?php //foreach ($aResultConfig as $key => $aValue) { 
        ?>
        <!-- <tr> -->
        <!-- <input type="hidden" id="ohdFmtCode" name="ohdFmtCode[]" value="<?php echo $aValue['FTFmtCode']; ?>"> -->
        <!-- <input type="hidden" id="ohdFNSysSeq<?= $key ?>" name="ohdFNSysSeq[]" value="<?php echo $aValue['FNSysSeq']; ?>">
                                        <input type="hidden" id="ohdFTSysKey<?= $key ?>" name="ohdFTSysKey[]" value="<?php echo $aValue['FTSysKey']; ?>">
                                        <td nowrap class="text-left xWTdBody"><?= $aValue['FNSysSeq']; ?></td>
                                        <td nowrap class="text-left xWTdBody"><?= $aValue['FTSysKey']; ?></td>
                                        <td nowrap class="text-left xWTdBody"><input id="oetFTSysStaUsrValue<?= $key ?>" class="form-control" type="input" name="oetFTSysStaUsrValue[]" value="<?php echo $aValue['FTSysStaUsrValue']; ?>"></td>
                                        <td nowrap class="text-left xWTdBody"><input id="oetFTSysStaUsrRef<?= $key ?>" class="form-control" type="input" name="oetFTSysStaUsrRef[]" value="<?php echo $aValue['FTSysStaUsrRef']; ?>"></td>
                                    </tr> -->
        <?php //} 
        ?>

        <?php // } 
        ?>
        <!-- </tbody>
                    </table>
                </div>
            </div>
        </div> -->

        <?php //} 
        ?>

        <!-- Status Recive Spc -->
        <!-- <div class="row">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <div class="form-group">
                    <label class="fancy-checkbox">
                        <?php
                        // if(isset($tRcvSpcStaAlwRet) && $tRcvSpcStaAlwRet == 1){
                        //     $tCheckedStaAlwRet  = 'checked';
                        // }else{
                        //     $tCheckedStaAlwRet  = '';
                        // }
                        ?>
                        <input type="checkbox" id="ocbRcvSpcStaAlwRet" name="ocbRcvSpcStaAlwRet" <?php //echo $tCheckedStaAlwRet;
                                                                                                    ?>>
                        <span> <?php //echo language('payment/recivespc/recivespc','tRcvSpcStaAlwRet');
                                ?></span>
                    </label>
                </div>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <div class="form-group">
                    <label class="fancy-checkbox">
                        <?php
                        // if(isset($tRcvSpcStaAlwCancel) && $tRcvSpcStaAlwCancel == 1){
                        //     $tCheckedStaAlwCancel   = 'checked';
                        // }else{
                        //     $tCheckedStaAlwCancel   = '';
                        // }
                        ?>
                        <input type="checkbox" id="ocbRcvSpcStaAlwCancel" name="ocbRcvSpcStaAlwCancel" <?php //echo $tCheckedStaAlwCancel;
                                                                                                        ?>>
                        <span> <?php //echo language('payment/recivespc/recivespc','tRcvSpcStaAlwCancel');
                                ?></span>
                    </label>
                </div>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-3 col-lg-3">
                <div class="form-group">
                    <label class="fancy-checkbox">
                        <?php
                        // if(isset($tRcvSpcStaPayLast) && $tRcvSpcStaPayLast == 1){
                        //     $tCheckedStaPayLast = 'checked';
                        // }else{
                        //     $tCheckedStaPayLast = '';
                        // }
                        ?>
                        <input type="checkbox" id="ocbRcvSpcStaPayLast" name="ocbRcvSpcStaPayLast" <?php //echo $tCheckedStaPayLast;
                                                                                                    ?>>
                        <span> <?php //echo language('payment/recivespc/recivespc','tRcvSpcStaPayLast');
                                ?></span>
                    </label>
                </div>
            </div>
        </div> -->


</form>
<?php include "script/jReciveSpcMain.php"; ?>
<link rel="stylesheet" href="<?php echo base_url('application/modules/common/assets/css/localcss/ada.component.css') ?>">
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>


<script>
    $(document).ready(function() {

        var tRcvSpcStaAlwCfg = $('#ohdtRcvSpcStaAlwCfg').val();
        // alert(tRcvSpcStaAlwCfg)
        $('#odvRcvSpcConfigChk').hide();
        $("#oetRcvSpcConfig").attr("disabled", true);
        if (tRcvSpcStaAlwCfg == 1) {
            $('#odvRcvSpcConfigChk').show();
            $("#oetRcvSpcConfig").attr("disabled", false);


        }
    });
</script>