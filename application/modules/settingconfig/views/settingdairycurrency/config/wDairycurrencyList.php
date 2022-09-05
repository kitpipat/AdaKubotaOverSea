<style>
    .xCNComboSelect {
        height: 33px !important;
    }

    .filter-option-inner-inner {
        margin-top: 0px;
    }

    .dropdown-toggle {
        height: 33px !important;
    }
</style>

<?php
$aUserData = $this->session->userdata('tSesUsrInfo');
?>


<input type="hidden" class="form-control" id="ohdSETTypePage" name="ohdSETTypePage" value="<?= $tTypePage; ?>">
<input type="hidden" class="form-control" id="ohdCurrentAgnCode" name="ohdCurrentAgnCode" value="<?= $this->session->userdata('tSesUsrAgnCode'); ?>">
<input type="hidden" class="form-control" id="ohdCurrentUsrCode" name="ohdCurrentUsrCode" value="<?= $aUserData['FTUsrCode']; ?>">

<div class="row">
    <div class="col-xs-8 col-md-4 col-lg-4">
        <div class="input-group">
            <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchCurrentDairy" name="oetSearchCurrentDairy" placeholder="<?php echo language('common/main/main', 'tPlaceholder') ?>">
            <span class="input-group-btn">
                <button id="oimSearchCurrentDairy" class="btn xCNBtnSearch" type="button">
                    <img class="xCNIconAddOn" src="<?php echo base_url() . '/application/modules/common/assets/images/icons/search-24.png' ?>">
                </button>
            </span>
        </div>
    </div>

    <div class="col-xs-4 col-md-8 col-lg-8 text-right">
        <div id="odvBtnAddEdit" style="display: block;padding-bottom:10px;">
            <button onclick="JSxCurrentcyCurrentRate()" type="button" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" style="margin-left: 5px;" style="display: block;"><?= language('common/main/main', 'Refresh'); ?></button>
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

    $('#oimSearchCurrentDairy').click(function(){
		JCNxOpenLoading();
		JSvSettingDairyCurrencyLoadTable();
	});
	$('#xCNInputWithoutSingleQuote').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvSettingDairyCurrencyLoadTable();
		}
	});


    //function Insert Data
    function onReaderLoad(event) {

        if (event.target.result == '' || event.target.result == null) {
            $('#odvContentConfigRenderHTMLImport').html('<span style="color:red"> รูปแบบไฟล์ไม่ถูกต้อง </span>');
            return;
        }

        var paData = JSON.parse(event.target.result);
        // var tRoleAutoGenCode    = $('#ocbRoleAutoGenCode').is(':checked')? 1 : 0;

        if (paData[0]['tTable'] != "TSysConfig" || paData[1]['tTable'] != "TSysConfig_L") {
            $('#odvContentConfigRenderHTMLImport').html('<span style="color:red"> รูปแบบไฟล์ไม่ถูกต้อง </span>');
        } else {
            $.ajax({
                type: "POST",
                url: "configInsertData",
                catch: false,
                data: {
                    aData: paData
                },
                timeout: 0,
                success: function(tResult) {
                    let aDataReturn = JSON.parse(tResult);
                    if (aDataReturn['nStaEvent'] == '1') {
                        $('#odvModalConfigImport').modal('hide');
                        JSvSettingConfigLoadTable();
                        $('.modal-backdrop').remove();
                    } else {
                        var tMsgErrorFunction = aDataReturn['tStaMessg'];
                        FSvCMNSetMsgErrorDialog('<p class="text-left">' + tMsgErrorFunction + '</p>');
                    }
                    JCNxCloseLoading();
                },
            });
        }
    }
</script>