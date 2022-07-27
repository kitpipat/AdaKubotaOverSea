<!-- LEFT SIDEBAR BUTTON-->

<!-- MENU BUTTON -->
<div style="width:60px;height: 100%;float: left;background-color: #1D2530;position: fixed;z-index: 6000;margin-top: -56px;">
    <div class="xWOdvBtnMenu">
        <button type="button" class="xCNBtnMenuIcoeHader btn-toggle-fullwidth" title="Menu">
            <img src="<?php echo base_url(); ?>application/modules/common/assets/images/icons/menu-50.png" alt="Klorofil Logo" class="img-responsive logo">
        </button>
    </div>

    <?php if(isset($oGrpModules) && !empty($oGrpModules) && is_array($oGrpModules)):?>
        <?php $nFirstMenu = 0; 
            foreach ($oGrpModules as $nKey => $aValGrpModules): ?>
            <?php if($aValGrpModules['FTGmnModStaUse'] == 1):?>
                <div class="xWOdvBtnMenu  <?php echo ($nFirstMenu == 0)? 'xCNBtnFirstMenu' : '';?>  ">
                    <button type="button"  data-menu="<?php echo $aValGrpModules['FTGmnModCode'];?>" class="xCNBtnMenu" title="<?php echo $aValGrpModules['FTGmnModName'];?>">
                        <img src="<?php echo base_url().$aValGrpModules['FTGmmModPathIcon'];?>" alt="Klorofil Logo" class="xCNBtnMenuIcon">
                    </button>
                </div>
            <?php $nFirstMenu++; 
            endif; ?>
        <?php endforeach;?>
    <?php endif;?>


    <!-- ADA-Tool 14/12/2021 -->
    <div class="xWOdvBtnMenu">
    <button type="button" data-menu="AdaTools" class="xCNBtnMenu" title="Toos">
        <img src="<?=base_url('application/modules/common/assets/images/iconsmenu/tool-box-1.png')?>" class="xCNBtnMenuIcon">
    </button>
    </div>
    <!-- ADA-Register 14/12/2021 -->

</div>
<!-- END MENU BUTTON -->

<!-- MENU BAR DATA -->
<div id="sidebar-nav" class="xWMenu sidebar xCNNavShadow">
    <div class="container-fluid xWContainer-fluid">
        <div class="xWHeadMenuList"style="padding: 7px;margin-top: 10px;">
            <a href="">
                <img src="<?php echo base_url();?>application/modules/common/assets/images/logo/AdaLogo.png" alt="Klorofil Logo" class="img-responsive logoAda">
            </a>
        </div>
        <div class="xWLineHeadMenuList"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label id="olbTitleMenuModules" class="xCNTitleMenuModules">-</label>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
                <input class="form-control xWinputSearchmenu" type="text" id="oetMenSearch" name="oetMenSearch" placeholder="Search Menu" style="margin:0px;">
            </div>
        </div>
    </div>
    <div class="sidebar-scroll">
    <ul class="nav get-menu xCNMenuListFAV" style="display:none;">
    
    <?php foreach($aMenuFav AS $nKey => $aValueFav){ ?>
        
        <li class="treeview-item xCNMenuItem "  > 
            <a data-mnrname="<?php echo trim($aValueFav->FavMnuRoute);?>" data-toggle="collapse" class="collapsed xWLiSubmenu">					
                <span style="margin-left:-27px;"><?php echo trim($aValueFav->FavMfvName);?></span> 
            </a>
        </li>
    <?php } ?>
    </ul>
        <?php $tGmnModCode = ''; ?>
        <?php $nI = 0; ?>
        <?php if(is_array($oMenuList)): ?>

            <?php foreach($oMenuList AS $nKey => $oValueModule){ ?>
                
                <?php if ($tGmnModCode != $oValueModule->FTGmnModCode){ ?>
                    <?php $tGmnModCode = $oValueModule->FTGmnModCode; ?>
                        <nav id="oNavMenu<?php echo $tGmnModCode?>" class="xCNMargintop10 xCNMenuList <?php echo $nI != 0 ? 'xCNHide' : ''; ?>">
                            <ul class="nav">
                                <li class="treeview">
                                    <?php if ($oValueModule->FTGmnCode != ''): ?>
                                        <!-- <a href="#FOLDER<?php echo $oValueModule->FTGmnCode ?>" data-toggle="collapse" class="collapsed">
                                            <i class="icon-submenu fa fa-plus"></i> <span><?php echo $oValueModule->FTGmnModName ?></span>
                                        </a> -->
                                    <?php else: ?>
                                        <ul class="nav get-menu">
                                            <li>
                                                <a href="<?php echo $oValueModule->FTMnuCtlName ?>" >
                                                    <span><?php echo $oValueModule->FTGmnModName ?></span>
                                                </a>
                                            </li>
                                        </ul>
                                    <?php endif; ?>
                                    <ul>
                                    <?php $tGrpMen = ''; ?>
                                    <?php foreach ($oMenuList as $oValue): ?>
                                        <?php if ($tGrpMen != $oValue->FTGmnCode && $tGmnModCode == $oValue->FTGmnModCode): ?>
                                            <?php $tGrpMen = $oValue->FTGmnCode; ?>
                                            <li class="treeview">

                                                <?php if ($oValue->FTGmnName == ''): ?>

                                                    <?php foreach ($oMenuList as $oValue2): ?>
                                                        <?php //echo $oValue2->FTGmnCode."-".$oValue->FTGmnCode;	?>
                                                        <?php if ($oValue2->FTGmnCode == $oValue->FTGmnCode): ?>	
                                                            <ul class="nav get-menu">
                                                                <li class="treeview-item xCNMenuItem">
                                                                    <a data-mnrname="<?php echo trim($oValue2->FTMnuCtlName);?>" data-toggle="collapse" class="collapsed xWLiSubmenu">					
                                                                        <span style="margin-left:-27px;"><?php echo $oValue2->FTMnuName ?></span> 
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        <?php endif; ?>              
                                                    <?php endforeach; ?>

                                                <?php else: ?>

                                                    <a href="#<?php echo $tGmnModCode . $oValue->FTGmnCode ?>" data-toggle="collapse" class="collapsed xWLiSubmenu">												
                                                        <i class="icon-submenu fa fa-plus"></i> <span><?php echo $oValue->FTGmnName ?></span> 
                                                    </a>
                                                    <!-- <a href="javascript:void(0)" class="xWSidebar-a"><label class="xCNMenuLabel"><?php echo $oValue->FTGmnName ?></label><span class="fa arrow"></span></a> -->
                                                    <div id="<?php echo $tGmnModCode . $oValue->FTGmnCode ?>" class="collapse ">
                                                        <ul class="nav get-menu">
                                                            <?php foreach ($oMenuList as $oValue2): ?>
                                                                <?php if ($oValue2->FTGmnCode == $oValue->FTGmnCode && $tGmnModCode == $oValue2->FTGmnModCode): ?>
                                                                    <?php //if ($oValue2->FTAutStaRead == '1'):?>                   
                                                                    <li class="treeview-item xCNMenuItem">
                                                                        <a data-mnrname="<?php echo trim($oValue2->FTMnuCtlName);?>"> <?php echo $oValue2->FTMnuName; ?></a>
                                                                    </li>
                                                                    <?php //endif;?>              
                                                                <?php endif; ?>              
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                <?php endif; ?>

                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?> 
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                <?php } ?>
            <?php $nI++ ?>

            <?php } ?>
            <nav id="oNavMenuAdaTools" class="xCNMargintop10 xCNMenuList">
                    <ul class="nav get-menu xCNMenuAdaTools" style="display:block;">
                    <?php if($this->session->userdata("nSesUsrRoleLevel")=='99'){ ?>
                        <li class="treeview-item xCNMenuItem">
                            <a data-mnrname="tool" data-toggle="collapse" class="collapsed xWLiSubmenu">
                                <span style="margin-left:-27px;"><?php echo language('tool/tool/tool','tToolTitle');?></span>
                            </a>
                        </li>
                        <?php } ?>
                        <li class="treeview-item xCNMenuItem">
                            <a data-mnrname="logDRG" data-toggle="collapse" class="collapsed xWLiSubmenu">
                                <span style="margin-left:-27px;"><?php echo language('tool/tool/tool','tLogGenRnn');?></span>
                            </a>
                        </li>
                    </ul>
                </nav>
        <?php else: ?>
            <li class="treeview">
                <a data-toggle="collapse" class="collapsed"></a>
            </li>
        <?php endif; ?>

    </div>
</div>


<input type="hidden" id="oetTextComfirmDeleteSingle"    name='oetTextComfirmDeleteSingle'   value="<?php echo language('common/main/main','tModalDeleteSingle');?>">
<input type="hidden" id="oetTextComfirmDeleteMulti"     name='oetTextComfirmDeleteMulti'    value="<?php echo language('common/main/main','tModalDeleteMulti');?>">
<input type="hidden" id="oetTextComfirmDeleteYesOrNot"  name='oetTextComfirmDeleteYesOrNot' value="<?php echo language('common/main/main','tModalDeleteYesOrNot');?>">
<input type="hidden" id="oetNotFoundDataInDB"           name='oetNotFoundDataInDB'          value="<?php echo language('common/main/main','tMainRptNotFoundDataInDB');?>">
<input type="hidden" id="oetAllBusGroup"           name='oetAllBusGroup'          value="<?php echo language('common/main/main','tAllbusgroup');?>">
<input type="hidden" id="oetAllShopVending"           name='oetAllShopVending'          value="<?php echo language('common/main/main','tAllstores');?>">
<!-- END LEFT SIDEBAR -->

