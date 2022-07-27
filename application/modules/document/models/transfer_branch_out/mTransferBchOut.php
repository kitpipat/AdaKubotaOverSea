<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mTransferBchOut extends CI_Model
{

    /**
     * Functionality : HD List
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : HD List
     * Return Type : Array
     */
    public function FSaMHDList($paParams = [])
    {
        $aRowLen = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);
        $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC, FTXthDocNo DESC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        HD.*,
                        BCHL.FTBchName,
                        USRL.FTUsrName AS FTCreateByName,
                        USRLAPV.FTUsrName AS FTXthApvName
                    FROM TCNTPdtTboHD HD WITH (NOLOCK)
                    LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON BCHL.FTBchCode = HD.FTBchCode
                    LEFT JOIN TCNMUser_L USRL WITH (NOLOCK) ON USRL.FTUsrCode = HD.FTCreateBy AND USRL.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L USRLAPV WITH (NOLOCK) ON HD.FTXthApvCode = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID
                    WHERE 1=1
        ";

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= "
                AND HD.FTBchCode IN ($tBchCode)
            ";
        }

        $aAdvanceSearch = $paParams['aAdvanceSearch'];

        $tSearchList = $aAdvanceSearch['tSearchAll'];
        if ($tSearchList != '') {
            $tSQL .= " AND ((HD.FTXthDocNo COLLATE THAI_BIN LIKE '%$tSearchList%') OR (BCHL.FTBchName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRL.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRLAPV.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%'))";
        }

        // จากสาขา - ถึงสาขา
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo = $aAdvanceSearch['tSearchBchCodeTo'];
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)) {
            $tSQL .= " AND ((HD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (HD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // จากวันที่ - ถึงวันที่
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo = $aAdvanceSearch['tSearchDocDateTo'];

        if (!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)) {
            $tSQL .= " AND ((HD.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (HD.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 00:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 23:59:59')))";
        }

        // สถานะเอกสาร
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {
            if ($tSearchStaDoc == 2) {
                $tSQL .= " AND HD.FTXthStaDoc = '$tSearchStaDoc' OR HD.FTXthStaDoc = ''";
            } else {
                $tSQL .= " AND HD.FTXthStaDoc = '$tSearchStaDoc'";
            }
        }

        // สถานะอนุมัติ
        $tSearchStaApprove = $aAdvanceSearch['tSearchStaApprove'];
        if (!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")) {
            if ($tSearchStaApprove == 2) {
                $tSQL .= " AND HD.FTXthStaApv = '$tSearchStaApprove'";
            } else {
                $tSQL .= " AND HD.FTXthStaApv = '$tSearchStaApprove'";
            }
        }

        // สถานะประมวลผล
        $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        if (!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")) {

            if ($tSearchStaPrcStk == 3) {
                $tSQL .= " AND HD.FTXthStaPrcStk = '$tSearchStaPrcStk' OR HD.FTXthStaPrcStk = '' ";
            } else {
                $tSQL .= " AND HD.FTXthStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $nFoundRow = $this->FSnMHDListGetPageAll($paParams);
            $nPageAll = ceil($nFoundRow / $paParams['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems' => $oList,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paParams['nPage'],
                'rnAllPage' => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
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
     * Functionality : Count HD Row
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Count Row
     * Return Type : Number
     */
    public function FSnMHDListGetPageAll($paParams = [])
    {
        $tSQL = "
            SELECT 
                HD.FTXthDocNo
            FROM TCNTPdtTboHD HD WITH (NOLOCK)
            WHERE 1=1
        ";

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= "
                AND HD.FTBchCode IN ($tBchCode)
            ";
        }

        $aAdvanceSearch = $paParams['aAdvanceSearch'];

        $tSearchList = $aAdvanceSearch['tSearchAll'];
        if ($tSearchList != '') {
            $tSQL .= " AND ((HD.FTXthDocNo COLLATE THAI_BIN LIKE '%$tSearchList%') OR (BCHL.FTBchName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRL.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRLAPV.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%'))";
        }

        // จากสาขา - ถึงสาขา
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo = $aAdvanceSearch['tSearchBchCodeTo'];
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)) {
            $tSQL .= " AND ((HD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (HD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // จากวันที่ - ถึงวันที่
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo = $aAdvanceSearch['tSearchDocDateTo'];

        if (!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)) {
            $tSQL .= " AND ((HD.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (HD.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 00:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 23:59:59')))";
        }

        // สถานะเอกสาร
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {
            if ($tSearchStaDoc == 2) {
                $tSQL .= " AND HD.FTXthStaDoc = '$tSearchStaDoc' OR HD.FTXthStaDoc = ''";
            } else {
                $tSQL .= " AND HD.FTXthStaDoc = '$tSearchStaDoc'";
            }
        }

        // สถานะอนุมัติ
        $tSearchStaApprove = $aAdvanceSearch['tSearchStaApprove'];
        if (!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")) {
            if ($tSearchStaApprove == 2) {
                $tSQL .= " AND HD.FTXthStaApv = '$tSearchStaApprove'";
            } else {
                $tSQL .= " AND HD.FTXthStaApv = '$tSearchStaApprove'";
            }
        }

        // สถานะประมวลผล
        $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        if (!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")) {

            if ($tSearchStaPrcStk == 3) {
                $tSQL .= " AND HD.FTXthStaPrcStk = '$tSearchStaPrcStk' OR HD.FTXthStaPrcStk = '' ";
            } else {
                $tSQL .= " AND HD.FTXthStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

    // ข้อมูลของริษัท
    public function FStTFWGetShpCodeForUsrLogin($paParams = [])
    {
        $nLngID     = $paParams['FNLngID'];
        $tUsrLogin  = $paParams['tUsrLogin'];

        $tSQL = "
            SELECT UGP.FTBchCode,
                BCHL.FTBchName,
                MCHL.FTMerCode,
                MCHL.FTMerName,
                UGP.FTShpCode,
                SHPL.FTShpName,
                SHP.FTShpType,
                SHP.FTWahCode AS FTWahCode,
                WAHL.FTWahName AS FTWahName
                /* BCH.FTWahCode AS FTWahCode_Bch, 
                BWAHL.FTWahName AS FTWahName_Bch  */
                        
            FROM TCNTUsrGroup UGP WITH (NOLOCK)
            LEFT JOIN TCNMBranch  BCH WITH (NOLOCK) ON UGP.FTBchCode = BCH.FTBchCode 
            LEFT JOIN TCNMBranch_L  BCHL WITH (NOLOCK) ON UGP.FTBchCode = BCHL.FTBchCode 
            /* LEFT JOIN TCNMWaHouse_L BWAHL ON BCH.FTWahCode = BWAHL.FTWahCode */
            LEFT JOIN TCNMShop      SHP WITH (NOLOCK) ON UGP.FTShpCode = SHP.FTShpCode
            LEFT JOIN TCNMMerchant_L  MCHL WITH (NOLOCK) ON SHP.FTMerCode = MCHL.FTMerCode AND  MCHL.FNLngID = '" . $nLngID . "'
            LEFT JOIN TCNMShop_L    SHPL WITH (NOLOCK) ON SHP.FTShpCode = SHPL.FTShpCode AND SHP.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = '" . $nLngID . "'
            LEFT JOIN TCNMWaHouse_L WAHL WITH (NOLOCK) ON SHP.FTWahCode = WAHL.FTWahCode 
            WHERE FTUsrCode = '$tUsrLogin'
        ";

        $aResult = [];

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = $oQuery->row_array();
        }

        return $aResult;
    }

    /**
     * Functionality : Get HD Detail
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : HD Detail
     * Return Type : Array
     */
    public function FSaMGetHD($paParams = [])
    {
        $tDocNo = $paParams['tDocNo'];
        $nLngID = $paParams['nLngID'];

        $tSQL = "
            SELECT
                HD.*,
                HDREF.*,
                SHIPVIAL.FTViaName,
                BCHL.FTBchName,
                CONVERT(CHAR(5), HD.FDXthDocDate, 108)  AS FTXthDocTime,
                USRAPV.FTUsrName AS FTXthApvName,
                USRL.FTUsrName AS FTCreateByName,
                RSNL.FTRsnName,
                /*===== From ===========*/
                BCHLF.FTBchName AS FTXthBchFrmName,
                MCHLF.FTMerName AS FTXthMerchantFrmName,
                SHPLF.FTShpName AS FTXthShopFrmName,
                WAHLF.FTWahName AS FTXthWhFrmName,
                /*===== To =============*/
                BCHLT.FTBchName AS FTXthBchToName,
                WAHLT.FTWahName AS FTXthWhToName
            FROM TCNTPdtTboHD HD WITH (NOLOCK)

            LEFT JOIN TCNTPdtTboHDRef HDREF WITH (NOLOCK) ON HDREF.FTXthDocNo = HD.FTXthDocNo AND HDREF.FTBchCode = HD.FTBchCode
            LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON BCHL.FTBchCode = HD.FTBchCode AND BCHL.FNLngID = $nLngID
            LEFT JOIN TCNMShipVia_L SHIPVIAL WITH (NOLOCK) ON SHIPVIAL.FTViaCode = HDREF.FTViaCode AND SHIPVIAL.FNLngID = $nLngID

            LEFT JOIN TCNMUser_L USRL WITH (NOLOCK) ON USRL.FTUsrCode = HD.FTCreateBy AND USRL.FNLngID = $nLngID
            LEFT JOIN TCNMUser_L USRAPV WITH (NOLOCK) ON USRAPV.FTUsrCode = HD.FTXthApvCode AND USRAPV.FNLngID = $nLngID

            LEFT JOIN TCNMRsn_L RSNL WITH (NOLOCK) ON RSNL.FTRsnCode = HD.FTRsnCode AND RSNL.FNLngID = $nLngID

            /*===== From =========================================*/ 
            LEFT JOIN TCNMBranch_L BCHLF WITH (NOLOCK) ON BCHLF.FTBchCode = HD.FTXthBchFrm AND BCHLF.FNLngID = $nLngID
            LEFT JOIN TCNMMerchant_L MCHLF WITH (NOLOCK) ON MCHLF.FTMerCode = HD.FTXthMerchantFrm AND MCHLF.FNLngID = $nLngID
            LEFT JOIN TCNMShop_L SHPLF WITH (NOLOCK) ON SHPLF.FTShpCode = HD.FTXthShopFrm AND SHPLF.FTBchCode = HD.FTXthBchFrm AND SHPLF.FNLngID = $nLngID
            LEFT JOIN TCNMWaHouse_L WAHLF WITH (NOLOCK) ON  WAHLF.FTWahCode = HD.FTXthWhFrm AND WAHLF.FTBchCode = HD.FTXthBchFrm AND WAHLF.FNLngID = $nLngID
            /*===== To ===========================================*/
            LEFT JOIN TCNMBranch_L BCHLT WITH (NOLOCK) ON BCHLT.FTBchCode = HD.FTXthBchTo AND BCHLT.FNLngID = $nLngID
            LEFT JOIN TCNMWaHouse_L WAHLT WITH (NOLOCK) ON  WAHLT.FTWahCode = HD.FTXthWhTo AND WAHLT.FTBchCode = HD.FTXthBchTo AND WAHLT.FNLngID = $nLngID
            WHERE 1=1
        ";

        if ($tDocNo != "") {
            $tSQL .= " AND HD.FTXthDocNo = '$tDocNo'";
        }

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->row_array();
            $aResult = array(
                'raItems' => $oDetail,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            // Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality : Insert DT to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMDTToTemp($paParams = [])
    {
        $tDocNo = $paParams['tDocNo']; // เลขที่เอกสาร
        $tDocKey = $paParams['tDocKey']; // ชื่อตาราง HD
        $tBchCode = $paParams['tBchCode']; // สาขาที่ทำรายการ
        // $tBchCodeLogin = $paParams['tBchCodeLogin'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session
        $nLngID = $paParams['nLngID'];

        // ทำการลบ ใน DT Temp ก่อนการย้าย DT ไป DT Temp
        $this->db->where('FTXthDocKey', $tDocKey);
        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->delete('TCNTDocDTTmp');

        $tSQL = "   
            INSERT TCNTDocDTTmp
                (FTBchCode,
                FTXthDocNo,
                FNXtdSeqNo,
                FTPdtCode,
                FTXtdPdtName,
                FTPunCode,
                FTPunName,
                FCXtdFactor,
                FTXtdBarCode,
                FTXtdVatType,
                FTVatCode,
                FCXtdVatRate,
                FCXtdQty,
                FCXtdQtyAll,
                FCXtdSetPrice,
                FCXtdAmt,
                FCXtdVat,
                FCXtdVatable,
                FCXtdNet,
                FCXtdCostIn,
                FCXtdCostEx,
                FTXtdStaPrcStk,
                FNXtdPdtLevel,
                FTXtdPdtParent,
                FCXtdQtySet,
                FTXtdPdtStaSet,
                FTXtdRmk,
                FDLastUpdOn,
                FTLastUpdBy,
                FDCreateOn,
                FTCreateBy,

                FTXthDocKey,
                FTSessionID)
        ";

        $tSQL .= "  
            SELECT
                DT.FTBchCode,
                'TBODOCTEMP' AS FTXthDocNo,
                DT.FNXtdSeqNo,
                DT.FTPdtCode,
                DT.FTXtdPdtName,
                DT.FTPunCode,
                DT.FTPunName,
                DT.FCXtdFactor,
                DT.FTXtdBarCode,
                DT.FTXtdVatType,
                DT.FTVatCode,
                DT.FCXtdVatRate,
                DT.FCXtdQty,
                DT.FCXtdQtyAll,
                DT.FCXtdSetPrice,
                DT.FCXtdAmt,
                DT.FCXtdVat,
                DT.FCXtdVatable,
                DT.FCXtdNet,
                DT.FCXtdCostIn,
                DT.FCXtdCostEx,
                DT.FTXtdStaPrcStk,
                DT.FNXtdPdtLevel,
                DT.FTXtdPdtParent,
                DT.FCXtdQtySet,
                DT.FTXtdPdtStaSet,
                DT.FTXtdRmk,
                DT.FDLastUpdOn,
                DT.FTLastUpdBy,
                DT.FDCreateOn,
                DT.FTCreateBy,

                '$tDocKey' AS FTXthDocKey,
                '$tUserSessionID' AS FTSessionID
            FROM TCNTPdtTboDT DT WITH(NOLOCK)
            WHERE DT.FTBchCode = '$tBchCode'
            AND DT.FTXthDocNo = '$tDocNo'
            ORDER BY DT.FNXtdSeqNo ASC
        ";

        $this->db->query($tSQL);
    }

    /**
     * Functionality : Insert Temp to DT
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMTempToDT($paParams = [])
    {
        $tDocNo = $paParams['tDocNo']; // เลขที่เอกสาร
        $tDocKey = $paParams['tDocKey']; // ชื่อตาราง HD
        $tBchCode = $paParams['tBchCode']; // สาขา
        // $tShpCode = $paParams['tShpCode']; // ร้านค้า
        // $tBchCodeLogin = $paParams['tBchCodeLogin'];
        $tUserSessionID = $paParams['tUserSessionID']; // User Session
        $tUserLoginCode = $paParams['tUserLoginCode']; // User Login Code
        // $nLngID = $paParams['nLngID'];

        // ทำการลบ ใน DT Temp ก่อนการย้าย DT ไป DT Temp
        $this->db->where('FTBchCode', $tBchCode);
        $this->db->where('FTXthDocNo', $tDocNo);
        $this->db->delete('TCNTPdtTboDT');

        $tSQL = "   
            INSERT TCNTPdtTboDT 
                (FTBchCode,
                FTXthDocNo,
                FNXtdSeqNo,
                FTPdtCode,
                FTXtdPdtName,
                FTPunCode,
                FTPunName,
                FCXtdFactor,
                FTXtdBarCode,
                FTXtdVatType,
                FTVatCode,
                FCXtdVatRate,
                FCXtdQty,
                FCXtdQtyAll,
                FCXtdSetPrice,
                FCXtdAmt,
                FCXtdVat,
                FCXtdVatable,
                FCXtdNet,
                FCXtdCostIn,
                FCXtdCostEx,
                FTXtdStaPrcStk,
                FNXtdPdtLevel,
                FTXtdPdtParent,
                FCXtdQtySet,
                FTXtdPdtStaSet,
                FTXtdRmk,
                FDLastUpdOn,
                FTLastUpdBy,
                FDCreateOn,
                FTCreateBy)
        ";

        $tSQL .= "  
            SELECT
                TMP.FTBchCode,
                TMP.FTXthDocNo,
                ROW_NUMBER() OVER(ORDER BY TMP.FNXtdSeqNo ASC) AS FNXtdSeqNo,
                TMP.FTPdtCode,
                TMP.FTXtdPdtName,
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
                GETDATE() AS FDLastUpdOn,
                '$tUserLoginCode' AS FTLastUpdBy,
                GETDATE() AS FDCreateOn,
                '$tUserLoginCode' AS FTCreateBy
            FROM TCNTDocDTTmp TMP WITH(NOLOCK)
            WHERE TMP.FTBchCode = '$tBchCode'
            AND TMP.FTXthDocKey = '$tDocKey'
            AND TMP.FTSessionID = '$tUserSessionID'
            ORDER BY TMP.FNXtdSeqNo ASC
        ";

        $this->db->query($tSQL);

        // ทำการลบ ใน DT Temp หลังการย้าย DT Temp ไป DT
        $this->db->where('FTSessionID', $tUserSessionID);
        $this->db->delete('TCNTDocDTTmp');
    }

    /**
     * Functionality : ล้างข้อมูลในตาราง tmp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxMClearInTmp($aParams = [])
    {
        $tUserSessionID = $aParams['tUserSessionID'];
        $tDocKey = $aParams['tDocKey'];

        $tSQL = "
            DELETE FROM TCNTDocDTTmp 
            WHERE FTSessionID = '$tUserSessionID' 
            AND FTXthDocKey = '$tDocKey'
        ";

        $this->db->query($tSQL);
    }

    /**
     * Functionality : Check DocNo is Duplicate
     * Parameters : DocNo
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Boolean
     */
    public function FSbMCheckDuplicate($ptDocNo = '')
    {
        $tSQL = "   
            SELECT 
                FTXthDocNo
            FROM TCNTPdtTboHD
            WHERE FTXthDocNo = '$ptDocNo'
        ";

        $bStatus = false;
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }

    /**
     * Functionality : Add or Update HD
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMAddUpdateHD($paParams = [])
    {
        // Update Master
        $this->db->set('FTBchCode', $paParams['FTBchCode']);
        $this->db->set('FDXthDocDate', $paParams['FDXthDocDate']);
        $this->db->set('FTXthVATInOrEx', $paParams['FTXthVATInOrEx']);
        $this->db->set('FTDptCode', $paParams['FTDptCode']);
        $this->db->set('FTXthBchFrm', $paParams['FTXthBchFrm']);
        $this->db->set('FTXthBchTo', $paParams['FTXthBchTo']);
        $this->db->set('FTXthMerchantFrm', $paParams['FTXthMerchantFrm']);
        $this->db->set('FTXthMerchantTo', $paParams['FTXthMerchantTo']);
        $this->db->set('FTXthShopFrm', $paParams['FTXthShopFrm']);
        $this->db->set('FTXthShopTo', $paParams['FTXthShopTo']);
        $this->db->set('FTXthWhFrm', $paParams['FTXthWhFrm']);
        $this->db->set('FTXthWhTo', $paParams['FTXthWhTo']);
        $this->db->set('FTUsrCode', $paParams['FTUsrCode']);
        $this->db->set('FTSpnCode', $paParams['FTSpnCode']);
        $this->db->set('FTXthApvCode', $paParams['FTXthApvCode']);
        $this->db->set('FTXthRefExt', $paParams['FTXthRefExt']);
        $this->db->set('FDXthRefExtDate', $paParams['FDXthRefExtDate']);
        $this->db->set('FTXthRefInt', $paParams['FTXthRefInt']);
        $this->db->set('FDXthRefIntDate', $paParams['FDXthRefIntDate']);
        $this->db->set('FNXthDocPrint', $paParams['FNXthDocPrint']);
        $this->db->set('FCXthTotal', $paParams['FCXthTotal']);
        $this->db->set('FCXthVat', $paParams['FCXthVat']);
        $this->db->set('FCXthVatable', $paParams['FCXthVatable']);
        $this->db->set('FTXthRmk', $paParams['FTXthRmk']);
        $this->db->set('FTXthStaDoc', $paParams['FTXthStaDoc']);
        $this->db->set('FTXthStaApv', $paParams['FTXthStaApv']);
        $this->db->set('FTXthStaPrcStk', $paParams['FTXthStaPrcStk']);
        $this->db->set('FTXthStaDelMQ', $paParams['FTXthStaDelMQ']);
        $this->db->set('FNXthStaDocAct', $paParams['FNXthStaDocAct']);
        $this->db->set('FNXthStaRef', $paParams['FNXthStaRef']);
        $this->db->set('FTRsnCode', $paParams['FTRsnCode']);
        $this->db->set('FDLastUpdOn', $paParams['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy', $paParams['FTLastUpdBy']);
        $this->db->where('FTXthDocNo', $paParams['FTXthDocNo']);
        $this->db->update('TCNTPdtTboHD');
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Master Success',
            );
        } else {
            // Add Master
            $this->db->set('FTBchCode', $paParams['FTBchCode']);
            $this->db->set('FTXthDocNo', $paParams['FTXthDocNo']);
            $this->db->set('FDXthDocDate', $paParams['FDXthDocDate']);
            $this->db->set('FTXthVATInOrEx', $paParams['FTXthVATInOrEx']);
            $this->db->set('FTDptCode', $paParams['FTDptCode']);
            $this->db->set('FTXthBchFrm', $paParams['FTXthBchFrm']);
            $this->db->set('FTXthBchTo', $paParams['FTXthBchTo']);
            $this->db->set('FTXthMerchantFrm', $paParams['FTXthMerchantFrm']);
            $this->db->set('FTXthMerchantTo', $paParams['FTXthMerchantTo']);
            $this->db->set('FTXthShopFrm', $paParams['FTXthShopFrm']);
            $this->db->set('FTXthShopTo', $paParams['FTXthShopTo']);
            $this->db->set('FTXthWhFrm', $paParams['FTXthWhFrm']);
            $this->db->set('FTXthWhTo', $paParams['FTXthWhTo']);
            $this->db->set('FTUsrCode', $paParams['FTUsrCode']);
            $this->db->set('FTSpnCode', $paParams['FTSpnCode']);
            $this->db->set('FTXthApvCode', $paParams['FTXthApvCode']);
            $this->db->set('FTXthRefExt', $paParams['FTXthRefExt']);
            $this->db->set('FDXthRefExtDate', $paParams['FDXthRefExtDate']);
            $this->db->set('FTXthRefInt', $paParams['FTXthRefInt']);
            $this->db->set('FDXthRefIntDate', $paParams['FDXthRefIntDate']);
            $this->db->set('FNXthDocPrint', $paParams['FNXthDocPrint']);
            $this->db->set('FCXthTotal', $paParams['FCXthTotal']);
            $this->db->set('FCXthVat', $paParams['FCXthVat']);
            $this->db->set('FCXthVatable', $paParams['FCXthVatable']);
            $this->db->set('FTXthRmk', $paParams['FTXthRmk']);
            $this->db->set('FTXthStaDoc', $paParams['FTXthStaDoc']);
            $this->db->set('FTXthStaApv', $paParams['FTXthStaApv']);
            $this->db->set('FTXthStaPrcStk', $paParams['FTXthStaPrcStk']);
            $this->db->set('FTXthStaDelMQ', $paParams['FTXthStaDelMQ']);
            $this->db->set('FNXthStaDocAct', $paParams['FNXthStaDocAct']);
            $this->db->set('FNXthStaRef', $paParams['FNXthStaRef']);
            $this->db->set('FTRsnCode', $paParams['FTRsnCode']);
            $this->db->set('FDLastUpdOn', $paParams['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paParams['FTLastUpdBy']);
            $this->db->set('FDCreateOn', $paParams['FDCreateOn']);
            $this->db->set('FTCreateBy', $paParams['FTCreateBy']);
            $this->db->insert('TCNTPdtTboHD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Master Success',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master.',
                );
            }
        }
        return $aStatus;
    }

    /**
     * Functionality : Add or Update HDRef
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMAddUpdateHDRef($paParams = [])
    {
        // Update TCNTPdtTboHDRef
        $this->db->set('FTBchCode', $paParams['FTBchCode']);
        $this->db->set('FTXthCtrName', $paParams['FTXthCtrName']);
        $this->db->set('FDXthTnfDate', $paParams['FDXthTnfDate']);
        $this->db->set('FTXthRefTnfID', $paParams['FTXthRefTnfID']);
        $this->db->set('FTXthRefVehID', $paParams['FTXthRefVehID']);
        $this->db->set('FTXthQtyAndTypeUnit', $paParams['FTXthQtyAndTypeUnit']);
        $this->db->set('FNXthShipAdd', $paParams['FNXthShipAdd']);
        $this->db->set('FTViaCode', $paParams['FTViaCode']);
        $this->db->where('FTXthDocNo', $paParams['FTXthDocNo']);
        $this->db->update('TCNTPdtTboHDRef');
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update AddUpdateHDRef Success',
            );
        } else {
            // Add TCNTPdtTboHDRef
            $this->db->set('FTBchCode', $paParams['FTBchCode']);
            $this->db->set('FTXthDocNo', $paParams['FTXthDocNo']);
            $this->db->set('FTXthCtrName', $paParams['FTXthCtrName']);
            $this->db->set('FDXthTnfDate', $paParams['FDXthTnfDate']);
            $this->db->set('FTXthRefTnfID', $paParams['FTXthRefTnfID']);
            $this->db->set('FTXthRefVehID', $paParams['FTXthRefVehID']);
            $this->db->set('FTXthQtyAndTypeUnit', $paParams['FTXthQtyAndTypeUnit']);
            $this->db->set('FNXthShipAdd', $paParams['FNXthShipAdd']);
            $this->db->set('FTViaCode', $paParams['FTViaCode']);
            $this->db->insert('TCNTPdtTboHDRef');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add AddUpdateHDRef Success',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit AddUpdateHDRef.',
                );
            }
        }
        return $aStatus;
    }

    /**
     * Functionality : Update DocNo in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMUpdateDocNoInTmp($paParams = [])
    {
        $this->db->set('FTXthDocNo', $paParams['tDocNo']);
        $this->db->where('FTXthDocNo', 'TBODOCTEMP');
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FTXthDocKey', $paParams['tDocKey']);
        $this->db->update('TCNTDocDTTmp');

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update DocNo Success',
            );
        } else {
            $aStatus = array(
                'rtCode' => '903',
                'rtDesc' => 'Update DocNo Fail',
            );
        }
        return $aStatus;
    }

    /**
     * Functionality : Cancel Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMDocCancel($paParams = [])
    {
        $this->db->set('FTXthStaDoc', '3');
        $this->db->where('FTXthDocNo', $paParams['tDocNo']);
        $this->db->update('TCNTPdtTboHD');
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Cancel Success',
            );
        } else {
            $aStatus = array(
                'rtCode' => '903',
                'rtDesc' => 'Cancel Fail',
            );
        }
        return $aStatus;
    }

    /**
     * Functionality : Approve Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Array
     */
    public function FSaMDocApprove($paParams = [])
    {
        $this->db->set('FTXthStaApv', '2');
        $this->db->set('FTXthApvCode', $paParams['tApvCode']);
        $this->db->where('FTXthDocNo', $paParams['tDocNo']);

        $this->db->update('TCNTPdtTboHD');
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Approve Success',
            );
        } else {
            $aStatus = array(
                'rtCode' => '903',
                'rtDesc' => 'Approve Fail',
            );
        }
        return $aStatus;
    }

    /**
     * Functionality : Del Document by DocNo
     * Parameters : function parameters
     * Creator : 04/02/2020 Piya
     * Return : Status Delete
     * Return Type : array
     */
    public function FSaMDelMaster($paParams = [])
    {
        $tDocNo = $paParams['tDocNo'];

        $this->db->where('FTXthDocNo', $tDocNo);
        $this->db->delete('TCNTPdtTboHD');

        $this->db->where('FTXthDocNo', $tDocNo);
        $this->db->delete('TCNTPdtTboDT');

        $this->db->where('FTXthDocNo', $tDocNo);
        $this->db->delete('TCNTPdtTboHDRef');

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'DelMaster Success',
            );
        } else {
            $aStatus = array(
                'rtCode' => '903',
                'rtDesc' => 'DelMaster Fail',
            );
        }
        return $aStatus;
    }
}
