<?php
//เซตค่าเวลาปัจจุบัน+1ปี
$dDateAddYear  = date('Y-m-d',strtotime("+1 year"));
if($aResult['rtCode'] == "1"){
	$tXthDocNo 				= $aResult['raItems']['FTXphDocNo'];
	$dXthDocDate 			= $aResult['raItems']['FDXphDocDate'];
	$tXthDocTime 			= $aResult['raItems']['FTXphDocTime'];
	$tCreateBy 				= $aResult['raItems']['FTCreateBy'];
	$tFTXphStaDoc 			= $aResult['raItems']['FTXphStaDoc'];
	$tXthStaApv 			= $aResult['raItems']['FTXphStaApv'];
	$tXthApvCode 			= $aResult['raItems']['FTXphUsrApv'];
	$tXthStaPrcStk 			= $aResult['raItems']['FTXphStaPrcDoc'];
	$tXthStaDelMQ 			= $aResult['raItems']['FTXphStaDelMQ'];
	// $tShpCode 				= $aResult['raItems']['FTShpCode'];
	// $tShpName 				= $aResult['raItems']['FTShpName'];
	$tCompCode = $tCompCode;
	$tBchCode 				= $aResult['raItems']['FTXphBchTo'];
	$tBchName 				= $aResult['raItems']['FTBchName'];
	$tMchCode					=	$aResult['raItems']['FTMerCode'];
	$tMchName 				=	$aResult['raItems']['FTMerName'];
	$tShpCodeStart 				= $aResult['raItems']['FTXthShopFrm'];
	$tShpNameStart 				= $aResult['raItems']['FTShpNameFrm'];
	$tUserBchCode      =  $tUserBchCode;
	$tUserBchName      =  "";
	$tUserMchCode      =  $tUserMchCode;
	$tUserMchName      =  "";
	$tUserShpCode      =  $tUserShpCode;
	$tUserShpName      =  "";
	$tUserWahCode 		 = "";
	$tUserWahName 		 = "";
	// $tMchCode					=	$tMchCode;
	// $tMchName 				=	$tMchName;
	// $tShpCodeStart 				= $aResult['raItems']['FTShpCode'];
	// $tShpNameStart 				= $aResult['raItems']['FTShpName'];
	// $tWahCodeStart 			= $aResult['raItems']['FTXthWhFrm'];
	// $tWahNameStart 			= $aResult['raItems']['FTWahNameFrm'];
	// $tShpCodeEnd 				= $tShpCodeEnd;
	// $tShpNameEnd				= $tShpNameEnd;
	// $tWahCodeEnd 			 = $tWahCodeEnd;
	// $tWahNameEnd 			 = $tWahNameEnd;
	// $tWahCodeTo 	    = $aResult['raItems']['FTXthWhTo'];
	// $tWahNameTo 	    = $aResult['raItems']['FTWahNameTo'];
	$tXthRefInt 			= $aResult['raItems']['FTXphRefInt'];
	$dXthRefIntDate 			= $aResult['raItems']['FDXphRefIntDate'];
	
	$nXthStaDocAct 		= $aResult['raItems']['FNXphStaDocAct'];
	// $tSplCode 			= $aResult['raItems']['FTSplCode'];
	// $tSplName 			= $aResult['raItems']['FTSplName'];
	$tXthRmk 					= $aResult['raItems']['FTXphRmk'];
	// $nXthDocType 		= $aResult['raItems']['FNXthDocType'];
	// $tXthCshOrCrd 		= $aResult['raItems']['FTXthCshOrCrd'];
	$tDptCode 				= "";
	$tDptName 				= "";
	$tUsrCode 				= $this->session->userdata('tSesUsername');
	$tUsrNameCreateBy	= $aResult['raItems']['FTCreateBy'];
	$tXthUsrNameApv 	= $aResult['raItems']['FTUsrNameApv'];
	$cXthVat ="";
    $cXthVatable="";
    $tXthVATInOrEx="";
    $tXthCtrName="";
	//Event Control
	if(isset($aAlwEvent)){
		if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaEdit'] == 1){
			$nAutStaEdit = 1;
		}else{
			$nAutStaEdit = 0;
		}
	}else{
		$nAutStaEdit = 0;
	}
	$tFDXphDStart= $aResult['raItems']['FDXphDStart'];
	$tFDXphDStop= $aResult['raItems']['FDXphDStop'];
	$tFTXphTStart= $aResult['raItems']['FTXphTStart'];
	$tFTXphTStop= $aResult['raItems']['FTXphTStop'];
	$tFTXphDocType= $aResult['raItems']['FTXphDocType'];
	
	$tBchCompCode 				= $tBchCompCode;
	$tBchCompName 				= $tBchCompName;
	//Event Control
	$tRoute         	= "ADJPLEventEdit";	
}else{
	$tFTXphDocType = "";
	$tFDXphDStart= date("Y-m-d");
	$tFDXphDStop= date("Y-m-d",strtotime('+1 year'));
	$tFTXphTStart= date("H:i:s");
	$tFTXphTStop= date("H:i:s",strtotime('+1 hour'));
	$tXthDocNo 				= "";
	$dXthDocDate 			= "";
	$tXthDocTime 			= date("H:i:s");
	$tCreateBy 				= $this->session->userdata('tSesUsrUsername');
	$tFTXphStaDoc 			= "";
	$tXthStaApv 			= "";
	$tXthApvCode 			= "";
	$tXthStaPrcStk 		= "";
	$tXthStaDelMQ 		= "";
	$tCompCode = $tCompCode;
	$tBchCompCode 				= $tBchCompCode;
	$tBchCompName 				= $tBchCompName;
	$tUserBchCode      =  $tBchCode;
	$tUserBchName      =  $tBchName;
	$tUserMchCode      =  $tMchCode;
	$tUserMchName      =  $tMchName;
	$tUserShpCode      =  $tShpCodeStart;
	$tUserShpName      =  $tShpNameStart;
	$tUserShpType			 = 	$tShpTypeStart;
	$tPosCodeStart 				= "";
	$tPosNameStart 				= "";
	$tPosCodeEnd 				= "";
	$tPosNameEnd				= "";
	$tUserWahCode 		 = $tWahCodeStart;
	$tUserWahName 		 = $tWahNameStart;
	if($tBchCode!=""){
		$tBchCode 				= $tBchCode;
	}else{
		$tBchCode				= $tBchCompCode;
	}
	$tBchName 				= "";
	$tMchCode					=	"";
	$tMchName 				=	"";
	$tShpCodeStart 				= "";
	$tShpNameStart 				= "";
	$tShpCodeEnd 				= "";
	$tShpNameEnd				= "";
	$tWahCodeStart 			= "";
	$tWahNameStart 			= "";
	$tWahCodeEnd 			 = "";
	$tWahNameEnd 			 = "";
	$dXthRefExtDate 	= "";
	$tXthRefInt 			= "";
	$tXthCtrName		 	= "";
	$tXthRefTnfID			= "";
	$tViaCode					= "";
	$tViaName					= "";
	$tXthRefVehID 		= "";
	$tXthQtyAndTypeUnit	= "";
	$tXthShipAdd			= "";	
	$nXthStaDocAct 		= "";
	// $tSplCode 				= "";
	// $tSplName 				= "";
	$tXthRmk 					= "";
	// $nXthDocType 			= "";
	// $tXthCshOrCrd 		    = "";
	$tXthVATInOrEx 		= "";
	$tDptCode 				= $tDptCode; 
	$tDptName 				= $this->session->userdata("tSesUsrDptName"); 
	$tUsrCode 				= $this->session->userdata('tSesUsername');
	$tUsrNameCreateBy	= $this->session->userdata('tSesUsrUsername');
	$tXthUsrNameApv 	= "";
	$dXthRefIntDate 	= "";
	//$tVatCode 				= $tVatCode;
	// $cXthVATRate 			= $cVatRate;
	$cXthVat 					= "";
	$cXthVatable 			= "";
	//TAPTOrdHDSpl
	// $tXthTaxAdd			    = "";
	
	

	$tRoute         	    = "ADJPLEventAdd";
	$nAutStaEdit = 0; //Event Control
}
$tUserType = "";
if($tUserBchCode=='' && $tUserShpCode==''){
	$tUserType = "HQ";
}else{
	if($tUserBchCode!='' && $tUserShpCode==''){
		$tUserType = "BCH";
	}else if($tUserBchCode!='' && $tUserShpCode!=''){
		$tUserType = "SHP";
	}
}

?>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddTFW">
	<input type="hidden" id="ohdBaseUrl" name="ohdBaseUrl" value="<?php echo base_url(); ?>">
	<input type="hidden" id="ohdTFWAutStaEdit" name="ohdTFWAutStaEdit" value="<?php echo $nAutStaEdit; ?>">
	<input type="hidden" id="ohdXthStaApv" name="ohdXthStaApv" value="<?php echo $tXthStaApv; ?>">
	<input type="hidden" class="" id="ohdXthStaDoc" name="ohdXthStaDoc" value="<?php echo $tFTXphStaDoc; ?>">
	<input type="hidden" id="ohdXthStaPrcStk" name="ohdXthStaPrcStk" value="<?php echo $tXthStaPrcStk; ?>">
	<input type="hidden" id="ohdXthStaDelMQ" name="ohdXthStaDelMQ" value="<?php echo $tXthStaDelMQ; ?>">
	<input type="hidden" id="ohdTFWRoute" name="ohdTFWRoute" value="<?php echo $tRoute; ?>">
	<button style="display:none" type="submit" id="obtSubmitTFW" onclick="JSnAddEditTFW();"></button>
	<input type="text" class="xCNHide" id="ohdSesUsrBchCode" name="ohdSesUsrBchCode" value="<?php echo $this->session->userdata("tSesUsrBchCode"); ?>"> 
	<input type="text" class="xCNHide" id="ohdCompCode" name="ohdCompCode" value="<?php echo $tCompCode; ?>"> 
	<input type="text" class="xCNHide" id="ohdBchCode" name="ohdBchCode" value="<?php 
	if($tUserBchCode==""){
		echo $tBchCompCode;
	}else{
		echo $tUserBchCode; 
	}
	
	?>"> 
	<!-- เวลา+1ปี -->
	<input type="text" class="xCNHide" id="ohdDateAddYear" name="ohdDateAddYear" value="<?php echo $dDateAddYear?>">

	<input type="text" class="xCNHide" id="ohdOptAlwSavQty0" name="ohdOptAlwSavQty0" value="<?php echo $nOptDocSave?>">
	<input type="text" class="xCNHide" id="ohdOptScanSku" name="ohdOptScanSku" value="<?php echo $nOptScanSku?>">
	<input type="text" class="xCNHide" id="ohdDptCode" name="ohdDptCode" maxlength="5" value="<?php echo $tDptCode;?>">
	<input type="text" class="xCNHide" d="oetUsrCode" name="oetUsrCode" maxlength="20" value="<?php echo $tUsrCode?>">
	<input type="text" class="xCNHide" id="oetXthApvCodeUsrLogin" name="oetXthApvCodeUsrLogin" maxlength="20" value="<?php echo $this->session->userdata('tSesUsername'); ?>">
	<input type="text" class="xCNHide" id="ohdLangEdit" name="ohdLangEdit" maxlength="1" value="<?php echo $this->session->userdata("tLangEdit"); ?>">
	<input type="text" class="xCNHide" id="ohdStatusLoadPdtToTem" name="ohdStatusLoadPdtToTem" value="0">
	<input type="text" class="xCNHide" id="ohdCheckSetDataDTFromTmp" name="ohdCheckSetDataDTFromTmp" value="1">
	<input type="text" class="xCNHide" id="ohdCheckDataTimeHDDuplicate" name="ohdCheckDataTimeHDDuplicate" value="0">
	<input type="text" class="xCNHide" id="ohdUserType" name="ohdUserType" value="<?php echo $tUserType; ?>">
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default" style="margin-bottom: 25px;"> 
				<div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWStatus'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvDataPromotion" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDataPromotion" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<div class="form-group xCNHide" style="text-align: right;">
							<label class="xCNTitleFrom "><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWApproved'); ?></label>
						</div>
						<input type="hidden" value="0" id="ohdCheckTFWSubmitByButton" name="ohdCheckTFWSubmitByButton"> 
						<input type="hidden" value="0" id="ohdCheckTFWClearValidate" name="ohdCheckTFWClearValidate"> 
						<label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWDocNo'); ?></label>
						<?php
						if($tRoute=="ADJPLEventAdd"){
						?>
						<div class="form-group" id="odvPunAutoGenCode">
							<div class="validate-input">
								<label class="fancy-checkbox">
									<input type="checkbox" id="ocbTFWAutoGenCode" name="ocbTFWAutoGenCode" checked="true" value="1">
									<span> <?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWAutoGenCode'); ?></span>
								</label>
							</div>
						</div>
						<div class="form-group" id="odvPunCodeForm">
							<input 
									type="text" 
									class="form-control xCNInputWithoutSpcNotThai" 
									maxlength="20" 
									id="oetXthDocNo" 
									name="oetXthDocNo"
									data-is-created="<?php  ?>"
									placeholder="<?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWDocNo')?>"
									value="<?php  ?>" 
									data-validate-required="<?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWDocNoRequired')?>"
									data-validate-dublicateCode="<?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWDocNoDuplicate')?>"
									readonly
									onfocus="this.blur()">
							<input type="hidden" value="2" id="ohdCheckDuplicateTFW" name="ohdCheckDuplicateTFW"> 
						</div>
						<?php
						}else{
						?>
						<div class="form-group" id="odvPunCodeForm">
							<div class="validate-input">
								<input 
										type="text" 
										class="form-control xCNInputWithoutSpcNotThai" 
										maxlength="20" 
										id="oetXthDocNo" 
										name="oetXthDocNo"
										data-is-created="<?php  ?>"
										placeholder="<?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWDocNo')?>"
										value="<?php echo $tXthDocNo; ?>" 
										readonly
										onfocus="this.blur()">
							</div>
						</div>
						<?php
						}
						?>
						<div class="form-group">
							<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWDocDate'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXthDocDate" name="oetXthDocDate" value="<?php echo $dXthDocDate; ?>" data-validate-required="<?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWPlsEnterDocDate'); ?>">
								<span class="input-group-btn">
									<button id="obtXthDocDate" type="button" class="btn xCNBtnDateTime">
										<img src="<?= base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
									</button>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWDocTime'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNTimePicker" id="oetXthDocTime" name="oetXthDocTime" value="<?php echo $tXthDocTime; ?>" data-validate-required="<?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWPlsEnterDocTime'); ?>">
								<span class="input-group-btn">
									<button id="obtXthDocTime" type="button" class="btn xCNBtnDateTime">
										<img src="<?= base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
									</button>
								</span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWCreateBy'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<input type="text" class="xCNHide" id="oetCreateBy" name="oetCreateBy" value="<?php echo $tCreateBy?>">
								<label><?php echo $tUsrNameCreateBy?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWTBStaDoc'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWStaDoc'.$tFTXphStaDoc); ?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWTBStaApv'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWStaApv'.$tXthStaApv); ?></label>
							</div>
						</div>
						<?php 
						if($tXthDocNo != ''){
						?>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWApvBy'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<input type="text" class="xCNHide" id="oetXthApvCode" name="oetXthApvCode" maxlength="20" value="<?php echo $tXthApvCode?>">
								<label><?php echo $tXthUsrNameApv != '' ? $tXthUsrNameApv : language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWStaDoc'); ?></label>
							</div>
						</div>
						<?php 
						} 
						?>
					</div>
				</div>    
			</div>
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWTnfCondition'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvWarehouse" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvWarehouse" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<!-- สาขา -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWBranch');?></label>
							<div class="input-group">
								<input class="form-control xCNHide" id="oetBchCode" name="oetBchCode" maxlength="5" value="<?php
									if($tRoute=="ADJPLEventAdd"){
										if($tUserType != "HQ"){ 
											echo $tUserBchCode; 
										}else{
											if($tBchCompCode){
												echo $tBchCompCode;
											}
										}  
									}else{
										echo $tBchCode;
									}
								?>">
								<input data-validate-required="<?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWBranchRequired'); ?>" class="form-control xWPointerEventNone" type="text" id="oetBchName" name="oetBchName" value="<?php 
									if($tRoute=="ADJPLEventAdd"){
										if($tUserType != "HQ"){ 
											echo $tUserBchName; 
										}else{
											if($tBchCompName){
												echo $tBchCompName;
											}
										}  
									}else{
										echo $tBchName;
									}
								?>" readonly>
								<span class="xWConditionSearchPdt input-group-btn
								<?php 
									if($tUserType != "HQ"){ 
										echo "disabled"; 
									}else{
										if(!$tBchCompCode){
											echo "disabled"; 
										}
									}
								?>
								">
									<button id="obtTFWBrowseBch" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn
									<?php 
										if($tUserType != "HQ"){ 
											echo "disabled"; 
										}else{
											if(!$tBchCompCode){
												echo "disabled"; 
											}
										}
									?>
									">
										<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
									</button>
								</span>
							</div>
						</div>
						<!-- สาขา -->
						<!-- กลุ่มร้านค้า -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWShopGroup');?></label>
							<div class="input-group">
								<input class="form-control xCNHide" id="oetMchCode" name="oetMchCode" maxlength="5" value="<?php
									if($tRoute=="ADJPLEventAdd"){
										if($tUserType == "SHP"){ 
											echo $tUserMchCode; 
										} 
									}else{
										echo $tMchCode;
									}
								?>">
								<input data-validate-required="<?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWMerChantEndRequired'); ?>" class="form-control xWPointerEventNone" type="text" id="oetMchName" name="oetMchName" value="<?php 
									if($tRoute=="ADJPLEventAdd"){
										if($tUserType == "SHP"){ 
											echo $tUserMchName; 
										}  
									}else{
										echo $tMchName;
									}
								?>" readonly>
								<span class="xWConditionSearchPdt input-group-btn
								<?php 
									if($tUserType == "SHP"){ 
										echo "disabled"; 
									}else{
										if($tUserType == "HQ" && !$tBchCompCode){
											echo "disabled"; 
										}
									}
								?>
								">
									<button id="obtTFWBrowseMch" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn
									<?php 
										if($tUserType == "SHP"){ 
											echo "disabled"; 
										}else{
											if($tUserType == "HQ" && !$tBchCompCode){
												echo "disabled"; 
											}
										}
									?>
									">
										<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
									</button>
								</span>
							</div>
						</div>
						<!-- กลุ่มร้านค้า -->
						<!-- ร้านค้า -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWShop');?></label>
							<div class="input-group">
								<input class="form-control xCNHide" id="oetShpCodeStart" name="oetShpCodeStart" maxlength="5" value="<?php
									if($tRoute=="ADJPLEventAdd"){
										if($tUserType == "SHP"){ 
											echo $tUserShpCode; 
										} 
									}else{
										echo $tShpCodeStart;
									}
								?>">
								<input data-validate-required="<?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWShopRequired'); ?>" class="form-control xWPointerEventNone" type="text" id="oetShpNameStart" name="oetShpNameStart" value="<?php 
									if($tRoute=="ADJPLEventAdd"){
										if($tUserType == "SHP"){ 
											echo $tUserShpName; 
										}  
									}else{
										echo $tShpNameStart;
									}
								?>" readonly>
								<span class="xWConditionSearchPdt input-group-btn
								<?php 
									if($tRoute=="ADJPLEventAdd"){
											echo "disabled"; 
										
									}else{
										if($tUserType == "SHP"){ 
											echo "disabled"; 
										}else{
											if($tMchCode==""){
												echo "disabled"; 
											}
										} 
									}
								?>
								">
									<button id="obtTFWBrowseShpStart" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn
									<?php 
										if($tRoute=="ADJPLEventAdd"){
											echo "disabled"; 
										
										}else{
											if($tUserType == "SHP"){ 
												echo "disabled"; 
											}else{
												if($tMchCode==""){
													echo "disabled"; 
												}
											} 
										}
									?>
									">
										<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
									</button>
								</span>
							</div>
						</div>
						<!-- ร้านค้า -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWAdjPriceType'); ?></label>
							<div class="input-group" style="width:100%">
								<select class="form-control" id="ocmPriceType" name="ocmPriceType">
									<option value="1"
									<?php 
									if($tFTXphDocType==""){
										echo "selected";
									}else{
										if($tFTXphDocType==1){
											echo "selected";
										}
									}
									?>
									><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tNormalprice');?></option>
									<option value="2"
									<?php 
									
										if($tFTXphDocType==2){
											echo "selected";
										}
									
									?>
									><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tSpecialsalesprice');?></option>
								</select>
							</div>
						</div>
						<div class="row xCNMarginTop30px">
							<div class="col-md-6">
								<div class="form-group">
									<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWDocDateStart'); ?></label>
									<div class="input-group">
										<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXthDocDateStart" name="oetXthDocDateStart" value="<?php echo $tFDXphDStart; ?>" data-validate-required="<?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWPlsEnterXthDocDateStart'); ?>">
										<span class="input-group-btn">
											<button id="obtXthDocDateStart" type="button" class="btn xCNBtnDateTime">
												<img src="<?= base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
											</button>
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group" id="odvDocDateEnd">
									<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWDocDateEnd'); ?></label>
									<div class="input-group">
										<input type="hidden"  id="ohdCheckDateEnd" name="ohdCheckDateEnd">
										<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXthDocDateEnd" name="oetXthDocDateEnd" value="<?php echo $tFDXphDStop; ?>" data-validate-required="<?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWPlsEnterXthDocDateEnd'); ?>">
										<span class="input-group-btn">
											<button id="obtXthDocDateEnd" type="button" class="btn xCNBtnDateTime">
												<img src="<?= base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row xCNMarginTop30px">
							<div class="col-md-6">
								<div class="form-group">
									<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWDocTimeStart'); ?></label>
									<div class="input-group">
										<input type="text" class="form-control xCNTimePicker" id="oetXthDocTimeStart" name="oetXthDocTimeStart" value="<?php echo $tFTXphTStart; ?>" data-validate-required="<?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWPlsEnterXthDocTimeStart'); ?>">
										<span class="input-group-btn">
											<button id="obtXthDocTimeStrat" type="button" class="btn xCNBtnDateTime">
												<img src="<?= base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
											</button>
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWDocTimeEnd'); ?></label>
									<div class="input-group">
										<input type="text" class="form-control xCNTimePicker" id="oetXthDocTimeEnd" name="oetXthDocTimeEnd" value="<?php echo $tFTXphTStop; ?>" data-validate-required="<?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWPlsEnterXthDocTimeEnd'); ?>">
										<span class="input-group-btn">
											<button id="obtXthDocTimeEnd" type="button" class="btn xCNBtnDateTime">
												<img src="<?= base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row xCNMarginTop30px">
							<div class="col-md-6 btn-group xCNDropDrownGroup">
								<button type="button" id="obtTWXVDControlFormClear" class="btn xCNBTNMngTable
								
								
								" style="width:100%;font-size: 17px;"><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tClearData');?></button>
							</div>
							<div class="col-md-6">
								<button type="button" id="obtTWXVDControlForm" class="btn btn-primary
								
								
								" style="width:100%;font-size: 17px;"><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tImportData');?></button>
							</div>
						</div>
					</div> 
				</div> 
			</div>
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWReference'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataGeneralInfo" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDataGeneralInfo" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<!-- วันที่เอกสารภายใน -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWRefInt'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc" id="oetXthRefInt" name="oetXthRefInt" maxlength="20" value="<?php echo $tXthRefInt?>">
								</div>
							</div>
						</div>
						<!-- วันที่เอกสารภายใน -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWRefIntDate'); ?></label>
									<div class="input-group">
										<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXthRefIntDate" name="oetXthRefIntDate" value="<?php echo $dXthRefIntDate?>">
										<span class="input-group-btn">
											<button id="obtXthRefIntDate" type="button" class="btn xCNBtnDateTime">
												<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>    
			</div>
		</div>
		<div class="col-md-8" id="odvRightPanal">
		<!-- Suplier -->
		<!-- Suplier -->
		<!-- Pdt -->
			<div class="panel panel-default" style="margin-bottom: 25px;position: relative;min-height: 200px;"> 
				<div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
					<div class="panel-body xCNPDModlue">
						<div class="row" style="margin-top: 10px;">
							<!-- <div class="col-md-6">
								<div class="form-group">
									<div class="input-group">
										<input type="text" class="form-control" maxlength="100" id="oetSearchPdtHTML" name="oetSearchPdtHTML" onkeyup="JSvDOCSearchPdtHTML()" placeholder="<?php //echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWSearchPdt'); ?>">
										<input type="text" class="form-control" maxlength="100" id="oetScanPdtHTML" name="oetScanPdtHTML" onkeyup="Javascript:if(event.keyCode==13) JSvTFWScanPdtHTML()" placeholder="<?php //echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWScanPdt'); ?>" style="display:none;" data-validate="ไม่พบข้อมูลที่แสกน">
										<span class="input-group-btn">
											<div id="odvMngTableList" class="xCNDropDrownGroup input-group-append">
												<button id="oimMngPdtIconSearch" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" onclick="JSvDOCSearchPdtHTML()">
													<img  src="<?php //echo  base_url().'application/modules/common/assets/images/icons/search-24.png'?>" style="width:20px;">
												</button>
												<button id="oimMngPdtIconScan" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" style="display:none;" onclick="JSvTFWScanPdtHTML()">
													<img class="oimMngPdtIconScan" src="<?php //echo  base_url().'application/modules/common/assets/images/icons/scanner.png'?>" style="width:20px;">
												</button>
												<button type="button" class="btn xCNDocDrpDwn xCNBtnDocSchAndScan" data-toggle="dropdown">
													<i class="fa fa-chevron-down f-s-14 t-plus-1" style="font-size: 12px;"></i>
												</button>
												<ul class="dropdown-menu" role="menu">
													<li>
														<a id="oliMngPdtSearch"><label><?php //echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWSearchPdt'); ?></label></a>
														<a id="oliMngPdtScan"><?php //echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker', 'tTFWScanPdt'); ?></a>
													</li>
												</ul>
											</div>
										</span>
									</div>
								</div>
							</div> -->
							<!-- <div class="col-md-6">
								<div class="btn-group xCNDropDrownGroup right">
									<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
										<?php // echo language('common/main/main','tCMNOption')?>
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li id="oliBtnDeleteAll" class="disabled">
											<a data-toggle="modal" data-target="#odvModalDelPdtTFW"><?php //echo language('common/main/main','tDelAll')?></a>
										</li>
									</ul>
								</div>
							</div> -->
						</div>
						<div id="odvPdtTablePanal">
						</div>
						<div id="odvPdtTablePanalDataHide">
						</div>
					</div>
				</div>
			</div>
			








			<!-- <div class="row">
				<div class="col-lg-7">
					<div class="col-md-12 panel panel-default" style="background: white;height: 180px;">
						<div class="row" style="background: #eeeeee;">					
							<div class="col-md-12">
								<label class="xCNLabelFrm" id="othFCXthGrandText" style="margin:5px 0 5px;">-</label>
							</div>
						</div>
						<div class="row" id="odvVatPanal">				
							<div class="table-responsive" style="height: 100px;overflow-y: scroll;">
								<table class="table xWPdtTableFont">
									<tbody>
										<tr>
											<td class="text-left xCNTextDetail2">
												<span id="othFCXthGrandText">-</span>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row" style="background: #eeeeee; padding-top: 6px; padding-bottom: 6px;">					
							<div class="col-md-12">
								<div class="row">
									<div class="col-lg-6">
										<label class="xCNLabelFrm">ยอดรวมภาษี</label>
									</div>
									<div class="col-lg-6 text-right">
										<label class="xCNLabelFrm" id="olaSumXtdVat">-</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-5">
					<div class="col-md-12 panel panel-default" style="background: white;height: 180px;">
						<div class="col-md-12" style="padding:15px;">
							<div class="col-lg-6 text-center">
								<label class="xCNLabelFrm"><?php //echo language('document/transferreceipt/transferreceipt', 'tTWITotalCash'); ?></label>
							</div>
							<div class="col-lg-6 text-center">
								<label class="xCNLabelFrm" id="othFCXthTotal">-</label>
							</div>
						</div>
						<div class="col-md-12" style="padding:15px;">
							<div class="col-lg-6 text-center">
								<label class="xCNLabelFrm">ภาษีมูลค่าเพิ่ม</label>
							</div>
							<div class="col-lg-6 text-center">
								<label class="xCNLabelFrm" id="olaVatTotal">-</label>
							</div>
						</div>
						<div class="col-md-12" style="padding:15px;">
							<div class="col-lg-6 text-center">
								<label class="xCNLabelFrm"><?php //echo language('document/transferreceipt/transferreceipt', 'tTWIGrandB4Wht'); ?></label>
							</div>
							<div class="col-lg-6 text-center">
								<label class="xCNLabelFrm" id="othFCXthGrandB4Wht">-</label>
							</div>
						</div>
					</div>
				</div>
			</div> -->















		</div>
	</div>
</form>

<div class="modal fade" id="odvADJPLRateToRental">
	<div class="modal-dialog" style="width: 800px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="xCNHeardModal modal-title" style="display:inline-block">เลือกอัตราค่าเช่า</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<style>
				
					.xWDOCPdtTableRateModal {
					width: 100%;
					}

					.xWDOCPdtTableRateModal thead {
					display: table; /* to take the same width as tr */
					width: calc(100%); /* - 17px because of the scrollbar width */
					}

					.xWDOCPdtTableRateModal tbody {
					display: block; /* to enable vertical scrolling */
					max-height: 200px; /* e.g. */
					overflow-y: scroll; /* keeps the scrollbar even if it doesn't need it; display purpose */
					}

					#otbDOCPdtTableRateModalOver th, #otbDOCPdtTableRateModalOver td {
					width:33.33%;
					padding: 5px;
					word-break: break-all; /* 4. */
					}

					#otbDOCPdtTableRateModalUnder th, #otbDOCPdtTableRateModalUnder td {
					width:25%;
					padding: 5px;
					word-break: break-all; /* 4. */
					}

					.xWDOCPdtTableRateModal tr {
					display: table; /* display purpose; th's border */
					width: 100%;
					box-sizing: border-box; /* because of the border (Chrome needs this line, but not FF) */
					}
					#otbDOCPdtTableRateModalOver tbody tr:hover{
						cursor: pointer;
						background-color: #c6e6ff;
						color: #000000 !important;
					}
					#otbDOCPdtTableRateModalOver tbody tr.active td{
						cursor: pointer;
						background-color: #179bfd;
						color: #FFFFFF !important;
					}
					.xWDOCPdtTableRateModal td {
					text-align: center;
					
					}
				</style>
				<div class="table-responsive">
					<table class="table table-striped xWPdtTableFont xWDOCPdtTableRateModal" id="otbDOCPdtTableRateModalOver">
						<thead>
							<tr class="xCNCenter">
								<th>รหัส</th>
								<th>ชื่ออัตราค่าเช่า</th>
								<th>การปัดหน่วยเวลา</th>
							</tr>
						</thead>
						<tbody style="height:120px;over-flow-y:scroll">
							<tr>
								<td colspan="100%" class="text-center"><span><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWNotFound');?></span></td>
							</tr>
						</tbody>
					</table>
				</div>
				<label>รายละเอียด</label>
				<div class="table-responsive">
					<table class="table table-striped xWPdtTableFont xWDOCPdtTableRateModal" id="otbDOCPdtTableRateModalUnder">
						<thead>
							<tr class="xCNCenter">
								<th>ลำดับ</th>
								<th>เงื่อนไข/หน่วย</th>
								<th>ประเภทการให้เช่า</th>
								<th>อัตราค่าเช่า</th>
							</tr>
						</thead>
						<tbody style="height:120px;over-flow-y:scroll">
							<tr>
								<td colspan="100%" class="text-center"><span><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWNotFound');?></span></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-xs-8"></div>
					<div class="col-xs-2 xCNDropDrownGroup">
						<button type="button" data-dismiss="modal" class="btn xCNBTNMngTable" style="width:100%;font-size: 17px;"><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWStaDoc3');?></button>
					</div>
					<div class="col-xs-2">
						<button type="button" class="btn btn-primary xWConditionSearchPdt" style="width:100%;font-size: 17px;" onclick="JSxSaveRateCodeToTmp();"><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWBtnOK');?></button>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade xCNModalApprove" id="odvTFWPopupApv">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main','tApproveTheDocument'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p><?php echo language('common/main/main','tMainApproveStatus'); ?></p>
					<ul>
						<li><?php echo language('common/main/main','tMainApproveStatus1'); ?></li>
						<li><?php echo language('common/main/main','tMainApproveStatus2'); ?></li>
						<li><?php echo language('common/main/main','tMainApproveStatus3'); ?></li>
						<li><?php echo language('common/main/main','tMainApproveStatus4'); ?></li>
					</ul>
				<p><?php echo language('common/main/main','tMainApproveStatus5'); ?></p>
				<p><strong><?php echo language('common/main/main','tMainApproveStatus6'); ?></strong></p>
			</div>
			<div class="modal-footer">
				<button onclick="JSnTFWApprove(true)" type="button" class="btn xCNBTNPrimery">
					<?php echo language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="odvShowOrderColumn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo language('common/main/main', 'tModalAdvTable'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo language('common/main/main', 'tModalAdvClose'); ?></button>
        <button type="button" class="btn btn-primary" onclick="JSxSaveColumnShow()"><?php echo language('common/main/main', 'tModalAdvSave'); ?></button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="odvModalEditTFWDisHD">
	<div class="modal-dialog xCNDisModal">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" style="display:inline-block"><label class="xCNLabelFrm"><?php echo language('common/main/main', 'tTFWDisEndOfBill'); ?></label></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
					<div class="form-group">
						<label class="xCNLabelFrm"><?php echo language('common/main/main', 'tTFWDisType'); ?></label>
						<select class="selectpicker form-control" id="ostXthHDDisChgText" name="ostXthHDDisChgText">
							<option value="3"><?php echo  language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tDisChgTxt3')?></option>
							<option value="4"><?php echo  language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tDisChgTxt4')?></option>
							<option value="1"><?php echo  language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tDisChgTxt1')?></option>
							<option value="2"><?php echo  language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tDisChgTxt2')?></option>
						</select>
					</div>
					</div>
					<div class="col-md-4">
						<label class="xCNLabelFrm"><?php echo language('common/main/main', 'tTFWValue'); ?></label>
						<input type="text" class="form-control xCNInputNumericWithDecimal" id="oetXddHDDis" name="oetXddHDDis" maxlength="11" placeholder="">
					</div>
					<div class="col-md-2">
					<div class="form-group">
						<button type="button" class="btn btn-primary xCNBtnAddDis" onclick="FSvTFWAddHDDis()">
						<label class="xCNLabelAddDis">+</label>
						</button>
					</div>
					</div>
				</div>
        		<div id="odvHDDisListPanal"></div>
				<input type='hidden' id="ohdConfirmIDDelete">
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="odvTFWPopupCancel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo  language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWCanDoc')?></label>
			</div>
			<div class="modal-body">
                <p id="obpMsgApv"><?php echo  language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWDocRemoveCantEdit')?></p>
                <p><strong><?php echo  language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWCancel')?>?</strong></p>
			</div>
			<div class="modal-footer">
                <button onclick="JSnTFWCancel(true)" type="button" class="btn xCNBTNPrimery">
					<?php echo language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include('script/jRentalproductpriceadjustmentlockerAdd.php')?>
