<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Cardshiftreturn_model extends CI_Model {

    /**
     * Functionality : Search UsrDepart By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMCardShiftReturnSearchByID($ptAPIReq, $ptMethodReq, $paData){
        $tCardShiftReturnDocNo = $paData['FTCshDocNo'];
        
        $nLngID = $paData['FNLngID'];
        $tSQL = "SELECT
                    CRDHD.FTCshDocNo AS rtCardShiftReturnDocNo,
                    CRDHD.FTBchCode AS rtCardShiftReturnBchCode,
                    CRDHD.FTCshDocType AS rtCardShiftReturnDocType,
                    CRDHD.FDCshDocDate AS rtCardShiftReturnDocDate,
                    CRDHD.FTUsrCode AS rtCardShiftReturnUsrCode,
                    CRDHD.FTCshApvCode AS rtCardShiftReturnApvCode,
                    CRDHD.FDCshApvDate AS rtCardShiftReturnApvDate,
                    CRDHD.FTCshCashier AS rtCardShiftReturnCashier,
                    CRDHD.FTCshStaSetExpired AS rtCardShiftReturnStaSetExpired,
                    CRDHD.FDCshDateExpired AS rtCardShiftReturnDateExpired,
                    CRDHD.FNCshCardQty AS rtCardShiftReturnCardQty,
                    CRDHD.FTCshStaPrcDoc AS rtCardShiftReturnStaPrcDoc,
                    CRDHD.FTCshStaDoc AS rtCardShiftReturnStaDoc,
                    CRDHD.FTCshStaDelMQ AS rtCardShiftReturnStaDelMQ
                FROM [TFNTCrdShiftHD] CRDHD
                WHERE 1=1";
                $tSQL .= " AND CRDHD.FTCshDocNo = '$tCardShiftReturnDocNo'";               
                $tSQL .= " AND CRDHD.FTCshDocType = '2'";
        
        /*if($tCardShiftReturnDocNo != ""){
            $tSQL .= "AND CRDHD.FTCshDocNo = '$tCardShiftReturnDocNo'";
        }*/
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
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
     * Functionality : List Card Shift HD
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftReturnList($ptAPIReq, $ptMethodReq, $paData){
        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $tCardShiftReturnBchCode = $paData['FTBchCode'];
        $tUserLevel = $paData['tUserLevel'];
        $nLngID = $paData['FNLngID'];

        $tSQL = "
            SELECT 
                c.* 
            FROM(
                SELECT 
                    ROW_NUMBER() OVER(ORDER BY rtFDCreateOn DESC) AS rtRowID,*
                FROM
                    (SELECT DISTINCT
                        CRDHD.FTBchCode AS rtCardShiftReturnBchCode,
                        CRDHD.FTCshDocNo AS rtCardShiftReturnDocNo,
                        CRDHD.FDCshDocDate AS rtCardShiftReturnDocDate,
                        CRDHD.FNCshCardQty AS rtCardShiftReturnCshCardQty,
                        CRDHD.FTCshStaDoc AS rtCardShiftReturnCshStaDoc,
                        CRDHD.FTCshStaPrcDoc AS rtCardShiftReturnCshStaPrcDoc,
                        CRDHD.FDCreateOn AS rtFDCreateOn
                        
                    FROM [TFNTCrdShiftHD] CRDHD
                    WHERE 1=1
        ";  
        
                    // BchCode is empty = HQ(use all)
                    ($tUserLevel == "HQ") ? "" : $tSQL .= " AND CRDHD.FTBchCode = '$tCardShiftReturnBchCode'";  
                    $tSQL .= " AND CRDHD.FTCshDocType = '2'";
        
        $tSearchList = $paData['tSearchAll'];
        $oAdvanceSearch = $paData['tAdvanceSearch'];
        
        if(!empty($oAdvanceSearch->tSearchDocDateFrom) && !empty($oAdvanceSearch->tSearchDocDateTo)){
            $tSQL .= " AND ((CRDHD.FDCshDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:59:59')) OR (CRDHD.FDCshDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00')))";
        }
        if(!empty($oAdvanceSearch->tSearchStaDoc) && ($oAdvanceSearch->tSearchStaDoc != "0")){
            $tSQL .= " AND CRDHD.FTCshStaDoc = '$oAdvanceSearch->tSearchStaDoc'";
        }
        if(!empty($oAdvanceSearch->tSearchStaApprove) && ($oAdvanceSearch->tSearchStaApprove != "0")){
            
            if($oAdvanceSearch->tSearchStaApprove == "1"){ // Approved
                $tSQL .= " AND CRDHD.FTCshStaPrcDoc = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if($oAdvanceSearch->tSearchStaApprove == "2"){ // Approved
                $tSQL .= " AND CRDHD.FTCshStaPrcDoc = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if($oAdvanceSearch->tSearchStaApprove == "3"){ // Pending approved
                $tSQL .= " AND (CRDHD.FTCshStaPrcDoc IS NULL OR CRDHD.FTCshStaPrcDoc = '') AND CRDHD.FTCshStaDoc != 3";
            }
            if($oAdvanceSearch->tSearchStaApprove == "4"){ // N/A Doc status(cancel)
                $tSQL .= " AND (CRDHD.FTCshStaPrcDoc IS NULL OR CRDHD.FTCshStaPrcDoc = '') AND CRDHD.FTCshStaDoc = 3";
            }
            
        }
        if ($tSearchList != ''){
            $tSQL .= " AND (CRDHD.FTBchCode LIKE '%$tSearchList%'";
            $tSQL .= " OR CRDHD.FTCshDocNo LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCardShiftReturnGetPageAll($tSearchList, $paData);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            // No Data
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
     * Functionality : List Card
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftReturnDataSourceList($paData){
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tStaShift = $paData['FTCrdStaShift'];
        $tStaType = $paData['tStaType'];
        $tSQL       = "SELECT c.* FROM(
                       SELECT  ROW_NUMBER() OVER(ORDER BY rtCrdCode ASC) AS rtRowID,*
                       FROM
                       (SELECT DISTINCT
                            CRD.FTCrdCode AS rtCrdCode,
                            CRDL.FTCrdName AS rtCrdName,
                            CRD.FTCrdHolderID AS rtCrdHolderID,
                            CRDT.FTCtyCode AS rtCtyCode,
                            CRDT.FCCtyTopupAuto AS rtCtyTopupAuto,
                            CRDTL.FTCtyName AS rtCtyName,
                            CONVERT(VARCHAR(10),CRD.FDCrdStartDate,121) AS rtCrdStartDate,
                            CONVERT(VARCHAR(10),CRD.FDCrdExpireDate,121) AS rtCrdExpireDate,
                            CRD.FCCrdValue AS rtCrdValue,
                            CRD.FCCrdDeposit AS rtCrdDeposit,
                            CRD.FTCrdStaShift AS rtCrdStaShift,
                            CRD.FTCrdStaActive AS rtCrdStaActive,
                            CONVERT(VARCHAR(10),CRD.FDCrdLastTopup,121) AS rtCrdLastTopup
                        FROM [TFNMCard] CRD WITH (NOLOCK)
                        LEFT JOIN TFNMCard_L CRDL WITH (NOLOCK) ON CRD.FTCrdCode = CRDL.FTCrdCode AND CRDL.FNLngID = $nLngID
                        LEFT JOIN TFNMCardType CRDT WITH (NOLOCK) ON CRD.FTCtyCode = CRDT.FTCtyCode
                        LEFT JOIN TFNMCardType_L CRDTL WITH (NOLOCK) ON CRDT.FTCtyCode = CRDTL.FTCtyCode AND CRDTL.FNLngID = $nLngID
                        WHERE 1=1 
                        AND CRD.FTCrdStaActive = 1
                        AND CRD.FTCrdStaType = 1";
        
        if($tStaType == "1"){ // Approved return
            $tSQL .= " AND (CRD.FTCrdStaShift = 1 OR CRD.FTCrdStaShift = 2)";
        }
        if($tStaType == "3"){ // Out
            $tSQL .= " AND CRD.FTCrdStaShift = 2";
        }
        if($tStaType == "4"){ // Pending return
            $tSQL .= " AND (CRD.FTCrdStaShift = 1 OR CRD.FTCrdStaShift = 2)";
        }
        if($tStaType == "2"){ // Cancel type
            $tSQL .= " AND (CRD.FTCrdStaShift = 1 OR CRD.FTCrdStaShift = 2)";
        }
        
        if(count($paData['aCardNumber']) > 0){
            $tCardNumber = implode(',', $paData['aCardNumber']);
            $tSQL .= " AND (CRD.FTCrdCode IN ($tCardNumber))";
        }
        
        if(count($paData['aCardTypeRange']) == 2){
            $tCardTypeRange = $paData['aCardTypeRange'];
            $tSQL .= " AND ((CRDT.FTCtyCode BETWEEN '$tCardTypeRange[0]' AND '$tCardTypeRange[1]') OR (CRDT.FTCtyCode BETWEEN '$tCardTypeRange[1]' AND '$tCardTypeRange[0]'))";
        }
        
        if(count($paData['aCardNumberRange']) == 2){
            $tCardNumberRange = $paData['aCardNumberRange'];
            $tSQL .= " AND ((CRD.FTCrdCode BETWEEN '$tCardNumberRange[0]' AND '$tCardNumberRange[1]') OR (CRD.FTCrdCode BETWEEN '$tCardNumberRange[1]' AND '$tCardNumberRange[0]'))";
        }
        
        if(count($paData['aNotInCardNumber']) > 0){
            $tNotInCardNumber = implode(',', $paData['aNotInCardNumber']);
            $tSQL .= " AND (CRD.FTCrdCode NOT IN ($tNotInCardNumber))";
        }
        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            // $tSQL .= " AND (CardShiftReturn.FTCgpCode LIKE '%$tSearchList%'";
            // $tSQL .= " OR CardShiftReturnL.FTCgpName LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSaMCardShiftReturnDataSourceGetPageAll($tSearchList, $nLngID, $paData);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
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
     * Functionality : All Page Of Card
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftReturnDataSourceGetPageAll($ptSearchList, $ptLngID, $paData){
        $tStaShift = $paData['FTCrdStaShift'];
        $tSQL = "SELECT COUNT (CRD.FTCrdCode) AS counts
                FROM [TFNMCard] CRD WITH (NOLOCK)
                LEFT JOIN TFNMCard_L CRDL WITH (NOLOCK) ON CRD.FTCrdCode = CRDL.FTCrdCode AND CRDL.FNLngID = $$ptLngID
                LEFT JOIN TFNMCardType CRDT WITH (NOLOCK) ON CRD.FTCtyCode = CRDT.FTCtyCode
                LEFT JOIN TFNMCardType_L CRDTL WITH (NOLOCK) ON CRDT.FTCtyCode = CRDTL.FTCtyCode AND CRDTL.FNLngID = $ptLngID
                WHERE 1=1 
                AND CRD.FTCrdStaActive = 1
                AND CRD.FTCrdStaType = 1
                AND CRD.FTCrdStaShift = '$tStaShift'";
        
        if(count($paData['aCardNumber']) > 0){
            $tCardNumbers = implode(',', $paData['aCardNumber']);
            $tSQL .= " AND (CRD.FTCrdCode IN ($tCardNumbers))";
        }
        
        if(count($paData['aCardTypeRange']) == 2){
            $tCardTypeRange = $paData['aCardTypeRange'];
            $tSQL .= " AND (CRDT.FTCtyCode BETWEEN '$tCardTypeRange[0]' AND '$tCardTypeRange[1]')";
            if(count($paData['aNotInCardNumber']) > 0){
                $tNotInCardNumber = implode(',', $paData['aNotInCardNumber']);
                $tSQL .= " AND (CRDT.FTCtyCode NOT IN ($tNotInCardNumber))";
            }
        }
        
        if(count($paData['aCardNumberRange']) == 2){
            $tCardNumberRange = $paData['aCardNumberRange'];
            $tSQL .= " AND (CRD.FTCrdCode BETWEEN '$tCardNumberRange[0]' AND '$tCardNumberRange[1]')";
        }
        
        if($ptSearchList != ''){
            // $tSQL .= " AND (CardShiftReturn.FTCgpCode LIKE '%$ptSearchList%'";
            // $tSQL .= " OR CardShiftReturnL.FTCgpName LIKE '%$ptSearchList%')";
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
     * Functionality : All Page Of Card Shift HD
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMCardShiftReturnGetPageAll($ptSearchList, $paData){
        $tCardShiftReturnBchCode = $paData['FTBchCode'];
        $tSQL = "SELECT COUNT (CRDHD.FTBchCode) AS counts
                FROM [TFNTCrdShiftHD] CRDHD
                WHERE 1=1";
                
                // BchCode is empty = HQ(use all)
                empty($tCardShiftReturnBchCode) ? "" : $tSQL .= " AND CRDHD.FTBchCode = '$tCardShiftReturnBchCode'";
                $tSQL .= "AND CRDHD.FTCshDocType = '2'";
        
        $oAdvanceSearch = $paData['tAdvanceSearch'];
        
        if(!empty($oAdvanceSearch->tSearchDocDateFrom) && !empty($oAdvanceSearch->tSearchDocDateTo)){
            $tSQL .= " AND ((CRDHD.FDCshDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:59:59')) OR (CRDHD.FDCshDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00')))";
        }
        if(!empty($oAdvanceSearch->tSearchStaDoc) && ($oAdvanceSearch->tSearchStaDoc != "0")){
            $tSQL .= " AND CRDHD.FTCshStaDoc = '$oAdvanceSearch->tSearchStaDoc'";
        }
        if(!empty($oAdvanceSearch->tSearchStaApprove) && ($oAdvanceSearch->tSearchStaApprove != "0")){
            
            if($oAdvanceSearch->tSearchStaApprove == "1"){ // Approved
                $tSQL .= " AND CRDHD.FTCshStaPrcDoc = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if($oAdvanceSearch->tSearchStaApprove == "2"){ // Approved
                $tSQL .= " AND CRDHD.FTCshStaPrcDoc = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if($oAdvanceSearch->tSearchStaApprove == "3"){ // Pending approved
                $tSQL .= " AND (CRDHD.FTCshStaPrcDoc IS NULL OR CRDHD.FTCshStaPrcDoc = '') AND CRDHD.FTCshStaDoc != 3";
            }
            if($oAdvanceSearch->tSearchStaApprove == "4"){ // N/A Doc status(cancel)
                $tSQL .= " AND (CRDHD.FTCshStaPrcDoc IS NULL OR CRDHD.FTCshStaPrcDoc = '') AND CRDHD.FTCshStaDoc = 3";
            }
            
        }
        if($ptSearchList != ''){
            $tSQL .= " AND (CRDHD.FTBchCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR CRDHD.FTCshDocNo LIKE '%$ptSearchList%')";
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
     * Parameters : $ptCardShiftReturnCode
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMCardShiftReturnCheckDuplicate($ptCardShiftReturnCode){
        $tSQL = "SELECT COUNT(FTCshDocNo) AS counts
                    FROM TFNTCrdShiftHD
                    WHERE FTCshDocNo = '$ptCardShiftReturnCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    /**
     * Functionality : Update Card Shift HD
     * Parameters : $paData is data for update
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftReturnAddUpdateHD($paData){
        try{
            // Update HD
            $this->db->set('FDCshDocDate' , $paData['FDCshDocDate']);
            // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
            $this->db->set('FTCshApvCode' , $paData['FTCshApvCode']);
            $this->db->set('FNCshCardQty' , $paData['FNCshCardQty']);
            
            $this->db->set('FTCshStaDoc' , $paData['FTCshStaDoc']);
            $this->db->set('FNCshStaDocAct' , $paData['FNCshStaDocAct']);
            
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            
            if($paData['FTCshStaPrcDoc'] == "1"){
                $this->db->set('FTCshStaPrcDoc', $paData['FTCshStaPrcDoc']);
            }
            if(!empty($paData['FTCshStaDoc'])){
                $this->db->set('FTCshStaDoc', $paData['FTCshStaDoc']);
            }
            
            $this->db->where('FTCshDocNo' , $paData['FTCshDocNo']);
            $this->db->where('FTCshDocType' , $paData['FTCshDocType']);
            $this->db->update('TFNTCrdShiftHD');
            
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                // Add HD
                $this->db->insert('TFNTCrdShiftHD', array(
                    'FTCshDocNo' => $paData['FTCshDocNo'],
                    'FDCshDocDate' => $paData['FDCshDocDate'],
                    'FTCshDocType'  => $paData['FTCshDocType'],
                    'FTBchCode' => $paData['FTBchCode'],
                    'FTUsrCode' => $paData['FTUsrCode'],
                    'FNCshCardQty'  => $paData['FNCshCardQty'],
                    'FTCshStaDoc'  => $paData['FTCshStaDoc'],
                    'FNCshStaDocAct'  => $paData['FNCshStaDocAct'],
                    'FDCreateOn' => $paData['FDCreateOn'],
                    'FTCreateBy'  => $paData['FTCreateBy']
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

        /**
     * Functionality : Update Card Shift HD
     * Parameters : $paData is data for update
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftReturnUpdateApvDocAndCancelDocHD($paData){
        try{
            // Update HD
            // $this->db->set('FDCshDocDate' , $paData['FDCshDocDate']);
            // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
            // $this->db->set('FTCshApvCode' , $paData['FTCshApvCode']);
            // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
            // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
            // $this->db->set('FNCshCardQty' , $paData['FNCshCardQty']);
            
            // $this->db->set('FTCshStaDoc' , $paData['FTCshStaDoc']);
            // $this->db->set('FNCshStaDocAct' , $paData['FNCshStaDocAct']);
            
            if($paData['FTCshStaPrcDoc'] == "2" && $paData['FTCshStaDoc'] == "1"){
                $this->db->set('FTCshStaPrcDoc', $paData['FTCshStaPrcDoc']);
                $this->db->set('FTCshApvCode', $paData['FTCshApvCode']);
                $this->db->set('FDCshApvDate', $paData['FDCshApvDate']);
            }
            
            if(!empty($paData['FTCshStaDoc']) && empty($paData['FTCshStaPrcDoc'])){
                $this->db->set('FTCshStaDoc', $paData['FTCshStaDoc']);
                $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
                $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            }
            
            $this->db->where('FTCshDocNo' , $paData['FTCshDocNo']);
            $this->db->where('FTCshDocType' , $paData['FTCshDocType']);
            $this->db->update('TFNTCrdShiftHD');
            
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }
    
    /**
     * Functionality : Update Card Shift HD
     * Parameters : $paData is data for update
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftReturnAddUpdateDT($paData){
        try{
            // Add DT
            $this->db->insert('TFNTCrdShiftDT', array(
                'FTBchCode' => $paData['FTBchCode'],
                'FTCshDocNo' => $paData['FTCshDocNo'],
                'FNCsdSeqNo'  => $paData['FNCsdSeqNo'],
                
                'FCCtdCardBal'  => $paData['FCCtdCardBal'],
                'FTCrdStaCrd'  => $paData['FTCrdStaCrd'],
                'FTCrdStaPrc'  => $paData['FTCrdStaPrc'],
                
                'FTCrdCode' => $paData['FTCrdCode'],
                'FTCrdRmk' => $paData['FTCrdRmk'],
                'FDCreateOn' => $paData['FDCreateOn'],
                'FTCreateBy'  => $paData['FTCreateBy'],
                'FDLastUpdOn' => $paData['FDLastUpdOn'],
                'FTLastUpdBy'  => $paData['FTLastUpdBy']
            ));

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }
    
    /**
     * Functionality : Update Card Table
     * Parameters : $paData is data for update
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftReturnUpdateCard($paData){
        try{
            // Update Card
            $this->db->set('FTCrdStaShift' , $paData['FTCrdStaShift']);
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->where('FTCrdCode' , $paData['FTCrdCode']);
            $this->db->where('FTCrdStaType' , $paData['FTCrdStaType']);
            $this->db->update('TFNMCard');
            
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Card',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Update Card.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }
    
    /**
     * Functionality : Delete Customer Group
     * Parameters : $paData
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMCardShiftReturnDel($paData){
        $this->db->where('FTCshDocNo', $paData['FTCshDocNo']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TFNTCrdShiftDT');
        
        $this->db->where('FTCshDocNo', $paData['FTCshDocNo']);
        $this->db->where('FTCshDocType', $paData['FTCshDocType']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TFNTCrdShiftHD');
        
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
    
    /**
     * Functionality : Delete Customer Group
     * Parameters : $paData
     * Creator : 25/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMCardShiftReturnDelDT($paData){
        $this->db->where('FTCshDocNo', $paData['FTCshDocNo']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TFNTCrdShiftDT');
        
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
    
    /**
     * Functionality : Get Card Shift DT
     * Parameters : $paData Filter by DocNo and BchCode
     * Creator : 12/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftReturnGetDTByDocNo($paData){
        $tCardShiftReturnDocNo = $paData['FTCshDocNo'];
        $tCardShiftReturnBchCode = $paData['FTBchCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL = "SELECT
                    CRDDT.FTCshDocNo AS rtCardShiftReturnDocNo,
                    CRDDT.FTBchCode AS rtCardShiftReturnBchCode,
                    CRDDT.FTCshDocNo AS rtCardShiftReturnDocNo,
                    CRDDT.FTCrdCode AS rtCardShiftReturnCrdCode,
                    CRDDT.FCCtdCardBal AS rtCardShiftReturnCardBal,
                    CRDDT.FNCsdSeqNo AS rtCardShiftReturnSeqNo,
                    CRDDT.FTCrdStaCrd AS rtCardShiftReturnStaCrd,
                    CRDDT.FTCrdRmk AS rtCardShiftReturnRmk,
                    CRD.FTCrdStaShift AS rtCardShiftReturnCrdStaShift,
                    CRD.FTCrdStaActive AS rtCardShiftReturnCrdStaActive,
                    CRD.FDCrdExpireDate AS rtCardShiftRetutnCrdExpireDate,
                    CRDL.FTCrdName AS rtCardShiftReturnCrdName
                FROM [TFNTCrdShiftDT] CRDDT
                LEFT JOIN TFNMCard CRD WITH (NOLOCK) ON CRD.FTCrdCode = CRDDT.FTCrdCode 
                LEFT JOIN TFNMCard_L CRDL WITH (NOLOCK) ON CRDL.FTCrdCode = CRDDT.FTCrdCode AND CRDL.FNLngID = $nLngID 
                WHERE 1=1 
                AND CRDDT.FTBchCode = '$tCardShiftReturnBchCode'
                AND CRDDT.FTCshDocNo = '$tCardShiftReturnDocNo'";
        
        $oQuery = $this->db->query($tSQL);
        
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
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
     * Functionality : Get Card Shift DT
     * Parameters : $paData Filter by DocNo and BchCode
     * Creator : 12/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftReturnGetCardOnHD($paData){
        $tSQL = "SELECT
                    CRDDT.FTCshDocNo AS rtCardShiftReturnDocNo,
                    CRDDT.FTBchCode AS rtCardShiftReturnBchCode,
                    CRDDT.FTCshDocNo AS rtCardShiftReturnDocNo,
                    CRDDT.FTCrdCode AS rtCardShiftReturnCrdCode,
                    CRDDT.FCCtdCardBal AS rtCardShiftReturnCardBal,
                    CRDDT.FNCsdSeqNo AS rtCardShiftReturnSeqNo
                FROM [TFNTCrdShiftHD] CRDHD
                RIGHT JOIN [TFNTCrdShiftDT] CRDDT 
                    ON CRDDT.FTCshDocNo = CRDHD.FTCshDocNo 
                WHERE CRDHD.FTCshDocType = '2' 
                AND CRDHD.FTCshStaPrcDoc IS NOT NULL
                AND CRDDT.FTCshDocNo IS NOT NULL";
        $oQuery = $this->db->query($tSQL);
        
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
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
}


