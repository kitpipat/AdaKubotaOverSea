<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cSlipMessage extends MX_Controller {
    
    public function __construct(){
        parent::__construct ();
        $this->load->model('pos/slipmessage/mSlipMessage');
        date_default_timezone_set("Asia/Bangkok");
    }
    
    /**
     * Functionality : Main page for slip message
     * Parameters : $nSmgBrowseType, $tSmgBrowseOption
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nSmgBrowseType, $tSmgBrowseOption){
        $nMsgResp = array('title'=>"Province");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ('common/wHeader', $nMsgResp);
            $this->load->view ('common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ('common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('slipMessage/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view ( 'pos/slipmessage/wSlipMessage', array (
            'nMsgResp'=>$nMsgResp,
            'vBtnSave' => $vBtnSave,
            'nSmgBrowseType'=>$nSmgBrowseType,
            'tSmgBrowseOption'=>$tSmgBrowseOption
        ));
    }
    
    /**
     * Functionality : Function Call District Page List
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvSMGListPage(){
        $this->load->view('pos/slipmessage/wSlipMessageList');
    }

    /**
     * Functionality : Function Call DataTables Slip Message
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvSMGDataList(){
        $nPage      = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
	    $aLangHave      = FCNaHGetAllLangByTable('TCNMSlipMsgHD_L');
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
        $aResList = $this->mSlipMessage->FSaMSMGList($tAPIReq, $tMethodReq, $aData);
        $aGenTable = array(
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('pos/slipmessage/wSlipMessageDataTable', $aGenTable);
    }

    /**
     * Functionality : Function CallPage Slip Message Add
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvSMGAddPage(){
        
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        // $aLangHave = FCNaHGetAllLangByTable('TCNMSlipMsgHD_L');
        // $nLangHave = count($aLangHave);
        // if($nLangHave > 1){
	    //     if($nLangEdit != ''){
	    //         $nLangEdit = $nLangEdit;
	    //     }else{
	    //         $nLangEdit = $nLangResort;
	    //     }
	    // }else{
	    //     if(@$aLangHave[0]->nLangList == ''){
	    //         $nLangEdit = '1';
	    //     }else{
	    //         $nLangEdit = $aLangHave[0]->nLangList;
	    //     }
        // }
        
        $aData  = array(
            'FNLngID'   => $nLangEdit,
        );
        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aDataAdd = array(
            'aResult'   => array('rtCode'=>'99')
        );
        
        $this->load->view('pos/slipmessage/wSlipMessageAdd',$aDataAdd);
    }
    
    /**
     * Functionality : Function CallPage Slip Message Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvSMGEditPage(){
        
        $tSmgCode       = $this->input->post('tSmgCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        // $aLangHave      = FCNaHGetAllLangByTable('TCNMSlipMsgHD_L');
        // $nLangHave      = count($aLangHave);
        
        // if($nLangHave > 1){
	    //     if($nLangEdit != ''){
	    //         $nLangEdit = $nLangEdit;
	    //     }else{
	    //         $nLangEdit = $nLangResort;
	    //     }
	    // }else{
	    //     if(@$aLangHave[0]->nLangList == ''){
	    //         $nLangEdit = '1';
	    //     }else{
	    //         $nLangEdit = $aLangHave[0]->nLangList;
	    //     }
        // }
        
        $aData  = array(
            'FTSmgCode' => $tSmgCode,
            'FNLngID'   => $nLangEdit
        );

        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aSmgData       = $this->mSlipMessage->FSaMSMGSearchByID($tAPIReq, $tMethodReq, $aData);
        $aDataEdit      = array('aResult' => $aSmgData);
        $this->load->view('pos/slipmessage/wSlipMessageAdd', $aDataEdit);
    }
    
    /**
     * Functionality : Event Add Slip Message
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaSMGAddEvent(){
        try{
            $tIsAutoGenCode = $this->input->post('ocbSlipmessageAutoGenCode');
            
            // Setup Reason Code
            $tSmgCode   = "";
            if(isset($tIsAutoGenCode) &&  $tIsAutoGenCode == 1){
                $aStoreParam = array(
                    "tTblName"   => 'TCNMSlipMsgHD_L',                           
                    "tDocType"   => 0,                                          
                    "tBchCode"   => "",                                 
                    "tShpCode"   => "",                               
                    "tPosCode"   => "",                     
                    "dDocDate"   => date("Y-m-d")       
                );
                $aAutogen   	   = FCNaHAUTGenDocNo($aStoreParam);
                $tSmgCode          = $aAutogen[0]["FTXxhDocNo"];
                
            }else{
                $tSmgCode = $this->input->post('oetSmgCode');
            }

            $aDataMaster = array(
                'FTSmgCode'             => $tSmgCode,
                'FTSmgTitle'            => $this->input->post('oetSmgTitle'),
                'FTHeadReceiptItems'    => $this->input->post('oetSmgSlipHead'), 
                'FTEndReceiptItems'     => $this->input->post('oetSmgSlipEnd'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FNLngID'               => $this->session->userdata("tLangEdit"),
            );

            // print_r($aDataMaster);
            // exit();


            $oCountDup  = $this->mSlipMessage->FSoMSMGCheckDuplicate($aDataMaster['FTSmgCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if($nStaDup == 0){
                $this->db->trans_begin();
                // Add or Update Slip
                $this->mSlipMessage->FSaMSMGAddUpdateHD($aDataMaster);

                if(!(count($aDataMaster['FTHeadReceiptItems']) <= 0)){
                    // Add or Update Head of receipt
                    $nIndex = 1;
                    foreach ($aDataMaster['FTHeadReceiptItems'] as $tHeadReceipt){
                        $aDataMaster['FTSmgType'] = '1'; // Type 1: head of receipt
                        $aDataMaster['FNSmgSeq'] = $nIndex; // Seq: 1,2,3,4,...
                        $aDataMaster['FTSmgName'] = $tHeadReceipt;
                        $this->mSlipMessage->FSaMSMGAddUpdateDT($aDataMaster);
                        $nIndex++;
                    }
                }
                
                if(!(count($aDataMaster['FTEndReceiptItems']) <= 0)){
                    // Add or Update End of receipt
                    $nIndex = 1;
                    foreach ($aDataMaster['FTEndReceiptItems'] as $tEndReceipt){
                        $aDataMaster['FTSmgType'] = '2'; // Type 1: head of receipt
                        $aDataMaster['FNSmgSeq'] = $nIndex; // Seq: 1,2,3,4,...
                        $aDataMaster['FTSmgName'] = $tEndReceipt;
                        $this->mSlipMessage->FSaMSMGAddUpdateDT($aDataMaster);
                        $nIndex++;
                    }
                }
                
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
                        'tCodeReturn'	=> $aDataMaster['FTSmgCode'],
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
     * Functionality : Event Edit Slip Message
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaSMGEditEvent(){
        try{
            $aDataMaster = array(
                'FTSmgCode'             => $this->input->post('oetSmgCode'),
                'FTSmgTitle'            => $this->input->post('oetSmgTitle'),
                'FTHeadReceiptItems'    => $this->input->post('oetSmgSlipHead'), 
                'FTEndReceiptItems'     => $this->input->post('oetSmgSlipEnd'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FNLngID'               => $this->session->userdata("tLangEdit"),
            );
            $this->db->trans_begin();
            // Add or Update Slip
            $this->mSlipMessage->FSaMSMGAddUpdateHD($aDataMaster);
            
            // Delete Detail
            $this->mSlipMessage->FSnMSMGDelDT($aDataMaster);
            
            if(!(count($aDataMaster['FTHeadReceiptItems']) <= 0)){
                // Add or Update Head of receipt
                $nIndex = 1;
                foreach ($aDataMaster['FTHeadReceiptItems'] as $tHeadReceipt){
                    $aDataMaster['FTSmgType'] = '1'; // Type 1: head of receipt
                    $aDataMaster['FNSmgSeq'] = $nIndex; // Seq: 1,2,3,4,...
                    $aDataMaster['FTSmgName'] = $tHeadReceipt;
                    $this->mSlipMessage->FSaMSMGAddUpdateDT($aDataMaster);
                    $nIndex++;
                }
            }
            // Add or Update End of receipt
            if(!(count($aDataMaster['FTEndReceiptItems']) <= 0)){
                // Add or Update Head of receipt
                $nIndex = 1;
                foreach ($aDataMaster['FTEndReceiptItems'] as $tEndReceipt){
                    $aDataMaster['FTSmgType'] = '2'; // Type 1: head of receipt
                    $aDataMaster['FNSmgSeq'] = $nIndex; // Seq: 1,2,3,4,...
                    $aDataMaster['FTSmgName'] = $tEndReceipt;
                    $this->mSlipMessage->FSaMSMGAddUpdateDT($aDataMaster);
                    $nIndex++;
                }
            }
            
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
                    'tCodeReturn'	=> $aDataMaster['FTSmgCode'],
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
     * Functionality : Event Delete Slip Message
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : Status Delete Event
     * Return Type : String
     */
    // public function FSaSMGDeleteEvent(){
    //     $tIDCode = $this->input->post('tIDCode');
    //     $aDataMaster = array(
    //         'FTSmgCode' => $tIDCode
    //     );

    //     $aResDel = $this->mSlipMessage->FSnMSMGDelHD($aDataMaster);
    //     $aReturn = array(
    //         'nStaEvent' => $aResDel['rtCode'],
    //         'tStaMessg' => $aResDel['rtDesc']
    //     );
    //     echo json_encode($aReturn);
    // }

    /**
     * Functionality : Vatrate unique check
     * Parameters : $tSelect "smgcode"
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : Check status true or false
     * Return Type : String
     */
    public function FStSMGUniqueValidate($tSelect = ''){
        
        if($this->input->is_ajax_request()){ // Request check
            if($tSelect == 'smgcode'){
                
                $tSmgCode = $this->input->post('tSmgCode');
                $oSlipMessage = $this->mSlipMessage->FSoMSMGCheckDuplicate($tSmgCode);
                
                $tStatus = 'false';
                if($oSlipMessage[0]->counts > 0){ // If have record
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
    
    /**
     * Functionality : Function Event Multi Delete
     * Parameters : Ajax Function Delete Slip Message
     * Creator : 07/09/2018 piya
     * Last Modified : -
     * Return : Status Event Delete And Status Call Back Event
     * Return Type : object
     */
    public function FSoSMGDeleteMulti(){
        $tSmgCode = $this->input->post('tIDCode');
      
        $aSmgCode = json_decode($tSmgCode);
        foreach($aSmgCode as $oSmgCode){
            $aSmg = ['FTSmgCode' => $oSmgCode];
            $this->mSlipMessage->FSnMSMGDelHD($aSmg);
        }
        echo json_encode($aSmgCode);
    }
    
    /**
     * Functionality : Delete vat rate
     * Parameters : -
     * Creator : 27/08/2018 piya
     * Last Modified : -
     * Return : Vat code
     * Return Type : Object
     */
    public function FSoSMGDelete(){

        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTSmgCode' => $tIDCode
        );
        $aResDel    = $this->mSlipMessage->FSnMSMGDelHD($aDataMaster);
        $nNumRowSmgLoc = $this->mSlipMessage->FSnMLOCGetAllNumRow();
        if($nNumRowSmgLoc!==false){
            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'nNumRowSmgLoc' => $nNumRowSmgLoc
            );
            echo json_encode($aReturn);
        }else{
            echo "database error";
        }
    }
}
