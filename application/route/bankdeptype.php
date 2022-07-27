<?php defined ('BASEPATH') or exit ( 'No direct script access allowed' );

$route ['bankdeptype/(:any)/(:any)']              = 'bankdeptype/bankdeptype/Bankdeptype_controller/index/$1/$2';
$route ['bankdeptypelist']                        = 'bankdeptype/bankdeptype/Bankdeptype_controller/FSxCBDTGetDatalist';
$route ['bankdeptypedatatable']                   = 'bankdeptype/bankdeptype/Bankdeptype_controller/FSxCBDTDataTable';
$route ['bankdeptypecallpageadd']                 = 'bankdeptype/bankdeptype/Bankdeptype_controller/FSxCBDTAddPage';
$route ['bankdeptypeaddevent']                    = 'bankdeptype/bankdeptype/Bankdeptype_controller/FSaCBDTAddEvent';
$route ['bankdeptypecallpageedit']                = 'bankdeptype/bankdeptype/Bankdeptype_controller/FSvCBDTEditPage';
$route ['bankdeptypeupdateevent']                 = 'bankdeptype/bankdeptype/Bankdeptype_controller/FSaCBNKEditEvent';
$route ['bankdeptypedelevent']                    = 'bankdeptype/bankdeptype/Bankdeptype_controller/FSaCBDTDeleteEvent';
