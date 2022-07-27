<script>
    $(document).ready(function(){
        $("#oetRoleFuncSearchAll").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".xCNRoleFuncSettingBody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
            console.log('JSaGetRoleFuncSettingSelect: ', JSaGetRoleFuncSettingSelect());
        });

        $(".xCNRoleFuncSettingPermissionItemAll").on("change", function(){
            var bIsChecked = $(this).is(":checked");
            if(bIsChecked){
                $(".xCNRoleFuncSettingPermissionItem").prop("checked", true);
            }else{
                $(".xCNRoleFuncSettingPermissionItem").prop("checked", false);
            }
        });
    });
    
    /**
     * Functionality: Get Function Setting Role on Selected
     * Creator: 24/04/2020 piya
     * LastUpdate: -
     * Return : Function Setting Role on Selected Items
     * ReturnType: array
     */
    function JSaGetRoleFuncSettingSelect(){
        var aRoleFuncSettingItems = [];
        var oRoleFuncSettingChecked = $(".xCNRoleFuncSettingTable .xCNRoleFuncSettingPermissionItem:checked");

        $.each(oRoleFuncSettingChecked, function(){
            var tGhdApp = $(this).data("ghd-app");
            var tGhdCode = $(this).data("ghd-code");
            var tSysCode = $(this).data("sys-code");

            aRoleFuncSettingItems.push({
                tGhdApp: tGhdApp,
                tGhdCode: tGhdCode,
                tSysCode: tSysCode
            });
        });

        return aRoleFuncSettingItems;
    }
</script>