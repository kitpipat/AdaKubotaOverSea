<?php

    //Functionality: Notifications (กระดิ่ง)
    // Create By Witsarut 03/03/2020
    function FCNxHNotifications(){
        $ci = &get_instance();
        $ci->load->database();

        $tMessageAlert = language('common/main/main', 'tMessageAlert');

        $oOnclick = "JSxEventClickNotiRead()";
        $tNotifications = '<li id="oliContainer" >';
        $tNotifications .='<div id="odvCntMessage"></div>';
        $tNotifications .='<button id="obtNotibtn" class="dropdown-toggle" data-toggle="dropdown" style="color: white;margin-top: 10px;margin-right:30px;" onclick="'.$oOnclick.'">'; 
        $tNotifications .='<img src="application/modules/common/assets/images/icons/Bell.png" alt="AdaFC Logo" class="img-responsive logo" style="padding:5px;width:30px;">';
        $tNotifications .='</button>'; 
        $tNotifications .='<div id="odvNotiMessageAlert">';
        $tNotifications .='<div class="xCNMessageAlert">'.$tMessageAlert.'</div>';
        $tNotifications .='<div id="odvMessageShow" style="height:350px;  overflow-y: scroll;"></div>';
        $tNotifications .='<div class="xCNShwAllMessage"></div>';
        $tNotifications .='</div>';
        $tNotifications .= '</li>';

        echo $tNotifications;
    }
?>
