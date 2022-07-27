<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class cUser extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('authen/user/mUser');
        $this->load->model('authen/login/mLogin');
        $this->load->library('password/PasswordStorage');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nUsrBrowseType,$tUsrBrowseOption){
        $nMsgResp = array('title'=>"User");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('user/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventUser	= FCNaHCheckAlwFunc('user/0/0');
        $this->load->view ( 'authen/user/wUser', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nUsrBrowseType'    => $nUsrBrowseType,
            'tUsrBrowseOption'  => $tUsrBrowseOption,
            'aAlwEventUser'     => $aAlwEventUser 
        ));
    }

    //Functionality : Function Call Page User List
    //Parameters : Ajax jUser()
    //Creator : 01/06/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvUSRListPage(){
        $aAlwEventUser	= FCNaHCheckAlwFunc('user/0/0');
        $aNewData  		= array( 'aAlwEventUser' => $aAlwEventUser);
        $this->load->view('authen/user/wUserList',$aNewData);
    }

    //Functionality : Function Call DataTables User List
    //Parameters : Ajax jUser()
    //Creator : 01/06/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvUSRDataList(){
        try{
            $nPage      = $this->input->post('nPageCurrent');
            $tSearchAll = $this->input->post('tSearchAll');
            if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
            if(!$tSearchAll){$tSearchAll='';}
            //Lang ภาษา
            $nLangEdit  = $this->session->userdata("tLangEdit");

            // เพิ่มระดับผู้ใช้ 12/03/2020 Saharat
            $tStaUsrLevel    = $this->session->userdata("tSesUsrLevel");
            $tUsrBchCode     = $this->session->userdata("tSesUsrBchCodeMulti"); 
            $tUsrShpCode     = $this->session->userdata("tSesUsrShpCodeMulti"); 

            $aData = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll,
                'tStaUsrLevel'  => $tStaUsrLevel,
                'tUsrBchCode'   => $tUsrBchCode,
                'tUsrShpCode'   => $tUsrShpCode,
                'tUsrMerCode'   => $this->session->userdata("tSesUsrMerCode"),
                'tUsrAgnCode'   => $this->session->userdata("tSesUsrAgnCode")
            );

            $tAPIReq    = "";
            $tMethodReq = "GET";
            $aResList = $this->mUser->FSaMUSRList($tAPIReq, $tMethodReq, $aData);
            if($aResList['rnAllRow'] == 0){
                $nPage = $nPage - 1;
                $aData['nPage'] = $nPage;
                $aResList = $this->mUser->FSaMUSRList($tAPIReq, $tMethodReq, $aData);
            }
            $aAlwEvent = FCNaHCheckAlwFunc('user/0/0'); //Controle Event
            $aGenTable  = array(
                'aAlwEventUser' => $aAlwEvent,
                'aDataList'     => $aResList,
                'nPage'         => $nPage,
                'tSearchAll'    => $tSearchAll
            );
            $this->load->view('authen/user/wUserDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage User Add
    //Parameters : Ajax Call Function
    //Creator : 04/06/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvUSRAddPage(){
        try{
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMUser_L');
            // $nLangHave      = count($aLangHave);
     

            // if($nLangHave > 1){
            //     if($nLangEdit != ''){
            //         $nLangEdit = $nLangEdit;
            //     }else{
            //         $nLangEdit = $nLangResort;
            //     }
            // }else{
            //     if(@$aLangHave[0]->nLangList == ''){
            //         $nLangEdit = '1';
            //     }else{
            //         $nLangEdit = $aLangHave[0]->nLangList;
            //     }
            // }
  
            $aData  = array(
                'FNLngID'   => $nLangEdit,
            );
            $tAPIReq        = "";
            $tMethodReq     = "GET";
            $aDataAdd = array(
                'aResult'   => array('rtCode'         =>'99',
                                     'dGetDataNow'   => date('Y-m-d'),
                                     'dGetDataFuture' => date('Y-m-d', strtotime('+1 year'))
                ),  
            );
      
            $this->load->view('authen/user/wUserAdd',$aDataAdd);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage User Edit
    //Parameters : Ajax Function Edit User
    //Creator : 04/06/2018 wasin
    //Last Modified : 11/05/2020 Napat(Jame)
    //Return : String View
    //Return Type : View
    public function FSvUSREditPage(){
        try{
            $tUsrCode       = $this->input->post('tUsrCode');
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aData  = array(
                'FTUsrCode' => $tUsrCode,
                'FNLngID'   => $nLangEdit
            );
            $tAPIReq        = "";
            $tMethodReq     = "GET";
            $aResList       = $this->mUser->FSaMUSRSearchByID($tAPIReq,$tMethodReq,$aData);

            // Create By Witsarut 21/02/2020
            // Join ขา Edit หา field FTUsrCode 
            $aResActRole   = $this->mUser->FSaMActRoleByID($tAPIReq,$tMethodReq,$aData);

            // Create By Witsarut 23/04/2020  (Select only FTBchCode)
            // Last Updated By Napat 11/05/2020 ( ดึงข้อมูล UsrGroup มาทั้งหมด )
            $aResUsrGroup    = $this->mUser->FSaMUsrBchByID($tAPIReq,$tMethodReq,$aData);

            // Create By Witsarut 23/04/2020  (Select only FTShpCode)
            // $aResUsrShp    = $this->mUser->FSaMUsrShpByID($tAPIReq,$tMethodReq,$aData);


            if(isset($aResList['raItems']['rtUsrImage']) && !empty($aResList['raItems']['rtUsrImage'])){
                $tImgObj        = $aResList['raItems']['rtUsrImage'];
                $aImgObj		= explode("application/modules/",$tImgObj);
				$aImgObjName	= explode("/",$tImgObj);
                $tImgObjAll     = $aImgObj[1];
                $tImgName		= end($aImgObjName);
            }else{
                $tImgObjAll     = "";
                $tImgName       = "";
            }
            $aDataEdit  = [
                'tImgObj'       => $tImgObjAll,
                'tImgName'      => $tImgName,
                'aResult'       => $aResList,
                'aResActRole'   => $aResActRole,
                'aResUsrGroup'  => $aResUsrGroup
                // 'aResUsrBch'   => $aResUsrBch
                // 'aResUsrShp'   => $aResUsrShp
            ];
       
            $this->load->view('authen/user/wUserAdd',$aDataEdit);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function Event Add User
    //Parameters : Ajax Function Add User
    //Creator : 07/06/2018 wasin
    //Last Modified : 11/05/2020 Napat(Jame)
    //Last Modified : 13/05/2020 Napat(Jame) ปิดการทำงานฟังค์ชั่น FSaMUSRAddUpdateGroup เพราะไม่ได้ใช้แล้ว
    //Return : Status Event Add And Status Call Back Event
    //Return Type : object
    public function FSoUSRAddEvent(){
        try{
            $tUserImage     = trim($this->input->post('oetImgInputuser'));
            $tUserImageOld  = trim($this->input->post('oetImgInputuserOld'));
            $tBchCode       = $this->input->post('oetBranchCode');
            $tShpCode       = $this->input->post('oetShopCode');
            if(!empty($tBchCode) && !empty($tShpCode)){
                $FTUsrStaShop   = 3;
            }else if(!empty($tBchCode) && empty($tShpCode)){
                $FTUsrStaShop   = 2;
            }else{
                $FTUsrStaShop   = 1;
            }
            $tIsAutoGenCode = $this->input->post('ocbUserAutoGenCode');
            $tUsrCode = "";
            if(isset($tIsAutoGenCode) && $tIsAutoGenCode == '1'){
                // Update new gencode
                // 15/05/2020 Napat(Jame)
                $aStoreParam = array(
                    "tTblName"    => 'TCNMUser',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $tUsrCode   = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode = FCNaHGenCodeV5('TCNMUser');
                // if($aGenCode['rtCode'] == '1'){
                //     $tUsrCode = $aGenCode['rtUsrCode'];
                // }
            }else{
                $tUsrCode = $this->input->post('oetUsrCode');
            }

            $aPassExp       = $this->input->post('oetUsrPassword');
            $aDataMaster    = array(
                'FTImgObj'      => $this->input->post('oetImgInputuser'),
                'FTUsrCode'     => $tUsrCode,
                'FTDptCode'     => $this->input->post('oetDepartCode'),
                // 'FTRolCode'     => '',
                'FTUsrTel'      => $this->input->post('oetUsrTel'),
                'FTUsrPwd'      => $aPassExp,
                'FTUsrEmail'    => $this->input->post('oetUsrEmail'),
                'FTUsrName'     => $this->input->post('oetUsrName'),
                'FTUsrRmk'      => $this->input->post('otaUsrRemark'),
                'FTBchCode'     => $tBchCode,
                'FTUsrStaShop'  => $FTUsrStaShop,
                'FTShpCode'     => $tShpCode,
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );

            // Create By Witsarut 23/04/2020
            // Last Updated By Napat 11/05/2020 เพิ่ม MerCode
            // Insert TCNTUsrBch feile FTBchCode && FTShpCode
            // *******************************************************************************************************************************************************
            // $tUsrMerCode = $this->input->post('oetUsrMerCode');
            // $tUsrBchCode = $this->input->post('oetBranchCode');
            // $tUsrShpCode = $this->input->post('oetShopCode');
            // $aDataMasterUsrBch = array(
            //     'FTUsrCode'         => $tUsrCode,
            //     'FTMerCode'         => (empty($tUsrMerCode) ? '' : $tUsrMerCode),
            //     'FTBchCode'         => (empty($tUsrBchCode) ? '' : $tUsrBchCode),
            //     'FTShpCode'         => (empty($tUsrShpCode) ? '' : $tUsrShpCode),
            //     'FDCreateOn'        => date('Y-m-d H:i:s'),
            //     'FTCreateBy'        => $this->session->userdata('tSesUsername'),
            //     'FDLastUpdOn'       => date('Y-m-d H:i:s'),
            //     'FTLastUpdBy'       => $this->session->userdata('tSesUsername')
            // );
            // $this->mUser->FSaMUSRAddUpdateMasterUsrBch($aDataMasterUsrBch);

            $oCountDup  = $this->mUser->FSoMUSRCheckDuplicate($aDataMaster['FTUsrCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if($nStaDup == 0){
                $this->db->trans_begin();

                // TCNMUser
                $aStaUsrMaster      = $this->mUser->FSaMUSRAddUpdateMaster($aDataMaster);
                $aStaUsrLang        = $this->mUser->FSaMUSRAddUpdateLang($aDataMaster);
                // $aStaUsrGroup       = $this->mUser->FSaMUSRAddUpdateGroup($aDataMaster);

                $tUsrAgnCode        = $this->input->post('oetUsrAgnCode');
                $tUsrMerCode        = $this->input->post('oetUsrMerCode');

                $tBanchCode         = $this->input->post('oetBranchCode');
                $tBranchSpitCode    = explode(',' , $tBanchCode);

                $tShpCode           = $this->input->post('oetShopCode');
                $tShopSpitCode      = explode(',' , $tShpCode);

                $aDataMasterUsrBch    = array(
                    'FTUsrCode'     => $tUsrCode,
                    'FTAgnCode'     => (empty($tUsrAgnCode) ? '' : $tUsrAgnCode),
                    'FTMerCode'     => (empty($tUsrMerCode) ? '' : $tUsrMerCode),
                    'FDCreateOn'    => date('Y-m-d H:i:s'),
                    'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                    'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                );

                // กรณีเลือกแต่ Merchant จะดึงสาขาที่อยู่ภายใต้ mer นี้มา insert ทั้งหมด
                // if($tUsrMerCode != "" && $tBanchCode == "" && $tShpCode == ""){
                //     $aGetBchFromMerCode = $this->mUser->FSaMUSRGetBranchFromMerCode($tUsrMerCode);
                //     if($aGetBchFromMerCode['nStaQuery'] == 1){
                //         for($i=0; $i < count($aGetBchFromMerCode['aItems']); $i++){
                //             $this->mUser->FSaMUSRAddUpdateMasterUsrBch($aGetBchFromMerCode['aItems'][$i]['FTBchCode'], $aDataMasterUsrBch);
                //         }
                //     }


                // กรณีเลือกแต่ Agency ดึง Branch ที่อยู่ภายใต้ Agency มาทั้งหมด
                if($tUsrAgnCode != "" && $tBchCode == ""){
                    // Last Update : Napat(Jame) 17/08/2020 ถ้าเลือก Agn ไม่ต้องไปดึง Bch มา
                    $this->mUser->FSaMUSRAddUpdateMasterUsrBch('', $aDataMasterUsrBch);
                    // $aGetBchFromAgnCode = $this->mUser->FSaMUSRGetBchFromAgnCode($tUsrAgnCode);
                    // if($aGetBchFromAgnCode['nStaQuery'] == 1){
                    //     for($i=0; $i < count($aGetBchFromAgnCode['aItems']); $i++){
                    //         $this->mUser->FSaMUSRAddUpdateMasterUsrBch($aGetBchFromAgnCode['aItems'][$i]['FTBchCode'], $aDataMasterUsrBch);
                    //     }
                    // }

                // กรณีเลือกแต่ Merchant ดึง Shop ที่อยู่ภายใต้ Merchant มาทั้งหมด
                }else if($tBchCode != "" && $tUsrMerCode != "" && $tShpCode == ""){
                    // Last Update : Napat(Jame) 16/09/2020 ถ้าเลือก Mer ไม่ต้องไปดึง Shp มา
                    $this->mUser->FSaMUSRAddUpdateMasterUsrBch($tBanchCode, $aDataMasterUsrBch);

                    // $aGetShpFromMerCode = $this->mUser->FSaMUSRGetShpFromMerCode($tUsrMerCode);

                    // if($aGetShpFromMerCode['nStaQuery'] == 1){
                    //     for($i=0; $i < count($aGetShpFromMerCode['aItems']); $i++){
                    //         $this->mUser->FSaMUSRAddUpdateMasterUsrShp($aGetShpFromMerCode['aItems'][$i]['FTShpCode'], str_replace(',', '', $tBchCode ), $aDataMasterUsrBch);
                    //     }
                    // }
                }else{
                    if($tBanchCode != '' && $tShpCode == ''){ // Add Usr Bch
                        if(isset($tBranchSpitCode) != empty($tBranchSpitCode)){
                            for($i=0; $i < count($tBranchSpitCode); $i++){
                                if($tBranchSpitCode[$i] == ''){
                                    continue;
                                }
                                $aStaMasterUsrBch  = $this->mUser->FSaMUSRAddUpdateMasterUsrBch($tBranchSpitCode[$i], $aDataMasterUsrBch);
                            }
                        }
                    }else if($tBanchCode != '' && $tShpCode != ''){ // Add Usr Shp
                        if(isset($tShopSpitCode) != empty($tShopSpitCode)){
                            for($i=0; $i < count($tShopSpitCode); $i++){
                                if($tShopSpitCode[$i] == ''){
                                    continue;
                                }
                                $aStaMasterUsrBch  = $this->mUser->FSaMUSRAddUpdateMasterUsrShp($tShopSpitCode[$i], $tBanchCode, $aDataMasterUsrBch);
                            }
                        }
                    }else if($tBanchCode == '' && $tShpCode == ''){ // Add Usr HQ
                        $this->mUser->FSaMUSRAddUpdateMasterUsrBch('', $aDataMasterUsrBch);
                    }
                }

                // ***********************************************************************************************************************************************************************
    
                // Create By Witsarut 21/02/2020
                // Insert  TCNMUsrActRole
                $tRoleCode   =  $this->input->post('oetRoleCode');
                $tRoleSpitCode   = explode(',' , $tRoleCode);

                $aDataMasterActRole = array(
                    'FTUsrCode'     => $tUsrCode,
                    'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                    'FDCreateOn'    => date('Y-m-d H:i:s'),
                    'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                );

                if(isset($tRoleSpitCode) != empty($tRoleSpitCode)){
                    for($i=0; $i < count($tRoleSpitCode); $i++){
                        // Inert TCNMUsrActRole
                        if($tRoleSpitCode[$i] == ''){
                            continue;
                        }
                        $aStaMasterActRole  = $this->mUser->FSaMUSRAddUpdateMasterActRole($tRoleSpitCode[$i],$aDataMasterActRole);
                    }
                }

                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Insert"
                    );
                }else{
                    $this->db->trans_commit();
                    // Check Image New Compare Image Old (เช็คข้อมูลรูปภาพใหม่ต้องไม่ตรงกับรูปภาพเก่าในระบบ)
                    if($tUserImage != $tUserImageOld){
                        $aImageUplode   = array(
                            'tModuleName'       => 'authen',
                            'tImgFolder'        => 'user',
                            'tImgRefID'         => $aDataMaster['FTUsrCode'],
                            'tImgObj'           => $tUserImage,
                            'tImgTable'         => 'TCNMUser',
                            'tTableInsert'      => 'TCNMImgPerson',
                            'tImgKey'           => '',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1
                        );
                        FCNnHAddImgObj($aImageUplode);
                    }
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTUsrCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Update'
                    );
   
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => "Status Dup"
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function Event Edit User
    //Parameters : Ajax Function Edit User
    //Creator : 07/06/2018 wasin
    //Last Modified : -
    //Return : Status Event Edit And Status Call Back Event
    //Return Type : object
    public function FSoUSREditEvent(){
        try{
            $tUserImageOld  = trim($this->input->post('oetImgInputuserOld'));
            $tUserImage     = trim($this->input->post('oetImgInputuser'));
            $tBchCode       = $this->input->post('oetBranchCode');
            $tShpCode       = $this->input->post('oetShopCode');
            if(!empty($tBchCode) && !empty($tShpCode)){
                $FTUsrStaShop   = 3;
            }else if(!empty($tBchCode) && empty($tShpCode)){
                $FTUsrStaShop   = 2;
            }else{
                $FTUsrStaShop   = 1;
            }
            $aPassExp       = $this->input->post('oetUsrPassword');
            $aDataMaster = array(
                'FTImgObj'      => $this->input->post('oetImgInputuser'),
                'FTUsrCode'     => $this->input->post('oetUsrCode'),
                'FTDptCode'     => $this->input->post('oetDepartCode'),
                'FTUsrTel'      => $this->input->post('oetUsrTel'),
                'FTUsrPwd'      => $aPassExp,
                'FTUsrEmail'    => $this->input->post('oetUsrEmail'),
                'FTUsrName'     => $this->input->post('oetUsrName'),
                'FTUsrRmk'      => $this->input->post('otaUsrRemark'),
                'FTBchCode'     => $tBchCode,
                'FTUsrStaShop'  => $FTUsrStaShop,
                'FTShpCode'     => $tShpCode,
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );
       
            // Create By Witsarut 21/02/2020
            // Insert  TCNMUsrActRole
            $aRoleCode     =  $this->input->post('oetRoleCode');
            $tRoleSpitCode   = explode(',' , $aRoleCode);
            $aDataMasterActRole = array(
                'FTUsrCode'     => $this->input->post('oetUsrCode'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
            );

            $aUsrCode   = array(
                'FTUsrCode'  =>  $this->input->post('oetUsrCode'),
            );

            $this->db->trans_begin();

            // Update Master
            $aStaUsrMaster  = $this->mUser->FSaMUSRAddUpdateMaster($aDataMaster);
            $aStaUsrLang    = $this->mUser->FSaMUSRAddUpdateLang($aDataMaster);

            //Del USerCode Table TCNMUsrActRole
            $this->mUser->FSaMDelActRoleCode($aUsrCode);

            //Update
            if(isset($tRoleSpitCode) != empty($tRoleSpitCode)){
                for($i=0; $i < count($tRoleSpitCode); $i++){
                    if($tRoleSpitCode[$i] == ''){
                        continue;
                    }
                    $aStaMasterActRole  = $this->mUser->FSaMUpdateMasterActRole($tRoleSpitCode[$i],$aDataMasterActRole);
                }
            }

            // ************************************************************** TCNTUsrBch ************************************************************************************************************

            // $tUsrMerCode = $this->input->post('oetUsrMerCode');
            // $tUsrBchCode = $this->input->post('oetBranchCode');
            // $tUsrShpCode = $this->input->post('oetShopCode');
            // $aDataMasterUsrBch = array(
            //     'FTUsrCode'         => $this->input->post('oetUsrCode'),
            //     'FTMerCode'         => (empty($tUsrMerCode) ? '' : $tUsrMerCode),
            //     'FTBchCode'         => (empty($tUsrBchCode) ? '' : $tUsrBchCode),
            //     'FTShpCode'         => (empty($tUsrShpCode) ? '' : $tUsrShpCode),
            //     'FDCreateOn'        => date('Y-m-d H:i:s'),
            //     'FTCreateBy'        => $this->session->userdata('tSesUsername'),
            //     'FDLastUpdOn'       => date('Y-m-d H:i:s'),
            //     'FTLastUpdBy'       => $this->session->userdata('tSesUsername')
            // );
            // $this->mUser->FSaMUSRAddUpdateMasterUsrBch($aDataMasterUsrBch);

            $tUsrAgnCode        = $this->input->post('oetUsrAgnCode');
            $tUsrMerCode        = $this->input->post('oetUsrMerCode');

            $tBchCode           = $this->input->post('oetBranchCode');
            $tBchSpitCode       = explode(',' , $tBchCode);

            $tShpCode           = $this->input->post('oetShopCode');
            $tShopSpitCode      = explode(',' , $tShpCode);

            $aDataMasterUsrBch = array(
                'FTUsrCode'     => $this->input->post('oetUsrCode'),
                'FTAgnCode'     => (empty($tUsrAgnCode) ? '' : $tUsrAgnCode),
                'FTMerCode'     => (empty($tUsrMerCode) ? '' : $tUsrMerCode),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
            );

            //Del USerCode Table TCNTUsrBch
            $this->mUser->FSaMDelUsrBchCode($aUsrCode);

            // กรณีเลือกแต่ Agency ดึง Branch ที่อยู่ภายใต้ Agency มาทั้งหมด
            if($tUsrAgnCode != "" && $tBchCode == ""){
                // Last Update : Napat(Jame) 16/09/2020 ถ้าเลือก Agn ไม่ต้องไปดึง Bch มา
                $this->mUser->FSaMUSRAddUpdateMasterUsrBch('', $aDataMasterUsrBch);
                // $aGetBchFromAgnCode = $this->mUser->FSaMUSRGetBchFromAgnCode($tUsrAgnCode);
                // if($aGetBchFromAgnCode['nStaQuery'] == 1){
                //     for($i=0; $i < count($aGetBchFromAgnCode['aItems']); $i++){
                //         $this->mUser->FSaMUSRAddUpdateMasterUsrBch($aGetBchFromAgnCode['aItems'][$i]['FTBchCode'], $aDataMasterUsrBch);
                //     }
                // }

            // กรณีเลือกแต่ Merchant ดึง Shop ที่อยู่ภายใต้ Merchant มาทั้งหมด
            }else if($tUsrMerCode != "" && $tShpCode == ""){
                // Last Update : Napat(Jame) 16/09/2020 ถ้าเลือก Mer ไม่ต้องไปดึง Shp มา
                $this->mUser->FSaMUSRAddUpdateMasterUsrBch($tBchCode, $aDataMasterUsrBch);
                // $aGetShpFromMerCode = $this->mUser->FSaMUSRGetShpFromMerCode($tUsrMerCode);
                // if($aGetShpFromMerCode['nStaQuery'] == 1){
                //     for($i=0; $i < count($aGetShpFromMerCode['aItems']); $i++){
                //         $this->mUser->FSaMUSRAddUpdateMasterUsrShp($aGetShpFromMerCode['aItems'][$i]['FTShpCode'], str_replace(',', '', $tBchCode ), $aDataMasterUsrBch);
                //     }
                // }
            }else{
                //Update
                if($tBchCode != '' && $tShpCode == ''){ // Update Usr Bch
                    if(isset($tBchSpitCode) != empty($tBchSpitCode)){
                        for($i=0; $i < count($tBchSpitCode); $i++){
                            if($tBchSpitCode[$i] == ''){
                                continue;
                            }
                            $aStaMasterUsrBch  = $this->mUser->FSaMUSRAddUpdateMasterUsrBch($tBchSpitCode[$i], $aDataMasterUsrBch);
                        }
                    }
                }else if($tBchCode != '' && $tShpCode != ''){ // Update Usr Shp
                    if(isset($tShopSpitCode) != empty($tShopSpitCode)){
                        for($i=0; $i < count($tShopSpitCode); $i++){
                            if($tShopSpitCode[$i] == ''){
                                continue;
                            }
                            $aStaMasterUsrBch  = $this->mUser->FSaMUSRAddUpdateMasterUsrShp($tShopSpitCode[$i], str_replace(',', '', $tBchCode ), $aDataMasterUsrBch);
                        }
                    }
                }else if($tBchCode == '' && $tShpCode == ''){ // Update Usr HQ
                    $this->mUser->FSaMUSRAddUpdateMasterUsrBch('', $aDataMasterUsrBch);
                }
            }

            // =======================================================================================
                // ตาราง  TCNTUsrGroup ไม่ได้ใช้แล้ว เพราะว่ามีตาราง TCNTUsrBch แล้ว confirm with P Run 23/04/2020
                // $aStaUsrGroup   = $this->mUser->FSaMUSRAddUpdateGroup($aDataMaster);
            // =======================================================================================

            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'tStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Update User"
                );
            }else{
                $this->db->trans_commit();
                // Check Image New Compare Image Old (เช็คข้อมูลรูปภาพใหม่ต้องไม่ตรงกับรูปภาพเก่าในระบบ)
                if($tUserImage != $tUserImageOld){
                    $aImageUplode   = array(
                        'tModuleName'       => 'authen',
                        'tImgFolder'        => 'user',
                        'tImgRefID'         => $aDataMaster['FTUsrCode'],
                        'tImgObj'           => $tUserImage,
                        'tImgTable'         => 'TCNMUser',
                        'tTableInsert'      => 'TCNMImgPerson',
                        'tImgKey'           => '',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1
                    );
                    FCNnHAddImgObj($aImageUplode);
                }
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTUsrCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Update'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function Event Delete User
    //Parameters : Ajax Function Delete User
    //Creator : 07/06/2018 wasin
    //Last Modified : -
    //Return : Status Event Delete And Status Call Back Event
    //Return Type : object
    public function FSoUSRDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTUsrCode' => $tIDCode,
            
        );
        $aResDel        = $this->mUser->FSnMUSRDel($aDataMaster);
        $nNumRowUsrLoc  = $this->mUser->FSnMLOCGetAllNumRow();
        if($aResDel['rtCode'] == 1){
            $aDeleteImage = array(
                'tModuleName'   => 'authen',
                'tImgFolder'    => 'user',
                'tImgRefID'     => $tIDCode,
                'tTableDel'     => 'TCNMImgPerson',
                'tImgTable'     => 'TCNMUser'
            );
            $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
           
            if($nStaDelImgInDB == 1){
                FSnHDeleteImageFiles($aDeleteImage);
            }
        }

        if($nNumRowUsrLoc){
            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'nNumRowUsrLoc' => $nNumRowUsrLoc
            );
            echo json_encode($aReturn);
        }else{
            echo "database error";
        }

    }

    //Functionality : Function Event Get Role User
    //Parameters : Ajax Function Delete User
    //Creator : 07/06/2018 wasin
    //Last Modified : -
    //Return : Status Event Delete And Status Call Back Event
    //Return Type : object
    public function FSoUSREventGetRoleUsr(){

        $tSesUsrRoleCodeMulti = $this->session->userdata('tSesUsrRoleCodeMulti');
        $tBchCodeUsr = $this->input->post('tBchCodeUsr');
        $aDataUsrRole = $this->mUser->FStUSERGetRoleSpcWhereBrows($tBchCodeUsr);
        $tUsrBchCodeMulti = '';
   
        if(!empty($aDataUsrRole)){
        $tUsrBchCodeMulti 	= $this->mLogin->FStMLOGMakeArrayToString($aDataUsrRole['aItems'],'FTRolCode','value');
        }
        
        if(!empty($tUsrBchCodeMulti)){
        $tSesUsrRoleCodeMulti .= ','.$tUsrBchCodeMulti;
        }
       echo $tSesUsrRoleCodeMulti;
    }

    ////////////////////// IMPORT /////////////////////////

    //Import
    public function FSaCUSRImportDataTable(){
        $this->load->view('authen/user/wUserImportDataTable');
    }

    public function FSaCUSRGetDataImport(){
        $aDataSearch = array(
			'nPageNumber'	=> ($this->input->post('nPageNumber') == 0) ? 1 : $this->input->post('nPageNumber'),
			'nLangEdit'		=> $this->session->userdata("tLangEdit"),
			'tTableKey'		=> 'TCNMUser',
			'tSessionID'	=> $this->session->userdata("tSesSessionID"),
			'tTextSearch'	=> $this->input->post('tSearch') 
		);
		$aGetData 					= $this->mUser->FSaMUSRGetTempData($aDataSearch);
        $data['draw'] 				= ($this->input->post('nPageNumber') == 0) ? 1 : $this->input->post('nPageNumber');
        $data['recordsTotal'] 		= $aGetData['numrow'];
        $data['recordsFiltered'] 	= $aGetData['numrow'];
        $data['data'] 				= $aGetData;
		$data['error'] 				= array();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    //Delete ข้อมูลใน
	public function FSaCUSRImportDelete(){
		$aDataMaster = array(
			'FNTmpSeq' 		=> $this->input->post('FNTmpSeq'),
			'tTableKey'		=> 'TCNMUser',
			'tSessionID'	=> $this->session->userdata("tSesSessionID")
		);
		$aResDel            = $this->mUser->FSaMUSRImportDelete($aDataMaster);

		//validate ข้อมูลซ้ำในตาราง Tmp
        $tUserCode          = $this->input->post('FTUsrCode');
		if(is_array($tUserCode)){
			foreach($tUserCode as $tValue){
				$aValidateData = array(
					'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
					'tFieldName'        => 'FTUsrCode',
					'tFieldValue'		=> $tValue
				);
				FCNnMasTmpChkInlineCodeDupInTemp($aValidateData);
			}
		}else{
			$aValidateData = array(
				'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
				'tFieldName'        => 'FTUsrCode',
				'tFieldValue'		=> $tUserCode
			);
			FCNnMasTmpChkInlineCodeDupInTemp($aValidateData);
        }
        
        //ให้มันวิ่งเข้าไปหาในตารางจริงอีกรอบ
        $aValidateData = array(
            'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
            'tFieldName'        => 'FTUsrCode',
            'tTableName'        => 'TCNMUser'
        );
        FCNnMasTmpChkCodeDupInDB($aValidateData);
		echo json_encode($aResDel);
	}

	// ย้ายรายการจาก Temp ไปยัง Master
	public function FSaCUSRImportMove2Master(){
		$aDataMaster = array(
			'nLangEdit'				=> $this->session->userdata("tLangEdit"),
			'tTableKey'				=> 'TCNMUser',
			'tSessionID'			=> $this->session->userdata("tSesSessionID"),
			'dDateOn'				=> date('Y-m-d H:i:s'),
			'dUserDateStart'		=> date('Y-m-d'),
			'dUserDateStop'			=> date('Y-m-d', strtotime('+1 year')),
			'tUserBy'				=> $this->session->userdata("tSesUsername"),
			'tTypeCaseDuplicate' 	=> $this->input->post('tTypeCaseDuplicate')
		);
		$this->db->trans_begin();
        $this->mUser->FSaMUSRImportMove2Master($aDataMaster);
        $this->mUser->FSaMUSRImportMove2MasterAndReplaceOrInsert($aDataMaster);
        $this->mUser->FSaMUSRImportMove2MasterDeleteTemp($aDataMaster);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$aReturnToHTML = array(
				'tCode'     => '99',
				'tDesc'     => 'Error'
			);
		}else{
			$this->db->trans_commit();
            $aReturnToHTML = array(
                'tCode'     => '1',
                'tDesc'     => 'success'
            );
		}

		echo json_encode($aReturnToHTML);
    }
    
    public function FSaCUSRImportGetItemAll(){
        $aResult  = $this->mUser->FSaMUSRGetTempDataAtAll();
		echo json_encode($aResult);
    }
}






