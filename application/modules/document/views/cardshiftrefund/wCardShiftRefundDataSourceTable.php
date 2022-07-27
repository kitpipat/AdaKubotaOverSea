<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            
            <span class="hidden" id="ospCardShiftRefundCardCodeTemp"><?php echo $tDataListAll; ?></span>
            <input type="hidden" id="ohdCardShiftRefundCountRowFromTemp" name="ohdCardShiftRefundCountRowFromTemp" value="<?=$rnAllRow?>">
            <input type="hidden" id="ohdCardShiftCountSuccess" name="ohdCardShiftCountSuccess" value="<?php echo FSnSelectCountResultSuccess('TFNTCrdTopUpTmp'); ?>">
            
            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:left;"><?= language('document/card/main', 'tMainNumber') ?></th>
                        <th nowrap class="xCNTextBold" style="width:30%;text-align:left;"><?= language('document/card/main', 'tExcelcardShiftRefundCode') ?></th>
                        <th nowrap class="xCNTextBold" style="text-align:left;"><?= language('document/card/main', 'tExcelcardShiftRefundValue') ?></th>
                        <th nowrap class="xCNTextBold" style="text-align:left;"><?= language('document/card/main', 'tExcelcardShiftRefundStatus') ?></th>
                        <th nowrap class="xCNTextBold" style="text-align:left;"><?= language('document/card/main', 'tExcelcardShiftRefundProcessStatus') ?></th>
                        <th nowrap class="xCNTextBold" style="text-align:left;"><?= language('document/card/main', 'tExcelcardShiftRefundRemark') ?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('document/card/main', 'tMainEdit') ?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('document/card/main', 'tMainDelete') ?></th>
                    </tr>
                </thead>
                <tbody id="otbCardShiftRefundDataSourceList">
                    <?php if ($aDataList['rtCode'] == 1): ?>
                        <?php $nTotalResult = $aDataList['CountTopUP'][0]['Total']; ?>
                        <?php foreach ($aDataList['raItems'] AS $key => $aValue) { ?>
                            <tr class="text-center xCNTextDetail2 xWCardShiftRefundDataSource" id="otrCardShiftRefundDataSource<?php echo $aValue['rtRowID']; ?>" data-seq="<?php echo $aValue['FNCtdSeqNo']; ?>">

                                <?php
                                $tFNSeq = $aValue['FNCtdSeqNo'];
                                
                                // สถานะบัตร
                                if ($aValue['FTCtdStaCrd'] == '1') {
                                    $tClassSta = "xWImpStaSuccess";
                                    $tTextStaCrd = language('document/card/main', 'tMainSuccess');
                                    $tStatusCard = '<img class="xCNIconTable" src="' . base_url() . 'application/modules/common/assets/images/icons/OK-Approve.png"> <span class="text-success">' . $tTextStaCrd . '</span>';
                                } else {
                                    $tClassSta = "xWImpStaUnsuccess";
                                    $tTextStaCrd = language('document/card/main', 'tMainUnSuccess');
                                    $tStatusCard = '<img class="xCNIconTable" src="' . base_url() . 'application/modules/common/assets/images/icons/cancel.png"> <span class="text-danger">' . $tTextStaCrd . '</span>';
                                }

                                $tProcess = '';
                                // ประมวลผลบัตร
                                if($tStaPrcDoc == "1" || $tStaPrcDoc == "2"){ // Document Processing or Approved
                                    if($tStaPrcDoc == "1"){ // Document Is Approved
                                        if($aValue['FTCtdStaPrc'] == "1"){ // Card Is Process Success
                                            $tProcess = language('document/card/main','tMainSuccessProcessed');
                                        }
                                        if($aValue['FTCtdStaPrc'] == "2"){ // Card Is Process Unsuccess
                                            $tProcess = language('document/card/main','tMainUnsuccessProcessed');
                                        }
                                    }
                                    if($tStaPrcDoc == "2"){ // Document Is Processing
                                        $tProcess = language('document/card/main','tMainProcessing');
                                    }
                                }else{
                                    if(empty($aValue['FTCtdStaPrc'])){ // Card Is Waiting Process
                                        $tProcess = language('document/card/main', 'tMainWaitingForProcessing');
                                    }
                                    if($tStaDoc == "3"){ // Document Is Cancle
                                        $tProcess = 'N/A';                                  
                                    }
                                }

                                // สถานะเอกสาร
                                $tDisabledStye = "";
                                $tStaDocProcess = "";
                                if ($tStaPrcDoc == "1" || $tStaPrcDoc == "2") { // Document Processing or Approved
                                    $tDisabledStye = 'style="opacity: 0.2; cursor: default;"';
                                    if ($tStaPrcDoc == "1") {
                                        $tStaDocProcess = '<img class="xCNIconTable" src="' . base_url() . 'application/modules/common/assets/images/icons/OK-Approve.png"> <span class="text-success">' . language('document/card/cardstatus', 'tCardShiftStatusTBApproved') . '</span>';
                                    }
                                    if ($tStaPrcDoc == "2") {
                                        $tStaDocProcess = language('document/card/cardstatus', 'tCardShiftStatusTBProcessing');
                                    }
                                } else { // Document cancel status
                                    if ($tStaDoc == "3") {
                                        $tStaDocProcess = 'N/A';
                                        $tDisabledStye = 'style="opacity: 0.2; cursor: default;"';
                                    }
                                }
                                ?>
                                <td nowrap class="text-center"> <?= $aValue['rtRowID'] ?></td>
                                <td nowrap class="xWCardShiftRefundCardCode text-left">
                                    <input id="oetCardShiftRefundCardCode<?php echo $aValue['rtRowID']; ?>" name="oetCardShiftRefundCardCode<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTCrdCode']; ?>">
                                    <input id="ohdCardShiftRefundCardCode<?php echo $aValue['rtRowID']; ?>" type="hidden" value="<?php echo $aValue['FTCrdCode']; ?>">
                                </td>
                                <td nowrap class="xWCardShiftRefundValue text-left">
                                    <input id="oetCardShiftRefundValue<?php echo $aValue['rtRowID']; ?>" name="oetCardShiftRefundValue<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo number_format($aValue['FCCtdCrdTP'], 2); ?>" class="xCNInputNumericWithoutDecimal">
                                    <input id="ohdCardShiftRefundValue<?php echo $aValue['rtRowID']; ?>" type="hidden" disabled="true" value="<?php echo number_format($aValue['FCCtdCrdTP'], 2); ?>">
                                </td>
                                <td nowrap class="text-center   <?= $tClassSta ?>"> <?= $tStatusCard ?></td>
                                <td nowrap class="text-center   <?= $tClassSta ?>"> <?= $tProcess ?></td>
                                <td nowrap class="text-left     <?= $tClassSta ?>"> <?= $aValue['FTCtdRmk'] ?></td>
                                <td>
                                    <img <?php echo $tDisabledStye; ?> class="xCNIconTable xWCardShiftRefundEdit" src="<?php echo base_url('application/modules/common/assets/images/icons/edit.png'); ?>" onclick="JSxCardShiftRefundDataSourceEditOperator(this, event, <?php echo $aValue['FNCtdSeqNo']; ?>)">
                                    <img class="xCNIconTable xWCardShiftRefundSave hidden" src="<?php echo base_url('application/modules/common/assets/images/icons/save.png'); ?>" onclick="JSxCardShiftRefundDataSourceSaveOperator(this, event, <?php echo $aValue['FNCtdSeqNo']; ?>)">
                                    <img class="xCNIconTable xWCardShiftRefundCancel hidden" src="<?php echo base_url('application/modules/common/assets/images/icons/reply_new.png'); ?>" onclick="JSxCardShiftRefundDataSourceCancelOperator(this, event)">
                                    <!-- <img class="xCNIconTable" src="<?php echo base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>" onClick="JSnCallPageExcelHelperEdit('<?= $nPage ?>','<?= $ptDocType ?>','<?= $aValue['FNCtdSeqNo']; ?>')" title="<?php echo language('authen/department/department', 'tDPTTBEdit'); ?>">       -->
                                </td>
                                <td>
                                    <!-- <img class="xCNIconTable" src="<?php echo base_url('application/modules/common/assets/images/icons/delete.png'); ?>" onClick="JSnCallPageExcelHelperDel('<?= $nPage ?>','<?= $ptDocType ?>','<?= $aValue['FNCtdSeqNo'] ?>','<?= $aValue['FTCrdCode'] ?>','<?= $tIDElement ?>')" 
                                        title="<?php echo language('customer/customerGroup/customerGroup', 'tCstGrpTBDelete'); ?>"> -->

                                    <img <?php echo $tDisabledStye; ?> class="xCNIconTable" src="<?php echo base_url('application/modules/common/assets/images/icons/delete.png'); ?>" onClick="JSxCardShiftRefundDataSourceDeleteOperator(this, event, <?php echo $nPage; ?>, '<?php echo $aValue['FTCrdCode']; ?>', <?php echo $aValue['FNCtdSeqNo']; ?>)">
                                </td>
                        <script>
                            $(document).ready(function() {  
                                $('#oetCardShiftRefundCardCode<?php echo $aValue['rtRowID']; ?>').click(function(){
                                    window.oCardShiftRefundBrowseCardOption<?php echo $aValue['rtRowID']; ?> = oCardShiftRefundBrowseCard<?php echo $aValue['rtRowID']; ?>();
                                    JCNxBrowseData('oCardShiftRefundBrowseCardOption<?php echo $aValue['rtRowID']; ?>');
                                });
                            });

                            var nLangEdit = <?php echo $this->session->userdata("tLangEdit"); ?>;

                            var oCardShiftRefundBrowseCard<?php echo $aValue['rtRowID']; ?> = function () {
                                let tNotIn = "";
                                let ptNotCardCode = JStCardShiftRefundGetCardCodeTemp();
                                if (!ptNotCardCode == "") {
                                    tNotIn = "AND TFNMCard.FTCrdCode NOT IN (" + ptNotCardCode + ")";
                                }
                                console.log("NOT IN TEMP: ", tNotIn);
                                let oOptions = {
                                    Title: ['payment/card/card', 'tCRDTitle'],
                                    Table: {Master: 'TFNMCard', PK: 'FTCrdCode', PKName: 'FTCrdName'},
                                    Join: {
                                        Table: ['TFNMCard_L'],
                                        On: ['TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits]
                                    },
                                    Where: {
                                        Condition: ["AND TFNMCard.FCCrdValue > 0 AND TFNMCard.FCCrdValue IS NOT NULL AND TFNMCard.FTCrdStaActive = 1 AND (TFNMCard.FTCrdStaShift = 2 OR TFNMCard.FTCrdStaType = 2) " + tNotIn]
                                    },
                                    GrideView: {
                                        ColumnPathLang: 'payment/card/card',
                                        ColumnKeyLang: ['tCRDTBCode', 'tCRDTBName', ''],
                                        // ColumnsSize     : ['15%', '85%'],
                                        WidthModal: 50,
                                        DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName', 'TFNMCard.FCCrdValue'],
                                        DisabledColumns: [2],
                                        DataColumnsFormat: ['', '', ''],
                                        Perpage: 500,
                                        OrderBy: ['TFNMCard_L.FTCrdName'],
                                        SourceOrder: "ASC"
                                    },
                                    NextFunc: {
                                        FuncName: 'JSxCardShiftRefundCallBackCardRefund<?php echo $aValue['rtRowID']; ?>',
                                        ArgReturn: ['FTCrdCode', 'FCCrdValue']
                                    },
                                    CallBack: {
                                        // StaDoc: '2',
                                        ReturnType: 'S',
                                        Value: ["oetCardShiftRefundCardCode<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"],
                                        Text: ["oetCardShiftRefundCardValueCode<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"]
                                    },
                                    RouteAddNew: 'card',
                                    BrowseLev: nStaCardShiftRefundBrowseType
                                };
                                return oOptions;
                            };

                            function JSxCardShiftRefundCallBackCardRefund<?php echo $aValue['rtRowID']; ?>(ptCard) {
                                poCard = JSON.parse(ptCard);
                                $('#oetCardShiftRefundValue' +<?php echo $aValue['rtRowID']; ?>).val(parseFloat(poCard[1]).toFixed(2));
                                $('#ohdCardShiftRefundValue' +<?php echo $aValue['rtRowID']; ?>).val(parseFloat(poCard[1]).toFixed(2));
                            }
                        </script>
                        </tr>
                    <?php } ?>
                    </tbody>

                    <tbody>
                        <tr>
                            <td nowrap="" class="text-right xCNTextDetail2" colspan="8" style="padding-right: 20%;">
                                <div class="col-4 pull-right text-right" style="padding-left: 15%;">
                                    <?php
                                    //GET Vat
                                    $tResult = FCNcDOCGetVatData();
                                    if ($tResult['cVatRate'] == '' || $tResult['cVatRate'] == null || $tResult['cVatRate'] == '.00') {
                                        $tTextVat = 'NULL';
                                    } else {
                                        $tTextVat = 'HAVE';
                                    }
                                    ?>
                                    
                                    <?php if ($tTextVat == 'HAVE') : ?>
                                        <?php
                                        $cCal = 0.00;
                                        $cVat = ($nTotalResult * $tResult['cVatRate']) / 100;
                                        $cTotalInVat = $nTotalResult + $cVat;
                                        ?>
                                        <label id="odlLabelValue"><?php echo number_format($nTotalResult, 2); ?></label>
                                        <br>
                                        <label id="odlLabelVat"><?php echo number_format($tResult['cVatRate'], 2, ".", ""); ?>%</label>
                                        <br>
                                        <label id="odlLabelTotal"><?php echo number_format($cTotalInVat, 2); ?></label>
                                    <?php else : ?>
                                        <label id="odlLabelValue"><?php echo number_format($nTotalResult, 2); ?></label>
                                        <br>
                                    <?php endif; ?>
                                        
                                </div>
                                <div class="col-4 pull-right text-left">
                                    <?php if($tTextVat == 'HAVE'){ ?>
                                        <label><?php echo language('document/card/cardrefund', 'tCardShiftRefundCardRefundValue'); ?></label>
                                        <br>
                                        <label><?php echo language('document/card/cardtopup', 'tCardShiftTopUpTaxRate'); ?></label>
                                        <br>
                                        <label><?php echo language('document/card/cardrefund', 'tCardShiftRefundNetReturnValue'); ?></label>
                                    <?php }else{ ?>
                                        <label><?php echo language('document/card/cardrefund', 'tCardShiftRefundCardRefundValue'); ?></label>
                                        <br>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr> 
                    </tbody>

                <?php else: ?>
                    <tr id="otrCardShiftRefundNoData"><td nowrap class='text-center xCNTextDetail2' colspan='10'><?php echo language('common/main/main', 'tCMNNotFoundData'); ?></td></tr>
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
        <input type="hidden" id="ohdCardShiftRefundDataSourceCurrentPage" value="<?php echo $nPage ?>">
        <div class="xWCardShiftRefundDataSourcePage btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvCardShiftRefundDataSourceClickPage('previous','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvCardShiftRefundDataSourceClickPage('<?php echo $i?>','<?=$ptDocType?>','<?=$tIDElement?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCardShiftRefundDataSourceClickPage('next','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- Modal Delete Table -->
<div class="modal fade" id="odvCardShiftRefundModalConfirmDelRecord">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
                <span class="xCNTextModal" style="display: inline-block; word-break:break-all"><?php echo language('common/main/main', 'tModalDeleteSingle'); ?> <span id="ospCardShiftRefundConfirDelMessage"></span></span>
			</div>
			<div class="modal-footer">
				<button id="osmCardShiftRefundConfirmDelRecord" type="button" class="btn xCNBTNPrimery">
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
<!--script>
    /*JSXCalculateTotal();

    function JSXCalculateTotal(){
        
        var nTotalResult    = '<?php echo isset($nTotalResult) ? number_format($nTotalResult, 2) : '0'; ?>';
        var nRate           = '<?=$tResult['cVatRate'];?>';

        if(nRate == '.0000' || nRate == '' || nRate == null){
            var tResult = parseFloat(nTotalResult);
            $('#odlLabelValue').text(tResult.toFixed(2));
        }else{
            $('#odlLabelValue').text(nTotalResult);
            var nCal = (nTotalResult * nRate)/100;
            var nCal = parseFloat(nCal) + parseFloat(nTotalResult);
            $('#odlLabelTotal').text('');
            $('#odlLabelTotal').text(nCal.toFixed(2));
        }
    }*/
</script-->









