<input id="oetPAMStaBrowse"         type="hidden" value="<?=$nPAMBrowseType ?>">
<input id="oetPAMCallBackOption"    type="hidden" value="<?=$tPAMBrowseOption ?>">

<div id="odvPAMMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <ol id="oliPAMMenuNav" class="breadcrumb">
                    <?php FCNxHADDfavorite('docPAM/0/0');?>
                    <li id="oliPAMTitle" class="xCNLinkClick" onclick="JSvPAMCallPageList('')"><?=language('document/productarrangement/productarrangement', 'tPAMTitleMenu'); ?></li>
                    <li id="oliPAMTitleAdd" class="active"><a><?=language('document/productarrangement/productarrangement', 'tPAMTitleAdd'); ?></a></li>
                    <li id="oliPAMTitleEdit" class="active"><a><?=language('document/productarrangement/productarrangement', 'tPAMTitleEdit'); ?></a></li>
                </ol>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                    <div id="odvPAMBtnGrpInfo">
                        <?php
                        if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
                            <button id="obtPAMCallPageAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvPAMCallPageAddDoc();">+</button>
                        <?php endif; ?>
                    </div>
                    <div id="odvPAMBtnGrpAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button id="obtPAMCallBackPage"  class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?=language('common/main/main', 'tBack'); ?></button>
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaPrint'] == 1)): ?>
                                <button id="obtPAMPrintDoc" onclick="JSxPAMPrintDoc()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?=language('common/main/main', 'tCMNPrint'); ?></button>
                            <?php endif; ?>
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaCancel'] == 1)): ?>
                                <button id="obtPAMCancelDoc" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?=language('common/main/main', 'tCancel'); ?></button>
                            <?php endif; ?>
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAppv'] == 1)): ?>
                                <button id="obtPAMApproveDoc" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?=language('common/main/main', 'tCMNApprove'); ?></button>
                            <?php endif; ?>
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)): ?>
                                <div  id="odvPAMBtnGrpSave" class="btn-group">
                                    <button id="obtPAMSubmitFromDoc" type="button" class="btn xWBtnGrpSaveLeft"> <?=language('common/main/main', 'tSave'); ?></button>
                                    <?=$vBtnSave ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="xCNMenuCump xCNPAMBrowseLine" id="odvMenuCump">&nbsp;</div>
<div class="main-content">
    <div id="odvPAMContentPageDocument"></div>
</div>

<script type="text/javascript" src="<?=base_url(); ?>application/modules/document/assets/src/arrangementproduct/jArrangementproduct.js"></script>
