<script type="text/javascript">
    $(document).ready(function(){
    
        if(JSbSupplierlevIsCreatePage()){
            //supplierlev Code
            $("#oetSlvCode").attr("disabled", true);
            $('#ocbSupplierlevAutoGenCode').change(function(){
                if($('#ocbSupplierlevAutoGenCode').is(':checked')) {
                    $('#oetSlvCode').val('');
                    $("#oetSlvCode").attr("disabled", true);
                    $('#odvSupplierlevCodeForm').removeClass('has-error');
                    $('#odvSupplierlevCodeForm em').remove();
                }else{
                    $("#oetSlvCode").attr("disabled", false);
                }
            });
            JSxSupplierlevVisibleComponent('#odvSupplierlevAutoGenCode', true);
        }
        
        if(JSbSupplierlevIsUpdatePage()){
      
            // supplierlev Code
            $("#oetSlvCode").attr("readonly", true);
            $('#odvSupplierlevAutoGenCode input').attr('disabled', true);
            JSxSupplierlevVisibleComponent('#odvSupplierlevAutoGenCode', false);    
        }
    });

    $('#oetSlvCode').blur(function(){
        JSxCheckSupplierlevCodeDupInDB();
    });

    //Functionality : Event Check supplierlev
    //Parameters : Event Blur Input supplierlev Code
    //Creator : 25/03/2019 wasin (Yoshi)
    //Update : 30/05/2019 saharat (Golf)
    //Return : -
    //Return Type : -
    function JSxCheckSupplierlevCodeDupInDB(){
        if(!$('#ocbCouponAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMSplLev",
                    tFieldName: "FTSlvCode",
                    tCode: $("#oetSlvCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateSlvCode").val(aResult["rtCode"]);
                    // Set Validate Dublicate Code
                    $.validator.addMethod('dublicateCode', function(value, element) {
                        if($("#ohdCheckDuplicateSlvCode").val() == 1){
                            return false;
                        }else{
                            return true;
                        }
                    },'');
                    // From Summit Validate
                    $('#ofmAddSupplierLevel').validate({
                        rules: {
                            oetSlvCode : {
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
                            oetSlvName:     {"required" :{}},
                        },
                        messages: {
                            oetSlvCode : {
                                "required"      : $('#oetSlvCode').attr('data-validate-required'),
                                "dublicateCode" : $('#oetSlvCode').attr('data-validate-dublicateCode')
                            },
                            oetSlvName : {
                                "required"      : $('#oetSlvName').attr('data-validate-required'),
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
                    $('#ofmAddSupplierLevel').submit();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }    
    }







</script>