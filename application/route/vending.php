<?php

//Vending Shop Layout , (รูปแบบตู้สินค้า)
$route ['VendingShopLayout/(:any)/(:any)']     = 'vending/vendingshoplayout/Vendingshoplayout_controller/index/$1/$2';
$route ['VendingShopLayoutList']               = 'vending/vendingshoplayout/Vendingshoplayout_controller/FSvVSLListPage';
$route ['VendingShopLayoutDataTable']          = 'vending/vendingshoplayout/Vendingshoplayout_controller/FSvVSLDataList';
$route ['VendingShopLayoutPageAdd']            = 'vending/vendingshoplayout/Vendingshoplayout_controller/FSvVSLAddPage';
$route ['VendingShopLayoutEventAdd']           = 'vending/vendingshoplayout/Vendingshoplayout_controller/FSaVSLAddEvent';
$route ['VendingShopLayoutPageEdit']           = 'vending/vendingshoplayout/Vendingshoplayout_controller/FSvVSLEditPage';
$route ['VendingShopLayoutEventEdit']          = 'vending/vendingshoplayout/Vendingshoplayout_controller/FSaVSLEditEvent';
$route ['VendingShopLayoutEventDelete']        = 'vending/vendingshoplayout/Vendingshoplayout_controller/FSaVSLDeleteEvent';
$route ['VendingShopLayoutEventDeleteColandUpdate'] = 'vending/vendingshoplayout/Vendingshoplayout_controller/FSaVSLEditEventandDeleteCol';


//manage product
$route ['VendingmanagePageAdd']                = 'vending/vendingshoplayout/Vendingmanage_controller/FSaVSLManagePageADD';
$route ['VendingmanageEventAdd']               = 'vending/vendingshoplayout/Vendingmanage_controller/FSaVSLManageEventADD';

//Vending Shop Layout , (รูปแบบตู้สินค้า) NewUI 9 ตุลา 2019
$route ['VendingLayout']                    = 'vending/vendinglayout/Vendinglayout_controller/index';
$route ['VendingLayoutList']                = 'vending/vendinglayout/Vendinglayout_controller/FSvVEDListPage';
$route ['VendingLayoutInsertSetting']       = 'vending/vendinglayout/Vendinglayout_controller/FSvVEDInsertSetting';
$route ['VendingLayoutSelectSetting']       = 'vending/vendinglayout/Vendinglayout_controller/FSvVEDSelectSetting';
$route ['VendingLayoutInsertDiagram']       = 'vending/vendinglayout/Vendinglayout_controller/FSxVEDInsertDiagram';


////////////////////////////////////////////////////////////// แก้ไข้ใหม่ STAT DOSE 17/01/2020

//ชั้นตู้ Cabinet
$route ['VendingCabinet']                   = 'vending/Cabinet/Cabinet_controller/FSvCVDCMain';
$route ['VendingCabinetPageAdd']            = 'vending/Cabinet/Cabinet_controller/FSvCVDCPageAdd';
$route ['VendingCabinetList']               = 'vending/Cabinet/Cabinet_controller/FSvCVDCListPage';
$route ['VendingCabinetDataTable']          = 'vending/Cabinet/Cabinet_controller/FSvVSTDataList';
$route ['VendingCabinetEventAdd']           = 'vending/Cabinet/Cabinet_controller/FSaVSTAddEvent';
$route ['VendingCabinetPageEdit']           = 'vending/Cabinet/Cabinet_controller/FSvVSTEditPage';
$route ['VendingCabinetEventEdit']          = 'vending/Cabinet/Cabinet_controller/FSaVSTEditEvent';
$route ['VendingCabinetEventDelete']        = 'vending/Cabinet/Cabinet_controller/FSaVSTDeleteEvent';


//Vending Shop Type , (ประเภทตู้สินค้า)
$route ['VendingShopType/(:any)/(:any)']     = 'vending/vendingshoptype/Vendingshoptype_controller/index/$1/$2';
$route ['VendingShopTypeList']               = 'vending/vendingshoptype/Vendingshoptype_controller/FSvVSTListPage';
$route ['VendingShopTypeDataTable']          = 'vending/vendingshoptype/Vendingshoptype_controller/FSvVSTDataList';
$route ['VendingShopTypePageAdd']            = 'vending/vendingshoptype/Vendingshoptype_controller/FSvVSTAddPage';
$route ['VendingShopTypeEventAdd']           = 'vending/vendingshoptype/Vendingshoptype_controller/FSaVSTAddEvent';
$route ['VendingShopTypePageEdit']           = 'vending/vendingshoptype/Vendingshoptype_controller/FSvVSTEditPage';
$route ['VendingShopTypeEventEdit']          = 'vending/vendingshoptype/Vendingshoptype_controller/FSaVSTEditEvent';
$route ['VendingShopTypeEventDelete']        = 'vending/vendingshoptype/Vendingshoptype_controller/FSaVSTDeleteEvent';


//Shop Layout
$route ['VendingGetDTShopLayout']            = 'vending/vendinglayout/Vendinglayout_controller/FSxVEDGetPDTShopLayout';
$route ['VendingDeleteDiagram']              = 'vending/vendinglayout/Vendinglayout_controller/FSxVEDDeleteDiagram';


/* Create By Witsarut 26/02/2020
    Master ประเภทตู้สินค้า
*/
$route ['CabinetType/(:any)/(:any)']     = 'vending/cabinettype/Cabinettype_Controller/index/$1/$2';
$route ['CabinetTypeList']               = 'vending/cabinettype/Cabinettype_Controller/FSvCCBNListPage';
$route ['CabinetTypeDataTable']          = 'vending/cabinettype/Cabinettype_Controller/FSvCCBNDataList';
$route ['CabinetTypePageAdd']            = 'vending/cabinettype/Cabinettype_Controller/FSvCCBNAddPage';
$route ['CabinetTypePageEdit']           = 'vending/cabinettype/Cabinettype_Controller/FSvCCBNEditPage';
$route ['CabinetTypeEventAdd']           = 'vending/cabinettype/Cabinettype_Controller/FSoCCBNAddEvent';
$route ['CabinetTypeEventEdit']          = 'vending/cabinettype/Cabinettype_Controller/FSoCCBNEditEvent';
$route ['CabinetTypeEventDelete']        = 'vending/cabinettype/Cabinettype_Controller/FSoCCBNDeleteEvent';
$route ['CabinetTypeEventDeleteMultiple']  = 'vending/cabinettype/Cabinettype_Controller/FSoCCBNDelMultipleEvent';
