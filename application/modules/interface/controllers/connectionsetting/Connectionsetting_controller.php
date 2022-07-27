<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Connectionsetting_controller extends MX_Controller {

    
    public function __construct(){
        parent::__construct ();
        $this->load->model('interface/connectionsetting/Connectionsetting_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nBrowseType,$tBrowseOption){
        $aDataSetting = array(
            'nBrowseType'                   => $nBrowseType,
            'tBrowseOption'                 => $tBrowseOption,
            'aAlwEventConnectionSetting'    => FCNaHCheckAlwFunc('ConnectionSetting/0/0'), //Controle Event
            'vBtnSave'                      => FCNaHBtnSaveActiveHTML('ConnectionSetting/0/0'), //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        );
        $this->load->view('interface/connectionsetting/wConnectionsetting',$aDataSetting);

    }

    // Call page list
    // Create WItsarut 28052020
     public function FSvCCCSDataList(){

        $tSearchAllNotSet  = $this->input->post('tSearchAllNotSet');
        $tSearchAllSetUp   = $this->input->post('tSearchAllSetUp');

        $tStaUsrLevel    = $this->session->userdata("tSesUsrLevel");
        $tUsrBchCode     = $this->session->userdata("tSesUsrBchCodeMulti"); 


        $aData = array(
            'FNLngID'           => $this->session->userdata("tLangEdit"),
            'nPageCurrent'      => $this->input->post('nPageCurrent'),
            'tSearchAllNotSet'  => $tSearchAllNotSet,
            'tSearchAllSetUp'   => $tSearchAllSetUp,
            'tStaUsrLevel'      => $tStaUsrLevel,
            'tUsrBchCode'       => $tUsrBchCode,
        );

        $aWaHouseListup      = $this->Connectionsetting_model->FSaMCCSListDataUP($aData);
        $aWaHouseListdown    = $this->Connectionsetting_model->FSaMCCSListDataDown($aData);
        $aAlwEventConnectionSetting = FCNaHCheckAlwFunc('ConnectionSetting/0/0');

        $aDataResult  = [
            'aWaHouseListup'     => $aWaHouseListup,
            'aWaHouseListdown'   => $aWaHouseListdown,
            'aAlwEvent'          => $aAlwEventConnectionSetting,
            'tSearchAllNotSet'   => $tSearchAllNotSet,
            'tSearchAllSetUp'    => $tSearchAllSetUp
        ];

        $this->load->view('interface/connectionsetting/wConnectionsettingWahouse',$aDataResult);

     }   

    //Functionality :  Load Page Add settingWahouse 
    //Parameters : 
    //Creator : 15/05/2020 saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSxCCCSPageWahouse(){

        $this->load->view('interface/connectionsetting/wConnectionsettingWahouse');
    }

    //Functionality :  Load Page Add Wahouse 
    //Parameters : 
    //Creator : 15/05/2020 saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSxCCCSPageAddWahouse(){
        $aAlwEventConnectionSetting = FCNaHCheckAlwFunc('ConnectionSetting/0/0');
        $aDataAdd = [
            'aResult'       => array('rtCode'=>'99'),
            'aAlwEvent'     => $aAlwEventConnectionSetting,
            'tBchCompCode'  => $this->session->userdata("tSesUsrBchCodeDefault"),
            'tBchCompName'  => $this->session->userdata("tSesUsrBchNameDefault"),
            'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
            'tSesAgnName'   => $this->session->userdata("tSesUsrAgnName"),
        ];

        $this->load->view('interface/connectionsetting/wConnectionsettingAdd',$aDataAdd);

    }

    //Functionality : Event Add settingWahouse
    //Parameters : Ajax jConnectionSetting()
    //Creator : 15/05/202020 saharat(Golf)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSxCCCSWahouseEventAdd(){
        try{
           
            $aDataMaster        = [
                'FTAgnCode'         => $this->input->post('oetCssAgnCode'),
                'FTBchCode'         => $this->input->post('oetCssBchCode'),
                'FTWahCode'         => $this->input->post('oetCssWahCode'),
                'FTWahRefNo'        => $this->input->post('oetCssWahRefNo'),
                'FTWahRemark'       => $this->input->post('otaLKWahRemark'),
                // 'FTWahStaChannel'   => $this->input->post('ocmStaChannel'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTCreateBy'        => $this->session->userdata('tSesUsername')
            ];
            
                $this->db->trans_begin();
                $aStaEventMaster  = $this->Connectionsetting_model->FSaMCSSAddUpdateMaster($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }
       
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality :  Load Page settingWahouse
    //Parameters : 
    //Creator : 15/05/2020 saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSxCCCSWahousePageEdit(){
        $aData  = [
            'FTAgnCode' => $this->input->post('tMerCode'),
            'FTBchCode' => $this->input->post('tBchCode'),
            'FTWahCode' => $this->input->post('tWahCode'),
            'FNLngID'   => $this->session->userdata("tLangEdit")
        ];

        $aResult        = $this->Connectionsetting_model->FSaMCCGetDataDown($aData);
        $aDataEdit  = [
            'aResult'    => $aResult,
            'aAlwEvent'  => FCNaHCheckAlwFunc('ConnectionSetting/0/0')
        ];

        $this->load->view('interface/connectionsetting/wConnectionsettingAdd',$aDataEdit);

    }
    

    //Functionality : Event Edit settingWahouse
    //Parameters : Ajax jConnectionSetting()
    //Creator : 15/05/2020 saharat(Golf)
    //Last Modified : -
    //Return : Status Edit Event
    //Return Type : View 
    public function FSxCCCSWahouseEventEdit(){
        try{
           
            $aDataMaster        = [
                'FTAgnCode'         => $this->input->post('oetCssAgnCode'),
                'FTBchCode'         => $this->input->post('oetCssBchCode'),
                'FTWahCode'         => $this->input->post('oetCssWahCode'),
                'FTWahRefNo'        => $this->input->post('oetCssWahRefNo'),
                // 'FTWahStaChannel'   => $this->input->post('ocmStaChannel'),
                'FTWahRemark'        => $this->input->post('otaLKWahRemark'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTCreateBy'        => $this->session->userdata('tSesUsername')
            ];
            
                $this->db->trans_begin();
                $aStaEventMaster  = $this->Connectionsetting_model->FSaMCSSAddUpdateMaster($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }
       
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Delete Siggle
	//Parameters : From Ajax File Userlogin
	//Creator : 04/07/2020 Witsarut (Bell)
	//Last Modified : -
	//Return : String View
	//Return Type : View
    public function FSaCCCSDeleteEvent(){

       $tAgnCode  = $this->input->post('tAgnCode');
       $tBchCode  = $this->input->post('tBchCode');
       $tWahCode  = $this->input->post('tWahCode');


        $aDataDel  = array(
            'FTAgnCode'   => $tAgnCode,
            'FTBchCode'   => $tBchCode,
            'FTWahCode'   => $tWahCode
        );

         $aResult       =  $this->Connectionsetting_model->FSnMConnSetDel($aDataDel);
         $nNumRowRsnLoc  = $this->Connectionsetting_model->FSnMLOCGetAllNumRow();

         if($nNumRowRsnLoc){
            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'nNumRowRsnLoc' => $nNumRowRsnLoc
            );
            echo json_encode($aReturn);
        }else{
            echo "database error";
        }

    }

    //Parameters : Ajax jUserlogin()
    //Creator : 20/08/2019 Witsarut
    //Return : array Data Return Status Delete
    //Return Type : array
    public function FSaCCCSDelMultipleEvent(){
        try{
            $this->db->trans_begin();

            $aDataDelete    = array(
                'aDataAgnCode'  => $this->input->post('paDataAgnCode'),
                'aDataMerCode'  => $this->input->post('paDataMerCode'),
                'aDataWahCode'  => $this->input->post('paDataWahCode'),
            );

            $tResult    = $this->Connectionsetting_model->FSaMConnDeleteMultiple($aDataDelete);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $aDataReturn    = array(
                    'nStaEvent' => 500,
                    'tStaMessg' => 'Error Not Delete Data Pos Ads Multiple'
                );
            }else{
                $this->db->trans_commit();
                $aDataReturn     = array(
                    'nStaEvent' => 1,
                    'tStaMessg' => 'Success Delete Pos Ads Multiple'
                );
            }
        }catch(Exception $Error){
            $aDataReturn     = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error
            );
        }
        echo json_encode($aDataReturn);
    }


    










}    
?>

