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

    .xWSMTSALFilter{
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
                               
                                        <div class="col-xs-12 col-sm-8 col-md-12 col-lg-12 text-left" style="padding:0px;margin-top:0.3rem; display: inline-flex;">
                                      
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 p-l-0">
                                            <div class="form-group">
                                            <label class="xCNLabelFrm" style="margin-right: 10px; margin-top: 5px;"><?php echo language('tool/tool/tool','tToolStatDate'); ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-center xCNDatePicker xWPointerEventNone" id="oetSMTSALDateDataForm" name="oetSMTSALDateDataForm" value="<?php echo @$dFirstDateOfMonth; ?>">
                                                    <span class="input-group-btn">
                                                        <button id="obtSMTSALDateDataForm" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconCalendar"></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 p-l-0">
                                            <div class="form-group">
                                            <label class="xCNLabelFrm" style="margin-left: 10px;  margin-right: 10px; margin-top: 5px;"><?php echo language('tool/tool/tool','tToolToDate'); ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-center xCNDatePicker xWPointerEventNone" id="oetSMTSALDateDataTo" name="oetSMTSALDateDataTo" value="<?php echo @$dLastDateOfMonth; ?>">
                                                    <span class="input-group-btn">
                                                        <button id="obtSMTSALDateDataTo" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconCalendar"></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                         
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 p-l-0" >
                                            <div class="form-group">
                                            <label class="xCNLabelFrm" style="margin-left: 10px;  margin-right: 10px; margin-top: 5px;"><?php echo language('tool/tool/tool','tToolStaPrcStk');?></label>
                                                <select class="selectpicker form-control" id="ocmATLDocStaPrcStk" name="ocmATLDocStaPrcStk" maxlength="1" >
                                                    <option value="" ><?php echo language('tool/tool/tool','tToolStaPrcStk0');?></option>
                                                    <option value="1" ><?php echo language('tool/tool/tool','tToolStaPrcStk1');?></option>
                                                    <option value="2" selected><?php echo language('tool/tool/tool','tToolStaPrcStk2');?></option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 " style="padding-top:26px">
                                        <div class="row">
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
                                            <div class="form-group" >
                                                <button id="obtSMTReload" class="btn btn-info" type="button">
                                                    <i class="fa fa-refresh" aria-hidden="true"></i> &nbsp; <?=language('sale/salemonitor/salemonitor', 'tSMTReload')?>
                                                </button>
                                            </div>
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
                                            <div class="form-group" >
                                                <button id="" class="btn btn-info xWSMTSALFilter" type="button" data-keyfilter="FSD" data-keygrp="BCH,SHP,POS">
                                                    <i class="fa fa-filter " aria-hidden="true" ></i>
                                                </button>
                                            </div>
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
                                            <div class="form-group"  >   
                                                <button type="button" id="obtATLSaleRepair" class="btn btn-primary" data-toggle="dropdown" >
                                                    <i class="fa fa-spinner" aria-hidden="true"></i> <?=language('sale/salemonitor/salemonitor', 'tSTLToolsRepair')?>				
                                                </button>
                                            </div>
                                            </div>
                                        </div>
                                        </div>

                                        </div>

                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 p-l-0">
                                            <div class="form-group">
                                                    <label class="fancy-checkbox ">
                                                        <input id="ocbAllBillNotPrcStock" type="checkbox" class="ocbAllBillNotPrcStock" name="ocbAllBillNotPrcStock[]" value="all">
                                                        <span class="">&nbsp;<label class="" ><?php echo language('tool/tool/tool','tToolAllBillNotPrcStock');?></label></span>
                                                    </label>
                                                </div>
                                        </div>
                                        
                                    </div>
                                </div>



                                <div class="col-md-12 xWSMTSALDataPanel"  id="odvPanelSaleData">
                            
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
</div>
<div id="odvSMTSALModalFilterHTML"></div>
<script type="text/javascript">
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
        $('#obtSMTSALDateDataForm').unbind().click(function(){
            $('#oetSMTSALDateDataForm').datepicker('show');
        });

        // Event Click Button Filter Date Data To
        $('#obtSMTSALDateDataTo').unbind().click(function(){
            $('#oetSMTSALDateDataTo').datepicker('show');
        });


        // $('#oetSMTSALDateDataForm').change(function(){
        //     JCNxOpenLoading();
        //     JCNxSMTCallSaleDataTable();
        // });

        $('#oetSMTSALDateDataTo').change(function(){
            JCNxOpenLoading();
            JCNxSMTCallSaleDataTable();
        });





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

        JCNxSMTCallSaleDataTable();
      
        $('.filter-option-inner-inner').css('margin-top','-2px');
    });

    $('#obtSMTReload').click(function(){
           JCNxOpenLoading();
            JCNxSMTCallSaleDataTable();
    });

    $('.xWSMTSALFilter').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                let tFilterDataKey  = $(this).data('keyfilter');
                let tFilterDataGrp  = $(this).data('keygrp');
                JSvSMTSALCallModalFilterDashBoard(tFilterDataKey,tFilterDataGrp);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtATLSaleRepair').click(function(){
        if(confirm('<?=language('tool/tool/tool', 'tSTLToolsConfirmRepair')?>')==true){
            JCNxOpenLoading();
            var oListItem = [];
            var i = 0;
            $(".ocbATLListItem:checkbox:checked").map(function(){
                oListItem[i] = { tBchCode:$(this).data('bchcode') , tDocNo:$(this).val() , tPosCode:$(this).data('poscode') };
                i++;
                }).get(); 
                // console.log(oListItem);
                if($("#ocbListItemAll:checkbox:checked").is(':checked')==true){
                    var nListAll = 1;
                }else{
                    var nListAll = 2;
                }
                
            $.ajax({
                    type: "POST",
                    url: "toolEventRepairStk",
                    data: {
                        oListItem:oListItem,
                        nListAll:nListAll
                    },
                    cache: false,
                    timeout: 0,
                    success : function(paDataReturn){
                        var paDataReturn = JSON.parse(paDataReturn);
                    
                        if(paDataReturn['nStaEvent']==1){
                            setTimeout(() => {
                                JCNxCloseLoading();
                                FSvCMNSetMsgSucessDialog('<?=language('tool/tool/tool', 'tToolMassageSuccess')?>');
                                JCNxSMTCallSaleDataTable();
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
</script>
