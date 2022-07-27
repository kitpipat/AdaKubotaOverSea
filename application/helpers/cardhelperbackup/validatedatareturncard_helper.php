<?php

/**
 * Functionality: (เอกสารคืนบัตร) ฟังก์ชั่นตรวจสอบว่ารหัสบัตรมีอยู่ในระบบหรือไม่
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified: 07/01/2018 Wasin(ํYoshi)
 * Return: 
 * Return Type: Numeric
*/
function FSnHReturnCrdChkCrdCodeFoundInDB($paParams){
    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============    
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo     = $paParams['tSeqNo'];

    //  Where Seq In Table Edit InLine
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND FNCsdSeqNo = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNCsdSeqNo = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorNotFoundCardCode   =   language('common/docvalidate','tErrorNotFoundCardCode'); // Add validate for lang (golf) 08/01/2019
    $tSQL   = " UPDATE TFNTCrdShiftTmp SET FTCrdStaCrd = 2 , FTCrdRmk = '".$tErrorNotFoundCardCode."'
                WHERE FTCrdCode
                NOT IN(
                    SELECT  DISTINCT C1.FTCrdCode FROM TFNTCrdShiftTmp C1
                    INNER JOIN(
                        SELECT CST.FTCrdCode AS FTCrdCodeTemp , ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                        FROM TFNTCrdShiftTmp CST
                        LEFT JOIN  TFNMCard CRD ON CST.FTCrdCode = CRD.FTCrdCode
                        WHERE 1=1
                        AND CST.FTSessionID = '".$tSessionID."'
                    ) C2 ON C1.FTCrdCode = C2.FTCrdCode
                    ".$tWhereSltSeqNo."
                ) ";
    
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTCrdStaCrd = 1 AND FTSessionID = '".$tSessionID."' ";
    
    $oQuery  = $ci->db->query($tSQL);

    if($ci->db->affected_rows() > 0){
        return 1;   // ไม่พบรหัสบัตรในระบบ
    }else{
        return 0;   // พบข้อมูลบัตรในระบบ
    }
}

/**
 * Functionality: (เอกสารคืนบัตร) ฟังก์ชั่นตรวจสอบว่าบัตรในตาราง Temp ซ้ำกันหรือไม่ถ้าซ้ำจะไม่ถูก Process
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 03/01/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: Status Process 
 * Return Type: Numeric
*/
function FSnHReturnCrdChkCrdCodeNotDupTemp($paParams){
    $ci = &get_instance();
    $ci->load->database();
    
    // ============= Parameter =============
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo     = $paParams['tSeqNo'];

    // Where Seq In Table Edit InLine
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND FNCsdSeqNo = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNCsdSeqNo = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorCrdTmpDup   =   language('common/docvalidate','tErrorCrdTmpDup'); // Add validate for lang (golf) 08/01/2019
    $tSQL   = " UPDATE TFNTCrdShiftTmp SET FTCrdStaCrd = 2 , FTCrdRmk = '".$tErrorCrdTmpDup."'
                WHERE  FTCrdCode
                IN (
                    SELECT DISTINCT C1.FTCrdCode FROM TFNTCrdShiftTmp C1
                    INNER JOIN (
                        SELECT FTCrdCode , COUNT(FTCrdCode)  AS FNCrdCodeCount
                        FROM TFNTCrdShiftTmp
                        WHERE FTSessionID = '".$tSessionID."'
                        GROUP BY FTCrdCode
                    ) C2 ON C1.FTCrdCode    = C2.FTCrdCode
                    AND C1.FTSessionID      = '".$tSessionID."'
                    AND C2.FNCrdCodeCount > 1
                    ".$tWhereSltSeqNo."
                ) ";
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND (FTCrdStaCrd = 1 AND FTSessionID = '".$tSessionID."')";

    $oQuery  = $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1;   // พบข้อมูลรหัสบัตรซ้ำในตาราง Temp
    }else{
        return 0;   // ไม่พบข้อมูลรหัสบัตรซ้ำในตาราง Temp
    }
}

/**
 * Functionality: (เอกสารคืนบัตร) ฟังก์ชั่นเช็คสถานะการถูกเบิกของบัตร (บัตรต้องถูกเบิกไปแล้ว)
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 03/01/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: Status Process 
 * Return Type: Numeric
*/
function FSnHReturnCrdChkStaShiftInCard($paParams){
    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============
    $tSessionID     = $paParams['tSessionID'];
    $tSeqNo         = $paParams['tSeqNo'];
    $bStaCardShift  = $paParams['bStaCardShift'];

    //Where Seq In Table Edit InLine
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND CST.FNCsdSeqNo  = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNCsdSeqNo  = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    // StatusShift = TURE: สถานะบัตรยังไม่ถูกเบิก , FALSE: สถานะบัตรถูกเบิกไปแล้ว
        $tErrorStaCardShift   = "";
    if(!empty($bStaCardShift) && $bStaCardShift === TRUE){
        $tWhereStaCrdShift    = " AND CRD.FTCrdStaShift = 1 ";
        $tErrorStaCardShift   =   language('common/docvalidate','tErrorStaCrdShiftNotWithdrawned'); // Add validate for lang (golf) 08/01/2019
    }else if(!empty($bStaCardShift) && $bStaCardShift === FALSE){
        $tWhereStaCrdShift    = " AND CRD.FTCrdStaShift = 2 ";
        $tErrorStaCardShift   =   language('common/docvalidate','tErrorStaCrdShiftWithdrawned'); // Add validate for lang (golf) 08/01/2019
    }else{
        $tWhereStaCrdShift  = "";
    }
    $tSQL   = " UPDATE TFNTCrdShiftTmp SET FTCrdStaCrd = 2 , FTCrdRmk = '".$tErrorStaCardShift."'
                WHERE  FTCrdCode
                NOT IN (
                    SELECT  ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                    FROM TFNTCrdShiftTmp CST
                    LEFT JOIN  TFNMCard CRD ON CST.FTCrdCode = CRD.FTCrdCode
                    WHERE 1=1 ";
    $tSQL   .= $tWhereSltSeqNo;
    $tSQL   .= $tWhereStaCrdShift;
    $tSQL   .= " ) ";
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTCrdStaCrd = 1 AND FTSessionID =  '".$tSessionID."' ";

    $oQuery = $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1;   // ข้อมูลสถานะการถูกเบิกไม่ตรงตามเงื่อนไข
    }else{
        return 0;   // ข้อมูลสถานะการถูกเบิกตรงตามเงื่อนไข
    }
}

/**
 * Functionality: (เอกสารคืนบัตร) ฟังก์ชั่นเช็คสถานะบัตร Active InActive Cancle
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 03/01/2019 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHReturnCrdChkStaActiveInCard($paParams){
    $ci = &get_instance();
    $ci->load->database();
    // ============= Parameter =============
    $tSessionID     = $paParams['tSessionID'];
    $tSeqNo         = $paParams['tSeqNo'];
    $nCrdStaActive  = $paParams['nCrdStaActive'];

    // Where Seq In Table Edit InLine
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND CST.FNCsdSeqNo  = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNCsdSeqNo  = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    // StatusActive = 1: Active , 2:InActive ,3:Cancle 
            $tErrorStaCrdActive   = "";
    switch ($nCrdStaActive) {
        case '1':
            //Status Active
            $tWhereCrdStaActive   = " AND CRD.FTCrdStaActive = 1";
            $tErrorStaCrdActive   =   language('common/docvalidate','tErrorStaCrdActive'); // Add validate for lang (golf) 08/01/2019
            break;
        case '2':
            //Status InActives
            $tWhereCrdStaActive   = " AND CRD.FTCrdStaActive = 2";
            $tErrorStaCrdActive   =   language('common/docvalidate','tErrorStaCrdInActive'); // Add validate for lang (golf) 08/01/2019
            break;
        case '3':
            //Status Cancle
            $tWhereCrdStaActive   = " AND CRD.FTCrdStaActive = 3";
            $tErrorStaCrdActive   =   language('common/docvalidate','tErrorStaCrdCancle'); // Add validate for lang (golf) 08/01/2019
            break;
        default:
            $tWhereCrdStaActive   =  "";
    }
    $tSQL   =   "   UPDATE TFNTCrdShiftTmp SET FTCrdStaCrd = 2 , FTCrdRmk = '".$tErrorStaCrdActive."'
                    WHERE  FTCrdCode
                    NOT IN (
                        SELECT  ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                        FROM TFNTCrdShiftTmp CST
                        LEFT JOIN TFNMCard CRD ON CRD.FTCrdCode = CST.FTCrdCode
                        WHERE 1=1 ";
    $tSQL   .= $tWhereSltSeqNo;
    $tSQL   .= $tWhereCrdStaActive;
    $tSQL   .= " ) ";
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTCrdStaCrd = 1 AND FTSessionID =  '".$tSessionID."' ";
    
    $oQuery = $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1;   // ข้อมูลสถานะไม่ตรงตามเงื่อนไข
    }else{
        return 0;   // ข้อมูลสถานะตรงตามเงื่อนไข
    }
}

