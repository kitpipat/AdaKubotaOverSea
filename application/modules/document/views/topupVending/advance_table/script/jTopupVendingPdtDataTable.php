<script>

    $(document).ready(function(){
        if(!bIsApvOrCancel){
            $('.xCNTopUpVendingQty').on('change keyup', function(event){
                if(event.type == "change"){
                    JSxTopUpVendingPdtDataTableEditInline(this);
                }
                if(event.keyCode == 13) {
                    JSxTopUpVendingPdtDataTableEditInline(this);
                } 
            });
        }

        if(bIsApvOrCancel){
            $('form .xCNApvOrCanCelDisabledQty').attr('disabled', true);
            $('#otbDOCPdtTable .xCNIconDel').addClass('xCNDocDisabled');
            $('#otbDOCPdtTable .xCNIconDel').removeAttr('onclick', true);
        }else{
            $('form .xCNApvOrCanCelDisabledQty').attr('disabled', false);
            $('#otbDOCPdtTable .xCNIconDel').removeClass('xCNDocDisabled');
            $('#otbDOCPdtTable .xCNIconDel').attr('onclick', 'JSxTopUpVendingPdtDataTableDeleteBySeq(this)');
        }
    });

    /**
     * Functionality : เรียกหน้าของรายการ PDT Layout
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Table List
     * Return Type : View
     */
    function JSvTopUpVendignPdtDataTableClickPage(ptPage) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWBtnNext").addClass("disabled");
                nPageOld = $(".xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSxTopUpVendingGetPdtLayoutDataTableInTmp(nPageCurrent);
    }

    /**
     * Functionality : Edit Inline PDT Layout in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTopUpVendingPdtDataTableEditInline(poElm) {
        JCNxOpenLoading();

        var nQty = $(poElm).val();
        var nStkQty = $(poElm).parents('.xCNTopUpVendingPdtLayoutRow').find('.xCNTopUpVendingPdtLayoutStkQty').text();
        var nMaxQty = $(poElm).parents('.xCNTopUpVendingPdtLayoutRow').find('.xCNTopUpVendingPdtLayoutMaxQty').text();
        var tPdtCode = $(poElm).parents('.xCNTopUpVendingPdtLayoutRow').find('.xCNTopUpVendingPdtLayoutPdtCode').text();
        var nSeqNo = $(poElm).parents('.xCNTopUpVendingPdtLayoutRow').data('seq-no');

        var nMaxRefill = nMaxQty - nStkQty;

        if (nQty <= nMaxRefill) {
            JSxTopUpVendingPdtDataTableUpdateBySeq(nQty, nSeqNo, tPdtCode);
        } else {
            JSxTopUpVendingPdtDataTableUpdateBySeq(nMaxRefill, nSeqNo, tPdtCode);
        }
    }

    /**
     * Functionality : Edit PDT Layout in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTopUpVendingPdtDataTableUpdateBySeq(pnQty, pnSeqNo, ptPdtCode) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetTopUpVendingBCHCode').val();
            var tPosCode = $('#oetTopUpVendingPosCode').val();
            var tWahCode = $('#oetTopUpVendingWahCode').val();

            $.ajax({
                type: "POST",
                url: "TopupVendingUpdatePdtLayoutInTmp",
                data: {
                    nQty: pnQty, // จำนวนที่เติม
                    nSeqNo: pnSeqNo,
                    tPdtCode: ptPdtCode, // สินค้าที่จะเติม
                    tBchCode: tBchCode, // สาขาที่จะเติม
                    tPosCode: tPosCode, // ตู้ขายสินค้าที่จะเติม
                    tWahCode: tWahCode // คลังสินค้าต้นทาง เพื่อใช้ในการเติมให้กับ คลังตู้สินค้า
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('#odvTopupVendingPdtDataTable').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxTopUpVendingGetPdtLayoutDataTableInTmp($nCurrentPage);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Delete PDT Layout in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTopUpVendingPdtDataTableDeleteBySeq(poElm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            var nSeqNo = $(poElm).parents('.xCNTopUpVendingPdtLayoutRow').data('seq-no');

            $.ajax({
                type: "POST",
                url: "TopupVendingDeletePdtLayoutInTmp",
                data: {
                    nSeqNo: nSeqNo
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('#odvTopupVendingPdtDataTable').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxTopUpVendingGetPdtLayoutDataTableInTmp($nCurrentPage);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }
</script>