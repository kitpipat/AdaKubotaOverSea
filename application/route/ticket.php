<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );


$route ['EticketBranchNew']                 = 'ticket/branch/Branchnew_controller/index';
$route ['EticketBranchAjaxNew']             = 'ticket/branch/Branchnew_controller/FSxCPRKList';
$route ['EticketBranchAjaxSearchNew']       = 'ticket/branch/Branchnew_controller/FStCPRKAjaxSearch';
// FS Location
$route ['EticketLocationNew/(.*)']          = 'ticket/location/Locationnew_controller/FSxCLocLocation/$1';
$route ['EticketLocAjaxSearchNew']          = 'ticket/location/Locationnew_controller/FStCLOCAjaxSearch';
$route ['EticketLocAjaxListNew']            = 'ticket/location/Locationnew_controller/FSxCLOCList';
$route ['EticketAddLocNew/(.*)']            = 'ticket/location/Locationnew_controller/FSxCLOCAdd/$1';
$route ['EticketEditLocNew/(.*)/(.*)']      = 'ticket/location/Locationnew_controller/FSxCLOCEdit/$1/$2';
$route ['EticketAddLocAjaxNew']             = 'ticket/location/Locationnew_controller/FSxCLocAddAjax';
$route ['EticketSaveLocation']              = 'ticket/location/Locationnew_controller/FSxCLocSaveLocation';
$route ['EticketDeleteLocation']            = 'ticket/location/Locationnew_controller/FSxCLocDeleteLocation';
$route ['EticketLoadArea']                  = 'ticket/location/Locationnew_controller/FSxCLocLoadArea';
$route ['EticketDelAre']                    = 'ticket/location/Locationnew_controller/FSxCLOCDelAre';
$route ['EticketLocCheck']                  = 'ticket/location/Locationnew_controller/FSxCLOCCheck';
// FS Level
$route ['EticketLevelListNew']              = 'ticket/level/Levelnew_controller/FSxCLVLList';
$route ['EticketLevelNew/(.*)']             = 'ticket/level/Levelnew_controller/FSxCLVL/$1';
$route ['EticketAddLevelNew/(.*)']          = 'ticket/level/Levelnew_controller/FSxCLVLAdd/$1';
$route ['EticketEditLevelNew/(.*)/(.*)']    = 'ticket/level/Levelnew_controller/FSxCLVLEdit/$1/$2';
$route ['EticketAddLevelAjax']              = 'ticket/level/Levelnew_controller/FSxCLVLAddAjax';
$route ['EticketEditLevelAjax']             = 'ticket/level/Levelnew_controller/FSxCLVLEditAjax';
$route ['EticketDelLevel']                  = 'ticket/level/Levelnew_controller/FSxCLVLDel';
$route ['EticketLvlCount']                  = 'ticket/level/Levelnew_controller/FStCLVLCount';
$route ['EticketLvlCheck']                  = 'ticket/level/Levelnew_controller/FStCLVLCheck';
// FS Zone
$route ['EticketZoneNew/(.*)']              = 'ticket/zone/Zonenew_controller/FSxCZNE/$1';
$route ['EticketZoneListNew']               = 'ticket/zone/Zonenew_controller/FSxCZNEList';
$route ['EticketAddZoneNew/(.*)']           = 'ticket/zone/Zonenew_controller/FSxCZNEAdd/$1';
$route ['EticketEditZoneNew/(.*)']          = 'ticket/zone/Zonenew_controller/FSxCZNEEdit/$1';
$route ['EticketZneCount']                  = 'ticket/zone/Zonenew_controller/FStCZNECount';
$route ['EticketAddZoneAjax']               = 'ticket/zone/Zonenew_controller/FSxCZNEAddAjax';
$route ['EticketEditZoneAjax']              = 'ticket/zone/Zonenew_controller/FSxCZNEEditAjax';
$route ['EticketZoneDel']                   = 'ticket/zone/Zonenew_controller/FSxCZNEDel';
$route ['EticketDelImgZne']                 = 'ticket/zone/Zonenew_controller/FSxCZNEDelImg';

// FS Gate
$route ['EticketGateNew/(.*)']              = 'ticket/gate/Gatenew_controller/FSxCGTE/$1';
$route ['EticketAddGateNew/(.*)']           = 'ticket/gate/Gatenew_controller/FSxCGTEAdd/$1';
$route ['EticketDelGateNew']                = 'ticket/gate/Gatenew_controller/FSxCGTEDel';
$route ['EticketGateListNew']               = 'ticket/gate/Gatenew_controller/FSxCGTEList';
$route ['EticketEditGateNew/(.*)/(.*)']     = 'ticket/gate/Gatenew_controller/FSxCGTEEdit/$1/$2';
$route ['EticketGateCheck']                 = 'ticket/gate/Gatenew_controller/FStCGTECheck';
$route ['EticketGateCount']                 = 'ticket/gate/Gatenew_controller/FSxCGTECount';
$route ['EticketAddGateAjax']               = 'ticket/gate/Gatenew_controller/FSxCGTEAddAjax';
$route ['EticketEditGateAjax']              = 'ticket/gate/Gatenew_controller/FSxCGTEEditAjax';
// Layout
$route ['EticketLayoutNew/(.*)']            = 'ticket/layout/Layoutnew_controller/FSxCLOT/$1';
$route ['EticketLayoutAddNew/(.*)']         = 'ticket/layout/Layoutnew_controller/FSxCLOTAdd/$1';
$route ['EticketLayoutDelImg']              = 'ticket/layout/Layoutnew_controller/FSxCLOTDelImg';
// สถานที่จัดการวันหยุด
$route ['EticketLocDayOffNew/(.*)']         = 'ticket/dayoff/Dayoffnew_controller/FSxCDOF/$1';
$route ['EticketLocDayOffAddNew/(.*)']      = 'ticket/dayoff/Dayoffnew_controller/FSxCDOFAdd/$1';
$route ['EticketLocDayOffEditNew/(.*)/(.*)']= 'ticket/dayoff/Dayoffnew_controller/FSxCDOFEdit/$1/$2';
$route ['EticketLocDayOff/(.*)']            = 'ticket/dayoff/Dayoffnew_controller/FSxCDOF/$1';
$route ['EticketLocDayOffList']             = 'ticket/dayoff/Dayoffnew_controller/FSxCDOFList';
$route ['EticketLocDayOffCount']            = 'ticket/dayoff/Dayoffnew_controller/FStCDOFCount';
$route ['EticketLocDayOffAdd/(.*)']         = 'ticket/dayoff/Dayoffnew_controller/FSxCDOFAdd/$1';
$route ['EticketLocDayOffAjax']             = 'ticket/dayoff/Dayoffnew_controller/FSxCDOFAjax';
$route ['EticketLocDayOffEdit/(.*)/(.*)']   = 'ticket/dayoff/Dayoffnew_controller/FSxCDOFEdit/$1/$2';
$route ['EticketLocDayOffEditAjax']         = 'ticket/dayoff/Dayoffnew_controller/FSxCDOFEditAjax';
$route ['EticketLocDayOffDel']              = 'ticket/dayoff/Dayoffnew_controller/FSxCDOFDel';
// Room
$route ['EticketRoomNew/(.*)/(.*)']         = 'ticket/room/Roomnew_controller/FSxCROM/$1/$2';
$route ['EticketRoomListNew']               = 'ticket/room/Roomnew_controller/FSxCROMList';
// Seat
$route ['EticketSeatNew/(.*)/(.*)/(.*)']    = 'ticket/seat/Seatnew_controller/FSxCSETSeat/$1/$2/$3';
$route ['EticketSeatListNew']               = 'ticket/seat/Seatnew_controller/FSxCSETSeatList';
$route ['EticketCreateSeatNew']             = 'ticket/seat/Seatnew_controller/FSxCSETCreateSeat';

// Branch
$route ['EticketBranch']                    = 'ticket/branch/Branchnew_controller/index';
$route ['EticketBranchAjax']                = 'ticket/branch/Branchnew_controller/FSxCPRKList';
$route ['EticketBranchAjaxSearch']          = 'ticket/branch/Branchnew_controller/FStCPRKAjaxSearch';
$route ['EticketSaveBranch']                = 'ticket/branch/Branchnew_controller/FSxCPRKSave';
$route ['EticketDeleteBranch']              = 'ticket/branch/Branchnew_controller/FSxCPRKDelete';
$route ['EticketBranchDetail']              = 'ticket/branch/Branchnew_controller/FSxCPRKDetail';
$route ['EticketBranchCheck']               = 'ticket/branch/Branchnew_controller/FSxCPRKCheck';
$route ['EticketDistrict']                  = 'ticket/branch/Branchnew_controller/FSxCPRKDistrict';
$route ['EticketProvince']                  = 'ticket/branch/Branchnew_controller/FSxCPRKProvince';
$route ['EticketAddBranch']                 = 'ticket/branch/Branchnew_controller/FSxCPRKAdd';
$route ['EticketAddBranchAjax']             = 'ticket/branch/Branchnew_controller/FSxCPRKAddAjax';
$route ['EticketEditBranch/(.*)']           = 'ticket/branch/Branchnew_controller/FSxCPRKEdit/$1';
$route ['EticketEditBranchAjax']            = 'ticket/branch/Branchnew_controller/FSxCPRKEditAjax';
$route ['EticketDelImgBranch']              = 'ticket/branch/Branchnew_controller/FSxCPRKDelImgPrk';
$route ['branchPageAdd']                    = 'company/branch/Branch_controller/FSvCBCHAddPage';
$route ['branchCallPageEdit']               = 'ticket/branch/Branchnew_controller/FSvCBCHCallPageEdit';

// FS Location
$route ['EticketLocation/(.*)']             = 'ticket/location/Locationnew_controller/FSxCLocLocation/$1';
$route ['EticketSaveLocation']              = 'ticket/location/Locationnew_controller/FSxCLocSaveLocation';
$route ['EticketLocAjaxList']               = 'ticket/location/Locationnew_controller/FSxCLOCList';
$route ['EticketLocAjaxSearch']             = 'ticket/location/Locationnew_controller/FStCLOCAjaxSearch';
$route ['EticketDeleteLocation']            = 'ticket/location/Locationnew_controller/FSxCLocDeleteLocation';
$route ['EticketLoadArea']                  = 'ticket/location/Locationnew_controller/FSxCLocLoadArea';
$route ['EticketDelAre']                    = 'ticket/location/Locationnew_controller/FSxCLOCDelAre';
$route ['EticketLocCheck']                  = 'ticket/location/Locationnew_controller/FSxCLOCCheck';
$route ['EticketAddLoc/(.*)']               = 'ticket/location/Locationnew_controller/FSxCLOCAdd/$1';
$route ['EticketAddLocAjax']                = 'ticket/location/Locationnew_controller/FSxCLocAddAjax';
$route ['EticketEditLoc/(.*)/(.*)']         = 'ticket/location/Locationnew_controller/FSxCLOCEdit/$1/$2';
$route ['EticketEditLocAjax']               = 'ticket/location/Locationnew_controller/FSxCLOCEditAjax';
$route ['EticketDelImgLoc']                 = 'ticket/location/Locationnew_controller/FSxCLOCDelImg';

// Agency
$route ['agency/(:any)/(:any)']             = 'ticket/agency/Agency_controller/index/$1/$2';
$route ['agencyList']                       = 'ticket/agency/Agency_controller/FStCAGNList';
$route ['agencyDataTable']                  = 'ticket/agency/Agency_controller/FSxCANGDataTable';
$route ['agencyPageAdd']                    = 'ticket/agency/Agency_controller/FSxCAGNAddPage';
$route ['agencyPageEdit']                   = 'ticket/agency/Agency_controller/FSvCAGNEditPage';
$route ['agencyEventAdd']                   = 'ticket/agency/Agency_controller/FSaCAGNAddEvent';
$route ['agencyEventEdit']                  = 'ticket/agency/Agency_controller/FSaCAGNEditEvent';
$route ['agencyEventDelete']                = 'ticket/agency/Agency_controller/FSaCAGNDeleteEvent';



//group Agency 
$route ['EticketAgency/group']              = 'ticket/agency/Agency_controller/FSxCAGEGroup';
$route ['EticketAgency/groupAjaxList']      = 'ticket/agency/Agency_controller/FSxCAGEGroupAjaxList';
$route ['EticketAgency/groupCount']         = 'ticket/agency/Agency_controller/FSxCAGEGroupCount';
$route ['EticketAgency/deleteGroup']        = 'ticket/agency/Agency_controller/FSxCAGEGroupDelete';
$route ['EticketAgency/EditGroup/(.*)']     = 'ticket/agency/Agency_controller/FSxCAGEGroupEdit/$1';
$route ['EticketAgency/EditGroupAjax']      = 'ticket/agency/Agency_controller/FSxCAGEGroupEditAjax';
$route ['EticketAgency/AddGroup']           = 'ticket/agency/Agency_controller/FSxCAGEGroupAdd';
$route ['EticketAgency/AddGroupAjax']       = 'ticket/agency/Agency_controller/FSxCAGEGroupAddAjax';

//group Type
$route ['EticketAgency/Type']               = 'ticket/agency/Agency_controller/FSxCAGEType';
$route ['EticketAgency/TypeAjaxList']       = 'ticket/agency/Agency_controller/FSxCAGETypeAjaxList';
$route ['EticketAgency/TypeCount']          = 'ticket/agency/Agency_controller/FSxCAGETypeCount';
$route ['EticketAgency/deleteType']         = 'ticket/agency/Agency_controller/FSxCAGETypeDelete';
$route ['EticketAgency/EditType/(.*)']      = 'ticket/agency/Agency_controller/FSxCAGETypeEdit/$1';
$route ['EticketAgency/EditTypeAjax']       = 'ticket/agency/Agency_controller/FSxCAGETypeEditAjax';
$route ['EticketAgency/AddType']            = 'ticket/agency/Agency_controller/FSxCAGETypeAdd';
$route ['EticketAgency/AddTypeAjax']        = 'ticket/agency/Agency_controller/FSxCAGETypeAddAjax';

//Promotion
$route ['EticketPromotion']                 = 'ticket/promotion/Promotion_controller/FSxCPMT';
$route ['EticketPromotionList']             = 'ticket/promotion/Promotion_controller/FSxCPMTList';
$route ['EticketPromotionCount']            = 'ticket/promotion/Promotion_controller/FSxCPMTCount';
$route ['EticketPromotionDel']              = 'ticket/promotion/Promotion_controller/FSxCPMTDel';
$route ['EticketPromotionAdd']              = 'ticket/promotion/Promotion_controller/FSxCPMTAdd';
$route ['EticketPromotionAddAjax']          = 'ticket/promotion/Promotion_controller/FSxCPMTAddAjax';
$route ['EticketPromotionEdit/(.*)']        = 'ticket/promotion/Promotion_controller/FSxCPMTEdit/$1';
$route ['EticketPromotionEditAjax']         = 'ticket/promotion/Promotion_controller/FSxCPMTEditAjax';
$route ['EticketPromotionPkgList']          = 'ticket/promotion/Promotion_controller/FSxCPMTPkgList';
$route ['EticketPromotionPkgCount']         = 'ticket/promotion/Promotion_controller/FSxCPMTPkgCount';
$route ['EticketPromotionBchList']          = 'ticket/promotion/Promotion_controller/FSxCPMTBchList';
$route ['EticketPromotionBchCount']         = 'ticket/promotion/Promotion_controller/FSxCPMTBchCount';
$route ['EticketPromotionAgnList']          = 'ticket/promotion/Promotion_controller/FSxCPMTAgnList';
$route ['EticketPromotionAgnCount']         = 'ticket/promotion/Promotion_controller/FSxCPMTAgnCount';
$route ['EticketPromotionCstList']          = 'ticket/promotion/Promotion_controller/FSxCPMTCstList';
$route ['EticketPromotionCstCount']         = 'ticket/promotion/Promotion_controller/FSxCPMTCstCount';
$route ['EticketPromotionGenKey']           = 'ticket/promotion/Promotion_controller/FSxCPMTGenKey';
$route ['EticketPromotionDelPkg']           = 'ticket/promotion/Promotion_controller/FSxCPMTDelPkg';
$route ['EticketPromotionDelBch']           = 'ticket/promotion/Promotion_controller/FSxCPMTDelBch';
$route ['EticketPromotionDelGrp']           = 'ticket/promotion/Promotion_controller/FSxCPMTDelGrp';
$route ['EticketPromotionApv']              = 'ticket/promotion/Promotion_controller/FSxCPMTApv';
$route ['EticketPromotionChkCode']          = 'ticket/promotion/Promotion_controller/FSxCPMTChkCode';

// Customer
$route ['EticketCustomer']                  = 'ticket/customer/Customer_controller/FSxCCST';
$route ['EticketCustomer/count']            = 'ticket/customer/Customer_controller/FStCCSTCount';
$route ['EticketCustomer/ajaxList']         = 'ticket/customer/Customer_controller/FSxCCSTAjaxList';
$route ['EticketCustomer/add']              = 'ticket/customer/Customer_controller/FSxCCSTAdd';
$route ['EticketCustomer/addAjax']          = 'ticket/customer/Customer_controller/FSxCCSTAddAjax';
$route ['EticketCustomer/edit/(.*)']        = 'ticket/customer/Customer_controller/FSxCCSTEdit/$1';
$route ['EticketCustomer/editAjax']         = 'ticket/customer/Customer_controller/FSxCCSTEditAjax';
$route ['EticketCustomer/delete']           = 'ticket/customer/Customer_controller/FSxCCSTDelete';
$route ['EticketCustomer/view/(.*)']        = 'ticket/customer/Customer_controller/FSxCCSTView/$1';
$route ['EticketCustomer/checkemail']       = 'ticket/customer/Customer_controller/FSxCCSTCheckEmail';
$route ['EticketCustomer/DelImg']           = 'ticket/customer/Customer_controller/FSxCCSTDelImg';

// category customer
$route ['EticketCustomer/category']             = 'ticket/customer/Customer_controller/FSxCCSTCategory';
$route ['EticketCustomer/categoryAjaxList']     = 'ticket/customer/Customer_controller/FSxCCSTCategoryAjaxList';
$route ['EticketCustomer/categoryCount']        = 'ticket/customer/Customer_controller/FSxCCSTCategoryCount';
$route ['EticketCustomer/deleteCategory']       = 'ticket/customer/Customer_controller/FSxCCSTCategoryDelete';
$route ['EticketCustomer/EditCategory/(.*)']    = 'ticket/customer/Customer_controller/FSxCCSTCategoryEdit/$1';
$route ['EticketCustomer/EditCategoryAjax']     = 'ticket/customer/Customer_controller/FSxCCSTCategoryEditAjax';
$route ['EticketCustomer/AddCategory']          = 'ticket/customer/Customer_controller/FSxCCSTCategoryAdd';
$route ['EticketCustomer/AddCategoryAjax']      = 'ticket/customer/Customer_controller/FSxCCSTCategoryAddAjax';

// group customer **
$route ['EticketCustomer/group']                = 'ticket/customer/Customer_controller/FSxCCSTGroup';
$route ['EticketCustomer/groupAjaxList']        = 'ticket/customer/Customer_controller/FSxCCSTGroupAjaxList';
$route ['EticketCustomer/groupCount']           = 'ticket/customer/Customer_controller/FSxCCSTGroupCount';
$route ['EticketCustomer/deleteGroup']          = 'ticket/customer/Customer_controller/FSxCCSTGroupDelete';
$route ['EticketCustomer/EditGroup/(.*)']       = 'ticket/customer/Customer_controller/FSxCCSTGroupEdit/$1';
$route ['EticketCustomer/EditGroupAjax']        = 'ticket/customer/Customer_controller/FSxCCSTGroupEditAjax';
$route ['EticketCustomer/AddGroup']             = 'ticket/customer/Customer_controller/FSxCCSTGroupAdd';
$route ['EticketCustomer/AddGroupAjax']         = 'ticket/customer/Customer_controller/FSxCCSTGroupAddAjax';


// Package
$route ['EticketPackage']                                       = 'ticket/package/Package_controller/index';
$route ['EticketPackageCount']                                  = 'ticket/package/Package_controller/FStCPKGCount';
$route ['EticketPackageList']                                   = 'ticket/package/Package_controller/FSxCPKGList';
$route ['EticketDeletePackage']                                 = 'ticket/package/Package_controller/FSxCPKGDelete';
$route ['EticketPackage_PdtSearch']                             = 'ticket/package/Package_controller/FSxCPKGPdtListSearch';
$route ['EticketPackage_PdtSelectedList']                       = 'ticket/package/Package_controller/FSxCPKGPdtSelectedList';
$route ['EticketPCK_AddPackage']                                = 'ticket/package/Package_controller/FSxCPKGAddPackage';
$route ['EticketPck_Call_Page_AddPackage']                      = 'ticket/package/Package_controller/FSxCPKGCallPageAddPackage';
$route ['EticketPackage_CountCheckPkgNoPdt']                    = 'ticket/package/Package_controller/FSxCPKGCountCheckPkgNoPdt';
$route ['EticketPackage_GETPageDialogPkgNoPdt']                 = 'ticket/package/Package_controller/FSxCPKGGETPageDialogPkgNoPdt';
$route ['EticketPackage_DelPkgNoPdt']                           = 'ticket/package/Package_controller/FSxCPKGDelPkgNoPdt';
$route ['EticketPackage_CallPageEditPkg']                       = 'ticket/package/Package_controller/FSxCPKGCallPageEditPkg';
$route ['EticketPackage_CallPageAddPkg']                        = 'ticket/package/Package_controller/FSxCPKGCallPageAddPkg';
$route ['EticketPackage_EditPackage']                           = 'ticket/package/Package_controller/FSxCPKGEditPkg';
$route ['EticketPackage_CallPagePkgDetail']                     = 'ticket/package/Package_controller/FSxCPKGCallPagePkgDetail';
$route ['EticketPackage_CallPagePkgModel']                      = 'ticket/package/Package_controller/FSxCPKGCallPagePkgModel';
$route ['EticketPackage_AddPkgModel']                           = 'ticket/package/Package_controller/FSxCPKGAddPkgModel';
$route ['EticketPackage_DelPkgModelAdmin']                      = 'ticket/package/Package_controller/FSxCPKGDelPkgModelAdmin';
$route ['EticketPackage_CallPageModalModelCustomer']            = 'ticket/package/Package_controller/FSxCPKGCallPageModalModelCustomer';
$route ['EticketPackage_CallPagePkgModalCstZone']               = 'ticket/package/Package_controller/FSxCPKGCallPagePkgModalCstZone';
$route ['EticketPackage_AddPkgModelZone']                       = 'ticket/package/Package_controller/FSxCPKGAddPkgModelZone';
$route ['EticketPackage_CheckPkgModelZoneMore2']                = 'ticket/package/Package_controller/FSxCPKGCheckPkgModelZoneMore2';
$route ['EticketPackage_AddPkgModelZoneStep2']                  = 'ticket/package/Package_controller/FSnCPKGAddPkgModelZoneStep2';
$route ['EticketPackage_DelPkgModelCustomer']                   = 'ticket/package/Package_controller/FSxCPKGDelPkgModelCustomer';
$route ['EticketPackage_CallPagePkgProduct']                    = 'ticket/package/Package_controller/FSxCPKGCallPagePkgProduct';
$route ['EticketPackage_GetSelectPdtHTML']                      = 'ticket/package/Package_controller/FSxCPKGGetSelectPdtHTML';
$route ['EticketPackage_AddPkgModelProduct']                    = 'ticket/package/Package_controller/FSxCPKGAddPkgModelProduct';
$route ['EticketPackage_DelPkgProduct']                         = 'ticket/package/Package_controller/FSxCPKGDelPkgProduct';
$route ['EticketPackage_EditPkgProduct']                        = 'ticket/package/Package_controller/FSxCPKGEditPkgProduct';
$route ['EticketPackage_CallPageModelAndPdtPanal']              = 'ticket/package/Package_controller/FSxCPKGCallPageModelAndPdtPanal';
$route ['EticketPackage_CallPagePdtPriSpcPri']                  = 'ticket/package/Package_controller/FSxCPKGCallPagePdtPriSpcPri';
$route ['EticketPackage_CallPagePdtPriSpcPriByDOWPanal']        = 'ticket/package/Package_controller/FSxCPKGCallPagePdtPriSpcPriByDOWPanal';
$route ['EticketPackage_CallPagePdtPriSpcPriByHLDPanal']        = 'ticket/package/Package_controller/FSxCPKGCallPagePdtPriSpcPriByHLDPanal';
$route ['EticketPackage_CallPagePdtSpcPriByWeekPanal']          = 'ticket/package/Package_controller/FSxCPKGCallPagePdtSpcPriByWeekPanal';
$route ['EticketPackage_CallPagePdtPriSpcPriByBKGPanal']        = 'ticket/package/Package_controller/FSxCPKGCallPagePdtPriSpcPriByBKGPanal';
$route ['EticketPackage_AddPkgPdtPriBKG']                       = 'ticket/package/Package_controller/FSnCPKGAddPkgPdtPriBKG';
$route ['EticketPackage_EditPkgPdtPriBKG']                      = 'ticket/package/Package_controller/FSxCPKGEditPkgPdtPriBKG';
$route ['EticketPackage_DelPkgPdtPriBKG']                       = 'ticket/package/Package_controller/FSxCPKGDelPdtGrpPriBKG';
$route ['EticketPackage_DelImgPkg']                             = 'ticket/package/Package_controller/FSxCPKGDelImg';
$route ['EticketPackage_GetSelectModelHTML']                    = 'ticket/package/Package_controller/FSxCPKGGetSelectModelHTML';
$route ['EticketPackage_AddPackage']                            = 'ticket/package/Package_controller/FSxCPKGAddPkg';
$route ['EticketPackage_ApprovePkg']                            = 'ticket/package/Package_controller/FSxCPKGApprovePkg';
$route ['EticketPackage_CallPagePkgSpcPriByGrp']                = 'ticket/package/Package_controller/FSxCPKGCallPagePkgSpcPriByGrp';
$route ['EticketPackage_GetSelectPkgGrpPriHTML']                = 'ticket/package/Package_controller/FStCPKGGetSelectPkgGrpPriHTML';
$route ['EticketPackage_AddPkgGrpPri']                          = 'ticket/package/Package_controller/FSnCPKGAddSpcPkgGrpPri';
$route ['EticketPackage_EditPkgSpcGrpPri']                      = 'ticket/package/Package_controller/FSnCPKGEditPkgSpcGrpPri';
$route ['EticketPackage_DelPkgSpcGrpPri']                       = 'ticket/package/Package_controller/FSxCPKGDelPkgSpcGrpPri';
$route ['EticketPackage_CallPagePdtGrpPri']                     = 'ticket/package/Package_controller/FSxCPKGCallPagePdtGrpPri';
$route ['EticketPackage_AddPkgPdtGrpPri']                       = 'ticket/package/Package_controller/FSnCPKGAddPkgPdtGrpPri';
$route ['EticketPackage_DelPkgPdtGrpPri']                       = 'ticket/package/Package_controller/FSxCPKGDelPkgPdtGrpPri';
$route ['EticketPackage_CallPagePkgGrpPriSpcPri']               = 'ticket/package/Package_controller/FSxCPKGCallPagePkgGrpPriSpcPri';
$route ['EticketPackage_CallPagePkgGrpPriSpcPriByDOWPanal']     = 'ticket/package/Package_controller/FSxCPKGCallPagePkgGrpPriSpcPriByDOWPanal';
$route ['EticketPackage_EditGrpPriSpcPriByDOW']                 = 'ticket/package/Package_controller/FSnCPKGEditGrpPriSpcPriByDOW';
$route ['EticketPackage_CallPagePkgGrpPriSpcPriByHLDPanal']     = 'ticket/package/Package_controller/FSxCPKGCallPagePkgGrpPriSpcPriByHLDPanal';
$route ['EticketPackage_EditPdtPriSpcPriByDOW']                 = 'ticket/package/Package_controller/FSnCPKGEditPdtPriSpcPriByDOW';
$route ['EticketPackage_CallPagePkgGrpPriSpcPriByBKGPanal']     = 'ticket/package/Package_controller/FSxCPKGCallPagePkgGrpPriSpcPriByBKGPanal';
$route ['EticketPackage_AddPkgGrpPriBKG']                       = 'ticket/package/Package_controller/FSnCPKGAddPkgGrpPriBKG';
$route ['EticketPackage_EditPkgGrpPriBKG']                      = 'ticket/package/Package_controller/FSxCPKGEditPkgGrpPriBKG';
$route ['EticketPackage_DelPkgGrpPriBKG']                       = 'ticket/package/Package_controller/FSxCPKGDelPkgGrpPriBKG';
$route ['EticketPackage_GetSelectTchGrpByPmoHTML']              = 'ticket/package/Package_controller/FSxCPKGGetSelectTchGrpByPmoHTML';
$route ['EticketPackage_CallPagePkgModalCstShowTime']           = 'ticket/package/Package_controller/FSxCPKGCallPagePkgModalCstShowTime';
$route ['EticketPackage_CallPageViewDetailLocShowTime']         = 'ticket/package/Package_controller/FSxCPKGCallPageViewDetailLocShowTime';
$route ['EticketPackage_CallPageTimeTableHDPanal']              = 'ticket/package/Package_controller/FSxCPKGCallPageTimeTableHDPanal';
$route ['EticketPackage_AddLocShowTime']                        = 'ticket/package/Package_controller/FSnCPKGAddLocShowTime';
$route ['EticketPackage_CallPageLocShowTimePanal']              = 'ticket/package/Package_controller/FSnCPKGCallPageLocShowTimePanal';
$route ['EticketPackage_DelPkgLocShowTimePanal']                = 'ticket/package/Package_controller/FSxCPKGDelPkgLocShowTimePanal';
$route ['EticketPackage_CheckLocHaveShowTime']                  = 'ticket/package/Package_controller/FSxCPKGCheckLocHaveShowTime';
$route ['EticketPackage_CallPagePpkPriSpcPri']                  = 'ticket/package/Package_controller/FSxCPKGCallPagePpkPriSpcPri';
$route ['EticketPackage_CallPagePkgPriByDOWPanal']              = 'ticket/package/Package_controller/FSxCPKGCallPagePkgPriByDOWPanal';
$route ['EticketPackage_EditPkgPriSpcPriByDOW']                 = 'ticket/package/Package_controller/FSnCPKGEditPkgPriSpcPriByDOW';
$route ['EticketPackage_CallPagePkgPriByBKGPanal']              = 'ticket/package/Package_controller/FSxCPKGCallPagePkgPriByBKGPanal';
$route ['EticketPackage_CallPagePkgPriByHLDPanal']              = 'ticket/package/Package_controller/FSxCPKGCallPagePkgPriByHLDPanal';
$route ['EticketPackage_AddPkgPriBKG']                          = 'ticket/package/Package_controller/FSnCPKGAddPkgPriBKG';
$route ['EticketPackage_EditPkgPriBKG']                         = 'ticket/package/Package_controller/FSxCPKGEditPkgPriBKG';
$route ['EticketPackage_DelPkgPriBKG']                          = 'ticket/package/Package_controller/FSxCPKGDelPkgPriBKG';
$route ['EticketPackage_GetPdtFullCalendar']                    = 'ticket/package/Package_controller/FSoCPKGGetPdtFullCalendar';
$route ['EticketPackage_GetPdtFullCalendarList']                = 'ticket/package/Package_controller/FSoCPKGGetPdtFullCalendarList';
$route ['EticketPackage_AddPdtSpcPriHLD']                       = 'ticket/package/Package_controller/FSnCPKGAddPdtSpcPriHLD';
$route ['EticketPackage_DelPdtSpcPriHLD']                       = 'ticket/package/Package_controller/FSnCPKGDelPdtSpcPriHLD';
$route ['EticketPackage_GetGrpFullCalendar']                    = 'ticket/package/Package_controller/FSoCPKGGetGrpFullCalendar';
$route ['EticketPackage_GetGrpFullCalendarList']                = 'ticket/package/Package_controller/FSoCPKGGetGrpFullCalendarList';
$route ['EticketPackage_AddGrpSpcPriHLD']                       = 'ticket/package/Package_controller/FSnCPKGAddGrpSpcPriHLD';
$route ['EticketPackage_DelGrpSpcPriHLD']                       = 'ticket/package/Package_controller/FSnCPKGDelGrpSpcPriHLD';
$route ['EticketPackage_GetPkgFullCalendar']                    = 'ticket/package/Package_controller/FSoCPKGGetPkgFullCalendar';
$route ['EticketPackage_GetPkgFullCalendarList']                = 'ticket/package/Package_controller/FSoCPKGGetPkgFullCalendarList';
$route ['EticketPackage_AddPkgSpcPriHLD']                       = 'ticket/package/Package_controller/FSnCPKGAddPkgSpcPriHLD';
$route ['EticketPackage_DelPkgSpcPriHLD']                       = 'ticket/package/Package_controller/FSnCPKGDelPkgSpcPriHLD';
$route ['EticketPackage_CheckMaxPark']                          = 'ticket/package/Package_controller/FSxCPKGCheckMaxPark';
$route ['EticketPackage_CheckPkgZone']                          = 'ticket/package/Package_controller/FSxCPKGCheckPkgZone';

// ShowTime
$route ['EticketShowTime/(.*)']                                 = 'ticket/showtime/Showtime_controller/FSxCSHT/$1';
$route ['EticketAddShowTime/(.*)']                              = 'ticket/showtime/Showtime_controller/FSxCSHTAdd/$1';
$route ['EticketAddShowTimeAjax']                               = 'ticket/showtime/Showtime_controller/FSxCSHTAddAjax';
$route ['EticketShowTimeLocList']                               = 'ticket/showtime/Showtime_controller/FSxCSHTLocList';
$route ['EticketShowTimeAddLoc']                                = 'ticket/showtime/Showtime_controller/FSxCSHTAddLoc';
$route ['EticketDelShowTime']                                   = 'ticket/showtime/Showtime_controller/FSxCSHTDelShowTime';
$route ['EticketShowTimeLocCount']                              = 'ticket/showtime/Showtime_controller/FSxCSHTLocCount';
$route ['EticketShowTimeLocLoadList']                           = 'ticket/showtime/Showtime_controller/FSxCSHTLocLoadList';
// ShowTime Package
$route ['EticketShowTimePackageList/(.*)/(.*)']                 = 'ticket/showtime/Showtime_controller/FSxCSHTShowTimePackageList/$1/$2';
$route ['EticketShowTimeAddPackage/(.*)/(.*)']                  = 'ticket/showtime/Showtime_controller/FSxCSHTShowTimeAddPackage/$1/$2';
$route ['EticketShowTimeAddPackageAjax']                        = 'ticket/showtime/Showtime_controller/FSxCSHTShowTimeAddPackageAjax';
$route ['EticketShowTimeDelPackage']                            = 'ticket/showtime/Showtime_controller/FSxCSHTShowTimeDelPackage';


// Verification
$route ['EticketVerification']                                  = 'ticket/verification/Verification_controller/FSxCVFN';
$route ['EticketVerificationAjaxList']                          = 'ticket/verification/Verification_controller/FSxCVFNAjaxList';
$route ['EticketVerificationCount']                             = 'ticket/verification/Verification_controller/FSxCVFNCount';
$route ['EticketVerificationApprove']                           = 'ticket/verification/Verification_controller/FSxCVFNApprove';
$route ['EticketTicketCancellation_Count']                      = 'ticket/verification/Verification_controller/FSxCVFNCancellationCount';
$route ['EticketTicketCancellation']                            = 'ticket/verification/Verification_controller/FSxCVFNTicketCancellation';
$route ['EticketTicketCancellationAjax']                        = 'ticket/verification/Verification_controller/FSxCVFNTicketCancellationAjax';
$route ['EticketCancelTicket']                                  = 'ticket/verification/Verification_controller/FSxCVFNCancelTicket';


// Natt Set Route Time Table List 14/11/60 12:40 PM
$route ['EticketTimeTable/TimeTableList/(.*)/(.*)']             = 'ticket/timelist/Timelist_controller/FSxCTLTHD/$1/$2';
$route ['EticketTimeTable/TimeTablePickList']                   = 'ticket/timelist/Timelist_controller/FSxCTLTPickList';
$route ['EticketTimeTable/TimeDOWAddList']                      = 'ticket/timelist/Timelist_controller/FSxCTLTTimeDOWAddList';
$route ['EticketTimeTable/DelTimeDOW']                          = 'ticket/timelist/Timelist_controller/FSxCTLTDelTimeDOW';
$route ['EticketTimeTable/TimeHolidayAddList']                  = 'ticket/timelist/Timelist_controller/FSxCTLTTimeHolidayAddList';
$route ['EticketTimeTable/DelTimeHoliday']                      = 'ticket/timelist/Timelist_controller/FSxCTLTDelTimeHoliday';
$route ['EticketTimeTable/FullCalendarEvent']                   = 'ticket/timelist/Timelist_controller/FSxCTLTFullCalendarEvent';
$route ['EticketTimeTable/FullCalendarEventList']               = 'ticket/timelist/Timelist_controller/FSxCTLTFullCalendarEventList';
$route ['EticketTimeTable/TimeTableSTAjaxList']                 = 'ticket/timelist/Timelist_controller/FSxCTLTTimeTableSTAjaxList';
$route ['EticketTimeTable/TimeTableSTCount']                    = 'ticket/timelist/Timelist_controller/FStCTLTTimeTableSTCount';
$route ['EticketTimeTable/AddTimeTableST/(.*)/(.*)']            = 'ticket/timelist/Timelist_controller/FSxCTLTTimeTableSTAdd/$1/$2';
$route ['EticketTimeTable/AddTimeTableSTAjax']                  = 'ticket/timelist/Timelist_controller/FSxCTLTTimeTableSTAddAjax';
$route ['EticketTimeTable/EditTimeTableST/(.*)/(.*)/(.*)']      = 'ticket/timelist/Timelist_controller/FSxCTLTTimeTableSTEdit/$1/$2/$3';
$route ['EticketTimeTable/EditTimeTableSTAjax']                 = 'ticket/timelist/Timelist_controller/FSxCTLTTimeTableSTEditAjax';
$route ['EticketTimeTable/DeleteTimeTableST']                   = 'ticket/timelist/Timelist_controller/FSxCTLTTimeTableSTDel';
$route ['EticketTimeTable/TimeTableSTPickList']                 = 'ticket/timelist/Timelist_controller/FSxCTLTSTPickList';
// Time Table รอบการแสดง
$route ['EticketTimeTable']                             = 'ticket/timetable/Timetable_controller/FSxCTTB';
$route ['EticketTimeTable/TimeTableAjaxList']           = 'ticket/timetable/Timetable_controller/FSxCTTBAjaxList';
$route ['EticketTimeTable/TimeTableCount']              = 'ticket/timetable/Timetable_controller/FStCTTBCount';
$route ['EticketTimeTable/AddTimeTable']                = 'ticket/timetable/Timetable_controller/FSxCTTBAdd';
$route ['EticketTimeTable/AddTimeTableAjax']            = 'ticket/timetable/Timetable_controller/FSxCTTBAddAjax';
$route ['EticketTimeTable/EditTimeTable/(.*)']          = 'ticket/timetable/Timetable_controller/FSxCTTBEdit/$1';
$route ['EticketTimeTable/EditTimeTableAjax']           = 'ticket/timetable/Timetable_controller/FSxCTTBEditAjax';
$route ['EticketTimeTable/DeleteTimeTable']             = 'ticket/timetable/Timetable_controller/FSxCTTBDelete';
// รอบการแสดง
$route ['EticketTimeTableDT/(.*)']                      = 'ticket/timetable/Timetable_controller/FSxCTTBDt/$1';
$route ['EticketTimeTable/TimeTableDTAjaxList']         = 'ticket/timetable/Timetable_controller/FSxCTTBDtAjaxList';
$route ['EticketTimeTable/TimeTableDTCount']            = 'ticket/timetable/Timetable_controller/FStCTTBDtCount';
$route ['EticketTimeTable/AddTimeTableDT/(.*)']         = 'ticket/timetable/Timetable_controller/FSxCTTBDtAdd/$1';
$route ['EticketTimeTable/AddTimeTableDTAjax']          = 'ticket/timetable/Timetable_controller/FSxCTTBDtAddAjax';
$route ['EticketTimeTable/EditTimeTableDT/(.*)/(.*)']   = 'ticket/timetable/Timetable_controller/FSxCTTBDtEdit/$1/$2';
$route ['EticketTimeTable/EditTimeTableDTAjax']         = 'ticket/timetable/Timetable_controller/FSxCTTBDtEditAjax';
$route ['EticketTimeTable/DeleteTimeTableDT']           = 'ticket/timetable/Timetable_controller/FSxCTTBDtDelete';
// Event
$route ['EticketEvent']                                 = 'ticket/event/Event_controller/FSxCEVT';
$route ['EticketEventList']                             = 'ticket/event/Event_controller/FSxCEVTList';
$route ['EticketEventCount']                            = 'ticket/event/Event_controller/FSxCEVTCount';
$route ['EticketAddEvent']                              = 'ticket/event/Event_controller/FSxCEVTAdd';
$route ['EticketAddEventAjax']                          = 'ticket/event/Event_controller/FSxCEVTAddAjax';
$route ['EticketEditEvent/(.*)']                        = 'ticket/event/Event_controller/FSxCEVTEdit/$1';
$route ['EticketEditEventAjax']                         = 'ticket/event/Event_controller/FSxCEVTEditAjax';
$route ['EticketDelEvent']                              = 'ticket/event/Event_controller/FSxCEVTDel';
$route ['EticketEventApv']                              = 'ticket/event/Event_controller/FSxCEVTApv';
$route ['EticketEventDelImg']                           = 'ticket/event/Event_controller/FSxCEVTDelImg';

// Bank Info
$route ['EticketBankInfo']                              = 'ticket/bankinfo/Bankinfo_controller/FSxCBIFMaster';
$route ['EticketBankInfoAdd']                           = 'ticket/bankinfo/Bankinfo_controller/FSxCBIFAdd';
$route ['EticketBankInfoAddAjax']                       = 'ticket/bankinfo/Bankinfo_controller/FSxCBIFAddAjax';
$route ['EticketBankInfoEdit/(.*)']                     = 'ticket/bankinfo/Bankinfo_controller/FSxCBIFEdit/$1';
$route ['EticketBankInfoEditAjax']                      = 'ticket/bankinfo/Bankinfo_controller/FSxCBIFEditAjax';
$route ['EticketBankInfoDel']                           = 'ticket/bankinfo/Bankinfo_controller/FSxCBIFDel';
$route ['EticketBankInfoList']                          = 'ticket/bankinfo/Bankinfo_controller/FSxCBIFList';
$route ['EticketBankInfoCount']                         = 'ticket/bankinfo/Bankinfo_controller/FSxCBIFCount';
$route ['EticketBankInfoDelImg']                        = 'ticket/bankinfo/Bankinfo_controller/FSxCBIFDelImg';
$route ['EticketBankInfoDelCheckBox']                   = 'ticket/bankinfo/Bankinfo_controller/FSxCBIFDelCheckBox';

