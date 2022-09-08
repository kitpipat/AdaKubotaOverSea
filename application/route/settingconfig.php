<?php

// ตั้งค่าระบบ
$route ['SettingConfig/(:any)/(:any)']      = 'settingconfig/settingconfig/Settingconfig_controller/index/$1/$2';
$route ['SettingConfigGetList']             = 'settingconfig/settingconfig/Settingconfig_controller/FSvSETGetPageList';

//Content ในตั้งค่าระบบ
$route ['SettingConfigLoadViewSearch']      = 'settingconfig/settingconfig/Settingconfig_controller/FSvSETGetPageListSearch';
$route ['SettingConfigLoadTable']           = 'settingconfig/settingconfig/Settingconfig_controller/FSvSETSettingGetTable';
$route ['SettingConfigSave']                = 'settingconfig/settingconfig/Settingconfig_controller/FSxSETSettingEventSave';
$route ['SettingConfigUseDefaultValue']     = 'settingconfig/settingconfig/Settingconfig_controller/FSxSETSettingUseDefaultValue';

//Content รหัสอัตโนมัติ
$route ['SettingAutonumberLoadViewSearch']  = 'settingconfig/settingconfig/Settingconfig_controller/FSvSETAutonumberGetPageListSearch';
$route ['SettingAutonumberLoadTable']       = 'settingconfig/settingconfig/Settingconfig_controller/FSvSETAutonumberSettingGetTable';
$route ['SettingAutonumberLoadPageEdit']    = 'settingconfig/settingconfig/Settingconfig_controller/FSvSETAutonumberPageEdit';
$route ['SettingAutonumberSave']            = 'settingconfig/settingconfig/Settingconfig_controller/FSvSETAutonumberEventSave';


//กำหนดเงื่อนไขส่วนลด
$route['discountpolicy/(:any)/(:any)']       = 'settingconfig/discountpolicy/Discountpolicy_controller/index/$1/$2';
$route['discountpolicyList']                 = 'settingconfig/discountpolicy/Discountpolicy_controller/FSvDPCDisPageList';
$route['discountpolicyLoadTable']            = 'settingconfig/discountpolicy/Discountpolicy_controller/FSvDPCDisGetdataTable';
$route['discountpolicySaveData']             = 'settingconfig/discountpolicy/Discountpolicy_controller/FSvDPCDisSaveData';

//////////////////////////////////////// Menu //////////////////////////////////////////////////////////////////////////////
//ตั้งค่าเมนู
$route['settingmenu/(:any)/(:any)']          = 'settingconfig/settingmenu/Settingmenu_controller/index/$1/$2';
$route['SettingMenuGetPage']                 = 'settingconfig/settingmenu/Settingmenu_controller/FSxCSMUGetPageSettingmenu';

//Module
$route['SettingMenuAddEditModule']               = 'settingconfig/settingmenu/Settingmenu_controller/FSxCSMUAddEditModule';

$route['CallModalModulEdit']                 = 'settingconfig/settingmenu/Settingmenu_controller/FSxCSMUCallModalEditModule';
$route['SettingMenuDelModule']               = 'settingconfig/settingmenu/Settingmenu_controller/FSxCSMUDelModule';

//MenuGrp
$route['SettingMenuAddEditMenuGrp']              = 'settingconfig/settingmenu/Settingmenu_controller/FSxCSMUAddEditMenuGrp';
$route['CallModalMenuGrpEdit']               = 'settingconfig/settingmenu/Settingmenu_controller/FSxCSMUCallModalEditMenuGrp';
$route['SettingMenuDelMenuGrp']               = 'settingconfig/settingmenu/Settingmenu_controller/FSxCSMUDelMenuGrp';


//MenuList
$route['SettingMenuAddEditMenuList']              = 'settingconfig/settingmenu/Settingmenu_controller/FSxCSMUAddEditMenuList';
$route['CallModalMenuListEdit']               = 'settingconfig/settingmenu/Settingmenu_controller/FSxCSMUCallModalEditMenuList';
$route['SettingMenuDelMenuList']              = 'settingconfig/settingmenu/Settingmenu_controller/FSxCSMUDelMenuList';

//StaUse
$route['UpdateStaUse']                        = 'settingconfig/settingmenu/Settingmenu_controller/FSxCSMUUpdateStaUse';


$route['CallMaxValueSequence']                = 'settingconfig/settingmenu/Settingmenu_controller/FSxCSMUCallMaxSequence';

//////////////////////////////////////// Report ////////////////////////////////////////////////////////////////////////////

$route['SettingReportGetPage']                = 'settingconfig/settingmenu/Settingreport_controller/FSxCSRTGetPageSettingreport';

$route['CallMaxValueSequenceRpt']             = 'settingconfig/settingmenu/Settingreport_controller/FSxCSRTCallMaxSequence';
$route['GenCodeRpt']                          = 'settingconfig/settingmenu/Settingreport_controller/FSxCSRTGencode';

//Module Rpt
$route['SettingReportAddUpdateModule']       = 'settingconfig/settingmenu/Settingreport_controller/FSxCSRTReportAddUpdateModule';
$route['SettingReportCallEditModuleRpt']     = 'settingconfig/settingmenu/Settingreport_controller/FSxCSRTReportCallMoalEditModulRpt';
$route['SettingReportDelModule']             = 'settingconfig/settingmenu/Settingreport_controller/FSxCSRTDelModuleReport';


//ReportGrp
$route['SettingReportAddEditRptGrp']           = 'settingconfig/settingmenu/Settingreport_controller/FSxCSRTAddEditRptGrp';
$route['CallModalReportGrpEdit']               = 'settingconfig/settingmenu/Settingreport_controller/FSxCSRTCallModalEditRptGrp';
$route['SettingReportDelRptGrp']               = 'settingconfig/settingmenu/Settingreport_controller/FSxCSRTDelReportGrp';

//ReportMenu
$route['SettingReportAddEditRptMenu']           = 'settingconfig/settingmenu/Settingreport_controller/FSxCSRTReportAddUpdateMenu';
$route['CallModalReportMenuEdit']               = 'settingconfig/settingmenu/Settingreport_controller/FSxCSRTCallModalEditRptMenu';
$route['SettingReportDelMenu']                  = 'settingconfig/settingmenu/Settingreport_controller/FSxCSRTDelMenuReport';

// กำหนดเงื่อนไขช่วงการตรวจสอบ
$route ['settingconperiod/(:any)/(:any)']       = 'settingconfig/settingconperiod/Settingconperiod_controller/index/$1/$2';
$route ['settingconperiodList']                 = 'settingconfig/settingconperiod/Settingconperiod_controller/FSvCLIMListPage';
$route ['settingconperiodDataTable']            = 'settingconfig/settingconperiod/Settingconperiod_controller/FSvCLIMDataList';
$route ['settingconperiodPageAdd']              = 'settingconfig/settingconperiod/Settingconperiod_controller/FSvCLIMAddPage';
$route ['settingconperiodDataCheckRolCode']     = 'settingconfig/settingconperiod/Settingconperiod_controller/FSvCLIMChkRole';
$route ['settingconperiodPageEdit']             = 'settingconfig/settingconperiod/Settingconperiod_controller/FSvCLIMEditPage';
$route ['settingconperiodEventDelete']          = 'settingconfig/settingconperiod/Settingconperiod_controller/FSaCLIMDeleteEvent';
$route ['settingconperiodEventDeleteMultiple']  = 'settingconfig/settingconperiod/Settingconperiod_controller/FSaCLIMDeleteMultiEvent';
$route ['settingconperiodEventAdd']             = 'settingconfig/settingconperiod/Settingconperiod_controller/FSaCLIMAddEvent';
$route ['settingconperiodEventEdit']            = 'settingconfig/settingconperiod/Settingconperiod_controller/FSaCLIMEditEvent';

//Export Data Settingconfig
$route ['configExportData']                     = 'settingconfig/settingconfig/Settingconfig_controller/FSxSETSettingConfigExport';
$route ['configInsertData']                     = 'settingconfig/settingconfig/Settingconfig_controller/FSxSETConfigInsertData';

///////////////////////  อัตราแลกเปลี่ยนสกุลเงินรายวัน //////////////////////////////////
$route ['SettingDailyCurrency/(:any)/(:any)']      = 'settingconfig/settingdairycurrency/Settingdairycurrency_controller/index/$1/$2';
$route ['SettingDailyCurrencyGetList']             = 'settingconfig/settingdairycurrency/Settingdairycurrency_controller/FSvSETGetDairyCurrencyPageList';

$route ['SettingDailyCurrencyLoadViewSearch']      = 'settingconfig/settingdairycurrency/Settingdairycurrency_controller/FSvSETGetDairyCurrencyPageListSearch';
$route ['SettingDailyCurrencyLoadTable']           = 'settingconfig/settingdairycurrency/Settingdairycurrency_controller/FSvSETDairyCurrencyGetTable';
$route ['SettingDailyCurrencySave']                = 'settingconfig/settingdairycurrency/Settingdairycurrency_controller/FSxSETDailyCurrencyEventSave';
$route ['docGetCurrentDairy']                      = 'settingconfig/settingdairycurrency/Settingdairycurrency_controller/FSxSETDailyCurrencyRefresh';

//// ตั้งค่า Url Format /////////////
    $route ['settingUrlFormat/(:any)/(:any)']           = 'settingconfig/settingurlformat/Settingurlformat_controller/index/$1/$2';
    $route ['urlList']                              = 'settingconfig/settingurlformat/Settingurlformat_controller/FSvCURLListPage';
    $route ['urlDataTable']                         = 'settingconfig/settingurlformat/Settingurlformat_controller/FSvCURLDataList';
    $route ['urlPageAdd']                           = 'settingconfig/settingurlformat/Settingurlformat_controller/FSvCURLAddPage';
    $route ['urlPageEdit']                          = 'settingconfig/settingurlformat/Settingurlformat_controller/FSvCURLEditPage';
    $route ['urlEventAdd']                          = 'settingconfig/settingurlformat/Settingurlformat_controller/FSoCURLAddEvent';
    $route ['urlEventEdit']                         = 'settingconfig/settingurlformat/Settingurlformat_controller/FSoCURLEditEvent';
    $route ['urlEventDelete']                       = 'settingconfig/settingurlformat/Settingurlformat_controller/FSoCURLDeleteEvent';
    $route ['urlCheckStaUse']                       = 'settingconfig/settingurlformat/Settingurlformat_controller/FSvCURLCheckStaUse';