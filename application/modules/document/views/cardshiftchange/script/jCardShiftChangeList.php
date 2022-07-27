<script type="text/javascript">
$(document).ready(function() {
        
    $('body').on('focus', ".xCNDatePicker", function(){
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
    $('#oahCardShiftChangeAdvanceSearch').on('click', function() {
        if($('#odvCardShiftChangeAdvanceSearchContainer').hasClass('hidden')){
            JSxCMNVisibleComponent('#odvCardShiftChangeAdvanceSearchContainer', true, 'slideUD');
        }else{
            JSxCMNVisibleComponent('#odvCardShiftChangeAdvanceSearchContainer', false, 'slideUD');
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
function JSxCardShiftChangeClearSearchData(){
    try{
        $('#oetSearchAll').val("");
        $('#oetCardShiftChangeSearchDocDateFrom').val("");
        $('#oetCardShiftChangeSearchDocDateTo').val("");
        $('#oetCardShiftChangeSearchCardQtyTo').val("");
        $(".selectpicker").val('0').selectpicker("refresh");
        JSvCardShiftChangeCardShiftChangeDataTable();
    }catch(err){
        console.log("JSxCardShiftChangeClearSearchData Error: ", err);
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
function JSoCardShiftChangeGetSearchData(){
    try{
        let oAdvanceSearchData = {
            tSearchAll : $('#oetSearchAll').val(),
            tSearchDocDateFrom : $('#oetCardShiftChangeSearchDocDateFrom').val(),
            tSearchDocDateTo : $('#oetCardShiftChangeSearchDocDateTo').val(),
            tSearchStaDoc : $('#ocmCardShiftChangeStaDoc').val(),
            tSearchStaApprove : $('#ocmCardShiftChangeStaApprove').val()
        };
        return oAdvanceSearchData;
    }catch(err){
        console.log("JSoCardShiftChangeGetSearchData Error: ", err);
    }
}
</script>

