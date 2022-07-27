<script type="text/javascript">

        var nLangEdits = <?=$this->session->userdata("tLangEdit")?>;

        // call BrowseUsrRole get RoleGrp
        function FSxPADPermissionApvDocAddUsrRole(ptDapRoleGrp){
            var tDapRoleGrp = ptDapRoleGrp;
            $('#ohdDapRoleGrp').val('');
            if(tDapRoleGrp != ''){
                $('#ohdDapRoleGrp').val(tDapRoleGrp);
                JCNxBrowseData('oBrowseUsrRole');
            }
        }

        // Option UsrRole
        var oBrowseUsrRole = {
            Title : ['authen/role/role','tROLTitle'],
            Table:{Master:'TCNMUsrRole',PK:'FTRolCode'},
            Join :{
                Table:	['TCNMUsrRole_L'],
                On:['TCNMUsrRole_L.FTRolCode = TCNMUsrRole.FTRolCode AND TCNMUsrRole_L.FNLngID = '+nLangEdits,]
            },
            GrideView:{
                ColumnPathLang	: 'authen/role/role',
                ColumnKeyLang	: ['tROLTBCode','tROLTBName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMUsrRole.FTRolCode','TCNMUsrRole_L.FTRolName'],
                DataColumnsFormat : ['',''],
                Perpage			: 5,
                OrderBy			: ['TCNMUsrRole.FTRolCode'],
                SourceOrder		: "ASC"
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: ["ohdBnkCode","TCNMUsrRole.FTRolCode"],
                Text		: ["oetBnkName","TCNMUsrRole_L.FTRolName"],
            },
            NextFunc : {
                FuncName    : 'JSxRptConsNextFuncBrowseUsrRole',
                ArgReturn   : ['FTRolCode','FTRolName']
            },
        }

        function JSxRptConsNextFuncBrowseUsrRole(poDataNextFunc){
            if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
            var aDataNextFunc   = JSON.parse(poDataNextFunc);
            tRolCode      = aDataNextFunc[0];
            tRolName      = aDataNextFunc[1];
        }
        let tDapRoleGrp = $('#ohdDapRoleGrp').val();
        //push Data
        $('.xCNNotdetermined'+tDapRoleGrp).html(tRolName);
        $('.xWUsrRole'+tDapRoleGrp).attr( "data-userrole",tRolCode) ;


    }

</script>