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
    <input type="hidden" id="oetDSHSALSort" name="oetDSHSALSort" value="">
    <input type="hidden" id="oetDSHSALFild" name="oetDSHSALFild" value="FTBchName,FTPosCode">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <!-- Panel Sale Data -->
        <div id="odvSMTSALPanelRight1" class="panel panel-default">
            <div >
                <div class="panel-body xWSMTSALPanelMainRight">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel-body" style="padding-bottom:0px;">
                                <div class="col-md-12 xWSMTSALHeadPanel">
                                    <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 p-l-0">

                                    <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1 text-right" style="padding:0px;margin-top:0.3rem;">
                                                <label class="xCNLabelFrm"><?php echo @$aTextLang['tSMTSALDateDataFrom']; ?></label>
                                            </div>
                                            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-r-0 text-right">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control text-center xCNDatePicker xWPointerEventNone" id="oetSMTSALDateDataForm" name="oetSMTSALDateDataForm" value="<?php echo @$dFirstDateOfMonth; ?>">
                                                        <span class="input-group-btn">
                                                            <button id="obtSMTSALDateDataForm" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconCalendar"></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1 text-right" style="padding:0px;margin-top:0.3rem;">
                                                <label class="xCNLabelFrm"><?php echo @$aTextLang['tSMTSALDateDataTo']; ?></label>
                                            </div>
                                            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-r-0 text-right">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control text-center xCNDatePicker xWPointerEventNone" id="oetSMTSALDateDataTo" name="oetSMTSALDateDataTo" value="<?php echo @$dLastDateOfMonth; ?>">
                                                        <span class="input-group-btn">
                                                            <button id="obtSMTSALDateDataTo" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconCalendar"></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-md-1 col-lg-1"  >
                                            <button id="obtSMTReload" class="btn btn-info" type="button">
                                            <i class="fa fa-refresh" aria-hidden="true"></i> &nbsp; <?=language('sale/salemonitor/salemonitor', 'tSMTReload')?>
                                            </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 p-r-0 text-right">
                                                <!-- <i class="fa fa-exchange xWSMTSALRequest" data-bchcode="<?=$this->session->userdata('tSesUsrBchCode')?>" data-poscode="" data-shiftcode="" data-ptype="4" aria-hidden="true" data-keyfilter="FSD" data-keygrp="BCH,SHP,POS"></i> -->
                                                &nbsp;
                                                <i class="fa fa-filter xWSMTSALFilter" aria-hidden="true" data-keyfilter="FSD" data-keygrp="BCH,SHP,POS"></i>
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
    });

    $('#obtSMTReload').click(function(){
           JCNxOpenLoading();
            JCNxSMTCallSaleDataTable();
    });



</script>
