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
    $('#oahCardShiftStatusAdvanceSearch').on('click', function() {
        if($('#odvCardShiftStatusAdvanceSearchContainer').hasClass('hidden')){
            JSxCMNVisibleComponent('#odvCardShiftStatusAdvanceSearchContainer', true, 'slideUD');
        }else{
            JSxCMNVisibleComponent('#odvCardShiftStatusAdvanceSearchContainer', false, 'slideUD');
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
function JSxCardShiftStatusClearSearchData(){
    try{
        $('#oetSearchAll').val("");
        $('#oetCardShiftStatusSearchDocDateFrom').val("");
        $('#oetCardShiftStatusSearchDocDateTo').val("");
        $('#oetCardShiftStatusSearchCardQtyTo').val("");
        $(".selectpicker").val('0').selectpicker("refresh");
        JSvCardShiftStatusCardShiftStatusDataTable();
    }catch(err){
        console.log("JSxCardShiftStatusClearSearchData Error: ", err);
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
function JSoCardShiftStatusGetSearchData(){
    try{
        let oAdvanceSearchData = {
            tSearchAll : $('#oetSearchAll').val(),
            tSearchDocDateFrom : $('#oetCardShiftStatusSearchDocDateFrom').val(),
            tSearchDocDateTo : $('#oetCardShiftStatusSearchDocDateTo').val(),
            tSearchStaDoc : $('#ocmCardShiftStatusStaDoc').val(),
            tSearchStaApprove : $('#ocmCardShiftStatusStaApprove').val()
        };
        return oAdvanceSearchData;
    }catch(err){
        console.log("JSoCardShiftStatusGetSearchData Error: ", err);
    }
}
</script>

