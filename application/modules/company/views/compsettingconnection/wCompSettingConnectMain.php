<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <p style="font-weight: bold;"><?=language('company/compsettingconnect/compsettingconnect','tCompSetConnectTitle')?></p>
    </div>

    
    <!--ปุ่มเพิ่ม-->
    <div class="text-right">
        <?php if($aAlwEventCompSettingCon['tAutStaFull'] == 1 || $aAlwEventCompSettingCon['tAutStaDelete'] == 1 ) : ?>  
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
        <?php if($aAlwEventCompSettingCon['tAutStaFull'] == 1 || $aAlwEventCompSettingCon['tAutStaAdd'] == 1) : ?>
            <button id="obtCompSetConnection" name="obtCompSetConnection" class="xCNBTNPrimeryPlus" type="button" style="margin-left: 20px; margin-top: 0px;" onclick="JSvCallPageCompSetConnectAdd()">+</button>
        <?php endif;?>
    <div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
   
    <!-- Content -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvContentCompSetConnectDataTable"></div>
    </div>
</div>

<!--CompSettingConnection  ที่กำลังจะสร้างข้อมูลการเชื่อมต่อ -->
<?php
   $tCompCode = $aCompCodeSetConnect['tCompCode'];
?>
<input type ="hidden" id="ohdCompCode" name="ohdCompCode" value="<?php echo $tCompCode;?>">
<?php include "script/jCompSettingConnectMain.php"; ?>