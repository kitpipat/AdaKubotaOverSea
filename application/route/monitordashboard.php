<?php defined ('BASEPATH') or exit ( 'No direct script access allowed' );

// Pos 
$route ['posSaleInforDashboard']            = 'monitordashboard/pos/Possaleinfor_controller/index';
$route ['posSaleInforChart']                = 'monitordashboard/pos/Possaleinfor_controller/FSxCDisplaySaleChartInfor';
$route ['posSaleInforGetInfor']             = 'monitordashboard/pos/Possaleinfor_controller/FSxCGetInforDashBoard';
$route ['posSaleInforAddInforByMQ']         = 'monitordashboard/pos/Possaleinfor_controller/FSxCAddInforByMQ';
$route ['posSaleInforLoadPdtBestSale']      = 'monitordashboard/pos/Possaleinfor_controller/FSxCLoadPdtBestSale';

// Vd
$route ['VdSaleInforDashboard']             = 'monitordashboard/vending/Vdsaleinfor_controller/index';
$route ['VdSaleInforChart']                 = 'monitordashboard/vending/Vdsaleinfor_controller/FSxCDisplaySaleChartInfor';
$route ['VdSaleInforGetInfor']              = 'monitordashboard/vending/Vdsaleinfor_controller/FSxCGetInforDashBoard';
$route ['VdSaleInforAddInforByMQ']          = 'monitordashboard/vending/Vdsaleinfor_controller/FSxCAddInforByMQ';
$route ['VdSaleInforLoadPdtBestSale']       = 'monitordashboard/vending/Vdsaleinfor_controller/FSxCLoadPdtBestSale';
$route ['VdSaleInforLoadHistoryPosSale']    = 'monitordashboard/vending/Vdsaleinfor_controller/FSxCLoadHistoryPosSale';
$route ['VdSaleInforGetMerChant']           = 'monitordashboard/vending/Vdsaleinfor_controller/FSxCGetMerChantInfor';
$route ['VdSaleInforGetShop']               = 'monitordashboard/vending/Vdsaleinfor_controller/FSxCGetShopInfor';
$route ['VdSaleInforVDDetail']              = 'monitordashboard/vending/Vdsaleinfor_controller/FSxCVDDetail';
$route ['VdSaleInforGetHistoryPosSale']     = 'monitordashboard/vending/Vdsaleinfor_controller/FSxCGetHistoryPosSale';

// Locker
$route ['lockerInforDashboard']             = 'monitordashboard/locker/Lockerinfor_controller/index';
$route ['lockerInforGetDataLockerStatus']   = 'monitordashboard/locker/Lockerinfor_controller/FSoCDLKDataLockerStatus';