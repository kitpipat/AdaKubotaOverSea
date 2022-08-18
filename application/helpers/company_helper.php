<?php
/**
 *
 * @param type $paParams
 * @return type
 */
function FCNaGetCompanyInfo($paParams = []){
    $ci = &get_instance();
    $ci->load->model('company/company/Company_model');

    $aCompParams = [
        'nLngID' => $paParams['nLngID'],
        'tBchCode' => $paParams['tBchCode'],
        'tAgnCode' => $_SESSION['tSesUsrAgnCode']
    ];

    // print_r($_SESSION);

    return $ci->Company_model->FSaMCMPGetCompanyInfo($aCompParams);
}

/**
 *
 * @param type $paParams
 * @return type
 */
function FCNaGetBranchInfo($paParams = []){
    $ci = &get_instance();
    $ci->load->model('company/branch/Branch_model');

     $aBchParams = [
        'nLngID' => $paParams['nLngID'],
        'tBchCode' => $paParams['tBchCode']
    ];

    return $ci->Branch_model->FSaMCMPGetBchInfo($aBchParams);
}


/**
 *
 * @param type $paParams
 * @return type
 */
function FCNtGetCompanyCode(){
    $ci = &get_instance();
    $ci->load->model('company/company/Company_model');
    $aCompany = $ci->Company_model->FSaMCMPGetCompanyCode();

    $tCompanyCode = "Company Code Not Found.";
    if($aCompany['rtCode'] == '1') {
        $tCompanyCode = $aCompany['raItems']['FTCmpCode'];
    }
    return $tCompanyCode;
}

/**
 *
 * @param type $paParams
 * @return type
 */
function FCNtGetCompanyBchCode(){
    $ci = &get_instance();
    $ci->load->model('company/company/Company_model');
    $aCompany = $ci->Company_model->FSaMCMPGetCompanyBchCode();

    $tCompanyCode = "Company Bch Code Not Found.";
    if($aCompany['rtCode'] == '1') {
        $tCompanyCode = $aCompany['raItems']['FTBchCode'];
    }
    return $tCompanyCode;
}
