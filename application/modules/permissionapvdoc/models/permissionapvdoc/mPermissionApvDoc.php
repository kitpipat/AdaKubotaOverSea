<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPermissionApvDoc extends CI_Model {
    
    //Functionality : list Data PermissionApvDoc
    //Parameters : function parameters
    //Creator :  17/02/2020 Saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMPADListData($paData){

        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID  = $paData['FNLngID'];
        $tSearchList = $paData['tSearchAll'];
        $tSQL    = "SELECT c.* FROM(
                        SELECT ROW_NUMBER() OVER( ORDER BY rtDapTable ASC) AS FNRowID, 
                            *
                    FROM
                    (
                        SELECT  DAP.*, 
                                DT.FTSdtDocName AS rtSdtDocName
                        FROM
                        (
                            SELECT DISTINCT 
                                FTDapTable   AS rtDapTable, 
                                FTDapRefType AS rtDapRefType
                            FROM TSysDocApv
                            where FNDapStaUse ='1' 
                        ) DAP
                        LEFT JOIN TSysDocType DT ON DAP.rtDapTable = DT.FTSdtTblName
                        AND DAP.rtDapRefType = DT.FNSdtDocType
                    
            ";
        if($tSearchList != ''){
            $tSQL .= "WHERE DT.FTSdtDocName COLLATE THAI_BIN LIKE '%$tSearchList%'"; 
        }
        $tSQL .= " ) Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMPADGetPageAll($tSearchList);
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
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Functionality : All Page Of PermissionApvDoc
    //Parameters : function parameters
    //Creator :  17/02/2020 Saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMPADGetPageAll($ptSearchList){
        $tSQL = "SELECT  COUNT (DAP.rtDapTable) AS counts
                        FROM
                        (
                            SELECT DISTINCT 
                                FTDapTable   AS rtDapTable, 
                                FTDapRefType AS rtDapRefType
                            FROM TSysDocApv
                        ) DAP
                        LEFT JOIN TSysDocType DT ON DAP.rtDapTable = DT.FTSdtTblName
                        AND DAP.rtDapRefType = DT.FNSdtDocType
                 ";
        if(@$tSearchList != ''){
            $tSQL .= " AND (DT.FTSdtTblName COLLATE THAI_BIN LIKE '%$ptSearchList%')";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }

    //Functionality : Search PermissionApvDoc By ID
    //Parameters : function parameters
    //Creator 17/02/2020 Saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMPADSearchByID($paData){

        $tDapTable       = $paData['FTDapTable'];
        $tDapRefType     = $paData['FTDapRefType'];
        $tFNLngID        = $paData['FNLngID'];
    
        $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID  = $paData['FNLngID'];

        $tSQL    = "SELECT c.* FROM(
                        SELECT ROW_NUMBER() OVER( ORDER BY FNDapSeq ASC) AS FNRowID, 
                            *
                    FROM
                    (
                        SELECT DAP.FTDapCode,
                                DAP.FTDapName,
                                DAP.FNDapSeq,
                                DAP.FTDapRefType,
                                DAP.FTDapUsrRoleGrp,
                                DAP.FTDapTable,
                                DAR.FTDarUsrRole,
                                TRL.FTRolName,
                                DAR.FTDarStaColor
                        FROM TSysDocApv DAP
                        LEFT JOIN TCNMDocApvRole DAR ON DAP.FTDapTable = DAR.FTDarTable 
                        AND DAP.FTDapRefType = DAR.FTDarRefType 
                        AND DAP.FNDapSeq = DAR.FNDarApvSeq  
                        LEFT JOIN TCNMUsrRole_L TRL ON DAR.FTDarUsrRole = TRL.FTRolCode  
                        AND TRL.FNLngID = '$tFNLngID'
                        WHERE 1=1
                        AND DAP.FTDapTable    = '$tDapTable'
                        AND DAP.FTDapRefType  = '$tDapRefType'
                        AND DAP.FNDapStaUse   = '1'
                    )
        ";
  
        $tSQL .= " Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMPADGetPageGetID($paData);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow+1,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            //No Data
            $aResult = array(
                'rnAllRow'      => 1,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;


    }

     //Functionality : All Page Of PermissionApvDoc
    //Parameters : function parameters
    //Creator :  12/02/2020 Saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMPADGetPageGetID($paData){

        $tDapTable       = $paData['FTDapTable'];
        $tDapRefType     = $paData['FTDapRefType'];

        $tSQL = "SELECT  COUNT (DAP.FNDapSeq) AS counts
            FROM TSysDocApv DAP
            LEFT JOIN TCNMDocApvRole DAR ON DAP.FTDapTable = DAR.FTDarTable AND DAP.FTDapRefType = DAR.FTDarRefType 
            AND DAP.FNDapSeq = DAR.FNDarApvSeq 
            WHERE 1=1
            AND DAP.FTDapTable    = '$tDapTable'
            AND DAP.FTDapRefType  = '$tDapRefType' ";
    
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }
    
    //Functionality : Update / Add TCNMDocApvRole
    //Parameters : function parameters
    //Creator : 17/02/2020 Saharat(Golf)
    //Last Modified : -
    //Return : response
    //Return Type : Array
    public function FSaMPADAddUpdateMaster($paDetailItems,$paData){
        try{

            $this->db->where('FTDarTable', $paData['FTDarTable']);
            $this->db->delete('TCNMDocApvRole');

            if(isset($paDetailItems) && !empty($paDetailItems)){
                // Loop Add/Update 
                foreach($paDetailItems AS $nKey => $aValue){
                $tColor = str_replace('#','',$aValue['tColorCode']);

                //Update Master
                $tSQLInsert = "";
                $tSQLInsert = " INSERT INTO TCNMDocApvRole (FTDarCode,FTDarTable,FTDarRefType,FNDarApvSeq,FTDarUsrRole,FTDarStaColor,FDLastUpdOn,
                                    FTLastUpdBy,FDCreateOn,FTCreateBy)
                                VALUES (    
                                            '".$aValue['tCode']."',
                                            '".$aValue['tTable']."',
                                            '".$aValue['tType']."',
                                            '".$aValue['tDapSeq']."',
                                            '".$aValue['tUserrole']."',
                                            '".$tColor."',
                                            '".$paData['FDLastUpdOn']."',
                                            '".$paData['FTLastUpdBy']."',
                                            '".$paData['FDCreateOn']."',
                                            '".$paData['FTCreateBy']."'
                                        )";
                    $oQuery = $this->db->query($tSQLInsert);
                }   
            }
        }catch(Exception $Error){
            return $Error;
        }
        
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
