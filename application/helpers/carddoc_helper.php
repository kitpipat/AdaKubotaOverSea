<?php

/**
* Functionality : Insert Helper Center
* Parameters : $ptDocType, $ptDataSetType, $paDataExcel, $paDataSet
* Creator : 3/1/2019 piya
* Last Modified : -
* Return : Status
* Return Type : array
*/
function FCNaCARDInsertDataToTemp($ptDocType, $ptDataSetType, $paDataExcel, $paDataSet) {
    
    // echo $ci->session->userdata("tSesSessionID");
    // ptDocType     = ชื่อหน้า
    // ptDataSetType = ชื่อ sheet 
    // paDataExcel   = data array excel
    // paDataSet     = xxx

    require_once (APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php');
    require_once (APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php');
    require_once (APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

    switch ($ptDataSetType) {
        case 'Excel': {// Excel - เหตุผล - option - มูลค่าที่เติม 
            FSaCCARTypeExcel($ptDocType, $ptDataSetType, $paDataExcel);
            break;
        }
        case 'CreateCard': {// New Card - รหัสบัตร - ประเภทบัตร - หน่วยงาน
            FSxInsertNewCardByCardCode($ptDataSetType, $paDataSet);
            break;
        }
        case 'CreateCardBetween': {// New Card Between - การ์ดโค๊ด - prefix - เลขเริ่มต้น - จำนวนที่ต้องการสร้างบัตร - ประเภทบัตร - หน่วยงาน
            FSxInsertNewCardByBetween($ptDataSetType, $paDataSet);
            break;
        }
        case 'Between': {// Between - มูลค่าที่เติม - ประเภทบัตรแบบช่วง - การ์ดรหัสแบบช่วง
            FSxInsertByBetween($ptDocType, $ptDataSetType, $paDataSet);
            break;
        }
        case 'ChooseCard': {// Chooset Card - รหัสบัตร - มูลค่า - รหัสบัตรใหม่(อาจเป็นค่าว่าง) 
            FSxInsertByChoose($ptDocType, $ptDataSetType, $paDataSet);
            break;
        }
    }
}

/**
 * Functionality : Insert new card by card code
 * Parameters : $ptDataSetType, $paDataSet
 * Creator : 3/1/2019 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function FSxInsertNewCardByCardCode($ptDataSetType, $paDataSet) {
    $ci = &get_instance();
    $ci->load->database();
    
    $tBchCode = $paDataSet["tBchCode"];
    $tDocNo = $paDataSet["tDocNo"];
    $tNewCardCode = $paDataSet["tNewCardCode"];
    $tCardTypeCode = $paDataSet["tCardTypeCode"];
    $tDptCode = $paDataSet['tDptCode'];
    $tDptName = $paDataSet['tDptName'];
    $tCreateOn = date("Y-m-d H:i:s");
    $tCreateBy = $paDataSet["tCreateBy"];
    $tSessionID = $ci->session->userdata("tSesSessionID");

    $tSQL = "INSERT INTO TFNTCrdImpTmp(
                FTBchCode, 
                FTCihDocNo, 
                FNCidSeqNo, 
                FTCidCrdCode, 
                FCCvdOldBal, 
                FTCidCrdRef, 
                FTCtyCode, 
                FTCidCrdName, 
                FTCidCrdHolderID, 
                FTCidCrdDepart, 
                FTCidStaCrd, 
                FTCidStaPrc, 
                FTCidRmk, 
                FDCreateOn, 
                FTCreateBy, 
                FTSessionID)
            VALUES (
                '$tBchCode', 
                '$tDocNo',
                (SELECT ISNULL(MAX(FNCidSeqNo), 0) FROM TFNTCrdImpTmp WHERE FTSessionID = '$tSessionID') + 1,
                '$tNewCardCode',
                null,
                null,
                '$tCardTypeCode',
                null,
                null,
                '$tDptName',
                '1',
                null,
                null,
                '$tCreateOn',
                '$tCreateBy',
                '$tSessionID'
            )";

    $oQuery = $ci->db->query($tSQL);
}

/**
 * Functionality : Insert new card by between
 * Parameters : $ptDataSetType, $paDataSet
 * Creator : 3/1/2019 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function FSxInsertNewCardByBetween($ptDataSetType, $paDataSet) {
    $ci = &get_instance();
    $ci->load->database();
    
    $tBchCode = $paDataSet["tBchCode"];
    $tDocNo = $paDataSet["tDocNo"];
    $tPrefixCode = $paDataSet["tPrefixCode"];
    $tBeginCode = $paDataSet["tBeginCode"];
    $nCardLoop = $paDataSet["nCardLoop"];
    $tCardTypeCode = $paDataSet["tCardTypeCode"];
    $tDptCode = $paDataSet['tDptCode'];
    $tDptName = $paDataSet['tDptName'];
    $tCreateOn = date("Y-m-d H:i:s");
    $tCreateBy = $paDataSet["tCreateBy"];
    $tSessionID = $ci->session->userdata("tSesSessionID");

    $nBeginNumber = intval($tBeginCode);
    $nBeginNumberLength = strlen($tBeginCode);

    $tSQL = "INSERT INTO TFNTCrdImpTmp(
                FTBchCode, 
                FTCihDocNo, 
                FNCidSeqNo, 
                FTCidCrdCode, 
                FCCvdOldBal, 
                FTCidCrdRef, 
                FTCtyCode, 
                FTCidCrdName, 
                FTCidCrdHolderID, 
                FTCidCrdDepart, 
                FTCidStaCrd, 
                FTCidStaPrc, 
                FTCidRmk, 
                FDCreateOn, 
                FTCreateBy, 
                FTSessionID) 
                VALUES ";
    
    $tPrefix = $tPrefixCode;
    $tComma = ",";
    
    for($nLoop = 0; $nLoop < $nCardLoop; $nLoop++){

        $nPreZero = str_pad($nBeginNumber, $nBeginNumberLength, "0", STR_PAD_LEFT);
        $tNewCardCode = $tPrefix . $nPreZero;

        $nBeginNumber++;
        if(($nLoop + 1) == $nCardLoop){$tComma = "";} // Last loop check
        
        $tSQL .= "(
                '$tBchCode', 
                '$tDocNo',
                ($nLoop + 1) + (SELECT ISNULL(MAX(FNCidSeqNo), 0) FROM TFNTCrdImpTmp WHERE FTSessionID = '$tSessionID'),
                '$tNewCardCode',
                null,
                null,
                '$tCardTypeCode',
                null,
                null,
                '$tDptName',
                '1',
                null,
                null,
                '$tCreateOn',
                '$tCreateBy',
                '$tSessionID'
            )$tComma ";
    }
    // $tSQL .= " WHERE FTCidCrdCode NOT EXISTS ( SELECT FTCidCrdCode FROM TFNTCrdImpTmp WHERE FTSessionID = '$tSessionID' ) ";
    $oQuery = $ci->db->query($tSQL);
}

/**
 * Functionality : Insert card to temp by between
 * Parameters : $ptDocType, $ptDataSetType, $paDataSet
 * Creator : 3/1/2019 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function FSxInsertByBetween($ptDocType, $ptDataSetType, $paDataSet) {
    $ci = &get_instance();
    $ci->load->database();
    $tSessionID = $ci->session->userdata("tSesSessionID");
    
    switch ($ptDocType) {
        case 'cardShiftOut' : {
            $tBchCode = $paDataSet["tBchCode"];
            $tCreateOn = date("Y-m-d H:i:s");
            $tCreateBy = $paDataSet["tCreateBy"];
            $tDocNo = $paDataSet["tDocNo"];
            
            $tWhereCardCode = "";
            $tWhereCardType = "";
            
            if(!empty($paDataSet["aCardCode"])){
                $tCardCodeFrom = $paDataSet["aCardCode"][0];
                $tCardCodeTo = $paDataSet["aCardCode"][1];
                $tWhereCardCode = " AND ((FTCrdCode BETWEEN '$tCardCodeFrom' AND '$tCardCodeTo') OR (FTCrdCode BETWEEN '$tCardCodeTo' AND '$tCardCodeFrom')) ";
            }
            if(!empty($paDataSet["aCardType"])){
                $tCardTypeFrom = $paDataSet["aCardType"][0];
                $tCardTypeTo = $paDataSet["aCardType"][1];
                $tWhereCardType = " AND ((FTCtyCode BETWEEN '$tCardTypeFrom' AND '$tCardTypeTo') OR (FTCrdCode BETWEEN '$tCardTypeTo' AND '$tCardTypeFrom')) ";
            }

            $tSQL = "INSERT INTO TFNTCrdShiftTmp(FTBchCode, FTCshDocNo, FNCsdSeqNo, FTCrdCode, FCCtdCardBal, FTCrdStaCrd, FTCrdStaPrc, FTCrdRmk, FDCreateOn, FTCreateBy, FTSessionID)

                SELECT 
                    '$tBchCode' AS FTBchCode,
                    '$tDocNo' AS FTCshDocNo,
                    ROW_NUMBER() OVER(ORDER BY CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNCsdSeqNo), 0) FROM TFNTCrdShiftTmp WHERE FTSessionID = '$tSessionID') AS FNCsdSeqNo,
                    CRD.FTCrdCode AS FTCrdCode,
                    CRD.FCCrdValue AS FCCtdCardBal,
                    '1' AS FTCrdStaCrd,
                    null AS FTCrdStaPrc,
                    null AS FTCrdRmk,
                    '$tCreateOn' AS FDCreateOn,
                    '$tCreateBy' AS FTCreateBy,
                    '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            FTCrdCode, FCCrdValue
                            FROM TFNMCard WITH (NOLOCK) WHERE 1=1 AND ( ( (TFNMCard.FTCrdStaType = 1) AND (TFNMCard.FTCrdStaShift = 1) ) AND (TFNMCard.FTCrdStaActive = 1) AND (CONVERT(datetime, TFNMCard.FDCrdExpireDate) > CONVERT(datetime, GETDATE())) )
                            AND ( FTCrdCode NOT IN (SELECT FTCrdCode FROM TFNTCrdShiftTmp WHERE FTSessionID = '$tSessionID') )
                            $tWhereCardCode $tWhereCardType
                        ) CRD";

            $oQuery = $ci->db->query($tSQL);
            break;
        }
        case 'cardShiftReturn' : {
            $tBchCode = $paDataSet["tBchCode"];
            $tCreateOn = date("Y-m-d H:i:s");
            $tCreateBy = $paDataSet["tCreateBy"];
            $tDocNo = $paDataSet["tDocNo"];
            
            $tWhereCardCode = "";
            $tWhereCardType = "";
            
            if(!empty($paDataSet["aCardCode"])){
                $tCardCodeFrom = $paDataSet["aCardCode"][0];
                $tCardCodeTo = $paDataSet["aCardCode"][1];
                $tWhereCardCode = " AND ((FTCrdCode BETWEEN '$tCardCodeFrom' AND '$tCardCodeTo') OR (FTCrdCode BETWEEN '$tCardCodeTo' AND '$tCardCodeFrom')) ";
            }
            if(!empty($paDataSet["aCardType"])){
                $tCardTypeFrom = $paDataSet["aCardType"][0];
                $tCardTypeTo = $paDataSet["aCardType"][1];
                $tWhereCardType = " AND ((FTCtyCode BETWEEN '$tCardTypeFrom' AND '$tCardTypeTo') OR (FTCrdCode BETWEEN '$tCardTypeTo' AND '$tCardTypeFrom')) ";
            }

            $tSQL = "INSERT INTO TFNTCrdShiftTmp(FTBchCode, FTCshDocNo, FNCsdSeqNo, FTCrdCode, FCCtdCardBal, FTCrdStaCrd, FTCrdStaPrc, FTCrdRmk, FDCreateOn, FTCreateBy, FTSessionID)

                SELECT 
                    '$tBchCode' AS FTBchCode,
                    '$tDocNo' AS FTCshDocNo,
                    ROW_NUMBER() OVER(ORDER BY CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNCsdSeqNo), 0) FROM TFNTCrdShiftTmp WHERE FTSessionID = '$tSessionID') AS FNCsdSeqNo,
                    CRD.FTCrdCode AS FTCrdCode,
                    CRD.FCCrdValue AS FCCtdCardBal,
                    '1' AS FTCrdStaCrd,
                    null AS FTCrdStaPrc,
                    null AS FTCrdRmk,
                    '$tCreateOn' AS FDCreateOn,
                    '$tCreateBy' AS FTCreateBy,
                    '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            FTCrdCode, FCCrdValue
                            FROM TFNMCard WITH (NOLOCK) WHERE 1=1 AND ( ((FTCrdStaType = 1) AND (FTCrdStaShift = 2)) )
                            AND ( FTCrdCode NOT IN (SELECT FTCrdCode FROM TFNTCrdShiftTmp WHERE FTSessionID = '$tSessionID') )
                            $tWhereCardCode $tWhereCardType
                        ) CRD";

            $oQuery = $ci->db->query($tSQL);
            break;
        }
        case 'cardShiftTopUp' : {
            $tBchCode = $paDataSet["tBchCode"];
            $tCtdCrdTP = $paDataSet["tCtdCrdTP"];
            $tCreateOn = date("Y-m-d H:i:s");
            $tCreateBy = $paDataSet["tCreateBy"];
            $tDocNo = $paDataSet["tDocNo"];
            
            $tWhereCardCode = "";
            $tWhereCardType = "";
            
            if(!empty($paDataSet["aCardCode"])){
                $tCardCodeFrom = $paDataSet["aCardCode"][0];
                $tCardCodeTo = $paDataSet["aCardCode"][1];
                $tWhereCardCode = " AND ((FTCrdCode BETWEEN '$tCardCodeFrom' AND '$tCardCodeTo') OR (FTCrdCode BETWEEN '$tCardCodeTo' AND '$tCardCodeFrom')) ";
            }
            if(!empty($paDataSet["aCardType"])){
                $tCardTypeFrom = $paDataSet["aCardType"][0];
                $tCardTypeTo = $paDataSet["aCardType"][1];
                $tWhereCardType = " AND ((FTCtyCode BETWEEN '$tCardTypeFrom' AND '$tCardTypeTo') OR (FTCrdCode BETWEEN '$tCardTypeTo' AND '$tCardTypeFrom')) ";
            }

            $tSQL = "INSERT INTO TFNTCrdTopUpTmp(FTBchCode, FTCthDocNo, FNCtdSeqNo, FTCrdCode, FCCtdCrdTP, FTCtdStaCrd, FTCtdStaPrc, FTCtdRmk, FDCreateOn, FTCreateBy, FTSessionID)

                SELECT 
                    '$tBchCode' AS FTBchCode,
                    '$tDocNo' AS FTCthDocNo,
                    ROW_NUMBER() OVER(ORDER BY  CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNCtdSeqNo), 0) FROM TFNTCrdTopUpTmp WHERE FTSessionID = '$tSessionID') AS FNCtdSeqNo,
                    CRD.FTCrdCode AS FTCrdCode,
                    CONVERT(DECIMAL(18,4),REPLACE(ISNULL('$tCtdCrdTP', 0), ',', '')) AS FCCtdCrdTP,
                    '1' AS FTCtdStaCrd,
                    null AS FTCtdStaPrc,
                    null AS FTCtdRmk,
                    '$tCreateOn' AS FDCreateOn,
                    '$tCreateBy' AS FTCreateBy,
                    '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            FTCrdCode
                            FROM TFNMCard WITH (NOLOCK) WHERE 1=1 AND ( FTCrdStaActive = 1 AND ((FTCrdStaShift = 2 AND FTCrdStaType = 1) OR FTCrdStaType = 2) AND ( CONVERT(datetime, FDCrdExpireDate) > CONVERT(datetime, GETDATE()) ) )
                            AND ( FTCrdCode NOT IN (SELECT FTCrdCode FROM TFNTCrdTopUpTmp WHERE FTSessionID = '$tSessionID') )
                            $tWhereCardCode $tWhereCardType
                        ) CRD";

            $oQuery = $ci->db->query($tSQL);
            break;
        }
        case 'cardShiftRefund' : {
            $tBchCode = $paDataSet["tBchCode"];
            $tCreateOn = date("Y-m-d H:i:s");
            $tCreateBy = $paDataSet["tCreateBy"];
            $tDocNo = $paDataSet["tDocNo"];

            $tWhereCardCode = "";
            $tWhereCardType = "";
            
            if(!empty($paDataSet["aCardCode"])){
                $tCardCodeFrom = $paDataSet["aCardCode"][0];
                $tCardCodeTo = $paDataSet["aCardCode"][1];
                $tWhereCardCode = " AND ((FTCrdCode BETWEEN '$tCardCodeFrom' AND '$tCardCodeTo') OR (FTCrdCode BETWEEN '$tCardCodeTo' AND '$tCardCodeFrom')) ";
            }
            if(!empty($paDataSet["aCardType"])){
                $tCardTypeFrom = $paDataSet["aCardType"][0];
                $tCardTypeTo = $paDataSet["aCardType"][1];
                $tWhereCardType = " AND ((FTCtyCode BETWEEN '$tCardTypeFrom' AND '$tCardTypeTo') OR (FTCrdCode BETWEEN '$tCardTypeTo' AND '$tCardTypeFrom')) ";
            }
            
            $tSQL = "INSERT INTO TFNTCrdTopUpTmp(FTBchCode, FTCthDocNo, FNCtdSeqNo, FTCrdCode, FCCtdCrdTP, FTCtdStaCrd, FTCtdStaPrc, FTCtdRmk, FDCreateOn, FTCreateBy, FTSessionID)

                SELECT 
                    '$tBchCode' AS FTBchCode,
                    '$tDocNo' AS FTCthDocNo,
                    ROW_NUMBER() OVER(ORDER BY CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNCtdSeqNo), 0) FROM TFNTCrdTopUpTmp WHERE FTSessionID = '$tSessionID') AS FNCtdSeqNo,
                    CRD.FTCrdCode AS FTCrdCode,
                    CRD.FCCrdValue AS FCCtdCrdTP,
                    '1' AS FTCtdStaCrd,
                    null AS FTCtdStaPrc,
                    null AS FTCtdRmk,
                    '$tCreateOn' AS FDCreateOn,
                    '$tCreateBy' AS FTCreateBy,
                    '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            FTCrdCode,
                            FCCrdValue
                            FROM TFNMCard WITH (NOLOCK) WHERE 1=1 AND ( (FCCrdValue > 0 AND FCCrdValue IS NOT NULL) AND (FTCrdStaActive = 1) AND (FTCrdStaShift = 2 OR FTCrdStaType = 2) )
                            AND ( FTCrdCode NOT IN (SELECT FTCrdCode FROM TFNTCrdTopUpTmp WHERE FTSessionID = '$tSessionID') )
                            $tWhereCardCode $tWhereCardType
                        ) CRD";

            $oQuery = $ci->db->query($tSQL);
            break;
        }
        case 'cardShiftStatus' : {
            $tBchCode = $paDataSet["tBchCode"];
            $tCreateOn = date("Y-m-d H:i:s");
            $tCreateBy = $paDataSet["tCreateBy"];
            $tDocNo = $paDataSet["tDocNo"];
            
            $tWhereCardCode = "";
            $tWhereCardType = "";
            
            if(!empty($paDataSet["aCardCode"])){
                $tCardCodeFrom = $paDataSet["aCardCode"][0];
                $tCardCodeTo = $paDataSet["aCardCode"][1];
                $tWhereCardCode = " AND ((FTCrdCode BETWEEN '$tCardCodeFrom' AND '$tCardCodeTo') OR (FTCrdCode BETWEEN '$tCardCodeTo' AND '$tCardCodeFrom')) ";
            }
            if(!empty($paDataSet["aCardType"])){
                $tCardTypeFrom = $paDataSet["aCardType"][0];
                $tCardTypeTo = $paDataSet["aCardType"][1];
                $tWhereCardType = " AND ((FTCtyCode BETWEEN '$tCardTypeFrom' AND '$tCardTypeTo') OR (FTCrdCode BETWEEN '$tCardTypeTo' AND '$tCardTypeFrom')) ";
            }

            $tSQL = "INSERT INTO TFNTCrdVoidTmp(FTBchCode, FTCvhDocNo, FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDCreateOn, FTCreateBy, FTSessionID)

                SELECT 
                    '$tBchCode' AS FTBchCode,
                    '$tDocNo' AS FTCvhDocNo,
                    ROW_NUMBER() OVER(ORDER BY CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNCvdSeqNo), 0) FROM TFNTCrdVoidTmp WHERE FTSessionID = '$tSessionID') AS FNCvdSeqNo,
                    CRD.FTCrdCode AS FTCvdOldCode,
                    CRD.FCCrdValue AS FCCvdOldBal,
                    null AS FTCvdNewCode,
                    '1' AS FTCvdStaCrd,
                    null AS FTCvdStaPrc,
                    null AS FTCvdRmk,
                    null AS FTRsnCode,
                    '$tCreateOn' AS FDCreateOn,
                    '$tCreateBy' AS FTCreateBy,
                    '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            FTCrdCode,
                            FCCrdValue
                            FROM TFNMCard WITH (NOLOCK) WHERE 1=1
                            AND ( FTCrdCode NOT IN (SELECT FTCrdCode FROM TFNTCrdVoidTmp WHERE FTSessionID = '$tSessionID') )
                            $tWhereCardCode $tWhereCardType
                        ) CRD";

            $oQuery = $ci->db->query($tSQL);
            break;
        }
        case 'cardShiftChange' : {
            $tBchCode = $paDataSet["tBchCode"];
            $tCvdOldCode = implode(",", $paDataSet["aOldCardCode"]);
            $tCvdNewCode = implode(",", $paDataSet["aNewCardCode"]);
            $tRsnCode = $paDataSet["tReasonCode"];
            $tCreateOn = date("Y-m-d H:i:s");
            $tCreateBy = $paDataSet["tCreateBy"];
            $tDocNo = $paDataSet["tDocNo"];
            $tSessionID = $ci->session->userdata("tSesSessionID");

            $tSQL = "INSERT INTO TFNTCrdVoidTmp(FTBchCode, FTCvhDocNo, FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDCreateOn, FTCreateBy, FTSessionID)

                SELECT 
                    '$tBchCode' AS FTBchCode,
                    '$tDocNo' AS FTCvhDocNo,
                    ROW_NUMBER() OVER(ORDER BY OLDCRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNCvdSeqNo), 0) FROM TFNTCrdVoidTmp WHERE FTSessionID = '$tSessionID') AS FNCvdSeqNo,
                    OLDCRD.FTCrdCode AS FTCvdOldCode,
                    OLDCRD.FCCrdValue AS FCCvdOldBal,
                    NEWCRD.FTCrdCode AS FTCvdNewCode,
                    '1' AS FTCvdStaCrd,
                    null AS FTCvdStaPrc,
                    null AS FTCvdRmk,
                    '$tRsnCode' AS FTRsnCode,
                    '$tCreateOn' AS FDCreateOn,
                    '$tCreateBy' AS FTCreateBy,
                    '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            FTCrdCode, FTCrdHolderID, FCCrdValue
                            FROM TFNMCard WITH (NOLOCK) WHERE FTCrdCode IN ($tCvdOldCode)
                        ) OLDCRD
                LEFT JOIN (
                     SELECT FTCrdCode, FTCrdHolderID FROM TFNMCard WITH (NOLOCK) WHERE FTCrdCode IN ($tCvdNewCode)
                ) NEWCRD
                ON OLDCRD.FTCrdHolderID = NEWCRD.FTCrdHolderID";

            $oQuery = $ci->db->query($tSQL);

            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
    }
}

/**
 * Functionality : Insert card to temp by choose
 * Parameters : $ptDocType, $ptDataSetType, $paDataSet
 * Creator : 3/1/2019 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function FSxInsertByChoose($ptDocType, $ptDataSetType, $paDataSet) {
    $ci = &get_instance();
    $ci->load->database();
    $tSessionID = $ci->session->userdata("tSesSessionID");
    
    switch ($ptDocType) {
        case 'cardShiftOut' : {
                $tBchCode = $paDataSet["tBchCode"];
                $tCrdCode = implode(",", $paDataSet["aCardCode"]);
                $tCreateOn = date("Y-m-d H:i:s");
                $tCreateBy = $paDataSet["tCreateBy"];
                $tDocNo = $paDataSet["tDocNo"];
                
                $tSQL = "INSERT INTO TFNTCrdShiftTmp(FTBchCode, FTCshDocNo, FNCsdSeqNo, FTCrdCode, FCCtdCardBal, FTCrdStaCrd, FTCrdStaPrc, FTCrdRmk, FDCreateOn, FTCreateBy, FTSessionID)

                    SELECT 
                        '$tBchCode' AS FTBchCode,
                        '$tDocNo' AS FTCshDocNo,
                        ROW_NUMBER() OVER(ORDER BY CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNCsdSeqNo), 0) FROM TFNTCrdShiftTmp WHERE FTSessionID = '$tSessionID') AS FNCsdSeqNo,
                        CRD.FTCrdCode AS FTCrdCode,
                        CRD.FCCrdValue AS FCCtdCardBal,
                        '1' AS FTCrdStaCrd,
                        null AS FTCrdStaPrc,
                        null AS FTCrdRmk,
                        '$tCreateOn' AS FDCreateOn,
                        '$tCreateBy' AS FTCreateBy,
                        '$tSessionID' AS FTSessionID
                        FROM(
                            SELECT
                                FTCrdCode, FCCrdValue
                                FROM TFNMCard WITH (NOLOCK) WHERE FTCrdCode IN ($tCrdCode)
                            ) CRD";

                $oQuery = $ci->db->query($tSQL);
                break;
            }
        case 'cardShiftReturn' : {
            $tBchCode = $paDataSet["tBchCode"];
            $tCrdCode = implode(",", $paDataSet["aCardCode"]);
            $tCreateOn = date("Y-m-d H:i:s");
            $tCreateBy = $paDataSet["tCreateBy"];
            $tDocNo = $paDataSet["tDocNo"];

            $tSQL = "INSERT INTO TFNTCrdShiftTmp(FTBchCode, FTCshDocNo, FNCsdSeqNo, FTCrdCode, FCCtdCardBal, FTCrdStaCrd, FTCrdStaPrc, FTCrdRmk, FDCreateOn, FTCreateBy, FTSessionID)

                SELECT 
                    '$tBchCode' AS FTBchCode,
                    '$tDocNo' AS FTCshDocNo,
                    ROW_NUMBER() OVER(ORDER BY CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNCsdSeqNo), 0) FROM TFNTCrdShiftTmp WHERE FTSessionID = '$tSessionID') AS FNCsdSeqNo,
                    CRD.FTCrdCode AS FTCrdCode,
                    CRD.FCCrdValue AS FCCtdCardBal,
                    '1' AS FTCrdStaCrd,
                    null AS FTCrdStaPrc,
                    null AS FTCrdRmk,
                    '$tCreateOn' AS FDCreateOn,
                    '$tCreateBy' AS FTCreateBy,
                    '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            FTCrdCode, FCCrdValue
                            FROM TFNMCard WITH (NOLOCK) WHERE FTCrdCode IN ($tCrdCode)
                        ) CRD";

            $oQuery = $ci->db->query($tSQL);
            break;
        }
        case 'cardShiftTopUp' : {
            $tBchCode = $paDataSet["tBchCode"];
            $tCtdCrdTP = $paDataSet["tCtdCrdTP"];
            $tCrdCode = implode(",", $paDataSet["aCardCode"]);
            $tCreateOn = date("Y-m-d H:i:s");
            $tCreateBy = $paDataSet["tCreateBy"];
            $tDocNo = $paDataSet["tDocNo"];

            $tSQL = "INSERT INTO TFNTCrdTopUpTmp(FTBchCode, FTCthDocNo, FNCtdSeqNo, FTCrdCode, FCCtdCrdTP, FTCtdStaCrd, FTCtdStaPrc, FTCtdRmk, FDCreateOn, FTCreateBy, FTSessionID)

                SELECT 
                    '$tBchCode' AS FTBchCode,
                    '$tDocNo' AS FTCthDocNo,
                    ROW_NUMBER() OVER(ORDER BY CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNCtdSeqNo), 0) FROM TFNTCrdTopUpTmp WHERE FTSessionID = '$tSessionID') AS FNCtdSeqNo,
                    CRD.FTCrdCode AS FTCrdCode,
                    CONVERT(DECIMAL(18,4),REPLACE(ISNULL('$tCtdCrdTP', 0), ',', '')) AS FCCtdCrdTP,
                    '1' AS FTCtdStaCrd,
                    null AS FTCtdStaPrc,
                    null AS FTCtdRmk,
                    '$tCreateOn' AS FDCreateOn,
                    '$tCreateBy' AS FTCreateBy,
                    '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            FTCrdCode
                            FROM TFNMCard WITH (NOLOCK) WHERE FTCrdCode IN ($tCrdCode)
                        ) CRD";

            $oQuery = $ci->db->query($tSQL);
            break;
        }
        case 'cardShiftRefund' : {
            $tBchCode = $paDataSet["tBchCode"];
            $tCrdCode = implode(",", $paDataSet["aCardCode"]);
            $tCreateOn = date("Y-m-d H:i:s");
            $tCreateBy = $paDataSet["tCreateBy"];
            $tDocNo = $paDataSet["tDocNo"];

            $tSQL = "INSERT INTO TFNTCrdTopUpTmp(FTBchCode, FTCthDocNo, FNCtdSeqNo, FTCrdCode, FCCtdCrdTP, FTCtdStaCrd, FTCtdStaPrc, FTCtdRmk, FDCreateOn, FTCreateBy, FTSessionID)

                SELECT 
                    '$tBchCode' AS FTBchCode,
                    '$tDocNo' AS FTCthDocNo,
                    ROW_NUMBER() OVER(ORDER BY CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNCtdSeqNo), 0) FROM TFNTCrdTopUpTmp WHERE FTSessionID = '$tSessionID') AS FNCtdSeqNo,
                    CRD.FTCrdCode AS FTCrdCode,
                    CRD.FCCrdValue AS FCCtdCrdTP,
                    '1' AS FTCtdStaCrd,
                    null AS FTCtdStaPrc,
                    null AS FTCtdRmk,
                    '$tCreateOn' AS FDCreateOn,
                    '$tCreateBy' AS FTCreateBy,
                    '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            FTCrdCode,
                            FCCrdValue
                            FROM TFNMCard WITH (NOLOCK) WHERE FTCrdCode IN ($tCrdCode)
                        ) CRD";
            echo $tSQL;
            $oQuery = $ci->db->query($tSQL);
            break;
        }
        case 'cardShiftStatus' : {
            $tBchCode = $paDataSet["tBchCode"];
            $tCvdOldCode = implode(",", $paDataSet["aCardCode"]);
            $tCreateOn = date("Y-m-d H:i:s");
            $tCreateBy = $paDataSet["tCreateBy"];
            $tDocNo = $paDataSet["tDocNo"];

            $tSQL = "INSERT INTO TFNTCrdVoidTmp(FTBchCode, FTCvhDocNo, FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDCreateOn, FTCreateBy, FTSessionID)

                SELECT 
                    '$tBchCode' AS FTBchCode,
                    '$tDocNo' AS FTCvhDocNo,
                    ROW_NUMBER() OVER(ORDER BY CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNCvdSeqNo), 0) FROM TFNTCrdVoidTmp WHERE FTSessionID = '$tSessionID') AS FNCvdSeqNo,
                    CRD.FTCrdCode AS FTCvdOldCode,
                    CRD.FCCrdValue AS FCCvdOldBal,
                    null AS FTCvdNewCode,
                    '1' AS FTCvdStaCrd,
                    null AS FTCvdStaPrc,
                    null AS FTCvdRmk,
                    null AS FTRsnCode,
                    '$tCreateOn' AS FDCreateOn,
                    '$tCreateBy' AS FTCreateBy,
                    '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            FTCrdCode,
                            FCCrdValue
                            FROM TFNMCard WITH (NOLOCK) WHERE FTCrdCode IN ($tCvdOldCode)
                        ) CRD";

            $oQuery = $ci->db->query($tSQL);
            break;
        }
        case 'cardShiftChange' : {
            $tBchCode = $paDataSet["tBchCode"];
            $tCvdOldCode = implode(",", $paDataSet["aOldCardCode"]);
            $tCvdNewCode = implode(",", $paDataSet["aNewCardCode"]);
            $tRsnCode = $paDataSet["tReasonCode"];
            $tCreateOn = date("Y-m-d H:i:s");
            $tCreateBy = $paDataSet["tCreateBy"];
            $tDocNo = $paDataSet["tDocNo"];

            $tSQL = "INSERT INTO TFNTCrdVoidTmp(FTBchCode, FTCvhDocNo, FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDCreateOn, FTCreateBy, FTSessionID)

                SELECT 
                    '$tBchCode' AS FTBchCode,
                    '$tDocNo' AS FTCvhDocNo,
                    ROW_NUMBER() OVER(ORDER BY  OLDCRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNCvdSeqNo), 0) FROM TFNTCrdVoidTmp WHERE FTSessionID = '$tSessionID') AS FNCvdSeqNo,
                    OLDCRD.FTCrdCode AS FTCvdOldCode,
                    OLDCRD.FCCrdValue AS FCCvdOldBal,
                    NEWCRD.FTCrdCode AS FTCvdNewCode,
                    '1' AS FTCvdStaCrd,
                    null AS FTCvdStaPrc,
                    null AS FTCvdRmk,
                    '$tRsnCode' AS FTRsnCode,
                    '$tCreateOn' AS FDCreateOn,
                    '$tCreateBy' AS FTCreateBy,
                    '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            FTCrdCode, FTCrdHolderID, FCCrdValue
                            FROM TFNMCard WITH (NOLOCK) WHERE FTCrdCode IN ($tCvdOldCode)
                        ) OLDCRD
                LEFT JOIN (
                     SELECT FTCrdCode, FTCrdHolderID FROM TFNMCard WITH (NOLOCK) WHERE FTCrdCode IN ($tCvdNewCode)
                ) NEWCRD
                ON OLDCRD.FTCrdHolderID = NEWCRD.FTCrdHolderID";

            $oQuery = $ci->db->query($tSQL);

            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
    }
}

/**
 * Functionality : Update card in temp by sequence
 * Parameters : $ptDocType, $pnSeq, $paDataSet
 * Creator : 3/1/2019 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function FSxUpdateTempBySeq($ptDocType, $pnSeq, $paDataSet) {
    $ci = &get_instance();
    $ci->load->database();
    $tSessionID = $ci->session->userdata("tSesSessionID");
    $tUpdateOn = date("Y-m-d H:i:s");
    
    switch ($ptDocType) {
        case 'cardShiftNewCard' : {
            $tCrdCode = $paDataSet["tNewCardCode"];
            $tCrdHolderID = $paDataSet["tHolderID"];
            $tCrdName = $paDataSet["tNewCardName"];
            $tCrdTypeCode = $paDataSet["tCardTypeCode"];
            $tDptCode = $paDataSet["tDptCode"];
            $tDptName = $paDataSet["tDptName"];

            $tSQL = "UPDATE TFNTCrdImpTmp SET FTCidStaCrd = '1', FTCidCrdCode = '$tCrdCode', FTCidRmk = null, FTCidCrdName = '$tCrdName', FTCidCrdHolderID = '$tCrdHolderID', FTCtyCode = '$tCrdTypeCode', FTCidCrdDepart = '$tDptName', FDCreateOn = '$tUpdateOn' 
                WHERE FNCidSeqNo = $pnSeq AND FTSessionID = '$tSessionID'";

            $oQuery = $ci->db->query($tSQL);

            break;
        }
        case 'cardShiftClearCard' : {
            $tCrdCode = $paDataSet["tNewCardCode"];

            $tSQL = "UPDATE TFNTCrdImpTmp SET FTCidStaCrd = '1', FTCidCrdCode = '$tCrdCode' , FTCidRmk = null, FDCreateOn = '$tUpdateOn' 
                WHERE FNCidSeqNo = $pnSeq AND FTSessionID = '$tSessionID'";
   
            $oQuery = $ci->db->query($tSQL);

            break;
        }
        case 'cardShiftOut' : {
            $tCrdCode = $paDataSet["tCardCode"];

            $tSQL = "UPDATE TFNTCrdShiftTmp SET FTCrdStaCrd = '1', FTCrdCode = '$tCrdCode', FTCrdRmk = null, FCCtdCardBal = ISNULL(CRD.FCCrdValue, 0), FDLastUpdOn = '$tUpdateOn'
                FROM (SELECT FCCrdValue FROM TFNMCard WITH (NOLOCK) WHERE FTCrdCode = '$tCrdCode') AS CRD 
                WHERE FNCsdSeqNo = $pnSeq AND FTSessionID = '$tSessionID'";

            $oQuery = $ci->db->query($tSQL);

            break;
        }
        case 'cardShiftReturn' : {
            $tCrdCode = $paDataSet["tCardCode"];
            
            $tSQL = "UPDATE TFNTCrdShiftTmp SET FTCrdStaCrd = '1', FTCrdCode = '$tCrdCode', FTCrdRmk = null, FCCtdCardBal = ISNULL(CRD.FCCrdValue, 0), FDLastUpdOn = '$tUpdateOn'
                    FROM (SELECT FCCrdValue FROM TFNMCard WITH (NOLOCK) WHERE FTCrdCode = '$tCrdCode') AS CRD 
                    WHERE FNCsdSeqNo = $pnSeq AND FTSessionID = '$tSessionID'";
            
            $oQuery = $ci->db->query($tSQL);
            
            break;
        }
        case 'cardShiftTopUp' : {
            $tCrdCode = $paDataSet["tCardCode"];
            $nValue = empty($paDataSet["nValue"])? 0.00 : $paDataSet["nValue"];
            
            $tSQL = "UPDATE TFNTCrdTopUpTmp SET FTCtdStaCrd = '1', FTCrdCode = '$tCrdCode', FTCtdRmk = null, FCCtdCrdTP = CONVERT(DECIMAL(18,4),REPLACE('$nValue', ',', '')), FDLastUpdOn = '$tUpdateOn'
                    WHERE FNCtdSeqNo = $pnSeq AND FTSessionID = '$tSessionID'";
            
            $oQuery = $ci->db->query($tSQL);
            
            break;
        }
        case 'cardShiftRefund' : {
            $tCrdCode = $paDataSet["tCardCode"];
            $tCrdValue = empty($paDataSet["tCardValue"])? 0.00 : $paDataSet["tCardValue"];
            
            /*$tSQL = "UPDATE TFNTCrdTopUpTmp SET FTCtdStaCrd = '1', FTCrdCode = '$tCrdCode', FTCtdRmk = null, FCCtdCrdTP = ISNULL($tCrdValue, 0), FDLastUpdOn = '$tUpdateOn'
                    FROM (SELECT FCCrdValue FROM TFNMCard WITH (NOLOCK) WHERE FTCrdCode = '$tCrdCode') AS CRD 
                    WHERE FNCtdSeqNo = $pnSeq AND FTSessionID = '$tSessionID'";*/
            
            $tSQL = "UPDATE TFNTCrdTopUpTmp SET FTCtdStaCrd = '1', FTCrdCode = '$tCrdCode', FTCtdRmk = null, FCCtdCrdTP = CONVERT(DECIMAL(18,4),REPLACE('$tCrdValue', ',', '')), FDLastUpdOn = '$tUpdateOn'
                    WHERE FNCtdSeqNo = $pnSeq AND FTSessionID = '$tSessionID'";
            
            $oQuery = $ci->db->query($tSQL);
            
            break;
        }
        case 'cardShiftStatus' : {
            $tCvdCode = $paDataSet["tCardCode"];
            
            $tSQL = "UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = '1', FTCvdOldCode = '$tCvdCode', FTCvdRmk = null, FCCvdOldBal = ISNULL(CRD.FCCrdValue, 0), FDLastUpdOn = '$tUpdateOn'
                    FROM (SELECT FCCrdValue FROM TFNMCard WITH (NOLOCK) WHERE FTCrdCode = '$tCvdCode') AS CRD 
                    WHERE FNCvdSeqNo = $pnSeq AND FTSessionID = '$tSessionID'";
            
            $oQuery = $ci->db->query($tSQL);
            
            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
        case 'cardShiftChange' : {
            $tCvdOldCode = $paDataSet["tOldCardCode"];
            $tCvdNewCode = $paDataSet["tNewCardCode"];
            $tRsnCode = $paDataSet["tReasonCode"];
            
            $tSQL = "UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = '1', FTCvdOldCode = '$tCvdOldCode', FTCvdRmk = null, FTCvdNewCode = '$tCvdNewCode', FTRsnCode = '$tRsnCode', FCCvdOldBal = ISNULL(CRD.FCCrdValue, 0), FDLastUpdOn = '$tUpdateOn'
                    FROM (SELECT FCCrdValue FROM TFNMCard WITH (NOLOCK) WHERE FTCrdCode = '$tCvdOldCode') AS CRD 
                    WHERE FNCvdSeqNo = $pnSeq AND FTSessionID = '$tSessionID'";
            
            $oQuery = $ci->db->query($tSQL);
            
            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
    }
}

/**
 * Functionality : Select all data in document temp by session id
 * Parameters : $ptDocType
 * Creator : 3/1/2019 piya
 * Last Modified : -
 * Return : Data in document temp by session id
 * Return Type : array
 */
function FSaSelectAllBySessionID($ptDocType){
    $ci = &get_instance();
    $ci->load->database();
    $tSessionID = $ci->session->userdata("tSesSessionID");
    
    switch ($ptDocType) {
        case 'cardShiftNewCard' : {

            $tSQL = "SELECT 
                        CRD.FTCidCrdCode,
                        CRD.FNCidSeqNo,
                        CRD.FTCtyCode,
                        CRD.FTCidCrdName,
                        CRD.FTCidCrdDepart
                FROM    TFNTCrdImpTmp CRD
                WHERE CRD.FTSessionID = '".$tSessionID."' 
                AND 1 = 1";

            $oQuery = $ci->db->query($tSQL);
            break;
        }
        case 'cardShiftOut' : {

            $tSQL = "SELECT 
                        CRD.FTCrdCode,
                        CRD.FNCsdSeqNo,
                        CRD.FTCrdStaCrd,
                        CRD.FTCrdStaPrc
                FROM TFNTCrdShiftTmp CRD
                WHERE CRD.FTSessionID = '".$tSessionID."' 
                AND 1 = 1";

            $oQuery = $ci->db->query($tSQL);
            break;
        }
        case 'cardShiftReturn' : {
            
            $tSQL = "SELECT 
                        CRD.FTCrdCode,
                        CRD.FNCsdSeqNo,
                        CRD.FTCrdStaCrd,
                        CRD.FTCrdStaPrc
                FROM TFNTCrdShiftTmp CRD
                WHERE CRD.FTSessionID = '".$tSessionID."' 
                AND 1 = 1";

            $oQuery = $ci->db->query($tSQL);
            break;
        }
        case 'cardShiftTopUp' : {

            $tSQL = "SELECT 
                        CRD.FTCrdCode,
                        CRD.FNCtdSeqNo
                FROM TFNTCrdTopUpTmp CRD
                WHERE CRD.FTSessionID = '".$tSessionID."' 
                AND 1 = 1";

            $oQuery = $ci->db->query($tSQL);
            break;
        }
        case 'cardShiftRefund' : {

            $tSQL = "SELECT 
                        CRD.FTCrdCode,
                        CRD.FNCtdSeqNo
                FROM TFNTCrdTopUpTmp CRD
                WHERE CRD.FTSessionID = '".$tSessionID."' 
                AND 1 = 1";

            $oQuery = $ci->db->query($tSQL);
            break;
        }
        case 'cardShiftStatus' : {

            $tSQL = "SELECT CRD.FTCvdOldCode,
                        CRD.FNCvdSeqNo,
                        CRD.FTCvdStaCrd,
                        CRD.FTCvdStaPrc,
                        CRD.FTCvdRmk
                FROM TFNTCrdVoidTmp CRD
                WHERE CRD.FTSessionID = '".$tSessionID."' 
                AND 1 = 1";

            $oQuery = $ci->db->query($tSQL);
            break;
        }
        case 'cardShiftChange' : {

            $tSQL = "SELECT CRD.FTCvdOldCode,
                        CRD.FTCvdNewCode,
                        CRD.FNCvdSeqNo,
                        CRD.FCCvdOldBal,
                        CRD.FTRsnCode,
                        CRD.FTCvdStaCrd,
                        CRD.FTCvdStaPrc,
                        CRD.FTCvdRmk
                FROM TFNTCrdVoidTmp CRD
                WHERE CRD.FTSessionID = '".$tSessionID."' 
                AND 1 = 1";

            $oQuery = $ci->db->query($tSQL);
            break;
        }
    }
    
    if ($oQuery->num_rows() > 0) {
        
        $aList      = $oQuery->result(); 

        $aResult = array(
                'raItems'       => $aList,
                'rnAllRow' => $oQuery->num_rows(),
                'rtCode'        => '1',
                'rtDesc'        => 'success'
        );
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
            
    } else {
        //No Data
        $aResult = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
        );
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        
    }
    return $aResult;
}

/**
 * Functionality : Copy card data in temp to DT
 * Parameters : $ptDocType
 * Creator : 3/1/2019 piya
 * Last Modified : -
 * Return : Data in document temp by session id
 * Return Type : array
 */
function FSxDocHelperTempToDT($ptDocType) {
    $ci = &get_instance();
    $ci->load->database();
    $tSessionID = $ci->session->userdata("tSesSessionID");
    $nLngID = $ci->session->userdata("tLangEdit");
    
    switch ($ptDocType) {
        case 'cardShiftNewCard' : {
            
            $tSQL = "INSERT INTO TFNTCrdImpDT (FTBchCode, FTCihDocNo, FNCidSeqNo, FTCidCrdCode, FCCvdOldBal, FTCidCrdRef, FTCtyCode, FTCidCrdName, FTCidCrdHolderID, FTCidCrdDepart, FTCidStaCrd, FTCidStaPrc, FTCidRmk, FDCreateOn, FTCreateBy)
                    SELECT FTBchCode, FTCihDocNo, ROW_NUMBER() OVER(ORDER BY  FNCidSeqNo ASC) AS FNCidSeqNo, FTCidCrdCode, FCCvdOldBal, FTCidCrdRef, FTCtyCode, FTCidCrdName, FTCidCrdHolderID, DPTL.FTDptCode AS FTCidCrdDepart, FTCidStaCrd, FTCidStaPrc, FTCidRmk, FDCreateOn, FTCreateBy
                    FROM TFNTCrdImpTmp IMPT
                    LEFT JOIN TCNMUsrDepart_L DPTL ON DPTL.FTDptName = IMPT.FTCidCrdDepart AND DPTL.FNLngID = $nLngID                   
                    WHERE FTSessionID = '$tSessionID'";
            
            $oQuery = $ci->db->query($tSQL);
            
            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
        case 'cardShiftClearCard' : {
            
            $tSQL = "INSERT INTO TFNTCrdImpDT (FTBchCode, FTCihDocNo, FNCidSeqNo, FTCidCrdCode, FCCvdOldBal, FTCidCrdRef, FTCtyCode, FTCidCrdName, FTCidCrdHolderID, FTCidCrdDepart, FTCidStaCrd, FTCidStaPrc, FTCidRmk, FDCreateOn, FTCreateBy)
                    SELECT FTBchCode, FTCihDocNo, ROW_NUMBER() OVER(ORDER BY  FNCidSeqNo ASC) AS FNCidSeqNo, FTCidCrdCode, FCCvdOldBal, FTCidCrdRef, FTCtyCode, FTCidCrdName, FTCidCrdHolderID, FTCidCrdDepart, FTCidStaCrd, FTCidStaPrc, FTCidRmk, FDCreateOn, FTCreateBy
                    FROM TFNTCrdImpTmp
                    WHERE FTSessionID = '$tSessionID'";
            
            $oQuery = $ci->db->query($tSQL);
            
            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
        case 'cardShiftOut' : {
            
            $tSQL = "INSERT INTO TFNTCrdShiftDT (FTBchCode, FTCshDocNo, FNCsdSeqNo, FTCrdCode, FCCtdCardBal, FTCrdStaCrd, FTCrdStaPrc, FTCrdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
                    SELECT FTBchCode, FTCshDocNo, ROW_NUMBER() OVER(ORDER BY  FNCsdSeqNo ASC) AS FNCsdSeqNo, FTCrdCode, FCCtdCardBal, FTCrdStaCrd, FTCrdStaPrc, FTCrdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy
                    FROM TFNTCrdShiftTmp
                    WHERE FTSessionID = '$tSessionID'";
            
            $oQuery = $ci->db->query($tSQL);
            
            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
        case 'cardShiftReturn' : {
            
            $tSQL = "INSERT INTO TFNTCrdShiftDT (FTBchCode, FTCshDocNo, FNCsdSeqNo, FTCrdCode, FCCtdCardBal, FTCrdStaCrd, FTCrdStaPrc, FTCrdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
                    SELECT FTBchCode, FTCshDocNo, ROW_NUMBER() OVER(ORDER BY  FNCsdSeqNo ASC) AS FNCsdSeqNo, FTCrdCode, FCCtdCardBal, FTCrdStaCrd, FTCrdStaPrc, FTCrdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy
                    FROM TFNTCrdShiftTmp
                    WHERE FTSessionID = '$tSessionID'";
            
            $oQuery = $ci->db->query($tSQL);
            
            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
        case 'cardShiftTopUp' : {
            
            $tSQL = "INSERT INTO TFNTCrdTopUpDT (FTBchCode, FTCthDocNo, FNCtdSeqNo, FTCrdCode, FCCtdCrdTP, FTCtdStaCrd, FTCtdStaPrc, FTCtdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
                    SELECT FTBchCode, FTCthDocNo, ROW_NUMBER() OVER(ORDER BY  FNCtdSeqNo ASC) AS FNCtdSeqNo, FTCrdCode, FCCtdCrdTP, FTCtdStaCrd, FTCtdStaPrc, FTCtdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy
                    FROM TFNTCrdTopUpTmp
                    WHERE FTSessionID = '$tSessionID'";
            
            $oQuery = $ci->db->query($tSQL);
            
            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
        case 'cardShiftRefund' : {
            
            $tSQL = "INSERT INTO TFNTCrdTopUpDT (FTBchCode, FTCthDocNo, FNCtdSeqNo, FTCrdCode, FCCtdCrdTP, FTCtdStaCrd, FTCtdStaPrc, FTCtdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
                    SELECT FTBchCode, FTCthDocNo, ROW_NUMBER() OVER(ORDER BY  FNCtdSeqNo ASC) AS FNCtdSeqNo, FTCrdCode, FCCtdCrdTP, FTCtdStaCrd, FTCtdStaPrc, FTCtdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy
                    FROM TFNTCrdTopUpTmp
                    WHERE FTSessionID = '$tSessionID'";
            
            $oQuery = $ci->db->query($tSQL);
            
            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
        case 'cardShiftStatus' : {
            
            $tSQL = "INSERT INTO TFNTCrdVoidDT (FTBchCode, FTCvhDocNo, FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
                    SELECT FTBchCode, FTCvhDocNo, ROW_NUMBER() OVER(ORDER BY  FNCvdSeqNo ASC) AS FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy
                    FROM TFNTCrdVoidTmp
                    WHERE FTSessionID = '$tSessionID'";
            
            $oQuery = $ci->db->query($tSQL);
            
            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
        case 'cardShiftChange' : {
            
            $tSQL = "INSERT INTO TFNTCrdVoidDT (FTBchCode, FTCvhDocNo, FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
                    SELECT FTBchCode, FTCvhDocNo, ROW_NUMBER() OVER(ORDER BY  FNCvdSeqNo ASC) AS FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy
                    FROM TFNTCrdVoidTmp
                    WHERE FTSessionID = '$tSessionID'";
            
            $oQuery = $ci->db->query($tSQL);
            
            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
    }
}

/**
 * Functionality : Copy card data in DT to temp
 * Parameters : $ptDocType, $ptDocNo
 * Creator : 3/1/2019 piya
 * Last Modified : -
 * Return : Data in document temp by session id
 * Return Type : array
 */
function FSxDocHelperDTToTemp($ptDocType, $ptDocNo) {
    $ci = &get_instance();
    $ci->load->database();
    $tSessionID = $ci->session->userdata("tSesSessionID");
    $nLngID = $ci->session->userdata("tLangEdit");
    
    switch ($ptDocType) {
        case 'cardShiftNewCard' : {
            
            $tSQL = "INSERT INTO TFNTCrdImpTmp (FTBchCode, FTCihDocNo, FNCidSeqNo, FTCidCrdCode, FCCvdOldBal, FTCidCrdRef, FTCtyCode, FTCidCrdName, FTCidCrdHolderID, FTCidCrdDepart, FTCidStaCrd, FTCidStaPrc, FTCidRmk, FDCreateOn, FTCreateBy, FTSessionID)
                    SELECT FTBchCode, FTCihDocNo, ROW_NUMBER() OVER(ORDER BY  FNCidSeqNo ASC) AS FNCidSeqNo, FTCidCrdCode, FCCvdOldBal, FTCidCrdRef, FTCtyCode, FTCidCrdName, FTCidCrdHolderID, DPTL.FTDptName AS FTCidCrdDepart, FTCidStaCrd, FTCidStaPrc, FTCidRmk, FDCreateOn, FTCreateBy, '$tSessionID' AS FTSessionID
                    FROM TFNTCrdImpDT IMPDT
                    LEFT JOIN TCNMUsrDepart_L DPTL ON DPTL.FTDptCode = IMPDT.FTCidCrdDepart AND DPTL.FNLngID = $nLngID                    
                    WHERE FTCihDocNo = '$ptDocNo'";
            
            $oQuery = $ci->db->query($tSQL);
            
            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
        case 'cardShiftClearCard' : {
            
            $tSQL = "INSERT INTO TFNTCrdImpTmp (FTBchCode, FTCihDocNo, FNCidSeqNo, FTCidCrdCode, FCCvdOldBal, FTCidCrdRef, FTCtyCode, FTCidCrdName, FTCidCrdHolderID, FTCidCrdDepart, FTCidStaCrd, FTCidStaPrc, FTCidRmk, FDCreateOn, FTCreateBy, FTSessionID)
                    SELECT FTBchCode, FTCihDocNo, ROW_NUMBER() OVER(ORDER BY  FNCidSeqNo ASC) AS FNCidSeqNo, FTCidCrdCode, FCCvdOldBal, FTCidCrdRef, FTCtyCode, FTCidCrdName, FTCidCrdHolderID, FTCidCrdDepart, FTCidStaCrd, FTCidStaPrc, FTCidRmk, FDCreateOn, FTCreateBy, '$tSessionID' AS FTSessionID
                    FROM TFNTCrdImpDT
                    WHERE FTCihDocNo = '$ptDocNo'";
            
            $oQuery = $ci->db->query($tSQL);
            
            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
        case 'cardShiftOut' : {
            
            $tSQL = "INSERT INTO TFNTCrdShiftTmp (FTBchCode, FTCshDocNo, FNCsdSeqNo, FTCrdCode, FCCtdCardBal, FTCrdStaCrd, FTCrdStaPrc, FTCrdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTSessionID)
                    SELECT FTBchCode, FTCshDocNo, ROW_NUMBER() OVER(ORDER BY  FNCsdSeqNo ASC) AS FNCsdSeqNo, FTCrdCode, FCCtdCardBal, FTCrdStaCrd, FTCrdStaPrc, FTCrdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, '$tSessionID' AS FTSessionID
                    FROM TFNTCrdShiftDT
                    WHERE FTCshDocNo = '$ptDocNo'";
            
            $oQuery = $ci->db->query($tSQL);
            
            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
        case 'cardShiftReturn' : {
            
            $tSQL = "INSERT INTO TFNTCrdShiftTmp (FTBchCode, FTCshDocNo, FNCsdSeqNo, FTCrdCode, FCCtdCardBal, FTCrdStaCrd, FTCrdStaPrc, FTCrdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTSessionID)
                    SELECT FTBchCode, FTCshDocNo, ROW_NUMBER() OVER(ORDER BY  FNCsdSeqNo ASC) AS FNCsdSeqNo, FTCrdCode, FCCtdCardBal, FTCrdStaCrd, FTCrdStaPrc, FTCrdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, '$tSessionID' AS FTSessionID
                    FROM TFNTCrdShiftDT
                    WHERE FTCshDocNo = '$ptDocNo'";
            
            $oQuery = $ci->db->query($tSQL);
            
            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
        case 'cardShiftTopUp' : {
            
            $tSQL = "INSERT INTO TFNTCrdTopUpTmp (FTBchCode, FTCthDocNo, FNCtdSeqNo, FTCrdCode, FCCtdCrdTP, FTCtdStaCrd, FTCtdStaPrc, FTCtdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTSessionID)
                    SELECT FTBchCode, FTCthDocNo, ROW_NUMBER() OVER(ORDER BY  FNCtdSeqNo ASC) AS FNCtdSeqNo, FTCrdCode, FCCtdCrdTP, FTCtdStaCrd, FTCtdStaPrc, FTCtdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, '$tSessionID' AS FTSessionID
                    FROM TFNTCrdTopUpDT
                    WHERE FTCthDocNo = '$ptDocNo'";
            
            $oQuery = $ci->db->query($tSQL);
            
            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
        case 'cardShiftRefund' : {
            
            $tSQL = "INSERT INTO TFNTCrdTopUpTmp (FTBchCode, FTCthDocNo, FNCtdSeqNo, FTCrdCode, FCCtdCrdTP, FTCtdStaCrd, FTCtdStaPrc, FTCtdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTSessionID)
                    SELECT FTBchCode, FTCthDocNo, ROW_NUMBER() OVER(ORDER BY  FNCtdSeqNo ASC) AS FNCtdSeqNo, FTCrdCode, FCCtdCrdTP, FTCtdStaCrd, FTCtdStaPrc, FTCtdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, '$tSessionID' AS FTSessionID
                    FROM TFNTCrdTopUpDT
                    WHERE FTCthDocNo = '$ptDocNo'";
            
            $oQuery = $ci->db->query($tSQL);
            
            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
        case 'cardShiftStatus' : {
            
            $tSQL = "INSERT INTO TFNTCrdVoidTmp (FTBchCode, FTCvhDocNo, FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTSessionID)
                    SELECT FTBchCode, FTCvhDocNo, ROW_NUMBER() OVER(ORDER BY  FNCvdSeqNo ASC) AS FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, '$tSessionID' AS FTSessionID
                    FROM TFNTCrdVoidDT
                    WHERE FTCvhDocNo = '$ptDocNo'";
            
            $oQuery = $ci->db->query($tSQL);
            
            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
        case 'cardShiftChange' : {
            
            $tSQL = "INSERT INTO TFNTCrdVoidTmp (FTBchCode, FTCvhDocNo, FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTSessionID)
                    SELECT FTBchCode, FTCvhDocNo, ROW_NUMBER() OVER(ORDER BY  FNCvdSeqNo ASC) AS FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, '$tSessionID' AS FTSessionID
                    FROM TFNTCrdVoidDT
                    WHERE FTCvhDocNo = '$ptDocNo'";
            
            $oQuery = $ci->db->query($tSQL);
            
            if($oQuery){
                // echo "Insert Success";
            }else{
                // echo "Inser Fail";
            }
            break;
        }
    }
}
