<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Slipmessage_model extends CI_Model {

    /**
     * Functionality : Search UsrDepart By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMSMGSearchByID($ptAPIReq, $ptMethodReq, $paData){
        
        $tDstCode = $paData['FTSmgCode'];
        $nLngID = $paData['FNLngID'];
        
        // Slip query
        $tHDSQL =   "SELECT
                        SMGHD.FTSmgCode AS rtSmgCode,
                        SMGHD.FNLngID AS rtSmgLngID,
                        SMGHD.FTSmgTitle AS rtSmgTitle,
                        SMGHD.FTFonts as rtSmgFonts
                    FROM [TCNMSlipMsgHD_L] SMGHD
                    WHERE 1=1 
                    AND SMGHD.FNLngID = $nLngID
                    AND SMGHD.FTSmgCode = '$tDstCode'";
        $oHDQuery = $this->db->query($tHDSQL);
        
        // Head of receipt and End of receipt query
        $tDTSQL =   "SELECT
                        SMGDT.FTSmgName  AS rtSmgName,
                        SMGDT.FTSmgType AS rtSmgType,
                        SMGDT.FNSmgSeq AS rtSmgSeq
                    FROM [TCNMSlipMsgDT_L] SMGDT
                    WHERE 1=1 
                    AND SMGDT.FNLngID = $nLngID
                    AND SMGDT.FTSmgCode = '$tDstCode' ORDER BY SMGDT.FNSmgSeq";
        $oDTQuery = $this->db->query($tDTSQL);
        
        if ($oHDQuery->num_rows() > 0){ // Have slip
            
            $oHDDetail = $oHDQuery->result();
            $oDTDetail = $oDTQuery->result();
            
            // Prepare Head of receipt and End of receipt data
            $aDTHeadItems = [];
            $aDTEndItems = [];
            foreach ($oDTDetail as $nIndex => $oItem){
                if($oItem->rtSmgType == 1){ // Head of receipt type
                    $aDTHeadItems[] = $oItem->rtSmgName;
                }
                
                if($oItem->rtSmgType == 2){ // End of receipt type
                    $aDTEndItems[] = $oItem->rtSmgName;
                }                
            }
            
            // Found
            $aResult = array(
                'raHDItems'   => $oHDDetail[0],
                'raDTHeadItems' => $aDTHeadItems,
                'raDTEndItems' => $aDTEndItems,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
            
        }else{
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
     * Functionality : List department
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMSMGList($ptAPIReq, $ptMethodReq, $paData){
    	// return null;
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        
        $tSQL       = "SELECT c.* FROM(
                       SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtSmgCode DESC) AS rtRowID,*
                       FROM
                       (SELECT DISTINCT
                                SMGHD.FTSmgCode   AS rtSmgCode,
                                SMGHD.FTSmgTitle AS rtSmgTitle,
                                SMGHD.FNLngID   AS rtSmgLanID,
                                SMGHD.FDCreateOn
                            FROM [TCNMSlipMsgHD_L] SMGHD
                            WHERE 1=1";
        
        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            $tSQL .= " AND (SMGHD.FTSmgCode LIKE '%$tSearchList%'";
            $tSQL .= " OR SMGHD.FTSmgTitle LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMSMGGetPageAll(/*$tWhereCode,*/ $tSearchList);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            //No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"=> 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }
    
    /**
     * Functionality : All Page Of Slip Message
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMSMGGetPageAll(/*$ptWhereCode,*/ $ptSearchList){
        $tSQL = "SELECT COUNT (SMGHD.FTSmgCode) AS counts
                FROM [TCNMSlipMsgHD_L] SMGHD
                WHERE 1=1";
        
        if($ptSearchList != ''){
            $tSQL .= " AND (SMGHD.FTSmgCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR SMGHD.FTSmgTitle  LIKE '%$ptSearchList%')";
        }
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }

    /**
     * Functionality : Checkduplicate
     * Parameters : $ptDstCode
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMSMGCheckDuplicate($ptDstCode){
        $tSQL = "SELECT COUNT(FTSmgCode) AS counts
                 FROM TCNMSlipMsgHD_L
                 WHERE FTSmgCode = '$ptDstCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    /**
     * Functionality : Update Slip Message
     * Parameters : $paData is data for update
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMSMGAddUpdateHD($paData){
        try{
            $tSQL = " UPDATE TCNMSlipMsgHD_L";
            $tSQL .= " SET FTSmgTitle = N'".$paData['FTSmgTitle']."', FDLastUpdOn = '".$paData['FDLastUpdOn']."', FTLastUpdBy = '".$paData['FTLastUpdBy']."', FTFonts = '".$paData['FTFonts']."', FNLngID = '".$paData['FNLngID']."'";
            $tSQL .= " WHERE FTSmgCode = ".$paData['FTSmgCode']."";
            $oQuery = $this->db->query($tSQL);
            // Update Header
            // $this->db->set('FTSmgTitle' , $paData['FTSmgTitle']);
            // $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            // $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
            // $this->db->set('FTFonts', $paData['FTFonts']);
            // $this->db->set('FNLngID', $paData['FNLngID']);
            // $this->db->where('FTSmgCode', $paData['FTSmgCode']);
            // $this->db->update('TCNMSlipMsgHD_L');

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                // Add Header
                $tSQL = " INSERT INTO TCNMSlipMsgHD_L VALUES ('".$paData['FTSmgCode']."','".$paData['FNLngID']."', N'".$paData['FTSmgTitle']."','".$paData['FDCreateOn']."','".$paData['FTCreateBy']."','".$paData['FDLastUpdOn']."','".$paData['FTLastUpdBy']."','".$paData['FTFonts']."')";
                $oQuery = $this->db->query($tSQL);
                // $this->db->insert('TCNMSlipMsgHD_L',array(
                //     'FTSmgCode'     => $paData['FTSmgCode'],
                //     'FTSmgTitle'    => $paData['FTSmgTitle'],
                //     'FDCreateOn'    => $paData['FDCreateOn'],
                //     'FTCreateBy'    => $paData['FTCreateBy'],
                //     'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                //     'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                //     'FNLngID'       => $paData['FNLngID'],
                //     'FTFonts'       => $paData['FTFonts'],
                // ));
                
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Master Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    /**
     * Functionality : Update Lang Slip Message
     * Parameters : $paData is data for update
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMSMGAddUpdateDT($paData){
        try{
            // Add Detail
            $tSQL = " INSERT INTO TCNMSlipMsgDT_L VALUES ('".$paData['FTSmgCode']."','".$paData['FNLngID']."', '".$paData['FTSmgType']."','".$paData['FNSmgSeq']."', N'".$paData['FTSmgName']."')";
            $oQuery = $this->db->query($tSQL);
            
            // Set Response status
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Lang Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Lang.',
                );
            }
            
            // Response status
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    /**
     * Functionality : Delete Slip Message
     * Parameters : $paData
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMSMGDelHD($paData){
        $this->db->where_in('FTSmgCode', $paData['FTSmgCode']);
        $this->db->delete('TCNMSlipMsgHD_L');
        
        $this->db->where_in('FTSmgCode', $paData['FTSmgCode']);
        $this->db->delete('TCNMSlipMsgDT_L');
        if($this->db->affected_rows() > 0){
            // Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            // Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
        
        // return $aStatus = array(
        //     'rtCode' => '1',
        //     'rtDesc' => 'success',
        // );
    }
    
    /**
     * Functionality : {description}
     * Parameters : {params}
     * Creator : dd/mm/yyyy piya
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    public function FSnMSMGDelDT($paData){
        
        $this->db->where('FTSmgCode', $paData['FTSmgCode']);
        $this->db->delete('TCNMSlipMsgDT_L');
        
        /*if($this->db->affected_rows() > 0){
            // Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            // Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;*/
        
        return $aStatus = array(
            'rtCode' => '1',
            'rtDesc' => 'success',
        );
    }
       

   
    //Functionality : get all row data from pdt location
    //Parameters : -
    //Creator : 1/04/2019 Pap
    //Return : array result from db
    //Return Type : array

    public function FSnMLOCGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMSlipMsgHD_L";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

    public function FSaMSMGGetStaUse(){
        $tSQL = "SELECT DISTINCT * FROM TSysLanguage";
        $tSQL .= " WHERE FTLngStaUse = '1' ";
        $oDTQuery = $this->db->query($tSQL);
        if($oDTQuery->num_rows() > 0){
            return $oDTQuery->result_array();
        }else{
            //No Data
            return array();
        }  
    }

    public function FSaMSMGGetFonts(){
        $tSQL = "SELECT DISTINCT * FROM TCNSFonts WHERE FTFntStause = 1";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0 ){
            $aResult = $oQuery->result_array();
        }else{
            $aResult = false;
        }
        return $aResult;
    }
}
