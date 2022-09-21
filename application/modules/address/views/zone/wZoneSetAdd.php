<?php
    //Decimal Show ลง 2 ตำแหน่ง
    $nDecShow =  FCNxHGetOptionDecimalShow();
    if(isset($aItems)){
        $tStaEnter      = "2"; //Edit
        $tZneID         = $aItems['FNZneID'];
        $tZneCode       = $aItems['FTZneCode'];
        $nZneLevel      = $aItems['FNZneLevel'];
        $tZneParent     = $aItems['FTZneParent'];
        $tZneChain      = $aItems['FTZneChain'];
        $tZneName       = $aItems['FTZneName'];
        $tKeyReferName  = $aItems['FTZneKey'];
        $tZneTable      = $aItems['FTZneTable'];
        
        $tZneAgnCode    = $aItems['FTAgnCode'];
        $tZneAgnName    = $aItems['FTAgnName'];
        $tBrowseCode = $aItems['FTZneRefCode'];
        $tBrowseName = $aItems['rtZneRefName'];
        // switch ($aItems['FTZneTable']) {
        //     case 'TCNMCountry':
        //         $tBrowseCode = $aItems['FTZneRefCode'];
        //         $tBrowseName = $aItems['TCNMCountry'];
        //     break;
        //     case 'TCNMBranch':
        //         $tBrowseCode = $aItems['FTZneRefCode'];
        //         $tBrowseName = $aItems['TCNMBranch'];
        //     break;
        //     case 'TCNMUser':
        //         $tBrowseCode = $aItems['FTZneRefCode'];
        //         $tBrowseName = $aItems['TCNMUser'];
        //     break;
        //     case 'TCNMSpn':
        //         $tBrowseCode = $aItems['FTZneRefCode'];
        //         $tBrowseName = $aItems['TCNMSpn'];
        //     break;
        //     case 'TCNMShop':
        //         $tBrowseCode = $aItems['FTZneRefCode'];
        //         $tBrowseName = $aItems['TCNMShop'];
        //     break;
        //     case 'TCNMPos':
        //         $tBrowseCode = $aItems['FTZneRefCode'];
        //         $tBrowseName = $aItems['TCNMPos'];
        //     break;
        //     case 'TCNMAgency':
        //         $tBrowseCode = $aItems['FTZneRefCode'];
        //         $tBrowseName = $aItems['TCNMAgency'];
        //     break;
        //     case 'TCNMMerchant':
        //         $tBrowseCode = $aItems['FTZneRefCode'];
        //         $tBrowseName = $aItems['TCNMMerchant'];
        //     break;
        //     default:
        //         false;
        //     break;
        // }
    }else{
        $tStaEnter      = "1"; //Add
        $tZneCode       	= $nResult['roItem']['rtZneCode'];
        $nZneLevel      	= $nResult['roItem']['rnZneLevel'];
        $tZneParent     	= $nResult['roItem']['rtZneParent'];
        $tZneChain      	= $nResult['roItem']['rtZneChain'];
        $tZneName       	= $nResult['roItem']['rtZneName'];
        $tZneAgnCode        = $nResult['roItem']['rtAgnCode'];
        $tZneAgnName        = $nResult['roItem']['rtAgnName'];
        $tMenuTabDisable    = "";
        $tZneID             = "";
        $tZneTable          = "";
        $tMenuTabToggle     = "tab";
        $tRoute 			= 'zoneEventEdit'; //Route ควบคุมการทำงาน Edit
    }
?>

<script>

    var nStaChk = $('#oetPdtSetStaEnter').val();
    if(nStaChk == "2"){
        $('.xWBtnPdtSetAddProduct').attr('disabled',true);
    }

</script>
    <input type="hidden" id="oetZneID" name="oetZneID" value="<?php echo $tZneID;?>">

    <input type="hidden" id="oetZneChain" name="oetZneChain" value="<?php echo $tZneChain;?>">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
            <div class="form-group">
                <div class="validate-input">
                    <label class="xCNLabelFrm"><?php echo  language('address/zone/zone','tZNECode')?><?php echo  language('address/zone/zone','tZNETitle')?></label>
                    <input type="text" class="xCNInputWithoutSpc" maxlength="100" id="oetZneCodeTab2" name="oetZneCodeTab2" value="<?php echo @$tZneCode;?>" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
        <!-- <input type="hidden" id="oetZneCodeTab2" name="oetZneCodeTab2"  value="<?php echo @$tZneCode;?>"> -->
        <input type="text" class="xCNHide"  id="oetZneChainOldTab2" name="oetZneChainOldTab2" value="<?php echo @$tZneChain?>" >
            <div class="form-group">
                <div class="validate-input">
                    <label class="xCNLabelFrm"><?php echo language("address/zone/zone","tZNEName");?></label>
                    <input type="hidden" id="oetZneNameOld" name="oetZneNameOld"  value="<?php echo @$tZneName;?>">
                    <input type="text" class="xCNInputWithoutSpc" maxlength="100" id="oetZneName" name="oetZneName" value="<?php echo @$tZneName;?>" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-5 col-lg-5">
            <div class="form-group" >
            <label class="xCNLabelFrm"><?php echo language('address/zone/zone','tZneSltAgency');?></label>
                <div class="input-group" >
                    <input type="text" class="form-control xCNHide" id="oetZneAgnCodeSecond" name="oetZneAgnCodeSecond" maxlength="5" value="<?php echo @$tZneAgnCode?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetZneAgnNameSecond" name="oetZneAgnNameSecond"  
                    placeholder="<?php echo language('address/zone/zone','tZneSltAgency');?>" value="<?php echo @$tZneAgnName?>" readonly>
                    <span class="input-group-btn">
                        <button id="obtBrowseAgencySecond" type="button" class="btn xCNBtnBrowseAddOn">
                            <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
            <div class="form-group">
            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/zone/zone','tTypeDetailRefer');?></label>
                <select class="selectpicker form-control" id="ocmTypeRefer" name="ocmTypeRefer" maxlength="1"
                data-validate-required = "<?= language('address/zone/zone','tZneValiTypeRefer')?>"
                data-validate-dublicateCode = "<?= language('address/zone/zone','tZneValiTypeRefer')?>"
                >
                    <!-- <option value=""><?php echo language('common/main/main','tCMNBlank-NA');?></option> -->
                    <option <?= ($tZneTable == 'TCNMCountry') ? 'selected' : false ?> value="TCNMCountry"><?php echo language('address/zone/zone','tZneSltCountry');?></option>
                    <option <?= ($tZneTable == 'TCNMAgency') ? 'selected' : false ?> value="TCNMAgency"><?php echo language('address/zone/zone','tZneSltAgency');?></option>
                    <option <?= ($tZneTable == 'TCNMBranch') ? 'selected' : false ?> value="TCNMBranch"><?php echo language('address/zone/zone','tZneSltBranch');?></option>
                    <option <?= ($tZneTable == 'TCNMMerchant') ? 'selected' : false ?> value="TCNMMerchant">กลุ่มธุรกิจ</option>
                    <option <?= ($tZneTable == 'TCNMShop') ? 'selected' : false ?> value="TCNMShop"><?php echo language('address/zone/zone','tZneSltShop');?></option>
                    <option <?= ($tZneTable == 'TCNMPos') ? 'selected' : false ?> value="TCNMPos"><?php echo language('address/zone/zone','tZneSltPos');?></option>
                    <option <?= ($tZneTable == 'TCNMUser') ? 'selected' : false ?> value="TCNMUser"><?php echo language('address/zone/zone','tZneSleUSer');?></option>
                    <option <?= ($tZneTable == 'TCNMSpn') ? 'selected' : false ?> value="TCNMSpn"><?php echo language('address/zone/zone','tZneSltSaleman');?></option>
                </select>
            </div>
        </div>
    </div>        
        
    <div class="row">
        <!-- ฺBrowse Branch (สาขา) -->
        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5" id="odvZneBranch" >
            <div class="form-group">
                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/zone/zone','tZneSltBranch');?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNHide" id="oetZneBchCode" name="oetZneBchCode" value="<?php echo @$tBrowseCode;?>">
                    <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetZneBchName" name="oetZneBchName" placeholder="<?php echo language('address/zone/zone','tZneSltBranch');?>" value="<?php echo @$tBrowseName;?>"
                    data-validate-required = "<?= language('address/zone/zone','tZneValiReference')?>"
                    data-validate-dublicateCode = "<?= language('address/zone/zone','tZneValiReference')?>
                    " readonly>
                    <span class="input-group-btn">
                        <button id="obtBrowseBranch" type="button" class="btn xCNBtnBrowseAddOn">
                            <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <!-- Browse User (ผู้ใช้)-->
        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5" id="odvZneUSer">
            <div class="form-group">
                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/zone/zone','tZneSleUSer');?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNHide" id="oetZneUSerCode" name="oetZneUSerCode" value="<?php echo @$tBrowseCode;?>">
                    <input type="text" class="from-control xCNInputWithoutSpcNotThai" id="oetZneUSerName"  name="oetZneUSerName"  placeholder="<?php echo language('address/zone/zone','tZneSleUSer');?>" value="<?php echo @$tBrowseName;?>"
                    data-validate-required = "<?= language('address/zone/zone','tZneValiReference')?>"
                    data-validate-dublicateCode = "<?= language('address/zone/zone','tZneValiReference')?>
                    " readonly>
                    <span class="input-group-btn">
                        <button id="obtBrowseUSer" type="button" class="btn xCNBtnBrowseAddOn">
                            <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <!-- Browse SaleMan พนักงานขาย -->
        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5" id="odvZneSaleMan">
            <div class="form-group">
            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/zone/zone','tZneSltSaleman');?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNHide" id="oetZneSpnCode" name="oetZneSpnCode" maxlength="5" value="<?php echo @$tBrowseCode?>">
                    <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetZneSpnName" name="oetZneSpnName" maxlength="100" placeholder="<?php echo language('address/zone/zone','tZneSltSaleman');?>" value="<?php echo @$tBrowseName?>"
                    data-validate-required = "<?= language('address/zone/zone','tZneValiReference')?>"
                    data-validate-dublicateCode = "<?= language('address/zone/zone','tZneValiReference')?>
                    " readonly>
                    <span class="input-group-btn">
                        <button id="obtBrowseSaleMan" type="button" class="btn xCNBtnBrowseAddOn">
                            <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <!-- Browse Shop (ร้านค้า) -->
        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5" id="odvZneShop">
            <div class="form-group" >
            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/zone/zone','tZneSltShop');?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNHide" id="oetZneShopCode" name="oetZneShopCode" value="<?php echo @$tBrowseCode?>">
                    <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetZneShopName" name="oetZneShopName"  placeholder="<?php echo language('address/zone/zone','tZneSltShop');?>" value="<?php echo @$tBrowseName?>"
                    data-validate-required = "<?= language('address/zone/zone','tZneValiReference')?>"
                    data-validate-dublicateCode = "<?= language('address/zone/zone','tZneValiReference')?>
                    " readonly>
                    <span class="input-group-btn">
                        <button id="obtBrowseShop" type="button" class="btn xCNBtnBrowseAddOn">
                            <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>
            
        <!-- Browse Pos (เครื่องจุดขาย) -->
        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5" id="odvZnePos">	
            <div class="form-group" >
            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/zone/zone','tZneSltPos');?></label>
                <div class="input-group" >
                    <input type="text" class="form-control xCNHide" id="oetZnePosCode" name="oetZnePosCode" maxlength="5" value="<?php echo @$tBrowseCode?>">
                    <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetZnePosName" name="oetZnePosName"  placeholder="<?php echo language('address/zone/zone','tZneSltPos');?>" value="<?php echo @$tBrowseName?>"
                    data-validate-required = "<?= language('address/zone/zone','tZneValiReference')?>"
                    data-validate-dublicateCode = "<?= language('address/zone/zone','tZneValiReference')?>
                    " readonly>
                    <span class="input-group-btn">
                        <button id="obtBrowsePOS" type="button" class="btn xCNBtnBrowseAddOn">
                            <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <!-- Browse Country (ประเทศ) -->
        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5" id="odvZneCountry">	
            <div class="form-group" >
            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/zone/zone','tZneSltCountry');?></label>
                <div class="input-group" >
                    <input type="text" class="form-control xCNHide" id="oetZneCtyCode" name="oetZneCtyCode" maxlength="5" value="<?php echo @$tBrowseCode?>">
                    <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetZneCtyName" name="oetZneCtyName"  placeholder="<?php echo language('address/zone/zone','tZneSltCountry');?>" value="<?php echo @$tBrowseName?>"
                    data-validate-required = "<?= language('address/zone/zone','tZneValiReference')?>"
                    data-validate-dublicateCode = "<?= language('address/zone/zone','tZneValiReference')?>
                    " readonly>
                    <span class="input-group-btn">
                        <button id="obtBrowseCountry" type="button" class="btn xCNBtnBrowseAddOn">
                            <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <!-- Browse Agency (ตัวแทนขาย) -->
        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5" id="odvZneAgency">	
            <div class="form-group" >
            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/zone/zone','tZneSltAgency');?></label>
                <div class="input-group" >
                    <input type="text" class="form-control xCNHide" id="oetZneAgnCode" name="oetZneAgnCode" maxlength="5" value="<?php echo @$tBrowseCode?>">
                    <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetZneAgnName" name="oetZneAgnName"  placeholder="<?php echo language('address/zone/zone','tZneSltAgency');?>" value="<?php echo @$tBrowseName?>"
                    data-validate-required = "<?= language('address/zone/zone','tZneValiReference')?>"
                    data-validate-dublicateCode = "<?= language('address/zone/zone','tZneValiReference')?>
                    " readonly>
                    <span class="input-group-btn">
                        <button id="obtBrowseAgency" type="button" class="btn xCNBtnBrowseAddOn">
                            <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <!-- Browse Merchant (กลุ่มธุรกิจ) -->
        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5" id="odvZneMerchant">	
            <div class="form-group" >
            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/zone/zone','tZneSltMerchant');?></label>
                <div class="input-group" >
                    <input type="text" class="form-control xCNHide" id="oetZneMchCode" name="oetZneMchCode" maxlength="5" value="<?php echo @$tBrowseCode?>">
                    <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetZneMchName" name="oetZneMchName"  placeholder="<?php echo language('address/zone/zone','tZneSltMerchant');?>" value="<?php echo @$tBrowseName?>"
                    data-validate-required = "<?= language('address/zone/zone','tZneValiReference')?>"
                    data-validate-dublicateCode = "<?= language('address/zone/zone','tZneValiReference')?>
                    " readonly>
                    <span class="input-group-btn">
                        <button id="obtBrowseMerchant" type="button" class="btn xCNBtnBrowseAddOn">
                            <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
            <div class="form-group">
                <div class="validate-input">
                    <label class="xCNLabelFrm"><?php echo language("address/zone/zone","tZneKeyRefer");?></label>
                    <input type="text" class="xCNInputWithoutSpc" maxlength="100" id="oetKeyReferName" name="oetKeyReferName" value="<?php echo @$tKeyReferName;?>">
                </div>
            </div>
        </div>
        <br>
    </div>

</div>

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
<?php include "script/jZoneAdd.php"; ?>
