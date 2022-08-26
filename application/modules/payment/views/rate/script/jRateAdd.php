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
    });
    $('#oetRteCode').blur(function(){
        JSxCheckRateCodeDupInDB();
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
                    tCode: $("#oetRteCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateRteCode").val(aResult["rtCode"]);  
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateRteCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddRate').validate({
                    rules: {
                        oetAgnCode : {
                            "required" :{
                                // ตรวจสอบเงื่อนไข validate
                                depends: function(oElement) {
                                if($('#ocbRateAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                                }
                            },
                            "dublicateCode" :{}
                        },
                        oetAgnName:     {"required" :{}},
                        oetAgnEmail:     {"required" :{}},
                    },
                    messages: {
                        oetAgnCode : {
                            "required"      : $('#oetAgnCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetAgnCode').attr('data-validate-dublicateCode')
                        },
                        oetAgnName : {
                            "required"      : $('#oetAgnName').attr('data-validate-required'),
                        },
                        oetAgnEmail : {
                            "required"      : $('#oetAgnEmail').attr('data-validate-required'),
                        },
                    },
                    errorElement: "em",
                    errorPlacement: function (error, element ) {
                        error.addClass( "help-block" );
                        if ( element.prop( "type" ) === "checkbox" ) {
                            error.appendTo( element.parent( "label" ) );
                        } else {
                            var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                            if(tCheck == 0){
                                error.appendTo(element.closest('.form-group')).trigger('change');
                            }
                        }
                    },
                    highlight: function ( element, errorClass, validClass ) {
                        $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                    },
                    submitHandler: function(form){}
                });

                // Submit From
                $('#ofmAddRate').submit();

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
    if($('#oetRteAgnCode').val() || $('#oetRteAgnName').val()){
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
    Title: ['payment/rate/rate','tRTETBRate'],
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
        Value: ["oetRteAgnCode", "TCNMAgency.FTAgnCode"],
        Text: ["oetRteAgnName", "TCNMAgency_L.FTAgnName"]
    },
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