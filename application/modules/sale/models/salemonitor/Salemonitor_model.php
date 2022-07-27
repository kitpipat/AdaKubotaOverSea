<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Salemonitor_model extends CI_Model {

    //Functionality : list Branch
    //Parameters : function parameters
    //Creator : 09/03/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMSMTBCHList($paData) {

        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID = $paData['FNLngID'];

        $tSQL   =   "   SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY rtBchCode ASC) AS rtRowID,* FROM (
                                SELECT DISTINCT
                                    BCH.FTBchCode AS rtBchCode,
                                    FTBchName AS rtBchName,
                                    FTBchType AS rtBchType,
                                    BCH.FTBchPriority AS rtBchPriority
    					FROM TCNMBranch   BCH  WITH(NOLOCK)
						LEFT JOIN TCNMBranch_L  BCHL  WITH(NOLOCK) ON BCH.FTBchCode = BCHL.FTBchCode  AND BCHL.FNLngID = $nLngID
						WHERE 1 = 1
        ";
        $tBchCode       = $paData['FTBchCode'];
        $tFilterBchCode    = $paData['tFilterBchCode'];
        
		// User BCH Level
		if ($this->session->userdata('tSesUsrLevel') == "BCH") { // ผู้ใช้ระดับ BCH ดูได้แค่สาขาที่มีสิทธิ์
			$tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
			$tSQL .= " AND BCH.FTBchCode IN($tBchCodeMulti)";
        }

        if(!empty($tFilterBchCode)){
            $tFilterBchCodeWhere = str_replace(",","','",$tFilterBchCode);
            $tSQL .= " AND BCH.FTBchCode IN ('$tFilterBchCodeWhere') ";
        }

        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        
        if ($oQuery->num_rows() > 0) {

            $aList = $oQuery->result();
            $aFoundRow = $this->JSnMSMTBCHGetPageAll($tFilterBchCode, $tBchCode, $nLngID);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า 

            $aResult = array(
                'raItems' => $aList,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage" => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        } else {
            //No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        }
        return $aResult;
    }

    //Functionality : All Page Of Branch
    //Parameters : function parameters
    //Creator : 09/03/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    function JSnMSMTBCHGetPageAll($ptFilterBchCode, $ptBchCode, $ptLngID) {

        $tSQL = "SELECT COUNT (BCH.FTBchCode) AS counts
                        FROM TCNMBranch BCH
                        LEFT JOIN TCNMBranch_L BCHL ON BCH.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $ptLngID
                        WHERE 1 = 1";

		// User BCH Level
		if ($this->session->userdata('tSesUsrLevel') == "BCH") { // ผู้ใช้ระดับ BCH ดูได้แค่สาขาที่มีสิทธิ์
			$tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
			$tSQL .= " AND BCH.FTBchCode IN($tBchCodeMulti)";
        }

        if(!empty($ptFilterBchCode)){
            $tFilterBchCodeWhere = str_replace(",","','",$ptFilterBchCode);
            $tSQL .= " AND BCH.FTBchCode IN ('$tFilterBchCodeWhere') ";
        }

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {

            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }



    // Functionality : ฟังก์ชั่น Call View Modal Filter
    // Parameters : Ajax and Function Parameter
    // Creator : 15/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSaMSMTCallSalHD($paDatWhere){


         $tDateData = $paDatWhere['tDateDataTo'];
         $tFilterBchCode = $paDatWhere['tFilterBchCode'];
         $tFilterShpCode = $paDatWhere['tFilterShpCode'];
         $tFilterPosCode = $paDatWhere['tFilterPosCode'];
         $tSqlWhere = "  SAL.FDXshDocDate BETWEEN '$tDateData 00:00:00' AND '$tDateData 23:59:59' ";

        	// User BCH Level
            if ($this->session->userdata('tSesUsrLevel') == "BCH") { // ผู้ใช้ระดับ BCH ดูได้แค่สาขาที่มีสิทธิ์
                $tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
                $tSQL .= " AND BCH.FTBchCode IN($tBchCodeMulti)";
            }

            if(!empty($tFilterBchCode)){
                $tFilterBchCodeWhere = str_replace(",","','",$tFilterBchCode);
                $tSqlWhere .= " AND SAL.FTBchCode IN ('$tFilterBchCodeWhere') ";
            }

            if(!empty($tFilterShpCode)){
                $tFilterShpCodeWhere = str_replace(",","','",$tFilterShpCode);
                $tSqlWhere .= " AND SAL.FTShpCode IN ('$tFilterShpCodeWhere') ";
            }

            if(!empty($tFilterPosCode)){
                $tFilterPosCodeWhere = str_replace(",","','",$tFilterPosCode);
                $tSqlWhere .= " AND SAL.FTPosCode IN ('$tFilterPosCodeWhere') ";
            }

            $nLangEdit      = $this->session->userdata("tLangEdit");

            $tSql = "SELECT
                            BCHL.FTBchName,
                            SAL.FTWahCode,
                            SAL.FTPosCode,
                            SAL.FTShfCode,
                            SAL.FTXshDocNo,
                            SAL.FTBchCode,
                            SAL.FDXshDocDate,
                            SAL.FTShpCode,
                            SAL.FCXshGrand,
                            SHPL.FTShpName,
                            POSL.FTPosName,
                            SAL.FNXshDocType
                        FROM
                        TPSTSalHD AS SAL
                            LEFT JOIN TCNMBranch_L AS BCHL ON SAL.FTBchCode = BCHL.FTBchCode  AND BCHL.FNLngID = $nLangEdit
                            LEFT JOIN TCNMShop_L   AS SHPL ON SAL.FTShpCode = SHPL.FTShpCode AND SHPL.FTBchCode = SAL.FTBchCode AND SHPL.FNLngID = $nLangEdit
                            LEFT JOIN TCNMPos_L   AS POSL ON SAL.FTPosCode = POSL.FTPosCode AND POSL.FTBchCode = SAL.FTBchCode AND POSL.FNLngID = $nLangEdit
                        WHERE
                        $tSqlWhere
                        ORDER BY
                            SAL.FTBchCode ASC,
                            SAL.FTShpCode ASC,
                            SAL.FTPosCode ASC
            ";

            // echo $tSql ;
            $oQuery = $this->db->query($tSql);
            return $oQuery->result_array();

    }

    // Functionality : ฟังก์ชั่น Call View Modal Filter
    // Parameters : Ajax and Function Parameter
    // Creator : 15/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSdMSMTGetLastGrandSiftDate($ptBchCode,$ptShpCode,$ptPosCode,$paDataWhere){

        $tDateData = $paDataWhere['tDateDataTo'];

            $tSql ="SELECT TOP 1
                    SAL.FDLastUpdOn AS lastData,
                    SAL.FTXshDocNo AS LastDoc
                    FROM
                        TPSTSalHD SAL
                    WHERE SAL.FTBchCode='$ptBchCode'
                    AND SAL.FTShpCode='$ptShpCode'
                    AND SAL.FTPosCode='$ptPosCode'
                    AND SAL.FDXshDocDate BETWEEN '$tDateData 00:00:00' AND '$tDateData 23:59:59'
                    ORDER BY SAL.FDLastUpdOn DESC
                    ";

            $oQuery = $this->db->query($tSql);
            return $oQuery->row_array();


    }

    // Functionality : ฟังก์ชั่น Call View Modal Filter
    // Parameters : Ajax and Function Parameter
    // Creator : 15/04/2020 Nale
    // Return : String View
    // Return Type : View
    public function FSaMSMTCallSiftHD($paDataWhere){

        $tDateData = $paDataWhere['tDateDataTo'];
        $tFilterBchCode = $paDataWhere['tFilterBchCode'];
        $tFilterPosCode = $paDataWhere['tFilterPosCode'];
        $tSqlWhere = " SHD.FDShdSaleDate BETWEEN '$tDateData 00:00:00' AND '$tDateData 23:59:59' ";

        // User BCH Level
        if ($this->session->userdata('tSesUsrLevel') == "BCH") { // ผู้ใช้ระดับ BCH ดูได้แค่สาขาที่มีสิทธิ์
            $tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND BCH.FTBchCode IN($tBchCodeMulti)";
        }


        if(!empty($tFilterBchCode)){
            $tFilterBchCodeWhere = str_replace(",","','",$tFilterBchCode);
            $tSqlWhere .= " AND SHD.FTBchCode IN ('$tFilterBchCodeWhere') ";
        }

        if(!empty($tFilterPosCode)){
            $tFilterPosCodeWhere = str_replace(",","','",$tFilterPosCode);
            $tSqlWhere .= " AND SHD.FTPosCode IN ('$tFilterPosCodeWhere') ";
        }


            $tSql ="SELECT
                        SHD.FTBchCode,
                        SHD.FTPosCode,
                        SHD.FTShfCode,
                        SHD.FDShdSignIn,
                        SHD.FDShdSignOut,
                        SLD.FTLstDocNoFrm,
                        SLD.FTLstDocNoTo,
                        SLD.FNLstDocType
                        FROM
                        TPSTShiftHD AS SHD
                        LEFT JOIN TPSTShiftSLastDoc SLD ON SHD.FTBchCode = SLD.FTBchCode AND SHD.FTPosCode = SLD.FTPosCode AND SHD.FTShfCode = SLD.FTShfCode 
                        WHERE
                        $tSqlWhere
            ";

            // echo $tSql;
            $oQuery = $this->db->query($tSql);
            return $oQuery->result_array();
    }


    public function FSaMSMTCallSumRcvShift($paData,$pType){
       $tBchCode    = $paData['tBchCode'];
       $tPosCode    = $paData['tPosCode'];
       $tShfCode  = $paData['tShfCode'];
       $tSqlWhere ='';
    if(!empty($pType)){
        $tSqlWhere .= " AND SRV.FTRcvDocType ='$pType' ";
    }
        $tSql = "SELECT
                        SUM (
                            CASE
                            WHEN SRV.FTRcvDocType = 1 THEN
                                ISNULL(SRV.FCRcvPayAmt, 0)
                            ELSE
                                ISNULL(SRV.FCRcvPayAmt, 0) *- 1
                            END
                        ) AS FCRcvPayAmt
                    FROM
                        TPSTShiftSSumRcv SRV
                    WHERE
                        SRV.FTBchCode = '$tBchCode'
                    AND SRV.FTPosCode = '$tPosCode'
                    AND SRV.FTShfCode = '$tShfCode'
                    $tSqlWhere
                    GROUP BY
                        SRV.FTShfCode
                ";
        $oQuery = $this->db->query($tSql);
        return $oQuery->row_array()['FCRcvPayAmt'];
    }


    public function FSaMSMTCallObjectData($paData){

        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID = $paData['FNLngID'];

        $tSQL   =   "   SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY FNUrlType ASC) AS rtRowID,* FROM (
                                SELECT
                                    OBJ.FNUrlID,
                                    OBJ.FTUrlRefID AS rtBchCode,
                                    BCHL.FTBchName AS rtBchName,
                                    OBJ.FNUrlType,
                                    OBJ.FTUrlAddress,
                                    OBJ.FTUrlPort
                                FROM
                                    TCNTUrlObject OBJ
                                LEFT JOIN TCNMBranch_L BCHL on OBJ.FTUrlRefID = BCHL.FTBchCode AND BCHL.FNLngID=$nLngID
					     	WHERE OBJ.FNUrlType NOT IN (1,2)
        ";

        $tBchCode       = $paData['FTBchCode'];
        $tFilterBchCode    = $paData['tFilterBchCode'];
        

        // User BCH Level
        if ($this->session->userdata('tSesUsrLevel') == "BCH") { // ผู้ใช้ระดับ BCH ดูได้แค่สาขาที่มีสิทธิ์
            $tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND BCH.FTBchCode IN($tBchCodeMulti)";
        }


        if(!empty($tFilterBchCode)){
            $tFilterBchCodeWhere = str_replace(",","','",$tFilterBchCode);
            $tSQL .= " AND OBJ.FTUrlRefID IN ('$tFilterBchCodeWhere') ";
        }

        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {

            $aList = $oQuery->result();
            $aFoundRow = $this->JSnMSMTUrlObjectGetPageAll($tFilterBchCode, $tBchCode, $nLngID);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า 

            $aResult = array(
                'raItems' => $aList,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage" => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        } else {
            //No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        }
        return $aResult;



    }


        //Functionality : All Page Of Branch
    //Parameters : function parameters
    //Creator : 09/03/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    function JSnMSMTUrlObjectGetPageAll($ptFilterBchCode, $ptBchCode, $ptLngID) {

        $tSQL = "SELECT COUNT (OBJ.FNUrlID) AS counts
		    					FROM TCNTUrlObject OBJ
								WHERE OBJ.FNUrlType NOT IN (1,2) ";

        // if ($this->session->userdata('tSesUsrBchCode')!= '') {
        //     $tBchCode = $this->session->userdata('tSesUsrBchCode');
        //     $tSQL .= " AND OBJ.FTUrlRefID = '$tBchCode' ";
        // }

        // User BCH Level
        if ($this->session->userdata('tSesUsrLevel') == "BCH") { // ผู้ใช้ระดับ BCH ดูได้แค่สาขาที่มีสิทธิ์
            $tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL .= " AND BCH.FTBchCode IN($tBchCodeMulti)";
        }

        if(!empty($ptFilterBchCode)){
            $tFilterBchCodeWhere = str_replace(",","','",$ptFilterBchCode);
            $tSQL .= " AND OBJ.FTUrlRefID IN ('$tFilterBchCodeWhere') ";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {

            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }



    public function FSaMSMTSALTotalSaleByBranch($paData){


        $dDateFrom = $this->input->post('oetSMTSALDateDataForm');
        $dDateTo = $this->input->post('oetSMTSALDateDataTo');
        $oetDSHSALSort = $this->input->post('oetDSHSALSort');
        $oetDSHSALFild = $this->input->post('oetDSHSALFild');

        // Branch Filter
        $tDSHSALFilterBchStaAll  = (!empty($this->input->post('oetSMTSALFilterBchStaAll')) && ($this->input->post('oetSMTSALFilterBchStaAll') == 1)) ? true : false;
        $nDSHSALFilterBchCode    = (!empty($this->input->post('oetSMTSALFilterBchCode'))) ? $this->input->post('oetSMTSALFilterBchCode') : "";
        $tDSHSALFilterBchName   = (!empty($this->input->post('oetSMTSALFilterBchName'))) ? $this->input->post('oetSMTSALFilterBchName') : "";
        // Pos Filter
        $tDSHSALFilterPosStaAll  = (!empty($this->input->post('oetSMTSALFilterPosStaAll')) && ($this->input->post('oetSMTSALFilterPosStaAll') == 1)) ? true : false;
        $nDSHSALFilterPosCode  = (!empty($this->input->post('oetSMTSALFilterPosCode'))) ? $this->input->post('oetSMTSALFilterPosCode') : "";
        $tDSHSALFilterPosName    = (!empty($this->input->post('oetSMTSALFilterPosName'))) ? $this->input->post('oetSMTSALFilterPosName') : "";
        // Diff Filter
        // $tDSHSALFilterDiff = $this->input->post('orbDSHSALDiff');
        $tDSHSALFilterDiff = (!empty($this->input->post('orbDSHSALDiff'))) ? $this->input->post('orbDSHSALDiff') : "";

        // Check Data Where In Branch
        $tTextWhereBranch   = '';
        if (isset($tDSHSALFilterBchStaAll) &&  $tDSHSALFilterBchStaAll == false) {
            if (isset($nDSHSALFilterBchCode) && !empty($nDSHSALFilterBchCode)) {
                $tTextWhereBranch   = 'AND SHD.FTBchCode IN (' . FCNtAddSingleQuote($nDSHSALFilterBchCode) . ')';
            }
        }

        // Check Data Where In POS
        $tTextWherePos      = '';
        if (isset($tDSHSALFilterPosStaAll) && $tDSHSALFilterPosStaAll == false) {
            if (isset($nDSHSALFilterPosCode) && !empty($nDSHSALFilterPosCode)) {
                $tTextWherePos  = 'AND SHD.FTPosCode IN (' . FCNtAddSingleQuote($nDSHSALFilterPosCode) . ')';
            }
        }

        // Check Data Where Diff
        $tTextWhereDiff      = '';
        if ($tDSHSALFilterDiff == '1') {
            $tTextWhereDiff  = 'AND  CalDiff.BillDiff <> 0';
        }


        $aRowLen        = FCNaHCallLenData($paData['nRow'], $paData['nPage']);


        $tUsrBchCodeMulti = $this->session->userdata("tSesUsrBchCodeMulti");
        $tUsrLevel = $this->session->userdata("tSesUsrLevel");
        $tTextWhereBranchRole = '';
        if ($tUsrLevel != 'HQ') {
            $tTextWhereBranchRole =  "AND  SHD.FTBchCode IN ($tUsrBchCodeMulti)";
        }


        $tSQL = " SELECT c.*
            FROM
            (
                SELECT ROW_NUMBER() OVER(
                    ORDER BY $oetDSHSALFild $oetDSHSALSort) AS rtRowID, 
                    DataMain.*
                FROM
                (
                    SELECT CalDiff.* FROM (
                    SELECT
                            SHD.FTBchCode,
                            BCHL.FTBchName,
                            SHD.FTPosCode,
                            CONVERT (DATE, SHD.FDShdSaleDate, 103) AS FDShdSaleDate,
                            SHD.FTShfCode,
                            CONVERT (
                                VARCHAR,
                                SHD.FDShdSignIn,
                                120
                            ) AS FDShdSignIn,
                            CONVERT (
                                VARCHAR,
                                SHD.FDShdSignOut,
                                120
                            ) AS FDShdSignOut,
                            SHD.FTShdUsrClosed,
                            SALHD.BillQty,
                            CASE WHEN  ISNULL(SHD.FNShdQtyBill, 0) <> 0 THEN
                            ISNULL(SHD.FNShdQtyBill, 0)
                            ELSE
                            ISNULL(SHLD.BillChk, 0)
                            END FNShdQtyBill,
                            CASE
                        WHEN ISNULL(SHD.FNShdQtyBill, 0) <> 0 THEN
                            (
                                ISNULL(SHD.FNShdQtyBill, 0) - ISNULL(SALHD.BillQty, 0)
                            )
                        ELSE
                            (
                                ISNULL(SHLD.BillChk, 0) - ISNULL(SALHD.BillQty, 0)
                            )
                        END BillDiff
                        FROM
                            TPSTShiftHD SHD
                        LEFT OUTER JOIN TCNMBranch_L BCHL ON SHD.FTBchCode = BCHL.FTBchCode
                        LEFT OUTER JOIN (
                            SELECT
                                HD.FTShfCode,
                                HD.FTBchCode,
                                HD.FTPosCode,
                                COUNT (HD.FTXshDocNo) AS BillQty
                            FROM
                                TPSTSalHD HD
                            GROUP BY
                                HD.FTBchCode,
                                HD.FTPosCode,
                                HD.FTShfCode
                        ) SALHD ON SHD.FTBchCode = SALHD.FTBchCode
                        AND SHD.FTPosCode = SALHD.FTPosCode
                        AND SHD.FTShfCode = SALHD.FTShfCode
                        LEFT JOIN (
                            SELECT
                                FTBchCode,
                                FTPosCode,
                                FTShfCode,
                                SUM (
                                    ISNULL(
                                        (
                                            CONVERT (
                                                BIGINT,
                                                RIGHT (SLD.FTLstDocNoTo, 7)
                                            ) - CONVERT (
                                                BIGINT,
                                                RIGHT (SLD.FTLstDocNoFrm, 7)
                                            )
                                        ) + 1,
                                        0
                                    )
                                ) AS BillChk
                            FROM
                                TPSTShiftSLastDoc SLD
                            GROUP BY
                                FTBchCode,
                                FTPosCode,
                                FTShfCode
                        ) SHLD ON SHD.FTBchCode = SHLD.FTBchCode
                        AND SHD.FTPosCode = SHLD.FTPosCode
                        AND SHD.FTShfCode = SHLD.FTShfCode
				WHERE
					CONVERT (DATE, SHD.FDShdSignIn, 103) BETWEEN '$dDateFrom'
				AND '$dDateTo'
                    $tTextWhereBranchRole  
                    $tTextWhereBranch
                    $tTextWherePos
                    ) CalDiff WHERE 1=1
                    $tTextWhereDiff
 ";



        $tSQL .= ") DataMain) AS c  WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";

                // echo   $tSQL;
                // die();
        $oQuery = $this->db->query($tSQL);


        if ($oQuery->num_rows() > 0) {
            $aList = $oQuery->result_array();
            $nFoundRow = $this->FSoMSMTGetPageAll($dDateFrom, $dDateTo, $tTextWhereBranch, $tTextWherePos, $tTextWhereDiff, $oetDSHSALSort, $oetDSHSALFild, $tTextWhereBranchRole);
            $nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aDataReturn = array(
                'raItems'       => $aList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aDataReturn = array(
                'raItems'       => array(),
                'rnAllRow' => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }

        return $aDataReturn;


    }


    
    // Functionality: Get Numrows Total By Branch
    // Parameters: function parameters
    // Creator:  06/10/2020 Worakorn
    // Return: Data Int
    // Return Type: Int
    public function FSoMSMTGetPageAll($pdDateFrom, $pdDateTo, $ptTextWhereBranch, $ptTextWherePos, $tTextWhereDiff, $oetDSHSALSort, $oetDSHSALFild , $ptTextWhereBranchRole)
    {


                $tSQL = " SELECT c.*
        FROM
        (
            SELECT ROW_NUMBER() OVER(
                ORDER BY $oetDSHSALFild $oetDSHSALSort) AS rtRowID, 
                DataMain.*
            FROM
            (
                SELECT CalDiff.* FROM (
                    SELECT
                            SHD.FTBchCode,
                            BCHL.FTBchName,
                            SHD.FTPosCode,
                            CONVERT (DATE, SHD.FDShdSaleDate, 103) AS FDShdSaleDate,
                            SHD.FTShfCode,
                            CONVERT (
                                VARCHAR,
                                SHD.FDShdSignIn,
                                120
                            ) AS FDShdSignIn,
                            CONVERT (
                                VARCHAR,
                                SHD.FDShdSignOut,
                                120
                            ) AS FDShdSignOut,
                            SHD.FTShdUsrClosed,
                            SALHD.BillQty,
                            CASE WHEN  ISNULL(SHD.FNShdQtyBill, 0) <> 0 THEN
                            ISNULL(SHD.FNShdQtyBill, 0)
                            ELSE
                            ISNULL(SHLD.BillChk, 0)
                            END FNShdQtyBill,
                            CASE
                        WHEN ISNULL(SHD.FNShdQtyBill, 0) <> 0 THEN
                            (
                                ISNULL(SHD.FNShdQtyBill, 0) - ISNULL(SALHD.BillQty, 0)
                            )
                        ELSE
                            (
                                ISNULL(SHLD.BillChk, 0) - ISNULL(SALHD.BillQty, 0)
                            )
                        END BillDiff
                        FROM
                            TPSTShiftHD SHD
                        LEFT OUTER JOIN TCNMBranch_L BCHL ON SHD.FTBchCode = BCHL.FTBchCode
                        LEFT OUTER JOIN (
                            SELECT
                                HD.FTShfCode,
                                HD.FTBchCode,
                                HD.FTPosCode,
                                COUNT (HD.FTXshDocNo) AS BillQty
                            FROM
                                TPSTSalHD HD
                            GROUP BY
                                HD.FTBchCode,
                                HD.FTPosCode,
                                HD.FTShfCode
                        ) SALHD ON SHD.FTBchCode = SALHD.FTBchCode
                        AND SHD.FTPosCode = SALHD.FTPosCode
                        AND SHD.FTShfCode = SALHD.FTShfCode
                        LEFT JOIN (
                            SELECT
                                FTBchCode,
                                FTPosCode,
                                FTShfCode,
                                SUM (
                                    ISNULL(
                                        (
                                            CONVERT (
                                                BIGINT,
                                                RIGHT (SLD.FTLstDocNoTo, 7)
                                            ) - CONVERT (
                                                BIGINT,
                                                RIGHT (SLD.FTLstDocNoFrm, 7)
                                            )
                                        ) + 1,
                                        0
                                    )
                                ) AS BillChk
                            FROM
                                TPSTShiftSLastDoc SLD
                            GROUP BY
                                FTBchCode,
                                FTPosCode,
                                FTShfCode
                        ) SHLD ON SHD.FTBchCode = SHLD.FTBchCode
                        AND SHD.FTPosCode = SHLD.FTPosCode
                        AND SHD.FTShfCode = SHLD.FTShfCode
				WHERE
					CONVERT (DATE, SHD.FDShdSignIn, 103) BETWEEN '$pdDateFrom'
				AND '$pdDateTo'
                    $ptTextWhereBranchRole  
                    $ptTextWhereBranch
                    $ptTextWherePos
                    ) CalDiff WHERE 1=1
                    $tTextWhereDiff
 ";

        $tSQL .= ") DataMain) AS c ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->num_rows();
        } else {
            return false;
        }
    }



}