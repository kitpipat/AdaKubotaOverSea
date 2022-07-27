<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
require_once (APPPATH.'third_party/PHPExcel/Classes/PHPExcel.php');
require_once (APPPATH.'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php');
require_once (APPPATH.'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');



class cCardMngData extends CI_Controller {

    
    public function __construct(){
        parent::__construct();
        $this->load->model('document/cardmngdata/mCardMngData');
        $this->load->helper('card');
    }

    public function index($nCmdBrowseType,$tCmdBrowseOption){
        
        //Delete IN modal
        FCNoCARDataListDeleteAllTable();

        $nMsgResp   = array('title' => "Card ManagementData");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view('common/wHeader', $nMsgResp);
            $this->load->view('common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view('common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $this->load->view('document/cardmngdata/wCardMngData', array (
            'nMsgResp'          => $nMsgResp,
            'nCmdBrowseType'    => $nCmdBrowseType,
            'tCmdBrowseOption'  => $tCmdBrowseOption
        ));
    }

    //Functionality : Function Call Page Card From List
    //Parameters : Ajax Call View Add
    //Creator : 19/10/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCCMDFromList(){
        try{
            $this->load->view('document/cardmngdata/wCardMngDataFrmList');
        }catch(Exception $Error){
            echo $Error;
        }
    }

    /** ============================================ Import ================================================ */
    //Functionality : Function Check Null Data In Files
    //Parameters : Ajax Call View Import Table
    //Creator : 13/11/2018 wasin
    //Return : Array Data Check Null In Array
    //Return Type : Array
    public function FSaCCMDChkDataNullInArray($aDataFiles){
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

    //Functionality : Function Fillter Data
    //Parameters : Ajax Call View Import Table
    //Creator : 13/11/2018 wasin
    //Return : Array Data Check Null In Array
    //Return Type : Array
    public function FSaCCMDFilterDataArray($paDataFilter){
        try{
            $aRowLen        = FCNaHCallLenData($paDataFilter['nRow'],$paDataFilter['nPage']);
            $tSearchData    = $paDataFilter['tSearchData'];
            $aDataCondition = $paDataFilter['aDataCondition'];
            $aDataSearch    = array();
            if(isset($tSearchData) && !empty($tSearchData)){
                foreach($aDataCondition as $nKeyData => $aRowData) {
                    $aDataFileImport = $aRowData['aItemsData'];
                    if($i = array_search(trim($tSearchData),$aDataFileImport) !== FALSE){
                        array_push($aDataSearch,$aRowData);
                    }
                }
            }else{
                $aDataSearch = $aDataCondition;
            }
            $aDataPage  = array();
            for($i = $aRowLen[0]; $i <= $aRowLen[1]-1; $i++) {
                if(isset($aDataSearch[$i]) && !empty($aDataSearch[$i])){
                    array_push($aDataPage,$aDataSearch[$i]);
                }
            }
            $nAllRow    = count($aDataSearch);
            $nPageAll   = ceil($nAllRow/$paDataFilter['nRow']);
            $aDataReturn = array(
                'raItems'       => $aDataPage,
                'rnAllRow'      => $nAllRow,
                'rnCurrentPage' => $paDataFilter['nPage'],
                'rnAllPage'     => $nPageAll,
            );
            return $aDataReturn;
        }catch(Exception $Error){
            echo $Error;
        } 
    }

    //Functionality : Function Get Data Import Table
    //Parameters : Ajax Call View Import Table
    //Creator : 25/10/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCCMDImpFileDataList(){
        try{
            $nStaImportProcess  = $this->input->post('nStaImportProcess');
            $tSearchAll         = $this->input->post('tSearchAll');
            if(isset($tSearchAll) && !empty($tSearchAll) && $tSearchAll != 'undefined'){
                $tSearchData    = $tSearchAll;
            }else{
                $tSearchData    = "";
            }
            $nPage              = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $tCmdDataEntry      = $this->input->post('tCmdDataEntry');
            $tCmdConsImport     = $this->input->post('tCmdConsImport');
            $aDataFiles         = (isset($_FILES['aFile']) && !empty($_FILES['aFile']))? $_FILES['aFile'] : null;
            
            $tSltTblCardEntry   = "";
            // เช็ค Switch Case Import Type List
            switch($tCmdDataEntry){
                case 1: // NewCard บัตรใหม่
                        // เช็คค่า ตาราง Temp แล้วทำการล้างข้อมูล Temp
                        if(isset($tSltCardEntry) && !empty($tSltCardEntry)){
                            FCNoCARDataListDeleteOnlyTable($tSltTblCardEntry);
                        }
                        // เซทค่าตาราง Temp ของเรื่องนั้นๆ
                        $tSltTblCardEntry   = "TFNTCrdImpTmp";

                        $ptDocType          = 'NewCard';
                        $ptDataSetType      = 'Excel';
                        $paDataExcel        = array(
                            'file'                  => $aDataFiles ,
                            'reasonfile'            => '', 
                            'optionfile_newcard'    => $tCmdConsImport,
                            'nDocno'                => '-'
                        );
                        $paDataSet = array('');
                        if(isset($_FILES['aFile'])){
                            $tResult = FCNaCARInsertDataToTempFileCenter($ptDocType,$ptDataSetType,$paDataExcel,$paDataSet);
                            // เช็คข้อมูลบันทึกบัตรใหม่เฉพาะข้อมูลใหม่เท่านั้น
                            if(isset($tCmdConsImport) && !empty($tCmdConsImport) && $tCmdConsImport == 1){
                                FSnHDelectDataNewCrdDupInCard();
                            }
                        }
                    break;
                case 2: // Top Up เติมเงิน
                        // ฟังก์ชั่นเช็คค่า ตาราง Temp แล้วทำการล้างข้อมูล Temp
                        if(isset($tSltCardEntry) && !empty($tSltCardEntry)){
                            FCNoCARDataListDeleteOnlyTable($tSltTblCardEntry);
                        }
                        // เซทค่าตาราง Temp ของเรื่องนั้นๆ
                        $tSltTblCardEntry   = "TFNTCrdTopUpTmp";

                        $ptDocType          = 'TopUp';
                        $ptDataSetType      = 'Excel';
                        $paDataExcel        = array(
                            'file'                  => $aDataFiles ,
                            'reasonfile'            => '', 
                            'optionfile_newcard'    => 0 ,
                            'nDocno'                => '-'
                        );
                        $paDataSet          = array('');
                        if(isset($_FILES['aFile'])){
                            FCNoCARDataListDeleteOnlyTable($tSltTblCardEntry);
                            $tResult        = FCNaCARInsertDataToTempFileCenter($ptDocType,$ptDataSetType,$paDataExcel,$paDataSet);
                        }
                    break;
                case 3: // CardTranfer เปลี่ยนบัตร
                        // ฟังก์ชั่นเช็คค่า ตาราง Temp แล้วทำการล้างข้อมูล Temp
                        if(isset($tSltCardEntry) && !empty($tSltCardEntry)){
                            FCNoCARDataListDeleteOnlyTable($tSltTblCardEntry);
                        }
                        // เซทค่าตาราง Temp ของเรื่องนั้นๆ
                        $tSltTblCardEntry   = "TFNTCrdVoidTmp";

                        $ptDocType          = 'CardTnfChangeCard';
                        $ptDataSetType      = 'Excel';
                        $paDataExcel        = array(
                            'file'                  => $aDataFiles ,
                            'reasonCode'            => $this->input->post('tReasonFile'), 
                            'optionfile_newcard'    => 0 ,
                            'nDocno'                => '-'
                        );
                        $paDataSet          = array('');
                        if(isset($_FILES['aFile'])){
                            FCNoCARDataListDeleteOnlyTable($tSltTblCardEntry);
                            $tResult = FCNaCARInsertDataToTempFileCenter($ptDocType,$ptDataSetType,$paDataExcel,$paDataSet);
                        }
                    break;
                case 4: // ClearCard ล้างบัตร
                        // ฟังก์ชั่นเช็คค่า ตาราง Temp แล้วทำการล้างข้อมูล Temp
                        if(isset($tSltCardEntry) && !empty($tSltCardEntry)){
                            FCNoCARDataListDeleteOnlyTable($tSltTblCardEntry);
                        }
                        // เซทค่าตาราง Temp ของเรื่องนั้นๆ
                        $tSltTblCardEntry   = "TFNTCrdImpTmp";

                        $ptDocType          = 'ClearCard';
                        $ptDataSetType      = 'Excel';
                        $paDataExcel        = array(
                            'file'                  => $aDataFiles ,
                            'reasonfile'            => '', 
                            'optionfile_newcard'    => $tCmdConsImport ,
                            'nDocno'                => '-'
                        );
                        $paDataSet      = array('');
                        if(isset($_FILES['aFile'])){
                            FCNoCARDataListDeleteOnlyTable($tSltTblCardEntry);
                            $tResult = FCNaCARInsertDataToTempFileCenter($ptDocType,$ptDataSetType,$paDataExcel,$paDataSet);
                        }
                    break;
            }

            if(empty($aDataFiles)){
                $aDataReturn = array(
                    'tStaLog'   => 'FirstPage',
                    'tDocType'  => $ptDocType
                );
                echo json_encode($aDataReturn);
            }else{
                //Upload success
                if($tResult['nStaEvent'] == 1){
                    $aDataReturn = array(
                        'tStaLog'   => 'Success',
                        'tDocType'  => $ptDocType
                    );
                    echo json_encode($aDataReturn);
                }else{  
                    $aDataReturn = array(
                        'tStaLog'   => $tResult['tTextError'],
                        'tDocType'  => $ptDocType
                    );
                    echo json_encode($aDataReturn);
                }
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }

    

    /** ============================================ Export ================================================ */

    //Functionality : Function Get Data Export Table
    //Parameters : Ajax Call View Export Table
    //Creator : 24/10/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCCMDExpFileDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TFNMCard_L');
            $nLangHave      = count($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }
            $tCMDDataType       = $this->input->post('tCMDDataType');
            $tCMDDataList       = $this->input->post('tCMDDataList');
            $nStaExportProcess  = $this->input->post('nStaExportProcess');
            $aCMDDataCons       = $this->input->post('oCMDDataExport');
            if($tCMDDataType == '2' && $tCMDDataList == '1' && is_array($aCMDDataCons)){
                $aData  = array(
                    'nPage'         => $nPage,
                    'nRow'          => 10,
                    'FNLngID'       => $nLangEdit,
                    'tSearchAll'    => $tSearchAll,
                    'aCMDDataCons'  => $aCMDDataCons
                );
                $aCMDDataExport = $this->mCardMngData->FSaMCMDGetDataCardExport($aData);
                $aRenderTable    = array(
                    'nStaProcess'       => $nStaExportProcess,
                    'aCMDDataExport'    => $aCMDDataExport,
                    'nPage'             => $nPage,
                    'tSearchAll'        => $tSearchAll
                );
            }else{
                $aRenderTable    = array(
                    'nStaProcess'       => $nStaExportProcess,
                    'nPage'             => $nPage,
                    'tSearchAll'        => $tSearchAll
                );
            }
            $this->load->view('document/cardmngdata/wCardMngDataExpDataTable',$aRenderTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function Export Process Data
    //Parameters : Ajax Process Export Data
    //Creator : 24/10/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSoCCMDProcessExport(){
        try{
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TFNMCard_L');
            $nLangHave      = count($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            $aExportCons    = $this->input->post('aDataCondition');
            $aDataCons      = array('FNLngID' => $nLangEdit,'aExportCons' => $aExportCons);
            $aDataExport    = $this->mCardMngData->FSoMCMDExpProcessData($aDataCons);
            if(is_array($aDataExport) && $aDataExport['rtCode']){
                // ตั้งค่า Font Size
                $aStyleHeadder = array('font' => array('size' => 12,'bold' => true,'color' => array('rgb' => 'FFFFFF')));

                $style3 = array('font' => array('size' => 12,'bold' => true,'color' => array('rgb' => 'FFFFFF')));

                //เริ่ม phpExcel
                $objPHPExcel = new PHPExcel();
                //A4 ตั้งค่าหน้ากระดาษ
                $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

                // จัดความกว้างของคอลัมน์
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        
                //หัวตาราง
                $nStartRowHeadder = 1;
                $objPHPExcel->getActiveSheet()->getStyle('A'.$nStartRowHeadder.':G'.$nStartRowHeadder)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB('306384');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$nStartRowHeadder.':G'.$nStartRowHeadder)->applyFromArray($aStyleHeadder);

                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$nStartRowHeadder, language('document/cardmngdata/cardmngdata','tCMDTBNo'))
                ->setCellValue('B'.$nStartRowHeadder, language('document/cardmngdata/cardmngdata','tCMDTBCardCode'))
                ->setCellValue('C'.$nStartRowHeadder, language('document/cardmngdata/cardmngdata','tCMDTBName'))
                ->setCellValue('D'.$nStartRowHeadder, language('document/cardmngdata/cardmngdata','tCMDTBStartDate'))
                ->setCellValue('E'.$nStartRowHeadder, language('document/cardmngdata/cardmngdata','tCMDTBExpireDate'))
                ->setCellValue('F'.$nStartRowHeadder, language('document/cardmngdata/cardmngdata','tCMDTBCardType'))
                ->setCellValue('G'.$nStartRowHeadder, language('document/cardmngdata/cardmngdata','tCMDTBStaType'));

                //ตัวอักษร Head Center
                $objPHPExcel->getActiveSheet()->getStyle("A".$nStartRowHeadder.":J".$nStartRowHeadder)
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $nStartRowData = 2;
                $nNum =0;
                foreach($aDataExport['raItems'] AS $nKey => $aValue){
                    $nNum++;

                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$nStartRowData, '  '.$nNum)
                    ->setCellValue('B'.$nStartRowData, '  '.$aValue['rtCrdCode'])
                    ->setCellValue('C'.$nStartRowData, '  '.$aValue['rtCrdName'])
                    ->setCellValue('D'.$nStartRowData, '  '.date("Y-m-d",strtotime($aValue['rtCrdStartDate'])))
                    ->setCellValue('E'.$nStartRowData, '  '.date("Y-m-d",strtotime($aValue['rtCrdExpireDate'])))
                    ->setCellValue('F'.$nStartRowData, '  '.$aValue['rtCrdCtyName'])
                    ->setCellValue('G'.$nStartRowData, '  '.($aValue['rtCrdStaType'] == 1)? language('payment/card/card','tCRDFrmCrdStaTypeDefault'): language('payment/card/card','tCRDFrmCrdStaTypeAuto'));
                
                    //ตัวอักษรชิดซ้าย
                    $objPHPExcel->getActiveSheet()->getStyle("A".$nStartRowData.":J".$nStartRowData)
                    ->getAlignment()
                    ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $nStartRowData++;
                }

                //Export File Excel
                $filename='CardExportData'.date("dmY").'.xlsx';
                // header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment; filename="'.$filename.'"');
                // header('Cache-Control: max-age=1');
                // $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
                $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                ob_start();
                $objWriter->save("php://output");
                $xlsData = ob_get_contents();
                ob_end_clean();

                $aResponse =  array(
                    'nStaExport'    => '1',
                    'tFileName'     => $filename,
                    'tFile'         => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData),
                    'tMessage'      => "Export File Successfully."
                );
            }else{
                $aResponse =  array(
                    'nStaExport'    => '800',
                    'tMessage'      => "Data Export Not Found."
                );
            }
        }catch(exception $Error){
            $aResponse =  array(
                'nStaExport'    => '801',
                'tMessage'      => "Error Not Export Data."
            );
        }
        echo json_encode($aResponse);
    }






    /** =============== New Concept Temp : Create Supawat =============== **/
    //Select Table
    public function FSaSelectDataTableRight(){
        $ptDocType      = $this->input->post('tDocType');
        $nPage          = $this->input->post('nPageCurrent');
        $tSearchAll     = $this->input->post('ptSearchAll');
        $tIDElement     = $this->input->post('ptIDElement');
        $tCmdConsImport     = $this->input->post('tCmdConsImport');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        // Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        switch($ptDocType){
            case 'NewCard': //บัตรใหม่
                $paParams['tSessionID'] = $this->session->userdata("tSesSessionID");
                $paParams['tSeqNo'] = "";
                // Validate New document temp
                FSnHNewCrdChkCrdCodeNotDupTemp($paParams);
                
                // เช็คข้อมูลบันทึกบัตรใหม่เฉพาะข้อมูลใหม่เท่านั้น
                if(isset($tCmdConsImport) && !empty($tCmdConsImport) && $tCmdConsImport == 1){
                    FSnHNewCrdChkCrdCodeDup($paParams);
                }
                
                FSnHNewCrdChkCrdNameNotEmpty($paParams);
                FSnHNewCrdChkCardTypeInDB($paParams);
                FSnHNewCrdChkDepartInDB($paParams);

                
                // Call data on temp helper
                $aDataTemp  = array(
                    'nPage'         => $nPage,
                    'nRow'          => 10,
                    'FNLngID'       => $nLangEdit,
                    'tSearchAll'    => $tSearchAll,
                    'ptDocType'     => "NewCard"
                );
                $aNewCardFromTemp   = FSaSelectDataForDocType($aDataTemp);
                $aDataRunHtml       = array(
                    'aDataList'     => $aNewCardFromTemp,
                    'tDataListAll'  => 0,
                    'rnAllRow'      => FSnSelectCountResult("TFNTCrdImpTmp"),
                    'ptDocType'     => $ptDocType,
                    'tIDElement'    => $tIDElement,
                    'nPage'         => $nPage,
                    'tSearchAll'    => $tSearchAll
                );
                
                $tHtmlViewImport   = $this->load->view('document/cardmngdata/wCardMngDataNewCardTable',$aDataRunHtml,true);
            break;

            case 'TopUp': //เติมเงิน
                $paParams['tSessionID']     = $this->session->userdata("tSesSessionID");
                $paParams['tSeqNo']         = "";
                $paParams['bStaCardShift']  = false;
                $paParams['nCrdStaActive']  = 1;
                // Validate document temp
                // เช็คบัตรในระบบ
                FSnHTopUpChkCrdCodeFoundInDB($paParams);
                // เช็คบัตรซ้ำในตาราง Temp
                FSnHTopUpChkCrdCodeNotDupTemp($paParams);
                // เช็คสถานะการเบิกบัตร
                FSnHTopUpChkStaShiftInCard($paParams);
                // เช็คสถานะบัตรใช้งาน
                FSnHTopUpChkStaActiveInCard($paParams);
                // เช็ควันที่บัตรหมดอายุ
                FSnHTopUpChkCardExpireDate($paParams);

                // Call data on temp helper
                $aDataTemp  = array(
                    'nPage'         => $nPage,
                    'nRow'          => 15,
                    'FNLngID'       => $nLangEdit,
                    'tSearchAll'    => $tSearchAll,
                    'ptDocType'     => "TopUp"
                );

                $aCardTopUpFromTemp = FSaSelectDataForDocType($aDataTemp);
                // echo '<pre>';
                // print_r($aCardTopUpFromTemp);
                $aDataRunHtml       = array(
                    'aDataList'     => $aCardTopUpFromTemp,
                    'tDataListAll'  => 0,
                    'rnAllRow'      => FSnSelectCountResult("TFNTCrdTopUpTmp"),
                    'ptDocType'     => $ptDocType,
                    'tIDElement'    => $tIDElement,
                    'nPage'         => $nPage,
                    'tSearchAll'    => $tSearchAll
                );

                $tHtmlViewImport    = $this->load->view('document/cardmngdata/wCardMngDataTopUpTable',$aDataRunHtml,true);
            break;

            case 'CardTnfChangeCard': //เปลี่ยนบัตร
                $paParams['tSessionID']     = $this->session->userdata("tSesSessionID");
                $paParams['tSeqNo']         = "";
               
                // Validate document temp
                FSnHCrdTranfChkOldCardFoundInDB($paParams);
                FSnHCrdTranfChkNewCardFoundInDB($paParams);
                FSnHCrdTranfChkNewCardNotDupTemp($paParams);
                FSnHCrdTranfChkNewCardOverBlc($paParams);
                FSnHCrdTranfChkRsnCodeNotEmpty($paParams);

                // $paParams['bStaCardShift'] = true;
                // FSnHCrdTranfChkStaShiftInCard($paParams);

                // $paParams['nCrdStaActive'] = 2;
                // FSnHCrdTranfChkNewCrdStaActiveInCard($paParams);
                // $paParams['nCrdStaActive'] = 1;
                // FSnHCrdTranfChkOldCrdStaActiveInCard($paParams);

                FSnHCrdTranfChkNewCrdHolderID($paParams);

                // Call data on temp helper
                $aDataTemp  = array(
                    'nPage'         => $nPage,
                    'nRow'          => 15,
                    'FNLngID'       => $nLangEdit,
                    'tSearchAll'    => $tSearchAll,
                    'ptDocType'     => "CardTnfChangeCard"
                );

                $aCardTopUpFromTemp = FSaSelectDataForDocType($aDataTemp);
                $aCardChangeCode = FSaSelectAllBySessionID("cardShiftChange");
                
                $aDataRunHtml       = array(
                    'aDataList'     => $aCardTopUpFromTemp,
                    'tDataListAll'  => json_encode($aCardChangeCode),
                    'rnAllRow'      => FSnSelectCountResult("TFNTCrdVoidTmp"),
                    'ptDocType'     => $ptDocType,
                    'tIDElement'    => $tIDElement,
                    'nPage'         => $nPage,
                    'tSearchAll'    => $tSearchAll
                );

                $tHtmlViewImport    = $this->load->view('document/cardmngdata/wCardMngDataCardTranfTable',$aDataRunHtml,true);
            break;

            case 'ClearCard': //ล้างบัตร
                $paParams['tSessionID'] = $this->session->userdata("tSesSessionID");
                $paParams['tSeqNo'] = "";
                $paParams['bStaCardShift'] = FALSE;
                // Validate Clear document temp
                FSnHClrCrdChkCrdCodeFoundInDB($paParams);
                FSnHClrCrdChkCrdCodeNotDupTemp($paParams);
                FSnHClrCrdChkStaShiftInCard($paParams);
                FSnHClrCrdChkCardExpireDate($paParams);
                
                // Call data on temp helper
                $aDataTemp  = array(
                    'nPage'         => $nPage,
                    'nRow'          => 10,
                    'FNLngID'       => $nLangEdit,
                    'tSearchAll'    => $tSearchAll,
                    'ptDocType'     => "ClearCard"
                );
                $aClearCardFromTemp   = FSaSelectDataForDocType($aDataTemp);
                
                $aDataRunHtml       = array(
                    'aDataList'     => $aClearCardFromTemp,
                    'tDataListAll'  => 0,
                    'rnAllRow'      => FSnSelectCountResult("TFNTCrdImpTmp"),
                    'ptDocType'     => $ptDocType,
                    'tIDElement'    => $tIDElement,
                    'nPage'         => $nPage,
                    'tSearchAll'    => $tSearchAll
                );
                $tHtmlViewImport   = $this->load->view('document/cardmngdata/wCardMngDataClearCardTable',$aDataRunHtml,true);
            break;

            // case 'cardShiftOut': //ใบเบิกบัตร
            //     $tHtmlViewImport  = $this->load->view('pos5/cardShiftOut/wNewCardShiftOutDataSourceTable',$aDataRunHtml,true);
            // break;

            // case 'cardShiftReturn': //ใบคืนบัตร
            //     $tHtmlViewImport  = $this->load->view('pos5/cardShiftReturn/wNewCardShiftReturnDataSourceTable',$aDataRunHtml,true);
            // break;

            // case 'cardShiftRefund': //ใบคืนเงิน
            //     $tHtmlViewImport  = $this->load->view('pos5/cardShiftRefund/wNewCardShiftRefundDataSourceTable',$aDataRunHtml,true);
            // break;

            // case 'cardShiftStatus': //ใบคืนเงิน
            //     $tHtmlViewImport  = $this->load->view('pos5/cardShiftStatus/wNewCardShiftStatusDataSourceTable',$aDataRunHtml,true);
            // break;

        }

        $aDataReturn        = array(
            'tHtmlView'     => $tHtmlViewImport,
            'nStaEvent'     => 1,
            'tStaMessage'   => 'Successful'
        );
        echo json_encode($aDataReturn);
    }

    //Delete Table right
    public function FSaDeleteDataTableRight(){
        $tID           = $this->input->post('ptID');
        $nSeq          = $this->input->post('pnSeq');
        $tDocType      = $this->input->post('ptDocType');
        $aData  = array(
            'tDocType'     => $tDocType,
            'nSeq'         => $nSeq,
            'tID'          => $tID
        );
        FSaDeleteDataForDocType($aData);
    }

    //Cleart Tmp By Table (parameter - nametable)
    public function FSaClearTempByTable(){
        $ptTableName  = $this->input->post('ptTableName');
        FCNoCARDataListDeleteOnlyTable($ptTableName);
    }

    //Update DocNo inTemp
    public function FSaUpdateDocnoinTempByTable(){
        $pnDocno        = $this->input->post('pnDocno');
        $ptTableName    = $this->input->post('ptTableName');
        echo FCNCallUpdateDocNo($pnDocno,$ptTableName);
    }


    // ===================== Edit In Line =====================================
    public function FSxCTopUpUpdateInlineOnTemp(){
        $tDocType           = "cardShiftTopUp";
        $nSeq               = $this->input->post('nSeq');
        $tCardCode          = $this->input->post('tCardCode');
        $nValue             = $this->input->post('nValue');
        $aDataSet = [
            "tCardCode"     => $tCardCode,
            "nValue"        => $nValue
        ];
        FSxUpdateTempBySeq($tDocType, $nSeq, $aDataSet);
    }

    public function FSxCNewCardUpdateInlineOnTemp(){
        $oNewCard   = json_decode($this->input->post('tNewCard'));
        $nSeq       = $this->input->post('nSeq');
        $tDocType   = "cardShiftNewCard";
        $aDataSet   = array(
            'tNewCardCode'  => $oNewCard->tCrdMngNewCardCode,
            'tNewCardName'  => $oNewCard->tCrdMngNewCardName,
            'tCardTypeCode' => $oNewCard->tCrdMngNewCtyCode,
            'tDptCode'      => $oNewCard->tCrdMngNewDptCode,
            'tDptName'      => $oNewCard->tCrdMngNewDptName,
        );
        FSxUpdateTempBySeq($tDocType, $nSeq, $aDataSet);
    }

    public function FSxCClearUpdateInlineOnTemp(){
        $tDocType           = "cardShiftClearCard";
        $nSeq               = $this->input->post('nSeq');
        $tCardCode          = $this->input->post('tCardCode');
        $aDataSet = [
            "tNewCardCode"     => $tCardCode
        ];
        FSxUpdateTempBySeq($tDocType, $nSeq, $aDataSet);
    }

     //Approve
    public function FSoCCMDProcessImport(){
        $nTypePage   = $this->input->post('nTypePage');

        switch($nTypePage){
            case 1: //บัตรใหม่
                $tName          = 'cardShiftNewCard';
                $tTableTmp      = 'TFNTCrdImpTmp';
                //##### DocNo ##### 
                $tGenDocNo      = 'TFNTCrdImpHD';

                $tDocNo = FCNaHGencodeV5($tGenDocNo, 7);
                $tDocNo = $tDocNo['rtCihDocNo'];
            break;
            case 2: //เติมเงิน
                $tName          = 'cardShiftTopUp';
                $tTableTmp      = 'TFNTCrdTopUpTmp';
                //##### DocNo ##### 
                $tGenDocNo      = 'TFNTCrdTopUpHD';

                $tDocNo = FCNaHGencodeV5($tGenDocNo, 3);
                $tDocNo = $tDocNo['rtCthDocNo'];
            break;
            case 3: //เปลี่ยนบัตร
                $tName          = 'cardShiftChange';
                $tTableTmp      = 'TFNTCrdVoidTmp';
                //##### DocNo ##### 
                $tGenDocNo      = 'TFNTCrdVoidHD';

                $tDocNo = FCNaHGencodeV5($tGenDocNo, 6);
                $tDocNo = $tDocNo['rtCvhDocNo'];
            break;
            case 4: //ล้างบัตร
                $tName          = 'cardShiftClearCard';
                $tTableTmp      = 'TFNTCrdImpTmp';
                //##### DocNo ##### 
                $tGenDocNo      = 'TFNTCrdImpHD';

                $tDocNo = FCNaHGencodeV5($tGenDocNo, 8);
                $tDocNo = $tDocNo['rtCihDocNo'];
            break;
            default:
            return;
        }

        //UpdateDocNo
        FCNCallUpdateDocNo($tDocNo,$tTableTmp);

        //Copy from Temp to DT
        FSxDocHelperTempToDT($tName);

        $aStaProcess = [];
        //Insert HD
        switch($nTypePage){
            case 1: //บัตรใหม่
                $aStaProcess = $this->FSaCProcessNewCard($tDocNo);
            break;
            case 2: //เติมเงิน
                $aStaProcess = $this->FSaCProcessTopUp($tDocNo);
            break;
            case 3: //เปลี่ยนบัตร
                $aStaProcess = $this->FSaCProcessTransferCard($tDocNo);
            break;
            case 4: //ล้างบัตร
                $aStaProcess = $this->FSaCProcessClearCard($tDocNo);
            break;
            default:
            return;
        }
        
        //Remove in Temp
        FCNoCARDataListDeleteOnlyTable($tTableTmp);
        
        $tStaProcess = json_encode($aStaProcess);
        echo $tStaProcess;
    }


    //Functionality : ฟังก์ชั่น Process New Card (บัตรใหม่)
    //Parameters : function parameters
    //Creator : 19/11/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSaCProcessNewCard($tDocCode){
        try{
            $tBchCode       = empty($this->session->userdata('tSesUsrBchCode'))?FCNtGetBchInComp():$this->session->userdata('tSesUsrBchCode');
            $tUsrCode       = $this->session->userdata("tSesUsername");

            $tTableNameHD   = "TFNTCrdImpHD";
            $aDataInsertHD = array(
                'FTBchCode'         => $tBchCode,
                'FTCihDocNo'        => $tDocCode,
                'FTCihDocType'      => 1,
                'FDCihDocDate'      => date('Y-m-d H:i:s'),
                'FTUsrCode'         => $this->session->userdata('tSesUsername'),
                'FTCihRmk'          => language('document/cardmngdata/cardmngdata','tCMDDocHDImpNewCard'),
                'FTCihApvCode'      => $this->session->userdata('tSesUsername'),
                'FDCihApvDate'      => date('Y-m-d H:i:s'),
                'FNCihStaDocAct'    => 1,
                'FTCihStaDoc'       => 1,
                'FTCihStaPrcDoc'    => 2,
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
            );
            $this->mCardMngData->FSaMCMDInsertDocHD($tTableNameHD,$aDataInsertHD);
            
            try {
                $aMQParams = [
                "queueName" => "CARDNEW", 
                    "params" => [
                        "ptBchCode" => $tBchCode, 
                        "ptDocNo"   => $tDocCode,
                        "ptUsrCode" => $tUsrCode
                    ]
                ];
                $nStaSendMQ = FCNxCallRabbitMQ($aMQParams);
                
                $aReturn = array(
                    'nStaProcess'   => '1',
                    'tStaMessage'   => 'Add Data Import Success.'
                );
            } catch(\ErrorException $err){
                $aReturn = array(
                    'nStaProcess'   => '900',
                    'tStaMessage'   => language('document/cardmngdata/cardmngdata','tCMDStatusErrorNotInsertDoc')
                );
            }
            
            return $aReturn;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : ฟังก์ชั่น Process Top-Up (เติมเงิน)
    //Parameters : function parameters
    //Creator : 19/11/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSaCProcessTopUp($tDocCode){
        try{
            $tBchCode       = empty($this->session->userdata('tSesUsrBchCode'))?FCNtGetBchInComp():$this->session->userdata('tSesUsrBchCode');
            $tUsrCode       = $this->session->userdata("tSesUsername");

            $tTableNameHD   = "TFNTCrdTopUpHD";
            $aVatCodeComp   = $this->mCardMngData->FSaMCMDGetVatCodeCompany();
            $nTotalTopUp    = 0;
            $nTotalTP       = FSaSelectDataForDocTypeTopUp('');
            $nTotal         = $nTotalTP[0]->Total;
            
            $aDataInsertHD = array(
                'FTBchCode'         => empty($this->session->userdata('tSesUsrBchCode'))?FCNtGetBchInComp():$this->session->userdata('tSesUsrBchCode'),
                'FTCthDocNo'        => $tDocCode,
                'FTCthDocType'      => 1,
                'FDCthDocDate'      => date('Y-m-d H:i:s'),
                'FTCthDocFunc'      => 1,
                'FTUsrCode'         => $this->session->userdata('tSesUsername'),
                'FTCthRmk'          => language('document/cardmngdata/cardmngdata','tCMDDocHDImpTopUp'),
                'FTUsrName'         => $this->session->userdata('tSesUsrUsername'),
                'FTCthStaDoc'       => 1,
                'FTCthStaPrcDoc'    => 2,
                'FTShfCode'         => $this->session->userdata('tSesUsername'),
                'FDShfSaleDate'     => date('Y-m-d H:i:s'),
                'FNCthStaDocAct'    => 1,
                'FTCthApvCode'      => $this->session->userdata('tSesUsername'),
                'FTVatCode'         => $aVatCodeComp['rtVatCode'],
                'FDCthApvDate'      => date('Y-m-d H:i:s'),
                'FCCthAmtTP'        => 0,
                'FCCthTotalTP'      => $nTotal,
                'FCCthTotalQty'     => FSnSelectCountResult('TFNTCrdTopUpTmp'),
                'FTCthStaPrc'       => 1,
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
            );

            $aStaInsertHD   = $this->mCardMngData->FSaMCMDInsertDocHD($tTableNameHD,$aDataInsertHD);
            
            try {
                $aMQParams = [
                "queueName" => "CARDTOPUP", 
                    "params" => [
                        "ptBchCode" => $tBchCode, 
                        "ptDocNo"   => $tDocCode,
                        "ptUsrCode" => $tUsrCode
                    ]
                ];
                $nStaSendMQ = FCNxCallRabbitMQ($aMQParams);
                
                $aReturn = array(
                    'nStaProcess'   => '1',
                    'tStaMessage'   => 'Add Data Import Success.'
                );
            } catch(\ErrorException $err){
                $aReturn = array(
                    'nStaProcess'   => '900',
                    'tStaMessage'   => language('document/cardmngdata/cardmngdata','tCMDStatusErrorNotInsertDoc')
                );
            }
                             
            return $aReturn;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : ฟังก์ชั่น Process Transfer Card (เปลี่ยนบัตร) 
    //Parameters : function parameters
    //Creator : 19/11/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSaCProcessTransferCard($tDocCode){
        try{
            $tBchCode       = empty($this->session->userdata('tSesUsrBchCode'))?FCNtGetBchInComp():$this->session->userdata('tSesUsrBchCode');
            $tUsrCode       = $this->session->userdata("tSesUsername");

            $tTableNameHD   = "TFNTCrdVoidHD";
            $aDataInsertHD  = array(
                'FTBchCode'         => empty($this->session->userdata('tSesUsrBchCode'))?FCNtGetBchInComp():$this->session->userdata('tSesUsrBchCode'),
                'FTCvhDocNo'        => $tDocCode,
                'FTCvhDocType'      => 2,
                'FDCvhDocDate'      => date('Y-m-d H:i:s'),
                'FTUsrCode'         => $this->session->userdata('tSesUsername'),
                'FTCvhRmk'          => language('document/cardmngdata/cardmngdata','tCMDDocHDImpTranfCard'),
                'FTCvhApvCode'      => $this->session->userdata('tSesUsername'),
                'FDCvhApvDate'      => date('Y-m-d H:i:s'),
                'FNCvhStaDocAct'    => 1,
                'FTCvhStaDoc'       => 1,
                'FTCvhStaPrcDoc'    => 2,
                'FNCvhCardQty'      => FSnSelectCountResult('TFNTCrdVoidTmp'),
                'FTCvhStaCrdActive' => 1,
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername')
            );
            
            $aStaInsertHD   = $this->mCardMngData->FSaMCMDInsertDocHD($tTableNameHD,$aDataInsertHD);
            
            try {
                $aMQParams = [
                "queueName" => "CARDSWAP", 
                    "params" => [
                        "ptBchCode" => $tBchCode, 
                        "ptDocNo"   => $tDocCode,
                        "ptUsrCode" => $tUsrCode
                    ]
                ];
                $nStaSendMQ = FCNxCallRabbitMQ($aMQParams);
                
                $aReturn = array(
                    'nStaProcess'   => '1',
                    'tStaMessage'   => 'Add Data Import Success.'
                );
            } catch(\ErrorException $err){
                $aReturn = array(
                    'nStaProcess'   => '900',
                    'tStaMessage'   => language('document/cardmngdata/cardmngdata','tCMDStatusErrorNotInsertDoc')
                );
            }
            
            return $aReturn;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : ฟังก์ชั่น Process Clear Card (ล้างบัตร)
    //Parameters : function parameters
    //Creator : 19/11/2018 Wasin
    //Return : data
    //Return Type : Array
    public function FSaCProcessClearCard($tDocCode){
        try{
            $tBchCode       = empty($this->session->userdata('tSesUsrBchCode'))?FCNtGetBchInComp():$this->session->userdata('tSesUsrBchCode');
            $tUsrCode       = $this->session->userdata("tSesUsername");

            $tTableNameHD   = "TFNTCrdImpHD";
            $aDataInsertHD = array(
                'FTBchCode'         => empty($this->session->userdata('tSesUsrBchCode'))?FCNtGetBchInComp():$this->session->userdata('tSesUsrBchCode'),
                'FTCihDocNo'        => $tDocCode,
                'FTCihDocType'      => 2,
                'FDCihDocDate'      => date('Y-m-d H:i:s'),
                'FTUsrCode'         => $this->session->userdata('tSesUsername'),
                'FTCihRmk'          => language('document/cardmngdata/cardmngdata','tCMDDocHDImpClaerCard'),
                'FTCihApvCode'      => $this->session->userdata('tSesUsername'),
                'FDCihApvDate'      => date('Y-m-d H:i:s'),
                'FNCihStaDocAct'    => 1,
                'FTCihStaDoc'       => 1,
                'FTCihStaPrcDoc'    => 2,
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
            );
            
            $aStaInsertHD   = $this->mCardMngData->FSaMCMDInsertDocHD($tTableNameHD,$aDataInsertHD);
            
            try {
                $aMQParams = [
                "queueName" => "CARDCLEAR", 
                    "params" => [
                        "ptBchCode" => $tBchCode, 
                        "ptDocNo"   => $tDocCode,
                        "ptUsrCode" => $tUsrCode
                    ]
                ];
                $nStaSendMQ = FCNxCallRabbitMQ($aMQParams);
                
                $aReturn = array(
                    'nStaProcess'   => '1',
                    'tStaMessage'   => 'Add Data Import Success.'
                );
            } catch(\ErrorException $err){
                $aReturn = array(
                    'nStaProcess'   => '900',
                    'tStaMessage'   => language('document/cardmngdata/cardmngdata','tCMDStatusErrorNotInsertDoc')
                );
            }
                       
            return $aReturn;
        }catch(Exception $Error){
            echo $Error;
        }
    }

























}












