<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="table-responsive">
        <table id="otbPAMDocPdtAdvTableList" class="table xWPdtTableFont">
            <thead>
                <tr class="xCNCenter">
                    <th class="text-center xCNHideWhenCancelOrApprove" >
                        <label class="fancy-checkbox">
                            <input id="ocbCheckAll" type="checkbox" class="ocbListItemAll" name="ocbCheckAll" onclick="FSxPAMSelectAll(this)">
                            <span class="">&nbsp;</span>
                        </label>
                    </th>
                    <th class="xCNTextBold"><?=language('document/productarrangement/productarrangement','tPAMTable_pdtcode')?></th>
                    <th class="xCNTextBold"><?=language('document/productarrangement/productarrangement','tPAMTable_pdtname')?></th>
                    <th class="xCNTextBold"><?=language('document/productarrangement/productarrangement','tPAMTable_qty')?></th>
                    <th class="xCNTextBold"><?=language('document/productarrangement/productarrangement','tPAMTable_barcode')?></th>
                    <th class="xCNTextBold"><?=language('document/productarrangement/productarrangement','จำนวนสั่ง')?></th>
                    <th class="xCNTextBold" style="width:13%"><?=language('document/productarrangement/productarrangement','จำนวนจัด')?></th>
                    <th class="xCNTextBold" style="width:13%"><?=language('document/productarrangement/productarrangement','หมายเหตุ')?></th>
                    <th class="xCNHideWhenCancelOrApprove"><?php echo language('common/main/main','tCMNActionDelete')?></th>
                </tr>
            </thead>
            <tbody id="odvTBodyPAMPdtAdvTableList">
                <?php
                    if($aDataDocDTTemp['rtCode'] == 1):
                        foreach($aDataDocDTTemp['raItems'] as $DataTableKey => $aDataTableVal):
                            $nKey = $aDataTableVal['FNXtdSeqNo']; ?>
                    <tr class="otr<?=$aDataTableVal['FTPdtCode'];?><?php echo $aDataTableVal['FTXtdBarCode'];?> xWPdtItem xWPdtItemList<?=$nKey?>"
                        data-alwvat="<?=$aDataTableVal['FTXtdVatType'];?>"
                        data-vat="<?=$aDataTableVal['FCXtdVatRate']?>"
                        data-key="<?=$nKey?>"
                        data-pdtcode="<?=$aDataTableVal['FTPdtCode'];?>"
                        data-pdtName="<?=$aDataTableVal['FTXtdPdtName'];?>"
                        data-seqno="<?=$nKey?>"
                        data-setprice="<?=$aDataTableVal['FCXtdSetPrice'];?>"
                        data-qty="<?=$aDataTableVal['FCXtdQty'];?>"
                        data-netafhd="<?=$aDataTableVal['FCXtdNetAfHD'];?>"
                        data-net="<?=$aDataTableVal['FCXtdNet'];?>"
                        data-stadis="<?=$aDataTableVal['FTXtdStaAlwDis'];?>"
                        data-barcode="<?=$aDataTableVal['FTXtdBarCode'];?>" >
                        <td class="otdListItem xCNHideWhenCancelOrApprove">
                            <label class="fancy-checkbox text-center">
                                <input id="ocbListItem<?=$nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" onclick="FSxPAMSelectMulDel(this)">
                                <span class="ospListItem">&nbsp;</span>
                            </label>
                        </td>
                        <td><?=$aDataTableVal['FTPdtCode'];?></td>
                        <td><?=$aDataTableVal['FTXtdPdtName'];?></td>
                        <td><?=$aDataTableVal['FTPunName'];?></td>
                        <td><?=$aDataTableVal['FTXtdBarCode'];?></td>
                        <td class="text-right"><?=str_replace(",","",number_format($aDataTableVal['FCXtdQtyOrd'],$nOptDecimalShow));?></td>
                        <td class="otdQty">
                            <div class="xWEditInLine<?=$nKey?>">
                                <input  type="text"
                                        class="xCNQty form-control xCNInputNumericWithDecimal xCNPdtEditInLine text-right xWValueEditInLine<?=$nKey?> xWShowInLine<?=$nKey?>"
                                        id="ohdQty<?=$nKey?>"
                                        name="ohdQty<?=$nKey?>"
                                        data-seq="<?=$nKey?>"
                                        data-factor="<?=str_replace(",","",number_format($aDataTableVal['FCXtdFactor'],$nOptDecimalShow));?>"
                                        data-qtyord="<?=str_replace(",","",number_format($aDataTableVal['FCXtdQtyOrd'],$nOptDecimalShow));?>"
                                        maxlength="10"
                                        value="<?=str_replace(",","",number_format($aDataTableVal['FCXtdQty'],$nOptDecimalShow));?>"
                                        autocomplete="off"
                                >
                            </div>
                        </td>
                        <td class="otdRmk">
                            <div class="xWEditInLineRmk<?=$nKey?>">
                                <input  type="text"
                                        class="xCNRmk form-control xCNPdtEditInLine text-left xWRemarkEditInLine<?=$nKey?>"
                                        id="ohdRmk<?=$nKey?>"
                                        name="ohdRmk<?=$nKey?>"
                                        data-seq="<?=$nKey?>"
                                        maxlength="200"
                                        value="<?=$aDataTableVal['FTXtdRmk']?>"
                                        autocomplete="off"
                                >
                            </div>
                        </td>
                        <td class="text-center xCNHideWhenCancelOrApprove">
                            <label class="xCNTextLink">
                                <img class="xCNIconTable" src="application/modules/common/assets/images/icons/delete.png" title="Remove" onclick="JSnPAMDelPdtInDTTempSingle(this)">
                            </label>
                        </td>
                    </tr>
            <?php
                    endforeach;
                else:
            ?>
                <tr><td class="text-center xCNTextDetail2 xCNTextNotfoundDataPdtTable" colspan="100%">กรุณาเลือกเอกสารอ้างอิงเพื่อทำการจัดสินค้า</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!--ลบสินค้าแบบตัวเดียว-->
<div id="odvModalDelDocSingle" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelSingle" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
            </div>
            <div class="modal-footer">
                <button id="osmTWIConfirmPdtDTTemp" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>

<!--ลบสินค้าแบบหลายตัว-->
<div id="odvModalDelDocMultiple" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main','tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdConfirmIDDelMultiple">
            </div>
            <div class="modal-footer">
                <button id="osmConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>

<script>

    $( document ).ready(function() {
        JSxAddScollBarInTablePdt();
        JSxEditQtyAndPrice();
        JSxPAMCountPdtItems();

        //control ปุ่ม [อนุมัติแล้ว หรือยกเลิก]
        if(tPAMStaApv == 1 || tPAMStaDoc == 3){
            // checkbox ทั้งหมด
            $('.xCNHideWhenCancelOrApprove').hide();

            // ช่องแก้ไขข้อมูล
            $('.xCNPdtEditInLine').attr('readonly',true);
        }
    });

    $( document ).on("keypress", 'form', function (e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            e.preventDefault();
            return false;
        }
    });

    // หลังจากเลือกสินค้า
    function FSvPAMNextFuncB4SelPDT(ptPdtData){
        var aPackData = JSON.parse(ptPdtData);
        for(var i=0;i<aPackData.length;i++){
            var aNewPackData = JSON.stringify(aPackData[i]);
            var aNewPackData = "["+aNewPackData+"]";
            FSvPAMAddPdtIntoDocDTTemp(aNewPackData);         // Append HMTL
            JSxPAMEventInsertToTemp(aNewPackData);           // Event Insert : server
        }
    }

    // Append PDT
    function FSvPAMAddPdtIntoDocDTTemp(ptPdtData){
        JCNxCloseLoading();
        var aPackData               = JSON.parse(ptPdtData);
        var tCheckIteminTableClass  = $('#otbPAMDocPdtAdvTableList tbody tr td').hasClass('xCNTextNotfoundDataPdtTable');
        var nPAMODecimalShow        = $('#ohdPAMODecimalShow').val();
        if(tCheckIteminTableClass==true){
            $('#otbPAMDocPdtAdvTableList tbody').html('');
            var nKey    = 1;
        }else{
            var nKey    = parseInt($('#otbPAMDocPdtAdvTableList tr:last').attr('data-seqno')) + parseInt(1);
        }

        var nLen    = aPackData.length;
        var tHTML   = '';
        for(var i=0; i<nLen; i++){

            var oData           = aPackData[i];
            var oResult         = oData.packData;
            oResult.NetAfHD     = (oResult.NetAfHD == '' || oResult.NetAfHD === undefined ? 0 : oResult.NetAfHD);
            oResult.Qty         = (oResult.Qty == '' || oResult.Qty === undefined ? 1 : oResult.Qty);
            oResult.Net         = (oResult.Net == '' || oResult.Net === undefined ? oResult.Price : oResult.Net);
            oResult.tDisChgTxt  = (oResult.tDisChgTxt == '' || oResult.tDisChgTxt === undefined ? '' : oResult.tDisChgTxt);
            var tBarCode        = oResult.Barcode;          //บาร์โค๊ด
            var tProductCode    = oResult.PDTCode;          //รหัสสินค้า
            var tProductName    = oResult.PDTName;          //ชื่อสินค้า
            var tUnitName       = oResult.PUNName;          //ชื่อหน่วยสินค้า
            var nQty            = parseInt(oResult.Qty);    //จำนวน
            var nFactor         = oResult.UnitFact;

            var tDuplicate      = $('#otbPAMDocPdtAdvTableList tbody tr').hasClass('otr'+tProductCode+tBarCode);
            var InfoOthReAddPdt = $('#ocmPAMFrmInfoOthReAddPdt').val();
            if(tDuplicate == true && InfoOthReAddPdt==1){
                //ถ้าสินค้าซ้ำ ให้เอา Qty +1
                var nValOld     = $('.otr'+tProductCode+tBarCode).find('.xCNQty').val();
                var nNewValue   = parseInt(nValOld) + parseInt(1);

                // รวมสินค้าซ้ำกรณีที่เปลี่ยนจากเลือกแบบแยกรายการเป็นบวกในรายการเดียวกัน
                var tCname = 'otr'+tProductCode+tBarCode;
                $('.'+tCname).each(function (e) {
                    if(e == '0'){
                        $(this).find('.xCNQty').val(nNewValue);
                    }
                });
            }else{//ถ้าสินค้าไม่ซ้ำ ก็บวกเพิ่มต่อเลย
                
                //จำนวน
                var oQty = '<div class="xWEditInLine'+nKey+'">';
                    oQty += '<input ';
                    oQty += 'type="text" ';
                    oQty += 'class="xCNQty form-control xCNInputNumericWithDecimal xCNPdtEditInLine text-right xWValueEditInLine'+nKey+' xWShowInLine'+nKey+' "';
                    oQty += 'id="ohdQty'+nKey+'" ';
                    oQty += 'name="ohdQty'+nKey+'" ';
                    oQty += 'data-seq='+nKey+' ';
                    oQty += 'data-factor='+nFactor+'"';
                    oQty += 'data-qtyord='+nQty+'"';
                    oQty += 'maxlength="10" ';
                    oQty += 'value="'+nQty+'"';
                    oQty += 'autocomplete="off" >';
                    oQty += '</div>';

                //หมายเหตุ
                var tRmk = '<td class="otdRmk"> ';
                    tRmk += ' <div class="xWEditInLineRmk'+nKey+'"> ';
                    tRmk += ' <input type="text"  ';
                    tRmk += ' class="xCNRmk form-control xCNPdtEditInLine text-left xWRemarkEditInLine'+nKey+'"" ';
                    tRmk += ' id="ohdRmk'+nKey+'"';
                    tRmk += ' name="ohdRmk'+nKey+'"';
                    tRmk += ' data-seq="'+nKey+'"';
                    tRmk += ' maxlength="200"  ';
                    tRmk += ' value=""  ';
                    tRmk += ' autocomplete="off"  ';
                    tRmk += ' >';
                    tRmk += ' </div> ';
                    tRmk += ' </td> ';

                tHTML += '<tr class="otr'+tProductCode+''+tBarCode+' xWPdtItem xWPdtItemList'+nKey+'"';
                tHTML += '  data-key="'+nKey+'"';
                tHTML += '  data-pdtcode="'+tProductCode+'"';
                tHTML += '  data-seqno="'+nKey+'"';
                tHTML += '  data-qty="'+nQty+'"';
                tHTML += '>';
                tHTML += '<td class="otdListItem xCNHideWhenCancelOrApprove">';
                tHTML += '  <label class="fancy-checkbox text-center">';
                tHTML += '      <input id="ocbListItem'+nKey+'" type="checkbox" class="ocbListItem" name="ocbListItem[]" onclick="FSxPAMSelectMulDel(this)">';
                tHTML += '      <span class="ospListItem">&nbsp;</span>';
                tHTML += '  </label>';
                tHTML += '</td>';
                tHTML += '<td>'+tProductCode+'</td>';
                tHTML += '<td>'+tProductName+'</td>';
                tHTML += '<td>'+tUnitName+'</td>';
                tHTML += '<td>'+tBarCode+'</td>';
                tHTML += '<td class="text-right">'+nQty+'</td>';
                tHTML += '<td class="otdQty">'+oQty+'</td>';
                tHTML += tRmk;
                tHTML += '<td nowrap class="text-center xCNHideWhenCancelOrApprove">';
                tHTML += '  <label class="xCNTextLink">';
                tHTML += '      <img class="xCNIconTable" src="application/modules/common/assets/images/icons/delete.png" title="Remove" onclick="JSnPAMDelPdtInDTTempSingle(this)">';
                tHTML += '  </label>';
                tHTML += '</td>';
                tHTML += '</tr>';
                nKey++;
            }
        }

        //สร้างตาราง
        $('#otbPAMDocPdtAdvTableList tbody').append(tHTML);

        JSxPAMCountPdtItems();
        JSxAddScollBarInTablePdt();
        JSxEditQtyAndPrice();
    }   

    // เพิ่มสินค้าตัวล่าสุด จะ hilight
    function JSxAddScollBarInTablePdt(){
        $('#otbPAMDocPdtAdvTableList >tbody >tr').css('background-color','#ffffff');
        var rowCount = $('#otbPAMDocPdtAdvTableList >tbody >tr').length;
        if(rowCount >= 2){
            $('#otbPAMDocPdtAdvTableList >tbody >tr').last().css('background-color','rgb(226, 243, 255)');
        }

        if(rowCount >= 7){
            $('.xWShowInLine' + rowCount).focus();
            $('html, body').animate({
                scrollTop: ($("#oetPAMInsertBarcode").offset().top)-80
            }, 0);
        }
    }

    //เเก้ไขจำนวน
    function JSxEditQtyAndPrice() {
        $('.xCNPdtEditInLine').click(function() {
            $(this).focus().select();
        });

        //แก้ไขจำนวน
        $('.xCNQty').off().on('change keypress', function(e) {
            if(e.type === 'change' || e.keyCode === 13){
                var nSeq                    = $(this).attr('data-seq');
                var nQty                    = parseFloat($('#ohdQty'+nSeq).val());
                var cFactor                 = $(this).attr('data-factor');
                var cQtyOrd                 = parseFloat($(this).attr('data-qtyord'));
                var tAlwQtyPickNotEqQtyOrd  = $('#ohdPAMAlwQtyPickNotEqQtyOrd').val();

                // ใบจัดสินค้าที่เกิดจากใบขาย จัดสินค้าได้ไม่เกินจำนวนใบขาย
                // if( tAlwQtyPickNotEqQtyOrd == 'false' ){ //อนุญาตจัดสินค้าไม่เท่ากับจำนวนสั่ง
                    if( nQty > cQtyOrd ){
                        $('#ohdQty'+nSeq).val(cQtyOrd);
                        JSxPAMPdtEditInline('Qty',nSeq,cQtyOrd,cFactor);
                        return;
                    }
                // }

                var nNextTab    = parseInt(nSeq)+1;
                $('.xWValueEditInLine'+nNextTab).focus().select();
                JSxPAMPdtEditInline('Qty',nSeq,nQty,cFactor);
            }
        });

        //แก้ไขหมายเหตุ
        $('.xCNRmk').off().on('change keypress', function(e) {
            if(e.type === 'change' || e.keyCode === 13){
                var nSeq        = $(this).attr('data-seq');
                var tRmk        = $('#ohdRmk'+nSeq).val();
                var nNextTab    = parseInt(nSeq)+1;
                $('.xWRemarkEditInLine'+nNextTab).focus().select();
                JSxPAMPdtEditInline('Rmk',nSeq,tRmk,0);
            }
        });

    }

    //เเก้ไขจำนวน และ ราคา
    function JSxPAMPdtEditInline(ptType,pnSeq,ptValue,pcFactor){
        if(pnSeq != undefined){
            $.ajax({
                type    : "POST",
                url     : "docPAMEditPdtInDTDocTemp",
                data    : {
                    'tPAMBchCode'   : $("#ohdPAMBchCode").val(),
                    'tPAMDocNo'     : $("#oetPAMDocNo").val(),
                    'tPAMType'      : ptType,
                    'nPAMSeqNo'     : pnSeq,
                    'tPAMValue'     : ptValue,
                    'cPAMFactor'    : pcFactor
                },
                catch   : false,
                timeout : 0,
                success : function (oResult){

                },
                error   : function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }

    //นับจำนวนรายการท้ายเอกสาร
    function JSxPAMCountPdtItems(){
        var nPdtItems = $('.xWPdtItem').length;
        $('.xShowQtyFooter').text(accounting.formatNumber(nPdtItems, 0, ','));
    }

    function FSxPAMSelectAll(){
        if($('.ocbListItemAll').is(":checked")){
            $('.ocbListItem').each(function (e) {
                if(!$(this).is(":checked")){
                    $(this).on( "click", FSxPAMSelectMulDel(this) );
                }
        });
        }else{
            $('.ocbListItem').each(function (e) {
                if($(this).is(":checked")){
                    $(this).on( "click", FSxPAMSelectMulDel(this) );
                }
        });
    }
}

</script>
