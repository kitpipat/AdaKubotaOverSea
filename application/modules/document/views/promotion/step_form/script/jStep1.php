<script>
    window.aPromotionStep1PmtPdtDtNotIn;

    $(document).ready(function(){

        $('#ocmPromotionGroupTypeTmp').selectpicker();
        $('#ocmPromotionListTypeTmp').selectpicker();   

        JSxPromotionStep1GetPmtDtGroupNameInTmp(1, false);

        $('#ocmPromotionListTypeTmp').on('change', function(){
            JSvPromotionStep1ClearPmtPdtDtInTemp(false);
            
            var tListType = $(this).val();
            if(tListType == "1"){
                JSxPromotionStep1GetPmtPdtDtInTmp(1, true);
            }
            if(tListType == "2"){
                JSxPromotionStep1GetPmtBrandDtInTmp(1, true);
            }
        });

        $('#obtPromotionStep1AddGroupNameBtn').on('click', function(){
            $('#oetPromotionGroupNameTmp').val("");
            $('#ohdPromotionGroupNameTmpOld').val("");
            $("#ocmPromotionGroupTypeTmp").prop('disabled', false);
            $("#ocmPromotionGroupTypeTmp").val("1").selectpicker("refresh");

            $("#ocmPromotionListTypeTmp").val("1");
            $("#ocmPromotionListTypeTmp").trigger('change'); 
            $("#ocmPromotionListTypeTmp").prop('disabled', false);
            $("#ocmPromotionListTypeTmp").selectpicker("refresh"); 

            JSvPromotionStep1ClearPmtPdtDtInTemp(false);
        });

        $('#ocbPromotionPmtPdtDtShopAll').on('change', function(){
            var bShopAllIsChecked = $('#ocbPromotionPmtPdtDtShopAll').is(':checked');
            if(bShopAllIsChecked){
                $('.xCNPromotionStep1BtnBrowse').prop('disabled', true).addClass('xCNBrowsePdtdisabled');
                $('.xCNPromotionStep1BtnShooseFile').prop('disabled', true);
                $('#obtPromotionStep1ImportFile').prop('disabled', true);
                $('.xCNPromotionStep1BtnDropDrownOption').prop('disabled', true);
                $('#oetPromotionStep1PmtFileName').prop('disabled', true);
            }else{
                $('.xCNPromotionStep1BtnBrowse').prop('disabled', false).removeClass('xCNBrowsePdtdisabled');
                $('.xCNPromotionStep1BtnShooseFile').prop('disabled', false);
                
                var bIsInputFileEmpty = $('#oetPromotionStep1PmtFileName').val() == "";
                if(!bIsInputFileEmpty){
                    $('#obtPromotionStep1ImportFile').prop('disabled', false);
                }

                $('.xCNPromotionStep1BtnDropDrownOption').prop('disabled', false);
                $('#oetPromotionStep1PmtFileName').prop('disabled', false);
            }    
        });

        /*===== Begin Group Type Control ===============================================*/
        $('#ocmPromotionGroupTypeTmp').on('change', function(){ // ประเภทกลุ่ม
            var tGroupType = $(this).val();
            JCNxPromotionStep1ControlExcept(tGroupType);
        });
        /*===== End Group Type Control =================================================*/

        if(bIsApvOrCancel){
            $('.xCNAddPmtGroupModalCanCelDisabled').prop('disabled', true);
            $('.xCNPromotionStep1BtnBrowse').prop('disabled', true).addClass('xCNBrowsePdtdisabled');
        }
    });

    /*===== Begin PMT PDT DT Table Process =============================================*/
    /**
     * Functionality : Get PMT_PDT_DT in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep1GetPmtPdtDtInTmp(pnPage, pbUseLoading) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();
            var tPmtGroupNameTmpOld = $('#ohdPromotionGroupNameTmpOld').val();
            var tPmtGroupTypeTmp = $('#ocmPromotionGroupTypeTmp').val();
            var tPmtGroupListTypeTmp = $('#ocmPromotionListTypeTmp').val();

            var tPmtGroupNameTmp = "";
            if(tPmtGroupNameTmpOld != ""){
                tPmtGroupNameTmp = tPmtGroupNameTmpOld;
            }

            var tSearchAll = $('#oetPromotionPdtLayoutSearchAll').val();

            if (pbUseLoading) {
                JCNxOpenLoading();
            }

            (pnPage == '' || (typeof pnPage) == 'undefined') ? pnPage = 1: pnPage = pnPage;

            $.ajax({
                type: "POST",
                url: "promotionStep1GetPmtPdtDtInTmp",
                data: {
                    tBchCode: tBchCode,
                    tPmtGroupNameTmp: tPmtGroupNameTmp,
                    tPmtGroupNameTmpOld: tPmtGroupNameTmpOld,
                    tPmtGroupTypeTmp: tPmtGroupTypeTmp,
                    tPmtGroupListTypeTmp: tPmtGroupListTypeTmp,
                    nPageCurrent: pnPage,
                    tSearchAll: tSearchAll
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
                    window.aPromotionStep1PmtPdtDtNotIn = oResult.notIn;
                    // console.log('aPromotionStep1PmtPdtDtNotIn: ', window.aPromotionStep1PmtPdtDtNotIn);
                    $('#odvPromotionPmtDtTableTmp').html(oResult.html);

                    /* if(JCNbPromotionStep1PmtDtTableIsEmpty()) {
                        $('#ocmPromotionGroupTypeTmp').attr('disabled', false).selectpicker('refresh');
                    }else{
                        $('#ocmPromotionGroupTypeTmp').attr('disabled', true).selectpicker('refresh');
                    } */

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

    /**
     * Functionality : Insert PMT_PDT_DT to Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep1InsertPmtPdtDtToTemp(ptParams) {
        // console.log((ptParams);
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();
            var tPmtGroupNameTmp = $('#oetPromotionGroupNameTmp').val();
            var tPmtGroupNameTmpOld = $('#ohdPromotionGroupNameTmpOld').val();
            var tPmtGroupTypeTmp = $('#ocmPromotionGroupTypeTmp').val();
            var tPmtGroupListTypeTmp = $('#ocmPromotionListTypeTmp').val();

            JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "promotionStep1InsertPmtPdtDtToTmp",
                data: {
                    tBchCode: tBchCode,
                    tPmtGroupNameTmp: tPmtGroupNameTmp,
                    tPmtGroupNameTmpOld: tPmtGroupNameTmpOld,
                    tPmtGroupTypeTmp: tPmtGroupTypeTmp,
                    tPmtGroupListTypeTmp: tPmtGroupListTypeTmp,
                    tPdtList: ptParams
                },
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    JSxPromotionStep1GetPmtPdtDtInTmp(1, true);
                    $('#odvPromotionPopupChequeAdd').modal('hide');
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

    /**
     * Functionality : Clear PMT_PDT_DT in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep1ClearPmtPdtDtInTemp(pbUseLoading) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var bLoadingGet = false;

            if (pbUseLoading) {
                JCNxOpenLoading();
                bLoadingGet = true;
            }

            var tPmtGroupNameTmp = $('#oetPromotionGroupNameTmp').val();
            var tPmtGroupNameTmpOld = $('#ohdPromotionGroupNameTmpOld').val();

            $.ajax({
                type: "POST",
                url: "promotionStep1ClearPmtDtInTmp",
                cache: false,
                data: {
                    tPmtGroupNameTmp: tPmtGroupNameTmp,
                    tPmtGroupNameTmpOld: tPmtGroupNameTmpOld
                },
                timeout: 5000,
                success: function(tResult) {
                    var tListType = $('#ocmPromotionListTypeTmp').val();
                    if (tListType == "1") {
                        JSxPromotionStep1GetPmtPdtDtInTmp(1, bLoadingGet);
                    }
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
    /*===== End PMT PDT DT Table Process ===============================================*/

    /*===== Begin PMT Brand DT Table Process ===========================================*/
    /**
     * Functionality : Get PMT_BRAND_DT in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep1GetPmtBrandDtInTmp(pnPage, pbUseLoading) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();
            var tPmtGroupNameTmpOld = $('#ohdPromotionGroupNameTmpOld').val();
            var tPmtGroupTypeTmp = $('#ocmPromotionGroupTypeTmp').val();
            var tPmtGroupListTypeTmp = $('#ocmPromotionListTypeTmp').val();

            var tPmtGroupNameTmp = "";
            if(tPmtGroupNameTmpOld != ""){
                tPmtGroupNameTmp = tPmtGroupNameTmpOld;
            }

            var tSearchAll = $('#oetPromotionPdtLayoutSearchAll').val();

            if (pbUseLoading) {
                JCNxOpenLoading();
            }

            (pnPage == '' || (typeof pnPage) == 'undefined') ? pnPage = 1: pnPage = pnPage;

            $.ajax({
                type: "POST",
                url: "promotionStep1GetPmtBrandDtInTmp",
                data: {
                    tBchCode: tBchCode,
                    tPmtGroupNameTmp: tPmtGroupNameTmp,
                    tPmtGroupNameTmpOld: tPmtGroupNameTmpOld,
                    tPmtGroupTypeTmp: tPmtGroupTypeTmp,
                    tPmtGroupListTypeTmp: tPmtGroupListTypeTmp,
                    nPageCurrent: pnPage,
                    tSearchAll: tSearchAll
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
                    window.aPromotionStep1PmtPdtDtNotIn = oResult.notIn;
                    $('#odvPromotionPmtDtTableTmp').html(oResult.html);

                    /* if(JCNbPromotionStep1PmtDtTableIsEmpty()) {
                        $('#ocmPromotionGroupTypeTmp').attr('disabled', false).selectpicker('refresh');
                    }else{
                        $('#ocmPromotionGroupTypeTmp').attr('disabled', true).selectpicker('refresh');
                    } */

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

    /**
     * Functionality : Insert PMT_BRAND_DT to Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep1InsertPmtBrandDtToTemp(ptParams) {
        // console.log((ptParams);
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();
            var tPmtGroupNameTmp = $('#oetPromotionGroupNameTmp').val();
            var tPmtGroupNameTmpOld = $('#ohdPromotionGroupNameTmpOld').val();
            var tPmtGroupTypeTmp = $('#ocmPromotionGroupTypeTmp').val();
            var tPmtGroupListTypeTmp = $('#ocmPromotionListTypeTmp').val();

            JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "promotionStep1InsertPmtBrandDtToTmp",
                data: {
                    tBchCode: tBchCode,
                    tPmtGroupNameTmp: tPmtGroupNameTmp,
                    tPmtGroupNameTmpOld: tPmtGroupNameTmpOld,
                    tPmtGroupTypeTmp: tPmtGroupTypeTmp,
                    tPmtGroupListTypeTmp: tPmtGroupListTypeTmp,
                    tBrandList: JSON.stringify(ptParams)
                },
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    JSxPromotionStep1GetPmtBrandDtInTmp(1, true);
                    $('#odvPromotionPopupChequeAdd').modal('hide');
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
     
    /**
     * Functionality : Browse Brand
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep1PmtBrandDtBrowseBrand(){
        // option Brand
        window.oPromotionBrowseBrand = {
            Title: ['product/pdtbrand/pdtbrand', 'tPBNTitle'],
            Table: {
                Master: 'TCNMPdtBrand',
                PK: 'FTPbnCode',
                PKName:'FTPbnName'
            },
            Join: {
                Table: ['TCNMPdtBrand_L'],
                On: ['TCNMPdtBrand.FTPbnCode = TCNMPdtBrand_L.FTPbnCode AND TCNMPdtBrand_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [
                    function() {
                        return "";
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'product/pdtbrand/pdtbrand',
                ColumnKeyLang: ['tPBNCode', 'tPBNName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMPdtBrand.FTPbnCode', 'TCNMPdtBrand_L.FTPbnName'],
                DataColumnsFormat: ['', ''],
                Perpage: 5,
                OrderBy: ['TCNMPdtBrand.FTPbnCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'M',
                Value: ["ohdPromotionBrandCodeTmp", "TCNMPdtBrand.FTPbnCode"],
                Text: ["ohdPromotionBrandNameTmp", "TCNMPdtBrand_L.FTPbnName"],
            },
            NextFunc: {
                FuncName: 'JSvPromotionStep1InsertPmtBrandDtToTemp',
                ArgReturn: ['FTPbnCode', 'FTPbnName']
            },
            BrowseLev: 1,
            // DebugSQL : true
        }
        JCNxBrowseData('oPromotionBrowseBrand');
    }
    /*===== End PMT Brand DT Table Process =============================================*/

    /*===== Begin PMT PDT DT Group Name Table Process ==================================*/
    /**
     * Functionality : Get PMT_PDT_DT Group Name in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep1GetPmtDtGroupNameInTmp(pnPage, pbUseLoading) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();
            var tPmtGroupNameTmpOld = $('#ohdPromotionGroupNameTmpOld').val();

            var tPmtGroupNameTmp = "";
            if(tPmtGroupNameTmpOld != ""){
                tPmtGroupNameTmp = tPmtGroupNameTmpOld;
            }

            var tSearchAll = $('#oetPromotionPdtLayoutSearchAll').val();

            if (pbUseLoading) {
                JCNxOpenLoading();
            }

            (pnPage == '' || (typeof pnPage) == 'undefined') ? pnPage = 1: pnPage = pnPage;

            $.ajax({
                type: "POST",
                url: "promotionStep1GetPmtDtGroupNameInTmp",
                data: {
                    tBchCode: tBchCode,
                    tPmtGroupNameTmp: tPmtGroupNameTmp,
                    nPageCurrent: pnPage,
                    tSearchAll: tSearchAll
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    $('#odvPromotionPmtPdtDtGroupNameDataTable').html(oResult.html);

                    /* if(JCNbPromotionStep1PmtDtTableIsEmpty()) {
                        $('#ocmPromotionGroupTypeTmp').attr('disabled', false).selectpicker('refresh');
                    }else{
                        $('#ocmPromotionGroupTypeTmp').attr('disabled', true).selectpicker('refresh');
                    } */

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
    /*===== End PMT PDT DT Group Name Table Process ====================================*/

    /*
    function : Function Browse
    Parameters : Error Ajax Function 
    Creator : 04/02/2020 Piya
    Return : Modal Status Error
    Return Type : view
    */
    function JCNvPromotionStep1Browse() {
        var tListTypeTmp = $('#ocmPromotionListTypeTmp').val();

        if(tListTypeTmp == "1"){
            JCNxPromotionStep1BrowsePdt();    
        }

        if(tListTypeTmp == "2"){
            JSxPromotionStep1PmtBrandDtBrowseBrand();    
        }
    }

    /*
    function : Function Browse Pdt
    Parameters : Error Ajax Function 
    Creator : 04/02/2020 Piya
    Return : -
    Return Type : -
    */
    function JCNxPromotionStep1BrowsePdt() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            // console.log("Browse PDT NOTIN: ", window.aPromotionStep1PmtPdtDtNotIn);
            $.ajax({
                type: "POST",
                url: "BrowseDataPDT",
                data: {
                    Qualitysearch: [
                        /*"CODEPDT",
                        "NAMEPDT",
                        "BARCODE",
                        "SUP",
                        "PurchasingManager",
                        "NAMEPDT",
                        "CODEPDT",
                        "BARCODE",
                        'LOC',
                        "FromToBCH",
                        "Merchant",
                        "FromToSHP",
                        "FromToPGP",
                        "FromToPTY",
                        "PDTLOGSEQ"
                        "PDTLOGSEQ"*/
                    ],
                    // PriceType: ["Cost", "tCN_Cost", "Company", "1"],
                    PriceType: ['Pricesell'],
                    // 'SelectTier': ['PDT'],
                    SelectTier: ["Barcode"],
                    // 'Elementreturn': ['oetInputTestValue','oetInputTestName'],
                    ShowCountRecord: 10,
                    NextFunc: "JSvPromotionStep1InsertPmtPdtDtToTemp",
                    ReturnType: "M",
                    BCH: ["", ""],
                    SHP: ["", ""],
                    MER: ["", ""],
                    SPL: ["", ""],
                    /* SPL: [$('#oetCreditNoteSplCode').val(), $('#oetCreditNoteSplName').val()],
                    BCH: [$("#oetBchCode").val(), $("#oetBchCode").val()],
                    SHP: [$("#oetShpCodeStart").val(), $("#oetShpCodeStart").val()], */
                    // NOTINITEM: [["00002", "1155109050238"]],
                    NOTINITEM: window.aPromotionStep1PmtPdtDtNotIn
                },
                cache: false,
                timeout: 5000,
                success: function (tResult) {
                    $("#odvModalDOCPDT").modal({backdrop: "static", keyboard: false});
                    $("#odvModalDOCPDT").modal({show: true});

                    // remove localstorage
                    localStorage.removeItem("LocalItemDataPDT");
                    $("#odvModalsectionBodyPDT").html(tResult);
                },
                error: function (data) {
                    // console.log(data);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /*
    function : ยืนยันการสร้างกลุ่มสินค้าโปรโมชัน
    Parameters : Error Ajax Function 
    Creator : 04/02/2020 Piya
    Return : Modal Status Error
    Return Type : view
    */
    function JCNvPromotionStep1ConfirmToSave(bLoadingGet) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tIsShopAll = ""; 
            if(!JCNbPromotionStep1PmtDtIsShopAll()){
                // เช็ครายการในตาราง ห้ามว่าง
                if(JCNbPromotionStep1PmtDtTableIsEmpty()){
                    var tWarningMessage = '<?php echo language('document/promotion/promotion','tWarMsg10'); ?>'; // กรุณาเพิ่มรายการก่อนบันทึก
                    FSvCMNSetMsgWarningDialog(tWarningMessage);
                    return;
                }
            }else{
                tIsShopAll = "1";
            }

            // เช็คชื่อกลุ่ม ห้ามว่าง
            var tGroupNameTmp = $('#oetPromotionGroupNameTmp').val();
            if(tGroupNameTmp === ''){
                var tWarningMessage = '<?php echo language('document/promotion/promotion','tWarMsg11'); ?>'; // กรุณาตั้งชื่อกลุ่มก่อนบันทึก
                FSvCMNSetMsgWarningDialog(tWarningMessage);
                return;
            }

            /*===== Begin Group Name Duplicate Check ===================================*/
            var tPmtGroupNameTmp = $('#oetPromotionGroupNameTmp').val();
            var tPmtGroupNameTmpOld = $('#ohdPromotionGroupNameTmpOld').val();
            // console.log(tPmtGroupNameTmp + ' : ' + tPmtGroupNameTmpOld);
            var bIsGroupNameDup = false;
            if(tPmtGroupNameTmp != '' && (tPmtGroupNameTmp != tPmtGroupNameTmpOld)){
                $.ajax({
                    type: "POST",
                    url: "promotionStep1UniqueValidateGroupName",
                    data: {
                        tPmtGroupNameTmp: tPmtGroupNameTmp,
                        tPmtGroupNameTmpOld: tPmtGroupNameTmpOld
                    },
                    cache: false,
                    timeout: 5000,
                    success: function(oResult) {
                        if(oResult.bStatus){
                            bIsGroupNameDup = true;
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCloseLoading();
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    },
                    async: false
                });

                if(bIsGroupNameDup){
                    var tWarningMessage = '<?php echo language('document/promotion/promotion','tWarMsg12'); ?> "' + tGroupNameTmp + '" <?php echo language('document/promotion/promotion','tWarMsg13'); ?>';
                    FSvCMNSetMsgWarningDialog(tWarningMessage);
                    return;
                }
            }
            /*===== End Group Name Duplicate Check =====================================*/
            
            var tBchCode = $('#oetPromotionBchCode').val();
            var tPmtGroupNameTmp = $('#oetPromotionGroupNameTmp').val();
            var tPmtGroupNameTmpOld = $('#ohdPromotionGroupNameTmpOld').val();
            var tPmtGroupTypeTmp = $('#ocmPromotionGroupTypeTmp').val();
            var tPmtGroupListTypeTmp = $('#ocmPromotionListTypeTmp').val();

            // JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "promotionStep1ConfirmPmtDtInTmp",
                data: {
                    tBchCode: tBchCode,
                    tIsShopAll: tIsShopAll,
                    tPmtGroupNameTmp: tPmtGroupNameTmp,
                    tPmtGroupNameTmpOld: tPmtGroupNameTmpOld,
                    tPmtGroupTypeTmp: tPmtGroupTypeTmp,
                    tPmtGroupListTypeTmp: tPmtGroupListTypeTmp
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
                    JSxPromotionStep1GetPmtDtGroupNameInTmp(1, true);
                    JSxPromotionStep1GetPmtPdtDtInTmp(1, false);
                    $('#oetPromotionGroupNameTmp').val("");

                    // if(tPmtGroupNameTmp != '' && (tPmtGroupNameTmp != tPmtGroupNameTmpOld)){
                    //     $("#odvPromotionLineCont .xCNPromotionStep2").trigger('click');
                    //     $("#odvPromotionLineCont .xCNPromotionStep1").trigger('click');
                    // }

                    $('#odvPromotionAddPmtGroupModal').modal('hide');
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

    /*
    function : ยืนยันการสร้างกลุ่มสินค้าโปรโมชัน
    Parameters : Error Ajax Function 
    Creator : 04/02/2020 Piya
    Return : Modal Status Error
    Return Type : view
    */
    function JCNvPromotionStep1BtnCancelCreateGroupName() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tPmtGroupNameTmp = $('#oetPromotionGroupNameTmp').val();
            var tPmtGroupNameTmpOld = $('#ohdPromotionGroupNameTmpOld').val();
            var tPmtGroupTypeTmp = $('#ocmPromotionGroupTypeTmp').val();
            var tPmtGroupListTypeTmp = $('#ocmPromotionListTypeTmp').val();
            
            $.ajax({
                type: "POST",
                url: "promotionStep1CancelPmtDtInTmp",
                data: {
                    tPmtGroupNameTmp: tPmtGroupNameTmp,
                    tPmtGroupNameTmpOld: tPmtGroupNameTmpOld,
                    tPmtGroupTypeTmp: tPmtGroupTypeTmp,
                    tPmtGroupListTypeTmp: tPmtGroupListTypeTmp
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    JSxPromotionStep1GetPmtDtGroupNameInTmp(1,false);
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                    JCNxCloseLoading();
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /*
    function : มีข้อมูลในตารางหน้า View หรือไม่ (Modal)
    Parameters : -
    Creator : 04/02/2020 Piya
    Return : Status
    Return Type : boolean
    */
    function JCNbPromotionStep1PmtDtTableIsEmpty() {
        var bStatus = true;
        var tListType = $('#ocmPromotionListTypeTmp').val();
        var nRowLength = 0;

        switch(tListType) {
            case "1" : { // สินค้า
                nRowLength = $('#otbPromotionStep1PmtPdtDtTable .xCNPromotionPmtPdtDtRow').length;
                break;
            }
            case "2" : { // ยี่ห้อ
                nRowLength = $('#otbPromotionStep1PmtBrandDtTable .xCNPromotionPmtBrandDtRow').length;
                break;
            }
        }

        if(nRowLength > 0){
            bStatus = false;
        }
        return bStatus;
    }

    /*
    function : มีรายการ กลุ่มยกเว้น ใน Temp หรือไม่
    Parameters : -
    Creator : 04/02/2020 Piya
    Return : Status
    Return Type : boolean
    */
    function JCNbPromotionStep1PmtDtHasExcludeTypeInTemp() {
        var bStatus = false;
        var tListType = $('#ohdPromotionPmtDtStaListTypeInTmp').val();

        if(tListType != ""){
            bStatus = true;
        }
        return bStatus;
    }

    /*
    function : มีข้อมูลในตารางหน้า View หรือไม่ (Modal)
    Parameters : -
    Creator : 04/02/2020 Piya
    Return : Status
    Return Type : boolean
    */
    function JCNbPromotionStep1PmtDtGroupNameTableIsEmpty() {
        var bStatus = true;
        nRowLength = $('#odvPromotionPmtPdtDtGroupNameDataTable #otbPromotionStep1PmtPdtDtGroupNameTable .xCNPromotionPmtPdtDtGroupNameRow').length;
        if(nRowLength > 0){
            bStatus = false;
        }
        return bStatus;
    }

    /*
    function : มีการเลือกทั้งร่้านหรือไม่
    Parameters : -
    Creator : 04/02/2020 Piya
    Return : Status
    Return Type : boolean
    */
    function JCNbPromotionStep1PmtDtIsShopAll() {
        var bStatus = false;
        bShopAllIsChecked = $('#ocbPromotionPmtPdtDtShopAll').is(':checked');
        if(bShopAllIsChecked){
            bStatus = true;
        }
        return bStatus;
    }
    
    /*
    function : ตรวจสอบข้อมูลก่อน Next Step
    Parameters : -
    Creator : 04/02/2020 Piya
    Return : Status
    Return Type : boolean
    */
    function JCNbPromotionStep1IsValid() {
        var bStatus = false;
        var bPmtDtGroupNameTableIsEmpty = JCNbPromotionStep1PmtDtGroupNameTableIsEmpty();   

        if(!bPmtDtGroupNameTableIsEmpty){
            bStatus = true;
        }
        return bStatus;
    }

    /*
    function : ตรวจสอบว่ามีรายการยกเว้นหรือไม่
    Parameters : -
    Creator : 14/12/2020 Piya
    Return : Status
    Return Type : boolean
    */
    function JCNbPromotionStep1HaveExceptOneMore() {
        var bStatus = false;
        var bIsHave = $("#otbPromotionStep1PmtPdtDtGroupNameTable .xCNPromotionPmtPdtDtGroupNameRow[data-sta-type='2']").length > 1;   

        if(bIsHave){
            bStatus = true;
        }
        return bStatus;
    }

    /*
    function : ตรวจสอบว่ามีรายการยกเว้นว่างใช่ไหม
    Parameters : -
    Creator : 14/12/2020 Piya
    Return : Status
    Return Type : boolean
    */
    function JCNbPromotionStep1EmptyExcept() {
        var bStatus = false;
        var bIsEmpty = $("#otbPromotionStep1PmtPdtDtGroupNameTable .xCNPromotionPmtPdtDtGroupNameRow[data-sta-type='2']").length < 1;   

        if(bIsEmpty){
            bStatus = true;
        }
        return bStatus;
    }

    /*
    function : ควบคุมประเภทกลุ่ม(ยกเว้น)
    Parameters : -
    Creator : 14/12/2020 Piya
    Return : Status
    Return Type : -
    */
    function JCNxPromotionStep1ControlExcept(ptGroupType) {
        var bHaveExceptOneMore = JCNbPromotionStep1HaveExceptOneMore();
        var bEmptyExcept = JCNbPromotionStep1EmptyExcept();
        var tGroupNameOld = $("#ohdPromotionGroupNameTmpOld").val();
        var tStaListTypeExcept = $("#otbPromotionStep1PmtPdtDtGroupNameTable .xCNPromotionPmtPdtDtGroupNameRow[data-sta-type='2']").data('sta-list-type');
        var tGroupNameExcept = $("#otbPromotionStep1PmtPdtDtGroupNameTable .xCNPromotionPmtPdtDtGroupNameRow[data-sta-type='2']").data('group-name');
        if( (ptGroupType == "2" && !bEmptyExcept) && ((tGroupNameOld != tGroupNameExcept) || bHaveExceptOneMore) ){ // 2: กลุ่มยกเว้น
            $("#ocmPromotionListTypeTmp").val(tStaListTypeExcept); 
            $("#ocmPromotionListTypeTmp").prop('disabled', true);
            $("#ocmPromotionListTypeTmp").selectpicker("refresh");
        }else{ 
            $("#ocmPromotionListTypeTmp").prop('disabled', false);
            $("#ocmPromotionListTypeTmp").selectpicker("refresh");
        }
    }

    /*===== Begin Import Excel =========================================================*/
    /**
     * Functionality : Set after change file
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 04/02/2020 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep1SetImportFile(poElement, poEvent) {
        try {
            var oFile = $(poElement)[0].files[0];
            console.log('oFile: ', oFile);
            if(oFile == undefined){
                $("#oetPromotionStep1PmtFileName").val("");
                $('#obtPromotionStep1ImportFile').attr('disabled', true);
            }else{
                $("#oetPromotionStep1PmtFileName").val(oFile.name);
                $('#obtPromotionStep1ImportFile').attr('disabled', false);
            }
            
        } catch (err) {
            console.log("JSxPromotionStep1SetImportFile Error: ", err);
        }
    }

    /**
     * Functionality : Confirm Import File
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep1ConfirmImportFile(){
        var tListTypeTmp = $('#ocmPromotionListTypeTmp').val();
        var tImportTypeMsg = '';

        if(tListTypeTmp == "1"){
            tImportTypeMsg = '<h3><?php echo language('document/promotion/promotion','tWarMsg14'); ?> <b><?php echo language('document/promotion/promotion','tProducts'); ?></b></h3>'      
        }

        if(tListTypeTmp == "2"){   
            tImportTypeMsg = '<h3><?php echo language('document/promotion/promotion','tWarMsg14'); ?> <b><?php echo language('document/promotion/promotion','tBrand'); ?></b></h3>'
        }

        var tImportConditionMsg = 
            '<p>- <?php echo language('document/promotion/promotion','tWarMsg15'); ?></p>' +
            '<p>- <?php echo language('document/promotion/promotion','tWarMsg16'); ?></p>' +
            '<p>- <?php echo language('document/promotion/promotion','tWarMsg17'); ?></p>'
        ;

        var tClearDataMsg = '<p><u><?php echo language('document/promotion/promotion','tWarMsg18'); ?></u></p>';

        FSvCMNSetMsgWarningDialog(tImportTypeMsg + tImportConditionMsg + tClearDataMsg, 'JSxPromotionStep1ImportFileToTemp', '', true);
    }

    /**
     * Functionality : Import Excel File to Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep1ImportFileToTemp() {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof (nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxOpenLoading();
                // console.log("ptStaShift: ", ptStaShift);
                var tPmtGroupNameTmp = $('#oetPromotionGroupNameTmp').val();
                var tPmtGroupNameTmpOld = $('#ohdPromotionGroupNameTmpOld').val();
                var tPmtGroupTypeTmp = $('#ocmPromotionGroupTypeTmp').val();
                var tPmtGroupListTypeTmp = $('#ocmPromotionListTypeTmp').val();

                var oFormData = new FormData();
                var oFile = $('#oefPromotionStep1PmtFileExcel')[0].files[0];
                console.log("File: ", oFile);
                oFormData.append('tPmtGroupNameTmp', tPmtGroupNameTmp);
                oFormData.append('tPmtGroupNameTmpOld', tPmtGroupNameTmpOld);
                oFormData.append('tPmtGroupTypeTmp', tPmtGroupTypeTmp);
                oFormData.append('tPmtGroupListTypeTmp', tPmtGroupListTypeTmp);
                oFormData.append('oefPromotionStep1PmtFileExcel', oFile);
                oFormData.append('aFile', oFile);
                
                $.ajax({
                    type: "POST",
                    url: "promotionStep1ImportExcelPmtDtToTmp",
                    data: oFormData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    Timeout: 0,
                    success: function (oResult) {
                        if(oResult.nStaEvent == "1"){
                            if(tPmtGroupListTypeTmp == "1"){ // Product
                                JSxPromotionStep1GetPmtPdtDtInTmp(1, false);
                            }
                            if(tPmtGroupListTypeTmp == "2"){ // Brand
                                JSxPromotionStep1GetPmtBrandDtInTmp(1, false)    
                            }
                        }else{
                            JCNxCloseLoading();
                        }
                        $('#oetPromotionStep1PmtFileName').val("");
                        $('#oefPromotionStep1PmtFileExcel').val(null);
                        $('#obtPromotionStep1ImportFile').attr('disabled', true);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxCloseLoading();
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log("JSxPromotionStep1ImportFileToTemp Error: ", err);
        }
    }
    /*===== End Import Excel ===========================================================*/
</script>