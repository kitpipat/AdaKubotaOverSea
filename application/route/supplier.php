<?php

//Supplier ผู้จำหน่าย
$route ['supplier/(:any)/(:any)']       = 'supplier/supplier/Supplier_controller/index/$1/$2';
$route ['supplierList']                 = 'supplier/supplier/Supplier_controller/FSvCSPLListPage';
$route ['supplierDataTable']            = 'supplier/supplier/Supplier_controller/FSvCSPLDataList';
$route ['supplierPageAdd']              = 'supplier/supplier/Supplier_controller/FSvCSPLAddPage';
$route ['supplierPageEdit']             = 'supplier/supplier/Supplier_controller/FSvCSPLEditPage';
$route ['supplierEventAdd']             = 'supplier/supplier/Supplier_controller/FSoCSPLAddEvent';
$route ['supplierEventEdit']            = 'supplier/supplier/Supplier_controller/FSoCSPLEditEvent';
$route ['supplierEventDelete']          = 'supplier/supplier/Supplier_controller/FSoCSPLDeleteEvent';
$route ['supplierPageAddAddress']       = 'supplier/supplier/Supplier_controller/FSvCSPLAddAddressPage';
$route ['supplierPageAddContact']       = 'supplier/supplier/Supplier_controller/FSvCSPLAddContactPage';
$route ['supplierEventAddAddress']      = 'supplier/supplier/Supplier_controller/FSoCSPLAddressAddEvent';
$route ['supplierEventAddContact']      = 'supplier/supplier/Supplier_controller/FSoCSPLContactAddEvent';
$route ['supplierAddressDataTable']     = 'supplier/supplier/Supplier_controller/FSoCSPLAddressDataTable';
$route ['supplierContactDataTable']     = 'supplier/supplier/Supplier_controller/FSoCSPLContactDataTable';
$route ['supplierAddressPageEdit']      = 'supplier/supplier/Supplier_controller/FSvCSPLEAddressEditPage';
$route ['supplierContactPageEdit']      = 'supplier/supplier/Supplier_controller/FSvCSPLEContactEditPage';
$route ['supplierEventEditAddress']     = 'supplier/supplier/Supplier_controller/FSoCSPLAddressEditEvent';
$route ['supplierEventEditContact']     = 'supplier/supplier/Supplier_controller/FSoCSPLContactEditEvent';
$route ['supplierAddressEventDelete']   = 'supplier/supplier/Supplier_controller/FSoCSPLAddressDeleteEvent';
$route ['supplierContactEventDelete']   = 'supplier/supplier/Supplier_controller/FSoCSPLContactDeleteEvent';
//Supplier Level (ระดับ ผู้จำหน่าย)
$route ['supplierlev/(:any)/(:any)']    = 'supplier/supplierlev/Supplierlev_controller/index/$1/$2';
$route ['supplierlevList']              = 'supplier/supplierlev/Supplierlev_controller/FSvCSLVListPage';
$route ['supplierlevDataTable']         = 'supplier/supplierlev/Supplierlev_controller/FSvCSLVDataList';
$route ['supplierlevPageAdd']           = 'supplier/supplierlev/Supplierlev_controller/FSvCSLVAddPage';
$route ['supplierlevPageEdit']          = 'supplier/supplierlev/Supplierlev_controller/FSvCSLVEditPage';
$route ['supplierlevEventAdd']          = 'supplier/supplierlev/Supplierlev_controller/FSoCSLVAddEvent';
$route ['supplierlevEventEdit']         = 'supplier/supplierlev/Supplierlev_controller/FSoCSLVEditEvent';
$route ['supplierlevEventDelete']       = 'supplier/supplierlev/Supplierlev_controller/FSoCSLVDeleteEvent';

//SupplierType (ประเภทจำหน่าย)
$route ['suppliertype/(:any)/(:any)']   = 'supplier/suppliertype/Suppliertype_controller/index/$1/$2';
$route ['suppliertypeList']             = 'supplier/suppliertype/Suppliertype_controller/FSvCSTYListPage';
$route ['suppliertypeDataTable']        = 'supplier/suppliertype/Suppliertype_controller/FSvCSTYDataList';
$route ['suppliertypePageAdd']          = 'supplier/suppliertype/Suppliertype_controller/FSvCSTYAddPage';
$route ['suppliertypePageEdit']         = 'supplier/suppliertype/Suppliertype_controller/FSvCSTYEditPage';
$route ['suppliertypeEventAdd']         = 'supplier/suppliertype/Suppliertype_controller/FSoCSTYAddEvent';
$route ['suppliertypeEventEdit']        = 'supplier/suppliertype/Suppliertype_controller/FSoCSTYEditEvent';
$route ['suppliertypeEventDelete']      = 'supplier/suppliertype/Suppliertype_controller/FSoCSTYDeleteEvent';

//Group Suppliers (กลุ่ม ผู้จำหน่าย)
$route ['groupsupplier/(:any)/(:any)']  = 'supplier/groupsupplier/Groupsupplier_controller/index/$1/$2';
$route ['groupsupplierList']            = 'supplier/groupsupplier/Groupsupplier_controller/FSvCSGPListPage';
$route ['groupsupplierDataTable']       = 'supplier/groupsupplier/Groupsupplier_controller/FSvCSGPDataList';
$route ['groupsupplierPageAdd']         = 'supplier/groupsupplier/Groupsupplier_controller/FSvCSGPAddPage';
$route ['groupsupplierPageEdit']        = 'supplier/groupsupplier/Groupsupplier_controller/FSvCSGPEditPage';
$route ['groupsupplierEventAdd']        = 'supplier/groupsupplier/Groupsupplier_controller/FSoCSGPAddEvent';
$route ['groupsupplierEventEdit']       = 'supplier/groupsupplier/Groupsupplier_controller/FSoCSGPEditEvent';
$route ['groupsupplierEventDelete']     = 'supplier/groupsupplier/Groupsupplier_controller/FSoCSGPDeleteEvent';

//ShipVia (ขนส่งโดย)
$route ['shipvia/(:any)/(:any)']      = 'shipvia/shipvia/Shipvia_controller/index/$1/$2';
$route ['shipviaList']                = 'shipvia/shipvia/Shipvia_controller/FSvCVIAListPage';
$route ['shipviaDataTable']           = 'shipvia/shipvia/Shipvia_controller/FSvCVIADataList';
$route ['shipviaPageAdd']             = 'shipvia/shipvia/Shipvia_controller/FSvCVIAAddPage';
$route ['shipviaPageEdit']            = 'shipvia/shipvia/Shipvia_controller/FSvCVIAEditPage';
$route ['shipviaEventAdd']            = 'shipvia/shipvia/Shipvia_controller/FSoCVIAAddEvent';
$route ['shipviaEventEdit']           = 'shipvia/shipvia/Shipvia_controller/FSoCVIAEditEvent';
$route ['shipviaEventDelete']         = 'shipvia/shipvia/Shipvia_controller/FSoCVIADeleteEvent';

