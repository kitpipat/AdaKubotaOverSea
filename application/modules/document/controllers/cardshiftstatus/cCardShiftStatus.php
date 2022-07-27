<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

require_once (APPPATH.'third_party/PHPExcel/Classes/PHPExcel.php');
require_once (APPPATH.'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php');
require_once (APPPATH.'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

class cCardShiftStatus extends MX_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->model('document/cardshiftstatus/mCardShiftStatus');
        $this->load->model('authen/user/mUser');
        $this->load->library('upload');
        $this->load->helper('file');
    }
    
    /**
     * Functionality : Main page for Card Shift
     * Parameters : $nCardShiftStatusBrowseType, $tCardShiftStatusBrowseOption
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nCardShiftStatusBrowseType, $tCardShiftStatusBrowseOption){
        
        $nMsgResp = array('title'=>"Province");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ('common/wHeader', $nMsgResp);
            $this->load->view ('common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ('common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('cardShiftStatus/0/0'); // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aPermission = FCNaHCheckAlwFunc("cardShiftStatus/0/0");
        $this->load->view ('document/cardshiftstatus/wCardShiftStatus', array (
            'nMsgResp'=>$nMsgResp,
            'vBtnSave' => $vBtnSave,
            'aPermission' => $aPermission,
            'nCardShiftStatusBrowseType'=>$nCardShiftStatusBrowseType,
            'tCardShiftStatusBrowseOption'=>$tCardShiftStatusBrowseOption
        ));
        
    }
    
    /**
     * Functionality : Function Call Card Shift Page List
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftStatusListPage(){
        $aAlwEvent	    = FCNaHCheckAlwFunc('cardShiftStatus/0/0');
		$aNewData  		= array( 'aAlwEvent' => $aAlwEvent );
        $this->load->view('document/cardshiftstatus/wCardShiftStatusList',$aNewData);
    }

    /**
     * Functionality : Function Call DataTables Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftStatusDataList(){
        $nPage = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        $tAdvanceSearch = json_decode($this->input->post('tAdvanceSearch'));
        $tUsrBchCode = $this->session->userdata('tSesUsrBchCom');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        // Lang ภาษา
        $nLangResort = $this->session->userdata("tLangID");
	    $nLangEdit = $this->session->userdata("tLangEdit");

        $aData = array(
            'nPage' => $nPage,
            'nRow' => 10,
            'FNLngID' => $nLangEdit,
            'tSearchAll' => $tSearchAll,
            'tAdvanceSearch' => $tAdvanceSearch,
            'FTBchCode' => $tUsrBchCode,
            'tUserLevel' => $this->session->userdata("tSesUsrLevel")
        );

        $tAPIReq = "";
        $tMethodReq = "GET";
        $aResList = $this->mCardShiftStatus->FSaMCardShiftStatusList($tAPIReq, $tMethodReq, $aData);
        $aAlwEvent = FCNaHCheckAlwFunc('cardShiftStatus/0/0');
        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('document/cardshiftstatus/wCardShiftStatusDataTable', $aGenTable);
    }

    /**
     * Functionality : Function Call DataTables Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftStatusDataSourceList(){
        $nPage = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        $tOptionDocNo = $this->input->post('tOptionDocNo');
        $tIsTemp = $this->input->post('tIsTemp');
        $tIsDataOnly = $this->input->post('tIsDataOnly');
        $tStaPrcDoc = $this->input->post('tStaPrcDoc');
        $tStaDoc = $this->input->post('tStaDoc');
        $tLastIndex = $this->input->post('tLastIndex');
        
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        // Lang ภาษา
        $nLangResort = $this->session->userdata("tLangID");
	$nLangEdit = $this->session->userdata("tLangEdit");
        
        $paParams['tSessionID'] = $this->session->userdata("tSesSessionID");
        $paParams['tSeqNo'] = "";
        
        if($tStaPrcDoc == "" AND $tStaDoc == ""){
            // Validate document temp
            FSnHCrdChangeChkCrdCodeFoundInDB($paParams);
            FSnHCrdChangeChkNewCardNotDupTemp($paParams);

            /*$paParams['bStaCardShift'] = true;
            FSnHCrdChangeChkStaShiftInCard($paParams);

            $paParams['nCrdStaActive'] = 1;
            FSnHCrdChangeChkCrdStaActiveInCard($paParams);*/
        }else{
            if($tStaPrcDoc == "" AND $tStaDoc == "1"){ // Document pending status(approve) or complete status(doc status)
                // Validate document temp
                FSnHCrdChangeChkCrdCodeFoundInDB($paParams);
                FSnHCrdChangeChkNewCardNotDupTemp($paParams);

                /*$paParams['bStaCardShift'] = true;
                FSnHCrdChangeChkStaShiftInCard($paParams);

                $paParams['nCrdStaActive'] = 1;
                FSnHCrdChangeChkCrdStaActiveInCard($paParams);*/
            }
        }
        
        // Call data on temp helper
        $aDataTemp  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll,
            'FTBchCode' => "",
            'ptDocType' => "cardShiftStatus"
        );
        $aCardChangeFromTemp = FSaSelectDataForDocType($aDataTemp);
        $aCardStatus = FSaSelectAllBySessionID("cardShiftStatus");
        
        $aGenTable = array(
            'aDataList' => $aCardChangeFromTemp,
            'tDataListAll' => json_encode($aCardStatus),
            'rnAllRow' => !empty($aCardStatus['rnAllRow']) ? $aCardStatus['rnAllRow'] : null,
            'ptDocType'     => "cardShiftStatus",
            'tIDElement'    => "",
            'tIsTemp' => $tIsTemp,
            'tIsDataOnly' => $tIsDataOnly,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll,
            'tStaPrcDoc' => $tStaPrcDoc,
            'tStaDoc' => $tStaDoc,
            'tLastIndex' => $tLastIndex,
            'tOptionDocNo' => $tOptionDocNo
        );
        $this->load->view('document/cardshiftstatus/wCardShiftStatusDataSourceTable', $aGenTable);
    }
    
    /**
     * Functionality : Function CallPage Card Shift Add
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftStatusAddPage(){
        $tUsrBchCode = empty($this->session->userdata('tSesUsrBchCode'))?FCNtGetBchInComp():$this->session->userdata('tSesUsrBchCode');
        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aData  = array(
            'FNLngID'   => $nLangEdit,
            'FTUsrCode' => $this->session->userdata("tSesUsername")
        );
        $aUser = $this->mUser->FSaMUSRByID($aData);
        
        $aDataAdd = array(
            'aResult' => ['rtCode' => '99'],
            'aUser' => $aUser,
            'aUserApv' => ['rtCode' => '99'],
            'tUsrBchCode' => $tUsrBchCode,
            'nLangEdit' => $nLangEdit,
            'aCardCode' => [],
            'aUserCreated' => ['rtCode' => '99']
        );
        
        $this->load->view('document/cardshiftstatus/wCardShiftStatusAdd', $aDataAdd);
    }
    
    /**
     * Functionality : Insert card data to document temp
     * Parameters : {params}
     * Creator : 3/01/2019 piya
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    public function FSxCardShiftStatusInsertToTemp(){
        $tUsrBchCode = empty($this->session->userdata('tSesUsrBchCode'))?FCNtGetBchInComp():$this->session->userdata('tSesUsrBchCode');
        $tUserCode = $this->session->userdata("tSesUsername");
        $aRangeCardCode = json_decode($this->input->post('tRangeCardCode'));
        $aRangeCardType = json_decode($this->input->post('tRangeCardType'));
        $aCardCode = json_decode($this->input->post('tCardCode'));
        $tInsertType = $this->input->post('tInsertType');
        $tDocNo = $this->input->post('tDocNo');
        
        $tDocType = "cardShiftStatus";
        
        if($tInsertType == "between"){
            $tDataSetType = "Between";
            $aDataSet = [
                "tDocNo" => $tDocNo,
                "tBchCode" => $tUsrBchCode,
                "tCreateBy" => $tUserCode,
                "aCardCode" => $aRangeCardCode,
                "aCardType" => $aRangeCardType
            ];
        }
        
        if($tInsertType == "choose"){
            $tDataSetType = "ChooseCard";
            $aDataSet = [
                "tDocNo" => $tDocNo,
                "tBchCode" => $tUsrBchCode,
                "tCreateBy" => $tUserCode,
                "aCardCode" => $aCardCode
            ];
        }
        FCNaCARDInsertDataToTemp($tDocType, $tDataSetType, [], $aDataSet);
    }
    
    /**
     * Functionality : Update card data in document temp by row
     * Parameters : {params}
     * Creator : 3/01/2019 piya
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    public function FSxCardShiftStatusUpdateInlineOnTemp(){
        $tCardNumber = $this->input->post('tCardNumber');
        $nSeq = $this->input->post('nSeq');
        $tDocType = "cardShiftStatus";
        $aDataSet = [
            "tCardCode" => $tCardNumber
        ];
        FSxUpdateTempBySeq($tDocType, $nSeq, $aDataSet);
    }
    
    /**
     * Functionality : Function CallPage Card Shift Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftStatusEditPage(){
        
        $tCardShiftStatusDocNo = $this->input->post('tCardShiftStatusDocNo');
        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUsrBchCode = empty($this->session->userdata('tSesUsrBchCode'))?FCNtGetBchInComp():$this->session->userdata('tSesUsrBchCode');
        
        $aData  = array(
            'FTCvhDocNo' => $tCardShiftStatusDocNo,
            'FNLngID'   => $nLangEdit,
            'FTUsrCode' => $this->session->userdata("tSesUsername")
        );
        $aUser = $this->mUser->FSaMUSRByID($aData);
        $aPermission = FCNaHCheckAlwFunc("cardShiftStatus/0/0");
        $tAPIReq = "";
        $tMethodReq = "GET";
        $aCardShiftStatusData = $this->mCardShiftStatus->FSaMCardShiftStatusSearchByID($tAPIReq, $tMethodReq, $aData);
        
        $aData['FTUsrCode'] = $aCardShiftStatusData['raItems']['rtCardShiftStatusUsrCode'];
        $aUserCreated = $this->mUser->FSaMUSRByID($aData);
        
        $aData['FTUsrCode'] = $aCardShiftStatusData['raItems']['rtCardShiftStatusApvCode'];
        $aUserApv = $this->mUser->FSaMUSRByID($aData);
        
        $aData['FTBchCode'] = $aCardShiftStatusData['raItems']['rtCardShiftStatusBchCode'];
        $aData['FTCvhDocNo'] = $aCardShiftStatusData['raItems']['rtCardShiftStatusDocNo'];
        
        // Remove in temp
        FCNoCARDataListDeleteOnlyTable("TFNTCrdVoidTmp");
        
        // Copy from DT to temp
        FSxDocHelperDTToTemp("cardShiftStatus", $aData['FTCvhDocNo']);
        
        // $aCardShiftStatusCardDataInDT = $this->mCardShiftStatus->FSaMCardShiftStatusGetDTByDocNo($aData);
        
        $aDataEdit = array(
            'aResult' => $aCardShiftStatusData,
            'aUser' => $aUser,
            'aUserApv' => $aUserApv,
            'nLangEdit' => $nLangEdit,
            'tUsrBchCode' => $tUsrBchCode,
            'aUserCreated' => $aUserCreated,
            'aPermission' => $aPermission
        );
        
        $this->load->view('document/cardshiftstatus/wCardShiftStatusAdd', $aDataEdit);
    }
    
    /**
     * Functionality : Event Add Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCardShiftStatusAddEvent(){
        try{
            $aDataMaster = array(
                'tIsAutoGenCode' => $this->input->post('ocbCardShiftStatusAutoGenCode'),
                'FTCvhDocNo' => $this->input->post('oetCardShiftStatusCode'),
                'FDCvhDocDate' => $this->input->post('oetCardShiftStatusDocDate') . ' ' . date('H:i:s'), 
                'FTCvhDocType' => "1", // Status card
                'FTBchCode'   => $this->session->userdata('tSesUsrBchCom'),
                
                'FTUsrCode'   => $this->session->userdata("tSesUsername"),
                'FTCvhStaCrdActive'   => $this->input->post("ocmCrdStaActive"),
                'FNCvhCardQty'   => FSnSelectCountResult('TFNTCrdVoidTmp'),
                'aCardCode' => json_decode($this->input->post('aCardCode')),
                
                'FTCvhApvCode' => $this->input->post('ohdCardShiftStatusApvCode'),
                'FTCvhStaPrcDoc' => $this->input->post('ohdCardShiftStatusCardStaPrcDoc'),
                'FTCvhStaDoc' => empty($this->input->post('hdCardShiftStatusCardStaDoc')) ? "1" : $this->input->post('hdCardShiftStatusCardStaDoc'),
                'FNCvhStaDocAct' => empty($this->input->post('hdCardShiftStatusCardStaDoc')) ? 1 : $this->input->post('hdCardShiftStatusCardStaDoc'),
            
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'   => $this->session->userdata('tSesUsername'),
                'FDCreateOn'   => date('Y-m-d H:i:s'),
                'FNLngID'   => $this->session->userdata("tLangEdit"),
            );
            
            // Setup DocNo
            if($aDataMaster['tIsAutoGenCode'] == '1'){ // Check Auto Gen DocNo?
                // Auto Gen DocNo Code
                $aGenCode = FCNaHGenCodeV5('TFNTCrdVoidHD', 5);
                if($aGenCode['rtCode'] == '1'){
                    $aDataMaster['FTCvhDocNo'] = $aGenCode['rtCvhDocNo'];
                }
            }
            
            $oCountDup  = $this->mCardShiftStatus->FSoMCardShiftStatusCheckDuplicate($aDataMaster['FTCvhDocNo']);
            $nStaDup    = $oCountDup[0]->counts;
            
            if($nStaDup == 0){
                $this->db->trans_begin();
                
                $aStaCardShiftStatusHD = $this->mCardShiftStatus->FSaMCardShiftStatusAddUpdateHD($aDataMaster);
                
                if($aStaCardShiftStatusHD['rtCode'] == "1"){
                    
                    // Update DocNo on Temp
                    FCNCallUpdateDocNo($aDataMaster['FTCvhDocNo'], 'TFNTCrdVoidTmp');
                    
                    // Copy from temp to DT
                    FSxDocHelperTempToDT("cardShiftStatus");
                    
                    // Remove in temp
                    FCNoCARDataListDeleteOnlyTable("TFNTCrdVoidTmp");
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
                        'tCodeReturn'	=> $aDataMaster['FTCvhDocNo'],
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
     * Functionality : Event Edit Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCardShiftStatusEditEvent(){
        try{
            $aDataMaster = array(
                'FTCvhDocNo' => $this->input->post('oetCardShiftStatusCode'),
                'FDCvhDocDate' => $this->input->post('oetCardShiftStatusDocDate') . ' ' . date('H:i:s'), 
                'FTCvhDocType' => "1", // Status card
                'FTBchCode'   => $this->session->userdata('tSesUsrBchCom'),
                
                // 'FTUsrCode'   => $this->session->userdata("tSesUsername"),
                'FTCvhStaCrdActive'   => $this->input->post("ocmCrdStaActive"),
                'FNCvhCardQty'   => FSnSelectCountResult('TFNTCrdVoidTmp'),
                'aCardCode'     => json_decode($this->input->post('aCardCode')),
                
                'FTCvhApvCode' => $this->input->post('ohdCardShiftStatusApvCode'),
                'FTCvhStaPrcDoc' => $this->input->post('ohdCardShiftStatusCardStaPrcDoc'),
                'FTCvhStaDoc' => empty($this->input->post('hdCardShiftStatusCardStaDoc')) ? "1" : $this->input->post('hdCardShiftStatusCardStaDoc'),
                'FNCvhStaDocAct' => empty($this->input->post('hdCardShiftStatusCardStaDocAct')) ? 1 : $this->input->post('hdCardShiftStatusCardStaDocAct'),
            
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'   => $this->session->userdata('tSesUsername'),
                'FDCreateOn'   => date('Y-m-d H:i:s'),
                'FNLngID'   => $this->session->userdata("tLangEdit"),
            );
            
            $this->db->trans_begin();
            
            $aCardShiftStatusHD = $this->mCardShiftStatus->FSaMCardShiftStatusSearchByID("", "", $aDataMaster);
            if( 
                ($aCardShiftStatusHD['rtCode'] == "1") // Query HD success
                && (empty($aCardShiftStatusHD["raItems"]['rtCardShiftStatusStaPrcDoc'])) // On pending approve status 
                && ($aCardShiftStatusHD["raItems"]['rtCardShiftStatusStaDoc'] == "1") // On document complete status
            ) 
            {
                $aStaCardShiftStatusHD  = $this->mCardShiftStatus->FSaMCardShiftStatusAddUpdateHD($aDataMaster);
                
                /*=============================================================*/
            if(($aStaCardShiftStatusHD['rtCode'] == "1")){ // Update HD success
                    $paParams['tDocType'] = "cardShiftStatus";
                    $paParams['tDocNo'] = $aDataMaster['FTCvhDocNo'];
                    // Remove on DT
                    FSaDeleteDatainTableDT($paParams);
                    
                    // Copy from Temp to DT
                    FSxDocHelperTempToDT("cardShiftStatus");
                    
                    // Remove in temp
                    FCNoCARDataListDeleteOnlyTable("TFNTCrdVoidTmp");
                }
                /*=============================================================*/
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
                    'tCodeReturn'	=> $aDataMaster['FTCvhDocNo'],
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
     * Functionality : Event Edit Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCardShiftStatusUpdateApvDocAndCancelDocEvent(){
        try{
            $aDataMaster = array(
                'FTCvhDocNo' => $this->input->post('oetCardShiftStatusCode'),
                'FDCvhDocDate' => $this->input->post('oetCardShiftStatusDocDate') . ' ' . date('H:i:s'), 
                'FTCvhDocType' => "1", // Status card
                'FTBchCode'   => $this->session->userdata('tSesUsrBchCom'),
                
                'FTUsrCode'   => $this->session->userdata("tSesUsername"),
                'FTCvhStaCrdActive'   => $this->input->post("ocmCrdStaActive"),
                'FNCvhCardQty'   => count(json_decode($this->input->post('aCardCode'))),
                'aCardCode' => json_decode($this->input->post('aCardCode')),
                
                'FTCvhApvCode' => $this->input->post('ohdCardShiftStatusApvCode'),
                'FTCvhStaPrcDoc' => $this->input->post('ohdCardShiftStatusCardStaPrcDoc'),
                'FDCvhApvDate' => date('Y-m-d H:i:s'),
                'FTCvhStaDoc' => empty($this->input->post('hdCardShiftStatusCardStaDoc')) ? "1" : $this->input->post('hdCardShiftStatusCardStaDoc'),
                'FNCvhStaDocAct' => empty($this->input->post('hdCardShiftStatusCardStaDocAct')) ? 1 : $this->input->post('hdCardShiftStatusCardStaDocAct'),
            
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'   => $this->session->userdata('tSesUsername'),
                'FDCreateOn'   => date('Y-m-d H:i:s'),
                'FNLngID'   => $this->session->userdata("tLangEdit"),
            );
            
            $this->db->trans_begin();
            
            $aCardShiftStatusHD = $this->mCardShiftStatus->FSaMCardShiftStatusSearchByID("", "", $aDataMaster);
            
            if( ($aDataMaster['FTCvhStaPrcDoc'] == "2") // Update status approve is true
                && ($aCardShiftStatusHD['rtCode'] == "1") // Query HD success
                && (empty($aCardShiftStatusHD["raItems"]['rtCardShiftStatusStaPrcDoc'])) // On pending approve status 
                && ($aCardShiftStatusHD["raItems"]['rtCardShiftStatusStaDoc'] == "1") // On document complete status
            ) 
            {
                $aStaCardShiftStatusHD = $this->mCardShiftStatus->FSaMCardShiftStatusUpdateApvDocAndCancelDocHD($aDataMaster);
                
                /*========================== Approved =========================*/
                try{
                    $aMQParams = [
                        "queueName" => "CARDADJSTATUS", 
                            "params" => [
                                "ptBchCode" => $aDataMaster['FTBchCode'], 
                                "ptDocNo" => $aDataMaster['FTCvhDocNo'],
                                "ptUsrCode" => $aDataMaster['FTUsrCode']
                                ]
                        ];
                    $debug = FCNxCallRabbitMQ($aMQParams);
                    
                }catch(\ErrorException $err){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => language('document/cardshiftstatus', 'tCardShiftStatusApproveFail')
                    );
                    echo json_encode($aReturn);
                    return;
                }
                /*=============================================================*/
            }
            
            /*=============================== Cancel ==========================*/
            if(($aDataMaster['FTCvhStaDoc'] == "3")){ // Have card and update status document is cancel
                $aStaCardShiftStatusHD = $this->mCardShiftStatus->FSaMCardShiftStatusUpdateApvDocAndCancelDocHD($aDataMaster);
            }
            /*=============================================================*/
            
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Update Event"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTCvhDocNo'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Update Event'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
      
    }
    
    /**
     * Functionality : Event Delete Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status Delete Event
     * Return Type : String
     */
    public function FSaCardShiftStatusDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTCardShiftStatusCode' => $tIDCode
        );

        $aResDel = $this->mCardShiftStatus->FSnMCardShiftStatusDel($aDataMaster);
        $aReturn = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    /**
     * Functionality : Vatrate unique check
     * Parameters : $tSelect "CardShiftStatuscode"
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Check status true or false
     * Return Type : String
     */
    public function FStCardShiftStatusUniqueValidate($tSelect = ''){
        
        if($this->input->is_ajax_request()){ // Request check
            if($tSelect == 'cardShiftStatusCode'){
                
                $tCardShiftStatusCode = $this->input->post('tCardShiftStatusCode');
                $oCustomerGroup = $this->mCardShiftStatus->FSoMCardShiftStatusCheckDuplicate($tCardShiftStatusCode);
                
                $tStatus = 'false';
                if($oCustomerGroup[0]->counts > 0){ // If have record
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
     * Parameters : Ajax Function Delete Card Shift
     * Creator : 09/10/2018 piya
     * Last Modified : -
     * Return : Status Event Delete And Status Call Back Event
     * Return Type : object
     */
    public function FSoCardShiftStatusDeleteMulti(){
        $tCardShiftStatusCode = $this->input->post('tCardShiftStatusCode');
      
        $aCardShiftStatusCode = json_decode($tCardShiftStatusCode);
        foreach($aCardShiftStatusCode as $oCardShiftStatusCode){
            $aCardShiftStatus = ['FTCardShiftStatusCode' => $oCardShiftStatusCode];
            $this->mCardShiftStatus->FSnMCardShiftStatusDel($aCardShiftStatus);
        }
        echo json_encode($aCardShiftStatusCode);
    }
    
    /**
     * Functionality : Delete vat rate
     * Parameters : -
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Vat code
     * Return Type : Object
     */
    public function FSoCardShiftStatusDelete(){
        $tCardShiftStatusCode = $this->input->post('tCardShiftStatusCode');
        
        $aCardShiftStatus = ['FTCardShiftStatusCode' => $tCardShiftStatusCode];
        $this->mCardShiftStatus->FSnMCardShiftStatusDel($aCardShiftStatus);
        echo json_encode($tCardShiftStatusCode);
    }
            
    /**
     * Functionality : Function Call DataTables Card Shift by file (xls or xlsx)
     * Parameters : Ajax and Function Parameter
     * Creator : 02/11/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftStatusDataSourceListByFile(){
        $nPage = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        $aCardTypeRange = json_decode($this->input->post('tCardTypeRange'));
        $aCardNumberRange = json_decode($this->input->post('tCardNumberRange'));
        $aCardNumber = json_decode($this->input->post('tCardNumber'));
        $aNotInCardNumber = json_decode($this->input->post('tNotInCardNumber'));
        $tSetEmpty = $this->input->post('tSetEmpty');
        $tStaShift = $this->input->post('tStaShift');
        $tIsTemp = $this->input->post('tIsTemp');
        $tIsDataOnly = $this->input->post('tIsDataOnly');
        $tStaPrcDoc = $this->input->post('tStaPrcDoc');
        $tDocNo = $this->input->post('tDocNo');
        $tStaDoc = $this->input->post('tStaDoc');
        $tStaType = $this->input->post('tStaType');
        $tLastIndex = $this->input->post('tLastIndex');
        
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        
        // Lang ภาษา
        $nLangResort = $this->session->userdata("tLangID");
	$nLangEdit = $this->session->userdata("tLangEdit");
        
        try{
            $aDataFiles = (isset($_FILES['oefCardShiftStatusImport']) && !empty($_FILES['oefCardShiftStatusImport']))? $_FILES['oefCardShiftStatusImport'] : null;
            
            if(isset($aDataFiles) && !empty($aDataFiles) && is_array($aDataFiles)){
                // Insert
                $aDataFiles     = (isset($_FILES['aFile']) && !empty($_FILES['aFile']))? $_FILES['aFile'] : null;
                $ptDocType      = 'cardShiftStatus';
                $ptDataSetType  = 'Excel';
                $paDataExcel    = [
                    'file' => $aDataFiles,
                    'reasonfile' => '', 
                    'optionfile_newcard' => 0,
                    'nDocno' => $tDocNo
                ];
                
                $paDataSet = [];
                if(isset($_FILES['aFile'])){
                    $tResult = FCNaCARInsertDataToTempFileCenter($ptDocType, $ptDataSetType, $paDataExcel, $paDataSet);
                }

                if($tResult['nStaEvent'] == 1){
                    $aDataReturn = array(
                        'tStaLog'   => 'Success',
                        'tDocType'  => $ptDocType
                    );
                    echo json_encode($aDataReturn);
                }else{  
                    $aDataReturn = array(
                        'tStaLog'   => $tResult['tTextError'],
                        'tDocType'  => $ptDocType
                    );
                    echo json_encode($aDataReturn);
                }
            }
        }catch(Exception $Error){
            echo "Controller Err FSvCardShiftStatusDataSourceListByFile = ".$Error;
        }
        
    }
}







