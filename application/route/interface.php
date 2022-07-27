<?php defined('BASEPATH') or exit('No direct script access allowed');

$route['interfaceimport/(:any)/(:any)']  = 'interface/interfaceimport/Interfaceimport_controller/index/$1/$2';
$route['interfaceimportAction']          = 'interface/interfaceimport/Interfaceimport_controller/FSxCINMCallRabitMQ';


//Interfacehistory ประวัตินำเข้า - นำออกด
//create by nonpawich 5/3/2020
$route['interfacehistory/(:any)/(:any)']  = 'interface/interfacehistory/Interfacehistory_controller/index/$1/$2';
$route['interfacehistorylist']            = 'interface/interfacehistory/Interfacehistory_controller/FSxCIFHList';
$route['interfaceihistorydatatable']      = 'interface/interfacehistory/Interfacehistory_controller/FSaCIFHGetDataTable';


//InterfaceExport ส่งออก
//Create by Napat(Jame) 05/03/2020
$route['interfaceexport/(:any)/(:any)']  = 'interface/interfaceexport/Interfaceexport_controller/index/$1/$2';
$route['interfaceexportAction']          = 'interface/interfaceexport/Interfaceexport_controller/FSxCIFXCallRabitMQ';

//ตั้งค่า 14/05/2020 Saharat(Golf)
$route['connectionsetting/(:any)/(:any)']       = 'interface/connectionsetting/Connectionsetting_controller/index/$1/$2';
$route['connectionsettingCallPageList']         = 'interface/connectionsetting/Connectionsetting_controller/FSxCCCSPageWahouse';
$route['connectionsettingDataTable']            = 'interface/connectionsetting/Connectionsetting_controller/FSvCCCSDataList';
$route['connectionsettingCallPageAddWahouse']   = 'interface/connectionsetting/Connectionsetting_controller/FSxCCCSPageAddWahouse';
$route['connectionsettingEventAdd']             = 'interface/connectionsetting/Connectionsetting_controller/FSxCCCSWahouseEventAdd';
$route['connectionsettingCallPageEdit']         = 'interface/connectionsetting/Connectionsetting_controller/FSxCCCSWahousePageEdit';
$route['connectionsettingEventEdit']            = 'interface/connectionsetting/Connectionsetting_controller/FSxCCCSWahouseEventEdit';
$route['connectionsettingEventDelete']          = 'interface/connectionsetting/Connectionsetting_controller/FSaCCCSDeleteEvent';
$route['connectionsettingEventDeleteMultiple']  = 'interface/connectionsetting/Connectionsetting_controller/FSaCCCSDelMultipleEvent';


//ตั้งค่า Tab ทั่วไป 15/05/2020 Witsarut(Bell)
$route['connectSetGenaral']                = 'interface/connectionsetting/Consettinggenaral_controller/FSxSETMainPage';
$route['connsetGenDataTable']              = 'interface/connectionsetting/Consettinggenaral_controller/FSvSETDataList';
$route['consetgenEventedit']               = 'interface/connectionsetting/Consettinggenaral_controller/FSxSETEventAdd';
$route['ConSettingGanPageEdit']            = 'interface/connectionsetting/Consettinggenaral_controller/FSvSETPageEdit';
$route['ConSettingGanPageEditApiAuth']     = 'interface/connectionsetting/Consettinggenaral_controller/FSvSETPageEditApiAuth';
$route['ConSettingGanPageAdd']             = 'interface/connectionsetting/Consettinggenaral_controller/FSvSETPageAdd';
$route['ConnSetGenaralEventAuthorEdit']    = 'interface/connectionsetting/Consettinggenaral_controller/FSvSETEventAuthorEdit';
$route['ConnSetGenaralEventAuthorAdd']     = 'interface/connectionsetting/Consettinggenaral_controller/FSvSETEventAuthorAdd';
$route['ConSettingGenaralEventDelete']     = 'interface/connectionsetting/Consettinggenaral_controller/FSaSETDeleteEvent';
