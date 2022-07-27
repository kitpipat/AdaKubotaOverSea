<script type="text/javascript">
$(document).ready(function(){
        
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
    $('#oahCardShiftOutAdvanceSearch').on('click', function(){
        if($('#odvCardShiftOutAdvanceSearchContainer').hasClass('hidden')){
            JSxCMNVisibleComponent('#odvCardShiftOutAdvanceSearchContainer', true, 'slideUD');
        }else{
            JSxCMNVisibleComponent('#odvCardShiftOutAdvanceSearchContainer', false, 'slideUD');
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
function JSxCardShiftOutClearSearchData(){
    try{
        $('#oetSearchAll').val("");
        $('#oetCardShiftOutSearchDocDateFrom').val("");
        $('#oetCardShiftOutSearchDocDateTo').val("");
        $('#oetCardShiftOutSearchCardQtyTo').val("");
        $(".selectpicker").val('0').selectpicker("refresh");
        JSvCardShiftOutCardShiftOutDataTable();
    }catch(err){
        console.log("JSxCardShiftOutClearSearchData Error: ", err);
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
function JSoCardShiftOutGetSearchData(){
    try{
        var oAdvanceSearchData = {
            tSearchAll : $('#oetSearchAll').val(),
            tSearchDocDateFrom : $('#oetCardShiftOutSearchDocDateFrom').val(),
            tSearchDocDateTo : $('#oetCardShiftOutSearchDocDateTo').val(),
            tSearchStaDoc : $('#ocmCardShiftOutStaDoc').val(),
            tSearchStaApprove : $('#ocmCardShiftOutStaApprove').val()
        };
        return oAdvanceSearchData;
    }catch(err){
        console.log("JSoCardShiftOutGetSearchData Error: ", err);
    }
}
</script>

