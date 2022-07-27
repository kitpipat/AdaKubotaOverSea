<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCardlogin extends CI_Model {

    //Functionality : LIist Userlogin
    //Parameters : function parameters
    //Creator :  25/11/2019 Witsarut
    //Return : data
    //Return Type : Array
    public function FSaMCRDLDataList($paData){
     
        try{

            $tCrdCode       = $paData['FTCrdCode'];
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tFNLngID       = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL           = " SELECT c.* FROM(SELECT  ROW_NUMBER() OVER(ORDER BY FTCrdCode ASC) AS rtRowID,*
                                FROM(
                                    SELECT 	
                                        CRDLOGIN.FTCrdCode,
                                        CRDLOGIN.FTCrdLogType,
                                        CONVERT(DATETIME,CRDLOGIN.FDCrdPwdStart, 121)    AS FDCrdPwdStart,
                                        CONVERT(DATETIME,CRDLOGIN.FDCrdPwdExpired, 121)  AS FDCrdPwdExpired,
                                        CRDLOGIN.FTCrdLogin,
                                        CRDLOGIN.FTCrdLoginPwd,
                                        CRDLOGIN.FTCrdRmk,
                                        CRDLOGIN.FTCrdStaActive
                                    FROM [TCNMCrdLogin] CRDLOGIN WITH(NOLOCK)
                                    WHERE 1=1
                                    AND CRDLOGIN.FTCrdCode    = '$tCrdCode'
            ";
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
           
            $oQuery = $this->db->query($tSQL);

            if($oQuery->num_rows() > 0){
                $aList      = $oQuery->result_array();
               
                $oFoundRow  = $this->FSoMCRDLGetPageAll($tSearchList,$paData);
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
                //No Data
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

    //Functionality : Count Userlogin
    //Parameters : function parameters
    //Creator :  19/08/2019 Witsarut
    //Return : data
    //Return Type : Array
    public function FSoMCRDLGetPageAll($ptSearchList,$paData){
        try{
            $tCrdCode       = $paData['FTCrdCode'];
            $tSQL       = " SELECT
                                COUNT (CRDLOGIN.FTCrdCode) AS counts
                            FROM [TCNMCrdLogin] CRDLOGIN WITH(NOLOCK)
                            WHERE 1=1
                            AND CRDLOGIN.FTCrdCode    = '$tCrdCode'
            ";

            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (CRDLOGIN.FTCrdCode LIKE '%$ptSearchList%')";
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

    //Functionality : check Data Userlogin
    //Parameters : function parameters
    //Creator : 20/08/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCRDLCheckID($paData){
        
        $tCrdCode    = $paData['FTCrdCode'];
        $tCrdlogin   = $paData['FTCrdLogin'];
        $tnLngID     = $paData['FNLngID'];

        $tSQL = "SELECT 
                    CRDLOGIN.FTCrdCode,
                    CRDLOGIN.FTCrdLogType,
                    CRDLOGIN.FDCrdPwdStart,
                    CRDLOGIN.FDCrdPwdExpired,
                    CRDLOGIN.FTCrdLogin,
                    CRDLOGIN.FTCrdLoginPwd,
                    CRDLOGIN.FTCrdRmk,
                    CRDLOGIN.FTCrdStaActive
                FROM [TCNMCrdLogin] CRDLOGIN
                WHERE 1=1 AND CRDLOGIN.FTCrdLogin = '$tCrdlogin'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0){
            $oDetail    = $oQuery->result();
            $aResult= array(
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



    //Functionality : Checkduplicate Data 
    //Parameters : function parameters
    //Creator :  20/08/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data Count Duplicate
    //Return Type : object
    public function FSoMCRDLCheckDuplicate($ptCrdLogin){
        $tSQL   = "SELECT COUNT(FTCrdLogin)AS counts
                   FROM TCNMCrdLogin
                   WHERE FTCrdLogin = '$ptCrdLogin' ";
        $oQuery = $this->db->query($tSQL);
        $nResult = $oQuery->row_array()["counts"];
        if($nResult>0){
            return true;
        }else{
            return false;
        }
    }

    //Functionality : Function Add Update Master Userlogin
    //Parameters : function parameters
    //Creator : 20/08/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Update Master
    //Return Type : Array
    public function  FSaMCRDLAddUpdateMaster($paData){
  
        try{
            //Update Master
            $this->db->set('FDCrdPwdExpired'  , $paData['FDCrdPwdExpired']);
            $this->db->set('FTCrdLogin'       , $paData['FTCrdLogin']);
            $this->db->set('FTCrdLoginPwd'    , $paData['FTCrdLoginPwd']);
            $this->db->set('FTCrdRmk'         , $paData['FTCrdRmk']);
            $this->db->set('FTCrdStaActive'   , $paData['FTCrdStaActive']);
            $this->db->where('FTCrdCode'      , $paData['FTCrdCode']);
            $this->db->where('FTCrdLogType'   , $paData['FTCrdLogType']);
            $this->db->where('FDCrdPwdStart'  , $paData['FDCrdPwdStart']);
            $this->db->update('TCNMCrdLogin');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            }else{
                $aResult= array(
                    'FTCrdCode'          => $paData['FTCrdCode'],
                    'FTCrdLogType'       => $paData['FTCrdLogType'],
                    'FDCrdPwdStart'      => $paData['FDCrdPwdStart'],
                    'FDCrdPwdExpired'    => $paData['FDCrdPwdExpired'],
                    'FTCrdLogin'         => $paData['FTCrdLogin'],
                    'FTCrdLoginPwd'      => $paData['FTCrdLoginPwd'],
                    'FTCrdRmk'           => $paData['FTCrdRmk'],
                    'FTCrdStaActive'     => $paData['FTCrdStaActive'],
                );
                //Add Master
                $this->db->insert('TCNMCrdLogin', $aResult);
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
            return $Error;
        }
    }

    //Functionality : Delete Userlogin
    //Parameters : function parameters
    //Creator : 04/07/2019 Witsarut (Bell)
    //Return : response
    //Return Type : array
    public function FSnMCRDLDel($paData){
        $this->db->where_in('FTCrdLogin', $paData['FTCrdLogin']);
        $this->db->delete('TCNMCrdLogin');

        if($this->db->affected_rows() > 0){
            //Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            //Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }

        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }

    //Functionality : Delete Mutiple Object
    //Parameters : function parameters
    //Creator : 26/07/2019 Witsarut
    //Return : data
    //Return Type : Arra
    public function FSaMCRDLDeleteMultiple($paDataDelete){
        $this->db->where_in('FTCrdCode',$paDataDelete['aDataCrdCode']);
        $this->db->where_in('FTCrdLogType',$paDataDelete['aDataLogType']);
        $this->db->where_in('FDCrdPwdStart',$paDataDelete['aDataPwStart']);
        $this->db->delete('TCNMCrdLogin');

        if($this->db->affected_rows() > 0){
            //Success
            $aStatus   = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
              //Ploblem
              $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }

    //Functionality : Get all row 
    //Parameters : -
    //Creator : 04/07/2019 Witsarut (Bell)
    //Return : array result from db
    //Return Type : array
    public function FSnMLOCGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMCrdLogin";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }


    //Functionality : Function Add Update Master User
    //Parameters : function parameters
    //Creator : 03/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Update Master
    //Return Type : Array
    // public function FSaMUSRAddUpMaster($paDataMaster){
    //     try{

    //         //Update Master
    //         $this->db->set('FTUsrLoginType' , $paDataMaster['FTUsrLogType']);
    //         $this->db->set('FDUsrStart'   , $paDataMaster['FDUsrPwdStart']);
    //         $this->db->set('FDUsrFinish'  , $paDataMaster['FDUsrPwdExpired']);
    //         $this->db->where('FTUsrCode'  , $paDataMaster['FTUsrCode']);
    //         $this->db->update('TCNMUser');
    //         if($this->db->affected_rows() > 0){
    //             $aStatus = array(
    //                 'rtCode' => '1',
    //                 'rtDesc' => 'Update Success',
    //             );
    //         }else{
    //             //Add Master
    //             $this->db->insert('TCNMUser',array(
    //                 'FTUsrLoginType' => $paDataMaster['FTUsrCode'],
    //                 'FTUsrLogType'   => $paDataMaster['FTUsrLogType'],
    //                 'FDUsrStart'     => $paDataMaster['FDUsrPwdStart'],
    //                 'FDUsrFinish'    => $paDataMaster['FDUsrPwdExpired']

    //             ));
    //             if($this->db->affected_rows() > 0){
    //                 $aStatus = array(
    //                     'rtCode' => '1',
    //                     'rtDesc' => 'Add Success',
    //                 );
    //             }else{
    //                 //Error 
    //                 $aStatus = array(
    //                     'rtCode' => '905',
    //                     'rtDesc' => 'Error Cannot Add/Edit Master.',
    //                 );
    //             }
    //         }
    //         $jStatus = json_encode($aStatus);
    //         $aStatus = json_decode($jStatus, true);
    //         return $aStatus;
    //     }catch(Exception $Error){
    //         return $Error;
    //     }
    // }

 }


