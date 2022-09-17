<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settingdairycurrency_model extends CI_Model
{

    //Get App Type เอาไปไว้ใน Option
    // Last Update : 13/08/2020 Napat(Jame)
    public function FSaMSETGetAppTpye()
    {
        // $tSQL   = "SELECT DISTINCT FTSysApp from TSysConfig";
        $nLngID = $this->session->userdata("tLangEdit");
        $tSQL = "   SELECT 
                        APP.FTAppCode,
                        APPL.FTAppName
                    FROM TsysApp APP WITH(NOLOCK)
                    INNER JOIN TSysApp_L APPL WITH(NOLOCK) ON APP.FTAppCode = APPL.FTAppCode AND APPL.FNLngID = $nLngID
                    WHERE FTAppVersion = '5'
                ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////// แท็บตั้งค่าระบบ

    //Load Datatable Type Checkbox
    // Last Update : 13/08/2020 Napat(Jame)
    public function FSaMSETConfigDataTableByCurrentcy($paData, $ptType)
    {
        $nLngID = $paData['FNLngID'];
        $tAgnCode   = $paData['FTAgnCode'];
        $tSearchList = $paData['tSearchAll'];
        $tAgnCodeChk   = $paData['tAgnCode'];
        $tSQL   = "SELECT
                    RATE.FTAgnCode,
                    AGNL.FTAgnName,
                    RATE.FTRteCode,
                    RATEL.FTRteName,
                    RATE.FCRteRate,
                    RATE.FCRteLastRate,
                    Job.FDJobDateCfm
                FROM
                    TFNMRate RATE WITH(NOLOCK)
                    LEFT JOIN TFNMRate_L RATEL WITH(NOLOCK) ON RATE.FTAgnCode = RATEL.FTAgnCode 
                    AND RATE.FTRteCode = RATEL.FTRteCode 
                    AND RATEL.FNLngID = '$nLngID'
                    LEFT JOIN TCNMAgency_L AGNL WITH(NOLOCK) ON RATE.FTAgnCode = AGNL.FTAgnCode 
                    AND AGNL.FNLngID = '$nLngID'
                    LEFT JOIN TCNSJobTask Job WITH(NOLOCK) ON RATE.FTAgnCode = job.FTAgnCode
                    WHERE RATE.FTRteStaUse = '1'
                ";
            if($tAgnCode != ''){
                $tSQL .= " AND RATE.FTAgnCode = '$tAgnCode' ";
            }
            if($tAgnCodeChk){
                $tSQL .= " AND RATE.FTAgnCode = '$tAgnCodeChk'";
            }

            if ($tSearchList != '') {
                $tSQL .= " AND (RATEL.FTRteName LIKE '%$tSearchList%'";
                $tSQL .= "      OR RATE.FTRteCode LIKE '%$tSearchList%')";
            }

        $tSQL   .= " ORDER BY RATE.FTRteCode DESC ";
        // echo $tSQL;
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aResult    = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }


    public function FSaMCurentcyGetLastUpdate($paData)
    {
        try{
            $nLngID = $paData['FNLngID'];
            $tAgnCode   = $paData['FTAgnCode'];
            $tSQL = " SELECT FDRteLastUpdOn FROM TFNMRate ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                $oList      = $oQuery->result();
                $aResult    = array(
                    'raItems'       => $oList,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                );
            } else {
                $aResult    = array(
                    'rtCode'        => '800',
                    'rtDesc'        => 'data not found',
                );
            }
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
            return $aResult;
        }catch (Exception $Error) {
            return $Error;
        }
    }

    public function FSaMCurentcyUpdate($paData)
    {
        try {
            // $nDecimalCurrentcySave = FCNxHGetOptionDecimalCurrencySave();
            // echo '<pre>';
            // echo $paData['FTRteCode']." : ".number_format($paData['FCRteRate'],$nDecimalCurrentcySave,".","");
            // echo '</pre>';

            $nDecimalCurrentcySave = FCNxHGetOptionDecimalCurrencySave();
            $tAgnCode = $paData['FTAgnCode'];
                $this->db->set('FCRteRate', number_format($paData['FCRteRate'],$nDecimalCurrentcySave,".",""));
                $this->db->set('FDLastUpdOn', date('Y-m-d H:i:s'));
                $this->db->set('FTLastUpdBy', $_SESSION['tSesUsername']);
                $this->db->where('FTAgnCode', $paData['FTAgnCode']);
                $this->db->where('FTRteCode', $paData['FTRteCode']);
                $this->db->update('TFNMRate');
        } catch (Exception $Error) {
            return $Error;
        }
    }

    public function FSaMCurentcyTashUpdate($paData)
    {
        try {
        $tAgnCode   = $paData['FTAgnCode'];
        $tCreateOn = date("Y-m-d H:i:s");
        $tAgnCodeSelect = $paData['tAgnCode'];
        $tUserName = $this->session->userdata('tSesUsername');
        $tSQLGetAllAgn   = "SELECT FTAgnCode FROM TFNMRate WITH(NOLOCK) WHERE 1=1 ";
        if($tAgnCode != ''){
            $tSQLGetAllAgn   .= " AND FTAgnCode = '$tAgnCode' ";
        }
        $tSQLGetAllAgn  .= "GROUP BY FTAGNCode ";
        $oQueryAllAgn = $this->db->query($tSQLGetAllAgn);
        $oListAllAgn      = $oQueryAllAgn->result_array();
    
        foreach($oListAllAgn AS $nKey => $aVal){
            $tValAgn  = $aVal['FTAgnCode'];

            $tSQL   = "SELECT FTAgnCode FROM TCNSJobTask WITH(NOLOCK)";
            if($tAgnCodeSelect != ''){
                $tSQL .= "WHERE FTAgnCode = '$tAgnCodeSelect' ";
            }else{
                $tSQL .= "WHERE FTAgnCode = '$tValAgn' ";
            }
            $oQuery = $this->db->query($tSQL);
            $oListAgn      = $oQuery->result_array();
            
            if (count($oListAgn) > 0) {
                $this->db->set('FDJobDateCfm', $tCreateOn);
                $this->db->set('FDLastUpdOn', $tCreateOn);
                $this->db->set('FTLastUpdBy', $tUserName);
                if($tAgnCodeSelect != ''){
                    $this->db->where('FTAgnCode', $tAgnCodeSelect);
                }else{
                    $this->db->where('FTAgnCode', $tValAgn);
                }
                $this->db->update('TCNSJobTask');
            } else {
                $tValAgn = ($tAgnCodeSelect != '') ? $tAgnCodeSelect : $tValAgn ;
                $tSQL = "INSERT INTO TCNSJobTask(FTAgnCode, FTJobRefTbl, FDJobDateCfm, FTJobStaUse, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
                VALUES( 
                    '$tValAgn',
                    'TFNMRate',
                    '$tCreateOn',
                    '1',
                    '$tCreateOn',
                    '$tUserName',
                    '$tCreateOn',
                    '$tUserName'
                    ) ";   
                $oQuery = $this->db->query($tSQL);
            }
        }
        
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //Update ค่าเริ่มต้น
    public function FSaMSETUseValueDefult()
    {
        $tSQL   = "UPDATE SETHD
                    SET 
                        SETHD.FTSysStaUsrValue = SETDT.FTSysStaDefValue,
                        SETHD.FTSysStaUsrRef = SETDT.FTSysStaDefRef
                    FROM TSysConfig SETHD
                    LEFT JOIN TSysConfig SETDT 
                    ON 
                        SETHD.FTSysApp = SETDT.FTSysApp 
                        AND SETHD.FTSysKey = SETDT.FTSysKey 
                        AND SETHD.FTSysSeq = SETDT.FTSysSeq 
                        AND SETHD.FTGmnCode = SETDT.FTGmnCode 
                        AND SETHD.FTSysStaDataType = SETDT.FTSysStaDataType";
        $oQuery = $this->db->query($tSQL);
        if ($this->db->affected_rows() > 0) {
            $aResult    = array(
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aResult    = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////// แท็บรหัสอัตโนมัติ

    public function FSaMSETConfigDataTableAutoNumber($paData)
    {
        $nLngID = $paData['FNLngID'];
        $tSQL   = "SELECT 
                        AO.FTSatTblName,
                        AO.FTSatStaDocType,
                        AO.FNSatMaxFedSize,
                        AO.FTSatDefFmtAll AS DefFmt,
                        AO.FTSatStaReset AS DefResetFmt,
                        TXN.FTAhmFmtAll AS UsrFmt,
                        TXN.FTAhmFmtReset AS UsrResetFmt,
                        AOL.FTSatTblDesc
                FROM [TCNTAuto] AO
                LEFT JOIN [TCNTAuto_L] AOL ON AO.FTSatTblName = AOL.FTSatTblName AND AO.FTSatFedCode = AOL.FTSatFedCode AND AO.FTSatStaDocType = AOL.FTSatStaDocType 
                LEFT JOIN [TCNTAutoHisTxn] TXN ON AO.FTSatTblName = TXN.FTAhmTblName AND AO.FTSatFedCode = TXN.FTAhmFedCode AND AO.FTSatStaDocType = TXN.FTSatStaDocType
                AND AOL.FNLngID = $nLngID
                WHERE 1=1 ";

        $tSearchList = trim($paData['tSearchAll']);
        if ($tSearchList != '') {
            $tSQL .= " AND (AO.FTSatTblName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= "      OR AOL.FTSatTblDesc COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= "      OR TXN.FTAhmFmtAll COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= "      OR TXN.FTAhmFmtAll COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= "      OR AO.FTSatTblName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= "      OR AO.FTSatDefChar COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= "      OR AO.FTSatStaDocType COLLATE THAI_BIN LIKE '%$tSearchList%')";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aResult    = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //อนุญาติให้จัดรูปแบบจากอะไรบ้างข้อมูล DT
    public function FSaMSETConfigGetAllowDataAutoNumber($paData)
    {
        $tTable = $paData['FTSatTblName'];
        $tType  = $paData['FTSatStaDocType'];

        $tSQL   = "SELECT 
                       AO.FTSatStaAlwChr ,
                       AO.FTSatStaAlwBch , 
                       AO.FTSatStaAlwPosShp , 
                       AO.FTSatStaAlwYear , 
                       AO.FTSatStaAlwMonth ,
                       AO.FTSatStaAlwDay , 
                       AO.FTSatStaAlwSep ,
                       AO.FNSatMinRunning ,
                       AO.FTSatDefFmtAll ,
                       AO.FTSatStaDefUsage,
                       AOL.FTSatTblDesc ,
                       AO.FNSatMaxFedSize ,
                       AO.FTSatDefChar,
                       AO.FTSatTblName,
                       AO.FTSatFedCode,
                       AO.FTSatStaDocType,
                       AO.FTSatDefNum,
                       TXN.FTAhmFmtAll AS FormatCustom,
                       TXN.FTAhmFmtPst,
                       TXN.FTAhmFmtChar,
                       TXN.FTAhmFmtReset,
                       TXN.FTSatStaAlwSep,
                       TXN.FTAhmFmtYear,
                       TXN.FNAhmFedSize,
                       TXN.FNAhmNumSize,
                       TXN.FTSatUsrNum
                FROM [TCNTAuto] AO
                LEFT JOIN [TCNTAuto_L] AOL ON AO.FTSatTblName = AOL.FTSatTblName AND AO.FTSatFedCode = AOL.FTSatFedCode AND AO.FTSatStaDocType = AOL.FTSatStaDocType 
                LEFT JOIN [TCNTAutoHisTxn] TXN ON AO.FTSatTblName = TXN.FTAhmTblName AND AO.FTSatFedCode = TXN.FTAhmFedCode AND AO.FTSatStaDocType = TXN.FTSatStaDocType
                WHERE 1=1 AND AO.FTSatTblName = '$tTable' AND AO.FTSatStaDocType = '$tType' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aResult    = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //หาความยาวของสาขา และ เครื่องจุดขาย
    public function FSaMSETGetMaxLength($ptTable)
    {
        $tSQL   = "SELECT 
                       AO.FNSatMaxFedSize
                    FROM [TCNTAuto] AO
                    WHERE 1=1 AND AO.FTSatTblName = '$ptTable' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aResult    = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //เลือกใช้ค่า ดีฟอล จำเป็นต้องลบ , ลบก่อน insert
    public function FSaMSETAutoNumberDelete($paData)
    {
        $this->db->where_in('FTAhmTblName', $paData['FTAhmTblName']);
        $this->db->where_in('FTAhmFedCode', $paData['FTAhmFedCode']);
        $this->db->where_in('FTSatStaDocType', $paData['FTSatStaDocType']);
        $this->db->delete('TCNTAutoHisTxn');
        if ($this->db->affected_rows() > 0) {
            //Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
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

    //เพิ่มข้อมูล
    public function FSaMSETAutoNumberInsert($paData)
    {
        $this->db->insert('TCNTAutoHisTxn', $paData);
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot insert.',
            );
        }

        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }

    // ===============================================  Export  Data ==================================================================

    // Function : Get Data Tsysconfig
    // Create By Sooksanti 05-10-2020
    public function FSaMSETExportDetailTsysconfig()
    {
        // $tRoleCode  = $paData['tRoleCode'];
        // $nLngID     = $this->session->userdata("tLangEdit");

        $tSQL = " SELECT * FROM TSysConfig";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result_array();
            $aResult = array(
                'raItems' => $oList,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'raItems' => array(),
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        unset($oList);
        return $aResult;
    }

    // Function : Get Data TSysConfig_L
    // Create By Sooksanti 05-10-2020
    public function FSaMSETExportDetailTSysConfig_L()
    {
        // $nLngID     = $this->session->userdata("tLangEdit");

        $tSQL = "   SELECT * FROM TSysConfig_L";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result_array();
            $aResult = array(
                'raItems' => $oList,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'raItems' => array(),
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        unset($nLngID);
        unset($tSQL);
        unset($oQuery);
        unset($oList);
        return $aResult;
    }

    // Function : Delete TSysConfigTmp
    // Create By Sooksanti 06-10-2020
    public function FSaMSETDeleteTSysConfigTmp()
    {
        try {
            $tSQL = "DELETE FROM TSysConfigTmp";
            $this->db->query($tSQL);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //function insert ตาราง TSysConfig -> TSysConfigTmp
    //create By Sooksanti(Non) 05-11-2020
    public function FSaMSETInsertToTmpTSysConfig()
    {
        try {
            $tSQL = "INSERT INTO TSysConfigTmp
                                    (FTSysCode,
                                    FTSysApp,
                                    FTSysKey,
                                    FTSysSeq,
                                    FTGmnCode,
                                    FTSysStaAlwEdit,
                                    FTSysStaDataType,
                                    FNSysMaxLength,
                                    FTSysStaDefValue,
                                    FTSysStaDefRef,
                                    FTSysStaUsrValue,
                                    FTSysStaUsrRef,
                                    FDLastUpdOn,
                                    FTLastUpdBy,
                                    FDCreateOn,
                                    FTCreateBy
                                    )
                            SELECT FTSysCode,
                                FTSysApp,
                                FTSysKey,
                                FTSysSeq,
                                FTGmnCode,
                                FTSysStaAlwEdit,
                                FTSysStaDataType,
                                FNSysMaxLength,
                                FTSysStaDefValue,
                                FTSysStaDefRef,
                                FTSysStaUsrValue,
                                FTSysStaUsrRef,
                                FDLastUpdOn,
                                FTLastUpdBy,
                                FDCreateOn,
                                FTCreateBy
                            FROM TSysConfig";

            $this->db->query($tSQL);
        } catch (Exception $Error) {
            echo $Error;
        }
    }


    // Function : Delete TSysConfig
    // Create By Sooksanti 05-10-2020
    public function FSaMSETDeleteTSysConfig()
    {
        try {
            $tSQL = "DELETE FROM TSysConfig";
            $this->db->query($tSQL);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //function insert ตาราง TSysConfig
    //create By Sooksanti(Non) 05-11-2020
    public function FSaMSETInsertTSysConfig($paDataInsTSysConfig)
    {
        try {
            $aInsTSysConfig = array(
                'FTSysCode' => $paDataInsTSysConfig['FTSysCode'],
                'FTSysApp' => $paDataInsTSysConfig['FTSysApp'],
                'FTSysKey' => $paDataInsTSysConfig['FTSysKey'],
                'FTSysSeq' => $paDataInsTSysConfig['FTSysSeq'],
                'FTGmnCode' => $paDataInsTSysConfig['FTGmnCode'],
                'FTSysStaAlwEdit' => $paDataInsTSysConfig['FTSysStaAlwEdit'],
                'FTSysStaDataType' => $paDataInsTSysConfig['FTSysStaDataType'],
                'FNSysMaxLength' => $paDataInsTSysConfig['FNSysMaxLength'],
                'FTSysStaDefValue' => $paDataInsTSysConfig['FTSysStaDefValue'],
                'FTSysStaDefRef' => $paDataInsTSysConfig['FTSysStaDefRef'],
                'FTSysStaUsrValue' => $paDataInsTSysConfig['FTSysStaUsrValue'],
                'FTSysStaUsrRef' => $paDataInsTSysConfig['FTSysStaUsrRef'],
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTLastUpdBy' => '',
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $this->session->userdata('tSesUsername'),
            );
            $this->db->insert('TSysConfig', $aInsTSysConfig);
        } catch (Exception $Error) {
            echo $Error;
        }
    }


    // Function : Delete TSysConfig_LTmp
    // Create By Sooksanti 06-10-2020
    public function FSaMSETDeleteTSysConfig_LTmp()
    {
        try {
            $tSQL = "DELETE FROM TSysConfig_LTmp";
            $this->db->query($tSQL);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //function insert ตาราง TSysConfig_L -> TSysConfig_LTmp
    //create By Sooksanti(Non) 05-11-2020
    public function FSaMSETInsertToTmpTSysConfig_L()
    {
        try {
            $tSQL = "DELETE FROM TSysConfig_LTmp";
            $this->db->query($tSQL);

            $tSQL = "INSERT INTO TSysConfig_LTmp
                                    (FTSysCode,
                                    FTSysApp,
                                    FTSysKey,
                                    FTSysSeq,
                                    FNLngID,
                                    FTSysName,
                                    FTSysDesc,
                                    FTSysRmk
                                    )
                            SELECT  FTSysCode,
                                    FTSysApp,
                                    FTSysKey,
                                    FTSysSeq,
                                    FNLngID,
                                    FTSysName,
                                    FTSysDesc,
                                    FTSysRmk
                            FROM TSysConfig_L;";

            $this->db->query($tSQL);

            $tSQL = "DELETE FROM TSysConfig_L";
            $this->db->query($tSQL);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    // Function : Delete TSysConfig_LTmp
    // Create By Sooksanti 06-10-2020
    public function FSaMSETDeleteTSysConfig_L()
    {
        try {
            $tSQL = "DELETE FROM TSysConfig_L";
            $this->db->query($tSQL);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //function insert ตาราง TSysConfig_L
    //create By Sooksanti(Non) 05-11-2020
    public function FSaMSETInsertTSysConfig_L($paDataInsTSysConfig_L)
    {
        try {
            $aInsTSysConfig_L = array(
                'FTSysCode' => $paDataInsTSysConfig_L['FTSysCode'],
                'FTSysApp' => $paDataInsTSysConfig_L['FTSysApp'],
                'FTSysKey' => $paDataInsTSysConfig_L['FTSysKey'],
                'FTSysSeq' => $paDataInsTSysConfig_L['FTSysSeq'],
                'FNLngID' => $paDataInsTSysConfig_L['FNLngID'],
                'FTSysName' => $paDataInsTSysConfig_L['FTSysName'],
                'FTSysDesc' => $paDataInsTSysConfig_L['FTSysDesc'],
                'FTSysRmk' => $paDataInsTSysConfig_L['FTSysRmk'],
            );
            $this->db->insert('TSysConfig_L', $aInsTSysConfig_L);
        } catch (Exception $Error) {
            echo $Error;
        }
    }
}
