<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

require_once (APPPATH.'third_party/PHPExcel/Classes/PHPExcel.php');
require_once (APPPATH.'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php');
require_once (APPPATH.'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

class cCardShiftOut extends MX_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->model('document/cardshiftout/mCardShiftOut');
        $this->load->model('authen/user/mUser');
        $this->load->library('upload');
        $this->load->helper('file');
    }
    
    /**
     * Functionality : Main page for Card Shift
     * Parameters : $nCardShiftOutBrowseType, $tCardShiftOutBrowseOption
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nCardShiftOutBrowseType, $tCardShiftOutBrowseOption){
        
        $nMsgResp = array('title'=>"Province");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ('common/wHeader', $nMsgResp);
            $this->load->view ('common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ('common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('cardShiftOut/0/0'); // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aPermission = FCNaHCheckAlwFunc("cardShiftOut/0/0");
        $this->load->view ('document/cardshiftout/wCardShiftOut', array (
            'nMsgResp'=>$nMsgResp,
            'vBtnSave' => $vBtnSave,
            'aPermission' => $aPermission,
            'nCardShiftOutBrowseType'=>$nCardShiftOutBrowseType,
            'tCardShiftOutBrowseOption'=>$tCardShiftOutBrowseOption
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
    public function FSvCardShiftOutListPage(){
        $aAlwEvent	    = FCNaHCheckAlwFunc('cardShiftOut/0/0');
		$aNewData  		= array( 'aAlwEvent' => $aAlwEvent );
        $this->load->view('document/cardshiftout/wCardShiftOutList',$aNewData);
    }

    /**
     * Functionality : Function Call DataTables Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftOutDataList(){
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
        $aResList = $this->mCardShiftOut->FSaMCardShiftOutList($tAPIReq, $tMethodReq, $aData);
        $aAlwEvent = FCNaHCheckAlwFunc('cardShiftOut/0/0');
        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('document/cardshiftout/wCardShiftOutDataTable', $aGenTable);
    }

    /**
     * Functionality : Function Call DataTables Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : 04/01/2019 Wasin(Yoshi)
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftOutDataSourceList(){
        $nPage              = $this->input->post('nPageCurrent');
        $tSearchAll         = $this->input->post('tSearchAll');
        $tDocNo             = $this->input->post('tDocNo');
        $aCardTypeRange     = json_decode($this->input->post('tCardTypeRange'));
        $aCardNumberRange   = json_decode($this->input->post('tCardNumberRange'));
        $aCardNumber        = json_decode($this->input->post('tCardNumber'));
        $aNotInCardNumber   = json_decode($this->input->post('tNotInCardNumber'));
        $tSetEmpty          = $this->input->post('tSetEmpty');
        $tStaShift          = $this->input->post('tStaShift');
        $tIsTemp            = $this->input->post('tIsTemp');
        $tIsDataOnly        = $this->input->post('tIsDataOnly');
        $tStaPrcDoc         = $this->input->post('tStaPrcDoc');
        $tStaDoc            = $this->input->post('tStaDoc');
        $tStaType           = $this->input->post('tStaType');
        $tLastIndex         = $this->input->post('tLastIndex');
        $tUsrBchCode        = empty($this->session->userdata('tSesUsrBchCode'))?FCNtGetBchInComp():$this->session->userdata('tSesUsrBchCode');
        $tOptionDocNo       = $this->input->post('tOptionDocNo');

        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        // Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");

        /** ===================== เช็ค Validate เอกสารเบิกบัตร =========================== */
            $paParams['tSessionID']     = $this->session->userdata("tSesSessionID");
            $paParams['tSeqNo']         = "";

            if($tStaPrcDoc == "" AND $tStaDoc == ""){
                //เช็คบัตรในระบบ
                $nStaChkCrdCodeFondInDB     = FSnHCrdShiftChkCrdCodeFoundInDB($paParams);

                // เช็คบัตรซ้ำในตาราง Temp
                $nStaChkTempDup             = FSnHCrdShiftChkCrdCodeNotDupTemp($paParams);

                // เช็คสถานะการถูกเบิกของบัตร
                $paParams['bStaCardShift']  = true;
                $nStaChkStaCrdShift         = FSnHCrdShiftChkStaShiftInCard($paParams);

                // เช็คสถานะ Active ของบัตร
                $paParams['nCrdStaActive']  = 1;
                $nStaChkStaCrdActive        = FSnHCrdShiftChkStaActiveInCard($paParams);

                // เช็ควันหมดอายุของบัตร
                $nStaChkStaCrdDateExpire    = FSnHCrdShiftChkCardExpireDate($paParams);
            }else{
                if($tStaPrcDoc == "" AND $tStaDoc == "1"){ // Document pending status(approve) or complete status(doc status)
                    //เช็คบัตรในระบบ
                    $nStaChkCrdCodeFondInDB     = FSnHCrdShiftChkCrdCodeFoundInDB($paParams);

                    // เช็คบัตรซ้ำในตาราง Temp
                    $nStaChkTempDup             = FSnHCrdShiftChkCrdCodeNotDupTemp($paParams);

                    // เช็คสถานะการถูกเบิกของบัตร
                    $paParams['bStaCardShift']  = true;
                    $nStaChkStaCrdShift         = FSnHCrdShiftChkStaShiftInCard($paParams);

                    // เช็คสถานะ Active ของบัตร
                    $paParams['nCrdStaActive']  = 1;
                    $nStaChkStaCrdActive        = FSnHCrdShiftChkStaActiveInCard($paParams);

                    // เช็ควันหมดอายุของบัตร
                    $nStaChkStaCrdDateExpire    = FSnHCrdShiftChkCardExpireDate($paParams);
                }
            }
        /** ========================================================================== */

        /** ======================= ดึงข้อมูลจาก ตาราง Temp =========================== */
            $aDataTemp  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll,
                'FTBchCode'     => "",
                'ptDocType'     => "cardShiftOut"
            );
            $aGetDataCrdShiftOutFrmTemp = FSaSelectDataForDocType($aDataTemp);
            $aCardOut                   = FSaSelectAllBySessionID("cardShiftOut");
        /** ========================================================================== */

        $aGenTable  = array(
            'aDataList'     => $aGetDataCrdShiftOutFrmTemp,
            'tDataListAll'  => json_encode($aCardOut),
            'rnAllRow'      => !empty($aCardOut['rnAllRow']) ? $aCardOut['rnAllRow'] : null,
            'ptDocType'     => "cardShiftOut",
            'tIDElement'    => "",
            'tIsTemp'       => $tIsTemp,
            'tIsDataOnly'   => $tIsDataOnly,
            'nPage'         => $nPage,
            'tSearchAll'    => $tSearchAll,
            'tStaPrcDoc'    => $tStaPrcDoc,
            'tStaDoc'       => $tStaDoc,
            'tLastIndex'    => $tLastIndex,
            'tOptionDocNo'  => $tOptionDocNo
        );
        $this->load->view('document/cardshiftout/wCardShiftOutDataSourceTable', $aGenTable);
    }
    
    /**
     * Functionality : Function CallPage Card Shift Add
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftOutAddPage(){
        
        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUsrBchCode = empty($this->session->userdata('tSesUsrBchCode'))?FCNtGetBchInComp():$this->session->userdata('tSesUsrBchCode');

        $aData  = array(
            'FNLngID'   => $nLangEdit,
            'FTUsrCode' => $this->session->userdata("tSesUsername")
        );
        $aUser = $this->mUser->FSaMUSRByID($aData);
        
        $aDataAdd = array(
            'aResult' => ['rtCode' => '99'],
            'aUser' => $aUser,
            'aUserApv' => ['rtCode' => '99'],
            'aCardCode' => [],
            'aUserCreated' => ['rtCode' => '99'],
            'nLangEdit' => $nLangEdit,
            'tUsrBchCode' => $tUsrBchCode
        );
        
        $this->load->view('document/cardshiftout/wCardShiftOutAdd', $aDataAdd);
    }
    
    /**
     * Functionality : Function CallPage Card Shift Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftOutEditPage(){
        
        $tCardShiftOutDocNo = $this->input->post('tCardShiftOutDocNo');
        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUsrBchCode = empty($this->session->userdata('tSesUsrBchCode'))?FCNtGetBchInComp():$this->session->userdata('tSesUsrBchCode');
        
        $aData  = array(
            'FTCshDocNo' => $tCardShiftOutDocNo,
            'FNLngID'   => $nLangEdit,
            'FTUsrCode' => $this->session->userdata("tSesUsername")
        );
        $aUser = $this->mUser->FSaMUSRByID($aData);
        $aPermission = FCNaHCheckAlwFunc("cardShiftOut/0/0");
        $tAPIReq = "";
        $tMethodReq = "GET";
        $aCardShiftOutData = $this->mCardShiftOut->FSaMCardShiftOutSearchByID($tAPIReq, $tMethodReq, $aData);
        
        $aData['FTUsrCode'] = $aCardShiftOutData['raItems']['rtCardShiftOutUsrCode'];
        $aUserCreated = $this->mUser->FSaMUSRByID($aData);
        
        $aData['FTUsrCode'] = $aCardShiftOutData['raItems']['rtCardShiftOutApvCode'];
        $aUserApv = $this->mUser->FSaMUSRByID($aData);
        
        $aData['FTBchCode'] = $aCardShiftOutData['raItems']['rtCardShiftOutBchCode'];
        $aData['FTCshDocNo'] = $aCardShiftOutData['raItems']['rtCardShiftOutDocNo'];

        // Remove in temp
        FCNoCARDataListDeleteOnlyTable("TFNTCrdShiftTmp");

        // Copy from DT to temp
        FSxDocHelperDTToTemp("cardShiftOut", $aData['FTCshDocNo']);

        // $aCardShiftOutCardDataInDT = $this->mCardShiftOut->FSaMCardShiftOutGetDTByDocNo($aData);

        $aDataEdit = array(
            'aResult'       => $aCardShiftOutData,
            'aUser'         => $aUser,
            'aUserApv'      => $aUserApv,
            'aUserCreated'  => $aUserCreated,
            'aPermission'   => $aPermission,
            'nLangEdit'     => $nLangEdit,
            'tUsrBchCode'   => $tUsrBchCode
        );
        
        $this->load->view('document/cardshiftout/wCardShiftOutAdd', $aDataEdit);
    }
    
    /**
     * Functionality : Event Add Card Shift
     * Parameters : Ajax and Function Parameter
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCardShiftOutAddEvent(){
        try{
            $aDataMaster = array(
                'tIsAutoGenCode' => $this->input->post('ocbCardShiftOutAutoGenCode'),
                'FTCshDocNo'        => $this->input->post('oetCardShiftOutCode'),
                'FDCshDocDate'      => $this->input->post('oetCardShiftOutDocDate') . ' ' . date('H:i:s'), 
                'FTCshDocType'      => "1", // Take out card
                'FTBchCode'         => $this->session->userdata('tSesUsrBchCom'),
                'FTUsrCode'         => $this->session->userdata("tSesUsername"),
                'FNCshCardQty'      => FSnSelectCountResult('TFNTCrdShiftTmp'),
                'aCardCode'         => json_decode($this->input->post('aCardCode')),
                'FTCshApvCode'      => $this->input->post('ohdCardShiftOutApvCode'),
                'FTCshStaPrcDoc'    => $this->input->post('ohdCardShiftOutCardStaPrcDoc'),
                'FTCshStaDoc'       => empty($this->input->post('hdCardShiftOutCardStaDoc')) ? "1" : $this->input->post('hdCardShiftOutCardStaDoc'),
                'FNCshStaDocAct'    => empty($this->input->post('hdCardShiftOutCardStaDoc')) ? 1 : $this->input->post('hdCardShiftOutCardStaDoc'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
            );
            
            // Setup DocNo
            if($aDataMaster['tIsAutoGenCode'] == '1'){ // Check Auto Gen DocNo?
                // Auto Gen DocNo Code
                $aGenCode = FCNaHGenCodeV5('TFNTCrdShiftHD', 1);
                if($aGenCode['rtCode'] == '1'){
                    $aDataMaster['FTCshDocNo'] = $aGenCode['rtCshDocNo'];
                }
            }
            
            $oCountDup  = $this->mCardShiftOut->FSoMCardShiftOutCheckDuplicate($aDataMaster['FTCshDocNo']);
            $nStaDup    = $oCountDup[0]->counts;

            if($nStaDup == 0){
                $this->db->trans_begin();

                $aStaCardShiftOutHD = $this->mCardShiftOut->FSaMCardShiftOutAddUpdateHD($aDataMaster);

                if($aStaCardShiftOutHD['rtCode'] == "1"){
                    
                    // Update DocNo on Temp
                    FCNCallUpdateDocNo($aDataMaster['FTCshDocNo'], 'TFNTCrdShiftTmp');
                    
                    // Copy from temp to DT
                    FSxDocHelperTempToDT("cardShiftOut");
                    
                    // Remove in temp
                    FCNoCARDataListDeleteOnlyTable("TFNTCrdShiftTmp");
                    
                }

                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'     => '900',
                        'tStaMessg'     => "Unsucess Add Event"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTCshDocNo'],
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
    public function FSaCardShiftOutEditEvent(){
        try{
            $aDataMaster = array(
                'FTCshDocNo'        => $this->input->post('oetCardShiftOutCode'),
                'FDCshDocDate'      => $this->input->post('oetCardShiftOutDocDate') . ' ' . date('H:i:s'),
                'FTCshDocType'      => "1", // Take out card
                'FTBchCode'         => $this->session->userdata('tSesUsrBchCom'),
                'FNCshCardQty'      => FSnSelectCountResult('TFNTCrdShiftTmp'),
                'aCardCode'         => json_decode($this->input->post('aCardCode')),
                'FTCshApvCode'      => $this->input->post('ohdCardShiftOutApvCode'),
                'FTCshStaPrcDoc'    => $this->input->post('ohdCardShiftOutCardStaPrcDoc'),
                'FTCshStaDoc'       => empty($this->input->post('hdCardShiftOutCardStaDoc')) ? "1" : $this->input->post('hdCardShiftOutCardStaDoc'),
                'FNCshStaDocAct'    => empty($this->input->post('hdCardShiftOutCardStaDocAct')) ? 1 : $this->input->post('hdCardShiftOutCardStaDocAct'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
            );
            
            $this->db->trans_begin();
            
            $aCardShiftOutHD = $this->mCardShiftOut->FSaMCardShiftOutSearchByID("", "", $aDataMaster);

            if( 
                ($aCardShiftOutHD['rtCode'] == "1") // Query HD success
                && (empty($aCardShiftOutHD["raItems"]['rtCardShiftOutStaPrcDoc'])) // On pending approve status 
                && ($aCardShiftOutHD["raItems"]['rtCardShiftOutStaDoc'] == "1") // On document complete status
            ) 
            {
                $aStaCardShiftOutHD  = $this->mCardShiftOut->FSaMCardShiftOutAddUpdateHD($aDataMaster);
                
                /*=============================================================*/
                if(($aStaCardShiftOutHD['rtCode'] == "1")){ // Update HD success
                    $paParams['tDocType']   = "cardShiftOut";
                    $paParams['tDocNo']     = $aDataMaster['FTCshDocNo'];

                    // Remove on DT
                    FSaDeleteDatainTableDT($paParams);

                    // Copy from Temp to DT
                    FSxDocHelperTempToDT("cardShiftOut");

                    // Remove in temp
                    FCNoCARDataListDeleteOnlyTable("TFNTCrdShiftTmp");

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
                    'tCodeReturn'	=> $aDataMaster['FTCshDocNo'],
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
    public function FSaCardShiftOutUpdateApvDocAndCancelDocEvent(){
        try{
            $aDataMaster = array(
                'FTCshDocNo'        => $this->input->post('oetCardShiftOutCode'),
                'FDCshDocDate'      => $this->input->post('oetCardShiftOutDocDate') . ' ' . date('H:i:s'), 
                'FTCshDocType'      => "1", // Take out card
                'FTBchCode'         => $this->session->userdata('tSesUsrBchCom'),
                'FTUsrCode'         => $this->session->userdata("tSesUsername"),
                'FNCshCardQty'      => count(json_decode($this->input->post('aCardCode'))),
                'aCardCode'         => json_decode($this->input->post('aCardCode')),
                'FTCshApvCode'      => $this->input->post('ohdCardShiftOutApvCode'),
                'FTCshStaPrcDoc'    => $this->input->post('ohdCardShiftOutCardStaPrcDoc'),
                'FDCshApvDate'      => date('Y-m-d H:i:s'),
                'FTCshStaDoc'       => empty($this->input->post('hdCardShiftOutCardStaDoc')) ? "1" : $this->input->post('hdCardShiftOutCardStaDoc'),
                'FNCshStaDocAct'    => empty($this->input->post('hdCardShiftOutCardStaDocAct')) ? 1 : $this->input->post('hdCardShiftOutCardStaDocAct'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FNLngID'           => $this->session->userdata("tLangEdit")
            );
            
            $this->db->trans_begin();
            
            $aCardShiftOutHD = $this->mCardShiftOut->FSaMCardShiftOutSearchByID("", "", $aDataMaster);
            
            if( ($aDataMaster['FTCshStaPrcDoc'] == "2") // Update status approve is true
                && ($aCardShiftOutHD['rtCode'] == "1") // Query HD success
                && (empty($aCardShiftOutHD["raItems"]['rtCardShiftOutStaPrcDoc'])) // On pending approve status 
                && ($aCardShiftOutHD["raItems"]['rtCardShiftOutStaDoc'] == "1") // On document complete status
            ) 
            {
                $aStaCardShiftOutHD = $this->mCardShiftOut->FSaMCardShiftOutUpdateApvDocAndCancelDocHD($aDataMaster);
                
                /*========================== Approved =========================*/
                try{
                    $aMQParams = [
                        "queueName" => "CARDREQUEST", 
                            "params" => [
                                "ptBchCode" => $aDataMaster['FTBchCode'], 
                                "ptDocNo" => $aDataMaster['FTCshDocNo'],
                                "ptUsrCode" => $aDataMaster['FTUsrCode']
                                ]
                        ];
                    FCNxCallRabbitMQ($aMQParams);
                }catch(\ErrorException $err){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => language('document/card/cardout', 'tCardShiftOutApproveFail')
                    );
                    echo json_encode($aReturn);
                    return;
                }
                /*=============================================================*/
            }
            
            /*=============================== Cancel ==========================*/
            if(($aDataMaster['FTCshStaDoc'] == "3")){ // Have card and update status document is cancel
                $aStaCardShiftOutHD = $this->mCardShiftOut->FSaMCardShiftOutUpdateApvDocAndCancelDocHD($aDataMaster);
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
                    'tCodeReturn'	=> $aDataMaster['FTCshDocNo'],
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
    public function FSaCardShiftOutDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTCardShiftOutCode' => $tIDCode
        );

        $aResDel = $this->mCardShiftOut->FSnMCardShiftOutDel($aDataMaster);
        $aReturn = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    /**
     * Functionality : Vatrate unique check
     * Parameters : $tSelect "CardShiftOutcode"
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Check status true or false
     * Return Type : String
     */
    public function FStCardShiftOutUniqueValidate($tSelect = ''){
        
        if($this->input->is_ajax_request()){ // Request check
            if($tSelect == 'cardShiftOutCode'){
                
                $tCardShiftOutCode = $this->input->post('tCardShiftOutCode');
                $oCustomerGroup = $this->mCardShiftOut->FSoMCardShiftOutCheckDuplicate($tCardShiftOutCode);
                
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
    public function FSoCardShiftOutDeleteMulti(){
        $tCardShiftOutCode = $this->input->post('tCardShiftOutCode');
      
        $aCardShiftOutCode = json_decode($tCardShiftOutCode);
        foreach($aCardShiftOutCode as $oCardShiftOutCode){
            $aCardShiftOut = ['FTCardShiftOutCode' => $oCardShiftOutCode];
            $this->mCardShiftOut->FSnMCardShiftOutDel($aCardShiftOut);
        }
        echo json_encode($aCardShiftOutCode);
    }
    
    /**
     * Functionality : Delete vat rate
     * Parameters : -
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : Vat code
     * Return Type : Object
     */
    public function FSoCardShiftOutDelete(){
        $tCardShiftOutCode = $this->input->post('tCardShiftOutCode');
        
        $aCardShiftOut = ['FTCardShiftOutCode' => $tCardShiftOutCode];
        $this->mCardShiftOut->FSnMCardShiftOutDel($aCardShiftOut);
        echo json_encode($tCardShiftOutCode);
    }
            
    /**
     * Functionality : Function Call DataTables Card Shift by file (xls or xlsx)
     * Parameters : Ajax and Function Parameter
     * Creator : 02/11/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCardShiftOutDataSourceListByFile(){
        $nPage              = $this->input->post('nPageCurrent');
        $tSearchAll         = $this->input->post('tSearchAll');
        $aCardTypeRange     = json_decode($this->input->post('tCardTypeRange'));
        $aCardNumberRange   = json_decode($this->input->post('tCardNumberRange'));
        $aCardNumber        = json_decode($this->input->post('tCardNumber'));
        $aNotInCardNumber   = json_decode($this->input->post('tNotInCardNumber'));
        $tSetEmpty          = $this->input->post('tSetEmpty');
        $tStaShift          = $this->input->post('tStaShift');
        $tIsTemp            = $this->input->post('tIsTemp');
        $tIsDataOnly        = $this->input->post('tIsDataOnly');
        $tStaPrcDoc         = $this->input->post('tStaPrcDoc');
        $tStaDoc            = $this->input->post('tStaDoc');
        $tStaType           = $this->input->post('tStaType');
        $tLastIndex         = $this->input->post('tLastIndex');
        $tDocNo             = $this->input->post('tDocNo');
        
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        
        // Lang ภาษา
        $nLangResort = $this->session->userdata("tLangID");
	$nLangEdit = $this->session->userdata("tLangEdit");
        
        try{
            $aDataFiles = (isset($_FILES['oefCardShiftOutImport']) && !empty($_FILES['oefCardShiftOutImport']))? $_FILES['oefCardShiftOutImport'] : null;
            
            if(isset($aDataFiles) && !empty($aDataFiles) && is_array($aDataFiles)){
                // Insert
                $aDataFiles     = (isset($_FILES['aFile']) && !empty($_FILES['aFile']))? $_FILES['aFile'] : null;
                $ptDocType      = 'cardShiftOut';
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
            echo "Controller Err FSvCardShiftOutDataSourceListByFile = ".$Error;
        }

    }

    /**
     * Functionality : Function Update Card Shift InLine
     * Parameters : Ajax and Function Parameter
     * Creator : 04/01/2019 Wasin(Yoshi)
     * Last Modified : -
     * Return : String View
     * Return Type : View
    */
    public function FSxCardShiftOutUpdateInlineOnTemp(){
        $tDocType           = "cardShiftOut";
        $nSeq               = $this->input->post('nSeq');
        $tCardCode          = $this->input->post('tCardCode');
        $aDataSet = [
            "tCardCode"     => $tCardCode,
        ];
        FSxUpdateTempBySeq($tDocType, $nSeq, $aDataSet);
    }

    /**
     * Functionality : Insert card data to document temp
     * Parameters : {params}
     * Creator : 3/01/2019 piya
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    public function FSxCardShiftOutInsertToTemp(){
        $tUsrBchCode = empty($this->session->userdata('tSesUsrBchCode'))?FCNtGetBchInComp():$this->session->userdata('tSesUsrBchCode');
        $tUserCode = $this->session->userdata("tSesUsername");
        $aRangeCardCode = json_decode($this->input->post('tRangeCardCode'));
        $aRangeCardType = json_decode($this->input->post('tRangeCardType'));
        $aCardCode = json_decode($this->input->post('tCardCode'));
        $tInsertType = $this->input->post('tInsertType');
        $tDocNo = $this->input->post('tDocNo');
        
        $tDocType   = "cardShiftOut";
        $tDataSetType   =   "";
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
}







