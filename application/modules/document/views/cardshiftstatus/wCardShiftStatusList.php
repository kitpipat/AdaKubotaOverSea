<div class="panel panel-headline"> <!-- เพิ่ม -->
	<div class="panel-heading"> <!-- เพิ่ม -->
        <section id="ostSearchRecive">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                        <label class="xCNLabelFrm"><?= language('common/main/main','tSearch')?></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="oetSearchAll" name="oetSearchAll" placeholder="<?= language('common/main/main','tSearch')?>" onkeypress="Javascript:if(event.keyCode==13) JSvCardShiftStatusCardShiftStatusDataTable()">
                            <span class="input-group-btn">
                                <button id="oimSearchCardShiftStatus" class="btn xCNBtnSearch" type="button" onclick="JSvCardShiftStatusCardShiftStatusDataTable()">
                                    <img class="xCNIconAddOn" src="<?php echo base_url('application/modules/common/assets/images/icons/search-24.png'); ?>">
                                </button>
                                <a id="oahCardShiftStatusSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxCardShiftStatusClearSearchData()"><?php echo language('common/main/main', 'tClearSearch'); ?></a>
                                <a id="oahCardShiftStatusAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;"><?php echo language('common/main/main', 'tAdvanceSearch'); ?></a>
                            </span>
                        </div>
                    </div>
                </div>
                <?php if(false) : ?>
                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1 ) : ?>
                <div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
                    <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                        <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                            ตัวเลือก
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li id="oliBtnDeleteAll" class="disabled">
                                <a href="javascript:;" data-toggle="modal" data-target="#odvModalDelCardShiftStatus" onclick="JSxCardShiftStatusSetDataBeforeDelMulti()">ลบทั้งหมด</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="row hidden" id="odvCardShiftStatusAdvanceSearchContainer">
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/card/cardstatus','tCardShiftStatusTBDocDate'); ?></label>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-right-15">
                        <div class="form-group">
                            <div class="validate-input">
                                <input 
                                    class="form-control input100 xCNDatePicker" 
                                    type="text" 
                                    name="oetCardShiftStatusSearchDocDateFrom" 
                                    id="oetCardShiftStatusSearchDocDateFrom" 
                                    aria-invalid="false" 
                                    placeholder="<?php echo language('document/card/cardstatus', 'tCardShiftStatusFrom'); ?>"
                                    data-validate="Please Insert Doc Date">
                                <span class="prefix xCNiConGen xCNIconBrowse"><i class="fa fa-calendar" aria-hidden="true" onclick="$('#oetCardShiftStatusSearchDocDateFrom').focus()"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-left-15">
                        <div class="form-group">
                            <div class="validate-input">
                                <input 
                                    class="form-control input100 xCNDatePicker" 
                                    type="text" 
                                    name="oetCardShiftStatusSearchDocDateTo" 
                                    id="oetCardShiftStatusSearchDocDateTo" 
                                    aria-invalid="false" 
                                    placeholder="<?php echo language('document/card/cardstatus', 'tCardShiftStatusTo'); ?>"
                                    data-validate="Please Insert Doc Date">
                                <span class="prefix xCNiConGen xCNIconBrowse"><i class="fa fa-calendar" aria-hidden="true" onclick="$('#oetCardShiftStatusSearchDocDateTo').focus()"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/card/cardstatus','tCardShiftStatusTBDocStatus'); ?></label>
                    </div>
                    <div class="form-group">
                        <select class="selectpicker form-control" id="ocmCardShiftStatusStaDoc" name="ocmCardShiftStatusStaDoc">
                            <option value='0'><?php echo language('common/main/main','tAll'); ?></option>
                            <option value='1'><?php echo language('document/card/cardstatus','tCardShiftStatusTBComplete'); ?></option>
                            <option value='2'><?php echo language('document/card/cardstatus','tCardShiftStatusTBIncomplete'); ?></option>
                            <option value='3'><?php echo language('document/card/cardstatus','tCardShiftStatusTBCancel'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/card/cardstatus','tCardShiftStatusTBApproveStatus'); ?></label>
                    </div>
                    <div class="form-group">
                        <select class="selectpicker form-control" id="ocmCardShiftStatusStaApprove" name="ocmCardShiftStatusStaApprove">
                            <option value='0'><?php echo language('common/main/main','tAll'); ?></option>
                            <option value='3'><?php echo language('document/card/cardstatus','tCardShiftStatusTBPending'); ?></option>
                            <option value='2'><?php echo language('document/card/cardstatus','tCardShiftStatusTBProcessing'); ?></option>
                            <option value='1'><?php echo language('document/card/cardstatus','tCardShiftStatusTBApproved'); ?></option>
                            <option value='4'><?php echo language('document/card/cardstatus','N/A'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <a id="oahCardShiftStatusAdvanceSearchSubmit" class="btn xCNBTNDefult xCNBTNDefult1Btn pull-right" href="javascript:;" onclick="JSvCardShiftStatusCardShiftStatusDataTable()"><?php echo language('common/main/main', 'tSearch'); ?></a>
                </div>
            </div>
        </section>
    </div>
    <div class="panel-body">
        <!--- Data Table -->
        <section id="ostDataCardShiftStatus"></section>
        <!-- End DataTable-->
    </div>
</div>
<?php include 'script/jCardShiftStatusList.php'; ?>



