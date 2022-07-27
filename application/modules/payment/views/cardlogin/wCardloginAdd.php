<?php

    // ตรวจสอบโหมดการทำงานว่าเป็น โหมดเพิ่มใหม่ หรือแก้ไข
    if($aResult['rtCode'] == 1){
    
        $tCrdLogType       	= $aResult['raItems']['FTCrdLogType'];
        $tCrdPwdStart       = $aResult['raItems']['FDCrdPwdStart'];
        $tCrdExpired       	= $aResult['raItems']['FDCrdPwdExpired'];
        $tCrdlogin       	= $aResult['raItems']['FTCrdLogin'];
        
        $tCrdLoginPwd       = $aResult['raItems']['FTCrdLoginPwd'];
        $Crdlog            = '******'; 
        
        $tRemark      	    = $aResult['raItems']['FTCrdRmk'];
        $tCrdStaActive      = $aResult['raItems']['FTCrdStaActive'];

        //route for edit
        $tRoute         	= "cardloginEventEdit";
    }else{
        $tCrdLogType        = "";
        $tCrdPwdStart       = "";
        $tCrdExpired        = "";
        $tCrdlogin          = "";
        
        $tCrdLoginPwd       = "";
        $Crdlog            = "";
        
        $tRemark            = "";
        $tCrdStaActive      = "";


        //route for add
        $tRoute             = "cardloginEventAdd";
    }

?>


<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddEditCrdLogin">
    <input type="hidden" value="<?php echo $tRoute; ?>" id="ohdTRoute">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <label class="xCNLabelFrm" style="color: #179bfd !important; cursor:pointer;" onclick="JSxCrdloginGetContent();" ><?php echo language('payment/cardlogin/cardlogin','tDetailLogin')?></label>
            <label class="xCNLabelFrm">
            <label class="xCNLabelFrm xWPageAdd" style="color: #aba9a9 !important;"> / <?php echo language('payment/cardlogin/cardlogin','tCrdloginAdd')?> </label> 
            <label class="xCNLabelFrm xWPageEdit hidden" style="color: #aba9a9 !important;"> / <?php echo language('payment/cardlogin/cardlogin','tCrdloginEdit')?> </label>   
        </div>

        <!--ปุ่มเพิ่ม-->
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  text-right">
            <button type="button" onclick="JSxCrdloginGetContent();" class="btn" style="background-color: #D4D4D4; color: #000000;">
                <?php echo language('common/main/main', 'tCancel')?>
            </button>
                <?php //if($aAlwEventUsrlogin['tAutStaFull'] == 1 || ($aAlwEventUsrlogin['tAutStaAdd'] == 1 || $aAlwEventUsrlogin['tAutStaEdit'] == 1)) : ?>
                    <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" id="obtCrdloginSave" onclick="JSxCrdSaveAddEdit('<?=$tRoute?>')"> <?php echo  language('common/main/main', 'tSave')?></button>
                <?php //endif; ?>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            
            <!-- End GenCode -->
            <div class="col-lg-6 col-md-6 col-xs-6">
                <div class="form-group">
                </div>

                 <!-- ประเภทการเข้าใช้งาน -->
                 <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('payment/cardlogin/cardlogin','tLoginType')?></label>
                 
                    <!-- Witsarut 19/08/2019-->
                    <!-- กรณีเปลี่ยนประเภทการเข้าใช้งานรูปแบบการกรอกข้อมูล Username/Password จะเปลี่ยนไปดังนี้
                        1 รหัสผ่าน ให้กรอก ชื่อผู้ใช้ และ รหัสผ่าน
                        2 PIN ให้กรอกเบอร์โทรศัพท์ และ PIN
                        3 RFID ให้กรอก RFID Code และทำการ Coppy ไปลงคอลัม รหัสผ่าน(Password)
                        4 QR ให้กรอก QR Code และทำการ Coppy ไปลงคอลัม รหัสผ่าน(Password) 
                        Validate รูปแบบการเลือกที่ Function JSxCURCheckLoginTypeUsed
                    -->

                    <?php
                        if(isset($tCrdLogType) && !empty($tCrdLogType)){
                    ?>
                    <input type="hidden" id="ohdTypeAddloginType" name="ohdTypeAddloginType" value="1">
                    <input type="hidden" id="ohdTypeAddloginTypeVal" name="ohdTypeAddloginTypeVal" value="<?php echo $tCrdLogType ?>">
                    <select class="selectpicker form-control" id="ocmlogintype" name="ocmlogintype" maxlength="1" onchange="JSxCRDLCheckLoginTypeUsed('insert')" 
                        <?=  "disabled"?>>
                        <option value = "1" <?= (!empty($tCrdLogType) && $tCrdLogType == '1')? "selected":""?>>
                            <?php echo language('payment/cardlogin/cardlogin','tCrdTypePwd');?>
                        </option>
                        <option value = "2" <?= (!empty($tCrdLogType) && $tCrdLogType == '2')? "selected":""?>>
                            <?php echo language('payment/cardlogin/cardlogin','tCrdTypePin');?>
                        </option>
                        <option value = "3" <?= (!empty($tCrdLogType) && $tCrdLogType == '3')? "selected":""?>>
                            <?php echo language('payment/cardlogin/cardlogin','tCrdTypeRFID');?>
                        </option>
                        <option value = "4" <?= (!empty($tCrdLogType) && $tCrdLogType == '4')? "selected":""?>>
                            <?php echo language('payment/cardlogin/cardlogin','tCrdTypeQR');?>
                        </option>
                    </select>
                    <?php
                        }else{
                    ?>
                    <input type="hidden" id="ohdTypeAddloginType" name="ohdTypeAddloginType" value="0">
                    <select class="selectpicker form-control" id="ocmlogintype" name="ocmlogintype" maxlength="1" onchange="JSxCRDLCheckLoginTypeUsed('insert')">
                        <option value = "1">
                            <?php echo language('payment/cardlogin/cardlogin','tCrdTypePwd');?>
                        </option>
                        <option value = "2">
                            <?php echo language('payment/cardlogin/cardlogin','tCrdTypePin');?>
                        </option>
                        <option value = "3">
                            <?php echo language('payment/cardlogin/cardlogin','tCrdTypeRFID');?>
                        </option>
                        <option value = "4">
                            <?php echo language('payment/cardlogin/cardlogin','tCrdTypeQR');?>
                        </option>
                    </select>
                    <?php
                        }
                    ?>
                 </div>

                <!-- *รหัสพนักงาน -->
                <div class="form-group" id="odvCRDLLoginID">

                    <label class="xCNLabelFrm XCNShow" id="olbCRDLLocinAcc">
                        <span class="text-danger">*</span>
                        <?= language('payment/cardlogin/cardlogin','tCrdloginAcc'); ?>
                    </label>

                    <!-- เบอร์โทรศัพท์ -->  
                    <label class="xCNLabelFrm XCNHide" id="olbCRDLTelNo">
                        <span class="text-danger">*</span>
                        <?= language('payment/cardlogin/cardlogin','tCrdTelNo'); ?>
                    </label>

                    <!-- RFID -->
                    <label class="xCNLabelFrm XCNHide" id="olbCRDLRFID">
                        <span class="text-danger">*</span>
                        <?= language('payment/cardlogin/cardlogin','tCrdTypeRFID'); ?>
                    </label>

                    <!-- QR Code -->
                    <label class="xCNLabelFrm XCNHide" id="olbCRDLQRCode">
                        <span class="text-danger">*</span>
                        <?= language('payment/cardlogin/cardlogin','tCrdTypeQR'); ?>
                    </label>

                    <input type="text" class="form-control"
                        id= "oetidCrdlogin"
                        name="oetidCrdlogin"
                        maxlength="30"
                        autocomplete="off"
                        value="<?php 
                            echo $tCrdlogin; 
                        ?>" 
                        placeholder="<?php echo language('payment/cardlogin/cardlogin','tCrdloginAcc')?>"
                        data-validate-required = "<?= language('payment/cardlogin/cardlogin','tValiCrdloginAcc')?> "
                       <?= (isset($tCrdLogType) && !empty($tCrdLogType))? "readonly":""?>
                    >
                </div>

                <!-- *รหัสผ่าน -->
                <div class="form-group" id="odvCRDLPwsPanel">

                    <!-- *รหัสผ่าน -->
                    <label class="xCNLabelFrm XCNShow" id="olbCRDLPassword">
                        <span class="text-danger">*</span>
                        <?= language('payment/cardlogin/cardlogin','tCrdloginPwd'); ?>
                    </label>

                    <!-- *PIN -->
                    <label class="xCNLabelFrm XCNHide" id="olbCRDLPin">
                        <span class="text-danger">*</span>
                        <?= language('payment/cardlogin/cardlogin','tCrdTypePin'); ?>
                    </label>

                    <!-- Update การเข้ารหัส -->
                    <!-- Create By Witsarut 1/09/2019 -->
                    
                    <input type="hidden" 
                            id="oetCrdloginPasswordOld" 
                            name="oetCrdloginPasswordOld" 
                            placeholder="<?= language('payment/cardlogin/cardlogin','tCrdEnCode')?>"
                            value=""
                    >

                    <!-- Update การเข้ารหัส -->
                    <!-- Create By Witsarut 1/09/2019 -->

                    <input type="password" 
                            class="form-control" 
                            autocomplete="off" 
                            id="oetidCrdlogPw" 
                            name="oetidCrdlogPw" 
                            maxlength="30"  
                            value = "<?=$Crdlog?>"
                            placeholder="<?php echo language('payment/cardlogin/cardlogin','tCrdloginPwd')?>"
                            data-validate-required = "<?php echo language('payment/cardlogin/cardlogin','tValiCrdloginPass')?>"
                            <?= (isset($tCrdLogType) && !empty($tCrdLogType) && ($tCrdLogType == 3 || $tCrdLogType == 4))? "readonly":""?>
                    >
                </div>


                <?php
                    //Time Start
                    if(isset($tCrdPwdStart)){
                        $aPasswordStart = explode(" ",$tCrdPwdStart);
                       if(isset($aPasswordStart[1])) {
                         $tCrdtimestart  = substr($aPasswordStart[1],0,8);
                       }else{
                           $tCrdtimestart = "";
                       }
                    }else{
                        $tCrdtimestart = "";
                    }
                ?>

                <!-- วันที่เริ่ม และ วันที่สิ้นสุด -->
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">	
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('payment/cardlogin/cardlogin','tCrdDateStart');?></label>
                            <div class="input-group">
                                <input type="text" style="display:none" id="oetCrdtimestart" name="oetCrdtimestart" value="<?php echo $tCrdtimestart;?>">
                                <input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-left" id="oetCrdlogStart" name="oetCrdlogStart" value="<?php if($tCrdPwdStart != ""){ echo $tCrdPwdStart;}else{echo $dGetDataNow;}?>" >
                                <span class="input-group-btn">
                                    <button id="obtCrdlogStart" type="button" class="btn xCNBtnDateTime">
                                        <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <?php
                        //Time Expire
                        if(isset($tCrdExpired)){
                            $aPasswordExpire = explode(" ",$tCrdExpired);
                        if(isset($aPasswordExpire[1])) {
                            $tCrdtimesExpire  = substr($aPasswordExpire[1],0,8);
                        }else{
                            $tCrdtimesExpire = "";
                        }
                        }else{
                            $tCrdtimesExpire = "";
                        }
                    ?>

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">	
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('payment/cardlogin/cardlogin','tCrdDateStop')?></label>
                            <div class="input-group">
                                <input type="text" style="display:none" id="oetCrdtimeExpire" name="oetCrdtimeExpire" value="<?php echo $tCrdtimesExpire;?>">
                                <input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-left" id="oetCrdlogStop" name="oetCrdlogStop" value="<?php if($tCrdExpired != ""){ echo $tCrdExpired;}else{echo $dGetDataFuture;}?>">
                                <span class="input-group-btn">
                                    <button id="obtCrdlogStop" type="button" class="btn xCNBtnDateTime">
                                        <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('payment/cardlogin/cardlogin','tCrdLRemark'); ?></label>
                    <textarea class="form-group" rows="4" maxlength="100" id="oetCrdlogRemark" name="oetCrdlogRemark" autocomplete="off"   placeholder="<?php echo language('payment/cardlogin/cardlogin','tCrdLRemark')?>"><?php echo $tRemark;?></textarea>
                </div>

                <div class="form-group">
                    <label class="fancy-checkbox">
                        <input type="checkbox" name="ocbCrdlogStaUse" <?php 
                        if($tRoute=="cardloginEventAdd"){
                            echo "checked";
                        }else{
                            echo ($tCrdStaActive == '1') ? "checked" : ''; 
                        } ?> value="1">
                        <span> <?php echo language('payment/cardlogin/cardlogin','tCrdStaActive'); ?></span>
                    </label>
                </div>
            </div>
        </div>

        <!--USer  ที่กำลังจะสร้างข้อมูลล็อกอิน -->
        <?php 
            $tCrdCode    = $aCrdCode['tCrdCode'];
        ?>
        <input type="hidden" id="ohdCrdLogCode" name="ohdCrdLogCode" value="<?=$tCrdCode?>">
        <input type="hidden" id="ohdValidateDuplicate" name="ohdValidateDuplicate" value="0"><!-- 0 คือ ไม่เกิด validate  และ 1 เกิด validate -->
</form>

<script>
    if("<?php echo $aResult['rtCode'];?>" == 1){
        var tCrdLogType  = '<?php  echo $tCrdLogType;?>';
        $('#ocmlogintype').val(tCrdLogType);
        JSxCRDLCheckLoginTypeUsed('edit');
    }

</script>

<?php include "script/jCardloginMain.php"; ?>
<link rel="stylesheet" href="<?php echo base_url('application/modules/common/assets/css/localcss/ada.component.css')?>">
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>