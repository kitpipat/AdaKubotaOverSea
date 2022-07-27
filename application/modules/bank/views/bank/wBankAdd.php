<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "bankEventEdit"; 
        $tBnkCode   = $aBnkData['raItems']['rtBnkCode'];
        $tBnkName   = $aBnkData['raItems']['rtBnkName'];
        $tBnkRmk    = $aBnkData['raItems']['rtBnkRmk'];
    }else{
        $tRoute     = "bankEventAdd";
        $tBnkCode   = "";
        $tBnkName   = "";
        $tBnkRmk    = "";
    }
?>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddBnk">
    <button type="submit" id="obtSubmitBnk" onclick="JSxSetStatusClickBnkSubmit('<?= $tRoute?>')"></button>
    <input type="hidden" id="ohdBnkRoute" value="<?php echo $tRoute; ?>">
    <div class="panel panel-headline"><!-- เพิ่มมาใหม่ --> 
        <div class="panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <div id="odvBntImage">
                            <?php 
                                if(isset($tImgObjAll) && !empty($tImgObjAll)){
                                    $tFullPatch = './application/modules/'.$tImgObjAll;                        
                                    if (file_exists($tFullPatch)){
                                        $tPatchImg = base_url().'/application/modules/'.$tImgObjAll;
                                    }else{
                                        $tPatchImg = base_url().'application/modules/common/assets/images/300x60.png';
                                    }
                                }else{
                                    $tPatchImg = base_url().'application/modules/common/assets/images/300x60.png';
                                }
                            ?>
                            <img id="oimImgMasterBank" class="img-responsive xCNImgCenter" src="<?php echo @$tPatchImg;?>">
                        </div>
                        <div class="form-group">
                            <div class="xCNUplodeImage">
                                <input type="text" class="xCNHide" id="oetImgInputBank"     name="oetImgInputBank"      value="<?php echo @$tImgName;?>">
                                <input type="text" class="xCNHide" id="oetImgInputBankOld"  name="oetImgInputBankOld"   value="<?php echo @$tImgName;?>">
                                <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('','','Bank')">
                                    <i class="fa fa-picture-o xCNImgButton"></i> <?php echo language('common/main/main','tSelectPic');?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-5 col-lg-5"> <!-- เปลี่ยน Col Class -->
                    <!-- รหัส -->
                    <div class="form-group" id="odvBnkCodeForm">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('bank/bank/bank','tBNKTBCode')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="hidden" class="form-control" maxlength="5" id="oetBnkCodeOld" name="oetBnkCodeOld"  value="<?php echo $tBnkCode ?>">
                        <input type="text" class="form-control" maxlength="5" id="oetBnkCode" name="oetBnkCode"
                            placeholder="<?= language('bank/bank/bank','tBNKTBCode')?>"
                            value="<?=$tBnkCode;?>" 
                            data-validate-required="<?php echo language('bank/bank/bank','tBNKValidCode')?>"
                        >
                    </div>
                    <!-- ชื่อ -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('bank/bank/bank','tBNKTBName')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="text" class="form-control" maxlength="100" id="oetBnkName" name="oetBnkName"
                            placeholder="<?= language('bank/bank/bank','tBNKTBName')?>"
                            value="<?=$tBnkName;?>" 
                            data-validate-required="<?php echo language('bank/bank/bank','tBNKValidName')?>"
                        >
                    </div>
                    <!-- หมายเหตุ -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('bank/bank/bank','tBNKRemark')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <textarea class="form-control" maxlength="100" rows="5" id="otaBnkRmk" name="otaBnkRmk"><?=$tBnkRmk?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>