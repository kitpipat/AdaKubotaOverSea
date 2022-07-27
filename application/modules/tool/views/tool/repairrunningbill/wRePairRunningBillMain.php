<style>
    .xWSMTSALHeadPanel{
        /* border-bottom:1px solid #cfcbcb8a !important; */
        padding-bottom:0px !important;
    }

    .xWSMTSALTextNumber{
        font-size: 25px !important;
        font-weight: bold;
    }
    
    .xWSMTSALPanelMainRight{
        padding-bottom:0px;
        /* min-height:300px; */
        overflow-x: auto;
    }

    .xWRpRn{
        cursor: pointer;
    }

    .xWSMTSALRequest{
        cursor: pointer;
    }
    .xWOverlayLodingChart{
        position: absolute;
	    min-width: 100%;
	    min-height: 100%;
	    width: 100%;
	    background: #FFFFFF;
	    z-index: 2500;
	    display: none;
	    top: 0%;
        margin-left: 0px;
        left: 0%;
    }
</style>
<?php
$dDateToday         = date("Y-m-d");
$dFirstDateOfMonth  = $dDateToday;
$dLastDateOfMonth   = $dDateToday;
?>
<div class="row">
  
    <form id="ofmRepirRunningFrm" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <!-- input ค่า sort กับ ฟิวช์ ที่ส่งไป query ของ Total By Branch -->
    <input type="hidden" id="oetDSHSALSort" name="oetDSHSALSort" value="DESC">
    <input type="hidden" id="oetDSHSALFild" name="oetDSHSALFild" value="FDCreateOn">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <!-- Panel Sale Data -->
        <div id="odvSMTSALPanelRight1" class="">
            <div >
                <div class="panel-body xWSMTSALPanelMainRight">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="">
                                <div class="col-md-12 xWSMTSALHeadPanel">
                                    <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 p-l-0">
                               
                                        <div class="col-xs-12 col-sm-8 col-md-12 col-lg-12 " style="padding:0px;margin-top:0.3rem; ">

                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 p-l-0">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm" style="margin-right: 10px; margin-top: 5px;"><?php echo language('tool/tool/tool','tSMTSALModalBranch'); ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control xCNHide" id="oetRpRnBchStaAll" name="oetRpRnBchStaAll">
                                                    <input type="text" class="form-control xCNHide" id="oetRpRnBchCode" name="oetRpRnBchCode">
                                                    <input type="text" class="form-control xWPointerEventNone" id="oetRpRnBchName" name="oetRpRnBchName" readonly>
                                                    <span class="input-group-btn">
                                                    <button id="obtRpRnSALFilterBch" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 p-l-0">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm" style="margin-right: 10px; margin-top: 5px;"><?php echo language('tool/tool/tool','tSMTSALModalPos'); ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control xCNHide" id="oetRpRnPosStaAll" name="oetRpRnPosStaAll">
                                                    <input type="text" class="form-control xCNHide" id="oetRpRnPosCode" name="oetRpRnPosCode">
                                                    <input type="text" class="form-control xWPointerEventNone" id="oetRpRnPosName" name="oetRpRnPosName" readonly>
                                                    <span class="input-group-btn">
                                                    <button id="obtRpRnBrowsPos" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 p-l-0">
                                            <div class="form-group">
                                            <label class="xCNLabelFrm" style="margin-right: 10px; margin-top: 5px;"><?php echo language('tool/tool/tool','tToolStatDate'); ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-center xCNDatePicker xWPointerEventNone" id="oetRpRnDateDataForm" name="oetRpRnDateDataForm" value="<?php echo @$dFirstDateOfMonth; ?>">
                                                    <span class="input-group-btn">
                                                        <button id="obtRpRnDateDataForm" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconCalendar"></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 p-l-0">
                                            <div class="form-group">
                                            <label class="xCNLabelFrm" style="margin-left: 10px;  margin-right: 10px; margin-top: 5px;"><?php echo language('tool/tool/tool','tToolToDate'); ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-center xCNDatePicker xWPointerEventNone" id="oetRpRnDateDataTo" name="oetRpRnDateDataTo" value="<?php echo @$dLastDateOfMonth; ?>">
                                                    <span class="input-group-btn">
                                                        <button id="obtRpRnDateDataTo" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconCalendar"></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                         
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 p-l-0">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm" style="margin-right: 10px; margin-top: 5px;"><?php echo language('tool/tool/tool','tSMTSALModalBill'); ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control xWPointerEventNone" id="oetRpRnDocNo" name="oetRpRnDocNo" readonly>
                                                    <span class="input-group-btn">
                                                    <button id="obtRpRnBrowsDocNo" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 p-l-0" >
                                            <div class="form-group">
                                            <label class="xCNLabelFrm" style="margin-left: 10px;  margin-right: 10px; margin-top: 5px;"><?php echo language('tool/tool/tool','tRPNBillType');?></label>
                                                <select class="selectpicker form-control" id="ocmRpRnBillType" name="ocmRpRnBillType" maxlength="1" >
                                                    <!-- <option value="" selected><?php echo language('tool/tool/tool','tRPNBillType0');?></option> -->
                                                    <option value="1" selected ><?php echo language('tool/tool/tool','tRPNBillType1');?></option>
                                                    <option value="9" ><?php echo language('tool/tool/tool','tRPNBillType2');?></option>
                                                </select>
                                            </div>
                                        </div>


                         
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 p-l-0">
                                            <div class="form-group" >
                                            <label class="xCNLabelFrm" style="margin-right: 10px; margin-top: 5px;"><?php echo language('tool/tool/tool','tSMTSALModalBillStratBill'); ?></label>
                                            <input type="number" class="form-control text-right " style="height: 37px;" id="oetRpRnNumberFirst" name="oetRpRnNumberFirst" value="1" readonly>
                                            </div>    
                                        </div>

                                        <!-- <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 " style="margin-top: 26px;" align="right">   
                                                   
                                               
                                        </div> -->

                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 " style="margin-top: 26px;" align="right">   
                                                    <button type="button" id="obtRpRnReload" class="btn btn-primary" style="width:100%"  >
                                                        <span><?=language('tool/tool/tool', 'tSTLToolsPreView')?></span>			
                                                    </button>
                                               
                                        </div>

                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 " style="margin-top: 26px;" align="right">   
                                                <button type="button" id="obtRpRnSaleRepair" class="btn btn-success"  disabled  style="width:100%" >
                                                            <span><?=language('tool/tool/tool', 'tSTLToolsConfirm')?></span>		
                                                </button>
                                        </div>


                                        </div>
                                    </div>

                            
                                        
                                    </div>
                                </div>

                                

                                <div class="col-md-12 xWSMTSALDataPanel"  id="odvPanelRepairRunningDataTable" >
                            
                                </div>
                                <div class="xWOverlayLodingChart" data-keyfilter="FSD">
                                    <img src="<?php echo base_url(); ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

 
    </div>
</form>
</div>
<div id="odvSMTSALModalFilterHTML"></div>
<script type="text/javascript">
    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
    $(document).ready(function(){

        
        $('.selectpicker').selectpicker('refresh');
        $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            disableTouchKeyboard : true,
            autoclose: true
        });

        // Event Click Button Filter Date Data Form
        $('#obtRpRnDateDataForm').unbind().click(function(){
            $('#oetRpRnDateDataForm').datepicker('show');
        });

        // Event Click Button Filter Date Data To
        $('#obtRpRnDateDataTo').unbind().click(function(){
            $('#oetRpRnDateDataTo').datepicker('show');
        });


        // $('#oetRpRnDateDataForm').change(function(){
        //     JCNxOpenLoading();
        //     JCNxATLRePairRunningBillDataTable();
        // });

        // $('#oetRpRnDateDataTo').change(function(){
        //     JCNxOpenLoading();
        //     JCNxATLRePairRunningBillDataTable();
        // });





        $('#ocbSMTRequestRepairing').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
            JSxSMTControlTableData();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#ocbSMTDataRequest').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
            JSxSMTControlTableData();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });


        $('#ocbSMTInformationShitf').unbind().click(function(){
            // let nStaSession = JCNxFuncChkSessionExpired();
            // if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
            JSxSMTControlTableData();
            // }else{
            //     JCNxShowMsgSessionExpired();
            // }
         
        });

        JCNxATLRePairRunningBillDataTable();
      
        $('.filter-option-inner-inner').css('margin-top','-2px');
    });

    $('#ocmRpRnBillStaRun').on('change',function(){
        JCNxOpenLoading();
        JCNxATLRePairRunningBillDataTable();
    });

    $('#obtRpRnReload').click(function(){
           JCNxOpenLoading();
            JCNxATLRePairRunningBillDataTable();
    });

    $('.xWRpRn').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                let tFilterDataKey  = $(this).data('keyfilter');
                let tFilterDataGrp  = $(this).data('keygrp');
                JSvSMTSALCallModalFilterDashBoard(tFilterDataKey,tFilterDataGrp);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtRpRnSaleRepair').click(function(){
        if(confirm('<?=language('tool/tool/tool', 'tSTLToolsConfirmRepairRunning')?>')==true){
            JCNxOpenLoading();

            var tRpRnDocUUID = $('#oetRpRnDocUUID').val();
            $.ajax({
                    type: "POST",
                    url: "toolRePairRunningBillCallMQPrc",
                    data: {
                        tRpRnDocUUID:tRpRnDocUUID
                    },
                    cache: false,
                    timeout: 0,
                    success : function(paDataReturn){
                        var paDataReturn = JSON.parse(paDataReturn);
                    
                        if(paDataReturn['nStaEvent']==1){
                            setTimeout(() => {
                                JCNxCloseLoading();
                                FSvCMNSetMsgSucessDialog('<?=language('tool/tool/tool', 'tToolMassageSuccess')?>');
                                // JCNxATLRePairRunningBillDataTable();
                            }, 5000);

                        }else{
                            FSvCMNSetMsgWarningDialog(paDataReturn['tStaMessg']);
                            JCNxCloseLoading();
                        }
                    },
                    error : function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR,textStatus,errorThrown);
                    }
                });

        }
});




        // Event Click Browse Multi Branch
        $('#obtRpRnSALFilterBch').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                var nSesUsrBchCount = "<?=$this->session->userdata('nSesUsrBchCount')?>";
                                // ********** Check Data Branch **********
                let tTextWhereInBranch      = '';
                if(nSesUsrBchCount > 0){
                    var tDataBranch = "<?=$this->session->userdata('tSesUsrBchCodeMulti')?>";
                    tTextWhereInBranch      = " AND (TCNMBranch.FTBchCode IN ("+tDataBranch+") )";
                }

                window.oSMTSALBrowseBchOption   = undefined;
                oSMTSALBrowseBchOption          = {
                    Title   : ['company/branch/branch','tBCHTitle'],
                    Table   : {Master:'TCNMBranch',PK:'FTBchCode'},
                    Join    : {
                        Table   : ['TCNMBranch_L'],
                        On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
                    },
                    Where :{
                        Condition : [tTextWhereInBranch]
                    },
                    GrideView:{
                        ColumnPathLang  	: 'company/branch/branch',
                        ColumnKeyLang	    : ['tBCHCode','tBCHName'],
                        ColumnsSize         : ['15%','75%'],
                        WidthModal          : 50,
                        DataColumns		    : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                        DataColumnsFormat   : ['',''],
                        Perpage			: 10,
                        OrderBy			    : ['TCNMBranch_L.FTBchCode ASC'],
                    },
                    NextFunc:{
                        FuncName:'JSxRpRnSetBrowsBch',
                        ArgReturn:['FTBchCode']
                    },
                    CallBack:{
                        ReturnType	: 'S',
                        Value		: ['oetRpRnBchCode','TCNMBranch.FTBchCode'],
                        Text		: ['oetRpRnBchName','TCNMBranch_L.FTBchName']
                    },
           
                };
                JCNxBrowseData('oSMTSALBrowseBchOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });



        // Event Click Browse Multi Pos
        $('#obtRpRnBrowsPos').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                var tFilterBchCode = $('#oetRpRnBchCode').val();
                var tFilterBchCodeWhere =tFilterBchCode;
                if(tFilterBchCodeWhere!=''){
                  var tConditionWhere = " AND TCNMPos.FTBchCode = '"+tFilterBchCodeWhere+"' ";
                }else{
                    var tConditionWhere = "";
                }
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oSMTSALBrowsePosOption   = undefined;
                oSMTSALBrowsePosOption          = {
                    Title       : ["pos/salemachine/salemachine","tPOSTitle"],
                    Table       : { Master:'TCNMPos', PK:'FTPosCode'},
                    Join    : {
                        Table   : ['TCNMPos_L'],
                        On      : [
                            'TCNMPos.FTPosCode = TCNMPos_L.FTPosCode AND TCNMPos.FTBchCode = TCNMPos_L.FTbchCode AND TCNMPos_L.FNLngID = '+nLangEdits
                        ]
                    },
                    Where   : {
                        Condition : [tConditionWhere]
                    },
                    GrideView   : {
                        ColumnPathLang  : 'pos/salemachine/salemachine',
                        ColumnKeyLang   : ['tPOSCode','tPOSRegNo'],
                        ColumnsSize     : ['10%','80%'],
                        WidthModal      : 50,
                        DataColumns     : ["TCNMPos.FTPosCode","TCNMPos_L.FTPosName"],
                        DataColumnsFormat : ['',''],
                        Perpage			: 10,
                        OrderBy         : ['TCNMPos.FTPosCode ASC'],
                    },
                    NextFunc:{
                        FuncName:'JSxRpRnSetBrowsPos',
                        ArgReturn:['FTPosCode']
                    },
                    CallBack    : {
                        ReturnType	: 'S',
                        Value       : ['oetRpRnPosCode',"TCNMPos.FTPosCode"],
                        Text        : ['oetRpRnPosName',"TCNMPos_L.FTPosName"]
                    }
                };
                JCNxBrowseData('oSMTSALBrowsePosOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });




                // Event Click Browse Multi Branch
     $('#obtRpRnBrowsDocNo').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                var tRpRnBchCode = $('#oetRpRnBchCode').val();
                                // ********** Check Data Branch **********
                let tTextWhere      = '';

                if(tRpRnBchCode != ''){
                    tTextWhere      = ' AND (TPSTSalHD.FTBchCode = "'+tRpRnBchCode+'" )';
                }

                var tRpRnPosCode = $('#oetRpRnPosCode').val();
                if(tRpRnPosCode != ''){
                    tTextWhere      = ' AND (TPSTSalHD.FTPosCode = "'+tRpRnPosCode+'" )';
                }

                var dRpRnDateDataForm = $('#oetRpRnDateDataForm').val();
                var dRpRnDateDataTo = $('#oetRpRnDateDataTo').val();
                if(dRpRnDateDataForm != '' &&  dRpRnDateDataTo!=''){
                    tTextWhere      = " AND CONVERT (DATE, TPSTSalHD.FDXshDocDate, 103) BETWEEN '"+dRpRnDateDataForm+"' AND '"+dRpRnDateDataTo+"' ";
                }
          
           

                window.oSMTSALBrowseBchOption   = undefined;
                oSMTSALBrowseBchOption          = {
                    Title   : ['tool/tool/tool','tSMTSALModalBillSal'],
                    Table   : {Master:'TPSTSalHD',PK:'FTXshDocNo'},
                    Where :{
                        Condition : [tTextWhere]
                    },
                    GrideView:{
                        ColumnPathLang  	: 'tool/tool/tool',
                        ColumnKeyLang	    : ['tToolDocDate','tToolDocNo'],
                        ColumnsSize         : ['25%','65%'],
                        WidthModal          : 50,
                        DataColumns		    : ['TPSTSalHD.FDXshDocDate','TPSTSalHD.FTXshDocNo'],
                        DataColumnsFormat   : ['',''],
                        Perpage			: 10,
                        OrderBy			    : ['TPSTSalHD.FDXshDocDate ASC'],
                    },
                    CallBack:{
                        ReturnType	: 'S',
                        Value		: ['oetRpRnDocNo','TPSTSalHD.FTXshDocNo'],
                        Text		: ['oetRpRnDocNo','TPSTSalHD.FTXshDocNo']
                    },
           
                };
                JCNxBrowseData('oSMTSALBrowseBchOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });


        function JSxRpRnSetBrowsPos(ptParam){
            // var aParam = JSON.parse(ptParam);
      
            // console.log(aParam);
            if(ptParam!='NULL'){
                $('#oetRpRnNumberFirst').attr('readonly',false);
                $('#obtRpRnBrowsDocNo').attr('disabled',false);
            }else{
                $('#oetRpRnNumberFirst').attr('readonly',true); 
                $('#obtRpRnBrowsDocNo').attr('disabled',true); 
                $('#oetRpRnDocNo').val('');    
            }
        }

        function JSxRpRnSetBrowsBch(ptParam){
            $('#oetRpRnPosCode').val('');
            $('#oetRpRnPosName').val('');
            $('#oetRpRnNumberFirst').attr('readonly',true);
        }
</script>
