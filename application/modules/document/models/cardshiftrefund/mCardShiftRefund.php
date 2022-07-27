<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCardShiftRefund extends CI_Model {

    /**
     * Functionality : Search UsrDepart By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMCardShiftRefundSearchByID($ptAPIReq, $ptMethodReq, $paData){
        $tCardShiftRefundDocNo = $paData['FTCthDocNo'];
        $nLngID = $paData['FNLngID'];
        $tSQL = "SELECT
                    CRDHD.FTCthDocNo AS rtCardShiftRefundDocNo,
                    CRDHD.FTBchCode AS rtCardShiftRefundBchCode,
                    CRDHD.FTCthDocType AS rtCardShiftRefundDocType,
                    CRDHD.FDCthDocDate AS rtCardShiftRefundDocDate,
                    CRDHD.FTUsrCode AS rtCardShiftRefundUsrCode,
                    CRDHD.FTCthApvCode AS rtCardShiftRefundApvCode,
                    CRDHD.FDCthApvDate AS rtCardShiftRefundApvDate,
                    CRDHD.FCCthTotalQty AS rtCardShiftRefundCardQty,
                    CRDHD.FCCthAmtTP AS rtCardShiftRefundAmtTP,
                    CRDHD.FCCthTotalTP AS rtCardShiftRefundTotalTP,
                    CRDHD.FTCthStaPrcDoc AS rtCardShiftRefundStaPrcDoc,
                    CRDHD.FTCthStaDoc AS rtCardShiftRefundStaDoc,
                    CRDHD.FTCthStaDelMQ AS rtCardShiftRefundStaDelMQ
                FROM [TFNTCrdTopUpHD] CRDHD
                WHERE 1=1";
                $tSQL .= " AND CRDHD.FTCthDocNo = '$tCardShiftRefundDocNo'";
                $tSQL .= " AND CRDHD.FTCthDocType = '5'"; // 5: Refund
        
        /*if($tCardShiftRefundDocNo != ""){
            $tSQL .= "AND CRDHD.FTCthDocNo = '$tCardShiftRefundDocNo'";
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
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftRefundList($ptAPIReq, $ptMethodReq, $paData){
        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $tCardShiftRefundBchCode = $paData['FTBchCode'];
        $tUserLevel = $paData['tUserLevel'];

        $nLngID = $paData['FNLngID'];
        $tSQL = "SELECT c.* FROM(
                    SELECT ROW_NUMBER() OVER(ORDER BY rtCardShiftRefundFDCreateOn DESC) AS rtRowID,*
                    FROM
                        (SELECT DISTINCT
                            CRDHD.FTBchCode AS rtCardShiftRefundBchCode,
                            CRDHD.FTCthDocNo AS rtCardShiftRefundDocNo,
                            CRDHD.FDCthDocDate AS rtCardShiftRefundDocDate,
                            CRDHD.FCCthTotalQty AS rtCardShiftRefundCshCardQty,
                            CRDHD.FTCthStaDoc AS rtCardShiftRefundCshStaDoc,
                            CRDHD.FTCthStaPrcDoc AS rtCardShiftRefundCshStaPrcDoc,
                            CRDHD.FDCreateOn AS rtCardShiftRefundFDCreateOn
                        FROM [TFNTCrdTopUpHD] CRDHD
                        WHERE 1=1";
                        
                        // BchCode is empty = HQ(use all)
                        ($tUserLevel == "HQ") ? "" : $tSQL .= " AND CRDHD.FTBchCode = '$tCardShiftRefundBchCode'";
                        $tSQL .= " AND CRDHD.FTCthDocType = '5'"; // 5: Refund    
        
        $tSearchList = $paData['tSearchAll'];
        $oAdvanceSearch = $paData['tAdvanceSearch'];
        
        if(!empty($oAdvanceSearch->tSearchDocDateFrom) && !empty($oAdvanceSearch->tSearchDocDateTo)){
            $tSQL .= " AND ((CRDHD.FDCthDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:59:59')) OR (CRDHD.FDCthDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00')))";
        }
        if(!empty($oAdvanceSearch->tSearchStaDoc) && ($oAdvanceSearch->tSearchStaDoc != "0")){
            $tSQL .= " AND CRDHD.FTCthStaDoc = '$oAdvanceSearch->tSearchStaDoc'";
        }
        if(!empty($oAdvanceSearch->tSearchStaApprove) && ($oAdvanceSearch->tSearchStaApprove != "0")){
            
            if($oAdvanceSearch->tSearchStaApprove == "1"){ // Approved
                $tSQL .= " AND CRDHD.FTCthStaPrcDoc = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if($oAdvanceSearch->tSearchStaApprove == "2"){ // Approved
                $tSQL .= " AND CRDHD.FTCthStaPrcDoc = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if($oAdvanceSearch->tSearchStaApprove == "3"){ // Pending approved
                $tSQL .= " AND (CRDHD.FTCthStaPrcDoc IS NULL OR CRDHD.FTCthStaPrcDoc = '') AND CRDHD.FTCthStaDoc != 3";
            }
            if($oAdvanceSearch->tSearchStaApprove == "4"){ // N/A Doc status(cancel)
                $tSQL .= " AND (CRDHD.FTCthStaPrcDoc IS NULL OR CRDHD.FTCthStaPrcDoc = '') AND CRDHD.FTCthStaDoc = 3";
            }
            
        }
        if ($tSearchList != ''){
            $tSQL .= " AND (CRDHD.FTBchCode LIKE '%$tSearchList%'";
            $tSQL .= " OR CRDHD.FTCthDocNo LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCardShiftRefundGetPageAll($tSearchList, $paData);
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
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftRefundDataSourceList($paData){
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
                            CRD.FTCrdStaType AS rtCrdStaType,
                            CONVERT(VARCHAR(10),CRD.FDCrdLastTopup,121) AS rtCrdLastTopup
                        FROM [TFNMCard] CRD WITH (NOLOCK)
                        LEFT JOIN TFNMCard_L CRDL WITH (NOLOCK) ON CRD.FTCrdCode = CRDL.FTCrdCode AND CRDL.FNLngID = $nLngID
                        LEFT JOIN TFNMCardType CRDT WITH (NOLOCK) ON CRD.FTCtyCode = CRDT.FTCtyCode
                        LEFT JOIN TFNMCardType_L CRDTL WITH (NOLOCK) ON CRDT.FTCtyCode = CRDTL.FTCtyCode AND CRDTL.FNLngID = $nLngID
                        WHERE 1=1
                        AND CRD.FTCrdStaActive = 1
                        AND (CRD.FTCrdStaType = 1 OR CRD.FTCrdStaType = 2)";
        
        if($tStaType == "1"){ // Approved type
            $tSQL .= " AND (CRD.FTCrdStaShift = '1' OR CRD.FTCrdStaShift = '2')";
        }
        if($tStaType == "2"){ // Cancel type
            $tSQL .= " AND (CRD.FTCrdStaShift = '1' OR CRD.FTCrdStaShift = '2')";
        }
        if($tStaType == "3"){ // Pending type
            $tSQL .= " AND CRD.FTCrdStaShift = $tStaShift";
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
            // $tSQL .= " AND (CardShiftRefund.FTCgpCode LIKE '%$tSearchList%'";
            // $tSQL .= " OR CardShiftRefundL.FTCgpName LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
       
        $oQuery = $this->db->query($tSQL);
        
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSaMCardShiftRefundDataSourceGetPageAll($tSearchList, $nLngID, $paData);
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
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftRefundDataSourceGetPageAll($ptSearchList, $ptLngID, $paData){
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
            // $tSQL .= " AND (CardShiftRefund.FTCgpCode LIKE '%$ptSearchList%'";
            // $tSQL .= " OR CardShiftRefundL.FTCgpName LIKE '%$ptSearchList%')";
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
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMCardShiftRefundGetPageAll($ptSearchList, $paData){
        $tCardShiftRefundBchCode = $paData['FTBchCode'];
        $tSQL = "SELECT COUNT (CRDHD.FTBchCode) AS counts
                FROM [TFNTCrdTopUpHD] CRDHD
                WHERE 1=1";
        
                // BchCode is empty = HQ(use all)
                empty($tCardShiftRefundBchCode) ? "" : $tSQL .= " AND CRDHD.FTBchCode = '$tCardShiftRefundBchCode'";
                $tSQL .= " AND CRDHD.FTCthDocType = '5'"; // 5: Refund
                
        $oAdvanceSearch = $paData['tAdvanceSearch'];
        
        if(!empty($oAdvanceSearch->tSearchDocDateFrom) && !empty($oAdvanceSearch->tSearchDocDateTo)){
            $tSQL .= " AND ((CRDHD.FDCthDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:59:59')) OR (CRDHD.FDCthDocDate BETWEEN CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$oAdvanceSearch->tSearchDocDateFrom 00:00:00')))";
        }
        if(!empty($oAdvanceSearch->tSearchStaDoc) && ($oAdvanceSearch->tSearchStaDoc != "0")){
            $tSQL .= " AND CRDHD.FTCthStaDoc = '$oAdvanceSearch->tSearchStaDoc'";
        }
        if(!empty($oAdvanceSearch->tSearchStaApprove) && ($oAdvanceSearch->tSearchStaApprove != "0")){
            
            if($oAdvanceSearch->tSearchStaApprove == "1"){ // Approved
                $tSQL .= " AND CRDHD.FTCthStaPrcDoc = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if($oAdvanceSearch->tSearchStaApprove == "2"){ // Approved
                $tSQL .= " AND CRDHD.FTCthStaPrcDoc = '$oAdvanceSearch->tSearchStaApprove'";
            }
            if($oAdvanceSearch->tSearchStaApprove == "3"){ // Pending approved
                $tSQL .= " AND (CRDHD.FTCthStaPrcDoc IS NULL OR CRDHD.FTCthStaPrcDoc = '') AND CRDHD.FTCthStaDoc != 3";
            }
            if($oAdvanceSearch->tSearchStaApprove == "4"){ // N/A Doc status(cancel)
                $tSQL .= " AND (CRDHD.FTCthStaPrcDoc IS NULL OR CRDHD.FTCthStaPrcDoc = '') AND CRDHD.FTCthStaDoc = 3";
            }
            
        }        
        if($ptSearchList != ''){
            $tSQL .= " AND (CRDHD.FTBchCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR CRDHD.FTCthDocNo LIKE '%$ptSearchList%')";
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
     * Parameters : $ptCardShiftRefundCode
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMCardShiftRefundCheckDuplicate($ptCardShiftRefundCode){
        $tSQL = "SELECT COUNT(FTCthDocNo) AS counts
                    FROM TFNTCrdTopUpHD
                    WHERE FTCthDocNo = '$ptCardShiftRefundCode'";
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
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftRefundAddUpdateHD($paData){
        try{
            // Update HD
            $this->db->set('FDCthDocDate' , $paData['FDCthDocDate']);
            $this->db->set('FTCthApvCode' , $paData['FTCthApvCode']);
            $this->db->set('FCCthTotalQty' , $paData['FCCthTotalQty']);
            // $this->db->set('FCCthAmtTP' , $paData['FCCthAmtTP']);
            $this->db->set('FCCthTotalTP' , $paData['FCCthTotalTP']);
            $this->db->set('FTCthDocFunc' , $paData['FTCthDocFunc']);
            
            $this->db->set('FTCthStaDoc' , $paData['FTCthStaDoc']);
            $this->db->set('FNCthStaDocAct' , $paData['FNCthStaDocAct']);
            
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            
            if($paData['FTCthStaPrcDoc'] == "1"){
                $this->db->set('FTCthStaPrcDoc', $paData['FTCthStaPrcDoc']);
            }
            if(!empty($paData['FTCthStaDoc'])){
                $this->db->set('FTCthStaDoc', $paData['FTCthStaDoc']);
            }
            $this->db->where('FTCthDocNo' , $paData['FTCthDocNo']);
            $this->db->where('FTCthDocType' , $paData['FTCthDocType']);
            $this->db->update('TFNTCrdTopUpHD');
            
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                // Add HD
                $this->db->insert('TFNTCrdTopUpHD', array(
                    'FTCthDocNo' => $paData['FTCthDocNo'],
                    'FDCthDocDate' => $paData['FDCthDocDate'],
                    'FTCthDocType'  => $paData['FTCthDocType'],
                    'FTCthDocFunc'  => $paData['FTCthDocFunc'],
                    'FTBchCode' => $paData['FTBchCode'],
                    'FTUsrCode' => $paData['FTUsrCode'],
                    'FTUsrName' => $paData['FTUsrName'],
                    'FCCthTotalQty'  => $paData['FCCthTotalQty'],
                    'FCCthTotalTP'  => $paData['FCCthTotalTP'],
                    // 'FCCthAmtTP'  => $paData['FCCthAmtTP'],
                    'FTCthStaDoc'  => $paData['FTCthStaDoc'],
                    'FNCthStaDocAct'  => $paData['FNCthStaDocAct'],
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
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftRefundUpdateApvDocAndCancelDocHD($paData){
        try{
            // Update HD
            // $this->db->set('FDCthDocDate' , $paData['FDCthDocDate']);
            // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
            // $this->db->set('FTCthApvCode' , $paData['FTCthApvCode']);
            // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
            // $this->db->set('FTUsrCode' , $paData['FTUsrCode']);
            // $this->db->set('FCCthTotalQty' , $paData['FCCthTotalQty']);
            
            // $this->db->set('FTCthStaDoc' , $paData['FTCthStaDoc']);
            // $this->db->set('FNCthStaDocAct' , $paData['FNCthStaDocAct']);
            
            if($paData['FTCthStaPrcDoc'] == "2" && $paData['FTCthStaDoc'] == "1"){
                $this->db->set('FTCthStaPrcDoc', $paData['FTCthStaPrcDoc']);
                $this->db->set('FTCthApvCode', $paData['FTCthApvCode']);
                $this->db->set('FDCthApvDate', $paData['FDCthApvDate']);
            }
            
            if(!empty($paData['FTCthStaDoc']) && empty($paData['FTCthStaPrcDoc'])){
                $this->db->set('FTCthStaDoc', $paData['FTCthStaDoc']);
                $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
                $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            }
            
            $this->db->where('FTCthDocNo' , $paData['FTCthDocNo']);
            $this->db->where('FTCthDocType' , $paData['FTCthDocType']);
            $this->db->update('TFNTCrdTopUpHD');
            
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
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftRefundAddUpdateDT($paData){
        try{
            // Add DT
            $this->db->insert('TFNTCrdTopUpDT', array(
                'FTBchCode' => $paData['FTBchCode'],
                'FTCthDocNo' => $paData['FTCthDocNo'],
                'FNCtdSeqNo'  => $paData['FNCtdSeqNo'],
                'FTCrdCode' => $paData['FTCrdCode'],
                'FCCtdCrdTP' => $paData['FCCtdCrdTP'],
                'FTCtdStaCrd'  => $paData['FTCtdStaCrd'],
                'FTCtdStaPrc'  => $paData['FTCtdStaPrc'],
                'FTCtdRmk' => $paData['FTCtdRmk'],
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
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCardShiftRefundUpdateCard($paData){
        try{
            // Update Card
            $this->db->set('FCCrdValue' , $paData['FCCrdValue']);
            $this->db->set('FDCrdLastTopup' , $paData['FDCrdLastTopup']);
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
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMCardShiftRefundDel($paData){
        $this->db->where('FTCthDocNo', $paData['FTCthDocNo']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TFNTCrdTopUpDT');
        
        $this->db->where('FTCthDocNo', $paData['FTCthDocNo']);
        $this->db->where('FTCthDocType', $paData['FTCthDocType']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TFNTCrdTopUpHD');
        
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
     * Creator : 30/10/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMCardShiftRefundDelDT($paData){
        $this->db->where('FTCthDocNo', $paData['FTCthDocNo']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TFNTCrdTopUpDT');
        
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
    public function FSaMCardShiftRefundGetDTByDocNo($paData){
        $tCardShiftRefundDocNo = $paData['FTCthDocNo'];
        $tCardShiftRefundBchCode = $paData['FTBchCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL = "SELECT
                    CRDDT.FTCthDocNo AS rtCardShiftRefundDocNo,
                    CRDDT.FTBchCode AS rtCardShiftRefundBchCode,
                    CRDDT.FTCrdCode AS rtCardShiftRefundCrdCode,
                    CRDDT.FNCtdSeqNo AS rtCardShiftRefundSeqNo,
                    CRDDT.FTCtdStaCrd AS rtCardShiftRefundStaCrd,
                    CRDDT.FCCtdCrdTP AS rtCardShiftRefundCrdTP,
                    CRDDT.FCCtdCrdTP AS rtCardShiftRefundCrdValue,
                    CRDDT.FTCtdRmk AS rtCardShiftRefundRmk,
                    CRD.FTCrdStaShift AS rtCardShiftRefundCrdStaShift,
                    CRD.FTCrdStaActive AS rtCardShiftRefundCrdStaActive,
                    CRD.FTCrdStaType AS rtCardShiftRefundCrdStaType,
                    CRD.FDCrdExpireDate AS rtCardShiftRefundCrdExpireDate,
                    CRDL.FTCrdName AS rtCardShiftRefundCrdName
                FROM [TFNTCrdTopUpDT] CRDDT
                LEFT JOIN TFNMCard CRD WITH (NOLOCK) ON CRD.FTCrdCode = CRDDT.FTCrdCode
                LEFT JOIN TFNMCard_L CRDL WITH (NOLOCK) ON CRDL.FTCrdCode = CRDDT.FTCrdCode AND CRDL.FNLngID = $nLngID 
                WHERE 1=1 
                AND CRDDT.FTBchCode = '$tCardShiftRefundBchCode'
                AND CRDDT.FTCthDocNo = '$tCardShiftRefundDocNo'";
        
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
     * Functionality : Get Card Shift
     * Parameters : $paData Filter by DocNo and BchCode
     * Creator : 12/10/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCardShiftRefundGetCardById($paData){
        $tCardShiftRefundCardCode = $paData['FTCrdCode'];
        $tSQL = "SELECT
                    CRD.FTCrdCode AS rtCardShiftRefundCrdCode,
                    CRD.FDCrdLastTopup AS rtCardShiftRefundLastTopup,
                    CRD.FCCrdValue AS rtCardShiftRefundCrdValue,
                    CRD.FTCrdStaType AS rtCardShiftRefundStaType,
                    CRD.FTCrdStaShift AS rtCardShiftRefundStaShift,
                    CRD.FTCrdStaActive AS rtCardShiftRefundStaActive
                FROM [TFNMCard] CRD WITH (NOLOCK)
                WHERE 1=1
                AND CRD.FTCrdStaActive = 1
                AND CRD.FTCrdStaType = 1
                AND CRD.FTCrdCode = '$tCardShiftRefundCardCode'";
        
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
}




