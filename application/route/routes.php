<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

// $route ['DataDic'] = 'cDataDic/index';
// // $route['default_controller'] = 'authen/cLogin';
// $route ['default_controller'] = 'common/cHome';

// //Browse
// $route ['BrowseData'] = 'common/Browser_controller/index';

// // GenCode
// $route ['generateCode']             = 'common/cCommon/FCNtCCMMGenCode';
// $route ['CheckInputGenCode']        = 'common/cCommon/FCNtCCMMCheckInputGenCode';
// $route ['GetPanalLangSystemHTML']   = 'common/cCommon/FCNtCCMMGetLangSystem';
// $route ['GetPanalLangListHTML']     = 'common/cCommon/FCNtCCMMChangeLangList';

// // language
// $route ['ChangeLang/(:any)/(:num)'] = 'cLanguage/index/$1/$2';
// $route ['ChangeLangEdit']           = 'cLanguage/FSxChangeLangEdit';
// $route ['ChangeBtnSaveAction']      = 'cLanguage/FSxChangeBtnSaveAction';

// //Image Temp.
// $route ['ImageCallMaster']  = 'common/Tempimg_controller/FSaCallMasterImage';
// $route ['ImageCallTemp']    = 'common/Tempimg_controller/FSaCallTempImage';
// $route ['ImageCallTempNEW']    = 'common/Tempimg_controller/FSaCallTempImageNEW';
// $route ['ImageDeleteFileNEW']  = 'common/Tempimg_controller/FSoImageDeleteNEW';
// $route ['ImageUplodeNEW']      = 'common/Tempimg_controller/FSaImageUplodeNEW';

// $route ['ImageUplode']      = 'common/Tempimg_controller/FSaImageUplode';
// $route ['ImageConvertCrop'] = 'common/Tempimg_controller/FSoConvertSizeCrop';
// $route ['ImageDeleteFile']  = 'common/Tempimg_controller/FSoImageDelete';


// // Authencation
// $route ['user']         = 'authen/cUser';
// $route ['login']        = 'authen/cLogin';
// $route ['logout']       = 'authen/cLogout';
// $route ['CheckSession'] = 'authen/cSession/FCNnCheckSession';
// $route ['checklogin']   = 'authen/cLogin/FSnCLOGChkLogin';

// // language
// $route ['ChangeLang/(:any)/(:num)'] = 'cLanguage/index/$1/$2';
// $route ['ChangeLangEdit'] = 'cLanguage/FSxChangeLangEdit';
// $route ['ChangeBtnSaveAction'] = 'cLanguage/FSxChangeBtnSaveAction';

// // Company
// $route ['company/(:any)/(:any)']        = 'pos5/company/cCompany/index/$1/$2';
// $route ['companyCheckUserLevel']        = 'pos5/company/cCompany/FSvCheckUserLevel';
// $route ['companyList']          		= 'pos5/company/cCompany/FSvCMPListPage';
// $route ['companyPageAdd']				= 'pos5/company/cCompany/FSvCMPAddPage';
// $route ['companyEventAdd']              = 'pos5/company/cCompany/FSoCMPAddEvent';
// $route ['companyEventEdit']				= 'pos5/company/cCompany/FSoCMPEditEvent';
// $route ['companyEventAddVat']           = 'pos5/company/cCompany/FSaCMPAddVat';
// $route ['companyEventCallAddress']      = 'pos5/company/cCompany/FSoCMPCallAddress';

// // User
// $route ['user/(:any)/(:any)']   = 'pos5/user/User_controller/index/$1/$2';
// $route ['userList']             = 'pos5/user/User_controller/FSvUSRListPage';
// $route ['userDataTable']        = 'pos5/user/User_controller/FSvUSRDataList';
// $route ['userPageAdd']          = 'pos5/user/User_controller/FSvUSRAddPage';
// $route ['userPageEdit']         = 'pos5/user/User_controller/FSvUSREditPage';
// $route ['userEventAdd']         = 'pos5/user/User_controller/FSoUSRAddEvent';
// $route ['userEventEdit']        = 'pos5/user/User_controller/FSoUSREditEvent';
// $route ['userEventDelete']      = 'pos5/user/User_controller/FSoUSRDeleteEvent';

// //Card
// $route ['card/(:any)/(:any)']    = 'pos5/card/Card_controller/index/$1/$2';
// $route ['cardList']              = 'pos5/card/Card_controller/FSvCCRDListPage';
// $route ['cardDataTable']         = 'pos5/card/Card_controller/FSvCCRDDataList';
// $route ['cardPageAdd']           = 'pos5/card/Card_controller/FSvCCRDAddPage';
// $route ['cardPageEdit']          = 'pos5/card/Card_controller/FSvCCRDEditPage';
// $route ['cardEventAdd']          = 'pos5/card/Card_controller/FSoCCRDAddEvent';
// $route ['cardEventEdit']         = 'pos5/card/Card_controller/FSoCCRDEditEvent';
// $route ['cardEventDelete']       = 'pos5/card/Card_controller/FSoCCRDDeleteEvent';
// $route ['checkStatusActive']     = "pos5/card/Card_controller/FSvCCRDChkStaAct";    // Add Check status Active

// // Card Shift
// $route ['cardShift/(:any)/(:any)'] = 'pos5/cardShift/cCardShift/index/$1/$2';
// $route ['cardShiftPanel'] = 'pos5/cardShift/cCardShift/FSvCardShiftPanelPage';
// $route ['cardShiftPanelEventInOut'] = 'pos5/cardShift/cCardShift/FSvCardShiftInOutEvent';
// $route ['cardShiftList'] = 'pos5/cardShift/cCardShift/FSvCardShiftListPage';
// $route ['cardShiftDataTable'] = 'pos5/cardShift/cCardShift/FSvCardShiftDataList';
// $route ['cardShiftPageAdd'] = 'pos5/cardShift/cCardShift/FSvCardShiftAddPage';
// $route ['cardShiftEventAdd'] = 'pos5/cardShift/cCardShift/FSaCardShiftAddEvent';
// $route ['cardShiftPageEdit'] = 'pos5/cardShift/cCardShift/FSvCardShiftEditPage';
// $route ['cardShiftEventEdit'] = 'pos5/cardShift/cCardShift/FSaCardShiftEditEvent';
// $route ['cardShiftDeleteMulti'] = 'pos5/cardShift/cCardShift/FSoCardShiftDeleteMulti';
// $route ['cardShiftDelete'] = 'pos5/cardShift/cCardShift/FSoCardShiftDelete';
// $route ['cardShiftUniqueValidate/(:any)'] = 'pos5/cardShift/cCardShift/FStCardShiftUniqueValidate/$1';

// //CardType (ประเภทบัตร)
// $route ['cardtype/(:any)/(:any)']       = 'pos5/cardtype/Cardtype_controller/index/$1/$2';
// $route ['cardtypeList']                 = 'pos5/cardtype/Cardtype_controller/FSvCCTYListPage';
// $route ['cardtypeDataTable']            = 'pos5/cardtype/Cardtype_controller/FSvCCTYDataList';
// $route ['cardtypePageAdd']              = 'pos5/cardtype/Cardtype_controller/FSvCCTYAddPage';
// $route ['cardtypePageEdit']             = 'pos5/cardtype/Cardtype_controller/FSvCCTYEditPage';
// $route ['cardtypeEventAdd']             = 'pos5/cardtype/Cardtype_controller/FSoCCTYAddEvent';
// $route ['cardtypeEventEdit']            = 'pos5/cardtype/Cardtype_controller/FSoCCTYEditEvent';
// $route ['cardtypeEventDelete']          = 'pos5/cardtype/Cardtype_controller/FSoCCTYDeleteEvent';

// //Card Import - Export (นำเข้า-ส่งออก ข้อมูลบัตร)
// $route ['cardmngdata/(:any)/(:any)']            = 'pos5/cardmngdata/Cardmngdata_controller/index/$1/$2';
// $route ['cardmngdataFromList']                  = 'pos5/cardmngdata/Cardmngdata_controller/FSvCCMDFromList';
// $route ['cardmngdataImpFileDataList']           = 'pos5/cardmngdata/Cardmngdata_controller/FSvCCMDImpFileDataList';
// $route ['cardmngdataExpFileDataList']           = 'pos5/cardmngdata/Cardmngdata_controller/FSvCCMDExpFileDataList';
// $route ['cardmngdataTopUpUpdateInlineOnTemp']   = 'pos5/cardmngdata/Cardmngdata_controller/FSxCTopUpUpdateInlineOnTemp';
// $route ['cardmngdataNewCardUpdateInlineOnTemp'] = 'pos5/cardmngdata/Cardmngdata_controller/FSxCNewCardUpdateInlineOnTemp';
// $route ['cardmngdataClearUpdateInlineOnTemp']   = 'pos5/cardmngdata/Cardmngdata_controller/FSxCClearUpdateInlineOnTemp';
// $route ['cardmngdataProcessImport']             = 'pos5/cardmngdata/Cardmngdata_controller/FSoCCMDProcessImport';
// $route ['cardmngdataProcessExport']             = 'pos5/cardmngdata/Cardmngdata_controller/FSoCCMDProcessExport';

// // Card Shift Out
// $route ['cardShiftOut/(:any)/(:any)']                   = 'pos5/cardShiftOut/Cardshiftout_controller/index/$1/$2';
// $route ['cardShiftOutList']                             = 'pos5/cardShiftOut/Cardshiftout_controller/FSvCardShiftOutListPage';
// $route ['cardShiftOutDataTable']                        = 'pos5/cardShiftOut/Cardshiftout_controller/FSvCardShiftOutDataList';
// $route ['cardShiftOutDataSourceTable']                  = 'pos5/cardShiftOut/Cardshiftout_controller/FSvCardShiftOutDataSourceList';
// $route ['cardShiftOutDataSourceTableByFile']            = 'pos5/cardShiftOut/Cardshiftout_controller/FSvCardShiftOutDataSourceListByFile';
// $route ['cardShiftOutPageAdd']                          = 'pos5/cardShiftOut/Cardshiftout_controller/FSvCardShiftOutAddPage';
// $route ['cardShiftOutEventAdd']                         = 'pos5/cardShiftOut/Cardshiftout_controller/FSaCardShiftOutAddEvent';
// $route ['cardShiftOutPageEdit']                         = 'pos5/cardShiftOut/Cardshiftout_controller/FSvCardShiftOutEditPage';
// $route ['cardShiftOutEventEdit']                        = 'pos5/cardShiftOut/Cardshiftout_controller/FSaCardShiftOutEditEvent';
// $route ['cardShiftOutEventUpdateApvDocAndCancelDoc']    = 'pos5/cardShiftOut/Cardshiftout_controller/FSaCardShiftOutUpdateApvDocAndCancelDocEvent';
// // $route ['cardShiftOutDeleteMulti']                   = 'pos5/cardShiftOut/Cardshiftout_controller/FSoCardShiftOutDeleteMulti';
// // $route ['cardShiftOutDelete']                        = 'pos5/cardShiftOut/Cardshiftout_controller/FSoCardShiftOutDelete';
// $route ['cardShiftOutUpdateInlineOnTemp']               = 'pos5/cardShiftOut/Cardshiftout_controller/FSxCardShiftOutUpdateInlineOnTemp';
// $route ['cardShiftOutInsertToTemp']                     = 'pos5/cardShiftOut/Cardshiftout_controller/FSxCardShiftOutInsertToTemp';
// $route ['cardShiftOutUniqueValidate/(:any)']            = 'pos5/cardShiftOut/Cardshiftout_controller/FStCardShiftOutUniqueValidate/$1';

// // Card Shift Return
// $route ['cardShiftReturn/(:any)/(:any)']                    = 'pos5/cardShiftReturn/Cardshiftreturn_controller/index/$1/$2';
// $route ['cardShiftReturnList']                              = 'pos5/cardShiftReturn/Cardshiftreturn_controller/FSvCardShiftReturnListPage';
// $route ['cardShiftReturnDataTable']                         = 'pos5/cardShiftReturn/Cardshiftreturn_controller/FSvCardShiftReturnDataList';
// $route ['cardShiftReturnDataSourceTable']                   = 'pos5/cardShiftReturn/Cardshiftreturn_controller/FSvCardShiftReturnDataSourceList';
// $route ['cardShiftReturnDataSourceTableByFile']             = 'pos5/cardShiftReturn/Cardshiftreturn_controller/FSvCardShiftReturnDataSourceListByFile';
// $route ['cardShiftReturnPageAdd']                           = 'pos5/cardShiftReturn/Cardshiftreturn_controller/FSvCardShiftReturnAddPage';
// $route ['cardShiftReturnEventAdd']                          = 'pos5/cardShiftReturn/Cardshiftreturn_controller/FSaCardShiftReturnAddEvent';
// $route ['cardShiftReturnPageEdit']                          = 'pos5/cardShiftReturn/Cardshiftreturn_controller/FSvCardShiftReturnEditPage';
// $route ['cardShiftReturnEventEdit']                         = 'pos5/cardShiftReturn/Cardshiftreturn_controller/FSaCardShiftReturnEditEvent';
// $route ['cardShiftReturnEventUpdateApvDocAndCancelDoc']     = 'pos5/cardShiftReturn/Cardshiftreturn_controller/FSaCardShiftReturnUpdateApvDocAndCancelDocEvent';
// $route ['cardShiftReturnGetCardOnHD']                       = 'pos5/cardShiftReturn/Cardshiftreturn_controller/FSaCardShiftReturnGetCardOnHD';
// $route ['cardShiftReturnUniqueValidate/(:any)']             = 'pos5/cardShiftReturn/Cardshiftreturn_controller/FStCardShiftReturnUniqueValidate/$1';
// $route ['cardShiftReturnUpdateInlineOnTemp']                = 'pos5/cardShiftReturn/Cardshiftreturn_controller/FSxCardShiftReturnUpdateInlineOnTemp';
// $route ['cardShiftReturnInsertToTemp']                      = 'pos5/cardShiftReturn/Cardshiftreturn_controller/FSxCardShiftReturnInsertToTemp';


// // Card Shift TopUp
// $route ['cardShiftTopUp/(:any)/(:any)']                 = 'pos5/cardShiftTopUp/Cardshifttopup_controller/index/$1/$2';
// $route ['cardShiftTopUpList']                           = 'pos5/cardShiftTopUp/Cardshifttopup_controller/FSvCardShiftTopUpListPage';
// $route ['cardShiftTopUpDataTable']                      = 'pos5/cardShiftTopUp/Cardshifttopup_controller/FSvCardShiftTopUpDataList';
// $route ['cardShiftTopUpDataSourceTable']                = 'pos5/cardShiftTopUp/Cardshifttopup_controller/FSvCardShiftTopUpDataSourceList';
// $route ['cardShiftTopUpDataSourceTableByFile']          = 'pos5/cardShiftTopUp/Cardshifttopup_controller/FSvCardShiftTopUpDataSourceListByFile';
// $route ['cardShiftTopUpPageAdd']                        = 'pos5/cardShiftTopUp/Cardshifttopup_controller/FSvCardShiftTopUpAddPage';
// $route ['cardShiftTopUpEventAdd']                       = 'pos5/cardShiftTopUp/Cardshifttopup_controller/FSaCardShiftTopUpAddEvent';
// $route ['cardShiftTopUpPageEdit']                       = 'pos5/cardShiftTopUp/Cardshifttopup_controller/FSvCardShiftTopUpEditPage';
// $route ['cardShiftTopUpEventEdit']                      = 'pos5/cardShiftTopUp/Cardshifttopup_controller/FSaCardShiftTopUpEditEvent';
// $route ['cardShiftTopUpEventUpdateApvDocAndCancelDoc']  = 'pos5/cardShiftTopUp/Cardshifttopup_controller/FSaCardShiftTopUpUpdateApvDocAndCancelDocEvent';
// $route ['cardShiftTopUpUniqueValidate/(:any)']          = 'pos5/cardShiftTopUp/Cardshifttopup_controller/FStCardShiftTopUpUniqueValidate/$1';
// $route ['cardShiftTopUpUpdateInlineOnTemp']             = 'pos5/cardShiftTopUp/Cardshifttopup_controller/FSxCardShiftTopUpUpdateInlineOnTemp';
// $route ['cardShiftTopUpInsertToTemp']                   = 'pos5/cardShiftTopUp/Cardshifttopup_controller/FSxCardShiftTopUpInsertToTemp';

// // Card Shift Refund
// $route ['cardShiftRefund/(:any)/(:any)'] = 'pos5/cardShiftRefund/Cardshiftrefund_controller/index/$1/$2';
// $route ['cardShiftRefundList'] = 'pos5/cardShiftRefund/Cardshiftrefund_controller/FSvCardShiftRefundListPage';
// $route ['cardShiftRefundDataTable'] = 'pos5/cardShiftRefund/Cardshiftrefund_controller/FSvCardShiftRefundDataList';
// $route ['cardShiftRefundDataSourceTable'] = 'pos5/cardShiftRefund/Cardshiftrefund_controller/FSvCardShiftRefundDataSourceList';
// $route ['cardShiftRefundDataSourceTableByFile'] = 'pos5/cardShiftRefund/Cardshiftrefund_controller/FSvCardShiftRefundDataSourceListByFile';
// $route ['cardShiftRefundPageAdd'] = 'pos5/cardShiftRefund/Cardshiftrefund_controller/FSvCardShiftRefundAddPage';
// $route ['cardShiftRefundEventAdd'] = 'pos5/cardShiftRefund/Cardshiftrefund_controller/FSaCardShiftRefundAddEvent';
// $route ['cardShiftRefundPageEdit'] = 'pos5/cardShiftRefund/Cardshiftrefund_controller/FSvCardShiftRefundEditPage';
// $route ['cardShiftRefundEventEdit'] = 'pos5/cardShiftRefund/Cardshiftrefund_controller/FSaCardShiftRefundEditEvent';
// $route ['cardShiftRefundEventUpdateApvDocAndCancelDoc'] = 'pos5/cardShiftRefund/Cardshiftrefund_controller/FSaCardShiftRefundUpdateApvDocAndCancelDocEvent';
// $route ['cardShiftRefundUpdateInlineOnTemp'] = 'pos5/cardShiftRefund/Cardshiftrefund_controller/FSxCardShiftRefundUpdateInlineOnTemp';
// $route ['cardShiftRefundInsertToTemp'] = 'pos5/cardShiftRefund/Cardshiftrefund_controller/FSxCardShiftRefundInsertToTemp';
// // $route ['cardShiftRefundDeleteMulti'] = 'pos5/cardShiftRefund/Cardshiftrefund_controller/FSoCardShiftRefundDeleteMulti';
// // $route ['cardShiftRefundDelete'] = 'pos5/cardShiftRefund/Cardshiftrefund_controller/FSoCardShiftRefundDelete';
// $route ['cardShiftRefundUniqueValidate/(:any)'] = 'pos5/cardShiftRefund/Cardshiftrefund_controller/FStCardShiftRefundUniqueValidate/$1';

// // Card Shift Status
// $route ['cardShiftStatus/(:any)/(:any)'] = 'pos5/cardShiftStatus/Cardshiftstatus_controller/index/$1/$2';
// $route ['cardShiftStatusList'] = 'pos5/cardShiftStatus/Cardshiftstatus_controller/FSvCardShiftStatusListPage';
// $route ['cardShiftStatusDataTable'] = 'pos5/cardShiftStatus/Cardshiftstatus_controller/FSvCardShiftStatusDataList';
// $route ['cardShiftStatusDataSourceTable'] = 'pos5/cardShiftStatus/Cardshiftstatus_controller/FSvCardShiftStatusDataSourceList';
// $route ['cardShiftStatusDataSourceTableByFile'] = 'pos5/cardShiftStatus/Cardshiftstatus_controller/FSvCardShiftStatusDataSourceListByFile';
// $route ['cardShiftStatusPageAdd'] = 'pos5/cardShiftStatus/Cardshiftstatus_controller/FSvCardShiftStatusAddPage';
// $route ['cardShiftStatusEventAdd'] = 'pos5/cardShiftStatus/Cardshiftstatus_controller/FSaCardShiftStatusAddEvent';
// $route ['cardShiftStatusPageEdit'] = 'pos5/cardShiftStatus/Cardshiftstatus_controller/FSvCardShiftStatusEditPage';
// $route ['cardShiftStatusEventEdit'] = 'pos5/cardShiftStatus/Cardshiftstatus_controller/FSaCardShiftStatusEditEvent';
// $route ['cardShiftStatusEventUpdateApvDocAndCancelDoc'] = 'pos5/cardShiftStatus/Cardshiftstatus_controller/FSaCardShiftStatusUpdateApvDocAndCancelDocEvent';
// $route ['cardShiftStatusUpdateInlineOnTemp'] = 'pos5/cardShiftStatus/Cardshiftstatus_controller/FSxCardShiftStatusUpdateInlineOnTemp';
// $route ['cardShiftStatusInsertToTemp'] = 'pos5/cardShiftStatus/Cardshiftstatus_controller/FSxCardShiftStatusInsertToTemp';
// $route ['cardShiftStatusUniqueValidate/(:any)'] = 'pos5/cardShiftStatus/Cardshiftstatus_controller/FStCardShiftStatusUniqueValidate/$1';

// // Card Shift Change
// $route ['cardShiftChange/(:any)/(:any)'] = 'pos5/cardShiftChange/Cardshiftchange_controller/index/$1/$2';
// $route ['cardShiftChangeList'] = 'pos5/cardShiftChange/Cardshiftchange_controller/FSvCardShiftChangeListPage';
// $route ['cardShiftChangeDataTable'] = 'pos5/cardShiftChange/Cardshiftchange_controller/FSvCardShiftChangeDataList';
// $route ['cardShiftChangeDataSourceTable'] = 'pos5/cardShiftChange/Cardshiftchange_controller/FSvCardShiftChangeDataSourceList';
// $route ['cardShiftChangeDataSourceTableByFile'] = 'pos5/cardShiftChange/Cardshiftchange_controller/FSvCardShiftChangeDataSourceListByFile';
// $route ['cardShiftChangePageAdd'] = 'pos5/cardShiftChange/Cardshiftchange_controller/FSvCardShiftChangeAddPage';
// $route ['cardShiftChangeEventAdd'] = 'pos5/cardShiftChange/Cardshiftchange_controller/FSaCardShiftChangeAddEvent';
// $route ['cardShiftChangePageEdit'] = 'pos5/cardShiftChange/Cardshiftchange_controller/FSvCardShiftChangeEditPage';
// $route ['cardShiftChangeEventEdit'] = 'pos5/cardShiftChange/Cardshiftchange_controller/FSaCardShiftChangeEditEvent';
// $route ['cardShiftChangeEventUpdateApvDocAndCancelDoc'] = 'pos5/cardShiftChange/Cardshiftchange_controller/FSaCardShiftChangeUpdateApvDocAndCancelDocEvent';
// $route ['cardShiftChangeUpdateInlineOnTemp'] = 'pos5/cardShiftChange/Cardshiftchange_controller/FSxCardShiftChangeUpdateInlineOnTemp';
// $route ['cardShiftChangeInsertToTemp'] = 'pos5/cardShiftChange/Cardshiftchange_controller/FSxCardShiftChangeInsertToTemp';
// $route ['cardShiftChangeUniqueValidate/(:any)'] = 'pos5/cardShiftChange/Cardshiftchange_controller/FStCardShiftChangeUniqueValidate/$1';
// $route ['cardShiftChangeCardUniqueValidate/(:any)'] = 'pos5/cardShiftChange/Cardshiftchange_controller/FStCardShiftChangeCardUniqueValidate/$1';

// // Vat Rate
// $route['VatRate'] = 'pos5/vatrate/cVateRate/FCNaCVATList';

// $route['vatrate/(:any)/(:any)'] =   'pos5/vatrate/Vatrate_controller/index/$1/$2';
// $route['vatrateList']           =   'pos5/vatrate/Vatrate_controller/FSvVATListPage';
// $route['vatrateDataTable']      =   'pos5/vatrate/Vatrate_controller/FSvVATDataList';
// $route['vatratePageAdd']        =   'pos5/vatrate/Vatrate_controller/FSvVATAddPage';
// $route['vatratePageEdit']       =   'pos5/vatrate/Vatrate_controller/FSvVATEditPage';
// $route['vatrateEventAdd']       =   'pos5/vatrate/Vatrate_controller/FSoVATAddEvent';
// $route['vatrateEventEdit']      =   'pos5/vatrate/Vatrate_controller/FSoVATEditEvent';
// $route['vatrateEventDelete']    =   'pos5/vatrate/Vatrate_controller/FSoVATDeleteEvent';
// $route['vatrateChkDup']         =   'pos5/vatrate/Vatrate_controller/FSoVATChackDup';

// $route['vatrateDeleteMulti']    =   'pos5/vatrate/Vatrate_controller/FSoVATDeleteMultiVat';
// $route['vatrateDelete']    =   'pos5/vatrate/Vatrate_controller/FSoVATDelete';
// $route['vatrateCreateOrUpdate'] =   'pos5/vatrate/Vatrate_controller/FSxVATCreateOrUpdate';
// $route['vatrateUniqueValidate/(:any)'] =   'pos5/vatrate/Vatrate_controller/FStVATUniqueValidate/$1';

// // Department
// $route ['department/(:any)/(:any)']    = 'pos5/department/Department_controller/index/$1/$2';
// $route ['departmentList']              = 'pos5/department/Department_controller/FSvCDPTListPage';
// $route ['departmentDataTable']         = 'pos5/department/Department_controller/FSvCDPTDataList';
// $route ['departmentPageAdd']           = 'pos5/department/Department_controller/FSvCDPTAddPage';
// $route ['departmentPageEdit']          = 'pos5/department/Department_controller/FSvCDPTEditPage';
// $route ['departmentEventAdd']          = 'pos5/department/Department_controller/FSoCDPTAddEvent';
// $route ['departmentEventEdit']         = 'pos5/department/Department_controller/FSoCDPTEditEvent';
// $route ['departmentEventDelete']       = 'pos5/department/Department_controller/FSoCDPTDeleteEvent';


// // Slip Message
// $route ['slipMessage/(:any)/(:any)'] = 'pos5/slipmessage/Slipmessage_controller/index/$1/$2';
// $route ['slipMessageList'] = 'pos5/slipmessage/Slipmessage_controller/FSvSMGListPage';
// $route ['slipMessageDataTable'] = 'pos5/slipmessage/Slipmessage_controller/FSvSMGDataList';
// $route ['slipMessagePageAdd'] = 'pos5/slipmessage/Slipmessage_controller/FSvSMGAddPage';
// $route ['slipMessageEventAdd'] = 'pos5/slipmessage/Slipmessage_controller/FSaSMGAddEvent';
// $route ['slipMessagePageEdit'] = 'pos5/slipmessage/Slipmessage_controller/FSvSMGEditPage';
// $route ['slipMessageEventEdit'] = 'pos5/slipmessage/Slipmessage_controller/FSaSMGEditEvent';
// $route ['slipMessageDeleteMulti'] = 'pos5/slipmessage/Slipmessage_controller/FSoSMGDeleteMulti';
// $route ['slipMessageDelete'] = 'pos5/slipmessage/Slipmessage_controller/FSoSMGDelete';
// $route ['slipMessageUniqueValidate/(:any)'] = 'pos5/slipmessage/Slipmessage_controller/FStSMGUniqueValidate/$1';

// // Reason
// $route ['reason/(:any)/(:any)']     = 'pos5/reason/Reason_controller/index/$1/$2';
// $route ['reasonList']               = 'pos5/reason/Reason_controller/FSvRSNListPage';
// $route ['reasonDataTable']          = 'pos5/reason/Reason_controller/FSvRSNDataList';
// $route ['reasonPageAdd']            = 'pos5/reason/Reason_controller/FSvRSNAddPage';
// $route ['reasonEventAdd']           = 'pos5/reason/Reason_controller/FSaRSNAddEvent';
// $route ['reasonPageEdit']           = 'pos5/reason/Reason_controller/FSvRSNEditPage';
// $route ['reasonEventEdit']          = 'pos5/reason/Reason_controller/FSaRSNEditEvent';
// $route ['reasonEventDelete']        = 'pos5/reason/Reason_controller/FSaRSNDeleteEvent';

// // Branch
// $route ['branch/(:any)/(:any)']     = 'pos5/branch/Branch_controller/index/$1/$2';
// $route ['branchList']               = 'pos5/branch/Branch_controller/FSvCBCHListPage';
// $route ['branchDataTable']          = 'pos5/branch/Branch_controller/FSvCBCHDataList';
// $route ['branchPageAdd']            = 'pos5/branch/Branch_controller/FSvCBCHAddPage';
// $route ['branchEventAdd']           = 'pos5/branch/Branch_controller/FSaCBCHAddEvent';
// $route ['branchPageEdit']           = 'pos5/branch/Branch_controller/FSvCBCHEditPage';
// $route ['branchEventEdit']          = 'pos5/branch/Branch_controller/FSaCBCHEditEvent';
// $route ['branchEventDelete']        = 'pos5/branch/Branch_controller/FSaCBCHDeleteEvent';
// $route ['branchCheckUserLevel']     = 'pos5/branch/Branch_controller/FSvCBCHCheckUserLevel';
// $route ['branchEventDeleteFolder']  = 'pos5/branch/Branch_controller/FSaCBCHDeleteEventFolder';
// $route ['branchBrowseWareHouse']    = 'pos5/branch/Branch_controller/FSoCBCHCallWareHouse';

// //Area (ภูมิภาค)
// $route ['area/(:any)/(:any)']    = 'pos5/area/Area_controller/index/$1/$2';
// $route ['areaList']              = 'pos5/area/Area_controller/FSvCAREListPage';
// $route ['areaDataTable']         = 'pos5/area/Area_controller/FSvCAREDataList';
// $route ['areaPageAdd']           = 'pos5/area/Area_controller/FSvCAREAddPage';
// $route ['areaPageEdit']          = 'pos5/area/Area_controller/FSvCAREEditPage';
// $route ['areaEventAdd']          = 'pos5/area/Area_controller/FSoCAREAddEvent';
// $route ['areaEventEdit']         = 'pos5/area/Area_controller/FSoCAREEditEvent';
// $route ['areaEventDelete']       = 'pos5/area/Area_controller/FSoCAREDeleteEvent';

// //Province
// $route ['province/(:any)/(:any)']   = 'pos5/province/Province_controller/index/$1/$2';
// $route ['provinceList']             = 'pos5/province/Province_controller/FSvPVNListPage';
// $route ['provinceDataTable']        = 'pos5/province/Province_controller/FSvPVNDataList';
// $route ['provincePageAdd']          = 'pos5/province/Province_controller/FSvPVNAddPage';
// $route ['provinceEventAdd']         = 'pos5/province/Province_controller/FSaPVNAddEvent';
// $route ['provincePageEdit']         = 'pos5/province/Province_controller/FSvPVNEditPage';
// $route ['provinceEventEdit']        = 'pos5/province/Province_controller/FSaPVNEditEvent';
// $route ['provinceEventDelete']      = 'pos5/province/Province_controller/FSaPVNDeleteEvent';

// //District
// $route ['district/(:any)/(:any)']       = 'pos5/district/District_controller/index/$1/$2';
// $route ['districtList']             	= 'pos5/district/District_controller/FSvDSTListPage';
// $route ['districtDataTable']            = 'pos5/district/District_controller/FSvDSTDataList';
// $route ['districtPageAdd']          	= 'pos5/district/District_controller/FSvDSTAddPage';
// $route ['districtEventAdd']         	= 'pos5/district/District_controller/FSaDSTAddEvent';
// $route ['districtPageEdit']         	= 'pos5/district/District_controller/FSvDSTEditPage';
// $route ['districtEventEdit']        	= 'pos5/district/District_controller/FSaDSTEditEvent';
// $route ['districtEventDelete']      	= 'pos5/district/District_controller/FSaDSTDeleteEvent';
// $route ['districtGetPostCode']      	= 'pos5/district/District_controller/FSnCDSTGetPostCode';
// $route ['districtBrowseProvince']   	= 'pos5/district/District_controller/FSoDSTCallProvince';
// $route ['BrowsedistrictWhereProvince']  = 'pos5/district/District_controller/FSoCPVNCallBrowseDistrictWhereProvince';

// // Sub District
// $route ['subdistrict/(:any)/(:any)']    = 'pos5/subdistrict/Subdistrict_controller/index/$1/$2';
// $route ['subdistrictList']              = 'pos5/subdistrict/Subdistrict_controller/FSvSDTListPage';
// $route ['subdistrictDataTable']         = 'pos5/subdistrict/Subdistrict_controller/FSvSDTDataList';
// $route ['subdistrictPageAdd']           = 'pos5/subdistrict/Subdistrict_controller/FSvSDTAddPage';
// $route ['subdistrictPageEdit']          = 'pos5/subdistrict/Subdistrict_controller/FSvSDTEditPage';
// $route ['subdistrictEventAdd']          = 'pos5/subdistrict/Subdistrict_controller/FSoSDTAddEvent';
// $route ['subdistrictEventEdit']         = 'pos5/subdistrict/Subdistrict_controller/FSoSDTEditEvent';
// $route ['subdistrictEventDelete']       = 'pos5/subdistrict/Subdistrict_controller/FSoSDTDeleteEvent';

// //Zone
// $route ['zone/(:any)/(:any)']   = 'pos5/zone/Zone_controller/index/$1/$2';
// $route ['zoneCheckUserLevel']   = 'pos5/zone/Zone_controller/FSvCZNECheckUserLevel';
// $route ['zoneList']             = 'pos5/zone/Zone_controller/FSvCZNEListPage';
// $route ['zoneDataTable']        = 'pos5/zone/Zone_controller/FSvCZNEDataList';
// $route ['zonePageAdd']          = 'pos5/zone/Zone_controller/FSvCZNEAddPage';
// $route ['zoneEventAdd']         = 'pos5/zone/Zone_controller/FSaCZNEAddEvent';
// $route ['zonePageEdit']         = 'pos5/zone/Zone_controller/FSvCZNEEditPage';
// $route ['zoneEventEdit']        = 'pos5/zone/Zone_controller/FSaCZNEEditEvent';
// $route ['zoneEventDelete']      = 'pos5/zone/Zone_controller/FSaCZNEDeleteEvent';

// //Rate
// $route ['rate/(:any)/(:any)']     = 'pos5/rate/Rate_controller/index/$1/$2';
// $route ['rateFormSearchList']     = 'pos5/rate/Rate_controller/FSxCRTEFormSearchList';
// $route ['ratePageAdd']            = 'pos5/rate/Rate_controller/FSxCRTEAddPage';
// $route ['rateDataTable']          = 'pos5/rate/Rate_controller/FSxCRTEDataTable';
// $route ['ratePageEdit']           = 'pos5/rate/Rate_controller/FSvCRTEEditPage';
// $route ['rateEventAdd']           = 'pos5/rate/Rate_controller/FSaCRTEAddEvent';
// $route ['rateEventEdit']          = 'pos5/rate/Rate_controller/FSaCRTEEditEvent';
// $route ['rateEventDelete']        = 'pos5/rate/Rate_controller/FSaCRTEDeleteEvent';

// //Sale Machine (เครื่องจุดขาย)
// $route ['salemachine/(:any)/(:any)'] = 'pos5/salemachine/Salemachine_controller/index/$1/$2';
// $route ['salemachineList']           = 'pos5/salemachine/Salemachine_controller/FSvCPOSListPage';
// $route ['salemachineDataTable']      = 'pos5/salemachine/Salemachine_controller/FSvCPOSDataList';
// $route ['salemachinePageAdd']        = 'pos5/salemachine/Salemachine_controller/FSvCPOSAddPage';
// $route ['salemachinePageEdit']       = 'pos5/salemachine/Salemachine_controller/FSvCPOSEditPage';
// $route ['salemachineEventAdd']       = 'pos5/salemachine/Salemachine_controller/FSoCPOSAddEvent';
// $route ['salemachineEventEdit']      = 'pos5/salemachine/Salemachine_controller/FSoCPOSEditEvent';
// $route ['salemachineEventDelete']    = 'pos5/salemachine/Salemachine_controller/FSoCPOSDeleteEvent';

// //Sale MachineDevice (เครื่องจุดขายอุปกรณ์)
// $route ['salemachinedevice/(:any)/(:any)']   = 'pos5/salemachinedevice/Salemachinedevice_controller/index/$1/$2';
// $route ['salemachinedeviceList']             = 'pos5/salemachinedevice/Salemachinedevice_controller/FSvCPHWListPage';
// $route ['salemachinedeviceDataTable']        = 'pos5/salemachinedevice/Salemachinedevice_controller/FSvCPHWDataList';
// $route ['salemachinedevicePageAdd']          = 'pos5/salemachinedevice/Salemachinedevice_controller/FSvCPHWAddPage';
// $route ['salemachinedevicePageEdit']         = 'pos5/salemachinedevice/Salemachinedevice_controller/FSvCPHWEditPage';
// $route ['salemachinedeviceEventAdd']         = 'pos5/salemachinedevice/Salemachinedevice_controller/FSoCPHWAddEvent';
// $route ['salemachinedeviceEventEdit']        = 'pos5/salemachinedevice/Salemachinedevice_controller/FSoCPHWEditEvent';
// $route ['salemachinedeviceEventDelete']      = 'pos5/salemachinedevice/Salemachinedevice_controller/FSoCPHWDeleteEvent';

// //Report
// $route['testreport']              = 'reportcard/Rptusecard1_controller/testreport';                  /**Report 1 */

// $route['RPTCRD/(:any)/(:any)']                      = 'reportcard/Report_controller/index/$1/$2';
// $route['RPTCRDExportExcelRptUseCard1']              = 'reportcard/Rptusecard1_controller/FSoCRPTCRDExportExcel';                  /**Report 1 */
// $route['RPTCRDExportExcelRptCheckStatusCard']       = 'reportcard/Rptcheckstatuscard_controller/FSoCRPTCRDExportExcel';           /**Report 2 */
// $route['RPTCRDExportExcelRptTransferCardInfo']      = 'reportcard/Rpttransfercardinfo_controller/FSoCRPTCRDExportExcel';          /**Report 3 */
// $route['RPTCRDExportExcelRptAdjustCashInCard']      = 'reportcard/Rptadjustcashincard_controller/FSoCRPTCRDExportExcel';          /**Report 4 */
// $route['RPTCRDExportExcelRptClearCardValueForReuse']= 'reportcard/Rptclearcardvalueforreuse_controller/FSoCRPTCRDExportExcel';    /**Report 5 */
// $route['RPTCRDExportExcelRptCardNoActive']          = 'reportcard/Rptcardnoactive_controller/FSoCRPTCRDExportExcel';              /**Report 6 */
// $route['RPTCRDExportExcelRptCardTimesUsed']         = 'reportcard/Rptcardtimesused_controller/FSoCRPTCRDExportExcel';             /**Report 7 */
// $route['RPTCRDExportExcelRptCardBalance']           = 'reportcard/Rptcardbalance_controller/FSoCRPTCRDExportExcel';               /**Report 8 */
// $route['RPTCRDExportExcelRptCollectExpireCard']     = 'reportcard/Rptcollectexpirecard_controller/FSoCRPTCRDExportExcel';         /**Report 9 */
// $route['RPTCRDExportExcelRptCardPrinciple']         = 'reportcard/Rptcardprinciple_controller/FSoCRPTCRDExportExcel';             /**Report 10 */
// $route['RPTCRDExportExcelRptCardDetail']            = 'reportcard/Rptcarddetail_controller/FSoCRPTCRDExportExcel';                /**Report 11 */
// $route['RPTCRDExportExcelRptCheckPrepaid']          = 'reportcard/Rptcheckprepaid_controller/FSoCRPTCRDExportExcel';              /**Report 12 */
// $route['RPTCRDExportExcelRptCheckCardUseInfo']      = 'reportcard/Rptcheckcarduseinfo_controller/FSoCRPTCRDExportExcel';          /**Report 13 */
// $route['RPTCRDExportExcelRptTopUp']                 = 'reportcard/Rpttopup_controller/FSoCRPTCRDExportExcel';                     /**Report 14 */
// $route['RPTCRDExportExcelRptUseCard2']              = 'reportcard/Rptusecard2_controller/FSoCRPTCRDExportExcel';                  /**Report 15 */

// /** Export PDF Report Card */
// $route['RPTCRDChkDataRptUseCard1']                  = 'reportcard/Rptusecard1_controller/FSoChkDataExportPDF';
// $route['RPTCRDExportPDFRptUseCard1']                = 'reportcard/Rptusecard1_controller/FSoCRPTCRDExportPDF';

// $route['RPTCRDChkDataRptCheckStatusCard']           = 'reportcard/Rptcheckstatuscard_controller/FSoChkDataExportPDF';
// $route['RPTCRDExportPDFRptCheckStatusCard']         = 'reportcard/Rptcheckstatuscard_controller/FSoCRPTCRDExportPDF';

// $route['RPTCRDChkDataRptTransferCardInfo']          = 'reportcard/Rpttransfercardinfo_controller/FSoChkDataExportPDF';
// $route['RPTCRDExportPDFRptTransferCardInfo']        = 'reportcard/Rpttransfercardinfo_controller/FSoCRPTCRDExportPDF';

// $route['RPTCRDChkDataRptAdjustCashInCard']          = 'reportcard/Rptadjustcashincard_controller/FSoChkDataExportPDF';
// $route['RPTCRDExportPDFRptAdjustCashInCard']        = 'reportcard/Rptadjustcashincard_controller/FSoCRPTCRDExportPDF';

// $route['RPTCRDChkDataRptClearCardValueForReuse']    = 'reportcard/Rptclearcardvalueforreuse_controller/FSoChkDataExportPDF';
// $route['RPTCRDExportPDFRptClearCardValueForReuse']  = 'reportcard/Rptclearcardvalueforreuse_controller/FSoCRPTCRDExportPDF';

// $route['RPTCRDChkDataRptCardNoActive']              = 'reportcard/Rptcardnoactive_controller/FSoChkDataExportPDF';
// $route['RPTCRDExportPDFRptCardNoActive']            = 'reportcard/Rptcardnoactive_controller/FSoCRPTCRDExportPDF';

// $route['RPTCRDChkDataRptCardTimesUsed']             = 'reportcard/Rptcardtimesused_controller/FSoChkDataExportPDF';
// $route['RPTCRDExportPDFRptCardTimesUsed']           = 'reportcard/Rptcardtimesused_controller/FSoCRPTCRDExportPDF';

// $route['RPTCRDChkDataRptCardBalance']               = 'reportcard/Rptcardbalance_controller/FSoChkDataExportPDF';
// $route['RPTCRDExportPDFRptCardBalance']             = 'reportcard/Rptcardbalance_controller/FSoCRPTCRDExportPDF';

// $route['RPTCRDChkDataRptCollectExpireCard']         = 'reportcard/Rptcollectexpirecard_controller/FSoChkDataExportPDF';
// $route['RPTCRDExportPDFRptCollectExpireCard']       = 'reportcard/Rptcollectexpirecard_controller/FSoCRPTCRDExportPDF';

// $route['RPTCRDChkDataRptCardPrinciple']             = 'reportcard/Rptcardprinciple_controller/FSoChkDataExportPDF';
// $route['RPTCRDExportPDFRptCardPrinciple']           = 'reportcard/Rptcardprinciple_controller/FSoCRPTCRDExportPDF';

// $route['RPTCRDChkDataRptCardDetail']                = 'reportcard/Rptcarddetail_controller/FSoChkDataExportPDF';
// $route['RPTCRDExportPDFRptCardDetail']              = 'reportcard/Rptcarddetail_controller/FSoCRPTCRDExportPDF';

// $route['RPTCRDChkDataRptCheckPrepaid']              = 'reportcard/Rptcheckprepaid_controller/FSoChkDataExportPDF';
// $route['RPTCRDExportPDFRptCheckPrepaid']            = 'reportcard/Rptcheckprepaid_controller/FSoCRPTCRDExportPDF';

// $route['RPTCRDChkDataRptCheckCardUseInfo']          = 'reportcard/Rptcheckcarduseinfo_controller/FSoChkDataExportPDF';
// $route['RPTCRDExportPDFRptCheckCardUseInfo']        = 'reportcard/Rptcheckcarduseinfo_controller/FSoCRPTCRDExportPDF';

// $route['RPTCRDChkDataRptTopUp']                     = 'reportcard/Rpttopup_controller/FSoChkDataExportPDF';
// $route['RPTCRDExportPDFRptTopUp']                   = 'reportcard/Rpttopup_controller/FSoCRPTCRDExportPDF';

// $route['RPTCRDChkDataRptUseCard2']                  = 'reportcard/Rptusecard2_controller/FSoChkDataExportPDF';
// $route['RPTCRDExportPDFRptUseCard2']                = 'reportcard/Rptusecard2_controller/FSoCRPTCRDExportPDF';


// //Warehouse
// $route ['warehouse/(:any)/(:any)']  = 'pos5/warehouse/Warehouse_controller/index/$1/$2';
// $route ['warehouseCheckUserLevel']  = 'pos5/warehouse/Warehouse_controller/FSvCWAHCheckUserLevel';
// $route ['warehouseList']            = 'pos5/warehouse/Warehouse_controller/FSvCWAHListPage';
// $route ['warehouseDataTable']       = 'pos5/warehouse/Warehouse_controller/FSvCWAHDataList';
// $route ['warehousePageAdd']         = 'pos5/warehouse/Warehouse_controller/FSvCWAHAddPage'; 
// $route ['warehouseEventAdd']        = 'pos5/warehouse/Warehouse_controller/FSaCWAHAddEvent';
// $route ['warehousePageEdit']        = 'pos5/warehouse/Warehouse_controller/FSvCWAHEditPage';
// $route ['warehouseEventEdit']       = 'pos5/warehouse/Warehouse_controller/FSaCWAHEditEvent';
// $route ['warehouseEventDelete']     = 'pos5/warehouse/Warehouse_controller/FSaCWAHDeleteEvent';
// $route ['xxx']                      = 'pos5/warehouse/Warehouse_controller/xxx';


// //Role
// $route['role/(:any)/(:any)']    = 'pos5/role/Role_controller/index/$1/$2';
// $route['roleList']              = 'pos5/role/Role_controller/FSvROLListPage';
// $route['roleDataTable']         = 'pos5/role/Role_controller/FSvROLDataList';
// $route['rolePageAdd']           = 'pos5/role/Role_controller/FSvROLAddPage';
// $route['rolePageEdit']          = 'pos5/role/Role_controller/FSvROLEditPage';
// $route['roleEventAdd']          = 'pos5/role/Role_controller/FSoROLAddEvent';
// $route['roleEventEdit']         = 'pos5/role/Role_controller/FSoROLEditEvent';
// $route['roleEventDelete']       = 'pos5/role/Role_controller/FSoROLDeleteEvent';

// // Shop
// $route ['shop/(:any)/(:any)']       = 'pos5/shop/Shop_controller/index/$1/$2';
// $route ['shopList']                 = 'pos5/shop/Shop_controller/FSvCSHPListPage';
// $route ['shopDataTable']            = 'pos5/shop/Shop_controller/FSvCSHPDataList';
// $route ['shopListFromBch']          = 'pos5/shop/Shop_controller/FSvCSHPListPageFromBch'; /*From Branch*/
// $route ['branchToShopDataTable']    = 'pos5/shop/Shop_controller/FSvCSHPBranchToShopDataList'; /*From Branch*/
// $route ['shopPageAdd']              = 'pos5/shop/Shop_controller/FSvCSHPAddPage';
// $route ['shopEventAdd']             = 'pos5/shop/Shop_controller/FSaCSHPAddEvent';
// $route ['shopPageEdit']             = 'pos5/shop/Shop_controller/FSvCSHPEditPage';
// $route ['shopEventEdit']            = 'pos5/shop/Shop_controller/FSaCSHPEditEvent';
// $route ['shopEventDelete']          = 'pos5/shop/Shop_controller/FSaCSHPDeleteEvent';
// $route ['shopGPEdit']               = 'pos5/shop/Shop_controller/FSvCSHPGPEditPage';


// // Card Shift New Card
// $route ['cardShiftNewCard/(:any)/(:any)']                   = 'pos5/cardShiftNewCard/Cardshiftnewcard_controller/index/$1/$2';
// $route ['cardShiftNewCardList']                             = 'pos5/cardShiftNewCard/Cardshiftnewcard_controller/FSvCardShiftNewCardListPage';
// $route ['cardShiftNewCardDataTable']                        = 'pos5/cardShiftNewCard/Cardshiftnewcard_controller/FSvCardShiftNewCardDataList';
// $route ['cardShiftNewCardDataSourceTable']                  = 'pos5/cardShiftNewCard/Cardshiftnewcard_controller/FSvCardShiftNewCardDataSourceList';
// $route ['cardShiftNewCardDataSourceTableByFile']            = 'pos5/cardShiftNewCard/Cardshiftnewcard_controller/FSvCardShiftNewCardDataSourceListByFile';
// $route ['cardShiftNewCardPageAdd']                          = 'pos5/cardShiftNewCard/Cardshiftnewcard_controller/FSvCardShiftNewCardAddPage';
// $route ['cardShiftNewCardEventAdd']                         = 'pos5/cardShiftNewCard/Cardshiftnewcard_controller/FSaCardShiftNewCardAddEvent';
// $route ['cardShiftNewCardPageEdit']                         = 'pos5/cardShiftNewCard/Cardshiftnewcard_controller/FSvCardShiftNewCardEditPage';
// $route ['cardShiftNewCardEventEdit']                        = 'pos5/cardShiftNewCard/Cardshiftnewcard_controller/FSaCardShiftNewCardEditEvent';
// $route ['cardShiftNewCardEventUpdateApvDocAndCancelDoc']    = 'pos5/cardShiftNewCard/Cardshiftnewcard_controller/FSaCardShiftNewCardUpdateApvDocAndCancelDocEvent';
// $route ['cardShiftNewCardUpdateInlineOnTemp'] = 'pos5/cardShiftNewCard/Cardshiftnewcard_controller/FSxCardShiftNewCardUpdateInlineOnTemp';
// $route ['cardShiftNewCardInsertToTemp'] = 'pos5/cardShiftNewCard/Cardshiftnewcard_controller/FSxCardShiftNewCardInsertToTemp';
// $route ['cardShiftNewCardUniqueValidate/(:any)']            = 'pos5/cardShiftNewCard/Cardshiftnewcard_controller/FStCardShiftNewCardUniqueValidate/$1';
// $route ['cardShiftNewCardChkCardCodeDup']                   = 'pos5/cardShiftNewCard/Cardshiftnewcard_controller/FSnCardShiftNewCardChkCardCodeDup';


// $route['MyProfile']             = 'pos5/Profile/cProfile/index';
// $route['MyProfilePageEdit']     = 'pos5/Profile/cProfile/FSvCMPFPageEdit';
// // $route['MyProfileEventEdit']    = 'pos5/Profile/cProfile/FSoCMPFEditEvent';
// $route['ChangePassword']        = 'pos5/Profile/cProfile/FSvCMPFChangePassword';



// /** Report Analysis (รายงานวิเคราะห์) */
// $route['RPTANS/(:any)/(:any)']  = 'reportanalysis/cReportAnalysis/index/$1/$2';
// // Process Excel
// $route['RPTANSExportExcelRptSaleShopByDate']    = 'reportanalysis/Rptsaleshopbydate_controller/FSoCExportExcel';
// $route['RPTANSExportExcelRptSaleShopByShop']    = 'reportanalysis/Rptsaleshopbyshop_controller/FSoCExportExcel';
// $route['RPTANSExportExcelRptCardActiveSummary'] = 'reportanalysis/cRptCardActiveSummary/FSoCExportExcel';
// $route['RPTANSExportExcelRptCardActiveDetail']  = 'reportanalysis/cRptCardActiveDetail/FSoCExportExcel';
// $route['RPTANSExportExcelRptUnExchangeBalance'] = 'reportanalysis/cRptUnExchangeBalance/FSoCExportExcel';

// // Process PDF
// $route['RPTANSChkDataRptSaleShopByDate']        = 'reportanalysis/Rptsaleshopbydate_controller/FSoCChkDataExportPDF';
// $route['RPTANSExportPDFRptSaleShopByDate']      = 'reportanalysis/Rptsaleshopbydate_controller/FSoCExportRptPDF';
// $route['RPTANSChkDataRptSaleShopByShop']        = 'reportanalysis/Rptsaleshopbyshop_controller/FSoCChkDataExportPDF';
// $route['RPTANSExportPDFRptSaleShopByShop']      = 'reportanalysis/Rptsaleshopbyshop_controller/FSoCExportRptPDF';
// $route['RPTANSChkDataRptCardActiveSummary']     = 'reportanalysis/cRptCardActiveSummary/FSoCChkDataExportPDF';
// $route['RPTANSExportPDFRptCardActiveSummary']   = 'reportanalysis/cRptCardActiveSummary/FSoCExportRptPDF';
// $route['RPTANSChkDataRptCardActiveDetail']      = 'reportanalysis/cRptCardActiveDetail/FSoCChkDataExportPDF';
// $route['RPTANSExportPDFRptCardActiveDetail']    = 'reportanalysis/cRptCardActiveDetail/FSoCExportRptPDF';
// $route['RPTANSChkDataRptUnExchangeBalance']     = 'reportanalysis/cRptUnExchangeBalance/FSoCChkDataExportPDF';
// $route['RPTANSExportPDFRptUnExchangeBalance']   = 'reportanalysis/cRptUnExchangeBalance/FSoCExportRptPDF';

// // Call Table Temp NewCard
// $route['CallTableTemp']                         = 'pos5/cardmngdata/Cardmngdata_controller/FSaSelectDataTableRight';
// $route['CallDeleteTemp']                        = 'pos5/cardmngdata/Cardmngdata_controller/FSaDeleteDataTableRight';
// $route['CallClearTempByTable']                  = 'pos5/cardmngdata/Cardmngdata_controller/FSaClearTempByTable';
// $route['CallUpdateDocNoinTempByTable']          = 'pos5/cardmngdata/Cardmngdata_controller/FSaUpdateDocnoinTempByTable';


