<script type="text/javascript">
    //Set Lang Edit 
    var nLangEdits = <?php echo $this->session->userdata("tLangEdit")?>;

    $('.selectpicker').selectpicker();

    //ส่วนสูงของ div ที่แสดงข้อมูล
    $nWinHeight =   $(window).height();
    // $("#oetWahCode").attr("readonly", true);

    $(document).ready(function(){
        $("#oetWahCode").attr("readonly", true);
        if(JSbWahIsCreatePage()){
        $('#ocbWahAutoGenCode').change(function(){
            if($('#ocbWahAutoGenCode').is(':checked')) {
                $('#oetWahCode').val('');
                $("#oetWahCode").attr("readonly", true);
                $('#odvWahCodeForm').removeClass('has-error');
                $('#odvWahCodeForm em').remove();
            }else{
                $("#oetWahCode").attr("readonly", false);
            }
        });
        JSxWahVisibleComponent('#ocbWahAutoGenCode', true);
    }
    
    if(JSbWahIsUpdatePage()){
        $("#oetWahCode").attr("readonly", true);
        $('#odvWahAutoGenCode input').attr('disabled', true);
        JSxWahVisibleComponent('#odvWahAutoGenCode', false);    
        }
    });


    $('#oetWahCode').blur(function(){
        JSxCheckWarehouseCodeDupInDB();
    });
        

    //Functionality: Event Check Warehouse Duplicate
    //Parameters: Event Blur Input Warehouse Code
    //Creator: 26/03/2019 wasin (Yoshi)
    //Return: 14/08/2019 Sahatat(Golf)
    //ReturnType: - 
    function JSxCheckWarehouseCodeDupInDB(){
        if(!$('#ocbWahAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMWaHouse",
                    tFieldName: "FTWahCode",
                    tCode: $("#oetWahCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateWahCode").val(aResult["rtCode"]);  
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateWahCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddWarehouse').validate({
                    rules: {
                        oetWahCode : {
                            "required" :{
                                // ตรวจสอบเงื่อนไข validate
                                depends: function(oElement) {
                                if($('#ocbWahAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                                }
                            },
                            "dublicateCode" :{}
                        },
                        oetWahName:     {"required" :{}},
                        oetWAHBchName:     {"required" :{}},
                    },
                    messages: {
                        oetWahCode : {
                            "required"      : $('#oetWahCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetWahCode').attr('data-validate-dublicateCode')
                        },
                        oetWahName : {
                            "required"      : $('#oetWahName').attr('data-validate-required'),
                        },
                        oetWAHBchName : {
                            "required"      : $('#oetWAHBchName').attr('data-validate-required'),
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
                    submitHandler: function(form){
                        // Submit From
                        JSxHideObjWahouseType();
                        $('#ofmAddWarehouse').submit();

                    }
                });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }    
    }

    // $('#ocmWahStaType').change(function(){
    //     JSxHideObjWahouseType();
    // });

    function JSxHideObjWahouseType(){
        tValWahStaType = $('#ocmWahStaType').val();
        switch(tValWahStaType){
            // มาตรฐาน
            case '1':
                $('#odvWhaSaleperson').hide();
                $('#odvWhaSaleMCPos').hide();
                $('#odvWahBranch').hide();
                $('#odvWhaShop').hide();
                $('#odvRefCode').show();
                $('#oetWahRefCode').val(''); // ล้างค่าใน Input Textbox
            break;
            // คลังทั่วไป
            case '2':
                $('#odvWhaSaleperson').hide();
                $('#odvWhaSaleMCPos').hide();
                $('#odvWahBranch').hide();
                $('#odvWhaShop').hide();
                $('#odvRefCode').show();
                $('#oetWahRefCode').val(''); // ล้างค่าใน Input Textbox
            break;
            // คลังสาขา
            // case '3':
            // 	$('#odvWhaSaleperson').hide();
            // 	$('#odvWhaSaleMCPos').hide();
            // 	$('#odvWahBranch').show();
            // 	$('#odvWhaShop').hide();
            // 	$('#odvRefCode').hide();
            // break;
            // คลังฝากขาย/ร้านค้า
            case '4':
                $('#odvWhaSaleperson').hide();
                $('#odvWhaSaleMCPos').hide();
                $('#odvWahBranch').hide();
                $('#odvWhaShop').show();
                $('#odvRefCode').hide();
            break;
            // คลังหน่วยรถ
            case '5':
                $('#odvWhaSaleperson').show();
                $('#odvWhaSaleMCPos').hide();
                $('#odvWahBranch').hide();
                $('#odvWhaShop').hide();
                $('#odvRefCode').hide();
            break;
            // คลัง Vending
            case '6':
                $('#odvWhaSaleperson').hide();
                $('#odvWhaSaleMCPos').show();
                $('#odvWahBranch').hide();
                $('#odvWhaShop').hide();
                $('#odvRefCode').hide();
            break;
            default:
                $('#odvWhaSaleperson').hide();
                $('#odvWhaSaleMCPos').hide();
                $('#odvWahBranch').hide();
                $('#odvWhaShop').hide();
                $('#odvRefCode').hide();
        }
    }

    $('.xWTooltipsBT').tooltip({'placement': 'bottom'});
    $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});
 

    $('#ocmWahStaType').change(function() {
        $('#ocmWahStaType-error').hide();
    });

    //Option POS
    var oBrowsePOS = {
        Title : ['company/warehouse/warehouse','tSalemachinePOS'],
        Table:{Master:'TCNMPos',PK:'FTPosCode'},
        Join :{
            Table:	['TCNMPosLastNo'],
            On:['TCNMPosLastNo.FTPosCode = TCNMPos.FTPosCode']
        },
        Where :{
            Condition : ["AND TCNMPos.FTPosType = '1' "]
        },
        GrideView:{
            ColumnPathLang	: 'pos/salemachine/salemachine',
            ColumnKeyLang	: ['tPOSCode','tPOSName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMPos.FTPosCode','TCNMPosLastNo.FTPosComName'],
            DataColumnsFormat : ['',''],
            Perpage			: 5,
            OrderBy			: ['TCNMPos.FTPosCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetWahPosCode","TCNMPos.FTPosCode"],
            Text		: ["oetWahPosName","TCNMPosLastNo.FTPosComName"],
        },
        RouteAddNew : 'salemachine',
        BrowseLev : nStaWahBrowseType
    } 


    // Option Branch
    var oBrowseBch = {
        
        Title : ['company/branch/branch','tBCHTitle'],
        Table:{Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
        Join :{
            Table:	['TCNMBranch_L'],
            On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'company/branch/branch',
            ColumnKeyLang	: ['tBCHCode','tBCHName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
            DataColumnsFormat : ['',''],
            // Perpage			: 5,
            // OrderBy			: ['TCNMBranch_L.FTBchName'],
            // SourceOrder		: "ASC"
            Perpage			: 10,
            OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetWAHBchCode","TCNMBranch.FTBchCode"],
            Text		: ["oetWAHBchName","TCNMBranch_L.FTBchName"],
        },
        // DebugSQL : true,
        RouteAddNew : 'branch',
        BrowseLev : nStaWahBrowseType

    }

    //OPtion Shop
    var oBrowseShop = {
        Title : ['authen/user/user','tBrowseSHPTitle'],
        Table:{Master:'TCNMShop',PK:'FTShpCode'},
        Join :{
            Table:	['TCNMShop_L'],
            On:['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits,]
        },
        Filter:{
            Selector:'oetBranchCode',
            Table:'TCNMShop',
            Key:'FTBchCode'
        },
        GrideView:{
            ColumnPathLang	: 'authen/user/user',
            ColumnKeyLang	: ['tBrowseSHPCode','tBrowseSHPName'],
            ColumnsSize     : ['10%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMShop.FTShpCode','TCNMShop_L.FTShpName'],
            DataColumnsFormat : ['',''],
            Perpage			: 5,
            OrderBy			: ['TCNMShop.FTShpCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            StaSingItem : '1',
            ReturnType	: 'S',
            Value		: ["oetWahRefCode","TCNMShop.FTShpCode"],
            Text		: ["oetWahRefName","TCNMShop_L.FTShpName"],
        },
        RouteAddNew : 'shop',
        BrowseLev : nStaWahBrowseType
    }


    //OPtion Shop
    var oBrowseSalePerson = {
        Title : ['company/warehouse/warehouse','tSalePerson'],
        Table:{Master:'TCNMSpn',PK:'FTSpnCode'},
        Join :{
            Table:	['TCNMSpn_L'],
            On:['TCNMSpn_L.FTSpnCode = TCNMSpn.FTSpnCode AND TCNMSpn_L.FNLngID = '+nLangEdits,]
        },
        Filter:{
            Selector:'oetSpnCode',
            Table:'TCNMSpn',
            Key:'FTSpnCode'
        },
        GrideView:{
            ColumnPathLang	: 'company/warehouse/warehouse',
            ColumnKeyLang	: ['tBrowseSHPCode','tBrowseSHPName'],
            ColumnsSize     : ['10%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMSpn.FTSpnCode','TCNMSpn_L.FTSpnName'],
            DataColumnsFormat : ['',''],
            Perpage			: 5,
            OrderBy			: ['TCNMSpn.FTSpnCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            StaSingItem : '1',
            ReturnType	: 'S',
            Value		: ["oetSpnCode","TCNMSpn.FTSpnCode"],
            Text		: ["oetSpnName","TCNMSpn_L.FTSpnName"],
        },
        RouteAddNew : 'saleperson',
        BrowseLev : nStaWahBrowseType
    }

    $('#oimBrowsePOS').click(function(){JCNxBrowseData('oBrowsePOS')});
    $('#oimShpBrowseBch').click(function(){JCNxBrowseData('oBrowseBch')});
    $('#oimBrowseShop').click(function(){JCNxBrowseData('oBrowseShop')});
    $('#oimBrowseSalePerson').click(function(){JCNxBrowseData('oBrowseSalePerson')});


    //Functionality: Set Validate Event Blur
    //Parameters: Validate Event Blur
    //Creator: 26/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxWahSetValidEventBlur(){
        $('#ofmAddWarehouse').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if($("#ohdCheckDuplicateWahCode").val() == 1){
                return false;
            }else{
                return true;
            }
        },'');

        // From Summit Validate
        $('#ofmAddWarehouse').validate({
            rules: {
                oetWahCode : {
                    "required" :{
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if($('#ocbWahAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode" :{}
                },
                oetWahName:     {"required" :{}},
                ocmWahStaType:  {"required" :{}},
            },
            messages: {
                oetWahCode : {
                    "required"      : $('#oetWahCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetWahCode').attr('data-validate-dublicateCode')
                },
                oetWahName : {
                    "required"      : $('#oetWahName').attr('data-validate-required'),
                },
                ocmWahStaType: {
                    "required"      : $('#ocmWahStaType').attr('data-validate-required'),
                }
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
            unhighlight: function(element, errorClass, validClass) {
                var nStaCheckValid  = $(element).parents('.form-group').find('.help-block').length
                if(nStaCheckValid != 0){
                    $(element).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                }
            },
            submitHandler: function(form){}
        });
    }



</script>