<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Promotionstep1pmtbranddt_controller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/promotion/Promotionstep1pmtbranddt_model');
        $this->load->model('document/promotion/Promotionstep1pmtdt_model');
        $this->load->model('document/promotion/Promotion_model');
    }

    /**
     * Functionality : Get PmtBrandDt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSxCPromotionGetPmtBrandDtInTmp()
    {
        $tPmtGroupTypeTmp = $this->input->post('tPmtGroupTypeTmp');
        $tPmtGroupListTypeTmp = $this->input->post('tPmtGroupListTypeTmp');
        $tPmtGroupNameTmp = $this->input->post('tPmtGroupNameTmp');
        $tPmtGroupNameTmpOld = $this->input->post('tPmtGroupNameTmpOld');
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

        $aGetPmtBrandDtInTmpParams  = array(
            'tPmtGroupNameTmp' => $tPmtGroupNameTmp,
            'tPmtGroupTypeTmp' => $tPmtGroupTypeTmp,
            'tPmtGroupListTypeTmp' => $tPmtGroupListTypeTmp,
            'FNLngID' => $nLangEdit,
            'nPage' => $nPage,
            'nRow' => 500,
            'tSearchAll' => $tSearchAll,
            'tUserSessionID' => $tUserSessionID
        );
        $aResList = $this->Promotionstep1pmtbranddt_model->FSaMGetPmtBrandDtInTmp($aGetPmtBrandDtInTmpParams);

        $aGetPmtBrandDtInAllTmpParams  = array(
            'FNLngID' => $nLangEdit,
            'tBchCodeLogin' => $tBchCodeLogin,
            'tUserSessionID' => $tUserSessionID,
            'tPmtGroupNameTmpOld' => $tPmtGroupNameTmpOld
        );
        $aGetPmtBrandDtInAllTmp = $this->Promotionstep1pmtbranddt_model->FSaMGetPmtBrandDtInAllTmp($aGetPmtBrandDtInAllTmpParams);
        
        $aNotIn = [];
        foreach($aGetPmtBrandDtInAllTmp as $nIndex => $aGetPmtBrandDtInAllTmpItem){
            $aNotIn[$nIndex][] = $aGetPmtBrandDtInAllTmpItem['FTPmdRefCode'];
            $aNotIn[$nIndex][] = $aGetPmtBrandDtInAllTmpItem['FTPmdBarCode'];
        }

        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow
        );
        $tHtml = $this->load->view('document/promotion/advance_table/wStep1PmtBrandDtTableTmp', $aGenTable, true);
        
        $aResponse = [
            'html' => $tHtml,
            'notIn' => $aNotIn
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResponse));
    }

    /**
     * Functionality : Insert PmtBrandDt to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCPromotionInsertPmtBrandDtToTmp()
    {
        $tPmtGroupNameTmp = $this->input->post('tPmtGroupNameTmp');
        $tPmtGroupNameTmpOld = $this->input->post('tPmtGroupNameTmpOld');
        $tPmtGroupTypeTmp = $this->input->post('tPmtGroupTypeTmp');
        $tPmtGroupListTypeTmp = $this->input->post('tPmtGroupListTypeTmp');
        $tBrandList = $this->input->post('tBrandList');
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserSessionDate = $this->session->userdata("tSesSessionDate");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");

        $this->db->trans_begin();

        $aClearPmtDtShopAllInTmpParams = [
            'tUserSessionID' => $tUserSessionID,
            'tPmtGroupNameTmpOld' => $tPmtGroupNameTmpOld
        ];
        $this->Promotionstep1pmtdt_model->FSbClearPmtDtShopAllInTmp($aClearPmtDtShopAllInTmpParams);
        
        $aBrandList = json_decode($tBrandList, JSON_OBJECT_AS_ARRAY);
        
        if (isset($aBrandList) && is_array($aBrandList) && !empty($aBrandList)) {
            foreach ($aBrandList as $aItem) {
                $tBrandCode = json_decode($aItem)[0];
                $tBrandName = json_decode($aItem)[1];
                $aPmtBrandDtToTempParams = [
                    'tDocNo' => 'PMTDOCTEMP',
                    'tPmtGroupNameTmp' => $tPmtGroupNameTmp,
                    'tPmtGroupNameTmpOld' => $tPmtGroupNameTmpOld,
                    'tPmtGroupTypeTmp' => $tPmtGroupTypeTmp,
                    'tPmtGroupListTypeTmp' => $tPmtGroupListTypeTmp,
                    'tBchCodeLogin' => $tBchCodeLogin,
                    'tUserSessionID' => $tUserSessionID,
                    'tUserSessionDate' => $tUserSessionDate,
                    'tUserLoginCode' => $tUserLoginCode,
                    'tBrandCode' => $tBrandCode,
                    'tBrandName' => $tBrandName,
                    'nLngID' => $nLangEdit
                ];
                $this->Promotionstep1pmtbranddt_model->FSaMPmtBrandDtToTemp($aPmtBrandDtToTempParams);
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Add"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success Add'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Update PmtBrandDt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionUpdatePmtBrandDtInTmp()
    {
        $tPmtGroupNameTmp = $this->input->post('tPmtGroupNameTmp');
        $tPmtGroupNameTmpOld = $this->input->post('tPmtGroupNameTmpOld');
        $tPmtGroupTypeTmp = $this->input->post('tPmtGroupTypeTmp');
        $tPmtGroupListTypeTmp = $this->input->post('tPmtGroupListTypeTmp');
        $tModelCode = $this->input->post('tModelCode');
        $tModelName = $this->input->post('tModelName');
        $nSeqNo = $this->input->post('nSeqNo');
        $tBchCode = $this->input->post('tBchCode');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        
        $this->db->trans_begin();

        $aUpdatePmtBrandDtInTmpBySeqParams = [
            'tPmtGroupNameTmp' => $tPmtGroupNameTmp,
            'tPmtGroupNameTmpOld' => $tPmtGroupNameTmpOld,
            'tPmtGroupTypeTmp' => $tPmtGroupTypeTmp,
            'tPmtGroupListTypeTmp' => $tPmtGroupListTypeTmp,
            'tModelCode' => $tModelCode,
            'tModelName' => $tModelName,
            'tUserLoginCode' => $tUserLoginCode,
            'tUserSessionID' => $tUserSessionID,
            'nSeqNo' => $nSeqNo,
        ];
        $this->Promotionstep1pmtbranddt_model->FSbUpdatePmtBrandDtInTmpBySeq($aUpdatePmtBrandDtInTmpBySeqParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Update"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success Update'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

}