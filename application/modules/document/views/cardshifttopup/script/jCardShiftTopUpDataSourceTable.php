<script type="text/javascript">
    $(document).ready(function() {
        window.rowValidate = $('#ofmCardShiftTopUpDataSourceForm').validate({
            messages: {

            },
            submitHandler: function (form) {
                
            },
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
     * Functionality : กด Delete
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 24/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftTopUpDataSourceDeleteOperator(poElement, poEvent, pnPage, ptOldCardCode, pnSeq) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                pnPage = (typeof pnPage !== 'undefined') ?  pnPage : 1;
                
                if (JSbCardShiftTopUpIsApv() || JSbCardShiftTopUpIsStaDoc("cancel")) {
                    return;
                }
                $('#ospCardShiftTopUpConfirDelMessage').html(ptOldCardCode);
                $('#odvCardShiftTopUpModalConfirmDelRecord').modal({backdrop: 'static', keyboard: false});
                $('#odvCardShiftTopUpModalConfirmDelRecord').modal('show');
                $('#osmCardShiftTopUpConfirmDelRecord').unbind().click(function(evt) {
                    $('#odvCardShiftTopUpModalConfirmDelRecord').modal('hide');
                    $.ajax({
                        type: "POST",
                        url: "CallDeleteTemp",
                        data: {ptID: ptOldCardCode, pnSeq: pnSeq, ptDocType: "TopUp"},
                        cache: false,
                        success: function (tResult) {
                            JSvCardShiftTopUpDataSourceTable(pnPage, [], [], [], [], [], true, "1", false, false, [], "1", "");
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSxCardShiftTopUpDataSourceDeleteOperator Error: ', err);
    }
    }

    /**
     * Functionality : กดปุ่ม edit
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 24/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftTopUpDataSourceEditOperator(poElement, poEvent, pnSeq) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                if (JSbCardShiftTopUpIsApv() || JSbCardShiftTopUpIsStaDoc("cancel")) {
                    return;
                }
                JSxCardShiftTopUpSetCardCodeTemp();
                let tRecordId = $(poElement).parents('.xWCardShiftTopUpDataSource').attr('id');
                let oRecord = {
                    tCode       : $(poElement).parents('.xWCardShiftTopUpDataSource').find('.xWCardShiftTopUpCardCode input[type=hidden]').val(),
                    tCodeName   : $(poElement).parents('.xWCardShiftTopUpDataSource').find('.xWCardShiftTopUpCardCode input[type=text]').val(),
                    tValue      : $(poElement).parents('.xWCardShiftTopUpDataSource').find('.xWCardShiftTopUpValue input[type=hidden]').val(),
                    tValueName  : $(poElement).parents('.xWCardShiftTopUpDataSource').find('.xWCardShiftTopUpValue input[type=text]').val()
                };
                // Backup Seft Record
                localStorage.setItem(tRecordId, JSON.stringify(oRecord));

                // Visibled icons
                JSxCardShiftTopUpDataSourceVisibledOperationIcon(poElement, 'edit', false); // Itself hidden(edit)
                JSxCardShiftTopUpDataSourceVisibledOperationIcon(poElement, 'cancel', true); // hidden cancel icon
                JSxCardShiftTopUpDataSourceVisibledOperationIcon(poElement, 'save', true); // hidden save icon

                $(poElement) // Active BTN
                        .parents('.xWCardShiftTopUpDataSource')
                        .find('.xWCardShiftTopUpCardCode input[type=text]')
                        .removeAttr('disabled')
                        .attr('readonly', true)
                        .addClass('btn');

                $(poElement) // Active TEXT
                        .parents('.xWCardShiftTopUpDataSource')
                        .find('.xWCardShiftTopUpValue input[type=text]')
                        .removeAttr('disabled')
                        .attr('maxlength', 18)
                        .addClass('text xCNInputNumericWithoutDecimal');
                
                $.getScript( "<?php echo base_url(); ?>application/assets/src/jFormValidate.js" );
            }else{
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSxEditOperator Error: ', err);
        }
    }

    /**
     * Functionality : กดปุ่ม cancle
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 24/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftTopUpDataSourceCancelOperator(poElement, poEvent) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                var tRecordId = $(poElement).parents('.xWCardShiftTopUpDataSource').attr('id');

                // Restore Seft Record
                var oBackupRecord = JSON.parse(localStorage.getItem(tRecordId));
                $(poElement).parents('.xWCardShiftTopUpDataSource').find('.xWCardShiftTopUpCardCode input[type=hidden]').val(oBackupRecord.tCode);
                $(poElement).parents('.xWCardShiftTopUpDataSource').find('.xWCardShiftTopUpCardCode input[type=text]').val(oBackupRecord.tCodeName);
                $(poElement).parents('.xWCardShiftTopUpDataSource').find('.xWCardShiftTopUpValue input[type=hidden]').val(oBackupRecord.tValue);
                $(poElement).parents('.xWCardShiftTopUpDataSource').find('.xWCardShiftTopUpValue input[type=text]').val(oBackupRecord.tValueName);

                // Remove Seft Record Backup
                localStorage.removeItem(tRecordId);

                // Visibled icons
                JSxCardShiftTopUpDataSourceVisibledOperationIcon(poElement, 'cancel', false); // Itself hidden(cancel)
                JSxCardShiftTopUpDataSourceVisibledOperationIcon(poElement, 'save', false); // hidden save icon
                JSxCardShiftTopUpDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon

                $(poElement) // Active BTN
                        .parents('.xWCardShiftTopUpDataSource')
                        .find('.xWCardShiftTopUpCardCode input[type=text]')
                        .attr('disabled', true)
                        .removeAttr('readonly')
                        .removeClass('btn');

                $(poElement)  // Active TEXT
                    .parents('.xWCardShiftTopUpDataSource')
                    .find('.xWCardShiftTopUpValue input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly', true)
                    .removeClass('text xCNInputNumericWithoutDecimal');
            }else{
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSxCancelOperator Error: ', err);
    }
    }

    /**
     * Functionality : กดปุ่ม save 
     * Parameters : poElement is Itself element, poEvent is Itself event, pnSeq is index in loop
     * Creator : 24/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftTopUpDataSourceSaveOperator(poElement, poEvent) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                var tRecordId = $(poElement).parents('.xWCardShiftTopUpDataSource').attr('id');
                var oPrefixNumber = tRecordId.match(/\d+/);
                
                let oRecord = {
                    nPage   : $('#ohdCardShiftTopUpDataSourceCurrentPage').val(),
                    nSeq    : $(poElement).parents('.xWCardShiftTopUpDataSource').data('seq'),
                    tCode   : $(poElement).parents('.xWCardShiftTopUpDataSource').find('.xWCardShiftTopUpCardCode input[type=text]').val(),
                    tValue  : $(poElement).parents('.xWCardShiftTopUpDataSource').find('.xWCardShiftTopUpValue input[type=text]').val()
                };
                
                // Update in document temp
                JSxCardShiftTopUpUpdateDataOnTemp(oRecord.tCode, oRecord.tValue, oRecord.nSeq, oRecord.nPage);
                
                // Remove Seft Record Backup
                localStorage.removeItem(tRecordId);
                // Visibled icons
                JSxCardShiftTopUpDataSourceVisibledOperationIcon(poElement, 'save', false); // Itself hidden(save)
                JSxCardShiftTopUpDataSourceVisibledOperationIcon(poElement, 'cancel', false); // hidden cancel icon
                JSxCardShiftTopUpDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon

                $(poElement)  // Active BTN
                        .parents('.xWCardShiftTopUpDataSource')
                        .find('.xWCardShiftTopUpCardCode input[type=text]')
                        .attr('disabled', true)
                        .removeAttr('readonly')
                        .removeClass('btn');


                $(poElement) // Active TEXT
                        .parents('.xWCardShiftTopUpDataSource')
                        .find('.xWCardShiftTopUpValue input[type=text]')
                        .attr('disabled', true)
                        .removeClass('text xCNInputNumericWithoutDecimal');
            }else{
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSxSaveOperator Error: ', err);
        }
    }

    /**
    * Functionality : ฟังก์ชั่น save edit in line  
    * Parameters : tCardCode, tNewCardCode, tReasonCode, pnPage
    * Creator : 27/12/2018 piya
    * Last Modified : -
    * Return : -
    * Return Type : -
    */
    function JSxCardShiftTopUpUpdateDataOnTemp(ptCardCode , pnValue , pnSeq, pnPage) {
        try{
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $.ajax({
                    type: "POST",
                    url: "cardShiftTopUpUpdateInlineOnTemp",
                    data: {
                        tCardCode       : ptCardCode,
                        nValue          : pnValue,
                        nSeq            : pnSeq
                    },
                    cache: false,
                    Timeout: 5000,
                    success: function(tResult) {
                        try{
                            JSvCardShiftTopUpDataSourceTable(pnPage, [], [], [], [], [], true, "1", false, false, [], "1", "");
                        }catch(err){}
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftTopUpResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        }catch(err){
            console.log("JSxCardShiftChangeInsertDataToTemp Error: ", err);
        }
    }

    /**
     * Functionality : control ปุ่ม เซฟ ยกเลิก บันทึก
     * Parameters : [poElement] is seft element in scope(<tr class="xWCardShiftTopUpDataSource">), 
     * [ptOperation] is icon type(edit, cancel, save), [pbVisibled] is true = show, false = hide
     * Creator : 07/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftTopUpDataSourceVisibledOperationIcon(poElement, ptOperation, pbVisibled) {
        try {
            switch (ptOperation) {
                case 'edit' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftTopUpDataSource')
                                .find('.xWCardShiftTopUpEdit'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftTopUpDataSource')
                                .find('.xWCardShiftTopUpEdit'))
                                .addClass('hidden');
                    }
                    break;
                }
                case 'cancel' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftTopUpDataSource')
                                .find('.xWCardShiftTopUpCancel'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftTopUpDataSource')
                                .find('.xWCardShiftTopUpCancel'))
                                .addClass('hidden');
                    }
                    break;
                }
                case 'save' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftTopUpDataSource')
                                .find('.xWCardShiftTopUpSave'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftTopUpDataSource')
                                .find('.xWCardShiftTopUpSave'))
                                .addClass('hidden');
                    }
                    break;
                }
                default :
                {
                }
            }
        } catch (err) {
            console.log('JJSxCardShiftTopUpDataSourceVisibledOperationIcon Error: ', err);
        }
    }

    //Page
    function JSvCardShiftTopUpDataSourceClickPage(ptPage, tDocType, ptIDElement) {
        JCNxOpenLoading();

        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                nPageOld = $('.xWCardShiftTopUpDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWCardShiftTopUpDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }
        JSvCardShiftTopUpDataSourceTable(nPageCurrent, [], [], [], [], [], true, "1", false, false, [], "1", "");
        // JSvClickCallTableTemp(tDocType, nPageCurrent, ptIDElement);
    }

</script>
