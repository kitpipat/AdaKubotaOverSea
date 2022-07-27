<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Notification_model extends CI_Model {

    //ไปดึงข้อความมาจากฐานข้อมูล
    public function FSaMGetNotification(){
        try{

            $tBranchCom  =  $this->session->userdata('tSesUsrBchCom');
            $tUserName   =  $this->session->userdata('tSesUsername');
            $tUserCode   =  $this->session->userdata('tSesUserCode');


            $tSQL        ="	SELECT 
                            NI.FTMsgID,
                            NI.FTNtiContents,
                            NI.FDNtiSendDate,
                            NI.FTBchCode,
                            NI.FTNtiTopic,
                            NR.FTUsrCode
                            FROM TCNTNoti NI
                        LEFT JOIN TCNTNotiRead NR ON NI.FTNtiID = NR.FTNtiID AND  NR.FTUsrCode = '$tUserCode'
                        WHERE NR.FTUsrCode IS NULL 
                        AND NI.FTBchCode = '$tBranchCom'";
            $oQuery  =  $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $aResult = array(
                    'raItems'       => $aList,
                    'rtCode'        => '1',
                );
            }else{
                $aResult = array(
                    'rtCode' => '900',
                    'rtDesc' => 'data not found',
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }

    }

    //เพิ่มข้อความลงในฐานข้อมูล
    public function FSaMAddNotification($paData){
        $tContent =   $paData['FTNtiContents'];
        // Insert Table TCNTNoti
        $aResult   = array(
            'FTNtiID'         => $paData['FTNtiID'],
            'FTMsgID'         => $paData['FTMsgID'],
            'FTBchCode'       => $paData['FTBchCode'],
            'FDNtiSendDate'   => $paData['FDNtiSendDate'],
            'FTNtiTopic'      => $paData['FTNtiTopic'],
            'FTNtiContents'   => $tContent,
            'FTNtiUsrRole'    => $paData['FTNtiUsrRole'],
            'FDLastUpdOn'     => $paData['FDLastUpdOn'],
            'FTLastUpdBy'     => $paData['FTLastUpdBy'],
            'FDCreateOn'      => $paData['FDCreateOn'],
            'FTCreateBy'      => $paData['FTCreateBy']
        );

        $this->db->insert('TCNTNoti',$aResult);
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add Noti Success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Insert Noti.',
            );
        }
        return $aStatus;
    }

    //เช็คข้อความซ้ำ
    public function FSaMCheckNotiMsgID($paData){

        $tMsgID     = $paData['FTMsgID'];
        $tNtiID     = $paData['FTNtiID'];


        $tBranchCom  =  $this->session->userdata('tSesUsrBchCom');
        $tUserName   =  $this->session->userdata('tSesUsername');

        $tSQL       = "SELECT 
                            NOTI.FTNtiID
                       FROM [TCNTNoti] NOTI WITH(NOLOCK)
                       WHERE 1=1
                       AND NOTI.FTNtiID ='$tNtiID' 
                    ";
        $oQuery  =  $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDetail    = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            // IF data Not found
            $aResult = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //กดว่าอ่านแล้ว
    public function FSaMMoveDataTableNotiToTableRead(){
        try{
            $tBranchCom  = $this->session->userdata('tSesUsrBchCom');
            $tUserName   = $this->session->userdata('tSesUsername');
            $tUserCode   =  $this->session->userdata('tSesUserCode');

            $dDate       = date('Y-m-d H:i:s');
            $tSQL        = "INSERT INTO TCNTNotiRead (
                                FTNtiID, 
                                FTUsrCode, 
                                FDNtrReadDate
                            )
                            SELECT 
                                NOTI.FTNtiID , 
                                '$tUserName' AS FTUsrCode , 
                                '$dDate' AS FDNtrReadDate
                            FROM TCNTNoti NOTI  
                            LEFT JOIN TCNTNotiRead NOTR ON NOTI.FTNtiID = NOTR.FTNtiID AND NOTR.FTUsrCode = '$tUserCode'
                            WHERE ";
            $tSQL        .= "NOTI.FTBchCode = '$tBranchCom'";
            $tSQL        .= " AND NOTR.FTUsrCode IS NULL ";
            $this->db->query($tSQL);
        }catch(Exception $Error){
            echo $Error;
        }
    }

}