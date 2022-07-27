<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute         = "pdtgroupEventEdit";
        $tPgpCode       = $aPgpData['raItems']['rtPgpCode'];
        $tPgpLevel      = $aPgpData['raItems']['rtPgpLevel'];
        $tPgpName       = $aPgpData['raItems']['rtPgpName'];
        $tPgpRmk        = $aPgpData['raItems']['rtPgpRmk'];
        $tPgpChain      = $aPgpData['raItems']['rtPgpChain'];
        $tPgpParentCode = $aPgpData['raItems']['rtPgpParentCode'];
        $tPgpParentName = $aPgpData['raItems']['rtPgpParentName'];
    }else{
        $tRoute         = "pdtgroupEventAdd";
        $tPgpCode       = "";
        $tPgpLevel      = "";
        $tPgpName       = "";
        $tPgpRmk        = "";
        $tPgpChain      = "";
        $tPgpParentCode = "";
        $tPgpParentName = "";
    }
?>
<!-- Product Group Input Hide -->
    <input type="text" class="xCNHide" id="ohdPdtGrpParent" value="">
<!-- Product Group Input Hide -->

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddPdtGroup">
    <button style="display:none" type="submit" id="obtSubmitPdtGroup" onclick="JSoAddEditPdtGroup('<?php echo $tRoute?>')"></button>
    <input type="hidden" id="ohdPdtGroupRoute" value="<?php echo $tRoute; ?>">
    <div class="panel panel-headline"><!-- เพิ่มมาใหม่ --> 
        <div class="panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
            <div class="row">
            <!-- เปลี่ยน Col Class -->
                <div class="col-xs-4 col-md-4 col-lg-4"> 
                    <div class="upload-img" id="oImgUpload">
                        <?php
      
                            if(isset($tImgObjAll) && !empty($tImgObjAll)){
                                $tFullPatch = './application/modules/'.$tImgObjAll;
                                $tPatchImg = base_url().'/application/modules/'.$tImgObjAll;
    
                                if (file_exists($tFullPatch)){
                                    $tPatchImg = base_url().'/application/modules/'.$tImgObjAll;
                                }else{
                                    $tPatchImg = base_url().'application/modules/common/assets/images/200x200.png';
                                }
                            }else{
                                $tPatchImg = base_url().'application/modules/common/assets/images/200x200.png';
                            }
                            
                            if(isset($tImgName) && !empty($tImgName)){
                                    $tImageNamePdtGrpParent   = $tImgName;
                                }else{
                                    $tImageNamePdtGrpParent   = '';
                            }
                        ?>      
                        <img id="oimImgMasterPdtGrpParent" class="img-responsive xCNImgCenter" style="width: 100%;" id="" src="<?php echo $tPatchImg;?>">
                    </div>
                        <div class="xCNUplodeImage">	
                            <input type="text" class="xCNHide" id="oetImgInputPdtGrpParentOld"  name="oetImgInputPdtGrpParentOld" value="<?php echo @$tImageNamePdtGrpParent;?>">
                            <input type="text" class="xCNHide" id="oetImgInputPdtGrpParent" name="oetImgInputPdtGrpParent" value="<?php echo @$tImgObjAll;?>">
                            <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('','','PdtGrpParent')">  <i class="fa fa-picture-o xCNImgButton"></i> <?php echo language('common/main/main','tSelectPic')?></button>
                        </div>
                </div>   
                <div class="col-xs-8 col-md-8 col-lg-8"> 
                    <div class="form-group">
                        <div class="validate-input">
                            <label class="fancy-checkbox">
                                    <input id="ocbPdtGrpSelectRoot" class="ocbSelectRoot xWSelectRoot"  name="ocbPdtGrpSelectRoot" type="checkbox">
                                    <span class="xCNLabelFrm"><?= language('product/pdtgroup/pdtgroup','tPGPFrmSelectRoot')?></span>
                                </label>
                            </div>
                        </div>
                        <div id="odvObjPgpChain" class="form-group">
                            <div class="form-group" data-validate="<?= language('product/pdtgroup/pdtgroup','tPGPValidPgpParent')?>">
                                <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdtgroup/pdtgroup','tPGPFrmParentGrp')?></label>
                                <input type="text" class="form-control xCNHide" id="oetPgpLevelOld" name="oetPgpLevelOld" value="<?=$tPgpLevel?>">
                                <input type="text" class="form-control xCNHide" id="oetPgpChain" name="oetPgpChain" value="<?=$tPgpParentCode?>">
                                <input type="text" class="form-control xCNHide" id="oetPgpChainOld" name="oetPgpChainOld" value="<?=$tPgpChain?>">
                                <input type="text" class="input100 xWPointerEventNone" id="oetPgpChainName" name="oetPgpChainName" maxlength="100" value="<?=$tPgpParentName?>" readonly>
                                <span class="focus-input100"></span>
                                <img id="oimBrowsePgpParent" class="xCNIconBrowse" src="<?= base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" value="0" id="ohdCheckPdtGroupClearValidate" name="ohdCheckPdtGroupClearValidate"> 
                            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('product/pdtgroup/pdtgroup','tPGPFrmPgpCode')?></label> <!-- เปลี่ยนชื่อ Class -->
                            <?php
                            if($tRoute=="pdtgroupEventAdd"){
                            ?>
                            <div class="form-group" id="odvPgpAutoGenCode">
                                <div class="validate-input">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbPgpAutoGenCode" name="ocbPgpAutoGenCode" checked="true" value="1">
                                        <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group" id="odvPunCodeForm">
                                <input 
                                    type="text" 
                                    class="form-control xCNInputWithoutSpcNotThai xCNInputNumericWithoutDecimal" 
                                    maxlength="5" 
                                    id="oetPgpCode" 
                                    name="oetPgpCode"
                                    data-is-created="<?php  ?>"
                                    placeholder="<?php echo language('product/pdtgroup/pdtgroup','tPGPFrmPgpCode')?>"
                                    value="<?php  ?>" 
                                    data-validate-required="<?php echo language('product/pdtgroup/pdtgroup','tPGPValidPgpCode')?>"
                                    data-validate-dublicateCode="<?php echo language('product/pdtgroup/pdtgroup','tPGPVldCodeDuplicate')?>"
                                    readonly
                                    onfocus="this.blur()">
                                <input type="hidden" value="2" id="ohdCheckDuplicatePgpCode" name="ohdCheckDuplicatePgpCode"> 
                            </div>
                            <?php
                            }else{
                            ?>
                            <div class="form-group" id="odvPunCodeForm">
                                <div class="validate-input">
                                    <label class="fancy-checkbox">
                                    <input 
                                        type="text" 
                                        class="form-control xCNInputWithoutSpcNotThai" 
                                        maxlength="5" 
                                        id="oetPgpCode" 
                                        name="oetPgpCode"
                                        data-is-created="<?php  ?>"
                                        placeholder="<?php echo language('product/pdtgroup/pdtgroup','tPGPFrmPgpCode')?>"
                                        value="<?php echo $tPgpCode; ?>" 
                                        readonly
                                        onfocus="this.blur()">
                                    </label>
                                </div>
                            <?php
                            }
                            ?>


                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('product/pdtgroup/pdtgroup','tPGPFrmPgpName')?></label>
                            <input type="text" class="form-control" maxlength="50" id="oetPgpName" name="oetPgpName" 
                            placeholder="<?php echo language('product/pdtgroup/pdtgroup','tPGPFrmPgpName')?>"
                            data-validate-required="<?php echo language('product/pdtgroup/pdtgroup','tPGPValidPgpName')?>" value="<?php echo $tPgpName ?>">
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('product/pdtgroup/pdtgroup','tPGPFrmPgpRmk')?></label> <!-- เปลี่ยนชื่อ Class -->
                            <textarea class="form-control" maxlength="100" rows="4" id="otaPgpRmk" name="otaPgpRmk"
                            ><?=$tPgpRmk?></textarea>
                        </div>
                    </div>
                
                </div>   
        </div>
    </div>
</form>


<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        <?php
        if($tRoute=="pdtgroupEventAdd"){
        ?>
            $('#ocbPdtGrpSelectRoot').prop("checked",true);
            $('#odvObjPgpChain').hide();
        <?php
        }else{
            if($tPgpParentName==""){
        ?>
            $('#ocbPdtGrpSelectRoot').prop("checked",true);
            $('#odvObjPgpChain').hide();
        <?php
            }
        }
        ?>
    });

    //Set Lang Edit 
    var nLangEdits  = <?=$this->session->userdata("tLangEdit")?>;

    //Option Browse PgpChain
    var oBrowsePgpParent    = {
        Title: ['product/pdtgroup/pdtgroup','tPGPTitle'],
        Table: {Master:'TCNMPdtGrp',PK:'FTPgpCode'},
        Join :{
            Table: ['TCNMPdtGrp_L'],
            On:['TCNMPdtGrp.FTPgpChain = TCNMPdtGrp_L.FTPgpChain AND TCNMPdtGrp_L.FNLngID = '+nLangEdits,]
        },
        GrideView: {
            ColumnPathLang	    : 'product/pdtgroup/pdtgroup',
            ColumnKeyLang	    : ['tPGPCode','tPGPChainCode','tPGPName','tPGPChain'],
            ColumnsSize         : ['10%','15%','30%','35%'],
            WidthModal          : 50,
            DataColumns		    : ['TCNMPdtGrp.FTPgpCode','TCNMPdtGrp.FTPgpChain','TCNMPdtGrp_L.FTPgpName','TCNMPdtGrp_L.FTPgpChainName'],
            DataColumnsFormat   : ['','','',''],
            Perpage			    : 5,
            OrderBy             : ['TCNMPdtGrp.FTPgpCode'],
            SourceOrder         : "DESC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetPgpChain","TCNMPdtGrp.FTPgpCode"],
            Text		: ["oetPgpChainName","TCNMPdtGrp_L.FTPgpChainName"],
        },
        NextFunc:{
            FuncName    : 'JSxCheckMaxLenPgpParent',
            ArgReturn   : ['FTPgpChain']
        },
        BrowseLev : '1'
    };

    //Set Event Browse
    $('#oimBrowsePgpParent').click(function(){JCNxBrowseData('oBrowsePgpParent');});

    var nLangEdits  = <?=$this->session->userdata("tLangEdit")?>;
    function JSxCheckMaxLenPgpParent(ptDataNextFunc){
        if(typeof(ptDataNextFunc) != undefined && ptDataNextFunc != "NULL"){
            var aDataNextFunc   = JSON.parse(ptDataNextFunc);
            var nPgpCode        = aDataNextFunc[0].length;
            if(nPgpCode >= 30){
                alert('<?php echo language('product/pdtgroup/pdtgroup','tPgpCodeMaxLen')?>');
                $('#oetPgpChain').val('');
                $('#oetPgpChainName').val('');
            }
        }
    }

    $('#ocbPdtGrpSelectRoot').click(function(){
        if($(this).is(':checked')){
            $('#oetPgpChain').val('');
            // $('#oetPgpChainName').val('');
            $('#odvObjPgpChain').fadeOut(500,function(){$(this).hide()});
        }else{
            $('#odvObjPgpChain').fadeIn(800,function(){$(this).show()});
        }
    });

    $('#oetPgpParent').on('change', function() {
        $('#ocbPdtGrpSelectRoot').prop('checked',false);
    });


</script>