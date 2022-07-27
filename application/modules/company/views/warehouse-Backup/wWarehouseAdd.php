<?php
	if(@$nResult['rtCode'] == '1'){//Success

		//Table Master
		$tWahStaType    = $nResult['roItem']['rtWahStaType'];
		$tWahRefCode    = $nResult['roItem']['rtWahRefCode'];
		$tWahCode       = $nResult['roItem']['rtWahCode'];
		$tWahName       = $nResult['roItem']['rtWahName'];
		$tBchCode		= $nResult['roItem']['rtBchCode'];
		$tBchName		= $nResult['roItem']['rtBchName'];
		$tShpCode		= $nResult['roItem']['rtShpCode'];
		$tShpName		= $nResult['roItem']['rtShpName'];
		$tSpnCode		= $nResult['roItem']['rtSpnCode'];
		$tSpnName		= $nResult['roItem']['rtSpnName'];
		$tPosCode		= $nResult['roItem']['rtPosCode'];
		$tPosComName	= $nResult['roItem']['rtPosComName'];
		$tPosComName	= $nResult['roItem']['rtShpName'];
		$tStaUsrLevel   = $tStaUsrLevel;
		$tUsrBchCode    = $tUsrBchCode;
		
		$tRoute			= 'warehouseEventEdit'; //Route ควบคุมการทำงาน Edit
	
	}else{ // fail;
		$tRoute 		= 'warehouseEventAdd'; //Route ควบคุมการทำงาน Add
		$tWahCode		= "";
		$tWahName		= "";
		$tBchCode		= "";
		$tBchName 		= "";
		$tShpCode		= "";
		$tShpName 		= "";
		$tSpnCode		= "";
		$tSpnName 		= "";
		$tPosCode		= "";
		$tPosComName	= "";
		$tStaUsrLevel   = $tStaUsrLevel;
		$tUsrBchCode    = $tUsrBchCode;
	}
?>

<!-- Zone Input Hide -->
<input type="text" class="xCNHide" id="ohdWahStaType" value="<?=@$tWahStaType?>">
<!-- Zone Input Hide -->
	
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddWarehouse">
	<button type="submit" id="obtSubmitWah" onclick="JSnAddEditWarehouse('<?=$tRoute?>');" class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNHide" > <?php echo language('common/main/main', 'tSave')?></button>
		<div class="panel-body" style="padding-top:20px !important;">
			<div class="row">
				<div class="col-xs-12 col-md-5 col-lg-5">
						<label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('company/warehouse/warehouse','tWahCode');?></label>
                        <div id="odvWahAutoGenCode" class="form-group">
                            <div class="validate-input">
                            <label class="fancy-checkbox">
                            <input type="checkbox" id="ocbWahAutoGenCode" name="ocbWahAutoGenCode" checked="true" value="1">
                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                        </label>
                    </div>
                </div>
                    <div id="odvWahCodeForm" class="form-group">
                        <input type="hidden" id="ohdCheckDuplicateWahCode" name="ohdCheckDuplicateWahCode" value="1"> 
                            <div class="validate-input">
                                <input 
                                type="text" 
                                class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                                maxlength="5" 
                                id="oetWahCode" 
                                name="oetWahCode"
                                value="<?php echo $tWahCode ?>"
                                autocomplete="off"
                                data-is-created="<?php echo $tWahCode ?>"
                                placeholder="<?php echo language('company/warehouse/warehouse','tWahCode')?>"
                                data-validate-required = "<?php echo language('company/warehouse/warehouse','tWAHValidCode');?>"
                                data-validate-dublicateCode = "<?php echo language('company/warehouse/warehouse','tWAHValidCodeDup')?>"
                                >
                            </div>
                        </div>
						<div class="form-group">
							<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('company/warehouse/warehouse','tWahName')?></label> <!-- เปลี่ยนชื่อ Class -->
							<input
								class="form-control"
								type="text"
								id="oetWahName"
								name="oetWahName"
								placeholder="<?php echo language('company/warehouse/warehouse','tWahName')?>"
								maxlength="100"
								value="<?php echo @$tWahName?>"
								data-validate-required = "<?php echo language('company/warehouse/warehouse','tWAHValidName')?>"
							>
						</div>
						<!-- Browse สาขา -->
						<div class="form-group" id="odvWhaBach">
							<label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('company/warehouse/warehouse','tBrowseBCHName')?></label>
							<?php if($tStaUsrLevel == "HQ") : ?>
								<div class="input-group">
									<input type="text" class="form-control xCNHide" id="oetWAHBchCode" name="oetWAHBchCode" value="<?php echo @$tBchCode?>">
									<input type="text" class="form-control xWPointerEventNone" id="oetWAHBchName" name="oetWAHBchName" value="<?php echo @$tBchName?>" 
									data-validate-required = "<?php echo language('company/warehouse/warehouse','tWAHValidbch')?>"
									readonly>
									<span class="input-group-btn">
										<button id="oimShpBrowseBch" type="button" class="btn xCNBtnBrowseAddOn">
											<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
										</button>
									</span>
									</div>
								<?php else : ?>
								<div class="form-group">
								<input type="text" class="form-control xCNHide" id="oetWAHBchCode" name="oetWAHBchCode" value="<?php echo $tUsrBchCode;?>">
							<input class="form-control" type="text" id="oetWAHBchName" name="oetWAHBchName" maxlength="100"value="<?php echo @$tStaUsrLevel?>" readonly>
						</div>
							<?php endif; ?>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('company/warehouse/warehouse','tWahStaType')?></label>
							<select
								class="selectpicker form-control"
								id="ocmWahStaType"
								name="ocmWahStaType"
								maxlength="1"
								data-validate-required = "<?php echo language('company/warehouse/warehouse','tWAHValidType')?>"
							>
									<?php echo $vWahStaType;?>
							</select>
						</div>

						<!-- <div class="form-group" id="odvRefCode">
							<label class="xCNLabelFrm"><?php echo language('company/warehouse/warehouse','tWahRefCode')?></label>
							<input class="form-control" type="text" id="oetWahRefCode" name="oetWahRefCode" 
							placeholder="<?php echo language('company/warehouse/warehouse','tWahRefCode')?>"
							maxlength="50" value="<?=@$tWahRefCode?>" >
						</div> -->

						<!-- Browse ร้านค้า -->
						<div class="form-group" id="odvWhaShop">
							<label class="xCNLabelFrm"><?php echo language('company/warehouse/warehouse','tWahRefCode')?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNHide" id="oetWahRefCode" name="oetWahRefCode" value="<?php echo @$tWahRefCode?>">
								<input type="text" class="form-control xWPointerEventNone" id="oetWahRefName" name="oetWahRefName" value="<?php echo @$tShpName?>" readonly>
								<span class="input-group-btn">
									<button id="oimBrowseShop" type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
									</button>
								</span>
							</div>
						</div>

						<!-- Browse พนักงานขาย -->
						<!-- <div class="form-group" id="odvWhaSaleperson">
							<label class="xCNLabelFrm"><?php echo language('company/warehouse/warehouse','tSalePerson')?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNHide" id="oetSpnCode" name="oetSpnCode" maxlength="5" value="<?php echo @$tSpnCode?>">
								<input type="text" class="form-control xWPointerEventNone" id="oetSpnName" name="oetSpnName" maxlength="100" value="<?php echo @$tSpnName?>" readonly>
								<span class="input-group-btn">
									<button id="oimBrowseSalePerson" type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
									</button>
								</span>
							</div>
						</div> -->

						<!-- Browse จุดขาย -->
						<!-- <div class="form-group" id="odvWhaSaleMCPos">
							<label class="xCNLabelFrm"><?php echo language('company/warehouse/warehouse','tSalemachinePOS')?></label>
							<div class="input-group" >
								<input type="text" class="form-control xCNHide" id="oetWahPosCode" name="oetWahPosCode" maxlength="5" value="<?php echo @$tPosCode?>">
								<input type="text" class="form-control xWPointerEventNone" id="oetWahPosName" name="oetWahPosName" maxlength="100" value="<?php echo @$tPosComName?>" readonly>
								<span class="input-group-btn">
									<button id="oimBrowsePOS" type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
									</button>
								</span>
							</div>
						</div> -->
					</div>
			</div>
		</div>
</form>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jWarehouseAdd.php"; ?>




	
