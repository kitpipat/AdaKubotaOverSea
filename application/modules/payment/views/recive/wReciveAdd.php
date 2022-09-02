<?php
if ($aResult['rtCode'] == "1") {
    $tRcvCode       = $aResult['raItems']['rtRcvCode'];
    $tRcvName       = $aResult['raItems']['rtRcvName'];
    $tRcvRemark     = $aResult['raItems']['rtRcvRmk'];
    $tRcvchecked    = $aResult['raItems']['rtRcvStatus'];

    $tRcvStaAllRte  = $aResult['raItems']['FTRcvStaAllRte'];

    $tSelected      = $aResult['rtSelected'];

    $tFmtCode   = $aResult['raItems']['rtFmtCode'];
    $tFmtName   = $aResult['raItems']['FTFmtName'];
    $tFmtCurrencyCode  = $aResult['raItems']['FTRcvRefRate'];
    $tFmtCurrencyName   = $aResult['raItems']['FTRteName'];

    $tRcvSpcStaAlwRet       = $aResult['raItems']['FTAppStaAlwRet'];
    $tRcvSpcStaAlwCancel    = $aResult['raItems']['FTAppStaAlwCancel'];
    $tRcvSpcStaPayLast      = $aResult['raItems']['FTAppStaPayLast'];

    $tRcvSpcStaAlwCfg     = $aResult['raItems']['FTFmtStaAlwCfg'];

    $tRoute         = "reciveEventEdit";

    //Event Control
    if (isset($aAlwEventRecive)) {
        if ($aAlwEventRecive['tAutStaFull'] == 1 || $aAlwEventRecive['tAutStaEdit'] == 1) {
            $nAutStaEdit = 1;
        } else {
            $nAutStaEdit = 0;
        }
    } else {
        $nAutStaEdit = 0;
    }
    //Event Control
} else {
    $tRcvCode       = "";
    $tRcvName       = "";
    $tRcvRemark     = "";
    $tRcvchecked    = "";
    $tImgObj        = "";

    $tRcvSpcStaAlwRet       = "1";
    $tRcvSpcStaAlwCancel    = "1";
    $tRcvSpcStaPayLast      = "1";

    $tFmtCode   = '';
    $tFmtName   = '';
    $tRcvSpcStaAlwCfg     = '';
    $tFmtCurrencyCode = '';
    $tFmtCurrencyName = '';

    $tSelected      = $aResult['rtSelected'];
    $tRoute         = "reciveEventAdd";
    $nAutStaEdit = 0; //Event Control

    $tRcvStaAllRte = '';
}


?>


<div class="panel-body">
    <div class="row">
        <div class="col-md-4">
            <div class="custom-tabs-line tabs-line-bottom left-aligned">
                <ul class="nav" role="tablist">
                    <!-- ข้อมูลทั่วไป -->
                    <li id="oliRcvSpcDetail" class="xWMenu active" data-menutype="DT">
                        <a data-toggle="tab" data-target="#odvRcvSpcContentInfoDT" aria-expanded="true"><?php echo language('payment/recivespc/recivespc', 'tTabNormal') ?></a>
                    </li>
                    <!---ข้อมูล Tab จัดการวิธีการชำระเงิน-->
                    <!-- Witsarut Add 27/11/2019 -->
                    <!-- ตรวจสอบโหมดการเรียก Page
                            ถ้าเป็นโหมดเพิ่ม ($aResult['rtCode'] == '99') ให้ปิด Tab จัดการวิธีการชำระเงิน 
                            ถ้าเป็นโหมดแก้ไข ($aResult['rtCode'] = 1) ให้เปิด Tab จัดการวิธีการชำระเงิน 
                        -->
                    <?php
                    if ($aResult['rtCode'] == '99') {
                    ?>
                        <li id="oliRcvSpcConfig" class="xWSubTab disabled" data-menutype="Cfg">
                            <a role="tab" aria-expanded="true"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcConnectionSettings') ?></a>
                        </li>
                    <?php } else { ?>
                        <?php if ($tRcvSpcStaAlwCfg  == 1) { ?>
                            <li id="oliRcvSpcConfig" class="xWMenu xWSubTab" data-menutype="Cfg" onclick="JSxRcvSpcGetConfig();">
                                <a role="tab" data-toggle="tab" data-target="#odvRcvSpcConfig" aria-expanded="true"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcConnectionSettings') ?></a>
                            </li>
                        <?php } else {
                        } ?>
                    <?php } ?>
                    <?php
                    if ($aResult['rtCode'] == '99') {
                    ?>
                        <li id="oliRcvSpc" class="xWSubTab disabled" data-menutype="Log">
                            <a role="tab" aria-expanded="true"><?php echo language('payment/recivespc/recivespc', 'tManagepayment') ?></a>
                        </li>
                    <?php } else { ?>
                        <li id="oliRcvSpc" class="xWMenu xWSubTab" data-menutype="Log" onclick="JSxRcvSpcGetContent();">
                            <a role="tab" data-toggle="tab" data-target="#odvRcvSpcData" aria-expanded="true"><?php echo language('payment/recivespc/recivespc', 'tManagepayment') ?></a>
                        </li>
                    <?php } ?>


                </ul>
            </div>
        </div>
    </div>

    <div id="odvPdtRowContentMenu" class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Tab Content Detail -->
            <div class="tab-content">
                <div id="odvRcvSpcContentInfoDT" class="tab-pane fade active in">
                    <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddRecive">
                        <input type="hidden" id='ohdtRcvSpcStaAlwCfg' name="ohdtRcvSpcStaAlwCfg" value="<?php echo $tRcvSpcStaAlwCfg; ?>">
                        <input type="hidden" id='ohdtFmtCodeOld' name="ohdtFmtCodeOld" value="<?php echo $tFmtCode; ?>">
                        <button style="display:none" type="submit" id="obtSubmitRecive" onclick="JSnAddEditRecive('<?= $tRoute ?>')"></button>
                        <div class="panel-body" style="padding-top:20px !important;">
                            <div class="row">
                                <div class="col-xs-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <div id="odvCompLogo">
                                            <?php
                                            if (isset($tImgObjAll) && !empty($tImgObjAll)) {
                                                $tFullPatch = './application/modules/' . $tImgObjAll;
                                                if (file_exists($tFullPatch)) {
                                                    $tPatchImg = base_url() . '/application/modules/' . $tImgObjAll;
                                                } else {
                                                    $tPatchImg = base_url() . 'application/modules/common/assets/images/200x200.png';
                                                }
                                            } else {
                                                $tPatchImg = base_url() . 'application/modules/common/assets/images/200x200.png';
                                            }
                                            ?>
                                            <img id="oimImgMasterRate" class="img-responsive xCNCenter" src="<?php echo @$tPatchImg; ?>" style="height:100%;;width:100%;">
                                        </div>
                                        <div class="form-group">
                                            <div class="xCNUplodeImage">
                                                <input type="text" class="xCNHide" id="oetImgInputRate" name="oetImgInputRate" value="<?php echo @$tImgName; ?>">
                                                <input type="text" class="xCNHide" id="oetImgInputRateOld" name="oetImgInputRateOld" value="<?php echo @$tImgName; ?>">
                                                <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('','','Rate')">
                                                    <i class="fa fa-picture-o xCNImgButton"></i> <?php echo language('common/main/main', 'tSelectPic') ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-8 col-lg-8">
                                    <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('payment/recive/recive', 'tRCVCode') ?></label>
                                    <div id="odvReciveAutoGenCode" class="form-group">
                                        <div class="validate-input">
                                            <label class="fancy-checkbox">
                                                <input type="checkbox" id="ocbReciveAutoGenCode" name="ocbReciveAutoGenCode" checked="true" value="1">
                                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div id="odvReciveCodeForm" class="form-group">
                                        <input type="hidden" id="ohdCheckDuplicateRcvCode" name="ohdCheckDuplicateRcvCode" value="1">
                                        <div class="validate-input">
                                            <input type="text" class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" maxlength="5" id="oetRcvCode" name="oetRcvCode" autocomplete="off" data-is-created="<?php echo $tRcvCode; ?>" placeholder="<?= language('promotion/voucher/voucher', 'tRCVCode') ?>" value="<?php echo $tRcvCode; ?>" data-validate-required="<?php echo language('payment/recive/recive', 'tRCVValidCode') ?>" data-validate-dublicateCode="<?php echo language('payment/recive/recive', 'tRCVValidCodeDup'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="validate-input">
                                            <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('payment/recive/recive', 'tRCVName') ?><?= language('payment/recive/recive', 'tRCVTitle') ?></label>
                                            <input type="text" class="form-control" maxlength="200" id="oetRcvName" name="oetRcvName" placeholder="<?= language('payment/recive/recive', 'tRCVName') ?><?= language('payment/recive/recive', 'tRCVTitle') ?>" autocomplete="off" value="<?php echo $tRcvName; ?>" data-validate-required="<?php echo language('payment/recive/recive', 'tRCVValidName') ?>">
                                        </div>
                                    </div>

                                    <div id="odvRcvFmtName" class="form-group">
                                        <!-- <label class="xCNLabelFrm"><?= language('payment/recive/recive', 'tRCVFormat') ?></label>
                                        <?= $tSelected ?> -->
                                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('payment/recive/recive', 'tRCVFormat') ?></label>
                                        <div class="input-group">

                                            <input type="text" autocomplete="off" class="form-control xCNHide" id="oetRcvFormatCode" name="oetRcvFormatCode" value="<?php echo $tFmtCode; ?>" >
                                            <div class="validate-input">
                                                <input type="text" class="form-control xWPointerEventNone" id="oetRcvFormatName" name="oetRcvFormatName" placeholder="" value="<?php echo $tFmtName; ?>" data-validate-required="<?php echo language('payment/recive/recive', 'tRCVValidFormatName') ?>" readonly>
                                            </div>
                                            <span class="input-group-btn">
                                                <button id="oimRcvFormatBrowse" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                            </span>
                                        </div>

                                    </div>
                                    <!-- สกุลเงิน -->
                                    <div id="odvRcvCurrencyName" class="form-group" style="display: block;">

                                        <!-- CheckBox ใช้งานหลายสกุลเงิน  -->
                                        <div class="form-group">
                                            <label class="fancy-checkbox">
                                                <input type="checkbox" id="ocbRcvMultiCur" name="ocbRcvMultiCur" <?= ($tRcvStaAllRte == '1') ? 'checked' : false ;?>>
                                                <span> <?php echo language('payment/recive/recive', 'tRCVMultiCur'); ?> </span>
                                            </label>
                                        </div>
                                        
                                        <label class="xCNLabelFrm"><?= language('payment/recive/recive','tRCVCurrency'); ?></label>
                                        <div class="input-group">
                                            <input type="text" autocomplete="off" class="form-control xCNHide" id="oetRcvCurrencyCode" name="oetRcvCurrencyCode" value="<?= $tFmtCurrencyCode; ?>">
                                            <div class="validate-input">
                                                <input type="text" class="form-control xWPointerEventNone" id="oetRcvCurrencyName" name="oetRcvCurrencyName" placeholder="" 
                                                value="<?= $tFmtCurrencyName; ?>" 
                                                data-validate-required="<?php echo language('payment/recive/recive', 'tRCVValidCurrencyName') ?>" readonly>
                                            </div>
                                            <span class="input-group-btn">
                                                <button id="obtRcvCurrencyBrowse" type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?= language('payment/recive/recive', 'tRCVStatus') ?></label>
                                        <select class="selectpicker form-control" id="ocbRcvStatus" name="ocbRcvStatus" maxlength="1">
                                            <!-- <option value=""><?= language('common/main/main', 'tCMNBlank-NA') ?></option> -->
                                            <option value="1" <?php if ($tRcvchecked == 1) {
                                                                    echo "selected";
                                                                } ?>><?= language('payment/recive/recive', 'tRCVStaActive1') ?></option>
                                            <option value="2" <?php if ($tRcvchecked == 2) {
                                                                    echo "selected";
                                                                } ?>><?= language('payment/recive/recive', 'tRCVStaActive2') ?></option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?= language('payment/recive/recive', 'tRCVRemark') ?></label>
                                        <textarea class="form-control" maxlength="100" rows="4" id="otaRcvRemark" name="otaRcvRemark"><?= $tRcvRemark ?></textarea>
                                    </div>

                                    <!-- สถานะทำรายการคืน    -->
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 row">
                                        <div class="form-group">
                                            <label class="fancy-checkbox">
                                                <?php
                                                if (isset($tRcvSpcStaAlwRet) && $tRcvSpcStaAlwRet == 1) {
                                                    $tCheckedStaAlwRet  = 'checked';
                                                } else {
                                                    $tCheckedStaAlwRet  = '';
                                                }
                                                ?>
                                                <input type="checkbox" id="ocbRcvSpcStaAlwRet" name="ocbRcvSpcStaAlwRet" <?php echo $tCheckedStaAlwRet; ?>>
                                                <span> <?php echo language('payment/recivespc/recivespc', 'tRcvSpcStaAlwRet'); ?></span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- สถานะยกเลิกรายการ -->
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 row">
                                        <div class="form-group">
                                            <label class="fancy-checkbox">
                                                <?php
                                                if (isset($tRcvSpcStaAlwCancel) && $tRcvSpcStaAlwCancel == 1) {
                                                    $tCheckedStaAlwCancel   = 'checked';
                                                } else {
                                                    $tCheckedStaAlwCancel   = '';
                                                }
                                                ?>
                                                <input type="checkbox" id="ocbRcvSpcStaAlwCancel" name="ocbRcvSpcStaAlwCancel" <?php echo $tCheckedStaAlwCancel; ?>>
                                                <span> <?php echo language('payment/recivespc/recivespc', 'tRcvSpcStaAlwCancel'); ?></span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- สถานะอนุญาตให้มีรายการอื่นต่อท้าย -->
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 row">
                                        <div class="form-group">
                                            <label class="fancy-checkbox">
                                                <?php
                                                if (isset($tRcvSpcStaPayLast) && $tRcvSpcStaPayLast == 1) {
                                                    $tCheckedStaPayLast = 'checked';
                                                } else {
                                                    $tCheckedStaPayLast = '';
                                                }
                                                ?>
                                                <input type="checkbox" id="ocbRcvSpcStaPayLast" name="ocbRcvSpcStaPayLast" <?php echo $tCheckedStaPayLast; ?>>
                                                <span> <?php echo language('payment/recivespc/recivespc', 'tRcvSpcStaPayLast'); ?></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
                <!-- Tab ReciveSpc -->
                <div id="odvRcvSpcData" class="tab-pane fade"></div>

                <!-- Tab ReciveSpcConfig -->
                <div id="odvRcvSpcConfig" class="tab-pane fade"></div>

            </div>
        </div>
    </div>
</div>
</div>

<?php include 'script/jReciveAdd.php'; ?>

<!-- div Dropdownbox -->
<div id="dropDownSelect1"></div>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>

<script type="text/javascript">
    $('.selectpicker').selectpicker();
    $(".selection-2").select2({
        minimumResultsForSearch: 20,
        dropdownParent: $('#dropDownSelect1')
    });

    $('.xWTooltipsBT').tooltip({
        'placement': 'bottom'
    });
    $('[data-toggle="tooltip"]').tooltip({
        'placement': 'top'
    });
</script>