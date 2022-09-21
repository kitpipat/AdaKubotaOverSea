var nStaMcnBrowseType = $('#oetMcnStaBrowse').val();
var tCallMcnBackOption = $('#oetMcnCallBackOption').val();

$('ducument').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxRsnNavDefult();
    if (nStaMcnBrowseType != 1) {
        JSvCallPageMerchantList();
    } else {
        JSvCallPageMerchantAdd();
    }
});

///function : Function Clear Defult Button Reason
//Parameters : -
//Creator : 08/05/2018 wasin
//Update:   28/05/2018 wasin
//Return : -
//Return Type : -
function JSxRsnNavDefult() {
    // Menu Bar เข้ามาจาก หน้า Master หรือ Browse
    if (nStaMcnBrowseType != 1) { // เข้ามาจาก  Master
        $('.obtChoose').hide();
        $('#oliRsnTitleAdd').hide();
        $('#oliRsnTitleEdit').hide();
        $('#odvBtnRsnAddEdit').hide();
        $('#odvBtnRsnInfo').show();
    } else { // เข้ามาจาก Browse Modal
        $('#odvModalBody #odvRsnMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliRsnNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvRsnBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNRsnBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNRsnBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

///function : Call Reason Page list  
//Parameters : - 
//Creator:	08/05/2018 wasin
//Update:   28/05/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageMerchantList(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        localStorage.tStaPageNow = 'JSvCallPageMerchantList';
        $('#oetSearchAll').val('');
        $.ajax({
            type: "POST",
            url: "merchantList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageMerchant').html(tResult);
                JSvMerchantDataTable(pnPage);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

///function : Call Reason Data List
//Parameters : Ajax Success Event 
//Creator:	28/05/2018 wasin
//Update:   
//Return : View
//Return Type : View
function JSvMerchantDataTable(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "merchantDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataReasion').html(tResult);
                }
                JSxRsnNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TCNMRsn_L'); //โหลดภาษาใหม่
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : Call Reason Page Add  
//Parameters : -
//Creator : 09/05/2018 wasin
//Update: 28/05/2018 wasin(yoshi)
//Return : View
//Return Type : View
function JSvCallPageMerchantAdd() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "merchantPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (nStaMcnBrowseType == 1) {
                    $('#odvModalBodyBrowse').html(tResult);
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                } else {
                    $('.xCNRsnVBrowse').hide();
                    $('.xCNRsnVMaster').show();
                    $('#oliRsnTitleEdit').hide();
                    $('#oliRsnTitleAdd').show();
                    $('#odvBtnRsnInfo').hide();
                    $('#odvBtnRsnAddEdit').show();
                }
                $('#odvContentPageMerchant').html(tResult);
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : Call Reason Page Edit  
//Parameters : -
//Creator: 09/05/2018 wasin(yoshi)
//Update: 28/05/2018 wasin(yoshi)
//Return : View
//Return Type : View
function JSvCallPageMerchantEdit(ptMcnCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageMerchantEdit', ptMcnCode);
        $.ajax({
            type: "POST",
            url: "merchantPageEdit",
            data: { tMcnCode: ptMcnCode },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#oliRsnTitleAdd').hide();
                    $('#oliRsnTitleEdit').show();
                    $('#odvBtnRsnInfo').hide();
                    $('#odvBtnRsnAddEdit').show();
                    $('#odvContentPageMerchant').html(tResult);
                    $('#odvReasonAutoGenCode').hide();
                    $('#oetMcnCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);
                    $('.xCNiConGen').attr('disabled', true);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality: Set Status Click Validate
//Parameters: -
//Creator: 25/03/2019 wasin(Yoshi)
//Return: -
//ReturnType: -
function JSxRsnSetStatusClickSubmit() {
    $("#ohdCheckRsnClearValidate").val("1");
}

//Functionality : (event) Add/Edit Reason
//Parameters : form
//Creator : 09/05/2018 wasin
//Return : object Status Event And Event Call Back
//Return Type : object
function JSnAddEditMerchant(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddMerchant').validate().destroy();

        $.validator.addMethod('dublicateCode', function(value, element) {
            if (ptRoute == "merchantEventAdd") {
                if ($("#ohdCheckDuplicateMcnCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        },'');


        $('#ofmAddMerchant').validate({
            rules: {
                oetMcnCode: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "merchantEventAdd") {
                                if ($('#ocbMerchantAutoGenCode').is(':checked')) {
                                    return false;
                                } else {
                                    return true;
                                }
                            } else {
                                return true;
                            }
                        }
                    },
                    "dublicateCode": {}
                },
                oetMcnName: { "required": {} },
                oetMcnEmail: {
                    "email": {}
                }
            },
            messages: {
                oetMcnCode: {
                    "required": $('#oetMcnCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetMcnCode').attr('data-validate-dublicateCode')
                },
                oetMcnName: {
                    "required": $('#oetMcnName').attr('data-validate-required')
                },
                oetMcnEmail: {
                    "email": $('#oetMcnEmail').attr('data-validate-email')
                }
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");
                if (element.prop("type") === "checkbox") {
                    error.appendTo(element.parent("label"));
                } else {
                    var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                    if (tCheck == 0) {
                        error.appendTo(element.closest('.form-group')).trigger('change');
                    }
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
            },
            unhighlight: function(element, errorClass, validClass) {
                var nStaCheckValid = $(element).parents('.form-group').find('.help-block').length
                if (nStaCheckValid != 0) {
                    $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
                }
            },

            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddMerchant').serialize(),
                    async: false,
                    cache: false,
                    timeout: 0,

                    success: function(tResult) {
                        JCNxOpenLoading();
                        if (nStaMcnBrowseType != 1) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                    JSvCallPageMerchantEdit(aReturn['tCodeReturn']);
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvCallPageMerchantAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvCallPageMerchantList();
                                }
                            } else {
                                alert(aReturn['tStaMessg']);
                            }
                        } else {
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallMcnBackOption);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });

    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality: เปลี่ยนหน้า pagenation
//Parameters: -
//Creator: 09/05/2018 wasin
//Update: 28/05/2018 wasin
//Return: View
//Return Type: View
function JSvClickPage(ptPage) {
    var nPageCurrent = '';
    var nPageNew;
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageReasonGrp .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew;
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageReasonGrp .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew;
            break;
        default:
            nPageCurrent = ptPage;
    }
    JSvMerchantDataTable(nPageCurrent);
}

//Functionality: (event) Delete
//Parameters: Button Event [tIDCode รหัสเหตุผล]
//Creator: 10/05/2018 wasin
//Update: 28/05/2018 wasin
//Return: Event Delete Reason List
//Return Type: -
function JSnMerchantDel(tCurrentPage, tDelName, tIDCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        var aData = $('#ohdConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        var tConfirm = $('#ohdDeleteconfirm').val();
        var tConfirmYN = $('#ohdDeleteconfirmYN').val();
        if (aDataSplitlength == '1') {
            $('#odvModalDelMerchant').modal('show');
            $('#ospConfirmDelete').text(tConfirm + ' ' + tIDCode + ' (' + tDelName + ') ' + tConfirmYN);
            $('#osmConfirm').on('click', function(evt) {
                if (localStorage.StaDeleteArray != '1') {
                    $.ajax({
                        type: "POST",
                        url: "merchantEventDelete",
                        data: { 'tIDCode': tIDCode },
                        cache: false,
                        success: function(tResult) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                $('#odvModalDelMerchant').modal('hide');
                                $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                                $('#ohdConfirmIDDelete').val('');
                                localStorage.removeItem('LocalItemData');
                                $('.modal-backdrop').remove();
                                setTimeout(function() {
                                    if (aReturn["nNumRowMcnLoc"] != 0) {
                                        if (aReturn["nNumRowMcnLoc"] > 10) {
                                            nNumPage = Math.ceil(aReturn["nNumRowRsnLoc"] / 10);
                                            if (tCurrentPage <= nNumPage) {
                                                JSvCallPageMerchantList(tCurrentPage);
                                            } else {
                                                JSvCallPageMerchantList(nNumPage);
                                            }
                                        } else {
                                            JSvCallPageMerchantList(1);
                                        }
                                    } else {
                                        JSvCallPageMerchantList(1);
                                    }
                                    // JSvBntDataTable(pnPage);
                                    // JSvReasonDataTable(tCurrentPage);
                                }, 500);
                            } else {
                                FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                                //alert(aReturn['tStaMessg']);
                            }
                            JSxRsnNavDefult();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }
            });
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : (event) Delete All
//Parameters : Button Event 
//Creator : 10/05/2018 wasin
//Update: 28/05/2018 wasin
//Return : Event Delete All Select List
//Return Type : -
function JSnMerchantDelChoose(tCurrentPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        var aData       = $('#ohdConfirmIDDelete').val();
        var aTexts      = aData.substring(0, aData.length - 2);
        var aDataSplit  = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
        }

        if(aDataSplitlength > 1){
            localStorage.StaDeleteArray = '1';
            $.ajax({
                type : "POST",
                url  : "merchantEventDelete",
                data : {'tIDCode': aNewIdDelete},
                cache: false,
                timeout: 0,
                success: function(oResult){
                    var aReturn = JSON.parse(oResult); 
                    if(aReturn['nStaEvent'] == 1){
                        setTimeout(function() {
                            $('#odvModalDelMerchant').modal('hide');    
                            JSvMerchantDataTable(tCurrentPage);
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();
                            if (aReturn["nNumRowMcnLoc"] != 0) {
                                if (aReturn["nNumRowMcnLoc"] > 10) {
                                    nNumPage = Math.ceil(aReturn["nNumRowMcnLoc"] / 10);
                                    if (pnPage <= nNumPage) {
                                        JSvCallPageMerchantList(tCurrentPage);
                                    } else {
                                        JSvCallPageMerchantList(nNumPage);
                                    }
                                } else {
                                    JSvCallPageMerchantList(1);
                                }
                            } else {
                                JSvCallPageMerchantList(1);
                            }
                        },1000);
                    }else{
                        alert(aReturn['tStaMessg']);
                    }
                    JSxRsnNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            localStorage.StaDeleteArray = '0';
            return false;
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Functionality: Function Show Button Delete All
//Parameters:   Event Parameter
//Creator:  28/05/2018 wasin
//Return: Event Button Delete All
//Return Type: -
function JSxShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
        $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $('#odvMngTableList #oliBtnDeleteAll').removeClass('disabled');
        } else {
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        }
        if (nNumOfArr > 1) {
            $('.xCNIconDel').addClass('xCNDisabled');
        } else {
            $('.xCNIconDel').removeClass('xCNDisabled');
        }
    }
}

//Functionality: Function Insert Text Delete
//Parameters: Event Parameter
//Creator: 28/05/2018 wasin
//Return: Event Insert Text
//Return Type: -
function JSxTextinModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tText = '';
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tText += aArrayConvert[0][$i].tName + '(' + aArrayConvert[0][$i].nCode + ') ';
            tText += ' , ';

            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        var tTexts = tText.substring(0, tText.length - 2);
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val() + tTexts);
        $('#ohdConfirmIDDelete').val(tTextCode);
    }
}

//Functionality: Function Chack Dupilcate Data
//Parameters: Event Select List Reason
//Creator: 28/05/2018 wasin
//Return: Duplicate/none
//Return Type: string
function findObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return 'Dupilcate';
        }
    }
    return 'None';
}

//Choose Checkbox
function JSxMerchantVisibledDelAllBtn(poElement, poEvent) { // Action start after change check box value.
    try {
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if (nCheckedCount > 1) {
            $('#oliBtnDeleteAll').removeClass("disabled");
            $('.xCNIconDel').addClass('xCNDisabled');
        } else {
            $('#oliBtnDeleteAll').addClass("disabled");
            $('.xCNIconDel').removeClass('xCNDisabled');
        }
    } catch (err) {
        //console.log('JSxDepartmentVisibledDelAllBtn Error: ', err);
    }
}


//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 11/10/2018 wasin
//Return: -
//Return Type: -
function JSxPaseCodeDelInModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
        $('#ohdConfirmIDDelete').val(tTextCode);
    }
}


// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbMerchantIsCreatePage() {
    try {
        const tRsnCode = $('#oetMcnCode').data('is-created');
        var bStatus = false;
        if (tRsnCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbMerchantIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbReasonIsUpdatePage() {
    try {
        const tRsnCode = $('#oetRsnCode').data('is-created');
        var bStatus = false;
        if (!tRsnCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbReasonIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxMerchantVisibleComponent(ptComponent, pbVisible, ptEffect) {
    try {
        if (pbVisible == false) {
            $(ptComponent).addClass('hidden');
        }
        if (pbVisible == true) {
            // $(ptComponent).removeClass('hidden');
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    } catch (err) {
        console.log('JSxMerchantVisibleComponent Error: ', err);
    }
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbReasonIsCreatePage() {
    try {
        const tRsnCode = $('#oetRsnCode').data('is-created');
        var bStatus = false;
        if (tRsnCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbReasonIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbMerchantIsUpdatePage() {
    try {
        const tMcnCode = $('#oetMcnCode').data('is-created');
        var bStatus = false;
        if (!tMcnCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbMerchantIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxReasonVisibleComponent(ptComponent, pbVisible, ptEffect) {
    try {
        if (pbVisible == false) {
            $(ptComponent).addClass('hidden');
        }
        if (pbVisible == true) {
            // $(ptComponent).removeClass('hidden');
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    } catch (err) {
        console.log('JSxReasonVisibleComponent Error: ', err);
    }
}







//  ================================================================ Merchant Function JS Address  ================================================================

// Functionality : Getdata table
// Parameters : Merchant Code
// Creator : 09/07/2019 Sarun
// Return : viwe
// Return Type : string
function JSxAddressDatatable(paDataRefCode) {
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "merchantAddressDataTable",
        data: { tMerchantCode: paDataRefCode },
        success: function(tResult) {
            $('#odvContentAddress').html(tResult);
            $('#olbMerchantAddressAdd').hide();
            $('#olbMerchantAddressEdit').hide();
            $('#odvMerchantBtnGrpAddEdit').hide();
            $('#odvMerchantBtnGrpInfo').show();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Call Page Add Merchant Address
// Parameters : -
// Creator : 09/07/2019 Sarun
// Last Update : 09/09/2019 Wasin(Yoshi)
// Return : view
// Return Type : view
function JSvCallPageMerchantAddAddress() {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "merchantPageAddAddress",
        data:{
            'ptMerchantCode' : $('#oetMcnCode').val()
        },
        success: function(tResult) {
            $('#odvContentAddress').html(tResult);

            $('#olbMerchantAddressEdit').hide();
            $('#odvMerchantBtnGrpInfo').hide();
            // $('#odvBtnRsnAddEdit').hide();

            $('#olbMerchantAddressAdd').show();
            $('#odvMerchantBtnGrpAddEdit').show();
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Call Page Edit Merchant Address
// Parameters : -
// Creator : 09/07/2019 Sarun
// Last Update : 09/09/2019 Wasin(Yoshi)
// Return : view
// Return Type : view
function JSvCallPageMerchantEditAddress(paMerchantAddressData){
    JCNxOpenLoading();
    $.ajax({
        type : "POST",
        url : "merchantAddressPageEdit",
        data : paMerchantAddressData,
        success: function(tResult){
            $('#odvContentAddress').html(tResult);
            $('#olbMerchantAddressAdd').hide();
            $('#odvMerchantBtnGrpInfo').hide();
            $('#olbMerchantAddressEdit').show();
            $('#odvMerchantBtnGrpAddEdit').show();
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


//Functionality : Event Add/Edit Merchant Address
//Parameters : From Submit
//Creator : 09/07/2019 Sarun
//Return : view
//Return Type : object
function JSoAddEditMerchantAddress(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: $('#ofmMerchantAddAddress #ohdMerchantAddressRoute').val(),
        data: $('#ofmMerchantAddAddress').serialize(),
        success: function(tResult){
            var aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaReturn'] == 1){
                var tCodeReturn = aDataReturn['tDataCodeReturn'];
                JSxAddressDatatable(tCodeReturn);
            }else{
                var tMsgErrorFunction   = aDataReturn['tStaMessg'];
                FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Delete Merchant Address
//Parameters : From Submit
//Creator : 09/07/2019 Wasin(Yoshi)
//Return : view
//Return Type : object
function JSoDeletDataMerchantAddress(poMerchantAddressData) {
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "merchantAddressEventDelete",
        data: poMerchantAddressData,
        success: function(tResult){
            var aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaReturn'] == 1){
                var tCodeReturn = aDataReturn['tDataCodeReturn'];
                JSxAddressDatatable(tCodeReturn);
            }else{
                var tMsgErrorFunction   = aDataReturn['tStaMessg'];
                FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//  ================================================================ End Merchant Function JS Address  ================================================================