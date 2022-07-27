<?php
//พี่รัตน์บอกให้ใช้ route sale (8 ตุลาคม 2562)

//ออกใบกำกับภาษีเต็มรูป
$route['TaxinvoiceABB/(:any)/(:any)']          = 'sale/taxinvoice/Taxinvoice_controller/index/$1/$2';
$route['TaxinvoiceABBList']                    = 'sale/taxinvoice/Taxinvoice_controller/FSvCTAXListPage';
$route['TaxinvoiceABBTable']                   = 'sale/taxinvoice/Taxinvoice_controller/FSvCTAXDataTable';

// พิมพ์เอกสาร EJ
$route['dcmReprintEJ/(:any)/(:any)']            = 'sale/reprintej/Reprintej_controller/index/$1/$2';
$route['dcmReprintEJCallPageMainFormPrint']     = 'sale/reprintej/Reprintej_controller/FSvCEJCallPageMainFormPrint';
$route['dcmReprintEJFilterDataABB']             = 'sale/reprintej/Reprintej_controller/FSoCEJGetDataAbbInDB';
$route['dcmReprintEJCallPageRenderPrintABB']    = 'sale/reprintej/Reprintej_controller/FSoCEJCallPageRenderPrintABB';

// จองช่องฝากของ
$route['salBookingLocker/(:any)/(:any)']       = 'sale/bookinglocker/Bookinglocker_controller/index/$1/$2';
$route['salBookingLockerPageMain']             = 'sale/bookinglocker/Bookinglocker_controller/FSvCBKLCallPageMain';
$route['salBookingLockerGetViewRack']          = 'sale/bookinglocker/Bookinglocker_controller/FSvCBKLGetViewRack';
$route['salBookingLockerGetModalBooking']      = 'sale/bookinglocker/Bookinglocker_controller/FSvCBKLGetViewBooking';
$route['salBookingLockerConfirmBookingLocker'] = 'sale/bookinglocker/Bookinglocker_controller/FSoCBKLConfirmBookingLocker';
$route['salBookingLockerCancelBookingLocker']  = 'sale/bookinglocker/Bookinglocker_controller/FSoCBKLCancelBookingLocker';
$route['salBookingLockerDeleteQueues']         = 'sale/bookinglocker/Bookinglocker_controller/FSoCBKLDeleteQueue';

// Dash Board Sale
$route['dashboardsale/(:any)/(:any)']          = 'sale/dashboardsale/Dashboardsale_controller/index/$1/$2';
$route['dashboardsaleMainPage']                = 'sale/dashboardsale/Dashboardsale_controller/FSvCDSHSALMainPage';
$route['dashboardsaleCallModalFilter']         = 'sale/dashboardsale/Dashboardsale_controller/FSvCDSHSALCallModalFilter';
$route['dashboardsaleConfirmFilter']           = 'sale/dashboardsale/Dashboardsale_controller/FSvCDSHSALConfirmFilter';
$route['dashboardsaleBillAllAndTotalSale']     = 'sale/dashboardsale/Dashboardsale_controller/FSoCDSHSALViewBillAllAndTotalSale';
$route['dashboardsaleTotalSaleByRecive']       = 'sale/dashboardsale/Dashboardsale_controller/FSvCDSHSALViewTotalSaleByRecive';
$route['dashboardsalePdtStockBarlance']        = 'sale/dashboardsale/Dashboardsale_controller/FSvCDSHSALViewPdtStockBarlance';
$route['dashboardsaleTopTenNewPdt']            = 'sale/dashboardsale/Dashboardsale_controller/FSvCDSHSALViewTopTenNewPdt';
$route['dashboardsaleTotalSaleByPdtGrp']       = 'sale/dashboardsale/Dashboardsale_controller/FSvCDSHSALViewTotalSaleByPdtGrp';
$route['dashboardsaleTotalSaleByPdtPty']       = 'sale/dashboardsale/Dashboardsale_controller/FSvCDSHSALViewTotalSaleByPdtPty';
$route['dashboardsaleTopTenBestSeller']        = 'sale/dashboardsale/Dashboardsale_controller/FSvCDSHSALViewTopTenBestSaller';
$route['dashboardsaleTotalByBranch']           = 'sale/dashboardsale/Dashboardsale_controller/FSvCDSHSALViewTotalByBranch';
$route['dashboardsaleTopTenBestSellerByValue']        = 'sale/dashboardsale/Dashboardsale_controller/FSvCDSHSALViewTopTenBestSallerByValue';

// Dash Board Modal Config
$route['dashboardsaleCallModalConfigPage']     = 'sale/dashboardsale/Dashboardsale_controller/FSvCDSHSALCallModalConfigPage';
$route['dashboardsaleCallModalConfigPageSaveCookie']     = 'sale/dashboardsale/Dashboardsale_controller/FSvCDSHSALCallModalConfigPageSaveCookie';


// Dash Board Sale
$route['salemonitor/(:any)/(:any)']          = 'sale/salemonitor/Salemonitor_controller/index/$1/$2';
$route['salemonitorMainPage']                = 'sale/salemonitor/Salemonitor_controller/FSvCSMTSALMainPage';
$route['salemonitorCallModalFilter']         = 'sale/salemonitor/Salemonitor_controller/FSvCSMTSALCallModalFilter';
$route['salemonitorConfirmFilter']           = 'sale/salemonitor/Salemonitor_controller/FSvCSMTSALConfirmFilter';
$route['salemonitorCallSaleDataTable']       = 'sale/salemonitor/Salemonitor_controller/FSvCSMTCallSaleDataTable';
$route['salemonitorCallApiDataTable']        = 'sale/salemonitor/Salemonitor_controller/FSvCSMTCallApiDataTable';
$route['salemonitorCallMQRequestSaleData']   = 'sale/salemonitor/Salemonitor_controller/FSvCSMTCallMQRequestSaleData';
$route['salemonitorCallMQRequestApiData']    = 'sale/salemonitor/Salemonitor_controller/FSvCSMTCallMQRequestApiData';
$route['salemonitorRequestAPIInOnLine']      = 'sale/salemonitor/Salemonitor_controller/FSaCSMTRequestAPIIsOnLine';

// MQ Information
$route['dasMQICallMianPage']                 = 'sale/salemonitor/Mqinfomation_controller/FSvMQICallMainPage';
$route['dasMQICallDataTable']                = 'sale/salemonitor/Mqinfomation_controller/FSvMQICallDataTable';
$route['dasMQIEventReConsumer']              = 'sale/salemonitor/Mqinfomation_controller/FSvMQIEventReConsumer';

// Sale Tools
$route['dasSTLCallMianPage']                 = 'sale/salemonitor/Saletools_controller/FSvSTLCallMainPage';
$route['dasSTLCallDataTable']                = 'sale/salemonitor/Saletools_controller/FSvSTLCallDataTable';
$route['dasSTLEventRepair']                  = 'sale/salemonitor/Saletools_controller/FSvSTLEventRePair';


// Sale Import
$route['dasIMPCallMianPage']                 = 'sale/salemonitor/Saleimportbill_controller/FSvCIMPCallMianPage';
$route['dasIMPCallPageFrom']                 = 'sale/salemonitor/Saleimportbill_controller/FSvCIMPCallPageFrom';
$route['dasIMPCallDataTable']                = 'sale/salemonitor/Saleimportbill_controller/FSvCIMPCallDataTable';
$route['dasIMPUploadFile']                   = 'sale/salemonitor/Saleimportbill_controller/FSaCIMPUploadFile';
$route['dasIMPLoadDatatable']                = 'sale/salemonitor/Saleimportbill_controller/FSvCIMPLoadDatatable';
$route['dasIMPInsertBillData']               = 'sale/salemonitor/Saleimportbill_controller/FSaCIMPInsertBillData';
