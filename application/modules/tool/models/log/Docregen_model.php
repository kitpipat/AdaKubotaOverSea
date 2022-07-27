<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Docregen_model extends CI_Model {

    //Functionality : list Branch
    //Parameters : function parameters
    //Creator : 09/03/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMDRGDataTable($paData) {

        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID = $this->session->userdata('tLangEdit');

        $tDRGBchCode = $this->input->post('oetDRGBchCode');
        $tDRGPosCode = $this->input->post('oetDRGPosCode');
        $tDRGDataForm = $this->input->post('oetDRGDataForm');
        $tDRGDataTo = $this->input->post('oetDRGDataTo');
        $tDRGUUIDFrm = $this->input->post('oetDRGUUIDFrm');
        $tDRGUUIDTo = $this->input->post('oetDRGUUIDTo');
        $tDRGDocNoOld = $this->input->post('oetDRGDocNoOld');
        $tDRGBillType = $this->input->post('oetDRGBillType');
        $tWhere = "";

        // User BCH Level
		if ($this->session->userdata('tSesUsrLevel') == "BCH") { // ผู้ใช้ระดับ BCH ดูได้แค่สาขาที่มีสิทธิ์
			$tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
			$tWhere .= " AND GRD.FTBchCode IN($tBchCodeMulti)";
        }


        if(!empty($tDRGBchCode)){
            $tWhere .= " AND GRD.FTBchCode='$tDRGBchCode' "; 
        }

        if(!empty($tDRGPosCode)){
            $tWhere .= " AND GRD.FTPosCode='$tDRGPosCode' "; 
        }
        if(empty($tDRGUUIDFrm) && empty($tDRGUUIDTo) && empty($tDRGDocNoOld)){
            if(!empty($tDRGDataForm) && !empty($tDRGDataTo)){
                $tWhere .= "  AND CONVERT (DATE, GRD.FDCreateOn, 103) BETWEEN '$tDRGDataForm' AND '$tDRGDataTo' "; 
            }
        }
        
        if(!empty($tDRGUUIDFrm)){
            $tWhere .= " AND GRD.FTLogUUID>='$tDRGUUIDFrm' "; 
        }

        if(!empty($tDRGUUIDTo)){
            $tWhere .= " AND GRD.FTLogUUID<='$tDRGUUIDTo' "; 
        }

        if(!empty($tDRGDocNoOld)){
            $tWhere .= " AND GRD.FTLogOldDocNo='$tDRGDocNoOld' "; 
        }

        if ($tDRGBillType != '') {
            $tWhere  .= " AND SHD.FNXshDocType = $tDRGBillType";
        }else{
            $tWhere   .= '';
        }

        $tSQL   =   "   SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY FTLogUUID,FTBchCode,FTPosCode,FTLogOldDocNo) AS rtRowID,* FROM (
                                SELECT
                                    GRD.FTLogUUID,
                                    GRD.FTBchCode,
                                    BCHL.FTBchName,
                                    GRD.FTPosCode,
                                    GRD.FTLogOldDocNo,
                                    GRD.FTLogNewDocNo,
                                    GRD.FTLogStaServer,
                                    GRD.FTLogStaClient,
                                    GRD.FDLastUpdOn,
                                    GRD.FDCreateOn
                                FROM
                                     (
                                        SELECT *,
                                        CASE WHEN GRDS.FTLogStaServer=1 THEN
                                            GRDS.FTLogNewDocNo
                                        ELSE
                                            GRDS.FTLogOldDocNo
                                        END AS FTDocNoJoin 
                                     FROM 
                                        TLGTDocRegen GRDS WITH(NOLOCK)
                                    ) GRD
                                LEFT OUTER JOIN TCNMBranch_L BCHL WITH(NOLOCK) ON GRD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                                LEFT OUTER JOIN TPSTSalHD SHD  WITH(NOLOCK) ON GRD.FTBchCode = SHD.FTBchCode AND GRD.FTDocNoJoin = SHD.FTXshDocNo
                            WHERE ISNULL(GRD.FTLogStaServer,'') !='' 
                            $tWhere

        ";


        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();
        // die();

        if ($oQuery->num_rows() > 0) {

            $aList = $oQuery->result();
            $aFoundRow = $this->JSnMDRGBCHGetPageAll($tWhere);
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
    function JSnMDRGBCHGetPageAll($ptWhere) {
        $nLngID = $this->session->userdata('tLangEdit');
        $tSQL = "SELECT  COUNT(*) AS counts
                        FROM
                        (SELECT *,
                        CASE WHEN GRDS.FTLogStaServer=1 THEN
                            GRDS.FTLogNewDocNo
                        ELSE
                            GRDS.FTLogOldDocNo
                        END AS FTDocNoJoin 
                        FROM 
                        TLGTDocRegen GRDS WITH(NOLOCK)
                                    ) GRD
                        LEFT OUTER JOIN TCNMBranch_L BCHL WITH(NOLOCK) ON GRD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                        LEFT OUTER JOIN TPSTSalHD SHD  WITH(NOLOCK) ON GRD.FTBchCode = SHD.FTBchCode AND GRD.FTDocNoJoin = SHD.FTXshDocNo
                    WHERE ISNULL(GRD.FTLogStaServer,'') !=''
                    $ptWhere
                    ";
                    
	

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {

            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }



}