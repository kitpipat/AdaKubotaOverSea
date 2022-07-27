<div class="panel-heading">
    <div class="row">
        <div class="col-xs-8 col-md-4 col-lg-4">
			<div class="form-group"> <!-- เปลี่ยน From Imput Class -->
				<label class="xCNLabelFrm"><?php echo language('common/main/main','tSearchNew')?></label>
				<div class="input-group">
					<input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchDpt" name="oetSearchDpt" placeholder="<?php echo language('authen/department/department','tPlaceholder')?>">
					<span class="input-group-btn">
						<button id="oimSearchDpt" class="btn xCNBtnSearch" type="button">
							<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
						</button>
					</span>
				</div>
			</div>
		</div>
		<?php if($aAlwEventDepartment['tAutStaFull'] == 1 || ($aAlwEventDepartment['tAutStaAdd'] == 1 || $aAlwEventDepartment['tAutStaEdit'] == 1)) : ?>
		<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
			<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
				<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
				<?= language('common/main/main','tCMNOption')?>
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li id="oliBtnDeleteAll" class="disabled">
						<a data-toggle="modal" data-target="#odvModalDelDpt"><?= language('common/main/main','tDelAll')?></a>
					</ul>
			</div>
		</div>
		<?php endif;?>
	</div>
</div>

<div class="panel-body">
    <section id="ostDataDpt"></section>
</div>

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>

<script>
	$('#oimSearchDpt').click(function(){
		JCNxOpenLoading();
		JSvDptDataTable();
	});
	$('#oetSearchDpt').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvDptDataTable();
		}
	});
</script>
