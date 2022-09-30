<script type="text/javascript">

    $('.xPAMRefInt').click(function(){
        var tBchCode    = $(this).data('bchcode');
        var tDocNo      = $(this).data('docno');
        JSxPAMCallRefIntDocDetailDataTable(tBchCode,tDocNo);
        $('.xPAMRefInt').removeClass('active');
        $(this).addClass('active');
    })

    // กดหน้า
    function JSvPAMRefIntClickPageList(ptPage){
        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld    = $('.xWPAMREFPageDataTable .active').text(); // Get เลขก่อนหน้า
                nPageNew    = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld    = $('.xWPAMREFPageDataTable .active').text(); // Get เลขก่อนหน้า
                nPageNew    = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }
        JCNxOpenLoading();
        JSxRefIntDocHDDataTable(nPageCurrent);
    }

    // ดึงรายละเอียดภายในเอกสารอ้างอิง
    function JSxPAMCallRefIntDocDetailDataTable(ptBchCode,ptDocNo){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "docPAMCallRefIntDocDetailDataTable",
            data: {
                'ptBchCode'     : ptBchCode,
                'ptDocNo'       : ptDocNo,
                'ptRefDoc'      : $("#ocbPAMRefDoc").val()
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                $('#odvPAMRefIntDocDetail').html(oResult);
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

</script>
