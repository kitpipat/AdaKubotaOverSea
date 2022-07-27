<script>
    var nLangEdit = '<?php echo $nLangEdit; ?>';
    var tUsrApv = '<?php echo $tUsrApv; ?>';
    var tUserLoginLevel = '<?php echo $tUserLoginLevel; ?>';
    var bIsAddPage = <?php echo ($bIsAddPage) ? 'true' : 'false'; ?>;
    var bIsApv = <?php echo ($bIsApv) ? 'true' : 'false'; ?>;
    var bIsCancel = <?php echo ($bIsCanCel) ? 'true' : 'false'; ?>;
    var bIsApvOrCancel = <?php echo ($bIsApvOrCanCel) ? 'true' : 'false'; ?>;

    $(document).ready(function() {

        JSxTopUpVendingGetPdtLayoutDataTableInTmp();

        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        $('#obtXthDocDate').click(function() {
            event.preventDefault();
            $('#oetXthDocDate').datepicker('show');
        });

        $('#obtXthDocTime').click(function() {
            event.preventDefault();
            $('#oetXthDocTime').datetimepicker('show');
        });

        $('#obtXthRefExtDate').click(function() {
            event.preventDefault();
            $('#oetXthRefExtDate').datepicker('show');
        });

        $('#obtXthRefIntDate').click(function() {
            event.preventDefault();
            $('#oetXthRefIntDate').datepicker('show');
        });

        $('#obtXthTnfDate').click(function() {
            event.preventDefault();
            $('#oetXthTnfDate').datepicker('show');
        });

        $('.xCNTimePicker').datetimepicker({
            format: 'HH:mm:ss'
        });

        $('.xWTooltipsBT').tooltip({
            'placement': 'bottom'
        });

        $('[data-toggle="tooltip"]').tooltip({
            'placement': 'top'
        });

        $('#ocbTopUpVendingAutoGenCode').unbind().bind('change', function() {
            var bIsChecked = $('#ocbTopUpVendingAutoGenCode').is(':checked');
            var oInputDocNo = $('#oetTopUpVendingDocNo');
            if (bIsChecked) {
                $(oInputDocNo).attr('readonly', true);
                $(oInputDocNo).attr('disabled', true);
                $(oInputDocNo).val("");
                $(oInputDocNo).parents('.form-group').removeClass('has-error').find('em').hide();
            } else {
                $(oInputDocNo).removeAttr('readonly');
                $(oInputDocNo).removeAttr('disabled');
            }
        });

        if (tUserLoginLevel == 'HQ') {
            $('#obtBrowseTopUpVendingShp').attr('disabled', true);
            $('#obtBrowseTopUpVendingPos').attr('disabled', true);

            if (bIsAddPage) {
                $('#obtBrowseTopUpVendingWah').attr('disabled', true);
            } else {
                $('#obtBrowseTopUpVendingWah').attr('disabled', false);
            }
            // $('#obtBrowseTopUpVendingMER').attr('disabled', true);
            // $('#obtBrowseTopUpVendingShp').attr('disabled', true);
            // $('#obtBrowseTopUpVendingPos').attr('disabled', true);

            // if (bIsAddPage) {
            //     $('#obtBrowseTopUpVendingWah').attr('disabled', true);
            // } else {
            //     $('#obtBrowseTopUpVendingWah').attr('disabled', false);
            // }
        }

        if (tUserLoginLevel == 'BCH' || tUserLoginLevel == 'HQ') {
            $('#obtBrowseTopUpVendingShp').attr('disabled', true);
            $('#obtBrowseTopUpVendingPos').attr('disabled', true);

            if (bIsAddPage) {
                $('#obtBrowseTopUpVendingWah').attr('disabled', true);
            } else {
                $('#obtBrowseTopUpVendingWah').attr('disabled', false);
            }
        }

        if (tUserLoginLevel == 'SHP') {
            $('#obtBrowseTopUpVendingMER').attr('disabled', true);
            $('#obtBrowseTopUpVendingShp').attr('disabled', true);

            if (bIsAddPage) {
                $('#obtBrowseTopUpVendingWah').attr('disabled', true);
            } else {
                $('#obtBrowseTopUpVendingWah').attr('disabled', false);
            }
        }

        if ($('#oetTopUpVendingWahCode').val() != "") {
            $('#obtTopUpVendingControlForm').attr('disabled', false);
        } else {
            $('#obtTopUpVendingControlForm').attr('disabled', true);
        }

        if (<?= !FCNbGetIsShpEnabled() ? '1' : '0' ?>){
            $('#obtBrowseTopUpVendingPos').attr('disabled', false);
            $('#obtBrowseTopUpVendingWah').attr('disabled', false);
        }
        

        if(bIsApvOrCancel && !bIsAddPage){
            $('#obtTFWApprove').hide();
            $('#obtTFWCancel').hide();
            $('#odvBtnAddEdit .btn-group').hide();
            $('form .xCNApvOrCanCelDisabled').attr('disabled', true);
        }else{
            $('#odvBtnAddEdit .btn-group').show();
        }

        $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                return false;
            }
        });

    });

    /*===== Begin Event Browse =========================================================*/
    // เลือกสาขา
    $("#obtBrowseTopUpVendingBCH").click(function() {
        // JSxCheckPinMenuClose(); // Hidden Pin Menu
        $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
        // option Ship Address 
        window.oBrowseTopUpVendingBranch = {
            Title: ['authen/user/user', 'tBrowseBCHTitle'],
            Table: {
                Master: 'TCNMBranch',
                PK: 'FTBchCode'
            },
            Join: {
                Table: ['TCNMBranch_L'],
                On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits]
            },
            GrideView: {
                ColumnPathLang: 'authen/user/user',
                ColumnKeyLang: ['tBrowseBCHCode', 'tBrowseBCHName'],
                ColumnsSize: ['10%', '75%'],
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMBranch.FTBchCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetTopUpVendingBCHCode", "TCNMBranch.FTBchCode"],
                Text: ["oetTopUpVendingBCHName", "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: 'JSxTopUpVendingCallbackBch',
                ArgReturn: ['FTBchCode']
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oBrowseTopUpVendingBranch');
    });

    // เลือกกลุ่มธุรกิจ
    $("#obtBrowseTopUpVendingMER").click(function() {
        // JSxCheckPinMenuClose(); // Hidden Pin Menu
        $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
        // option Ship Address 
        window.oBrowseTopUpVendingMch = {
            Title: ['company/warehouse/warehouse', 'tWAHBwsMchTitle'],
            Table: {
                Master: 'TCNMMerchant',
                PK: 'FTMerCode'
            },
            Join: {
                Table: ['TCNMMerchant_L'],
                On: ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: ["AND (SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTShpStaActive = 1 AND TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '" + $("#oetTopUpVendingBCHCode").val() + "') != 0"]
            },
            GrideView: {
                ColumnPathLang: 'company/warehouse/warehouse',
                ColumnKeyLang: ['tWAHBwsMchCode', 'tWAHBwsMchNme'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
                DataColumnsFormat: ['', ''],
                Perpage: 5,
                OrderBy: ['TCNMMerchant.FTMerCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetTopUpVendingMchCode", "TCNMMerchant.FTMerCode"],
                Text: ["oetTopUpVendingMchName", "TCNMMerchant_L.FTMerName"],
            },
            NextFunc: {
                FuncName: 'JSxTopUpVendingCallbackMer',
                ArgReturn: ['FTMerCode', 'FTMerName']
            },
            BrowseLev: 1,
            //DebugSQL : true
        };
        JCNxBrowseData('oBrowseTopUpVendingMch');
    });

    // เลือกร้านค้า
    $("#obtBrowseTopUpVendingShp").click(function() {
        // JSxCheckPinMenuClose(); // Hidden Pin Menu
        $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
        // Option Shop
        window.oBrowseTopUpVendingShp = {
            Title: ['company/shop/shop', 'tSHPTitle'],
            Table: {
                Master: 'TCNMShop',
                PK: 'FTShpCode'
            },
            Join: {
                Table: ['TCNMShop_L', 'TCNMWaHouse_L'],
                On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
                    'TCNMShop.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMShop.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID= ' + nLangEdits
                ]
            },
            Where: {
                Condition: [
                    function() {
                        var tSQL = "AND TCNMShop.FTShpStaActive = 1 AND TCNMShop.FTBchCode = '" + $("#oetTopUpVendingBCHCode").val() + "' AND TCNMShop.FTMerCode = '" + $("#oetTopUpVendingMchCode").val() + "'";
                        return tSQL;
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'company/branch/branch',
                ColumnKeyLang: ['tBCHCode', 'tBCHName'],
                ColumnsSize: ['25%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName', 'TCNMShop.FTWahCode', 'TCNMWaHouse_L.FTWahName', 'TCNMShop.FTShpType', 'TCNMShop.FTBchCode'],
                DataColumnsFormat: ['', '', '', '', '', ''],
                DisabledColumns: [2, 3, 4, 5],
                Perpage: 5,
                OrderBy: ['TCNMShop_L.FTShpCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetTopUpVendingShpCode", "TCNMShop.FTShpCode"],
                Text: ["oetTopUpVendingShpName", "TCNMShop_L.FTShpName"],
            },
            NextFunc: {
                FuncName: 'JSxTopUpVendingCallbackShp',
                ArgReturn: ['FTBchCode', 'FTShpCode', 'FTShpType', 'FTWahCode', 'FTWahName']
            },
            BrowseLev: 1


        }
        JCNxBrowseData('oBrowseTopUpVendingShp');
    });

    // เลือกตู้
    $("#obtBrowseTopUpVendingPos").click(function() {
        // JSxCheckPinMenuClose(); // Hidden Pin Menu
        $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
        // option Pos 
        var bIsShopEnabled = '<?= FCNbGetIsShpEnabled() ? '1' : '0' ?>';
        var tWahMasterTable = 'TVDMPosShop';
        var tPK = "FTPosCode"; 
        var oJoinCondition = {
                Table: ['TCNMPos', 'TCNMPosLastNo', 'TCNMWaHouse', 'TCNMWaHouse_L'],
                On: ['TVDMPosShop.FTPosCode = TCNMPos.FTPosCode AND TVDMPosShop.FTBchCode = TCNMPos.FTBchCode',
                    'TVDMPosShop.FTPosCode = TCNMPosLastNo.FTPosCode',
                    'TVDMPosShop.FTPosCode = TCNMWaHouse.FTWahRefCode AND TCNMWaHouse.FTWahStaType = 6 AND TCNMPos.FTBchCode = TCNMWaHouse.FTBchCode',
                    'TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits
                ]
            };
        var aCondition = [
                            function() {
                                var tSQL = "AND TCNMPos.FTPosStaUse = 1 AND TVDMPosShop.FTShpCode = '" + $("#oetTopUpVendingShpCode").val() + "' AND TVDMPosShop.FTBchCode = '" + $("#oetTopUpVendingBCHCode").val() + "'";
                                tSQL += " AND TCNMPos.FTPosType = '4'";
                                return tSQL;
                            }
                        ];
        var aDataColumns = ['TVDMPosShop.FTPosCode', 'TCNMPosLastNo.FTPosComName', 'TVDMPosShop.FTShpCode', 'TVDMPosShop.FTBchCode', 'TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'];
        var aDataColumnsFormat = ['', '', '', '', '', ''];
        var aDisabledColumns = [1, 2, 3, 4, 5];
        var aArgReturn= ['FTBchCode', 'FTShpCode', 'FTPosCode', 'FTWahCode', 'FTWahName'];


        if(bIsShopEnabled == 0){
            tWahMasterTable = 'TCNMPos';
            tPK = "FTPosCode"; 
            oJoinCondition = {
                Table: ['TCNMWaHouse', 'TCNMWaHouse_L'],
                On: [   '   TCNMPos.FTPosCode = TCNMWaHouse.FTWahRefCode \
                            AND TCNMWaHouse.FTWahStaType = 6 \
                            AND TCNMPos.FTBchCode = TCNMWaHouse.FTBchCode',
                        'TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits
                ]
            };
            aCondition = [
                            function() {
                                var tSQL = "AND TCNMPos.FTPosStaUse = 1 \
                                            AND TCNMPos.FTBchCode = '" + $("#oetTopUpVendingBCHCode").val() + "'";
                                tSQL += " AND TCNMPos.FTPosType = '4'";
                                return tSQL;
                            }
                        ];
            aDataColumns = ['TCNMPos.FTPosCode', 'TCNMPos.FTBchCode', 'TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'];
            aDataColumnsFormat = ['', '', '', ''];
            aDisabledColumns = [1, 2, 3, 4];
            aArgReturn= ['FTBchCode', 'FTPosCode', 'FTWahCode', 'FTWahName'];
        }
        window.oBrowseTopUpVendingPos = {
            Title: ['pos/posshop/posshop', 'tPshTBPosCode'],
            Table: {
                Master: tWahMasterTable,
                PK: tPK
            },
            Join: oJoinCondition,
            Where: {
                Condition: aCondition
            },
            GrideView: {
                ColumnPathLang: 'pos/posshop/posshop',
                ColumnKeyLang: ['tPshBRWShopTBCode', 'tPshBRWPosTBName'],
                ColumnsSize: ['25%', '75%'],
                WidthModal: 50,
                DataColumns: aDataColumns,
                DataColumnsFormat: aDataColumnsFormat,
                DisabledColumns: aDisabledColumns,
                Perpage: 5,
                OrderBy: [tWahMasterTable + '.FTPosCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetTopUpVendingPosCode", tWahMasterTable + "FTPosCode"],
                Text: ["oetTopUpVendingPosName", tWahMasterTable + "FTPosCode"],
            },
            NextFunc: {
                FuncName: 'JSxTopUpVendingCallbackPos',
                ArgReturn: aArgReturn
            },
            BrowseLev: 1

        }
        JCNxBrowseData('oBrowseTopUpVendingPos');
    });

    // เลือกคลังสินค้า
    $("#obtBrowseTopUpVendingWah").click(function() {
        // JSxCheckPinMenuClose(); // Hidden Pin Menu
        $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
        // option warehouse 
        var bIsShopEnabled = '<?= FCNbGetIsShpEnabled() ? '1' : '0' ?>';
        var tWahMasterTable = 'TCNMWaHouse';
        var tPK = "FTWahCode"; 
        var tPKName = "FTWahName"; 
        if(bIsShopEnabled == 1){
            tWahMasterTable = 'TCNMShpWah';
            tPK = "FTWahCode"; 
            tPKName = "FTWahName"; 
        }
        window.oBrowseTopUpVendingWah = {
            Title: ['company/warehouse/warehouse', 'tWAHTitle'],
            Table: {
                Master  : tWahMasterTable,
                PK      : tPK,
                PKName  : tPKName
            },
            Join: {
                Table: ["TCNMWaHouse_L"],
                On: ["TCNMWaHouse_L.FTWahCode = "+tWahMasterTable+".FTWahCode AND TCNMWaHouse_L.FTBchCode = "+tWahMasterTable+".FTBchCode AND TCNMWaHouse_L.FNLngID = " + nLangEdits, ]
            },
            Where: {
                Condition: [
                    function() {
                        var tSQL = "";
                        if(bIsShopEnabled == 1){
                            tSQL = " AND TCNMShpWah.FTBchCode = '" + $("#oetTopUpVendingBCHCode").val() + "'";
                            tSQL += " AND TCNMShpWah.FTShpCode = '" + $('#oetTopUpVendingShpCode').val() + "'";
                        } else {
                            tSQL = " AND TCNMWaHouse.FTWahRefCode = '" + $("#oetTopUpVendingBCHCode").val() + "'";
                        }
                        return tSQL;
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'company/warehouse/warehouse',
                ColumnKeyLang: ['tWahCode', 'tWahName'],
                DataColumns: [tWahMasterTable+'.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                DataColumnsFormat: ['', ''],
                ColumnsSize: ['15%', '75%'],
                Perpage: 10,
                WidthModal: 50,
                OrderBy: ['TCNMWaHouse_L.FTWahName'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'M',
                Value: ["oetTopUpVendingWahCode", tWahMasterTable+".FTWahCode"],
                Text: ["oetTopUpVendingWahName", "TCNMWaHouse_L.FTWahName"],
            },
            NextFunc: {
                FuncName: 'JSxTopUpVendingCallbackWah',
                ArgReturn: []
            },
            RouteAddNew: 'warehouse',
            BrowseLev: 1
        }
        JCNxBrowseData('oBrowseTopUpVendingWah');
    });

    // เลือกขนส่งโดย
    $("#obtSearchShipVia").click(function() {
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        $(".modal.fade:not(#odvTFWBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTFWPopupApv,#odvModalDelPdtTFW)").remove();
        // option Ship Address 
        oTFWBrowseShipVia = {
            Title: ['document/producttransferwahouse/producttransferwahouse', 'tTFWShipViaModalTitle'],
            Table: {
                Master: 'TCNMShipVia',
                PK: 'FTViaCode'
            },
            Join: {
                Table: ['TCNMShipVia_L'],
                On: [
                    "TCNMShipVia.FTViaCode = TCNMShipVia_L.FTViaCode AND TCNMShipVia_L.FNLngID = " + nLangEdits
                ]
            },
            GrideView: {
                ColumnPathLang: 'document/producttransferwahouse/producttransferwahouse',
                ColumnKeyLang: ['tTFWShipViaCode', 'tTFWShipViaName'],
                DataColumns: ['TCNMShipVia.FTViaCode', 'TCNMShipVia_L.FTViaName'],
                DataColumnsFormat: ['', ''],
                ColumnsSize: [''],
                Perpage: 10,
                WidthModal: 50,
                OrderBy: ['TCNMShipVia.FTViaCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetTopUpVendingViaCode", "TCNMShipVia.FTViaCode"],
                Text: ["oetTopUpVendingViaName", "TCNMShipVia_L.FTViaName"],
            },
            BrowseLev: 1
        }
        JCNxBrowseData('oTFWBrowseShipVia');
    });
    /*===== End Event Browse ===========================================================*/

    /*===== Begin Callback Browse ======================================================*/
    // Browse Bch Callback
    function JSxTopUpVendingCallbackBch(params) {
        var tBchCode = $('#oetTopUpVendingBCHCode').val();

        $('#oetTopUpVendingMchCode').val("");
        $('#oetTopUpVendingMchName').val("");

        $('#oetTopUpVendingShpCode').val("");
        $('#oetTopUpVendingShpName').val("");

        $('#oetTopUpVendingPosCode').val("");
        $('#oetTopUpVendingPosName').val("");

        $('#oetTopUpVendingWahCode').val("");
        $('#oetTopUpVendingWahName').val("");

        $('#obtBrowseTopUpVendingMER').attr('disabled', true);
        $('#obtBrowseTopUpVendingShp').attr('disabled', true);
        $('#obtBrowseTopUpVendingPos').attr('disabled', true);
        $('#obtBrowseTopUpVendingWah').attr('disabled', true);

        if (tBchCode != "") {
            $('#obtBrowseTopUpVendingMER').attr('disabled', false);
        }
    }

    // Browse Mer Callback
    function JSxTopUpVendingCallbackMer(params) {
        var tBchCode = $('#oetTopUpVendingBCHCode').val();
        var tMerCode = $('#oetTopUpVendingMchCode').val();

        $('#obtBrowseTopUpVendingMER').attr('disabled', true);
        $('#obtBrowseTopUpVendingShp').attr('disabled', true);
        $('#obtBrowseTopUpVendingPos').attr('disabled', true);
        $('#obtBrowseTopUpVendingWah').attr('disabled', true);

        $('#oetTopUpVendingShpCode').val("");
        $('#oetTopUpVendingShpName').val("");

        $('#oetTopUpVendingPosCode').val("");
        $('#oetTopUpVendingPosName').val("");

        $('#oetTopUpVendingWahCode').val("");
        $('#oetTopUpVendingWahName').val("");

        if (tBchCode != "" && tMerCode != "") {
            if (tUserLoginLevel == "HQ") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
            }
        } else {
            if (tUserLoginLevel == "HQ") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
            }
        }
    }

    // Browse Shop Callback
    function JSxTopUpVendingCallbackShp(params) {
        var tBchCode = $('#oetTopUpVendingBCHCode').val();
        var tMerCode = $('#oetTopUpVendingMchCode').val();
        var tShpCode = $('#oetTopUpVendingShpCode').val();

        $('#obtBrowseTopUpVendingMER').attr('disabled', true);
        $('#obtBrowseTopUpVendingShp').attr('disabled', true);
        $('#obtBrowseTopUpVendingPos').attr('disabled', true);
        $('#obtBrowseTopUpVendingWah').attr('disabled', true);

        $('#oetTopUpVendingPosCode').val("");
        $('#oetTopUpVendingPosName').val("");

        $('#oetTopUpVendingWahCode').val("");
        $('#oetTopUpVendingWahName').val("");

        if (tBchCode != "" && tMerCode != "" && tShpCode != "") {
            if (tUserLoginLevel == "HQ") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
                $('#obtBrowseTopUpVendingPos').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
                $('#obtBrowseTopUpVendingPos').attr('disabled', false);
            }
        } else {
            if (tUserLoginLevel == "HQ") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
            }
        }
    }

    // Browse Pos Callback
    function JSxTopUpVendingCallbackPos(params) {

        var tBchCode = $('#oetTopUpVendingBCHCode').val();
        var tMerCode = $('#oetTopUpVendingMchCode').val();
        var tShpCode = $('#oetTopUpVendingShpCode').val();
        var tPosCode = $('#oetTopUpVendingPosCode').val();
        var tWahCode = $('#oetTopUpVendingWahCode').val();

        $('#obtBrowseTopUpVendingMER').attr('disabled', true);
        $('#obtBrowseTopUpVendingShp').attr('disabled', true);
        $('#obtBrowseTopUpVendingPos').attr('disabled', true);
        $('#obtBrowseTopUpVendingWah').attr('disabled', true);

        $('#oetTopUpVendingWahCode').val("");
        $('#oetTopUpVendingWahName').val("");

        // JSxTopUpVendingSetWahByShop()

        if (tBchCode != "" && tMerCode != "" && tShpCode != "" && tPosCode != "") {
            if (tUserLoginLevel == "HQ") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
                $('#obtBrowseTopUpVendingPos').attr('disabled', false);
                $('#obtBrowseTopUpVendingWah').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
                $('#obtBrowseTopUpVendingPos').attr('disabled', false);
                $('#obtBrowseTopUpVendingWah').attr('disabled', false);
            }
            if (tUserLoginLevel == "SHP") {
                $('#obtBrowseTopUpVendingPos').attr('disabled', false);
                $('#obtBrowseTopUpVendingWah').attr('disabled', false);
            }
        } else {
            if (tUserLoginLevel == "HQ") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
                $('#obtBrowseTopUpVendingPos').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
                $('#obtBrowseTopUpVendingPos').attr('disabled', false);
            }
            if (tUserLoginLevel == "SHP") {
                $('#obtBrowseTopUpVendingPos').attr('disabled', false);
            }
        }


    }

    // Browse Warehouse Callback
    function JSxTopUpVendingCallbackWah(params) {
        var tBchCode = $('#oetTopUpVendingBCHCode').val();
        var tMerCode = $('#oetTopUpVendingMchCode').val();
        var tShpCode = $('#oetTopUpVendingShpCode').val();
        var tPosCode = $('#oetTopUpVendingPosCode').val();
        var tWahCode = $('#oetTopUpVendingWahCode').val();

        if (tBchCode != "" && tMerCode != "" && tShpCode != "" && tPosCode != "" && tWahCode != "") {
            $('#obtTopUpVendingControlForm').attr('disabled', false);
        } else {
            $('#obtTopUpVendingControlForm').attr('disabled', true);
        }
    }
    /*===== End Callback Browse ========================================================*/

    $('#obtTopUpVendingControlForm').unbind().bind('click', function() {
        console.log('Select List');
        JSxTopUpVendingInsertPdtLayoutToTemp();
        JSxTopUpVendingGetPdtLayoutDataTableInTmp(1);
    });

    /**
     * Functionality : Insert PDT Layout to Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTopUpVendingInsertPdtLayoutToTemp() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetTopUpVendingBCHCode').val();
            var tMerCode = $('#oetTopUpVendingMchCode').val();
            var tShpCode = $('#oetTopUpVendingShpCode').val();
            var tPosCode = $('#oetTopUpVendingPosCode').val();
            var tWahCodeInShop = $('#oetTopUpVendingWahCode').val();

            // JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "TopupVendingInsertPdtLayoutToTmp",
                data: {
                    tBchCode: tBchCode,
                    tMerCode: tMerCode,
                    tShpCode: tShpCode,
                    tPosCode: tPosCode,
                    tWahCodeInShop: tWahCodeInShop
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
                    // JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // JCNxCloseLoading();
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Get PDT Layout in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTopUpVendingGetPdtLayoutDataTableInTmp(pnPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetTopUpVendingBCHCode').val();
            var tMerCode = $('#oetTopUpVendingMchCode').val();
            var tShpCode = $('#oetTopUpVendingShpCode').val();
            var tPosCode = $('#oetTopUpVendingPosCode').val();
            var tWahCode = $('#oetTopUpVendingWahCode').val();

            var tSearchAll = $('#oetTopUpVendingPdtLayoutSearchAll').val();

            JCNxOpenLoading();

            (pnPage == '' || (typeof pnPage) == 'undefined') ? pnPage = 1: pnPage = pnPage;

            $.ajax({
                type: "POST",
                url: "TopupVendingGetPdtLayoutDataTableInTmp",
                data: {
                    tBchCode: tBchCode,
                    tMerCode: tMerCode,
                    tShpCode: tShpCode,
                    tPosCode: tPosCode,
                    tWahCode: tWahCode,
                    nPageCurrent: pnPage,
                    tSearchAll: tSearchAll
                },
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    $('#odvTopupVendingPdtDataTable').html(tResult);
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCloseLoading();
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    var bUniqueTopUpVendingCode;
    $.validator.addMethod(
        "uniqueTopUpVendingCode",
        function(tValue, oElement, aParams) {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof nStaSession !== "undefined" && nStaSession == 1) {

                var tTopUpVendingCode = tValue;
                $.ajax({
                    type: "POST",
                    url: "TopupVendingUniqueValidate",
                    data: "tTopUpVendingCode=" + tTopUpVendingCode,
                    dataType: "JSON",
                    success: function(poResponse) {
                        bUniqueTopUpVendingCode = (poResponse.bStatus) ? false : true;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Custom validate uniqueTopUpVendingCode: ', jqXHR, textStatus, errorThrown);
                    },
                    async: false
                });
                return bUniqueTopUpVendingCode;

            } else {
                JCNxShowMsgSessionExpired();
            }

        },
        "Doc No. is Already Taken"
    );

    /**
     * Functionality : Validate Form
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTopUpVendingValidateForm() {
        var oTopUpVendingForm = $('#ofmTopUpVendingForm').validate({
            focusInvalid: false,
            onclick: false,
            onfocusout: false,
            onkeyup: false,
            rules: {
                oetTopUpVendingDocNo: {
                    required: true,
                    maxlength: 20,
                    uniqueTopUpVendingCode: bIsAddPage
                },
                oetTopUpVendingDocDate: {
                    required: true
                },
                oetTopUpVendingDocTime: {
                    required: true
                },
                oetTopUpVendingMchName: {
                    required: true
                },
                oetTopUpVendingShpName: {
                    required: true
                },
                oetTopUpVendingPosName: {
                    required: true
                },
                oetTopUpVendingWahName: {
                    required: true
                }
            },
            messages: {
                oetCreditNoteDocNo: {
                    "required": $('#oetCreditNoteDocNo').attr('data-validate-required')
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
                $(element).closest('.form-group').addClass("has-error");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').removeClass("has-error");
            },
            submitHandler: function(form) {
                JSxTopUpVendingSave();
            }
        });
    }

    /**
     * Functionality : Save Doc
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTopUpVendingSave() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetTopUpVendingBCHCode').val();
            var tMerCode = $('#oetTopUpVendingMchCode').val();
            var tShpCode = $('#oetTopUpVendingShpCode').val();
            var tPosCode = $('#oetTopUpVendingPosCode').val();
            var tWahCode = $('#oetTopUpVendingWahCode').val();

            // JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "<?php echo $tRoute; ?>",
                data: $("#ofmTopUpVendingForm").serialize(),
                cache: false,
                timeout: 5000,
                dataType: "JSON",
                success: function(oResult) {
                    console.log(oResult);
                    switch(oResult.nStaCallBack){
                        case "1" : {
                            JSvTopUpVendingCallPageEdit(oResult.tCodeReturn);
                            break;
                        }
                        case "2" : {
                            JSvTopUpVendingCallPageAdd();
                            break;
                        }
                        case "3" : {
                            JSvTopUpVendingCallPageList();
                            break;
                        }
                        default : {
                            JSvTopUpVendingCallPageEdit(oResult.tCodeReturn);    
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // JCNxCloseLoading();
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : ดึงข้อมูล Wah ด้วย shp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTopUpVendingSetWahByShop() {
        // alert('tset');
        $.ajax({
            type: "POST",
            url: "TopupVendingGetWahByShop",
            data: {
                tShpCode: $('#oetTopUpVendingShpCode').val(),
                tBchCode: $('#oetTopUpVendingBCHCode').val()
            },
            cache       : false,
            timeout     : 5000,
            dataType    : "JSON",
            success: function(oResult) {

                $('#oetTopUpVendingWahCode').val(oResult.tWahCodeByShp);
                $('#oetTopUpVendingWahName').val(oResult.tWahNameByShp);

                if (oResult.tWahCodeByShp != "") {
                    $('#obtTopUpVendingControlForm').attr('disabled', false);
                } else {
                    $('#obtTopUpVendingControlForm').attr('disabled', true);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // JCNxCloseLoading();
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    /**
     * Functionality : Approve Doc
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvTopUpVendingApprove(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            try {
                if (pbIsConfirm) {
                    $("#ohdXthStaApv").val(2); // Set status for processing approve
                    $("#odvTopUpVendingPopupApv").modal("hide");

                    var tDocNo = $("#oetTopUpVendingDocNo").val();
                    var tStaApv = $("#ohdXthStaApv").val();

                    JCNxOpenLoading();

                    $.ajax({
                        type: "POST",
                        url: "TopupVendingDocApprove",
                        data: {
                            tDocNo: tDocNo,
                            tStaApv: tStaApv
                        },
                        cache: false,
                        timeout: 0,
                        success: function(oResult) {
                            console.log(oResult);
                            try {
                                if (oResult.nStaEvent == "900") {
                                    FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                                    JCNxCloseLoading();
                                    return;
                                }
                            } catch (err) {}
                            JSoTopUpVendingSubscribeMQ();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                            JCNxCloseLoading();
                        }
                    });
                } else {
                    // console.log("StaApvDoc Call Modal");
                    $("#odvTopUpVendingPopupApv").modal("show");
                }
            } catch (err) {
                console.log("JSvTopUpVendingApprove Error: ", err);
            }

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Cancel Doc
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvTopUpVendingCancel(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tDocNo = $("#oetTopUpVendingDocNo").val();

            if (pbIsConfirm) {
                $.ajax({
                    type: "POST",
                    url: "TopupVendingDocCancel",
                    data: {
                        tDocNo: tDocNo
                    },
                    cache: false,
                    timeout: 5000,
                    success: function(tResult) {
                        $("#odvTopUpVendingPopupCancel").modal("hide");

                        var aResult = $.parseJSON(tResult);
                        if (aResult.nSta == 1) {
                            JSvTopUpVendingCallPageEdit(tDocNo);
                        } else {
                            JCNxCloseLoading();
                            var tMsgBody = aResult.tMsg;
                            FSvCMNSetMsgWarningDialog(tMsgBody);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                $("#odvTopUpVendingPopupCancel").modal("show");
            }

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : SubscribeMQ
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSoTopUpVendingSubscribeMQ() {
        // RabbitMQ
        /*===========================================================================*/
        // Document variable
        var tLangCode = $("#ohdLangEdit").val();
        var tUsrBchCode = $("#oetTopUpVendingBCHCode").val();
        var tUsrApv = $("#oetXthApvCodeUsrLogin").val();
        var tDocNo = $("#oetTopUpVendingDocNo").val();
        var tPrefix = "RESTFWVD";
        var tStaApv = $("#ohdXthStaApv").val();
        var tStaDelMQ = $("#ohdXthStaDelMQ").val();
        var tQName = tPrefix + "_" + tDocNo + "_" + tUsrApv;

        // MQ Message Config
        var poDocConfig = {
            tLangCode: tLangCode,
            tUsrBchCode: tUsrBchCode,
            tUsrApv: tUsrApv,
            tDocNo: tDocNo,
            tPrefix: tPrefix,
            tStaDelMQ: tStaDelMQ,
            tStaApv: tStaApv,
            tQName: tQName
        };

        // RabbitMQ STOMP Config
        var poMqConfig = {
            host: "ws://" + oSTOMMQConfig.host + ":15674/ws",
            username: oSTOMMQConfig.user,
            password: oSTOMMQConfig.password,
            vHost: oSTOMMQConfig.vhost
        };

        // Update Status For Delete Qname Parameter
        var poUpdateStaDelQnameParams = {
            ptDocTableName: "TVDTPdtTwxHD",
            ptDocFieldDocNo: "FTXthDocNo",
            ptDocFieldStaApv: "FTXthStaPrcStk",
            ptDocFieldStaDelMQ: "FTXthStaDelMQ",
            ptDocStaDelMQ: tStaDelMQ,
            ptDocNo: tDocNo
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit: "JSvTopUpVendingCallPageEdit",
            tCallPageList: "JSvTopUpVendingCallPageList"
        };

        // Check Show Progress %
        FSxCMNRabbitMQMessage(
            poDocConfig,
            poMqConfig,
            poUpdateStaDelQnameParams,
            poCallback
        );
        /*===========================================================================*/
        // RabbitMQ
    }
</script>