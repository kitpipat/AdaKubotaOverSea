///function : Funtion Call Image Temp
//Parameters : Event Button
//Creator :	12/04/2018 (Wasin)
//Return :  -
//Return Type : -
function JSvImageCallTemp(ptPage, pnBrowseType) {
    var nWinHeight = $(window).height();
    var nh = parseInt(nWinHeight) - 250;
    var nHeightCropCanvasBox = nh-30;
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "ImageCallTemp",
        data: {
            nPageCurrent: ptPage,
            nBrowseType: pnBrowseType
        },
        cache: false,
        timeout: 0,
        success: function (oResult) {
            var aDataImg = JSON.parse(oResult);
            // console.log('JSvImageCallTemp');
            // console.log(aDataImg);
            if (aDataImg != "") {
                $('#odlModalTempImg .modal-body').css('max-height',nHeightCropCanvasBox);
                $('#odvImgItemsList').empty();
                $('#odvImgItemsList').html(aDataImg.rtImgData);
                $('#odvImgTotalPage').html(aDataImg.rtTotalPage);
                $('#odvImgPagenation').html(aDataImg.rtPaging);
                $('#odlModalTempImg').modal('show');
                var waterfall = new Waterfall({
                    containerSelector: '.wf-container',
                    boxSelector: '.wf-box',
                    minBoxWidth: 220
                });
            }
            JCNxCloseLoading();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

///function : Fuction Image Uplode and Resize file
//Parameters : Event Button
//Creator : 12/04/2018 (Wasin)
//Return : 
//Return Type : 
function JSxImageUplodeResize(poImg, ptRetio) {
    var oImgData = poImg.files[0];
    var oImgFrom = new FormData();
    oImgFrom.append('file', oImgData);
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "ImageUplode",
        cache: false,
        contentType: false,
        processData: false,
        data: oImgFrom,
        datatype: "JSON",
        timeout: 50000,
        success: function (tResult) {
            if (tResult != "") {
                JSxImageCrop(tResult, ptRetio);
            }
            JCNxCloseLoading();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

///function : Function Crop Image
//Parameters : Function Paramiter (JSoImagUplodeResize)
//Creator : 12/04/2018 (Wasin)
//Return : -
//Return Type : -
function JSxImageCrop(poImgData, ptRetion) {
    var aImgData = JSON.parse(poImgData);
    if (aImgData.tImgBase64 != "") {
        $('#odvModalCrop').empty();
        $('#odvModalCrop')
                .append('<div class="modal fade" id="oModalCropper" aria-labelledby="modalLabel" role="dialog" tabindex="-1"> <div class="modal-dialog" role="document" style="z-index:2000; margin-top: 60px;"> <div class="modal-content"> <div class="modal-header" style="padding-bottom:10px;"> <h5 class="modal-title" id="modalLabel" style="font-weight:bold; margin:0px 0px 0px 0px; float:left;">Crop Image</h5> <button id="oModalCropperdelete" style="float:right;" type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div> <div class="modal-body" style="min-height:500px;height:500px;overflow-y:auto;"> <div> <img id="oImageCropper" style="max-width: 60%;" src="' +
                        aImgData.tImgBase64 + '" alt="Picture"> </div> </div> <div class="modal-footer"> <div class="pull-left"> <div class="btn-group"> <button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper\').cropper(\'zoom\', 0.1)" title="Zoom In"> <span class="docs-tooltip"> <span class="fa fa-search-plus"></span> </span> </button> <button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper\').cropper(\'zoom\', -0.1)" title="Zoom Out"> <span class="docs-tooltip"> <span class="fa fa-search-minus"></span> </span> </button> </div> <div class="btn-group"> <button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper\').cropper(\'move\', -10, 0)" title="Move Left"> <span class="docs-tooltip"> <span class="fa fa-arrow-left"></span> </span> </button> <button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper\').cropper(\'move\', 10, 0)" title="Move Right"> <span class="docs-tooltip"> <span class="fa fa-arrow-right"></span> </span> </button> <button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper\').cropper(\'move\', 0, -10)" title="Move Up"> <span class="docs-tooltip"> <span class="fa fa-arrow-up"></span> </span> </button> <button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper\').cropper(\'move\', 0, 10)" title="Move Down"> <span class="docs-tooltip"> <span class="fa fa-arrow-down"></span> </span> </button> </div> </div> <button type="button" class="btn btn-outline-primary pull-right xWBtnCropImage" title="Crop"> <span> Crop </span> </button> </div> </div> </div> </div>');
    }
    setTimeout(function () {
        $('#odlModalTempImg').modal('hide');
        $('#oModalCropper').modal({backdrop: 'static', keyboard: false});
        $('#oModalCropper').modal("show");
        var $image = $('#oImageCropper');
        var $button = $('.xWBtnCropImage');

        var cropBoxData;
        var canvasData;
        $('#oModalCropper').on('shown.bs.modal', function () {
            $image.cropper({
                width : 215,
                height : 130,
                viewMode : 1,
                dragMode : 'move',
                autoCropArea : 0.8,
                restore : true,
                guides : true,
                highlight : false,
                cropBoxMovable : true,
                cropBoxResizable : true,
                strict: true,
                background: false,
                zoomable: false,
                aspectRatio: 16 / 9,
                built: function () {
                    $image.cropper("setCropBoxData", {width: "215", height: "130"});
                },
                ready: function () {
                    $image.cropper('setCanvasData', canvasData);
                    $image.cropper('setCropBoxData', cropBoxData);
                }
            });
        }).on('hidden.bs.modal', function () {
            cropBoxData = $image.cropper('getCropBoxData');
            canvasData = $image.cropper('getCanvasData');
            $image.cropper('destroy');
            $('#oModalCropper').remove();
            $('#ofilePhotoAdd').val('');
            $('#oetInputUplode').val('');
        });
        $button.on('click', function () {
            var croppedCanvas;
            var roundedCanvas;
            croppedCanvas = $image.cropper('getCroppedCanvas');
            roundedCanvas = croppedCanvas.toDataURL();
            $.ajax({
                type: "POST",
                url: "ImageConvertCrop",
                cache: false,
                data: {
                    'tBase64': roundedCanvas,
                    'tImgName': aImgData.tImgName,
                    'tImgtype': aImgData.tImgType,
                    'tImgPath': aImgData.tImgFullPath
                },
                success: function (tResult) {
                    if (tResult != "") {
                        $('#oModalCropper').modal("hide");
                        JSvImageCallTemp();
                    }
                    $('#oetInputUplode').val('');
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
        $('#oModalCropperdelete').click(function () {
            JSxImageDelete(aImgData.tImgName);
            $('#odlModalTempImg').modal('show');

        });
    }, 500);
}

///function : Function Crop Image
//Parameters : Function Paramiter (JSoImagUplodeResize)
//Creator : 12/04/2018 (Wasin)
//Return : -
//Return Type : -
function JSxImageDelete(ptImgName) {
    if (ptImgName != "") {
        $.ajax({
            type: "POST",
            url: "ImageDeleteFile",
            cache: false,
            data: {tImageName: ptImgName},
            success: function (tResult) {
                var aDataImg = JSON.parse(tResult);
                if (aDataImg != "") {
                    $('#odvImgTempData').html(aDataImg.rtImgData);
                    $('#odvImgTotalPage').html(aDataImg.rtTotalPage);
                    $('#odvImgPagenation').html(aDataImg.rtPaging);
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
    }
}

///function : Function Click Page Temp
//Parameters : Event Button
//Creator : 18/04/2018 (Wasin)
//Return : -
//Return Type : -
function JSvClickPageTemp(ptPage) {
    if (ptPage == '1') {
        var nPage = 'previous';
    } else if (ptPage == '2') {
        var nPage = 'next';
    }
    var nPageCurrent = '';
    switch (nPage) {
        case 'next': //กดปุ่ม Next
            $('.next').addClass('disabled');
            nPageOld = $('.pagination .active a').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous 
            nPageOld = $('.pagination .active a').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = 1
    }
    JSvImageCallTemp(nPageCurrent);
}

///function : Function Choose Image
//Parameters : Event Button
//Creator : 18/04/2018 (Wasin)
//Return : -
//Return Type : -
function JSxChooseImage(ptFullPatch, ptImgName, pnBrowseType) {
    var tImgName = "";
    var tImgShow = "";
    if (ptFullPatch == "") {
        tImgShow = "http://www.bagglove.com/images/400X200.gif"
    } else {
        tImgShow = ptFullPatch + '/' + ptImgName;
        tImgName = ptImgName;
    }

    if (pnBrowseType == '1') {
        $('#oimImgMaster').attr('src', tImgShow);
        $('#oetImgInput').val(ptImgName);
    } else {

        $('#oimImgMaster').attr('src', tImgShow);
        // oImageTumblr = '<li style="width:auto">';
        // oImageTumblr += '<img src="' + tImgShow + '" class="img img-respornsive" style="width:120px;"><br>';
        // oImageTumblr += '<a onclick="JCNxRemoveTumblr(' + "'" + tImgShow + "'" + ')">ลบ</a>';
        // oImageTumblr += '</li>';
        var nMinNumber = 1; // le minimum
        var nMaxNumber = 100; // le maximum
        var nImgIdx = Math.floor(Math.random() * (nMaxNumber + 1) + nMinNumber);
        $("#otbImageList").find('tbody > tr')
                .append($('<td>').attr('id', 'otdTumblr' + nImgIdx)
                        .append($('<img>')
                                .attr('id', 'oimTumblr' + nImgIdx)
                                .attr('src', tImgShow)
                                .attr('data-img', tImgName)
                                .attr('data-tumblr', nImgIdx)
                                .text('Image cell')
                                .css('z-index', '100')
                                .addClass('xCNImgTumblr img img-respornsive')
                                .click(function () {
                                    $('#oimImgMaster').attr('src', $(this).attr('src'));
                                    return false;
                                })
                                .hover(function () {
                                    $('#odvImgDelBnt' + $(this).data('tumblr')).show();
                                    //JCNxRemoveImgTumblr(this, tImgShow);
                                })
                                .mouseleave(function () {
                                    $('#odvImgDelBnt' + $(this).data('tumblr')).hide();
                                })
                                )
                        .append($('<div class="xCNImgDelIcon"></div>')
                                .attr('id', 'odvImgDelBnt' + nImgIdx)
                                .attr('data-id', nImgIdx)
                                .css('z-index', '500')
                                .hover(function () {
                                    $(this).show();
                                    $('#' + nImgIdx).addClass('xCNImgHover');
                                    //JCNxRemoveImgTumblr(this, tImgShow);
                                })
                                .append('<i class="fa fa-times" aria-hidden="true"></i> ลบรูป ')
                                .mouseleave(function () {
                                    $(this).hide();
                                })
                                .click(function () {
                                    JCNxRemoveImgTumblr(this);
                                })
                                )
                        );

    }
    $('#odlModalTempImg').modal('hide');

}

///function : Function Choose Remove Image 
//Parameters : Event Button
//Creator : 18/04/2018 (Wasin)
//Return : -
//Return Type : -
function JCNxRemoveImgTumblr(poTumblrID) {
    nDataId = $(poTumblrID).data('id');

    tCurrentShowPath = $('#oimImgMaster').attr('src');
    tCurrentRemovingPath = $('#oimTumblr' + nDataId).attr('src');
    $('#otdTumblr' + nDataId).remove();
    if (tCurrentShowPath === tCurrentRemovingPath) {
        $('#oimImgMaster').attr('src', 'http://www.bagglove.com/images/400X200.gif');
    }
    //tTumblrPathFrist = $("#otbImageList >  tr > td:nth-child(1)").text();
    tTumblrPathFrist = jQuery("#otbImageList").find("td:eq(1) > img").attr('src');

    if (tTumblrPathFrist != '' || tTumblrPathFrist != undefined) {
        $('#oimImgMaster').attr('src', tTumblrPathFrist);
    }
}









// function: Funtion Call Image Temp
// Parameters: Event Button
// Creator:	12/04/2018 Wasin(Yoshi)
// LastModify: 26/02/2019 Wasin(Yoshi)
// Return:  View Modal Temp Image
// ReturnType: View
function JSvImageCallTempNEW(ptPage,pnBrowseType,ptMasterName,ptRetion){

    // Create By Witsarut 04/10/2019
        JSxCheckPinMenuClose();
    // Create By Witsarut 04/10/2019

    // alert(ptPage+'/'+pnBrowseType+'/'+ptMasterName+'/'+ptRetion);
    $('.xCNModalTempImgNew').remove(); //ลบ modal ทุกครั้งก่อนสร้างใหม่ เพราะเจอปัญหามันเรียกซ้อนกัน Napat(Jame) 09/092019
    $.ajax({
        type: "POST",
        url: "ImageCallMaster",
        data: {
            ptMasterName: ptMasterName,
            pnBrowseType: pnBrowseType
        },
        cache: false,
        timeout: 0,
        success: function (tResult) {
            $('body').append(tResult);
            JSvImageCallTempNEWStep2(ptPage, pnBrowseType, ptMasterName,ptRetion);
            if (ptRetion == '') {
                $('#ohdRetionCropper').val('16 / 9');
            } else {
                $('#ohdRetionCropper').val(ptRetion);
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}


///function : Funtion Call Image Temp
//Parameters : Event Button
//Creator :	12/04/2018 (Wasin)
//Return :  -
//Return Type : -
function JSvImageCallTempNEWStep2(ptPage, pnBrowseType, ptMasterName,ptRetion) {
    var nWinHeight = $(window).height();
    var nh = parseInt(nWinHeight) - 250;
    var nHeightCropCanvasBox = nh-30;
    JCNxOpenLoadingInModal();
    $.ajax({
        type: "POST",
        url: "ImageCallTempNEW",
        data: {
            nPageCurrent: ptPage,
            nBrowseType: pnBrowseType,
            ptMasterName: ptMasterName,
            ptRetion: ptRetion
        },
        cache: false,
        timeout: 0,
        success: function (tResult) {
            var aDataImg = JSON.parse(tResult);
            console.log(aDataImg);
            if (aDataImg != "") {
                $('#odlModalTempImg'+ptMasterName+' .modal-body').css('max-height',nHeightCropCanvasBox);
                $('#odvImgTempData' + ptMasterName).html(aDataImg.rtImgData);
                $('#odvImgTotalPage' + ptMasterName).html(aDataImg.rtTotalPage);
                $('#odvImgPagenation' + ptMasterName).html(aDataImg.rtPaging);
                $('#odlModalTempImg' + ptMasterName).modal('show');
                setTimeout(function(){
                    var waterfall   = new Waterfall({
                        containerSelector: '.wf-container1',
                        boxSelector: '.wf-box1',
                        minBoxWidth: 220,
                    });
                    JCNxCloseLoadingInModal();
                },2000);
            }else{
                JCNxCloseLoadingInModal();
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}


///function :
//Parameters : - 
//Creator :xxx
//Return : -
//Return Type : -
function JSxChooseImageNEW(ptFullPatch, ptImgName, pnBrowseType, ptMasterName) {
    var tImgName = "";
    var tImgShow = "";
    // ตรวจสอบว่า เป็น paramiter จาก สินค้าหรือไม่
    if(ptMasterName == "Product"){
        $('.xCNColorProduct').hide();
        $('.xCNCheckedORB').prop('checked',false);
        $("#oimImgMasterProduct").css({ 'width' : '100%' });
        $('#oetPdtColor').val('#000000'); 
        $('#oetPdtColor').attr("disabled", true); 
    }

    if (ptFullPatch == "") {
        tImgShow = tBaseURL+"application/modules/common/assets/images/NoPic.png"
    } else {
        tImgShow = ptFullPatch + '/' + ptImgName;
        tImgName = ptImgName;
    }

    if (pnBrowseType == '1') {
        // Single Brows Image Choose
        $('#oimImgMaster' + ptMasterName).attr('src', tImgShow);
        $('#oetImgInput' + ptMasterName).val(ptImgName).trigger('change');
    }else if(pnBrowseType == '99'){
        //Case นี้คือเอาไว้ใช้สำหรับลงทะเบียนผ่านใบหน้า ทุกครั้งที่เลือกรูปเสร็จเเล้วจะมีการ call API ตรวจสอบว่าสำเร็จ หรือ ล้มเหลว (วัฒน์ 22-ตุลา-2019)
        $('#oimImgMaster' + ptMasterName).attr('src', tImgShow);
        $('#oetImgInput' + ptMasterName).val(ptImgName).trigger('change');
        JSxOnCallNextFunction(ptFullPatch,ptImgName,ptMasterName);
    }else if(pnBrowseType == '3') {
        //Multi Brows Img AdMessage

        var nMinNumber = 1; // le minimum
        var nMaxNumber = 100; // le maximum
        var nImgIdx = Math.floor(Math.random() * (nMaxNumber + 1) + nMinNumber);

        $('#odvImageList'+ptMasterName).append($('<div>')
        .attr('id', 'odvADMTumblr'+ptMasterName+nImgIdx)
        .attr('class','xWADMImgDataItem xWADMImgParent')
            // .append($('<div>')
                .append($('<div>')
                .attr('id','oimTumblr'+ptMasterName+nImgIdx)
                .attr('class','thumbnail xWADMImg xWADMImgStyle')
                // .attr('src', tImgShow)
                .attr('data-img',tImgName)
                .attr('data-tumblr',nImgIdx)
                // .text('Image cell')
                // .css('background-image',tImgShow)
                .css("background-image", "url('" + tImgShow + "')")
                // .css('height','100%')
                )
            // )
            .append($('<div>')
            .attr('class','xWADMImgChild xWADMImgDel')
            .css('display','none')
                .append($('<button>')
                .attr('class','btn xCNBTNDefult xCNBTNDefult2Btn xWADMBtnImgDel')
                .attr('type','button')
                .text('ลบรูป')
                )
            )
        );
    }else{
        // oImageTumblr = '<li style="width:auto">';
        // oImageTumblr += '<img src="' + tImgShow + '" class="img img-respornsive" style="width:120px;"><br>';
        // oImageTumblr += '<a onclick="JCNxRemoveTumblr(' + "'" + tImgShow + "'" + ')">ลบ</a>';
        // oImageTumblr += '</li>';
        $('#oimImgMaster' + ptMasterName).attr('src', tImgShow);
        var nMinNumber = 1; // le minimum
        var nMaxNumber = 100; // le maximum
        var nImgIdx = Math.floor(Math.random() * (nMaxNumber + 1) + nMinNumber);
        $('#oimImgMaster'+ptMasterName).attr('src',tImgShow);
        $('#otbImageList'+ptMasterName).find('tbody > tr')
        .append($('<td>')
        .attr('id', 'otdTumblr'+ptMasterName+nImgIdx)
        .attr('class','xWTDImgDataItem')
            .append($('<img>')
            .attr('id','oimTumblr'+ptMasterName+nImgIdx)
            .attr('src', tImgShow)
            .attr('data-img',tImgName)
            .attr('data-tumblr',nImgIdx)
            .text('Image cell')
            .css('z-index', '100')
            .css('width','106px')
            .css('height','67px')
            .addClass('xCNImgTumblr img img-respornsive')
                .click(function(){
                    $('#oimImgMaster'+ptMasterName).attr('src',$(this).attr('src'));
                    return false;
                })
                .hover(function () {
                    $('#odvImgDelBnt'+ ptMasterName + $(this).data('tumblr')).show();
                    //JCNxRemoveImgTumblr(this, tImgShow);
                })
                .mouseleave(function () {
                    $('#odvImgDelBnt'+ ptMasterName + $(this).data('tumblr')).hide();
                })
            )
            .append($('<div class="xCNImgDelIcon"></div>')
            .attr('id', 'odvImgDelBnt'+ ptMasterName + nImgIdx)
            .attr('data-id', nImgIdx)
            .css('z-index', '500')
            .css('cursor','pointer')
            .css('text-align','center')
                .hover(function(){
                    $(this).show();
                    $('#' + nImgIdx).addClass('xCNImgHover');
                })
                .append('<i class="fa fa-times" aria-hidden="true"></i> ลบรูป ')
                .mouseleave(function () {
                    $(this).hide();
                })
                .click(function (){
                    JCNxRemoveImgTumblrNEW(this,ptMasterName);
                })
            )
        );
    }
    $('#odlModalTempImg' + ptMasterName).modal('hide');
}

function JCNxRemoveImgTumblrNEW(poTumblrID, ptMasterName) {
    nDataId                 = $(poTumblrID).data('id');
    tCurrentShowPath        = $('#oimImgMaster'+ptMasterName).attr('src');
    tCurrentRemovingPath    = $('#oimTumblr'+ptMasterName+nDataId).attr('src');
    $('#otdTumblr'+ ptMasterName + nDataId).remove();
    if (tCurrentShowPath === tCurrentRemovingPath) {
        $('#oimImgMaster' + ptMasterName).attr('src',tBaseURL+"application/modules/common/assets/images/NoPic.png");
    }
    
    tTumblrPathFrist = $("#otbImageList >  tr > td:nth-child(1)").text();
    tTumblrPathFrist = jQuery("#otbImageList" + ptMasterName).find("td:eq(1) > img").attr('src');

    if (tTumblrPathFrist != '' || tTumblrPathFrist != undefined) {
        $('#oimImgMaster' + ptMasterName).attr('src', tTumblrPathFrist);
    }
}


///function : Function Crop Image
//Parameters : Function Paramiter (JSoImagUplodeResize)
//Creator : 12/04/2018 (Wasin)
//Return : -
//Return Type : -
function JSxImageDeleteNEW(ptImgName, ptMasterName) {
    if (ptImgName != "") {
        $.ajax({
            type: "POST",
            url: "ImageDeleteFileNEW",
            cache: false,
            data: {tImageName: ptImgName,
                tMasterName: ptMasterName},
            success: function (tResult) {
                var aDataImg = JSON.parse(tResult);
                if (aDataImg != "") {
                    $('#odvImgTempData' + ptMasterName).html(aDataImg.rtImgData);
                    $('#odvImgTotalPage' + ptMasterName).html(aDataImg.rtTotalPage);
                    $('#odvImgPagenation' + ptMasterName).html(aDataImg.rtPaging);
                    var waterfall = new Waterfall({
                        containerSelector: '.wf-container1',
                        boxSelector: '.wf-box1',
                        minBoxWidth: 220,
                    });
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
    }
}

///function : Function Click Page Temp
//Parameters : Event Button
//Creator : 18/04/2018 (Wasin)
//Return : -
//Return Type : -
function JSvClickPageTempNEW(ptPage, ptMasterName) {

    if (ptPage == '1') {
        var nPage = 'previous';
    } else if (ptPage == '2') {
        var nPage = 'next';
    }
    var nPageCurrent = '';
    switch (nPage) {
        case 'next': //กดปุ่ม Next
            $('.next').addClass('disabled');
            nPageOld = $('.pagination' + ' .' + ptMasterName + '.active a').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous 
            nPageOld = $('.pagination' + ' .' + ptMasterName + '.active a').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = 1
    }

    JSvImageCallTempNEW(nPageCurrent, '', ptMasterName);
}

///function : Fuction Image Uplode and Resize file
//Parameters : Event Button
//Creator : 12/04/2018 (Wasin)
//Return : 
//Return Type : 
function JSxImageUplodeResizeNEW(poImg, ptRetio, ptMasterName,pnBrowseType) {
    var oImgData = poImg.files[0];
    var oImgFrom = new FormData();
    oImgFrom.append('file', oImgData);
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "ImageUplode",
        cache: false,
        contentType: false,
        processData: false,
        data: oImgFrom,
        datatype: "JSON",
        timeout: 0,
        success: function (tResult) {
            if (tResult != "") {
                JSxImageCropNEW(tResult, ptRetio, ptMasterName,pnBrowseType);
            }
            JCNxCloseLoading();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

///function : Function Crop Image
//Parameters : Function Paramiter (JSoImagUplodeResize)
//Creator : 12/04/2018 (Wasin)
//Return : -
//Return Type : -
function JSxImageCropNEW(poImgData, ptRetion, ptMasterName,pnBrowseType){
    var nWinHeight = $(window).height();
    var nh = parseInt(nWinHeight) - 250;
    var nHeightCropCanvasBox = nh-30;
    var aImgData = JSON.parse(poImgData);
    if (aImgData.tImgBase64 != "") {
        $("#odvModalCrop" + ptMasterName)
        .append(
            '<div class="modal fade" id="oModalCropper' + ptMasterName + '" aria-labelledby="modalLabel" role="dialog" tabindex="-1">'+
                '<div class="modal-dialog" role="document" style="z-index:2000; margin-top: 60px;"> <div class="modal-content">'+
                    '<div class="modal-header" style="padding-bottom:10px;">'+
                        '<h5 class="modal-title" id="modalLabel" style="font-weight:bold; margin:0px 0px 0px 0px; float:left;">Crop Image</h5>'+
                        '<button id="oModalCropperdelete' + ptMasterName + '" style="float:right;" type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                        '<span aria-hidden="true">&times;</span> </button>'+
                    '</div>'+
                    '<div class="modal-body" style="max-height:'+nHeightCropCanvasBox+'px;overflow-y:auto;">'+
                        '<div>'+
                            '<img id="oImageCropper' + ptMasterName + '" style="max-width: 60%;" src="' +aImgData.tImgBase64 + '" alt="Picture">'+
                        '</div>'+
                    '</div>'+
                    '<div class="modal-footer">'+
                        '<div class="pull-left">'+
                            '<div class="btn-group">'+
                                '<button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper' + ptMasterName + '\').cropper(\'zoom\', 0.1)" title="Zoom In">'+
                                    '<span class="docs-tooltip">'+
                                        '<span class="fa fa-search-plus">'+
                                        '</span>'+
                                    '</span>'+
                                '</button>'+
                                '<button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper' + ptMasterName + '\').cropper(\'zoom\', -0.1)" title="Zoom Out">'+
                                    '<span class="docs-tooltip">'+
                                        '<span class="fa fa-search-minus">'+
                                        '</span>'+
                                    '</span>'+
                                '</button>'+
                            '</div>'+
                            '<div class="btn-group">'+
                                '<button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper' + ptMasterName + '\').cropper(\'move\', -10, 0)" title="Move Left">'+
                                    '<span class="docs-tooltip">'+
                                        '<span class="fa fa-arrow-left">'+
                                        '</span>'+
                                    '</span>'+
                                '</button>'+
                                '<button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper' + ptMasterName + '\').cropper(\'move\', 10, 0)" title="Move Right">'+
                                    '<span class="docs-tooltip">'+
                                        '<span class="fa fa-arrow-right">'+
                                        '</span>'+
                                    '</span>'+
                                '</button>'+
                                '<button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper' + ptMasterName + '\').cropper(\'move\', 0, -10)" title="Move Up">'+
                                    '<span class="docs-tooltip">'+
                                        '<span class="fa fa-arrow-up">'+
                                        '</span>'+
                                    '</span>'+
                                '</button>'+
                                '<button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper' + ptMasterName + '\').cropper(\'move\', 0, 10)" title="Move Down">'+
                                    '<span class="docs-tooltip">'+
                                        '<span class="fa fa-arrow-down">'+
                                        '</span>'+
                                    '</span>'+
                                '</button>'+
                            '</div>'+
                        '</div>'+
                        '<button type="button" class="btn btn-outline-primary pull-right xWBtnCropImage' + ptMasterName + '" title="Crop">'+
                            '<span> Crop </span>'+
                        '</button>'+
                    '</div>'+
                '</div>'+
            '</div>'+
        '</div>');
    }
    setTimeout(function () {
        $('#odlModalTempImg' + ptMasterName).modal('hide');
        $('#oModalCropper' + ptMasterName).modal({backdrop: 'static', keyboard: false});
        $('#oModalCropper' + ptMasterName).modal("show");
        var $image = $('#oImageCropper' + ptMasterName);
        var $button = $('.xWBtnCropImage' + ptMasterName);
        var cropBoxData;
        var canvasData;
        var tRetionCropper = $('#ohdRetionCropper').val();		
        var aRetionCropper = tRetionCropper.split("/");
        $('#oModalCropper' + ptMasterName).on('shown.bs.modal', function () {
            $image.cropper({
                width : 215,
                height : 130,
                viewMode : 1,
                dragMode : 'move',
                autoCropArea : 0.8,
                // restore : true,
                // guides : true,
                // highlight : false,
                // cropBoxMovable : true,
                // cropBoxResizable : true,
                // strict: true,
                // background: false,
                // zoomable: false,
                aspectRatio: aRetionCropper[0]/aRetionCropper[1],
                built: function () {
                    $image.cropper("setCropBoxData", {width: "215", height: "130"});
                },
                ready: function () {
                    $image.cropper('setCanvasData', canvasData);
                    $image.cropper('setCropBoxData', cropBoxData);
                }
            });
        }).on('hidden.bs.modal', function () {
            cropBoxData = $image.cropper('getCropBoxData');
            canvasData = $image.cropper('getCanvasData');
            $image.cropper('destroy');
            $('#oModalCropper' + ptMasterName).remove();
            $('#ofilePhotoAdd').val('');
            $('#oetInputUplode' + ptMasterName).val('');
        });
        $button.on('click', function () {
            var croppedCanvas;
            var roundedCanvas;
            croppedCanvas = $image.cropper('getCroppedCanvas');
            roundedCanvas = croppedCanvas.toDataURL();
            $.ajax({
                type: "POST",
                url: "ImageConvertCrop",
                cache: false,
                data: {
                    'tBase64': roundedCanvas,
                    'tImgName': aImgData.tImgName,
                    'tImgtype': aImgData.tImgType,
                    'tImgPath': aImgData.tImgFullPath
                },
                success: function (tResult) {
                    if (tResult != "") {
                        $('#oModalCropper' + ptMasterName).modal("hide");
                        JSvImageCallTempNEW('', pnBrowseType, ptMasterName);
                    }
                    $('#oetInputUplode' + ptMasterName).val('');
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
        $('#oModalCropperdelete' + ptMasterName).click(function () {
            JSxImageDeleteNEW(aImgData.tImgName, ptMasterName);
            $('#odlModalTempImg' + ptMasterName).modal('show');

        });
    }, 500);
}




