<?php 
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>
<style>
    .xWImpStaSuccess {
        color: #007b00 !important;
        font-size: 18px !important;
        font-weight: bold;
    }
    .xWImpStaInProcess {
        color: #7b7f7b !important;
        font-size: 18px !important;
        font-weight: bold;
    }
    .xWImpStaUnsuccess {
        color: #f60a0a !important;
        font-size: 18px !important;
        font-weight: bold;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
        
            <span class="hidden" id="ospCardShiftReturnCardCodeTemp"><?php echo $tDataListAll; ?></span>
            <input type="hidden" id="ohdCardShiftReturnCountRowFromTemp" name="ohdCardShiftStatusCountRowFromTemp" value="<?php echo $rnAllRow; ?>">
            <input type="hidden" id="ohdCardShiftCountSuccess" name="ohdCardShiftCountSuccess" value="<?php echo FSnSelectCountResultSuccess('TFNTCrdShiftTmp'); ?>">

            <table class="table table-striped" id="otbCardShiftReturnCardTable">
                <thead>
                    <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php  echo language('common/main/main','tCMNSequence'); ?></th>
                    <th nowrap class="xCNTextBold text-center" style="width:20%;"><?php echo language('document/card/cardreturn','tCardShiftReturnTBCode');?></th>
                    <th nowrap class="xCNTextBold text-center" style="width:20%;"><?php echo language('document/card/cardreturn','tCardShiftReturnTBCardStatus'); ?></th>
                    <th nowrap class="xCNTextBold text-center" style="width:15%;"><?php echo language('document/card/cardreturn','tCardShiftReturnTBProcessStatus'); ?></th>
                    <th nowrap class="xCNTextBold text-center" style="width:15%;"><?php echo language('document/card/cardreturn','tCardShiftReturnTBRmk'); ?></th>
                    <th nowrap class="xCNTextBold text-center" style="width:15%;"><?php echo language('document/card/cardreturn','tCardShiftReturnTBEdit'); ?></th>
                    <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('document/card/cardreturn','tCardShiftReturnTBDelete'); ?></th> 
                </thead>
                <tbody id="otbCardShiftReturnDataSourceList">
                    <?php if($aDataList['rtCode'] == 1) :?>
                        <?php foreach($aDataList['raItems'] as $key => $aValue) : ?>
                            <?php
                                // สถานะบัตร
                                if($aValue['FTCrdStaCrd'] == '1'){
                                    $tClassSta      = "xWImpStaSuccess";
                                    $tTextStaCrd    = language('document/card/main','tMainSuccess');
                                    $tStatusCard    = '<img class="xCNIconTable" src="'.base_url().'application/modules/common/assets/images/icons/OK-Approve.png"> <span class="text-success">' .$tTextStaCrd. '</span>';
                                }else{
                                    $tClassSta      = "xWImpStaUnsuccess";
                                    $tTextStaCrd    = language('document/card/main','tMainUnSuccess');
                                    $tStatusCard    = '<img class="xCNIconTable" src="'.base_url().'application/modules/common/assets/images/icons/cancel.png"> <span class="text-danger">' . $tTextStaCrd . '</span>';
                                }
                                
                                $tProcess = '';
                                // ประมวลผลบัตร
                                if($tStaPrcDoc == "1" || $tStaPrcDoc == "2"){ // Document Processing or Approved
                                    if($tStaPrcDoc == "1"){ // Document Is Approved
                                        if($aValue['FTCrdStaPrc'] == "1"){ // Card Is Process Success
                                            $tProcess = language('document/card/main','tMainSuccessProcessed');
                                        }
                                        if($aValue['FTCrdStaPrc'] == "2"){ // Card Is Process Unsuccess
                                            $tProcess = language('document/card/main','tMainUnsuccessProcessed');
                                        }
                                    }
                                    if($tStaPrcDoc == "2"){ // Document Is Processing
                                        $tProcess = language('document/card/main','tMainProcessing');
                                    }
                                }else{
                                    if(empty($aValue['FTCrdStaPrc'])){ // Card Is Waiting Process
                                        $tProcess = language('document/card/main', 'tMainWaitingForProcessing');
                                    }
                                    if($tStaDoc == "3"){ // Document Is Cancle
                                        $tProcess = 'N/A';                                  
                                    }
                                }

                                
                                // สถานะเอกสาร
                                $tDisabledStye = "";
                                $tStaDocProcess = "";
                                if($tStaPrcDoc == "1" || $tStaPrcDoc == "2"){ // Document Processing or Approved
                                    $tDisabledStye = 'style="opacity: 0.2; cursor: default;"';
                                    if($tStaPrcDoc == "1"){
                                        $tStaDocProcess = '<img class="xCNIconTable" src="' . base_url() . '/application/assets/icons/OK-Approve.png"> <span class="text-success">' . language('document/card/cardstatus','tCardShiftStatusTBApproved') . '</span>';
                                    }
                                    if($tStaPrcDoc == "2"){
                                        $tStaDocProcess = language('document/card/cardstatus','tCardShiftStatusTBProcessing');
                                    }
                                }else{ // Document cancel status
                                    if($tStaDoc == "3"){
                                        $tStaDocProcess = 'N/A'; 
                                        $tDisabledStye = 'style="opacity: 0.2; cursor: default;"';                                    
                                    }
                                }

                            ?>
                            <tr class="text-center xCNTextDetail2 xWCardShiftReturnDataSource" id="otrCardShiftReturnDataSource<?php echo $aValue['rtRowID']; ?>" data-seq="<?php echo $aValue['FNCsdSeqNo']; ?>">
                                <td nowrap class="text-center"><?php echo $aValue['rtRowID']; ?></td>
                                <td nowrap class="xWCardShiftReturnCardCode text-left">
                                    <input id="oetCardShiftReturnCardName<?php echo $aValue['rtRowID']; ?>" name="oetCardShiftReturnCardName<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTCrdCode']; ?>">
                                    <input id="oetCardShiftReturnCardCode<?php echo $aValue['rtRowID']; ?>" type="hidden" value="<?php echo $aValue['FTCrdCode']; ?>">
                                </td>
                                <td nowrap class="xWCardShiftReturnStatus text-left">
                                    <?php echo $tStatusCard; ?>
                                    <input type="hidden" class="xWCardShiftReturnStatusCard" value="<?php echo $aValue['FTCrdStaCrd']; ?>">
                                </td>
                                <td nowrap class="text-left"><?php echo $tProcess; ?></td>
                                <td nowrap class="xWCardShiftReturnCardRmk text-left"><?php echo $aValue['FTCrdRmk']; ?></td>
                                <td nowrap class="text-center"> 
                                    <img  <?php echo $tDisabledStye; ?> class="xCNIconTable xWCardShiftReturnEdit" src="<?php echo  base_url('application/modules/common/assets/images/icons/edit.png'); ?>" onclick="JSxCardShiftReturnDataSourceEditOperator(this, event, <?php echo $aValue['FNCsdSeqNo']; ?>)">
                                    <img class="xCNIconTable xWCardShiftReturnSave hidden" src="<?php echo  base_url('application/modules/common/assets/images/icons/save.png'); ?>" onclick="JSxCardShiftReturnDataSourceSaveOperator(this, event, <?php echo $aValue['FNCsdSeqNo']; ?>)">
                                    <img class="xCNIconTable xWCardShiftReturnCancel hidden" src="<?php echo  base_url('application/modules/common/assets/images/icons/reply_new.png'); ?>" onclick="JSxCardShiftReturnDataSourceCancelOperator(this, event)">
                                </td>
                                <td nowrap class="text-center">
                                    <img  <?php echo $tDisabledStye; ?> class="xCNIconTable" src="<?php echo base_url('application/modules/common/assets/images/icons/delete.png'); ?>" onClick="JSxCardShiftReturnDataSourceDeleteOperator(this, event, <?php echo $nPage; ?>, '<?php echo $aValue['FTCrdCode']; ?>', <?php echo $aValue['FNCsdSeqNo']; ?>)">
                                </td>
                                <script>
                                    $(document).ready(function(){
                                        $('#oetCardShiftReturnCardName<?php echo $aValue['rtRowID']; ?>').click(function(){
                                            window.oCardShiftReturnBrowseCardOption<?php echo $aValue['rtRowID']; ?> = oCardShiftReturnBrowseCard<?php echo $aValue['rtRowID']; ?>(JStCardShiftReturnGetCardCodeTemp());
                                            JCNxBrowseData('oCardShiftReturnBrowseCardOption<?php echo $aValue['rtRowID']; ?>');
                                        });
                                    });
                                    var nLangEdit = <?php echo $this->session->userdata("tLangEdit"); ?>;
                                    var oCardShiftReturnBrowseCard<?php echo $aValue['rtRowID']; ?> = function (ptNotCardCode) {
                                        let tNotIn = "";
                                        if(!ptNotCardCode == ""){
                                            tNotIn = "AND TFNMCard.FTCrdCode NOT IN (" + ptNotCardCode + ")";
                                        }
                                        let oOptions = {
                                            Title : ['payment/card/card','tCRDTitle'],
                                            Table:{Master:'TFNMCard', PK:'FTCrdCode', PKName:'FTCrdName'},
                                            Join :{
                                                Table: ['TFNMCard_L'],
                                                On: ['TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits]
                                            },
                                            Where :{
                                                Condition : [" AND (TFNMCard.FTCrdStaType = 1) AND (TFNMCard.FTCrdStaActive = 1) AND (TFNMCard.FTCrdStaShift = 1) AND (CONVERT(datetime, TFNMCard.FDCrdExpireDate) > CONVERT(datetime, GETDATE())) " + tNotIn]
                                            },
                                            GrideView:{
                                                ColumnPathLang	: 'payment/card/card',
                                                ColumnKeyLang	: ['tCRDTBCode', 'tCRDTBName', ''],
                                                // ColumnsSize     : ['15%', '85%'],
                                                WidthModal      : 50,
                                                DataColumns		: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName', 'TFNMCard.FTCrdHolderID'],
                                                DisabledColumns	:[2],
                                                DataColumnsFormat : ['', '', ''],
                                                Perpage			: 500,
                                                OrderBy			: ['TFNMCard_L.FTCrdName'],
                                                SourceOrder		: "ASC"
                                            },
                                            CallBack:{
                                                // StaDoc: '2',
                                                ReturnType	: 'S',
                                                Value		: ["oetCardShiftReturnCardCode<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"],
                                                Text		: ["oetCardShiftReturnCardName<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"]
                                            },
                                            NextFunc:{
                                                FuncName: 'JSxCardShiftReturnCallBackCardChange',
                                                ArgReturn: ['FTCrdCode', 'FTCrdHolderID']
                                            },
                                            // RouteFrom : 'cardShiftChange',
                                            RouteAddNew : 'card',
                                            BrowseLev : nStaCardShiftReturnBrowseType
                                        };
                                        return oOptions;
                                    }; 
                                </script>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr id="otrCardShiftReturnNoData"><td nowrap class='text-center xCNTextDetail2' colspan='999'><?php echo language('common/main/main','tCMNNotFoundData'); ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
	<!-- เปลี่ยน -->
	<div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
	<!-- เปลี่ยน -->
    <div class="col-md-6">
        <input type="hidden" id="ohdCardShiftReturnDataSourceCurrentPage" value="<?php echo $nPage ?>">
        <div class="xWCardShiftReturnDataSourcePage btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvCardShiftReturnDataSourceClickPage('previous','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <button onclick="JSvCardShiftReturnDataSourceClickPage('<?php echo $i?>','<?=$ptDocType?>','<?=$tIDElement?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCardShiftReturnDataSourceClickPage('next','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<!-- Modal Delete Table -->
<div class="modal fade" id="odvCardShiftReturnModalConfirmDelRecord">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
                <span class="xCNTextModal" style="display: inline-block; word-break:break-all"><?php echo language('common/main/main', 'tModalDeleteSingle'); ?> <span id="ospCardShiftReturnConfirDelMessage"></span></span>
			</div>
			<div class="modal-footer">
				<button id="osmCardShiftReturnConfirmDelRecord" type="button" class="btn xCNBTNPrimery">
					<?php echo language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>
<!-- End Modal Delete Table -->

