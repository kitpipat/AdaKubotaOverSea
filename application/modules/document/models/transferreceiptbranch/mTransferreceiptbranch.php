<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mTransferreceiptbranch extends CI_Model {

    //Data List
    public function FSaMTBIList($paData){

        $aRowLen    = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $nDocType   = $paData['nTBIDocType'];
        $tSQL       = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC, FTXthDocNo DESC) AS FNRowID,* FROM
                            (SELECT DISTINCT
                                TBI.FTBchCode,
                                BCHL.FTBchName,
                                TBI.FTXthDocNo,
                                CONVERT(CHAR(10),TBI.FDXthDocDate,103)   AS FDXthDocDate,
                                TBI.FTXthStaDoc,
                                TBI.FTXthStaApv,
                                TBI.FTXthStaPrcStk,
                                TBI.FTCreateBy,
                                TBI.FDCreateOn,
                                USRL.FTUsrName AS FTCreateByName,
                                TBI.FTXthApvCode,
                                USRLAPV.FTUsrName AS FTXthApvName
                            FROM [TCNTPdtTbiHD] TBI WITH (NOLOCK)
                            LEFT JOIN TCNMBranch_L  BCHL WITH (NOLOCK) ON TBI.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID 
                            LEFT JOIN TCNMUser_L    USRL WITH (NOLOCK) ON TBI.FTCreateBy = USRL.FTUsrCode AND USRL.FNLngID = $nLngID 
                            LEFT JOIN TCNMUser_L    USRLAPV WITH (NOLOCK) ON TBI.FTXthApvCode = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID 
                            WHERE 1=1 AND TBI.FNXthDocType='$nDocType' ";


        // Check User Login Branch
        if($this->session->userdata('tSesUsrLevel')!='HQ'){
        $tUserLoginBchCode  = $this->session->userdata('tSesUsrBchCodeMulti');
        $tSQL   .=  "   AND TBI.FTBchCode IN($tUserLoginBchCode)";
        }

        $aAdvanceSearch = $paData['aAdvanceSearch'];
        @$tSearchList   = $aAdvanceSearch['tSearchAll'];
        if(@$tSearchList != ''){
            $tSQL .= " AND ((TBI.FTXthDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),TBI.FDXthDocDate,103) LIKE '%$tSearchList%'))";
        }

        /*จากสาขา - ถึงสาขา*/
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)){
            $tSQL .= " AND ((TBI.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (TBI.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        /*จากวันที่ - ถึงวันที่*/
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
        
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL .= " AND ((TBI.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (TBI.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        /*สถานะเอกสาร*/
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if(!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")){
            if($tSearchStaDoc == 2){
                $tSQL .= " AND TBI.FTXthStaDoc = '$tSearchStaDoc' OR TBI.FTXthStaDoc = ''";
            }else{
                $tSQL .= " AND TBI.FTXthStaDoc = '$tSearchStaDoc'";
            }
        }

        /*สถานะอนุมัติ*/
        $tSearchStaApprove = $aAdvanceSearch['tSearchStaApprove'];
        if(!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")){
            if($tSearchStaApprove == 2){
                $tSQL .= " AND TBI.FTXthStaApv = '$tSearchStaApprove' OR TBI.FTXthStaApv = '' ";
            }else{
                $tSQL .= " AND TBI.FTXthStaApv = '$tSearchStaApprove'";
            }
        }

        /*สถานะประมวลผล*/
        $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        if(!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")){
            
            if($tSearchStaPrcStk == 3){
                $tSQL .= " AND TBI.FTXthStaPrcStk = '$tSearchStaPrcStk' OR TBI.FTXthStaPrcStk = '' ";
            }else{
                $tSQL .= " AND TBI.FTXthStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
        // echo $tSQL;
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aFoundRow  = $this->FSnMTBIGetPageAll($paData);
            $nFoundRow  = $aFoundRow[0]->counts;
            $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult    = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Count Page
    public function FSnMTBIGetPageAll($paData){
        $nLngID     = $paData['FNLngID'];
        $nDocType   = $paData['nTBIDocType'];
        $tSQL   = " SELECT COUNT (TBI.FTXthDocNo) AS counts
                    FROM [TCNTPdtTbiHD] TBI WITH (NOLOCK)
                    WHERE 1=1 
                    AND TBI.FNXthDocType = '$nDocType'
                  ";

    // Check User Login Branch
      if($this->session->userdata('tSesUsrLevel')!='HQ'){
        $tUserLoginBchCode  = $this->session->userdata('tSesUsrBchCodeMulti');
        $tSQL   .=  "   AND TBI.FTBchCode IN($tUserLoginBchCode)";
        }

        $aAdvanceSearch = $paData['aAdvanceSearch'];
        @$tSearchList   = $aAdvanceSearch['tSearchAll'];
        if(@$tSearchList != ''){
            $tSQL .= " AND ((TBI.FTXthDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (TBI.FDXthDocDate LIKE '%$tSearchList%'))";
        }

        /*จากสาขา - ถึงสาขา*/
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)){
            $tSQL .= " AND ((TBI.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (TBI.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        /*จากวันที่ - ถึงวันที่*/
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL .= " AND ((TBI.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (TBI.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        /*สถานะเอกสาร*/
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if(!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")){
            $tSQL .= " AND TBI.FTXthStaDoc = '$tSearchStaDoc'";
        }

        /*สถานะอนุมัติ*/
        $tSearchStaApprove = $aAdvanceSearch['tSearchStaApprove'];
        if(!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")){
            if($tSearchStaApprove == 2){
                $tSQL .= " AND TBI.FTXthStaApv = '$tSearchStaApprove' OR TBI.FTXthStaApv = '' ";
            }else{
                $tSQL .= " AND TBI.FTXthStaApv = '$tSearchStaApprove'";
            }
        }

        /*สถานะประมวลผล*/
        $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        if(!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")){
            if($tSearchStaPrcStk == 3){
                $tSQL .= " AND TBI.FTXthStaPrcStk = '$tSearchStaPrcStk' OR TBI.FTXthStaPrcStk = '' ";
            }else{
                $tSQL .= " AND TBI.FTXthStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }

    //Clear Tmp
    public function FSxMTBIClearPdtInTmp($ptTblSelectData){
        $tXthDocKey     = $ptTblSelectData;
        $tSessionID     = $this->session->userdata('tSesSessionID');
        $this->db->where_in('FTXthDocKey',$tXthDocKey);
        $this->db->where_in('FTSessionID',$tSessionID);
        $this->db->delete('TCNTDocDTTmp');
    }

    //Get Shop Code From User Login
    public function FSaMTBIGetShpCodeForUsrLogin($paDataShp){
        $nLngID     = $paDataShp['FNLngID'];
        $tUsrLogin  = $paDataShp['tUsrLogin'];
        $tSQL       = " SELECT
                            UGP.FTBchCode,
                            BCHL.FTBchName,
                            MCHL.FTMerCode,
                            MCHL.FTMerName,
                            UGP.FTShpCode,
                            SHPL.FTShpName,
                            SHP.FTShpType,
                            SHP.FTWahCode   AS FTWahCode,
                            WAHL.FTWahName  AS FTWahName
                        FROM TCNTUsrGroup UGP           WITH (NOLOCK)
                        LEFT JOIN TCNMBranch BCH        WITH (NOLOCK) ON UGP.FTBchCode = BCH.FTBchCode 
                        LEFT JOIN TCNMBranch_L BCHL     WITH (NOLOCK) ON UGP.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                        LEFT JOIN TCNMShop SHP          WITH (NOLOCK) ON UGP.FTShpCode = SHP.FTShpCode
                        LEFT JOIN TCNMShop_L  SHPL      WITH (NOLOCK) ON SHP.FTShpCode = SHPL.FTShpCode AND SHP.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
                        LEFT JOIN TCNMMerchant_L MCHL   WITH (NOLOCK) ON SHP.FTMerCode = MCHL.FTMerCode AND MCHL.FNLngID = $nLngID
                        LEFT JOIN TCNMWaHouse_L WAHL    WITH (NOLOCK) ON SHP.FTWahCode = WAHL.FTWahCode
                        WHERE FTUsrCode ='$tUsrLogin' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult    = $oQuery->row_array();
        }else{
            $aResult    = "";
        }
        unset($oQuery);
        return $aResult;
    }

    //Get Data In Doc DT Temp
    public function FSaMTBIGetDocDTTempListPage($paDataWhere){
        $tTBIDocNo           = $paDataWhere['FTXthDocNo'];
        $tTBIDocKey          = $paDataWhere['FTXthDocKey'];
        $tSearchPdtAdvTable  = $paDataWhere['tSearchPdtAdvTable'];
        $tTBISesSessionID    = $this->session->userdata('tSesSessionID');

        $aRowLen    = FCNaHCallLenData($paDataWhere['nRow'],$paDataWhere['nPage']);
        $tSQL       = " SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY FNXtdSeqNo ASC) AS rtRowID,* FROM (
                                SELECT
                                    DOCTMP.FTBchCode,
                                    DOCTMP.FTXthDocNo,
                                    DOCTMP.FNXtdSeqNo,
                                    DOCTMP.FTXthDocKey,
                                    DOCTMP.FTPdtCode,
                                    DOCTMP.FTXtdPdtName,
                                    DOCTMP.FTPunName,
                                    DOCTMP.FTXtdBarCode,
                                    DOCTMP.FTPunCode,
                                    DOCTMP.FCXtdFactor,
                                    DOCTMP.FCXtdQty,
                                    DOCTMP.FCXtdSetPrice,
                                    DOCTMP.FCXtdAmtB4DisChg,
                                    DOCTMP.FTXtdDisChgTxt,
                                    DOCTMP.FCXtdNet,
                                    DOCTMP.FCXtdNetAfHD,
                                    DOCTMP.FTXtdStaAlwDis,
                                    DOCTMP.FDLastUpdOn,
                                    DOCTMP.FDCreateOn,
                                    DOCTMP.FTLastUpdBy,
                                    DOCTMP.FTCreateBy,
                                    DOCTMP.FCXtdAmt
                                FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                                WHERE 1 = 1
                                AND DOCTMP.FTXthDocNo  = '$tTBIDocNo'
                                AND DOCTMP.FTXthDocKey = '$tTBIDocKey'
                                AND DOCTMP.FTSessionID = '$tTBISesSessionID'
                                AND DOCTMP.FTCabNameForTWXVD IS NULL ";
                                
        if(isset($tSearchPdtAdvTable) && !empty($tSearchPdtAdvTable)){
            $tSQL   .=  "   AND (
                                DOCTMP.FTPdtCode COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                                OR DOCTMP.FTXtdPdtName COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                                OR DOCTMP.FTXtdBarCode COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                                OR DOCTMP.FTPunName COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%' )
                        ";
        }
        $tSQL   .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0){
            $aDataList  = $oQuery->result_array();
            $aFoundRow  = $this->FSaMTBIGetDocDTTempListPageAll($paDataWhere);
            $nFoundRow  = ($aFoundRow['rtCode'] == '1')? $aFoundRow['rtCountData'] : 0;
            $nPageAll   = ceil($nFoundRow/$paDataWhere['nRow']);
            $aDataReturn    = array(
                'raItems'       => $aDataList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataWhere['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        unset($aDataList);
        unset($aFoundRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aDataReturn;
    }   

    //Count All Documeny DT Temp
    public function FSaMTBIGetDocDTTempListPageAll($paDataWhere){
        $tTBIDocNo           = $paDataWhere['FTXthDocNo'];
        $tTBIDocKey          = $paDataWhere['FTXthDocKey'];
        $tSearchPdtAdvTable = $paDataWhere['tSearchPdtAdvTable'];
        $tTBISesSessionID    = $this->session->userdata('tSesSessionID');

        $tSQL   = " SELECT COUNT (DOCTMP.FTXthDocNo) AS counts
                    FROM TCNTDocDTTmp DOCTMP
                    WHERE 1 = 1 ";
        
        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tTBIDocNo' ";
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tTBIDocKey' ";
        $tSQL   .= " AND DOCTMP.FTSessionID = '$tTBISesSessionID' ";
        $tSQL   .= " AND DOCTMP.FTCabNameForTWXVD IS NULL ";

        if(isset($tSearchPdtAdvTable) && !empty($tSearchPdtAdvTable)){
            $tSQL   .= " AND ( DOCTMP.FTPdtCode LIKE '%$tSearchPdtAdvTable%' ";
            $tSQL   .= " OR DOCTMP.FTXtdPdtName LIKE '%$tSearchPdtAdvTable%' ";
            $tSQL   .= " OR DOCTMP.FTPunName    LIKE '%$tSearchPdtAdvTable%' ";
            $tSQL   .= " OR DOCTMP.FTXtdBarCode LIKE '%$tSearchPdtAdvTable%' )";
        }
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail        = $oQuery->row_array();
            $aDataReturn    =  array(
                'rtCountData'   => $aDetail['counts'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    =  array(
                'rtCode'    => '800',
                'rtDesc'    => 'Data Not Found',
            );
        }
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }

    //Sum Amount DT Temp
    public function FSaMTBISumDocDTTemp($paDataWhere){
        $tTBIDocNo           = $paDataWhere['FTXthDocNo'];
        $tTBIDocKey          = $paDataWhere['FTXthDocKey'];
        $tTBISesSessionID    = $this->session->userdata('tSesSessionID');
        $tSQL               = " SELECT
                                    SUM(FCXtdNetAfHD)       AS FCXtdSumNetAfHD,
                                    SUM(FCXtdAmtB4DisChg)   AS FCXtdSumAmtB4DisChg
                                FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                                WHERE 1 = 1 ";
        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tTBIDocNo' ";
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tTBIDocKey' ";
        $tSQL   .= " AND DOCTMP.FTSessionID = '$tTBISesSessionID' ";
        $tSQL   .= " AND DOCTMP.FTCabNameForTWXVD IS NULL ";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult    = $oQuery->row_array();
            $aDataReturn    =  array(
                'raDataSum' => $aResult,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            $aDataReturn    =  array(
                'rtCode'    => '800',
                'rtDesc'    => 'Data Sum Empty',
            );
        }
        unset($oQuery);
        unset($aResult);
        return $aDataReturn;
    }

    //หาราคา Price จากสินค้า
    public function FSaMTBIGetPriceBYPDT($ptCode){
        $tSQL           = "SELECT TOP 1 FTCmpWhsInOrEx FROM TCNMComp";
        $oQuery         = $this->db->query($tSQL);
        $oList          = $oQuery->result_array();
        $nVat           = $oList[0]['FTCmpWhsInOrEx'];

        $FNLngID        = $this->session->userdata("tLangEdit");
        $FTPdtCode      = $ptCode;
        $tVatInorEx     = $nVat;

        $tSQL =  "SELECT P.*,PUNL.FTPunName,";
                if( $tVatInorEx == 1){
        $tSQL .= " ISNULL(CAVG.FCPdtCostEx    * ISNULL(P.FCPdtUnitFact,1),NULL)	as PDTCostAvgInorEX ,";
                }else if( $tVatInorEx == 2){
        $tSQL .= " ISNULL(CAVG.FCPdtCostIn    * ISNULL(P.FCPdtUnitFact,1),NULL)	as PDTCostAvgInorEX ,";
                }
        $tSQL .= " ISNULL(PSPL.FCSplLastPrice * ISNULL(P.FCPdtUnitFact,1),NULL) as PDTCostLastPrice,
                ISNULL(PCFF.FCPdtCostEx       *	ISNULL(P.FCPdtUnitFact,1),NULL)	as PDTCostFiFo			
                FROM(
                SELECT 
                        PDT.FTPdtCode,	
                        PBCH.FTShpCode,
                        PDT_L.FTPdtName,
                        PBCH.FTBchCode,			
                        BAR.FTBarCode,
                        BAR.FTPunCode,
                        PPS.FCPdtUnitFact,
                        PDT.FCPdtCostStd *  ISNULL(PPS.FCPdtUnitFact,1)	as PDTCostSTD,
                        PDTIMG.FTImgObj,
                        LOGSEQ.FTPlcCode
                            
                FROM TCNMPdt PDT
                LEFT JOIN TCNMPdtSpcBch PBCH  ON PDT.FTPdtCode = PBCH.FTPdtCode  
                LEFT JOIN TCNMPdtBar BAR ON BAR.FTPdtCode = PDT.FTPdtCode
                LEFT JOIN  TCNTPdtLocSeq  LOGSEQ  ON BAR.FTBarCode   = LOGSEQ.FTBarCode
                LEFT JOIN TCNMPdt_L PDT_L ON PDT.FTPdtCode = PDT_L.FTPdtCode AND PDT_L.FNLngID = '$FNLngID'
                INNER JOIN TCNMPdtPackSize PPS ON PDT.FTPdtCode = PPS.FTPdtCode AND BAR.FTPunCode = PPS.FTPunCode 
                LEFT JOIN TCNMImgPdt PDTIMG ON PDT.FTPdtCode = PDTIMG.FTImgRefID AND PDTIMG.FTImgTable = 'TCNMPdt' AND PDTIMG.FTImgKey = 'master' AND PDTIMG.FNImgSeq = '1'
                WHERE PDT.FTPdtCode = '$FTPdtCode'
                ) P
                LEFT JOIN TCNMPdtUnit_L PUNL ON P.FTPunCode = PUNL.FTPunCode  AND PUNL.FNLngID = '$FNLngID'
                LEFT JOIN  TCNMPdtCostAvg CAVG	ON CAVG.FTPdtCode = P.FTPdtCode
                LEFT JOIN  TCNMPdtSpl PSPL	ON PSPL.FTPdtCode = P.FTPdtCode AND PSPL.FTBarCode = P.FTBarCode
                LEFT JOIN  TCNMPdtCostFiFo PCFF	ON PCFF.FTPdtCode = P.FTPdtCode";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //หา Max Seq From Doc DT Temp
    public function FSaMTBIGetMaxSeqDocDTTemp($paDataWhere){
        $tSOBchCode         = $paDataWhere['FTBchCode'];
        $tSODocNo           = $paDataWhere['FTXthDocNo'];
        $tSODocKey          = $paDataWhere['FTXthDocKey'];
        $tSOSesSessionID    = $this->session->userdata('tSesSessionID');
        $tSQL   =   "   SELECT 
                            MAX(DOCTMP.FNXtdSeqNo) AS rnMaxSeqNo
                        FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                        WHERE 1 = 1 ";
        $tSQL   .= " AND DOCTMP.FTBchCode   = '$tSOBchCode'";
        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tSODocNo'";
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tSODocKey'";
        $tSQL   .= " AND DOCTMP.FTSessionID = '$tSOSesSessionID'";
        $tSQL   .= " AND DOCTMP.FTCabNameForTWXVD IS NULL ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail    = $oQuery->row_array();
            $nResult    = $aDetail['rnMaxSeqNo'];
        }else{
            $nResult    = 0;
        }
        return empty($nResult)? 0 : $nResult;
    }

    //หาข้อมูล PDT
    public function FSaMTBIGetDataPdt($paDataPdtParams){
        $tPdtCode   = $paDataPdtParams['tPdtCode'];
        $FTPunCode  = $paDataPdtParams['tPunCode'];
        $FTBarCode  = $paDataPdtParams['tBarCode'];
        $nLngID     = $paDataPdtParams['nLngID'];
        $tSQL       = " SELECT
                            PDT.FTPdtCode,
                            PDT.FTPdtStkControl,
                            PDT.FTPdtGrpControl,
                            PDT.FTPdtForSystem,
                            PDT.FCPdtQtyOrdBuy,
                            PDT.FCPdtCostDef,
                            PDT.FCPdtCostOth,
                            PDT.FCPdtCostStd,
                            PDT.FCPdtMin,
                            PDT.FCPdtMax,
                            PDT.FTPdtPoint,
                            PDT.FCPdtPointTime,
                            PDT.FTPdtType,
                            PDT.FTPdtSaleType,
                            ISNULL(PRI4PDT.FCPgdPriceRet,0) AS FTPdtSalePrice,
                            PDT.FTPdtSetOrSN,
                            PDT.FTPdtStaSetPri,
                            PDT.FTPdtStaSetShwDT,
                            PDT.FTPdtStaAlwDis,
                            PDT.FTPdtStaAlwReturn,
                            PDT.FTPdtStaVatBuy,
                            PDT.FTPdtStaVat,
                            PDT.FTPdtStaActive,
                            PDT.FTPdtStaAlwReCalOpt,
                            PDT.FTPdtStaCsm,
                            PDT.FTTcgCode,
                            PDT.FTPtyCode,
                            PDT.FTPbnCode,
                            PDT.FTPmoCode,
                            PDT.FTVatCode,
                            PDT.FDPdtSaleStart,
                            PDT.FDPdtSaleStop,
                            PDTL.FTPdtName,
                            PDTL.FTPdtNameOth,
                            PDTL.FTPdtNameABB,
                            PDTL.FTPdtRmk,
                            PKS.FTPunCode,
                            PKS.FCPdtUnitFact,
                            VAT.FCVatRate,
                            UNTL.FTPunName,
                            BAR.FTBarCode,
                            BAR.FTPlcCode,
                            PDTLOCL.FTPlcName,
                            PDTSRL.FTSrnCode,
                            PDT.FCPdtCostStd,
                            CAVG.FCPdtCostEx,
                            CAVG.FCPdtCostIn,
                            SPL.FCSplLastPrice
                        FROM TCNMPdt PDT WITH (NOLOCK)
                        LEFT JOIN TCNMPdt_L PDTL        WITH (NOLOCK)   ON PDT.FTPdtCode      = PDTL.FTPdtCode    AND PDTL.FNLngID    = $nLngID
                        LEFT JOIN TCNMPdtPackSize  PKS  WITH (NOLOCK)   ON PDT.FTPdtCode      = PKS.FTPdtCode     AND PKS.FTPunCode   = '$FTPunCode'
                        LEFT JOIN TCNMPdtUnit_L UNTL    WITH (NOLOCK)   ON UNTL.FTPunCode     = '$FTPunCode'      AND UNTL.FNLngID    = $nLngID
                        LEFT JOIN TCNMPdtBar BAR        WITH (NOLOCK)   ON PKS.FTPdtCode      = BAR.FTPdtCode     AND BAR.FTPunCode   = '$FTPunCode'
                        LEFT JOIN TCNMPdtLoc_L PDTLOCL  WITH (NOLOCK)   ON PDTLOCL.FTPlcCode  = BAR.FTPlcCode     AND PDTLOCL.FNLngID = $nLngID
                        LEFT JOIN (
                            SELECT DISTINCT
                                FTVatCode,
                                FCVatRate,
                                FDVatStart
                            FROM TCNMVatRate WITH (NOLOCK)
                            WHERE CONVERT(VARCHAR(19),GETDATE(),121) > FDVatStart ) VAT
                        ON PDT.FTVatCode = VAT.FTVatCode
                        LEFT JOIN TCNTPdtSerial PDTSRL  WITH (NOLOCK)   ON PDT.FTPdtCode    = PDTSRL.FTPdtCode
                        LEFT JOIN TCNMPdtSpl SPL        WITH (NOLOCK)   ON PDT.FTPdtCode    = SPL.FTPdtCode AND BAR.FTBarCode = SPL.FTBarCode
                        LEFT JOIN TCNMPdtCostAvg CAVG   WITH (NOLOCK)   ON PDT.FTPdtCode    = CAVG.FTPdtCode
                        LEFT JOIN (
                            SELECT DISTINCT
                                P4PDT.FTPdtCode,
                                P4PDT.FTPunCode,
                                P4PDT.FDPghDStart,
                                P4PDT.FTPghTStart,
                                P4PDT.FCPgdPriceRet
                            FROM TCNTPdtPrice4PDT P4PDT WITH (NOLOCK)
                            WHERE 1=1
                            AND (CONVERT(VARCHAR(10),GETDATE(),121) >= CONVERT(VARCHAR(10),P4PDT.FDPghDStart,121))
                            AND (CONVERT(VARCHAR(10),GETDATE(),121) <= CONVERT(VARCHAR(10),P4PDT.FDPghDStop,121))
                        ) AS PRI4PDT
                        ON PDT.FTPdtCode = PRI4PDT.FTPdtCode AND PRI4PDT.FTPunCode = PKS.FTPunCode
                        WHERE 1 = 1 ";
    
        if(isset($tPdtCode) && !empty($tPdtCode)){
            $tSQL   .= " AND PDT.FTPdtCode   = '$tPdtCode'";
        }

        if(isset($FTBarCode) && !empty($FTBarCode)){
            $tSQL   .= " AND BAR.FTBarCode = '$FTBarCode'";
        }

        $tSQL   .= " ORDER BY FDVatStart DESC";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail    = $oQuery->row_array();
            $aResult    = array(
                'raItem'    => $aDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        unset($oQuery);
        unset($aDetail);
        return $aResult;
    }

    //เพิ่มสินค้าลง Tmp
    public function FSaMTBIInsertPDTToTemp($paDataPdtMaster,$paDataPdtParams){
        $paPIDataPdt    = $paDataPdtMaster['raItem'];

        // นำสินค้าเพิ่มจำนวนในแถวแรก
        $tSQL   =   "   SELECT
                            FNXtdSeqNo, 
                            FCXtdQty
                        FROM TCNTDocDTTmp
                        WHERE 1=1 
                        AND FTXthDocNo      = '".$paDataPdtParams['tDocNo']."'
                        AND FTBchCode       = '".$paDataPdtParams['tBchCode']."'
                        AND FTXthDocKey     = '".$paDataPdtParams['tDocKey']."'
                        AND FTSessionID     = '".$paDataPdtParams['tSessionID']."'
                        AND FTPdtCode       = '".$paPIDataPdt["FTPdtCode"]."'
                        AND FTXtdBarCode    = '".$paPIDataPdt["FTBarCode"]."'
                        ORDER BY FNXtdSeqNo";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            // เพิ่มจำนวนให้รายการที่มีอยู่แล้ว
            $aResult    = $oQuery->row_array();
            $tSQL       =   "   UPDATE TCNTDocDTTmp
                                SET FCXtdQty = '".($aResult["FCXtdQty"] + 1 )."' ,
                                FTCabNameForTWXVD = null
                                WHERE 1=1
                                AND FTBchCode       = '".$paDataPdtParams['tBchCode']."'
                                AND FTXthDocNo      = '".$paDataPdtParams['tDocNo']."'
                                AND FNXtdSeqNo      = '".$aResult["FNXtdSeqNo"]."'
                                AND FTXthDocKey     = '".$paDataPdtParams['tDocKey']."'
                                AND FTSessionID     = '".$paDataPdtParams['tSessionID']."'
                                AND FTPdtCode       = '".$paPIDataPdt["FTPdtCode"]."'
                                AND FTXtdBarCode    = '".$paPIDataPdt["FTBarCode"]."' ";
            $this->db->query($tSQL);
            $aStatus = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Add Success.',
            );
        }else{
            // เพิ่มรายการใหม่
            $aDataInsert    = array(
                'FTBchCode'         => $paDataPdtParams['tBchCode'],
                'FTXthDocNo'        => $paDataPdtParams['tDocNo'],
                'FNXtdSeqNo'        => $paDataPdtParams['nMaxSeqNo'],
                'FTXthDocKey'       => $paDataPdtParams['tDocKey'],
                'FTPdtCode'         => $paPIDataPdt['FTPdtCode'],
                'FTXtdPdtName'      => $paPIDataPdt['FTPdtName'],
                'FCXtdFactor'       => $paPIDataPdt['FCPdtUnitFact'],
                'FTPunCode'         => $paPIDataPdt['FTPunCode'],
                'FTPunName'         => $paPIDataPdt['FTPunName'],
                'FTXtdBarCode'      => $paDataPdtParams['tBarCode'],
                'FTXtdVatType'      => $paPIDataPdt['FTPdtStaVatBuy'],
                'FTVatCode'         => $paPIDataPdt['FTVatCode'],
                'FCXtdVatRate'      => $paPIDataPdt['FCVatRate'],
                'FTXtdStaAlwDis'    => $paPIDataPdt['FTPdtStaAlwDis'],
                'FTXtdSaleType'     => $paPIDataPdt['FTPdtSaleType'],
                'FCXtdSalePrice'    => $paPIDataPdt['FTPdtSalePrice'],
                'FCXtdQty'          => 1,
                'FCXtdQtyAll'       => 1*$paPIDataPdt['FCPdtUnitFact'],
                'FCXtdSetPrice'     => $paDataPdtParams['cPrice'] * 1,
                'FTXtdDocNoRef'     => $paDataPdtParams['tDocRefSO'],
                'FTSessionID'       => $paDataPdtParams['tSessionID'],
                'FDLastUpdOn'       => date('Y-m-d h:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d h:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername')
            );
            $this->db->insert('TCNTDocDTTmp',$aDataInsert);

            $this->db->last_query();  
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode'    => '1',
                    'rtDesc'    => 'Add Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode'    => '905',
                    'rtDesc'    => 'Error Cannot Add.',
                );
            }
        }   
        return $aStatus;
    }

    //ลบเอกสาร HD - ตัวเดียว
    public function FSnMTBIDelDocument($paDataDoc){
        $tTBIDocNo  = $paDataDoc['tTBIDocNo'];
        
        $this->db->trans_begin();

        //กลับไปอัพเดทสินค้าใน CN
        // $aPackData = array('FTXthDocNo' => $tTBIDocNo);
        // $this->FSvMTBICheckDocumentInCN('CANCEL',$aPackData);
        
        // Document HD 
        $this->db->where_in('FTXthDocNo',$tTBIDocNo);
        $this->db->delete('TCNTPdtTbiHD');

        // Document DT
        $this->db->where_in('FTXthDocNo',$tTBIDocNo);
        $this->db->delete('TCNTPdtTBIDT');

        // Document HD Ref
        $this->db->where_in('FTXthDocNo',$tTBIDocNo);
        $this->db->delete('TCNTPdtTbiHDRef');

        // Document Temp
        $this->db->where_in('FTXthDocNo',$tTBIDocNo);
        $this->db->where_in('FTXthDocKey','TCNTPdtTbiHD');
        $this->db->delete('TCNTDocDTTmp');
 
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $aStaDeleteDoc  = array(
                'rtCode'    => '905',
                'rtDesc'    => 'Cannot Delete Item.',
            );
        }else{
            $this->db->trans_commit();
            $aStaDeleteDoc  = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Delete Complete.',
            );
        }
        return $aStaDeleteDoc;
    }

    //ลบสินค้า DTTmp - ตัวเดียว
    public function FSnMTBIDelPdtInDTTmp($paDataWhere){
        // Delete Doc DT Temp
        // $this->db->where_in('FTSessionID',$paDataWhere['tSessionID']);
        // $this->db->where_in('FTPdtCode',$paDataWhere['tPdtCode']);
        // $this->db->where_in('FNXtdSeqNo',$paDataWhere['nSeqNo']);
        // $this->db->where_in('FTXthDocNo',$paDataWhere['tDocNo']);
        // $this->db->where_in('FTBchCode',$paDataWhere['tBchCode']);
        // $this->db->delete('TCNTDocDTTmp');

        $this->db->set('FTCabNameForTWXVD', 'DELETE_TEMP');
        $this->db->where_in('FTSessionID',$paDataWhere['tSessionID']);
        $this->db->where_in('FTPdtCode',$paDataWhere['tPdtCode']);
        $this->db->where_in('FNXtdSeqNo',$paDataWhere['nSeqNo']);
        $this->db->where_in('FTXthDocNo',$paDataWhere['tDocNo']);
        $this->db->where_in('FTBchCode',$paDataWhere['tBchCode']);
        $this->db->update('TCNTDocDTTmp');
        return ;
    }

    //ลบสินค้า DTTmp - หลายตัว
    public function FSnMTBIDelMultiPdtInDTTmp($paDataWhere){
        $tSessionID = $this->session->userdata('tSesSessionID');

        // Delete Doc DT Temp
        // $this->db->where_in('FTSessionID',$tSessionID);
        // $this->db->where_in('FNXtdSeqNo',$paDataWhere['aDataSeqNo']);
        // $this->db->where_in('FTPunCode',$paDataWhere['aDataPunCode']);
        // $this->db->where_in('FTPdtCode',$paDataWhere['aDataPdtCode']);
        // $this->db->where_in('FTXthDocNo',$paDataWhere['tDocNo']);
        // $this->db->where_in('FTBchCode',$paDataWhere['tBchCode']);
        // $this->db->delete('TCNTDocDTTmp');

        $this->db->set('FTCabNameForTWXVD', 'DELETE_TEMP');
        $this->db->where_in('FTSessionID',$tSessionID);
        $this->db->where_in('FTPunCode',$paDataWhere['aDataPunCode']);
        $this->db->where_in('FTPdtCode',$paDataWhere['aDataPdtCode']);
        $this->db->where_in('FNXtdSeqNo',$paDataWhere['aDataSeqNo']);
        $this->db->where_in('FTXthDocNo',$paDataWhere['tDocNo']);
        $this->db->where_in('FTBchCode',$paDataWhere['tBchCode']);
        $this->db->update('TCNTDocDTTmp');
        return ;
    }

    //คำนวณค่า
    public function FSaMTBICalInDTTemp($paParams){
        $tDocNo     = $paParams['tDocNo'];
        $tDocKey    = $paParams['tDocKey'];
        $tBchCode   = $paParams['tBchCode'];
        $tSessionID = $paParams['tSessionID'];
        $tSQL       = " SELECT
                            /* ยอดรวม ==============================================================*/
                            SUM(ISNULL(DTTMP.FCXtdNet, 0)) AS FCXphTotal,

                            /* ยอดรวมสินค้าไม่มีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0) ELSE 0 END) AS FCXphTotalNV,

                            /* ยอดรวมสินค้าห้ามลด ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdStaAlwDis = 2 THEN ISNULL(DTTMP.FCXtdNet, 0) ELSE 0 END) AS FCXphTotalNoDis,

                            /* ยอมรวมสินค้าลดได้ และมีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0) ELSE 0 END) AS FCXphTotalB4DisChgV,

                            /* ยอมรวมสินค้าลดได้ และไม่มีภาษี */
                            SUM(CASE WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0) ELSE 0 END) AS FCXphTotalB4DisChgNV,

                            /* ยอดรวมหลังลด และมีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0) ELSE 0 END) AS FCXphTotalAfDisChgV,

                            /* ยอดรวมหลังลด และไม่มีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0) ELSE 0 END) AS FCXphTotalAfDisChgNV,

                            /* ยอดรวมเฉพาะภาษี ==============================================================*/
                            (
                                (
                                    /* ยอดรวม */
                                    SUM(DTTMP.FCXtdNet)
                                    - 
                                    /* ยอดรวมสินค้าไม่มีภาษี */
                                    SUM(
                                        CASE
                                            WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                            ELSE 0
                                        END
                                    )
                                )
                                -
                                (
                                    /* ยอมรวมสินค้าลดได้ และมีภาษี */
                                    SUM(
                                        CASE
                                            WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                            ELSE 0
                                        END
                                    )
                                    -
                                    /* ยอมรวมสินค้าลดได้ และมีภาษี */
                                    SUM(
                                        CASE
                                            WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                            ELSE 0
                                        END
                                    )
                                )
                            ) AS FCXphAmtV,

                            /* ยอดรวมเฉพาะไม่มีภาษี ==============================================================*/
                            (
                                (
                                    /* ยอดรวมสินค้าไม่มีภาษี */
                                    SUM(
                                        CASE
                                            WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                            ELSE 0
                                        END
                                    )
                                )
                                -
                                (
                                    /* ยอมรวมสินค้าลดได้ และไม่มีภาษี */
                                    SUM(
                                        CASE
                                            WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                            ELSE 0
                                        END
                                    )
                                    -
                                    /* ยอดรวมหลังลด และไม่มีภาษี */
                                    SUM(
                                        CASE
                                            WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0)
                                            ELSE 0
                                        END
                                    )
                                )
                            ) AS FCXphAmtNV,

                            /* ยอดภาษี ==============================================================*/
                            SUM(ISNULL(DTTMP.FCXtdVat, 0)) AS FCXphVat,

                            /* ยอดแยกภาษี ==============================================================*/
                            (
                                (
                                    /* ยอดรวมเฉพาะภาษี */
                                    (
                                        (
                                            /* ยอดรวม */
                                            SUM(DTTMP.FCXtdNet)
                                            - 
                                            /* ยอดรวมสินค้าไม่มีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                                    ELSE 0
                                                END
                                            )
                                        )
                                        -
                                        (
                                            /* ยอมรวมสินค้าลดได้ และมีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                                    ELSE 0
                                                END
                                            )
                                            -
                                            /* ยอดรวมหลังลด และมีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0)
                                                    ELSE 0
                                                END
                                            )
                                        )
                                    )
                                    -
                                    /* ยอดภาษี */
                                    SUM(ISNULL(DTTMP.FCXtdVat, 0))	
                                )
                                +
                                (
                                    /* ยอดรวมเฉพาะไม่มีภาษี */
                                    (
                                        (
                                            /* ยอดรวมสินค้าไม่มีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                                    ELSE 0
                                                END
                                            )
                                        )
                                        -
                                        (
                                            /* ยอมรวมสินค้าลดได้ และไม่มีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                                    ELSE 0
                                                END
                                            )
                                            -
                                            /* ยอดรวมหลังลด และไม่มีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0)
                                                    ELSE 0
                                                END
                                            )
                                        )
                                    )
                                )
                            ) AS FCXphVatable,

                            /* รหัสอัตราภาษี ณ ที่จ่าย ==============================================================*/
                            STUFF((
                                SELECT  ',' + DOCCONCAT.FTXtdWhtCode
                                FROM TCNTDocDTTmp DOCCONCAT
                                WHERE  1=1 
                                AND DOCCONCAT.FTBchCode = '$tBchCode'
                                AND DOCCONCAT.FTXthDocNo = '$tDocNo'
                                AND DOCCONCAT.FTSessionID = '$tSessionID'
                            FOR XML PATH('')), 1, 1, '') AS FTXphWpCode,

                            /* ภาษีหัก ณ ที่จ่าย ==============================================================*/
                            SUM(ISNULL(DTTMP.FCXtdWhtAmt, 0)) AS FCXphWpTax

                        FROM TCNTDocDTTmp DTTMP
                        WHERE DTTMP.FTXthDocNo  = '$tDocNo' 
                        AND DTTMP.FTXthDocKey   = '$tDocKey' 
                        AND DTTMP.FTSessionID   = '$tSessionID'
                        AND DTTMP.FTBchCode     = '$tBchCode'
                        GROUP BY DTTMP.FTSessionID ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult    = $oQuery->result_array();
        }else{
            $aResult    = [];
        }
        return $aResult;
    }

    //Get Cal From HDDis Temp
    public function FSaMTBICalInHDDisTemp($paParams){
        $tDocNo     = $paParams['tDocNo'];
        $tDocKey    = $paParams['tDocKey'];
        $tBchCode   = $paParams['tBchCode'];
        $tSessionID = $paParams['tSessionID']; 
        $tSQL       = " SELECT
                            /* ข้อความมูลค่าลดชาร์จ ==============================================================*/
                            STUFF((
                                SELECT  ',' + DOCCONCAT.FTXtdDisChgTxt
                                FROM TCNTDocHDDisTmp DOCCONCAT
                                WHERE  1=1 
                                AND DOCCONCAT.FTBchCode 		= '$tBchCode'
                                AND DOCCONCAT.FTXthDocNo		= '$tDocNo'
                                AND DOCCONCAT.FTSessionID		= '$tSessionID'
                            FOR XML PATH('')), 1, 1, '') AS FTXphDisChgTxt,
                            /* มูลค่ารวมส่วนลด ==============================================================*/
                            SUM( 
                                CASE 
                                    WHEN HDDISTMP.FTXtdDisChgType = 1 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                    WHEN HDDISTMP.FTXtdDisChgType = 2 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                    ELSE 0 
                                END
                            ) AS FCXphDis,
                            /* มูลค่ารวมส่วนชาร์จ ==============================================================*/
                            SUM( 
                                CASE 
                                    WHEN HDDISTMP.FTXtdDisChgType = 3 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                    WHEN HDDISTMP.FTXtdDisChgType = 4 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                    ELSE 0 
                                END
                            ) AS FCXphChg
                        FROM TCNTDocHDDisTmp HDDISTMP
                        WHERE 1=1 
                        AND HDDISTMP.FTXthDocNo     = '$tDocNo' 
                        AND HDDISTMP.FTSessionID    = '$tSessionID'
                        AND HDDISTMP.FTBchCode      = '$tBchCode'
                        GROUP BY HDDISTMP.FTSessionID ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult    = $oQuery->row_array();
        }else{
            $aResult    = [];
        }
        return $aResult;
    }

    //บันทึกลง HD
    public function FSxMTBIAddUpdateHD($paDataMaster,$paDataWhere,$paTableAddUpdate){
        $aDataGetDataHD     =   $this->FSaMTBIGetDataDocHD(array(
            'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
            'FNLngID'       => $this->session->userdata("tLangEdit")
        ));

        $aDataAddUpdateHD   = array();
        if(isset($aDataGetDataHD['rtCode']) && $aDataGetDataHD['rtCode'] == 1){
            $aDataHDOld         = $aDataGetDataHD['raItems'];
            $aDataAddUpdateHD   = array_merge($paDataMaster,array(
                'FTBchCode'     => $paDataWhere['FTBchCode'],
                'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
                'FDLastUpdOn'   => $paDataWhere['FDLastUpdOn'],
                'FTLastUpdBy'   => $paDataWhere['FTLastUpdBy'],
                'FDCreateOn'    => $aDataHDOld['FDCreateOn'],
                'FTCreateBy'    => $aDataHDOld['FTCreateBy']
            ));
        }else{
            $aDataAddUpdateHD   = array_merge($paDataMaster,array(
                'FTBchCode'     => $paDataWhere['FTBchCode'],
                'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
                'FDCreateOn'    => $paDataWhere['FDCreateOn'],
                'FTCreateBy'    => $paDataWhere['FTCreateBy'],
            ));
        }

        // Delete HD
        $this->db->where_in('FTBchCode',$aDataAddUpdateHD['FTBchCode']);
        $this->db->where_in('FTXthDocNo',$aDataAddUpdateHD['FTXthDocNo']);
        $this->db->delete($paTableAddUpdate['tTableHD']);

        // Insert HD
        $this->db->insert($paTableAddUpdate['tTableHD'],$aDataAddUpdateHD);
        return;
    }

    //เอาข้อมูล HD
    public function FSaMTBIGetDataDocHD($paDataWhere){
        $tTBIDocNo   = $paDataWhere['FTXthDocNo'];
        $nLngID      = $paDataWhere['FNLngID'];

        $tSQL       = " SELECT
                            BCHL.FTBchName,
                            SHP.FTMerCode,
                            MERL.FTMerName,
                            SHP.FTShpType,
                            SHP.FTShpCode,
                            SHPL.FTShpName,
                            SHPL_T.FTShpName AS ShpNameTo,
                            POS.FTWahRefCode,
                            -- POSL.FTPosComName,

                            

                            DPTL.FTDptName,
                            USRL.FTUsrName,
                            USRAPV.FTUsrName AS FTXphApvName,
                            
                            DOCHD.FTBchCode,
                            DOCHD.FTXthDocNo,
                            DOCHD.FNXthDocType,
                            --DOCHD.FTXthTypRefFrm,
                            DOCHD.FDXthDocDate,
                            DOCHD.FTXthVATInOrEx,
                            DOCHD.FTDptCode,
                            --DOCHD.FTXthMerCode,

                            DOCHD.FTXthBchFrm           AS FTBchCodeFrom,
                            BCHL_F.FTBchName            AS FTBchNameFrom,

                            DOCHD.FTXthBchTo            AS FTBchCodeTo,
                            BCHL_T.FTBchName            AS FTBchNameTo,

                            -- DOCHD.FTXthWhFrm            AS FTWahCodeFrom,
                            -- WAHL_F.FTWahName            AS FTWahNameFrom,

                            DOCHD.FTXthWhTo             AS FTWahCodeTo,
                            WAHL_T.FTWahName            AS FTWahNameTo,
                            

                            -- DOCHD.FTXthShopFrm,
                            -- DOCHD.FTXthShopTo,
                            
                            --DOCHD.FTXthPosFrm,
                            --DOCHD.FTXthPosTo,
                            DOCHD.FTSplCode,
                            SPLL.FTSplName,

                            DOCHD.FTXthOther,
                            DOCHD.FTUsrCode,
                            DOCHD.FTSpnCode,
                            DOCHD.FTXthApvCode,
                            DOCHD.FTXthRefExt,
                            DOCHD.FDXthRefExtDate,
                            DOCHD.FTXthRefInt,
                            DOCHD.FDXthRefIntDate,
                            DOCHD.FNXthDocPrint,
                            DOCHD.FCXthTotal,
                            DOCHD.FCXthVat,
                            DOCHD.FCXthVatable,
                            DOCHD.FTXthRmk,
                            DOCHD.FTXthStaDoc,
                            DOCHD.FTXthStaApv,
                            DOCHD.FTXthStaPrcStk,
                            DOCHD.FTXthStaDelMQ,
                            DOCHD.FNXthStaDocAct,
                            DOCHD.FNXthStaRef,
                            DOCHD.FTRsnCode,
                            DOCHD.FDLastUpdOn,
                            DOCHD.FTLastUpdBy,
                            DOCHD.FDCreateOn,
                            DOCHD.FTCreateBy,
                            REA.FTRsnName,

                            HDREF.FTXthCtrName,
                            CONVERT(VARCHAR(10), HDREF.FDXthTnfDate, 121) AS FDXthTnfDate,
                            HDREF.FTXthRefTnfID,
                            HDREF.FTXthRefVehID,
                            HDREF.FTXthQtyAndTypeUnit,
                            HDREF.FNXthShipAdd,
                            HDREF.FTViaCode,
                            SHV_L.FTViaName,
                            DOCHD.FTXthRsnType

                        FROM TCNTPdtTbiHD DOCHD WITH (NOLOCK)

                        LEFT JOIN TCNTPdtTbiHDRef   HDREF   WITH (NOLOCK)  ON DOCHD.FTXthDocNo     = HDREF.FTXthDocNo  AND DOCHD.FTBchCode = HDREF.FTBchCode
                        LEFT JOIN TCNMShipVia_L     SHV_L   WITH (NOLOCK)  ON HDREF.FTViaCode      = SHV_L.FTViaCode   AND SHV_L.FNLngID        = $nLngID

                        LEFT JOIN TCNMBranch_L      BCHL    WITH (NOLOCK)   ON DOCHD.FTBchCode     = BCHL.FTBchCode    AND BCHL.FNLngID	        = $nLngID

                        LEFT JOIN TCNMBranch_L      BCHL_F  WITH (NOLOCK)  ON DOCHD.FTXthBchFrm    = BCHL_F.FTBchCode  AND BCHL_F.FNLngID	    = $nLngID
                        LEFT JOIN TCNMBranch_L      BCHL_T  WITH (NOLOCK)  ON DOCHD.FTXthBchTo     = BCHL_T.FTBchCode  AND BCHL_T.FNLngID	    = $nLngID

                        LEFT JOIN TCNMShop          SHP     WITH (NOLOCK)   ON DOCHD.FTXthShopFrm   = SHP.FTShpCode     AND DOCHD.FTBchCode = SHP.FTBchCode
                        LEFT JOIN TCNMShop_L        SHPL    WITH (NOLOCK)   ON DOCHD.FTXthShopFrm   = SHPL.FTShpCode    AND DOCHD.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
                        LEFT JOIN TCNMShop_L        SHPL_T  WITH (NOLOCK)   ON DOCHD.FTXthShopTo    = SHPL_T.FTShpCode	AND DOCHD.FTBchCode = SHPL_T.FTBchCode AND SHPL_T.FNLngID	    = $nLngID
                        LEFT JOIN TCNMMerchant_L    MERL    WITH (NOLOCK)   ON SHP.FTMerCode        = MERL.FTMerCode	AND MERL.FNLngID	    = $nLngID

                        LEFT JOIN TCNMWaHouse_L     WAHL_F  WITH (NOLOCK)   ON DOCHD.FTXthWhFrm     = WAHL_F.FTWahCode	AND DOCHD.FTXthBchFrm = WAHL_F.FTBchCode AND WAHL_F.FNLngID	    = $nLngID
                        LEFT JOIN TCNMWaHouse_L     WAHL_T  WITH (NOLOCK)   ON DOCHD.FTXthWhTo      = WAHL_T.FTWahCode	AND DOCHD.FTXthBchTo  = WAHL_T.FTBchCode AND WAHL_T.FNLngID	    = $nLngID

                        LEFT JOIN TCNMRsn_L         REA     WITH (NOLOCK)   ON DOCHD.FTRsnCode      = REA.FTRsnCode	    AND REA.FNLngID	     = $nLngID
                        LEFT JOIN TCNMWaHouse       POS     WITH (NOLOCK)   ON DOCHD.FTXthWhTo      = POS.FTWahCode		AND DOCHD.FTBchCode  =  POS.FTBchCode AND POS.FTWahStaType    = '6'
                        LEFT JOIN TCNMUsrDepart_L	DPTL    WITH (NOLOCK)   ON DOCHD.FTDptCode      = DPTL.FTDptCode	AND DPTL.FNLngID	= $nLngID
                        LEFT JOIN TCNMUser_L        USRL    WITH (NOLOCK)   ON DOCHD.FTUsrCode      = USRL.FTUsrCode	AND USRL.FNLngID	= $nLngID
                        LEFT JOIN TCNMUser_L        USRAPV	WITH (NOLOCK)   ON DOCHD.FTXthApvCode	= USRL.FTUsrCode	AND USRL.FNLngID	= $nLngID
                        LEFT JOIN TCNMSpl_L         SPLL    WITH (NOLOCK)   ON DOCHD.FTSplCode		= SPLL.FTSplCode	AND SPLL.FNLngID	= $nLngID
                        WHERE 1=1 AND DOCHD.FTXthDocNo = '$tTBIDocNo' ";
                        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail = $oQuery->row_array();
            $aResult    = array(
                'raItems'   => $aDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            $aResult    = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found.',
            );
        }
        return $aResult;
    }

    //Update DocNo In Doc Temp
    public function FSxMTBIAddUpdateDocNoToTemp($paDataWhere,$paTableAddUpdate){
        // Update DocNo Into DTTemp
        $this->db->where('FTXthDocNo','');
        $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
        $this->db->where('FTXthDocKey',$paTableAddUpdate['tTableHD']);
        $this->db->update('TCNTDocDTTmp',array(
            'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
            'FTBchCode'     => $paDataWhere['FTBchCode']
        ));

        // Update DocNo Into HDDisTemp
        $this->db->where('FTXthDocNo','');
        $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
        $this->db->update('TCNTDocHDDisTmp',array(
            'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
            'FTBchCode'     => $paDataWhere['FTBchCode']
        ));
        return;
    }

    //ย้ายข้อมูลจาก DTTmp To DT
    public function FSaMTBIMoveDtTmpToDt($paDataWhere,$paTableAddUpdate){
        $tTBIBchCode     = $paDataWhere['FTBchCode'];
        $tTBIDocNo       = $paDataWhere['FTXthDocNo'];
        $tXtdBchRef       = $paDataWhere['FTXtdBchRef'];
        $tTBIDocKey      = $paTableAddUpdate['tTableHD'];
        $tTBISessionID   = $this->session->userdata('tSesSessionID');
        
        if(isset($tTBIDocNo) && !empty($tTBIDocNo)){
            $this->db->where_in('FTXthDocNo',$tTBIDocNo);
            $this->db->delete($paTableAddUpdate['tTableDT']);
        }

        $tSQL   = " INSERT INTO ".$paTableAddUpdate['tTableDT']." (
                    FTBchCode , FTXthDocNo , FNXtdSeqNo , FTPdtCode , FTXtdPdtName ,
                    FTPunCode , FTPunName , FCXtdFactor , FTXtdBarCode , FTXtdVatType ,
                    FTVatCode , FCXtdVatRate , FCXtdQty , FCXtdQtyAll , FCXtdSetPrice ,
                    FCXtdAmt , FCXtdVat , FCXtdVatable , FCXtdNet , FCXtdCostIn ,
                    FCXtdCostEx , FTXtdStaPrcStk , FNXtdPdtLevel , FTXtdPdtParent ,FCXtdQtySet ,
                    FTXtdPdtStaSet , FTXtdRmk , FTXtdBchRef , FTXtdDocNoRef , FDLastUpdOn ,
                    FTLastUpdBy ,FDCreateOn , FTCreateBy ) ";
        $tSQL   .=  "   SELECT
                            DOCTMP.FTBchCode,
                            DOCTMP.FTXthDocNo,
                            ROW_NUMBER() OVER(ORDER BY DOCTMP.FNXtdSeqNo ASC) AS FNXtdSeqNo,
                            DOCTMP.FTPdtCode,
                            DOCTMP.FTXtdPdtName,
                            DOCTMP.FTPunCode,
                            DOCTMP.FTPunName,
                            DOCTMP.FCXtdFactor,
                            DOCTMP.FTXtdBarCode,
                            DOCTMP.FTXtdVatType,
                            DOCTMP.FTVatCode,
                            DOCTMP.FCXtdVatRate,
                            DOCTMP.FCXtdQty,
                            DOCTMP.FCXtdQtyAll,
                            DOCTMP.FCXtdSetPrice,
                            DOCTMP.FCXtdAmt,
                            DOCTMP.FCXtdVat,
                            DOCTMP.FCXtdVatable,
                            DOCTMP.FCXtdNet,
                            DOCTMP.FCXtdCostIn,
                            DOCTMP.FCXtdCostEx,
                            DOCTMP.FTXtdStaPrcStk,
                            DOCTMP.FNXtdPdtLevel,
                            DOCTMP.FTXtdPdtParent,
                            DOCTMP.FCXtdQtySet,
                            DOCTMP.FTXtdPdtStaSet,
                            DOCTMP.FTXtdRmk,
                            '$tXtdBchRef' AS FTXtdBchRef,
                            DOCTMP.FTXtdDocNoRef,
                            DOCTMP.FDLastUpdOn,
                            DOCTMP.FTLastUpdBy,
                            DOCTMP.FDCreateOn,
                            DOCTMP.FTCreateBy
                        FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                        WHERE 1 = 1
                        AND DOCTMP.FTBchCode    = '$tTBIBchCode'
                        AND DOCTMP.FTXthDocNo   = '$tTBIDocNo'
                        AND DOCTMP.FTXthDocKey  = '$tTBIDocKey'
                        AND DOCTMP.FTSessionID  = '$tTBISessionID'
                        AND DOCTMP.FTCabNameForTWXVD IS NULL
                        ORDER BY DOCTMP.FNXtdSeqNo ASC ";
        $oQuery = $this->db->query($tSQL);


        //ถ้าสินค้านั้นมีการ ref CN ต้องเอาไปอัพเดทให้ว่ากำลังประมวลผล
        $tSQLUpdateCN     =  "SELECT DOCTMP.FTXtdDocNoRef , DOCTMP.FTBchCode,DOCTMP.FTXthDocNo,DOCTMP.FTPdtCode,DOCTMP.FTCabNameForTWXVD
                        FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK) WHERE 1 = 1
                        AND DOCTMP.FTBchCode    = '$tTBIBchCode'
                        AND DOCTMP.FTXthDocNo   = '$tTBIDocNo'
                        AND DOCTMP.FTXthDocKey  = '$tTBIDocKey'
                        AND DOCTMP.FTSessionID  = '$tTBISessionID'
                        AND DOCTMP.FTXtdDocNoRef IS NOT NULL
                        ORDER BY DOCTMP.FNXtdSeqNo ASC ";
        $oQuery     = $this->db->query($tSQLUpdateCN);
        $aDetailCN    = $oQuery->result_array();
        if($oQuery->num_rows() > 0){
            for($i=0; $i<count($aDetailCN); $i++){
                $aPackData = array(
                    'tDocNo'    => $aDetailCN[$i]['FTXtdDocNoRef'],
                    'tPdtCode'  => $aDetailCN[$i]['FTPdtCode']
                );
                $this->FSaMTBIUpdatePDTInCN($aPackData);
            }
        }    


        //อัพเดทสินค้า CN ให้กลับมาใช้งานได้ กรณีที่เขากดลบในตาราง
        $tSQLCN     =  "SELECT DOCTMP.FTBchCode,DOCTMP.FTXthDocNo,DOCTMP.FTPdtCode,DOCTMP.FTCabNameForTWXVD
                        FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK) WHERE 1 = 1
                        AND DOCTMP.FTBchCode    = '$tTBIBchCode'
                        AND DOCTMP.FTXthDocNo   = '$tTBIDocNo'
                        AND DOCTMP.FTXthDocKey  = '$tTBIDocKey'
                        AND DOCTMP.FTSessionID  = '$tTBISessionID'
                        AND DOCTMP.FTCabNameForTWXVD = 'DELETE_TEMP'
                        ORDER BY DOCTMP.FNXtdSeqNo ASC ";
        $oQuery     = $this->db->query($tSQLCN);
        $aDetail    = $oQuery->result_array();
        if($oQuery->num_rows() > 0){
            for($i=0; $i<count($aDetail); $i++){
                $aPackData = array(
                    'tDocNo'    => $aDetail[$i]['FTXthDocNo'],
                    'tPdtCode'  => $aDetail[$i]['FTPdtCode']
                );
                $this->FSvMTBICheckDocumentInCN('DEL',$aPackData);
            }
        }
        return;
    }

    //ย้ายข้อมูลจาก DT To DTTmp
    public function FSxMTBIMoveDTToDTTemp($paDataWhere){
        $tTBIDocNo       = $paDataWhere['FTXthDocNo'];
        $tTBIDocKey      = $paDataWhere['FTXthDocKey'];

        // Delect Document DTTemp By Doc No
        $this->db->where('FTXthDocNo',$tTBIDocNo);
        $this->db->delete('TCNTDocDTTmp');

        $tSQL   = " INSERT INTO TCNTDocDTTmp (
                        FTBchCode, FTXthDocNo, FNXtdSeqNo , FTXthDocKey , FTPdtCode, 
                        FTXtdPdtName, FTPunCode, FTPunName, FCXtdFactor,
                        FTXtdBarCode, FTXtdVatType, FTVatCode, FCXtdVatRate,
                        FCXtdQty, FCXtdQtyAll, FCXtdSetPrice, FCXtdAmt,
                        FCXtdVat, FCXtdVatable, FCXtdNet, FCXtdCostIn,
                        FCXtdCostEx, FTXtdStaPrcStk, FNXtdPdtLevel, FTXtdPdtParent,
                        FCXtdQtySet, FTXtdPdtStaSet, FTXtdRmk, FTXtdBchRef,
                        FTXtdDocNoRef, FTSessionID , FDLastUpdOn, FDCreateOn , FTLastUpdBy , FTCreateBy )
                    SELECT
                        DT.FTBchCode , 
                        DT.FTXthDocNo , 
                        DT.FNXtdSeqNo , 
                        CONVERT(VARCHAR,'".$tTBIDocKey."') AS FTXthDocKey,
                        DT.FTPdtCode , 
                        DT.FTXtdPdtName ,
                        DT.FTPunCode , 
                        DT.FTPunName , 
                        DT.FCXtdFactor , 
                        DT.FTXtdBarCode , 
                        DT.FTXtdVatType ,
                        DT.FTVatCode , 
                        DT.FCXtdVatRate , 
                        DT.FCXtdQty , 
                        DT.FCXtdQtyAll , 
                        DT.FCXtdSetPrice ,
                        DT.FCXtdAmt , 
                        DT.FCXtdVat , 
                        DT.FCXtdVatable , 
                        DT.FCXtdNet , 
                        DT.FCXtdCostIn ,
                        DT.FCXtdCostEx , 
                        DT.FTXtdStaPrcStk , 
                        DT.FNXtdPdtLevel , 
                        DT.FTXtdPdtParent , 
                        DT.FCXtdQtySet ,
                        DT.FTXtdPdtStaSet , 
                        DT.FTXtdRmk , 
                        DT.FTXtdBchRef ,
                        DT.FTXtdDocNoRef ,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesSessionID')."') AS FTSessionID ,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDLastUpdOn ,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn ,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTLastUpdBy ,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTCreateBy
                    FROM TCNTPdtTBIDT AS DT WITH (NOLOCK)
                    WHERE 1=1 AND DT.FTXthDocNo = '$tTBIDocNo'
                    ORDER BY DT.FNXtdSeqNo ASC ";
        $oQuery = $this->db->query($tSQL);
        return;
    }

    //ยกเลิกเอกสาร
    public function FSvMTBICancel($paDataUpdate){
        try{
            $this->db->set('FTXthStaDoc', 3);
            $this->db->where('FTXthDocNo', $paDataUpdate['FTXthDocNo']);
            $this->db->update('TCNTPdtTbiHD');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'OK',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Approve',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //อัพเดทข้อมูลรายเเถว
    public function FSaMTBIUpdateInlineDTTemp($paDataUpdateDT,$paDataWhere){
        $this->db->set($paDataUpdateDT['tTBIFieldName'], $paDataUpdateDT['tTBIValue']);
        $this->db->where('FTSessionID',$paDataWhere['tTBISessionID']);
        $this->db->where('FTXthDocKey',$paDataWhere['tDocKey']);
        $this->db->where('FNXtdSeqNo',$paDataWhere['nTBISeqNo']);
        $this->db->where('FTXthDocNo',$paDataWhere['tTBIDocNo']);
        $this->db->where('FTBchCode',$paDataWhere['tTBIBchCode']);
        $this->db->update('TCNTDocDTTmp');
   
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Update Success',
            );
        }else{
            $aStatus = array(
                'rtCode'    => '903',
                'rtDesc'    => 'Update Fail',
            );
        }
        return $aStatus;
    }

    //ไปเอาสินค้า จากตาราง CN ใบสั้งจ่าย
    public function FSaMTBIGetPDTInCN($paDataWhere){
        $tBCHCode       = $paDataWhere['tBCHCode'];
        $tSHPCode       = $paDataWhere['tSHPCode'];
        $tWAHCode       = $paDataWhere['tWAHCode'];
        $nLngID         = $paDataWhere['FNLngID'];

        $tSQL       = " SELECT 
                            row_number() over (order by CN.FTXshDocNo) as rtRowID,
                            CN.FTXshDocNo , 
                            CN.FNXsdSeqNo , 
                            CN.FTStaPrcStk ,
                            HD.FTBchCode ,
                            BACL.FTBchName ,
                            HD.FTShpCode ,
                            SHPL.FTShpName ,
                            HD.FTWahCode ,
                            WAHL.FTWahName , 
                            DT.FTPdtCode ,
                            DT.FTXsdPdtName ,
                            DT.FTPunCode ,
                            DT.FTPunName , 
                            BAR.FTBarCode
                        FROM TVDTDTCN CN 
                        LEFT JOIN TARTSoHD HD			ON HD.FTXshDocNo = CN.FTXshDocNo
                        LEFT JOIN TARTSoDT DT			ON HD.FTXshDocNo = DT.FTXshDocNo AND DT.FNXsdSeqNo = CN.FNXsdSeqNo
                        LEFT JOIN TCNMBranch_L BACL		ON HD.FTBchCode = BACL.FTBchCode AND BACL.FNLngID = $nLngID
                        LEFT JOIN TCNMShop_L SHPL		ON HD.FTShpCode = SHPL.FTShpCode AND HD.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
                        LEFT JOIN TCNMWahouse_L WAHL	ON HD.FTWahCode = WAHL.FTWahCode AND HD.FTBchCode = WAHL.FTBchCode AND WAHL.FNLngID = $nLngID
                        LEFT JOIN TCNMPdtBar BAR		ON BAR.FTPdtCode = DT.FTPdtCode AND DT.FTPunCode = BAR.FTPunCode 
                        WHERE CN.FTStaPrcStk IS NULL";

        if($tBCHCode != null || $tBCHCode != ''){
            $tSQL .= " AND HD.FTBchCode = '$tBCHCode' ";
        }

        if($tSHPCode != null || $tSHPCode != ''){
            $tSQL .= " AND HD.FTShpCode = '$tSHPCode' ";
        }

        if($tWAHCode != null || $tWAHCode != ''){
            $tSQL .= " AND HD.FTWahCode = '$tWAHCode' ";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail    = $oQuery->result_array();
            $aResult    = array(
                'raItems'   => $aDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            $aResult    = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found.',
            );
        }
        return $aResult;
    }

    //อัพเดทสินค้าในตาราง CN ว่าถูกใช้งานอยู่
    public function FSaMTBIUpdatePDTInCN($ptPackData){
        $tDocument = $ptPackData['tDocNo'];
        $tPDTCode  = $ptPackData['tPdtCode'];

        $tSQL = " SELECT 
                    DT.FTXtdDocNoRef , 
                    DT.FTXthDocNo , 
                    DT.FTPdtCode ,
                    SODT.FNXsdSeqNo
                FROM TCNTDocDTTmp DT
                LEFT JOIN TARTSoDT SODT ON  DT.FTXtdDocNoRef = SODT.FTXshDocNo AND DT.FTPdtCode = SODT.FTPdtCode
                WHERE 
                SODT.FTXsdStaPrcStk = 2 AND
                DT.FTXtdDocNoRef = '$tDocument' AND
                DT.FTXtdDocNoRef IS NOT NULL AND
                DT.FTPdtCode = '$tPDTCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail    = $oQuery->result_array();
            for($i=0; $i<count($aDetail); $i++){
                $dLastUpdOn = date('Y-m-d H:i:s');
                $tLastUpdBy = $this->session->userdata('tSesUsername');
                $this->db->set('FTStaPrcStk',1);
                $this->db->set('FDLastUpdOn',$dLastUpdOn);
                $this->db->set('FTLastUpdBy',$tLastUpdBy);
                $this->db->where('FTXshDocNo',$aDetail[$i]['FTXtdDocNoRef']);
                $this->db->where('FNXsdSeqNo',$aDetail[$i]['FNXsdSeqNo']);
                $this->db->update('TVDTDTCN');
            }
        }
    }

    //อัพเดทอนุมัติ
    public function FSvMTBIApprove($paDataUpdate){
        try{
            $dLastUpdOn = date('Y-m-d H:i:s');
            $tLastUpdBy = $this->session->userdata('tSesUsername');
            $this->db->set('FDLastUpdOn',$dLastUpdOn);
            $this->db->set('FTLastUpdBy',$tLastUpdBy);
            $this->db->set('FTXthStaPrcStk',2);
            $this->db->set('FTXthStaApv',2);
            $this->db->set('FTXthApvCode',$paDataUpdate['FTXthApvCode']);
            $this->db->where('FTXthDocNo',$paDataUpdate['FTXthDocNo']);
            $this->db->update('TCNTPdtTbiHD');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'OK',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Approve',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //เช็คว่าเป็นสินค้า CN ไหมถ้า CN ต้องกลับไปอนุญาติให้ใช้งานได้
    public function FSvMTBICheckDocumentInCN($ptType,$paData){

        if($ptType == 'CANCEL'){
            $tDocument = $paData['FTXthDocNo'];
            $tPDTCode  = '';

            $tSQL = " SELECT 
                    DT.FTXtdDocNoRef , 
                    DT.FTXthDocNo , 
                    DT.FTPdtCode ,
                    SODT.FNXsdSeqNo
                FROM TCNTPdtTBIDT DT
                LEFT JOIN TARTSoDT SODT ON  DT.FTXtdDocNoRef = SODT.FTXshDocNo AND DT.FTPdtCode = SODT.FTPdtCode
                WHERE 
                SODT.FTXsdStaPrcStk = 2 AND
                DT.FTXthDocNo = '$tDocument' ";
        }else if($ptType == 'DEL'){
            $tDocument = $paData['tDocNo'];
            $tPDTCode  = $paData['tPdtCode'];

            $tSQL = " SELECT 
                    DT.FTXtdDocNoRef , 
                    DT.FTXthDocNo , 
                    DT.FTPdtCode ,
                    SODT.FNXsdSeqNo
                FROM TCNTDocDTTmp DT
                LEFT JOIN TARTSoDT SODT ON  DT.FTXtdDocNoRef = SODT.FTXshDocNo AND DT.FTPdtCode = SODT.FTPdtCode
                WHERE 
                SODT.FTXsdStaPrcStk = 2 AND
                DT.FTXthDocNo = '$tDocument' AND
                DT.FTXtdDocNoRef IS NOT NULL ";
        }

        if($tPDTCode != ''){
            $tSQL .= " AND DT.FTPdtCode = '$tPDTCode' ";
        }      
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail    = $oQuery->result_array();
            for($i=0; $i<count($aDetail); $i++){
                $dLastUpdOn = date('Y-m-d H:i:s');
                $tLastUpdBy = $this->session->userdata('tSesUsername');
                $this->db->set('FTStaPrcStk',null);
                $this->db->set('FDLastUpdOn',$dLastUpdOn);
                $this->db->set('FTLastUpdBy',$tLastUpdBy);
                $this->db->where('FTXshDocNo',$aDetail[$i]['FTXtdDocNoRef']);
                $this->db->where('FNXsdSeqNo',$aDetail[$i]['FNXsdSeqNo']);
                $this->db->update('TVDTDTCN');
            }
        }
    }


    public function FSoMTBIEventInsertPdtIntDTBchToTemp($paDataPdtMaster,$paDataPdtParams){ 
        try{
            $paPIDataPdt    = $paDataPdtMaster['raItem'];

            $aDataInsert    = array(
                'FTBchCode'         => $paDataPdtParams['tBchCode'],
                'FTXthDocNo'        => $paDataPdtParams['tDocNo'],
                'FNXtdSeqNo'        => $paDataPdtParams['nMaxSeqNo'],
                'FTXthDocKey'       => $paDataPdtParams['tDocKey'],
                'FTPdtCode'         => $paPIDataPdt['FTPdtCode'],
                'FTXtdPdtName'      => $paPIDataPdt['FTPdtName'],
                'FCXtdFactor'       => $paPIDataPdt['FCPdtUnitFact'],
                'FTPunCode'         => $paPIDataPdt['FTPunCode'],
                'FTPunName'         => $paPIDataPdt['FTPunName'],
                'FTXtdBarCode'      => $paDataPdtParams['tBarCode'],
                'FTXtdVatType'      => $paPIDataPdt['FTPdtStaVatBuy'],
                'FTVatCode'         => $paPIDataPdt['FTVatCode'],
                'FCXtdVatRate'      => $paPIDataPdt['FCVatRate'],
                'FTXtdStaAlwDis'    => $paPIDataPdt['FTPdtStaAlwDis'],
                'FTXtdSaleType'     => $paPIDataPdt['FTPdtSaleType'],
                'FCXtdSalePrice'    => $paPIDataPdt['FTPdtSalePrice'],
                'FCXtdQty'          => $paDataPdtParams['FCXtdQty'],
                'FCXtdQtyAll'       => $paDataPdtParams['FCXtdQtyAll'],
                'FCXtdSetPrice'     => $paDataPdtParams['cPrice'] * 1,
                'FTXtdDocNoRef'     => $paDataPdtParams['tDocRefSO'],
                'FTSessionID'       => $paDataPdtParams['tSessionID'],
                'FDLastUpdOn'       => date('Y-m-d h:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d h:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername')
            );
            $this->db->insert('TCNTDocDTTmp',$aDataInsert);
       if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'OK',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Approve',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
}


public function FSoMTBIEventGetPdtIntDTBch($pData){ 

    $tTBODocNo =  $pData['tTBODocNo'];
    $tTBIDocNo =  $pData['tTBIDocNo'];
    $tTBIBchCodeTo =  $pData['tTBIBchCodeTo'];
    $tTBISesUsername =  $pData['tTBISesUsername'];
    $tTBISessionID =  $pData['tTBISessionID'];


        $tSqlDocTmp = " SELECT 
                            ITB.FTPdtCode,
                            ITB.FTXtdPdtName,
                            ITB.FTPunCode,
                            ITB.FTPunName,
                            ITB.FTXtdBarCode,
                            ITB.FCXtdQty,
                            ITB.FCXtdQtyAll
                        FROM 
                        TCNTPdtIntDTBch ITB
                        WHERE ITB.FTXthDocNo = '$tTBODocNo'
                        AND ITB.FTXthBchTo = '$tTBIBchCodeTo'
                        AND ( ITB.FTXtdRvtRef IS NULL OR ITB.FTXtdRvtRef='' )
                        ORDER BY ITB.FNXtdSeqNo ASC
                        ";
        $oQuery = $this->db->query($tSqlDocTmp);
        $result = $oQuery->result_array();

        return $result;
    }

    //Functionality : Function Add/Update HD Ref
    //Parameters : function parameters
    //Creator : 26/03/2020 Napat(Jame)
    //Last Modified : -
    //Return : Status Add/Update HD Ref
    //Return Type : array
    public function FSaMTBIAddUpdateHDRef($paData,$paWhere,$paTable){

        try{
            //Update Master
            $this->db->set('FTBchCode'              , $paWhere['FTBchCode']);
            $this->db->set('FTXthDocNo'             , $paWhere['FTXthDocNo']);
            $this->db->set('FTXthCtrName'           , $paData['FTXthCtrName']);
            $this->db->set('FDXthTnfDate'           , $paData['FDXthTnfDate']);
            $this->db->set('FTXthRefTnfID'          , $paData['FTXthRefTnfID']);
            $this->db->set('FTXthRefVehID'          , $paData['FTXthRefVehID']);
            $this->db->set('FTXthQtyAndTypeUnit'    , $paData['FTXthQtyAndTypeUnit']);
            $this->db->set('FNXthShipAdd'           , $paData['FNXthShipAdd']);
            $this->db->set('FTViaCode'              , $paData['FTViaCode']);

            $this->db->where('FTXthDocNo'           , $paWhere['FTXthDocNo']);
            $this->db->update($paTable['tTableHDRef']);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                //Add Master
                $this->db->insert($paTable['tTableHDRef'],array(
                    'FTBchCode'             => $paWhere['FTBchCode'],
                    'FTXthDocNo'            => $paWhere['FTXthDocNo'],
                    'FTXthCtrName'          => $paData['FTXthCtrName'],
                    'FDXthTnfDate'          => $paData['FDXthTnfDate'],
                    'FTXthRefTnfID'         => $paData['FTXthRefTnfID'],
                    'FTXthRefVehID'         => $paData['FTXthRefVehID'],
                    'FTXthQtyAndTypeUnit'   => $paData['FTXthQtyAndTypeUnit'],
                    'FNXthShipAdd'          => $paData['FNXthShipAdd'],
                    'FTViaCode'             => $paData['FTViaCode']
                ));
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



}