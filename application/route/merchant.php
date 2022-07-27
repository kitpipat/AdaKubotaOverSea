<?php

//Merchant ผู้ประกอบการ
$route ['merchant/(:any)/(:any)']    = 'merchant/merchant/Merchant_controller/index/$1/$2';
$route ['merchantList']              = 'merchant/merchant/Merchant_controller/FSvCMerchantListPage';
$route ['merchantDataTable']         = 'merchant/merchant/Merchant_controller/FSvCMerchantDataList';
$route ['merchantPageAdd']           = 'merchant/merchant/Merchant_controller/FSvCMerchantAddPage';
$route ['merchantPageEdit']          = 'merchant/merchant/Merchant_controller/FSvMCNEditPage';
$route ['merchantEventAdd']          = 'merchant/merchant/Merchant_controller/FSaMCNAddEvent';
$route ['merchantEventEdit']         = 'merchant/merchant/Merchant_controller/FSaMCNEditEvent';
$route ['merchantEventDelete']       = 'merchant/merchant/Merchant_controller/FSaMCNDeleteEvent';

$route ['merchantAddressDataTable']     = 'merchant/merchant/Merchant_controller/FSvCMerchantAddressDataTable';
$route ['merchantPageAddAddress']       = 'merchant/merchant/Merchant_controller/FSvCMerchantAddressCallPageAdd';
$route ['merchantAddressPageEdit']      = 'merchant/merchant/Merchant_controller/FSvCMerchantAddressCallPageEdit';
$route ['merchantEventAddAddress']      = 'merchant/merchant/Merchant_controller/FSaCMerchantAddressAddEvent';
$route ['merchantEventEditAddress']     = 'merchant/merchant/Merchant_controller/FSaCMerchantAddressEditEvent';
$route ['merchantAddressEventDelete']   = 'merchant/merchant/Merchant_controller/FSoCMerchantAddressDeleteEvent';