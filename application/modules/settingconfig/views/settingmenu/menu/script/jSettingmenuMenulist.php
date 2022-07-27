<script>
//open ModalMenuList
$('#othSMPAddMenuList').click(function() {
    $('#odvMenuList').val(1);
    JSxSMUClearValidateMenuList()
    $('#odvSMPModalAddEditMenuList').modal({
        backdrop: 'static',
        keyboard: false
    });
    $('#odvSMPModalAddEditMenuList').modal("show");
});


//Functionality: Clear Validate ModalMenuList
//Parameters: -
//Creator: 21/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function JSxSMUClearValidateMenuList() {
    $('#oetSMPMenuListCode').prop('disabled', false);
    $('#oetSMPMenuListModuleCode').val('')
    $('#oetSMPMenuListModuleName').val('')
    $('#oetSMPMenuListMenuGrpCode').val('')
    $('#oetSMPMenuListMenuGrpName').val('')
    $('#oetSMPMenuListCode').val('')
    $('#oetSMPMenuListName').val('')
    $('#oetSMPMenuListRemark').val('')
    $('#oetSMPMenuListRemark').val('')
    $('#oetSMPMenuListControllerName').val('')
    $('#oetSMPMenuListSeq').val('')

    // Clear Validate MenuListcode Input
    $('#oetSMPMenuListCode').parents('.form-group').removeClass("has-error");
    $('#oetSMPMenuListCode').parents('.form-group').removeClass("has-success");
    $('#oetSMPMenuListCode').parents('.form-group').find(".help-block").fadeOut('slow').remove();
    // Clear Validate MenuListname Input
    $('#oetSMPMenuListName').parents('.form-group').removeClass("has-error");
    $('#oetSMPMenuListName').parents('.form-group').removeClass("has-success");
    $('#oetSMPMenuListName').parents('.form-group').find(".help-block").fadeOut('slow').remove();
    // Clear Validate MenuListSeq Input
    $('#oetSMPMenuListSeq').parents('.form-group').removeClass("has-error");
    $('#oetSMPMenuListSeq').parents('.form-group').removeClass("has-success");
    $('#oetSMPMenuListSeq').parents('.form-group').find(".help-block").fadeOut('slow').remove();
    // Clear Validate Modulename Input
    $('#oetSMPMenuListModuleName').parents('.form-group').removeClass("has-error");
    $('#oetSMPMenuListModuleName').parents('.form-group').removeClass("has-success");
    $('#oetSMPMenuListModuleName').parents('.form-group').find(".help-block").fadeOut('slow').remove()
}


//open BrowseModule
$('#oimSMPBrowseModuleMenuList').click(function() {
    $('#odvSMPModalAddEditMenuList').modal("hide");
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) != 'undefined' && nStaSession == 1) {
        window.oSMPBrowseModule = oBrowseModule({
            'tReturnInputCode': 'oetSMPMenuListModuleCode',
            'tReturnInputName': 'oetSMPMenuListModuleName',
        });
        JCNxBrowseData('oSMPBrowseModule');

    } else {
        JCNxShowMsgSessionExpired();
    }
});

//open BrowseMenuGrp
$('#oimSMPBrowseMenuGrp').click(function() {
    $('#odvSMPModalAddEditMenuList').modal("hide");
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) != 'undefined' && nStaSession == 1) {
        window.oSMPBrowseMenuGrp = oBrowseMenuGrp({
            'tReturnInputCode': 'oetSMPMenuListMenuGrpCode',
            'tReturnInputName': 'oetSMPMenuListMenuGrpName',
            'tReturnModCode': $('#oetSMPMenuListModuleCode').val()
        });
        JCNxBrowseData('oSMPBrowseMenuGrp');

    } else {
        JCNxShowMsgSessionExpired();
    }
});


//Browse MenuGrp
var oBrowseMenuGrp = function(poReturnInput) {
    var tInputReturnCode = poReturnInput.tReturnInputCode;
    var tInputReturnName = poReturnInput.tReturnInputName;
    var tInputModCode = poReturnInput.tReturnModCode;

    var oSMPBrowseMenuGrp = {
        Title: ['settingconfig/settingmenu/settingmenu', 'tSettingMenuGroup'],
        Table: {
            Master: 'TSysMenuGrp',
            PK: 'FTGmnCode'
        },
        Join: {
            Table: ['TSysMenuGrp_L'],
            On: ['TSysMenuGrp.FTGmnCode = TSysMenuGrp_L.FTGmnCode AND TSysMenuGrp_L.FNLngID =' +
                nLangEdits
            ]
        },
        Where: {
            Condition: ["AND TSysMenuGrp.FTGmnModCode = '" +
                tInputModCode + "'"
            ]
        },
        GrideView: {
            ColumnPathLang: 'settingconfig/settingmenu/settingmenu',
            ColumnKeyLang: ['tModalMenuGrpCode', 'tModalMenuGrpName'],
            ColumnsSize: ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TSysMenuGrp.FTGmnCode', 'TSysMenuGrp_L.FTGmnName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TSysMenuGrp.FNGmnShwSeq ASC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TSysMenuGrp_L.FTGmnCode"],
            Text: [tInputReturnName, "TSysMenuGrp_L.FTGmnName"]
        },
        NextFunc: {
            FuncName: 'FSxSMUSetMaxSequenceMenuGrp',
            ArgReturn: ['FTGmnCode', 'FTGmnName']
        },
    };
    return oSMPBrowseMenuGrp;
}


//Functionality: Gen ค่าลำดับกลุ่มเมนู
//Parameters: จากการ ฺBrowse MenuGrp
//Creator: 21/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function FSxSMUSetMaxSequenceMenuGrp(tGmnCode) {
    if (tGmnCode == 'NULL') {
        FSxSMUMaxSequence('TSysMenuGrp', 'FTGmnModCode', 'FNGmnShwSeq',$('#oetSMPMenuListModuleCode').val())
        $('#oetSMPMenuListSeq').val(nMaxsequence + 1);
        $('#odvSMPModalAddEditMenuList').modal("show");
    } else {
        oGmnModCode = JSON.parse(tGmnCode)
        if (oGmnModCode[1] == null) {
            $('#oetSMPMenuListMenuGrpName').val(oGmnModCode[0]);
        }
        FSxSMUMaxSequence('TSysMenuList', 'FTGmnCode', 'FNMnuSeq', oGmnModCode[0])
        $('#oetSMPMenuListSeq').val(nMaxsequence + 1);
        $('#odvSMPModalAddEditMenuList').modal("show");
    }
}

//close brows MenuGrp
$(document).on('click', '#myModal .xCNBTNDefult2Btn', function() {
    if ($('#odvMenuList').val() == 1) {
        $('#odvSMPModalAddEditMenuList').modal("show");
    }
});

//Functionality: Event Check MenuList Duplicate
//Parameters:-
//Creator: 20/08/2020  Sooksanti(Non)
//Return: -
//ReturnType: -
function JSxSMUCheckMenuListCodeDupInDB() {
    $.ajax({
        type: "POST",
        url: "CheckInputGenCode",
        data: {
            tTableName: "TSysMenuList",
            tFieldName: "FTMnuCode",
            tCode: $("#oetSMPMenuListCode").val(),
        },
        async: false,
        cache: false,
        timeout: 0,
        success: function(tResult) {
            var aResult = JSON.parse(tResult);
            $("#ohdCheckDuplicateMenuListCode").val(aResult["rtCode"]);
            JSxSMUMenuListSetValidEventBlur();
            $('#ofmSMPAddEditMenuList').submit();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

$('#oetSMPMenuListCode').blur(function() {
    JSxSMUCheckMenuListCodeDupInDB();
});


//Functionality: Set Validate Event Blur
//Parameters: -
//Creator: 21/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function JSxSMUMenuListSetValidEventBlur() {
    $('#ofmSMPAddEditMenuList').validate().destroy();
    $.validator.addMethod('dublicateCode', function(value, element) {
        if ($("#ohdCheckDuplicateMenuListCode").val() == 1) {
            return false;
        } else {
            return true;
        }
    }, '');
    // From Summit Validate
    $('#ofmSMPAddEditMenuList').validate({
        rules: {
            oetSMPMenuListCode: {
                "required": {},
                "dublicateCode": {}
            },
        },
        messages: {
            oetSMPMenuListCode: {
                "required": $('#oetSMPMenuListCode').attr('data-validate-required'),
                "dublicateCode": $('#oetSMPMenuListCode').attr('data-validate-dublicateCode'),
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
            $(element).closest('.form-group').addClass("has-error");
        },
        unhighlight: function(element, errorClass, validClass) {
            var nStaCheckValid = $(element).parents('.form-group').find('.help-block').length
            if (nStaCheckValid != 0) {
                $(element).closest('.form-group').removeClass("has-error");
            }
        },
        submitHandler: function(form) {}
    });
}

//Submit
$("#obtSMPModalMenuListSubmit").click(function() {
    JSxSMUAddEditMenuList();
});


//Functionality: Call Modal EditMenuGrp
//Parameters: มาจากการคลิกปุ่มแก้ไขกลุ่มเมนู
//Creator: 21/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: 
function JSxSMUCallModalMenuListEdit(tMenuListCode, tMenuListName) {
    $.ajax({
        type: "POST",
        url: "CallModalMenuListEdit",
        data: {
            tMenuListCode: tMenuListCode,
        },
        async: false,
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvMenuList').val(1);
            var aResult = JSON.parse(tResult);
            if (aResult['rtCode'] == '1') {
                $('#odvSMPModalAddEditMenuList').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                JSxSMUClearValidateModule();
                $('#odvSMPModalAddEditMenuList').modal("show");
                $('#oetSMPMenuListCode').prop('disabled', true);
                $('#oetSMPMenuListCode').val(aResult['raItems'][0]['FTMnuCode']);
                $('#oetSMPMenuListModuleCode').val(aResult['raItems'][0]['FTGmnModCode']);
                $('#oetSMPMenuListModuleName').val(aResult['raItems'][0]['FTGmnModName']);
                $('#oetSMPMenuListMenuGrpCode').val(aResult['raItems'][0]['FTGmnCode']);
                $('#oetSMPMenuListMenuGrpName').val(aResult['raItems'][0]['FTGmnName']);
                $('#oetSMPMenuListName').val(aResult['raItems'][0]['FTMnuName']);
                $('#oetSMPMenuListRemark').val(aResult['raItems'][0]['FTMnuRmk']);
                $('#oetSMPMenuListControllerName').val(aResult['raItems'][0]['FTMnuCtlName']);
                $('#oetSMPMenuListSeq').val(aResult['raItems'][0]['FNMnuSeq']);
                if (aResult['raItems'][0]['FTAutStaAdd'] == '1') {
                    $('#ocbSMPAutStaAdd').prop('checked', true);

                } else {
                    $('#ocbSMPAutStaAdd').prop('checked', false);
                }

                if (aResult['raItems'][0]['FTAutStaAppv'] == '1') {
                    $('#ocbSMPAutStaAppv').prop('checked', true);
                } else {
                    $('#ocbSMPAutStaAppv').prop('checked', false);
                }

                if (aResult['raItems'][0]['FTAutStaCancel'] == '1') {
                    $('#ocbSMPAutStaCancel').prop('checked', true);
                } else {
                    $('#ocbSMPAutStaCancel').prop('checked', false);
                }

                if (aResult['raItems'][0]['FTAutStaDelete'] == '1') {
                    $('#ocbSMPAutStaDelete').prop('checked', true);
                } else {
                    $('#ocbSMPAutStaDelete').prop('checked', false);
                }

                if (aResult['raItems'][0]['FTAutStaEdit'] == '1') {
                    $('#ocbSMPAutStaEdit').prop('checked', true);
                } else {
                    $('#ocbSMPAutStaEdit').prop('checked', false);
                }

                if (aResult['raItems'][0]['FTAutStaPrint'] == '1') {
                    $('#ocbSMPAutStaPrint').prop('checked', true);
                } else {
                    $('#ocbSMPAutStaPrint').prop('checked', false);
                }

                if (aResult['raItems'][0]['FTAutStaPrintMore'] == '1') {
                    $('#ocbSMPAutStaPrintMore').prop('checked', true);
                } else {
                    $('#ocbSMPAutStaPrintMore').prop('checked', false);
                }

                if (aResult['raItems'][0]['FTAutStaRead'] == '1') {
                    $('#ocbSMPAutStaRead').prop('checked', true);
                } else {
                    $('#ocbSMPAutStaRead').prop('checked', false);
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality: Modal DeleteMenuGrp Confirm
//Parameters: มาจากการคลิกลบกลุ่มเมนู
//Creator: 21/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: 
function JSxSMUMenuListDel(tMenuListCode, tMenuListName, tYesOrNo) {
    $('#odvSMPModalDelModule').modal('show');
    $('#odvSMPModalDelModule #ospConfirmDelete').html('<p><strong>' + $('#oetTextComfirmDeleteSingle').val() +
        tMenuListCode +
        ' ( ' +
        tMenuListName + ' ) ' + '</strong></p>');
    $('#ohdConfirmIDDelete').val('SettingMenuDelMenuList');
    $('#osmConfirm').val(tMenuListCode);
}
</script>