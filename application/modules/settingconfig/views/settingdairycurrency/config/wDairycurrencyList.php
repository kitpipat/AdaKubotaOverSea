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
// $aUserData = $this->session->userdata('tSesUsrInfo');
$tAgnCode = $this->session->userdata('tSesUsrAgnCode');
$tAgnName = $this->session->userdata('tSesUsrAgnName');
$tBchCount = $this->session->userdata('nSesUsrBchCount');

// print_r($this->session->userdata());
?>


<input type="hidden" class="form-control" id="ohdSETTypePage" name="ohdSETTypePage" value="<?= $tTypePage; ?>">
<input type="hidden" class="form-control" id="ohdCurrentAgnCode" name="ohdCurrentAgnCode" value="<?= $this->session->userdata('tSesUsrAgnCode'); ?>">
<input type="hidden" class="form-control" id="ohdCurrentUsrCode" name="ohdCurrentUsrCode" value="<?= $this->session->userdata("tSesUsername"); ?>">

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


<?php if( $tBchCount > 0 && $tAgnCode == ''){ ?>
<?php }else{ ?>
    <div class="col-xs-4 col-md-8 col-lg-8 text-right">
        <div class="col-lg-7 col-md-6 col-xs-6 no-padding padding-left-15">
        </div>
        <div class="col-lg-4 col-md-4 col-xs-12 no-padding padding-right-15">
            <div class="form-group">
                <div class="input-group"><input type="text" class="form-control xCNHide" id="oetSpcAgncyCode" name="oetSpcAgncyCode" maxlength="5" value="<?= @$tAgnCode; ?>">
                    <input type="hidden" id="oetSpcAgncyCodeOld" name="oetSpcAgncyCodeOld" value="<?= @$tAgnCode; ?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetSpcAgncyName" name="oetSpcAgncyName" maxlength="100" placeholder="<?php echo language('authen/role/role', 'tRolegency'); ?>" value="<?= @$tAgnName; ?>" data-validate-required="<?php echo language('authen/role/role', 'tValiSpcAgency') ?>" readonly>
                    <span class="input-group-btn">
                        <button id="oimBrowseSpcAgncy" type="button" class="btn xCNBtnBrowseAddOn" <?= @$tDisabled ?> <?php
                                                                                                                        if ($this->session->userdata("tSesUsrLoginLevel") != 'HQ') {
                                                                                                                            echo 'disabled';
                                                                                                                        }
                                                                                                                        ?>>
                            <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-lg-1 col-md-1 col-xs-1 no-padding" >

            <div id="odvBtnAddEdit" style="display: block;padding-bottom:10px;">
                <button onclick="JSxCurrentcyCurrentRate()" type="button" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" style="padding: 3px 27px !important;" style="display: block;"><?= language('settingconfig/settingdairycurrency/settingdairycurrency', 'tResetRefresh'); ?></button>
            </div>
        </div>
    </div>
<?php } ?>
</div>
</div>
</div>

<div id="odvContentConfigTable"></div>


<script>
    //ใช้ selectpicker
    $('.selectpicker').selectpicker();

    //LoadTable
    JSvSettingDairyCurrencyLoadTable();

    $('#oimSearchCurrentDairy').click(function() {
        JCNxOpenLoading();
        JSvSettingDairyCurrencyLoadTable();
    });
    $('#xCNInputWithoutSingleQuote').keypress(function(event) {
        if (event.keyCode == 13) {
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

    $('#oimBrowseSpcAgncy').click(function(e){
    e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) != 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oBrowseSpcAgencyOption = oBrowseSpcAgncy({
                'tReturnInputCode'  : 'oetSpcAgncyCode',
                'tReturnInputName'  : 'oetSpcAgncyName',
                'tBchCodeWhere'     : $('#oetSpcBranchCode').val(),
            });
            JCNxBrowseData('oBrowseSpcAgencyOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    //Option Browse
    var oBrowseSpcAgncy = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tBchCodeWhere       = poReturnInput.tBchCodeWhere;
        
        var oOptionReturn       = {
            Title : ['ticket/agency/agency', 'tAggTitle'],
            Table:{Master:'TCNMAgency', PK:'FTAgnCode'},
            Join :{
            Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang	: 'ticket/agency/agency',
                ColumnKeyLang	: ['tAggCode', 'tAggName'],
                ColumnsSize     : ['15%', '85%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat : ['', ''],
                Perpage			: 10,
                OrderBy			: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMAgency.FTAgnCode"],
                Text		: [tInputReturnName,"TCNMAgency_L.FTAgnName"],
            },
            NextFunc: {
                FuncName: 'JSvSettingDairyCurrencyLoadTable',
                ArgReturn: []
            },
            RouteAddNew : 'agency',
            BrowseLev : 1,
        }
        return oOptionReturn;
    }
</script>