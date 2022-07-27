<?php defined ('BASEPATH') or exit ( 'No direct script access allowed' );

// Authencation
$route ['login']                        = 'authen/login/Login_controller';
$route ['Checklogin']                   = 'authen/login/Login_controller/FSaCLOGChkLogin';
$route ['logout']                       = 'authen/logout/Logout_controller';
$route ['CheckSession']                 = 'authen/session/Session_controller/FCNnCheckSession';
$route ['SetupAdaStoreBack']            = 'authen/login/Login_controller/FSaCLOGSetUpAdaStoreBack';

// Department
$route ['department/(:any)/(:any)']     = 'authen/department/Department_controller/index/$1/$2';
$route ['departmentList']               = 'authen/department/Department_controller/FSvCDPTListPage';
$route ['departmentDataTable']          = 'authen/department/Department_controller/FSvCDPTDataList';
$route ['departmentPageAdd']            = 'authen/department/Department_controller/FSvCDPTAddPage';
$route ['departmentPageEdit']           = 'authen/department/Department_controller/FSvCDPTEditPage';
$route ['departmentEventAdd']           = 'authen/department/Department_controller/FSoCDPTAddEvent';
$route ['departmentEventEdit']          = 'authen/department/Department_controller/FSoCDPTEditEvent';
$route ['departmentEventDelete']        = 'authen/department/Department_controller/FSoCDPTDeleteEvent';

// User
$route ['user/(:any)/(:any)']           = 'authen/user/User_controller/index/$1/$2';
$route ['userList']                     = 'authen/user/User_controller/FSvUSRListPage';
$route ['userDataTable']                = 'authen/user/User_controller/FSvUSRDataList';
$route ['userPageAdd']                  = 'authen/user/User_controller/FSvUSRAddPage';
$route ['userPageEdit']                 = 'authen/user/User_controller/FSvUSREditPage';
$route ['userEventAdd']                 = 'authen/user/User_controller/FSoUSRAddEvent';
$route ['userEventEdit']                = 'authen/user/User_controller/FSoUSREditEvent';
$route ['userEventDelete']              = 'authen/user/User_controller/FSoUSRDeleteEvent';
$route ['userEventGetRoleUsr']          = 'authen/user/User_controller/FSoUSREventGetRoleUsr';

// Import User
$route ['userPageImportDataTable']      = 'authen/user/User_controller/FSaCUSRImportDataTable';
$route ['userEventImportDelete']        = 'authen/user/User_controller/FSaCUSRImportDelete';
$route ['userEventImportMove2Master']   = 'authen/user/User_controller/FSaCUSRImportMove2Master';
$route ['userGetDataImport']            = 'authen/user/User_controller/FSaCUSRGetDataImport';
$route ['userGetItemAllImport']         = 'authen/user/User_controller/FSaCUSRImportGetItemAll';



//Role
$route['role/(:any)/(:any)']            = 'authen/role/Role_controller/index/$1/$2';
$route['roleList']                      = 'authen/role/Role_controller/FStCCallPageRoleList';
$route['roleDataTable']                 = 'authen/role/Role_controller/FSoCCallPageRoleDataTable';
$route['rolePageAdd']                   = 'authen/role/Role_controller/FSoCCallPageRoleAdd';
$route['rolePageEdit']                  = 'authen/role/Role_controller/FSoCCallPageRoleEdit';
$route['roleEventAdd']                  = 'authen/role/Role_controller/FSoRoleAddEvent';
$route['roleEventEdit']                 = 'authen/role/Role_controller/FSoRoleEditEvent';
$route['roleEventDelete']               = 'authen/role/Role_controller/FSoRoleDeleteEvent';

//UserLogin
$route ['userlogin']                     = 'authen/userlogin/Userlogin_controller/FSvCUserloginMainPage';
$route ['userloginDataTable']            = 'authen/userlogin/Userlogin_controller/FSvCUserLogDataList';
$route ['userloginPageAdd']              = 'authen/userlogin/Userlogin_controller/FSvCUserlogPageAdd';
$route ['userloginEventAdd']             = 'authen/userlogin/Userlogin_controller/FSaCUserlogAddEvent';
$route ['userloginPageEdit']             = 'authen/userlogin/Userlogin_controller/FSvCUserlogPageEdit';
$route ['userloginEventEdit']            = 'authen/userlogin/Userlogin_controller/FSaCUserlogEditEvent';
$route ['userloginEventDelete']          = 'authen/userlogin/Userlogin_controller/FSaCUserlogDeleteEvent';
$route ['userloginEventDeleteMultiple']  = 'authen/userlogin/Userlogin_controller/FSoCUserlogDelMultipleEvent';

// Change Password
$route ['cmmUSREventChangePassword']     = 'common/Common_controller/FCNaCCMMChangePassword';
