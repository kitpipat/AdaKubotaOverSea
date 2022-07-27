<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reportanalysis_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('reportanalysis/Reportanalysis_model');
        $this->load->model('pos5/company/Company_model');
    }

    public function index($nRptAnsBrowseType,$tRptAnsBrowseOption){
        $aWhereData     = array(
            'tUsrRoleCode'  => $this->session->userdata('tSesUsrRoleCode'),
            'nLngID'        => FCNaHGetLangEdit('TSysMenuList_L')
        );
        $aMenuRptAns    = $this->Reportanalysis_model->FSaMRPAGetMenuReportAnalysis($aWhereData);
        // print_r($aWhereData);
        $aDataView      = array(
            'nRptAnsBrowseType'     => $nRptAnsBrowseType,
            'tRptAnsBrowseOption'   => $tRptAnsBrowseOption,
            'aMenuRptAns'           => $aMenuRptAns
        );
        $this->load->view('reportanalysis/wReportAnalysis',$aDataView);
    }
    




}