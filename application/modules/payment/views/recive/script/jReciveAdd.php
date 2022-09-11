<script type="text/javascript">
    $('.selection-2').selectpicker();
    var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;
    $(document).ready(function() {
        if (JSbRcvIsCreatePage()) {
            // Rcv Code
            $("#oetRcvCode").attr("disabled", true);
            $('#ocbReciveAutoGenCode').change(function() {
                if ($('#ocbReciveAutoGenCode').is(':checked')) {
                    $('#oetRcvCode').val('');
                    $("#oetRcvCode").attr("disabled", true);
                    $('#odvReciveCodeForm').removeClass('has-error');
                    $('#odvReciveCodeForm em').remove();
                } else {
                    $("#oetRcvCode").attr("disabled", false);
                }
            });
            JSxRcvVisibleComponent('#odvReciveAutoGenCode', true);
        }

        if (JSbRcvIsUpdatePage()) {
            // Sale Person Code
            $("#oetRcvCode").attr("readonly", true);
            $('#odvReciveAutoGenCode input').attr('disabled', true);
            JSxRcvVisibleComponent('#odvReciveAutoGenCode', false);
        }

        $('#oetRcvCode').blur(function() {
            JSxCheckRcvCodeDupInDB();
        });
        $('.xWHideSave').show();
        $('.xWMenu').click(function() {
            var tMenuType = $(this).data('menutype');
            if (tMenuType == 'Cfg' || tMenuType == 'Log') {
                $('.xWHideSave').hide();
            } else {
                $('.xWHideSave').show();
            }
        });

    });

    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckRcvCodeDupInDB() {
        if (!$('#ocbReciveAutoGenCode').is(':checked')) {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: {
                    tTableName: "TFNMRcv",
                    tFieldName: "FTRcvCode",
                    tCode: $("#oetRcvCode").val()
                },
                async: false,
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateRcvCode").val(aResult["rtCode"]);
                    JSxRcvSetValidEventBlur();
                    $('#ofmAddRecive').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }

    //Functionality: Set Validate Event Blur
    //Parameters: Validate Event Blur
    //Creator: 26/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxRcvSetValidEventBlur() {
        $('#ofmAddRecive').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if ($("#ohdCheckDuplicateRcvCode").val() == 1) {
                return false;
            } else {
                return true;
            }
        }, '');

        // From Summit Validate
        $('#ofmAddRecive').validate({
            rules: {
                oetRcvCode: {
                    "required": {
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if ($('#ocbReciveAutoGenCode').is(':checked')) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    },
                    "dublicateCode": {}
                },

                oetRcvName: {
                    "required": {}
                },
                oetRcvFormatName: {
                    "required": {}
                },
            },
            messages: {
                oetRcvCode: {
                    "required": $('#oetRcvCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetRcvCode').attr('data-validate-dublicateCode')
                },
                oetRcvName: {
                    "required": $('#oetRcvName').attr('data-validate-required'),
                },
                oetRcvFormatName: {
                    "required": $('#oetRcvFormatName').attr('data-validate-required'),
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
                var nStaCheckValid = $(element).parents('.form-group').find('.help-block').length
                if (nStaCheckValid != 0) {
                    $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
                }
            },
            submitHandler: function(form) {}
        });
    }

    // Create By Witsarut 27/11/2019
    // Get Data FTRcvCode
    function JSxRcvSpcGetContent() {
        JCNxOpenLoading();
        var tRoutepage = '<?= $tRoute ?>';
        if (tRoutepage == 'reciveEventAdd') {
            return;
        } else {
            var ptRcvCode = '<?php echo $tRcvCode; ?>'
            var ptRcvName = '<?php echo $tRcvName; ?>'

            // Check Login Expried
            var nStaSession = JCNxFuncChkSessionExpired();

            // if have session
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {

                $("#odvRcvSpcContentInfoDT").attr("class", "tab-pane fade out");
                $.ajax({
                    type: "POST",
                    url: "recivespc/0/0",
                    data: {
                        tRcvCode: ptRcvCode,
                        tRcvName: ptRcvName
                    },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        $('#odvRcvSpcData').html(tResult);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        }
    }



    // Create By Worakorn 04/11/2020
    // Get Data FTRcvCode
    function JSxRcvSpcGetConfig() {
        JCNxOpenLoading();
        var tRoutepage = '<?= $tRoute ?>';
        if (tRoutepage == 'reciveEventAdd') {
            return;
        } else {
            var ptRcvCode = '<?php echo $tRcvCode; ?>'
            var ptRcvName = '<?php echo $tRcvName; ?>'

            // Check Login Expried
            var nStaSession = JCNxFuncChkSessionExpired();

            // if have session
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {

                $("#odvRcvSpcContentInfoDT").attr("class", "tab-pane fade out");
                $.ajax({
                    type: "POST",
                    url: "recivespcconfig/0/0",
                    data: {
                        tRcvCode: ptRcvCode,
                        tRcvName: ptRcvName
                    },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        $('#odvRcvSpcConfig').html(tResult);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        }

    }

    $('#ocbRcvMultiCur').click(function() {
        if ($('#ocbRcvMultiCur').prop('checked')) {
            $("#obtRcvCurrencyBrowse").attr("disabled", true);
            // $("#oetRcvCurrencyName").prop('required',false);
            $('#oetRcvCurrencyCode').val('');
            $('#oetRcvCurrencyName').val('');
        } else {
            $("#obtRcvCurrencyBrowse").attr("disabled", false);
            // $("#oetRcvCurrencyName").prop('required',true);
        }
    });

    $('#oimRcvFormatBrowse').click(function() {
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowsetSysFormat');
    });


    var oBrowsetSysFormat = {
        Title: ['payment/recive/recive', 'tRCVFormat'],
        Table: {
            Master: 'TSysRcvFmt',
            PK: 'FTFmtCode'
        },
        Join: {
            Table: ['TSysRcvFmt_L'],
            On: ['TSysRcvFmt_L.FTFmtCode = TSysRcvFmt.FTFmtCode  AND TSysRcvFmt_L.FNLngID =' + nLangEdits]
        },
        Where: {
            Condition: [' AND TSysRcvFmt.FTFmtStaUsed = 1 ']
        },
        GrideView: {
            ColumnPathLang: 'payment/recivespc/recivespc',
            ColumnKeyLang: ['tBrowseAppCode', 'tBrowseAppName'],
            ColumnsSize: ['15%', '75%'],
            DataColumns: ['TSysRcvFmt.FTFmtCode', 'TSysRcvFmt_L.FTFmtName'],
            DataColumnsFormat: ['', ''],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TSysRcvFmt.FTFmtCode ASC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRcvFormatCode", "TSysRcvFmt.FTFmtCode"],
            Text: ["oetRcvFormatName", "TSysRcvFmt_L.FTFmtName"]
        },
        // DebugSQL:true
        NextFunc: {
            FuncName: 'JSxNextFuncFormatValidate',
            ArgReturn: ['FTFmtCode']
        },
    };

    function JSxNextFuncFormatValidate(ptFmtCode) {
        if (ptFmtCode != 'NULL') {
            $('#oetRcvFormatName').removeAttr('data-validate-required')
            $('#oetRcvFormatName').removeAttr('aria-describedby')
            $("#oetRcvFormatName-error").css({"display":"none"})
            $('#odvRcvFmtName').removeClass("has-error")
            $('#odvRcvFmtName').addClass("has-success")
        } else {
            $('#odvRcvFmtName').removeClass("has-success")
            $('#odvRcvFmtName').addClass("has-error")
            $("#oetRcvFormatName-error").removeAttr("style")
        }

        JSxRcvCheckCurrency();
    }

    $('#obtRcvCurrencyBrowse').click(function() {
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowsetRate');
    });

    var tAgnCode   = '<?php echo $this->session->userdata("tSesUsrAgnCode") ?>';
    if(tAgnCode != ""){
        tWhereAgn = " AND TFNMRate.FTAgnCode IN ('','"+tAgnCode+"') ";
    }else{
        tWhereAgn = "";
    }
    var oBrowsetRate = {
        Title: ['payment/recive/recive', 'tRCVCurrency'],
        Table: {
            Master: 'TFNMRate',
            PK: 'FTRteCode'
        },
        Join: {
            Table: ['TFNMRate_L'],
            On: ['TFNMRate_L.FTRteCode = TFNMRate.FTRteCode AND TFNMRate.FTAgnCode = TFNMRate_L.FTAgnCode AND TFNMRate_L.FNLngID =' + nLangEdits]
        },
        Where: {
            Condition: [tWhereAgn]
        },
        GrideView: {
            ColumnPathLang: 'payment/recivespc/recivespc',
            ColumnKeyLang: ['tBrowseAppCode', 'tBrowseAppName'],
            ColumnsSize: ['15%', '75%'],
            DataColumns: ['TFNMRate.FTRteCode', 'TFNMRate_L.FTRteName'],
            DataColumnsFormat: ['', ''],
            DistinctField   : ['TFNMRate.FTRteCode'],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TFNMRate.FTRteCode ASC'],
        },
        // DebugSQL: true,
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRcvCurrencyCode", "TFNMRate.FTRteCode"],
            Text: ["oetRcvCurrencyName", "TFNMRate_L.FTRteName"]
        },
    };

    $(document).ready(function(){
        JSxRcvCheckCurrency();
    });
    
    function JSxRcvCheckCurrency(){
        if ($('#ocbRcvMultiCur').prop('checked')) {
            $("#obtRcvCurrencyBrowse").attr("disabled", true);
            // $("#oetRcvCurrencyName").prop('required',false);
            $('#oetRcvCurrencyCode').val('');
            $('#oetRcvCurrencyName').val('');
        } else {
            $("#obtRcvCurrencyBrowse").attr("disabled", false);
            // $("#oetRcvCurrencyName").prop('required',true);
        }
        $("#odvRcvCurrencyName").hide();
        var tFmtCode = $('#oetRcvFormatCode').val();
        if (tFmtCode == '001') {
            $("#odvRcvCurrencyName").show();
        }else{
            $("#odvRcvCurrencyName").hide();
        }
    }

</script>