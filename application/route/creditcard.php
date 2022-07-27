<?php
//Credit (บัตรเครดิต)
$route ['creditcard/(:any)/(:any)']     = 'creditcard/creditcard/Creditcard_controller/index/$1/$2';
$route ['creditcardFormSearchList']     = 'creditcard/creditcard/Creditcard_controller/FSxCCDCFormSearchList';
$route ['creditcardPageAdd']            = 'creditcard/creditcard/Creditcard_controller/FSxCCDCAddPage';
$route ['creditcardDataTable']          = 'creditcard/creditcard/Creditcard_controller/FSxCCDCDataTable';
$route ['creditcardPageEdit']           = 'creditcard/creditcard/Creditcard_controller/FSvCCDCEditPage';
$route ['creditcardEventAdd']           = 'creditcard/creditcard/Creditcard_controller/FSaCCDCAddEvent';
$route ['creditcardEventEdit']          = 'creditcard/creditcard/Creditcard_controller/FSaCCDCEditEvent';
$route ['creditcardEventDelete']        = 'creditcard/creditcard/Creditcard_controller/FSaCCDCDeleteEvent';

// //Bank (ธนาคาร)
// $route ['bank/(:any)/(:any)']       = 'bank/bank/Bank_controller/index/$1/$2';
// $route ['bankFormSearchList']       = 'bank/bank/Bank_controller/FSxCBNKFormSearchList';
// $route ['bankDataTable']            = 'bank/bank/Bank_controller/FSxCBNKDataTable';
// $route ['bankPageAdd']              = 'bank/bank/Bank_controller/FSaCAGNAddEvent';
// $route ['bankEventAdd']             = 'bank/bank/Bank_controller/FSaCBNKAddEvent';
// $route ['bankPageEdit']             = 'bank/bank/Bank_controller/FSvCBNKEditPage';
// $route ['bankEventEdit']            = 'bank/bank/Bank_controller/FSaCBNKEditEvent';
$route ['bankEventDelete']          = 'bank/bank/Bank_controller/FSaCBNKDeleteEvent';
// $route ['bankGetdata2']          = 'bank/bank/Bank_controller/FSxCBNKDataTable';
