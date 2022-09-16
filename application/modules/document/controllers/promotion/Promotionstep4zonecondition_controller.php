<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Promotionstep4zonecondition_controller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/promotion/Promotionstep4zonecondition_model');
        $this->load->model('document/promotion/Promotion_model');
    }

    /**
     * Functionality : Get PdtPmtHDChn in Temp
     * Parameters : -
     * Creator : 04/01/2021 Woakorn
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSxCPromotionGetHDZoneInTmp()
    {
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

        $aGetPdtPmtHDCstPriInTmpParams  = array(
            'FNLngID' => $nLangEdit,
            'nPage' => $nPage,
            'nRow' => 50,
            'tSearchAll' => $tSearchAll,
            'tUserSessionID' => $tUserSessionID
        );
        $aResList = $this->Promotionstep4zonecondition_model->FSaMGetPdtPmtHDChnInTmp($aGetPdtPmtHDCstPriInTmpParams);

        // print_r($aResList); die();

        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow
        );
        $tHtml = $this->load->view('document/promotion/advance_table/wStep4ZoneConditionTableTmp', $aGenTable, true);
        
        $aResponse = [
            'html' => $tHtml
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResponse));
    }

    /**
     * Functionality : Insert PdtPmtHDChn to Temp
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCPromotionInsertZoneToTmp()
    {
        $tChnList = $this->input->post('tZoneList');
        $tBchCode = $this->input->post('tBchCode');
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserSessionDate = $this->session->userdata("tSesSessionDate");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");
        
        $aChnList = json_decode($tChnList);

        if(!isset($aChnList[0]) || !isset($aChnList[1])) {
            return;
        }

        $tChnCode = $aChnList[0];
        $tChnName = $aChnList[1];
        $tChnZne  = $aChnList[2];
        $this->db->trans_begin();

        $aPdtPmtHDCstPriToTempParams = [
            'tDocNo' => 'PMTDOCTEMP',
            'tBchCode'  => $tBchCode,
            'tZoneChain' => $tChnCode,
            'tZoneCode' => $tChnZne,
            'tZoneName' => $tChnName,
            'tUserSessionID' => $tUserSessionID,
            'tUserSessionDate' => $tUserSessionDate,
            'nLngID' => $nLangEdit
        ];
        
        $this->Promotionstep4zonecondition_model->FSaMPdtPmtHDChnToTemp($aPdtPmtHDCstPriToTempParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess InsertChanneloTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success InsertChannelToTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Update PdtPmtHDChn in Temp
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionUpdateZoneInTmp()
    {
        
        $tBchCode = $this->input->post('tBchCode');
        $tDocNo = $this->input->post('tDocNo');
        $tChnCode = $this->input->post('tChnCode');
        $tZneCode = $this->input->post('tZneCode');
        $tPmhStaType = $this->input->post('tPmhStaType');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        
        $this->db->trans_begin();

        $aUpdatePmtCBInTmpBySeqParams = [
            'tBchCode' => $tBchCode,
            'tDocNo' => $tDocNo,
            'tChnCode' => $tChnCode,
            'tZneCode' => $tZneCode,
            'tPmhStaType' => $tPmhStaType,
            'tUserSessionID' => $tUserSessionID
        ];
        $this->Promotionstep4zonecondition_model->FSbUpdateChnInTmpByKey($aUpdatePmtCBInTmpBySeqParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess UpdateZoneInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success UpdateChannelInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Delete PdtPmtHDChn by Primary Key in Temp
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCPromotionDeleteZoneInTmp()
    {
        $tDocNo = $this->input->post('tDocNo');
        $tBchCode = $this->input->post('tBchCode');
        $tChnCode = $this->input->post('tChnCode');
        $tZneCode = $this->input->post('tZneCode');
        
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $this->db->trans_begin();

        $aDeleteInTmpByKeyParams = [
            'tUserSessionID' => $tUserSessionID,
            'tBchCode'  => $tBchCode,
            'tDocNo' => $tDocNo,
            'tZoneCode' => $tChnCode,
            'tZoneChainCode' =>$tZneCode,
        ];
        // print_r($aDeleteInTmpByKeyParams); die();
        $this->Promotionstep4zonecondition_model->FSbDeletePdtPmtHDChnInTmpByKey($aDeleteInTmpByKeyParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess DeleteZoneInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success DeleteZoneInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }
}