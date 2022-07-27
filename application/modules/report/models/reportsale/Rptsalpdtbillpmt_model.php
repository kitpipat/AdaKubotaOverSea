<?php defined('BASEPATH') or exit('No direct script access allowed');

class Rptsalpdtbillpmt_model extends CI_Model
{
    //Functionality: Delete Temp Report
    //Parameters:  Function Parameter
    //Creator: 10/11/2020 Sooksanti
    //Last Modified :
    //Return : Call Store Proce
    //Return Type: Array
    public function FSnMExecStoreReport($paData)
    {
        // สาขา
        $tBchCodeSelect = ($paData['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paData['tBchCodeSelect']);
        // ร้านค้า
        $tShpCodeSelect = ($paData['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paData['tShpCodeSelect']);
        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paData['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paData['tMerCodeSelect']);
        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = ($paData['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paData['tPosCodeSelect']);

        $tCstCodeFrom = empty($paData['tCstCodeFrom']) ? '' : $paData['tCstCodeFrom'];
        $tCstCodeTo = empty($paData['tCstCodeTo']) ? '' : $paData['tCstCodeTo'];

        $tCallStore = "{ CALL SP_RPTxDiscPmtByBill(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID' => $paData['nLangID'],
            'pnComName' => $paData['tCompName'],
            'ptRptCode' => $paData['tRptCode'],
            'ptUsrSession' => $paData['tUserSession'],
            'pnFilterType' => $paData['tTypeSelect'],
            // สาขา
            'ptBchL' => $tBchCodeSelect,
            'ptBchF' => $paData['tBchCodeFrom'],
            'ptBchT' => $paData['tBchCodeTo'],
            // กลุ่มร้านค้า
            'ptMerL' => $tMerCodeSelect,
            'ptMerF' => $paData['tMerCodeFrom'],
            'ptMerT' => $paData['tMerCodeTo'],
            // ร้านค้า
            'ptShpL' => $tShpCodeSelect,
            'ptShpF' => $paData['tShpCodeFrom'],
            'ptShpT' => $paData['tShpCodeTo'],
            // เครื่องจุดขาย
            'ptPosL' => $tPosCodeSelect,
            'ptPosF' => $paData['tPosCodeFrom'],
            'ptPosT' => $paData['tPosCodeTo'],
            // ลูกค้า
            'ptCstF' => $paData['tCstCodeFrom'],
            'ptCstT' => $paData['tCstCodeTo'],
            // ช่องทางขาย
            'ptChnF' => $paData['tChannelCodeFrom'],
            'ptChnT' => $paData['tChannelCodeTo'],
            // วันที่เอกสาร
            'ptDocDateF' => $paData['tDocDateFrom'],
            'ptDocDateT' => $paData['tDocDateTo'],

            'FNResult' => 0,
        );

        $oQuery = $this->db->query($tCallStore, $aDataStore);
        // echo $this->db->last_query();exit;
        if ($oQuery !== false) {
            unset($oQuery);
            return 1;
        } else {
            unset($oQuery);
            return 0;
        }
    }

    // Functionality: Get Data Page Co
    // Parameters:  Function Parameter
    // Creator: 10/11/2020 Sooksanti(Non)
    // Return : Array Data Page Nation
    // Return Type: Array
    public function FMaMRPTPagination($paDataWhere)
    {
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            SELECT
                SAL.FTRptCode
            FROM TRPTSalPdtBillPmtTmp AS SAL WITH(NOLOCK)
            WHERE 1=1
            AND SAL.FTComName = '$tComName'
            AND SAL.FTRptCode = '$tRptCode'
            AND SAL.FTUsrSession = '$tUsrSession'
        ";

        $oQuery = $this->db->query($tSQL);

        $nRptAllRecord = $oQuery->num_rows();
        $nPage = $paDataWhere['nPage'];
        $nPerPage = $paDataWhere['nPerPage'];
        $nPrevPage = $nPage - 1;
        $nNextPage = $nPage + 1;
        $nRowIDStart = (($nPerPage * $nPage) - $nPerPage);
        if ($nRptAllRecord <= $nPerPage) {
            $nTotalPage = 1;
        } else if (($nRptAllRecord % $nPerPage) == 0) {
            $nTotalPage = ($nRptAllRecord / $nPerPage);
        } else {
            $nTotalPage = ($nRptAllRecord / $nPerPage) + 1;
            $nTotalPage = (int) $nTotalPage;
        }

        // get rowid end
        $nRowIDEnd = $nPerPage * $nPage;
        if ($nRowIDEnd > $nRptAllRecord) {
            $nRowIDEnd = $nRptAllRecord;
        }

        $aRptMemberDet = array(
            "nTotalRecord" => $nRptAllRecord,
            "nTotalPage" => $nTotalPage,
            "nDisplayPage" => $paDataWhere['nPage'],
            "nRowIDStart" => $nRowIDStart,
            "nRowIDEnd" => $nRowIDEnd,
            "nPrevPage" => $nPrevPage,
            "nNextPage" => $nNextPage,
        );
        unset($oQuery);
        return $aRptMemberDet;
    }

    // Functionality: Get Data Report In Table Temp
    // Parameters:  Function Parameter
    // Creator: 10/10/2020 Sooksanti(Nont)
    // Last Modified : -
    // Return : Array Data report
    // Return Type: Array
    public function FSaMGetDataReport($paDataWhere)
    {
        $nPage = $paDataWhere['nPage'];
        // Call Data Pagination
        $aPagination = $this->FMaMRPTPagination($paDataWhere);
        $nRowIDStart = $aPagination["nRowIDStart"];
        $nRowIDEnd = $aPagination["nRowIDEnd"];
        $nTotalPage = $aPagination["nTotalPage"];
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา
        if ($nPage == $nTotalPage) {
            $tJoinFoooter = "   LEFT JOIN (
                                    SELECT
                                        FTUsrSession AS FTUsrSession_Footer,
                                        SUM(
                                            CASE
                                                WHEN TMP.FNType = 2 THEN ISNULL(TMP.FCXsdDis, 0)
                                            END
                                        ) AS FCXsdDis_SumFooter,
                                        SUM(
                                            CASE
                                                WHEN TMP.FNType = 2 THEN ISNULL(TMP.FCXsdNet, 0)
                                            END
                                        ) AS FCXsdNet_SumFooter,
                                        SUM(
                                            CASE
                                                WHEN TMP.FNType = 1 THEN ISNULL(TMP.FCXshVatable, 0)
                                            END
                                        ) AS FCXshVatable_SumFooter,
                                        SUM(
                                            CASE
                                                WHEN TMP.FNType = 1 THEN ISNULL(TMP.FCXshVat, 0)
                                            END
                                        ) AS FCXshVat_SumFooter,
                                        SUM(
                                            CASE
                                                WHEN TMP.FNType = 1 THEN ISNULL(TMP.FCXshDis+(TMP.FCXshDisPnt), 0)
                                            END
                                        ) AS FCXshDis_SumFooter,
                                        SUM(
                                            CASE
                                                WHEN TMP.FNType = 1 THEN ISNULL(TMP.FCXshRnd, 0)
                                            END
                                        ) AS FCXshRnd_SumFooter,
                                        SUM(
                                            CASE
                                                WHEN TMP.FNType = 1 THEN ISNULL(TMP.FCXshGrand, 0)
                                            END
                                        ) AS FCXshGrand_SumFooter,
                                        SUM(
                                            CASE
                                                WHEN TMP.FNType = 2 THEN ISNULL(TMP.FCXdtDisPmt, 0)
                                            END
                                        ) AS FCXdtDisPmt_SumFooter,
                                        SUM(
                                            CASE
                                                WHEN TMP.FNType = 1 THEN ISNULL(TMP.FCXshDisPnt, 0)
                                            END
                                        ) AS FCXshDisPnt_SumFooter
                                    FROM TRPTSalPdtBillPmtTmp TMP WITH(NOLOCK)
                                    WHERE 1=1
                                    AND FTComName = '$tComName'
                                    AND FTRptCode = '$tRptCode'
                                    AND FTUsrSession = '$tUsrSession'
                                    GROUP BY FTUsrSession
                                ) T ON L.FTUsrSession = T.FTUsrSession_Footer ";
                            
            $tJoinFoooter .= "  LEFT JOIN (
                                    SELECT 
                                        TMP.FTUsrSession AS FTUsrSession_Footer,
                                        SUM(
                                            CASE
                                                WHEN TMP.FNType = 2 THEN ISNULL(TMP.FCXsdAmt, 0)
                                            END
                                        ) AS FCXsdAmt_SumFooter
                                    FROM (
                                        SELECT 
                                            ROW_NUMBER() OVER(PARTITION BY FTPdtCode,FTXshDocNo,FNType ORDER BY FTPdtCode ASC) AS FTRowByPdt,
                                            FCXsdAmt,
                                            FTUsrSession,
                                            FNType
                                        FROM TRPTSalPdtBillPmtTmp WITH(NOLOCK)
                                        WHERE 1=1
                                        AND FTComName = '$tComName'
                                        AND FTRptCode = '$tRptCode'
                                        AND FTUsrSession = '$tUsrSession'
                                    ) TMP 
                                    WHERE TMP.FTRowByPdt = '1'
                                    GROUP BY FTUsrSession
                                ) T1 ON L.FTUsrSession = T1.FTUsrSession_Footer ";
        } else {
            // ถ้าไม่ใช่ให้ Select 0 เพื่อให้ Join ได้แต่จะไม่มีการ Sum
            $tJoinFoooter = "   LEFT JOIN (  
                                    SELECT '$tUsrSession' AS FTUsrSession_Footer
                                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
                                LEFT JOIN (  
                                    SELECT '$tUsrSession' AS FTUsrSession_Footer
                                ) T1 ON  L.FTUsrSession = T1.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL = "   
            SELECT
                L.*,
                T.*,
                T1.*
            FROM (
                SELECT
                    ROW_NUMBER() OVER(ORDER BY FTXshDocNo ASC) AS RowID,
                    ROW_NUMBER() OVER(PARTITION BY FTXshDocNo ORDER BY FNXshDocType ASC, FDXshDocDate ASC, FTXshDocNo ASC, FNType ASC) AS PartID,
                    ROW_NUMBER() OVER(PARTITION BY FTPdtCode,FTXshDocNo,FNType ORDER BY FTPdtCode ASC) AS FTRowByPdt,
					DENSE_RANK() OVER(PARTITION BY FTXshDocNo ORDER BY FTXshDocNo ASC,FNType ASC, FTPdtCode ASC) - 1 AS FTRowDisplay,
					SUM(1) OVER (PARTITION BY FTPdtCode,FTXshDocNo,FNType ORDER BY FTPdtCode ASC) AS FTRowMax,
                    A.*,
                    S1.FNRptGroupMember,
                    S.FCXsdAmt_SubTotal,
                    S1.FCXsdDis_SubTotal,
                    S1.FCXdtDisPmt_SubTotal,
                    S1.FCXsdNet_SubTotal
                FROM TRPTSalPdtBillPmtTmp A WITH(NOLOCK)
                /* Calculate Misures */
                LEFT JOIN (
                    SELECT 
						A.FTXshDocNo AS FTXshDocNo_SubTotal,
                        SUM( 
                            ISNULL(A.FCXsdAmt, 0)
                        ) AS FCXsdAmt_SubTotal
					FROM (
						 SELECT 
							ROW_NUMBER() OVER(PARTITION BY FTPdtCode,FTXshDocNo,FNType ORDER BY FTPdtCode ASC) AS FTRowByPdt,
							FTXshDocNo,
                            FCXsdAmt
						 FROM TRPTSalPdtBillPmtTmp
						WHERE 1=1
						AND FTComName = '$tComName'
						AND FTRptCode = '$tRptCode'
						AND FTUsrSession = '$tUsrSession'
					) A
					WHERE A.FTRowByPdt = '1'
					GROUP BY A.FTXshDocNo
                ) AS S ON A.FTXshDocNo = S.FTXshDocNo_SubTotal

                LEFT JOIN (
                    SELECT
                        FTXshDocNo AS FTXshDocNo_SubTotal,
                        COUNT(FDXshDocDate) AS FNRptGroupMember,
                        SUM( 
                            ISNULL(FCXsdDis, 0)
                        ) AS FCXsdDis_SubTotal,
                        SUM( 
                            ISNULL(FCXdtDisPmt, 0)
                        ) AS FCXdtDisPmt_SubTotal,
                        SUM( 
                            ISNULL(FCXsdNet, 0)
                        ) AS FCXsdNet_SubTotal
                    FROM TRPTSalPdtBillPmtTmp WITH(NOLOCK)
                    WHERE 1=1
                    AND FTComName = '$tComName'
                    AND FTRptCode = '$tRptCode'
                    AND FTUsrSession = '$tUsrSession'
                    GROUP BY FTXshDocNo
                ) AS S1 ON A.FTXshDocNo = S1.FTXshDocNo_SubTotal

                WHERE 1=1
                AND A.FTComName = '$tComName'
                AND A.FTRptCode = '$tRptCode'
                AND A.FTUsrSession = '$tUsrSession'
            ) AS L 
        ";

        $tSQL .= " $tJoinFoooter ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd";

        // สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FTXshDocNo ASC, L.FTRowDisplay ASC";
        // print_r($tSQL);

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aData = $oQuery->result_array();
        } else {
            $aData = null;
        }
        $aErrorList = array(
            "nErrInvalidPage" => "",
        );

        $aResualt = array(
            "aPagination" => $aPagination,
            "aRptData" => $aData,
            "aError" => $aErrorList,
        );
        unset($oQuery);
        unset($aData);
        return $aResualt;
    }
}
