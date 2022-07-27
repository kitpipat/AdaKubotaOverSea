<?php

//Update Join Value For Refund
function FCNCardShiftRefundJoinUpdateValue(){

    $ci = &get_instance();
    $ci->load->database();
    $ptSesstionID = $ci->session->userdata("tSesSessionID");

    $tSQL = "   UPDATE T
                    SET T.FCCtdCrdTP = C.FCCrdValue
                FROM TFNTCrdTopUpTmp T
                JOIN TFNMCard C
                    ON T.FTCrdCode = C.FTCrdCode
                WHERE T.FTSEssionID = '$ptSesstionID'";

    $oQuery = $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1;
    }else{
        return 0;
    }

}

//Delete Data All table - Temp
function FCNoCARDataListDeleteAllTable(){

    $ci = &get_instance();
    $ci->load->database();
    $ptSesstionID = $ci->session->userdata("tSesSessionID");
    $tDate = date('Y-m-d');

    //$ci->db->where_in('FTSessionID', $ptSesstionID);
    $ci->db->where('FDCreateOn <', $tDate);
    $ci->db->delete('TFNTCrdImpTmp');

    //$ci->db->where_in('FTSessionID', $ptSesstionID);
    $ci->db->where('FDCreateOn <', $tDate);
    $ci->db->delete('TFNTCrdShiftTmp');

    //$ci->db->where_in('FTSessionID', $ptSesstionID);
    $ci->db->where('FDCreateOn <', $tDate);
    $ci->db->delete('TFNTCrdTopUpTmp');

    //$ci->db->where_in('FTSessionID', $ptSesstionID);
    $ci->db->where('FDCreateOn <', $tDate);
    $ci->db->delete('TFNTCrdVoidTmp');

    if($ci->db->affected_rows() > 0){
        return 'success';
    }else{
        return 'fail';
    }
}

//Delete Data table where session - Temp
function FCNoCARDataListDeleteOnlyTable($ptTable){
    $ci= &get_instance();
    $ci->load->database();
    $ptSesstionID   = $ci->session->userdata("tSesSessionID");
    
    $ci->db->where_in('FTSessionID', $ptSesstionID);
    $ci->db->delete($ptTable);

    if($ci->db->affected_rows() > 0){
        return 'success';
    }else{
        return 'fail';
    }
}

//Insert Helper Center
function FCNaCARInsertDataToTempFileCenter($ptDocType,$ptDataSetType,$paDataExcel,$paDataSet){

    //ptDocType     = ชื่อหน้า
    //ptDataSetType = ชื่อ sheet 
    //paDataExcel   = data array excel
    //paDataSet     = xxx

    require_once (APPPATH.'third_party/PHPExcel/Classes/PHPExcel.php');
    require_once (APPPATH.'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php');
    require_once (APPPATH.'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

    switch($ptDataSetType){
        case 'Excel': //Excel - เหตุผล - option - มูลค่าที่เติม - Docno
            return FSaCCARTypeExcel($ptDocType,$ptDataSetType,$paDataExcel);
        break;

        case 'CreateCard': //New Card - รหัสบัตร - ประเภทบัตร - หน่วยงาน

        break;

        case 'CreateCardBetween': //New Card Between - การ์ดโค๊ด - prefix - เลขเริ่มต้น - จำนวนที่ต้องการสร้างบัตร - ประเภทบัตร - หน่วยงาน

        break;

        case 'Between': //Between - มูลค่าที่เติม - ประเภทบัตรแบบช่วง - การ์ดรหัสแบบช่วง
        
        break;

        case 'ChooseCard': //Chooset Card - รหัสบัตร - มูลค่า - รหัสบัตรใหม่(อาจเป็นค่าว่าง) 

        break;
    }
}

//Insert Excel
function FSaCCARTypeExcel($ptDocType,$ptDataSetType,$paDataExcel){
    $ci = &get_instance();
    $ci->load->database();
    set_time_limit(0);
    //E101 : ชื่อชีสไม่ถูกต้อง
    //E102 : column head ไม่ ถูกต้อง เกิน หรือ ขาด (field)
    if(isset($paDataExcel) && !empty($paDataExcel) && is_array($paDataExcel)){
        $oLoadExcel     = PHPExcel_IOFactory::load($paDataExcel['file']['tmp_name']);
        switch($ptDocType){
            case 'NewCard': //ใบสร้างบัตร - success
                $tTableName     = 'TFNTCrdImpTmp';
                $tSheetName     = 'NewCard';
                $nColumn        = 5;
                $tStatementSql  = "INSERT INTO TFNTCrdImpTmp (FTBchCode , FTCihDocNo , FNCidSeqNo , FTCidCrdCode , FTCtyCode , FTCidCrdDepart , FTCidCrdName , FTCidCrdHolderID , FTCidStaCrd , FTCidRmk , FDCreateOn , FTCreateBy , FTSessionID) VALUES ";
                $oSheetName     = $oLoadExcel->getSheetByName('NewCard');
                $aDataCondition = ['FTCidCrdCode','FTCtyCode','FTCidCrdHolderID','FTCidCrdDepart','FTCidCrdName'];
            break;

            case 'TopUp': //ใบเติมเงิน - success
                $tTableName     = 'TFNTCrdTopUpTmp';
                $tSheetName     = 'TopUp';
                $nColumn        = 2;
                $tStatementSql  = "INSERT INTO TFNTCrdTopUpTmp (FTBchCode , FTCthDocNo , FNCtdSeqNo , FTCrdCode , FCCtdCrdTP , FTCtdStaCrd , FTCtdRmk , FDCreateOn , FTCreateBy , FTSessionID) VALUES ";
                $oSheetName     = $oLoadExcel->getSheetByName('TopUp');
                $aDataCondition = ['FTCrdCode','FCCtdCrdTP'];
            break;

            case 'CardTnfChangeCard': //ใบเปลี่ยนบัตร - success
                $tTableName     = 'TFNTCrdVoidTmp';
                $tSheetName     = 'CardTnf';
                $nColumn        = 2;
                $tStatementSql  = "INSERT INTO TFNTCrdVoidTmp (FTBchCode , FTCvhDocNo , FNCvdSeqNo , FTCvdOldCode , FTCvdNewCode , FTCvdStaCrd , FTCvdRmk , FTRsnCode , FDCreateOn , FTCreateBy , FTSessionID) VALUES ";
                $oSheetName     = $oLoadExcel->getSheetByName('CardTnf');
                $aDataCondition = ['FTCvdOldCode','FTCvdNewCode'];
            break;

            case 'ClearCard': //ใบล้างบัตร - success
                $tTableName     = 'TFNTCrdImpTmp';
                $tSheetName     = 'ClrCard';
                $nColumn        = 1;
                $tStatementSql  = "INSERT INTO TFNTCrdImpTmp (FTBchCode , FTCihDocNo , FNCidSeqNo , FTCidCrdCode , FTCidStaCrd , FTCidRmk , FDCreateOn , FTCreateBy , FTSessionID) VALUES ";
                $oSheetName     = $oLoadExcel->getSheetByName('ClrCard');
                $aDataCondition = ['FTCidCrdCode'];
            break;
    
            case 'cardShiftOut': //ใบเบิกบัตร - success
                $tTableName     = 'TFNTCrdShiftTmp';
                $tSheetName     = 'CardTnf';
                $nColumn        = 1;
                $tStatementSql  = "INSERT INTO TFNTCrdShiftTmp (FTBchCode , FTCshDocNo , FNCsdSeqNo , FTCrdCode  , FTCrdStaCrd , FTCrdRmk  , FDCreateOn , FTCreateBy , FTSessionID) VALUES ";
                $oSheetName     = $oLoadExcel->getSheetByName('CardTnf');
                $aDataCondition = ['FTCrdCode'];
            break;
    
            case 'cardShiftReturn': //ใบคืนบัตร - success
                $tTableName     = 'TFNTCrdShiftTmp';
                $tSheetName     = 'CardTnf';
                $nColumn        = 1;
                $tStatementSql  = "INSERT INTO TFNTCrdShiftTmp (FTBchCode , FTCshDocNo , FNCsdSeqNo , FTCrdCode  , FTCrdStaCrd , FTCrdRmk  , FDCreateOn , FTCreateBy , FTSessionID) VALUES ";
                $oSheetName     = $oLoadExcel->getSheetByName('CardTnf');
                $aDataCondition = ['FTCrdCode'];
            break;

            case 'cardShiftRefund': //ใบคืนเงิน - success
                $tTableName     = 'TFNTCrdTopUpTmp';
                $tSheetName     = 'CardTnf';
                $nColumn        = 1;
                $tStatementSql  = "INSERT INTO TFNTCrdTopUpTmp (FTBchCode , FTCthDocNo , FNCtdSeqNo , FTCrdCode , FTCtdStaCrd , FTCtdRmk , FDCreateOn , FTCreateBy , FTSessionID) VALUES ";
                $oSheetName     = $oLoadExcel->getSheetByName('CardTnf');
                $aDataCondition = ['FTCrdCode'];
            break;

            case 'cardShiftStatus': //ใบเปลี่ยนสถานะบัตร - success
                $tTableName     = 'TFNTCrdVoidTmp';
                $tSheetName     = 'CardTnf';
                $nColumn        = 1;
                $tStatementSql  = "INSERT INTO TFNTCrdVoidTmp (FTBchCode , FTCvhDocNo , FNCvdSeqNo  , FTCvdOldCode , FTCvdStaCrd , FTCvdRmk , FDCreateOn , FTCreateBy , FTSessionID) VALUES ";
                $oSheetName     = $oLoadExcel->getSheetByName('CardTnf');
                $aDataCondition = ['FTCvdOldCode'];
            break;
        }   

        //Check DocNo ก่อน
        if($paDataExcel['nDocno'] == '' || $paDataExcel['nDocno'] == null){
            $nDocno = '-';
        }else{
            $nDocno = $paDataExcel['nDocno'];
        }

        //Step : 0 Delete Data in table ทุกครั้งที่มีการอัพโหลดใหม่
        $tSession_id    = $ci->session->userdata("tSesSessionID");
        $tUsrBch        = empty($ci->session->userdata('tSesUsrBchCode'))?FCNtGetBchInComp():$ci->session->userdata('tSesUsrBchCode');
        FCNoCARDataListDeleteOnlyTable($tTableName);

        //step : 1 -> Case ชื่อ sheet ผ่าน
        if(isset($oSheetName) && !empty($oSheetName)){
            //step : 2 -> เช็ค column head ว่าถูกต้องไหม
            $aDataresultInExcel     = array();
            $aDataInFiles           = $oLoadExcel->getActiveSheet()->toArray();
            if($nColumn != count($aDataInFiles[0])){
                $aDataReturn        = array(
                    'tTextError'    => 'E102',
                    'nStaEvent'     => 2
                );
                return $aDataReturn;
            }else{
                //step : 3 -> เช็ค ค่าว่าง
                array_shift($aDataInFiles);
                $aDataNotNull   = FSaCCMDChkDataNullInArrayHelper($aDataInFiles);
                if(isset($aDataNotNull) && !empty($aDataNotNull)){
                    $nLoopStart     = 0;
                    $nLoopEnd       = 900;
                    $nCol           = count($aDataNotNull);
                    $nResultLoop    = $nCol / $nLoopEnd;
                    //step : 4 -> วนinsert ครั้งละ 900
                    $i = 0;
                    do {
                        $tSql = " $tStatementSql ";
                        for($j=$nLoopStart; $j<$nLoopEnd; $j++){
                            if(isset($aDataNotNull[$j])){

                                $tError = '';
                                for($k=0; $k<count($aDataCondition); $k++){
                                    switch($aDataCondition[$k]){
                                        case 'FTCidCrdCode': 
                                            $tCellData  = $aDataNotNull[$j]['aItemsData'][$k];
                                            $tCrdCode   = $tCellData;
                                            if(empty($tCrdCode) && $tCrdCode == ""){
                                                $tError         = 'Empty';
                                                $tData_CidCode = '';
                                            }else{
                                                $nLenghtCrdCode = strlen($tCrdCode);
                                                if($nLenghtCrdCode > 10 && $nLenghtCrdCode != 0){
                                                    $tError         = 'MaxOverLenght';
                                                    $tData_CidCode = substr($tCellData,0,30);   
                                                }else{
                                                    $tData_CidCode  = $tCellData;
                                                }
                                            }
                                        break;
                                        case 'FTCtyCode': 
                                            $tCellData  = $aDataNotNull[$j]['aItemsData'][$k];
                                            $tCtyCode   = $tCellData;
                                            if(empty($tCtyCode) && $tCtyCode == ""){
                                                $tError         = 'Empty';
                                                $tData_CtyCode  = '';
                                            }else{
                                                $nLenghtCtyCode = strlen($tCtyCode);
                                                if($nLenghtCtyCode > 5 && $nLenghtCtyCode != 0){
                                                    $tError         = 'MaxOverLenght';
                                                    $tData_CtyCode  = substr($tCellData,0,5);   
                                                }else{
                                                    $tData_CtyCode  = $tCellData;
                                                }
                                            }
                                        break;
                                        case 'FTCidCrdHolderID': 
                                            $tCellData  = $aDataNotNull[$j]['aItemsData'][$k];
                                            $tHolderID  = $tCellData;
                                            if(empty($tHolderID) && $tHolderID == ""){
                                                $tError          = 'Empty';
                                                $tData_HolderID  = '';
                                            }else{
                                                $tHolderIDLenght  = strlen($tHolderID);
                                                if($tHolderIDLenght > 30){
                                                    $tError         = 'MaxOverLenght';
                                                    $tData_HolderID = substr($tCellData,0,30);   
                                                }else{
                                                    $tData_HolderID = $tCellData;
                                                }
                                            }
                                        break;
                                        case 'FTCidCrdDepart': 
                                            $tCellData  = $aDataNotNull[$j]['aItemsData'][$k];
                                            $tDptCode  = strlen($tCellData);
                                            if(empty($tDptCode) && $tDptCode == ""){
                                                $tError         = 'Empty';
                                                $tData_DptCode  = '';
                                            }else{
                                                $nLenghtDptCode = strlen($tDptCode);
                                                if($nLenghtDptCode > 100 && $nLenghtDptCode != 0){
                                                    $tError        = 'MaxOverLenght';
                                                    $tData_DptCode = substr($tCellData,0,100);   
                                                }else{
                                                    $tData_DptCode = $tCellData;
                                                }
                                            }
                                        break;
                                        case 'FTCidCrdName': 
                                            $tCellData  = $aDataNotNull[$j]['aItemsData'][$k];
                                            $tCrdName  = strlen($tCellData);
                                            if(empty($tCrdName) && $tCrdName == ""){
                                                $tError         = 'Empty';
                                                $tData_CrdName  = '';
                                            }else{
                                                $nLenghtCrdName = strlen($tCrdName);
                                                if($nLenghtCrdName > 200 && $nLenghtCrdName != 0){
                                                    $tError        = 'MaxOverLenght';
                                                    $tData_CrdName = substr($tCellData,0,200);   
                                                }else{
                                                    $tData_CrdName = $tCellData;
                                                }
                                            }
                                        break;
                                        case 'FTCrdCode':
                                            $tCellData  = $aDataNotNull[$j]['aItemsData'][$k];
                                            $tCrdCode   = $tCellData;
                                            if(empty($tCrdCode) && $tCrdCode == ""){
                                                $tError         = 'Empty';
                                                $tData_CrdCode = '';
                                            }else{
                                                $nLenghtCrdCode = strlen($tCrdCode);
                                                if($nLenghtCrdCode > 10 && $nLenghtCrdCode != 0){
                                                    $tError         = 'MaxOverLenght';
                                                    $tData_CrdCode = substr($tCellData,0,30);   
                                                }else{
                                                    $tData_CrdCode  = $tCellData;
                                                }
                                            }
                                        break;
                                        case 'FCCtdCrdTP':
                                            $tCellData  = $aDataNotNull[$j]['aItemsData'][$k];
                                            $tCrdTP   = $tCellData;
                                            if(empty($tCrdTP) && $tCrdTP == ""){
                                                $tError         = 'Empty';
                                                $tData_CrdTP = '';
                                            }else{
                                                $nLenghtCrdTP = strlen($tCrdTP);
                                                if($nLenghtCrdTP > 18 && $nLenghtCrdTP != 0){
                                                    $tError         = 'MaxOverLenght';
                                                    $tData_CrdTP    = substr($tCellData,0,18);   
                                                }else{
                                                    $tData_CrdTP    = $tCellData;
                                                }
                                            }
                                        break;
                                        case 'FTCvdOldCode':
                                            $tCellData      = $aDataNotNull[$j]['aItemsData'][$k];
                                            $tCvdOldCode    = $tCellData;
                                            if(empty($tCvdOldCode) && $tCvdOldCode == ""){
                                                $tError         = 'Empty';
                                                $tData_OldCode  = '';
                                            }else{
                                                $nLenghtCvdOldCode = strlen($tCvdOldCode);
                                                if($nLenghtCvdOldCode > 10 && $nLenghtCvdOldCode != 0){
                                                    $tError           = 'MaxOverLenght';
                                                    $tData_OldCode    = substr($tCellData,0,30);   
                                                }else{
                                                    $tData_OldCode    = $tCellData;
                                                }
                                            }
                                        break;
                                        case 'FTCvdNewCode':
                                            $tCellData      = $aDataNotNull[$j]['aItemsData'][$k];
                                            $tCvdNewCode    = $tCellData;
                                            if(empty($tCvdNewCode) && $tCvdNewCode == ""){
                                                $tError         = 'Empty';
                                                $tData_NewCode  = '';
                                            }else{
                                                $nLenghtCvdNewCode = strlen($tCvdNewCode);
                                                if($nLenghtCvdNewCode > 10 && $nLenghtCvdNewCode != 0){
                                                    $tError           = 'MaxOverLenght';
                                                    $tData_NewCode    = substr($tCellData,0,30);   
                                                }else{
                                                    $tData_NewCode    = $tCellData;
                                                }
                                            }
                                        break;
                                    }
                                }

                                if($tError == ''){ $tStaCrd = 1; }else{ $tStaCrd = 2; }
                                switch($ptDocType){
                                    case 'NewCard': //ใบสร้างบัตร
                                        $tSql .= "( '".$tUsrBch."' , 
                                                    '".$nDocno."' , 
                                                    $j+1 , 
                                                    '".$tData_CidCode."' , 
                                                    '".$tData_CtyCode."' ,
                                                    '".$tData_DptCode."' , 
                                                    '".$tData_CrdName."' , 
                                                    '".$tData_HolderID."' , 
                                                    '".$tStaCrd."' , 
                                                    '".$tError."' , 
                                                    '".date('Y-m-d h:i:s')."' , 
                                                    '".$ci->session->userdata("tSesUsername")."' , 
                                                    '".$tSession_id."'
                                                ),";
                                    break;

                                    case 'TopUp': //ใบเติมเงิน
                                        if($tStaCrd == 2){ $tData_CrdTP = 0; }else{ $tData_CrdTP = $tData_CrdTP; }
                                        $tSql .= "( '".$tUsrBch."' , 
                                                    '".$nDocno."' ,  
                                                    $j+1 , 
                                                    '".$tData_CrdCode."' , 
                                                    '".$tData_CrdTP."' , 
                                                    '".$tStaCrd."' ,  
                                                    '".$tError."' , 
                                                    '". date('Y-m-d h:i:s') . "' , 
                                                    '".$ci->session->userdata("tSesUsername")."' , 
                                                    '".$tSession_id."'
                                                ),";
                                    break;

                                    case 'CardTnfChangeCard': //เปลียนบัตร
                                        $tSql .= "( '".$tUsrBch."' , 
                                                    '".$nDocno."' , 
                                                    $j+1 , 
                                                    '".$tData_OldCode."' , 
                                                    '".$tData_NewCode."' , 
                                                    '".$tStaCrd."' ,  
                                                    '".$tError."' , 
                                                    '".$paDataExcel['reasonfile']."' , 
                                                    '". date('Y-m-d h:i:s') . "' , 
                                                    '".$ci->session->userdata("tSesUsername")."' , 
                                                    '".$tSession_id."'
                                                ),";
                                    break;
                        
                                    case 'ClearCard': //ใบล้างบัตร
                                        $tSql .= "( '".$tUsrBch."' , 
                                                    '".$nDocno."' , 
                                                    $j+1 , 
                                                    '".$tData_CidCode."' , 
                                                    '".$tStaCrd."' ,  
                                                    '".$tError."' , 
                                                    '". date('Y-m-d h:i:s') . "' , 
                                                    '".$ci->session->userdata("tSesUsername")."' , 
                                                    '".$tSession_id."'
                                                ),";
                                    break;
                            
                                    case 'cardShiftOut': //ใบเบิกบัตร
                                        $tSql .= "( '".$tUsrBch."' , 
                                                    '".$nDocno."' , 
                                                    $j+1 , 
                                                    '".$tData_CrdCode."' , 
                                                    '".$tStaCrd."' ,  
                                                    '".$tError."' , 
                                                    '". date('Y-m-d h:i:s') . "' , 
                                                    '".$ci->session->userdata("tSesUsername")."' , 
                                                    '".$tSession_id."'
                                                ),";
                                    break;
                            
                                    case 'cardShiftReturn': //ใบคืนบัตร
                                        $tSql .= "( '".$tUsrBch."' , 
                                                    '".$nDocno."' , 
                                                    $j+1 , 
                                                    '".$tData_CrdCode."' , 
                                                    '".$tStaCrd."' ,  
                                                    '".$tError."' , 
                                                    '". date('Y-m-d h:i:s') . "' , 
                                                    '".$ci->session->userdata("tSesUsername")."' , 
                                                    '".$tSession_id."'
                                                ),";
                                    break;

                                    case 'cardShiftRefund': //ใบคืนเงิน
                                        $tSql .= "( '".$tUsrBch."' , 
                                                    '".$nDocno."' ,  
                                                    $j+1 , 
                                                    '".$tData_CrdCode."' , 
                                                    '".$tStaCrd."' ,  
                                                    '".$tError."' , 
                                                    '". date('Y-m-d h:i:s') . "' , 
                                                    '".$ci->session->userdata("tSesUsername")."' , 
                                                    '".$tSession_id."'
                                                ),";
                                    break;

                                    case 'cardShiftStatus': //ใบเปลี่ยนสถานะบัตร
                                        $tSql .= "( '".$tUsrBch."' , 
                                                    '".$nDocno."' , 
                                                    $j+1 , 
                                                    '".$tData_OldCode."' , 
                                                    '".$tStaCrd."' ,  
                                                    '".$tError."' , 
                                                    '". date('Y-m-d h:i:s') . "' , 
                                                    '".$ci->session->userdata("tSesUsername")."' , 
                                                    '".$tSession_id."'
                                                ),";
                                    break;
                                }   

                            }
                        }
                        $tResultSql = substr($tSql, 0 , -1);
                        $ci->db->query($tResultSql);
                        $nLoopStart     = $nLoopEnd;
                        $nLoopEnd       = $nLoopEnd + 900;
                        $i++;
                    } while ($i <= $nResultLoop);
                }

                $aDataReturn        = array(
                    'tTextError'    => '',
                    'nStaEvent'     => 1
                );
                return $aDataReturn;
            }
        }else{
            //step : 1 -> Case ชื่อ sheet ไม่ผ่าน
            $aDataReturn        = array(
                'tTextError'    => 'E101',
                'nStaEvent'     => 2
            );
            return $aDataReturn;
        }
    }
}

//Select Excel
function FSaSelectDataForDocType($paData){
    $ci = &get_instance();
    $ci->load->database();
    $tSession_id = $ci->session->userdata("tSesSessionID");
    // --S      = 'Success'
    // --E      = 'Error'
    // --N/A    = 'Undefind'
    // --W      = Process

    $aRowLen = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
    $nLngID = $paData['FNLngID'];
    
    switch($paData['ptDocType']){
        case 'NewCard': //ใบสร้างบัตร
            // FCNoCARDataListDeleteOnlyTable('TFNTCrdImpTmp');
            $tSQLCountTopUP = 0;
            $tSQL = "SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FNCidSeqNo ASC) AS rtRowID,* FROM
                    (SELECT CIT.FTCidCrdCode,
                            CIT.FTCtyCode,
                            CRDTL.FTCtyName,
                            CIT.FTCidCrdHolderID,
                            CIT.FTCidCrdName,
                            CIT.FTCidCrdDepart,
                            DPTL.FTDptName,
                            CIT.FNCidSeqNo,
                            CIT.FTCidStaCrd,
                            CIT.FTCidStaPrc,
                            CIT.FTCidRmk
                    FROM TFNTCrdImpTmp CIT 
                    LEFT JOIN TFNMCardType CT ON CIT.FTCtyCode = CT.FTCtyCode
                    LEFT JOIN TFNMCardType_L CRDTL ON CRDTL.FTCtyCode = CIT.FTCtyCode AND CRDTL.FNLngID = $nLngID
                    LEFT JOIN TCNMUsrDepart_L DPTL ON DPTL.FTDptName = CIT.FTCidCrdDepart AND DPTL.FNLngID = $nLngID
                    WHERE CIT.FTSessionID = '".$tSession_id."' 
                    AND 1 = 1
                    ";
            $tSearchList = $paData['tSearchAll'];
            if ($tSearchList != '') {
                $tSQL .= " AND (CIT.FTCidCrdCode LIKE '%$tSearchList%'";
                $tSQL .= " OR CRDTL.FTCtyName LIKE '%$tSearchList%' ";
                $tSQL .= " OR CIT.FTCidCrdHolderID LIKE '%$tSearchList%' ";
                $tSQL .= " OR CIT.FTCidCrdName LIKE '%$tSearchList%' ";
                $tSQL .= " OR DPTL.FTDptName LIKE '%$tSearchList%' )";
            }
        break;

        case 'TopUp': //ใบเติมเงิน
            // FCNoCARDataListDeleteOnlyTable('TFNTCrdTopUpTmp');
            $tSQLCountTopUP = FSaSelectDataForDocTypeTopUp($paData['tSearchAll']);
            $tSQL = "SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FNCtdSeqNo ASC) AS rtRowID,* FROM
                (SELECT CTU.FTCrdCode,
                        CTU.FCCtdCrdTP,
                        CTU.FNCtdSeqNo,
                        CTU.FTCtdStaCrd,
                        CTU.FTCtdStaPrc,
                        CTU.FTCtdRmk
                FROM   TFNTCrdTopUpTmp CTU 
                WHERE CTU.FTSessionID = '".$tSession_id."' 
                AND 1 = 1
                ";
            $tSearchList = $paData['tSearchAll'];
            if ($tSearchList != '') {
                $tSQL .= " AND (CTU.FTCrdCode LIKE '%$tSearchList%'";
                $tSQL .= " OR CTU.FCCtdCrdTP LIKE '%$tSearchList%' )";
            }
        break;

        case 'CardTnfChangeCard': //เปลียนบัตร
            // FCNoCARDataListDeleteOnlyTable('TFNTCrdVoidTmp');
            $tSQLCountTopUP = 0;
            $tSQL = "SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FNCvdSeqNo ASC) AS rtRowID,* FROM
                (SELECT CVD.FTCvdOldCode,
                        CVD.FTCvdNewCode,
                        CVD.FNCvdSeqNo,
                        CVD.FCCvdOldBal,
                        CRD.FTCrdHolderID,
                        CRDL.FTCrdName,
                        CVD.FTRsnCode,
                        CVD.FTCvdStaCrd,
                        CVD.FTCvdStaPrc,
                        CVD.FTCvdRmk,
                        RSNL.FTRsnName
                FROM TFNTCrdVoidTmp CVD 
                LEFT JOIN TFNMCard CRD ON CVD.FTCvdOldCode = CRD.FTCrdCode
                LEFT JOIN TFNMCard_L CRDL ON CVD.FTCvdOldCode = CRDL.FTCrdCode AND CRDL.FNLngID = $nLngID
                LEFT JOIN TCNMRsn_L RSNL ON RSNL.FTRsnCode = CVD.FTRsnCode AND RSNL.FNLngID = $nLngID
                WHERE CVD.FTSessionID = '".$tSession_id."' 
                AND 1 = 1
                ";
            $tSearchList = $paData['tSearchAll'];
            if ($tSearchList != '') {
                $tSQL .= " AND (CVD.FTCvdOldCode LIKE '%$tSearchList%' ";
                $tSQL .= " OR RSNL.FTRsnName LIKE '%$tSearchList%' ";
                $tSQL .= " OR CVD.FTCvdNewCode LIKE '%$tSearchList%') ";
            }
        break;

        case 'ClearCard': //ใบล้างบัตร
            // FCNoCARDataListDeleteOnlyTable('TFNTCrdImpTmp');
            $tSQLCountTopUP = 0;
            $tSQL = "SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FNCidSeqNo ASC) AS rtRowID,* FROM
                    (SELECT CIT.FTCidCrdCode,
                            CIT.FNCidSeqNo,
                            CIT.FTCidStaCrd,
                            CIT.FTCidStaPrc,
                            CIT.FTCidRmk
                    FROM   TFNTCrdImpTmp CIT 
                    WHERE CIT.FTSessionID = '".$tSession_id."' 
                    AND 1 = 1
                    ";
            $tSearchList = $paData['tSearchAll'];
            if ($tSearchList != '') {
                $tSQL .= " AND (CIT.FTCidCrdCode LIKE '%$tSearchList%' )";
            }
        break;

        case 'cardShiftOut': //ใบเบิกบัตร
            $tSQLCountTopUP = 0;
            $tSQL = "SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FNCsdSeqNo ASC) AS rtRowID,* FROM
                    (SELECT CST.FTCrdCode,
                            CST.FNCsdSeqNo,
                            CST.FTCrdStaCrd,
                            CST.FTCrdStaPrc,
                            CST.FTCrdRmk
                    FROM   TFNTCrdShiftTmp CST 
                    WHERE CST.FTSessionID = '".$tSession_id."' 
                    AND 1 = 1
                    ";
            $tSearchList = $paData['tSearchAll'];
            if ($tSearchList != '') {
                $tSQL .= " AND (CST.FTCrdCode LIKE '%$tSearchList%' )";
            }
        break;

        case 'cardShiftReturn': //ใบคืนบัตร
            $tSQLCountTopUP = 0;
            $tSQL = "SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FNCsdSeqNo ASC) AS rtRowID,* FROM
                    (SELECT CST.FTCrdCode,
                            CST.FNCsdSeqNo,
                            CST.FTCrdStaCrd,
                            CST.FTCrdStaPrc,
                            CST.FTCrdRmk
                    FROM   TFNTCrdShiftTmp CST 
                    WHERE CST.FTSessionID = '".$tSession_id."' 
                    AND 1 = 1
                    ";
            $tSearchList = $paData['tSearchAll'];
            if ($tSearchList != '') {
                $tSQL .= " AND (CST.FTCrdCode LIKE '%$tSearchList%' )";
            }
        break;

        case 'cardShiftRefund': //ใบคืนเงิน 
            $tSQLCountTopUP = FSaSelectDataForDocTypeTopUp($paData['tSearchAll']);
            $tSQL = "SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FNCtdSeqNo ASC) AS rtRowID,* FROM
                (SELECT CTU.FTCrdCode,
                        CTU.FCCtdCrdTP,
                        CTU.FNCtdSeqNo,
                        CTU.FTCtdStaCrd,
                        CTU.FTCtdStaPrc,
                        CTU.FTCtdRmk
                FROM   TFNTCrdTopUpTmp CTU 
                WHERE CTU.FTSessionID = '".$tSession_id."' 
                AND 1 = 1
                ";
            $tSearchList = $paData['tSearchAll'];
            if ($tSearchList != '') {
                $tSQL .= " AND (CTU.FTCrdCode LIKE '%$tSearchList%'";
                $tSQL .= " OR CTU.FCCtdCrdTP LIKE '%$tSearchList%' )";
            }
        break;

        case 'cardShiftStatus': //ใบเปลี่ยนสถานะบัตร
            $tSQLCountTopUP = 0;
            $tSQL = "SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FNCvdSeqNo ASC) AS rtRowID,* FROM
                (SELECT CVD.FTCvdOldCode,
                        CVD.FTCvdNewCode,
                        CVD.FNCvdSeqNo,
                        CVD.FCCvdOldBal,
                        CRD.FTCrdHolderID,
                        CVD.FTRsnCode,
                        CVD.FTCvdStaCrd,
                        CVD.FTCvdStaPrc,
                        CVD.FTCvdRmk,
                        RSNL.FTRsnName
                FROM   TFNTCrdVoidTmp CVD 
                LEFT JOIN TFNMCard CRD ON CVD.FTCvdOldCode = CRD.FTCrdCode
                LEFT JOIN TCNMRsn_L RSNL ON RSNL.FTRsnCode = CVD.FTRsnCode AND RSNL.FNLngID = $nLngID
                WHERE CVD.FTSessionID = '".$tSession_id."' 
                AND 1 = 1
                ";
            $tSearchList = $paData['tSearchAll'];
            if ($tSearchList != '') {
                $tSQL .= " AND ( ";
                $tSQL .= " CVD.FTCvdOldCode LIKE '%$tSearchList%' )";
            }
        break; 
    }  

    $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

    $oQuery = $ci->db->query($tSQL);
    
    if ($oQuery->num_rows() > 0) {
        
        $aList      = $oQuery->result();
        $aFoundRow  = JSnMHEPGetPageListAll($paData['ptDocType'], $tSearchList, $nLngID);
        $nFoundRow  = $aFoundRow[0]->counts;
        $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า 

        $aResult = array(
                'raItems'       => $aList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => $nPageAll, 
                'rtCode'        => '1',
                'rtDesc'        => 'success',
                'CountTopUP'    => $tSQLCountTopUP
        );
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
            
    } else {
        //No Data
        $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
        );
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        
    }
    
    return $aResult;
    
}

//Select Count (case topup)
function FSaSelectDataForDocTypeTopUp($tSearchList){
    $ci = &get_instance();
    $ci->load->database();
    $tSession_id = $ci->session->userdata("tSesSessionID");


    $tSQL = "SELECT SUM(CTU.FCCtdCrdTP) as Total FROM  TFNTCrdTopUpTmp CTU 
            WHERE CTU.FTSessionID = '".$tSession_id."' AND 1 = 1 ";

    if ($tSearchList != '') {
        $tSQL .= " AND (CTU.FTCrdCode LIKE '%$tSearchList%'";
        $tSQL .= " OR CTU.FCCtdCrdTP LIKE '%$tSearchList%' )";
    }

    $oQuery = $ci->db->query($tSQL);
    if ($oQuery->num_rows() > 0) {
        $aList      = $oQuery->result();
    } else {
        $aList = array('Total'=>0);
    }
    
    return $aList;
}

//Count Page List
function JSnMHEPGetPageListAll($ptDocType, $ptSearchList, $ptLngID){
    $ci = &get_instance();
    $ci->load->database();
    $tSession_id = $ci->session->userdata("tSesSessionID");

    switch($ptDocType){
        case 'NewCard': //บัตรใหม่
            $tSQL = "SELECT COUNT (CIT.FTCidCrdCode) AS counts
                FROM TFNTCrdImpTmp CIT
                LEFT JOIN TFNMCardType CT ON CIT.FTCtyCode = CT.FTCtyCode
                LEFT JOIN TFNMCardType_L CRDTL ON CRDTL.FTCtyCode = CIT.FTCtyCode AND CRDTL.FNLngID = $ptLngID
                LEFT JOIN TCNMUsrDepart_L DPTL ON DPTL.FTDptCode = CIT.FTCidCrdDepart AND DPTL.FNLngID = $ptLngID
                WHERE 1 = 1 AND CIT.FTSessionID = '".$tSession_id."' ";
                if ($ptSearchList != '') {
                    $tSQL .= " AND (CIT.FTCidCrdCode LIKE '%$ptSearchList%'";
                    $tSQL .= " OR CRDTL.FTCtyName LIKE '%$ptSearchList%' ";
                    $tSQL .= " OR CIT.FTCidCrdHolderID LIKE '%$ptSearchList%' ";
                    $tSQL .= " OR CIT.FTCidCrdName LIKE '%$ptSearchList%' ";
                    $tSQL .= " OR DPTL.FTDptName LIKE '%$ptSearchList%' )";
                }
        break;

        case 'TopUp': //ใบเติมเงิน
            $tSQL = "SELECT COUNT (CTU.FTCrdCode) AS counts
                FROM TFNTCrdTopUpTmp CTU 
                WHERE 1 = 1 AND CTU.FTSessionID = '".$tSession_id."' ";
                if ($ptSearchList != '') {
                    $tSQL .= " AND (CTU.FTCrdCode LIKE '%$ptSearchList%'";
                    $tSQL .= " OR CTU.FCCtdCrdTP LIKE '%$ptSearchList%' )";
                }
        break;

        case 'CardTnfChangeCard': //เปลี่ยนบัตร
            $tSQL = "SELECT COUNT (CVD.FNCvdSeqNo) AS counts
                FROM  TFNTCrdVoidTmp CVD 
                LEFT JOIN TFNMCard CRD ON CVD.FTCvdOldCode = CRD.FTCrdCode
                LEFT JOIN TFNMCard_L CRDL ON CVD.FTCvdOldCode = CRDL.FTCrdCode AND CRDL.FNLngID = $ptLngID
                LEFT JOIN TCNMRsn_L RSNL ON RSNL.FTRsnCode = CVD.FTRsnCode AND RSNL.FNLngID = $ptLngID
                WHERE 1 = 1 AND CVD.FTSessionID = '".$tSession_id."' ";
                if ($ptSearchList != '') {
                    $tSQL .= " AND (CVD.FTCvdOldCode LIKE '%$ptSearchList%' ";
                    $tSQL .= " OR RSNL.FTRsnName LIKE '%$ptSearchList%' ";
                    $tSQL .= " OR CVD.FTCvdNewCode LIKE '%$ptSearchList%' )";
                }
        break;

        case 'ClearCard': //ใบล้างบัตร
            $tSQL = "SELECT COUNT (CIT.FTCidCrdCode) AS counts
                FROM TFNTCrdImpTmp CIT 
                WHERE 1 = 1 AND CIT.FTSessionID = '".$tSession_id."' ";
                if ($ptSearchList != '') {
                    $tSQL .= " AND (CIT.FTCidCrdCode LIKE '%$ptSearchList%' )";
                }
        break;

        case 'cardShiftOut': //ใบเบิกบัตร 
            $tSQL = "SELECT COUNT (CST.FTCrdCode) AS counts
                FROM TFNTCrdShiftTmp CST 
                WHERE 1 = 1 AND CST.FTSessionID = '".$tSession_id."' ";
                if ($ptSearchList != '') {
                    $tSQL .= " AND (CST.FTCrdCode LIKE '%$ptSearchList%' )";
                }
        break;

        case 'cardShiftReturn': //ใบคืนบัตร
            $tSQL = "SELECT COUNT (CST.FTCrdCode) AS counts
                FROM TFNTCrdShiftTmp CST 
                WHERE 1 = 1 AND CST.FTSessionID = '".$tSession_id."' ";
                if ($ptSearchList != '') {
                    $tSQL .= " AND (CST.FTCrdCode LIKE '%$ptSearchList%' )";
                }
        break;

        case 'cardShiftRefund': //ใบคืนเงิน 
            $tSQL = "SELECT COUNT (CTU.FTCrdCode) AS counts
                FROM TFNTCrdTopUpTmp CTU 
                WHERE 1 = 1 AND CTU.FTSessionID = '".$tSession_id."' ";
                if ($ptSearchList != '') {
                    $tSQL .= " AND (CTU.FTCrdCode LIKE '%$ptSearchList%'";
                    $tSQL .= " OR CTU.FCCtdCrdTP LIKE '%$ptSearchList%' )";
                }
        break;

        case 'cardShiftStatus': //ใบเปลี่ยนสถานะบัตร
            $tSQL = "SELECT COUNT (CVD.FNCvdSeqNo) AS counts
                FROM  TFNTCrdVoidTmp CVD 
                LEFT JOIN TFNMCard CRD ON CVD.FTCvdOldCode = CRD.FTCrdCode
                LEFT JOIN TCNMRsn_L RSNL ON RSNL.FTRsnCode = CVD.FTRsnCode AND RSNL.FNLngID = $ptLngID
                WHERE 1 = 1 AND CVD.FTSessionID = '".$tSession_id."' ";
                if ($ptSearchList != '') {
                    $tSQL .= " AND ( ";
                    $tSQL .= " CVD.FTCvdOldCode LIKE '%$ptSearchList%' )";
                }
        break;
    }  
    
    $oQuery = $ci->db->query($tSQL);
    if ($oQuery->num_rows() > 0) {
        return $oQuery->result();
    } else {
        return false;
    }
}

//Delete Data in Temp by record
function FSaDeleteDataForDocType($paData){
    $ci = &get_instance();
    $ci->load->database();

    try{
        $ci->db->trans_begin();
        
        switch($paData['tDocType']){
            case 'NewCard': //ใบสร้างบัตร
                $tTableName = 'TFNTCrdImpTmp';
                $ci->db->where_in('FNCidSeqNo', $paData['nSeq']);
            break;

            case 'TopUp': //ใบเติมเงิน
                $tTableName = 'TFNTCrdTopUpTmp';
                $ci->db->where_in('FNCtdSeqNo', $paData['nSeq']);
            break;

            case 'CardTnfChangeCard': //ใบเปลี่ยนบัตร
                $tTableName = 'TFNTCrdVoidTmp';
                $ci->db->where_in('FNCvdSeqNo', $paData['nSeq']);
            break;

            case 'ClearCard': //ใบล้างบัตร
                $tTableName = 'TFNTCrdImpTmp';
                $ci->db->where_in('FNCidSeqNo', $paData['nSeq']);
            break;

            case 'cardShiftOut': //ใบเบิกบัตร
                $tTableName = 'TFNTCrdShiftTmp';
                $ci->db->where_in('FNCsdSeqNo', $paData['nSeq']);
            break;

            case 'cardShiftReturn': //ใบคืนบัตร
                $tTableName = 'TFNTCrdShiftTmp';
                $ci->db->where_in('FNCsdSeqNo', $paData['nSeq']);
            break;

            case 'cardShiftRefund': //ใบคืนเงิน 
                $tTableName = 'TFNTCrdTopUpTmp';
                $ci->db->where_in('FNCtdSeqNo', $paData['nSeq']);
            break;

            case 'cardShiftStatus': //ใบเปลี่ยนสถานะบัตร
                $tTableName = 'TFNTCrdVoidTmp';
                $ci->db->where_in('FNCvdSeqNo', $paData['nSeq']);
            break;
        }   

        $ci->db->delete($tTableName);

        if($ci->db->trans_status() === FALSE){
            $ci->db->trans_rollback();
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Delete Unsuccess.',
            );
        }else{
            $ci->db->trans_commit();
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Delete Success.',
            );
        }
        return $aStatus;
    }catch(Exception $Error){
        echo $Error;
    }
}

//Delete Data in DT
function FSaDeleteDatainTableDT($paData){
    //paData['tDocType'] : Document type 
    //paData['tDocNo'] : Document no 
    $ci = &get_instance();
    $ci->load->database();

    try{
        $ci->db->trans_begin();
        
        switch($paData['tDocType']){
            case 'NewCard': //ใบสร้างบัตร
                $tTableName = 'TFNTCrdImpDT';
                $ci->db->where_in('FTCihDocNo', $paData['tDocNo']);
            break;

            case 'TopUp': //ใบเติมเงิน
                $tTableName = 'TFNTCrdTopUpDT';
                $ci->db->where_in('FTCthDocNo', $paData['tDocNo']);
            break;

            case 'CardTnfChangeCard': //ใบเปลี่ยนบัตร
                $tTableName = 'TFNTCrdVoidDT';
                $ci->db->where_in('FTCvhDocNo', $paData['tDocNo']);
            break;

            case 'ClearCard': //ใบล้างบัตร
                $tTableName = 'TFNTCrdImpDT';
                $ci->db->where_in('FTCihDocNo', $paData['tDocNo']);
            break;

            case 'cardShiftOut': //ใบเบิกบัตร
                $tTableName = 'TFNTCrdShiftDT';
                $ci->db->where_in('FTCshDocNo', $paData['tDocNo']);
            break;

            case 'cardShiftReturn': //ใบคืนบัตร
                $tTableName = 'TFNTCrdShiftDT';
                $ci->db->where_in('FTCshDocNo', $paData['tDocNo']);
            break;

            case 'cardShiftRefund': //ใบคืนเงิน 
                $tTableName = 'TFNTCrdTopUpDT';
                $ci->db->where_in('FTCthDocNo', $paData['tDocNo']);
            break;

            case 'cardShiftStatus': //ใบเปลี่ยนสถานะบัตร
                $tTableName = 'TFNTCrdVoidDT';
                $ci->db->where_in('FTCvhDocNo', $paData['tDocNo']);
            break;
        }   

        $ci->db->delete($tTableName);

        if($ci->db->trans_status() === FALSE){
            $ci->db->trans_rollback();
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Delete Unsuccess.',
            );
        }else{
            $ci->db->trans_commit();
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Delete Success.',
            );
        }
        return $aStatus;
    }catch(Exception $Error){
        echo $Error;
    }
}

//Function Check Null
function FSaCCMDChkDataNullInArrayHelper($aDataFiles){
    try{
        $aDataReturn = array();
        if(isset($aDataFiles) && is_array($aDataFiles)){
            $nRowID = 0;
            foreach($aDataFiles as $nKeyData => $aRowData) {
                $nCountArrayData    =  count($aRowData);
                $nDataIsNull        = "";
                foreach($aRowData as $nKey => $aRow){
                    if($aRow == ""){
                        $nDataIsNull++;
                    }
                }
                if($nCountArrayData != $nDataIsNull){
                    $nRowID++;
                    $aDataChkNull = array(
                        'nRowID'        => $nRowID,
                        'aItemsData'    => $aRowData
                    );
                    array_push($aDataReturn,$aDataChkNull);
                }
            }
        }
        return $aDataReturn;
    }catch(Exception $Error){
        echo $Error;
    }
}

//Function Update DocNo in Table
function FCNCallUpdateDocNo($pnDocno,$ptTableName){
    $ci = &get_instance();
    $ci->load->database();
    $tSession_id = $ci->session->userdata("tSesSessionID");

    switch($ptTableName){
        case 'TFNTCrdImpTmp': //ใบสร้างบัตร
            $tTableName     = 'TFNTCrdImpTmp';
            $tFiledDocNo    = 'FTCihDocNo';
            $ci->db->select('FTCihDocNo');
            $ci->db->limit(1);
            $ci->db->where_in('FTSessionID', $tSession_id);
        break;

        case 'TFNTCrdTopUpTmp': //ใบเติมเงิน
            $tTableName     = 'TFNTCrdTopUpTmp';
            $tFiledDocNo    = 'FTCthDocNo';
            $ci->db->select('FTCthDocNo');
            $ci->db->limit(1);
            $ci->db->where_in('FTSessionID', $tSession_id);
        break;

        case 'TFNTCrdVoidTmp': //ใบเปลี่ยนบัตร
            $tTableName     = 'TFNTCrdVoidTmp';
            $tFiledDocNo    = 'FTCvhDocNo';
            $ci->db->select('FTCvhDocNo');
            $ci->db->limit(1);
            $ci->db->where_in('FTSessionID', $tSession_id);
        break;

        case 'TFNTCrdShiftTmp': //ใบเบิกบัตร
            $tTableName     = 'TFNTCrdShiftTmp';
            $tFiledDocNo    = 'FTCshDocNo';
            $ci->db->select('FTCshDocNo');
            $ci->db->limit(1);
            $ci->db->where_in('FTSessionID', $tSession_id);
        break;
    }   

    $ci->db->from($tTableName);
    $query  = $ci->db->get();
    $nCount = count($query->result());
    if($nCount != 0){
        $ci->db->set($tFiledDocNo , $pnDocno);
        $ci->db->where('FTSessionID', $tSession_id);
        $ci->db->update($tTableName);

        echo 'success';
    }else{
        echo 'fail';
    }
}


//Count Result All - For Table
function FSnSelectCountResult($ptTableName){
    $ci = &get_instance();
    $ci->load->database();
    $tSessionID = $ci->session->userdata("tSesSessionID");
    
    switch ($ptTableName) {
        case 'TFNTCrdImpTmp' : {
            $tSQL = "SELECT FTCidCrdCode FROM TFNTCrdImpTmp 
                WHERE FTSessionID = '".$tSessionID."' 
                AND 1 = 1";
            break;
        }
        case 'TFNTCrdShiftTmp' : {
            $tSQL = "SELECT FNCsdSeqNo FROM TFNTCrdShiftTmp 
                WHERE FTSessionID = '".$tSessionID."' 
                AND 1 = 1";
            break;
        }
        case 'TFNTCrdTopUpTmp' : {
            $tSQL = "SELECT FTCrdCode FROM TFNTCrdTopUpTmp
                WHERE FTSessionID = '".$tSessionID."' 
                AND 1 = 1";
            break;
        }
        case 'TFNTCrdVoidTmp' : {
            $tSQL = "SELECT FNCvdSeqNo FROM TFNTCrdVoidTmp
                WHERE FTSessionID = '".$tSessionID."' 
                AND 1 = 1";
            break;
        }
    }
    
    $oQuery = $ci->db->query($tSQL);
    if ($oQuery->num_rows() > 0) {
        $aResult = $oQuery->num_rows();
    }else{
        $aResult = 0;
    }
    return $aResult;
}

//Count Result Success - For Table
function FSnSelectCountResultSuccess($ptTableName){
    $ci = &get_instance();
    $ci->load->database();
    $tSessionID = $ci->session->userdata("tSesSessionID");
    
    switch ($ptTableName) {
        case 'TFNTCrdImpTmp' : {
            $tSQL = "SELECT FTCidCrdCode FROM TFNTCrdImpTmp 
                WHERE FTSessionID = '".$tSessionID."' AND FTCidStaCrd = 1
                AND 1 = 1";
            break;
        }
        case 'TFNTCrdShiftTmp' : {
            $tSQL = "SELECT FNCsdSeqNo FROM TFNTCrdShiftTmp 
                WHERE FTSessionID = '".$tSessionID."' AND FTCrdStaCrd = 1
                AND 1 = 1";
            break;
        }
        case 'TFNTCrdTopUpTmp' : {
            $tSQL = "SELECT FTCrdCode FROM TFNTCrdTopUpTmp
                WHERE FTSessionID = '".$tSessionID."' AND FTCtdStaCrd = 1
                AND 1 = 1";
            break;
        }
        case 'TFNTCrdVoidTmp' : {
            $tSQL = "SELECT FNCvdSeqNo FROM TFNTCrdVoidTmp
                WHERE FTSessionID = '".$tSessionID."' AND FTCvdStaCrd = 1
                AND 1 = 1";
            break;
        }
    }
    
    $oQuery = $ci->db->query($tSQL);
    if ($oQuery->num_rows() > 0) {
        $aResult = $oQuery->num_rows();
    }else{
        $aResult = 0;
    }
    return $aResult;
}

//Helper Select Join Delect From Select Insert NewCard Only
function FSnHDelectDataNewCrdDupInCard(){
    $ci = &get_instance();
    $ci->load->database();

    $tSessionID = $ci->session->userdata("tSesSessionID");

    $tSQL   = " DELETE CIT 
                FROM TFNTCrdImpTmp CIT 
                INNER JOIN TFNMCard CRD
                ON CRD.FTCrdCode = CIT.FTCidCrdCode
                WHERE CIT.FTSessionID = '".$tSessionID."' ";
    
    $oQuery = $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1;   // พบรหัสที่ซ้ำตารางบัตรในกรณีเงื่อนไขนำเข้าเฉพาะข้อมูลใหม่เท่านั้น
    }else{
        return 0;   // ไม่พบรหัสที่ซ้ำตารางบัตรในกรณีเงื่อนไขนำเข้าเฉพาะข้อมูลใหม่เท่านั้น
    }
}

