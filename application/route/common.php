<?php
defined ('BASEPATH') or exit ( 'No direct script access allowed' );

// Defaule Controller
$route ['default_controller']           = 'common/Home_controller';

// Browse Modal
$route ['BrowseData']                   = 'common/Browser_controller/index';

// Browse Modal PDT
// $route ['BrowseDataPDT']                = 'common/Browserpdtcallview_controller/index';
//common/cBrowserPDT/index route browse สินค้า ของเก่า
// $route ['BrowseDataPDTTable']           = 'common/cBrowserPDT/FSxGetProductfotPDT';
// $route ['BrowseDataPDTBarcode']         = 'common/cBrowserPDT/FSxGetBarcodeforPDT';

// Browse Modal สินค้าแบบใหม่ เรียก view ของพี่รันต์ (10 กันยายน 2562)
$route ['BrowseDataPDT']                        = 'common/Browserpdtcallview_controller/index';
$route ['BrowseDataPDTTableCallView']           = 'common/Browserpdtcallview_controller/FSxGetProductfotPDT';
$route['CallModalAddPDTConfig']                 = "common/Browserpdtcallview_controller/FSvCallViewModalPdtConfig";

// language
$route ['ChangeLang/(:any)/(:num)']     = 'common/Language_controller/index/$1/$2';
$route ['ChangeLangEdit']               = 'common/Language_controller/FSxChangeLangEdit';
$route ['ChangeBtnSaveAction']          = 'common/Language_controller/FSxChangeBtnSaveAction';

// GenCode
$route ['generateCode']                 = 'common/Common_controller/FCNtCCMMGenCode';
$route ['generateCodeV5']               = 'common/Common_controller/FCNtCCMMGenCodeV5';
$route ['CheckInputGenCode']            = 'common/Common_controller/FCNtCCMMCheckInputGenCode';
$route ['GetPanalLangSystemHTML']       = 'common/Common_controller/FCNtCCMMGetLangSystem';
$route ['GetPanalLangListHTML']         = 'common/Common_controller/FCNtCCMMChangeLangList';

// Image Temp.
$route ['ImageCallMaster']              = 'common/Tempimg_controller/FSaCallMasterImage';
$route ['ImageCallTemp']                = 'common/Tempimg_controller/FSaCallTempImage';
$route ['ImageCallTempNEW']             = 'common/Tempimg_controller/FSaCallTempImageNEW';
$route ['ImageDeleteFileNEW']           = 'common/Tempimg_controller/FSoImageDeleteNEW';
$route ['ImageUplodeNEW']               = 'common/Tempimg_controller/FSaImageUplodeNEW';
$route ['ImageUplode']                  = 'common/Tempimg_controller/FSaImageUplode';
$route ['ImageConvertCrop']             = 'common/Tempimg_controller/FSoConvertSizeCrop';
$route ['ImageDeleteFile']              = 'common/Tempimg_controller/FSoImageDelete';

// Rabbit MQ
$route ['RabbitMQDeleteQname']          = 'common/rabbitmq/Rabbitmq_controller/FStDeleteQname';
$route ['RabbitMQUpdateStaDeleteQname'] = 'common/rabbitmq/Rabbitmq_controller/FStUpdateStaDeleteQname';

// VatRate
$route ['getVateActiveByVatCode']       = 'common/Common_controller/FStGetVateActiveByVatCode';

// Route Browse Multiple Select Data (Last Update: 12/12/2019 Wasin(Yoshi))
$route ['BrowseMultiple']               = 'common/browsemultiselect/Browsemultiselect_controller/index';

//เลือกภาษาในการเพิ่มข้อมูล
$route ['SwitchLang']                   = 'common/Language_controller/FSxSwitchLang';
$route ['InsertSwitchLang']             = 'common/Language_controller/FSxEventInsertSwitchLang';

//Addfavorit
// Create Witsarut 10/01/2020
$route['Addfavorite']                   = "common/Addfavorite_controller/FSxAddfavorite";
$route['ChkStafavorite']                = "common/Addfavorite_controller/FSxChkStaDisable";
$route['CallModalOptionFavorite']       = "common/Addfavorite_controller/FSvCallViewModalFavorite";
$route['GetDatafavname']                = "common/Addfavorite_controller/FSxGetDatafavName";

//Notification
$route['GetDataNotification']           = "common/Home_controller/FSxGetDataNoti";
$route['GetDataNotificationRead']       = "common/Home_controller/FSxGetDataNotiRead";
$route['InsDataNotification']           = "common/Home_controller/FSxAddDataNoti";

//Import
$route['ImportFileExcel']               = "common/Home_controller/FSxImpImportFileExcel";

$route['GetMassageQueue']               = "common/Common_controller/FCNtCCMMGetMassageProgress";
$route['GetMassageQueueDailyCurrent']   = "common/Common_controller/FCNtCCMMGetMassageProgressDailyCurrent";
