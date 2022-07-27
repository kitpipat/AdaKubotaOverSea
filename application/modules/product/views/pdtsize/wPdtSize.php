<input id="oetPszStaBrowse" type="hidden" value="<?=$nPszBrowseType?>">
<input id="oetPszCallBackOption" type="hidden" value="<?=$tPszBrowseOption?>">

<?php if(isset($nPszBrowseType) && $nPszBrowseType == 0) : ?>
<div id="odvPszMainMenu" class="main-menu"> <!-- เปลี่ยน -->
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNPszVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb"> <!-- เปลี่ยน -->
                        <?php FCNxHADDfavorite('pdtsize/0/0');?> 
                        <li id="oliPszTitle" class="xCNLinkClick" onclick="JSvCallPagePdtPszList()" style="cursor:pointer"><?= language('product/pdtsize/pdtsize','tPSZTitle')?></li> <!-- เปลี่ยน -->
                        <li id="oliPszTitleAdd" class="active"><a><?= language('product/pdtsize/pdtsize','tPSZTitleAdd')?></a></li>
                        <li id="oliPszTitleEdit" class="active"><a><?= language('product/pdtsize/pdtsize','tPSZTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0"> <!-- เปลี่ยน -->
                    <div id="odvBtnPszInfo">
                        <?php if($aAlwEventPdtSize['tAutStaFull'] == 1 || $aAlwEventPdtSize['tAutStaAdd'] == 1) : ?>
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPagePdtPszAdd()">+</button>
                        <?php endif;?>
                    </div>
                    <div id="odvBtnAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button onclick="JSvCallPagePdtPszList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                            <?php if($aAlwEventPdtSize['tAutStaFull'] == 1 || ($aAlwEventPdtSize['tAutStaAdd'] == 1 || $aAlwEventPdtSize['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitPdtPsz').click()"> <?php echo language('common/main/main', 'tSave')?></button>
								<?php echo $vBtnSave?>
							</div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xCNPszVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?php echo $tPszBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
						<i class="fa fa-arrow-left xCNBackBowse"></i>	
					</a>
                    <ol id="oliPunNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tPszBrowseOption?>')"><a>แสดงข้อมูล : <?php echo language('product/pdtsize/pdtsize','tPSZTitle')?></a></li>
                        <li class="active"><a><?php echo  language('product/pdtsize/pdtsize','tPSZTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitPdtPsz').click()"><?php echo  language('common/main/main', 'tSave')?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>
<div class="xCNMenuCump xCNPszBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPagePdtPsz"></div>
</div>
<script src="<?= base_url('application/modules/product/assets/src/pdtsize/jPdtSize.js')?>"></script>