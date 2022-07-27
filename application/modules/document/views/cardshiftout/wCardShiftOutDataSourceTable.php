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
        
            <span class="hidden" id="ospCardShiftOutCardCodeTemp"><?php echo $tDataListAll; ?></span>
            <input type="hidden" id="ohdCardShiftOutCountRowFromTemp" name="ohdCardShiftStatusCountRowFromTemp" value="<?php echo $rnAllRow; ?>">
            <input type="hidden" id="ohdCardShiftCountSuccess" name="ohdCardShiftCountSuccess" value="<?php echo FSnSelectCountResultSuccess('TFNTCrdShiftTmp'); ?>">

            <table class="table table-striped" id="otbCardShiftOutCardTable">
                <thead>
                    <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php  echo language('common/main/main','tCMNSequence'); ?></th>
                    <th nowrap class="xCNTextBold text-center" style="width:20%;"><?php echo language('document/card/cardout','tCardShiftOutTBCode');?></th>
                    <th nowrap class="xCNTextBold text-center" style="width:20%;"><?php echo language('document/card/cardout','tCardShiftOutTBCardStatus'); ?></th>
                    <th nowrap class="xCNTextBold text-center" style="width:15%;"><?php echo language('document/card/cardout','tCardShiftOutTBProcessStatus'); ?></th>
                    <th nowrap class="xCNTextBold text-center" style="width:15%;"><?php echo language('document/card/cardout','tCardShiftOutTBRmk'); ?></th>
                    <th nowrap class="xCNTextBold text-center" style="width:15%;"><?php echo language('document/card/cardout','tCardShiftOutTBEdit'); ?></th>
                    <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('document/card/cardout','tCardShiftOutTBDelete'); ?></th> 
                </thead>
                <tbody id="otbCardShiftOutDataSourceList">
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
                            <tr class="text-center xCNTextDetail2 xWCardShiftOutDataSource" id="otrCardShiftOutDataSource<?php echo $aValue['rtRowID']; ?>" data-seq="<?php echo $aValue['FNCsdSeqNo']; ?>">
                                <td nowrap class="text-center"><?php echo $aValue['rtRowID']; ?></td>
                                <td nowrap class="xWCardShiftOutCardCode text-left">
                                    <input id="oetCardShiftOutCardName<?php echo $aValue['rtRowID']; ?>" name="oetCardShiftOutCardName<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTCrdCode']; ?>">
                                    <input id="oetCardShiftOutCardCode<?php echo $aValue['rtRowID']; ?>" type="hidden" value="<?php echo $aValue['FTCrdCode']; ?>">
                                </td>
                                <td nowrap class="xWCardShiftOutStatus text-left">
                                    <?php echo $tStatusCard; ?>
                                    <input type="hidden" class="xWCardShiftOutStatusCard" value="<?php echo $aValue['FTCrdStaCrd']; ?>">
                                </td>
                                <td nowrap class="text-left"><?php echo $tProcess; ?></td>
                                <td nowrap class="xWCardShiftOutCardRmk text-left"><?php echo $aValue['FTCrdRmk']; ?></td>
                                <td nowrap class="text-center"> 
                                    <img <?php echo $tDisabledStye; ?> class="xCNIconTable xWCardShiftOutEdit" src="<?php echo  base_url('application/modules/common/assets/images/icons/edit.png'); ?>" onclick="JSxCardShiftOutDataSourceEditOperator(this, event, <?php echo $aValue['FNCsdSeqNo']; ?>)">
                                    <img class="xCNIconTable xWCardShiftOutSave hidden" src="<?php echo  base_url('application/modules/common/assets/images/icons/save.png'); ?>" onclick="JSxCardShiftOutDataSourceSaveOperator(this, event, <?php echo $aValue['FNCsdSeqNo']; ?>)">
                                    <img class="xCNIconTable xWCardShiftOutCancel hidden" src="<?php echo  base_url('application/modules/common/assets/images/icons/reply_new.png'); ?>" onclick="JSxCardShiftOutDataSourceCancelOperator(this, event)">
                                </td>
                                <td nowrap class="text-center">
                                    <img <?php echo $tDisabledStye; ?> class="xCNIconTable" src="<?php echo base_url('application/modules/common/assets/images/icons/delete.png'); ?>" onClick="JSxCardShiftOutDataSourceDeleteOperator(this, event, <?php echo $nPage; ?>, '<?php echo $aValue['FTCrdCode']; ?>', <?php echo $aValue['FNCsdSeqNo']; ?>)">
                                </td>
                                <script>
                                    $(document).ready(function(){
                                        $('#oetCardShiftOutCardName<?php echo $aValue['rtRowID']; ?>').click(function(){
                                            window.oCardShiftOutBrowseCardOption<?php echo $aValue['rtRowID']; ?> = oCardShiftOutBrowseCard<?php echo $aValue['rtRowID']; ?>(JStCardShiftOutGetCardCodeTemp());
                                            JCNxBrowseData('oCardShiftOutBrowseCardOption<?php echo $aValue['rtRowID']; ?>');
                                        });
                                    });
                                    var nLangEdit = <?php echo $this->session->userdata("tLangEdit"); ?>;
                                    var oCardShiftOutBrowseCard<?php echo $aValue['rtRowID']; ?> = function (ptNotCardCode) {
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
                                                Value		: ["oetCardShiftOutCardCode<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"],
                                                Text		: ["oetCardShiftOutCardName<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"]
                                            },
                                            NextFunc:{
                                                FuncName: 'JSxCardShiftOutCallBackCardChange',
                                                ArgReturn: ['FTCrdCode', 'FTCrdHolderID']
                                            },
                                            // RouteFrom : 'cardShiftChange',
                                            RouteAddNew : 'card',
                                            BrowseLev : nStaCardShiftOutBrowseType
                                        };
                                        return oOptions;
                                    }; 
                                </script>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr id="otrCardShiftOutNoData"><td nowrap class='text-center xCNTextDetail2' colspan='999'><?php echo language('common/main/main','tCMNNotFoundData'); ?></td></tr>
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
        <input type="hidden" id="ohdCardShiftOutDataSourceCurrentPage" value="<?php echo $nPage ?>">
        <div class="xWCardShiftOutDataSourcePage btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvCardShiftOutDataSourceClickPage('previous','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvCardShiftOutDataSourceClickPage('<?php echo $i?>','<?=$ptDocType?>','<?=$tIDElement?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCardShiftOutDataSourceClickPage('next','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<!-- Modal Delete Table -->
<div class="modal fade" id="odvCardShiftOutModalConfirmDelRecord">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
                <span class="xCNTextModal" style="display: inline-block; word-break:break-all"><?php echo language('common/main/main', 'tModalDeleteSingle'); ?> <span id="ospCardShiftOutConfirDelMessage"></span></span>
			</div>
			<div class="modal-footer">
				<button id="osmCardShiftOutConfirmDelRecord" type="button" class="btn xCNBTNPrimery">
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

