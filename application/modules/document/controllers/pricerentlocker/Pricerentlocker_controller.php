<?php 
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Pricerentlocker_controller extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('company/company/Company_model');
        $this->load->model('company/branch/Branch_model');
        $this->load->model('company/shop/Shop_model');
        $this->load->model('payment/rate/Rate_model');
        $this->load->model('company/vatrate/Vatrate_model');
        $this->load->model('document/pricerentlocker/Pricerentlocker_model');
    }

    public function index($nPriRntLkBrowseType,$tPriRntLkBrowseOption){
        $aDataConfigView    = array(
            'nPriRntLkBrowseType'   => $nPriRntLkBrowseType,
            'tPriRntLkBrowseOption' => $tPriRntLkBrowseOption,
            'aAlwEvent'             => FCNaHCheckAlwFunc('dcmPriRentLocker/0/0'),
            'vBtnSave'              => FCNaHBtnSaveActiveHTML('dcmPriRentLocker/0/0'),
            'nOptDecimalShow'       => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'       => FCNxHGetOptionDecimalSave()

        );
        $this->load->view('document/pricerentlocker/wPriceRentLocker',$aDataConfigView);
    }

    // Functionality : Function Call Page From Search List
    // Parameters : Ajax and Function Parameter
    // Creator : 05/07/2019 wasin (AKA: MR.JW)
    // LastUpdate: -
    // Return : String View
    // Return Type : View
    public function FSvCPriRntLkFormSearchList(){
        $this->load->view('document/pricerentlocker/wPriceRentLockerFormSearchList');
    }

    // Functionality : Function Call Page Data Table
    // Parameters : Ajax and Function Parameter
    // Creator : 05/07/2019 wasin (AKA: MR.JW)
    // LastUpdate: -
    // Return : Object View Data Table
    // Return Type : object
    public function FSoCPriRntLkDataTable(){
        try{
            $tSearchAll = $this->input->post('ptSearchAll');
            $nPage      = $this->input->post('pnPageCurrent');
            $aAlwEvent  = FCNaHCheckAlwFunc('dcmPriRentLocker/0/0');

            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

            // Page Current 
            if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('pnPageCurrent');}

            // Check Search
            if(!$tSearchAll){$tSearchAll='';}
            
            //Lang ภาษา
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TRTMPriRateHD_L');
            $nLangHave      = count($aLangHave);
            if($nLangHave > 1){
                if($nLangEdit != ''){
                    $nLangEdit = $nLangEdit;
                }else{
                    $nLangEdit = $nLangResort;
                }
            }else{
                if(@$aLangHave[0]->nLangList == ''){
                    $nLangEdit = '1';
                }else{
                    $nLangEdit = $aLangHave[0]->nLangList;
                }
            }

            // Data Conditon Get Data Document
            $aDataCondition  = array(
                'FNLngID'       => $nLangEdit,
                'nPage'         => $nPage,
                'nRow'          => 10,
                'tSearchAll'    => $tSearchAll
            );

            $aDataList  = $this->Pricerentlocker_model->FSaMPriRntLkGetDataTableList($aDataCondition);
            $aConfigView    = array(
                'nPage'             => $nPage,
                'nOptDecimalShow'   => $nOptDecimalShow,
                'aAlwEvent'         => $aAlwEvent,
                'aDataList'         => $aDataList,
            );
            $tPIViewDataTableList   = $this->load->view('document/pricerentlocker/wPriceRentLockerDataTable',$aConfigView,true);
            $aReturnData = array(
                'tPIViewDataTableList'  => $tPIViewDataTableList,
                'nStaEvent'             => '1',
                'tStaMessg'             => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Function Call Page Add
    // Parameters : Ajax and Function Parameter
    // Creator : 03/07/2019 wasin (AKA: MR.JW)
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCPriRntLkAddPage(){
        try{
            // Get Option Show Decimal  
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow(); 
            // Get Option Doc Save
            $nOptDocSave        = FCNnHGetOptionDocSave();

            // Lang Data
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave = FCNaHGetAllLangByTable('TRTMPriRateHD_L');
            $nLangHave = count($aLangHave);
            if($nLangHave > 1){
                if($nLangEdit != ''){
                    $nLangEdit = $nLangEdit;
                }else{
                    $nLangEdit = $nLangResort;
                }
            }else{
                if(@$aLangHave[0]->nLangList == ''){
                    $nLangEdit = '1';
                }else{
                    $nLangEdit = $aLangHave[0]->nLangList;
                }
            }

            $aDataConfigViewAdd = array(
                'nOptDecimalShow'   => $nOptDecimalShow,
                'nOptDocSave'       => $nOptDocSave,
                'aDataList'         => array('rtCode'=>'99'),
            );

            $tViewPageAdd   = $this->load->view('document/pricerentlocker/wPriceRentLockerAdd',$aDataConfigViewAdd,true);
            $aReturnData    = array(
                'tViewPageAdd'  => $tViewPageAdd,
                'nStaEvent'     => '1',
                'tStaMessg'     => "Success."
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Function Call Page Edit
    // Parameters : Ajax and Function Parameter
    // Creator : 10/07/2019 wasin (AKA: MR.JW)
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCPriRntLkEditPage(){
        try{
            $aPriRntLkRthCode   = $this->input->post('tRthCode');
            // Get Option Show Decimal  
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow(); 
            // Get Option Doc Save
            $nOptDocSave        = FCNnHGetOptionDocSave();

            // Lang Data
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave = FCNaHGetAllLangByTable('TRTMPriRateHD_L');
            $nLangHave = count($aLangHave);
            if($nLangHave > 1){
                if($nLangEdit != ''){
                    $nLangEdit = $nLangEdit;
                }else{
                    $nLangEdit = $nLangResort;
                }
            }else{
                if(@$aLangHave[0]->nLangList == ''){
                    $nLangEdit = '1';
                }else{
                    $nLangEdit = $aLangHave[0]->nLangList;
                }
            }
            $aDataWhere     = array(
                'FTRthCode' => $aPriRntLkRthCode,
                'FNLngID'   => $nLangEdit
            );
            $aGetDataEdit   = $this->Pricerentlocker_model->FSaMPriRntLkGetDataByID($aDataWhere);

            $aDataConfigViewAdd = array(
                'nOptDecimalShow'   => $nOptDecimalShow,
                'nOptDocSave'       => $nOptDocSave,
                'aDataList'         => $aGetDataEdit,
            );
            $tViewPageAdd   = $this->load->view('document/pricerentlocker/wPriceRentLockerAdd',$aDataConfigViewAdd,true);
            $aReturnData    = array(
                'tViewPageAdd'  => $tViewPageAdd,
                'nStaEvent'     => '1',
                'tStaMessg'     => "Success."
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Price Rent Locker Get Data DT
    // Parameters : Ajax and Function Parameter
    // Creator : 08/07/2019 wasin (AKA: MR.JW)
    // Return : Object View Page Table Data DT
    // Return Type : object
    public function FSoCPriRntLkLoadDataDT(){
        try{
            $tPriRntLkRthCode   = $this->input->post('ptPriRntLkRthCode');
            $nPageCurrent       = $this->input->post('pnPageCurrent');

            //Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

            $aDataWhere         = array(
                'FTRthCode'     => $tPriRntLkRthCode,
                'nPage'         => $nPageCurrent,
                'nRow'          => 20,
            );

            $aPriRntLkDataDT    = $this->Pricerentlocker_model->FSaMPriRntLkGetDataDT($aDataWhere);
            $aDataView          = array(
                'nOptDecimalShow'   => $nOptDecimalShow,
                'nPage'             => $nPageCurrent,
                'aPriRntLkDataDT'   => $aPriRntLkDataDT,
            );
            $tPriRntLkViewTableDT   = $this->load->view('document/pricerentlocker/wPriceRentLockerTableDataDT',$aDataView,true);
            $aReturnData    = array(
                'tPriRntLkViewTableDT'  => $tPriRntLkViewTableDT,
                'nStaEvent'             => '1',
                'tStaMessg'             => "Fucntion Success Return View."
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Price Rent Locker Event Add
    // Parameters : Ajax and Function Parameter
    // Creator : 10/07/2019 wasin (AKA: MR.JW)
    // Return : Object View Page Table Data DT
    // Return Type : object
    public function FSoCPriRntLkEventAdd(){
        try{
            $aPriRntLkDataHD    = $this->input->post('aPriRntLkDataHD');
            $aPriRntLkDataDT    = $this->input->post('aPriRntLkDataDT');

            $aDataWhere     = array(
                'FTRthCode'     => $aPriRntLkDataHD['oetPriRntLkRthCode'],
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
            );

            $aDataMasterHD  = array(
                'FTRthCalType'  => $aPriRntLkDataHD['ocmPriRntLkRthCalType'],
                'FTRthName'     => $aPriRntLkDataHD['oetPriRntLkRthName'],
            );
        
            $this->db->trans_begin();

            if(isset($aPriRntLkDataHD['ocbPriRntLkAutoGenCode']) && $aPriRntLkDataHD['ocbPriRntLkAutoGenCode'] == 1){
                $aPIGenCode = FCNaHGenCodeV5('TRTMPriRateHD',0);
                if($aPIGenCode['rtCode'] == '1'){
                    $aDataWhere['FTRthCode']    = $aPIGenCode['rtRthCode'];
                }
            }else{
                $aDataWhere['FTRthCode']    = $aPriRntLkDataHD['oetPriRntLkRthCode'];
            }

            $this->Pricerentlocker_model->FSxMPriRntLkAddUpdateHD($aDataWhere,$aDataMasterHD);
            $this->Pricerentlocker_model->FSxMPriRntLkAddUpdateHDLang($aDataWhere,$aDataMasterHD);
            
            // Delete DT
            $this->Pricerentlocker_model->FSxMPriRntLkDeleteDataDT($aDataWhere,$aPriRntLkDataDT);
            if(isset($aPriRntLkDataDT) && !empty($aPriRntLkDataDT)){
                $this->Pricerentlocker_model->FSxMPriRntLkAddUpdateDT($aDataWhere,$aPriRntLkDataDT);
            }

            // Check Status Transection DB
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData    = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Error Unsucess Add Price Rent Locker."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData    = array(
                    'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'   => $aDataWhere['FTRthCode'],
                    'nStaEvent'     => '1',
                    'tStaMessg'		=> 'Success Add Price Rent Locker.'
                );
            }
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Price Rent Locker Event Edit
    // Parameters : Ajax and Function Parameter
    // Creator : 10/07/2019 wasin (AKA: MR.JW)
    // Return : Object View Page Table Data DT
    // Return Type : object
    public function FSoCPriRntLkEventEdit(){
        try{
            $aPriRntLkDataHD    = $this->input->post('aPriRntLkDataHD');
            $aPriRntLkDataDT    = $this->input->post('aPriRntLkDataDT');

            $aDataWhere     = array(
                'FTRthCode'     => $aPriRntLkDataHD['oetPriRntLkRthCode'],
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
            );

            $aDataMasterHD  = array(
                'FTRthCalType'  => $aPriRntLkDataHD['ocmPriRntLkRthCalType'],
                'FTRthName'     => $aPriRntLkDataHD['oetPriRntLkRthName'],
            );
        
            $this->db->trans_begin();

            if(isset($aPriRntLkDataHD['ocbPriRntLkAutoGenCode']) && $aPriRntLkDataHD['ocbPriRntLkAutoGenCode'] == 1){
                $aPIGenCode = FCNaHGenCodeV5('TRTMPriRateHD',0);
                if($aPIGenCode['rtCode'] == '1'){
                    $aDataWhere['FTRthCode']    = $aPIGenCode['rtRthCode'];
                }
            }else{
                $aDataWhere['FTRthCode']    = $aPriRntLkDataHD['oetPriRntLkRthCode'];
            }

            $this->Pricerentlocker_model->FSxMPriRntLkAddUpdateHD($aDataWhere,$aDataMasterHD);
            $this->Pricerentlocker_model->FSxMPriRntLkAddUpdateHDLang($aDataWhere,$aDataMasterHD);

            // Delete DT
            $this->Pricerentlocker_model->FSxMPriRntLkDeleteDataDT($aDataWhere,$aPriRntLkDataDT);
            if(isset($aPriRntLkDataDT) && !empty($aPriRntLkDataDT)){
                $this->Pricerentlocker_model->FSxMPriRntLkAddUpdateDT($aDataWhere,$aPriRntLkDataDT);
            }

            // Check Status Transection DB
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData    = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Error Unsucess Add Price Rent Locker."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData    = array(
                    'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'   => $aDataWhere['FTRthCode'],
                    'nStaEvent'     => '1',
                    'tStaMessg'		=> 'Success Add Price Rent Locker.'
                );
            }
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Delete Price Rent Locker Delete Event Single
    // Parameters : Ajax and Function Parameter
    // Creator : 11/07/2019 wasin (AKA: MR.JW)
    // Return : Object View Page Table Data DT
    // Return Type : object
    public function FSoCPriRntLkEventDelSingle(){
        try{
            $tPriRntLkRthCode   = $this->input->post('pnDocNo');

            $aDataWhere = array(
                'FTRthCode'    => $tPriRntLkRthCode,
            );
            $this->db->trans_begin();

            $this->Pricerentlocker_model->FSaMPriRntLkDeleteData($aDataWhere);

            // Check Status Transection Delete
            if($this->db->trans_status()  === FALSE){
                $this->db->trans_rollback();
                $aReturnData    = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Error Unsucess Delete Price Rent Locker."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData    = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success Delete Price Rent Locker.'
                );
            }
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Delete Price Rent Locker Delete Event Multiple
    // Parameters : Ajax and Function Parameter
    // Creator : 11/07/2019 wasin (AKA: MR.JW)
    // Return : Object View Page Table Data DT
    // Return Type : object
    public function FSoCPriRntLkEventDelMultiple(){
        try{
            $this->db->trans_begin();
            
            $aPriRntLkRthCode   = $this->input->post('paDocNo');
            $nCountSeqData      = count($aPriRntLkRthCode);

            if($nCountSeqData > 1){
                foreach($aPriRntLkRthCode AS $nKey => $tPriRntLkRthCode){
                    $aDataWhere = array(
                        'FTRthCode'    => $tPriRntLkRthCode,
                    );
                    $this->Pricerentlocker_model->FSaMPriRntLkDeleteData($aDataWhere);
                }
            }

            // Check Status Transection Delete
            if($this->db->trans_status()  === FALSE){
                $this->db->trans_rollback();
                $aReturnData    = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Error Unsucess Delete Price Rent Locker."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData    = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success Delete Price Rent Locker.'
                );
            }
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }


    
}