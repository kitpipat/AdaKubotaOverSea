<?php defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

class Login_controller extends MX_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library( "session" );
		if(@$_SESSION['tSesUsername'] == true) {
			redirect( '', 'refresh' );
			exit();
		}
	}

	public function index() {
		$this->load->view('authen/login/wLogin');
	}

	//Functionality: ตรวจสอบการเข้าใช้งานระบบ
	//Parameters:  รับค่าจากฟอร์ม type POST
	//Creator: 23/03/2018 Phisan(Arm)
	//Last Modified :
	//Return : Error Code
	//Return Type: Redirect
	public function FSaCLOGChkLogin(){
		//try {
			$tUsername	= $this->input->post('oetUsername'); //ชื่อผู้ใช้
			$tPassword	= $this->input->post('oetPasswordhidden'); //รหัสผ่าน

			//   ตรวจสอบการล็อกอิน
			$this->load->model('authen/login/Login_model');

			$aDataUsr = $this->Login_model->FSaMLOGChkLogin($tUsername,$tPassword);
			if(!empty($aDataUsr[0])){

				$this->session->set_userdata("tSesUserLogin", $tUsername);
				if($aDataUsr[0]['FTUsrStaActive'] == '3'){
					$aReturn = array(
						'nStaReturn'		=> 3,
						'tMsgReturn'		=> 'Reset Password',
						'tUsrLogType'		=> $aDataUsr[0]['FTUsrLogType']
					);
				}else{
					// Create By : Napat(Jame) 12/05/2020
					$aDataUsrGroup = $this->Login_model->FSaMLOGGetDataUserLoginGroup($aDataUsr[0]['FTUsrCode']);
					$aDataUsrRole  = $this->Login_model->FSaMLOGGetUserRole($aDataUsr[0]['FTUsrCode']);
					$aDataDefCty   = $this->Login_model->FSaMGetCountry($aDataUsrGroup[0]['FTAgnCode']);
					$aDataDefLanguage   = $this->Login_model->FSaMGetLanguage($aDataDefCty);
					if(empty($aDataUsrGroup[0]['FTMerCode']) && empty($aDataUsrGroup[0]['FTBchCode']) && empty($aDataUsrGroup[0]['FTShpCode'])){
						$aDataComp 			= $this->Login_model->FSaMLOGGetBch();

						$tUsrAgnCodeDefult  = $aDataUsrGroup[0]['FTAgnCode'];
						$tUsrAgnNameDefult  = $aDataUsrGroup[0]['FTAgnName'];
						
						$tUsrMerCodeDefult  = '';
						$tUsrMerNameDefult  = '';

						if($aDataUsrGroup[0]['FTLoginLevel'] != 'HQ'){
							$tUsrBchCodeDefult  = '';
							$tUsrBchNameDefult  = '';

							$tUsrBchCodeMulti	= "''";
							$tUsrBchNameMulti	= "''";
						}else{
							$tUsrBchCodeDefult  = $aDataComp[0]['FTBchCode'];
							$tUsrBchNameDefult  = $aDataComp[0]['FTBchName'];

							$tUsrBchCodeMulti	= "'".$aDataComp[0]['FTBchCode']."'";
							$tUsrBchNameMulti	= "'".$aDataComp[0]['FTBchName']."'";
						}

						$nUsrBchCount		= 0;

						$tUsrShpCodeDefult  = $aDataComp[0]['FTShpCode'];
						$tUsrShpNameDefult  = $aDataComp[0]['FTShpName'];
						$tUsrShpCodeMulti 	= "'".$aDataComp[0]['FTShpCode']."'";
						$tUsrShpNameMulti 	= "'".$aDataComp[0]['FTShpName']."'";
						$nUsrShpCount		= 0;

						$tUsrWahCodeDefult  = $aDataComp[0]['FTWahCode'];
						$tUsrWahNameDefult  = $aDataComp[0]['FTWahName'];
					}else{
						$tUsrAgnCodeDefult  = $aDataUsrGroup[0]['FTAgnCode'];
						$tUsrAgnNameDefult  = $aDataUsrGroup[0]['FTAgnName'];

						$tUsrMerCodeDefult  = $aDataUsrGroup[0]['FTMerCode'];
						$tUsrMerNameDefult  = $aDataUsrGroup[0]['FTMerName'];

						$tUsrBchCodeDefult  = $aDataUsrGroup[0]['FTBchCode'];
						$tUsrBchNameDefult  = $aDataUsrGroup[0]['FTBchName'];
						$tUsrBchCodeMulti 	= $this->Login_model->FStMLOGMakeArrayToString($aDataUsrGroup,'FTBchCode','value');
						$tUsrBchNameMulti 	= $this->Login_model->FStMLOGMakeArrayToString($aDataUsrGroup,'FTBchName','value');
						$nUsrBchCount		= $this->Login_model->FStMLOGMakeArrayToString($aDataUsrGroup,'FTBchCode','counts');

						$tUsrShpCodeDefult  = $aDataUsrGroup[0]['FTShpCode'];
						$tUsrShpNameDefult  = $aDataUsrGroup[0]['FTShpName'];
						$tUsrShpCodeMulti 	= $this->Login_model->FStMLOGMakeArrayToString($aDataUsrGroup,'FTShpCode','value');
						$tUsrShpNameMulti 	= $this->Login_model->FStMLOGMakeArrayToString($aDataUsrGroup,'FTShpName','value');
						$nUsrShpCount		= $this->Login_model->FStMLOGMakeArrayToString($aDataUsrGroup,'FTShpCode','counts');

						$tUsrWahCodeDefult  = $aDataUsrGroup[0]['FTWahCode'];
						$tUsrWahNameDefult  = $aDataUsrGroup[0]['FTWahName'];
					}
					$tUsrRoleMulti = $this->Login_model->FStMLOGMakeArrayToString($aDataUsrRole,'FTRolCode','value');
					$nUsrRoleLevel  = $this->Login_model->FSaMLOGGetUserRoleLevel($tUsrRoleMulti);

					// Login Level
					$this->session->set_userdata("tSesUsrLoginLevel", $aDataUsrGroup[0]['FTLoginLevel']);

					// User Role
					$this->session->set_userdata("tSesUsrRoleCodeMulti", $tUsrRoleMulti);
					$this->session->set_userdata("nSesUsrRoleLevel", $nUsrRoleLevel);

					// Agency
					$this->session->set_userdata("tSesUsrAgnCode", $tUsrAgnCodeDefult);
					$this->session->set_userdata("tSesUsrAgnName", $tUsrAgnNameDefult);

					// PdtPriList
					$this->session->set_userdata("tSesUsrPplCode", $aDataUsrGroup[0]['FTPplCode']);

					// Default Country
					$this->session->set_userdata("tSesDefCountry", $aDataDefCty);
					$this->session->set_userdata("tSesDefLanguage", $aDataDefLanguage);
					

					// Merchant
					$this->session->set_userdata("tSesUsrMerCode", $tUsrMerCodeDefult);
					$this->session->set_userdata("tSesUsrMerName", $tUsrMerNameDefult);

					// Branch
					$this->session->set_userdata("tSesUsrBchCodeDefault", $tUsrBchCodeDefult);
					$this->session->set_userdata("tSesUsrBchNameDefault", $tUsrBchNameDefult);
					$this->session->set_userdata("tSesUsrBchCodeMulti", $tUsrBchCodeMulti);
					$this->session->set_userdata("tSesUsrBchNameMulti", $tUsrBchNameMulti);
					$this->session->set_userdata("nSesUsrBchCount", $nUsrBchCount);

					// Shop
					$this->session->set_userdata("tSesUsrShpCodeDefault", $tUsrShpCodeDefult);
					$this->session->set_userdata("tSesUsrShpNameDefault", $tUsrShpNameDefult);
					$this->session->set_userdata("tSesUsrShpCodeMulti", $tUsrShpCodeMulti);
					$this->session->set_userdata("tSesUsrShpNameMulti", $tUsrShpNameMulti);
					$this->session->set_userdata("nSesUsrShpCount", $nUsrShpCount);

					// WaHouse
					$this->session->set_userdata("tSesUsrWahCode", $tUsrWahCodeDefult);
					$this->session->set_userdata("tSesUsrWahName", $tUsrWahNameDefult);

					// $aTest = array(
					// 	'tUsrCode'	=> $aDataUsr[0]['FTUsrCode'],
					// 	'nSesUsrRoleLevel'	=> $this->session->userdata("nSesUsrRoleLevel"),
					// 	'tSesUsrRoleCodeMulti' => $this->session->userdata("tSesUsrRoleCodeMulti"),

					// 	'tSesUsrAgnCode' => $this->session->userdata("tSesUsrAgnCode"),
					// 	'tSesUsrAgnName' => $this->session->userdata("tSesUsrAgnName"),

					// 	'tSesUsrMerCodeDefault' => $this->session->userdata("tSesUsrMerCode"),
					// 	'tSesUsrMerNameDefault' => $this->session->userdata("tSesUsrMerName"),

					// 	'tSesUsrBchCodeDefault' => $this->session->userdata("tSesUsrBchCodeDefault"),
					// 	'tSesUsrBchNameDefault' => $this->session->userdata("tSesUsrBchNameDefault"),
					// 	'tSesUsrBchCodeMulti' => $this->session->userdata("tSesUsrBchCodeMulti"),
					// 	'tSesUsrBchNameMulti' => $this->session->userdata("tSesUsrBchNameMulti"),
					// 	'nSesUsrBchCount' => $this->session->userdata("nSesUsrBchCount"),

					// 	'tSesUsrShpCodeDefault' => $this->session->userdata("tSesUsrShpCodeDefault"),
					// 	'tSesUsrShpNameDefault' => $this->session->userdata("tSesUsrShpNameDefault"),
					// 	'tSesUsrShpCodeMulti' => $this->session->userdata("tSesUsrShpCodeMulti"),
					// 	'tSesUsrShpNameMulti' => $this->session->userdata("tSesUsrShpNameMulti"),
					// 	'nSesUsrShpCount' => $this->session->userdata("nSesUsrShpCount"),

					// 	'tSesUsrWahCode'	=> $this->session->userdata("tSesUsrWahCode"),
					// 	'tSesUsrWahName'	=> $this->session->userdata("tSesUsrWahName"),
					// );
					// echo "<pre>";
					// print_r($aTest);
					// exit;

					// $aUsrBch = $this->Login_model->FSaMLOGGetUsrBch($aDataUsr[0]['FTUsrCode']);
					// $tUsrBchCode = $this->Login_model->FStMLOGMakeArrayToStringUsrBch($aUsrBch,1);
					// $tUsrBchName = $this->Login_model->FStMLOGMakeArrayToStringUsrBch($aUsrBch,2);

					//  ******** Create by Witsarut Add UsrShp  ********
					// $aUsrBchShp 	= $this->Login_model->FSaMLOGGetUsrBchShp($aDataUsr[0]['FTUsrCode']);
					// $tUsrBchCode 	= $this->Login_model->FStMLOGMakeArrayToStringUsrBchShp($aUsrBchShp,1);
					// $tUsrBchName 	= $this->Login_model->FStMLOGMakeArrayToStringUsrBchShp($aUsrBchShp,2);
					//  ******** Create by Witsarut Add UsrShp  ********


					// $this->session->set_userdata ("tSesUsrBchIn", $tUsrBchCode);
					// $this->session->set_userdata ("tSesUsrBchNameIn", $tUsrBchName);

					// echo $this->session->userdata("tSesUsrBchIn");
					// die();
					//case : เข้ามาแบบ HQ จะใช้ tSesUsrBchCom
					//     : เข้ามาแบบ BCH , SHP จะใช้ tSesUsrBchCode
					// if(empty($aDataUsr)){
					// 	$aGetDataBch = $this->Login_model->FSaMLOGGetBch();
					// 	$aGetBch 		= $aGetDataBch[0]['FTBchCode'];
					// 	$aGetBchName 	= $aGetDataBch[0]['FTBchName'];
					// 	$tWahCode		= $aGetDataBch[0]['FTWahCode'];
					// 	$tWahName		= $aGetDataBch[0]['FTWahName'];
					// }else{
					// 	$aGetBch 		= $aDataUsr[0]['FTBchCode'];
					// 	$aGetBchName 	= $aDataUsr[0]['FTBchName'];
					// 	$tWahCode		= $aDataUsr[0]['FTWahCode'];
					// 	$tWahName		= $aDataUsr[0]['FTWahName'];
					// }

					// $this->session->set_userdata ("tSesUsrBchCom", $aGetBch);
					// $this->session->set_userdata ("tSesUsrBchNameCom", $aGetBchName);


					$this->session->set_userdata('bSesLogIn',TRUE);
					$this->session->set_userdata("tSesUserCode", $aDataUsr[0]['FTUsrCode']);
					$this->session->set_userdata("tSesUsername", $aDataUsr[0]['FTUsrCode']);
					$this->session->set_userdata("tSesUsrDptName", $aDataUsr[0]['FTDptName']);
					$this->session->set_userdata("tSesUsrDptCode", $aDataUsr[0]['FTDptCode']);
					// $this->session->set_userdata("tSesUsrRoleCode", $aDataUsr[0]['FTRolCode']);
					// $this->session->set_userdata("tSesUsrBchCode", $aDataUsr[0]['FTBchCode']);
					// $this->session->set_userdata("tSesUsrBchName", $aDataUsr[0]['FTBchName']);
					// $this->session->set_userdata("tSesUsrShpCode", $aDataUsr[0]['FTShpCode']);
					// $this->session->set_userdata("tSesUsrShpName", $aDataUsr[0]['FTShpName']);
					// Name User
					$this->session->set_userdata("tSesUsrUsername", $aDataUsr[0]['FTUsrName']);
					// New Brach
					// $this->session->set_userdata("tSesUsrBchCodeOld", $aDataUsr[0]['FTBchCode']);
					// New sessionID for document

					// $this->session->set_userdata("tSesUsrMerCode", $aDataUsr[0]['FTMerCode']);
					// $this->session->set_userdata("tSesUsrMerName", $aDataUsr[0]['FTMerName']);
					// $this->session->set_userdata("tSesUsrWahCode", $tWahCode);
					// $this->session->set_userdata("tSesUsrWahName", $tWahName);

					$this->session->set_userdata("tSesUsrImagePerson", $aDataUsr[0]['FTImgObj']);

					$this->session->set_userdata("tSesUsrInfo", $aDataUsr[0]);
					$this->session->set_userdata("tSesUsrGroup", $aDataUsrGroup);

					$tDateNow = date('Y-m-d H:i:s');
					$tSessionID = $aDataUsr[0]['FTUsrCode'].date('YmdHis', strtotime($tDateNow));
					$this->session->set_userdata("tSesSessionID", $tSessionID);
					$this->session->set_userdata("tSesSessionDate", $tDateNow);

					$nLangEdit = $this->session->userdata("tLangEdit");
					if($nLangEdit == ''){
						$this->session->set_userdata( "tLangEdit", $this->session->userdata("tLangID") );
					}

					// User level
					if(empty($aDataUsrGroup[0]['FTBchCode']) && empty($aDataUsrGroup[0]['FTShpCode'])){ // HQ level
						$this->session->set_userdata("tSesUsrLevel", "HQ");
					}
					if(!empty($aDataUsrGroup[0]['FTBchCode']) && empty($aDataUsrGroup[0]['FTShpCode'])){ // BCH level
						$this->session->set_userdata("tSesUsrLevel", "BCH");
					}
					if(!empty($aDataUsrGroup[0]['FTBchCode']) && !empty($aDataUsrGroup[0]['FTShpCode'])){ // SHP level
						$this->session->set_userdata("tSesUsrLevel", "SHP");
					}


					//สร้าง session มาหลอกๆ ไว้เดียวมาลบ ให้มัน gencode ได้ก่อน
					$this->session->set_userdata("tSesUsrBchCode", '99999');
					$this->session->set_userdata("tSesUsrShpCode", '88888');

					FCNbLoadConfigIsShpEnabled();

					// Delete Doc Temp
					$this->load->helper('document');
					FCNoHDOCDeleteDocTmp();
					// End Delete Temp Card

					// Clear Report Temp
					$this->load->helper('report');
					FCNoHDOCClearRptTmp();

					// Delete Temp Card
					$this->load->helper('card');
					FCNoCARDataListDeleteAllTable();
					// End Delete Temp Card

					// redirect();

					$aReturn = array(
						'nStaReturn'	=> 1,
						'tMsgReturn'	=> 'Found Data'
					);

				}

			}else{
				$aReturn = array(
					'nStaReturn'	=> 99,
					'tMsgReturn'	=> 'Not Fround Data'
				);
			}
			// }

		// }catch(Exception $e) {
		// 	$aReturn = array(
		// 		'nStaReturn'	=> 500,
		// 		'tMsgReturn'	=> $e
		// 	);
		// 	// echo "Error Code: 500 !Server error".' '.$e;
		// }

		echo json_encode($aReturn);
	}


	// //Functionality: check file configdb ที่วันที่ น้อยกว่าวันปัจจุบัน เพื่อไม่ให้เป็นไฟล์ ขยะ
	// //Creator: 24/04/2019 Krit
	// public function FSxCLOGCheckDeleteFileConfigdb(){

	// 	$tPath = 'application/config/configDB/';
	// 	if(file_exists($tPath)){
	// 		$files = scandir($tPath);
	// 		foreach($files as $key => $filename) {
	// 			if($files[$key] > 1){

	// 				$dDateNow = date("d-m-Y");
	// 				$tFilenameNew = substr($filename, 0,8);
	// 				$nDay 	= substr($tFilenameNew,0,2); //Day
	// 				$nMonth = substr($tFilenameNew,2,2); //Month
	// 				$nYear 	= substr($tFilenameNew,4,4); //Month
	// 				$tDateNewFormat = $nDay."-".$nMonth."-".$nYear; //Implode Day month year
	// 				$dDateFileSource = strtotime($tDateNewFormat); //Set format date
	// 				$dDateFile = date('d-m-Y',$dDateFileSource); //Change format date

	// 				//Check Date Now > Date file for Del file old.
	// 				if($dDateNow > $dDateFile){
	// 					// echo "Del File: ".$filename."<br>";
	// 					unlink($tPath.$filename) or die("Couldn't delete file");
	// 				}
	// 			}
	// 		}
	// 	}else{
	// 		//No Folder
	// 	}
	// }

	//Functionality: รันสคริปท์ temp
	//Parameters:  -
	//Creator: 29/07/2020 Napat(Jame)
	//Last Modified : 05/08/2020 Napat(Jame) ปรับให้เป็นการรันแบบ แมนนวล
	//Return : -
	//Return Type: -
	public function FSaCLOGSetUpAdaStoreBack(){
		try {
			// Settings
			$this->load->model('authen/login/Login_model');
			$tDirScript     = "application/modules/authen/assets/SQLScript/*.sql";
			$nTotalScript   = count(glob($tDirScript));
			$nCount         = 0;
			$nSuccess       = 0;
			$nError         = 0;

			$tTimeStart = round(microtime(true) * 1000);
			echo "<div style='overflow-y:auto;height:70%;padding:15px;background-color:#efefef;border-radius:5px;'>";
			echo "<table>";
			if($nTotalScript > 0){
				$db_debug = $this->db->db_debug;
				$this->db->db_debug = FALSE;
				foreach (glob($tDirScript) as $tPathFile){
					echo "<tr>";
					$nCount++;
					$tFileName 			= basename($tPathFile,".sql");
					$tStatement  		= file_get_contents($tPathFile);
					$tTimeLoopStart 	= round(microtime(true) * 1000);
					$aStaExecute  		= $this->Login_model->FSaMLOGExecuteScript($tStatement);
					$tTimeLoopFinish 	= round(microtime(true) * 1000);
					$nDiffTimeProcess 	= $tTimeLoopFinish - $tTimeLoopStart;

					if( $aStaExecute['nStaQuery'] == 1 ){
						if( isset($aStaExecute['tStaMessage']) && $aStaExecute['tStaMessage']['code'] != '0000' ) {
							echo "<td>".$nCount.".</td>";
							echo "<td>".$tFileName."</td>";
							echo "<td><img src='application/modules/common/assets/images/icons/Not-Approve.png' width='18'></td>";
							echo "<td><span>$nDiffTimeProcess ms.</span> <span style='color:red;'>".$aStaExecute['tStaMessage']['message']."</span></td>";
							$nError++;
						}else{
							echo "<td>".$nCount.".</td>";
							echo "<td>".$tFileName."</td>";
							echo "<td><img src='application/modules/common/assets/images/icons/OK-Approve.png' width='18'></td>";
							echo "<td><span>$nDiffTimeProcess ms.</span></td>";
							$nSuccess++;
						}
					}else{
						print_r($aStaExecute['tStaMessage']);
					}
					echo "</tr>";
				}
				$this->db->db_debug = $db_debug;
			}else{
				echo "<tr><td align='center'>ไม่พบไฟล์สคริปท์ (".$tDirScript.")</td></tr>";
			}
			$tTimeFinish = round(microtime(true) * 1000);

			echo "</table>";
			echo "</div>";

			echo "<br>จำนวนทั้งหมด ".count(glob($tDirScript))." สคริปท์ <br>";
			echo "สำเร็จ ".$nSuccess." สคริปท์ <br>";
			echo "ล้มเหลว ".$nError." สคริปท์ <br>";

			$nDiffTimeProcess = ($tTimeFinish - $tTimeStart) / 1000;
			echo "<br>ใช้เวลา ".$nDiffTimeProcess." วินาที<br>";

		}catch(Exception $e) {
			print_r($e);
		}
	}

}
