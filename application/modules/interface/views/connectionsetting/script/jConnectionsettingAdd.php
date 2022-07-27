<script type="text/javascript">

    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit")?>;

    $(document).ready(function(){
      
        // event
        $("#oetCssBchCode").change(function(){
            JSxSltBrowseDisabled(); 
        });

        $('.selectpicker').selectpicker();

        $("#oetCssBchCode").change(function(){
            JSxSltBrowseDisabled(); 
        });

    });


    //ถ้า ไม่มีการเลือก สาขา Browse คลังจะถูกปิด
    function JSxSltBrowseDisabled(){
        var tBchCode = $('#oetCssBchCode').val();
        if(tBchCode == ''){
            $('#oimBrowseWah').attr('disabled', true);
            $('#oetCssWahCode').val('');
            $('#oetCssWahName').val('');
        }else{
            $('#oimBrowseWah').attr('disabled', false);
        }
    }

    //BrowseAgn 
    $('#oimBrowseAgn').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowseAgn({
                'tReturnInputCode'  : 'oetCssAgnCode',
                'tReturnInputName'  : 'oetCssAgnName',
                'tBchCodeWhere'     : $('#oetCssBchCode').val(),
            });
            JCNxBrowseData('oPdtBrowseAgencyOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    //BrowseBch
    $('#oimBrowseBch').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oBrowseBranchOption = oBrowseBch({
                'tReturnInputCode'  : 'oetCssBchCode',
                'tReturnInputName'  : 'oetCssBchName',
                'tAgnCodeWhere'     : $('#oetCssAgnCode').val(),
            });
            JCNxBrowseData('oBrowseBranchOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


    //BrowseWah
    $('#oimBrowseWah').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oBrowseWahOption = oBrowseWah({
                'tReturnInputCode'  : 'oetCssWahCode',
                'tReturnInputName'  : 'oetCssWahName',
                'tBchCodeWhere'     : $('#oetCssBchCode').val(),
            });
            JCNxBrowseData('oBrowseWahOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    
    //Option Agn
    var oBrowseAgn =   function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tBchCodeWhere       = poReturnInput.tBchCodeWhere;
        
        var oOptionReturn       = {
            Title : ['ticket/agency/agency', 'tAggTitle'],
            Table:{Master:'TCNMAgency', PK:'FTAgnCode'},
            Join :{
            Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang	: 'ticket/agency/agency',
                ColumnKeyLang	: ['tAggCode', 'tAggName'],
                ColumnsSize     : ['15%', '85%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat : ['', ''],
                Perpage			: 10,
                OrderBy			: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMAgency.FTAgnCode"],
                Text		: [tInputReturnName,"TCNMAgency_L.FTAgnName"],
            },
            RouteAddNew : 'agency',
            BrowseLev : 1,
            NextFunc: {
				FuncName: 'JSxClearBrowseConditionAgn',
				ArgReturn: ['FTAgnCode']
			}
        }
        return oOptionReturn;
    }

    function JSxClearBrowseConditionAgn(ptData){
        // aData = JSON.parse(ptData);
        if(ptData != '' || ptData != 'null'){
            $('#oetCssBchCode').val(''); 
            $('#oetCssBchName').val(''); 
            $('#oetCssWahCode').val('');
            $('#oetCssWahName').val('');
            $("#oimBrowseWah").attr("disabled",true);
        }
    }

    //Option Branch
    var oBrowseBch       = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tAgnCodeWhere       = poReturnInput.tAgnCodeWhere;

        $nCountBCH = '<?=$this->session->userdata('nSesUsrBchCount')?>';

        if($nCountBCH > 1){
            //ถ้าสาขามากกว่า 1 
            tBCH        = "<?=$this->session->userdata('tSesUsrBchCodeMulti');?>";
            tWhereBCH   = " AND TCNMBranch.FTBchCode IN ( " + tBCH + " ) ";
        }else{
            tWhereBCH   = '';
        }

        if(tAgnCodeWhere == '' || tAgnCodeWhere == null){
            tWhereAgn   = '';
        }else{
            tWhereAgn   = " AND TCNMBranch.FTAgnCode = '"+tAgnCodeWhere+"'";
        }


        var oOptionReturn       = {
            Title   : ['company/branch/branch','tBCHTitle'],
            Table   :{Master:'TCNMBranch',PK:'FTBchCode'},
            Join :{
                Table   :	['TCNMBranch_L','TCNMAgency_L'],
                On      :   [
                    'TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+ nLangEdits,
                    'TCNMAgency_L.FTAgnCode = TCNMBranch.FTAgnCode AND TCNMAgency_L.FNLngID = '+ nLangEdits,
            ]
            },
            Where:{
                Condition : [tWhereBCH+tWhereAgn]
            },
            GrideView:{
                ColumnPathLang	: 'company/branch/branch',
                ColumnKeyLang	: ['tBCHCode','tBCHName'],
                ColumnsSize     : ['15%','75%'],
                DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName','TCNMAgency_L.FTAgnName','TCNMBranch.FTAgnCode'],
                DataColumnsFormat : ['','','',''],
                DisabledColumns: [2, 3],
                WidthModal      : 50,
                Perpage			: 10,
                OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMBranch.FTBchCode"],
                Text		: [tInputReturnName,"TCNMBranch_L.FTBchName"],
            },
            RouteAddNew : 'branch',
            BrowseLev : 1,
            NextFunc: {
                FuncName: 'JSxClearBrowseConditionBCH',
                ArgReturn: ['FTAgnName','FTAgnCode']
            }
        }
        return oOptionReturn;
    }

    //หลังจากเลือกสาขาต้องล้างค้า
    function JSxClearBrowseConditionBCH(ptData){
      
        if(ptData == '' || ptData == 'null'){
            $("#oimBrowseWah").attr("disabled",true);
        }else{
            aData = JSON.parse(ptData);
            var FTAgnName = aData[0];
            var FTAgnCode = aData[1];

            $('#oetCssAgnCode').val(FTAgnCode);
            $('#oetCssAgnName').val(FTAgnName);
            $('#oetCssWahCode').val('');
            $('#oetCssWahName').val('');
            $("#oimBrowseWah").attr("disabled",false);
        }
    }

  
    oBrowseWah =  function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tBchCodeWhere       = poReturnInput.tBchCodeWhere;

        var  tWhereStaType   = "AND ((TCNMWaHouse.FTWahStaType = '1' AND  TCNMWaHouse.FTWahCode = '00001') OR TCNMWaHouse.FTWahStaType = '2') AND ISNULL(TLKMWaHouse.FTWahCode, '') = ''  AND TCNMWaHouse.FTBchCode =  '"+tBchCodeWhere+"'";

        var oOptionReturn       = {
            Title: ['company/warehouse/warehouse','tWAHTitle'],
            Table:{Master:'TCNMWaHouse',PK:'FTWahCode'},
            Join :{
                Table: ['TCNMWaHouse_L','TLKMWaHouse','TCNMBranch','TCNMBranch_L','TCNMAgency_L'],
                On:[
                    'TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = '+nLangEdits,
                    'TCNMWaHouse.FTBchCode = TLKMWaHouse.FTBchCode AND TCNMWaHouse.FTWahCode = TLKMWaHouse.FTWahCode',
                    'TCNMWaHouse.FTBchCode = TCNMBranch.FTBchCode',
                    'TCNMWaHouse.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,
                    'TCNMBranch.FTAgnCode = TCNMAgency_L.FTAgnCode AND TCNMAgency_L.FNLngID = '+nLangEdits,
                ]
            },
            Where : {
                Condition : [tWhereStaType]
            },
            GrideView:{
                ColumnPathLang	: 'company/warehouse/warehouse',
                ColumnKeyLang	: ['tWahBranch','tWahCode','tWahName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TCNMWaHouse.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMWaHouse.FTWahCode"],
                Text		: [tInputReturnName,"TCNMWaHouse_L.FTWahName"],
            },
            RouteAddNew : 'branch',
            BrowseLev : 1,
        }
        return oOptionReturn;
    }

    





















</script>