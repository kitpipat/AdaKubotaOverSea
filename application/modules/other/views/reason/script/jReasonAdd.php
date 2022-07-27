<script type="text/javascript">
    $('.selection-2').selectpicker();

    $('#ocmRcnGroup').change(function() {
        $('#ocmRcnGroup-error').hide();
    });

    $(document).ready(function () {
        if(JSbReasonIsCreatePage()){
            // Reason Code
            $("#oetRsnCode").attr("disabled", true);
            $('#ocbReasonAutoGenCode').change(function(){
                if($('#ocbReasonAutoGenCode').is(':checked')) {
                    $('#oetRsnCode').val('');
                    $("#oetRsnCode").attr("disabled", true);
                    $('#odvReasonCodeForm').removeClass('has-error');
                    $('#odvReasonCodeForm em').remove();
                }else{
                    $("#oetRsnCode").attr("disabled", false);
                }
            });
            JSxReasonVisibleComponent('#odvReasonAutoGenCode', true);
        }

        if(JSbReasonIsUpdatePage()){
            // Sale Person Code
            $("#oetRsnCode").attr("readonly", true);
            $('#odvReasonAutoGenCode input').attr('disabled', true);
            JSxReasonVisibleComponent('#odvReasonAutoGenCode', false);    
        }

        $('#oetRsnCode').blur(function(){
            JSxCheckReasonCodeDupInDB();
        });

    });

    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckReasonCodeDupInDB(){
        if(!$('#ocbReasonAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMRsn",
                    tFieldName: "FTRsnCode",
                    tCode: $("#oetRsnCode").val()
                },
                async : false,
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateRsnCode").val(aResult["rtCode"]);
                    JSxReasonSetValidEventBlur();
                    $('#ofmAddReason').submit();
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
    function JSxReasonSetValidEventBlur(){
        $('#ofmAddReason').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if($("#ohdCheckDuplicateRsnCode").val() == 1){
                return false;
            }else{
                return true;
            }
        },'');

        // From Summit Validate
        $('#ofmAddReason').validate({
            rules: {
                oetRsnCode : {
                    "required" :{
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if($('#ocbReasonAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode" :{}
                },
                oetRsnName:     {"required" :{}},
                ocmRcnGroup:    {"required" :{}},
            },
            messages: {
                oetRsnCode : {
                    "required"      : $('#oetRsnCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetRsnCode').attr('data-validate-dublicateCode')
                },
                oetRsnName : {
                    "required"      : $('#oetRsnName').attr('data-validate-required'),
                },
                ocmRcnGroup: {
                    "required"      : $('#osmSelect').attr('data-validate-required'),
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