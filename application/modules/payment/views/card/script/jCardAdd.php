<script type="text/javascript">
    // $('.selection-2').selectpicker();


    $(document).ready(function () {
        if(JSbCrdIsCreatePage()){
            // Crd Code
            $("#oetCrdCode").attr("disabled", true);
            $('#ocbCardAutoGenCode').change(function(){
                if($('#ocbCardAutoGenCode').is(':checked')) {
                    $('#oetCrdCode').val('');
                    $("#oetCrdCode").attr("disabled", true);
                    $('#odvCardCodeForm').removeClass('has-error');
                    $('#odvCardCodeForm em').remove();
                }else{
                    $("#oetCrdCode").attr("disabled", false);
                }
            });
            JSxCrdVisibleComponent('#odvCardAutoGenCode', true);
        }

        if(JSbCrdIsUpdatePage()){
            // Sale Person Code
            $("#oetCrdCode").attr("readonly", true);
            $('#odvCardAutoGenCode input').attr('disabled', true);
            JSxCrdVisibleComponent('#odvCardAutoGenCode', false);    
        }

        $('#oetCrdCode').blur(function(){
            JSxCheckCrdCodeDupInDB();
        });

    });

    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckCrdCodeDupInDB(){
        if(!$('#ocbCardAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TFNMCard",
                    tFieldName: "FTCrdCode",
                    tCode: $("#oetCrdCode").val()
                },
                async : false,
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateCrdCode").val(aResult["rtCode"]);
                    JSxCrdSetValidEventBlur();
                    $('#ofmAddCard').submit();
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
    function JSxCrdSetValidEventBlur(){
        $('#ofmAddCard').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if($("#ohdCheckDuplicateCrdCode").val() == 1){
                return false;
            }else{
                return true;
            }
        },'');

        // From Summit Validate
        $('#ofmAddCard').validate({
            rules: {
                oetCrdCode : {
                    "required" :{
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if($('#ocbCardAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode" :{}
                },

                oetCrdCtyCode        :  {"required" :{}},
                oetCrdCtyName        :  {"required" :{}},
                oetCrdDepartmentName :  {"required" :{}}, 

            },
            messages: {
                oetCrdCode : {
                    "required"      : $('#oetCrdCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetCrdCode').attr('data-validate-dublicateCode')
                },
             
                oetCrdCtyName : {
                    "required"      : $('#oetCrdCtyName').attr('data-validate-required'),
                },

                oetCrdDepartmentName : {
                    "required"      : $('#oetCrdDepartmentName').attr('data-validate-required'),
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
            unhighlight: function(element, errorClass, validClass) {
                var nStaCheckValid  = $(element).parents('.form-group').find('.help-block').length
                if(nStaCheckValid != 0){
                    $(element).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                }
            },
            submitHandler: function(form){}
        });
    }


    // Get Data CardCode
    // Create By Witsarut 25/11/2019
    function JSxCrdloginGetContent(){
        var tRoutepage = '<?=$tRoute?>';

        if(tRoutepage == 'cardEventAdd'){
            return;
        }else{
            var ptCrdCode   = '<?php echo $tCrdCode;?>';

            // Check Login Expried
            var nStaSession = JCNxFuncChkSessionExpired();

            //if have Session
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $("#odvCrdloginContentInfoDT").attr("class","tab-pane fade out");
                $.ajax({
                    type    : "POST",
                    url     : "cardlogin",
                    data    :  {
                        tCrdCode : ptCrdCode
                    },
                    cache    : false,
                    timeout : 0,
                    success : function(tResult){
                        $('#odvCrdloginData').html(tResult);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        }
    }


</script>