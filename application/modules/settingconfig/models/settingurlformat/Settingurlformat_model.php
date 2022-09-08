<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Settingurlformat_model extends CI_Model {

    //Functionality : list Product Unit
    //Parameters : function parameters
    //Creator :  13/09/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSaMURLList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tAngCode       = $this->session->userdata('tSesUsrAgnCode');           

            $tSQL       = "SELECT c.* FROM(
                                 SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtFspCode DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        FMT.FTFspCode   AS rtFspCode,
										FMT_L.FTFmtName AS rtFmtName,
                                        AGN_L.FTAgnName AS rtAngName,
                                        BCH_L.FTBchName AS rtBchName,
                                        FMT.FTFspStaUse AS rtStaUse,
                                        FMT.FDCreateOn
                                    FROM [TCNMFmtRteSpc] FMT
                                    LEFT JOIN [TCNMAgency_L]  AGN_L ON FMT.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                                    LEFT JOIN [TCNMBranch_L]  BCH_L ON FMT.FTBchCode = BCH_L.FTBchCode AND BCH_L.FNLngID = $nLngID
                                    LEFT JOIN [TFNSFmtURL_L]  FMT_L ON FMT.FTFmtCode = FMT_L.FTFmtCode AND FMT_L.FNLngID = $nLngID AND FTFmtType = 1
                                    WHERE 1=1 ";
            if(!empty($tAngCode)){
                $tSQL .= "AND FMT.FTAgnCode = '$tAngCode'";
            }

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (FMT.FTFspCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
                $tSQL .= " OR AGN_L.FTAgnName COLLATE THAI_BIN LIKE '%$tSearchList%' ";
                $tSQL .= " OR LEFT(AGN_L.FTAgnName,1) = '%$tSearchList%' " ;
                $tSQL .= " OR BCH_L.FTBchName COLLATE THAI_BIN LIKE '%$tSearchList%' ";
                $tSQL .= " OR LEFT(BCH_L.FTBchName,1) = '%$tSearchList%' " ;
                $tSQL .= " OR FMT_L.FTFmtName COLLATE THAI_BIN LIKE '%$tSearchList%' ";
                $tSQL .= " OR LEFT(FMT.FTFmtCode,1)   = '%$tSearchList%' " ;
                $tSQL .= " OR LEFT(FMT_L.FTFmtName,1) = '%$tSearchList%' )" ;
            }
            
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            // print_r($tSQL);
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMURLGetPageAll($tSearchList,$nLngID,$tAngCode);
                $nFoundRow = $oFoundRow[0]->counts;
                $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult = array(
                    'raItems'       => $aList,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paData['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => $aRowLen,
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
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }


    public function FSoMURLCheckStaUse($ptAngCode){
        try{   
            $tSQL = "SELECT FMT.FTFspCode,
                            FMC.FTFmtName
                    FROM [TCNMFmtRteSpc] FMT
                    LEFT JOIN TFNSFmtURL_L FMC ON FMT.FTFmtCode = FMC.FTFmtCode
                    WHERE 1=1 AND FTFspStaUse ='1' AND FTAgnCode = '$ptAngCode' AND FMC.FTFmtType = '1'";           
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aResult = array(
                    'rnAllRow' => $oQuery->result_array(),
                    'rtCode' => '1',
                    'rtDesc' => 'found 1',
                );
                
            }else{
                $aResult = array(
                    'rtCode' => '0',
                    'rtDesc' => 'data not found',
                );  
            }
            return $aResult; 
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : All Page Of Product Unit
    //Parameters : function parameters
    //Creator :  13/09/2018 Wasin
    //Return : object Count All Product Unit
    //Return Type : Object 
    public function FSoMURLGetPageAll($ptSearchList,$ptLngID,$ptAgnCode){
        try{
            $tSQL = "SELECT COUNT (FMT.FTFspCode) AS counts
                     FROM [TCNMFmtRteSpc] FMT
                     LEFT JOIN [TCNMAgency_L]  AGN_L ON FMT.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $ptLngID
                    LEFT JOIN [TCNMBranch_L]  BCH_L ON FMT.FTBchCode = BCH_L.FTBchCode AND BCH_L.FNLngID = $ptLngID
                    LEFT JOIN [TFNSFmtURL_L]  FMT_L ON FMT.FTFmtCode = FMT_L.FTFmtCode AND FMT_L.FNLngID = $ptLngID AND FTFmtType = 1
                     WHERE 1=1";
            if(!empty($ptAgnCode)){
                $tSQL .= " AND FMT.FTAgnCode = '$ptAgnCode'";
            }
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (FMT.FTFspCode COLLATE THAI_BIN LIKE '%$ptSearchList%'";
                $tSQL .= " OR AGN_L.FTAgnName COLLATE THAI_BIN LIKE '%$ptSearchList%' ";
                $tSQL .= " OR LEFT(AGN_L.FTAgnName,1) = '%$ptSearchList%' " ;
                $tSQL .= " OR BCH_L.FTBchName COLLATE THAI_BIN LIKE '%$ptSearchList%' ";
                $tSQL .= " OR LEFT(BCH_L.FTBchName,1) = '%$ptSearchList%' " ;
                $tSQL .= " OR FMT_L.FTFmtName COLLATE THAI_BIN LIKE '%$ptSearchList%' ";
                $tSQL .= " OR LEFT(FMT.FTFmtCode,1)   = '%$ptSearchList%' " ;
                $tSQL .= " OR LEFT(FMT_L.FTFmtName,1) = '%$ptSearchList%' )" ;
            }
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            }else{
                return false;
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Get Data Product Unit By ID
    //Parameters : function parameters
    //Creator : 13/09/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSaMURLGetDataByID($paData){
        try{
            $tUrlCode   = $paData['FTFspCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT FMT.FTFspCode as rtFspCode,
                                FMT.FTAgnCode	AS rtAngCode,
                                AGN_L.FTAgnName as rtAngName,
                                FMT.FTBchCode	AS rtBchCode,
                                BCH_L.FTBchName AS rtBchName,
                                FMT.FTFmtCode	AS	rtFmtCode,
                                FMT_L.FTFmtName AS rtFmtName,
                                FMT.FTFspStaUse AS rtStaUse
                            FROM TCNMFmtRteSpc FMT  
                            LEFT JOIN [TCNMAgency_L]  AGN_L ON FMT.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                            LEFT JOIN [TCNMBranch_L]  BCH_L ON FMT.FTBchCode = BCH_L.FTBchCode AND BCH_L.FNLngID = $nLngID
                            LEFT JOIN [TFNSFmtURL_L]  FMT_L ON FMT.FTFmtCode = FMT_L.FTFmtCode AND FMT_L.FNLngID = $nLngID
                            WHERE 1 = 1 AND FMT.FTFspCode = '$tUrlCode' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDetail = $oQuery->row_array();
                $aResult = array(
                    'raItems'   => $aDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            }else{
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'Data not found.',
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Checkduplicate Product Unit 
    //Parameters : function parameters
    //Creator : 13/09/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSnMURLCheckDuplicate($ptUrlCode){
        $tSQL = "SELECT COUNT(FMT.FTFspCode) AS counts
                 FROM TCNMFmtRteSpc FMT 
                 WHERE FMT.FTFspCode = '$ptUrlCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update ProductUnit (TCNMPdtUnit)
    //Parameters : function parameters
    //Creator : 13/09/2018 Wasin
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMCTYAddUpdateMaster($paUrlData){
        try{
            if($paUrlData['FTFspStaUse'] == '1'){
                $this->db->where('FTAgnCode',$paUrlData['FTAgnCode']);
                $this->db->update('TCNMFmtRteSpc',array(
                   'FTFspStaUse'    =>  '2',
                ));
            }
            $this->db->where('FTFspCode', $paUrlData['FTFspCode']);
            $this->db->update('TCNMFmtRteSpc',array(
                    'FTFspCode'     => $paUrlData['FTFspCode'],
                    'FTFmtCode'    => $paUrlData['FTFmtCode'],
                    'FTFspStaUse'    => $paUrlData['FTFspStaUse'],
                    'FTAgnCode'   => $paUrlData['FTAgnCode'],
                    'FTBchCode'   => $paUrlData['FTBchCode'],
                    'FDLastUpdOn'     => $paUrlData['FDLastUpdOn'],
                    'FDCreateOn'       => $paUrlData['FDCreateOn'],
                    'FTLastUpdBy'   => $paUrlData['FTLastUpdBy'],
                    'FTCreateBy'  => $paUrlData['FTCreateBy'],
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update ProductUnit Success',
                );
            }else{
                if($paUrlData['FTFspStaUse'] == '1'){
                    $this->db->where('FTAgnCode',$paUrlData['FTAgnCode']);
                    $this->db->update('TCNMFmtRteSpc',array(
                       'FTFspStaUse'    =>  '2',
                    ));
                }
                $this->db->insert('TCNMFmtRteSpc', array(
                    'FTFspCode'     => $paUrlData['FTFspCode'],
                    'FTFmtCode'    => $paUrlData['FTFmtCode'],
                    'FTFspStaUse'    => $paUrlData['FTFspStaUse'],
                    'FTAgnCode'   => $paUrlData['FTAgnCode'],
                    'FTBchCode'   => $paUrlData['FTBchCode'],
                    'FDLastUpdOn'     => $paUrlData['FDLastUpdOn'],
                    'FDCreateOn'       => $paUrlData['FDCreateOn'],
                    'FTLastUpdBy'   => $paUrlData['FTLastUpdBy'],
                    'FTCreateBy'  => $paUrlData['FTCreateBy'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Format Url Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Format Url.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete ProductUnit
    //Parameters : function parameters
    //Creator : 13/09/2018 Wasin
    //Update : 1/04/2019 Pap
    //Return : 
    //Return Type : array
    public function FSaMPUNDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTFspCode', $paData['FTFspCode']);
            $this->db->delete('TCNMFmtRteSpc');

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Delete Unsuccess.',
                );
            }else{
                $this->db->trans_commit();
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete Success.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : get all row data from pdt location
    //Parameters : -
    //Creator : 1/04/2019 Pap
    //Return : array result from db
    //Return Type : array
    public function FSnMPUNGetAllNumRow($patAngCodeHide){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMFmtRteSpc WHERE TCNMFmtRteSpc.FTAgnCode = '$patAngCodeHide' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }



































































































}