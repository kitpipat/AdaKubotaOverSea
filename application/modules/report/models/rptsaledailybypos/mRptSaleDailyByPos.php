
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptSaleDailyByPos extends CI_Model {

    // Functionality: Call Stored Procedure
    // Parameters:  Function Parameter
    // Creator: 19/12/2019 Witsarut(Bell)
    // Last Modified : -
    // Return : Status Return Call Stored Procedure
    // Return Type: Array
    public function FSnMExecStoreReport($paDataFilter){
        $nLangID        = $paDataFilter['nLangID'];
        $tComName       = $paDataFilter['tCompName'];
        $tRptCode       = $paDataFilter['tRptCode'];
        $tUserSession   = $paDataFilter['tUserSession'];
        $tFilterType    = $paDataFilter['nFilterType'];

        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // เครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);
        // /แคชเชีย
        $tCstCodeSelect = ($paDataFilter['bCashierStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tCashierCodeSelect']);

        $tCallStore = "{CALL SP_RPTxSalDailyByPosTmp(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'       => $nLangID,
            'pnComName'     => $tComName,
            'ptRptCode'     => $tRptCode,
            'ptUsrSession'  => $tUserSession,
            'pnFilterType'  => $tFilterType,

            //สาขา
            'ptBchL'     => $tBchCodeSelect,
            'ptBchF'     => $paDataFilter['tBchCodeFrom'],
            'ptBchT'     => $paDataFilter['tBchCodeTo'],
            
            //shop
            'ptShpL'     => $tShpCodeSelect,
            'ptShpF'     => $paDataFilter['tShpCodeFrom'],
            'ptShpT'     => $paDataFilter['tShpCodeTo'],
           
             //pos   
            'ptPosCodeL'  => $tPosCodeSelect,
            'ptPosCodeF'  => $paDataFilter['tRptPosCodeFrom'],
            'ptPosCodeT'  => $paDataFilter['tRptPosCodeTo'],

            //cashier
            'ptUsrL'    => $tCstCodeSelect,
            'ptUsrF'    => $paDataFilter['tCashierCodeFrom'],
            'ptUsrT'    => $paDataFilter['tCashierCodeTo'],

            //date
            'ptDocDateF'    => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'    => $paDataFilter['tDocDateTo'],
            'ptDocDateT'    => $paDataFilter['tDocDateTo'],

            // Year
            // 'ptYear'        => $paDataFilter['tRptYear'],
            
            'FNResult'      => 0
        );

        $oQuery = $this->db->query($tCallStore, $aDataStore);

        if ($oQuery !== FALSE) {
            unset($oQuery);
            return 1;
        } else {
            unset($oQuery);
            return 0;
        }
    }

    // Functionality: Get Data Report In Table Temp
    // Parameters:  Function Parameter
    // Creator: 23/12/2019 Witsarut (Bell)
    // Last Modified : -
    // Return : Array Data report
    // Return Type: Array
    public function FSaMGetDataReport($paDataWhere){

        $nPage      = $paDataWhere['nPage'];
        $nPerPage   = $paDataWhere['nPerPage'];

        // Call Data Pagination 
        $aPagination    = $this->FMaMRPTPagination($paDataWhere);
        
        $nRowIDStart    = $aPagination["nRowIDStart"];
        $nRowIDEnd      = $aPagination["nRowIDEnd"];
        $nTotalPage     = $aPagination["nTotalPage"];

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        if($nPage == $nTotalPage){
            $tRptJoinFooter = " SELECT
                                    FTUsrSession    AS FTUsrSession_Footer
                                FROM TRPTSalDailyByPosTmp WITH(NOLOCK)
                                WHERE 1=1
                                    AND FTComName       = '$tComName'
                                    AND FTRptCode		= '$tRptCode'
                                    AND FTUsrSession    = '$tUsrSession'
                                    GROUP BY FTTnsType , FTPosCode  
                ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
       
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
      
        $tSQL = "   
               SELECT
                   L.*
                                     
               FROM (
                   SELECT 
                        
                       ROW_NUMBER() OVER(ORDER BY FTPosCode ASC) AS RowID ,
                       ROW_NUMBER() OVER(PARTITION BY FTBchCode ORDER BY FTBchCode,FTPosCode,FTRcvCode ASC) AS RowBch2,
                       A.*
                   FROM TRPTSalDailyByPosTmp A WITH(NOLOCK)
                  
            
                 
                   WHERE A.FTComName = '$tComName'
                   AND A.FTRptCode = '$tRptCode'
                   AND A.FTUsrSession = '$tUsrSession'
            
                
               ) AS L
           "; 

        //    $tSQL .= " ORDER BY FTPosCode ,FTTnsType ASC   ";

        //    echo $tSQL;
        //    exit;
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0){
                $aData = $oQuery->result_array();
          
            }else{
                $aData = NULL;
            }
    
            $aErrorList = [
                "nErrInvalidPage" => ""
            ];
    
            $aResualt= [
                "aPagination" => $aPagination,
                "aRptData" => $aData,
                "aError" => $aErrorList
            ];
            unset($oQuery); 
            unset($aData);
            return $aResualt;
    }

    // Functionality: Get Data Page Co
    // Parameters:  Function Parameter
    // Creator: 23/12/2019 Witsarut(Bell)
    // Last Modified : -
    // Return : Array Data Page Nation
    // Return Type: Array
    public function FMaMRPTPagination($paDataWhere){

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            SELECT
                SPCTMP.FTRptCode
            FROM TRPTSalDailyByPosTmp SPCTMP WITH(NOLOCK)
            WHERE SPCTMP.FTComName  = '$tComName'
            AND SPCTMP.FTRptCode    = '$tRptCode'
            AND SPCTMP.FTUsrSession = '$tUsrSession'";

        $oQuery     = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->num_rows();
        $nPage = $paDataWhere['nPage'];
        $nPerPage = $paDataWhere['nPerPage'];
        $nPrevPage = $nPage-1;
        $nNextPage = $nPage+1;

        $nRowIDStart = (($nPerPage*$nPage)-$nPerPage); //RowId Start
        if($nRptAllRecord<=$nPerPage){
            $nTotalPage = 1;
        }else if(($nRptAllRecord % $nPerPage)==0){
            $nTotalPage = ($nRptAllRecord/$nPerPage) ;
        }else{
            $nTotalPage = ($nRptAllRecord/$nPerPage)+1;
            $nTotalPage = (int)$nTotalPage;
        }

        // get rowid end
        $nRowIDEnd = $nPerPage * $nPage;
        if($nRowIDEnd > $nRptAllRecord){
            $nRowIDEnd = $nRptAllRecord;
        }

        $aRptMemberDet = array(
            "nTotalRecord"  => $nRptAllRecord,
            "nTotalPage"    => $nTotalPage,
            "nDisplayPage"  => $paDataWhere['nPage'],
            "nRowIDStart"   => $nRowIDStart,
            "nRowIDEnd"     => $nRowIDEnd,
            "nPrevPage"     => $nPrevPage,
            "nNextPage"     => $nNextPage,
            "nPerPage"      => $nPerPage
        );
        unset($oQuery);
        return $aRptMemberDet;
    }


    // Functionality: Get Data Page Co
    // Parameters:  Function Parameter
    // Creator: 23/12/2019 Witsarut(Bell)
    // Last Modified : -
    // Return : Array Data Page Nation
    // Return Type: Array
    public function FMxMRPTSetPriorityGroup($paDataWhere){

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode']; 
        $tUsrSession    = $paDataWhere['tUsrSessionID'];
        
        $tSQL = "   
            UPDATE TRPTSalDailyByPosTmp
                SET TRPTSalDailyByPosTmp.FNRowPartID = B.PartID
                FROM (
                    SELECT
                        ROW_NUMBER() OVER(PARTITION BY TSPT.FTRcvCode ORDER BY TSPT.FTRcvCode ASC) AS PartID ,
                        TSPT.FTRptRowSeq
                    FROM TRPTSalDailyByPosTmp TSPT WITH(NOLOCK)
                    WHERE TSPT.FTComName = '$tComName'
                    AND TSPT.FTRptCode  = '$tRptCode'
                    AND TSPT.FTUsrSession = '$tUsrSession'";
              

            $tSQL  .= "
                ) AS B
                    WHERE 1=1
                    AND TRPTSalDailyByPosTmp.FTRptRowSeq = B.FTRptRowSeq
                    AND TRPTSalDailyByPosTmp.FTComName = '$tComName' 
                    AND TRPTSalDailyByPosTmp.FTRptCode = '$tRptCode'
                    AND TRPTSalDailyByPosTmp.FTUsrSession = '$tUsrSession' ";

                    // print_r($tSQL); die();

            $this->db->query($tSQL);
    }


    // Functionality: Count Data Report All
    // Parameters: Function Parameter
    // Creator: 11/04/2019 Saharat(Golf)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSnMCountRowInTemp($paDataWhere) {
       
        $tUserSession   = $paDataWhere['tUsrSessionID'];
        $tCompName      = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];

        $tSQL = "   SELECT 
                             COUNT(TTDT.FTRptCode) AS rnCountPage
                         FROM TRPTSalDailyByPosTmp AS TTDT WITH(NOLOCK)
                         WHERE 1 = 1
                         AND FTUsrSession    = '$tUserSession'
                         AND FTComName       = '$tCompName'
                         AND FTRptCode       = '$tRptCode'";

        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
        unset($oQuery);
        return $nRptAllRecord;
    }


    
    

   
}


