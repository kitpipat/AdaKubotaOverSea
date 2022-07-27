<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Home_controller extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->helper('url');
        $this->load->library ( "session" );			
        if(@$_SESSION['tSesUsername'] == false) {
            redirect ( 'login', 'refresh' );
            exit ();
        }
        $this->load->model('common/Menu_model');
        $this->load->model('favorite/favorite/Favorites_model');

        $this->load->model('common/Notification_model');
    }

    public function index($nMsgResp = ''){
        $nMsgResp   = array('title' => "Home");
		$this->load->view ('common/wHeader',$nMsgResp);
		$this->load->view ('common/wTopBar',array('nMsgResp'=> $nMsgResp));
        $tUsrID         =   $this->session->userdata("tSesUsername");
        $nLngID         =   $this->session->userdata("tLangID");
        $nOwner         =  $this->session->userdata('tSesUserCode');
        $aMenuFav =  $this->Favorites_model->FSaFavGetdataList($nOwner,$nLngID);
        if(isset($nLngID) && !empty($nLngID)){
            $nLngID = $this->session->userdata("tLangID");
        }else{
            $nLngID = 1;
        }
        $oGrpModules    =   $this->Menu_model->FSaMMENUGetMenuGrpModulesName($tUsrID,$nLngID);

        $oMenuList 	    =   $this->Menu_model->FSoMMENUGetMenuList($tUsrID,$nLngID);

        //ไปหา exchang ถ้ายังไม่มีต้องสร้าง exchang
        // Create By Witsarut 03/03/2020
        $aMQParams = [
            "queuesname"    => "CN_QNotiMsg".$this->session->userdata('tSesUsrBchCom').$this->session->userdata('tSesSessionID'),
            "exchangname"   => "CN_XNotiMsg".$this->session->userdata('tSesUsrBchCom'),
            "params" => [
                'ptFunction'    => "",
                'ptSource'      => "",
                'ptDest'        => "",
                'ptFilter'      => "",
                'ptFTNotiId'    => "",
                'ptFTTopic'     => "",
                'ptFDSendDate'  => "",
                'ptFTUsrRole'   => "",
                'ptFTSubTopic'  => "",
                'ptFTMsg'       => "",
                'ptFTSubTopic'  => "",
                'ptFTMsg'       => ""      
            ]
        ];
       // FCNxDeclearExchangeStatDosenotification($aMQParams);

        //  *****************************************************

        // $oMenu           =   $this->Menu_model->FSaMMENUGetMenuListByUsrMenuName($tUsrID,$nLngID,'POS');
	    // $oMenuTIK 	    =   $this->Menu_model->FSaMMENUGetMenuListByUsrMenuName($tUsrID,$nLngID,'TIK');
        // $oMenuRPT 	    =   $this->Menu_model->FSaMMENUGetMenuListByUsrMenuName($tUsrID,$nLngID,'RPT');
        // $oMenuVED 	    =   $this->Menu_model->FSaMMENUGetMenuListByUsrMenuName($tUsrID,$nLngID,'VED');
      
        $this->load->view ('common/wMenu',array(
            
            'aMenuFav'	    => $aMenuFav,
            'nMsgResp'	    => $nMsgResp,
            'oGrpModules'   => $oGrpModules,
            'oMenuList'     => $oMenuList,
            // 'oMenu'      => $oMenu,
            // 'oMenuTIK'	=> $oMenuTIK,
            // 'oMenuRPT'	=> $oMenuRPT,
            // 'oMenuVED'   => $oMenuVED,
            'tUsrID'        => $tUsrID
        ));
        
        
        $this->load->view('common/wWellcome', $nMsgResp);
        $this->load->view('common/wFooter',array('nMsgResp' => $nMsgResp));
    }

    //Create by witsarut 04/03/2020
    //function ใช้ในการ Insdata Insert ลง ตาราง Notification
    public function FSxAddDataNoti(){
        try{
            
            $aResData =  $this->input->post('tDataNoti');

            foreach($aResData['ptData']['paContents'] AS $nKey => $aValue){
               $tSubTopic  =  $aValue['ptFTSubTopic'];
               $tMsg       =  $aValue['ptFTMsg'];
            } 

            $aData = array(
                'FTMsgID'       => $aResData['ptFunction'],
                'FTBchCode'     => $this->session->userdata('tSesUsrBchCom'),
                'FDNtiSendDate' => $aResData['ptData']['ptFDSendDate'],
                'FTNtiID'       => $aResData['ptData']['ptFTNotiId'],
                'FTNtiTopic'    => $aResData['ptData']['ptFTTopic'],
                'FTNtiContents' => json_encode($aResData['ptData']['paContents']),
                'FTNtiUsrRole'  => $aResData['ptData']['ptFTUsrRole'],
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'tSource'       => $aResData['ptSource'],
                'tDest'         => $aResData['ptDest'],
                'tFilter'       => $aResData['ptFilter']
            );


            $this->db->trans_begin();

            // Check ข้อมูลซ้ำ TCNTNoti (FTMsgID)
            // เงื่อนไข : ถ้า Check แล้วเกิดข้อมูลซ้ำจะไม่ Insert TCNTNoti
            $aChkDupNotiMsgID   = $this->Notification_model->FSaMCheckNotiMsgID($aData);

            if($aChkDupNotiMsgID['rtCode'] == 1){
                $aReturn = array(
                    'nStaEvent'    => '905',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            }else{
                $aResult = $this->Notification_model->FSaMAddNotification($aData);
                
                if($this->db->trans_status() == false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Success Add Data"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Data',
                    );
                }
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }

    }

    //Create by witsarut 04/03/2020
    //function ใช้ในการ Getdata Insert ลง ตาราง Notification
    public function FSxGetDataNoti(){

        $aData = $this->Notification_model->FSaMGetNotification();
        if($aData['rtCode'] == 900){
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Success Add Data"
            );
        }else{
            $aReturn = array(
                'nStaEvent'	    => '1',
                'tStaMessg'		=> 'Success Add Data',
                'aData'         => $aData['raItems']
            );
        }
        echo json_encode($aReturn);
    }

    //Create by witsarut 04/03/2020
    //function ใช้ในการ Getdata Read 
    public function FSxGetDataNotiRead(){
        $this->Notification_model->FSaMMoveDataTableNotiToTableRead();
    }

    //Create by supawat 03/07/2020
    public function FSxImpImportFileExcel(){
        $this->load->model('common/Common_model');
        $aPackData      = $this->input->post('aPackdata');
        $tNameModule    = $this->input->post('tNameModule');
        $tTypeModule    = $this->input->post('tTypeModule');
        $tFlagClearTmp  = $this->input->post('tFlagClearTmp');
        $nPackData      = count($aPackData);

        //เลือกใช้ตาราง
        if($tTypeModule == 'document'){
             //ถ้าเป็นเอกสารจะใช้ตาราง TCNTDocDTTmp
            $tTableName = 'TCNTDocDTTmp';
        }else if($tTypeModule == 'master'){
             //ถ้าเป็นมาส์เตอร์จะใช้ตาราง TCNTImpMasTmp
            $tTableName = 'TCNTImpMasTmp';
        }

        //เงื่อนไข ที่มีผลต่อตาราง
        switch ($tNameModule) {
            case "branch":
                $aTableRefPK = ['TCNMBranch'];
                $tTableRefPK = $aTableRefPK[0];
            break;
            case "adjprice":
                $aTableRefPK = ['TCNTPdtAdjPriHD'];
                $tTableRefPK = $aTableRefPK[0];
            break;
            case "user":
                $aTableRefPK = ['TCNMUser'];
                $tTableRefPK = $aTableRefPK[0];
            break;
            case "pos":
                $aTableRefPK = ['TCNMPos'];
                $tTableRefPK = $aTableRefPK[0];
            break;
            case "product":
                $aTableRefPK = ['TCNMPDT','TCNMPdtUnit','TCNMPdtBrand','TCNMPdtTouchGrp'];
                $tTableRefPK = $aTableRefPK;
            break;
        }

        //เงื่อนไข ที่มีผลต่อตาราง
        $aWhereData = array(
            'tTableRefPK'       => $tTableRefPK,
            'tTableNameTmp'	    => $tTableName,
            'tFlagClearTmp'     => $tFlagClearTmp,
            'tTypeModule'       => $tTypeModule,
            'tNameModule'		=> $tNameModule,
            'tSessionID'        => $this->session->userdata("tSesSessionID")
        );

        //ถ้าเป็นการนำเข้าจากหน้าจอสินค้า จะพิเศษกว่าอันอื่น
        if($tNameModule == 'product'){  

            $this->Common_model->FCNaMCMMDeleteTmpExcelCasePDT($aWhereData);

            //เพิ่ม ทัสกลุ่ม
                $aSumSheetTGroup = array();
                if(isset($aPackData[4])){
                    for($tTGROUP=0; $tTGROUP<count($aPackData[4]); $tTGROUP++){
                        $aTGroup = array(
                            'FTTmpTableKey'     => 'TCNMPdtTouchGrp',
                            'FNTmpSeq'          => $tTGROUP + 1,
                            'FTTcgCode'         => $aPackData[4][$tTGROUP][0],
                            'FTTcgName'         => $aPackData[4][$tTGROUP][1],
                            'FTSessionID'       => $this->session->userdata("tSesSessionID"),
                            'FTTmpStatus'       => (isset($aPackData[4][$tTGROUP][2]) == '') ? '' : $aPackData[4][$tTGROUP][2],
                            'FTTmpRemark'       => (isset($aPackData[4][$tTGROUP][3]) == '') ? '' : $aPackData[4][$tTGROUP][3],
                            'FDCreateOn'        => date('Y-m-d')
                        );
                        array_push($aSumSheetTGroup,$aTGroup);
                    }

                    //Insert ลง Tmp แล้ว
                    $this->Common_model->FCNaMCMMImportExcelToTmp($aWhereData,$aSumSheetTGroup);

                    //validate ข้อมูลซ้ำในตาราง Tmp _ ทัสกลุ่ม
                    $aValidateData = array(
                        'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                        'tFieldName'        => 'FTTcgCode'
                    );
                    FCNnMasTmpChkCodeDupInTemp($aValidateData);

                    //validate มีข้อมูลอยู่เเล้วในตารางจริง _ ทัสกลุ่ม
                    $aValidateData = array(
                        'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                        'tFieldName'        => 'FTTcgCode',
                        'tTableName'        => 'TCNMPdtTouchGrp'
                    );
                    FCNnMasTmpChkCodeDupInDB($aValidateData);
                }

            //เพิ่ม แบรนด์
                $aSumSheetBrand = array();
                if(isset($aPackData[3])){
                    for($tBrand=0; $tBrand<count($aPackData[3]); $tBrand++){
                        $aBrand = array(
                            'FTTmpTableKey'     => 'TCNMPdtBrand',
                            'FNTmpSeq'          => $tBrand + 1,
                            'FTPbnCode'         => $aPackData[3][$tBrand][0],
                            'FTPbnName'         => $aPackData[3][$tBrand][1],
                            'FTSessionID'       => $this->session->userdata("tSesSessionID"),
                            'FTTmpStatus'       => (isset($aPackData[3][$tBrand][2]) == '') ? '' : $aPackData[3][$tBrand][2],
                            'FTTmpRemark'       => (isset($aPackData[3][$tBrand][3]) == '') ? '' : $aPackData[3][$tBrand][3],
                            'FDCreateOn'        => date('Y-m-d')
                        );
                        array_push($aSumSheetBrand,$aBrand);
                    }

                    //Insert ลง Tmp แล้ว
                    $this->Common_model->FCNaMCMMImportExcelToTmp($aWhereData,$aSumSheetBrand);

                    //validate ข้อมูลซ้ำในตาราง Tmp _ แบรนด์
                    $aValidateData = array(
                        'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                        'tFieldName'        => 'FTPbnCode'
                    );
                    FCNnMasTmpChkCodeDupInTemp($aValidateData);

                    //validate มีข้อมูลอยู่เเล้วในตารางจริง _ แบรนด์
                    $aValidateData = array(
                        'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                        'tFieldName'        => 'FTPbnCode',
                        'tTableName'        => 'TCNMPdtBrand'
                    );
                    FCNnMasTmpChkCodeDupInDB($aValidateData);
                }

            //เพิ่ม หน่วยสินค้า
                $aSumSheetUnit = array();
                if(isset($aPackData[2])){
                    for($tUnit=0; $tUnit<count($aPackData[2]); $tUnit++){
                        $aUnit = array(
                            'FTTmpTableKey'     => 'TCNMPdtUnit',
                            'FNTmpSeq'          => $tUnit + 1,
                            'FTPunCode'         => $aPackData[2][$tUnit][0],
                            'FTPunName'         => $aPackData[2][$tUnit][1],
                            'FTSessionID'       => $this->session->userdata("tSesSessionID"),
                            'FTTmpStatus'       => (isset($aPackData[2][$tUnit][2]) == '') ? '' : $aPackData[2][$tUnit][2],
                            'FTTmpRemark'       => (isset($aPackData[2][$tUnit][3]) == '') ? '' : $aPackData[2][$tUnit][3],
                            'FDCreateOn'        => date('Y-m-d')
                        );
                        array_push($aSumSheetUnit,$aUnit);
                    }

                    //Insert ลง Tmp แล้ว
                    $this->Common_model->FCNaMCMMImportExcelToTmp($aWhereData,$aSumSheetUnit);

                    //validate ข้อมูลซ้ำในตาราง Tmp _ หน่วยสินค้า
                    $aValidateData = array(
                        'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                        'tFieldName'        => 'FTPunCode'
                    );
                    FCNnMasTmpChkCodeDupInTemp($aValidateData);

                    //validate มีข้อมูลอยู่เเล้วในตารางจริง _ หน่วยสินค้า
                    $aValidateData = array(
                        'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                        'tFieldName'        => 'FTPunCode',
                        'tTableName'        => 'TCNMPdtUnit'
                    );
                    FCNnMasTmpChkCodeDupInDB($aValidateData);
                }

            //เพิ่ม ข้อมูลสินค้า
                $aSumSheetPDT = array();
                if(isset($aPackData[1])){
                    for($tPDT=0; $tPDT<count($aPackData[1]); $tPDT++){
                        $aPDT = array(
                            'FTTmpTableKey'     => 'TCNMPdt',
                            'FNTmpSeq'          => $tPDT + 1,
                            'FTPdtCode'         => (isset($aPackData[1][$tPDT][0]) == '') ? '' : $aPackData[1][$tPDT][0],
                            'FTPdtName'         => (isset($aPackData[1][$tPDT][1]) == '') ? '' : $aPackData[1][$tPDT][1],
                            'FTPdtNameABB'      => (isset($aPackData[1][$tPDT][2]) == '') ? '' : $aPackData[1][$tPDT][2],
                            'FTPunCode'         => (isset($aPackData[1][$tPDT][3]) == '') ? '' : $aPackData[1][$tPDT][3],
                            'FCPdtUnitFact'     => (isset($aPackData[1][$tPDT][4]) == '') ? '' : $aPackData[1][$tPDT][4],
                            'FTBarCode'         => (isset($aPackData[1][$tPDT][5]) == '') ? '' : $aPackData[1][$tPDT][5],
                            'FTPbnCode'         => (isset($aPackData[1][$tPDT][6]) == '') ? '' : $aPackData[1][$tPDT][6],
                            'FTTcgCode'         => (isset($aPackData[1][$tPDT][7]) == '') ? '' : $aPackData[1][$tPDT][7],
                            'FTSessionID'       => $this->session->userdata("tSesSessionID"),
                            'FTTmpStatus'       => (isset($aPackData[1][$tPDT][8]) == '') ? '' : $aPackData[1][$tPDT][8],
                            'FTTmpRemark'       => (isset($aPackData[1][$tPDT][9]) == '') ? '' : $aPackData[1][$tPDT][9],
                            'FDCreateOn'        => date('Y-m-d')
                        );
                        array_push($aSumSheetPDT,$aPDT);
                    }

                    //Insert ลง Tmp แล้ว
                    $this->Common_model->FCNaMCMMImportExcelToTmp($aWhereData,$aSumSheetPDT);

                    //validate ข้อมูลซ้ำในตาราง Tmp
                    $aValidateData = array(
                        'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                        'tFieldName'        => 'FTPdtCode'
                    );
                    FCNnMasTmpChkCodeDupInTemp($aValidateData);

                    //validate มีข้อมูลอยู่เเล้วในตารางจริง
                    $aValidateData = array(
                        'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                        'tFieldName'        => 'FTPdtCode',
                        'tTableName'        => 'TCNMPdt'
                    );
                    FCNnMasTmpChkCodeDupInDB($aValidateData);

                    //Check หน่วยสินค้าจาก Temp ก่อนเเล้วค่อยเช็คจาก master
                    $aValidateData = array(
                        'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                        'tFieldName'        => 'FTPunCode',
                        'tTableCheck'       => 'TCNMPdtUnit'
                    );
                    FCNnMasTmpChkCodeDupInDBSpecial($aValidateData);

                    //Check รหัสกลุ่มสินค้าทัช Temp ก่อนเเล้วค่อยเช็คจาก master
                    $aValidateData = array(
                        'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                        'tFieldName'        => 'FTTcgCode',
                        'tTableCheck'       => 'TCNMPdtTouchGrp'
                    );
                    FCNnMasTmpChkCodeDupInDBSpecial($aValidateData);

                    //Check รหัสยี่ห้อ Temp ก่อนเเล้วค่อยเช็คจาก master
                    $aValidateData = array(
                        'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                        'tFieldName'        => 'FTPbnCode',
                        'tTableCheck'       => 'TCNMPdtBrand'
                    );
                    FCNnMasTmpChkCodeDupInDBSpecial($aValidateData);
                }
        }else{
            $aInsPackdata = array();
            if($nPackData > 1){
                for($i=1; $i<$nPackData; $i++){
                    switch ($tNameModule) {
                        case "branch":
                            $aObject = array(
                                'FTTmpTableKey'     => $tTableRefPK,
                                'FNTmpSeq'          => $i,
                                'FTBchCode'         => $aPackData[$i][0],
                                'FTBchName'         => (isset($aPackData[$i][1]) == '') ? '' : $aPackData[$i][1],
                                'FTAgnCode'         => (isset($aPackData[$i][2]) == '') ? '' : $aPackData[$i][2],
                                'FTPplCode'         => (isset($aPackData[$i][3]) == '') ? '' : $aPackData[$i][3],
                                'FTTmpStatus'       => (isset($aPackData[$i][4]) == '') ? '' : $aPackData[$i][4],
                                'FTTmpRemark'       => (isset($aPackData[$i][5]) == '') ? '' : $aPackData[$i][5],
                                'FTSessionID'       => $this->session->userdata("tSesSessionID"),
                                'FDCreateOn'        => date('Y-m-d')
                            );
                        break;
                        case "adjprice":
                            $aObject = array(
                                'FTBchCode'         => $this->session->userdata("tSesUsrBchCodeDefault"),
                                'FTXthDocKey'       => $tTableRefPK,
                                'FNXtdSeqNo'        => $i,
                                'FTPdtCode'         => $aPackData[$i][0],
                                'FTPunCode'         => (isset($aPackData[$i][1]) == '') ? '' : $aPackData[$i][1],
                                'FCXtdPriceRet'     => (isset($aPackData[$i][2]) == '') ? '' : $aPackData[$i][2],
                                'FTTmpStatus'       => (isset($aPackData[$i][3]) == '') ? '' : $aPackData[$i][3],
                                'FTTmpRemark'       => (isset($aPackData[$i][4]) == '') ? '' : $aPackData[$i][4],
                                'FTSessionID'       => $this->session->userdata("tSesSessionID"),
                                'FDCreateOn'        => date('Y-m-d')
                            );
                        break;
                        case "user":
                            $aObject = array(
                                'FTTmpTableKey'     => $tTableRefPK,
                                'FNTmpSeq'          => $i,
                                'FTUsrCode'         => $aPackData[$i][0],
                                'FTUsrName'         => (isset($aPackData[$i][1]) == '') ? '' : $aPackData[$i][1],
                                'FTBchCode'         => (isset($aPackData[$i][2]) == '') ? '' : $aPackData[$i][2],
                                'FTRolCode'         => (isset($aPackData[$i][3]) == '') ? '' : $aPackData[$i][3],
                                'FTAgnCode'         => (isset($aPackData[$i][4]) == '') ? '' : $aPackData[$i][4],
                                'FTMerCode'         => (isset($aPackData[$i][5]) == '') ? '' : $aPackData[$i][5],
                                'FTShpCode'         => (isset($aPackData[$i][6]) == '') ? '' : $aPackData[$i][6],
                                'FTDptCode'         => (isset($aPackData[$i][7]) == '') ? '' : $aPackData[$i][7],
                                'FTUsrTel'          => (isset($aPackData[$i][8]) == '') ? '' : $aPackData[$i][8],
                                'FTUsrEmail'        => (isset($aPackData[$i][9]) == '') ? '' : $aPackData[$i][9],
                                'FTTmpStatus'       => (isset($aPackData[$i][10]) == '') ? '' : $aPackData[$i][10],
                                'FTTmpRemark'       => (isset($aPackData[$i][11]) == '') ? '' : $aPackData[$i][11],
                                'FTSessionID'       => $this->session->userdata("tSesSessionID"),
                                'FDCreateOn'        => date('Y-m-d')
                            );
                        break;
                        case "pos":
                            $aObject = array(
                                'FTTmpTableKey'     => $tTableRefPK,
                                'FNTmpSeq'          => $i,
                                'FTBchCode'         => $aPackData[$i][0],
                                'FTPosCode'         => $aPackData[$i][1],
                                'FTPosName'         => (isset($aPackData[$i][2]) == '') ? '' : $aPackData[$i][2],
                                'FTPosType'         => (isset($aPackData[$i][3]) == '') ? '' : $aPackData[$i][3],
                                'FTPosRegNo'        => (isset($aPackData[$i][4]) == '') ? '' : $aPackData[$i][4],
                                'FTTmpStatus'       => (isset($aPackData[$i][5]) == '') ? '' : $aPackData[$i][5],
                                'FTTmpRemark'       => (isset($aPackData[$i][6]) == '') ? '' : $aPackData[$i][6],
                                'FTSessionID'       => $this->session->userdata("tSesSessionID"),
                                'FDCreateOn'        => date('Y-m-d')
                            );
                        break;
                    }
                    array_push($aInsPackdata,$aObject);
                }

                //Insert ลง Tmp แล้ว
                $this->Common_model->FCNaMCMMImportExcelToTmp($aWhereData,$aInsPackdata);
            }
        }

        //Validate พวกอ่างอิงไม่เจอ + ตรวจสอบข้อมูลว่ามีจริงไหม
        switch ($tNameModule) {
            case "branch":
                //validate ข้อมูลซ้ำในตาราง Tmp
                $aValidateData = array(
                    'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                    'tFieldName'        => 'FTBchCode'
                );
                FCNnMasTmpChkCodeDupInTemp($aValidateData);

                //validate มีข้อมูลอยู่เเล้วในตารางจริง
                $aValidateData = array(
                    'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                    'tFieldName'        => 'FTBchCode',
                    'tTableName'        => 'TCNMBranch'
                );
                FCNnMasTmpChkCodeDupInDB($aValidateData);

                //validate ข้อมูลอ้างอิงมีจริงไหม _ FTPplCode
                $aValidateData = array(
                    'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                    'tFieldName'        => 'FTPplCode',
                    'tTableName'        => 'TCNMPdtPriList',
                    'tErrMsg'           => 'ไม่พบกลุ่มราคาในระบบ'
                );
                FCNnMasTmpChkCodeInDB($aValidateData);
        
                //validate ข้อมูลอ้างอิงมีจริงไหม
                $aValidateData = array(
                    'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                    'tFieldName'        => 'FTAgnCode',
                    'tTableName'        => 'TCNMAgency',
                    'tErrMsg'           => 'ไม่พบตัวแทนขายในระบบ'
                );
                FCNnMasTmpChkCodeInDB($aValidateData);
            break;
            case "adjprice":
                //validate ข้อมูลอ้างอิงมีจริงไหม _ FTPdtCode
                $aValidateData = array(
                    'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                    'tFieldName'        => 'FTPdtCode',
                    'tTableName'        => 'TCNMPDT',
                    'tErrMsg'           => 'ไม่พบสินค้าในระบบ'
                );
                FCNnDocTmpChkCodeInDB($aValidateData);

                //validate ข้อมูลอ้างอิงมีจริงไหม _ FTPunCode
                $aValidateData = array(
                    'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                    'tFieldName'        => 'FTPunCode',
                    'tTableName'        => 'TCNMPdtUnit',
                    'tErrMsg'           => 'ไม่พบหน่วยสินค้าในระบบ'
                );
                FCNnDocTmpChkCodeInDB($aValidateData);

                //validate เช็คซ้ำกันใน temp
                $aValidateData = array(
                    'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                    'aFieldName'        => ['FTPdtCode','FTPunCode']
                );
                FCNnDocTmpChkCodeMultiDupInTemp($aValidateData);
            break;
            case "user":

                //validate ข้อมูลซ้ำในตาราง Tmp _ รหัสผู้ใช้
                $aValidateData = array(
                    'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                    'tFieldName'        => 'FTUsrCode'
                );
                FCNnMasTmpChkCodeDupInTemp($aValidateData);

                //validate มีข้อมูลอยู่เเล้วในตารางจริง _ รหัสผู้ใช้
                $aValidateData = array(
                    'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                    'tFieldName'        => 'FTUsrCode',
                    'tTableName'        => 'TCNMUser'
                );
                FCNnMasTmpChkCodeDupInDB($aValidateData);

                //validate ข้อมูลอ้างอิงมีจริงไหม _ สาขา
                $aValidateData = array(
                    'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                    'tFieldName'        => 'FTBchCode',
                    'tTableName'        => 'TCNMBranch',
                    'tErrMsg'           => 'ไม่พบรหัสสาขาในระบบ'
                );
                FCNnMasTmpChkCodeInDB($aValidateData);

                //validate ข้อมูลอ้างอิงมีจริงไหม _ กลุ่มสิทธิ
                $aValidateData = array(
                    'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                    'tFieldName'        => 'FTRolCode',
                    'tTableName'        => 'TCNMUsrRole',
                    'tErrMsg'           => 'ไม่พบกลุ่มสิทธิ์ในระบบ'
                );
                FCNnMasTmpChkCodeInDB($aValidateData);

                //validate ข้อมูลอ้างอิงมีจริงไหม _ รหัสตัวแทนขาย	
                $aValidateData = array(
                    'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                    'tFieldName'        => 'FTAgnCode',
                    'tTableName'        => 'TCNMAgency',
                    'tErrMsg'           => 'ไม่พบตัวแทนขายในระบบ'
                );
                FCNnMasTmpChkCodeInDB($aValidateData);

                //validate ข้อมูลอ้างอิงมีจริงไหม _ กลุ่มธุรกิจ	
                $aValidateData = array(
                    'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                    'tFieldName'        => 'FTMerCode',
                    'tTableName'        => 'TCNMMerchant',
                    'tErrMsg'           => 'ไม่พบกลุ่มธุรกิจในระบบ'
                );
                FCNnMasTmpChkCodeInDB($aValidateData);

                //validate ข้อมูลอ้างอิงมีจริงไหม _ ร้านค้า	
                $aValidateData = array(
                    'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                    'tFieldName'        => 'FTShpCode',
                    'tTableName'        => 'TCNMShop_L',
                    'tErrMsg'           => 'ไม่พบร้านค้าในระบบ'
                );
                FCNnMasTmpChkCodeInDB($aValidateData);

                //validate ข้อมูลอ้างอิงมีจริงไหม _ แผนก	
                $aValidateData = array(
                    'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                    'tFieldName'        => 'FTDptCode',
                    'tTableName'        => 'TCNMUsrDepart_L',
                    'tErrMsg'           => 'ไม่พบแผนกในระบบ'
                );
                FCNnMasTmpChkCodeInDB($aValidateData);
            break;
            case "pos":

                // ตรวจสอบสาขาว่ามีอยู่จริงหรือไม่
                $aValidateData = array(
                    'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                    'tFieldName'        => 'FTBchCode',
                    'tTableName'        => 'TCNMBranch',
                    'tErrMsg'           => 'ไม่พบสาขาในระบบ'
                );
                FCNnMasTmpChkCodeInDB($aValidateData);

                 // ตรวจสอบข้อมูลซ้ำในตาราง Temp
                 $aValidateData = array(
                    'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                    'aFieldName'        => ['FTBchCode','FTPosCode']
                );
                FCNnMasTmpChkCodeMultiDupInTemp($aValidateData);

                // ตรวจสอบข้อมูลซ้ำในตาราง Master
                $aValidateData = array(
                    'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                    'tTableName'        => 'TCNMPos',
                    'aFieldName'        => ['FTBchCode','FTPosCode']
                );
                FCNnMasTmpChkCodeMultiDupInDB($aValidateData);
            break;
        }

    }
}

