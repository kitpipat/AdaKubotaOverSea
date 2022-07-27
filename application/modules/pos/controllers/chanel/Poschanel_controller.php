<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Poschanel_controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('pos/chanel/Poschanel_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    /**
     * Functionality : Main page for slip message
     * Parameters : $nChnBrowseType, $tChnBrowseOption
     * Creator : 29/12/2020 Worakorn
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nChnBrowseType, $tChnBrowseOption)
    {
        $nMsgResp = array('title' => "Province");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if (!$isXHR) {
            $this->load->view('common/wHeader', $nMsgResp);
            $this->load->view('common/wTopBar', array('nMsgResp' => $nMsgResp));
            $this->load->view('common/wMenu', array('nMsgResp' => $nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('chanel/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('pos/chanel/wPosChanel', array(
            'nMsgResp' => $nMsgResp,
            'vBtnSave' => $vBtnSave,
            'nChnBrowseType' => $nChnBrowseType,
            'tChnBrowseOption' => $tChnBrowseOption
        ));
    }

    /**
     * Functionality : Function Call District Page List
     * Parameters : Ajax and Function Parameter
     * Creator : 29/12/2020 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCCHNListPage()
    {
        $this->load->view('pos/chanel/wPosChanelList');
    }

    /**
     * Functionality : Function Call DataTables Slip Message
     * Parameters : Ajax and Function Parameter
     * Creator : 29/12/2020 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCCHNDataList()
    {
        $nPage      = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }
        if (!$tSearchAll) {
            $tSearchAll = '';
        }
        //Lang ภาษา
        // $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        // $aLangHave      = FCNaHGetAllLangByTable('TCNMSlipMsgHD_L');
        // $nLangHave      = count($aLangHave);
        // if ($nLangHave > 1) {
        //     if ($nLangEdit != '') {
        //         $nLangEdit = $nLangEdit;
        //     } else {
        //         $nLangEdit = $nLangResort;
        //     }
        // } else {
        //     if (@$aLangHave[0]->nLangList == '') {
        //         $nLangEdit = '1';
        //     } else {
        //         $nLangEdit = $aLangHave[0]->nLangList;
        //     }
        // }

        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );

        $tAPIReq = "";
        $tMethodReq = "GET";
        $aResList = $this->Poschanel_model->FSaMCHNList($tAPIReq, $tMethodReq, $aData);
        $aGenTable = array(
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('pos/chanel/wPosChanelDataTable', $aGenTable);
    }

    /**
     * Functionality : Function CallPage Slip Message Add
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCHNAddPage()
    {

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
            'aResult'   => array('rtCode' => '99')
        );

        $this->load->view('pos/chanel/wPosChanelAdd', $aDataAdd);
    }

    /**
     * Functionality : Function CallPage Slip Message Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCHNEditPage()
    {

        $tChnCode       = $this->input->post('tChnCode');
        // $tChnBchCode       = $this->input->post('tChnBchCode');
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
            'FTChnCode' => $tChnCode,
            // 'FTBchCode' => $tChnBchCode,
            'FNLngID'   => $nLangEdit
        );

        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aChnData       = $this->Poschanel_model->FSaMCHNSearchByID($tAPIReq, $tMethodReq, $aData);
        $aDataEdit      = array('aResult' => $aChnData);
        $this->load->view('pos/chanel/wPosChanelAdd', $aDataEdit);
    }

    /**
     * Functionality : Event Add Slip Message
     * Parameters : Ajax and Function Parameter
     * Creator : 31/08/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCHNAddEvent()
    {
        try {
            $tIsAutoGenCode = $this->input->post('ocbSlipmessageAutoGenCode');
            // $tBchCodeCreate = $this->input->post('oetWahBchCodeCreated');

            // Setup Reason Code
            $tChnCode   = "";
            if (isset($tIsAutoGenCode) &&  $tIsAutoGenCode == 1) {
                $aStoreParam = array(
                    "tTblName"   => 'TCNMChannel',
                    "tDocType"   => 0,
                    // "tBchCode"   => $tBchCodeCreate,
                    "tBchCode"   => "",
                    "tShpCode"   => "",
                    "tPosCode"   => "",
                    "dDocDate"   => date("Y-m-d")
                );
                $aAutogen          = FCNaHAUTGenDocNo($aStoreParam);
                $tChnCode          = $aAutogen[0]["FTXxhDocNo"];
                // print_r($tChnCode); die();
            } else {
                $tChnCode = $this->input->post('oetChnCode');
            }

            // $nCountSeq   = $this->Poschanel_model->FSnMChnCountSeq($tBchCodeCreate);
            $nCountSeq   = $this->Poschanel_model->FSnMChnCountSeq($this->input->post('oetChnAppCode'));
            $nCountSeq   = $nCountSeq + 1;


            $aDataMaster = array(
                'FTChnCode'             => $tChnCode,
                'FTAppCode' => $this->input->post('oetChnAppCode'),
                'FNChnSeq' => $nCountSeq,
                'FTChnStaUse'   => (!empty($this->input->post('ocbChnStatusUse'))) ? 1 : 2,
                'FTChnRefCode'  => $this->input->post('oetChnRefCode'),
                'FTPplCode'     => $this->input->post('oetChnPplCode'),
                'FTWahCode'     => $this->input->post('oetBchWahCode'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),


                'FTChnName'            => $this->input->post('oetChnName'),
                'FTAgnCode' => $this->input->post('oetChnAgnCode'),
                'FTBchCode'             => $this->input->post('oetWahBchCodeCreated'),
                // 'FTBchCode'             => $tBchCodeCreate,
                // 'FTBchCodeOld'             => $this->input->post('oetChnBchCodeOld'),       
                // 'FTChnGroup' =>  $this->input->post('oetChnGroup'),
                'tTypeInsertUpdate' => 'Insert'
            );
            // print_r($aDataMaster); die();
            // print_r($aDataMaster);
            // exit();


            // $oCountDup  = $this->Poschanel_model->FSoMCHNCheckDuplicate($aDataMaster['FTChnCode'], $aDataMaster['FTBchCode']);
            $oCountDup  = $this->Poschanel_model->FSoMCHNCheckDuplicate($aDataMaster['FTChnCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if ($nStaDup == 0) {
                $this->db->trans_begin();
                // Add or Update Slip
                $this->Poschanel_model->FSaMCHNAddUpdateHD($aDataMaster);


                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                } else {
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'    => $aDataMaster['FTChnCode'],
                        // 'tCodeBchReturn'    => $aDataMaster['FTBchCode'],
                        'nStaEvent'        => '1',
                        'tStaMessg'        => 'Success Add Event'
                    );
                }
            } else {
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => "Data Code Duplicate"
                );
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
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
    public function FSaCHNEditEvent()
    {
        try {


            $aDataMaster = array(
                'FTChnCode'             => $this->input->post('oetChnCode'),
                'FTAppCode' => $this->input->post('oetChnAppCode'),
                'FNChnSeq' => $this->input->post('oetChnSeq'),
                'FTChnStaUse'   => (!empty($this->input->post('ocbChnStatusUse'))) ? 1 : 2,
                'FTChnRefCode'  => $this->input->post('oetChnRefCode'),
                'FTPplCode'     => $this->input->post('oetChnPplCode'),
                'FTWahCode'     => $this->input->post('oetBchWahCode'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),


                'FTChnName'            => $this->input->post('oetChnName'),
                'FTAgnCode' => $this->input->post('oetChnAgnCode'),
                'FTBchCode'             => $this->input->post('oetWahBchCodeCreated'),

                'tTypeInsertUpdate' => 'Update'
            );

            $this->db->trans_begin();
            // Add or Update 
            $this->Poschanel_model->FSaMCHNAddUpdateHD($aDataMaster);

            // Delete Detail
            // $this->Poschanel_model->FSnMCHNDelDT($aDataMaster);

            // if (!(count($aDataMaster['FTHeadReceiptItems']) <= 0)) {
            //     // Add or Update Head of receipt
            //     $nIndex = 1;
            //     foreach ($aDataMaster['FTHeadReceiptItems'] as $tHeadReceipt) {
            //         $aDataMaster['FTChnType'] = '1'; // Type 1: head of receipt
            //         $aDataMaster['FNChnSeq'] = $nIndex; // Seq: 1,2,3,4,...
            //         $aDataMaster['FTChnName'] = $tHeadReceipt;
            //         $this->Poschanel_model->FSaMCHNAddUpdateDT($aDataMaster);
            //         $nIndex++;
            //     }
            // }
            // // Add or Update End of receipt
            // if (!(count($aDataMaster['FTEndReceiptItems']) <= 0)) {
            //     // Add or Update Head of receipt
            //     $nIndex = 1;
            //     foreach ($aDataMaster['FTEndReceiptItems'] as $tEndReceipt) {
            //         $aDataMaster['FTChnType'] = '2'; // Type 1: head of receipt
            //         $aDataMaster['FNChnSeq'] = $nIndex; // Seq: 1,2,3,4,...
            //         $aDataMaster['FTChnName'] = $tEndReceipt;
            //         $this->Poschanel_model->FSaMCHNAddUpdateDT($aDataMaster);
            //         $nIndex++;
            //     }
            // }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Update Event"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'    => $aDataMaster['FTChnCode'],
                    'tCodeBchReturn'    => $aDataMaster['FTBchCode'],
                    'nStaEvent'        => '1',
                    'tStaMessg'        => 'Success Update Event'
                );
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
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
    // public function FSaCHNDeleteEvent(){
    //     $tIDCode = $this->input->post('tIDCode');
    //     $aDataMaster = array(
    //         'FTChnCode' => $tIDCode
    //     );

    //     $aResDel = $this->Poschanel_model->FSnMCHNDelHD($aDataMaster);
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
    public function FStCHNUniqueValidate($tSelect = '')
    {

        if ($this->input->is_ajax_request()) { // Request check
            if ($tSelect == 'smgcode') {

                $tChnCode = $this->input->post('tChnCode');
                $oSlipMessage = $this->Poschanel_model->FSoMCHNCheckDuplicate($tChnCode);

                $tStatus = 'false';
                if ($oSlipMessage[0]->counts > 0) { // If have record
                    $tStatus = 'true';
                }
                echo $tStatus;

                return;
            }
            echo 'Param not match.';
        } else {
            echo 'Method Not Allowed';
        }
    }

    /**
     * Functionality : Function Event Multi Delete
     * Parameters : Ajax Function Delete
     * Creator : 04/01/2021 Worakorn
     * Last Modified : -
     * Return : Status Event Delete And Status Call Back Event
     * Return Type : object
     */
    public function FSoCHNDeleteMulti()
    {
        // $tChnCode = $this->input->post('tIDCode');

        // $aChnCode = json_decode($tChnCode);
        // foreach ($aChnCode as $oChnCode) {
        //     $aChn = ['FTChnCode' => $oChnCode];
        //     $this->Poschanel_model->FSnMCHNDelHD($aChn);
        // }
        // echo json_encode($aChnCode);
        try {
            $this->db->trans_begin();
            $aDataWhereDel  = $this->input->post('paDataWhere');
            // print_r($aDataWhereDel); die();
            $aDataDelete    = [
                'FTChnCode' => $aDataWhereDel['paChnCode'],
                'FTBchCode' => $aDataWhereDel['paBchCode'],
            ];

            // $tRevCodeWhere =  $this->input->post('ptRevCodeWhere');
            $tResult    = $this->Poschanel_model->FSaMChnDeleteMultiple($aDataDelete);
            if ($this->db->trans_status() == FALSE) {
                $this->db->trans_rollback();
                $aDataReturn    = array(
                    'nStaEvent' => 500,
                    'tStaMessg' => 'Error Not Delete Data Multiple'
                );
            } else {
                $this->db->trans_commit();
                $aDataReturn     = array(
                    'nStaEvent' => 1,
                    'tStaMessg' => 'Success Delete  Multiple'
                );
            }
        } catch (Exception $Error) {
            $aDataReturn     = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error
            );
        }
        echo json_encode($aDataReturn);
    }

    /**
     * Functionality : Delete
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Last Modified : -
     * Return : Vat code
     * Return Type : Object
     */
    public function FSoCHNDelete()
    {

        $tChnBchCode = $this->input->post('tChnBchCode');
        $tChnCode = $this->input->post('tChnCode');
        $aDataMaster = array(
            'FTChnCode' => $tChnCode,
            'FTBchCode' => $tChnBchCode
        );
        $aResDel    = $this->Poschanel_model->FSnMCHNDelHD($aDataMaster);
        $nNumRowChnLoc = $this->Poschanel_model->FSnMLOCGetAllNumRow();
        if ($nNumRowChnLoc !== false) {
            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'nNumRowChnLoc' => $nNumRowChnLoc
            );
            echo json_encode($aReturn);
        } else {
            echo "database error";
        }
    }
}
