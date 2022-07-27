<div class="row">
    <div class="col-md-12 xCNPromotionStep3TableGroupBuyContainer">
        <!--Section : เงื่อนไขกลุ่มซื้อ-->
        <div class="panel panel-default" style="margin-bottom: 10px;">
            <div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'tPurchaseGroupConditions'); ?></label>
            </div>

            <div class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body xCNPDModlue xCNPromotionStep3TableGroupBuy">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 xCNPromotionStep3TableGroupBuyWithGroupGetContainer">
        <!--Section : เงื่อนไขกลุ่มซื้อ กลุ่มรับ-->
        <div class="panel panel-default" style="margin-bottom: 10px;">
            <div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'tPurchaseGroupConditions_Get'); ?></label>
            </div>

            <div class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body xCNPDModlue xCNPromotionStep3TableGroupBuyWithGroupGet">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 xCNPromotionStep3TableGroupGetContainer">
        <!--Section : เงื่อนไขกลุ่มรับ-->
        <div class="panel panel-default" style="margin-bottom: 10px;">
            <div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'tGetGroupConditions'); ?></label>
            </div>

            <div class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body xCNPDModlue">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="fancy-checkbox" style="width: fit-content;">
                                    <input 
                                    type="checkbox" 
                                    class="xCNApvOrCanCelDisabled" 
                                    value="1" 
                                    id="ocbPromotionStep3GroupGetControl" 
                                    name="ocbPromotionStep3GroupGetControl" 
                                    maxlength="1"
                                    <?php echo ($bIsApvOrCancel)?'disabled':''; ?> 
                                    checked>
                                    <span>&nbsp;</span>
                                    <span class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tGetRight'); ?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="xCNPromotionStep3TableGroupGet"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <!--Section : เงื่อนไข - สิทธิประโยชน์คูปอง-->
        <div class="panel panel-default" style="margin-bottom: 10px;">
            <div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'tConditions_CouponBenefits'); ?></label>
            </div>

            <div class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body xCNPDModlue xCNPromotionStep3TableCoupon">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="fancy-checkbox" style="width: fit-content;">
                                    <input 
                                    type="checkbox" 
                                    class="xCNApvOrCanCelDisabled" 
                                    value="1" 
                                    id="ocbPromotionStep3CouponControl" 
                                    name="ocbPromotionStep3CouponControl" 
                                    <?php echo ($bIsApvOrCancel)?'disabled':''; ?>
                                    maxlength="1">
                                    <span>&nbsp;</span>
                                    <span class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tGetRight'); ?></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select
                                disabled
                                onchange="JSvPromotionStep3InsertOrUpdateCouponToTemp()"
                                class="selectpicker form-control" 
                                id="ocmPromotionStep3PgtStaCoupon" 
                                name="ocmPromotionStep3PgtStaCoupon">
                                    <!-- <option value='1'><?php echo language('document/promotion/promotion', 'tIndeterminate'); ?></option> -->
                                    <option value='2'><?php echo language('document/promotion/promotion', 'tGrantCoupon'); ?></option>
                                    <option value='3'><?php echo language('document/promotion/promotion', 'tTheMessage'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">

                            <div class="form-group xCNPromotionStep3BrowseCouponContainer">
                                <div class="input-group">
                                    <input 
                                    name="oetPromotionStep3CouponName" 
                                    id="oetPromotionStep3CouponName" 
                                    class="form-control" 
                                    value="" 
                                    type="text" 
                                    readonly
                                    <?php echo ($bIsApvOrCancel)?'disabled':''; ?> 
                                    placeholder="<?= language('document/promotion/promotion', 'tCoupon') ?>">
                                    <input
                                    onchange="JSvPromotionStep3InsertOrUpdateCouponToTemp()" 
                                    name="oetPromotionStep3CouponCode" 
                                    id="oetPromotionStep3CouponCode" 
                                    value="<?php // echo $tUsrCode; ?>" 
                                    class="form-control xCNHide" 
                                    type="text">
                                    <span class="input-group-btn">
                                        <button 
                                        disabled
                                        class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" 
                                        id="obtPromotionBrowseCoupon" 
                                        type="button" 
                                        onclick="JSxPromotionStep3BrowseCoupon()">
                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                        </button>
                                    </span>
                                </div>
                            </div><!-- BrowseCoupon -->

                            <div class="form-group xCNPromotionStep3PgtCpnTextContainer" style="display: none;">
                                <input 
                                type="text"
                                onchange="JSvPromotionStep3InsertOrUpdateCouponToTemp()" 
                                class="form-control xCNApvOrCanCelDisabled" 
                                id="oetPromotionStep3PgtCpnText" 
                                name="oetPromotionStep3PgtCpnText" 
                                maxlength="50"
                                placeholder="<?php echo language('document/promotion/promotion', 'tTheMessage'); ?>" 
                                value="<?php echo $tPmhName; ?>">
                            </div>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <!--Section : เงื่อนไข - สิทธิประโยชน์แต้ม-->
        <div class="panel panel-default" style="margin-bottom: 10px;">
            <div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'tConditions_PointsBenefits'); ?></label>
            </div>

            <div class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body xCNPDModlue xCNPromotionStep3TablePoint">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="fancy-checkbox" style="width: fit-content;">
                                    <input
                                    type="checkbox" 
                                    class="xCNApvOrCanCelDisabled" 
                                    value="1" 
                                    id="ocbPromotionStep3PointControl" 
                                    name="ocbPromotionStep3PointControl" 
                                    <?php echo ($bIsApvOrCancel)?'disabled':''; ?>
                                    maxlength="1">
                                    <span>&nbsp;</span>
                                    <span class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tGetRight'); ?></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select 
                                disabled
                                onchange="JSvPromotionStep3InsertOrUpdatePointToTemp()"
                                class="selectpicker form-control" 
                                id="ocmPromotionStep3PgtStaPoint" 
                                name="ocmPromotionStep3PgtStaPoint">
                                    <!-- <option value='1'><?php echo language('document/promotion/promotion', 'tIndeterminate'); ?></option> -->
                                    <option value='2'><?php echo language('document/promotion/promotion', 'tGivePoints'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select 
                                disabled
                                onchange="JSvPromotionStep3InsertOrUpdatePointToTemp()"
                                class="selectpicker form-control" 
                                id="ocmPromotionStep3PgtStaPntCalType" 
                                name="ocmPromotionStep3PgtStaPntCalType">
                                    <option value='1'><?php echo language('document/promotion/promotion', 'tFullyWorth'); ?></option>
                                    <option value='2'><?php echo language('document/promotion/promotion', 'tFullyPurchased'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input 
                                disabled
                                onchange="JSvPromotionStep3InsertOrUpdatePointToTemp()"
                                name="oetPromotionStep3PgtPntBuy"
                                id="oetPromotionStep3PgtPntBuy" 
                                class="form-control text-right xCNInputLength xCNInputNumericWithoutDecimal" 
                                data-length="15"
                                maxlength="15"
                                value="" 
                                type="text" 
                                placeholder="<?= language('document/promotion/promotion', 'tRatio') ?>"> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input 
                                disabled
                                onchange="JSvPromotionStep3InsertOrUpdatePointToTemp()"
                                name="oetPromotionStep3PgtPntGet" 
                                id="oetPromotionStep3PgtPntGet" 
                                class="form-control text-right xCNInputLength xCNInputNumericWithoutDecimal" 
                                data-length="15"
                                maxlength="15"
                                value="" 
                                type="text" 
                                placeholder="<?= language('document/promotion/promotion', 'tNumber') ?>"> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('script/jStep3.php'); ?>