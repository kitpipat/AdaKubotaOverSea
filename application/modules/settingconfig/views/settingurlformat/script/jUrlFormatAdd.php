<script type="text/javascript">
    // Set Lang Edit 
    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit")?>;
    var tWhereAgn = "";
    var tWhereLang = ""
    var tCountryCode = $("#oetBchAgnCode").val();

    $('#oimBchBrowseLang').click(function(){
        var tCountryCode = $("#oetCtyCode").val();
            JSxCheckPinMenuClose();
            oBchBrowseLangOption = oBchBrowseLang({
                    'tCountryCode' : tCountryCode
                });
            JCNxBrowseData('oBchBrowseLangOption');
        });
var oBchBrowseLang = function(poReturnInputCty){
        var tCountryCode = $("#oetBchAgnCode").val();
    
        let oBchBrowseLang = {
        
        Title : ['company/branch/branch', 'tBCHTitle'],
        Table:{Master:'TCNMBranch', PK:'FTBchCode'},
        Join :{
            Table: ['TCNMBranch_L'],
            On: [' TCNMBranch.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
        },
        Where :{
            Condition : ["AND TCNMBranch.FTAgnCode = '"+tCountryCode+"' "]
        },
        GrideView:{
            ColumnPathLang	: 'company/branch/branch',
            ColumnKeyLang	: ['tBCHCode', 'tBCHTitle'],
            ColumnsSize     : ['15%', '85%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
            DataColumnsFormat : ['', ''],
            Perpage			: 10,
            OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
        },
        CallBack:{
            ReturnType      : 'S',
            Value           : ["oetBchCode", "TCNMBranch.FTBchCode"],
            Text            : ["oetBchName", "TCNMBranch_L.FTBchName"]
        },
        RouteAddNew : 'branch',
        BrowseLev : nStaCtyBrowseType
    };
    return oBchBrowseLang;
}

var oBchBrowseAgency = {
        Title : ['company/branch/branch', 'tBchAgnTitle'],
        Table:{Master:'TCNMAgency', PK:'FTAgnCode'},
        Join :{
            Table: ['TCNMAgency_L'],
            On: [' TCNMAgency.FTAgnCode = TCNMAgency_L.FTAgnCode AND TCNMAgency_L.FNLngID = '+nLangEdits]
        },
        Where :{
            Condition : [tWhereAgn]
        },
        GrideView:{
            ColumnPathLang	: 'company/branch/branch',
            ColumnKeyLang	: ['tBchAgnCode', 'tBchAgnName'],
            ColumnsSize     : ['15%', '85%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
            DataColumnsFormat : ['', ''],
            Perpage			: 10,
            OrderBy			: ['TCNMAgency.FDCreateOn DESC'],
        },
        CallBack:{
            ReturnType      : 'S',
            Value           : ["oetBchAgnCode", "TCNMAgency.FTAgnCode"],
            Text            : ["oetBchAgnName", "TCNMAgency_L.FTAgnName"]
        },
        RouteAddNew : 'agency',
        BrowseLev : nStaCtyBrowseType
    };

    var oBchBrowseUrl = {
        Title : ['settingconfig/settingurlformat/settingurlformat', 'tUrlName'],
        Table:{Master:'TFNSFmtURL_L', PK:'FTFmtCode'},
        Where :{
            Condition : ['AND TFNSFmtURL_L.FTFmtType = 1']
        },
        GrideView:{
            ColumnPathLang	: 'settingconfig/settingurlformat/settingurlformat',
            ColumnKeyLang	: ['tUrlCode', 'tUrlName'],
            ColumnsSize     : ['15%', '85%'],
            WidthModal      : 50,
            DataColumns		: ['TFNSFmtURL_L.FTFmtCode', 'TFNSFmtURL_L.FTFmtName'],
            DataColumnsFormat : ['', ''],
            Perpage			: 10,
            OrderBy			: ['TFNSFmtURL_L.FTFmtCode ASC'],
        },
        CallBack:{
            ReturnType      : 'S',
            Value           : ["oetUrlFormatCode", "TFNSFmtURL_L.tBchAgnCode"],
            Text            : ["oetUrlFormatName", "TFNSFmtURL_L.FTFmtName"]
        }
    };



    $(document).ready(function(){

        $('.selectpicker').selectpicker('refresh');

        if($('#oetAngCode').val()){
         $('#oimBchBrowseVat').attr('disabled', true);
        }

        if($('#oetUrlCode').val()){
         $('#odvUrlAutoGenCode').addClass('xCNHide');
        }

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            startDate: new Date(),
        });
        
        
        $('#oimBchBrowseVat').click(function(){
            JSxCheckPinMenuClose();
            JCNxBrowseData('oBchBrowseAgency');
        });

        $('#oimBrowseUrl').click(function(){
            JSxCheckPinMenuClose();
            JCNxBrowseData('oBchBrowseUrl');
        });

        if(JCNbUrlIsCreatePage()){
            //Brach Code
            $("#oetUrlCode").attr("disabled", true);
            $("#oetUrlCode").attr("disabled", true);

            $('#ocbUrlAutoGenCode').change(function(){
    
                if($('#ocbUrlAutoGenCode').is(':checked')) {
                    $('#oetUrlCode').val('');
                    $("#oetUrlCode").attr("disabled", true);
                    $('#odvUrlCodeForm').removeClass('has-error');
                    $('#odvUrlCodeForm em').remove();
                }else{
                    $("#oetUrlCode").attr("disabled", false);
                }
            });
            JSxBrachVisibleComponent('#ocbUrlAutoGenCode', true);
        }

        if(JCNbUrlsUpdatePage()){
            // Brach Code
            $("#oetUrlCode").attr("readonly", true);
            $('#ocbUrlAutoGenCode input').attr('disabled', true);
            JSxBrachVisibleComponent('#ocbUrlAutoGenCode', false);    
        }

        $('#oetUrlCode').blur(function(){
            JSxCheckUrlCodeDupInDB();
        });

        //Functionality : Event Check Brach
    //Parameters : Event Blur Input Brach Code
    //Creator : 20/09/2019 Saharat (Golf)
    //Return : -
    //Return Type : -
    function JSxCheckUrlCodeDupInDB(){
        if(!$('#ocbUrlAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMFmtRteSpc",
                    tFieldName: "FTFspCode",
                    tCode: $("#oetUrlCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateUrlCode").val(aResult["rtCode"]);  
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateUrlCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddUrl').validate({
                    rules: {
                        oetUrlCode : {
                            "required" :{
                                // ตรวจสอบเงื่อนไข validate
                                depends: function(oElement) {
                                if($('#ocbUrlAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                                }
                            },
                            "dublicateCode" :{}
                        },              
                        oetUrlFormatName:  { "required": {} },
                    },
                    messages: {
                        oetUrlCode : {
                            "required"      : $('#oetUrlCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetUrlCode').attr('data-validate-dublicateCode')
                        },
                        oetUrlFormatName: {
                            "required" : $('#oetUrlFormatName').attr('data-validate-required'),                 
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
                $('#ofmAddUrl').submit();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }   
    }
    });

</script>