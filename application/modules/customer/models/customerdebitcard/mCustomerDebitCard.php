<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCustomerDebitCard extends CI_Model {

    //Functionality : List CompSettingConnection
    //Parameters : function parameters
    //Creator :  19/10/2019 Witsarut
    //Return : data
    //Return Type : Array
    public function FSaMCstDebitCardDataList($paData){

        try{
            $tCstCode       =  $paData['FTCrdRefCode'];
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];

            $tSQL           = " SELECT c.* FROM(SELECT  ROW_NUMBER() OVER(ORDER BY FTCrdRefCode ASC) AS rtRowID,*
                                FROM(
                                    SELECT 	
                                        CRDMAN.FTCrdCode,
                                        CRDMAN.FTCrdRefCode,
                                        CRDMAN.FTCrdTable,
                                        CTY_L.FTCtyName, 
                                        CRD.FCCrdValue,
                                        CRD.FDCrdExpireDate,
                                        CRD.FTCrdStaActive
                                    FROM [TFNMCardMan] CRDMAN WITH(NOLOCK)
                                    LEFT JOIN TFNMCard CRD  WITH(NOLOCK) ON CRDMAN.FTCrdCode = CRD.FTCrdCode
                                    LEFT JOIN TFNMCardType_L CTY_L WITH(NOLOCK) ON CRD.FTCtyCode = CTY_L.FTCtyCode
                                    WHERE 1=1
                                    AND CRDMAN.FTCrdRefCode    = '$tCstCode'
                            ";
                    $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
                    $oQuery  = $this->db->query($tSQL);
                    if($oQuery->num_rows() > 0){    
                        $aList      = $oQuery->result_array();
                        $oFoundRow  = $this->FSoMCstDebitCardGetPageAll($tSearchList,$paData);
                        $nFoundRow  = $oFoundRow[0]->counts;
                        $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                        $aResult    = array(
                            'raItems'       => $aList,
                            'rnAllRow'      => $nFoundRow,
                            'rnCurrentPage' => $paData['nPage'],
                            'rnAllPage'     => $nPageAll,
                            'rtCode'        => '1',
                            'rtDesc'        => 'success',
                            'tSQL'          => $tSQL
                        );
                    }else{
                        // if don't have data
                        $aResult = array(
                            'rnAllRow'      => 0,
                            'rnCurrentPage' => $paData['nPage'],
                            "rnAllPage"     => 0,
                            'rtCode'        => '800',
                            'rtDesc'        => 'data not found'
                        );
                    }
                    return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Count CompSettingConnection
    //Parameters : function parameters
    //Creator :  19/08/2019 Witsarut
    //Return : data
    //Return Type : Array
    public function FSoMCstDebitCardGetPageAll($ptSearchList,$paData){
        try{
            $tCstCode       =  $paData['FTCrdRefCode'];
            $tSQL           =  " SELECT 
                                    COUNT (CRDMAN.FTCrdRefCode) AS counts
                                FROM [TFNMCardMan] CRDMAN WITH(NOLOCK)
                                WHERE 1=1
                                AND CRDMAN.FTCrdRefCode    = '$tCstCode'
                        ";
                        if(isset($ptSearchList) && !empty($ptSearchList)){
                            $tSQL .= " AND (URLObj.FNUrlID LIKE '%$ptSearchList%')";
                        }
                        $oQuery = $this->db->query($tSQL);
                        if($oQuery->num_rows() > 0){
                            return $oQuery->result(); 
                        }else{
                            return false;
                        }
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Get Data FSaMCstDebitCardCheckID
    //Parameters : function parameters
    //Creator : 17/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCstDebitCardCheckID($paData){
        try{
            $tCstCode   =  $paData['FTCrdRefCode'];
            $tnLngID    = $paData['FNLngID'];

            $tSQL  = "SELECT 	
                        CRDMAN.FTCrdCode,
                        CRDMAN.FTCrdRefCode,
                        CRDMAN.FTCrdTable,
                        CTY_L.FTCtyName, 
                        CRD.FCCrdValue,
                        CRD.FDCrdExpireDate,
                        CRD.FTCrdStaActive
                    FROM [TFNMCardMan] CRDMAN WITH(NOLOCK)
                    LEFT JOIN TFNMCard CRD  WITH(NOLOCK) ON CRDMAN.FTCrdCode = CRD.FTCrdCode
                    LEFT JOIN TFNMCardType_L CTY_L WITH(NOLOCK) ON CRD.FTCtyCode = CTY_L.FTCtyCode
                    WHERE 1=1
                    AND CRDMAN.FTCrdRefCode    = '$tCstCode'";
                $oQuery = $this->db->query($tSQL);
                if($oQuery->num_rows() > 0){
                    $oDetail    = $oQuery->result();
                    $aResult = array(
                        'raItems'   => $oDetail,
                        'rtCode'    => '1',
                        'rtDesc'    => 'success',
                    );
                }else{
                    //if data not found
                    $aResult    = array(
                        'rtCode'    => '800',
                        'rtDesc'    => 'data not found',
                    );
                }
                $jResult = json_encode($aResult);
                $aResult = json_decode($jResult, true);
                return $aResult;
        }catch(exception $Error){
            echo $Error;
        }

    }

    //Functionality : Add Data
    //Parameters : function parameters
    //Creator : 17/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCSTAddUpdateMaster($paDataAdd){

        try{
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            }else{
                $aResult = array(
                    'FTCrdCode'    => $paDataAdd['FTCrdCode'],
                    'FTCrdRefCode' => $paDataAdd['FTCrdRefCode'],
                    'FTCrdTable'   => $paDataAdd['FTCrdTable'],
                );

                //Add Master
                $this->db->insert('TFNMCardMan', $aResult);

                //update Card Holderid
                $this->db->where('FTCrdCode', $paDataAdd['FTCrdCode']);
                $this->db->update('TFNMCard', array(
                    'FTCrdHolderID' => $paDataAdd['FTCrdRefCode'],
                ));


                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success',
                    );
                }else{
                    // Error
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            $Error;
        }

    }

    //Functionality : Delete CustomerDebitCard 
    //Parameters : function parameters
    //Creator : 19/09/2019 Witsarut (Bell)
    //Return : response
    //Return Type : array
    public function FSnMCstDebitCard($paData){

        try{
            $this->db->trans_begin();
            $this->db->where_in('FTCrdCode', $paData['FTCrdCode']);
            $this->db->where_in('FTCrdRefCode', $paData['FTCrdRefCode']);
            $this->db->delete('TFNMCardMan');


            $this->db->where_in('FTCrdCode', $paData['FTCrdCode']);
            $this->db->update('TFNMCard', array(
                'FTCrdHolderID' => $paDataAdd['FTCrdRefCode'],
            ));

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
            $Error;
        }
    }

    //Functionality : Get all row 
    //Parameters : -
    //Creator : 19/09/2019 Witsarut (Bell)
    //Return : array result from db
    //Return Type : array
   public function FSnMCstDebitCrdGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TFNMCardMan";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

    //Functionality : check Data CheckDupiate
    //Parameters : function parameters
    //Creator : 17/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCstCheckCrdCode($paData){
        $tRefCode    = $paData['FTCrdRefCode'];
        $tCrdCode    = $paData['FTCrdCode'];

        $tSQL  = "SELECT 	
                    CRDMAN.FTCrdCode
                FROM [TFNMCardMan] CRDMAN WITH(NOLOCK)
                WHERE 1=1
                AND CRDMAN.FTCrdRefCode = '$tRefCode'
                AND CRDMAN.FTCrdCode = '$tCrdCode'
                ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDetail    = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //if data not found
            $aResult    = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }
   
 }


