<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Browserpdt_model extends CI_Model {

    //PDT
    public function FSnMGetProduct($paData){
        try{
            $tBchSession = $this->session->userdata("tSesUsrBchCode");
            $tShpSession = $this->session->userdata("tSesUsrShpCode");
            $tMerSession = $this->session->userdata("tSesUsrMerCode");

            // if($tBchSession == ''){
            //     echo 'USER HQ';
            // }else if($tBchSession != '' && $tShpSession == ''){
            //     echo 'USER BCH : BCHCODE -->' . $tBchSession . ' SHP -->' . $tShpSession;
            // }else if($tShpSession != ''){
            //     echo 'USER SHP : SHOPCODE -->' .  $tShpSession . ' MER -->' . $tMerSession;
            // }

            $aRowLen     = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID      = $paData['FNLngID'];
            $tSQL       = "";
            $tSelectTier = $paData['tSelectTier'];
            if($tSelectTier == 'Barcode'){
                $tSQL       = "SELECT c.* FROM(
                    SELECT  ROW_NUMBER() OVER(ORDER BY FTPdtCode ASC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        PDT.FTPdtCode,
                        PDT.FCPdtMin,
                        PDT.FCPdtMax,
                        PDT.FTPdtPoint,
                        PDT.FCPdtPointTime,
                        PDT.FTPdtType,
                        PDT.FTPdtSaleType,
                        PDT.FTPdtSetOrSN,
                        PDTL.FTPdtName,
                        PDTL.FTPdtRmk,
                        PBCH.FTShpCode,
                        PBCH.FTMerCode,
                        PBCH.FTMgpCode ,
                        PBCH.FTBchCode
                    FROM TCNMPdt PDT
                    LEFT JOIN TCNMPdtSpcBch PBCH    ON PDT.FTPdtCode = PBCH.FTPdtCode  
                    LEFT JOIN TCNMPdt_L PDTL        ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = $nLngID 
                    LEFT JOIN TCNMPdtBar BAR        ON BAR.FTPdtCode = PDT.FTPdtCode 
                    LEFT JOIN TCNMPdtSpl SPL        ON PDT.FTPdtCode = SPL.FTPdtCode AND BAR.FTBarCode = SPL.FTBarCode ";
            }else if($tSelectTier == 'PDT'){
                $tSQL       = "SELECT c.* FROM(
                    SELECT  ROW_NUMBER() OVER(ORDER BY FTPdtCode ASC) AS FNRowID,* FROM
                    (SELECT DISTINCT
                        PDT.FTPdtCode,
                        PDT.FCPdtMin,
                        PDT.FCPdtMax,
                        PDT.FTPdtPoint,
                        PDT.FCPdtPointTime,
                        PDT.FTPdtType,
                        PDT.FTPdtSaleType,
                        PDT.FTPdtSetOrSN,
                        PBCH.FTShpCode,
                        PBCH.FTMerCode,
                        PBCH.FTMgpCode,
                        PBCH.FTBchCode,
                        PDTL.FTPdtName,
                        PDTL.FTPdtRmk,
                        PAC.FTPunCode,
                        UNT.FTPunName,
                        ISNULL(P4PDT.FCPgdPriceRet,0) AS FCPgdPriceRet,
                        ISNULL(P4PDT.FCPgdPriceWhs,0) AS FCPgdPriceWhs,
                        ISNULL(P4PDT.FCPgdPriceNet,0) AS FCPgdPriceNet,
                        PDTIMG.FTImgObj,
                        PDAGE.FCPdtCookTime , 
                        PDAGE.FCPdtCookHeat
                    FROM TCNMPdt PDT
                    LEFT JOIN TCNMPdtSpcBch PBCH    ON PDT.FTPdtCode = PBCH.FTPdtCode  
                    LEFT JOIN TCNMPdt_L PDTL        ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = 1 
                    LEFT JOIN TCNMPdtPackSize PAC	ON PAC.FTPdtCode = PDT.FTPdtCode
                    LEFT JOIN TCNMPdtBar BAR        ON BAR.FTPdtCode = PDT.FTPdtCode 
                    LEFT JOIN TCNMPdtUnit_L UNT     ON UNT.FTPunCode = PAC.FTPunCode AND UNT.FNLngID = 1 
                    
                    LEFT JOIN TCNMPdtAge PDAGE   ON PDAGE.FTPdtCode  = PDT.FTPdtCode 
                    LEFT JOIN TCNMImgPdt  PDTIMG  ON PDT.FTPdtCode   = PDTIMG.FTImgRefID AND PDTIMG.FTImgTable = 'TCNMPdt' AND PDTIMG.FTImgKey = 'master' AND PDTIMG.FNImgSeq = '1'

                    LEFT JOIN TCNMPdtSpl SPL        ON PDT.FTPdtCode = SPL.FTPdtCode AND BAR.FTBarCode = SPL.FTBarCode 
                    LEFT JOIN TCNTPdtPrice4PDT P4PDT ON PDT.FTPdtCode = P4PDT.FTPdtCode AND P4PDT.FTPunCode  = PAC.FTPunCode
                    AND ( CONVERT(VARCHAR(10),GETDATE(),121) >= CONVERT(VARCHAR(10),P4PDT.FDPghDStart,121) ) AND  ( CONVERT(VARCHAR(10),GETDATE(),121) <= CONVERT(VARCHAR(10),P4PDT.FDPghDStop,121) )
                    AND P4PDT.FTPghDocType = 1 ";
            }
            
            //ที่เก็บ
            // $tPDTLOGSEQFrom   = $paData['tPDTLOGSEQ'][0]; 
            // $tPDTLOGSEQTo     = $paData['tPDTLOGSEQ'][1]; 
            $tPDTLOGSEQTo     = $paData['tPDTLOGSEQ']; 
            if ($tPDTLOGSEQTo != ''){
                $tSQL .= " LEFT JOIN TCNTPdtLocSeq LOCSEQ ON LOCSEQ.FTBarCode = BAR.FTPdtCode WHERE (LOCSEQ.FTPlcCode = '$tPDTLOGSEQTo') AND ";
            }else{
                $tSQL .= " WHERE ";
            }
            
            //สินค้าเคลื่อนไหว
            $nPDTMoveon = $paData['nPDTMoveon']; 
            if ($nPDTMoveon == 1){
                $tSQL .= " PDT.FTPdtStaActive = '1' ";
            }else if($nPDTMoveon == 2){
                $tSQL .= " PDT.FTPdtStaActive = '2' ";
            }

            //บาร์โค๊ด
            $tBarcode = $paData['tBarcode'];
            if ($tBarcode != ''){
                $tSQL .= " AND (BAR.FTBarcode LIKE '%$tBarcode%')";
            }

            //ชื่อสินค้า
            $tNamePDT = $paData['tNamePDT']; 
            if ($tNamePDT != ''){
                $tSQL .= " AND (PDTL.FTPdtName LIKE '%$tNamePDT%')";
            }

            //ผู้จัดซื้อ
            $tPurchasingManager = $paData['tPurchasingManager'];
            if ($tPurchasingManager != ''){
                $tSQL .= " AND (SPL.FTUsrCode = '$tPurchasingManager')";
            }

            //รหัสสินค้า
            $tCodePDT = $paData['tCodePDT']; 
            if ($tCodePDT != ''){
                $tSQL .= " AND (PDT.FTPdtCode = '$tCodePDT')";
            }

            //ตัวแทนจำหน่าย
            $tSPLCode = $paData['tSPLCode']; 
            if ($tSPLCode != ''){
                $tSQL .= " AND (SPL.FTSplCode = '$tSPLCode')";
            }

            //เงื่อนไขพิเศษ ตามหน้า
            $tPagename = $paData['tPagename'];
            if($tPagename == 'PI'){
                $tSQL .= " AND (PDT.FTPdtSetOrSN != 4)";
            }

            //กลุ่มร้านค้า
            $tMerchant = $paData['tMerchant']; 
            if ($tMerchant == '' || $tMerchant == null){
                // if($tMerSession != ''){
                //     $tSQL .= " AND (PBCH.FTMerCode = '$tMerSession')";
                // }
            }else{
                $tSQL .= " AND (PBCH.FTMerCode = '$tMerchant')";
            }
            
            //กลุ่มสินค้า ของ กลุ่มร้านค้า
            $tMerchantGroup = $paData['tMerchantGroup']; 
            if ($tMerchantGroup == '' || $tMerchantGroup == null){
                
            }else{
                $tSQL .= " AND (PBCH.FTMgpCode = '$tMerchantGroup')";
            }

            //สาขา
            $tBCHFrom   = $paData['aBCH'][0]; 
            $tBCHTo     = $paData['aBCH'][1]; 
            if ($tBCHFrom == '' &&  $tBCHTo == ''){
                //Check Session BCH
                if($tBchSession == '' || $tBchSession == null){
                    //$tSQL .= " AND (PBCH.FTBchCode != '')";
                }else if($tBchSession != '' && $tShpSession == ''){
                    $tSQL .= " AND (PBCH.FTBchCode = $tBchSession)";
                }
            }else{
                $tSQL .= " AND (PBCH.FTBchCode BETWEEN '$tBCHFrom' AND '$tBCHTo')";
            }

            //กลุ่มร้านค้า
            $tMCHFrom   = $paData['aMCH'][0]; 
            $tMCHTo     = $paData['aMCH'][1]; 
            if ($tMCHFrom != '' &&  $tMCHTo != ''){
                $tSQL .= " AND (PBCH.FTMerCode BETWEEN '$tMCHFrom' AND '$tMCHTo')";
            }


            //ร้านค้า
            $tSHPFrom   = $paData['aSHP'][0]; 
            $tSHPTo     = $paData['aSHP'][1]; 
            if ($tSHPFrom == '' &&  $tSHPTo == ''){
                //Check Session SHP
                if($tShpSession != '' || $tShpSession != null){
                    $tSQL .= " AND ( PBCH.FTShpCode = '$tShpSession' )";
                }
            }else{
                $tSQL .= " AND (PBCH.FTShpCode BETWEEN '$tSHPFrom' AND '$tSHPTo')";
            }

            //กลุ่มสินค้า
            $tPGPFrom   = $paData['aPGP'][0]; 
            $tPGPTo     = $paData['aPGP'][1]; 
            if ($tPGPFrom != '' &&  $tPGPTo != ''){
                $tSQL .= " AND (FTPgpChain BETWEEN '$tPGPFrom' AND '$tPGPTo')";
            }

            //ประเภท
            $tPTYFrom   = $paData['aPTY'][0]; 
            $tPTYTo     = $paData['aPTY'][1]; 
            if ($tPTYFrom != '' &&  $tPTYTo != ''){
                $tSQL .= " AND (FTPtyCode BETWEEN '$tPTYFrom' AND '$tPTYTo')";
            }

            //ไม่เอาสินค้าอะไรบ้าง NOT IN
            if($tSelectTier == 'PDT'){
                $aNotinItem = $paData['aNotinItem'];
                if($aNotinItem != '' || $aNotinItem != null){
                    $tNotinItem     = '';
                    $aNewNotinItem  = explode(',',$aNotinItem);

                    for($i=0; $i<count($aNewNotinItem); $i++){
                        $aNewPDT  = explode(':::',$aNewNotinItem[$i]);
                        $tNotinItem .=  "'".$aNewPDT[0]."'" . ',';
                        if($i == count($aNewNotinItem)-1){
                            $tNotinItem = substr($tNotinItem,0,-1);
                        }
                    }
                    $tSQL .= " AND (PDTL.FTPdtCode NOT IN ($tNotinItem))";
                }
            }

            //ถ้าเข้ามาแบบ shp ไม่ต้อง union
            if(count($tShpSession) == 0){

                //ถ้ามี SHP BCH ก็ UNION
                if($tBchSession == ''){ //เข้ามาแบบ HQ
                    if($tSHPFrom != '' &&  $tSHPTo != ''){
                        $tCanUnion = false;
                    }else if($tMerchant != ''){
                        $tCanUnion = false;
                    }else if($tBCHFrom != '' && $tBCHTo != ''){
                        $tCanUnion = true;
                    }else{
                        $tCanUnion = false;
                    }
                }

                if($tBchSession != '' && $tShpSession == ''){ //เข้ามาแบบ BCH
                    if($tSHPFrom != '' &&  $tSHPTo != ''){
                        $tCanUnion = false;
                    }else if($tMerchant != ''){
                        $tCanUnion = false;
                    }else if($tCodePDT != ''){
                        $tCanUnion = true;
                    }else{
                        $tCanUnion = true;
                    }
                }

                if ($tCanUnion == true){
                    if($tSelectTier == 'Barcode'){
                        $tSQL .= " UNION ALL ";
                        $tSQL .= " SELECT DISTINCT
                            PDT.FTPdtCode,
                            PDT.FCPdtMin,
                            PDT.FCPdtMax,
                            PDT.FTPdtPoint,
                            PDT.FCPdtPointTime,
                            PDT.FTPdtType,
                            PDT.FTPdtSaleType,
                            PDT.FTPdtSetOrSN,
                            PDTL.FTPdtName,
                            PDTL.FTPdtRmk,
                            PBCH.FTShpCode,
                            PBCH.FTMerCode,
                            PBCH.FTMgpCode,
                            PBCH.FTBchCode
                        FROM TCNMPdt PDT
                        LEFT JOIN TCNMPdtSpcBch PBCH    ON PDT.FTPdtCode = PBCH.FTPdtCode  
                        LEFT JOIN TCNMPdt_L PDTL        ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = $nLngID 
                        LEFT JOIN TCNMPdtBar BAR        ON BAR.FTPdtCode = PDT.FTPdtCode 
                        LEFT JOIN TCNMPdtSpl SPL        ON PDT.FTPdtCode = SPL.FTPdtCode AND BAR.FTBarCode = SPL.FTBarCode";

                        //สินค้าเคลื่อนไหว
                        $nPDTMoveon = $paData['nPDTMoveon']; 
                        if ($nPDTMoveon == 1){
                            $tSQL .= " WHERE PDT.FTPdtStaActive = '1' ";
                        }else if($nPDTMoveon == 2){
                            $tSQL .= " WHERE PDT.FTPdtStaActive = '2' ";
                        }

                        //บาร์โค๊ด
                        $tBarcode = $paData['tBarcode'];
                        if ($tBarcode != ''){
                            $tSQL .= " AND (BAR.FTBarcode LIKE '%$tBarcode%')";
                        }
                        
                        //รหัสสินค้า
                        $tCodePDT = $paData['tCodePDT']; 
                        if ($tCodePDT != ''){
                            $tSQL .= " AND (PDT.FTPdtCode = '$tCodePDT')";
                        }

                        //ชื่อสินค้า
                        $tNamePDT = $paData['tNamePDT']; 
                        if ($tNamePDT != ''){
                            $tSQL .= " AND (PDTL.FTPdtName LIKE '%$tNamePDT%')";
                        }

                        //ตัวแทนจำหน่าย
                        $tSPLCode = $paData['tSPLCode']; 
                        if ($tSPLCode != ''){
                            $tSQL .= " AND (SPL.FTSplCode = '$tSPLCode')";
                        }

                        //กลุ่มสินค้า ของ กลุ่มร้านค้า
                        $tMerchantGroup = $paData['tMerchantGroup']; 
                        if ($tMerchantGroup == ''){
                            
                        }else{
                            $tSQL .= " AND (PBCH.FTMgpCode = '$tMerchantGroup')";
                        }

                        if($tBchSession == '' || $tBchSession == null){
                            $tSQL .= " AND (ISNULL(PBCH.FTBchCode,'') = '' AND ISNULL(PBCH.FTMerCode,'') = '' AND ISNULL(PBCH.FTShpCode,'') = '' ) ";
                        }else{
                            $tSQL .= " AND ISNULL(PBCH.FTBchCode,'') = '' ";
                        }
                    }else if($tSelectTier == 'PDT'){
                        $tSQL .= " UNION ALL ";
                        $tSQL .= " SELECT DISTINCT
                            PDT.FTPdtCode,
                            PDT.FCPdtMin,
                            PDT.FCPdtMax,
                            PDT.FTPdtPoint,
                            PDT.FCPdtPointTime,
                            PDT.FTPdtType,
                            PDT.FTPdtSaleType,
                            PDT.FTPdtSetOrSN,
                            PBCH.FTMgpCode,
                            PBCH.FTShpCode,
                            PBCH.FTMerCode,
                            PBCH.FTBchCode,
                            PDTL.FTPdtName,
                            PDTL.FTPdtRmk,
                            PAC.FTPunCode,
                            UNT.FTPunName,
                            ISNULL(P4PDT.FCPgdPriceRet,0) AS FCPgdPriceRet,
                            ISNULL(P4PDT.FCPgdPriceWhs,0) AS FCPgdPriceWhs,
                            ISNULL(P4PDT.FCPgdPriceNet,0) AS FCPgdPriceNet,
                            PDTIMG.FTImgObj,
                            PDAGE.FCPdtCookTime , 
                            PDAGE.FCPdtCookHeat
                        FROM TCNMPdt PDT
                        LEFT JOIN TCNMPdtSpcBch PBCH    ON PDT.FTPdtCode = PBCH.FTPdtCode  
                        LEFT JOIN TCNMPdt_L PDTL        ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = 1 
                        LEFT JOIN TCNMPdtPackSize PAC	ON PAC.FTPdtCode = PDT.FTPdtCode
                        LEFT JOIN TCNMPdtBar BAR        ON BAR.FTPdtCode = PDT.FTPdtCode 
                        LEFT JOIN TCNMPdtUnit_L UNT     ON UNT.FTPunCode = PAC.FTPunCode AND UNT.FNLngID = 1 
                        LEFT JOIN TCNMPdtAge PDAGE   ON PDAGE.FTPdtCode  = PDT.FTPdtCode 
                        LEFT JOIN TCNMImgPdt  PDTIMG  ON PDT.FTPdtCode   = PDTIMG.FTImgRefID AND PDTIMG.FTImgTable = 'TCNMPdt' AND PDTIMG.FTImgKey = 'master' AND PDTIMG.FNImgSeq = '1'

                        LEFT JOIN TCNMPdtSpl SPL        ON PDT.FTPdtCode = SPL.FTPdtCode AND BAR.FTBarCode = SPL.FTBarCode 
                        LEFT JOIN TCNTPdtPrice4PDT P4PDT ON PDT.FTPdtCode = P4PDT.FTPdtCode AND P4PDT.FTPunCode = PAC.FTPunCode 
                        AND ((CONVERT(VARCHAR(10),GETDATE(),121) >= CONVERT(VARCHAR(10),P4PDT.FDPghDStart,121)) 
                        AND (CONVERT(VARCHAR(10),GETDATE(),121) <= CONVERT(VARCHAR(10),P4PDT.FDPghDStop,121))) 
                        AND P4PDT.FTPghDocType = 1 ";

                        //สินค้าเคลื่อนไหว
                        $nPDTMoveon = $paData['nPDTMoveon']; 
                        if ($nPDTMoveon == 1){
                            $tSQL .= " WHERE PDT.FTPdtStaActive = '1' AND (PDT.FTPdtSetOrSN != 4) ";
                        }else if($nPDTMoveon == 2){
                            $tSQL .= " WHERE PDT.FTPdtStaActive = '2' AND (PDT.FTPdtSetOrSN != 4) ";
                        }

                        //ชื่อสินค้า
                        $tNamePDT = $paData['tNamePDT']; 
                        if ($tNamePDT != ''){
                            $tSQL .= " AND (PDTL.FTPdtName LIKE '%$tNamePDT%')";
                        }

                        //รหัสสินค้า
                        $tCodePDT = $paData['tCodePDT']; 
                        if ($tCodePDT != ''){
                            $tSQL .= " AND (PDT.FTPdtCode = '$tCodePDT')";
                        }

                        //ตัวแทนจำหน่าย
                        $tSPLCode = $paData['tSPLCode']; 
                        if ($tSPLCode != ''){
                            $tSQL .= " AND (SPL.FTSplCode = '$tSPLCode')";
                        }

                        //กลุ่มสินค้า ของ กลุ่มร้านค้า
                        $tMerchantGroup = $paData['tMerchantGroup']; 
                        if ($tMerchantGroup == ''){
                            
                        }else{
                            $tSQL .= " AND (PBCH.FTMgpCode = '$tMerchantGroup')";
                        }
                        
                        if($tBchSession == '' || $tBchSession == null){
                            $tSQL .= " AND (ISNULL(PBCH.FTBchCode,'') = '' AND ISNULL(PBCH.FTMerCode,'') = '' AND ISNULL(PBCH.FTShpCode,'') = '' ) ";
                        }else if($tBchSession != '' && $tShpSession == ''){
                            $tSQL .= " AND (ISNULL(PBCH.FTBchCode,'') = '' AND ISNULL(PBCH.FTMerCode,'') = '' AND ISNULL(PBCH.FTShpCode,'') = '' )";
                        }
                    }
                }
            }

            $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList      = $oQuery->result_array();
                $oFoundRow  = $this->FSnMSPRGetPageAll($paData,$nLngID);
                $nFoundRow  = $oFoundRow[0]->counts;
                $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult    = array(
                    'raItems'       => $aList,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paData['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                    'sql'           => $tSQL
                );
            }else{
                //No Data
                $aResult    = array(
                    'rnAllRow'      => 0,
                    'rnCurrentPage' => $paData['nPage'],
                    "rnAllPage"     => 0,
                    'rtCode'        => '800',
                    'rtDesc'        => 'data not found',
                    'sql'           => $tSQL
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //count pdt สำหรับ pagenation
    public function FSnMSPRGetPageAll($paData, $ptLngID){
        $tSelectTier = $paData['tSelectTier'];

        if($tSelectTier == 'Barcode'){
            $tBchSession = $this->session->userdata("tSesUsrBchCode");
            $tShpSession = $this->session->userdata("tSesUsrShpCode");
            $tMerSession = $this->session->userdata("tSesUsrMerCode");

            $tSQL = "SELECT COUNT(Totalrecord.FTPdtCode) AS counts FROM (
                    SELECT DISTINCT(PDT.FTPdtCode) FROM TCNMPdt PDT
                    LEFT JOIN TCNMPdtSpcBch PBCH    ON PDT.FTPdtCode = PBCH.FTPdtCode  
                    LEFT JOIN TCNMPdt_L PDTL        ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = $ptLngID
                    LEFT JOIN TCNMPdtBar BAR        ON BAR.FTPdtCode = PDT.FTPdtCode
                    LEFT JOIN TCNMPdtSpl SPL        ON PDT.FTPdtCode = SPL.FTPdtCode AND BAR.FTBarCode = SPL.FTBarCode ";
          
            //ที่เก็บ
            $tPDTLOGSEQTo     = $paData['tPDTLOGSEQ']; 
            if ($tPDTLOGSEQTo != ''){
                $tSQL .= " LEFT JOIN TCNTPdtLocSeq LOCSEQ ON LOCSEQ.FTBarCode = BAR.FTPdtCode WHERE (LOCSEQ.FTPlcCode = '$tPDTLOGSEQTo') AND ";
            }else{
                $tSQL .= " WHERE ";
            }

            $nPDTMoveon = $paData['nPDTMoveon']; 
            if ($nPDTMoveon == 1){
                $tSQL .= " PDT.FTPdtStaActive = '1' ";
            }else if($nPDTMoveon == 2){
                $tSQL .= " PDT.FTPdtStaActive = '2' ";
            }

            $tBarcode = $paData['tBarcode'];
            if ($tBarcode != ''){
                $tSQL .= " AND (BAR.FTBarcode LIKE '%$tBarcode%')";
            }

            $tNamePDT = $paData['tNamePDT']; 
            if ($tNamePDT != ''){
                $tSQL .= " AND (PDTL.FTPdtName LIKE '%$tNamePDT%')";
            }

            $tPurchasingManager = $paData['tPurchasingManager'];
            if ($tPurchasingManager != ''){
                $tSQL .= " AND (SPL.FTUsrCode = '$tPurchasingManager')";
            }

            $tCodePDT = $paData['tCodePDT']; 
            if ($tCodePDT != ''){
                $tSQL .= " AND (PDT.FTPdtCode = '$tCodePDT')";
            }

            $tSPLCode = $paData['tSPLCode']; 
            if ($tSPLCode != ''){
                $tSQL .= " AND (SPL.FTSplCode LIKE '%$tSPLCode%')";
            }

            $tPagename = $paData['tPagename'];
            if($tPagename == 'PI'){
                $tSQL .= " AND (PDT.FTPdtSetOrSN != 4)";
            }

            $tMerchant = $paData['tMerchant']; 
            if ($tMerchant == ''){
                /*if($tMerSession != ''){
                    $tSQL .= " AND (PBCH.FTMerCode = '$tMerSession')";
                }*/
            }else{
                $tSQL .= " AND (PBCH.FTMerCode = '$tMerchant')";
            }

            //กลุ่มสินค้า ของ กลุ่มร้านค้า
            $tMerchantGroup = $paData['tMerchantGroup']; 
            if ($tMerchantGroup == ''){
                
            }else{
                $tSQL .= " AND (PBCH.FTMgpCode = '$tMerchantGroup')";
            }

            $tBCHFrom   = $paData['aBCH'][0]; 
            $tBCHTo     = $paData['aBCH'][1]; 
            if ($tBCHFrom == '' &&  $tBCHTo == ''){
                //Check Session BCH
                if($tBchSession == '' || $tBchSession == null){ //HQ
                    //$tSQL .= " AND (PBCH.FTBchCode != '')";
                }else if($tBchSession != '' && $tShpSession == ''){
                    $tSQL .= " AND (PBCH.FTBchCode = $tBchSession)";
                    // $tSQL .= " AND (PBCH.FTBchCode = $tBchSession AND ISNULL(PBCH.FTMerCode,'') = '' AND ISNULL(PBCH.FTShpCode,'') = '' )";
                }
            }else{
                $tSQL .= " AND (PBCH.FTBchCode BETWEEN '$tBCHFrom' AND '$tBCHTo')";
            }
            
            $tSHPFrom   = $paData['aSHP'][0]; 
            $tSHPTo     = $paData['aSHP'][1]; 
            if ($tSHPFrom == '' &&  $tSHPTo == ''){
                /*if($tShpSession != ''){
                    $tSQL .= " AND (PBCH.FTShpCode = '$tShpSession')";
                }*/
                 //Check Session SHP
                if($tShpSession != '' || $tShpSession != null){
                    $tSQL .= " AND ( PBCH.FTShpCode = '$tShpSession' )";
                }
            }else{
                $tSQL .= " AND (PBCH.FTShpCode BETWEEN '$tSHPFrom' AND '$tSHPTo')";
            }
            
            $tPGPFrom   = $paData['aPGP'][0]; 
            $tPGPTo     = $paData['aPGP'][1]; 
            if ($tPGPFrom != '' &&  $tPGPTo != ''){
                $tSQL .= " AND (FTPgpChain BETWEEN '$tPGPFrom' AND '$tPGPTo')";
            }

            $tPTYFrom   = $paData['aPTY'][0]; 
            $tPTYTo     = $paData['aPTY'][1]; 
            if ($tPTYFrom != '' &&  $tPTYTo != ''){
                $tSQL .= " AND (FTPtyCode BETWEEN '$tPTYFrom' AND '$tPTYTo')";
            }
        }else if($tSelectTier == 'PDT'){
            $tBchSession = $this->session->userdata("tSesUsrBchCode");
            $tShpSession = $this->session->userdata("tSesUsrShpCode");
            $tMerSession = $this->session->userdata("tSesUsrMerCode");

            $tSQL = "SELECT COUNT(Totalrecord.FTPdtCode) AS counts FROM (
                     SELECT FTPdtCode FROM(SELECT DISTINCT 
                        PDT.FTPdtCode,
                        PAC.FTPunCode,
                        UNT.FTPunName
                    FROM TCNMPdt PDT
                    LEFT JOIN TCNMPdtSpcBch PBCH    ON PDT.FTPdtCode = PBCH.FTPdtCode  
                    LEFT JOIN TCNMPdt_L PDTL        ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = 1
                    LEFT JOIN TCNMPdtPackSize PAC	ON PAC.FTPdtCode = PDT.FTPdtCode
                    LEFT JOIN TCNMPdtBar BAR        ON BAR.FTPdtCode = PDT.FTPdtCode 
                    LEFT JOIN TCNMPdtUnit_L UNT     ON UNT.FTPunCode = PAC.FTPunCode AND UNT.FNLngID = 1 
                    LEFT JOIN TCNMPdtSpl SPL        ON PDT.FTPdtCode = SPL.FTPdtCode AND BAR.FTBarCode = SPL.FTBarCode";
            
            //ที่เก็บ
            $tPDTLOGSEQTo     = $paData['tPDTLOGSEQ']; 
            if ($tPDTLOGSEQTo != ''){
                $tSQL .= " LEFT JOIN TCNTPdtLocSeq LOCSEQ ON LOCSEQ.FTBarCode = BAR.FTPdtCode WHERE (LOCSEQ.FTPlcCode = '$tPDTLOGSEQTo') AND ";
            }else{
                $tSQL .= " WHERE ";
            }

            $nPDTMoveon = $paData['nPDTMoveon']; 
            if ($nPDTMoveon == 1){
                $tSQL .= " PDT.FTPdtStaActive = '1' ";
            }else if($nPDTMoveon == 2){
                $tSQL .= " PDT.FTPdtStaActive = '2' ";
            }

            $tBarcode = $paData['tBarcode'];
            if ($tBarcode != ''){
                $tSQL .= " AND (BAR.FTBarcode LIKE '%$tBarcode%')";
            }

            $tNamePDT = $paData['tNamePDT']; 
            if ($tNamePDT != ''){
                $tSQL .= " AND (PDTL.FTPdtName LIKE '%$tNamePDT%')";
            }

            $tPurchasingManager = $paData['tPurchasingManager'];
            if ($tPurchasingManager != ''){
                $tSQL .= " AND (SPL.FTUsrCode = '$tPurchasingManager')";
            }

            $tCodePDT = $paData['tCodePDT']; 
            if ($tCodePDT != ''){
                $tSQL .= " AND (PDT.FTPdtCode = '$tCodePDT')";
            }

            $tSPLCode = $paData['tSPLCode']; 
            if ($tSPLCode != ''){
                $tSQL .= " AND (SPL.FTSplCode LIKE '%$tSPLCode%')";
            }

            $tMerchant = $paData['tMerchant']; 
            if ($tMerchant != ''){
                $tSQL .= " AND (PBCH.FTMerCode = '$tMerchant')";
            }

            //กลุ่มสินค้า ของ กลุ่มร้านค้า
            $tMerchantGroup = $paData['tMerchantGroup']; 
            if ($tMerchantGroup == ''){
                
            }else{
                $tSQL .= " AND (PBCH.FTMgpCode = '$tMerchantGroup')";
            }

            $tPagename = $paData['tPagename'];
            if($tPagename == 'PI'){
                $tSQL .= " AND (PDT.FTPdtSetOrSN != 4)";
            }

            $tBCHFrom   = $paData['aBCH'][0]; 
            $tBCHTo     = $paData['aBCH'][1]; 
            if ($tBCHFrom == '' &&  $tBCHTo == ''){
                //Check Session BCH
                if($tBchSession == '' || $tBchSession == null){ //HQ
                    //$tSQL .= " AND (PBCH.FTBchCode != '')";
                }else if($tBchSession != '' && $tShpSession == ''){
                    $tSQL .= " AND (PBCH.FTBchCode = $tBchSession)";
                    // $tSQL .= " AND (PBCH.FTBchCode = $tBchSession AND ISNULL(PBCH.FTMerCode,'') = '' AND ISNULL(PBCH.FTShpCode,'') = '' )";
                }
            }else{
                $tSQL .= " AND (PBCH.FTBchCode BETWEEN '$tBCHFrom' AND '$tBCHTo')";
            }
            
            $tSHPFrom   = $paData['aSHP'][0]; 
            $tSHPTo     = $paData['aSHP'][1]; 
            if ($tSHPFrom == '' &&  $tSHPTo == ''){
                if($tShpSession != '' || $tShpSession != null){
                    $tSQL .= " AND ( PBCH.FTShpCode = $tShpSession )";
                }
            }else{
                $tSQL .= " AND (PBCH.FTShpCode BETWEEN '$tSHPFrom' AND '$tSHPTo')";
            }
            
            $tPGPFrom   = $paData['aPGP'][0]; 
            $tPGPTo     = $paData['aPGP'][1]; 
            if ($tPGPFrom != '' &&  $tPGPTo != ''){
                $tSQL .= " AND (FTPgpChain BETWEEN '$tPGPFrom' AND '$tPGPTo')";
            }

            $tPTYFrom   = $paData['aPTY'][0]; 
            $tPTYTo     = $paData['aPTY'][1]; 
            if ($tPTYFrom != '' &&  $tPTYTo != ''){
                $tSQL .= " AND (FTPtyCode BETWEEN '$tPTYFrom' AND '$tPTYTo')";
            }

            //ไม่เอาสินค้าอะไรบ้าง
            $aNotinItem = $paData['aNotinItem'];
            if($aNotinItem != '' || $aNotinItem != null){
                $tNotinItem     = '';
                $aNewNotinItem  = explode(',',$aNotinItem);

                for($i=0; $i<count($aNewNotinItem); $i++){
                    $aNewPDT  = explode(':::',$aNewNotinItem[$i]);
                    $tNotinItem .=  "'".$aNewPDT[0]."'" . ',';
                    if($i == count($aNewNotinItem)-1){
                        $tNotinItem = substr($tNotinItem,0,-1);
                    }
                }
                $tSQL .= " AND (PDTL.FTPdtCode NOT IN ($tNotinItem))";
            }
        }


        //ถ้าเข้ามาแบบ shp ไม่ต้อง union
        if(count($tShpSession) == 0){
            //ถ้ามี SHP BCH ก็ UNION
            if($tBchSession == ''){ //เข้ามาแบบ HQ
                if($tSHPFrom != '' &&  $tSHPTo != ''){
                    $tCanUnion = false;
                }else if($tMerchant != ''){
                    $tCanUnion = false;
                }else if($tBCHFrom != '' && $tBCHTo != ''){
                    $tCanUnion = true;
                }else{
                    $tCanUnion = false;
                }
            }

            if($tBchSession != '' && $tShpSession == ''){ //เข้ามาแบบ BCH
                if($tSHPFrom != '' &&  $tSHPTo != ''){
                    $tCanUnion = false;
                }else if($tMerchant != ''){
                    $tCanUnion = false;
                }else if($tCodePDT != ''){
                    $tCanUnion = true;
                }else{
                    $tCanUnion = true;
                }
            }

            if ($tCanUnion == true){
                if($tSelectTier == 'Barcode'){
                    $tSQL .= " UNION ALL ";
                    $tSQL .= " SELECT DISTINCT(PDT.FTPdtCode) FROM TCNMPdt PDT ";
                    $tSQL .= " LEFT JOIN TCNMPdtSpcBch PBCH ON PDT.FTPdtCode = PBCH.FTPdtCode ";
                    $tSQL .= " LEFT JOIN TCNMPdt_L PDTL ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = 1 ";
                    $tSQL .= " LEFT JOIN TCNMPdtBar BAR ON BAR.FTPdtCode = PDT.FTPdtCode ";
                    $tSQL .= " LEFT JOIN TCNMPdtSpl SPL ON PDT.FTPdtCode = SPL.FTPdtCode AND BAR.FTBarCode = SPL.FTBarCode WHERE PDT.FTPdtSetOrSN != 4 ";
                    
                    //สินค้าเคลื่อนไหว
                    $nPDTMoveon = $paData['nPDTMoveon']; 
                    if ($nPDTMoveon == 1){
                        $tSQL .= " AND PDT.FTPdtStaActive = '1' ";
                    }else if($nPDTMoveon == 2){
                        $tSQL .= " AND PDT.FTPdtStaActive = '2' ";
                    }

                    //บาร์โค๊ด
                    $tBarcode = $paData['tBarcode'];
                    if ($tBarcode != ''){
                        $tSQL .= " AND (BAR.FTBarcode LIKE '%$tBarcode%')";
                    }

                    //รหัสสินค้า
                    $tCodePDT = $paData['tCodePDT']; 
                    if ($tCodePDT != ''){
                        $tSQL .= " AND (PDT.FTPdtCode = '$tCodePDT')";
                    }

                    //ชื่อสินค้า
                    $tNamePDT = $paData['tNamePDT']; 
                    if ($tNamePDT != ''){
                        $tSQL .= " AND (PDTL.FTPdtName LIKE '%$tNamePDT%')";
                    }

                    if($tBchSession == '' || $tBchSession == null){
                        $tSQL .= " AND (ISNULL(PBCH.FTBchCode,'') = '' AND ISNULL(PBCH.FTMerCode,'') = '' AND ISNULL(PBCH.FTShpCode,'') = '' ) ";
                    }else{
                        $tSQL .= " AND ISNULL(PBCH.FTBchCode,'') = '' ";
                    }
                    $tSQL .= " ) AS Totalrecord ";
                }else if($tSelectTier == 'PDT'){
                    $tSQL .= " ) as A UNION ALL ";
                    $tSQL .= " SELECT FTPdtCode FROM( ";
                    $tSQL .= " SELECT DISTINCT PDT.FTPdtCode, PAC.FTPunCode, UNT.FTPunName FROM TCNMPdt PDT ";
                    $tSQL .= " LEFT JOIN TCNMPdtSpcBch PBCH ON PDT.FTPdtCode = PBCH.FTPdtCode ";
                    $tSQL .= " LEFT JOIN TCNMPdt_L PDTL ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = 1   ";
                    $tSQL .= " LEFT JOIN TCNMPdtPackSize PAC	ON PAC.FTPdtCode = PDT.FTPdtCode ";
                    $tSQL .= " LEFT JOIN TCNMPdtBar BAR ON BAR.FTPdtCode = PDT.FTPdtCode ";
                    $tSQL .= " LEFT JOIN TCNMPdtUnit_L UNT ON UNT.FTPunCode = PAC.FTPunCode AND UNT.FNLngID = 1   ";
                    $tSQL .= " LEFT JOIN TCNMPdtSpl SPL ON PDT.FTPdtCode = SPL.FTPdtCode AND BAR.FTBarCode = SPL.FTBarCode  ";
                    $tSQL .= " WHERE ";
                    $tSQL .= " PDT.FTPdtSetOrSN != 4 ";

                    //สินค้าเคลื่อนไหว
                    $nPDTMoveon = $paData['nPDTMoveon']; 
                    if ($nPDTMoveon == 1){
                        $tSQL .= " AND PDT.FTPdtStaActive = '1' ";
                    }else if($nPDTMoveon == 2){
                        $tSQL .= " AND PDT.FTPdtStaActive = '2' ";
                    }

                    //รหัสสินค้า
                    $tCodePDT = $paData['tCodePDT']; 
                    if ($tCodePDT != ''){
                        $tSQL .= " AND (PDT.FTPdtCode = '$tCodePDT')";
                    }

                    //ชื่อสินค้า
                    $tNamePDT = $paData['tNamePDT']; 
                    if ($tNamePDT != ''){
                        $tSQL .= " AND (PDTL.FTPdtName LIKE '%$tNamePDT%')";
                    }

                    if($tBchSession == '' || $tBchSession == null){
                        $tSQL .= " AND (ISNULL(PBCH.FTBchCode,'') = '' AND ISNULL(PBCH.FTMerCode,'') = '' AND ISNULL(PBCH.FTShpCode,'') = '' ) ";
                    }else if($tBchSession != '' && $tShpSession == ''){
                        $tSQL .= " AND (ISNULL(PBCH.FTBchCode,'') = '' AND ISNULL(PBCH.FTMerCode,'') = '' AND ISNULL(PBCH.FTShpCode,'') = '' )";
                    }
                    $tSQL .= " ) as A ) as Totalrecord ";
                }
            }else{
                if($tSelectTier == 'Barcode'){
                    $tSQL .= " ) AS Totalrecord ";
                }else if($tSelectTier == 'PDT'){
                    $tSQL .= " ) as A ) as Totalrecord ";
                }
            }
        }else{
            if($tSelectTier == 'Barcode'){
                $tSQL .= " ) AS Totalrecord ";
            }else if($tSelectTier == 'PDT'){
                $tSQL .= " ) as A ) as Totalrecord ";
            }
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //get หาต้นทุนใช้แบบไหน
    public function FSnMGetTypePrice($tSyscode,$tSyskey,$tSysseq){
        $tSQL = "SELECT FTSysStaDefValue,FTSysStaUsrValue
            FROM  TSysConfig 
            WHERE 
                FTSysCode = '$tSyscode' AND 
                FTSysKey = '$tSyskey' AND 
                FTSysSeq = '$tSysseq'
            ";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0){
            $oRes  = $oQuery->result();
            if($oRes[0]->FTSysStaUsrValue != ''){
                $tDataSavDec = $oRes[0]->FTSysStaUsrValue;
            }else{
                $tDataSavDec = $oRes[0]->FTSysStaDefValue;    
            }
        }else{
            //Decimal Default = 2 
            $tDataSavDec = 2;
        }
        return $tDataSavDec;
    }

    //get Barcode - COST
    public function FSnMGetBarcodeCOST($paData,$aNotinItem){
        $FNLngID        = $paData['FNLngID'];
        $FTPdtCode      = $paData['FTPdtCode'];
        $tVatInorEx     = $paData['tVatInorEx'];

        $tSQL =  "SELECT P.*,PUNL.FTPunName,";
                if( $tVatInorEx == 1){
        $tSQL .= " ISNULL(CAVG.FCPdtCostEx    * ISNULL(P.FCPdtUnitFact,1),NULL)	as PDTCostAvgInorEX ,";
                }else if( $tVatInorEx == 2){
        $tSQL .= " ISNULL(CAVG.FCPdtCostIn    * ISNULL(P.FCPdtUnitFact,1),NULL)	as PDTCostAvgInorEX ,";
                }
        $tSQL .= " ISNULL(PSPL.FCSplLastPrice * ISNULL(P.FCPdtUnitFact,1),NULL) as PDTCostLastPrice,
                ISNULL(PCFF.FCPdtCostEx       *	ISNULL(P.FCPdtUnitFact,1),NULL)	as PDTCostFiFo			
                FROM(
                SELECT 
                        PDT.FTPdtCode,	
                        PBCH.FTShpCode,
                        PDT_L.FTPdtName,
                        PBCH.FTBchCode,			
                        BAR.FTBarCode,
                        BAR.FTPunCode,
                        PPS.FCPdtUnitFact,
                        PDT.FCPdtCostStd *  ISNULL(PPS.FCPdtUnitFact,1)	as PDTCostSTD,
                        PDTIMG.FTImgObj,
                        LOGSEQ.FTPlcCode
                            
                FROM TCNMPdt PDT
                LEFT JOIN TCNMPdtSpcBch PBCH  ON PDT.FTPdtCode = PBCH.FTPdtCode  
                LEFT JOIN TCNMPdtBar BAR ON BAR.FTPdtCode = PDT.FTPdtCode
                LEFT JOIN  TCNTPdtLocSeq  LOGSEQ  ON BAR.FTBarCode   = LOGSEQ.FTBarCode
                LEFT JOIN TCNMPdt_L PDT_L ON PDT.FTPdtCode = PDT_L.FTPdtCode AND PDT_L.FNLngID = '$FNLngID'
                INNER JOIN TCNMPdtPackSize PPS ON PDT.FTPdtCode = PPS.FTPdtCode AND BAR.FTPunCode = PPS.FTPunCode 
                LEFT JOIN TCNMImgPdt PDTIMG ON PDT.FTPdtCode = PDTIMG.FTImgRefID AND PDTIMG.FTImgTable = 'TCNMPdt' AND PDTIMG.FTImgKey = 'master' AND PDTIMG.FNImgSeq = '1'
                WHERE PDT.FTPdtCode = '$FTPdtCode'
                ) P
                LEFT JOIN TCNMPdtUnit_L PUNL ON P.FTPunCode = PUNL.FTPunCode  AND PUNL.FNLngID = '$FNLngID'
                LEFT JOIN  TCNMPdtCostAvg CAVG	ON CAVG.FTPdtCode = P.FTPdtCode
                LEFT JOIN  TCNMPdtSpl PSPL	ON PSPL.FTPdtCode = P.FTPdtCode AND PSPL.FTBarCode = P.FTBarCode
                LEFT JOIN  TCNMPdtCostFiFo PCFF	ON PCFF.FTPdtCode = P.FTPdtCode";
        //ไม่เอาสินค้าอะไรบ้าง
        if($aNotinItem != '' || $aNotinItem != null){
            $tNotinItem     = '';
            $aNewNotinItem  = explode(',',$aNotinItem);

            for($i=0; $i<count($aNewNotinItem); $i++){
                $aNewPDT  = explode(':::',$aNewNotinItem[$i]);
                $tNotinItem .=  "'".$aNewPDT[1]."'" . ',';
                if($i == count($aNewNotinItem)-1){
                    $tNotinItem = substr($tNotinItem,0,-1);
                }
            }
            $tSQL .= " WHERE (PBAR.FTBarCode NOT IN ($tNotinItem))";
        }   


        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //get Barcode - PriceSell
    public function FSnMGetBarcodePriceSELL($paData,$aNotinItem){
        $FNLngID        = $paData['FNLngID'];
        $FTPdtCode      = $paData['FTPdtCode'];

        $tSQL =  "SELECT Price.* , 
                        PDT.FTPdtCode,
                        PDTIMG.FTImgObj,
                        PDT.FTPdtCode,
                        PDT_L.FTPdtName,
                        PDT_L.FTPdtRmk,
                        PPSZ.FTPunCode,
                        PBAR.FTBarCode,
                        PDTG_L.FTPgpName,
                        PTY_L.FTPtyName,
                        PUN_L.FTPunName,
                        PBCH.FTShpCode,
                        PBCH.FTBchCode,
                        PSPL.FTSplCode,
                        SPLL.FTSplName ,
                        LOGSEQ.FTPlcCode,
                        PDAGE.FCPdtCookTime , 
                        PDAGE.FCPdtCookHeat 
                    FROM ( SELECT TOP 1 
                    FTPdtCode,
                    ISNULL(P4PDT.FCPgdPriceRet,0) AS FCPgdPriceRet,
                    ISNULL(P4PDT.FCPgdPriceWhs,0) AS FCPgdPriceWhs,
                    ISNULL(P4PDT.FCPgdPriceNet,0) AS FCPgdPriceNet
                    FROM TCNTPdtPrice4PDT P4PDT
                    WHERE FTPdtCode = '$FTPdtCode'
                    AND ((CONVERT(VARCHAR(10),GETDATE(),121) >= CONVERT(VARCHAR(10),P4PDT.FDPghDStart,121)) 
                    AND (CONVERT(VARCHAR(10),GETDATE(),121) <= CONVERT(VARCHAR(10),P4PDT.FDPghDStop,121)))
                    AND P4PDT.FTPghDocType = 1
                    ORDER BY CONVERT(VARCHAR(10),P4PDT.FDPghDStart,121) DESC 
                    ) AS Price 
                RIGHT JOIN TCNMPdt          PDT     ON Price.FTPdtCode  = PDT.FTPdtCode
                LEFT JOIN TCNMPdtSpcBch     PBCH    ON PDT.FTPdtCode    = PBCH.FTPdtCode  
                LEFT JOIN TCNMPdt_L         PDT_L   ON PDT.FTPdtCode    = PDT_L.FTPdtCode AND PDT_L.FNLngID = 1
                LEFT JOIN TCNMPdtPackSize   PPSZ    ON PDT.FTPdtCode    = PPSZ.FTPdtCode
                LEFT JOIN TCNMPdtBar        PBAR    ON PDT.FTPdtCode    = PBAR.FTPdtCode AND PPSZ.FTPunCode = PBAR.FTPunCode
                LEFT JOIN TCNMPdtGrp        PGRP    ON PDT.FTPgpChain   = PGRP.FTPgpCode
                LEFT JOIN TCNMPdtGrp_L      PDTG_L  ON PGRP.FTPgpCode   = PDTG_L.FTPgpChain AND PDTG_L.FNLngID  = 1
                LEFT JOIN TCNMPdtType_L     PTY_L   ON PDT.FTPtyCode    = PTY_L.FTPtyCode AND PTY_L.FNLngID   = 1
                LEFT JOIN TCNMPdtUnit_L     PUN_L   ON PPSZ.FTPunCode   = PUN_L.FTPunCode AND PUN_L.FNLngID   = 1
                LEFT JOIN TCNMPdtSpl        PSPL    ON PDT.FTPdtCode    = PSPL.FTPdtCode AND PBAR.FTBarCode = PSPL.FTBarCode
                LEFT JOIN TCNMSpl_L         SPLL    ON PSPL.FTSplCode   = SPLL.FTSplCode AND SPLL.FNLngID = 1
                LEFT JOIN TCNMPdtAge        PDAGE   ON PDAGE.FTPdtCode  = PDT.FTPdtCode 
                LEFT JOIN TCNMImgPdt        PDTIMG  ON PDT.FTPdtCode    = PDTIMG.FTImgRefID AND PDTIMG.FTImgTable = 'TCNMPdt' AND PDTIMG.FTImgKey = 'master' AND PDTIMG.FNImgSeq = '1'
                LEFT JOIN TCNTPdtLocSeq     LOGSEQ  ON PBAR.FTBarCode   = LOGSEQ.FTBarCode
                WHERE 1=1 AND PDT.FTPdtCode  = '$FTPdtCode' ";

        //ไม่เอาสินค้าอะไรบ้าง
        if($aNotinItem != '' || $aNotinItem != null){
            $tNotinItem     = '';
            $aNewNotinItem  = explode(',',$aNotinItem);

            for($i=0; $i<count($aNewNotinItem); $i++){
                $aNewPDT  = explode(':::',$aNewNotinItem[$i]);
                if($FTPdtCode == $aNewPDT[0]){
                    $tNotinItem .=  "'".$aNewPDT[1]."'" . ',';
                }

                if($i == count($aNewNotinItem)-1){
                    $tNotinItem = substr($tNotinItem,0,-1);
                }
            }
            if($tNotinItem == ''){
                $tSQL .= " ORDER BY PBAR.FTBarCode ASC";
            }else{
                $tSQL .= " AND (PBAR.FTBarCode NOT IN ($tNotinItem)) ORDER BY PBAR.FTBarCode ASC ";
            }
        }else{
            $tSQL .= " ORDER BY PBAR.FTBarCode ASC";
        }   

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //get vat จาก company กรณีที่ไม่มี supplier ส่งมา
    public function FSaMGetWhsInorExIncompany(){
        $tSQL           = "SELECT TOP 1 FTCmpWhsInOrEx FROM TCNMComp";
        $oQuery         = $this->db->query($tSQL);
        $oList          = $oQuery->result_array();
        return $oList;
    }

    //get vat จาก sup
    public function FSaMGetWhsInorExInSupplier($pnCode){
        $tSQL           = "SELECT FTSplStaVATInOrEx FROM TCNMSpl WHERE FTSplCode = '$pnCode'";
        $oQuery         = $this->db->query($tSQL);
        $oList          = $oQuery->result_array();
        return $oList;
    }



}