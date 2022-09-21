<?php
 if(@$nResult['rtCode'] == '1'){
  //Success
  $tSessAgnCode 	= $this->session->userdata("tSesUsrAgnCode");

  //Table Master
	$tZneCode       	= $nResult['roItem']['rtZneCode'];
	$nZneLevel      	= $nResult['roItem']['rnZneLevel'];
	$tZneParent     	= $nResult['roItem']['rtZneParent'];
	$tZneChain      	= $nResult['roItem']['rtZneChain'];
	$tAreCode      		= $nResult['roItem']['rtAreCode'];
	$tAreName       	= $nResult['roItem']['rtAreName'];  
	$tZneName       	= $nResult['roItem']['rtZneName'];
	$tZneParentName 	= $nResult['roItem']['rtZneParentName'];
	$tZneChainName  	= $nResult['roItem']['rtZneChainName'];
	$tZneRmk  			= $nResult['roItem']['rtZneRemark'];
	$tZneAgnCode  		= $nResult['roItem']['rtAgnCode'];
	$tZneAgnName  		= $nResult['roItem']['rtAgnName'];
	$tMenuTabDisable    = "";
	$tMenuTabToggle     = "tab";
	$tRoute 			= 'zoneEventEdit'; //Route ควบคุมการทำงาน Edit
	//Event Control
	if(isset($aAlwEventZone)){
		if($aAlwEventZone['tAutStaFull'] == 1 || $aAlwEventZone['tAutStaEdit'] == 1 && !$tSessAgnCode){
			$nAutStaEdit = 1;
		}elseif($tZneAgnCode == $tSessAgnCode){
			$nAutStaEdit = 1;
		}else{
			$nAutStaEdit = 0;
		}
	}else{
		$nAutStaEdit = 0;
	}
 }else{
	$nAutStaEdit = 0;
	$tZneCode       	= "";
	$nZneLevel      	= "";
	$tZneParent     	= "";
	$tZneChain      	= "";
	$tAreCode      		= "";
	$tAreName       	= "";
	$tZneName       	= "";
	$tZneParentName 	= "";
	$tZneChainName  	= "";
	$tZneRmk  			= "";
	$tRoute 			= 'zoneEventAdd'; //Route ควบคุมการทำงาน Add
	$tMenuTabDisable    = "disabled xWCloseTab";
	$tMenuTabToggle     = "false";
 }
?>
<input type="hidden" id="ohdRteAutStaEdit" value="<?php echo $nAutStaEdit?>">

<input type="text" class="xCNHide" id="ohdZneParent" value="<?php echo @$tZneParent?>">
<div class="panel-body">	
	<!-- Nav Tab Add Product -->
	<div id="odvPdtRowNavMenu" class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="custom-tabs-line tabs-line-bottom left-aligned">
				<ul class="nav" role="tablist">
					<li id="oliZneDataAddInfo1" class="xWMenu active" data-menutype="MN">
						<a role="tab" data-toggle="tab" data-target="#odvZneContentInfo" aria-expanded="true"><?php echo language('address/zone/zone','tZneTitle')?></a>
					</li>
				
					<li id="oliZneDataAddSet" class="xWMenu xWSubTab <?php echo $tMenuTabDisable;?>" data-menutype="SET">
						<a role="tab" data-toggle="<?php echo $tMenuTabToggle;?>" data-target="#odvZneContentSet" aria-expanded="false"><?php echo language('address/zone/zone','tZneRefer')?></a>
					</li>

				</ul>
			</div>
		</div>
	</div>
		
<div id="odvPdtRowContentMenu" class="row">		
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
		<div class="tab-content">
			<!-- Tab Content Detail  1-->
			<div id="odvZneContentInfo" class="tab-pane fade active in">
				<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddZone">
				<button style="display:none" type="submit" id="obtSubmitZne" onclick="JSnAddEditZone('<?php echo $tRoute?>');" class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNHide" ></button>	
					<div class="row">
						<div class="tab-content">
							<div class="col-md-12 xCNDivOverFlow">
									<div class="row">
										<div class="col-xs-12 col-md-5 col-lg-5">
											<div class="form-group">
												<div class="validate-input">
													<label class="fancy-checkbox">
														<input class="ocbListItem"  id="ocbSelectRoot"  name="ocbSelectRoot" type="checkbox">
															<span class="xCNLabelFrm"> &nbsp; <?php echo language('address/zone/zone','tZNEFirstlevel')?></span>
													</label>
												</div>		
											</div>
										</div>
									</div>
									
									<div class="row xWPanalZneChain">
										<div class="col-xs-12 col-md-5 col-lg-5">
											<div class="form-group">
												<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/zone/zone','tZNEChooseZone')?></label>
												<div class="input-group">
													<input type="text" class="xCNHide"  id="oetZneChainOld" name="oetZneChainOld" value="<?php echo @$tZneChain?>" >
													<input type="text" class="xCNHide"  id="oetZneParentNameOld" name="oetZneParentNameOld" placeholder="<?php echo language('address/zone/zone','tZNEChooseZone')?>" value="<?php echo @$tZneChainName?>">
													<input type="text" class="form-control xCNHide" id="oetZneParent" name="oetZneParent" value="<?php echo @$tZneParent?>">
													<input type="text" class="form-control xWPointerEventNone" id="oetZneParentName" name="oetZneParentName" maxlength="100" placeholder="<?php if(@$tZneChainName != ''){ echo @$tZneChainName; }else{echo language('address/zone/zone','tZneValiZone'); } ?>"  value="<?php echo @$tZneChainName ?>" readonly  data-validate="<?php echo language('address/zone/zone','tZneValiZone')?>">
													<span class="input-group-btn">
														<button id="oimBrowseZneParent" type="button" class="btn xCNBtnBrowseAddOn">
															<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
														</button>
													</span>
												</div>
											</div>
										</div>
									</div>

									<!-- <div class="row">
										<div class="col-xs-12 col-md-5 col-lg-5">
											<div class="form-group">
												<label class="xCNLabelFrm"><?php echo language('address/area/area','tARETitle')?></label>
												<div class="input-group">
													<input type="text" class="form-control xCNHide" id="oetAreCode" name="oetAreCode" maxlength="5" value="<?php echo @$tAreCode?>">
													<input type="text" class="form-control xWPointerEventNone" id="oetAreName" name="oetAreName" maxlength="100" placeholder="#####" value="<?php echo @$tAreName?>" readonly>
													<span class="input-group-btn">
														<button id="oimBrowseArea" type="button" class="btn xCNBtnBrowseAddOn">
															<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
														</button>
													</span>
												</div>
											</div>
										</div>
									</div> -->

									
									<div class="row">
										<div class="col-xs-12 col-md-5 col-lg-5">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo  language('address/zone/zone','tZNECode')?><?php echo  language('address/zone/zone','tZNETitle')?></label>
															<div id="odvZneAutoGenCode" class="form-group">
																<div class="validate-input">
																<label class="fancy-checkbox">
																<input type="checkbox" id="ocbZoneAutoGenCode" name="ocbZoneAutoGenCode" checked="true" value="1">
																<span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
															</label>
														</div>
													</div>
														<div id="odvZneCodeForm" class="form-group">
															<input type="hidden" id="ohdCheckDuplicateZneCode" name="ohdCheckDuplicateZneCode" value="1"> 
																<div class="validate-input">
																	<input 
																	type="text" 
																	class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote\" 
																	maxlength="5" 
																	id="oetZneCode" 
																	name="oetZneCode"
																	value="<?php echo $tZneCode ?>"
																	data-is-created="<?php echo $tZneCode ?>"
																	placeholder="<?= language('address/zone/zone','tZNEZCode')?>"
																	data-validate-required = "<?= language('address/zone/zone','tZneValiBranchCode')?>"
																	data-validate-dublicateCode = "<?= language('address/zone/zone','tZneValidCodeDup')?>"
																	>
																</div>
															</div>
														</div>

												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-12 col-md-5 col-lg-5">
											<div class="form-group">
												<div class="validate-input" data-validate="Please Enter">
													<label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo  language('address/zone/zone','tZNEName')?></label>
													<input class="xCNHide" type="text" id="oetZneNameOldTab1" name="oetZneNameOldTab1" value="<?php echo @$tZneName?>"
													data-validate-required = "<?php echo language('address/zone/zone','tZneValiZoneName')?>" 
													 >
													<input class="form-control" maxlength="100" type="text" id="oetZneNameTab1" name="oetZneNameTab1" maxlength="100" value="<?php echo @$tZneName?>"
													data-validate-required = "<?php echo language('address/zone/zone','tZneValiZoneName')?>"
													placeholder="<?php echo  language('address/zone/zone','tZNEName')?>" 
													autocomplete="off"
													 >
													<span class="focus-"></span>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-12 col-md-5 col-lg-5">
											<div class="form-group" >
											<label class="xCNLabelFrm"><?php echo language('address/zone/zone','tZneSltAgency');?></label>
												<div class="input-group" >
													<input type="text" class="form-control xCNHide" id="oetZneAgnCodeFirst" name="oetZneAgnCodeFirst" maxlength="5" value="<?php echo @$tZneAgnCode?>">
													<input type="text" class="form-control xWPointerEventNone" id="oetZneAgnNameFirst" name="oetZneAgnNameFirst"  
													placeholder="<?php echo language('address/zone/zone','tZneSltAgency');?>" value="<?php echo @$tZneAgnName?>" readonly>
													<span class="input-group-btn">
														<button id="obtBrowseAgencyFirst" type="button" class="btn xCNBtnBrowseAddOn">
															<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
														</button>
													</span>
												</div>
											</div>
										</div>
									</div>
									
								<div class="row">
									<div class="col-xs-12 col-md-5 col-lg-5">
										<div class="form-group">
											<label class="xCNLabelFrm"><?php echo language('address/zone/zone','tZneRemark')?></label>
											<textarea class="form-control xCNInputWithoutSpc" maxlength="100" rows="4" id="oetZneRemark" name="oetZneRemark"><?php echo @$tZneRmk; ?></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>
				</form>
			</div>


			<!-- Tab Content Detail  2 -->
					<div id="odvZneContentSet" class="tab-pane fade">
						<div class="panel-heading">
							
						<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddReferzone">

							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="margin-bottom:10px;">
									<label id="olbZneSetInfo" class="xCNLabelFrm xCNLinkClick"><?= language('address/zone/zone', 'tZneRefer') ?></label>
									<label id="olbZneSetAdd" class="xCNLabelFrm xCNHide"> / <?= language('common/main/main', 'tAdd') ?></label>
									<label id="olbZneSetEdit" class="xCNLabelFrm xCNHide"> / <?= language('common/main/main', 'tEdit') ?></label>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right" style="margin-bottom:10px;">
									<button id="obtZneSetAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
									<button id="obtZneSetBack" class="btn xCNHide" type="button" style="background-color: #D4D4D4; color: #000000;"><?= language('common/main/main', 'tCancel') ?></button>
									<button id="obtZneSetSave" class="btn xCNHide" type="submit" onclick="JSnAddReferZone()" style="background-color: rgb(23, 155, 253); color: white;"><?= language('common/main/main', 'tSave') ?></button>
								</div>
							</div>
							<div id="odvZneSetTable" class="row">
								<!-- DataTable Product Set -->
								<div id="odvZneSetDataTable"></div>
								<!-- End DataTable Product Set -->
							</div>

						</form>

				        <script type="text/javascript">
							  window.onload = JSvZoneObjDataTable();
						</script>
					<div class="panel-body">
						<div id="odvContentZoneObjData"></div>
					</div>
						</tbody>
					</table>
				</div>
			<!-- Tab Content Detail  2 -->

			</div>
		</div>
	</div>
</div>

<!-- div Dropdownbox -->
<div id="dropDownSelect1"></div>

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
<?php include "script/jZoneAdd.php"; ?>






	
