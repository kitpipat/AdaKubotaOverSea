<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Vendinglayout_model extends CI_Model {

    //เข้าไปหาข้อมูลก่อนว่าเคยถูกเพิ่มไหม
    function FSaMVEDFindDataHD($paData){
        $tShpCode = $paData['tShpCode'];
        $tBchCode = $paData['tBchCode'];

        //TVDMShopSize ตารางนี้ คือไว้เซตความสูง ความกว้าง ของตู้สินค้า
        $tSQL = "SELECT VSL.FTBchCode AS FTBchCode FROM [TVDMShopSize] VSL WHERE 1=1 AND FTBchCode ='$tBchCode' AND FTShpCode = '$tShpCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }

        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //เพิ่มข้อมูลพวกจำนวนชั้น จำนวนช่อง
    function FSaMVEDInsertSettingLayout($paData){
        try{
            $dDateCreateOn  = date("Y-m-d H:i:s");
            $tSesUsername   = $this->session->userdata("tSesUsername");
            $FNLngID        = $this->session->userdata("tLangEdit");
            $FTShpCode      = $paData['tShpCode'];
            $FTBchCode      = $paData['tBchCode'];
            $FCLayRowQty    = $paData['nVBFloor'];
            $FCLayColQty    = $paData['nVBColumn'];
            $FTLayName      = $paData['tVBName'];
            $FTLayRemark    = $paData['tVBReason'];
            $tTypePage      = $paData['tTypePage'];

            if($tTypePage == "INSERT"){
                $this->db->insert('TVDMShopSize',array(
                    'FTBchCode'      => $FTBchCode,
                    'FTShpCode'      => $FTShpCode,
                    'FCLayRowQty'    => $FCLayRowQty,
                    'FCLayColQty'    => $FCLayColQty,
                    'FTLayStaUse'    => 1,
                    'FDCreateOn'     => $dDateCreateOn,
                    'FTCreateBy'     => $tSesUsername,
                    'FDLastUpdOn'    => $dDateCreateOn,
                    'FTLastUpdBy'    => $tSesUsername
                ));
    
                $this->db->insert('TVDMShopSize_L',array(
                    'FTBchCode'     => $FTBchCode,
                    'FTShpCode'     => $FTShpCode,
                    'FNLngID'       => $FNLngID,
                    'FTLayName'     => $FTLayName,
                    'FTLayRemark'   => $FTLayRemark
                ));
            }else if($tTypePage == "EDIT"){
                $this->db->where('FTBchCode', $FTBchCode);
                $this->db->where('FTShpCode', $FTShpCode);
                $this->db->update('TVDMShopSize',array(
                    'FCLayRowQty'    => $FCLayRowQty,
                    'FCLayColQty'    => $FCLayColQty,
                    'FTLayStaUse'    => 1,
                    'FDCreateOn'     => $dDateCreateOn,
                    'FTCreateBy'     => $tSesUsername,
                    'FDLastUpdOn'    => $dDateCreateOn,
                    'FTLastUpdBy'    => $tSesUsername
                ));

                $this->db->where('FTBchCode', $FTBchCode);
                $this->db->where('FTShpCode', $FTShpCode);
                $this->db->update('TVDMShopSize_L',array(
                    'FNLngID'       => $FNLngID,
                    'FTLayName'     => $FTLayName,
                    'FTLayRemark'   => $FTLayRemark
                ));
            }else if($tTypePage == "CONFIRM"){
                //ถ้าไม่สนใจ ยืนยันจะลดขนาดความสูงและลดชั้น จะต้องลบเเละทำรายการใหม่
                $tDisType      = $paData['tDisType'];
                if($tDisType == 'FLOOR'){
                    $this->db->where('FTShpCode', $FTShpCode);
                    $this->db->where('FNLayRow > ', $FCLayRowQty);
                    $this->db->delete('TVDMPdtLayout');
                }else{
                    $this->db->where('FTShpCode', $FTShpCode);
                    $this->db->delete('TVDMPdtLayout');
                }

                $this->db->where('FTBchCode', $FTBchCode);
                $this->db->where('FTShpCode', $FTShpCode);
                $this->db->update('TVDMShopSize',array(
                    'FCLayRowQty'    => $FCLayRowQty,
                    'FCLayColQty'    => $FCLayColQty,
                    'FTLayStaUse'    => 1,
                    'FDCreateOn'     => $dDateCreateOn,
                    'FTCreateBy'     => $tSesUsername,
                    'FDLastUpdOn'    => $dDateCreateOn,
                    'FTLastUpdBy'    => $tSesUsername
                ));

                $this->db->where('FTBchCode', $FTBchCode);
                $this->db->where('FTShpCode', $FTShpCode);
                $this->db->update('TVDMShopSize_L',array(
                    'FNLngID'       => $FNLngID,
                    'FTLayName'     => $FTLayName,
                    'FTLayRemark'   => $FTLayRemark
                ));
            }
            
            if($this->db->affected_rows() > 0 ){
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
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //ลบความสูงจากตาราง Tmp
    function FSaMVEDDeleteHeightToTmp($paData){
        $FTShpCode      = $paData['tShpCode'];
        $FTBchCode      = $paData['tBchCode'];
        $tCabinetSeq    = $paData['tCabinetSeq'];
        $this->db->where('FTMttTableKey', 'TVDMShopCabinet');
        $this->db->where('FTBchCode', $FTBchCode); 
        $this->db->where('FTShpCode', $FTShpCode); 
        $this->db->where('FTGhdApp', $tCabinetSeq);
        $this->db->delete('TsysMasTmp');
    }

    //เพิ่มความสูงลงตาราง Tmp
    function FSaMVEDInsertHeightToTmp($nKey,$nHeight,$paData){
        $FTShpCode      = $paData['tShpCode'];
        $FTBchCode      = $paData['tBchCode'];
        $tCabinetSeq    = $paData['tCabinetSeq'];

        $this->db->insert('TsysMasTmp', array(
            'FTMttTableKey' => 'TVDMShopCabinet',
            'FTBchCode'     => $FTBchCode,
            'FTGhdApp'      => $tCabinetSeq ,
            'FTShpCode'     => $FTShpCode,
            'FTRefPdtCode'  => $nKey,
            'FTPdtCode'     => $nHeight,
            'FDCreateOn'    => date('Y-m-d')
        ));


        $this->db->where('FNCabSeq', $tCabinetSeq);
        $this->db->where('FTShpCode', $FTShpCode);
        $this->db->where('FNLayRow', $nKey);
        $this->db->update('TVDMPdtLayout',array(
            'FCLayHigh'    => $nHeight
        ));
    }

    //เอาความสูงจากตาราง Tmp
    function FSaMVEDGetDataHeightTemp($paData){
        $tShpCode       = $paData['tShpCode'];
        $tBchCode       = $paData['tBchCode'];
        $nSeqCabinet    = $paData['nSeqCabinet'];
        $tSQL = "SELECT 
                    FTPdtCode , FTRefPdtCode FROM TsysMasTmp 
                WHERE FTMttTableKey = 'TVDMShopCabinet' AND FTBchCode = '$tBchCode' AND FTShpCode = '$tShpCode' AND FTGhdApp = '$nSeqCabinet'  ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result_array();
        }else{
            $oDetail = array();
        }
        return $oDetail;
    }

    //เอาข้อมูลไปแสดง HD ใช้ชั้นเท่าไหร่ ใช้ช่องเท่าไหร่
    function FSaMVEDGetDataHD($paData){
        $tShpCode       = $paData['tShpCode'];
        $tBchCode       = $paData['tBchCode'];
        $nLngID         = $this->session->userdata("tLangEdit");
        $tSQL = "SELECT
                    Vsl.FTBchCode       AS rtVslBch,
                    BchL.FTBchName      AS rtBchName,
                    Vsl.FTShpCode       AS rtVslShp,
                    Vsl.FCLayRowQty     AS rtVslRowQty,
                    Vsl.FCLayColQty     AS rtVslColQty,
                    Vsl.FTLayStaUse     AS rtVslStaUse,
                    Vsl_L.FTLayName     AS rtVslName,
                    Vsl_L.FTLayRemark   AS rtVslRemark,
                    Shp_L.FTShpName     AS rtShpName
                FROM [TVDMShopSize] Vsl
                LEFT JOIN [TCNMBranch_L] BchL       ON Vsl.FTBchCode = BchL.FTBchCode   AND BchL.FNLngID = $nLngID 
                LEFT JOIN [TVDMShopSize_L] Vsl_L    ON Vsl.FTShpCode = Vsl_L.FTShpCode  AND Vsl_L.FNLngID = $nLngID
                LEFT JOIN [TCNMShop_L] Shp_L        ON Vsl.FTShpCode = Shp_L.FTShpCode  AND Vsl.FTBchCode = SHP_L.FTBchCode  AND Shp_L.FNLngID = $nLngID
                WHERE 1=1 AND Vsl.FTBchCode ='$tBchCode' AND Vsl.FTShpCode = '$tShpCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }

        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //เอาข้อมูลของ Settting ออกมาโชว์
    function FSaMVEDGetDataSetting($paData){
        $tShpCode       = $paData['tShpCode'];
        $tBchCode       = $paData['tBchCode'];
        $nLngID         = $this->session->userdata("tLangEdit");
        $tSQL = "SELECT
                    Vsl.FTBchCode       AS rtVslBch,
                    Vsl.FTShpCode       AS rtVslShp,
                    Vsl.FCLayRowQty     AS rtVslRowQty,
                    Vsl.FCLayColQty     AS rtVslColQty,
                    Vsl.FTLayStaUse     AS rtVslStaUse,
                    Vsl_L.FTLayName     AS rtVslName,
                    Vsl_L.FTLayRemark   AS rtVslRemark
                FROM [TVDMShopSize] Vsl
                LEFT JOIN [TVDMShopSize_L] Vsl_L    ON Vsl.FTShpCode = Vsl_L.FTShpCode AND Vsl_L.FNLngID = $nLngID 
                WHERE 1=1 AND Vsl.FTBchCode ='$tBchCode' AND Vsl.FTShpCode = '$tShpCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }

        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //เอาข้อมูลความสูงของแต่ละชั้น 
    function FSaMVEDGetDataHeightFloor($paData){
        $tShpCode       = $paData['tShpCode'];
        $tBchCode       = $paData['tBchCode'];
        $nSeqCabinet    = $paData['nSeqCabinet'];
        $nLngID         = $this->session->userdata("tLangEdit");
        $tSQL = "SELECT
                        PDT.FNLayRow ,
                        PDT.FCLayHigh 
                FROM [TVDMPdtLayout] PDT
                WHERE 1=1 AND PDT.FTBchCode ='$tBchCode' AND PDT.FTShpCode = '$tShpCode' AND PDT.FNCabSeq = '$nSeqCabinet'  ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result_array();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //Not Found
            $oDetail = array();
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }

        // $jResult = json_encode($aResult);
        // $aResult = json_decode($jResult, true);
        return $oDetail;
    }

    //เอาข้อมูลไปแสดง DT รายการสินค้าต่างๆ
    public function FSaMVEDGetDataDT($paData){
        $tShpCode           = $paData['tShpCode'];
        $tBchCode           = $paData['tBchCode'];
        $nSeqCabinet        = $paData['nSeqCabinet'];
        $nLngID             = $this->session->userdata("tLangEdit");
        $tSQL = "SELECT 
                    DISTINCT
                    Vslpdt.FTShpCode        AS rtPdtShp,   
                    Vslpdt.FNLayRow         AS rtPdtRow,
                    Vslpdt.FNLayCol         AS rtPdtCol,
                    Vslpdt.FTPdtCode        AS rtPdtCode,
                    Vslpdt.FCLayColQtyMax   AS rtPdtColQtyMax,
                    Vslpdt.FTLayStaCtrlXY   AS FTLayStaCtrlXY,
                    Vslpdt.FTWahCode        AS FTWahCode,
                    Vslpdt.FCLayDim         AS rtPdtDim,
                    Vslpdt.FCLayHigh        AS rtPdtHigh,
                    Vslpdt.FCLayWide        AS rtPdtWide,
                    Vslpdt.FTLayStaUse      AS rtPdtStaUse,
                    Vslpdt.FNCabSeq         AS FNCabSeq,
                    REPLACE(PDTIMG.FTImgObj,'\','/')         AS rtPdtImage,
                    PDTL.FTPdtName          AS rtPdtName,
                    PDTL.FTPdtRmk           AS rtPdtRmk,
                    PDAGE.FCPdtCookTime     AS rtPdtCookTime, 
                    PDAGE.FCPdtCookHeat     AS rtPdtCookHeat
                    FROM [TVDMPdtLayout] Vslpdt
                    LEFT JOIN TCNMPdt    PDT     ON Vslpdt.FTPdtCode  	= PDT.FTPdtCode
                    LEFT JOIN TCNMPdt_L  PDTL    ON PDT.FTPdtCode       = PDTL.FTPdtCode AND PDTL.FNLngID = '$nLngID' 
                    LEFT JOIN TCNMPdtAge PDAGE   ON PDAGE.FTPdtCode     = PDT.FTPdtCode 
                    LEFT JOIN TCNMImgPdt PDTIMG  ON PDT.FTPdtCode       = PDTIMG.FTImgRefID AND PDTIMG.FTImgTable = 'TCNMPdt' AND PDTIMG.FTImgKey = 'master' AND PDTIMG.FNImgSeq = '1'
                    WHERE 1=1 AND Vslpdt.FTShpCode = '$tShpCode' AND Vslpdt.FTBchCode = '$tBchCode' AND Vslpdt.FNCabSeq = '$nSeqCabinet'  ";
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    } 

    //หาว่า MerCode อะไร
    public function FSaMVslFindMerCode($paDataFindMercode){
        $tFTBchCode = $paDataFindMercode['FTBchCode'];
        $tFTShpCode = $paDataFindMercode['FTShpCode'];
        $tSQL = "SELECT FTMerCode FROM TCNMShop WHERE FTBchCode = '$tFTBchCode' AND FTShpCode = '$tFTShpCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //ลบสินค้าใน Diagram ทั้งหมดก่อนเพิ่มสินค้าใหม่
    public function FSaMVslDeleteItem($paData){
        $this->db->where_in('FTShpCode', $paData['FTShpCode']);
        $this->db->where_in('FNCabSeq', $paData['FNCabSeq']);
        $this->db->delete('TVDMPdtLayout');
    }

    //เพิ่มสินค้าจาก Diagram ลงฐานข้อมูล
    public function FSaMVslInsertPDT($paData){
        try{
            $this->db->insert('TVDMPdtLayout',$paData);
            if($this->db->affected_rows() > 0 ){
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
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //หาว่าความสูงแต่ละชั้นเท่าไหร่
    public function FStMVEDFindHeight($pnBCH,$pnSHP,$pnFloor,$pnSeqCabinet){
        //หาความสูงแต่ละชั้น
        $tSQL = "SELECT FTPdtCode FROM TsysMasTmp 
                WHERE FTMttTableKey = 'TVDMShopCabinet' 
                AND FTBchCode = '$pnBCH' 
                AND FTShpCode = '$pnSHP' 
                AND FTRefPdtCode = '$pnFloor'
                AND FTGhdApp = '$pnSeqCabinet' ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result_array();
            $nHeight = $oDetail[0]['FTPdtCode'];
        }else{
            $nHeight = '100';
        }
        return $nHeight;
    }

    //ลบข้อมูล ที่ถูก Merge
    public function FSxMVslDeletePDT($paData){
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->where('FTMerCode', $paData['FTMerCode']);
        $this->db->where('FTShpCode', $paData['FTShpCode']);
        $this->db->where('FNLayRow', $paData['FNLayRow']);
        $this->db->where('FNLayCol', $paData['FNLayCol']);
        $this->db->delete('TVDMPdtLayout');
    }

    //เรียง Seq ใหม่
    public function FSxMVEDSortSeqrow($paData){
        $tFTBchCode = $paData['FTBchCode'];
        $tFTShpCode = $paData['FTShpCode'];
        $tFNCabSeq  = $paData['FNCabSeq'];
        $tSql = "UPDATE T1 
                SET T1.FNLayCol = T2.FNLayNewCol -1
                FROM  TVDMPdtLayout T1 
                LEFT JOIN(
                    SELECT  ROW_NUMBER() OVER(PARTITION BY FNLayRow ORDER BY  FNLayRow,FNLayCol ASC) AS FNLayNewCol , 
                    FTBchCode AS FTBchCodeX,
                    FTShpCode AS FTShpCodeX,
                    FNLayRow AS FNLayRowX,
                    FNLayCol AS FNLayColX
                    FROM  TVDMPdtLayout 
                    WHERE FTBchCode = '$tFTBchCode' AND FTShpCode = '$tFTShpCode' AND FNCabSeq = '$tFNCabSeq' ) T2 ON T1.FTBchCode = T2.FTBchCodeX AND T1.FTShpCode = T2.FTShpCodeX 
                    AND T1.FNLayRow=T2.FNLayRowX AND T1.FNLayCol = T2.FNLayColX
                WHERE T1.FTBchCode = '$tFTBchCode' AND T1.FTShpCode = '$tFTShpCode' AND T1.FNCabSeq = '$tFNCabSeq' ";
        $oQuery = $this->db->query($tSql);
    }

    //###### New Version ######

    //Get Cabinet
    public function FSaMVEDGetCabinet($paData){
        $tShpCode       = $paData['tShpCode'];
        $tBchCode       = $paData['tBchCode'];
        $nLngID         = $this->session->userdata("tLangEdit");
        $tSQL = "SELECT
                    SCB.FTBchCode ,
                    SCB.FTShpCode ,
                    SCB.FNCabSeq ,
                    SCB.FNCabMaxRow ,
                    SCB.FNCabMaxCol ,
                    SCB.FNCabType ,
                    SCB.FTShtCode ,
                    SCB.FDLastUpdOn ,
                    SCB.FTLastUpdBy ,
                    SCB.FDCreateOn ,
                    SCB.FTCreateBy ,
                    CabinetL.FTCabName ,
                    CabinetL.FTCabRmk ,
                    SPY.FTShtType,
                    SPT.FTShtName
                FROM [TVDMShopCabinet] SCB
                LEFT JOIN  [TVDMShopType] SPY ON SCB.FTShtCode = SPY.FTShtCode
                LEFT JOIN  [TVDMShopType_L] SPT ON SCB.FTShtCode = SPT.FTShtCode AND SPT.FNLngID = $nLngID
                LEFT JOIN  [TVDMShopCabinet_L] CabinetL ON SCB.FNCabSeq = CabinetL.FNCabSeq AND SCB.FTShpCode = CabinetL.FTShpCode 
                            AND SCB.FTBchCode = CabinetL.FTBchCode AND CabinetL.FNLngID = $nLngID 
                WHERE 1=1 AND SCB.FTShpCode ='$tShpCode' AND SCB.FTBchCode = '$tBchCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }

        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Update Cabinet
    public function FSxMVEDUpdateCabinet($paData){
        try{
            $dDateCreateOn  = date("Y-m-d H:i:s");
            $tSesUsername   = $this->session->userdata("tSesUsername");
            $FNLngID        = $this->session->userdata("tLangEdit");
            $FTShpCode      = $paData['tShpCode'];
            $FTBchCode      = $paData['tBchCode'];
            $FNCabSeq       = $paData['tCabinetSeq'];
            $FNCabMaxRow    = $paData['nVBFloor'];
            $FNCabMaxCol    = $paData['nVBColumn'];
            $FTCabName      = $paData['tVBName'];
            $FTCabRmk       = $paData['tVBReason'];
            $tTypePage      = $paData['tTypePage'];

            if($tTypePage == "EDIT"){
                $this->db->where('FTShpCode', $FTShpCode);
                $this->db->where('FTBchCode', $FTBchCode);
                $this->db->where('FNCabSeq' , $FNCabSeq);
                $this->db->update('TVDMShopCabinet',array(
                    'FNCabMaxRow'    => $FNCabMaxRow,
                    'FNCabMaxCol'    => $FNCabMaxCol,
                ));

                $this->db->where('FTShpCode', $FTShpCode);
                $this->db->where('FTBchCode', $FTBchCode);
                $this->db->where('FNCabSeq', $FNCabSeq);
                $this->db->update('TVDMShopCabinet_L',array(
                    'FNLngID'           => $FNLngID,
                    'FTCabName'         => $FTCabName,
                    'FTCabRmk'          => $FTCabRmk,
                ));
            }else if($tTypePage == "CONFIRM"){
                //ถ้าไม่สนใจ ยืนยันจะลดขนาดความสูงและลดชั้น จะต้องลบเเละทำรายการใหม่
                $tDisType      = $paData['tDisType'];
                if($tDisType == 'FLOOR'){
                    $this->db->where('FTShpCode', $FTShpCode);
                    $this->db->where('FNCabSeq' , $FNCabSeq);
                    $this->db->where('FTBchCode' , $FTBchCode);
                    $this->db->where('FNLayRow > ', $FNCabMaxRow);
                    $this->db->delete('TVDMPdtLayout');
                }else{
                    $this->db->where('FTShpCode', $FTShpCode);
                    $this->db->where('FNCabSeq' , $FNCabSeq);
                    $this->db->where('FTBchCode' , $FTBchCode);
                    $this->db->delete('TVDMPdtLayout');
                }

                $this->db->where('FTBchCode', $FTBchCode);
                $this->db->where('FTShpCode', $FTShpCode);
                $this->db->update('TVDMShopCabinet',array(
                    'FNCabMaxRow'    => $FNCabMaxRow,
                    'FNCabMaxCol'    => $FNCabMaxCol,
                    'FDLastUpdOn'    => $dDateCreateOn,
                    'FTLastUpdBy'    => $tSesUsername
                ));

                $this->db->where('FTBchCode', $FTBchCode);
                $this->db->where('FTShpCode', $FTShpCode);
                $this->db->where('FNCabSeq', $FNCabSeq);
                $this->db->update('TVDMShopCabinet_L',array(
                    'FNLngID'           => $FNLngID,
                    'FTCabName'         => $FTCabName,
                    'FTCabRmk'          => $FTCabRmk,
                ));
            }
            
            if($this->db->affected_rows() > 0 ){
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
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Delete Diagram
    public function FSaMVEDDeleteDiagram($paData){
        try{
            $tShpCode       = $paData['tShpCode'];
            $tBchCode       = $paData['tBchCode'];
            $nSeqCabinet    = $paData['nSeqCabinet'];

            $this->db->where('FTShpCode', $tShpCode);
            $this->db->where('FTBchCode', $tBchCode);
            $this->db->where('FNCabSeq', $nSeqCabinet);
            $this->db->delete('TVDMPdtLayout');

            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Delete',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Get wahhouse
    public function FSaMVEDGetWahhouse($paData){
        $tShpCode       = $paData['tShpCode'];
        $tBchCode       = $paData['tBchCode'];
        $nLngID         = $this->session->userdata("tLangEdit");

        $tSQL = "SELECT
                     SHP.FTWahCode,
                     SHP.FTWahCode AS WAHMain,
                     WAH_L.FTWahName
                 FROM [TCNMShpWah] SHP
                 LEFT JOIN  [TCNMWaHouse_L] WAH_L ON SHP.FTWahCode = WAH_L.FTWahCode AND SHP.FTBchCode = WAH_L.FTBchCode AND WAH_L.FNLngID = $nLngID
                 WHERE 1=1 AND SHP.FTShpCode ='$tShpCode' AND SHP.FTBchCode ='$tBchCode' ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //Not Found
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