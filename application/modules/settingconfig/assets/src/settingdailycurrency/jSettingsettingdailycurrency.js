var nStaSettingConfigBrowseType = $("#oetSettingConfigStaBrowse").val();
var tCallSettingConfigBackOption = $("#oetSettingConfigCallBackOption").val();

$("document").ready(function() {
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose();
    JSvSettingConfigDailyCurrencyCallPageList();
});

//Get FuncHD List Page
function JSvSettingConfigDailyCurrencyCallPageList() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');
            $.ajax({
                type: "POST",
                url: "SettingDailyCurrencyGetList",
                data: {},
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    $("#odvContentPageSettingDairyCurrency").html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } catch (err) {
            console.log('JSvSettingConfigDailyCurrencyCallPageList Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////// แท็บตั้งค่าระบบ

//Load View Setting Config Search (หน้าค้นหา + ปุ่มบันทึก)
function JSvSettingDairyCurrencyLoadViewSearch() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');
            $.ajax({
                type: "POST",
                url: "SettingDailyCurrencyLoadViewSearch",
                data: { ptTypePage: 'Main' , ptAgnCode: '00500'},
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    $("#odvInforSettingconfig").html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } catch (err) {
            console.log('JSvSettingConfigDailyCurrencyCallPageList Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Load Table Setting 
function JSvSettingDairyCurrencyLoadTable() {
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');

            var tAppType = $("#ocmAppType option:selected").val();
            var tSearch = $('#oetSearchCurrentDairy').val();
            var tTypePage = $('#ohdSETTypePage').val();
            var tAgnCodeChk = $('#oetSpcAgncyCode').val();
            if (tTypePage == "Agency") {
                tAgnCode = $('#oetAgnCode').val();
            } else {
                tAgnCode = '';
            }

            $.ajax({
                type: "POST",
                url: "SettingDailyCurrencyLoadTable",
                data: {
                    tAppType: tAppType,
                    tSearch: tSearch,
                    ptTypePage: tTypePage,
                    ptAgnCode: tAgnCode,
                    ptAgnCodeChk: tAgnCodeChk,
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    aPackData = [];
                    aPackDataInput = [];
                    $("#odvContentConfigTable").html('');
                    $("#odvContentConfigTable").html(tResult);
                    JSxControlScroll();
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } catch (err) {
            console.log('JSvSettingConfigDailyCurrencyCallPageList Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//ควบคุมตารางให้มีสกอร์ หรือไม่มีสกอร์
function JSxControlScroll() {
    var nWindowHeight = ($(window).height() - 460) / 2;

    //สำหรับตารางที่เป็นเช็คบ๊อก
    var nLenCheckbox = $('#otbTableForCheckbox tbody tr').length;
    if (nLenCheckbox > 6) {
        $('.xCNTableHeightCheckbox').css('height', nWindowHeight);
    } else {
        $('.xCNTableHeightCheckbox').css('height', 'auto');
    }

    //สำหรับตารางอื่นๆ
    var nLenInput = $('#otbTableForInput tbody tr').length;
    if (nLenCheckbox < 6) {
        var nWindowHeightInput = ($(window).height() - 125) / 2;
    } else {
        var nWindowHeightInput = nWindowHeight;
    }

    if (nLenInput > 6) {
        $('.xCNTableHeightInput').css('height', nWindowHeightInput);
    } else {
        $('.xCNTableHeightInput').css('height', 'auto');
    }
}

//โชว์ Modal ยกเลิก
function JSxSETCancel() {
    $('#odvModalSETCancel').modal('show');
}

//Event Modal ยกเลิก
function JSxSETModalCancel() {
    $('#odvModalSETCancel').modal('hide');

    //ล้างค่าก่อนโหลดหน้าอีกครั้ง
    $("#ocmAppType option[value='0']").attr("selected", "selected");
    $('.selectpicker').selectpicker('refresh');
    $('#oetSearchAll').val('');
    JSvSettingDairyCurrencyLoadTable();
}

//Event Value in Checkbox
var aPackData = [];

function JSxEventClickCheckboxCurrentcy(elem) {
    var tCheckseq       = $(elem).data("seq");
    var nRctRate        = $(elem).data("rterate");
    var nRctLastRate    = $(elem).data("rtelastrate");
    var nDecimal        = $("#oetDecimal").val();
    if(nRctLastRate > 0 ){
        var nConvertLastRate = 1/nRctLastRate;
    }else{
        var nConvertLastRate = 0;
    }

    if(nRctRate > 0 ){
        var nConvertRate = 1/nRctRate;
    }else{
        var nConvertRate = 0;
    }

    if ($(elem).is(':checked')) {
        $('#oetUseCurrency'+tCheckseq).val(parseFloat(nConvertLastRate).toFixed(nDecimal));
        $('#oetUseCurrency'+tCheckseq).attr('readonly',true);
    }else{
        $('#oetUseCurrency'+tCheckseq).val(parseFloat(nConvertRate).toFixed(nDecimal));
        $('#oetUseCurrency'+tCheckseq).attr('readonly',false);
    }
}


//Event Save - บันทึก
function JSxCurrentcySave() {
    var nDecimal        = $("#oetDecimal").val();
    var nStaSession = JCNxFuncChkSessionExpired();
    var tAgnCode    = $('#oetSpcAgncyCode').val();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            var aPackDataInput = [];
            var aGetItem = [];
            var nflag = '0';
            $(".oetCurrentCurentcy").each(function() { 
                var tCheckseq       = $(this).data("seq");
                var nAgnCode        = $(this).data("agncode");
                var nRteCode        = $(this).data("rtecode");
                var nRteOldval      = $(this).data("oldval");
                var nChangeValue    = $(this).val();
                var nRteLast        = parseFloat($("#ocbListItem_"+tCheckseq).data("rtelastrate"));
                var nRteDiff        = 1/nRteLast;
                if(nChangeValue == ''){
                    nflag = '1';
                    return false;
                }
                // if(nChangeValue != nRteOldval){
                aGetItem.push({
                    FCRteRate: nChangeValue,
                    FTRteCode: nRteCode,
                    FTAgnCode: nAgnCode,
                    nRteLast : parseFloat(nRteDiff).toFixed(nDecimal), 
                    nRte     : nRteLast, 
                    tAgnCode : tAgnCode,
                });
                // }
            });
            if(nflag == '0'){
                $.ajax({
                    type: "POST",
                    url: "SettingDailyCurrencySave",
                    data: {
                        aGetItem: aGetItem,
                    },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        JSvSettingDairyCurrencyLoadTable();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                FSvCMNSetMsgErrorDialog('กรุณากรอกข้อมูลให้ครบถ้วน');
            }
        } catch (err) {
            console.log('JSvSettingConfigDailyCurrencyCallPageList Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Event Default - โชว์หน้าต่าง ใช้แม่แบบ
function JSxSETReDefault() {
    $('#odvModalSETDefault').modal('show');
}

//Event Use Default  - ใช้แม่แบบ
function JSxSETModalDefault() {
    $('#odvModalSETDefault').modal('hide');
    $.ajax({
        type: "POST",
        url: "SettingConfigUseDefaultValue",
        data: {},
        cache: false,
        timeout: 5000,
        success: function(tResult) {
            $("#ocmAppType option[value='0']").attr("selected", "selected");
            $('.selectpicker').selectpicker('refresh');
            $('#oetSearchAll').val('');
            JSvSettingDairyCurrencyLoadTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

/////////////////////////////////////////////////////////////////////////////////////////////// แท็บรหัสอัตโนมัติ


//Load View Setting Number Search (หน้าค้นหา + ปุ่มบันทึก)
function JSvSettingNumberLoadViewSearch() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');
            $.ajax({
                type: "POST",
                url: "SettingAutonumberLoadViewSearch",
                data: {},
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    $("#odvInforAutonumber").html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } catch (err) {
            console.log('JSvSettingConfigDailyCurrencyCallPageList Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

function JSvSCFLoadViewAPISearch() {
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');
            $.ajax({
                type: "POST",
                url: "connectSetGenaral",
                data: {
                    tStaApiTxnType: '3'
                },
                cache: false,
                success: function(tResult) {
                    $("#odvSCFApiCentent").html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } catch (err) {
            console.log('JSvSCFLoadViewAPISearch Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Load View Datatable
function JSvSettingAutoNumberLoadTable() {
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');

            var tAppType = '';
            var tSearch = $('#oetSearchAllAutoNumber').val();
            $.ajax({
                type: "POST",
                url: "SettingAutonumberLoadTable",
                data: { tAppType: tAppType, tSearch: tSearch },
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    aPackData = [];
                    aPackDataInput = [];
                    $("#odvContentAutoNumber").html('');
                    $("#odvContentAutoNumber").html(tResult);
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } catch (err) {
            console.log('JSvSettingConfigDailyCurrencyCallPageList Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Load Page Update
function JSvCallPageUpdateAutonumber(ptTable, pnSeq) {
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');
            $.ajax({
                type: "POST",
                url: "SettingAutonumberLoadPageEdit",
                data: { ptTable: ptTable, pnSeq: pnSeq },
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    $("#odvInforAutonumber").html('');
                    $("#odvInforAutonumber").html(tResult);
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } catch (err) {
            console.log('JSvSettingConfigDailyCurrencyCallPageList Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// แนะนำช่องฝาก
function JSxCurrentcyCurrentRate() {
    try {
        var tAgnCode    = $('#oetSpcAgncyCode').val();
        var tUsrCode    = $('#ohdCurrentUsrCode').val();

    //     JCNxOpenLoading();
    if(tAgnCode != ''){
        $.ajax({
            type: "POST",
            url: "docGetCurrentDairy",
            data: {
                tAgnCode    : tAgnCode,
                tUsrCode    : tUsrCode
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var aReturnData = JSON.parse(tResult);
                JSoDailySubscribeMQ();
                // if(aReturnData['nStaEvent'] == 1){
                //     localStorage.setItem("SuggestLay",0);
                //     JSxDBRGetMsgSuggestLay(tRefInDocNo);
                // }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        FSvCMNSetMsgErrorDialog('กรุณาเลือกตัวแทนขาย');
    }


    } catch (err) {
        console.log("JSxDBRApproveDocument Error: ", err);
    }
}

function JSoDailySubscribeMQ(){
	
	//RabbitMQ
    /*===========================================================================*/

    var tAgnCode    = $('#oetSpcAgncyCode').val();
    var tUsrCode    = $('#ohdCurrentUsrCode').val();
    var tLangCode = $("#ohdLangEdit").val();
    var tUsrBchCode = $("#oetBchCode").val();
    var tUsrApv     = $("#oetXthApvCodeUsrLogin").val();
    var tStaPrcDoc = $("#oetStaPrcDoc").val();
    var tDocNo = $("#oetXphDocNo").val();
    var tPrefix = 'RESEXCHANGERATE';
    var tStaDelMQ = $("#oetStaDelQname").val();
    var tStaApv = $("#oetStaApv").val();
    var tQName = tPrefix + '_' + tAgnCode + '_' +tUsrCode;

    // alert(tQName);

    // MQ Message Config
    var poDocConfig = {
        tLangCode: tLangCode,
        tUsrBchCode: tUsrBchCode,
        tUsrApv: tUsrApv,
        tDocNo: tDocNo,
        tPrefix: tPrefix,
        tStaDelMQ: tStaDelMQ,
        tStaApv: tStaApv,
        tQName: tQName
    };

    var poMqConfig = {
        host: 'ws://' + '147.50.143.126' + ':15674/ws',
        username: 'Admin',
        password: 'Admin',
        vHost: 'AdaPos5.0SKCDev_Master'
    };

    // Callback Page Control(function)
    var poCallback = {
        tCallPageEdit: 'JSvSettingConfigDailyCurrencyCallPageList',
        tCallPageList: 'JSvSettingConfigDailyCurrencyCallPageList'
    };

    // Update Status For Delete Qname Parameter
    var poUpdateStaDelQnameParams = {
        ptDocTableName : "TCNTPdtAdjPriHD",
        ptDocFieldDocNo: "FTXphDocNo",
        ptDocFieldStaApv: "FTXphStaPrcDoc",
        ptDocFieldStaDelMQ: "FTXphStaDelMQ",
        ptDocStaDelMQ: "1",
        ptDocNo : tDocNo    
    };

    //Check Show Progress %
	FSxCMNRabbitMQMessageDailyCurrent(poDocConfig, poMqConfig, poUpdateStaDelQnameParams, poCallback);
    /*===========================================================================*/
    //RabbitMQ
	
}

