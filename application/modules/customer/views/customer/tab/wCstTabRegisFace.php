<style>

    .wCNInnerPDT{
        width           : 90%;
        height          : 90%;
        border-radius   : 2px;
        top             : 5%;
        left            : 5%;
        background      : #D8D8D8 ;
        position        : absolute;
    }

    .wCNOuterPDT{
        border-radius   : 2px;
        width           : 200px !important;
        height          : 200px !important;
        border          : 2px solid #D8D8D8 ;
        background      : #FFF;
        margin          : 4px;
        position        : relative;
        display         : inline-block;
    }

    .wCNOuterPDT:hover{
        border-color    : #0081c2;
    }

    .wCNOuterPDT:hover .wCNInnerPDT{
        background      : #0081c2; 
        cursor          : pointer;
    }

    .wCNFontInsertPDT{
        display         : block;
        margin          : 16% 20%;
        text-align      : center;
        font-size       : 4.5rem !important;
    }

    .wCNOuterPDT:hover .wCNFontInsertPDT{
        color           : #FFF;
    }

    .xCNBtnDelete{
        background-color: #f36767;
        border-radius   : 50px;
        width           : 20px;
        height          : 20px;
        position        : absolute;
        z-index         : 99;
        right           : -10px;
        top             : -10px;
        display         : none;
        color           : #FFF;
        border          : 1px solid #f17575;
        box-shadow      : 2px 2px 3px 0px rgb(173, 173, 173);
    }

    .xCNBtnDeleteShow{
        display         : block;
        cursor          : pointer;
    }

    .xCNFontBtnDelete{
        text-align      : center;
        display         : block;
        font-size       : 0.8rem !important;
        font-weight     : bold;
    }

</style>

<!--เนื้อหา-->
<div id="odvTabRegisFace" class="tab-pane fade" style="width: 100%;"></div>

<!--กรณีรูปภาพไม่สำเร็จ-->
<div class="modal fade" id="odvModalImageRecogNoneProcess">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" style="display:inline-block; color: #FFF;"><?=language('customer/customer/customer', 'tCSTModalHeadRegisFace')?></h5>
			</div>
			<div class="modal-body">
				<span id="ospImageRecogNoneProcess"><?=language('customer/customer/customer', 'tCSTModalContentRegisFace')?></span>
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery"  data-dismiss="modal">
					<i class="fa fa-check-circle" aria-hidden="true"></i> <?=language('common/main/main', 'tModalConfirm')?>
				</button>
			</div>
		</div>
	</div>
</div>

<!--กรณีไม่ได้ตั้งค่า API-->
<div class="modal fade" id="odvModalDontConfigAPI">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" style="display:inline-block; color: #FFF;"><?=language('customer/customer/customer', 'tCSTDontConfigAPI')?></h5>
			</div>
			<div class="modal-body">
				<span id="ospDontConfigAPI"><?=language('customer/customer/customer', 'tCSTContentDontConfigAPI')?></span>
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery"  data-dismiss="modal">
					<i class="fa fa-check-circle" aria-hidden="true"></i> <?=language('common/main/main', 'tModalConfirm')?>
				</button>
			</div>
		</div>
	</div>
</div>

<script>
    //Get ความกว้างมาก่อน
    nWidth = 0;
    $(function() {
        //สร้าง Diagram รูปภาพ
        var nWidth = $('#odvTabRegisFace').width();
        JSxCreateImageLayout(nWidth,1);

        //ไปดึงข้อมูลมา
        var tCustomerCode = $('#oetCstCode').val();
        JSaGetDataImg(tCustomerCode);
    });

    //ดึงข้อมูลมา
    function JSaGetDataImg(ptCustomerCode){
        $.ajax({
            type    : "POST",
            url     : "customerRegisFaceGetImage",
            data    : { 'CustomerCode' : ptCustomerCode },
            cache   : false,
            timeout : 0,
            success : function(tResult) {
                JCNxCloseLoading();
                var tPackData = JSON.parse(tResult);
                if(tPackData.rtCode == 1){
                    //มีข้อมูล
                    $('#odvTabRegisFace').empty();
                    var nCount = tPackData.raItems.length;
                    var pnSeq  = 1;
                    for(i=0; i<nCount; i++){
                        var pnSeq = pnSeq;
                        var tHTML =  "<div class='wCNOuterPDT' data-UseThisColumn='true'>";
                            tHTML += "<div class='xCNBtnDelete' onclick='JSxDeleteImage(this)'><span class='xCNFontBtnDelete'> X </span></div>";
                            tHTML += "<div class='wCNInnerPDT'>";
                            tHTML += "<input type='text' class='xCNHide' data-seq='"+pnSeq+"' id='oetImgInputRegisterFace"+pnSeq+"'  name='oetImgInputRegisterFace"+pnSeq+"' value=''>";
                            tHTML += "<img id='oimImgMasterRegisterFace"+pnSeq+"' style='height:100%; width:100%; display:none;'>";
                            tHTML += "<span id='ospMessageRegisterFace"+pnSeq+"'  class='wCNFontInsertPDT'>+</span>";
                            tHTML += "</div>";
                            tHTML += "</div>";
                        $('#odvTabRegisFace').append(tHTML);

                        var tPathImage  = tPackData.raItems[i].FTImgObj;
                        var tPathImage  = tPathImage.split("application");
                        var tNPathImage = '<?=base_url()?>'+'/application/'+tPathImage[1];
                        $('#oimImgMasterRegisterFace'+pnSeq).attr('src', tNPathImage);
                        $('#oimImgMasterRegisterFace'+pnSeq).css('display','block');
                        $('#ospMessageRegisterFace'+pnSeq).css('display','none');
                        pnSeq++;

                        JSxColumnDeleteHover();
                    }

                    //ถ้ามีครบ 10 ช่องแล้วไม่ต้องเพิ่ม
                    if(pnSeq != 11){
                        var tHTML =  "<div class='wCNOuterPDT' data-UseThisColumn='false'>";
                            tHTML += "<div class='xCNBtnDelete' onclick='JSxDeleteImage(this)'><span class='xCNFontBtnDelete'> X </span></div>";
                            tHTML += "<div class='wCNInnerPDT' onclick=JSvImageCallTempNEW('','99','RegisterFace"+pnSeq+"')>";
                            tHTML += "<input type='text' class='xCNHide' data-seq='"+pnSeq+"' id='oetImgInputRegisterFace"+pnSeq+"'  name='oetImgInputRegisterFace"+pnSeq+"' value=''>";
                            tHTML += "<img id='oimImgMasterRegisterFace"+pnSeq+"' style='height:100%; width:100%; display:none;'>";
                            tHTML += "<span id='ospMessageRegisterFace"+pnSeq+"'  class='wCNFontInsertPDT'>+</span>";
                            tHTML += "</div>";
                            tHTML += "</div>";
                        $('#odvTabRegisFace').append(tHTML);
                    }
                }else{
                    //ไม่มีข้อมูล
                    $('#odvTabRegisFace').empty();
                    var pnSeq = 1;
                    var tHTML =  "<div class='wCNOuterPDT' data-UseThisColumn='false'>";
                        tHTML += "<div class='xCNBtnDelete' onclick='JSxDeleteImage(this)'><span class='xCNFontBtnDelete'> X </span></div>";
                        tHTML += "<div class='wCNInnerPDT' onclick=JSvImageCallTempNEW('','99','RegisterFace"+pnSeq+"')>";
                        tHTML += "<input type='text' class='xCNHide' data-seq='"+pnSeq+"' id='oetImgInputRegisterFace"+pnSeq+"'  name='oetImgInputRegisterFace"+pnSeq+"' value=''>";
                        tHTML += "<img id='oimImgMasterRegisterFace"+pnSeq+"' style='height:100%; width:100%; display:none;'>";
                        tHTML += "<span id='ospMessageRegisterFace"+pnSeq+"'  class='wCNFontInsertPDT'>+</span>";
                        tHTML += "</div>";
                        tHTML += "</div>";
                    $('#odvTabRegisFace').append(tHTML);
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
    
    //ลบข้อมูลในช่อง
    function JSxColumnDeleteHover(){
        $('.wCNOuterPDT').hover(
            function() {
                var oElm = $(this).attr('data-UseThisColumn').toString();
                if(oElm == 'true'){
                    $(this).children('.xCNBtnDelete').addClass('xCNBtnDeleteShow');
                }
            }, function() {
                $(this).children('.xCNBtnDelete').removeClass('xCNBtnDeleteShow');
            }
        );
    }

    //ฟังก์ชั่นลบรูปภาพในช่อง
    function JSxDeleteImage(elem){
        var nSeqOld         = $(elem).parent().find('.wCNInnerPDT .xCNHide').attr('data-seq');
        var tCustomerCode   = $('#oetCstCode').val();
        $.ajax({
            type    : "POST",
            url     : "customerRegisFaceDeleteImage",
            data    : { 'CustomerCode' : tCustomerCode , 'nSeqOld' : nSeqOld},
            cache   : false,
            timeout : 0,
            success : function(oResult) {
                JCNxOpenLoading();
                var tResult = oResult.trim();
                if(tResult == 'refresh'){
                    JSxDeleteImage(elem)
                }else{
                    JSaGetDataImg(tCustomerCode);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //ปุ่มช่อง
    function JSxCreateImageLayout(pnWidth,pnSeq){
        var tHTML =  "<div class='wCNOuterPDT' data-UseThisColumn='false'>";
            tHTML += "<div class='xCNBtnDelete' onclick='JSxDeleteImage(this)'><span class='xCNFontBtnDelete'> X </span></div>";
            tHTML += "<div class='wCNInnerPDT' onclick=JSvImageCallTempNEW('','99','RegisterFace"+pnSeq+"')>";
            tHTML += "<input type='text' class='xCNHide' data-seq='"+pnSeq+"' id='oetImgInputRegisterFace"+pnSeq+"'  name='oetImgInputRegisterFace"+pnSeq+"' value=''>";
            tHTML += "<img id='oimImgMasterRegisterFace"+pnSeq+"' style='height:100%; width:100%; display:none;'>";
            tHTML += "<span id='ospMessageRegisterFace"+pnSeq+"'  class='wCNFontInsertPDT'>+</span>";
            tHTML += "</div>";
            tHTML += "</div>";
        $('#odvTabRegisFace').append(tHTML);
        var nNewWidth = parseInt(pnWidth) - 200;
        var tImage = $('#oetImgInputRegisterFace'+pnSeq).val();
        
        //ถ้ามีภาพเเล้ว ให้เด้งลบ
        JSxColumnDeleteHover();
    }

    //หลังจากเลือกรูปแล้ว ให้ยิง API
    function JSxOnCallNextFunction(ptFullPatch,ptImgName,ptIDElm){
        JCNxOpenLoading();
        //รหัสลูกค้า
        var tCustomerCode = $('#oetCstCode').val();
        $.ajax({
            type    : "POST",
            url     : "customerRegisFace",
            data    : { 'CustomerCode' : tCustomerCode , 'ImageFullPath' : ptFullPatch , 'ImageName' : ptImgName },
            cache   : false,
            timeout : 0,
            success : function(tResult) {
                JCNxCloseLoading();
                var tResult = tResult.trim();
                // console.log(tResult);
                if(tResult == 'refresh'){
                    JSxOnCallNextFunction(ptFullPatch,ptImgName,ptIDElm)
                }else if(tResult == 'ConfigFail'){
                    $('#odvModalDontConfigAPI').modal('show');
                }else if(tResult == 'fail'){
                    var tHeadModalNotFound = '<?=language('customer/customer/customer', 'tCSTModalContentRegisFace')?>';
                    $('#odvModalImageRecogNoneProcess').modal('show');
                    $('#ospImageRecogNoneProcess').text(tHeadModalNotFound + ' ไม่พบใบหน้า ' + ' กรุณาลองใหม่อีกครั้ง');
                }else if(tResult == 'success'){
                    var tElementID = $('#odvTabRegisFace > .wCNOuterPDT:last-child > .wCNInnerPDT').children().attr('data-seq');
                    var nSeqBefore = tElementID;
                    var nSeqNew    = parseInt(nSeqBefore) + 1;

                    //ลบ event ไม่ให้มันทำงาน
                    $('#odvTabRegisFace > .wCNOuterPDT:last-child > .wCNInnerPDT').prop("onclick", null).off("click");

                    //เอารูปมาโชว์ + ซ่อนข้อความปุ่มเพิ่ม
                    $('#oimImgMasterRegisterFace'+nSeqBefore).css('display','block');
                    $('#ospMessageRegisterFace'+nSeqBefore).css('display','none');
                    $('#odvTabRegisFace > .wCNOuterPDT').attr('data-UseThisColumn','true');
                    if(nSeqNew == 11){
                        //Break เพิ่มไม่ได้เเล้ว
                    }else{
                        //ข้อมูลน้อยกว่า 10 ให้เพิ่มอัตโนมัติ
                        var nWidth = $('#odvTabRegisFace').width();
                        JSxCreateImageLayout(nWidth,nSeqNew);
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //กรณีกดเลือกรูป หลังจากเเสดง Modal ไม่สำเร็จ
    function JSxConfirmImageRecogNoneProcess(){
    }
</script>