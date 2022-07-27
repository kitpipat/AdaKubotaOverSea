<?php

// Product
$route ['product/(:any)/(:any)']        = 'product/product/Product_controller/index/$1/$2';
$route ['productMain']                  = 'product/product/Product_controller/FSvCPDTCallPageMain';
$route ['productDataTable']             = 'product/product/Product_controller/FSvCPDTCallPageDataTable';
$route ['productAdvTableShwColList']    = 'product/product/Product_controller/FSoCPDTAdvTableShwColList';
$route ['productAdvTableShwColSave']    = 'product/product/Product_controller/FSnCPDTAdvTableShwColSave';
$route ['productPageAdd']               = 'product/product/Product_controller/FSoCPDTCallPageAdd';
$route ['productPageEdit']              = 'product/product/Product_controller/FSoCPDTCallPageEdit';
$route ['productAddPackSizeUnit']       = 'product/product/Product_controller/FSoCPDTPackSizeAdd';
$route ['productUpdatePackSizeUnit']    = 'product/product/Product_controller/FSoCPDTPackSizeUpdate';
// $route ['productUpdatePdtUnitFact']     = 'product/product/Product_controller/FSoCPDTPdtUnitFactUpdate';
$route ['productGetPackSizeUnit']       = 'product/product/Product_controller/FSoCPDTPackSizeDataTable';
$route ['productDelPackSizeUnit']       = 'product/product/Product_controller/FSoCPDTPackSizeDelete';
$route ['productGetEvnNotSale']         = 'product/product/Product_controller/FSoCPDTEvnNotSaleDataTable';
$route ['productGetDataPdtSet']         = 'product/product/Product_controller/FSoCPDTPdtSetDataTable';
$route ['productChkBarCodeDup']         = 'product/product/Product_controller/FSoCPDTChkBarcodeDup';
$route ['productEventAdd']              = 'product/product/Product_controller/FSoCPDTAddEvent';
$route ['productEventEdit']             = 'product/product/Product_controller/FSoCPDTEditEvent';
$route ['productEventDelete']           = 'product/product/Product_controller/FSoCPDTDeleteEvent';
$route ['productGetDataBarCode']        = 'product/product/Product_controller/FSoCPDTBarCodeDataTable';
$route ['productUpdateBarCode']         = 'product/product/Product_controller/FSoCPDTUpdateBarCode';
$route ['productDeleteBarCode']         = 'product/product/Product_controller/FSoCPDTDeleteBarCode';

//Product Set
$route ['productSetDataTable']          = 'product/product/Product_controller/FSaCPDTSETCallDataTable';
$route ['productSetCallPageAdd']        = 'product/product/Product_controller/FSaCPDTSETCallPageAdd';
$route ['productSetEventAdd']           = 'product/product/Product_controller/FSaCPDTSETEventAdd';
$route ['productSetCallPageEdit']       = 'product/product/Product_controller/FSaCPDTSETCallPageEdit';
$route ['productSetEventDelete']        = 'product/product/Product_controller/FSaCPDTSETEventDelete';
$route ['productSetUpdStaSetPri']       = 'product/product/Product_controller/FSaCPDTSETUpdateStaSetPri';
$route ['productSetUpdStaSetShwDT']     = 'product/product/Product_controller/FSaCPDTSETUpdateStaSetShwDT';

// Product Modal Price Route
$route ['productCallModalPriceList']    = 'product/phpprice/Pdtprice_controller/FSvCallPdtPriceList';
$route ['productPriceTablePRI4PDT']     = 'product/phpprice/Pdtprice_controller/FSvCallPdtTablePrice4PDT';
$route ['productPriceTablePRI4CST']     = 'product/phpprice/Pdtprice_controller/FSvCallPdtTablePrice4CST';
$route ['productPriceTablePRI4ZNE']     = 'product/phpprice/Pdtprice_controller/FSvCallPdtTablePrice4ZNE';
$route ['productPriceTablePRI4BCH']     = 'product/phpprice/Pdtprice_controller/FSvCallPdtTablePrice4BCH';
$route ['productPriceTablePRI4AGG']     = 'product/phpprice/Pdtprice_controller/FSvCallPdtTablePrice4AGG';


//Product Unit
$route ['pdtunit/(:any)/(:any)']    = 'product/pdtunit/Pdtunit_controller/index/$1/$2';
$route ['pdtunitList']              = 'product/pdtunit/Pdtunit_controller/FSvCPUNListPage';
$route ['pdtunitDataTable']         = 'product/pdtunit/Pdtunit_controller/FSvCPUNDataList';
$route ['pdtunitPageAdd']           = 'product/pdtunit/Pdtunit_controller/FSvCPUNAddPage';
$route ['pdtunitPageEdit']          = 'product/pdtunit/Pdtunit_controller/FSvCPUNEditPage';
$route ['pdtunitEventAdd']          = 'product/pdtunit/Pdtunit_controller/FSoCPUNAddEvent';
$route ['pdtunitEventEdit']         = 'product/pdtunit/Pdtunit_controller/FSoCPUNEditEvent';
$route ['pdtunitEventDelete']       = 'product/pdtunit/Pdtunit_controller/FSoCPUNDeleteEvent';

//Product Group
$route ['pdtgroup/(:any)/(:any)']    = 'product/pdtgroup/Pdtgroup_controller/index/$1/$2';
$route ['pdtgroupList']              = 'product/pdtgroup/Pdtgroup_controller/FSvCPGPListPage';
$route ['pdtgroupDataTable']         = 'product/pdtgroup/Pdtgroup_controller/FSvCPGPDataList';
$route ['pdtgroupPageAdd']           = 'product/pdtgroup/Pdtgroup_controller/FSvCPGPAddPage';
$route ['pdtgroupPageEdit']          = 'product/pdtgroup/Pdtgroup_controller/FSvCPGPEditPage';
$route ['pdtgroupEventAdd']          = 'product/pdtgroup/Pdtgroup_controller/FSoCPGPAddEvent';
$route ['pdtgroupEventEdit']         = 'product/pdtgroup/Pdtgroup_controller/FSoCPGPEditEvent';
$route ['pdtgroupEventDelete']       = 'product/pdtgroup/Pdtgroup_controller/FSoCPGPDeleteEvent';

//MerchantProduct Group
$route ['MerPdtGrp/(:any)/(:any)']   = 'product/merpdtgroup/Merpdtgroup_controller/index/$1/$2';
$route ['MerPdtGroupList']           = 'product/merpdtgroup/Merpdtgroup_controller/FSvCMGPListPage';
$route ['MerPdtGroupDataTable']      = 'product/merpdtgroup/Merpdtgroup_controller/FSvCMgpDataList';
$route ['MerPdtGroupPageAdd']        = 'product/merpdtgroup/Merpdtgroup_controller/FSvCMGPAddPage';
$route ['MerchantProductEventAdd']   = 'product/merpdtgroup/Merpdtgroup_controller/FSoCMGPAddEvent';
$route ['MerchantProductEventDelete']   = 'product/merpdtgroup/Merpdtgroup_controller/FSoCMgpDeleteEvent';
$route ['MerPdtGroupPageEdit']       = 'product/merpdtgroup/Merpdtgroup_controller/FSvCMGPEditPage';
$route ['MerchantProductEventEdit']  = 'product/merpdtgroup/Merpdtgroup_controller/FSoCMGPEditEvent';


//Product PriceGroup (กลุ่มราคา)
$route ['pdtpricegroup/(:any)/(:any)']  = 'product/pdtpricegroup/Pdtpricegroup_controller/index/$1/$2';
$route ['pdtpricegroupList']          = 'product/pdtpricegroup/Pdtpricegroup_controller/FSvCPPLListPage';
$route ['pdtpricegroupDataTable']     = 'product/pdtpricegroup/Pdtpricegroup_controller/FSvCPPLDataList';
$route ['pdtpricegroupPageAdd']       = 'product/pdtpricegroup/Pdtpricegroup_controller/FSvCPPLAddPage';
$route ['pdtpricegroupPageEdit']      = 'product/pdtpricegroup/Pdtpricegroup_controller/FSvCPPLEditPage';
$route ['pdtpricegroupEventAdd']      = 'product/pdtpricegroup/Pdtpricegroup_controller/FSoCPPLAddEvent';
$route ['pdtpricegroupEventEdit']     = 'product/pdtpricegroup/Pdtpricegroup_controller/FSoCPPLEditEvent';
$route ['pdtpricegroupEventDelete']   = 'product/pdtpricegroup/Pdtpricegroup_controller/FSoCPPLDeleteEvent';

//Product Promotion Group (กลุ่มโปรโมชั่น)
$route ['pdtpmggroup/(:any)/(:any)'] = 'product/pdtpromotiongroup/Pdtpmggrp_controller/index/$1/$2';
$route ['pdtpromotionList']          = 'product/pdtpromotiongroup/Pdtpmggrp_controller/FSvCPMGListPage';
$route ['pdtpromotionDataTable']     = 'product/pdtpromotiongroup/Pdtpmggrp_controller/FSvCPMGDataList';
$route ['pdtpromotionPageAdd']       = 'product/pdtpromotiongroup/Pdtpmggrp_controller/FSvCPMGAddPage';
$route ['pdtpromotionPageEdit']      = 'product/pdtpromotiongroup/Pdtpmggrp_controller/FSvCPMGEditPage';
$route ['pdtpromotionEventAdd']      = 'product/pdtpromotiongroup/Pdtpmggrp_controller/FSoCPMGAddEvent';
$route ['pdtpromotionEventEdit']     = 'product/pdtpromotiongroup/Pdtpmggrp_controller/FSoCPMGEditEvent';
$route ['pdtpromotionEventDelete']   = 'product/pdtpromotiongroup/Pdtpmggrp_controller/FSoCPMGDeleteEvent';

//Product Type
$route ['pdttype/(:any)/(:any)']    = 'product/pdttype/Pdttype_controller/index/$1/$2';
$route ['pdttypeList']              = 'product/pdttype/Pdttype_controller/FSvCPTYListPage';
$route ['pdttypeDataTable']         = 'product/pdttype/Pdttype_controller/FSvCPTYDataList';
$route ['pdttypePageAdd']           = 'product/pdttype/Pdttype_controller/FSvCPTYAddPage';
$route ['pdttypePageEdit']          = 'product/pdttype/Pdttype_controller/FSvCPTYEditPage';
$route ['pdttypeEventAdd']          = 'product/pdttype/Pdttype_controller/FSoCPTYAddEvent';
$route ['pdttypeEventEdit']         = 'product/pdttype/Pdttype_controller/FSoCPTYEditEvent';
$route ['pdttypeEventDelete']       = 'product/pdttype/Pdttype_controller/FSoCPTYDeleteEvent';

//Product Brand (ยี่ห้อ)
$route ['pdtbrand/(:any)/(:any)']    = 'product/pdtbrand/Pdtbrand_controller/index/$1/$2';
$route ['pdtbrandList']              = 'product/pdtbrand/Pdtbrand_controller/FSvCBNListPage';
$route ['pdtbrandDataTable']         = 'product/pdtbrand/Pdtbrand_controller/FSvCBNDataList';
$route ['pdtbrandPageAdd']           = 'product/pdtbrand/Pdtbrand_controller/FSvCBNAddPage';
$route ['pdtbrandPageEdit']          = 'product/pdtbrand/Pdtbrand_controller/FSvCBNEditPage';
$route ['pdtbrandEventAdd']          = 'product/pdtbrand/Pdtbrand_controller/FSoCBNAddEvent';
$route ['pdtbrandEventEdit']         = 'product/pdtbrand/Pdtbrand_controller/FSoCBNEditEvent';
$route ['pdtbrandEventDelete']       = 'product/pdtbrand/Pdtbrand_controller/FSoCBNDeleteEvent';

//Product Model (รุ่น)
$route ['pdtmodel/(:any)/(:any)']    = 'product/pdtmodel/Pdtmodel_controller/index/$1/$2';
$route ['pdtmodelList']              = 'product/pdtmodel/Pdtmodel_controller/FSvCPMOListPage';
$route ['pdtmodelDataTable']         = 'product/pdtmodel/Pdtmodel_controller/FSvCPMODataList';
$route ['pdtmodelPageAdd']           = 'product/pdtmodel/Pdtmodel_controller/FSvCPMOAddPage';
$route ['pdtmodelPageEdit']          = 'product/pdtmodel/Pdtmodel_controller/FSvCPMOEditPage';
$route ['pdtmodelEventAdd']          = 'product/pdtmodel/Pdtmodel_controller/FSoCPMOAddEvent';
$route ['pdtmodelEventEdit']         = 'product/pdtmodel/Pdtmodel_controller/FSoCPMOEditEvent';
$route ['pdtmodelEventDelete']       = 'product/pdtmodel/Pdtmodel_controller/FSoCPMODeleteEvent';

//Product Color (สี)
$route ['pdtcolor/(:any)/(:any)']    = 'product/pdtcolor/Pdtcolor_controller/index/$1/$2';
$route ['pdtcolorList']              = 'product/pdtcolor/Pdtcolor_controller/FSvCCLRListPage';
$route ['pdtcolorDataTable']         = 'product/pdtcolor/Pdtcolor_controller/FSvCCLRDataList';
$route ['pdtcolorPageAdd']           = 'product/pdtcolor/Pdtcolor_controller/FSvCCLRAddPage';
$route ['pdtcolorPageEdit']          = 'product/pdtcolor/Pdtcolor_controller/FSvCCLREditPage';
$route ['pdtcolorEventAdd']          = 'product/pdtcolor/Pdtcolor_controller/FSoCCLRAddEvent';
$route ['pdtcolorEventEdit']         = 'product/pdtcolor/Pdtcolor_controller/FSoCCLREditEvent';
$route ['pdtcolorEventDelete']       = 'product/pdtcolor/Pdtcolor_controller/FSoCCLRDeleteEvent';

//Product Size (ขนาด)
$route ['pdtsize/(:any)/(:any)']    = 'product/pdtsize/Pdtsize_controller/index/$1/$2';
$route ['pdtsizeList']              = 'product/pdtsize/Pdtsize_controller/FSvCPSZListPage';
$route ['pdtsizeDataTable']         = 'product/pdtsize/Pdtsize_controller/FSvCPSZDataList';
$route ['pdtsizePageAdd']           = 'product/pdtsize/Pdtsize_controller/FSvCPSZAddPage';
$route ['pdtsizePageEdit']          = 'product/pdtsize/Pdtsize_controller/FSvCPSZEditPage';
$route ['pdtsizeEventAdd']          = 'product/pdtsize/Pdtsize_controller/FSoCPSZAddEvent';
$route ['pdtsizeEventEdit']         = 'product/pdtsize/Pdtsize_controller/FSoCPSZEditEvent';
$route ['pdtsizeEventDelete']       = 'product/pdtsize/Pdtsize_controller/FSoCPSZDeleteEvent';

//Product No Sale By Event
$route ['pdtnoslebyevn/(:any)/(:any)']    = 'product/pdtnoslebyevn/Pdtnoslebyevn_controller/index/$1/$2';
$route ['pdtnoslebyevnList']              = 'product/pdtnoslebyevn/Pdtnoslebyevn_controller/FSvCEVNListPage';
$route ['pdtnoslebyevnDataTable']         = 'product/pdtnoslebyevn/Pdtnoslebyevn_controller/FSvCEVNDataList';
$route ['pdtnoslebyevnPageAdd']           = 'product/pdtnoslebyevn/Pdtnoslebyevn_controller/FSvCEVNAddPage';
$route ['pdtnoslebyevnPageEdit']          = 'product/pdtnoslebyevn/Pdtnoslebyevn_controller/FSvCEVNEditPage';
$route ['pdtnoslebyevnEventAdd']          = 'product/pdtnoslebyevn/Pdtnoslebyevn_controller/FSoCEVNAddEvent';
$route ['pdtnoslebyevnEventEdit']         = 'product/pdtnoslebyevn/Pdtnoslebyevn_controller/FSoCEVNEditEvent';
$route ['pdtnoslebyevnEventDelete']       = 'product/pdtnoslebyevn/Pdtnoslebyevn_controller/FSoCEVNDeleteEvent';
$route ['pdtnoslebyCheckDuplicateDatetime']       = 'product/pdtnoslebyevn/Pdtnoslebyevn_controller/FSoCEVNCheckDuplicateDateTime'; //09-04-2562 pap
$route ['pdtnosleCheckTimeDuplicate']       = 'product/pdtnoslebyevn/Pdtnoslebyevn_controller/FStCEVNCheckTimeDaplicate';
$route ['pdtnosleCheckDateDuplicate']       = 'product/pdtnoslebyevn/Pdtnoslebyevn_controller/FStCEVNCheckDateDaplicate';
$route ['pdtnosleCheckDateTimeDuplicate']       = 'product/pdtnoslebyevn/Pdtnoslebyevn_controller/FStCEVNCheckDateTimeDaplicate';

//Product Location
$route ['pdtlocation/(:any)/(:any)']    = 'product/pdtlocation/Pdtlocation_controller/index/$1/$2';
$route ['pdtlocationList']              = 'product/pdtlocation/Pdtlocation_controller/FSvCLOCListPage';
$route ['pdtlocationDataTable']         = 'product/pdtlocation/Pdtlocation_controller/FSvCLOCDataList';
$route ['pdtlocationPageAdd']           = 'product/pdtlocation/Pdtlocation_controller/FSvCLOCAddPage';
$route ['pdtlocationPageEdit']          = 'product/pdtlocation/Pdtlocation_controller/FSvCLOCEditPage';
$route ['pdtlocationPageManage']        = 'product/pdtlocation/Pdtlocation_controller/FSvCLOCManagePage';
$route ['pdtlocationEventAdd']          = 'product/pdtlocation/Pdtlocation_controller/FSoCLOCAddEvent';
$route ['pdtlocationEventEdit']         = 'product/pdtlocation/Pdtlocation_controller/FSoCLOCEditEvent';
$route ['pdtlocationEventDelete']       = 'product/pdtlocation/Pdtlocation_controller/FSoCLOCDeleteEvent';
$route ['pdtlocationProductGroup']      = 'product/pdtlocation/Pdtlocation_controller/FSvCLOCGetDataPdtGrp';
$route ['pdtlocationProductType']       = 'product/pdtlocation/Pdtlocation_controller/FSvCLOCGetDataPdtTyp';
$route ['pdtlocationEventManageEdit']   = 'product/pdtlocation/Pdtlocation_controller/FSoCLOCManageEditEvent';
$route ['pdtlocationEventManageAdd']    = 'product/pdtlocation/Pdtlocation_controller/FSoCLOCManageAddEvent';
$route ['pdtlocationLocSeqDataTable']   = 'product/pdtlocation/Pdtlocation_controller/FSvCLOCSeqDataList';
$route ['pdtlocationSeqEventDelete']    = 'product/pdtlocation/Pdtlocation_controller/FSoCLOCSeqDeleteEvent';

// Product Touch Group (กลุ่มสินค้าด่วน)
$route ['pdtTouchGroup/(:any)/(:any)']  = 'product/pdttouchgroup/Pdttouchgroup_controller/index/$1/$2';
$route ['pdtTouchGroupPageMain']        = 'product/pdttouchgroup/Pdttouchgroup_controller/FSvCTCGCallPageMain';
$route ['pdtTouchGroupPageDataTable']   = 'product/pdttouchgroup/Pdttouchgroup_controller/FSvCTCGCallPageDataTable';
$route ['pdtTouchGroupPageAdd']         = 'product/pdttouchgroup/Pdttouchgroup_controller/FSvCTCGCallPageAdd';
$route ['pdtTouchGroupPageEdit']        = 'product/pdttouchgroup/Pdttouchgroup_controller/FSvCTCGCallPageEdit';
$route ['pdtTouchGroupEventAdd']        = 'product/pdttouchgroup/Pdttouchgroup_controller/FSoCTCGEventAdd';
$route ['pdtTouchGroupEventEdit']       = 'product/pdttouchgroup/Pdttouchgroup_controller/FSoCTCGEventEdit';
$route ['pdtTouchGroupEventDelete']     = 'product/pdttouchgroup/Pdttouchgroup_controller/FSoCTCGEventDelete';


// Drug Tab ยา
$route ['pdtDrugPageAdd/(:any)/(:any)'] = 'product/pdtdrug/Pdtdrug_controller/FSvCDrugPageAdd/$1/$2';
$route ['pdtDrugEventAdd']              = 'product/pdtdrug/Pdtdrug_controller/FSaCDrugAddEvent';

//กำหนดเงื่อนไขการควบคุมสต๊อก
$route ['pdtEventPageStockConditionsList']  = 'product/product/Product_controller/FSvCPDTCallPageStockConditions';
$route ['pdtEventPageStockConditionsEdit']  = 'product/product/Product_controller/FSvCPDTCStockConditionsGetDataById';
$route ['pdtEventAddStockConditions']       = 'product/product/Product_controller/FSaCPDTStockConditionsEventAdd';
$route ['pdtEventEditStockConditions']      = 'product/product/Product_controller/FSaCPDTStockConditionsEventEdit';
$route ['pdtEventDeleteStockConditions']    = 'product/product/Product_controller/FSaCPDTStockConditionsDeleteEvent';

// Import product
$route ['productPageImportDataTable']           = 'product/product/Impproduct_controller/FSaCPDTImportDataTable';
$route ['productEventImportDelete']             = 'product/product/Impproduct_controller/FSaCPDTImportDelete';
$route ['productEventImportMove2Master']        = 'product/product/Impproduct_controller/FSaCPDTImportMove2Master';
$route ['productGetDataImport']                 = 'product/product/Impproduct_controller/FSaCPDTGetDataImport';
$route ['productGetItemAllImport']              = 'product/product/Impproduct_controller/FSaCPDTImportGetItemAll';
