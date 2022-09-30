<!-- Filter -->
<section>
    <div class="col-md-3 col-xs-3 col-sm-3">
        <div class="form-group">
            <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMAdvSearchBranch')?></label>
                <div class="input-group">
                    <input
                        type="text"
                        class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
                        id="oetPAMRefIntBchCode"
                        name="oetPAMRefIntBchCode"
                        maxlength="5"
                        value="<?=$tBCHCode?>"
                        data-bchcodeold = ""
                    >
                    <input
                        type="text"
                        class="form-control xWPointerEventNone"
                        id="oetPAMRefIntBchName"
                        name="oetPAMRefIntBchName"
                        maxlength="100"
                        value="<?=$tBCHName?>"
                        readonly
                    >
                    <input
                        type="hidden"
                        class="form-control xWPointerEventNone"
                        id="oetPAMRefIntRefDoc"
                        name="oetPAMRefIntRefDoc"
                        maxlength="100"
                        value="<?=$tRefDoc?>"

                    >
                    <span class="input-group-btn xWConditionSearchPdt">
                        <button id="obtPAMBrowseBchRefIntDoc" type="button" class="btn xCNBtnBrowseAddOn" >
                            <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- เลขที่เอกสาร -->
    <div class="col-md-2 col-xs-2 col-sm-2">
        <div class="form-group">
            <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOTBDocNo')?></label>
                <input
                    type="text"
                    class="form-control"
                    id="oetPAMRefIntDocNo"
                    name="oetPAMRefIntDocNo"
                    maxlength="100"
                    value=""
                    placeholder="<?php echo language('document/purchaseorder/purchaseorder', 'tPOTBDocNo')?>"
                >
            </div>
        </div>
    </div>
    <!-- วันที่เอกสารเริ่ม -->
    <div class="col-md-2 col-xs-2 col-sm-2">
        <div class="form-group">
            <label class="xCNLabelFrm"><?php echo language('document/document/document', 'tDocDateFrm')?></label>
                    <div class="input-group">
                    <input
                        type="text"
                        class="form-control xCNDatePicker xCNInputMaskDate"
                        id="oetPAMRefIntDocDateFrm"
                        name="oetPAMRefIntDocDateFrm"
                        placeholder="YYYY-MM-DD"
                        value=""
                    >
                    <span class="input-group-btn">
                        <button id="obtPAMBrowseRefExtDocDateFrm" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- วันที่เอกสารสิ้นสุด -->
    <div class="col-md-2 col-xs-2 col-sm-2">
        <div class="form-group">
            <label class="xCNLabelFrm"><?php echo language('document/document/document', 'tDocDateTo')?></label>
                <div class="input-group">
                    <input
                        type="text"
                        class="form-control xCNDatePicker xCNInputMaskDate"
                        id="oetPAMRefIntDocDateTo"
                        name="oetPAMRefIntDocDateTo"
                        placeholder="YYYY-MM-DD"
                        value=""
                    >
                    <span class="input-group-btn">
                        <button id="obtPAMBrowseRefExtDocDateTo" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- สถานะเอกสาร -->
    <div class="col-md-2 col-xs-2 col-sm-2">
        <div class="form-group">
            <label class="xCNLabelFrm"><?php echo language('document/document/document','tDocStaDoc');?></label>
            <select class="selectpicker form-control" id="oetPAMRefIntStaDoc" name="oetPAMRefIntStaDoc" maxlength="1">
                <option value="1" ><?php echo language('document/document/document','tDocStaProApv1');?></option>
                <option value="2" ><?php echo language('document/document/document','tDocStaProApv');?></option>
                <option value="3" ><?php echo language('document/document/document','tDocStaProDoc3');?></option>
            </select>
        </div>
    </div>
    <!-- ปุ่มค้นหา -->
    <div class="col-md-1 col-xs-1 col-sm-1" style="padding-top: 24px;">
        <button id="obtRefIntDocFilter" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" ><?= language('document/document/document', 'tDocFilter')?></button>
    </div>
</section>

<!-- Document -->
<section>
    <div id="odvRefIntDocHDDataTable"></div>
</section>

<!-- Items -->
<section>
    <div id="odvRefIntDocDTDataTable"></div>
</section>

<script>

    $(document).ready(function(){

        $('.selectpicker').selectpicker('refresh');

        $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            disableTouchKeyboard : true,
            autoclose: true
        });

        $('#obtPAMBrowseBchRefIntDoc').click(function(){
            $('#odvPAMModalRefIntDoc').modal('hide');
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                window.oPAMBrowseRefBranchOption  = undefined;
                oPAMBrowseRefBranchOption         = oBranchRefOption({
                    'tReturnInputCode'  : 'oetPAMRefIntBchCode',
                    'tReturnInputName'  : 'oetPAMRefIntBchName',
                    'tNextFuncName'     : 'JSxPAMRefIntNextFunctBrowsBranch',
                    'tAgnCode'          : $('#oetPAMAgnCode').val(),
                    'aArgReturn'        : ['FTBchCode','FTBchName'],
                });
                JCNxBrowseData('oPAMBrowseRefBranchOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // ตัวแปร Option Browse Modal สาขา
        var oBranchRefOption = function(poDataFnc){
            var tInputReturnCode    = poDataFnc.tReturnInputCode;
            var tInputReturnName    = poDataFnc.tReturnInputName;
            var tNextFuncName       = poDataFnc.tNextFuncName;
            var aArgReturn          = poDataFnc.aArgReturn;
            var tAgnCode            = poDataFnc.tAgnCode;
            var nLangEdits      = "<?=$this->session->userdata("tLangEdit")?>";
            tUsrLevel = "<?=$this->session->userdata('tSesUsrLevel')?>";
            tBchMulti = "<?=$this->session->userdata("tSesUsrBchCodeMulti"); ?>";
            tWhere = "";
            if(tUsrLevel != "HQ"){
                tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchMulti+") ";
            }else{
                tWhere = "";
            }

            if(tAgnCode!=''){
                tSQLWhere = " AND TCNMBranch.FTAgnCode ='"+tAgnCode+"' ";
            }

            // ตัวแปร ออฟชั่นในการ Return
            var oOptionReturn       = {
                Title: ['authen/user/user', 'tBrowseBCHTitle'],
                Table: {
                    Master  : 'TCNMBranch',
                    PK      : 'FTBchCode'
                },
                Join :{
                    Table : ['TCNMBranch_L'],
                    On : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
                },
                Where : {
                    Condition : [tWhere]
                },
                GrideView: {
                    ColumnPathLang      : 'authen/user/user',
                    ColumnKeyLang       : ['tBrowseBCHCode', 'tBrowseBCHName'],
                    ColumnsSize         : ['10%', '75%'],
                    DataColumns         : ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                    DataColumnsFormat   : ['', ''],
                    DisabledColumns     : [2,3],
                    WidthModal          : 30,
                    Perpage             : 10,
                    OrderBy             : ['TCNMBranch.FTBchCode'],
                    SourceOrder         : "ASC"
                },
                CallBack: {
                    ReturnType  : 'S',
                    Value       : [tInputReturnCode, "TCNMBranch.FTBchCode"],
                    Text        : [tInputReturnName, "TCNMBranch_L.FTBchName"]
                },
                NextFunc: {
                    FuncName    : tNextFuncName,
                    ArgReturn   : aArgReturn
                },
                RouteAddNew: 'branch',
                BrowseLev: 1
            };
            return oOptionReturn;
        }

        $('#obtPAMBrowseRefExtDocDateFrm').unbind().click(function(){
            $('#oetPAMRefIntDocDateFrm').datepicker('show');
        });

        $('#obtPAMBrowseRefExtDocDateTo').unbind().click(function(){
            $('#oetPAMRefIntDocDateTo').datepicker('show');
        });

        JSxRefIntDocHDDataTable();
    });

    $('#odvPAMModalRefIntDoc').on('hidden.bs.modal', function () {
        $('#wrapper').css('overflow','auto');
        $('#odvPAMModalRefIntDoc').css('overflow','auto');
    });

    $('#odvPAMModalRefIntDoc').on('show.bs.modal', function () {
        $('#wrapper').css('overflow','hidden');
        $('#odvPAMModalRefIntDoc').css('overflow','auto');
    });

    function JSxPAMRefIntNextFunctBrowsBranch(ptData){
        JSxCheckPinMenuClose();
        $('#odvPAMModalRefIntDoc').modal("show");
    }

    $('#obtRefIntDocFilter').on('click',function(){
        JSxRefIntDocHDDataTable();
    });

    //เรียกตารางเลขที่เอกสารอ้างอิง
    function JSxRefIntDocHDDataTable(pnPage){
        if(pnPage == '' || pnPage == null){
            var pnNewPage = 1;
        }else{
            var pnNewPage = pnPage;
        }
        var nPageCurrent = pnNewPage;
        var tPAMRefIntBchCode       = $('#oetPAMRefIntBchCode').val();
        var tPAMRefIntDocNo         = $('#oetPAMRefIntDocNo').val();
        var tPAMRefIntDocDateFrm    = $('#oetPAMRefIntDocDateFrm').val();
        var tPAMRefIntDocDateTo     = $('#oetPAMRefIntDocDateTo').val();
        var tPAMRefIntStaDoc        = $('#oetPAMRefIntStaDoc').val();
        var tPAMRefIntIntRefDoc     = $('#oetPAMRefIntRefDoc').val();
        var tTypeRef                = $("#ocbPAMRefDoc").val();
        if (nPageCurrent==NaN) {
            nPageCurrent = 1;
        }

        $.ajax({
            type: "POST",
            url: "docPAMCallRefIntDocDataTable",
            data: {
                'tPAMRefIntBchCode'     : tPAMRefIntBchCode,
                'tPAMRefIntDocNo'       : tPAMRefIntDocNo,
                'tPAMRefIntDocDateFrm'  : tPAMRefIntDocDateFrm,
                'tPAMRefIntDocDateTo'   : tPAMRefIntDocDateTo,
                'tPAMRefIntStaDoc'      : tPAMRefIntStaDoc,
                'nPAMRefIntPageCurrent' : nPageCurrent,
                'tPAMRefIntIntRefDoc'   : tPAMRefIntIntRefDoc,
                'tTypeRef'              : tTypeRef
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                    $('#odvRefIntDocHDDataTable').html(oResult);
                    JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

</script>

