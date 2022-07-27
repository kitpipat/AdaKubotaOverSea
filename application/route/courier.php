<?php
    //Courier
    $route ['courier/(:any)/(:any)']        = 'courier/courier/Courier_controller/index/$1/$2';
    $route ['courierList']                  = 'courier/courier/Courier_controller/FSvCCRYListPage';
    $route ['courierDataTable']             = 'courier/courier/Courier_controller/FSvCCRYDataList';
    $route ['courierPageAdd']               = 'courier/courier/Courier_controller/FSvCCRYAddPage';
    $route ['courierPageEdit']              = 'courier/courier/Courier_controller/FSvCCRYEditPage';
    $route ['courierEventAdd']              = 'courier/courier/Courier_controller/FSoCCRYAddEvent';
    $route ['courierEventEdit']             = 'courier/courier/Courier_controller/FSoCCRYEditEvent';
    $route ['courierEventDelete']           = 'courier/courier/Courier_controller/FSoCCRYDeleteEvent';

    // //Courier Address
    $route ['courierAddressData']           = 'courier/courier/Courieraddress_controller/FSvCCRYAddressData';
    $route ['courierAddressDataTable']      = 'courier/courier/Courieraddress_controller/FSvCCRYAddressDataTable';
    $route ['courierAddressPageAdd']        = 'courier/courier/Courieraddress_controller/FSvCCRYAddressCallPageAdd';
    $route ['courierAddressPageEdit']       = 'courier/courier/Courieraddress_controller/FSvCCRYAddressCallPageEdit';
    $route ['courierAddressAddEvent']       = 'courier/courier/Courieraddress_controller/FSoCCRYAddressAddEvent';
    $route ['courierAddressEditEvent']      = 'courier/courier/Courieraddress_controller/FSoCCRYAddressEditEvent';
    $route ['courierAddressDeleteEvent']    = 'courier/courier/Courieraddress_controller/FSoCCRYAddressDeleteEvent';

    //CourierGrp
    $route ['courierGrp/(:any)/(:any)']     = 'courier/couriergrp/Couriergrp_controller/index/$1/$2';
    $route ['courierGrpList']               = 'courier/couriergrp/Couriergrp_controller/FSvCCGPListPage';
    $route ['courierGrpDataTable']          = 'courier/couriergrp/Couriergrp_controller/FSvCCGPDataList';
    $route ['courierGrpPageAdd']            = 'courier/couriergrp/Couriergrp_controller/FSvCCGPAddPage';
    $route ['courierGrpPageEdit']           = 'courier/couriergrp/Couriergrp_controller/FSvCCGPEditPage';
    $route ['courierGrpEventAdd']           = 'courier/couriergrp/Couriergrp_controller/FSoCCGPAddEvent';
    $route ['courierGrpEventEdit']          = 'courier/couriergrp/Couriergrp_controller/FSoCCGPEditEvent';
    $route ['courierGrpEventDelete']        = 'courier/couriergrp/Couriergrp_controller/FSoCCGPDeleteEvent';


    //CourierType
    $route ['courierType/(:any)/(:any)']     = 'courier/couriertype/Couriertype_controller/index/$1/$2';
    $route ['courierTypeList']               = 'courier/couriertype/Couriertype_controller/FSvCCTYListPage';
    $route ['courierTypeDataTable']          = 'courier/couriertype/Couriertype_controller/FSvCCTYDataList';
    $route ['courierTypePageAdd']            = 'courier/couriertype/Couriertype_controller/FSvCCTYAddPage';
    $route ['courierTypePageEdit']           = 'courier/couriertype/Couriertype_controller/FSvCCTYEditPage';
    $route ['courierTypeEventAdd']           = 'courier/couriertype/Couriertype_controller/FSoCCTYAddEvent';
    $route ['courierTypeEventEdit']          = 'courier/couriertype/Couriertype_controller/FSoCCTYEditEvent';
    $route ['courierTypeEventDelete']        = 'courier/couriertype/Couriertype_controller/FSoCCTYDeleteEvent';

    //CourierMan
    $route ['courierMan/(:any)/(:any)']      = 'courier/courierman/Courierman_controller/index/$1/$2';
    $route ['courierManList']                = 'courier/courierman/Courierman_controller/FSvCCurmanListPage';
    $route ['courierManDataTable']           = 'courier/courierman/Courierman_controller/FSvCCurmanDataList';
    $route ['courierManPageAdd']             = 'courier/courierman/Courierman_controller/FSvCCurAddPage';
    $route ['courierManEventAdd']            = 'courier/courierman/Courierman_controller/FSoCCurAddEvent';
    $route ['courierManPageEdit']            = 'courier/courierman/Courierman_controller/FSvCCurEditPage';
    $route ['courierManEventEdit']           = 'courier/courierman/Courierman_controller/FSoCCurEditEvent';
    $route ['courierManEventDelete']        = 'courier/courierman/Courierman_controller/FSoCCurDeleteEvent';
    $route ['courierManCheckTelDup']        = 'courier/courierman/Courierman_controller/FSoCCheckDuplicateTel';

    //Courier Login
    $route ['courierlogin']                 = 'courier/courierlogin/Courierlogin_controller/FSvCCourierloginMainPage';
    $route ['courierloginDataTable']        = 'courier/courierlogin/Courierlogin_controller/FSvCCURLogDataList';
    $route ['courierloginPageAdd']          = 'courier/courierlogin/Courierlogin_controller/FSvCCURlogPageAdd';
    $route ['courierloginEventAdd']         = 'courier/courierlogin/Courierlogin_controller/FSaCCURlogAddEvent';
    $route ['courierloginPageEdit']         = 'courier/courierlogin/Courierlogin_controller/FSvCCURlogPageEdit';
    $route ['courierloginEventEdit']        = 'courier/courierlogin/Courierlogin_controller/FSaCCURlogEditEvent';
    $route ['courierloginEventDelete']      = 'courier/courierlogin/Courierlogin_controller/FSaCCURlogDeleteEvent';
    $route ['courierloginEventDeleteMultiple']  = 'courier/courierlogin/Courierlogin_controller/FSoCCURLogDelMultipleEvent';
    
    //Validate
    $route ['courierloginCheckInputGenCode']    = 'courier/courierlogin/Courierlogin_controller/FSaMCURCheckDuplicate';