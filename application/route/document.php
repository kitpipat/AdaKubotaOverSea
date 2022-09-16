<?php

    date_default_timezone_set('Asia/Bangkok');

// Modal Browse Product Document
$route['BrowseGetPdtList']         = 'document/browseproduct/Browseproduct_controller/FMvCBWSPDTGetPdtList';
$route['BrowseGetPdtDetailList']   = 'document/browseproduct/Browseproduct_controller/FMvCBWSPDTGetPdtDetailList';

// Document Image Product
$route['DOCGetPdtImg']             = 'document/document/Document_controller/FMvCDOCGetPdtImg';

// ใบลดหนี้, ใบรับของ-ใบซื้อสินค้า/บริการ Center
$route['DOCEndOfBillCalVat'] = 'document/document/Docendofbill_controller/FStCDOCEndOfBillCalVat';
$route['DOCEndOfBillCal'] = 'document/document/Docendofbill_controller/FStCDOCEndOfBillCal';

// PO (เอกสารสั่งซื้อ)
$route['po/(:any)/(:any)']         = 'document/purchaseorder/Purchaseorder_controller/index/$1/$2';
$route['POFormSearchList']         = 'document/purchaseorder/Purchaseorder_controller/FSxCPOFormSearchList';
$route['POPageAdd']                = 'document/purchaseorder/Purchaseorder_controller/FSxCPOAddPage';
$route['POPageEdit']               = 'document/purchaseorder/Purchaseorder_controller/FSvCPOEditPage';
$route['POEventAdd']               = 'document/purchaseorder/Purchaseorder_controller/FSaCPOAddEvent';
$route['POEventEdit']              = 'document/purchaseorder/Purchaseorder_controller/FSaCPOEditEvent';
$route['POEventDelete']            = 'document/purchaseorder/Purchaseorder_controller/FSaCPODeleteEvent';
$route['PODataTable']              = 'document/purchaseorder/Purchaseorder_controller/FSxCPODataTable';
$route['POGetShpByBch']            = 'document/purchaseorder/Purchaseorder_controller/FSvCPOGetShpByBch';
$route['POAddPdtIntoTableDT']      = 'document/purchaseorder/Purchaseorder_controller/FSvCPOAddPdtIntoTableDT';
$route['POEditPdtIntoTableDT']     = 'document/purchaseorder/Purchaseorder_controller/FSvCPOEditPdtIntoTableDT';
$route['PORemovePdtInFile']        = 'document/purchaseorder/Purchaseorder_controller/FSvCPORemovePdtInFile';
$route['PORemoveAllPdtInFile']     = 'document/purchaseorder/Purchaseorder_controller/FSvCPORemoveAllPdtInFile';
$route['POAdvanceTableShowColList'] = 'document/purchaseorder/Purchaseorder_controller/FSvCPOAdvTblShowColList';
$route['POAdvanceTableShowColSave'] = 'document/purchaseorder/Purchaseorder_controller/FSvCPOShowColSave';
$route['POGetDTDisTableData']      = 'document/purchaseorder/Purchaseorder_controller/FSvCPOGetDTDisTableData';
$route['POAddDTDisIntoTable']      = 'document/purchaseorder/Purchaseorder_controller/FSvCPOAddDTDisIntoTable';
$route['PORemoveDTDisInFile']      = 'document/purchaseorder/Purchaseorder_controller/FSvCPORemoveDTDisInFile';
$route['POGetHDDisTableData']      = 'document/purchaseorder/Purchaseorder_controller/FSvCPOGetHDDisTableData';
$route['POAddHDDisIntoTable']      = 'document/purchaseorder/Purchaseorder_controller/FSvCPOAddHDDisIntoTable';
$route['PORemoveHDDisInFile']      = 'document/purchaseorder/Purchaseorder_controller/FSvCPORemoveHDDisInFile';
$route['POEditDTDis']              = 'document/purchaseorder/Purchaseorder_controller/FSvCPOEditDTDis';
$route['POSetSessionVATInOrEx']    = 'document/purchaseorder/Purchaseorder_controller/FSvCPOSetSessionVATInOrEx';
$route['POEditHDDis']              = 'document/purchaseorder/Purchaseorder_controller/FSvCPOEditHDDis';
$route['POGetAddress']             = 'document/purchaseorder/Purchaseorder_controller/FSvCPOGetShipAdd';
$route['POGetPdtBarCode']          = 'document/purchaseorder/Purchaseorder_controller/FSvCPOGetPdtBarCode';
$route['POPdtAdvanceTableLoadData'] = 'document/purchaseorder/Purchaseorder_controller/FSvCPOPdtAdvTblLoadData';
$route['POApprove']                = 'document/purchaseorder/Purchaseorder_controller/FSvCPOApprove';
$route['POCancel']                 = 'document/purchaseorder/Purchaseorder_controller/FSvCPOCancel';

// TFW (ใบโอนสินค้าระหว่างคลัง)
$route ['TFW/(:any)/(:any)']         = 'document/producttransferwahouse/Producttransferwahouse_controller/index/$1/$2';
$route ['TFWFormSearchList']         = 'document/producttransferwahouse/Producttransferwahouse_controller/FSxCTFWFormSearchList';
$route ['TFWPageAdd']                = 'document/producttransferwahouse/Producttransferwahouse_controller/FSxCTFWAddPage';
$route ['TFWPageEdit']               = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWEditPage';
$route ['TFWEventAdd']               = 'document/producttransferwahouse/Producttransferwahouse_controller/FSaCTFWAddEvent';
$route ['TFWCheckPdtTmpForTransfer'] = 'document/producttransferwahouse/Producttransferwahouse_controller/FSbCheckHaveProductForTransfer';
$route ['TFWCheckHaveProductInDT'] = 'document/producttransferwahouse/Producttransferwahouse_controller/FSbCheckHaveProductInDT';

$route ['TFWEventEdit']              = 'document/producttransferwahouse/Producttransferwahouse_controller/FSaCTFWEditEvent';
$route ['TFWEventDelete']            = 'document/producttransferwahouse/Producttransferwahouse_controller/FSaCTFWDeleteEvent';
$route ['TFWDataTable']              = 'document/producttransferwahouse/Producttransferwahouse_controller/FSxCTFWDataTable';
$route ['TFWGetShpByBch']            = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWGetShpByBch';
$route ['TFWAddPdtIntoTableDT']      = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWAddPdtIntoTableDT';
$route ['TFWEditPdtIntoTableDT']     = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWEditPdtIntoTableDT';
$route ['TFWRemovePdtInDTTmp']       = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWRemovePdtInDTTmp';
$route ['TFWRemovePdtInFile']        = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWRemovePdtInFile';
$route ['TFWRemoveAllPdtInFile']     = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWRemoveAllPdtInFile';
$route ['TFWAdvanceTableShowColList']= 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWAdvTblShowColList';
$route ['TFWAdvanceTableShowColSave']= 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWShowColSave';
$route ['TFWGetDTDisTableData']      = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWGetDTDisTableData';
$route ['TFWAddDTDisIntoTable']      = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWAddDTDisIntoTable';
$route ['TFWRemoveDTDisInFile']      = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWRemoveDTDisInFile';
$route ['TFWGetHDDisTableData']      = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWGetHDDisTableData';
$route ['TFWAddHDDisIntoTable']      = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWAddHDDisIntoTable';
$route ['TFWRemoveHDDisInFile']      = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWRemoveHDDisInFile';
$route ['TFWEditDTDis']              = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWEditDTDis';
$route ['TFWEditHDDis']              = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWEditHDDis';
$route ['TFWGetAddress']             = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWGetShipAdd';
$route ['TFWGetPdtBarCode']          = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWGetPdtBarCode';
$route ['TFWPdtAdvanceTableLoadData']= 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWPdtAdvTblLoadData';
$route ['TFWVatTableLoadData']       = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWVatLoadData';
$route ['TFWCalculateLastBill']      = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWCalculateLastBill';
$route ['TFWPdtMultiDeleteEvent']    = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWPdtMultiDeleteEvent';
$route ['TFWApprove']                = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWApprove';
$route ['TFWCancel']                 = 'document/producttransferwahouse/Producttransferwahouse_controller/FSvCTFWCancel';
$route ['TFWClearDocTemForChngCdt']  = 'document/producttransferwahouse/Producttransferwahouse_controller/FSxCTFXClearDocTemForChngCdt';
$route ['TFWCheckViaCodeForApv']  = 'document/producttransferwahouse/Producttransferwahouse_controller/FSxCTWXCheckViaCodeForApv';

// TFW (ใบโอนสินค้าระหว่างคลัง ตู้ VD) -
// $route ['TWXVD/(:any)/(:any)']         = 'document/producttransferwahousevd/Producttransferwahousevd_controller/index/$1/$2';
$route ['TWXVDFormSearchList']         = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSxCTFWFormSearchList';
$route ['TWXVDPageAdd']                = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSxCTFWAddPage';
$route ['TWXVDPageEdit']               = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWEditPage';
$route ['TWXVDEventAdd']               = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSaCTFWAddEvent';
$route ['TWXVDCheckPdtTmpForTransfer'] = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSbCheckHaveProductForTransfer';
$route ['TWXVDCheckHaveProductInDT'] = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSbCheckHaveProductInDT';

$route ['TWXVDEventEdit']              = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSaCTFWEditEvent';
$route ['TWXVDEventDelete']            = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSaCTFWDeleteEvent';
$route ['TWXVDDataTable']              = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSxCTFWDataTable';
$route ['TWXVDGetShpByBch']            = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWGetShpByBch';
$route ['TWXVDAddPdtIntoTableDT']      = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWAddPdtIntoTableDT';
$route ['TWXVDEditPdtIntoTableDT']     = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWEditPdtIntoTableDT';
$route ['TWXVDRemovePdtInDTTmp']       = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWRemovePdtInDTTmp';
$route ['TWXVDRemovePdtInFile']        = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWRemovePdtInFile';
$route ['TWXVDRemoveAllPdtInFile']     = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWRemoveAllPdtInFile';
$route ['TWXVDAdvanceTableShowColList']= 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWAdvTblShowColList';
$route ['TWXVDAdvanceTableShowColSave']= 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWShowColSave';
$route ['TWXVDGetDTDisTableData']      = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWGetDTDisTableData';
$route ['TWXVDAddDTDisIntoTable']      = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWAddDTDisIntoTable';
$route ['TWXVDRemoveDTDisInFile']      = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWRemoveDTDisInFile';
$route ['TWXVDGetHDDisTableData']      = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWGetHDDisTableData';
$route ['TWXVDAddHDDisIntoTable']      = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWAddHDDisIntoTable';
$route ['TWXVDRemoveHDDisInFile']      = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWRemoveHDDisInFile';
$route ['TWXVDEditDTDis']              = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWEditDTDis';
$route ['TWXVDEditHDDis']              = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWEditHDDis';
$route ['TWXVDGetAddress']             = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWGetShipAdd';
$route ['TWXVDGetPdtBarCode']          = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWGetPdtBarCode';
$route ['TWXVDPdtAdvanceTableLoadData']= 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWPdtAdvTblLoadData';
$route ['TWXVDVatTableLoadData']       = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWVatLoadData';
$route ['TWXVDCalculateLastBill']      = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWCalculateLastBill';
$route ['TWXVDPdtMultiDeleteEvent']    = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWPdtMultiDeleteEvent';
$route ['TWXVDApprove']                = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWApprove';
$route ['TWXVDCancel']                 = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSvCTFWCancel';
$route ['TWXVDClearDocTemForChngCdt']  = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSxCTFXClearDocTemForChngCdt';
$route ['TWXVDCheckViaCodeForApv']  = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSxCTWXCheckViaCodeForApv';
$route ['TWXVDPdtDtLoadToTem']  = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSxCTWXVDPdtDtLoadToTem';
$route ['TWXVDPdtUpdateTem']  = 'document/producttransferwahousevd/Producttransferwahousevd_controller/FSxCTWXVDPdtUpdateTem';

// TFW (ใบปรับสต็อก ตู้ VD)
$route ['ADJSTKVD/(:any)/(:any)']         = 'document/adjuststockvd/Producttransferwahousevd_controller/index/$1/$2';
$route ['ADJSTKVDFormSearchList']         = 'document/adjuststockvd/Producttransferwahousevd_controller/FSxCTFWFormSearchList';
$route ['ADJSTKVDPageAdd']                = 'document/adjuststockvd/Producttransferwahousevd_controller/FSxCTFWAddPage';
$route ['ADJSTKVDPageEdit']               = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWEditPage';
$route ['ADJSTKVDEventAdd']               = 'document/adjuststockvd/Producttransferwahousevd_controller/FSaCTFWAddEvent';
$route ['ADJSTKVDCheckPdtTmpForTransfer'] = 'document/adjuststockvd/Producttransferwahousevd_controller/FSbCheckHaveProductForTransfer';
$route ['ADJSTKVDCheckHaveProductInDT'] = 'document/adjuststockvd/Producttransferwahousevd_controller/FSbCheckHaveProductInDT';

$route ['ADJSTKVDEventEdit']              = 'document/adjuststockvd/Producttransferwahousevd_controller/FSaCTFWEditEvent';
$route ['ADJSTKVDEventDelete']            = 'document/adjuststockvd/Producttransferwahousevd_controller/FSaCTFWDeleteEvent';
$route ['ADJSTKVDDataTable']              = 'document/adjuststockvd/Producttransferwahousevd_controller/FSxCTFWDataTable';
$route ['ADJSTKVDGetShpByBch']            = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWGetShpByBch';
$route ['ADJSTKVDAddPdtIntoTableDT']      = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWAddPdtIntoTableDT';
$route ['ADJSTKVDEditPdtIntoTableDT']     = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWEditPdtIntoTableDT';
$route ['ADJSTKVDRemovePdtInDTTmp']       = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWRemovePdtInDTTmp';
$route ['ADJSTKVDRemovePdtInFile']        = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWRemovePdtInFile';
$route ['ADJSTKVDRemoveAllPdtInFile']     = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWRemoveAllPdtInFile';
$route ['ADJSTKVDAdvanceTableShowColList']= 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWAdvTblShowColList';
$route ['ADJSTKVDAdvanceTableShowColSave']= 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWShowColSave';
$route ['ADJSTKVDGetDTDisTableData']      = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWGetDTDisTableData';
$route ['ADJSTKVDAddDTDisIntoTable']      = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWAddDTDisIntoTable';
$route ['ADJSTKVDRemoveDTDisInFile']      = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWRemoveDTDisInFile';
$route ['ADJSTKVDGetHDDisTableData']      = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWGetHDDisTableData';
$route ['ADJSTKVDAddHDDisIntoTable']      = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWAddHDDisIntoTable';
$route ['ADJSTKVDRemoveHDDisInFile']      = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWRemoveHDDisInFile';
$route ['ADJSTKVDEditDTDis']              = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWEditDTDis';
$route ['ADJSTKVDEditHDDis']              = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWEditHDDis';
$route ['ADJSTKVDGetAddress']             = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWGetShipAdd';
$route ['ADJSTKVDGetPdtBarCode']          = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWGetPdtBarCode';
$route ['ADJSTKVDPdtAdvanceTableLoadData']= 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWPdtAdvTblLoadData';
$route ['ADJSTKVDVatTableLoadData']       = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWVatLoadData';
$route ['ADJSTKVDCalculateLastBill']      = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWCalculateLastBill';
$route ['ADJSTKVDPdtMultiDeleteEvent']    = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWPdtMultiDeleteEvent';
$route ['ADJSTKVDApprove']                = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWApprove';
$route ['ADJSTKVDCancel']                 = 'document/adjuststockvd/Producttransferwahousevd_controller/FSvCTFWCancel';
$route ['ADJSTKVDClearDocTemForChngCdt']  = 'document/adjuststockvd/Producttransferwahousevd_controller/FSxCTFXClearDocTemForChngCdt';
$route ['ADJSTKVDCheckViaCodeForApv']  = 'document/adjuststockvd/Producttransferwahousevd_controller/FSxCTWXCheckViaCodeForApv';
$route ['ADJSTKVDPdtDtLoadToTem']  = 'document/adjuststockvd/Producttransferwahousevd_controller/FSxCTWXVDPdtDtLoadToTem';
$route ['ADJSTKVDPdtUpdateTem']  = 'document/adjuststockvd/Producttransferwahousevd_controller/FSxCTWXVDPdtUpdateTem';

// ADJPL (ใบปรับราคาสินค้า ตู้ locker)
$route ['ADJPL/(:any)/(:any)']          = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/index/$1/$2';
$route ['ADJPLFormSearchList']          = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSxCTFWFormSearchList';
$route ['ADJPLPageAdd']                 = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSxCTFWAddPage';
$route ['ADJPLPageEdit']                = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWEditPage';
$route ['ADJPLEventAdd']                = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSaCTFWAddEvent';
$route ['ADJPLCheckPdtTmpForTransfer']  = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSbCheckHaveProductForTransfer';
$route ['ADJPLCheckHaveProductInDT']    = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSbCheckHaveProductInDT';
$route ['ADJPLEventEdit']               = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSaCTFWEditEvent';
$route ['ADJPLEventDelete']             = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSaCTFWDeleteEvent';
$route ['ADJPLDataTable']               = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSxCTFWDataTable';
$route ['ADJPLGetShpByBch']             = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWGetShpByBch';
$route ['ADJPLAddPdtIntoTableDT']       = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWAddPdtIntoTableDT';
$route ['ADJPLEditPdtIntoTableDT']      = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWEditPdtIntoTableDT';
$route ['ADJPLRemovePdtInDTTmp']        = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWRemovePdtInDTTmp';
$route ['ADJPLRemovePdtInFile']         = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWRemovePdtInFile';
$route ['ADJPLRemoveAllPdtInFile']      = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWRemoveAllPdtInFile';
$route ['ADJPLAdvanceTableShowColList'] = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWAdvTblShowColList';
$route ['ADJPLAdvanceTableShowColSave'] = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWShowColSave';
$route ['ADJPLGetDTDisTableData']       = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWGetDTDisTableData';
$route ['ADJPLAddDTDisIntoTable']       = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWAddDTDisIntoTable';
$route ['ADJPLRemoveDTDisInFile']       = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWRemoveDTDisInFile';
$route ['ADJPLGetHDDisTableData']       = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWGetHDDisTableData';
$route ['ADJPLAddHDDisIntoTable']       = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWAddHDDisIntoTable';
$route ['ADJPLRemoveHDDisInFile']       = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWRemoveHDDisInFile';
$route ['ADJPLEditDTDis']               = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWEditDTDis';
$route ['ADJPLEditHDDis']               = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWEditHDDis';
$route ['ADJPLGetAddress']              = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWGetShipAdd';
$route ['ADJPLGetPdtBarCode']           = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWGetPdtBarCode';
$route ['ADJPLPdtAdvanceTableLoadData'] = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWPdtAdvTblLoadData';
$route ['ADJPLVatTableLoadData']        = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWVatLoadData';
$route ['ADJPLCalculateLastBill']       = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWCalculateLastBill';
$route ['ADJPLPdtMultiDeleteEvent']     = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWPdtMultiDeleteEvent';
$route ['ADJPLApprove']                 = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWApprove';
$route ['ADJPLCancel']                  = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSvCTFWCancel';
$route ['ADJPLClearDocTemForChngCdt']   = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSxCTFXClearDocTemForChngCdt';
$route ['ADJPLCheckViaCodeForApv']      = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSxCTWXCheckViaCodeForApv';
$route ['ADJPLPdtDtLoadToTem']          = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSxCTWXVDPdtDtLoadToTem';
$route ['ADJPLPdtUpdateTem']            = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSxCTWXVDPdtUpdateTem';
$route ['ADJPLPdtGetRateInfor']         = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSxCADJPLPdtGetRateInfor';
$route ['ADJPLPdtGetRateDTInfor']       = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSxCADJPLPdtGetRateDTInfor';
$route ['ADJPLPdtSaveRateDTInTmp']      = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSxCADJPLPdtSaveRateDTInTmp';
$route ['ADJPLCheckDateTime']           = 'document/rentalproductpriceadjustmentlocker/Rentalproductpriceadjustmentlocker_controller/FSxCADJPLCheckDateTime';



// TBX (ใบโอนสินค้าระหว่างสาขา)
$route ['TBX/(:any)/(:any)']         = 'document/producttransferbranch/Producttransferbranch_controller/index/$1/$2';
$route ['TBXFormSearchList']         = 'document/producttransferbranch/Producttransferbranch_controller/FSxCTBXFormSearchList';
$route ['TBXPageAdd']                = 'document/producttransferbranch/Producttransferbranch_controller/FSxCTBXAddPage';
$route ['TBXPageEdit']               = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXEditPage';
$route ['TBXEventAdd']               = 'document/producttransferbranch/Producttransferbranch_controller/FSaCTBXAddEvent';
$route ['TBXCheckPdtTmpForTransfer'] = 'document/producttransferbranch/Producttransferbranch_controller/FSbCheckHaveProductForTransfer';
$route ['TBXCheckHaveProductInDT'] = 'document/producttransferbranch/Producttransferbranch_controller/FSbCheckHaveProductInDT';

$route ['TBXEventEdit']              = 'document/producttransferbranch/Producttransferbranch_controller/FSaCTBXEditEvent';
$route ['TBXEventDelete']            = 'document/producttransferbranch/Producttransferbranch_controller/FSaCTBXDeleteEvent';
$route ['TBXDataTable']              = 'document/producttransferbranch/Producttransferbranch_controller/FSxCTBXDataTable';
$route ['TBXAddPdtIntoTableDT']      = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXAddPdtIntoTableDT';
$route ['TBXEditPdtIntoTableDT']     = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXEditPdtIntoTableDT';
$route ['TBXRemovePdtInDTTmp']       = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXRemovePdtInDTTmp';
$route ['TBXRemovePdtInFile']        = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXRemovePdtInFile';
$route ['TBXRemoveAllPdtInFile']     = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXRemoveAllPdtInFile';
$route ['TBXAdvanceTableShowColList']= 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXAdvTblShowColList';
$route ['TBXAdvanceTableShowColSave']= 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXShowColSave';
$route ['TBXGetDTDisTableData']      = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXGetDTDisTableData';
$route ['TBXAddDTDisIntoTable']      = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXAddDTDisIntoTable';
$route ['TBXRemoveDTDisInFile']      = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXRemoveDTDisInFile';
$route ['TBXGetHDDisTableData']      = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXGetHDDisTableData';
$route ['TBXAddHDDisIntoTable']      = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXAddHDDisIntoTable';
$route ['TBXRemoveHDDisInFile']      = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXRemoveHDDisInFile';
$route ['TBXEditDTDis']              = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXEditDTDis';
$route ['TBXEditHDDis']              = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXEditHDDis';
$route ['TBXGetAddress']             = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXGetShipAdd';
$route ['TBXGetPdtBarCode']          = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXGetPdtBarCode';
$route ['TBXPdtAdvanceTableLoadData']= 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXPdtAdvTblLoadData';
$route ['TBXVatTableLoadData']       = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXVatLoadData';
$route ['TBXCalculateLastBill']      = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXCalculateLastBill';
$route ['TBXPdtMultiDeleteEvent']    = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXPdtMultiDeleteEvent';
$route ['TBXApprove']                = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXApprove';
$route ['TBXCancel']                 = 'document/producttransferbranch/Producttransferbranch_controller/FSvCTBXCancel';
$route ['TBXClearDocTemForChngCdt']  = 'document/producttransferbranch/Producttransferbranch_controller/FSxCTFXClearDocTemForChngCdt';
$route ['TBXCheckViaCodeForApv']  = 'document/producttransferbranch/Producttransferbranch_controller/FSxCTBXCheckViaCodeForApv';

// SalePriceAdj ใบปรับราคาขาย
$route['dcmSPA/(:any)/(:any)']             = 'document/salepriceadj/Salepriceadj_controller/index/$1/$2';
$route['dcmSPAMain']                       = 'document/salepriceadj/Salepriceadj_controller/FSvCSPAMainPage';
$route['dcmSPADataTable']                  = 'document/salepriceadj/Salepriceadj_controller/FSvCSPADataList';
$route['dcmSPAPageAdd']                    = 'document/salepriceadj/Salepriceadj_controller/FSvCSPAAddPage';
$route['dcmSPAPageEdit']                   = 'document/salepriceadj/Salepriceadj_controller/FSvCSPAEditPage';
$route['dcmSPAEventEdit']                  = 'document/salepriceadj/Salepriceadj_controller/FSoCSPAEditEvent';
$route['dcmSPAEventAdd']                   = 'document/salepriceadj/Salepriceadj_controller/FSoCSPAAddEvent';
$route['dcmSPAEventDelete']                = 'document/salepriceadj/Salepriceadj_controller/FSoCSPADeleteEvent';
$route['dcmSPAPdtPriDataTable']            = 'document/salepriceadj/Salepriceadj_controller/FSvCSPAPdtPriDataList'; // Get Pdt List
$route['dcmSPAPdtPriEventAddTmp']          = 'document/salepriceadj/Salepriceadj_controller/FSvCSPAPdtPriAddTmpEvent';
$route['dcmSPAPdtPriEventAddDT']           = 'document/salepriceadj/Salepriceadj_controller/FSvCSPAPdtPriAddDTEvent';
$route['dcmSPAPdtPriEventDelete']          = 'document/salepriceadj/Salepriceadj_controller/FSoCSPAPdtPriDeleteEvent';
$route['dcmSPAPdtPriEventDelAll']          = 'document/salepriceadj/Salepriceadj_controller/FSoCSPAProductDeleteAllEvent';
$route['dcmSPAPdtPriEventUpdPriTmp']       = 'document/salepriceadj/Salepriceadj_controller/FSoCSPAUpdatePriceTemp';
$route['dcmSPAGetBchComp']                 = 'document/salepriceadj/Salepriceadj_controller/FSoCSPAGetBchComp';
$route['dcmSPAAdvanceTableShowColList']    = 'document/salepriceadj/Salepriceadj_controller/FSvCSPAAdvTblShowColList';
$route['dcmSPAAdvanceTableShowColSave']    = 'document/salepriceadj/Salepriceadj_controller/FSvCSPAShowColSave';
$route['dcmSPAOriginalPrice']              = 'document/salepriceadj/Salepriceadj_controller/FSoCSPAOriginalPrice';
$route['dcmSPAPdtPriAdjust']               = 'document/salepriceadj/Salepriceadj_controller/FSoCSPAPdtPriAdjustEvent';
$route['dcmSPAEventApprove']               = 'document/salepriceadj/Salepriceadj_controller/FSoCSPAApproveEvent';
$route['dcmSPAUpdateStaDocCancel']         = 'document/salepriceadj/Salepriceadj_controller/FSoCSPAUpdateStaDocCancel';

// จ่ายโอนสินค้า
// $route['TWO/(:any)/(:any)']            = 'document/transferwarehouseout/Transferwarehouseout_controller/index/$1/$2';
// $route['TWOFormSearchList']         = 'document/transferwarehouseout/Transferwarehouseout_controller/FSxCTWOFormSearchList';
// $route['TWOPageAdd']                = 'document/transferwarehouseout/Transferwarehouseout_controller/FSxCTWOAddPage';
// $route['TWOPageEdit']               = 'document/transferwarehouseout/Transferwarehouseout_controller/FSvCTWOEditPage';
// $route['TWOEventAdd']               = 'document/transferwarehouseout/Transferwarehouseout_controller/FSaCTWOAddEvent';
// $route['TWOEventEdit']              = 'document/transferwarehouseout/Transferwarehouseout_controller/FSaCTWOEditEvent';
// $route['TWOEventDelete']            = 'document/transferwarehouseout/Transferwarehouseout_controller/FSaCTWODeleteEvent';
// $route['TWODataTable']              = 'document/transferwarehouseout/Transferwarehouseout_controller/FSxCTWODataTable';
// $route['TWOGetShpByBch']            = 'document/transferwarehouseout/Transferwarehouseout_controller/FSvCTWOGetShpByBch';
// $route['TWOAddPdtIntoTableDT']      = 'document/transferwarehouseout/Transferwarehouseout_controller/FSvCTWOAddPdtIntoTableDT';
// $route['TWOEditPdtIntoTableDT']     = 'document/transferwarehouseout/Transferwarehouseout_controller/FSvCTWOEditPdtIntoTableDT';
// $route['TWORemovePdtInDTTmp']       = 'document/transferwarehouseout/Transferwarehouseout_controller/FSvCTWORemovePdtInDTTmp';
// $route['TWORemoveAllPdtInFile']     = 'document/transferwarehouseout/Transferwarehouseout_controller/FSvCTWORemoveAllPdtInFile';
// $route['TWOAdvanceTableShowColList'] = 'document/transferwarehouseout/Transferwarehouseout_controller/FSvCTWOAdvTblShowColList';
// $route['TWOAdvanceTableShowColSave'] = 'document/transferwarehouseout/Transferwarehouseout_controller/FSvCTWOShowColSave';
// $route['TWOGetAddress']             = 'document/transferwarehouseout/Transferwarehouseout_controller/TFSvCTWOGetShipAdd';
// $route['TWOGetPdtBarCode']          = 'document/transferwarehouseout/Transferwarehouseout_controller/FSvCTWOGetPdtBarCode';
// $route['TWOPdtAdvanceTableLoadData'] = 'document/transferwarehouseout/Transferwarehouseout_controller/FSvCTWOPdtAdvTblLoadData';
// $route['TWOVatTableLoadData']       = 'document/transferwarehouseout/Transferwarehouseout_controller/FSvCTWOVatLoadData';
// $route['TWOCalculateLastBill']      = 'document/transferwarehouseout/Transferwarehouseout_controller/FSvCTWOCalculateLastBill';
// $route['TWOPdtMultiDeleteEvent']    = 'document/transferwarehouseout/Transferwarehouseout_controller/FSvCTWOPdtMultiDeleteEvent';
// $route['TWOApprove']                = 'document/transferwarehouseout/Transferwarehouseout_controller/FSvCTWOApprove';
// $route['TWOCancel']                 = 'document/transferwarehouseout/Transferwarehouseout_controller/FSvCTWOCancel';

// Card Import - Export (นำเข้า-ส่งออก ข้อมูลบัตร)
$route['cardmngdata/(:any)/(:any)']            = 'document/cardmngdata/Cardmngdata_controller/index/$1/$2';
$route['cardmngdataFromList']                  = 'document/cardmngdata/Cardmngdata_controller/FSvCCMDFromList';
$route['cardmngdataImpFileDataList']           = 'document/cardmngdata/Cardmngdata_controller/FSvCCMDImpFileDataList';
$route['cardmngdataExpFileDataList']           = 'document/cardmngdata/Cardmngdata_controller/FSvCCMDExpFileDataList';
$route['cardmngdataTopUpUpdateInlineOnTemp']   = 'document/cardmngdata/Cardmngdata_controller/FSxCTopUpUpdateInlineOnTemp';
$route['cardmngdataNewCardUpdateInlineOnTemp'] = 'document/cardmngdata/Cardmngdata_controller/FSxCNewCardUpdateInlineOnTemp';
$route['cardmngdataClearUpdateInlineOnTemp']   = 'document/cardmngdata/Cardmngdata_controller/FSxCClearUpdateInlineOnTemp';
$route['cardmngdataProcessImport']             = 'document/cardmngdata/Cardmngdata_controller/FSoCCMDProcessImport';
$route['cardmngdataProcessExport']             = 'document/cardmngdata/Cardmngdata_controller/FSoCCMDProcessExport';

// Call Table Temp
$route['CallTableTemp']                         = 'document/cardmngdata/Cardmngdata_controller/FSaSelectDataTableRight';
$route['CallDeleteTemp']                        = 'document/cardmngdata/Cardmngdata_controller/FSaDeleteDataTableRight';
$route['CallClearTempByTable']                  = 'document/cardmngdata/Cardmngdata_controller/FSaClearTempByTable';
$route['CallUpdateDocNoinTempByTable']          = 'document/cardmngdata/Cardmngdata_controller/FSaUpdateDocnoinTempByTable';

// Card Shift New Card(สร้างบัตรใหม่)
$route['cardShiftNewCard/(:any)/(:any)']                   = 'document/cardshiftnewcard/Cardshiftnewcard_controller/index/$1/$2';
$route['cardShiftNewCardList']                             = 'document/cardshiftnewcard/Cardshiftnewcard_controller/FSvCardShiftNewCardListPage';
$route['cardShiftNewCardDataTable']                        = 'document/cardshiftnewcard/Cardshiftnewcard_controller/FSvCardShiftNewCardDataList';
$route['cardShiftNewCardDataSourceTable']                  = 'document/cardshiftnewcard/Cardshiftnewcard_controller/FSvCardShiftNewCardDataSourceList';
$route['cardShiftNewCardDataSourceTableByFile']            = 'document/cardshiftnewcard/Cardshiftnewcard_controller/FSvCardShiftNewCardDataSourceListByFile';
$route['cardShiftNewCardPageAdd']                          = 'document/cardshiftnewcard/Cardshiftnewcard_controller/FSvCardShiftNewCardAddPage';
$route['cardShiftNewCardEventAdd']                         = 'document/cardshiftnewcard/Cardshiftnewcard_controller/FSaCardShiftNewCardAddEvent';
$route['cardShiftNewCardPageEdit']                         = 'document/cardshiftnewcard/Cardshiftnewcard_controller/FSvCardShiftNewCardEditPage';
$route['cardShiftNewCardEventEdit']                        = 'document/cardshiftnewcard/Cardshiftnewcard_controller/FSaCardShiftNewCardEditEvent';
$route['cardShiftNewCardEventUpdateApvDocAndCancelDoc']    = 'document/cardshiftnewcard/Cardshiftnewcard_controller/FSaCardShiftNewCardUpdateApvDocAndCancelDocEvent';
$route['cardShiftNewCardUpdateInlineOnTemp'] = 'document/cardshiftnewcard/Cardshiftnewcard_controller/FSxCardShiftNewCardUpdateInlineOnTemp';
$route['cardShiftNewCardInsertToTemp'] = 'document/cardshiftnewcard/Cardshiftnewcard_controller/FSxCardShiftNewCardInsertToTemp';
$route['cardShiftNewCardUniqueValidate/(:any)']            = 'document/cardshiftnewcard/Cardshiftnewcard_controller/FStCardShiftNewCardUniqueValidate/$1';
$route['cardShiftNewCardChkCardCodeDup']                   = 'document/cardshiftnewcard/Cardshiftnewcard_controller/FSnCardShiftNewCardChkCardCodeDup';

// Card Shift Out
$route['cardShiftOut/(:any)/(:any)']                   = 'document/cardshiftout/Cardshiftout_controller/index/$1/$2';
$route['cardShiftOutList']                             = 'document/cardshiftout/Cardshiftout_controller/FSvCardShiftOutListPage';
$route['cardShiftOutDataTable']                        = 'document/cardshiftout/Cardshiftout_controller/FSvCardShiftOutDataList';
$route['cardShiftOutDataSourceTable']                  = 'document/cardshiftout/Cardshiftout_controller/FSvCardShiftOutDataSourceList';
$route['cardShiftOutDataSourceTableByFile']            = 'document/cardshiftout/Cardshiftout_controller/FSvCardShiftOutDataSourceListByFile';
$route['cardShiftOutPageAdd']                          = 'document/cardshiftout/Cardshiftout_controller/FSvCardShiftOutAddPage';
$route['cardShiftOutEventAdd']                         = 'document/cardshiftout/Cardshiftout_controller/FSaCardShiftOutAddEvent';
$route['cardShiftOutPageEdit']                         = 'document/cardshiftout/Cardshiftout_controller/FSvCardShiftOutEditPage';
$route['cardShiftOutEventEdit']                        = 'document/cardshiftout/Cardshiftout_controller/FSaCardShiftOutEditEvent';
$route['cardShiftOutEventUpdateApvDocAndCancelDoc']    = 'document/cardshiftout/Cardshiftout_controller/FSaCardShiftOutUpdateApvDocAndCancelDocEvent';
// $route ['cardShiftOutDeleteMulti']                   = 'document/cardshiftout/Cardshiftout_controller/FSoCardShiftOutDeleteMulti';
// $route ['cardShiftOutDelete']                        = 'document/cardshiftout/Cardshiftout_controller/FSoCardShiftOutDelete';
$route['cardShiftOutUpdateInlineOnTemp']               = 'document/cardshiftout/Cardshiftout_controller/FSxCardShiftOutUpdateInlineOnTemp';
$route['cardShiftOutInsertToTemp']                     = 'document/cardshiftout/Cardshiftout_controller/FSxCardShiftOutInsertToTemp';
$route['cardShiftOutUniqueValidate/(:any)']            = 'document/cardshiftout/Cardshiftout_controller/FStCardShiftOutUniqueValidate/$1';

// Card Shift Return
$route['cardShiftReturn/(:any)/(:any)']                    = 'document/cardshiftreturn/Cardshiftreturn_controller/index/$1/$2';
$route['cardShiftReturnList']                              = 'document/cardshiftreturn/Cardshiftreturn_controller/FSvCardShiftReturnListPage';
$route['cardShiftReturnDataTable']                         = 'document/cardshiftreturn/Cardshiftreturn_controller/FSvCardShiftReturnDataList';
$route['cardShiftReturnDataSourceTable']                   = 'document/cardshiftreturn/Cardshiftreturn_controller/FSvCardShiftReturnDataSourceList';
$route['cardShiftReturnDataSourceTableByFile']             = 'document/cardshiftreturn/Cardshiftreturn_controller/FSvCardShiftReturnDataSourceListByFile';
$route['cardShiftReturnPageAdd']                           = 'document/cardshiftreturn/Cardshiftreturn_controller/FSvCardShiftReturnAddPage';
$route['cardShiftReturnEventAdd']                          = 'document/cardshiftreturn/Cardshiftreturn_controller/FSaCardShiftReturnAddEvent';
$route['cardShiftReturnPageEdit']                          = 'document/cardshiftreturn/Cardshiftreturn_controller/FSvCardShiftReturnEditPage';
$route['cardShiftReturnEventEdit']                         = 'document/cardshiftreturn/Cardshiftreturn_controller/FSaCardShiftReturnEditEvent';
$route['cardShiftReturnEventUpdateApvDocAndCancelDoc']     = 'document/cardshiftreturn/Cardshiftreturn_controller/FSaCardShiftReturnUpdateApvDocAndCancelDocEvent';
$route['cardShiftReturnGetCardOnHD']                       = 'document/cardshiftreturn/Cardshiftreturn_controller/FSaCardShiftReturnGetCardOnHD';
$route['cardShiftReturnUniqueValidate/(:any)']             = 'document/cardshiftreturn/Cardshiftreturn_controller/FStCardShiftReturnUniqueValidate/$1';
$route['cardShiftReturnUpdateInlineOnTemp']                = 'document/cardshiftreturn/Cardshiftreturn_controller/FSxCardShiftReturnUpdateInlineOnTemp';
$route['cardShiftReturnInsertToTemp']                      = 'document/cardshiftreturn/Cardshiftreturn_controller/FSxCardShiftReturnInsertToTemp';

// Card Shift TopUp
$route['cardShiftTopUp/(:any)/(:any)']                 = 'document/cardshifttopup/Cardshifttopup_controller/index/$1/$2';
$route['cardShiftTopUpList']                           = 'document/cardshifttopup/Cardshifttopup_controller/FSvCardShiftTopUpListPage';
$route['cardShiftTopUpDataTable']                      = 'document/cardshifttopup/Cardshifttopup_controller/FSvCardShiftTopUpDataList';
$route['cardShiftTopUpDataSourceTable']                = 'document/cardshifttopup/Cardshifttopup_controller/FSvCardShiftTopUpDataSourceList';
$route['cardShiftTopUpDataSourceTableByFile']          = 'document/cardshifttopup/Cardshifttopup_controller/FSvCardShiftTopUpDataSourceListByFile';
$route['cardShiftTopUpPageAdd']                        = 'document/cardshifttopup/Cardshifttopup_controller/FSvCardShiftTopUpAddPage';
$route['cardShiftTopUpEventAdd']                       = 'document/cardshifttopup/Cardshifttopup_controller/FSaCardShiftTopUpAddEvent';
$route['cardShiftTopUpPageEdit']                       = 'document/cardshifttopup/Cardshifttopup_controller/FSvCardShiftTopUpEditPage';
$route['cardShiftTopUpEventEdit']                      = 'document/cardshifttopup/Cardshifttopup_controller/FSaCardShiftTopUpEditEvent';
$route['cardShiftTopUpEventUpdateApvDocAndCancelDoc']  = 'document/cardshifttopup/Cardshifttopup_controller/FSaCardShiftTopUpUpdateApvDocAndCancelDocEvent';
$route['cardShiftTopUpUniqueValidate/(:any)']          = 'document/cardshifttopup/Cardshifttopup_controller/FStCardShiftTopUpUniqueValidate/$1';
$route['cardShiftTopUpUpdateInlineOnTemp']             = 'document/cardshifttopup/Cardshifttopup_controller/FSxCardShiftTopUpUpdateInlineOnTemp';
$route['cardShiftTopUpInsertToTemp']                   = 'document/cardshifttopup/Cardshifttopup_controller/FSxCardShiftTopUpInsertToTemp';

// Card Shift Refund
$route['cardShiftRefund/(:any)/(:any)']                = 'document/cardshiftrefund/Cardshiftrefund_controller/index/$1/$2';
$route['cardShiftRefundList']                          = 'document/cardshiftrefund/Cardshiftrefund_controller/FSvCardShiftRefundListPage';
$route['cardShiftRefundDataTable']                     = 'document/cardshiftrefund/Cardshiftrefund_controller/FSvCardShiftRefundDataList';
$route['cardShiftRefundDataSourceTable']               = 'document/cardshiftrefund/Cardshiftrefund_controller/FSvCardShiftRefundDataSourceList';
$route['cardShiftRefundDataSourceTableByFile']         = 'document/cardshiftrefund/Cardshiftrefund_controller/FSvCardShiftRefundDataSourceListByFile';
$route['cardShiftRefundPageAdd']                       = 'document/cardshiftrefund/Cardshiftrefund_controller/FSvCardShiftRefundAddPage';
$route['cardShiftRefundEventAdd']                      = 'document/cardshiftrefund/Cardshiftrefund_controller/FSaCardShiftRefundAddEvent';
$route['cardShiftRefundPageEdit']                      = 'document/cardshiftrefund/Cardshiftrefund_controller/FSvCardShiftRefundEditPage';
$route['cardShiftRefundEventEdit']                     = 'document/cardshiftrefund/Cardshiftrefund_controller/FSaCardShiftRefundEditEvent';
$route['cardShiftRefundEventUpdateApvDocAndCancelDoc'] = 'document/cardshiftrefund/Cardshiftrefund_controller/FSaCardShiftRefundUpdateApvDocAndCancelDocEvent';
$route['cardShiftRefundUpdateInlineOnTemp']            = 'document/cardshiftrefund/Cardshiftrefund_controller/FSxCardShiftRefundUpdateInlineOnTemp';
$route['cardShiftRefundInsertToTemp']                  = 'document/cardshiftrefund/Cardshiftrefund_controller/FSxCardShiftRefundInsertToTemp';
// $route ['cardShiftRefundDeleteMulti'] = 'document/cardshiftrefund/Cardshiftrefund_controller/FSoCardShiftRefundDeleteMulti';
// $route ['cardShiftRefundDelete'] = 'document/cardshiftrefund/Cardshiftrefund_controller/FSoCardShiftRefundDelete';
$route['cardShiftRefundUniqueValidate/(:any)']         = 'document/cardshiftrefund/Cardshiftrefund_controller/FStCardShiftRefundUniqueValidate/$1';

// Card Shift Status
$route['cardShiftStatus/(:any)/(:any)'] = 'document/cardshiftstatus/Cardshiftstatus_controller/index/$1/$2';
$route['cardShiftStatusList'] = 'document/cardshiftstatus/Cardshiftstatus_controller/FSvCardShiftStatusListPage';
$route['cardShiftStatusDataTable'] = 'document/cardshiftstatus/Cardshiftstatus_controller/FSvCardShiftStatusDataList';
$route['cardShiftStatusDataSourceTable'] = 'document/cardshiftstatus/Cardshiftstatus_controller/FSvCardShiftStatusDataSourceList';
$route['cardShiftStatusDataSourceTableByFile'] = 'document/cardshiftstatus/Cardshiftstatus_controller/FSvCardShiftStatusDataSourceListByFile';
$route['cardShiftStatusPageAdd'] = 'document/cardshiftstatus/Cardshiftstatus_controller/FSvCardShiftStatusAddPage';
$route['cardShiftStatusEventAdd'] = 'document/cardshiftstatus/Cardshiftstatus_controller/FSaCardShiftStatusAddEvent';
$route['cardShiftStatusPageEdit'] = 'document/cardshiftstatus/Cardshiftstatus_controller/FSvCardShiftStatusEditPage';
$route['cardShiftStatusEventEdit'] = 'document/cardshiftstatus/Cardshiftstatus_controller/FSaCardShiftStatusEditEvent';
$route['cardShiftStatusEventUpdateApvDocAndCancelDoc'] = 'document/cardshiftstatus/Cardshiftstatus_controller/FSaCardShiftStatusUpdateApvDocAndCancelDocEvent';
$route['cardShiftStatusUpdateInlineOnTemp'] = 'document/cardshiftstatus/Cardshiftstatus_controller/FSxCardShiftStatusUpdateInlineOnTemp';
$route['cardShiftStatusInsertToTemp'] = 'document/cardshiftstatus/Cardshiftstatus_controller/FSxCardShiftStatusInsertToTemp';
$route['cardShiftStatusUniqueValidate/(:any)'] = 'document/cardshiftstatus/Cardshiftstatus_controller/FStCardShiftStatusUniqueValidate/$1';

// Card Shift Change
$route['cardShiftChange/(:any)/(:any)'] = 'document/cardshiftchange/Cardshiftchange_controller/index/$1/$2';
$route['cardShiftChangeList'] = 'document/cardshiftchange/Cardshiftchange_controller/FSvCardShiftChangeListPage';
$route['cardShiftChangeDataTable'] = 'document/cardshiftchange/Cardshiftchange_controller/FSvCardShiftChangeDataList';
$route['cardShiftChangeDataSourceTable'] = 'document/cardshiftchange/Cardshiftchange_controller/FSvCardShiftChangeDataSourceList';
$route['cardShiftChangeDataSourceTableByFile'] = 'document/cardshiftchange/Cardshiftchange_controller/FSvCardShiftChangeDataSourceListByFile';
$route['cardShiftChangePageAdd'] = 'document/cardshiftchange/Cardshiftchange_controller/FSvCardShiftChangeAddPage';
$route['cardShiftChangeEventAdd'] = 'document/cardshiftchange/Cardshiftchange_controller/FSaCardShiftChangeAddEvent';
$route['cardShiftChangePageEdit'] = 'document/cardshiftchange/Cardshiftchange_controller/FSvCardShiftChangeEditPage';
$route['cardShiftChangeEventEdit'] = 'document/cardshiftchange/Cardshiftchange_controller/FSaCardShiftChangeEditEvent';
$route['cardShiftChangeEventUpdateApvDocAndCancelDoc'] = 'document/cardshiftchange/Cardshiftchange_controller/FSaCardShiftChangeUpdateApvDocAndCancelDocEvent';
$route['cardShiftChangeUpdateInlineOnTemp'] = 'document/cardshiftchange/Cardshiftchange_controller/FSxCardShiftChangeUpdateInlineOnTemp';
$route['cardShiftChangeInsertToTemp'] = 'document/cardshiftchange/Cardshiftchange_controller/FSxCardShiftChangeInsertToTemp';
$route['cardShiftChangeUniqueValidate/(:any)'] = 'document/cardshiftchange/Cardshiftchange_controller/FStCardShiftChangeUniqueValidate/$1';
$route['cardShiftChangeCardUniqueValidate/(:any)'] = 'document/cardshiftchange/Cardshiftchange_controller/FStCardShiftChangeCardUniqueValidate/$1';

// dcmTXII (ใบรับโอนสินค้า)
$route['dcmTXI/(:any)/(:any)/(:any)']  = 'document/transferreceipt/Transferreceipt_controller/index/$1/$2/$3';
$route['dcmTXIFormSearchList']         = 'document/transferreceipt/Transferreceipt_controller/FSxCTXIFormSearchList';
$route['dcmTXIPageAdd']                = 'document/transferreceipt/Transferreceipt_controller/FSxCTXIAddPage';
$route['dcmTXIPageEdit']               = 'document/transferreceipt/Transferreceipt_controller/FSvCTXIEditPage';
$route['dcmTXIEventAdd']               = 'document/transferreceipt/Transferreceipt_controller/FSaCTXIAddEvent';
$route['dcmTXIEventEdit']              = 'document/transferreceipt/Transferreceipt_controller/FSaCTXIEditEvent';
$route['dcmTXIEventDelete']            = 'document/transferreceipt/Transferreceipt_controller/FSaCTXIDeleteEvent';
$route['dcmTXIPdtMultiDeleteEvent']    = 'document/transferreceipt/Transferreceipt_controller/FSvCTXIPdtMultiDeleteEvent';
$route['dcmTXIDataTable']              = 'document/transferreceipt/Transferreceipt_controller/FSxCTXIDataTable';
$route['dcmTXIGetShpByBch']            = 'document/transferreceipt/Transferreceipt_controller/FSvCTXIGetShpByBch';
$route['dcmTXIAddPdtIntoTableDT']      = 'document/transferreceipt/Transferreceipt_controller/FSvCTXIAddPdtIntoTableDT';
$route['dcmTXIEditPdtIntoTableDT']     = 'document/transferreceipt/Transferreceipt_controller/FSvCTXIEditPdtIntoTableDT';
$route['dcmTXIRemovePdtInTemp']        = 'document/transferreceipt/Transferreceipt_controller/FSvCTXIRemovePdtInTemp';
$route['dcmTXIRemoveAllPdtInFile']     = 'document/transferreceipt/Transferreceipt_controller/FSvCTXIRemoveAllPdtInFile';
$route['dcmTXIAdvanceTableShowColList'] = 'document/transferreceipt/Transferreceipt_controller/FSvCTXIAdvTblShowColList';
$route['dcmTXIAdvanceTableShowColSave'] = 'document/transferreceipt/Transferreceipt_controller/FSvCTXIShowColSave';
$route['dcmTXIGetAddress']             = 'document/transferreceipt/Transferreceipt_controller/FSvCTXIGetShipAdd';
$route['dcmTXIGetPdtBarCode']          = 'document/transferreceipt/Transferreceipt_controller/FSvCTXIGetPdtBarCode';
$route['dcmTXIPdtAdvanceTableLoadData'] = 'document/transferreceipt/Transferreceipt_controller/FSvCTXIPdtAdvTblLoadData';
$route['dcmTXIVatTableLoadData']       = 'document/transferreceipt/Transferreceipt_controller/FSvCTXIVatLoadData';
$route['dcmTXIApprove']                = 'document/transferreceipt/Transferreceipt_controller/FSvCTXIApprove';
$route['dcmTXICancel']                 = 'document/transferreceipt/Transferreceipt_controller/FSvCTXICancel';
$route['dcmTXICalculateLastBill']      = 'document/transferreceipt/Transferreceipt_controller/FSvCTXICalculateLastBill';
$route['dcmTXIGetDataRefInt']          = 'document/transferreceipt/Transferreceipt_controller/FSvCTXIGetDataRefInt';
$route['dcmTXIClearDTTemp']            = 'document/transferreceipt/Transferreceipt_controller/FSvCTXIClearDTTemp';
$route['dcmTXIBrowseDataPDT']          = 'document/transferreceipt/Transferreceipt_controller/FSvCTXIBrowseDataPDT';
$route['dcmTXIBrowseDataPDTTable']      = 'document/transferreceipt/Transferreceipt_controller/FSvCTXIBrowseDataTXIPDTTable';

// Promotion
/* $route['promotion/(:any)/(:any)']     = 'document/promotion/Promotion_controller/index/$1/$2';
$route['promotionFormSearchList']     = 'document/promotion/Promotion_controller/FSxCPMTFormSearchList';
$route['promotionPageTSysList']       = 'document/promotion/Promotion_controller/FSxCPMTPageTSysList';
$route['promotionTSysListDataTable']  = 'document/promotion/Promotion_controller/FSxCPMTTSysListDataTable';
$route['promotionPageAdd']            = 'document/promotion/Promotion_controller/FSxCPMTAddPage';
$route['promotionDataTable']          = 'document/promotion/Promotion_controller/FSxCPMTDataTable';
$route['promotionPageEdit']           = 'document/promotion/Promotion_controller/FSvCPMTEditPage';
$route['promotionEventAdd']           = 'document/promotion/Promotion_controller/FSaCPMTAddEvent';
$route['promotionEventEdit']          = 'document/promotion/Promotion_controller/FSaCPMTEditEvent';
$route['promotionEventDelete']        = 'document/promotion/Promotion_controller/FSaCPMTDeleteEvent';
$route['promotionUniqueValidate/(:any)'] = 'document/promotion/Promotion_controller/FStDocPromotionUniqueValidate/$1';
$route['promotionEventUpdateApvDocAndCancelDoc'] = 'document/promotion/Promotion_controller/FSaDocPromotionUpdateApvDocAndCancelDocEvent'; */

// Adjust Stock (ใบปรับสต๊อก)
$route ['adjStkSub/(:any)/(:any)']         = 'document/adjuststocksub/Adjuststocksub_controller/index/$1/$2';
$route ['adjStkSubFormSearchList']         = 'document/adjuststocksub/Adjuststocksub_controller/FSxCAdjStkSubFormSearchList';
$route ['adjStkSubDataTable']              = 'document/adjuststocksub/Adjuststocksub_controller/FSxCAdjStkSubDataTable';
$route ['adjStkSubPageAdd']                = 'document/adjuststocksub/Adjuststocksub_controller/FSxCAdjStkSubAddPage';
$route ['adjStkSubPageEdit']               = 'document/adjuststocksub/Adjuststocksub_controller/FSvCAdjStkSubEditPage';
$route ['adjStkSubEventAdd']               = 'document/adjuststocksub/Adjuststocksub_controller/FSaCAdjStkSubAddEvent';
$route ['adjStkSubEventEdit']              = 'document/adjuststocksub/Adjuststocksub_controller/FSaCAdjStkSubEditEvent';
$route ['adjStkSubEventDelete']            = 'document/adjuststocksub/Adjuststocksub_controller/FSaCASTDeleteEvent';
$route ['adjStkSubApproved']               = 'document/adjuststocksub/Adjuststocksub_controller/FSaCASTApprove';
$route ['adjStkSubCancel']                 = 'document/adjuststocksub/Adjuststocksub_controller/FSvCAdjStkSubCancel';
$route ['adjStkSubRemovePdtInDTTmp']       = 'document/adjuststocksub/Adjuststocksub_controller/FSvCAdjStkSubRemovePdtInDTTmp';
$route ['adjStkSubPdtAdvanceTableLoadData']= 'document/adjuststocksub/Adjuststocksub_controller/FSvCAdjStkSubPdtAdvTblLoadData';
$route ['adjStkSubPdtMultiDeleteEvent']    = 'document/adjuststocksub/Adjuststocksub_controller/FSvCAdjStkSubPdtMultiDeleteEvent';
$route ['docASTEventAddProducts']           = 'document/adjuststocksub/Adjuststocksub_controller/FSaCASTEventAddProducts';
$route ['docASTEventEditInLine']            = 'document/adjuststocksub/Adjuststocksub_controller/FSxCASTEditInLine';
$route ['docASTEventUpdateDateTime']        = 'document/adjuststocksub/Adjuststocksub_controller/FSaCASTUpdateDateTime';

/*===== Begin Credit Note (ใบลดหนี้) =====================================================*/
$route ['creditNote/(:any)/(:any)']         = 'document/creditnote/Creditnote_controller/index/$1/$2';
$route ['creditNoteFormSearchList']         = 'document/creditnote/Creditnote_controller/FSxCCreditNoteFormSearchList';
$route ['creditNotePageAdd']                = 'document/creditnote/Creditnote_controller/FSxCCreditNoteAddPage';
$route ['creditNotePageEdit']               = 'document/creditnote/Creditnote_controller/FSvCCreditNoteEditPage';
$route ['creditNoteEventAdd']               = 'document/creditnote/Creditnote_controller/FSaCCreditNoteAddEvent';
$route ['creditNoteCheckHaveProductInDT']   = 'document/creditnote/Creditnote_controller/FSbCheckHaveProductInDT';
$route ['creditNoteEventDeleteMultiDoc']    = 'document/creditnote/Creditnote_controller/FSoCreditNoteDeleteMultiDoc';
$route ['creditNoteEventDeleteDoc']         = 'document/creditnote/Creditnote_controller/FSoCreditNoteDeleteDoc';
$route ['creditNoteUniqueValidate/(:any)']  = 'document/creditnote/Creditnote_controller/FStCCreditNoteUniqueValidate/$1';

$route ['creditNoteEventEdit']              = 'document/creditnote/Creditnote_controller/FSaCCreditNoteEditEvent';
$route ['creditNoteDataTable']              = 'document/creditnote/Creditnote_controller/FSxCCreditNoteDataTable';
$route ['creditNoteGetShpByBch']            = 'document/creditnote/Creditnote_controller/FSvCCreditNoteGetShpByBch';
$route ['creditNoteAddPdtIntoTableDT']      = 'document/creditnote/Creditnote_controller/FSvCCreditNoteAddPdtIntoTableDT';
$route ['creditNoteEditPdtIntoTableDT']     = 'document/creditnote/Creditnote_controller/FSvCCreditNoteEditPdtIntoTableDT';
$route ['creditNoteRemovePdtInDTTmp']       = 'document/creditnote/Creditnote_controller/FSvCCreditNoteRemovePdtInDTTmp';
$route ['creditNoteRemovePdtInFile'] = 'document/creditnote/Creditnote_controller/FSvCCreditNoteRemovePdtInFile';
$route ['creditNoteRemoveAllPdtInFile'] = 'document/creditnote/Creditnote_controller/FSvCCreditNoteRemoveAllPdtInFile';
$route ['creditNoteAdvanceTableShowColList'] = 'document/creditnote/Creditnote_controller/FSvCCreditNoteAdvTblShowColList';
$route ['creditNoteAdvanceTableShowColSave'] = 'document/creditnote/Creditnote_controller/FSvCCreditNoteShowColSave';
$route ['creditNoteClearTemp'] = 'document/creditnote/Creditnote_controller/FSaCreditNoteClearTemp';

$route ['creditNoteGetDTDisTableData']      = 'document/creditnote/Creditnotedischgmodal_controller/FSvCCreditNoteGetDTDisTableData';
$route ['creditNoteAddDTDisIntoTable']      = 'document/creditnote/Creditnotedischgmodal_controller/FSvCCreditNoteAddDTDisIntoTable';
$route ['creditNoteGetHDDisTableData']      = 'document/creditnote/Creditnotedischgmodal_controller/FSvCCreditNoteGetHDDisTableData';
$route ['creditNoteAddHDDisIntoTable']      = 'document/creditnote/Creditnotedischgmodal_controller/FSvCCreditNoteAddHDDisIntoTable';
$route ['creditNoteAddEditDTDis']           = 'document/creditnote/Creditnotedischgmodal_controller/FSvCCreditNoteAddEditDTDis';
$route ['creditNoteAddEditHDDis']           = 'document/creditnote/Creditnotedischgmodal_controller/FSvCCreditNoteAddEditHDDis';

$route ['creditNoteGetPdtBarCode']          = 'document/creditnote/Creditnote_controller/FSvCCreditNoteGetPdtBarCode';
$route ['creditNotePdtAdvanceTableLoadData']= 'document/creditnote/Creditnote_controller/FSvCCreditNotePdtAdvTblLoadData';
$route ['creditNoteNonePdtAdvanceTableLoadData']= 'document/creditnote/Creditnote_controller/FSvCCreditNoteNonePdtAdvTblLoadData';
// $route ['CreditNoteVatTableLoadData']       = 'document/creditnote/Creditnote_controller/FSvCCreditNoteVatLoadData';
$route ['creditNoteCalculateLastBill']      = 'document/creditnote/Creditnote_controller/FSvCCreditNoteCalculateLastBill';
$route ['creditNotePdtMultiDeleteEvent']    = 'document/creditnote/Creditnote_controller/FSvCCreditNotePdtMultiDeleteEvent';
$route ['creditNoteApprove']                = 'document/creditnote/Creditnote_controller/FSvCCreditNoteApprove';
$route ['creditNoteCancel']                 = 'document/creditnote/Creditnote_controller/FSvCCreditNoteCancel';
$route ['creditNoteClearDocTemForChngCdt']  = 'document/creditnote/Creditnote_controller/FSxCTFXClearDocTemForChngCdt';
$route ['creditNoteRefPIHDList']            = 'document/creditnote/cCreditNoteRefPIModal/FSoCreditNoteRefPIHDList';
$route ['creditNoteRefPIDTList']  = 'document/creditnote/cCreditNoteRefPIModal/FSoCreditNoteRefPIDTList';
$route ['creditNoteDisChgHDList']            = 'document/creditnote/Creditnotedischgmodal_controller/FSoCreditNoteDisChgHDList';
$route ['creditNoteDisChgDTList']  = 'document/creditnote/Creditnotedischgmodal_controller/FSoCreditNoteDisChgDTList';
$route ['creditNoteCalEndOfBillNonePdt'] = 'document/creditnote/Creditnote_controller/FSoCreditNoteCalEndOfBillNonePdt';
/*===== End Credit Note (ใบลดหนี้) =======================================================*/

// ============================= ใบจ่ายโอนระหว่างคลัง - ใบจ่ายโอนระหว่างสาขา - ใบเบิกออก ============================= //
    $route['dcmTXO/(:any)/(:any)/(:any)']       = 'document/transferout/Transferout_controller/index/$1/$2/$3';
    $route['dcmTXOFormSearchList']              = 'document/transferout/Transferout_controller/FSvCTXOFormSearchList';
    $route['dcmTXODataTable']                   = 'document/transferout/Transferout_controller/FSxCTXODataTable';
    $route['dcmTXOPageAdd']                     = 'document/transferout/Transferout_controller/FSoCTXOAddPage';
    $route['dcmTXOPageEdit']                    = 'document/transferout/Transferout_controller/FSoCTXOEditPage';
    $route['dcmTXOPdtAdvanceTableLoadData']     = 'document/transferout/Transferout_controller/FSoCTXOPdtAdvTblLoadData';
    $route['dcmTXOVatTableLoadData']            = 'document/transferout/Transferout_controller/FSoCTXOVatLoadData';
    $route['dcmTXOCalculateLastBill']           = 'document/transferout/Transferout_controller/FSoCTXOCalculateLastBill';
    $route['dcmTXOAdvanceTableShowColList']     = 'document/transferout/Transferout_controller/FSoCTXOAdvTblShowColList';
    $route['dcmTXOAdvanceTableShowColSave']     = 'document/transferout/Transferout_controller/FSoCTXOShowColSave';
    $route['dcmTXOAddPdtIntoTableDTTmp']        = 'document/transferout/Transferout_controller/FSoCTXOAddPdtIntoTableDTTmp';
    $route['dcmTXOEditPdtIntoTableDTTmp']       = 'document/transferout/Transferout_controller/FSoCTXOEditPdtIntoTableDTTmp';
    $route['dcmTXORemovePdtInDTTmp']            = 'document/transferout/Transferout_controller/FSoCTXORemovePdtInDTTmp';
    $route['dcmTXORemoveMultiPdtInDTTmp']       = 'document/transferout/Transferout_controller/FSoCTXORemovePdtMultiInDTTmp';
    $route['dcmTXOChkHavePdtForTnf']            = 'document/transferout/Transferout_controller/FSoCTXOChkHavePdtForTnf';
    $route['dcmTXOEventAdd']                    = 'document/transferout/Transferout_controller/FSoCTXOAddEventDoc';
    $route['dcmTXOEventEdit']                   = 'document/transferout/Transferout_controller/FSoCTXOEditEventDoc';
    $route['dcmTXOEventDelete']                 = 'document/transferout/Transferout_controller/FSoCTXODeleteEventDoc';
    $route['dcmTXOApproveDoc']                  = 'document/transferout/Transferout_controller/FSoCTXOApproveDocument';
    $route['dcmTXOCancelDoc']                   = 'document/transferout/Transferout_controller/FSoCTXOCancelDoc';
    $route['dcmTXOPrintDoc']                    = 'document/transferout/Transferout_controller/FSoCTXOPrintDoc';
    $route['dcmTXOClearDataDocTemp']            = 'document/transferout/Transferout_controller/FSoCTXOClearDataDocTemp';
    $route['dcmTXOCheckViaCodeForApv']          = 'document/transferout/Transferout_controller/FSoCTXOCheckViaCodeForApv';
// ============================================================================================================ //

// ========================================== ใบตรวจนับสินค้า ==================================================== //
    $route['dcmAST/(:any)/(:any)']          = 'document/adjuststock/Adjuststock_controller/index/$1/$2';
    $route['dcmASTFormSearchList']          = 'document/adjuststock/Adjuststock_controller/FSvCASTFormSearchList';
    $route['dcmASTDataTable']               = 'document/adjuststock/Adjuststock_controller/FSoCASTDataTable';
    $route['dcmASTEventDelete']             = 'document/adjuststock/Adjuststock_controller/FSoCASTDeleteEventDoc';
    $route['dcmASTPageAdd']                 = 'document/adjuststock/Adjuststock_controller/FSoCASTAddPage';
    $route['dcmASTPageEdit']                = 'document/adjuststock/Adjuststock_controller/FSoCASTEditPage';
    $route['dcmASTPdtAdvanceTableLoadData'] = 'document/adjuststock/Adjuststock_controller/FSoCASTPdtAdvTblLoadData';
    $route['dcmASTAdvanceTableShowColList'] = 'document/adjuststock/Adjuststock_controller/FSoCASTAdvTblShowColList';
    $route['dcmASTAdvanceTableShowColSave'] = 'document/adjuststock/Adjuststock_controller/FSoCASTShowColSave';
    $route['dcmASTCheckPdtTmpForTransfer']  = 'document/adjuststock/Adjuststock_controller/FSbCheckHaveProductForTransfer';
    $route['dcmASTAddPdtIntoTableDT']       = 'document/adjuststock/Adjuststock_controller/FSvCASTAddPdtIntoTableDT';
    $route['dcmASTEventAdd']                = 'document/adjuststock/Adjuststock_controller/FSaCASTAddEvent';
    $route['dcmASTEventEdit']               = 'document/adjuststock/Adjuststock_controller/FSaCASTEditEvent';
    $route['dcmASTEditPdtIntoTableDT']      = 'document/adjuststock/Adjuststock_controller/FSvCASTEditPdtIntoTableDT';
    $route['dcmASTRemovePdtInDTTmp']        = 'document/adjuststock/Adjuststock_controller/FSvCASTRemovePdtInDTTmp';
    $route['dcmASTPdtMultiDeleteEvent']     = 'document/adjuststock/Adjuststock_controller/FSvCASTPdtMultiDeleteEvent';
    $route['dcmASTUpdateInline']            = 'document/adjuststock/Adjuststock_controller/FSoCASTUpdateDataInline';
    $route['dcmASTCancel']                  = 'document/adjuststock/Adjuststock_controller/FSvCASTCancel';
    $route['dcmASTApprove']                 = 'document/adjuststock/Adjuststock_controller/FSvCASTApprove';
    $route['dcmASTGetPdtBarCode']           = 'document/adjuststock/Adjuststock_controller/FSvCASTGetPdtBarCode';
    $route['docAdjStkEventAddProducts']     = 'document/adjuststock/Adjuststock_controller/FSvCAdjStkEventAddProducts';
// ============================================================================================================ //

// ========================================= ใบรับของ-ใบซื้อสินค้า/บริการ =========================================== //
    $route['dcmPI/(:any)/(:any)']           = 'document/purchaseinvoice/Purchaseinvoice_controller/index/$1/$2';
    $route['dcmPIFormSearchList']           = 'document/purchaseinvoice/Purchaseinvoice_controller/FSvCPIFormSearchList';
    $route['dcmPIDataTable']                = 'document/purchaseinvoice/Purchaseinvoice_controller/FSoCPIDataTable';
    $route['dcmPIPageAdd']                  = 'document/purchaseinvoice/Purchaseinvoice_controller/FSoCPIAddPage';
    $route['dcmPIPageEdit']                 = 'document/purchaseinvoice/Purchaseinvoice_controller/FSoCPIEditPage';
    $route['dcmPIPdtAdvanceTableLoadData']  = 'document/purchaseinvoice/Purchaseinvoice_controller/FSoCPIPdtAdvTblLoadData';
    $route['dcmPIVatTableLoadData']         = 'document/purchaseinvoice/Purchaseinvoice_controller/FSoCPIVatLoadData';
    $route['dcmPICalculateLastBill']        = 'document/purchaseinvoice/Purchaseinvoice_controller/FSoCPICalculateLastBill';
    $route['dcmPIEventDelete']              = 'document/purchaseinvoice/Purchaseinvoice_controller/FSoCPIDeleteEventDoc';
    $route['dcmPIAdvanceTableShowColList']  = 'document/purchaseinvoice/Purchaseinvoice_controller/FSoCPIAdvTblShowColList';
    $route['dcmPIAdvanceTableShowColSave']  = 'document/purchaseinvoice/Purchaseinvoice_controller/FSoCPIAdvTalShowColSave';
    $route['dcmPIAddPdtIntoDTDocTemp']      = 'document/purchaseinvoice/Purchaseinvoice_controller/FSoCPIAddPdtIntoDocDTTemp';
    $route['dcmPIEditPdtIntoDTDocTemp']     = 'document/purchaseinvoice/Purchaseinvoice_controller/FSoCPIEditPdtIntoDocDTTemp';
    $route['dcmPIChkHavePdtForDocDTTemp']   = 'document/purchaseinvoice/Purchaseinvoice_controller/FSoCPIChkHavePdtForDocDTTemp';
    $route['dcmPIEventAdd']                 = 'document/purchaseinvoice/Purchaseinvoice_controller/FSoCPIAddEventDoc';
    $route['dcmPIEventEdit']                = 'document/purchaseinvoice/Purchaseinvoice_controller/FSoCPIEditEventDoc';
    $route['dcmPIRemovePdtInDTTmp']         = 'document/purchaseinvoice/Purchaseinvoice_controller/FSvCPIRemovePdtInDTTmp';
    $route['dcmPIRemovePdtInDTTmpMulti']    = 'document/purchaseinvoice/Purchaseinvoice_controller/FSvCPIRemovePdtInDTTmpMulti';
    $route['dcmPICancelDocument']           = 'document/purchaseinvoice/Purchaseinvoice_controller/FSvCPICancelDocument';
    $route['dcmPIApproveDocument']          = 'document/purchaseinvoice/Purchaseinvoice_controller/FSvCPIApproveDocument';
    // Search And Add Product
    $route['dcmPISerachAndAddPdtIntoTbl']   = 'document/purchaseinvoice/Purchaseinvoice_controller/FSoCPISearchAndAddPdtIntoTbl';
    // Clear Data In DocDTTemp
    $route['dcmPIClearDataDocTemp']         = 'document/purchaseinvoice/Purchaseinvoice_controller/FSoCPIClearDataInDocTemp';
    // Modal Discount/Chage
    $route['dcmPIDisChgHDList']             = 'document/purchaseinvoice/Purchaseinvoicedischgmodal_controller/FSoCPIDisChgHDList';
    $route['dcmPIDisChgDTList']             = 'document/purchaseinvoice/Purchaseinvoicedischgmodal_controller/FSoCPIDisChgDTList';
    $route['dcmPIAddEditDTDis']             = 'document/purchaseinvoice/Purchaseinvoicedischgmodal_controller/FSoCPIAddEditDTDis';
    $route['dcmPIAddEditHDDis']             = 'document/purchaseinvoice/Purchaseinvoicedischgmodal_controller/FSoCPIAddEditHDDis';

// ============================================================================================================ //

// ======================================= การกำหนดอัตราค่าเช่า (Locker) ========================================= //
    $route['dcmPriRentLocker/(:any)/(:any)']    = 'document/pricerentlocker/Pricerentlocker_controller/index/$1/$2';
    $route['dcmPriRntLkFormSearchList']         = 'document/pricerentlocker/Pricerentlocker_controller/FSvCPriRntLkFormSearchList';
    $route['dcmPriRntLkDataTable']              = 'document/pricerentlocker/Pricerentlocker_controller/FSoCPriRntLkDataTable';
    $route['dcmPriRntLkPageAdd']                = 'document/pricerentlocker/Pricerentlocker_controller/FSoCPriRntLkAddPage';
    $route['dcmPriRntLkPageEdit']               = 'document/pricerentlocker/Pricerentlocker_controller/FSoCPriRntLkEditPage';
    $route['dcmPriRntLkLoadDataDT']             = 'document/pricerentlocker/Pricerentlocker_controller/FSoCPriRntLkLoadDataDT';
    $route['dcmPriRntLkEventAdd']               = 'document/pricerentlocker/Pricerentlocker_controller/FSoCPriRntLkEventAdd';
    $route['dcmPriRntLkEventEdit']              = 'document/pricerentlocker/Pricerentlocker_controller/FSoCPriRntLkEventEdit';
    $route['dcmPriRntLkEvemtDeleteSingle']      = 'document/pricerentlocker/Pricerentlocker_controller/FSoCPriRntLkEventDelSingle';
    $route['dcmPriRntLkEvemtDeleteMulti']       = 'document/pricerentlocker/Pricerentlocker_controller/FSoCPriRntLkEventDelMultiple';
// ============================================================================================================ //

// ============================================== การกำหนดคูปอง =============================================== //
    $route['dcmCouponSetup/(:any)/(:any)']      = 'document/couponsetup/Couponsetup_controller/index/$1/$2';
    $route['dcmCouponSetupFormSearchList']      = 'document/couponsetup/Couponsetup_controller/FSvCCPHFormSearchList';
    $route['dcmCouponSetupGetDataTable']        = 'document/couponsetup/Couponsetup_controller/FSoCCPHGetDataTable';
    $route['dcmCouponSetupPageAdd']             = 'document/couponsetup/Couponsetup_controller/FSoCCPHCallPageAdd';
    $route['dcmCouponSetupPageEdit']            = 'document/couponsetup/Couponsetup_controller/FSoCCPHCallPageEdit';
    $route['dcmCouponSetupPageDetailDT']        = 'document/couponsetup/Couponsetup_controller/FSoCCPHCallPageDetailDT';
    $route['dcmCouponSetupPageDetailDT']        = 'document/couponsetup/Couponsetup_controller/FSoCCPHCallPageDetailDT';
    $route['dcmCouponSetupEventAddCouponToDT']  = 'document/couponsetup/Couponsetup_controller/FSoCCPHCallEventAddCouponToDT';
    $route['dcmCouponSetupEventAdd']            = 'document/couponsetup/Couponsetup_controller/FSoCCPHEventAdd';
    $route['dcmCouponSetupEventEdit']           = 'document/couponsetup/Couponsetup_controller/FSoCCPHEventEdit';
    $route['dcmCouponSetupEventDelete']         = 'document/couponsetup/Couponsetup_controller/FSoCCPHEventDelete';
    $route['dcmCouponSetupEvenApprove']         = 'document/couponsetup/Couponsetup_controller/FSaCCPHEventAppove';
    $route['dcmCouponSetupEvenCancel']          = 'document/couponsetup/Couponsetup_controller/FSaCCPHEventCancel';

// ============================================================================================================ //

// ========================================= ใบรับของ-ใบซื้อสินค้า/บริการ =========================================== //
    $route['dcmSO/(:any)/(:any)']           = 'document/saleorder/Saleorder_controller/index/$1/$2';
    $route['dcmSOFormSearchList']           = 'document/saleorder/Saleorder_controller/FSvCSOFormSearchList';
    $route['dcmSODataTable']                = 'document/saleorder/Saleorder_controller/FSoCSODataTable';
    $route['dcmSOPageAdd']                  = 'document/saleorder/Saleorder_controller/FSoCSOAddPage';
    $route['dcmSOPageEdit']                 = 'document/saleorder/Saleorder_controller/FSoCSOEditPage';
    $route['dcmSOPdtAdvanceTableLoadData']  = 'document/saleorder/Saleorder_controller/FSoCSOPdtAdvTblLoadData';
    $route['dcmSOVatTableLoadData']         = 'document/saleorder/Saleorder_controller/FSoCSOVatLoadData';
    $route['dcmSOCalculateLastBill']        = 'document/saleorder/Saleorder_controller/FSoCSOCalculateLastBill';
    $route['dcmSOEventDelete']              = 'document/saleorder/Saleorder_controller/FSoCSODeleteEventDoc';
    $route['dcmSOAdvanceTableShowColList']  = 'document/saleorder/Saleorder_controller/FSoCSOAdvTblShowColList';
    $route['dcmSOAdvanceTableShowColSave']  = 'document/saleorder/Saleorder_controller/FSoCSOAdvTalShowColSave';
    $route['dcmSOAddPdtIntoDTDocTemp']      = 'document/saleorder/Saleorder_controller/FSoCSOAddPdtIntoDocDTTemp';
    $route['dcmSOEditPdtIntoDTDocTemp']     = 'document/saleorder/Saleorder_controller/FSoCSOEditPdtIntoDocDTTemp';
    $route['dcmSOChkHavePdtForDocDTTemp']   = 'document/saleorder/Saleorder_controller/FSoCSOChkHavePdtForDocDTTemp';
    $route['dcmSOEventAdd']                 = 'document/saleorder/Saleorder_controller/FSoCSOAddEventDoc';
    $route['dcmSOEventEdit']                = 'document/saleorder/Saleorder_controller/FSoCSOEditEventDoc';
    $route['dcmSORemovePdtInDTTmp']         = 'document/saleorder/Saleorder_controller/FSvCSORemovePdtInDTTmp';
    $route['dcmSORemovePdtInDTTmpMulti']    = 'document/saleorder/Saleorder_controller/FSvCSORemovePdtInDTTmpMulti';
    $route['dcmSOCancelDocument']           = 'document/saleorder/Saleorder_controller/FSvCSOCancelDocument';
    $route['dcmSOApproveDocument']          = 'document/saleorder/Saleorder_controller/FSvCSOApproveDocument';
    // Search And Add Product
    $route['dcmSOSerachAndAddPdtIntoTbl']   = 'document/saleorder/Saleorder_controller/FSoCSOSearchAndAddPdtIntoTbl';
    // Clear Data In DocDTTemp
    $route['dcmSOClearDataDocTemp']         = 'document/saleorder/Saleorder_controller/FSoCSOClearDataInDocTemp';
    // Modal Discount/Chage
    $route['dcmSODisChgHDList']             = 'document/saleorder/Saleorderdischgmodal_controller/FSoCSODisChgHDList';
    $route['dcmSODisChgDTList']             = 'document/saleorder/Saleorderdischgmodal_controller/FSoCSODisChgDTList';
    $route['dcmSOAddEditDTDis']             = 'document/saleorder/Saleorderdischgmodal_controller/FSoCSOAddEditDTDis';
    $route['dcmSOAddEditHDDis']             = 'document/saleorder/Saleorderdischgmodal_controller/FSoCSOAddEditHDDis';
    $route['dcmSOPocessAddDisTmpCst']       = 'document/saleorder/Saleorderdischgmodal_controller/FSoCSOPocessAddDisTmpCst';

    $route['dcmSOPageEditMonitor']                 = 'document/saleorder/Saleorder_controller/FSoCSOEditPageMonitor';
    $route['dcmSOPdtAdvanceTableLoadDataMonitor']  = 'document/saleorder/Saleorder_controller/FSoCSOPdtAdvTblLoadDataMonitor';
    $route['dcmSORejectDocument']           = 'document/saleorder/Saleorder_controller/FSvCSORejectDocument';

// ============================================================================================================ //

    // ตรวจสอบกระบวนการอนุมัติใบสั่งขาย (Check sales order approval process.)
    $route['dcmCheckSO/(:any)/(:any)']      = 'document/checksaleorderapprove/Chksaleorderapprove_controller/index/$1/$2';
    $route ['dcmCheckSoPageMain']           = 'document/checksaleorderapprove/Chksaleorderapprove_controller/FSvCCHKSoCallPageMain';

// ============================================================================================================ //



/*===== Begin ใบเติมสินค้า ================================================================*/
// Master
$route ['TWXVD/(:any)/(:any)'] = 'document/topupVending/Topupvending_controller/index/$1/$2';
$route ['TopupVendingList'] = 'document/topupVending/Topupvending_controller/FSxCTUVTopupVendingList';
$route ['TopupVendingDataTable'] = 'document/topupVending/Topupvending_controller/FSxCTUVTopupVendingDataTable';
$route ['TopupVendingCallPageAdd'] = 'document/topupVending/Topupvending_controller/FSxCTUVTopupVendingAddPage';
$route ['TopupVendingEventAdd'] = 'document/topupVending/Topupvending_controller/FSaCTUVTopupVendingAddEvent';
$route ['TopupVendingCallPageEdit'] = 'document/topupVending/Topupvending_controller/FSvCTUVTopupVendingEditPage';
$route ['TopupVendingEventEdit'] = 'document/topupVending/Topupvending_controller/FSaCTUVTopupVendingEditEvent';
$route ['TopupVendingDocApprove'] = 'document/topupVending/Topupvending_controller/FStCTopUpVendingDocApprove';
$route ['TopupVendingDocCancel'] = 'document/topupVending/Topupvending_controller/FStCTopUpVendingDocCancel';
$route ['TopupVendingDelDoc'] = 'document/topupVending/Topupvending_controller/FStTopUpVendingDeleteDoc';
$route ['TopupVendingDelDocMulti'] = 'document/topupVending/Topupvending_controller/FStTopUpVendingDeleteMultiDoc';
$route ['TopupVendingGetWahByShop'] = 'document/topupVending/Topupvending_controller/FStGetWahByShop';
$route ['TopupVendingUniqueValidate']  = 'document/topupVending/Topupvending_controller/FStCTopUpVendingUniqueValidate/$1';
// Temp
$route ['TopupVendingInsertPdtLayoutToTmp'] = 'document/topupVending/Topupvending_controller/FSaCTUVTopupVendingInsertPdtLayoutToTmp';
$route ['TopupVendingGetPdtLayoutDataTableInTmp'] = 'document/topupVending/Topupvending_controller/FSxCTUVTopupVendingGetPdtLayoutDataTableInTmp';
$route ['TopupVendingUpdatePdtLayoutInTmp'] = 'document/topupVending/Topupvending_controller/FSxCTUVTopupVendingUpdatePdtLayoutInTmp';
$route ['TopupVendingDeletePdtLayoutInTmp'] = 'document/topupVending/Topupvending_controller/FSxCTUVTopupVendingDeletePdtLayoutInTmp';
/*===== End ใบเติมสินค้า ==================================================================*/

/*===== Begin ใบนำฝาก ==================================================================*/
// Master
$route ['deposit/(:any)/(:any)'] = 'document/deposit/Deposit_controller/index/$1/$2';
$route ['depositList'] = 'document/deposit/Deposit_controller/FSxCDepositList';
$route ['depositDataTable'] = 'document/deposit/Deposit_controller/FSxCDepositDataTable';
$route ['depositCallPageAdd'] = 'document/deposit/Deposit_controller/FSxCDepositAddPage';
$route ['depositEventAdd'] = 'document/deposit/Deposit_controller/FSaCDepositAddEvent';
$route ['depositCallPageEdit'] = 'document/deposit/Deposit_controller/FSvCDepositEditPage';
$route ['depositEventEdit'] = 'document/deposit/Deposit_controller/FSaCDepositEditEvent';
$route ['depositUniqueValidate']  = 'document/deposit/Deposit_controller/FStCDepositUniqueValidate/$1';
$route ['depositDocApprove'] = 'document/deposit/Deposit_controller/FStCDepositDocApprove';
$route ['depositDocCancel'] = 'document/deposit/Deposit_controller/FStCDepositDocCancel';
$route ['depositDelDoc'] = 'document/deposit/Deposit_controller/FStDepositDeleteDoc';
$route ['depositDelDocMulti'] = 'document/deposit/Deposit_controller/FStDepositDeleteMultiDoc';
// Cash
$route ['depositInsertCashToTmp'] = 'document/deposit/Depositcash_controller/FSaCDepositInsertCashToTmp';
$route ['depositGetCashInTmp'] = 'document/deposit/Depositcash_controller/FSxCDepositGetCashInTmp';
$route ['depositUpdateCashInTmp'] = 'document/deposit/Depositcash_controller/FSxCDepositUpdateCashInTmp';
$route ['depositDeleteCashInTmp'] = 'document/deposit/Depositcash_controller/FSxCDepositDeleteCashInTmp';
$route ['depositClearCashInTmp'] = 'document/deposit/Depositcash_controller/FSxCDepositClearCashInTmp';
// Cheque
$route ['depositInsertChequeToTmp'] = 'document/deposit/Depositcheque_controller/FSaCDepositInsertChequeToTmp';
$route ['depositGetChequeInTmp'] = 'document/deposit/Depositcheque_controller/FSxCDepositGetChequeInTmp';
$route ['depositUpdateChequeInTmp'] = 'document/deposit/Depositcheque_controller/FSxCDepositUpdateChequeInTmp';
$route ['depositDeleteChequeInTmp'] = 'document/deposit/Depositcheque_controller/FSxCDepositDeleteChequeInTmp';
$route ['depositClearChequeInTmp'] = 'document/deposit/Depositcheque_controller/FSxCDepositClearChequeInTmp';
/*===== End ใบนำฝาก ====================================================================*/

// ============================================== เงื่อนไขการแลกแต้ม =============================================== //
$route['dcmRDH/(:any)/(:any)']             = 'document/conditionredeem/Conditionredeem_controller/index/$1/$2';
$route['dcmRDHFormSearchList']             = 'document/conditionredeem/Conditionredeem_controller/FSvCRDHFormSearchList';
$route['dcmRDHGetDataTable']               = 'document/conditionredeem/Conditionredeem_controller/FSoCRDHGetDataTable';
$route['dcmRDHPageAdd']                    = 'document/conditionredeem/Conditionredeem_controller/FSoCRDHCallPageAdd';
$route['dcmRDHPageEdit']                   = 'document/conditionredeem/Conditionredeem_controller/FSoCRDHCallPageEdit';
$route['dcmRDHPageDetailDT']               = 'document/conditionredeem/Conditionredeem_controller/FSoCRDHCallPageDetailDT';
$route['dcmRDHEventAddCouponToDT']         = 'document/conditionredeem/Conditionredeem_controller/FSoCRDHCallEventAddCouponToDT';
$route['dcmRDHEventAdd']                   = 'document/conditionredeem/Conditionredeem_controller/FSoCRDHEventAdd';
$route['dcmRDHEventEdit']                  = 'document/conditionredeem/Conditionredeem_controller/FSoCRDHEventEdit';
$route['dcmRDHEventDelete']                = 'document/conditionredeem/Conditionredeem_controller/FSoCRDHEventDelete';
$route['dcmRDHEvenApprove']                = 'document/conditionredeem/Conditionredeem_controller/FSaCRDHEventAppove';
$route['dcmRDHEvenCancel']                 = 'document/conditionredeem/Conditionredeem_controller/FSaCRDHEventCancel';
$route['dcmRDHAddPdtIntoDTDocTemp']        = 'document/conditionredeem/Conditionredeem_controller/FSaCRDHEventAddPdtTemp';
$route['dcmRDHPdtAdvanceTableLoadData']    = 'document/conditionredeem/Conditionredeem_controller/FSaCRDHECallEventPdtTemp';
$route['dcmRDHPdtAdvanceTableDeleteSingle'] = 'document/conditionredeem/Conditionredeem_controller/FSaCRDHPdtAdvanceTableDeleteSingle';
$route['dcmRDHPdtClearConditionRedeemTmp']  = 'document/conditionredeem/Conditionredeem_controller/FSxCRDHClearConditionRedeemTmp';
$route['dcmRDHSaveGrpNameDTTemp']           = 'document/conditionredeem/Conditionredeem_controller/FSaCRDHInsertGrpNamePDTToTemp';
$route['dcmRDHGetGrpDTTemp']                = 'document/conditionredeem/Conditionredeem_controller/FSaCRDHGetGrpNamePDTToTemp';
$route['dcmRDHSetPdtGrpDTTemp']             = 'document/conditionredeem/Conditionredeem_controller/FSaCRDHSetPdtGrpDTTemp';
$route['dcmRDHDelGroupInDTTemp']            = 'document/conditionredeem/Conditionredeem_controller/FSaCRDHDelGroupInDTTemp';
$route['dcmRDHChangStatusAfApv']            = 'document/conditionredeem/Conditionredeem_controller/FSaCRDHChangStatusAfApv';

/*===== Begin โปรโมชั่น ==================================================================*/
// Master
$route ['promotion/(:any)/(:any)'] = 'document/promotion/Promotion_controller/index/$1/$2';
$route ['promotionList'] = 'document/promotion/Promotion_controller/FSxCPromotionList';
$route ['promotionDataTable'] = 'document/promotion/Promotion_controller/FSxCPromotionDataTable';
$route ['promotionCallPageAdd'] = 'document/promotion/Promotion_controller/FSxCPromotionAddPage';
$route ['promotionEventAdd'] = 'document/promotion/Promotion_controller/FSaCPromotionAddEvent';
$route ['promotionCallPageEdit'] = 'document/promotion/Promotion_controller/FSvCPromotionEditPage';
$route ['promotionEventEdit'] = 'document/promotion/Promotion_controller/FSaCPromotionEditEvent';
$route ['promotionUniqueValidate']  = 'document/promotion/Promotion_controller/FStCPromotionUniqueValidate/$1';
$route ['promotionDocApprove'] = 'document/promotion/Promotion_controller/FStCPromotionDocApprove';
$route ['promotionDocCancel'] = 'document/promotion/Promotion_controller/FStCPromotionDocCancel';
$route ['promotionDelDoc'] = 'document/promotion/Promotion_controller/FStPromotionDeleteDoc';
$route ['promotionDelDocMulti'] = 'document/promotion/Promotion_controller/FStPromotionDeleteMultiDoc';

// Step1 PMTDT Tmp
$route ['promotionStep1ConfirmPmtDtInTmp'] = 'document/promotion/Promotionstep1pmtdt_controller/FSxCPromotionConfirmPmtDtInTmp';
$route ['promotionStep1CancelPmtDtInTmp'] = 'document/promotion/Promotionstep1pmtdt_controller/FSxCPromotionCancelPmtDtInTmp';
$route ['promotionStep1PmtDtInTmpToBin'] = 'document/promotion/Promotionstep1pmtdt_controller/FSxCPromotionPmtDtInTmpToBin';
$route ['promotionStep1DeletePmtDtInTmp'] = 'document/promotion/Promotionstep1pmtdt_controller/FSxCPromotionDeletePmtDtInTmp';
$route ['promotionStep1DeleteMorePmtDtInTmp'] = 'document/promotion/Promotionstep1pmtdt_controller/FSxCPromotionDeleteMorePmtDtInTmp';
$route ['promotionStep1ClearPmtDtInTmp'] = 'document/promotion/Promotionstep1pmtdt_controller/FSxCPromotionClearPmtDtInTmp';
// Step1 Group Name
$route ['promotionStep1GetPmtDtGroupNameInTmp'] = 'document/promotion/Promotionstep1pmtdt_controller/FSxCPromotionGetPmtDtGroupNameInTmp';
$route ['promotionStep1DeletePmtDtGroupNameInTmp'] = 'document/promotion/Promotionstep1pmtdt_controller/FSxCPromotionDeletePmtDtGroupNameInTmp';
$route ['promotionStep1UniqueValidateGroupName']  = 'document/promotion/Promotionstep1pmtdt_controller/FStCPromotionPmtDtUniqueValidate';
// Step1 PDT Tmp
$route ['promotionStep1InsertPmtPdtDtToTmp'] = 'document/promotion/Promotionstep1pmtpdtdt_controller/FSaCPromotionInsertPmtPdtDtToTmp';
$route ['promotionStep1GetPmtPdtDtInTmp'] = 'document/promotion/Promotionstep1pmtpdtdt_controller/FSxCPromotionGetPmtPdtDtInTmp';
$route ['promotionStep1UpdatePmtPdtDtInTmp'] = 'document/promotion/Promotionstep1pmtpdtdt_controller/FSxCPromotionUpdatePmtPdtDtInTmp';
// Step1 Brand Tmp
$route ['promotionStep1InsertPmtBrandDtToTmp'] = 'document/promotion/Promotionstep1pmtbranddt_controller/FSaCPromotionInsertPmtBrandDtToTmp';
$route ['promotionStep1GetPmtBrandDtInTmp'] = 'document/promotion/Promotionstep1pmtbranddt_controller/FSxCPromotionGetPmtBrandDtInTmp';
$route ['promotionStep1UpdatePmtBrandDtInTmp'] = 'document/promotion/Promotionstep1pmtbranddt_controller/FSxCPromotionUpdatePmtBrandDtInTmp';
// Step1 Import PmtDt from Excel
$route ['promotionStep1ImportExcelPmtDtToTmp'] = 'document/promotion/Promotionstep1Importpmtexcel_controller/FStPromotionImportFromExcel';
// Step2 Group Name
$route ['promotionStep2GetPmtDtGroupNameInTmp'] = 'document/promotion/Promotionstep2pmtdt_controller/FSxCPromotionGetPmtDtGroupNameInTmp';
$route ['promotionStep2GetPmtCBInTmp'] = 'document/promotion/Promotionstep2pmtdt_controller/FStCPromotionGetPmtCBInTmp';
$route ['promotionStep2GetPmtCGInTmp'] = 'document/promotion/Promotionstep2pmtdt_controller/FStCPromotionGetPmtCGInTmp';
// Step3 PmtCB
$route ['promotionStep3GetPmtCBInTmp'] = 'document/promotion/Promotionstep3pmtcb_controller/FSxCPromotionGetPmtCBInTmp';
$route ['promotionStep3InsertPmtCBToTmp'] = 'document/promotion/Promotionstep3pmtcb_controller/FSaCPromotionInsertPmtCBToTmp';
$route ['promotionStep3UpdatePmtCBInTmp'] = 'document/promotion/Promotionstep3pmtcb_controller/FSxCPromotionUpdatePmtCBInTmp';
$route ['promotionStep3DeletePmtCBInTmp'] = 'document/promotion/Promotionstep3pmtcb_controller/FSaCPromotionDeletePmtCBInTmp';
$route ['promotionStep3UpdatePmtCGAndPmtCBPerAvgDisInTmp'] = 'document/promotion/Promotionstep3pmtcb_controller/FSxCPromotionUpdatePmtCGAndPmtCBPerAvgDisInTmp';
// Step3 PmtCG
$route ['promotionStep3GetPmtCGInTmp'] = 'document/promotion/Promotionstep3pmtcg_controller/FSxCPromotionGetPmtCGInTmp';
$route ['promotionStep3InsertPmtCGToTmp'] = 'document/promotion/Promotionstep3pmtcg_controller/FSaCPromotionInsertPmtCGToTmp';
$route ['promotionStep3UpdatePmtCGInTmp'] = 'document/promotion/Promotionstep3pmtcg_controller/FSxCPromotionUpdatePmtCGInTmp';
$route ['promotionStep3UpdatePmtCGPgtStaGetTypeInTmp'] = 'document/promotion/Promotionstep3pmtcg_controller/FSxCPromotionUpdatePmtCGPgtStaGetTypeInTmp';
$route ['promotionStep3DeletePmtCGInTmp'] = 'document/promotion/Promotionstep3pmtcg_controller/FSaCPromotionDeletePmtCGInTmp';
$route ['promotionStep3ClearPmtCGInTmp'] = 'document/promotion/Promotionstep3pmtcg_controller/FSxCPromotionClearPmtCGInTmp';
// Step3 PmtCB With PmtCG
$route ['promotionStep3GetPmtCBWithPmtCGInTmp'] = 'document/promotion/Promotionstep3pmtcb_controller/FSxCPromotionGetPmtCBWithPmtCGInTmp';
$route['promotionStep3InsertPmtCBAndPmtCGToTmp'] = 'document/promotion/Promotionstep3pmtcb_controller/FSaCPromotionInsertPmtCBAndPmtCGToTmp';
$route['promotionStep3DeletePmtCBAndPmtCGInTmpBySeq'] = 'document/promotion/Promotionstep3pmtcb_controller/FSaCPromotionDeletePmtCBAndPmtCGInTmpBySeq';
$route['promotionStep3GetPmtCBAndPmtCGPgtPerAvgDisInTmp'] = 'document/promotion/Promotionstep3pmtcb_controller/FStCPromotionGetPmtCBAndPmtCGPgtPerAvgDisInTmp';
// Step3 Coupon
$route ['promotionStep3InsertOrUpdateCouponToTmp'] = 'document/promotion/Promotionstep3coupon_controller/FSaCPromotionInsertOrUpdateCouponToTmp';
$route ['promotionStep3GetCouponInTmp'] = 'document/promotion/Promotionstep3coupon_controller/FStCPromotionGetCouponInTmp';
$route ['promotionStep3DeleteCouponInTmp'] = 'document/promotion/Promotionstep3coupon_controller/FSxCPromotionDeleteCouponInTmp';
// Step3 Point
$route ['promotionStep3InsertOrUpdatePointToTmp'] = 'document/promotion/Promotionstep3point_controller/FSaCPromotionInsertOrUpdatePointToTmp';
$route ['promotionStep3GetPointInTmp'] = 'document/promotion/Promotionstep3point_controller/FStCPromotionGetPointInTmp';
$route ['promotionStep3DeletePointInTmp'] = 'document/promotion/Promotionstep3point_controller/FSxCPromotionDeletePointInTmp';
// Step4 PriceGroup Condition
$route ['promotionStep4GetPriceGroupConditionInTmp'] = 'document/promotion/Promotionstep4pricegroupcondition_controller/FSxCPromotionGetPdtPmtHDCstPriInTmp';
$route ['promotionStep4InsertPriceGroupConditionToTmp'] = 'document/promotion/Promotionstep4pricegroupcondition_controller/FSaCPromotionInsertPriceGroupToTmp';
$route ['promotionStepeUpdatePriceGroupConditionInTmp'] = 'document/promotion/Promotionstep4pricegroupcondition_controller/FSxCPromotionUpdatePriceGroupInTmp';
$route ['promotionStep4DeletePriceGroupConditionInTmp'] = 'document/promotion/Promotionstep4pricegroupcondition_controller/FSxCPromotionDeletePriceGroupInTmp';
// Step4 Channel Condition
$route ['promotionStep4GetChnConditionInTmp'] = 'document/promotion/Promotionstep4chncondition_controller/FSxCPromotionGetHDChnInTmp';
$route ['promotionStep4InsertChnConditionToTmp'] = 'document/promotion/Promotionstep4chncondition_controller/FSaCPromotionInsertChnToTmp';
$route ['promotionStepeUpdateChnConditionInTmp'] = 'document/promotion/Promotionstep4chncondition_controller/FSxCPromotionUpdateChnInTmp';
$route ['promotionStep4DeleteChnConditionInTmp'] = 'document/promotion/Promotionstep4chncondition_controller/FSxCPromotionDeleteChnInTmp';
// Step4 Zone Condition
$route ['promotionStep4GetZoneConditionInTmp'] = 'document/promotion/Promotionstep4zonecondition_controller/FSxCPromotionGetHDZoneInTmp';
$route ['promotionStep4InsertZoneConditionToTmp'] = 'document/promotion/Promotionstep4zonecondition_controller/FSaCPromotionInsertZoneToTmp';
$route ['promotionStepeUpdateZoneConditionInTmp'] = 'document/promotion/Promotionstep4zonecondition_controller/FSxCPromotionUpdateZoneInTmp';
$route ['promotionStep4DeleteZoneConditionInTmp'] = 'document/promotion/Promotionstep4zonecondition_controller/FSxCPromotionDeleteZoneInTmp';
// Step4 Branch Condition
$route ['promotionStep4GetBchConditionInTmp'] = 'document/promotion/Promotionstep4bchcondition_controller/FSxCPromotionGetBchConditionInTmp';
$route ['promotionStep4InsertBchConditionToTmp'] = 'document/promotion/Promotionstep4bchcondition_controller/FSaCPromotionInsertBchConditionToTmp';
$route ['promotionStepeUpdateBchConditionInTmp'] = 'document/promotion/Promotionstep4bchcondition_controller/FSxCPromotionUpdateBchConditionInTmp';
$route ['promotionStep4DeleteBchConditionInTmp'] = 'document/promotion/Promotionstep4bchcondition_controller/FSxCPromotionDeleteBchConditionInTmp';
// Step5 Check and Confirm
$route ['promotionStep5GetCheckAndConfirmPage'] = 'document/promotion/Promotionstep5checkandconfirm_controller/FSxCPromotionGetCheckAndConfirmPage';
$route ['promotionStep5UpdatePmtCBStaCalSumInTmp'] = 'document/promotion/Promotionstep5checkandconfirm_controller/FSxCPromotionUpdatePmtCBStaCalSumInTmp';
$route ['promotionStep5UpdatePmtCGStaGetEffectInTmp'] = 'document/promotion/Promotionstep5checkandconfirm_controller/FSxCPromotionUpdatePmtCGStaGetEffectInTmp';
// Create Promotion By Import
$route ['promotionImportExcelToTmp'] = 'document/promotion/Promotionstep1Importpmtexcel_controller/FStPromotionImportExcelToTmp';
$route ['promotionGetImportExcelMainPage'] = 'document/promotion/Promotionstep1Importpmtexcel_controller/FStPromotionGetImportExcelMainPage';
$route ['promotionImportExcelTempToMaster'] = 'document/promotion/Promotionstep1Importpmtexcel_controller/FSoCImportTempToMaster';
$route ['promotionClearImportExcelInTmp'] = 'document/promotion/Promotionstep1Importpmtexcel_controller/FSoCImportClearInTemp';
// Summary HD
// Product Group
$route ['promotionGetImportExcelPdtGroupInTmp'] = 'document/promotion/Promotionstep1Importpmtexcel_controller/FSoCImportGetPdtGroupInTmp';
$route ['promotionGetImportExcelPdtGroupDataJsonInTmp'] = 'document/promotion/Promotionstep1Importpmtexcel_controller/FSoCImportGetPdtGroupDataJsonInTmp';
$route ['promotionDeleteImportExcelPdtGroupInTempBySeq'] = 'document/promotion/Promotionstep1Importpmtexcel_controller/FSoCImportDeletePdtGroupInTempBySeqNo';
$route ['promotionGetImportExcelPdtGroupStaInTmp'] = 'document/promotion/Promotionstep1Importpmtexcel_controller/FSoCImportGetStaPdtGroupInTemp';
// Condition-กลุ่มซื้อ
$route ['promotionGetImportExcelCBInTmp'] = 'document/promotion/Promotionstep1Importpmtexcel_controller/FSoCImportGetCBInTmp';
$route ['promotionGetImportExcelCBDataJsonInTmp'] = 'document/promotion/Promotionstep1Importpmtexcel_controller/FSoCImportGetCBDataJsonInTmp';
$route ['promotionDeleteImportExcelCBInTempBySeq'] = 'document/promotion/Promotionstep1Importpmtexcel_controller/FSoCImportDeleteCBInTempBySeqNo';
$route ['promotionGetImportExcelCBStaInTmp'] = 'document/promotion/Promotionstep1Importpmtexcel_controller/FSoCImportGetStaCBInTemp';
// Option1-กลุ่มรับ(กรณีส่วนลด)
$route ['promotionGetImportExcelCGInTmp'] = 'document/promotion/Promotionstep1Importpmtexcel_controller/FSoCImportGetCGInTmp';
$route ['promotionGetImportExcelCGDataJsonInTmp'] = 'document/promotion/Promotionstep1Importpmtexcel_controller/FSoCImportGetCGDataJsonInTmp';
$route ['promotionDeleteImportExcelCGInTempBySeq'] = 'document/promotion/Promotionstep1Importpmtexcel_controller/FSoCImportDeleteCGInTempBySeqNo';
$route ['promotionGetImportExcelCGStaInTmp'] = 'document/promotion/Promotionstep1Importpmtexcel_controller/FSoCImportGetStaCGInTemp';
// Option2-กลุ่มรับ(กรณีcoupon)
// Option3-กลุ่มรับ(กรณีแต้ม)
/*===== End โปรโมชั่น ====================================================================*/

//ใบจ่ายโอน - เนลว์ 06/03/2020
$route ['TWO/(:any)/(:any)/(:any)']                          = 'document/transferwarehouseout/Transferwarehouseout_controller/index/$1/$2/$3';
$route ['TWOTransferwarehouseoutList']                       = 'document/transferwarehouseout/Transferwarehouseout_controller/FSxCTWOTransferwarehouseoutList';
$route ['TWOTransferwarehouseoutDataTable']                  = 'document/transferwarehouseout/Transferwarehouseout_controller/FSxCTWOTransferwarehouseoutDataTable';
$route ['TWOTransferwarehouseoutPageAdd']                    = 'document/transferwarehouseout/Transferwarehouseout_controller/FSvCTWOTransferwarehouseoutPageAdd';
$route ['TWOTransferwarehouseoutPageEdit']                   = 'document/transferwarehouseout/Transferwarehouseout_controller/FSvCTWOTransferwarehouseoutPageEdit';
$route ['TWOTransferwarehouseoutPdtAdvanceTableLoadData']    = 'document/transferwarehouseout/Transferwarehouseout_controller/FSoCTWOPdtAdvTblLoadData';
$route ['TWOTransferAdvanceTableShowColList']                = 'document/transferwarehouseout/Transferwarehouseout_controller/FSoCTWOAdvTblShowColList';
$route ['TWOTransferAdvanceTableShowColSave']                = 'document/transferwarehouseout/Transferwarehouseout_controller/FSoCTWOAdvTalShowColSave';
$route ['TWOTransferwarehouseoutAddPdtIntoDTDocTemp']        = 'document/transferwarehouseout/Transferwarehouseout_controller/FSoCTWOAddPdtIntoDocDTTemp';
$route ['TWOTransferwarehouseoutRemovePdtInDTTmp']           = 'document/transferwarehouseout/Transferwarehouseout_controller/FSvCTWORemovePdtInDTTmp';
$route ['TWOTransferwarehouseoutRemovePdtInDTTmpMulti']      = 'document/transferwarehouseout/Transferwarehouseout_controller/FSvCTWORemovePdtInDTTmpMulti';
$route ['dcmTWOEventEdit']                                   = 'document/transferwarehouseout/Transferwarehouseout_controller/FSoCTWOEditEventDoc';
$route ['dcmTWOEventAdd']                                    = 'document/transferwarehouseout/Transferwarehouseout_controller/FSoCTWOAddEventDoc';
$route ['TWOTransferwarehouseoutEventDelete']                = 'document/transferwarehouseout/Transferwarehouseout_controller/FSoCTWODeleteEventDoc';
$route ['TWOTransferwarehouseoutEventCencel']                = 'document/transferwarehouseout/Transferwarehouseout_controller/FSoCTWOEventCancel';
$route ['TWOTransferwarehouseoutEventEditInline']            = 'document/transferwarehouseout/Transferwarehouseout_controller/FSoCTWOEditPdtIntoDocDTTemp';
// $route ['TWOTransferwarehouseoutSelectPDTInCN']              = 'document/transferwarehouseout/Transferwarehouseout_controller/FSoCTWOSelectPDTInCN';
$route ['TWOTransferwarehouseoutEventApproved']              = 'document/transferwarehouseout/Transferwarehouseout_controller/FSoCTWOApproved';

/*===== Begin ใบจ่ายโอน - สาขา ==========================================================*/
// Master
$route ['docTransferBchOut/(:any)/(:any)'] = 'document/transfer_branch_out/Transferbchout_controller/index/$1/$2';
$route ['docTransferBchOutList'] = 'document/transfer_branch_out/Transferbchout_controller/FSxCTransferBchOutList';
$route ['docTransferBchOutDataTable'] = 'document/transfer_branch_out/Transferbchout_controller/FSxCTransferBchOutDataTable';
$route ['docTransferBchOutCallPageAdd'] = 'document/transfer_branch_out/Transferbchout_controller/FSxCTransferBchOutAddPage';
$route ['docTransferBchOutEventAdd'] = 'document/transfer_branch_out/Transferbchout_controller/FSaCTransferBchOutAddEvent';
$route ['docTransferBchOutCallPageEdit'] = 'document/transfer_branch_out/Transferbchout_controller/FSvCTransferBchOutEditPage';
$route ['docTransferBchOutEventEdit'] = 'document/transfer_branch_out/Transferbchout_controller/FSaCTransferBchOutEditEvent';
$route ['docTransferBchOutUniqueValidate']  = 'document/transfer_branch_out/Transferbchout_controller/FStCTransferBchOutUniqueValidate/$1';
$route ['docTransferBchOutDocApprove'] = 'document/transfer_branch_out/Transferbchout_controller/FStCTransferBchOutDocApprove';
$route ['docTransferBchOutDocCancel'] = 'document/transfer_branch_out/Transferbchout_controller/FStCTransferBchOutDocCancel';
$route ['docTransferBchOutDelDoc'] = 'document/transfer_branch_out/Transferbchout_controller/FStTransferBchOutDeleteDoc';
$route ['docTransferBchOutDelDocMulti'] = 'document/transfer_branch_out/Transferbchout_controller/FStTransferBchOutDeleteMultiDoc';
// Pdt Temp
$route ['docTransferBchOutInsertPdtToTmp'] = 'document/transfer_branch_out/Transferbchoutpdt_controller/FSaCTransferBchOutInsertPdtToTmp';
$route ['docTransferBchOutGetPdtInTmp'] = 'document/transfer_branch_out/Transferbchoutpdt_controller/FSxCTransferBchOutGetPdtInTmp';
$route ['docTransferBchOutUpdatePdtInTmp'] = 'document/transfer_branch_out/Transferbchoutpdt_controller/FSxCTransferBchOutUpdatePdtInTmp';
$route ['docTransferBchOutDeletePdtInTmp'] = 'document/transfer_branch_out/Transferbchoutpdt_controller/FSxCTransferBchOutDeletePdtInTmp';
$route ['docTransferBchOutDeleteMorePdtInTmp'] = 'document/transfer_branch_out/Transferbchoutpdt_controller/FSxCTransferBchOutDeleteMorePdtInTmp';
$route ['docTransferBchOutClearPdtInTmp'] = 'document/transfer_branch_out/Transferbchoutpdt_controller/FSxCTransferBchOutClearPdtInTmp';
// Pdt Options
$route ['docTransferBchOutGetPdtColumnList']= 'document/transfer_branch_out/Transferbchoutpdt_controller/FStCTransferBchOutGetPdtColumnList';
$route ['docTransferBchOutUpdatePdtColumn']= 'document/transfer_branch_out/Transferbchoutpdt_controller/FStCTransferBchOutUpdatePdtColumn';
/*===== End ใบจ่ายโอน - สาขา ============================================================*/

//ใบรับโอน - สาขา เนลว์ 20/03/2020
$route ['docTBI/(:any)/(:any)/(:any)']       = 'document/transferreceiptbranch/Transferreceiptbranch_controller/index/$1/$2/$3';
$route ['docTBIPageList']                    = 'document/transferreceiptbranch/Transferreceiptbranch_controller/FSxCTBIPageList';
$route ['docTBIPageDataTable']               = 'document/transferreceiptbranch/Transferreceiptbranch_controller/FSxCTBIPageDataTable';
$route ['docTBIPageAdd']                     = 'document/transferreceiptbranch/Transferreceiptbranch_controller/FSvCTBIPageAdd';
$route ['docTBIPageEdit']                    = 'document/transferreceiptbranch/Transferreceiptbranch_controller/FSvCTBIPageEdit';
$route ['docTBIPagePdtAdvanceTableLoadData'] = 'document/transferreceiptbranch/Transferreceiptbranch_controller/FSoCTBIPagePdtAdvTblLoadData';
$route ['docTBIPageTableShowColList']        = 'document/transferreceiptbranch/Transferreceiptbranch_controller/FSoCTBIPageAdvTblShowColList';
$route ['docTBIEventTableShowColSave']       = 'document/transferreceiptbranch/Transferreceiptbranch_controller/FSoCTBIEventAdvTalShowColSave';
$route ['docTBIEventAddPdtIntoDTDocTemp']    = 'document/transferreceiptbranch/Transferreceiptbranch_controller/FSoCTBIEventAddPdtIntoDocDTTemp';
$route ['docTBIEventRemovePdtInDTTmp']       = 'document/transferreceiptbranch/Transferreceiptbranch_controller/FSvCTBIEventRemovePdtInDTTmp';
$route ['docTBIEventRemovePdtInDTTmpMulti']  = 'document/transferreceiptbranch/Transferreceiptbranch_controller/FSvCTBIEventRemovePdtInDTTmpMulti';
$route ['docTBIEventEdit']                   = 'document/transferreceiptbranch/Transferreceiptbranch_controller/FSoCTBIEventEdit';
$route ['docTBIEventAdd']                    = 'document/transferreceiptbranch/Transferreceiptbranch_controller/FSoCTBIEventAdd';
$route ['docTBIEventDelete']                 = 'document/transferreceiptbranch/Transferreceiptbranch_controller/FSoCTBIEventDelete';
$route ['docTBIEventCencel']                 = 'document/transferreceiptbranch/Transferreceiptbranch_controller/FSoCTBIEventCancel';
$route ['docTBIEventEditInline']             = 'document/transferreceiptbranch/Transferreceiptbranch_controller/FSoCTBIEventEditPdtIntoDocDTTemp';
$route ['docTBIPageSelectPDTInCN']           = 'document/transferreceiptbranch/Transferreceiptbranch_controller/FSoCTBIPageSelectPDTInCN';
$route ['docTBIEventApproved']               = 'document/transferreceiptbranch/Transferreceiptbranch_controller/FSoCTBIEventApproved';
$route ['docTBIEventClearTemp']               = 'document/transferreceiptbranch/Transferreceiptbranch_controller/FSxCTBIEventClearTemp';
$route ['docTBIEventGetPdtIntDTBch']         = 'document/transferreceiptbranch/Transferreceiptbranch_controller/FSoCTBIEventGetPdtIntDTBch';

//ใบรับโอน - คลังสินค้า - วัฒน์ 20/02/2020
$route ['TWI/(:any)/(:any)']                         = 'document/transferreceiptnew/Transferreceiptnew_controller/index/$1/$2';
$route ['TWITransferReceiptList']                    = 'document/transferreceiptnew/Transferreceiptnew_controller/FSxCTWITransferReceiptList';
$route ['TWITransferReceiptDataTable']               = 'document/transferreceiptnew/Transferreceiptnew_controller/FSxCTWITransferReceiptDataTable';
$route ['TWITransferReceiptPageAdd']                 = 'document/transferreceiptnew/Transferreceiptnew_controller/FSvCTWITransferReceiptPageAdd';
$route ['TWITransferReceiptPageEdit']                = 'document/transferreceiptnew/Transferreceiptnew_controller/FSvCTWITransferReceiptPageEdit';
$route ['TWITransferReceiptPdtAdvanceTableLoadData'] = 'document/transferreceiptnew/Transferreceiptnew_controller/FSoCTWIPdtAdvTblLoadData';
$route ['TWITransferAdvanceTableShowColList']        = 'document/transferreceiptnew/Transferreceiptnew_controller/FSoCTWIAdvTblShowColList';
$route ['TWITransferAdvanceTableShowColSave']        = 'document/transferreceiptnew/Transferreceiptnew_controller/FSoCTWIAdvTalShowColSave';
$route ['TWITransferReceiptAddPdtIntoDTDocTemp']     = 'document/transferreceiptnew/Transferreceiptnew_controller/FSoCTWIAddPdtIntoDocDTTemp';
$route ['TWITransferReceiptRemovePdtInDTTmp']        = 'document/transferreceiptnew/Transferreceiptnew_controller/FSvCTWIRemovePdtInDTTmp';
$route ['TWITransferReceiptRemovePdtInDTTmpMulti']   = 'document/transferreceiptnew/Transferreceiptnew_controller/FSvCTWIRemovePdtInDTTmpMulti';
$route ['dcmTWIEventEdit']                           = 'document/transferreceiptnew/Transferreceiptnew_controller/FSoCTWIEditEventDoc';
$route ['dcmTWIEventAdd']                            = 'document/transferreceiptnew/Transferreceiptnew_controller/FSoCTWIAddEventDoc';
$route ['TWITransferReceiptEventDelete']             = 'document/transferreceiptnew/Transferreceiptnew_controller/FSoCTWIDeleteEventDoc';
$route ['TWITransferReceiptEventCencel']             = 'document/transferreceiptnew/Transferreceiptnew_controller/FSoCTWIEventCancel';
$route ['TWITransferReceiptEventEditInline']         = 'document/transferreceiptnew/Transferreceiptnew_controller/FSoCTWIEditPdtIntoDocDTTemp';
$route ['TWITransferReceiptSelectPDTInCN']           = 'document/transferreceiptnew/Transferreceiptnew_controller/FSoCTWISelectPDTInCN';
$route ['TWITransferReceiptEventApproved']           = 'document/transferreceiptnew/Transferreceiptnew_controller/FSoCTWIApproved';
$route ['TWITransferReceiptRefDoc']                  = 'document/transferreceiptnew/Transferreceiptnew_controller/FSaCTWIRefDoc';
$route ['TWITransferReceiptRefGetWah']               = 'document/transferreceiptnew/Transferreceiptnew_controller/FSaCTWIGetWahRefDoc';

//ใบรับเข้า - คลังสินค้า - วัฒน์ 20/02/2020
$route ['TXOOut/(:any)/(:any)']                         = 'document/transferreceiptOut/Transferreceiptout_controller/index/$1/$2';
$route ['TXOOutTransferReceiptList']                    = 'document/transferreceiptOut/Transferreceiptout_controller/FSxCTWOTransferReceiptList';
$route ['TXOOutTransferReceiptDataTable']               = 'document/transferreceiptOut/Transferreceiptout_controller/FSxCTWOTransferReceiptDataTable';
$route ['TXOOutTransferReceiptPageAdd']                 = 'document/transferreceiptOut/Transferreceiptout_controller/FSvCTWOTransferReceiptPageAdd';
$route ['TXOOutTransferReceiptPageEdit']                = 'document/transferreceiptOut/Transferreceiptout_controller/FSvCTWOTransferReceiptPageEdit';
$route ['TXOOutTransferReceiptPdtAdvanceTableLoadData'] = 'document/transferreceiptOut/Transferreceiptout_controller/FSoCTWOPdtAdvTblLoadData';
$route ['TXOOutTransferAdvanceTableShowColList']        = 'document/transferreceiptOut/Transferreceiptout_controller/FSoCTWOAdvTblShowColList';
$route ['TXOOutTransferAdvanceTableShowColSave']        = 'document/transferreceiptOut/Transferreceiptout_controller/FSoCTWOAdvTalShowColSave';
$route ['TXOOutTransferReceiptAddPdtIntoDTDocTemp']     = 'document/transferreceiptOut/Transferreceiptout_controller/FSoCTWOAddPdtIntoDocDTTemp';
$route ['TXOOutTransferReceiptRemovePdtInDTTmp']        = 'document/transferreceiptOut/Transferreceiptout_controller/FSvCTWORemovePdtInDTTmp';
$route ['TXOOutTransferReceiptRemovePdtInDTTmpMulti']   = 'document/transferreceiptOut/Transferreceiptout_controller/FSvCTWORemovePdtInDTTmpMulti';
$route ['dcmTXOOutEventEdit']                           = 'document/transferreceiptOut/Transferreceiptout_controller/FSoCTWOEditEventDoc';
$route ['dcmTXOOutEventAdd']                            = 'document/transferreceiptOut/Transferreceiptout_controller/FSoCTWOAddEventDoc';
$route ['TXOOutTransferReceiptEventDelete']             = 'document/transferreceiptOut/Transferreceiptout_controller/FSoCTWODeleteEventDoc';
$route ['TXOOutTransferReceiptEventCencel']             = 'document/transferreceiptOut/Transferreceiptout_controller/FSoCTWOEventCancel';
$route ['TXOOutTransferReceiptEventEditInline']         = 'document/transferreceiptOut/Transferreceiptout_controller/FSoCTWOEditPdtIntoDocDTTemp';
$route ['TXOOutTransferReceiptSelectPDTInCN']           = 'document/transferreceiptOut/Transferreceiptout_controller/FSoCTWOSelectPDTInCN';
$route ['TXOOutTransferReceiptEventApproved']           = 'document/transferreceiptOut/Transferreceiptout_controller/FSoCTWOApproved';


//หาราคาที่มีส่วนลด
$route ['GetPriceAlwDiscount']                          = 'document/creditnote/Creditnotedischgmodal_controller/FSaCCENGetPriceAlwDiscount';




//เอกสารใบตรวจนับ - รวม สินค้าคงคลัง
$route['docSM/(:any)/(:any)']              = 'document/adjuststocksum/Adjuststocksum_controller/index/$1/$2';
$route['docSMFormSearchList']              = 'document/adjuststocksum/Adjuststocksum_controller/FSvCSMFormSearchList';
$route['docSMDataTable']                   = 'document/adjuststocksum/Adjuststocksum_controller/FSoCSMGetDataTable';
$route['docSMPageAdd']                     = 'document/adjuststocksum/Adjuststocksum_controller/FSoCSMCallPageAdd';
$route['docSMPageEdit']                    = 'document/adjuststocksum/Adjuststocksum_controller/FSoCSMCallPageEdit';
$route['docSMEventCallPdtStkSum']          = 'document/adjuststocksum/Adjuststocksum_controller/FSoCSMEventCallPdtStkSum';
$route['docSMTableLoadData']               = 'document/adjuststocksum/Adjuststocksum_controller/FSoCSMCallTableLoadData';
$route['docSMEventEditInLine']             = 'document/adjuststocksum/Adjuststocksum_controller/FSoCSMEventEditInLine';
$route['docSMEventRemovePdtInDTTmp']       = 'document/adjuststocksum/Adjuststocksum_controller/FSvCEventRemovePdtInDTTmp';
$route['docSMEventRemoveMultiPdtInDTTmp']  = 'document/adjuststocksum/Adjuststocksum_controller/FSvCEventRemoveMultiPdtInDTTmp';
$route['docSMEventClearTemp']              = 'document/adjuststocksum/Adjuststocksum_controller/FSxCSMEventClearTemp';
$route['docSMEventDelete']                 = 'document/adjuststocksum/Adjuststocksum_controller/FSaCSMEventDelete';
$route['docSMEventAdd']                    = 'document/adjuststocksum/Adjuststocksum_controller/FSoCSMEventAdd';
$route['docSMEventEdit']                   = 'document/adjuststocksum/Adjuststocksum_controller/FSoCSMEventEdit';
$route['docSMEventApprove']                 = 'document/adjuststocksum/Adjuststocksum_controller/FSaCSMEventAppove';
$route['docSMEventCancel']                  = 'document/adjuststocksum/Adjuststocksum_controller/FSaCSMEventCancel';



//เอกสารใบสั้งซื้อ วัฒน์ ยังทำไม่เสร็จ ย้ายไปทำ task อื่นก่อน
// $route ['docPO/(:any)/(:any)']                          = 'document/purchaseorderNew/Purchaseorder_controller/index/$1/$2';
// $route ['docPOList']                                    = 'document/purchaseorderNew/Purchaseorder_controller/FSxCDPODocumentList';
// $route ['docPODataTable']                               = 'document/purchaseorderNew/Purchaseorder_controller/FSxCDPODocumentDataTable';
// $route ['docPOPageAdd']                                 = 'document/purchaseorderNew/Purchaseorder_controller/FSxCDPODocumentPageAdd';
// $route ['docPOEventEdit']                               = '';
// $route ['docPOEventAdd']                                = '';
// $route ['docPOLoadPDTTmp']                              = 'document/purchaseorderNew/Purchaseorder_controller/FSxCDPODocumentLoadPDTTmp';
