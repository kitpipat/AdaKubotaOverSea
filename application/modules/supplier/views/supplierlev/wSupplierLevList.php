<div class="panel panel-headline"> <!-- เพิ่ม -->
	<div class="panel-heading"> <!-- เพิ่ม -->
		<div class="row">
			<div class="col-xs-8 col-md-4 col-lg-4">
				<div class="form-group"> <!-- เปลี่ยน From Imput Class -->
					<label class="xCNLabelFrm"><?php echo language('supplier/supplierlev/supplierlev','tSLVSearch')?></label>
					<div class="input-group">
						<input type="text" class="form-control" id="oetSearchSupplierLevel" name="oetSearchSupplierLevel" placeholder="<?php echo language('supplier/supplierlev/supplierlev','tSLVSearchData')?>">
						<span class="input-group-btn">
							<button id="oimSearchSupplierLevel" class="btn xCNBtnSearch" type="button">
								<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
							</button>
						</span>
					</div>
				</div>
			</div>
			<?php if($aAlwEventSupplierLevel['tAutStaFull'] == 1 || $aAlwEventSupplierLevel['tAutStaDelete'] == 1 ) : ?>
			<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
				<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
					<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
						<?php echo language('common/main/main','tCMNOption')?>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li id="oliBtnDeleteAll" class="disabled">
							<a data-toggle="modal" data-target="#odvModalDelSupplierLevel"><?php echo language('common/main/main','tDelAll')?></a>
						</li>
					</ul>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
	<input type="hidden" name="ohdDeleteconfirm" id="ohdDeleteconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItems') ?>">
	<input type="hidden" name="ohdDeleteconfirmYN" id="ohdDeleteconfirmYN" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsYN') ?>">

	<div class="panel-body">
		<section id="ostDataSupplierLevel"></section>
	</div>
</div>

<script>
	$('#oimSearchSupplierLevel').click(function(){
		JCNxOpenLoading();
		JSvSupplierLevelDataTable();
	});
	$('#oetSearchSupplierLevel').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvSupplierLevelDataTable();
		}
	});
</script>
