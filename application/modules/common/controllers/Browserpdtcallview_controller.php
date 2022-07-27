<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Browserpdtcallview_controller extends MX_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('common/Browserpdtcallview_model');
        $this->load->model('company/branch/Branch_model');
    }

    //List PDT Serach
    public function index(){
        //hidden filter search
        $Qualitysearch  = $this->input->post('Qualitysearch');

        //price type
        $PriceType      = $this->input->post('PriceType');

        //Select Tier : เลือกระดับไหน [PDT,Barcode]
        $SelectTier     = $this->input->post('SelectTier');
        if (isset($SelectTier)) {
            $SelectTier = $SelectTier[0];
        } else {
            $SelectTier = 'Barcode';
        }

        //element return input
        $tElementreturn     = $this->input->post('Elementreturn');

        // ******************************************************************************************************
        // Create By Witsarut 02/07/2020  เก็บข้อมูลลง  Cookie
        $nCheckPage  =  $this->input->cookie("PDTCookie_" . $this->session->userdata("tSesUserCode"), true);
        $tCookieVal = json_decode($nCheckPage);

        if(!empty($nCheckPage)){
            $nPerPage = $tCookieVal->nPerPage;
        }else{
            $nPerPage ='';
        }
        
        //ShowCountRecord
        if($nPerPage == '' || null){
            $nShowCountRecord  = $this->input->post('ShowCountRecord');
        }else{
           $nShowCountRecord   = $nPerPage;
        }

        // ******************************************************************************************************
        
        //name NextFunc
        $tNameNextFunc      = $this->input->post('NextFunc');

        //Return type S,M
        $tReturnType        = $this->input->post('ReturnType');

        //Parameter SPL
        $tParameterSPL      = $this->input->post('SPL');

        //Parameter BCH
        $tParameterBCH      = $this->input->post('BCH');

        //Parameter MCH
        $tParameterMER      = $this->input->post('MER');

        //Parameter SHP
        $tParameterSHP      = $this->input->post('SHP');

        //Parameter DISTYPE
        $tParameterDISTYPE    = $this->input->post('DISTYPE');

        //Get Time for localstorage
        $tTimeLocalstorage  = $this->input->post('TimeLocalstorage');

        $tPagename          = $this->input->post('PageName');
        if (isset($tPagename)) {
            $tPagename = $tPagename;
        } else {
            $tPagename = '';
        }

        //Not in Item
        $aNotinItem         = $this->input->post('NOTINITEM');
        
        $aData = array(
            'nShowCountRecord'  => $nShowCountRecord,
            'aQualitysearch'    => $Qualitysearch,
            'aPriceType'        => $PriceType,
            'tSelectTier'       => $SelectTier,
            'tElementreturn'    => $tElementreturn,
            'tNameNextFunc'     => $tNameNextFunc,
            'tReturnType'       => $tReturnType,
            'SesBch'            => $this->session->userdata("tSesUsrBchCode"),
            'SesShp'            => $this->session->userdata("tSesUsrShpCode"),
            'SesMer'            => $this->session->userdata("tSesUsrMerCode"),
            'tParameterSPL'     => $tParameterSPL,
            'tParameterMER'     => $tParameterMER,
            'tParameterBCH'     => $tParameterBCH,
            'tParameterSHP'     => $tParameterSHP,
            'tParameterDISTYPE' => $tParameterDISTYPE,
            'tTimeLocalstorage' => $tTimeLocalstorage ,
            'tPagename'         => $tPagename,
            'aNotinItem'        => $aNotinItem,
        );

        $this->load->view('common/wBrowsePDTCallView', $aData);
    }

    //วิ่งเข้าฟังก์ชั่น get product โยนพวก parameter ไป
    public function FSxGetProductfotPDT(){
        $tBarcode  =  $this->input->post('tTextScan');
        if($tBarcode == '' || $tBarcode == null){
            $nPage                  =  $this->input->post("nPage");
            $tPagename              =  $this->input->post("tPagename");

            // ****************************************************************************************
            // Create By Witsarut 02/07/2020  เก็บข้อมูลลง  Cookie
            $nCheckPage  =  $this->input->cookie("PDTCookie_" . $this->session->userdata("tSesUserCode"), true);
            $tCookieVal = json_decode($nCheckPage);

            if(!empty($nCheckPage)){
                $nPerPage = $tCookieVal->nPerPage;
            }else{
                $nPerPage ='';
            }
            
            if($nPerPage == '' || null){
                $nRow  = $this->input->post('nRow');
            }else{
               $nRow   = $nPerPage;
            }
            // ****************************************************************************************

            $aPriceType             =  json_decode($this->input->post("aPriceType"));
            $tBCH                   =  $this->input->post("BCH");
            $tSHP                   =  $this->input->post("SHP");
            $tMER                   =  $this->input->post("MER");
            $tSPL                   =  $this->input->post("SPL");
            $nDISTYPE               =  $this->input->post("DISTYPE");
            $tSelectTier            =  $this->input->post("SelectTier");
            $tReturnType            =  $this->input->post("ReturnType");
            $aNotinItem             =  $this->input->post("aNotinItem");
            $nPDTMoveon             =  $this->input->post("PDTMoveon");
            $nTotalResult           =  $this->input->post("nTotalResult");
            $tSearchText            =  $this->input->post("tSearchText");
            $tSearchSelect          =  $this->input->post("tSearchSelect");
            $tFindOnlyPDT           = 'normal';
        }else{
            $tBCH                   =  $this->input->post("BCH");
            $tSHP                   =  $this->input->post("SHP");
            $tMER                   =  $this->input->post("MER");
            $tSPL                   =  $this->input->post("SPL");
            $aPriceType             =  $this->input->post("aPriceType");
            $tSearchText            =  trim($tBarcode);
            $tSearchSelect          =  'PDTANDBarcode';
            $nTotalResult           =  0;
            $nRow                   =  90000;
            $nPage                  =  1;
            $tReturnType            = 'S';
            $tFindOnlyPDT           = 'Barcode';
        }

        $aDataSearch = array(
            'FNLngID'               => $this->session->userdata("tLangEdit"),
            'nPage'                 => @$nPage,
            'nRow'                  => @$nRow,
            'aPriceType'            => @$aPriceType,
            'tBCH'                  => @$tBCH,
            'tMER'                  => @$tMER,
            'tSHP'                  => @$tSHP,
            'tSPL'                  => @$tSPL,
            'nDISTYPE'              => @$nDISTYPE , 
            'tSelectTier'           => @$tSelectTier,
            'tPagename'             => @$tPagename,
            'aNotinItem'            => @$aNotinItem,
            'nPDTMoveon'            => @$nPDTMoveon,
            'tSearchText'           => @$tSearchText,
            'tSearchSelect'         => @$tSearchSelect,
            'nTotalResult'          => ($nTotalResult == '') ? '0' : $nTotalResult,
            'tFindOnlyPDT'          => $tFindOnlyPDT
        );

        //ค้นหาสินค้า
        $aProduct = $this->JSaCGetDataProduct($aDataSearch);

        // Create Witsarut 25/06/2020
        // GetAllRow 
        if($aProduct['nPDTAll'] == 0){
            $tGetAllRow = $this->session->userdata("tSesGetAllRow");
        }else{
            $tGetAllRow = $aProduct['nPDTAll'];
        }

        $this->session->set_userdata("tSesGetAllRow", $tGetAllRow);

        //หาประเภทราคา ใช้ต้นทุนแบบไหน [1,2,3,4];
        if($aPriceType[0] == 'Pricesell' || $aPriceType[0] == 'Price4Cst'){
            $aCheckPrice = '';
            $tVatInorEx  = '';
        }else if($aPriceType[0] == 'Cost'){
            $aCheckPrice = $this->Browserpdtcallview_model->FSnMGetTypePrice($aPriceType[1], $aPriceType[2], $aPriceType[3]);
            if ($tSPL == '' || $tSPL == null) { 
                //ไม่ส่ง spl มา
                $aGetInorEx    = $this->Browserpdtcallview_model->FSaMGetWhsInorExIncompany();
                $tVatInorEx    = $aGetInorEx[0]['FTCmpRetInOrEx'];
            } else {
                $aGetInorEx    = $this->Browserpdtcallview_model->FSaMGetWhsInorExInSupplier($tSPL);
                if (empty($aGetInorEx)) {
                    $tVatInorEx    = 1;
                } else {
                    $tVatInorEx    = $aGetInorEx[0]['FTSplStaVATInOrEx'];
                }
            }
        }

        $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
        $aDataHTML          = array(
            'nPage'             => $this->input->post("nPage"),
            'aPriceType'        => $aPriceType,
            'tSelectTier'       => @$tSelectTier,
            'nOptDecimalShow'   => $nOptDecimalShow,
            'aTSysconfig'       => $aCheckPrice,
            'tReturnType'       => $tReturnType,
            'tVatInorEx'        => $tVatInorEx,
            'aProduct'          => $aProduct
        );

        
        if($tBarcode == '' || $tBarcode  == null){
            $this->load->view('common/wBrowsePDTTableCallView', $aDataHTML);
        }else{
            if($aProduct['rtCode'] == 800){
                $aReturn = 800;
            }else{
                $tReturn    = $aProduct;
                $aData      = $tReturn['raItems'];
                $aReturn    = array();
                for($i=0; $i<count($tReturn['raItems']); $i++){
                    $aPackData = array(
                        'SHP'       => $aData[$i]['FTShpCode'],
                        'BCH'       => $aData[$i]['FTPdtSpcBch'],
                        'PDTCode'   => $aData[$i]['FTPdtCode'],
                        'PDTName'   => $aData[$i]['FTPdtName'],
                        'PUNCode'   => $aData[$i]['FTPunCode'],
                        'Barcode'   => $aData[$i]['FTBarCode'],
                        'PUNName'   => $aData[$i]['FTPunName'],
                        'PriceRet'  => number_format($aData[$i]['FCPgdPriceRet'], $nOptDecimalShow, '.', ','),
                        'PriceWhs'  => number_format($aData[$i]['FCPgdPriceWhs'], $nOptDecimalShow, '.', ','),
                        'PriceNet'  => number_format($aData[$i]['FCPgdPriceNet'], $nOptDecimalShow, '.', ','),
                        'IMAGE'     => $aData[$i]['FTImgObj'],
                        'LOCSEQ'    => '',
                        'Remark'    => $aData[$i]['FTPdtName'],
                        'CookTime'  => ($aData[$i]['FCPdtCookTime'] == '') ? 0 : $aData[$i]['FCPdtCookTime'],
                        'CookHeat'  => ($aData[$i]['FCPdtCookHeat'] == '') ? 0 : $aData[$i]['FCPdtCookHeat'],
                        'AlwDis'    => ($aData[$i]['FTPdtStaAlwDis'] == '' || $aData[$i]['FTPdtStaAlwDis'] == null ) ? 2 : $aData[$i]['FTPdtStaAlwDis'],
                        'AlwVat'    => $aData[$i]['FTPdtStaVat'],
                        'nVat'      => $aData[$i]['FCVatRate'],
                        'NetAfHD'   => number_format($aData[$i]['FCPgdPriceRet'], $nOptDecimalShow, '.', ',')
                    );
                    array_push($aReturn , [ "pnPdtCode" => $aData[$i]['FTPdtCode'] , 
                                            "ptBarCode" => $aData[$i]['FTBarCode'] ,
                                            "ptPunCode" => $aData[$i]['FTPunCode'] ,
                                            "packData"  => $aPackData
                                          ]);
                }
            }
            echo json_encode($aReturn);
        }
    }

    //GET Product
    public function JSaCGetDataProduct($paData){
        $tFilter            = '';
        $tBchSession        = $this->session->userdata("tSesUsrBchCom");
        $tShpSession        = $this->session->userdata("tSesUsrShpCode");
        $tMerSession        = $this->session->userdata("tSesUsrMerCode");
        $tSelectTier        = $paData['tSelectTier'];
        // $tFilter            .= " AND ";

        //-------------------สินค้าเคลื่อนไหว-------------------
        $nPDTMoveon = $paData['nPDTMoveon']; 
        if ($nPDTMoveon == 1){
            $tFilter .= " AND Products.FTPdtStaActive = '1' ";
        }else if($nPDTMoveon == 2){
            $tFilter .= " AND Products.FTPdtStaActive = '2' ";
        }

        //-------------------ฟิลเตอร์การค้นหา-------------------
        $tSearchSelect  = $paData['tSearchSelect'];
        $tSearchText    = $paData['tSearchText'];
        if($tSearchText != '' || $tSearchText != null){

            if($tSearchSelect == 'PDTANDBarcode'){
                $tFilter .= " AND (Products.FTPdtCode = '$tSearchText' OR Products.FTBarCode = '$tSearchText' )";
            }
            switch ($tSearchSelect) {
                case "FTPdtName": 
                    //ชื่อสินค้า
                    $tFilter .= " AND (Products.FTPdtName LIKE '%$tSearchText%')";
                    break;
                case "FTPdtCode": 
                    //รหัสสินค้า
                    $tFilter .= " AND (Products.FTPdtCode LIKE '%$tSearchText%') ";
                    break;
                case "FTBarCode": 
                    //รหัสบาร์โค๊ด
                    $tFilter .= " AND (Products.FTBarCode LIKE '%$tSearchText%')";
                    break;
                case "FTPgpCode": 
                    //กลุ่มสินค้า
                    $tFilter .= " AND (Products.FTPgpChain = '$tSearchText')";
                    break;
                case "FTPtyCode": 
                    //ประเภทสินค้า
                    $tFilter .= " AND (Products.FTPtyCode = '$tSearchText' )";
                    break;
                case "FTBuyer": 
                    //ผู้จัดซื้อ
                    $tFilter .= " AND (Products.FTBuyer = '$tSearchText')";
                    break;
                case "FTPlcCode": 
                    //ที่เก็บ
                    $tFoundPDT = $this->Browserpdtcallview_model->FSnMFindPDTByBarcode($tSearchText,'FINDPLCCODE');
                    if($tFoundPDT == false || empty($tFoundPDT)){
                        //กรณีที่เข้าไปหา plc code เเล้วไม่เจอ PDT เลย ต้องให้มันค้นหา โดย KEYWORD : EMPTY
                        $tFilter    .= " AND (Products.FTPdtCode = 'EMPTY' AND Products.FTPunCode = 'EMPTY')";
                    }else{
                        $tPDT       = $tFoundPDT[0]['FTPdtCode'];
                        $tPunCode   = $tFoundPDT[0]['FTPunCode'];
                        $tBarCode   = $tFoundPDT[0]['FTBarCode'];
                        $tFilter    .= " AND (Products.FTBarCode = '$tBarCode')";
                    }
                    break;
                case "ALL": 
                    $tFilter .= " AND (Products.FTPdtName LIKE '%$tSearchText%')";
                    $tFilter .= " OR (Products.FTPdtCode LIKE '%$tSearchText%')";
                    $tFilter .= " OR (Products.FTPgpChain = '$tSearchText')";
                    $tFilter .= " OR (Products.FTBuyer = '$tSearchText')";
                    break;
                default:
                    $tFilter .= "";
            }
            
        }

        if(!empty($paData['nDISTYPE'])){
            $nDISTYPE = $paData['nDISTYPE'];
            $tFilter .= " AND (Products.FTPdtStaAlwDis = $nDISTYPE )";
            // FTPdtStaAlwDis
        }
        //-------------------เงื่อนไขพิเศษ ตามหน้า-------------------
        $tPagename = $paData['tPagename'];
        if($tPagename == 'PI'){
            $tFilter .= " AND (Products.FTPdtSetOrSN != 4)";
        }
   
        //-------------------ไม่เอาสินค้าอะไรบ้าง NOT IN-------------------
        $aNotinItem = $paData['aNotinItem'];
        if(!empty($aNotinItem)){
            if($aNotinItem != '' || $aNotinItem != null){
                $tNotinItem     = '';
                $tNotinBarcode  = '';
                $aNewNotinItem  = explode(',',$aNotinItem);

                for($i=0; $i<count($aNewNotinItem); $i++){
                    $aNewPDT  = explode(':::',$aNewNotinItem[$i]);
                    $tFilter .= " AND (Products.FTPdtCode != '$aNewPDT[0]' OR Products.FTBarCode != '$aNewPDT[1]' )";
                }
            }
        }

        //-------------------เลือกราคาแบบไหน-------------------
        if($paData['aPriceType'][0] == 'Pricesell'){
            //ถ้าเหมือนกันให้ใช้ Price4PDT ถ้าไม่เหมือนกันให้ใช้ Price4BCH
            $tLeftJoinPrice  = " LEFT JOIN VCN_Price4PdtActive VPP ON ";
            $tLeftJoinPrice .= " VPP.FTPdtCode = ProductM.FTPdtCode AND ";
            $tLeftJoinPrice .= " VPP.FTPunCode = ProductM.FTPunCode ";
        }else if($paData['aPriceType'][0] =='Price4Cst'){

            $tUserBchCode = $this->session->userdata('tSesUsrBchCom');
            $tCstPplCode  = $paData['aPriceType'][1];

            //--ราคาของ customer
            $tLeftJoin = "LEFT JOIN (
                            SELECT * FROM (
                            SELECT 
                                ROW_NUMBER () OVER ( PARTITION BY FTPdtCode , FTPunCode ORDER BY FDPghDStart DESC) AS FNRowPart,
                                FTPdtCode , 
                                FTPunCode , 
                                FCPgdPriceRet 
                                FROM TCNTPdtPrice4PDT WHERE  
                            FDPghDStart <= CONVERT (VARCHAR(10), GETDATE(), 121)
                            AND FDPghDStop >= CONVERT (VARCHAR(10), GETDATE(), 121)
                            AND FTPghTStart <= CONVERT(time,GETDATE())
	                        AND FTPghTStop >= CONVERT(time,GETDATE())
                            AND FTPplCode = '$tCstPplCode'
                            ) AS PCUS 
                            WHERE PCUS.FNRowPart = 1 
                        ) PCUS ON ProductM.FTPdtCode = PCUS.FTPdtCode AND ProductM.FTPunCode = PCUS.FTPunCode ";
            
            // --ราคาของสาขา
            $tLeftJoin .= "LEFT JOIN (
                            SELECT * FROM (
                            SELECT 
                                ROW_NUMBER () OVER ( PARTITION BY FTPdtCode , FTPunCode ORDER BY FDPghDStart DESC) AS FNRowPart,
                                FTPdtCode , 
                                FTPunCode , 
                                FCPgdPriceRet 
                                FROM TCNTPdtPrice4PDT WHERE  
                            FDPghDStart <= CONVERT (VARCHAR(10), GETDATE(), 121)
                            AND FDPghDStop >= CONVERT (VARCHAR(10), GETDATE(), 121)
                            AND FTPghTStart <= CONVERT(time,GETDATE())
	                        AND FTPghTStop >= CONVERT(time,GETDATE())
                            AND FTPplCode = (SELECT FTPplCode FROM TCNMBranch WHERE FTPplCode != '' AND FTBchCode = '$tUserBchCode')
                            ) AS PCUS 
                            WHERE PCUS.FNRowPart = 1 
                        ) PBCH ON ProductM.FTPdtCode = PBCH.FTPdtCode AND ProductM.FTPunCode = PBCH.FTPunCode ";
        
            // --ราคาที่ไม่กำหนด PPL
            $tLeftJoin .= "LEFT JOIN (
                            SELECT * FROM (
                            SELECT 
                                ROW_NUMBER () OVER ( PARTITION BY FTPdtCode , FTPunCode ORDER BY FDPghDStart DESC) AS FNRowPart,
                                FTPdtCode , 
                                FTPunCode , 
                                FCPgdPriceRet 
                                FROM TCNTPdtPrice4PDT WHERE  
                            FDPghDStart <= CONVERT (VARCHAR(10), GETDATE(), 121)
                            AND FDPghDStop >= CONVERT (VARCHAR(10), GETDATE(), 121)
                            AND FTPghTStart <= CONVERT(time,GETDATE())
	                        AND FTPghTStop >= CONVERT(time,GETDATE())
                            AND ISNULL(FTPplCode,'') = ''
                            ) AS PCUS 
                            WHERE PCUS.FNRowPart = 1 
                        ) PEMPTY ON ProductM.FTPdtCode = PEMPTY.FTPdtCode AND ProductM.FTPunCode = PEMPTY.FTPunCode ";

            $tLeftJoinPrice  = " $tLeftJoin ";
        }else if($paData['aPriceType'][0] == 'Cost'){
            $tLeftJoinPrice  = " LEFT JOIN VCN_ProductCost VPC ON ";
            $tLeftJoinPrice .= " VPC.FTPdtCode = ProductM.FTPdtCode ";
        }

        //-------------------ผู้จำหน่าย-------------------
        if($paData['tSPL'] != '' || $paData['tSPL'] != null){
            $tFilter .= " AND (Products.FTSplCode = '".$paData['tSPL']."' OR ISNULL(Products.FTSplCode,'') = '')";
        }

        //-------------------สาขา-------------------
        if($paData['tBCH'] != '' || $paData['tBCH'] != null){
			$tBCH 	 = $paData['tBCH'];
        }else{
			$tBCH 	 = $tBchSession;
        }
        
        //-------------------กลุ่มธุรกิจ-------------------
        if($paData['tMER'] != '' || $paData['tMER'] != null){
            $tFilter .= " AND (Products.FTMerCode = '".$paData['tMER']."')";
        }
        
        //-------------------ร้านค้า-------------------
        if($paData['tSHP'] != '' || $paData['tSHP'] != null){
            //$tFilter .= " AND (Products.FTShpCode = '".$paData['tSHP']."')";
        }

        //เงือนไขว่าวิ่งเข้า VIEW SQL ชุดไหน
        //+-------------+-------------+-------------+-------------+
        //+     BCH     +     MER     +     SHP     +    V_SQL    +
        //+-------------+-------------+-------------+-------------+
        //+     null    +     null    +     null    +     HQ      +
        //+-------------+-------------+-------------+-------------+
        //+      /      +     null    +     null    +     BCH     +
        //+-------------+-------------+-------------+-------------+
        //+      /      +     /       +     null    +     BCH     +
        //+-------------+-------------+-------------+-------------+
        //+      /      +     /       +      /      +     SHP     +
        //+-------------+-------------+-------------+-------------+
        //+      /      +     null    +      /      +     SHP     +
        //+-------------+-------------+-------------+-------------+
        //+     null    +     /       +      /      +     SHP     +
        //+-------------+-------------+-------------+-------------+
        //+     null    +     null    +      /      +     SHP     +
        //+-------------+-------------+-------------+-------------+
        //+     null    +     /       +     null    +     SHP     +
        //+-------------+-------------+-------------+-------------+
        
        $nTotalResult       = $paData['nTotalResult'];
        if($paData['tBCH'] == '' && $paData['tMER'] == '' && $paData['tSHP'] == ''){
            // HQ
            $tPermission    = 'HQ';
        }else if($paData['tBCH'] != '' && $paData['tMER'] == '' && $paData['tSHP'] == ''){
            // BCH 
            $tPermission    = 'BCH';
        }else if($paData['tBCH'] != '' && $paData['tMER'] != '' && $paData['tSHP'] == ''){
            // BCH 
            $tPermission    = 'BCH';
        }else if($paData['tBCH'] != '' && $paData['tMER'] != '' && $paData['tSHP'] != ''){
            // SHP
            $paData['tBCH'] = $tBCH;
            $tPermission    = 'SHP';
        }else if($paData['tBCH'] == '' && $paData['tMER'] != '' && $paData['tSHP'] != ''){
            // SHP
            $paData['tBCH'] = $tBCH;
            $tPermission    = 'SHP';
        }else if($paData['tBCH'] == '' && $paData['tMER'] == '' && $paData['tSHP'] != ''){
            // SHP
            $paData['tBCH'] = $tBCH;
            $tPermission    = 'SHP';
        }else if($paData['tBCH'] == '' && $paData['tMER'] != '' && $paData['tSHP'] == ''){
            // SHP
            $paData['tBCH'] = $tBCH;
            $tPermission    = 'SHP';
        }else if($paData['tBCH'] != '' && $paData['tMER'] == '' && $paData['tSHP'] != ''){
            // SHP
            $paData['tBCH'] = $tBCH;
            $tPermission    = 'SHP';
        }else{
            $tPermission    = 'ETC';
        }   

        switch ($tPermission) {
            case "HQ":
                $aResultPDT = $this->Browserpdtcallview_model->FSaMGetProductHQ($tFilter,$tLeftJoinPrice,$paData,$nTotalResult);
                //print_r(  $aResultPDT );
                break;
            case "BCH":
                $aResultPDT = $this->Browserpdtcallview_model->FSaMGetProductBCH($tFilter,$tLeftJoinPrice,$paData,$nTotalResult);
                //print_r(  $aResultPDT );
                break;
            case "SHP":
                $aResultPDT = $this->Browserpdtcallview_model->FSaMGetProductSHP($tFilter,$tLeftJoinPrice,$paData,$nTotalResult);
                break;
            default:
                $aResultPDT = ' E R R O R';
        }

        // echo $tPermission;
        return $aResultPDT;
    }


    // Add DataPdtConfig
    // Create Witsarut 30/06/2020
    public function FSvCallViewModalPdtConfig(){

        $nMaxPage   = $this->input->post('nCheckMaxPage');
        $nPerPage   = $this->input->post('nCheckPerPage');

        $aData = array(
            'nMaxPage'   => $this->input->post('nCheckMaxPage'),
            'nPerPage'   => $this->input->post('nCheckPerPage')
        );

        $tPrefixCookie = "PDTCookie_";

        $nCookieName = $tPrefixCookie . $this->session->userdata("tSesUserCode");
        $tCookieValue   = json_encode($aData);

        $aCookie = array(
            'name'    => $nCookieName,
            'value'   => $tCookieValue,
            'expire'  => 31556926,
        );

        $this->input->set_cookie($aCookie);
       
    }

}
