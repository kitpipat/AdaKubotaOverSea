<input type="hidden" id="ohdRptGrpMod"          value="<?php echo $tRptGrpMod;?>">
<input type="hidden" id="ohdRptBrowseType"      value="<?php echo $nRptBrowseType;?>">
<input type="hidden" id="ohdRptBrowseOption"    value="<?php echo $tRptBrowseOption;?>">

<!-- Title Bar Menu Report -->
<div id="odvRptMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <ol id="oliMenuNav" class="breadcrumb xCNBCMenu">
                    <?php
                        switch($tRptGrpMod){
                            case 001:
                                FCNxHADDfavorite('rptReport/001/0/0');
                            break;
                            case 002:
                                FCNxHADDfavorite('rptReport/002/0/0');
                            break;
                            case 003:
                                FCNxHADDfavorite('rptReport/003/0/0');
                            break;
                            case 004:
                                FCNxHADDfavorite('rptReport/004/0/0');
                            break;
                            case 005:
                                FCNxHADDfavorite('rptReport/005/0/0');
                            break;
                        }
                    ?>
                    <li id="oliRptTitle"><?php echo language('report/report/report','tMenuTitleRpt'.$tRptGrpMod);?></li>
                </ol>
            </div>
        </div>    
    </div>
</div>
<!-- Menu Cump Report -->
<div class="xCNMenuCump xCNRptBrowseLine" id="odvMenuCump">&nbsp;</div>

<!-- Div Content Report -->
<div class="main-content">
    <div id="odvContentPageRpt"></div>
</div>
<script type="text/javascript" src="<?php echo base_url();?>application/modules/report/assets/src/report/jReport.js"></script>




