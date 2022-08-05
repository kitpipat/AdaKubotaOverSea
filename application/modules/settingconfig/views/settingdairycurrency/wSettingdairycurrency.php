<input id="oetSettingConfigStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetSettingConfigCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<div id="odvSettingConfigMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNSettingConfigVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('SettingDailyCurrency/0/0');?>
                        <li id="oliSettingConfigTitle" class="xCNLinkClick" onclick="JSvSettingConfigDailyCurrencyCallPageList()"><?php echo language('settingconfig/settingdairycurrency/settingdairycurrency', 'tSettingDailyCurrencyTitle'); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="xCNMenuCump xCNSettingConfigBrowseLine" id="odvMenuCump">&nbsp;</div>

<div class="main-content">
    <div id="odvContentPageSettingDairyCurrency"></div>
</div>

<script type="text/javascript" src="<?php echo base_url('application/modules/settingconfig/assets/src/settingdailycurrency/jSettingsettingdailycurrency.js'); ?>"></script>
