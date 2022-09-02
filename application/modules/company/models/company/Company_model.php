<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Company_model extends CI_Model{
    
    //Functionality : List Data Company
    //Parameters : function parameters
    //Creator : 20/04/2018 wasin(yoshi)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCMPList($ptAPIReq,$ptMethodReq,$paData){
        try{
            $nLngID     = $paData['FNLngID'];
            $nLevelUser = $this->session->tSesUserLevel;
        
            $tSQL = "SELECT
                        CIMG.FTImgObj       AS rtCmpImage,
                        RIMG.FTImgObj       AS rtCmpRteImage,
                        CMP.FTCmpCode       AS rtCmpCode,
                        CMPL.FTCmpName      AS rtCmpName,
                        BCHL.FTBchCode      AS rtCmpBchCode,
                        BCHL.FTBchName      AS rtCmpBchName,
                        BCH.FTBchStaHQ      AS rtCmpBchStaHQ,
                        CMPL.FTCmpShop      AS rtCmpShop,
                        CMPL.FTCmpDirector  AS rtCmpDirector,
                        CMP.FTCmpEmail      AS rtCmpEmail,
                        CMP.FTCmpFax        AS rtCmpFax,
                        CMP.FTCmpTel        AS rtCmpTel,
                        CMP.FTVatCode       AS rtVatCodeUse,
                        CMP.FTCmpRetInOrEx  AS rtCmpRetInOrEx,
                        CMP.FTCmpWhsInOrEx  AS rtCmpWhsInOrEx,
                        RTEL.FTRteCode      AS rtCmpRteCode,
                        RTEL.FTRteName      AS rtCmpRteName,
                        CYL.FTCtyCode       AS rtCmpCyCode,
                        CYL.FTCtyName       AS rtCmpCyName
                    FROM [TCNMComp] CMP
                    LEFT JOIN [TCNMComp_L]     CMPL ON CMP.FTCmpCode = CMPL.FTCmpCode  AND CMPL.FNLngID = $nLngID
                    LEFT JOIN [TCNMBranch_L]   BCHL ON CMP.FTBchCode = BCHL.FTBchCode  AND BCHL.FNLngID = $nLngID
                    LEFT JOIN [TCNMBranch]     BCH  ON CMP.FTBchCode = BCH.FTBchCode
                    LEFT JOIN [TFNMRate_L]     RTEL ON CMP.FTRteCode = RTEL.FTRteCode  AND RTEL.FNLngID = $nLngID
                    LEFT JOIN [TCNMImgObj]     CIMG ON CMP.FTCmpCode = CIMG.FTImgRefID AND CIMG.FTImgTable = 'TCNMComp'
                    LEFT JOIN [TCNMImgObj]     RIMG ON CMP.FTRteCode = CIMG.FTImgRefID AND CIMG.FTImgTable = 'TFNMRate'
                    LEFT JOIN [TCNMCountry_L]  CYL  ON CMP.FTCtyCode = CYL.FTCtyCode
            ";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0) {
                $oList = $oQuery->result();
                $aResult = array(
                    'raItems'   => $oList[0],
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
                $jResult = json_encode($aResult);
                $aResult = json_decode($jResult, true);
            }else{
                //No Data
                $aResult = array(
                    'raItems'   => '',
                    'rtCode'    => '800',
                    'rtDesc'    => 'data not found'
                );
                $jResult = json_encode($aResult);
                $aResult = json_decode($jResult, true);
            }
            return $aResult;
        }catch(Exception $Error){
            return $Error;
        }
    }
    
    //Functionality : Function Get Config Address
    //Parameters : 
    //Creator : 24/5/2018 wasin (yoshi)
    //Last Modified : -
    //Return : object
    //Return Type : object
    public function FSoMCMPGenViewAddress($ptSysCode,$ptSysKey){
        try{
            $tSQL = "SELECT 
                        TCF.FTSysStaDefValue AS rtStaDefValue,
                        TCF.FTSysStaUsrValue AS rtStaUsrValue
                    FROM [TSysConfig] TCF
                    WHERE FTSysCode = '$ptSysCode' AND FTSysKey = '$ptSysKey' ";
            
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            } else {
                //No Data
                return false;
            }
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Functionality : Function Get VateRate
    //Parameters : 
    //Creator : 07/08/2019 Saharat (Golf)
    //Last Modified : -
    //Return : object
    //Return Type : object
    public function FSoMCMPGetVatRate($ptVatCode){
        try{
            $tSQL   = " SELECT TOP 1
                            TVR.FTVatCode  AS rtVatCode,
                            TVR.FDVatStart AS rtVatStart,
                            TVR.FCVatRate  AS rtVatRate
                        FROM [TCNMVatRate] TVR
                        WHERE 1=1
                        AND TVR.FTVatCode = '$ptVatCode'
                        AND CONVERT(VARCHAR(19),GETDATE(),121) >= CONVERT(VARCHAR(19),TVR.FDVatStart,121)
                        ORDER BY TVR.FDVatStart DESC
            ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result_array();
            } else {
                //No Data
                return false;
            }
        }catch(Exception $Error){
            return $Error;
        }
    }
    
    //Functionality :Fuction Call Address 
    //Parameters : 
    //Creator : 23/05/2018 wasin
    //Update : 10/04/2019 pap
    //Last Modified : -
    //Return : Array Data Address
    //Return Type : Array
    public function FSaMCMPSelectAddressList($paData){
        $tRefCode   = $paData['FTAddRefCode'];
        $nLngID     = $paData['FNLngID'];
        $nAddGrp    = $paData['FTAddGrpType'];
        $nAddVer    = $paData['FTAddVersion'];
        $tSQL   =   "   SELECT
                            ROW_NUMBER() OVER(ORDER BY ADDL.FNAddSeqNo ASC) AS rtRowID,
                            ADDL.FNLngID            AS rtAddLngID,
                            ADDL.FTAddGrpType       AS rtAddGrpType,
                            ADDL.FTAddRefCode       AS rtAddRefCode,
                            ADDL.FNAddSeqNo         AS rtAddSeqNo,
                            ADDL.FTAddRefNo         AS rtAddRefNo,
                            ADDL.FTAddName          AS rtAddName,
                            ADDL.FTAddTaxNo         AS rtAddTaxNo,
                            ADDL.FTAddWebsite       AS rtAddWebsite,
                            ADDL.FTAddRmk           AS rtAddRmk,
                            ADDL.FTAddVersion       AS rtAddVersion
                        FROM [TCNMAddress_L] ADDL
                        WHERE 1=1
                        AND ADDL.FTAddGrpType   = '$nAddGrp'
                        AND ADDL.FNLngID        = '$nLngID'
                        AND ADDL.FTAddRefCode   = '$tRefCode' 
                        AND ADDL.FTAddVersion   = '$nAddVer'
        ";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result_array();
        }else{
            return array();
        }
    }

    //Functionality : Checkduplicate Data
    //Parameters : function parameters
    //Creator : 24/05/2018 wasin(Yoshi)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMCMPCheckduplicate($ptCmpCode){
        try{
            $tSQL = "SELECT COUNT(FTCmpCode)AS counts
                    FROM TCNMComp
                    WHERE FTCmpCode = '$ptCmpCode' ";

            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                return $oQuery->result();
            }else{
                return false;
            }
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Functionality : Function Add/Update Company
    //Parameters : function parameters
    //Creator :  24/05/2018 wasin(Yoshi)
    //Last Update : 03/07/2018 (Update Center Add/Update Master Company)
    //Return : data
    //Return Type : Array
    public function FSaMCMPAddUpdateMaster($paDataMaster){
        $tSQLUpd    = " UPDATE TCNMComp
                        SET
                            FTCmpTel        = '".$paDataMaster['FTCmpTel']."',
                            FTCmpFax        = '".$paDataMaster['FTCmpFax']."',
                            FTBchcode       = '".$paDataMaster['FTBchcode']."',
                            FTCmpWhsInOrEx  = '".$paDataMaster['FTCmpWhsInOrEx']."',
                            FTCmpRetInOrEx  = '".$paDataMaster['FTCmpRetInOrEx']."',
                            FTCmpEmail      = '".$paDataMaster['FTCmpEmail']."',
                            FTRteCode       = '".$paDataMaster['FTRteCode']."',
                            FTVatCode       = '".$paDataMaster['FTVatCode']."',
                            FDLastUpdOn     = GETDATE(),
                            FTLastUpdBy     = '".$paDataMaster['FTLastUpdBy']."',
                            FTCtyCode     = '".$paDataMaster['FTCtyCode']."'
                        WHERE 1=1 
                        AND  FTCmpCode = '".$paDataMaster['FTCmpCode']."'
        ";
        $oQueryUpd  = $this->db->query($tSQLUpd);
        if($this->db->affected_rows() == 0){
            $tSQLAdd    = " INSERT INTO TCNMComp (FTCmpCode,FTCmpTel,FTCmpFax,FTBchcode,FTCmpWhsInOrEx,FTCmpRetInOrEx,FTCmpEmail,FTRteCode,FTVatCode,FDCreateOn,FTCreateBy,FTCtyCode)
                            VALUES (
                                '".$paDataMaster['FTCmpCode']."',
                                '".$paDataMaster['FTCmpTel']."',
                                '".$paDataMaster['FTCmpFax']."',
                                '".$paDataMaster['FTBchcode']."',
                                '".$paDataMaster['FTCmpWhsInOrEx']."',
                                '".$paDataMaster['FTCmpRetInOrEx']."',
                                '".$paDataMaster['FTCmpEmail']."',
                                '".$paDataMaster['FTRteCode']."',
                                '".$paDataMaster['FTVatCode']."',
                                GETDATE(),
                                '".$paDataMaster['FTCreateBy']."',
                                '".$paDataMaster['FTCtyCode']."'
                            )
            ";
            $oQueryAdd  = $this->db->query($tSQLAdd);
        }
        return;
    }

    //Functionality : Function Add/Update Company_L
    //Parameters : function parameters
    //Creator :  24/05/2018 wasin(Yoshi)
    //Last Update : 03/07/2018 (Update Center Add/Update Master Company_L)
    //Return : data
    //Return Type : Array
    public function FSaMCMPAddUpdateLang($paDataMaster){
        $tSQLUpd    = " UPDATE TCNMComp_L
                        SET 
                            FTCmpName       = '".$paDataMaster['FTCmpName']."',
                            FTCmpShop       = '".$paDataMaster['FTCmpShop']."',
                            FTCmpDirector   = '".$paDataMaster['FTCmpDirector']."'
                        WHERE 1=1 AND FTCmpCode = '".$paDataMaster['FTCmpCode']."' AND FNLngID = '".$paDataMaster['FNLngID']."'
        ";
        $oQueryUpd  = $this->db->query($tSQLUpd);
        if($this->db->affected_rows() == 0){
            $tSQLAdd    = " INSERT INTO TCNMComp_L (FTCmpCode,FNLngID,FTCmpName,FTCmpShop,FTCmpDirector)
                            VALUES (
                                '".$paDataMaster['FTCmpCode']."',
                                '".$paDataMaster['FNLngID']."',
                                '".$paDataMaster['FTCmpName']."',
                                '".$paDataMaster['FTCmpShop']."',
                                '".$paDataMaster['FTCmpDirector']."'
                            )
            ";
            $oQueryAdd  = $this->db->query($tSQLAdd);
        }
        return;
    }

    //Functionality : Function Add/Update Address
	//Parameters : function parameters
    //Creator : 24/05/2018 wasin(Yoshi)
    //Update : 11/04/2019 pap
	//Last Update : 03/07/2018 (Update Center Add/Update Master Address)
	//Return : response
    //Return Type : Array
    public function FSaMCMPAddUpdateAddress($paData){
        try{
            //Update Address
            $this->db->set('FTAddTaxNo',$paData['FTAddTaxNo']);
            $this->db->set('FTAddCountry',$paData['FTAddCountry']);
            // $this->db->set('FTAreCode',$paData['FTAreCode']);
            // $this->db->set('FTZneCode',$paData['FTZneCode']);
            $this->db->set('FTAddV1No',$paData['FTAddV1No']);
            $this->db->set('FTAddV1Soi',$paData['FTAddV1Soi']);
            $this->db->set('FTAddV1Village',$paData['FTAddV1Village']);
            $this->db->set('FTAddV1Road',$paData['FTAddV1Road']);
            $this->db->set('FTAddV1SubDist',$paData['FTAddV1SubDist']);
            $this->db->set('FTAddV1DstCode',$paData['FTAddV1DstCode']);
            $this->db->set('FTAddV1PvnCode',$paData['FTAddV1PvnCode']);
            $this->db->set('FTAddCountry',$paData['FTAddCountry']);
            $this->db->set('FTAddV1PostCode',$paData['FTAddV1PostCode']);
            $this->db->set('FTAddV2Desc1',$paData['FTAddV2Desc1']);
            $this->db->set('FTAddV2Desc2',$paData['FTAddV2Desc2']);
            $this->db->set('FTAddWebsite',$paData['FTAddWebsite']);
            $this->db->set('FTAddLongitude',$paData['FTAddLongitude']);
            $this->db->set('FTAddLatitude',$paData['FTAddLatitude']);

            $this->db->set('FDLastUpdOn',$paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy',$paData['FTLastUpdBy']);
            $this->db->where('FTAddVersion', $paData['FTAddVersion']);
            $this->db->where('FTAddGrpType', $paData['FTAddGrpType']);
            $this->db->where('FTAddRefCode', $paData['FTAddRefCode']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->update('TCNMAddress_L');

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            }else{
                //Add Address
                $this->db->insert('TCNMAddress_L',array(
                    'FNLngID'           => $paData['FNLngID'],
                    'FTAddGrpType'      => $paData['FTAddGrpType'],
                    'FTAddRefCode'      => $paData['FTAddRefCode'],
                    'FTAddTaxNo'        => $paData['FTAddTaxNo'],
                    'FTAddCountry'      => $paData['FTAddCountry'],
                    // 'FTAreCode'         => $paData['FTAreCode'],
                    // 'FTZneCode'         => $paData['FTZneCode'],
                    'FTAddVersion'      => $paData['FTAddVersion'],
                    'FTAddV1No'         => $paData['FTAddV1No'],
                    'FTAddV1Soi'        => $paData['FTAddV1Soi'],
                    'FTAddV1Village'    => $paData['FTAddV1Village'],
                    'FTAddV1Road'       => $paData['FTAddV1Road'],
                    'FTAddV1DstCode'    => $paData['FTAddV1DstCode'],
                    'FTAddV1PvnCode'    => $paData['FTAddV1PvnCode'],
                    'FTAddCountry'      => $paData['FTAddCountry'],
                    'FTAddV1PostCode'   => $paData['FTAddV1PostCode'],
                    'FTAddV2Desc1'      => $paData['FTAddV2Desc1'],
                    'FTAddV2Desc2'      => $paData['FTAddV2Desc2'],
                    'FTAddWebsite'      => $paData['FTAddWebsite'],
                    'FTAddLongitude'    => $paData['FTAddLongitude'],
                    'FTAddLatitude'     => $paData['FTAddLatitude'],
                    // 'FDCreateOn'        => $paData['FDCreateOn'],
                    'FTCreateBy'        => $paData['FTCreateBy']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success',
                    );
                }else{
                    //Error 
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Address.',
                    );
                }
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Functionality : List Data Name Company
    //Parameters : function parameters
    //Creator : 24/07/2019 saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCMPGetName($paData){
        try{
            $nLngID     = $paData['FNLngID'];
            $tSQL = "SELECT
                        CMPL.FTCmpName      AS rtCmpName
                    FROM [TCNMComp] CMP
                    LEFT JOIN [TCNMComp_L]     CMPL ON CMP.FTCmpCode = CMPL.FTCmpCode  AND CMPL.FNLngID = $nLngID
            ";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0) {
                $oList = $oQuery->result();
                $aResult = array(
                    'raItems'   => $oList[0],
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
                $jResult = json_encode($aResult);
                $aResult = json_decode($jResult, true);
            }else{
                //No Data
                $aResult = array(
                    'raItems'   => '',
                    'rtCode'    => '800',
                    'rtDesc'    => 'data not found'
                );
                $jResult = json_encode($aResult);
                $aResult = json_decode($jResult, true);
            }
            return $aResult;
        }catch(Exception $Error){
            return $Error;
        }
    }


    //Functionality : Function Update Branch
    //Parameters : function parameters
    //Creator :  31/07/2019 Saharat(Golf)
    //Return : data
    //Return Type : Array
    public function FSaMCMPAddUpdateMasterBch($paData){ 
        try{
            $Result = $this->FSaMCMPAddBchUpdate($paData);
            if($Result['rtCode'] == 1){
                $this->db->set('FTBchStaHQ' ,1);
                $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
                $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
                $this->db->where('FTBchcode', $paData['FTBchcode']);
                $this->db->update('TCNMBranch');
            }

            //Update Branch   
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            }
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Success',
                );
            }else{
                    //Error 
                    $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master.',
                );
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Functionality : Function Update Branch
    //Parameters : function parameters
    //Creator :  31/07/2019 Saharat(Golf)
    //Return : data
    //Return Type : Array
    public function FSaMCMPAddBchUpdate($paData){
        try{
            //Update Branch
            $StaHQ = '' ;
            $this->db->set('FTBchStaHQ' , $StaHQ);
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->update('TCNMBranch');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Success',
                );
            }else{
                    //Error 
                    $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master.',
                );
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }


    /**
     * Functionality : Get Company Info
     * Parameters : function parameters
     * Creator :  31/07/2019 Piya
     * Return : data
     * Return Type : Array
     */
    public function FSaMCMPGetCompanyInfo($paParams = []){
        $nLangID = $paParams['nLngID'];
        $tAgnCode = $paParams['tAgnCode'];
    
        if(isset($paParams['tBchCode']) && !empty($paParams['tBchCode'])){
            $tBchCodeSql = "'".$paParams['tBchCode']."'";
        }else{
            $tBchCodeSql = "COMP.FTBchCode";
        }
        
        $tSQL = "
            SELECT TOP 1
                COMP.FTBchcode,
                COMP.FTCmpCode,
                COMP.FTCmpEmail,
                COMP.FTCmpFax,
                COMP.FTCmpTel,
                COMPL.FTCmpName,
                BCHL.FTBchName,
                ADDL.*,
                PROVL.FTPvnName,
                DISTL.FTDstName,
                SUBDISTL.FTSudName

            FROM TCNMComp COMP WITH (NOLOCK)
            LEFT JOIN TCNMComp_L COMPL WITH (NOLOCK) ON COMPL.FTCmpCode = COMP.FTCmpCode AND COMPL.FNLngID = $nLangID 
            LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON BCHL.FTBchCode = $tBchCodeSql AND BCHL.FNLngID = $nLangID
            LEFT JOIN TCNMAddress_L ADDL WITH (NOLOCK) ON ADDL.FTAddRefCode = $tBchCodeSql AND ADDL.FTAddRefNo = '1' AND ADDL.FTAddGrpType = '1' AND ADDL.FNLngID = $nLangID
            LEFT JOIN TCNMProvince_L PROVL WITH (NOLOCK) ON PROVL.FTPvnCode = ADDL.FTAddV1PvnCode AND PROVL.FNLngID = $nLangID
            LEFT JOIN TCNMDistrict_L DISTL WITH (NOLOCK) ON DISTL.FTDstCode = ADDL.FTAddV1DstCode AND DISTL.FNLngID = $nLangID
            LEFT JOIN TCNMSubDistrict_L SUBDISTL WITH (NOLOCK) ON SUBDISTL.FTSudCode = ADDL.FTAddV1SubDist AND SUBDISTL.FNLngID = $nLangID
        ";
        
        $oQuery = $this->db->query($tSQL);
        
        if($oQuery->num_rows() > 0) {
            $aItems = $oQuery->row_array();
            $aResult = array(
                'raItems'       => $aItems,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else {
            // No Data
            $aResult = array(
                'raItems' => [],
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality : Get Company Info
     * Parameters : function parameters
     * Creator :  31/07/2019 Piya
     * Return : data
     * Return Type : Array
     */
    public function FSaMCMPGetLanFromAgn($ptAgnCode,$tnLangID){

        $tSQLGetCty = "
            SELECT TOP 1
                AGN.FTAgnCode,
                AGN.FTCtyCode
            FROM TCNMAgency AGN WITH (NOLOCK)
            WHERE AGN.FTAgnCode = '$ptAgnCode'
        ";
        $oQueryGetCty = $this->db->query($tSQLGetCty);
        $aItemsGetCty = $oQueryGetCty->row_array();
        $tCtyCode = $aItemsGetCty['FTCtyCode'];
        
        if(isset($tCtyCode) && !empty($tCtyCode)){
                $tSQLGetLan = "
                SELECT TOP 1
                    CTY.FNLngID
                FROM TCNMCountry CTY WITH (NOLOCK)
                WHERE CTY.FTCtyCode = '$tCtyCode'
            ";
            $oQueryGetLan = $this->db->query($tSQLGetLan);
            $aItemsGetLan = $oQueryGetLan->row_array();
            $nLangID = $aItemsGetLan['FNLngID'];
        }

        if($nLangID == ''){
            $nLangID = $tnLangID;
        }

        return $nLangID;
    }

    /**
     * Functionality : Get Language
     * Parameters : function parameters
     * Creator :  31/07/2019 Piya
     * Return : data
     * Return Type : Array
     */
    public function FSaMCMPGetLanguage($paParams = []){
        $nLangID = $paParams['nLngID'];
        $tAgnCode = $paParams['tAgnCode'];

        if(isset($paParams['tAgnCode']) && !empty($paParams['tAgnCode'])){
            $tSQLGetCty = "
                SELECT TOP 1
                    AGN.FTAgnCode,
                    AGN.FTCtyCode
                FROM TCNMAgency AGN WITH (NOLOCK)
                WHERE AGN.FTAgnCode = '$tAgnCode'
            ";
            $oQueryGetCty = $this->db->query($tSQLGetCty);
            $aItemsGetCty = $oQueryGetCty->row_array();
            $tCtyCode = $aItemsGetCty['FTCtyCode'];
            
            if(isset($tCtyCode) && !empty($tCtyCode)){
                    $tSQLGetLan = "
                    SELECT TOP 1
                        LAN.FNLngID
                    FROM TSysLanguage LAN WITH (NOLOCK)
                    WHERE LAN.FTLngStaLocal = '1' AND LAN.FTLngStaUse = '1' AND LAN.FTCtyCode = '$tCtyCode';
                ";
                $oQueryGetLan = $this->db->query($tSQLGetLan);
                $aItemsGetLan = $oQueryGetLan->row_array();
                $nLangID = $aItemsGetLan['FNLngID'];
            }
        }else{
            $nLangID = $paParams['nLngID'];
        }

        if($nLangID == ''){
            $nLangID = $paParams['nLngID'];
        }
        // print_r($nLangID);

        
        if(isset($paParams['tBchCode']) && !empty($paParams['tBchCode'])){
            $tBchCodeSql = "'".$paParams['tBchCode']."'";
        }else{
            $tBchCodeSql = "COMP.FTBchCode";
        }
        
        $tSQL = "
            SELECT TOP 1
                COMP.FTBchcode,
                COMP.FTCmpCode,
                COMP.FTCmpEmail,
                COMP.FTCmpFax,
                COMP.FTCmpTel,
                COMPL.FTCmpName,
                BCHL.FTBchName,
                ADDL.*,
                PROVL.FTPvnName,
                DISTL.FTDstName,
                SUBDISTL.FTSudName

            FROM TCNMComp COMP WITH (NOLOCK)
            LEFT JOIN TCNMComp_L COMPL WITH (NOLOCK) ON COMPL.FTCmpCode = COMP.FTCmpCode AND COMPL.FNLngID = $nLangID 
            LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON BCHL.FTBchCode = $tBchCodeSql AND BCHL.FNLngID = $nLangID
            LEFT JOIN TCNMAddress_L ADDL WITH (NOLOCK) ON ADDL.FTAddRefCode = $tBchCodeSql AND ADDL.FTAddRefNo = '1' AND ADDL.FTAddGrpType = '1' AND ADDL.FNLngID = $nLangID
            LEFT JOIN TCNMProvince_L PROVL WITH (NOLOCK) ON PROVL.FTPvnCode = ADDL.FTAddV1PvnCode AND PROVL.FNLngID = $nLangID
            LEFT JOIN TCNMDistrict_L DISTL WITH (NOLOCK) ON DISTL.FTDstCode = ADDL.FTAddV1DstCode AND DISTL.FNLngID = $nLangID
            LEFT JOIN TCNMSubDistrict_L SUBDISTL WITH (NOLOCK) ON SUBDISTL.FTSudCode = ADDL.FTAddV1SubDist AND SUBDISTL.FNLngID = $nLangID
        ";
        
        $oQuery = $this->db->query($tSQL);
        
        if($oQuery->num_rows() > 0) {
            $aItems = $oQuery->row_array();
            $aResult = array(
                'raItems'       => $aItems,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else {
            // No Data
            $aResult = array(
                'raItems' => [],
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }
    
    // Functionality : Get Company Code
    // Parameters : function parameters
    // Creator :  31/07/2019 Piya
    // Return : data
    // Return Type : Array
    public function FSaMCMPGetCompanyCode(){
        
        $tSQL = "
            SELECT TOP 1
                COMP.FTCmpCode
            FROM TCNMComp COMP WITH (NOLOCK)
        ";
        
        $oQuery = $this->db->query($tSQL);
        
        if($oQuery->num_rows() > 0) {
            $aItems = $oQuery->row_array();
            $aResult = array(
                'raItems' => $aItems,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else {
            $aItems = false;
            // No Data
            $aResult = array(
                'raItems' => $aItems,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    // Functionality : Get Company Bch Code
    // Parameters : function parameters
    // Creator :  31/07/2019 Piya
    // Return : data
    // Return Type : Array
    public function FSaMCMPGetCompanyBchCode(){
        
        $tSQL = "
            SELECT TOP 1
                COMP.FTBchCode
            FROM TCNMComp COMP WITH (NOLOCK)
        ";
        
        $oQuery = $this->db->query($tSQL);
        
        if($oQuery->num_rows() > 0) {
            $aItems = $oQuery->row_array();
            $aResult = array(
                'raItems' => $aItems,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else {
            $aItems = false;
            // No Data
            $aResult = array(
                'raItems' => $aItems,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    // Functionality : Get Data Address 
    // Parameters : Ajax Parameter
    // Creator :  06/09/2019 Wasin(Yoshi)
    // Return : Data Address
    // Return Type : Array
    public function FSaMGetDataAddress($paDataAddrWhere){
        $tSQL   = " SELECT DISTINCT
                        ADDR.FNLngID,
                        ADDR.FTAddGrpType,
                        ADDR.FTAddRefCode,
                        ADDR.FNAddSeqNo,
                        ADDR.FTAddRefNo,
                        ADDR.FTAddName,
                        ADDR.FTAddTaxNo,
                        ADDR.FTAddRmk,
                        ADDR.FTAddCountry,
                        ADDR.FTAddVersion,
                        ADDR.FTAddV1No,
                        ADDR.FTAddV1Soi,
                        ADDR.FTAddV1Village,
                        ADDR.FTAddV1Road,
                        ADDR.FTAddV1SubDist AS FTSudCode,
                        SUDL.FTSudName,
                        ADDR.FTAddV1DstCode AS FTDstCode,
                        DSTL.FTDstName,
                        ADDR.FTAddV1PvnCode AS FTPvnCode,
                        PVNL.FTPvnName,
                        ADDR.FTAddV1PostCode,
                        ADDR.FTAddV2Desc1,
                        ADDR.FTAddV2Desc2,
                        ADDR.FTAddWebsite,
                        ADDR.FTAddLongitude,
                        ADDR.FTAddLatitude

                    FROM TCNMAddress_L          ADDR WITH(NOLOCK)
                    LEFT JOIN TCNMSubDistrict_L SUDL WITH(NOLOCK) ON ADDR.FTAddV1SubDist = SUDL.FTSudCode AND SUDL.FNLngID = '".$paDataAddrWhere['FNLngID']."'
                    LEFT JOIN TCNMDistrict_L    DSTL WITH(NOLOCK) ON ADDR.FTAddV1DstCode = DSTL.FTDstCode AND DSTL.FNLngID = '".$paDataAddrWhere['FNLngID']."'
                    LEFT JOIN TCNMProvince_L    PVNL WITH(NOLOCK) ON ADDR.FTAddV1PvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = '".$paDataAddrWhere['FNLngID']."'
                    WHERE 1=1
                    AND ADDR.FNLngID        = '".$paDataAddrWhere['FNLngID']."'
                    AND ADDR.FTAddGrpType   = '".$paDataAddrWhere['FTAddGrpType']."'
                    AND ADDR.FTAddRefCode   = '".$paDataAddrWhere['FTAddRefCode']."'
                    AND ADDR.FNAddSeqNo     = '".$paDataAddrWhere['FNAddSeqNo']."'
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return array();
        }
    }
}
















