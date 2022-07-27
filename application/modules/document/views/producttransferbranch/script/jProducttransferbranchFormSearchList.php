<script type="text/javascript">

$(document).ready(function(){
	
	$('.selectpicker').selectpicker();

	$('#obtSearchDocDateFrom').click(function(){
		event.preventDefault();
		$('#oetSearchDocDateFrom').datepicker('show');
	});

	$('#obtSearchDocDateTo').click(function(){
		event.preventDefault();
		$('#oetSearchDocDateTo').datepicker('show');
	});

	$('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
	});

	$(".selection-2").select2({
		// minimumResultsForSearch: 20,
		dropdownParent: $('#dropDownSelect1')
	});

});

// Event Click On/Off Advance Search
$('#oahTBAdvanceSearch').unbind().click(function(){
	if($('#odvTBAdvanceSearchContainer').hasClass('hidden')){
		$('#odvTBAdvanceSearchContainer').removeClass('hidden').hide().slideDown(500);
	}else{
		$("#odvTBAdvanceSearchContainer").slideUp(500,function() {
			$(this).addClass('hidden');
		});
	}
});

// Advance Enter Search
$('#obtTBSubmitFrmSearchAdv').off('click').on('click',function(){
	JSvCallPageTBPdtDataTable();
});


//Option Branch From
var oPmhBrowseBchFrom = {
	
	Title : ['company/branch/branch','tBCHTitle'],
	Table:{Master:'TCNMBranch',PK:'FTBchCode'},
	Join :{
		Table:	['TCNMBranch_L'],
		On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
	},
	GrideView:{
		ColumnPathLang	: 'company/branch/branch',
		ColumnKeyLang	: ['tBCHCode','tBCHName'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
		DataColumnsFormat : ['',''],
		Perpage			: 10,
		OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
		// SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetBchCodeFrom","TCNMBranch.FTBchCode"],
		Text		: ["oetBchNameFrom","TCNMBranch_L.FTBchName"],
	},
}
//Option Branch From

//Option Branch To
var oPmhBrowseBchTo = {
	
	Title : ['company/branch/branch','tBCHTitle'],
	Table:{Master:'TCNMBranch',PK:'FTBchCode'},
	Join :{
		Table:	['TCNMBranch_L'],
		On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
	},
	GrideView:{
		ColumnPathLang	: 'company/branch/branch',
		ColumnKeyLang	: ['tBCHCode','tBCHName'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
		DataColumnsFormat : ['',''],
		Perpage			: 10,
		OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
		// SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetBchCodeTo","TCNMBranch.FTBchCode"],
		Text		: ["oetBchNameTo","TCNMBranch_L.FTBchName"],
	},
}
//Option Branch To

//Event Browse
$('#obtTBBrowseBchFrom').click(function(){ JCNxBrowseData('oPmhBrowseBchFrom'); });
$('#obtTBBrowseBchTo').click(function(){ JCNxBrowseData('oPmhBrowseBchTo'); });

</script>