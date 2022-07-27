<input id="oetClrStaBrowse" type="hidden" value="<?=$nClrBrowseType?>">
<input id="oetClrCallBackOption" type="hidden" value="<?=$tClrBrowseOption?>">

<?php if(isset($nClrBrowseType) && $nClrBrowseType == 0) : ?>
<div id="odvClrMainMenu" class="main-menu"> <!-- เปลี่ยน -->
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNClrVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb"> <!-- เปลี่ยน -->
                        <?php FCNxHADDfavorite('pdtcolor/0/0');?> 
                        <li id="oliClrTitle" class="xCNLinkClick" onclick="JSvCallPagePdtClrList()" style="cursor:pointer"><?= language('product/pdtcolor/pdtcolor','tCLRTitle')?></li> <!-- เปลี่ยน -->
                        <li id="oliClrTitleAdd" class="active"><a><?= language('product/pdtcolor/pdtcolor','tCLRTitleAdd')?></a></li>
                        <li id="oliClrTitleEdit" class="active"><a><?= language('product/pdtcolor/pdtcolor','tCLRTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0"> <!-- เปลี่ยน -->
                    <div id="odvBtnClrInfo">
                        <?php if($aAlwEventPdtColor['tAutStaFull'] == 1 || $aAlwEventPdtColor['tAutStaAdd'] == 1) : ?>
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPagePdtClrAdd()">+</button>
                        <?php endif;?>
                    </div>
                    <div id="odvBtnAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button onclick="JSvCallPagePdtClrList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                            <?php if($aAlwEventPdtColor['tAutStaFull'] == 1 || ($aAlwEventPdtColor['tAutStaAdd'] == 1 || $aAlwEventPdtColor['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="JSxSetStatusClickClrSubmit();$('#obtSubmitPdtClr').click()"> <?php echo language('common/main/main', 'tSave')?></button>
								<?php echo $vBtnSave?>
							</div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xCNClrVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?php echo $tClrBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
						<i class="fa fa-arrow-left xCNBackBowse"></i>	
					</a>
                    <ol id="oliPunNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tClrBrowseOption?>')"><a>แสดงข้อมูล : <?php echo language('product/pdtcolor/pdtcolor','tCLRTitle')?></a></li>
                        <li class="active"><a><?php echo  language('product/pdtcolor/pdtcolor','tCLRTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitPdtClr').click()"><?php echo  language('common/main/main', 'tSave')?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>
<div class="xCNMenuCump xCNClrBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPagePdtClr"></div>
</div>
<script src="<?= base_url('application/modules/product/assets/src/pdtcolor/jPdtColor.js')?>"></script>