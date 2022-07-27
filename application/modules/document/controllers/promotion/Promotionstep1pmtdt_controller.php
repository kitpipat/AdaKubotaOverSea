<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Promotionstep1pmtdt_controller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/promotion/Promotionstep1pmtdt_model');
        $this->load->model('document/promotion/Promotion_model');
    }

    /**
     * Functionality : Confirm PmtDt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionConfirmPmtDtInTmp()
    {
        $tIsShopAll = $this->input->post('tIsShopAll'); // ตรวจสอบว่าเป็นการเลือกทั้งร้านหรือไม่ 1: ใช้ทั้งร้าน
        $tPmtGroupNameTmp = $this->input->post('tPmtGroupNameTmp');
        $tPmtGroupNameTmpOld = $this->input->post('tPmtGroupNameTmpOld');
        $tPmtGroupTypeTmp = $this->input->post('tPmtGroupTypeTmp');
        $tPmtGroupListTypeTmp = $this->input->post('tPmtGroupListTypeTmp');
        $tBchCode = $this->input->post('tBchCode');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");
        
        $this->db->trans_begin();

        if($tIsShopAll == "1"){
            $aDeletePmtDtInTmpByGroupNameParams = [
                'tGroupName' => $tPmtGroupNameTmpOld,
                'tUserSessionID' => $tUserSessionID
            ];
            $this->Promotionstep1pmtdt_model->FSbDeletePmtDtInTmpByGroupName($aDeletePmtDtInTmpByGroupNameParams); 
            
            $aShopAllToTempParams = [
                'tDocNo' => 'PMTDOCTEMP',
                'tBchCodeLogin' => $tBchCodeLogin,
                'tPmtGroupNameTmp' => $tPmtGroupNameTmp,
                'tPmtGroupNameTmpOld' => $tPmtGroupNameTmpOld,
                'tPmtGroupListTypeTmp' => $tPmtGroupListTypeTmp,
                'tPmtGroupTypeTmp' => $tPmtGroupTypeTmp,
                'tUserLoginCode' => $tUserLoginCode,
                'tUserSessionID' => $tUserSessionID
            ];
            $this->Promotionstep1pmtdt_model->FSaMPmtDtShopAllToTemp($aShopAllToTempParams);
        }else{
            $aUpdatePmtDtInTmpParams = [
                'tPmtGroupNameTmp' => $tPmtGroupNameTmp,
                'tPmtGroupNameTmpOld' => $tPmtGroupNameTmpOld,
                'tPmtGroupListTypeTmp' => $tPmtGroupListTypeTmp,
                'tPmtGroupTypeTmp' => $tPmtGroupTypeTmp,
                'tUserLoginCode' => $tUserLoginCode,
                'tUserSessionID' => $tUserSessionID
            ];
            $this->Promotionstep1pmtdt_model->FSbUpdatePmtDtInTmp($aUpdatePmtDtInTmpParams);
        }

        $aClearPmtDtInBinParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $this->Promotionstep1pmtdt_model->FSbClearPmtDtInBin($aClearPmtDtInBinParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess ConfirmPmtDtInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success ConfirmPmtDtInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
        
    }

    /**
     * Functionality : Cancel PmtDt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionCancelPmtDtInTmp()
    {
        $tPmtGroupNameTmp = $this->input->post('tPmtGroupNameTmp');
        $tPmtGroupNameTmpOld = $this->input->post('tPmtGroupNameTmpOld');
        $tPmtGroupTypeTmp = $this->input->post('tPmtGroupTypeTmp');
        $tPmtGroupListTypeTmp = $this->input->post('tPmtGroupListTypeTmp');
        $tBchCode = $this->input->post('tBchCode');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");
        
        $this->db->trans_begin();

        if(empty($tPmtGroupNameTmpOld)){
            $aDeletePmtDtInTmpByGroupNameParams = [
                'tGroupName' => $tPmtGroupNameTmpOld,
                'tUserSessionID' => $tUserSessionID
            ];
            $this->Promotionstep1pmtdt_model->FSbDeletePmtDtInTmpByGroupName($aDeletePmtDtInTmpByGroupNameParams);
        }else{
            $aBinToPmtDtInTmpByGroupNameParams = [
                'tGroupName' => $tPmtGroupNameTmpOld,
                'tUserSessionID' => $tUserSessionID
            ];
            $this->Promotionstep1pmtdt_model->FSbBinToPmtDtInTmpByGroupName($aBinToPmtDtInTmpByGroupNameParams);
        }


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess CancelPmtDtInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success CancelPmtDtInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
        
    }

    /**
     * Functionality : Copy PmtDt in Temp to Bin
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionPmtDtInTmpToBin()
    {
        $tPmtGroupNameTmp = $this->input->post('tPmtGroupNameTmp');
        $tPmtGroupNameTmpOld = $this->input->post('tPmtGroupNameTmpOld');
        $tPmtGroupTypeTmp = $this->input->post('tPmtGroupTypeTmp');
        $tPmtGroupListTypeTmp = $this->input->post('tPmtGroupListTypeTmp');
        $tBchCode = $this->input->post('tBchCode');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");
        
        $this->db->trans_begin();

        $aPmtDtInTmpToBinByGroupNameParams = [
            'tGroupName' => $tPmtGroupNameTmp,
            'tUserSessionID' => $tUserSessionID
        ];
        $this->Promotionstep1pmtdt_model->FSbPmtDtInTmpToBinByGroupName($aPmtDtInTmpToBinByGroupNameParams);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess PmtDtInTmpToBin"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success PmtDtInTmpToBin'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Delete PmtDt by SeqNo in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionDeletePmtDtInTmp()
    {
        $nSeqNo = $this->input->post('nSeqNo');
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $this->db->trans_begin();

        $aDeleteInTmpBySeqParams = [
            'tUserSessionID' => $tUserSessionID,
            'nSeqNo' => $nSeqNo,
        ];
        $this->Promotionstep1pmtdt_model->FSbDeletePmtDtInTmpBySeq($aDeleteInTmpBySeqParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess DeletePmtDtInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success DeletePmtDtInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Delete More PmtDt by SeqNo in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionDeleteMorePmtDtInTmp()
    {
        $tSeqNo = $this->input->post('tSeqNo');
        $aSeqNo = json_decode($tSeqNo);

        $this->db->trans_begin();

        if (!empty($aSeqNo)) {
            $tUserSessionID = $this->session->userdata("tSesSessionID");
            
            $aDeleteInTmpBySeqParams = [
                'tUserSessionID' => $tUserSessionID,
                'aSeqNo' => $aSeqNo,
            ];
            $this->Promotionstep1pmtdt_model->FSbDeleteMorePmtDtInTmpBySeq($aDeleteInTmpBySeqParams);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess DeleteMorePmtDtInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success DeleteMorePmtDtInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Clear PmtDt by Group Name in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionClearPmtDtInTmp()
    {
        $tPmtGroupNameTmp = $this->input->post('tPmtGroupNameTmp');
        $tPmtGroupNameTmpOld = $this->input->post('tPmtGroupNameTmpOld');
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $this->db->trans_begin();

        $aClearPmtDtInTmpParams = [
            'tUserSessionID' => $tUserSessionID,
            'tPmtGroupNameTmpOld' => $tPmtGroupNameTmpOld
        ];
        $this->Promotionstep1pmtdt_model->FSbClearPmtDtInTmp($aClearPmtDtInTmpParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess ClearPmtDtInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success ClearPmtDtInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Check Group Name Duplicate
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStCPromotionPmtDtUniqueValidate()
    {
        $aStatus = ['bStatus' => false];

        if ($this->input->is_ajax_request()) { // Request check

            $tPmtGroupNameTmp = $this->input->post('tPmtGroupNameTmp');
            $tPmtGroupNameTmpOld = $this->input->post('tPmtGroupNameTmpOld');
            $tPmtGroupTypeTmp = $this->input->post('tPmtGroupTypeTmp');
            $tUserSessionID = $this->session->userdata("tSesSessionID");

            $aCheckPmtDtDuplicateGroupNameParams = [
                'tPmtGroupNameTmp' => $tPmtGroupNameTmp,
                'tPmtGroupNameTmpOld' => $tPmtGroupNameTmpOld,
                'tPmtGroupTypeTmp' => $tPmtGroupTypeTmp,
                'tUserSessionID' => $tUserSessionID   
            ];
            $bIsGroupNameDup = $this->Promotionstep1pmtdt_model->FSbMCheckPmtDtDuplicateGroupName($aCheckPmtDtDuplicateGroupNameParams);

            if ($bIsGroupNameDup) { // If have record
                $aStatus['bStatus'] = true;
            }
        } else {
            echo 'Method Not Allowed';
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aStatus));
    }

    /**
     * Functionality : Get PmtDt Group Name in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSxCPromotionGetPmtDtGroupNameInTmp()
    {
        $tPmtGroupNameTmp = $this->input->post('tPmtGroupNameTmp');
        $tSearchAll = $this->input->post('tSearchAll');
        $nPage = $this->input->post('nPageCurrent');
        $aAlwEvent = FCNaHCheckAlwFunc('promotion/0/0');
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aGetPmtDtInTmpParams  = array(
            'tPmtGroupNameTmp' => $tPmtGroupNameTmp,
            'FNLngID' => $nLangEdit,
            'nPage' => $nPage,
            'nRow' => 50,
            'tSearchAll' => $tSearchAll,
            'tUserSessionID' => $tUserSessionID
        );
        $aResList = $this->Promotionstep1pmtdt_model->FSaMGetPmtDtGroupInTmp($aGetPmtDtInTmpParams);

        $aGetPmtDtStaListTypeOnExcudeTypeInTmpParams  = array(
            'tUserSessionID' => $tUserSessionID
        );
        $tPmdStaListType = $this->Promotionstep1pmtdt_model->FStMGetPmtDtStaListTypeOnExcudeTypeInTmp($aGetPmtDtStaListTypeOnExcudeTypeInTmpParams);

        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'tPmdStaListType' => $tPmdStaListType,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow
        );
        $tHtml = $this->load->view('document/promotion/advance_table/wStep1PmtDtByGroupNameTableTmp', $aGenTable, true);
        
        $aResponse = [
            'html' => $tHtml
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResponse));
    }
    
    /**
     * Functionality : Delete PmtDt Group Name in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionDeletePmtDtGroupNameInTmp()
    {
        $tGroupName = $this->input->post('tGroupName');
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $this->db->trans_begin();

        $aDeleteInTmpByGroupNameParams = [
            'tUserSessionID' => $tUserSessionID,
            'tGroupName' => $tGroupName,
        ];
        $this->Promotionstep1pmtdt_model->FSbDeletePmtDtInTmpByGroupName($aDeleteInTmpByGroupNameParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess DeletePmtDtGroupNameInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success DeletePmtDtGroupNameInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }
}