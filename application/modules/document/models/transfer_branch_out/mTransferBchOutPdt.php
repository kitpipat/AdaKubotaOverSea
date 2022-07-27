<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mTransferBchOutPdt extends CI_Model
{
    /**
     * Functionality : Get Pdt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Data List Pdt
     * Return Type : Array
     */
    public function FSaMGetPdtInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $tDocKey = $paParams['tDocKey'];
        $aRowLen = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);
        // $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FNXtdSeqNo ASC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        TMP.FTBchCode,
                        TMP.FTXthDocNo,
                        TMP.FNXtdSeqNo,
                        TMP.FTXthDocKey,
                        TMP.FTPdtCode,
                        TMP.FTXtdPdtName,
                        /*TMP.FTXtdStkCode,*/
                        TMP.FTPunCode,
                        TMP.FTPunName,
                        TMP.FCXtdFactor,
                        TMP.FTXtdBarCode,
                        TMP.FTXtdVatType,
                        TMP.FTVatCode,
                        TMP.FCXtdVatRate,
                        TMP.FCXtdQty,
                        TMP.FCXtdQtyAll,
                        TMP.FCXtdSetPrice,
                        TMP.FCXtdAmt,
                        TMP.FCXtdVat,
                        TMP.FCXtdVatable,
                        TMP.FCXtdNet,
                        TMP.FCXtdCostIn,
                        TMP.FCXtdCostEx,
                        TMP.FTXtdStaPrcStk,
                        TMP.FNXtdPdtLevel,
                        TMP.FTXtdPdtParent,
                        TMP.FCXtdQtySet,
                        TMP.FTXtdPdtStaSet,
                        TMP.FTXtdRmk,
                        TMP.FTSessionID,

                        TMP.FDLastUpdOn,
                        TMP.FDCreateOn,
                        TMP.FTLastUpdBy,
                        TMP.FTCreateBy
                    FROM TCNTDocDTTmp TMP WITH(NOLOCK)
                    WHERE TMP.FTSessionID = '$tUserSessionID'
                    AND TMP.FTXthDocKey = '$tDocKey'
        ";

        $tSearchList = $paParams['tSearchAll'];
        if ($tSearchList != '') {
            $tSQL .= " AND ((TMP.FTPdtCode COLLATE THAI_BIN LIKE '%$tSearchList%') OR (TMP.FTXtdPdtName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (TMP.FTXtdBarCode COLLATE THAI_BIN LIKE '%$tSearchList%') OR (TMP.FTPunName COLLATE THAI_BIN LIKE '%$tSearchList%'))";
        }

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $nFoundRow = $this->FSnMTFWGetPdtInTmpPageAll($paParams);
            $nPageAll = ceil($nFoundRow / $paParams['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paParams['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            // No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paParams['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality : Count Pdt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Count Pdt
     * Return Type : Number
     */
    public function FSnMTFWGetPdtInTmpPageAll($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $tDocKey = $paParams['tDocKey'];
        $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT 
                FTSessionID
            FROM TCNTDocDTTmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID' 
            AND TMP.FTXthDocKey = '$tDocKey'
        ";

        $tSearchList = $paParams['tSearchAll'];
        if ($tSearchList != '') {
            $tSQL .= " AND ((TMP.FTPdtCode COLLATE THAI_BIN LIKE '%$tSearchList%') OR (TMP.FTXtdPdtName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (TMP.FTXtdBarCode COLLATE THAI_BIN LIKE '%$tSearchList%') OR (TMP.FTPunName COLLATE THAI_BIN LIKE '%$tSearchList%'))";
        }
        
        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

    /**
     * Functionality : Update Pdt Value in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbUpdatePdtInTmpBySeq($paParams = [])
    {
        $this->db->set($paParams['tFieldName'], $paParams['tValue']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTXthDocNo', $paParams['tDocNo']);
        $this->db->where('FNXtdSeqNo', $paParams['nSeqNo']);
        $this->db->where('FTXthDocKey', $paParams['tDocKey']);
        $this->db->update('TCNTDocDTTmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Delete Pdt in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbDeletePdtInTmpBySeq($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTXthDocNo', $paParams['tDocNo']);
        $this->db->where('FTXthDocKey', $paParams['tDocKey']);
        $this->db->where('FNXtdSeqNo', $paParams['nSeqNo']);
        $this->db->delete('TCNTDocDTTmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Delete More Pdt in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbDeleteMorePdtInTmpBySeq($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTXthDocNo', $paParams['tDocNo']);
        $this->db->where('FTXthDocKey', $paParams['tDocKey']);
        $this->db->where_in('FNXtdSeqNo', $paParams['aSeqNo']);
        $this->db->delete('TCNTDocDTTmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Clear Pdt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Delete
     * Return Type : Boolean
     */
    public function FSbClearPdtInTmp($paParams = [])
    {
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTBddTypeForDeposit', '1');
        $this->db->delete('TCNTDocDTTmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Function Get Max Seq From Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Max Seq
     * Return Type : array
     */
    public function FSnMGetMaxSeqDTTemp($paParams = [])
    {
        $tDocNo = $paParams['tDocNo'];
        $tDocKey = $paParams['tDocKey'];
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQL = "
            SELECT 
                MAX(DOCTMP.FNXtdSeqNo) AS maxSeqNo
            FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
            WHERE 1 = 1
        ";

        $tSQL .= " AND DOCTMP.FTXthDocNo = '$tDocNo'";

        $tSQL .= " AND DOCTMP.FTXthDocKey = '$tDocKey'";

        $tSQL .= " AND DOCTMP.FTSessionID = '$tUserSessionID'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result_array();
            $aResult = $oDetail[0]['maxSeqNo'];
        } else {
            $aResult = 0;
        }

        return empty($aResult) ? 0 : $aResult;
    }

    /**
     * Functionality : Get Pdt Data
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Pdt Data
     * Return Type : array
     */
    public function FSaMGetDataPdt($paParams = []){

        $tPdtCode = $paParams['tPdtCode'];
        $FTPunCode = $paParams['tPunCode'];
        $FTBarCode = $paParams['tBarCode'];
        $nLngID = $paParams['nLngID'];

        $tSQL = "
            SELECT
                PDT.FTPdtCode,
                PDT.FTPdtStkControl,
                PDT.FTPdtGrpControl,
                PDT.FTPdtForSystem,
                PDT.FCPdtQtyOrdBuy,
                PDT.FCPdtCostDef,
                PDT.FCPdtCostOth,
                PDT.FCPdtCostStd,
                PDT.FCPdtMin,
                PDT.FCPdtMax,
                PDT.FTPdtPoint,
                PDT.FCPdtPointTime,
                PDT.FTPdtType,
                PDT.FTPdtSaleType,
                ISNULL(PRI4PDT.FCPgdPriceRet,0) AS FTPdtSalePrice,
                PDT.FTPdtSetOrSN,
                PDT.FTPdtStaSetPri,
                PDT.FTPdtStaSetShwDT,
                PDT.FTPdtStaAlwDis,
                PDT.FTPdtStaAlwReturn,
                PDT.FTPdtStaVatBuy,
                PDT.FTPdtStaVat,
                PDT.FTPdtStaActive,
                PDT.FTPdtStaAlwReCalOpt,
                PDT.FTPdtStaCsm,
                PDT.FTTcgCode,
                PDT.FTPtyCode,
                PDT.FTPbnCode,
                PDT.FTPmoCode,
                PDT.FTVatCode,
                PDT.FDPdtSaleStart,
                PDT.FDPdtSaleStop,
                PDTL.FTPdtName,
                PDTL.FTPdtNameOth,
                PDTL.FTPdtNameABB,
                PDTL.FTPdtRmk,
                PKS.FTPunCode,
                PKS.FCPdtUnitFact,
                VAT.FCVatRate,
                UNTL.FTPunName,
                BAR.FTBarCode,
                BAR.FTPlcCode,
                PDTLOCL.FTPlcName,
                PDTSRL.FTSrnCode,
                PDT.FCPdtCostStd,
                CAVG.FCPdtCostEx,
                CAVG.FCPdtCostIn,
                SPL.FCSplLastPrice
            FROM TCNMPdt PDT WITH (NOLOCK)
            LEFT JOIN TCNMPdt_L PDTL        WITH (NOLOCK)   ON PDT.FTPdtCode      = PDTL.FTPdtCode    AND PDTL.FNLngID    = $nLngID
            LEFT JOIN TCNMPdtPackSize  PKS  WITH (NOLOCK)   ON PDT.FTPdtCode      = PKS.FTPdtCode     AND PKS.FTPunCode   = '$FTPunCode'
            LEFT JOIN TCNMPdtUnit_L UNTL    WITH (NOLOCK)   ON UNTL.FTPunCode     = '$FTPunCode'      AND UNTL.FNLngID    = $nLngID
            LEFT JOIN TCNMPdtBar BAR        WITH (NOLOCK)   ON PKS.FTPdtCode      = BAR.FTPdtCode     AND BAR.FTPunCode   = '$FTPunCode'
            LEFT JOIN TCNMPdtLoc_L PDTLOCL  WITH (NOLOCK)   ON PDTLOCL.FTPlcCode  = BAR.FTPlcCode     AND PDTLOCL.FNLngID = $nLngID
            LEFT JOIN (
                SELECT DISTINCT
                    FTVatCode,
                    FCVatRate,
                    FDVatStart
                FROM TCNMVatRate WITH (NOLOCK)
                WHERE CONVERT(VARCHAR(19),GETDATE(),121) > FDVatStart ) VAT
            ON PDT.FTVatCode = VAT.FTVatCode
            LEFT JOIN TCNTPdtSerial PDTSRL  WITH (NOLOCK)   ON PDT.FTPdtCode    = PDTSRL.FTPdtCode
            LEFT JOIN TCNMPdtSpl SPL        WITH (NOLOCK)   ON PDT.FTPdtCode    = SPL.FTPdtCode AND BAR.FTBarCode = SPL.FTBarCode
            LEFT JOIN TCNMPdtCostAvg CAVG   WITH (NOLOCK)   ON PDT.FTPdtCode    = CAVG.FTPdtCode
            LEFT JOIN (
                SELECT DISTINCT
                    P4PDT.FTPdtCode,
                    P4PDT.FTPunCode,
                    P4PDT.FDPghDStart,
                    P4PDT.FTPghTStart,
                    P4PDT.FCPgdPriceRet,
                    P4PDT.FCPgdPriceWhs,
                    P4PDT.FCPgdPriceNet
                FROM TCNTPdtPrice4PDT P4PDT WITH (NOLOCK)
                WHERE 1=1
                AND (CONVERT(VARCHAR(10),GETDATE(),121) >= CONVERT(VARCHAR(10),P4PDT.FDPghDStart,121))
                AND (CONVERT(VARCHAR(10),GETDATE(),121) <= CONVERT(VARCHAR(10),P4PDT.FDPghDStop,121))
            ) AS PRI4PDT
            ON PDT.FTPdtCode = PRI4PDT.FTPdtCode AND PRI4PDT.FTPunCode = PKS.FTPunCode
            WHERE 1 = 1
        ";
        
        if($tPdtCode!= ""){
            $tSQL .= "AND PDT.FTPdtCode = '$tPdtCode'";
        }

        if($FTBarCode!= ""){
            $tSQL .= "AND BAR.FTBarCode = '$FTBarCode'";
        }
        
        $tSQL .= " ORDER BY FDVatStart DESC";
        
        $oQuery = $this->db->query($tSQL);
        
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItem'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $tResult = json_encode($aResult);
        $aResult = json_decode($tResult, true);
        return $aResult;
    }

    /**
     * Functionality : Insert DT to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : array
     */
    public function FSaMInsertPDTToTemp($paData = [], $paDataWhere = []){
        
        $paData = $paData['raItem'];
        if($paDataWhere['tOptionAddPdt'] == '1'){
            // นำสินค้าเพิ่มจำนวนในแถวแรก
            $tSQL = "   
                SELECT 
                    FNXtdSeqNo, 
                    FCXtdQty 
                FROM TCNTDocDTTmp 
                WHERE FTBchCode = '".$paDataWhere['tBchCode']."' 
                AND FTXthDocNo = '".$paDataWhere['tDocNo']."'
                AND FTXthDocKey = '".$paDataWhere['tDocKey']."'
                AND FTSessionID = '".$paDataWhere['tUserSessionID']."'
                AND FTPdtCode = '".$paData["FTPdtCode"]."' 
                AND FTXtdBarCode = '".$paData["FTBarCode"]."'
                ORDER BY FNXtdSeqNo
            ";
            
            $oQuery = $this->db->query($tSQL);
            
            if($oQuery->num_rows() > 0){ // เพิ่มจำนวนให้รายการที่มีอยู่แล้ว
                $aResult = $oQuery->row_array();
                $tSQL = "
                    UPDATE TCNTDocDTTmp SET
                        FCXtdQty = '".($aResult["FCXtdQty"] + 1 )."'
                    WHERE 
                    FTBchCode = '".$paDataWhere['tBchCode']."' AND
                    FTXthDocNo  = '".$paDataWhere['tDocNo']."' AND
                    FNXtdSeqNo = '".$aResult["FNXtdSeqNo"]."' AND
                    FTXthDocKey = '".$paDataWhere['tDocKey']."' AND
                    FTSessionID = '".$paDataWhere['tUserSessionID']."' AND
                    FTPdtCode = '".$paData["FTPdtCode"]."' AND 
                    FTXtdBarCode = '".$paData["FTBarCode"]."'";
                
                $this->db->query($tSQL);
                
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Success.',
                );
            }else{
                
                // เพิ่มรายการใหม่
                $this->db->set('FTPdtCode', $paData['FTPdtCode']);
                $this->db->set('FTXtdPdtName', $paData['FTPdtName']);
                $this->db->set('FCXtdFactor', $paData['FCPdtUnitFact']);
                $this->db->set('FCPdtUnitFact', $paData['FCPdtUnitFact']);
                $this->db->set('FTPunCode', $paData['FTPunCode']);
                $this->db->set('FTPunName', $paData['FTPunName']);
                $this->db->set('FTXtdVatType', $paData['FTPdtStaVatBuy']);
                $this->db->set('FTVatCode', $paData['FTVatCode']);
                $this->db->set('FCXtdVatRate', $paData['FCVatRate']);
                $this->db->set('FCXtdNet', $paData['FTPdtPoint'] * $paData['FCPdtCostStd']);
                $this->db->set('FTXtdStaAlwDis', $paData['FTPdtStaAlwDis']);
                $this->db->set('FCXtdQty', 1);  // เพิ่มสินค้าใหม่
                $this->db->set('FCXtdQtyAll', 1*$paData['FCPdtUnitFact']); // จากสูตร qty * fector
                $this->db->set('FCXtdSalePrice', $paData['FTPdtSalePrice']);

                $this->db->set('FTBchCode', $paDataWhere['tBchCode']);
                $this->db->set('FTXthDocNo', $paDataWhere['tDocNo']);
                $this->db->set('FNXtdSeqNo', $paDataWhere['nMaxSeqNo']);
                $this->db->set('FTXthDocKey', $paDataWhere['tDocKey']);
                $this->db->set('FTXtdBarCode', $paDataWhere['tBarCode']);
                $this->db->set('FCXtdSetPrice', $paDataWhere['pcPrice'] * 1); // pcPrice มาจากข้อมูลใน modal คือ (ต้อทุนต่อหน่วยเล็กสุด * fector) จะได้จากสูตร  pcPrice * rate  (rate ต้องนำมาจากสกุลเงินของ company)
                $this->db->set('FTSessionID', $paDataWhere['tUserSessionID']);
                $this->db->set('FDLastUpdOn', date('Y-m-d h:i:s'));
                $this->db->set('FTLastUpdBy', $this->session->userdata('tSesUsername'));
                $this->db->set('FDCreateOn', date('Y-m-d h:i:s'));
                $this->db->set('FTCreateBy', $this->session->userdata('tSesUsername'));
                        
                $this->db->insert('TCNTDocDTTmp');

                $this->db->last_query();  

                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success.',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add.',
                    );
                }
            }
        }else{
            // เพิ่มแถวใหม่
            $this->db->set('FTPdtCode', $paData['FTPdtCode']);
            $this->db->set('FTXtdPdtName', $paData['FTPdtName']);
            $this->db->set('FCXtdFactor', $paData['FCPdtUnitFact']);
            $this->db->set('FCPdtUnitFact', $paData['FCPdtUnitFact']);
            $this->db->set('FTPunCode', $paData['FTPunCode']);
            $this->db->set('FTPunName', $paData['FTPunName']);
            $this->db->set('FTXtdVatType', $paData['FTPdtStaVatBuy']);
            $this->db->set('FTVatCode', $paData['FTVatCode']);
            $this->db->set('FCXtdVatRate', $paData['FCVatRate']);
            $this->db->set('FCXtdNet', $paData['FTPdtPoint'] * $paData['FCPdtCostStd']);
            $this->db->set('FTXtdStaAlwDis', $paData['FTPdtStaAlwDis']);
            $this->db->set('FCXtdQty', 1);  // เพิ่มสินค้าใหม่
            $this->db->set('FCXtdQtyAll', 1*$paData['FCPdtUnitFact']); // จากสูตร qty * fector
            $this->db->set('FCXtdSalePrice', $paData['FTPdtSalePrice']);

            $this->db->set('FTBchCode', $paDataWhere['tBchCode']);
            $this->db->set('FTXthDocNo', $paDataWhere['tDocNo']);
            $this->db->set('FNXtdSeqNo', $paDataWhere['nMaxSeqNo']);
            $this->db->set('FTXthDocKey', $paDataWhere['tDocKey']);
            $this->db->set('FTXtdBarCode', $paDataWhere['tBarCode']);
            $this->db->set('FCXtdSetPrice', $paDataWhere['pcPrice'] * 1); // pcPrice มาจากข้อมูลใน modal คือ (ต้อทุนต่อหน่วยเล็กสุด * fector) จะได้จากสูตร  pcPrice * rate  (rate ต้องนำมาจากสกุลเงินของ company)
            $this->db->set('FTSessionID', $paDataWhere['tUserSessionID']);
            $this->db->set('FDLastUpdOn', date('Y-m-d h:i:s'));
            $this->db->set('FTLastUpdBy', $this->session->userdata('tSesUsername'));
            $this->db->set('FDCreateOn', date('Y-m-d h:i:s'));
            $this->db->set('FTCreateBy', $this->session->userdata('tSesUsername'));

            $this->db->insert('TCNTDocDTTmp');

            $this->db->last_query();  

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add.',
                );
            }
        }
        
        return $aStatus;
        
    }

    /**
     * Functionality : คำนวณใน DT Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxMCalInTmp($aParams = [])
    {
        $tUserSessionID = $aParams['tUserSessionID'];
        $tDocKey = $aParams['tDocKey'];

        $tSQL = "
            SELECT
                SUM(CASE 
                    WHEN TMP.FTBddTypeForDeposit = '1' THEN ISNULL(TMP.FCBddRefAmtForDeposit, 0)
                    ELSE 0
                END) AS FCBddRefAmtCashTotal,
                SUM(CASE 
                    WHEN TMP.FTBddTypeForDeposit = '2' THEN ISNULL(TMP.FCBddRefAmtForDeposit, 0)
                    ELSE 0
                END) AS FCBddRefAmtChequeTotal,
                SUM(ISNULL(TMP.FCBddRefAmtForDeposit, 0)) AS FCBddRefAmtTotal
            FROM TCNTDocDTTmp TMP WITH(NOLOCK)
            WHERE FTSessionID = '$tUserSessionID' AND FTXthDocKey = '$tDocKey'
            GROUP BY TMP.FTSessionID
        ";

        $oQuery = $this->db->query($tSQL);

        $aData = [
            'FCBddRefAmtPdtTotal' => 0,
            'FCBddRefAmtTotal' => 0
        ];

        if ($oQuery->num_rows() > 0) {
            $aData = $oQuery->row_array();
        }

        return $aData;
    }
}
