<input id="oetRcvStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetRcvCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<div class="main-menu clearfix">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<ol id="oliMenuNav" class="breadcrumb">
					<?php FCNxHADDfavorite('recive/0/0');?> 
					<li id="oliCrdTitle" class="xCNLinkClick" onclick="JSvCallPageReciveList()" style="cursor:pointer"><?= language('payment/recive/recive','tRCVTitle')?></li>
					<li id="oliRcvTitleAdd" class="active"><a><?= language('payment/recive/recive','tRCVTitleAdd')?></a></li>
					<li id="oliRcvTitleEdit" class="active"><a><?= language('payment/recive/recive','tRCVTitleEdit')?></a></li>
				</ol>
			</div>
			
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
				<div class="demo-button xCNBtngroup" style="width:100%;">
					<div id="odvBtnRcvInfo">
						<?php if($aAlwEventRecive['tAutStaFull'] == 1 || $aAlwEventRecive['tAutStaAdd'] == 1) : ?>
							<button id="obtRcvAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageReciveAdd()">+</button>
						<?php endif; ?>
					</div>
					<div id="odvBtnAddEdit" class="xWHideSave">
						<button onclick="JSvCallPageReciveList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"><?= language('common/main/main', 'tBack')?></button>
						<?php if($aAlwEventRecive['tAutStaFull'] == 1 || ($aAlwEventRecive['tAutStaAdd'] == 1 || $aAlwEventRecive['tAutStaEdit'] == 1)) : ?>
							<div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft " onclick="$('#obtSubmitRecive').click()"><?= language('common/main/main', 'tSave')?></button>
								<?=$vBtnSave?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="xCNMenuCump" id="odvMenuCump">
	&nbsp;
</div>
<div class="main-content">
	<div id="odvContentPageRecive" class="panel panel-headline">
	</div>
</div>
<script src="<?= base_url('application/modules/payment/assets/src/recive/jRecive.js')?>"></script>
