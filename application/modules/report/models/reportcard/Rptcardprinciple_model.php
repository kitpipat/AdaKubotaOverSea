<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Rptcardprinciple_model extends CI_Model {

    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 5/11/2019 Saharat(Golf)
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter) {

        $tCallStore = "{CALL SP_RPTxCardPrinciple(?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'           => $paDataFilter['nLangID'],
            'pnComName'         => $paDataFilter['tCompName'],
            'ptRptName'         => $paDataFilter['tRptCode'],
            'ptCrdTypeF'        => $paDataFilter['tRptCardTypeCode'],
            'ptCrdTypeT'        => $paDataFilter['tRptCardTypeCodeTo'],
            'ptYearF'           => $paDataFilter['tRptYearCode'],
            'ptYearT'           => $paDataFilter['tRptYearCodeTo'],
            'FNResult'          => 0
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
     * Creator: 29/10/2019 Saharat(GolF)
     * Last Modified : -
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere, $paDataFilter) {
        $aRowLen = FCNaHCallLenData($paDataWhere['nRow'], $paDataWhere['nPage']);

        $tUserCode  = $paDataWhere['tUserCode'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tSessionID = $paDataWhere['tUserSession'];

        $tSQL = "
            SELECT
                c.*
            FROM(
                SELECT
                    ROW_NUMBER() OVER(ORDER BY FTTxnYear ASC) AS rtRowID, *
                FROM(
                    SELECT TOP 100 PERCENT
                    TMP.FTTxnYear, 
                    TMP.FTCtyName, 
                    TMP.FNTxnCountCard, 
                    TMP.FCCrdValue 
                    FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                WHERE 1=1 AND TMP.FTComName = '$tCompName' AND TMP.FTRptName = '$tRptCode'
                ORDER BY
                TMP.FTTxnYear ASC

            ) Base ) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]

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

    //รายงานรายการต้นงวดบัตรและเงินสด[10] : count
    public function FSaMCountDataReportAll($paFilterReport){
        try{
            $tComName     = $paFilterReport['tCompName'];
            $tRptCode     = $paFilterReport['tRptCode'];
            
            $tSQL           = "SELECT COUNT(FTComName) AS FTComName FROM TFCTRptCrdTmp WITH (NOLOCK) WHERE FTComName = '$tComName' AND FTRptName = '$tRptCode'";
            $oQuery         = $this->db->query($tSQL);
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array()[0]["FTComName"];
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //รายงานรายการต้นงวดบัตรและเงินสด[10] : ผลรวม
    public function FSaMRPTCRDGetDataRptCardPrincipleSum($paFilterReport){
        $tComName = $paFilterReport['tCompName'];
        $tRptCode = $paFilterReport['tRptCode'];
        
        $tSQL = "   SELECT 
                        SUM(FNTxnCountCard) AS FNTxnCountCard,
                        SUM(FCCrdValue ) AS FCCrdValue 
                    FROM TFCTRptCrdTmp WITH (NOLOCK)   
                    WHERE FTComName = '$tComName' AND FTRptName = '$tRptCode'";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }



}
