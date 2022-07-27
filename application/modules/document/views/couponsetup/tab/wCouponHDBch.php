
<div id="odvTabCouponHDBch" class="tab-pane fade active in">
        <div class="row">
            <div class="table-responsive">

              <div  style="padding-bottom: 20px;">
                    <?php  if($this->session->userdata('nSesUsrBchCount')!=1){ ?>
                  <button id="obtTabCouponHDBchInclude" class="xCNBTNPrimeryPlus xCNInputWhenStaCancelDoc" type="button">+</button>
                    <?php } ?>
                </div>
               <div>
                 <label  class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDBchInclude')?></label>
               </div> 
        
             <table  class="table xWPdtTableFont">
                    <thead>
                        <tr class="xCNCenter">
                            <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDBchCode')?></th>
                            <th nowrap class="xCNTextBold" style="width:30%;"><?php echo language('company/merchant/merchant','tMerchantTitle')?></th>
                            <th nowrap class="xCNTextBold" style="width:80%;"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDBchName')?></th>
                            <th nowrap class="xCNTextBold" style="width:30%;"><?php echo language('company/shop/shop','tSHPTitle')?></th>
                            <th  style="width:10%;"></th>
                        </tr >
                    </thead>
                    <tbody id="otbCouponHDBchInclude">
                    <?php 
                            if($tCPHRoute == "dcmCouponSetupEventAdd" && $this->session->userdata('tSesUsrLevel')!='HQ'){ 
                                $tSesUsrBchCodeMulti = str_replace("'","",$this->session->userdata('tSesUsrBchCodeMulti'));
                                $tSesUsrBchNameMulti = str_replace("'","",$this->session->userdata('tSesUsrBchNameMulti'));
                                $aBchCodeArray = explode(',',$tSesUsrBchCodeMulti);
                                $aBchNameArray = explode(',',$tSesUsrBchNameMulti);
                                if(!empty($aBchCodeArray)){
                                    $nNum = 1;
                                    foreach($aBchCodeArray as $nK => $tBchCode){
                                ?>
                                <tr class='otrInclude' id='otrCPHcouponIncludeBch<?=$nK?>'>
                                <td>
                                <input type='hidden' name='ohdCPHCouponIncludeBchCode[<?=$nK?>]' class='ohdCPHCouponIncludeBchCode' value='<?=$tBchCode?>'>
                                <input type='hidden' name='ohdCPHCouponIncludeMerCode[<?=$nK?>]' class='ohdCPHCouponIncludeMerCode' value='<?=$this->session->userdata('tSesUsrMerCode')?>'>
                                <input type='hidden' name='ohdCPHCouponIncludeShpCode[<?=$nK?>]' class='ohdCPHCouponIncludeShpCode' value=''<?=$this->session->userdata('tSesUsrShpCodeDefault')?>>
                                <?=$tBchCode?>
                                </td>
                                <td><?=$aBchNameArray[$nK]?></td>
                                <td><?=$this->session->userdata('tSesUsrMerName')?></td>
                                <td><?=$this->session->userdata('tSesUsrShpNameDefault')?></td>
                                <td align='center'>
                                <?php  if($this->session->userdata('nSesUsrBchCount')!=1){ ?>
                                <img onclick='JSxCPHcouponRemoveTRIncludeBch(<?=$nK?>)' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' >
                                <?php } ?>
                                </td>
                                </tr>
                       <?php    
                                    }
                                    $nNum++;
                                }


                        }
                    ?>
                    <?php if(!empty($aDataDocHD['raCouponDetailInOrEx']['aCouponHDBch'][1])){
                                  foreach($aDataDocHD['raCouponDetailInOrEx']['aCouponHDBch'][1] AS $nKey => $aValue){ 
                                     $nI=strtotime(date('Y-m-d H:i:s')).$nKey;
                                ?>
                           <tr class='otrInclude' id='otrCPHcouponIncludeBch<?=$nI?>'>
                            <td>
                            <input type='hidden' name='ohdCPHCouponIncludeBchCode[<?=$nI?>]' class='ohdCPHCouponIncludeBchCode' value='<?=$aValue['FTCphBchTo']?>'>
                            <input type='hidden' name='ohdCPHCouponIncludeMerCode[<?=$nI?>]' class='ohdCPHCouponIncludeMerCode' value='<?=$aValue['FTCphMerTo']?>'>
                            <input type='hidden' name='ohdCPHCouponIncludeShpCode[<?=$nI?>]' class='ohdCPHCouponIncludeShpCode' value='<?=$aValue['FTCphShpTo']?>'>
                            <?=$aValue['FTCphBchTo']?>
                            </td>
                            <td><?=$aValue['FTBchName']?></td>
                            <td><?=$aValue['FTMerName']?></td>
                            <td><?=$aValue['FTShpName']?></td>
                            <td align='center'>
                            <?php  if($this->session->userdata('nSesUsrBchCount')!=1){ ?>
                            <img onclick='JSxCPHcouponRemoveTRIncludeBch(<?=$nI?>)' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>
                            <?php } ?>
                            </tr>
                        <?php } 
                             } ?>
                    </tbody>
                </table>
                </div>

                <div class="table-responsive">
                <div  style="padding-bottom: 20px;">
                <?php  if($this->session->userdata('nSesUsrBchCount')!=1){ ?>
                  <button id="obtTabCouponHDBchExclude" class="xCNBTNPrimeryPlus xCNInputWhenStaCancelDoc" type="button">+</button>
                  <?php } ?>
                </div>
               <div>
                 <label  class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDBchExclude')?></label>
               </div> 
             <table  class="table xWPdtTableFont">
                    <thead>
                        <tr class="xCNCenter">
                            <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDBchCode')?></th>
                            <th nowrap class="xCNTextBold" style="width:80%;"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDBchName')?></th>
                             <th nowrap class="xCNTextBold" style="width:30%;"><?php echo language('company/merchant/merchant','tMerchantTitle')?></th>
                            <th nowrap class="xCNTextBold" style="width:30%;"><?php echo language('company/shop/shop','tSHPTitle')?></th> 
                            <th  style="width:10%;"></th>
                        </tr>
                    </thead>
                    <tbody id="otbCouponHDBchExclude">
                    <?php if(!empty($aDataDocHD['raCouponDetailInOrEx']['aCouponHDBch'][2])){
                                  foreach($aDataDocHD['raCouponDetailInOrEx']['aCouponHDBch'][2] AS $nKey => $aValue){ 
                                     $nI=strtotime(date('Y-m-d H:i:s')).$nKey;
                                ?>
                           <tr class='otrExclude' id='otrCPHcouponExcludeBch<?=$nI?>'>
                            <td>
                            <input type='hidden' name='ohdCPHCouponExcludeBchCode[<?=$nI?>]' class='ohdCPHCouponExcludeBchCode' value='<?=$aValue['FTCphBchTo']?>'>
                            <input type='hidden' name='ohdCPHCouponExcludeMerCode[<?=$nI?>]' class='ohdCPHCouponExcludeMerCode' value='<?=$aValue['FTCphMerTo']?>'>
                            <input type='hidden' name='ohdCPHCouponExcludeShpCode[<?=$nI?>]' class='ohdCPHCouponExcludeShpCode' value='<?=$aValue['FTCphShpTo']?>'>
                            <?=$aValue['FTCphBchTo']?>
                            </td>
                            <td><?=$aValue['FTBchName']?></td>
                             <td><?=$aValue['FTMerName']?></td>
                            <td><?=$aValue['FTShpName']?></td> 
                            <td align='center'><img onclick='JSxCPHcouponRemoveTRExcludeBch(<?=$nI?>)' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>
                            </tr>
                        <?php } 
                             } ?>
                    </tbody>
                </table>
                </div>

            </div>
</div>


<div  class="modal fade" id="odvCPHCouponHDBch" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('document/couponsetup/couponsetup','tCPHTabCouponHDBchSelect')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
      <div class="modal-body">
    <input  type="hidden" name="ohdCPHcouponModalTypeInclude" id="ohdCPHcouponModalTypeInclude">
        <div class='row'>

                <div class='col-lg-12'>
                        <div class='form-group'>
                            <label class="xCNLabelFrm"><?=language('company/branch/branch','tBCHTitle')?></label>
                            <div class='input-group'>
                                <input type='text' class='form-control xCNHide xWCPHAllInput' id='oetCPHBchCodeTo' name='oetCPHBchCodeTo' maxlength='5'>
                                <input type='text' class='form-control xWPointerEventNone xWCPHAllInput' id='oetCPHBchNameTo' name='oetCPHBchNameTo' readonly>
                                <span class='input-group-btn'>
                                    <button id='obtCPHBrowseBchTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class='col-lg-12' >
                        <div class='form-group'>
                        <label class="xCNLabelFrm"><?=language('company/branch/branch','tMerchantTitle')?></label>
                            <div class='input-group'>
                                <input type='text' class='form-control xCNHide xWCPHAllInput' id='oetCPHMerCodeTo' name='oetCPHMerCodeTo' maxlength='5'>
                                <input type='text' class='form-control xWPointerEventNone xWCPHAllInput' id='oetCPHMerNameTo' name='oetCPHMerNameTo' readonly>
                                <span class='input-group-btn'>
                                    <button id='obtCPHBrowseMerTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                </span>
                            </div>
                        </div>
                    </div>

                <div class='col-lg-12' >
                    <div class='form-group'>
                    <label class="xCNLabelFrm"><?=language('company/branch/branch','tSHPTitle')?></label>
                        <div class='input-group'>
                            <input type='text' class='form-control xCNHide xWCPHAllInput' id='oetCPHShpCodeTo' name='oetCPHShpCodeTo' maxlength='5'>
                            <input type='text' class='form-control xWPointerEventNone xWCPHAllInput' id='oetCPHShpNameTo' name='oetCPHShpNameTo' readonly>
                            <span class='input-group-btn'>
                                <button id='obtCPHBrowseShpTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
    
      </div>
      <div class="modal-footer">
        <button type="button"  class="btn xCNBTNPrimery" id="obtCPHCouponSelectBch" ><?=language('common/main/main','tModalAdvChoose')?></button>
        <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main','tModalAdvClose')?></button>
      </div>
    </div>
  </div>
</div>

<script>


function JSnCHPCheckDuplicationRowHDBch(paData){

    let nLenIn = $('input[name^="ohdCPHCouponIncludeBchCode["]').length
    let aEchDataIn = JSxCreateArray(nLenIn,3);
    //Include
    $('input[name^="ohdCPHCouponIncludeBchCode["]').each(function(index){
        let tBchCode = $(this).val();
        aEchDataIn[index][0]=tBchCode;
    });
    $('input[name^="ohdCPHCouponIncludeMerCode["]').each(function(index){
        let tMerCode = $(this).val();
        aEchDataIn[index][1]=tMerCode;
    });
    $('input[name^="ohdCPHCouponIncludeShpCode["]').each(function(index){
        let tShpCode = $(this).val();
        aEchDataIn[index][2]=tShpCode;
    });

    let nLenEx = $('input[name^="ohdCPHCouponExcludeBchCode["]').length
    let aEchDataEx = JSxCreateArray(nLenEx,3);
    //Exclude
    $('input[name^="ohdCPHCouponExcludeBchCode["]').each(function(index){
        let tBchCode = $(this).val();
        aEchDataEx[index][0]=tBchCode;
    });
    $('input[name^="ohdCPHCouponExcludeMerCode["]').each(function(index){
        let tMerCode = $(this).val();
        aEchDataEx[index][1]=tMerCode;
    });
    $('input[name^="ohdCPHCouponExcludeShpCode["]').each(function(index){
        let tShpCode = $(this).val();
        aEchDataEx[index][2]=tShpCode;
    });

    // console.log("aEchDataIn",aEchDataIn);
    // console.log("aEchDataEx",aEchDataEx);

    let nAproveAppend = 0;
    for(i=0;i<aEchDataIn.length;i++){
        if(aEchDataIn[i][0]==paData.tCPHBchCodeTo && aEchDataIn[i][1]==paData.tCPHMerCodeTo && aEchDataIn[i][2]==paData.tCPHShpCodeTo){
            nAproveAppend++;
        }
    }
    for(i=0;i<aEchDataEx.length;i++){
        if(aEchDataEx[i][0]==paData.tCPHBchCodeTo && aEchDataEx[i][1]==paData.tCPHMerCodeTo && aEchDataEx[i][2]==paData.tCPHShpCodeTo){
            nAproveAppend++;
        }
    }
    // console.log(nAproveAppend);
    return nAproveAppend;
}

$('#obtCPHCouponSelectBch').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
          var tCouponModalTypeInclude = $('#ohdCPHcouponModalTypeInclude').val();
          var tCPHBchCodeTo           = $('#oetCPHBchCodeTo').val();
          var tCPHBchNameTo           = $('#oetCPHBchNameTo').val();
          var tCPHMerCodeTo           = $('#oetCPHMerCodeTo').val();
          var tCPHMerNameTo           = $('#oetCPHMerNameTo').val();
          var tCPHShpCodeTo           = $('#oetCPHShpCodeTo').val();
          var tCPHShpNameTo           = $('#oetCPHShpNameTo').val();
          if(tCPHBchCodeTo!=''){
          let aData = { 
                         tCPHBchCodeTo:tCPHBchCodeTo,
                         tCPHBchNameTo:tCPHBchNameTo,
                         tCPHMerCodeTo:tCPHMerCodeTo,
                         tCPHMerNameTo:tCPHMerNameTo,
                         tCPHShpCodeTo:tCPHShpCodeTo,
                         tCPHShpNameTo:tCPHShpNameTo,
                         }
                
           let nAproveSta = JSnCHPCheckDuplicationRowHDBch(aData);
            
            if(nAproveSta==0){

                if(tCouponModalTypeInclude==1){
                    JSxConsNextFuncBrowseBchInclude(aData);
                }else{
                    JSxConsNextFuncBrowseBchExclude(aData);
                }
                
                $("#odvCPHCouponHDBch").modal('hide');
            }else{
             alert('Data Select Duplicate.');
            }
        }else{
            alert('Please Select Branch.');
        }

        }
});

$('#obtCPHBrowseBchTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oCPHBranchOptionTo   = undefined;
            oCPHBranchOptionTo          = oCPHBranchOption({
                'tReturnInputCode'  : 'oetCPHBchCodeTo',
                'tReturnInputName'  : 'oetCPHBchNameTo',
        
            });
            JCNxBrowseData('oCPHBranchOptionTo');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


    $('#obtCPHBrowseMerTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oCPHMerChantOptionTo = undefined;
            oCPHMerChantOptionTo        = oCPHMerChantOption({
                'tReturnInputCode'  : 'oetCPHMerCodeTo',
                'tReturnInputName'  : 'oetCPHMerNameTo',
                'tNextFuncName'     : 'JSxCPHConsNextFuncBrowseMerChant',
                'aArgReturn'        : ['FTMerCode','FTMerName']
            });
            JCNxBrowseData('oCPHMerChantOptionTo');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


    $('#obtCPHBrowseShpTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
  
            let tCPHBranchForm  = $('#oetCPHBchCodeTo').val();
            let tCPHBranchTo    = $('#oetCPHBchCodeTo').val();
            window.oCPHShopOptionTo = undefined;
            oCPHShopOptionTo        = oCPHShopOption({
                'tReturnInputCode'  : 'oetCPHShpCodeTo',
                'tReturnInputName'  : 'oetCPHShpNameTo',
                'tCPHBranchForm'    : tCPHBranchForm,
                'tCPHBranchTo'      : tCPHBranchTo,
                'tNextFuncName'     : 'JSxCPHConsNextFuncBrowseShp',
                'aArgReturn'        : ['FTShpCode','FTShpName']
            });
            JCNxBrowseData('oCPHShopOptionTo');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

      /*===== Begin Browse Option ======================================================= */





      var oCPHBranchOption = function(poCPHReturnInputBch){
        let tCPHNextFuncNameBch    = poCPHReturnInputBch.tNextFuncName;
        let aCPHArgReturnBch       = poCPHReturnInputBch.aArgReturn;
        let tCPHInputReturnCodeBch = poCPHReturnInputBch.tReturnInputCode;
        let tCPHInputReturnNameBch = poCPHReturnInputBch.tReturnInputName;

              
      var tUsrLevel     = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
        var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        var nCountBch     = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
        var tMerCode = $('#oetCPHMerCodeTo').val();
        var tWhere = "";

        if(nCountBch == 1){
            $('#obtCPHBrowseBchTo').attr('disabled',true);
        }
        if(tUsrLevel != "HQ"){
            tWhere += " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
        }else{
            tWhere += "";
        }

        // if(tMerCode!=''){
        //     tWhere += " AND TCNMBranch.FTMerCode = '"+tMerCode+"' ";
        // }


        let oCPHOptionReturnBch    = {
            Title: ['company/branch/branch','tBCHTitle'],
            Table:{Master:'TCNMBranch',PK:'FTBchCode'},
            Join :{
                Table:	['TCNMBranch_L'],
                On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
            },
            Where : {
                        Condition : [tWhere]
                    },
            GrideView:{
                ColumnPathLang	: 'company/branch/branch',
                ColumnKeyLang	: ['tBCHCode','tBCHName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TCNMBranch_L.FTBchCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tCPHInputReturnCodeBch,"TCNMBranch.FTBchCode"],
                Text		: [tCPHInputReturnNameBch,"TCNMBranch_L.FTBchName"]
            },
        
            RouteAddNew: 'branch',
            BrowseLev: 0
        };
        return oCPHOptionReturnBch;
    };


    // Browse Merchant Option
    var oCPHMerChantOption  = function(poReturnInputMer){
        let tMerInputReturnCode = poReturnInputMer.tReturnInputCode;
        let tMerInputReturnName = poReturnInputMer.tReturnInputName;
        let tMerNextFuncName    = poReturnInputMer.tNextFuncName;
        let aMerArgReturn       = poReturnInputMer.aArgReturn;
        let oMerOptionReturn    = {
            Title: ['company/merchant/merchant','tMerchantTitle'],
            Table: {Master:'TCNMMerchant',PK:'FTMerCode'},
            Join: {
                Table: ['TCNMMerchant_L'],
                On: ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = '+nLangEdits]
            },
            GrideView: {
                ColumnPathLang	: 'company/merchant/merchant',
                ColumnKeyLang	: ['tMerCode','tMerName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMMerchant.FTMerCode','TCNMMerchant_L.FTMerName'],
                DataColumnsFormat : ['',''],
                Perpage			: 5,
                OrderBy			: ['TCNMMerchant.FTMerCode ASC'],
            },
            CallBack: {
                ReturnType	: 'S',
                Value		: [tMerInputReturnCode,"TCNMMerchant.FTMerCode"],
                Text		: [tMerInputReturnName,"TCNMMerchant_L.FTMerName"],
            },
            NextFunc : {
                FuncName    : tMerNextFuncName,
                ArgReturn   : aMerArgReturn
            },
            RouteAddNew: 'merchant',
            BrowseLev: 0,
        };
        return oMerOptionReturn;
    }


 
 // Browse Shop Option
 var oCPHShopOption = function(poReturnInputShp){
        let tShpNextFuncName        = poReturnInputShp.tNextFuncName;
        let aShpArgReturn           = poReturnInputShp.aArgReturn;
        let tShpInputReturnCode     = poReturnInputShp.tReturnInputCode;
        let tShpInputReturnName     = poReturnInputShp.tReturnInputName;
       
        let tShpCPHBranchForm       = poReturnInputShp.tCPHBranchForm;
        let tShpCPHBranchTo         = poReturnInputShp.tCPHBranchTo;
        let tShpWhereShop           = "";
        let tShpWhereShopAndBch     = "";

        // Case Report Type POS,VD,LK
      
                // Report Pos (รานงานการขาย)
                // tShpWhereShop       = " AND (TCNMShop.FTShpStaActive = 1) AND (TCNMShop.FTShpType = 1)";
                // tShpWhereShopAndBch = " AND ((TCNMShop.FTBchCode BETWEEN "+tShpCPHBranchForm+" AND "+tShpCPHBranchTo+") OR (TCNMShop.FTBchCode BETWEEN "+tShpCPHBranchTo+" AND "+tShpCPHBranchForm+"))";
                
                // Report Pos (รานงานการขาย) + Report Vending (รานงานตู้ขายสินค้า)
                tShpWhereShop       = " AND (TCNMShop.FTShpStaActive = 1)";
                tShpWhereShopAndBch = " AND ((TCNMShop.FTBchCode BETWEEN "+tShpCPHBranchForm+" AND "+tShpCPHBranchTo+") OR (TCNMShop.FTBchCode BETWEEN "+tShpCPHBranchTo+" AND "+tShpCPHBranchForm+"))";
   
        if(typeof tShpCPHBranchForm === 'undefined'  && typeof tShpCPHBranchTo === 'undefined'){
            // แสดงข้อมูล ร้านค้าทั้งหมดตามประเภทของรายงาน
            var oShopOptionReturn       = {
                Title   : ['company/shop/shop','tSHPTitle'],
                Table   : {Master:'TCNMShop', PK:'FTShpCode'},
                Join    : {
                    Table   : ['TCNMShop_L', 'TCNMBranch_L'],
                    On      : [
                        'TCNMShop.FTBchCode = TCNMShop_L.FTBchCode      AND TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                        'TCNMShop.FTBchCode = TCNMBranch_L.FTBchCode    AND TCNMBranch_L.FNLngID = '+nLangEdits
                    ]
                },
                Where :{
                    Condition : [tShpWhereShop]
                },
                GrideView:{
                    ColumnPathLang	: 'company/shop/shop',
                    ColumnKeyLang	: ['tSHPTBBranch','tSHPTBCode','tSHPTBName'],
                    ColumnsSize     : ['15%','15%','75%'],
                    WidthModal      : 50,
                    DataColumns		: ['TCNMBranch_L.FTBchName', 'TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
                    DataColumnsFormat : ['','',''],
                    Perpage			: 10,
                    OrderBy			: ['TCNMShop.FTBchCode ASC,TCNMShop.FTShpCode ASC'],
                },
                CallBack:{
                    ReturnType	: 'S',
                    Value		: [tShpInputReturnCode,"TCNMShop.FTShpCode"],
                    Text		: [tShpInputReturnName,"TCNMShop_L.FTShpName"]
                },
                NextFunc : {
                    FuncName    : tShpNextFuncName,
                    ArgReturn   : aShpArgReturn
                },
                RouteAddNew: 'shop',
                BrowseLev: 0
            };
        }else{
            if(tShpCPHBranchForm == "" && tShpCPHBranchTo == ""){
                // แสดงข้อมูล ร้านค้าทั้งหมดตามประเภทของรายงาน
                var oShopOptionReturn   = {
                    Title   : ['company/shop/shop','tSHPTitle'],
                    Table   : {Master:'TCNMShop', PK:'FTShpCode'},
                    Join    : {
                        Table   : ['TCNMShop_L', 'TCNMBranch_L'],
                        On      : [
                            'TCNMShop.FTBchCode = TCNMShop_L.FTBchCode      AND TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                            'TCNMShop.FTBchCode = TCNMBranch_L.FTBchCode    AND TCNMBranch_L.FNLngID = '+nLangEdits
                        ]
                    },
                    Where :{
                        Condition : [tShpWhereShop]
                    },
                    GrideView:{
                        ColumnPathLang	: 'company/shop/shop',
                        ColumnKeyLang	: ['tSHPTBBranch','tSHPTBCode','tSHPTBName'],
                        ColumnsSize     : ['15%','15%','75%'],
                        WidthModal      : 50,
                        DataColumns		: ['TCNMBranch_L.FTBchName', 'TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
                        DataColumnsFormat : ['','',''],
                        Perpage			: 10,
                        OrderBy			: ['TCNMShop.FTBchCode ASC,TCNMShop.FTShpCode ASC'],
                    },
                    CallBack:{
                        ReturnType	: 'S',
                        Value		: [tShpInputReturnCode,"TCNMShop.FTShpCode"],
                        Text		: [tShpInputReturnName,"TCNMShop_L.FTShpName"]
                    },
                    NextFunc : {
                        FuncName    : tShpNextFuncName,
                        ArgReturn   : aShpArgReturn
                    },
                    RouteAddNew: 'shop',
                    BrowseLev: 0
                };
            }else{
                // แสดงข้อมูลร้านค้า ตามสาขาที่เลือกไว้
                var oShopOptionReturn   = {
                    Title   : ['company/shop/shop','tSHPTitle'],
                    Table   : {Master:'TCNMShop', PK:'FTShpCode'},
                    Join    : {
                        Table   : ['TCNMShop_L', 'TCNMBranch_L'],
                        On      : [
                            'TCNMShop.FTBchCode = TCNMShop_L.FTBchCode      AND TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                            'TCNMShop.FTBchCode = TCNMBranch_L.FTBchCode    AND TCNMBranch_L.FNLngID = '+nLangEdits
                        ]
                    },
                    Where :{
                        Condition : [tShpWhereShop+tShpWhereShopAndBch]
                    },
                    GrideView:{
                        ColumnPathLang	: 'company/shop/shop',
                        ColumnKeyLang	: ['tSHPTBBranch','tSHPTBCode','tSHPTBName'],
                        ColumnsSize     : ['15%','15%','75%'],
                        WidthModal      : 50,
                        DataColumns		: ['TCNMBranch_L.FTBchName', 'TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
                        DataColumnsFormat : ['','',''],
                        Perpage			: 10,
                        OrderBy			: ['TCNMShop.FTBchCode ASC,TCNMShop.FTShpCode ASC'],
                    },
                    CallBack:{
                        ReturnType	: 'S',
                        Value		: [tShpInputReturnCode,"TCNMShop.FTShpCode"],
                        Text		: [tShpInputReturnName,"TCNMShop_L.FTShpName"]
                    },
                    NextFunc : {
                        FuncName    : tShpNextFuncName,
                        ArgReturn   : aShpArgReturn
                    },
                    RouteAddNew: 'shop',
                    BrowseLev: 0
                }
            }
        }
        return oShopOptionReturn;
    };


     
    /*===== Begin Event Next Function Browse ========================================== */
    // Functionality : Next Function Branch And Check Data Shop And Clear Data
    // Parameter : Event Next Func Modal
    // Create : 30/09/2019 Wasin(Yoshi)
    // update : 03/10/2019 Saharat(Golf)
    // Return : Clear Velues Data
    // Return Type : -
    function JSxCPHConsNextFuncBrowseBch(poDataNextFunc){
        if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
            let aDataNextFunc   = JSON.parse(poDataNextFunc);
            tBchCode      = aDataNextFunc[0];
            tBchName      = aDataNextFunc[1];
        }

        // ประกาศตัวแปร สาขา
        var tCPHBchCodeTo,tCPHBchNameTo
        tCPHBchCodeTo   = $('#oetCPHBchCodeTo').val();
        tCPHBchNameTo   = $('#oetCPHBchNameTo').val();

        // เช็คข้อมูลถ้ามีการ Browse จากสาขา ให้ default ถึงสาขา เป็นข้อมูลเดียวกัน 
        if((typeof(tCPHBchCodeTo) !== 'undefined' && tCPHBchCodeTo == "")){
            $('#oetCPHBchCodeTo').val(tBchCode);
            $('#oetCPHBchNameTo').val(tBchName);
        } 


        var tCPHShopCodeTo
        tCPHShopCodeTo      = $('#oetCPHShpCodeTo').val();
        if( (typeof(tCPHShopCodeTo) !== 'undefined' && tCPHShopCodeTo != "")){
            $('#oetCPHShpCodeTo').val('');
            $('#oetCPHShpNameTo').val('');
        }
    }

    // Functionality : Next Function Shop And Check Data Pos And Clear Data
    // Parameter : Event Next Func Modal
    // Create : 30/09/2019 Wasin(Yoshi)
    // update : 03/10/2019 Sahart(Golf)
    // Return : Clear Velues Data
    // Return Type : -
    function JSxCPHConsNextFuncBrowseShp(poDataNextFunc){

        if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
            let aDataNextFunc   = JSON.parse(poDataNextFunc);
            tShpCode = aDataNextFunc[0];
            tShpName = aDataNextFunc[1];
        }

        // ประกาศตัวแปร ร้านค้า
        var tCPHShpCodeTo,tCPHShpNameTo

        tCPHShpCodeTo   = $('#oetCPHShpCodeTo').val();
        tCPHShpNameTo   = $('#oetCPHShpNameTo').val();

        // เช็คข้อมูลถ้ามีการ Browse จากร้านค้า ให้ default ถึงร้านค้า เป็นข้อมูลเดียวกัน 
        if((typeof(tCPHShpCodeTo) !== 'undefined' && tCPHShpCodeTo == "")){
            $('#oetCPHShpCodeTo').val(tShpCode);
            $('#oetCPHShpNameTo').val(tShpName);
        } 

 

        var tCPHPosCodeTo

        tCPHPosCodeTo   = $('#oetCPHPosCodeTo').val();
        if((typeof(tCPHPosCodeTo) !== 'undefined' && tCPHPosCodeTo != "")){

            $('#oetCPHPosCodeTo').val('');
            $('#oetCPHPosNameTo').val('');
        }


        // ประกาศตัวแปร ร้านค้าที่โอน
        var tCPHShpTCodeTo   = $('#oetCPHShpTCodeTo').val();
        var tCPHShpTNameTo   = $('#oetCPHShpTNameTo').val();

        // เช็คข้อมูลถ้ามีการ Browse จากร้านค้าที่โอน ให้ default ถึงร้านค้าที่โอน เป็นข้อมูลเดียวกัน 
        if((typeof(tCPHShpTCodeTo) !== 'undefined' && tCPHShpTCodeTo == "")){
            $('#oetCPHShpTCodeTo').val(tShpCode);
            $('#oetCPHShpTNameTo').val(tShpName);
        } 

   

        // ประกาศตัวแปร ร้านค้าที่รับโอน
        var tCPHShpRCodeTo   = $('#oetCPHShpRCodeTo').val();
        var tCPHShpRNameTo   = $('#oetCPHShpRNameTo').val();

        // เช็คข้อมูลถ้ามีการ Browse จากร้านค้าที่รับโอน ให้ default ถึงร้านค้าที่รับโอน เป็นข้อมูลเดียวกัน 
        if((typeof(tCPHShpRCodeTo) !== 'undefined' && tCPHShpRCodeTo == "")){
            $('#oetCPHShpRCodeTo').val(tShpCode);
            $('#oetCPHShpRNameTo').val(tShpName);
        } 


    }


     // Functionality : Next Function MerChant And Check Data 
    // Parameter : Event Next Func Modal
    // Create : 04/10/2019 Saharat(Golf)
    // Return : Clear Velues Data
    // Return Type : -
    function  JSxCPHConsNextFuncBrowseMerChant(poDataNextFunc){

        if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
            let aDataNextFunc   = JSON.parse(poDataNextFunc);
            tMerCode      = aDataNextFunc[0];
            tMerName      = aDataNextFunc[1];
        }

        // ประกาศตัวแปร กลุ่มธุรกิจ
        var tCPHMerCodeTo,tCPHPdtNameTo
        tCPHMerCodeTo   = $('#oetCPHMerCodeTo').val();
        tCPHMerNameTo   = $('#oetCPHMerNameTo').val();

        // เช็คข้อมูลถ้ามีการ Browse จากกลุ่มธุรกิจ ให้ default ถึงกลุ่มธุรกิจ เป็นข้อมูลเดียวกัน 
        if( (typeof(tCPHMerCodeTo) !== 'undefined' && tCPHMerCodeTo == "")){
            $('#oetCPHMerCodeTo').val(tMerCode);
            $('#oetCPHMerNameTo').val(tMerName);
        } 

   
}   


  // =========================================== Event Browse Multi Branch ===========================================
  $('#obtTabCouponHDBchInclude').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            $('#oetCPHBchCodeTo').val('');
            $('#oetCPHBchNameTo').val('');
            $('#oetCPHMerCodeTo').val('');
            $('#oetCPHMerNameTo').val('');
            $('#oetCPHShpCodeTo').val('');
            $('#oetCPHShpNameTo').val('');
            $('#ohdCPHcouponModalTypeInclude').val(1);
            $("#odvCPHCouponHDBch").modal({backdrop: "static", keyboard: false});
             $("#odvCPHCouponHDBch").modal({show: true});
        }else{
            JCNxShowMsgSessionExpired();
        }
    });



    
  // =========================================== Event Browse Multi Branch ===========================================
  $('#obtTabCouponHDBchExclude').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            $('#oetCPHBchCodeTo').val('');
            $('#oetCPHBchNameTo').val('');
            $('#oetCPHMerCodeTo').val('');
            $('#oetCPHMerNameTo').val('');
            $('#oetCPHShpCodeTo').val('');
            $('#oetCPHShpNameTo').val('');
            $('#ohdCPHcouponModalTypeInclude').val(2);
            $("#odvCPHCouponHDBch").modal({backdrop: "static", keyboard: false});
             $("#odvCPHCouponHDBch").modal({show: true});
        }else{
            JCNxShowMsgSessionExpired();
        }
    });




        /*===== Begin Event Next Function Browse ========================================== */
    // Functionality : 
    // Parameter : Event Next Func Modal
    // Create : 11/02/2020 Nattakit(Nale)
    // Return : Set Element And value
    // Return Type : -
    function JSxConsNextFuncBrowseBchInclude(poDataNextFunc){
        if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
        //   var  aCPHCouponIncludeBchCode = $('#ohdCPHCouponIncludeBchCode').val().split(",");
        //   var  aCPHCouponIncludeBchName = $('#ohdCPHCouponIncludeBchName').val().split(",");

        var i = Date.now();

          var tMarkUp ="";
                    tMarkUp +="<tr class='otrInclude' id='otrCPHcouponIncludeBch"+i+"'>";
                    tMarkUp +="<td>";
                    tMarkUp +="<input type='hidden' name='ohdCPHCouponIncludeBchCode["+i+"]' class='ohdCPHCouponIncludeBchCode' value='"+poDataNextFunc.tCPHBchCodeTo+"'>";
                    tMarkUp +="<input type='hidden' name='ohdCPHCouponIncludeMerCode["+i+"]' class='ohdCPHCouponIncludeMerCode' value='"+poDataNextFunc.tCPHMerCodeTo+"'>";
                    tMarkUp +="<input type='hidden' name='ohdCPHCouponIncludeShpCode["+i+"]' class='ohdCPHCouponIncludeShpCode' value='"+poDataNextFunc.tCPHShpCodeTo+"'>";
                    tMarkUp +=poDataNextFunc.tCPHBchCodeTo+"</td>";
                    tMarkUp +="<td>"+poDataNextFunc.tCPHBchNameTo+"</td>";
                    tMarkUp +="<td>"+poDataNextFunc.tCPHMerNameTo+"</td>";
                    tMarkUp +="<td>"+poDataNextFunc.tCPHShpNameTo+"</td>";
                    tMarkUp +="<td align='center'><img onclick='JSxCPHcouponRemoveTRIncludeBch("+i+")' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>";
                    tMarkUp +="</tr>";
                
 
                $('#otbCouponHDBchInclude').append(tMarkUp);
        }
    }

    function JSxCPHcouponRemoveTRIncludeBch(ptCode){
        $('#otrCPHcouponIncludeBch'+ptCode).remove();
    
    }



        /*===== Begin Event Next Function Browse ========================================== */
    // Functionality : 
    // Parameter : Event Next Func Modal
    // Create : 11/02/2020 Nattakit(Nale)
    // Return : Set Element And value
    // Return Type : -
    function JSxConsNextFuncBrowseBchExclude(poDataNextFunc){
        if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
        //   var  aCPHCouponExcludeBchCode = $('#ohdCPHCouponExcludeBchCode').val().split(",");
        //   var  aCPHCouponExcludeBchName = $('#ohdCPHCouponExcludeBchName').val().split(",");

        var i = Date.now();

          var tMarkUp ="";
                    tMarkUp +="<tr class='otrExclude' id='otrCPHcouponExcludeBch"+i+"'>";
                    tMarkUp +="<td>";
                    tMarkUp +="<input type='hidden' name='ohdCPHCouponExcludeBchCode["+i+"]' class='ohdCPHCouponExcludeBchCode' value='"+poDataNextFunc.tCPHBchCodeTo+"'>";
                    tMarkUp +="<input type='hidden' name='ohdCPHCouponExcludeMerCode["+i+"]' class='ohdCPHCouponExcludeMerCode' value='"+poDataNextFunc.tCPHMerCodeTo+"'>";
                    tMarkUp +="<input type='hidden' name='ohdCPHCouponExcludeShpCode["+i+"]' class='ohdCPHCouponExcludeShpCode' value='"+poDataNextFunc.tCPHShpCodeTo+"'>";
                    tMarkUp +=poDataNextFunc.tCPHBchCodeTo+"</td>";
                    tMarkUp +="<td>"+poDataNextFunc.tCPHBchNameTo+"</td>";
                    tMarkUp +="<td>"+poDataNextFunc.tCPHMerNameTo+"</td>";
                    tMarkUp +="<td>"+poDataNextFunc.tCPHShpNameTo+"</td>";
                    tMarkUp +="<td align='center'><img onclick='JSxCPHcouponRemoveTRExcludeBch("+i+")' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>";
                    tMarkUp +="</tr>";
                
 
                $('#otbCouponHDBchExclude').append(tMarkUp);
        }
    }

    function JSxCPHcouponRemoveTRExcludeBch(ptCode){
        $('#otrCPHcouponExcludeBch'+ptCode).remove();
    
    }
</script>