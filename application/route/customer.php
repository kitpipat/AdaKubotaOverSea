<?php
// Customer
$route ['customer/(:any)/(:any)']           = 'customer/customer/Customer_controller/index/$1/$2';
$route ['customerList']                     = 'customer/customer/Customer_controller/FSvCSTListPage';
$route ['customerDataTable']                = 'customer/customer/Customer_controller/FSvCSTDataList';
$route ['customerContactDataTable']         = 'customer/customer/Customer_controller/FSvCSTContactDataList';
$route ['customerPageAdd']                  = 'customer/customer/Customer_controller/FSvCSTAddPage';
$route ['customerEventAdd']                 = 'customer/customer/Customer_controller/FSaCSTAddEvent';
$route ['customerPageEdit']                 = 'customer/customer/Customer_controller/FSvCSTEditPage';
$route ['customerEventEdit']                = 'customer/customer/Customer_controller/FSaCSTEditEvent';
// $route ['customerEventAddUpdateAddress']    = 'customer/customer/Customer_controller/FSaCSTAddUpdateAddressEvent';
$route ['customerEventAddUpdateContact']    = 'customer/customer/Customer_controller/FSaCSTAddUpdateContactEvent';
$route ['customerEventDeleteContact']       = 'customer/customer/Customer_controller/FSaCSTDeleteContactEvent';
$route ['customerEventAddUpdateCardInfo']   = 'customer/customer/Customer_controller/FSaCSTAddUpdateCardInfoEvent';
$route ['customerEventAddUpdateCredit']     = 'customer/customer/Customer_controller/FSaCSTAddUpdateCreditEvent';
$route ['customerEventDataTableRfid']       = 'customer/customer/Customer_controller/FSaCSTDataTableRfidEvent';
$route ['customerEventAddUpdateRfid']       = 'customer/customer/Customer_controller/FSaCSTAddRfidEvent';
$route ['customerEventUpdateRfid']          = 'customer/customer/Customer_controller/FSaCSTUpdateRfidEvent';
$route ['customerEventDeleteRfid']          = 'customer/customer/Customer_controller/FSaCSTDeleteRfidEvent';
$route ['customerDeleteMulti']              = 'customer/customer/Customer_controller/FSoCSTDeleteMulti';
$route ['customerDelete']                   = 'customer/customer/Customer_controller/FSoCSTDelete';
$route ['customerUniqueValidate/(:any)']    = 'customer/customer/Customer_controller/FStCSTUniqueValidate/$1';
// Customer Address New Design
$route ['customerAddressData']              = 'customer/customer/Customeraddress_controller/FSvCCSTAddressData';
$route ['customerAddressDataTable']         = 'customer/customer/Customeraddress_controller/FSvCCSTAddressDataTable';
$route ['customerAddressPageAdd']           = 'customer/customer/Customeraddress_controller/FSvCCSTAddressCallPageAdd';
$route ['customerAddressPageEdit']          = 'customer/customer/Customeraddress_controller/FSvCCSTAddressCallPageEdit';
$route ['customerAddressAddEvent']          = 'customer/customer/Customeraddress_controller/FSoCCSTAddressAddEvent';
$route ['customerAddressEditEvent']         = 'customer/customer/Customeraddress_controller/FSoCCSTAddressEditEvent';
$route ['customerAddressDeleteEvent']       = 'customer/customer/Customeraddress_controller/FSoCCSTAddressDeleteEvent';

// Customer Group
$route ['customerGroup/(:any)/(:any)']          = 'customer/customergroup/Customergroup_controller/index/$1/$2';
$route ['customerGroupList']                    = 'customer/customergroup/Customergroup_controller/FSvCstGrpListPage';
$route ['customerGroupDataTable']               = 'customer/customergroup/Customergroup_controller/FSvCstGrpDataList';
$route ['customerGroupPageAdd']                 = 'customer/customergroup/Customergroup_controller/FSvCstGrpAddPage';
$route ['customerGroupEventAdd']                = 'customer/customergroup/Customergroup_controller/FSaCstGrpAddEvent';
$route ['customerGroupPageEdit']                = 'customer/customergroup/Customergroup_controller/FSvCstGrpEditPage';
$route ['customerGroupEventEdit']               = 'customer/customergroup/Customergroup_controller/FSaCstGrpEditEvent';
$route ['customerGroupDeleteMulti']             = 'customer/customergroup/Customergroup_controller/FSoCstGrpDeleteMulti';
$route ['customerGroupDelete']                  = 'customer/customergroup/Customergroup_controller/FSoCstGrpDelete';
$route ['customerGroupUniqueValidate/(:any)']   = 'customer/customergroup/Customergroup_controller/FStCstGrpUniqueValidate/$1';

// Customer Type
$route ['customerType/(:any)/(:any)']           = 'customer/customertype/Customertype_controller/index/$1/$2';
$route ['customerTypeList']                     = 'customer/customertype/Customertype_controller/FSvCstTypeListPage';
$route ['customerTypeDataTable']                = 'customer/customertype/Customertype_controller/FSvCstTypeDataList';
$route ['customerTypePageAdd']                  = 'customer/customertype/Customertype_controller/FSvCstTypeAddPage';
$route ['customerTypeEventAdd']                 = 'customer/customertype/Customertype_controller/FSaCstTypeAddEvent';
$route ['customerTypePageEdit']                 = 'customer/customertype/Customertype_controller/FSvCstTypeEditPage';
$route ['customerTypeEventEdit']                = 'customer/customertype/Customertype_controller/FSaCstTypeEditEvent';
$route ['customerTypeDeleteMulti']              = 'customer/customertype/Customertype_controller/FSoCstTypeDeleteMulti';
$route ['customerTypeDelete']                   = 'customer/customertype/Customertype_controller/FSoCstTypeDelete';
$route ['customerTypeUniqueValidate/(:any)']    = 'customer/customertype/Customertype_controller/FStCstTypeUniqueValidate/$1';

// Customer Level
$route ['customerLevel/(:any)/(:any)']          = 'customer/customerlevel/Customerlevel_controller/index/$1/$2';
$route ['customerLevelList']                    = 'customer/customerlevel/Customerlevel_controller/FSvCstLevListPage';
$route ['customerLevelDataTable']               = 'customer/customerlevel/Customerlevel_controller/FSvCstLevDataList';
$route ['customerLevelPageAdd']                 = 'customer/customerlevel/Customerlevel_controller/FSvCstLevAddPage';
$route ['customerLevelEventAdd']                = 'customer/customerlevel/Customerlevel_controller/FSaCstLevAddEvent';
$route ['customerLevelPageEdit']                = 'customer/customerlevel/Customerlevel_controller/FSvCstLevEditPage';
$route ['customerLevelEventEdit']               = 'customer/customerlevel/Customerlevel_controller/FSaCstLevEditEvent';
$route ['customerLevelDeleteMulti']             = 'customer/customerlevel/Customerlevel_controller/FSoCstLevDeleteMulti';
$route ['customerLevelDelete']                  = 'customer/customerlevel/Customerlevel_controller/FSoCstLevDelete';
$route ['customerLevelUniqueValidate/(:any)']   = 'customer/customerlevel/Customerlevel_controller/FStCstLevUniqueValidate/$1';

// Customer Occupation
$route ['customerOcp/(:any)/(:any)']            = 'customer/customerocp/Customerocp_controller/index/$1/$2';
$route ['customerOcpList']                      = 'customer/customerocp/Customerocp_controller/FSvCstOcpListPage';
$route ['customerOcpDataTable']                 = 'customer/customerocp/Customerocp_controller/FSvCstOcpDataTable';
$route ['customerOcpPageAdd']                   = 'customer/customerocp/Customerocp_controller/FSvCstOcpAddPage';
$route ['customerOcpPageEdit']                  = 'customer/customerocp/Customerocp_controller/FSvCstOcpEditPage';
$route ['customerOcpEventAdd']                  = 'customer/customerocp/Customerocp_controller/FSaCstOcpAddEvent';
$route ['customerOcpEventEdit']                 = 'customer/customerocp/Customerocp_controller/FSaCstOcpEditEvent';
$route ['customerOcpEventDelete']               = 'customer/customerocp/Customerocp_controller/FSaCstOcpDeleteEvent';
$route ['customerOcpUniqueValidate/(:any)']     = 'customer/customerocp/Customerocp_controller/FStCstOcpUniqueValidate/$1';

//Register Face
$route ['customerRegisFace']                    = 'customer/customerregisface/Customerregisface_controller/FSxCstRGFCallAPIMain';
$route ['customerRegisFaceGetImage']            = 'customer/customerregisface/Customerregisface_controller/FSaCstRGFGetImage';
$route ['customerRegisFaceDeleteImage']         = 'customer/customerregisface/Customerregisface_controller/FSaCstRGFDeleteImage';


// Add Tab Debit Card
// Create By Witsarut 26/10/2016
$route ['DebitCardDataTable']                   = 'customer/customerdebitcard/Customerdebitcard_controller/FSvCCstDebitDataList';
$route ['DebitCardPageAdd']                     = 'customer/customerdebitcard/Customerdebitcard_controller/FSvCCstDebitPageAdd';
$route ['DebitCardEventAdd']                    = 'customer/customerdebitcard/Customerdebitcard_controller/FSaCCstDebitAddEvent';
$route ['DebitCardPageEdit']                    = 'customer/customerdebitcard/Customerdebitcard_controller/FSvCCstDebitPageEdit';
$route ['DebitCardEventEdit']                   = 'customer/customerdebitcard/Customerdebitcard_controller/FSaCCstDebitEditEvent';
$route ['DebitCardEventDelete']                 = 'customer/customerdebitcard/Customerdebitcard_controller/FSaCCstDebitDeleteEvent';
