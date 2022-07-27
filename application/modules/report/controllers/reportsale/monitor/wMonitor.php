<div class="odvContentPage" id="odvContentPage">

<div id="odvAuditMainMenu" class="main-menu">
  <input type="hidden" name="oetSpcAgncyCode" id="oetSpcAgncyCode" value="">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNDepositVMaster">
                <div class="col-xs-12 col-md-6">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <li style="cursor:pointer;" ><img id="oimImgFavicon" style="cursor:pointer; margin-top: -10px;" width="20px;" height="20px;" src="<?php echo base_url();?>application/modules/common/assets/images/icons/favorit.png" class="xCNDisabled xWImgDisable"></li>
                        <li id="oliAuditTitle" class="xCNLinkClick" onclick="JSxMonitorDefult()"><?= language('monitor/monitor/monitor','tMONTitle')?></li>
                        <input type="hidden" id="oetSesUsrLevel" value="<?php echo $this->session->userdata('tSesUsrLevel'); ?>">
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                      <button class="btn xCNBTNDefult xCNBTNDefult2Btn" id="obtAUDback" onclick="JSxMonitorDefultHeader();"  type="button"><?= language('monitor/monitor/monitor','tMONBtnBack')?></button>
                      <button class="btn xCNBTNDefult xCNBTNDefult2Btn" id="obtAUDExport" onclick="JSxMonitorDefult();"  type="button"><?= language('monitor/monitor/monitor','tMONBtnExport')?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="main-content" id="odvContent">
  <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmMONSearchData">
    <div id="odvContentPageMON"  class="panel panel-headline">
      <div class="panel-heading">
        <div class="row">
              <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                  <div class="form-group">
                      <label class="xCNLabelFrm"><?= language('monitor/monitor/monitor','tMONlabelSplFrom')?></label>
                      <div class="input-group">
                          <input type="text" class="form-control xCNHide xWRptAllInput" id="oetMONSupplierCodeFrom" name="oetMONSupplierCodeFrom" maxlength="5">
                          <input type="text" class="form-control xWPointerEventNone xWRptAllInput xCNInputNewUI" id="oetMONSupplierNameFrom" name="oetMONSupplierNameFrom" readonly="">
                          <span class="input-group-btn">
                              <button id="obtMONBrowseSupplierFrom" type="button" class="btn xCNBtnBrowseAddOn">
                                  <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                              </button>
                          </span>
                      </div>
                  </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                  <div class="form-group">
                      <label class="xCNLabelFrm"><?= language('monitor/monitor/monitor','tMONlabelSplTo')?></label>
                      <div class="input-group">
                          <input type="text" class="form-control xCNHide xWRptAllInput" id="oetMONSupplierCodeTo" name="oetMONSupplierCodeTo" maxlength="5">
                          <input type="text" class="form-control xWPointerEventNone xWRptAllInput xCNInputNewUI" id="oetMONSupplierNameTo" name="oetMONSupplierNameTo" readonly="">
                          <span class="input-group-btn">
                              <button id="obtMONBrowseSupplierTo" type="button" class="btn xCNBtnBrowseAddOn">
                                  <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                              </button>
                          </span>
                      </div>
                  </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                  <div class="form-group">
                      <label class="xCNLabelFrm"><?= language('monitor/monitor/monitor','tMONlabelSplGrp')?></label>
                      <div class="input-group">
                          <input type="text" class="form-control xCNHide xWRptAllInput" id="oetMONSupplierCodeGroup" name="oetMONSupplierCodeGroup" maxlength="5">
                          <input type="text" class="form-control xWPointerEventNone xWRptAllInput xCNInputNewUI" id="oetMONSupplierNameGroup" name="oetMONSupplierNameGroup" readonly="">
                          <span class="input-group-btn">
                              <button id="obtMONBrowseSupplierGroup" type="button" class="btn xCNBtnBrowseAddOn">
                                  <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                              </button>
                          </span>
                      </div>
                  </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                  <div class="form-group">
                      <label class="xCNLabelFrm"><?= language('monitor/monitor/monitor','tMONlabelSplTyp')?></label>
                      <div class="input-group">
                          <input type="text" class="form-control xCNHide xWRptAllInput" id="oetMONSupplierCodeType" name="oetMONSupplierCodeType" maxlength="5">
                          <input type="text" class="form-control xWPointerEventNone xWRptAllInput xCNInputNewUI" id="oetMONSupplierNameType" name="oetMONSupplierNameType" readonly="">
                          <span class="input-group-btn">
                              <button id="obtMONBrowseSupplierType" type="button" class="btn xCNBtnBrowseAddOn">
                                  <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                              </button>
                          </span>
                      </div>
                  </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                  <div class="form-group">
                      <label class="xCNLabelFrm"><?= language('monitor/monitor/monitor','tMONlabelSplClass')?></label>
                      <div class="input-group">
                          <input type="text" class="form-control xCNHide xWRptAllInput" id="oetMONSupplierCodeClass" name="oetMONSupplierCodeClass" maxlength="5">
                          <input type="text" class="form-control xWPointerEventNone xWRptAllInput xCNInputNewUI" id="oetMONSupplierNameClass" name="oetMONSupplierNameClass" readonly="">
                          <span class="input-group-btn">
                              <button id="obtMONBrowseSupplierClass" type="button" class="btn xCNBtnBrowseAddOn">
                                  <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                              </button>
                          </span>
                      </div>
                  </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                  <div class="form-group">
                      <label class="xCNLabelFrm"><?= language('monitor/monitor/monitor','tMONlabelClassDeldate')?></label>
                      <select class="selectpicker form-control" name="ocmMONClass" id="ocmMONClass">
                        <option class="xWPdtForSystem2" value="A"><?= language('monitor/monitor/monitor','tMONlabelClassAll')?></option>
                        <?php
                              foreach ($aDataList['aItems'] as $nKey => $aValue) {
                                $tOptionval = $aValue['FTOdlType']."_".$aValue['FNOdlMin']."_".$aValue['FNOdlMax'];
                                switch ($aValue['FTOdlType']) {
                                    case "1":
                                        $aValue['FTOdlType'] = language('service/overduel/overduel','tOdloption1');
                                        $tTO =" - ";
                                break;
                                    case "2":
                                        $aValue['FTOdlType'] = language('service/overduel/overduel','tOdloption2');
                                        $tTO ="";
                                break;
                              } ?>
                              <option  value="<?php echo $tOptionval; ?>"><?= $aValue['FTOdlType'] ?> <?php echo $aValue['FNOdlMin']; ?><?php echo   $tTO; ?><?php echo $aValue['FNOdlMax']; ?> วัน</option><?php
                              }
                         ?>
                      </select>
                  </div>
              </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('monitor/monitor/monitor','tMONlabelDeldateFrom')?></label>
                    <div class="input-group">
                      <input type="text" class="form-control xControlForm xCNDatePicker xCNInputMaskDate" id="oetMONRefBilDocDateFrom" name="oetMONRefBilDocDateFrom" value="" placeholder="YYYY-MM-DD" maxlength="10">
                      <span class="input-group-btn">
                        <button id="obtMONBrowseRefBilDocDateFrom" name="obtMONBrowseRefBilDocDateFrom" type="button" class="btn xCNDatePicker xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                      </span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('monitor/monitor/monitor','tMONlabelDeldateTo')?></label>
                    <div class="input-group">
                      <input type="text" class="form-control xControlForm xCNDatePicker xCNInputMaskDate" id="oetMONRefBilDocDateTo" name="oetMONRefBilDocDateTo" value="" placeholder="YYYY-MM-DD" maxlength="10">
                      <span class="input-group-btn">
                        <button id="obtMONBrowseRefBilDocDateTo" name="obtMONBrowseRefBilDocDateTo" type="button" class="btn xCNDatePicker xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                      </span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('monitor/monitor/monitor','tMONlabelFromDeldate')?></label>
                    <div class="input-group">
                      <input type="text" class="form-control xControlForm xCNDatePicker xCNInputMaskDate" id="oetMONRefDealDateFrom" name="oetMONRefDealDateFrom" value="" placeholder="YYYY-MM-DD" maxlength="10">
                      <span class="input-group-btn">
                        <button id="obtMONBrowseRefDealDateFrom" name="obtMONBrowseRefDealDateFrom" type="button" class="btn xCNDatePicker xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                      </span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('monitor/monitor/monitor','tMONlabelToDeldate')?></label>
                    <div class="input-group">

                      <input type="text" class="form-control xControlForm xCNDatePicker xCNInputMaskDate" id="oetMONRefDealDateTo" name="oetMONRefDealDateTo" value="" placeholder="YYYY-MM-DD" maxlength="10">
                      <span class="input-group-btn">
                        <button id="obtMONBrowseRefDealDateTo" name="obtMONBrowseRefDealDateTo" type="button" class="btn xCNDatePicker xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                      </span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
              <div class="form-group">
                <label class="xCNLabelFrm"></label>
                <div class="input-group">
                  <a id="oahADCAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;"><?= language('monitor/monitor/monitor','tMONlabelClear')?></a>
                  &nbsp;
                  <a id="oahADCSearchReset" class="btn xCNBTNPrimery  xCNBTNDefult1Btn" href="javascript:;" onclick="JSxMONSearchData()"><?= language('monitor/monitor/monitor','tMONlabelSearch')?></a>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive" id="otbMONDataListSupl">

            </div>
          </div>
        </div>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive" id="otbMONDataListSuplDetail">

            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

</div>

</div>
<script src="<?php echo base_url('application/modules/monitor/assets/src/monitor/jMonitor.js'); ?>"></script>
<script type="text/javascript">
  $('document').ready(function(){
      $('.selectpicker').selectpicker();

      $('.xCNDatePicker').datepicker({
          format: "yyyy-mm-dd",
          todayHighlight: true,
          enableOnReadonly: false,
          disableTouchKeyboard : true,
          autoclose: true
      });
      JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
      JSxMonitorDefult();
  });
  $("#oahADCAdvanceSearch").click(function(event) {
      $('#oetMONRefBilDocDateFrom').val('');
      $('#oetMONRefBilDocDateTo').val('');
      $('#oetMONRefDealDateFrom').val('');
      $('#oetMONRefDealDateTo').val('');
      $("#oetMONSupplierCodeFrom").val("");
      $("#oetMONSupplierNameFrom").val("");
      $("#oetMONSupplierCodeTo").val("");
      $("#oetMONSupplierNameTo").val("");
      $("#oetMONSupplierCodeGroup").val("");
      $("#oetMONSupplierNameGroup").val("");
      $("#oetMONSupplierCodeType").val("");
      $("#oetMONSupplierNameType").val("");
      $("#oetMONSupplierCodeClass").val("");
      $("#oetMONSupplierNameClass").val("");
      $("#ocmMONClass").val("A");
      $('.selectpicker').selectpicker('refresh');
  });
  $('#obtMONBrowseRefBilDocDateFrom').click(function(event){
      $('.xCNDatePicker').datepicker("hide");
      $('#oetMONRefBilDocDateFrom').datepicker('show');
  });
  $('#obtMONBrowseRefBilDocDateTo').click(function(event){
      $('.xCNDatePicker').datepicker("hide");
      $('#oetMONRefBilDocDateTo').datepicker('show');
  });
  $('#obtMONBrowseRefDealDateFrom').click(function(event){
      $('.xCNDatePicker').datepicker("hide");
      $('#oetMONRefDealDateFrom').datepicker('show');
  });
  $('#obtMONBrowseRefDealDateTo').click(function(event){
      $('.xCNDatePicker').datepicker("hide");
      $('#oetMONRefDealDateTo').datepicker('show');
  });
  function JSxMONSearchData() {
     var nStaSession = JCNxFuncChkSessionExpired();
     JCNxOpenLoading();
     if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
       $.ajax({
           type: "POST",
           url: "monListSearchData",
           data: $('#ofmMONSearchData').serialize(),
           cache: false,
           timeout: 0,
           success: function(wResult){
               $("#otbMONDataListSuplDetail").html("");
               $("#otbMONDataListSupl").html(wResult);
               JCNxCloseLoading();
           },
           error: function(jqXHR, textStatus, errorThrown) {
               JCNxResponseError(jqXHR, textStatus, errorThrown);
           }
       });
     }
  }
  function JSxMonitorDefultHeader() {
    var nStaSession = JCNxFuncChkSessionExpired();
    JCNxOpenLoading();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
      $.ajax({
          type: "POST",
          url: "monSPL/0/0",
          cache: false,
          timeout: 0,
          success: function(wResult){

              JCNxCloseLoading();
              $('#odvContentPage').html(wResult);

              //JSxMonitorDefult();
          },
          error: function(jqXHR, textStatus, errorThrown) {
              JCNxResponseError(jqXHR, textStatus, errorThrown);
          }
      });
    }
  }
  function JSxMonitorDefult() {
    var nStaSession = JCNxFuncChkSessionExpired();
    JCNxOpenLoading();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
      $.ajax({
          type: "POST",
          url: "monList",
          cache: false,
          timeout: 0,
          success: function(wResult){
              $('#oliAuditTitle').html("ตรวจสอบเจ้าหนี้ค้างจ่าย");
              $("#otbMONDataListSuplDetail").html("");
              $("#otbMONDataListSupl").html(wResult);
              JCNxCloseLoading();
              $('#obtAUDback').hide();
              $('#obtAUDExport').show();
          },
          error: function(jqXHR, textStatus, errorThrown) {
              JCNxResponseError(jqXHR, textStatus, errorThrown);
          }
      });
    }
  }
  function JSxMONListDetail(ptSplCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    JCNxOpenLoading();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
      $.ajax({
          type: "POST",
          url: "monListSuplDetail",
          data: {
            "ocmMONClass":$("#ocmMONClass").val(),
            "oetMONRefBilDocDateFrom":$("#oetMONRefBilDocDateFrom").val(),
            "oetMONRefBilDocDateTo":$("#oetMONRefBilDocDateTo").val(),
            "oetMONRefDealDateFrom":$("#oetMONRefDealDateFrom").val(),
            "oetMONRefDealDateTo":$("#oetMONRefDealDateTo").val(),
            "oetMONSupplierCodeFrom":$("#oetMONSupplierCodeFrom").val(),
            "oetMONSupplierCodeTo":$("#oetMONSupplierCodeTo").val(),
            "oetMONSupplierCodeGroup":$("#oetMONSupplierCodeGroup").val(),
            "oetMONSupplierCodeType":$("#oetMONSupplierCodeType").val(),
            "oetMONSupplierCodeClass":$("#oetMONSupplierCodeClass").val(),
            "ptSplCode":ptSplCode
          },
          cache: false,
          timeout: 0,
          success: function(wResult){
              $("#otbMONDataListSuplDetail").html(wResult);
              JCNxCloseLoading();
          },
          error: function(jqXHR, textStatus, errorThrown) {
              JCNxResponseError(jqXHR, textStatus, errorThrown);
          }
      });
    }
  }

  function JSvIVCallPageEdit(ptDocumentNumber){
      var nStaSession = JCNxFuncChkSessionExpired();
      if(typeof nStaSession !== "undefined" && nStaSession == 1) {
          JCNxOpenLoading();
          $.ajax({
              type    : "POST",
              url     : "docInvoicePageEdit",
              data    : {'ptIVDocNo' : ptDocumentNumber},
              cache   : false,
              timeout : 0,
              success: function(tResult){
                  var aReturnData = JSON.parse(tResult);
                  if(aReturnData['nStaEvent'] == '1'){
                      JSxIVNavDefult('showpage_edit');
                      $('#odvContent').html(aReturnData['tViewPageAdd']);
                      $('#oliAuditTitle').html("ใบซื้อสินค้า");
                      JCNxCloseLoading();
                      $('#obtAUDback').show();
                      $('#obtAUDExport').hide()
                      //โหลดสินค้าใน Temp
                      JSvIVLoadPdtDataTableHtml();

                      //เช็คว่าเอกสารยกเลิก หรือเอกสารอนุมัติ
                      JSxIVControlFormWhenCancelOrApprove();
                  }else{
                      var tMessageError   = aReturnData['tStaMessg'];
                      FSvCMNSetMsgErrorDialog(tMessageError);
                      JCNxCloseLoading();
                  }
              },
              error: function (jqXHR, textStatus, errorThrown){
                  JCNxResponseError(jqXHR, textStatus, errorThrown);
              }
          });
      }else{
          JCNxShowMsgSessionExpired();
      }
  }
  function JSxIVNavDefult(ptType) {
      if(ptType == 'showpage_list'){
          $("#oliIVTitleAdd").hide();
          $("#oliIVTitleEdit").hide();
          $("#odvBtnAddEdit").hide();
          $('#odvBtnIVPageAddorEdit').show();
      }else if(ptType == 'showpage_add'){
          $("#oliIVTitleAdd").show();
          $("#oliIVTitleEdit").hide();
          $("#odvBtnAddEdit").show();
          $('#odvBtnIVPageAddorEdit').hide();

          $('#obtIVApproveDoc').hide();
          $('#obtIVPrintDoc').hide();
          $('#obtIVCancelDoc').hide();
          $('.xCNBTNSaveDoc').show();
      }else if(ptType == 'showpage_edit'){
          $("#oliIVTitleAdd").hide();
          $("#oliIVTitleEdit").show();

          $("#odvBtnAddEdit").show();
          $('#odvBtnIVPageAddorEdit').hide();
          $('#obtIVApproveDoc').show();
          $('#obtIVPrintDoc').show();
          $('#obtIVCancelDoc').show();
          $('.xCNBTNSaveDoc').show();
      }

      //ล้างค่า
      localStorage.removeItem('IV_LocalItemDataDelDtTemp');
      localStorage.removeItem('LocalItemData');
  }
  //สินค้าใน DT
  function JSvIVLoadPdtDataTableHtml(pnPage){
      var nStaSession = JCNxFuncChkSessionExpired();
      if(typeof nStaSession !== "undefined" && nStaSession == 1){
          if($("#ohdIVRoute").val() == "docInvoiceEventAdd"){
              var tIVDocNo    = "";
          }else{
              var tIVDocNo    = $("#oetIVDocNo").val();
          }

          var tIVStaApv       = $("#ohdIVStaApv").val();
          var tIVStaDoc       = $("#ohdIVStaDoc").val();
          var tIVVATInOrEx    = $("#ocmIVfoVatInOrEx").val();

          if(pnPage == '' || pnPage == null){
              var pnNewPage = 1;
          }else{
              var pnNewPage = pnPage;
          }
          var nPageCurrent  = pnNewPage;

          $.ajax({
              type    : "POST",
              url     : "docInvoiceTableDTTemp",
              data    : {
                  'tBCHCode'              : $('#ohdIVBchCode').val(),
                  'ptIVDocNo'             : tIVDocNo,
                  'ptIVStaApv'            : tIVStaApv,
                  'ptIVStaDoc'            : tIVStaDoc,
                  'ptIVVATInOrEx'         : tIVVATInOrEx,
              },
              cache: false,
              Timeout: 0,
              success: function (oResult){
                  var aReturnData = JSON.parse(oResult);
                  if(aReturnData['nStaEvent'] == '1') {
                      $('#odvIVDataPdtTableDTTemp').html(aReturnData['tIVPdtAdvTableHtml']);
                      var aIVEndOfBill = aReturnData['aIVEndOfBill'];
                      JSxIVSetFooterEndOfBill(aIVEndOfBill);
                      JCNxCloseLoading();
                  }else{
                      var tMessageError = aReturnData['tStaMessg'];
                      FSvCMNSetMsgErrorDialog(tMessageError);
                      JCNxCloseLoading();
                  }
              },
              error: function (jqXHR, textStatus, errorThrown) {
                  JCNxResponseError(jqXHR, textStatus, errorThrown);
              }
          });
      }else{
          JCNxShowMsgSessionExpired();
      }
  }
  //Control ปุ่ม และอินพุตต่างๆ [เอกสารยกเลิก / เอกสารอนุมัติ]
  function JSxIVControlFormWhenCancelOrApprove(){
      var tStatusDoc = $('#ohdIVStaDoc').val();
      var tStatusApv = $('#ohdIVStaApv').val();

      //control ฟอร์ม
      if(tStatusDoc == 3 || (tStatusDoc == 1 && tStatusApv == 1)){ //เอกสารยกเลิก
          //ปุ่มเลือก
          $('.xCNBtnBrowseAddOn').addClass('disabled');
          $('.xCNBtnBrowseAddOn').attr('disabled',true);

          //ปุ่มเวลา
          $('.xCNBtnDateTime').addClass('disabled');
          $('.xCNBtnDateTime').attr('disabled',true);

          //อินพุต
          $('.form-control').attr('readonly', true);

          //เพิ่มข้อมูลสินค้า
          $('.xCNHideWhenCancelOrApprove').hide();

          //พวก selectpicker
          $('.selectpicker').prop("disabled",true)
      }

      //control ปุ่ม
      if(tStatusDoc == 3 ){ //เอกสารยกเลิก
          //ปุ่มยกเลิก
          $('#obtIVCancelDoc').hide();

          //ปุ่มอนุมัติ
          $('#obtIVApproveDoc').hide();

          //ปุ่มบันทึก
          $('.xCNBTNSaveDoc').hide();
      }else if(tStatusDoc == 1 && tStatusApv == 1){ //เอกสารอนุมัติแล้ว
          //ปุ่มยกเลิก
          $('#obtIVCancelDoc').hide();

          //ปุ่มอนุมัติ
          $('#obtIVApproveDoc').hide();

          //ปุ่มบันทึก
          $('.xCNBTNSaveDoc').show();

          //สามารถกรอกหมายเหตุได้
          $('#otaIVRemark').attr('readonly', false);
      }
  }
</script>
