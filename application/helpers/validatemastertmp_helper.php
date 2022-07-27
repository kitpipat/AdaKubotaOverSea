<?php

/*===== Begin Temp Validate in TCNTImpMasTmp ==============================================*/
/**
* Functionality:ตรวจสอบรหัสว่ามีอยู่จริงหรือไม่
* Parameters: Array เงื่อนไขการเช็คค่า [paParams]
* [tUserSessionID => '', tFieldName => '', tTableName => '', tErrMsg => '']
* Creator: 02/07/2020 Piya
* Last Modified: -
* Return: Status
* Return Type: Number
*/
function FCNnMasTmpChkCodeInDB(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['tFieldName']) || empty($paParams['tFieldName']) 
        || !isset($paParams['tTableName']) || empty($paParams['tTableName'])
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============    
    $tUserSessionID = $paParams['tUserSessionID'];
    $tFieldName = $paParams['tFieldName'];
    $tTablename = $paParams['tTableName'];

    // Where Table Key
    $tWhereTableKey = "";
    $tWhereTableKeyTmp = "";
    $tWhereTableKeyTmp1 = "";
    if (!empty($paParams['tTableKey'])) {
        $tTableKey = $paParams['tTableKey'];
        $tWhereTableKey = " AND FTTmpTableKey = '$tTableKey'";
        $tWhereTableKeyTmp = " AND TMP.FTTmpTableKey = '$tTableKey'";
        $tWhereTableKeyTmp1 = " AND TMP1.FTTmpTableKey = '$tTableKey'";
    }

    // Where Seq In Table Edit InLine
    $tWhereSeqNo = "";
    $tWhereSeqNoTmp = "";
    $tWhereSeqNoTmp1 = "";
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSeqNo = " AND FNTmpSeq = $tSeqNo";
        $tWhereSeqNoTmp = " AND TMP.FNTmpSeq = $tSeqNo";
        $tWhereSeqNoTmp1 = " AND TMP1.FNTmpSeq = $tSeqNo";
    }

    $tErrMsg = isset($paParams['tErrMsg'])?$paParams['tErrMsg']:language('common/main/main','ข้อมูลอ้างอิงไม่ถูกต้อง');
    $tFieldNameTmp = $tFieldName."Temp";

    $tSQL = " 
        UPDATE TCNTImpMasTmp SET FTTmpStatus = '2', FTTmpRemark = '$tErrMsg'
        WHERE $tFieldName
        NOT IN(
            SELECT DISTINCT TMP1.$tFieldName FROM TCNTImpMasTmp TMP1 WITH (NOLOCK)
            INNER JOIN(
                SELECT TMP.$tFieldName AS $tFieldNameTmp, ISNULL(MAS.$tFieldName,MAS.$tFieldName) AS $tFieldName
                FROM TCNTImpMasTmp TMP
                LEFT JOIN $tTablename MAS WITH (NOLOCK) ON TMP.$tFieldName = MAS.$tFieldName
                WHERE 1=1
                AND TMP.FTTmpStatus = '1'
                AND TMP.FTSessionID = '$tUserSessionID'
                $tWhereSeqNoTmp
                $tWhereTableKeyTmp
            ) TMP2 ON TMP1.$tFieldName = TMP2.$tFieldName
            $tWhereSeqNoTmp1
            $tWhereTableKeyTmp1
        ) 
    ";
    
    $tSQL .= $tWhereSeqNo;
    $tSQL .= $tWhereTableKey;
    $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID') AND ($tFieldName <> '' AND $tFieldName IS NOT NULL)";
    
    $ci->db->query($tSQL);

    if($ci->db->affected_rows() > 0){
        return 1;   // ไม่พบข้อมูลในระบบ
    }else{
        return 0;   // พบข้อมูลในระบบ
    }
}

/**
* Functionality:ตรวจสอบรหัสว่ามีอยู่จริงหรือไม่ (Multiple Field)
* Parameters: Array เงื่อนไขการเช็คค่า [paParams]
* [tUserSessionID => '', tTableName => '', aFieldName = ['field_name1', 'field_name2, ...], tErrMsg => '']
* Creator: 02/07/2020 Piya
* Last Modified: -
* Return: -
* Return Type: Number
*/
function FCNnMasTmpChkCodeMultiInDB(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['aFieldName']) || empty($paParams['aFieldName'])
        || !isset($paParams['tTableName']) || empty($paParams['tTableName'])
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============    
    $tUserSessionID = $paParams['tUserSessionID'];
    $aFieldName = $paParams['aFieldName'];
    $tTablename = $paParams['tTableName'];

    // Where Table Key
    $tWhereTableKey = "";
    $tWhereTableKeyTmp = "";
    $tWhereTableKeyTmp1 = "";
    if (!empty($paParams['tTableKey'])) {
        $tTableKey = $paParams['tTableKey'];
        $tWhereTableKey = " AND FTTmpTableKey = '$tTableKey'";
        $tWhereTableKeyTmp = " AND TMP.FTTmpTableKey = '$tTableKey'";
        $tWhereTableKeyTmp1 = " AND TMP1.FTTmpTableKey = '$tTableKey'";
    }

    // Where Seq In Table Edit InLine
    $tWhereSeqNo = "";
    $tWhereSeqNoTmp = "";
    $tWhereSeqNoTmp1 = "";
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSeqNo = " AND FNTmpSeq = $tSeqNo";
        $tWhereSeqNoTmp = " AND TMP.FNTmpSeq = $tSeqNo";
        $tWhereSeqNoTmp1 = " AND TMP1.FNTmpSeq = $tSeqNo";
    }

    $tErrMsg = isset($paParams['tErrMsg'])?$paParams['tErrMsg']:language('common/main/main','ข้อมูลอ้างอิงไม่ถูกต้อง');

    $tFieldOn1 = "";
    $tFieldOn2 = "";

    $tSelect = "";
    
    foreach($aFieldName as $nIndex => $tFieldName) {
        if($nIndex == 0){
            $tFieldOn1 .= " ON TMP.$tFieldName = MAS.$tFieldName";
            $tFieldOn2 .= " ON TMP1.$tFieldName = TMP2.$tFieldName";
        }else{
            $tFieldOn1 .= " AND TMP.$tFieldName = MAS.$tFieldName";
            $tFieldOn2 .= " AND TMP1.$tFieldName = TMP2.$tFieldName";
        }

        if ($nIndex == count($aFieldName)-1) {
            $tSelect .= " ISNULL(MAS.$tFieldName,MAS.$tFieldName) AS $tFieldName";
        }else{
            $tSelect .= " ISNULL(MAS.$tFieldName,MAS.$tFieldName) AS $tFieldName,";
        }
    }

    $tSQL = " 
        UPDATE TCNTImpMasTmp SET FTTmpStatus = '2', FTTmpRemark = '$tErrMsg'
    ";

    foreach ($aFieldName as $nIndex => $tFieldName) {
        if ($nIndex == 0) {
            $tSQL .= "
                WHERE $tFieldName
                NOT IN(
                    SELECT DISTINCT TMP1.$tFieldName FROM TCNTImpMasTmp TMP1 WITH (NOLOCK)
                    INNER JOIN(
                        SELECT $tSelect
                        FROM TCNTImpMasTmp TMP WITH (NOLOCK)
                        LEFT JOIN $tTablename MAS WITH (NOLOCK) $tFieldOn1
                        WHERE 1=1
                        AND TMP.FTTmpStatus = '1'
                        AND TMP.FTSessionID = '$tUserSessionID'
                        $tWhereSeqNoTmp
                        $tWhereTableKeyTmp
                    ) TMP2 $tFieldOn2
                    $tWhereSeqNoTmp1
                    $tWhereTableKeyTmp1
                ) 
            ";
        }else{
            $tSQL .= "
                OR $tFieldName
                NOT IN(
                    SELECT DISTINCT TMP1.$tFieldName FROM TCNTImpMasTmp TMP1 WITH (NOLOCK)
                    INNER JOIN(
                        SELECT $tSelect
                        FROM TCNTImpMasTmp TMP
                        LEFT JOIN $tTablename MAS WITH (NOLOCK) $tFieldOn1
                        WHERE 1=1
                        AND TMP.FTTmpStatus = '1'
                        AND TMP.FTSessionID = '$tUserSessionID'
                        $tWhereSeqNoTmp
                        $tWhereTableKeyTmp
                    ) TMP2 $tFieldOn2
                    $tWhereSeqNoTmp1
                    $tWhereTableKeyTmp1
                ) 
            ";
        }
    }

    $tSQL .= $tWhereSeqNo;
    $tSQL .= $tWhereTableKey;
    $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID')";
    
    $ci->db->query($tSQL);

    if($ci->db->affected_rows() > 0){
        return 1; // ไม่พบข้อมูลในระบบ
    }else{
        return 0; // พบข้อมูลในระบบ
    }
}

/**
 * Functionality: ตรวจสอบรหัสว่า ซ้ำในระบบหรือไม่
 * Parameters: Array เงื่อนไขการเช็คค่า [$paParams]
 * [tUserSessionID => '', tFieldName => '', tTableName => '']
 * Creator: 02/07/2020 Piya
 * Last Modified: -
 * Return: Status
 * Return Type: Number
*/
function FCNnMasTmpChkCodeDupInDB(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['tFieldName']) || empty($paParams['tFieldName']) 
        || !isset($paParams['tTableName']) || empty($paParams['tTableName'])
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    $tUserSessionID = $paParams['tUserSessionID'];
    $tFieldName = $paParams['tFieldName'];
    $tTableName = $paParams['tTableName'];

    /** Where Seq In Table Edit InLine */
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSltSeqNo = " AND FNTmpSeq = $tSeqNo";
        $tWhereUpdSeqNo = " AND FNTmpSeq = $tSeqNo";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrMsg = language('common/main/main','มีข้อมูลนี้อยู่แล้วในระบบ'); 

    $tSQL = " 
        UPDATE TCNTImpMasTmp SET FTTmpStatus = '6', FTTmpRemark = '$tErrMsg'
        WHERE $tFieldName
        IN(
            SELECT ISNULL(MAS.$tFieldName,MAS.$tFieldName) AS $tFieldName
            FROM TCNTImpMasTmp TMP WITH (NOLOCK)
            LEFT JOIN $tTableName MAS WITH (NOLOCK) ON TMP.$tFieldName = MAS.$tFieldName
            WHERE 1=1 
            AND TMP.FTTmpStatus = '1'
    ";
    $tSQL .= $tWhereSltSeqNo;
    $tSQL .= " ) ";

    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID')";

    $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1; // กรณีมีการ Duplicate Code
    }else{
        return 0; // กรณีไม่มีการ Duplicate Code
    }
}

/**
 * Functionality: ตรวจสอบรหัสว่า ซ้ำหรือไม่ (Multiple Field)
 * Parameters: Array เงื่อนไขการเช็คค่า [$paParams]
 * tUserSessionID, tTableName
 * [tUserSessionID => '', tTableName => '', aFieldName = ['field_name1', 'field_name2, ...]]
 * Creator: 02/07/2020 Piya
 * Last Modified: -
 * Return: Status
 * Return Type: Number
*/
function FCNnMasTmpChkCodeMultiDupInDB(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['aFieldName']) || empty($paParams['aFieldName'])
        || !isset($paParams['tTableName']) || empty($paParams['tTableName'])
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    $tUserSessionID = $paParams['tUserSessionID'];
    $aFieldName = $paParams['aFieldName'];
    $tTableName = $paParams['tTableName'];

    /** Where Seq In Table Edit InLine */
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSltSeqNo = " AND FNTmpSeq = $tSeqNo";
        $tWhereUpdSeqNo = " AND FNTmpSeq = $tSeqNo";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrMsg = language('common/main/main','มีข้อมูลนี้อยู่แล้วในระบบ');

    $tSQL = " 
        UPDATE TCNTImpMasTmp SET FTTmpStatus = '6', FTTmpRemark = '$tErrMsg'
        WHERE 1=1 
    ";

    $tFieldOn = "";

    foreach($aFieldName as $nIndex => $tFieldName) {
        if($nIndex == 0){
            $tFieldOn .= " ON TMP.$tFieldName = MAS.$tFieldName";
        }else{
            $tFieldOn .= " AND TMP.$tFieldName = MAS.$tFieldName";
        }
    }

    foreach($aFieldName as $tFieldName) {
        $tSQL .= "
            AND $tFieldName IN(
                SELECT ISNULL(MAS.$tFieldName,MAS.$tFieldName) AS $tFieldName
            FROM TCNTImpMasTmp TMP WITH (NOLOCK)
            LEFT JOIN $tTableName MAS WITH (NOLOCK) $tFieldOn
            WHERE 1=1 
            AND TMP.FTTmpStatus = '1' 
        ";

        $tSQL .= $tWhereSltSeqNo;
        $tSQL .= " ) ";
    }

    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID')";

    $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1; // กรณีมีการ Duplicate Code
    }else{
        return 0; // กรณีไม่มีการ Duplicate Code
    }
}

/**
* Functionality:ตรวจสอบรหัสว่ามีอยู่จริงหรือไม่ (Temp)
* Parameters: Array เงื่อนไขการเช็คค่า [paParams]
* [tUserSessionID => '', tFieldName => '', tTableName => '', tErrMsg => '']
* Creator: 02/07/2020 Piya
* Last Modified: -
* Return: Status
* Return Type: Number
*/
function FCNnMasTmpChkCodeInTemp(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['tFieldName']) || empty($paParams['tFieldName']) 
        || !isset($paParams['tTableName']) || empty($paParams['tTableName'])
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============    
    $tUserSessionID = $paParams['tUserSessionID'];
    $tFieldName = $paParams['tFieldName'];
    $tTablename = $paParams['tTableName'];
    $tTableKeyIn = $paParams['tTableKeyIn'];

    // Where Table Key
    $tWhereTableKey = "";
    $tWhereTableKeyTmp = "";
    $tWhereTableKeyTmp1 = "";
    $tWhereTableKeyMas = "";
    if (!empty($paParams['tTableKey'])) {
        $tTableKey = $paParams['tTableKey'];
        $tWhereTableKey = " AND FTTmpTableKey = '$tTableKey'";
        $tWhereTableKeyTmp = " AND TMP.FTTmpTableKey = '$tTableKey'";
        $tWhereTableKeyTmp1 = " AND TMP1.FTTmpTableKey = '$tTableKey'";
        $tWhereTableKeyMas = " AND MAS.FTTmpTableKey = '$tTableKeyIn'";
    }

    // Where Seq In Table Edit InLine
    $tWhereSeqNo = "";
    $tWhereSeqNoTmp = "";
    $tWhereSeqNoTmp1 = "";
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSeqNo = " AND FNTmpSeq = $tSeqNo";
        $tWhereSeqNoTmp = " AND TMP.FNTmpSeq = $tSeqNo";
        $tWhereSeqNoTmp1 = " AND TMP1.FNTmpSeq = $tSeqNo";
    }

    $tErrMsg = isset($paParams['tErrMsg'])?$paParams['tErrMsg']:language('common/main/main','ข้อมูลอ้างอิงไม่ถูกต้อง');
    $tFieldNameTmp = $tFieldName."Temp";

    $tSQL = " 
        UPDATE TCNTImpMasTmp SET FTTmpStatus = '2', FTTmpRemark = '$tErrMsg'
        WHERE $tFieldName
        NOT IN(
            SELECT DISTINCT TMP1.$tFieldName FROM TCNTImpMasTmp TMP1 WITH (NOLOCK)
            INNER JOIN(
                SELECT TMP.$tFieldName AS $tFieldNameTmp, ISNULL(MAS.$tFieldName,MAS.$tFieldName) AS $tFieldName
                FROM TCNTImpMasTmp TMP
                LEFT JOIN $tTablename MAS WITH (NOLOCK) ON TMP.$tFieldName = MAS.$tFieldName AND MAS.FTTmpStatus = '1' AND MAS.FTSessionID = '$tUserSessionID' $tWhereTableKeyMas
                WHERE 1=1
                AND TMP.FTTmpStatus = '1'
                AND TMP.FTSessionID = '$tUserSessionID'
                $tWhereSeqNoTmp
                $tWhereTableKeyTmp
            ) TMP2 ON TMP1.$tFieldName = TMP2.$tFieldName
            $tWhereSeqNoTmp1
            $tWhereTableKeyTmp1
        ) 
    ";
    
    $tSQL .= $tWhereSeqNo;
    $tSQL .= $tWhereTableKey;
    $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID') AND ($tFieldName <> '' AND $tFieldName IS NOT NULL)";
    
    $ci->db->query($tSQL);

    if($ci->db->affected_rows() > 0){
        return 1;   // ไม่พบข้อมูลในระบบ
    }else{
        return 0;   // พบข้อมูลในระบบ
    }
}

/**
 * Functionality: ตรวจสอบรหัสว่า ซ้ำใน Temp หรือไม่
 * Parameters: Array เงื่อนไขการเช็คค่า [$paParams]
 * [tUserSessionID => '', tFieldName => '', tTableKey => '']
 * Creator: 02/07/2020 Piya
 * Last Modified: -
 * Return: Status
 * Return Type: Number
*/
function FCNnMasTmpChkCodeDupInTemp(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['tFieldName']) || empty($paParams['tFieldName'])
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    $tUserSessionID = $paParams['tUserSessionID'];
    $tFieldName = $paParams['tFieldName'];

    // Where Table Key
    $tWhereTableKey1 = "";
    $tWhereTableKey2 = "";
    if (!empty($paParams['tTableKey'])) {
        $tTableKey = $paParams['tTableKey'];
        $tWhereTableKey1 = " AND FTTmpTableKey = '$tTableKey'";
        $tWhereTableKey2 = " AND TMP1.FTTmpTableKey = '$tTableKey'";
    }

    // Where Seq In Table Edit InLine
    $tWhereSeqNo1 = "";
    $tWhereSeqNo2 = "";
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSeqNo1 = " AND FNTmpSeq = $tSeqNo";
        $tWhereSeqNo2 = " AND TMP1.FNTmpSeq = $tSeqNo";
    }

    $tErrMsg = language('common/main/main','กรอกข้อมูลซ้ำ');

    $tSQL = " 
        UPDATE TCNTImpMasTmp SET FTTmpStatus = '5', FTTmpRemark = '$tErrMsg'
        WHERE $tFieldName 
        IN(
            SELECT DISTINCT TMP1.$tFieldName FROM TCNTImpMasTmp TMP1 WITH (NOLOCK)
            INNER JOIN(
                SELECT $tFieldName , COUNT($tFieldName) AS FNCount
                FROM TCNTImpMasTmp WITH (NOLOCK)
                WHERE FTSessionID = '$tUserSessionID'
                AND FTTmpStatus = '1'
                $tWhereTableKey1
                $tWhereSeqNo1
                GROUP BY $tFieldName
            ) TMP2 ON TMP1.$tFieldName = TMP2.$tFieldName
            AND TMP1.FTTmpStatus = '1'
            AND TMP1.FTSessionID = '$tUserSessionID'
            AND TMP2.FNCount > 1 
            $tWhereTableKey2
            $tWhereSeqNo2
        ) 
    ";

    $tSQL .= $tWhereSeqNo1;
    $tSQL .= $tWhereTableKey1;
    $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID')";

    $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1; // พบข้อมูลรหัสซ้ำในตาราง Temp
    }else{
        return 0; // ไม่พบข้อมูลรหัสในตาราง Temp
    }
}

/**
 * Functionality: ตรวจสอบรหัสว่า ซ้ำใน Temp หรือไม่ (Multiple Field)
 * Parameters: Array เงื่อนไขการเช็คค่า [$paParams]
 * [tUserSessionID => '', aFieldName = ['field_name1', 'field_name2, ...]]
 * Creator: 02/07/2020 Piya
 * Last Modified: -
 * Return: Status
 * Return Type: Number
*/
function FCNnMasTmpChkCodeMultiDupInTemp(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['aFieldName']) || empty($paParams['aFieldName']) 
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    $tUserSessionID = $paParams['tUserSessionID'];
    $aFieldName = $paParams['aFieldName'];

    // Where Table Key
    $tWhereTableKey1 = "";
    $tWhereTableKey2 = "";
    if (!empty($paParams['tTableKey'])) {
        $tTableKey = $paParams['tTableKey'];
        $tWhereTableKey1 = " AND FTTmpTableKey = '$tTableKey'";
        $tWhereTableKey2 = " AND TMP1.FTTmpTableKey = '$tTableKey'";
    }

    // Where Seq In Table Edit InLine
    $tWhereSeqNo1 = "";
    $tWhereSeqNo2 = "";
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSeqNo1 = " AND FNTmpSeq = $tSeqNo";
        $tWhereSeqNo2 = " AND TMP1.FNTmpSeq = $tSeqNo";
    }

    $tErrMsg = language('common/main/main','กรอกข้อมูลซ้ำ');

    $tSQL = " 
        UPDATE TCNTImpMasTmp SET FTTmpStatus = '5', FTTmpRemark = '$tErrMsg'
        WHERE 1=1 
    ";

    $tFieldMulti = implode(", ", $aFieldName);
    $tFieldOn = "";

    foreach($aFieldName as $nIndex => $tFieldName) {
        if($nIndex == 0){
            $tFieldOn .= " ON TMP1.$tFieldName = TMP2.$tFieldName";
        }else{
            $tFieldOn .= " AND TMP1.$tFieldName = TMP2.$tFieldName";
        }
    }

    foreach($aFieldName as $tFieldName) {
        $tSQL .= "
            AND $tFieldName IN(
                SELECT DISTINCT TMP1.$tFieldName FROM TCNTImpMasTmp TMP1 WITH (NOLOCK)
                INNER JOIN(
                    SELECT $tFieldMulti, COUNT(*) AS FNCount
                    FROM TCNTImpMasTmp WITH (NOLOCK)
                    WHERE FTSessionID = '$tUserSessionID'
                    AND FTTmpStatus = '1'
                    GROUP BY $tFieldMulti
                ) TMP2 $tFieldOn
                AND TMP1.FTTmpStatus = '1'
                AND TMP1.FTSessionID = '$tUserSessionID'
                $tWhereTableKey2
                AND TMP2.FNCount > 1 
                $tWhereSeqNo2
            ) 
        ";
    }

    $tSQL .= $tWhereSeqNo1;
    $tSQL .= $tWhereTableKey1;
    $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID')";

    $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1; // พบข้อมูลรหัสซ้ำในตาราง Temp
    }else{
        return 0; // ไม่พบข้อมูลรหัสในตาราง Temp
    }
}

/**
 * Functionality: ตรวจสอบรหัสว่า ซ้ำใน Temp หรือไม่ (Edit Inline)
 * Parameters: Array เงื่อนไขการเช็คค่า [$paParams]
 * [tUserSessionID => '', tFieldName => '', tFieldValue => '']
 * Creator: 02/07/2020 Piya
 * Last Modified: -
 * Return: Status
 * Return Type: Number
*/
function FCNnMasTmpChkInlineCodeDupInTemp(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['tFieldName']) || empty($paParams['tFieldName'])
        || !isset($paParams['tFieldValue']) || empty($paParams['tFieldValue'])
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    $tUserSessionID = $paParams['tUserSessionID'];
    $tFieldName = $paParams['tFieldName'];

    $tFieldValue = $paParams['tFieldValue'];
    if (substr($paParams['tFieldName'],1,1) == "T") {
        $tFieldValue = "'".$paParams['tFieldValue']."'";
    }

    // Where Table Key
    $tWhereTableKey1 = "";
    $tWhereTableKey2 = "";
    if (!empty($paParams['tTableKey'])) {
        $tTableKey = $paParams['tTableKey'];
        $tWhereTableKey1 = " AND FTTmpTableKey = '$tTableKey'";
        $tWhereTableKey2 = " AND TMP1.FTTmpTableKey = '$tTableKey'";
    }

    // Where Seq In Table Edit InLine
    $tWhereSeqNo1 = "";
    $tWhereSeqNo2 = "";
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSeqNo1 = " AND FNTmpSeq = $tSeqNo";
        $tWhereSeqNo2 = " AND TMP1.FNTmpSeq = $tSeqNo";
    }

    $tSQL = " 
        UPDATE TCNTImpMasTmp SET FTTmpStatus = '1', FTTmpRemark = ''
        WHERE $tFieldName 
        IN(
            SELECT DISTINCT TMP1.$tFieldName FROM TCNTImpMasTmp TMP1 WITH (NOLOCK)
            INNER JOIN(
                SELECT $tFieldName /*, COUNT($tFieldName) AS FNCount*/
                FROM TCNTImpMasTmp WITH (NOLOCK)
                WHERE FTSessionID = '$tUserSessionID'
                AND $tFieldName = $tFieldValue
                $tWhereTableKey1
                GROUP BY $tFieldName
            ) TMP2 ON TMP1.$tFieldName = TMP2.$tFieldName
            AND TMP1.FTSessionID = '$tUserSessionID'
            /*AND TMP2.FNCount > 1*/ 
            $tWhereSeqNo2
            AND TMP1.$tFieldName = $tFieldValue
            $tWhereTableKey2
        ) 
    ";
    $tSQL .= $tWhereSeqNo1;
    $tSQL .= " AND (FTTmpStatus <> '1' AND FTSessionID = '$tUserSessionID' $tWhereTableKey1 )";

    $tErrMsg = language('common/main/main','กรอกข้อมูลซ้ำ');

    $tSQL .= " 
        UPDATE TCNTImpMasTmp SET FTTmpStatus = '5', FTTmpRemark = '$tErrMsg'
        WHERE $tFieldName 
        IN(
            SELECT DISTINCT TMP1.$tFieldName FROM TCNTImpMasTmp TMP1 WITH (NOLOCK)
            INNER JOIN(
                SELECT $tFieldName , COUNT($tFieldName) AS FNCount
                FROM TCNTImpMasTmp WITH (NOLOCK)
                WHERE FTSessionID = '$tUserSessionID'
                AND FTTmpStatus = '1'
                AND $tFieldName = $tFieldValue
                $tWhereTableKey1
                GROUP BY $tFieldName
            ) TMP2 ON TMP1.$tFieldName = TMP2.$tFieldName
            AND TMP1.FTTmpStatus = '1'
            AND TMP1.FTSessionID = '$tUserSessionID'
            AND TMP2.FNCount > 1 
            $tWhereSeqNo2
            AND TMP1.$tFieldName = $tFieldValue
            $tWhereTableKey2
        ) 
    ";

    $tSQL .= $tWhereSeqNo1;
    $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID' $tWhereTableKey1 )";

    // echo $tSQL;

    $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1; // พบข้อมูลรหัสซ้ำในตาราง Temp
    }else{
        return 0; // ไม่พบข้อมูลรหัสในตาราง Temp
    }
}

/**
 * Functionality: ตรวจสอบรหัสว่า ซ้ำใน Temp หรือไม่ (Multiple Field and Edit Inline)
 * Parameters: Array เงื่อนไขการเช็คค่า [$paParams]
 * [tUserSessionID => '', aFieldName = [['field_name1', 'value1'], ['field_name2', 'value2'], [...]]
 * Creator: 02/07/2020 Piya
 * Last Modified: -
 * Return: Status
 * Return Type: Number
*/
function FCNnMasTmpChkInlineCodeMultiDupInTemp(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['aFieldName']) || empty($paParams['aFieldName']) 
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    $tUserSessionID = $paParams['tUserSessionID'];
    $aFieldName = $paParams['aFieldName'];

    // Where Table Key
    $tWhereTableKey1 = "";
    $tWhereTableKey2 = "";
    if (!empty($paParams['tTableKey'])) {
        $tTableKey = $paParams['tTableKey'];
        $tWhereTableKey1 = " AND FTTmpTableKey = '$tTableKey'";
        $tWhereTableKey2 = " AND TMP1.FTTmpTableKey = '$tTableKey'";
    }

    // Where Seq In Table Edit InLine
    $tWhereSeqNo1 = "";
    $tWhereSeqNo2 = "";
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSeqNo1 = " AND FNTmpSeq = $tSeqNo";
        $tWhereSeqNo2 = " AND TMP1.FNTmpSeq = $tSeqNo";
    }

    $tFieldMulti = "";
    $tFieldOn = "";
    $tFieldWhere = "";
    $tFieldWhereTmp2 = "";

    foreach($aFieldName as $nIndex => $tField) {
        /**
         * tField[0] : fieldname, 
         * tField[1] : fieldvalue
         */
        if($nIndex == 0){
            $tFieldOn .= " ON TMP1.$tField[0] = TMP2.$tField[0]";
        }else{
            $tFieldOn .= " AND TMP1.$tField[0] = TMP2.$tField[0]";
        }

        $tFieldWhere .= " AND $tField[0] = '$tField[1]'";
        $tFieldWhereTmp2 .= " AND TMP2.$tField[0] = '$tField[1]'";

        if($nIndex == count($aFieldName)-1){
            $tFieldMulti .= "$tField[0] ";
        }else{
            $tFieldMulti .= "$tField[0], ";
        }
    }

    $tSQL = " 
        UPDATE TCNTImpMasTmp SET FTTmpStatus = '1', FTTmpRemark = ''
        WHERE 1=1 
    ";
    
    foreach($aFieldName as $nIndex => $tField) {
        /**
         * tField[0] : fieldname, 
         * tField[1] : fieldvalue
         */
        $tSQL .= "
            AND $tField[0] IN(
                SELECT DISTINCT TMP1.$tField[0] FROM TCNTImpMasTmp TMP1 WITH (NOLOCK)
                INNER JOIN(
                    SELECT $tFieldMulti/*, COUNT(*) AS FNCount*/
                    FROM TCNTImpMasTmp WITH (NOLOCK)
                    WHERE FTSessionID = '$tUserSessionID'
                    $tWhereTableKey1
                    GROUP BY $tFieldMulti
                ) TMP2 $tFieldOn
                AND TMP1.FTSessionID = '$tUserSessionID'
                /*AND TMP2.FNCount > 1*/ 
                $tWhereSeqNo2
                $tFieldWhereTmp2
                $tWhereTableKey2
            ) 
        ";
    }

    $tSQL .= $tWhereSeqNo1;
    $tSQL .= $tFieldWhere;
    $tSQL .= $tWhereTableKey1;
    $tSQL .= " AND (FTTmpStatus <> '1' AND FTSessionID = '$tUserSessionID')";


    $tErrMsg = language('common/main/main','กรอกข้อมูลซ้ำ');

    $tSQL .= " 
        UPDATE TCNTImpMasTmp SET FTTmpStatus = '5', FTTmpRemark = '$tErrMsg'
        WHERE 1=1 
    ";

    foreach($aFieldName as $nIndex => $tField) {
        /**
         * tField[0] : fieldname, 
         * tField[1] : fieldvalue
         */
        $tSQL .= "
            AND $tField[0] IN(
                SELECT DISTINCT TMP1.$tField[0] FROM TCNTImpMasTmp TMP1 WITH (NOLOCK)
                INNER JOIN(
                    SELECT $tFieldMulti, COUNT(*) AS FNCount
                    FROM TCNTImpMasTmp WITH (NOLOCK)
                    WHERE FTSessionID = '$tUserSessionID'
                    AND FTTmpStatus = '1'
                    $tWhereTableKey1
                    GROUP BY $tFieldMulti
                ) TMP2 $tFieldOn
                AND TMP1.FTTmpStatus = '1'
                AND TMP1.FTSessionID = '$tUserSessionID'
                AND TMP2.FNCount > 1 
                $tWhereSeqNo2
                $tFieldWhereTmp2
                $tWhereTableKey2
            ) 
        ";
    }

    $tSQL .= $tWhereSeqNo1;
    $tSQL .= $tFieldWhere;
    $tSQL .= $tWhereTableKey1;
    $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID')";

    $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1; // พบข้อมูลรหัสซ้ำในตาราง Temp
    }else{
        return 0; // ไม่พบข้อมูลรหัสในตาราง Temp
    }
}
/*===== End Temp Validate in TCNTImpMasTmp ================================================*/

//เช็คหน่วยซ้ำ - ยี่ห้อซ้ำ - สินค้าทัชซ้ำ
function FCNnMasTmpResetStatus(array $paParams = []){
    $ci = &get_instance();
    $ci->load->database();

    $tUserSessionID     = $paParams['tUserSessionID'];
    $tSQL               = "UPDATE TCNTImpMasTmp SET FTTmpStatus = 1 , FTTmpRemark = '' WHERE FTTmpTableKey = 'TCNMPDT' AND FTSessionID = '$tUserSessionID' AND FTTmpStatus = '2' ";
    $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1; // พบข้อมูลรหัสซ้ำในตาราง Temp
    }else{
        return 0; // ไม่พบข้อมูลรหัสในตาราง Temp
    }
}

function FCNnMasTmpChkCodeDupInDBSpecial(array $paParams = []){
    $ci = &get_instance();
    $ci->load->database();

    $tUserSessionID     = $paParams['tUserSessionID'];
    $tFieldName         = $paParams['tFieldName'];
    $tTableCheck        = $paParams['tTableCheck'];
    
    switch ($tTableCheck) {
        case "TCNMPdtUnit":
            $tSQL = "UPDATE T SET 
                        T.FTTmpStatus = '2', 
                        T.FTTmpRemark = 'ไม่พบหน่วยสินค้า' 
                    FROM TCNTImpMasTmp T INNER JOIN (
                    SELECT 
                        PDT.FTSessionID ,
                        PDT.FTPdtCode ,
                        PDT.FTPunCode , 
                        TMP.FTPunCode AS haveSheet ,
                        MAS.FTPunCode AS haveMaster
                    FROM TCNTImpMasTmp PDT
                    LEFT JOIN TCNTImpMasTmp TMP ON PDT.FTPunCode = TMP.FTPunCode 
                        AND PDT.FTSessionID = TMP.FTSessionID 
                        AND TMP.FTTmpTableKey = 'TCNMPdtUnit' 
                        AND TMP.FTTmpStatus = 1
                    LEFT JOIN TCNMPdtUnit MAS ON PDT.FTPunCode = MAS.FTPunCode
                    WHERE 
                    PDT.FTTmpTableKey = 'TCNMPdt' AND PDT.FTTmpStatus = 1
                    AND PDT.FTSessionID = '$tUserSessionID'
                    AND isnull(TMP.FTPunCode,'') + isnull(MAS.FTPunCode,'') = ''
                    ) C ON C.FTPdtCode = T.FTPdtCode AND C.FTSessionID = T.FTSessionID AND C.FTPunCode = T.FTPunCode";
        break;
        case "TCNMPdtTouchGrp":
            $tSQL = "UPDATE T SET 
                        T.FTTmpStatus = '2', 
                        T.FTTmpRemark = 'ไม่พบรหัสกลุ่มสินค้าทัช' 
                    FROM TCNTImpMasTmp T INNER JOIN (
                    SELECT 
                        PDT.FTSessionID ,
                        PDT.FTPdtCode ,
                        PDT.FTTcgCode , 
                        TMP.FTTcgCode AS haveSheet ,
                        MAS.FTTcgCode AS haveMaster
                    FROM TCNTImpMasTmp PDT
                    LEFT JOIN TCNTImpMasTmp TMP ON PDT.FTTcgCode = TMP.FTTcgCode 
                        AND PDT.FTSessionID = TMP.FTSessionID 
                        AND TMP.FTTmpTableKey = 'TCNMPdtTouchGrp' 
                        AND TMP.FTTmpStatus = 1
                    LEFT JOIN TCNMPdtTouchGrp MAS ON PDT.FTTcgCode = MAS.FTTcgCode
                    WHERE 
                    PDT.FTTmpTableKey = 'TCNMPdt' AND PDT.FTTmpStatus = 1
                    AND PDT.FTSessionID = '$tUserSessionID'
                    AND isnull(TMP.FTTcgCode,'') + isnull(MAS.FTTcgCode,'') = ''
                    AND (PDT.FTTcgCode <> '' AND PDT.FTTcgCode IS NOT NULL)
                    ) C ON C.FTPdtCode = T.FTPdtCode AND C.FTSessionID = T.FTSessionID AND C.FTTcgCode = T.FTTcgCode";
        break;
        case "TCNMPdtBrand":
            $tSQL = "UPDATE T SET 
                        T.FTTmpStatus = '2', 
                        T.FTTmpRemark = 'ไม่พบรหัสยี่ห้อ' 
                    FROM TCNTImpMasTmp T INNER JOIN (
                    SELECT 
                        PDT.FTSessionID ,
                        PDT.FTPdtCode ,
                        PDT.FTPbnCode , 
                        TMP.FTPbnCode AS haveSheet ,
                        MAS.FTPbnCode AS haveMaster
                    FROM TCNTImpMasTmp PDT
                    LEFT JOIN TCNTImpMasTmp TMP ON PDT.FTPbnCode = TMP.FTPbnCode 
                        AND PDT.FTSessionID = TMP.FTSessionID 
                        AND TMP.FTTmpTableKey = 'TCNMPdtBrand' 
                        AND TMP.FTTmpStatus = 1
                    LEFT JOIN TCNMPdtBrand MAS ON PDT.FTPbnCode = MAS.FTPbnCode
                    WHERE 
                    PDT.FTTmpTableKey = 'TCNMPdt' AND PDT.FTTmpStatus = 1
                    AND PDT.FTSessionID = '$tUserSessionID'
                    AND isnull(TMP.FTPbnCode,'') + isnull(MAS.FTPbnCode,'') = ''
                    AND (PDT.FTPbnCode <> '' AND PDT.FTPbnCode IS NOT NULL)
                    ) C ON C.FTPdtCode = T.FTPdtCode AND C.FTSessionID = T.FTSessionID AND C.FTPbnCode = T.FTPbnCode";
        break;
    }

    $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1; // พบข้อมูลรหัสซ้ำในตาราง Temp
    }else{
        return 0; // ไม่พบข้อมูลรหัสในตาราง Temp
    }
}

/**
* Functionality:ตรวจสอบรหัสว่ามีอยู่จริงหรือไม่ (For Promotion DT)
* Parameters: Array เงื่อนไขการเช็คค่า [paParams]
* [tUserSessionID => '', tFieldName => '', tTableName => '', tErrMsg => '']
* Creator: 02/07/2020 Piya
* Last Modified: -
* Return: Status
* Return Type: Number
*/
function FCNnMasTmpPmtChkCodeInDB(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['tFieldName']) || empty($paParams['tFieldName']) 
        || !isset($paParams['tTableName']) || empty($paParams['tTableName'])
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============    
    $tUserSessionID = $paParams['tUserSessionID'];
    $tFieldName = $paParams['tFieldName'];
    $tTablename = $paParams['tTableName'];

    // Where Table Key
    $tWhereTableKey = "";
    $tWhereTableKeyTmp = "";
    $tWhereTableKeyTmp1 = "";
    if (!empty($paParams['tTableKey'])) {
        $tTableKey = $paParams['tTableKey'];
        $tWhereTableKey = " AND FTTmpTableKey = '$tTableKey'";
        $tWhereTableKeyTmp = " AND TMP.FTTmpTableKey = '$tTableKey'";
        $tWhereTableKeyTmp1 = " AND TMP1.FTTmpTableKey = '$tTableKey'";
    }

    // Where Seq In Table Edit InLine
    $tWhereSeqNo = "";
    $tWhereSeqNoTmp = "";
    $tWhereSeqNoTmp1 = "";
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSeqNo = " AND FNTmpSeq = $tSeqNo";
        $tWhereSeqNoTmp = " AND TMP.FNTmpSeq = $tSeqNo";
        $tWhereSeqNoTmp1 = " AND TMP1.FNTmpSeq = $tSeqNo";
    }

    $tErrMsg = isset($paParams['tErrMsg'])?$paParams['tErrMsg']:language('common/main/main','ข้อมูลอ้างอิงไม่ถูกต้อง');
    $tFieldNameTmp = $tFieldName."Temp";

    $tSQL = " 
        UPDATE TCNTImpMasTmp SET FTTmpStatus = '2', FTTmpRemark = '$tErrMsg'
        WHERE $tFieldName
        NOT IN(
            SELECT DISTINCT TMP1.$tFieldName FROM TCNTImpMasTmp TMP1 WITH (NOLOCK)
            INNER JOIN(
                SELECT TMP.$tFieldName AS $tFieldNameTmp, ISNULL(MAS.$tFieldName,MAS.$tFieldName) AS $tFieldName
                FROM TCNTImpMasTmp TMP
                LEFT JOIN $tTablename MAS WITH (NOLOCK) ON TMP.$tFieldName = MAS.$tFieldName
                WHERE 1=1
                AND TMP.FTTmpStatus = '1'
                AND TMP.FTSessionID = '$tUserSessionID'
                $tWhereSeqNoTmp
                $tWhereTableKeyTmp
            ) TMP2 ON TMP1.$tFieldName = TMP2.$tFieldName
            $tWhereSeqNoTmp1
            $tWhereTableKeyTmp1
        ) 
    ";
    
    $tSQL .= $tWhereSeqNo;
    $tSQL .= $tWhereTableKey;
    $tSQL .= " AND FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID' AND ($tFieldName <> '' AND $tFieldName IS NOT NULL) AND FTBarCode <> '*'";
    
    $ci->db->query($tSQL);

    if($ci->db->affected_rows() > 0){
        return 1;   // ไม่พบข้อมูลในระบบ
    }else{
        return 0;   // พบข้อมูลในระบบ
    }
}

/**
 * Functionality: ตรวจสอบรหัสว่า ซ้ำใน Temp หรือไม่ (For Promotion DT)
 * Parameters: Array เงื่อนไขการเช็คค่า [$paParams]
 * [tUserSessionID => '', tFieldName => '', tTableKey => '']
 * Creator: 02/07/2020 Piya
 * Last Modified: -
 * Return: Status
 * Return Type: Number
*/
function FCNnMasTmpPmtChkCodeDupOnTypeInTemp(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['tFieldName']) || empty($paParams['tFieldName'])
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    $tUserSessionID = $paParams['tUserSessionID'];
    $tFieldName = $paParams['tFieldName'];

    $tPmdStaType = $paParams['tPmdStaType'];

    // Where Table Key
    $tWhereTableKey1 = "";
    $tWhereTableKey2 = "";
    if (!empty($paParams['tTableKey'])) {
        $tTableKey = $paParams['tTableKey'];
        $tWhereTableKey1 = " AND FTTmpTableKey = '$tTableKey'";
        $tWhereTableKey2 = " AND TMP1.FTTmpTableKey = '$tTableKey'";
    }

    // Where Seq In Table Edit InLine
    $tWhereSeqNo1 = "";
    $tWhereSeqNo2 = "";
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSeqNo1 = " AND FNTmpSeq = $tSeqNo";
        $tWhereSeqNo2 = " AND TMP1.FNTmpSeq = $tSeqNo";
    }

    $tErrMsg = language('common/main/main','กรอกข้อมูลซ้ำ');

    $tSQL = " 
        UPDATE TCNTImpMasTmp SET FTTmpStatus = '5', FTTmpRemark = '$tErrMsg'
        WHERE $tFieldName 
        IN(
            SELECT DISTINCT TMP1.$tFieldName FROM TCNTImpMasTmp TMP1 WITH (NOLOCK)
            INNER JOIN(
                SELECT $tFieldName , COUNT($tFieldName) AS FNCount
                FROM TCNTImpMasTmp WITH (NOLOCK)
                WHERE FTSessionID = '$tUserSessionID'
                AND FTTmpStatus = '1'
                AND FTPmdStaType = '$tPmdStaType'
                $tWhereTableKey1
                $tWhereSeqNo1
                GROUP BY $tFieldName
            ) TMP2 ON TMP1.$tFieldName = TMP2.$tFieldName
            AND TMP1.FTTmpStatus = '1'
            AND TMP1.FTSessionID = '$tUserSessionID'
            AND TMP2.FNCount > 1 
            AND FTPmdStaType = '$tPmdStaType'
            $tWhereTableKey2
            $tWhereSeqNo2
        ) 
    ";

    $tSQL .= $tWhereSeqNo1;
    $tSQL .= $tWhereTableKey1;
    $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID' AND FTPmdStaType = '$tPmdStaType')";

    // $tSQL = " 
    //     UPDATE TCNTImpMasTmp SET FTTmpStatus = '5', FTTmpRemark = '$tErrMsg'
    //     WHERE $tFieldName 
    //     IN(
    //         SELECT DISTINCT TMP1.$tFieldName FROM TCNTImpMasTmp TMP1 WITH (NOLOCK)
    //         INNER JOIN(
    //             SELECT $tFieldName , COUNT($tFieldName) AS FNCount
    //             FROM TCNTImpMasTmp WITH (NOLOCK)
    //             WHERE FTSessionID = '$tUserSessionID'
    //             AND FTTmpStatus = '1'
    //             AND FTPmdStaType = '$tPmdStaType'
    //             $tWhereTableKey1
    //             $tWhereSeqNo1
    //             GROUP BY $tFieldName
    //         ) TMP2 ON TMP1.$tFieldName = TMP2.$tFieldName
    //         AND TMP1.FTTmpStatus = '1'
    //         AND TMP1.FTSessionID = '$tUserSessionID'
    //         AND TMP2.FNCount > 1 
    //         AND FTPmdStaType = '$tPmdStaType'
    //         $tWhereTableKey2
    //         $tWhereSeqNo2
    //     ) 
    // ";

    // $tSQL .= $tWhereSeqNo1;
    // $tSQL .= $tWhereTableKey1;
    // $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID' AND FTPmdStaType = '$tPmdStaType')";
    
    $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1; // พบข้อมูลรหัสซ้ำในตาราง Temp
    }else{
        return 0; // ไม่พบข้อมูลรหัสในตาราง Temp
    }
}

/**
 * Functionality: ตรวจสอบรหัสว่า ซ้ำใน Temp หรือไม่ (For Promotion DT)
 * Parameters: Array เงื่อนไขการเช็คค่า [$paParams]
 * [tUserSessionID => '', tFieldName => '', tTableKey => '']
 * Creator: 02/07/2020 Piya
 * Last Modified: -
 * Return: Status
 * Return Type: Number
*/
function FCNnMasTmpPmtChkCodeDupOnNameInTemp(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['tFieldName']) || empty($paParams['tFieldName'])
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    $tUserSessionID = $paParams['tUserSessionID'];
    $tFieldName = $paParams['tFieldName'];

    $tPmdGrpName = $paParams['tPmdGrpName'];

    // Where Table Key
    $tWhereTableKey1 = "";
    $tWhereTableKey2 = "";
    if (!empty($paParams['tTableKey'])) {
        $tTableKey = $paParams['tTableKey'];
        $tWhereTableKey1 = " AND FTTmpTableKey = '$tTableKey'";
        $tWhereTableKey2 = " AND TMP1.FTTmpTableKey = '$tTableKey'";
    }

    // Where Seq In Table Edit InLine
    $tWhereSeqNo1 = "";
    $tWhereSeqNo2 = "";
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSeqNo1 = " AND FNTmpSeq = $tSeqNo";
        $tWhereSeqNo2 = " AND TMP1.FNTmpSeq = $tSeqNo";
    }

    $tErrMsg = language('common/main/main','กรอกข้อมูลซ้ำ');

    $tSQL = " 
        UPDATE TCNTImpMasTmp SET FTTmpStatus = '5', FTTmpRemark = '$tErrMsg'
        WHERE $tFieldName 
        IN(
            SELECT DISTINCT TMP1.$tFieldName FROM TCNTImpMasTmp TMP1 WITH (NOLOCK)
            INNER JOIN(
                SELECT $tFieldName , COUNT($tFieldName) AS FNCount
                FROM TCNTImpMasTmp WITH (NOLOCK)
                WHERE FTSessionID = '$tUserSessionID'
                AND FTTmpStatus = '1'
                AND FTPmdGrpName = '$tPmdGrpName'
                $tWhereTableKey1
                $tWhereSeqNo1
                GROUP BY $tFieldName
            ) TMP2 ON TMP1.$tFieldName = TMP2.$tFieldName
            AND TMP1.FTTmpStatus = '1'
            AND TMP1.FTSessionID = '$tUserSessionID'
            AND TMP2.FNCount > 1 
            AND FTPmdGrpName = '$tPmdGrpName'
            $tWhereTableKey2
            $tWhereSeqNo2
        ) 
    ";

    $tSQL .= $tWhereSeqNo1;
    $tSQL .= $tWhereTableKey1;
    $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID' AND FTPmdGrpName = '$tPmdGrpName')";
    
    $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1; // พบข้อมูลรหัสซ้ำในตาราง Temp
    }else{
        return 0; // ไม่พบข้อมูลรหัสในตาราง Temp
    }
}

/**
 * Functionality: ตรวจสอบรหัสว่า ซ้ำใน Temp หรือไม่ (Edit Inline For Promotion DT)
 * Parameters: Array เงื่อนไขการเช็คค่า [$paParams]
 * [tUserSessionID => '', tFieldName => '', tFieldValue => '']
 * Creator: 02/07/2020 Piya
 * Last Modified: -
 * Return: Status
 * Return Type: Number
*/
function FCNnMasTmpPmtChkInlineCodeDupInTemp(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['tFieldName']) || empty($paParams['tFieldName'])
        || !isset($paParams['tFieldValue']) || empty($paParams['tFieldValue'])
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    $tUserSessionID = $paParams['tUserSessionID'];
    $tFieldName = $paParams['tFieldName'];

    $tFieldValue = $paParams['tFieldValue'];
    if (substr($paParams['tFieldName'],1,1) == "T") {
        $tFieldValue = "'".$paParams['tFieldValue']."'";
    }

    // Where Table Key
    $tWhereTableKey1 = "";
    $tWhereTableKey2 = "";
    if (!empty($paParams['tTableKey'])) {
        $tTableKey = $paParams['tTableKey'];
        $tWhereTableKey1 = " AND FTTmpTableKey = '$tTableKey'";
        $tWhereTableKey2 = " AND TMP1.FTTmpTableKey = '$tTableKey'";
    }

    // Where Seq In Table Edit InLine
    $tWhereSeqNo1 = "";
    $tWhereSeqNo2 = "";
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSeqNo1 = " AND FNTmpSeq = $tSeqNo";
        $tWhereSeqNo2 = " AND TMP1.FNTmpSeq = $tSeqNo";
    }

    $tSQL = " 
        UPDATE TCNTImpMasTmp SET FTTmpStatus = '1', FTTmpRemark = ''
        WHERE $tFieldName 
        IN(
            SELECT DISTINCT TMP1.$tFieldName FROM TCNTImpMasTmp TMP1 WITH (NOLOCK)
            INNER JOIN(
                SELECT $tFieldName /*, COUNT($tFieldName) AS FNCount*/
                FROM TCNTImpMasTmp WITH (NOLOCK)
                WHERE FTSessionID = '$tUserSessionID'
                AND $tFieldName = $tFieldValue
                $tWhereTableKey1
                GROUP BY $tFieldName
            ) TMP2 ON TMP1.$tFieldName = TMP2.$tFieldName
            AND TMP1.FTSessionID = '$tUserSessionID'
            /*AND TMP2.FNCount > 1*/ 
            $tWhereSeqNo2
            AND TMP1.$tFieldName = $tFieldValue
            $tWhereTableKey2
        ) 
    ";
    $tSQL .= $tWhereSeqNo1;
    $tSQL .= " AND (FTTmpStatus <> '1' AND FTSessionID = '$tUserSessionID' $tWhereTableKey1 )";

    // $tErrMsg = language('common/main/main','กรอกข้อมูลซ้ำ');

    // $tSQL .= " 
    //     UPDATE TCNTImpMasTmp SET FTTmpStatus = '5', FTTmpRemark = '$tErrMsg'
    //     WHERE $tFieldName 
    //     IN(
    //         SELECT DISTINCT TMP1.$tFieldName FROM TCNTImpMasTmp TMP1 WITH (NOLOCK)
    //         INNER JOIN(
    //             SELECT $tFieldName , COUNT($tFieldName) AS FNCount
    //             FROM TCNTImpMasTmp WITH (NOLOCK)
    //             WHERE FTSessionID = '$tUserSessionID'
    //             AND FTTmpStatus = '1'
    //             AND $tFieldName = $tFieldValue
    //             $tWhereTableKey1
    //             GROUP BY $tFieldName
    //         ) TMP2 ON TMP1.$tFieldName = TMP2.$tFieldName
    //         AND TMP1.FTTmpStatus = '1'
    //         AND TMP1.FTSessionID = '$tUserSessionID'
    //         AND TMP2.FNCount > 1 
    //         $tWhereSeqNo2
    //         AND TMP1.$tFieldName = $tFieldValue
    //         $tWhereTableKey2
    //     ) 
    // ";

    // $tSQL .= $tWhereSeqNo1;
    // $tSQL .= " AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID' $tWhereTableKey1 )";

    // echo $tSQL;

    $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1; // พบข้อมูลรหัสซ้ำในตาราง Temp
    }else{
        return 0; // ไม่พบข้อมูลรหัสในตาราง Temp
    }
}

/**
* Functionality:ตรวจสอบรหัสว่ามีอยู่จริงหรือไม่ (Temp) (For Promotion CB,CG)
* Parameters: Array เงื่อนไขการเช็คค่า [paParams]
* [tUserSessionID => '', tFieldName => '', tTableName => '', tErrMsg => '']
* Creator: 02/07/2020 Piya
* Last Modified: -
* Return: Status
* Return Type: Number
*/
function FCNnMasTmpPmtChkCodeInTemp(array $paParams = [])
{
    if(
        !isset($paParams['tUserSessionID']) || empty($paParams['tUserSessionID']) 
        || !isset($paParams['tFieldName']) || empty($paParams['tFieldName']) 
        || !isset($paParams['tTableName']) || empty($paParams['tTableName'])
    ) {
        return;
    }

    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============    
    $tUserSessionID = $paParams['tUserSessionID'];
    $tFieldName = $paParams['tFieldName'];
    $tTablename = $paParams['tTableName'];
    $tTableKeyIn = $paParams['tTableKeyIn'];

    // Where Table Key
    $tWhereTableKey = "";
    $tWhereTableKeyTmp = "";
    $tWhereTableKeyTmp1 = "";
    $tWhereTableKeyMas = "";
    if (!empty($paParams['tTableKey'])) {
        $tTableKey = $paParams['tTableKey'];
        $tWhereTableKey = " AND FTTmpTableKey = '$tTableKey'";
        $tWhereTableKeyTmp = " AND TMP.FTTmpTableKey = '$tTableKey'";
        $tWhereTableKeyTmp1 = " AND TMP1.FTTmpTableKey = '$tTableKey'";
        $tWhereTableKeyMas = " AND MAS.FTTmpTableKey = '$tTableKeyIn'";
    }

    // Where Seq In Table Edit InLine
    $tWhereSeqNo = "";
    $tWhereSeqNoTmp = "";
    $tWhereSeqNoTmp1 = "";
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])){
        $tSeqNo = $paParams['tSeqNo'];
        $tWhereSeqNo = " AND FNTmpSeq = $tSeqNo";
        $tWhereSeqNoTmp = " AND TMP.FNTmpSeq = $tSeqNo";
        $tWhereSeqNoTmp1 = " AND TMP1.FNTmpSeq = $tSeqNo";
    }

    $tErrMsg = isset($paParams['tErrMsg'])?$paParams['tErrMsg']:language('common/main/main','ข้อมูลอ้างอิงไม่ถูกต้อง');
    $tFieldNameTmp = $tFieldName."Temp";

    $tSQL = " 
        UPDATE TCNTImpMasTmp SET FTTmpStatus = '2', FTTmpRemark = '$tErrMsg'
        WHERE $tFieldName
        NOT IN(
            SELECT DISTINCT TMP1.$tFieldName FROM TCNTImpMasTmp TMP1 WITH (NOLOCK)
            INNER JOIN(
                SELECT TMP.$tFieldName AS $tFieldNameTmp, ISNULL(MAS.$tFieldName,MAS.$tFieldName) AS $tFieldName
                FROM TCNTImpMasTmp TMP
                LEFT JOIN $tTablename MAS WITH (NOLOCK) ON TMP.$tFieldName = MAS.$tFieldName AND MAS.FTTmpStatus = '1' AND MAS.FTSessionID = '$tUserSessionID' $tWhereTableKeyMas
                WHERE 1=1
                AND TMP.FTTmpStatus = '1'
                AND TMP.FTSessionID = '$tUserSessionID'
                $tWhereSeqNoTmp
                $tWhereTableKeyTmp
            ) TMP2 ON TMP1.$tFieldName = TMP2.$tFieldName
            $tWhereSeqNoTmp1
            $tWhereTableKeyTmp1
        )
    ";
    
    $tSQL .= $tWhereSeqNo;
    $tSQL .= $tWhereTableKey;
    $tSQL .= " 
        AND (FTTmpStatus = '1' AND FTSessionID = '$tUserSessionID') 
        AND ($tFieldName <> '' AND $tFieldName IS NOT NULL)
        OR (
            FTPmdGrpName IN(
                SELECT
                    FTPmdGrpName
                FROM TCNTImpMasTmp
                WHERE FTPmdStaType = '3' 
                AND FTTmpStatus = '1' 
                AND FTSessionID = '$tUserSessionID'
                AND FTTmpTableKey = 'PMT_DT'
            )
            $tWhereTableKey
        )
    ";
    
    $ci->db->query($tSQL);

    if($ci->db->affected_rows() > 0){
        return 1;   // ไม่พบข้อมูลในระบบ
    }else{
        return 0;   // พบข้อมูลในระบบ
    }
}