<style>

.xCNComboSelect{
    height: 33px !important;
}

.filter-option-inner-inner{
    margin-top : 0px;
}

.dropdown-toggle{
    height: 33px !important;
}
</style>


<input type="hidden" class="form-control" id="ohdSETTypePage" name="ohdSETTypePage" value="<?=$tTypePage;?>">

<div class="row">
    <div class="col-xs-8 col-md-4 col-lg-4">
    </div>

    <div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:25px;">
            <div id="odvBtnAddEdit" style="display: block;padding-bottom:10px;">
                    <button onclick="JSxCurrentcySave()" type="button" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" style="margin-left: 5px;" style="display: block;"><?=language('common/main/main', 'tModalConfirm'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="odvContentConfigTable"></div>


<script>
    //ใช้ selectpicker
    $('.selectpicker').selectpicker();	

    //LoadTable
    JSvSettingDairyCurrencyLoadTable();


    //function Insert Data
    function onReaderLoad(event){
            
        if(event.target.result == '' || event.target.result == null){
            $('#odvContentConfigRenderHTMLImport').html('<span style="color:red"> รูปแบบไฟล์ไม่ถูกต้อง </span>');
            return;
        }

        var paData = JSON.parse(event.target.result);
        // var tRoleAutoGenCode    = $('#ocbRoleAutoGenCode').is(':checked')? 1 : 0;

        if(paData[0]['tTable'] != "TSysConfig" || paData[1]['tTable'] != "TSysConfig_L"){
            $('#odvContentConfigRenderHTMLImport').html('<span style="color:red"> รูปแบบไฟล์ไม่ถูกต้อง </span>');
        }else{
            $.ajax({
                type : "POST",
                url : "configInsertData",
                catch : false,
                data : {
                    aData : paData
                },
                timeout : 0,
                success : function(tResult){
                    let aDataReturn = JSON.parse(tResult);
                    if(aDataReturn['nStaEvent'] == '1'){
                        $('#odvModalConfigImport').modal('hide');
                        JSvSettingConfigLoadTable();
                        $('.modal-backdrop').remove();
                    }else{
                        var tMsgErrorFunction   = aDataReturn['tStaMessg'];
                        FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
                    }
                    JCNxCloseLoading();
                },
            });
        }
    }
</script>