<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class mMovement extends CI_Model {

    //Functionality : list Data Movement
    //Parameters : function parameters
    //Creator :  10/03/2020 Saharat(Golf)
    //Last Modified : 15/04/2020 surawat
    //Return : data
    //Return Type : Array
    public function FSaMMovementList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tWhereBch      = "";
            $tWherePdt      = "";
            $tWhereWah      = "";
            $tWhereDate     = "";
            $SqlWhere       = "";

            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tBchCode       = $paData['tSearchAll']['tBchCode'];
            $tShpCode       = $paData['tSearchAll']['tShpCode'];
            $tWahCode       = $paData['tSearchAll']['tWahCode'];
            $tPdtCode       = $paData['tSearchAll']['tPdtCode'];
            $dDateStart     = $paData['tSearchAll']['dDateStart'];
            $dDateTo        = $paData['tSearchAll']['dDateTo'];

            if($tBchCode != ""){
                $tBchCodeText= str_replace(",","','",$tBchCode);
                $tWhereBch  = "AND STK.FTBchCode IN ('$tBchCodeText')";
            }
            // (String)
            if($tPdtCode != ""){
                // echo $tPdtCode;
                // $aPdtCode = explode(',',$tPdtCode);
                // $nCount = count($aPdtCode);
            
                // if(!empty($aPdtCode)){
                //     // print_r($aPdtCode);
                //     $nCheck = 1;
                //     $tWherePdt = " AND (";
                //         foreach($aPdtCode as $aData){
                //             $tWherePdt .= " STK.FTPdtCode = '$aData' ";
                //             if($nCheck!=$nCount){
                //                 $tWherePdt .= " OR ";
                //             }
                //             $nCheck++;
                //         }
                //     $tWherePdt .= " )";
                // }
                $tPdtCodeText= str_replace(",","','",$tPdtCode);
                $tWherePdt = "AND STK.FTPdtCode IN ('$tPdtCodeText')";
            }

            if($tWahCode != ""){
                $tWahCodeText= str_replace(",","','",$tWahCode);
                $tWhereWah = "AND  STK.FTWahCode IN ('$tWahCodeText')";
            }
            $tWhereStartDate='';
            $tWhereEndDate='';
            if($dDateStart != ""){
                $tWhereStartDate = " AND CONVERT(VARCHAR(10),STK.FDStkDate,121) >= '$dDateStart' ";
            }
            if($dDateTo != ""){
                $tWhereEndDate = " AND CONVERT(VARCHAR(10),STK.FDStkDate,121) <= '$dDateTo' ";
            }

            $SqlWhere =  $tWhereBch.' '.$tWherePdt.' '.$tWhereWah.' '.$tWhereStartDate." ".$tWhereEndDate;
            
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDStkDate ASC,FTBchCode,FTPdtCode,FTWahCode,FDStkDate ASC) AS rtRowID,* FROM
                                    (SELECT STK.FTBchCode, 
                                            STK.FTPdtCode, 
                                            PDT.FTPdtName,
                                            STK.FTStkDocNo,
                                            STK.FDStkDate,
                                            STK.FCStkQty,
                                            STK.FTWahCode,
                                            WAH.FTWahName,
                                            STK.FTStkType,
                                            
                                            CASE
                                                            WHEN STK.FTStkType = 0
                                                            THEN STK.FCStkQty
                                                            ELSE 0
                                                        END AS FCStkMonthEnd,
                                                        CASE
                                                            WHEN STK.FTStkType = 1
                                                            THEN STK.FCStkQty
                                                            ELSE 0
                                                        END AS FCStkIN,
                                                        CASE
                                                            WHEN STK.FTStkType = 2
                                                            THEN STK.FCStkQty
                                                            ELSE 0
                                                        END AS FCStkOUT,
                                                        CASE
                                                            WHEN STK.FTStkType = 3
                                                            THEN STK.FCStkQty
                                                            ELSE 0
                                                        END AS FCStkSale,
                                                        CASE
                                                            WHEN STK.FTStkType = 4
                                                            THEN STK.FCStkQty
                                                            ELSE 0
                                                        END AS FCStkReturn,
                                                        CASE
                                                            WHEN STK.FTStkType = 5
                                                            THEN STK.FCStkQty
                                                            ELSE 0
                                                        END AS FCStkAdjust,
                                            SUM(  CASE
                                                            WHEN STK.FTStkType = 0
                                                            THEN STK.FCStkQty * 1
                                                            WHEN STK.FTStkType = 1
                                                            THEN STK.FCStkQty * 1
                                                            WHEN STK.FTStkType = 2
                                                            THEN STK.FCStkQty * -1
                                                            WHEN STK.FTStkType = 3
                                                            THEN STK.FCStkQty * -1
                                                            WHEN STK.FTStkType = 4
                                                            THEN STK.FCStkQty
                                                            WHEN STK.FTStkType = 5
                                                            THEN STK.FCStkQty * 1
                                                            ELSE 0 END ) OVER(PARTITION BY STK.FTPdtCode,STK.FTWahCode ORDER BY STK.FTBchCode, 
                                                STK.FTPdtCode, 
                                                STK.FTWahCode,
                                                STK.FDStkDate) AS FCStkQtyInWah
                                        FROM TCNTPdtStkCrd STK
                                        LEFT JOIN TCNMPdt_L  PDT ON STK.FTPdtCode = PDT.FTPdtCode AND PDT.FNLngID = $nLngID
                                        LEFT JOIN TCNMWaHouse_L WAH ON STK.FTBchCode = WAH.FTBchCode AND STK.FTWahCode = WAH.FTWahCode AND WAH.FNLngID = $nLngID
                                        WHERE 1=1 ";
            $tSQL .=  $SqlWhere;
      
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

            $tSQL .= "              ORDER BY 
                                    c.FDStkDate ASC,
                                    c.FTBchCode, 
                                    c.FTPdtCode, 
                                    c.FTWahCode";
            // echo $tSQL;
            // die();
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMMerchantGetPageAll($SqlWhere,$nLngID);
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
    public function FSoMMerchantGetPageAll($SqlWhere,$ptLngID){
        try{
            $tSQL = "SELECT COUNT (STK.FTPdtCode) AS counts
                        FROM 
                        (
                        SELECT FTBchCode,FTStkDocNo,FTPdtCode,FTWahCode,FDStkDate
                    FROM TCNTPdtStkCrd ) STK
                    LEFT JOIN TCNMPdt_L PDTL ON STK.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = '$ptLngID'
                    LEFT JOIN TCNMWaHouse_L WAH ON STK.FTBchCode = WAH.FTBchCode AND STK.FTWahCode = WAH.FTWahCode AND WAH.FNLngID = '$ptLngID'
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

