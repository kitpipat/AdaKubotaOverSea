<input id="oetShpStaBrowse" type="hidden" value="<?php echo $nShpBrowseType?>">
<input id="oetShpCallBackOption" type="hidden" value="<?php echo $tShpBrowseOption?>">
<?php if(isset($nShpBrowseType) && $nShpBrowseType == 0) : ?>
	<div id="odvShpMainMenu" class="main-menu clearfix">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<ol id="oliMenuNav" class="breadcrumb">
							<?php FCNxHADDfavorite('shop/0/0');?> 
							<li id="oliShpTitle" class="xCNLinkClick" onclick="JSvCallPageShopList()" style="cursor:pointer"><?php echo  language('company/shop/shop','tSHPTitle')?></li>
							<li id="oliShpTitleAdd"  class="active"><a><?php echo  language('company/shop/shop','tSHPTitleAdd')?></a></li>
							<li id="oliShpTitleEdit" class="active"><a><?php echo  language('company/shop/shop','tSHPTitleEdit')?></a></li>
						</ol>
					</div>
					<div id="odvBtnGrpShop" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
						<div id="odvBtnShpInfo">
							<?php if($aAlwEventShop['tAutStaFull'] == 1 || $aAlwEventShop['tAutStaAdd'] == 1) : ?>
								<button class="xCNBTNPrimeryPlus" type="button" onclick="JSvSHPAddPage()">+</button>
							<?php endif; ?>

							<!--เช็คสิทธิ 12/03/2020 supawat -->
							<script>
								if('<?=$this->session->userdata('tSesUsrLevel')?>' == 'SHP'){
									$('.xCNBTNPrimeryPlus').hide();
								}
							</script>

						</div>
						<div id="odvBtnAddEdit">
							<button onclick="JSvCallPageShopList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo  language('common/main/main', 'tBack')?></button>
							<?php if($aAlwEventShop['tAutStaFull'] == 1 || ($aAlwEventShop['tAutStaAdd'] == 1 || $aAlwEventShop['tAutStaEdit'] == 1)) : ?>
								<div class="btn-group">
									<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitShp').click()"> <?php echo  language('common/main/main', 'tSave')?></button>
									<?php echo $vBtnSave?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<div class="xCNMenuCump xCNShpBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
        <div id="odvContentPageShop" class="panel panel-headline" style="margin-bottom:0px;">
        </div>
    </div>
<?php else: ?>
	<div class="modal-header xCNModalHead">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a onclick="JCNxBrowseData('<?php echo $tShpBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
					<i class="fa fa-arrow-left xCNIcon"></i>	
				</a>
				<ol id="oliShpNavBrowse" class="breadcrumb xCNMenuModalBrowse">
					<li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tShpBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('company/shop/shop','tSHPTitle')?></a></li>
					<li class="active"><a><?php echo  language('company/shop/shop','tSHPTitleAdd')?></a></li>
				</ol>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
				<div id="odvShpBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
					<button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitShp').click()"><?php echo  language('common/main/main', 'tSave')?></button>
				</div>
			</div>
		</div>
	</div>
	<div id="odvModalBodyBrowse" class="modal-body">
	</div>
<?php endif;?>
<script src="<?php echo  base_url('application/modules/company/assets/src/shop/jShop.js'); ?>"></script>
<script src="<?php echo  base_url('application/modules/company/assets/src/shopgpbyshp/jShopGpByShp.js'); ?>"></script>
<script src="<?php echo  base_url('application/modules/company/assets/src/shopgpbypdt/jShopGpByPdt.js'); ?>"></script>
<script src="<?php echo  base_url('application/modules/pos/assets/src/posshop/jPosShop.js'); ?>"></script>
<!--Vending ประเภทตู้สินค้า -->
<script src="<?php echo base_url('application/modules/vending/assets/src/vendingshoptype/jVendingshoptype.js'); ?>"></script>
<!--Vending รูปแบบตู้สินค้า -->
<script src="<?php echo base_url('application/modules/vending/assets/src/vendingshoplayout/jVendingshoplayout.js'); ?>"></script>
<script src="<?php echo base_url('application/modules/vending/assets/src/vendingshoplayout/jVendingManagelayout.js');?>"></script>