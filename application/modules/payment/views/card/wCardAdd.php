<?php
    //Decimal Save
    $tDecSave = FCNxHGetOptionDecimalSave();

    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute         = "cardEventEdit";
        $tCrdCode       = $aCrdData['raItems']['rtCrdCode'];
        $tCrdHolderID   = $aCrdData['raItems']['rtCrdHolderID'];
        $tCrdRefID      = $aCrdData['raItems']['rtCrdRefID'];
        $tCrdName       = $aCrdData['raItems']['rtCrdName'];
        $tCrdCtyCode    = $aCrdData['raItems']['rtCrdCtyCode'];
        $tCrdCtyName    = $aCrdData['raItems']['rtCrdCtyName'];
        $tCrdStartDate  = (!empty($aCrdData['raItems']['rtCrdStartDate']))? date("Y-m-d", strtotime($aCrdData['raItems']['rtCrdStartDate'])) : '';
        $tCrdExpireDate = (!empty($aCrdData['raItems']['rtCrdExpireDate']))? explode(" ",$aCrdData['raItems']['rtCrdExpireDate']) : array('');
        $tCrdExpireDate = $tCrdExpireDate[0];
        $tCrdStaType    = $aCrdData['raItems']['rtCrdStaType'];
        $tCrdStaActive  = $aCrdData['raItems']['rtCrdStaActive'];
        $tCrdStaLocate  = $aCrdData['raItems']['rtCrdStaLocate'];
        $tCrdRmk        = $aCrdData['raItems']['rtCrdRmk'];
        $tCrdValue      = number_format($aCrdData['raItems']['rtCrdValue'],$tDecSave );
        $tCrdDeposit    = number_format($aCrdData['raItems']['rtCrdDeposit'],$tDecSave );
        $tCrdStaShift   = $aCrdData['raItems']['rtCrdStaShift'];
        $tCrdDepartmentCode = $aCrdData['raItems']['rtCrdDepartmentCode'];
        $tCrdDepartmentName = $aCrdData['raItems']['rtCrdDepartmentName'];
    }else{
        $tRoute         = "cardEventAdd";
        $tCrdCode       = "";
        $tCrdHolderID   = "";
        $tCrdRefID      = "";
        $tCrdName       = "";
        $tCrdCtyCode    = "";
        $tCrdCtyName    = "";
        $tCrdStartDate  = "";
        $tCrdExpireDate = "";
        $tCrdStaType    = "";
        $tCrdStaActive  = "";
        $tCrdStaLocate  = "";
        $tCrdRmk        = "";
        $tCrdValue      = "0.00";
        $tCrdDeposit    = "";
        $tCrdStaShift   = "";
        $tCrdDepartmentCode = "";
        $tCrdDepartmentName = "";
    }
?>
<style>
    #odvPanelCrdValue{
        background-color: #f0f4f7;
        height: 120px;
    }
    #odvPanelCrdValue > .panel-heading > hr{
        margin-top: 0px;
        margin-bottom: 0px;
        border: 0;
        border-top: 1px solid #CCC;
        margin-right: -20px;
    }
    #odvPanelCrdValue > .panel-body > label {
        font-size: 30px !important;
        font-weight: bold !important;
    }

    .xWCardActive {
        color: #007b00 !important;
        font-weight: bold;
        margin: 0;
    }
    .xWCardInActive {
        color: #7b7f7b !important;
        font-weight: bold;
        margin: 0;
    }
    .xWCardCancle {
        color: #f60a0a !important;
        font-weight: bold;
        margin: 0;
    }
</style>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="custom-tabs-line tabs-line-bottom left-aligned">
                        <ul class="nav" role="tablist">
                            <!-- ข้อมูลทั่วไป -->   
                            <li id="oliUsrloginDetail" class="xWMenu active" data-menutype="DT">
                                <a role="tab" data-toggle="tab" data-target="#odvCrdloginContentInfoDT" aria-expanded="true"><?php echo language('authen/user/user','tTabNormal')?></a>
                            </li>
                            
                            <!---ข้อมูลล็อกอิน-->
                            <!-- Witsarut Add 10/08/2019 14: 00 -->
                            <!-- ตรวจสอบโหมดการเรียก Page
                                ถ้าเป็นโหมดเพิ่ม ($aResult['rtCode'] == '99') ให้ปิด Tab ข้อมูลล็อกอิน 
                                ถ้าเป็นโหมดแก้ไข ($aResult['rtCode'] = 1) ให้เปิด Tab ข้อมูลล็อกอิน 
                            -->
                            <?php
                                if($nStaAddOrEdit == '99'){
                            ?>
                                <li id="oliCrdlogin" class="xWMenu xWSubTab disabled" data-menutype="Log">
                                    <a role="tab"   aria-expanded="true"><?php echo language('payment/cardlogin/cardlogin','tDetailLogin')?></a>
                                </li>
                            <?php }else{ ?>
                                <li id="oliCrdlogin" class="xWMenu xWSubTab" data-menutype="Log" onclick="JSxCrdloginGetContent();">
                                    <a role="tab" data-toggle="tab" data-target="#odvCrdloginData" aria-expanded="true"><?php echo language('payment/cardlogin/cardlogin','tDetailLogin')?></a>
                                </li>
                            <?php } ?>

                        </ul>
                    </div>
                </div>  
            </div>
            

            <div id="odvPdtRowContentMenu" class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <!-- Tab Content Detail -->
                    <div class="tab-content">
                        <div id="odvCrdloginContentInfoDT"  class="tab-pane fade active in">
                            <form class="validate-form" method="post" id="ofmAddCard">
                                <button type="submit" class="xCNHide" id="obtSubmitCard" onclick="JSoAddEditCard('<?php echo $tRoute?>')"></button>
                                <div class="panel-body" style="padding-top:20px !important;">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <div id="odvImageCard">
                                                    <?php
                                                        if(isset($tImgObjPath) && !empty($tImgObjPath)){
                                                            $tFullPatch = './application/modules/'.$tImgObjPath;
                                                            if (file_exists($tFullPatch)){
                                                                $tPatchImg = base_url().'application/modules/'.$tImgObjPath;
                                                            }else{
                                                                $tPatchImg = base_url().'application/modules/common/assets/images/200x200.png';
                                                            }
                                                        }else{
                                                            $tPatchImg  =   base_url().'application/modules/common/assets/images/200x200.png';
                                                        }
                                                    ?>
                                                    <img id="oimImgMasterCard" class="img-responsive xCNImgCenter" src="<?php  echo $tPatchImg;?>">
                                                </div>

                                                <div class="form-group">
                                                    <div class="xCNUplodeImage">
                                                        <input type="hidden" id="oetImgInputbranchOld" 	name="oetImgInputbranchOld" value="<?php echo @$tImgObjName;?>">
                                                        <input type="hidden" id="oetImgInputCard" name="oetImgInputCard" value="<?php echo @$tImgObjName;?>">
                                                        <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('','','Card')">
                                                            <i class="fa fa-camera"></i> <?php echo language('common/main/main','tSelectPic')?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                                            <label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('payment/card/card','tCRDFrmCrdCode')?></label>
                                                <div class="form-group" id="odvCardAutoGenCode">
                                                    <div class="validate-input">
                                                        <label class="fancy-checkbox">
                                                            <input type="checkbox" id="ocbCardAutoGenCode" name="ocbCardAutoGenCode" checked="true"  value="1">
                                                            <span><?php echo language('common/main/main', 'tGenerateAuto');?></span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div id="odvCardCodeForm" class="form-group">
                                                    <input type="hidden" id="ohdCheckDuplicateCrdCode" name="ohdCheckDuplicateCrdCode" value="1"> 
                                                    <div class="validate-input">
                                                        <input 
                                                            type="text" 
                                                            class="form-control xCNInputWithoutSpcNotThai" 
                                                            maxlength="5" 
                                                            id="oetCrdCode" 
                                                            name="oetCrdCode"
                                                            data-is-created="<?php echo $tCrdCode; ?>"
                                                            placeholder="<?php echo language('payment/card/card','tCRDFrmCrdCode')?>""
                                                            value="<?php echo $tCrdCode; ?>" 
                                                            data-validate-required = "<?php echo language('payment/card/card','tCRDValidCardCode')?>"
                                                            data-validate-dublicateCode = "<?php echo language('payment/card/card','tCRDValidCodeDup')?>"
                                                        >
                                                    </div>
                                                </div>

                                            <div class="form-group">
                                            <div class="validate-input">
                                                <label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('payment/card/card','tCRDFrmCrdHolderID')?></label>
                                                <input type="text" class="form-control" maxlength="30" id="oetCrdHolderID" name="oetCrdHolderID" value="<?php echo $tCrdHolderID;?>"
                                                data-validate-required = "<?php echo language('payment/card/card','tCRDValidCrdHolderID')?>"
                                                >
                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('payment/card/card','tCRDFrmCrdRefID')?></label>
                                                <input type="text" class="form-control" maxlength="30" id="oetCrdRefID" name="oetCrdRefID" value="<?php echo $tCrdRefID;?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('payment/card/card','tCRDFrmCrdName')?></label>
                                                <input type="text" class="form-control" maxlength="200" id="oetCrdName" name="oetCrdName" value="<?php echo $tCrdName;?>">
                                            </div>
                                            <!--Department-->
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><span style ="color:red">*</span><?php echo language('payment/card/card','tCRDDepartment')?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control xCNHide" id="oetCrdDepartment" name="oetCrdDepartment" value="<?php echo $tCrdDepartmentCode; ?>" data-validate="<?php echo  language('payment/card/card','tCRDValiDepartment');?>">
                                                    <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetCrdDepartmentName" name="oetCrdDepartmentName" value="<?php echo $tCrdDepartmentName; ?>" 
                                                    data-validate-required = "<?php echo language('payment/card/card','tCRDValidDepartmentName')?>"
                                                    readonly>
                                                    <span class="input-group-btn">
                                                        <button id="obtBrowseDepartment" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--End Department-->
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('payment/card/card','tCRDFrmCtyCode')?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control xCNHide" id="oetCrdCtyCode" name="oetCrdCtyCode" value="<?php echo $tCrdCtyCode; ?>" data-validate="<?php echo  language('payment/card/card','tCRDValidCardTypeCode');?>">
                                                    <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetCrdCtyName" name="oetCrdCtyName" value="<?php echo $tCrdCtyName ?>" data-validate="<?php echo  language('payment/card/card','tCRDValidCardTypeName');?>" readonly
                                                    data-validate-required = "<?php echo language('payment/card/card','tCRDValidCrdCtyName')?>"
                                                    >
                                                    <span class="input-group-btn">
                                                        <button id="obtBrowseCardType" type="button" class="btn xCNBtnBrowseAddOn">
                                                            <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('payment/card/card','tCRDFrmCrdDeposit')?></label>
                                                <input type="text" class="form-control xCNInputNumericWithDecimal text-right" id="oetCrdDeposit" name="oetCrdDeposit" onclick="JCNdValidateComma('oetCrdDeposit',3,'FC');" onfocusout="JCNdValidatelength8Decimal('oetCrdDeposit','FC',3,'<?php echo $tDecSave?>')"  value="<?php echo $tCrdDeposit;?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('payment/card/card','tCRDFrmCrdStartDate')?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetCrdStartDate" name="oetCrdStartDate" autocomplete="off" value="<?php echo $tCrdStartDate;?>" data-validate="<?php echo language('payment/card/card','tCRDValidCardStartDate')?>">
                                                    <span class="input-group-btn">
                                                        <button id="obtCrdStartDate" type="button" class="btn xCNBtnDateTime">
                                                            <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('payment/card/card','tCRDFrmCrdExpireDate')?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetCrdExpireDate" name="oetCrdExpireDate" autocomplete="off" value="<?php echo $tCrdExpireDate;?>">
                                                    <span class="input-group-btn">
                                                        <button id="obtCrdExpireDate" type="button" class="btn xCNBtnDateTime">
                                                            <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('payment/card/card','tCRDFrmCrdStaType')?></label>
                                                <select class="selectpicker form-control xCNSelectBox" id="ocmCrdStaType" name="ocmCrdStaType" onchange="JSxChkUseCrdStaType()">
                                                    <option value='2' <?php echo ($tCrdStaType == 2)? 'selected':''?>><?php echo language('payment/card/card','tCRDFrmCrdStaTypeDefault')?></option>
                                                    <option value='1' <?php echo ($tCrdStaType == 1)? 'selected':''?>><?php echo language('payment/card/card','tCRDFrmCrdStaTypeNormal')?></option>
                                                </select>
                                            </div>
                                            <!-- สถานะ เบิกใช้งานบัตร -->
                                            <!-- <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('payment/card/card','tCRDFrmCrdStaLocate')?></label>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                                        <label class="fancy-radio xCNRadioMain">
                                                            <input type="radio" id="ocbCrdStaLocateUse" name="ordCrdStaLocate" value="1" <?php echo ($tCrdStaLocate == 1)? 'checked':'';?> disabled>
                                                            <span><i></i> <?php echo language('payment/card/card','tCRDFrmCrdStaLocUseNewWord')?></span>
                                                        </label>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                                        <label class="fancy-radio xCNRadioMain">
                                                            <input type="radio" id="ocbCrdStaLocateUnUse" name="ordCrdStaLocate" value="2" <?php echo ($tCrdStaLocate == 2)? 'checked':'';?> disabled>
                                                            <span><i></i> <?php echo language('payment/card/card','tCRDFrmCrdStaLocUnUseNewWord')?></span>
                                                        </label>
                                                    </div>    
                                                </div>
                                            </div> -->

                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('payment/card/card','tCRDFrmCrdStaActive')?></label>
                                                    <select  required  class="selectpicker form-control xCNSelectBox" id="ocmCrdStaAct" name="ocmCrdStaAct" data-live-search="true"> 
                                                        <option value='1' <?php echo  (isset($tCrdStaActive ) && !empty($tCrdStaActive) && $tCrdStaActive == '1')? "selected":""?>>
                                                            <?php echo language('payment/card/card','tCRDFrmCrdActive')?>
                                                        </option>
                                                        <option value='2' <?php echo  (isset($tCrdStaActive) && !empty($tCrdStaActive) && $tCrdStaActive == '2')? "selected":""?>>
                                                            <?php echo language('payment/card/card','tCRDFrmCrdInactive')?>
                                                        </option>
                                                        <option value='3' <?php echo  (isset($tCrdStaActive) && !empty($tCrdStaActive) && $tCrdStaActive == '3')? "selected":""?>>
                                                            <?php echo language('payment/card/card','tCRDFrmCrdCancel')?>
                                                        </option>
                                                    </select>                        
                                                </div>

                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('payment/card/card','tCRDFrmCrdRmk')?></label>
                                                <textarea class="form-control" maxlength="100" rows="4" id="otaCrdRmk" name="otaCrdRmk"><?php echo $tCrdRmk; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                            <div id="odvPanelCrdValue" class="panel-headline">
                                                <div class="panel-heading text-right">
                                                    <label class="xCNLabelFrm"><?php echo language('payment/card/card','tCRDFrmCrdValue')?></label>
                                                    <hr>
                                                </div>
                                                <div class="panel-body text-right">
                                                    <label><?php echo $tCrdValue; ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                         <!-- Tab CardLogin  -->
                        <div id="odvCrdloginData" class="tab-pane fade"></div>
                    </div>
                </div>
            </div>
        </div>

<?php include "script/jCardAdd.php"; ?>

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>


<script type="text/javascript">

    $('#ocmCrdStaAct').selectpicker();

    var nLangEdits      = <?php echo $this->session->userdata("tLangEdit")?>;
    var nStaAddOrEdit   = <?php echo $nStaAddOrEdit?>;
    var tCrdStaShift = '<?php echo $tCrdStaShift?>';
    var dDatNow         = '<?php echo date('Y-m-d')?>';
    $(document).ready(function(){
        $('.xCNSelectBox').selectpicker();

         $('#obtCrdStartDate').click(function(event){
            $('#oetCrdStartDate').datepicker({
                format: "yyyy-mm-dd",
                todayHighlight: true,
                enableOnReadonly: false,
                startDate :'1900-01-01',
                disableTouchKeyboard : true,
                autoclose: true,
            });
            $('#oetCrdStartDate').datepicker('show');
            event.preventDefault();
        });

        $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            startDate :'1900-01-01',
            disableTouchKeyboard : true,
            autoclose: true
        });

        $('#obtCrdStartDate').click(function(event){
            $('#oetCrdStartDate').datepicker('show');
            event.preventDefault();
        });

        $('#obtCrdExpireDate').click(function(event){
            $('#oetCrdExpireDate').datepicker('show');
            event.preventDefault();
        });

        if(nStaAddOrEdit === 99){
            $('#oetCrdDeposit').val('0.00');
            $('#ocbCrdStaLocateUse').prop("checked", true);
            $('#oetCrdStartDate').removeAttr('maxlength');
            $('#oetCrdExpireDate').removeAttr('maxlength');
            $('#oetCrdStartDate').val(dDatNow);
            $('#oetCrdExpireDate').val('9999-12-31');
            JSxChkUseCrdStaType();
        }else{
            JSxChkStaCardStaShif(tCrdStaShift);
        }
    });

    //Browse Card Type
    var oCrdBrwCardType = {
        Title : ['payment/cardtype/cardtype','tCTYTitle'],
        Table:{Master:'TFNMCardType',PK:'FTCtyCode'},
        Join :{
            Table:	['TFNMCardType_L'],
            On:['TFNMCardType_L.FTCtyCode = TFNMCardType.FTCtyCode AND TFNMCardType_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'payment/cardtype/cardtype',
            ColumnKeyLang	: ['tCTYCode','tCTYName','tCRDFrmCrdDeposit'],
            DataColumns		: ['TFNMCardType.FTCtyCode','TFNMCardType_L.FTCtyName','TFNMCardType.FCCtyDeposit'],
            DisabledColumns : [2],
            Perpage			: 10,
            OrderBy			: ['TFNMCardType.FDCreateOn DESC']
            // SourceOrder		: "DESC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetCrdCtyCode","TFNMCardType.FTCtyCode"],
            Text		: ["oetCrdCtyName","TFNMCardType_L.FTCtyName"],
        },
        NextFunc:{
            FuncName:'JSxNextFuncCrdType',
            ArgReturn:['FTCtyCode','FTCtyName','FCCtyDeposit']
        },
        RouteAddNew : 'cardtype',
        BrowseLev : nStaCrdBrowseType
    }

    $('#obtBrowseCardType').click(function(){JCNxBrowseData('oCrdBrwCardType');});


    //Browse Department
    var oCrdBrwDepartment = {
        Title : ['authen/department/department','tDPTTitle'],
        Table:{Master:'TCNMUsrDepart',PK:'FTDptCode'},
        Join :{
            Table:	['TCNMUsrDepart_L'],
            On:['TCNMUsrDepart_L.FTDptCode = TCNMUsrDepart.FTDptCode AND TCNMUsrDepart_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'authen/department/department',
            ColumnKeyLang	: ['tDPTTBCode','tDPTTBName'],
            DataColumns		: ['TCNMUsrDepart.FTDptCode','TCNMUsrDepart_L.FTDptName'],
            // DisabledColumns : [2],
            Perpage			: 10,
            OrderBy			: ['TCNMUsrDepart.FDCreateOn DESC']
            // SourceOrder		: "DESC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetCrdDepartment","TCNMUsrDepart.FTDptCode"],
            Text		: ["oetCrdDepartmentName","TCNMUsrDepart_L.FTDptName"],
        },
        NextFunc:{
            FuncName:'JSxNextFuncDetType',
            ArgReturn:['FTDptCode']
        },
        RouteAddNew : 'department',
        BrowseLev : nStaCrdBrowseType
    }

    $('#obtBrowseDepartment').click(function(){JCNxBrowseData('oCrdBrwDepartment');});

    function JSxChkStaCardStaShif(tCrdStaShift){
        if(tCrdStaShift != "" && tCrdStaShift != 1){
            // $('#oetCrdHolderID').prop('readonly', true);
            
            // $('#oetCrdRefID').prop('readonly', true);

            $('#obtBrowseCardType').prop('disabled', true);

            $('#oetCrdDeposit').prop('readonly', true);

            $('#oetCrdStartDate').prop('readonly', true);
            $('#obtCrdStartDate').prop('disabled', true);

            $('#oetCrdExpireDate').prop('readonly', true);
            $('#obtCrdExpireDate').prop('disabled', true);

            $('#ocmCrdStaType').parent().addClass('xCNDivSelectReadOnly');
            $('#ocmCrdStaType').parent().find('button').addClass('xCNBtnSelectReadOnly');
        }
    }

    function JSxNextFuncDetType(paDataReturn){
        $('#oetCrdDepartmentName').closest('.form-group').addClass( "has-success" ).removeClass( "has-error");
        $('#oetCrdDepartmentName').closest('.form-group').find(".help-block").fadeOut('slow').remove();
    }

    function JSxNextFuncCrdType(paDataReturn){
        $('#oetCrdCtyName').closest('.form-group').addClass( "has-success" ).removeClass( "has-error");
        $('#oetCrdCtyName').closest('.form-group').find(".help-block").fadeOut('slow').remove();
        var aPdtTypeData = JSON.parse(paDataReturn);
        $('#oetCrdDeposit').val(accounting.formatNumber(aPdtTypeData[2],2));
    }

    function JSxChkUseCrdStaType(){
        var tCrdStaType = $('#ocmCrdStaType').val();
        if(tCrdStaType == '1'){
            $('#ocbCrdStaLocateUse').prop( "checked",true);
            $('#ocbCrdStaLocateUnUse').prop( "checked",false);
        }else{
            $('#ocbCrdStaLocateUse').prop( "checked",false);
            $('#ocbCrdStaLocateUnUse').prop( "checked",true);
        }
    }
</script>

