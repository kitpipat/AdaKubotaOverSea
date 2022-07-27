<script>


$("document").ready(function(){
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose();
        // Event Click Navigater Title (คลิก Title ของเอกสาร)
        $('#oliSMTSALTitle').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                // $('#oetSMTSALDateDataTo').val($(this).attr('datenow'));
                JSvDRGMain();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        JCNxOpenLoading();
        JSvDRGMain();
  

    

});


// Function: Call Main Page DashBoard
// Parameters: Document Ready Or Parameter Event
// Creator: 14/01/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JSvDRGMain(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "logDRGMainPage",
        cache: false,
        data: {
            // 'ptDateDataForm'    : tDateDataForm,
            // 'ptDateDataTo'      : tDateDataTo
        },
        timeout: 0,
        success: function (tResult){
            $("#odvSMTRePairRunningBill").html(tResult);
            $('.tab-pane').removeClass('active');
            $('.tab-pane').removeClass('in');
            $('#odvSMTRePairRunningBill').addClass('active');
            $('#odvSMTRePairRunningBill').addClass('in');
       //     JCNxSMTCallSaleDataTable();
            // JCNxSMTCallApiDataTable();
    
            // JCNxCloseLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}




// Function: Confirm Filter DashBoard
// Parameters: Document Ready Or Parameter Event
// Creator: 06/02/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JCNxDRGDataTable(nPageCurrent){
    const tDateDataForm   = $('#oetSMTSALDateDataForm').val();
    const tDateDataTo   = $('#oetSMTSALDateDataTo').val();
    const tDSHSALSort   = $('#oetDSHSALSort').val();
    const tDSHSALFild   = $('#oetDSHSALFild').val();
    const tATLDocStaPrcStk   = $('#ocmATLDocStaPrcStk').val();
    var tAllBillNotPrcStock = '';
    if($('#ocbAllBillNotPrcStock').prop('checked')==true){
     tAllBillNotPrcStock   = 'all';
    }else{
     tAllBillNotPrcStock   = 'no';
    }
    if(nPageCurrent=='' || nPageCurrent == undefined || nPageCurrent == 'NaN' ){
        nPageCurrent = 1;
    }
    $.ajax({
        type: "POST",
        url: "logDRGDataTable",
        data: $('#ofmDRGFrm').serialize()+"&nPageCurrent="+nPageCurrent,
        cache: false,
        timeout: 0,
        success : function(paDataReturn){
           
            $('#odvPanelDRGData').html(paDataReturn);
          var tSesUsrBchCode =  $('#odhSesUsrBchCode').val();
            // JSxSMTControlTableData();
            // JSxSMTCallMQRequestSaleData(tSesUsrBchCode,'','',10);
            JCNxCloseLoading();
        },
        error : function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR,textStatus,errorThrown);
        }
    });
}






    //Functionality : เปลี่ยนหน้า pagenation
    //Parameters : Event Click Pagenation
    //Creator : 06/10/2020 Worakorn
    //Return : View
    //Return Type : View
    function JSvDRGClickPage(ptPage) {
        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPageDRG .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWPageDRG .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }

        const ptFSort = '';
        JCNxDRGDataTable(nPageCurrent);
    }



// Function: Call Main Page DashBoard
// Parameters: Document Ready Or Parameter Event
// Creator: 14/01/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JSvATLRePairRunningBillMain(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "toolRePairRunningBillMainPage",
        cache: false,
        data: {
            // 'ptDateDataForm'    : tDateDataForm,
            // 'ptDateDataTo'      : tDateDataTo
        },
        timeout: 0,
        success: function (tResult){
            $("#odvSMTRePairRunningBill").html(tResult);
            $('.tab-pane').removeClass('active');
            $('.tab-pane').removeClass('in');
            $('#odvSMTRePairRunningBill').addClass('active');
            $('#odvSMTRePairRunningBill').addClass('in');
       //     JCNxSMTCallSaleDataTable();
            // JCNxSMTCallApiDataTable();
    
            // JCNxCloseLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}




// Function: Confirm Filter DashBoard
// Parameters: Document Ready Or Parameter Event
// Creator: 06/02/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JCNxATLRePairRunningBillDataTable(nPageCurrent){
    const tDateDataForm   = $('#oetSMTSALDateDataForm').val();
    const tDateDataTo   = $('#oetSMTSALDateDataTo').val();
    const tDSHSALSort   = $('#oetDSHSALSort').val();
    const tDSHSALFild   = $('#oetDSHSALFild').val();
    const tATLDocStaPrcStk   = $('#ocmATLDocStaPrcStk').val();
    var tAllBillNotPrcStock = '';
    if($('#ocbAllBillNotPrcStock').prop('checked')==true){
     tAllBillNotPrcStock   = 'all';
    }else{
     tAllBillNotPrcStock   = 'no';
    }
    if(nPageCurrent=='' || nPageCurrent == undefined || nPageCurrent == 'NaN' ){
        nPageCurrent = 1;
    }
    $.ajax({
        type: "POST",
        url: "toolRePairRunningBillDataTable",
        data: $('#ofmRepirRunningFrm').serialize()+"&nPageCurrent="+nPageCurrent,
        cache: false,
        timeout: 0,
        success : function(paDataReturn){
           
            $('#odvPanelRepairRunningDataTable').html(paDataReturn);
          var tSesUsrBchCode =  $('#odhSesUsrBchCode').val();
            // JSxSMTControlTableData();
            // JSxSMTCallMQRequestSaleData(tSesUsrBchCode,'','',10);
            JCNxCloseLoading();
        },
        error : function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR,textStatus,errorThrown);
        }
    });
}






    //Functionality : เปลี่ยนหน้า pagenation
    //Parameters : Event Click Pagenation
    //Creator : 06/10/2020 Worakorn
    //Return : View
    //Return Type : View
    function JSvATLRePairRunningBillClickPage(ptPage) {
        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPageTotalByBranchRunning .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWPageTotalByBranchRunning .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }

        const ptFSort = '';
        JCNxATLRePairRunningBillDataTable(nPageCurrent);
    }



</script>