<style>
    #odvChangepasswordTopBar{
        padding: 10px 20px;
        cursor : pointer;
    }

    #odvChangepasswordTopBar:hover{
        background-color: #fafafa;
    }

    @media screen and (max-width: 767px){
        #odvChangepasswordTopBar{
            padding: 10px 15px !important;
        }
    }

    #oimImgPerson{
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: inline;
        margin-right: 5px;
        border: 1px solid #d8d8d8;
    }

/* Css Notification */
/* Create By witsarut 04/03/2020 */

    #odvCntMessage {
        display:block;
        position:absolute;
        background:#E1141E;
        color:#FFF;
        font-size:12px;
        font-weight:normal;
        padding:0px 6px;
        margin: 3px 0px 0px 18px;
        border-radius:2px;
        -moz-border-radius:2px;
        -webkit-border-radius:2px;
        z-index:1;
    }

    #oliContainer {
        position:relative;
    }

    #odvNotiMessageAlert {
        display:none;
        width:380px;
        position:absolute;
        top:55px;
        left:-356px;
        background:#FFF;
        border:solid 1px rgba(100, 100, 100, .20);
        -webkit-box-shadow:0 3px 8px rgba(0, 0, 0, .20);
        z-index: 0;
    }

    #odvNotiMessageAlert:before {
        content: '';
        display:block;
        width:0;
        height:0;
        color:transparent;
        border:10px solid #CCC;
        border-color:transparent transparent #f5f5f5;
        margin-top:-20px;
        margin-left:-800px;
    }
    .xCNShwAllMessage {
        background:#F6F7F8;
        padding:13px;
        font-size:12px;
        font-weight:bold;
        border-top:solid 1px rgba(100, 100, 100, .30);
        text-align:center;
    }

    .xCNShwAllMessage a {
        color:#3b5998;
    }

    .xCNShwAllMessage a:hover {
        background:#F6F7F8;
        color:#3b5998;
        text-decoration:underline;
    }

    .xCNMessageAlert {
        background      : #F6F7F8;
        font-weight     : bold;
        padding         : 15px;
        border          : 1px solid transparent;
        border-radius   : 4px;
    }

    .xCNBlockNoti{
        border      : 1px solid #dedede;
        background  : #fefefe;
        padding     : 10px;
        border-top  : 0px;
    }

</style>
<!-- WRAPPER -->
<div id="wrapper">
    <nav class="navbar navbar-default navbar-fixed-top" style="margin-left: 60px;">
        <div class="container-fluid">
            <div class="brand">
                <a href="<?php echo base_url();?>" >
                    <img src="<?php echo base_url();?>application/modules/common/assets/images/logo/adapos5_logo.png" alt="AdaFC Logo" class="img-responsive logo" style="padding:5px;width:90px;margin:-8px;">
                </a>
                <a href="<?php echo base_url();?>" >
                    <div style="padding:5px;margin:-8px;position:absolute;top:25%;left:35%;margin-left:-100px;width:40%;text-align: center;"><span id="spnCompanyName"></div>
                </a>
            </div>
            <div id="navbar-menu">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <?php if($this->session->userdata('tSesUsrImagePerson') == null){ ?>
                            <!-- ไม่มีภาพ -->
                            <?php $tPatchImg = base_url().'application/modules/common/assets/images/icons/Customer.png'; ?>
                            <img id="oimImgPerson" style="border: 0px !important;" class="img-responsive" src="<?php echo @$tPatchImg;?>">
                        <?php }else{
                            $tImage = $this->session->userdata('tSesUsrImagePerson');
                            $tImage = explode("application/modules",$tImage);
                            $tPatchImg = base_url('application/modules/').$tImage[1];
                            ?>
                            <img id="oimImgPerson" class="img-responsive" src="<?=$tPatchImg?>">
                        <?php }?>
                        <button  class="dropdown-toggle" data-toggle="dropdown" style="color: white;margin-top: 10px;margin-right: 10px;"><a><span><?php echo $this->session->userdata('tSesUsrUsername') ?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a></button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="MyProfile">
                                    <i class="lnr lnr-user"></i> <span><?php echo language('common/main/main','tMNUProfile')?></span>
                                </a>
                            </li>
                            <li>
                                <div id="odvChangepasswordTopBar" onClick="JCNxCallModalChangePassword(1);">
                                    <i class="lnr lnr-cog" style="vertical-align: middle;"></i>
                                    <span><?php echo language('common/main/main','tMNUChangePassword')?></span>
                                </div>
                            </li>
                            <li>
                                <a href="logout">
                                    <i class="lnr lnr-exit"></i> <span><?php echo language('common/main/main','tMNULogout')?></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="odvNavibarClearfixed" style="background:#FFFFFF;z-index:500"></div>

 <script>
    $(document).ready(function(){
        JSxGetNameCompany();
    });

    // call Company
    function JSxGetNameCompany(){
        $.ajax({
            type: "GET",
            url: "companyEventGetName",
            cache: false,
            timeout: 0,
            success: function(tResult) {
            var aReturn = JSON.parse(tResult);
            var tCompanyName = aReturn['raItems']['rtCmpName'];
            $('#spnCompanyName').html(tCompanyName);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                (jqXHR, textStatus, errorThrown);
            }
        });
    }
</script>
<?php include('application/modules/common/views/script/jChangePassword.php'); ?>
