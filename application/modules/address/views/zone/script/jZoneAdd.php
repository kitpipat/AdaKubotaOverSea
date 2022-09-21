<script>
    var tUsrLevel = "<?= $this->session->userdata('tSesUsrLevel') ?>";
    var tBchCode = "<?= $this->session->userdata('tSesUsrBchCodeMulti') ?>";
    var tAgnName = "<?= $this->session->userdata('tSesUsrAgnName') ?>";

    $(document).ready(function(){
        var tAgnCode = "<?= $this->session->userdata('tSesUsrAgnCode') ?>";

        if(tAgnCode && !$('#oetZneCode').val()){
            $('#oetZneAgnCodeFirst').val(tAgnCode);
            $('#oetZneAgnNameFirst').val(tAgnName);
            $("#obtBrowseAgencyFirst").attr("disabled", true); 
        }

        if( tUsrLevel != 'HQ' && $('#oetZneCode').val() ){
            $("#obtBrowseAgencyFirst").attr("disabled", true); 
            $('#oetZneAgnCodeSecond').val(tAgnCode);
            $('#oetZneAgnNameSecond').val(tAgnName);
            $("#obtBrowseAgencySecond").attr("disabled", true); 
        }

        if($('#oetZneCode').val()){
            $("#ocbSelectRoot").attr("disabled", true); 
        }

        if($('#oetZneParent').val() != ''){
            $("#ocbSelectRoot").attr("checked", false); 
        }else{
            $('.xWPanalZneChain').hide();
            $("#ocbSelectRoot").attr("checked", true); 
        }   

        $('#ocbSelectRoot').click(function(){
            if($(this).is(':checked')){
                //Check 
                $('#oetZneParent').val('');
                $('#oetZneParentName').val('');
                $('.xWPanalZneChain').hide();
            } else {
                $('.xWPanalZneChain').show();
                
            }
        });

        JSxHideObjZoneType();
        $('.selectpicker').selectpicker();	


        if(JSbZoneIsCreatePage()){
        //Zone Code
        $("#oetZneCode").attr("disabled", true);

        $('#ocbZoneAutoGenCode').change(function(){
   
            if($('#ocbZoneAutoGenCode').is(':checked')) {
                $('#oetZneCode').val('');
                $("#oetZneCode").attr("disabled", true);
                $('#odvZneCodeForm').removeClass('has-error');
                $('#odvZneCodeForm em').remove();
            }else{
                $("#oetZneCode").attr("disabled", false);
            }
        });
        JSxAgencyVisibleComponent('#odvZneAutoGenCode', true);
    }
    
    

    $('.xWIMGZoneReferEdit').off('click');
    $('.xWIMGZoneReferEdit').on('click',function(){
        var tZneCode = $(this).parent().parent().data('znecode');
        JSxZoneSetCallPageEdit(tPdtCode);
    });

    $('#obtZneSetAdd').off('click');
    $('#obtZneSetAdd').on('click', function() {
        JSxZoneSetCallPageAdd();
    });

    $('#obtZneSetBack').off('click');
    $('#obtZneSetBack').on('click', function() {
        JSvZoneObjDataTable();
    });

    $('#olbZneSetInfo').off('click');
    $('#olbZneSetInfo').on('click', function() {
        JSvZoneObjDataTable();
    });

    if(JSbZoneIsUpdatePage()){
        // Zone Code
        $("#oetZneCode").attr("readonly", true);
        $('#odvZneAutoGenCode input').attr('disabled', true);
        JSxAgencyVisibleComponent('#odvZneAutoGenCode', false);    

        }
    });

    $('#oetZneCode').blur(function(){
        JSxCheckZoneCodeDupInDB();
    });

 //Functionality : Event Check Zone
    //Parameters : Event Blur Input Zone Code
    //Creator : 25/03/2019 wasin (Yoshi)
    //Update : 30/05/2019 saharat (Golf)
    //Return : -
    //Return Type : -
    function JSxCheckZoneCodeDupInDB(){
        if(!$('#ocbZoneAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMZone",
                    tFieldName: "FTZneCode",
                    tCode: $("#oetZneCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateZneCode").val(aResult["rtCode"]);  
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateZneCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddZone').validate({
                    rules: {
                        oetZneCode : {
                            "required" :{
                                // ตรวจสอบเงื่อนไข validate
                                depends: function(oElement) {
                                if($('#ocbZoneAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                                }
                            },
                            "dublicateCode" :{}
                        },
                        oetZneName:     {"required" :{}},

                    },
                    messages: {
                        oetZneCode : {
                            "required"      : $('#oetZneCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetZneCode').attr('data-validate-dublicateCode')
                        },
                        oetZneName : {
                            "required"      : $('#oetZneName').attr('data-validate-required'),
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
                $('#ofmAddZone').submit();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }    
    }


    //Set Lang Edit 
    var nLangEdits = <?php echo $this->session->userdata("tLangEdit")?>;

    $('#ocmTypeRefer').change(function(){
        JSxHideObjZoneType();
    });

    function JSxHideObjZoneType(){
              tZneRefer = $('#ocmTypeRefer').val();
        
        switch(tZneRefer){
            case 'TCNMBranch':
                $('#odvZneBranch').show();
                $('#odvZneUSer').hide();
                $('#odvZneSaleMan').hide();
                $('#odvZneShop').hide();
                $('#odvZnePos').hide();
                $('#odvZneCountry').hide();
                $('#odvZneAgency').hide();
                $('#odvZneMerchant').hide();

                // $('#oetZneBchCode').val('');
                // $('#oetZneBchName').val('');
                $('#oetZneUSerCode').val('');
                $('#oetZneUSerName').val('');
                $('#oetZneSpnCode').val('');
                $('#oetZneSpnName').val('');
                $('#oetZneShopCode').val('');
                $('#oetZneShopName').val('');
                $('#oetZnePosCode').val('');
                $('#oetZnePosName').val('');
                $('#oetZneCtyCode').val('');
                $('#oetZneCtyName').val('');
                $('#oetZneAgnCode').val('');
                $('#oetZneAgnName').val('');
                $('#oetZneMchCode').val('');
                $('#oetZneMchName').val('');
            break;

            case 'TCNMUser':
                $('#odvZneBranch').hide();
                $('#odvZneUSer').show();
                $('#odvZneSaleMan').hide();
                $('#odvZneShop').hide();
                $('#odvZnePos').hide();
                $('#odvZneCountry').hide();
                $('#odvZneAgency').hide();
                $('#odvZneMerchant').hide();

                $('#oetZneBchCode').val('');
                $('#oetZneBchName').val('');
                // $('#oetZneUSerCode').val('');
                // $('#oetZneUSerName').val('');
                $('#oetZneSpnCode').val('');
                $('#oetZneSpnName').val('');
                $('#oetZneShopCode').val('');
                $('#oetZneShopName').val('');
                $('#oetZnePosCode').val('');
                $('#oetZnePosName').val('');
                $('#oetZneCtyCode').val('');
                $('#oetZneCtyName').val('');
                $('#oetZneAgnCode').val('');
                $('#oetZneAgnName').val('');
                $('#oetZneMchCode').val('');
                $('#oetZneMchName').val('');
            break;

            case 'TCNMSpn':
                $('#odvZneBranch').hide();
                $('#odvZneUSer').hide();
                $('#odvZneSaleMan').show();
                $('#odvZneShop').hide();
                $('#odvZnePos').hide();
                $('#odvZneCountry').hide();
                $('#odvZneAgency').hide();
                $('#odvZneMerchant').hide();

                $('#oetZneBchCode').val('');
                $('#oetZneBchName').val('');
                $('#oetZneUSerCode').val('');
                $('#oetZneUSerName').val('');
                // $('#oetZneSpnCode').val('');
                // $('#oetZneSpnName').val('');
                $('#oetZneShopCode').val('');
                $('#oetZneShopName').val('');
                $('#oetZnePosCode').val('');
                $('#oetZnePosName').val('');
                $('#oetZneCtyCode').val('');
                $('#oetZneCtyName').val('');
                $('#oetZneAgnCode').val('');
                $('#oetZneAgnName').val('');
                $('#oetZneMchCode').val('');
                $('#oetZneMchName').val('');
            break;
       
            case 'TCNMShop':
                $('#odvZneBranch').hide();
                $('#odvZneUSer').hide();
                $('#odvZneSaleMan').hide();
                $('#odvZneShop').show();
                $('#odvZnePos').hide();
                $('#odvZneCountry').hide();
                $('#odvZneAgency').hide();
                $('#odvZneMerchant').hide();

                $('#oetZneBchCode').val('');
                $('#oetZneBchName').val('');
                $('#oetZneUSerCode').val('');
                $('#oetZneUSerName').val('');
                $('#oetZneSpnCode').val('');
                $('#oetZneSpnName').val('');
                // $('#oetZneShopCode').val('');
                // $('#oetZneShopName').val('');
                $('#oetZnePosCode').val('');
                $('#oetZnePosName').val('');
                $('#oetZneCtyCode').val('');
                $('#oetZneCtyName').val('');
                $('#oetZneAgnCode').val('');
                $('#oetZneAgnName').val('');
                $('#oetZneMchCode').val('');
                $('#oetZneMchName').val('');
            break;

            case 'TCNMPos':
                $('#odvZneBranch').hide();
                $('#odvZneUSer').hide();
                $('#odvZneSaleMan').hide();
                $('#odvZneShop').hide();
                $('#odvZnePos').show();
                $('#odvZneCountry').hide();
                $('#odvZneAgency').hide();
                $('#odvZneMerchant').hide();

                $('#oetZneBchCode').val('');
                $('#oetZneBchName').val('');
                $('#oetZneUSerCode').val('');
                $('#oetZneUSerName').val('');
                $('#oetZneSpnCode').val('');
                $('#oetZneSpnName').val('');
                $('#oetZneShopCode').val('');
                $('#oetZneShopName').val('');
                // $('#oetZnePosCode').val('');
                // $('#oetZnePosName').val('');
                $('#oetZneCtyCode').val('');
                $('#oetZneCtyName').val('');
                $('#oetZneAgnCode').val('');
                $('#oetZneAgnName').val('');
                $('#oetZneMchCode').val('');
                $('#oetZneMchName').val('');
            break;
            case 'TCNMCountry':          
                $('#odvZneBranch').hide();
                $('#odvZneUSer').hide();
                $('#odvZneSaleMan').hide();
                $('#odvZneShop').hide();
                $('#odvZnePos').hide();
                $('#odvZneCountry').show();
                $('#odvZneAgency').hide();
                $('#odvZneMerchant').hide();

                $('#oetZneBchCode').val('');
                $('#oetZneBchName').val('');
                $('#oetZneUSerCode').val('');
                $('#oetZneUSerName').val('');
                $('#oetZneSpnCode').val('');
                $('#oetZneSpnName').val('');
                $('#oetZneShopCode').val('');
                $('#oetZneShopName').val('');
                $('#oetZnePosCode').val('');
                $('#oetZnePosName').val('');
                // $('#oetZneCtyCode').val('');
                // $('#oetZneCtyName').val('');
                $('#oetZneAgnCode').val('');
                $('#oetZneAgnName').val('');
                $('#oetZneMchCode').val('');
                $('#oetZneMchName').val('');
            break;
            case 'TCNMAgency':          
                $('#odvZneBranch').hide();
                $('#odvZneUSer').hide();
                $('#odvZneSaleMan').hide();
                $('#odvZneShop').hide();
                $('#odvZnePos').hide();
                $('#odvZneCountry').hide();
                $('#odvZneAgency').show();
                $('#odvZneMerchant').hide();

                $('#oetZneBchCode').val('');
                $('#oetZneBchName').val('');
                $('#oetZneUSerCode').val('');
                $('#oetZneUSerName').val('');
                $('#oetZneSpnCode').val('');
                $('#oetZneSpnName').val('');
                $('#oetZneShopCode').val('');
                $('#oetZneShopName').val('');
                $('#oetZnePosCode').val('');
                $('#oetZnePosName').val('');
                $('#oetZneCtyCode').val('');
                $('#oetZneCtyName').val('');
                // $('#oetZneAgnCode').val('');
                // $('#oetZneAgnName').val('');
                $('#oetZneMchCode').val('');
                $('#oetZneMchName').val('');

                var tAgnCode = "<?= $this->session->userdata('tSesUsrAgnCode') ?>";

                if(tAgnCode){
                    var tAgnName = "<?= $this->session->userdata('tSesUsrAgnName') ?>";
                    $('#oetZneAgnCode').val(tAgnCode);
                    $('#oetZneAgnName').val(tAgnName);
                    $("#obtBrowseAgency").attr("disabled", true); 
                }
                
            break;
            case 'TCNMMerchant':          
                $('#odvZneBranch').hide();
                $('#odvZneUSer').hide();
                $('#odvZneSaleMan').hide();
                $('#odvZneShop').hide();
                $('#odvZnePos').hide();
                $('#odvZneCountry').hide();
                $('#odvZneAgency').hide();
                $('#odvZneMerchant').show();

                $('#oetZneBchCode').val('');
                $('#oetZneBchName').val('');
                $('#oetZneUSerCode').val('');
                $('#oetZneUSerName').val('');
                $('#oetZneSpnCode').val('');
                $('#oetZneSpnName').val('');
                $('#oetZneShopCode').val('');
                $('#oetZneShopName').val('');
                $('#oetZnePosCode').val('');
                $('#oetZnePosName').val('');
                $('#oetZneCtyCode').val('');
                $('#oetZneCtyName').val('');
                $('#oetZneAgnCode').val('');
                $('#oetZneAgnName').val('');
                // $('#oetZneMchCode').val('');
                // $('#oetZneMchName').val('');
            break;
            default:
                $('#odvZneBranch').hide();
                $('#odvZneUSer').hide();
                $('#odvZneSaleMan').hide();
                $('#odvZneShop').hide();
                $('#odvZnePos').hide();
                $('#odvZneCountry').hide();
                $('#odvZneAgency').hide();
                $('#odvZneMerchant').hide();

        }
    }


    //Option Branch
    var oBrowseZneParent = {
        Title : ['address/zone/zone','tZNETitle'],
        Table:{Master:'TCNMZone',PK:'FTZneCode'},
        Join :{
            Table:	['TCNMZone_L'],
            On:['TCNMZone_L.FTZneCode = TCNMZone.FTZneCode AND TCNMZone_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'address/zone/zone',
            ColumnKeyLang	: ['tZNECode','tZNEChainName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMZone.FTZneCode','TCNMZone_L.FTZneChainName'],
            DataColumnsFormat : ['',''],
            Perpage			: 5,
            OrderBy			: ['TCNMZone.FTZneChain'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetZneParent","TCNMZone.FTZneCode"],
            Text		: ["oetZneParentName","TCNMZone_L.FTZneChainName"],
        },
        NextFunc:{
            FuncName:'JSxNextFuncZneParent',
            ArgReturn:['FTZneCode']
        },
        BrowseLev : '1'
    }
    //Option Area
    var oBrowseArea = {
        Title : ['address/area/area','tARESubTitle'],
        Table:{Master:'TCNMArea',PK:'FTAreCode'},
        Join :{
            Table:	['TCNMArea_L'],
            On:['TCNMArea_L.FTAreCode = TCNMArea.FTAreCode AND TCNMArea_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'address/area/area',
            ColumnKeyLang	: ['tARECode','tAREName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMArea.FTAreCode','TCNMArea_L.FTAreName'],
            DataColumnsFormat : ['',''],
            Perpage			: 5,
            OrderBy			: ['TCNMArea.FTAreCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetAreCode","TCNMArea.FTAreCode"],
            Text		: ["oetAreName","TCNMArea_L.FTAreName"],
        },
        NextFunc:{
            FuncName:'JSxNextFuncZneArea',
            ArgReturn:['FTAreCode']
        },
        // RouteAddNew : 'area',
        // BrowseLev : nStaZneBrowseType
    } 

    
    if ((tBchCode == '' || tBchCode == null) || tUsrLevel == "HQ") {
        tWhereBch = '';
    } else {
        tWhereBch = " AND TCNMBranch.FTBchCode IN(" + tBchCode + ")";
    }
    // OPtion ฺBranch (สาขา)
    var oBrowseBch = {
        
        Title : ['company/branch/branch','tBCHTitle'],
        Table:{Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
        Join :{
            Table:	['TCNMBranch_L'],
            On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID ='+nLangEdits,]
        },
        Where :{
            Condition : [tWhereBch]
        },
        GrideView:{
            ColumnPathLang	: 'company/branch/branch',
            ColumnKeyLang	: ['tBCHCode','tBCHName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
            DataColumnsFormat : ['',''],
            Perpage			: 5,
            OrderBy			: ['TCNMBranch_L.FTBchName'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            StaSingItem : '1',
            ReturnType	: 'S',
            Value		: ["oetZneBchCode","TCNMBranch.FTBchCode"],
            Text		: ["oetZneBchName","TCNMBranch_L.FTBchName"],
        },

        // RouteAddNew : 'branch',
        // BrowseLev : nStaZneBrowseType
        
    }

  
    // Browse USer (ผู้ใช้ ) 
    var tUsrCode = "<?= $this->session->userdata('tSesUserCode') ?>";
    if ((tUsrCode == '' || tUsrCode == null) || tUsrLevel == "HQ") {
        tWhereUser = '';
    } else {
        tWhereUser = " AND TCNMUser.FTUsrCode IN(" + tUsrCode + ")";
    }

    var oBrowseUSer = {
        Title : ['authen/user/user','tUSRTitle'],
        Table:{Master:'TCNMUser',PK:'FTUsrCode',PKName:'FTUsrName'},
        Join : {
            Table:	['TCNMUser_L'],
            On:['TCNMUser_L.FTUsrCode = TCNMUser.FTUsrCode AND TCNMUser_L.FNLngID ='+nLangEdits,]
        },
        Where :{
            Condition : [tWhereUser]
        },
        GrideView:{
            ColumnPathLang	: 'authen/user/user',
            ColumnKeyLang	: ['tUSRCode','tUSRName'],
            ColumnsSize		: ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMUser.FTUsrCode','TCNMUser_L.FTUsrName'],
            DataColumnsFormat : ['',''],
            Perpage			: 5,
            OrderBy			: ['TCNMUser_L.FTUsrName'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            StaSingItem : '1',
            ReturnType	: 'S',
            Value		: ["oetZneUSerCode","TCNMUser.FTUsrCode"],
            Text		: ["oetZneUSerName","TCNMUser_L.FTUsrName"],
        },

        // RouteAddNew : 'user',
        // BrowseLev : nStaZneBrowseType
    }

    // Browse SaleMan (พนักงานขาย) 
    if ((tBchCode == '' || tBchCode == null) || tUsrLevel == "HQ") {
        tWhereSale = '';
    } else {
        tWhereSale = " AND TCNTSpnGroup.FTBchCode IN(''," + tBchCode + ")";
    }
    var  oBrowseSaleMan = {
        Title : ['company/warehouse/warehouse','tSalePerson'],
        Table:{Master:'TCNMSpn',PK:'FTSpnCode'},
        Join :{
            Table:	['TCNMSpn_L','TCNTSpnGroup'],
            On:['TCNMSpn_L.FTSpnCode = TCNMSpn.FTSpnCode AND TCNMSpn_L.FNLngID = '+nLangEdits,
                'TCNTSpnGroup.FTSpnCode = TCNMSpn.FTSpnCode'
                ]
        },
        Where :{
            Condition : [tWhereSale]
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
            Value		: ["oetZneSpnCode","TCNMSpn.FTSpnCode"],
            Text		: ["oetZneSpnName","TCNMSpn_L.FTSpnName"],
        },
        // RouteAddNew : 'saleperson',
        // BrowseLev : nStaZneBrowseType
    }


    //ฺBrowse Shop (ร้านค้า)
    if ((tBchCode == '' || tBchCode == null) || tUsrLevel == "HQ") {
        tWhereShop = '';
    } else {
        tWhereShop = " AND TCNMShop.FTBchCode IN(" + tBchCode + ")";
    }
    var oBrowseShop = {
        Title : ['authen/user/user','tBrowseSHPTitle'],
        Table:{Master:'TCNMShop',PK:'FTShpCode'},
        Join :{
            Table:	['TCNMShop_L'],
            On:['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits,]
        },
        Where :{
            Condition : [tWhereShop]
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
            Value		: ["oetZneShopCode","TCNMShop.FTShpCode"],
            Text		: ["oetZneShopName","TCNMShop_L.FTShpName"],
        },
        // RouteAddNew : 'shop',
        // BrowseLev : nStaZneBrowseType
    }

    if ((tBchCode == '' || tBchCode == null) || tUsrLevel == "HQ") {
        tWherePOS = '';
    } else {
        tWherePOS = " AND TCNMPos.FTBchCode IN(" + tBchCode + ")";
    }
    // Browse Pos (เครื่องจุดขาย) 
    var oBrowsePOS = {
        Title : ['company/warehouse/warehouse','tSalemachinePOS'],
        Table:{Master:'TCNMPos',PK:'FTPosCode'},
        Join :{
            Table:	['TCNMPos_L','TCNMBranch_L'],
            On:[
                'TCNMPos_L.FTPosCode = TCNMPos.FTPosCode AND  TCNMPos_L.FTBchCode = TCNMPos.FTBchCode',
                'TCNMBranch_L.FTBchCode = TCNMPos.FTBchCode'
               ]
        },
        Where :{
            Condition : ["AND TCNMPos.FTPosType = '1' " + tWherePOS]
        },
        GrideView:{
            ColumnPathLang	: 'pos/salemachine/salemachine',
            ColumnKeyLang	: ['tPOSCode','tPOSBranchRef','tPOSName'],
            ColumnsSize     : ['15%','20%','55'],
            WidthModal      : 50,
            DataColumns		: ['TCNMPos.FTPosCode','TCNMBranch_L.FTBchName','TCNMPos_L.FTPosName'],
            DataColumnsFormat : ['','',''],
            Perpage			: 5,
            OrderBy			: ['TCNMPos.FTPosCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetZnePosCode","TCNMPos.FTPosCode"],
            Text		: ["oetZnePosName","TCNMPos_L.FTPosName"],
        },
        // RouteAddNew : 'salemachine',
        // BrowseLev : nStaZneBrowseType,
        // DebugSQL: true,
    }	

    var tCtyCode = "<?= $this->session->userdata('tSesDefCountry') ?>";
    
    if ((tCtyCode == '' || tCtyCode == null) || tUsrLevel == "HQ") {
        tWhereCty = '';
    } else {
        tWhereCty = " AND TCNMCountry.FTCtyCode = '" + tCtyCode + "'";
    }
    // Browse Country (ประเทศ) 
    var oBrowseCountry = {
        Title : ['company/country/country','tCountryTitle'],
        Table:{Master:'TCNMCountry',PK:'FTCtyCode'},
        Join :{
            Table:	['TCNMCountry_L'],
            On:['TCNMCountry_L.FTCtyCode = TCNMCountry.FTCtyCode']
        },
        Where :{
            Condition : ["AND TCNMCountry.FTCtyStaUse = '1' "+ tWhereCty]
        },
        GrideView:{
            ColumnPathLang	: 'company/country/country',
            ColumnKeyLang	: ['tCountryRef','tCountryName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMCountry.FTCtyCode','TCNMCountry_L.FTCtyName'],
            DataColumnsFormat : ['',''],
            Perpage			: 5,
            OrderBy			: ['TCNMCountry.FTCtyCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetZneCtyCode","TCNMCountry.FTCtyCode"],
            Text		: ["oetZneCtyName","TCNMCountry_L.FTCtyName"],
        },
        // RouteAddNew : 'country',
        // BrowseLev : nStaZneBrowseType
    }	

    var tAgnCode = "<?= $this->session->userdata('tSesUsrAgnCode') ?>";

    if (tAgnCode == '' || tAgnCode == null) {
        tWhereAgn = '';
    } else {
        tWhereAgn = " AND TCNMAgency.FTAgnCode = '" + tAgnCode + "'";
    }
    var oBrowseAgency = {
        Title: ['payment/rate/rate','tRTEAgency'],
        Table: {
            Master: 'TCNMAgency',
            PK: 'FTAgnCode'
        },
        Join: {
            Table: ['TCNMAgency_L'],
            On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode']
        },
        Where: {
            Condition: [tWhereAgn]
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
            Value: ["oetZneAgnCode", "TCNMAgency.FTAgnCode"],
            Text: ["oetZneAgnName", "TCNMAgency_L.FTAgnName"]
        }
    }

    var oBrowseAgencyF = {
        Title: ['payment/rate/rate','tRTEAgency'],
        Table: {
            Master: 'TCNMAgency',
            PK: 'FTAgnCode'
        },
        Join: {
            Table: ['TCNMAgency_L'],
            On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode']
        },
        Where: {
            Condition: [tWhereAgn]
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
            Value: ["oetZneAgnCodeFirst", "TCNMAgency.FTAgnCode"],
            Text: ["oetZneAgnNameFirst", "TCNMAgency_L.FTAgnName"]
        }
    }

    var oBrowseAgencyS = {
        Title: ['payment/rate/rate','tRTEAgency'],
        Table: {
            Master: 'TCNMAgency',
            PK: 'FTAgnCode'
        },
        Join: {
            Table: ['TCNMAgency_L'],
            On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode']
        },
        Where: {
            Condition: [tWhereAgn]
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
            Value: ["oetZneAgnCodeSecond", "TCNMAgency.FTAgnCode"],
            Text: ["oetZneAgnNameSecond", "TCNMAgency_L.FTAgnName"]
        }
    }

    // Browse Merchant (กลุ่มธุรกิจ) 
    var tMerCode = ",'<?= $this->session->userdata('tSesUsrPplCode') ?>'";

    if (tUsrLevel == "HQ") {
        tWhereMer = '';
    } else {
        tWhereMer = " AND TCNMMerchant.FTPplCode IN(''" + tMerCode + ")";
    }
    var oBrowseMerchant = {
        Title: ['address/zone/zone','tZneSltMerchant'],
        Table: {
            Master: 'TCNMMerchant',
            PK: 'FTMerCode'
        },
        Join: {
            Table: ['TCNMMerchant_L'],
            On: ['TCNMMerchant_L.FTMerCode = TCNMMerchant.FTMerCode']
        },
        Where: {
            Condition: [tWhereMer]
        },
        GrideView: {
            ColumnPathLang: 'merchant/merchant/merchant',
            ColumnKeyLang: ['tMCNTBCode', 'tMCNTBName'],
            ColumnsSize: ['15%', '75%'],
            DataColumns: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
            DataColumnsFormat: ['', ''],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TCNMMerchant.FTMerCode ASC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetZneMchCode", "TCNMMerchant.FTMerCode"],
            Text: ["oetZneMchName", "TCNMMerchant_L.FTMerName"]
        }
    }

    //Set Event Browse 
    $('#oimBrowseZneParent').click(function(){
        // Update CheckPinMenu Create By Witsarut 04/10/2019
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowseZneParent');
    });
    
    $('#oimBrowseArea').click(function(){
        // Update CheckPinMenu Create By Witsarut 04/10/2019
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowseArea');
    });
    
    $('#obtBrowseUSer').click(function(){
        // Update CheckPinMenu Create By Witsarut 04/10/2019
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowseUSer');
    });

  
    $('#obtBrowseSaleMan').click(function(){
        // Update CheckPinMenu Create By Witsarut 04/10/2019
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowseSaleMan');
    });

    $('#obtBrowseShop').click(function(){
        // Update CheckPinMenu Create By Witsarut 04/10/2019
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowseShop');
    });

    $('#obtBrowsePOS').click(function(){
        // Update CheckPinMenu Create By Witsarut 04/10/2019
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowsePOS');
    });

    $('#obtBrowseBranch').click(function(){
      // Update CheckPinMenu Create By Witsarut 04/10/2019
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowseBch');
    });

    $('#obtBrowseCountry').click(function(){
        // Update CheckPinMenu Create By Witsarut 04/10/2019
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowseCountry');
    });

    $('#obtBrowseAgency').click(function(){
        // Update CheckPinMenu Create By Witsarut 04/10/2019
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowseAgency');
    });

    $('#obtBrowseAgencyFirst').click(function(){
        // Update CheckPinMenu Create By Witsarut 04/10/2019
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowseAgencyF');
    });

    $('#obtBrowseAgencySecond').click(function(){
        // Update CheckPinMenu Create By Witsarut 04/10/2019
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowseAgencyS');
    });

    $('#obtBrowseMerchant').click(function(){
        // Update CheckPinMenu Create By Witsarut 04/10/2019
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowseMerchant');
    });
    

    function JSxNextFuncZneParent(paDataReturn){
        $('#oetZneParentName').closest('.form-group').addClass( "has-success" ).removeClass( "has-error");
        $('#oetZneParentName').closest('.form-group').find(".help-block").fadeOut('slow').remove();
    }

    function JSxNextFuncZneArea(paDataReturn){
        $('#oetZneName').closest('.form-group').addClass( "has-success" ).removeClass( "has-error");
        $('#oetZneName').closest('.form-group').find(".help-block").fadeOut('slow').remove();
    }

    $(".selection-2").select2({
        minimumResultsForSearch: 20,
        dropdownParent: $('#dropDownSelect1')
    });


    $('.xWTooltipsBT').tooltip({'placement': 'bottom'});
    $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});




    $('#oetZneParent').on('change', function() {
        $('#ocbSelectRoot').prop('checked',false);
    });

    //Edit inline
    function JSvCallPageZoneReferClickEdit(ZenElement, ZenEvent , pnZoneCode) {
        // console.log(pnZone);
        JSxZoneSetCallPageEdit(pnZoneCode);
    }

    //
    function JSxHideObjZoneTypeRefer(evn,tElement){
        var tTypeZen = $(evn).val();
        var tRecordId = $(tElement).parents('.xWZoneObjDataSource').attr('id');
        switch(tTypeZen){
            case 'TCNMBranch':
                $('#oetZneUSerCode'+tRecordId).addClass("xCNHide");
                $('#oetZneUSerCode'+tRecordId).val('');

                $('#oetZneSpnCode'+tRecordId).addClass("xCNHide");
                $('#oetZneSpnCode'+tRecordId).val('');

                $('#oetZneShopCode'+tRecordId).addClass("xCNHide");
                $('#oetZneShopCode'+tRecordId).val('');

                $('#oetZnePosCode'+tRecordId).addClass("xCNHide");
                $('#oetZnePosCode'+tRecordId).val('');

                $('#odvZneReferBranch'+tRecordId).show();
                $('#odvZneRefUSer'+tRecordId).hide();
                $('#odvZneSaleMan'+tRecordId).hide();
                $('#odvZneShop'+tRecordId).hide();
                $('#odvZnePos'+tRecordId).hide();

                $('#oetZneEdit'+tRecordId).show();
                $('#odvZneRefName'+tRecordId).addClass("xCNHide");

                $('#odvZneReferBranch'+tRecordId).removeClass("xCNHide");
                $('#oetZneBchCode'+tRecordId).addClass("xCNHide");
                $('.xCNZneReferZneUSer'+tRecordId).addClass("xCNHide");
                $('#odvZneReferBranch'+tRecordId).find('#obtBrowseBranchZen').click(function(){
                    var tInpurReturnCode            = $(this).closest('.xWZoneObjDataSource').find('#oetZneEdit'+tRecordId).attr('id');
                    var tInpurReturnName            = $(this).closest('.xWZoneObjDataSource').find('#oetZneBchName'+tRecordId).attr('id');
                    window.oBrowseBchZenEditInline  = undefined;
                    oBrowseBchZenEditInline         = {
                        Title : ['company/branch/branch','tBCHTitle'],
                        Table:{Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
                        Join :{
                            Table:	['TCNMBranch_L'],
                            On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID ='+nLangEdits,]
                        },
                        GrideView:{
                            ColumnPathLang	: 'company/branch/branch',
                            ColumnKeyLang	: ['tBCHCode','tBCHName'],
                            ColumnsSize     : ['15%','75%'],
                            WidthModal      : 50,
                            DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                            DataColumnsFormat : ['',''],
                            Perpage			: 10,
                            OrderBy		    : ['TCNMBranch.FDCreateOn DESC'],
                        },
                        CallBack:{
                            StaSingItem : '1',
                            ReturnType	: 'S',
                            Value		: [tInpurReturnCode,"TCNMBranch.FTBchCode"],
                            Text		: [tInpurReturnName,"TCNMBranch_L.FTBchName"],
                        },
                        RouteAddNew : 'branch',
                        BrowseLev : nStaZneBrowseType
                    }
                    JCNxBrowseData('oBrowseBchZenEditInline');
                $('#oetZneEdit'+tRecordId).removeClass("xCNHide");
            });
            break;
            case 'TCNMUser':
                $('#oetZneSpnCode'+tRecordId).addClass("xCNHide");
                $('#oetZneSpnCode'+tRecordId).val('');

                $('#oetZneEdit'+tRecordId).addClass("xCNHide");
                $('#oetZneEdit'+tRecordId).val('');

                $('#oetZneShopCode'+tRecordId).addClass("xCNHide");
                $('#oetZneShopCode'+tRecordId).val('');

                $('#oetZnePosCode'+tRecordId).addClass("xCNHide");
                $('#oetZnePosCode'+tRecordId).val('');

                //เปิด/ปิด Browse
                $('#odvZneRefUSer'+tRecordId).show();
                $('#odvZneReferBranch'+tRecordId).hide();
                $('#odvZneSaleMan'+tRecordId).hide();
                $('#odvZneShop'+tRecordId).hide();
                $('#odvZnePos'+tRecordId).hide();
                
                $('#odvZneRefUSer'+tRecordId).removeClass("xCNHide");

                $('#odvZneRefName'+tRecordId).addClass("xCNHide");


                $('#odvZneSaleMan'+tRecordId).addClass("xCNHide");
                $('#oetZneBchCode'+tRecordId).addClass("xCNHide");
                $('.xCNZneSpnCode'+tRecordId).addClass("xCNHide");
                
                $('#odvZneRefUSer'+tRecordId).find('#obtBrowseUSer').click(function(){
                    var tInpurReturnCode    = $(this).closest('.xWZoneObjDataSource').find('#oetZneUSerCode'+tRecordId).attr('id');
                    var tInpurReturnName    = $(this).closest('.xWZoneObjDataSource').find('#oetZneUSerName'+tRecordId).attr('id');
                window.oBrowseUSerZenEditInline  = undefined;
                // Browse USer (ผู้ใช้ ) 
                oBrowseUSerZenEditInline         = {
                        Title : ['authen/user/user','tUSRTitle'],
                        Table:{Master:'TCNMUser',PK:'FTUsrCode',PKName:'FTUsrName'},
                        Join : {
                            Table:	['TCNMUser_L'],
                            On:['TCNMUser_L.FTUsrCode = TCNMUser.FTUsrCode AND TCNMUser_L.FNLngID ='+nLangEdits,]
                        },
                        GrideView:{
                            ColumnPathLang	: 'authen/user/user',
                            ColumnKeyLang	: ['tUSRCode','tUSRName'],
                            ColumnsSize     : ['15%','75%'],
                            WidthModal      : 50,
                            DataColumns		: ['TCNMUser.FTUsrCode','TCNMUser_L.FTUsrName'],
                            DataColumnsFormat : ['',''],
                            Perpage			: 5,
                            OrderBy			: ['TCNMUser_L.FTUsrName'],
                            SourceOrder		: "ASC"
                        },
                        CallBack:{
                            StaSingItem : '1',
                            ReturnType	: 'S',
                            Value		: [tInpurReturnCode,"TCNMUser.FTUsrCode"],
                            Text		: [tInpurReturnName,"TCNMUser_L.FTUsrName"],
                        },
                        RouteAddNew : 'user',
                        BrowseLev : nStaZneBrowseType
                    }
                    JCNxBrowseData('oBrowseUSerZenEditInline');
                $('#oetZneUSerCode'+tRecordId).removeClass("xCNHide");
            });
            break;

            case 'TCNMSpn':
                //ซ่อนtext Code ล้างค่า
                $('#oetZneUSerCode'+tRecordId).addClass("xCNHide");
                $('#oetZneUSerCode'+tRecordId).val('');

                $('#oetZneEdit'+tRecordId).addClass("xCNHide");
                $('#oetZneEdit'+tRecordId).val('');

                $('#oetZneShopCode'+tRecordId).addClass("xCNHide");
                $('#oetZneShopCode'+tRecordId).val('');

                $('#oetZnePosCode'+tRecordId).addClass("xCNHide");
                $('#oetZnePosCode'+tRecordId).val('');

                //เปิด/ปิด Browse
                $('#odvZneSaleMan'+tRecordId).show();
                $('#odvZneReferBranch'+tRecordId).hide();
                $('#odvZneRefUSer'+tRecordId).hide();
                $('#odvZneShop'+tRecordId).hide();
                $('#odvZnePos'+tRecordId).hide();
    

                $('#odvZneSaleMan'+tRecordId).removeClass("xCNHide");
                $('#oetZneBchCodeotrZen'+tRecordId).show();
                $('#odvZneRefUSerotrZen'+tRecordId).addClass("xCNHide");


                $('#oetZneBchCode'+tRecordId).addClass("xCNHide");
                $('.xWInpuTextLineZenReferName'+tRecordId).addClass("xCNHide");
                $('#odvZneSaleMan'+tRecordId).find('#obtBrowseSaleMan').click(function(){
                    var tInpurReturnCode    = $(this).closest('.xWZoneObjDataSource').find('#oetZneSpnCode'+tRecordId).attr('id');
                    var tInpurReturnName    = $(this).closest('.xWZoneObjDataSource').find('#oetZneSpnName'+tRecordId).attr('id');
                window.oBrowseSaleManZenEditInline  = undefined;
                    // Browse SaleMan (พนักงานขาย) 
                oBrowseSaleManZenEditInline         = {
                    Title : ['company/warehouse/warehouse','tSalePerson'],
                    Table:{Master:'TCNMSpn',PK:'FTSpnCode'},
                    Join :{
                        Table:	['TCNMSpn_L'],
                        On:['TCNMSpn_L.FTSpnCode = TCNMSpn.FTSpnCode AND TCNMSpn_L.FNLngID = '+nLangEdits,]
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
                        Value		: [tInpurReturnCode,"TCNMSpn.FTSpnCode"],
                        Text		: [tInpurReturnName,"TCNMSpn_L.FTSpnName"],
                    },
                    RouteAddNew : 'saleperson',
                    BrowseLev : nStaZneBrowseType
                }
                    JCNxBrowseData('oBrowseSaleManZenEditInline');
                $('#oetZneSpnCode'+tRecordId).removeClass("xCNHide");
            });
            break;
            case 'TCNMShop':
                //ซ่อนtext Code ล้างค่า
                $('#oetZneUSerCode'+tRecordId).addClass("xCNHide");
                $('#oetZneUSerCode'+tRecordId).val('');

                $('#oetZneEdit'+tRecordId).addClass("xCNHide");
                $('#oetZneEdit'+tRecordId).val('');

                $('#oetZneSpnCode'+tRecordId).addClass("xCNHide");
                $('#oetZneSpnCode'+tRecordId).val('');

                $('#oetZnePosCode'+tRecordId).addClass("xCNHide");
                $('#oetZnePosCode'+tRecordId).val('');
                


                // เปิด/ปิด Browse
                $('#odvZneShop'+tRecordId).show();
                $('#odvZneSaleMan'+tRecordId).hide();
                $('#odvZneReferBranch'+tRecordId).hide();
                $('#odvZneRefUSer'+tRecordId).hide();
                $('#odvZnePos'+tRecordId).hide();
                
                $('#odvZneShop'+tRecordId).removeClass("xCNHide");

                $('#oetZneBchCodeotrZen'+tRecordId).show();
                $('#odvZneRefUSerotrZen'+tRecordId).addClass("xCNHide");


                $('#oetZneBchCode'+tRecordId).addClass("xCNHide");
                $('.xWInpuTextLineZenReferName'+tRecordId).addClass("xCNHide");
                $('#odvZneShop'+tRecordId).find('#obtBrowseShop').click(function(){
                    var tInpurReturnCode    = $(this).closest('.xWZoneObjDataSource').find('#oetZneShopCode'+tRecordId).attr('id');
                    var tInpurReturnName    = $(this).closest('.xWZoneObjDataSource').find('#oetZneShopName'+tRecordId).attr('id');
                window.oBrowseShopZenEditInline  = undefined;
                        //ฺBrowse Shop (ร้านค้า)
                oBrowseShopZenEditInline         = {
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
                        Value		: [tInpurReturnCode,"TCNMShop.FTShpCode"],
                        Text		: [tInpurReturnName,"TCNMShop_L.FTShpName"],
                    },
                    RouteAddNew : 'shop',
                    BrowseLev : nStaZneBrowseType
                }
                    JCNxBrowseData('oBrowseShopZenEditInline');
                $('#oetZneShopCode'+tRecordId).removeClass("xCNHide");
            });
            break;
            case 'TCNMPos':
                        //ซ่อนtext Code ล้างค่า
                $('#oetZneUSerCode'+tRecordId).addClass("xCNHide");
                $('#oetZneUSerCode'+tRecordId).val('');

                $('#oetZneEdit'+tRecordId).addClass("xCNHide");
                $('#oetZneEdit'+tRecordId).val('');

                $('#oetZneSpnCode'+tRecordId).addClass("xCNHide");
                $('#oetZneSpnCode'+tRecordId).val('');

                $('#oetZneSpnCode'+tRecordId).addClass("xCNHide");
                $('#oetZneSpnCode'+tRecordId).val('');

                // เปิด/ปิด Browse
                $('#odvZnePos'+tRecordId).show();
                $('#odvZneShop'+tRecordId).hide();
                $('#odvZneSaleMan'+tRecordId).hide();
                $('#odvZneReferBranch'+tRecordId).hide();
                $('#odvZneRefUSer'+tRecordId).hide();
                
                $('#odvZnePos'+tRecordId).removeClass("xCNHide");
                
                $('#oetZneBchCodeotrZen'+tRecordId).show();
                $('#odvZneRefUSerotrZen'+tRecordId).addClass("xCNHide");


                $('#oetZneBchCode'+tRecordId).addClass("xCNHide");
                $('.xWInpuTextLineZenReferName'+tRecordId).addClass("xCNHide");
                $('#odvZnePos'+tRecordId).find('#obtBrowsePOS').click(function(){
                    var tInpurReturnCode    = $(this).closest('.xWZoneObjDataSource').find('#oetZnePosCode'+tRecordId).attr('id');
                    var tInpurReturnName    = $(this).closest('.xWZoneObjDataSource').find('#oetZnePosName'+tRecordId).attr('id');
                window.oBrowsePOSZenEditInline  = undefined;
                // Browse Pos (เครื่องจุดขาย) 
                oBrowsePOSZenEditInline         = {
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
                        Value		: [tInpurReturnCode,"TCNMPos.FTPosCode"],
                        Text		: [tInpurReturnName,"TCNMPosLastNo.FTPosComName"],
                    },
                    RouteAddNew : 'salemachine',
                    BrowseLev : nStaZneBrowseType
                }
                JCNxBrowseData('oBrowsePOSZenEditInline');
                $('#oetZnePosCode'+tRecordId).removeClass("xCNHide");  
            }); 
            break;
            default:

                $('#odvZneRefName'+tRecordId).removeClass("xCNHide");
                $('#oetZneBchCode'+tRecordId).removeClass("xCNHide");

                $('#odvZnePos'+tRecordId).hide();
                $('#odvZneShop'+tRecordId).hide();
                $('#odvZneSaleMan'+tRecordId).hide();
                $('#odvZneReferBranch'+tRecordId).hide();
                $('#odvZneRefUSer'+tRecordId).hide();

        }
    }

    //Save 
    function JSxZenReferDataSourceSaveOperator(ZenElement, ZenEvent, ptZneID, pnPage){
            try {
                var tRecordId                   = $(ZenElement).parents('.xWZoneObjDataSource').attr('id');
                var tZneKey                     = $(ZenElement).parents('.xWZoneObjDataSource').find('#oetZneKey'+tRecordId).val();
                var tTypeRefer                  = $(ZenElement).parents('.xWZoneObjDataSource').find('#ocmTypeReferEditRefer'+tRecordId).val();
        
                var tZenRefCode                 = $(ZenElement).parents('.xWZoneObjDataSource').find('#oetZneEdit'+tRecordId).val();
                var tZneUSerCode                = $(ZenElement).parents('.xWZoneObjDataSource').find('#oetZneUSerCode'+tRecordId).val();
                var tZneSpnCode                 = $(ZenElement).parents('.xWZoneObjDataSource').find('#oetZneSpnCode'+tRecordId).val();
                var tZneShpCode                 = $(ZenElement).parents('.xWZoneObjDataSource').find('#oetZneShopCode'+tRecordId).val();
                var tZnePosCode                 = $(ZenElement).parents('.xWZoneObjDataSource').find('#oetZnePosCode'+tRecordId).val();
                
                
                
                if(typeof(tZenRefCode)  !== undefined && tZenRefCode != ""){
                    var tZneCode                = $(ZenElement).parents('.xWZoneObjDataSource').find('#oetZneEdit'+tRecordId).val();
                }
                if(typeof(tZneUSerCode) !== undefined && tZneUSerCode != ""){
                    var tZneCode                = $(ZenElement).parents('.xWZoneObjDataSource').find('#oetZneUSerCode'+tRecordId).val();
                }
                if(typeof(tZneSpnCode)  !== undefined && tZneSpnCode != ""){
                    var tZneCode                = $(ZenElement).parents('.xWZoneObjDataSource').find('#oetZneSpnCode'+tRecordId).val();
                }
                if(typeof(tZneShpCode)  !== undefined && tZneShpCode != ""){
                    var tZneCode                = $(ZenElement).parents('.xWZoneObjDataSource').find('#oetZneShopCode'+tRecordId).val();
                }
                if(typeof(tZnePosCode)  !== undefined && tZnePosCode != ""){
                    var tZneCode                = $(ZenElement).parents('.xWZoneObjDataSource').find('#oetZnePosCode'+tRecordId).val();
                }
    
                // Update
                JSxZoneReferUpdateDataEditinline(tZneCode, tZneKey, tTypeRefer, pnPage, ptZneID, ZenElement);

                // Remove Seft Record Backup
                localStorage.removeItem(tRecordId);

                // Visibled icons
                JSxZonreferDataSourceVisibledOperationIcon(ZenElement, 'save', false); // Itself hidden(save)
                JSxZonreferDataSourceVisibledOperationIcon(ZenElement, 'cancel', false); // hidden cancel icon
                JSxZonreferDataSourceVisibledOperationIcon(ZenElement, 'edit', true); // show edit icon

                $(ZenElement) // Active ShopbyGPAvg - success
                            .parents('.xWShpShopDataSource')
                            .find('.xCNFieldGPPerAvg input[type=text]')
                            .removeAttr('disabled')
                            .addClass('text')
                            .attr('maxlength', 18);

                } catch (err) {
                console.log('JSxZenReferDataSourceSaveOperator Error: ', err);
                }
                }

                //Cancle
                function JSxPageShpShopDataSourceCancelOperator(ZenElement,ZenEvent,Page){

                try {
                var tRecordId = $(ZenElement).parents('.xWZoneObjDataSource').attr('id');

                // Restore Seft Record
                var oBackupRecord = JSON.parse(localStorage.getItem(tRecordId));
                $(ZenElement).parents('.xWZoneObjDataSource').find('.xWTimeStampClockIN input[type=text]').val(oBackupRecord.tClockIN);
                $(ZenElement).parents('.xWZoneObjDataSource').find('.xWTimeStampClockOut input[type=text]').val(oBackupRecord.tClockOUT);

                // Remove Seft Record Backup
                localStorage.removeItem(tRecordId);

                // Visibled icons
                JSxZonreferDataSourceVisibledOperationIcon(ZenElement, 'cancel', false); // Itself hidden(cancel)
                JSxZonreferDataSourceVisibledOperationIcon(ZenElement, 'save', false); // hidden save icon
                JSxZonreferDataSourceVisibledOperationIcon(ZenElement, 'edit', true); // show edit icon

                $(ZenElement) // Active GPPerAvg - Status
                        .parents('.xWShpShopDataSource')
                        .find('.xCNFieldGPPerAvg input[type=text]')
                        .attr('disabled', true);



                JSvZoneObjDataTable(Page);          
                } catch (err) {
                console.log('JSxCancelOperator Error: ', err);
                }
                }

                //Hidden BTN / Show BTN
                function JSxZonreferDataSourceVisibledOperationIcon(ZenElement, ptOperation, pbVisibled) {
                try {
                switch (ptOperation) {
                    case 'edit' :
                    {
                        if (pbVisibled) { // show
                            $($(ZenElement) // Unhidden Cancel of seft group
                                    .parents('.xWZoneObjDataSource')
                                    .find('.xWIMGZoneReferEdit'))
                                    .removeClass('hidden');
                        } else { // hide
                            $($(ZenElement) // Hidden Cancel of seft group
                                    .parents('.xWZoneObjDataSource')
                                    .find('.xWIMGZoneReferEdit'))
                                    .addClass('hidden');
                        }
                        break;
                    }
                    case 'cancel' :
                    {
                        if (pbVisibled) { // show
                            $($(ZenElement) // Unhidden Cancel of seft group
                                    .parents('.xWZoneObjDataSource')
                                    .find('.xWIMGZoneReferCancel'))
                                    .removeClass('hidden');
                    
                        } else { // hide
                            $($(ZenElement) // Hidden Cancel of seft group
                                    .parents('.xWZoneObjDataSource')
                                    .find('.xWIMGZoneReferCancel'))
                                    .addClass('hidden');
                                
                        }
                        break;
                    }
                    case 'save' :
                    {
                        if (pbVisibled) { // show
                            $($(ZenElement) // Unhidden Cancel of seft group
                                    .parents('.xWZoneObjDataSource')
                                    .find('.xWIMGZoneReferSave'))
                                    .removeClass('hidden');
                        } else { // hide
                            $($(ZenElement) // Hidden Cancel of seft group
                                    .parents('.xWZoneObjDataSource')
                                    .find('.xWIMGZoneReferSave'))
                                    .addClass('hidden');
                        }
                        break;
                    }
                    default :
                    {
                    }
                }
            } catch (err) {
            console.log('JSxZonreferDataSourceVisibledOperationIcon Error: ', err);
            }
        }
    
    
    //Update Inline 
    function JSxZoneReferUpdateDataEditinline(ptZneCode, ptZneKey, ptTypeRefer, pnPage, ptZneID, ZenElement){
        try{
            var tRecordId    = $(ZenElement).parents('.xWZoneObjDataSource').attr('id');
            var tZneCode     = ptZneCode;
            var tZneKey      = ptZneKey;
            var tTypeRefer   = ptTypeRefer;
            var tZneID       = ptZneID;
            $('#odvZnePos'+tRecordId).hide();
            $('#odvZneShop'+tRecordId).hide();
            $('#odvZneSaleMan'+tRecordId).hide();
            $('#odvZneReferBranch'+tRecordId).hide();
            $('#odvZneRefUSer'+tRecordId).hide();
            $.ajax({
            type    : "POST",
            url     : "zoneReferEventEdit",
            data    : {
                tZneCode   : tZneCode, 
                tZneKey    : tZneKey, 
                tTypeRefer : tTypeRefer, 
                tZneID     : tZneID
                
            },
            cache: false,
            success: function(tResult) {
                tResult = tResult.trim();
                var tData = $.parseJSON(tResult);
                if(tData['nStaEvent'] == '1'){
                    JSvZoneObjDataTable(pnPage);
                }
            }
        });
            }catch(err){
        console.log("JSxZoneReferUpdateDataEditinline Error: ", err);
    }
}
</script>