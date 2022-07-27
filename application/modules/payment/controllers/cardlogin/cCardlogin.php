<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cCardlogin extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('company/branch/mBranch');
        $this->load->model('payment/card/mCard');
        $this->load->model('payment/cardlogin/mCardlogin');
   
    }

    //Functionality : Function Call Page Main
	//Parameters : From Ajax File Userlogin
	//Creator : 25/11/2019 Witsarut (Bell)
	//Last Modified : -
	//Return : String View
	//Return Type : View
    public function FSvCCardloginMainPage(){

        $vBtnSaveGpCrdlogin    = FCNaHBtnSaveActiveHTML('card/0/0');
        $aAlwEventCrdlogin     = FCNaHCheckAlwFunc('card/0/0');

        // Get CardCode
         $tCrdCode = $this->input->post('tCrdCode');

        $aCrdCode   = array(
          'tCrdCode'   => $tCrdCode
        );

        $this->load->view('payment/cardlogin/wCardloginMain',array(
            'vBtnSaveGpCrdlogin' => $vBtnSaveGpCrdlogin,
            'aAlwEventCrdlogin'  => $aAlwEventCrdlogin,
            'aCrdCode'           => $aCrdCode
        ));
    }


    //Functionality : List Data 
	//Parameters : From Ajax File Cardlogin
	//Creator : 25/11/2019 Witsarut (Bell)
	//Last Modified : -
	//Return : String View
	//Return Type : View
    public function FSvCCardLogDataList(){

        $tCrdCode    = $this->input->post('tCrdCode');
        $nPage       = $this->input->post('nPageCurrent');
        $tSearchAll  = $this->input->post('tSearchAll');

        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage  = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        //สิทธิ
        $aAlwEventCrdlogin   = FCNaHCheckAlwFunc('card/0/0');

        $aData = array(
            'FTCrdCode'    => $tCrdCode,
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll,
        );

        $aResList    = $this->mCardlogin->FSaMCRDLDataList($aData);

        $aGenTable      = array(
            'aDataList'   => $aResList,
            'nPage'       => $nPage,
            'FTCrdCode'   =>  $tCrdCode,
            'aAlwEventCrdlogin'   =>  $aAlwEventCrdlogin,
        );

        //Return Data View
        $this->load->view('payment/cardlogin/wCardloginDataTable',$aGenTable);
    }

    //Functionality :  Load Page Add CrdLogin 
    //Parameters : 
    //Creator : 26/11/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : HTML View
    //Return Type : View
    public function FSvCCardlogPageAdd(){   
        
        $dGetDataNow    = date('Y-m-d');
        $dGetDataFuture = date('Y-m-d', strtotime('+1 year'));

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $vBtnSaveGpCrdlogin    = FCNaHBtnSaveActiveHTML('cardlogin/0/0');
        $aAlwEventCrdlogin     = FCNaHCheckAlwFunc('cardlogin/0/0');

        $tCrdCode =   $this->input->post('tCrdCode');

        $aCrdCode   = array(
            'tCrdCode'   => $tCrdCode
        );

        $aDataAdd  = array(
            'aResult'   => array('rtCode'=>'99'),
            'vBtnSaveGpCrdlogin' => $vBtnSaveGpCrdlogin,
            'aAlwEventCrdlogin'  => $aAlwEventCrdlogin,
            'dGetDataNow'		 => $dGetDataNow,
            'dGetDataFuture'	 => $dGetDataFuture,
            'aCrdCode'           => $aCrdCode
        );

        $this->load->view('payment/cardlogin/wCardloginAdd',$aDataAdd);
    }    


    //Functionality :  Load Page Edit Courierlogin 
    //Parameters : 
    //Creator : 26/11/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCCardlogPageEdit(){

        $dGetDataNow    = date('Y-m-d');
        $dGetDataFuture = date('Y-m-d', strtotime('+1 year'));
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aAlwEventCrdlogin  = FCNaHCheckAlwFunc('cardlogin/0/0');

        $aData  = array(
            'FTCrdCode'  =>  $this->input->post('tCrdCode'),
            'FTCrdLogin' =>  $this->input->post('tCrdLogin'),
            'FNLngID' =>  $nLangEdit
        );

        $aResult    = $this->mCardlogin->FSaMCRDLCheckID($aData);

        $aCrdCode   = array(
            'tCrdCode'   => $this->input->post('tCrdCode'),
        );

        $aDataEdit = array(
            'aResult'           => $aResult,  
            'aAlwEventCrdlogin' => $aAlwEventCrdlogin,
            'dGetDataNow'       => $dGetDataNow,
            'dGetDataFuture'    => $dGetDataFuture,
            'aCrdCode'          => $aCrdCode
        );

        $this->load->view('payment/cardlogin/wCardloginAdd',$aDataEdit);
    }

    //Functionality : Function Add Cardlogin
    //Parameters : From Ajax File Cardlogin
    //Creator : 26/11/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaCCardlogAddEvent(){
        try{

            date_default_timezone_set("Asia/Bangkok");
            $tCrdLogin     = "";
            $tCrdLoginPwd  = "";

            $tCrdLogin      =  $this->input->post('oetidCrdlogin');
            $tCrdLoginPwd   =  $this->input->post('oetCrdloginPasswordOld');

            $aDataMaster      = array(
                'FTCrdCode'         => $this->input->post('ohdCrdLogCode'),
                'FTCrdLogType'      => $this->input->post('ocmlogintype'), 
                'FDCrdPwdStart'     => $this->input->post('oetCrdlogStart')." ".date('H:i:s'),
                'FDCrdPwdExpired'   => $this->input->post('oetCrdlogStop')." ".date('H:i:s'),
                'FTCrdLogin'        => $tCrdLogin,
                'FTCrdLoginPwd'     => $tCrdLoginPwd,
                'FTCrdRmk'          => $this->input->post('oetCrdlogRemark'),
                'FTCrdStaActive'    => (!empty($this->input->post('ocbCrdlogStaUse')))? '1':'2',
            );

            $oCountDup  = $this->mCardlogin->FSoMCRDLCheckDuplicate($aDataMaster['FTCrdLogin']);

            if($oCountDup==false){
                $this->db->trans_begin();
                $aStaMaster  = $this->mCardlogin->FSaMCRDLAddUpdateMaster($aDataMaster);

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
                        'tCodeReturn'	=> $aDataMaster['FTCrdLogin'],
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
   

    //Functionality : Function Add Cardlogin
    //Parameters : From Ajax File Cardlogin
    //Creator : 26/11/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function  FSaCCardlogEditEvent(){
        try{
            date_default_timezone_set("Asia/Bangkok");
            $tCrdLogin     = "";
            $tCrdLoginPwd  = "";
            $tCrdLogType   = "";
            
            $tCrdTimeStart      = $this->input->post('oetCrdtimestart');
            $tCrdTimeExpire     = $this->input->post('oetCrdtimeExpire');

            if($tCrdTimeStart == "" || $tCrdTimeStart == null ){
                $tCrdTimeStart = date('H:i:s');
            }else{
                $tCrdTimeStart = $tCrdTimeStart;
            }

            if($this->input->post('ohdTypeAddloginType')==0){
                $tCrdLogType = $this->input->post('ocmlogintype');
            }else{
                $tCrdLogType = $this->input->post('ohdTypeAddloginTypeVal');
            }

            $tCrdLogin      = $this->input->post('oetidCrdlogin');
            $tCrdLoginPwd   = $this->input->post('oetCrdloginPasswordOld');

            $aDataMaster  = array(
                'FTCrdCode'         => $this->input->post('ohdCrdLogCode'),
                'FTCrdLogType'      => $tCrdLogType, 
                'FDCrdPwdStart'     => $this->input->post('oetCrdlogStart')." ".$tCrdTimeStart,
                'FDCrdPwdExpired'   => $this->input->post('oetCrdlogStop')." ".$tCrdTimeStart,
                'FTCrdLogin'        => $tCrdLogin,
                'FTCrdLoginPwd'     => $tCrdLoginPwd,
                'FTCrdRmk'          => $this->input->post('oetCrdlogRemark'),
                'FTCrdStaActive'    => (!empty($this->input->post('ocbCrdlogStaUse')))? '1':'2',
            );

            $this->db->trans_begin();
            $aStaMaster  = $this->mCardlogin->FSaMCRDLAddUpdateMaster($aDataMaster);

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
                    'tCodeReturn'	=> $aDataMaster['FTCrdLogin'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            $Error;
        }
    }

    //Functionality : Event Delete Cardlogin
    //Parameters : Ajax jReason()
    //Creator : 26/11/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCCardlogDeleteEvent(){
       $tCrdloginCode  = $this->input->post('tCrdloginCode');
     
       $aDataMaster = array(
            'FTCrdLogin' => $tCrdloginCode
        );

        $aResDel     = $this->mCardlogin->FSnMCRDLDel($aDataMaster);
        $nNumRowRsnLoc  = $this->mCardlogin->FSnMLOCGetAllNumRow();

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

    //Functionality : Delete Cardlogin Ads Multiple
    //Parameters : Ajax jUserlogin()
    //Creator : 26/11/2019 Witsarut
    //Return : array Data Return Status Delete
    //Return Type : array
    public function FSoCCardlogDelMultipleEvent(){
        try{

            $this->db->trans_begin();  

            $aDataDelete    = array(
                'aDataCrdCode'  => $this->input->post('paDataCrdCode'),
                'aDataLogType'  => $this->input->post('paDataLogType'),
                'aDataPwStart'  => $this->input->post('paDataPwStart'),
            );
            $tResult    = $this->mCardlogin->FSaMCRDLDeleteMultiple($aDataDelete);

    
            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $aDataReturn    = array(
                    'nStaEvent' => 500,
                    'tStaMessg' => 'Error Not Delete Data Multiple'
                );
            }else{
                $this->db->trans_commit();
                $aDataReturn     = array(
                    'nStaEvent' => 1,
                    'tStaMessg' => 'Success Delete  Multiple'
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