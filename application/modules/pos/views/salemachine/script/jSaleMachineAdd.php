<script type="text/javascript">
    $(document).ready(function(){

        if( bIsAddPage ){
            let tWahBchCode = $('#oetWahBchCodeCreated').val();
            if( tWahBchCode !== undefined ){
                let tWahBchName = $('#oetWahBchNameCreated').val();
                $('#oetPosBchCode').val(tWahBchCode);
                $('#oetPosBchName').val(tWahBchName);
                $('#oimPosBrowseBch').attr('disabled',true);

                let WahStaType = $('#ocmWahStaType').val();
                switch(WahStaType){
                    case '2':
                        $('#ocmPosType').val(1);
                        break;
                    case '6':
                        $('#ocmPosType').val(4);
                        break;
                    default:
                        $('#ocmPosType').val(1);
                        break;
                }
                $('#ocmPosType').attr('disabled',true);
            }
        }

        // Event Tab
        $('#odvPosPanelBody .xCNPOSTab').unbind().click(function(){
            let tPosRoute       = '<?php echo @$tRoute;?>';
            if(tPosRoute == 'salemachineEventAdd'){
                return;
            }else{
                let tTypeTab    = $(this).data('typetab');
                if(typeof(tTypeTab) !== undefined && tTypeTab == 'main'){
                    JCNxOpenLoading();
                    setTimeout(function(){
                        $('#odvPosMainMenu #odvBtnAddEdit').show();
                        JCNxCloseLoading();
                        return;
                    },500);
                }else if(typeof(tTypeTab) !== undefined && tTypeTab == 'sub'){
                    $('#odvPosMainMenu #odvBtnAddEdit').hide();
                    let tTabTitle   = $(this).data('tabtitle');
                    switch(tTabTitle){
                        case 'posinfomachine':
                            JCNxOpenLoading();
                            setTimeout(function(){
                                JCNxCloseLoading();
                                return;
                            },500);
                        break;
                        case 'posads':
                            JSxPosAdsGetContent();
                        break;
                        case 'posaddress':
                            JSxGetPosContentAddress();
                        break;
                    }
                }   
            }
        });

    if(JSbSaleMachineIsCreatePage()){
        $("#oetPosCode").attr("disabled", true);
        $('#ocbPosAutoGenCode').change(function(){
            if($('#ocbPosAutoGenCode').is(':checked')) {
                $('#oetPosCode').val('');
                $("#oetPosCode").attr("disabled", true);
                $('#odvPosCodeForm').removeClass('has-error');
                $('#odvPosCodeForm em').remove();
            }else{
                $("#oetPosCode").attr("disabled", false);
            }
        });
        JSxSaleMachineVisibleComponent('#ocbPosAutoGenCode', true);
    }
    
    if(JSbSaleMachineIsUpdatePage()){
        $("#oetPosCode").attr("readonly", true);
        $('#odvPosAutoGenCode input').attr('disabled', true);
        JSxSaleMachineVisibleComponent('#odvPosAutoGenCode', false);    

        }
    });
    
    $('#oetPosCode').blur(function(){
        // JSxPosValidateDocCodeDublicate();
    });

    // Functionality: Function Check Is Create Page
    // Parameters: Event Documet Redy
    // Creator: 23/09/2019 saharat(Golf)
    // Return: object Status Delete
    // ReturnType: boolean
    function JSxPosValidateDocCodeDublicate(){
    if(!$('#ocbPosAutoGenCode').is(':checked')){
        $.ajax({
            type: "POST",
            url: "CheckInputGenCode",
            data: { 
                tTableName: "TCNMPos",
                tFieldName: "FTPosCode",
                tCode: $('#oetPosCode').val()
            },
            cache: false,
            timeout: 0,
            success: function(tResult){
            var aResultData = JSON.parse(tResult);
            $("#ohdCheckPosValidate").val(aResultData["rtCode"]);
            $('#ofmAddSaleMachine').validate().destroy();
            $.validator.addMethod('dublicateCode', function(value,element){
                if($("#ohdTMacFormRoute").val() == "salemachineEventAdd"){
                    if($('#ocbPosAutoGenCode').is(':checked')) {
                        return true;
                    }else{
                        if($("#ohdCheckPosValidate").val() == 1) {
                            return false;
                        }else{
                            return true;
                        }
                    }
                }else{
                    return true;
                }
            });

            // Set Form Validate From Add 
            $('#ofmAddSaleMachine').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetPosCode : {"dublicateCode": {}},
                    oetPosBchName : {"dublicateCode": {}},
                },
                messages: {
                    oetPosCode : {"dublicateCode"  : $('#oetPosCode').attr('data-validate-dublicatecode')}
                },
                messages: {
                    oetPosBchName : {"dublicateCode"  : $('#oetPosBchName').attr('data-validate-dublicatecode')}
                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    error.addClass("help-block");
                    if(element.prop("type") === "checkbox") {
                        error.appendTo(element.parent("label"));
                    }else{
                        var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                        if (tCheck == 0) {
                            error.appendTo(element.closest('.form-group')).trigger('change');
                        }
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).closest('.form-group').addClass("has-error");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).closest('.form-group').removeClass("has-error");
                },
                submitHandler: function (form) {}
            });
            $('#obtSubmitSaleMachine').submit();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
            },
        });
        }
    }


    // Create By : Witsarut
    // Create Date : 10/08/2019
    // Functional : Get Content for PosAds
    // Return : -
    // Return Type : -
    // Parameter : Route Name
    function JSxPosAdsGetContent(){
        var tBchCode    = $('#ohdBchCode').val();
        var tShpCode    = $('#ohdShpCode').val();
        var tPosCode    = '<?php echo @$tPosCode?>';
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $.ajax({
                type: "POST",
                url: "posAds/0/0",
                data: {
                    tPosCode  : tPosCode,
                    tBchCode  : tBchCode,
                    tShpCode  : tShpCode
                },
                cache	: false,
                timeout	: 0,
                success	: function(tResult){
                    $('#odvPosPanelBody #odvInforPosAds').html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }
    
    // Function: Event Call Salemachine Address
    // Parameters : Event Click Tab
    // Creator : 16/09/2019 wasin(Yoshi)
    // Return : -
    // Return Type : -
    function JSxGetPosContentAddress(){
        let tPosCode    = '<?php echo @$tPosCode;?>';
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            $.ajax({
                type    : "POST",
                url     : "salemachineAddressData",
                data    : {'ptPosCode':tPosCode},
                success	: function(tResult){
                    $('#odvPosPanelBody #odvPOSAddressData').html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    //check type ว่าใช่ type 4 หรือไม่ ถ้าใช่ให้เปิด WarehouseForm ถ้าไม่ใช่ ปิด WarehouseForm

    $("#ocmPosType").change(function(){
        var tPosType = $('#ocmPosType').val();
        if(tPosType == 4 || tPosType == 1){
            $('#odvWarehouseForm').removeAttr("style");
        }else{
            $("#odvWarehouseForm").attr("style", "display:none;");
        }
    });




</script>