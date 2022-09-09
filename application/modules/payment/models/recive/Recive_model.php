<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recive_model extends CI_Model
{

    //Functionality : Search Recive By ID
    //Parameters : function parameters
    //Creator : 11/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRCVSearchByID($ptAPIReq, $ptMethodReq, $paData)
    {
        $tRcvCode   = $paData['FTRcvCode'];
        $nLngID     = $paData['FNLngID'];

        $tSQL = "SELECT
                    RCV.FTRcvCode   AS rtRcvCode,
                    RCV.FTRcvStaUse AS rtRcvStatus,
                    RCV.FTFmtCode   AS rtFmtCode,
                    RCVL.FTRcvName  AS rtRcvName,
                    RCVL.FTRcvRmk   AS rtRcvRmk,
                    IMGO.FTImgObj   AS rtImgObj,
                    RCV.FTAppStaAlwRet,
                    RCV.FTAppStaAlwCancel,
                    RCV.FTAppStaPayLast,
                    TRF.FTFmtStaAlwCfg,
                    TRFL.FTFmtName,
                    RCV.FTRcvRefRate,
                    RCFL.FTRteName,
                    RCV.FTRcvStaAllRte
                 FROM [TFNMRcv] RCV WITH(NOLOCK)
                 LEFT JOIN [TFNMRcv_L] RCVL WITH(NOLOCK) ON RCV.FTRcvCode = RCVL.FTRcvCode AND RCVL.FNLngID = $nLngID
                 LEFT JOIN [TCNMImgObj] IMGO WITH(NOLOCK) ON RCV.FTRcvCode = IMGO.FTImgRefID AND IMGO.FTImgTable = 'TFNMRcv' AND IMGO.FNImgSeq = 1
                 LEFT JOIN [TSysRcvFmt] TRF WITH(NOLOCK) ON TRF.FTFmtCode = RCV.FTFmtCode
                 LEFT JOIN [TSysRcvFmt_L] TRFL WITH(NOLOCK) ON TRFL.FTFmtCode = TRF.FTFmtCode AND TRFL.FNLngID = $nLngID
                 LEFT JOIN [TFNMRate_L] RCFL WITH(NOLOCK) ON RCFL.FTRteCode = RCV.FTRcvRefRate AND TRFL.FNLngID = $nLngID
                 WHERE 1=1 ";

        if ($tRcvCode != "") {
            $tSQL .= "AND RCV.FTRcvCode = '$tRcvCode'";
        }
        // print_r($tSQL); die();
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

    //Functionality : list Recive
    //Parameters : function parameters
    //Creator :  11/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRCVList($ptAPIReq, $ptMethodReq, $paData)
    {
        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID = $paData['FNLngID'];

        $tSQL   = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtRcvCode ASC) AS rtRowID,* FROM
                            (SELECT DISTINCT
                                RCV.FTRcvCode   AS rtRcvCode,
                                RCV.FTRcvStaUse AS rtRcvStatus,
                                RCVL.FTRcvName  AS rtRcvName,
                                RCVF.FTFmtCode  AS rtRCVFmtCode,
                                RCVF.FTFmtName  AS rtRCVFmtName,
                                IMGO.FTImgObj   AS rtImgObj,
                                RCV.FDCreateOn,
                                RCV.FTAppStaAlwRet,
                                RCV.FTAppStaAlwCancel,
                                RCV.FTAppStaPayLast
                            FROM [TFNMRcv] RCV WITH(NOLOCK)
                            LEFT JOIN [TFNMRcv_L] RCVL WITH(NOLOCK) ON RCV.FTRcvCode = RCVL.FTRcvCode AND RCVL.FNLngID = $nLngID
                            LEFT JOIN [TSysRcvFmt_L] RCVF WITH(NOLOCK) ON RCV.FTFmtCode = RCVF.FTFmtCode AND RCVF.FNLngID = $nLngID
                            LEFT JOIN [TCNMImgObj] IMGO WITH(NOLOCK) ON RCV.FTRcvCode = IMGO.FTImgRefID AND IMGO.FTImgTable = 'TFNMRcv' AND IMGO.FNImgSeq = 1
                            WHERE 1=1 ";

        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != '') {
            $tSQL .= " AND (RCV.FTRcvCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR RCVL.FTRcvName  COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR RCVF.FTFmtName  COLLATE THAI_BIN LIKE '%$tSearchList%')";
        }

        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMRCVGetPageAll($tSearchList, $nLngID);
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

    //Functionality : All Page Of Recive
    //Parameters : function parameters
    //Creator :  11/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMRCVGetPageAll($ptSearchList, $ptLngID)
    {

        $tSQL   =   "   SELECT 
                            COUNT (RCV.FTRcvCode) AS counts
                        FROM TFNMRcv                RCV     WITH(NOLOCK)
                        LEFT JOIN [TFNMRcv_L]       RCVL    WITH(NOLOCK) ON RCV.FTRcvCode = RCVL.FTRcvCode   AND RCVL.FNLngID = $ptLngID
                        LEFT JOIN [TSysRcvFmt_L]    RCVF    WITH(NOLOCK) ON RCV.FTFmtCode = RCVF.FTFmtCode   AND RCVF.FNLngID = $ptLngID
                        WHERE 1=1
        ";

        if ($ptSearchList != '') {
            $tSQL .= " AND (RCV.FTRcvCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR RCVL.FTRcvName LIKE '%$ptSearchList%'";
            $tSQL .= " OR RCVF.FTFmtName LIKE '%$ptSearchList%')";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }

    //Functionality : Select Data Recive Formate
    //Parameters : function parameters
    //Creator :  11/05/2018 Wasin
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMRCVFormat($ptAPIReq, $ptMethodReq, $paData)
    {
        $nLngID = $paData['FNLngID'];
        $tSQL = "SELECT
                        RCVF.FTFmtCode  AS rtFmtCode,
                        RCVF.FTFmtKbRef AS rtFmtKey,
                        RCVFL.FTFmtName AS rtFmtName
                    FROM [TSysRcvFmt] RCVF
                    LEFT JOIN [TSysRcvFmt_L] RCVFL ON RCVF.FTFmtCode = RCVFL.FTFmtCode AND RCVFL.FNLngID = $nLngID
        ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aResult = array(
                'raItems'   => $oList,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            //No Data
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Functionality : Functio Add/Update Masters
    //Parameters : function parameters
    //Creator :  14/05/2018 Wasin
    //Last Modified : 11/06/2018 wasin (ยุบรวม Update Add)
    //Return : Status Add Update Master
    //Return Type : Array
    public function FSaMRCVAddUpdateMaster($paData)
    {
        try {
            $this->db->select('FTFmtStaAlwCfg');
            $this->db->from('TSysRcvFmt');
            $this->db->where('FTFmtCode', $paData['FTFmtCode']);
            $oGet = $this->db->get();
            $aData = $oGet->result_array();
            $nData = $oGet->num_rows();


            //Update Master
            $this->db->set('FTFmtCode', $paData['FTFmtCode']);
            $this->db->set('FTRcvStaUse', $paData['FTRcvStaUse']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
            $this->db->set('FTRcvRefRate', $paData['FTRcvRefRate']);
            $this->db->set('FTRcvStaAllRte', $paData['FTRcvStaAllRte']);
            $this->db->set('FTAppStaAlwRet', $paData['FTAppStaAlwRet']);
            $this->db->set('FTAppStaAlwCancel', $paData['FTAppStaAlwCancel']);
            $this->db->set('FTAppStaPayLast', $paData['FTAppStaPayLast']);

            $this->db->where('FTRcvCode', $paData['FTRcvCode']);
            $this->db->update('TFNMRcv');
            if ($this->db->affected_rows() > 0) {

                if ($paData['FTFmtCode'] != $paData['FTFmtCodeOld']) {
                    $this->db->where('FTRcvCode', $paData['FTRcvCode']);
                    $this->db->delete('TFNMRcvSpcConfig');

                    $this->db->where('FTRcvCode', $paData['FTRcvCode']);
                    $this->db->delete('TFNMRcvSpc');
                }


                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            } else {
                //Add Master
                $this->db->insert('TFNMRcv', array(
                    'FTRcvCode'     => $paData['FTRcvCode'],
                    'FTFmtCode'     => $paData['FTFmtCode'],
                    'FTRcvStaUse'   => $paData['FTRcvStaUse'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],

                    'FTAppStaAlwRet'    => $paData['FTAppStaAlwRet'],
                    'FTAppStaAlwCancel' => $paData['FTAppStaAlwCancel'],
                    'FTAppStaPayLast'   => $paData['FTAppStaPayLast'],
                    'FTRcvRefRate'      => $paData['FTRcvRefRate'],
                    'FTRcvStaAllRte'    => $paData['FTRcvStaAllRte'],
                ));


                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }

            if($this->session->userdata("tSesUsrLevel") != 'HQ'){
                $tRcvSpcAggCode = $this->session->userdata("tSesUsrAgnCode");
                $tRcvSpcBchCode = $this->session->userdata("tSesUsrBchCodeDefault");
                if ($tRcvSpcAggCode == '' && $tRcvSpcBchCode != '') {
                    $tBchIns = $tRcvSpcBchCode;
                } else {
                    $tBchIns = '';
                }
                
                $aDataRcvCode = array(
                    'FTRcvCode' => $paData['FTRcvCode'],
                    'FTAppCode'  =>   '',
                    'FTAggCode'  =>   $tRcvSpcAggCode,
                    'FTBchCode'  =>   $tBchIns,
                    'FTMerCode'  =>   '',
                    'FTShpCode'  =>   '',
                    'FTPosCode'  =>   '',
                    'FTPdtRmk'  =>   '',
                    'FNRcvSeq' => 1

                );
                $this->db->insert('TFNMRcvSpc', $aDataRcvCode);
            } 

            $this->db->select('FTRcvCode');
            $this->db->from('TFNMRcvSpcConfig');
            $this->db->where('FTRcvCode', $paData['FTRcvCode']);
            $this->db->limit(1);
            $oGetRdv = $this->db->get();
            $nDataRcv = $oGetRdv->num_rows();

            if ($nDataRcv > 0) {
            } else {
                if ($nData > 0) {
                    if ($aData[0]['FTFmtStaAlwCfg'] == 1) {

                        $this->db->select('*');
                        $this->db->from('TSysRcvConfig');
                        $this->db->where('FTFmtCode', $paData['FTFmtCode']);
                        $oResultConfig = $this->db->get();
                        $aDataConfig = $oResultConfig->result_array();
                        $nNumConfig = $oResultConfig->num_rows();
                        // print_r($aDataConfig);   print_r($nNumConfig); die();

                        if ($nNumConfig > 0) {
                            foreach ($aDataConfig  as $aVal) {
                                $aDataRcvCodeCfg = array(
                                    'FTRcvCode' => $paData['FTRcvCode'],
                                    'FNRcvSeq' => 1,
                                    'FNSysSeq' => $aVal['FNSysSeq'],
                                    'FTSysKey' => $aVal['FTSysKey'],
                                    'FTSysStaUsrValue'  =>   $aVal['FTSysStaUsrValue'],
                                    'FTSysStaUsrRef' =>   $aVal['FTSysStaUsrRef']
                                );
                                $this->db->insert('TFNMRcvSpcConfig', $aDataRcvCodeCfg);
                            }
                            $tRcvSpcAggCode = $this->session->userdata("tSesUsrAgnCode");
                            $tRcvSpcBchCode = $this->session->userdata("tSesUsrBchCodeDefault");
                            if ($tRcvSpcAggCode == '' && $tRcvSpcBchCode != '') {
                                $tBchIns = $tRcvSpcBchCode;
                            } else {
                                $tBchIns = '';
                            }
                            
                            $aDataRcvCode = array(
                                'FTRcvCode' => $paData['FTRcvCode'],
                                'FTAppCode'  =>   '',
                                'FTAggCode'  =>   $tRcvSpcAggCode,
                                'FTBchCode'  =>   $tBchIns,
                                'FTMerCode'  =>   '',
                                'FTShpCode'  =>   '',
                                'FTPosCode'  =>   '',
                                'FTPdtRmk'  =>   '',
                                'FNRcvSeq' => 1

                            );

                            $this->db->insert('TFNMRcvSpc', $aDataRcvCode);
                        }
                    }
                }
            }






            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //Functionality : Functio Add/Update Lang
    //Parameters : function parameters
    //Creator :  14/05/2018 Wasin
    //Last Modified : 11/06/2018 wasin (ยุบรวม Update Add Update)
    //Return : Status Add Update Lang
    //Return Type : Array
    public function FSaMRCVAddUpdateLang($paData)
    {
        try {
            //Update Lang
            $this->db->set('FTRcvName', $paData['FTRcvName']);
            $this->db->set('FTRcvRmk', $paData['FTRcvRmk']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTRcvCode', $paData['FTRcvCode']);
            $this->db->update('TFNMRcv_L');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            } else {
                //Add Lang
                $this->db->insert('TFNMRcv_L', array(
                    'FTRcvCode' => $paData['FTRcvCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTRcvName' => $paData['FTRcvName'],
                    'FTRcvRmk'  => $paData['FTRcvRmk'],
                ));
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Lang Success.',
                    );
                } else {
                    //Error 
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Lang.',
                    );
                }
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //Functionality : Checkduplicate
    //Parameters : function parameters
    //Creator : 14/05/2018 wasin
    //Last Modified : -
    //Return : data Count Duplicate
    //Return Type : object
    public function FSoMRCVCheckDuplicate($ptRcvCode)
    {
        $tSQL   = "SELECT COUNT(FTRcvCode)AS counts
                   FROM TFNMRcv
                   WHERE FTRcvCode = '$ptRcvCode' ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    //Functionality : Delete Recive
    //Parameters : function parameters
    //Creator : 14/05/2018 wasin
    //Return : response
    //Return Type : array
    public function FSnMRCVDel($ptAPIReq, $ptMethodReq, $paData)
    {
        $this->db->where_in('FTRcvCode', $paData['FTRcvCode']);
        $this->db->delete('TFNMRcv');

        $this->db->where_in('FTRcvCode', $paData['FTRcvCode']);
        $this->db->delete('TFNMRcv_L');

        $this->db->where_in('FTRcvCode', $paData['FTRcvCode']);
        $this->db->delete('TFNMRcvSpcConfig');

        $this->db->where_in('FTRcvCode', $paData['FTRcvCode']);
        $this->db->delete('TFNMRcvSpc');
        // if ($this->db->affected_rows() > 0) {
        //Success
        $aStatus = array(
            'rtCode' => '1',
            'rtDesc' => 'success',
        );
        // } else {
        //Ploblem
        // $aStatus = array(
        //     'rtCode' => '905',
        //     'rtDesc' => 'cannot Delete Item.',
        // );
        // }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }

    //Functionality : Delete Image Recive
    //Parameters : function parameters
    //Creator : 12/08/2019 Saharat(Golf)
    //Return : array
    //Return Type : array
    public function FSnMRCVImgDel($paData)
    {
        $this->db->where_in('FTImgRefID', $paData['tImgRefID']);
        $this->db->where_in('FTImgTable', $paData['tImgTable']);
        $this->db->delete('TCNMImgObj');

        // if ($this->db->affected_rows() > 0) {
        //Success
        $aStatus = array(
            'rtCode' => '1',
            'rtDesc' => 'Delete success ',
        );
        // } else {
        //     //Ploblem
        //     $aStatus = array(
        //         'rtCode' => '905',
        //         'rtDesc' => 'cannot Delete Item.',
        //     );
        // }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }




    //Functionality : get all row data from pdt location
    //Parameters : -
    //Creator : 1/04/2019 Pap
    //Return : array result from db
    //Return Type : array

    public function FSnMLOCGetAllNumRow()
    {
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TFNMRcv";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        } else {
            $aResult = false;
        }
        return $aResult;
    }
}
