<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mInterfaceExport extends CI_Model {
    
    public function FSaMIFXGetHD($pnLang){
        $tSQL = "   SELECT 
                        API.FTApiCode,
                        API_L.FTApiName
                    FROM TCNMTxnAPI API WITH(NOLOCK) 
                    LEFT JOIN TCNMTxnAPI_L API_L ON API.FTApiCode = API_L.FTApiCode AND API_L.FNLngID = $pnLang
                    WHERE 1=1 
                    AND API.FTApiTxnType = '2' 
                    AND ISNULL(API_L.FTApiName,'') != ''
                    ORDER BY API_L.FTApiName ASC
                ";

        $oQuery     = $this->db->query($tSQL);
        $aResult    = $oQuery->result_array();
        return $aResult;
    }


    //Get Data TLKMConfig  
    public function FSaMINMGetDataConfig(){
    $tSQL = " SELECT  *
                FROM TLKMConfig WITH(NOLOCK)
                LEFT JOIN TLKMConfig_L ON TLKMConfig.FTCfgCode = TLKMConfig_L.FTCfgCode AND TLKMConfig_L.FNLngID = 1
                WHERE TLKMConfig.FTCfgKey = 'Noti'
                AND TLKMConfig_L.FTCfgSeq = '2'
                AND TLKMConfig.FTCfgSeq = '2' 
             ";

        $oQuery     = $this->db->query($tSQL);

        $aResult    = $oQuery->result_array();
        return $aResult;
    }


       //Get Data DocNo
       public function FSaMINMGetDataDocNo($ptDocNoFrom,$ptDocNoTo){
        $tSQL = " SELECT  FTXshDocNo
                    FROM TPSTSalHD WITH(NOLOCK)
                    WHERE FTXshDocNo BETWEEN '$ptDocNoFrom' AND '$ptDocNoTo'
                 ";
    
            $oQuery     = $this->db->query($tSQL);
        
    
            $aResult    = $oQuery->result_array();
            return $aResult;
        }

        public function FSaMINMGetLogHisError(){

          $tSql ="SELECT
          LKH.FTLogTaskRef,
          SHD.FTBchCode
          
          FROM
          dbo.TLKTLogHis AS LKH
          LEFT OUTER JOIN TPSTSalHD SHD ON LKH.FTLogTaskRef = SHD.FTXshDocNo
          WHERE
          LKH.FTLogType = 2 AND
          LKH.FTLogStaPrc = 2
          ";

          $oQuery     = $this->db->query($tSql);
    
          $aResult    = $oQuery->result_array();
          return $aResult;
        }
   
}


