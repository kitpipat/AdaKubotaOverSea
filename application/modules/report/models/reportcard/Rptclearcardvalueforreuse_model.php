<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Rptclearcardvalueforreuse_model extends CI_Model {

    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 05/11/2019 Piya
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter = []) {

        $tCallStore = "{CALL SP_RPTxClearCardValueForReuse(?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID' => $paDataFilter['nLngID'],
            'pnComName' => $paDataFilter['tCompName'],
            'ptRptName' => $paDataFilter['tRptCode'],
            'ptCrdF' => $paDataFilter['tCardCodeFrom'],
            'ptCrdT' => $paDataFilter['tCardCodeTo'],
            'ptCrdTypeF' => $paDataFilter['tCardTypeCodeFrom'],
            'ptCrdTypeT' => $paDataFilter['tCardTypeCodeTo'],
            'ptDocDateF' => $paDataFilter['tDocDateFrom'],
            'ptDocDateT' => $paDataFilter['tDocDateTo'],
            'FNResult' => 0
        );

        $oQuery = $this->db->query($tCallStore, $aDataStore);

        if (false !== $oQuery) {
            unset($oQuery);
            return 1;
        } else {
            unset($oQuery);
            return 0;
        }
    }

    /**
     * Functionality: Get Data Report
     * Parameters:  Function Parameter
     * Creator: 05/11/2019 Piya
     * Last Modified : -
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere = [], $paDataFilter = []) {

        $aRowLen = FCNaHCallLenData($paDataWhere['nRow'], $paDataWhere['nPage']);

        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUserSessionID = $paDataWhere['tUserSessionID'];

        $tSQL  = "  
            SELECT
                RPT.*
                FROM(
                    SELECT
                        ROW_NUMBER() OVER(ORDER BY TMP.FTTxnPosCode ASC, TMP.FDTxnDocDate ASC) AS rtRowID, TMP.* 
                    FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                    WHERE 1=1 AND TMP.FTComName = '$tCompName' AND TMP.FTRptName = '$tRptCode'
                    /*AND FTTxnDocType = 10*/   
                ) AS RPT        
            WHERE RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]
            ORDER BY RPT.FTTxnPosCode ASC, RPT.FDTxnDocDate
        ";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aDataRpt = $oQuery->result_array();

            $oCountRowRpt = $this->FSaMCountDataReportAll($paDataWhere);
            $nFoundRow = $oCountRowRpt;
            $nPageAll = ceil($nFoundRow / $paDataWhere['nRow']);
            $aReturnData = array(
                'raItems' => $aDataRpt,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paDataWhere['nPage'],
                'rnAllPage' => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aReturnData = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        unset($oQuery);
        unset($oCountRowRpt);
        unset($nFoundRow);
        unset($nPageAll);
        return $aReturnData;
    }

    /**
     * Functionality: Count Data Report All
     * Parameters: Function Parameter
     * Creator: 05/11/2019 Piya
     * Last Modified: -
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSaMCountDataReportAll($paDataWhere) {

        $tUserSessionID = $paDataWhere['tUserSessionID'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];

        $tSQL = "   
            SELECT 
                FTComName
            FROM TFCTRptCrdTmp WITH (NOLOCK)
            WHERE FTComName = '$tCompName' AND FTRptName = '$tRptCode'
            /*AND FTTxnDocType = 10*/
        ";

        $oQuery = $this->db->query($tSQL);

        $nCountData = $oQuery->num_rows();
        unset($oQuery);
        return $nCountData;
    }
}
