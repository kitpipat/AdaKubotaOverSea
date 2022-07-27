<script>

//function: function Set Modal Text In Msg Success
//Parameters: Text Message Return
//Creator: 23/01/2020 ฺBell
//Return: View Alert success Massage
//Return Type: -
function FSvCMNMsgSucessDialog(tMsgBody) {
    $('#odvModalInfoMessageFrm .modal-body ').html(tMsgBody);
    $('#odvModalInfoMessageFrm').modal({ backdrop: 'static', keyboard: false })
    JCNxCloseLoading();
    $('#odvModalInfoMessageFrm').modal({ show: true });
}

//function : function Close Lodding
//Parameters : - 
//Creator : 03/05/2018 wasin
//Return : Close Lodding
//Return Type : -
function JCNxCloseLoading() {
    $('.xCNOverlay').delay(10).fadeOut();
}


// Create By Napat(Jame) 14/05/2020
// Call Modal
function JCNxCallModalChangePassword(pnStaAct){

    $('#odvmodalChangePassword').remove();
    let tHTML = '';
    tHTML += '<div class="modal fade" id="odvmodalChangePassword">';
    tHTML += '  <div class="modal-dialog" style="width: 400px;">';
    tHTML += '      <div class="modal-content">';
    tHTML += '          <div class="modal-header xCNModalHead">';
    tHTML += '              <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tMNUChangePassword')?></label>';
    tHTML += '              <input type="hidden" id="ohdtypeChangePassword" name="ohdtypeChangePassword"></input>';
    tHTML += '          </div>';
    tHTML += '          <div class="modal-body">';
    tHTML += '              <div class="form-group">';
    tHTML += '                  <label class="xCNLabelFrm"><?php echo language('common/main/main','tMNUChangePasswordOld')?></label>';
    tHTML += '                  <input class="form-control xWCanEnterChgPass" type="password" id="oetPasswordOld" name="oetPasswordOld" maxlength="100" value="">';
    tHTML += '              </div>';
    tHTML += '              <div class="form-group">';
    tHTML += '                  <label class="xCNLabelFrm"><?php echo language('common/main/main','tMNUChangePasswordNew')?></label>';
    tHTML += '                  <input class="form-control xWCanEnterChgPass" type="password" id="oetPasswordNew" name="oetPasswordNew" size="12" minlength="12" maxlength="12" value="">';
    tHTML += '              </div>';
    tHTML += '              <div class="form-group">';
    tHTML += '                  <label class="xCNLabelFrm"><?php echo language('common/main/main','tMNUChangePasswordConfirm')?></label>';
    tHTML += '                  <input class="form-control xWCanEnterChgPass" type="password" id="oetPasswordConf" name="oetPasswordConf" size="12" minlength="12" maxlength="12" value="">';
    tHTML += '              </div>';
    tHTML += '                  <label id="odlChkDegitPassword" class="xCNLabelFrm" style="display:block; text-align:right; color: #f95353 !important;"><?= language('common/main/main','tCheckDegitPassword')?></label>';
    tHTML += '                  <label id="odlPasswordNomatch" class="xCNLabelFrm" style="display:none; text-align:right; color: #f95353 !important;"><?= language('common/main/main','tMNUChangePasswordNoMatch')?></label>';
    tHTML += '                  <label id="odlChgPassword" class="xCNLabelFrm" style="display:block; text-align:right; color: #f95353 !important;"><?= language('common/main/main','รหัสผ่านใหม่เหมือนกับรหัสผ่านเก่าไม่อนุญาตให้ใช้')?></label>';
    tHTML += '                  <label id="odlChgPasswordConf" class="xCNLabelFrm" style="display:block; text-align:right; color: #f95353 !important;"><?= language('common/main/main','tMNUChangePasswordConfirmIncorrect')?></label>';
    tHTML += '          </div>';
    tHTML += '          <div class="modal-footer">';
    tHTML += '              <button id="obtConfirmPassword" onClick="JCNxCheckPassword('+pnStaAct+')" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">';
    tHTML += '                  <?php echo language('common/main/main', 'tModalConfirm')?>';
    tHTML += '              </button>';
    tHTML += '              <button id="obtCancelPassword" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">';
    tHTML += '                  <?php echo language('common/main/main', 'tModalCancel')?>';
    tHTML += '              </button>';
    tHTML += '          </div>';
    tHTML += '      </div>';
    tHTML += '  </div>';
    tHTML += '</div>';
    $('body').append(tHTML);
    setTimeout(function(){
        $('#oetPasswordOld').val('');
        $('#oetPasswordNew').val('');
        $('#odlPasswordNomatch').css("display", "none");
        $('#odlChgPasswordConf').css("display", "none");
        $('#odlChgPassword').hide();  // ถ้าเปลี่ยน Password ใหม่ แล้ว เหมือนกับ Password เก่า จะไม่อณุญาติ (Bell)
        $('#odlChkDegitPassword').hide();  // เช็ค Password ถ้า key ถึง 8 degit (Bell)
        $('#odvmodalChangePassword').modal("toggle");
        setTimeout(function(){
            $('#oetPasswordOld').focus();
            $('.xWCanEnterChgPass').on('keypress',function(){
                $('#odlPasswordNomatch').css("display", "none");
                $('#odlChgPasswordConf').css("display", "none");
                $('#odlChgPassword').hide();  // ถ้าเปลี่ยน Password ใหม่ แล้ว เหมือนกับ Password เก่า จะไม่อณุญาติ (Bell)
                $('#odlChkDegitPassword').hide();  // เช็ค Password ถ้า key ถึง 8 degit (Bell)
                console.log(event.keyCode);
                if(event.keyCode == 13){
                    $('#obtConfirmPassword').click();
                }
         
            });
        }, 1000);
    }, 500);
    
}

// Create By Napat(Jame) 14/05/2020
// เปลี่ยนรหัสผ่าน
function JCNxCheckPassword(pnStaAct){
    var tPassOld = $('#oetPasswordOld').val();
    var tPassNew = $('#oetPasswordNew').val();
    var tPassConf = $('#oetPasswordConf').val();
    var tConfirmlogin = '<?=language('common/main/main','tModalConfirmlogin');?>';
    var tMsgConfirm   = tConfirmlogin;

    if(tPassOld == '' || tPassOld == null || tPassNew == '' || tPassNew == null){
        if($('#oetPasswordOld').val() == '' || $('#oetPasswordOld').val() == null){
            $('#oetPasswordOld').focus();
        }else{
            $('#oetPasswordNew').focus();
        }
    }else if(tPassOld == tPassNew){   // ถ้าเปลี่ยน Password ใหม่ แล้ว เหมือนกับ Password เก่า จะไม่อณุญาติ  (Request จาก Tester พี่เล้ง) 
        $('#odlChgPassword').show();
    }else if(tPassNew != tPassConf){
        $('#odlChgPasswordConf').show();
    }else{

        tApprove = false;
        //ถ้า TYPE : PIN
        if($('#ohdtypeChangePassword').val() == 2){
            if($('#oetPasswordNew').val().length < 6){
                $('#odlChkDegitPassword').text('กรุณากรอกรหัสขั้นต่ำ 6 ตัวอักษร');
                $('#odlChkDegitPassword').show(); // เช็ค Password ถ้า key ถึง 6 degit (Bell)
                return;
            }else{
                var tApprove = true;
            }
        }else{
            //ถ้า TYPE : PASSWORD + OTHER
            if($('#oetPasswordNew').val().length < 8){   
                $('#odlChkDegitPassword').text('กรุณากรอกรหัสขั้นต่ำ 8 ตัวอักษร');
                $('#odlChkDegitPassword').show(); // เช็ค Password ถ้า key ถึง 8 degit (Bell)
                return;
            }else{
                var tApprove = true;
            }
        }


        if(tApprove == true){
            var tEncPasswordOld = JCNtAES128EncryptData(tPassOld, tKey, tIV);
            var tEncPasswordNew = JCNtAES128EncryptData(tPassNew, tKey, tIV);

            $.ajax({
                type: "POST",
                url: "cmmUSREventChangePassword",
                data: { 
                    ptPasswordOld : tEncPasswordOld,
                    ptPasswordNew : tEncPasswordNew,
                    pnChkUsrSta   : pnStaAct
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturn = JSON.parse(oResult);
                    // console.log(aReturn);
                    if(aReturn['nCode'] == '1'){
                        console.log('LOG >> change password success');
                        $('#odlPasswordNomatch').css("display", "none");
                        $('#odvmodalChangePassword').modal("toggle");
                        var tMsgConfirm   = tConfirmlogin;
                        FSvCMNMsgSucessDialog('<p class="text-left">'+tMsgConfirm+'</p>');
                        setTimeout(function(){
                            document.location = 'logout';
                        }, 1000);
                    }else{
                        console.log('LOG >> error change password');
                        $('#odlPasswordNomatch').css("display", "block");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    (jqXHR, textStatus, errorThrown);
                }
            });
        }
    }
}

</script>
