<script type="text/javascript">

	var tUsrLevel = '<?=$this->session->userdata('tSesUsrLoginLevel')?>';
	alert(tUsrLevel);
	if( tUsrLevel != "HQ" ){
		var tBchCount = <?php echo $this->session->userdata("nSesUsrBchCount"); ?>;
		if(tBchCount < 2){
			$('#oimBrowseBch').attr('disabled', true);
		}
	}

	nLangEdits = '<?php echo $this->session->userdata("tLangEdit"); ?>';
	tUsrApv    = '<?php echo $this->session->userdata("tSesUsername"); ?>';
	var tSesUsrLevel    = '<?php echo $this->session->userdata('tSesUsrLoginLevel');?>';
    var tUserBchCode    = '<?php echo $this->session->userdata("tSesUsrBchCodeDefault");?>';
    var tUserBchName    = '<?php echo $this->session->userdata("tSesUsrBchNameDefault");?>';
    var tUserWahCode    = '<?php echo $this->session->userdata("tSesUsrWahCode");?>';
	var tUserWahName    = '<?php echo $this->session->userdata("tSesUsrWahName");?>';
	var tRoute          =  $('#ohdTFWRoute').val();
	<?php
	if ($tRoute == "ADJSTKVDEventAdd") {
		if ($tBchCode == '') {
			if ($tShpCodeStart == '') {
				// user hq
				?>
				var tUserType = "HQ";
			<?php
		}
		?>

		<?php
	} else {
		if ($tShpCodeStart != '') {
			// user shop
			?>
				var tUserType = "SHP";
				
			<?php
		} else {
			// user bch
			?>
				var tUserType = "BCH";
				
			<?php
		}
	}
}
?>
	/* Disabled Enter in Form */
	$(document).keypress(
		function(event) {
			if (event.which == '13') {
				event.preventDefault();
			}
		}
	);
	//RabbitMQ
	/*===========================================================================*/
	// Document variable
	var tLangCode = nLangEdits;
	var tUsrBchCode = $("#ohdBchCode").val();
	var tUsrApv = $("#oetXthApvCode").val();
	var tDocNo = $("#oetXthDocNo").val();
	var tPrefix = 'RESAJS';
	var tStaApv = $("#ohdXthStaApv").val();
	var tStaPrcStk = $("#ohdXthStaPrcStk").val();
	var tStaDelMQ = $("#ohdXthStaDelMQ").val();
	var tQName = tPrefix + '_' + tDocNo + '_' + tUsrApv;
	$(document).ready(function() {
		

		if(tUserBchCode != ''){
            $('#oetBchCode').val(tUserBchCode);
            $('#oetBchName').val(tUserBchName);
            $('#obtBrowseASTBCH').attr("disabled","disabled");
        }
        if(tUserWahCode != '' && tRoute == 'dcmASTEventAdd'){
            $('#ohdWahCodeStart').val(tUserWahCode);
            $('#oetWahNameStart').val(tUserWahName);
        }
		// MQ Message Config
		var poDocConfig = {
			tLangCode: tLangCode,
			tUsrBchCode: tUsrBchCode,
			tUsrApv: tUsrApv,
			tDocNo: tDocNo,
			tPrefix: tPrefix,
			tStaDelMQ: tStaDelMQ,
			tStaApv: tStaApv,
			tQName: tQName
		};

		// RabbitMQ STOMP Config
		var poMqConfig = {
			host: "ws://"+oSTOMMQConfig.host+":15674/ws",
			username: oSTOMMQConfig.user,
			password: oSTOMMQConfig.password,
			vHost: oSTOMMQConfig.vhost
		};

		// Update Status For Delete Qname Parameter
		var poUpdateStaDelQnameParams = {
			ptDocTableName: "TCNTPdtAdjStkHD",
			ptDocFieldDocNo: "FTAjhDocNo",
			ptDocFieldStaApv: "FTAjhStaPrcStk",
			ptDocFieldStaDelMQ: "FTAjhStaDelMQ",
			ptDocStaDelMQ: tStaDelMQ,
			ptDocNo: tDocNo
		};

		// Callback Page Control(function)
		var poCallback = {
		    tCallPageEdit: "JSvCallPageTFWEdit",
    		tCallPageList: "JSvCallPageTFWList"
		};

		//Check Show Progress %
		if (tDocNo != '' && (tStaApv == 2 || tStaPrcStk == 2)) { // 2 = Processing
			
		    
			FSxCMNRabbitMQMessage(poDocConfig, poMqConfig, poUpdateStaDelQnameParams, poCallback);
		}

		//Check Delete MQ SubScrib
		if (tStaApv == 1 && tStaPrcStk == 1 && tStaDelMQ == '') { // Qname removed ?
			// console.log('DelMQ:');
			// Delete Queue Name Parameter
			var poDelQnameParams = {
				ptPrefixQueueName: tPrefix,
				ptBchCode: tUsrBchCode,
				ptDocNo: tDocNo,
				ptUsrCode: tUsrApv
			};
			FSxCMNRabbitMQDeleteQname(poDelQnameParams);
			FSxCMNRabbitMQUpdateStaDeleteQname(poUpdateStaDelQnameParams);
		}

		/*===========================================================================*/
		//RabbitMQ
		$('#oliMngPdtScan').click(function() {
			//Hide
			$('#oetSearchPdtHTML').hide();
			$('#oimMngPdtIconSearch').hide();
			//Show
			$('#oetScanPdtHTML').show();
			$('#oimMngPdtIconScan').show();
		});

		$('#oliMngPdtSearch').click(function() {
			//Hide
			$('#oetScanPdtHTML').hide();
			$('#oimMngPdtIconScan').hide();
			//Show
			$('#oetSearchPdtHTML').show();
			$('#oimMngPdtIconSearch').show();
		});

		$('.selectpicker').selectpicker();

		$('.xCNDatePicker').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true,
		});

		//DATE
		$('#obtXthDocDate').click(function() {
			event.preventDefault();
			$('#oetXthDocDate').datepicker('show');
		});

		$('#obtXthDocTime').click(function() {
			event.preventDefault();
			$('#oetXthDocTime').datetimepicker('show');
		});

		$('#obtXthRefExtDate').click(function() {
			event.preventDefault();
			$('#oetXthRefExtDate').datepicker('show');
		});

		$('#obtXthRefIntDate').click(function() {
			event.preventDefault();
			$('#oetXthRefIntDate').datepicker('show');
		});


		$('#obtXthTnfDate').click(function() {
			event.preventDefault();
			$('#oetXthTnfDate').datepicker('show');
		});

		//DATE


		$('.xCNTimePicker').datetimepicker({
			format: 'LT'
		});

		$('.xWTooltipsBT').tooltip({
			'placement': 'bottom'
		});
		$('[data-toggle="tooltip"]').tooltip({
			'placement': 'top'
		});


		tSpmCode = $('#oetSpmCode').val();

		$('#oetSplCode').change(function() {
			//Clear Modal Pdt ????????????????????????????????????????????????????????????????????? Spl
			$('#odvBrowsePdtPanal').html('');
		});


		$('#ostPmcGetCond').on('change', function(e) {
			var nSelected = $("option:selected", this);
			var nValue = this.value;
			if (nValue == 1 || nValue == 3) {
				// alert('????????????')
				$('.xWCdGetValue').removeClass('xCNHide');
				$('.xWCdGetQty').addClass('xCNHide');
				$('.xWCdPerAvgDis').addClass('xCNHide');

			} else if (nValue == 2) {
				// alert('??????????????? %')
				$('.xWCdGetValue').addClass('xCNHide');
				$('.xWCdGetQty').addClass('xCNHide');
				$('.xWCdPerAvgDis').removeClass('xCNHide');

			} else if (nValue == 4) {
				// alert('??????????????? ????????????')
				$('.xWCdGetValue').addClass('xCNHide');
				$('.xWCdGetQty').removeClass('xCNHide');
				$('.xWCdPerAvgDis').addClass('xCNHide');

			}

			$('#oetPmcGetQty').val('');
			$('#oetPmcGetValue').val('');
			$('#oetPmcPerAvgDis').val('');

		});

		//Set DocDate is Date Now	
		var dCurrentDate = new Date();
		var tAmOrPm = (dCurrentDate.getHours() < 12) ? "AM" : "PM";
		var tCurrentTime = dCurrentDate.getHours() + ":" + dCurrentDate.getMinutes() + " " + tAmOrPm;

		if ($('#oetXthDocDate').val() == '') {
			$('#oetXthDocDate').datepicker("setDate", dCurrentDate); // Doc Date
		}
		if ($('#oetXthTnfDate').val() == '') {
			$('#oetXthTnfDate').datepicker("setDate", dCurrentDate); // 
		}
		//Set DocTime is Time Now	
		if ($('#oetXthDocTime').val() == '') {
			$('#oetXthDocTime').val(tCurrentTime);
		}
		//Config Option ScanSku
		// nOptScanSku = $('#ohdOptScanSku').val();
		// $('#ostOptScanSku').val(nOptScanSku).attr('selected',true).trigger('change');

		//Config Option DocSave
		// nOptAlwSavQty0 = $('#ohdOptAlwSavQty0').val();
		// $('#ostOptAlwSavQty0').val(nOptAlwSavQty0).attr('selected',true).trigger('change');


		$('#ostXthVATInOrEx').on('change', function(e) {
			JSvTFWLoadPdtDataTableHtml(); // ????????????????????????????????????????????????
		});

		//Check Box Auto Gen Code
		$('#ocbStaAutoGenCode').on('change', function(e) {
			if ($('#ocbStaAutoGenCode').is(':checked')) {
				$('#oetXthDocNo').val('');
				$('#oetXthDocNo').attr('disabled', true);

				$('#oetXthDocNo-error').remove();
				$('#oetXthDocNo').parent().parent().removeClass('has-error');
			} else {
				$('#oetXthDocNo').attr('disabled', false);
			}
		});

	});

	var oTFWBrowseSpl = {

		Title: ['supplier/supplier/supplier', 'tSPLTitle'],
		Table: {
			Master: 'TCNMSpl',
			PK: 'FTSplCode'
		},
		Join: {
			Table: ['TCNMSpl_L', 'TCNMSplCredit'],
			On: ['TCNMSpl_L.FTSplCode = TCNMSpl.FTSplCode AND TCNMSpl_L.FNLngID = ' + nLangEdits,
				'TCNMSpl_L.FTSplCode = TCNMSplCredit.FTSplCode'
			]
		},
		Where: {
			Condition: ["AND TCNMSpl.FTSplStaActive = '1' "]
		},
		GrideView: {
			ColumnPathLang: 'supplier/supplier/supplier',
			ColumnKeyLang: ['tSPLTBCode', 'tSPLTBName'],
			ColumnsSize: ['15%', '75%'],
			WidthModal: 50,
			DataColumns: ['TCNMSpl.FTSplCode', 'TCNMSpl_L.FTSplName', 'TCNMSplCredit.FNSplCrTerm', 'TCNMSplCredit.FCSplCrLimit', 'TCNMSpl.FTSplStaVATInOrEx', 'TCNMSplCredit.FTSplTspPaid'],
			DataColumnsFormat: ['', ''],
			DisabledColumns: [2, 3, 4, 5],
			Perpage: 5,
			OrderBy: ['TCNMSpl_L.FTSplName'],
			SourceOrder: "ASC"
		},
		CallBack: {
			ReturnType: 'S',
			Value: ["oetSplCode", "TCNMSpl.FTSplCode"],
			Text: ["oetSplName", "TCNMSpl_L.FTSplName"],
		},
		NextFunc: {
			FuncName: 'JSxTFWGetDataToFillSpl',
			ArgReturn: ['FNSplCrTerm', 'FCSplCrLimit', 'FTSplStaVATInOrEx', 'FTSplTspPaid', 'FTSplCode', 'FTSplName']
		},
		RouteAddNew: 'supplier',
		BrowseLev: nStaTFWBrowseType

	}
	//Option Suplier

	//Option SalePerson
	var oTFWBrowseSpn = {

		Title: ['pos5/saleperson', 'tSPNTitle'],
		Table: {
			Master: 'TCNMSpn',
			PK: 'FTSpnCode'
		},
		Join: {
			Table: ['TCNMSpn_L'],
			On: ['TCNMSpn_L.FTSpnCode = TCNMSpn.FTSpnCode AND TCNMSpn_L.FNLngID = ' + nLangEdits, ]
		},
		GrideView: {
			ColumnPathLang: 'pos5/saleperson',
			ColumnKeyLang: ['tSPNCode', 'tSPNName', '', '', ''],
			ColumnsSize: ['15%', '75%'],
			WidthModal: 50,
			DataColumns: ['TCNMSpn.FTSpnCode', 'TCNMSpn_L.FTSpnName'],
			DataColumnsFormat: ['', ''],
			DisabledColumns: [2, 3, 4],
			Perpage: 5,
			OrderBy: ['TCNMSpn_L.FTSpnName'],
			SourceOrder: "ASC"
		},
		CallBack: {
			ReturnType: 'S',
			Value: ["oetSpnCode", "TCNMSpn.FTSpnCode"],
			Text: ["oetSpnName", "TCNMSpn_L.FTSpnName"],
		},
		RouteAddNew: 'suplier',
		BrowseLev: nStaTFWBrowseType

	}
	//Option SalePerson
	var nLangEdits;
	var oPmhBrowseBch;
	var oTFWBrowseMch;
	var oTFWBrowseShpStart;
	var oTFWBrowsePosStart;
	var oTFWBrowseWahStart;
	var oTFWBrowseShpEnd;
	var oTFWBrowsePosEnd;
	var oTFWBrowseWahEnd;
	var oTFWBrowseShipAdd;
	var tOldBchCkChange = "";
	var tOldMchCkChange = "";
	var tOldShpStartCkChange = "";
	var tOldPosStartCkChange = "";
	var tOldWahStartCkChange = "";
	var tOldShpEndCkChange = "";
	var tOldPosEndCkChange = "";
	var tOldWahEndCkChange = "";
	var oTFWBrowseShipVia = "";
	var oOptionReturn = "";
	
	//????????????????????????????????????
	$('#obtTFWBrowseMch').click(function() {
		$(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
		tOldMchCkChange	= $("#oetMchCode").val();
		oTFWBrowseMch	= {
			Title: ['company/warehouse/warehouse', 'tWAHBwsMchTitle'],
			Table: {
				Master: 'TCNMMerchant',
				PK: 'FTMerCode'
			},
			Join: {
				Table: ['TCNMMerchant_L'],
				On: ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = ' + nLangEdits]
			},
			Where: {
				Condition: ["AND (SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTShpStaActive = 1 AND TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '" + $("#oetBchCode").val() + "') != 0"]
			},
			GrideView: {
				ColumnPathLang: 'company/warehouse/warehouse',
				ColumnKeyLang: ['tWAHBwsMchCode', 'tWAHBwsMchNme'],
				ColumnsSize: ['15%', '75%'],
				WidthModal: 50,
				DataColumns: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
				DataColumnsFormat: ['', ''],
				Perpage: 5,
				OrderBy: ['TCNMMerchant.FTMerCode'],
				SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["oetMchCode", "TCNMMerchant.FTMerCode"],
				Text: ["oetMchName", "TCNMMerchant_L.FTMerName"],
			},
			NextFunc: {
				FuncName: 'JSxSetSeqConditionMerChant',
				ArgReturn: ['FTMerCode', 'FTMerName']
			},
			BrowseLev: 1,
			//DebugSQL : true
		};
		// Hide Pin Menu
		JSxCheckPinMenuClose();
		//Option merchant
		JCNxBrowseData('oTFWBrowseMch');
	});

	//???????????????????????????
	$('#obtTFWBrowseShpStart').click(function() {
		$(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
		tOldShpStartCkChange	= $("#oetShpCodeStart").val();
		//Option Shop  Start
		oTFWBrowseShpStart		= {
			Title: ['company/shop/shop', 'tSHPTitle'],
			Table: {
				Master: 'TCNMShop',
				PK: 'FTShpCode'
			},
			Join: {
				Table: ['TCNMShop_L', 'TCNMWaHouse_L'],
				On: [
					'TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
					'TCNMShop.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMShop.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID= ' + nLangEdits
				]
			},
			Where: {
				Condition: [
					function() {
						var tSQL = "AND TCNMShop.FTShpStaActive = 1 AND TCNMShop.FTBchCode = '" + $("#oetBchCode").val() + "' AND TCNMShop.FTMerCode = '" + $("#oetMchCode").val() + "'";
						tSQL += " AND TCNMShop.FTShpType = 4";
						return tSQL;
					}
				]
			},
			GrideView: {
				ColumnPathLang: 'company/branch/branch',
				ColumnKeyLang: ['tBCHCode', 'tBCHName'],
				ColumnsSize: ['25%', '75%'],
				WidthModal: 50,
				DataColumns: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName', 'TCNMShop.FTWahCode', 'TCNMWaHouse_L.FTWahName', 'TCNMShop.FTShpType', 'TCNMShop.FTBchCode'],
				DataColumnsFormat: ['', '', '', '', '', ''],
				DisabledColumns: [2, 3, 4, 5],
				Perpage: 5,
				OrderBy: ['TCNMShop_L.FTShpName'],
				SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["oetShpCodeStart", "TCNMShop.FTShpCode"],
				Text: ["oetShpNameStart", "TCNMShop_L.FTShpName"],
			},
			NextFunc: {
				FuncName: 'JSxSetSeqConditionShpStart',
				ArgReturn: ['FTBchCode', 'FTShpCode', 'FTShpType', 'FTWahCode', 'FTWahName']
			},
			BrowseLev: 1,
			// DebugSQL : true


		}
		// Hide Pin Menu
		JSxCheckPinMenuClose();
		//Option Shop Start
		JCNxBrowseData('oTFWBrowseShpStart');
	});

	//??????????????????????????????????????????????????????
	$('#obtTFWBrowsePosStart').click(function() {
		$(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
		tOldPosStartCkChange	= $("#oetPosCodeStart").val();
		//Option Shop  Start
		oTFWBrowsePosStart		= {
			Title: ['pos/posshop/posshop', 'tPshTBPosCode'],
			Table: {
				Master: 'TVDMPosShop',
				PK: 'FTPosCode'
			},
			Join: {
				Table: ['TCNMPos', 'TCNMPosLastNo', 'TCNMWaHouse', 'TCNMWaHouse_L'],
				On: [
					'TVDMPosShop.FTPosCode = TCNMPos.FTPosCode AND TVDMPosShop.FTBchCode = TCNMPos.FTBchCode',
					'TVDMPosShop.FTPosCode = TCNMPosLastNo.FTPosCode',
					'TVDMPosShop.FTPosCode = TCNMWaHouse.FTWahRefCode AND TVDMPosShop.FTBchCode = TCNMWaHouse.FTBchCode AND TCNMWaHouse.FTWahStaType = 6',
					'TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TVDMPosShop.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID= ' + nLangEdits
				]
			},
			Where: {
				Condition: [
					function() {
						var tSQL = "AND TCNMPos.FTPosStaUse = 1 AND TVDMPosShop.FTShpCode = '" + $("#oetShpCodeStart").val() + "' AND TVDMPosShop.FTBchCode = '" + $("#oetBchCode").val() + "'";
						tSQL += " AND TCNMPos.FTPosType = '4'";
						if ($("#oetShpCodeEnd").val() != "") {
							if ($("#oetShpCodeStart").val() == $("#oetShpCodeEnd").val()) {
								if ($("#oetPosCodeEnd").val() != "") {
									tSQL += " AND TVDMPosShop.FTPosCode != '" + $("#oetPosCodeEnd").val() + "'";
								}
							}
						}
						tSQL += " AND ISNULL(TCNMWaHouse.FTWahRefCode,'') != '' ";
						return tSQL;
					}
				]
			},
			GrideView: {
				ColumnPathLang: 'pos/posshop/posshop',
				ColumnKeyLang: ['tPshBRWShopTBCode', 'tPshBRWPosTBName'],
				ColumnsSize: ['25%', '75%'],
				WidthModal: 50,
				DataColumns: ['TVDMPosShop.FTPosCode', 'TCNMPosLastNo.FTPosComName', 'TVDMPosShop.FTShpCode', 'TVDMPosShop.FTBchCode', 'TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
				DataColumnsFormat: ['', '', '', '', '', ''],
				DisabledColumns: [1,2, 3, 4, 5],
				Perpage: 5,
				OrderBy: ['TVDMPosShop.FTPosCode'],
				SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["oetPosCodeStart", "TVDMPosShop.FTPosCode"],
				Text: ["oetPosNameStart", "TVDMPosShop.FTPosCode"],
			},
			NextFunc: {
				FuncName: 'JSxSetSeqConditionPosStart',
				ArgReturn: ['FTBchCode', 'FTShpCode', 'FTPosCode', 'FTWahCode', 'FTWahName']
			},
			BrowseLev: 1,
			// DebugSQL : true

		}

		// Hide Pin Menu
		JSxCheckPinMenuClose();
		//Option Shop Start
		JCNxBrowseData('oTFWBrowsePosStart');
	});

	//???????????????????????????
	$('#obtTFWBrowseWahStart').click(function() {
		// $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
		// tOldWahStartCkChange	= $("ohdWahCodeStart").val();

		// if($("#oetPosCodeStart").val() == ""){
		// 	//???????????????????????? SHPWAH
		// 	oTFWBrowseWahStart	= {
		// 		Title	: ['company/warehouse/warehouse', 'tWAHTitle'],
		// 		Table	: { Master: 'TCNMShpWah', PK: 'FTWahCode' },
		// 		Join	: {
		// 			Table	: ['TCNMWaHouse_L'],
		// 			On		: ['TCNMWaHouse_L.FTWahCode = TCNMShpWah.FTWahCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
		// 		},
		// 		Where: {
		// 			Condition: [
		// 				function() {
		// 					var tSQL = "";
		// 						tSQL += " AND TCNMShpWah.FTShpCode = ('" + $("#oetShpCodeStart").val() + "')";
		// 					return tSQL;
		// 				}
		// 			]
		// 		},
		// 		GrideView: {
		// 			ColumnPathLang		: 'company/warehouse/warehouse',
		// 			ColumnKeyLang		: ['tWahCode', 'tWahName'],
		// 			DataColumns			: ['TCNMShpWah.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
		// 			DataColumnsFormat	: ['', ''],
		// 			ColumnsSize			: ['15%', '75%'],
		// 			Perpage				: 5,
		// 			WidthModal			: 50,
		// 			OrderBy				: ['TCNMWaHouse_L.FTWahName'],
		// 			SourceOrder			: "ASC"
		// 		},
		// 		CallBack: {
		// 			ReturnType: 'S',
		// 			Value	: ["ohdWahCodeStart", "TCNMWaHouse.FTWahCode"],
		// 			Text	: ["oetWahNameStart", "TCNMWaHouse_L.FTWahName"],
		// 		},
		// 		NextFunc: {
		// 			FuncName	: 'JSxSetSeqConditionWahStart',
		// 			ArgReturn	: []
		// 		},
		// 		RouteAddNew	: 'warehouse',
		// 		BrowseLev	: nStaTFWBrowseType
		// 	}
		// }else if($("#oetPosCodeStart").val() != ""){
		// 	//???????????????????????? WAHHOUSE
		// 	oTFWBrowseWahStart	= {
		// 		Title	: ['company/warehouse/warehouse', 'tWAHTitle'],
		// 		Table	: { Master: 'TCNMWaHouse', PK: 'FTWahCode' },
		// 		Join	: {
		// 			Table	: ['TCNMWaHouse_L'],
		// 			On		: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
		// 		},
		// 		Where: {
		// 			Condition: [
		// 				function() {
		// 					var tSQL = "";
		// 						tSQL += " AND TCNMWaHouse.FTWahRefCode = ('" + $("#oetPosCodeStart").val() + "')";
		// 					return tSQL;
		// 				}
		// 			]
		// 		},
		// 		GrideView: {
		// 			ColumnPathLang		: 'company/warehouse/warehouse',
		// 			ColumnKeyLang		: ['tWahCode', 'tWahName'],
		// 			DataColumns			: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
		// 			DataColumnsFormat	: ['', ''],
		// 			ColumnsSize			: ['15%', '75%'],
		// 			Perpage				: 5,
		// 			WidthModal			: 50,
		// 			OrderBy				: ['TCNMWaHouse_L.FTWahName'],
		// 			SourceOrder			: "ASC"
		// 		},
		// 		CallBack: {
		// 			ReturnType: 'S',
		// 			Value	: ["ohdWahCodeStart", "TCNMWaHouse.FTWahCode"],
		// 			Text	: ["oetWahNameStart", "TCNMWaHouse_L.FTWahName"],
		// 		},
		// 		NextFunc: {
		// 			FuncName	: 'JSxSetSeqConditionWahStart',
		// 			ArgReturn	: []
		// 		},
		// 		RouteAddNew	: 'warehouse',
		// 		BrowseLev	: nStaTFWBrowseType
		// 	}
		// }

		// // Hide Pin Menu
		// JSxCheckPinMenuClose();
		// //Option WareHouse From 
		// JCNxBrowseData('oTFWBrowseWahStart');
	});

	//??????????????????
	$('#obtASTBrowseRsn').click(function() {
		$(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
		// Option Modal ??????????????????
		oOptionReturn = {
			Title: ["other/reason/reason","tRSNTitle"],
			Table: {Master:"TCNMRsn",PK:"FTRsnCode"},
			Join: {
				Table: ["TCNMRsn_L"],
				On: ["TCNMRsn.FTRsnCode = TCNMRsn_L.FTRsnCode AND TCNMRsn_L.FNLngID = '"+nLangEdits+"'"]
			},
			Where: {
				Condition: [
					function() {
						var tSQL = " AND TCNMRsn.FTRsgCode = '008' ";
						return tSQL;
					}
				]
			},
			GrideView: {
				ColumnPathLang: 'other/reason/reason',
				ColumnKeyLang: ['tRSNTBCode','tRSNTBName'],
				ColumnsSize: ['15%','75%'],
				WidthModal: 50,
				DataColumns: ['TCNMRsn.FTRsnCode','TCNMRsn_L.FTRsnName'],
				DataColumnsFormat: ['',''],
				Perpage: 10,
				OrderBy: ['TCNMRsn_L.FTRsnName ASC'],
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["oetASTRsnCode","TCNMRsn.FTRsnCode"],
				Text: ["oetASTRsnName","TCNMRsn_L.FTRsnName"],
			},
			RouteAddNew : 'reason',
			BrowseLev : 1,
		};
		// Hide Pin Menu
		JSxCheckPinMenuClose();
		JCNxBrowseData('oOptionReturn');
	});
	
	//??????????????????
	$('#obtTFWBrowseShpEnd').click(function() {
		$(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
		tOldShpEndCkChange = $("#oetShpCodeEnd").val();
		//Option Shop  Start
		oTFWBrowseShpEnd = {
			Title: ['company/shop/shop', 'tSHPTitle'],
			Table: {
				Master: 'TCNMShop',
				PK: 'FTShpCode'
			},
			Join: {
				Table: ['TCNMShop_L', 'TCNMWaHouse_L'],
				On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
					'TCNMShop.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID= ' + nLangEdits
				]
			},
			Where: {
				Condition: [
					function() {
						var tSQL = "AND TCNMShop.FTShpStaActive = 1 AND TCNMShop.FTBchCode = '" + $("#oetBchCode").val() + "' AND TCNMShop.FTMerCode = '" + $("#oetMchCode").val() + "'";
						if ($("#oetShpCodeStart").val() != "" && $("#ohdWahCodeStart").val() != "") {
							if ($($($($("#obtTFWBrowsePosStart").parent()).parent()).parent()).hasClass("xCNHide")) {
								if ($($($($("#obtTFWBrowsePosEnd").parent()).parent()).parent()).hasClass("xCNHide")) {
									tSQL += " AND TCNMShop.FTShpCode != '" + $("#oetShpCodeStart").val() + "'";

								} else {
									if ($("#oetShpCodeEnd").val() != "") {
										tSQL += " AND TCNMShop.FTShpCode != '" + $("#oetShpCodeStart").val() + "'";
									}
								}
							}
						}
						return tSQL;
					}
				]


			},
			GrideView: {
				ColumnPathLang: 'company/branch/branch',
				ColumnKeyLang: ['tBCHCode', 'tBCHName'],
				ColumnsSize: ['25%', '75%'],
				WidthModal: 50,
				DataColumns: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName', 'TCNMShop.FTWahCode', 'TCNMWaHouse_L.FTWahName', 'TCNMShop.FTShpType', 'TCNMShop.FTBchCode'],
				DataColumnsFormat: ['', '', '', '', '', ''],
				DisabledColumns: [2, 3, 4, 5],
				Perpage: 5,
				OrderBy: ['TCNMShop_L.FTShpName'],
				SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["oetShpCodeEnd", "TCNMShop.FTShpCode"],
				Text: ["oetShpNameEnd", "TCNMShop_L.FTShpName"],
			},
			NextFunc: {
				FuncName: 'JSxSetSeqConditionShpEnd',
				ArgReturn: ['FTBchCode', 'FTShpCode', 'FTShpType', 'FTWahCode', 'FTWahName']
			},
			BrowseLev: 1
		}
		// Hide Pin Menu
		JSxCheckPinMenuClose();
		//Option Shop Start
		JCNxBrowseData('oTFWBrowseShpEnd');
	});

	//?????????????????????????????????????????????
	$('#obtTFWBrowsePosEnd').click(function() {
		$(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
		tOldPosEndCkChange = $("#oetPosCodeEnd").val();
		//Option Shop  Start
		oTFWBrowsePosEnd = {
			Title: ['pos/posshop/posshop', 'tPshTBPosCode'],
			Table: {
				Master: 'TVDMPosShop',
				PK: 'FTPosCode'
			},
			Join: {
				Table: ['TCNMPos', 'TCNMPosLastNo', 'TCNMWaHouse', 'TCNMWaHouse_L'],
				On: ['TVDMPosShop.FTPosCode = TCNMPos.FTPosCode',
					'TVDMPosShop.FTPosCode = TCNMPosLastNo.FTPosCode',
					'TVDMPosShop.FTPosCode = TCNMWaHouse.FTWahRefCode AND TCNMWaHouse.FTWahStaType = 6',
					'TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID= ' + nLangEdits
				]
			},
			Where: {
				Condition: [
					function() {
						var tSQL = "AND TCNMPos.FTPosStaUse = 1 AND TVDMPosShop.FTShpCode = '" + $("#oetShpCodeEnd").val() + "' AND TVDMPosShop.FTBchCode = '" + $("#oetBchCode").val() + "'";
						tSQL += " AND TCNMPos.FTPosType = '4'";
						if ($("#oetShpCodeStart").val() != "") {
							if ($("#oetShpCodeEnd").val() == $("#oetShpCodeStart").val()) {
								if ($("#oetPosCodeStart").val() != "") {
									tSQL += " AND TVDMPosShop.FTPosCode NOT IN ('" + $("#oetPosCodeStart").val() + "')";
								}
							}
						}
						return tSQL;
					}
				]
			},
			GrideView: {
				ColumnPathLang: 'pos/posshop/posshop',
				ColumnKeyLang: ['tPshBRWShopTBCode', 'tPshBRWPosTBName'],
				ColumnsSize: ['25%', '75%'],
				WidthModal: 50,
				DataColumns: ['TVDMPosShop.FTPosCode', 'TCNMPosLastNo.FTPosComName', 'TVDMPosShop.FTShpCode', 'TVDMPosShop.FTBchCode', 'TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
				DataColumnsFormat: ['', '', '', '', '', ''],
				DisabledColumns: [1,2, 3, 4, 5],
				Perpage: 5,
				OrderBy: ['TVDMPosShop.FTPosCode'],
				SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["oetPosCodeEnd", "TVDMPosShop.FTPosCode"],
				Text: ["oetPosNameEnd", "TVDMPosShop.FTPosCode"],
			},
			NextFunc: {
				FuncName: 'JSxSetSeqConditionPosEnd',
				ArgReturn: ['FTBchCode', 'FTShpCode', 'FTPosCode', 'FTWahCode', 'FTWahName']
			},
			BrowseLev: 1

		}
		// Hide Pin Menu
		JSxCheckPinMenuClose();
		//Option Shop 
		JCNxBrowseData('oTFWBrowsePosEnd');
	});

	//??????????????????
	$('#obtTFWBrowseWahEnd').click(function() {
		$(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
		tOldWahEndCkChange = $("#ohdWahCodeEnd").val();
		if ($("#oetBchCode").val() != "" &&
			$("#oetShpCodeEnd").val() == "" &&
			$("#oetPosCodeEnd").val() == "") {
			//Option WareHouse From
			oTFWBrowseWahEnd = {
				Title: ['company/warehouse/warehouse', 'tWAHTitle'],
				Table: {
					Master: 'TCNMWaHouse',
					PK: 'FTWahCode'
				},
				Join: {
					Table: ['TCNMWaHouse_L'],
					On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
				},
				Where: {
					Condition: [
						function() {
							var tSQL = "AND TCNMWaHouse.FTWahStaType IN (1,2)";
							if ($("#ohdWahCodeStart").val() != "") {
								tSQL += " AND TCNMWaHouse.FTWahCode NOT IN ('" + $("#ohdWahCodeStart").val() + "')";
							}
							return tSQL;
						}
					]
				},
				GrideView: {
					ColumnPathLang: 'company/warehouse/warehouse',
					ColumnKeyLang: ['tWahCode', 'tWahName'],
					DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
					DataColumnsFormat: ['', ''],
					ColumnsSize: ['15%', '75%'],
					Perpage: 5,
					WidthModal: 50,
					OrderBy: ['TCNMWaHouse_L.FTWahName'],
					SourceOrder: "ASC"
				},
				CallBack: {
					ReturnType: 'S',
					Value: ["ohdWahCodeEnd", "TCNMWaHouse.FTWahCode"],
					Text: ["oetWahNameEnd", "TCNMWaHouse_L.FTWahName"],
				},
				NextFunc: {
					FuncName: 'JSxSetSeqConditionWahEnd',
					ArgReturn: []
				},
				RouteAddNew: 'warehouse',
				BrowseLev: nStaTFWBrowseType
			}
		} else if ($("#oetBchCode").val() != "" &&
			$("#oetShpCodeEnd").val() != "" &&
			$("#oetPosCodeEnd").val() == "") {
			//Option WareHouse From
			oTFWBrowseWahEnd = {
				Title: ['company/warehouse/warehouse', 'tWAHTitle'],
				Table: {
					Master: 'TCNMWaHouse',
					PK: 'FTWahCode'
				},
				Join: {
					Table: ['TCNMWaHouse_L', 'TCNMShop'],
					On: [
						"TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID = " + nLangEdits,
						"TCNMWaHouse.FTWahCode = TCNMShop.FTWahCode AND TCNMShop.FTBchCode = '" + $("#oetBchCode").val() + "' AND TCNMShop.FTShpCode = '" + $("#oetShpCodeEnd").val() + "'"
					]
				},
				Where: {
					Condition: [
						function() {
							var tSQL = "AND (TCNMShop.FTBchCode != '' AND TCNMShop.FTShpCode != '') AND (TCNMShop.FTBchCode IS NOT NULL AND TCNMShop.FTShpCode IS NOT NULL)";
							return tSQL;
						}
					]
				},
				GrideView: {
					ColumnPathLang: 'company/warehouse/warehouse',
					ColumnKeyLang: ['tWahCode', 'tWahName'],
					DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
					DataColumnsFormat: ['', ''],
					ColumnsSize: ['15%', '75%'],
					Perpage: 5,
					WidthModal: 50,
					OrderBy: ['TCNMWaHouse.FTWahCode'],
					SourceOrder: "ASC"
				},
				CallBack: {
					ReturnType: 'S',
					Value: ["ohdWahCodeEnd", "TCNMWaHouse.FTWahCode"],
					Text: ["oetWahNameEnd", "TCNMWaHouse_L.FTWahName"],
				},
				NextFunc: {
					FuncName: 'JSxSetSeqConditionWahEnd',
					ArgReturn: []
				},
				RouteAddNew: 'warehouse',
				BrowseLev: nStaTFWBrowseType
			}
		}
		// Hide Pin Menu
		JSxCheckPinMenuClose();
		//Option WareHouse From 
		JCNxBrowseData('oTFWBrowseWahEnd');
	});


	$('#obtTFWBrowseShipAdd').click(function(pE) {
		$(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
		$("#odvTFWBrowseShipAdd").modal("show");
		// tBchCode    = $('#oetBchCode').val();
		// tXthShipAdd = $('#ohdXthShipAdd').val();

		// JSvTFWGetShipAddData(tBchCode,tXthShipAdd);

	});
	//Event Browse ShipAdd
	$('#oliBtnEditShipAdd').click(function() {
		$(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
		//option Ship Address 
		oTFWBrowseShipAdd = {
			Title: ['document/purchaseorder/purchaseorder', 'tBrowseADDTitle'],
			Table: {
				Master: 'TCNMAddress_L',
				PK: 'FNAddSeqNo'
			},
			Join: {
				Table: ['TCNMProvince_L', 'TCNMDistrict_L', 'TCNMSubDistrict_L'],
				On: [
					"TCNMAddress_L.FTAddV1PvnCode = TCNMProvince_L.FTPvnCode AND TCNMProvince_L.FNLngID = " + nLangEdits,
					"TCNMAddress_L.FTAddV1DstCode = TCNMDistrict_L.FTDstCode AND TCNMDistrict_L.FNLngID = " + nLangEdits,
					"TCNMAddress_L.FTAddV1SubDist = TCNMSubDistrict_L.FTSudCode AND TCNMSubDistrict_L.FNLngID = " + nLangEdits
				]
			},
			Where: {
				Condition: [
					function() {
						var tFilter = "";
						if ($("#oetBchCode").val() != "") {
							if ($("#oetMchCode").val() != "") {
								if ($("#oetShpCodeEnd").val() != "") {
									if ($("#oetPosCodeEnd").val() != "") {
										// ???????????????????????????????????????
										tFilter += "AND FTAddGrpType = 6 AND FTAddRefCode = '" + $("#oetPosCodeEnd").val() + "' AND TCNMAddress_L.FNLngID = " + nLangEdits;
									} else {
										// ?????????????????????
										tFilter += "AND FTAddGrpType = 4 AND FTAddRefCode = '" + $("#oetShpCodeEnd").val() + "' AND TCNMAddress_L.FNLngID = " + nLangEdits;
									}
								} else {
									// ????????????
									tFilter += "AND FTAddGrpType = 1 AND FTAddRefCode = '" + $("#oetBchCode").val() + "' AND TCNMAddress_L.FNLngID = " + nLangEdits;
								}
							} else {
								// ????????????
								tFilter += "AND FTAddGrpType = 1 AND FTAddRefCode = '" + $("#oetBchCode").val() + "' AND TCNMAddress_L.FNLngID = " + nLangEdits;
							}
						}
						return tFilter;
					}
				]
			},
			GrideView: {
				ColumnPathLang: 'document/purchaseorder/purchaseorder',
				ColumnKeyLang: ['tBrowseADDBch', 'tBrowseADDSeq', 'tBrowseADDV1No', 'tBrowseADDV1Soi', 'tBrowseADDV1Village', 'tBrowseADDV1Road', 'tBrowseADDV1SubDist', 'tBrowseADDV1DstCode', 'tBrowseADDV1PvnCode', 'tBrowseADDV1PostCode'],
				DataColumns: ['TCNMAddress_L.FTAddRefCode', 'TCNMAddress_L.FNAddSeqNo', 'TCNMAddress_L.FTAddV1No', 'TCNMAddress_L.FTAddV1Soi', 'TCNMAddress_L.FTAddV1Village', 'TCNMAddress_L.FTAddV1Road', 'TCNMAddress_L.FTAddV1SubDist', 'TCNMAddress_L.FTAddV1DstCode', 'TCNMAddress_L.FTAddV1PvnCode', 'TCNMAddress_L.FTAddV1PostCode', 'TCNMSubDistrict_L.FTSudName', 'TCNMDistrict_L.FTDstName', 'TCNMProvince_L.FTPvnName', 'TCNMAddress_L.FTAddV2Desc1', 'TCNMAddress_L.FTAddV2Desc2'],
				DataColumnsFormat: ['', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
				ColumnsSize: [''],
				DisabledColumns: [10, 11, 12, 13, 14],
				Perpage: 10,
				WidthModal: 50,
				OrderBy: ['TCNMAddress_L.FTAddRefCode'],
				SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["ohdShipAddSeqNo", "TCNMAddress_L.FNAddSeqNo"],
				Text: ["ohdShipAddSeqNo", "TCNMAddress_L.FNAddSeqNo"],
			},
			NextFunc: {
				FuncName: 'JSvTFWGetShipAddData',
				ArgReturn: ['FNAddSeqNo', 'FTAddV1No', 'FTAddV1Soi', 'FTAddV1Village', 'FTAddV1Road', 'FTSudName', 'FTDstName', 'FTPvnName', 'FTAddV1PostCode', 'FTAddV2Desc1', 'FTAddV2Desc2']
			},
			BrowseLev: 1
		}
		// Hide Pin Menu
		JSxCheckPinMenuClose();
		//option Ship Address 
		JCNxBrowseData('oTFWBrowseShipAdd');
	});

	$("#obtSearchShipVia").click(function(){
		$(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
		//option Ship Address 
		oTFWBrowseShipVia = {
			Title: ['document/producttransferwahouse/producttransferwahouse', 'tTFWShipViaModalTitle'],
			Table: {
				Master: 'TCNMShipVia',
				PK: 'FTViaCode'
			},
			Join: {
				Table: ['TCNMShipVia_L'],
				On: [
					"TCNMShipVia.FTViaCode = TCNMShipVia_L.FTViaCode AND TCNMShipVia_L.FNLngID = " + nLangEdits
				]
			},
			GrideView: {
				ColumnPathLang: 'document/producttransferwahouse/producttransferwahouse',
				ColumnKeyLang: ['tTFWShipViaCode', 'tTFWShipViaName'],
				DataColumns: ['TCNMShipVia.FTViaCode', 'TCNMShipVia_L.FTViaName'],
				DataColumnsFormat: ['', ''],
				ColumnsSize: [''],
				Perpage: 10,
				WidthModal: 50,
				OrderBy: ['TCNMShipVia.FTViaCode'],
				SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType: 'S',
				Value: ["oetViaCode", "TCNMShipVia.FTViaCode"],
				Text: ["oetViaName", "TCNMShipVia_L.FTViaName"],
			},
			BrowseLev: 1
		}
		// Hide Pin Menu
		JSxCheckPinMenuClose();
		//option Ship Address 
		JCNxBrowseData('oTFWBrowseShipVia');
	});

	$('#obtTFWBrowseSpl').click(function() {
		JCNxBrowseData('oTFWBrowseSpl');
	});
	$('#obtTFWBrowseShp').click(function() {
		JCNxBrowseData('oTFWBrowseShp');
	});

	$('#obtTFWBrowseWahTo').click(function() {
		JCNxBrowseData('oTFWBrowseWahTo');
	});
	$('#obtTFWBrowseRate').click(function() {
		JCNxBrowseData('oTFWBrowseRate');
	});

	//Option Promotion GrpBuy
	var oTFWBrowsePdt = {

		Title: ['product/product/product', 'tPDTTitle'],
		Table: {
			Master: 'TCNMPdt',
			PK: 'FTPdtCode'
		},
		Join: {
			Table: ['TCNMPdt_L', 'TCNMPdtPackSize', 'TCNMPdtUnit_L', 'TCNMPdtBar', 'TCNMPdtSpl', 'TCNTPdtPrice4PDT'],
			On: ['TCNMPdt_L.FTPdtCode 			= 	TCNMPdt.FTPdtCode AND TCNMPdt_L.FNLngID = ' + nLangEdits,
				"TCNMPdt.FTPdtCode					= 	TCNMPdtPackSize.FTPdtCode AND TCNMPdtPackSize.FCPdtUnitFact = '1'",
				'TCNMPdtPackSize.FTPunCode	= 	TCNMPdtUnit_L.FTPunCode AND TCNMPdtUnit_L.FNLngID=' + nLangEdits,
				'TCNMPdt.FTPdtCode					= 	TCNMPdtBar.FTPdtCode AND TCNMPdtPackSize.FTPunCode = TCNMPdtBar.FTPunCode',
				'TCNMPdt.FTPdtCode					= 	TCNMPdtSpl.FTPdtCode',
				'TCNTPdtPrice4PDT.FTPdtCode	= 	TCNMPdt.FTPdtCode  AND TCNTPdtPrice4PDT.FTPunCode  = TCNMPdtPackSize.FTPunCode AND TCNTPdtPrice4PDT.FTPghDocType = 1 AND TCNTPdtPrice4PDT.FDPghDStart <= GETDATE()',
			]
		},
		Where: {
			Condition: ["AND TCNMPdt.FTPdtType IN('1','2','4') AND TCNMPdt.FTPdtStaActive='1' AND TCNMPdt.FTPdtForSystem = '1' AND TCNMPdt.FTPdtStaActive = '1' "]
		},
		Filter: {
			Selector: 'oetSplCode',
			Table: 'TCNMPdtSpl',
			Key: 'FTSplCode'
		},
		GrideView: {
			ColumnPathLang: 'pos5/product',
			ColumnKeyLang: ['tPDTCode', 'tPDTName', 'tPDTTBUnit', 'tPDTTBPrice', ''],
			ColumnsSize: ['15%', '25%', '20%', '20%'],
			WidthModal: 50,
			DataColumns: ['TCNMPdt.FTPdtCode', 'TCNMPdt_L.FTPdtName', 'TCNMPdtUnit_L.FTPunName', 'TCNTPdtPrice4PDT.FCPgdPriceRET', 'TCNMPdtUnit_L.FTPunCode'],
			DataColumnsFormat: ['', '', '', ''],
			DisabledColumns: [4],
			Perpage: 10,
			OrderBy: ['TCNMPdt_L.FTPdtName'],
			SourceOrder: "ASC"
		},
		CallBack: {
			ReturnType: 'M',
			StaDoc: '1',
			StaSingItem: '1',
			Value: ["ohdTFWPdtCode", "TCNMPdt.FTPdtCode"],
			Text: ["ohdTFWPdtName", "TCNMPdt_L.FTPdtName"],

		},
		BrowsePdt: 1,
		NextFunc: {
			FuncName: 'JSxTFWAddPdtInRow',
			ArgReturn: ['FTPdtCode', 'FTPunCode']
		},
		RouteAddNew: 'product',
		BrowseLev: nStaTFWBrowseType,
		DebugSQL: 0,
	}
	//Option Promotion GrpBuy

	//Event Browse
	$('#obtTFWBrowsePdt').click(function() {
		JCNxBrowseProductData('oTFWBrowsePdt');
	});

	// put ?????????????????? Modal ?????? Input ???????????? Add
	function JSnTFWAddShipAdd() {
		tShipAddSeqNoSelect = $('#ohdShipAddSeqNo').val();
		$('#ohdXthShipAdd').val(tShipAddSeqNoSelect);

		$('#odvTFWBrowseShipAdd').modal('toggle');
	}


	function JSxTFWAddPdtInRow(poJsonData) {

		for (var n = 0; n < poJsonData.length; n++) {

			tdVal = $('.nItem' + n).data('otrval')

			if (tdVal != '' && tdVal == undefined) {

				nTRID = JCNnRandomInteger(100, 1000000);

				aColDatas = JSON.parse(poJsonData[n]);
				tPdtCode = aColDatas[0];
				tPunCode = aColDatas[1];
				FSvTFWAddPdtIntoTableDT(tPdtCode, tPunCode);

			}
		}

	}

	//Functionality : Select Spl To input
	//Parameters : -
	//Creator : 01/08/2018 Krit(Copter)
	//Return : View
	//Return Type : value to input
	function JSxTFWGetDataToFillSpl(poJsonData) {

		tOldSplCode = $('#ohdOldSplCode').val();
		tOldSplName = $('#oetOldSplName').val();
		tNewSplCode = $('#oetSplCode').val();

		bStaHavePdt = $('#odvPdtTablePanal tbody tr').hasClass('xCNDOCPdtItem');

		//Check ????????????????????????????????????????????? Spl ?????????????????????
		if (tOldSplCode != tNewSplCode && tOldSplCode != '' && bStaHavePdt === true) {

			bootbox.confirm({
				title: aLocale['tWarning'],
				message: 'Suplier ???????????????????????????????????????????????? Product ????????????????????????????????????????????????????????????????????????????????? ????????????????????????????????????????????????????????? ?',
				buttons: {
					cancel: {
						label: aLocale['tBtnConfirm'],
						className: 'xCNBTNPrimery'
					},
					confirm: {
						label: aLocale['tBtnClose'],
						className: 'xCNBTNDefult'
					}
				},
				callback: function(result) {
					if (result == false) {

						aJsonData = JSON.parse(poJsonData);
						nXthCrTerm = days = parseInt(aJsonData[0], 10); //
						tSplCrLimit = aJsonData[1] //
						tSplStaVATInOrEx = aJsonData[2] //
						tSplTspPaid = aJsonData[3] //
						tSplCode = aJsonData[4] //
						tSplName = aJsonData[5] //

						$('#ohdOldSplCode').val(tSplCode).trigger('change');
						$('#oetOldSplName').val(tSplName).trigger('change');

						//Put Data into Form
						//??????/??????????????????
						if (nXthCrTerm > 0) {
							$('#ostXthCshOrCrd').val('2').trigger('change');
						} else {
							$('#ostXthCshOrCrd').val('1').trigger('change');
						}
						//??????????????????????????????????????????
						$('#oetXthCrTerm').val(nXthCrTerm);

						//?????????????????????????????? 1.??????????????? 2.????????????????????????????????????
						if (tSplStaVATInOrEx == '') {
							tSplStaVATInOrEx = 1; //Def value 
						}
						$('#ostXthVATInOrEx').val(tSplStaVATInOrEx).trigger('change');

						dDocDate = $('#oetXthDocDate').val(); // Doc Date
						date = new Date($("#oetXthDocDate").val());


						if (!isNaN(date.getTime())) {
							date.setDate(date.getDate() + days);
							$('#oetXthDueDate').datepicker("setDate", date); //??????????????????????????????????????????????????????????????????????????????????????????????????????
						} else {
							alert("Please Enter Date");
							$('#oetXthDocDate').focus();
						}

						//?????????????????????????????????
						if (tSplTspPaid == '') {
							tSplTspPaid = 1; //Def value 
						}
						$('#ostXthDstPaid').val(tSplTspPaid).trigger('change');


						//???????????????????????? ???????????????????????? File
						JSnTFWRemoveAllDTInFile();

					} else {
						$('#oetSplCode').val(tOldSplCode).trigger('change');
						$('#oetSplName').val(tOldSplName).trigger('change');
					}
				}
			});

		} else {
			aJsonData = JSON.parse(poJsonData);
			nXthCrTerm = days = parseInt(aJsonData[0], 10); //
			tSplCrLimit = aJsonData[1] //
			tSplStaVATInOrEx = aJsonData[2] //
			tSplTspPaid = aJsonData[3] //
			tSplCode = aJsonData[4] //
			tSplName = aJsonData[5] //

			$('#ohdOldSplCode').val(tSplCode).trigger('change');
			$('#oetOldSplName').val(tSplName).trigger('change');

			//Put Data into Form
			//??????/??????????????????
			if (nXthCrTerm > 0) {
				$('#ostXthCshOrCrd').val('2').trigger('change');
			} else {
				$('#ostXthCshOrCrd').val('1').trigger('change');
			}
			//??????????????????????????????????????????
			$('#oetXthCrTerm').val(nXthCrTerm);

			//?????????????????????????????? 1.??????????????? 2.????????????????????????????????????
			if (tSplStaVATInOrEx == '') {
				tSplStaVATInOrEx = 1; //Def value 
			}
			$('#ostXthVATInOrEx').val(tSplStaVATInOrEx).trigger('change');

			dDocDate = $('#oetXthDocDate').val(); // Doc Date
			date = new Date($("#oetXthDocDate").val());


			if (!isNaN(date.getTime())) {
				date.setDate(date.getDate() + days);
				$('#oetXthDueDate').datepicker("setDate", date); //??????????????????????????????????????????????????????????????????????????????????????????????????????
			} else {
				alert("Please Enter Date");
				$('#oetXthDocDate').focus();
			}

			//?????????????????????????????????
			if (tSplTspPaid == '') {
				tSplTspPaid = 1; //Def value 
			}
			$('#ostXthDstPaid').val(tSplTspPaid).trigger('change');

		}

	}

	function JSxTFWGetWahFormShop(poJsonData) {

		if (poJsonData != undefined) {
			aData = JSON.parse(poJsonData);

			tWahCode = aData[0];
			tWahName = aData[1];

			if (tWahCode != '' && tWahCode != undefined) {
				$('#ohdWahCode').val(tWahCode);
				$('#oetWahCodeName').val(tWahName);
			} else {
				$('#ohdWahCode').val('');
				$('#oetWahCodeName').val('');

			}
		}

	}

	function FSvTFWAddHDDis() {

		tHDXthDisChgText = $('#ostXthHDDisChgText').val();
		cHDXthDis = $('#oetXddHDDis').val();
		tHDXthDocNo = $('#oetXthDocNo').val();
		tHDBchCode = $('#ohdSesUsrBchCode').val();

		nPlusOld = '';
		nPercentOld = '';
		tPlusNew = '';
		nPercentNew = '';
		tOldDisHDChgLength = '';

		if (tHDXthDisChgText == 1 || tHDXthDisChgText == 2) {
			tPlusNew = '+';
		}
		if (tHDXthDisChgText == 2 || tHDXthDisChgText == 4) {
			nPercentNew = '%';
		}

		//?????? length ??????????????????????????? ????????? HD
		$('.xWAlwEditXpdHDDisChgValue').each(function(e) {
			nDistypeOld = $(this).data('distype');
			if (nDistypeOld == 1 || nDistypeOld == 2) {
				nPlusOld = '+';
			}
			if (nDistypeOld == 2 || nDistypeOld == 4) {
				nPercentOld = '%';
			}
			tOldDisHDChgLength += nPlusOld + $(this).text() + nPercentOld + ','
		});
		tNewDisHDChgLength = tPlusNew + accounting.formatNumber(cHDXthDis, nOptDecimalSave, "") + nPercentNew;
		//??????????????????????????????????????????????????????
		tCurDisHDChgLength = tOldDisHDChgLength + tNewDisHDChgLength
		//?????????????????????????????????????????????
		nCurDisHDChgLength = tCurDisHDChgLength.length;

		if (cHDXthDis == '') {
			$('#oetXddHDDis').focus();
		} else {
			//Check ????????????????????? Text DisChgText
			if (nCurDisHDChgLength <= 20) {
				$.ajax({
					type: "TFWST",
					url: "ADJSTKVDAddHDDisIntoTable",
					data: {
						tHDXthDocNo: tHDXthDocNo,
						tHDBchCode: tHDBchCode,
						tHDXthDisChgText: tHDXthDisChgText,
						cHDXthDis: cHDXthDis
					},
					cache: false,
					timeout: 5000,
					success: function(tResult) {



					},
					error: function(jqXHR, textStatus, errorThrown) {
						(jqXHR, textStatus, errorThrown);
					}
				});
			} else {
				alert('??????????????????????????????????????????????????? ??????????????????????????????????????? 20');
			}

		}
	}

	$('#obtBrowseASTBCH').click(function(){ JCNxBrowseData('oBrowse_BCH'); });

	var oBrowse_BCH = {
           Title   : ['company/branch/branch','tBCHTitle'],
           Table   : {Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
           Join    : {
               Table   : ['TCNMBranch_L','TCNMWaHouse_L'],
               On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID ='+nLangEdits,
                           'TCNMBranch.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMBranch.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID ='+nLangEdits,
               ]
           },
           GrideView:{
               ColumnPathLang : 'company/branch/branch',
               ColumnKeyLang : ['tBCHCode','tBCHName',''],
               ColumnsSize     : ['15%','75%',''],
               WidthModal      : 50,
               DataColumns  : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName','TCNMWaHouse_L.FTWahCode','TCNMWaHouse_L.FTWahName'],
               DataColumnsFormat : ['',''],
               DisabledColumns   : [2,3],
               Perpage   : 5,
               OrderBy   : ['TCNMBranch_L.FTBchName'],
               SourceOrder  : "ASC"
           },
           CallBack:{
               ReturnType : 'S',
               Value  : ["oetBchCode","TCNMBranch.FTBchCode"],
               Text  : ["oetBchName","TCNMBranch_L.FTBchName"],
           },
           NextFunc    :   {
               FuncName    :   'JSxSetDefauleWahouse',
               ArgReturn   :   ['FTWahCode','FTWahName']
           }
       }
    
       function JSxSetDefauleWahouse(ptData){
           if(ptData == '' || ptData == 'NULL'){
               $('#ohdWahCodeStart').val('');
               $('#oetWahNameStart').val('');
           }else{
               var tResult = JSON.parse(ptData);
               $('#ohdWahCodeStart').val(tResult[0]);
               $('#oetWahNameStart').val(tResult[1]);
           }
	   }
	   // Event Browse Modal ??????????????????????????????
	   $('#obtASTBrowseWah').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hidden Pin Menu

                var tShpCode = $('#oetShpCodeStart').val();
                var tPosCode = $('#oetPosCodeStart').val();
                if(typeof(tShpCode) != undefined && tShpCode != "" && tPosCode == ""){
                    //????????????????????????????????? ShopWah  Where ShpCode
                    window.oASTBrowseShpWahOption = undefined;
                    oASTBrowseShpWahOption     = oASTBrowseShpWah({
                        'tASTBchCode'        : $('#oetBchCode').val(),
                        'tASTShpCode'        : $('#oetShpCodeStart').val(),
                        'tReturnInputCode'   : 'ohdWahCodeStart',
                        'tReturnInputName'   : 'oetWahNameStart',
                        'tNextFuncName'      : "JSxASTSetConditionWah",
                        'aArgReturn'         : []
                    });
                    JCNxBrowseData('oASTBrowseShpWahOption');
                }else{
                    //???????????????????????? Wahouse   Where RefCode
                    window.oASTBrowseWahOption  = undefined;
                    oASTBrowseWahOption         = oASTBrowseWah({
                        'tASTBchCode'       : $('#oetBchCode').val(),
                        'tASTShpCode'       : $('#oetShpCodeStart').val(),
                        'tASTPosCode'       : $('#oetPosCodeStart').val(),
                        'tReturnInputCode'  : "ohdWahCodeStart",
                        'tReturnInputName'  : "oetWahNameStart",
                        'tNextFuncName'     : "JSxASTSetConditionWah",
                        'aArgReturn'        : []
                    });
                    JCNxBrowseData('oASTBrowseWahOption');
                }
                
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
		        // Option Modal ??????????????????????????????
	var oASTBrowseWah       = function(poDataFnc){
		var tASTBchCode         = poDataFnc.tASTBchCode;
		var tASTShpCode         = poDataFnc.tASTShpCode;
		var tASTPosCode         = poDataFnc.tASTPosCode;
		var tInputReturnCode    = poDataFnc.tReturnInputCode;
		var tInputReturnName    = poDataFnc.tReturnInputName;
		var tNextFuncName       = poDataFnc.tNextFuncName;
		var aArgReturn          = poDataFnc.aArgReturn;
		var tWhereModal         = "";

		// Where ????????????????????? ????????????
		if(tASTShpCode == "" && tASTPosCode == ""){
			tWhereModal += " AND (TCNMWaHouse.FTWahStaType IN (1,2,5))";
		}

		// Where ????????????
		if(tASTBchCode  != ""){
			tWhereModal += " AND (TCNMWaHouse.FTBchCode = '"+tASTBchCode+"')";
		}

		// Where ????????????????????? ?????????????????????
		if(tASTShpCode  != "" && tASTPosCode == ""){
			tWhereModal += " AND (TCNMWaHouse.FTWahStaType IN (4))";
			tWhereModal += " AND (TCNMWaHouse.FTWahRefCode = '"+tASTShpCode+"')";
		}

		// Where ????????????????????? ???????????????????????????????????????
		if(tASTShpCode  != "" && tASTPosCode != ""){
			tWhereModal += " AND (TCNMWaHouse.FTWahStaType IN (6))";
			tWhereModal += " AND (TCNMWaHouse.FTWahRefCode = '"+tASTPosCode+"')";
		}

		var oOptionReturn       = {
			Title: ["company/warehouse/warehouse","tWAHTitle"],
			Table: { Master:"TCNMWaHouse", PK:"FTWahCode"},
			Join: {
				Table: ["TCNMWaHouse_L"],
				On: [
					"TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = '"+nLangEdits+"'"
				]
			},
			Where: {
				Condition : [tWhereModal]
			},
			GrideView:{
				ColumnPathLang: 'company/warehouse/warehouse',
				ColumnKeyLang: ['tWahCode','tWahName'],
				DataColumns: ['TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
				DataColumnsFormat: ['',''],
				ColumnsSize: ['15%','75%'],
				Perpage: 5,
				WidthModal: 50,
				OrderBy: ['TCNMWaHouse_L.FTWahName'],
				SourceOrder: "ASC"
			},
			CallBack: {
				ReturnType  : 'S',
				Value       : [tInputReturnCode,"TCNMWaHouse.FTWahCode"],
				Text        : [tInputReturnName,"TCNMWaHouse_L.FTWahName"]
			},
			NextFunc: {
				FuncName    : tNextFuncName,
				ArgReturn   : aArgReturn
			},
			DebugSQL : true,
			RouteAddNew: 'warehouse',
			BrowseLev : nStaTFWBrowseType
		};
		return oOptionReturn;
	}

        
	// Create By Napat(Jame) 25/03/63
	// Option Modal ?????????????????????????????? (?????????????????????)
	var oASTBrowseShpWah        = function(poDataFnc){
		var tASTBchCode         = poDataFnc.tASTBchCode;
		var tASTShpCode         = poDataFnc.tASTShpCode;
		var tInputReturnCode    = poDataFnc.tReturnInputCode;
		var tInputReturnName    = poDataFnc.tReturnInputName;
		var tNextFuncName       = poDataFnc.tNextFuncName;
		var aArgReturn          = poDataFnc.aArgReturn;
		var tWhereModal         = "";

		var oOptionReturn       = {
			Title: ["company/warehouse/warehouse","tWAHTitle"],
			Table: {Master:"TCNMShpWah",PK:"FTWahCode"},
			Join: {
				Table: ['TCNMWaHouse_L'],
				On: [
					'TCNMShpWah.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMShpWah.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits
				]
			},
			Where: {
				Condition: [
					" AND TCNMShpWah.FTBchCode = '" + tASTBchCode + "' ",
					" AND TCNMShpWah.FTShpCode = '" + tASTShpCode + "' "
				]
			},
			GrideView: {
				ColumnPathLang      : 'company/warehouse/warehouse',
				ColumnKeyLang       : ['tWahCode','tWahName'],
				ColumnsSize         : ['15%','75%'],
				WidthModal          : 50,
				DataColumns         : ['TCNMShpWah.FTWahCode','TCNMWaHouse_L.FTWahName'],
				DataColumnsFormat   : ['',''],
				// DisabledColumns     : [2,3,4,5],
				Perpage             : 10,
				OrderBy			    : ['TCNMShpWah.FTWahCode ASC'],
			},
			CallBack: {
				ReturnType	: 'S',
				Value		: [tInputReturnCode,"TCNMShpWah.FTWahCode"],
				Text		: [tInputReturnName,"TCNMWaHouse_L.FTWahName"],
			},
			NextFunc: {
				FuncName    : tNextFuncName,
				ArgReturn   : aArgReturn
			},
			RouteAddNew: 'warehouse',
			BrowseLev : nStaTFWBrowseType,
			// DebugSQL : true
		};
		return oOptionReturn;
	}

</script>