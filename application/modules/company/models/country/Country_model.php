<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Country_model extends CI_Model {

    //Functionality : list Product Unit
    //Parameters : function parameters
    //Creator :  13/09/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSaMCTYList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tAgnLangCode   = $paData['tAgnLangCode']['FNLngID'];
            $tUserLang      = $this->session->userdata('tLangID');
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtCtyCode DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        CTY.FTCtyCode   AS rtCtyCode,
                                        CTY_L.FTCtyName AS rtCtyName,
                                        CTY.FDCreateOn
                                    FROM [TCNMCountry] CTY
                                    LEFT JOIN [TCNMCountry_L]  CTY_L ON CTY.FTCtyCode = CTY_L.FTCtyCode AND CTY_L.FNLngID = '$nLngID'                  
									OR CTY.FTCtyCode = CTY_L.FTCtyCode AND CTY_L.FNLngID = '$tUserLang' ";

            if(!empty($tAgnLangCode)){
                $tSQL .= " OR CTY.FTCtyCode = CTY_L.FTCtyCode AND CTY_L.FNLngID = '$tAgnLangCode'";
            }
            $tSQL .= " WHERE 1=1 ";

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (CTY.FTCtyCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
                $tSQL .= " OR CTY_L.FTCtyName COLLATE THAI_BIN LIKE '%$tSearchList%' ";
                $tSQL .= " OR LEFT(CTY.FTCtyCode,1)   = '%$tSearchList%' " ;
                $tSQL .= " OR LEFT(CTY_L.FTCtyName,1) = '%$tSearchList%' )" ;
            }
            
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            // print_r($tSQL);
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMPUNGetPageAll($tSearchList,$nLngID);
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

    //Functionality : All Page Of Product Unit
    //Parameters : function parameters
    //Creator :  13/09/2018 Wasin
    //Return : object Count All Product Unit
    //Return Type : Object 
    public function FSoMPUNGetPageAll($ptSearchList,$ptLngID){
        try{
            $tSQL = "SELECT COUNT (CTY.FTCtyCode) AS counts
                     FROM [TCNMCountry] CTY
                     LEFT JOIN [TCNMCountry_L]  CTY_L ON CTY.FTCtyCode = CTY_L.FTCtyCode AND CTY_L.FNLngID = $ptLngID
                     WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (CTY.FTCtyCode COLLATE THAI_BIN LIKE '%$ptSearchList%'";
                $tSQL .= " OR CTY_L.FTCtyName  COLLATE THAI_BIN LIKE '%$ptSearchList%')";
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
    public function FSaMCTYGetDataByID($paData){
        try{
            $tAgnLangCode   = $paData['tAgnLangCode']['FNLngID'];
            $tUserLang      = $this->session->userdata('tLangID');
            $tCtyCode   = $paData['FTCtyCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT CTY.FNLngID as rtCtyLangID,
                                    STSL.FTLngNameEng as rtLangName,
                                    CTY.FTCtyCode AS rtCtyCode,
                                    CTY_L.FTCtyName AS rtCtyName,
                                    CTY.FTVatCode AS rtCtyVatCode,
                                    VVA.FCVatRate AS rtCtyVatRate,
                                    CTY.FTRteIsoCode AS rtIsoCode,
                                    CTY.FTCtyStaUse AS  rtCtyStaUse,
                                    CTY.FTCtyStaCtrlRate AS reCtyStaCtrlRate,
                                    CTY.FTCtyLatitude AS rtCtyLatitude,
	                                CTY.FTCtyLongitude AS rtCtyLongitude,
                                    RATE_L.FTRteIsoName AS rtRteIsoName,
                                    CTY.FTCtyRefID AS rtCtyRefID
                            FROM TCNMCountry CTY 
                            LEFT JOIN TCNMCountry_L CTY_L ON CTY.FTCtyCode = CTY_L.FTCtyCode 
                            LEFT JOIN TSysLanguage STSL ON CTY.FNLngID = STSL.FNLngID
                            LEFT JOIN VCN_VatActive VVA ON CTY.FTVatCode = VVA.FTVatCode
                            LEFT JOIN TCNSRate_L RATE_L ON CTY.FTRteIsoCode = RATE_L.FTRteIsoCode";
            $tSQL .= " WHERE 1 = 1 AND CTY.FTCtyCode = '$tCtyCode' ";

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
    public function FSnMCTYCheckDuplicate($ptCtyCode){
        $tSQL = "SELECT COUNT(CTY.FTCtyCode) AS counts
                 FROM TCNMCountry CTY 
                 WHERE CTY.FTCtyCode = '$ptCtyCode' ";
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
    public function FSaMCTYAddUpdateMaster($paDataCty){
        try{
            $this->db->where('FTCtyCode', $paDataCty['FTCtyCode']);
            $this->db->update('TCNMCountry',array(
                'FTCtyCode'     => $paDataCty['FTCtyCode'],
                    'FDCreateOn'    => $paDataCty['FDCreateOn'],
                    'FTCreateBy'    => $paDataCty['FTCreateBy'],
                    'FDLastUpdOn'   => $paDataCty['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paDataCty['FTLastUpdBy'],
                    'FTVatCode'     => $paDataCty['FTVatCode'],
                    'FNLngID'       => $paDataCty['FNLngID'],
                    'FTCtyStaUse'   => $paDataCty['FTCtyStaUse'],
                    'FTRteIsoCode'  => $paDataCty['FTRteIsoCode'],
                    'FTCtyStaCtrlRate' => $paDataCty['FTCtyStaCtrlRate'],
                    'FTCtyLongitude' => $paDataCty['FTCtyLongitude'],
                    'FTCtyLatitude' => $paDataCty['FTCtyLatitude'],
                    'FTCtyRefID'    => $paDataCty['FTCtyRefID'],
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update ProductUnit Success',
                );
            }else{
                $this->db->insert('TCNMCountry', array(
                    'FTCtyCode'     => $paDataCty['FTCtyCode'],
                    'FDCreateOn'    => $paDataCty['FDCreateOn'],
                    'FTCreateBy'    => $paDataCty['FTCreateBy'],
                    'FDLastUpdOn'   => $paDataCty['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paDataCty['FTLastUpdBy'],
                    'FTVatCode'     => $paDataCty['FTVatCode'],
                    'FNLngID'       => $paDataCty['FNLngID'],
                    'FTCtyStaUse'   => $paDataCty['FTCtyStaUse'],
                    'FTRteIsoCode'  => $paDataCty['FTRteIsoCode'],
                    'FTCtyStaCtrlRate' => $paDataCty['FTCtyStaCtrlRate'],
                    'FTCtyLongitude' => $paDataCty['FTCtyLongitude'],
                    'FTCtyLatitude' => $paDataCty['FTCtyLatitude'],
                    'FTCtyRefID'    => $paDataCty['FTCtyRefID'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Country Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Country.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update ProductUnit Lang (TCNMPdtUnit_L)
    //Parameters : function parameters
    //Creator : 13/09/2018 Wasin
    //Update : 1/04/2019 Pap
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMCTYAddUpdateLang($paDataCty){
        // $tSQL = "INSERT INTO TCNMPdtUnit_L (FTPunCode,FNLngID,FTPunName)
        //          VALUES('".$paDataCty["FTPunCode"]."',
        //                 '".$this->session->userdata("tLangID")."',
        //                 '".$paDataCty["FTPunName"]."')";
        // $this->db->query($tSQL);
        try{
            //Update Pdt Unit Lang
            $this->db->where('FNLngID', $paDataCty['langEdit']);
            $this->db->where('FTCtyCode', $paDataCty['FTCtyCode']);
            $this->db->update('TCNMCountry_L',array('FTCtyName' => $paDataCty['FTCtyName']));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Unit Lang Success.',
                );
            }else{
                //Add Pdt Unit Lang
                $this->db->insert('TCNMCountry_L', array(
                    'FTCtyCode' => $paDataCty['FTCtyCode'],
                    'FNLngID'   => $paDataCty['langEdit'],
                    'FTCtyName' => $paDataCty['FTCtyName']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Country Unit Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Country Lang.',
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

            $this->db->where_in('FTCtyCode', $paData['FTCtyCode']);
            $this->db->delete('TCNMCountry');

            $this->db->where_in('FTCtyCode', $paData['FTCtyCode']);
            $this->db->delete('TCNMCountry_L');

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
    public function FSnMPUNGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMCountry";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

    public function FSnMCTYGetLangLocal(){
        $tSQL = "SELECT FNLngID  FROM TSysLanguage WHERE FTLngStaLocal = '1'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array();
        }else{
            $aResult = false;
        }
        return $aResult;
    }

    public function FSnMCTYGetLangAgent(){
        $tAngCode       = $this->session->userdata('tSesUsrAgnCode');   
        $tSQL = "SELECT CTY.FNLngID  FROM TCNMAgency AGN LEFT JOIN TCNMCountry CTY ON AGN.FTCtyCode = CTY.FTCtyCode WHERE AGN.FTAgnCode = '$tAngCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array();
        }else{
            $aResult = false;
        }
        return $aResult;
    }



































































































}