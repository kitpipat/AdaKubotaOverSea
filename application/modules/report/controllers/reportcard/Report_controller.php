<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('reportcard/Reportcard_model');
        $this->load->model('pos5/company/Company_model');
    }

    public function index($nBrowseType,$tBrowseOption) {
        $nLngID     = FCNaHGetLangEdit();
        $nRoleCode  = $this->session->userdata('tSesUsrRoleCode');
        $aDataRPC   = $this->Reportcard_model->FSaMRPCGetDataReportcardList($nLngID,$nRoleCode);
        $aSltYear   = $this->Reportcard_model->FSaMRPGetdataYearList();    // Add select box for year 16/01/2019 (bell)

        $aData = array(
            'nBrowseType'   => $nBrowseType,
            'tBrowseOption' => $tBrowseOption,
            'aDataRPC'      => $aDataRPC,
            'aSltYear'     => $aSltYear
        );
        $this->load->view('reportcard/wReportcard',$aData);
    }
}
