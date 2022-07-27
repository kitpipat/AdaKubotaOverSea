<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Depositcheque_controller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/deposit/Depositcheque_model');
        $this->load->model('document/deposit/Deposit_model');
    }

    /**
     * Functionality : Get Cheque in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSxCDepositGetChequeInTmp()
    {
        $tSearchAll = $this->input->post('tSearchAll');
        $nPage = $this->input->post('nPageCurrent');
        $aAlwEvent = FCNaHCheckAlwFunc('deposit/0/0');
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aGetChequeInTmpParams  = array(
            'FNLngID' => $nLangEdit,
            'nPage' => $nPage,
            'nRow' => 20,
            'tSearchAll' => $tSearchAll,
            'tUserSessionID' => $tUserSessionID
        );
        $aResList = $this->Depositcheque_model->FSaMGetChequeInTmp($aGetChequeInTmpParams);

        $aCalInTmpParams = [
            'tUserSessionID' => $tUserSessionID,
            'tDocKey' => 'TFNTBnkDplHD'    
        ];
        $aCalInTmp = $this->Deposit_model->FSxMCalInTmp($aCalInTmpParams);
        $aCalInTmp['FTBddRefAmtChequeTotalText'] = FCNtNumberToTextBaht(number_format($aCalInTmp['FCBddRefAmtChequeTotal'], $nOptDecimalShow));
        $aCalInTmp['FCBddRefAmtChequeTotal'] = number_format($aCalInTmp['FCBddRefAmtChequeTotal'], $nOptDecimalShow);
        $aCalInTmp['FTBddRefAmtTotalText'] = FCNtNumberToTextBaht(number_format($aCalInTmp['FCBddRefAmtTotal'], $nOptDecimalShow));
        $aCalInTmp['FCBddRefAmtTotal'] = number_format($aCalInTmp['FCBddRefAmtTotal'], $nOptDecimalShow);

        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow,
            'aCalInTmp' => $aCalInTmp
        );
        $tHtml = $this->load->view('document/deposit/advance_table/wDepositChequeDatatable', $aGenTable, true);

        $aResponse = [
            'calInTmp' => $aCalInTmp,
            'html' => $tHtml
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResponse));
    }

    /**
     * Functionality : Insert Cheque to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCDepositInsertChequeToTmp()
    {
        $tBchCode = $this->input->post('tBchCode');
        $tChequeRefNo = $this->input->post('tChequeRefNo');
        $cChequeValue = str_replace(",","",empty($this->input->post('cChequeValue'))?"0.00":$this->input->post('cChequeValue'));
        $tChequeBnkName = $this->input->post('tChequeBnkName');
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCode");

        $aPdtlayoutToTempParams = [
            'tDocNo' => 'DPLDOCTEMP',
            'tDocKey' => 'TFNTBnkDplHD',
            'tBchCode' => $tBchCode,
            'tChequeRefNo' => $tChequeRefNo,
            'cChequeValue' => $cChequeValue,
            'tChequeBnkName' => $tChequeBnkName,
            'tBchCodeLogin' => $tBchCodeLogin,
            'tUserSessionID' => $tUserSessionID,
            'tUserLoginCode' => $tUserLoginCode,
            'nLngID' => $nLangEdit
        ];
        $this->Depositcheque_model->FSaMChequeToTemp($aPdtlayoutToTempParams);
    }

    /**
     * Functionality : Update Cheque in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCDepositUpdateChequeInTmp()
    {
        $tChequeRefNo = $this->input->post('tChequeRefNo');
        $cChequeValue = str_replace(",","",empty($this->input->post('cChequeValue'))?"0.00":$this->input->post('cChequeValue'));
        $nSeqNo = $this->input->post('nSeqNo');
        $tBchCode = $this->input->post('tBchCode');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");
        
        $aUpdateChequeInTmpBySeqParams = [
            'tChequeRefNo' => $tChequeRefNo,
            'cChequeValue' => $cChequeValue,
            'tUserLoginCode' => $tUserLoginCode,
            'tUserSessionID' => $tUserSessionID,
            'nSeqNo' => $nSeqNo,
        ];
        $this->Depositcheque_model->FSbUpdateChequeInTmpBySeq($aUpdateChequeInTmpBySeqParams);
    }

    /**
     * Functionality : Delete Cheque in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCDepositDeleteChequeInTmp()
    {
        $nSeqNo = $this->input->post('nSeqNo');
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $aDeleteInTmpBySeqParams = [
            'tUserSessionID' => $tUserSessionID,
            'nSeqNo' => $nSeqNo,
        ];
        $this->Depositcheque_model->FSbDeleteChequeInTmpBySeq($aDeleteInTmpBySeqParams);
    }

    /**
     * Functionality : Clear Cheque in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCDepositClearChequeInTmp()
    {
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $aClearChequeInTmpParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $this->Depositcheque_model->FSbClearChequeInTmp($aClearChequeInTmpParams);
    }

}