
<style>
.custom-tabs-line.tabs-line-bottom .active a {
    font-family: THSarabunNew-Bold;
    font-size: 19px !important;
    line-height: 32px;
    font-weight: 500;
    color: #179bfd !important;
}
.tab-pane {
padding:10px;
}
</style>

    <div id="odvSMTSALMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <ol id="oliSMTSALMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('logDRG');?>
                        <li id="oliSMTSALTitle" style="cursor:pointer;" datenow="<?=date('Y-m-d')?>"><?php echo language('tool/tool/tool', 'tlogDRGTitle');?></li>
                    </ol>
                </div>
            
            </div>
        </div>    
    </div>
    <div class="xCNMenuCump xCNSMTSALBrowseLine" id="odvMenuCump">&nbsp;</div>

    <!-- <div class="main-content">
        <div class="panel panel-headline">
            <div class="row">
                <div class="panel-body" id="odvSMTRePairRunningBill" style="padding-top:20px !important;">
                 
                </div>
            </div>
           
        </div>
    </div> -->




        <div class="main-content">
        <div class="panel panel-headline">
            <div class="row">
                <div class="panel-body" style="padding-top:20px !important;">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="custom-tabs-line tabs-line-bottom left-aligned">
                                    <ul class="nav" role="tablist" data-typetab="main" data-tabtitle="odvSMTSALContentPage">
                                        <li id="oliSMTInfo1" class="xWMenu active">
                                            <a  
                                                role="tab" 
                                                data-toggle="tab" 
                                                data-target="#odvSMTSALContentPage"
                                                onclick="JSvDRGMain()"
                                                aria-expanded="true"><?=language('tool/tool/tool', 'ประวัติการซ่อมเลขที่บิล');?></a>
                                        </li>
                                        <?php if($this->session->userdata("tSesUsrLevel")=='HQ'){ ?>
                                        <li id="oliSMTInfo2" class="xWMenu" data-typetab="main" data-tabtitle="odvSMTMQInformation">
                                            <a 
                                                role="tab" 
                                                data-toggle="tab" 
                                                data-target="#odvSMTMQInformation"
                                                onclick="JSvATLRePairRunningBillMain()"
                                                aria-expanded="false"><?=language('tool/tool/tool', 'ซ่อมเลขที่บิล')?></a>
                                        </li>
                                        <?php } ?>
                                        <!-- <li id="oliSMTInfo3" class="xWMenu" data-typetab="main" data-tabtitle="odvSMTSaleTools">
                                            <a 
                                                role="tab" 
                                                data-toggle="tab" 
                                                data-target="#odvSMTSaleTools"
                                                onclick="JCNxSMTCallSaleTools()"
                                                aria-expanded="false"><?=language('sale/salemonitor/salemonitor', 'tMQITools')?></a>
                                        </li> -->
                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="tab-content">
                    <div id="odvPanelRepairRunningData"  class="tab-pane fade active in"></div>
                    <div id="odvSMTRePairRunningBill"  class="tab-pane fade"></div>
                </div>
            </div>
        </div>
    </div>

<?php 
    include('script/jDocRegen.php');
?>