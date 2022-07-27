<?php
    //Decimal Save
    $tDecSave = FCNxHGetOptionDecimalSave();
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute             = "cardtypeEventEdit";
        $tCtyCode           = $aCtyData['raItems']['rtCtyCode'];
        $tCtyName           = $aCtyData['raItems']['rtCtyName'];

        $tCtyStatusPay      = $aCtyData['raItems']['rtCtyStaPay'];
        $tCtyPaylimit       = number_format($aCtyData['raItems']['rtCtyCreditLimit'],$tDecSave);

        $tCtyDeposit        = number_format($aCtyData['raItems']['rtCtyDeposit'],$tDecSave );
        $tCtyTopupAuto      = number_format($aCtyData['raItems']['rtCtyTopupAuto'],$tDecSave );
        $tCtyExpiredType    = $aCtyData['raItems']['rtCtyExpiredType'];
        $tCtyExpirePeriod   = $aCtyData['raItems']['rtCtyExpirePeriod'];
        $tCstStaActiveCheck = $aCtyData['raItems']['rtCtyStaAlwRet'];
        $tCtyRmk            = $aCtyData['raItems']['rtCtyRmk'];
    }else{
        $tRoute              = "cardtypeEventAdd"; 
        $tCtyCode            = "";
        $tCtyName            = "";
        $tCtyDeposit         = "0.00";
        $tCtyTopupAuto       = "0.00";
        $tCtyPaylimit        = "0.00";
        $tCtyExpiredType     = "";
        $tCtyExpirePeriod    = "";
        $tCstStaActiveCheck  = "";
        $tCtyRmk             = "";
    }
?>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddCardType">
    <button style="display:none" type="submit" id="obtSubmitCardType" onclick="JSoAddEditCardType('<?php echo $tRoute?>')"></button>
    <div class=""><!-- เพิ่มมาใหม่ --> 
        <div class="panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
        <!-- รหัสประเภทบัตร -->
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5">
                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('payment/cardtype/cardtype','tCTYFrmCtyCode')?></label> 
                    <div class="form-group" id="odvCardtypeAutoGenCode">
                        <div class="validate-input">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbCardtypeAutoGenCode" name="ocbCardtypeAutoGenCode" checked="true" value="1">
                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group" id="odvCardtypeCodeForm">
                            <input type="hidden" id="ohdCheckDuplicateCtyCode" name="ohdCheckDuplicateCtyCode" value="1">
                            <div class="validate-input">
                                <input 
                                    type="text"
                                    class="form-control xCNInputWithoutSpcNotThai"
                                    maxlength="5"
                                    id="oetCtyCode"
                                    name="oetCtyCode"
                                    placeholder="<?php echo language('payment/cardtype/cardtype','tCTYFrmCtyCode')?>"
                                    value="<?php echo $tCtyCode?>"
                                    data-is-created="<?php echo $tCtyCode; ?>"
                                    data-validate-required = "<?php echo language('payment/cardtype/cardtype','tCTYValidCode')?>"
                                    data-validate-dublicateCode ="<?php echo language('payment/cardtype/cardtype','tCTYValidCodeDup');?>"
                                >
                            </div>
                        </div>
                        <!-- ชื่อประเภทบัตร -->
                        <div class="form-group">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('payment/cardtype/cardtype','tCTYFrmCtyName')?></label> 
                                <input 
                                    type="text"
                                    class="form-control"
                                    id="oetCtyName"
                                    name="oetCtyName"
                                    value="<?php echo $tCtyName;?>"
                                    data-validate-required = "<?php echo language('payment/cardtype/cardtype','tCTYValidName')?>"
                                >
                            </div>
                        </div>

                    <!-- ค่ามัดจำบัตร -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('payment/cardtype/cardtype','tCTYDeposit')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="text" class="form-control xCNInputNumericWithDecimal text-right" id="oetCtyDeposit" name="oetCtyDeposit" onclick="JCNdValidateComma('oetCtyDeposit',3,'FC');" onfocusout="JCNdValidatelength8Decimal('oetCtyDeposit','FC',3,'<?php echo $tDecSave?>')"  value="<?php echo $tCtyDeposit;?>" 
                        data-validate="<?php echo language('payment/cardtype/cardtype','tCTYValidDeposit')?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                    </div>
                    <!-- ยอดเติมเงินอัติโนมัติ -->
    		        <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('payment/cardtype/cardtype','tCTYTopupAuto')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="text" class="form-control xCNInputNumericWithDecimal text-right" id="oetCtyTopupAuto" name="oetCtyTopupAuto" onclick="JCNdValidateComma('oetCtyTopupAuto',3,'FC');" onfocusout="JCNdValidatelength8Decimal('oetCtyTopupAuto','FC',3,'<?php echo $tDecSave?>')" value="<?php echo $tCtyTopupAuto;?>" 
                        data-validate="<?php echo language('payment/cardtype/cardtype','tCTYValidTopupAuto')?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                    </div>

                    <!-- ประเภทหมดอายุ(1=ชั่วโมง/2=วัน/3=เดือน/4=ปี) -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('payment/cardtype/cardtype','tCTYExpiredType')?></label>
                        <select  required  class="selectpicker form-control" id="ocmCtyExpireType" name="ocmCtyExpireType" data-live-search="true" data-validate="<?php echo language('payment/cardtype/cardtype','tCTYValidExpireType')?>">
                            <option value='2' <?php echo  (isset($tCtyExpiredType) && !empty($tCtyExpiredType) && $tCtyExpiredType == '2')? "selected":""?>>
                                <?php echo language('payment/cardtype/cardtype','tCTYFrmDay')?>
                            </option>
                            <option value='1' <?php echo  (isset($tCtyExpiredType) && !empty($tCtyExpiredType) && $tCtyExpiredType == '1')? "selected":""?>>
                                <?php echo language('payment/cardtype/cardtype','tCTYFrmHour')?>
                            </option>
                            <option value='3' <?php echo  (isset($tCtyExpiredType) && !empty($tCtyExpiredType) && $tCtyExpiredType == '3')? "selected":""?>>
                                <?php echo language('payment/cardtype/cardtype','tCTYFrmMonth')?>
                            </option>
                            <option value='4' <?php echo  (isset($tCtyExpiredType) && !empty($tCtyExpiredType) && $tCtyExpiredType == '4')? "selected":""?>>
                                <?php echo language('payment/cardtype/cardtype','tCTYFrmYear')?>
                            </option>
                        </select>
                    </div> 
                    <!-- อายุบัตร -->
                    <div class="form-group">
                        <label class="xCNLabelFrm" id="tCTYExpire"><?php echo language('payment/cardtype/cardtype','tCTYExpireHour')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="text" class="form-control xCNInputNumericWithoutDecimal text-right" maxlength= "4" id="oetCtyExpirePeriod" name="oetCtyExpirePeriod" value="<?php echo $tCtyExpirePeriod?>" 
                        data-validate="<?php echo language('payment/cardtype/cardtype','tCTYValidExpirePeriod')?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                    </div>

                    <!-- สถานะการชำระ เพิ่มมาใหม่ -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('payment/cardtype/cardtype','tCTYStaPay')?></label>
                        <select  required  class="selectpicker form-control" id="ocmCtyStatusPay" name="ocmCtyStatusPay">
                            <option value='1' <?php echo  (isset($tCtyStatusPay) && !empty($tCtyStatusPay) && $tCtyStatusPay == '1')? "selected":""?>>
                                <?php echo language('payment/cardtype/cardtype','tCTYTopupfirst')?>
                            </option>
                            <option value='2' <?php echo  (isset($tCtyStatusPay) && !empty($tCtyStatusPay) && $tCtyStatusPay == '2')? "selected":""?>>
                                <?php echo language('payment/cardtype/cardtype','tCTYPayLater')?>
                            </option>
                        </select>
                    </div>

                    <!-- วงเงืน เพิ่มมาใหม่ -->
                    <div class="form-group">
                        <label class="xCNLabelFrm" id="tCTYPaylimit"><?php echo language('payment/cardtype/cardtype','tCTYPaylimit')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="text" class="form-control xCNInputNumericWithDecimal text-right" id="oetCtyPaylimit" name="oetCtyPaylimit"  onclick="JCNdValidateComma('oetCtyPaylimit',3,'FC');" onfocusout="JCNdValidatelength8Decimal('oetCtyPaylimit','FC',3,'<?php echo $tDecSave?>')" value="<?php echo $tCtyPaylimit;?>"
                        data-validate="<?php echo language('payment/cardtype/cardtype','tCTYValidPaylimit')?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                    </div>
                  

                    <!-- อนุญาตคืน -->
                    <div class="form-group">
			            <div class="">
                        <label class="fancy-checkbox">
                            <input type="checkbox"  name="ocbCtyStaAlwRet" <?php echo $tCstStaActiveCheck == "1" ?  'checked="checked"' : ''?> value="1">
                            <span> <?php echo language('payment/cardtype/cardtype','TCTYStaAlwRet'); ?></span>
                        </label>
                        </div>
                  </div>
                    <!-- หมายเหตุ -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('payment/cardtype/cardtype','tCTYFrmCtyRmk')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <textarea class="form-control" maxlength="100" rows="4" id="otaCtyRmk" name="otaCtyRmk"><?php echo $tCtyRmk?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php include 'script/jCardtypeAdd.php';?>
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>

<script>

    $('#ocmCtyExpireType').change(function() {
        $('#ocmCtyExpireType-error').hide();
    });

    $('#obtGenCodeCardType').click(function(){
        JStGenerateCardTypeCode();
    });

    $('#ocmCtyExpireType').selectpicker();
    
    $('#ocmCtyExpireType').change(function(){
        var nStaExpireType = $(this).val();
        //console.log(nStaExpireType);

        switch(nStaExpireType.toString()){
            case '1':
                $('#tCTYExpire').text('<?php echo language('payment/cardtype/cardtype','tCTYExpireHour');?>');
                break;
            case '2':
                $('#tCTYExpire').text('<?php echo language('payment/cardtype/cardtype','tCTYExpireDays');?>');
                break;
            case '3':
                $('#tCTYExpire').text('<?php echo language('payment/cardtype/cardtype','tCTYExpireMonth');?>');
                break;
            case '4':
                $('#tCTYExpire').text('<?php echo language('payment/cardtype/cardtype','tCTYExpireYear');?>');
                break;
            default :
                $('#tCTYExpire').text('<?php echo language('payment/cardtype/cardtype','tCTYExpireHour');?>');
            }
        });

    // **************************************************************************
        // Create By Witsarut 25/10/2019
        $('#ocmCtyStatusPay').selectpicker();

        // ถ้า สถานะการชำระ  เติมเงินก่อน ตรง input วงเงินจะปิด
        // ถ้า สถานะการชำระ  จ่ายทีหลัง ตรง input วงเงินจะเปิด
        $(document).ready(function(){
            var tRoute = "<?php echo $tRoute;?>";
            if(tRoute  == 'cardtypeEventEdit'){
               var nStatusPay = $('#ocmCtyStatusPay').val();
               if(nStatusPay == "1"){
                 $('#oetCtyPaylimit').attr('readonly','readonly');
               }
            }else{
                $('#oetCtyPaylimit').attr('readonly','readonly');
            }
        });


        $('#ocmCtyStatusPay').change(function(){
            var nStatusPay = $(this).val();
            if(nStatusPay == "1"){
                $('#oetCtyPaylimit').val('0.00');
                $('#oetCtyPaylimit').attr('readonly','readonly');
            }else{
                $('#oetCtyPaylimit').removeAttr('readonly');
            }
        });

        // ล้างค่า ExpiredType
        $('#ocmCtyExpireType').change(function(){
            var nStatusExpired = $(this).val();
            switch (nStatusExpired){
                case '1' :
                    $('#oetCtyExpirePeriod').val('');
                break;
                case '2' :
                    $('#oetCtyExpirePeriod').val('');
                break;
                case '3' :
                    $('#oetCtyExpirePeriod').val('');
                break;
                case '4' :
                    $('#oetCtyExpirePeriod').val('');
                break;
                default : 
                    $('#oetCtyExpirePeriod').val('');
            }
        });

    // **************************************************************************

</script>