<?php defined ('BASEPATH') or exit ( 'No direct script access allowed' );


$route ['BookCheque/(:any)/(:any)']                = 'bookcheque/bookcheque/Bookcheque_controller/index/$1/$2';
$route ['BookChequeList']                          = 'bookcheque/bookcheque/Bookcheque_controller/FSvCBCQList';
$route ['BookChequeDatatable']                     = 'bookcheque/bookcheque/Bookcheque_controller/FSvCBCQGetDataTable';
$route ['BookChequeAddPage']                       = 'bookcheque/bookcheque/Bookcheque_controller/FSvCBCQAddPage';
$route ['BookChequeAddevent']                      = 'bookcheque/bookcheque/Bookcheque_controller/FSaCBCQAddEvent';
$route ['BookChequeUpdatPage']                     = 'bookcheque/bookcheque/Bookcheque_controller/FSvCBCQEditPage';
$route ['BookChequeUpdateevent']                   = 'bookcheque/bookcheque/Bookcheque_controller/FSaCBCQEditEvent';
$route ['BookChequeDelevent']                      = 'bookcheque/bookcheque/Bookcheque_controller/FSaCBCQDeleteEvent';