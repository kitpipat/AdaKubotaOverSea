<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="row">
            <!--ค้นหาธรรมดา-->
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">
                    <div class="input-group">
                        <input
                            class="form-control xCNInputWithoutSingleQuote"
                            type="text"
                            id="oetSearchAll"
                            name="oetSearchAll"
                            placeholder="<?=language('common/main/main','tPlaceholder')?>"
                            onkeyup="Javascript:if(event.keyCode==13) JSvPAMCallPageDataTable()"
                            autocomplete="off"
                        >
                        <span class="input-group-btn">
                            <button type="button" class="btn xCNBtnDateTime" onclick="JSvPAMCallPageDataTable()">
                                <img class="xCNIconSearch">
                            </button>
                        </span>
                    </div>
                </div>
            </div>

            <!--ค้นหาขั้นสูง-->
            <a id="oahPAMAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;"><?=language('common/main/main', 'tAdvanceSearch'); ?></a>

            <!--ล้างข้อมูลค้นหา-->
            <a class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxPAMClearAdvSearchData()"><?=language('common/main/main', 'tClearSearch'); ?></a>
        </div>

        <!--ค้นหาขั้นสูง-->
        <div id="odvPAMAdvanceSearchContainer" class="hidden" style="margin-bottom:20px;">

            <div class="row">
            <!-- สาขาที่สร้าง -->
            <?php
                // $tSesUsrLevel = $this->session->userdata("tSesUsrLevel");
                // if( $tSesUsrLevel != "HQ" ){
                //     $tBchCodeDefault    = $this->session->userdata("tSesUsrBchCodeDefault");
                //     $tBchNameDefault    = $this->session->userdata("tSesUsrBchNameDefault");

                //     $nSesUsrBchCount    = $this->session->userdata("nSesUsrBchCount");
                //     if( $nSesUsrBchCount == 1 ){
                //         $tDisabledBch = "disabled";
                //     }else{
                //         $tDisabledBch = "";
                //     }

                // }else{
                //     $tBchCodeDefault    = "";
                //     $tBchNameDefault    = "";
                //     $tDisabledBch       = "";
                // }
            ?>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tDocBchCreate') ?></label>
                    <div class="input-group"><input type="text" class="form-control xControlForm xCNHide" id="oetPAMBchCode" name="oetPAMBchCode" maxlength="5" value="<?=@$tBchCodeDefault?>">
                        <input type="text" class="form-control xControlForm xWPointerEventNone" id="oetPAMBchName" name="oetPAMBchName" maxlength="100" placeholder="<?php echo language('document/productarrangement/productarrangement', 'tDocBchCreate') ?>" value="<?=@$tBchNameDefault?>" readonly>
                        <span class="input-group-btn">
                            <button id="obtPAMBrowseBch" type="button" class="btn xCNBtnBrowseAddOn" <?=@$tDisabledBch?> >
                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
                </div>
            </div>
                
            <!-- ประเภทใบจัด -->
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMPackingType'); ?></label>
                    <select class="selectpicker xWPAMDisabledOnApv form-control xControlForm" id="ocmPAMPackType" name="ocmPAMPackType" maxlength="1">
                        <option value="0" selected><?php echo language('common/main/main', 'tAll'); ?></option>
                        <option value="11"><?php echo language('document/productarrangement/productarrangement', 'tPAMDocType1'); ?></option>
                        <option value="13"><?php echo language('document/productarrangement/productarrangement', 'tPAMDocType2'); ?></option>
                    </select>
                </div>
            </div>

            <!-- จากวันที่เอกสาร -->
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('document/document/document', 'tDocDateFrom'); ?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xControlForm xCNDatePicker xCNInputMaskDate" id="oetPAMDocDateFrm" name="oetPAMDocDateFrm" value="" placeholder="<?php echo language('document/document/document', 'tDocDateFrom') ?>">
                        <span class="input-group-btn">
                            <button id="obtPAMDocDateFrm" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                        </span>
                    </div>
                </div>
            </div>
                
            <!-- ถึงวันที่เอกสาร -->
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('document/document/document', 'tDocDateTo'); ?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xControlForm xCNDatePicker xCNInputMaskDate" id="oetPAMDocDateTo" name="oetPAMDocDateTo" value="" placeholder="<?php echo language('document/document/document', 'tDocDateTo') ?>">
                        <span class="input-group-btn">
                            <button id="obtPAMDocDateTo" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                        </span>
                    </div>
                </div>
            </div>
            </div>

            <div class="row">
            <!-- ที่เก็บ -->
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMLocation') ?></label>
                    <div class="input-group"><input type="text" class="form-control xControlForm xCNHide" id="oetPAMPlcCode" name="oetPAMPlcCode" maxlength="5" value="">
                        <input type="text" class="form-control xControlForm xWPointerEventNone" id="oetPAMPlcName" name="oetPAMPlcName" maxlength="100" placeholder="<?php echo language('document/productarrangement/productarrangement', 'tPAMLocation') ?>" value="" readonly>
                        <span class="input-group-btn">
                            <button id="obtPAMBrowsePlc" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
                </div>
            </div>

            <!-- หมวดสินค้า 1-5 -->
            <?php for($i=1;$i<=2;$i++){ ?>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMCat'.$i) ?></label>
                    <div class="input-group"><input type="text" class="form-control xControlForm xCNHide" id="oetPAMCat<?=$i?>Code" name="oetPAMCat<?=$i?>Code" maxlength="10" value="">
                        <input type="text" class="form-control xControlForm xWPointerEventNone" id="oetPAMCat<?=$i?>Name" name="oetPAMCat<?=$i?>Name" maxlength="100" placeholder="<?php echo language('document/productarrangement/productarrangement', 'tPAMCat'.$i) ?>" value="" readonly>
                        <span class="input-group-btn">
                            <button id="obtPAMBrowseCat<?=$i?>" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
                </div>
                </div>
            <?php } ?>

            <!-- สถานะเอกสาร -->
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('document/document/document', 'tDocStaDoc'); ?></label>
                    <select class="selectpicker xWPAMDisabledOnApv form-control xControlForm" id="ocmPAMStaDoc" name="ocmPAMStaDoc" maxlength="1">
                        <option value="0" selected><?php echo language('common/main/main', 'tAll'); ?></option>
                        <option value="2"><?php echo language('document/document/document', 'tDocStaProApv'); ?></option>
                        <option value="1"><?php echo language('document/document/document', 'tDocStaProApv1'); ?></option>
                        <option value="3"><?php echo language('document/document/document', 'tDocStaProDoc3'); ?></option>
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                <div class="form-group" style="width: 60%;">
                    <label class="xCNLabelFrm">&nbsp;</label>
                    <button  type="button" id="obtPAMConfirmSearch" class="btn xCNBTNPrimery" style="width:100%" ><?php echo language('common/main/main', 'tSearch'); ?></button>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-8 col-sm-4 col-md-4 col-lg-4"></div>
            <!--ตัวเลือกลบหลายตัว-->
            <div class="col-xs-4 col-sm-8 col-md-8 col-lg-8 text-right" style="margin-top:-35px;">
                <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                        <?=language('common/main/main','tCMNOption')?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li id="oliPAMBtnDeleteAll" class="disabled">
                            <a data-toggle="modal" data-target="#odvPAMModalDelDocMultiple"><?= language('common/main/main','tDelAll')?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
		<section id="ostPAMDataTableDocument"></section>
	</div>
</div>

<script src="<?=base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?=base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include('script/jArrangementProductFormSearchList.php')?>
