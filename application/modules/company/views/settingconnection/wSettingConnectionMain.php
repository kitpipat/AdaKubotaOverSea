<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p style="font-weight: bold;"><?=language('company/settingconnection/settingconnection','tBCHSetConnectTitle')?></p>
    </div>

    <!--ปุ่มเพิ่ม-->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
        <?php if($aAlwEventBchSettingCon['tAutStaFull'] == 1 || $aAlwEventBchSettingCon['tAutStaDelete'] == 1 ) : ?>  
            <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                    <?=language('common/main/main','tCMNOption')?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li id="oliBtnDeleteAll" class="disabled">
                        <a data-toggle="modal" data-target="#odvModalDeleteMutirecord"><?=language('common/main/main','tDelAll')?></a>
                    </li>
                </ul>
            </div>
        <?php endif;?>
        <?php if($aAlwEventBchSettingCon['tAutStaFull'] == 1 || $aAlwEventBchSettingCon['tAutStaAdd'] == 1) : ?>
            <button id="obtBchSetConnection" name="obtBchSetConnection" class="xCNBTNPrimeryPlus" type="button" style="margin-left: 20px; margin-top: 0px;" onclick="JSvCallPageBchSetConnectionAdd()">+</button>
        <?php endif;?>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>

    <!--content-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvContentBchSetConnectionDataTable"></div>
    </div>
</div>

<!--SettingConnection  ที่กำลังจะสร้างข้อมูลการเชื่อมต่อ -->
<?php
    $tBchCode    = $aBchCodeSetConnect['tBchCode'];
?>
<input type="hidden" id="ohdBchCode" name="ohdBchCode" value="<?=$tBchCode?>">
<?php include "script/jSettingConnectionMain.php"; ?>


