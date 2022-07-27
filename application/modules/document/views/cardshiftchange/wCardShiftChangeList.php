<div class="panel panel-headline"> <!-- เพิ่ม -->
    <div class="panel-heading"> <!-- เพิ่ม -->
        <section id="ostSearchRecive">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                        <label class="xCNLabelFrm"><?= language('common/main/main','tSearch')?></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="oetSearchAll" name="oetSearchAll" placeholder="<?= language('common/main/main','tSearch')?>" onkeypress="Javascript:if(event.keyCode==13) JSvCardShiftChangeCardShiftChangeDataTable()">
                            <span class="input-group-btn">
                                <button id="oimSearchCardShiftChange" class="btn xCNBtnSearch" type="button" onclick="JSvCardShiftChangeCardShiftChangeDataTable()">
                                    <img class="xCNIconAddOn" src="<?php echo base_url('application/modules/common/assets/images/icons/search-24.png'); ?>">
                                </button>
                                <a id="oahCardShiftChangeSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxCardShiftChangeClearSearchData()"><?php echo language('common/main/main', 'tClearSearch'); ?></a>
                                <a id="oahCardShiftChangeAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;"><?php echo language('common/main/main', 'tAdvanceSearch'); ?></a>
                            </span>
                        </div>
                    </div>
                </div>
                <?php if(false) : ?>
                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1 ) : ?>
                <div class="col-xs-12 col-md-6 col-lg-6 text-right" style="margin-top:34px;">
                    <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                        <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                            ตัวเลือก
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li id="oliBtnDeleteAll" class="disabled">
                                <a href="javascript:;" data-toggle="modal" data-target="#odvModalDelCardShiftChange" onclick="JSxCardShiftChangeSetDataBeforeDelMulti()">ลบทั้งหมด</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="row hidden" id="odvCardShiftChangeAdvanceSearchContainer">
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/card/cardchange','tCardShiftChangeTBDocDate'); ?></label>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-right-15">
                        <div class="form-group">
                            <div class="validate-input">
                                <input 
                                    class="form-control input100 xCNDatePicker" 
                                    type="text" 
                                    name="oetCardShiftChangeSearchDocDateFrom" 
                                    id="oetCardShiftChangeSearchDocDateFrom" 
                                    aria-invalid="false" 
                                    placeholder="<?php echo language('document/card/cardchange', 'tCardShiftChangeFrom'); ?>"
                                    data-validate="Please Insert Doc Date">
                                <span class="prefix xCNiConGen xCNIconBrowse"><i class="fa fa-calendar" aria-hidden="true" onclick="$('#oetCardShiftChangeSearchDocDateFrom').focus()"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-left-15">
                        <div class="form-group">
                            <div class="validate-input">
                                <input 
                                    class="form-control input100 xCNDatePicker" 
                                    type="text" 
                                    name="oetCardShiftChangeSearchDocDateTo" 
                                    id="oetCardShiftChangeSearchDocDateTo" 
                                    aria-invalid="false" 
                                    placeholder="<?php echo language('document/card/cardchange', 'tCardShiftChangeTo'); ?>"
                                    data-validate="Please Insert Doc Date">
                                <span class="prefix xCNiConGen xCNIconBrowse"><i class="fa fa-calendar" aria-hidden="true" onclick="$('#oetCardShiftChangeSearchDocDateTo').focus()"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/card/cardchange','tCardShiftChangeTBDocStatus'); ?></label>
                    </div>
                    <div class="form-group">
                        <select class="selectpicker form-control" id="ocmCardShiftChangeStaDoc" name="ocmCardShiftChangeStaDoc">
                            <option value='0'><?php echo language('common/main/main','tAll'); ?></option>
                            <option value='1'><?php echo language('document/card/cardchange','tCardShiftChangeTBComplete'); ?></option>
                            <option value='2'><?php echo language('document/card/cardchange','tCardShiftChangeTBIncomplete'); ?></option>
                            <option value='3'><?php echo language('document/card/cardchange','tCardShiftChangeTBCancel'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/card/cardchange','tCardShiftChangeTBApproveStatus'); ?></label>
                    </div>
                    <div class="form-group">
                        <select class="selectpicker form-control" id="ocmCardShiftChangeStaApprove" name="ocmCardShiftChangeStaApprove">
                            <option value='0'><?php echo language('common/main/main','tAll'); ?></option>
                            <option value='3'><?php echo language('document/card/cardchange','tCardShiftChangeTBPending'); ?></option>
                            <option value='2'><?php echo language('document/card/cardchange','tCardShiftChangeTBProcessing'); ?></option>
                            <option value='1'><?php echo language('document/card/cardchange','tCardShiftChangeTBApproved'); ?></option>
                            <option value='4'><?php echo language('document/card/cardchange','N/A'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <a id="oahCardShiftChangeAdvanceSearchSubmit" class="btn xCNBTNDefult xCNBTNDefult1Btn pull-right" href="javascript:;" onclick="JSvCardShiftChangeCardShiftChangeDataTable()"><?php echo language('common/main/main', 'tSearch'); ?></a>
                </div>
            </div>
        </section>
    </div>
    <div class="panel-body">
        <!--- Data Table -->
        <section id="ostDataCardShiftChange"></section>
        <!-- End DataTable-->
    </div>
</div>
<?php include 'script/jCardShiftChangeList.php'; ?>



