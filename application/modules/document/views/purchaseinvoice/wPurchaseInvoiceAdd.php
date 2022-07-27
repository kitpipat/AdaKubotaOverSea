<?php
    $tSesUsrLevel   = $this->session->userdata('tSesUsrLevel');
    if(isset($aDataDocHD) && $aDataDocHD['rtCode'] == '1'){
        $aDataDocHD             = @$aDataDocHD['raItems'];
        $aDataDocHDSpl          = @$aDataDocHDSpl['raItems'];

        $tPIRoute               = "dcmPIEventEdit";
        $nPIAutStaEdit          = 1;
        $tPIDocNo               = $aDataDocHD['FTXphDocNo'];
        $dPIDocDate             = date("Y-m-d",strtotime($aDataDocHD['FDXphDocDate']));
        $dPIDocTime             = date("h:i:s a",strtotime($aDataDocHD['FDXphDocDate']));
        $tPICreateBy            = $aDataDocHD['FTCreateBy'];
        $tPIUsrNameCreateBy     = $aDataDocHD['FTUsrName'];
    
        $tPIStaRefund           = $aDataDocHD['FTXphStaRefund'];
        $tPIStaDoc              = $aDataDocHD['FTXphStaDoc'];
        $tPIStaApv              = $aDataDocHD['FTXphStaApv'];
        $tPIStaPrcStk           = $aDataDocHD['FTXphStaPrcStk'];
        $tPIStaDelMQ            = $aDataDocHD['FTXphStaDelMQ'];
        $tPIStaPaid             = $aDataDocHD['FTXphStaPaid'];

        $tPISesUsrBchCode       = $this->session->userdata("tSesUsrBchCode");
        $tPIDptCode             = $aDataDocHD['FTDptCode'];
        $tPIUsrCode             = $this->session->userdata('tSesUsername');
        $tPILangEdit            = $this->session->userdata("tLangEdit");

        $tPIApvCode             = $aDataDocHD['FTXphApvCode'];
        $tPIUsrNameApv          = $aDataDocHD['FTXphApvName'];
        $tPIRefPoDoc            = "";
        $tPIRefIntDoc           = $aDataDocHD['FTXphRefInt'];
        $dPIRefIntDocDate       = $aDataDocHD['FDXphRefIntDate'];
        $tPIRefExtDoc           = $aDataDocHD['FTXphRefExt'];
        $dPIRefExtDocDate       = $aDataDocHD['FDXphRefExtDate'];

        $tPIBchCode             = $aDataDocHD['FTBchCode'];
        $tPIBchName             = $aDataDocHD['FTBchName'];
        $tPIUserBchCode         = $tUserBchCode;
        $tPIUserBchName         = $tUserBchName;
        $tPIBchCompCode         = $tBchCompCode;
        $tPIBchCompName         = $tBchCompName;

        $tPIMerCode             = $aDataDocHD['FTMerCode'];
        $tPIMerName             = $aDataDocHD['FTMerName'];
        $tPIShopType            = $aDataDocHD['FTShpType'];
        $tPIShopCode            = $aDataDocHD['FTShpCode'];
        $tPIShopName            = $aDataDocHD['FTShpName'];
        $tPIPosCode             = $aDataDocHD['FTWahRefCode'];
        $tPIPosName             = $aDataDocHD['FTPosComName'];
        $tPIWahCode             = $aDataDocHD['FTWahCode'];
        $tPIWahName             = $aDataDocHD['FTWahName'];
        $nPIStaDocAct           = $aDataDocHD['FNXphStaDocAct'];
        $tPIFrmDocPrint         = $aDataDocHD['FNXphDocPrint'];
        $tPIFrmRmk              = $aDataDocHD['FTXphRmk'];
        $tPISplCode             = $aDataDocHD['FTSplCode'];
        $tPISplName             = $aDataDocHD['FTSplName'];

        $tPICmpRteCode          = $aDataDocHD['FTRteCode'];
        $cPIRteFac              = $aDataDocHD['FCXphRteFac'];

        $tPIVatInOrEx           = $aDataDocHD['FTXphVATInOrEx'];
        $tPISplPayMentType      = $aDataDocHD['FTXphCshOrCrd'];

        // ข้อมูลผู้จำหน่าย Supplier 
        $tPISplDstPaid          = $aDataDocHDSpl['FTXphDstPaid'];
        $tPISplCrTerm           = $aDataDocHDSpl['FNXphCrTerm'];
        $dPISplDueDate          = $aDataDocHDSpl['FDXphDueDate'];
        $dPISplBillDue          = $aDataDocHDSpl['FDXphBillDue'];
        $tPISplCtrName          = $aDataDocHDSpl['FTXphCtrName'];
        $dPISplTnfDate          = $aDataDocHDSpl['FDXphTnfDate'];
        $tPISplRefTnfID         = $aDataDocHDSpl['FTXphRefTnfID'];
        $tPISplRefVehID         = $aDataDocHDSpl['FTXphRefVehID'];
        $tPISplRefInvNo         = $aDataDocHDSpl['FTXphRefInvNo'];
        $tPISplQtyAndTypeUnit   = $aDataDocHDSpl['FTXphQtyAndTypeUnit'];

        // ที่อยู่สำหรับการจัดส่ง
        $tPISplShipAdd          = $aDataDocHDSpl['FNXphShipAdd'];
        $tPIShipAddAddV1No      = (isset($aDataDocHDSpl['FTXphShipAddNo']) && !empty($aDataDocHDSpl['FTXphShipAddNo']))? $aDataDocHDSpl['FTXphShipAddNo'] : "-";
        $tPIShipAddV1Soi        = (isset($aDataDocHDSpl['FTXphShipAddSoi']) && !empty($aDataDocHDSpl['FTXphShipAddSoi']))? $aDataDocHDSpl['FTXphShipAddSoi'] : "-";
        $tPIShipAddV1Village    = (isset($aDataDocHDSpl['FTXphShipAddVillage']) && !empty($aDataDocHDSpl['FTXphShipAddVillage']))? $aDataDocHDSpl['FTXphShipAddVillage'] : "-";
        $tPIShipAddV1Road       = (isset($aDataDocHDSpl['FTXphShipAddRoad']) && !empty($aDataDocHDSpl['FTXphShipAddRoad']))? $aDataDocHDSpl['FTXphShipAddRoad'] : "-";
        $tPIShipAddV1SubDist    = (isset($aDataDocHDSpl['FTXphShipSubDistrict']) && !empty($aDataDocHDSpl['FTXphShipSubDistrict']))? $aDataDocHDSpl['FTXphShipSubDistrict'] : "-";
        $tPIShipAddV1DstCode    = (isset($aDataDocHDSpl['FTXphShipDistrict']) && !empty($aDataDocHDSpl['FTXphShipDistrict']))? $aDataDocHDSpl['FTXphShipDistrict'] : "-";
        $tPIShipAddV1PvnCode    = (isset($aDataDocHDSpl['FTXphShipProvince']) && !empty($aDataDocHDSpl['FTXphShipProvince']))? $aDataDocHDSpl['FTXphShipProvince'] : "-";
        $tPIShipAddV1PostCode   = (isset($aDataDocHDSpl['FTXphShipPosCode']) && !empty($aDataDocHDSpl['FTXphShipPosCode']))? $aDataDocHDSpl['FTXphShipPosCode'] : "-";

        // ที่อยู่สำหรับการออกใบกำกับภาษี
        $tPISplTaxAdd           = $aDataDocHDSpl['FNXphTaxAdd'];
        $tPITexAddAddV1No       = (isset($aDataDocHDSpl['FTXphTaxAddNo']) && !empty($aDataDocHDSpl['FTXphTaxAddNo']))? $aDataDocHDSpl['FTXphTaxAddNo'] : "-";
        $tPITexAddV1Soi         = (isset($aDataDocHDSpl['FTXphTaxAddSoi']) && !empty($aDataDocHDSpl['FTXphTaxAddSoi']))? $aDataDocHDSpl['FTXphTaxAddSoi'] : "-";
        $tPITexAddV1Village     = (isset($aDataDocHDSpl['FTXphTaxAddVillage']) && !empty($aDataDocHDSpl['FTXphTaxAddVillage']))? $aDataDocHDSpl['FTXphTaxAddVillage'] : "-";
        $tPITexAddV1Road        = (isset($aDataDocHDSpl['FTXphTaxAddRoad']) && !empty($aDataDocHDSpl['FTXphTaxAddRoad']))? $aDataDocHDSpl['FTXphTaxAddRoad'] : "-";
        $tPITexAddV1SubDist     = (isset($aDataDocHDSpl['FTXphTaxSubDistrict']) && !empty($aDataDocHDSpl['FTXphTaxSubDistrict']))? $aDataDocHDSpl['FTXphTaxSubDistrict'] : "-";
        $tPITexAddV1DstCode     = (isset($aDataDocHDSpl['FTXphTaxDistrict']) && !empty($aDataDocHDSpl['FTXphTaxDistrict']))? $aDataDocHDSpl['FTXphTaxDistrict'] : "-";
        $tPITexAddV1PvnCode     = (isset($aDataDocHDSpl['FTXphTaxProvince']) && !empty($aDataDocHDSpl['FTXphTaxProvince']))? $aDataDocHDSpl['FTXphTaxProvince'] : "-";
        $tPITexAddV1PostCode    = (isset($aDataDocHDSpl['FTXphTaxPosCode']) && !empty($aDataDocHDSpl['FTXphTaxPosCode']))? $aDataDocHDSpl['FTXphTaxPosCode'] : "-";

    }else{
        $tPIRoute               = "dcmPIEventAdd";
        $nPIAutStaEdit          = 0;
        $tPIDocNo               = "";
        $dPIDocDate             = "";
        $dPIDocTime             = "";
        $tPICreateBy            = $this->session->userdata('tSesUsrUsername');
        $tPIUsrNameCreateBy     = $this->session->userdata('tSesUsrUsername');

        $tPIStaRefund           = 1;
        $tPIStaDoc              = 1;
        $tPIStaApv              = NULL;
        $tPIStaPrcStk           = NULL;
        $tPIStaDelMQ            = NULL;
        $tPIStaPaid             = 1;

        $tPISesUsrBchCode       = $this->session->userdata("tSesUsrBchCode");
        $tPIDptCode             = $tDptCode; 
        $tPIUsrCode             = $this->session->userdata('tSesUsername');
        $tPILangEdit            = $this->session->userdata("tLangEdit");

        $tPIApvCode             = "";
        $tPIUsrNameApv          = "";
        $tPIRefPoDoc            = "";
        $tPIRefIntDoc           = "";
        $dPIRefIntDocDate       = "";
        $tPIRefExtDoc           = "";
        $dPIRefExtDocDate       = "";

        $tPIBchCode             = $tBchCode;
        $tPIBchName             = $tBchName;
        $tPIUserBchCode         = $tBchCode;
        $tPIUserBchName         = $tBchName;
        $tPIBchCompCode         = $tBchCompCode;
        $tPIBchCompName         = $tBchCompName;
        $tPIMerCode             = $tMerCode;
        $tPIMerName             = $tMerName;
        $tPIShopType            = $tShopType;
        $tPIShopCode            = $tShopCode;
        $tPIShopName            = $tShopName;
        $tPIPosCode             = "";
        $tPIPosName             = "";
        $tPIWahCode             = "";
        $tPIWahName             = "";
        $nPIStaDocAct           = "";
        $tPIFrmDocPrint         = 0;
        $tPIFrmRmk              = "";
        $tPISplCode             = "";
        $tPISplName             = "";

        $tPICmpRteCode          = $tCmpRteCode;
        $cPIRteFac              = $cXthRteFac;

        $tPIVatInOrEx           = "";
        $tPISplPayMentType      = "";

        // ข้อมูลผู้จำหน่าย Supplier
        $tPISplDstPaid          = "";
        $tPISplCrTerm           = "";
        $dPISplDueDate          = "";
        $dPISplBillDue          = "";
        $tPISplCtrName          = "";
        $dPISplTnfDate          = "";
        $tPISplRefTnfID         = "";
        $tPISplRefVehID         = "";
        $tPISplRefInvNo         = "";
        $tPISplQtyAndTypeUnit   = "";
        
        // ที่อยู่สำหรับการจัดส่ง
        $tPISplShipAdd          = "";
        $tPIShipAddAddV1No      = "-";
        $tPIShipAddV1Soi        = "-";
        $tPIShipAddV1Village    = "-";
        $tPIShipAddV1Road       = "-";
        $tPIShipAddV1SubDist    = "-";
        $tPIShipAddV1DstCode    = "-";
        $tPIShipAddV1PvnCode    = "-";
        $tPIShipAddV1PostCode   = "-";

        // ที่อยู่สำหรับการออกใบกำกับภาษี
        $tPISplTaxAdd           = "";
        $tPITexAddAddV1No       = "-";
        $tPITexAddV1Soi         = "-";
        $tPITexAddV1Village     = "-";
        $tPITexAddV1Road        = "-";
        $tPITexAddV1SubDist     = "-";
        $tPITexAddV1DstCode     = "-";
        $tPITexAddV1PvnCode     = "-";
        $tPITexAddV1PostCode    = "-";

    }
?>
<form id="ofmPIFormAdd" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <input type="hidden" id="ohdPIRoute" name="ohdPIRoute" value="<?php echo $tPIRoute;?>">
    <input type="hidden" id="ohdPICheckClearValidate" name="ohdPICheckClearValidate" value="0">
    <input type="hidden" id="ohdPICheckSubmitByButton" name="ohdPICheckSubmitByButton" value="0">
    <input type="hidden" id="ohdPIAutStaEdit" name="ohdPIAutStaEdit" value="<?php echo $nPIAutStaEdit;?>">

    <input type="hidden" id="ohdPIStaRefund" name="ohdPIStaRefund" value="<?php echo $tPIStaRefund;?>">
    <input type="hidden" id="ohdPIStaDoc" name="ohdPIStaDoc" value="<?php echo $tPIStaDoc;?>">
    <input type="hidden" id="ohdPIStaApv" name="ohdPIStaApv" value="<?php echo $tPIStaApv;?>">
    <input type="hidden" id="ohdPIStaDelMQ" name="ohdPIStaDelMQ" value="<?php echo $tPIStaDelMQ; ?>">
    <input type="hidden" id="ohdPIStaPrcStk" name="ohdPIStaPrcStk" value="<?php echo $tPIStaPrcStk;?>">
    <input type="hidden" id="ohdPIStaPaid" name="ohdPIStaPaid" value="<?php echo $tPIStaPaid;?>">

    <input type="hidden" id="ohdPISesUsrBchCode" name="ohdPISesUsrBchCode" value="<?php echo $tPISesUsrBchCode; ?>">
    <input type="hidden" id="ohdPIBchCode" name="ohdPIBchCode" value="<?php echo $tPIBchCode; ?>">
    <input type="hidden" id="ohdPIDptCode" name="ohdPIDptCode" value="<?php echo $tPIDptCode;?>">
    <input type="hidden" id="ohdPIUsrCode" name="ohdPIUsrCode" value="<?php echo $tPIUsrCode?>">

    <input type="hidden" id="ohdPICmpRteCode" name="ohdPICmpRteCode" value="<?php echo $tPICmpRteCode;?>">
    <input type="hidden" id="ohdPIRteFac" name="ohdPIRteFac" value="<?php echo $cPIRteFac;?>">

    <input type="hidden" id="ohdPIApvCodeUsrLogin" name="ohdPIApvCodeUsrLogin" value="<?php echo $tPIUsrCode; ?>">
    <input type="hidden" id="ohdPILangEdit" name="ohdPILangEdit" value="<?php echo $tPILangEdit; ?>">
    <input type="hidden" id="ohdPIOptAlwSaveQty" name="ohdPIOptAlwSaveQty" value="<?php echo $nOptDocSave?>">
    <input type="hidden" id="ohdPIOptScanSku" name="ohdPIOptScanSku" value="<?php echo $nOptScanSku?>">
    
    <button style="display:none" type="submit" id="obtPISubmitDocument" onclick="JSxPIAddEditDocument()"></button>
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <!-- Panel รหัสเอกสารและสถานะเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvPIHeadStatusInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmStatus'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvPIDataStatusInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvPIDataStatusInfo" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group xCNHide" style="text-align: right;">
                                    <label class="text-success xCNTitleFrom"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmAppove');?></label>
                                </div>
                                <label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelAutoGenCode'); ?></label>
                                <?php if(isset($tPIDocNo) && empty($tPIDocNo)):?>
                                <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbPIStaAutoGenCode" name="ocbPIStaAutoGenCode" maxlength="1" checked="checked">
                                        <span>&nbsp;</span>
                                        <span class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmAutoGenCode');?></span>
                                    </label>
                                </div>
                                <?php endif;?>
                                <!-- เลขรหัสเอกสาร -->
                                <div class="form-group" style="cursor:not-allowed">
                                    <input
                                        type="text"
                                        class="form-control xCNGenarateCodeTextInputValidate"
                                        id="oetPIDocNo"
                                        name="oetPIDocNo"
                                        maxlength="20"
                                        value="<?php echo $tPIDocNo;?>"
                                        data-validate-required="<?php echo language('document/purchaseinvoice/purchaseinvoice','tPIPlsEnterOrRunDocNo'); ?>"
                                        data-validate-duplicate="<?php echo language('document/purchaseinvoice/purchaseinvoice','tPIPlsDocNoDuplicate'); ?>"
                                        placeholder="<?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmDocNo');?>"
                                        style="pointer-events:none"
                                        readonly
                                    >
                                    <input type="hidden" id="ohdPICheckDuplicateCode" name="ohdPICheckDuplicateCode" value="2">
                                </div>
                                <!-- วันที่ในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmDocDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate"
                                            id="oetPIDocDate"
                                            name="oetPIDocDate"
                                            value="<?php echo $dPIDocDate; ?>"
                                            data-validate-required="<?php echo language('document/purchaseinvoice/purchaseinvoice','tPIPlsEnterDocDate'); ?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtPIDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- เวลาในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmDocTime');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNTimePicker xCNInputMaskTime"
                                            id="oetPIDocTime"
                                            name="oetPIDocTime"
                                            value="<?php echo $dPIDocTime; ?>"
                                            data-validate-required="<?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPIPlsEnterDocTime');?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtPIDocTime" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- ผู้สร้างเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmCreateBy');?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <input type="hidden" id="ohdPICreateBy" name="ohdPICreateBy" value="<?php echo $tPICreateBy?>">
                                            <label><?php echo $tPIUsrNameCreateBy?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- สถานะเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmStaDoc'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <?php
                                                if($tPIRoute == "dcmPIEventAdd"){
                                                    $tPiLabelStaDoc  = language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmValStaDoc');
                                                }else{
                                                    $tPiLabelStaDoc  = language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmValStaDoc'.$tPIStaDoc); 
                                                }
                                            ?>
                                            <label><?php echo $tPiLabelStaDoc;?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- สถานะอนุมัติเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmStaApv'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmValStaApv'.$tPIStaApv); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- สถานะประมวลผลเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmStaPrcStk'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmValStaPrcStk'.$tPIStaPrcStk); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <?php if(isset($tPIDocNo) && !empty($tPIDocNo)):?>
                                    <!-- ผู้อนุมัติเอกสาร -->
                                    <div class="form-group" style="margin:0">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmApvBy'); ?></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                                <input type="hidden" id="ohdPIApvCode" name="ohdPIApvCode" maxlength="20" value="<?php echo $tPIApvCode?>">
                                                <label>
                                                    <?php echo (isset($tPIUsrNameApv) && !empty($tPIUsrNameApv))? $tPIUsrNameApv : "-" ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel ข้อมูลอ้างอิง -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvPIReferenceDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmReference');?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvPIDataReferenceDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvPIDataReferenceDoc" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-t-10">
                                <!-- อ้างอิงเลขที่เอกสารใบขอซื้อ -->
                                <div class="form-group xCNHide">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmRefPo');?></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="oetPIRefPoDoc"
                                        name="oetPIRefPoDoc"
                                        maxlength="20"
                                        value="<?php echo $tPIRefPoDoc;?>"
                                    >
                                </div>
                                <!-- อ้างอิงเลขที่เอกสารภายใน -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmRefIntDoc');?></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="oetPIRefIntDoc"
                                        name="oetPIRefIntDoc"
                                        maxlength="20"
                                        value="<?php echo $tPIRefIntDoc;?>"
                                    >
                                </div>
                                <!-- วันที่อ้างอิงเลขที่เอกสารภายใน -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmRefIntDocDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate"
                                            id="oetPIRefIntDocDate"
                                            name="oetPIRefIntDocDate"
                                            placeholder="YYYY-MM-DD"
                                            value="<?php echo $dPIRefIntDocDate;?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtPIBrowseRefIntDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- อ้างอิงเลขที่เอกสารภายนอก -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmRefExtDoc');?></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="oetPIRefExtDoc"
                                        name="oetPIRefExtDoc"
                                        value="<?php echo $tPIRefExtDoc;?>"
                                    >
                                </div>
                                <!-- วันที่เอกสารภายนอก -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmRefExtDocDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate"
                                            id="oetPIRefExtDocDate"
                                            name="oetPIRefExtDocDate"
                                            placeholder="YYYY-MM-DD"
                                            value="<?php echo $dPIRefExtDocDate;?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtPIBrowseRefExtDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Panel เงื่อนไขเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvPIConditionDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmConditionDoc'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvPIDataConditionDoc" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvPIDataConditionDoc" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <!-- Condition สาขา -->
                                <div class="form-group m-b-0">
                                    <?php
                                        if($tPIRoute == "dcmPIEventAdd"){
                                            if($tSesUsrLevel == "HQ"){
                                                $tPIDataInputBchCode    = $tPIBchCompCode;
                                                $tPIDataInputBchName    = $tPIBchCompName;
                                            }else{
                                                $tPIDataInputBchCode    = $tPIUserBchCode;
                                                $tPIDataInputBchName    = $tPIUserBchName;
                                            }
                                        }else{
                                            $tPIDataInputBchCode    = $tPIBchCode;
                                            $tPIDataInputBchName    = $tPIBchName;
                                        }
                                    ?>

                                    <!-- <input class="form-control xCNHide" id="oetPIFrmBchCode" name="oetPIFrmBchCode" maxlength="5" value="<?php echo $tPIDataInputBchCode;?>">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmBranch');?></label>
                                    <label>&nbsp;<?php echo $tPIDataInputBchName;?></label> -->
                                            
                                    <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmBranch')?></label>
												<div class="input-group">
													<input
														type="text"
														class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
														id="oetPIFrmBchCode"
														name="oetPIFrmBchCode"
														maxlength="5"
														value="<?php echo @$tPIDataInputBchCode?>"
													>
													<input
														type="text"
														class="form-control xWPointerEventNone"
														id="oetPIFrmBchName"
														name="oetPIFrmBchName"
														maxlength="100"
														placeholder="<?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmBranch')?>"
														value="<?php echo @$tPIDataInputBchName?>"
														readonly
													>
													<span class="input-group-btn">
														<button id="obtBrowseTWOBCH" type="button" class="btn xCNBtnBrowseAddOn xCNBtnBrowseAddOn">
															<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
														</button>
													</span>
												</div>
											</div>

                                </div>
                                <!-- Condition กลุ่มธุรกิจ -->
                                <div class="form-group <?php if(!FCNbGetIsShpEnabled()) : echo 'xCNHide';  endif;?>"">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmMerchant');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetPIFrmMerCode" name="oetPIFrmMerCode" maxlength="5" value="<?php echo $tPIMerCode;?>">
                                        <input type="text" class="form-control xWPointerEventNone" id="oetPIFrmMerName" name="oetPIFrmMerName" value="<?php echo $tPIMerName;?>" readonly>
                                        <?php
                                            $tDisabledBtnMerchant = "";
                                            if($tPIRoute == "dcmPIEventAdd"){
                                                if($tSesUsrLevel == "SHP"){
                                                    $tDisabledBtnMerchant = "disabled";
                                                }
                                            }else{
                                                if($tSesUsrLevel == "SHP"){
                                                    $tDisabledBtnMerchant = "disabled";
                                                }
                                            }
                                        ?>
                                        <span class="xWConditionSearchPdt input-group-btn <?php echo $tDisabledBtnMerchant;?>">
                                            <button id="obtPIBrowseMerchant" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tDisabledBtnMerchant;?>">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Condition ร้านค้า -->
                                <div class="form-group <?php if(!FCNbGetIsShpEnabled()) : echo 'xCNHide';  endif;?>">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmShop');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetPIFrmShpCode" name="oetPIFrmShpCode" maxlength="5" value="<?php echo $tPIShopCode;?>">
                                        <input type="text" class="form-control xWPointerEventNone" id="oetPIFrmShpName" name="oetPIFrmShpName" value="<?php echo $tPIShopName;?>" readonly>
                                        <?php
                                            $tDisabledBtnShop = "";
                                            if($tPIRoute == "dcmPIEventAdd"){
                                                $tDisabledBtnShop   = "disabled";
                                            }else{
                                                if($tSesUsrLevel == "SHP"){
                                                    $tDisabledBtnShop   = "disabled";
                                                }else{
                                                    if(empty($tPIShopCode) && empty($tPIShopName)){
                                                        $tDisabledBtnShop   = "disabled";
                                                    }
                                                }
                                            }
                                        ?>
                                        <span class="xWConditionSearchPdt input-group-btn <?php echo $tDisabledBtnShop;?>">
                                            <button id="obtPIBrowseShop" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tDisabledBtnShop;?>">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Condition เครื่องจุดขาย -->
                                <div class="form-group <?php if(!FCNbGetIsShpEnabled()) : echo 'xCNHide';  endif;?>">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmPos');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetPIFrmPosCode" name="oetPIFrmPosCode" maxlength="5" value="<?php echo $tPIPosCode;?>">
                                        <input type="text" class="form-control xWPointerEventNone" id="oetPIFrmPosName" name="oetPIFrmPosName" value="<?php echo $tPIPosName;?>" readonly>
                                        <?php
                                            $tDisabledBtnPos    = "";
                                            if($tPIRoute == "dcmPIEventAdd"){
                                                $tDisabledBtnPos    = "disabled";
                                            }else{
                                                if($tSesUsrLevel == "SHP"){
                                                    $tDisabledBtnPos    = "disabled";
                                                }else{
                                                    if(empty($tPIPosCode)){
                                                        $tDisabledBtnPos    = "disabled";
                                                    }
                                                }
                                            }
                                        ?>
                                        <span class="xWConditionSearchPdt input-group-btn <?php echo $tDisabledBtnPos;?>">
                                            <button id="obtPIBrowsePos" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tDisabledBtnPos;?>">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Condition คลังสินค้า -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style = "color:red">*</span> <?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmWah');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetPIFrmWahCode" name="oetPIFrmWahCode" maxlength="5" value="<?php echo $tPIWahCode;?>">
                                        <input
                                            type="text"
                                            class="form-control xWPointerEventNone"
                                            id="oetPIFrmWahName"
                                            name="oetPIFrmWahName"
                                            value="<?php echo $tPIWahName;?>"
                                            data-validate-required="<?php echo language('document/purchaseinvoice/purchaseinvoice','tPIPlsEnterWah'); ?>"
                                            readonly
                                        >
                                        <?php
                                            $tDisabledBtnWah    = "";
                                            // if($tPIRoute == "dcmPIEventAdd"){
                                            //     if($tSesUsrLevel == "SHP"){
                                            //         $tDisabledBtnWah    = "disabled";
                                            //     }
                                            // }else{
                                            //     if($tSesUsrLevel == "SHP"){
                                            //         $tDisabledBtnWah    = "disabled";
                                            //     }else{
                                            //         if(!empty($tPIMerCode) && !empty($tPIShopCode) && !empty($tPIWahCode)){
                                            //             $tDisabledBtnWah    = "disabled";
                                            //         }
                                            //     }
                                            // }
                                        ?>
                                        <span class="xWConditionSearchPdt input-group-btn <?php echo $tDisabledBtnWah;?>">
                                            <button id="obtPIBrowseWahouse" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php echo $tDisabledBtnWah;?>">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Panel Supplier Info -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvPISupplierInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoDoc');?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvPIDataSupplierInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvPIDataSupplierInfo" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div id="odvRowPanelSplInfo" class="row"  style="max-height:350px;overflow-x:auto">
                            <div class="col-xs-12 col-sm-12 col-col-md-12 col-lg-12">
                                <!-- ประเภทภาษี -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoVatInOrEx');?></label>
                                    <?php
                                        switch($tPIVatInOrEx){
                                            case '1':
                                                $tOptionVatIn   = "selected";
                                                $tOptionVatEx   = "";
                                            break;
                                            case '2':
                                                $tOptionVatIn   = "";
                                                $tOptionVatEx   = "selected";
                                            break;
                                            default:
                                                $tOptionVatIn   = "selected";
                                                $tOptionVatEx   = "";
                                        }
                                    ?>
                                    <select class="selectpicker form-control" id="ocmPIFrmSplInfoVatInOrEx" name="ocmPIFrmSplInfoVatInOrEx" maxlength="1">
                                        <option value="1" <?php echo @$tOptionVatIn;?>><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoVatInclusive');?></option>
                                        <option value="2" <?php echo @$tOptionVatEx;?>><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoVatExclusive');?></option>
                                    </select>
                                </div>
                                <!-- ประเภทการชำระ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoPaymentType');?></label>
                                    <select class="selectpicker form-control" id="ocmPIFrmSplInfoPaymentType" name="ocmPIFrmSplInfoPaymentType" maxlength="1" value="<?php echo $tPISplPayMentType;?>">
                                        <option value="1" selected="true"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoPaymentType1');?></option>
                                        <option value="2"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoPaymentType2');?></option>
                                    </select>
                                </div>
                                <!-- วิธีการชำระเงิน -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoDstPaid');?></label>
                                    <select class="selectpicker form-control" id="ocmPIFrmSplInfoDstPaid" name="ocmPIFrmSplInfoDstPaid" maxlength="1" value="<?php echo $tPISplDstPaid;?>">
                                        <option value="1" selected="true"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoDstPaid1');?></option>
                                        <option value="2"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoDstPaid2');?></option>
                                    </select>
                                </div>
                                <!-- ระยะเครดิต -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoCrTerm');?></label>
                                    <input
                                        type="text"
                                        class="form-control text-right xCNInputNumericWithoutDecimal"
                                        id="oetPIFrmSplInfoCrTerm"
                                        name="oetPIFrmSplInfoCrTerm"
                                        value="<?php echo $tPISplCrTerm;?>"
                                    >
                                </div>
                                <!-- วันครบกำหนดชำระเงิน -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoDueDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate"
                                            id="oetPIFrmSplInfoDueDate"
                                            name="oetPIFrmSplInfoDueDate"
                                            placeholder="YYYY-MM-DD"
                                            value="<?php echo $dPISplDueDate;?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtPIFrmSplInfoDueDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- วันวางบิล -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoBillDue');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate"
                                            id="oetPIFrmSplInfoBillDue"
                                            name="oetPIFrmSplInfoBillDue"
                                            placeholder="YYYY-MM-DD"
                                            value="<?php echo $dPISplBillDue;?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtPIFrmSplInfoBillDue" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>  
                                <!-- วันที่ขนส่ง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoTnfDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate"
                                            id="oetPIFrmSplInfoTnfDate"
                                            name="oetPIFrmSplInfoTnfDate"
                                            placeholder="YYYY-MM-DD"
                                            value="<?php echo $dPISplTnfDate;?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtPIFrmSplInfoTnfDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- ชื่อผู้ติดต่อ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoCtrName');?></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="oetPIFrmSplInfoCtrName"
                                        name="oetPIFrmSplInfoCtrName"
                                        value="<?php echo $tPISplCtrName;?>"
                                    >
                                </div>
                                <!-- เลขที่ขนส่ง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoRefTnfID');?></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="oetPIFrmSplInfoRefTnfID"
                                        name="oetPIFrmSplInfoRefTnfID"
                                        value="<?php echo $tPISplRefTnfID;?>"
                                    >
                                </div>
                                <!-- อ้างอิงเลขที่ขนส่ง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoRefVehID');?></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="oetPIFrmSplInfoRefVehID"
                                        name="oetPIFrmSplInfoRefVehID"
                                        value="<?php echo $tPISplRefVehID;?>"
                                    >
                                </div>
                                <!-- เลขที่บัญชีราคาสินค้า -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoRefInvNo');?></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="oetPIFrmSplInfoRefInvNo"
                                        name="oetPIFrmSplInfoRefInvNo"
                                        value="<?php echo $tPISplRefInvNo;?>"
                                    >
                                </div>
                                <!-- จำนวนและลักษณะหีบห่อ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoQtyAndTypeUnit');?></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="oetPIFrmSplInfoQtyAndTypeUnit"
                                        name="oetPIFrmSplInfoQtyAndTypeUnit"
                                        value="<?php echo $tPISplQtyAndTypeUnit;?>"
                                    >
                                </div>
                            </div>
                        </div>
                        <div id="odvRowPanelBtnGrpSplInfo" class="row" style="padding-top:20px;">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <input type="hidden" id="ohdPIFrmShipAdd" name="ohdPIFrmShipAdd" value="<?php echo $tPISplShipAdd;?>">
                                <button type="button" id="obtPIFrmBrowseShipAdd" class="btn btn-primary" style="width:100%;">
                                    +&nbsp;<?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoShipAddress');?>
                                </button>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <input type="hidden" id="ohdPIFrmTaxAdd" name="ohdPIFrmTaxAdd" value="<?php echo $tPISplTaxAdd;?>">
                                <button type="button" id="obtPIFrmBrowseTaxAdd" class="btn btn-primary" style="width:100%;">
                                    +&nbsp;<?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmSplInfoTaxAddress');?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel อืนๆ -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvPIInfoOther" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmInfoOth');?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvPIDataInfoOther" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvPIDataInfoOther" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
                                <!-- สถานะความเคลื่อนไหว -->
                                <div class="form-group">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" value="1" id="ocbPIFrmInfoOthStaDocAct" name="ocbPIFrmInfoOthStaDocAct" maxlength="1" <?php echo ($nPIStaDocAct == '1' || empty($nPIStaDocAct)) ? 'checked' : ''; ?>>
                                        <span>&nbsp;</span>
                                        <span class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmInfoOthStaDocAct'); ?></span>
                                    </label>
                                </div>
                                <!-- สถานะอ้างอิง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmInfoOthRef');?></label>
                                    <select class="selectpicker form-control" id="ocmPIFrmInfoOthRef" name="ocmPIFrmInfoOthRef" maxlength="1">
                                        <option value="0" selected><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmInfoOthRef0');?></option>
                                        <option value="1"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmInfoOthRef1');?></option>
                                        <option value="2"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmInfoOthRef2');?></option>
                                    </select>
                                </div>
                                <!-- จำนวนครั้งที่พิมพ์ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmInfoOthDocPrint');?></label>
                                    <input
                                        type="text"
                                        class="form-control text-right"
                                        id="ocmPIFrmInfoOthDocPrint"
                                        name="ocmPIFrmInfoOthDocPrint"
                                        value="<?php echo $tPIFrmDocPrint;?>"
                                        readonly
                                    >
                                </div>
                                <!-- กรณีเพิ่มสินค้ารายการเดิม -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmInfoOthReAddPdt');?></label>
                                    <select class="form-control selectpicker" id="ocmPIFrmInfoOthReAddPdt" name="ocmPIFrmInfoOthReAddPdt">
                                        <option value="1" selected><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmInfoOthReAddPdt1');?></option>
                                        <option value="2"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPILabelFrmInfoOthReAddPdt2');?></option>
                                    </select>
                                </div>
                                <!-- หมายเหตุ -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPILabelFrmInfoOthRemark');?></label>
                                    <textarea
                                        class="form-control"
                                        id="otaPIFrmInfoOthRmk"
                                        name="otaPIFrmInfoOthRmk"
                                        rows="10"
                                        maxlength="200"
                                        style="resize: none;height:86px;"
                                    >
                                        <?php echo $tPIFrmRmk?>
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <div class="row">
                <!-- ตารางรายการสินค้า -->
                <div id="odvPIDataPanelDetailPDT" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default" style="margin-bottom:25px;position:relative;min-height:500px;">
                        <div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
                            <div class="panel-body">
                                <div class="row p-t-10">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetPIFrmSplCode" name="oetPIFrmSplCode" value="<?php echo $tPISplCode;?>">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="oetPIFrmSplName"
                                                    name="oetPIFrmSplName"
                                                    value="<?php echo $tPISplName;?>"
                                                    placeholder="<?php echo language('document/purchaseinvoice/purchaseinvoice','tPIMsgValidSplCode') ?>"
                                                    readonly
                                                >
                                                <span class="input-group-btn">
                                                    <button id="obtPIBrowseSupplier" type="button" class="btn xCNBtnBrowseAddOn">
                                                        <img class="xCNIconFind">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-t-10">
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="100"
                                                    id="oetPIFrmFilterPdtHTML"
                                                    name="oetPIFrmFilterPdtHTML"
                                                    placeholder="<?php echo language('document/purchaseinvoice/purchaseinvoice','tPIFrmFilterTablePdt');?>"
                                                    onkeyup="javascript:if(event.keyCode==13) JSvPIDOCFilterPdtInTableTemp()"
                                                >
                                                <input 
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="100"
                                                    id="oetPIFrmSearchAndAddPdtHTML"
                                                    name="oetPIFrmSearchAndAddPdtHTML"
                                                    onkeyup="Javascript:if(event.keyCode==13) JSxPIChkConditionSearchAndAddPdt()"
                                                    placeholder="<?php echo language('document/purchaseinvoice/purchaseinvoice','tPIFrmSearchAndAddPdt');?>"
                                                    style="display:none;"
                                                    data-validate="<?php echo language('document/purchaseinvoice/purchaseinvoice','tPIMsgValidScanNotFoundBarCode');?>"
                                                >
                                                <span class="input-group-btn">
                                                    <div id="odvPISearchAndScanBtnGrp" class="xCNDropDrownGroup input-group-append">
                                                        <button id="obtPIMngPdtIconSearch" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" onclick="JSvPIDOCFilterPdtInTableTemp()">
                                                            <i class="fa fa-filter" style="width:20px;"></i>
                                                        </button>
                                                        <button id="obtPIMngPdtIconScan" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" style="display:none;" onclick="JSxPIChkConditionSearchAndAddPdt()">
                                                            <i class="fa fa-search" style="width:20px;"></i>
                                                        </button>
                                                        <button type="button" class="btn xCNDocDrpDwn xCNBtnDocSchAndScan" data-toggle="dropdown" style="display:none;">
                                                            <i class="fa fa-chevron-down f-s-14 t-plus-1" style="font-size: 12px;"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a id="oliPIMngPdtSearch"><label><?php echo language('document/purchaseinvoice/purchaseinvoice','tPIFrmFilterTablePdt'); ?></label></a>
                                                                <a id="oliPIMngPdtScan"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPIFrmSearchAndAddPdt'); ?></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 text-right">
                                        <div id="odvPIMngAdvTableList" class="btn-group xCNDropDrownGroup">
                                            <button id="obtPIAdvTablePdtDTTemp" type="button" class="btn xCNBTNMngTable m-r-20"><?php echo language('common/main/main', 'tModalAdvTable') ?></button>
                                        </div>
                                        <div id="odvPIMngDelPdtInTableDT" class="btn-group xCNDropDrownGroup">
                                            <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                                                <?php echo language('common/main/main','tCMNOption')?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li id="oliPIBtnDeleteMulti" class="disabled">
                                                    <a data-toggle="modal" data-target="#odvPIModalDelPdtInDTTempMultiple"><?php echo language('common/main/main','tDelAll')?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                                        <div class="form-group">
                                            <div style="position: absolute;right: 15px;top:-5px;">
                                                <button type="button" id="obtPIDocBrowsePdt" class="xCNBTNPrimeryPlus xCNDocBrowsePdt">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-t-10" id="odvPIDataPdtTableDTTemp">
                                    
                                </div>
                                <?php include('wPurchaseInvoiceEndOfBill.php');?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</form>

<!-- =================================================================== View Modal Shipping Purchase Invoice  =================================================================== -->
    <div id="odvPIBrowseShipAdd" class="modal fade">
        <div class="modal-dialog" style="width: 800px;">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPIShipAddress'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JSnPIShipAddData()"><?php echo language('common/main/main', 'tModalConfirm')?></button>  
                            <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel panel-default" style="margin-bottom:5px;">
                                <div class="panel-heading xCNPanelHeadColor" style="padding-top:5px!important;padding-bottom:5px!important;">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNTextDetail1"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPIShipAddInfo');?></label> 
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <a style="font-size:14px!important;color:#179bfd;">
                                                <i class="fa fa-pencil" id="oliPIEditShipAddress">&nbsp;<?php echo language('document/purchaseinvoice/purchaseinvoice','tPIShipChange');?></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body xCNPDModlue">
                                    <input type="hidden" id="ohdPIShipAddSeqNo" class="form-control">
                                    <?php $tPIFormatAddressType = FCNaHAddressFormat('TCNMBranch'); //1 ที่อยู่ แบบแยก  ,2  แบบรวม ?>
                                    <?php if(!empty($tPIFormatAddressType) && $tPIFormatAddressType == '1'): ?>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPIShipADDV1No');?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPIShipAddAddV1No"><?php echo @$tPIShipAddAddV1No;?></label> 
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPIShipADDV1Village');?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPIShipAddV1Soi"><?php echo @$tPIShipAddV1Soi;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPIShipADDV1Soi'); ?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPIShipAddV1Village"><?php echo @$tPIShipAddV1Village;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPIShipADDV1Road'); ?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPIShipAddV1Road"><?php echo @$tPIShipAddV1Road;?></label> 
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPIShipADDV1SubDist'); ?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPIShipAddV1SubDist"><?php echo @$tPIShipAddV1SubDist;?></label> 
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPIShipADDV1DstCode'); ?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPIShipAddV1DstCode"><?php echo @$tPIShipAddV1DstCode?></label> 
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPIShipADDV1PvnCode'); ?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPIShipAddV1PvnCode"><?php echo @$tPIShipAddV1PvnCode?></label> 
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPIShipADDV1PostCode'); ?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPIShipAddV1PostCode"><?php echo @$tPIShipAddV1PostCode;?></label> 
                                            </div>
                                        </div>
                                    <?php else:?>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPIShipADDV2Desc1')?></label><br>
                                                    <label id="ospPIShipAddV2Desc1"><?php echo @$tPIShipAddV2Desc1;?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPIShipADDV2Desc2')?></label><br>
                                                    <label id="ospPIShipAddV2Desc2"><?php echo @$tPIShipAddV2Desc2;?></label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- ============================================================================================================================================================================= -->

<!-- ================================================================== View Modal TexAddress Purchase Invoice  ================================================================== -->
    <div id="odvPIBrowseTexAdd" class="modal fade">
        <div class="modal-dialog" style="width: 800px;">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITexAddress'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JSnPITexAddData()"><?php echo language('common/main/main', 'tModalConfirm')?></button>  
                            <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel panel-default" style="margin-bottom:5px;">
                                <div class="panel-heading xCNPanelHeadColor" style="padding-top:5px!important;padding-bottom:5px!important;">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNTextDetail1"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPITexAddInfo');?></label> 
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <a style="font-size:14px!important;color:#179bfd;">
                                                <i class="fa fa-pencil" id="oliPIEditTexAddress">&nbsp;<?php echo language('document/purchaseinvoice/purchaseinvoice','tPITexChange');?></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body xCNPDModlue">
                                    <input type="hidden" id="ohdPITexAddSeqNo" class="form-control">
                                    <?php $tPIFormatAddressType = FCNaHAddressFormat('TCNMBranch'); //1 ที่อยู่ แบบแยก  ,2  แบบรวม ?>
                                    <?php if(!empty($tPIFormatAddressType) && $tPIFormatAddressType == '1'): ?>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPITexADDV1No');?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPITexAddAddV1No"><?php echo @$tPITexAddAddV1No;?></label> 
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPITexADDV1Village');?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPITexAddV1Soi"><?php echo @$tPITexAddV1Soi;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPITexADDV1Soi'); ?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPITexAddV1Village"><?php echo @$tPITexAddV1Village;?></label>
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPITexADDV1Road'); ?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPITexAddV1Road"><?php echo @$tPITexAddV1Road;?></label> 
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPITexADDV1SubDist'); ?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPITexAddV1SubDist"><?php echo @$tPITexAddV1SubDist;?></label> 
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPITexADDV1DstCode'); ?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPITexAddV1DstCode"><?php echo @$tPITexAddV1DstCode?></label> 
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPITexADDV1PvnCode'); ?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPITexAddV1PvnCode"><?php echo @$tPITexAddV1PvnCode?></label> 
                                            </div>
                                        </div>
                                        <div class="row p-b-5">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPITexADDV1PostCode'); ?></label> 
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <label id="ospPITexAddV1PostCode"><?php echo @$tPITexAddV1PostCode;?></label> 
                                            </div>
                                        </div>
                                    <?php else:?>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITexADDV2Desc1')?></label><br>
                                                    <label id="ospPITexAddV2Desc1"><?php echo @$tPITexAddV2Desc1;?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITexADDV2Desc2')?></label><br>
                                                    <label id="ospPITexAddV2Desc2"><?php echo @$tPITexAddV2Desc2;?></label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>                           
<!-- ============================================================================================================================================================================= -->

<!-- ======================================================================== View Modal Appove Document  ======================================================================== -->
    <div id="odvPIModalAppoveDoc" class="modal fade xCNModalApprove">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main','tApproveTheDocument'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo language('common/main/main','tMainApproveStatus'); ?></p>
                        <ul>
                            <li><?php echo language('common/main/main','tMainApproveStatus1'); ?></li>
                            <li><?php echo language('common/main/main','tMainApproveStatus2'); ?></li>
                            <li><?php echo language('common/main/main','tMainApproveStatus3'); ?></li>
                            <li><?php echo language('common/main/main','tMainApproveStatus4'); ?></li>
                        </ul>
                    <p><?php echo language('common/main/main','tMainApproveStatus5'); ?></p>
                    <p><strong><?php echo language('common/main/main','tMainApproveStatus6'); ?></strong></p>
                </div>
                <div class="modal-footer">
                    <button onclick="JSxPIApproveDocument(true)" type="button" class="btn xCNBTNPrimery">
                        <?php echo language('common/main/main', 'tModalConfirm'); ?>
                    </button>
                    <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                        <?php echo language('common/main/main', 'tModalCancel'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
<!-- ============================================================================================================================================================================= -->

<!-- ======================================================================== View Modal Cancel Document  ======================================================================== -->
    <div class="modal fade" id="odvPurchaseInviocePopupCancel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPIMsgCancel')?></label>
                </div>
                <div class="modal-body">
                    <p id="obpMsgApv"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPIMsgDocProcess')?></p>
                    <p><strong><?php echo language('document/purchaseinvoice/purchaseinvoice','tPIMsgCanCancel')?></strong></p>
                </div>
                <div class="modal-footer">
                    <button onclick="JSnPICancelDocument(true)" type="button" class="btn xCNBTNPrimery">
                        <?php echo language('common/main/main', 'tModalConfirm'); ?>
                    </button>
                    <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                        <?php echo language('common/main/main', 'tModalCancel'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
<!-- ============================================================================================================================================================================= -->

<!-- =====================================================================  Modal Advance Table Product DT Temp ==================================================================-->
    <div class="modal fade" id="odvPIOrderAdvTblColumns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('common/main/main', 'tModalAdvTable'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body" id="odvPIModalBodyAdvTable">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo language('common/main/main', 'tModalAdvClose'); ?></button>
                    <button id="obtPISaveAdvTableColums" type="button" class="btn btn-primary"><?php echo language('common/main/main', 'tModalAdvSave'); ?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ============================================================================================================================================================================= -->

<!-- ============================================================== View Modal Delete Product In DT DocTemp Multiple  ============================================================ -->
    <div id="odvPIModalDelPdtInDTTempMultiple" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main','tModalDelete')?></label>
                </div>
                <div class="modal-body">
                    <span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                    <input type="hidden" id="ohdConfirmPIDocNoDelete"   name="ohdConfirmPIDocNoDelete">
                    <input type="hidden" id="ohdConfirmPISeqNoDelete"   name="ohdConfirmPISeqNoDelete">
                    <input type="hidden" id="ohdConfirmPIPdtCodeDelete" name="ohdConfirmPIPdtCodeDelete">
                    <input type="hidden" id="ohdConfirmPIPunCodeDelete" name="ohdConfirmPIPunCodeDelete">
                    
                </div>
                <div class="modal-footer">
                    <button id="osmConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
                </div>
            </div>
        </div>
    </div>     
<!-- ============================================================================================================================================================================= -->


<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include('script/jPurchaseInvoiceAdd.php');?>
<?php include('dis_chg/wPurchaseInvoiceDisChgModal.php'); ?>