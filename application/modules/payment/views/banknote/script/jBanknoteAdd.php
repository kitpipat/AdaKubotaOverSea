<script type="text/javascript">
    // $('.selection-2').selectpicker();


    $(document).ready(function () {
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

</script>