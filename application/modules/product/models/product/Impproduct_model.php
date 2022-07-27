<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Impproduct_model extends CI_Model {

    //ข้อมูลใน Temp
    public function FSaMUSRGetTempData($paDataSearch){
        $tType          = $paDataSearch['tType'];
        $nLngID         = $paDataSearch['nLangEdit'];
        $tTableKey      = $paDataSearch['tTableKey'];
        $tSessionID     = $paDataSearch['tSessionID'];
        $tTextSearch    = $paDataSearch['tTextSearch'];

        switch ($tType) {
            case "TCNMPdtTouchGrp":
                $tSQL   = " SELECT 
                                IMP.FNTmpSeq,
                                IMP.FTTcgCode,
                                IMP.FTTcgName,
                                IMP.FTTmpRemark,
                                IMP.FTTmpStatus
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE 1=1
                                AND IMP.FTSessionID     = '$tSessionID'
                                AND FTTmpTableKey       = '$tTableKey'";
                if($tTextSearch != '' || $tTextSearch != null){
                    $tSQL .= " AND (IMP.FTTcgCode LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTTcgName LIKE '%$tTextSearch%' ";
                    $tSQL .= " )";
                }
            break;
            case "TCNMPdtBrand":
                $tSQL   = " SELECT 
                                IMP.FNTmpSeq,
                                IMP.FTPbnCode,
                                IMP.FTPbnName,
                                IMP.FTTmpRemark,
                                IMP.FTTmpStatus
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE 1=1
                                AND IMP.FTSessionID     = '$tSessionID'
                                AND FTTmpTableKey       = '$tTableKey'";
                if($tTextSearch != '' || $tTextSearch != null){
                    $tSQL .= " AND (IMP.FTPbnCode LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTPbnName LIKE '%$tTextSearch%' ";
                    $tSQL .= " )";
                }
            break;
            case "TCNMPdtUnit":
                $tSQL   = " SELECT 
                                IMP.FNTmpSeq,
                                IMP.FTPunCode,
                                IMP.FTPunName,
                                IMP.FTTmpRemark,
                                IMP.FTTmpStatus
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE 1=1
                                AND IMP.FTSessionID     = '$tSessionID'
                                AND FTTmpTableKey       = '$tTableKey'";
                if($tTextSearch != '' || $tTextSearch != null){
                    $tSQL .= " AND (IMP.FTPunCode LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTPunName LIKE '%$tTextSearch%' ";
                    $tSQL .= " )";
                }
            break;
            case "TCNMPDT":
                $tSQL   = " SELECT 
                                IMP.FNTmpSeq,
                                IMP.FTPdtCode,
                                IMP.FTPdtName,
                                IMP.FTPdtNameABB,
                                IMP.FTPunCode,
                                UNIT.FTPunName,
                                IMP.FCPdtUnitFact,
                                IMP.FTBarCode,
                                IMP.FTPbnCode,
                                BRAND.FTPbnName,
                                IMP.FTTcgCode,
                                TOUCH.FTTcgName,
                                IMP.FTTmpRemark,
                                IMP.FTTmpStatus,
                                UNIT_L.FTPunName AS Master_FTPunName,
                                BRAND_L.FTPbnName AS Master_FTPbnName,
                                TOUCH_L.FTTcgName AS Master_FTTcgName
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            LEFT JOIN TCNTImpMasTmp UNIT        ON UNIT.FTPunCode       = IMP.FTPunCode  AND UNIT.FTTmpTableKey = 'TCNMPdtUnit'         AND UNIT.FTTmpStatus = 1
                            LEFT JOIN TCNTImpMasTmp BRAND       ON BRAND.FTPbnCode      = IMP.FTPbnCode  AND BRAND.FTTmpTableKey = 'TCNMPdtBrand'       AND BRAND.FTTmpStatus = 1
                            LEFT JOIN TCNTImpMasTmp TOUCH       ON TOUCH.FTTcgCode      = IMP.FTTcgCode  AND TOUCH.FTTmpTableKey = 'TCNMPdtTouchGrp'    AND TOUCH.FTTmpStatus = 1
                            LEFT JOIN TCNMPdtUnit_L UNIT_L      ON UNIT_L.FTPunCode     = IMP.FTPunCode  AND UNIT_L.FNLngID = $nLngID                   AND IMP.FTTmpStatus = 1
                            LEFT JOIN TCNMPdtBrand_L BRAND_L    ON BRAND_L.FTPbnCode    = IMP.FTPbnCode  AND BRAND_L.FNLngID = $nLngID                  AND IMP.FTTmpStatus = 1
                            LEFT JOIN TCNMPdtTouchGrp_L TOUCH_L ON TOUCH_L.FTTcgCode    = IMP.FTTcgCode  AND TOUCH_L.FNLngID = $nLngID                  AND IMP.FTTmpStatus = 1
                            WHERE 1=1
                                AND IMP.FTSessionID     = '$tSessionID'
                                AND IMP.FTTmpTableKey       = '$tTableKey'
                                
                                ";
                if($tTextSearch != '' || $tTextSearch != null){
                    $tSQL .= " AND (IMP.FTPdtCode LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTPdtName LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTPdtNameABB LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTPunCode LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR UNIT.FTPunName LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FCPdtUnitFact LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTBarCode LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTPbnCode LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR BRAND.FTPbnName LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR IMP.FTTcgCode LIKE '%$tTextSearch%' ";
                    $tSQL .= " OR TOUCH.FTTcgName LIKE '%$tTextSearch%' ";
                    $tSQL .= " )";
                }
            break;
        }
        
        // echo $tSQL ;

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aStatus = array(
                'tCode'     => '1',
                'tDesc'     => 'success',
                'aResult'   => $oQuery->result_array(),
                'numrow'    => $oQuery->num_rows()
            );
        }else{
            $aStatus = array(
                'tCode'     => '99',
                'tDesc'     => 'Error',
                'aResult'   => array(),
                'numrow'    => 0
            );
        }
        return $aStatus;
    }

    //ลบข้อมูล Temp 
    public function FSaMPDTImportDelete($paParamMaster) {
        try{
            $this->db->where_in('FNTmpSeq', $paParamMaster['FNTmpSeq']);
            $this->db->where_in('FTTmpTableKey', $paParamMaster['tTableKey']);
            $this->db->delete('TCNTImpMasTmp');

            if($this->db->trans_status() === FALSE){
                $aStatus = array(
                    'tCode' => '905',
                    'tDesc' => 'Cannot Delete Item.',
                );
            }else{
                $aStatus = array(
                    'tCode' => '1',
                    'tDesc' => 'Delete Complete.',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //ลบข้อมูลใน Temp หลังจาก move เสร็จแล้ว
    public function FSaMPDTImportMove2MasterDeleteTemp($paDataSearch){
        try{
            $tSessionID     = $paDataSearch['tSessionID'];
            $tTableKey      = $paDataSearch['tTableKey'];
            $aWhere         = array('TCNMPDT','TCNMPdtUnit','TCNMPdtBrand','TCNMPdtTouchGrp');

            // ลบรายการใน Temp
            $this->db->where_in('FTSessionID', $tSessionID);
            $this->db->where_in('FTTmpTableKey' , $aWhere);
            $this->db->delete('TCNTImpMasTmp');
        }catch(Exception $Error) {
            return $Error;
        }

    }

    //move temp to ตารางจริง
    public function FSaMPDTImportMove2Master($paDataSearch){
        try{
            $nLngID             = $paDataSearch['nLangEdit'];
            $tTableKey          = $paDataSearch['tTableKey'];
            $tSessionID         = $paDataSearch['tSessionID'];
            $dDateOn            = $paDataSearch['dDateOn'];
            $tUserBy            = $paDataSearch['tUserBy'];
            $dDateStart         = $paDataSearch['dDateStart'];
            $dDateStop          = $paDataSearch['dDateStop'];

            //*********************** TCNMPdtTouchGrp + TCNMPdtTouchGrp_L ************************//

            //เพิ่มข้อมูลลงตาราง TCNMPdtTouchGrp
            $tSQL   = " INSERT INTO TCNMPdtTouchGrp (FTTcgCode,FTTcgStaUse,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                        SELECT 
                            IMP.FTTcgCode,
                            1 AS FTTcgStaUse,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID       = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtTouchGrp'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //เพิ่มข้อมูลลงตาราง TCNMPdtTouchGrp_L
            $tSQL   = " INSERT INTO TCNMPdtTouchGrp_L (FTTcgCode,FNLngID,FTTcgName,FTTcgRmk)
                        SELECT 
                            IMP.FTTcgCode,
                            $nLngID,
                            IMP.FTTcgName,
                            'IMPORT'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID       = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtTouchGrp'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //*********************** TCNMPdtBrand + TCNMPdtBrand_L ************************//

            //เพิ่มข้อมูลลงตาราง TCNMPdtBrand
            $tSQL   = " INSERT INTO TCNMPdtBrand (FTPbnCode,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                        SELECT 
                            IMP.FTPbnCode,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtBrand'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //เพิ่มข้อมูลลงตาราง TCNMPdtBrand_L
            $tSQL   = " INSERT INTO TCNMPdtBrand_L (FTPbnCode,FNLngID,FTPbnName,FTPbnRmk)
                        SELECT 
                            IMP.FTPbnCode,
                            $nLngID,
                            IMP.FTPbnName,
                            'IMPORT'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtBrand'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //*********************** TCNMPdtUnit + TCNMPdtUnit_L ************************//

            //เพิ่มข้อมูลลงตาราง TCNMPdtUnit
            $tSQL   = " INSERT INTO TCNMPdtUnit (FTPunCode,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                        SELECT 
                            IMP.FTPunCode,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtUnit'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //เพิ่มข้อมูลลงตาราง TCNMPdtUnit_L
            $tSQL   = " INSERT INTO TCNMPdtUnit_L (FTPunCode,FNLngID,FTPunName)
                        SELECT 
                            IMP.FTPunCode,
                            $nLngID,
                            IMP.FTPunName
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPdtUnit'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);
        
            //*********************** TCNMPDT + TCNMPDT_L + TCNMPDTPackSize + TCNMPdtBar ************************//
            //เพิ่มข้อมูลลงตาราง TCNMPDT
            $tSQL   = " INSERT INTO TCNMPDT (
                            FTPDTCode ,FTTcgCode ,FTPbnCode ,FTPdtStaVat ,FTPdtStaActive ,FTPdtStaAlwReturn,
                            FTPdtStaAlwDis ,FTPdtStaVatBuy ,FTPdtStaAlwReCalOpt ,FTPdtStaCsm ,FTPdtPoint ,FTPdtForSystem,
                            FTPdtStkControl ,FTPdtType , FTPdtSaleType ,FTPdtSetOrSN ,FTPdtStaSetPri ,FDPdtSaleStart,
                            FDPdtSaleStop ,FCPdtMin , FCPdtMax ,FTVatCode, FDLastUpdOn , FTLastUpdBy, FDCreateOn, FTCreateBy
                        )
                        SELECT 
                            IMP.FTPDTCode,
                            IMP.FTTcgCode,
                            IMP.FTPbnCode,
                            1 AS FTPdtStaVat,
                            1 AS FTPdtStaActive,
                            1 AS FTPdtStaAlwReturn,
                            1 AS FTPdtStaAlwDis,
                            1 AS FTPdtStaVatBuy,
                            1 AS FTPdtStaAlwReCalOpt,
                            1 AS FTPdtStaCsm,
                            1 AS FTPdtPoint,
                            1 AS FTPdtForSystem,
                            1 AS FTPdtStkControl,
                            1 AS FTPdtType,
                            1 AS FTPdtSaleType,
                            1 AS FTPdtSetOrSN,
                            2 AS FTPdtStaSetPri,
                            '$dDateStart' AS FDPdtSaleStart,
                            '$dDateStop' AS FDPdtSaleStop,
                            1 AS FCPdtMin,
                            1 AS FCPdtMax,
                            (SELECT TOP 1 FTVatCode FROM TCNMComp) AS FTVatCode,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPDT'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //เพิ่มข้อมูลลงตาราง TCNMPDT_L
            $tSQL   = " INSERT INTO TCNMPDT_L (FTPdtCode,FNLngID,FTPdtName,FTPdtNameABB,FTPdtRmk)
                        SELECT 
                            IMP.FTPdtCode,
                            $nLngID,
                            IMP.FTPdtName,
                            IMP.FTPdtNameABB,
                            'IMPORT'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPDT'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //เพิ่มข้อมูลลงตาราง TCNMPDTPackSize
            $tSQL   = " INSERT INTO TCNMPDTPackSize (FTPdtCode,FTPunCode,FCPdtUnitFact,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                        SELECT 
                            IMP.FTPdtCode,
                            IMP.FTPunCode,
                            IMP.FCPdtUnitFact,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPDT'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            //เพิ่มข้อมูลลงตาราง TCNMPdtBar
            $tSQL   = " INSERT INTO TCNMPdtBar (FTPdtCode,FTBarCode,FTPunCode,FTBarStaUse,FTBarStaAlwSale,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                        SELECT 
                            IMP.FTPdtCode,
                            IMP.FTBarCode,
                            IMP.FTPunCode,
                            1 AS FTBarStaUse,
                            1 AS FTBarStaAlwSale,
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID     = '$tSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMPDT'
                        AND IMP.FTTmpStatus       = '1' ";
            $this->db->query($tSQL);

            if($this->db->trans_status() === FALSE){
                $aStatus = array(
                    'tCode'     => '99',
                    'tDesc'     => 'Error'
                );
            }else{
                $aStatus = array(
                    'tCode'     => '1',
                    'tDesc'     => 'success'
                );
            }
            return $aStatus;
        }catch(Exception $Error) {
            return $Error;
        }
    }

    //อัพเดทรายการเดิม + ใช้รายการใหม่
    public function FSaMPDTImportMove2MasterAndReplaceOrInsert($paDataSearch){
        try{
            $tTypeCaseDuplicate = $paDataSearch['tTypeCaseDuplicate'];
            $nLngID             = $paDataSearch['nLangEdit'];
            $tSessionID         = $paDataSearch['tSessionID'];
            $dDateOn            = $paDataSearch['dDateOn'];
            $tUserBy            = $paDataSearch['tUserBy'];
            $dDateStart         = $paDataSearch['dDateStart'];
            $dDateStop          = $paDataSearch['dDateStop'];
            
            if($tTypeCaseDuplicate == 2){
                //อัพเดทรายการเดิม

                //อัพเดทตาราง TCNMPdtTouchGrp_L
                $tSQL   = " UPDATE
                                TCNMPdtTouchGrp_L
                            SET
                                TCNMPdtTouchGrp_L.FTTcgName  = TCNTImpMasTmp.FTTcgName
                            FROM
                                TCNMPdtTouchGrp_L
                            INNER JOIN
                                TCNTImpMasTmp
                            ON
                                TCNMPdtTouchGrp_L.FTTcgCode = TCNTImpMasTmp.FTTcgCode
                            WHERE
                                TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                            AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPdtTouchGrp'
                            AND TCNTImpMasTmp.FTTmpStatus = '6' 
                ";
                $this->db->query($tSQL);

                //อัพเดทรายการ TCNMPdtBrand_L
                $tSQL   = " UPDATE
                                TCNMPdtBrand_L
                            SET
                                TCNMPdtBrand_L.FTPbnName  = TCNTImpMasTmp.FTPbnName
                            FROM
                                TCNMPdtBrand_L
                            INNER JOIN
                                TCNTImpMasTmp
                            ON
                                TCNMPdtBrand_L.FTPbnCode = TCNTImpMasTmp.FTPbnCode
                            WHERE
                                TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                            AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPdtBrand'
                            AND TCNTImpMasTmp.FTTmpStatus = '6' 
                ";
                $this->db->query($tSQL);

                //อัพเดทรายการ TCNMPdtUnit_L
                $tSQL   = " UPDATE
                                TCNMPdtUnit_L
                            SET
                                TCNMPdtUnit_L.FTPunName  = TCNTImpMasTmp.FTPunName
                            FROM
                                TCNMPdtUnit_L
                            INNER JOIN
                                TCNTImpMasTmp
                            ON
                                TCNMPdtUnit_L.FTPunCode = TCNTImpMasTmp.FTPunCode
                            WHERE
                                TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                            AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPdtUnit'
                            AND TCNTImpMasTmp.FTTmpStatus = '6' 
                ";
                $this->db->query($tSQL);

                //อัพเดทรายการ TCNMPDT_L
                $tSQL   = " UPDATE
                                TCNMPDT_L
                            SET
                                TCNMPDT_L.FTPdtName     = TCNTImpMasTmp.FTPdtName,
                                TCNMPDT_L.FTPdtNameABB  = TCNTImpMasTmp.FTPdtNameABB
                            FROM
                                TCNMPDT_L
                            INNER JOIN
                                TCNTImpMasTmp
                            ON
                                TCNMPDT_L.FTPdtCode = TCNTImpMasTmp.FTPdtCode
                            WHERE
                                TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                            AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPDT'
                            AND TCNTImpMasTmp.FTTmpStatus = '6' 
                ";
                $this->db->query($tSQL);

                //อัพเดทรายการ TCNMPdtBar
                $tSQL   = " UPDATE
                                TCNMPdtBar
                            SET
                                TCNMPdtBar.FTBarCode     = TCNTImpMasTmp.FTBarCode,
                                TCNMPdtBar.FTPunCode     = TCNTImpMasTmp.FTPunCode
                            FROM
                                TCNMPdtBar
                            INNER JOIN
                                TCNTImpMasTmp
                            ON
                                TCNMPdtBar.FTPdtCode = TCNTImpMasTmp.FTPdtCode AND
                                TCNMPdtBar.FTPunCode = TCNTImpMasTmp.FTPunCode
                            WHERE
                                TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                            AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPDT'
                            AND TCNTImpMasTmp.FTTmpStatus = '6' 
                ";
                $this->db->query($tSQL);

                //อัพเดทรายการ TCNMPDTPackSize
                $tSQL   = " UPDATE
                                TCNMPDTPackSize
                            SET
                                TCNMPDTPackSize.FTPunCode     = TCNTImpMasTmp.FTPunCode,
                                TCNMPDTPackSize.FCPdtUnitFact = TCNTImpMasTmp.FCPdtUnitFact 
                            FROM
                                TCNMPDTPackSize
                            INNER JOIN
                                TCNTImpMasTmp
                            ON
                                TCNMPDTPackSize.FTPdtCode = TCNTImpMasTmp.FTPdtCode
                            WHERE
                                TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                            AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPDT'
                            AND TCNTImpMasTmp.FTTmpStatus = '6' 
                ";
                $this->db->query($tSQL);

                //อัพเดทรายการ TCNMPDT
                $tSQL   = " UPDATE
                                TCNMPDT
                            SET
                                TCNMPDT.FTTcgCode       = TCNTImpMasTmp.FTTcgCode,
                                TCNMPDT.FTPbnCode       = TCNTImpMasTmp.FTPbnCode
                            FROM
                                TCNMPDT
                            INNER JOIN
                                TCNTImpMasTmp
                            ON
                                TCNMPDT.FTPdtCode = TCNTImpMasTmp.FTPdtCode
                            WHERE
                                TCNTImpMasTmp.FTSessionID = '$tSessionID' 
                            AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMPDT'
                            AND TCNTImpMasTmp.FTTmpStatus = '6' 
                ";
                $this->db->query($tSQL);
            }else if($tTypeCaseDuplicate == 1){
                //ใช้รายการใหม่

                //-------------------------ลบข้อมูลก่อน 

                //ลบข้อมูลในตาราง TCNMPdtTouchGrp_L
                $tSQLDelete = "DELETE FROM TCNMPdtTouchGrp_L WHERE FTTcgCode IN (
                                    SELECT FTTcgCode
                                    FROM TCNTImpMasTmp
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPdtTouchGrp'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPdtTouchGrp
                $tSQLDelete = "DELETE FROM TCNMPdtTouchGrp WHERE FTTcgCode IN (
                                    SELECT FTTcgCode
                                    FROM TCNTImpMasTmp
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPdtTouchGrp'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPdtUnit_L
                $tSQLDelete = "DELETE FROM TCNMPdtUnit_L WHERE FTPunCode IN (
                                    SELECT FTPunCode
                                    FROM TCNTImpMasTmp
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPdtUnit'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPdtUnit
                $tSQLDelete = "DELETE FROM TCNMPdtUnit WHERE FTPunCode IN (
                                    SELECT FTPunCode
                                    FROM TCNTImpMasTmp
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPdtUnit'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPdtBrand_L
                $tSQLDelete = "DELETE FROM TCNMPdtBrand_L WHERE FTPbnCode IN (
                                    SELECT FTPbnCode
                                    FROM TCNTImpMasTmp
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPdtBrand'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPdtBrand
                $tSQLDelete = "DELETE FROM TCNMPdtBrand WHERE FTPbnCode IN (
                                    SELECT FTPbnCode
                                    FROM TCNTImpMasTmp
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPdtBrand'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPDT_L
                $tSQLDelete = "DELETE FROM TCNMPDT_L WHERE FTPdtCode IN (
                                    SELECT FTPdtCode
                                    FROM TCNTImpMasTmp
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPDT'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPDT
                $tSQLDelete = "DELETE FROM TCNMPDT WHERE FTPdtCode IN (
                                    SELECT FTPdtCode
                                    FROM TCNTImpMasTmp
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPDT'
                                )";
                $this->db->query($tSQLDelete);

                 //ลบข้อมูลในตาราง TCNMPDTPackSize
                 $tSQLDelete = "DELETE FROM TCNMPDTPackSize WHERE FTPunCode IN (
                                    SELECT FTPunCode
                                    FROM TCNTImpMasTmp
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPDT'
                                )";
                $this->db->query($tSQLDelete);

                //ลบข้อมูลในตาราง TCNMPdtBar
                $tSQLDelete = "DELETE FROM TCNMPdtBar WHERE FTPdtCode IN (
                                    SELECT FTPdtCode
                                    FROM TCNTImpMasTmp
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMPDT'
                                )";
                $this->db->query($tSQLDelete);
                    
                //*********************** TCNMPdtTouchGrp + TCNMPdtTouchGrp_L ************************//

                //เพิ่มข้อมูลลงตาราง TCNMPdtTouchGrp
                $tSQL   = " INSERT INTO TCNMPdtTouchGrp (FTTcgCode,FTTcgStaUse,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                            SELECT 
                                IMP.FTTcgCode,
                                1 AS FTTcgStaUse,
                                '$dDateOn',
                                '$tUserBy',
                                '$dDateOn',
                                '$tUserBy'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID       = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPdtTouchGrp'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);

                //เพิ่มข้อมูลลงตาราง TCNMPdtTouchGrp_L
                $tSQL   = " INSERT INTO TCNMPdtTouchGrp_L (FTTcgCode,FNLngID,FTTcgName,FTTcgRmk)
                            SELECT 
                                IMP.FTTcgCode,
                                $nLngID,
                                IMP.FTTcgName,
                                'IMPORT'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID       = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPdtTouchGrp'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);

                //*********************** TCNMPdtBrand + TCNMPdtBrand_L ************************//

                //เพิ่มข้อมูลลงตาราง TCNMPdtBrand
                $tSQL   = " INSERT INTO TCNMPdtBrand (FTPbnCode,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                            SELECT 
                                IMP.FTPbnCode,
                                '$dDateOn',
                                '$tUserBy',
                                '$dDateOn',
                                '$tUserBy'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPdtBrand'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);

                //เพิ่มข้อมูลลงตาราง TCNMPdtBrand_L
                $tSQL   = " INSERT INTO TCNMPdtBrand_L (FTPbnCode,FNLngID,FTPbnName,FTPbnRmk)
                            SELECT 
                                IMP.FTPbnCode,
                                $nLngID,
                                IMP.FTPbnName,
                                'IMPORT'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPdtBrand'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);

                //*********************** TCNMPdtUnit + TCNMPdtUnit_L ************************//

                //เพิ่มข้อมูลลงตาราง TCNMPdtUnit
                $tSQL   = " INSERT INTO TCNMPdtUnit (FTPunCode,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                            SELECT 
                                IMP.FTPunCode,
                                '$dDateOn',
                                '$tUserBy',
                                '$dDateOn',
                                '$tUserBy'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPdtUnit'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);

                //เพิ่มข้อมูลลงตาราง TCNMPdtUnit_L
                $tSQL   = " INSERT INTO TCNMPdtUnit_L (FTPunCode,FNLngID,FTPunName)
                            SELECT 
                                IMP.FTPunCode,
                                $nLngID,
                                IMP.FTPunName
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPdtUnit'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);

                //*********************** TCNMPDT + TCNMPDT_L + TCNMPDTPackSize + TCNMPdtBar ************************//
                //เพิ่มข้อมูลลงตาราง TCNMPDT
                $tSQL   = " INSERT INTO TCNMPDT (
                                FTPDTCode ,FTTcgCode ,FTPbnCode ,FTPdtStaVat ,FTPdtStaActive ,FTPdtStaAlwReturn,
                                FTPdtStaAlwDis ,FTPdtStaVatBuy ,FTPdtStaAlwReCalOpt ,FTPdtStaCsm ,FTPdtPoint ,FTPdtForSystem,
                                FTPdtStkControl ,FTPdtType , FTPdtSaleType ,FTPdtSetOrSN ,FTPdtStaSetPri ,FDPdtSaleStart,
                                FDPdtSaleStop ,FCPdtMin , FCPdtMax ,FTVatCode, FDLastUpdOn , FTLastUpdBy, FDCreateOn, FTCreateBy
                            )
                            SELECT 
                                IMP.FTPDTCode,
                                IMP.FTTcgCode,
                                IMP.FTPbnCode,
                                1 AS FTPdtStaVat,
                                1 AS FTPdtStaActive,
                                1 AS FTPdtStaAlwReturn,
                                1 AS FTPdtStaAlwDis,
                                1 AS FTPdtStaVatBuy,
                                1 AS FTPdtStaAlwReCalOpt,
                                1 AS FTPdtStaCsm,
                                1 AS FTPdtPoint,
                                1 AS FTPdtForSystem,
                                1 AS FTPdtStkControl,
                                1 AS FTPdtType,
                                1 AS FTPdtSaleType,
                                1 AS FTPdtSetOrSN,
                                2 AS FTPdtStaSetPri,
                                '$dDateStart' AS FDPdtSaleStart,
                                '$dDateStop' AS FDPdtSaleStop,
                                1 AS FCPdtMin,
                                1 AS FCPdtMax,
                                (SELECT TOP 1 FTVatCode FROM TCNMComp) AS FTVatCode,
                                '$dDateOn',
                                '$tUserBy',
                                '$dDateOn',
                                '$tUserBy'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPDT'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);

                //เพิ่มข้อมูลลงตาราง TCNMPDT_L
                $tSQL   = " INSERT INTO TCNMPDT_L (FTPdtCode,FNLngID,FTPdtName,FTPdtNameABB,FTPdtRmk)
                            SELECT 
                                IMP.FTPdtCode,
                                $nLngID,
                                IMP.FTPdtName,
                                IMP.FTPdtNameABB,
                                'IMPORT'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPDT'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);

                //เพิ่มข้อมูลลงตาราง TCNMPDTPackSize
                $tSQL   = " INSERT INTO TCNMPDTPackSize (FTPdtCode,FTPunCode,FCPdtUnitFact,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                            SELECT 
                                IMP.FTPdtCode,
                                IMP.FTPunCode,
                                IMP.FCPdtUnitFact,
                                '$dDateOn',
                                '$tUserBy',
                                '$dDateOn',
                                '$tUserBy'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPDT'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);

                //เพิ่มข้อมูลลงตาราง TCNMPdtBar
                $tSQL   = " INSERT INTO TCNMPdtBar (FTPdtCode,FTBarCode,FTPunCode,FTBarStaUse,FTBarStaAlwSale,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
                            SELECT 
                                IMP.FTPdtCode,
                                IMP.FTBarCode,
                                IMP.FTPunCode,
                                1 AS FTBarStaUse,
                                1 AS FTBarStaAlwSale,
                                '$dDateOn',
                                '$tUserBy',
                                '$dDateOn',
                                '$tUserBy'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = 'TCNMPDT'
                            AND IMP.FTTmpStatus       = '6' ";
                $this->db->query($tSQL);
            }
        }catch(Exception $Error) {
            return $Error;
        }
    }

    //หาจำนวน record ทั้งหมด
    public function FSaMPDTGetTempDataAtAll($ptTableName){
        try{
            $tSesSessionID = $this->session->userdata("tSesSessionID");
            $tSQL   = "SELECT TOP 1
                        (SELECT COUNT(FTTmpTableKey) AS TYPESIX FROM TCNTImpMasTmp IMP  
                        WHERE IMP.FTSessionID     = '$tSesSessionID'
                        AND IMP.FTTmpTableKey     = '$ptTableName'
                        AND IMP.FTTmpStatus       = '6') AS TYPESIX ,

                        (SELECT COUNT(FTTmpTableKey) AS TYPEONE FROM TCNTImpMasTmp IMP  
                        WHERE IMP.FTSessionID     = '$tSesSessionID'
                        AND IMP.FTTmpTableKey     = '$ptTableName'
                        AND IMP.FTTmpStatus       = '1') AS TYPEONE ,

                        (SELECT COUNT(FTTmpTableKey) AS TYPEONE FROM TCNTImpMasTmp IMP  
                        WHERE IMP.FTSessionID     = '$tSesSessionID'
                        AND IMP.FTTmpTableKey     = '$ptTableName'
                        ) AS ITEMALL
                    FROM TCNTImpMasTmp ";
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array();
        }catch(Exception $Error) {
            return $Error;
        }
    }
}