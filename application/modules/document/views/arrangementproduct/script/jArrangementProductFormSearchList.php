<script type="text/javascript">

    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit"); ?>;

    $(document).ready(function(){

        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            format                  : 'yyyy-mm-dd',
            enableOnReadonly        : false,
            disableTouchKeyboard    : true,
            autoclose               : true,
            todayHighlight          : true
        });

        // Doc Date From
        $('#obtPAMDocDateFrm').unbind().click(function(){
            $('#oetPAMDocDateFrm').datepicker('show');
        });

        // Doc Date To
        $('#obtPAMDocDateTo').unbind().click(function(){
            $('#oetPAMDocDateTo').datepicker('show');
        });

    });

    // ค้นหาขั้นสูง
    $('#oahPAMAdvanceSearch').unbind().click(function(){
        if($('#odvPAMAdvanceSearchContainer').hasClass('hidden')){
            $('#odvPAMAdvanceSearchContainer').removeClass('hidden').hide().slideDown(500);
        }else{
            $("#odvPAMAdvanceSearchContainer").slideUp(500,function() {
                $(this).addClass('hidden');
            });
        }
    });

    // From Search Data Page 
    $("#obtPAMConfirmSearch").unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            JSvPAMCallPageDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Branch From
    $('#obtPAMBrowseBch').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPAMBrowseBranchFromOption  = oPAMBrowseBranch({
                'tReturnInputCode'  : 'oetPAMBchCode',
                'tReturnInputName'  : 'oetPAMBchName'
            });
            JCNxBrowseData('oPAMBrowseBranchFromOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Location
    $('#obtPAMBrowsePlc').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPAMBrowseLocationOption  = oPAMBrowseLocation({
                'tReturnInputCode'  : 'oetPAMPlcCode',
                'tReturnInputName'  : 'oetPAMPlcName'
            });
            JCNxBrowseData('oPAMBrowseLocationOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Category 1
    $('#obtPAMBrowseCat1').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPAMBrowseCategoryOption  = oPAMBrowseCategory({
                'tReturnInputCode'  : 'oetPAMCat1Code',
                'tReturnInputName'  : 'oetPAMCat1Name',
                'nCatLevel'         :  1
            });
            JCNxBrowseData('oPAMBrowseCategoryOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Category 2
    $('#obtPAMBrowseCat2').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPAMBrowseCategoryOption  = oPAMBrowseCategory({
                'tReturnInputCode'  : 'oetPAMCat2Code',
                'tReturnInputName'  : 'oetPAMCat2Name',
                'nCatLevel'         :  2
            });
            JCNxBrowseData('oPAMBrowseCategoryOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

     // Option Branch
     var oPAMBrowseBranch = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tUsrLevel 	  	= "<?=$this->session->userdata("tSesUsrLevel"); ?>";
        var tBchCodeMulti 	= "<?=$this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        var nCountBch 		= "<?=$this->session->userdata("nSesUsrBchCount"); ?>";
        var nLangEdits      = "<?=$this->session->userdata("tLangEdit")?>";
        var tWhere 			= "";

        if(nCountBch == 1){
            $('#obtPAMBrowseBch').attr('disabled',true);
        }

        if(tUsrLevel != "HQ"){
            tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
        }else{
            tWhere = "";
        }

        var oOptionReturn       = {
            Title : ['company/branch/branch','tBCHTitle'],
            Table : {Master:'TCNMBranch',PK:'FTBchCode'},
            Join :{
                Table : ['TCNMBranch_L'],
                On : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
            },
            Where   : {
                Condition : [tWhere]
            },
            GrideView:{
                ColumnPathLang      : 'company/branch/branch',
                ColumnKeyLang       : ['tBCHCode','tBCHName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                DataColumnsFormat   : ['',''],
                Perpage             : 20,
                OrderBy             : ['TCNMBranch.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMBranch.FTBchCode"],
                Text		: [tInputReturnName,"TCNMBranch_L.FTBchName"],
            },
        }
        return oOptionReturn;
    };

    // Option Location
    var oPAMBrowseLocation = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tUsrLevel 	  	= "<?=$this->session->userdata("tSesUsrLevel"); ?>";
        var tBchCodeMulti 	= "<?=$this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        var nCountBch 		= "<?=$this->session->userdata("nSesUsrBchCount"); ?>";
        var nLangEdits      = "<?=$this->session->userdata("tLangEdit")?>";
        var tWhere 			= "";
        var tAgnCode        = '<?=$this->session->userdata("tSesUsrAgnCode"); ?>';
        if(nCountBch == 1){
            $('#obtPAMBrowseBch').attr('disabled',true);
        }

        if(tUsrLevel != "HQ"){
            tWhere = " AND TCNMPdtLoc.FTAgnCode = '"+tAgnCode+"' ";
        }else{
            tWhere = "";
        }
      
        var oOptionReturn       = {
            Title : ['product/pdtlocation/pdtlocation','tLOCTitle'],
            Table : {Master:'TCNMPdtLoc',PK:'FTPlcCode'},
            Join :{
                Table : ['TCNMPdtLoc_L'],
                On : ['TCNMPdtLoc_L.FTPlcCode = TCNMPdtLoc.FTPlcCode AND TCNMPdtLoc_L.FNLngID = '+nLangEdits,]
            },
            Where   : {
                Condition : [tWhere]
            },
            GrideView:{
                ColumnPathLang      : 'product/pdtlocation/pdtlocation',
                ColumnKeyLang       : ['tLOCFrmLocCode','tLOCFrmLocName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMPdtLoc.FTPlcCode','TCNMPdtLoc_L.FTPlcName'],
                DataColumnsFormat   : ['',''],
                Perpage             : 20,
                OrderBy             : ['TCNMPdtLoc.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMPdtLoc.FTPlcCode"],
                Text		: [tInputReturnName,"TCNMPdtLoc_L.FTPlcName"],
            },
        }
        return oOptionReturn;
    };

    // Option Location
    var oPAMBrowseCategory = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var nCatLevel           = poReturnInput.nCatLevel;
        var tWhere              = " AND TCNMPdtCatInfo.FTCatStaUse = '1' ";

        if( nCatLevel != "" ){
            tWhere += " AND TCNMPdtCatInfo.FNCatLevel = "+nCatLevel+" ";
            var tCat1Code = $("#oetPAMCat1Code").val();
            if (nCatLevel=='2' && tCat1Code !='') {
                tWhere += " AND TCNMPdtCatInfo.FTCatParent = '"+tCat1Code+"' ";
            }
        }

        var oOptionReturn       = {
            Title : ['product/pdtcat/pdtcat','tCATTitle'],
            Table : {Master:'TCNMPdtCatInfo',PK:'FTCatCode'},
            Join :{
                Table : ['TCNMPdtCatInfo_L'],
                On : ['TCNMPdtCatInfo_L.FTCatCode = TCNMPdtCatInfo.FTCatCode AND TCNMPdtCatInfo_L.FNCatLevel = TCNMPdtCatInfo.FNCatLevel AND TCNMPdtCatInfo_L.FNLngID = '+nLangEdits,]
            },
            Where   : {
                Condition : [tWhere]
            },
            GrideView:{
                ColumnPathLang      : 'product/pdtcat/pdtcat',
                ColumnKeyLang       : ['tCATTBCode','tCATTBName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMPdtCatInfo.FTCatCode','TCNMPdtCatInfo_L.FTCatName'],
                DataColumnsFormat   : ['',''],
                Perpage             : 20,
                OrderBy             : ['TCNMPdtCatInfo.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMPdtCatInfo.FTCatCode"],
                Text		: [tInputReturnName,"TCNMPdtCatInfo_L.FTCatName"],
            },
        }
        return oOptionReturn;
    };

    // ล้างข้อมูล clear ค่า
    function JSxPAMClearAdvSearchData(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){

            var nCountBch = "<?=$this->session->userdata("nSesUsrBchCount"); ?>";
            if(nCountBch != 1){ //ถ้ามีมากกว่า 1 สาขาต้อง reset 
                $('#oetPAMBchName').val("");
                $('#oetPAMBchCode').val("");
            }

            $('#oetSearchAll').val("")
            $('#oetPAMDocDateFrm').val("");
            $('#oetPAMDocDateTo').val("");
            $('#oetPAMPlcCode').val("");
            $('#oetPAMPlcName').val("");

            $('#oetPAMCat1Code').val("");
            $('#oetPAMCat1Name').val("");
            $('#oetPAMCat2Code').val("");
            $('#oetPAMCat2Name').val("");

            $('#ofmPAMSearchAdv').find('select').val(0).selectpicker("refresh");
            JSvPAMCallPageDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

</script>
