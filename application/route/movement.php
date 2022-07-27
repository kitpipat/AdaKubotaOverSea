<?php defined('BASEPATH') or exit('No direct script access allowed');

// คลังสินค้า >> คลัง >> ความเคลื่อนไหว
$route['movement/(:any)/(:any)']    = 'movement/movement/Movement_controller/index/$1/$2';
$route['movementList']              = 'movement/movement/Movement_controller/FSvCMovementListPage';
$route['movementDataTable']         = 'movement/movement/Movement_controller/FSvCMovementDataList';


$route['mmtMMTPageContentTab']       = 'movement/movement/Movement_controller/FSxMmtContentTab';


$route['mmtINV/(:any)/(:any)']       = 'movement/inventory/Inv_controller/index/$1/$2';
$route['mmtINVPageList']             = 'movement/inventory/Inv_controller/FSxCInvPageList';
$route['mmtINVDataTableList']        = 'movement/inventory/Inv_controller/FSxCInvDataTableList';
