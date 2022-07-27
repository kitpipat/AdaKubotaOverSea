<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Customerocp_controller extends MX_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('customer/customerocp/Customerocp_model');
    }

    /**
     * Functionality : Main page for Customer Type
     * Parameters : $nCstOcpBrowseType, $tCstOcpBrowseOption
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nCstOcpBrowseType,$tCstOcpBrowseOption){
        $aDataConfigView    = [
            'nCstOcpBrowseType'     => $nCstOcpBrowseType,
            'tCstOcpBrowseOption'   => $tCstOcpBrowseOption,
            'aAlwEvent'             => FCNaHCheckAlwFunc('customerType/0/0'),
            'vBtnSave'              => FCNaHBtnSaveActiveHTML('customerType/0/0'),
            'nOptDecimalShow'       => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'       => FCNxHGetOptionDecimalSave()
        ];
        $this->load->view ( 'customer/customerocp/wCustomerOcp',$aDataConfigView);
    }

    /**
     * Functionality : Function Call Customer Type Page List
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCstOcpListPage(){
        $aDataConfigView    = ['aAlwEvent' => FCNaHCheckAlwFunc('customerType/0/0')];
        $this->load->view('customer/customerocp/wCustomerOcpList',$aDataConfigView);
    }

    /**
     * Functionality : Function Call DataTables Customer Type
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCstOcpDataTable(){
        $nPage      = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
	    $aLangHave      = FCNaHGetAllLangByTable('TCNMCstOcp_L');
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

        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );

        $tAPIReq = "";
        $tMethodReq = "GET";
        $aResList = $this->Customerocp_model->FSaMCstOcpList($tAPIReq, $tMethodReq, $aData);
        $aGenTable = array(
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('customer/customerocp/wCustomerOcpDataTable', $aGenTable);
    }

    /**
     * Functionality : Function CallPage Customer Type Add
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCstOcpAddPage(){

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave = FCNaHGetAllLangByTable('TCNMCstOcp_L');
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

        $aData  = array(
            'FNLngID'   => $nLangEdit,
        );
        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aDataAdd = array(
            'aResult'   => array('rtCode'=>'99')
        );

        $this->load->view('customer/customerocp/wCustomerOcpAdd',$aDataAdd);
    }

    /**
     * Functionality : Function CallPage Customer Type Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCstOcpEditPage(){

        $tCstOcpCode       = $this->input->post('tCstOcpCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TCNMCstOcp_L');
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

        $aData  = array(
            'FTCstOcpCode' => $tCstOcpCode,
            'FNLngID'   => $nLangEdit
        );

        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aCstOcpData       = $this->Customerocp_model->FSaMCstOcpSearchByID($tAPIReq,$tMethodReq,$aData);
        $aDataEdit      = array('aResult' => $aCstOcpData);
        $this->load->view('customer/customerocp/wCustomerOcpAdd', $aDataEdit);
    }

    /**
     * Functionality : Event Add Customer Ocp
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCstOcpAddEvent(){
        try{
            date_default_timezone_set("Asia/Bangkok");
            $aDataMaster = array(
                'tIsAutoGenCode'  => $this->input->post('ocbCstOcpAutoGenCode'),
                'FTCstOcpCode'    => $this->input->post('oetCstOcpCode'),
                'FTCstOcpRmk'     => $this->input->post('otaCstOcpRemark'),
                'FTCstOcpName'    => $this->input->post('oetCstOcpName'),
                'FTLastUpdBy'     => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'     => date('Y-m-d H:i:s'),
                'FTCreateBy'      => $this->session->userdata('tSesUsername'),
                'FDCreateOn'      => date('Y-m-d H:i:s'),
                'FNLngID'         => $this->session->userdata("tLangEdit"),
            );

            if($aDataMaster['tIsAutoGenCode'] == '1'){ // Check Auto Gen Customer Ocp Code?
                // Auto Gen Customer Ocp Code
                $aGenCode = FCNaHGenCodeV5('TCNMCstOcp','0');
                if($aGenCode['rtCode'] == '1'){
                    $aDataMaster['FTCstOcpCode'] = $aGenCode['rtOcpCode'];
                }
            }

            $oCountDup  = $this->Customerocp_model->FSoMCstOcpCheckDuplicate($aDataMaster['FTCstOcpCode']);
            $nStaDup    = $oCountDup[0]->counts;

            if($nStaDup == 0){
                $this->db->trans_begin();
                $aStaCstOcpMaster  = $this->Customerocp_model->FSaMCstOcpAddUpdateMaster($aDataMaster);
                $aStaCstOcpLang    = $this->Customerocp_model->FSaMCstOcpAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTCstOcpCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => "Data Code Duplicate"
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    /**
     * Functionality : Event Edit Customer Type
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCstOcpEditEvent(){
        try{
            $aDataMaster = array(
                'FTCstOcpCode'  => $this->input->post('oetCstOcpCode'),
                'FTCstOcpRmk'   => $this->input->post('otaCstOcpRemark'),
                'FTCstOcpName'  => $this->input->post('oetCstOcpName'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
            );

            $this->db->trans_begin();
            $aStaCstOcpMaster  = $this->Customerocp_model->FSaMCstOcpAddUpdateMaster($aDataMaster);
            $aStaCstOcpLang    = $this->Customerocp_model->FSaMCstOcpAddUpdateLang($aDataMaster);

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTCstOcpCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }

    }

    /**
     * Functionality : Event Delete Customer Type
     * Parameters : Ajax and Function Parameter
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Status Delete Event
     * Return Type : String
     */
    public function FSaCstOcpDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTCstOcpCode' => $tIDCode
        );

        $aResDel = $this->Customerocp_model->FSnMCstOcpDel($aDataMaster);
        $aReturn = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    /**
     * Functionality : Vatrate unique check
     * Parameters : $tSelect "CstOcpcode"
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Check status true or false
     * Return Type : String
     */
    public function FStCstOcpUniqueValidate($tSelect = ''){

        if($this->input->is_ajax_request()){ // Request check
            if($tSelect == 'CstOcpCode'){

                $tCstOcpCode = $this->input->post('tCstOcpCode');
                $oCustomerType = $this->Customerocp_model->FSoMCstOcpCheckDuplicate($tCstOcpCode);

                $tStatus = 'false';
                if($oCustomerType[0]->counts > 0){ // If have record
                    $tStatus = 'true';
                }
                echo $tStatus;

                return;
            }
            echo 'Param not match.';
        }else{
            echo 'Method Not Allowed';
        }
    }

    //Functionality : Function Event Multi Delete
    //Parameters : Ajax Function Delete Customer Type
    //Creator : 14/06/2018 wasin
    //Last Modified : -
    //Return : Status Event Delete And Status Call Back Event
    //Return Type : object
    public function FSoCstOcpDeleteMulti(){
        $tCstOcpCode = $this->input->post('tCstOcpCode');

        $aCstOcpCode = json_decode($tCstOcpCode);
        foreach($aCstOcpCode as $oCstOcpCode){
            $aCstOcp = ['FTCstOcpCode' => $oCstOcpCode];
            $this->Customerocp_model->FSnMCstOcpDel($aCstOcp);
        }
        echo json_encode($aCstOcpCode);
    }

    /**
     * Functionality : Delete vat rate
     * Parameters : -
     * Creator : 20/09/2018 piya
     * Last Modified : -
     * Return : Vat code
     * Return Type : Object
     */
    public function FSoCstOcpDelete(){
        $tCstOcpCode = $this->input->post('tCstOcpCode');

        $aCstOcp = ['FTCstOcpCode' => $tCstOcpCode];
        $this->Customerocp_model->FSnMCstOcpDel($aCstOcp);
        echo json_encode($tCstOcpCode);
    }

}
