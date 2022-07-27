<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mMenu extends CI_Model {

    //Function : Get Menu Module
    //creater : Krit(Copter)
    //edit : 19/03/2019 Krit(Copter)
    public function FSaMMENUGetMenuGrpModulesName($tUsrID,$pnLngID){
        $tSQL   = " SELECT
                        TSM.FTGmnModCode,
                        TSM.FNGmnModShwSeq,
                        TSM.FTGmnModStaUse,
                        TSM.FTGmmModPathIcon,
                        TSM.FTGmmModColorBtn,
                        TSM_L.FTGmnModName
                    FROM TSysMenuGrpModule TSM
                    LEFT JOIN TSysMenuGrpModule_L TSM_L ON TSM.FTGmnModCode = TSM_L.FTGmnModCode AND TSM_L.FNLngID = $pnLngID 
                    INNER JOIN (	
                        SELECT MENULIST.FTGmnModCode FROM TCNTUsrMenu MENU
                        INNER JOIN TCNMUsrActRole ACT ON MENU.FTRolCode = ACT.FTRolCode
                        INNER JOIN TSysMenuList MENULIST ON MENU.FTGmnCode = MENULIST.FTGmnCode
                                                        AND MENU.FTMnuParent = MENULIST.FTMnuParent
                                                        AND MENU.FTMnuCode = MENULIST.FTMnuCode
                                                        AND MENULIST.FTMnuStaUse = 1
                        WHERE ACT.FTUsrCode = '$tUsrID' AND MENU.FTAutStaRead = 1
                        GROUP BY MENULIST.FTGmnModCode ) MENUROLE ON MENUROLE.FTGmnModCode = TSM.FTGmnModCode
                    WHERE TSM.FTGmmModPathIcon != '' AND FTGmnModStaUse = 1

                    UNION ALL

                    SELECT 
                        TSM.FTGmnModCode, 
                        TSM.FNGmnModShwSeq, 
                        TSM.FTGmnModStaUse, 
                        TSM.FTGmmModPathIcon, 
                        TSM.FTGmmModColorBtn, 
                        TSM_L.FTGmnModName
                    FROM TSysMenuGrpModule TSM
                    LEFT JOIN TSysMenuGrpModule_L TSM_L ON TSM.FTGmnModCode = TSM_L.FTGmnModCode AND TSM_L.FNLngID = 1
                    WHERE TSM.FTGmmModPathIcon != '' AND TSM.FTGmnModStaUse = 1 AND TSM.FTGmnModCode = 'FAV'

                    ORDER BY TSM.FNGmnModShwSeq ASC ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result_array();
        }else{
            return false;
        }
    }       
    // Function : GetDataMenu
    public function FSoMMENUGetMenuList($tUsrID,$pnLngID){

        $tSqlRole = "SELECT FTRolCode FROM TCNMUsrActRole  WHERE FTUsrCode = '$tUsrID'";
        $query  = $this->db->query($tSqlRole); 

        $aRole = $query->result_array();
        // print_r($aRole);
        $nCount = count($aRole);
        $tRoleCode = '';
        if(!empty($aRole)){
            $nK = 1;
            foreach($aRole AS $aData){
                $tRoleCode .=$aData['FTRolCode'];
                if($nCount!=$nK){
                  $tRoleCode .= ",";
                }
                $nK++;
            }
        }

        if($tRoleCode == '' || $tRoleCode == null){
            $tRoleCode = '00000';
        }else{
            $tRoleCode = $tRoleCode;
        }
       
        $tSQL   =   "  SELECT  
                                MenuGrpModule.FNGmnModShwSeq,
                                MENUGRP.FNGmnShwSeq,
                                USR.FTUsrCode, 
                                MENULIST.FTGmnModCode, 
                                MenuGrpModule_L.FTGmnModName, 
                                USRMENU.FTGmnCode, 
                                MENUGRP_L.FTGmnName, 
                                USRMENU.FTMnuParent, 
                                USRMENU.FTMnuCode, 
                                MENULIST_L.FTMnuName, 
                                MENULIST.FNMnuSeq, 
                                MENULIST.FNMnuLevel, 
                                MENULIST.FTMnuCtlName, 
                                MAC.FNCounts,
                                USRMENU.FTAutStaFull, 
                                USRMENU.FTAutStaRead
                        FROM TCNMUser USR

                            LEFT JOIN (SELECT DISTINCT 
                                USRMENUSUB.FTGmnCode, 
                                USRMENUSUB.FTMnuParent, 
                                USRMENUSUB.FTMnuCode,
                                USRMENUSUB.FTAutStaFull, 
                                USRMENUSUB.FTAutStaRead, 
                                '$tUsrID' AS UsrCode  
                            FROM TCNTUsrMenu USRMENUSUB  
                            WHERE USRMENUSUB.FTRolCode IN($tRoleCode)) 
                            USRMENU ON USRMENU.UsrCode = USR.FTUsrCode
                            INNER JOIN TSysMenuList MENULIST ON USRMENU.FTGmnCode = MENULIST.FTGmnCode
                                                                AND USRMENU.FTMnuParent = MENULIST.FTMnuParent
                                                                AND USRMENU.FTMnuCode = MENULIST.FTMnuCode
                                                                AND MENULIST.FTMnuStaUse = 1
                            LEFT JOIN TSysMenuList_L MENULIST_L ON MENULIST.FTMnuCode = MENULIST_L.FTMnuCode
                                                                    AND MENULIST_L.FNLngID = '$pnLngID'
                            LEFT JOIN TSysMenuGrpModule MenuGrpModule ON MENULIST.FTGmnModCode = MenuGrpModule.FTGmnModCode
                            LEFT JOIN TSysMenuGrpModule_L MenuGrpModule_L ON MenuGrpModule.FTGmnModCode = MenuGrpModule_L.FTGmnModCode
                                                                            AND MenuGrpModule_L.FNLngID = '$pnLngID'
                            LEFT JOIN TSysMenuGrp MENUGRP ON USRMENU.FTGmnCode = MENUGRP.FTGmnCode
                                                            AND MenuGrpModule_L.FTGmnModCode = MENUGRP.FTGmnModCode
                            LEFT JOIN TSysMenuGrp_L MENUGRP_L ON MENUGRP.FTGmnCode = MENUGRP_L.FTGmnCode
                                                                AND MENUGRP_L.FNLngID = '$pnLngID'
                        
                            LEFT JOIN
                        (
                            SELECT MEU.FTMnuParent, 
                                    COUNT(DT.FTAutStaRead) AS FNCounts
                            FROM TCNTUsrMenu DT
                                LEFT JOIN TSysMenuList MEU ON DT.FTMnuCode = MEU.FTMnuCode
                                                                AND (DT.FTAutStaRead = 1
                                                                    OR DT.FTAutStaFull = 1)
                            GROUP BY MEU.FTMnuParent
                        ) AS MAC ON USRMENU.FTMnuCode = MAC.FTMnuParent
                        WHERE 1 = 1
                        
                            AND (USRMENU.FTAutStaRead = 1
                                    OR USRMENU.FTAutStaFull = 1) ";

                        if(isset($tUsrID) && !empty($tUsrID)) {
                            $tSQL .= " AND USR.FTUsrCode = '$tUsrID'";
                        }

                        $tSQL .= "  ORDER BY
                                    MenuGrpModule.FNGmnModShwSeq ASC, 
                                    MENUGRP.FNGmnShwSeq ASC,  
                                    MENULIST.FNMnuSeq ASC ";
        // print_r('<pre>');
        // print_r($tSQL);
        // print_r('</pre>');         
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
                //No Data
            return false;
        }
    }

}




