<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default']['hostname'] = '202.44.55.94'; // or put the IP of your SQL Server Instance

$db['default']['username'] = 'sa'; 
$db['default']['password'] = 'Ad@soft2016'; 
$db['default']['database'] = 'DevAdaFC';
//$db['default']['database'] = 'TesterAdaFC';
$db['default']['dbdriver'] = 'sqlsrv';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE; // changed (true by default)
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

