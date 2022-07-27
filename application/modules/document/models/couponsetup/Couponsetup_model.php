<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Couponsetup_model extends CI_Model
{

    // Functionality: Get Data Purchase Invoice HD List
    // Parameters: function parameters
    // Creator:  23/12/2019 Wasin(Yoshi)
    // Return: Data Array
    // Return Type: Array
    public function FSaMCPHGetDataTableList($paDataCondition)
    {
        $aRowLen = FCNaHCallLenData($paDataCondition['nRow'], $paDataCondition['nPage']);
        $nLngID = $paDataCondition['FNLngID'];
        $aDatSessionUserLogIn = $paDataCondition['aDatSessionUserLogIn'];
        $aAdvanceSearch = $paDataCondition['aAdvanceSearch'];
        // Advance Search
        $tSearchList = $aAdvanceSearch['tSearchAll'];
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo = $aAdvanceSearch['tSearchBchCodeTo'];
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo = $aAdvanceSearch['tSearchDocDateTo'];
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        $tSearchStaApprove = $aAdvanceSearch['tSearchStaApprove'];
        $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];

        $tSQL = "  
            SELECT c.* FROM (
                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS FNRowID,* FROM (
                    SELECT DISTINCT
                        (CASE
                            WHEN 
                                CPHD.FTCphStaDoc <> '3' AND CPHD.FTCphStaClosed = '2' 
                                AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStart,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                                AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStop,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120)  
                            THEN '1'
                            
                            WHEN 
                                CPHD.FTCphStaDoc <> '3' AND CPHD.FTCphStaClosed = '1' 
                                AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStart,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                                AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStop,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120) 
                            THEN '2'

                            WHEN  
                                CPHD.FTCphStaDoc <> '3' 
                                AND CONVERT(CHAR(10),CPHD.FDCphDateStart,120) > CONVERT(CHAR(19), GETDATE(), 120)
                            THEN '3'

                            WHEN 
                                CPHD.FTCphStaDoc <> '3' 
                                AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStop,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStop, 108)) < CONVERT(CHAR(19), GETDATE(), 120)
                            THEN '4'

                            WHEN 
                                CPHD.FTCphStaDoc = '3'
                            THEN '5'
                            
                            ELSE '6'
                        END) AS UsedStatus,
                        CPHD.FTBchCode,
                        BCHL.FTBchName,
                        CPHD.FTCphDocNo,
                        CONVERT(VARCHAR(10),CPHD.FDCreateOn,121) AS FDCphDocDate,
                        CPHD.FTCphStaDoc,
                        CPHD.FTCphStaApv,
                        CPHD.FTCphStaPrcDoc,
                        CPHD.FTCphStaDelMQ,
                        CPHDL.FTCpnName,
                        CPHD.FTUsrCode AS FTUsrCodeIns,
                        USRINS.FTUsrName AS FTUsrNameIns,
                        CPHD.FTCphUsrApv AS FTUsrCodeApv,
                        USRAPV.FTUsrName AS FTUsrNameApv,
                        CPHD.FDCreateOn AS FDCreateOn
                    FROM TFNTCouponHD CPHD WITH(NOLOCK)
                    LEFT JOIN TFNTCouponHD_L CPHDL WITH(NOLOCK) ON CPHD.FTCphDocNo = CPHDL.FTCphDocNo
                    LEFT JOIN TCNMBranch_L BCHL WITH(NOLOCK) ON CPHD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L USRINS WITH(NOLOCK) ON CPHD.FTUsrCode = USRINS.FTUsrCode AND USRINS.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L USRAPV WITH(NOLOCK) ON CPHD.FTCphUsrApv = USRAPV.FTUsrCode AND USRAPV.FNLngID = $nLngID
                    OUTER APPLY (  
                        Select *
                        From TFNTCouponHDBch TARBCH1 
                        WHERE TARBCH1.FTCphDocNo = CPHD.FTCphDocNo 
                        AND TARBCH1.FTBchCode = CPHD.FTBchCode 
                        ) TARBCH
                    WHERE ( 1=1
        ";

        // Check User Login Branch
        if ($this->session->userdata('tSesUsrLevel') != 'HQ') {
            $tUserLoginBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND CPHD.FTBchCode IN($tUserLoginBchCode)";
        }

        // Check User Login Shop
        if($this->session->userdata('nSesUsrShpCount') > 0){
            $tUserLoginShpCode = $this->session->userdata('tSesUsrShpCodeMulti');
            $tSQL .= " AND CPHD.FTShpCode IN($tUserLoginShpCode)";
        }

        // ต้นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร
        if (isset($tSearchList) && !empty($tSearchList)) {
            $tSQL .= " 
                AND (
                    (CPHD.FTCphDocNo LIKE '%$tSearchList%') 
                    OR (BCHL.FTBchName LIKE '%$tSearchList%') 
                    OR (CONVERT(VARCHAR(10),CPHD.FDCphDocDate,103) LIKE '%$tSearchList%')
                )
            ";
        }

        // ค้นหาจากสาขา - ถึงสาขา
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)) {
            $tSQL .= " 
                AND ((CPHD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (CPHD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))
            ";
        }

        // ค้นหาจากวันที่ - ถึงวันที่
        if (!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)) {
            $tSQL .= " 
                AND (
                    CONVERT(VARCHAR(10),CPHD.FDCphDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tSearchDocDateFrom',121) AND CONVERT(VARCHAR(10),'$tSearchDocDateTo',121) OR
                    CONVERT(VARCHAR(10),CPHD.FDCphDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tSearchDocDateTo',121) AND CONVERT(VARCHAR(10),'$tSearchDocDateFrom',121)
                )
            ";
        }

        // ค้นหาสถานะเอกสาร
        if (isset($tSearchStaDoc) && !empty($tSearchStaDoc)) {
            $tSQL .= " AND (CPHD.FTCphStaDoc = '$tSearchStaDoc')";
        }

        // ค้นหาสถานะอนุมัติ
        if (isset($tSearchStaApprove) && !empty($tSearchStaApprove)) {
            if ($tSearchStaApprove == 2) {
                $tSQL .= " AND (CPHD.FTCphStaApv = '$tSearchStaApprove' OR CPHD.FTCphStaApv = '' )";
            } else {
                $tSQL .= " AND (CPHD.FTCphStaApv = '$tSearchStaApprove')";
            }
        }

        // ค้นหาสถานะประมวลผล
        if (isset($tSearchStaPrcStk) && !empty($tSearchStaPrcStk)) {
            if ($tSearchStaPrcStk == 3) {
                $tSQL .= " AND (CPHD.FTCphStaPrcDoc = '$tSearchStaPrcStk' OR CPHD.FTCphStaPrcDoc = '' OR CPHD.FTCphStaPrcDoc = NULL)";
            } else {
                $tSQL .= " AND (CPHD.FTCphStaPrcDoc = '$tSearchStaPrcStk')";
            }
        }

        // สถานะการใช้งาน
        $tSearchUsedStatus = $aAdvanceSearch['tSearchUsedStatus'];
        $tSQLSearchUsedStatus = "";
        switch($tSearchUsedStatus){
            case '1' : { // หยุดการใช้งาน
                $tSQL .= "
                    AND (
                        CPHD.FTCphStaDoc <> '3' AND CPHD.FTCphStaClosed = '2' 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStart,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStop,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120) 
                    )
                ";
                $tSQLSearchUsedStatus = "
                    AND (
                        CPHD.FTCphStaDoc <> '3' AND CPHD.FTCphStaClosed = '2' 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStart,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStop,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                break;
            }
            case '2' : { // ใช้งาน
                $tSQL .= "
                    AND (
                        CPHD.FTCphStaDoc <> '3' AND CPHD.FTCphStaClosed = '1' 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStart,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStop,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                $tSQLSearchUsedStatus = "
                    AND (
                        CPHD.FTCphStaDoc <> '3' AND CPHD.FTCphStaClosed = '1' 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStart,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStop,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                break;
            }
            case '3' : { // ยังไม่เริ่ม
                $tSQL .= "
                    AND (
                        CPHD.FTCphStaDoc <> '3' 
                        AND CONVERT(CHAR(10),CPHD.FDCphDateStart,120) > CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                $tSQLSearchUsedStatus = "
                    AND (
                        CPHD.FTCphStaDoc <> '3' 
                        AND CONVERT(CHAR(10),CPHD.FDCphDateStart,120) > CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                break;
            }
            case '4' : { // หมดอายุ
                $tSQL .= "
                    AND (
                        CPHD.FTCphStaDoc <> '3' 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStop,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStop, 108)) < CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                $tSQLSearchUsedStatus = "
                    AND (
                        CPHD.FTCphStaDoc <> '3' 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStop,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStop, 108)) < CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                break;
            }
            case '5' : { // ยกเลิก
                $tSQL .= "
                    AND CPHD.FTCphStaDoc = '3'
                ";
                $tSQLSearchUsedStatus = "
                    AND CPHD.FTCphStaDoc = '3'
                ";
                break;
            }
            default : {}
        }

        $tSQL .= " ) ";

        if ($this->session->userdata('tSesUsrLevel') != 'HQ') {
            // $tUserLoginBchCode  = $aDatSessionUserLogIn['FTBchCode'];
            $tUserLoginBchCode = $this->session->userdata('tSesUsrBchCodeMulti');

            $tSQL .= "	
                OR (
                    CPHD.FTCphStaApv = 1
                    AND (
                        (TARBCH.FTCphBchTo IS NULL)
                        OR (
                            TARBCH.FTCphBchTo IN($tUserLoginBchCode)
                            AND TARBCH.FTCphStaType = 1
                        )
                        OR (
                            TARBCH.FTCphBchTo NOT IN($tUserLoginBchCode)
                            AND TARBCH.FTCphStaType = 2
                        )
                    )  
            ";

            // ค้นหา รหัสเอกสาร,ชือสาขา,วันที่เอกสาร
            if (isset($tSearchList) && !empty($tSearchList)) {
                $tSQL .= " 
                    AND (
                        (CPHD.FTCphDocNo LIKE '%$tSearchList%') 
                        OR (BCHL.FTBchName LIKE '%$tSearchList%') 
                        OR (CONVERT(VARCHAR(10),CPHD.FDCphDocDate,103) LIKE '%$tSearchList%')
                    )
                ";
            }
            
            // วันที่เอกสาร
            if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)) {
                $tSQL .= " 
                AND ((CPHD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (CPHD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
            }

            $tSQL .= $tSQLSearchUsedStatus;
            $tSQL .= ")";
        }


        $tSQL .=  ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDataList = $oQuery->result_array();
            $aDataCountAllRow = $this->FSnMCPHCountPageDocListAll($paDataCondition);
            $nFoundRow = ($aDataCountAllRow['rtCode'] == '1') ? $aDataCountAllRow['rtCountData'] : 0;
            $nPageAll = ceil($nFoundRow / $paDataCondition['nRow']);
            $aResult = array(
                'raItems' => $oDataList,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paDataCondition['nPage'],
                'rnAllPage' => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paDataCondition['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        unset($nLngID);
        unset($aDatSessionUserLogIn);
        unset($aAdvanceSearch);
        unset($tSearchList);
        unset($tSearchBchCodeFrom);
        unset($tSearchBchCodeTo);
        unset($tSearchDocDateFrom);
        unset($tSearchDocDateTo);
        unset($tSearchStaDoc);
        unset($tSearchStaApprove);
        unset($tSearchStaPrcStk);
        unset($tUserLoginBchCode);
        unset($tUserLoginShpCode);
        unset($tSQL);
        unset($oQuery);
        unset($oDataList);
        unset($aDataCountAllRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aResult;
    }

    // Functionality: Get Data Page All
    // Parameters: function parameters
    // Creator:  23/12/2019 Wasin(Yoshi)
    // Return: Data Array
    // Return Type: Array
    public function FSnMCPHCountPageDocListAll($paDataCondition)
    {
        $nLngID = $paDataCondition['FNLngID'];
        $aDatSessionUserLogIn = $paDataCondition['aDatSessionUserLogIn'];
        $aAdvanceSearch = $paDataCondition['aAdvanceSearch'];
        // Advance Search
        $tSearchList = $aAdvanceSearch['tSearchAll'];
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo = $aAdvanceSearch['tSearchBchCodeTo'];
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo = $aAdvanceSearch['tSearchDocDateTo'];
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        $tSearchStaApprove = $aAdvanceSearch['tSearchStaApprove'];
        $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];

        $tSQL = "   
            SELECT 
                COUNT(DISTINCT CPHD.FTCphDocNo) AS counts
            FROM TFNTCouponHD CPHD WITH(NOLOCK)
            LEFT JOIN TCNMBranch_L BCHL WITH(NOLOCK) ON CPHD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
            LEFT JOIN TCNMUser_L USRINS WITH(NOLOCK) ON CPHD.FTUsrCode = USRINS.FTUsrCode AND USRINS.FNLngID = $nLngID
            LEFT JOIN TCNMUser_L USRAPV WITH(NOLOCK) ON CPHD.FTCphStaApv = USRAPV.FTUsrCode AND USRAPV.FNLngID = $nLngID
            OUTER APPLY (  
                        Select  *
                        From TFNTCouponHDBch TARBCH1 
                        WHERE TARBCH1.FTCphDocNo = CPHD.FTCphDocNo 
                        AND  TARBCH1.FTBchCode = CPHD.FTBchCode 
                        ) TARBCH
            WHERE ( 1=1
        ";

        // Check User Login Branch
        if ($this->session->userdata('tSesUsrLevel') != 'HQ') {
            $tUserLoginBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND CPHD.FTBchCode IN($tUserLoginBchCode)";
        }

        // Check User Login Shop
        if($this->session->userdata('nSesUsrShpCount') > 0){
            $tUserLoginBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tUserLoginShpCode = $this->session->userdata('tSesUsrShpCodeMulti');
            $tSQL .= " AND CPHD.FTBchCode IN($tUserLoginBchCode)";
            $tSQL .= " AND CPHD.FTShpCode IN($tUserLoginShpCode)";
        }

        // ต้นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร
        if (isset($tSearchList) && !empty($tSearchList)) {
            $tSQL .= " 
                AND (
                    (CPHD.FTCphDocNo LIKE '%$tSearchList%') 
                    OR (BCHL.FTBchName LIKE '%$tSearchList%') 
                    OR (CONVERT(VARCHAR(10),CPHD.FDCphDocDate,103) LIKE '%$tSearchList%')
                )
            ";
        }

        // ค้นหาจากสาขา - ถึงสาขา
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)) {
            $tSQL .= " 
                AND ((CPHD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (CPHD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))
            ";
        }

        // ค้นหาจากวันที่ - ถึงวันที่
        if (!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)) {
            $tSQL .= " 
                AND (
                    CONVERT(VARCHAR(10),CPHD.FDCphDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tSearchDocDateFrom',121) AND CONVERT(VARCHAR(10),'$tSearchDocDateTo',121) OR
                    CONVERT(VARCHAR(10),CPHD.FDCphDocDate,121) BETWEEN CONVERT(VARCHAR(10),'$tSearchDocDateTo',121) AND CONVERT(VARCHAR(10),'$tSearchDocDateFrom',121)
                )
            ";
        }

        // ค้นหาสถานะเอกสาร
        if (isset($tSearchStaDoc) && !empty($tSearchStaDoc)) {
            $tSQL .= " AND (CPHD.FTCphStaDoc = '$tSearchStaDoc')";
        }

        // ค้นหาสถานะอนุมัติ
        if (isset($tSearchStaApprove) && !empty($tSearchStaApprove)) {
            if ($tSearchStaApprove == 2) {
                $tSQL .= " AND (CPHD.FTCphStaApv = '$tSearchStaApprove' OR CPHD.FTCphStaApv = '' )";
            } else {
                $tSQL .= " AND (CPHD.FTCphStaApv = '$tSearchStaApprove')";
            }
        }

        // ค้นหาสถานะประมวลผล
        if (isset($tSearchStaPrcStk) && !empty($tSearchStaPrcStk)) {
            if ($tSearchStaPrcStk == 3) {
                $tSQL .= " AND (CPHD.FTCphStaPrcDoc = '$tSearchStaPrcStk' OR CPHD.FTCphStaPrcDoc = '' OR CPHD.FTCphStaPrcDoc = NULL)";
            } else {
                $tSQL .= " AND (CPHD.FTCphStaPrcDoc = '$tSearchStaPrcStk')";
            }
        }

        // สถานะการใช้งาน
        $tSearchUsedStatus = $aAdvanceSearch['tSearchUsedStatus'];
        $tSQLSearchUsedStatus = "";
        switch($tSearchUsedStatus){
            case '1' : { // หยุดการใช้งาน
                $tSQL .= "
                    AND (
                        CPHD.FTCphStaDoc <> '3' AND CPHD.FTCphStaClosed = '2' 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStart,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStop,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120) 
                    )
                ";
                $tSQLSearchUsedStatus = "
                    AND (
                        CPHD.FTCphStaDoc <> '3' AND CPHD.FTCphStaClosed = '2' 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStart,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStop,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                break;
            }
            case '2' : { // ใช้งาน
                $tSQL .= "
                    AND (
                        CPHD.FTCphStaDoc <> '3' AND CPHD.FTCphStaClosed = '1' 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStart,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStop,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                $tSQLSearchUsedStatus = "
                    AND (
                        CPHD.FTCphStaDoc <> '3' AND CPHD.FTCphStaClosed = '1' 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStart,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStart, 108)) <= CONVERT(CHAR(19), GETDATE(), 120) 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStop,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStop, 108)) >= CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                break;
            }
            case '3' : { // ยังไม่เริ่ม
                $tSQL .= "
                    AND (
                        CPHD.FTCphStaDoc <> '3' 
                        AND CONVERT(CHAR(10),CPHD.FDCphDateStart,120) > CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                $tSQLSearchUsedStatus = "
                    AND (
                        CPHD.FTCphStaDoc <> '3' 
                        AND CONVERT(CHAR(10),CPHD.FDCphDateStart,120) > CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                break;
            }
            case '4' : { // หมดอายุ
                $tSQL .= "
                    AND (
                        CPHD.FTCphStaDoc <> '3' 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStop,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStop, 108)) < CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                $tSQLSearchUsedStatus = "
                    AND (
                        CPHD.FTCphStaDoc <> '3' 
                        AND CONCAT(CONVERT(CHAR(10),CPHD.FDCphDateStop,120),' ',CONVERT(CHAR(8), CPHD.FTCphTimeStop, 108)) < CONVERT(CHAR(19), GETDATE(), 120)
                    )
                ";
                break;
            }
            case '5' : { // ยกเลิก
                $tSQL .= "
                    AND CPHD.FTCphStaDoc = '3'
                ";
                $tSQLSearchUsedStatus = "
                    AND CPHD.FTCphStaDoc = '3'
                ";
                break;
            }
            default : {}
        }

        $tSQL .= " ) ";

        if ($this->session->userdata('tSesUsrLevel') != 'HQ') {
            // $tUserLoginBchCode  = $aDatSessionUserLogIn['FTBchCode'];
            $tUserLoginBchCode = $this->session->userdata('tSesUsrBchCodeMulti');

            $tSQL .= "	
                OR (
                    CPHD.FTCphStaApv = 1
                    AND (
                        (TARBCH.FTCphBchTo IS NULL)
                        OR (
                            TARBCH.FTCphBchTo IN($tUserLoginBchCode)
                            AND TARBCH.FTCphStaType = 1
                        )
                        OR (
                            TARBCH.FTCphBchTo NOT IN($tUserLoginBchCode)
                            AND TARBCH.FTCphStaType = 2
                        )
                    )  
            ";

            // ค้นหา รหัสเอกสาร,ชือสาขา,วันที่เอกสาร
            if (isset($tSearchList) && !empty($tSearchList)) {
                $tSQL .= " 
                    AND (
                        (CPHD.FTCphDocNo LIKE '%$tSearchList%') 
                        OR (BCHL.FTBchName LIKE '%$tSearchList%') 
                        OR (CONVERT(VARCHAR(10),CPHD.FDCphDocDate,103) LIKE '%$tSearchList%')
                    )
                ";
            }
            
            // วันที่เอกสาร
            if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)) {
                $tSQL .= " 
                AND ((CPHD.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (CPHD.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
            }

            $tSQL .= $tSQLSearchUsedStatus;
            $tSQL .= ")";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail = $oQuery->row_array();
            $aDataReturn = array(
                'rtCountData' => $aDetail['counts'],
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aDataReturn = array(               
                'rtCode' => '800',
                'rtDesc' => 'Data Not Found',
            );
        }
        unset($nLngID);
        unset($aDatSessionUserLogIn);
        unset($aAdvanceSearch);
        unset($tSearchList);
        unset($tSearchBchCodeFrom);
        unset($tSearchBchCodeTo);
        unset($tSearchDocDateFrom);
        unset($tSearchDocDateTo);
        unset($tSearchStaDoc);
        unset($tSearchStaApprove);
        unset($tSearchStaPrcStk);
        unset($tUserLoginBchCode);
        unset($tUserLoginShpCode);
        unset($tSQL);
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }

    // Functionality: Get Data Detail DT
    // Parameters: function parameters
    // Creator:  25/12/2019 Wasin(Yoshi)
    // Return: Data Array
    // Return Type: Array
    public function FSaMCPHGetDataDetailDT($paDataWhere)
    {
        $tCPHDocNo          = $paDataWhere['tCPHDocNo'];
        $aRowLenaRowLen     = FCNaHCallLenData($paDataWhere['nRow'], $paDataWhere['nPage']);
        $tSQL               = " SELECT
                                    CPD.FTBchCode,
                                    CPD.FTCphDocNo,
                                    CPD.FTCpdBarCpn,
                                    CPD.FNCpdSeqNo,
                                    CPD.FNCpdAlwMaxUse,
                                    IMG.FTImgObj
                                FROM TFNTCouponDT CPD WITH(NOLOCK)
                                LEFT JOIN TCNMImgObj IMG WITH(NOLOCK) ON IMG.FTImgRefID = CPD.FTCphDocNo AND IMG.FTImgTable = 'TFNTCouponHD' AND IMG.FTImgKey = 'coupon'
                                WHERE 1 = 1
                                AND (CPD.FTCphDocNo='$tCPHDocNo')
                                ORDER BY FNCpdSeqNo ASC
        ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataList  = $oQuery->result_array();
            $aFoundRow  = $this->FSaMCPHCountDataDetailDT($paDataWhere);
            $nFoundRow  = ($aFoundRow['rtCode'] == '1') ? $aFoundRow['rtCountData'] : 0;
            $nPageAll   = ceil($nFoundRow / $paDataWhere['nRow']);
            $aDataReturn    = array(
                'raItems'       => $aDataList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataWhere['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aDataReturn    = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($tCPHDocNo);
        unset($tCPHSearchDataDT);
        unset($aRowLen);
        unset($tSQL);
        unset($oQuery);
        unset($aDataList);
        unset($aFoundRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aDataReturn;
    }

    // Functionality: Count Data Detail DT
    // Parameters: function parameters
    // Creator:  25/12/2019 Wasin(Yoshi)
    // Return: Data Array
    // Return Type: Array
    private function FSaMCPHCountDataDetailDT($paDataWhere)
    {
        $tCPHDocNo  = $paDataWhere['tCPHDocNo'];
        $tSQL       = " SELECT
                            COUNT(CPH.FTCphDocNo) AS counts
                        FROM TFNTCouponDT CPH WITH(NOLOCK)
                        WHERE 1 = 1
                        AND (CPH.FTCphDocNo  = '$tCPHDocNo')
        ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail        = $oQuery->row_array();
            $aDataReturn    =  array(
                'rtCountData'   => $aDetail['counts'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aDataReturn    =  array(
                'rtCode'    => '800',
                'rtDesc'    => 'Data Not Found',
            );
        }
        unset($tCPHDocNo);
        unset($tCPHSearchDataDT);
        unset($tSQL);
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }

    // Functionality : Delete Coupon Setup Document
    // Parameters : function parameters
    // Creator : 26/12/2019 Wasin(Yoshi)
    // Return : Array Status Delete
    // Return Type : array
    public function FSnMCPHDelDocument($paDataDoc)
    {
        $tDataDocNo = $paDataDoc['tDataDocNo'];
        $this->db->trans_begin();
        // Document HD
        $this->db->where_in('FTCphDocNo', $tDataDocNo);
        $this->db->delete('TFNTCouponHD');
        // Document HD_L
        $this->db->where_in('FTCphDocNo', $tDataDocNo);
        $this->db->delete('TFNTCouponHD_L');
        // Document DT
        $this->db->where_in('FTCphDocNo', $tDataDocNo);
        $this->db->delete('TFNTCouponDT');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aStaDelDoc     = array(
                'rtCode'    => '905',
                'rtDesc'    => 'Cannot Delete Item.',
            );
        } else {
            $this->db->trans_commit();
            $aStaDelDoc     = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Delete Complete.',
            );
        }
        return $aStaDelDoc;
    }

    //Functionality : Insert Coupon HD
    //Parameters : function parameters
    //Creator : 26/12/2019 saharat(Golf)
    //Last Modified : -
    //Return : Array
    //Return Type : Array
    public function FSaMCCPAddUpdateCouponHD($paDataMaster, $paDataWhere)
    {
        // Delete TFNTCouponHD
        $tSQLDelete = " SELECT * FROM TFNTCouponHD WHERE 1=1 AND TFNTCouponHD.FTBchCode = '" . $paDataMaster['FTBchCode'] . "' AND TFNTCouponHD.FTCphDocNo = '" . $paDataMaster['FTCphDocNo'] . "' ";
        $oQuery     = $this->db->query($tSQLDelete);
        $nCount =  $oQuery->num_rows();
        if ($nCount == 0) {
            //Add TFNTCouponHD
            $tSQLInsert = " INSERT INTO TFNTCouponHD (
                            FTBchCode,
                            FTCphDocNo,
                            FTCptCode,
                            FDCphDocDate,
                            FTCphDisType,
                            FCCphDisValue,
                            FTPplCode,
                            FDCphDateStart,
                            FDCphDateStop,
                            FTCphTimeStart,
                            FTCphTimeStop,
                            FTCphStaClosed,
                            FTCphRefAccCode,
                            FCCphMinValue,
                            FTCphStaOnTopPmt,
                            FNCphLimitUsePerBill,
                            FTStaChkMember,
                            FTUsrCode,
                            FTCphStaDoc,
                            FTCphStaApv,
                            FTCphStaPrcDoc,
                            FTCphStaDelMQ,
                            FDLastUpdOn,
                            FTLastUpdBy,
                            FDCreateOn,
                            FTCreateBy
                        )VALUES(
                            '" . $paDataMaster['FTBchCode'] . "',
                            '" . $paDataMaster['FTCphDocNo'] . "',
                            '" . $paDataMaster['FTCptCode'] . "',
                            CONVERT(DATETIME,'" . $paDataMaster['FDCphDocDate'] . "'),
                            '" . $paDataMaster['FTCphDisType'] . "',
                            CONVERT(FLOAT,'" . $paDataMaster['FCCphDisValue'] . "'),
                            '" . $paDataMaster['FTPplCode'] . "',
                            CONVERT(DATETIME,'" . $paDataMaster['FDCphDateStart'] . "'),
                            CONVERT(DATETIME,'" . $paDataMaster['FDCphDateStop'] . "'),
                            '" . $paDataMaster['FTCphTimeStart'] . "',
                            '" . $paDataMaster['FTCphTimeStop'] . "',
                            '" . $paDataMaster['FTCphStaClosed'] . "',
                            '" . $paDataMaster['FTCphRefAccCode'] . "',
                            CONVERT(FLOAT,'" . $paDataMaster['FCCphMinValue'] . "'),
                            '" . $paDataMaster['FTCphStaOnTopPmt'] . "',
                            CONVERT(FLOAT,'" . $paDataMaster['FNCphLimitUsePerBill'] . "'),
                            '" . $paDataMaster['FTStaChkMember'] . "',
                            '" . $paDataMaster['FTUsrCode'] . "',
                            '" . $paDataMaster['FTCphStaDoc'] . "',
                            '" . $paDataMaster['FTCphStaApv'] . "',
                            '" . $paDataMaster['FTCphStaPrcDoc'] . "',
                            '" . $paDataMaster['FTCphStaDelMQ'] . "',
                            GETDATE(),
                            '" . $paDataWhere['FTLastUpdBy'] . "',
                            GETDATE(),
                            '" . $paDataWhere['FTCreateBy'] . "'
                        )
        ";
        } else {
            $tSQLInsert = " UPDATE TFNTCouponHD SET 
                                    FTCphDisType  =  '" . $paDataMaster['FTCphDisType'] . "',
                                    FCCphDisValue = CONVERT(FLOAT,'" . $paDataMaster['FCCphDisValue'] . "'),
                                    FTPplCode = '" . $paDataMaster['FTPplCode'] . "',
                                    FDCphDateStart = CONVERT(DATETIME,'" . $paDataMaster['FDCphDateStart'] . "'),
                                    FDCphDateStop = CONVERT(DATETIME,'" . $paDataMaster['FDCphDateStop'] . "'),
                                    FTCphTimeStart = '" . $paDataMaster['FTCphTimeStart'] . "',
                                    FTCphTimeStop = '" . $paDataMaster['FTCphTimeStop'] . "',
                                    FTCphStaClosed = '" . $paDataMaster['FTCphStaClosed'] . "',
                                    FTStaChkMember = '" . $paDataMaster['FTStaChkMember'] . "',
                                    FCCphMinValue = CONVERT(FLOAT,'" . $paDataMaster['FCCphMinValue'] . "'),
                                    FTCphStaOnTopPmt = '" . $paDataMaster['FTCphStaOnTopPmt'] . "',
                                    FNCphLimitUsePerBill = CONVERT(FLOAT,'" . $paDataMaster['FNCphLimitUsePerBill'] . "'),
                                    FTCphRefAccCode = '" . $paDataMaster['FTCphRefAccCode'] . "',
                                    FDLastUpdOn =  GETDATE(),
                                    FTLastUpdBy = '" . $paDataWhere['FTLastUpdBy'] . "' 
                                WHERE TFNTCouponHD.FTBchCode = '" . $paDataMaster['FTBchCode'] . "' AND TFNTCouponHD.FTCphDocNo = '" . $paDataMaster['FTCphDocNo'] . "'
                ";
        }
        $oQuery = $this->db->query($tSQLInsert);
        return;
    }

    //Functionality : Insert Coupon HD Lang
    //Parameters : function parameters
    //Creator : 26/12/2019 saharat(Golf)
    //Last Modified : -
    //Return : Array
    //Return Type : Array
    public function FSaMCCPAddUpdateCouponHDL($paDataMaster)
    {
        // Delete TFNTCouponHD
        $tSQLDelete = " DELETE FROM TFNTCouponHD_L WHERE 1=1 AND TFNTCouponHD_L.FTBchCode = '" . $paDataMaster['FTBchCode'] . "' AND TFNTCouponHD_L.FTCphDocNo = '" . $paDataMaster['FTCphDocNo'] . "' AND TFNTCouponHD_L.FNLngID = CONVERT(INT,'" . $paDataMaster['FNLngID'] . "') ";
        $oQuery     = $this->db->query($tSQLDelete);

        //Add TFNTCouponHD_L
        $tSQLInsert = " INSERT INTO TFNTCouponHD_L(
                            FTBchCode,
                            FTCphDocNo,
                            FNLngID,
                            FTCpnName,
                            FTCpnMsg1,
                            FTCpnMsg2,
                            FTCpnCond 
                        )VALUES(
                            '" . $paDataMaster['FTBchCode'] . "',
                            '" . $paDataMaster['FTCphDocNo'] . "',
                            CONVERT(INT,'" . $paDataMaster['FNLngID'] . "'),
                            '" . $paDataMaster['FTCpnName'] . "',
                            '" . $paDataMaster['FTCpnMsg1'] . "',
                            '" . $paDataMaster['FTCpnMsg2'] . "',
                            '" . $paDataMaster['FTCpnCond'] . "'
                        )
        ";
        $oQuery = $this->db->query($tSQLInsert);
        return;
    }

    //Functionality : Function Insert TFNTCouponDT
    //Parameters : function parameters
    //Creator : 26/12/2019 Bell
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMCCPAddUpdateCouponDT($aDetailItems, $paDataDT)
    {
        $tSQLDelete = "DELETE FROM TFNTCouponDT WHERE 1=1 AND TFNTCouponDT.FTBchCode = '" . $paDataDT['FTBchCode'] . "' AND  TFNTCouponDT.FTCphDocNo = '" . $paDataDT['FTCphDocNo'] . "' ";
        $oQuery = $this->db->query($tSQLDelete);

        if (isset($aDetailItems) && !empty($aDetailItems)) {
            // Loop Add/Update 
            foreach ($aDetailItems as $nKey => $aValue) {
                $tSQLInsert = "";
                $nSeqNo     = ++$nKey;
                $tSQLInsert = " INSERT INTO TFNTCouponDT ( FTBchCode,FTCphDocNo,FTCpdBarCpn,FNCpdSeqNo,FNCpdAlwMaxUse ) VALUES (
                                    '" . $paDataDT['FTBchCode'] . "',
                                    '" . $paDataDT['FTCphDocNo'] . "',
                                    '" . $aValue['FTCpdBarCpn'] . "',
                                    '" . $nSeqNo . "',
                                    '" . $aValue['FNCpdAlwMaxUse'] . "'
                                )";
                $oQuery = $this->db->query($tSQLInsert);
            }
        }
        return;
    }

    //Functionality : Function Insert TFNTCouponHDCstPri
    //Parameters : function parameters
    //Creator : 14/02/2020 Nale
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMCCPAddUpdateCouponHDCstPri($paDataDT, $paItemList)
    {
        $tSQLDelete = "DELETE FROM TFNTCouponHDCstPri WHERE 1=1 AND TFNTCouponHDCstPri.FTBchCode = '" . $paDataDT['FTBchCode'] . "' AND  TFNTCouponHDCstPri.FTCphDocNo = '" . $paDataDT['FTCphDocNo'] . "' ";
        $oQuery = $this->db->query($tSQLDelete);

        if (isset($paItemList['aCouponIncludeCstPriCode']) && !empty($paItemList['aCouponIncludeCstPriCode'])) {
            // Loop Add/Update 
            foreach ($paItemList['aCouponIncludeCstPriCode'] as $nKey => $aValue) {
                $tSQLInsert = "";
                $tSQLInsert = " INSERT INTO TFNTCouponHDCstPri ( FTBchCode,FTCphDocNo,FTPplCode,FTCphStaType ) VALUES (
                                    '" . $paDataDT['FTBchCode'] . "',
                                    '" . $paDataDT['FTCphDocNo'] . "',
                                    '" . $aValue . "',
                                    '1'
                                )";
                $oQuery = $this->db->query($tSQLInsert);
            }
        }

        if (isset($paItemList['aCouponExcludeCstPriCode']) && !empty($paItemList['aCouponExcludeCstPriCode'])) {
            // Loop Add/Update 
            foreach ($paItemList['aCouponExcludeCstPriCode'] as $nKey => $aValue) {
                $tSQLInsert = "";
                $tSQLInsert = " INSERT INTO TFNTCouponHDCstPri ( FTBchCode,FTCphDocNo,FTPplCode,FTCphStaType ) VALUES (
                                    '" . $paDataDT['FTBchCode'] . "',
                                    '" . $paDataDT['FTCphDocNo'] . "',
                                    '" . $aValue . "',
                                    '2'
                                )";
                $oQuery = $this->db->query($tSQLInsert);
            }
        }


        return;
    }

    //Functionality : Function Insert TFNTCouponHDPdt
    //Parameters : function parameters
    //Creator : 14/02/2020 Nale
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMCCPAddUpdateCouponHDPdt($paDataDT, $paItemList)
    {
        $tSQLDelete = "DELETE FROM TFNTCouponHDPdt WHERE 1=1 AND TFNTCouponHDPdt.FTBchCode = '" . $paDataDT['FTBchCode'] . "' AND  TFNTCouponHDPdt.FTCphDocNo = '" . $paDataDT['FTCphDocNo'] . "' ";
        $oQuery = $this->db->query($tSQLDelete);

        if (isset($paItemList['aCouponIncludePdtCode']) && !empty($paItemList['aCouponIncludePdtCode'])) {
            // Loop Add/Update 
            foreach ($paItemList['aCouponIncludePdtCode'] as $nKey => $aValue) {
                $tPdtCode   = $aValue;
                $tPunCode   = $paItemList['aCouponIncludePdtUnitCode'][$nKey];
                $tSQLInsert = "";
                $tSQLInsert = " INSERT INTO TFNTCouponHDPdt ( FTBchCode,FTCphDocNo,FTPdtCode,FTPunCode,FTCphStaType ) VALUES (
                                    '" . $paDataDT['FTBchCode'] . "',
                                    '" . $paDataDT['FTCphDocNo'] . "',
                                    '" . $tPdtCode . "',
                                    '" . $tPunCode . "',
                                    '1'
                                )";
                $oQuery = $this->db->query($tSQLInsert);
            }
        }

        if (isset($paItemList['aCouponExcludePdtCode']) && !empty($paItemList['aCouponExcludePdtCode'])) {
            // Loop Add/Update 
            foreach ($paItemList['aCouponExcludePdtCode'] as $nKey => $aValue) {
                $tPdtCode   = $aValue;
                $tPunCode   = $paItemList['aCouponExcludePdtUnitCode'][$nKey];
                $tSQLInsert = "";
                $tSQLInsert = " INSERT INTO TFNTCouponHDPdt ( FTBchCode,FTCphDocNo,FTPdtCode,FTPunCode,FTCphStaType ) VALUES (
                                    '" . $paDataDT['FTBchCode'] . "',
                                    '" . $paDataDT['FTCphDocNo'] . "',
                                    '" . $tPdtCode . "',
                                    '" . $tPunCode . "',
                                    '2'
                                )";
                $oQuery = $this->db->query($tSQLInsert);
            }
        }


        return;
    }

    //Functionality : Function Insert TFNTCouponHDBch
    //Parameters : function parameters
    //Creator : 14/02/2020 Nale
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaMCCPAddUpdateCouponHDBch($paDataDT, $paItemList)
    {
        $tSQLDelete = "DELETE FROM TFNTCouponHDBch WHERE 1=1 AND TFNTCouponHDBch.FTBchCode = '" . $paDataDT['FTBchCode'] . "' AND  TFNTCouponHDBch.FTCphDocNo = '" . $paDataDT['FTCphDocNo'] . "' ";
        $oQuery = $this->db->query($tSQLDelete);

        if (isset($paItemList['aCouponIncludeBchCode']) && !empty($paItemList['aCouponIncludeBchCode'])) {
            // Loop Add/Update 
            foreach ($paItemList['aCouponIncludeBchCode'] as $nKey => $aValue) {
                $tBchCode   = $aValue;
                $tMerCode   = $paItemList['aCouponIncludeMerCode'][$nKey];
                $tShpCode   = $paItemList['aCouponIncludeShpCode'][$nKey];
                $tSQLInsert = "";
                $tSQLInsert = " INSERT INTO TFNTCouponHDBch ( FTBchCode,FTCphDocNo,FTCphBchTo,FTCphMerTo,FTCphShpTo,FTCphStaType ) VALUES (
                                    '" . $paDataDT['FTBchCode'] . "',
                                    '" . $paDataDT['FTCphDocNo'] . "',
                                    '" . $tBchCode . "',
                                    '" . $tMerCode . "',
                                    '" . $tShpCode . "',
                                    '1'
                                )";
                $oQuery = $this->db->query($tSQLInsert);
            }
        }

        if (isset($paItemList['aCouponExcludeBchCode']) && !empty($paItemList['aCouponExcludeBchCode'])) {
            // Loop Add/Update 
            foreach ($paItemList['aCouponExcludeBchCode'] as $nKey => $aValue) {
                $tBchCode   = $aValue;
                $tMerCode   = $paItemList['aCouponExcludeMerCode'][$nKey];
                $tShpCode   = $paItemList['aCouponExcludeShpCode'][$nKey];
                $tSQLInsert = "";
                $tSQLInsert = " INSERT INTO TFNTCouponHDBch ( FTBchCode,FTCphDocNo,FTCphBchTo,FTCphMerTo,FTCphShpTo,FTCphStaType ) VALUES (
                                    '" . $paDataDT['FTBchCode'] . "',
                                    '" . $paDataDT['FTCphDocNo'] . "',
                                    '" . $tBchCode . "',
                                    '" . $tMerCode . "',
                                    '" . $tShpCode . "',
                                    '2'
                                )";
                $oQuery = $this->db->query($tSQLInsert);
            }
        }


        return;
    }

    //Functionality : Search Coupon By ID
    //Parameters : function parameters
    //Creator : 26/12/2019 saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCCPGetDataByID($paData)
    {
        $nLngID     = $paData['FNLngID'];
        $tCphDocNo  = $paData['FTCphDocNo'];
        $tSQL       = " SELECT
                            TCH.FTBchCode,
                            TCH.FTCphDocNo,
                            TCH.FTCptCode,
                            CTL.FTCptName,
                            TCH.FDCphDocDate,
                            TCH.FTCphDisType,
                            TCH.FCCphDisValue,
                            TCH.FDCphDateStart,
                            TCH.FDCphDateStop,
                            TCH.FTCphTimeStart,
                            TCH.FTCphTimeStop,
                            TCH.FTCphStaClosed,
                            TCH.FTStaChkMember,
                            
                            TCH.FCCphMinValue,
                            TCH.FTCphStaOnTopPmt,
                            TCH.FNCphLimitUsePerBill,
                            TCH.FTCphRefAccCode,

                            TCH.FTUsrCode       AS FTUserCodeCreate,
                            USRINS.FTUsrName    AS FTUserNameCreate,
                            TCH.FTCphUsrApv     AS FTUserCodeAppove,
                            USRAPV.FTUsrName    AS FTUserNameAppove,
                            
        
                            TCH.FTPplCode,

                            TCH.FTCphStaDoc,
                            TCH.FTCphStaApv,
                            TCH.FTCphStaPrcDoc,
                            TCH.FTCphStaDelMQ,

                            TCHL.FTCpnName,
                            TCHL.FTCpnMsg1,
                            TCHL.FTCpnMsg2,
                            TCHL.FTCpnCond,
                            BCHL.FTBchName,

                            TPL.FTPplName

                        FROM TFNTCouponHD TCH 
                        
                        LEFT JOIN TFNMCouponType_L CTL  ON TCH.FTCptCode = CTL.FTCptCode AND CTL.FNLngID   =  $nLngID
                        LEFT JOIN TFNTCouponHD_L   TCHL ON TCH.FTCphDocNo   = TCHL.FTCphDocNo AND TCHL.FNLngID  =  $nLngID
                        LEFT JOIN TCNMUser_L USRINS ON TCH.FTUsrCode = USRINS.FTUsrCode AND USRINS.FNLngID = $nLngID
                        LEFT JOIN TCNMUser_L USRAPV ON TCH.FTCphUsrApv = USRAPV.FTUsrCode AND USRAPV.FNLngID = $nLngID
                        LEFT JOIN TCNMBranch_L BCHL ON TCH.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID

                        LEFT JOIN TCNMPdtPriList_L TPL   ON TCH.FTPplCode   = TPL.FTPplCode   AND TPL.FNLngID   =  $nLngID
                        WHERE 1=1
        ";

        if ($tCphDocNo != "") {
            $tSQL .= "AND TCH.FTCphDocNo = '$tCphDocNo'";
        }

        $oQuery = $this->db->query($tSQL);

        $aCouponHDBch_Include = $this->db->where('TFNTCouponHDBch.FTCphDocNo', $tCphDocNo)
            ->where('TFNTCouponHDBch.FTCphStaType', 1)
            ->join('TCNMBranch_L', 'TFNTCouponHDBch.FTCphBchTo=TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID=' . $nLngID, 'left')
            ->join('TCNMMerchant_L', 'TFNTCouponHDBch.FTCphMerTo=TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID=' . $nLngID, 'left')
            ->join('TCNMShop_L', 'TFNTCouponHDBch.FTCphShpTo=TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID=' . $nLngID, 'left')
            ->get('TFNTCouponHDBch')
            ->result_array();

        $aCouponHDBch_Exclude = $this->db->where('TFNTCouponHDBch.FTCphDocNo', $tCphDocNo)
            ->where('TFNTCouponHDBch.FTCphStaType', 2)
            ->join('TCNMBranch_L', 'TFNTCouponHDBch.FTCphBchTo=TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID=' . $nLngID, 'left')
            ->join('TCNMMerchant_L', 'TFNTCouponHDBch.FTCphMerTo=TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID=' . $nLngID, 'left')
            ->join('TCNMShop_L', 'TFNTCouponHDBch.FTCphShpTo=TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID=' . $nLngID, 'left')
            ->get('TFNTCouponHDBch')
            ->result_array();

        $aCouponHDCstPri_Include = $this->db->where('FTCphDocNo', $tCphDocNo)
            ->where('FTCphStaType', 1)
            ->join('TCNMPdtPriList_L', 'TFNTCouponHDCstPri.FTPplCode=TCNMPdtPriList_L.FTPplCode AND TCNMPdtPriList_L.FNLngID=' . $nLngID, 'left')
            ->get('TFNTCouponHDCstPri')
            ->result_array();

        $aCouponHDCstPri_Exclude = $this->db->where('FTCphDocNo', $tCphDocNo)
            ->where('FTCphStaType', 2)
            ->join('TCNMPdtPriList_L', 'TFNTCouponHDCstPri.FTPplCode=TCNMPdtPriList_L.FTPplCode AND TCNMPdtPriList_L.FNLngID=' . $nLngID, 'left')
            ->get('TFNTCouponHDCstPri')
            ->result_array();

        $aCouponHDPdt_Include = $this->db->where('FTCphDocNo', $tCphDocNo)
            ->where('FTCphStaType', 1)
            ->join('TCNMPdt_L', 'TFNTCouponHDPdt.FTPdtCode=TCNMPdt_L.FTPdtCode AND TCNMPdt_L.FNLngID=' . $nLngID, 'left')
            ->join('TCNMPdtUnit_L', 'TFNTCouponHDPdt.FTPunCode=TCNMPdtUnit_L.FTPunCode AND TCNMPdtUnit_L.FNLngID=' . $nLngID, 'left')
            ->get('TFNTCouponHDPdt')
            ->result_array();

        $aCouponHDPdt_Exclude = $this->db->where('FTCphDocNo', $tCphDocNo)
            ->where('FTCphStaType', 2)
            ->join('TCNMPdt_L', 'TFNTCouponHDPdt.FTPdtCode=TCNMPdt_L.FTPdtCode AND TCNMPdt_L.FNLngID=' . $nLngID, 'left')
            ->join('TCNMPdtUnit_L', 'TFNTCouponHDPdt.FTPunCode=TCNMPdtUnit_L.FTPunCode AND TCNMPdtUnit_L.FNLngID=' . $nLngID, 'left')
            ->get('TFNTCouponHDPdt')
            ->result_array();



        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();
            $aCouponDetailInOrEx['aCouponHDBch'][1]    = $aCouponHDBch_Include;
            $aCouponDetailInOrEx['aCouponHDBch'][2]    = $aCouponHDBch_Exclude;
            $aCouponDetailInOrEx['aCouponHDCsrPri'][1] = $aCouponHDCstPri_Include;
            $aCouponDetailInOrEx['aCouponHDCsrPri'][2] = $aCouponHDCstPri_Exclude;
            $aCouponDetailInOrEx['aCouponHDPdt'][1]    = $aCouponHDPdt_Include;
            $aCouponDetailInOrEx['aCouponHDPdt'][2]    = $aCouponHDPdt_Exclude;
            $aResult = array(
                'raItems'   => $oDetail[0],
                'raCouponDetailInOrEx' => $aCouponDetailInOrEx,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Functionality : Event Cancel Document
    //Parameters : function parameters
    //Creator : 27/12/2019 Supawat(Wat)
    //Return : data
    //Return Type : Array
    public function FSaMCPHCancelStatus($paDataWhere)
    {
        try {
            $tFTBchCode     = $paDataWhere['FTBchCode'];
            $tFTCphDocNo    = $paDataWhere['FTCphDocNo'];
            $this->db->set('FTCphStaDoc', '3');
            $this->db->where('FTBchCode', $tFTBchCode);
            $this->db->where('FTCphDocNo', $tFTCphDocNo);
            $this->db->update('TFNTCouponHD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Update',
                );
            }
            return $aStatus;
        } catch (Exception  $Error) {
            return $Error;
        }
    }

    //Functionality : Event Cancel Document
    //Parameters : function parameters
    //Creator : 27/12/2019 Supawat(Wat)
    //Return : data
    //Return Type : Array
    public function FSaMCPHAppoveStatus($paDataWhere)
    {
        $tFTBchCode     = $paDataWhere['FTBchCode'];
        $tFTCphDocNo    = $paDataWhere['FTCphDocNo'];
        $tFTCphUsrApv   = $paDataWhere['FTCphUsrApv'];

        $this->db->set('FTCphStaDoc', '1');
        $this->db->set('FTCphStaApv', '1');
        $this->db->set('FTCphStaPrcDoc', '1');
        $this->db->set('FTCphStaDelMQ', '1');
        $this->db->set('FTCphUsrApv', $tFTCphUsrApv);
        $this->db->where('FTBchCode', $tFTBchCode);
        $this->db->where('FTCphDocNo', $tFTCphDocNo);
        $this->db->update('TFNTCouponHD');
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Success',
            );
        } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Update',
            );
        }
        return $aStatus;
    }
}
