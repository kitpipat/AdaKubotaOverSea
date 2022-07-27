<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mPosChanel extends CI_Model
{

    /**
     * Functionality : Search UsrDepart By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMCHNSearchByID($ptAPIReq, $ptMethodReq, $paData)
    {

        $tChnCode = $paData['FTChnCode'];
        // $tChnBchCode = $paData['FTBchCode'];
        $nLngID = $paData['FNLngID'];

        //  query
        $tHDSQL =   "SELECT
                        CHN.FTChnCode   AS rtChnCode,
                       CHNL.FTChnName AS rtChnName,
                       CHNS.FTBchCode AS rtChnBchCode,
                       BCHL.FTBchName AS rtChnBchName,
                       CHNS.FTAgnCode AS rtChnAgnCode,
                       AGNL.FTAgnName AS rtChnAgnName,
                       CHN.FTAppCode AS rtChnAppCode,
                       APPL.FTAppName AS rtChnAppName,
                       CHN.FTPplCode AS rtChnPplCode,
                       PPLL.FTPplName AS rtChnPplName,
                       CHN.FTChnStaUse AS rtChnStaUse,
                    --    CHN.FTChnGroup AS rtChnGroup,
                       CHN.FTWahCode AS rtChnWahCode,
                       WAHL.FTWahName AS rtChnWahName,
                       CHN.FTChnRefCode AS rtChnRefCode,
                       CHN.FDCreateOn,
                       CHN.FNChnSeq   AS rtChnSeq
                            FROM [TCNMChannel] CHN
                    LEFT JOIN   TCNMChannel_L CHNL ON CHN.FTChnCode = CHNL.FTChnCode
                    LEFT JOIN   TCNMChannelSpc CHNS ON CHN.FTChnCode = CHNS.FTChnCode
                    LEFT JOIN   TCNMAgency_L AGNL ON CHNS.FTAgnCode = AGNL.FTAgnCode
                    LEFT JOIN   TCNMBranch_L BCHL ON CHNS.FTBchCode = BCHL.FTBchCode
                    LEFT JOIN   TSysApp_L APPL ON CHN.FTAppCode = APPL.FTAppCode  AND APPL.FNLngID = $nLngID
                    LEFT JOIN   TCNMPdtPriList_L PPLL ON CHN.FTPplCode = PPLL.FTPplCode
                    LEFT JOIN   TCNMWaHouse_L WAHL ON CHNS.FTBchCode =  WAHL.FTBchCode AND CHN.FTWahCode = WAHL.FTWahCode AND WAHL.FNLngID = $nLngID
                    WHERE 1=1 
                    
                    AND CHN.FTChnCode = '$tChnCode'";
        $oHDQuery = $this->db->query($tHDSQL);

        // Head of receipt and End of receipt query
        // $tDTSQL =   "SELECT
        //                 SMGDT.FTSmgName  AS rtSmgName,
        //                 SMGDT.FTSmgType AS rtSmgType,
        //                 SMGDT.FNSmgSeq AS rtSmgSeq
        //             FROM [TCNMSlipMsgDT_L] SMGDT
        //             WHERE 1=1 
        //             AND SMGDT.FNLngID = $nLngID
        //             AND SMGDT.FTSmgCode = '$tDstCode' ORDER BY SMGDT.FNSmgSeq";
        // $oDTQuery = $this->db->query($tDTSQL);

        if ($oHDQuery->num_rows() > 0) { // Have slip

            $oHDDetail = $oHDQuery->result();
            // $oDTDetail = $oDTQuery->result();

            // Prepare Head of receipt and End of receipt data
            // $aDTHeadItems = [];
            // $aDTEndItems = [];
            // foreach ($oDTDetail as $nIndex => $oItem) {
            //     if ($oItem->rtSmgType == 1) { // Head of receipt type
            //         $aDTHeadItems[] = $oItem->rtSmgName;
            //     }

            //     if ($oItem->rtSmgType == 2) { // End of receipt type
            //         $aDTEndItems[] = $oItem->rtSmgName;
            //     }
            // }

            // Found
            $aResult = array(
                'raHDItems'   => $oHDDetail[0],
                // 'raDTHeadItems' => $aDTHeadItems,
                // 'raDTEndItems' => $aDTEndItems,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            // Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality : List department
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCHNList($ptAPIReq, $ptMethodReq, $paData)
    {
        // return null;
        $aRowLen            = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID             = $paData['FNLngID'];
        $tWhereCondition    = "";

        if ($this->session->userdata("tSesUsrLevel") != "HQ") {

            $tSesUsrAgnCode = $this->session->userdata("tSesUsrAgnCode");
            if( $tSesUsrAgnCode != "" ){
                $tWhereCondition .= " AND CHNS.FTAgnCode = '$tSesUsrAgnCode' ";
            }

            $tBchCode = $this->session->userdata("tSesUsrBchCodeMulti");
            $tWhereCondition .= " AND ( CHNS.FTBchCode IN ($tBchCode) OR ISNULL(CHNS.FTBchCode,'') = '' ) ";

            $tWhereCondition .= " OR CHNS.FTChnCode IS NULL ";
        }

        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != '') {
            $tWhereCondition .= " AND (CHN.FTChnCode LIKE '%$tSearchList%' ";
            $tWhereCondition .= " OR CHNL.FTChnName LIKE '%$tSearchList%') ";
        }

        $tSQL1 = " SELECT c.* FROM( SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtChnCode DESC) AS rtRowID,* FROM ( ";
        $tSQL2 = " SELECT DISTINCT
                        CHN.FTChnCode   AS rtChnCode,
                        CHNL.FTChnName AS rtChnName,
                        CHNS.FTBchCode AS rtChnBchCode,
                        BCHL.FTBchName AS rtChnBchName,
                        CHNS.FTAgnCode AS rtChnAgnCode,
                        AGNL.FTAgnName AS rtChnAgnName,
                        CHN.FTAppCode AS rtChnAppCode,
                        APPL.FTAppName AS rtChnAppName,
                        CHN.FTPplCode AS rtChnPplCode,
                        PPLL.FTPplName AS rtChnPplName,
                        CHN.FTChnStaUse AS rtChnStaUse,
                        --    CHN.FTChnGroup AS rtChnGroup,
                        CHN.FTWahCode AS rtChnWahCode,
                        WAHL.FTWahName AS rtChnWahName,
                        CHN.FTChnRefCode AS rtChnRefCode,
                        CHN.FDCreateOn
                    FROM [TCNMChannel] CHN WITH(NOLOCK)
                    LEFT JOIN TCNMChannel_L       CHNL WITH(NOLOCK) ON CHN.FTChnCode = CHNL.FTChnCode
                    LEFT JOIN TCNMChannelSpc      CHNS WITH(NOLOCK) ON CHN.FTChnCode = CHNS.FTChnCode
                    LEFT JOIN TCNMAgency_L        AGNL WITH(NOLOCK) ON CHNS.FTAgnCode = AGNL.FTAgnCode
                    LEFT JOIN TCNMBranch_L        BCHL WITH(NOLOCK) ON CHNS.FTBchCode = BCHL.FTBchCode
                    LEFT JOIN TSysApp_L           APPL WITH(NOLOCK) ON CHN.FTAppCode = APPL.FTAppCode  AND APPL.FNLngID = $nLngID
                    LEFT JOIN TCNMPdtPriList_L    PPLL WITH(NOLOCK) ON CHN.FTPplCode = PPLL.FTPplCode
                    LEFT JOIN TCNMWaHouse_L       WAHL WITH(NOLOCK) ON CHNS.FTBchCode =  WAHL.FTBchCode AND CHN.FTWahCode = WAHL.FTWahCode AND WAHL.FNLngID = $nLngID
                    WHERE 1=1
                    $tWhereCondition
                 ";
        $tSQL3 = " ) Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";


        $tFullQuery  = $tSQL1.$tSQL2.$tSQL3;
        $tCountQuery = $tSQL2;
        // print_r($tSQL);

        $oQuery = $this->db->query($tFullQuery);
        if ( $oQuery->num_rows() > 0 ) {
            $oCount = $this->db->query($tSQL2);
            // $oList = $oQuery->result();
            // $aFoundRow = $this->FSnMCHNGetPageAll(/*$tWhereCode,*/$tSearchList, $nLngID);
            // $nFoundRow = $aFoundRow[0]->counts;
            $nFoundRow = $oCount->num_rows();
            $nPageAll  = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oQuery->result(),
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

    /**
     * Functionality : All Page Of Slip Message
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMCHNGetPageAll(/*$ptWhereCode,*/$ptSearchList, $ptLngID)
    {
        $tSQL = "SELECT COUNT (CHN.FTChnCode) AS counts
                FROM [TCNMChannel] CHN
                WHERE 1=1 ";
        //  AND CHN.FNLngID = $ptLngID";

        // if($ptSearchList != ''){
        //     $tSQL .= " AND (SMGHD.FTSmgCode LIKE '%$ptSearchList%'";
        //     $tSQL .= " OR SMGHD.FTSmgTitle  LIKE '%$ptSearchList%')";
        // }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }

    /**
     * Functionality : Checkduplicate
     * Parameters : $ptDstCode
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMCHNCheckDuplicate($ptChnCode)
    {
        $tSQL = "SELECT COUNT(FTChnCode) AS counts
                 FROM TCNMChannel
                 WHERE FTChnCode = '$ptChnCode'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    /**
     * Functionality : Update Slip Message
     * Parameters : $paData is data for update
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCHNAddUpdateHD($paData)
    {
        try {
            if ($paData['tTypeInsertUpdate'] == 'Update') {
                // Update
                $this->db->set('FTAppCode', $paData['FTAppCode']);
                $this->db->set('FTChnStaUse', $paData['FTChnStaUse']);
                $this->db->set('FTChnRefCode', $paData['FTChnRefCode']);
                $this->db->set('FTPplCode', $paData['FTPplCode']);
                $this->db->set('FTWahCode', $paData['FTWahCode']);
                $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
                $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
                $this->db->where('FTChnCode', $paData['FTChnCode']);
                $this->db->update('TCNMChannel');

                $this->db->set('FNLngID', $paData['FNLngID']);
                $this->db->set('FTChnName', $paData['FTChnName']);
                $this->db->where('FTChnCode', $paData['FTChnCode']);
                $this->db->update('TCNMChannel_L');

                if ($paData['FTAgnCode'] != '' || $paData['FTBchCode'] != '') {
                    $this->db->select('FTChnCode');
                    $this->db->from('TCNMChannelSpc');
                    $this->db->where('FTChnCode', $paData['FTChnCode']);
                    $oGetChn = $this->db->get();
                    $nDataChn = $oGetChn->num_rows();
                    if ($nDataChn > 0) {
                        $this->db->set('FTAgnCode', $paData['FTAgnCode']);
                        $this->db->set('FTAppCode', $paData['FTAppCode']);
                        $this->db->set('FTBchCode', $paData['FTBchCode']);
                        $this->db->where('FTChnCode', $paData['FTChnCode']);
                        $this->db->update('TCNMChannelSpc');
                    } else {
                        $this->db->insert('TCNMChannelSpc', array(
                            'FTChnCode'     => $paData['FTChnCode'],
                            'FTAgnCode'    => $paData['FTAgnCode'],
                            'FTAppCode'    => $paData['FTAppCode'],
                            'FNChnSeq'   => $paData['FNChnSeq'],
                            'FTBchCode'     => $paData['FTBchCode'],
                        ));
                    }
                }

                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Master Success',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Update Master.',
                    );
                }
            } else if ($paData['tTypeInsertUpdate'] == 'Insert') {
                // Insert
                $this->db->insert('TCNMChannel', array(
                    'FTChnCode'     => $paData['FTChnCode'],
                    'FTAppCode'    => $paData['FTAppCode'],
                    'FNChnSeq'   => $paData['FNChnSeq'],
                    'FTChnStaUse'   => $paData['FTChnStaUse'],
                    'FTChnRefCode'   => $paData['FTChnRefCode'],
                    'FTPplCode'     => $paData['FTPplCode'],
                    'FTWahCode'    => $paData['FTWahCode'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                    // 'FTChnGroup'   => $paData['FTChnGroup'],
                ));
                $this->db->insert('TCNMChannel_L', array(
                    'FTChnCode'     => $paData['FTChnCode'],
                    'FNLngID' => $paData['FNLngID'],
                    'FTChnName'    => $paData['FTChnName'],
                    'FTChnRmk'    => '',
                    // 'FTBchCode'     => $paData['FTBchCode'],
                ));

                if ($paData['FTAgnCode'] != '' || $paData['FTBchCode'] != '') {
                    $this->db->insert('TCNMChannelSpc', array(
                        'FTChnCode'     => $paData['FTChnCode'],
                        'FTAgnCode'    => $paData['FTAgnCode'],
                        'FTAppCode'    => $paData['FTAppCode'],
                        'FNChnSeq'   => $paData['FNChnSeq'],
                        'FTBchCode'     => $paData['FTBchCode'],
                    ));
                }

                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Master Success',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add Master.',
                    );
                }
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    /**
     * Functionality : Update Lang Slip Message
     * Parameters : $paData is data for update
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    // public function FSaMCHNAddUpdateDT($paData)
    // {
    //     try {
    //         // Add Detail
    //         $this->db->insert('TCNMSlipMsgDT_L', array(
    //             'FTSmgCode' => $paData['FTSmgCode'],
    //             'FTSmgType' => $paData['FTSmgType'],
    //             'FNLngID'   => $paData['FNLngID'],
    //             'FNSmgSeq'  => $paData['FNSmgSeq'],
    //             'FTSmgName' => $paData['FTSmgName']
    //         ));

    //         // Set Response status
    //         if ($this->db->affected_rows() > 0) {
    //             $aStatus = array(
    //                 'rtCode' => '1',
    //                 'rtDesc' => 'Add Lang Success',
    //             );
    //         } else {
    //             $aStatus = array(
    //                 'rtCode' => '905',
    //                 'rtDesc' => 'Error Cannot Add/Edit Lang.',
    //             );
    //         }

    //         // Response status
    //         return $aStatus;
    //     } catch (Exception $Error) {
    //         return $Error;
    //     }
    // }

    /**
     * Functionality : Delete Slip Message
     * Parameters : $paDataFSnMCHNDelHD
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMCHNDelHD($paData)
    {
        // $this->db->where_in('FTBchCode', $paData['FTBchCode']);
        $this->db->where_in('FTChnCode', $paData['FTChnCode']);
        $this->db->delete('TCNMChannel');

        // $this->db->where_in('FTBchCode', $paData['FTBchCode']);
        $this->db->where_in('FTChnCode', $paData['FTChnCode']);
        $this->db->delete('TCNMChannel_L');

        $this->db->where_in('FTChnCode', $paData['FTChnCode']);
        $this->db->delete('TCNMChannelSpc');

        if ($this->db->affected_rows() > 0) {
            // Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            // Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;

        // return $aStatus = array(
        //     'rtCode' => '1',
        //     'rtDesc' => 'success',
        // );
    }

    /**
     * Functionality : {description}
     * Parameters : {params}
     * Creator : dd/mm/yyyy piya
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    // public function FSnMCHNDelDT($paData)
    // {

    //     $this->db->where('FTSmgCode', $paData['FTSmgCode']);
    //     $this->db->delete('TCNMSlipMsgDT_L');

    //     /*if($this->db->affected_rows() > 0){
    //         // Success
    //         $aStatus = array(
    //             'rtCode' => '1',
    //             'rtDesc' => 'success',
    //         );
    //     }else{
    //         // Ploblem
    //         $aStatus = array(
    //             'rtCode' => '905',
    //             'rtDesc' => 'cannot Delete Item.',
    //         );
    //     }
    //     $jStatus = json_encode($aStatus);
    //     $aStatus = json_decode($jStatus, true);
    //     return $aStatus;*/

    //     return $aStatus = array(
    //         'rtCode' => '1',
    //         'rtDesc' => 'success',
    //     );
    // }



    //Functionality : get all row data from pdt location
    //Parameters : -
    //Creator : 1/04/2019 Pap
    //Return : array result from db
    //Return Type : array

    public function FSnMLOCGetAllNumRow()
    {
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMChannel";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        } else {
            $aResult = false;
        }
        return $aResult;
    }



    public function  FSaMChnDeleteMultiple($paDataDelete)
    {
        // print_r($paDataDelete); die();

        // $this->db->where_in('FTBchCode', $paDataDelete['FTBchCode']);
        $this->db->where_in('FTChnCode', $paDataDelete['FTChnCode']);
        $this->db->delete('TCNMChannel');


        // $this->db->where_in('FTBchCode', $paDataDelete['FTBchCode']);
        $this->db->where_in('FTChnCode', $paDataDelete['FTChnCode']);
        $this->db->delete('TCNMChannel_L');


        $this->db->where_in('FTChnCode', $paDataDelete['FTChnCode']);
        $this->db->delete('TCNMChannelSpc');


        if ($this->db->affected_rows() > 0) {
            //Success
            $aStatus   = array(
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

    //Functionality : Count Seq
    //Parameters : function parameters
    //Creator : 06/01/2021 Worakorn
    //Return : data
    //Return Type : Array
    public function FSnMChnCountSeq($ptAppCode)
    {
        $tSQL = "SELECT COUNT(FNChnSeq) AS counts
                FROM TCNMChannel
                WHERE FTAppCode = '$ptAppCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->row_array()["counts"];
        } else {
            return FALSE;
        }
    }
}
