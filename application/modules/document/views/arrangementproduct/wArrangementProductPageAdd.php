<?php
    if ( isset($aDataDocHD) && $aDataDocHD['rtCode'] == '1' ) {
        // echo '<pre>';
        // print_r($_SESSION);
        // echo '</pre>';
        $aDataDocHD              = $aDataDocHD['raItems'];
        $tPAMRoute               = "docPAMEventEdit";
        $tPAMDocNo               = $aDataDocHD['FTXthDocNo'];
        $tPAMDocType             = $aDataDocHD['FNXthDocType'];
        $dPAMDocDate             = date("Y-m-d", strtotime($aDataDocHD['FDXthDocDate']));
        $dPAMDocTime             = date("H:i", strtotime($aDataDocHD['FDXthDocDate']));
        $tPAMCreateBy            = $aDataDocHD['FTCreateBy'];
        $tPAMUsrNameCreateBy     = $aDataDocHD['FTUsrName'];
        $tPAMStaDoc              = $aDataDocHD['FTXthStaDoc'];
        $tPAMStaApv              = $aDataDocHD['FTXthStaApv'];
        $tPAMStaPrcStk           = '';
        $tPAMSesUsrBchCode       = $this->session->userdata("tSesUsrBchCodeDefault");
        $tPAMUsrCode             = $this->session->userdata('tSesUsername');
        $tPAMLangEdit            = $this->session->userdata("tLangEdit");
        $tPAMApvCode             = $aDataDocHD['FTXthApvCode'];
        $tPAMUsrNameApv          = $aDataDocHD['FTXthApvName'];
        $nPAMStaRef              = $aDataDocHD['FNXthStaRef'];
        $tPAMBchCode             = $aDataDocHD['FTBchCode'];
        $tPAMBchName             = $aDataDocHD['FTBchName'];
        $nPAMStaDocAct           = $aDataDocHD['FNXthStaDocAct'];
        $tPAMFrmDocPrint         = $aDataDocHD['FNXthDocPrint'];
        $tPAMFrmRmk              = $aDataDocHD['FTXthRmk'];
        $nStaUploadFile          = 2;
        $tPAMPlcCode             = $aDataDocHD['FTPlcCode'];
        $tPAMPlcName             = $aDataDocHD['FTPlcName'];
        $tPAMStaDocAuto          = $aDataDocHD['FTXthStaDocAuto'];
        $tPAMDataInputBchCodeTo  = $aDataDocHD['FTXshBchTo'];
        $tPAMDataInputBchNameTo  = $aDataDocHD['FTXshBchNameTo'];
        $tPAMAgnCode             = $aDataDocHD['rtAgnCode'];
        $tPAMAgnName             = $aDataDocHD['rtAgnName'];

        $aPAMCatCode = array(
            '1' => $aDataDocHD['FTCat1Code'],
            '2' => $aDataDocHD['FTCat2Code']
        );

        $aPAMCatName = array(
            '1' => $aDataDocHD['FTCat1Name'],
            '2' => $aDataDocHD['FTCat2Name']
        );
    } else {
        $tPAMRoute               = "docPAMEventAdd";
        $tPAMDocNo               = "";
        $tPAMDocType             = "11";
        $dPAMDocDate             = date("Y-m-d");
        $dPAMDocTime             = date('H:i:s');
        $tPAMCreateBy            = $this->session->userdata('tSesUsrUsername');
        $tPAMUsrNameCreateBy     = $this->session->userdata('tSesUsrUsername');
        $nPAMStaRef              = 0;
        $tPAMStaDoc              = 1;
        $tPAMStaApv              = NULL;
        $tPAMStaPrcStk           = NULL;
        $tPAMSesUsrBchCode       = $this->session->userdata("tSesUsrBchCodeDefault");
        $tPAMUsrCode             = $this->session->userdata('tSesUsername');
        $tPAMLangEdit            = $this->session->userdata("tLangEdit");
        $tPAMApvCode             = "";
        $tPAMUsrNameApv          = "";
        $tPAMBchCode             = "";
        $tPAMBchName             = "";
        $nPAMStaDocAct           = "1";
        $tPAMFrmDocPrint         = "";
        $tPAMFrmRmk              = "";
        $nStaUploadFile          = 1;
        $tPAMPlcCode             = "";
        $tPAMPlcName             = "";
        $tPAMStaDocAuto          = "";
        $tPAMDataInputBchCodeTo  = "";
        $tPAMDataInputBchNameTo  = "";
        $tPAMAgnCode             = "";
        $tPAMAgnName             = "";
        $aPAMCatCode = array(
            '1' => "",
            '2' => ""
        );

        $aPAMCatName = array(
            '1' => "",
            '2' => ""
        );
    }

    //กำหนดค่า
    $tSesUsrLevel   = $this->session->userdata('tSesUsrLevel');
    $tUserBchName   = $this->session->userdata('tSesUsrBchNameDefault');
    $tUserBchCode   = $this->session->userdata('tSesUsrBchCodeDefault');
    $tUserWahName   = $this->session->userdata('tSesUsrWahName');
    $tUserWahCode   = $this->session->userdata('tSesUsrWahCode');
    $nLangEdit      = $this->session->userdata("tLangEdit");
    $tUsrApv        = $this->session->userdata("tSesUsername");
    $tUserLoginLevel= $this->session->userdata("tSesUsrLevel");
    $bIsApv         = empty($tPAMStaApv) ? false : true;
    $bIsCancel      = ($tPAMStaDoc == "3") ? true : false;
    $bIsApvOrCancel = ($bIsApv || $bIsCancel);
    $bIsMultiBch    = $this->session->userdata("nSesUsrBchCount") > 1;
?>

<script>
	var nLangEdit           = '<?=$nLangEdit; ?>';
	var tUsrApv             = '<?=$tUsrApv; ?>';
	var tUserLoginLevel     = '<?=$tUserLoginLevel; ?>';
	var bIsApv              = <?=($bIsApv) ? 'true' : 'false'; ?>;
	var bIsCancel           = <?=($bIsCancel) ? 'true' : 'false'; ?>;
	var bIsApvOrCancel      = <?=($bIsApvOrCancel) ? 'true' : 'false'; ?>;
    var tPAMStaDoc          = '<?=$tPAMStaDoc; ?>';
	var tPAMStaApv          = '<?=$tPAMStaApv; ?>';
	var bIsMultiBch         = <?=($bIsMultiBch) ? 'true' : 'false'; ?>;
</script>

<style>
    #odvRowDataEndOfBill .panel-heading {
        padding-top: 10px !important;
        padding-bottom: 10px !important;
    }

    #odvRowDataEndOfBill .panel-body {
        padding-top: 0px !important;
        padding-bottom: 0px !important;
    }

    #odvRowDataEndOfBill .list-group-item {
        padding-left: 0px !important;
        padding-right: 0px !important;
        border: 0px solid #ddd;
    }

    .mark-font, .panel-default > .panel-heading.mark-font{
        color           : #232C3D !important;
        font-weight     : 900;
    }
</style>

<form id="ofmPAMFormAdd" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <input type="hidden" id="ohdPAMRoute"                   name="ohdPAMRoute"                  value="<?=$tPAMRoute; ?>">
    <input type="hidden" id="ohdPAMODecimalShow"            name="ohdPAMODecimalShow"           value="<?=$nOptDecimalShow; ?>">
    <input type="hidden" id="ohdPAMStaDoc"                  name="ohdPAMStaDoc"                 value="<?=$tPAMStaDoc; ?>">
    <input type="hidden" id="ohdPAMStaApv"                  name="ohdPAMStaApv"                 value="<?=$tPAMStaApv; ?>">
    <input type="hidden" id="ohdPAMBchCode"                 name="ohdPAMBchCode"                value="<?=$tPAMBchCode; ?>">
    <input type="hidden" id="ohdPAMLangEdit"                name="ohdPAMLangEdit"               value="<?=$tPAMLangEdit; ?>">
    <input type="hidden" id="ohdSesSessionID"               name="ohdSesSessionID"              value="<?=$this->session->userdata('tSesSessionID') ?>">
    <input type="hidden" id="ohdPAMVATInOrEx"               name="ohdPAMVATInOrEx"              value="">
    <input type="hidden" id="ohdPAMStaDocAuto"              name="ohdPAMStaDocAuto"             value="<?=$tPAMStaDocAuto?>">
    <input type="hidden" id="ohdPAMDocType"                 name="ohdPAMDocType"                value="<?=$tPAMDocType?>">
    <input type="hidden" id="ohdPAMAlwQtyPickNotEqQtyOrd"   name="ohdPAMAlwQtyPickNotEqQtyOrd"  value="<?php if(isset($bAlwQtyPickNotEqQtyOrd)){ echo "true"; }else{ echo "false"; }?>">
    <input type="hidden" id="ohdPAMValidatePdt"             name="ohdPAMValidatePdt"            value="<?= language('document/productarrangement/productarrangement', 'tPAMPleaseSeletedPDTIntoTable') ?>">

    <button style="display:none" type="submit" id="obtPAMSubmitDocument" onclick="JSxPAMAddEditDocument()"></button>
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <!-- Panel รหัสเอกสารและสถานะเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvPAMHeadStatusInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/productarrangement/productarrangement', 'tPAMDoucment'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvPAMDataStatusInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvPAMDataStatusInfo" class="panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group xCNHide" style="text-align: right;">
                                    <label class="text-success xCNTitleFrom"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmAppove'); ?></label>
                                </div>
                                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/productarrangement/productarrangement', 'tPAMLabelFrmDocNo'); ?></label>
                                <?php if (isset($tPAMDocNo) && empty($tPAMDocNo)) : ?>
                                    <div class="form-group">
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbPAMStaAutoGenCode" name="ocbPAMStaAutoGenCode" maxlength="1" checked="checked">
                                            <span>&nbsp;</span>
                                            <span class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMLabelFrmAutoGenCode'); ?></span>
                                        </label>
                                    </div>
                                <?php endif; ?>
                                <!-- เลขรหัสเอกสาร -->
                                <div class="form-group" style="cursor:not-allowed">
                                    <input type="text" class="form-control xControlForm xCNGenarateCodeTextInputValidate xCNInputWithoutSpcNotThai" id="oetPAMDocNo" name="oetPAMDocNo" maxlength="20" value="<?php echo $tPAMDocNo; ?>" data-validate-required="<?php echo language('document/purchaseorder/purchaseorder', 'tPAMPlsEnterOrRunDocNo'); ?>" data-validate-duplicate="<?php echo language('document/purchaseorder/purchaseorder', 'tPAMPlsDocNoDuplicate'); ?>" placeholder="<?php echo language('document/productarrangement/productarrangement', 'tPAMLabelFrmDocNo'); ?>" style="pointer-events:none" readonly>
                                    <input type="hidden" id="ohdPAMCheckDuplicateCode" name="ohdPAMCheckDuplicateCode" value="2">
                                </div>
                                <!-- วันที่ในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMLabelFrmDocDate'); ?></label>
                                    <div class="input-group">
                                        <?php if ($dPAMDocDate == '') {
                                            $dPAMDocDate = '';
                                        } ?>
                                        <input type="text" class="form-control xControlForm xCNDatePicker xCNInputMaskDate" id="oetPAMDocDate" name="oetPAMDocDate" value="<?php echo $dPAMDocDate; ?>">
                                        <span class="input-group-btn">
                                            <button id="obtPAMDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- เวลาในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMLabelFrmDocTime'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xControlForm xCNTimePicker xCNInputMaskTime" id="oetPAMDocTime" name="oetPAMDocTime" value="<?php echo $dPAMDocTime; ?>">
                                        <span class="input-group-btn">
                                            <button id="obtPAMDocTime" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- ผู้สร้างเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMLabelFrmCreateBy'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <input type="hidden" id="ohdPAMCreateBy" name="ohdPAMCreateBy" value="<?php echo $tPAMCreateBy ?>">
                                            <label><?php echo $tPAMUsrNameCreateBy ?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- สถานะเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMLabelFrmStaDoc'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <?php
                                            if ($tPAMRoute == "docPAMEventAdd") {
                                                $tPAMLabelStaDoc  = language('document/purchaseorder/purchaseorder', 'tPOLabelFrmValStaDoc');
                                            } else {
                                                $tPAMLabelStaDoc  = language('document/purchaseorder/purchaseorder', 'tPOLabelFrmValStaDoc' . $tPAMStaDoc);
                                            }
                                            ?>
                                            <label><?php echo $tPAMLabelStaDoc; ?></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- สถานะอนุมัติเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMLabelFrmStaApv'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmValStaApv' . $tPAMStaApv); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <?php if (isset($tPAMDocNo) && !empty($tPAMDocNo)) : ?>
                                    <!-- ผู้อนุมัติเอกสาร -->
                                    <div class="form-group" style="margin:0">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMLabelFrmApvBy'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                                <input type="hidden" id="ohdPAMApvCode" name="ohdPAMApvCode" maxlength="20" value="<?php echo $tPAMApvCode ?>">
                                                <label>
                                                    <?php echo (isset($tPAMUsrNameApv) && !empty($tPAMUsrNameApv)) ? $tPAMUsrNameApv : "-" ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel เงื่อนไข -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvPAMCondition" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/productarrangement/productarrangement', 'tPAMCondition'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvPAMConditionList" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvPAMConditionList" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">

                                <!-- ตัวแทนขาย -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMAgency') ?></label>
                                    <div class="input-group"><input type="text" class="form-control xControlForm xCNHide" id="oetPAMAgnCode" name="oetPAMAgnCode" maxlength="5" value="<?= $tPAMAgnCode ?>">
                                        <input type="text" class="form-control xControlForm xWPointerEventNone" id="oetPAMAgnName" name="oetPAMAgnName" maxlength="100" placeholder="<?php echo language('document/productarrangement/productarrangement', 'tPAMAgency') ?>" value="<?= $tPAMAgnName ?>" readonly>
                                        <span class="input-group-btn">
                                            <button id="obtPAMBrowseAgn" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- สาขาที่สร้าง -->
                                <?php
                                    // if($tPAMRoute == "docPAMEventAdd"){
                                    //     $tPAMDataInputBchCode    = $this->session->userdata('tSesUsrBchCodeDefault');
                                    //     $tPAMDataInputBchName    = $this->session->userdata('tSesUsrBchNameDefault');
                                    // }else{
                                        $tPAMDataInputBchCode    = $tPAMBchCode;
                                        $tPAMDataInputBchName    = $tPAMBchName;
                                    // }
                                ?>
                                <script>
                                    var tUsrLevel = '<?=$this->session->userdata('tSesUsrLevel')?>';
                                    if( tUsrLevel != "HQ" ){
                                        //BCH - SHP
                                        var tBchCount = '<?=$this->session->userdata("nSesUsrBchCount")?>';
                                        if(tBchCount < 2){
                                            $('#obtPAMBrowseBch').attr('disabled',true);
                                        }
                                    }
                                </script>

                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tDocBchCreate') ?></label>
                                    <div class="input-group"><input type="text" class="form-control xControlForm xCNHide" id="oetPAMBchCode" name="oetPAMBchCode" maxlength="5" value="<?=$tPAMDataInputBchCode?>">
                                        <input type="text" class="form-control xControlForm xWPointerEventNone" 
                                            id="oetPAMBchName" name="oetPAMBchName" maxlength="100" 
                                            placeholder="<?php echo language('document/productarrangement/productarrangement', 'tDocBchCreate') ?>" 
                                            value="<?=$tPAMDataInputBchName?>" 
                                            data-validate-required = "<?php echo language('document/productarrangement/productarrangement', 'tPAMPlsEnterBch') ?>"
                                            readonly>
                                        <span class="input-group-btn">
                                            <button id="obtPAMBrowseBch" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <!-- ไปยังสาขา -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tDocBchTo') ?></label>
                                    <div class="input-group"><input type="text" class="form-control xControlForm xCNHide" id="oetPAMBchCodeTo" name="oetPAMBchCodeTo" maxlength="5" value="<?=$tPAMDataInputBchCodeTo?>">
                                        <input type="text" class="form-control xControlForm xWPointerEventNone" 
                                        id="oetPAMBchNameTo" name="oetPAMBchNameTo" maxlength="100" 
                                        placeholder="<?php echo language('document/productarrangement/productarrangement', 'tDocBchTo') ?>" 
                                        value="<?=$tPAMDataInputBchNameTo?>" 
                                        data-validate-required = "<?php echo language('document/productarrangement/productarrangement', 'tPAMPlsEnterBch') ?>"
                                        readonly>
                                        <span class="input-group-btn">
                                            <button id="obtPAMBrowseBchTo" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <!-- ที่เก็บ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMLocation') ?></label>
                                    <div class="input-group"><input type="text" class="form-control xControlForm xCNHide" id="oetPAMPlcCode" name="oetPAMPlcCode" maxlength="5" value="<?=$tPAMPlcCode?>">
                                        <input type="text" class="form-control xControlForm xWPointerEventNone" id="oetPAMPlcName" name="oetPAMPlcName" maxlength="100" placeholder="<?php echo language('document/productarrangement/productarrangement', 'tPAMLocation') ?>" value="<?=$tPAMPlcName?>" readonly>
                                        <span class="input-group-btn">
                                            <button id="obtPAMBrowsePlc" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <!-- หมวดสินค้า 1-2 -->
                                <?php for($i=1;$i<=2;$i++){ ?>
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMCat'.$i) ?></label>
                                    <div class="input-group"><input type="text" class="form-control xControlForm xCNHide" id="oetPAMCat<?=$i?>Code" name="oetPAMCat<?=$i?>Code" maxlength="10" value="<?=$aPAMCatCode[$i]?>">
                                        <input type="text" class="form-control xControlForm xWPointerEventNone" id="oetPAMCat<?=$i?>Name" name="oetPAMCat<?=$i?>Name" maxlength="100" placeholder="<?php echo language('document/productarrangement/productarrangement', 'tPAMCat'.$i) ?>" value="<?=$aPAMCatName[$i]?>" readonly>
                                        <span class="input-group-btn">
                                            <button id="obtPAMBrowseCat<?=$i?>" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <?php } ?>
                                
                                <!-- สถานะอ้างอิง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMPackingType'); ?></label>
                                    <?php
                                    if($tPAMRoute == "docPAMEventAdd"){ ?>
                                        <select class="selectpicker xWPAMDisabledOnApv form-control xControlForm" id="ocmPAMPackType" name="ocmPAMPackType" maxlength="12">
                                            <option value="11" <?php if ($tPAMDocType=='11') { echo "selected";} ?>><?php echo language('document/productarrangement/productarrangement', 'tPAMDocType1'); ?></option>
                                            <option value="13" <?php if ($tPAMDocType=='13') { echo "selected";} ?>><?php echo language('document/productarrangement/productarrangement', 'tPAMDocType2'); ?></option>
                                        </select>
                                    <?php }else{ //ขาแก้ไขเปลี่ยน ประเภทไม่ได้ ?>
                                        <input type="hidden" id="ocmPAMPackType" name="ocmPAMPackType" value="<?=$tPAMDocType?>">
                                        <input type="text" readonly class="form-control" value="<?= ($tPAMDocType=='11') ? language('document/productarrangement/productarrangement', 'tPAMDocType1') : language('document/productarrangement/productarrangement', 'tPAMDocType2') ?>">
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel อืนๆ -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvPAMInfoOther" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/productarrangement/productarrangement', 'อื่นๆ'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvPAMDataInfoOther" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvPAMDataInfoOther" class="panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
                                <!-- สถานะความเคลื่อนไหว -->
                                <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbPAMFrmInfoOthStaDocAct" name="ocbPAMFrmInfoOthStaDocAct" <?php echo ($nPAMStaDocAct == '1') ? 'checked' : ''; ?>>
                                        <span>&nbsp;</span>
                                        <span class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmInfoOthStaDocAct'); ?></span>
                                    </label>
                                </div>
                                <!-- สถานะอ้างอิง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmInfoOthRef'); ?></label>
                                    <select class="selectpicker xWPAMDisabledOnApv form-control xControlForm" id="ocmPAMFrmInfoOthRef" name="ocmPAMFrmInfoOthRef" maxlength="1">
                                        <option value="0" selected><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmInfoOthRef0'); ?></option>
                                        <option value="1"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmInfoOthRef1'); ?></option>
                                        <option value="2"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmInfoOthRef2'); ?></option>
                                    </select>
                                </div>
                                <!-- จำนวนครั้งที่พิมพ์ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmInfoOthDocPrint'); ?></label>
                                    <input type="text" class="form-control xControlForm text-right" id="ocmPAMFrmInfoOthDocPrint" name="ocmPAMFrmInfoOthDocPrint" value="<?php echo $tPAMFrmDocPrint; ?>" readonly>
                                </div>
                                <!-- กรณีเพิ่มสินค้ารายการเดิม -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmInfoOthReAddPdt'); ?></label>
                                    <select class="form-control xControlForm selectpicker xWPAMDisabledOnApv" id="ocmPAMFrmInfoOthReAddPdt" name="ocmPAMFrmInfoOthReAddPdt">
                                        <option value="1" selected><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmInfoOthReAddPdt1'); ?></option>
                                        <option value="2"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmInfoOthReAddPdt2'); ?></option>
                                    </select>
                                </div>
                                <!-- หมายเหตุ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOLabelFrmInfoOthRemark'); ?></label>
                                    <textarea class="form-control xControlRmk xWConditionSearchPdt" id="otaPAMFrmInfoOthRmk" name="otaPAMFrmInfoOthRmk" rows="10" maxlength="200" style="resize: none;height:86px;"><?php echo $tPAMFrmRmk ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel ไฟลแนบ -->
            <div class="panel panel-default xCNHide" style="margin-bottom: 25px;">
                <div id="odvSOReferenceDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('common/main/main', 'tUPFPanelFile'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvSODataFile" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvSODataFile" class="panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="odvPAMShowDataTable">


                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    var oSOCallDataTableFile = {
                        ptElementID : 'odvPAMShowDataTable',
                        ptBchCode   : $('#oetPAMBchCode').val(),
                        ptDocNo     : $('#oetPAMDocNo').val(),
                        ptDocKey    : 'TCNTPdtPickHD',
                        ptSessionID : '<?= $this->session->userdata("tSesSessionID") ?>',
                        pnEvent     : <?= $nStaUploadFile ?>,
                        ptCallBackFunct: '',
                        ptStaApv        : $('#ohdPAMStaApv').val(),
                        ptStaDoc        : $('#ohdPAMStaDoc').val()
                    }
                    JCNxUPFCallDataTable(oSOCallDataTableFile);
                </script>
            </div>
        </div>

        <div class="col-sm-9 col-md-9 col-lg-9">
            <div class="row">
                <div id="odvPAMDataPanelDetailPDT" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default" style="margin-bottom:25px;position:relative;">
                        <div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="custom-tabs-line tabs-line-bottom left-aligned">
                                            <ul class="nav" role="tablist">

                                                <!-- สินค้า -->
                                                <li class="xWMenu active xCNStaHideShow" style="cursor:pointer;">
                                                    <a role="tab" data-toggle="tab" data-target="#odvPAMContentProduct" aria-expanded="true"><?= language('document/document/document', 'ข้อมูลสินค้า') ?></a>
                                                </li>

                                                <!-- อ้างอิง -->
                                                <li class="xWMenu xWSubTab xCNStaHideShow" style="cursor:pointer;">
                                                    <a role="tab" data-toggle="tab" data-target="#odvPAMContentHDDocRef" aria-expanded="false"><?= language('document/document/document', 'เอกสารอ้างอิง') ?></a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-content">

                                    <!-- รายการสินค้า -->
                                    <div id="odvPAMContentProduct" class="tab-pane fade active in" style="padding: 0px !important;">
                                        <div class="row p-t-15">

                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchPdtHTML" name="oetSearchPdtHTML" onkeyup="JSvPAMCSearchPdtHTML()" placeholder="<?= language('common/main/main', 'tPlaceholder'); ?>">
                                                        <span class="input-group-btn">
                                                            <button id="oimMngPdtIconSearch" class="btn xCNBtnSearch" type="button" onclick="JSvPAMCSearchPdtHTML()">
                                                                <img class="xCNIconBrowse" src="<?php echo base_url() . '/application/modules/common/assets/images/icons/search-24.png' ?>">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 text-right  xCNHideWhenCancelOrApprove">
                                              <div id="odvPAMMngDelPdtInTableDT" class="btn-group xCNDropDrownGroup">
                                                  <button type="button" class="btn xCNBTNMngTable xWConditionSearchPdt" data-toggle="dropdown">
                                                      <?=language('common/main/main', 'tCMNOption') ?>
                                                      <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu" role="menu">
                                                      <li id="oliPAMBtnDeleteMulti" class="disabled">
                                                          <a data-toggle="modal" data-target="#odvPAMModalDelPdtInDTTempMultiple"><?php echo language('common/main/main', 'tDelAll') ?></a>
                                                      </li>
                                                  </ul>
                                              </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 xCNHide xCNHideWhenCancelOrApprove">
                                                <!--ค้นหาจากบาร์โค๊ด-->
                                                <div class="form-group" style="width: 85%;">
                                                    <input type="text" class="form-control xControlForm" id="oetPAMInsertBarcode" autocomplete="off" name="oetPAMInsertBarcode" maxlength="50" value="" onkeypress="Javascript:if(event.keyCode==13) JSxSearchFromBarcode(event,this);" placeholder="เพิ่มสินค้าด้วยบาร์โค้ด หรือ รหัสสินค้า">
                                                </div>

                                                <!--เพิ่มสินค้าแบบปกติ-->
                                                <div class="form-group">
                                                    <div style="position: absolute;right: 15px;top:-5px;">
                                                        <button type="button" id="obtPAMDocBrowsePdt" class="xCNBTNPrimeryPlus xCNDocBrowsePdt">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row p-t-10" id="odvPAMDataPdtTableDTTemp">
                                        </div>

                                        <!--ส่วนสรุปท้ายบิล-->
                                        <div class="odvRowDataEndOfBill" id="odvRowDataEndOfBill">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <label class="pull-left mark-font"><?= language('document/purchaseorder/purchaseorder', 'จำนวนจัดรวมทั้งสิ้น'); ?></label>
                                                    <label class="pull-right mark-font"><span class="mark-font xShowQtyFooter">0</span> <?= language('document/purchaseorder/purchaseorder', 'รายการ'); ?></label>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- อ้างอิงเอกสาร -->
                                    <div id="odvPAMContentHDDocRef" class="tab-pane fade" style="padding: 0px !important;">
                                        <div class="row p-t-15">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                                                <div style="margin-top:-2px;">
                                                    <button type="button" id="obtPAMAddDocRef" class="xCNBTNPrimeryPlus xCNDocBrowsePdt xCNHideWhenCancelOrApprove">+</button>
                                                </div>
                                            </div>
                                            <div id="odvPAMTableHDRef"></div>
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
</form>

<!-- =========================================== View Modal Shipping Purchase Invoice  =========================================== -->
<div id="odvPAMBrowseShipAdd" class="modal fade">
    <div class="modal-dialog" style="width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('document/productarrangement/productarrangement', 'tPAMShipAddress'); ?></label>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JSnPAMShipAddData()"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                        <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-default" style="margin-bottom:5px;">
                            <div class="panel-heading" style="padding-top:5px!important;padding-bottom:5px!important;">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label class="xCNTextDetail1"><?php echo language('document/productarrangement/productarrangement', 'tPAMShipAddInfo'); ?></label>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                        <a style="font-size:14px!important;color:#1866ae;">
                                            <i class="fa fa-pencil" id="oliPAMEditShipAddress">&nbsp;<?php echo language('document/productarrangement/productarrangement', 'tPAMShipChange'); ?></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body xCNPDModlue">
                                <input type="hidden" id="ohdPAMShipAddSeqNo" class="form-control xControlForm">
                                <?php $tPAMFormatAddressType = FCNaHAddressFormat('TCNMBranch'); //1 ที่อยู่ แบบแยก  ,2  แบบรวม
                                ?>
                                <?php if (!empty($tPAMFormatAddressType) && $tPAMFormatAddressType == '1') : ?>
                                    <div class="row p-b-5">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMShipADDV1No'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label id="ospPAMShipAddAddV1No"><?php echo @$tPAMShipAddAddV1No; ?></label>
                                        </div>
                                    </div>
                                    <div class="row p-b-5">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMShipADDV1Village'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label id="ospPAMShipAddV1Soi"><?php echo @$tPAMShipAddV1Soi; ?></label>
                                        </div>
                                    </div>
                                    <div class="row p-b-5">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMShipADDV1Soi'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label id="ospPAMShipAddV1Village"><?php echo @$tPAMShipAddV1Village; ?></label>
                                        </div>
                                    </div>
                                    <div class="row p-b-5">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMShipADDV1Road'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label id="ospPAMShipAddV1Road"><?php echo @$tPAMShipAddV1Road; ?></label>
                                        </div>
                                    </div>
                                    <div class="row p-b-5">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMShipADDV1SubDist'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label id="ospPAMShipAddV1SubDist"><?php echo @$tPAMShipAddV1SubDist; ?></label>
                                        </div>
                                    </div>
                                    <div class="row p-b-5">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMShipADDV1DstCode'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label id="ospPAMShipAddV1DstCode"><?php echo @$tPAMShipAddV1DstCode ?></label>
                                        </div>
                                    </div>
                                    <div class="row p-b-5">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMShipADDV1PvnCode'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label id="ospPAMShipAddV1PvnCode"><?php echo @$tPAMShipAddV1PvnCode ?></label>
                                        </div>
                                    </div>
                                    <div class="row p-b-5">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMShipADDV1PostCode'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label id="ospPAMShipAddV1PostCode"><?php echo @$tPAMShipAddV1PostCode; ?></label>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMShipADDV2Desc1') ?></label><br>
                                                <label id="ospPAMShipAddV2Desc1"><?php echo @$tPAMShipAddV2Desc1; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMShipADDV2Desc2') ?></label><br>
                                                <label id="ospPAMShipAddV2Desc2"><?php echo @$tPAMShipAddV2Desc2; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- =========================================== View Modal Appove Document  =========================================== -->
<div id="odvPAMModalAppoveDoc" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main', 'tApproveTheDocument'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo language('common/main/main', 'tMainApproveStatus'); ?></p>
                <ul>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus1'); ?></li>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus2'); ?></li>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus3'); ?></li>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus4'); ?></li>
                </ul>
                <p><?php echo language('common/main/main', 'tMainApproveStatus5'); ?></p>
                <p><strong><?php echo language('common/main/main', 'tMainApproveStatus6'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button onclick="JSxPAMApproveDocument(true)" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- =========================================== View Modal Cancel Document  =========================================== -->
<div class="modal fade" id="odvPAMPopupCancel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/productarrangement/productarrangement', 'tPAMCancelDoc') ?></label>
            </div>
            <div class="modal-body">
                <p id="obpMsgApv"><?php echo language('document/productarrangement/productarrangement', 'tPAMCancelDocWarnning') ?></p>
                <p><strong><?php echo language('document/productarrangement/productarrangement', 'tPAMCancelDocConfrim') ?></strong></p>
            </div>
            <div class="modal-footer">
                <button onclick="JSnPAMCancelDocument(true)" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- =========================================== View Modal Delete Product In DT DocTemp Multiple  =========================================== -->
<div id="odvPAMModalDelPdtInDTTempMultiple" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type="hidden" id="ohdConfirmPAMDocNoDelete" name="ohdConfirmPAMDocNoDelete">
                <input type="hidden" id="ohdConfirmPAMSeqNoDelete" name="ohdConfirmPAMSeqNoDelete">
                <input type="hidden" id="ohdConfirmPAMPdtCodeDelete" name="ohdConfirmPAMPdtCodeDelete">
                <input type="hidden" id="ohdConfirmPAMPunCodeDelete" name="ohdConfirmPAMPunCodeDelete">

            </div>
            <div class="modal-footer">
                <button id="osmConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- =========================================== Modal ไม่พบรหัสสินค้า =========================================== -->
<div id="odvPAMModalPDTNotFound" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?= language('common/main/main', 'tMessageAlert') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo language('document/productarrangement/productarrangement', 'tPAMPdtNotFound') ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn xCNBTNPrimery" data-dismiss="modal" onclick="JSxNotFoundClose();">
                    <?= language('common/main/main', 'tCMNOK') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- =========================================== พบสินค้ามากกว่าหนึ่งตัว =========================================== -->
<div id="odvPAMModalPDTMoreOne" class="modal fade">
    <div class="modal-dialog" role="document" style="width: 85%; margin: 1.75rem auto;">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('document/productarrangement/productarrangement', 'tPAMSelectPdt') ?></label>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JCNxConfirmPDTMoreOne(1)" data-dismiss="modal"><?php echo language('document/productarrangement/productarrangement', 'tPAMChoose') ?></button>
                        <button class="btn xCNBTNDefult xCNBTNDefult2Btn" onclick="JCNxConfirmPDTMoreOne(2)" data-dismiss="modal"><?php echo language('document/productarrangement/productarrangement', 'tPAMClose') ?></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <table class="table table-striped xCNTablePDTMoreOne">
                    <thead>
                        <tr>
                            <th class="xCNTextBold" style="text-align:center; width:120px;"><?= language('common/main/main', 'tModalcodePDT') ?></th>
                            <th class="xCNTextBold" style="text-align:center; width:160px;"><?= language('common/main/main', 'tModalnamePDT') ?></th>
                            <th class="xCNTextBold" style="text-align:center; width:120px;"><?= language('common/main/main', 'tModalPriceUnit') ?></th>
                            <th class="xCNTextBold" style="text-align:center; width:160px;"><?= language('common/main/main', 'tModalbarcodePDT') ?></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- =========================================== Modal เปลี่ยนสาขา =========================================== -->
<div id="odvPAMModalChangeBCH" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?= language('common/main/main', 'tMessageAlert') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo language('document/productarrangement/productarrangement', 'tPAMBchNotFound') ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" id="obtChangeBCH" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tModalConfirm'); ?></button>
                <button type="button" data-dismiss="modal" class="btn xCNBTNDefult"><?php echo language('common/main/main', 'tModalCancel'); ?></button>
            </div>
        </div>
    </div>
</div>

<!-- =========================================== อ้างอิงเอกสารภายใน =========================================== -->
<div id="odvPAMModalRefIntDoc" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 1200px;">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard olbPAMModalRefIntDoc"></label>
            </div>
            <div class="modal-body">
                <div class="row" id="odvPAMFromRefIntDoc"></div>
            </div>
            <div class="modal-footer">
                <button id="obtConfirmRefDocInt" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'tModalConfirm') ?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- =========================================== อ้างอิงเอกสารภายใน (ภายใน หรือ ภายนอก) =========================================== -->
<div id="odvPAMModalAddDocRef" class="modal fade" tabindex="1" role="dialog" style='z-index:1045'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="ofmPAMFormAddDocRef" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?=language('common/main/main', 'อ้างอิงเอกสาร') ?></label>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control xCNHide" id="oetPAMRefDocNoOld" name="oetPAMRefDocNoOld">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?=language('common/main/main', 'ประเภทการอ้างอิงเอกสาร'); ?></label>
                                <select class="selectpicker form-control" id="ocbPAMRefType" name="ocbPAMRefType">
                                    <option value="1" selected><?=language('common/main/main', 'อ้างอิงภายใน'); ?></option>
                                    <option value="3"><?=language('common/main/main', 'อ้างอิงภายนอก'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12 xWShowRefInt">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?=language('common/main/main', 'เอกสาร'); ?></label>
                                <select class="selectpicker form-control" id="ocbPAMRefDoc" name="ocbPAMRefDoc">
                                    <option value="1" selected><?=language('common/main/main', 'ใบจ่ายโอน - สาขา'); ?></option>
                                    <option value="2"><?=language('common/main/main', 'ใบสั่งขาย'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12 xWShowRefInt">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('common/main/main', 'เลขที่เอกสารอ้างอิง') ?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" id="oetPAMDocRefInt" name="oetPAMDocRefInt" maxlength="20" value="">
                                    <input type="text" class="form-control xWPointerEventNone" id="oetPAMDocRefIntName" name="oetPAMDocRefIntName" maxlength="20" placeholder="<?php echo language('common/main/main', 'เลขที่เอกสารอ้างอิง') ?>" value="" readonly>
                                    <span class="input-group-btn">
                                        <button id="obtPAMBrowseRefDoc" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12 xWShowRefExt">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('common/main/main', 'เลขที่เอกสารอ้างอิง'); ?></label>
                                <input type="text" class="form-control" id="oetPAMRefDocNo" name="oetPAMRefDocNo" placeholder="<?php echo language('common/main/main', 'เลขที่เอกสารอ้างอิง'); ?>" maxlength="20" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/document/document', 'วันที่เอกสารอ้างอิง'); ?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetPAMRefDocDate" name="oetPAMRefDocDate" placeholder="YYYY-MM-DD" autocomplete="off">
                                    <span class="input-group-btn">
                                        <button id="obtPAMRefDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12 xWShowRefExt">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('common/main/main', 'ค่าอ้างอิง'); ?></label>
                                <input type="text" class="form-control" id="oetPAMRefKey" name="oetPAMRefKey" placeholder="<?php echo language('common/main/main', 'ค่าอ้างอิง'); ?>" maxlength="10" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="obtPAMConfirmAddDocRef" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="submit"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?=base_url('application/modules/common/assets/src/jThaiBath.js') ?>"></script>
<script src="<?=base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?=base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>
<?php include('script/jArrangementProductAdd.php'); ?>