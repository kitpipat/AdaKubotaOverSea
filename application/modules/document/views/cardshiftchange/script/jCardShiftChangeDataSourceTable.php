<script type="text/javascript">
    $(document).ready(function() {
        window.rowValidate = $('#ofmCardShiftChangeDataSourceForm').validate({
            /*rules: {
             oetCardShiftChangeCardName1: {
             required: true,
             uniqueCardShiftChangeCode: JCNbCardShiftChangeIsCreatePage(),
             maxlength: 20
             },
             ['oetCardShiftChangeNewCardName' + pnSeq]: {
             required: true
             }
             },*/
            messages: {
                // oetCardShiftChangeCode: "",
                // oetCardShiftChangeName: ""
            },
            /*errorClass: "alert-validate",
             validClass: "",*/
            submitHandler: function (form) {
                /*var aCardPack = JSaCardShiftChangeGetDataSourceCode("cardPack", false);
                 console.log("aCardCode: ", aCardPack);
                 $.ajax({
                 type: "POST",
                 url: ptRoute,
                 data: $('#ofmAddCardShiftChangeMainForm').serialize() + "&" + $('#ofmSearchCard').serialize() + "&aCard=" + JSON.stringify(aCardPack),
                 cache: false,
                 timeout: 0,
                 success: function(tResult) {
                 JSvCardShiftChangeCallPageCardShiftChangeEdit($("#oetCardShiftChangeCode").val());
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                 JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
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
    function JSxCardShiftChangeDataSourceDeleteOperator(poElement, poEvent, pnPage, ptOldCardCode, pnSeq) {
        try {
            pnPage = (typeof pnPage !== 'undefined') ?  pnPage : 1;
            
            if (JSbCardShiftChangeIsApv() || JSbCardShiftChangeIsStaDoc("cancel")) {
                return;
            }
            $('#ospCardShiftChangeConfirDelMessage').html(ptOldCardCode);
            $('#odvCardShiftChangeModalConfirmDelRecord').modal({backdrop: 'static', keyboard: false});
            $('#odvCardShiftChangeModalConfirmDelRecord').modal('show');
            
            $('#osmCardShiftChangeConfirmDelRecord').unbind().click(function(evt) {
                
                $('#odvCardShiftChangeModalConfirmDelRecord').modal('hide');

                $.ajax({
                    type: "POST",
                    url: "CallDeleteTemp",
                    data: {ptID: ptOldCardCode, pnSeq: pnSeq, ptDocType: "CardTnfChangeCard"},
                    cache: false,
                    success: function (tResult) {
                        JSvCardShiftChangeDataSourceTable(pnPage, [], [], [], [], [], true, "1", false, false, [], "1", "");
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
                
                JSxCardShiftChangeSetCountNumber();
                JSxCardShiftChangeSetCardCodeTemp();
                
            });

        } catch (err) {
            console.log('JSxCardShiftChangeDataSourceDeleteOperator Error: ', err);
    }
    }

    /**
     * Functionality : Edit Record Before to Save.
     * Parameters : poElement is Itself element, poEvent is Itself event, pnSeq
     * Creator : 24/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeDataSourceEditOperator(poElement, poEvent, pnSeq) {
        try {
            if (JSbCardShiftChangeIsApv() || JSbCardShiftChangeIsStaDoc("cancel")) {
                return;
            }
            JSxCardShiftChangeSetCardCodeTemp();
            let tRecordId = $(poElement).parents('.xWCardShiftChangeDataSource').attr('id');
            let oRecord = {
                tNewCardCode: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeNewCardCode input[type=hidden]').val(),
                tNewCardName: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeNewCardCode input[type=text]').val(),
                tOldCardCode: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeCardCode input[type=hidden]').val(),
                tOldCardName: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeCardCode input[type=text]').val(),
                tReasonCode: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeReason input[type=hidden]').val(),
                tReasonName: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeReason input[type=text]').val()
            };
            // Backup Seft Record
            localStorage.setItem(tRecordId, JSON.stringify(oRecord));

            // Visibled icons
            JSxCardShiftChangeDataSourceVisibledOperationIcon(poElement, 'edit', false); // Itself hidden(edit)
            JSxCardShiftChangeDataSourceVisibledOperationIcon(poElement, 'cancel', true); // hidden cancel icon
            JSxCardShiftChangeDataSourceVisibledOperationIcon(poElement, 'save', true); // hidden save icon

            $(poElement) // Active Old Card Code Field.
                    .parents('.xWCardShiftChangeDataSource')
                    .find('.xWCardShiftChangeCardCode input[type=text]')
                    .removeAttr('disabled')
                    .attr('readonly', true)
                    .addClass('btn');

            $(poElement) // Active New Card Name Field.
                    .parents('.xWCardShiftChangeDataSource')
                    .find('.xWCardShiftChangeNewCardCode input[type=text]')
                    .removeAttr('disabled')
                    .attr('readonly', true)
                    .addClass('btn');

            $(poElement) // Active Reason Name Field.
                    .parents('.xWCardShiftChangeDataSource')
                    .find('.xWCardShiftChangeReason input[type=text]')
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
    function JSxCardShiftChangeDataSourceCancelOperator(poElement, poEvent) {
        try {
            var tRecordId = $(poElement).parents('.xWCardShiftChangeDataSource').attr('id');

            // Restore Seft Record
            var oBackupRecord = JSON.parse(localStorage.getItem(tRecordId));
            $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeNewCardCode input[type=hidden]').val(oBackupRecord.tNewCardCode);
            $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeNewCardCode input[type=text]').val(oBackupRecord.tNewCardName);
            $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeCardCode input[type=hidden]').val(oBackupRecord.tOldCardCode);
            $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeCardCode input[type=text]').val(oBackupRecord.tOldCardName);
            $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeReason input[type=hidden]').val(oBackupRecord.tReasonCode);
            $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeReason input[type=text]').val(oBackupRecord.tReasonName);

            // Remove Seft Record Backup
            localStorage.removeItem(tRecordId);

            // Visibled icons
            JSxCardShiftChangeDataSourceVisibledOperationIcon(poElement, 'cancel', false); // Itself hidden(cancel)
            JSxCardShiftChangeDataSourceVisibledOperationIcon(poElement, 'save', false); // hidden save icon
            JSxCardShiftChangeDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon

            $(poElement) // Remove Active Old Card Code Field.
                    .parents('.xWCardShiftChangeDataSource')
                    .find('.xWCardShiftChangeCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

            $(poElement) // Remove Active New Card Name Field.
                    .parents('.xWCardShiftChangeDataSource')
                    .find('.xWCardShiftChangeNewCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

            $(poElement) // Remove Active Reason Name Field.
                    .parents('.xWCardShiftChangeDataSource')
                    .find('.xWCardShiftChangeReason input[type=text]')
                    .attr('disabled', true)
                    .attr('readonly', true)
                    .removeClass('btn');

        } catch (err) {
            console.log('JSxCancelOperator Error: ', err);
    }
    }

    /**
     * Functionality : Confirm Record Before to Save.
     * Parameters : poElement is Itself element, poEvent is Itself event, pnSeq is index in loop, pnSeq
     * Creator : 24/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeDataSourceSaveOperator(poElement, poEvent, pnSeq) {
        try {
            var tRecordId = $(poElement).parents('.xWCardShiftChangeDataSource').attr('id');
            var oPrefixNumber = tRecordId.match(/\d+/);
            
            let oRecord = {
                nPage: $('#ohdCardShiftChangeDataSourceCurrentPage').val(),
                nSeq: $(poElement).parents('.xWCardShiftChangeDataSource').data('seq'),
                tNewCardCode: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeNewCardCode input[type=hidden]').val(),
                tNewCardName: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeNewCardCode input[type=text]').val(),
                tOldCardCode: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeCardCode input[type=hidden]').val(),
                tOldCardName: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeCardCode input[type=text]').val(),
                tReasonCode: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeReason input[type=hidden]').val(),
                tReasonName: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeReason input[type=text]').val()
            };
            
            // เช็ค Validate Row
            /*var nStaChkSaveRow = JSnCardShiftChangeChkValidateSaveRow(aDataChkValidateRow);
            if (nStaChkSaveRow == 0) {
                $('#' + tRecordId + ' .xWCardShiftChangeStatus .xWNewCardStatusRmk').val(nStaChkSaveRow);
                $('#' + tRecordId + ' .xWCardShiftChangeStatus .xWNewCardStatus').val(1);
            } else {
                $('#' + tRecordId + ' .xWCardShiftChangeStatus .xWNewCardStatusRmk').val(nStaChkSaveRow);
                $('#' + tRecordId + ' .xWCardShiftChangeStatus .xWNewCardStatus').val(2);
            }*/
            
            // Update in document temp
            JSxCardShiftChangeUpdateDataOnTemp(oRecord.tOldCardCode, oRecord.tNewCardCode, oRecord.tReasonCode, oRecord.nSeq, oRecord.nPage);
            
            // Remove Seft Record Backup
            localStorage.removeItem(tRecordId);
            // Visibled icons
            JSxCardShiftChangeDataSourceVisibledOperationIcon(poElement, 'save', false); // Itself hidden(save)
            JSxCardShiftChangeDataSourceVisibledOperationIcon(poElement, 'cancel', false); // hidden cancel icon
            JSxCardShiftChangeDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon

            $(poElement) // Remove Active Old Card Code Field.
                    .parents('.xWCardShiftChangeDataSource')
                    .find('.xWCardShiftChangeCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

            $(poElement) // Remove Active New Card Name Field.
                    .parents('.xWCardShiftChangeDataSource')
                    .find('.xWCardShiftChangeNewCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

            $(poElement) // Remove Active Reason Name Field.
                    .parents('.xWCardShiftChangeDataSource')
                    .find('.xWCardShiftChangeReason input[type=text]')
                    .attr('disabled', true)
                    .attr('readonly', true)
                    .removeClass('btn');

        } catch (err) {
            console.log('JSxSaveOperator Error: ', err);
        }
    }

    /**
     * Functionality : Visibled operation icon
     * Parameters : [poElement] is seft element in scope(<tr class="xWCardShiftChangeDataSource">), 
     * [ptOperation] is icon type(edit, cancel, save), [pbVisibled] is true = show, false = hide
     * Creator : 07/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeDataSourceVisibledOperationIcon(poElement, ptOperation, pbVisibled) {
        try {
            switch (ptOperation) {
                case 'edit' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftChangeDataSource')
                                .find('.xWCardShiftChangeEdit'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftChangeDataSource')
                                .find('.xWCardShiftChangeEdit'))
                                .addClass('hidden');
                    }
                    break;
                }
                case 'cancel' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftChangeDataSource')
                                .find('.xWCardShiftChangeCancel'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftChangeDataSource')
                                .find('.xWCardShiftChangeCancel'))
                                .addClass('hidden');
                    }
                    break;
                }
                case 'save' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftChangeDataSource')
                                .find('.xWCardShiftChangeSave'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftChangeDataSource')
                                .find('.xWCardShiftChangeSave'))
                                .addClass('hidden');
                    }
                    break;
                }
                default :
                {
                }
            }
        } catch (err) {
            console.log('JJSxCardShiftChangeDataSourceVisibledOperationIcon Error: ', err);
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
    function JSxCardShiftChangeValidateInline() {
        $('#obtCardShiftChangeSubmitForm').click();
        $('#ofmCardShiftChangeDataSourceForm').validate({
            rules: {
                oetCardShiftChangeCardName1: {
                    required: true,
                    uniqueCardShiftChangeCode: JCNbCardShiftChangeIsCreatePage(),
                    maxlength: 20
                },
                oetCardShiftChangeNewCardName1: {
                    required: true
                }
            },
            messages: {
                // oetCardShiftChangeCode: "",
                // oetCardShiftChangeName: ""
            },
            /*errorClass: "alert-validate",
             validClass: "",*/
            submitHandler: function (form) {
                /*var aCardPack = JSaCardShiftChangeGetDataSourceCode("cardPack", false);
                 console.log("aCardCode: ", aCardPack);
                 $.ajax({
                 type: "POST",
                 url: ptRoute,
                 data: $('#ofmAddCardShiftChangeMainForm').serialize() + "&" + $('#ofmSearchCard').serialize() + "&aCard=" + JSON.stringify(aCardPack),
                 cache: false,
                 timeout: 0,
                 success: function(tResult) {
                 JSvCardShiftChangeCallPageCardShiftChangeEdit($("#oetCardShiftChangeCode").val());
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                 JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
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
    function JSnCardShiftChangeChkValidateSaveRow(paDataChkValidateRow) {
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

    function JSvCardShiftChangeDataSourceClickPage(ptPage, tDocType, ptIDElement) {
        JCNxOpenLoading();

        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                nPageOld = $('.xWCardShiftChangeDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWCardShiftChangeDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }
        JSvCardShiftChangeDataSourceTable(nPageCurrent, [], [], [], [], [], true, "1", false, false, [], "1", "");
        // JSvClickCallTableTemp(tDocType, nPageCurrent, ptIDElement);
    }
</script>
