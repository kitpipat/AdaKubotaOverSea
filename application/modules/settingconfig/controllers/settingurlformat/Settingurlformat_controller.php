<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Settingurlformat_controller extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('settingconfig/settingurlformat/Settingurlformat_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nPunBrowseType,$tPunBrowseOption){
        $nMsgResp   = array('title'=>"asdasd");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave               = FCNaHBtnSaveActiveHTML('settingUrlFormat/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventUrl	    = FCNaHCheckAlwFunc('settingUrlFormat/0/0');

        $this->load->view('settingconfig/settingurlformat/wUrlFormat', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nPunBrowseType'    => $nPunBrowseType,
            'tPunBrowseOption'  => $tPunBrowseOption,
            'aAlwEventUrl'  => $aAlwEventUrl
        ));
    }

    //Functionality : Function Call Product Unit Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 13/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCURLListPage(){
        $aAlwEventUrl	    = FCNaHCheckAlwFunc('settingUrlFormat/0/0');
        $this->load->view('settingconfig/settingurlformat/wUrlFormatList',array(
            'aAlwEventUrl'  =>  $aAlwEventUrl
        ));
    }

    //Functionality : Function Call DataTables Product Unit
    //Parameters : Ajax Call View DataTable
    //Creator : 13/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCURLDataList(){
        try{
            $tSearchAll = $this->input->post('tSearchAll');
            $nPage      = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 15,
                'FNLngID'       => $nLangResort,
                'tSearchAll'    => $tSearchAll,
            );
            $aUrlDataList           = $this->Settingurlformat_model->FSaMURLList($aData);
            $aAlwEventUrl	    = FCNaHCheckAlwFunc('SettingURLFormat/0/0');
            $aGenTable  = array(
                'aUrlDataList'          => $aUrlDataList,
                'nPage'                 => $nPage,
                'tSearchAll'            => $tSearchAll,
                'aAlwEventUrl'      => $aAlwEventUrl
            );
            $this->load->view('settingconfig/settingurlformat/wUrlFormatDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    public function FSvCURLCheckStaUse(){
        try{
            $tAngCode = $this->input->post('oetBchAgnCode');
            $aUrlDataList  = $this->Settingurlformat_model->FSoMURLCheckStaUse($tAngCode);
            echo json_encode($aUrlDataList);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Unit Add
    //Parameters : Ajax Call View Add
    //Creator : 13/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCURLAddPage(){
        try{
            $aDataUrl = array(
                'nStaAddOrEdit'   => 99
            );
            $this->load->view('settingconfig/settingurlformat/wUrlFormatAdd',$aDataUrl);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Unit Edit
    //Parameters : Ajax Call View Edit
    //Creator : 13/09/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCURLEditPage(){
        try{
            $tUrlCode       = $this->input->post('tUrlCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");

            $aData  = array(
                'FTFspCode' => $tUrlCode,
                'FNLngID'   => $nLangEdit
            );

            $aURLData       = $this->Settingurlformat_model->FSaMURLGetDataByID($aData);
            $aDataURL     = array(
                'nStaAddOrEdit' => 1,
                'raResult'      => $aURLData
            );
            $this->load->view('settingconfig/settingurlformat/wUrlFormatAdd',$aDataURL);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Add Product Unit
    //Parameters : Ajax Event
    //Creator : 13/09/2018 wasin
    //Update : 23/08/2019 Saharat(Golf)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCURLAddEvent(){
        try{
            $tIsAutoGenCode = $this->input->post('ocbUrlAutoGenCode');
            $tUrlCode = "";
            if(isset($tIsAutoGenCode) && $tIsAutoGenCode == '1'){
                // Update new gencode
                // 15/05/2020 Napat(Jame)
                $aStoreParam = array(
                    "tTblName"    => 'TCNMFmtRteSpc',
                    "tDocType"    => 0,
                    "tBchCode"    => "",
                    "tShpCode"    => "",
                    "tPosCode"    => "",
                    "dDocDate"    => date("Y-m-d")
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $tUrlCode   = $aAutogen[0]["FTXxhDocNo"];

            }else{
                $tUrlCode = $this->input->post('oetUrlCode');
            }

            $aUrlData   = array(
                'FTFspCode'     => $tUrlCode,
                'FTFmtCode'     => $this->input->post('oetUrlFormatCode'),
                'FTFspStaUse'   => $this->input->post('ocmUrlStaActive'),
                'FTAgnCode'     => $this->input->post('oetBchAgnCode'),
                'FTBchCode'     => $this->input->post('oetBchCode'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
            );
       

            $oCountDup      = $this->Settingurlformat_model->FSnMURLCheckDuplicate($aUrlData['FTFspCode']);
            $nStaDup        = $oCountDup['counts'];
            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaDptMaster  = $this->Settingurlformat_model->FSaMCTYAddUpdateMaster($aUrlData);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aUrlData['FTFspCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add'
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

    //Functionality : Event Edit Product Unit
    //Parameters : Ajax Event
    //Creator : 13/09/2018 wasin
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCURLEditEvent(){
        try{
            $aDataUrl   = array(
                'FTFspCode'     => $this->input->post('oetUrlCode'),
                'FTFmtCode'     => $this->input->post('oetUrlFormatCode'),
                'FTFspStaUse'   => $this->input->post('ocmUrlStaActive'),
                'FTAgnCode'     => $this->input->post('oetBchAgnCode'),
                'FTBchCode'     => $this->input->post('oetBchCode'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
            );
            $this->db->trans_begin();
            $aStaPunMaster  = $this->Settingurlformat_model->FSaMCTYAddUpdateMaster($aDataUrl);
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataUrl['FTFspCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Delete Product Unit
    //Parameters : Ajax jReason()
    //Creator : 13/09/2018 wasin
    //Update : 1/4/2019 Pap
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCURLDeleteEvent(){
        $tAngCodeHide = $this->session->userdata('tSesUsrAgnCode');
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTFspCode' => $tIDCode
        );
        $aResDel        = $this->Settingurlformat_model->FSaMPUNDelAll($aDataMaster);
        $nNumRowUrlFmt = $this->Settingurlformat_model->FSnMPUNGetAllNumRow($tAngCodeHide);
        if($nNumRowUrlFmt!==false){
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
                'nNumRowUrlFmt' => $nNumRowUrlFmt
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
    }


    





































































}  