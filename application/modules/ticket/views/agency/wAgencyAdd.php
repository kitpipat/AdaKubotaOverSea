<?php
if ($aResult['rtCode'] == "1") {
    $tAgnCode           = $aResult['raItems']['FTAgnCode'];
    $tAgnName           = $aResult['raItems']['FTAgnName'];
    $tAgnEmail          = $aResult['raItems']['FTAgnEmail'];
    $tAgnPwd            = $aResult['raItems']['FTAgnPwd'];
    $tAgnTel            = $aResult['raItems']['FTAgnTel'];
    $tAgnFax            = $aResult['raItems']['FTAgnFax'];
    $tAgnMo             = $aResult['raItems']['FTAgnMo'];
    $tAgnStaApv         = $aResult['raItems']['FTAgnStaApv'];
    $tAgnStaActive      = $aResult['raItems']['FTAgnStaActive'];
    $tAgnPplCode        = $aResult['raItems']['FTPplCode'];
    $tAgnPplName        = $aResult['raItems']['FTPplName'];
    $tAggRefCode        = $aResult['raItems']['FTAgnRefCode'];

    $tChnCode        = $aResult['raItems']['FTChnCode'];
    $tChnName        = $aResult['raItems']['FTChnName'];

    $tAgnCyCode    = $aResult['raItems']['FTCtyCode'];
    $tAgnCyName    = $aResult['raItems']['FTCtyName'];

    //route
    $tRoute             = "agencyEventEdit";
    //Event Control
    if (isset($aAlwEventAgency)) {
        if ($aAlwEventAgency['tAutStaFull'] == 1 || $aAlwEventAgency['tAutStaEdit'] == 1) {
            $nAutStaEdit = 1;
        } else {
            $nAutStaEdit = 0;
        }
    } else {
        $nAutStaEdit = 0;
    }
    $tMenuTab           = "";
    $tMenuTabToggle     = "tab";

} else {
    $tAgnCode           = "";
    $tAgnName           = "";
    $tAgnEmail          = "";
    $tAgnPwd            = "";
    $tAgnTel            = "";
    $tAgnFax            = "";
    $tAgnMo             = "";
    $tAgnStaApv         = "";
    $tAgnStaActive      = "";
    $tAgnPplCode        = "";
    $tAgnPplName        = "";
    $tAggRefCode        = "";

    $tChnCode        = "";
    $tChnName        = "";
    //route
    $tRoute         = "agencyEventAdd";
    $nAutStaEdit = 0; //Event Control

    $tMenuTab           = "disabled xCNCloseTabNav";
    $tMenuTabToggle     = "false";

    $tAgnCyCode    = "";
    $tAgnCyName    = "";
}
?>
<input type="hidden" id="ohdAngAutStaEdit" value="<?php echo $nAutStaEdit ?>">
<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddAgn">
    <button style="display:none" type="submit" id="obtSubmitAgency" onclick="JSnAddEditAgency('<?php echo  $tRoute ?>')"></button>
    <div class="panel-body">


        <div class="custom-tabs-line tabs-line-bottom left-aligned">
            <ul class="nav" role="tablist">
                <li class="nav-item active" id="oliInforGeneralTap">
                    <a class="nav-link flat-buttons active" data-toggle="tab" data-target="#odvInfoMainAgency" role="tab" aria-expanded="true">
                        <?= language('settingconfig/settingconfig/settingconfig', 'ข้อมูลทั่วไป'); ?>
                    </a>
                </li>
                <li class="nav-item <?= $tMenuTab; ?>" id="oliInforSettingConTab">
                    <a class="nav-link flat-buttons" data-toggle="<?= $tMenuTabToggle; ?>" data-target="#odvInforSettingconfig" role="tab" aria-expanded="false">
                        <?= language('settingconfig/settingconfig/settingconfig', 'tTitleTab1Settingconfig'); ?>
                    </a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="tab-content">
                    <div id="odvInfoMainAgency" class="tab-pane in active" role="tabpanel" aria-expanded="true">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="upload-img" id="oImgUpload">
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

                                            // Check Image Name
                                            // Update By 18/09/2019 Wasin(Yoshi)
                                            if (isset($tImgName) && !empty($tImgName)) {
                                                $tImageNameAgency   = $tImgName;
                                            } else {
                                                $tImageNameAgency   = '';
                                            }
                                            ?>
                                            <img id="oimImgMasterAgency" class="img-responsive xCNImgCenter" style="width: 100%;" id="" src="<?php echo $tPatchImg; ?>">
                                        </div>
                                        <div class="xCNUplodeImage">
                                            <input type="text" class="xCNHide" id="oetImgInputAgencyOld" name="oetImgInputAgencyOld" value="<?php echo @$tImageNameAgency; ?>">
                                            <input type="text" class="xCNHide" id="oetImgInputAgency" name="oetImgInputAgency" value="<?php echo @$tImageNameAgency; ?>">
                                            <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('','','Agency')"> <i class="fa fa-picture-o xCNImgButton"></i> <?php echo language('common/main/main', 'tSelectPic') ?></button>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo  language('ticket/agency/agency', 'tAggCode'); ?></label>
                                            <div id="odvAgnAutoGenCode" class="form-group">
                                                <div class="validate-input">
                                                    <label class="fancy-checkbox">
                                                        <input type="checkbox" id="ocbAgencyAutoGenCode" name="ocbAgencyAutoGenCode" checked="true" value="1">
                                                        <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="odvAgnCodeForm" class="form-group">
                                                <input type="hidden" id="ohdCheckDuplicateAgnCode" name="ohdCheckDuplicateAgnCode" value="1">
                                                <div class="validate-input">
                                                    <input type="text" class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" maxlength="5" id="oetAgnCode" name="oetAgnCode" value="<?php echo $tAgnCode ?>" autocomplete="off" data-is-created="<?php echo $tAgnCode ?>" placeholder="<?php echo  language('ticket/agency/agency', 'tAggCode') ?>" data-validate-required="<?php echo  language('ticket/agency/agency', 'tAGNValidCheckCode') ?>" data-validate-dublicateCode="<?php echo  language('ticket/agency/agency', 'tAGNValidCheckCode') ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo  language('ticket/agency/agency', 'tName'); ?><?php echo  language('ticket/agency/agency', 'tAggTitle'); ?></label>
                                            <input class="form-control" type="text" name="oetAgnName" id="oetAgnName" value="<?php echo $tAgnName; ?>" data-validate="<?php echo  language('ticket/agency/agency', 'tAgencyGroupName') ?>" autocomplete="off" placeholder="<?php echo  language('ticket/agency/agency', 'tName'); ?><?php echo  language('ticket/agency/agency', 'tAggTitle'); ?>" data-validate-required="<?php echo  language('ticket/agency/agency', 'tAGNValidName') ?>" data-validate-dublicateCode="<?php echo  language('ticket/agency/agency', 'tAGNValidName') ?>">
                                            <span class="focus-input100"></span>
                                        </div>
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo  language('ticket/agency/agency', 'tEmail'); ?></label>
                                            <input class="form-control" type="email" name="oetAgnEmail" id="oetAgnEmail" value="<?php echo $tAgnEmail; ?>" maxlength="50" data-validate="<?php echo  language('ticket/agency/agency', 'tEmail'); ?>" autocomplete="off" placeholder="<?php echo  language('ticket/agency/agency', 'tEmail'); ?>" data-validate-required="<?php echo  language('ticket/agency/agency', 'tAGNValidEmail') ?>" data-validate-dublicateCode="<?php echo  language('ticket/agency/agency', 'tAGNValidEmail') ?>">
                                            <span class="focus-input100"></span>
                                        </div>
                                        <!-- <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo  language('ticket/agency/agency', 'tPassword'); ?></label>
                        <input class="form-control" type="password" name="opwAgnPwd" id="opwAgnPwd" value="<?php echo $tAgnPwd; ?>" data-validate="<?php echo  language('ticket/agency/agency', 'tPassword'); ?>"
                        data-validate-required = "<?php echo  language('ticket/agency/agency', 'tAGNValidPwd') ?>"
                        maxlength="30" 
                        autocomplete="off"
                        placeholder="<?php echo  language('ticket/agency/agency', 'tPassword'); ?>"
                        data-validate-dublicateCode = "<?php echo  language('ticket/agency/agency', 'tAGNValidPwd') ?>"
                        >
                        <span class="focus-input100"></span>
                    </div> -->
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('customer/customer/customer', 'tCSTPplRet'); ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetAGNPplRetCode" name="oetAGNPplRetCode" value="<?php echo $tAgnPplCode; ?>">
                                                <input type="text" class="form-control xWPointerEventNone" id="oetAGNPplRetName" name="oetAGNPplRetName" value="<?php echo $tAgnPplName; ?>" readonly>
                                                <span class="input-group-btn">
                                                    <button id="oimAGNBrowsePpl" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Browse Chanel -->
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('company/warehouse/warehouse', 'tBrowseCHNName') ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetAgnChanelCode" name="oetAgnChanelCode" value="<?php echo $tChnCode; ?>">
                                                <input type="text" class="form-control xWPointerEventNone" id="oetAgnChanelName" name="oetAgnChanelName" value="<?php echo $tChnName; ?>" readonly>
                                                <span class="input-group-btn">
                                                    <button id="oimAgnBrowseChanel" type="button" class="btn xCNBtnBrowseAddOn">
                                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- อ้างอิงประเทศ -->
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('ticket/agency/agency', 'tAGNRefCountry') ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetAgnCyCode" name="oetAgnCyCode" value="<?php echo $tAgnCyCode; ?>">
                                                <input type="text" class="form-control xWPointerEventNone" id="oetAgnCyName" name="oetAgnCyName" value="<?php echo $tAgnCyName; ?>" readonly placeholder="<?= language('ticket/agency/agency', 'tAGNRefCountry'); ?>">
                                                <span class="input-group-btn">
                                                    <button id="obtAgnBrowseCountry" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- รหัสอ้างอิงตัวแทนขาย -->
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('ticket/agency/agency', 'tAGNReferAgency'); ?></label>
                                            <input type="text" maxlength="20" class="form-control" id="oetAggRefCode" name="oetAggRefCode" value="<?php echo $tAggRefCode; ?>" placeholder="<?php echo language('ticket/agency/agency', 'tAGNReferAgency'); ?>">
                                        </div>


                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo  language('ticket/agency/agency', 'tPhoneTel'); ?></label>
                                            <input class="form-control" maxlength="50" type="text" name="oetAgnTel" value="<?php echo $tAgnTel; ?>" id="oetAgnTel" placeholder="<?php echo  language('ticket/agency/agency', 'tPhoneTel'); ?>" maxlength="13" autocomplete="off">
                                            <span class="focus-input100"></span>
                                        </div>
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo  language('ticket/agency/agency', 'tFaxNumber'); ?></label>
                                            <input class="form-control" type="text" placeholder="<?php echo  language('ticket/agency/agency', 'tFaxNumber'); ?>" maxlength="50" name="oetAgnFax" value="<?php echo $tAgnFax; ?>" id="oetAgnFax" maxlength="13">
                                            <span class="focus-input100"></span>
                                        </div>
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo  language('ticket/agency/agency', 'tPhoneNumber'); ?></label>
                                            <input class="form-control" type="text" name="oetAgnMo" id="oetAgnMo" maxlength="50" placeholder="<?php echo  language('ticket/agency/agency', 'tPhoneNumber'); ?>" value="<?php echo $tAgnMo; ?>" autocomplete="off" maxlength="13">
                                            <span class="focus-input100"></span>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="input100 input100-select">
                                                                <label class="xCNLabelFrm"><?php echo  language('ticket/agency/agency', 'tAgnStaApv'); ?></label>
                                                                <div>
                                                                    <select name="ocmAgnStaApv" id="ocmAgnStaApv" class="selectpicker form-control">
                                                                        <option class="xWStaApv0" value="0"><?php echo  language('ticket/agency/agency', 'tApv'); ?></option>
                                                                        <option class="xWStaApv1" value="1"><?php echo  language('ticket/agency/agency', 'tNotApv'); ?></option>
                                                                    </select>
                                                                </div>
                                                                <span class="focus-input100"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="input100 input100-select">
                                                                <label class="xCNLabelFrm"> <?php echo  language('ticket/agency/agency', 'tAgnStaActive'); ?></label>
                                                                <div>
                                                                    <select name="ocmAgnStaActive" id="ocmAgnStaActive" class="selectpicker form-control">
                                                                        <option class="xWStaActive1" value="1"><?php echo  language('ticket/agency/agency', 'tContact'); ?></option>
                                                                        <option class="xWStaActive2" value="2"><?php echo  language('ticket/agency/agency', 'tUnContact'); ?></option>
                                                                    </select>
                                                                </div>
                                                                <span class="focus-input100"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div id="odvInforSettingconfig" class="tab-pane" role="tabpanel" aria-expanded="true"></div>


                </div>
            </div>
        </div>




    </div>
    </div>
    </div>
    </div>
</form>
<?php include "script/jAgennyAdd.php"; ?>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('application/modules/settingconfig/assets/src/settingconfig/jSettingConfig.js'); ?>"></script>