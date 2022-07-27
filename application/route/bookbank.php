<?php defined ('BASEPATH') or exit ( 'No direct script access allowed' );

//สมุดบัญชีธนาคาร
$route ['BookBank/(:any)/(:any)']               = 'bookbank/bookbank/Bookbank_controller/index/$1/$2';
$route ['BookBankList']                         = 'bookbank/bookbank/Bookbank_controller/FSxCBBKCallPageList';
$route ['BookBankDataTable']                    = 'bookbank/bookbank/Bookbank_controller/FSxCBBKDataTable';
$route ['BookBankEventPageAdd']                 = 'bookbank/bookbank/Bookbank_controller/FSxCBBKPageAdd';
$route ['BookBankEventAddContentDetail']        = 'bookbank/bookbank/Bookbank_controller/FSaCBBKAddEvent';
$route ['BookBankEventEditContentDetail']       = 'bookbank/bookbank/Bookbank_controller/FSaCBBKEditEvent';
$route ['BookBankEventPageEdit']                = 'bookbank/bookbank/Bookbank_controller/FSvCBBKEditPage';
$route ['BookBankEventDelete']                  = 'bookbank/bookbank/Bookbank_controller/FSaCBBKDeleteEvent';
// $route ['BookbankEventCallPageContentDetail']   = 'Bookbank/Bookbank/Bookbank_controller/FSxCBBKPageContentDetail';
// $route ['BookbankEventCallPageContentAccountActivity']   = 'Bookbank/Bookbank/Bookbank_controller/FSxCBBKPageContentAccountActivity';
