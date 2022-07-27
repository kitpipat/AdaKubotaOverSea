<script type="text/javascript">
    var tPIStaDocDoc    = $('#ohdPIStaDoc').val();
    var tPIStaApvDoc    = $('#ohdPIStaApv').val();
    var tPIStaPrcStkDoc = $('#ohdPIStaPrcStk').val();

    $(document).ready(function(){
        // ======================================================= Set Edit In Line Pdt Doc Temp =======================================================
            if((tPIStaDocDoc == 3) || (tPIStaApvDoc == 1 && tPIStaPrcStkDoc == 1)){
                $('#otbPIDocPdtAdvTableList .xCNPIBeHideMQSS').hide();
            }else{
                var oParameterEditInLine    = {
                    "DocModules"                    : "",
                    "FunctionName"                  : "JSxPISaveEditInline",
                    "DataAttribute"                 : ['data-field', 'data-seq'],
                    "TableID"                       : "otbPIDocPdtAdvTableList",
                    "NotFoundDataRowClass"          : "xWPITextNotfoundDataPdtTable",
                    "EditInLineButtonDeleteClass"   : "xWPIDeleteBtnEditButtonPdt",
                    "LabelShowDataClass"            : "xWShowInLine",
                    "DivHiddenDataEditClass"        : "xWEditInLine"
                }
                JCNxSetNewEditInline(oParameterEditInLine);

                $(".xWEditInlineElement").eq(nIndexInputEditInline).focus();
                $(".xWEditInlineElement").eq(nIndexInputEditInline).select();

                $(".xWEditInlineElement").removeAttr("disabled");


                let oElement = $(".xWEditInlineElement");
                for(let nI=0;nI<oElement.length;nI++){
                    $(oElement.eq(nI)).val($(oElement.eq(nI)).val().trim());
                }
            }
        // =============================================================================================================================================

        // ================================================ Event Click Delete Multiple PDT IN Table DT ================================================
            $('#otbPIDocPdtAdvTableList #odvTBodyPIPdtAdvTableList .ocbListItem').unbind().click(function(){
                let tPIDocNo    = $('#oetPIDocNo').val();
                let tPISeqNo    = $(this).parents('.xWPdtItem').data('seqno');
                let tPIPdtCode  = $(this).parents('.xWPdtItem').data('pdtcode');
                let tPIPunCode  = $(this).parents('.xWPdtItem').data('puncode');
                $(this).prop('checked', true);
                let oLocalItemDTTemp    = localStorage.getItem("PI_LocalItemDataDelDtTemp");
                let oDataObj            = [];
                if(oLocalItemDTTemp){
                    oDataObj    = JSON.parse(oLocalItemDTTemp);
                }
                let aArrayConvert   = [JSON.parse(localStorage.getItem("PI_LocalItemDataDelDtTemp"))];
                if(aArrayConvert == '' || aArrayConvert == null){
                    oDataObj.push({
                        'tDocNo'    : tPIDocNo,
                        'tSeqNo'    : tPISeqNo,
                        'tPdtCode'  : tPIPdtCode,
                        'tPunCode'  : tPIPunCode,
                    });
                    localStorage.setItem("PI_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
                    JSxPITextInModalDelPdtDtTemp();
                }else{
                    var aReturnRepeat   = JStPIFindObjectByKey(aArrayConvert[0],'tSeqNo',tPISeqNo);
                    if(aReturnRepeat == 'None' ){
                        //ยังไม่ถูกเลือก
                        oDataObj.push({
                            'tDocNo'    : tPIDocNo,
                            'tSeqNo'    : tPISeqNo,
                            'tPdtCode'  : tPIPdtCode,
                            'tPunCode'  : tPIPunCode,
                        });
                        localStorage.setItem("PI_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
                        JSxPITextInModalDelPdtDtTemp();
                    }else if(aReturnRepeat == 'Dupilcate'){
                        localStorage.removeItem("PI_LocalItemDataDelDtTemp");
                        $(this).prop('checked', false);
                        var nLength = aArrayConvert[0].length;
                        for($i=0; $i<nLength; $i++){
                            if(aArrayConvert[0][$i].tSeqNo == tPISeqNo){
                                delete aArrayConvert[0][$i];
                            }
                        }
                        var aNewarraydata   = [];
                        for($i=0; $i<nLength; $i++){
                            if(aArrayConvert[0][$i] != undefined){
                                aNewarraydata.push(aArrayConvert[0][$i]);
                            }
                        }
                        localStorage.setItem("PI_LocalItemDataDelDtTemp",JSON.stringify(aNewarraydata));
                        JSxPITextInModalDelPdtDtTemp();
                    }
                }
                JSxPIShowButtonDelMutiDtTemp();
            });
        // =============================================================================================================================================

        // ==================================================== Event Confirm Delete PDT IN Tabel DT ===================================================
            $('#odvPIModalDelPdtInDTTempMultiple #osmConfirmDelMultiple').unbind().click(function(){
                var nStaSession = JCNxFuncChkSessionExpired();
                if(typeof nStaSession !== "undefined" && nStaSession == 1){
                    JSnPIRemovePdtDTTempMultiple();
                }else{
                    JCNxShowMsgSessionExpired();
                }
            });
        // =============================================================================================================================================
    });

    // Functionality: ฟังก์ชั่น Save Edit In Line Pdt Doc DT Temp
    // Parameters: Behind Next Func Edit Value
    // Creator: 02/07/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: View
    // ReturnType : View
    function JSxPISaveEditInline(paParams){
        console.log('JSxPISaveEditInline: ', paParams);
        var oThisEl         = paParams['Element'];
        var tThisDisChgText = $(oThisEl).parents('tr.xWPdtItem').find('td label.xWPIDisChgDT').text().trim();
        if(tThisDisChgText == ''){
            console.log('No Have Dis/Chage DT');
            // ไม่มีลด/ชาร์จ
            var nSeqNo      = paParams.DataAttribute[1]['data-seq'];
            var tFieldName  = paParams.DataAttribute[0]['data-field'];
            var tValue      = accounting.unformat(paParams.VeluesInline);
            var bIsDelDTDis = false;
            FSvPIEditPdtIntoTableDT(nSeqNo,tFieldName,tValue,bIsDelDTDis); 
        }else{
            console.log('Have Dis/Chage DT');
            // มีลด/ชาร์จ
            $('#odvPIModalConfirmDeleteDTDis').modal({
                backdrop: 'static',
                show: true
            });
            
            $('#odvPIModalConfirmDeleteDTDis #obtPIConfirmDeleteDTDis').unbind();
            $('#odvPIModalConfirmDeleteDTDis #obtPIConfirmDeleteDTDis').one('click',function(){
                $('#odvPIModalConfirmDeleteDTDis').modal('hide');
                $('.modal-backdrop').remove();
                var nSeqNo      = paParams.DataAttribute[1]['data-seq'];
                var tFieldName  = paParams.DataAttribute[0]['data-field'];
                var tValue      = accounting.unformat(paParams.VeluesInline);
                var bIsDelDTDis = true;
                FSvPIEditPdtIntoTableDT(nSeqNo,tFieldName,tValue,bIsDelDTDis);
            });

            $('#odvPIModalConfirmDeleteDTDis #obtPICancelDeleteDTDis').unbind();
            $('#odvPIModalConfirmDeleteDTDis #obtPICancelDeleteDTDis').one('click',function(){
                $('.modal-backdrop').remove();
                JSvPILoadPdtDataTableHtml();
            });

            $('#odvPIModalConfirmDeleteDTDis').modal('show')
        }
    }

    //Functionality: Call Modal Dis/Chage Doc DT
    //Parameters: object Event Click
    //Creator: 02/07/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: View
    // ReturnType : View
    function JCNvPICallModalDisChagDT(poEl){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1) {
            var tDocNo          = $(poEl).parents('.xWPdtItem').data('docno');
            var tPdtCode        = $(poEl).parents('.xWPdtItem').data('pdtcode');
            var tPdtName        = $(poEl).parents('.xWPdtItem').data('pdtname');
            var tPunCode        = $(poEl).parents('.xWPdtItem').data('puncode');
            var tNet            = $(poEl).parents('.xWPdtItem').data('netafhd');
            var tSetPrice       = $(poEl).parents('.xWPdtItem').data('setprice');
            var tQty            = $(poEl).parents('.xWPdtItem').data('qty');
            var tStaDis         = $(poEl).parents('.xWPdtItem').data('stadis');
            var tSeqNo          = $(poEl).parents('.xWPdtItem').data('seqno');
            var bHaveDisChgDT   = $(poEl).parents('.xWPIDisChgDTForm').find('label.xWPIDisChgDT').text() == ''? false : true;
            window.DisChgDataRowDT  = {
                tDocNo          : tDocNo,
                tPdtCode        : tPdtCode,
                tPdtName        : tPdtName,
                tPunCode        : tPunCode,
                tNet            : tNet,
                tSetPrice       : tSetPrice,
                tQty            : tQty,
                tStadis         : tStaDis,
                tSeqNo          : tSeqNo,
                bHaveDisChgDT   : bHaveDisChgDT
            };
            var oPIDisChgParams = {
                DisChgType: 'disChgDT'
            };
            JSxPIOpenDisChgPanel(oPIDisChgParams);
        }else{
            JCNxShowMsgSessionExpired();
        }   
    }

    // Functionality: Pase Text Product Item In Modal Delete
    // Parameters: Event Click List Table Delete Mutiple
    // Creator: 26/07/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    function JSxPITextInModalDelPdtDtTemp(){
        var aArrayConvert   = [JSON.parse(localStorage.getItem("PI_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == ""){
        }else{
            var tPITextDocNo   = "";
            var tPITextSeqNo   = "";
            var tPITextPdtCode = "";
            var tPITextPunCode = "";
            $.each(aArrayConvert[0],function(nKey,aValue){
                tPITextDocNo    += aValue.tDocNo;
                tPITextDocNo    += " , ";

                tPITextSeqNo    += aValue.tSeqNo;
                tPITextSeqNo    += " , ";

                tPITextPdtCode  += aValue.tPdtCode;
                tPITextPdtCode  += " , ";

                tPITextPunCode  += aValue.tPunCode;
                tPITextPunCode  += " , ";
            });
            $('#odvPIModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').text($('#oetTextComfirmDeleteMulti').val());
            $('#odvPIModalDelPdtInDTTempMultiple #ohdConfirmPIDocNoDelete').val(tPITextDocNo);
            $('#odvPIModalDelPdtInDTTempMultiple #ohdConfirmPISeqNoDelete').val(tPITextSeqNo);
            $('#odvPIModalDelPdtInDTTempMultiple #ohdConfirmPIPdtCodeDelete').val(tPITextPdtCode);
            $('#odvPIModalDelPdtInDTTempMultiple #ohdConfirmPIPunCodeDelete').val(tPITextPunCode);
        }
    }

    // Functionality: Show Button Delete Multiple DT Temp
    // Parameters: Event Click List Table Delete Mutiple
    // Creator: 26/07/2019 Wasin(Yoshi)
    // Return: -
    // ReturnType: -
    function JSxPIShowButtonDelMutiDtTemp(){
        var aArrayConvert = [JSON.parse(localStorage.getItem("PI_LocalItemDataDelDtTemp"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == ""){
            $("#odvPIMngDelPdtInTableDT #oliPIBtnDeleteMulti").addClass("disabled");
        }else{
            var nNumOfArr   = aArrayConvert[0].length;
            if(nNumOfArr > 1) {
                $("#odvPIMngDelPdtInTableDT #oliPIBtnDeleteMulti").removeClass("disabled");
            }else{
                $("#odvPIMngDelPdtInTableDT #oliPIBtnDeleteMulti").addClass("disabled");
            }
        }
    }

    //Functionality: Function Delete Product In Doc DT Temp
    //Parameters: object Event Click
    //Creator: 04/07/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: View
    // ReturnType : View
    function JSnPIDelPdtInDTTempSingle(poEl) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var tVal    = $(poEl).parents("tr.xWPdtItem").attr("data-pdtcode");
            var tSeqno  = $(poEl).parents("tr.xWPdtItem").attr("data-seqno");
            $(poEl).parents("tr.xWPdtItem").remove();
            JSnPIRemovePdtDTTempSingle(tSeqno, tVal);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    // Functionality: Function Remove Product In Doc DT Temp
    // Parameters: Event Btn Click Call Edit Document
    // Creator: 04/07/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: Status Add/Update Document
    // ReturnType: object
    function JSnPIRemovePdtDTTempSingle(ptSeqNo,ptPdtCode){
        var tPIDocNo        = $("#oetPIDocNo").val();
        var tPIBchCode      = $('#oetPIFrmBchCode').val();
        var tPIVatInOrEx    = $('#ocmPIFrmSplInfoVatInOrEx').val();
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "dcmPIRemovePdtInDTTmp",
            data: {
                'tBchCode'      : tPIBchCode,
                'tDocNo'        : tPIDocNo,
                'nSeqNo'        : ptSeqNo,
                'tPdtCode'      : ptPdtCode,
                'tVatInOrEx'    : tPIVatInOrEx,
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    JSvPILoadPdtDataTableHtml();
                    JCNxLayoutControll();
                }else{
                    var tMessageError   = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    
    //Functionality: Remove Comma
    //Parameters: Event Button Delete All
    //Creator: 26/07/2019 Wasin
    //Return:  object Status Delete
    //Return Type: object
    function JSoPIRemoveCommaData(paData){
        var aTexts              = paData.substring(0, paData.length - 2);
        var aDataSplit          = aTexts.split(" , ");
        var aDataSplitlength    = aDataSplit.length;
        var aNewDataDeleteComma = [];

        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewDataDeleteComma.push(aDataSplit[$i]);
        }
        return aNewDataDeleteComma;
    }

    // Functionality: Fucntion Call Delete Multiple Doc DT Temp
    // Parameters: Event Click List Table Delete Mutiple
    // Creator: 26/07/2019 Wasin(Yoshi)
    // Return: array Data Status Delete
    // ReturnType: Array
    function JSnPIRemovePdtDTTempMultiple(){
        JCNxOpenLoading();
        var tPIDocNo        = $("#oetPIDocNo").val();
        var tPIBchCode      = $('#oetPIFrmBchCode').val();
        var tPIVatInOrEx    = $('#ocmPIFrmSplInfoVatInOrEx').val();
        var aDataPdtCode    = JSoPIRemoveCommaData($('#odvPIModalDelPdtInDTTempMultiple #ohdConfirmPIPdtCodeDelete').val());
        var aDataPunCode    = JSoPIRemoveCommaData($('#odvPIModalDelPdtInDTTempMultiple #ohdConfirmPIPunCodeDelete').val());
        var aDataSeqNo      = JSoPIRemoveCommaData($('#odvPIModalDelPdtInDTTempMultiple #ohdConfirmPISeqNoDelete').val());
        $.ajax({
            type: "POST",
            url: "dcmPIRemovePdtInDTTmpMulti",
            data: {
                'ptPIBchCode'   : tPIBchCode,
                'ptPIDocNo'     : tPIDocNo,
                'ptPIVatInOrEx' : tPIVatInOrEx,
                'paDataPdtCode' : aDataPdtCode,
                'paDataPunCode' : aDataPunCode,
                'paDataSeqNo'   : aDataSeqNo,
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    $('#odvPIModalDelPdtInDTTempMultiple').modal('hide');
                    $('#odvPIModalDelPdtInDTTempMultiple #ospTextConfirmDelMultiple').empty();
                    localStorage.removeItem('PI_LocalItemDataDelDtTemp');
                    $('#odvPIModalDelPdtInDTTempMultiple #ohdConfirmPIDocNoDelete').val('');
                    $('#odvPIModalDelPdtInDTTempMultiple #ohdConfirmPISeqNoDelete').val('');
                    $('#odvPIModalDelPdtInDTTempMultiple #ohdConfirmPIPdtCodeDelete').val('');
                    $('#odvPIModalDelPdtInDTTempMultiple #ohdConfirmPIPunCodeDelete').val('');
                    setTimeout(function(){
                        $('.modal-backdrop').remove();
                        JSvPILoadPdtDataTableHtml();
                        JCNxLayoutControll();
                    }, 500);
                }else{
                    var tMessageError   = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
                }
            },  
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    







</script>