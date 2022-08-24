<input id="oetPunStaBrowse" type="hidden" value="<?php echo $nPunBrowseType?>">
<input id="oetPunCallBackOption" type="hidden" value="<?php echo $tPunBrowseOption?>">

<?php if(isset($nPunBrowseType) && $nPunBrowseType == 0) : ?>
	<div id="odvPunMenuTitle" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <ol id="oliMenuNav" class="breadcrumb">
                            <?php FCNxHADDfavorite('pdtunit/0/0');?> 
                            <li id="oliCountryTitle" class="xCNLinkClick" onclick="JSvCallPageCountryList()" style="cursor:pointer"><?php echo language('company/country/country','tCountryTitle')?></li>
                            <li id="oliCountryTitleAdd" class="active"><a><?php echo language('company/country/country','tCountryTitleAdd')?></a></li>
                            <li id="oliCountryTitleEdit" class="active"><a><?php echo language('company/country/country','tCountryTitleEdit')?></a></li>
                        </ol>
					</div>
                        <div class="col-xs-12 col-md-4 text-right p-r-0">
                        <div id="odvBtnCtyInfo">
                            <?php if($aAlwEventPdtUnit['tAutStaFull'] == 1 || $aAlwEventPdtUnit['tAutStaAdd'] == 1) : ?>
                            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageCountryAdd()">+</button>
                            <?php endif; ?>
                        </div>
                        <div id="odvBtnAddEdit" style="margin-top:3px">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button onclick="JSvCallPageCountryList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                                
                                <?php if($aAlwEventPdtUnit['tAutStaFull'] == 1 || ($aAlwEventPdtUnit['tAutStaAdd'] == 1 || $aAlwEventPdtUnit['tAutStaEdit'] == 1)) : ?>
                                <div class="btn-group">
                                <button onclick="$('#obtSubmitCty').click();" class="btn btn-default xWBtnGrpSaveLeft" type="submit"> <?= language('common/main/main', 'tSave')?></button>
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
		<div id="odvContentPageCountry" class="panel panel-headline"></div>
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
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCty').click()"><?php echo language('common/main/main', 'tSave')?></button>
                    </div>
                </div>
            </div>
        </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
</div>
<?php endif;?>	
<script src="<?php echo  base_url('application/modules/company/assets/src/country/jCountry.js')?>"></script>

