<script type="text/javascript">
    // $('.selection-2').selectpicker();
    var tUsrLevel = "<?= $this->session->userdata('tSesUsrLoginLevel') ?>";
    var tAgnCode = "<?= $this->session->userdata('tSesUsrAgnCode') ?>";

    $(document).ready(function () {

        if( tUsrLevel != 'HQ' && tAgnCode != $('#oetBntAgnCode').val()){
            $('.form-control').attr('disabled', true);
            $('#ocbBntStaShw').attr('disabled', true);
            $('#obtBarSubmitBnt').hide();
        }

        // ควบคุม เปิด-ปิด อ้าอิงประเภทสกุุลเงิน 
        // var tAgnCodeInput = $("#oetBntAgnCode").val();
        // if (tAgnCodeInput) {
        //     $("#obtBntRateBrowse").attr('disabled', false);
        // } else {
        //     $("#obtBntRateBrowse").attr('disabled', true);
        // }

        if(JSbBntIsCreatePage()){
            // Bnt Code
            $("#oetBntCode").attr("disabled", true);
            $('#ocbBanknoteAutoGenCode').change(function(){
                if($('#ocbBanknoteAutoGenCode').is(':checked')) {
                    $('#oetBntCode').val('');
                    $("#oetBntCode").attr("disabled", true);
                    $('#odvBanknoteCodeForm').removeClass('has-error');
                    $('#odvBanknoteCodeForm em').remove();
                }else{
                    $("#oetBntCode").attr("disabled", false);
                }
            });
            JSxBntVisibleComponent('#odvBanknoteAutoGenCode', true);
        }

        if(JSbBntIsUpdatePage()){
            // Sale Person Code
            $("#oetBntCode").attr("readonly", true);
            $('#odvBanknoteAutoGenCode input').attr('disabled', true);
            JSxBntVisibleComponent('#odvBanknoteAutoGenCode', false);    
        }

    });

    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckBntCodeDupInDB(){
        if(!$('#ocbBanknoteAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TFNMBankNote",
                    tFieldName: "FTBntCode",
                    tCode: $("#oetBntCode").val()
                },
                async : false,
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateBntCode").val(aResult["rtCode"]);
                    JSxBntSetValidEventBlur();
                    $('#ofmAddBnt').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }

    //Functionality: Set Validate Event Blur
    //Parameters: Validate Event Blur
    //Creator: 26/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxBntSetValidEventBlur(){
        $('#ofmAddBnt').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if($("#ohdCheckDuplicateBntCode").val() == 1){
                return false;
            }else{
                return true;
            }
        },'');

        // From Summit Validate
        $('#ofmAddBnt').validate({
            rules: {
                oetBntCode : {
                    "required" :{
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if($('#ocbBanknoteAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode" :{}
                },
                
                oetBntName:     {"required" :{}},
            },
            messages: {
                oetBntCode : {
                    "required"      : $('#oetBntCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetBntCode').attr('data-validate-dublicateCode')
                },
                oetBntName : {
                    "required"      : $('#oetBntName').attr('data-validate-required'),
                }
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
            unhighlight: function(element, errorClass, validClass) {
                var nStaCheckValid  = $(element).parents('.form-group').find('.help-block').length
                if(nStaCheckValid != 0){
                    $(element).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                }
            },
            submitHandler: function(form){}
        });
    }

    //BrowseAgn 
    $('#oimBrowseAgn').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowseAgn({
                'tReturnInputCode'  : 'oetBntAgnCode',
                'tReturnInputName'  : 'oetBntAgnName',
                'tNextFuncName': 'JSxBntConsNextFuncBrowseAgn',
                'aArgReturn': ['FTAgnCode', 'FTAgnName']
            });
            JCNxBrowseData('oPdtBrowseAgencyOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit")?>;

    //Option Agn
    var oBrowseAgn =   function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tNextFuncName = poReturnInput.tNextFuncName;
        var aArgReturn = poReturnInput.aArgReturn;

        var oOptionReturn       = {
            Title : ['ticket/agency/agency', 'tAggTitle'],
            Table:{Master:'TCNMAgency', PK:'FTAgnCode'},
            Join :{
            Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang	: 'ticket/agency/agency',
                ColumnKeyLang	: ['tAggCode', 'tAggName'],
                ColumnsSize     : ['15%', '85%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat : ['', ''],
                Perpage			: 10,
                OrderBy			: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMAgency.FTAgnCode"],
                Text		: [tInputReturnName,"TCNMAgency_L.FTAgnName"],
            },
            NextFunc: {
                FuncName: tNextFuncName,
                ArgReturn: aArgReturn
            },
            RouteAddNew : 'agency',
            BrowseLev : 1,
        }
        return oOptionReturn;
    }

    function JSxBntConsNextFuncBrowseAgn(poDataNextFunc) {
        if (typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL") {
            var aDataNextFunc = JSON.parse(poDataNextFunc);
            tAgnCode = aDataNextFunc[0];
            tAgnName = aDataNextFunc[1];
        }

        $('#oetBntRateCode').val('');
        $('#oetBntRateName').val('');

        if(tAgnCode){
            $("#obtBntRateBrowse").attr('disabled', false);
        }else{
            $("#obtBntRateBrowse").attr('disabled', true);
        }
    }


var tStaUsrLevel    = '<?php  echo $this->session->userdata("tSesUsrLevel"); ?>';
if(tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP'){
    $('#oimBrowseAgn').attr("disabled", true);

}


//BrowseAgn 
$('#obtBntRateBrowse').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPdtBrowseRateOption = oBrowseRte({
                'tReturnInputCode'  : 'oetBntRateCode',
                'tReturnInputName'  : 'oetBntRateName',
            });
            JCNxBrowseData('oPdtBrowseRateOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit")?>;

    //Option Rate
    var oBrowseRte =   function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
    
        var tWhereAgn = "";
        var tAgnCodeWhere = $('#oetBntAgnCode').val();
        if (tAgnCodeWhere == '' || tAgnCodeWhere == null) {
            tWhereAgn = '';
        } else {
            tWhereAgn = " AND TFNMRate.FTAgnCode = '" + tAgnCodeWhere + "'";
        }


        var oOptionReturn  = {
            Title: ['payment/recive/recive', 'tRCVCurrency'],
            Table:{Master:'TFNMRate', PK:'FTRteCode'},
            Join :{
            Table: ['TFNMRate_L'],
                On: ['TFNMRate_L.FTRteCode = TFNMRate.FTRteCode AND TFNMRate_L.FNLngID = '+nLangEdits]
            },
            Where: {
                Condition: [" AND TFNMRate.FTRteStaLocal = 1" + tWhereAgn]
            },
            GrideView: {
                ColumnPathLang: 'payment/recivespc/recivespc',
                ColumnKeyLang: ['tBrowseAppCode', 'tBrowseAppName'],
                ColumnsSize: ['15%', '75%'],
                DataColumns: ['TFNMRate.FTRteCode', 'TFNMRate_L.FTRteName'],
                DataColumnsFormat: ['', ''],
                DistinctField   : ['TFNMRate.FTRteCode'],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TFNMRate.FTRteCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TFNMRate.FTRteCode"],
                Text		: [tInputReturnName,"TFNMRate_L.FTRteName"],
            },
            RouteAddNew : 'agency',
            BrowseLev : 1,
            // DebugSQL: true,
        }
        return oOptionReturn;
    }



    var tStaUsrLevel    = '<?php  echo $this->session->userdata("tSesUsrLevel"); ?>';


    if(tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP'){
        $('#oimBrowseAgn').attr("disabled", true);
    
    }


</script>