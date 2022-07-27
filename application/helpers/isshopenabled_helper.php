<?php
/**
* Functionality : อ่านค่าว่าอนุญาตให้ระบบร้านค้าทำงานไหมจาก db มาเก็บใน userdata session
* Parameters    : -
* Creator       : 16/04/2020 surawat + 11/08/2020 Supawat 
* Last Modified : -
* Return        : -
* Return Type   : -
*/
function FCNbLoadConfigIsShpEnabled(){
    $ci = &get_instance();
    $ci->load->database();
    $tRoleCode = $ci->session->userdata('tSesUsrRoleCodeMulti');
    $tSQL = "SELECT * FROM TCNTUsrFuncRpt FUNC WHERE FUNC.FTRolCode IN ($tRoleCode) AND FUNC.FTUfrGrpRef IN ('054')";
    $oQuery = $ci->db->query($tSQL);
    if ($oQuery->num_rows() > 0) { 
        // Found Data
        $bBrowseShpConfigValue = true;
        $ci->session->set_userdata("bShpEnabled", $bBrowseShpConfigValue);
    } else { 
        // No Data
        $bBrowseShpConfigValue = false;
        $ci->session->set_userdata("bShpEnabled", $bBrowseShpConfigValue);
    }
    return $ci->session->userdata("bShpEnabled");

    // $aSysConfigResult = FCNaGetSysConfig([  'tSysCode' => 'bCN_BrowseShpEnabled',
    //                                         'tSysApp' => 'WEB',
    //                                         'tSysKey' => 'BrowseShpEnabled',
    //                                         'tSysSeq' => '1']);

    // $bBrowseShpConfigValue = true;
    // // print_r($aSysConfigResult);
    // if($aSysConfigResult['rtCode'] == 1){
    //     $aBrowseShpConfig = $aSysConfigResult['raItems'];
    //     $nSysStaDefValue = $aBrowseShpConfig['FTSysStaDefValue'];
    //     $nSysStaUsrValue = $aBrowseShpConfig['FTSysStaUsrValue'];
        
    //     if($nSysStaUsrValue != ''){
    //         $bBrowseShpConfigValue = $nSysStaUsrValue; //ถ้า Sys User มีค่าจะใช้ค่าของ UserValue
    //     }else{
    //         $bBrowseShpConfigValue = $nSysStaDefValue; //ถ้า Sys User ไม่มีค่าจะใช้ค่าของ DefValue
    //     }
    // }
    // $ci->session->set_userdata("bShpEnabled", $bBrowseShpConfigValue);
    // return $ci->session->userdata("bShpEnabled");
}

/**
* Functionality : อ่านค่าการอนุญาตให้ระบบร้านค้าทำงานที่เก็บไว้ใน userdata session
* Parameters    : -
* Creator       : 16/04/2020 surawat + 11/08/2020 Supawat 
* Last Modified : -
* Return        : ผลอนุญาตให้ระบบร้านค้าทำงาน
* Return Type   : boolean
*/
function FCNbGetIsShpEnabled(){
    $ci = &get_instance();
    return $ci->session->userdata("bShpEnabled");
}