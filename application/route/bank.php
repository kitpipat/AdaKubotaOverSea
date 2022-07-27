<?php defined ('BASEPATH') or exit ( 'No direct script access allowed' );

$route ['bankindex/(:any)/(:any)']    = 'bank/bank/Bank_controller/index/$1/$2';
$route ['banklist']                   = 'bank/bank/Bank_controller/FSvCBNKListPage';
$route ['bankDataTable']              = 'bank/bank/Bank_controller/FSvCBNKDataList';
$route ['bankPageAdd']                = 'bank/bank/Bank_controller/FSvCBNKAddPage';
$route ['bankPageEdit']               = 'bank/bank/Bank_controller/FSvCBNKEditPage';
$route ['bankEventAdd']               = 'bank/bank/Bank_controller/FSoCBNKAddEvent';
$route ['bankEventEdit']              = 'bank/bank/Bank_controller/FSoCBNKEditEvent';
$route ['bankEventDelete']            = 'bank/bank/Bank_controller/FSoCBNKDeleteEvent';
