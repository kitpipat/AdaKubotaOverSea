$("document").ready(function () {
  // JSxTestPDTForSupawat();

  $("#odvModalDOCPDT").on("hidden.bs.modal", function () {
    $(".odvModalBackdropPDT").fadeOut("fast", function () {
      $(this).remove();
    });
  });
  aMulti = [];
});

//List
function JSxTestPDTForSupawat() {

  var dTime             = new Date();
  var dTimelocalStorage = dTime.getTime();
  aMulti                = [];
  $.ajax({
    type  : "POST",
    url   : "BrowseDataPDT",
    data  : {
        'Qualitysearch'   : [],
        'PriceType'       : ['Cost','tCN_Cost','Company','1'], 
        // 'PriceType'       : ['Pricesell'],                   //เลือกได้สองระดับ Cost ต้นทุน หรือ Pricesell ราคาขาย
        'ShowCountRecord' : 10,
        'NextFunc'        : 'JSxNextFunction',
        'ReturnType'	    : 'M',
        'SPL'             : ['',''], //CODE , NAME
        'BCH'             : ['',''], //CODE , NAME
        'MER'             : ['',''], //CODE , NAME
        'SHP'             : ['',''], //CODE , NAME
        //'NOTINITEM'       : [["00001","8854927003192"],["00001","ADA0000091"],["00001","ADA9999910"]],
        //'NOTINITEM'       : [['PDTCODE1','BARCODE1'],['PDTCODE2','BARCODE2'],['PDTCODE3','BARCODE3']]
        'TimeLocalstorage': dTimelocalStorage
    },
    cache   : false,
    timeout : 5000,
    success : function (tResult) {
      $("#odvModalDOCPDT").modal({ backdrop: "static", keyboard: false });
      $("#odvModalDOCPDT").modal({ show: true });

      //remove localstorage
      localStorage.removeItem("LocalItemDataPDT");
      localStorage.removeItem("LocalItemDataPDT" + dTimelocalStorage);
      $("#odvModalsectionBodyPDT").html(tResult);
    },
    error: function (data) {
      console.log(data);
    }
  });
}

//Pagenation
function JSvPDTBrowseClickPage(ptPage) {
  try {
    var nPageCurrent = "";
    var nPageNew;
    switch (ptPage) {
      case 'Fisrt': //กดหน้าแรก
          nPageCurrent 	= 1;
      break;
      case "next": //กดปุ่ม Next
        $(".xWBtnNext").addClass("disabled");
        nPageOld = $(".xWPagePrinter .active").text(); // Get เลขก่อนหน้า
        nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
        nPageCurrent = nPageNew;
        break;
      case "previous": //กดปุ่ม Previous
        nPageOld = $(".xWPagePrinter .active").text(); // Get เลขก่อนหน้า
        nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
        nPageCurrent = nPageNew;
        break;
      case 'Last': //กดหน้าสุดท้าย
          nPageCurrent 	= $('#ohdPDTEndPage').val();
      break;
      default:
        nPageCurrent = ptPage;
    }
    JSxGetPDTTable(nPageCurrent);
  } catch (err) {
    console.log("JSvSetprinterClickPage Error: ", err);
  }
}

//click กดปิด
function JCNxRemoveSelectedPDT(){
  var tTimeStorage = $("#odhTimeStorage").val();
  localStorage.removeItem("LocalItemDataPDT" + tTimeStorage);

  $('#odvPDTDataSelection').empty();
  aMulti = [];
}

//clikc ยืนยัน บนขวา
function JCNxConfirmSelectedPDT() {
  var tTimeStorage = $("#odhTimeStorage").val();
  $("#odvPDTDataSelection").empty();
  aMulti = [];
  var LocalItemDataPDT = localStorage.getItem("LocalItemDataPDT" + tTimeStorage);
  var tEleNameReturn  = $("#odhEleNamePDT").val();
  var tEleValueReturn = $("#odhEleValuePDT").val();
  var tNameNextFunc   = $("#odhEleNameNextFunc").val();

  $("div").remove("odvModalBackdropPDT");
  $("#odvModalDOCPDT").modal("hide");

  var aData       = JSON.parse(LocalItemDataPDT);
  var aNewData    = aData.sort(compare);
  var aNewReturn  = JSON.stringify(aNewData);

  localStorage.removeItem("LocalItemDataPDT" + tTimeStorage);

  $("#" + tEleNameReturn).val(aNewReturn);
  $("#" + tEleValueReturn).val(aNewReturn);

  if (tNameNextFunc != "" || tNameNextFunc != null) {
    return window[tNameNextFunc](aNewReturn);
  }
}

//sort array
function compare(a, b) {
  if (a.pnPdtCode < b.pnPdtCode) return -1;
  if (a.pnPdtCode > b.pnPdtCode) return 1;
  return 0;
}

//next funct is ready
function JSxNextFunction(elem) {
  var aData = JSON.parse(elem);
  console.log(aData);
}


// Get Data PdtConfig
// Create Witsarut 30/05/2020
function JSxAdjustPage(){
    
    var nCheckMaxPage = $('#oetMaxPage').val(); 
    var nCheckPerPage = $('#oetPerPage').val();

    $.ajax({
      type: "POST",
      url: "CallModalAddPDTConfig",
      data: { 'nCheckMaxPage' : nCheckMaxPage , 'nCheckPerPage' : nCheckPerPage},
      timeout: 0,
      cache: false,
      success: function(tViewModal){
        $('#odvModalAddPdtConfig').hide();
        JSxGetPDTTable(1);
      },
      error: function (jqXHR, textStatus, errorThrown) {
          JCNxResponseError(jqXHR,textStatus,errorThrown);
      }
    });
}