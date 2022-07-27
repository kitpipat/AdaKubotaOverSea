<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cTransferBchOutPdt extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/transfer_branch_out/mTransferBchOutPdt');
        $this->load->model('document/transfer_branch_out/mTransferBchOut');
    }

    /**
     * Functionality : Get Pdt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSxCTransferBchOutGetPdtInTmp()
    {
        $tSearchAll = $this->input->post('tSearchAll');
        $tIsApvOrCancel = $this->input->post('tIsApvOrCancel');
        $nPage = $this->input->post('nPageCurrent');
        $aAlwEvent = FCNaHCheckAlwFunc('deposit/0/0');
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tDocNo = 'TBODOCTEMP';
        $tDocKey = 'TCNTPdtTboHD';

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aColumnShow = FCNaDCLGetColumnShow('TCNTPdtTboDT');

        // Calcurate Document DT Temp
        $aCalcDTParams = [
            'tDataDocEvnCall'   => '',
            'tDataVatInOrEx'    => '2',
            'tDataDocNo'        => $tDocNo,
            'tDataDocKey'       => $tDocKey,
            'tDataSeqNo'        => ''
        ];
        FCNbHCallCalcDocDTTemp($aCalcDTParams);

        $aEndOfBillParams = [
            'tSplVatType' => '2',
            'tDocNo' => $tDocNo,
            'tDocKey' => $tDocKey,
            'nLngID' => FCNaHGetLangEdit(),
            'tSesSessionID' => $this->session->userdata('tSesSessionID'),
            'tBchCode' => $this->session->userdata('tSesUsrLevel') == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata('tSesUsrBchCode')
        ];
        $aEndOfBill['aEndOfBillVat'] = FCNaDOCEndOfBillCalVat($aEndOfBillParams);
        $aEndOfBill['aEndOfBillCal'] = FCNaDOCEndOfBillCal($aEndOfBillParams);
        $aEndOfBill['tTextBath'] = FCNtNumberToTextBaht($aEndOfBill['aEndOfBillCal']['cCalFCXphGrand']);

        $aGetPdtInTmpParams  = array(
            'FNLngID' => $nLangEdit,
            'nPage' => $nPage,
            'nRow' => 20,
            'tSearchAll' => $tSearchAll,
            'tUserSessionID' => $tUserSessionID,
            'tDocKey' => $tDocKey
        );
        $aResList = $this->mTransferBchOutPdt->FSaMGetPdtInTmp($aGetPdtInTmpParams);

        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'bIsApvOrCancel' => ($tIsApvOrCancel=="1")?true:false,
            'aColumnShow' => $aColumnShow,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow
        );
        $tHtml = $this->load->view('document/transfer_branch_out/advance_table/wTransferBchOutPdtDatatable', $aGenTable, true);

        $aResponse = [
            'aEndOfBill' => $aEndOfBill,
            'html' => $tHtml
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResponse));
    }

    /**
     * Functionality : Insert Pdt to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCTransferBchOutInsertPdtToTmp()
    {
        $tDocNo = 'TBODOCTEMP';
        $tDocKey = 'TCNTPdtTboHD';
        $nLngID = $this->session->userdata("tLangID");
        $tUserSessionID = $this->session->userdata('tSesSessionID');
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCode = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCode");

        $tTransferBchOutOptionAddPdt = $this->input->post('tTransferBchOutOptionAddPdt');
        $tIsByScanBarCode = $this->input->post('tIsByScanBarCode');
        $tBarCodeByScan = $this->input->post('tBarCodeByScan');
        $tPdtData = $this->input->post('tPdtData');
        $aPdtData = json_decode($tPdtData);

        $this->db->trans_begin();

        if ($tIsByScanBarCode != '1') { // ทำงานเมื่อไม่ใช่การแสกนบาร์โค๊ดมา

            // ทำทีรายการ ตามรายการสินค้าที่เพิ่มเข้ามา
            foreach ($aPdtData as $nKey => $oItem) {
                $oPackData = $oItem->packData;

                $tPdtCode = $oPackData->PDTCode;
                $tBarCode = $oPackData->Barcode;
                $tPunCode = $oPackData->PUNCode;
                $cPrice = $oPackData->Price;

                $aGetMaxSeqDTTempParams = array(
                    'tDocNo' => $tDocNo,
                    'tDocKey' => $tDocKey,
                    'tUserSessionID' => $tUserSessionID
                );
                $nMaxSeqNo = $this->mTransferBchOutPdt->FSnMGetMaxSeqDTTemp($aGetMaxSeqDTTempParams);

                $aDataPdtParams = array(
                    'tDocNo' => $tDocNo,
                    'tBchCode' => $tBchCode, // จากสาขาที่ทำรายการ
                    'tPdtCode' => $tPdtCode, // จาก Browse Pdt
                    'tPunCode' => $tPunCode, // จาก Browse Pdt
                    'tBarCode' => $tBarCode, // จาก Browse Pdt
                    'pcPrice' => $cPrice, // ราคาสินค้าจาก Browse Pdt
                    'nMaxSeqNo' => $nMaxSeqNo + 1, // จำนวนล่าสุด Seq
                    // 'nCounts' => $nCounts,
                    'nLngID' => $nLngID, // รหัสภาษาที่ login
                    'tUserSessionID' => $tUserSessionID,
                    'tDocKey' => $tDocKey,
                    'tOptionAddPdt' => $tTransferBchOutOptionAddPdt
                );

                $aDataPdtMaster = $this->mTransferBchOutPdt->FSaMGetDataPdt($aDataPdtParams); // Data Master Pdt ข้อมูลรายการสินค้าที่เพิ่มเข้ามา

                if ($aDataPdtMaster['rtCode'] == '1') {
                    $this->mTransferBchOutPdt->FSaMInsertPDTToTemp($aDataPdtMaster, $aDataPdtParams); // นำรายการสินค้าเข้า DT Temp
                }
            }
        }

        // นำเข้ารายการสินค้าจากการแสกนบาร์โค๊ด
        if ($tIsByScanBarCode == '1') {
            $aGetPunCodeByBarCodeParams = [
                'tBarCode' => $tBarCodeByScan,
                'tSplCode' => $tSplCode
            ];
            $aPdtData = $this->mTransferBchOutPdt->FSaMCreditNoteGetPunCodeByBarCode($aGetPunCodeByBarCodeParams);

            if ($aPdtData['rtCode'] == '1') {

                $aDataWhere = array(
                    'tDocNo'    => $tDocNo,
                    'tDocKey'   => 'TAPTPcHD',
                );
                $nMaxSeqNo = $this->mTransferBchOutPdt->FSaMCreditNoteGetMaxSeqDTTemp($aDataWhere);

                $aPdtItems = $aPdtData['raItem'];
                // Loop
                $aDataPdtParams = array(
                    'tDocNo' => $tDocNo,
                    'tSplCode' => $tSplCode,
                    'tBchCode' => $tBchCode,   // จากสาขาที่ทำรายการ
                    'tPdtCode' => $aPdtItems['FTPdtCode'],  // จาก Browse Pdt
                    'tPunCode' => $aPdtItems['FTPunCode'],  // จาก Browse Pdt
                    'tBarCode' => $aPdtItems['FTBarCode'],  // จาก Browse Pdt
                    'pcPrice' => $aPdtItems['cCost'],
                    'nMaxSeqNo' => $nMaxSeqNo + 1, // จำนวนล่าสุด Seq
                    // 'nCounts' => $nCounts,
                    'nLngID' => $this->session->userdata("tLangID"), // รหัสภาษาที่ login
                    'tSessionID' => $this->session->userdata('tSesSessionID'),
                    'tDocKey' => 'TAPTPcHD',
                    'nCreditNoteOptionAddPdt' => $nCreditNoteOptionAddPdt
                );

                $aDataPdtMaster = $this->mTransferBchOutPdt->FSaMCreditNoteGetDataPdt($aDataPdtParams); // Data Master Pdt ข้อมูลรายการสินค้าที่เพิ่มเข้ามา
                if ($aDataPdtMaster['rtCode'] == '1') {
                    $nStaInsPdtToTmp = $this->mTransferBchOutPdt->FSaMCreditNoteInsertPDTToTemp($aDataPdtMaster, $aDataPdtParams); // นำรายการสินค้าเข้า DT Temp
                }
                // Loop
            } else {
                $aStatus = array(
                    'rtCode' => '800',
                    'rtDesc' => 'Data not found.',
                );
                $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aStatus));
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess InsertPdtToTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success InsertPdtToTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Update Pdt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCTransferBchOutUpdatePdtInTmp()
    {
        $tFieldName = $this->input->post('tFieldName');
        $tValue = $this->input->post('tValue');
        $nSeqNo = $this->input->post('nSeqNo');
        $tDocNo = 'TBODOCTEMP';
        $tDocKey = 'TCNTPdtTboHD';
        $tBchCode = $this->input->post('tBchCode');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");

        $this->db->trans_begin();

        $aUpdatePdtInTmpBySeqParams = [
            'tFieldName' => $tFieldName,
            'tValue' => $tValue,
            'tUserSessionID' => $tUserSessionID,
            'tDocNo' => $tDocNo,
            'tDocKey' => $tDocKey,
            'nSeqNo' => $nSeqNo,
        ];
        $this->mTransferBchOutPdt->FSbUpdatePdtInTmpBySeq($aUpdatePdtInTmpBySeqParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess UpdatePdtInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success UpdatePdtInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Delete Pdt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCTransferBchOutDeletePdtInTmp()
    {
        $nSeqNo = $this->input->post('nSeqNo');
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $this->db->trans_begin();

        $aDeleteInTmpBySeqParams = [
            'tUserSessionID' => $tUserSessionID,
            'tDocNo' => 'TBODOCTEMP',
            'tDocKey' => 'TCNTPdtTboHD',
            'nSeqNo' => $nSeqNo,
        ];
        $this->mTransferBchOutPdt->FSbDeletePdtInTmpBySeq($aDeleteInTmpBySeqParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess DeletePdtInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success DeletePdtInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Delete More Pdt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCTransferBchOutDeleteMorePdtInTmp()
    {
        $tSeqNo = $this->input->post('tSeqNo');
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $this->db->trans_begin();

        $aDeleteInTmpBySeqParams = [
            'tUserSessionID' => $tUserSessionID,
            'tDocNo' => 'TBODOCTEMP',
            'tDocKey' => 'TCNTPdtTboHD',
            'aSeqNo' => json_decode(FCNtAddSingleQuote($tSeqNo)),
        ];
        $this->mTransferBchOutPdt->FSbDeleteMorePdtInTmpBySeq($aDeleteInTmpBySeqParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess DeleteMorePdtInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success DeleteMorePdtInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Clear Pdt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCTransferBchOutClearPdtInTmp()
    {
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $aClearPdtInTmpParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $this->mTransferBchOutPdt->FSbClearPdtInTmp($aClearPdtInTmpParams);
    }

    /**
     * Functionality : Get Pdt Column List
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FStCTransferBchOutGetPdtColumnList()
    {

        $aAvailableColumn = FCNaDCLAvailableColumn('TCNTPdtTboDT');
        $aData['aAvailableColumn'] = $aAvailableColumn;
        $this->load->view('document/transfer_branch_out/advance_table/wTransferBchOutPdtColList', $aData);
    }

    /**
     * Functionality : Update Pdt Column
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FStCTransferBchOutUpdatePdtColumn()
    {

        $aColShowSet = $this->input->post('aColShowSet');
        $aColShowAllList = $this->input->post('aColShowAllList');
        $aColumnLabelName = $this->input->post('aColumnLabelName');
        $nStaSetDef = $this->input->post('nStaSetDef');

        $this->db->trans_begin();

        FCNaDCLSetShowCol('TCNTPdtTboDT', '', '');

        if ($nStaSetDef == 1) {
            FCNaDCLSetDefShowCol('TCNTPdtTboDT');
        } else {
            for ($i = 0; $i < count($aColShowSet); $i++) {

                FCNaDCLSetShowCol('TCNTPdtTboDT', 1, $aColShowSet[$i]);
            }
        }

        // Reset Seq
        FCNaDCLUpdateSeq('TCNTPdtTboDT', '', '', '');
        $q = 1;
        for ($n = 0; $n < count($aColShowAllList); $n++) {
            FCNaDCLUpdateSeq('TCNTPdtTboDT', $aColShowAllList[$n], $q, $aColumnLabelName[$n]);
            $q++;
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess UpdatePdtColumn"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success UpdatePdtColumn'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }
}
