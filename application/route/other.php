<?php
    // Reason (เหตุผล)
    $route ['reason/(:any)/(:any)']     = 'other/reason/Reason_controller/index/$1/$2';
    $route ['reasonList']               = 'other/reason/Reason_controller/FSvRSNListPage';
    $route ['reasonDataTable']          = 'other/reason/Reason_controller/FSvRSNDataList';
    $route ['reasonPageAdd']            = 'other/reason/Reason_controller/FSvRSNAddPage';
    $route ['reasonEventAdd']           = 'other/reason/Reason_controller/FSaRSNAddEvent';
    $route ['reasonPageEdit']           = 'other/reason/Reason_controller/FSvRSNEditPage';
    $route ['reasonEventEdit']          = 'other/reason/Reason_controller/FSaRSNEditEvent';
    $route ['reasonEventDelete']        = 'other/reason/Reason_controller/FSaRSNDeleteEvent';	
    // $route ['reasonEventDelete']        = 'other/reason/Reason_controller/FSaRSNDeleteEvent';	

?>