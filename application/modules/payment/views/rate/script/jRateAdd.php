<script type="text/javascript">
 $(document).ready(function(){

    $('.selectpicker').selectpicker();
    if(JSbRateIsCreatePage()){
        //Rate Code
        $("#oetRteCode").attr("disabled", true);
        $('#ocbRateAutoGenCode').change(function(){
   
            if($('#ocbRateAutoGenCode').is(':checked')) {
                $('#oetRteCode').val('');
                $("#oetRteCode").attr("disabled", true);
                $('#odvRteCodeForm').removeClass('has-error');
                $('#odvRteCodeForm em').remove();
            }else{
                $("#oetRteCode").attr("disabled", false);
                $("#oetRteCode").focus();
            }
        });
        JSxRateVisibleComponent('#odvRteAutoGenCode', true);
    }
    
    if(JSbRateIsUpdatePage()){
  
        // Rate Code
        $("#oetRteCode").attr("readonly", true);
        $('#odvRteAutoGenCode input').attr('disabled', true);
        JSxRateVisibleComponent('#odvRteAutoGenCode', false);    

    }

    $('#oetRteCode').on(('keyup change'),function(){
        JSxCheckRateCodeDupInDB();
    });

    $('#oetRteRate').on(('keyup change'),function(){
        $('#oetRteRateDef').val($('#oetRteRate').val());
    });
    
    $('#oetRteFraction').on(('keyup change'),function(){
        $('#oetRteFractionDef').val($('#oetRteFraction').val());
    });

    $('#oetRteMaxChg').on(('keyup change'),function(){
        $('#oetRteMaxChgDef').val($('#oetRteMaxChg').val());
    });
    
});


    //Functionality : Event Check Agency
    //Parameters : Event Blur Input Agency Code
    //Creator : 25/03/2019 wasin (Yoshi)
    //Update : 30/05/2019 saharat (Golf)
    //Return : -
    //Return Type : -
    function JSxCheckRateCodeDupInDB(){
        if(!$('#ocbRateAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TFNMRate",
                    tFieldName: "FTRteCode",
                    tCode: $("#oetRteCode").val(),
                    tAgnCode: $("#ohdRteAgnCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateRteCode").val(aResult.rtCode);  
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }    
    }



    $('ducument').ready(function(){
    JSxShowButtonChoose();
	var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
	var nlength = $('#odvRGPList').children('tr').length;
	for($i=0; $i < nlength; $i++){
		var tDataCode = $('#otrRate'+$i).data('code')
		if(aArrayConvert == null || aArrayConvert == ''){
		}else{
			var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',tDataCode);
			if(aReturnRepeat == 'Dupilcate'){
				$('#ocbListItem'+$i).prop('checked', true);
			}else{ }
		}
	}

	$('.ocbListItem').click(function(){
        var nCode = $(this).parent().parent().parent().data('code');  //code
        var tName = $(this).parent().parent().parent().data('name');  //code
        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{ }
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"nCode": nCode, "tName": tName });
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxPaseCodeDelInModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxPaseCodeDelInModal();
            }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].nCode == nCode){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                JSxPaseCodeDelInModal();
            }
        }
        JSxShowButtonChoose();
    })

    var tSessAgn = '<?= $this->session->userdata("tSesUsrAgnCode") ?>';
    if($('#ohdRteAgnCode').val() || $('#oetRteAgnName').val()){
        if(!tSessAgn){
            $("#obtRtcBrowseAgn").attr("disabled", false);
        }else{
            $("#obtRtcBrowseAgn").attr("disabled", true);
        }
    }else{
        $("#obtRtcBrowseAgn").attr("disabled", false);

    }
});

 // ตัวแทนขาย
 $('#obtRtcBrowseAgn').click(function() {
    JSxCheckPinMenuClose();
    JCNxBrowseData('oBrowsetAgn');
});
    
var oBrowsetAgn = {
    Title: ['payment/rate/rate','tRTEAgency'],
    Table: {
        Master: 'TCNMAgency',
        PK: 'FTAgnCode'
    },
    Join: {
        Table: ['TCNMAgency_L'],
        On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode']
    },
    GrideView: {
        ColumnPathLang: 'payment/rate/rate',
        ColumnKeyLang: ['tBrowseAgnCode', 'tBrowseAgnName'],
        ColumnsSize: ['15%', '75%'],
        DataColumns: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
        DataColumnsFormat: ['', ''],
        WidthModal: 50,
        Perpage: 10,
        OrderBy: ['TCNMAgency.FTAgnCode ASC'],
    },
    CallBack: {
        ReturnType: 'S',
        Value: ["ohdRteAgnCode", "TCNMAgency.FTAgnCode"],
        Text: ["oetRteAgnName", "TCNMAgency_L.FTAgnName"]
    },
    NextFunc: {
        FuncName: 'JSxCheckRateCodeDupInDB',
        ArgReturn: []
    }
};

// ISO Currency
$('#obtRtcBrowseIso').click(function(){
    JSxCheckPinMenuClose();
    JCNxBrowseData('oBrowsetIso');
});

var oBrowsetIso = {
    Title: ['payment/rate/rate','tRteIsoName'],
    Table: {
        Master: 'TCNSRate_L',
        PK: 'FTRteIsoCode'
    },
    GrideView: {
        ColumnPathLang: 'payment/rate/rate',
        ColumnKeyLang: ['tBrowseIsoCode', 'tBrowseIsoName'],
        ColumnsSize: ['15%', '75%'],
        DataColumns: ['TCNSRate_L.FTRteIsoCode', 'TCNSRate_L.FTRteIsoName'],
        DataColumnsFormat: ['', ''],
        WidthModal: 50,
        Perpage: 10,
        OrderBy: ['TCNSRate_L.FTRteIsoCode ASC'],
    },
    CallBack: {
        ReturnType: 'S',
        Value: ["oetRteIsoCode", "TCNSRate_L.FTRteIsoCode"],
        Text: ["oetRteIsoName", "TCNSRate_L.FTRteIsoName"]
    },
    // DebugSQL: true,
};
</script>