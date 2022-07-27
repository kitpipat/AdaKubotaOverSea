<?php 
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Creditnoterefpimodal_controller extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('company/company/Company_model');
        $this->load->model('company/branch/Branch_model');
        $this->load->model('company/shop/Shop_model');
        $this->load->model('payment/rate/Rate_model');
        $this->load->model('company/vatrate/Vatrate_model');
        $this->load->model('document/creditnote/Creditnoterefpimodal_model');
    }

    /**
     * Functionality : Function Call Data From PI HD
     * Parameters : Ajax and Function Parameter
     * Creator : 21/06/2019 Piya
     * LastUpdate: -
     * Return : Object View Data Table
     * Return Type : object
     */
    public function FSoCreditNoteRefPIHDList(){
        try{
            $aAdvanceSearch = $this->input->post('oAdvanceSearch');
            $nPage = $this->input->post('nPageCurrent');
            
            $aAlwEvent = FCNaHCheckAlwFunc('dcmPI/0/0');
            // Get Option Show Decimal
            $nOptDecimalShow = FCNxHGetOptionDecimalShow();
            // Page Current 
            if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
            // Lang ภาษา
            $nLangEdit          = $this->session->userdata("tLangEdit");
            
            // Data Conditon Get Data Document
            $aDataCondition  = array(
                'FNLngID'           => $nLangEdit,
                'nPage'             => $nPage,
                'nRow'              => 10,
                'aAdvanceSearch'    => $aAdvanceSearch,
                'tStaApv' => $this->input->post('ocmStaApv'),
                'tStaRef' => $this->input->post('ocmStaRef'),
                'tStaDocAct' => $this->input->post('ocmStaDocAct'),
                'tStaDoc' => $this->input->post('ocmStaDoc')
            );
            $aDataList = $this->Creditnoterefpimodal_model->FSaMCreditNoteGetPIHDList($aDataCondition);
            
            $aConfigView    = array(
                'nPage'             => $nPage,
                'nOptDecimalShow'   => $nOptDecimalShow,
                'aAlwEvent'         => $aAlwEvent,
                'aDataList'         => $aDataList,
            );
            $tPIViewDataTableList   = $this->load->view('document/creditnote/ref_pi/wCreditNotePIHDList', $aConfigView, true);
            
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
  
    /**
     * Functionality : Function Call Data From PI DT
     * Parameters : Ajax and Function Parameter
     * Creator : 21/06/2019 Piya
     * LastUpdate: -
     * Return : Object View Data Table
     * Return Type : object
     */
    public function FSoCreditNoteRefPIDTList(){
        try{
            $tDocNo = $this->input->post('tDocNo');
            $aAdvanceSearch = $this->input->post('oAdvanceSearch');
            $nPage = $this->input->post('nPageCurrent');
            $aAlwEvent = FCNaHCheckAlwFunc('dcmPI/0/0');
            // Get Option Show Decimal
            $nOptDecimalShow = FCNxHGetOptionDecimalShow();
            // Page Current 
            if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
            // Lang ภาษา
            $nLangEdit = $this->session->userdata("tLangEdit");
            
            // Data Conditon Get Data Document
            $aDataCondition  = array(
                'tDocNo'            => $tDocNo,
                'FNLngID'           => $nLangEdit,
                'nPage'             => $nPage,
                'nRow'              => 1000,
                'aAdvanceSearch'    => $aAdvanceSearch
            );
            $aDataList  = $this->Creditnoterefpimodal_model->FSaMCreditNoteGetPIDTList($aDataCondition);
            
            $aConfigView    = array(
                'nPage'             => $nPage,
                'nOptDecimalShow'   => $nOptDecimalShow,
                'aAlwEvent'         => $aAlwEvent,
                'aDataList'         => $aDataList,
            );
            $tPIViewDataTableList   = $this->load->view('document/creditnote/ref_pi/wCreditNotePIDTList', $aConfigView, true);
            
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
    
}





















































































































































































































































