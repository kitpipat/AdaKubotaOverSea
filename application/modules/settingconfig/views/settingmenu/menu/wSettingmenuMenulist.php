<style>
fieldset {
    margin: 0;
    padding: 10px;
    position: relative;
    padding-left: 10px !important;

    border: 1px solid #ccc;
    position: relative;
    padding: 15px;
    margin-top: 30px;
}
</style>
<!-- View Modal Add/Edit MenuList -->
<div id="odvSMPModalAddEditMenuList" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label
                            class="xCNTextModalHeard"><?php echo language('settingconfig/settingmenu/settingmenu', 'tSettingMenu_Menu'); ?></label>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color:#FFF;opacity:1;margin-top:-11px;">
                            <span aria-hidden="true" style="font-size: 30px !important;">×</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="panel-body" style="padding:10px">
                    <form action="javascript:void(0);" class="validate-form" method="post" id="ofmSMPAddEditMenuList">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span>
                                        <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalModuleName');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetSMPMenuListModuleCode"
                                            name="oetSMPMenuListModuleCode">
                                        <input type="text" class="form-control xWPointerEventNone"
                                            id="oetSMPMenuListModuleName" name="oetSMPMenuListModuleName"
                                            autocomplete="off"
                                            data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tValidModuleName');?>"
                                            readonly>
                                        <span class="input-group-btn">
                                            <button id="oimSMPBrowseModuleMenuList" type="button"
                                                class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="xCNLabelFrm">
                                        <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuGrpName');?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide" id="oetSMPMenuListMenuGrpCode"
                                            name="oetSMPMenuListMenuGrpCode">
                                        <input type="text" class="form-control xWPointerEventNone"
                                            id="oetSMPMenuListMenuGrpName" name="oetSMPMenuListMenuGrpName"
                                            autocomplete="off"
                                            data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tModalMenuGrpName');?>"
                                            readonly>
                                        <span class="input-group-btn">
                                            <button id="oimSMPBrowseMenuGrp" type="button"
                                                class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span>
                                        <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuListCode'); ?></label>
                                    <input type="hidden" id="ohdCheckDuplicateMenuListCode"
                                        name="ohdCheckDuplicateMenuListCode" value="1">
                                    <input type="text" class="form-control" maxlength="100" id="oetSMPMenuListCode"
                                        name="oetSMPMenuListCode"
                                        placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuListCode'); ?>"
                                        autocomplete="off"
                                        data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu', 'tValidMenuListCode'); ?>"
                                        data-validate-dublicateCode="<?php echo language('settingconfig/settingmenu/settingmenu', 'tValidMenuListDupCode'); ?>">
                                </div>

                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span>
                                        <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuListName'); ?></label>
                                    <input type="text" class="form-control" maxlength="100" id="oetSMPMenuListName"
                                        name="oetSMPMenuListName"
                                        placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuListName'); ?>"
                                        autocomplete="off"
                                        data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tValidMenuListName');?>">
                                </div>

                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span>
                                        <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuListSeq'); ?></label>
                                    <input type="number" class="form-control" maxlength="100" id="oetSMPMenuListSeq"
                                        min="1" name="oetSMPMenuListSeq"
                                        placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuListSeq'); ?>"
                                        autocomplete="off"
                                        data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tValidMenuListSeq');?>">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                <div class="form-group">
                                    <label class="xCNLabelFrm">
                                        <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuListRemark'); ?></label>
                                    <input type="text" class="form-control" maxlength="100" id="oetSMPMenuListRemark"
                                        name="oetSMPMenuListRemark"
                                        placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuListRemark'); ?>"
                                        autocomplete="off"
                                        data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tValidMenuListRemark');?>">
                                </div>

                                <div class="form-group">
                                    <label class="xCNLabelFrm">
                                        <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuListRouteName'); ?></label>
                                    <input type="text" class="form-control" maxlength="100"
                                        id="oetSMPMenuListControllerName" name="oetSMPMenuListControllerName"
                                        placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuListRouteName'); ?>"
                                        autocomplete="off"
                                        data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tValidMenuListControllerName');?>">
                                </div>

                                <fieldset>
                                    <label class="xCNLabelFrm"
                                        style="position: absolute;top: -15px;left: 15px;background: #fff;padding-left: 10px;padding-right: 10px;">
                                        <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuListAuth'); ?>
                                    </label>
                                    <div class="col-xs-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="fancy-checkbox">
                                                <input type="checkbox" id="ocbSMPAutStaRead" name="ocbSMPAutStaRead"
                                                    checked="checked">
                                                <span><?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuListAutStaRead'); ?></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-xs-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="fancy-checkbox">
                                                <input type="checkbox" id="ocbSMPAutStaAdd" name="ocbSMPAutStaAdd"
                                                    checked="checked">
                                                <span><?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuListAutStaAdd'); ?></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-xs-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="fancy-checkbox">
                                                <input type="checkbox" id="ocbSMPAutStaDelete" name="ocbSMPAutStaDelete"
                                                    checked="checked">
                                                <span><?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuListAutStaDelete'); ?></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-xs-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="fancy-checkbox">
                                                <input type="checkbox" id="ocbSMPAutStaEdit" name="ocbSMPAutStaEdit"
                                                    checked="checked">
                                                <span><?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuListAutStaEdit'); ?></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-xs-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="fancy-checkbox">
                                                <input type="checkbox" id="ocbSMPAutStaCancel"
                                                    name="ocbSMPAutStaCancel">
                                                <span><?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuListAutStaCancel'); ?></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-xs-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="fancy-checkbox">
                                                <input type="checkbox" id="ocbSMPAutStaAppv" name="ocbSMPAutStaAppv">
                                                <span><?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuListAutStaAppv'); ?></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-xs-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="fancy-checkbox">
                                                <input type="checkbox" id="ocbSMPAutStaPrint" name="ocbSMPAutStaPrint">
                                                <span><?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuListAutStaPrint'); ?></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-xs-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="fancy-checkbox">
                                                <input type="checkbox" id="ocbSMPAutStaPrintMore"
                                                    name="ocbSMPAutStaPrintMore">
                                                <span><?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuListAutStaPrintMore'); ?></span>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <button type="submit" id="obtSMPModalMenuListSubmit" style="display:none"></button>
                    </form>
                    <div class="col-lg-12 pt-3">
                        <div class="btn-group pull-right" style="margin: 10px 0 20px 0;">
                            <button type="button" class="btn xCNBTNDefult" style="margin-right:10px;"
                                data-dismiss="modal">
                                <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuCancel'); ?></button>
                            <button type="submit" class="btn xCNBTNPrimery xCNAddPmtGroupModalCanCelDisabled"
                                onclick="$('#obtSMPModalMenuListSubmit').click()" id="obtSMPAddMenuList">
                                <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalSave'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'script/jSettingmenuMenulist.php';?>