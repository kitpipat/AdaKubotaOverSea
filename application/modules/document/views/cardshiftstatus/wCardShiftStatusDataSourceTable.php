<?php if($tIsDataOnly == "0") : ?>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            
            <span class="hidden" id="ospCardShiftStatusCardCodeTemp"><?php echo $tDataListAll; ?></span>
            <input type="hidden" id="ohdCardShiftStatusCountRowFromTemp" name="ohdCardShiftStatusCountRowFromTemp" value="<?php echo $rnAllRow; ?>">
            <input type="hidden" id="ohdCardShiftStatusCountSuccess" name="ohdCardShiftStatusCountSuccess" value="<?php echo FSnSelectCountResultSuccess('TFNTCrdVoidTmp'); ?>">
            
            <table class="table table-striped" id="otbCardShiftStatusCardTable">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('common/main/main','tCMNSequence'); ?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:30%;"><?php echo language('document/card/cardstatus','tCardShiftStatusTBCode'); ?></th>
                        <?php if(false) : ?>
                        <th nowrap class="xCNTextBold text-left" style="width:30%;"><?php echo language('document/card/cardstatus','tCardShiftStatusTBName'); ?></th>
                        <?php endif; ?>
                        <th nowrap class="xCNTextBold text-left" style="width:10%;"><?php echo language('document/card/cardstatus','tCardShiftStatusTBCardStatus'); ?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:10%;"><?php echo language('document/card/cardstatus','tCardShiftStatusTBProcessStatus'); ?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:10%;"><?php echo language('document/card/cardstatus','tCardShiftStatusTBRmk'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('document/card/cardstatus','tCardShiftStatusTBEdit'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('document/card/cardstatus','tCardShiftStatusTBDelete'); ?></th>
                    </tr>
                </thead>
                <tbody id="otbCardShiftStatusDataSourceList">
<?php endif; ?>   
                <?php if($aDataList['rtCode'] == 1) : ?>
                    <?php foreach($aDataList['raItems'] as $key => $aValue) : ?>
                        <?php
                            $tFNSeq = $aValue['FNCvdSeqNo'];
                            
                            // สถานะบัตร
                            if($aValue['FTCvdStaCrd'] == '1'){
                                $tClassSta   = "xWImpStaSuccess";
                                $tTextStaCrd    = language('document/card/main','tMainSuccess');
                                $tStatusCard    = '<img class="xCNIconTable" src="' . base_url() . 'application/modules/common/assets/images/icons/OK-Approve.png"> <span class="text-success">' . $tTextStaCrd . '</span>';
                            }else{
                                $tClassSta   = "xWImpStaUnsuccess";
                                $tTextStaCrd    = language('document/card/main','tMainUnSuccess');
                                $tStatusCard    = '<img class="xCNIconTable" src="' . base_url() . 'application/modules/common/assets/images/icons/cancel.png"> <span class="text-danger">' . $tTextStaCrd . '</span>';
                            }
                            
                            $tProcess = '';
                            // ประมวลผลบัตร
                            if($tStaPrcDoc == "1" || $tStaPrcDoc == "2"){ // Document Processing or Approved
                                if($tStaPrcDoc == "1"){ // Document Is Approved
                                    if($aValue['FTCvdStaPrc'] == "1"){ // Card Is Process Success
                                        $tProcess = language('document/card/main','tMainSuccessProcessed');
                                    }
                                    if($aValue['FTCvdStaPrc'] == "2"){ // Card Is Process Unsuccess
                                        $tProcess = language('document/card/main','tMainUnsuccessProcessed');
                                    }
                                }
                                if($tStaPrcDoc == "2"){ // Document Is Processing
                                    $tProcess = language('document/card/main','tMainProcessing');
                                }
                            }else{
                                if(empty($aValue['FTCvdStaPrc'])){ // Card Is Waiting Process
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
                                    $tStaDocProcess = '<img class="xCNIconTable" src="' . base_url() . 'application/modules/common/assets/images/icons/OK-Approve.png"> <span class="text-success">' . language('document/card/cardstatus','tCardShiftStatusTBApproved') . '</span>';
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
                        <tr class="text-center xCNTextDetail2 xWCardShiftStatusDataSource" id="otrCardShiftStatusDataSource<?php echo $aValue['rtRowID']; ?>" data-seq="<?php echo $aValue['FNCvdSeqNo']; ?>">
							<td nowrap class="text-center"><?php echo $aValue['rtRowID']; ?></td>
                            <td nowrap class="xWCardShiftStatusCardCode text-left">
                                <input id="oetCardShiftStatusCardName<?php echo $aValue['rtRowID']; ?>" name="oetCardShiftChangeCardName<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTCvdOldCode']; ?>">
                                <input id="oetCardShiftStatusCardCode<?php echo $aValue['rtRowID']; ?>" name="oetCardShiftStatusCardCode<?php echo $aValue['rtRowID']; ?>" type="hidden" value="<?php echo $aValue['FTCvdOldCode']; ?>">
                            </td>
                            <?php if(false) : ?>
                            <td nowrap class="text-left"><?php echo $aValue['FTCrdName'] ?></td>
                            <?php endif; ?>
                            <td nowrap class="text-left"><?php echo $tStatusCard; ?></td>
                            <td nowrap class="text-left"><?php echo $tProcess; ?></td>
                            <td nowrap class="text-left"><?php echo $aValue['FTCvdRmk']; ?></td>        
                            <td nowrap class="text-center"> 
                                <img <?php echo $tDisabledStye; ?> class="xCNIconTable xWCardShiftStatusEdit" src="<?php echo  base_url('application/modules/common/assets/images/icons/edit.png'); ?>" onclick="JSxCardShiftStatusDataSourceEditOperator(this, event, <?php echo $aValue['FNCvdSeqNo']; ?>)">
                                <img class="xCNIconTable xWCardShiftStatusSave hidden" src="<?php echo  base_url('application/modules/common/assets/images/icons/save.png'); ?>" onclick="JSxCardShiftStatusDataSourceSaveOperator(this, event, <?php echo $aValue['FNCvdSeqNo']; ?>)">
                                <img class="xCNIconTable xWCardShiftStatusCancel hidden" src="<?php echo  base_url('application/modules/common/assets/images/icons/reply_new.png'); ?>" onclick="JSxCardShiftStatusDataSourceCancelOperator(this, event)">
                            </td>
                            <td nowrap class="text-center">
                                <img <?php echo $tDisabledStye; ?> class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" onClick="JSxCardShiftStatusDataSourceDeleteOperator(this, event, <?php echo $nPage; ?>, '<?php echo $aValue['FTCvdOldCode']; ?>', <?php echo $aValue['FNCvdSeqNo']; ?>)">
                            </td>
                            <script>
                            $(document).ready(function() {  
                                $('#oetCardShiftStatusCardName<?php echo $aValue['rtRowID']; ?>').click(function(){
                                    window.oCardShiftStatusBrowseCardOption<?php echo $aValue['rtRowID']; ?> = oCardShiftStatusBrowseCard<?php echo $aValue['rtRowID']; ?>(JStCardShiftStatusGetCardCodeTemp());
                                    JCNxBrowseData('oCardShiftStatusBrowseCardOption<?php echo $aValue['rtRowID']; ?>');
                                });
                            });
                            
                            var nLangEdit = <?php echo $this->session->userdata("tLangEdit"); ?>;
                            var oCardShiftStatusBrowseCard<?php echo $aValue['rtRowID']; ?> = function (ptNotCardCode) {
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
                                        Condition : [tNotIn]
                                        // Condition : ["AND ((TFNMCard.FTCrdStaType = 1 AND TFNMCard.FTCrdStaShift = 1) OR TFNMCard.FTCrdStaType = 2)" + tNotIn]
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
                                        Value		: ["oetCardShiftStatusCardCode<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"],
                                        Text		: ["oetCardShiftStatusCardName<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"]
                                    },
                                    /*NextFunc:{
                                        FuncName: 'JSxCardShiftStatusCallBackCardChange',
                                        ArgReturn: ['FTCrdCode', 'FTCrdHolderID']
                                    },*/
                                    // RouteFrom : 'cardShiftChange',
                                    RouteAddNew : 'card',
                                    BrowseLev : nStaCardShiftStatusBrowseType
                                };
                                return oOptions;
                            };   
                            </script>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                        <tr id="otrCardShiftStatusNoData"><td nowrap class='text-center xCNTextDetail2' colspan='8'><?php echo language('common/main/main','tCMNNotFoundData'); ?></td></tr>
                <?php endif; ?>
                        
<?php if($tIsDataOnly == "0") : ?>                        
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
        <input type="hidden" id="ohdCardShiftStatusDataSourceCurrentPage" value="<?php echo $nPage ?>">
        <div class="xWCardShiftStatusDataSourcePage btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvCardShiftStatusDataSourceClickPage('previous','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvCardShiftStatusDataSourceClickPage('<?php echo $i?>','<?=$ptDocType?>','<?=$tIDElement?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCardShiftStatusDataSourceClickPage('next','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- Modal Delete Table -->
<div class="modal fade" id="odvCardShiftStatusModalConfirmDelRecord">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
                <span class="xCNTextModal" style="display: inline-block; word-break:break-all"><?php echo language('common/main/main', 'tModalDeleteSingle'); ?> <span id="ospCardShiftStatusConfirDelMessage"></span></span>
			</div>
			<div class="modal-footer">
				<button id="osmCardShiftStatusConfirmDelRecord" type="button" class="btn xCNBTNPrimery">
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

<?php endif; ?>



