<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class mCommon extends CI_Model {
    //Functionality : Function Update Password User Login
    //Parameters : usrlogin , oldpass , newpass
    //Creator : 13/05/2020 Napat(Jame)
    //Last Modified : -
    //Return : Status Update Password
    //Return Type : Array
    public function FCNaMCMMChangePassword($paPackData){
        try{
            // ถ้าส่ง parameters UsrStaActive = 3 คือ เปลี่ยนรหัสผ่าน ครั้งแรก
            // ให้ปรับสถานะ = 1 เพื่อเริ่มใช้งาน
            if($paPackData['nChkUsrSta'] == 3){
                $this->db->set('FTUsrStaActive'  , '1');
            }

            $this->db->set('FTUsrLoginPwd'  , $paPackData['tPasswordNew']);
            $this->db->where('FTUsrLogin'  , $paPackData['FTUsrLogin']);
            $this->db->where('FTUsrLoginPwd'  , $paPackData['tPasswordOld']);
            $this->db->update('TCNMUsrLogin');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'nCode'     => 1,
                    'tDesc'     => 'Update Password Success',
                );
            }else{
                $aStatus = array(
                    'nCode'     => 905,
                    'tDesc'     => 'Error Cannot Update Password.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Delete
    public function FCNaMCMMDeleteTmpExcelCasePDT($paPackData){
        try{    
            $aWhere = array('TCNMPDT','TCNMPdtUnit','TCNMPdtBrand','TCNMPdtTouchGrp');
            $this->db->where_in('FTTmpTableKey' , $aWhere);
            $this->db->where_in('FTSessionID'   , $paPackData['tSessionID']);
            $this->db->delete($paPackData['tTableNameTmp']); 
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Import Excel To Temp
    public function FCNaMCMMImportExcelToTmp($paPackData,$poIns){
        try{    
            $tTableNameTmp      = $paPackData['tTableNameTmp'];
            $tNameModule        = $paPackData['tNameModule'];
            $tTypeModule        = $paPackData['tTypeModule']; 
            $tFlagClearTmp      = $paPackData['tFlagClearTmp']; 
            $tTableRefPK        = $paPackData['tTableRefPK']; 

            //ลบข้อมูลทั้งหมดก่อน
            if($tTypeModule == 'document' && $tFlagClearTmp == 1){
                //ลบช้อมูลของ document
                $this->db->where_in('FTXthDocKey'   , $tTableRefPK);
                $this->db->where_in('FTSessionID'   , $paPackData['tSessionID']);
                $this->db->delete($tTableNameTmp);
            }else if($tTypeModule == 'master'){
                //ลบข้อมูลของ master
                if($tNameModule != 'product'){
                    $this->db->where_in('FTTmpTableKey' , $tTableRefPK);
                    $this->db->where_in('FTSessionID'   , $paPackData['tSessionID']);
                    $this->db->delete($tTableNameTmp);  
                }
            }
           
            //เพิ่มข้อมูล
            $this->db->insert_batch($tTableNameTmp, $poIns);

            /*เพิ่มข้อมูล
             $tNameProject   = explode('/', $_SERVER['REQUEST_URI'])[1];
             $tPathFileBulk  = $_SERVER['DOCUMENT_ROOT'].'/'.$tNameProject.'/application/modules/common/assets/writeFileImport/FileImport_Branch.txt';
             $tSQL = "BULK INSERT dbo.TCNTImpMasTmp FROM '".$tPathFileBulk."'
                     WITH
                     (
                         FIELDTERMINATOR=',',
                         ROWTERMINATOR = '\n'
            )";*/
        }catch(Exception $Error){
            return $Error;
        }
    }
}