var nStaInterfaceImportBrowseType = $('#oetInterfaceImportStaBrowse').val();
var tCallInterfaceImportBackOption = $('#oetInterfaceImportCallBackOption').val();
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    // $('.progress').hide();
});
//function : Event Click Checkbox all  
//Parameters : 
//Creator :	05/03/2020 nale
//Return : 
//Return Type : 
$('#ocmINMChkAll').click(function() {

    if ($(this).prop('checked') == true) {
        $('.progress-bar-chekbox').prop('checked', true);
    } else {
        $('.progress-bar-chekbox').prop('checked', false);
    }
});


//function : DefualValueProgress
//Parameters :
//Creator :	06/03/2020 nale
//Return : 
//Return Type : 

function JSxINMDefualValueProgress() {

    $('.xWINMTextDisplay').css('display', 'none').removeClass('text-success').removeClass('text-danger').text('').data('status', '2');
    // $('.progress-bar-chekbox:checked').each(function(){

    //     let tIdElement =  $(this).attr('idpgb');
    //     $('#odv'+tIdElement).attr('aria-valuenow',0);
    //     $('#odv'+tIdElement).css('width','0%');
    //     $('#odv'+tIdElement).text('0%');
    //     $('#odv'+tIdElement).attr('status',1);
    //     $('#osp'+tIdElement).hide();
    //     $('#otd'+tIdElement).show();
    // });

}
//function : UpdateProgress
//Parameters : pnPer ptType
//Creator :	05/03/2020 nale
//Return : 
//Return Type : 
function JSxINMUpdateProgress(pnPer, ptType) {

    $('#odvINM' + ptType + 'ProgressBar').attr('aria-valuenow', pnPer);
    $('#odvINM' + ptType + 'ProgressBar').css('width', pnPer + '%');
    $('#odvINM' + ptType + 'ProgressBar').text(pnPer + '%');
    let nSuccessType = 0;
    if (pnPer == 100) {
        $('#odvINM' + ptType + 'ProgressBar').attr('status', 2);
        nSuccessType = JSxINMCheckSuccessProgress();

        setTimeout(() => {
            $('#odvINM' + ptType + 'ProgressBar').parent().hide();
            $('#ospINM' + ptType + 'ProgressBar').css('color', 'green');
            $('#ospINM' + ptType + 'ProgressBar').show();
            let tstingshow = $('#ospINM' + ptType + 'ProgressBar').attr('distext');
            $('#ospINM' + ptType + 'ProgressBar').text(tstingshow);

        }, 3000);

    }
    return nSuccessType;
}

//function : CheckSuccessProgress 
//Parameters : 
//Creator :	05/03/2020 nale
//Return : 1 = success , 2 = pendding
//Return Type : 
function JSbINMCheckSuccessProgress() {
    let nCounUnSucees = 0;
    $('.progress-bar-chekbox:checked').each(function() {
        let tIdElement = $(this).attr('idpgb');
        if ($('.' + tIdElement).data('status') == 2) {
            nCounUnSucees++;
        }
    });

    if (nCounUnSucees > 0) {
        return false;
    } else {
        return true;
    }
}
//function : Click Confrim  
//Parameters : 
//Creator :	05/03/2020 nale
//Return : 
//Return Type : 
$('#obtInterfaceImportConfirm').click(function() {
    //    let nImpportFile = $('.progress-bar-chekbox:checked').length;
    //     if(nImpportFile > 0){
    JCNxOpenLoading();
    JSxINMDefualValueProgress();
    JSxINMCallRabbitMQ();
    // }else{
    //     alert('Please Select Imformation For Import');
    // }

});

//function : Call Rabbit MQ 
//Parameters : 
//Creator :	05/03/2020 nale
//Return : 
//Return Type : 
function JSxINMCallRabbitMQ() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {

        $.ajax({
            type: "POST",
            url: "interfaceimportAction",
            data: $('#ofmInterfaceImport').serialize() + "&ptTypeEvent=" + 'getpassword',
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                // console.log(tResult);
                var aResult = JSON.parse(tResult);
                if (aResult.tHost == '' || aResult.tPort == '' || aResult.tPassword == '' || aResult.tUser == '' || aResult.tVHost == "") {
                    alert('Connect ใน ตั้งค่า Config ไม่ครบ');
                    return;
                } else {
                    var tPassword = JCNtAES128DecryptData(aResult.tPassword, '5YpPTypXtwMML$u@', 'zNhQ$D%arP6U8waL');

                    $.ajax({
                        type: "POST",
                        url: "interfaceimportAction",
                        data: $('#ofmInterfaceImport').serialize() + "&ptTypeEvent=" + 'confirm' + '&tPassword=' + tPassword,
                        cache: false,
                        Timeout: 0,
                        success: function(tResult) {
                            console.log(tResult);
                            // $('#obtInterfaceImportConfirm').attr('disabled', true);
                            // $('.xWINMProgress').css('display', 'block');

                            $('.progress-bar-chekbox:checked').each(function(e) {
                                var nValue = $(this).val();
                                switch (nValue) {
                                    case '00006':
                                        $('.xWINM'+nValue+'Progress').css('display', 'block');
                                    break;
                                    case '00007':
                                        $('.xWINM'+nValue+'Progress').css('display', 'block');
                                    break;
                                  }
                            });
                            JCNxCloseLoading();
                            JSxINMSubScribeQName();

                            $('#odvInterfaceImportSuccess').modal('show');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}


function JSxINMSubScribeQName() {

    let tUserCode = $('#tUserCode').val();
    var oImnclient = Stomp.client('ws://' + oSTOMMQConfig.host + ':15674/ws');
    // ****** Send Rabbit MQ ******
    var on_connect = function(x) {
        oImnclient.subscribe('/queue/LK_RPTransferResponseSAP', function(res) { // ตอนนี้ใช้ Queue LK_QProgressBar
            let aRes = JSON.parse(res.body);

            if (parseInt(aRes['pnStatus']) == 1) {
                var tDisplay = $('.xWINM' + aRes['ptType'] + 'TextDisplay').data('success');
                $('.xWINM' + aRes['ptType'] + 'TextDisplay').addClass('text-success');
            } else {
                var tDisplay = $('.xWINM' + aRes['ptType'] + 'TextDisplay').data('fail');
                $('.xWINM' + aRes['ptType'] + 'TextDisplay').addClass('text-danger');
            }

            $('.xWINM' + aRes['ptType'] + 'Progress').css('display', 'none'); // ปิด spinner
            $('.xWINM' + aRes['ptType'] + 'TextDisplay').data('status', '1');
            $('.xWINM' + aRes['ptType'] + 'TextDisplay').css('display', 'block');
            $('.xWINM' + aRes['ptType'] + 'TextDisplay').text(tDisplay);

            if (JSbINMCheckSuccessProgress() == true) {
                oImnclient.disconnect();
                $('#obtInterfaceImportConfirm').attr('disabled', false);
                $('.xWINMProgress').css('display', 'none');
            }

            // if(aRes['pnStatus']!=2){
            //     let nReSucess = JSxINMUpdateProgress(aRes['pnProgress'],aRes['ptType']);
            //     if(nReSucess==1){
            //         oImnclient.disconnect();
            //         $('#obtInterfaceImportConfirm').attr('disabled',false);
            //     }
            // }else{
            //     $('#odvINM'+aRes['ptType']+'ProgressBar').attr('status',2);
            //     $('#odvINM'+aRes['ptType']+'ProgressBar').parent().hide();
            //     $('#ospINM'+aRes['ptType']+'ProgressBar').text(aRes['ptDescription']);
            //     $('#ospINM'+aRes['ptType']+'ProgressBar').css('color','red');
            //     $('#ospINM'+aRes['ptType']+'ProgressBar').show();
            //     let nStatus = JSxINMCheckSuccessProgress();
            //     if(nStatus==1){
            //             oImnclient.disconnect();
            //             $('#obtInterfaceImportConfirm').attr('disabled',false);
            //     }
            // }

        });
    }
    var on_error = function(x) {
        console.log(x);
    }

    oImnclient.connect(oSTOMMQConfig.user, oSTOMMQConfig.password, on_connect, on_error, oSTOMMQConfig.vhost);
}