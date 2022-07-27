<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cVendinglayout extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('vending/vendinglayout/mVendinglayout');
        date_default_timezone_set("Asia/Bangkok");
    }

    public $aHeight;
    public function index(){
        $nMsgResp               = array('title'=>"Vending Shop Layout");
        $vBtnSave               = FCNaHBtnSaveActiveHTML('vendingshoplayout/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwvendingshoplayout	= FCNaHCheckAlwFunc('vendingshoplayout/0/0');
        $this->load->view('vending/vendinglayout/wVendinglayout', array (
            'nMsgResp'                      => $nMsgResp,
            'vBtnSave'                      => $vBtnSave,
            'aAlwEventvendingshoplayout'    => $aAlwvendingshoplayout,
            'tShpCode'                      => $this->input->post('tShpCode'),
            'tBchCode'                      => $this->input->post('tBchCode')
        ));
    }

    //วิ่งเข้าฟังก์ชั่นแรก
    public function FSvVEDListPage(){
        $aPackData = array(
            'tShpCode'    => $this->input->post('tShpCode'),
            'tBchCode'    => $this->input->post('tBchCode')
        );
        //Stat dose - newUI
        $this->FSvVEDShowViewDiagram($aPackData);
    }

    //เข้าหน้า เซตข้อมูล
    public function FSvVEDShowViewSetting($paPackData){
        $this->load->view('vending/vendinglayout/wVendinglayoutSetting',$paPackData);
    }

    //เอาข้อมูลของ HD Setting ออกมาโชว์
    public function FSvVEDSelectSetting(){
        $tShpCode       = $this->input->post('tShpCode');
        $tBchCode       = $this->input->post('tBchCode');
        $nSeqCabinet    = $this->input->post('nSeqCabinet');
        $paPackData = array(
            'tShpCode'       => $tShpCode,
            'tBchCode'       => $tBchCode,
            'nSeqCabinet'    => $nSeqCabinet
        );
        $aGetDataHeightFloor    = $this->mVendinglayout->FSaMVEDGetDataHeightFloor($paPackData);
        $aGetDataHeightTemp     = $this->mVendinglayout->FSaMVEDGetDataHeightTemp($paPackData);

        $aReturn = array(
            // 'aGetDataSetting'       => $aGetDataSetting,
            'aGetDataHeightFloor'   => $aGetDataHeightFloor,
            'aGetDataHeightTemp'    => $aGetDataHeightTemp
        );
        
        echo json_encode($aReturn);
    }

    //เข้าหน้า แสดงข้อมูลสินค้า
    public function FSvVEDShowViewDiagram($paPackData){
        $aGetDataCabinet    = $this->mVendinglayout->FSaMVEDGetCabinet($paPackData);
        $aGetWahhouse       = $this->mVendinglayout->FSaMVEDGetWahhouse($paPackData);

        $aData = array(
            'aCabinet'      =>  $aGetDataCabinet,
            'aGetWahhouse'  =>  $aGetWahhouse
        );
        $this->load->view('vending/vendinglayout/wVendinglayoutDiagram',$aData);
    }

    //เพิ่มจำนวนชั้น จำนวนช่อง
    public function FSvVEDInsertSetting(){
        $aPackData = array(
            'tShpCode'          => $this->input->post('tShpCode'),
            'tBchCode'          => $this->input->post('tBchCode'),
            'tVBName'           => $this->input->post('tVBName'),
            'nVBFloor'          => $this->input->post('nVBFloor'),
            'nVBColumn'         => $this->input->post('nVBColumn'),
            'tVBReason'         => $this->input->post('tVBReason'),
            'aHeight'           => $this->input->post('aHeight'),
            'tTypePage'         => $this->input->post('tTypePage'),
            'tDisType'          => $this->input->post('tDisType'),
            'tCabinetSeq'       => $this->input->post('tCabinetSeq'), 
        );

        //เซตความสูงเก็บไว้เป็นตัวแปร global
        $aHeight          = $this->input->post('aHeight');
        $nKeyIndex        = 0;
        
        $this->mVendinglayout->FSaMVEDDeleteHeightToTmp($aPackData);
        for($i=1; $i<=count($aHeight); $i++){
            $this->mVendinglayout->FSaMVEDInsertHeightToTmp($i,$aHeight[$nKeyIndex],$aPackData);
            $nKeyIndex++;
        }
        
        //เพิ่มข้อมูลลงตาราง TVDMShopCabinet (เก็บว่าใช้กี่ชั้น ใช้กี่ช่อง)
        $aFindVendingLayout     = $this->mVendinglayout->FSxMVEDUpdateCabinet($aPackData);
        return $aFindVendingLayout;
    }

    //เพิ่มพวกสินค้าลง ฐานข้อมูล
    public function FSxVEDInsertDiagram(){
        $tBchCode       = $this->input->post('tBchCode');
        $tShopCode      = $this->input->post('tShopCode');
        $aPackData      = $this->input->post('aPackData');
        $nColQtyMax     = $this->input->post('nColQtyMax');
        $nSeqCabinet    = $this->input->post('nSeqCabinet');

        //หาว่า mercode อะไร
        $aDataCondition = array(
            'FTBchCode'         => $tBchCode,
            'FTShpCode'         => $tShopCode,
            'FNCabSeq'          => $nSeqCabinet
        );
        $aReturnMerCode = $this->mVendinglayout->FSaMVslFindMerCode($aDataCondition);

        //ลบสินค้าก่อนทุกครั้ง
        $this->mVendinglayout->FSaMVslDeleteItem($aDataCondition);

        //เพิ่มข้อมูลสินค้าจาก diagram
        for($j=0; $j<count($aPackData); $j++){
            $aColumn = $aPackData[$j];

            $aDataInsert = array(
                'FTBchCode'         => trim($tBchCode),
                'FNCabSeq'          => $nSeqCabinet,
                'FTMerCode'         => $aReturnMerCode['raItems'][0]['FTMerCode'],
                'FTShpCode'         => $tShopCode,
                'FNLayRow'          => $aColumn['nFloor'],
                'FNLayCol'          => $aColumn['nColumn'] - 1,
                'FTPdtCode'         => $aColumn['nPDTCode'],    
                'FCLayColQtyMax'    => $aColumn['nDim'],
                'FCLayDim'          => $aColumn['nDim'],
                'FCLayHigh'         => $this->mVendinglayout->FStMVEDFindHeight(trim($tBchCode),trim($tShopCode),$aColumn['nFloor'],$nSeqCabinet),
                'FCLayWide'         => $aColumn['nUseColumn'],
                'FTLayStaUse'       => 1,
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FTLayStaCtrlXY'    => $aColumn['tStatusSpring'],
                'FTWahCode'         => $aColumn['nWahCode']
            );

            $this->mVendinglayout->FSaMVslInsertPDT($aDataInsert);
        }

        //เรียง Seq ใหม่
        $this->mVendinglayout->FSxMVEDSortSeqrow($aDataCondition);
    }

    //ไปค้นหาว่ามีข้อมูลไหม ถ้ามี ให้เอามาโชว์
    public function FSxVEDGetPDTShopLayout(){
        $tBchCode       = $this->input->post('tBchCode');
        $tShopCode      = $this->input->post('tShopCode');
        $nSeqCabinet    = $this->input->post('nSeqCabinet');

        $paPackData = array(
            'tShpCode'          => $tShopCode,
            'tBchCode'          => $tBchCode,
            'nSeqCabinet'       => $nSeqCabinet
        );

        $aGetDataDT     = $this->mVendinglayout->FSaMVEDGetDataDT($paPackData);
        $aData = array(
            'aDT'       => $aGetDataDT,
        );

        echo json_encode($aData);
    }

    //ลบข้อมูลใน diagram เพื่อที่จะต้องการสร้างใหม่
    public function FSxVEDDeleteDiagram(){
        $tBchCode       = $this->input->post('tBchCode');
        $tShopCode      = $this->input->post('tShopCode');
        $nSeqCabinet    = $this->input->post('nSeqCabinet');

        $paPackData = array(
            'tShpCode'          => $tShopCode,
            'tBchCode'          => $tBchCode,
            'nSeqCabinet'       => $nSeqCabinet
        );

        $aDeleteLayout = $this->mVendinglayout->FSaMVEDDeleteDiagram($paPackData);
        echo json_encode($aDeleteLayout);
    }


}
