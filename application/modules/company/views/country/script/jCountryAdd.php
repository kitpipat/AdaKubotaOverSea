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
            DataColumnsFormat : ['', 'Number:2'],
            Perpage			: 10,
            OrderBy			: ['VCN_VatActive.FTVatCode ASC'],
        },
        CallBack:{
            ReturnType      : 'S',
            Value           : ["oetVatCode", "VCN_VatActive.FTVatCode"],
            Text            : ["oetVatRate", "VCN_VatActive.FCVatRate"]
        },
        // DebugSQL : true,
        NextFunc: {
            FuncName: 'JSxFormatInput'
        },
    };

    function JSxFormatInput(){
        if($('#oetVatRate').val()){
            $('#oetVatRate').addClass('text-right');
        }else{
            $('#oetVatRate').removeClass('text-right');
        }
    }

    var oBchBrowseRate = {
        Title : ['company/country/country', 'tRateTitle'],
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
            ColumnKeyLang	: ['tRateCode', 'tRateTitle'],
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
        if($('#oetVatCode').val()){
            $('#oetVatRate').addClass('text-right');
        }


        $('.selectpicker').selectpicker('refresh');

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            startDate: new Date(),
        });

        if($('#oetCtyCode').val()){
         $('#odvUrlAutoGenCode').addClass('xCNHide');
        }
        
        $('#oimBchBrowseVat').click(function(){
            JSxCheckPinMenuClose();
            JCNxBrowseData('oBchBrowseVat');
        });

        $('#oimBchBrowseRte').click(function(){
            JSxCheckPinMenuClose();
            JCNxBrowseData('oBchBrowseRate');
        });

        if(JCNbCtyIsCreatePage()){
            //Brach Code
            $("#oetCtyCode").attr("disabled", true);
            $("#oetCtyCode").attr("disabled", true);

            $('#ocbCtyAutoGenCode').change(function(){
    
                if($('#ocbCtyAutoGenCode').is(':checked')) {
                    $('#oetCtyCode').val('');
                    $("#oetCtyCode").attr("disabled", true);
                    $('#odvCtyCodeForm').removeClass('has-error');
                    $('#odvCtyCodeForm em').remove();
                }else{
                    $("#oetCtyCode").attr("disabled", false);
                }
            });
            JSxBrachVisibleComponent('#ocbCtyAutoGenCode', true);
        }

        if(JCNbCtysUpdatePage()){
            // Brach Code
            $("#oetCtyCode").attr("readonly", true);
            $('#ocbCtyAutoGenCode input').attr('disabled', true);
            JSxBrachVisibleComponent('#ocbCtyAutoGenCode', false);    
        }

        $('#oetCtyCode').blur(function(){
            JSxCheckUrlCodeDupInDB();
        });

        //Functionality : Event Check Brach
    //Parameters : Event Blur Input Brach Code
    //Creator : 20/09/2019 Saharat (Golf)
    //Return : -
    //Return Type : -
    function JSxCheckUrlCodeDupInDB(){
        if(!$('#ocbCtyAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMCountry",
                    tFieldName: "FTCtyCode",
                    tCode: $("#oetCtyCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateCtyCode").val(aResult["rtCode"]);  
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateCtyCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddCountry').validate({
                    rules: {
                        oetUrlCode : {
                            "required" :{
                                // ตรวจสอบเงื่อนไข validate
                                depends: function(oElement) {
                                if($('#ocbCtyAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                                }
                            },
                            "dublicateCode" :{}
                        },
                    },
                    messages: {
                        oetUrlCode : {
                            "required"      : $('#oetUrlCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetUrlCode').attr('data-validate-dublicateCode')
                        },
                    },
                    errorElement: "em",
                    errorPlacement: function (error, element ) {
                        error.addClass( "help-block" );
                        if ( element.prop( "type" ) === "checkbox" ) {
                            error.appendTo( element.parent( "label" ) );
                        } else {
                            var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                            if(tCheck == 0){
                                error.appendTo(element.closest('.form-group')).trigger('change');
                             }
                        }
                    },
                    highlight: function ( element, errorClass, validClass ) {
                        $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                    },
                    submitHandler: function(form){}
                });

                // Submit From brach
                $('#ofmAddCountry').submit();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }   
    }
    });

</script>