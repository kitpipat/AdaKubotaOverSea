var nStaCtyBrowseType = $('#oetPunStaBrowse').val();
var tCallPunBackOption = $('#oetPunCallBackOption').val();
// alert(nStaCtyBrowseType+'//'+tCallPunBackOption);

$('document').ready(function() {
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCtyNavDefult();
    if (nStaCtyBrowseType != 1) {
        JSvCallPageCountryList(1);
    } else {
        JSvCallPageCountryAdd();
    }
    localStorage.removeItem('LocalItemData');
});

///function : Function Clear Defult Button Product Unit
//Parameters : Document Ready
//Creator : 13/09/2018 wasin
//Return : Show Tab Menu
//Return Type : -
function JSxCtyNavDefult() {
    if (nStaCtyBrowseType != 1 || nStaCtyBrowseType == undefined) {
        $('.xCNChoose').hide();
        $('#oliCountryTitleAdd').hide();
        $('#oliCountryTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnCtyInfo').show();
    } else {
        $('#odvModalBody #odvCtyBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNPunBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNPunBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function 
//Creator : 13/09/2018 wasin
//Return : Modal Status Error
//Return Type : view
/* function JCNxResponseError(jqXHR, textStatus, errorThrown) {
    JCNxCloseLoading();
    var tHtmlError = $(jqXHR.responseText);
    var tMsgError = "<h3 style='font-size:20px;color:red'>";
    tMsgError += "<i class='fa fa-exclamation-triangle'></i>";
    tMsgError += " Error<hr></h3>";
    switch (jqXHR.status) {
        case 404:
            tMsgError += tHtmlError.find('p:nth-child(2)').text();
            break;
        case 500:
            tMsgError += tHtmlError.find('p:nth-child(3)').text();
            break;

        default:
            tMsgError += 'something had error. please contact admin';
            break;
    }
    $("body").append(tModal);
    $('#modal-customs').attr("style", 'width: 450px; margin: 1.75rem auto;top:20%;');
    $('#myModal').modal({ show: true });
    $('#odvModalBody').html(tMsgError);
} */

//function : Call Product Unit Page list  
//Parameters : Document Redy And Event Button
//Creator :	13/09/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageCountryList(pnPage) {
    localStorage.tStaPageNow = 'JSvCallPageCountryList';
    $('#oetSearchAll').val('');
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "countryList",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvContentPageCountry').html(tResult);
            JSvCtyDataTable(pnPage);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

/**
 * Functionality : Is create page.
 * Parameters : -
 * Creator : 12/06/2019 saharat(Golf)
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
 function JCNbCtyIsCreatePage() {
    try {
        const tBchCode = $('#oetCtyCode').data('is-created');
        var bStatus = false;
        if (tBchCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JCNbUrlIsCreatePage Error: ', err);
    }
}

/**
 * Functionality : Is update page.
 * Parameters : -
 * Creator : 12/06/2019 saharat(Golf)
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
 function JCNbCtysUpdatePage() {
    try {
        const tBchCode = $('#oetCtyCode').data('is-created');
        var bStatus = false;
        if (!tBchCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JCNbCtysUpdatePage Error: ', err);
    }
}

//Functionality : (event) Add/Edit Reason
//Parameters : form
//Creator : 27/03/2018 wasin(yoshi)
//Return : Status Add
//Return Type : n
function JSnAddEditCountry(tRouteEvent) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddCountry').validate().destroy();
        $('#ofmAddCountry').validate({
            rules: {
                oetCtyCode:  { "required": {} },
                oetCtyName:  { "required": {} },
                oetRteName:  { "required": {} },
                oetCtyRef:  { "required": {} },
                oetVatRate:  { "required": {} },
            },
            messages: {
                oetCtyCode: {
                    "required" : $('#oetCtyCode').attr('data-validate-required'),                 
                },
                oetCtyName: {
                    "required": $('#oetCtyName').attr('data-validate-required'),
                },
                oetRteName: {
                    "required": $('#oetRteName').attr('data-validate-required'),
                },
                oetCtyRef: {
                    "required": $('#oetCtyRef').attr('data-validate-required'),
                },
                oetVatRate: {
                    "required": $('#oetVatRate').attr('data-validate-required'),
                },
                
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
                $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
            },
            submitHandler: function(form) {


                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: tRouteEvent,
                    data: $("#ofmAddCountry").serialize(),
                    timeout: 0,
                    success: function(tResult) {
                        if (nStaCtyBrowseType != 1) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                    JSvBCHCallPageCountryEdit(aReturn['tCodeReturn'])
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvCallPageCountryAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvCallPageCountryList();
                                }
                            } else {
                                alert(aReturn['tStaMessg']);
                            }

                            //Switch Lang
                            //JCNxInsertLangOtherByMaster(aReturn['tCodeReturn']);
                        } else {
                            JCNxBrowseData(tCallRteBackOption);
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

// Functionality : Call Branch PageEdit
// Parameters : function Parameters
// Creator : 27/03/2018 wasin(yoshi)
// Last Update: 15/01/2019 Wasin(Yoshi)
// Return : View
// Return Type : View
function JSvBCHCallPageCountryEdit(ptCtyCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        // JStCMMGetPanalLangSystemHTML('JSvBCHCallPageCountryEdit', ptCtyCode);
        $.ajax({
            type: "POST",
            url: "countryPageEdit",
            data: {
                tCtyCode: ptCtyCode
            },
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageCountry').html(tResult);
                

                ohdCtyStaRate = $('#ohdCtyStaRate').val();
                $("#ocmExcRte option[value='" + ohdCtyStaRate + "']").attr('selected', true).trigger('change');

                ohdBchStaActive = $('#ohmCtyStaActive').val();
                $("#ocmCtyStaActive option[value='" + ohdBchStaActive + "']").attr('selected', true).trigger('change');

                oetZneCode = $('#oetZneCode').val();
                if (oetZneCode != '') {
                    $('.xWZneName').removeClass('xWCurNotAlw');
                    $('.xWZneName i').removeClass('xWPointerEventNone');

                    $('.xWPvnName').removeClass('xWCurNotAlw');
                    $('.xWPvnName i').removeClass('xWPointerEventNone');
                }

                oetAddV1PvnCode = $('#oetAddV1PvnCode').val();
                if (oetAddV1PvnCode != '') {
                    $('.xWPvnName').removeClass('xWCurNotAlw');
                    $('.xWPvnName i').removeClass('xWPointerEventNone');
                }

                oetAddV1DstCode = $('#oetAddV1DstCode').val();
                if (oetAddV1DstCode != '') {
                    $('.xWDstName').removeClass('xWCurNotAlw');
                    $('.xWDstName i').removeClass('xWPointerEventNone');
                }

                //Put Data
                //Disabled input

                $('#oliCountryTitleEdit').show();
                $('#oliCountryTitleAdd').hide();
                $('#odvBtnCtyInfo').hide();
                $('#odvBtnAddEdit').show();
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

//function : Call Product Unit Data List
//Parameters : Ajax Success Event 
//Creator:	13/09/2018 wasin
//Return : View
//Return Type : View
function JSvCtyDataTable(pnPage) {
    var tSearchAll = $('#oetSearchCty').val();
    var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "countryDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#ostDataCty').html(tResult);
            }
            JSxCtyNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMCountry_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call Product Unit Page Add  
//Parameters : Event Button Click
//Creator : 13/09/2018 wasin
//Update : 29/03/2019 pap
//Return : View
//Return Type : View
function JSvCallPageCountryAdd() {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "countryPageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (nStaCtyBrowseType == 1) {
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
            } else {
                $('.xCNPunVBrowse').hide();
                $('.xCNPunVMaster').show();
                $('#oliCountryTitleEdit').hide();
                $('#oliCountryTitleAdd').show();
                $('#odvBtnCtyInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvContentPageCountry').html(tResult);
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    })
}


//Functionality : function submit by submit button only
//Parameters : route
//Creator : 29/03/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxSubmitEventByButton(ptRoute) {
    if ($("#ohdCheckPunClearValidate").val() == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: ptRoute,
            data: $('#ofmAddPdtUnit').serialize(),
            cache: false,
            timeout: 0,
            success: function(oResult) {
                if (nStaCtyBrowseType != 1) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        switch (aReturn['nStaCallBack']) {
                            case '1':
                                JSvCallPagePdtUnitEdit(aReturn['tCodeReturn']);
                                break;
                            case '2':
                                JSvCallPageCountryAdd();
                                break;
                            case '3':
                                JSvCallPageCountryList(1);
                                break;
                            default:
                                JSvCallPagePdtUnitEdit(aReturn['tCodeReturn']);
                        }
                    } else {
                        JCNxCloseLoading();
                        FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                    }
                } else {
                    JCNxCloseLoading();
                    JCNxBrowseData(tCallPunBackOption);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

//Functionality : Call Product Unit Page Edit  
//Parameters : Event Button Click 
//Creator : 13/09/2018 wasin
//Return : View
//Return Type : View
function JSvCallPagePdtUnitEdit(ptCtyCode) {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPagePdtUnitEdit', ptCtyCode);
    $.ajax({
        type: "POST",
        url: "countryPageEdit",
        data: { tCtyCode: ptCtyCode },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != '') {
                $('#oliCountryTitleAdd').hide();
                $('#oliCountryTitleEdit').show();
                $('#odvBtnCtyInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPageCountry').html(tResult);
                $('#oetPunCode').addClass('xCNDisable');
                $('.xCNDisable').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true);
            }
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : set click status submit form from save button
//Parameters : -
//Creator : 26/03/2019 pap
//Return : -
//Return Type : -
function JSxSetStatusClickPdtUnitSubmit() {
    $("#ohdCheckPunClearValidate").val("1");
}


//Functionality : Event Add/Edit Product Unit
//Parameters : From Submit
//Creator : 13/09/2018 wasin
//Update : 29/03/2019 pap
//Return : Status Event Add/Edit Product Unit
//Return Type : object
function JSoAddEditPdtUnit(ptRoute) {
    if ($("#ohdCheckPunClearValidate").val() == 1) {
        $('#ofmAddPdtUnit').validate().destroy();
        if (!$('#ocbPunAutoGenCode').is(':checked')) {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: {
                    tTableName: "TCNMPdtUnit",
                    tFieldName: "FTPunCode",
                    tCode: $("#oetPunCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicatePunCode").val(aResult["rtCode"]);
                    JSxValidationFormPdtUnit("JSxSubmitEventByButton", ptRoute);
                    $('#ofmAddPdtUnit').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JSxValidationFormPdtUnit("JSxSubmitEventByButton", ptRoute);
        }

    }
}

//Functionality : Generate Code Product Unit
//Parameters : Event Button Click
//Creator : 13/09/2018 wasin
//Return : Event Push Value In Input
//Return Type : -
function JStGeneratePdtUnitCode() {
    var tTableName = 'TCNMPdtUnit';
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "generateCode",
        data: { tTableName: tTableName },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            var tData = $.parseJSON(tResult);
            if (tData.rtCode == '1') {
                $('#oetPunCode').val(tData.rtPunCode);
                $('#oetPunCode').addClass('xCNDisable');
                $('#oetPunCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true);
                $('#oetPunName').focus();
            } else {
                $('#oetPunCode').val(tData.rtDesc);
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Event Single Delete
//Parameters : Event Icon Delete
//Creator : 13/09/2018 wasin
//Update: 01/04/2019 Pap
//Return : object Status Delete
//Return Type : object
function JSoPdtUnitDel(tCurrentPage, tIDCode, tDelName, tYesOnNo) {
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {
        // $('#ospConfirmDelete').html('ยืนยันการลบข้อมูล : ' + tIDCode+' ('+tDelName+')');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + tDelName + ' ) ' + tYesOnNo);
        $('#odvModalDelCty').modal('show');
        $('#osmConfirm').on('click', function(evt) {

            $.ajax({
                type: "POST",
                url: "countryEventDelete",
                data: { 'tIDCode': tIDCode },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturn = JSON.parse(oResult);
                    // alert(aReturn['nStaEvent']);
                    // if (aReturn['nStaEvent'] == '1'){
                    //     $('#odvModalDelCty').modal('hide');
                    //     $('#ospConfirmDelete').empty();
                    //     localStorage.removeItem('LocalItemData');

                    //     setTimeout(function() {
                    //         JSvCallPageCountryList(tCurrentPage);
                    //     }, 500);
                    // }else{
                    //     JCNxOpenLoading();
                    //     alert(aReturn['tStaMessg']);                        
                    // }
                    // JSxCtyNavDefult();



                    if (aReturn['nStaEvent'] == '1') {
                        $('#odvModalDelCty').modal('hide');
                        $('#ospConfirmDelete').empty();
                        localStorage.removeItem('LocalItemData');
                        $('#ohdConfirmIDDelete').val('');
                        $('#ospConfirmIDDelete').val('');
                        setTimeout(function() {
                            if (aReturn["nNumRowCty"] != 0) {
                                if (aReturn["nNumRowCty"] > 10) {
                                    nNumPage = Math.ceil(aReturn["nNumRowCty"] / 10);
                                    if (tCurrentPage <= nNumPage) {
                                        JSvCallPageCountryList(tCurrentPage);
                                    } else {
                                        JSvCallPageCountryList(nNumPage);
                                    }
                                } else {
                                    JSvCallPageCountryList(1);
                                }
                            } else {
                                JSvCallPageCountryList(1);
                            }
                        }, 500);
                    } else {
                        JCNxOpenLoading();
                        alert(tData['tStaMessg']);
                    }
                    JSxCtyNavDefult();
                },

                // error: function(data) {
                //     console.log(data)

                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    }
}

//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 13/09/2018 wasin
//Update: 01/04/2019 Pap
//Return:  object Status Delete
//Return Type: object

function JSoCtyDelChoose() {
    var tCurrentPage = $("#nCurrentPageTB").val();
    JCNxOpenLoading();

    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    for ($i = 0; $i < aDataSplitlength; $i++) {
        aNewIdDelete.push(aDataSplit[$i]);
    }

    if (aDataSplitlength > 1) {

        localStorage.StaDeleteArray = '1';

        $.ajax({
            type: "POST",
            url: "countryEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {

                // setTimeout(function(){
                // 		$('#odvModalDelCty').modal('hide');
                // 		$('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
                // 		$('#ohdConfirmIDDelete').val('');
                // 		localStorage.removeItem('LocalItemData');
                // 		JSvCallPageCountryList(1);
                // 		$('.modal-backdrop').remove();
                // },500);
                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == '1') {
                    $('#odvModalDelCty').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#ohdConfirmIDDelete').val('');
                    $('#ospConfirmIDDelete').val('');
                    setTimeout(function() {
                        if (aReturn["nNumRowCty"] != 0) {
                            if (aReturn["nNumRowCty"] > 10) {
                                nNumPage = Math.ceil(aReturn["nNumRowCty"] / 10);
                                if (tCurrentPage <= nNumPage) {
                                    JSvCallPageCountryList(tCurrentPage);
                                } else {
                                    JSvCallPageCountryList(nNumPage);
                                }
                            } else {
                                JSvCallPageCountryList(1);
                            }
                        } else {
                            JSvCallPageCountryList(1);
                        }
                    }, 500);
                } else {
                    JCNxOpenLoading();
                    alert(tData['tStaMessg']);
                }
                JSxCtyNavDefult();



            },
            error: function(data) {
                console.log(data);
            }
        });


    } else {
        localStorage.StaDeleteArray = '0';

        return false;
    }

}


//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 13/09/2018 wasin
//Return : View
//Return Type : View
function JSvPdtUnitClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagePdtUnit .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน

            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagePdtUnit .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvCtyDataTable(nPageCurrent);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 13/09/2018 wasin
//Return: - 
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
    }
}




//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 13/09/2018 wasin
//Return: -
//Return Type: -

function JSxTextinModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        //Disabled ปุ่ม Delete
        if (aArrayConvert[0].length > 1) {
            $('.xCNIconDel').addClass('xCNDisabled');
        } else {
            $('.xCNIconDel').removeClass('xCNDisabled');
        }

        $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลที่เลือกใช่หรือไม่ ?');
        $('#ohdConfirmIDDelete').val(tTextCode);
    }
}


function JSxBrachVisibleComponent(ptComponent, pbVisible, ptEffect) {
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
        console.log('JSxBrachVisibleComponent Error: ', err);
    }
}