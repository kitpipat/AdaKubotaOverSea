<?php
require_once('././././config_deploy.php');
?>
<input type="hidden" id="ohdBaseUrlUseInJS" value="<?php echo base_url(); ?>">

<!-- Modal Browse -->
<div class="modal fade" id="odvModalBrowse">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-6 pad-0">
                        <label id="olbModalTitle" class="xCNTextModalHeard">Browse</label>
                    </div>
                    <div class="col-md-6 pad-0 text-right">
                        <button class="btn xCNBTNDefult" data-dismiss="modal" aria-label="Close"><?php echo language('common/main/main', 'tModalCancel') ?></button>
                        <button id="obtBrowseSB" class="btn xCNBTNPrimery xCNBtnBrowse"><?php echo language('common/main/main', 'tCMNChoose') ?></button>
                        <button id="obtBrowseMB" class="btn xCNBTNPrimery xCNBtnBrowse"><?php echo language('common/main/main', 'tCMNChooseAll') ?></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="wrap-input100">
                                            <span class="xCNTextDetail1"><?php echo language('common/main/main', 'tSearch') ?></span>
                                            <input class="input100" type="text" id="oetBrowseSearchAll" name="oetBrowseSearchAll">
                                            <span class="focus-input100"></span>
                                            <i id="odvClickSearch" class="fa fa-magic prefix xCNiConBrowse"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-5"></div>
                                    <div class="col-md-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div id="odvBrowseTable" class="table-responsive" style="margin-top:15px !important"></div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div id="odvBrowseTotalAll" class="col-lg-6" style="padding-top: 30px;"></div>
                            <div id="odvBrowsePaging" class="col-lg-6 pad-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="oetBrowseCode">
    <input type="hidden" id="oetBrowseName">
</div>

<!-- Modal Pdt For Document-->
<div class="modal fade" id="odvBrowsePdt">
    <div class="modal-dialog" style="width: 75%;">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo  language('document/browsepdt/browsepdt', 'tBRWPdtInfo') ?></label>
                    </div>
                    <div class="col-xs-12 col-md-6 text-right">
                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JSxPDTConfirmSelected()"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                        <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <input type="text" class="form-control" maxlength="25" id="oetBrowsePdtBarCode" name="oetBrowsePdtBarCode" placeholder="<?php echo language('document/browsepdt/browsepdt', 'tBrowsePdtCodeOrBarCode') ?>" onkeyup="Javascript:if (event.keyCode == 13) JSxPdtBrowseSearch()">
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <input type="text" class="form-control" maxlength="25" id="oetBrowsePdtCode" name="oetBrowsePdtCode" placeholder="<?php echo language('document/browsepdt/browsepdt', 'tBrowsePdtCode') ?>" onkeyup="Javascript:if (event.keyCode == 13) JSxPdtBrowseSearch()">
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <input type="text" class="form-control" maxlength="100" id="oetBrowsePdtName" name="oetBrowsePdtName" placeholder="<?php echo language('document/browsepdt/browsepdt', 'tBrowsePdtName') ?>" onkeyup="Javascript:if (event.keyCode == 13) JSxPdtBrowseSearch()">
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <select class="selectpicker form-control" id="ostBrowsePdtPunCode" name="ostBrowsePdtPunCode" maxlength="1">
                                <option value="">-- <?php echo  language('document/browsepdt/browsepdt', 'tSelectPdtPun') ?> --</option>
                                <?php if (is_array($aDataPdtUnit) == 1) { ?>
                                    <?php foreach ($aDataPdtUnit as $Key => $Value) { ?>
                                        <option value="<?php echo $Value->FTPunCode ?>"><?php echo $Value->FTPunName ?></option>
                                    <?php } ?>
                                <?php } else { ?>
                                    <option value="">-</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-1">
                        <button class="btn" onclick="JSxPdtBrowseSearch()" style="background: #eeeeee;height: 34px;">
                            <img style="cursor: pointer;width: 20px;margin-right: 5px;" src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/search-24.png' ?>">
                        </button>
                    </div>
                    <div class="col-xs-12 col-md-3 text-right">
                        <button class="xCNBtnPushModalBrowse" onclick="JSvCallPagePdtMaster()">+</button>
                    </div>
                </div>
                <div id="odvBrowsePdtPanal"></div>
                <div id="odvPdtDataMultiSelection"></div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Pdt For Document-->

<!-- Modal Info Message-->
<div class="modal fade" id="odvModalInfoMessage" data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
    <div class="modal-dialog" role="document" style="width: 450px; margin: 1.75rem auto;top:20%;">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <h3 style="font-size:20px;color:#08f93e;font-weight: 1000;"><i class="fa fa-info"></i> <span id="ospHeader"></span></h3>
            </div>
            <div class="modal-body">
                <div class="xCNMessage"></div>
                <div class="clearfix"></div>
                <div class="text-center">
                    <div class="ldBar label-center" style="width:50%;height:50%;margin:auto;" data-value="0" data-preset="circle" data-stroke="#21bd35" data-stroke-trail="#b2f5be" id="odvIdBar">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="xCNTextResponse"></div>
            </div>
            <div class="modal-footer">
                <button class="btn xCNBTNPrimery xCNBTNDefult2Btn" type="button" data-dismiss="modal">
                    <?php echo  language('common/main/main', 'tCMNOK') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Overlay Projects -->
<div class="xCNOverlay">
    <img src="<?php echo base_url() ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
</div>

<!-- Overlay Data -->
<div class="xCNOverlayLodingData" style="z-index: 7000;">
    <img src="<?php echo base_url(); ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
    <div id="odvOverLayContentForLongTimeLoading" style="display: none;"><?php echo language('common/main/main', 'tLodingData'); ?></div>
</div>
<!-- Close Overlay Data -->

<!-- Modal Crop -->
<div id="odvModalCrop"></div>

<!-- END Modal Croup -->
<div class="clearfix"></div>

<!-- Tab Chang Lang -->
<div class="footer container-fluid" id="odvLangEditPanal">
    <div class="row xCNWidth100per xCNHight100per">
        <div class="col-xs-6 xCNHight100per">
            <div class="xCNFooterPanalHelp xCNWidth100per xCNHight100per">
                <span class="xCNMrgLeft"><?php echo VERSION_DEPLOY; ?></span>
            </div>
        </div>
        <div class="col-xs-6 xCNHight100per">
            <div class="xCNFooterPanalHelp xCNWidth100per xCNHight100per text-right">
                <span class="xCNMrgRight">Connect : <?php echo BASE_DATABASE; ?></span>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TEMPIMG -->
<div class="modal fade bd-example-modal-lg" id="odlModalTempImg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-6">
                        <label class="xCNTextModalHeard">คลังรูปภาพ</label>
                    </div>
                    <div class="col-md-6 text-right">
                        <input style="display:none;" type="file" id="oetInputUplode" onchange="JSxImageUplodeResize(this)" accept="image/*">
                        <button onclick="$('#oetInputUplode').click()" class="btn xCNBTNPrimery xCNBTNPrimery1Btn" type="button">อัพโหลดรูปภาพ</button>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="overflow-x:auto;padding:0px">
                <div class="xCNImgContraner">
                    <div id="odvImgItemsList" class="wf-container"></div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div id="odvImgTotalPage" class="col-md-6"></div>
                    <div id="odvImgPagenation" class="col-md-6"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Error-->
<div class="modal fade" id="odvModalError" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 5000; display: none;">
    <div class="modal-dialog" id="modal-customsError" role="document" style="width: 450px; margin: 1.75rem auto;top:20%;">
        <div class="modal-content" id="odvModalBodyError">
            <div class="modal-header xCNModalHead">
                <h3 style="font-size:20px;color:red;font-weight: 1000;"><i class="fa fa-exclamation-triangle"></i> <?php echo language('common/main/main', 'tModalError') ?></h3>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button class="btn xCNBTNPrimery xCNBTNDefult2Btn" type="button" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tCMNOK') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Wanning-->
<div class="modal fade" id="odvModalWanning" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 5000; display: none;">
    <div class="modal-dialog" id="modal-customsWanning" role="document" style="margin: 1.75rem auto;top:20%;">
        <div class="modal-content" id="odvModalBodyWanning">
            <div class="modal-header xCNModalHead">
                <h3 style="font-size:20px;color:#FFFF00;font-weight: 1000;"><i class="fa fa-exclamation-triangle"></i> <?php echo language('common/main/main', 'tModalWarning') ?></h3>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button class="btn xCNBTNPrimery xCNBTNDefult2Btn xWBtnOK" type="button" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tCMNOK') ?>
                </button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn xWBtnCancel" type="button" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tCancel') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Create By Witsarut 18/06/20
Modal Info Message Confirm
Message Modal Confirm for login and ChangePassword -->
<div class="modal fade" id="odvModalInfoMessageFrm" data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
    <div class="modal-dialog" role="document" style="width: 450px; margin: 1.75rem auto;top:20%;">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <h3 style="font-size:20px;color:#08f93e;font-weight: 1000;"><i class="fa fa-info"></i> <span id="ospHeader"></span></h3>
            </div>
            <div class="modal-body">
                <div class="xCNMessage"></div>
                <div class="clearfix"></div>
                <div class="text-center">
                    <div class="ldBar label-center" style="width:50%;height:50%;margin:auto;" data-value="0" data-preset="circle" data-stroke="#21bd35" data-stroke-trail="#b2f5be" id="odvIdBar">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="xCNTextResponse"></div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<!-- Modal เปลี่ยนภาษาเพิ่มเติม-->
<div class="modal fade" id="odvModalSwitchLang" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 5000; display: none;">
    <div class="modal-dialog modal-lg" role="document" style="margin: 1.75rem auto;">
        <div class="modal-content xCNContentlSwitchLang"></div>
    </div>
</div>

<!-- Modal Muti เนล-->
<div id="odvModalBrowseMultiContent"></div>

<!-- Create By Supawat 02/07/20 Modal เวลากด Import File -->
<div class="modal fade" id="odvModalImportFile" data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
    <div class="modal-dialog" role="document" style="width: 450px; margin: 1.75rem auto;top:20%;">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;">นำเข้าข้อมูล</label>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div id="odvContentFileImport">
                    <div class="form-group">
                        <div class="input-group">
                            <!--Hidden : ชื่อหน้าจอ -->
                            <input type="hidden" class="form-control" id="ohdImportNameModule" name="ohdImportNameModule">

                            <!--Hidden : route หลังจาก import เสร็จแล้ว [Document] - [Master] -->
                            <input type="hidden" class="form-control" id="ohdImportAfterRoute" name="ohdImportAfterRoute">

                            <!--Hidden : Type Import [Document] - [Master] -->
                            <input type="hidden" class="form-control" id="ohdImportTypeModule" name="ohdImportTypeModule">

                            <!--Hidden : สำหรับ [Document] ว่ามันจะมีการตรวจสอบ ว่าเคลียร์ทั้งหมด และเพิ่ม ใหม่ หรือ เพิ่มจำนวนต่อจากเดิม  -->
                            <input type="hidden" class="form-control" id="ohdImportClearTempOrInsCon" name="ohdImportClearTempOrInsCon">

                            <input type="text" class="form-control" id="oetFileNameImport" name="oetFileNameImport" placeholder="เลือกไฟล์" readonly="">
                            <input type="file" class="form-control" style="visibility: hidden; position: absolute;" id="oefFileImportExcel" name="oefFileImportExcel" onchange="JSxCheckFileImportFile(this, event)" accept=".csv,application/vnd.ms-excel,.xlt,application/vnd.ms-excel,.xla,application/vnd.ms-excel,.xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,.xltx,application/vnd.openxmlformats-officedocument.spreadsheetml.template,.xlsm,application/vnd.ms-excel.sheet.macroEnabled.12,.xltm,application/vnd.ms-excel.template.macroEnabled.12,.xlam,application/vnd.ms-excel.addin.macroEnabled.12,.xlsb,application/vnd.ms-excel.sheet.binary.macroEnabled.12">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" style="border-radius: 0px 5px 5px 0px;" onclick="$('#oefFileImportExcel').click()">
                                    เลือกไฟล์
                                </button>
                                <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" style="border-radius: 0px !important; margin-left: 30px; width: 100px;" id="obtIMPConfirmUpload" onclick="JSxImportFileExcel()"><?php echo language('common/main/main', 'ตกลง') ?></button>
                            </span>
                        </div>
                    </div>
                    <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                        <a id="oahDowloadTemplate" href="<?= base_url('application/modules/common/assets/template/Branch_Template.xlsx') ?>">
                            <u>ดาวน์โหลดแม่แบบ</u>
                        </a>
                    </div>
                </div>
                <div id="odvContentRenderHTMLImport"></div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-6">
                        <span id="ospTextSummaryImport" style="text-align: left; display: block; font-weight: bold;"></span>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" id="obtIMPUpdateAgain" style="display:none;"><?php echo language('common/main/main', 'เลือกไฟล์ใหม่') ?></button>
                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" id="obtIMPConfirm" style="display:none;"><?php echo language('common/main/main', 'ยืนยันการนำเข้า') ?></button>
                        <button class="btn xCNBTNDefult xCNBTNDefult2Btn" id="obtIMPCancel" data-dismiss="modal"><?php echo language('common/main/main', 'ยกเลิก') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create By Supawat 02/07/20 Modal เวลากด Import File -->
<div class="modal fade" id="odvModalDialogClearData" data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
    <div class="modal-dialog" role="document" style="margin: 1.75rem auto; top: 20%;">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <h3 style="font-size:20px;color:#FFFF00;font-weight: 1000;"><i class="fa fa-exclamation-triangle"></i> <?= language('common/main/main', 'tModalWarning') ?></h3>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    ข้อมูลที่ทำรายการไปแล้ว จะถูกล้างทั้งหมด และนำเข้าใหม่ กดยืนยันเพื่อดำเนินการต่อ ?
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" data-dismiss="modal" id="obtConfirmDeleteBeforeInsert"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- END WRAPPER -->
<input type="hidden" class="form-control" id="ohdMsgSesExpired" name="ohdSessionLogin" value="<?php echo language('common/main/main', 'tMsgSesExpired'); ?>">
<input type="hidden" id="ohdSystemIsInProgress" name="ohdSystemIsInProgress" value="<?php echo language('common/main/main', 'tMainSystemIsInProgress'); ?>">
<input type="hidden" id="ohdHideProcessProgress" name="ohdHideProcessProgress" value="<?php echo language('common/main/main', 'tMainHideProcessProgress'); ?>">
<input type="hidden" id="ohdHideProcessProgressDone" name="ohdHideProcessProgressDone" value="<?php echo language('common/main/main', 'tMainHideProcessProgressDone'); ?>">
<input type="hidden" id="ohdCMNOK" name="ohdCMNOK" value="<?php echo language('common/main/main', 'tCMNOK'); ?>">
<input type="hidden" class="form-control" id="ohdBaseURL" name="ohdBaseURL" value="<?php echo base_url(); ?>">
<input type="hidden" class="form-control" id="ohdUserLevel" name="ohdUserLevel" value="<?php echo $this->session->userdata('tSesUsrLevel'); ?>">
<input type="hidden" id="ohdRptNotFoundDataInDB" name="ohdRptNotFoundDataInDB" value="<?php echo language('common/main/main', 'tMainRptNotFoundDataInDB'); ?>">

<!-- ===================== BaseURL Project =============================== -->
<script>
    var tBaseURL = document.getElementById('ohdBaseURL').value;
</script>
<!-- ===================================================================== -->

<!-- ===================== Rabbit MQ Config =============================== -->
<script>
    //SwitchLang
    var aPackDataLang = [];

    window.oSTOMMQConfig = {
        host: '<?php echo HOST ?>',
        user: '<?php echo USER ?>',
        password: '<?php echo PASS ?>',
        vhost: '<?php echo VHOST ?>',
        port: '<?php echo PORT ?>',
        exchange: '<?php echo EXCHANGE ?>'
    };

    window.oRPTSTOMMQConfig = {
        host: '<?php echo MQ_REPORT_HOST ?>',
        user: '<?php echo MQ_REPORT_USER ?>',
        password: '<?php echo MQ_REPORT_PASS ?>',
        vhost: '<?php echo MQ_REPORT_VHOST ?>',
        port: '<?php echo MQ_REPORT_PORT ?>',
        exchange: '<?php echo MQ_REPORT_EXCHANGE ?>'
    };

    window.oBKLSTOMMQConfig = {
        host: '<?php echo MQ_BOOKINGLK_HOST ?>',
        user: '<?php echo MQ_BOOKINGLK_USER ?>',
        password: '<?php echo MQ_BOOKINGLK_PASS ?>',
        vhost: '<?php echo MQ_BOOKINGLK_VHOST ?>',
        port: '<?php echo MQ_BOOKINGLK_PORT ?>',
        exchange: '<?php echo MQ_BOOKINGLK_EXCHANGE ?>'
    }
</script>
<!-- ===================================================================== -->

<!-- BootStrap Select -->
<script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/bootstrap-select-1.13.2/dist/js/bootstrap-select.min.js"></script>

<!-- Layout Pinterest -->
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/global/Waterfall/responsive_waterfall.js"></script>

<!-- Map Open Layer -->
<script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/openlayers/ol.js"></script>

<!-- Bootstrap tooltips -->
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/popper.min.js"></script>

<!-- MDB common JavaScript -->
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/mdb.min.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/accounting.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/select2/select2.min.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/global/ContactFrom/main.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/multiple-select.js"></script>

<!-- table dnd -->
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.tablednd.js"></script>

<!-- fullcalendar  02/09/2019-->
<!-- To Protect for virus -->
<!-- Update by Witsarut New Download lasttime still https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js -->
<script src="application/modules/common/assets/js/fullcalendar.min.js"></script>

<!--Key Password-->
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/global/PasswordAES128/aes.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/global/PasswordAES128/cAES128.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/global/PasswordAES128/AESKeyIV.js"></script>

<!-- JS Custom AdaSoft -->
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jCommon.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jCommonRabbitMQ.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jPageControll.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jBrowseModal.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jBrowseProduct.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jBrowseMultiSelect.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jAjaxErrorHandle.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jTempImage.js"></script>

<!--Import Excel-->
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jImportExcel.js"></script>

<!--helper import export excel-->
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jExcelCenter.js"></script>

<!-- Loading Bar -->
<script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/loading-bar/loading-bar.js"></script>

<!-- RabbitMQ -->
<script src="<?php echo base_url('application/modules/common/assets/vendor/rabbitmq/stomp.min.js'); ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/vendor/rabbitmq/sockjs.min.js'); ?>"></script>

<!-- Print JS -->
<script src="<?php echo base_url('application/modules/common/assets/js/global/PrintJS/print.min.js'); ?>"></script>

<!-- Thai Bath Text -->
<script src="<?php echo base_url('application/modules/common/assets/src/jThaiBath.js'); ?>"></script>

<!-- Modal PDT for:supawat -->
<div class="modal fade" id="odvModalDOCPDT" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="overflow: hidden auto; z-index: 5000; display: none;">
    <div class="modal-dialog" id="modal-customsWanning" role="document" style="width: 85%; margin: 1.75rem auto;top:0%;">
        <div class="modal-content" id="odvModalBodyPDT">
            <div class="modal-header xCNModalHead">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('common/main/main', 'tShowData') . ' ' . language('common/main/main', 'tModalHeadnamePDT'); ?></label>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JCNxConfirmSelectedPDT()"><?php echo language('common/main/main', 'tModalAdvChoose') ?></button>
                        <button class="btn xCNBTNDefult xCNBTNDefult2Btn" onclick="JCNxRemoveSelectedPDT()" data-dismiss="modal"><?php echo  language('common/main/main', 'tModalCancel'); ?></button>
                    </div>
                </div>
            </div>
            <div class="modal-body" id="odvModalsectionBodyPDT"></div>
        </div>
    </div>
    <div id="odvPDTDataSelection"></div>
</div>
<!-- End Modal PDT for:supawat -->

<div id="odvAddForiteAppendDiv"></div>

<script>
    $(document).ready(function() {
        sizeControl();
        // alert('xx')
    });

    $(window).resize(function() {
        sizeControl();
    });

    function sizeControl() {
        var w = window,
            d = document,
            e = d.documentElement,
            g = d.getElementsByTagName('body')[0],
            x = w.innerWidth || e.clientWidth || g.clientWidth,
            y = w.innerHeight || e.clientHeight || g.clientHeight;

        var nNewWidth = y - 90;
        if ($('#odvContentWellcome').length > 0) { // Set height on welcome page only
            document.getElementById('odvContentWellcome').style.height = nNewWidth + 'px';
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        localStorage.setItem("SucOnSO", 1);
        var tFirstMenuName = $('.xCNBtnFirstMenu .xCNBtnMenu').attr('title');
        $('#olbTitleMenuModules').text(tFirstMenuName);

        // Set Default Save Option
        if (localStorage.getItem('tBtnSaveStaActive') == null) {
            localStorage.setItem('tBtnSaveStaActive', '1');
        }

        $('.footer').show();

        // Event Search Menu
        $("#oetMenSearch").on("keyup", function() {
            $('body').removeClass('sidenav-toggled'); //เปิด Menu ข้างๆออกมา
            if (this.value.length > 0) {
                $(".treeview").hide().filter(function() {
                    a = $(this).text().toLowerCase().indexOf($("#oetMenSearch").val().toLowerCase()) != -1;

                    return $(this).text().toLowerCase().indexOf($("#oetMenSearch").val().toLowerCase()) != -1;
                }).show();

                $(".treeview-item").hide().filter(function() {
                    b = $(this).text().toLowerCase().indexOf($("#oetMenSearch").val().toLowerCase()) != -1;

                    return $(this).text().toLowerCase().indexOf($("#oetMenSearch").val().toLowerCase()) != -1;
                }).show();
            } else {
                $(".treeview").show();
                $(".treeview-item").show();
            }

            $('.treeview').each(function(ele) {
                if ($(this).css('display') == 'none') {
                    n = $('.sidebar-scroll .xWMenuChkSpan').length;
                    if (n == 0) {
                        $('.sidebar-scroll').append('<span class="xWMenuChkSpan">ไม่พบ Menu</span>')
                    }
                } else {
                    $('.xWMenuChkSpan').remove();
                    return false;
                }
            });
        });
        // End Event Search Menu

        // Event Click Menu
        $(".xCNBtnMenu").click(function() {

            $('.xCNBtnMenu').children().removeClass('xCNBtnMenuIconActive');
            $(this).children().addClass('xCNBtnMenuIconActive');

            //ปิด brow Master เมื่อมีการกดเมนู Saharat(GolF) 25/11/2019
            $('.modal').modal('hide');

            var tMenuTitle = $(this).attr('title');
            $("#olbTitleMenuModules").text(tMenuTitle);

            var tMenu = $(this).data('menu');
            if (tMenu == 'FAV') {
                $('.xCNMenuListFAV').show();
                $('#olbTitleMenuFav').show();
            } else {

                $('.xCNMenuListFAV').hide();
                $('#olbTitleMenuFav').hide();
            }
            $('.xWOdvBtnMenu').removeClass('xWOdvBtnActive');

            $('.xCNMenuList').addClass('xCNHide');
            $('#oNavMenu' + tMenu).removeClass('xCNHide');

            if (!$('body').hasClass('layout-fullwidth')) {

            } else {
                $('body').removeClass('layout-fullwidth');
                $('body').removeClass('layout-default');
                //Add Control Menu Bar // Copter 2018-10-02
                $(".brand").addClass("xWMargin100")
                $(".main").removeClass("xWWidth100");
            }
        });
        // End Event Click Menu

        //สามารถกดปุ่ม ยืนยัน ในหน้าต่างอนุมัติได้แค่ครั้งเดียว Supawat 02-08-2020
        $(document).on('show.bs.modal', '.xCNModalApprove', function(e) {
            var oElem = $(this)[0];
            var oEventClick = $(oElem).find('button.xCNBTNPrimery');
            $(oEventClick).click(function() {
                $(oEventClick).attr('disabled', true);

                setTimeout(function() {
                    $(oEventClick).attr('disabled', false);
                }, 2000);
            });
        });

    });

    //function : Function Show Event Error
    //Parameters : Error Ajax Function 
    //Creator : 02/07/2018 wasin
    //Return : Modal Status Error
    //Return Type : view
    function JCNxResponseError(jqXHR, textStatus, errorThrown) {
        JCNxCloseLoading();
        var tHtmlError = $(jqXHR.responseText);
        var tMsgError = "";
        switch (jqXHR.status) {
            case 404:
                tMsgError += tHtmlError.find('p:nth-child(2)').text();
                break;
            case 500:
                tMsgError += tHtmlError.find('p:nth-child(3)').text();
                break;
            default:
                tMsgError += '<?php echo language('common/main/main','tSomeThingHadError'); ?>';
                break;
        }
        $("body").append(tModal);
        $('#modal-customs').attr("style", 'width: 450px; margin: 1.75rem auto;top:20%;');
        $('#odvModalError').modal({
            show: true
        });
        $('#odvModalError .modal-body').html(tMsgError);
    }
</script>
</body>

</html>