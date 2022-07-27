<div class="panel panel-headline">
    <div class="panel-heading"> <!-- เพิ่ม -->
        <section id="ostSearchCardShiftNewCard">
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('common/main/main','tSearch'); ?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchCardShiftNewCard" name="oetSearchCardShiftNewCard" placeholder="<?php echo language('common/main/main','tSearch'); ?>">
                            <span class="input-group-btn">
                                <button id="obtSearchCardShiftNewCard" class="btn xCNBtnSearch" type="button">
                                    <img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                                </button>
                                <a id="oahCardShiftNewCardSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxCardShiftNewCardClearSearchData()"><?php echo language('common/main/main', 'tClearSearch'); ?></a>
                                <a id="oahCardShiftNewCardAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;"><?php echo language('common/main/main', 'tAdvanceSearch'); ?></a>
                            </span>
                        </div>
                    </div>
                </div>
                <?php if(false) : ?>
                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1 ) : ?>
                    <div class="col-xs-12 col-md-6 col-lg-6 text-right" style="margin-top:34px;">
                        <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                            <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                                <?php echo language('common/main/main', 'tCMNChoose'); ?>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li id="oliBtnDeleteAll" class="disabled">
                                    <a href="javascript:;" data-toggle="modal" data-target="#odvModalDelCardShiftNewCard" onclick=""><?php echo language('common/main/main', 'tCMNDeleteAll'); ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="row hidden" id="odvCardNewCardAdvanceSearchContainer">
                <div class="col-xs-6 col-md-6 col-lg-6 pad-0">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/card/cardchange','tCardShiftChangeTBDocDate'); ?></label>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-right-15">
                        <div class="form-group">
                            <div class="">
                                <div class="input-group">
                                    <input 
                                        class="form-control xCNDatePicker" 
                                        type="text" 
                                        name="oetCardShiftNewCardSearchDocDateFrom" 
                                        id="oetCardShiftNewCardSearchDocDateFrom" 
                                        aria-invalid="false" 
                                        placeholder="<?php echo language('document/card/newcard', 'tCardShiftNewCardFrom'); ?>"
                                        data-validate="Please Insert Doc Date">
                                    <span class="input-group-btn">
                                        <button onclick="$('#oetCardShiftNewCardSearchDocDateFrom').focus()" type="button" class="btn xCNBtnDateTime">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-left-15">
                        <div class="form-group">
                            <div class="">
                                <div class="input-group">
                                    <input 
                                        class="form-control input100 xCNDatePicker" 
                                        type="text" 
                                        name="oetCardShiftNewCardSearchDocDateTo" 
                                        id="oetCardShiftNewCardSearchDocDateTo" 
                                        aria-invalid="false" 
                                        placeholder="<?php echo language('document/card/newcard', 'tCardShiftNewCardTo'); ?>"
                                        data-validate="Please Insert Doc Date">
                                    <span class="input-group-btn">
                                        <button onclick="$('#oetCardShiftNewCardSearchDocDateTo').focus()" type="button" class="btn xCNBtnDateTime">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-3 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/card/cardchange','tCardShiftChangeTBDocStatus'); ?></label>
                    </div>
                    <div class="form-group">
                        <select class="selectpicker form-control" id="ocmCardNewCardStaDoc" name="ocmCardNewCardStaDoc">
                            <option value='0'><?php echo language('common/main/main','tAll'); ?></option>
                            <option value='1'><?php echo language('document/card/cardchange','tCardShiftChangeTBComplete'); ?></option>
                            <option value='2'><?php echo language('document/card/cardchange','tCardShiftChangeTBIncomplete'); ?></option>
                            <option value='3'><?php echo language('document/card/cardchange','tCardShiftChangeTBCancel'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-3 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/card/cardchange','tCardShiftChangeTBApproveStatus'); ?></label>
                    </div>
                    <div class="form-group">
                        <select class="selectpicker form-control" id="ocmCardNewCardStaApprove" name="ocmCardNewCardStaApprove">
                            <option value='0'><?php echo language('common/main/main','tAll'); ?></option>
                            <option value='3'><?php echo language('document/card/cardchange','tCardShiftChangeTBPending'); ?></option>
                            <option value='2'><?php echo language('document/card/cardchange','tCardShiftChangeTBProcessing'); ?></option>
                            <option value='1'><?php echo language('document/card/cardchange','tCardShiftChangeTBApproved'); ?></option>
                            <option value='4'><?php echo language('document/card/cardchange','N/A'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <a id="oahCardShiftChangeAdvanceSearchSubmit" class="btn xCNBTNDefult xCNBTNDefult1Btn pull-right" href="javascript:;" onclick="JSvCardShiftNewCardDataTable()"><?php echo language('common/main/main', 'tSearch'); ?></a>
                </div>
            </div>
        </section>
    </div>
    <div class="panel-body">
        <!--- Data Table -->
        <section id="ostDataCardShiftNewCard"></section>
        <!-- End DataTable-->
    </div>
</div>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include 'script/jCardShiftNewCardList.php'; ?>


