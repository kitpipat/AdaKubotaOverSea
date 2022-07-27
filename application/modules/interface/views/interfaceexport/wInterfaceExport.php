<input id="oetInterfaceExportStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetInterfaceExportCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<?php
	if($this->session->userdata("tSesUsrLevel") == "HQ"){
		$tDisabled = "";
	}else{
		$nCountBch = $this->session->userdata("nSesUsrBchCount");
		if($nCountBch == 1){
			$tDisabled = "disabled";
		}else{
			$tDisabled = "";
		}
	}

	$tUserBchCode = $this->session->userdata("tSesUsrBchCodeDefault");
	$tUserBchName = $this->session->userdata("tSesUsrBchNameDefault");
?>

<?php

	$dBchStartFrm		= date('Y-m-d');
	$dBchStartTo		= date('Y-m-d');
?>

<div id="odvCpnMaIFXenu" class="main-menu clearfix">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<ol id="oliMenuNav" class="breadcrumb">
					<?php FCNxHADDfavorite('interfaceexport/0/0');?> 
					<li id="oliInterfaceExportTitle" class="xCNLinkClick" style="cursor:pointer" ><?php echo language('interface/interfaceexport/interfaceexport','tITFXTitle') ?></li>
				</ol>
			</div>
			
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
			<div id="odvBtnCmpEditInfo">
			<button id="obtInterfaceExportConfirm" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('interface/interfaceexport/interfaceexport','tITFXTConfirm')  ?></button> 
				</div>
	
			</div>
		</div>
	</div>
</div>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmInterfaceExport">
<div class="main-content">
	<div class="panel panel-headline">
	<input type="hidden" name="tUserCode" id="tUserCode" value="<?=$this->session->userdata('tSesUserCode')?>">
	<div class="row">
    <div class="col-md-12">

		<div class="panel-body">

			<div class="col-md-12">
				<input type="checkbox" name="ocbReqpairExport" id="ocbReqpairExport"  value="1" > เฉพาะรายการส่งไม่สำเร็จ
			</div>
				<div class="table-responsive" style="padding:20px">
						<table id="otbCtyDataList" class="table table-striped"> <!-- เปลี่ยน -->
							<thead>
								<tr>
									<th width="4%" nowrap class="text-center xCNTextBold"><?php echo language('interface/interfaceexport/interfaceexport','tITFXID'); ?></th>
									<th width="5%" nowrap class="text-center xCNTextBold"><?php echo language('interface/interfaceexport/interfaceexport','tITFXSelect'); ?></th>
									<th width="20%" nowrap class="text-center xCNTextBold"><?php echo language('interface/interfaceexport/interfaceexport','tITFXList'); ?></th>
									<th nowrap class="text-center xCNTextBold"><?php echo language('interface/interfaceexport/interfaceexport','tITFXCondition'); ?></th>
									<!-- <th width="15%" nowrap class="text-center xCNTextBold"><?php echo language('interface/interfaceexport/interfaceexport','tITFXTStatus'); ?></th> -->
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align="center">1</td>
									<td align="center">
										<input type="checkbox" class="progress-bar-chekbox xWIFXDisabledOnProcess" name="ocmIFXExport[]" id="ocmIFXExport1" value="1" idpgb="xWIFXExpBonTextDisplay" data-type="ExpBon" checked >
									</td>
									<td align="left"><?php echo @$aDataMasterImport[0]['FTApiName'] ?></td>
									<td>
										<div class="col-md-12">

											<!-- สาขา -->
											<div class="row">
												<div class="col-md-2"><?php echo language('company/branch/branch', 'tBCHTitle'); ?></div>
												<div class="col-md-10">

													<div id="odvCondition4" class="row">
														<div class="col-lg-5">
															
															<div class="form-group">	
																<div class="input-group">
																	<input class="form-control xCNHide" id="oetIFXBchCodeSale" name="oetIFXBchCodeSale" maxlength="5" value="<?php echo $tUserBchCode; ?>">
																	<input class="form-control xWPointerEventNone" type="text" id="oetIFXBchNameSale" name="oetIFXBchNameSale" value="<?php echo $tUserBchName; ?>" readonly>
																	<span class="input-group-btn">
																		<button id="obtIFXBrowseBchSale" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess" <?php echo $tDisabled; ?> >
																			<img src="<?php echo  base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
																		</button>
																	</span>
																</div>
															</div>
															
														</div>
													</div>

												</div>
											</div>
											<!-- สาขา -->

											<div class="row">
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterDate');?></div>
												<div class="col-md-10">

													<div id="odvCondition4" class="row">

														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input 
																		type="text" 
																		class="form-control xWITFXDatePickerSale xCNDatePicker xCNDatePickerStart xCNInputMaskDate xWRptAllInput xWIFXDisabledOnProcess" 
																		autocomplete="off" 
																		id="oetITFXDateFromSale"  
																		name="oetITFXDateFromSale"  
																		maxlength="10"
																		value=<?=$dBchStartFrm;?>>
																	<span class="input-group-btn">
																		<button id="obtITFXDateFromSale" type="button" class="btn xCNBtnDateTime xWIFXDisabledOnProcess"><img class="xCNIconCalendar"></button>
																	</span>
																</div>
															</div>
														</div>
												
														<div class="col-lg-1">
															<p class="xCNTextTo"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterTo');?></p>
														</div>

														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" 
																		class="form-control xWITFXDatePickerSale xCNDatePicker xCNDatePickerEnd xCNInputMaskDate xWRptAllInput xWIFXDisabledOnProcess" 
																		autocomplete="off" id="oetITFXDateToSale" 
																		name="oetITFXDateToSale"  
																		maxlength="10"
																		value="<?=$dBchStartTo;?>">
																	<span class="input-group-btn">
																		<button id="obtITFXDateToSale" type="button" class="btn xCNBtnDateTime xWIFXDisabledOnProcess"><img class="xCNIconCalendar"></button>
																	</span>
																</div>
															</div>
														</div>
														
													</div>

												</div>
											</div>

											<div class="row">
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterDocSal');?></div>
												<div class="col-md-10">
													<div class="xCNFilterBox"><div id="odvCondition1" class="row xCNFilterRangeMode">

														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXXshDocNoFrom" name="oetITFXXshDocNoFrom" readonly>
																	<!-- <input type="text" class="form-control xWPointerEventNone xWRptAllInput" id="oetRptBchNameFrom" name="oetRptBchNameFrom" readonly=""> -->
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseFromSale" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
												
														<div class="col-lg-1">
															<p class="xCNTextTo"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterTo');?></p>
														</div>

														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXXshDocNoTo" name="oetITFXXshDocNoTo" readonly>
																	<!-- <input type="text" class="form-control xWPointerEventNone xWRptAllInput" id="oetRptBchNameTo" name="oetRptBchNameTo" readonly=""> -->
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseToSale" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>
									</td>
									<!-- <td align="left">  
										<div class="xWIFXExpBonTextDisplay xWIFXTextDisplay" style="display:none;"
											 data-status 	= "2"
											 data-success	= "<?=language('interface/interfaceexport/interfaceexport','tITFXExportSuccess')?>"
											 data-fail		= "<?=language('interface/interfaceexport/interfaceexport','tITFXExportFail')?>">
										</div>

										div class="row xWIFXProgress xWIFXExpBonProgress" style="display:none;">
											<div class="col-md-1">
												<div class="loader simple-circle"></div>
											</div>
											<div class="col-md-9">
												<div class="odvIFXExpBonTextProgress text-primary"><?//=language('interface/interfaceexport/interfaceexport','tITFXExportProcess')?></div>
											</div>
											
											<div class="col-md-1"></div>
										</div>
  									</td> -->
								</tr>
								<!-- <tr> -->
									<!-- <td align="center">2</td> -->
									<!-- <td align="center"><input type="checkbox" class="progress-bar-chekbox xWIFXDisabledOnProcess" name="ocmIFXExport[]" id="ocmIFXExport2" value="2" idpgb="xWIFXExpFinTextDisplay" data-type="ExpFin" checked ></td> -->
									<!-- <td><?php //echo $aDataMasterImport[1]['FTInfName']  ?></td> -->
									<!-- <td> -->
										<!-- <div class="col-md-12"> -->
											<!-- สาขา -->
											<!-- <div class="row">
												<div class="col-md-2"><?php //echo language('company/branch/branch', 'tBCHTitle'); ?></div>
												<div class="col-md-10">

													<div id="odvCondition4" class="row">
														<div class="col-lg-5">
															
															<div class="form-group">	
																<div class="input-group">
																	<input class="form-control xCNHide" id="oetIFXBchCodeFin" name="oetIFXBchCodeFin" maxlength="5" value="<?php //echo $tUserBchCode; ?>">
																	<input class="form-control xWPointerEventNone" type="text" id="oetIFXBchNameFin" name="oetIFXBchNameFin" value="<?php //echo $tUserBchName; ?>" readonly>
																	<span class="input-group-btn">
																		<button id="obtIFXBrowseBchFin" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess" <?php //echo $tDisabled; ?> >
																			<img src="<?php //echo  base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
																		</button>
																	</span>
																</div>
															</div>
															
														</div>
													</div>

												</div>
											</div> -->
											<!-- สาขา -->

											<!-- <div class="row">
												<div class="col-md-2"><?//=language('interface/interfaceexport/interfaceexport','tITFXFilterDate');?></div>
												<div class="col-md-10">
													<div id="odvCondition4" class="row">

														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWITFXDatePickerFinance xCNDatePicker xCNDatePickerStart xCNInputMaskDate xWRptAllInput xWIFXDisabledOnProcess" autocomplete="off" id="oetITFXDateFromFinance" name="oetITFXDateFromFinance" maxlength="10">
																	<span class="input-group-btn">
																		<button id="obtITFXDateFromFinance" type="button" class="btn xCNBtnDateTime xWIFXDisabledOnProcess"><img class="xCNIconCalendar"></button>
																	</span>
																</div>
															</div>
														</div>

														<div class="col-lg-1">
															<p class="xCNTextTo"><?//=language('interface/interfaceexport/interfaceexport','tITFXFilterTo');?></p>
														</div>

														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWITFXDatePickerFinance xCNDatePicker xCNDatePickerEnd xCNInputMaskDate xWRptAllInput xWIFXDisabledOnProcess" autocomplete="off" id="oetITFXDateToFinance" name="oetITFXDateToFinance" maxlength="10">
																	<span class="input-group-btn">
																		<button id="obtITFXDateToFinance" type="button" class="btn xCNBtnDateTime xWIFXDisabledOnProcess"><img class="xCNIconCalendar"></button>
																	</span>
																</div>
															</div>
														</div>

													</div>
												</div>
											</div> -->
										<!-- </div>
									</td> -->
									<!-- <td align="left">  
										<div class="xWIFXExpFinTextDisplay xWIFXTextDisplay" style="display:none;"
											 data-status 	= "2"
											 data-success	= "<?//=language('interface/interfaceexport/interfaceexport','tITFXExportSuccess')?>"
											 data-fail		= "<?//=language('interface/interfaceexport/interfaceexport','tITFXExportFail')?>">
										</div>

										<div class="row xWIFXProgress xWIFXExpFinProgress" style="display:none;">
											<div class="col-md-1">
												<div class="loader simple-circle"></div>
											</div>
											<div class="col-md-9">
												<div class="odvIFXExpFinTextProgress text-primary"><?//=language('interface/interfaceexport/interfaceexport','tITFXExportProcess')?></div>
											</div>
											<div class="col-md-1"></div>
										</div> 
										<span id="ospIFXText_ExpFin" style="color:green;display:none" distext="<?//=language('interface/interfaceexport/interfaceexport','tITFXExportSuccess')?>" ><?//=language('interface/interfaceexport/interfaceexport','tITFXExportSuccess')?></span>
										<div class="progress" style="margin-bottom:0px">
									  		<div class="progress-bar" id="odvIFXProgressBar_ExpFin" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%" status='1'>
												0%
											</div>
									  	</div>	
  									</td> -->
								<!-- </tr> -->
							</tbody>
						</table>

						<!-- <input type="checkbox" name="ocmIFXChkAll" class="xWIFXDisabledOnProcess" id="ocmIFXChkAll" value="1" checked > <?php //echo language('interface/interfaceexport/interfaceexport','tITFXSelectAll'); ?> -->
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
</form>


<!--Modal Success-->
<div class="modal fade" id="odvInterfaceEmportSuccess">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('interface/interfaceexport/interfaceexport','tStatusProcess'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?=language('interface/interfaceexport/interfaceexport','tContentProcess'); ?></p>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" id="obtIFXModalMsgConfirm" type="button" class="btn xCNBTNPrimery">
                    <?=language('common/main/main', 'tModalConfirm'); ?>
                </button>
				<button type="button" id="obtIFXModalMsgCancel" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
            </div>
        </div>
    </div>
</div>



<script src="<?php echo base_url('application/modules/interface/assets/src/interfaceexport/jInterfaceExport.js')?>"></script>
<script>
	$('#ocbReqpairExport').click(function(){
		// Last Update : Napat(Jame) 17/08/2020 แก้ปัญหาติ๊ก checkbox แล้วกดปุ่มเมนูซ้ายมือไม่ได้
		if($(this).prop('checked') == true){
			$('.xWIFXDisabledOnProcess').prop('disabled',true);
			// $('input').prop('disabled',true);
			// $('button').prop('disabled',true);
		}else{
			$('.xWIFXDisabledOnProcess').prop('disabled',false);
			// $('input').prop('disabled',false);
			// $('button').prop('disabled',false);
		}
		$('#ocbReqpairExport').prop('disabled',false);
		$('#obtInterfaceExportConfirm').prop('disabled',false);
		$('#obtIFXModalMsgConfirm').prop('disabled',false);
	});

	$( document ).ready(function() {
		$('.xCNDatePicker').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true,
			// startDate: new Date()
		}).on('changeDate',function(ev){
			JSxIFXAfterChangeDateClearBrowse();
		});
	});


	$('#oetITFXDateFromSale').on('change',function(){
		if($('#oetITFXDateToSale').val() == ""){
			$('#oetITFXDateToSale').val($('#oetITFXDateFromSale').val());
		}
	});

	$('#oetITFXDateToSale').on('change',function(){
		if($('#oetITFXDateFromSale').val() == ""){
			$('#oetITFXDateFromSale').val($('#oetITFXDateToSale').val());
		}
	});

	$('#oetITFXDateFromFinance').on('change',function(){
		if($('#oetITFXDateToFinance').val() == ""){
			$('#oetITFXDateToFinance').val($('#oetITFXDateFromFinance').val());
		}
	});

	$('#oetITFXDateToFinance').on('change',function(){
		if($('#oetITFXDateFromFinance').val() == ""){
			$('#oetITFXDateFromFinance').val($('#oetITFXDateToFinance').val());
		}
	});

	

	// Date For SaleHD
	$('#obtITFXDateFromSale').off('click').on('click',function(){
		$('#oetITFXDateFromSale').datepicker('show');
	});

	$('#obtITFXDateToSale').off('click').on('click',function(){
		$('#oetITFXDateToSale').datepicker('show');
	});

	

	// Date For Finance
	$('#obtITFXDateFromFinance').off('click').on('click',function(){
		$('#oetITFXDateFromFinance').datepicker('show');
	});

	$('#obtITFXDateToFinance').off('click').on('click',function(){
		$('#oetITFXDateToFinance').datepicker('show');
	});

	// $('.xWITFXDatePickerFinance').datepicker({
	// 	format					: 'dd/mm/yyyy',
	// 	disableTouchKeyboard 	: true,
	// 	enableOnReadonly		: false,
	// 	autoclose				: true,
	// });


	$('#obtITFXBrowseFromSale').off('click').on('click',function(){
		window.oITFXBrowseFromSale = undefined;
		oITFXBrowseFromSale        = oITFXBrowseSaleOption({
			'tReturnInputCode'  : 'oetITFXXshDocNoFrom',
			'tReturnInputName'  : '',
			'tNextFuncName'     : 'JSxIFXAfterBrowseSaleFrom',
			'aArgReturn'        : ['FTXshDocNo']
		});
		JCNxBrowseData('oITFXBrowseFromSale');
	});

	$('#obtITFXBrowseToSale').off('click').on('click',function(){
		window.oITFXBrowseToSale = undefined;
		oITFXBrowseToSale        = oITFXBrowseSaleOption({
			'tReturnInputCode'  : 'oetITFXXshDocNoTo',
			'tReturnInputName'  : '',
			'tNextFuncName'     : 'JSxIFXAfterBrowseSaleTo',
			'aArgReturn'        : ['FTXshDocNo']
		});
		JCNxBrowseData('oITFXBrowseToSale');
	});
	

	var oITFXBrowseSaleOption = function(poReturnInput){
        let tNextFuncName    = poReturnInput.tNextFuncName;
        let aArgReturn       = poReturnInput.aArgReturn;
        let tInputReturnCode = poReturnInput.tReturnInputCode;
		let tInputReturnName = poReturnInput.tReturnInputName;
		let dDateFrom		 = $('#oetITFXDateFromSale').val();
		let dDateTo			 = $('#oetITFXDateToSale').val();
		let tWhere		     = "";
		
		if(dDateFrom != "" && dDateTo != ""){
			tWhere = " AND CONVERT(VARCHAR(10),TPSTSalHD.FDXshDocDate,121) BETWEEN CONVERT(VARCHAR(10),CONVERT(datetime,'" + dDateFrom +"',121),121) AND CONVERT(VARCHAR(10),CONVERT(datetime,'"+dDateTo+"',121),121)";
		}else{
			tWhere = " ";
		}

        let oOptionReturn    = {
            Title: ['interface/interfaceexport/interfaceexport','tITFXDataSal'],
            Table:{Master:'TPSTSalHD',PK:'FTXshDocNo'},
			Where: {
                    Condition: [tWhere]
			},
			Filter:{
				Selector    : 'oetIFXBchCodeSale',
				Table       : 'TPSTSalHD',
				Key         : 'FTBchCode'
			},
            GrideView:{
                ColumnPathLang	: 'interface/interfaceexport/interfaceexport',
                ColumnKeyLang	: ['tITFXSalDocNo','tITFXSalDate'],
                ColumnsSize     : ['30%','70%'],
                WidthModal      : 50,
                DataColumns		: ['TPSTSalHD.FTXshDocNo','TPSTSalHD.FDXshDocDate'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TPSTSalHD.FTXshDocNo ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TPSTSalHD.FTXshDocNo"],
                Text		: [tInputReturnName,"TPSTSalHD.FTXshDocNo"]
			},
            NextFunc : {
                FuncName    : tNextFuncName,
                ArgReturn   : aArgReturn
            }
            // RouteAddNew: 'branch',
            // BrowseLev: 1
        };
        return oOptionReturn;
	};
	
	$('#ocmIFXChkAll').off('click').on('click',function(){
		if($(this).prop('checked') == true){
			$('.progress-bar-chekbox').prop('checked',true);
		}else{
			$('.progress-bar-chekbox').prop('checked',false);
		}
	});

	$('#obtInterfaceExportConfirm').off('click').on('click',function(){
		let nImpportFile = $('.progress-bar-chekbox:checked').length;
        if(nImpportFile > 0){
			JCNxOpenLoading(); 
			JSxIFXDefualValueProgress();
			JSxIFXCallRabbitMQ();
        }else{
            alert('Please Select Imformation For Export');
        }
	});

	$('#obtIFXBrowseBchFin').off('click').on('click',function(){
		window.oITFXBrowseBch = undefined;
		oITFXBrowseBch        = oITFXBrowseBchOption({
			'tReturnInputCode'  : 'oetIFXBchCodeFin',
			'tReturnInputName'  : 'oetIFXBchNameFin',
		});
		JCNxBrowseData('oITFXBrowseBch');
	});
	
	$('#obtIFXBrowseBchSale').off('click').on('click',function(){
		window.oITFXBrowseBch = undefined;
		oITFXBrowseBch        = oITFXBrowseBchOption({
			'tReturnInputCode'  : 'oetIFXBchCodeSale',
			'tReturnInputName'  : 'oetIFXBchNameSale',
		});
		JCNxBrowseData('oITFXBrowseBch');
	});

	var oITFXBrowseBchOption = function(poReturnInput){
        let tNextFuncName    = poReturnInput.tNextFuncName;
        let aArgReturn       = poReturnInput.aArgReturn;
        let tInputReturnCode = poReturnInput.tReturnInputCode;
		let tInputReturnName = poReturnInput.tReturnInputName;

		var tUsrLevel     = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
		var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
		var nCountBch     = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
		let tWhere		     = "";

		if(tUsrLevel != "HQ"){
			tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
		}else{
			tWhere = "";
		}

		var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
        let oOptionReturn    = {
            Title: ['company/branch/branch','tBCHTitle'],
            Table:{Master:'TCNMBranch',PK:'FTBchCode'},
			Join: {
                Table: ['TCNMBranch_L'],
                On:['TCNMBranch.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
			},
			Where: {
				Condition: [tWhere]
			},
            GrideView:{
                ColumnPathLang	: 'company/branch/branch',
                ColumnKeyLang	: ['tBCHCode','tBCHName'],
                ColumnsSize     : ['30%','70%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMBranch.FTBchCode"],
                Text		: [tInputReturnName,"TCNMBranch_L.FTBchName"]
			},
        };
        return oOptionReturn;
	};

	// Create By : Napat(Jame) 17/08/2020 เมื่อกดปุ่มยืนยันให้วิ่งไปที่หน้า ประวัตินำเข้า-ส่งออก
	$('#obtIFXModalMsgConfirm').off('click');
	$('#obtIFXModalMsgConfirm').on('click',function(){
		// ใส่ timeout ป้องกัน modal-backdrop
		setTimeout(function(){
			$.ajax({
				type    : "POST",
				url     : "interfacehistory/0/0",
				data    : {},
				cache   : false,
				Timeout : 0,
				success: function(tResult){
					$('.odvMainContent').html(tResult);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					JCNxResponseError(jqXHR, textStatus, errorThrown);
				}
			});
		}, 100);
	});

</script>