<?php defined ('BASEPATH') or exit ( 'No direct script access allowed' );

//สิทธิ์การอนุมัติเอกสาร
$route ['PermissionApproveDoc/(:any)/(:any)']       = 'permissionapvdoc/permissionapvdoc/Permissionapvdoc_controller/index/$1/$2';
$route ['PermissionApproveDocList']                 = 'permissionapvdoc/permissionapvdoc/Permissionapvdoc_controller/FSxCPADCallPageList';
$route ['PermissionApproveDocDataTable']            = 'permissionapvdoc/permissionapvdoc/Permissionapvdoc_controller/FSxCPADDataTable';
$route ['PermissionApproveDocPageEdit']             = 'permissionapvdoc/permissionapvdoc/Permissionapvdoc_controller/FSvCPADEditPage';
$route ['PermissionApproveDocEventAdd']             = 'permissionapvdoc/permissionapvdoc/Permissionapvdoc_controller/FSvCPADEventAdd';
