<script type="text/javascript">

$(document).ready(function(){
    $('.selectpicker').selectpicker();

    $('#obtXphDocDateFrom').click(function(){
        event.preventDefault();
        $('#oetXphDocDateFrom').datepicker('show');
    });

    $('#obtXphDocDateTo').click(function(){
        event.preventDefault();
        $('#oetXphDocDateTo').datepicker('show');
    });

    $('.xCNDatePicker').datepicker({
    format: 'yyyy-mm-dd',
    todayHighlight: true
    });

    $(".selection-2").select2({
        // minimumResultsForSearch: 20,
        dropdownParent: $('#dropDownSelect1')
    });

    /*FSvGetSelectShpByBch('');

    $('#ostBchCode').change(function(){
        tBchCode = $(this).val();
        FSvGetSelectShpByBch(tBchCode);
    });*/
});

// Advance search display control
$('#oahAdjStkSubAdvanceSearch').on('click', function() {
    if($('#odvAdjStkSubAdvanceSearchContainer').hasClass('hidden')){
        $('#odvAdjStkSubAdvanceSearchContainer').removeClass('hidden fadeIn').addClass('fadeIn');
    }else{
        $('#odvAdjStkSubAdvanceSearchContainer').addClass('hidden fadeIn');
    }
});

// Option Branch From
var oPmhBrowseBchFrom = {
    Title: ['company/branch/branch', 'tBCHTitle'],
    Table: {Master:'TCNMBranch', PK:'FTBchCode'},
    Join: {
        Table: ['TCNMBranch_L'],
        On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
    },
    GrideView: {
        ColumnPathLang: 'company/branch/branch',
        ColumnKeyLang: ['tBCHCode', 'tBCHName'],
        ColumnsSize: ['15%', '75%'],
    WidthModal: 50,
        DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
        DataColumnsFormat: ['', ''],
        Perpage: 5,
        OrderBy: ['TCNMBranch_L.FTBchName'],
        SourceOrder: "ASC"
    },
    CallBack: {
        ReturnType: 'S',
        Value: ["oetBchCodeFrom", "TCNMBranch.FTBchCode"],
        Text: ["oetBchNameFrom", "TCNMBranch_L.FTBchName"]
    }
};
// Option Branch From

// Option Branch To
var oPmhBrowseBchTo = {
    Title: ['company/branch/branch', 'tBCHTitle'],
    Table: {Master:'TCNMBranch', PK:'FTBchCode'},
    Join: {
        Table: ['TCNMBranch_L'],
        On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
    },
    GrideView: {
        ColumnPathLang: 'company/branch/branch',
        ColumnKeyLang: ['tBCHCode', 'tBCHName'],
        ColumnsSize: ['15%', '75%'],
    WidthModal: 50,
        DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
        DataColumnsFormat: ['', ''],
        Perpage: 5,
        OrderBy: ['TCNMBranch_L.FTBchName'],
        SourceOrder: "ASC"
    },
    CallBack:{
        ReturnType: 'S',
        Value: ["oetBchCodeTo", "TCNMBranch.FTBchCode"],
        Text: ["oetBchNameTo", "TCNMBranch_L.FTBchName"]
    }
};
// Option Branch To

// Event Browse
$('#obtAdjStkSubBrowseBchFrom').click(function(){ JCNxBrowseData('oPmhBrowseBchFrom'); });
$('#obtAdjStkSubBrowseBchTo').click(function(){ JCNxBrowseData('oPmhBrowseBchTo'); });
</script>





