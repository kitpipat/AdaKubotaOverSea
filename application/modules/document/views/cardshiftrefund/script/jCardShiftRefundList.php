<script type="text/javascript">
$(document).ready(function() {
        
    $('body').on('focus',".xCNDatePicker", function(){
        $(this).datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            // startDate: new Date(),
            // startDate: '-3d',
            orientation: "bottom"
        });
    });

    $('.selectpicker').selectpicker();

    // Advance search display control
    $('#oahCardShiftRefundAdvanceSearch').on('click', function() {
        if($('#odvCardShiftRefundAdvanceSearchContainer').hasClass('hidden')){
            JSxCMNVisibleComponent('#odvCardShiftRefundAdvanceSearchContainer', true, 'slideUD');
        }else{
            JSxCMNVisibleComponent('#odvCardShiftRefundAdvanceSearchContainer', false, 'slideUD');
        }
    });
    
});

/**
* Functionality : Clear search data
* Parameters : -
* Creator : 12/12/2018 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxCardShiftRefundClearSearchData(){
    try{
        $('#oetSearchAll').val("");
        $('#oetCardShiftRefundSearchDocDateFrom').val("");
        $('#oetCardShiftRefundSearchDocDateTo').val("");
        $('#oetCardShiftRefundSearchCardQtyTo').val("");
        $(".selectpicker").val('0').selectpicker("refresh");
        JSvCardShiftRefundCardShiftRefundDataTable();
    }catch(err){
        console.log("JSxCardShiftRefundClearSearchData Error: ", err);
    }
}

/**
* Functionality : Get search data
* Parameters : -
* Creator : 12/12/2018 piya
* Last Modified : -
* Return : Search data
* Return Type : Object
*/
function JSoCardShiftRefundGetSearchData(){
    try{
        var oAdvanceSearchData  = {
            tSearchAll : $('#oetSearchAll').val(),
            tSearchDocDateFrom : $('#oetCardShiftRefundSearchDocDateFrom').val(),
            tSearchDocDateTo : $('#oetCardShiftRefundSearchDocDateTo').val(),
            tSearchStaDoc : $('#ocmCardShiftRefundStaDoc').val(),
            tSearchStaApprove : $('#ocmCardShiftRefundStaApprove').val()
        };
        return oAdvanceSearchData;
    }catch(err){
        console.log("JSoCardShiftRefundGetSearchData Error: ", err);
    }
}
</script>

