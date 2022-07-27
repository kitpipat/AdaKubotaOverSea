<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cChkSaleOrderApprove extends MX_Controller {

    public function __construct() {
        date_default_timezone_set("Asia/Bangkok");
        parent::__construct();
        $this->load->model('document/checksaleorderapprove/mChkSaleOrderApprove');
        $this->load->helper('array_helper');
    }

    public function index($pnBrowseType,$ptBrowseOption){
        $aDataConfigView    = [
            'nChkSoBrowseType'     => $pnBrowseType,
            'tChkSoBrowseOption'   => $ptBrowseOption,
            'aAlwEvent'            => FCNaHCheckAlwFunc('dcmCheckSO/0/0'),
            'vBtnSave'             => FCNaHBtnSaveActiveHTML('dcmCheckSO/0/0'),
            'nOptDecimalShow'      => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'      => FCNxHGetOptionDecimalSave()
        ];

        $aMQParams = [
            "queuesname" => "MQAPROVE".$this->session->userdata('tSesSessionID'),
            "exchangname" => "EX_MQApprove",
            "params" => [
                "ptBchCode" => "",
                "ptDocNo" => "",
                "ptDocType" => 1,
                "ptUser" => $this->session->userdata('tSesUsername'),
                "ptConnStr" => 0
            ]
        ];
        // FCNxRentalCallRabbitMQ($aMQParams);

        $this->load->view('document/checksaleorderapprove/wChkSaleOrderApproveFormSearchList',$aDataConfigView);
    } 

    // Functionality: Function Call Page Booking Locker Main
    // Parameters: Ajax and Function Parameter
    // Creator: 22/01/2019 Witsarut(Bell)
    // Return: String View
    // ReturnType: View
    public function FSvCCHKSoCallPageMain(){

        $aAdvanceSearch     = $this->input->post('oAdvanceSearch');
        $nPage              = $this->input->post('nPageCurrent');
        $nLangEdit          = $this->session->userdata("tLangEdit");
        $tBchCode           = $this->session->userdata('tSesUsrBchCom');

        // Page Current 
        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }

        // Lang ภาษา
        $nLangEdit = $this->session->userdata("tLangEdit");

        // Data Conditon Get Data Document
        $aDataCondition     = array(
            'FTBchCode'      => $tBchCode,
            'FNLngID'        => $nLangEdit,
            'nPage'          => $nPage,
            'nRow'           => 10,
            'aAdvanceSearch' => $aAdvanceSearch,
            'aDatSessionUserLogIn' => $this->session->userdata("tSesUsrInfo")
        );

        //Get Data of SOHD
        $aResultData    = $this->mChkSaleOrderApprove->FSaMCHKSoGetDetailData($aDataCondition);

        //Get Data Loop for Seq 1-6
        $aResultSeq = $this->mChkSaleOrderApprove->FSaMCHKSoGetdataloop($aDataCondition);

        if($aResultData['rtCode'] == 800){
            $aDataSeq   = [];
        }else{
            $aDataSeq=array();
            foreach($aResultData['raItems'] as $nK => $aValue){
                $aDataSeq[$aValue['LastSeq']][] = $aValue;
            }
        }
        $nSetLimitTimeReloadPageMain = $this->mChkSaleOrderApprove->FSnMCHKSoGetTimeMonitorCountDown();

        $aDataConfigView    =  [
            'aResultSeq'        => $aResultSeq,
            'aResultData'       => $aDataSeq,
            'aAlwEventBKL'      => FCNaHCheckAlwFunc('dcmCheckSO/0/0'),
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave(),
            'nSetLimitTimeReloadPageMain' => ($nSetLimitTimeReloadPageMain*1000)
        ];

        $this->load->view('document/checksaleorderapprove/wChkSaleOrderApproveMain',$aDataConfigView);
    }


}