<?php
    // Functionality : คำส่วนลดท้ายบิล
    // Parameters : function parameters
    // Creator : -
    // Last Modified : 22-01-2020 Nale
    // Description Modified : เพิ่ม Where ที่เลขที่เอกสารในคิวรี่  
    // Return : -
    // Return Type : None

    // FCNaHCalculateProrate('TAPTPcHD','DEMODOCNO');

    //คำนวณ prorate
    function FCNaHCalculateProrate($ptPagename,$ptDocumentNo){
        $ci = &get_instance();
        $ci->load->database();
        set_time_limit(0);

        //Session ID
        $tSession_id    = $ci->session->userdata("tSesSessionID");
        $tSesUsername   = $ci->session->userdata("tSesUsername");
        $tSesBCH        = $ci->session->userdata("tSesUsrBchCode");

        //case : เข้ามาแบบ HQ จะใช้ tSesUsrBchCom 
		    // : เข้ามาแบบ BCH , SHP จะใช้ tSesUsrBchCode 
        if($tSesBCH == '' ||  $tSesBCH == null){
            $tSesBCH  = $ci->session->userdata("tSesUsrBchCom");
        }else{
            $tSesBCH  = $ci->session->userdata("tSesUsrBchCode");
        }

        //Demo Test parameter
        // $tSesUsername   = 'WAT';
        // $tSession_id    = '00920190701093952';
        // $tSesBCH        = '00042';

        //parameter
        //$ptPagename   = ชือเอกสารของเรื่องนั้นๆ 
        //$ptDocumentNo = หมายเลขเอกสาร
        if($ptDocumentNo == '' || $ptDocumentNo == null){
            $ptDocumentNo = '';
        }else{
            $ptDocumentNo = $ptDocumentNo;
        }

        //Step 01 : วิ่งไปเช็คว่ามีส่วนลดท้ายบิล 
        // $tSQLHDDis = "SELECT SUM(FCXtdAmt) AS FCXtdAmt FROM TCNTDocHDDisTmp WHERE FTSessionID  = '$tSession_id' ";

        $tSQLHDDis = "SELECT HDD.*,CASE WHEN HDD.FCXtdAmt < 0 THEN 1 ELSE 3 END AS FTXtdDisChgType FROM(
                        SELECT SUM(CASE WHEN FTXtdDisChgType = 1 THEN FCXtdAmt * -1
                                        WHEN FTXtdDisChgType = 2 THEN FCXtdAmt * -1
                                        WHEN FTXtdDisChgType = 3 THEN FCXtdAmt
                                        WHEN FTXtdDisChgType = 4 THEN FCXtdAmt
                                    ELSE 0 END 
                                ) FCXtdAmt
                        FROM  TCNTDocHDDisTmp
                        WHERE FTSessionID  = '$tSession_id'   
                        AND FTXthDocNo ='$ptDocumentNo' 
                    ) HDD WHERE FCXtdAmt != 0 ";
            
        $oQueryHDDis = $ci->db->query($tSQLHDDis);
        if($oQueryHDDis->num_rows() > 0){
            //case พบข้อมูล

            //ผลรวมของ ส่วนลดท้ายบิล
            $aDetailHDDis = $oQueryHDDis->result_array();
            $nDiscount    = $aDetailHDDis[0]['FCXtdAmt'];

            $tCheckType   =  substr($nDiscount,0,1);
            if($tCheckType == '-'){
                // echo 'Type เป็น ลด ';
                $tFTXtdDisChgType = 1;
            }else{
                // echo 'Type เป็น ชาร์ท ';
                $tFTXtdDisChgType = 3;
            }
            $nDiscount = abs($nDiscount); 

            //Step 02 : วิ่งไปลบแต่ละรายการของ ข้อมูลส่วนลดท้ายบิล
            $tTableName = 'TCNTDocDTDisTmp';
            $ci->db->where_in('FNXtdStaDis', '2');
            $ci->db->where_in('FTSessionID', $tSession_id);
            $ci->db->delete($tTableName);

            //Step 03 : ไปเอาข้อมูลแต่ละรายการในตาราง Temp
            $tSQLDT = "SELECT FTPdtCode,FTXtdPdtName,FCXtdNet,FTXtdStaAlwDis,FNXtdSeqNo FROM TCNTDocDTTmp WHERE FTXtdStaAlwDis = 1 AND FTSessionID = '$tSession_id' AND FTXthDocKey = '$ptPagename' AND FTXthDocNo ='$ptDocumentNo'  ";
            $oQueryDT = $ci->db->query($tSQLDT);
            if($oQueryDT->num_rows() > 0){

                //Step 04 : คำนวณ prorate เข้าสูตร : ส่วนลดท้ายบิลทั้งหมด x ราคาต่อชิ้น/ราคาทั้งหมดหลังหักส่วนลด
                $aDetail  = $oQueryDT->result_array();

                //ทศนิยม
                $nDecimal = FCNxHGetOptionDecimalShow();

                //ส่วนลดท้ายบิลทั้งหมด
                $nDiscount = $nDiscount;
                
                //ราคาทั้งหมดหลังหักส่วนลด
                $nSum = 0;
                for($i=0; $i<count($aDetail); $i++){
                    $nSum = $nSum + $aDetail[$i]['FCXtdNet'];
                }

                //ราคา prorate by product
                $aProrateByproduct = array();
                for($i=0; $i<count($aDetail); $i++){
                    //ต้องอนุญาติลดเท่านั้น FTXtdStaAlwDis = 1
                    if($aDetail[$i]['FTXtdStaAlwDis'] == 1){
                        if($aDetail[$i]['FCXtdNet'] == 0){
                            $nProrate = $nDiscount;
                        }else{
                            $nProrate = $nDiscount * $aDetail[$i]['FCXtdNet']/$nSum;
                        }

                        $nProrate = intval($nProrate);
                        $bCheckDecimal  = is_float($nProrate);
                        if($bCheckDecimal == true){
                            //ถ้ามีทศนิยม
                            $aProrateDecimal = explode(".",$nProrate);
                            $nProrateDecimal = substr($aProrateDecimal[1],0,$nDecimal);
                            $nNewProrate = $aProrateDecimal[0].'.'.$nProrateDecimal;
                        }else{
                            //ถ้าไม่มีทศนิยม
                            $nNewProrate = substr($nProrate,0,$nDecimal);
                        }
        
                        $aNewArrayProduct = array(
                            'FCXtdNet'      => $aDetail[$i]['FCXtdNet'] ,
                            'FNXtdSeqNo'    => $aDetail[$i]['FNXtdSeqNo'] , 
                            'FTPdtCode'     => $aDetail[$i]['FTPdtCode'] ,
                            'Value'         => $nNewProrate
                        );
                        array_push($aProrateByproduct,$aNewArrayProduct);
                    }else{
                        $aDataReturn    =  array(
                            'rtCode'    => '800',
                            'rtDesc'    => 'Data Not Found',
                        );
                        return $aDataReturn;
                        exit;
                    }
                }

                //ผลรวม prorate มันจะยังไม่ครบจำนวนส่วนลด ต้องเอาไปหยอดตัวสุดท้าย
                $nSumProrate = 0;
                for($i=0; $i<count($aProrateByproduct); $i++){
                    $nSumProrate = $nSumProrate + $aProrateByproduct[$i]['Value'];

                    //ผลรวม prorate ที่เหลือต้องเอาไป + ตัวสุดท้าย
                    if($i == count($aProrateByproduct) - 1){
                        $nDifferenceProrate = $nDiscount - $nSumProrate;
                        $aProrateByproduct[$i]['Value'] = $aProrateByproduct[$i]['Value'] + $nDifferenceProrate;
                    }
                }

                //Step 05 : เอาไป insert ที่ตาราง DTDisTmp
                $tSQLDTDisTmpColumn = 'INSERT INTO TCNTDocDTDisTmp (
                    FTBchCode,
                    FTXthDocNo,
                    FNXtdSeqNo,
                    FTSessionID,
                    FDXtdDateIns,
                    FNXtdStaDis,
                    FTXtdDisChgType,
                    FCXtdNet,
                    FCXtdValue,
                    FDCreateOn,
                    FTCreateBy,
                    FTXtdDisChgTxt
                ) VALUES ';
                $tSQLDTDisTmpValue = '';
                $tSql = " $tSQLDTDisTmpColumn ";
                for($i=0; $i<count($aProrateByproduct); $i++){
                    $tSQLDTDisTmpValue .= "(
                        '".$tSesBCH."' ,
                        '".$ptDocumentNo."' ,
                        '".$aProrateByproduct[$i]['FNXtdSeqNo']."',
                        '$tSession_id',
                        '".date("Y-m-d H:i:s")."',
                        '2',
                        '$tFTXtdDisChgType',
                        ".$aProrateByproduct[$i]['FCXtdNet'].",
                        ".$aProrateByproduct[$i]['Value'].",
                        '".date("Y-m-d H:i:s")."',
                        '".$tSesUsername."',
                        '$nDiscount'
                    ),";

                    if($i == count($aProrateByproduct)-1){
                        $tSQLDTDisTmpValue = substr($tSQLDTDisTmpValue, 0 , -1);
                    }
                }
                $tSql .= $tSQLDTDisTmpValue;
                $tInsertDTDis = FCNaHProrateInsertDiscount($tSql);
                if($tInsertDTDis == 'success'){
                    $aDataReturn    =  array(
                        'rtCode'    => '1',
                        'rtDesc'    => 'success',
                    );
                }else{
                    $aDataReturn    =  array(
                        'rtCode'    => '800',
                        'rtDesc'    => 'Data Not Found',
                    );
                }

                return $aDataReturn;
            }else{
                //case ไม่พบข้อมูลของสินค้า
                return;
            }
        }else{
            //case ไม่พบข้อมูลของส่วนลด
            return;
        }
    }

    //Function : insert TCNTDocDTDisTmp (ตารางส่วนลด)
    function FCNaHProrateInsertDiscount($ptSql){
         //Step 05 : เอาไป insert ที่ตาราง DTDisTmp
        $ci = &get_instance();
        $ci->load->database();
        set_time_limit(0);
        $oQuery = $ci->db->query($ptSql);
        if($oQuery == 1){
            return 'success';
        }else{
            return 'fail';
        }
    }

?>