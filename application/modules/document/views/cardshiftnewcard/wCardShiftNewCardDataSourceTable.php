<?php if($tIsDataOnly == "0") : ?>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            
            <span class="hidden" id="ospCardShiftNewCardCardCodeTemp"><?php echo $tDataListAll;?></span>
            <input type="hidden" id="ohdCardShiftNewCardCountRowFromTemp" name="ohdCardShiftNewCardCountRowFromTemp" value="<?php echo $rnAllRow; ?>">
            <input type="hidden" id="ohdCardShiftNewCardCountSuccess" name="ohdCardShiftNewCardCountSuccess" value="<?php echo FSnSelectCountResultSuccess('TFNTCrdImpTmp'); ?>">
            
            <table class="table table-striped" id="otbCardShiftNewCardCardTable">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('common/main/main','tCMNSequence'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBCode'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBHolderID'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBName'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBCardType'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBDepartmentName'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBCardStatus'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBProcessStatus'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBRmk'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBEdit'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBDelete'); ?></th>                        
                    </tr>
                </thead>
                <tbody id="otbCardShiftNewCardDataSourceList">
<?php endif; ?>   
                <?php if($aDataList['rtCode'] == 1) : ?>
                    <?php foreach($aDataList['raItems'] as $key => $aValue) : ?>
                        <?php
                            $tFNSeq = $aValue['FNCidSeqNo'];   
                            
                            // สถานะบัตร 
                            if($aValue['FTCidStaCrd'] == '1'){
                                $tClassSta   = "xWImpStaSuccess";
                                $tTextStaCrd    = language('document/card/main','tMainSuccess');
                                $tStatusCard    = '<img class="xCNIconTable" src="' . base_url() . '/application/modules/common/assets/images/icons/OK-Approve.png"> <span class="text-success">' . $tTextStaCrd . '</span>';
                            }else{
                                $tClassSta   = "xWImpStaUnsuccess";
                                $tTextStaCrd    = language('document/card/main','tMainUnSuccess');
                                $tStatusCard    = '<img class="xCNIconTable" src="' . base_url() . '/application/modules/common/assets/images/icons/cancel.png"> <span class="text-danger">' . $tTextStaCrd . '</span>';
                            }
                            
                            $tProcess = '';
                            // ประมวลผลบัตร
                            if($tStaPrcDoc == "1" || $tStaPrcDoc == "2"){ // Document Processing or Approved
                                if($tStaPrcDoc == "1"){ // Document Is Approved
                                    if($aValue['FTCidStaPrc'] == "1"){ // Card Is Process Success
                                        $tProcess = language('document/card/main','tMainSuccessProcessed');
                                    }
                                    if($aValue['FTCidStaPrc'] == "2"){ // Card Is Process Unsuccess
                                        $tProcess = language('document/card/main','tMainUnsuccessProcessed');
                                    }
                                }
                                if($tStaPrcDoc == "2"){ // Document Is Processing
                                    $tProcess = language('document/card/main','tMainProcessing');
                                }
                            }else{
                                if(empty($aValue['FTCidStaPrc'])){ // Card Is Waiting Process
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
                    <tr class="text-center xCNTextDetail2 xWCardShiftNewCardDataSource" id="otrCardShiftNewCardDataSource<?php echo $aValue['rtRowID']; ?>" data-seq="<?php echo $aValue['FNCidSeqNo']; ?>">
                        <td nowrap class="text-center"><?php echo $aValue['rtRowID']; ?></td>
                        <td nowrap class="xWCardShiftNewCardCardCode text-left">
                            <input id="oetCardShiftNewCardCode<?php echo $aValue['rtRowID']; ?>" name="oetCardShiftNewCardCode<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTCidCrdCode']; ?>" maxlength="30">
                        </td>
                        <td nowrap class="xWCardShiftNewCardHolderID text-left">
                            <input id="oetCardShiftNewCardHolderID<?php echo $aValue['rtRowID']; ?>" name="oetCardShiftNewCardHolderID<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTCidCrdHolderID']; ?>" maxlength="30">
                        </td>
                        <td nowrap class="xWCardShiftNewCardCardName text-left">
                            <input id="oetCardShiftNewCardName<?php echo $aValue['rtRowID']; ?>" name="oetCardShiftNewCardName<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTCidCrdName']; ?>" maxlength="255">
                        </td>
                        <td nowrap class="xWCardShiftNewCardCty text-left">
                            <input id="oetCardShiftNewCardCtyName<?php echo $aValue['rtRowID']; ?>" name="oetCardShiftNewCardCtyName<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTCtyName']; ?>">
                            <input id="ohdCardShiftNewCardCtyCode<?php echo $aValue['rtRowID']; ?>" name="ohdCardShiftNewCardCtyCode<?php echo $aValue['rtRowID']; ?>" type="hidden" value="<?php echo $aValue['FTCtyCode']; ?>">
                        </td>
                        <td nowrap class="xWCardShiftNewCardDepart text-left">
                            <input id="oetCardShiftNewCardDptName<?php echo $aValue['rtRowID']; ?>" name="oetCardShiftNewCardDptName<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTCidCrdDepart']; ?>">
                            <input id="ohdCardShiftNewCardDptCode<?php echo $aValue['rtRowID']; ?>" name="ohdCardShiftNewCardDptCode<?php echo $aValue['rtRowID']; ?>" type="hidden" value="<?php echo $aValue['FTCidCrdDepart']; ?>">
                        </td>
                        <td nowrap class="xWCardShiftNewCardStatus text-left">
                            <?php echo $tStatusCard; ?>
                            <input type="hidden" class="xWCardShiftNewCardStatus" value="<?php echo $aValue['FTCidStaCrd']; ?>">
                        </td>
                        <td nowrap class="text-left"><?php echo $tProcess; ?></td>
                        <td nowrap class="text-left"><?php echo $aValue['FTCidRmk']; ?></td>
                        <td nowrap class="text-center"> 
                            <img <?php echo $tDisabledStye; ?> class="xCNIconTable xWCardShiftNewCardEdit" src="<?php echo  base_url('application/modules/common/assets/images/icons/edit.png'); ?>" onclick="JSxCardShiftNewCardDataSourceEditOperator(this, event, <?php echo $aValue['FNCidSeqNo']; ?>)">
                            <img class="xCNIconTable xWCardShiftNewCardSave hidden" src="<?php echo  base_url('application/modules/common/assets/images/icons/save.png'); ?>" onclick="JSxCardShiftNewCardDataSourceSaveOperator(this, event, <?php echo $aValue['FNCidSeqNo']; ?>, <?php echo $nPage; ?>)">
                            <img class="xCNIconTable xWCardShiftNewCardCancel hidden" src="<?php echo  base_url('application/modules/common/assets/images/icons/reply_new.png'); ?>" onclick="JSxCardShiftNewCardDataSourceCancelOperator(this, event)">
                        </td>
                        <td nowrap class="text-center">
                            <img <?php echo $tDisabledStye; ?> class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" onClick="JSxCardShiftNewCardDataSourceDeleteOperator(this, event, <?php echo $nPage; ?>, '<?php echo $aValue['FTCidCrdCode']; ?>', <?php echo $aValue['FNCidSeqNo']; ?>)">
                        </td>
                        <script>
                            $(document).ready(function(){  
                            $('#oetCardShiftNewCardCtyName<?php echo $aValue['rtRowID']; ?>').click(function(){
                                window.oCardShiftNewCardBrowseNewCardCtyOption<?php echo $aValue['rtRowID']; ?> = oCardShiftNewCardBrowseNewCardCty<?php echo $aValue['rtRowID']; ?>();
                                JCNxBrowseData('oCardShiftNewCardBrowseNewCardCtyOption<?php echo $aValue['rtRowID']; ?>');
                            });
                            $('#oetCardShiftNewCardDptName<?php echo $aValue['rtRowID']; ?>').click(function(){
                                window.oCardShiftNewCardBrowseNewCardDptOption<?php echo $aValue['rtRowID']; ?> = oCardShiftNewCardBrowseNewCardDpt<?php echo $aValue['rtRowID']; ?>();
                                JCNxBrowseData('oCardShiftNewCardBrowseNewCardDptOption<?php echo $aValue['rtRowID']; ?>');
                            });
                        });
                        var oCardShiftNewCardBrowseNewCardCty<?php echo $aValue['rtRowID']; ?> = function () {
                            let oOptions = {
                                Title : ['payment/cardtype/cardtype','tCTYTitle'],
                                Table:{Master:'TFNMCardType', PK:'FTCtyCode'},
                                Join :{
                                    Table: ['TFNMCardType_L'],
                                    On: ['TFNMCardType_L.FTCtyCode = TFNMCardType.FTCtyCode AND TFNMCardType_L.FNLngID = '+nLangEdit]
                                },
                                GrideView:{
                                    ColumnPathLang	: 'payment/cardtype/cardtype',
                                    ColumnKeyLang	: ['tCTYCode', 'tCTYName'],
                                    // ColumnsSize     : ['15%', '85%'],
                                    WidthModal      : 50,
                                    DataColumns		: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName'],
                                    DisabledColumns	:[],
                                    DataColumnsFormat : ['', ''],
                                    Perpage			: 100,
                                    OrderBy			: ['TFNMCardType_L.FTCtyName'],
                                    SourceOrder		: "ASC"
                                },
                                CallBack:{
                                    ReturnType	: 'S',
                                    Value		: ["ohdCardShiftNewCardCtyCode<?php echo $aValue['rtRowID']; ?>", "TFNMCardType.FTCtyCode"],
                                    Text		: ["oetCardShiftNewCardCtyName<?php echo $aValue['rtRowID']; ?>", "TFNMCardType.FTCtyName"]
                                },
                                /*NextFunc:{
                                    FuncName: 'JSxCardShiftNewCardCallBackValidate', // 'JSxCardShiftNewCardSetDataSource',
                                    ArgReturn: ['FTCrdCode']
                                },*/
                                // RouteFrom : 'cardShiftChange',
                                RouteAddNew : 'cardtype',
                                BrowseLev : 0
                                // BrowseLev : nStaCardShiftNewCardBrowseType
                            };
                            return oOptions;
                        };   
                        var oCardShiftNewCardBrowseNewCardDpt<?php echo $aValue['rtRowID']; ?> = function () {                                
                            let oOptions = {
                                Title : ['authen/department/department','tDPTTitle'],
                                Table : {Master:'TCNMUsrDepart', PK:'FTDptCode'},
                                Join :{
                                    Table: ['TCNMUsrDepart_L'],
                                    On: ['TCNMUsrDepart_L.FTDptCode = TCNMUsrDepart.FTDptCode AND TCNMUsrDepart_L.FNLngID = '+nLangEdit]
                                },
                                GrideView:{
                                    ColumnPathLang	: 'authen/department/department',
                                    ColumnKeyLang	: ['tDPTTBCode', 'tDPTTBName'],
                                    WidthModal      : 50,
                                    DataColumns		: ['TCNMUsrDepart.FTDptCode', 'TCNMUsrDepart_L.FTDptName'],
                                    DisabledColumns	:[],
                                    DataColumnsFormat : ['', ''],
                                    Perpage			: 100,
                                    OrderBy			: ['TCNMUsrDepart_L.FTDptName'],
                                    SourceOrder		: "ASC"
                                },
                                CallBack:{
                                    ReturnType	: 'S',
                                    Value		: ["ohdCardShiftNewCardDptCode<?php echo $aValue['rtRowID']; ?>", "TCNMUsrDepart.FTDptCode"],
                                    Text		: ["oetCardShiftNewCardDptName<?php echo $aValue['rtRowID']; ?>", "TCNMUsrDepart.FTDptName"]
                                },
                                /*NextFunc:{
                                    FuncName: 'JSxCardShiftNewCardCallBackValidate', // 'JSxCardShiftNewCardSetDataSource',
                                    ArgReturn: ['FTCrdCode']
                                },*/
                                // RouteFrom : 'cardShiftChange',
                                RouteAddNew : 'department',
                                BrowseLev : 0
                                // BrowseLev : nStaCardShiftNewCardBrowseType
                            };
                            return oOptions;
                        };    
                        </script>
                    </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr id="otrCardShiftNewCardNoData"><td nowrap class='text-center xCNTextDetail2' colspan='11'><?php echo language('common/main/main','tCMNNotFoundData'); ?></td></tr>
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
        <p><?= language('common/main/main', 'tResultTotalRecord') ?> <?= $aDataList['rnAllRow'] ?> <?= language('common/main/main', 'tRecord') ?> <?= language('common/main/main', 'tCurrentPage') ?> <?= $aDataList['rnCurrentPage'] ?> / <?= $aDataList['rnAllPage'] ?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <input type="hidden" id="ohdCardShiftNewCardDataSourceCurrentPage" value="<?php echo $nPage ?>">
        <div class="xWCardShiftNewCardDataSourcePage btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvCardShiftNewCardDataSourceClickPage('previous','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvCardShiftNewCardDataSourceClickPage('<?php echo $i?>','<?=$ptDocType?>','<?=$tIDElement?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCardShiftNewCardDataSourceClickPage('next','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- Modal Delete Table -->
    <div class="modal fade" id="odvCardShiftNewCardModalConfirmDelRecord">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
                </div>
                <div class="modal-body">
                    <span class="xCNTextModal" style="display: inline-block; word-break:break-all"><?php echo language('common/main/main', 'tModalDeleteSingle'); ?> <span id="ospCardShiftNewCardConfirDelMessage"></span></span>
                </div>
                <div class="modal-footer">
                    <button id="osmCardShiftNewCardConfirmDelRecord" type="button" class="btn xCNBTNPrimery">
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



