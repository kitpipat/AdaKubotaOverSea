<script type="text/javascript">
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
        if (JSbAgencyIsCreatePage()) {
            //Agency Code
            $("#oetAgnCode").attr("disabled", true);
            $('#ocbAgencyAutoGenCode').change(function() {
                if ($('#ocbAgencyAutoGenCode').is(':checked')) {
                    $('#oetAgnCode').val('');
                    $("#oetAgnCode").attr("disabled", true);
                    $('#odvAgnCodeForm').removeClass('has-error');
                    $('#odvAgnCodeForm em').remove();
                } else {
                    $("#oetAgnCode").attr("disabled", false);
                }
            });
            JSxAgencyVisibleComponent('#ocbVatrateAutoGenCode', true);
        }

        if (JSbAgencyIsUpdatePage()) {
            // Agency Code
            $("#oetAgnCode").attr("readonly", true);
            $('#odvAgnAutoGenCode input').attr('disabled', true);
            JSxAgencyVisibleComponent('#odvAgnAutoGenCode', false);

        }


        $.ajax({
            type: "POST",
            url: "SettingConfigLoadViewSearch",
            data: {
                ptTypePage: 'Agency'
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $("#odvInforSettingconfig").html(tResult);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });
    $('#oetAgnCode').blur(function() {
        JSxCheckAgencyCodeDupInDB();
    });


    $('#oimAGNBrowsePpl').click(function() {
        // Create By Witsarut 04/10/2019
        JSxCheckPinMenuClose();
        // Create By Witsarut 04/10/2019
        JCNxBrowseData('oAGNBrowsePpl');
    });

    $('#oimAgnBrowseChanel').click(function() {
        JSxCheckPinMenuClose();
        var tAgnCodeParam = $('#oetAgnCode').val();
        window.oBrowsePosOption = undefined;
        oBrowseAgnOption = oAGNBrowseChanel({
            'tAgnCodeParam': tAgnCodeParam
        });
        JCNxBrowseData('oBrowseAgnOption');
    })

    //Functionality : Event Check Agency
    //Parameters : Event Blur Input Agency Code
    //Creator : 25/03/2019 wasin (Yoshi)
    //Update : 30/05/2019 saharat (Golf)
    //Return : -
    //Return Type : -
    function JSxCheckAgencyCodeDupInDB() {
        if (!$('#ocbAgencyAutoGenCode').is(':checked')) {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: {
                    tTableName: "TCNMAgency",
                    tFieldName: "FTAgnCode",
                    tCode: $("#oetAgnCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateAgnCode").val(aResult["rtCode"]);
                    // Set Validate Dublicate Code
                    $.validator.addMethod('dublicateCode', function(value, element) {
                        if ($("#ohdCheckDuplicateAgnCode").val() == 1) {
                            return false;
                        } else {
                            return true;
                        }
                    }, '');

                    // From Summit Validate
                    $('#ofmAddAgn').validate({
                        rules: {
                            oetAgnCode: {
                                "required": {
                                    // ตรวจสอบเงื่อนไข validate
                                    depends: function(oElement) {
                                        if ($('#ocbAgencyAutoGenCode').is(':checked')) {
                                            return false;
                                        } else {
                                            return true;
                                        }
                                    }
                                },
                                "dublicateCode": {}
                            },
                            oetAgnName: {
                                "required": {}
                            },
                            oetAgnEmail: {
                                "required": {}
                            },
                        },
                        messages: {
                            oetAgnCode: {
                                "required": $('#oetAgnCode').attr('data-validate-required'),
                                "dublicateCode": $('#oetAgnCode').attr('data-validate-dublicateCode')
                            },
                            oetAgnName: {
                                "required": $('#oetAgnName').attr('data-validate-required'),
                            },
                            oetAgnEmail: {
                                "required": $('#oetAgnEmail').attr('data-validate-required'),
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
                        submitHandler: function(form) {}
                    });

                    // Submit From
                    $('#ofmAddAgn').submit();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }
    }


    $('ducument').ready(function() {
        JSxShowButtonChoose();
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        var nlength = $('#odvRGPList').children('tr').length;
        for ($i = 0; $i < nlength; $i++) {
            var tDataCode = $('#otrCoupon' + $i).data('code')
            if (aArrayConvert == null || aArrayConvert == '') {} else {
                var aReturnRepeat = findObjectByKey(aArrayConvert[0], 'nCode', tDataCode);
                if (aReturnRepeat == 'Dupilcate') {
                    $('#ocbListItem' + $i).prop('checked', true);
                } else {}
            }
        }

        $('.ocbListItem').click(function() {
            var nCode = $(this).parent().parent().parent().data('code'); //code
            var tName = $(this).parent().parent().parent().data('name'); //code
            $(this).prop('checked', true);
            var LocalItemData = localStorage.getItem("LocalItemData");
            var obj = [];
            if (LocalItemData) {
                obj = JSON.parse(LocalItemData);
            } else {}
            var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
            if (aArrayConvert == '' || aArrayConvert == null) {
                obj.push({
                    "nCode": nCode,
                    "tName": tName
                });
                localStorage.setItem("LocalItemData", JSON.stringify(obj));
                JSxPaseCodeDelInModal();
            } else {
                var aReturnRepeat = findObjectByKey(aArrayConvert[0], 'nCode', nCode);
                if (aReturnRepeat == 'None') { //ยังไม่ถูกเลือก
                    obj.push({
                        "nCode": nCode,
                        "tName": tName
                    });
                    localStorage.setItem("LocalItemData", JSON.stringify(obj));
                    JSxPaseCodeDelInModal();
                } else if (aReturnRepeat == 'Dupilcate') { //เคยเลือกไว้แล้ว
                    localStorage.removeItem("LocalItemData");
                    $(this).prop('checked', false);
                    var nLength = aArrayConvert[0].length;
                    for ($i = 0; $i < nLength; $i++) {
                        if (aArrayConvert[0][$i].nCode == nCode) {
                            delete aArrayConvert[0][$i];
                        }
                    }
                    var aNewarraydata = [];
                    for ($i = 0; $i < nLength; $i++) {
                        if (aArrayConvert[0][$i] != undefined) {
                            aNewarraydata.push(aArrayConvert[0][$i]);
                        }
                    }
                    localStorage.setItem("LocalItemData", JSON.stringify(aNewarraydata));
                    JSxPaseCodeDelInModal();
                }
            }
            JSxShowButtonChoose();
        })
    });

    var nLangEdits = <?= $this->session->userdata("tLangEdit") ?>;
    var oAGNBrowsePpl = {
        Title: ['product/pdtpricelist/pdtpricelist', 'tPPLTitle'],
        Table: {
            Master: 'TCNMPdtPriList',
            PK: 'FTPplCode'
        },
        Join: {
            Table: ['TCNMPdtPriList_L'],
            On: ['TCNMPdtPriList_L.FTPplCode = TCNMPdtPriList.FTPplCode AND TCNMPdtPriList_L.FNLngID = ' + nLangEdits]
        },
        Where: {
            // Condition : ["AND TCNMBranch.FTWahStaType = '3' "]
        },
        GrideView: {
            ColumnPathLang: 'product/pdtpricelist/pdtpricelist',
            ColumnKeyLang: ['tPPLTBCode', 'tPPLTBName'],
            ColumnsSize: ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TCNMPdtPriList.FTPplCode', 'TCNMPdtPriList_L.FTPplName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMPdtPriList.FDCreateOn DESC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetAGNPplRetCode", "TCNMPdtPriList.FTPplCode"],
            Text: ["oetAGNPplRetName", "TCNMPdtPriList.FTPplName"]
        },
        RouteAddNew: 'pdtpricegroup',
        BrowseLev: $('#oetANGStaBrowse').val()
    };


    var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
    var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var nCountBch = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
    var tUsrAgnCode = "<?php echo $this->session->userdata("tSesUsrAgnCode"); ?>";
    var tWhere = "";
    var tAgnCode = $('#oetAgnCode').val();
    // if (nCountBch == 1) {
    //     $('#obtBrowseSaleAdjBCH').attr('disabled', true);
    // }
    if (tUsrLevel != "HQ") {
        // tWhere = " AND TCNMBranch.FTBchCode IN (" + tBchCodeMulti + ") ";
        if (tAgnCode != "") {
            tWhereAgnCode = " AND ( TCNMChannelSpc.FTAgnCode = '" + tAgnCode + "' OR ISNULL(TCNMChannelSpc.FTAgnCode,'') = '' ) "
        } else {
            tWhereAgnCode = " AND ( TCNMChannelSpc.FTAgnCode = '" + tUsrAgnCode + "' OR ISNULL(TCNMChannelSpc.FTAgnCode,'') = '' ) "
        }

    } else {
        // tWhere = "";
        tWhereAgnCode = "";
        if ( tAgnCode != "" ) {
            tWhereAgnCode = " AND ( TCNMChannelSpc.FTAgnCode = '" + tAgnCode + "' OR ISNULL(TCNMChannelSpc.FTAgnCode,'') = '' ) "
        } else {
            tWhereAgnCode = ""
        }
    }


    // Option Chanel
    var oAGNBrowseChanel = function(poDataFnc) {
        var tPOSBchCodeParam = poDataFnc.tPOSBchCodeParam;
        var tWhereBchChn = '';
        // var tBchCode = $('#oetPosBchCode').val();

        // if ($("#oetPosBchCode").val() != "") {
        //     tWhereBchChn += " AND TCNMChannel.FTBchCode = '" + tBchCode + "'";
        // }

        var oOptionReturn = {
            Title: ['company/branch/branch', 'tCHNTitle'],
            Table: {
                Master: 'TCNMChannel',
                PK: 'FTChnCode',
                PKName: 'FTChnName'
            },
            Join: {
                Table: ['TCNMChannelSpc', 'TCNMChannel_L'],
                On: ['TCNMChannelSpc.FTChnCode = TCNMChannel.FTChnCode', 'TCNMChannel_L.FTChnCode = TCNMChannel.FTChnCode  AND TCNMChannel_L.FNLngID = ' + nLangEdits, ]
            },
            Where: {
                Condition: [tWhereAgnCode]
            },
            GrideView: {
                ColumnPathLang: 'company/branch/branch',
                ColumnKeyLang: ['tBCHCode', 'tBCHName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMChannel.FTChnCode', 'TCNMChannel_L.FTChnName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMChannel.FTChnCode DESC'],

            },
            // NextFunc: {
            //     FuncName: 'JSxClearBrowsePosWah'
            // },
            // DebugSQL : true,
            CallBack: {
                ReturnType: 'S',
                Value: ["oetAgnChanelCode", "TCNMChannel.FTChnCode"],
                Text: ["oetAgnChanelName", "TCNMChannel_L.FTChnName"],
            },

        }
        return oOptionReturn
    }

    $('#obtAgnBrowseCountry').click(function() {
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowseCountry');
    });
    var nLangStaLocal = <?php echo FCNaGetLngStalocal() ?>;
    var nDefLang      = <?php echo $this->session->userdata("tSesDefLanguage")?>
    
    var oBrowseCountry = {
        Title: ['ticket/agency/agency', 'tAGNRefCountry'],
        Table: {
            Master: 'TCNMCountry',
            PK: 'FTCtyCode',
        },
        Join: {
            Table: ['TCNMCountry_L'],
            On: ['TCNMCountry_L.FTCtyCode = TCNMCountry.FTCtyCode  AND (TCNMCountry_L.FNLngID = ' + nDefLang + ' OR TCNMCountry_L.FNLngID= '+ nLangEdits + ' OR TCNMCountry_L.FNLngID= '+ nLangStaLocal + ')', ]
        },  
        Where: {
            Condition: ['AND TCNMCountry.FTCtyStaUse = 1']
        },
        GrideView: {
            ColumnPathLang: 'ticket/agency/agency',
            ColumnKeyLang: ['tAGNCyCode', 'tAGNCyName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMCountry.FTCtyCode', 'TCNMCountry_L.FTCtyName'],
            DataColumnsFormat: ['', ''],
            DistinctField   : ['TCNMCountry.FTCtyCode'],
            DistinctFieldOrderBY : 'DESC',
            Perpage: 10,
            OrderBy: ['TCNMCountry.FTCtyCode DESC'],

        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetAgnCyCode", "TCNMCountry.FTCtyCode"],
            Text: ["oetAgnCyName", "TCNMCountry_L.FTCtyName"],
        },
        // DebugSQL : true,
    };
</script>