<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Rate_model extends CI_Model
{

    //Functionality : Search Rate By ID
    //Parameters : function parameters
    //Creator : 04/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRTESearchByID($paData)
    {

        $tRteCode   = $paData['FTRteCode'];
        $nLngID     = $paData['FNLngID'];
        $tAgnCode   = $paData['FTAgnCode'];

        $tSQL   = " SELECT
                        DISTINCT
                        RTE.FTRteCode       AS rtRteCode,
                        RTE.FCRteRate       AS rcRteRate,
                        RTE.FCRteFraction   AS rcRteFraction,
                        RTE.FCRteMaxUnit    AS rcRteMaxUnit,
                        RTE.FTRteType       AS rtRteType,
                        RTE.FTRteTypeChg    AS rcRteTypeChg,
                        RTE.FTRteSign       AS rcRteSign,
                        RTE.FTRteStaLocal   AS rcRteStaLocal,
                        RTE.FTRteStaUse     AS rtRteStaUse,
                        RTEL.FTRteName      AS rtRteName,
                        RTEL.FTRteShtName   AS rtRteShtName,
                        RTEL.FTRteNameText  AS rtRteNameText,
                        RTEL.FTRteDecText   AS rtRteDecText,
                        RTE.FTRteStaUse     AS rtRteStaUse,
                        RTE.FTRteStaLocal   AS rtRteStaLocal,
                        RTE.FTRteStaLocal   AS rtRteStaLocal,
                        RTE.FTRteStaAlwChange   AS rtRteStaAlwChange,
                        IMGO.FTImgObj       AS rtImgObj,
                        AGNL.FTAgnCode,
                        AGNL.FTAgnName,
                        RATEL.FTRteIsoCode,
                        RATEL.FTRteIsoName
                    FROM [TFNMRate] RTE WITH(NOLOCK)
                    LEFT JOIN [TFNMRate_L] RTEL WITH(NOLOCK) ON RTE.FTRteCode = RTEL.FTRteCode AND RTEL.FNLngID = $nLngID  AND RTE.FTAgnCode = RTEL.FTAgnCode
                    LEFT JOIN [TCNMImgObj] IMGO WITH(NOLOCK) ON RTE.FTAgnCode+RTE.FTRteCode = IMGO.FTImgRefID AND IMGO.FTImgTable = 'TFNMRate' AND IMGO.FNImgSeq = 1
                    LEFT JOIN [TCNMAgency_L] AGNL WITH(NOLOCK) ON AGNL.FTAgnCode = RTE.FTAgnCode
                    LEFT JOIN [TCNSRate_L] RATEL WITH(NOLOCK) ON RATEL.FTRteIsoCode = RTE.FTRteIsoCode
                    WHERE 1=1 
        ";

        if ($tRteCode != "") {
            $tSQL .= "AND RTE.FTRteCode = '$tRteCode' ";
        }
        $tSQL .= "AND RTE.FTAgnCode = '$tAgnCode'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
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

    //Functionality : list Rate
    //Parameters : function parameters
    //Creator :  11/05/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRTEList($paData)
    {
        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID = $paData['FNLngID'];
        $tSearchList = $paData['tSearchAll'];

        $tSQL   = " SELECT c.* FROM(
                        --  SELECT  ROW_NUMBER() OVER(ORDER BY FTAgnCode ASC,FTRteCode ASC) AS FNRowID,* 
                         SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC,FTRteCode DESC) AS FNRowID,* 
                        FROM
                            (SELECT DISTINCT
                                    RTE.FTRteCode,
                                    RTE.FCRteRate,
                                    RTE.FCRteFraction,
                                    RTE.FTRteType,
                                    RTE.FTRteTypeChg,
                                    RTE.FTRteSign,
                                    RTE.FTRteStaLocal,
                                    RTE.FTRteStaUse,
                                    RTEL.FTRteName,
                                    RTEL.FTRteShtName,
                                    RTEL.FTRteNameText,
                                    RTEL.FTRteDecText,
                                    IMGO.FTImgObj,
                                    RTE.FDCreateOn,
                                    AGNL.FTAgnCode,
                                    RTE.FTRteStaAlwChange,
                                    AGNL.FTAgnName
                            FROM [TFNMRate] RTE
                            LEFT JOIN [TFNMRate_L] RTEL ON RTE.FTRteCode = RTEL.FTRteCode   AND RTEL.FNLngID    = $nLngID AND RTE.FTAgnCode = RTEL.FTAgnCode
                            LEFT JOIN [TCNMImgObj] IMGO ON RTE.FTAgnCode+RTE.FTRteCode = IMGO.FTImgRefID  AND IMGO.FTImgTable = 'TFNMRate' AND IMGO.FNImgSeq  = 1
                            LEFT JOIN [TCNMAgency_L] AGNL WITH(NOLOCK) ON AGNL.FTAgnCode = RTE.FTAgnCode
                            WHERE 1=1
                    ";

        $tSessAgn = $this->session->userdata('tSesUsrAgnCode');
        if ($tSessAgn != '') {
            $tSQL   .= " AND (RTE.FTAgnCode = '' OR RTE.FTAgnCode = '$tSessAgn')";
        }

        if ($tSearchList != '') {
            $tSQL   .= " AND (UPPER(RTE.FTRteCode) COLLATE  THAI_BIN LIKE UPPER('%$tSearchList%')";
            $tSQL   .= " OR UPPER(RTEL.FTRteName) COLLATE THAI_BIN LIKE UPPER('%$tSearchList%'))";
        }

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMRTEGetPageAll($tSearchList, $nLngID);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            //No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Functionality : Update Creditcard
    //Parameters : function parameters
    //Creator : 03/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : response
    //Return Type : Array
    public function FSaMRTEAddUpdateMaster($paData)
    {
        if ($paData['FTRteStaLocal'] == 1) {
            $tRteCode = $paData['FTRteCode'];
            $tRteStalocal = $paData['FTRteStaLocal'];
            $tAgnCode = $paData['FTAgnCode'];

            $tSQL = "
                SELECT 
                    FTRteCode
                FROM TFNMRate WITH(NOLOCK)
                WHERE FTRteStaLocal = '$tRteStalocal' AND FTAgnCode = '$tAgnCode'
            ";

            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                $aData = $oQuery->result();

                $aDataUpdate = array(
                    'FTRteStaLocal' => 2,
                    'FDLastUpdOn' => $paData['FDLastUpdOn'],
                    'FTLastUpdBy' => $paData['FTLastUpdBy']
                );

                $this->db->where('FTRteCode', $aData[0]->FTRteCode);
                $this->db->update('TFNMRate', $aDataUpdate);
            }
        }

        // Update Master
        $this->db->set('FTAgnCode', $paData['FTAgnCode']);
        $this->db->set('FCRteRate', $paData['FCRteRate']);
        $this->db->set('FCRteFraction', $paData['FCRteFraction']);
        $this->db->set('FTRteType', $paData['FTRteType']);
        $this->db->set('FTRteTypeChg', $paData['FTRteTypeChg']);
        $this->db->set('FTRteSign', $paData['FTRteSign']);
        $this->db->set('FTRteStaUse', $paData['FTRteStaUse']);
        $this->db->set('FTRteStaLocal', $paData['FTRteStaLocal']);
        $this->db->set('FTRteStaAlwChange', $paData['FTRteStaAlwChange']);
        $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
        $this->db->set('FTRteIsoCode', $paData['FTRteIsoCode']);
        $this->db->set('FCRteMaxUnit', $paData['FCRteMaxUnit']);

        
        $this->db->where('FTRteCode', $paData['FTRteCode']);
        $this->db->where('FTAgnCode', $paData['FTAgnCode']);
        $this->db->update('TFNMRate');

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Master Success',
            );
        } else {
            // Add Master
            $this->db->insert('TFNMRate', array(
                'FTAgnCode' => $paData['FTAgnCode'],
                'FTRteCode' => $paData['FTRteCode'],
                'FCRteRate' => $paData['FCRteRate'],
                'FCRteFraction' => $paData['FCRteFraction'],
                'FTRteType' => $paData['FTRteType'],
                'FTRteTypeChg'  => $paData['FTRteTypeChg'],
                'FTRteSign' => $paData['FTRteSign'],
                'FTRteStaUse' => $paData['FTRteStaUse'],
                'FTRteIsoCode' => $paData['FTRteIsoCode'],
                'FCRteMaxUnit' => $paData['FCRteMaxUnit'],
                'FTRteStaLocal' => $paData['FTRteStaLocal'],
                // เวลาอัปเดทล่าสุด
                'FDLastUpdOn' => $paData['FDLastUpdOn'],
                'FTLastUpdBy' => $paData['FTLastUpdBy'],
                // เวลาบันทึกครั้งแรก
                'FDCreateOn' => $paData['FDCreateOn'],
                'FTCreateBy' => $paData['FTCreateBy']
            ));
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Master Success',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master.',
                );
            }
        }
        return $aStatus;
    }

    //Functionality : Update Lang Bank
    //Parameters : function parameters
    //Creator : 02/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : response
    //Return Type : num
    public function FSaMRTEAddUpdateLang($paData)
    {
        // Update Lang
        $this->db->set('FTAgnCode', $paData['FTAgnCode']);
        $this->db->set('FTRteName', $paData['FTRteName']);
        $this->db->where('FNLngID', $paData['FNLngID']);
        $this->db->where('FTAgnCode', $paData['FTAgnCode']);
        $this->db->where('FTRteCode', $paData['FTRteCode']);
        $this->db->update('TFNMRate_L');

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Lang Success.',
            );
        } else {
            $this->db->insert('TFNMRate_L', array(
                'FTAgnCode' => $paData['FTAgnCode'],
                'FTRteCode' => $paData['FTRteCode'],
                'FNLngID' => $paData['FNLngID'],
                'FTRteName' => $paData['FTRteName'],
            ));
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Lang Success',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Lang.',
                );
            }
        }
        return $aStatus;
    }

    //Functionality : Add Update Rate Unit  
    //Parameters : function parameters
    //Creator :  06/08/2020 Nale
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRTEAddUpdateRateUnitFact($paData)
    {
        try {
            $tRteCode = $paData['FTRteCode'];
            $aRtuFac = $paData['aRtuFac'];

            if (!empty($aRtuFac)) {
                $nRateUnit = $this->db->where(array('FTRteCode'=> $tRteCode,'FTAgnCode'=>$paData['FTAgnCode']))->order_by('FNRtuSeq', 'ASC')->get('TFNMRateUnit')->num_rows();
                if ($nRateUnit > 0) {
                    $this->db->where('FTRteCode', $tRteCode);
                    $this->db->where('FTAgnCode', $paData['FTAgnCode']);
                    $this->db->delete('TFNMRateUnit');
                }
                foreach ($aRtuFac as $nKey => $cRtuFac) {
                    $this->db->insert('TFNMRateUnit', array(
                        'FTAgnCode'     => $paData['FTAgnCode'],
                        'FTRteCode'     => $tRteCode,
                        'FNRtuSeq'      => ($nKey + 1),
                        'FCRtuFac'      => $cRtuFac

                    ));
                }
            }else{
                $this->db->where('FTRteCode', $tRteCode);
                $this->db->where('FTAgnCode', $paData['FTAgnCode']);
                $this->db->delete('TFNMRateUnit');
            }

            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Rate Unit Success',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Rate Unit.',
                );
            }

            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //Functionality : Get Rate Unit  
    //Parameters : function parameters
    //Creator :  06/08/2020 Nale
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRTERateUnit($paData)
    {
        $tRteCode = $paData['FTRteCode'];
        $aRateUnit = $this->db->where(array('FTRteCode'=> $tRteCode,'FTAgnCode'=>$paData['FTAgnCode']))->order_by('FNRtuSeq', 'ASC')->get('TFNMRateUnit')->result_array();

        if (count($aRateUnit) > 0) {
            return $aRateUnit;
        } else {
            //No Data
            return false;
        }
    }

    //Functionality : All Page Of Rate
    //Parameters : function parameters
    //Creator :  11/05/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMRTEGetPageAll($ptSearchList, $ptLngID)
    {
        $tSessAgn = $this->session->userdata('tSesUsrAgnCode');

        $tSQL = "SELECT  COUNT (RTE.FTRteCode) AS counts 
                 FROM TFNMRate RTE
                 LEFT JOIN [TFNMRate_L] RTEL ON RTE.FTRteCode = RTEL.FTRteCode AND RTE.FTAgnCode = RTEL.FTAgnCode AND RTEL.FNLngID = $ptLngID
                 WHERE 1=1 ";
        if ($ptSearchList != '') {
            $tSQL .= " AND (   UPPER(RTE.FTRteCode) COLLATE THAI_BIN LIKE UPPER('%$ptSearchList%')";
            $tSQL .= "      OR UPPER(RTEL.FTRteName)  COLLATE THAI_BIN LIKE UPPER('%$ptSearchList%'))";
        }
        
        if ($tSessAgn != '') {
            $tSQL   .= " AND (RTE.FTAgnCode = '' OR RTE.FTAgnCode = '$tSessAgn')";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }


    //Functionality : Check Feild FTRteStaLocal
    //Parameters : function parameters
    //Creator : 24/08/2020 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    public function FSnMRTECheckStaLocal($paData)
    {
        $tRteCode     = $paData['FTRteCode'];
        $tRteStalocal = $paData['FTRteStaLocal'];

        $tSQL  = "SELECT FTRteStaLocal AS counts
                  FROM TFNMRate 
                  WHERE FTRteStaLocal = '$tRteStalocal' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }



    //Functionality : Checkduplicate
    //Parameters : function parameters
    //Creator : 03/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMRTECheckDuplicate($ptRteCode,$ptAgnCode = '')
    {
        $tSQL = "SELECT COUNT(FTRteCode)AS counts
                 FROM TFNMRate
                 WHERE FTRteCode = '$ptRteCode' ";

        //เพิ่มเงื่อนไข ตรวจเช็ค Agency
        if($ptAgnCode != '' || $ptAgnCode != null){
            $tSQL .= " AND FTAgnCode = '$ptAgnCode' ";
        }
	
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }





    //Functionality : Delete Rate
    //Parameters : function parameters
    //Creator : 14/05/2018 wasin
    //Return : response
    //Return Type : array
    public function FSnMRTEDel($paData)
    {
        $this->db->where_in('FTRteCode', $paData['FTRteCode']);
        $this->db->where_in('FTAgnCode', $paData['FTAgnCode']);
        $this->db->delete('TFNMRate');

        $this->db->where_in('FTRteCode', $paData['FTRteCode']);
        $this->db->where_in('FTAgnCode', $paData['FTAgnCode']);
        $this->db->delete('TFNMRate_L');

        $this->db->where_in('FTRteCode', $paData['FTRteCode']);
        $this->db->where_in('FTAgnCode', $paData['FTAgnCode']);
        $this->db->delete('TFNMRateUnit');

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

    //Functionality : get all row 
    //Parameters : -
    //Creator : 12/08/2019 Saharat(Golf)
    //Return : array 
    //Return Type : array
    public function FSnMRTEGetAllNumRow()
    {
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TFNMRate";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        } else {
            $aResult = false;
        }
        return $aResult;
    }
}
