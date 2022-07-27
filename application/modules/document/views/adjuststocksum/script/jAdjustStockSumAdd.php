
<script type="text/javascript">
nLangEdits = <?php echo $this->session->userdata("tLangEdit"); ?>;
tUsrApv = <?php echo $this->session->userdata("tSesUsername"); ?>;
            
// Disabled Enter in Form
$(document).keypress(
    function(event){
        if (event.which == '13') {
            event.preventDefault();
        }
    }
);

$(document).ready(function(){

    var nCountBch = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
    if(nCountBch == 1){
        $('#obtAdjStkSumBrowseBch').attr('disabled',true);
    }
    
    if(JCNbAdjStkSumIsUpdatePage()){
        // Doc No
        $("#oetAdjStkSumAjhDocNo").attr("readonly", true);
        $("#odvAdjStkSumSubAutoGenDocNoForm input").attr("disabled", true);
        $('#obtSMLoadDTStkSubToTemp').attr("disabled", true);
        JSxCMNVisibleComponent('#odvAdjStkSumSubAutoGenDocNoForm', false);
        
        JSxCMNVisibleComponent('#obtCardShiftOutBtnApv', true);
        JSxCMNVisibleComponent('#obtCardShiftOutBtnCancelApv', true);
        JSxCMNVisibleComponent('#obtCardShiftOutBtnDocMa', true);
    }
    
    if(JCNbAdjStkSumIsCreatePage()){
        // Doc No
        $("#oetAdjStkSumAjhDocNo").attr("disabled", true);
        $('#ocbAdjStkSumSubAutoGenCode').change(function(){
            if($('#ocbAdjStkSumSubAutoGenCode').is(':checked')) {
                $("#oetAdjStkSumAjhDocNo").attr("disabled", true);
                $('#odvAdjStkSumSubDocNoForm').removeClass('has-error');
                $('#odvAdjStkSumSubDocNoForm em').remove();
            }else{
                $("#oetAdjStkSumAjhDocNo").attr("disabled", false);
            }
        });
        JSxCMNVisibleComponent('#odvAdjStkSumSubAutoGenDocNoForm', true);
        
        JSxCMNVisibleComponent('#obtCardShiftOutBtnApv', false);
        JSxCMNVisibleComponent('#obtCardShiftOutBtnCancelApv', false);
        JSxCMNVisibleComponent('#obtCardShiftOutBtnDocMa', false);
    }
    JSvAdjStkSumLoadPdtDataTableHtml();
    console.log('JStCMNUserLevel: ', JStCMNUserLevel());
    // Condition control onload
    // if(JStCMNUserLevel() == 'HQ'){
    //     // Init
    //     $('#obtAdjStkSumBrowseMch').attr('disabled', false);
    //     $('#obtAdjStkSumBrowseShp').attr('disabled', true);
    //     $('#obtAdjStkSumBrowsePos').attr('disabled', false);
    //     $('#obtAdjStkSumBrowseWah').attr('disabled', false);
    // }
    
    // if(JStCMNUserLevel() == 'BCH'){
    //     // Init
    //     $('#obtAdjStkSumBrowseBch').attr('disabled', true);
    //     $('#obtAdjStkSumBrowseMch').attr('disabled', false);
    //     $('#obtAdjStkSumBrowseShp').attr('disabled', true);
    //     $('#obtAdjStkSumBrowsePos').attr('disabled', false);
    //     $('#obtAdjStkSumBrowseWah').attr('disabled', false);
    // }
    
    // if(JStCMNUserLevel() == 'SHP'){
    //     // Init
    //     console.log('SHP');
    //     $('#obtAdjStkSumBrowseBch').attr('disabled', true);
    //     $('#obtAdjStkSumBrowseMch').attr('disabled', true);
    //     $('#obtAdjStkSumBrowseShp').attr('disabled', true);
    //     $('#obtAdjStkSumBrowsePos').attr('disabled', false);
    //     $('#obtAdjStkSumBrowseWah').attr('disabled', false);
    // }
    
    $('#oliAdjStkSumMngPdtScan').click(function(){
        // Hide
        $('#oetAdjStkSumSearchPdtHTML').hide();
        $('#oimAdjStkSumMngPdtIconSearch').hide();
        // Show
        $('#oetAdjStkSumScanPdtHTML').show();
        $('#oimAdjStkSumMngPdtIconScan').show();
    });

    $('#oliAdjStkSumMngPdtSearch').click(function(){
        // Hide
        $('#oetAdjStkSumScanPdtHTML').hide();
        $('#oimAdjStkSumMngPdtIconScan').hide();
        // Show
        $('#oetAdjStkSumSearchPdtHTML').show();
        $('#oimAdjStkSumMngPdtIconSearch').show();
    });

    // DATE
    /*$('#obtXthDocDate').click(function(){
        event.preventDefault();
        $('#oetXthDocDate').datepicker('show');
    });

    $('#obtXthDocTime').click(function(){
        event.preventDefault();
        $('#oetXthDocTime').datetimepicker('show');
    });

    $('#obtXthRefExtDate').click(function(){
        event.preventDefault();
        $('#oetXthRefExtDate').datepicker('show');
    });

    $('#obtXthRefIntDate').click(function(){
        event.preventDefault();
        $('#oetXthRefIntDate').datepicker('show');
    });

    $('#obtXthTnfDate').click(function(){
        event.preventDefault();
        $('#oetXthTnfDate').datepicker('show');
    });*/
    // DATE

    $('.selectpicker').selectpicker();
	
    $('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
	autoclose: true,
        todayHighlight: true
    });
    
    $('.xCNTimePicker').datetimepicker({
        format: 'HH:mm:ss'
    });
	
    $('.xWTooltipsBT').tooltip({'placement': 'bottom'});
    $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});
        
    /*var tSpmCode = $('#oetSpmCode').val();

    $('#oetSplCode').change(function(){
        // Clear Modal Pdt เพื่อโหลดใหม่ตอนเปลี่ยน Spl
        $('#odvBrowsePdtPanal').html('');
    });
    
    $('#ostPmcGetCond').on('change', function (e) {
        var nSelected = $("option:selected", this);
        var nValue = this.value;
    	if(nValue == 1 || nValue == 3){
            // alert('ราคา')
            $('.xWCdGetValue').removeClass('xCNHide');
            $('.xWCdGetQty').addClass('xCNHide');
            $('.xWCdPerAvgDis').addClass('xCNHide');
        }else if(nValue == 2){
            // alert('จำนวน %')
            $('.xWCdGetValue').addClass('xCNHide');
            $('.xWCdGetQty').addClass('xCNHide');
            $('.xWCdPerAvgDis').removeClass('xCNHide');

        }else if(nValue == 4){
            // alert('จำนวน แต้ม')
            $('.xWCdGetValue').addClass('xCNHide');
            $('.xWCdGetQty').removeClass('xCNHide');
            $('.xWCdPerAvgDis').addClass('xCNHide');
        }

        $('#oetPmcGetQty').val('');
        $('#oetPmcGetValue').val('');
        $('#oetPmcPerAvgDis').val('');
    });*/

    /*// Set DocDate is Date Now	
    var dCurrentDate = new Date();
    var tAmOrPm = (dCurrentDate.getHours() < 12) ? "AM" : "PM";
    var tCurrentTime = dCurrentDate.getHours() + ":" + dCurrentDate.getMinutes() + " " + tAmOrPm;

    if($('#oetXthDocDate').val() =='' ){
        $('#oetXthDocDate').datepicker("setDate",dCurrentDate); // Doc Date
    }
    if($('#oetXthTnfDate').val() =='' ){
        $('#oetXthTnfDate').datepicker("setDate",dCurrentDate); // 
    }
    // Set DocTime is Time Now	
    if($('#oetXthDocTime').val() =='' ){
        $('#oetXthDocTime').val(tCurrentTime);
    }

    $('#ostXthVATInOrEx').on('change', function (e) {
        JSvAdjStkSumLoadPdtDataTableHtml(); // คำนวนท้ายบิลใหม่
    });*/
});

/*var oAdjStkSumBrowseSpl = {
    Title: ['supplier/supplier/supplier', 'tSPLTitle'],
    Table: {Master:'TCNMSpl', PK:'FTSplCode'},
    Join: {
        Table: ['TCNMSpl_L','TCNMSplCredit'],
        On: ['TCNMSpl_L.FTSplCode = TCNMSpl.FTSplCode AND TCNMSpl_L.FNLngID = '+nLangEdits,
            'TCNMSpl_L.FTSplCode = TCNMSplCredit.FTSplCode'
        ]
    },
    Where:{
        Condition : ["AND TCNMSpl.FTSplStaActive = '1' "]
    },
    GrideView:{
        ColumnPathLang	: 'supplier/supplier/supplier',
        ColumnKeyLang	: ['tSPLTBCode', 'tSPLTBName'],
        ColumnsSize     : ['15%', '75%'],
    WidthModal      : 50,
        DataColumns		: ['TCNMSpl.FTSplCode', 'TCNMSpl_L.FTSplName', 'TCNMSplCredit.FNSplCrTerm', 'TCNMSplCredit.FCSplCrLimit', 'TCNMSpl.FTSplStaVATInOrEx', 'TCNMSplCredit.FTSplTspPaid'],
        DataColumnsFormat : ['',''],
        DisabledColumns: [2, 3, 4, 5],
        Perpage: 5,
        OrderBy: ['TCNMSpl_L.FTSplName'],
        SourceOrder: "ASC"
    },
    CallBack:{
        ReturnType: 'S',
        Value: ["oetSplCode", "TCNMSpl.FTSplCode"],
        Text: ["oetSplName", "TCNMSpl_L.FTSplName"]
    },
    NextFunc:{
        FuncName:'JSxAdjStkSumGetDataToFillSpl',
        ArgReturn:['FNSplCrTerm', 'FCSplCrLimit', 'FTSplStaVATInOrEx', 'FTSplTspPaid', 'FTSplCode', 'FTSplName']
    },
    RouteAddNew: 'supplier',
    BrowseLev: nStaAdjStkSumBrowseType

};*/
// Option Suplier

// Option SalePerson
/*var oAdjStkSumBrowseSpn = {
	
    Title: ['pos5/saleperson', 'tSPNTitle'],
    Table: {Master:'TCNMSpn', PK:'FTSpnCode'},
    Join: {
        Table: ['TCNMSpn_L'],
        On: ['TCNMSpn_L.FTSpnCode = TCNMSpn.FTSpnCode AND TCNMSpn_L.FNLngID = '+nLangEdits]
    },
    GrideView: {
        ColumnPathLang: 'pos5/saleperson',
        ColumnKeyLang: ['tSPNCode', 'tSPNName', '', '', ''],
        ColumnsSize: ['15%', '75%'],
        WidthModal: 50,
        DataColumns: ['TCNMSpn.FTSpnCode', 'TCNMSpn_L.FTSpnName'],
        DataColumnsFormat: ['', ''],
        DisabledColumns	:[2, 3, 4],
        Perpage: 5,
        OrderBy: ['TCNMSpn_L.FTSpnName'],
        SourceOrder: "ASC"
    },
    CallBack: {
        ReturnType: 'S',
        Value: ["oetSpnCode", "TCNMSpn.FTSpnCode"],
        Text: ["oetSpnName", "TCNMSpn_L.FTSpnName"]
    },
    RouteAddNew: 'suplier',
    BrowseLev: nStaAdjStkSumBrowseType
};*/

// Option SalePerson
/*var nLangEdits;
var oPmhBrowseBch;
var oAdjStkSumBrowseMch;
var oAdjStkSumBrowseShpStart;
var oAdjStkSumBrowsePosStart;
var obtAdjStkSumBrowseWahStart;
var oAdjStkSumBrowseShpEnd;
var oAdjStkSumBrowsePosEnd;
var obtAdjStkSumBrowseWahEnd;
var oAdjStkSumBrowseShipAdd;
var tOldBchCkChange = "";
var tOldMchCkChange = "";
var tOldShpStartCkChange = "";
var tOldShpEndCkChange = "";*/

/*========================= Begin Browse Options =============================*/

// สาขา 
$('#obtAdjStkSumBrowseBch').click(function(){ 

    if($('.xWPdtItem').length>0){
        if(confirm("<?=language('document/adjuststocksum/adjuststocksum','tAdjStkSumMassesChange')?>")==true){
                    JSxDocSMClearPdtInTmp();
        }   
    }

    // $(".modal.fade:not(#odvAdjStkSumBrowseShipAdd, #odvModalDOCPDT, #odvModalWanning)").remove();
    tOldBchCkChange = $("#oetBchCode").val();
    // Lang Edit In Browse
    nLangEdits = <?php echo $this->session->userdata("tLangEdit")?>;

    var tUsrLevel     = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
    var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";   
    var tWhere = "";
 
    if(tUsrLevel != "HQ"){
        tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
    }else{
        tWhere = "";
    }


    // Option Branch
    oPmhBrowseBch = {
        Title: ['company/branch/branch', 'tBCHTitle'],
        Table: {Master:'TCNMBranch', PK:'FTBchCode'},
        Join: {
            Table: ['TCNMBranch_L'],
            On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
        },
        Where : {
                        Condition : [tWhere]
                    },
        GrideView:{
            ColumnPathLang: 'company/branch/branch',
            ColumnKeyLang: ['tBCHCode', 'tBCHName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
            DataColumnsFormat: ['', ''],
            DisabledColumns: [],
            Perpage: 5,
            OrderBy: ['TCNMBranch_L.FTBchName'],
            SourceOrder: "ASC"
        },
        CallBack:{
            ReturnType: 'S',
            Value: ["oetAdjStkSumBchCode", "TCNMBranch.FTBchCode"],
            Text: ["oetAdjStkSumBchName", "TCNMBranch_L.FTBchName"]
        },
        NextFunc:{
            FuncName: 'JSxAdjStkSumCallbackAfterSelectBch',
            ArgReturn: ['FTBchCode', 'FTBchName']
        },
        RouteFrom: 'promotion',
        RouteAddNew: 'branch',
        BrowseLev: 2
    };
    // Option Branch
    JCNxBrowseData('oPmhBrowseBch');

});

// กลุ่มร้านค้า
$('#obtAdjStkSumBrowseMch').click(function(){
    // $(".modal.fade:not(#odvAdjStkSumBrowseShipAdd, #odvModalDOCPDT, #odvModalWanning)").remove();
    tOldMchCkChange = $("#oetMchCode").val();
    // Option merchant
    oAdjStkSumBrowseMch = {
        Title: ['company/warehouse/warehouse', 'tWAHBwsMchTitle'],
        Table: {Master:'TCNMMerchant', PK:'FTMerCode'}, 
        Join: {
            Table: ['TCNMMerchant_L'], 
            On: ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = '+nLangEdits]
        },
        Where: {
            Condition: ["AND (SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '"+$("#ohdAdjStkSumBchCode").val()+"') != 0"]
        },
        GrideView: {
            ColumnPathLang: 'company/warehouse/warehouse',
            ColumnKeyLang: ['tWAHBwsMchCode', 'tWAHBwsMchNme'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
            DataColumnsFormat: ['',''],
            Perpage: 5,
            OrderBy: ['TCNMMerchant.FTMerCode'],
            SourceOrder: "ASC"
        },
        CallBack:{
            ReturnType: 'S',
            Value: ["oetAdjStkSumMchCode", "TCNMMerchant.FTMerCode"],
            Text: ["oetAdjStkSumMchName", "TCNMMerchant_L.FTMerName"]
        },
        NextFunc:{
            FuncName:'JSxAdjStkSumCallbackAfterSelectMer',
            ArgReturn:['FTMerCode', 'FTMerName']
        },
        BrowseLev: 1
    };
    // Option merchant
    JCNxBrowseData('oAdjStkSumBrowseMch');
});

// ร้านค้า
$('#obtAdjStkSumBrowseShp').click(function(){
    console.log('Mer: ', $("#oetAdjStkSumMchCode").val());
    // $(".modal.fade:not(#odvAdjStkSumBrowseShipAdd, #odvModalDOCPDT, #odvModalWanning)").remove();
    // Option Shop
    oAdjStkSumBrowseShp = {
        Title : ['company/shop/shop', 'tSHPTitle'],
        Table:{Master: 'TCNMShop', PK: 'FTShpCode'},
        Join :{
            Table: ['TCNMShop_L', 'TCNMWaHouse_L'],
            On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                'TCNMShop.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID= '+nLangEdits
            ]
        },
        Where:{
            Condition : [
                function(){
                    var tSQL = "AND TCNMShop.FTBchCode = '"+$("#ohdAdjStkSumBchCode").val()+"' AND TCNMShop.FTMerCode = '"+$("#oetAdjStkSumMchCode").val()+"'";
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
            DisabledColumns:[2, 3, 4, 5],
            Perpage: 5,
            OrderBy: ['TCNMShop_L.FTShpName'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetAdjStkSumShpCode", "TCNMShop.FTShpCode"],
            Text: ["oetAdjStkSumShpName", "TCNMShop_L.FTShpName"]
        },
        NextFunc: {
            FuncName: 'JSxAdjStkSumCallbackAfterSelectShp',
            ArgReturn: ['FTBchCode', 'FTShpCode', 'FTShpType', 'FTWahCode', 'FTWahName']
        },
        BrowseLev: 1
    };
    // Option Shop
    JCNxBrowseData('oAdjStkSumBrowseShp');
});

// เครื่องจุดขาย
$('#obtAdjStkSumBrowsePos').click(function(){ 
    var tAdjBchCode = $("#oetAdjStkSumBchCode").val();
    var tWhereModal         = "";
    if(typeof(tAdjBchCode) != undefined && tAdjBchCode != ""){
        tWhereModal += " AND (TCNMPos.FTBchCode = '"+tAdjBchCode+"') AND TCNMPos.FTPosStaUse = 1 AND TCNMWaHouse.FTWahCode != ''AND FTPosType <>'4'";
    }

    oAdjStkSumBrowsePos = {
        Title: ['pos/posshop/posshop', 'tPshTBPosCode'],
        Table: { Master:'TCNMPos', PK:'FTPosCode' },
        Join: {
            Table: ['TCNMPos_L', 'TCNMBranch_L','TCNMWaHouse','TCNMWaHouse_L'],
            On: [
                        'TCNMPos_L.FTBchCode = TCNMPos.FTBchCode AND TCNMPos_L.FTPosCode = TCNMPos.FTPosCode AND TCNMPos_L.FNLngID = ' + nLangEdits,
                        'TCNMPos.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits,
                        'TCNMWaHouse.FTWahRefCode = TCNMPos.FTPosCode AND TCNMWaHouse.FTBchCode = TCNMPos.FTBchCode AND TCNMWaHouse.FTWahStaType in(1,2)',
                        'TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits
                ]
        },
        Where: {
            Condition: [tWhereModal]
        },
        GrideView: {
            ColumnPathLang: 'pos/posshop/posshop',
            ColumnKeyLang: ['tPshBRWShopTBCode', 'tPshBRWPosTBName'],
            ColumnsSize: ['25%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMPos.FTPosCode', 'TCNMPos_L.FTPosName','TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat: ['', '','',''],
            DisabledColumns : [2,3],
            Perpage: 10,
            OrderBy: ['TCNMPos.FDCreateOn DESC, TCNMPos.FTPosCode ASC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetAdjStkSumPosCode", "TCNMPos.FTPosCode"],
            Text: ["oetAdjStkSumPosName", "TCNMPos_L.FTPosName"]
        },
        NextFunc: {
            FuncName: 'JSxAdjStkSumCallbackAfterSelectPos',
            ArgReturn: ['FTPosCode','FTPosName','FTWahCode','FTWahName']
        },
        BrowseLev: 1

    };
    // Option Shop
    JCNxBrowseData('oAdjStkSumBrowsePos');
});

// คลังสินค้า
$('#obtAdjStkSumBrowseWah').click(function(){


    if($('.xWPdtItem').length>0){
        if(confirm('<?=language('document/adjuststocksum/adjuststocksum','tAdjStkSumMassesChange')?>')==true){
                    JSxDocSMClearPdtInTmp();
        }   
    }
    var tAdjBchCode = $('#ohdAdjStkSumBchCode').val();
    var tAdjPosCode = $('#oetAdjStkSumPosCode').val();
    var tWhereModal = "";
    if(tAdjBchCode  != ""){
        tWhereModal += " AND (TCNMWaHouse.FTBchCode = '"+tAdjBchCode+"')";
    }
    if(tAdjPosCode != ""){
        tWhereModal += " AND (TCNMWaHouse.FTWahStaType IN (1,2))";
        tWhereModal += " AND (TCNMWaHouse.FTWahRefCode = '"+tAdjPosCode+"')";
    }
    // $(".modal.fade:not(#odvAdjStkSumBrowseShipAdd, #odvModalDOCPDT, #odvModalWanning)").remove();
    // Option WareHouse
    oAdjStkSumBrowseWah = {
        
        Title: ['company/warehouse/warehouse', 'tWAHTitle'],
        Table: { Master:'TCNMWaHouse', PK:'FTWahCode'},
        Join: {
            Table: ['TCNMWaHouse_L'],
            On:['TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = '+nLangEdits]
        },
        Where: {
            Condition: [tWhereModal]
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
        CallBack:{
            ReturnType: 'S',
            Value: ["oetAdjStkSumWahCode","TCNMWaHouse.FTWahCode"],
            Text: ["oetAdjStkSumWahName","TCNMWaHouse_L.FTWahName"]
        },

        RouteAddNew: 'warehouse',
        BrowseLev: nStaAdjStkSumBrowseType
    };
    // Option WareHouse
    JCNxBrowseData('oAdjStkSumBrowseWah');
});

// เหตุผล
$('#obtAdjStkSumBrowseReason').click(function(){
    // $(".modal.fade:not(#odvAdjStkSumBrowseShipAdd, #odvModalDOCPDT, #odvModalWanning)").remove();
    // Option WareHouse
    oAdjStkSumBrowseReason = {
            Title: ['other/reason/reason', 'tRSNTitle'],
            Table: { Master:'TCNMRsn', PK:'FTRsnCode' },
            Join: {
                Table: ['TCNMRsn_L'],
                On: ['TCNMRsn_L.FTRsnCode = TCNMRsn.FTRsnCode AND TCNMRsn_L.FNLngID = '+nLangEdits]
            },
            Where: {
                Condition : ["AND TCNMRsn.FTRsgCode = '008' "]
            },
            GrideView:{
                ColumnPathLang: 'other/reason/reason',
                ColumnKeyLang: ['tRSNTBCode', 'tRSNTBName'],
                // ColumnsSize: ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TCNMRsn.FTRsnCode', 'TCNMRsn_L.FTRsnName'],
                DisabledColumns: [],
                DataColumnsFormat: ['', ''],
                Perpage: 5,
                OrderBy: ['TCNMRsn_L.FTRsnName'],
                SourceOrder: "ASC"
            },
            CallBack:{
                ReturnType: 'S',
                Value: ["oetAdjStkSumReasonCode", "TCNMRsn.FTRsnCode"],
                Text: ["oetAdjStkSumReasonName", "TCNMRsn_L.FTRsnName"]
            },
            /*NextFunc:{
                FuncName:'JSxCSTAddSetAreaCode',
                ArgReturn:['FTRsnCode']
            },*/
            // RouteFrom : 'cardShiftChange',
            RouteAddNew : 'reason',
            BrowseLev : nStaAdjStkSumBrowseType
    };
    // Option WareHouse
    JCNxBrowseData('oAdjStkSumBrowseReason');
});

/*=========================== End Browse Options =============================*/

/*=================== Begin Callback Browse ==================================*/
/**
 * สาขา
 * Functionality : Process after shoose branch
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxAdjStkSumCallbackAfterSelectBch(poJsonData) {
    if (poJsonData != "NULL") {
        $('#obtAdjStkSumBrowsePos').attr('disabled', false);
        $('#obtAdjStkSumBrowseWah').attr('disabled', false);
    }else{
        $('#obtAdjStkSumBrowsePos').attr('disabled', true);
        $('#obtAdjStkSumBrowseWah').attr('disabled', true);
    }
    $('#oetAdjStkSumPosCode').val('');
    $('#oetAdjStkSumPosName').val('');
    $('#oetAdjStkSumWahName').val('');
    $('#oetAdjStkSumWahCode').val('');

    // if (poJsonData != "NULL") {
    //     // aData = JSON.parse(poJsonData);
    //     // tAddBch = aData[0];
    //     // tAddSeqNo = aData[1];
    //     $('#obtAdjStkSumBrowsePos').attr('disabled', false);
    //     if(JStCMNUserLevel() == 'HQ'){
    //         var tBchCode = $('#ohdAdjStkSumBchCode').val();

    //         if(tBchCode != ''){
    //             $('#obtAdjStkSumBrowsePos').attr('disabled', false);
    //         }else{
    //             $('#obtAdjStkSumBrowsePos').attr('disabled', true);
    //         }
    //     }
    // }else{
    //     $('#obtAdjStkSumBrowsePos').attr('disabled', true);
    // }

    // $('#oetAdjStkSumWahCode').val('');
    // $('#oetAdjStkSumWahName').val('');
    // $('#oetAdjStkSumPosCode').val('');
    // $('#oetAdjStkSumPosName').val('');
    


    // var tBchCode = $('#ohdAdjStkSumBchCode').val();
    // var tMchName = $('#oetAdjStkSumMchName').val();
    // var tShpName = $('#oetAdjStkSumShpName').val();
    // var tWahName = $('#oetAdjStkSumWahName').val();
    
    // $('#obtAdjStkSumBrowseMch').attr('disabled', true);
    // $('#obtAdjStkSumBrowseShp').attr('disabled', true);
    
    // $('#obtAdjStkSumBrowseWah').attr('disabled', true);
}

/**
 * กลุ่มร้านค้า
 * Functionality : Process after shoose merchant
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxAdjStkSumCallbackAfterSelectMer(poJsonData) {
    
    if (poJsonData != "NULL") {
        aData = JSON.parse(poJsonData);
        tAddBch = aData[0];
        tAddSeqNo = aData[1];
    }
    
    var tBchCode = $('#ohdAdjStkSumBchCode').val();
    var tMchName = $('#oetAdjStkSumMchName').val();
    var tShpName = $('#oetAdjStkSumShpName').val();
    var tPosName = $('#oetAdjStkSumPosName').val();
    var tWahName = $('#oetAdjStkSumWahName').val();
    
    $('#obtAdjStkSumBrowseShp').attr('disabled', true);
    $('#obtAdjStkSumBrowsePos').attr('disabled', true);
    $('#obtAdjStkSumBrowseWah').attr('disabled', true);
    
    if(JStCMNUserLevel() == 'HQ' || JStCMNUserLevel() == 'BCH'){
        if(tMchName != ''){
            $('#obtAdjStkSumBrowseShp').attr('disabled', false);
            $('#obtAdjStkSumBrowseWah').attr('disabled', true);
        }else{
            $('#obtAdjStkSumBrowseWah').attr('disabled', false);
        }
        $('#oetAdjStkSumShpCode, #oetAdjStkSumShpName').val('');
        $('#oetAdjStkSumPosCode, #oetAdjStkSumPosName').val('');
        $('#oetAdjStkSumWahCode, #oetAdjStkSumWahName').val('');
    }
}

/**
 * ร้านค้า
 * Functionality : Process after shoose shop
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxAdjStkSumCallbackAfterSelectShp(poJsonData) {
    
    var aData, tResAddBch, tResAddSeqNo, tResWahCode, tResWahName;
    if (poJsonData != "NULL") {
        aData = JSON.parse(poJsonData);
        tResAddBch = aData[0];
        tResAddSeqNo = aData[1];
        tResWahCode = aData[3];
        tResWahName = aData[4];
    }else{
        $('#oetAdjStkSumWahCode, #oetAdjStkSumWahName').val('');
    }
    console.log('aData: ', aData);
    $('#ohdAdjStkSumWahCodeInShp').val(tResWahCode);
    $('#ohdAdjStkSumWahNameInShp').val(tResWahName);
    var tBchCode = $('#ohdAdjStkSumBchCode').val();
    var tMchName = $('#oetAdjStkSumMchName').val();
    var tShpName = $('#oetAdjStkSumShpName').val();
    var tPosName = $('#oetAdjStkSumPosName').val();
    var tWahName = $('#oetAdjStkSumWahName').val();
    
    $('#obtAdjStkSumBrowsePos').attr('disabled', true);
    $('#obtAdjStkSumBrowseWah').attr('disabled', false);
    
    if(JStCMNUserLevel() == 'HQ' || JStCMNUserLevel() == 'BCH'){
        if(tShpName != ''){
            $('#obtAdjStkSumBrowsePos').attr('disabled', false);
            $('#obtAdjStkSumBrowseWah').attr('disabled', true);
            $('#oetAdjStkSumWahCode').val(tResWahCode);
            $('#oetAdjStkSumWahName').val(tResWahName);
        }else{
            $('#oetAdjStkSumWahCode, #oetAdjStkSumWahName').val('');
        }
        $('#oetAdjStkSumPosCode, #oetAdjStkSumPosName').val('');
    }
}

/**
 * เครื่องจุดขาย
 * Functionality : Process after shoose pos
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxAdjStkSumCallbackAfterSelectPos(poJsonData) {
    if (poJsonData != "NULL") {
        aData = JSON.parse(poJsonData);
        $('#obtAdjStkSumBrowseWah').attr('disabled', true);
        $('#oetAdjStkSumWahCode').val(aData[2])
        $('#oetAdjStkSumWahName').val(aData[3])
    }else{
        $('#obtAdjStkSumBrowseWah').attr('disabled', false);
        $('#oetAdjStkSumWahCode').val('')
        $('#oetAdjStkSumWahName').val('')
    }

    // var aData, tResAddBch, tResAddSeqNo, tResWahCode, tResWahName;
    // if (poJsonData != "NULL") {
    //     aData = JSON.parse(poJsonData);
    //     tResAddBch = aData[0];
    //     tResAddSeqNo = aData[1];
    //     tResWahCode = aData[3];
    //     tResWahName = aData[4];
    // }else{
    //     $('#oetAdjStkSumPosCode, #oetAdjStkSumPosName').val('');
    //     $('#oetAdjStkSumWahCode').val($('#ohdAdjStkSumWahCodeInShp').val());
    //     $('#oetAdjStkSumWahName').val($('#ohdAdjStkSumWahNameInShp').val());
    //     return;
    // }
    // console.log('aData Pos: ', aData);
    
    // var tBchCode = $('#ohdAdjStkSumBchCode').val();
    // var tMchName = $('#oetAdjStkSumMchName').val();
    // var tShpName = $('#oetAdjStkSumShpName').val();
    // var tPosName = $('#oetAdjStkSumPosName').val();
    // var tWahName = $('#oetAdjStkSumWahName').val();
    
    // $('#obtAdjStkSumBrowseWah').attr('disabled', false);
    
    // if(JStCMNUserLevel() == 'HQ' || JStCMNUserLevel() == 'BCH' || JStCMNUserLevel() == 'SHP'){
    //     if(tPosName != ''){
    //         $('#obtAdjStkSumBrowseWah').attr('disabled', false);
    //         $('#oetAdjStkSumWahCode').val(tResWahCode);
    //         $('#oetAdjStkSumWahName').val(tResWahName);
    //     }
    // }
}

/**
 * คลังสินค้า
 * Functionality : Process after shoose warehouse
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxAdjStkSumCallbackAfterSelectWah(poJsonData) {
    
    if (poJsonData != "NULL") {
        aData = JSON.parse(poJsonData);
        tAddBch = aData[0];
        tAddSeqNo = aData[1];
    }
    
}


function JSxAdjStkSumAddPdtInRow(poJsonData){
    for (var n = 0; n < poJsonData.length; n++) {

        var tdVal = $('.nItem'+n).data('otrval')

        if((tdVal != '') && (typeof tdVal == 'undefined')){

            nTRID = JCNnRandomInteger(100, 1000000);

            var aColDatas = JSON.parse(poJsonData[n]);
            var tPdtCode = aColDatas[0];
            var tPunCode = aColDatas[1];
            FSvAdjStkSumAddPdtIntoTableDT(tPdtCode, tPunCode);

        }
    }
}




/**
* Functionality : Load StockSub DT
* Parameters : -
* Creator : 16/07/2020 nale
* Last Modified : -
* Return : Approve status
* Return Type : boolean
*/
function JSxDocSMLoadDTStkSubToTemp(){




   var ptXthDocNo = $("#oetAdjStkSumAjhDocNo").val();
   var ptBchCode = $("#oetAdjStkSumBchCode").val();
   var ptWahCode = $("#oetAdjStkSumWahCode").val();
    if($('#oetAdjStkSumBchName').val()==''){
       var tMsgBody = 'กรุณาระบุสาขา';
        FSvCMNSetMsgWarningDialog(tMsgBody);
        return false;
    }

    if(ptWahCode==''){
       var tMsgBody = 'กรุณาระบคลัง';
        FSvCMNSetMsgWarningDialog(tMsgBody);
        return false;
    }

    JCNxOpenLoading();

    $.ajax({
        type: "POST",
        url: "docSMEventCallPdtStkSum",
        data: {
            ptXthDocNo: ptXthDocNo,
            ptBchCode: ptBchCode,
            ptWahCode: ptWahCode
        },
        cache: false,
        timeout: 5000,
        success: function (tResult) {
            oResult = JSON.parse(tResult);
            var tMarkUp = '';
            for(var nI = 0 ; nI < oResult.length ; nI++){
                tMarkUp +="<input  type='hidden' name='ohdSMXtdDocNoRef[]' value='"+oResult[nI].FTAjhDocNo+"'>";
            }
            $('#ohddocSMDocRef').html(tMarkUp);
            JSvAdjStkSumLoadPdtDataTableHtml();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });


}

/**
* Functionality : Check Approve
* Parameters : -
* Creator : 24/05/2019 Piya
* Last Modified : -
* Return : Approve status
* Return Type : boolean
*/
function JSbAdjStkSumIsApv(){
    var bStatus = false;
    if(($("#ohdAdjStkSumAjhStaApv").val() == "1") || ($("#ohdAdjStkSumAjhStaApv").val() == "2")){
        bStatus = true;
    }
    return bStatus;
}

/**
* Functionality : Check Approve
* Parameters : -
* Creator : 24/05/2019 Piya
* Last Modified : -
* Return : Approve status
* Return Type : boolean
*/
function JSbAdjStkSumIsStaPrcStk(){
    var bStatus = false;
    if($("#ohdAdjStkSumAjhStaPrcStk").val() == "1"){
        bStatus = true;
    }
    return bStatus;
}

/**
* Functionality : Check document status
* Parameters : ptStaType is ("complete", "incomplete", "cancel")
* Creator : 24/05/2019 Piya
* Last Modified : -
* Return : Document status
* Return Type : boolean
*/
function JSbAdjStkSumIsStaDoc(ptStaType){
    var bStatus = false;
    if(ptStaType == "complete"){
        if($("#ohdAdjStkSumAjhStaDoc").val() == "1"){
            bStatus = true;
        }
        return bStatus;
    }
    if(ptStaType == "incomplete"){
        if($("#ohdAdjStkSumAjhStaDoc").val() == "2"){
            bStatus = true;
        }
        return bStatus;
    }
    if(ptStaType == "cancel"){
        if($("#ohdAdjStkSumAjhStaDoc").val() == "3"){
            bStatus = true;
        }
        return bStatus;
    }
    return bStatus;
}

/*============================= Begin Custom Form Validate ===================*/

var bUniqueAdjStkSumCode;
$.validator.addMethod(
    "uniqueAdjStkSumCode", 
    function(tValue, oElement, aParams) {
        var tAdjStkSumCode = tValue;
        $.ajax({
            type: "POST",
            url: "adjStkSumUniqueValidate/docAdjStkSumCode",
            data: "tAdjStkSumCode=" + tAdjStkSumCode,
            dataType:"html",
            success: function(ptMsg)
            {
                // If vatrate and vat start exists, set response to true
                bUniqueAdjStkSumCode = (ptMsg == 'true') ? false : true;                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Custom validate uniqueAdjStkSumCode: ', jqXHR, textStatus, errorThrown);
            },
            async: false
        });
        return bUniqueAdjStkSumCode;
    },
    "Adjust Stock Doc Code is Already Taken"
);

// Override Error Message
jQuery.extend(jQuery.validator.messages, {
    required: "This field is required.",
    remote: "Please fix this field.",
    email: "Please enter a valid email address.",
    url: "Please enter a valid URL.",
    date: "Please enter a valid date.",
    dateISO: "Please enter a valid date (ISO).",
    number: "Please enter a valid number.",
    digits: "Please enter only digits.",
    creditcard: "Please enter a valid credit card number.",
    equalTo: "Please enter the same value again.",
    accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
    minlength: jQuery.validator.format("Please enter at least {0} characters."),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
    min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
});

/*============================= End Custom Form Validate =====================*/

/**
* Functionality : Form validate
* Parameters : -
* Creator : 24/05/2019 Piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxValidateFormAddAdjStkSum() {
    $('#ofmAddAdjStkSum').validate({
        focusInvalid: true,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            oetAdjStkSumAjhDocNo: {
                required: true,
                maxlength: 20,
                uniqueAdjStkSumCode: JCNbAdjStkSumIsCreatePage()
            },
            oetAdjStkSumAjhDocDate: {
                required: true
            },
            oetAdjStkSumAjhDocTime: {
                required: true
            },
            oetAdjStkSumWahCode: {
                required: true
            },
            oetAdjStkSumWahName: {
                required: true
            },
            oetAdjStkSumReasonCode: {
                required: true
            },
            oetAdjStkSumReasonName: {
                required: true
            }
        },
        messages: {
            oetAdjStkSumAjhDocNo: {
                "required": $('#oetAdjStkSumAjhDocNo').attr('data-validate-required')
            }
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            error.addClass("help-block");
            if (element.prop("type") === "checkbox") {
                error.appendTo(element.parent("label"));
            } else {
                var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                if (tCheck == 0) {
                    error.appendTo(element.closest('.form-group')).trigger('change');
                }
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').addClass("has-error");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').removeClass("has-error");
        },
        submitHandler: function (form) {
            JSxAdjStkSumAddUpdateAction();
        }
    });
}

/**
 * Functionality : Add or Update
 * Parameters : route
 * Creator : 23/05/2019 Piya
 * Update : -
 * Return : -
 * Return Type : -
 */
function JSxAdjStkSumAddUpdateAction() {

    if($('.xCNPdtEditInLine').length>0){

        $.ajax({
            type: "POST",
            url: '<?php echo $tRoute; ?>',
            data: $("#ofmAddAdjStkSum").serialize(),
            cache: false,
            timeout: 0,
            success: function (tResult) {

                if (nStaAdjStkSumBrowseType != 1) {
                    var aReturn = JSON.parse(tResult);
                    if (aReturn["nStaEvent"] == 1) {
                        if (
                                aReturn["nStaCallBack"] == "1" ||
                                aReturn["nStaCallBack"] == null
                                ) {
                            JSvCallPageAdjStkSumEdit(aReturn["tCodeReturn"]);
                        } else if (aReturn["nStaCallBack"] == "2") {
                            JSvCallPageAdjStkSumAdd();
                        } else if (aReturn["nStaCallBack"] == "3") {
                            JSvCallPageAdjStkSumList();
                        }
                    } else {
                        tMsgBody = aReturn["tStaMessg"];
                        FSvCMNSetMsgWarningDialog(tMsgBody);
                    }
                } else {
                    JCNxBrowseData(tCallAdjStkSumBackOption);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    }else{
        FSvCMNSetMsgWarningDialog('กรุณารวมเอกสารตรวจนับสินค้า');
    }
}
</script>























































































































































































































