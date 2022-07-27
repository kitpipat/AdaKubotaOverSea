<script type="text/javascript">
    $(document).ready(function(){
    
        if(JSbsSuppliertypeIsCreatePage()){
            //suppliertype Code
            $("#oetStyCode").attr("disabled", true);
            // $("#oetStyCode").attr("disabled", true);
            $('#ocbSupplierTypeAutoGenCode').change(function(){
                if($('#ocbSupplierTypeAutoGenCode').is(':checked')) {
                    $('#oetStyCode').val('');
                    $("#oetStyCode").attr("disabled", true);
                    $('#odvCpnCodeForm').removeClass('has-error');
                    $('#odvCpnCodeForm em').remove();
                }else{
                    $("#oetStyCode").attr("disabled", false);
                }
            });
            JSxSuppliertypeVisibleComponent('#odvStyAutoGenCode', true);
        }
        
        if(JSbSuppliertypeIsUpdatePage()){
      
            // suppliertype Code
            $("#oetStyCode").attr("readonly", true);
            $('#odvStyAutoGenCode input').attr('disabled', true);
            JSxSuppliertypeVisibleComponent('#odvStyAutoGenCode', false);    
        }
    });

    $('#oetStyCode').blur(function(){
        JSxCheckSuppliertypeCodeDupInDB();
    });

    //Functionality : Event Check suppliertype
    //Parameters : Event Blur Input suppliertype Code
    //Creator : 25/03/2019 wasin (Yoshi)
    //Updata : 30/05/2019 saharat (Golf)
    //Return : -
    //Return Type : -
    function JSxCheckSuppliertypeCodeDupInDB(){
        if(!$('#ocbSupplierTypeAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMSplType",
                    tFieldName: "FTStyCode",
                    tCode: $("#oetStyCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateStyCode").val(aResult["rtCode"]);
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateStyCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddSty').validate({
                    rules: {
                        oetStyCode : {
                            "required" :{
                                // ตรวจสอบเงื่อนไข validate
                                depends: function(oElement) {
                                if($('#ocbCouponAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                                }
                            },
                            "dublicateCode" :{}
                        },
                        oetStyName:     {"required" :{}},
                    },
                    messages: {
                        oetStyCode : {
                            "required"      : $('#oetStyCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetStyCode').attr('data-validate-dublicateCode')
                        },
                        oetStyName : {
                            "required"      : $('#oetStyName').attr('data-validate-required'),
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

                // Submit From
                $('#ofmAddSty').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }    
    }







</script>