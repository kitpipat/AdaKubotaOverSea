<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cBank extends MX_Controller {
    public function __construct(){
        parent::__construct ();
        $this->load->model('bank/bank/mBank');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nBnkBrowseType,$tBnkBrowseOption){
        $nMsgResp   = array('title'=>"BAnk");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';

        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        
        $vBtnSave       = FCNaHBtnSaveActiveHTML('bankindex/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventBank	= FCNaHCheckAlwFunc('bankindex/0/0');

        $this->load->view('bank/bank/wBank', array(
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nBnkBrowseType'    => $nBnkBrowseType,
            'tBnkBrowseOption'  => $tBnkBrowseOption,
            'aAlwEventBank'     => $aAlwEventBank
        ));

    }

    //Functionality : Function Call Bank Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCBNKListPage(){
        $aAlwEventBank	    = FCNaHCheckAlwFunc('bankindex/0/0');
        $this->load->view('bank/bank/wBankList', array(
            'aAlwEventBank' => $aAlwEventBank
        )); 
    }


    //Functionality : Function Call DataTables Bank
    //Parameters : Ajax Call View DataTable
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCBNKDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");

            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll
            );

            $aBnkDataList     = $this->mBank->FSaMBNKList($aData); 

            $aAlwEventBank	    = FCNaHCheckAlwFunc('bankindex/0/0');
            $aGenTable  = array(
                'aBnkDataList'      => $aBnkDataList,
                'nPage'             => $nPage,
                'tSearchAll'        => $tSearchAll,
                'aAlwEventBank'     => $aAlwEventBank
            );

            $this->load->view('bank/bank/wBankDataTable', $aGenTable);

        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage Bank
    //Parameters : Ajax Call View Add
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCBNKAddPage(){
        try{
            $aDataBnk = array(
                'nStaAddOrEdit'   => 99
            );
            $this->load->view('bank/bank/wBankAdd',$aDataBnk);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage BAnk Edits
    //Parameters : Ajax Call View Add
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCBNKEditPage(){
        try{
                
            $aData = array(
                'tBnkCode'    => $this->input->post('tBnkCode'),
                'nLangResort' => $this->session->userdata("tLangID"),
                'nLangEdit'   =>  $this->session->userdata("tLangEdit")
            );

            $aBnkData   = $this->mBank->FSaMBnkGetDataByID($aData);
            if(isset($aBnkData['raItems']['rtBnkImage']) && !empty($aBnkData['raItems']['rtBnkImage'])){
                $tImgObj        = $aBnkData['raItems']['rtBnkImage'];
                $aImgObj        = explode("application/modules/",$tImgObj);
                $aImgObjName    = explode("/",$tImgObj);
                $tImgObjAll		= $aImgObj[1];
                $tImgName		= end($aImgObjName);
            }else{
                $tImgObjAll     = "";
                $tImgName       = "";
            }
            $aData   = array(
                'nStaAddOrEdit' => 1,
                'aBnkData'   => $aBnkData,
                'tImgObjAll' => $tImgObjAll,
                'tImgName'   => $tImgName
            );
            $this->load->view('bank/bank/wBankAdd', $aData);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Add Bank
    //Parameters : Ajax Event
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCBNKAddEvent(){
        try{
            /** ==================== Input Image Data ==================== */
            $tImgInputBank      = $this->input->post('oetImgInputBank');
            $tImgInputBankOld   = $this->input->post('oetImgInputBankOld');
            /** ==================== Input Image Data ==================== */

            $tBnkCodeOld      = $this->input->post('oetBnkCodeOld');

            $aDataMaster = array(
                'tBnkCodeOld'   => $tBnkCodeOld,
                'FTBnkCode'     => $this->input->post('oetBnkCode'),
                'FTBnkName'     => $this->input->post('oetBnkName'),
                'FTBnkRmk'      => $this->input->post('otaBnkRmk'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );

            $oCountDup  = $this->mBank->FSnMBNKCheckDuplicate($aDataMaster['FTBnkCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if($nStaDup == 0){
                $this->db->trans_begin();
                $aStaEventMaster  = $this->mBank->FSaMBNKAddUpdateMaster($aDataMaster);
                $aStaEventLang    = $this->mBank->FSaMBNKAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event 1"
                    );
                }else{
                    $this->db->trans_commit();
                    if($tImgInputBank != $tImgInputBankOld){
                        $aImageData = [
                            'tModuleName'       => 'bank',
                            'tImgFolder'        => 'bank',
                            'tImgRefID'         => $this->input->post('oetBnkCode'),
                            'tImgObj'           => $tImgInputBank,
                            'tImgTable'         => 'TFNMBank',
                            'tTableInsert'      => 'TCNMImgObj',
                            'tImgKey'           => 'main',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1
                        ];
                        FCNnHAddImgObj($aImageData);
                    }

                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTBnkCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => language('bank/bank/bank', 'tBnkDataDupicate')
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Edit Bank
    //Parameters : Ajax Event
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCBNKEditEvent(){
        try{
            $this->db->trans_begin();

            /** ==================== Input Image Data ==================== */
            $tImgInputBank      = $this->input->post('oetImgInputBank');
            $tImgInputBankOld   = $this->input->post('oetImgInputBankOld');
            /** ==================== Input Image Data ==================== */

            $tBnkCodeOld      = $this->input->post('oetBnkCodeOld');

            $aDataMaster = array(
                'tBnkCodeOld'   => $tBnkCodeOld,
                'FTBnkCode'     => $this->input->post('oetBnkCode'),
                'FTBnkName'     => $this->input->post('oetBnkName'),
                'FTBnkRmk'      => $this->input->post('otaBnkRmk'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );

            $aStaEventMaster  = $this->mBank->FSaMBNKAddUpdateMaster($aDataMaster);
            $aStaEventLang    = $this->mBank->FSaMBNKAddUpdateLang($aDataMaster);
            $this->mBank->FSaMBNKAddImgObj($aDataMaster);
            
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit Product Brand"
                );
            }else{
                $this->db->trans_commit();

                if($tImgInputBank != $tImgInputBankOld){
                    $aImageUplode = array(
                        'tModuleName'       => 'bank',
                        'tImgFolder'        => 'bank',
                        'tImgRefID'         => $aDataMaster['FTBnkCode'],
                        'tImgObj'           => $tImgInputBank,
                        'tImgTable'         => 'TFNMBank',
                        'tTableInsert'      => 'TCNMImgObj',
                        'tImgKey'           => 'main',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1
                    );
                    FCNnHAddImgObj($aImageUplode);
                }
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTBnkCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit Product Brand'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

     //Functionality : Event Delete BAnk
    //Parameters : Ajax jReason()
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCBNKDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTBnkCode' => $tIDCode
        );
        $aResDel    = $this->mBank->FSaMBNKDelAll($aDataMaster);
        $nNumRowBnk = $this->mBank->FSnMBNKGetAllNumRow();

        if($nNumRowBnk!==false){
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
                'nNumRowBnk' => $nNumRowBnk
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }



    }

}

