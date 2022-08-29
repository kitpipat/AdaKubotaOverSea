<input id="oetPunStaBrowse" type="hidden" value="<?php echo $nPunBrowseType?>">
<input id="oetPunCallBackOption" type="hidden" value="<?php echo $tPunBrowseOption?>">

<?php if(isset($nPunBrowseType) && $nPunBrowseType == 0) : ?>
	<div id="odvPunMenuTitle" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <ol id="oliMenuNav" class="breadcrumb">
                            <?php FCNxHADDfavorite('settingUrlFormat/0/0');?> 
                            <li id="oliCountryTitle" class="xCNLinkClick" onclick="JSvCallPageURLList()" style="cursor:pointer"><?php echo language('settingconfig/settingurlformat/settingurlformat','tAngTitle')?></li>
                            <li id="oliUrlTitleAdd" class="active"><a><?php echo language('settingconfig/settingurlformat/settingurlformat','tAngTitleAdd')?></a></li>
                            <li id="oliUrlTitleEdit" class="active"><a><?php echo language('settingconfig/settingurlformat/settingurlformat','tAngTitleEdit')?></a></li>
                        </ol>
					</div>
                        <div class="col-xs-12 col-md-4 text-right p-r-0">
                        <div id="odvBtnUrlInfo">
                            <?php if($aAlwEventUrl['tAutStaFull'] == 1 || $aAlwEventUrl['tAutStaAdd'] == 1) : ?>
                            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageURLAdd()">+</button>
                            <?php endif; ?>
                        </div>
                        <div id="odvBtnAddEdit" style="margin-top:3px">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button onclick="JSvCallPageURLList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                                
                                <?php if($aAlwEventUrl['tAutStaFull'] == 1 || ($aAlwEventUrl['tAutStaAdd'] == 1 || $aAlwEventUrl['tAutStaEdit'] == 1)) : ?>
                                <div class="btn-group">
                                <button onclick="$('#obtSubmitUrl').click();" class="btn btn-default xWBtnGrpSaveLeft" type="submit"> <?= language('common/main/main', 'tSave')?></button>
                                    <?php echo $vBtnSave?>
                                </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
					</div>
				</div>
			</div>
		</div>
	<div class="xCNMenuCump xCNPtyBrowseLine" id="odvMenuCump">
		&nbsp;
	</div>
	<div class="main-content">
		<div id="odvContentPageUrl" class="panel panel-headline"></div>
	</div>
	<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
    <?php else: ?>
        <div class="modal-header xCNModalHead">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <a onclick="JCNxBrowseData('<?php echo $tPunBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                        <i class="fa fa-arrow-left xCNIcon"></i>	
                    </a>
                    <ol id="oliPunNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tPunBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('product/pdtunit/pdtunit','tPUNTitle')?></a></li>
                        <li class="active"><a><?php echo language('product/pdtunit/pdtunit','tPUNTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvCtyBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitUrl').click()"><?php echo language('common/main/main', 'tSave')?></button>
                    </div>
                </div>
            </div>
        </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
</div>
<?php endif;?>	
<script src="<?php echo  base_url('application/modules/settingconfig/assets/src/settingurlformat/jUrlFormat.js')?>"></script>

