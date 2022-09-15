<?php defined ('BASEPATH') or exit ( 'No direct script access allowed' );

// Area (ภูมิภาค)
$route ['area/(:any)/(:any)']           = 'address/area/Area_controller/index/$1/$2';
$route ['areaList']                     = 'address/area/Area_controller/FSvCAREListPage';
$route ['areaDataTable']                = 'address/area/Area_controller/FSvCAREDataList';
$route ['areaPageAdd']                  = 'address/area/Area_controller/FSvCAREAddPage';
$route ['areaPageEdit']                 = 'address/area/Area_controller/FSvCAREEditPage';
$route ['areaEventAdd']                 = 'address/area/Area_controller/FSoCAREAddEvent';
$route ['areaEventEdit']                = 'address/area/Area_controller/FSoCAREEditEvent';
$route ['areaEventDelete']              = 'address/area/Area_controller/FSoCAREDeleteEvent';

// Zone (โซน)
$route ['zone/(:any)/(:any)']           = 'address/zone/Zone_controller/index/$1/$2';
$route ['zoneCheckUserLevel']           = 'address/zone/Zone_controller/FSvCZNECheckUserLevel';
$route ['zoneList']                     = 'address/zone/Zone_controller/FSvCZNEListPage';
$route ['zoneDataTable']                = 'address/zone/Zone_controller/FSvCZNEDataList';
$route ['zonePageAdd']                  = 'address/zone/Zone_controller/FSvCZNEAddPage';
$route ['zoneEventAdd']                 = 'address/zone/Zone_controller/FSaCZNEAddEvent';
$route ['zonePageEdit']                 = 'address/zone/Zone_controller/FSvCZNEEditPage';
$route ['zoneEventEdit']                = 'address/zone/Zone_controller/FSaCZNEEditEvent';
$route ['zoneEventDelete']              = 'address/zone/Zone_controller/FSaCZNEDeleteEvent';
$route ['zoneSetCallPageAdd']           = 'address/zone/Zone_controller/FSaCZNESETCallPageAdd';
$route ['zoneSetCallPageEdit']          = 'address/zone/Zone_controller/FSaCZNESETCallPageEdit';
//Refer
$route ['zoneEvenAddRefer']             = 'address/zone/Zone_controller/FSvCZNEAddRefer';
$route ['zoneReferTable']               = 'address/zone/Zone_controller/FSvCZNEObjDataList';
$route ['zoneReferEventDelete']         = 'address/zone/Zone_controller/FSaCAGNDeleteEvent';
$route ['zoneReferEventEdit']           = 'address/zone/Zone_controller/FSvCZNEEditRefer';





// Province
$route ['province/(:any)/(:any)']       = 'address/province/Province_controller/index/$1/$2';
$route ['provinceList']                 = 'address/province/Province_controller/FSvPVNListPage';
$route ['provinceDataTable']            = 'address/province/Province_controller/FSvPVNDataList';
$route ['provincePageAdd']              = 'address/province/Province_controller/FSvPVNAddPage';
$route ['provinceEventAdd']             = 'address/province/Province_controller/FSaPVNAddEvent';
$route ['provincePageEdit']             = 'address/province/Province_controller/FSvPVNEditPage';
$route ['provinceEventEdit']            = 'address/province/Province_controller/FSaPVNEditEvent';
$route ['provinceEventDelete']          = 'address/province/Province_controller/FSaPVNDeleteEvent';

// District
$route ['district/(:any)/(:any)']       = 'address/district/District_controller/index/$1/$2';
$route ['districtList']             	= 'address/district/District_controller/FSvDSTListPage';
$route ['districtDataTable']            = 'address/district/District_controller/FSvDSTDataList';
$route ['districtPageAdd']          	= 'address/district/District_controller/FSvDSTAddPage';
$route ['districtEventAdd']         	= 'address/district/District_controller/FSaDSTAddEvent';
$route ['districtPageEdit']         	= 'address/district/District_controller/FSvDSTEditPage';
$route ['districtEventEdit']        	= 'address/district/District_controller/FSaDSTEditEvent';
$route ['districtEventDelete']      	= 'address/district/District_controller/FSaDSTDeleteEvent';
$route ['districtGetPostCode']      	= 'address/district/District_controller/FSnCDSTGetPostCode';
$route ['districtBrowseProvince']   	= 'address/district/District_controller/FSoDSTCallProvince';
$route ['BrowsedistrictWhereProvince']  = 'address/district/District_controller/FSoCPVNCallBrowseDistrictWhereProvince';

// Sub District
$route ['subdistrict/(:any)/(:any)']    = 'address/subdistrict/Subdistrict_controller/index/$1/$2';
$route ['subdistrictList']              = 'address/subdistrict/Subdistrict_controller/FSvSDTListPage';
$route ['subdistrictDataTable']         = 'address/subdistrict/Subdistrict_controller/FSvSDTDataList';
$route ['subdistrictPageAdd']           = 'address/subdistrict/Subdistrict_controller/FSvSDTAddPage';
$route ['subdistrictPageEdit']          = 'address/subdistrict/Subdistrict_controller/FSvSDTEditPage';
$route ['subdistrictEventAdd']          = 'address/subdistrict/Subdistrict_controller/FSoSDTAddEvent';
$route ['subdistrictEventEdit']         = 'address/subdistrict/Subdistrict_controller/FSoSDTEditEvent';
$route ['subdistrictEventDelete']       = 'address/subdistrict/Subdistrict_controller/FSoSDTDeleteEvent';


//referencezone (อ้างอิงโซน)
$route ['referencezone/(:any)/(:any)']  = 'pos/referencezone/Referencezone_controller/index/$1/$2';
$route ['referencezoneList']            = 'pos/referencezone/Referencezone_controller/FSvCZneReferListPage';
$route ['referencezoneDataTable']       = 'pos/referencezone/Referencezone_controller/FSvCZneReferDataList';
$route ['referencezonePageAdd']         = 'pos/referencezone/Referencezone_controller/FSvCZneReferAddPage';
$route ['referencezonePageEdit']        = 'pos/referencezone/Referencezone_controller/FSvCZneReferEditPage';
$route ['referencezoneEventAdd']        = 'pos/referencezone/Referencezone_controller/FSoCZneReferAddEvent';
$route ['referencezoneEventEdit']       = 'pos/referencezone/Referencezone_controller/FSoCZneReferEditEvent';
$route ['referencezoneEventDelete']     = 'pos/referencezone/Referencezone_controller/FSoCZneReferDeleteEvent';

