<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arrangementproduct_model extends CI_Model {

    // ดึงข้อมูลมาแสดงบนตาราางหน้า List
    public function FSaMPAMGetDataTableList($paDataCondition){
        $aRowLen                = FCNaHCallLenData($paDataCondition['nRow'],$paDataCondition['nPage']);
        $nLngID                 = $paDataCondition['FNLngID'];
        $aAdvanceSearch         = $paDataCondition['aAdvanceSearch'];
        $tSearchList            = $aAdvanceSearch['tSearchAll'];
        $tSearchBchCode         = $aAdvanceSearch['tSearchBchCode'];
        $tSearchPlcCode         = $aAdvanceSearch['tSearchPlcCode'];
        $tSearchStaDoc          = $aAdvanceSearch['tSearchStaDoc'];
        $tSearchPackType        = $aAdvanceSearch['tSearchPackType'];
        $tSearchDocDateFrom     = $aAdvanceSearch['tSearchDocDateFrm'];
        $tSearchDocDateTo       = $aAdvanceSearch['tSearchDocDateTo'];
        $tSearchCat1Code        = $aAdvanceSearch['tSearchCat1Code'];
        $tSearchCat2Code        = $aAdvanceSearch['tSearchCat2Code'];

        $tSQL1  = "  SELECT c.* ,
                        COUNT(HDDocRef_in.FTXthDocNo) OVER (PARTITION BY C.FTXthDocNo)  AS PARTITIONBYDOC, 
                        HDDocRef_in.FTXthRefDocNo                                       AS 'DOCREF',
                        CONVERT(varchar,HDDocRef_in.FDXthRefDocDate, 103)               AS 'DATEREF'
                     FROM( SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , FTXthDocNo ASC ) AS FNRowID,* FROM ( ";
        $tSQL2  = "  SELECT
                        HD.FTBchCode,
                        BCHL.FTBchName,
                        HD.FTXthDocNo,
                        CONVERT(CHAR(10),HD.FDXthDocDate,103) AS FDXthDocDate,
                        CONVERT(CHAR(5), HD.FDXthDocDate,108) AS FTXthDocTime,
                        HD.FTXthStaDoc,
                        HD.FTXthStaApv,
                        HD.FTCreateBy,
                        HD.FDCreateOn,
                        HD.FNXthStaDocAct,
                        HD.FNXthDocType,
                        USRL.FTUsrName          AS FTCreateByName
                    FROM TCNTPdtPickHD	            HD      WITH (NOLOCK)
                    LEFT JOIN TCNMBranch_L          BCHL    WITH (NOLOCK) ON HD.FTBchCode     = BCHL.FTBchCode    AND BCHL.FNLngID          = $nLngID
                    LEFT JOIN TCNMUser_L            USRL    WITH (NOLOCK) ON HD.FTCreateBy    = USRL.FTUsrCode    AND USRL.FNLngID          = $nLngID
                    WHERE (HD.FNXthDocType = 11 OR HD.FNXthDocType = 13) ";

        if ( $this->session->userdata('tSesUsrLevel') != "HQ" ) {
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL2 .= " AND HD.FTBchCode IN ($tBchCode) ";
        }

        //สาขา
        if( !empty($tSearchBchCode) ){
            $tSQL2 .= " AND HD.FTBchCode = '".$tSearchBchCode."' ";
        }
        // ที่เก็บสินค้า
        if( !empty($tSearchPlcCode) ){
            $tSQL2 .= " AND HD.FTPlcCode = '".$tSearchPlcCode."' ";
        }

        // หมวดสินค้า 1
        if( !empty($tSearchCat1Code) ){
            $tSQL2 .= " AND HD.FTXthCat1 = '".$tSearchCat1Code."' ";
        }

        // หมวดสินค้า 2
        if( !empty($tSearchCat2Code) ){
            $tSQL2 .= " AND HD.FTXthCat2 = '".$tSearchCat2Code."' ";
        }

        // ค้นหาจากวันที่ - ถึงวันที่
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL2 .= " AND ((HD.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (HD.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        // ค้นหาสถานะเอกสาร
        if(isset($tSearchStaDoc) && !empty($tSearchStaDoc)){
            if ($tSearchStaDoc == '3') {
                $tSQL2 .= " AND HD.FTXthStaDoc = '3' ";
            } elseif ($tSearchStaDoc == '2') {
                $tSQL2 .= " AND ISNULL(HD.FTXthStaApv,'') = '' AND HD.FTXthStaDoc != '3' ";
            } elseif ($tSearchStaDoc == '1') {
                $tSQL2 .= " AND HD.FTXthStaApv = '1' ";
            }
        }

        // ประเภทใบจัด
        if(isset($tSearchPackType) && !empty($tSearchPackType)){
            if ($tSearchPackType == 11) {
                $tSQL2 .= " AND HD.FNXthDocType = 11 ";
            } else if ($tSearchPackType == 13) {
                $tSQL2 .= " AND HD.FNXthDocType = 13 ";
            }else {
                $tSQL2 .= " AND (HD.FNXthDocType = 11 OR HD.FNXthDocType = 13) ";
            }
        }

        $tSQL3      =  ") Base) AS c 
        LEFT JOIN TCNTPdtPickHDDocRef HDDocRef_in WITH (NOLOCK) ON C.FTXthDocNo = HDDocRef_in.FTXthDocNo AND HDDocRef_in.FTXthRefType = 1
        WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        // ค้นหาเอกสาร,ชือสาขา,วันที่เอกสาร
        if(isset($tSearchList) && !empty($tSearchList)){
            $tSQL3 .= " AND ((c.FTXthDocNo LIKE '%$tSearchList%')
                            OR (c.FTBchName LIKE '%$tSearchList%')
                            OR (CONVERT(CHAR(10),c.FDXthDocDate,103) LIKE '%$tSearchList%') 
                            OR (HDDocRef_in.FTXthRefDocNo LIKE '%$tSearchList%') 
                        ) ";
        }

        $tSQL3      .=  " ORDER BY c.FDCreateOn DESC ";

        $tSQLMain   = $tSQL1.$tSQL2.$tSQL3;
        // echo $tSQLMain;
        // exit;
        $oQueryMain = $this->db->query($tSQLMain);

        if( $oQueryMain->num_rows() > 0 ){
            $oDataList          = $oQueryMain->result_array();
            $tSQLPage           = $tSQL2;
            $oQueryPage         = $this->db->query($tSQLPage);
            $nFoundRow          = $oQueryPage->num_rows();
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
        unset($oQueryMain);
        unset($oDataList);
        unset($aDataCountAllRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aResult;
    }

    // เปิดมาหน้า ADD จะต้อง ลบเอกสารอ้างอิง ใน Temp โดย where session
    public function FSxMPAMClearDataInDocTemp(){
        $tSessionID = $this->session->userdata('tSesSessionID');

        //ลบข้อมูล HDDocRef
        $this->db->where_in('FTSessionID', $tSessionID);
        $this->db->where('FTXthDocKey', 'TCNTPdtPickHD');
        $this->db->delete('TCNTDocHDRefTmp');

        //ลบข้อมูล DT
        $this->db->where_in('FTSessionID', $tSessionID);
        $this->db->where('FTXthDocKey', 'TCNTPdtPickDT');
        $this->db->delete('TCNTDocDTTmp');
    }

    // ข้อมูลสินค้า ใน Temp
    public function FSaMPAMGetDocDTTempListPage($paDataWhere){
        $tPAMDocNo           = $paDataWhere['FTXthDocNo'];
        $tPAMDocKey          = $paDataWhere['FTXthDocKey'];
        $tPAMSesSessionID    = $this->session->userdata('tSesSessionID');

        $tSQL       = " SELECT
                        PAMCTMP.FTBchCode,
                        PAMCTMP.FTXthDocNo,
                        PAMCTMP.FNXtdSeqNo,
                        PAMCTMP.FTXthDocKey,
                        PAMCTMP.FTPdtCode,
                        PAMCTMP.FTXtdPdtName,
                        PAMCTMP.FTPunName,
                        PAMCTMP.FTXtdBarCode,
                        PAMCTMP.FTPunCode,
                        PAMCTMP.FCXtdFactor,
                        PAMCTMP.FCXtdQty,
                        PAMCTMP.FCXtdSetPrice,
                        PAMCTMP.FCXtdAmtB4DisChg,
                        PAMCTMP.FTXtdDisChgTxt,
                        PAMCTMP.FCXtdNet,
                        PAMCTMP.FCXtdNetAfHD,
                        PAMCTMP.FTXtdStaAlwDis,
                        PAMCTMP.FTTmpRemark,
                        PAMCTMP.FCXtdVatRate,
                        PAMCTMP.FTXtdVatType,
                        PAMCTMP.FTSrnCode,
                        PAMCTMP.FDLastUpdOn,
                        PAMCTMP.FDCreateOn,
                        PAMCTMP.FTLastUpdBy,
                        PAMCTMP.FTCreateBy,
                        PAMCTMP.FTXtdPdtSetOrSN,
                        PAMCTMP.FCXtdQtyOrd,
                        PAMCTMP.FTXtdRmk
                    FROM TCNTDocDTTmp PAMCTMP WITH (NOLOCK)
                    WHERE PAMCTMP.FTXthDocKey = '$tPAMDocKey'
                          AND PAMCTMP.FTSessionID = '$tPAMSesSessionID' ";

        if(isset($tPAMDocNo) && !empty($tPAMDocNo)){
            $tSQL   .=  " AND ISNULL(PAMCTMP.FTXthDocNo,'')  = '$tPAMDocNo' ";
        }

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataList  = $oQuery->result_array();
            $aDataReturn    = array(
                'raItems'       => $aDataList,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    = array(
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

    // ข้อมูลสินค้า
    public function FSaMPAMGetDataPdt($paDataPdtParams){
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
                            0 AS FTPdtSalePrice,
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
                            CAVG.FCPdtCostIn
                        FROM TCNMPdt PDT WITH (NOLOCK)
                        LEFT JOIN TCNMPdt_L PDTL        WITH (NOLOCK)   ON PDT.FTPdtCode      = PDTL.FTPdtCode    AND PDTL.FNLngID    = $nLngID
                        LEFT JOIN TCNMPdtPackSize  PKS  WITH (NOLOCK)   ON PDT.FTPdtCode      = PKS.FTPdtCode     AND PKS.FTPunCode   = '$FTPunCode'
                        LEFT JOIN TCNMPdtUnit_L UNTL    WITH (NOLOCK)   ON UNTL.FTPunCode     = '$FTPunCode'      AND UNTL.FNLngID    = $nLngID
                        LEFT JOIN TCNMPdtBar BAR        WITH (NOLOCK)   ON PKS.FTPdtCode      = BAR.FTPdtCode     AND BAR.FTPunCode   = '$FTPunCode'
                        LEFT JOIN TCNMPdtLoc_L PDTLOCL  WITH (NOLOCK)   ON PDTLOCL.FTPlcCode  = BAR.FTPlcCode     AND PDTLOCL.FNLngID = $nLngID
                        LEFT OUTER JOIN VCN_VatActive VAT WITH (NOLOCK) ON  PDT.FTVatCode = VAT.FTVatCode
                        LEFT JOIN TCNTPdtSerial PDTSRL  WITH (NOLOCK)   ON PDT.FTPdtCode    = PDTSRL.FTPdtCode
                        LEFT JOIN TCNMPdtCostAvg CAVG   WITH (NOLOCK)   ON PDT.FTPdtCode    = CAVG.FTPdtCode
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

    // เพิ่มข้อมูลลง temp
    public function FSaMPAMInsertPDTToTemp($paDataPdtMaster,$paDataPdtParams){
        $paDataPdt    = $paDataPdtMaster['raItem'];
        if ($paDataPdtParams['tPAMOptionAddPdt'] == 1) {
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
                            AND FTPdtCode       = '".$paDataPdt["FTPdtCode"]."'
                            AND FTXtdBarCode    = '".$paDataPdt["FTBarCode"]."'
                            ORDER BY FNXtdSeqNo
                        ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                // เพิ่มจำนวนให้รายการที่มีอยู่แล้ว
                $aResult    = $oQuery->row_array();
                $tSQL       =   "   UPDATE TCNTDocDTTmp
                                    SET FCXtdQty = '".($aResult["FCXtdQty"] + 1 )."' ,
                                    FCXtdQtyAll = '".($aResult["FCXtdQty"] + 1 ) * $paDataPdt['FCPdtUnitFact']."'
                                    WHERE 1=1
                                    AND FTBchCode       = '".$paDataPdtParams['tBchCode']."'
                                    AND FTXthDocNo      = '".$paDataPdtParams['tDocNo']."'
                                    AND FNXtdSeqNo      = '".$aResult["FNXtdSeqNo"]."'
                                    AND FTXthDocKey     = '".$paDataPdtParams['tDocKey']."'
                                    AND FTSessionID     = '".$paDataPdtParams['tSessionID']."'
                                    AND FTPdtCode       = '".$paDataPdt["FTPdtCode"]."'
                                    AND FTXtdBarCode    = '".$paDataPdt["FTBarCode"]."'
                                ";
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
                    'FTPdtCode'         => $paDataPdt['FTPdtCode'],
                    'FTXtdPdtName'      => $paDataPdt['FTPdtName'],
                    'FCXtdFactor'       => $paDataPdt['FCPdtUnitFact'],
                    'FTPunCode'         => $paDataPdt['FTPunCode'],
                    'FTPunName'         => $paDataPdt['FTPunName'],
                    'FTXtdBarCode'      => $paDataPdtParams['tBarCode'],
                    'FTXtdVatType'      => $paDataPdt['FTPdtStaVatBuy'],
                    'FTVatCode'         => $paDataPdt['FTVatCode'],
                    'FCXtdVatRate'      => $paDataPdt['FCVatRate'],
                    'FTXtdStaAlwDis'    => $paDataPdt['FTPdtStaAlwDis'],
                    'FTXtdSaleType'     => $paDataPdt['FTPdtSaleType'],
                    'FCXtdSalePrice'    => $paDataPdtParams['cPrice'],
                    'FCXtdQty'          => 1,
                    'FCXtdQtyAll'       => 1*$paDataPdt['FCPdtUnitFact'],
                    'FCXtdSetPrice'     => $paDataPdtParams['cPrice'] * 1,
                    'FCXtdNet'          => $paDataPdtParams['cPrice'] * 1,
                    'FTSessionID'       => $paDataPdtParams['tSessionID'],
                    'FDLastUpdOn'       => date('Y-m-d h:i:s'),
                    'FTLastUpdBy'       => $paDataPdtParams['tPAMUsrCode'],
                    'FDCreateOn'        => date('Y-m-d h:i:s'),
                    'FTCreateBy'        => $paDataPdtParams['tPAMUsrCode'],
                );
                $this->db->insert('TCNTDocDTTmp',$aDataInsert);
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
        }else{
            // เพิ่มแถวใหม่
            $aDataInsert    = array(
                'FTBchCode'         => $paDataPdtParams['tBchCode'],
                'FTXthDocNo'        => $paDataPdtParams['tDocNo'],
                'FNXtdSeqNo'        => $paDataPdtParams['nMaxSeqNo'],
                'FTXthDocKey'       => $paDataPdtParams['tDocKey'],
                'FTPdtCode'         => $paDataPdt['FTPdtCode'],
                'FTXtdPdtName'      => $paDataPdt['FTPdtName'],
                'FCXtdFactor'       => $paDataPdt['FCPdtUnitFact'],
                'FTPunCode'         => $paDataPdt['FTPunCode'],
                'FTPunName'         => $paDataPdt['FTPunName'],
                'FTXtdBarCode'      => $paDataPdtParams['tBarCode'],
                'FTXtdVatType'      => $paDataPdt['FTPdtStaVatBuy'],
                'FTVatCode'         => $paDataPdt['FTVatCode'],
                'FCXtdVatRate'      => $paDataPdt['FCVatRate'],
                'FTXtdStaAlwDis'    => $paDataPdt['FTPdtStaAlwDis'],
                'FTXtdSaleType'     => $paDataPdt['FTPdtSaleType'],
                'FCXtdSalePrice'    => $paDataPdtParams['cPrice'],
                'FCXtdQty'          => 1,
                'FCXtdQtyAll'       => 1*$paDataPdt['FCPdtUnitFact'],
                'FCXtdSetPrice'     => $paDataPdtParams['cPrice'] * 1,
                'FCXtdNet'          => $paDataPdtParams['cPrice'] * 1,
                'FTSessionID'       => $paDataPdtParams['tSessionID'],
                'FDLastUpdOn'       => date('Y-m-d h:i:s'),
                'FTLastUpdBy'       => $paDataPdtParams['tPAMUsrCode'],
                'FDCreateOn'        => date('Y-m-d h:i:s'),
                'FTCreateBy'        => $paDataPdtParams['tPAMUsrCode'],
            );
            $this->db->insert('TCNTDocDTTmp',$aDataInsert);
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

    // แก้ไขข้อมูล ตาม Seq
    public function FSaMPAMUpdateInlineDTTemp($paDataUpdateDT,$paDataWhere){
        $this->db->where_in('FTSessionID',$paDataWhere['tPAMSessionID']);
        $this->db->where_in('FTXthDocKey',$paDataWhere['tDocKey']);
        $this->db->where_in('FNXtdSeqNo',$paDataWhere['nPAMSeqNo']);

        if ($paDataWhere['tPAMDocNo'] != '' && $paDataWhere['tPAMBchCode'] != '') {
            $this->db->where_in('FTXthDocNo',$paDataWhere['tPAMDocNo']);
            $this->db->where_in('FTBchCode',$paDataWhere['tPAMBchCode']);
        }

        $this->db->update('TCNTDocDTTmp', $paDataUpdateDT);
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

    // ลบข้อมูลใน Temp
    public function FSnMPAMDelPdtInDTTmp($paDataWhere){
        $this->db->where_in('FTSessionID',$paDataWhere['tSessionID']);
        $this->db->where_in('FTXthDocNo',$paDataWhere['tPAMDocNo']);
        $this->db->where_in('FTXthDocKey',$paDataWhere['tDocKey']);
        $this->db->where_in('FTPdtCode',$paDataWhere['tPdtCode']);
        $this->db->where_in('FNXtdSeqNo',$paDataWhere['nSeqNo']);
        $this->db->where_in('FTBchCode',$paDataWhere['tBchCode']);
        $this->db->delete('TCNTDocDTTmp');
        return ;
    }

    // [เอกสารอ้างอิง] อ้างอิงเอกสาร table
    public function FSaMPAMGetDataHDRefTmp($paData){
        $tTableTmpHDRef = $paData['tTableTmpHDRef'];
        $FTXthDocNo     = $paData['FTXthDocNo'];
        $FTXthDocKey    = $paData['FTXthDocKey'];
        $FTSessionID    = $paData['FTSessionID'];

        $tSQL = "   SELECT TMP.FTXthDocNo, TMP.FTXthRefDocNo, TMP.FTXthRefType, TMP.FTXthRefKey, TMP.FDXthRefDocDate 
                    FROM $tTableTmpHDRef TMP WITH(NOLOCK)
                    WHERE TMP.FTXthDocNo  = '$FTXthDocNo'
                      AND TMP.FTXthDocKey = '$FTXthDocKey'
                      AND TMP.FTSessionID = '$FTSessionID'
                    ORDER BY TMP.FDCreateOn DESC ";
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() > 0 ){
            $aResult    = array(
                'aItems'   => $oQuery->result_array(),
                'tCode'    => '1',
                'tDesc'    => 'found data',
            );
        }else{
            $aResult    = array(
                'tCode'    => '800',
                'tDesc'    => 'data not found.',
            );
        }
        return $aResult;
    }

    // [เอกสารอ้างอิง] อ้างอิงเอกสารใบสั่งขาย HD
    public function FSoMPAMCallRefIntDoc_SO_DataTable($paDataCondition){
        $aRowLen                  = FCNaHCallLenData($paDataCondition['nRow'],$paDataCondition['nPage']);
        $nLngID                   = $paDataCondition['FNLngID'];
        $aAdvanceSearch           = $paDataCondition['aAdvanceSearch'];
        $tPAMRefIntBchCode        = $aAdvanceSearch['tPAMRefIntBchCode'];
        $tPAMRefIntDocNo          = $aAdvanceSearch['tPAMRefIntDocNo'];
        $tPAMRefIntDocDateFrm     = $aAdvanceSearch['tPAMRefIntDocDateFrm'];
        $tPAMRefIntDocDateTo      = $aAdvanceSearch['tPAMRefIntDocDateTo'];
        $tPAMRefIntStaDoc         = $aAdvanceSearch['tPAMRefIntStaDoc'];

        $tSQLMain = "   SELECT DISTINCT
                        HD.FTBchCode,
                        BCHL.FTBchName,
                        HD.FTXshDocNo       AS FTXphDocNo,
                        CONVERT(CHAR(10),HD.FDXshDocDate,121) AS FDXphDocDate,
                        CONVERT(CHAR(5), HD.FDXshDocDate,108) AS FTXshDocTime,
                        HD.FTXshStaDoc      AS FTXphStaDoc,
                        HD.FTXshStaApv      AS FTXphStaApv,
                        HD.FNXshStaRef      AS FNXphStaRef,
                        HD.FTXshVATInOrEx   AS FTXphVATInOrEx,
                        CST_Crd.FNCstCrTerm AS FNXphCrTerm,
                        HD.FTCreateBy,
                        HD.FDCreateOn,
                        HD.FNXshStaDocAct   AS FNXphStaDocAct,
                        USRL.FTUsrName      AS FTCreateByName,
                        HD.FTXshApvCode     AS FTXphApvCode,
                        WAH_L.FTWahCode,
                        WAH_L.FTWahName
                    FROM TARTSoHD HD WITH (NOLOCK)
                    LEFT JOIN TCNMBranch_L          BCHL        WITH (NOLOCK) ON HD.FTBchCode     = BCHL.FTBchCode    AND BCHL.FNLngID    = ".$this->db->escape($nLngID)."
                    LEFT JOIN TCNMUser_L            USRL        WITH (NOLOCK) ON HD.FTCreateBy    = USRL.FTUsrCode    AND USRL.FNLngID    = ".$this->db->escape($nLngID)."
                    LEFT JOIN TCNMWaHouse_L         WAH_L       WITH (NOLOCK) ON HD.FTBchCode     = WAH_L.FTBchCode   AND HD.FTWahCode = WAH_L.FTWahCode AND WAH_L.FNLngID	= ".$this->db->escape($nLngID)."
                    LEFT JOIN TCNMCstCredit         CST_Crd     WITH (NOLOCK) ON HD.FTCstCode     = CST_Crd.FTCstCode
                    LEFT JOIN TCNTPdtPickHDDocRef   DOCREFTMP   WITH (NOLOCK) ON HD.FTXshDocNo    = DOCREFTMP.FTXthRefDocNo AND DOCREFTMP.FTXthRefType = '1'
                    WHERE 1=1";

        //ไม่เอาเอกสารที่อ้างอิงเเล้ว
        $tSQLMain .= " AND ISNULL(DOCREFTMP.FTXthRefDocNo,'') = '' ";

        if(isset($tPAMRefIntBchCode) && !empty($tPAMRefIntBchCode)){
            $tSQLMain .= " AND (HD.FTBchCode = ".$this->db->escape($tPAMRefIntBchCode)." OR HD.FTBchCode = ".$this->db->escape($tPAMRefIntBchCode).")";
        }

        if(isset($tPAMRefIntDocNo) && !empty($tPAMRefIntDocNo)){
            $tSQLMain .= " AND (HD.FTXshDocNo LIKE '%".$this->db->escape_like_str($tPAMRefIntDocNo)."%')";
        }

        // ค้นหาจากวันที่ - ถึงวันที่
        if(!empty($tPAMRefIntDocDateFrm) && !empty($tPAMRefIntDocDateTo)){
            $tSQLMain .= " AND ((HD.FDXshDocDate BETWEEN CONVERT(datetime,'$tPAMRefIntDocDateFrm 00:00:00') AND CONVERT(datetime,'$tPAMRefIntDocDateTo 23:59:59')) OR (HD.FDXshDocDate BETWEEN CONVERT(datetime,'$tPAMRefIntDocDateTo 23:00:00') AND CONVERT(datetime,'$tPAMRefIntDocDateFrm 00:00:00')))";
        }

        // ค้นหาสถานะเอกสาร
        if(isset($tPAMRefIntStaDoc) && !empty($tPAMRefIntStaDoc)){
            if ($tPAMRefIntStaDoc == 3) {
                $tSQLMain .= " AND HD.FTXshStaDoc = ".$this->db->escape($tPAMRefIntStaDoc);
            } elseif ($tPAMRefIntStaDoc == 2) {
                $tSQLMain .= " AND ISNULL(HD.FTXshStaApv,'') = '' AND HD.FTXshStaDoc != ".$this->db->escape(3);
            } elseif ($tPAMRefIntStaDoc == 1) {
                $tSQLMain .= " AND HD.FTXshStaApv = ".$this->db->escape($tPAMRefIntStaDoc)." AND HD.FTXshStaDoc = '1' ";
            }
        }

        $tSQL   =   " SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FDXphDocDate DESC ,FTXphDocNo DESC ) AS FNRowID,* FROM
                (  $tSQLMain
                ) Base) AS c WHERE c.FNRowID > ".$this->db->escape($aRowLen[0])." AND c.FNRowID <= ".$this->db->escape($aRowLen[1])." ";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->result_array();
            $oQueryMain         = $this->db->query($tSQLMain);
            $aDataCountAllRow   = $oQueryMain->num_rows();
            $nFoundRow          = $aDataCountAllRow;
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
        unset($oQuery);
        unset($oDataList);
        unset($aDataCountAllRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aResult;
    }

    // [เอกสารอ้างอิง] อ้างอิงเอกสารใบจ่ายโอน - สาขา HD
    public function FSoMPAMCallRefIntDoc_TBO_DataTable($paDataCondition){
        $aRowLen                    = FCNaHCallLenData($paDataCondition['nRow'],$paDataCondition['nPage']);
        $nLngID                     = $paDataCondition['FNLngID'];
        $aAdvanceSearch             = $paDataCondition['aAdvanceSearch'];
        $tPAMRefIntBchCode          = $aAdvanceSearch['tPAMRefIntBchCode'];
        $tPAMRefIntDocNo            = $aAdvanceSearch['tPAMRefIntDocNo'];
        $tPAMRefIntDocDateFrm       = $aAdvanceSearch['tPAMRefIntDocDateFrm'];
        $tPAMRefIntDocDateTo        = $aAdvanceSearch['tPAMRefIntDocDateTo'];
        $tPAMRefIntStaDoc           = $aAdvanceSearch['tPAMRefIntStaDoc'];

        $tSQLMain = "   SELECT DISTINCT
                        TBOHD.FTBchCode,
                        BCHL.FTBchName,
                        BCHLTO.FTBchName        AS BCHNameTo,
                        TBOHD.FTXthDocNo        AS FTXphDocNo,
                        CONVERT(CHAR(10),TBOHD.FDXthDocDate,121) AS FDXphDocDate,
                        CONVERT(CHAR(5), TBOHD.FDXthDocDate,108) AS FTXshDocTime,
                        TBOHD.FTXthStaDoc       AS FTXphStaDoc ,
                        TBOHD.FTXthStaApv       AS FTXphStaApv,
                        TBOHD.FNXthStaRef       AS FNXphStaRef,
                        '0'                     AS FTXphVATInOrEx,
                        '0'                     AS FNXphCrTerm,
                        TBOHD.FTCreateBy,
                        TBOHD.FDCreateOn,
                        0                       AS FNXphStaDocAct,
                        USRL.FTUsrName          AS FTCreateByName,
                        TBOHD.FTXthApvCode      AS FTXphApvCode,
                        WAH_L.FTWahCode,
                        WAH_L.FTWahName
                    FROM TCNTPdtTboHD       TBOHD           WITH (NOLOCK)
                    LEFT JOIN TCNMBranch_L  BCHL            WITH (NOLOCK) ON TBOHD.FTXthBchFrm   = BCHL.FTBchCode    AND BCHL.FNLngID    = $nLngID
                    LEFT JOIN TCNMBranch_L  BCHLTO          WITH (NOLOCK) ON TBOHD.FTXthBchTo    = BCHLTO.FTBchCode  AND BCHLTO.FNLngID  = $nLngID
                    LEFT JOIN TCNMUser_L    USRL            WITH (NOLOCK) ON TBOHD.FTCreateBy    = USRL.FTUsrCode    AND USRL.FNLngID    = $nLngID
                    LEFT JOIN TCNMWaHouse_L WAH_L           WITH (NOLOCK) ON TBOHD.FTXthBchFrm   = WAH_L.FTBchCode   AND TBOHD.FTXthWhFrm = WAH_L.FTWahCode AND WAH_L.FNLngID = $nLngID
                    LEFT JOIN TCNTPdtPickHDDocRef DOCREFTMP WITH (NOLOCK) ON TBOHD.FTXthDocNo   = DOCREFTMP.FTXthRefDocNo AND DOCREFTMP.FTXthRefType = '1'
                    WHERE 1 =1 ";

        //ไม่เอาเอกสารที่อ้างอิงเเล้ว
        $tSQLMain .= " AND ISNULL(DOCREFTMP.FTXthRefDocNo,'') = '' ";

        if(isset($tPAMRefIntBchCode) && !empty($tPAMRefIntBchCode)){
            $tSQLMain .= " AND (TBOHD.FTBchCode = '$tPAMRefIntBchCode' OR TBOHD.FTBchCode = '$tPAMRefIntBchCode')";
        }else {
            if ($this->session->userdata("tSesUsrLevel") != 'HQ') {
            $tSesUsrBchCodeMulti = $this->session->userdata("tSesUsrBchCodeMulti");
            $tSQLMain .= " AND TBOHD.FTBchCode IN ($tSesUsrBchCodeMulti) ";
            }
        }

        if(isset($tPAMRefIntDocNo) && !empty($tPAMRefIntDocNo)){
            $tSQLMain .= " AND (TBOHD.FTXthDocNo LIKE '%$tPAMRefIntDocNo%')";
        }

        // ค้นหาจากวันที่ - ถึงวันที่
        if(!empty($tPAMRefIntDocDateFrm) && !empty($tPAMRefIntDocDateTo)){
            $tSQLMain .= " AND ((TBOHD.FDXthDocDate BETWEEN CONVERT(datetime,'$tPAMRefIntDocDateFrm 00:00:00') AND CONVERT(datetime,'$tPAMRefIntDocDateTo 23:59:59')) OR (TBOHD.FDXthDocDate BETWEEN CONVERT(datetime,'$tPAMRefIntDocDateTo 23:00:00') AND CONVERT(datetime,'$tPAMRefIntDocDateFrm 00:00:00')))";
        }

        // ค้นหาสถานะเอกสาร
        if(isset($tPAMRefIntStaDoc) && !empty($tPAMRefIntStaDoc)){
            if ($tPAMRefIntStaDoc == 3) {
                $tSQLMain .= " AND TBOHD.FTXthStaDoc = '$tPAMRefIntStaDoc'";
            } elseif ($tPAMRefIntStaDoc == 2) {
                $tSQLMain .= " AND ISNULL(TBOHD.FTXthStaApv,'') = '' AND TBOHD.FTXthStaDoc != '3'";
            } elseif ($tPAMRefIntStaDoc == 1) {
                $tSQLMain .= " AND TBOHD.FTXthStaApv = '$tPAMRefIntStaDoc' AND TBOHD.FTXthStaDoc = '1' ";
            }
        }

        $tSQL   =   "SELECT c.* FROM(
                    SELECT  ROW_NUMBER() OVER(ORDER BY FDXphDocDate DESC ,FTXphDocNo DESC ) AS FNRowID,* FROM
                    (  $tSQLMain
                    ) Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1] ";

        $oQuery = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->result_array();
            $oQueryMain         = $this->db->query($tSQLMain);
            $aDataCountAllRow   = $oQueryMain->num_rows();
            $nFoundRow          = $aDataCountAllRow;
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
        unset($oQuery);
        unset($oDataList);
        unset($aDataCountAllRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aResult;
    }

    // [เอกสารอ้างอิง] อ้างอิงเอกสารใบสั่งขาย DT
    public function FSoMPAMCallRefIntDocDT_SO_DataTable($paData){

        $tBchCode   =  $paData['tBchCode'];
        $tDocNo     =  $paData['tDocNo'];
        $tSQL       = "SELECT
                        DT.FTBchCode,
                        DT.FTXshDocNo   AS FTXphDocNo,
                        DT.FNXsdSeqNo   AS FNXpdSeqNo,
                        DT.FTPdtCode,
                        DT.FTXsdPdtName AS FTXpdPdtName,
                        DT.FTPunCode,
                        DT.FTPunName,
                        DT.FTXsdBarCode AS FTXpdBarCode,
                        DT.FCXsdFactor  AS FCXpdFactor,
                        DT.FCXsdQty     AS FCXpdQty,
                        DT.FCXsdQty     AS FCXpdQtyAll,
                        DT.FTXsdRmk     AS FTXpdRmk,
                        DT.FDLastUpdOn,
                        DT.FTLastUpdBy,
                        DT.FDCreateOn,
                        DT.FTCreateBy
                        FROM TARTSoDT DT WITH(NOLOCK)
                    WHERE  DT.FTBchCode = '$tBchCode' AND  DT.FTXshDocNo ='$tDocNo' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->result_array();
            $aResult = array(
                'raItems'       => $oDataList,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        return $aResult;
    }

    // [เอกสารอ้างอิง] อ้างอิงเอกสารใบจ่ายโอน - สาขา DT
    public function FSoMPAMCallRefIntDocDT_TBO_DataTable($paData){
        $tBchCode  =  $paData['tBchCode'];
        $tDocNo    =  $paData['tDocNo'];
        $tSQL      = "SELECT
                        DT.FTBchCode,
                        DT.FTXthDocNo   AS FTXphDocNo,
                        DT.FNXtdSeqNo   AS FNXpdSeqNo,
                        DT.FTPdtCode,
                        DT.FTXtdPdtName AS FTXpdPdtName,
                        DT.FTPunCode,
                        DT.FTPunName,
                        DT.FTXtdBarCode AS FTXpdBarCode,
                        DT.FCXtdFactor  AS FCXpdFactor,
                        DT.FCXtdQty     AS FCXpdQty,
                        DT.FCXtdQtyAll  AS FCXpdQtyAll,
                        DT.FTXtdRmk     AS FTXpdRmk,
                        DT.FDLastUpdOn,
                        DT.FTLastUpdBy,
                        DT.FDCreateOn,
                        DT.FTCreateBy
                        FROM TCNTPdtTboDT DT WITH(NOLOCK)
                    WHERE  DT.FTBchCode = '$tBchCode' AND  DT.FTXthDocNo ='$tDocNo' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDataList          = $oQuery->result_array();
            $aResult = array(
                'raItems'       => $oDataList,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        return $aResult;
    }

    // [เอกสารอ้างอิง] นำข้อมูลจากใบสั่งขาย ลง DTTemp
    public function FSoMPAMCallRefIntDocInsert_SO_DTToTemp($paData){

        $tPAMDocNo          = $paData['tPAMDocNo'];
        $tPAMFrmBchCode     = $paData['tPAMFrmBchCode'];
        $tRefIntDocNo       = $paData['tRefIntDocNo'];
        $tRefIntBchCode     = $paData['tRefIntBchCode'];
        $tInsertOrUpdateRow = $paData['tInsertOrUpdateRow'];
        $aSeqNo             = '(' . implode(',', $paData['aSeqNo']) .')';

        if($tInsertOrUpdateRow == 1){ //บวก QTY
            // $nQTY       = "DT.FCXsdQty" .'+'. "ISNULL(DOCTMP.FCXtdQty,0)";
            // $nQTYAll    = "DT.FCXsdQtyAll" .'+'. "ISNULL(DOCTMP.FCXtdQtyAll,0)";
            // $nQTYOrd    = "DT.FCXsdQty" .'+'. "ISNULL(DOCTMP.FCXtdQty,0)";
            $nQTY       = "DT.FCXsdQty";
            $nQTYAll    = "DT.FCXsdQtyAll";
            $nQTYOrd    = "DT.FCXsdQty";
        }else{ //ขึ้น row ใหม่
            $nQTY       = "DT.FCXsdQty";
            $nQTYAll    = "DT.FCXsdQtyAll";
            $nQTYOrd    = "DT.FCXsdQty";
        }

        $tSQL= "INSERT INTO TCNTDocDTTmp (
                FTBchCode,FTXthDocNo,FNXtdSeqNo,FTXthDocKey,FTPdtCode,FTXtdPdtName,FTPunCode,FTPunName,FCXtdFactor,FTXtdBarCode,
                FCXtdQty,FCXtdQtyAll,FTXtdStaPrcStk,FTXtdStaAlwDis,FNXtdPdtLevel,FTXtdPdtParent,
                FTXtdPdtStaSet,FTXtdRmk,FCXtdQtyOrd,FTSessionID,FDLastUpdOn,FDCreateOn,FTLastUpdBy,FTCreateBy )
                SELECT
                    '$tPAMFrmBchCode'   AS FTBchCode,
                    '$tPAMDocNo'        AS FTXphDocNo,
                    DT.FNXsdSeqNo,
                    'TCNTPdtPickDT'     AS FTXthDocKey,
                    DT.FTPdtCode,
                    DT.FTXsdPdtName,
                    DT.FTPunCode,
                    DT.FTPunName,
                    DT.FCXsdFactor,
                    DT.FTXsdBarCode,
                    0                   AS FCXtdQty,
                    0                   AS FCXtdQtyAll,
                    ''                  AS FTXpdStaPrcStk,
                    ''                  AS FTPdtStaAlwDis,
                    0                   AS FNXpdPdtLevel,
                    ''                  AS FTXpdPdtParent,
                    ''                  AS FTPdtStaSet,
                    ''                  AS FTXpdRmk,
                    $nQTYOrd            AS FCXtdQtyOrd,
                    CONVERT(VARCHAR,'".$this->session->userdata('tSesSessionID')."') AS FTSessionID,
                    CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDLastUpdOn,
                    CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn,
                    CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTLastUpdBy,
                    CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTCreateBy
                FROM
                    TARTSoDT DT WITH (NOLOCK)
                --LEFT JOIN TCNTDocDTTmp DOCTMP ON DT.FTPdtCode = DOCTMP.FTPdtCode AND DT.FTPunCode =  DOCTMP.FTPunCode AND DT.FTXsdBarCode = DOCTMP.FTXtdBarCode AND DOCTMP.FTXthDocKey = 'TCNTPdtPickDT' AND DOCTMP.FTSessionID = '".$this->session->userdata('tSesSessionID')."'
                WHERE  DT.FTBchCode = '$tRefIntBchCode' AND DT.FTXshDocNo ='$tRefIntDocNo' AND DT.FNXsdSeqNo IN $aSeqNo ";
        $oQuery = $this->db->query($tSQL);
        if($this->db->affected_rows() > 0){
            $aResult = array(
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        return $aResult;

    }
    
    // [เอกสารอ้างอิง] นำข้อมูลจากใบจ่ายโอน - สาขา ลง DTTemp
    public function FSoMPAMCallRefIntDocInsert_TBO_DTToTemp($paData){
        
        $tPAMDocNo          = $paData['tPAMDocNo'];
        $tPAMFrmBchCode     = $paData['tPAMFrmBchCode'];
        $tRefIntDocNo       = $paData['tRefIntDocNo'];
        $tRefIntBchCode     = $paData['tRefIntBchCode'];
        $tInsertOrUpdateRow = $paData['tInsertOrUpdateRow'];
        $aSeqNo             = '(' . implode(',', $paData['aSeqNo']) .')';

        if($tInsertOrUpdateRow == 1){ //บวก QTY
            // $nQTY       = "DT.FCXtdQty" .'+'. "ISNULL(DOCTMP.FCXtdQty,0)";
            // $nQTYAll    = "DT.FCXtdQtyAll" .'+'. "ISNULL(DOCTMP.FCXtdQtyAll,0)";
            // $nQTYOrd    = "DT.FCXtdQty" .'+'. "ISNULL(DOCTMP.FCXtdQty,0)";
            $nQTY       = "DT.FCXtdQty";
            $nQTYAll    = "DT.FCXtdQtyAll";
            $nQTYOrd    = "DT.FCXtdQty";
        }else{ //ขึ้น row ใหม่
            $nQTY       = "DT.FCXtdQty";
            $nQTYAll    = "DT.FCXtdQtyAll";
            $nQTYOrd    = "DT.FCXtdQty";
        }

        $tSQL= "INSERT INTO TCNTDocDTTmp (
                FTBchCode,FTXthDocNo,FNXtdSeqNo,FTXthDocKey,FTPdtCode,FTXtdPdtName,FTPunCode,FTPunName,FCXtdFactor,FTXtdBarCode,
                FCXtdQty,FCXtdQtyAll,FTXtdStaPrcStk,FTXtdStaAlwDis,FNXtdPdtLevel,FTXtdPdtParent,
                FTXtdPdtStaSet,FTXtdRmk,FCXtdQtyOrd,FTSessionID,FDLastUpdOn,FDCreateOn,FTLastUpdBy,FTCreateBy )
                SELECT
                    '$tPAMFrmBchCode'   AS FTBchCode,
                    '$tPAMDocNo'        AS FTXthDocNo,
                    DT.FNXtdSeqNo,
                    'TCNTPdtPickDT'     AS FTXthDocKey,
                    DT.FTPdtCode,
                    DT.FTXtdPdtName,
                    DT.FTPunCode,
                    DT.FTPunName,
                    DT.FCXtdFactor,
                    DT.FTXtdBarCode,
                    0                   AS FCXtdQty,
                    0                   AS FCXtdQtyAll,
                    ''                  AS FTXpdStaPrcStk,
                    ''                  AS FTPdtStaAlwDis,
                    0                   AS FNXpdPdtLevel,
                    ''                  AS FTXpdPdtParent,
                    ''                  AS FTPdtStaSet,
                    ''                  AS FTXpdRmk,
                    $nQTYOrd            AS FCXtdQtyOrd,
                    CONVERT(VARCHAR,'".$this->session->userdata('tSesSessionID')."') AS FTSessionID,
                    CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDLastUpdOn,
                    CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn,
                    CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTLastUpdBy,
                    CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTCreateBy
                FROM
                    TCNTPdtTboDT DT WITH (NOLOCK)
                --LEFT JOIN TCNTDocDTTmp DOCTMP ON DT.FTPdtCode = DOCTMP.FTPdtCode AND DT.FTPunCode =  DOCTMP.FTPunCode AND DT.FTXsdBarCode = DOCTMP.FTXtdBarCode AND DOCTMP.FTXthDocKey = 'TCNTPdtPickDT' AND DOCTMP.FTSessionID = '".$this->session->userdata('tSesSessionID')."'
                WHERE  DT.FTBchCode = '$tRefIntBchCode' AND  DT.FTXthDocNo ='$tRefIntDocNo' AND DT.FNXtdSeqNo IN $aSeqNo ";

        $oQuery = $this->db->query($tSQL);
        if($this->db->affected_rows() > 0){
            $aResult = array(
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        return $aResult;

    }

    // [เอกสารอ้างอิง] เพิ่ม
    public function FSaMPAMAddEditHDRefTmp($paDataWhere,$paDataAddEdit){

        $tRefDocNo = $paDataAddEdit['FTXthRefDocNo'];
        $tSQL = " SELECT FTXthRefDocNo FROM TCNTDocHDRefTmp
                  WHERE FTXthDocNo    = '".$paDataWhere['FTXthDocNo']."'
                    AND FTXthDocKey   = '".$paDataWhere['FTXthDocKey']."'
                    AND FTSessionID   = '".$paDataWhere['FTSessionID']."'
                    AND FTXthRefDocNo = '".$tRefDocNo."' ";
        $oQuery = $this->db->query($tSQL);
        $this->db->trans_begin();
        if ( $oQuery->num_rows() > 0 ){
            $this->db->where('FTXthRefDocNo',$tRefDocNo);
            $this->db->where('FTXthDocNo',$paDataWhere['FTXthDocNo']);
            $this->db->where('FTXthDocKey',$paDataWhere['FTXthDocKey']);
            $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
            $this->db->update('TCNTDocHDRefTmp',$paDataAddEdit);
        }else{
            $aDataAdd = array_merge($paDataAddEdit,array(
                'FTXthDocNo'  => $paDataWhere['FTXthDocNo'],
                'FTXthDocKey' => $paDataWhere['FTXthDocKey'],
                'FTSessionID' => $paDataWhere['FTSessionID'],
                'FDCreateOn'  => $paDataWhere['FDCreateOn'],
            ));
            $this->db->insert('TCNTDocHDRefTmp',$aDataAdd);
        }

        if ( $this->db->trans_status() === FALSE ) {
            $this->db->trans_rollback();
            $aResult = array(
                'nStaEvent' => '800',
                'tStaMessg' => 'Add/Edit HDDocRef Error'
            );
        } else {
            $this->db->trans_commit();
            $aResult = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Add/Edit HDDocRef Success'
            );
        }
        return $aResult;
    }

    // [เอกสารอ้างอิง] ลบ
    public function FSaMPAMDelHDDocRef($paData){
        $tDocNo       = $paData['FTXshDocNo'];
        $tRefDocNo    = $paData['FTXshRefDocNo'];
        $tDocKey      = $paData['FTXshDocKey'];
        $tSessionID   = $paData['FTSessionID'];

        $this->db->where('FTSessionID',$tSessionID);
        $this->db->where('FTXthDocKey',$tDocKey);
        $this->db->where('FTXthRefDocNo',$tRefDocNo);
        $this->db->where('FTXthDocNo',$tDocNo);
        $this->db->delete('TCNTDocHDRefTmp');

        if ( $this->db->trans_status() === FALSE ) {
            $this->db->trans_rollback();
            $aResult = array(
                'nStaEvent' => '800',
                'tStaMessg' => 'Delete HD Doc Ref Error'
            );
        } else {
            $this->db->trans_commit();
            $aResult = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Delete HD Doc Ref Success'
            );
        }
        return $aResult;
    }

    // เช็คว่ามีใน DT เเล้วหรือยัง
    public function FSnMPAMChkPdtInDocDTTemp($paDataWhere){
        $tPAMDocNo       = $paDataWhere['FTXthDocNo'];
        $tPAMDocKey      = $paDataWhere['FTXthDocKey'];
        $tPAMSessionID   = $paDataWhere['FTSessionID'];
        $tSQL           = " SELECT
                                COUNT(FNXtdSeqNo) AS nCountPdt
                            FROM TCNTDocDTTmp DocDT WITH(NOLOCK)
                            WHERE DocDT.FTXthDocKey   = '$tPAMDocKey'
                              AND DocDT.FTSessionID   = '$tPAMSessionID' ";
        if(isset($tPAMDocNo) && !empty($tPAMDocNo)){
            $tSQL   .=  " AND ISNULL(DocDT.FTXthDocNo,'')  = '$tPAMDocNo' ";
        }
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataQuery = $oQuery->row_array();
            return $aDataQuery['nCountPdt'];
        }else{
            return 0;
        }
    }

    // ย้ายข้อมูลจาก TempHDDocRef => ตารางจริง
    public function FSxMPCKMoveHDRefTmpToHDRef($paDataWhere){
        $tBchCode     = $paDataWhere['FTBchCode'];
        $tDocNo       = $paDataWhere['FTXthDocNo'];
        $tSessionID   = $this->session->userdata('tSesSessionID');
        $tTableHD     = 'TCNTPdtPickHD';

        // [จัดการใบจัดสินค้า]
        if (isset($tDocNo) && !empty($tDocNo)) {
            $this->db->where('FTBchCode', $tBchCode);
            $this->db->where('FTXthDocNo', $tDocNo);
            $this->db->delete('TCNTPdtPickHDDocRef');
        }

        //Insert HDDocRef ในตารางใบจัดสินค้า
        $tSQL   =   "   INSERT INTO TCNTPdtPickHDDocRef (FTAgnCode, FTBchCode, FTXthDocNo, FTXthRefDocNo, FTXthRefType, FTXthRefKey, FDXthRefDocDate) ";
        $tSQL   .=  "   SELECT
                            '".$this->session->userdata("tSesUsrAgnCode")."' AS FTAgnCode,
                            '$tBchCode' AS FTBchCode,
                            FTXthDocNo,
                            FTXthRefDocNo,
                            FTXthRefType,
                            FTXthRefKey,
                            FDXthRefDocDate
                        FROM TCNTDocHDRefTmp WITH (NOLOCK)
                        WHERE FTXthDocNo  = '$tDocNo'
                          AND FTXthDocKey = '".$tTableHD."'
                          AND FTSessionID = '$tSessionID' ";
        $this->db->query($tSQL);

        //Insert ใบสั่งขาย
        $this->db->where('FTBchCode',$tBchCode);
        $this->db->where('FTXshRefDocNo',$tDocNo);
        $this->db->delete('TARTSoHDDocRef');
        $tSQL   =   "   INSERT INTO TARTSoHDDocRef (FTAgnCode , FTBchCode, FTXshDocNo, FTXshRefDocNo, FTXshRefType, FTXshRefKey, FDXshRefDocDate) ";
        $tSQL   .=  "   SELECT
                            '".$this->session->userdata("tSesUsrAgnCode")."' AS FTAgnCode,
                            '$tBchCode' AS FTBchCode,
                            FTXthRefDocNo AS FTXshDocNo,
                            FTXthDocNo AS FTXshRefDocNo,
                            2,
                            'PCK',
                            FDXthRefDocDate
                        FROM TCNTDocHDRefTmp WITH (NOLOCK)
                        WHERE FTXthDocNo  = '$tDocNo'
                          AND FTXthDocKey = '".$tTableHD."'
                          AND FTSessionID = '$tSessionID'
                          AND FTXthRefKey = 'SO'  ";
        $this->db->query($tSQL);

        //Insert ใบจ่ายโอน - สาขา (ยังไม่มีตารางนี้)
            // $this->db->where('FTBchCode',$tBchCode);
            // $this->db->where('FTXshRefDocNo',$tDocNo);
            // $this->db->delete('TSVTJob2OrdHDDocRef');
            // $tSQL   =   "   INSERT INTO TSVTJob2OrdHDDocRef (FTAgnCode, FTBchCode, FTXshDocNo, FTXshRefDocNo, FTXshRefType, FTXshRefKey, FDXshRefDocDate) ";
            // $tSQL   .=  "   SELECT
            //                     '' AS FTAgnCode,
            //                     '$tBchCode' AS FTBchCode,
            //                     FTXthRefDocNo AS FTXshDocNo,
            //                     FTXthDocNo AS FTXshRefDocNo,
            //                     2,
            //                     'QT',
            //                     FDXthRefDocDate
            //                 FROM TCNTDocHDRefTmp WITH (NOLOCK)
            //                 WHERE FTXthDocNo  = '$tDocNo'
            //                   AND FTXthDocKey = '".$paTableAddUpdate['tTableHD']."'
            //                   AND FTSessionID = '$tSessionID'
            //                   AND FTXthRefKey = 'Job2Ord' ";
            // $this->db->query($tSQL);
    }

    // เพิ่ม - แก้ไขข้อมูล TCNTPdtPickHD => ตารางจริง
    public function FSxMPAMAddUpdateHD($paDataMaster,$paDataWhere,$paTableAddUpdate){
        $aDataGetDataHD     =   $this->FSaMPAMGetDataDocHD(array(
            'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
            'FNLngID'       => $this->session->userdata("tLangEdit")
        ));

        $aDataAddUpdateHD   = array();
        if(isset($aDataGetDataHD['rtCode']) && $aDataGetDataHD['rtCode'] == 1){
            $aDataAddUpdateHD   = array_merge($paDataMaster,array(
                'FDLastUpdOn'   => $paDataWhere['FDLastUpdOn'],
                'FTLastUpdBy'   => $paDataWhere['FTLastUpdBy'],
            ));

            // update HD
            $this->db->where('FTAgnCode',$paDataWhere['FTAgnCode']);
            $this->db->where('FTBchCode',$paDataWhere['FTBchCode']);
            $this->db->where('FTXthDocNo',$paDataWhere['FTXthDocNo']);
            $this->db->update($paTableAddUpdate['tTableHD'], $aDataAddUpdateHD);
        }else{
            $aDataAddUpdateHD   = array_merge($paDataMaster,array(
                'FTBchCode'     => $paDataWhere['FTBchCode'],
                'FTXshBchTo'    => $paDataWhere['FTXshBchTo'],
                'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
                'FDCreateOn'    => $paDataWhere['FDCreateOn'],
                'FTCreateBy'    => $paDataWhere['FTCreateBy'],
            ));
            // Insert HD
            $this->db->insert($paTableAddUpdate['tTableHD'],$aDataAddUpdateHD);
        }

        return;
    }

    // อัพเดทเลขที่เอกสาร  TCNTDocDTTmp , TCNTDocHDDisTmp , TCNTDocDTDisTmp => ตารางจริง
    public function FSxMPAMAddUpdateDocNoToTemp($paDataWhere,$paTableAddUpdate){
        // Update DocNo Into DTTemp
        $this->db->where('FTXthDocNo','');
        $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
        $this->db->where('FTXthDocKey',$paTableAddUpdate['tTableDT']);
        $this->db->update('TCNTDocDTTmp',array(
            'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
            'FTBchCode'     => $paDataWhere['FTBchCode']
        ));

        // Update DocNo Into DTTemp
        $this->db->where('FTXthDocNo','');
        $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
        $this->db->where('FTXthDocKey','TCNTPdtPickHD');
        $this->db->update('TCNTDocHDRefTmp',array(
            'FTXthDocNo'    => $paDataWhere['FTXthDocNo']
        ));
        return;
    }

    // เพิ่ม - แก้ไขข้อมูล TCNTPdtPickDT => ตารางจริง
    public function FSaMPAMMoveDtTmpToDt($paDataWhere,$paTableAddUpdate){
        $tPAMBchCode     = $paDataWhere['FTBchCode'];
        $tPAMDocNo       = $paDataWhere['FTXthDocNo'];
        $tPAMDocKey      = $paTableAddUpdate['tTableDT'];
        $tPAMSessionID   = $paDataWhere['FTSessionID'];

        if(isset($tPAMDocNo) && !empty($tPAMDocNo)){
            $this->db->where_in('FTXthDocNo',$tPAMDocNo);
            $this->db->delete($paTableAddUpdate['tTableDT']);
        }

        $tSQL   = " INSERT INTO ".$paTableAddUpdate['tTableDT']." ( FTAgnCode,FTBchCode,FTXthDocNo,FNXtdSeqNo,FTPdtCode,
                        FTXtdPdtName,FTPunCode,FTPunName,FCXtdFactor,FTXtdBarCode,FCXtdQty,FCXtdQtyAll,
                        FTXtdStaPrcStk,FTXtdStaAlwDis,FTPdtStaSet,
                        FTXtdRmk,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy,FCXtdQtyOrd ) ";
        $tSQL   .=  "   SELECT
                            '' AS FTAgnCode,
                            PAMCTMP.FTBchCode,
                            PAMCTMP.FTXthDocNo,
                            ROW_NUMBER() OVER(ORDER BY PAMCTMP.FNXtdSeqNo ASC) AS FNXtdSeqNo,
                            PAMCTMP.FTPdtCode,
                            PAMCTMP.FTXtdPdtName,
                            PAMCTMP.FTPunCode,
                            PAMCTMP.FTPunName,
                            PAMCTMP.FCXtdFactor,
                            PAMCTMP.FTXtdBarCode,
                            PAMCTMP.FCXtdQty,
                            PAMCTMP.FCXtdQtyAll,
                            PAMCTMP.FTXtdStaPrcStk,
                            PAMCTMP.FTXtdStaAlwDis,
                            PAMCTMP.FTXtdPdtStaSet,
                            PAMCTMP.FTXtdRmk,
                            PAMCTMP.FDLastUpdOn,
                            PAMCTMP.FTLastUpdBy,
                            PAMCTMP.FDCreateOn,
                            PAMCTMP.FTCreateBy,
                            PAMCTMP.FCXtdQtyOrd
                        FROM TCNTDocDTTmp PAMCTMP WITH (NOLOCK)
                        WHERE PAMCTMP.FTBchCode    = '$tPAMBchCode'
                          AND PAMCTMP.FTXthDocNo   = '$tPAMDocNo'
                          AND PAMCTMP.FTXthDocKey  = '$tPAMDocKey'
                          AND PAMCTMP.FTSessionID  = '$tPAMSessionID'
                        ORDER BY PAMCTMP.FNXtdSeqNo ASC ";
        $this->db->query($tSQL);
        return;
    }

    // ข้อมูล HD
    public function FSaMPAMGetDataDocHD($paDataWhere){
        $tPAMDocNo  = $paDataWhere['FTXthDocNo'];
        $nLngID     = $this->session->userdata("tLangEdit");
        $tSQL       = " SELECT
                            PAMCHD.FTXthDocNo,
                            PAMCHD.FDXthDocDate,
                            PAMCHD.FTXthStaDoc,
                            PAMCHD.FTXthStaApv,
                            PAMCHD.FTDptCode,
                            PAMCHD.FTXthApvCode,
                            PAMCHD.FNXthStaRef,
                            PAMCHD.FTWahCode,
                            PAMCHD.FNXthStaDocAct,
                            PAMCHD.FNXthDocPrint,
                            PAMCHD.FTXthRmk,
                            PAMCHD.FNXthStaDocAct,
                            PAMCHD.FDCreateOn   AS DateOn,
                            PAMCHD.FTCreateBy   AS CreateBy,
                            PAMCHD.FTBchCode,
                            BCH1_L.FTBchName,
                            PAMCHD.FTXshBchTo,
                            BCH2_L.FTBchName    AS FTXshBchNameTo,
                            DPTL.FTDptName,
                            USRL.FTUsrName      AS FTCreateBy,
                            USRL.FTUsrName      AS FTUsrName,
                            USRAPV.FTUsrName	AS FTXthApvName,
                            AGN.FTAgnCode       AS rtAgnCode,
                            AGN.FTAgnName       AS rtAgnName,
                            PAMCHD.FTPlcCode,
                            PLC_L.FTPlcName,
                            ISNULL(PAMCHD.FTXthStaDocAuto,'1') AS FTXthStaDocAuto,
                            PAMCHD.FTXthCat1 AS FTCat1Code,
                            CAT1_L.FTCatName AS FTCat1Name,
                            PAMCHD.FTXthCat2 AS FTCat2Code,
                            CAT2_L.FTCatName AS FTCat2Name,
                            PAMCHD.FNXthDocType
                        FROM TCNTPdtPickHD          PAMCHD  WITH (NOLOCK)
                        LEFT JOIN TCNMBranch_L      BCH1_L    WITH (NOLOCK)   ON PAMCHD.FTBchCode     = BCH1_L.FTBchCode  AND BCH1_L.FNLngID	= $nLngID
                        LEFT JOIN TCNMBranch_L      BCH2_L    WITH (NOLOCK)   ON PAMCHD.FTXshBchTo    = BCH2_L.FTBchCode  AND BCH2_L.FNLngID	= $nLngID
                        LEFT JOIN TCNMAgency_L      AGN     WITH (NOLOCK)   ON PAMCHD.FTAgnCode       = AGN.FTAgnCode     AND AGN.FNLngID	    = $nLngID
                        LEFT JOIN TCNMUsrDepart_L	DPTL    WITH (NOLOCK)   ON PAMCHD.FTDptCode       = DPTL.FTDptCode	  AND DPTL.FNLngID	    = $nLngID
                        LEFT JOIN TCNMUser_L        USRL    WITH (NOLOCK)   ON PAMCHD.FTUsrCode       = USRL.FTUsrCode	  AND USRL.FNLngID	    = $nLngID
                        LEFT JOIN TCNMUser_L        USRAPV	WITH (NOLOCK)   ON PAMCHD.FTXthApvCode	  = USRAPV.FTUsrCode  AND USRAPV.FNLngID	= $nLngID
                        LEFT JOIN TCNMPdtLoc_L      PLC_L   WITH (NOLOCK)   ON PAMCHD.FTPlcCode       = PLC_L.FTPlcCode   AND PLC_L.FNLngID	    = $nLngID
                        LEFT JOIN TCNMPdtCatInfo_L  CAT1_L  WITH (NOLOCK)   ON PAMCHD.FTXthCat1       = CAT1_L.FTCatCode  AND CAT1_L.FNCatLevel = 1 AND CAT1_L.FNLngID = $nLngID
                        LEFT JOIN TCNMPdtCatInfo_L  CAT2_L  WITH (NOLOCK)   ON PAMCHD.FTXthCat2       = CAT2_L.FTCatCode  AND CAT2_L.FNCatLevel = 2 AND CAT2_L.FNLngID = $nLngID
                        WHERE PAMCHD.FTXthDocNo = '$tPAMDocNo' ";

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

    // ย้ายจาก DT To Temp
    public function FSxMPAMMoveDTToDTTemp($paDataWhere){
        $tPAMDocNo       = $paDataWhere['FTXthDocNo'];
        $tDocKey        = $paDataWhere['FTXthDocKey'];

        // Delect Document DTTemp By Doc No
        $this->db->where('FTXthDocNo',$tPAMDocNo);
        $this->db->delete('TCNTDocDTTmp');

        $tSQL   = " INSERT INTO TCNTDocDTTmp (
                        FTBchCode,FTXthDocNo,FNXtdSeqNo,FTXthDocKey,FTPdtCode,FTXtdPdtName,FTPunCode,FTPunName,FCXtdFactor,FTXtdBarCode,
                        FCXtdQty,FCXtdQtyAll,FTXtdStaPrcStk,FTXtdStaAlwDis,
                        FTXtdPdtStaSet,FTXtdRmk,FTSessionID,FDLastUpdOn,FDCreateOn,FTLastUpdBy,FTCreateBy,FTXtdPdtSetOrSN,FCXtdQtyOrd )
                    SELECT
                        DT.FTBchCode,
                        DT.FTXthDocNo,
                        DT.FNXtdSeqNo,
                        CONVERT(VARCHAR,'".$tDocKey."') AS FTXthDocKey,
                        DT.FTPdtCode,
                        DT.FTXtdPdtName,
                        DT.FTPunCode,
                        DT.FTPunName,
                        DT.FCXtdFactor,
                        DT.FTXtdBarCode,
                        DT.FCXtdQty,
                        DT.FCXtdQtyAll,
                        DT.FTXtdStaPrcStk,
                        DT.FTXtdStaAlwDis,
                        DT.FTPdtStaSet,
                        DT.FTXtdRmk,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesSessionID')."') AS FTSessionID,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDLastUpdOn,
                        CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTLastUpdBy,
                        CONVERT(VARCHAR,'".$this->session->userdata('tSesUsername')."') AS FTCreateBy,
                        ISNULL(PDT.FTPdtSetOrSN,'1') AS FTPdtSetOrSN,
                        DT.FCXtdQtyOrd
                    FROM TCNTPdtPickDT DT WITH(NOLOCK)
                    LEFT JOIN TCNMPdt PDT WITH(NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
                    WHERE DT.FTXthDocNo = '$tPAMDocNo'
                    ORDER BY DT.FNXtdSeqNo ASC ";
        $this->db->query($tSQL);
        return;
    }

    // ย้ายจาก HDDocRef To Temp
    public function FSxMPAMMoveHDRefToHDRefTemp($paData){

        $tDocNo     = $paData['FTXthDocNo'];
        $tSessionID = $this->session->userdata('tSesSessionID');
        $tSQL       = " INSERT INTO TCNTDocHDRefTmp (FTXthDocNo, FTXthRefDocNo, FTXthRefType, FTXthRefKey, FDXthRefDocDate, FTXthDocKey, FTSessionID , FDCreateOn)";
        $tSQL      .= " SELECT
                          FTXthDocNo,
                          FTXthRefDocNo,
                          FTXthRefType,
                          FTXthRefKey,
                          FDXthRefDocDate,
                          'TCNTPdtPickHD' AS FTXthDocKey,
                          '$tSessionID'  AS FTSessionID,
                          CONVERT(DATETIME,'".date('Y-m-d H:i:s')."') AS FDCreateOn
                      FROM TCNTPdtPickHDDocRef WITH(NOLOCK)
                      WHERE FTXthDocNo = '$tDocNo' ";
        $this->db->query($tSQL);

    }

    // อนุมัตเอกสาร
    public function FSxMPAMApproveDocument($paDataUpdate){
        $this->db->set('FDLastUpdOn',$paDataUpdate['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy',$paDataUpdate['FTXthUsrApv']);
        $this->db->set('FTXthStaApv',$paDataUpdate['FTXthStaApv']);
        $this->db->set('FTXthApvCode',$paDataUpdate['FTXthUsrApv']);
        $this->db->where('FTBchCode',$paDataUpdate['FTBchCode']);
        $this->db->where('FTXthDocNo',$paDataUpdate['FTXthDocNo']);
        $this->db->update('TCNTPdtPickHD');

        //วิ่งไปหาว่าใบจัดนี้ อ้างอิง SO และอัพเดทสถานะที่ SO
        $this->FSxMPAMRelationSO($paDataUpdate['FTXthDocNo']);
    }

    // ยกเลิกเอกสาร
    public function FSxMPAMCancelDocument($paData){

        //อัพเดทให้ เป็นยกเลิก
        $this->db->set('FDLastUpdOn',$paData['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy',$paData['FTLastUpdBy']);
        $this->db->set('FTXthStaDoc',3); //ยกเลิก
        $this->db->where('FTXthDocNo',$paData['tDocNo']);
        $this->db->update('TCNTPdtPickHD');

        //อัพเดทในส่วนเอกสารอ้างอิง
        if($paData['tDocType'] == '11' ){ //ใบจัดสินค้าให้ลูกค้า - อ้างใบจ่ายโอนสาขา
            
        }else if($paData['tDocType'] == '13' ){ //ใบจัดสินค้าให้สาขา - อ้างใบสั่งขาย
            
            //วิ่งไปหาว่าใบจัดนี้ อ้างอิง SO และอัพเดทสถานะที่ SO
            $this->FSxMPAMRelationSO($paData['tDocNo']);

            //ลบการอ้างอิงออก SO
            $this->db->where('FTXshRefDocNo',$paData['tDocNo']);
            $this->db->delete('TARTSoHDDocRef');
        }

        //ลบการอ้างอิงออก PICK
        $this->db->where('FTXthDocNo',$paData['tDocNo']);
        $this->db->delete('TCNTPdtPickHDDocRef');
    }

    //วิ่งไปหาว่าใบจัดนี้ อ้างอิง SO มากกว่ากี่ใบ
    public function FSxMPAMRelationSO($ptPICKDocNo){
        $tSQL = "   SELECT COUNT(HD.FTXthDocNo) AS FNCountWDocApv
                    FROM TCNTPdtPickHDDocRef HDR
                    INNER JOIN TCNTPdtPickHD HD ON HD.FTXthDocNo = HDR.FTXthDocNo
                    WHERE FTXthRefDocNo IN ( SELECT DISTINCT FTXthRefDocNo FROM TCNTPdtPickHDDocRef WHERE FTXthDocNo = '".$ptPICKDocNo."' )
                    AND HD.FTXthDocNo <> '".$ptPICKDocNo."'
                    AND ISNULL(HD.FTXthStaApv,'') = '' ";
        $oQuery = $this->db->query($tSQL);
        $aItems = $oQuery->result_array();

        //ถ้าไม่มี ใบจัดค้าง ค้างจะไปอัพเดท SO ว่า 
        if($aItems[0]['FNCountWDocApv'] == 0){
            //จัดครบแล้วรออนุมัติ
            $nStaPrc = 7;
        }else{
            //จัดแล้วบางส่วน
            $nStaPrc = 6;
        }

        //อัพเดท Staprc
        $tSQL   = " UPDATE TARTSoHD WITH(ROWLOCK)
                SET FTXshStaPrcDoc = '$nStaPrc' 
                FROM TARTSoHD HD 
                INNER JOIN (
                    SELECT DISTINCT FTXthRefDocNo FROM TCNTPdtPickHDDocRef WHERE FTXthDocNo = '".$ptPICKDocNo."'
                ) REF ON REF.FTXthRefDocNo = HD.FTXshDocNo ";
        $this->db->query($tSQL);
    }

    // ลบเอกสาร HD
    public function FSnMPAMDelDocument($paDataDoc){
        $tDataDocNo = $paDataDoc['tDataDocNo'];
        $tBchCode   = $paDataDoc['tBchCode'];
        $this->db->trans_begin();

        // HD
        $this->db->where('FTXthDocNo',$tDataDocNo);
        $this->db->where('FTBchCode',$tBchCode);
        $this->db->delete('TCNTPdtPickHD');

        // DT
        $this->db->where('FTXthDocNo',$tDataDocNo);
        $this->db->where('FTBchCode',$tBchCode);
        $this->db->delete('TCNTPdtPickDT');

        // DT SN
        $this->db->where('FTXthDocNo',$tDataDocNo);
        $this->db->where('FTBchCode',$tBchCode);
        $this->db->delete('TCNTPdtPickDTSN');

        // HD DocRef
        $this->db->where('FTXthDocNo',$tDataDocNo);
        $this->db->delete('TCNTPdtPickHDDocRef');

        // ลบอ้างอิง ใบสั่งขาย
        $this->db->where('FTXshRefDocNo',$tDataDocNo);
        $this->db->delete('TARTSoHDDocRef');

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $aStaDelDoc     = array(
                'rtCode'    => '905',
                'rtDesc'    => 'Cannot Delete Item.',
            );
        }else{
            $this->db->trans_commit();
            $aStaDelDoc     = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Delete Complete.',
            );
        }
        return $aStaDelDoc;
    }

    //อัพเดทหมายเหตุถ้าเอกสารอนุมัติแล้ว
    public function FSaMPAMUpdateRmk($paDataUpdate){
        $dLastUpdOn = date('Y-m-d H:i:s');
        $tLastUpdBy = $this->session->userdata('tSesUsername');

        $this->db->set('FDLastUpdOn',$dLastUpdOn);
        $this->db->set('FTLastUpdBy',$tLastUpdBy);
        $this->db->set('FTXthRmk',$paDataUpdate['FTXthRmk']);
        $this->db->where('FTBchCode',$paDataUpdate['FTBchCode']);
        $this->db->where('FTXthDocNo',$paDataUpdate['FTXthDocNo']);
        $this->db->update('TCNTPdtPickHD');

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Updated Success.',
            );
        } else {
            $aStatus = array(
                'rtCode' => '903',
                'rtDesc' => 'Not Update.',
            );
        }
        return $aStatus;
    }

}
