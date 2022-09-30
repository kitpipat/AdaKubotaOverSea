$("document").ready(function() {
    JSxCheckPinMenuClose(); 
    JSxPAMNavDefult('showpage_list');

    JSvPAMCallPageList();
});

// Control เมนู
function JSxPAMNavDefult(ptType) {
    if (ptType == 'showpage_list') { // แสดง
        $("#oliPAMTitle").show();
        $("#odvPAMBtnGrpInfo").show();
        $("#obtPAMCallPageAdd").show();
        $("#oliPAMTitleAdd").hide();
        $("#oliPAMTitleEdit").hide();
        $("#obtPAMCallBackPage").hide();
        $("#obtPAMPrintDoc").hide();
        $("#obtPAMCancelDoc").hide();
        $("#obtPAMApproveDoc").hide();
        $("#odvPAMBtnGrpSave").hide();
    } else if (ptType == 'showpage_add') { // แสดง
        $("#oliPAMTitle").show();
        $("#odvPAMBtnGrpSave").show();
        $("#oliPAMTitleAdd").show();
        $("#oliPAMTitleEdit").hide();
        $("#obtPAMCallBackPage").show();
        $("#obtPAMPrintDoc").hide();
        $("#obtPAMCancelDoc").hide();
        $("#obtPAMApproveDoc").hide();
        $("#odvPAMBtnGrpInfo").hide();
    } else if (ptType == 'showpage_edit') { // แสดง
        $("#oliPAMTitle").show();
        $("#odvPAMBtnGrpSave").show();
        $("#obtPAMApproveDoc").show();
        $("#obtPAMCancelDoc").show();
        $("#obtPAMCallBackPage").show();
        $("#oliPAMTitleEdit").show();
        $("#obtPAMPrintDoc").show();
        $("#oliPAMTitleAdd").hide();
        $("#odvPAMBtnGrpInfo").hide();
    }

    // ล้างค่า
    localStorage.removeItem('LocalItemData');
    localStorage.removeItem("PAM_LocalItemDataDelDtTemp");
}

// หน้าจอลิสต์ข้อมูล
function JSvPAMCallPageList() {
    $.ajax({
        type    : "GET",
        url     : "docPAMFormSearchList",
        cache   : false,
        timeout : 0,
        success: function(tResult) {
            $("#odvPAMContentPageDocument").html(tResult);
            JSxCheckPinMenuClose();
            JSxPAMNavDefult('showpage_list');
            JSvPAMCallPageDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// ตารางข้อมูล
function JSvPAMCallPageDataTable(pnPage) {
    JCNxOpenLoading();
    var oAdvanceSearch = JSoPAMGetAdvanceSearchData();

    var nPageCurrent = pnPage;
    if (typeof(nPageCurrent) == undefined || nPageCurrent == "") {
        nPageCurrent = "1";
    }
    $.ajax({
        type    : "POST",
        url     : "docPAMDataTable",
        data    : {
            oAdvanceSearch  : oAdvanceSearch,
            nPageCurrent    : nPageCurrent
        },
        cache: false,
        timeout: 0,
        success: function(oResult) {
            var aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                $('#ostPAMDataTableDocument').html(aReturnData['tPAMViewDataTableList']);
            } else {
                var tMessageError = aReturnData['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// รวม Values ต่างๆของการค้นหาขั้นสูง
function JSoPAMGetAdvanceSearchData() {
    var oAdvanceSearchData = {
        tSearchAll              : $("#oetSearchAll").val().trim(),
        tSearchBchCode          : $("#oetPAMBchCode").val(),
        tSearchPlcCode          : $("#oetPAMPlcCode").val(),
        tSearchCat1Code         : $("#oetPAMCat1Code").val(),
        tSearchCat1Name         : $("#oetPAMCat1Name").val(),
        tSearchCat2Code         : $("#oetPAMCat2Code").val(),
        tSearchCat2Name         : $("#oetPAMCat2Name").val(),
        tSearchDocDateFrm       : $("#oetPAMDocDateFrm").val(),
        tSearchDocDateTo        : $("#oetPAMDocDateTo").val(),
        tSearchStaDoc           : $("#ocmPAMStaDoc").val(),
        tSearchPackType         : $("#ocmPAMPackType").val()
    };
    return oAdvanceSearchData;
}

// หน้าจอเพิ่มข้อมูล
function JSvPAMCallPageAddDoc() {
    JCNxOpenLoading();
    $.ajax({
        type    : "POST",
        url     : "docPAMPageAdd",
        cache   : false,
        timeout : 0,
        success : function(oResult) {
            var aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                JSxPAMNavDefult('showpage_add');
                $('#odvPAMContentPageDocument').html(aReturnData['tPAMViewPageAdd']);
                JSvPAMLoadPdtDataTableHtml();
                JCNxLayoutControll();
                JCNxCloseLoading();
            } else {
                var tMessageError = aReturnData['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// โหลดข้อมูลในสินค้า Temp
function JSvPAMLoadPdtDataTableHtml() {
    if ($("#ohdPAMRoute").val() == "docPAMEventAdd") {
        var tPAMDocNo = "";
    } else {
        var tPAMDocNo = $("#oetPAMDocNo").val();
    }
    
    $.ajax({
        type    : "POST",
        url     : "docPAMPdtAdvanceTableLoadData",
        data    : {
            'tSelectBCH'        : $('#oetPAMBchCode').val(),
            'ptPAMDocNo'        : tPAMDocNo
        },
        cache: false,
        Timeout: 0,
        success: function(oResult) {
            var aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                $('#odvPAMDataPanelDetailPDT #odvPAMDataPdtTableDTTemp').html(aReturnData['tPAMPdtAdvTableHtml']);

                //เอกสารอ้างอิง
                JSxPAMCallPageHDDocRef();
                JCNxCloseLoading();
            } else {
                var tMessageError = aReturnData['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
                JCNxCloseLoading();
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// บันทึกข้อมูล - แก้ไขข้อมูล
function JSxPAMAddEditDocument() { 
    var nStaSession = 1;
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        JSxPAMValidateFormDocument();
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// บันทึกข้อมูล - แก้ไขข้อมูล
function JSxPAMValidateFormDocument(){
    if($("#ohdPAMCheckClearValidate").val() != 0){
        $('#ofmPAMFormAdd').validate().destroy();
    }

    $('#ofmPAMFormAdd').validate({
        focusInvalid: true,
        rules: {
            oetPAMDocNo : {
                "required" : {
                    depends: function (oElement) {
                        if($("#ohdPAMRoute").val()  ==  "docPAMEventAdd"){
                            if($('#ocbPAMStaAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }else{
                            return false;
                        }
                    }
                }
            },
            oetPAMBchName       : {"required" : true},
            oetPAMBchNameTo     : {"required" : true}
        },
        messages: {
            oetPAMDocNo         : {"required" : $('#oetPAMDocNo').attr('data-validate-required')},
            oetPAMBchName       : {"required" : $('#oetPAMBchName').attr('data-validate-required')},
            oetPAMBchNameTo     : {"required" : $('#oetPAMBchNameTo').attr('data-validate-required')}
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            error.addClass("help-block");
            if(element.prop("type") === "checkbox") {
                error.appendTo(element.parent("label"));
            }else{
                var tCheck  = $(element.closest('.form-group')).find('.help-block').length;
                if(tCheck == 0) {
                    error.appendTo(element.closest('.form-group')).trigger('change');
                }
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
        },
        submitHandler: function (form){
            if(!$('#ocbPAMStaAutoGenCode').is(':checked')){
                JSxPAMValidateDocCodeDublicate();
            }else{
                JSxPAMSubmitEventByButton('');
            }
        },
    });
}

// Validate Doc Code (Validate ตรวจสอบรหัสเอกสาร)
function JSxPAMValidateDocCodeDublicate(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url : "CheckInputGenCode",
        data: {
            'tTableName'    : 'TCNTPdtPickHD',
            'tFieldName'    : 'FTXthDocNo',
            'tCode'         : $('#oetPAMDocNo').val()
        },
        success: function (oResult) {
            var aResultData = JSON.parse(oResult);
            $("#ohdPAMCheckDuplicateCode").val(aResultData["rtCode"]);

            if($("#ohdPAMCheckClearValidate").val() != 1) {
                $('#ofmPAMFormAdd').validate().destroy();
            }

            $.validator.addMethod('dublicateCode', function(value,element){
                if($("#ohdPAMRoute").val() == "docPAMEventAdd"){
                    if($('#ocbPAMStaAutoGenCode').is(':checked')) {
                        return true;
                    }else{
                        if($("#ohdPAMCheckDuplicateCode").val() == 1) {
                            return false;
                        }else{
                            return true;
                        }
                    }
                }else{
                    return true;
                }
            });

            // Set Form Validate From Add Document
            $('#ofmPAMFormAdd').validate({
                focusInvalid    : false,
                onclick         : false,
                onfocusout      : false,
                onkeyup         : false,
                rules: {
                    oetPAMDocNo : {"dublicateCode": {}}
                },
                messages: {
                    oetPAMDocNo : {"dublicateCode"  : $('#oetPAMDocNo').attr('data-validate-duplicate')}
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
                submitHandler: function (form) {
                    JSxPAMSubmitEventByButton('');
                }
            })

            if($("#ohdPAMCheckClearValidate").val() != 1) {
                $("#ofmPAMFormAdd").submit();
                $("#ohdPAMCheckClearValidate").val(1);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// บันทึกข้อมูล - แก้ไขข้อมูล (วิ่งเข้า controller)
function JSxPAMSubmitEventByButton(ptType){
    var tPAMDocNo = '';

    if($("#ohdPAMRoute").val() !=  "docPAMEventAdd"){
        var tPAMDocNo    = $('#oetPAMDocNo').val();
    }

    // อินพุต
    $(".form-control").attr("disabled", false);

    $.ajax({
        type: "POST",
        url: "docPAMChkHavePdtForDocDTTemp",
        data: {
            'ptPAMDocNo'         : tPAMDocNo,
            'tPAMSesSessionID'   : $('#ohdSesSessionID').val(),
            'tPAMUsrCode'        : $('#ohdPAMUsrCode').val(),
            'tPAMLangEdit'       : $('#ohdPAMLangEdit').val(),
            'tSesUsrLevel'       : $('#ohdSesUsrLevel').val(),
        },
        cache: false,
        timeout: 0,
        success: function (oResult){
            var aDataReturnChkTmp   = JSON.parse(oResult);
            $('.xWPAMDisabledOnApv').attr('disabled',false);
            if (aDataReturnChkTmp['nStaReturn'] == '1'){
                $.ajax({
                    type    : "POST",
                    url     : $("#ohdPAMRoute").val(),
                    data    : $("#ofmPAMFormAdd").serialize(),
                    cache   : false,
                    timeout : 0,
                    success : function(oResult){
                        var aDataReturnEvent    = JSON.parse(oResult);
                        if(aDataReturnEvent['nStaReturn'] == '1'){
                            var nPAMStaCallBack      = aDataReturnEvent['nStaCallBack'];
                            var nPAMDocNoCallBack    = aDataReturnEvent['tCodeReturn'];
                            var nPAMPayType          = $('#ocmPAMTypePayment').val();
                            var nPAMVatInOrEx        = $('#ocmPAMFrmSplInfoVatInOrEx').val();
                            var nPAMStaRef           = $('#ocmPAMFrmInfoOthRef').val();

                            let oPAMCallDataTableFile = {
                                ptElementID : 'odvPAMShowDataTable',
                                ptBchCode   : $('#oetPAMBchCode').val(),
                                ptDocNo     : nPAMDocNoCallBack,
                                ptDocKey    :'TCNTPdtPickHD',
                            }
                            JCNxUPFInsertDataFile(oPAMCallDataTableFile);

                            if( ptType == 'approve' ){
                                JSxPAMApproveDocument(false);
                            }else{
                                switch(nPAMStaCallBack){
                                    case '1' :
                                        JSvPAMCallPageEdit(nPAMDocNoCallBack,nPAMPayType,nPAMVatInOrEx,nPAMStaRef);
                                    break;
                                    case '2' :
                                        JSvPAMCallPageAddDoc();
                                    break;
                                    case '3' :
                                        JSvPAMCallPageList();
                                    break;
                                    default :
                                        JSvPAMCallPageEdit(nPAMDocNoCallBack,nPAMPayType,nPAMVatInOrEx,nPAMStaRef);
                                }
                            }
                        }else{
                            var tMessageError = aDataReturnEvent['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error   : function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else if(aDataReturnChkTmp['nStaReturn'] == '800'){
                var tMsgDataTempFound   = aDataReturnChkTmp['tStaMessg'];
                FSvCMNSetMsgWarningDialog('<p class="text-left">'+tMsgDataTempFound+'</p>');
            }else{
                var tMsgErrorFunction   = aDataReturnChkTmp['tStaMessg'];
                FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// อนุมัติเอกสาร
function JSxPAMApproveDocument(pbIsConfirm) { 
    try {
        if (pbIsConfirm) {
            $("#odvPAMModalAppoveDoc").modal('hide');
            var tDocNo                  = $('#oetPAMDocNo').val();
            var tBchCode                = $('#ohdPAMBchCode').val();
            var tAlwQtyPickNotEqQtyOrd  = $('#ohdPAMAlwQtyPickNotEqQtyOrd').val();

            $.ajax({
                type    : "POST",
                url     : "docPAMApproveDocument",
                data    : {
                    tDocNo                  : tDocNo,
                    tBchCode                : tBchCode,
                    tAlwQtyPickNotEqQtyOrd  : tAlwQtyPickNotEqQtyOrd,
                    tDocType                : $('#ohdPAMDocType').val()
                },
                cache   : false,
                timeout : 0,
                success : function(tResult) {
                    var aReturnData = JSON.parse(tResult);
                    var tMessageError = aReturnData['tStaMessg'];
                    if (aReturnData['nStaEvent'] == '1') {
                        JSvPAMCallPageEdit(tDocNo);
                    } else {
                        setTimeout(function(){
                            FSvCMNSetMsgErrorDialog(tMessageError);
                            JCNxCloseLoading();
                        }, 500);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            $("#odvPAMModalAppoveDoc").modal('show');
        }
    } catch (err) {
        console.log("JSxPAMApproveDocument Error: ", err);
    }
}

// เข้าหน้าแบบ แก้ไข
function JSvPAMCallPageEdit(ptDocumentNumber) { 
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "docPAMPageEdit",
            data    : {
                'ptPAMDocNo': ptDocumentNumber
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var aReturnData = JSON.parse(tResult)
                if( aReturnData['nStaEvent'] == '1' ){
                    JSxPAMNavDefult('showpage_edit');
                    $('#odvPAMContentPageDocument').html(aReturnData['tViewPageEdit']);

                    window.scrollTo(0, 0);
                    JSvPAMLoadPdtDataTableHtml();
                }else{
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
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