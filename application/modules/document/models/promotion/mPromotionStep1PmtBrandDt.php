<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mPromotionStep1PmtBrandDt extends CI_Model
{
    /**
     * Functionality : Get PmtBrandDt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Data List PmtBrandDt
     * Return Type : Array
     */
    public function FSaMGetPmtBrandDtInTmp($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $tPmtGroupNameTmp = $paParams['tPmtGroupNameTmp'];
        $tPmtGroupTypeTmp = $paParams['tPmtGroupTypeTmp'];
        $tPmtGroupListTypeTmp = $paParams['tPmtGroupListTypeTmp'];
        $aRowLen = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);
        // $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FNPmdSeq ASC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        TMP.FTBchCode,
                        TMP.FTPmhDocNo,
                        TMP.FNPmdSeq,
                        TMP.FTPmdStaType,
                        TMP.FTPmdGrpName,
                        TMP.FTPmdRefCode,
                        TMP.FTPmdRefName,
                        TMP.FTPmdSubRef,
                        TMP.FTPmdSubRefName,
                        TMP.FTPmdBarCode,
                        TMP.FTPmdStaListType,
                        TMP.FTSessionID
                    FROM TCNTPdtPmtDT_Tmp TMP WITH(NOLOCK)
                    WHERE TMP.FTSessionID = '$tUserSessionID'
                    AND TMP.FTPmdGrpName = '$tPmtGroupNameTmp'
                    AND TMP.FTPmdStaType = '$tPmtGroupTypeTmp'
                    AND TMP.FTPmdStaListType = '$tPmtGroupListTypeTmp'
        ";

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $nFoundRow = $this->FSnMTFWGetPmtBrandDtInTmpPageAll($paParams);
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
     * Functionality : Count PmtBrandDt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Count PmtBrandDt
     * Return Type : Number
     */
    public function FSnMTFWGetPmtBrandDtInTmpPageAll($paParams = [])
    {
        $tUserSessionID = $paParams['tUserSessionID'];
        $tPmtGroupNameTmp = $paParams['tPmtGroupNameTmp'];
        $tPmtGroupTypeTmp = $paParams['tPmtGroupTypeTmp'];
        $tPmtGroupListTypeTmp = $paParams['tPmtGroupListTypeTmp'];
        $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT 
                FTSessionID
            FROM TCNTPdtPmtDT_Tmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FTPmdGrpName = '$tPmtGroupNameTmp'
            AND TMP.FTPmdStaType = '$tPmtGroupTypeTmp'
            AND TMP.FTPmdStaListType = '$tPmtGroupListTypeTmp'
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

    /**
     * Functionality : Get All PmtPdtDt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Count PmtPdtDt
     * Return Type : Number
     */
    public function FSaMGetPmtBrandDtInAllTmp($paParams = []){
        $tPmtGroupNameTmpOld = $paParams['tPmtGroupNameTmpOld'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $tBchCodeLogin = $paParams['tBchCodeLogin'];
        $nLngID = $paParams['FNLngID'];

        $tSQL = "
            SELECT 
                *
            FROM TCNTPdtPmtDT_Tmp TMP WITH(NOLOCK) 
            WHERE TMP.FTSessionID = '$tUserSessionID'
            AND TMP.FTBchCode = '$tBchCodeLogin'
            AND TMP.FTPmdRefCode IS NOT NULL
            AND TMP.FTPmdRefCode <> ''
            /* AND TMP.FTPmdGrpName = '$tPmtGroupNameTmpOld' */
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

    /**
     * Functionality : Insert PmtBrandDt to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaMPmtBrandDtToTemp($paParams = [])
    {
        $tPmtGroupNameTmpOld = $paParams['tPmtGroupNameTmpOld'];
        $tBchCodeLogin = $paParams['tBchCodeLogin'];
        $tUserSessionID = $paParams['tUserSessionID'];
        $tUserSessionDate = $paParams['tUserSessionDate'];

        $this->db->set('FTBchCode', $tBchCodeLogin);
        $this->db->set('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->set('FNPmdSeq', "(SELECT (ISNULL(MAX(FNPmdSeq), 0) + 1) AS FNPmdSeq FROM TCNTPdtPmtDT_Tmp WITH(NOLOCK) WHERE FTSessionID = '$tUserSessionID' AND FTBchCode = '$tBchCodeLogin')", false);
        $this->db->set('FTPmdStaType', $paParams['tPmtGroupTypeTmp']); // ประเภทกลุ่ม 1:กลุ่มร่วมรายการ 2:กลุ่มยกเว้น
        $this->db->set('FTPmdStaListType', $paParams['tPmtGroupListTypeTmp']); // ประเภทกลุ่ม 1:กลุ่มร่วมรายการ 2:กลุ่มยกเว้น
        $this->db->set('FTPmdGrpName', $tPmtGroupNameTmpOld); // ชื่อกลุ่มจัดรายการ
        $this->db->set('FTPmdRefCode', $paParams['tBrandCode']); // รหัสยี่ห้อ
        $this->db->set('FTPmdRefName', $paParams['tBrandName']); // ชื่อยี่ห้อ

        $this->db->set('FTPmdSubRef', isset($paParams['tModelCode'])?$paParams['tModelCode']:NULL); // รหัสรุ่น
        $this->db->set('FTPmdSubRefName', isset($paParams['tModelName'])?$paParams['tModelName']:NULL); // ชื่อรุ่น

        $this->db->set('FDCreateOn', $tUserSessionDate);
        $this->db->set('FTSessionID', $tUserSessionID);
        $this->db->insert('TCNTPdtPmtDT_Tmp');

        $aStatus = [
            'rtCode' => '905',
            'rtDesc' => 'Insert PmtBrandDt Fail.',
        ];

        if ($this->db->affected_rows() > 0) {
            $aStatus['rtCode'] = '1';
            $aStatus['rtDesc'] = 'Insert PmtBrandDt Success';
        }
        return $aStatus;
    }

    /**
     * Functionality : Update PmtBrandDt Value in Temp by SeqNo
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status Update
     * Return Type : Boolean
     */
    public function FSbUpdatePmtBrandDtInTmpBySeq($paParams = [])
    {
        $this->db->set('FTPmdSubRef', $paParams['tModelCode']);
        $this->db->set('FTPmdSubRefName', $paParams['tModelName']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->where('FNPmdSeq', $paParams['nSeqNo']);
        $this->db->where('FTPmdStaType', $paParams['tPmtGroupTypeTmp']);
        $this->db->where('FTPmdStaListType', $paParams['tPmtGroupListTypeTmp']);

        $this->db->update('TCNTPdtPmtDT_Tmp');

        $bStatus = false;

        if ($this->db->affected_rows() > 0) {
            $bStatus = true;
        }

        return $bStatus;
    }
}
