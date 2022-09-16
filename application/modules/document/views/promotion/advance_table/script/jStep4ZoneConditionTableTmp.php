<script>

    $(document).ready(function(){

        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        if(bIsApvOrCancel){
            $('form .xCNApvOrCanCelDisabledPdtPmtHDZone').attr('disabled', true);
            $('#otbPromotionStep4ZoneConditionTable .xCNIconDel').addClass('xCNDocDisabled');
            $('#otbPromotionStep4ZoneConditionTable .xCNIconDel').removeAttr('onclick', true);
        }else{
            $('form .xCNApvOrCanCelDisabledPdtPmtHDZone').attr('disabled', false);
            $('#otbPromotionStep4ZoneConditionTable .xCNIconDel').removeClass('xCNDocDisabled');
            $('#otbPromotionStep4ZoneConditionTable .xCNIconDel').attr('onclick', 'JSxPromotionStep4ZoneConditionDataTableDeleteByKey(this)');
        }

        // Check All Control
        $('.xCNListItemAll').on('click', function(){
            var bIsCheckedAll = $(this).is(':checked');
            // console.log('bIsCheckedAll: ', bIsCheckedAll);
            if(bIsCheckedAll){
                $('.xCNPromotionPdtPmtHDZoneRow .xCNListItem').prop('checked', true);
            }else{
                $('.xCNPromotionPdtPmtHDZoneRow .xCNListItem').prop('checked', false);     
            }
        });

    });

    /**
     * Functionality : เรียกหน้าของรายการ PdtPmtHDChn in Temp
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Return : Table List
     * Return Type : View
     */
    function JSvPromotionStep4PriceGroupConditionDataTableClickPage(ptPage) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xCNPromotionPdtPmtHDChnPage .xWBtnNext").addClass("disabled");
                nPageOld = $(".xCNPromotionPdtPmtHDChnPriPage .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xCNPromotionPdtPmtHDChnPage .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSxPromotionStep4GetHDZoneInTmp(nPageCurrent, true);
    }

    /**
     * Functionality : Update PdtPmtHDChn in Temp by Primary Key
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep4ZoneConditionDataTableEditInline(poElm){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var tBchCode = $(poElm).parents('.xCNPromotionPdtPmtHDZoneRow').data('bch-code');
            var tDocNo = $(poElm).parents('.xCNPromotionPdtPmtHDZoneRow').data('doc-no');
            var tChnCode = $(poElm).parents('.xCNPromotionPdtPmtHDZoneRow').data('chn-code');
            var tZneCode = $(poElm).parents('.xCNPromotionPdtPmtHDZoneRow').data('znechi-code');
            var tPmhStaType = $(poElm).val();

            $.ajax({
                type: "POST",
                url: "promotionStepeUpdateZoneConditionInTmp",
                data: {
                    tDocNo: tDocNo,
                    tBchCode: tBchCode,
                    tChnCode: tChnCode,
                    tZneCode: tZneCode,
                    tPmhStaType: tPmhStaType
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('.xCNPromotionPmtBrandDtPage').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxPromotionStep4GetHDZoneInTmp($nCurrentPage, false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCloseLoading();
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Delete PdtPmtHDCstPri in Temp by Primary Key
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep4ZoneConditionDataTableDeleteByKey(poElm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();
            var tBchCode = $(poElm).parents('.xCNPromotionPdtPmtHDZoneRow').data('bch-code');
            var tDocNo = $(poElm).parents('.xCNPromotionPdtPmtHDZoneRow').data('doc-no');
            var tChnCode = $(poElm).parents('.xCNPromotionPdtPmtHDZoneRow').data('chn-code');
            var tZneCode = $(poElm).parents('.xCNPromotionPdtPmtHDZoneRow').data('znechi-code');


            $.ajax({
                type: "POST",
                url: "promotionStep4DeleteZoneConditionInTmp",
                data: {
                    tDocNo: tDocNo,
                    tBchCode: tBchCode,
                    tChnCode: tChnCode,
                    tZneCode: tZneCode,
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('.xCNPromotionPdtPmtHDChnPage').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxPromotionStep4GetHDZoneInTmp($nCurrentPage, true);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                    JCNxCloseLoading();
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }
</script>