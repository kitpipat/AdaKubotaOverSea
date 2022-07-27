<script type="text/javascript">
    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';

    $(document).ready(function(){
        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
        });

        // Doc Date From
        $('#obtCPHAdvSearchDocDateForm').unbind().click(function(){
            $('#oetCPHAdvSearcDocDateFrom').datepicker('show');
        });

        // Doc Date To
        $('#obtCPHAdvSearchDocDateTo').unbind().click(function(){
            $('#oetCPHAdvSearcDocDateTo').datepicker('show');
        });
    });

    // Advance search Display control
    $('#obtCPHAdvanceSearch').unbind().click(function(){
        if($('#odvCPHAdvanceSearchContainer').hasClass('hidden')){
            $('#odvCPHAdvanceSearchContainer').removeClass('hidden').hide().slideDown(500);
        }else{
            $("#odvCPHAdvanceSearchContainer").slideUp(500,function() {
                $(this).addClass('hidden');
            });
        }
    });

    // Option Branch
    var oCPHBrowseBranch    = function(poCPHBchReturnInput){
        let tCPHBchInputReturnCode  = poCPHBchReturnInput.tReturnInputCode;
        let tCPHBchInputReturnName  = poCPHBchReturnInput.tReturnInputName;
        let oCPHBchOptionReturn     = {
            Title : ['company/branch/branch','tBCHTitle'],
            Table : {Master:'TCNMBranch',PK:'FTBchCode'},
            Join :{
                Table : ['TCNMBranch_L'],
                On : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
            },
            GrideView:{
                ColumnPathLang      : 'company/branch/branch',
                ColumnKeyLang       : ['tBCHCode','tBCHName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                DataColumnsFormat   : ['',''],
                Perpage             : 20,
                OrderBy             : ['TCNMBranch.FTBchCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tCPHBchInputReturnCode,"TCNMBranch.FTBchCode"],
                Text		: [tCPHBchInputReturnName,"TCNMBranch_L.FTBchName"],
            },
        }
        return oCPHBchOptionReturn;
    };

    // Event Browse Branch From
    $('#obtCPHAdvSearchBrowseBchFrom').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oCPHBrowseBranchFromOption   = undefined;
            oCPHBrowseBranchFromOption          = oCPHBrowseBranch({
                'tReturnInputCode'  : 'oetCPHAdvSearchBchCodeFrom',
                'tReturnInputName'  : 'oetCPHAdvSearchBchNameFrom'
            });
            JCNxBrowseData('oCPHBrowseBranchFromOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Branch To
    $('#obtCPHAdvSearchBrowseBchTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oCPHBrowseBranchToOption = undefined;
            oCPHBrowseBranchToOption        = oCPHBrowseBranch({
                'tReturnInputCode'  : 'oetCPHAdvSearchBchCodeTo',
                'tReturnInputName'  : 'oetCPHAdvSearchBchNameTo'
            });
            JCNxBrowseData('oCPHBrowseBranchToOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    $('#obtCPHSearchReset').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCPHClearAdvSearchData();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Functionality: ฟังก์ชั่นล้างค่า Input Advance Search
    // Parameters: Button Event Click
    // Creator: 23/12/2019 Wasin(Yoshi)
    // Last Update -
    // Return: Clear Value In Input Advance Search
    // ReturnType: -
    function JSxCPHClearAdvSearchData(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            $('#ofmCPHFromSerchAdv').find('input').val('');
            $('#ofmCPHFromSerchAdv').find('select').val(0).selectpicker("refresh");
            $('#ocmUsedStatus').val(0).selectpicker('refresh');
            $('#oetRDHSearchAllDocument').val('');
            JSvCPHCallPageDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // ====================================================  From Search Data Page Purchase Invioce ====================================================
    $('#oetCPHSearchAllDocument').keyup(function(event){
        var nCodeKey    = event.which;
        if(nCodeKey == 13){
            event.preventDefault();
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSvCPHCallPageDataTable();
            }else{
                JCNxShowMsgSessionExpired();
            }
        }
    });

    $('#obtCPHSerchAllDocument').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            JSvCPHCallPageDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    $("#obtCPHAdvSearchSubmitForm").unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            JSvCPHCallPageDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
</script>