<script type="text/javascript">
    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';

    $(document).ready(function(){
        $('.selectpicker').selectpicker();

        // Set Select  Doc Date
        $('#obtASTDocDateForm').unbind().click(function(){
            event.preventDefault();
            $('#oetASTDocDateFrom').datepicker('show');
        });

        $('#obtASTDocDateTo').unbind().click(function(){
            event.preventDefault();
            $('#oetASTDocDateTo').datepicker('show');
        });
    });

    // Event Click On/Off Advance Search
    $('#oahTRNAdvanceSearch').unbind().click(function(){
        if($('#odvTRNAdvanceSearchContainer').hasClass('hidden')){
            $('#odvTRNAdvanceSearchContainer').removeClass('hidden').hide().slideDown(500);
        }else{
            $("#odvTRNAdvanceSearchContainer").slideUp(500,function() {
                $(this).addClass('hidden');
            });
        }
    });

    // ======================= Option Branch Advance Search =======================
        var oASTBrowseBch   = function(poReturnInput){
            var tInputReturnCode    = poReturnInput.tReturnInputCode;
            var tInputReturnName    = poReturnInput.tReturnInputName;
            var oOptionReturn       = {
                Title : ['company/branch/branch','tBCHTitle'],
                Table : {Master:'TCNMBranch',PK:'FTBchCode'},
                Join :{
                    Table : ['TCNMBranch_L'],
                    On : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
                },
                GrideView:{
                    ColumnPathLang : 'company/branch/branch',
                    ColumnKeyLang : ['tBCHCode','tBCHName'],
                    ColumnsSize : ['15%','75%'],
                    WidthModal : 50,
                    DataColumns : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                    DataColumnsFormat : ['',''],
                    Perpage : 10,
                    OrderBy : ['TCNMBranch.FDCreateOn DESC'],
                    // SourceOrder : "ASC"
                },
                CallBack:{
                ReturnType	: 'S',
                    Value		: [tInputReturnCode,"TCNMBranch.FTBchCode"],
                    Text		: [tInputReturnName,"TCNMBranch_L.FTBchName"],
                },
            }
            return oOptionReturn;
        }

        // Branch From
        $('#obtASTBrowseBchFrom').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oASTBrowseBchFromOption = oASTBrowseBch({
                    'tReturnInputCode'  : 'oetASTBchCodeFrom',
                    'tReturnInputName'  : 'oetASTBchNameFrom'
                });
                JCNxBrowseData('oASTBrowseBchFromOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Branch To
        $('#obtASTBrowseBchTo').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oASTBrowseBchToOption = oASTBrowseBch({
                    'tReturnInputCode'  : 'oetASTBchCodeTo',
                    'tReturnInputName'  : 'oetASTBchNameTo'
                });
                JCNxBrowseData('oASTBrowseBchToOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
    // ============================================================================

    $('#obtTWISubmitFrmSearchAdv').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvTRNCallPageTransferReceiptDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Functionality: ฟังก์ชั่นล้างค่า Input Advance Search
    // Parameters: Button Event Click
    // Creator: 06/06/2019 Wasin(Yoshi)
    // Last Update: -
    // Return: Clear Value In Input Advance Search
    // ReturnType: -
    function JSxTWIClearSearchData(){
       
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            $("#oetSearchAll").val("");
            $("#oetASTBchCodeFrom").val("");
            $("#oetASTBchNameFrom").val("");    //แก้ไขลบข้อมูลจากการค้นหา 9/01/2020
            $("#oetASTBchCodeTo").val("");
            $("#oetASTBchNameTo").val("");
            $("#oetASTDocDateFrom").val("");
            $("#oetASTDocDateTo").val("");
            $(".xCNDatePicker").datepicker("setDate", null);
            $(".selectpicker")
            .val("0")
            .selectpicker("refresh");
            JSvTRNCallPageTransferReceiptDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

</script>