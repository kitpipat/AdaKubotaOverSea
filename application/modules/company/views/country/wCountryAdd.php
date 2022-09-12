<?php
if(isset($raResult['rtCode']) && $raResult['rtCode'] == 1){
		$tRoute				= 'countryEventEdit';	
		$tCtyLangName		= $raResult['raItems']['rtLangName'];
		$tCtyName			= $raResult['raItems']['rtCtyName'];
		$tCtyCode			= $raResult['raItems']['rtCtyCode'];
		$tCtyLangID 		= $raResult['raItems']['rtCtyLangID'];
		$tCtyStaActive		= $raResult['raItems']['rtCtyStaUse'];
		$tExcRte			= $raResult['raItems']['reCtyStaCtrlRate'];
		$tVatCode			= $raResult['raItems']['rtCtyVatCode'];
		$tVatRate 			= $raResult['raItems']['rtCtyVatRate'];
		$tCtyLa				= $raResult['raItems']['rtCtyLatitude'];
		$tCtyLon 			= $raResult['raItems']['rtCtyLongitude'];
		$tRteName			= $raResult['raItems']['rtRteIsoName'];
		$tRteCode			= $raResult['raItems']['rtIsoCode'];
		$tCtyRef			= $raResult['raItems']['rtCtyRefID'];
	}else{
		$tRoute				= 'countryEventAdd';
		$tCtyLangName 		= 'ภาษา';
		$tCtyName			= '';
		$tCtyRef			= '';
		$tCtyCode			= '';
		$tCtyLangID 		= '1';
		$tCtyStaActive		= '1';
		$tExcRte			= '2';
		$tVatCode			= '';
		$tVatRate 			= '';
		$tCtyLa				= '';
		$tCtyLon 			= '';
		$tRteName			= '';
		$tRteCode			= '';
	}
	$nDecimalShow = FCNxHGetOptionDecimalShow()
?>
<div id="odvBranchPanelBody" class="panel-body" style="padding-top:10px !important;">
<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">			
			<div id="odvCtyContentDataTab" class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
					<div class="tab-content">
						<!-- Tab Info Data Branch -->
						<div id="odvCtyDataInfo" class="tab-pane active" style="margin-top:10px;" role="tabpanel" aria-expanded="true">
							<div class="row" style="margin-right:-30px; margin-left:-30px;">
								<div class="main-content" style="padding-bottom:0px !important;">
									<form id="ofmAddCountry" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
										<input type="hidden" id="ohdCtyStaRate" value="<?php echo @$tExcRte?>">
										<input type="hidden" id="ohmCtyStaActive" value="<?php echo @$tCtyStaActive; ?>">
										<input type="hidden" id="ohdBchRouteData" name="ohdBchRouteData" value="<?php echo $tRoute;?>">
										<button type="submit" id="obtSubmitCty" class="btn xCNHide" onclick="JSnAddEditCountry('<?php echo @$tRoute?>');">
										</button>
										<div class="row">											
											<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
												<div class="row">
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
													<div class="form-group">
															<label class="xCNLabelFrm">
															<span class="text-danger">*</span> <?php echo language('company/country/country','tCountryCode')?> 
															</label>
															<div id="odvUrlAutoGenCode" class="form-group">
																<div class="validate-input">
																	<label class="fancy-checkbox">
																		<input type="checkbox" id="ocbCtyAutoGenCode" name="ocbCtyAutoGenCode" checked="true" value="1">
																		<span> <?php echo language('common/main/main','tGenerateAuto');?></span>
																	</label>
																</div>
															</div>
															<div id="odvCtyCodeForm" class="form-group">
																<input type="hidden" id="ohdCheckDuplicateCtyCode" name="ohdCheckDuplicateCtyCode" value="1">
																<div class="validate-input">
																	<input 
																		type="text" 
																		class="form-control xCNGenarateCodeTextInputValidate" 
																		maxlength="5" 
																		id="oetCtyCode" 
																		name="oetCtyCode"
																		value="<?php echo @$tCtyCode; ?>"
																		data-is-created="<?php echo @$tCtyCode; ?>"
																		autocomplete="off"
																		placeholder="<?php echo language('company/country/country','tCountryCode')?>" 
																		data-validate-required="<?php echo language('company/country/country','tCountryCodeValidate')?>" 
																		data-validate-dublicateCode="<?php echo language('company/branch/branch','tSHPValidCheckCode');?>"
																	>
																</div>
															</div>											
														</div>
													</div>
												</div>

												<div class="row">
												   <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm">
																<span class="text-danger">*</span> <?php echo language('company/country/country','tCountryName')?> </label>
															<input type="text" class="form-control" maxlength="50" id="oetCtyName" name="oetCtyName" autocomplete="off" placeholder="<?php echo language('company/country/country','tCountryName')?>" data-validate-required="<?php echo language('company/country/country','tCountryNameValidate')?>" value="<?php echo @$tCtyName; ?>">
														</div>
													</div>
												</div>

												
												<div class="row">
												   <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm">
																<span class="text-danger">*</span> <?php echo language('company/country/country','tCountryRef')?> </label>
															<input type="text" class="form-control" maxlength="5" id="oetCtyRef" name="oetCtyRef" autocomplete="off" placeholder="<?php echo language('company/country/country','tCountryRef')?>" data-validate-required="<?php echo language('company/country/country','tCountryRefValidate')?>" value="<?php echo @$tCtyRef; ?>">
														</div>
													</div>
												</div>


												<div class="row">
												   <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm"><?php echo language('company/country/country','tCountryLang')?></label>
															<div class="input-group">
																<input type="text" class="form-control xCNHide" id="oetCtyLangID" name="oetCtyLangID" value="<?php echo @$tCtyLangID; ?>">
																<input type="text" class="form-control xWPointerEventNone" id="oetCtyLangName" name="oetCtyLangName" value="<?php echo @$tCtyLangName; ?>" readonly>
																<span class="input-group-btn">
																	<button id="oimBchBrowseLang" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
																</span>
															</div>
														</div>
													</div>
												</div>

												<div class="row">
												   <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm"><?php echo language('company/country/country','tCountryVat')?></label>
															<div class="input-group">
																<input type="text" class="form-control xCNHide" id="oetVatCode" name="oetVatCode" value="<?php echo @$tVatCode; ?>">
																<input type="text" class="form-control xWPointerEventNone" placeholder="อัตราภาษี" id="oetVatRate" name="oetVatRate" value="<?=@number_format(@$tVatRate,$nDecimalShow) ?>" readonly data-validate-required="<?php echo language('company/country/country','tCountryVatValidate')?>">
																<span class="input-group-btn">
																	<button id="oimBchBrowseVat" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
																</span>
															</div>
														</div>
													</div>
												</div>

												<div class="row">
												   <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm"><?php echo language('company/country/country','tCountryIso')?></label>
															<div class="input-group">
																<input type="text" class="form-control xCNHide" id="oetRteCode" name="oetRteCode" value="<?php echo @$tRteCode; ?>">
																<input type="text" class="form-control xWPointerEventNone" placeholder="สกุลเงินสากล" id="oetRteName" name="oetRteName" value="<?php echo @$tRteName; ?>" readonly data-validate-required="<?php echo language('company/country/country','tCountryIsoValidate')?>">
																<span class="input-group-btn">
																	<button id="oimBchBrowseRte" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
																</span>
															</div>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm"><?php echo language('company/country/country','tCountryExCtrl')?></label>
																<select class="form-control" id="ocmExcRte" name="ocmExcRte" value="<?php echo @$tExcRte; ?>">
																	<option value="1"<?php echo (@$tExcRte == 1)? " selected" : "";?>>
																	<?php echo language('company/country/country','tCountryAllow')?>
																	</option>
																	<option value="2"<?php echo (@$tExcRte == 2)? " selected" : "";?>>
																	<?php echo language('company/country/country','tCountryNotAllow')?>
																	</option>
																</select>														
														</div>
													</div>	
												</div>																					

												<div class="row">
												   <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
														<div class="form-group">
															<label class="xCNLabelFrm">
																<?php echo language('company/country/country','tCountryla')?> </label>
															<input 
															type="text" 
															class="form-control" 
															id="oetCtyLa" 
															name="oetCtyLa" 
															autocomplete="off" 
															maxlength="50"
															oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
															placeholder="<?php echo language('company/country/country','tCountryla')?>" 
															value="<?php echo @$tCtyLa; ?>">
														</div>
													</div>

													<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
														<div class="form-group">
															<label class="xCNLabelFrm">
																<?php echo language('company/country/country','tCountrylon')?> </label>
															<input 
															type="text" 
															class="form-control" 
															id="oetCtyLon" 
															name="oetCtyLon" 
															autocomplete="off" 
															maxlength="50"
															oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
															placeholder="<?php echo language('company/country/country','tCountrylon')?>" 
															value="<?php echo @$tCtyLon; ?>">
														</div>
													</div>
												</div>

												<!-- <div class="row">
												   <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm">
																<?php echo language('company/country/country','tCountrylon')?> </label>
															<input 
															type="text" 
															class="form-control" 
															id="oetCtyLon" 
															name="oetCtyLon" 
															autocomplete="off" 
															maxlength="50"
															oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
															placeholder="<?php echo language('company/country/country','tCountrylon')?>" 
															value="<?php echo @$tCtyLon; ?>">
														</div>
													</div>
												</div>
												 -->
												<div class="row">
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm"><?php echo language('company/country/country','tCountryStaUse')?> </label>
																<select class="form-control" id="ocmCtyStaActive" name="ocmCtyStaActive" value="<?php echo @$tCtyStaActive; ?>">
																	<option value="1"<?php echo (@$tCtyStaActive == 1)? " selected" : "";?>>
																	<?php echo language('company/country/country','tCountryUse')?></option>
																	<option value="2"<?php echo (@$tCtyStaActive == 2)? " selected" : "";?>>
																	<?php echo language('company/country/country','tCountryNotUse')?></option>
																</select>														
														</div>
													</div>	
												</div>

											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> 
<?php include "script/jCountryAdd.php";?>