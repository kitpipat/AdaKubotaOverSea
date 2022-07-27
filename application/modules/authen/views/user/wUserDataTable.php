<?php 
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>

<div class="row">
    <div class="col-md-12">
    <input type="hidden" id="nCurrentPageTB" value="$nCurrentPage">
        <div class="table-responsive">
            <table id="otbUserDataList" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <?php if ($aAlwEventUser['tAutStaFull'] == 1 || ($aAlwEventUser['tAutStaAdd'] == 1 || $aAlwEventUser['tAutStaEdit'] == 1)) : ?>
                            <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('authen/user/user', 'tUSRTBChoose') ?></th>
                        <?php endif; ?>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('authen/user/user', 'tUSRTBPic') ?></th>
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('authen/user/user', 'tUSRTBName') ?></th>
                        <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo language('authen/user/user', 'tUSRTBDepart') ?></th>
                        <!-- <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo language('authen/user/user', 'tUSRTBBranch') ?></th> -->
                        <!-- <?php if(FCNbGetIsShpEnabled()): ?>
                        <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo language('authen/user/user', 'tUSRTBShop') ?></th>
                        <?php endif; ?> -->
                        <?php if ($aAlwEventUser['tAutStaFull'] == 1 || ($aAlwEventUser['tAutStaAdd'] == 1 || $aAlwEventUser['tAutStaEdit'] == 1)) : ?>
                            <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('authen/user/user', 'tUSRTBDelete') ?></th>
                        <?php endif; ?>
                        <?php if ($aAlwEventUser['tAutStaFull'] == 1 || ($aAlwEventUser['tAutStaAdd'] == 1 || $aAlwEventUser['tAutStaEdit'] == 1)) : ?>
                            <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('authen/user/user', 'tUSRTBEdit') ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if ($aDataList['rtCode'] == 1): ?>
                        <?php
                            // $tUsrCode = "";
                            foreach ($aDataList['raItems'] AS $key => $aValue) {
                                $tImgObjPath = $aValue['rtUsrImage'];
                                if(isset($tImgObjPath) && !empty($tImgObjPath)){
                                    $aImgObj    = explode("application",$tImgObjPath);
                                    $tFullPatch = './application'.$aImgObj[1];
                                    if (file_exists($tFullPatch)){
                                        $tPatchImg = base_url().'/application'.$aImgObj[1];
                                    }else{
                                        $tPatchImg = base_url().'application/modules/common/assets/images/200x200.png';
                                    }
                                }else{
                                    $tPatchImg = base_url().'application/modules/common/assets/images/200x200.png';
                                }

                                // if($tUsrCode != $aValue['rtUsrCode']){
                                //     $tUsrCode = $aValue['rtUsrCode'];
                        ?>
                            <tr class="text-center xCNTextDetail2 otrUser" id="otrUser<?= $key ?>" data-code="<?= $aValue['rtUsrCode'] ?>" data-name="<?= $aValue['rtUsrName'] ?>">
                                <?php if ($aAlwEventUser['tAutStaFull'] == 1 || ($aAlwEventUser['tAutStaAdd'] == 1 || $aAlwEventUser['tAutStaEdit'] == 1)) : ?>
                                    <td class="text-center">
                                        <label class="fancy-checkbox">
                                            <input id="ocbListItem<?= $key ?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                            <span>&nbsp;</span>
                                        </label>
                                    </td>
                                <?php endif; ?>
                                <td><img class="" src="<?= $tPatchImg ?>" style="width:36px;"></td>
                                <td class="text-left"><?= $aValue['rtUsrName'] ?></td>
                                <td class="text-left"><?= $aValue['rtDptName'] ?></td>
                                <!-- <td class="text-left"><?=$aValue['rtBchName']?></td>
                                <?php if(FCNbGetIsShpEnabled()): ?>
                                <td class="text-left"><?=$aValue['rtShpName']?></td>
                                <?php endif; ?> -->
                                <?php if ($aAlwEventUser['tAutStaFull'] == 1 || ($aAlwEventUser['tAutStaAdd'] == 1 || $aAlwEventUser['tAutStaEdit'] == 1)) : ?>
                                    <td>
                                        <img class="xCNIconTable" src="<?php echo base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>" onClick="JSnUserDel('<?= $nCurrentPage ?>','<?= $aValue['rtUsrName'] ?>','<?php echo $aValue['rtUsrCode'] ?>','<?php echo language('common/main/main', 'tBCHYesOnNo') ?>')">
                                    </td>
                                <?php endif; ?>
                                <?php if ($aAlwEventUser['tAutStaFull'] == 1 || ($aAlwEventUser['tAutStaAdd'] == 1 || $aAlwEventUser['tAutStaEdit'] == 1)) : ?>
                                    <td>
                                        <img class="xCNIconTable" src="<?php echo base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>" onClick="JSvCallPageUserEdit('<?php echo $aValue['rtUsrCode'] ?>')">
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php 
                                // }
                            } 
                        ?>
                    <?php else: ?>
                        <tr><td class='text-center xCNTextDetail2' colspan='99'><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPageUser btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>

            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                if($nPage == $i){ 
                        $tActive = 'disabled'; 
                        $tDisPageNumber = 'active'; 
                }else{
                        $tActive = '-'; 
                        $tDisPageNumber = ''; 
                }
                ?>
                <button onclick="JSvClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tDisPageNumber; ?>" <?php echo $tActive ?>><?php echo $i?></button>
            <?php } ?>
            
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>

            <button onclick="JSvClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>

        </div>
    </div>
</div>


<div class="modal fade" id="odvModalDelUser">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdConfirmIDDelete">
            </div>

            <input type='hidden' id="ospConfirmIDDelete">

            <div class="modal-footer">
                <button id="osmConfirm"  onClick="JSaUserDelChoose('<?= $nCurrentPage ?>')"  type="button" class="btn xCNBTNPrimery" >
                    <?php echo language('common/main/main', 'tModalConfirm') ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel') ?>
                </button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">


<script type="text/javascript">
    $('.ocbListItem').click(function(){
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
            JSxPaseCodeDelInModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxPaseCodeDelInModal();
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
                JSxPaseCodeDelInModal();
            }
        }
        JSxShowButtonChoose();
    });
</script>


