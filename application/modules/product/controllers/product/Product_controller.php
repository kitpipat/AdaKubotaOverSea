<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product/product/Product_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nPdtBrowseType, $tPdtBrowseOption)
    {
        $nMsgResp   = array('title' => "Card");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if (!$isXHR) {
            $this->load->view('common/wHeader', $nMsgResp);
            $this->load->view('common/wTopBar', array('nMsgResp' => $nMsgResp));
            $this->load->view('common/wMenu', array('nMsgResp' => $nMsgResp));
        }
        // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $vBtnSave       = FCNaHBtnSaveActiveHTML('product/0/0');
        $aAlwEventPdt   = FCNaHCheckAlwFunc('product/0/0');
        $this->load->view('product/product/wProduct', array(
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nPdtBrowseType'    => $nPdtBrowseType,
            'tPdtBrowseOption'  => $tPdtBrowseOption,
            'aAlwEventPdt'      => $aAlwEventPdt
        ));
    }

    //Functionality : Function Call Page Product Main
    //Parameters : Ajax and Function Parameter
    //Creator : 31/01/2019 wasin(Yoshi)
    //Return : String View
    //Return Type : View
    public function FSvCPDTCallPageMain()
    {
        $aAlwEventPdt   = FCNaHCheckAlwFunc('product/0/0');
        $this->load->view('product/product/wProductMain', array(
            'aAlwEventPdt'  => $aAlwEventPdt
        ));
    }

    //Functionality : Function Call View Product DataTable
    //Parameters : Ajax Call View DataTable
    //Creator : 31/01/2019 wasin(Yoshi)
    //Return : String View
    //Return Type : View
    public function FSvCPDTCallPageDataTable()
    {
        try {
            $nPage          = $this->input->post('nPageCurrent');
            $tSearchAll     = $this->input->post('tSearchAll');
            $nSearchProductType   = $this->input->post('nSearchProductType');
            $tPdtForSys     = $this->input->post('tPdtForSys');
            if ($nPage == '' || $nPage == null) {
                $nPage = 1;
            } else {
                $nPage  = $this->input->post('nPageCurrent');
            }
            if (!$tSearchAll) {
                $tSearchAll = '';
            }
            //Lang ภาษา
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");

            $aData  = array(
                'nRow'          => 50,
                'nPage'         => $nPage,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll,
                'nSearchProductType' => $nSearchProductType,
                'tPdtForSys'    => $tPdtForSys,
                'nPagePDTAll'   => $this->input->post('nPagePDTAll')
            );

            $aColumnShow        = FCNaDCLGetColumnShow('TCNMPdt');
            $aAlwEventPdt       = FCNaHCheckAlwFunc('product/0/0');
            $aPdtDataList       = $this->Product_model->FSaMPDTGetDataTable($aData);

            $aGenTable  = array(
                'aPdtColumnShw' => $aColumnShow,
                'aAlwEventPdt'  => $aAlwEventPdt,
                'aPdtDataList'  => $aPdtDataList,
                'nPage'         => $nPage,
                'tPdtForSys'    => $tPdtForSys
            );

            // Return Dat View
            $aReturnData = array(
                'vPdtPageDataTable' => $this->load->view('product/product/wProductDataTable', $aGenTable, true),
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality : Call Data Advance Table Col List Show
    //Parameters : Ajax Paramiter
    //Creator : 31/01/2019 wasin(Yoshi)
    //Last Modified : -
    //Return : Object Data List Advance Table
    //Return Type : Object
    public function FSoCPDTAdvTableShwColList()
    {
        try {
            $aAvailableColumn   =   FCNaDCLAvailableColumn('TCNMPdt');
            if (isset($aAvailableColumn) && !empty($aAvailableColumn)) {
                $aDataReturn    = array(
                    'aAvailableColumn'  => $aAvailableColumn,
                    'nStaEvent'         => '1',
                    'tStaMessg'         => 'Success'
                );
            } else {
                $aDataReturn    = array(
                    'nStaEvent' => '800',
                    'tStaMessg' => language('common/main/main', 'tModalAdvMngTableNotFoundData')
                );
            }
        } catch (Exception $Error) {
            $aDataReturn = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataReturn);
    }

    //Functionality : Save Avance Table Set User 
    //Parameters : Ajax Paramiter
    //Creator : 31/01/2019 wasin(Yoshi)
    //Last Modified : -
    //Return : Status Update Avence Table
    //Return Type : numeric
    public function FSnCPDTAdvTableShwColSave()
    {
        try {
            $this->db->trans_begin();
            FCNaDCLSetShowCol('TCNMPdt', '', '');
            $aColShowSet        = $this->input->post('aColShowSet');
            $aColShowAllList    = $this->input->post('aColShowAllList');
            $aColumnLabelName   = $this->input->post('aColumnLabelName');
            $nStaSetDef         = $this->input->post('nStaSetDef');
            if ($nStaSetDef == 1) {
                FCNaDCLSetDefShowCol('TCNMPdt');
            } else {
                for ($i = 0; $i < count($aColShowSet); $i++) {
                    FCNaDCLSetShowCol('TCNMPdt', 1, $aColShowSet[$i]);
                }
            }
            //Reset Seq
            FCNaDCLUpdateSeq('TCNMPdt', '', '', '');
            $q = 1;
            for ($n = 0; $n < count($aColShowAllList); $n++) {
                FCNaDCLUpdateSeq('TCNMPdt', $aColShowAllList[$n], $q, $aColumnLabelName[$n]);
                $q++;
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aDataReturn    = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Eror Not Save Colums'
                );
            } else {
                $this->db->trans_commit();
                $aDataReturn    = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success'
                );
            }
        } catch (Exception $Error) {
            $aDataReturn = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataReturn);
    }

    // Functionality : Function CallPage Product Add
    // Parameters : Ajax Call Page
    // Creator : 01/02/2019 wasin(Yoshi)
    // Last Modified : -
    // Return : String View
    // Return Type : View
    public function FSoCPDTCallPageAdd()
    {
        try {
            date_default_timezone_set("Asia/Bangkok");
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");

            $nUseType       = $this->session->userdata("tSesUsrLevel");
            $nUsrBchCode    = $this->session->userdata("tSesUsrBchCodeMulti");
            $nUsrShpCode    = $this->session->userdata("tSesUsrShpCodeMulti");
            $dGetDataNow    = date('Y-m-d');
            $dGetDataFuture = date('Y-m-d', strtotime('+1 year'));

            // Delete All Temp
            $aDataWhere     = array(
                'FTMttTableKey'     => 'TCNMPdt',
                'DeleteType'        => 2, //1 Delete Singal , 2 Delete All
                'FTMttSessionID'    => $this->session->userdata("tSesSessionID")
            );

            $this->Product_model->FSaMPDTDelDataMasTemp($aDataWhere);
            $aDataSpcWah  = array(
                $tPdtCode        = $this->input->post('tPdtCode'),
                $nUsrBchCode    = $this->session->userdata("tSesUsrBchCodeMulti")
            );
            $aDataPdtSpcWah = $this->Product_model->FSaMPDTGetDataPdtSpcWah($aDataSpcWah);
            $aReturnVat = $this->Product_model->FSaMPDTGetVatRateCpn();
            //เช็ค vat ว่ามีค่า หรือไม่
            if ($aReturnVat['rtCode'] == 1) {
                $aDataVatrate  = array(
                    'tVatCode'  =>  $aReturnVat['raItems']['0']['FTVatCode'],
                    'tVatRate'  =>  $aReturnVat['raItems']['0']['FCVatRate']
                );
            } else {
                $aDataVatrate  = array(
                    'tVatCode'  =>  '',
                    'tVatRate'  =>  "0.00"
                );
            }
            $aCtyCheck      = $this->Product_model->FSaMPDTCtyCheckByID($this->session->userdata('tSesUsrInfo')['FTUsrCode']);
            $aLangList      = FCNaGetLngListByCty();
            $aVatRate       = FCNoHCallVatlist();
            $aAlwEventPdt   = FCNaHCheckAlwFunc('product/0/0');
            $aDatProduct    = array(
                'nStaAddOrEdit'     => 99,
                'aVatRate'          => $aVatRate,
                'aAlwEventPdt'      => $aAlwEventPdt,
                'nUseType'          => $nUseType,
                'nUsrBchCode'       => $nUsrBchCode,
                'nUsrShpCode'       => $nUsrShpCode,
                'dGetDataNow'       => $dGetDataNow,
                'dGetDataFuture'    => $dGetDataFuture,
                'tVatCompany'       => $aDataVatrate,
                'aDataPdtSpcWah'    => $aDataPdtSpcWah,
                'aLangList'         => $aLangList,
                'aCtyCheck'         => $aCtyCheck
            );
            $aReturnData    =   array(
                'vPdtPageAdd'   => $this->load->view('product/product/wProductAdd', $aDatProduct, true),
                'nStaEvent'     => '1',
                'tStaMessg'     => 'Success'
            );
        } catch (Exception $Error) {
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Function CallPage Product Edit
    // Parameters : Ajax Call Page
    // Creator : 20/02/2019 wasin(Yoshi)
    // Last Modified : -
    // Return : String View
    // Return Type : View
    public function FSoCPDTCallPageEdit()
    {
        try {
            $tPdtCode       = $this->input->post('tPdtCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $nUseType       = $this->session->userdata("tSesUsrLevel");
            $nUsrBchCode    = $this->session->userdata("tSesUsrBchCodeMulti");
            $nUsrShpCode    = $this->session->userdata("tSesUsrShpCodeMulti");
            $aDataWhere     = array(
                'FTMttTableKey'     => 'TCNMPdt',
                'FTMttRefKey'       => 'TCNMPdtPackSize',
                'FTPdtCode'         => $tPdtCode,
                'FNLngID'           => $nLangEdit,
                'DeleteType'        => 2, //1 Delete Singal , 2 Delete All
                'FTMttSessionID'    => $this->session->userdata("tSesSessionID"),
                'dDate'             => date('Y-m-d H:i:s'),
                'tUser'             => $this->session->userdata('tSesUsername'),
            );
            // Insert into PackSize Temp
            $aDataWhereBarCode     = array(
                'FTMttTableKey'     => 'TCNMPdt',
                'FTMttRefKey'       => 'TCNMPdtBar',
                'FTPdtCode'         => $tPdtCode,
                'FNLngID'           => $nLangEdit,
                'FTMttSessionID'    => $this->session->userdata("tSesSessionID"),
                'dDate'             => date('Y-m-d H:i:s'),
                'tUser'             => $this->session->userdata('tSesUsername')
            );

            // บันทึกข้อมูลงตาราง  TsysMasTmp
            $this->Product_model->FSaMPDTStockConditionsGetDataList($aDataWhere);
            // Delete All Temp
            $this->Product_model->FSaMPDTDelDataMasTemp($aDataWhere);
            // Insert into PackSize Temp
            $this->Product_model->FSaMPDTInsertPackSizeMasTemp($aDataWhere);
            //Get Data BarCode MasTmp
            $this->Product_model->FSaMPDTInsertBarCodeMasTemp($aDataWhereBarCode);
            // Get Data Product Info
            $aPdtImgData        = $this->Product_model->FSaMPDTGetDataImgByID($aDataWhere);
            $aPdtInfoData       = $this->Product_model->FSaMPDTGetDataInfoByID($aDataWhere);
            $aPdtRentalData     = $this->Product_model->FSaMPDTGetDataRentalByID($aDataWhere);
            $aChkChainPdtSet    = $this->Product_model->FSaMPDTChkChainPdtSet($aDataWhere);
            // Get Data Product History PI
            $aPdtHisPI      = $this->Product_model->FSaMPDTGetDataHistoryPI($aDataWhere);
            $aVatRate       = FCNoHCallVatlist();
            $aAlwEventPdt   = FCNaHCheckAlwFunc('product/0/0');

            $aLangList      = FCNaGetLngListByCty();

            // View Product Add Main
            $tViewPagePdtAdd    = $this->load->view('product/product/wProductAdd', array(
                'nStaAddOrEdit'     => 1,
                'aVatRate'          => $aVatRate,
                'aAlwEventPdt'      => $aAlwEventPdt,
                'aPdtImgData'       => $aPdtImgData,
                'aPdtInfoData'      => $aPdtInfoData,
                'aPdtRentalData'    => $aPdtRentalData,
                'aPdtHisPI'         => $aPdtHisPI,
                'nUseType'          => $nUseType,
                'nUsrBchCode'       => $nUsrBchCode,
                'nUsrShpCode'       => $nUsrShpCode,
                'aChkChainPdtSet'   => $aChkChainPdtSet,
                'aLangList'         => $aLangList,
            ), true);
            $aReturnData    = array(
                'vPdtPageAdd'       => $tViewPagePdtAdd,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        } catch (Exception $Error) {
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }


    // Functionality : CallPage DataTable Product Event Not Sale
    // Parameters : Ajax Call Page DataTable Product Event Not Sale
    // Creator : 07/02/2018 wasin
    // Last Modified : -
    // Return : object View
    // Return Type : object
    public function FSoCPDTEvnNotSaleDataTable()
    {
        try {
            $tEvnCode       = $this->input->post('tEvnCode');
            //Lang ภาษา
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aData  = array(
                'FTEvnCode' => $tEvnCode,
                'FNLngID'   => $nLangEdit
            );

            $aDataNoEvnCode = $this->Product_model->FSaMPDTEvnNotSaleByID($aData);
            $aGenTable      = array('aDataList' => $aDataNoEvnCode);
            $aReturnData    = array(
                'vPdtEvnNotSale'    => $this->load->view('product/product/wProductNoSaleEvnDataTable', $aGenTable, true),
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }


    // Functionality : CallPage DataTable Product PackSize 
    // Parameters : Ajax Call Page DataTable Product PackSize
    // Creator : 08/02/2018 wasin
    // Last Modified : -
    // Return : object View
    // Return Type : object
    public function FSoCPDTPackSizeDataTable()
    {
        try {
            $FTPdtCode   = $this->input->post('FTPdtCode');
            // Get Lang ภาษา
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");

            $aData = array(
                'FTMttTableKey'         => 'TCNMPdt',
                'FTMttRefKey'           => 'TCNMPdtPackSize',
                'FTPdtCode'             => $FTPdtCode,
                'FNLngID'               => $nLangEdit,
                'FTMttSessionID'        => $this->session->userdata("tSesSessionID"),
            );
            $aDataPdtUnit       = $this->Product_model->FSaMPDTGetDataMasTemp($aData);
            $aAlwEventPdt       = FCNaHCheckAlwFunc('product/0/0');
            $aGenTable  = array(
                'aAlwEventPdt'          => $aAlwEventPdt,
                'aDataUnitPackSize'     => $aDataPdtUnit
            );
            $this->load->view('product/product/wProductPackSizeDataTable', $aGenTable);
        } catch (Exception $Error) {
            // $aReturnData = array(
            //     'nStaEvent' => '500',
            //     'tStaMessg' => $Error->getMessage()
            // );
        }
        // echo json_encode($aReturnData);
    }

    // Last Update : Napat(Jame) 09/06/2020
    public function FSoCPDTPackSizeDelete()
    {
        $FTPdtCode      = $this->input->post('FTPdtCode');
        $FTPunCode      = $this->input->post('FTPunCode');
        $nTypeAction    = $this->input->post('pnTypeAction');

        // Get Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $aData = array(
            'FTMttTableKey'         => 'TCNMPdt',
            'FTMttRefKey'           => 'TCNMPdtPackSize',
            'FTPdtCode'             => $FTPdtCode,
            'FTPunCode'             => $FTPunCode,
            'FNLngID'               => $nLangEdit,
            'DeleteType'            => $nTypeAction, //1 Delete Singal , 2 Delete All Temp , 3 Delete All Pdt , 4 Delete Multi
            'FTMttSessionID'        => $this->session->userdata("tSesSessionID"),
        );

        $this->Product_model->FSaMPDTDelDataMasTemp($aData);
        $aDataPdtUnit       = $this->Product_model->FSaMPDTGetDataMasTemp($aData);
        $aAlwEventPdt       = FCNaHCheckAlwFunc('product/0/0');
        $aGenTable  = array(
            'aAlwEventPdt'          => $aAlwEventPdt,
            'aDataUnitPackSize'     => $aDataPdtUnit
        );
        $this->load->view('product/product/wProductPackSizeDataTable', $aGenTable);
    }

    // Functionality : Func.Chech BarCode Duplicate In DB
    // Parameters : Ajax Send Event Post
    // Creator : 12/02/2018 Wasin(Yoshi)
    // Last Modified : -
    // Return : object Array Data Chk BarCode Duplicate
    // Return Type : object
    public function FSoCPDTChkBarcodeDup()
    {
        try {
            $tPdtCode = $this->input->post('tPdtCode');
            $tBarcode = $this->input->post('tBarCode');
            if (isset($tBarcode) && !empty($tBarcode)) {
                $aStaBarcode    = $this->Product_model->FSaMStaChkBarcode($tPdtCode, $tBarcode);
                if ($aStaBarcode['rtCode'] == 1) {
                    $aReturnData = array(
                        'nStaBarCodeDup' => $aStaBarcode['raItems']['Counts'],
                        'nStaEvent'      => '1',
                        'tStaMessg'      => 'Success Ajax'
                    );
                }
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality: Function Add Product Event
    //Parameters:  Ajax Send Event Post
    //Creator: 15/02/2018 Wasin(Yoshi)
    //LastModified: -
    //Return: Return object Status Event Add
    //ReturnType: object
    public function FSoCPDTAddEvent()
    {
        try {
            $nTypeAdd           = $this->input->post('pnTypeAdd');
            $nLangResort        = $this->session->userdata("tLangID");
            $nLangEdit          = $this->session->userdata("tLangEdit");
            $aPdtImg            = $this->input->post('aPdtImg');
            $aPdtDataInfo1      = $this->input->post('aPdtDataInfo1');

            // เช็คโค้ดสี 
            if ($aPdtDataInfo1['tChecked'] == '0') {
                $tCodeColor         = $aPdtDataInfo1['tPdtColor'];
            } else {
                $tCodeColor         = $aPdtDataInfo1['tChecked'];
            }

            $aPdtDataInfo2      = $this->input->post('aPdtDataInfo2');
            $tIsAutoGenCode     = $aPdtDataInfo1['tIsAutoGenCode'];

            // Setup Product Code
            $tPdtCode   = "";
            if (isset($tIsAutoGenCode) && $tIsAutoGenCode == '1') {
                // Call Auto Gencode Helper
                $aStoreParam = array(
                    "tTblName"   => 'TCNMPdt',
                    "tDocType"   => 0,
                    "tBchCode"   => "",
                    "tShpCode"   => "",
                    "tPosCode"   => "",
                    "dDocDate"   => date("Y-m-d")
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $tPdtCode   = $aAutogen[0]["FTXxhDocNo"];
            } else {
                $tPdtCode   = $aPdtDataInfo1['tPdtCode'];
            }

            $aDataWherePdt      = array(
                'FTPdtCode'         => $tPdtCode
            );
            $aDataWhereMasTmp   = array(
                'FTMttTableKey'     => 'TCNMPdt',
                'FTMttSessionID'    => $this->session->userdata("tSesSessionID")
            );
            $aDataWherePackSize = array(
                'FTMttTableKey'     => 'TCNMPdt',
                'FTMttRefKey'       => 'TCNMPdtPackSize',
                'FTMttSessionID'    => $this->session->userdata("tSesSessionID")
            );
            $aDataWhereBarCode = array(
                'FTMttTableKey'     => 'TCNMPdt',
                'FTMttRefKey'       => 'TCNMPdtBar',
                'FTMttSessionID'    => $this->session->userdata("tSesSessionID")
            );

            $aDataAddUpdatePdt  = array(
                'FTPdtStkControl'       => $aPdtDataInfo1['nPdtStkControl'],
                'FTPdtForSystem'        => $aPdtDataInfo2['tPdtForSystem'], //1
                'FCPdtQtyOrdBuy'        => floatval(preg_replace("/[^-0-9\.]/", "", $aPdtDataInfo2['tPdtQtyOrdBuy'])),
                'FCPdtCostDef'          => floatval(preg_replace("/[^-0-9\.]/", "", $aPdtDataInfo2['tPdtCostDef'])),
                'FCPdtCostOth'          => floatval(preg_replace("/[^-0-9\.]/", "", $aPdtDataInfo2['tPdtCostOth'])),
                'FCPdtCostStd'          => floatval(preg_replace("/[^-0-9\.]/", "", $aPdtDataInfo2['tPdtCostStd'])),
                'FCPdtMax'              => floatval(preg_replace("/[^-0-9\.]/", "", $aPdtDataInfo2['tPdtMax'])),
                'FTPdtPoint'            => $aPdtDataInfo1['nPdtStaPoint'],
                'FTPdtType'             => $aPdtDataInfo1['tPdtType'],
                'FTPdtSaleType'         => $aPdtDataInfo1['tPdtSaleType'],
                'FTPdtSetOrSN'          => '1',
                'FTPdtStaSetPri'        => '1',
                'FTPdtStaSetShwDT'      => '2',
                'FTPdtStaAlwDis'        => $aPdtDataInfo1['nPdtStaAlwDis'],
                'FTPdtStaAlwReturn'     => $aPdtDataInfo1['nPdtStaAlwReturn'],
                'FTPdtStaVatBuy'        => $aPdtDataInfo1['nPdtStaVatBuy'],
                'FTPdtStaVat'           => $aPdtDataInfo1['nPdtStaVat'],
                'FTPdtStaActive'        => $aPdtDataInfo1['nPdtStaActive'],
                'FTPdtStaAlwReCalOpt'   => 1,
                'FTPdtStaCsm'           => 1,
                'FTTcgCode'             => $aPdtDataInfo2['tPdtTcgCode'],
                'FTPgpChain'            => $aPdtDataInfo2['tPdtPgpChain'],
                'FTPtyCode'             => $aPdtDataInfo2['tPdtPtyCode'],
                'FTPbnCode'             => $aPdtDataInfo2['tPdtPbnCode'],
                'FTPmoCode'             => $aPdtDataInfo2['tPdtPmoCode'],
                'FTCtyCode'             => $aPdtDataInfo2['tPdtCyCode'],
                'FTVatCode'             => $aPdtDataInfo1['tPdtVatCode'],
                'FDPdtSaleStart'        => ($aPdtDataInfo2['tPdtSaleStart'] == '') ? NULL : $aPdtDataInfo2['tPdtSaleStart'],
                'FDPdtSaleStop'         => ($aPdtDataInfo2['tPdtSaleStop'] == '') ? NULL : $aPdtDataInfo2['tPdtSaleStop'],
                'FTPdtRefID'            => $aPdtDataInfo1['tPdtRefID']
            );

            $aDataSpcBch        = array(
                'FTPdtCode'             => $tPdtCode,
                'FTAgnCode'             => $aPdtDataInfo2['tPdtAgnCode'],
                'FTBchCode'             => $aPdtDataInfo2['tPdtBchCode'],
                'FTMerCode'             => $aPdtDataInfo2['tPdtMerCode'],
                'FTShpCode'             => $aPdtDataInfo2['tPdtShpCode'],
                'FTMgpCode'             => $aPdtDataInfo2['tPdtMgpCode'],
                'FCPdtMin'              => floatval(preg_replace("/[^-0-9\.]/", "", $aPdtDataInfo2['tPdtMin']))
            );

            $aDataWhereLangPdt  = array(
                'FNLngID'           => $nLangEdit,
                'FTPdtCode'         => $tPdtCode
            );
            $aDataLangPdt       = array(
                'FNLngID'       => $nLangEdit,
                'FTPdtName'     => $aPdtDataInfo1['tPdtName'],
                'FTPdtNameOth'  => $aPdtDataInfo1['tPdtNameOth'],
                'FTPdtNameABB'  => $aPdtDataInfo1['tPdtNameABB'],
                'FTPdtRmk'      => $aPdtDataInfo2['tPdtRmk']
            );

            $aLangList = FCNaGetLngListByCty();
            $aPdtList  = array();
            parse_str($this->input->post('aPdtInputTab'), $aPdtListForm);
            foreach($aLangList AS $Lng){
                $aPdtList[$Lng['FTLngShortName']] = array(
                    'FTPdtName'      => $aPdtListForm[($Lng['FTLngShortName'] == $this->session->userdata('tSesDefCountry')) ? 'oetPdtName' : 'oetPdtName'.$Lng['FTLngShortName']],
                    'FNLngID'        => $aPdtListForm[($Lng['FTLngShortName'] == $this->session->userdata('tSesDefCountry')) ? 'ohdPdtLngID' : 'ohdPdtLngID'.$Lng['FTLngShortName']],
                    'FTPdtNameOth'   => $aPdtListForm[($Lng['FTLngShortName'] == $this->session->userdata('tSesDefCountry')) ? 'oetPdtNameOth' : 'oetPdtNameOth'.$Lng['FTLngShortName']],
                    'FTPdtNameABB'   => $aPdtListForm[($Lng['FTLngShortName'] == $this->session->userdata('tSesDefCountry')) ? 'oetPdtNameABB' : 'oetPdtNameABB'.$Lng['FTLngShortName']],
                    'FTPdtRmk'       => $aPdtDataInfo2['tPdtRmk']
                );
            }
            // Check Product Dup In DataBase
            $aStaPdtDup =   $this->Product_model->FSaMPDTCheckDuplicate($aDataWherePdt['FTPdtCode']);
            if ($aStaPdtDup['rtCode'] == '1' && $aStaPdtDup['rnCountPdt'] == '0') {
                $this->db->trans_begin();
                $this->Product_model->FSaMPDTAddUpdateMaster($aDataWherePdt, $aDataAddUpdatePdt);
                $this->Product_model->FSaMPDTAddUpdateLang($aDataWhereLangPdt, $aPdtList);
                if ($aDataSpcBch['FTAgnCode'] != "" || $aDataSpcBch['FTBchCode'] != "" || $aDataSpcBch['FTMerCode'] != "" || $aDataSpcBch['FTShpCode'] != "" || $aDataSpcBch['FTMgpCode'] != "" || $aDataSpcBch['FCPdtMin'] != "") {
                    $this->Product_model->FSxMPDTAddUpdateSpcBch($aDataSpcBch);
                }

                if ($nTypeAdd == 1) {
                    $this->Product_model->FSxMPDTUpdatePdtCodeMasTmp($aDataWhereMasTmp, $aDataWherePdt);
                    $this->Product_model->FSxMPDTAddUpdatePackSize($aDataWherePdt, $aDataWherePackSize);
                    $this->Product_model->FSxMPDTAddUpdateBarCode($aDataWherePdt, $aDataWhereBarCode);
                    $this->Product_model->FSxMPDTAddUpdateSupplier($aDataWherePdt, $aDataWhereBarCode);
                } else {
                    $this->Product_model->FSxMPDTAutoAddBarCodeAndUnit($aDataWherePdt);
                }

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $aReturnData = array(
                        'nStaEvent'    => '500',
                        'tStaMessg'    => "Unsucess Add Even"
                    );
                } else {
                    $this->db->trans_commit();
                    if (isset($aPdtImg) && !empty($aPdtImg)) {
                        $aImageUplode = array(
                            'tModuleName'       => 'product',
                            'tImgFolder'        => 'product',
                            'tImgRefID'         => $aDataWherePdt['FTPdtCode'],
                            'tImgObj'           => $aPdtImg,
                            'tImgTable'         => 'TCNMPdt',
                            'tTableInsert'      => 'TCNMImgPdt',
                            'tImgKey'           => 'master',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 0,
                            'nStaImageMulti'    => 1
                        );
                        FCNnHAddImgObj($aImageUplode);
                    } else {
                        $aColorUplode = array(
                            'tModuleName'       => 'product',
                            'tImgFolder'        => 'product',
                            'tImgRefID'         => $aDataWherePdt['FTPdtCode'],
                            'tImgObj'           => $tCodeColor,
                            'tImgTable'         => 'TCNMPdt',
                            'tTableInsert'      => 'TCNMImgPdt',
                            'tImgKey'           => 'master',
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 0,
                            'nStaImageMulti'    => 1,
                            'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                            'FDCreateOn'        => date('Y-m-d H:i:s'),
                            'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                            'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                        );

                        $tResult = $this->Product_model->FSaMPDTAddUpdateImgObj($aColorUplode);
                    }
                    $aReturnData = array(
                        'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'    => $aDataWherePdt['FTPdtCode'],
                        'nStaEvent'        => '1',
                        'tStaMessg'        => 'Success Add Event',
                    );
                }
            } else {
                $aReturnData = array(
                    'nStaEvent' => '800',
                    'tStaMessg' => 'Data Product Is Duplicate'
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality: Function Edit Product Event
    //Parameters:  Ajax Send Event Post
    //Creator: 21/02/2018 Wasin(Yoshi)
    //LastModified: -
    //Return: Return object Status Event Edit
    //ReturnType: object
    public function FSoCPDTEditEvent()
    {
        try {
            // Get Lang ภาษา
            $nLangResort = $this->session->userdata("tLangID");
            $nLangEdit = $this->session->userdata("tLangEdit");
            $aPdtImg = $this->input->post('aPdtImg');
            $aPdtDataInfo1 = $this->input->post('aPdtDataInfo1');

            // เช็คโค้ดสี 
            if ($aPdtDataInfo1['tChecked'] == '0') {
                $tCodeColor = $aPdtDataInfo1['tPdtColor'];
            } else {
                $tCodeColor = $aPdtDataInfo1['tChecked'];
            }
            
            $aPdtDataInfo2 = $this->input->post('aPdtDataInfo2');
            $aPdtDataRental = $this->input->post('aPdtDataRental');
            $aDataWherePdt = array(
                // 'FNLngID' => $nLangEdit,
                'FTPdtCode' => $aPdtDataInfo1['tPdtCode']
            );

            $aDataWherePackSize = array(
                'FTMttTableKey' => 'TCNMPdt',
                'FTMttRefKey' => 'TCNMPdtPackSize',
                'FTMttSessionID' => $this->session->userdata("tSesSessionID")
            );

            $aDataWhereBarCode = array(
                'FTMttTableKey' => 'TCNMPdt',
                'FTMttRefKey' => 'TCNMPdtBar',
                'FTMttSessionID' => $this->session->userdata("tSesSessionID")
            );

            $aDataAddUpdateRental = array(
                'FTPdtCode' => $aPdtDataInfo1['tPdtCode'],
                'FTPdtRentType' => $aPdtDataRental['tRetPdtType'],
                'FTPdtStaReqRet' => $aPdtDataRental['tRetPdtSta'],
                'FCPdtDeposit' => ($aPdtDataRental['tRetPdtDeposit'] == "" ? 0 : $aPdtDataRental['tRetPdtDeposit']),
                'FTPdtStaPay' => $aPdtDataRental['tRetPdtStaPay'],
                'FTShpCode' => $aPdtDataRental['tRetPdtShpCode'],
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FTCreateBy' => $this->session->userdata('tSesUsername')
            );

            $aDataAddUpdatePdt  = array(
                // 'FTPdtStkCode' => $aPdtDataInfo1['tPdtStkCode'],
                'FTPdtStkControl' => $aPdtDataInfo1['nPdtStkControl'],
                'FTPdtForSystem' => $aPdtDataInfo2['tPdtForSystem'], //1
                'FCPdtQtyOrdBuy' => floatval(preg_replace("/[^-0-9\.]/", "", $aPdtDataInfo2['tPdtQtyOrdBuy'])),
                'FCPdtCostDef' => floatval(preg_replace("/[^-0-9\.]/", "", $aPdtDataInfo2['tPdtCostDef'])),
                'FCPdtCostOth' => floatval(preg_replace("/[^-0-9\.]/", "", $aPdtDataInfo2['tPdtCostOth'])),
                'FCPdtCostStd' => floatval(preg_replace("/[^-0-9\.]/", "", $aPdtDataInfo2['tPdtCostStd'])),
                'FCPdtMax' => floatval(preg_replace("/[^-0-9\.]/", "", $aPdtDataInfo2['tPdtMax'])),
                'FTPdtPoint' => $aPdtDataInfo1['nPdtStaPoint'],
                // 'FCPdtPointTime' => floatval(preg_replace("/[^-0-9\.]/","",$aPdtDataInfo2['tPdtPointTime'])),
                'FTPdtType' => $aPdtDataInfo1['tPdtType'],
                'FTPdtSaleType' => $aPdtDataInfo1['tPdtSaleType'],
                // 'FTPdtSetOrSN' => 1,
                'FTPdtStaAlwDis' => $aPdtDataInfo1['nPdtStaAlwDis'],
                'FTPdtStaAlwReturn' => $aPdtDataInfo1['nPdtStaAlwReturn'],
                'FTPdtStaVatBuy' => $aPdtDataInfo1['nPdtStaVatBuy'],
                'FTPdtStaVat' => $aPdtDataInfo1['nPdtStaVat'],
                'FTPdtStaActive' => $aPdtDataInfo1['nPdtStaActive'],
                'FTPdtStaAlwReCalOpt' => 1,
                'FTPdtStaCsm' => 1,
                // 'FTShpCode' => 1,
                // 'FTPdtRefShop' => $aPdtDataInfo2['tPdtMerCode'],
                'FTTcgCode' => $aPdtDataInfo2['tPdtTcgCode'],
                'FTPgpChain' => $aPdtDataInfo2['tPdtPgpChain'],
                'FTPtyCode' => $aPdtDataInfo2['tPdtPtyCode'],
                'FTPbnCode' => $aPdtDataInfo2['tPdtPbnCode'],
                'FTPmoCode' => $aPdtDataInfo2['tPdtPmoCode'],
                'FTCtyCode' => $aPdtDataInfo2['tPdtCyCode'],
                'FTVatCode' => $aPdtDataInfo1['tPdtVatCode'],
                'FDPdtSaleStart' => ($aPdtDataInfo2['tPdtSaleStart'] == '') ? NULL : $aPdtDataInfo2['tPdtSaleStart'],
                'FDPdtSaleStop' => ($aPdtDataInfo2['tPdtSaleStop'] == '') ? NULL : $aPdtDataInfo2['tPdtSaleStop'],
                // 'FTBchCode' => $aPdtDataInfo2['tPdtBchCode'],
                // 'FTBchCode' => $aPdtDataInfo2['tPdtBchCode'],
                'FTPdtRefID'    => $aPdtDataInfo1['tPdtRefID']
            );
            $aDataSpcBch = array(
                'FTPdtCode' => $aPdtDataInfo1['tPdtCode'],
                'FTAgnCode' => $aPdtDataInfo2['tPdtAgnCode'],
                'FTBchCode' => $aPdtDataInfo2['tPdtBchCode'],
                'FTMerCode' => $aPdtDataInfo2['tPdtMerCode'],
                'FTShpCode' => $aPdtDataInfo2['tPdtShpCode'],
                'FTMgpCode' => $aPdtDataInfo2['tPdtMgpCode'],
                'FCPdtMin' => floatval(preg_replace("/[^-0-9\.]/", "", $aPdtDataInfo2['tPdtMin']))
            );

            $aDataWhereLangPdt = array(
                'FNLngID' => $nLangEdit,
                'FTPdtCode' => $aPdtDataInfo1['tPdtCode']
            );
            $aDataLangPdt = array(
                'FTPdtName' => $aPdtDataInfo1['tPdtName'],
                'FTPdtNameOth' => $aPdtDataInfo1['tPdtNameOth'],
                'FTPdtNameABB' => $aPdtDataInfo1['tPdtNameABB'],
                'FTPdtRmk' => $aPdtDataInfo2['tPdtRmk']
            );

            $aLangList = FCNaGetLngListByCty();
            $aPdtList  = array();
            parse_str($this->input->post('aPdtInputTab'), $aPdtListForm);
            // $tCtyCode     = $this->Product_model->FSaMPDTGetCtyByID($aPdtListForm['ohdCreateCode']);
            $tCtyCode = ($aPdtDataInfo2['tPdtCyCode']) ? $aPdtDataInfo2['tPdtCyCode'] : 'THA';
            $aPdtNameList = $this->Product_model->FSaMPDTGetListByID($aPdtDataInfo1['tPdtCode'],$tCtyCode);
            foreach($aPdtNameList AS $Lng){
                $aPdtList[$Lng['FTLngShortName']] = array(
                    'FTPdtName'      => $aPdtListForm[($Lng['FTLngShortName'] == $tCtyCode) ? 'oetPdtName' : 'oetPdtName'.$Lng['FTLngShortName']],
                    'FNLngID'        => $aPdtListForm[($Lng['FTLngShortName'] == $tCtyCode) ? 'ohdPdtLngID' : 'ohdPdtLngID'.$Lng['FTLngShortName']],
                    'FTPdtNameOth'   => $aPdtListForm[($Lng['FTLngShortName'] == $tCtyCode) ? 'oetPdtNameOth' : 'oetPdtNameOth'.$Lng['FTLngShortName']],
                    'FTPdtNameABB'   => $aPdtListForm[($Lng['FTLngShortName'] == $tCtyCode) ? 'oetPdtNameABB' : 'oetPdtNameABB'.$Lng['FTLngShortName']],
                    'FTPdtRmk'       => $aPdtDataInfo2['tPdtRmk']
                );
            }
            // print_r($tCtyCode);
            // print_r($aPdtNameList);
            // print_r($aPdtList);
            $this->db->trans_begin();

            $this->Product_model->FSaMPDTAddUpdateMaster($aDataWherePdt, $aDataAddUpdatePdt);
            $this->Product_model->FSaMPDTAddUpdateLang($aDataWhereLangPdt, $aPdtList);
            $this->Product_model->FSxMPDTAddUpdatePackSize($aDataWherePdt, $aDataWherePackSize);
            $this->Product_model->FSxMPDTAddUpdateBarCode($aDataWherePdt, $aDataWhereBarCode);
            $this->Product_model->FSxMPDTAddUpdateSupplier($aDataWherePdt, $aDataWhereBarCode);

            // บันทึกกำหนดเงื่อนไขการควบคุมสต๊อก
            $this->Product_model->FSaMPDTStockConditionsAddEdit($aPdtDataInfo1['tPdtCode']);

            if ($aDataSpcBch['FTAgnCode'] != "" || $aDataSpcBch['FTBchCode'] != "" || $aDataSpcBch['FTMerCode'] != "" || $aDataSpcBch['FTShpCode'] != "" || $aDataSpcBch['FTMgpCode'] != "" || $aDataSpcBch['FCPdtMin'] != "") {
                $this->Product_model->FSxMPDTAddUpdateSpcBch($aDataSpcBch);
            }

            if ($aDataAddUpdatePdt['FTPdtForSystem'] == '4') {
                $this->Product_model->FSxMPDTAddUpdateRental($aDataAddUpdateRental);
            }

            // $this->Product_model->FSxMPDTAddUpdatePdtSet($aDataWherePdt,$aPdtDataAllSet);
            // $this->Product_model->FSxMPDTAddUpdatePdtEvnNosale($aDataWherePdt,$tPdtEvnNotSale);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => "Unsucess Add Even"
                );
            } else {
                $this->db->trans_commit();
                if ($aPdtDataInfo1['tPdtColor'] == "#000000" && $aPdtDataInfo1['tChecked'] == "0") {

                    if (isset($aPdtImg) && !empty($aPdtImg)) {
                        $aImageUplode = array(
                            'tModuleName' => 'product',
                            'tImgFolder' => 'product',
                            'tImgRefID' => $aDataWherePdt['FTPdtCode'],
                            'tImgObj' => $aPdtImg,
                            'tImgTable' => 'TCNMPdt',
                            'tTableInsert' => 'TCNMImgPdt',
                            'tImgKey' => 'master',
                            'dDateTimeOn' => date('Y-m-d H:i:s'),
                            'tWhoBy' => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 0,
                            'nStaImageMulti' => 1
                        );
                        FCNnHAddImgObj($aImageUplode);
                    }
                } else {
                    $aColorUplode = array(
                        'tModuleName' => 'product',
                        'tImgFolder' => 'product',
                        'tImgRefID' => $aDataWherePdt['FTPdtCode'],
                        'tImgObj' => $tCodeColor,
                        'tImgTable' => 'TCNMPdt',
                        'tTableInsert' => 'TCNMImgPdt',
                        'tImgKey' => 'master',
                        'tWhoBy' => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 0,
                        'nStaImageMulti' => 1,
                        'FDLastUpdOn' => date('Y-m-d H:i:s'),
                        'FDCreateOn' => date('Y-m-d H:i:s'),
                        'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                        'FTCreateBy' => $this->session->userdata('tSesUsername'),
                    );
                    $this->Product_model->FSaMPDTAddUpdateImgObj($aColorUplode);
                }
                $aReturnData = array(
                    'nStaCallBack' => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn' => $aDataWherePdt['FTPdtCode'],
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success Add Event'
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality: Function Delete All Product Event
    //Parameters:  Ajax Send Event Post
    //Creator: 25/02/2018 Wasin(Yoshi)
    //update : 18/09/2019 Saharat(Golf)
    //LastModified: -
    //Return: Return object Status Event Delete
    //ReturnType: object
    public function FSoCPDTDeleteEvent()
    {
        $tIDCode = $this->input->post('tIDCode');
        $tPdtForSystem = $this->input->post('tPdtForSystem');
        $aDataDel = array(
            'FTPdtCode' => $tIDCode,
            'tPdtForSystem' => $tPdtForSystem
        );
        $aResDel = $this->Product_model->FSaMPdtDeleteAll($aDataDel);
        $nNumRow = $this->Product_model->FSnMPdtGetAllNumRow($aDataDel);
        if ($aResDel['rtCode'] == 1) {
            $aDeleteImage = array(
                'tModuleName' => 'product',
                'tImgFolder' => 'product',
                'tImgRefID' => $tIDCode,
                'tTableDel' => 'TCNMImgPdt',
                'tImgTable' => 'TCNMPdt'
            );
            $nStaDelImgInDB = FSnHDelectImageInDB($aDeleteImage);
            if ($nStaDelImgInDB == 1) {
                FSnHDeleteImageFiles($aDeleteImage);
            }
            if ($nNumRow !== false) {
                $aReturn = array(
                    'nStaEvent' => $aResDel['rtCode'],
                    'tStaMessg' => $aResDel['rtDesc'],
                    'nNumRow' => $nNumRow['rtCountData']
                );
                echo json_encode($aReturn);
            } else {
                echo "database error!";
            }
        }
    }


    public function FSoCPDTBarCodeDataTable()
    {
        $aData = array(
            'FTMttTableKey' => 'TCNMPdt',
            'FTMttRefKey' => 'TCNMPdtBar',
            'FTPdtCode' => $this->input->post('ptPdtCode'),
            'FTPunCode' => $this->input->post('ptPunCode'),
            'FTMttSessionID' => $this->session->userdata("tSesSessionID")
        );

        $aDataPdtBarCode = $this->Product_model->FSaMPDTGetDataTableBarCodeByID($aData);
        $this->load->view('product/product/wProductBarCdoeDataTable', $aDataPdtBarCode);
    }

    /**
     * Functionality : เพิ่ม แก้ไข รายการ barcode ใน temp.
     * Parameters : -
     * Creator : 13/04/2020 surawat
     * Last Modified : 13/04/2020 surawat
     * Return : สถานะการเพิ่มหรือแก้ไข
     * Return Type : array
     */
    public function FSoCPDTUpdateBarCode()
    {
        $aPdtDataPackSize = array(
            'FTMttTableKey'     => 'TCNMPdt',
            'FTMttRefKey'       => 'TCNMPdtBar',
            'FTPdtCode'         => $this->input->post('FTPdtCode'),
            'FTBarCode'         => $this->input->post('FTBarCode'),
            'tOldBarCode'       => $this->input->post('tOldBarCode'),
            'FTPunCode'         => $this->input->post('FTPunCode'),
            'FTPlcCode'         => $this->input->post('FTPlcCode'),
            'FTPlcName'         => $this->input->post('FTPlcName'),
            'FTSplCode'         => $this->input->post('FTSplCode'),
            'FTSplName'         => $this->input->post('FTSplName'),
            'FTBarStaUse'       => $this->input->post('FTBarStaUse'),
            'FTBarStaAlwSale'   => $this->input->post('FTBarStaAlwSale'),
            'FTSplStaAlwPO'     => $this->input->post('FTSplStaAlwPO'),
            'FTMttSessionID'    => $this->session->userdata("tSesSessionID"),
            'tCheckStatus'      => $this->input->post('StatusAddEdit')
        );
        if ($aPdtDataPackSize['tCheckStatus'] == "0") { // เพิ่มบาร์โค๊ดใหม่
            $CheckBarCodeByID = $this->Product_model->FSaMPDTCheckBarCodeByID($aPdtDataPackSize);
            if ($CheckBarCodeByID['rtCode']  == "800") { // ไม่พบบาร์โค๊ดใน Temp
                $this->Product_model->FSxMPDTAddUpdateBarCodeByID($aPdtDataPackSize);
                $aReturn = array(
                    'nStaQuery' => 1,
                    'tStaMessg' => 'Success',
                );
            } else { // พบบาร์โค๊ดใน Temp
                $aReturn = array(
                    'nStaQuery' => 99,
                    'tStaMessg' => 'Error',
                );
            }
        } else { // แก้ไขบาร์โค๊ด
            if ($aPdtDataPackSize['FTBarCode'] == $aPdtDataPackSize['tOldBarCode']) { // บาร์โค้ดไม่มีการแก้ไข
                $CheckBarOldCodeByID = $this->Product_model->FSaMPDTCheckBarOldCodeByID($aPdtDataPackSize);
                if ($CheckBarOldCodeByID['rtCode']  == '1') { // พบบาร์โค๊ดเดิมใน Temp
                    $this->Product_model->FSxMPDTDeleteBarCode($aPdtDataPackSize);
                    $this->Product_model->FSxMPDTAddUpdateBarCodeByID($aPdtDataPackSize);
                    $aReturn = array(
                        'nStaQuery' => 1,
                        'tStaMessg' => 'Success'
                    );
                } else { // ไม่พบบาร์โค๊ดเดิมใน Temp
                    $aReturn = array(
                        'nStaQuery' => 99,
                        'tStaMessg' => 'Error'
                    );
                }
            } else { // บาร์โค๊ดมีการแก้ไข
                $CheckBarOldCodeByID = $this->Product_model->FSaMPDTCheckBarOldCodeByID($aPdtDataPackSize);
                // ถ้ามีการแก้ไขรหัสบาร์โค้ให้เช็ครหัสซ้ำ
                if ($CheckBarOldCodeByID['rtCode'] == "800") { // ไม่มีรายการ bar code เดิม แล้วมัน edit มาได้ยังไง? แปลว่า error
                    $aReturn = array(
                        'nStaQuery' => 99,
                        'tStaMessg' => 'Error'
                    );
                } else {
                    // ตรวจสอบว่า barcode ใหม่ที่จะใช้มันไปซ้ำกับใครไหม
                    $CheckBarCodeByID = $this->Product_model->FSaMPDTCheckBarCodeByID($aPdtDataPackSize);
                    if ($CheckBarCodeByID['rtCode']  == "800") { // bar code ใหม่ ไม่ซ้ำกับใคร
                        $this->Product_model->FSxMPDTDeleteBarCode($aPdtDataPackSize);
                        $this->Product_model->FSxMPDTAddUpdateBarCodeByID($aPdtDataPackSize);
                        $aReturn = array(
                            'nStaQuery' => 1,
                            'tStaMessg' => 'Success',
                        );
                    } else {
                        $aReturn = array(
                            'nStaQuery' => 99,
                            'tStaMessg' => 'Error'
                        );
                    }
                }
            }
        }
        echo json_encode($aReturn);
    }

    public function FSoCPDTDeleteBarCode()
    {
        $aPdtBarCode = array(
            'FTMttTableKey' => 'TCNMPdt',
            'FTMttRefKey' => 'TCNMPdtBar',
            'FTPdtCode' => $this->input->post('FTPdtCode'),
            'FTPunCode' => $this->input->post('FTPunCode'),
            'FTBarCode' => $this->input->post('FTBarCode'),
            'FTMttSessionID' => $this->session->userdata("tSesSessionID")
        );
        $this->Product_model->FSxMPDTDeleteBarCode($aPdtBarCode);

        // $aData = array(
        //     'FTMttTableKey'     => 'TCNMPdt',
        //     'FTMttRefKey'       => 'TCNMPdtBar',
        //     'FTPdtCode'         => $this->input->post('FTPdtCode'),
        //     'FTPunCode'         => $this->input->post('FTPunCode'),
        //     'FTMttSessionID'    => $this->session->userdata("tSesSessionID")
        // );
        // $aDataPdtBarCode        = $this->Product_model->FSaMPDTGetDataTableBarCodeByID($aData);
        // $this->load->view('product/product/wProductBarCdoeDataTable',$aDataPdtBarCode);
    }

    public function FSoCPDTPackSizeAdd()
    {
        $FTPdtCode = $this->input->post('FTPdtCode');
        $aPunCode = $this->input->post('aPunCode');
        $aDataUnitFact = $this->input->post('paDataUnitFact');
        $aDataUnit = count($aDataUnitFact);
        $aDataUnitCount = trim($aDataUnit);

        if ($aDataUnitCount > 0) {
            $tUnitFact = max($aDataUnitFact) + 1;
        } else {
            $tUnitFact = 1;
        }

        for ($i = 0; $i < count($aPunCode); $i++) {
            $aPun = json_decode($aPunCode[$i]);
            $aDataWhere = array(
                'FTMttTableKey' => 'TCNMPdt',
                'FTMttRefKey' => 'TCNMPdtPackSize',
                'FTPdtCode' => $FTPdtCode,
                'FTPunCode' => $aPun[0],
                'FTPunName' => $aPun[1],
                'FCPdtUnitFact' => $tUnitFact,
                'FCPdtWeight' => '0',
                'FTMttSessionID' => $this->session->userdata("tSesSessionID"),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FTCreateBy' => $this->session->userdata('tSesUsername')
            );
            $tChkDup = $this->Product_model->FSaMPDTCheckMasTempDuplicate($aDataWhere);
            if ($tChkDup['rtCode'] == '800') {
                // Insert into PackSize Temp
                $this->Product_model->FSaMPDTAddPackSizeByIDMasTemp($aDataWhere);
            }
        }
    }

    public function FSoCPDTPackSizeUpdate()
    {
        $aDataWhere  = array(
            'FTMttTableKey' => 'TCNMPdt',
            'FTMttRefKey' => 'TCNMPdtPackSize',
            'FTPdtCode' => $this->input->post('FTPdtCode'),
            'FTPunCode' => $this->input->post('FTPunCode'),
            'FTMttSessionID' => $this->session->userdata("tSesSessionID")
        );

        $nUpdateType = $this->input->post('pnUpdateType');
        if ($nUpdateType == 1) {
            $aDataUpdate = array(
                'FCPdtUnitFact' => $this->input->post('FCPdtUnitFact'),
                'FTPdtGrade' => $this->input->post('FTPdtGrade'),
                'FCPdtWeight' => $this->input->post('FCPdtWeight'),
                'FTClrCode' => $this->input->post('FTClrCode'),
                'FTClrName' => $this->input->post('FTClrName'),
                'FTPszCode' => $this->input->post('FTPszCode'),
                'FTPszName' => $this->input->post('FTPszName'),
                'FTPdtUnitDim' => $this->input->post('FTPdtUnitDim'),
                'FTPdtPkgDim' => $this->input->post('FTPdtPkgDim'),
                'FTPdtStaAlwPick' => $this->input->post('FTPdtStaAlwPick'),
                'FTPdtStaAlwPoHQ' => $this->input->post('FTPdtStaAlwPoHQ'),
                'FTPdtStaAlwBuy' => $this->input->post('FTPdtStaAlwBuy'),
                'FTPdtStaAlwSale' => $this->input->post('FTPdtStaAlwSale'),
            );
        } else {
            $aDataUpdate = array(
                'FCPdtUnitFact' => $this->input->post('FCPdtUnitFact')
            );
        }

        $aUpdPackSize = $this->Product_model->FSaMPDTUpdatePackSizeByIDMasTemp($aDataWhere, $aDataUpdate);
        echo json_encode($aUpdPackSize);
    }

    public function FSaCPDTSETCallDataTable()
    {
        try {
            $aDataSearch = array(
                // 'FTMttTableKey' => 'TCNMPdt',
                // 'FTMttRefKey' => 'TCNTPdtSet',
                // 'FTMttSessionID' => $this->session->userdata("tSesSessionID"),
                'FTPdtCode' => $this->input->post('oetPdtCode'),
                'FNLngID' => $this->session->userdata("tLangEdit")
            );
            $aDataOthPdt = $this->Product_model->FSaMPDTGetOthPdt();
            $aDataPdtSet = $this->Product_model->FSaMPDTGetDataPdtSet($aDataSearch);

            $aDataReturn = array(
                'aDataOthPdt' => $aDataOthPdt,
                'aDataPdtSet' => $aDataPdtSet,
                'tHTML' => $this->load->view('product/product/wProductSetDataTable', $aDataPdtSet, true),
                'nStaEvent' => 1,
                'tStaMessg' => 'Success'
            );
        } catch (Exception $Error) {
            $aDataReturn = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataReturn);
    }

    public function FSaCPDTSETCallPageAdd()
    {
        try {
            $aDataReturn = array(
                'tHTML' => $this->load->view('product/product/wProductSetAdd', '', true),
                'nStaEvent' => 1,
                'tStaMessg' => 'Success'
            );
        } catch (Exception $Error) {
            $aDataReturn = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataReturn);
    }

    public function FSaCPDTSETEventAdd()
    {
        try {
            $aPdtSetWhere = array(
                'FTPdtCode' => $this->input->post('oetPdtCode'),
                'FTPdtCodeSet' => $this->input->post('oetPdtSetPdtCode')
            );
            $aDataPdtSetAdd = array(
                'FCPstQty' => $this->input->post('oetPdtSetPstQty')
            );
            $aAddPdtSet = $this->Product_model->FSaMPDTUpdPdtSet($aDataPdtSetAdd, $aPdtSetWhere);
            $this->Product_model->FSaMPDTUpdPdtStaSet($aPdtSetWhere);
            $aDataReturn = array(
                'nStaEvent' => $aAddPdtSet['tCode'],
                'tStaMessg' => $aAddPdtSet['tDesc']
            );
        } catch (Exception $Error) {
            $aDataReturn = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataReturn);
    }

    public function FSaCPDTSETCallPageEdit()
    {
        try {
            $aDataWhere = array(
                'FTPdtCode'         => $this->input->post('ptPdtCode'),
                'FTPdtCodeSet'      => $this->input->post('ptPdtCodeSet'),
                'FNLngID'           => $this->session->userdata("tLangEdit")
            );
            $aDataPdtSet = $this->Product_model->FSaMPDTGetDataPdtSetByID($aDataWhere);

            $aDataReturn = array(
                'tHTML'     => $this->load->view('product/product/wProductSetAdd', $aDataPdtSet, true),
                'nStaEvent' => 1,
                'tStaMessg' => 'Success'
            );
        } catch (Exception $Error) {
            $aDataReturn = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataReturn);
    }

    public function FSaCPDTSETEventDelete()
    {
        try {
            $aDataDel = array(
                'FTPdtCode'         => $this->input->post('ptPdtCode'),
                'FTPdtCodeSet'      => $this->input->post('ptPdtCodeSet')
            );
            $aDataPdtSet = $this->Product_model->FSaMPDTDelPdtSet($aDataDel);
            $this->Product_model->FSaMPDTUpdPdtStaSet($aDataDel);
            $aDataReturn = array(
                'nStaEvent' => $aDataPdtSet['tCode'],
                'tStaMessg' => $aDataPdtSet['tDesc']
            );
        } catch (Exception $Error) {
            $aDataReturn = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataReturn);
    }

    public function FSaCPDTSETUpdateStaSetPri()
    {
        try {
            $aDataWhere = array(
                'FTPdtCode'         => $this->input->post('ptPdtCode')
            );
            $aDataUpd = array(
                'FTPdtStaSetPri'    => $this->input->post('ptPdtStaSetPri')
            );
            $aDataPdtSetPri = $this->Product_model->FSaMPDTUpdPdtSetPri($aDataUpd, $aDataWhere);
            $aDataReturn = array(
                'nStaEvent' => $aDataPdtSetPri['tCode'],
                'tStaMessg' => $aDataPdtSetPri['tDesc']
            );
        } catch (Exception $Error) {
            $aDataReturn = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataReturn);
    }

    public function FSaCPDTSETUpdateStaSetShwDT()
    {
        try {
            $aDataWhere = array(
                'FTPdtCode'         => $this->input->post('ptPdtCode')
            );
            $aDataUpd = array(
                'FTPdtStaSetShwDT'    => $this->input->post('ptPdtStaSetShwDT')
            );
            $aDataPdtStaSetShwDT = $this->Product_model->FSaMPDTUpdPdtStaSetShwDT($aDataUpd, $aDataWhere);
            $aDataReturn = array(
                'nStaEvent' => $aDataPdtStaSetShwDT['tCode'],
                'tStaMessg' => $aDataPdtStaSetShwDT['tDesc']
            );
        } catch (Exception $Error) {
            $aDataReturn = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataReturn);
    }

    /*
    // Functionality :Call Viwe กำหนดเงื่อนไขการควบคุมสต๊อก
    // Parameters : 
    // Creator : 23/01/2020 Saharat(Golf)
    // Last Modified : -
    // Return : String View
    // Return Type : View
    */
    public function FSvCPDTCallPageStockConditions()
    {
        $aDataList = array(
            'FTPdtCode'         => $this->input->post('ptPdtCode'),
            'FTMttSessionID'    => $this->session->userdata("tSesSessionID"),
            'FNLngID'           => $this->session->userdata("tLangID"),
            'FTMttTableKey'     => 'TCNMPdtSpcWah',
            'nPage'             => 1,
            'nRow'              => 10,
        );
        $aResultData  = $this->Product_model->FSaMPDTStockConditionsList($aDataList);
        $this->load->view('product/product/wProductStockConditions', $aResultData);
    }

    /*
    // Functionality : ดึงข้อมูลไป แก้ไข
    // Parameters : 
    // Creator : 23/01/2020 Saharat(Golf)
    // Last Modified : -
    // Return : array
    // Return Type : array
    */
    public function FSvCPDTCStockConditionsGetDataById()
    {
        $aDataGet = array(
            'FTPdtCode'           => $this->input->post('ptPdtCode'),
            'FTBchCode'           => $this->input->post('ptBchCode'),
            'FTWahCode'           => $this->input->post('ptWahCode'),
            'FNLngID'             => $this->session->userdata("tLangID"),
        );

        $aResultData  = $this->Product_model->FSaMPDTStockConditionsGetDataByID($aDataGet);
        echo json_encode($aResultData);
    }

    //Functionality: เพิ่มข้อมูล StockConditions
    //Parameters:  พารามิเตอร์ จาก jProductAdd
    //Creator: 23/01/2020 Saharat(GolF)
    //LastModified: -
    //Return: Return JSON
    //ReturnType: JSON
    public function FSaCPDTStockConditionsEventAdd()
    {
        try {
            $aDataStockConditions  = array(
                'FTMttTableKey'         => 'TCNMPdtSpcWah',
                'FTBchCodeOld'          => $this->input->post('oetStockConditionBchCode'),
                'FTWahCodeOld'          => $this->input->post('oetStockConditionWahCode'),
                'FTPdtCode'             => $this->input->post('oetStockConditionPdtCode'),
                'FTBchCode'             => $this->input->post('oetStockConditionBchCode'),
                'FTWahCode'             => $this->input->post('oetStockConditionWahCode'),
                'FCSpwQtyMin'           => $this->input->post('oetStockConditionsMin'),
                'FCSpwQtyMax'           => $this->input->post('oetStockConditionsMax'),
                'FTSpwRmk'              => $this->input->post('oetStockConditionsRemark'),
                'FTMttSessionID'        => $this->session->userdata("tSesSessionID"),
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername')
            );
            $aResultData = $this->Product_model->FSaMPDTStockConditionsCheckBchWah($aDataStockConditions);
            if ($aResultData === 0) {
                $aResult = $this->Product_model->FSaMPDTStockConditionsAddEditTemp($aDataStockConditions);
            } else {
                $aResult = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master',
                );
            }
        } catch (Exception $Error) {
            $aResult = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aResult);
    }

    //Functionality: เพิ่มข้อมูล StockConditions
    //Parameters:  พารามิเตอร์ จาก jProductAdd
    //Creator: 23/01/2020 Saharat(GolF)
    //LastModified: -
    //Return: Return JSON
    //ReturnType: JSON
    public function FSaCPDTStockConditionsEventEdit()
    {
        try {
            $aData  = array(
                'FTMttTableKey'         => 'TCNMPdtSpcWah',
                'FTBchCodeOld'          => $this->input->post('oetStockConditionBchCodeOld'),
                'FTWahCodeOld'          => $this->input->post('oetStockConditionWahCodeOld'),
                'FTPdtCode'             => $this->input->post('oetStockConditionPdtCode'),
                'FTBchCode'             => $this->input->post('oetStockConditionBchCode'),
                'FTWahCode'             => $this->input->post('oetStockConditionWahCode'),
                'FCSpwQtyMin'           => $this->input->post('oetStockConditionsMin'),
                'FCSpwQtyMax'           => $this->input->post('oetStockConditionsMax'),
                'FTSpwRmk'              => $this->input->post('oetStockConditionsRemark'),
                'FTMttSessionID'        => $this->session->userdata("tSesSessionID"),
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername')
            );

            if ($aData['FTBchCode'] == $aData['FTBchCodeOld'] && $aData['FTWahCode'] == $aData['FTWahCodeOld']) {
                $aResult = $this->Product_model->FSaMPDTStockConditionsAddEditTemp($aData);
            } else {
                $aResultCheckBchWah = $this->Product_model->FSaMPDTStockConditionsCheckBchWah($aData);
                if ($aResultCheckBchWah == 0) {
                    $aResult = $this->Product_model->FSaMPDTStockConditionsAddEditTemp($aData);
                } else {
                    $aResult = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master',
                    );
                }
            }
        } catch (Exception $Error) {
            $aResult = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aResult);
    }

    //Functionality : Event Delete Agency
    //Parameters : Ajax jReason()
    //Creator : 11/06/2019 saharat(Golf)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCPDTStockConditionsDeleteEvent()
    {
        $aDataDel = array(
            'FTPdtCode' => $this->input->post('ptPdtCode'),
            'FTBchCode' => $this->input->post('ptBchCode'),
            'FTWahCode' => $this->input->post('ptWahCode'),
        );
        $aResDel        = $this->Product_model->FSaMPDTStockConditionsDel($aDataDel);
        if ($aResDel) {
            $aReturn    = array(
                'nStaEvent'  => $aResDel['rtCode'],
                'tStaMessg'  => $aResDel['rtDesc'],
            );
            echo json_encode($aReturn);
        } else {
            echo "database error!";
        }
    }

    public function FSaCPDTCheckTabPdt()
    {
        $aData = array(
            'tPdtCode'  => $this->input->post('ptPdtCode'),
            'nLngCty'   => $this->input->post('pnLngCty')
        );
        $aResultLang  = $this->Product_model->FSaMPDTGetTabPdt($aData);
        if ($aResultLang) {
            $aReturn    = array(
                'nStaEvent'  => '1',
                'tStaMsg'    => 'success',
                'aResult'    => $aResultLang,
            );
        } else {
            $aReturn    = array(
                'nStaEvent'  => '0',
                'tStaMsg'    => 'error',
            );
        }
        echo json_encode($aReturn);
    }
}
