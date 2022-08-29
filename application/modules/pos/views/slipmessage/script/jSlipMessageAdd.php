<script type="text/javascript">
    $('.selection-2').selectpicker();

    $(document).ready(function () {
        if(JSbSmgIsCreatePage()){
            // Smg Code
            $("#oetSmgCode").attr("disabled", true);
            $('#ocbSlipmessageAutoGenCode').change(function(){
                if($('#ocbSlipmessageAutoGenCode').is(':checked')) {
                    $('#oetSmgCode').val('');
                    $("#oetSmgCode").attr("disabled", true);
                    $('#odvSlipmessageCodeForm').removeClass('has-error');
                    $('#odvSlipmessageCodeForm em').remove();
                }else{
                    $("#oetSmgCode").attr("disabled", false);
                }
            });
            JSxSmgVisibleComponent('#odvSlipmessageAutoGenCode', true);
        }

        if(JSbSmgIsUpdatePage()){
            // Sale Person Code
            $("#oetSmgCode").attr("readonly", true);
            $('#odvSlipmessageAutoGenCode input').attr('disabled', true);
            JSxSmgVisibleComponent('#odvSlipmessageAutoGenCode', false);    
        }

        $('#oetSmgCode').blur(function(){
            JSxCheckSmgCodeDupInDB();
        });

    });

    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckSmgCodeDupInDB(){
        if(!$('#ocbSlipmessageAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMSlipMsgHD_L",
                    tFieldName: "FTSmgCode",
                    tCode: $("#oetSmgCode").val()
                },
                async : false,
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateSmgCode").val(aResult["rtCode"]);
                    JSxSmgSetValidEventBlur();
                    $('#ofmAddSlipMessage').submit();
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
    function JSxSmgSetValidEventBlur(){
        $('#ofmAddSlipMessage').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if($("#ohdCheckDuplicateSmgCode").val() == 1){
                return false;
            }else{
                return true;
            }
        },'');

        // From Summit Validate
        $('#ofmAddSlipMessage').validate({
            rules: {
                oetSmgCode : {
                    "required" :{
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if($('#ocbSlipmessageAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode" :{}
                },
                oetSmgTitle:     {"required" :{}},
                oetSmgFontsSize:  {"required" :{}},
                // ocmRcnGroup:    {"required" :{}},
            },
            messages: {
                oetSmgCode : {
                    "required"      : $('#oetSmgCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetSmgCode').attr('data-validate-dublicateCode')
                },
                oetSmgTitle : {
                    "required"      : $('#oetSmgTitle').attr('data-validate-required'),
                },
                oetSmgFontsSize : {
                    "required"      :  $('#oetSmgFontsSize').attr('data-validate-required'), 
                }
                // ocmRcnGroup: {
                //     "required"      : $('#osmSelect').attr('data-validate-required'),
                // }
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