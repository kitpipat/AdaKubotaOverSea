<?php
    if(isset($nStaCallView) && $nStaCallView == 1){
        @$tBchCode           =  "";
        @$tBchName           =  "";
        @$tAgnCode           =  $tSesAgnCode;
        @$tAgnName           =  $tSesAgnName;
        $tRoute = "roleEventAdd";
    }else{
        //นับจำนวน ถ้า Count จากตาราง TCNMUsrRoleSpc 
        // ** ถ้า FTAgnCode มากกว่า 1 จะไม่โชว์ แต่ถ้า นับ FTAgnCode มีแค่ 1 ให้โชว
        $tCntRoleCode =   $aDataCountRoleCode['raItems']['counts'];

        if($tCntRoleCode > 1){
            @$tBchCode  = "";    
            @$tBchName  = ""; 
        }else{
            @$tBchCode      = $aDataUsrRoleSpc['raItems']['FTBchCode'];
            @$tBchName      = $aDataUsrRoleSpc['raItems']['FTBchName'];
        }
   
        @$tAgnCode      = $aDataUsrRoleSpc['raItems']['FTAgnCode'];
        @$tAgnName      = $aDataUsrRoleSpc['raItems']['FTAgnName'];
        @$tRoleUsrSpc   = $aDataUsrRoleSpc['raItems']['FTRolCode'];   // Role มาจากตาราง TCNMUsrRoleSpc
        @$tUsrActRole   = $aDataUsrRoleSpc['raItems']['rtUsrActRole']; // Role มาจากตาราง TCNMUsrActRole

        // if(@$tRoleUsrSpc == @$tUsrActRole){
        //     $tDisabled    = 'disabled';  
        //     // Browse ตัวแทนขาย กับ ฺBrowse สาขา ปิด ก็ต่อเมื่อ สิทธิการใช้งานไปผูกกับผู้ใช้
        // }else{
        //     $tDisabled    = '';
        // }

        // print_r($tRoleUsrSpc);
        // print_r($tUsrActRole);

        $tRoute = "roleEventEdit";
    }

    // Check Data Role Main Master
    if(isset($aDataUsrRole) && !empty($aDataUsrRole)){
        $tRoleCode   = $aDataUsrRole['FTRolCode'];
        $tRoleLevel  = $aDataUsrRole['FNRolLevel'];
        $tRoleName   = $aDataUsrRole['FTRolName'];
        $tRoleRmk    = $aDataUsrRole['FTRolRmk'];
        $tImgObjAll  = $aDataUsrRole['rtRoleImgObj'];
    }else{
        $tRoleCode    = "";
        $tRoleLevel   = $this->session->userdata('nSesUsrRoleLevel');
        $tRoleName    = "";
        $tRoleRmk     = "";
        $tImgObjAll   = "";
    }
?>
<style>
    #otbModuleMenuRole thead tr:first-child {
        background-color: #1D2530 !important;
    }

    #otbModuleMenuRole thead tr:first-child th {
        border :0px solid #dee2e6 !important;
       
    }

    .xWwhite{
        color : #FFFFFF !important;
    }

    .xCNDisbledChkBox{
        cursor: not-allowed !important;
    }

    .xCNDisbledChkBox > span{
        cursor: not-allowed !important;
    }

    .xCNDisbledChkBox > span::before{
        background-color: #000000 !important;
        opacity: 0.1 !important;
    }

</style>
<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddEditRole">
    <button class="xCNHide" id="obtRoleAddEditEvent" type="submit" onclick="JSxAddEditRole('<?php echo $tRoute?>')"></button>
    <input type="hidden" id="ohdRoleRouteData" name="ohdRoleRouteData" value="<?php echo $tRoute;?>">
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                <!-- ******************************************************** -->
                <div class="form-group">
                    <div class="odvCompLogo">
                        <?php 
                            if(isset($tImgObjAll) && !empty($tImgObjAll)){
                                
                                $tImgPath  = explode("/application/modules/",$tImgObjAll);

                                $tFullPatch = './application/modules/'.$tImgPath[1]; 


                                if (file_exists($tFullPatch)){
                                    $tPatchImg = base_url().'/application/modules/'.$tImgPath[1];
                                }else{
                                    $tPatchImg = base_url().'application/modules/common/assets/images/300x60.png';
                                }
                            }else{
                                $tPatchImg = base_url().'application/modules/common/assets/images/300x60.png';
                            }
                        ?>
                        <img class="img-responsive xCNImgCenter" id="oimImgMasterRole" src="<?php echo @$tPatchImg;?>">
                    </div>
                    <div class="xCNUplodeImage">
                        <input type="text" class="xCNHide" id="oetImgInputRoleOld" name="oetImgInputRoleOld"  value="<?php echo @$tImgName;?>">
                        <input type="text" class="xCNHide" id="oetImgInputRole" 	name="oetImgInputRole" 	value="<?php echo @$tImgName;?>">
                        <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('','','Role')">
                            <i class="fa fa-picture-o xCNImgButton"></i> <?php echo  language('common/main/main','tSelectPic')?>
                        </button>
                    </div> 
                </div>

                <!-- ******************************************************** -->
                <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('authen/role/role', 'tROLTBCode'); ?></label>
                <?php if(isset($tRoleCode) && empty($tRoleCode)):?>
                    <div id="odvRolAutoGenCodeFrmGrp" class="form-group">
                        <div class="validate-input">
                            <label class="fancy-checkbox xWAutoGenCode ">
                            <input type="checkbox" id="ocbRoleAutoGenCode" name="ocbRoleAutoGenCode" checked="true" value="1">
                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                        </div>
                    </div>
                <?php endif;?>
                <div id="odvRoleCodeFrmGrp" class="form-group">
                    <input type="hidden" id="ohdCheckDuplicateRoleCode" name="ohdCheckDuplicateRoleCode" value="1"> 
                    <div class="validate-input">
                        <input
                            type="text"
                            class="form-control xCNGenarateCodeTextInputValidate" 
                            maxlength="5"
                            id="oetRolCode" 
                            name="oetRolCode"
                            value="<?php echo @$tRoleCode;?>"
                            data-is-created=""
                            placeholder="<?php echo language('authen/role/role','tROLTBCode');?>"
                            data-validate-required= "<?php echo language('authen/role/role', 'tRoleValiCode');?>"
                            data-validate-dublicateCode="<?php echo language('authen/role/role','tRoleValidCodeDup');?>"
                        >
                    </div>
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('authen/role/role','tROLTBName');?></label>
                    <input 
                        type="text"
                        class="form-control"
                        maxlength="200"
                        id="oetRolName"
                        name="oetRolName"
                        value="<?php echo @$tRoleName;?>"
                        placeholder="<?php echo language('authen/role/role','tROLTBName');?>" autocomplete="off"
                        data-validate-required="<?php echo language('authen/role/role','tRoleValiName')?>"
                    >
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('authen/role/role', 'tROLTBLevel');?></label>
                    <select id="ocmRolLevel" class="selectpicker form-control" name="ocmRolLevel" value="<?php echo @$tRoleLevel;?>">
                        <?php
                             for($i=0;$i<=99;$i++){
                                    if($i>$this->session->userdata('nSesUsrRoleLevel')){
                                        continue;
                                    }
                        ?>
                        <option value="<?=$i?>" <?php echo (!empty($tRoleLevel) && $tRoleLevel == $i)? 'selected' : '';?>><?=$i?></option>
                         <?php } ?>
            
                    </select>
                </div>
                
                <!-- เพิ่ม กำหนดพิเศษ ฺBrowse Agncy, Branch -->
                <?php 
                    $tSpcBchCode       = "";
                    $tSpcBchName       = "";
                    $tSpcAgnCode       = "";
                    $tSpcAgnName       = ""; 

                    if($tRoute == "roleEventAdd"){
                       $tSpcBchCode           = $tBchCode;
                       $tSpcBchName           = $tBchName;
                       $tSpcAgnCode           = $tAgnCode; 
                       $tSpcAgnName           = $tAgnName;
                       
                    }else{
                        $tSpcBchCode          = $tBchCode;
                        $tSpcBchName          = $tBchName;
                        $tSpcAgnCode          = $tAgnCode;
                        $tSpcAgnName          = $tAgnName;

                    }
                ?>

               
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('authen/role/role','tRolegency')?></label>
                    <div class="input-group"><input type="text" class="form-control xCNHide" id="oetSpcAgncyCode" name="oetSpcAgncyCode" maxlength="5" value="<?=@$tSpcAgnCode;?>">
                    <input type="hidden" id="oetSpcAgncyCodeOld" name="oetSpcAgncyCodeOld" value="<?=@$tSpcAgnCode;?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetSpcAgncyName" name="oetSpcAgncyName" maxlength ="100" 
                        placeholder ="<?php echo language('authen/role/role','tRolegency');?>" value="<?=@$tSpcAgnName;?>"
                        data-validate-required = "<?php echo language('authen/role/role','tValiSpcAgency')?>" 
                        readonly>
                        <span class="input-group-btn">
                            <button id="oimBrowseSpcAgncy" type="button" class="btn xCNBtnBrowseAddOn" <?=@$tDisabled?>  
                            <?php
                                if($this->session->userdata("nSesUsrBchCount")!= 0){
                                    echo 'disabled';
                                }
                            ?>
                            >
                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('authen/role/role','tRoleBranch')?></label>
                    <div class="input-group"><input type="text" class="form-control xCNHide" id="oetSpcBranchCode" name="oetSpcBranchCode" maxlength="5" value="<?=@$tSpcBchCode;?>">
                    <input type="hidden" id="oetSpcBranchCodeOld" name="oetSpcBranchCodeOld" value="<?=@$tSpcBchCode;?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetSpcBranchName" name="oetSpcBranchName" maxlength ="100" 
                        placeholder ="<?php echo language('authen/role/role','tRoleBranch');?>" value="<?=@$tSpcBchName;?>"
                        data-validate-required = "<?php echo language('authen/role/role','tValiSpcBranch')?>" 
                        readonly>
                        <span class="input-group-btn">
                            <button id="oimBrowseSpcBranch" type="button" class="btn xCNBtnBrowseAddOn" <?=@$tDisabled?>>
                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('authen/role/role', 'tROLRemark');?></label>
                    <textarea class="form-control" rows="4" maxlength="100" id="otaRolRemark" name="otaRolRemark"><?php echo @$tRoleRmk;?></textarea>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-8">
                <div id="odvRoleMenuList" class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('authen/role/role','tROLSystemMenu');?></label>
                        </div>
                        <div class="table-responsive">
                            <table id="otbModuleMenuRole" class="table xWTableHead">
                                <thead>
                                    <tr>
                                        <th nowrap style="width:3%;text-align:center;" class="xWTableth"><label class="xCNLabelFrm xWwhite"><?php echo language('authen/role/role', 'tROLTModule'); ?></label></th>
                                        <th nowrap style="width:3%;text-align:center;" class="xWTableth"><label class="xCNLabelFrm xWwhite"><?php echo language('authen/role/role', 'tROLTGroup'); ?></label></th>
                                        <th nowrap style="width:3%;text-align:center;" class="xWTableth"><label class="xCNLabelFrm xWwhite"><?php echo language('authen/role/role', 'tROLTMenu'); ?></label></th>
                                        <th nowrap style="width:15%;text-align:center;" colspan="7" class="xWTableth"><label class="xCNLabelFrm xWwhite"><?php echo language('authen/role/role', 'tROLGroupMenu'); ?></label></th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">
                                            <input 
                                            type="text" 
                                            class="form-control xCNInputWithoutSingleQuote" 
                                            id="oetSearchAll" 
                                            name="oetSearchAll" 
                                            autocomplete="off" 
                                            onkeypress="if (event.keyCode == 13) {return false;}"
                                            placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>">
                                        </th>
                                        <th nowrap style="width:2%;text-align:center;"><label class="xCNLabelFrm"><?php echo language('authen/role/role', 'tROLTRead'); ?></label></th>
                                        <th nowrap style="width:2%;text-align:center;"><label class="xCNLabelFrm"><?php echo language('authen/role/role', 'tROLTAdd'); ?></label></th>
                                        <th nowrap style="width:2%;text-align:center;"><label class="xCNLabelFrm"><?php echo language('authen/role/role', 'tROLTBDelete'); ?></label></th>
                                        <th nowrap style="width:2%;text-align:center;"><label class="xCNLabelFrm"><?php echo language('authen/role/role', 'tROLTBEdit'); ?></label></th>
                                        <th nowrap style="width:2%;text-align:center;"><label class="xCNLabelFrm"><?php echo language('authen/role/role', 'tROLMenuApprove'); ?></label></th>
                                        <th nowrap style="width:2%;text-align:center;"><label class="xCNLabelFrm"><?php echo language('authen/role/role', 'tROLMenuCancel'); ?></label></th>
                                        <th nowrap style="width:2%;text-align:center;"><label class="xCNLabelFrm"><?php echo language('authen/role/role', 'tROLMenuReprint'); ?></label></th>
                                    </tr>
                                </thead>
                                <tbody id="otbDataBody">
                                    <?php if($aDataMenuList['rtCode'] != '1' && $aDataMenuReport['raItems'] != 1){?>
                                        <tr><td class='text-center xCNTextDetail2' colspan='9'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>       
                                    <?php }else{ ?>
                                        <?php $aModuleCode = "";?>
                                        <?php foreach($aDataMenuList['raItems'] AS $key => $aValue):?>
                                            <?php if($aModuleCode != $aValue['FTGmnModCode']):?>
                                                <tr class="xWRoleHeardGmnMod">
                                                    <td nowrap colspan="3" class="xCNMenuGrpModule" data-gmc="<?php echo $aValue['FTGmnModCode'];?>">
                                                        <i class="fa fa-plus xCNPlus" data-gmc="<?php echo $aValue['FTGmnModCode'];?>" ></i>
                                                        <label class="xCNLabelFrm">&nbsp;
                                                            <?php echo $aValue['FTGmnModName'];?>
                                                        </label>
                                                    </td>
                                                    <td nowrap class="xWHeardRoleAll"  data-gmc="<?php echo $aValue['FTGmnModCode'];?>" colspan="7">               
                                                        <label class="fancy-checkbox xWCheckAll">
                                                            <input class="xWOcbCheckAll" type="checkbox">
                                                            <span><?php echo language('common/main/main','tCMNChooseAll');?></span>
                                                        </label>
                                                    </td>
                                                </tr>
                                            <?php endif;?>
                                            <tr class="hidden xCNDataRole" data-gmc="<?php echo $aValue['FTGmnModCode'];?>" data-gmn="<?php echo $aValue['FTGmnCode'];?>" data-mnc="<?php echo $aValue['FTMnuCode'];?>">
                                                <td nowrap></td>
                                                <td nowrap><label class="xCNLabelFrm"><?php echo $aValue['FTGmnName']; ?></label></td>
                                                <td nowrap><?php echo $aValue['FTMnuName']; ?></td>
                                        
                                                <?php if($aValue['FTAutStaRead'] == '0'){ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNDisbledChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleRead"   onclick="return false;"><span> </span></label></td>
                                                <?php }else{ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNIsUseChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleRead" > <span> </span></label></td>                                                                                
                                                <?php } ?>

                                                <?php if($aValue['FTAutStaAdd'] == '0'){ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNDisbledChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleAdd"   onclick="return false;"><span> </span></label></td>
                                                <?php }else{ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNIsUseChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleAdd" > <span> </span></label></td>                                                                                
                                                <?php } ?>
                                                
                                                <?php if($aValue['FTAutStaDelete'] == '0'){ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNDisbledChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleDel"  onclick="return false;"> <span> </span></label></td>                                                                                
                                                <?php }else{ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNIsUseChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleDel" > <span> </span></label></td>     
                                                <?php } ?>

                                                <?php if($aValue['FTAutStaEdit'] == '0'){ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNDisbledChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleEdit"  onclick="return false;"> <span> </span></label></td>                                        
                                                <?php }else{ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNIsUseChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleEdit"> <span> </span></label></td>                                        
                                                <?php } ?>

                                                <?php if($aValue['FTAutStaAppv'] == '0'){ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNDisbledChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleAppv"  onclick="return false;"> <span> </span></label></td>
                                                <?php }else{ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNIsUseChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleAppv" > <span> </span></label></td>
                                                <?php } ?>

                                                <?php if($aValue['FTAutStaCancel'] == '0'){ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNDisbledChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleCancel"  onclick="return false;"> <span> </span></label></td>
                                                <?php }else{ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNIsUseChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleCancel"> <span> </span></label></td>                                        
                                                <?php } ?>

                                                <?php if($aValue['FTAutStaPrintMore'] == '0'){ ?> 
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNDisbledChkBox"><input type="checkbox" class="xCNInputRole xWDataRolePrintMore"   onclick="return false;"> <span> </span></label></td>
                                                <?php }else{ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNIsUseChkBox"><input type="checkbox" class="xCNInputRole xWDataRolePrintMore" > <span> </span></label></td>   
                                                <?php } ?>

                                            <tr>
                                            <?php $aModuleCode = $aValue['FTGmnModCode']; ?>
                                        <?php endforeach;?>

                                        <?php $aModuleRtpCode = "";?>
                                        <?php 
                                            if(!empty($aDataMenuReport['raItems'])){
                                        foreach($aDataMenuReport['raItems'] AS $key => $aValue): ?>
                                            <?php if($aModuleRtpCode != $aValue['FTGrpRptModCode']):?>
                                                <tr class="xWRoleHeardRptModCode">
                                                    <td nowrap colspan="3" class="xCNMenuRptModule"  data-rmc="<?php echo $aValue['FTGrpRptModCode'];?>">
                                                        <i class="fa fa-plus xCNPlus" data-rmc="
                                                            <?php echo $aValue['FTGrpRptModCode'];?>">
                                                        </i>
                                                        <label class="xCNLabelFrm">&nbsp;
                                                            <?php echo language('common/main/main', 'tMNUHeadReport'); ?> / <?=$aValue['FNGrpRptModName'];?>
                                                        </label>
                                                    </td>
                                                    <td nowrap class="xWHeardReportAll"  data-rmc="<?php echo $aValue['FTGrpRptModCode'];?>" colspan="7">
                                                        <label class="fancy-checkbox xWCheckAll">
                                                        <input class="xWAllow" type="checkbox">
                                                            <span><?php echo language('common/main/main', 'tCMNAllowall'); ?></span>
                                                        </label>
                                                    </td>
                                                <?php $aModuleRtpCode = $aValue['FTGrpRptModCode']; ?>
                                            <?php endif;?>
                                            <tr class="hidden xCNDataReport" data-rmc="<?php echo $aValue['FTGrpRptModCode'];?>" data-grc="<?php echo $aValue['FTGrpRptCode'];?>" data-rtc="<?php echo $aValue['FTRptCode'];?>">
                                                <td nowrap></td>
                                                <td nowrap><label class="xCNLabelFrm"><?php echo $aValue['FTGrpRptName']; ?></label></td>
                                                <td nowrap><?php echo $aValue['FTRptName']; ?></td>
                                                <?php if(isset($aValue['FTUfrStaAlw']) && !empty($aValue['FTUfrStaAlw'])){
                                                    $tStaAlw = $aValue['FTUfrStaAlw'];
                                                }else{
                                                    $tStaAlw = "";
                                                } ?>
                                                <?php if($tStaAlw != '1'){ ?>
                                                    <td nowrap colspan="6"><label class="fancy-checkbox"><input type="checkbox"   class="xCNInputReport xWDataReportAllow"> <span><?= language('common/main/main', 'tCMNAllow'); ?></span></label></td>
                                                <?php }else{ ?>    
                                                    <td nowrap colspan="6"><label class="fancy-checkbox"><input type="checkbox" checked="true" class="xCNInputReport xWDataReportAllow"> <span><?= language('common/main/main', 'tCMNAllow'); ?></span></label></td>
                                                <?php } ?>   
                                            </tr>
                                        <?php endforeach;
                                        }  ?>
                                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> 
                <?php include('func_setting/wFuncSetting.php'); ?>
            </div>
        </div>
    </div>
</form>
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
<?php include 'script/jRoleAdd.php';?>