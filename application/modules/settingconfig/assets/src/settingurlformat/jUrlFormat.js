var nStaCtyBrowseType = $('#oetPunStaBrowse').val();
var tCallPunBackOption = $('#oetPunCallBackOption').val();
// alert(nStaCtyBrowseType+'//'+tCallPunBackOption);

$('document').ready(function() {
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxUrlNavDefult();
    if (nStaCtyBrowseType != 1) {
        JSvCallPageURLList(1);
    } else {
        JSvCallPageURLAdd();
    }
    localStorage.removeItem('LocalItemData');
});

///function : Function Clear Defult Button Product Unit
//Parameters : Document Ready
//Creator : 13/09/2018 wasin
//Return : Show Tab Menu
//Return Type : -
function JSxUrlNavDefult() {
    if (nStaCtyBrowseType != 1 || nStaCtyBrowseType == undefined) {
        $('.xCNChoose').hide();
        $('#oliUrlTitleAdd').hide();
        $('#oliUrlTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnUrlInfo').show();
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
function JSvCallPageURLList(pnPage) {
    localStorage.tStaPageNow = 'JSvCallPageURLList';
    $('#oetSearchAll').val('');
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "urlList",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvContentPageUrl').html(tResult);
            JSvUrlDataTable(pnPage);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


function JSnAddUrl(tRouteEvent) {
    $('#odvModalUrlStaUse').modal('hide');
    $(".modal-backdrop").remove();
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: tRouteEvent,
        data: $("#ofmAddUrl").serialize(),
        timeout: 0,
        success: function(tResult) {
            if (nStaCtyBrowseType != 1) {
                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == 1) {
                    if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                        JSvURLCallPageUrlEdit(aReturn['tCodeReturn'])
                    } else if (aReturn['nStaCallBack'] == '2') {
                        JSvCallPageURLAdd();
                    } else if (aReturn['nStaCallBack'] == '3') {
                        JSvCallPageURLList();
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

//Functionality : (event) Add/Edit Reason
//Parameters : form
//Creator : 27/03/2018 wasin(yoshi)
//Return : Status Add
//Return Type : n
function JSnAddEditUrl(tRouteEvent) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddUrl').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (tRouteEvent == "urlEventAdd") {
                if ($("#ohdCheckDuplicateUrlCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmAddUrl').validate({
            rules: {
                oetUrlCode: {
                    "required": {
                        depends: function(oElement) {
                            if (tRouteEvent == "urlEventAdd") {
                                if ($('#ocbUrlAutoGenCode').is(':checked')) {
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
                oetUrlFormatName: {"required": {}}
                
            },
            messages: {
                oetUrlCode: {
                    "required"      : $('#oetUrlCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetUrlCode').attr('data-validate-dublicateCode')
                },      
                oetUrlFormatName:   {
                    "required"      : $('#oetUrlFormatName').attr('data-validate-required'),
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
                $.ajax({
                        type: "POST",
                        url: 'urlCheckStaUse',
                        data: $("#ofmAddUrl").serialize(),
                        timeout: 0,
                        success: function(tResult) {

                                var aReturn = JSON.parse(tResult);
                                console.log(aReturn['rtCode'])
                                if(aReturn['rtCode'] == '1' && $('#ocmUrlStaActive').val()=='1'){
                                    $('#osphaha').html(aReturn['rnAllRow'][0]['FTFspCode']+' '+'('+aReturn['rnAllRow'][0]['FTFmtName']+')')
                                    $('#odvModalUrlStaUse').modal('show');
                                    
                                }else{
                                    JSnAddUrl(tRouteEvent)
                                }
                                //Switch Lang
                                //JCNxInsertLangOtherByMaster(aReturn['tCodeReturn']);
                           
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
function JSvURLCallPageUrlEdit(ptUrlCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        // JStCMMGetPanalLangSystemHTML('JSvURLCallPageUrlEdit', ptUrlCode);
        $.ajax({
            type: "POST",
            url: "urlPageEdit",
            data: {
                tUrlCode: ptUrlCode
            },
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageUrl').html(tResult);

                ohdUrlStaActive = $('#ohmUrlStaActive').val();
                $("#ocmUrlStaActive option[value='" + ohdUrlStaActive + "']").attr('selected', true).trigger('change');

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
                 //Put Data
                //Disabled input
                $('#oetUrlCode').addClass('xCNCursorNotAlw').attr('readonly', true);
                $('#odvUrlAutoGenCode').addClass('xCNHide');

                $('#oliUrlTitleEdit').show();
                $('#oliUrlTitleAdd').hide();
                $('#odvBtnUrlInfo').hide();
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
function JSvUrlDataTable(pnPage) {
    var tSearchAll = $('#oetSearchCty').val();
    var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "urlDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#ostDataUrl').html(tResult);
            }
            JSxUrlNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMCountry_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
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
 function JCNbUrlIsCreatePage() {
    try {
        const tBchCode = $('#oetUrlCode').data('is-created');
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
function JCNbUrlsUpdatePage() {
    try {
        const tBchCode = $('#oetUrlCode').data('is-created');
        var bStatus = false;
        if (!tBchCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JCNbUrlsUpdatePage Error: ', err);
    }
}

//Functionality : Call Product Unit Page Add  
//Parameters : Event Button Click
//Creator : 13/09/2018 wasin
//Update : 29/03/2019 pap
//Return : View
//Return Type : View
function JSvCallPageURLAdd() {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "urlPageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (nStaCtyBrowseType == 1) {
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
            } else {
                $('.xCNPunVBrowse').hide();
                $('.xCNPunVMaster').show();
                $('#oliUrlTitleEdit').hide();
                $('#oliUrlTitleAdd').show();
                $('#odvBtnUrlInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvContentPageUrl').html(tResult);
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
                                JSvCallPageUrlEdit(aReturn['tCodeReturn']);
                                break;
                            case '2':
                                JSvCallPageURLAdd();
                                break;
                            case '3':
                                JSvCallPageURLList(1);
                                break;
                            default:
                                JSvCallPageUrlEdit(aReturn['tCodeReturn']);
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
function JSvCallPageUrlEdit(ptUrlCode) {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPageUrlEdit', ptUrlCode);
    $.ajax({
        type: "POST",
        url: "urlPageEdit",
        data: { tUrlCode: ptUrlCode },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != '') {
                $('#oliUrlTitleAdd').hide();
                $('#oliUrlTitleEdit').show();
                $('#odvBtnUrlInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPageUrl').html(tResult);
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




//Functionality : Event Single Delete
//Parameters : Event Icon Delete
//Creator : 13/09/2018 wasin
//Update: 01/04/2019 Pap
//Return : object Status Delete
//Return Type : object
function JSoUrlDel(tCurrentPage, tIDCode, tDelName, tYesOnNo) {
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {
        // $('#ospConfirmDelete').html('ยืนยันการลบข้อมูล : ' + tIDCode+' ('+tDelName+')');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + tDelName + ' ) ' + tYesOnNo);
        $('#odvModalDelUrl').modal('show');
        $('#osmConfirm').on('click', function(evt) {

            $.ajax({
                type: "POST",
                url: "urlEventDelete",
                data: { 'tIDCode': tIDCode },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturn = JSON.parse(oResult);
                    // alert(aReturn['nStaEvent']);
                    // if (aReturn['nStaEvent'] == '1'){
                    //     $('#odvModalDelUrl').modal('hide');
                    //     $('#ospConfirmDelete').empty();
                    //     localStorage.removeItem('LocalItemData');

                    //     setTimeout(function() {
                    //         JSvCallPageURLList(tCurrentPage);
                    //     }, 500);
                    // }else{
                    //     JCNxOpenLoading();
                    //     alert(aReturn['tStaMessg']);                        
                    // }
                    // JSxUrlNavDefult();



                    if (aReturn['nStaEvent'] == '1') {
                        $('#odvModalDelUrl').modal('hide');
                        $('#ospConfirmDelete').empty();
                        localStorage.removeItem('LocalItemData');
                        $('#ohdConfirmIDDelete').val('');
                        $('#ospConfirmIDDelete').val('');
                        setTimeout(function() {
                            if (aReturn["nNumRowUrlFmt"] != 0) {
                                if (aReturn["nNumRowUrlFmt"] > 10) {
                                    nNumPage = Math.ceil(aReturn["nNumRowUrlFmt"] / 10);
                                    if (tCurrentPage <= nNumPage) {
                                        JSvCallPageURLList(tCurrentPage);
                                    } else {
                                        JSvCallPageURLList(nNumPage);
                                    }
                                } else {
                                    JSvCallPageURLList(1);
                                }
                            } else {
                                JSvCallPageURLList(1);
                            }
                        }, 500);
                    } else {
                        JCNxOpenLoading();
                        alert(tData['tStaMessg']);
                    }
                    JSxUrlNavDefult();
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

function JSoUrlDelChoose() {
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
            url: "urlEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {

                // setTimeout(function(){
                // 		$('#odvModalDelUrl').modal('hide');
                // 		$('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
                // 		$('#ohdConfirmIDDelete').val('');
                // 		localStorage.removeItem('LocalItemData');
                // 		JSvCallPageURLList(1);
                // 		$('.modal-backdrop').remove();
                // },500);
                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == '1') {
                    $('#odvModalDelUrl').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#ohdConfirmIDDelete').val('');
                    $('#ospConfirmIDDelete').val('');
                    setTimeout(function() {
                        if (aReturn["nNumRowUrlFmt"] != 0) {
                            if (aReturn["nNumRowUrlFmt"] > 10) {
                                nNumPage = Math.ceil(aReturn["nNumRowUrlFmt"] / 10);
                                if (tCurrentPage <= nNumPage) {
                                    JSvCallPageURLList(tCurrentPage);
                                } else {
                                    JSvCallPageURLList(nNumPage);
                                }
                            } else {
                                JSvCallPageURLList(1);
                            }
                        } else {
                            JSvCallPageURLList(1);
                        }
                    }, 500);
                } else {
                    JCNxOpenLoading();
                    alert(tData['tStaMessg']);
                }
                JSxUrlNavDefult();



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
function JSvUrlClickPage(ptPage) {
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
    JSvUrlDataTable(nPageCurrent);
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




//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Reason
//Creator: 13/09/2018 wasin
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

/**
 * Functionality : Show or Hide Component
 * Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
 * Creator : 12/06/2019 saharat(Golf)
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
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