

$("document").ready(function(){
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose();
        // Event Click Navigater Title (คลิก Title ของเอกสาร)
        $('#oliSMTSALTitle').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                // $('#oetSMTSALDateDataTo').val($(this).attr('datenow'));
                JSvSMTSALPageDashBoardMain();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        JCNxOpenLoading();
        JSvSMTSALPageDashBoardMain();
  

    

});



// Function: Call Main Page DashBoard
// Parameters: Document Ready Or Parameter Event
// Creator: 14/01/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JSvSMTSALPageDashBoardMain(){
    JCNxOpenLoading();
    const tDateDataForm = $('#oetSMTSALDateDataForm').val();
    const tDateDataTo   = $('#oetSMTSALDateDataTo').val();
    $.ajax({
        type: "POST",
        url: "toolMainPage",
        cache: false,
        data: {
            // 'ptDateDataForm'    : tDateDataForm,
            // 'ptDateDataTo'      : tDateDataTo
        },
        timeout: 0,
        success: function (tResult){
            $("#odvSMTSALContentPage").html(tResult);
       //     JCNxSMTCallSaleDataTable();
            // JCNxSMTCallApiDataTable();
    
            // JCNxCloseLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}



// Function: Call Modal Option Modal Filter
// Parameters: Document Ready Or Parameter Event
// Creator: 31/01/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JSvSMTSALCallModalFilterDashBoard(ptFilterDataKey,ptFilterDataGrp){

   var tSMTSALFilterBchCode = $('#oetSMTSALFilterBchCode').val();
   var tSMTSALFilterBchStaAll = $('#oetSMTSALFilterBchStaAll').val();
   var tSMTSALFilterBchName = $('#oetSMTSALFilterBchName').val();

   var tSMTSALFilterShpStaAll = $('#oetSMTSALFilterShpStaAll').val();
   var tSMTSALFilterShpCode = $('#oetSMTSALFilterShpCode').val();
   var tSMTSALFilterShpName = $('#oetSMTSALFilterShpName').val();

   var oetSMTSALFilterPosStaAll = $('#oetSMTSALFilterPosStaAll').val();
   var oetSMTSALFilterPosCode = $('#oetSMTSALFilterPosCode').val();
   var oetSMTSALFilterPosName = $('#oetSMTSALFilterPosName').val();

    $.ajax({
        type: "POST",
        url: "toolCallModalFilter",
        data: {
            'ptFilterDataKey'   : ptFilterDataKey,
            'ptFilterDataGrp'   : ptFilterDataGrp,
        },
        cache: false,
        timeout: 0,
        success : function(ptViewModalHtml){
            $('#odvSMTSALModalFilterHTML').html(ptViewModalHtml);
            $('#odvSMTSALModalFilter').modal({backdrop: 'static', keyboard: false})  
            $('#odvSMTSALModalFilter').modal('show');

            $('#oetSMTSALFilterBchCode').val(tSMTSALFilterBchCode);
            $('#oetSMTSALFilterBchStaAll').val(tSMTSALFilterBchStaAll);
            $('#oetSMTSALFilterBchName').val(tSMTSALFilterBchName);
            
            $('#oetSMTSALFilterShpStaAll').val(tSMTSALFilterShpStaAll);
            $('#oetSMTSALFilterShpCode').val(tSMTSALFilterShpCode);
            $('#oetSMTSALFilterShpName').val(tSMTSALFilterShpName);

            $('#oetSMTSALFilterPosStaAll').val(oetSMTSALFilterPosStaAll);
            $('#oetSMTSALFilterPosCode').val(oetSMTSALFilterPosCode);
            $('#oetSMTSALFilterPosName').val(oetSMTSALFilterPosName);


            
        var tFilterBchCode = $('#ohdSMTSALSessionBchCode').val();
        var tFilterBchName = $('#ohdSMTSALSessionBchName').val();
        var nSesUsrBchCount = $('#odhnSesUsrBchCount').val();
        if(nSesUsrBchCount==1){
                $('#oetSMTSALFilterBchCode').val(tFilterBchCode);
                $('#oetSMTSALFilterBchName').val(tFilterBchName);
                $('#obtSMTSALFilterShp').attr('disabled',false);
                $('#obtSMTSALFilterPos').attr('disabled',false);
                $('#obtSMTSALFilterBch').attr('disabled',true);
            }else{
                $('#obtSMTSALFilterShp').attr('disabled',true);
                $('#obtSMTSALFilterPos').attr('disabled',true);
                $('#obtSMTSALFilterBch').attr('disabled',false);      
            
        }


        },
        error : function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR,textStatus,errorThrown);
        }
    });
}

// Function: Confirm Filter DashBoard
// Parameters: Document Ready Or Parameter Event
// Creator: 06/02/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JCNxSMTSALConfirmFilter(ptFilterKey){
    const tDateDataTo   = $('#oetSMTSALDateDataTo').val();
    JCNxOpenLoading();
    if($('#ohdSMTSALFilterKey').val()=='FSD'){
        JCNxSMTCallSaleDataTable();
    }else{
        JCNxSMTCallApiDataTable();
    }
    $('#odvSMTSALModalFilter').modal('hide');
}




// Function: Confirm Filter DashBoard
// Parameters: Document Ready Or Parameter Event
// Creator: 06/02/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JCNxSMTCallSaleDataTable(nPageCurrent){
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
        url: "toolCallSaleDataTable",
        data: $('#odvSMTSALModalFilter #ofmSMTSALFormFilter').serialize()+"&oetSMTSALDateDataForm="+tDateDataForm+"&oetSMTSALDateDataTo="+tDateDataTo+"&ocbAllBillNotPrcStock="+tAllBillNotPrcStock+"&ocmATLDocStaPrcStk="+tATLDocStaPrcStk+"&oetDSHSALSort="+tDSHSALSort+"&oetDSHSALFild="+tDSHSALFild+"&nPageCurrent="+nPageCurrent,
        cache: false,
        timeout: 0,
        success : function(paDataReturn){
           
            $('#odvPanelSaleData').html(paDataReturn);
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
    function JSvToolClickPage(ptPage) {
        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPageTotalByBranch .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWPageTotalByBranch .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }

        const ptFSort = '';
        JCNxSMTCallSaleDataTable(nPageCurrent);
    }




