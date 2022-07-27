<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Inv_controller extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('movement/movement/Movement_model');//
        $this->load->model('movement/inventory/Inv_model');
        date_default_timezone_set("Asia/Bangkok");
    }


    public function index($nMovementType,$tMovementOption){
        $vBtnSave           = FCNaHBtnSaveActiveHTML('mmtINV/0/0');
        $aAlwEventMovement	= FCNaHCheckAlwFunc('mmtINV/0/0');
        $this->load->view ( 'movement/inventory/wInventory', array (
            'vBtnSave'          =>$vBtnSave,
            'nMovementType'     =>$nMovementType,
            'tMovementOption'   =>$tMovementOption,
            'aAlwEventMovement' =>$aAlwEventMovement
        ));
    }

    /**
     * Functionality : แสดงหน้า list รายการสินค้าคงคลัง
     * Parameters : -
     * Creator : 15/04/2020 surawat
     * Last Modified : -
     * Return : html ฟอร์มค้นหารายการ
     * Return Type : html
     */
    public function FSxCInvPageList(){
        $aAlwEventMovement	       = FCNaHCheckAlwFunc('mmtINV/0/0');
        $tUsrBchCode     = $this->session->userdata("tSesUsrBchCode");
        $tUsrShpCode     = $this->session->userdata("tSesUsrShpCode");
        $this->load->view('movement/inventory/wInvList', array(
            'aAlwEventMovement'    => $aAlwEventMovement,
            'tUsrBchCode'          => $tUsrBchCode,
            'tUsrShpCode'          => $tUsrShpCode
        ));
    }

    /**
     * Functionality : แสดงหน้า list รายการสินค้าคงคลัง
     * Parameters : -
     * Creator : 15/04/2020 surawat
     * Last Modified : -
     * Return : html ฟอร์มค้นหารายการ
     * Return Type : html
     */
    public function FSxCInvDataTableList(){
        try{
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nRow           = 10;
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $tDataSearch    = $this->input->post('tDataFilter');
            $tSearchAll     = json_decode($tDataSearch, true);
            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => $nRow,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll
            );
            // $aMovementDataList               = $this->Movement_model->FSaMMovementList($aData);
            $aInvDataList               = $this->Inv_model->FSaMInvList($aData);
            $aAlwEventMovement	             = FCNaHCheckAlwFunc('mmtINV/0/0');
            $aGenTable  = array(
                'aDataList'                 => $aInvDataList,
                'nPage'                     => $nPage,
                'nRow'                      => $nRow,
                'tSearchAll'                => $tSearchAll,
                'aAlwEventMovement'         => $aAlwEventMovement,
                'tSearchAll'                => $tSearchAll,
                'nOptDecimalShow'           => FCNxHGetOptionDecimalShow()
            );


            $this->load->view('movement/inventory/wInvDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }





}
