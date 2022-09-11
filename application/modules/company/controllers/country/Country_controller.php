<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Country_controller extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('company/country/Country_model');
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
        $vBtnSave               = FCNaHBtnSaveActiveHTML('country/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventCty	    = FCNaHCheckAlwFunc('country/0/0');

        $this->load->view('company/country/wCountry', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nPunBrowseType'    => $nPunBrowseType,
            'tPunBrowseOption'  => $tPunBrowseOption,
            'aAlwEventCty'  => $aAlwEventCty
        ));
    }

    //Functionality : Function Call Product Unit Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 13/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCCTYListPage(){
        $aAlwEventCty	    = FCNaHCheckAlwFunc('country/0/0');
        $this->load->view('company/country/wCountryList',array(
            'aAlwEventCty'  =>  $aAlwEventCty
        ));
    }

    //Functionality : Function Call DataTables Product Unit
    //Parameters : Ajax Call View DataTable
    //Creator : 13/09/2018 wasin
    //Return : String View
    //Return Type : ViewoetCtyRef
    public function FSvCCTYDataList(){
        try{
            $tSearchAll = $this->input->post('tSearchAll');
            $nPage      = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata('tLangID');
            $aLangHave      = FCNaHGetAllLangByTable('TCNMCountry_L');
            @$nLangHave      = count($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = 1;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }
            
            $tAgnLang = $this->Country_model->FSnMCTYGetLangAgent();
            $tLangLocal = $this->Country_model->FSnMCTYGetLangLocal();
            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 15,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll,
                'tLangLocal'    => $tLangLocal,
                'tAgnLangCode'  => $tAgnLang,
            );
            $aPunDataList           = $this->Country_model->FSaMCTYList($aData);
            $aAlwEventCty	    = FCNaHCheckAlwFunc('country/0/0');
            $aGenTable  = array(
                'aPunDataList'          => $aPunDataList,
                'nPage'                 => $nPage,
                'tSearchAll'            => $tSearchAll,
                'aAlwEventCty'          => $aAlwEventCty,
                

            );
            $this->load->view('company/country/wCountryDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Unit Add
    //Parameters : Ajax Call View Add
    //Creator : 13/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCCTYAddPage(){
        try{
            $aDataPdtUnit = array(
                'nStaAddOrEdit'   => 99
            );
            $this->load->view('company/country/wCountryAdd',$aDataPdtUnit);
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
    public function FSvCCTYEditPage(){
        try{
            $tCtyCode       = $this->input->post('tCtyCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMCountry_L');
            @$nLangHave      = count($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }
            $tAgnLang = $this->Country_model->FSnMCTYGetLangAgent();
            $tLangLocal = $this->Country_model->FSnMCTYGetLangLocal();
            $aData  = array(
                'FTCtyCode' => $tCtyCode,
                'FNLngID'   => $nLangEdit,
                'tLangLocal'    => $tLangLocal,
                'tAgnLangCode'  => $tAgnLang,
            );

            $aCtyData       = $this->Country_model->FSaMCTYGetDataByID($aData);
            $aDataCty      = array(
                'nStaAddOrEdit' => 1,
                'raResult'      => $aCtyData
            );
            $this->load->view('company/country/wCountryAdd',$aDataCty);
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
    public function FSoCCTYAddEvent(){
        try{
            $nLangEdit      = $this->session->userdata("tLangEdit"); 
            $tIsAutoGenCode = $this->input->post('ocbCtyAutoGenCode');
            $tCtyCode = "";
            if(isset($tIsAutoGenCode) && $tIsAutoGenCode == '1'){
                // Update new gencode
                // 15/05/2020 Napat(Jame)
                $aStoreParam = array(
                    "tTblName"    => 'TCNMCountry',
                    "tDocType"    => 0,
                    "tBchCode"    => "",
                    "tShpCode"    => "",
                    "tPosCode"    => "",
                    "dDocDate"    => date("Y-m-d")
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $tCtyCode   = $aAutogen[0]["FTXxhDocNo"];

            }else{
                $tCtyCode = $this->input->post('oetCtyCode');
            }

            $aDataCty   = array(
                'FTCtyCode'     => $tCtyCode,
                'FTCtyName'     => $this->input->post('oetCtyName'),
                'FTCtyStaUse'   => $this->input->post('ocmCtyStaActive'),
                'FTCtyStaCtrlRate'  => $this->input->post('ocmExcRte'),
                'FTVatCode'     => $this->input->post('oetVatCode'),
                'FTRteIsoCode'  => $this->input->post('oetRteCode'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->input->post("oetCtyLangID"),
                'FTCtyLongitude' => $this->input->post('oetCtyLon'),
                'FTCtyLatitude' => $this->input->post('oetCtyLa'),
                'FTCtyRefID'    => $this->input->post('oetCtyRef'),
                'langEdit'      => $nLangEdit,
            );
            $oCountDup      = $this->Country_model->FSnMCTYCheckDuplicate($aDataCty['FTCtyCode']);
            $nStaDup        = $oCountDup['counts'];
            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaDptMaster  = $this->Country_model->FSaMCTYAddUpdateMaster($aDataCty);
                $aStaDptLang    = $this->Country_model->FSaMCTYAddUpdateLang($aDataCty);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Product Unit"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataCty['FTCtyCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Product Unit'
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
    public function FSoCCTYEditEvent(){
        try{
            $nLangEdit      = $this->session->userdata("tLangEdit"); 
            $aDataPdtUnit   = array(
                'FTCtyCode'     => $this->input->post('oetCtyCode'),
                'FTCtyName'     => $this->input->post('oetCtyName'),
                'FTCtyStaUse'   => $this->input->post('ocmCtyStaActive'),
                'FTVatCode'     => $this->input->post('oetVatCode'),
                'FTCtyStaCtrlRate'  => $this->input->post('ocmExcRte'),
                'FTRteIsoCode'  => $this->input->post('oetRteCode'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->input->post("oetCtyLangID"),
                'FTCtyLongitude' => $this->input->post('oetCtyLon'),
                'FTCtyLatitude' => $this->input->post('oetCtyLa'),
                'FTCtyRefID'    => $this->input->post('oetCtyRef'),
                'langEdit'      => $nLangEdit,
            );
            $this->db->trans_begin();
            $aStaPunMaster  = $this->Country_model->FSaMCTYAddUpdateMaster($aDataPdtUnit);
            $aStaPunLang    = $this->Country_model->FSaMCTYAddUpdateLang($aDataPdtUnit);
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit Product Unit"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataPdtUnit['FTCtyCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit Product Unit'
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
    public function FSoCCTYDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTCtyCode' => $tIDCode
        );
        $aResDel        = $this->Country_model->FSaMPUNDelAll($aDataMaster);
        $nNumRowCty = $this->Country_model->FSnMPUNGetAllNumRow();
        if($nNumRowCty!==false){
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
                'nNumRowCty' => $nNumRowCty
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
    }


    





































































}  