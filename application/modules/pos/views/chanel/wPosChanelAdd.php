<?php
if ($aResult['rtCode'] == "1") {
    $tChnCode = $aResult['raHDItems']['rtChnCode'];
    $tChnName = $aResult['raHDItems']['rtChnName'];
    $tChnRefCode = $aResult['raHDItems']['rtChnRefCode'];
    $tChnBchCode = $aResult['raHDItems']['rtChnBchCode'];
    $tChnBchName = $aResult['raHDItems']['rtChnBchName'];
    $tChnAgnCode = $aResult['raHDItems']['rtChnAgnCode'];
    $tChnAgnName = $aResult['raHDItems']['rtChnAgnName'];
    $tChnAppCode = $aResult['raHDItems']['rtChnAppCode'];
    $tChnAppName = $aResult['raHDItems']['rtChnAppName'];
    $tChnPplCode = $aResult['raHDItems']['rtChnPplCode'];
    $tChnPplName = $aResult['raHDItems']['rtChnPplName'];
    $tChnWahCode = $aResult['raHDItems']['rtChnWahCode'];
    $tChnWahName = $aResult['raHDItems']['rtChnWahName'];
    $tChnStaUse = $aResult['raHDItems']['rtChnStaUse'];

    $tChnSeq = $aResult['raHDItems']['rtChnSeq'];




    // $tTCGStaUse = $aResult['raHDItems']['FTChnStaUse'];
    $tRoute = "chanelEventEdit";
} else {
    $tChnCode = "";
    $tChnName = "";
    $tChnRefCode = "";
    $tRoute = "chanelEventAdd";
    $tChnBchCode = "";
    $tChnBchName = "";
    $tChnAgnCode = "";
    $tChnAgnName = "";
    $tChnAppCode = "";
    $tChnAppName = "";
    $tChnPplCode = "";
    $tChnPplName = "";
    $tChnWahCode = "";
    $tChnWahName = "";
    $tChnStaUse = 1;

    $tChnSeq = "";


    $tSesUsrLev = $this->session->userdata("tSesUsrLevel");
    $tSesUsrBchMuti =   $this->session->userdata("tSesUsrBchCodeMulti");
    $tSesUsrBchCount = $this->session->userdata("nSesUsrBchCount");
    $tSesAgnCode =  $this->session->userdata('tSesUsrAgnCode');
    $tSesAgnName =  $this->session->userdata('tSesUsrAgnName');

    $tSesUsrBchName =   $this->session->userdata("tSesUsrBchNameDefault");
    $tSesUsrBchCode = $this->session->userdata("tSesUsrBchCodeDefault");



    if ($tSesUsrLev != 'HQ') {
        $tChnAgnCode =  $tSesAgnCode;
        $tChnAgnName = $tSesAgnName;
    }

    if ($tSesUsrBchCount == 1 && $this->session->userdata("tSesUsrLoginLevel") != "HQ" && $this->session->userdata("tSesUsrLoginLevel") != "AGN") {
        $tChnBchCode = $tSesUsrBchCode;
        $tChnBchName = $tSesUsrBchName;
    }
}



$tHeadReceiptPlaceholder = "Head of Receipt";
$tEndReceiptPlaceholder = "End of Receipt";

?>
<style>
    .xWChnMoveIcon {
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

    .xWChnDyForm {
        border-radius: 0px;
        border: 0px;
    }

    .xWChnBtn {
        box-shadow: none;
    }

    .xWChnItemSelect {
        margin-bottom: 5px;
    }

    .alert-validate::before,
    .alert-validate::after {
        z-index: 100;
    }

    .input-group-addon:not(:first-child):not(:last-child),
    .input-group-btn:not(:first-child):not(:last-child),
    .input-group .form-control:not(:first-child):not(:last-child) {
        border-radius: 4px;
    }
</style>
<div class="panel panel-headline">
    <div class="panel-body">
        <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddChanel">
            <button style="display:none" type="submit" id="obtSubmitChanel" onclick="JSnAddEditChanel('<?= $tRoute ?>')"></button>
            <div class="panel-body" style="padding-top:20px !important;">
                <div class="row">
                    <div class="col-xs-12 col-md-5 col-lg-5">

                        <input type="hidden" class="input100 xCNHide" id="oetChnSeq" name="oetChnSeq"  value="<?php echo $tChnSeq; ?>">


                        <!-- <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/slipmessage/slipmessage', 'tSMGCode'); ?></label> -->
                        <label class="xCNLabelFrm"><span style="color:red">*</span>รหัสช่องทางการขาย</label>
                        <div class="form-group" id="odvSlipmessageAutoGenCode">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbSlipmessageAutoGenCode" name="ocbSlipmessageAutoGenCode" checked="true" value="1">
                                    <span><?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group" id="odvSlipmessageCodeForm">
                            <input type="hidden" id="ohdCheckDuplicateChnCode" name="ohdCheckDuplicateChnCode" value="1">
                            <div class="validate-input">
                                <input type="text" class="form-control xCNInputWithoutSpcNotThai" maxlength="5" id="oetChnCode" name="oetChnCode" data-is-created="<?php echo $tChnCode; ?>" placeholder="รหัสช่องทางการขาย" autocomplete="off" value="<?php echo $tChnCode; ?>" data-validate-required="<?php echo language('pos/slipmessage/slipmessage', 'tSMGValidCode') ?>" data-validate-dublicateCode="<?php echo language('pos/slipmessage/slipmessage', 'tSMGValidCodeDup'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="validate-input">
                                <!-- <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/slipmessage/slipmessage', 'tSMGName'); ?></label> -->
                                <label class="xCNLabelFrm"><span style="color:red">*</span>ชื่อช่องทางการขาย</label>

                                <input type="text" class="form-control" maxlength="70" id="oetChnName" name="oetChnName" autocomplete="off" placeholder="ชื่อช่องทางการขาย" value="<?php echo $tChnName; ?>" data-validate-required="<?php echo language('pos/slipmessage/slipmessage', 'tSMGValidName'); ?>">
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <div class="validate-input">
                                <label class="xCNLabelFrm">กลุ่มช่องทางการขาย</label>

                                <input type="text" class="form-control" maxlength="5" id="oetChnGroup" name="oetChnGroup" autocomplete="off" placeholder="กลุ่มช่องทางการขาย" value="<?php echo $tChnGroup; ?>">
                            </div>
                        </div> -->

                        <div class="form-group">
                            <div class="validate-input">
                                <label class="xCNLabelFrm">รหัสอ้างอิง</label>

                                <input type="text" class="form-control" maxlength="20" id="oetChnRefCode" name="oetChnRefCode" autocomplete="off" placeholder="Ref Code" value="<?php echo $tChnRefCode; ?>">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="xCNLabelFrm">ตัวแทนขาย</label>
                            <div class="input-group">
                                <input type="text" id="oetChnAgnCode" class="form-control xCNHide" name="oetChnAgnCode" value="<?php echo $tChnAgnCode; ?>">
                                <input type="text" id="oetChnAgnName" class="form-control" name="oetChnAgnName" value="<?php echo $tChnAgnName; ?>" data-validate-required="กรุณากรอกตัวแทนขาย" readonly>
                                <span class="input-group-btn">
                                    <?php
                                    // Last Update : 21/05/2020 nale  ถ้าเข้ามาเป็น User ระดับ HQ ให้เลือก Agency ได้
                                    if (!empty($this->session->userdata('tSesUsrAgnCode')) || $this->session->userdata('nSesUsrBchCount') > 0) {
                                        $tDisableBrowseAgency = 'disabled';
                                    } else {
                                        $tDisableBrowseAgency = '';
                                    }
                                    ?>
                                    <button id="obtBrowseAgency" type="button" class="btn xCNBtnBrowseAddOn" <?php echo @$tDisableBrowseAgency; ?>>
                                        <img class="xCNIconFind">
                                    </button>
                                </span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="xCNLabelFrm">สาขา</label>
                            <div class="input-group">
                                <!-- <input type="hidden" class="input100 xCNHide" id="oetChnBchCodeOld" name="oetChnBchCodeOld" maxlength="5" value="<?php echo $tChnBchCode; ?>"> -->
                                <input type="text" class="input100 xCNHide" id="oetWahBchCodeCreated" name="oetWahBchCodeCreated" maxlength="5" value="<?php echo $tChnBchCode; ?>">
                                <input class="form-control xWPointerEventNone" type="text" id="oetWahBchNameCreated" name="oetWahBchNameCreated" value="<?php echo $tChnBchName; ?>" data-validate-required="<?php echo language('company/warehouse/warehouse', 'tWAHValidbch') ?>" readonly>
                                <span class="input-group-btn xWConditionSearchPdt">
                                    <button id="obtWahBrowseBchCreated" type="button" class="btn xCNBtnBrowseAddOn" <?php echo ($this->session->userdata("nSesUsrBchCount") == 1 && $this->session->userdata("tSesUsrLoginLevel") != "HQ" && $this->session->userdata("tSesUsrLoginLevel") != "AGN" ) ? 'disabled' : ''; ?>>
                                        <img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                    </button>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('payment/recivespc/recivespc', 'tRCVSpcBrwApp'); ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNHide" id="oetChnAppCode" name="oetChnAppCode" value="<?php echo $tChnAppCode; ?>">
                                <input type="text" class="form-control xWPointerEventNone" id="oetChnAppName" name="oetChnAppName" placeholder="" value="<?php echo $tChnAppName; ?>" data-validate-required="<?php echo language('company/warehouse/warehouse', 'tWAHValidApp') ?>" readonly>
                                <span class="input-group-btn">
                                    <!-- <button id="oimRcvSpcBrowseApp" type="button" class="btn xCNBtnBrowseAddOn" <?= $aResult['rtCode'] == 1 ? 'disabled' : ''; ?>><img class="xCNIconFind"></button> -->
                                    <button id="oimChnBrowseApp" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                </span>
                            </div>
                        </div>

                        <div class="form-group" id="odvWarehouse">
                            <label class="xCNLabelFrm"><?php echo  language('company/branch/branch', 'tBCHWarehouse') ?></label>
                            <div class="input-group">
                                <!-- <input class="form-control xCNHide" id="oetBchWahCodeOld" name="oetBchWahCodeOld" maxlength="5" value="<?php echo $tWahCode ?>"> -->
                                <input class="form-control xCNHide" id="oetBchWahCode" name="oetBchWahCode" maxlength="5" value="<?php echo $tChnWahCode; ?>">
                                <input class="form-control xWPointerEventNone" type="text" id="oetBchWahName" name="oetBchWahName" value="<?php echo $tChnWahName; ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="obtBchBrowseWah" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>




                        <div class='form-group'>
                            <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem', 'tRdhCreateGroupCrPplName') ?></label>
                            <div class='input-group'>
                                <input type='text' class='form-control xCNHide xWRddAllInput' id='oetChnPplCode' name='oetChnPplCode' maxlength='5' value="<?php echo $tChnPplCode; ?>">
                                <input type='text' class='form-control xWPointerEventNone xWCPHAllInput' id='oetChnPplName' name='oetChnPplName' value="<?php echo $tChnPplName; ?>" readonly>
                                <span class='input-group-btn'>
                                    <button id='obtChnBrowsePpl' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                </span>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="fancy-checkbox">ใช้งาน
                                <?php
                                if (isset($tChnStaUse) && $tChnStaUse == 1) {
                                    $tChecked   = 'checked';
                                } else {
                                    $tChecked   = '';
                                }
                                ?>
                                <input type="checkbox" id="ocbChnStatusUse" name="ocbChnStatusUse" <?php echo $tChecked; ?>>
                                <span> <?php echo @$aTextLang['tTCGStatusUse']; ?></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- <div class="row">
                    <div class="col-md-6">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/slipmessage/slipmessage', 'tSMGSlipHead'); ?></label>
                        <div class="xWChnSortContainer" id="odvChnSlipHeadContainer">

                            <?php foreach ($aChnHeadItems as $nHIndex => $oHeadItem) : $nHIndex++; ?>
                                <div class="form-group xWChnItemSelect" id="<?php echo $nHIndex; ?>">
                                    <div class="input-group validate-input">
                                        <span class="input-group-btn">
                                            <div class="btn xWChnMoveIcon" type="button"><i class="icon-move fa fa-arrows"></i></div>
                                        </span>
                                        <input type="text" class="form-control xWChnDyForm" maxlength="50" id="oetChnSlipHead<?php echo $nHIndex; ?>" name="oetChnSlipHead[<?php echo $nHIndex; ?>]" value="<?php echo $oHeadItem; ?>" placeholder="<?php echo $tHeadReceiptPlaceholder; ?> <?php echo $nHIndex; ?>">
                                        <span class="input-group-btn">
                                            <button class="btn pull-right xWChnBtn xWChnBtnDelete" onclick="JSxChanelDeleteRow(this, event)"><?php echo language('pos/slipmessage/slipmessage', 'tSMGDeleteRow'); ?></button>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                        <div class="wrap-input100">
                            <button type="button" class="btn pull-right xWChnBtn xWChnBtnAdd" id="xWChnAddHeadRow" onclick="JSxChanelAddHeadReceiptRow()"><i class="fa fa-plus"></i> <?php echo language('pos/slipmessage/slipmessage', 'tSMGAddRow'); ?></button>
                        </div>
                    </div>
                </div> -->

                <!-- <div class="row">
                    <div class="col-md-6">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/slipmessage/slipmessage', 'tSMGSlipEnd'); ?></label>
                        <div class="xWChnSortContainer" id="odvChnSlipEndContainer">

                            <?php foreach ($aChnEndItems as $nEIndex => $oEndItem) : $nEIndex++ ?>
                                <div class="form-group xWChnItemSelect" id="<?php echo $nEIndex; ?>">
                                    <div class="input-group validate-input">
                                        <span class="input-group-btn">
                                            <div class="btn xWChnMoveIcon" type="button"><i class="icon-move fa fa-arrows"></i></div>
                                        </span>
                                        <input type="text" class="form-control xWChnDyForm" maxlength="50" id="oetChnSlipEnd<?php echo $nEIndex; ?>" name="oetChnSlipEnd[<?php echo $nEIndex; ?>]" value="<?php echo $oEndItem; ?>" placeholder="<?php echo $tEndReceiptPlaceholder; ?> <?php echo $nEIndex; ?>">
                                        <span class="input-group-btn">
                                            <button class="btn pull-right xWChnBtn xWChnBtnDelete" onclick="JSxChanelDeleteRow(this, event)"><?= language('pos/slipmessage/slipmessage', 'tSMGDeleteRow') ?></button>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                        <div class="wrap-input100">
                            <button type="button" class="btn pull-right xWChnBtn xWChnBtnAdd" id="xWChnAddEndRow" onclick="JSxChanelAddEndReceiptRow()"><i class="fa fa-plus"></i> <?php echo language('pos/slipmessage/slipmessage', 'tSMGAddRow'); ?></button>
                        </div>
                    </div>
                </div> -->

            </div>
        </form>
    </div>
</div>

<script type="text/html" id="oscSlipHeadRowTemplate">
    <div class="form-group xWChnItemSelect" id="{0}">
        <div class="input-group validate-input">
            <span class="input-group-btn">
                <div class="btn xWChnMoveIcon" type="button"><i class="icon-move fa fa-arrows"></i></div>
            </span>
            <input type="text" class="form-control xWChnDyForm" maxlength="50" id="oetChnSlipHead{0}" name="oetChnSlipHead[{0}]" value="" placeholder="<?php echo $tHeadReceiptPlaceholder; ?> {0}" data-validate="<?php echo language('pos/slipmessage/slipmessage', 'tSMGValidHead'); ?>">
            <span class="input-group-btn">
                <button class="btn pull-right xWChnBtn xWChnBtnDelete" onclick="JSxChanelDeleteRowHead(this, event)"><?php echo language('pos/slipmessage/slipmessage', 'tSMGDeleteRow'); ?></button>
            </span>
        </div>
    </div>
</script>
<script type="text/html" id="oscSlipEndRowTemplate">
    <div class="form-group xWChnItemSelect" id="{0}">
        <div class="input-group validate-input">
            <span class="input-group-btn">
                <div class="btn xWChnMoveIcon" type="button"><i class="icon-move fa fa-arrows"></i></div>
            </span>
            <input type="text" class="form-control xWChnDyForm" maxlength="50" id="oetChnSlipEnd{0}" name="oetChnSlipEnd[{0}]" value="" placeholder="<?php echo $tEndReceiptPlaceholder; ?> {0}">
            <span class="input-group-btn">
                <button class="btn pull-right xWChnBtn xWChnBtnDelete" onclick="JSxChanelDeleteRowEnd(this, event)"><?php echo language('pos/slipmessage/slipmessage', 'tSMGDeleteRow'); ?></button>
            </span>
        </div>
    </div>
</script>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>
<?php include 'script/jPosChanelAdd.php'; ?>

<script type="text/javascript">
    $(function() {
        if (JCNbChanelIsCreatePage()) { // For create page

            // Set head of receipt default
            JSxChanelRowDefualt('head', 1);
            // Set end of receipt default
            JSxChanelRowDefualt('end', 1);

        } else { // for update page

            if (JCNnChanelCountRow('head') <= 0) {
                // Set head of receipt default
                JSxChanelRowDefualt('head', 1);
            }
            if (JCNnChanelCountRow('end') <= 0) {
                // Set end of receipt default
                JSxChanelRowDefualt('end', 1);
            }

        }
        JSaChanelGetSortData('head');
        // Remove sort data
        JSxChanelRemoveSortData('all');

        $('#odvChnSlipHeadContainer').sortable({
            items: '.xWChnItemSelect',
            opacity: 0.7,
            axis: 'y',
            handle: '.xWChnMoveIcon',
            update: function(event, ui) {
                var aToArray = $(this).sortable('toArray');
                var aSerialize = $(this).sortable('serialize', {
                    key: ".sort"
                });
                // JSxChanelSetRowSortData('head', aToArray);
                // JSoChanelSortabled('head', true);
            }
        });

        $('#odvChnSlipEndContainer').sortable({
            items: '.xWChnItemSelect',
            opacity: 0.7,
            axis: 'y',
            handle: '.xWChnMoveIcon',
            update: function(event, ui) {
                var aToArray = $(this).sortable('toArray');
                var aSerialize = $(this).sortable('serialize', {
                    key: ".sort"
                });
                // JSxChanelSetRowSortData('end', aToArray);
                // JSoChanelSortabled('end', true);
            }
        });

        $('.xWTooltipsBT').tooltip({
            'placement': 'bottom'
        });
        $('[data-toggle="tooltip"]').tooltip({
            'placement': 'top'
        });

        $('#oimChnBrowseProvince').click(function() {
            JCNxBrowseData('oPvnOption');
        });

        if (JCNbChanelIsUpdatePage()) {
            $("#obtGenCodeChanel").attr("disabled", true);
        }
    });

    var nLangEdits = '<?php echo $this->session->userdata("tLangEdit") ?>';
    var nStaPdtBrowseType = $('#ohdPdtStaBrowseType').val();

    // Click Browse Agency
    $('#obtBrowseAgency').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oPdtBrowseAgency({
                'tReturnInputCode': 'oetChnAgnCode',
                'tReturnInputName': 'oetChnAgnName',
                'tBchCodeWhere': $('#oetPdtBchCode').val(),
            });
            JCNxBrowseData('oPdtBrowseAgencyOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });



    //เลือกตัวแทนขาย
    var oPdtBrowseAgency = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;
        var tBchCodeWhere = poReturnInput.tBchCodeWhere;

        var tSesLev = '<?php echo $this->session->userdata('tSesUsrLevel'); ?>'
        var tSesAgenCde = '<?php echo $this->session->userdata('tSesUsrAgnCode'); ?>'

        var tWhereAgn = '';
        if (tSesLev != 'HQ') {
            tWhereAgn = " AND TCNMBranch.FTAgnCode = '" + tSesAgenCde + "'";
        } else {
            tWhereAgn = '';
        }

        var oOptionReturn = {
            Title: ['ticket/agency/agency', 'tAggTitle'],
            Table: {
                Master: 'TCNMAgency',
                PK: 'FTAgnCode'
            },
            Join: {
                Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [
                    tWhereAgn
                ]
            },
            GrideView: {
                ColumnPathLang: 'ticket/agency/agency',
                ColumnKeyLang: ['tAggCode', 'tAggName'],
                ColumnsSize: ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMAgency.FTAgnCode"],
                Text: [tInputReturnName, "TCNMAgency_L.FTAgnName"],
            },
            RouteAddNew: 'agency',
            BrowseLev: nStaPdtBrowseType,
            NextFunc: {
                FuncName: 'JSxClearBrowseConditionAgn',
                ArgReturn: ['FTAgnCode']
            }
        }
        return oOptionReturn;
    }

    function JSxClearBrowseConditionAgn(ptData) {
        // aData = JSON.parse(ptData);
        if (ptData != '' || ptData != 'NULL') {

            $('#oetWahBchCodeCreated').val('');
            $('#oetWahBchNameCreated').val('');

            $('#oetBchWahCode').val('');
            $('#oetBchWahName').val('');
        }
    }

    // ระบบ
    $('#oimChnBrowseApp').click(function() {
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowsetSysApp');
    });

    // ระบบ
    var oBrowsetSysApp = {
        Title: ['payment/recivespc/recivespc', 'tBrowseAppTitle'],
        Table: {
            Master: 'TSysApp',
            PK: 'FTAppCode'
        },
        Join: {
            Table: ['TSysApp_L'],
            On: ['TSysApp_L.FTAppCode = TSysApp.FTAppCode AND TSysApp_L.FNLngID =' + nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'payment/recivespc/recivespc',
            ColumnKeyLang: ['tBrowseAppCode', 'tBrowseAppName'],
            ColumnsSize: ['15%', '75%'],
            DataColumns: ['TSysApp.FTAppCode', 'TSysApp_L.FTAppName'],
            DataColumnsFormat: ['', ''],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TSysApp.FTAppCode ASC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetChnAppCode", "TSysApp.FTAppCode"],
            Text: ["oetChnAppName", "TSysApp_L.FTAppName"]
        },
        // NextFunc: {
        //     FuncName: 'JSxNextFuncRcvSpc',
        //     ArgReturn: ['FTAppCode']
        // },
    };

    $('#obtChnBrowsePpl').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRptRddCstPriOptionFrom = undefined;
            oRptRddCstPriOptionFrom = oRptCstPriOption({
                'tReturnInputCode': 'oetChnPplCode',
                'tReturnInputName': 'oetChnPplName',

                'aArgReturn': ['FTPplCode', 'FTPplName']
            });
            JCNxBrowseData('oRptRddCstPriOptionFrom');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    var oRptCstPriOption = function(poReturnInputCstPri) {

        let aArgReturnCstPri = poReturnInputCstPri.aArgReturn;
        let tInputReturnCodeCstPri = poReturnInputCstPri.tReturnInputCode;
        let tInputReturnNameCstPri = poReturnInputCstPri.tReturnInputName;
        let oOptionReturnCstPri = {
            Title: ['product/pdtpricelist/pdtpricelist', 'tPPLTitle'],
            Table: {
                Master: 'TCNMPdtPriList',
                PK: 'FTPplCode',
                PKName: 'FTPplName'
            },
            Join: {
                Table: ['TCNMPdtPriList_L'],
                On: ['TCNMPdtPriList_L.FTPplCode = TCNMPdtPriList.FTPplCode AND TCNMPdtPriList_L.FNLngID = ' + nLangEdits]
            },
            GrideView: {
                ColumnPathLang: 'product/pdtpricelist/pdtpricelist',
                ColumnKeyLang: ['tPPLTBCode', 'tPPLTBName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMPdtPriList.FTPplCode', 'TCNMPdtPriList_L.FTPplName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMPdtPriList_L.FTPplCode ASC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCodeCstPri, "TCNMPdtPriList.FTPplCode"],
                Text: [tInputReturnNameCstPri, "TCNMPdtPriList_L.FTPplName"]
            },

            RouteAddNew: 'pdtpricelist',
            BrowseLev: 0
        };
        return oOptionReturnCstPri;
    };


    /*===== Begin Browse ===============================================================*/



    // สาขาที่สร้าง
    $("#obtWahBrowseBchCreated").click(function() {
        var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
        var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        var nCountBch = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
        var tAgnCodeWhere = $('#oetChnAgnCode').val()
        var tWhere = "";
        var tWhereAgn = '';

        // if (nCountBch == 1) {
        //     $('#obtWahBrowseBchCreated').attr('disabled', true);
        // }
        if (tUsrLevel != "HQ") {
            tWhere = " AND TCNMBranch.FTBchCode IN (" + tBchCodeMulti + ") ";

        } else {
            tWhere = "";
        }

        if (tAgnCodeWhere == '' || tAgnCodeWhere == null) {
            tWhereAgn = '';
        } else {
            tWhereAgn = " AND TCNMBranch.FTAgnCode = '" + tAgnCodeWhere + "'";
        }
        // option 
        window.oWahBrowseBchCreated = {
            Title: ['authen/user/user', 'tBrowseBCHTitle'],
            Table: {
                Master: 'TCNMBranch',
                PK: 'FTBchCode'
            },
            Join: {
                Table: ['TCNMBranch_L'],
                On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [
                    tWhere + tWhereAgn
                ]
            },
            GrideView: {
                ColumnPathLang: 'authen/user/user',
                ColumnKeyLang: ['tBrowseBCHCode', 'tBrowseBCHName'],
                ColumnsSize: ['10%', '75%'],
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMBranch.FTBchCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetWahBchCodeCreated", "TCNMBranch.FTBchCode"],
                Text: ["oetWahBchNameCreated", "TCNMBranch_L.FTBchName"]
            },
            // DebugSQL: true,
            NextFunc: {
                FuncName: 'JSxClearBrowseConditionBch',
                ArgReturn: ['FTBchCode']
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oWahBrowseBchCreated');
    });


    function JSxClearBrowseConditionBch(ptData) {
        // aData = JSON.parse(ptData);
        if (ptData != '' || ptData != 'NULL') {


            $('#oetBchWahCode').val('');
            $('#oetBchWahName').val('');
        }
    }

    $('#obtBchBrowseWah').click(function() {
        JSxCheckPinMenuClose();
        var tPOSBchCodeParam = $('#oetWahBchCodeCreated').val();
        window.oBrowsePosOption = undefined;
        oBrowsePosOption = oBrowsePosBch({
            'tPOSBchCodeParam': tPOSBchCodeParam
        });
        JCNxBrowseData('oBrowsePosOption');
    });

    // Add warehouse
    var oBrowsePosBch = function(poDataFnc) {
        var tPOSBchCodeParam = poDataFnc.tPOSBchCodeParam;

        // var tPosType = $('#ocmPosType').val();
        var tBchCode = $('#oetWahBchCodeCreated').val();
        var tWhereSraType = '';
        // if (tPosType == 1) {
        //     var tWhereSraType = "AND TCNMWaHouse.FTWahStaType = '2' AND (TCNMWaHouse.FTWahRefCode = '' OR TCNMWaHouse.FTWahRefCode IS NULL)";
        // } else {
        //     var tWhereSraType = "AND TCNMWaHouse.FTWahStaType = '6' AND (TCNMWaHouse.FTWahRefCode = '' OR TCNMWaHouse.FTWahRefCode IS NULL)";
        // }

        if ($("#oetWahBchCodeCreated").val() != "") {
            tWhereSraType += " AND TCNMWaHouse.FTBchCode = '" + tBchCode + "'";
        } else {
            tWhereSraType += " AND TCNMWaHouse.FTBchCode = '99999'";
        }

        var oOptionReturn = {
            Title: ['company/warehouse/warehouse', 'tWAHTitle'],
            Table: {
                Master: 'TCNMWaHouse',
                PK: 'FTWahCode'
            },
            Join: {
                Table: ['TCNMWaHouse_L'],
                On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode  AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
            },
            Where: {
                Condition: [tWhereSraType]
            },
            GrideView: {
                ColumnPathLang: 'company/warehouse/warehouse',
                ColumnKeyLang: ['tWahCode', 'tWahName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                DataColumnsFormat: ['', ''],
                Perpage: 5,
                OrderBy: ['TCNMWaHouse.FTWahCode'],
                SourceOrder: "ASC"
            },

            CallBack: {
                ReturnType: 'S',
                Value: ["oetBchWahCode", "TCNMWaHouse.FTWahCode"],
                Text: ["oetBchWahName", "TCNMWaHouse_L.FTWahName"],
            },
            NextFunc: {
                FuncName: 'JSxValidFormAddEditSaleMachineTapGeneral',
                ArgReturn: []
            },

            RouteFrom: 'chanel',
            RouteAddNew: 'warehouse',
            // BrowseLev: nStaPosBrowseType,
        }
        return oOptionReturn;
    }
    /*===== End Browse =================================================================*/
</script>

<?php include 'script/wPosChanelScript.php'; ?>