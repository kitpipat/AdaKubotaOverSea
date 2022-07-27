<input id="oetViaStaBrowse" type="hidden" value="<?=$nViaBrowseType?>">
<input id="oetViaCallBackOption" type="hidden" value="<?=$tViaBrowseOption?>">

<?php if(isset($nViaBrowseType) && $nViaBrowseType == 0) :?>
    <div id="odvViaMainMenu" class="main-menu"> <!-- เปลี่ยน -->
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <ol id="oliMenuNav" class="breadcrumb"> <!-- เปลี่ยน -->
                        <li id="oliViaTitle" class="xCNLinkClick" onclick="JSvCallPageShipViaList()" style="cursor:pointer"><?= language('shipvia/shipvia/shipvia','tVIATitle')?></li> <!-- เปลี่ยน -->
                        <li id="oliViaTitleAdd" class="active"><a><?= language('shipvia/shipvia/shipvia','tVIATitleAdd')?></a></li>
                        <li id="oliViaTitleEdit" class="active"><a><?= language('shipvia/shipvia/shipvia','tVIATitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
                    <div id="odvBtnViaInfo">
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageShipViaAdd()">+</button>
                    </div>
                    <div id="odvBtnAddEdit">
                        <button onclick="JSvCallPageShipViaList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                        <div class="btn-group">
                            <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitShipVia').click()"> <?php echo language('common/main/main', 'tSave')?></button>
                            <?php echo $vBtnSave?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tViaBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPunNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tViaBrowseOption?>')"><a>แสดงข้อมูล : <?php echo language('shipvia/shipvia/shipvia','tVIATitle')?></a></li>
                    <li class="active"><a><?php echo  language('shipvia/shipvia/shipvia','tVIATitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitShipVia').click()"><?php echo  language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNViaBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>

    <div class="main-content">
        <div id="odvContentPageShipVia"></div>
    </div>

<?php endif;?>
<script src="<?php echo base_url('application/modules/shipvia/assets/src/shipvia/jShipVia.js')?>"></script>