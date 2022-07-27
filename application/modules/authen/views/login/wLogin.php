<!doctype html>
<html lang="th" class="fullscreen-bg">
<head>
    <title>Login | <?php echo BASE_TITLE; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url();?>application/modules/authen/assets/images/AdaLogo.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>application/modules/authen/assets/images/AdaLogo.png">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>application/modules/authen/assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>application/modules/authen/assets/vendor/bootstrap/css/bootstrap.custom.css">
	<link rel="stylesheet" href="<?php echo base_url();?>application/modules/authen/assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>application/modules/authen/assets/vendor/linearicons/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>application/modules/authen/assets/vendor/chartist/css/chartist-custom.css">
    <!-- MAIN CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>application/modules/authen/assets/css/main.css">
    <!-- Login CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>application/modules/authen/assets/css/localcss/ada.login.css">
    <link rel="stylesheet" href="<?php echo base_url();?>application/modules/common/assets/css/localcss/ada.component.css">
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" href="<?php echo base_url();?>application/modules/authen/assets/css/demo.css">
    <!-- jquery -->
    <script src="<?php echo base_url();?>application/modules/authen/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>application/modules/authen/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <style>
        body{
            background-image: url('application/modules/common/assets/images/bg/SKC-Backoffice.png');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        .xWLoginBox{
            border-radius: 5px !important;
        }

        .xWLoginBox {
            -webkit-box-shadow: 0px 0px 105px -23px rgba(0,0,0,1);
            -moz-box-shadow: 0px 0px 105px -23px rgba(0,0,0,1);
            box-shadow: 0px 0px 43px -25px rgba(0,0,0,1)
        }
    </style>
</head>
<body>
    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="vertical-align-wrap">
            <div class="vertical-align-middle">
                <div class="auth-box lockscreen clearfix xWLoginBox">
                    <div class="content">
                        <div class="logo text-center">
                            <img src="<?php echo base_url();?>application/modules/authen/assets/images/adastatdose.png" alt="Ada Logo">
                        </div>
                        <!-- <form class="form-auth-small" onclick="JSxCheckLogin();" action="Checklogin" method="POST"> -->
                        <form class="form-auth-small" method="POST">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="signin-email" class="control-label sr-only"><?php echo language('authen/login/login', 'tUsernameCode');?></label>
                                        <input type="text" required  oninvalid="this.setCustomValidity('<?php echo language('authen/login/login', 'tRequireUsr');?>')" oninput="setCustomValidity('')" class="form-control xWCtlForm xWCanEnter" id="oetUsername" name="oetUsername" placeholder="<?php echo language('authen/login/login', 'tUsernameCode');?>">
                                        <span id="ospvalidateName" style="float:right; color: #f95353 !important;"><?php echo language('common/main/main', 'tCommonPlsEnterUserName');?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="signin-password" class="control-label sr-only"><?php echo language('authen/login/login', 'tPassword');?></label>
                                        <input type="password" required oninvalid="this.setCustomValidity('<?php echo language('authen/login/login', 'tRequirePw');?>')" oninput="setCustomValidity('')" class="form-control xWCtlForm xWCanEnter" id="oetPassword" name="oetPassword" placeholder="<?php echo language('authen/login/login', 'tPassword');?>">
                                        <input type="hidden" id="oetPasswordhidden" name="oetPasswordhidden">
                                        <span id="ospvalidatePassword" style="float:right; color: #f95353 !important;"><?php echo language('common/main/main', 'กรุณากรอกรหัสผ่าน');?></span>
                                    </div>
                                    <span id="ospUsrOrPwNotCorrect" style="float:right; color: #f95353 !important;"><?php echo language('common/main/main', 'tValiNameOrPasswordNotCorrect');?></span>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <!-- <div class="form-group clearfix">
                                        <label class="fancy-checkbox element-left">
                                            <input type="checkbox">
                                            <span><?php echo language('authen/login/login', 'tRememberMe');?></span>
                                        </label>
                                    </div> -->
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
                                    <div class="form-group dropdown" >
                                        <?php
                                            $nPicLang = @$_SESSION["tLangEdit"];
                                            if($nPicLang == ''){
                                                $nPicLang = '1';
                                            }
                                        ?>
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                            <!-- <img src="<?php echo  base_url('application/modules/authen/assets/images/use/').$nPicLang.'.png' ?>" style="height: 20px; width: 20px;">  -->
                                            <?php echo language('authen/login/login', 'tLanguageType');?> <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="<?php echo  base_url('ChangeLang/th/1'); ?>">
                                                    <!-- <img src="<?php echo  base_url('application/modules/authen/assets/images/flags/th.png')?>" style="height: 20px; width: 20px;"> -->
                                                    <?php echo language('authen/login/login', 'tLanguageType1');?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo  base_url('ChangeLang/en/2'); ?>">
                                                    <!-- <img src="<?php echo  base_url('application/modules/authen/assets/images/flags/en.png')?>" style="height: 20px; width: 20px;"> -->
                                                    <?php echo language('authen/login/login', 'tLanguageType2');?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <!-- <button type="submit" class="btn xWCtlBtn"><span style="color:#0081c2;"><?php echo language('authen/login/login', 'tLogin');?></span></button> -->
                                    <button type="button" id="obtLOGConfirmLogin" class="btn xWCtlBtn"><span style="color:#0081c2;"><?php echo language('authen/login/login', 'tLogin');?></span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END WRAPPER -->

    <!-- Create By Witsarut 18/06/20
    Modal Info Message Confirm
    Message Modal Confirm for login and ChangePassword -->
    <div class="modal fade" id="odvModalInfoMessageFrm" data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
        <div class="modal-dialog" role="document" style="width: 450px; margin: 1.75rem auto;top:20%;">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <h3 style="font-size:20px;color:#08f93e;font-weight: 1000;"><i class="fa fa-info"></i> <span id="ospHeader"></span></h3>
                </div>
                <div class="modal-body">
                    <div class="xCNMessage"></div>
                    <div class="clearfix"></div>
                    <div class="text-center">
                        <div
                            class="ldBar label-center"
                            style="width:50%;height:50%;margin:auto;"
                            data-value="0"
                            data-preset="circle"
                            data-stroke="#21bd35"
                            data-stroke-trail="#b2f5be"
                            id="odvIdBar">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="xCNTextResponse"></div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

</body>
</html>
<!--Key Password-->
<script type="text/javascript" src="<?php echo base_url() ?>application/modules/authen/assets/js/global/PasswordAES128/aes.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>application/modules/authen/assets/js/global/PasswordAES128/cAES128.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>application/modules/authen/assets/js/global/PasswordAES128/AESKeyIV.js"></script>
<script>

    $('document').ready(function(){

        $('#ospUsrOrPwNotCorrect').hide();  // ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง
        $('#ospvalidateName').hide(); // กรุณากรอกชื่อผู้ใช้
        $('#ospvalidatePassword').hide();  //กรุณากรอกรหัสผ่าน

        $('#oetUsername').focus();
    });

    $('.xWCanEnter').on('keypress',function(){
        $('#ospUsrOrPwNotCorrect').hide(); // ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง
        $('#ospvalidateName').hide();  // กรุณากรอกชื่อผู้ใช้
        $('#ospvalidatePassword').hide(); //กรุณากรอกรหัสผ่าน
        if(event.keyCode == 13){
            $('#obtLOGConfirmLogin').click();
        }
    });

    // function JSxCheckLogin(){
    //     var tOldPassword = $('#oetPassword').val();
    //     var tEncPassword = JCNtAES128EncryptData(tOldPassword, tKey, tIV);
    //     $('#oetPasswordhidden').val(tEncPassword);
    // }

    // Last Update By Napat(Jame) 22/05/2020
    // เพิ่มเช็คเงื่อนไข input username and password ต้องไม่ใช่เท่ากับว่าง
    $('#obtLOGConfirmLogin').off('click');
    $('#obtLOGConfirmLogin').on('click',function(){

        var tUsername    = $('#oetUsername').val();
        var tOldPassword = $('#oetPassword').val();
        var tEncPassword = JCNtAES128EncryptData(tOldPassword, tKey, tIV);

        if(tUsername != "" && tOldPassword != ""){
            $.ajax({
                type: "POST",
                url: "Checklogin",
                data: {
                    'oetUsername'           : tUsername,
                    'oetPasswordhidden'     : tEncPassword
                },
                cache: false,
                timeout	: 0,
                success: function (oResult){
                    var aReturn = $.parseJSON(oResult);
                    console.log(aReturn);

                    if(aReturn['nStaReturn'] == '1'){
                        location.reload();
                    }else if(aReturn['nStaReturn'] == '3'){
                        JCNxCallModalChangePassword(3);
                        //FTUsrLogType : 1 = รหัสผ่าน // 2 = PIN // 3 = RFID // 4 = QRCode
                        //Clear - ค่า
                        $('.xCNTextModalHeard').text('<?=language('common/main/main', 'tMNUChangePassword')?>');
                        $('#ohdtypeChangePassword').val('');
                        $('#oetPasswordNew').attr('maxlength','25');
                        $('#oetPasswordNew').attr('minlength','8');

                        //Set - ค่า
                        switch(aReturn.tUsrLogType) {
                            case "1":
                                var tChangeType = 'รหัสผ่าน';
                                break;
                            case "2":
                                var tChangeType = 'PIN';
                                $('#oetPasswordNew').attr('maxlength','6');
                                $('#oetPasswordNew').attr('minlength','6');
                                break;
                            case "3":
                                var tChangeType = 'RFID';
                                break;
                            case "4":
                                var tChangeType = 'QRCode';
                                break;
                            default:
                                var tChangeType = 'รหัสผ่าน';
                        }

                        $('.xCNTextModalHeard').text('<?=language('common/main/main', 'tMNUChangePassword')?>ประเภท : ' + tChangeType);
                        $('#ohdtypeChangePassword').val(aReturn.tUsrLogType);
                    }else{
                        $('#ospUsrOrPwNotCorrect').show();  // ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง
                        // location.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            if(tUsername == ""){
                $('#ospvalidateName').show();   // กรุณากรอกชื่อผู้ใช้
                $('#ospUsrOrPwNotCorrect').hide();  // ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง
                // $('#oetUsername').focus();
            }else{
                $('#ospvalidatePassword').show();  //กรุณากรอกรหัสผ่าน
                $('#ospUsrOrPwNotCorrect').hide();  // ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง
                // $('#oetPassword').focus();
            }
        }

    });

</script>

<?php include('application/modules/common/views/script/jChangePassword.php'); ?>
