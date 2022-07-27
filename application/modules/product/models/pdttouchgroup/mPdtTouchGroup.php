<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPdtTouchGroup extends CI_Model {

    // Functionality: Get Data Table List
    // Parameters: function parameters
    // Creator:  06/01/2020 wasin(Yoshi)
    // Return: Data Array
    // Return Type: Array
    public function FSaMTCGDataTableList($paDataCondition){
        $aRowLen        = FCNaHCallLenData($paDataCondition['nRow'],$paDataCondition['nPage']);
        $nLngID         = $paDataCondition['nLngID'];
        $tSearchAll     = $paDataCondition['tSearchAll'];
        // ค้นหา
        $tTextSqlSearch = "";
        if(isset($tSearchAll) && !empty($tSearchAll)){
            $tTextSqlSearch = " AND ((TCG.FTTcgCode LIKE '%$tSearchAll%') OR (TCGL.FTTcgName LIKE '%$tSearchAll%'))";
        }

        $tSQL           = " SELECT c.* FROM (
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC ,FTTcgCode DESC) AS FNRowID,* FROM (
                                    SELECT DISTINCT
                                        TCG.FTTcgCode,
                                        TCG.FTTcgStaUse,
                                        TCGL.FTTcgName,
                                        IMG.FTImgObj,
                                        TCG.FDCreateOn
                                    FROM TCNMPdtTouchGrp TCG WITH(NOLOCK)
                                    LEFT JOIN TCNMPdtTouchGrp_L TCGL WITH(NOLOCK) ON TCG.FTTcgCode = TCGL.FTTcgCode AND TCGL.FNLngID = $nLngID
                                    LEFT JOIN TCNMImgObj IMG ON IMG.FTImgRefID = TCG.FTTcgCode AND IMG.FTImgTable = 'TCNMPdtTouchGrp'
                                    WHERE 1=1
                                    $tTextSqlSearch
                                ) Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->result_array();
            $aDataCountAllRow   = $this->FSnMTCGCountPageDataTableAll($paDataCondition);
            $nFoundRow          = ($aDataCountAllRow['rtCode'] == '1')? $aDataCountAllRow['rtCountData'] : 0;
            $nPageAll           = ceil($nFoundRow/$paDataCondition['nRow']);
            $aResult = array(
                'raItems'       => $oDataList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataCondition['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataCondition['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($aRowLen);
        unset($nLngID);
        unset($tSearchAll);
        unset($tTextSqlSearch);
        unset($tSQL);
        unset($oQuery);
        unset($oDataList);
        unset($aDataCountAllRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aResult;
    }

    // Functionality: Get Data Page All
    // Parameters: function parameters
    // Creator:  06/01/2020 wasin(Yoshi)
    // Return: Data Array
    // Return Type: Array
    private function FSnMTCGCountPageDataTableAll($paDataCondition){
        $aRowLen        = FCNaHCallLenData($paDataCondition['nRow'],$paDataCondition['nPage']);
        $nLngID         = $paDataCondition['nLngID'];
        $tSearchAll     = $paDataCondition['tSearchAll'];
        // ค้นหา
        $tTextSqlSearch = "";
        if(isset($tSearchAll) && !empty($tSearchAll)){
            $tTextSqlSearch = " AND ((TCG.FTTcgCode LIKE '%$tSearchAll%') OR (TCGL.FTTcgName LIKE '%$tSearchAll%'))";
        }
        $tSQL   = " SELECT COUNT(TCG.FTTcgCode) AS counts
                    FROM TCNMPdtTouchGrp TCG WITH(NOLOCK)
                    LEFT JOIN TCNMPdtTouchGrp_L TCGL WITH(NOLOCK) ON TCG.FTTcgCode = TCGL.FTTcgCode AND TCGL.FNLngID = $nLngID
                    WHERE 1=1
                    $tTextSqlSearch
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0) {
            $aDetail        = $oQuery->row_array();
            $aDataReturn    =  array(
                'rtCountData'   => $aDetail['counts'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    =  array(
                'rtCode'        => '800',
                'rtDesc'        => 'Data Not Found',
            );
        }
        unset($aRowLen);
        unset($nLngID);
        unset($tSearchAll);
        unset($tTextSqlSearch);
        unset($tSQL);
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }

    // Functionality: Get Data By ID
    // Parameters: function parameters
    // Creator:  07/01/2020 wasin(Yoshi)
    // Return: Data Array
    // Return Type: Array
    public function FSaMTCGGetDataByID($paDataWhere){
        $nLngID     = $paDataWhere['nLngID'];
        $tTcgCode   = $paDataWhere['tTcgCode'];
        $tSQL       = " SELECT 
                            TCG.FTTcgCode,
                            TCG.FTTcgStaUse,
                            TCGL.FTTcgName,
                            TCGL.FTTcgRmk,
                            IMG.FTImgObj
                        FROM TCNMPdtTouchGrp TCG WITH(NOLOCK)
                        LEFT JOIN TCNMPdtTouchGrp_L TCGL WITH(NOLOCK) ON TCG.FTTcgCode = TCGL.FTTcgCode AND TCGL.FNLngID = $nLngID
                        LEFT JOIN TCNMImgObj IMG WITH(NOLOCK) ON TCG.FTTcgCode = IMG.FTImgRefID AND IMG.FNImgSeq = 1 AND IMG.FTImgTable = 'TCNMPdtTouchGrp' AND IMG.FTImgKey = 'master'
                        WHERE 1=1
                        AND TCG.FTTcgCode = '$tTcgCode'
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0) {
            $aDataResult    = $oQuery->row_array();
            $aDataReturn = [
                'raItems'   => $aDataResult,
                'rtCode'    => '1',
                'rtName'    => 'Found Data.'
            ];
        }else{
            $aDataReturn = [
                'rtCode' => '800',
                'rtName' => 'Data Not Found.',
            ];
        }
        unset($nLngID);
        unset($tTcgCode);
        unset($tSQL);
        unset($oQuery);
        unset($aDataResult);
        return $aDataReturn;
    }

    // Functionality: Event Insert Data Master
    // Parameters: function parameters
    // Creator:  07/01/2020 wasin(Yoshi)
    // Return: Data Array
    // Return Type: Array
    public function FSaMTCGAddDataMaster($paDataMaster){
        // Add Master
        $tInsertMaster  = " INSERT INTO TCNMPdtTouchGrp (FTTcgCode,FTTcgStaUse,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                            VALUES (
                                '".$paDataMaster['FTTcgCode']."',
                                '".$paDataMaster['FTTcgStaUse']."',
                                GETDATE(),
                                '".$paDataMaster['FTLastUpdBy']."',
                                GETDATE(),
                                '".$paDataMaster['FTLastUpdBy']."'
                            )
        ";
        $oQueryMaster = $this->db->query($tInsertMaster);

        // Add Lang
        $tSQLInsertLang = " INSERT INTO TCNMPdtTouchGrp_L (FTTcgCode,FNLngID,FTTcgName,FTTcgRmk)
                            VALUES (
                                '".$paDataMaster['FTTcgCode']."',
                                '".$paDataMaster['FNLngID']."',
                                '".$paDataMaster['FTTcgName']."',
                                '".$paDataMaster['FTTcgRmk']."'
                            )
        ";
        $oQueryLang = $this->db->query($tSQLInsertLang);
        return;
    }

    // Functionality: Event Update Data Master
    // Parameters: function parameters
    // Creator:  07/01/2020 wasin(Yoshi)
    // Return: Data Array
    // Return Type: Array
    public function FSaMTCGUpdateDataMaster($paDataMaster){
        // Updaete Master
        $tUpdateMaster  = " UPDATE TCNMPdtTouchGrp WITH(ROWLOCK)
                            SET
                                FTTcgStaUse = '".$paDataMaster['FTTcgStaUse']."',
                                FDLastUpdOn = GETDATE(),
                                FTLastUpdBy = '".$paDataMaster['FTLastUpdBy']."'
                            WHERE 1=1
                            AND FTTcgCode = '".$paDataMaster['FTTcgCode']."'
        ";
        $oQueryMaster = $this->db->query($tUpdateMaster);

        // Update Lang
        $tUpdateLang    = " UPDATE TCNMPdtTouchGrp_L WITH(ROWLOCK)
                            SET
                                FTTcgName   = '".$paDataMaster['FTTcgName']."',
                                FTTcgRmk    = '".$paDataMaster['FTTcgRmk']."'
                            WHERE 1=1 
                            AND FTTcgCode   = '".$paDataMaster['FTTcgCode']."'
                            AND FNLngID     = '".$paDataMaster['FNLngID']."'
        ";
        $oQueryLang = $this->db->query($tUpdateLang);
        return;
    }

    // Functionality: Event Delete 
    // Parameters: function parameters
    // Creator:  07/01/2020 wasin(Yoshi)
    // Return: Data Array
    // Return Type: Array
    public function FSnMTCGEventDelete($paDataWhere){
        // Delete Table Master
        $this->db->where_in('FTTcgCode',$paDataWhere['FTTcgCode']);
        $this->db->delete('TCNMPdtTouchGrp');
        // Delete Table Lang
        $this->db->where_in('FTTcgCode',$paDataWhere['FTTcgCode']);
        $this->db->delete('TCNMPdtTouchGrp_L');
        if($this->db->affected_rows() > 0){
            $aStatus    = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Cannot Delete.',
            );
        }
        return $aStatus;
    }

}