<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Promotionstep5checkandconfirm_controller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/promotion/Promotionstep5checkandconfirm_model');
        $this->load->model('document/promotion/Promotion_model');
    }

    /**
     * Functionality : Get Check and Confirm Page
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSxCPromotionGetCheckAndConfirmPage()
    {
        $aAlwEvent = FCNaHCheckAlwFunc('promotion/0/0');
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tPbyStaBuyCond = $this->input->post('tPbyStaBuyCond'); // เงื่อนไขการซื้อ
        $tConditionBuyIsRange = $this->input->post('tConditionBuyIsRange');
        $nOptionDecimalShow = FCNxHGetOptionDecimalShow();
        $nOptionDecimalSave = FCNxHGetOptionDecimalSave();

        $aGetPmtCBInTmpParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $aPmtCBInTmp = $this->Promotionstep5checkandconfirm_model->FSaMGetPmtCBInTmp($aGetPmtCBInTmpParams);
        
        $aGetPmtCGInTmpParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $aPmtCGInTmp = $this->Promotionstep5checkandconfirm_model->FSaMGetPmtCGInTmp($aGetPmtCGInTmpParams);

        $aGetCouponInTmpParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $aCouponInTmp = $this->Promotionstep5checkandconfirm_model->FSaMGetCouponInTmp($aGetCouponInTmpParams);

        $aGetPointInTmpParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $aPointInTmp = $this->Promotionstep5checkandconfirm_model->FSaMGetPointInTmp($aGetPointInTmpParams);
        $aGetPdtPmtHDCstPriInTmpParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $aPdtPmtHDCstPriInTmp = $this->Promotionstep5checkandconfirm_model->FSaMGetPdtPmtHDCstPriInTmp($aGetPdtPmtHDCstPriInTmpParams);
        $aGetPdtPmtHDBchInTmpParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $aPdtPmtHDBchInTmp = $this->Promotionstep5checkandconfirm_model->FSaMGetPdtPmtHDBchInTmp($aGetPdtPmtHDBchInTmpParams);
        $aGetPdtPmtHDChnInTmpParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $aPdtPmtHDChnInTmp = $this->Promotionstep5checkandconfirm_model->FSaMGetPdtPmtHDChnInTmp($aGetPdtPmtHDChnInTmpParams);
        $aGetPdtPmtHDZoneInTmpParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $aPdtPmtHDZoneInTmp = $this->Promotionstep5checkandconfirm_model->FSaMGetPdtPmtHDZoneInTmp($aGetPdtPmtHDZoneInTmpParams);
        

        $aViewParams = array(
            'aAlwEvent' => $aAlwEvent,
            'nOptDecimalShow' => $nOptDecimalShow,
            'aPmtCBInTmp' => $aPmtCBInTmp,
            'aPmtCGInTmp' => $aPmtCGInTmp,
            'aCouponInTmp' => $aCouponInTmp,
            'aPointInTmp' => $aPointInTmp,
            'aPdtPmtHDCstPriInTmp' => $aPdtPmtHDCstPriInTmp,
            'aPdtPmtHDBchInTmp' => $aPdtPmtHDBchInTmp,
            'aPdtPmtHDChnInTmp' => $aPdtPmtHDChnInTmp,
            'aPdtPmtHDZoneInTmp' => $aPdtPmtHDZoneInTmp,
            'tPbyStaCalSum' => isset($aPmtCBInTmp[0]['FTPbyStaCalSum'])?$aPmtCBInTmp[0]['FTPbyStaCalSum']:'1',
            'tPgtStaGetEffect' => isset($aPmtCGInTmp[0]['FTPgtStaGetEffect'])?$aPmtCGInTmp[0]['FTPgtStaGetEffect']:'1',
            'tPgtStaGetType' => isset($aPmtCGInTmp[0]['FTPgtStaGetType'])?$aPmtCGInTmp[0]['FTPgtStaGetType']:'1',
            'tPbyStaBuyCond' => $tPbyStaBuyCond,
            'bConditionBuyIsRange' => json_decode($tConditionBuyIsRange),
            'nOptionDecimalShow' => $nOptionDecimalShow
        );
        $tHtml = $this->load->view('document/promotion/advance_page/wStep5CheckAndConfirm', $aViewParams, true);
        
        $aResponse = [
            'html' => $tHtml
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResponse));
    }

    /**
     * Functionality : Update PmtCB StaCalSum in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionUpdatePmtCBStaCalSumInTmp()
    {
        $tBchCode = $this->input->post('tBchCode');
        $tPbyStaCalSum = $this->input->post('tPbyStaCalSum');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        
        $this->db->trans_begin();

        $aUpdatePmtCBStaCalSumParams = [
            'tBchCode' => $tBchCode,
            'tPbyStaCalSum' => $tPbyStaCalSum,
            'tUserLoginCode' => $tUserLoginCode,
            'tUserSessionID' => $tUserSessionID
        ];
        $this->Promotionstep5checkandconfirm_model->FSbMUpdatePmtCBStaCalSumInTmp($aUpdatePmtCBStaCalSumParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess UpdatePmtCBStaCalSumInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success UpdatePmtCBStaCalSumInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Update PmtCG StaGetEffect in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionUpdatePmtCGStaGetEffectInTmp()
    {
        $tBchCode = $this->input->post('tBchCode');
        $tPgtStaGetEffect = $this->input->post('tPgtStaGetEffect');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        
        $this->db->trans_begin();

        $aUpdatePmtCGStaGetEffectInTmpParams = [
            'tBchCode' => $tBchCode,
            'tPgtStaGetEffect' => $tPgtStaGetEffect,
            'tUserLoginCode' => $tUserLoginCode,
            'tUserSessionID' => $tUserSessionID
        ];
        $this->Promotionstep5checkandconfirm_model->FSbMUpdatePmtCGStaGetEffectInTmp($aUpdatePmtCGStaGetEffectInTmpParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess UpdatePmtCGStaGetEffectInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success UpdatePmtCGStaGetEffectInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }
}