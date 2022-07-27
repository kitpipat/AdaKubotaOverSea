<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Repairrunningbill_model extends CI_Model {

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



    public function FSaMRPNDataTable($paData){


        $dDateFrom = $this->input->post('oetRpRnDateDataForm');
        $dDateTo = $this->input->post('oetRpRnDateDataTo');
        $nLngID = $this->session->userdata('tLangEdit');
        // Branch Filter
        $tDSHSALFilterBchCode    = (!empty($this->input->post('oetRpRnBchCode'))) ? $this->input->post('oetRpRnBchCode') : "";
    
        // Pos Filter
      
        $tDSHSALFilterPosCode  = (!empty($this->input->post('oetRpRnPosCode'))) ? $this->input->post('oetRpRnPosCode') : "";
        $tRpRnBillStaRun    = (!empty($this->input->post('ocmRpRnBillStaRun'))) ? $this->input->post('ocmRpRnBillStaRun') : "";
        // Diff Filter
        // $tBillType = $this->input->post('orbDSHSALDiff');
        $tBillType = (!empty($this->input->post('ocmRpRnBillType'))) ? $this->input->post('ocmRpRnBillType') : "";

        $tRpRnDocNo   = (!empty($this->input->post('oetRpRnDocNo'))) ? $this->input->post('oetRpRnDocNo') : "";

        $nRpRnNumberFirst   = (!empty($this->input->post('oetRpRnNumberFirst'))) ? $this->input->post('oetRpRnNumberFirst') : 0;
        
        // Check Data Where In Branch
        $tTextWhereBranch   = '';

                // User BCH Level
		if ($this->session->userdata('tSesUsrLevel') == "BCH") { // ผู้ใช้ระดับ BCH ดูได้แค่สาขาที่มีสิทธิ์
			$tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
			$tTextWhereBranch .= " AND SAL.FTBchCode IN($tBchCodeMulti)";
        }

        if (isset($tDSHSALFilterBchCode) && !empty($tDSHSALFilterBchCode)) {
            $tTextWhereBranch   = "AND SAL.FTBchCode ='$tDSHSALFilterBchCode' ";
        }
        

        if (isset($tDSHSALFilterPosCode) && !empty($tDSHSALFilterPosCode)) {
            $tTextWherePos  = "AND SAL.FTPosCode ='$tDSHSALFilterPosCode' ";
        }else{
            $tTextWherePos  = ''; 
        }
        

 
        if ($tBillType != '') {
            $tTextWhereType  = " AND SAL.FNXshDocType = $tBillType";
        }else{
            $tTextWhereType      = '';
        }

        $tTextWhereStaRun = '';
        if($tRpRnBillStaRun!=''){
            if($tRpRnBillStaRun=='1'){
                $tTextWhereStaRun = "WHERE ISNULL(HD.tDocDup,'') = '' ";
            }else{
                $tTextWhereStaRun = "WHERE ISNULL(HD.tDocDup,'') = '1' ";
            }
        }
  
        $tTextWhereDate = "AND CONVERT (DATE, SAL.FDXshDocDate, 103) BETWEEN '$dDateFrom' AND '$dDateTo'";
      
        if($nRpRnNumberFirst>0){
            $nRpRnNumberFirst=$nRpRnNumberFirst-1;
        }else{
            $nRpRnNumberFirst = 0;
        }
        if(!empty($tRpRnDocNo)){
            $tTextWhereDate .= "AND SAL.FTXshDocNo >='$tRpRnDocNo' ";
        }

        $this->FSaMRPNInsertToGTRegen($dDateFrom, $dDateTo, $tTextWhereBranch, $tTextWherePos, $tTextWhereType, $tTextWhereDate,$tTextWhereStaRun,$nRpRnNumberFirst );

        $tSesSessionID = $this->session->userdata('tSesSessionID');

        $aRowLen        = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        
        $tSQLQuery="    SELECT 
                        ROW_NUMBER() OVER( ORDER BY GD.FNXshDocType,GD.FTBchCode,GD.FTPosCode,GD.FDXshDocDate) AS rtRowID, 
                        GD.*,HD.* FROM (
                        SELECT 
                        SAL.FNXshDocType,
                        '' AS FTLogUUID,
                        '' AS FTAgnCode,
                        SAL.FTBchCode,
                        BCHL.FTBchName,
                        SAL.FTPosCode,
                        SAL.FTXshDocNo,
                        SAL.FDXshDocDate,
                        CONCAT(
                        CONVERT(VARCHAR(13),SAL.FTXshDocNo),
                        RIGHT('0000000' + CONVERT(VARCHAR,($nRpRnNumberFirst + ROW_NUMBER() OVER ( PARTITION BY SAL.FNXshDocType,SAL.FTBchCode,SAL.FTPosCode ORDER BY SAL.FNXshDocType,SAL.FTBchCode,SAL.FTPosCode,SAL.FDXshDocDate))),7)
                        ) AS FTXshDocNoNew,
                        GETDATE() AS FDLastUpdOn,
                        '' AS FTLastUpdBy,
                        GETDATE() AS FDCreateOn,
                        '' AS FTCreateBy,
                        CASE WHEN ISNULL(SHIF.FDShdSignOut,'') != '' THEN
						    1
						ELSE
						    2
					    END AS tStaShfClose
                        FROM
                        TPSTSalHD AS SAL WITH(NOLOCK)
                        LEFT JOIN TCNMBranch_L AS BCHL WITH(NOLOCK) ON SAL.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                        LEFT JOIN TPSTShiftHD AS SHIF WITH (NOLOCK) ON SAL.FTBchCode = SHIF.FTBchCode AND SAL.FTPosCode = SHIF.FTPosCode AND SAL.FTShfCode = SHIF.FTShfCode
                        WHERE  SAL.FTXshDocNo IS NOT NULL
                        $tTextWhereDate
                        $tTextWhereBranch
                        $tTextWherePos
                        $tTextWhereType
                        ) GD
                        LEFT JOIN (
                            SELECT HD.FDXshDocDate AS FDXshDocDateDup,HD.FTXshDocNo AS FTXshDocNoDup,HD.FTBchCode AS FTBchCodeDup,'1' AS tDocDup FROM TPSTSalHD HD WITH (NOLOCK)
                            WHERE HD.FTXshDocNo NOT IN (SELECT FTLogOldDocNo FROM TLGTDocRegen LG  WITH (NOLOCK) WHERE FTLogUUID = '$tSesSessionID' )
                        ) HD ON GD.FTBchCode = HD.FTBchCodeDup AND GD.FTXshDocNoNew = HD.FTXshDocNoDup
                         
                        $tTextWhereStaRun
                        ";


    $tSQL = "SELECT c.*
             FROM
             ( $tSQLQuery) 
             AS c  WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";

                // echo   $tSQL;
                // die();
        $oQuery = $this->db->query($tSQL);
        //$this->session->set_userdata('tAdaToolSQLQuery',$tSQLQuery);

        if ($oQuery->num_rows() > 0) {
            $aList = $oQuery->result_array();
            $nFoundRow = $this->FSoMSMTGetPageAll($dDateFrom, $dDateTo, $tTextWhereBranch, $tTextWherePos, $tTextWhereType, $tTextWhereDate ,$tTextWhereStaRun,$nRpRnNumberFirst );
            $nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aDataFindDup = $this->FSoMSMTFindDup($dDateFrom, $dDateTo, $tTextWhereBranch, $tTextWherePos, $tTextWhereType, $tTextWhereDate ,$tTextWhereStaRun,$nRpRnNumberFirst );
            $aDataFindNotCloseShf = $this->FSoMSMTFindNotCloseShf($dDateFrom, $dDateTo, $tTextWhereBranch, $tTextWherePos, $tTextWhereType, $tTextWhereDate ,$tTextWhereStaRun,$nRpRnNumberFirst );

            $aDataReturn = array(
                'raItems'       => $aList,
                'rnAllRow'      => $nFoundRow,
                'raDataFindDup' => $aDataFindDup,
                'raDataFindNotCloseShf' => $aDataFindNotCloseShf,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aDataReturn = array(
                'raItems'       => array(),
                'rnAllRow' => 0,
                'raDataFindDup' => array(),
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
    public function FSoMSMTFindDup($pdDateFrom, $pdDateTo, $ptTextWhereBranch, $ptTextWherePos, $tTextWhereType,$ptTextWhereDate ,$tTextWhereStaRun,$nRpRnNumberFirst)
    {

        $tSesSessionID = $this->session->userdata('tSesSessionID');
                $tSQL = "SELECT TOP 1 GD.*,HD.* FROM (
                    SELECT 
                        SAL.FNXshDocType,
                        '' AS FTLogUUID,
                        '' AS FTAgnCode,
                        SAL.FTBchCode,
                        SAL.FTPosCode,
                        SAL.FTXshDocNo,
                        SAL.FDXshDocDate,
                        CONCAT(
                        CONVERT(VARCHAR(13),SAL.FTXshDocNo),
                        RIGHT('0000000' + CONVERT(VARCHAR,($nRpRnNumberFirst + ROW_NUMBER() OVER ( PARTITION BY SAL.FNXshDocType,SAL.FTBchCode,SAL.FTPosCode ORDER BY SAL.FNXshDocType,SAL.FTBchCode,SAL.FTPosCode,SAL.FDXshDocDate))),7)
                        ) AS FTXshDocNoNew
                        FROM
                        TPSTSalHD AS SAL WITH(NOLOCK)
                        WHERE  SAL.FTXshDocNo IS NOT NULL
                    $ptTextWhereDate
                    $ptTextWhereBranch
                    $ptTextWherePos
                    $tTextWhereType
                    ) GD
                    LEFT JOIN (
                            SELECT HD.FDXshDocDate AS FDXshDocDateDup,HD.FTXshDocNo AS FTXshDocNoDup,HD.FTBchCode AS FTBchCodeDup,'1' AS tDocDup FROM TPSTSalHD HD WITH (NOLOCK)
                            WHERE HD.FTXshDocNo NOT IN (SELECT FTLogOldDocNo FROM TLGTDocRegen LG  WITH (NOLOCK) WHERE FTLogUUID = '$tSesSessionID' )
                    ) HD ON GD.FTBchCode = HD.FTBchCodeDup AND GD.FTXshDocNoNew = HD.FTXshDocNoDup
                    WHERE ISNULL(HD.tDocDup,'') = '1' 
                     ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataReturn = $oQuery->result_array();
        } else {
            $aDataReturn = array();
        }
        return $aDataReturn;
    }


        // Functionality: Get Numrows Total By Branch
    // Parameters: function parameters
    // Creator:  06/10/2020 Worakorn
    // Return: Data Int
    // Return Type: Int
    public function FSoMSMTFindNotCloseShf($pdDateFrom, $pdDateTo, $ptTextWhereBranch, $ptTextWherePos, $tTextWhereType,$ptTextWhereDate ,$tTextWhereStaRun,$nRpRnNumberFirst)
    {

        $tSesSessionID = $this->session->userdata('tSesSessionID');
                $tSQL = "SELECT TOP 1 GD.* FROM (
                    SELECT 
                        SAL.FNXshDocType,
                        '' AS FTLogUUID,
                        '' AS FTAgnCode,
                        SAL.FTBchCode,
                        SAL.FTPosCode,
                        SAL.FTXshDocNo,
                        SAL.FDXshDocDate,
                        CONCAT(
                        CONVERT(VARCHAR(13),SAL.FTXshDocNo),
                        RIGHT('0000000' + CONVERT(VARCHAR,($nRpRnNumberFirst + ROW_NUMBER() OVER ( PARTITION BY SAL.FNXshDocType,SAL.FTBchCode,SAL.FTPosCode ORDER BY SAL.FNXshDocType,SAL.FTBchCode,SAL.FTPosCode,SAL.FDXshDocDate))),7)
                        ) AS FTXshDocNoNew,
                        CASE WHEN ISNULL(SHIF.FDShdSignOut,'') != '' THEN
						    1
						ELSE
						    2
					    END AS tStaShfClose,
                        SHIF.FDShdSignOut
                        FROM
                        TPSTSalHD AS SAL WITH(NOLOCK)
                        LEFT JOIN TPSTShiftHD AS SHIF WITH (NOLOCK) ON SAL.FTBchCode = SHIF.FTBchCode AND SAL.FTPosCode = SHIF.FTPosCode AND SAL.FTShfCode = SHIF.FTShfCode
                        WHERE  SAL.FTXshDocNo IS NOT NULL
                    $ptTextWhereDate
                    $ptTextWhereBranch
                    $ptTextWherePos
                    $tTextWhereType
                    ) GD
                    WHERE  ISNULL(GD.FDShdSignOut,'') = ''
                    ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataReturn = $oQuery->result_array();
        } else {
            $aDataReturn = array();
        }
        return $aDataReturn;
    }



    // Functionality: Get Numrows Total By Branch
    // Parameters: function parameters
    // Creator:  06/10/2020 Worakorn
    // Return: Data Int
    // Return Type: Int
    public function FSoMSMTGetPageAll($pdDateFrom, $pdDateTo, $ptTextWhereBranch, $ptTextWherePos, $tTextWhereType,$ptTextWhereDate ,$tTextWhereStaRun,$nRpRnNumberFirst)
    {

        $tSesSessionID = $this->session->userdata('tSesSessionID');
                $tSQL = " SELECT c.*
                    FROM
                    (
                    SELECT GD.*,HD.* FROM (
                    SELECT 
                        SAL.FNXshDocType,
                        '' AS FTLogUUID,
                        '' AS FTAgnCode,
                        SAL.FTBchCode,
                        SAL.FTPosCode,
                        SAL.FTXshDocNo,
                        SAL.FDXshDocDate,
                        CONCAT(
                        CONVERT(VARCHAR(13),SAL.FTXshDocNo),
                        RIGHT('0000000' + CONVERT(VARCHAR,($nRpRnNumberFirst + ROW_NUMBER() OVER ( PARTITION BY SAL.FNXshDocType,SAL.FTBchCode,SAL.FTPosCode ORDER BY SAL.FNXshDocType,SAL.FTBchCode,SAL.FTPosCode,SAL.FDXshDocDate))),7)
                        ) AS FTXshDocNoNew
                        FROM
                        TPSTSalHD AS SAL WITH(NOLOCK)
                        WHERE  SAL.FTXshDocNo IS NOT NULL
                    $ptTextWhereDate
                    $ptTextWhereBranch
                    $ptTextWherePos
                    $tTextWhereType
                    ) GD
                    LEFT JOIN (
                            SELECT HD.FDXshDocDate AS FDXshDocDateDup,HD.FTXshDocNo AS FTXshDocNoDup,HD.FTBchCode AS FTBchCodeDup,'1' AS tDocDup FROM TPSTSalHD HD WITH (NOLOCK)
                            WHERE HD.FTXshDocNo NOT IN (SELECT FTLogOldDocNo FROM TLGTDocRegen LG  WITH (NOLOCK) WHERE FTLogUUID = '$tSesSessionID' )
                    ) HD ON GD.FTBchCode = HD.FTBchCodeDup AND GD.FTXshDocNoNew = HD.FTXshDocNoDup
                     $tTextWhereStaRun
                    ) AS c 
                    ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->num_rows();
        } else {
            return false;
        }
    }

    // Functionality: Get Numrows Total By Branch
    // Parameters: function parameters
    // Creator:  06/10/2020 Worakorn
    // Return: Data Int
    // Return Type: Int
    public function FSaMRPNInsertToGTRegen ($pdDateFrom, $pdDateTo, $ptTextWhereBranch, $ptTextWherePos, $tTextWhereType,$ptTextWhereDate,$tTextWhereStaRun,$nRpRnNumberFirst ){
            $tSesSessionID = $this->session->userdata('tSesSessionID');
            $uniqid = uniqid();
            $tSesUsername = $this->session->userdata('tSesUsername');
            $this->db->where('FTLogUUID',$tSesSessionID)->delete('TLGTDocRegen');
            $this->db->where("ISNULL(FTLogStaServer,'')!=",1)->where('FDLastUpdOn<',date('Y-m-d'))->delete('TLGTDocRegen');
      
            $tSQL="INSERT INTO TLGTDocRegen (
                    FTLogUUID,
                    FTAgnCode,
                    FTBchCode,
                    FTPosCode,
                    FTLogOldDocNo,
                    FTLogNewDocNo,
                    FDLastUpdOn,
                    FTLastUpdBy,
                    FDCreateOn,
                    FTCreateBy
                    )
                    SELECT 
                        '$tSesSessionID' AS FTLogUUID,
                        '' AS FTAgnCode,
                        SAL.FTBchCode,
                        SAL.FTPosCode,
                        SAL.FTXshDocNo,
                        CONCAT(
                        CONVERT(VARCHAR(13),SAL.FTXshDocNo),
                        RIGHT('0000000' + CONVERT(VARCHAR,($nRpRnNumberFirst + ROW_NUMBER() OVER ( PARTITION BY SAL.FNXshDocType,SAL.FTBchCode,SAL.FTPosCode ORDER BY SAL.FNXshDocType,SAL.FTBchCode,SAL.FTPosCode,SAL.FDXshDocDate))),7)
                        ) AS FTXshDocNoNew,
                        GETDATE() AS FDLastUpdOn,
                        '$tSesUsername' AS FTLastUpdBy,
                        SAL.FDXshDocDate AS FDLastUpdOn,
                        '$tSesUsername' AS FTCreateBy
                    FROM
                        TPSTSalHD AS SAL WITH(NOLOCK)
                    WHERE  SAL.FTXshDocNo IS NOT NULL 
                        $ptTextWhereDate
                        $ptTextWhereBranch
                        $ptTextWherePos
                        $tTextWhereType
                    ";

        $this->db->query($tSQL);
        if($this->db->affected_rows() > 0){
            $aStatus    = array(
                'rtCode' => '1',
                'rtDesc' => 'Success',
            );
        }else{
            $aStatus    = array(
                'rtCode' => '801',
                'rtDesc' => 'Error',
            );
        }
        return $aStatus;
    }


    // Functionality: Get Numrows Total By Branch
    // Parameters: function parameters
    // Creator:  06/10/2020 Worakorn
    // Return: Data Int
    // Return Type: Int
    public function FSaMRPNUpdateUUIDToGTRegen ($ptUUID){

        $tSesSessionID = $this->session->userdata('tSesSessionID');
        $tSesUsername = $this->session->userdata('tSesUsername');
        $this->db->set('FTLogUUID',$ptUUID);
        $this->db->set('FTLogStaServer',2);
        $this->db->set('FTLogStaClient',2);
        $this->db->set('FDLastUpdOn',date('Y-m-d H:i:s'));
        $this->db->set('FTLastUpdBy',$tSesUsername);
        $this->db->where('FTLogUUID',$tSesSessionID)->update('TLGTDocRegen');
//   echo $this->db->last_query();
//   die();
        if($this->db->affected_rows() > 0){
            $aStatus    = array(
                'rtCode' => '1',
                'rtDesc' => 'Success',
            );
        }else{
            $aStatus    = array(
                'rtCode' => '801',
                'rtDesc' => 'Error',
            );
        }
        return $aStatus;
    }



}