<?php
    // Sale Person  (พนักงานขาย)
    $route ['saleperson/(:any)/(:any)']         = 'pos/saleperson/Saleperson_controller/index/$1/$2';
    $route ['salepersonList']                   = 'pos/saleperson/Saleperson_controller/FSvSPNListPage';
    $route ['salepersonDataTable']              = 'pos/saleperson/Saleperson_controller/FSvSPNDataList';
    $route ['salepersonPageAdd']                = 'pos/saleperson/Saleperson_controller/FSvSPNAddPage';
    $route ['salepersonPageEdit']               = 'pos/saleperson/Saleperson_controller/FSvSPNEditPage';
    $route ['salepersonEventAdd']               = 'pos/saleperson/Saleperson_controller/FSaSPNAddEvent';
    $route ['salepersonEventEdit']              = 'pos/saleperson/Saleperson_controller/FSaSPNEditEvent';
    $route ['salepersonDelete']                 = 'pos/saleperson/Saleperson_controller/FSoSPNDelete';
    // $route ['salepersonDeleteMulti']            = 'pos/saleperson/Saleperson_controller/FSoSPNDeleteMulti';

    // Slip Message (ข้อความหัวท้ายใบเสร็จ)
    $route ['slipMessage/(:any)/(:any)']        = 'pos/slipmessage/Slipmessage_controller/index/$1/$2';
    $route ['slipMessageList']                  = 'pos/slipmessage/Slipmessage_controller/FSvSMGListPage';
    $route ['slipMessageDataTable']             = 'pos/slipmessage/Slipmessage_controller/FSvSMGDataList';
    $route ['slipMessagePageAdd']               = 'pos/slipmessage/Slipmessage_controller/FSvSMGAddPage';
    $route ['slipMessageEventAdd']              = 'pos/slipmessage/Slipmessage_controller/FSaSMGAddEvent';
    $route ['slipMessagePageEdit']              = 'pos/slipmessage/Slipmessage_controller/FSvSMGEditPage';
    $route ['slipMessageEventEdit']             = 'pos/slipmessage/Slipmessage_controller/FSaSMGEditEvent';
    $route ['slipMessageDeleteMulti']           = 'pos/slipmessage/Slipmessage_controller/FSoSMGDeleteMulti';
    $route ['slipMessageDelete']                = 'pos/slipmessage/Slipmessage_controller/FSoSMGDelete';
    $route ['slipMessageUniqueValidate/(:any)'] = 'pos/slipmessage/Slipmessage_controller/FStSMGUniqueValidate/$1';

     // Set Printer  (g)
     $route ['setprinter/(:any)/(:any)']         = 'pos/setprinter/Setprinter_controller/index/$1/$2';
     $route ['setprinterList']                   = 'pos/setprinter/Setprinter_controller/FSvCSPRListPage';
     $route ['setprinterDataTable']              = 'pos/setprinter/Setprinter_controller/FSvCSPRDataList';
     $route ['setprinterPageAdd']                = 'pos/setprinter/Setprinter_controller/FSvCSPRAddPage';
     $route ['setprinterPageEdit']               = 'pos/setprinter/Setprinter_controller/FSvCSPREditPage';
     $route ['setprinterEventAdd']               = 'pos/setprinter/Setprinter_controller/FSaCSPRAddEvent';
     $route ['setprinterEventEdit']              = 'pos/setprinter/Setprinter_controller/FSaCSPREditEvent';
     $route ['setprinterDelete']                 = 'pos/setprinter/Setprinter_controller/FSoCSPRDelete';
     $route ['setprinterDeleteMulti']            = 'pos/setprinter/Setprinter_controller/FSoCSPRDeleteMulti';

    //Sale Machine (เครื่องจุดขาย)
    $route ['salemachine/(:any)/(:any)']        = 'pos/salemachine/Salemachine_controller/index/$1/$2';
    $route ['salemachineList']                  = 'pos/salemachine/Salemachine_controller/FSvCPOSListPage';
    $route ['salemachineDataTable']             = 'pos/salemachine/Salemachine_controller/FSvCPOSDataList';
    $route ['salemachinePageAdd']               = 'pos/salemachine/Salemachine_controller/FSvCPOSAddPage';
    $route ['salemachinePageEdit']              = 'pos/salemachine/Salemachine_controller/FSvCPOSEditPage';
    $route ['salemachineEventAdd']              = 'pos/salemachine/Salemachine_controller/FSoCPOSAddEvent';
    $route ['salemachineEventEdit']             = 'pos/salemachine/Salemachine_controller/FSoCPOSEditEvent';
    $route ['salemachineEventDelete']           = 'pos/salemachine/Salemachine_controller/FSoCPOSDeleteEvent';
    $route ['salemachineImportGetDataInTemp']       = 'pos/salemachine/Salemachine_controller/FStCImportGetDataInTmp';
    $route ['salemachineImportGetDataJsonInTemp']   = 'pos/salemachine/Salemachine_controller/FSoCImportGetDataJsonInTmp';
    $route ['salemachineImportDeleteInTempBySeq']   = 'pos/salemachine/Salemachine_controller/FSoCImportDeleteInTempBySeqNo';
    $route ['salemachineImportTempToMaster']        = 'pos/salemachine/Salemachine_controller/FSoCImportTempToMaster';
    $route ['salemachineImportClearInTemp']         = 'pos/salemachine/Salemachine_controller/FSoCImportClearInTemp';
    $route ['salemachineImportGetStaInTemp']        = 'pos/salemachine/Salemachine_controller/FSoCSALImportGetStaInTemp';

    // Sale Machine Address (ที่อยู่เครื่องจุดขาย)
    $route ['salemachineAddressData']           = 'pos/salemachine/Salemachineaddress_controller/FSvCPOSAddressData';
    $route ['salemachineAddressDataTable']      = 'pos/salemachine/Salemachineaddress_controller/FSvCPOSAddressDataTable';
    $route ['salemachineAddressPageAdd']        = 'pos/salemachine/Salemachineaddress_controller/FSvCPOSAddressCallPageAdd';
    $route ['salemachineAddressPageEdit']       = 'pos/salemachine/Salemachineaddress_controller/FSvCPOSAddressCallPageEdit';
    $route ['salemachineAddressAddEvent']       = 'pos/salemachine/Salemachineaddress_controller/FSoCPOSAddressAddEvent';
    $route ['salemachineAddressEditEvent']      = 'pos/salemachine/Salemachineaddress_controller/FSoCPOSAddressEditEvent';
    $route ['salemachineAddressDeleteEvent']    = 'pos/salemachine/Salemachineaddress_controller/FSoCPOSAddressDeleteEvent';

    //Sale MachineDevice (เครื่องจุดขายอุปกรณ์)
    $route ['salemachinedevice/(:any)/(:any)']  = 'pos/salemachinedevice/Salemachinedevice_controller/index/$1/$2';
    $route ['salemachinedeviceList']            = 'pos/salemachinedevice/Salemachinedevice_controller/FSvCPHWListPage';
    $route ['salemachinedeviceDataTable']       = 'pos/salemachinedevice/Salemachinedevice_controller/FSvCPHWDataList';
    $route ['salemachinedevicePageAdd']         = 'pos/salemachinedevice/Salemachinedevice_controller/FSvCPHWAddPage';
    $route ['salemachinedevicePageEdit']        = 'pos/salemachinedevice/Salemachinedevice_controller/FSvCPHWEditPage';
    $route ['salemachinedeviceEventAdd']        = 'pos/salemachinedevice/Salemachinedevice_controller/FSoCPHWAddEvent';
    $route ['salemachinedeviceEventEdit']       = 'pos/salemachinedevice/Salemachinedevice_controller/FSoCPHWEditEvent';
    $route ['salemachinedeviceEventDelete']     = 'pos/salemachinedevice/Salemachinedevice_controller/FSoCPHWDeleteEvent';
    $route ['salemachineCheckInputGenCode']     = 'pos/salemachinedevice/Salemachinedevice_controller/FSoCPHWCheckInputGenCode';

    // Ad Message (จัดการสื่อ/ข้อความ/หน้าจอลูกค้า)
    $route ['adMessage/(:any)/(:any)']                  = 'pos/admessage/Admessage_controller/index/$1/$2';
    $route ['adMessageList']                            = 'pos/admessage/Admessage_controller/FSvADVListPage';
    $route ['adMessageDataTable']                       = 'pos/admessage/Admessage_controller/FSvADVDataList';
    $route ['adMessagePageAdd']                         = 'pos/admessage/Admessage_controller/FSvADVAddPage';
    $route ['adMessageEventAdd']                        = 'pos/admessage/Admessage_controller/FSaADVAddEvent';
    $route ['adMessagePageEdit']                        = 'pos/admessage/Admessage_controller/FSvADVEditPage';
    $route ['adMessageEventEdit']                       = 'pos/admessage/Admessage_controller/FSaADVEditEvent';
    $route ['adMessageDeleteMulti']                     = 'pos/admessage/Admessage_controller/FSoADVDeleteMulti';
    $route ['adMessageDelete']                          = 'pos/admessage/Admessage_controller/FSoADVDelete';
    $route ['adMessageUniqueValidate/(:any)']           = 'pos/admessage/Admessage_controller/FStADVUniqueValidate/$1';
    $route ['adMessageUniqueFileNameValidate/(:any)']   = 'pos/admessage/Admessage_controller/FStADVUniqueFileNameValidate/$1';


    //TCNMPosAds (กำหนดโฆษณาเครื่องจุดขาย/ตู้ Vending)
    $route ['posAds/(:any)/(:any)']         = 'pos/posAds/Posads_controller/index/$1/$2';
    $route ['posAdsList']                   = 'pos/posAds/Posads_controller/FSvCADSListPage';
    $route ['posAdsDataTable']              = 'pos/posAds/Posads_controller/FSvCADSDataList';
    $route ['posAdsPageAdd']                = 'pos/posAds/Posads_controller/FSvCADSAddPage';
    $route ['posAdsPageEdit']               = 'pos/posAds/Posads_controller/FSvCADSEditPage';
    $route ['posAdsEventAdd']               = 'pos/posAds/Posads_controller/FSoCADSAddEvent';
    $route ['posAdsEventEdit']              = 'pos/posAds/Posads_controller/FSoCADSEditEvent';
    $route ['posAdsEventDelete']            = 'pos/posAds/Posads_controller/FSoCADSDeleteEvent';
    $route ['posAdsEventDeleteMultiple']    = 'pos/posAds/Posads_controller/FSoCADSDeleteMultipleEvent';
    $route ['posAdsViewMedia']              = 'pos/posAds/Posads_controller/FSoCADSViewMedia';
    $route ['posAdsViewPosition']           = 'pos/posAds/Posads_controller/FSoCADSViewPosition';


    //TVDMPosShop (กำหนดเครื่องจุดขาย)
    $route ['posshop/(:any)/(:any)']         = 'pos/posshop/Posshop_controller/index/$1/$2';
    $route ['posshopList']                   = 'pos/posshop/Posshop_controller/FSvCPSHListPage';
    $route ['posshoppageadd']                = 'pos/posshop/Posshop_controller/FSvCPSHCallPageAdd';
    $route ['posshopDataTable']              = 'pos/posshop/Posshop_controller/FSvCPSHDataList';
    $route ['posshopPageEdit']               = 'pos/posshop/Posshop_controller/FSvCPSHEditPage';
    $route ['posshopEventAdd']               = 'pos/posshop/Posshop_controller/FSoCPSHAddEvent';
    $route ['posshopEventDelete']            = 'pos/posshop/Posshop_controller/FSoCPSHDeleteEvent';
    $route ['posshopEventpageedit']          = 'pos/posshop/Posshop_controller/FSvCPSHCallPageEdit';
    $route ['posshopEventEdit']              = 'pos/posshop/Posshop_controller/FSoCPSHEditEvent';

    //Edit in line in page : shop
    $route ['posshopEditinLinePageShop']     = 'pos/posshop/Posshop_controller/FSvCPSHEditInLinePageShop';

    // EDC เครื่องอ่านบัตรเครดิต
    $route['posEdc/(:any)/(:any)']          = 'pos/posedc/Posedc_controller/index/$1/$2';
    $route['posEdcList']                    = 'pos/posedc/Posedc_controller/FSvCPosEdcListPage';
    $route['posEdcDataTable']               = 'pos/posedc/Posedc_controller/FSoCPosEdcDataTable';
    $route['posEdcPageAdd']                 = 'pos/posedc/Posedc_controller/FSoCPosEdcCallPageAdd';
    $route['posEdcPageEdit']                = 'pos/posedc/Posedc_controller/FSoCPosEdcCallPageEdit';
    $route['posEdcEventAdd']                = 'pos/posedc/Posedc_controller/FSoCPosEdcAddEvent';
    $route['posEdcEventEdit']               = 'pos/posedc/Posedc_controller/FSoCPosEdcEditEvent';
    $route['posEdcEventDelete']             = 'pos/posedc/Posedc_controller/FSoCPosEdcDeleteEvent';

    //ลงทะเบียนจุดขาย
    //Create By Witsarut 14/07/2020
    $route['posreg/(:any)/(:any)']         = 'pos/posregister/Posregister_controller/index/$1/$2';
    $route['posregList']                   = 'pos/posregister/Posregister_controller/FSvPRGPageList';
    $route['posregLoadTable']              = 'pos/posregister/Posregister_controller/FSvPRGGetTable';
    $route['posregSaveData']               = 'pos/posregister/Posregister_controller/FSvPRGSaveData';
    $route['posregCancelData']             = "pos/posregister/Posregister_controller/FSvPRGCancelData";




    //ช่องทองขาย
    //Create By Worakorn 28/12/2020
    $route['chanel/(:any)/(:any)']         = 'pos/chanel/Poschanel_controller/index/$1/$2';
    $route['chanelList']                   = 'pos/chanel/Poschanel_controller/FSvCCHNListPage';
    $route['chanelDataTable']              = 'pos/chanel/Poschanel_controller/FSvCCHNDataList';
    $route ['chanelPageAdd']               = 'pos/chanel/Poschanel_controller/FSvCHNAddPage';
    $route ['chanelEventAdd']              = 'pos/chanel/Poschanel_controller/FSaCHNAddEvent';
    $route ['chanelPageEdit']              = 'pos/chanel/Poschanel_controller/FSvCHNEditPage';
    $route ['chanelEventEdit']             = 'pos/chanel/Poschanel_controller/FSaCHNEditEvent';
    $route ['chanelDeleteMulti']           = 'pos/chanel/Poschanel_controller/FSoCHNDeleteMulti';
    $route ['chanelDelete']                = 'pos/chanel/Poschanel_controller/FSoCHNDelete';
    $route ['chanelUniqueValidate/(:any)'] = 'pos/chanel/Poschanel_controller/FStCHNUniqueValidate/$1';
