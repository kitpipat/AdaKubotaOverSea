<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Inv_model extends CI_Model {
        //Functionality : list Data Movement
    //Parameters : function parameters
    //Creator :  10/03/2020 Saharat(Golf)
    //Last Modified : 15/04/2020 surawat
    //Return : data
    //Return Type : Array
    public function FSaMInvList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tWhereBch      = "";
            $tWherePdt      = "";
            $tWhereWah      = "";
            $SqlWhere       = "";

            $nLngID         = $paData['FNLngID'];
            $tBchCode       = $paData['tSearchAll']['tBchCode'];
            $tWahCode       = $paData['tSearchAll']['tWahCode'];
            $tPdtCode       = $paData['tSearchAll']['tPdtCode'];

            if($tBchCode != ""){
                $tBchCodeText= str_replace(",","','",$tBchCode);
                $tWhereBch  = "AND BAL.FTBchCode IN ('$tBchCodeText')";
            }else{
                $tStaUsrLevel    = $this->session->userdata("tSesUsrLevel");
                if($tStaUsrLevel == 'HQ'){
                    $SqlWhere   .= "";
                }else if($tStaUsrLevel == 'BCH'){
                    $tBCH    = $this->session->userdata("tSesUsrBchCom");
                    $SqlWhere   .= " AND BAL.FTBchCode = '$tBCH'";
                }
            }

            if($tPdtCode != ""){
                $tPdtCodeText= str_replace(",","','",$tPdtCode);
                $tWherePdt = "AND PDT.FTPdtCode IN ('$tPdtCodeText')";
            }

            if($tWahCode != ""){
                $tWahCodeText= str_replace(",","','",$tWahCode);
                $tWhereWah = "AND  BAL.FTWahCode IN ('$tWahCodeText')";
            }

            $SqlWhere =  $tWhereBch.' '.$tWherePdt.' '.$tWhereWah;

            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC, FTPdtCode, FTBchCode, FTWahCode ASC) AS rtRowID,* FROM
                                    (
                                        SELECT
                                            PDT.FTPdtCode,
                                            PDT.FTPdtName, 
                                            BCH.FTBchCode,
                                            BCH.FTBchName,
                                            BAL.FTWahCode,
                                            WAH.FTWahName,
                                            BAL.FCStkQty,
                                            BAL.FDCreateOn,
                                            ISNULL(ITA.FCXtdQtyAll,0) AS FCXtdQtyInt,
                                            ISNULL(BAL.FCStkQty,0) + ISNULL(ITA.FCXtdQtyAll,0) AS FCXtdQtyBal
                                        FROM TCNTPdtStkBal BAL
                                            LEFT JOIN TCNMPdt_L PDT ON BAL.FTPdtCode = PDT.FTPdtCode AND PDT.FNLngID = $nLngID 
                                            LEFT JOIN TCNMBranch_L BCH ON BAL.FTBchCode = BCH.FTBchCode AND PDT.FNLngID = $nLngID 
                                            LEFT JOIN TCNMWaHouse_L WAH ON BAL.FTBchCode = WAH.FTBchCode AND BAL.FTWahCode = WAH.FTWahCode AND WAH.FNLngID = $nLngID 
                                            LEFT JOIN
                                                (
                                                    SELECT FTBchCode, 
                                                        FTXthWahTo, 
                                                        FTPdtCode, 
                                                        SUM(INT.FCXtdQtyAll) AS FCXtdQtyAll
                                                    FROM
                                                    (
                                                        SELECT FTBchCode, 
                                                            FTXthWahTo, 
                                                            FTPdtCode, 
                                                            FCXtdQtyAll
                                                        FROM TCNTPdtIntDT
                                                        WHERE ISNULL(FTXtdRvtRef, '') = '' 
                                                        --AND
                                                        UNION ALL
                                                        SELECT FTXthBchTo AS FTBchCode, 
                                                            FTXthWahTo, 
                                                            FTPdtCode, 
                                                            FCXtdQtyAll
                                                        FROM TCNTPdtIntDTBCH
                                                        WHERE ISNULL(FTXtdRvtRef, '') = '' 
                                                    --AND
                                                    ) INT
                                                    GROUP BY FTBchCode, FTXthWahTo, FTPdtCode
                                                ) ITA ON BAL.FTBchCode = ITA.FTBchCode AND BAL.FTWahCode = ITA.FTXthWahTo AND BAL.FTPdtCode = ITA.FTPdtCode
                                        --ORDER BY BAL.FTPdtCode,BAL.FTBchCode,BAL.FTWahCode ASC
                                        WHERE 1=1 
                                    ";
            $tSQL .=  $SqlWhere;
      
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";


            $tSQL .= " ORDER BY FDCreateOn DESC, FTPdtCode, FTBchCode, FTWahCode ASC";
            // print_r("<pre>");
            // print_r($tSQL);
            // print_r("</pre>");
            // die();

            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMInvGetPageAll($SqlWhere,$nLngID);
                $nFoundRow = $oFoundRow[0]->counts;
                $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult = array(
                    'raItems'       => $aList,
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
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

        //Functionality : All Page Of Movement
    //Parameters : function parameters
    //Creator :  11/03/2020 Saharat(Golf)
    //Last Modified : 15/04/2020 surawat
    //Return : object Count All Movement
    //Return Type : Object
    public function FSoMInvGetPageAll($SqlWhere,$ptLngID){
        try{
            $tSQL = "SELECT COUNT (*) AS counts
                        FROM TCNTPdtStkBal BAL
                        LEFT JOIN TCNMPdt_L PDT ON BAL.FTPdtCode = PDT.FTPdtCode AND PDT.FNLngID = $ptLngID
                        LEFT JOIN TCNMBranch_L BCH ON BAL.FTBchCode = BCH.FTBchCode AND PDT.FNLngID = $ptLngID
                        LEFT JOIN TCNMWaHouse_L WAH ON BAL.FTBchCode = WAH.FTBchCode AND BAL.FTWahCode = WAH.FTWahCode AND WAH.FNLngID = $ptLngID
                        LEFT JOIN
                            (
                                SELECT FTBchCode, 
                                    FTXthWahTo, 
                                    FTPdtCode, 
                                    SUM(INT.FCXtdQtyAll) AS FCXtdQtyAll
                                FROM
                                (
                                    SELECT FTBchCode, 
                                        FTXthWahTo, 
                                        FTPdtCode, 
                                        FCXtdQtyAll
                                    FROM TCNTPdtIntDT
                                    WHERE ISNULL(FTXtdRvtRef, '') = '' 
                                    --AND
                                    UNION ALL
                                    SELECT FTXthBchTo AS FTBchCode, 
                                        FTXthWahTo, 
                                        FTPdtCode, 
                                        FCXtdQtyAll
                                    FROM TCNTPdtIntDTBCH
                                    WHERE ISNULL(FTXtdRvtRef, '') = '' 
                                --AND
                                ) INT
                                GROUP BY FTBchCode, FTXthWahTo, FTPdtCode
                            ) ITA ON BAL.FTBchCode = ITA.FTBchCode AND BAL.FTWahCode = ITA.FTXthWahTo AND BAL.FTPdtCode = ITA.FTPdtCode
                                
                    WHERE 1=1 $SqlWhere ";
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
}