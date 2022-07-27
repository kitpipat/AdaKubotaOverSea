<?php

// ตั้งค่าการใช้งานฟังก์ชัน (Function Setting)
$route ['funcSetting/(:any)/(:any)'] = 'setting/func_setting/Funcsetting_controller/index/$1/$2';
$route ['funcSettingGetSearchList'] = 'setting/func_setting/Funcsetting_controller/FSxCFuncSettingSearchList';
$route ['funcSettingGetEditPage'] = 'setting/func_setting/Funcsetting_controller/FSxCFuncSettingEditPage';
$route ['funcSettingGetDataTableHD'] = 'setting/func_setting/Funcsetting_controller/FSxCFuncSettingGetDataTableInHD';
$route ['funcSettingGetDataTableTemp'] = 'setting/func_setting/Funcsetting_controller/FSxCFuncSettingGetDataTableInTemp';

$route ['funcSettingInsertDTToTmp'] = 'setting/func_setting/Funcsetting_controller/FSxCFuncSettingInsertDTToTemp';
$route ['funcSettingUpdateFuncInTmp'] = 'setting/func_setting/Funcsetting_controller/FSxCFuncSettingUpdateFuncInTmp';
$route ['funcSettingUpdateFuncAllInTmp'] = 'setting/func_setting/Funcsetting_controller/FSxCFuncSettingUpdateFuncAllInTmp';
$route ['funcSettingSaveEvent'] = 'setting/func_setting/Funcsetting_controller/FSxCFuncSettingSaveEvent';
