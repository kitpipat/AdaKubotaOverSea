<?php

//Card
$route['card/(:any)/(:any)']       = 'payment/card/Card_controller/index/$1/$2';
$route['cardList']                 = 'payment/card/Card_controller/FSvCCRDListPage';
$route['cardDataTable']            = 'payment/card/Card_controller/FSvCCRDDataList';
$route['cardPageAdd']              = 'payment/card/Card_controller/FSvCCRDAddPage';
$route['cardPageEdit']             = 'payment/card/Card_controller/FSvCCRDEditPage';
$route['cardEventAdd']             = 'payment/card/Card_controller/FSoCCRDAddEvent';
$route['cardEventEdit']            = 'payment/card/Card_controller/FSoCCRDEditEvent';
$route['cardEventDelete']          = 'payment/card/Card_controller/FSoCCRDDeleteEvent';
$route['checkStatusActive']        = "payment/card/Card_controller/FSvCCRDChkStaAct";

//CardType (ประเภทบัตร)
$route['cardtype/(:any)/(:any)']   = 'payment/cardtype/Cardtype_controller/index/$1/$2';
$route['cardtypeList']             = 'payment/cardtype/Cardtype_controller/FSvCCTYListPage';
$route['cardtypeDataTable']        = 'payment/cardtype/Cardtype_controller/FSvCCTYDataList';
$route['cardtypePageAdd']          = 'payment/cardtype/Cardtype_controller/FSvCCTYAddPage';
$route['cardtypePageEdit']         = 'payment/cardtype/Cardtype_controller/FSvCCTYEditPage';
$route['cardtypeEventAdd']         = 'payment/cardtype/Cardtype_controller/FSoCCTYAddEvent';
$route['cardtypeEventEdit']        = 'payment/cardtype/Cardtype_controller/FSoCCTYEditEvent';
$route['cardtypeEventDelete']      = 'payment/cardtype/Cardtype_controller/FSoCCTYDeleteEvent';

//Recive (ประเภทการชำระเงิน)
$route['recive/(:any)/(:any)']      = 'payment/recive/Recive_controller/index/$1/$2';
$route['reciveList']                = 'payment/recive/Recive_controller/FSvRCVListPage';
$route['reciveDataTable']           = 'payment/recive/Recive_controller/FSvRCVDataList';
$route['recivePageAdd']             = 'payment/recive/Recive_controller/FSvRCVAddPage';
$route['reciveEventAdd']            = 'payment/recive/Recive_controller/FSaRCVAddEvent';
$route['recivePageEdit']            = 'payment/recive/Recive_controller/FSvRCVEditPage';
$route['reciveEventEdit']           = 'payment/recive/Recive_controller/FSaRCVEditEvent';
$route['reciveEventDelete']         = 'payment/recive/Recive_controller/FSaRCVDeleteEvent';
$route['recivespcGetRcvConfig']     = 'payment/recive/Recive_controller/FSaCRCVGetRcvConfig';

//BankNote (ธนบัตร)
$route['banknote/(:any)/(:any)']   = 'payment/banknote/Banknote_controller/index/$1/$2';
$route['banknoteList']             = 'payment/banknote/Banknote_controller/FSvCBNTListPage';
$route['banknoteDataTable']        = 'payment/banknote/Banknote_controller/FSvCBNTDataList';
$route['banknotePageAdd']          = 'payment/banknote/Banknote_controller/FSvCBNTAddPage';
$route['banknotePageEdit']         = 'payment/banknote/Banknote_controller/FSvCBNTEditPage';
$route['banknoteEventAdd']         = 'payment/banknote/Banknote_controller/FSoCBNTAddEvent';
$route['banknoteEventEdit']        = 'payment/banknote/Banknote_controller/FSoCBNTEditEvent';
$route['banknoteEventDelete']      = 'payment/banknote/Banknote_controller/FSoCBNTDeleteEvent';
$route['banknoteUniqueValidate'] = 'payment/banknote/Banknote_controller/FStCBanknoteUniqueValidate';

//Rate สกุลเงิน
$route['rate/(:any)/(:any)']       = 'payment/rate/Rate_controller/index/$1/$2';
$route['rateFormSearchList']       = 'payment/rate/Rate_controller/FSxCRTEFormSearchList';
$route['ratePageAdd']              = 'payment/rate/Rate_controller/FSxCRTEAddPage';
$route['rateDataTable']            = 'payment/rate/Rate_controller/FSxCRTEDataTable';
$route['ratePageEdit']             = 'payment/rate/Rate_controller/FSvCRTEEditPage';
$route['rateEventAdd']             = 'payment/rate/Rate_controller/FSaCRTEAddEvent';
$route['rateEventEdit']            = 'payment/rate/Rate_controller/FSaCRTEEditEvent';
$route['rateEventDelete']          = 'payment/rate/Rate_controller/FSaCRTEDeleteEvent';

//CardLogin
$route['cardlogin']                     = 'payment/cardlogin/Cardlogin_controller/FSvCCardloginMainPage';
$route['cardloginDataTable']            = 'payment/cardlogin/Cardlogin_controller/FSvCCardLogDataList';
$route['cardloginPageAdd']              = 'payment/cardlogin/Cardlogin_controller/FSvCCardlogPageAdd';
$route['cardloginEventAdd']             = 'payment/cardlogin/Cardlogin_controller/FSaCCardlogAddEvent';
$route['cardloginPageEdit']             = 'payment/cardlogin/Cardlogin_controller/FSvCCardlogPageEdit';
$route['cardloginEventEdit']            = 'payment/cardlogin/Cardlogin_controller/FSaCCardlogEditEvent';
$route['cardloginEventDelete']          = 'payment/cardlogin/Cardlogin_controller/FSaCCardlogDeleteEvent';
$route['cardloginEventDeleteMultiple']  = 'payment/cardlogin/Cardlogin_controller/FSoCCardlogDelMultipleEvent';

// Create By Witsarut 27/11/2019
//ReciveSpc
$route['recivespc/(:any)/(:any)']       = 'payment/recivespc/Recivespc_controller/FSvCReciveSpcMainPage/$1/$2';
$route['recivespcDataTable']            = 'payment/recivespc/Recivespc_controller/FSvCReciveSpcDataList';
$route['recivespcPageAdd']              = 'payment/recivespc/Recivespc_controller/FSvCReciveSpcPageAdd';
$route['recivespcEventAdd']             = 'payment/recivespc/Recivespc_controller/FSaCReciveSpcAddEvent';
$route['recivespcPageEdit']             = 'payment/recivespc/Recivespc_controller/FSvCReciveSpcPageEdit';
$route['recivespcEventEdit']            = 'payment/recivespc/Recivespc_controller/FSaCReciveSpcEditEvent';
$route['recivespcEventDelete']          = 'payment/recivespc/Recivespc_controller/FSaCReciveSpcDeleteEvent';
$route['recivespcEventDeleteMultiple']  = 'payment/recivespc/Recivespc_controller/FSoCReciveSpcDelMultipleEvent';





// Create By Worakorn 04/11/2020
//ReciveSpc
$route['recivespcconfig/(:any)/(:any)']       = 'payment/recivespcconfig/Recivespccfg_controller/FSvCReciveSpcCfgMainPage/$1/$2';
$route['recivespcconfigDataTable']            = 'payment/recivespcconfig/Recivespccfg_controller/FSvCReciveSpcCfgDataList';
$route['recivespcconfigPageAdd']              = 'payment/recivespcconfig/Recivespccfg_controller/FSvCReciveSpcCfgPageAdd';

$route['recivespcconfigEventAdd']             = 'payment/recivespcconfig/Recivespccfg_controller/FSaCReciveSpcCfgAddEvent';
$route['recivespcconfigPageEdit']             = 'payment/recivespcconfig/Recivespccfg_controller/FSvCReciveSpcCfgPageEdit';
$route['recivespcconfigEventEdit']            = 'payment/recivespcconfig/Recivespccfg_controller/FSaCReciveSpcCfgEditEvent';
$route['recivespcconfigEventDelete']          = 'payment/recivespcconfig/Recivespccfg_controller/FSaCReciveSpcCfgDeleteEvent';
$route['recivespcconfigEventDeleteMultiple']  = 'payment/recivespcconfig/Recivespccfg_controller/FSoCReciveSpcCfgDelMultipleEvent';
