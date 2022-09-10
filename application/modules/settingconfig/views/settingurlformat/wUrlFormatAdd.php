<?php
$tAngCodeHide = $this->session->userdata('tSesUsrAgnCode');
$tAngName = $this->session->userdata('tSesUsrAgnName');
if(isset($raResult['rtCode']) && $raResult['rtCode'] == 1){
		$tRoute				= 'urlEventEdit';	
		$tFspCode			= $raResult['raItems']['rtFspCode'];
		$tAngName 			= $raResult['raItems']['rtAngName'];
		$tAngCode			= $raResult['raItems']['rtAngCode'];
		$tBchName			= $raResult['raItems']['rtBchName'];
		$tBchCode 			= $raResult['raItems']['rtBchCode'];
		$tUrlFormatName		= $raResult['raItems']['rtFmtName'];
		$tUrlFormatCode 	= $raResult['raItems']['rtFmtCode'];
		$tUrlStaActive		= $raResult['raItems']['rtStaUse'];	
	}else{
		$tRoute				= 'urlEventAdd';
		$tBchName 			= "";
		$tBchCode       	= "";
		$tUrlStaActive		= "2";
		$tUrlFormatName		= "";
		$tUrlFormatCode		= "";
		$tFspCode			= "";
		if(!empty($tAngCodeHide) && !empty($tAngName) ){
			$tAngCode			= $this->session->userdata('tSesUsrAgnCode');
			$tAngName 			= $this->session->userdata('tSesUsrAgnName');
		}else{
			$tAngCode			= '';
			$tAngName 			= 'ตัวแทนขาย';
		}
		
	}
?>
<div id="odvBranchPanelBody" class="panel-body" style="padding-top:10px !important;">
<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div id="odvUrlContentDataTab" class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
					<div class="tab-content">
						<!-- Tab Info Data Branch -->
						<div id="odvUrlDataInfo" class="tab-pane active" style="margin-top:10px;" role="tabpanel" aria-expanded="true">
							<div class="row" style="margin-right:-30px; margin-left:-30px;">
								<div class="main-content" style="padding-bottom:0px !important;">
									<form id="ofmAddUrl" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
										<input type="hidden" id="ohmUrlStaActive" value="<?php echo @$tUrlStaActive; ?>">
										<input type="hidden" id="ohdBchRouteData" name="ohdBchRouteData" value="<?php echo $tRoute;?>">
										<button type="submit" id="obtSubmitUrl" class="btn xCNHide" onclick="JSnAddEditUrl('<?php echo @$tRoute?>');">
										</button>
										<div class="row">											
											<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

											<div class="row">
												   <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
												   <div class="form-group">
															<label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('settingconfig/settingurlformat/settingurlformat','tUrlFormatTitleCode');?></label>
															<div id="odvUrlAutoGenCode" class="form-group">
																<div class="validate-input">
																	<label class="fancy-checkbox">
																		<input type="checkbox" id="ocbUrlAutoGenCode" name="ocbUrlAutoGenCode" checked="true" value="1">
																		<span> <?php echo language('common/main/main','tGenerateAuto');?></span>
																	</label>
																</div>
															</div>
															<div id="odvUrlCodeForm" class="form-group">
																<input type="hidden" id="ohdCheckDuplicateUrlCode" name="ohdCheckDuplicateUrlCode" value="1">
																<div class="validate-input">
																	<input 
																		type="text" 
																		class="form-control xCNGenarateCodeTextInputValidate" 
																		maxlength="5" 
																		id="oetUrlCode" 
																		name="oetUrlCode"
																		value="<?php echo $tFspCode;?>"
																		data-is-created="<?php echo $tFspCode;?>"
																		autocomplete="off"
																		placeholder="<?php echo language('settingconfig/settingurlformat/settingurlformat','tUrlFormatTitleCode');?>"
																		data-validate-required="<?php echo language('company/branch/branch','tSHPValiBranchCode');?>"
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
															<label class="xCNLabelFrm"><?php echo language('settingconfig/settingurlformat/settingurlformat','tAngName');?></label>
															<div class="input-group">
																<input type="hidden" id="oetAngCode" value="<?php echo @$tAngCodeHide; ?>">
																<input type="text" class="form-control xCNHide" id="oetBchAgnCode" name="oetBchAgnCode" value="<?php echo @$tAngCode; ?>">
																<input type="text" class="form-control xWPointerEventNone" id="oetBchAgnName" name="oetBchAgnName" value="<?php echo @$tAngName; ?>" readonly>
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
															<label class="xCNLabelFrm"><?php echo language('settingconfig/settingurlformat/settingurlformat','tBchName');?></label>
															<div class="input-group">
																<input type="text" class="form-control xCNHide" id="oetBchCode" name="oetBchCode" value="<?php echo @$tBchCode; ?>" >
																<input type="text" class="form-control xWPointerEventNone" id="oetBchName" name="oetBchName" placeholder="เลือกสาขา" value="<?php echo @$tBchName; ?>" readonly>
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
															<label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('settingconfig/settingurlformat/settingurlformat','tFormatName');?></label>
															<div class="input-group">
																<input type="text" class="form-control xCNHide" id="oetUrlFormatCode" name="oetUrlFormatCode" value="<?php echo @$tUrlFormatCode; ?>">
																<input type="text" class="form-control xWPointerEventNone" id="oetUrlFormatName" name="oetUrlFormatName" placeholder="รายละเอียด" value="<?php echo @$tUrlFormatName; ?>" readonly data-validate-required="<?php echo language('settingconfig/settingurlformat/settingurlformat','tUrlApiValidate');?>">
																<span class="input-group-btn">
																	<button id="oimBrowseUrl" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
																</span>
															</div>
														</div>
													</div>
												</div>


												
												<div class="row">
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm"><?php echo language('company/country/country','tCountryStaUse')?> </label>
																<select class="form-control" id="ocmUrlStaActive" name="ocmUrlStaActive" value="<?php echo @$tUrlStaActive; ?>">
																	<option value="1"<?php echo (@$tUrlStaActive == 1)? " selected" : "";?>>
																	<?php echo language('company/country/country','tCountryUse')?></option>
																	<option value="2"<?php echo (@$tUrlStaActive == 2)? " selected" : "";?>>
																	<?php echo language('company/country/country','tCountryNotUse')?></option>
																</select>														
														</div>
													</div>	
												</div>
												
													<div class="modal fade" id="odvModalUrlStaUse">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header xCNModalHead">
															<label class="xCNTextModalHeard"><?php echo language('settingconfig/settingurlformat/settingurlformat','tCheckTitle');?></label>
														</div>
														<div class="modal-body">
															<span><?php echo language('settingconfig/settingurlformat/settingurlformat','tCheckSta');?> </span>
															<span id="osphaha">  </span><br>
															<span><?php echo language('settingconfig/settingurlformat/settingurlformat','tCheckNext');?></span>
															<input type='hidden' id="ohdConfirmIDDelete">
														</div>
														<div class="modal-footer">
															<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSnAddUrl('<?php echo @$tRoute?>');">
																<?=language('common/main/main', 'tModalConfirm')?>
															</button>
															<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
																<?=language('common/main/main', 'tModalCancel')?>
															</button>
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
<?php include "script/jUrlFormatAdd.php";?>