<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Taxinvoice_controller extends MX_Controller {

	public function __construct() {
        parent::__construct ();
        $this->load->model('taxinvoice/Taxinvoice_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nBrowseType,$tBrowseOption){
        $aData['nBrowseType']               = $nBrowseType;
        $aData['tBrowseOption']             = $tBrowseOption;
		$aData['aAlwEventTaxinvoiceABB']    = FCNaHCheckAlwFunc('TaxinvoiceABB/0/0'); //Controle Event
        $aData['vBtnSave']                  = FCNaHBtnSaveActiveHTML('TaxinvoiceABB/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน

        $this->load->view('sale/taxinvoice/wTaxinvoice',$aData);
    }

    //LIST พวกปุ่ม +
    public function FSvCTAXListPage(){
        $tTypeABB   = $this->input->post('tTypeABB');
        $aPackData  = array(
            'tTypeABB'      =>  $tTypeABB
        );
        $this->load->view('sale/taxinvoice/wTaxinvoiceList',$aPackData);
    }

    //DATA TABLE ข้อมูลในตาราง
    public function FSvCTAXDataTable(){
        $tTypeABB      = $this->input->post('tTypeABB');
        $nPage         = $this->input->post('nPageCurrent');
        $nLangEdit     = $this->session->userdata("tLangEdit");
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage  = $this->input->post('nPageCurrent');}

        $aData  = array(
            'tTypeABB'      => $tTypeABB,
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit
        );

        switch ($tTypeABB) {
            case "ABBVD":
                //ไป modal ใบกับกำภาษีของตู้ขายสินค้า
                $aResultList = $this->Taxinvoice_model->FSaMTAXDataTableABBVD($aData);
                break;
            case "ABBPOS":
                //ไป modal ใบกับกำภาษีของร้านค้า
                $aResultList = $this->Taxinvoice_model->FSaMTAXDataTableABBPOS($aData);
                break;
            case "ABBSL":
                //ไป modal ใบกับกำภาษีของตู้ฝากของ
                $aResultList = $this->Taxinvoice_model->FSaMTAXDataTableABBSL($aData);
                break;
            default:
                //ไป modal ใบกับกำภาษีของตู้ขายสินค้า
                $aResultList = $this->Taxinvoice_model->FSaMTAXDataTableABBVD($aData);
        }

        $aAlwEventTaxinvoiceABB         = FCNaHCheckAlwFunc('TaxinvoiceABB/0/0');
        $aGenTable                      = array(
            'aDataList' 	            => $aResultList,
            'nPage'     	            => $nPage,
            'aAlwEventTaxinvoiceABB'    => $aAlwEventTaxinvoiceABB
        );

        // Return Data View
        $this->load->view('sale/taxinvoice/wTaxinvoiceDataTable',$aGenTable);
    }


}
