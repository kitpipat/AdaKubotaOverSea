<?php
//Move File Image From system/temp To Folder destination
//10/04/2018 Krit(Copter)
function FCNnHAddImgObj($paImgData){
	// print_r($paImgData);
	$ci = &get_instance();
	$ci->load->database();
	if(is_array($paImgData) && isset($paImgData)){
		if(!empty($paImgData['tImgObj'])){

			// เช็ค Folder System
			if(!is_dir('./application/modules/'.$paImgData['tModuleName'].'/assets/systemimg')){
				mkdir('./application/modules/'.$paImgData['tModuleName'].'/assets/systemimg');
			}

			//เช็ค ไฟล์ Folder Image 
			if(!is_dir('./application/modules/'.$paImgData['tModuleName'].'/assets/systemimg/'.$paImgData['tImgFolder'])){
				mkdir('./application/modules/'.$paImgData['tModuleName'].'/assets/systemimg/'.$paImgData['tImgFolder']);
			}

			//เช็ค ไฟล์ Folder Image Ref ID
			if(!is_dir('./application/modules/'.$paImgData['tModuleName'].'/assets/systemimg/'.$paImgData['tImgFolder']."/".$paImgData['tImgRefID'])){
				mkdir('./application/modules/'.$paImgData['tModuleName'].'/assets/systemimg/'.$paImgData['tImgFolder']."/".$paImgData['tImgRefID']);
			}

			if(!empty($paImgData['nStaDelBeforeEdit']) && $paImgData['nStaDelBeforeEdit'] == 1){
				$files	= glob('application/modules/'.$paImgData['tModuleName'].'/assets/systemimg/'.$paImgData['tImgFolder']."/".$paImgData['tImgRefID']."/*"); // get all file names
				foreach($files as $file){ // iterate files
					if(is_file($file))
						unlink($file); // delete file
				}
			}

			if(isset($paImgData['nStaImageMulti']) && $paImgData['nStaImageMulti'] == 1){
				// ******* Image Multiple
				$ci->db->trans_begin();

				$aImgData	= $paImgData['tImgObj'];
				$nCountImg	= count($aImgData);
				// Delete Image Obj
				$ci->db->where('FTImgRefID',$paImgData['tImgRefID']);
				$ci->db->where('FTImgTable',$paImgData['tImgTable']);
				$ci->db->where('FTImgKey',$paImgData['tImgKey']);
				$ci->db->delete($paImgData['tTableInsert']);

				for ($i = 0; $i < $nCountImg; $i++){
					$tParthImg 			= $paImgData['tModuleName'].'/assets/systemimg/'.$paImgData['tImgFolder']."/".$paImgData['tImgRefID']."/".$aImgData[$i];
					$aUrlPathServer 	= explode('/index.php',$_SERVER['SCRIPT_FILENAME']);
					$tPathFullComputer	= str_replace('\\', "/", $aUrlPathServer[0]. "/application/modules/");
					$ci->db->insert($paImgData['tTableInsert'],array(
						'FTImgRefID' 	=> $paImgData['tImgRefID'],
						'FNImgSeq'		=> $i+1,
						'FTImgTable'	=> $paImgData['tImgTable'],
						'FTImgKey'		=> $paImgData['tImgKey'],
						'FTImgObj'		=> $tPathFullComputer.$tParthImg,
						'FDLastUpdOn'	=> $paImgData['dDateTimeOn'],
						'FDCreateOn'	=> $paImgData['dDateTimeOn'],
						'FTLastUpdBy'	=> $paImgData['tWhoBy'],
						'FTCreateBy'	=> $paImgData['tWhoBy'],
					));
					if($ci->db->trans_status() === false){
						$ci->db->trans_rollback();
					}else{
						$ci->db->trans_commit();
						if(file_exists('application/modules/common/assets/system/systemimage/'.$ci->session->tSesUsername."/".$aImgData[$i])){
							copy(APPPATH.'modules/common/assets/system/systemimage/'.$ci->session->tSesUsername."/".$aImgData[$i]
							, APPPATH.'modules/'.$tParthImg);
						}
					}
				}
			}else{
				// ******* Single  Image
				// Delete Data Image Obj
				$ci->db->trans_begin();

				$ci->db->where('FTImgRefID',$paImgData['tImgRefID']);
				$ci->db->where('FTImgTable',$paImgData['tImgTable']);
				$ci->db->where('FTImgKey',$paImgData['tImgKey']);
				$ci->db->delete($paImgData['tTableInsert']);

				$tParthImg 			= $paImgData['tModuleName'].'/assets/systemimg/'.$paImgData['tImgFolder']."/".$paImgData['tImgRefID']."/".$paImgData['tImgObj'];
				$aUrlPathServer 	= explode('/index.php',$_SERVER['SCRIPT_FILENAME']);
				$tPathFullComputer	= str_replace('\\', "/", $aUrlPathServer[0]. "/application/modules/");

				$ci->db->insert($paImgData['tTableInsert'],array(
					'FTImgRefID' 	=> $paImgData['tImgRefID'],
					'FNImgSeq'		=> 1,
					'FTImgTable'	=> $paImgData['tImgTable'],
					'FTImgKey'		=> $paImgData['tImgKey'],
					'FTImgObj'		=> $tPathFullComputer.$tParthImg,
					'FDLastUpdOn'	=> $paImgData['dDateTimeOn'],
					'FDCreateOn'	=> $paImgData['dDateTimeOn'],
					'FTLastUpdBy'	=> $paImgData['tWhoBy'],
					'FTCreateBy'	=> $paImgData['tWhoBy'],
				));
				if($ci->db->trans_status() === false){
					$ci->db->trans_rollback();
				}else{
					$ci->db->trans_commit();
					if(file_exists('application/modules/common/assets/system/systemimage/'.$ci->session->tSesUsername."/".$paImgData['tImgObj'])){
						copy(APPPATH.'modules/common/assets/system/systemimage/'.$ci->session->tSesUsername."/".$paImgData['tImgObj'], APPPATH.'modules/'.$tParthImg);
					}
				}
			}
		}
	}
}

// Delete In Folder
function FSnHDeleteImageFiles($paImgDel){
	$ci	= &get_instance();
	$ci->load->database();
	if(is_array($paImgDel) && isset($paImgDel)){
		if(isset($paImgDel['tImgRefID']) && is_array($paImgDel['tImgRefID'])){
			foreach($paImgDel['tImgRefID'] AS $tKeyRefID){
				if(is_dir('./application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$tKeyRefID)){
					$nNum = count($paImgDel['tImgRefID']);
					if($nNum > 1){ /*ลบหลาย Row*/
						
						for($i = 0; $i < $nNum; $i++){
							$tIDCode = preg_replace('/\s+/', '', $paImgDel['tImgRefID'][$i]); /* ลบ ช่องว่าง */
							$files = glob('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$tIDCode.'/*'); //get all file names
							foreach($files as $file){
								if(is_file($file))
									unlink($file); //delete file
							}
							if (!is_dir('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$tIDCode)) {
								mkdir('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$tIDCode);
							}
							rmdir('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$tIDCode);
						}
					}else{ /*ลบ 1 Row*/
						
						$files = glob('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$paImgDel['tImgRefID'] .'/*'); //get all file names
						foreach($files as $file){
							if(is_file($file))
								unlink($file); //delete file
						}
						if (!is_dir('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$paImgDel['tImgRefID'] )) {
							mkdir('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$paImgDel['tImgRefID']);
						}
						rmdir('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$paImgDel['tImgRefID']);
					}
				}
			}
		}else{
			
			if(is_dir('./application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$paImgDel['tImgRefID'])){
				$files = glob('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$paImgDel['tImgRefID'] .'/*'); //get all file names
				foreach($files as $file){
					if(is_file($file))
						unlink($file); //delete file
				}
				if (!is_dir('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$paImgDel['tImgRefID'] )) {
					mkdir('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$paImgDel['tImgRefID']);
				}
				rmdir('application/modules/'.$paImgDel['tModuleName'].'/assets/systemimg/'.$paImgDel['tImgFolder'].'/'.$paImgDel['tImgRefID']);
			}else{
				
			}
		}
	}else{}
}

// Delete In DB
function FSnHDelectImageInDB($paImgDel){
	$ci	= &get_instance();
	$ci->load->database();

	$tTableDel	= $paImgDel['tTableDel'];
	$tImgRefID  = $paImgDel['tImgRefID'];
	$tImgTable  = $paImgDel['tImgTable'];

	$ci->db->trans_begin();
	if(!is_array($tImgRefID)){
		$tQueryGroup =	"	DELETE FROM $tTableDel
							WHERE FTImgRefID	= '$tImgRefID' 
							AND FTImgTable		= '$tImgTable'
		";
		$oQuery = $ci->db->query($tQueryGroup);
	}else{
		for($i=0; $i<count($tImgRefID); $i++){
			$tQueryGroup	= 	"	DELETE FROM $tTableDel
									WHERE FTImgRefID 	= '$tImgRefID[$i]' 
									AND FTImgTable		= '$tImgTable'
			";
			$oQuery = $ci->db->query($tQueryGroup);
		}
	}
	if ($ci->db->trans_status() === FALSE){
		$ci->db->trans_rollback();
		return 0;
	}else{
		$ci->db->trans_commit();
		return 1;
	}
}







// //Delete Image in database - normal
// function FSnHDeleteImageInDatabase($paImgDel){
// 	$ci = &get_instance();
// 	$ci->load->database();

// 	$ptImgTable = 'TCNMImgObj';
// 	$tImgRefID  = $paImgDel['tImgRefID'];
// 	$tImgTable  = $paImgDel['tImgTable'];

// 	if(count($tImgRefID) == 1 ){
// 		$tQueryGroup = "DELETE FROM TCNMImgObj
// 						WHERE FTImgRefID = '".$tImgRefID."' 
// 						AND FTImgTable = '".$tImgTable."' ";
// 		$oQuery = $ci->db->query($tQueryGroup);
// 	}else{
// 		for($i=0; $i<count($tImgRefID); $i++){
// 			$tQueryGroup = "DELETE FROM TCNMImgObj
// 							WHERE FTImgRefID = '".$tImgRefID[$i]."' 
// 							AND FTImgTable = '".$tImgTable."' ";
// 			$oQuery = $ci->db->query($tQueryGroup);
// 		}
// 	}
// }

// //Delete Image in database - person
// function FSnHDeleteImageInDatabasePerson($paImgDel){
// 	$ci = &get_instance();
// 	$ci->load->database();

// 	$tImgRefID  = $paImgDel['tImgRefID'];
// 	$tImgTable  = $paImgDel['tImgTable'];

// 	if(count($tImgRefID) == 1 ){
// 		$tQueryGroup = "DELETE FROM TCNMImgPerson
// 						WHERE FTImgRefID = '".$tImgRefID."' 
// 						AND FTImgTable = '".$tImgTable."' ";
// 		$oQuery = $ci->db->query($tQueryGroup);
// 	}else{
// 		for($i=0; $i<count($tImgRefID); $i++){
// 			$tQueryGroup = "DELETE FROM TCNMImgPerson
// 							WHERE FTImgRefID = '".$tImgRefID[$i]."' 
// 							AND FTImgTable = '".$tImgTable."' ";
// 			$oQuery = $ci->db->query($tQueryGroup);
// 		}
// 	}
// }

// /**
// * Natt add
// **/

// function FSaHAddImgObj($ptImgRefID, $ptImgSeq, $ptImgTable, $ptImgType, $ptImgKey, $ptNameImg, $ptPathImg) {	
// 	$ci = &get_instance();
// 	$ci->load->database();
// 	$ci->db->insert($ptImgTable,array(
// 		'FNImgRefID' => $ptImgRefID,
// 		'FTImgType' => $ptImgType,
// 		'FNImgSeq' => $ptImgSeq,
// 		'FTImgKey' => $ptImgKey,
// 		'FTImgObj' => 'application/modules/common/assets/images/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg,
// 	));	
// 	if (!file_exists('application/modules/common/assets/images/'.$ptPathImg.'/'.$ptImgRefID)) {
// 		mkdir('application/modules/common/assets/images/'.$ptPathImg.'/'.$ptImgRefID, 0777, true);	    
// 	}	
// 	copy('application/modules/common/assets/images/'.$ci->session->tSesUsername.'/'.$ptNameImg , 'application/modules/common/assets/images/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg);
// }


function FSaHUpdateImgObj($ptImgRefID, $ptImgTable, $ptImgType, $ptImgKey, $ptNameImg, $ptPathImg) {	
	$ci = &get_instance();
	$ci->load->database();
	$ci->db->select('FNImgRefID');
	$ci->db->where('FNImgRefID', $ptImgRefID);
	$ci->db->where('FTImgType', $ptImgType);
	$ci->db->where('FNImgSeq', 1);
	$ci->db->where('FTImgKey', 'main');
	$ci->db->from($ptImgTable);
	$oQ = $ci->db->get();
	$count = $oQ->result();
	if (@count($count) >= 1) {
		$ci->db->where ( 'FNImgRefID', $ptImgRefID );
		$ci->db->where ( 'FTImgType', $ptImgType);
		$ci->db->where ( 'FTImgKey', 'main');
		$ci->db->update ( $ptImgTable, array (
			'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg
		) );
	} else {
		$ci->db->insert($ptImgTable,array(
			'FNImgRefID' => $ptImgRefID,
			'FTImgType' => $ptImgType,
			'FNImgSeq' => 1,
			'FTImgKey' => 'main',
			'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg,
		));	
	}
	if (!file_exists('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID)) {
		mkdir('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID, 0777, true);	    
	}
	$files = glob('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/*'); //get all file names
	foreach($files as $file){
		if(is_file($file))
	    unlink($file); //delete file
}
copy('application/assets/system/systemimage/'.$ci->session->tSesUsername.'/'.$ptNameImg , 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg);
}

// function FSaHUpdateImg($ptImgRefID, $nSeq, $ptImgTable, $ptImgType, $ptImgKey, $ptNameImg, $ptPathImg) {	
// 	$ci = &get_instance();
// 	$ci->load->database();
// 	$ci->db->select('FNImgRefID');
// 	$ci->db->where('FNImgRefID', $ptImgRefID);
// 	$ci->db->where('FTImgType', $ptImgType);
// 	$ci->db->where('FNImgSeq', $nSeq);
// 	$ci->db->where('FTImgKey', $ptImgKey);
// 	$ci->db->from($ptImgTable);
// 	$oQ = $ci->db->get();
// 	$count = $oQ->result();
// 	if (@count($count) >= 1) {
// 		$ci->db->where ( 'FNImgRefID', $ptImgRefID );
// 		$ci->db->where ( 'FTImgType', $ptImgType);
// 		$ci->db->where ( 'FNImgSeq', $nSeq);
// 		$ci->db->where ( 'FTImgKey', $ptImgKey);
// 		$ci->db->update ( $ptImgTable, array (
// 			'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg
// 		) );
// 	} else {
// 		$ci->db->insert($ptImgTable,array(
// 			'FNImgRefID' => $ptImgRefID,
// 			'FTImgType' => $ptImgType,
// 			'FNImgSeq' => $nSeq,
// 			'FTImgKey' => $ptImgKey,
// 			'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg,
// 		));
// 	}
// 	if (!file_exists('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID)) {
// 		mkdir('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID, 0777, true);	    
// 	}
// 	//unlink('application/assets/system/'.$ptPathImg.'/'.$ptImgRefID.'/'.$count[0]->FTImgObj);
// 	copy('application/assets/system/tempimage/'.$ci->session->tSesUsername.'/'.$ptNameImg , 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg);
// }

function FSaHDelImgObj($ptImgID, $ptTableDel, $ptNameImg, $ptImgTable) {	
	$ci = &get_instance();
	$ci->load->database();
	$ci->db->delete($ptTableDel, array(
		'FTImgRefID' => $ptImgID,
		'FTImgTable' => $ptImgTable,
	));	
	// unlink($ptNameImg);
}

// function FSaDelImg($ptImgRefID, $ptImgTable, $ptImgType, $ptImgKey, $ptPathImg) {	
// 	$ci = &get_instance();
// 	$ci->load->database();
// 	$ci->db->where ( 'FNImgRefID', $ptImgRefID);
// 	$ci->db->where ( 'FTImgType', $ptImgType);
// 	$ci->db->where ( 'FTImgKey', $ptImgKey);
// 	$ci->db->delete ($ptImgTable);
// 	$files = glob('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/*'); //get all file names
// 	foreach($files as $file){
// 		if(is_file($file))
// 	    unlink($file); //delete file
// }
// @rmdir('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID);
// }
// /********************************************************************************************/
// function FSxCNAddImgObj($ptImgRefID, $ptImgSeq, $ptImgTable, $ptImgKey, $ptNameImg, $ptPathImg, $ptFImgTable) {	
// 	$ci = &get_instance();
// 	$ci->load->database();
// 	$ci->db->insert($ptImgTable,array(
// 		'FTImgRefID' => $ptImgRefID,
// 		'FNImgSeq' => $ptImgSeq,
// 		'FTImgKey' => $ptImgKey,
// 		'FTImgTable' => $ptFImgTable,
// 		'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg,
// 	));	
// 	if (!file_exists('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID)) {
// 		mkdir('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID, 0777, true);	    
// 	}	
// 	copy('application/assets/system/tempimage/'.$ci->session->tSesUsername.'/'.$ptNameImg , 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg);
// }
// function FSxCNUpdateImgObj($ptImgRefID, $ptImgTable, $ptImgKey, $ptNameImg, $ptPathImg, $ptFImgTable) {	
// 	$ci = &get_instance();
// 	$ci->load->database();
// 	$ci->db->select('FTImgRefID');
// 	$ci->db->where('FTImgRefID', $ptImgRefID);
// 	$ci->db->where('FNImgSeq', 1);
// 	$ci->db->where('FTImgKey', 'main');
// 	$ci->db->where('FTImgTable', $ptFImgTable);
// 	$ci->db->from($ptImgTable);
// 	$oQ = $ci->db->get();
// 	$count = $oQ->result();
// 	if (@count($count) >= 1) {
// 		$ci->db->where ( 'FTImgRefID', $ptImgRefID );
// 		$ci->db->where ( 'FTImgKey', 'main');
// 		$ci->db->where('FTImgTable', $ptFImgTable);
// 		$ci->db->update ( $ptImgTable, array (
// 			'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg
// 		) );
// 	} else {
// 		$ci->db->insert($ptImgTable,array(
// 			'FTImgRefID' => $ptImgRefID,
// 			'FNImgSeq' => 1,
// 			'FTImgKey' => 'main',
// 			'FTImgTable' => $ptFImgTable,
// 			'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg,
// 		));	
// 	}
// 	if (!file_exists('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID)) {
// 		mkdir('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID, 0777, true);	    
// 	}
// 	$files = glob('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/*'); //get all file names
// 	foreach($files as $file){
// 		if(is_file($file))
// 	    unlink($file); //delete file
// }
// copy('application/assets/system/tempimage/'.$ci->session->tSesUsername.'/'.$ptNameImg , 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg);
// }

// function FSxCNUpdateImg($ptImgRefID, $nSeq, $ptImgTable, $ptImgKey, $ptNameImg, $ptPathImg, $ptFImgTable) {	
// 	$ci = &get_instance();
// 	$ci->load->database();
// 	$ci->db->select('FTImgRefID');
// 	$ci->db->where('FTImgRefID', $ptImgRefID);
// 	$ci->db->where('FNImgSeq', $nSeq);
// 	$ci->db->where('FTImgKey', $ptImgKey);
// 	$ci->db->where('FTImgTable', $ptFImgTable);
// 	$ci->db->from($ptImgTable);
// 	$oQ = $ci->db->get();
// 	$count = $oQ->result();
// 	if (@count($count) >= 1) {
// 		$ci->db->where ( 'FTImgRefID', $ptImgRefID );
// 		$ci->db->where ( 'FNImgSeq', $nSeq);
// 		$ci->db->where ( 'FTImgKey', $ptImgKey);
// 		$ci->db->where('FTImgTable', $ptFImgTable);
// 		$ci->db->update ( $ptImgTable, array (
// 			'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg
// 		) );
// 	} else {
// 		$ci->db->insert($ptImgTable,array(
// 			'FTImgRefID' => $ptImgRefID,
// 			'FNImgSeq' => $nSeq,
// 			'FTImgKey' => $ptImgKey,
// 			'FTImgTable' => $ptFImgTable,
// 			'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg,
// 		));
// 	}
// 	if (!file_exists('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID)) {
// 		mkdir('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID, 0777, true);	    
// 	}
// 	//unlink('application/assets/system/'.$ptPathImg.'/'.$ptImgRefID.'/'.$count[0]->FTImgObj);
// 	copy('application/assets/system/tempimage/'.$ci->session->tSesUsername.'/'.$ptNameImg , 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg);
// }

// function FSxCNDelImg($ptImgRefID, $ptImgTable, $ptImgKey, $ptPathImg, $ptFImgTable) {	
// 	$ci = &get_instance();
// 	$ci->load->database();
// 	$ci->db->where ( 'FTImgRefID', $ptImgRefID);
// 	$ci->db->where ( 'FTImgKey', $ptImgKey);
// 	$ci->db->where ( 'FTImgTable', $ptFImgTable);
// 	$ci->db->delete ($ptImgTable);
// 	$files = glob('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/*'); //get all file names
// 	foreach($files as $file){
// 		if(is_file($file))
// 	    unlink($file); //delete file
// 	}
// 	@rmdir('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID);
// }


// function FSxAddtextOn($text, $file, $out) { 
//   list($width, $height) = getimagesize($file);
//   $image_p = imagecreatetruecolor($width, $height);
//   $image = imagecreatefromjpeg($file);
//   imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height);
//   $text_color = imagecolorallocate($image_p, 0, 0, 0);
//   $bg_color = imagecolorallocate($image_p, 255, 255, 255);
//   $font = FCPATH.'application/libraries/image/ubuntu.ttf';
//   $tFontText = 12;
//   $dims = imagettfbbox($tFontText, 0, $font, $text);
//   $oImgHeight = (int)$height - (int)$tFontText;
//   imagefilledrectangle($image_p, (int)$width - 190, $height, $width, (int)$height - 40, $bg_color);
//   imagettftext($image_p, $tFontText, 0, (int)$width - 150, $oImgHeight, $text_color, $font, $text);
//   imagejpeg($image_p, $out, 100); 
//   imagedestroy($image); 
//   imagedestroy($image_p); 
// }

// function FSxPMTAddImg($ptImgRefID, $ptImgSeq, $ptImgTable, $ptImgKey, $ptNameImg, $ptPathImg, $ptFImgTable, $ptFTPmhCode) {
// 	require 'application/libraries/image/vendor/autoload.php';

// 	@header('Content-type: image/jpeg');
// 	require 'application/libraries/image/vendor/autoload.php';	
// 	$ci = &get_instance();
// 	$ci->load->database();
// 	@$ci->db->where ('FNImgRefID', $ptImgRefID);
// 	@$ci->db->where ('FNImgSeq', $ptImgSeq);
// 	@$ci->db->where ('FTImgKey', $ptImgKey);
// 	@$ci->db->where ('FTImgTable', $ptFImgTable);
// 	@$ci->db->delete ($ptImgTable);
// 	$files = glob('application/assets/system/eticket/promotion/'.$ptImgRefID.'/*'); //get all file names
// 	foreach($files as $file){
// 		if(is_file($file))
// 	    unlink($file); //delete file
// 	}
// 	$ci->db->insert($ptImgTable,array(
// 		'FNImgRefID' => $ptImgRefID,
// 		'FNImgSeq' => $ptImgSeq,
// 		'FTImgKey' => $ptImgKey,
// 		'FTImgTable' => $ptFImgTable,
// 		'FTImgObj' => 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg,
// 	)); 
// 	if (!file_exists('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID)) {
// 		@mkdir('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID, 0777, true);     
// 	}
// 	$image = new \NMC\ImageWithText\Image('application/assets/system/tempimage/'.$ci->session->tSesUsername.'/'.$ptNameImg);
// 	$text1 = new \NMC\ImageWithText\Text('', 3, 25);
// 	//$text1 = new \NMC\ImageWithText\Text($ptFTPmhCode, 3, 25);
// 	$text1->align = 'right';
// 	$text1->color = 'FFFFFF';
// 	$text1->font = FCPATH.'application/libraries/image/ubuntu.ttf';
// 	$text1->lineHeight = 36;
// 	$text1->size = 24;
// 	$text1->startX = 5;
// 	$text1->startY = 110;
// 	$image->addText($text1);
// 	$image->render('application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg);
//     FSxAddtextOn($ptFTPmhCode, 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg, 'application/assets/system/eticket/'.$ptPathImg.'/'.$ptImgRefID.'/'.$ptNameImg);
// }