<script type="text/javascript">
    $(document).ready(function() {
        window.rowValidate = $('#ofmCardShiftStatusDataSourceForm').validate({
            /*rules: {
             oetCardShiftStatusCardName1: {
             required: true,
             uniqueCardShiftStatusCode: JCNbCardShiftStatusIsCreatePage(),
             maxlength: 20
             },
             ['oetCardShiftStatusNewCardName' + pnSeq]: {
             required: true
             }
             },*/
            messages: {
                // oetCardShiftStatusCode: "",
                // oetCardShiftStatusName: ""
            },
            /*errorClass: "alert-validate",
             validClass: "",*/
            submitHandler: function (form) {
                /*var aCardPack = JSaCardShiftStatusGetDataSourceCode("cardPack", false);
                 console.log("aCardCode: ", aCardPack);
                 $.ajax({
                 type: "POST",
                 url: ptRoute,
                 data: $('#ofmAddCardShiftStatusMainForm').serialize() + "&" + $('#ofmSearchCard').serialize() + "&aCard=" + JSON.stringify(aCardPack),
                 cache: false,
                 timeout: 0,
                 success: function(tResult) {
                 JSvCardShiftStatusCallPageCardShiftStatusEdit($("#oetCardShiftStatusCode").val());
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                 JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown);
                 }
                 });*/
            },
            /*errorPlacement: function(error, element) {
             $(element).parent('.validate-input').attr('data-validate', error[0].textContent);
             }
             highlight: function(element, errorClass, validClass) {
             $(element).parent().addClass(errorClass).removeClass(validClass);
             },
             unhighlight: function(element, errorClass, validClass) {
             $(element).parent().removeClass(errorClass).addClass(validClass);
             },*/
            errorElement: "em",
            errorPlacement: function (error, element) {
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
            highlight: function (element, errorClass, validClass) {
                $(element).addClass("has-error").removeClass("has-success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).addClass("has-success").removeClass("has-error");
            }
        });
    });

    /**
     * Functionality : Delete Record Before to Save.
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 24/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftStatusDataSourceDeleteOperator(poElement, poEvent, pnPage, ptOldCardCode, pnSeq) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                pnPage = (typeof pnPage !== 'undefined') ?  pnPage : 1;   
                if (JSbCardShiftStatusIsApv() || JSbCardShiftStatusIsStaDoc("cancel")) {
                    return;
                }
                $('#ospCardShiftStatusConfirDelMessage').html(ptOldCardCode);
                $('#odvCardShiftStatusModalConfirmDelRecord').modal({backdrop: 'static', keyboard: false});
                $('#odvCardShiftStatusModalConfirmDelRecord').modal('show');
                $('#osmCardShiftStatusConfirmDelRecord').unbind().click(function(evt) {
                    $('#odvCardShiftStatusModalConfirmDelRecord').modal('hide');
                    $.ajax({
                        type: "POST",
                        url: "CallDeleteTemp",
                        data: {ptID: ptOldCardCode, pnSeq: pnSeq, ptDocType: "cardShiftStatus"},
                        cache: false,
                        timeout: 0,
                        success: function (tResult) {
                            JSvCardShiftStatusDataSourceTable(pnPage, [], [], [], true, "1", false, false, [], "1", "");
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });  
                    JSxCardShiftStatusSetCountNumber();
                    JSxCardShiftStatusSetCardCodeTemp(); 
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSxCardShiftStatusDataSourceDeleteOperator Error: ', err);
    }
    }

    /**
     * Functionality : Edit Record Before to Save.
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 24/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftStatusDataSourceEditOperator(poElement, poEvent, pnSeq) {
        try {
            if (JSbCardShiftStatusIsApv() || JSbCardShiftStatusIsStaDoc("cancel")) {
                return;
            }
            JSxCardShiftStatusSetCardCodeTemp();
            let tRecordId = $(poElement).parents('.xWCardShiftStatusDataSource').attr('id');
            let oRecord = {
                tNewCardCode: $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusNewCardCode input[type=hidden]').val(),
                tNewCardName: $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusNewCardCode input[type=text]').val(),
                tOldCardCode: $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusCardCode input[type=hidden]').val(),
                tOldCardName: $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusCardCode input[type=text]').val(),
                tReasonCode: $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusReason input[type=hidden]').val(),
                tReasonName: $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusReason input[type=text]').val()
            };
            // Backup Seft Record
            localStorage.setItem(tRecordId, JSON.stringify(oRecord));

            // Visibled icons
            JSxCardShiftStatusDataSourceVisibledOperationIcon(poElement, 'edit', false); // Itself hidden(edit)
            JSxCardShiftStatusDataSourceVisibledOperationIcon(poElement, 'cancel', true); // hidden cancel icon
            JSxCardShiftStatusDataSourceVisibledOperationIcon(poElement, 'save', true); // hidden save icon

            $(poElement) // Active Old Card Code Field.
                    .parents('.xWCardShiftStatusDataSource')
                    .find('.xWCardShiftStatusCardCode input[type=text]')
                    .removeAttr('disabled')
                    .attr('readonly', true)
                    .addClass('btn');

            $(poElement) // Active New Card Name Field.
                    .parents('.xWCardShiftStatusDataSource')
                    .find('.xWCardShiftStatusNewCardCode input[type=text]')
                    .removeAttr('disabled')
                    .attr('readonly', true)
                    .addClass('btn');

            $(poElement) // Active Reason Name Field.
                    .parents('.xWCardShiftStatusDataSource')
                    .find('.xWCardShiftStatusReason input[type=text]')
                    .removeAttr('disabled')
                    .attr('readonly', true)
                    .addClass('btn');

        } catch (err) {
            console.log('JSxEditOperator Error: ', err);
    }
    }

    /**
     * Functionality : Cancel Edit Record Before to Save.
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 24/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftStatusDataSourceCancelOperator(poElement, poEvent) {
        try {
            var tRecordId = $(poElement).parents('.xWCardShiftStatusDataSource').attr('id');

            // Restore Seft Record
            var oBackupRecord = JSON.parse(localStorage.getItem(tRecordId));
            $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusNewCardCode input[type=hidden]').val(oBackupRecord.tNewCardCode);
            $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusNewCardCode input[type=text]').val(oBackupRecord.tNewCardName);
            $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusCardCode input[type=hidden]').val(oBackupRecord.tOldCardCode);
            $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusCardCode input[type=text]').val(oBackupRecord.tOldCardName);
            $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusReason input[type=hidden]').val(oBackupRecord.tReasonCode);
            $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusReason input[type=text]').val(oBackupRecord.tReasonName);

            // Remove Seft Record Backup
            localStorage.removeItem(tRecordId);

            // Visibled icons
            JSxCardShiftStatusDataSourceVisibledOperationIcon(poElement, 'cancel', false); // Itself hidden(cancel)
            JSxCardShiftStatusDataSourceVisibledOperationIcon(poElement, 'save', false); // hidden save icon
            JSxCardShiftStatusDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon

            $(poElement) // Remove Active Old Card Code Field.
                    .parents('.xWCardShiftStatusDataSource')
                    .find('.xWCardShiftStatusCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

            $(poElement) // Remove Active New Card Name Field.
                    .parents('.xWCardShiftStatusDataSource')
                    .find('.xWCardShiftStatusNewCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

            $(poElement) // Remove Active Reason Name Field.
                    .parents('.xWCardShiftStatusDataSource')
                    .find('.xWCardShiftStatusReason input[type=text]')
                    .attr('disabled', true)
                    .attr('readonly', true)
                    .removeClass('btn');

        } catch (err) {
            console.log('JSxCancelOperator Error: ', err);
    }
    }

    /**
     * Functionality : Confirm Record Before to Save.
     * Parameters : poElement is Itself element, poEvent is Itself event, pnSeq is index in loop
     * Creator : 24/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftStatusDataSourceSaveOperator(poElement, poEvent) {
        try {
            var tRecordId = $(poElement).parents('.xWCardShiftStatusDataSource').attr('id');
            var oPrefixNumber = tRecordId.match(/\d+/);
            
            let oRecord = {
                nPage: $('#ohdCardShiftStatusDataSourceCurrentPage').val(),
                nSeq: $(poElement).parents('.xWCardShiftStatusDataSource').data('seq'),
                tNewCardCode: $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusNewCardCode input[type=hidden]').val(),
                tNewCardName: $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusNewCardCode input[type=text]').val(),
                tOldCardCode: $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusCardCode input[type=hidden]').val(),
                tOldCardName: $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusCardCode input[type=text]').val(),
                tReasonCode: $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusReason input[type=hidden]').val(),
                tReasonName: $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusReason input[type=text]').val()
            };
            
            // เช็ค Validate Row
            /*var nStaChkSaveRow = JSnCardShiftStatusChkValidateSaveRow(aDataChkValidateRow);
            if (nStaChkSaveRow == 0) {
                $('#' + tRecordId + ' .xWCardShiftStatusStatus .xWNewCardStatusRmk').val(nStaChkSaveRow);
                $('#' + tRecordId + ' .xWCardShiftStatusStatus .xWNewCardStatus').val(1);
            } else {
                $('#' + tRecordId + ' .xWCardShiftStatusStatus .xWNewCardStatusRmk').val(nStaChkSaveRow);
                $('#' + tRecordId + ' .xWCardShiftStatusStatus .xWNewCardStatus').val(2);
            }*/
            
            // Update in document temp
            JSxCardShiftStatusUpdateDataOnTemp(oRecord.tOldCardCode, oRecord.tNewCardCode, oRecord.tReasonCode, oRecord.nSeq, oRecord.nPage);
            
            // Remove Seft Record Backup
            localStorage.removeItem(tRecordId);
            // Visibled icons
            JSxCardShiftStatusDataSourceVisibledOperationIcon(poElement, 'save', false); // Itself hidden(save)
            JSxCardShiftStatusDataSourceVisibledOperationIcon(poElement, 'cancel', false); // hidden cancel icon
            JSxCardShiftStatusDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon

            $(poElement) // Remove Active Old Card Code Field.
                    .parents('.xWCardShiftStatusDataSource')
                    .find('.xWCardShiftStatusCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

            $(poElement) // Remove Active New Card Name Field.
                    .parents('.xWCardShiftStatusDataSource')
                    .find('.xWCardShiftStatusNewCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

            $(poElement) // Remove Active Reason Name Field.
                    .parents('.xWCardShiftStatusDataSource')
                    .find('.xWCardShiftStatusReason input[type=text]')
                    .attr('disabled', true)
                    .attr('readonly', true)
                    .removeClass('btn');

        } catch (err) {
            console.log('JSxSaveOperator Error: ', err);
        }
    }

    /**
     * Functionality : Visibled operation icon
     * Parameters : [poElement] is seft element in scope(<tr class="xWCardShiftStatusDataSource">), 
     * [ptOperation] is icon type(edit, cancel, save), [pbVisibled] is true = show, false = hide
     * Creator : 07/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftStatusDataSourceVisibledOperationIcon(poElement, ptOperation, pbVisibled) {
        try {
            switch (ptOperation) {
                case 'edit' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftStatusDataSource')
                                .find('.xWCardShiftStatusEdit'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftStatusDataSource')
                                .find('.xWCardShiftStatusEdit'))
                                .addClass('hidden');
                    }
                    break;
                }
                case 'cancel' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftStatusDataSource')
                                .find('.xWCardShiftStatusCancel'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftStatusDataSource')
                                .find('.xWCardShiftStatusCancel'))
                                .addClass('hidden');
                    }
                    break;
                }
                case 'save' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftStatusDataSource')
                                .find('.xWCardShiftStatusSave'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftStatusDataSource')
                                .find('.xWCardShiftStatusSave'))
                                .addClass('hidden');
                    }
                    break;
                }
                default :
                {
                }
            }
        } catch (err) {
            console.log('JJSxCardShiftStatusDataSourceVisibledOperationIcon Error: ', err);
        }
    }

    /**
     * Functionality : Validate inline.
     * Parameters : -
     * Creator : 26/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftStatusValidateInline() {
        $('#obtCardShiftStatusSubmitForm').click();
        $('#ofmCardShiftStatusDataSourceForm').validate({
            rules: {
                oetCardShiftStatusCardName1: {
                    required: true,
                    uniqueCardShiftStatusCode: JCNbCardShiftStatusIsCreatePage(),
                    maxlength: 20
                },
                oetCardShiftStatusNewCardName1: {
                    required: true
                }
            },
            messages: {
                // oetCardShiftStatusCode: "",
                // oetCardShiftStatusName: ""
            },
            /*errorClass: "alert-validate",
             validClass: "",*/
            submitHandler: function (form) {
                /*var aCardPack = JSaCardShiftStatusGetDataSourceCode("cardPack", false);
                 console.log("aCardCode: ", aCardPack);
                 $.ajax({
                 type: "POST",
                 url: ptRoute,
                 data: $('#ofmAddCardShiftStatusMainForm').serialize() + "&" + $('#ofmSearchCard').serialize() + "&aCard=" + JSON.stringify(aCardPack),
                 cache: false,
                 timeout: 0,
                 success: function(tResult) {
                 JSvCardShiftStatusCallPageCardShiftStatusEdit($("#oetCardShiftStatusCode").val());
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                 JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown);
                 }
                 });*/
            },
            /*errorPlacement: function(error, element) {
             $(element).parent('.validate-input').attr('data-validate', error[0].textContent);
             }
             highlight: function(element, errorClass, validClass) {
             $(element).parent().addClass(errorClass).removeClass(validClass);
             },
             unhighlight: function(element, errorClass, validClass) {
             $(element).parent().removeClass(errorClass).addClass(validClass);
             },*/
            errorElement: "em",
            errorPlacement: function (error, element) {
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
            highlight: function (element, errorClass, validClass) {
                $(element).addClass("has-error").removeClass("has-success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).addClass("has-success").removeClass("has-error");
            }
        });
    }
    
    /**
     * Functionality : Function Check Validate Row Tabel
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 10/12/2018 wasin(Yoshi)
     * Return : Status Check Validate
     * Return Type : Number
     */
    function JSnCardShiftStatusChkValidateSaveRow(paDataChkValidateRow) {
        try {
            if (paDataChkValidateRow['tCrdShiftNewCardCode'] != "") {
                var nStaChkCodeDup = $.ajax({
                    type: "POST",
                    url: "cardShiftNewCardChkCardCodeDup",
                    data: {tCardCodeChkDup: paDataChkValidateRow['tCrdShiftNewCardCode']},
                    async: false
                }).responseText;
                if (nStaChkCodeDup != 0) {
                    return 4;
                }
            } else {
                return 1;
            }

            if (paDataChkValidateRow['tCrdShiftNewCardName'] != "") {
                var tCharacterReg = /^\s*[a-z,A-Z,ก-๙, ,0-9,@,-]+\s*$/;
                var tCardName = paDataChkValidateRow['tCrdShiftNewCardName'];
                if (tCharacterReg.test(tCardName) == false) {
                    return 16;
                }
            }

            if (paDataChkValidateRow['tCrdShiftNewCtyCode'] == "" && paDataChkValidateRow['tCrdShiftNewCtyName'] == "") {
                return 5;
            }

            if (paDataChkValidateRow['tCrdShiftNewDptCode'] == "" && paDataChkValidateRow['tCrdShiftNewDptName'] == "") {
                return 12;
            }
            return 0;
        } catch (err) {
            console.log('Error JSnCardShiftNewCardChkValidateSaveRow' + err);
        }
    }

    function JSvCardShiftStatusDataSourceClickPage(ptPage, tDocType, ptIDElement) {
        JCNxOpenLoading();

        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                nPageOld = $('.xWCardShiftStatusDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWCardShiftStatusDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }
        JSvCardShiftStatusDataSourceTable(nPageCurrent, [], [], [], true, "1", false, false, [], "1", "");
        // JSvClickCallTableTemp(tDocType, nPageCurrent, ptIDElement);
    }
</script>
