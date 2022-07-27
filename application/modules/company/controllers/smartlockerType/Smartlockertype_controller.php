<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Smartlockertype_controller extends MX_Controller {
    
    public function __construct() {
        parent::__construct ();
        $this->load->model('company/smartlockertype/mSmartlockerType');
        $this->load->model('company/shopgpbypdt/Shopgpbypdt_model');
    }

    //Main page
    public function FSaCSHPCallLocTypeMainPage(){
        // $nPageShpCallBack       = $this->input->post('nPageShpCallBack');
        // $vBtnSaveGpShp          = FCNaHBtnSaveActiveHTML('shop/0/0');
        // $aAlwEventShopGpByShp   = FCNaHCheckAlwFunc('shop/0/0');
     
        // $this->load->view('company/smartlockersize/wSmartlockerSizeMain',array(
        //     'nPageShpCallBack'      => $nPageShpCallBack,
        //     'vBtnSaveGpShp'         => $vBtnSaveGpShp,
        //     'aAlwEventSMS'          => $aAlwEventShopGpByShp
        // ));
        
        $aData = array(
            'FTBchCode' => $this->input->post('tBchCode'),
            'FTShpCode' => $this->input->post('tShpCode'),
            'nLangEdit' => $this->session->userdata("tLangEdit")  
        );
        $aCheckDataLockerType  = $this->mSmartlockerType->FSnMSmartLockerTypeEventGetData($aData);
        //เช็คข้อมูล ในตาราง TRTMShopType
        if($aCheckDataLockerType['rtCode'] == 1){
            $aDataLockerType = $aCheckDataLockerType['raItems']['FTBchCode']; 
        }else{
            $aDataLockerType = "";
        }
        $this->load->view('company/shop/smartlockertype/wShopLocTypeList',array(
            'tBchCode'       => $aData['FTBchCode'],
            'tShpCode'       => $aData['FTShpCode'],
            'tCheckShopType' => $aDataLockerType
        ));
    }

    //DataTable
    function FSaCSHPCallLocTypeDataList(){
        $tShpCode       = $this->input->post('tShpCode');
        $tSesUserLevel  = $this->session->userdata("tSesUsrLevel"); 
        $tBchCode       = $this->input->post('tBchCode');
        $nPage          = $this->input->post('nPageCurrent');
        $tSearchAll     = '';
        if($tSesUserLevel == 'HQ'){ //เช้ามาแบบสำนักงานใหญ่
            $tBchCode = $this->input->post('tBchCode');
        }else{ //เข้ามาแบบสาขาหรือช็อป
            if (strpos($tBchCode, ',') !== false) {
                //มีหลายสาขา
                $tBchCode = $this->session->userdata("tSesUsrBchCode"); 
            }else{
                //มีสาขาเดียว
                $tBchCode = $this->input->post('tBchCode');
            }
        }

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll,
            'tShpCode'      => $tShpCode,
            'tBchCode'      => $tBchCode
        );
        $aResList           = $this->mSmartlockerType->FSaMSmartLockerTypeDataList($aData);
        $aGenTable          = array(
            'aDataList' 	    => $aResList,
            'nPage'     	    => $nPage
        );

        //Return Data View
        $this->load->view('company/shop/smartlockertype/wShopLocTypeDataTable',$aGenTable);

    }

    //Page Insert or Edit
    function FSaCSHPCallLocTypeAddEdit(){
        $tShpCode       = $this->input->post('tShpCode');
        $tSesUserLevel  = $this->session->userdata("tSesUsrLevel"); 
        $tBchCode       = $this->input->post('tBchCode');
        $tTypePage      = $this->input->post('tTypePage');

        //ส่วน Insert
        $aData  = array(
            'FTBchCode'     => $tBchCode,
            'FTShpCode'     => $tShpCode,
            'nLangEdit'     => $this->session->userdata("tLangEdit")
        );

        if($tTypePage == 'pageadd'){
            $aGetNameShop       = $this->mSmartlockerType->FSnMSmartLockerTypeGetNameShop($aData);
            if($aGetNameShop['rtCode'] == 1){
                $aDataLockerType = $aGetNameShop['raItems']['FTShpName']; 
            }else{
                $aDataLockerType = "";
            }
        }else if($tTypePage == 'pageedit'){
            $aCheckDataLockerType   = $this->mSmartlockerType->FSnMSmartLockerTypeEventGetData($aData);
            if($aCheckDataLockerType['rtCode'] == 1){
                $aDataLockerType = $aCheckDataLockerType['raItems']; 
            }else{
                $aDataLockerType = "";
            }
        }
       

        if($tSesUserLevel == 'HQ'){
            //Check ว่าร้านนี้มีกี่สาขา
            if (strpos($tBchCode, ',') !== false) {
                //มีหลายสาขาเดียว
                $tOptionBrowseBch = 1;
                $tNameBch         = '';
                $aNewBranch = explode(",",$tBchCode);
                $tWhereBranch = '';
                for($i=0; $i<count($aNewBranch); $i++){
                    $tWhereBranch .= "'".trim($aNewBranch[$i])."'".',';
                    if($i == count($aNewBranch) - 1){
                        $tWhereBranch = substr($tWhereBranch,0,-1);
                    }
                }
            }else{
                //มีสาขาเดียว
                $tOptionBrowseBch   = 0;
                $tWhereBranch       = '';
                $tNameBch           = $this->Shopgpbypdt_model->FSaMShopGpBySelectDataDT($aData,'branch');
            }
        }else{
            $tOptionBrowseBch   = 0;
            $tWhereBranch       = '';
            $tNameBch           = $this->Shopgpbypdt_model->FSaMShopGpBySelectDataDT($aData,'branch');
        }   

        $this->load->view('company/shop/smartlockertype/wShopLocTypeAddEdit',array(
            'tBchCode'        => $tBchCode,
            'tShpCode'        => $tShpCode,
            'tStatus'         => $tTypePage,
            'tNameBch'        => $tNameBch,
            'tWhereBranch'    => $tWhereBranch,
            'aDataLockerType' => $aDataLockerType
        ));
    }

    //Event Insert
    function FSaCSHPEventInsert(){
        $aData = array(
            'FTBchCode'     => $this->input->post('oetInputSmartLockerTypeBchCode'),
            'FTShpCode'     => $this->input->post('ohdSmartLockerTypeSHP'),
            'FTShtType'     => $this->input->post('oetShtType'),
            'FNLngID'		=> $this->session->userdata("tLangID"),	
            'FTShtName'		=> $this->input->post('oetShtName'),
            'FTShtRemark'   => $this->input->post('oetShtRemark')
        );  
        $aCheckBch        = $this->mSmartlockerType->FSnMSmartLockerCheckBch($aData);
        if(empty($aCheckBch)){
            $aReturnInsert    = $this->mSmartlockerType->FSnMSmartLockerTypeAddData($aData);
        }else{
            echo trim(1);
        }
    }

    //Event Edit
    function FSaCSHPEventEdit(){
        $aData = array(
            'FTBchCode'     => $this->input->post('ptBchCode'),
            'FTShpCode'     => $this->input->post('ptShpCode'),
            'FTShtType'     => $this->input->post('oetShtType'),
            'FNLngID'		=> $this->session->userdata("tLangID"),	
            'FTShtName'		=> $this->input->post('oetShtName'),
            'FTShtRemark'   => $this->input->post('oetShtRemark')
        );

        $aReturnUpdate    = $this->mSmartlockerType->FSnMSmartLockerTypeEditData($aData);
    }

    //Event Delete
    function FSaCSHPEventDelete(){
        $aData = array(
            'FTBchCode'     => $this->input->post('ptBchCode'),
            'FTShpCode'     => $this->input->post('ptShpCode'),
            'FTShtType'     => $this->input->post('ptType')
        );
        $tEventDelete       = $this->mSmartlockerType->FSnMSmartLockerTypeEventDelete($aData);
    }
    
}