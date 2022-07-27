<?php 
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Promotion_controller extends MX_Controller {

	public function __construct() {
            parent::__construct ();
            $this->load->model('document/promotion/Promotion_model');
    }

    public function index($nBrowseType, $tBrowseOption){

        $aData['nBrowseType']           = $nBrowseType;
        $aData['tBrowseOption']         = $tBrowseOption;
        $aData['aAlwEventPromotion']    = FCNaHCheckAlwFunc('promotion/0/0'); //Controle Event
        $aData['vBtnSave']              = FCNaHBtnSaveActiveHTML('promotion/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        
        $this->load->view('document/promotion/wPromotion', $aData);

    }

    public function FSCopter(){
        
        $this->load->view('document/promotion/wCopter');
    }


    public function FSxCPMTPageTSysList(){

        $aDataAdd = array(
            'aResult'   => array('rtCode'=>'99')
        );

        $this->load->view('document/promotion/wPromotionTSysListFormSearchList', $aDataAdd);
    }


    public function FSxCPMTAddPage(){

        $tSpmCode = $this->input->post('tSpmCode');

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TFNMRate_L');
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
            'FNLngID'   => $nLangEdit,
            'tSpmCode'  => $tSpmCode
        );
       
        $aSpmData =  $this->Promotion_model->FSaMPMTTSysPmtSearchByID($aData);

        $aDataAdd = array(
            'aResult'   =>  array('rtCode'=>'99'),
            'tSpmCode'  =>  $tSpmCode,
            'aSpmData'  =>  $aSpmData,
        );

        $this->load->view('document/promotion/wPromotionAdd',$aDataAdd);
    }


    public function FSvCPMTEditPage(){

        $aAlwEventPromotion	= FCNaHCheckAlwFunc('promotion/0/0'); //Controle Event

        $tPmhCode = $this->input->post('tPmhCode');

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TSysPmt_L');
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

        //Data Master
        $aDataEdit  = array(
            'FTPmhCode' => $tPmhCode
        );
        $aResult        = $this->Promotion_model->FSaMPMTGetPdtPmtHD($aDataEdit); // Data TCNTPdtPmtHD Promotion
        $aResultPmtCD   = $this->Promotion_model->FSaMPMTPdtPmtCD($aDataEdit); // Data TCNTPdtPmtCD Condition
        $aResultPmtDT   = $this->Promotion_model->FSaMPMTPdtPmtDT($aDataEdit); // Data TCNTPdtPmtDT Detail
        $aResultPmtGrpBoth = $this->Promotion_model->FSaMPMTPdtPmtDTGrpBoth($aDataEdit); // Data TCNTPdtPmtDT GrpBoth Only

        $tSpmCode = $aResult['raItems']['rtSpmCode'];

        //Data TSysPmt Master
        $aDataTSysPmt  = array(
            'FNLngID'   => $nLangEdit,
            'tSpmCode'  => $tSpmCode
        );
        $aSpmData =  $this->Promotion_model->FSaMPMTTSysPmtSearchByID($aDataTSysPmt);

        $aDataPmhEdit = array(  'aResult'               =>  $aResult,
                                'aResultPmtCD'          =>  $aResultPmtCD,
                                'aResultPmtDT'          =>  $aResultPmtDT,
                                'aResultPmtGrpBoth'     =>  $aResultPmtGrpBoth,
                                'aAlwEventPromotion'    =>  $aAlwEventPromotion,
                                'aSpmData'              =>  $aSpmData,
                                'tSpmCode'              =>  $tSpmCode,
                            );
        $this->load->view('document/promotion/wPromotionAdd',$aDataPmhEdit);

    }

    public function FSxCPMTFormSearchList(){
        $this->load->view('document/promotion/wPromotionFormSearchList');
    }
    
    /**
     * Functionality : Event Add Promotion
     * Parameters : Ajax jReason()
     * Creator : 03/07/2018 Copter(Krit)
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCPMTAddEvent(){

        // $tSpmStaRcvFree = $this->FSsCReturnCheckBox($this->input->post('ocbSpmStaRcvFree'));

        try{

                $aDataMaster = array(

                    'FTBchCode'             => $this->session->userdata('tSesUsrBchCode'),    
                    'FTPmhCode'             => $this->input->post('oetPmhCode'),
                    'FTPmhName'             => $this->input->post('oetPmhName'),
                    'FTPmhNameSlip'         => $this->input->post('oetPmhNameSlip'),
                    'FTSpmCode'             => $this->input->post('oetSpmCode'),
                    'FTSpmType'             => $this->input->post('oetSpmType'),
                    'FDPmhDStart'           => $this->input->post('oetPmhDStart'),
                    'FDPmhDStop'            => $this->input->post('oetPmhDStop'),
                    'FDPmhTStart'           => $this->input->post('oetPmhTStart'),
                    'FDPmhTStop'            => $this->input->post('oetPmhTStop'),
                    'FTPmhClosed'           => '',
                    'FTPmhStatus'           => '',
                    'FTPmhRetOrWhs'         => $this->input->post('ostPmhRetOrWhs'),
                    'FTPmhRmk'              => $this->input->post('oetPmhRmk'),
                    'FTPmhStaPrcDoc'        => '',
                    'FNPmhStaAct'           => '',
                    'FTUsrCode'             => $this->input->post('oetPmhUsrCode'),
                    'FTPmhApvCode'          => '',
                    'FTPmhBchTo'            => $this->input->post('oetPmhBchTo'),
                    'FTPmhZneTo'            => $this->input->post('oetPmhZneTo'),
                    'FTPmhStaExceptPmt'     => $this->FSsCReturnCheckBox($this->input->post('ocbPmhStaExceptPmt')),
                    'FTSpmStaRcvFree'       => $this->FSsCReturnCheckBox($this->input->post('ocbSpmStaRcvFree')),
                    'FTSpmStaAlwOffline'    => $this->FSsCReturnCheckBox($this->input->post('ocbSpmStaAlwOffline')),
                    'FTSpmStaChkLimitGet'   => $this->FSsCReturnCheckBox($this->input->post('ocbSpmStaChkLimitGet')),
                    'FNPmhLimitNum'         => $this->input->post('oetPmhLimitNum'), 
                    'FTPmhStaLimit'         => $this->input->post('oetPmhStaLimit'),
                    'FTPmhStaLimitCst'      => $this->input->post('oetPmhStaLimitCst'),
                    'FTSpmStaChkCst'        => $this->FSsCReturnCheckBox($this->input->post('ocbSpmStaChkCst')),
                    'FNPmhCstNum'           => $this->input->post('oetPmhCstNum'),
                    'FTSpmStaChkCstDOB'     => $this->FSsCReturnCheckBox($this->input->post('ocbSpmStaChkCstDOB')),
                    'FNPmhCstDobNum'        => $this->input->post('oetPmhCstDobNum'),
                    'FNPmhCstDobPrev'       => $this->input->post('oetPmhCstDobPrev'),
                    'FNPmhCstDobNext'       => $this->input->post('oetPmhCstDobNext'),
                    'FTSpmStaUseRange'      => '',
                    'FTPmgCode'             => $this->input->post('oetPmgCode'),
                    'FTSplCode'             => $this->input->post('oetSplCode'),
                    'FDPntSplStart'         => $this->input->post('oetPntSplStart'),
                    'FDPntSplExpired'       => $this->input->post('oetPntSplExpired'),
                    'FTAggCode'             => '',
                    
                    'FDDateIns'             => date('Y-m-d'),
                    'FDDateUpd'             => date('Y-m-d'),
                    'FTTimeIns'             => date('h:i:s'),
                    'FTTimeUpd'             => date('h:i:s'),
                    'FTWhoIns'              => $this->session->userdata('tSesUsername'),
                    'FTWhoUpd'              => $this->session->userdata('tSesUsername'),
                );

                $oCountDup  = $this->Promotion_model->FSnMPMTCheckDuplicate($aDataMaster['FTPmhCode']);
                $nStaDup    = $oCountDup[0]->counts;
                // print_r($aDataMaster);
                $nSeq = 0;
                if($nStaDup == 0){

                    $this->db->trans_begin();

                    //Master Pmt
                    $aStaEventMaster  = $this->Promotion_model->FSaMPMTAddUpdatePmtHD($aDataMaster);
                    //Master Pmt

                    //Save DT
                    $aCondition     =   $this->input->post('ohdCondition');
                    $aGrpBuy        =   $this->input->post('ohdGrpBuy');
                    $aGrpJoin       =   $this->input->post('ohdGrpJoin');
                    $aGrpRcv        =   $this->input->post('ohdGrpRcv');
                    $aGrpBothItem   =   $this->input->post('oetGrpBothItem');
                    $aGrpReject     =   $this->input->post('ohdGrpReject');    
                    
                    $aStaAddPmtDT = $this->FSaMPMTAddPmtDT($aCondition,$aGrpBuy,$aGrpJoin,$aGrpRcv,$aGrpBothItem,$aGrpReject);
                    //Save DT

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
                            'tCodeReturn'	=> $aDataMaster['FTPmhCode'],
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
     * Functionality : Event Edit Promotion
     * Parameters : Ajax jReason()
     * Creator : 23/07/2018 Krit(Krit)
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCPMTEditEvent(){

        // $tSpmStaRcvFree = $this->FSsCReturnCheckBox($this->input->post('ocbSpmStaRcvFree'));
 
        try{
                $aDataMaster = array(

                    'FTBchCode'             => $this->session->userdata('tSesUsrBchCode'),    
                    'FTPmhCode'             => $this->input->post('oetPmhCode'),
                    'FTPmhName'             => $this->input->post('oetPmhName'),
                    'FTPmhNameSlip'         => $this->input->post('oetPmhNameSlip'),
                    'FTSpmCode'             => $this->input->post('oetSpmCode'),
                    'FTSpmType'             => $this->input->post('oetSpmType'),
                    'FDPmhDStart'           => $this->input->post('oetPmhDStart'),
                    'FDPmhDStop'            => $this->input->post('oetPmhDStop'),
                    'FDPmhTStart'           => $this->input->post('oetPmhTStart'),
                    'FDPmhTStop'            => $this->input->post('oetPmhTStop'),
                    'FTPmhClosed'           => '',
                    'FTPmhStatus'           => '',
                    'FTPmhRetOrWhs'         => $this->input->post('ostPmhRetOrWhs'),
                    'FTPmhRmk'              => $this->input->post('oetPmhRmk'),
                    'FTPmhStaPrcDoc'        => '',
                    'FNPmhStaAct'           => '',
                    'FTUsrCode'             => $this->input->post('oetPmhUsrCode'),
                    'FTPmhApvCode'          => '',
                    'FTPmhBchTo'            => $this->input->post('oetPmhBchTo'),
                    'FTPmhZneTo'            => $this->input->post('oetPmhZneTo'),
                    'FTPmhStaExceptPmt'     => $this->FSsCReturnCheckBox($this->input->post('ocbPmhStaExceptPmt')),
                    'FTSpmStaRcvFree'       => $this->FSsCReturnCheckBox($this->input->post('ocbSpmStaRcvFree')),
                    'FTSpmStaAlwOffline'    => $this->FSsCReturnCheckBox($this->input->post('ocbSpmStaAlwOffline')),
                    'FTSpmStaChkLimitGet'   => $this->FSsCReturnCheckBox($this->input->post('ocbSpmStaChkLimitGet')),
                    'FNPmhLimitNum'         => $this->input->post('oetPmhLimitNum'), 
                    'FTPmhStaLimit'         => $this->input->post('oetPmhStaLimit'),
                    'FTPmhStaLimitCst'      => $this->input->post('oetPmhStaLimitCst'),
                    'FTSpmStaChkCst'        => $this->FSsCReturnCheckBox($this->input->post('ocbSpmStaChkCst')),
                    'FNPmhCstNum'           => $this->input->post('oetPmhCstNum'),
                    'FTSpmStaChkCstDOB'     => $this->FSsCReturnCheckBox($this->input->post('ocbSpmStaChkCstDOB')),
                    'FNPmhCstDobNum'        => $this->input->post('oetPmhCstDobNum'),
                    'FNPmhCstDobPrev'       => $this->input->post('oetPmhCstDobPrev'),
                    'FNPmhCstDobNext'       => $this->input->post('oetPmhCstDobNext'),
                    'FTSpmStaUseRange'      => '',
                    'FTPmgCode'             => $this->input->post('oetPmgCode'),
                    'FTSplCode'             => $this->input->post('oetSplCode'),
                    'FDPntSplStart'         => $this->input->post('oetPntSplStart'),
                    'FDPntSplExpired'       => $this->input->post('oetPntSplExpired'),
                    'FTAggCode'             => '',
                    
                    'FDDateIns'             => date('Y-m-d'),
                    'FDDateUpd'             => date('Y-m-d'),
                    'FTTimeIns'             => date('h:i:s'),
                    'FTTimeUpd'             => date('h:i:s'),
                    'FTWhoIns'              => $this->session->userdata('tSesUsername'),
                    'FTWhoUpd'              => $this->session->userdata('tSesUsername'),
                );

                $this->db->trans_begin();
                    $aStaDstMaster  = $this->Promotion_model->FSaMPMTAddUpdatePmtHD($aDataMaster);

                    $aCondition     =   $this->input->post('ohdCondition');
                    $aGrpBuy        =   $this->input->post('ohdGrpBuy');   
                    $aGrpJoin       =   $this->input->post('ohdGrpJoin');
                    $aGrpRcv        =   $this->input->post('ohdGrpRcv');  
                    $aGrpBothItem   =   $this->input->post('oetGrpBothItem');
                    $aGrpReject     =   $this->input->post('ohdGrpReject');    
                    
                    $aStaAddPmtDT = $this->FSaMPMTAddPmtDT($aCondition,$aGrpBuy,$aGrpJoin,$aGrpRcv,$aGrpBothItem,$aGrpReject);

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
                            'tCodeReturn'	=> $aDataMaster['FTPmhCode'],
                            'nStaEvent'	    => '1',
                            'tStaMessg'		=> 'Success Add Event'
                        );
                    }
                    echo json_encode($aReturn);



            
                // if($aStaAddPmtDT == 0){

                   
                // }else{
                //     $aReturn = array(
                //         'nStaEvent'    => '801',
                //         'tStaMessg'    => "Data Code Duplicate"
                //     );
                // }
            

            // echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
   
    }



    public function FSaMPMTAddPmtDT($paCondition,$paGrpBuy,$paGrpJoin,$paGrpRcv,$paGrpBothItem,$paGrpReject){

        $nSpmStaBuy    =  $this->input->post('ohdSpmStaBuy');    
        $tPmhBchTo     = $this->input->post('oetPmhBchTo');
        $tPmhCode      = $this->input->post('oetPmhCode');
        $tSpmCode      = $this->input->post('oetSpmCode');
         
        $aStaEventDelCD =  $this->Promotion_model->FSnMPMTDelPmtCD($tPmhCode); /*ลบ Data เก่าออก*/
        $aStaEventDelDT =  $this->Promotion_model->FSnMPMTDelPmtDT($tPmhCode); //*ลบ Data เก่าออก*/

         //GrpName
         $tPmdGrpBuyNameCurrent     = $this->input->post('ohdPmdGrpBuyNameCurrent');
         $tPmdGrpJoinName           = $this->input->post('ohdPmdGrpJoinName');
         $tPmdGrpRcvName            = $this->input->post('ohdPmdGrpRcvName');
         $tPmdGrpRejectName         = $this->input->post('ohdPmdGrpRejectName');
         

         $nSeq = 0;
         //Condition 
         $aCondition     =  $paCondition;
         $nNumCondition  =  count($aCondition);

         for($i=0;$i<$nNumCondition;$i++){

             $aConditionExploded = explode(",",$aCondition[$i]);

             if($nSpmStaBuy == 3 || $nSpmStaBuy == 4){
                 $cPmcBuyQty = $aConditionExploded[6];
                 $cPmcBuyAmt = 0;
             }else if($nSpmStaBuy == 1 || $nSpmStaBuy == 2){
                 $cPmcBuyQty = 0;
                 $cPmcBuyAmt = $aConditionExploded[6];
             }


             $aDataCondition = array(

                 'FTBchCode'             => $tPmhBchTo,
                 'FTPmhCode'             => $tPmhCode,
                 'FNPmcSeq'              => floatval($aConditionExploded[0]),
                 'FTSpmCode'             => $tSpmCode,
                 'FTPmcGrpCode'          => $aConditionExploded[11],
                 'FTPmcGrpName'          => $aConditionExploded[1],
                 'FTPmcStaGrpCond'       => $aConditionExploded[2],
                 
                 'FCPmcGetCond'          => floatval($aConditionExploded[6]),
                 'FCPmcBuyAmt'           => floatval($aConditionExploded[7]),
                 'FCPmcBuyQty'           => floatval($aConditionExploded[8]),
                 'FCPmcBuyMinQty'        => floatval($aConditionExploded[9]),
                 'FCPmcBuyMaxQty'        => floatval($aConditionExploded[10]),
                 'FCPmcPerAvgDis'        => floatval($aConditionExploded[3]),
                 'FCPmcGetValue'         => floatval($aConditionExploded[4]),
                 'FCPmcGetQty'           => floatval($aConditionExploded[5]),
                 'FTSpmStaBuy'           => $nSpmStaBuy,
                 'FTSpmStaRcv'           => '',
                 'FTSpmStaAllPdt'        => '',

                 'FDDateIns'             => date('Y-m-d'),
                 'FDDateUpd'             => date('Y-m-d'),
                 'FTTimeIns'             => date('h:i:s'),
                 'FTTimeUpd'             => date('h:i:s'),
                 'FTWhoIns'              => $this->session->userdata('tSesUsername'),
                 'FTWhoUpd'              => $this->session->userdata('tSesUsername'),

             );
             
             $this->db->trans_begin();
             $aStaEventCD = $this->Promotion_model->FSaMPMTAddUpdatePmtCD($aDataCondition);
             if($this->db->trans_status() === false){
                 $this->db->trans_rollback();
             }else{
                 $this->db->trans_commit();
             }
         }
         //Condition 


         
        //Group Buy
        $aGrpBuy =  $paGrpBuy;     
        $nNumGrpBuy = count($aGrpBuy);
        
        for($i=0;$i<$nNumGrpBuy;$i++){

            $aGrpBuyExploded = explode(",",$aGrpBuy[$i]);
            
            $aDataCondition = array(

                'FTBchCode'             => $tPmhBchTo,
                'FTPmhCode'             => $tPmhCode,
                'FNPmdSeq'              => $nSeq+1,
                'FTSpmCode'             => $tSpmCode,
                'FTPmdGrpCode'          => 'GrpBuy',
                'FTPmdGrpType'          => '1',
                'FTPmdGrpName'          => $tPmdGrpBuyNameCurrent,
                'FTPdtCode'             => $aGrpBuyExploded[1],
                'FCPmdSetPriceOrg'      => floatval($aGrpBuyExploded[2]),
                'FTPunCode'             => $aGrpBuyExploded[3],
                
                'FDDateIns'             => date('Y-m-d'),
                'FDDateUpd'             => date('Y-m-d'),
                'FTTimeIns'             => date('h:i:s'),
                'FTTimeUpd'             => date('h:i:s'),
                'FTWhoIns'              => $this->session->userdata('tSesUsername'),
                'FTWhoUpd'              => $this->session->userdata('tSesUsername'),

            );
            $this->db->trans_begin();
            $aStaEventCD = $this->Promotion_model->FSaMPMTAddUpdatePmtDT($aDataCondition);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
            }else{
                $this->db->trans_commit();
            }
            $nSeq = $nSeq+1;
        }
        //Group Buy


        //Group Join
        $aGrpJoin =  $paGrpJoin;     
        $nNumGrpJoin = count($aGrpJoin);

        for($i=0;$i<$nNumGrpJoin;$i++){

            $aGrpJoinExploded = explode(",",$aGrpJoin[$i]);

            $aDataCondition = array(

                'FTBchCode'             => $tPmhBchTo,
                'FTPmhCode'             => $tPmhCode,
                'FNPmdSeq'              => $nSeq+1,
                'FTSpmCode'             => $tSpmCode,
                'FTPmdGrpCode'          => 'GrpJoin',
                'FTPmdGrpType'          => '1',
                'FTPmdGrpName'          => $tPmdGrpJoinName,
                'FTPdtCode'             => $aGrpJoinExploded[1],
                'FCPmdSetPriceOrg'      => floatval($aGrpJoinExploded[2]),
                'FTPunCode'             => $aGrpJoinExploded[3],
                
                'FDDateIns'             => date('Y-m-d'),
                'FDDateUpd'             => date('Y-m-d'),
                'FTTimeIns'             => date('h:i:s'),
                'FTTimeUpd'             => date('h:i:s'),
                'FTWhoIns'              => $this->session->userdata('tSesUsername'),
                'FTWhoUpd'              => $this->session->userdata('tSesUsername'),

            );
            $this->db->trans_begin();
            $aStaEventCD = $this->Promotion_model->FSaMPMTAddUpdatePmtDT($aDataCondition);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
            }else{
                $this->db->trans_commit();
            }
            $nSeq = $nSeq+1;
        }
        //Group Join


        //Group Rcv
        $aGrpRcv =  $paGrpRcv;     
        $nNumGrpRcv = count($aGrpRcv);
        
        for($i=0;$i<$nNumGrpRcv;$i++){

            $aGrpRcvExploded = explode(",",$aGrpRcv[$i]);

            $aDataCondition = array(

                'FTBchCode'             => $tPmhBchTo,
                'FTPmhCode'             => $tPmhCode,
                'FNPmdSeq'              => $nSeq+1,
                'FTSpmCode'             => $tSpmCode,
                'FTPmdGrpCode'          => 'GrpRcv',
                'FTPmdGrpType'          => '1',
                'FTPmdGrpName'          => $tPmdGrpRcvName,
                'FTPdtCode'             => $aGrpRcvExploded[1],
                'FCPmdSetPriceOrg'      => floatval($aGrpRcvExploded[2]),
                'FTPunCode'             => $aGrpRcvExploded[3],
                
                'FDDateIns'             => date('Y-m-d'),
                'FDDateUpd'             => date('Y-m-d'),
                'FTTimeIns'             => date('h:i:s'),
                'FTTimeUpd'             => date('h:i:s'),
                'FTWhoIns'              => $this->session->userdata('tSesUsername'),
                'FTWhoUpd'              => $this->session->userdata('tSesUsername'),

            );
            $this->db->trans_begin();

            $aStaEventCD = $this->Promotion_model->FSaMPMTAddUpdatePmtDT($aDataCondition);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
            }else{
                $this->db->trans_commit();
            }
            $nSeq = $nSeq+1;
        }
        //Group Rcv


        //Group Both
        $aGrpBothItem = $paGrpBothItem;
        $nNumBothItem = count($aGrpBothItem);
        
        for($nItem=0;$nItem<$nNumBothItem;$nItem++){

            $aGrpBoth =  $this->input->post('ohdGrpBoth'.$aGrpBothItem[$nItem]);     
            
            $nNumGrpBoth = count($aGrpBoth);

                for($i=0;$i<$nNumGrpBoth;$i++){

                    $aGrpBothExploded = explode(",",$aGrpBoth[$i]);

                    $aDataGrpBoth = array(

                        'FTBchCode'             => $tPmhBchTo,
                        'FTPmhCode'             => $tPmhCode,
                        'FNPmdSeq'              => $nSeq+1,
                        'FTSpmCode'             => $tSpmCode,
                        'FTPmdGrpCode'          => 'GrpBoth'.$aGrpBothItem[$nItem],
                        'FTPmdGrpType'          => '1',
                        'FTPmdGrpName'          => $this->input->post('ohdPmdGrpBothName'.$aGrpBothItem[$nItem]."Current"),
                        'FTPdtCode'             => $aGrpBothExploded[1],
                        'FCPmdSetPriceOrg'      => floatval($aGrpBothExploded[2]),
                        'FTPunCode'             => $aGrpBothExploded[3],
                        
                        'FDDateIns'             => date('Y-m-d'),
                        'FDDateUpd'             => date('Y-m-d'),
                        'FTTimeIns'             => date('h:i:s'),
                        'FTTimeUpd'             => date('h:i:s'),
                        'FTWhoIns'              => $this->session->userdata('tSesUsername'),
                        'FTWhoUpd'              => $this->session->userdata('tSesUsername'),

                    );

                    $this->db->trans_begin();

                    $aStaEventCD = $this->Promotion_model->FSaMPMTAddUpdatePmtDT($aDataGrpBoth);

                    if($this->db->trans_status() === false){
                        $this->db->trans_rollback();
                    }else{
                        $this->db->trans_commit();
                    }
                    $nSeq = $nSeq+1;
                }
            
        }
        //Group Both

        
        //Group Reject
        $aGrpReject =  $paGrpReject;     
        $nNumGrpReject = count($aGrpReject);

        for($i=0;$i<$nNumGrpReject;$i++){

            $aGrpRejectExploded = explode(",",$aGrpReject[$i]);

            $aDataCondition = array(

                'FTBchCode'             => $tPmhBchTo,
                'FTPmhCode'             => $tPmhCode,
                'FNPmdSeq'              => $nSeq+1,
                'FTSpmCode'             => $tSpmCode,
                'FTPmdGrpCode'          => 'GrpReject',
                'FTPmdGrpType'          => '1',
                'FTPmdGrpName'          => $tPmdGrpRejectName,
                'FTPdtCode'             => $aGrpRejectExploded[1],
                'FCPmdSetPriceOrg'      => floatval($aGrpRejectExploded[2]),
                'FTPunCode'             => $aGrpRejectExploded[3],
                
                'FDDateIns'             => date('Y-m-d'),
                'FDDateUpd'             => date('Y-m-d'),
                'FTTimeIns'             => date('h:i:s'),
                'FTTimeUpd'             => date('h:i:s'),
                'FTWhoIns'              => $this->session->userdata('tSesUsername'),
                'FTWhoUpd'              => $this->session->userdata('tSesUsername'),

            );
            $this->db->trans_begin();

            $aStaEventCD = $this->Promotion_model->FSaMPMTAddUpdatePmtDT($aDataCondition);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
            }else{
                $this->db->trans_commit();
            }
            $nSeq = $nSeq+1;
        }
        //Group Reject

    }

    public function FSsCReturnCheckBox($ptStaus){

        if($ptStaus == 'on'){
            return 1;
        }else{
            return 2;
        }
    }

    /**
     * Functionality : Event Delete Promotion
     * Parameters : Ajax jReason()
     * Creator : 03/07/2018 Krit(Copter)
     * Last Modified : -
     * Return : Status Delete Event
     * Return Type : String
     */
    public function FSaCPMTDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTPmhCode' => $tIDCode
        );

        $aResDel    = $this->Promotion_model->FSnMPMTDel($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }
    
    /**
     * Functionality : Function Call DataTables Promotion
     * Parameters : Ajax jBranch()
     * Creator : 03/07/2018 Krit(Copter)
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSxCPMTDataTable(){

        $aAlwEvent = FCNaHCheckAlwFunc('promotion/0/0'); //Controle Event
        
        $nPage = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        
     
        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'tSearchAll'    => $tSearchAll
        );

        $aResList   = $this->Promotion_model->FSaMPMTList($aData);
        $aGenTable  = array(

            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage'     => $nPage,
            'tSearchAll'    => $tSearchAll
        );

        $this->load->view('document/promotion/wPromotionDataTable',$aGenTable);
    }

    /**
     * Functionality : Function Call DataTables Promotion
     * Parameters : Ajax jBranch()
     * Creator : 03/07/2018 Krit(Copter)
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSxCPMTTSysListDataTable(){

        $aAlwEvent = FCNaHCheckAlwFunc('promotion/0/0'); //Controle Event
        
        $nPage = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TFNMRate_L');
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
            'nRow'          => 15,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );

        $aResList   = $this->Promotion_model->FSaMPMTTSysPmtList($aData);
        $aGenTable  = array(

            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage'     => $nPage,
            'tSearchAll'    => $tSearchAll

        );

        $this->load->view('document/promotion/wPromotionTSysListDataTable',$aGenTable);
    }
}


