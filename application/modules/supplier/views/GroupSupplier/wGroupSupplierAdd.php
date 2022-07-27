<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "groupsupplierEventEdit";
        $tSgpCode   = $aSgpData['raItems']['rtSgpCode'];
        $tSgpName   = $aSgpData['raItems']['rtSgpName'];
        $tSgpRmk    = $aSgpData['raItems']['rtSgpRmk'];
    }else{
        $tRoute     = "groupsupplierEventAdd";
        $tSgpCode   = "";
        $tSgpName   = "";
        $tSgpRmk    = "";
    }
?>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddGroupSupplier">
    <button style="display:none" type="submit" id="obtSubmitGroupSupplier" onclick="JSoAddEditGroupSupplier('<?= $tRoute?>')"></button>
    <div class="panel panel-headline"><!-- เพิ่มมาใหม่ --> 
        <div class="panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5"> <!-- เปลี่ยน Col Class -->    

                    <!-- GenCode GroupSupplier-->
                    <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('supplier/groupsupplier/groupsupplier','tSGPFrmSgpCode')?></label> 
                        <div class="form-group" id="odvGroupSupplierAutoGenCode">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbGroupSupplierAutoGenCode" name="ocbGroupSupplierAutoGenCode" checked="true" value="1">
                                        <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                        </label>
                                    </div>
                                </div>
                            <div class="form-group" id="odvGroupSupplierCodeForm">
                                <input type="hidden" id="ohdCheckDuplicateSgpCode" name="ohdCheckDuplicateSgpCode" value="1">
                                    <div class="validate-input">
                                        <input 
                                            type="text"
                                            class="form-control xCNGenarateCodeTextInputValidate"
                                            maxlength="5"
                                            id="oetSgpCode"
                                            name="oetSgpCode"
                                            placeholder="<?php echo language('supplier/groupsupplier/groupsupplier','tSGPFrmPlacName')?>"
                                            value="<?php echo $tSgpCode?>"
                                            data-is-created="<?php echo $tSgpCode; ?>"
                                            autocomplete="off"
                                            data-validate-required = "<?php echo language('supplier/groupsupplier/groupsupplier','tSGPValidCode')?>"
                                            data-validate-dublicateCode ="<?php echo language('supplier/groupsupplier/groupsupplier','tSGPValidCodeDup');?>"
                                        >
                                        </div>
                                    </div>
                        <!-- EndGenCode GroupSupplier-->
        
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('supplier/groupsupplier/groupsupplier','tSGPGroupSup')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="text" class="form-control " maxlength="50" 
                        placeholder="<?php echo language('supplier/groupsupplier/groupsupplier','tSGPGroupSup')?>"
                        id="oetSgpName" name="oetSgpName" value="<?=$tSgpName?>" 
                        data-validate-required="<?= language('supplier/groupsupplier/groupsupplier','tSGPValidName')?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                    </div>

                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('supplier/groupsupplier/groupsupplier','tSGPFrmSgpRmk')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <textarea class="form-control " maxlength="100" rows="4" id="otaSgpRmk" name="otaSgpRmk"><?=$tSgpRmk?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include 'script/jGroupSupplierAdd.php';?>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>


<script>
    $('#obtGenCodeGroupSupplier').click(function(){
        JStGenerateGroupSupplierCode();
    });
</script>