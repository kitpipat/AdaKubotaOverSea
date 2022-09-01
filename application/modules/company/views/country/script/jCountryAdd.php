<script type="text/javascript">



    // Set Lang Edit 
    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit")?>;
    var tWhereAgn = "";
    var tWhereLang = ""
    var tCountryCode = $("#oetCtyCode").val();

    $('#oimBchBrowseLang').click(function(){
        var tCountryCode = $("#oetCtyCode").val();
            JSxCheckPinMenuClose();
            oBchBrowseLangOption = oBchBrowseLang({
                    'tCountryCode' : tCountryCode
                });
            JCNxBrowseData('oBchBrowseLangOption');
        });
var oBchBrowseLang = function(poReturnInputCty){
        var tCountryCode = $("#oetCtyCode").val();
    
        let oBchBrowseLang = {
        
        Title : ['company/country/country', 'tCountryLang'],
        Table:{Master:'TSysLanguage', PK:'FNLngID'},
        Where :{
            Condition : ["AND TSysLanguage.FTLngStaUse = '1' "]
        },
        GrideView:{
            ColumnPathLang	: 'company/country/country',
            ColumnKeyLang	: ['tCountryLangID', 'tCountryLangName'],
            ColumnsSize     : ['15%', '85%'],
            WidthModal      : 50,
            DataColumns		: ['TSysLanguage.FNLngID', 'TSysLanguage.FTLngShortName'],
            DataColumnsFormat : ['', ''],
            Perpage			: 10,
            OrderBy			: ['TSysLanguage.FNLngID ASC'],
        },
        CallBack:{
            ReturnType      : 'S',
            Value           : ["oetCtyLangID", "TSysLanguage.FNLngID"],
            Text            : ["oetCtyLangName", "TSysLanguage.FTLngShortName"]
        },
        RouteAddNew : 'SysLang',
        BrowseLev : nStaCtyBrowseType
    };
    return oBchBrowseLang;
}

    var oBchBrowseVat = {
        Title : ['company/country/country', 'tVatTitle'],
        Table:{Master:'VCN_VatActive', PK:'FTVatCode'},
        // Join :{
        //     Table: ['TCNMCountry_L'],
        //     On: [' TCNMCountry.FTCtyCode = TCNMCountry_L.FTCtyCode AND TCNMCountry_L.FNLngID = '+nLangEdits]
        // },
        Where :{
            Condition : [tWhereAgn]
        },
        GrideView:{
            ColumnPathLang	: 'company/country/country',
            ColumnKeyLang	: ['tVatCode', 'tVatTitle'],
            ColumnsSize     : ['15%', '85%'],
            WidthModal      : 50,
            DataColumns		: ['VCN_VatActive.FTVatCode', 'VCN_VatActive.FCVatRate'],
            DataColumnsFormat : ['', ''],
            Perpage			: 10,
            OrderBy			: ['VCN_VatActive.FTVatCode ASC'],
        },
        CallBack:{
            ReturnType      : 'S',
            Value           : ["oetVatCode", "VCN_VatActive.FTVatCode"],
            Text            : ["oetVatRate", "VCN_VatActive.FCVatRate"]
        },
        RouteAddNew : 'SysLang',
        BrowseLev : nStaCtyBrowseType
    };

    var oBchBrowseRate = {
        Title : ['company/country/country', 'tVatTitle'],
        Table:{Master:'TCNSRate_L', PK:'FTRteIsoCode'},
        // Join :{
        //     Table: ['TCNMCountry_L'],
        //     On: [' TCNMCountry.FTCtyCode = TCNMCountry_L.FTCtyCode AND TCNMCountry_L.FNLngID = '+nLangEdits]
        // },
        Where :{
            Condition : [tWhereAgn]
        },
        GrideView:{
            ColumnPathLang	: 'company/country/country',
            ColumnKeyLang	: ['tVatCode', 'tVatTitle'],
            ColumnsSize     : ['15%', '85%'],
            WidthModal      : 50,
            DataColumns		: ['TCNSRate_L.FTRteIsoCode', 'TCNSRate_L.FTRteIsoName'],
            DataColumnsFormat : ['', ''],
            Perpage			: 10,
            OrderBy			: ['TCNSRate_L.FTRteIsoCode ASC'],
        },
        CallBack:{
            ReturnType      : 'S',
            Value           : ["oetRteCode", "TCNSRate_L.FTRteIsoCode"],
            Text            : ["oetRteName", "TCNSRate_L.FTRteIsoName"]
        },
        // RouteAddNew : 'RateCode',
        //BrowseLev : nStaCtyBrowseType
    };




    $(document).ready(function(){

        $('.selectpicker').selectpicker('refresh');

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            startDate: new Date(),
        });

        
        $('#oimBchBrowseVat').click(function(){
            JSxCheckPinMenuClose();
            JCNxBrowseData('oBchBrowseVat');
        });

        $('#oimBchBrowseRte').click(function(){
            JSxCheckPinMenuClose();
            JCNxBrowseData('oBchBrowseRate');
        });
        
    });

</script>