<?php
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            <th class="xCNTextBold" style="width:5%;"><?=language('document/adjuststock/adjuststock','tASTTBChoose')?></th>
                        <?php endif; ?>
                        <th class="xCNTextBold"><?=language('document/adjuststock/adjuststock','tASTTBBchCreate')?></th>
						<th class="xCNTextBold"><?=language('document/adjuststock/adjuststock','tASTTBDocNo')?></th>
                        <th class="xCNTextBold"><?=language('document/adjuststock/adjuststock','tASTTBDocDate')?></th>
                        <th class="xCNTextBold"><?=language('document/adjuststock/adjuststock','tASTTBStaDoc')?></th>
                        <th class="xCNTextBold"><?=language('document/adjuststock/adjuststock','tASTTBStaApv')?></th>
                        <th class="xCNTextBold"><?=language('document/adjuststock/adjuststock','tASTTBStaPrc')?></th>
                        <th class="xCNTextBold"><?=language('document/adjuststock/adjuststock','tASTTBCreateBy')?></th>
                        <th class="xCNTextBold"><?=language('document/adjuststock/adjuststock','tASTTBApvBy')?></th>

                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
							<th class="xCNTextBold" style="width:5%;"><?= language('common/main/main','tCMNActionDelete')?></th>
                        <?php endif; ?>
                        
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
						    <th class="xCNTextBold" style="width:5%;"><?= language('common/main/main','tCMNActionEdit')?></th>
						<?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php 
                        if(count($aDataList['raItems'])!=0){
                            foreach($aDataList['raItems'] AS $nKey => $aValue):?>
                                <?php
                                    if($aValue['FTXthStaApv'] == 1 || $aValue['FTXthStaApv'] == 2 || $aValue['FTXthStaDoc'] == 3){
                                        $tCheckboxDisabled  = "disabled";
                                        $tClassDisabled     = "xCNDocDisabled";
                                        $tTitle             = language('document/document/document','tDOCMsgCanNotDel');
                                        $tOnclick           = '';
                                    }else{
                                        $tCheckboxDisabled  = "";
                                        $tClassDisabled     = '';
                                        $tTitle             = '';
                                        $tOnclick           = "onclick=JSoTBIDelDocSingle('".$nCurrentPage."','".$aValue['FTXthDocNo']."')";
                                    }
                                    
                                    // เช็ค Text Color FTXthStaDoc
                                    if($aValue['FTXthStaDoc'] == 1){
                                        $tClassStaDoc = 'text-success';
                                    }else if($aValue['FTXthStaDoc'] == 2){
                                        $tClassStaDoc = 'text-warning';    
                                    }else if($aValue['FTXthStaDoc'] == 3){
                                        $tClassStaDoc = 'text-danger';
                                    }else{
                                        $tClassStaDoc = "";
                                    }

                                    // เช็ค Text Color FTXthStaApv
                                    if($aValue['FTXthStaApv'] == 1){
                                        $tClassStaApv = 'text-success';
                                    }else if($aValue['FTXthStaApv'] == 2){
                                        $tClassStaApv = 'text-warning';    
                                    }else if($aValue['FTXthStaApv'] == ''){
                                        $tClassStaApv = 'text-danger';    
                                    }else{
                                        $tClassStaApv = "";
                                    }

                                    // เช็ค Text Color FTXthStaPrcStk
                                    if($aValue['FTXthStaPrcStk'] == 1){
                                        $tClassPrcStk = 'text-success';
                                    }else if($aValue['FTXthStaPrcStk'] == 2){
                                        $tClassPrcStk = 'text-warning';
                                    }else if($aValue['FTXthStaPrcStk'] == ''){
                                        $tClassPrcStk = 'text-danger';    
                                    }else{
                                        $tClassPrcStk = "";
                                    }
                                ?>
                                <tr id="otrTIB<?php echo $nKey?>" class="text-center xCNTextDetail2 otrTIB" data-code="<?php echo $aValue['FTXthDocNo']?>" data-name="<?php echo $aValue['FTXthDocNo']?>">
                                    <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                        <td class="text-center">
                                            <label class="fancy-checkbox ">
                                                <input id="ocbListItem<?php echo $nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?php echo $tCheckboxDisabled;?>>
                                                <span class="<?php echo $tClassDisabled?>">&nbsp;</span>
                                            </label>
                                        </td>
                                    <?php endif; ?>
                                    <td class="text-left"><?php echo (!empty($aValue['FTBchName']))? $aValue['FTBchName'] : '-' ?></td>
                                    <td class="text-left"><?php echo (!empty($aValue['FTXthDocNo']))? $aValue['FTXthDocNo'] : '-' ?></td>
                                    <td class="text-center"><?php echo (!empty($aValue['FDXthDocDate']))? $aValue['FDXthDocDate'] : '-' ?></td>
                                    <td class="text-center">
                                        <label class="xCNTDTextStatus <?php echo $tClassStaDoc;?>"><?php echo language('document/adjuststock/adjuststock','tASTStaDoc'.$aValue['FTXthStaDoc']) ?></label>
                                    </td>
                                    <td class="text-center">
                                        <label class="xCNTDTextStatus <?php echo $tClassStaApv;?>"><?php echo language('document/adjuststock/adjuststock','tASTStaApv'.$aValue['FTXthStaApv'])?></label>
                                    </td>
                                    <td class="text-center">
                                        <label class="xCNTDTextStatus <?php echo $tClassPrcStk;?>"><?php echo language('document/adjuststock/adjuststock','tASTStaPrcStk'.$aValue['FTXthStaPrcStk']) ?></label>
                                    </td>
                                    <td class="text-center">
                                        <?php echo (!empty($aValue['FTCreateByName']))? $aValue['FTCreateByName'] : '-' ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo (!empty($aValue['FTXthStaApv']))? $aValue['FTXthApvName'] : '-' ?>
                                    </td>
                                    <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                        <td>
                                            <img
                                                class="xCNIconTable xCNIconDel <?php echo $tClassDisabled?>"
                                                src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                                <?php echo $tOnclick?>
                                                title="<?php echo $tTitle?>"
                                            >
                                        </td>
                                    <?php endif; ?>
                                    <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                                        <td>
                                            <img class="xCNIconTable xCNIconEdit" onClick="JSvTBICallPageEdit('<?php echo $aValue['FTXthDocNo']?>')">
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach;
                        } else{ ?>
                        <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php } ?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aDataList['rnCurrentPage']?> / <?php echo $aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageTIBPdt btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvTIBClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>

            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvTIBClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>

            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvTIBClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- ===================================================== Modal Delete Document Single ===================================================== -->
<div id="odvTBIModalDelDocSingle" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelSingle" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
            </div>
            <div class="modal-footer">
                <button id="osmTBIConfirmPdtDTTemp" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>
<!-- ======================================================================================================================================== -->

<!-- ===================================================== Modal Delete Document Multiple =================================================== -->
<div id="odvTBIModalDelDocMultiple" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main','tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <span id="ospTBITextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdTBIConfirmIDDelMultiple">
            </div>
            <div class="modal-footer">
                <button id="obtTBIConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>
<!-- ======================================================================================================================================== -->

<script type="text/javascript">
    localStorage.removeItem('LocalItemData');
    
    //Functionality: Function Chack Value LocalStorage
    //Parameters: Event Select List Branch
    //Creator: 07/06/2019 Wasin(Yoshi)
    //Return: Duplicate/none
    //Return Type: string
    function JStTBIFindObjectByKey(array, key, value) {
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return "Dupilcate";
            }
        }
        return "None";
    }

    //Functionality: Function Chack And Show Button Delete All
    //Parameters: LocalStorage Data
    //Creator: 26/03/2563 Napat(Jame)
    //Return: Show Button Delete All
    //Return Type: -
    function JSxTBIShowButtonChoose() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        console.log(aArrayConvert);
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
            $("#oliBtnDeleteAll").addClass("disabled");
        } else {
            nNumOfArr = aArrayConvert[0].length;
            if (nNumOfArr > 1) {
                $("#oliBtnDeleteAll").removeClass("disabled");
            } else {
                $("#oliBtnDeleteAll").addClass("disabled");
            }
        }
    }

    //Functionality: Insert Text In Modal Delete
    //Parameters: LocalStorage Data
    //Creator: 26/03/2020 Napat(Jame)
    //Return: -
    //Return Type: -
    function JSxTBITextInModal() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        } else {
            var tTextCode = "";
            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += " , ";
            }
            //Disabled ปุ่ม Delete
            if (aArrayConvert[0].length > 1) {
            $(".xCNIconDel").addClass("xCNDisabled");
            } else {
            $(".xCNIconDel").removeClass("xCNDisabled");
            }

            $("#ospTBITextConfirmDelMultiple").text("ท่านต้องการลบข้อมูลทั้งหมดหรือไม่ ?");
            $("#ohdTBIConfirmIDDelMultiple").val(tTextCode);
        }
    }

    //ลบ HD - หลายตัว
    function JSxTBIDelDocMultiple(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var aDataDelMultiple    = $('#odvTBIModalDelDocMultiple #ohdTBIConfirmIDDelMultiple').val();
            var aTextsDelMultiple   = aDataDelMultiple.substring(0, aDataDelMultiple.length - 2);
            var aDataSplit          = aTextsDelMultiple.split(" , ");
            var nDataSplitlength    = aDataSplit.length;
            var aNewIdDelete        = [];
            
            for($i = 0; $i < nDataSplitlength; $i++){
                aNewIdDelete.push(aDataSplit[$i]);
            }
            if(nDataSplitlength > 1){
                JCNxOpenLoading();
                localStorage.StaDeleteArray = '1';
                $.ajax({
                    type    : "POST",
                    url     : "docTBIEventDelete",
                    data    : {'tTBIDocNo': aNewIdDelete},
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if(aReturnData['nStaEvent'] == '1'){
                            $('#odvTBIModalDelDocMultiple').modal('hide');
                            $('#odvTBIModalDelDocMultiple #ospTBITextConfirmDelMultiple').empty();
                            $('#odvTBIModalDelDocMultiple #ohdTBIConfirmIDDelMultiple').val('');
                            $('.modal-backdrop').remove();
                            localStorage.removeItem('LocalItemData');
                            setTimeout(function () {
                                JSvTBICallPageTransferReceipt();
                            }, 500);
                        }else{
                            JCNxCloseLoading();
                            FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    $(document).ready(function(){
        // Click Check Box List Delete All
        $('.ocbListItem').unbind().click(function(){
            var nCode = $(this).parent().parent().parent().data('code');  //code
            var tName = $(this).parent().parent().parent().data('name');  //code
            $(this).prop('checked', true);
            var LocalItemData = localStorage.getItem("LocalItemData");
            var obj = [];
            if(LocalItemData){
                obj = JSON.parse(LocalItemData);
            }else{ }
            var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
            if(aArrayConvert == '' || aArrayConvert == null){
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxTBITextInModal();
            }else{
                var aReturnRepeat = JStTBIFindObjectByKey(aArrayConvert[0],'nCode',nCode);
                if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                    obj.push({"nCode": nCode, "tName": tName });
                    localStorage.setItem("LocalItemData",JSON.stringify(obj));
                    JSxTBITextInModal();
                }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                    localStorage.removeItem("LocalItemData");
                    $(this).prop('checked', false);
                    var nLength = aArrayConvert[0].length;
                    for($i=0; $i<nLength; $i++){
                        if(aArrayConvert[0][$i].nCode == nCode){
                            delete aArrayConvert[0][$i];
                        }
                    }
                    var aNewarraydata = [];
                    for($i=0; $i<nLength; $i++){
                        if(aArrayConvert[0][$i] != undefined){
                            aNewarraydata.push(aArrayConvert[0][$i]);
                        }
                    }
                    localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                    JSxTBITextInModal();
                }
            }
            JSxTBIShowButtonChoose();
        });

        // Confirm Delete Modal Multiple
        $('#odvTBIModalDelDocMultiple #obtTBIConfirmDelMultiple').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof nStaSession !== "undefined" && nStaSession == 1) {
                JSxTBIDelDocMultiple();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
    });
</script>