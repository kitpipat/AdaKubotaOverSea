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

    .xWDRG{
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
  
    <form id="ofmDRGFrm" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
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
                                                    <input type="text" class="form-control xCNHide" id="oetDRGBchStaAll" name="oetDRGBchStaAll">
                                                    <input type="text" class="form-control xCNHide" id="oetDRGBchCode" name="oetDRGBchCode" value="">
                                                    <input type="text" class="form-control xWPointerEventNone" id="oetDRGBchName" name="oetDRGBchName" value="" readonly>
                                                    <span class="input-group-btn">
                                                    <button id="obtDRGSALFilterBch" type="button" class="btn xCNBtnBrowseAddOn"
                                                    <?php if($this->session->userdata("nSesUsrBchCount")=='1'){ echo 'disabled'; } ?>
                                                    ><img class="xCNIconFind"></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 p-l-0">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm" style="margin-right: 10px; margin-top: 5px;"><?php echo language('tool/tool/tool','tSMTSALModalPos'); ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control xCNHide" id="oetDRGPosStaAll" name="oetDRGPosStaAll">
                                                    <input type="text" class="form-control xCNHide" id="oetDRGPosCode" name="oetDRGPosCode" >
                                                    <input type="text" class="form-control xWPointerEventNone" id="oetDRGPosName" name="oetDRGPosName" readonly>
                                                    <span class="input-group-btn">
                                                    <button id="obtDRGBrowsPos" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 p-l-0">
                                            <div class="form-group">
                                            <label class="xCNLabelFrm" style="margin-right: 10px; margin-top: 5px;"><?php echo language('tool/tool/tool','tToolStatDate'); ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-center xCNDatePicker xWPointerEventNone" id="oetDRGDataForm" name="oetDRGDataForm" value="<?php echo @$dFirstDateOfMonth; ?>">
                                                    <span class="input-group-btn">
                                                        <button id="obtDRGDataForm" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconCalendar"></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 p-l-0">
                                            <div class="form-group">
                                            <label class="xCNLabelFrm" style="margin-left: 10px;  margin-right: 10px; margin-top: 5px;"><?php echo language('tool/tool/tool','tToolToDate'); ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-center xCNDatePicker xWPointerEventNone" id="oetDRGDataTo" name="oetDRGDataTo" value="<?php echo @$dLastDateOfMonth; ?>">
                                                    <span class="input-group-btn">
                                                        <button id="obtDRGDataTo" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconCalendar"></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                         


                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 p-l-0">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm" style="margin-right: 10px; margin-top: 5px;"><?php echo language('tool/tool/tool','tlogDRGUUIDFrm'); ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control xWPointerEventNone" id="oetDRGUUIDFrm" name="oetDRGUUIDFrm" readonly>
                                                    <span class="input-group-btn">
                                                    <button id="obtDRGUUIDFrm" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 p-l-0">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm" style="margin-right: 10px; margin-top: 5px;"><?php echo language('tool/tool/tool','tlogDRGUUIDTo'); ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control xWPointerEventNone" id="oetDRGUUIDTo" name="oetDRGUUIDTo" readonly>
                                                    <span class="input-group-btn">
                                                    <button id="obtDRGUUIDTo" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 p-l-0" >
                                            <div class="form-group">
                                            <label class="xCNLabelFrm" style="margin-left: 10px;  margin-right: 10px; margin-top: 5px;"><?php echo language('tool/tool/tool','tRPNBillType');?></label>
                                                <select class="selectpicker form-control" id="oetDRGBillType" name="oetDRGBillType" maxlength="1" >
                                                    <option value="" selected><?php echo language('tool/tool/tool','tRPNBillType0');?></option>
                                                    <option value="1" ><?php echo language('tool/tool/tool','tRPNBillType1');?></option>
                                                    <option value="9" ><?php echo language('tool/tool/tool','tRPNBillType2');?></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 p-l-0">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm" style="margin-right: 10px; margin-top: 5px;"><?php echo language('tool/tool/tool','tlogDRGDocNo'); ?></label>
                                                    <input type="text" class="form-control" id="oetDRGDocNoOld" name="oetDRGDocNoOld" >
                                            </div>
                                        </div>
                                        


                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 " style="margin-top: 26px;">   
                                                    <button type="button" id="obtDRGReload" class="btn btn-primary" style="width:100%" >
                                                        <span><?=language('tool/tool/tool', 'tSTLToolsPreView')?></span>			
                                                    </button>
                                        </div>

                                        </div>
                                    </div>

                            
                                        
                                    </div>
                                </div>

                                

                                <div class="col-md-12 xWSMTSALDataPanel"  id="odvPanelDRGData" >
                            
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
        $('#obtDRGDataForm').unbind().click(function(){
            $('#oetDRGDataForm').datepicker('show');
        });

        // Event Click Button Filter Date Data To
        $('#obtDRGDataTo').unbind().click(function(){
            $('#oetDRGDataTo').datepicker('show');
        });


        // $('#oetDRGDataForm').change(function(){
        //     JCNxOpenLoading();
        //     JCNxDRGDataTable();
        // });

        // $('#oetDRGDataTo').change(function(){
        //     JCNxOpenLoading();
        //     JCNxDRGDataTable();
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

        JCNxDRGDataTable();
      
        $('.filter-option-inner-inner').css('margin-top','-2px');
    });

    $('#ocmDRGBillStaRun').on('change',function(){
        JCNxOpenLoading();
        JCNxDRGDataTable();
    });

    $('#obtDRGReload').click(function(){
           JCNxOpenLoading();
            JCNxDRGDataTable();
    });

    $('.xWDRG').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                let tFilterDataKey  = $(this).data('keyfilter');
                let tFilterDataGrp  = $(this).data('keygrp');
                JSvSMTSALCallModalFilterDashBoard(tFilterDataKey,tFilterDataGrp);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });





        // Event Click Browse Multi Branch
        $('#obtDRGSALFilterBch').unbind().click(function(){
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
                        FuncName:'JSxDRGSetBrowsBch',
                        ArgReturn:['FTBchCode']
                    },
                    CallBack:{
                        ReturnType	: 'S',
                        Value		: ['oetDRGBchCode','TCNMBranch.FTBchCode'],
                        Text		: ['oetDRGBchName','TCNMBranch_L.FTBchName']
                    },
           
                };
                JCNxBrowseData('oSMTSALBrowseBchOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });



        // Event Click Browse Multi Pos
        $('#obtDRGBrowsPos').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                var tFilterBchCode = $('#oetDRGBchCode').val();
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
                        FuncName:'JSxDRGSetBrowsPos',
                        ArgReturn:['FTPosCode']
                    },
                    CallBack    : {
                        ReturnType	: 'S',
                        Value       : ['oetDRGPosCode',"TCNMPos.FTPosCode"],
                        Text        : ['oetDRGPosName',"TCNMPos_L.FTPosName"]
                    }
                };
                JCNxBrowseData('oSMTSALBrowsePosOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });




                // Event Click Browse Multi Branch
                $('#obtDRGUUIDFrm').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                var tDRGBchCode = $('#oetDRGBchCode').val();
                                // ********** Check Data Branch **********
                let tTextWhere      = '';

                // if(tDRGBchCode != ''){
                //     tTextWhere      = ' AND (TLGTDocRegen.FTBchCode = "'+tDRGBchCode+'" )';
                // }

                // var tDRGPosCode = $('#oetDRGPosCode').val();
                // if(tDRGPosCode != ''){
                //     tTextWhere      = ' AND (TLGTDocRegen.FTPosCode = "'+tDRGPosCode+'" )';
                // }

                // var dDRGDataForm = $('#oetDRGDataForm').val();
                // var dDRGDataTo = $('#oetDRGDataTo').val();
                // if(dDRGDataForm != '' &&  dDRGDataTo!=''){
                //     tTextWhere      = " AND CONVERT (DATE, TLGTDocRegen.FDCreateOn, 103) BETWEEN '"+dDRGDataForm+"' AND '"+dDRGDataTo+"' ";
                // }
          
           

                window.oDRGBrowseUUIDOption   = undefined;
                oDRGBrowseUUIDOption          = {
                    Title   : ['tool/tool/tool','UUID'],
                    Table   : {Master:'TLGTDocRegen',PK:'FTLogUUID'},
                    Where :{
                        Condition : [tTextWhere]
                    },
                    GrideView:{
                        ColumnPathLang  	: 'tool/tool/tool',
                        ColumnKeyLang	    : ['tToolDocDate','tlogDRGRefUUID'],
                        ColumnsSize         : ['25%','65%'],
                        WidthModal          : 50,
                        DataColumns		    : ['TLGTDocRegen.FDLastUpdOn','TLGTDocRegen.FTLogUUID'],
                        DistinctField       : [''],
                        DataColumnsFormat   : ['',''],
                        Perpage			: 10,
                        OrderBy			    : ['TLGTDocRegen.FDCreateOn DESC'],
                    },
                    CallBack:{
                        ReturnType	: 'S',
                        Value		: ['oetDRGUUIDFrm','TLGTDocRegen.FTLogUUID'],
                        Text		: ['oetDRGUUIDFrm','TLGTDocRegen.FTLogUUID']
                    },
           
                };
                JCNxBrowseData('oDRGBrowseUUIDOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });



     // Event Click Browse Multi Branch
         $('#obtDRGUUIDTo').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                var tDRGBchCode = $('#oetDRGBchCode').val();
                                // ********** Check Data Branch **********
                let tTextWhere      = '';

                // if(tDRGBchCode != ''){
                //     tTextWhere      = ' AND (TLGTDocRegen.FTBchCode = "'+tDRGBchCode+'" )';
                // }

                // var tDRGPosCode = $('#oetDRGPosCode').val();
                // if(tDRGPosCode != ''){
                //     tTextWhere      = ' AND (TLGTDocRegen.FTPosCode = "'+tDRGPosCode+'" )';
                // }

                // var dDRGDataForm = $('#oetDRGDataForm').val();
                // var dDRGDataTo = $('#oetDRGDataTo').val();
                // if(dDRGDataForm != '' &&  dDRGDataTo!=''){
                //     tTextWhere      = " AND CONVERT (DATE, TLGTDocRegen.FDCreateOn, 103) BETWEEN '"+dDRGDataForm+"' AND '"+dDRGDataTo+"' ";
                // }
          
           

                window.oDRGBrowseUUIDOption   = undefined;
                oDRGBrowseUUIDOption          = {
                    Title   : ['tool/tool/tool','UUID'],
                    Table   : {Master:'TLGTDocRegen',PK:'FTLogUUID'},
                    Where :{
                        Condition : [tTextWhere]
                    },
                    GrideView:{
                        ColumnPathLang  	: 'tool/tool/tool',
                        ColumnKeyLang	    : ['tToolDocDate','tToolDocNo'],
                        ColumnsSize         : ['25%','65%'],
                        WidthModal          : 50,
                        DataColumns		    : ['TLGTDocRegen.FDLastUpdOn','TLGTDocRegen.FTLogUUID'],
                        DistinctField       : [''],
                        DataColumnsFormat   : ['',''],
                        Perpage			: 10,
                        OrderBy			    : ['TLGTDocRegen.FDLastUpdOn DESC'],
                    },
                    CallBack:{
                        ReturnType	: 'S',
                        Value		: ['oetDRGUUIDTo','TLGTDocRegen.FTLogUUID'],
                        Text		: ['oetDRGUUIDTo','TLGTDocRegen.FTLogUUID']
                    },
           
                };
                JCNxBrowseData('oDRGBrowseUUIDOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
        function JSxDRGSetBrowsPos(ptParam){
            // var aParam = JSON.parse(ptParam);
      
            // console.log(aParam);
            if(ptParam!='NULL'){
                $('#oetDRGNumberFirst').attr('readonly',false);
            }else{
                $('#oetDRGNumberFirst').attr('readonly',true);      
            }
        }

        function JSxDRGSetBrowsBch(ptParam){
            $('#oetDRGPosCode').val('');
            $('#oetDRGPosName').val('');
            $('#oetDRGNumberFirst').attr('readonly',true);
        }
</script>
