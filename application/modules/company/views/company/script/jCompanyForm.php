<script type="text/javascript">
    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit")?>;
    // Option Branch
    $nCountBCH = '<?= $this->session->userdata('nSesUsrBchCount') ?>';
    if ($nCountBCH > 0) {
        //ถ้าสาขามากกว่า 1 
        tBCH = "<?= $this->session->userdata('tSesUsrBchCodeMulti'); ?>";
        tWhereBCH = " AND TCNMBranch.FTBchCode IN ( " + tBCH + " ) ";
    } else {
        tWhereBCH = '';
        tBCH = "<?= $this->session->userdata('tSesUsrBchCodeMulti'); ?>";
    }
    var oCmpBranch      = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var oOptionReturn       = {
            Title   : ['company/branch/branch','tBCHTitle'],
            Table   :{Master:'TCNMBranch',PK:'FTBchCode'},
            Join    :{
                Table : ['TCNMBranch_L'],
                On : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
            },
            Where: {
                Condition: [tWhereBCH]
            },
            GrideView:{
                ColumnPathLang	: 'company/branch/branch',
                ColumnKeyLang	: ['tBCHCode','tBCHName'],
                ColumnsSize     : ['10%','75%'],
                DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                DataColumnsFormat : ['',''],
                WidthModal      : 50,
                Perpage			: 10,
                OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
            },
            
            CallBack:{
                ReturnType : 'S',
                Value : [tInputReturnCode,"TCNMBranch.FTBchCode"],
                Text : [tInputReturnName,"TCNMBranch_L.FTBchName"],
            },
            RouteAddNew : 'branch',
            BrowseLev : nStaCmpBrowseType
        };
        return oOptionReturn;
    }
    
    // Option Currency
    var oCmpCurrency    = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var oOptionReturn       = {
            Title   : ['payment/rate/rate','tRTETitle'],
            Table   :{Master:'TFNMRate',PK:'FTRteCode'},
            Join    :{
                Table : ['TFNMRate_L'],
                On : ['TFNMRate_L.FTRteCode = TFNMRate.FTRteCode AND TFNMRate_L.FNLngID = '+nLangEdits,]
            },
            GrideView:{
                ColumnPathLang	: 'payment/rate/rate',
                ColumnKeyLang	: ['tRTETBRteCode','tRTETBRteName'],
                ColumnsSize     : ['10%','75%'],
                DataColumns		: ['TFNMRate.FTRteCode','TFNMRate_L.FTRteName'],
                DataColumnsFormat : ['',''],
                WidthModal      : 50,
                Perpage			: 10,
                OrderBy			: ['TFNMRate.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TFNMRate.FTRteCode"],
                Text		: [tInputReturnName,"TFNMRate_L.FTRteName"],
            },
            RouteAddNew : 'rate',
            BrowseLev : nStaCmpBrowseType,
            // DebugSQL : true
        };
        return oOptionReturn;
    }
    var oCmpVatRate     = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tTextLeftJoin       = "( SELECT Result.* ";
            tTextLeftJoin       += " FROM ";
            tTextLeftJoin       += " ( ";
            tTextLeftJoin       += "   SELECT VatAtv.* FROM (  ";
            tTextLeftJoin       += "     SELECT  ";
            tTextLeftJoin       += "        row_number() over (partition by TCNMVatRate.FTVatCode order by FDVatStart DESC) as VatRateActive, ";
            tTextLeftJoin       += "        TCNMVatRate.FDVatStart, ";
            tTextLeftJoin       += "        TCNMVatRate.FTVatCode,  ";
            tTextLeftJoin       += "        TCNMVatRate.FCVatRate ";
            tTextLeftJoin       += "     FROM TCNMVatRate ";
            tTextLeftJoin       += "     WHERE 1 = 1 ";
            tTextLeftJoin       += "    AND (CONVERT(VARCHAR(19), GETDATE(), 121) >= CONVERT(VARCHAR(19), TCNMVatRate.FDVatStart, 121)) ";
            tTextLeftJoin       += " ) VatAtv WHERE VatAtv.VatRateActive = 1 ";
            tTextLeftJoin       += " ) AS Result ";
            tTextLeftJoin       += ") AS TVJOIN ";

        var oOptionReturn       = {
            Title : ['company/vatrate/vatrate','tVATTitle'],
            Table : {Master:'TCNMVatRate',PK:'FTVatCode'},
            Join    :{
                Table : [tTextLeftJoin],
                SpecialJoin : ['INNER JOIN'],
                On : ['TCNMVatRate.FTVatCode = TVJOIN.FTVatCode AND TCNMVatRate.FDVatStart = TVJOIN.FDVatStart']
            },
            GrideView :{
                ColumnPathLang	: 'company/vatrate/vatrate',
                ColumnKeyLang	: ['tVATTBCode','tVATTBRate','tVATDateStart'],
                DataColumns		: ['TCNMVatRate.FTVatCode','TCNMVatRate.FCVatRate','TCNMVatRate.FDVatStart'],
                Perpage			: 10,
                OrderBy			: ['TCNMVatRate.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMVatRate.FTVatCode"],
                Text		: [tInputReturnName,"TCNMVatRate.FCVatRate"],
            },
            // DebugSQL : true
        };
        return oOptionReturn;
    }


    $(document).ready(function(){
        $('.xCNComboSelect').selectpicker('refresh');

        // Event Browse สาขา
        $('#obtCmpBrowseBranch').click(function() { 
            poElement = this;
            if (poElement.getAttribute("data-dblclick") == null) {
                poElement.setAttribute("data-dblclick", 1);
                $(poElement).select();
                setTimeout(function () {
                    if (poElement.getAttribute("data-dblclick") == 1) {
                        var nStaSession = JCNxFuncChkSessionExpired();
                        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                            // Create By Witsarut 04/10/2019
                                JSxCheckPinMenuClose();
                             // Create By Witsarut 04/10/2019
                            window.oCmpBranchOption = undefined;
                            oCmpBranchOption        = oCmpBranch({
                                'tReturnInputCode'  : 'oetCmpBchCode',
                                'tReturnInputName'  : 'oetCmpBchName',
                            })
                            JCNxBrowseData('oCmpBranchOption');
                        }else{
                            JCNxShowMsgSessionExpired();
                        }
                    }
                    poElement.removeAttribute("data-dblclick");
                }, 300);
            }
        });

        // Event Browse สกุลเงิน
        $('#obtCmpBrowseCurrency').click(function() { 
            poElement = this;
            if (poElement.getAttribute("data-dblclick") == null) {
                poElement.setAttribute("data-dblclick", 1);
                $(poElement).select();
                setTimeout(function () {
                    if (poElement.getAttribute("data-dblclick") == 1) {
                        var nStaSession = JCNxFuncChkSessionExpired();
                        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                            // Create By Witsarut 04/10/2019
                                JSxCheckPinMenuClose();
                             // Create By Witsarut 04/10/2019
                            window.oCmpCurrencyOption   = undefined;
                            oCmpCurrencyOption          = oCmpCurrency({
                                'tReturnInputCode'  : 'oetCmpRteCode',
                                'tReturnInputName'  : 'oetCmpRteName',
                            });
                            JCNxBrowseData('oCmpCurrencyOption');
                        }else{
                            JCNxShowMsgSessionExpired();
                        }
                    }
                    poElement.removeAttribute("data-dblclick");
                }, 300);
            }
        });

        // Event Browse อัตรภาษี
        $('#obtCmpBrowseVatRate').click(function() { 
            poElement = this;
            if (poElement.getAttribute("data-dblclick") == null) {
                poElement.setAttribute("data-dblclick", 1);
                $(poElement).select();
                setTimeout(function () {
                    if (poElement.getAttribute("data-dblclick") == 1) {
                        var nStaSession = JCNxFuncChkSessionExpired();
                        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                             // Create By Witsarut 04/10/2019
                                JSxCheckPinMenuClose();
                             // Create By Witsarut 04/10/2019
                            window.oCmpVatRateOption   = undefined;
                            oCmpVatRateOption          = oCmpVatRate({
                                'tReturnInputCode'  : 'oetVatRateCode',
                                'tReturnInputName'  : 'oetVatRateName',
                            });
                            JCNxBrowseData('oCmpVatRateOption');
                        }else{
                            JCNxShowMsgSessionExpired();
                        }
                    }
                    poElement.removeAttribute("data-dblclick");
                }, 300);
            }
        });

    });

    // Browse ประเทศ
    $('#obtCmpBrowseCountry').click(function() {
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowseCountry');
    });
    var nLangStaLocal = <?php echo FCNaGetLngStalocal() ?>;
    var nDefLang      = <?php echo $this->session->userdata("tSesDefLanguage")?>
    
    var oBrowseCountry = {
        Title: ['company/company/company', 'tCMPRefCountry'],
        Table: {
            Master: 'TCNMCountry',
            PK: 'FTCtyCode',
        },
        Join: {
            Table: ['TCNMCountry_L'],
            On: ['TCNMCountry_L.FTCtyCode = TCNMCountry.FTCtyCode  AND (TCNMCountry_L.FNLngID = ' + nDefLang + ' OR TCNMCountry_L.FNLngID= '+ nLangEdits + ' OR TCNMCountry_L.FNLngID= '+ nLangStaLocal + ')', ]
        },
        Where: {
            Condition: ['AND TCNMCountry.FTCtyStaUse = 1 ']
        },
        GrideView: {
            ColumnPathLang: 'company/company/company',
            ColumnKeyLang: ['tCMPCyCode', 'tCMPCyName'],
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
            Value: ["oetCmpCyCode", "TCNMCountry.FTCtyCode"],
            Text: ["oetCmpCyName", "TCNMCountry_L.FTCtyName"],
        },
        // DebugSQL: true,
    };


</script>