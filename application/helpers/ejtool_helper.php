<?php
    // Functional : Encypt EJ Slip
    // Create By : Kitpipat 
    // Last Update By :
    // Last Update On 
    // Create On : 10/10/2019
    // Parameter : EJ File Path
    // Parameter Type : String
    // Return : EJ Information 
    // Return Type : Array
    function FCNaHFLEDeCypther($ptEJFilePath){

        $aEJInfo = array();
        // ตรวจสอบ file path ว่ามีการส่งมาหรือไม่ ถ้าไม่ให้ return error กลับไป
        if($ptEJFilePath == '' or $ptEJFilePath == null){

           $aEJInfo['tStatus'] = 'Error'; 
           $aEJInfo['tErrorType'] = 'file path does not exist'; 
           $aEJInfo['tEJFile'] = null;

        }else{
            // ตรวจสอบ file path ที่ส่งมามีอยู่จริงหรือไม่ ถ้ามีให้ไปอ่านไฟล์ตาม path mujlj',k
            if (file_exists($ptEJFilePath)) {

                $oHandleFile = fopen($ptEJFilePath, "rb");
        
                $tImageBinary = '';
                $nLine = 0;

                // อ่านค่าจากไฟล์แบบเรียงบรรทัด
                while(! feof($oHandleFile)) {

                      $tContenLine = fgets($oHandleFile);
                    //   ตรวจสอบว่าเป็น Line สุดท้ายหรือไม่ 
                      if (!feof($oHandleFile))
                      {
                        // ตรวจสอบว่าเป็น Line ที่ 1 หรือไม่
                        if($nLine > 0){
                            $tImageBinary.=$tContenLine;
                        }
                        
                      }
                

                  $nLine++;
                
                }
                fclose($oHandleFile);

                $aEJInfo['tStatus'] = 'Success'; 
                $aEJInfo['tErrorType'] = null; 
                $aEJInfo['tEJFile'] = $tImageBinary;

               
            }else {
                $aEJInfo['tStatus'] = 'Error'; 
                $aEJInfo['tErrorType'] = 'file path does not exist'; 
                $aEJInfo['tEJFile'] = 'Null';
            }

            return $aEJInfo;

        }
    

    }

    // Functional : Initail Encypt EJ Slip
    // Create By : Kitpipat 
    // Last Update By :
    // Last Update On 
    // Create On : 10/10/2019
    // Parameter : EJ File Path, Image content Type to retrun
    // Parameter Type : String
    // Return : EJ Information 
    // Return Type : Array
    function FCNaHFLEGetEJ($ptEJFilePath,$ptImageType){

             $aEJInfo = array();
             $aEJInfo = FCNaHFLEDeCypther($ptEJFilePath);
             if($aEJInfo['tStatus'] == 'Success' and $aEJInfo['tEJFile'] != ''){
                
                if($ptImageType == '' or $ptImageType == null){
                    $ptImageType = 'png';
                }else{
                    $ptImageType = $ptImageType;
                }
                $tDataImage = 'data:image/'.$ptImageType.';base64,';

                // Convert Binary to Base64 Format
                $tEJImage=$tDataImage.base64_encode($aEJInfo['tEJFile']);
               
                $aEJInfo['tStatus'] = 'Success'; 
                $aEJInfo['tErrorType'] = null; 
                $aEJInfo['tEJFile'] = $tEJImage;


             }else{
                 return $aEJInfo;
             }
             return $aEJInfo;
    }
?>

