<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Merchant_controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('merchant/merchant/Merchant_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nMerchantType, $tMerchantOption)
    {
        $vBtnSave           = FCNaHBtnSaveActiveHTML('merchant/0/0');
        $aAlwEventMerchant    = FCNaHCheckAlwFunc('merchant/0/0');
        $this->load->view('merchant/merchant/wMerchant', array(
            'vBtnSave'          => $vBtnSave,
            'nMerchantType'     => $nMerchantType,
            'tMerchantOption'   => $tMerchantOption,
            'aAlwEventMerchant' => $aAlwEventMerchant
        ));
    }

    //Functionality : Function Call Merchant Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 10/06/2019 Sarun
    //Return : String View
    //Return Type : View
    public function FSvCMerchantListPage()
    {
        $aAlwEventMerchant        = FCNaHCheckAlwFunc('merchant/0/0');
        $this->load->view('merchant/merchant/wMerchantList', array(
            'aAlwEventMerchant'    => $aAlwEventMerchant,
        ));
    }

    //Functionality : Function Call DataTables SupplierLevel
    //Parameters : Ajax Call View DataTable
    //Creator : 09/10/2018 witsarut
    //Return : String View
    //Return Type : View
    public function FSvCMerchantDataList()
    {
        try {
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null) ? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangEdit      = $this->session->userdata("tLangEdit");

            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll
            );

            $aMerchantDataList      = $this->Merchant_model->FSaMMerchantList($aData);
            $aAlwEventMerchant        = FCNaHCheckAlwFunc('merchant/0/0');
            $aGenTable  = array(
                'aDataList'                 => $aMerchantDataList,
                'nPage'                     => $nPage,
                'tSearchAll'                => $tSearchAll,
                'aAlwEventMerchant'         => $aAlwEventMerchant
            );
            $this->load->view('merchant/merchant/wMerchantDataTable', $aGenTable);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Function CallPage SupplierLevel Add
    //Parameters : Ajax Call View Add
    //Creator : 09/10/2018 witsarut
    //Return : String View
    //Return Type : View
    public function FSvCMerchantAddPage()
    {

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'FNLngID'   => $nLangEdit,
        );
        $aDataAdd = array(
            'aResult'       => array('rtCode' => '99'),
            'nStaAddOrEdit' => 99
        );
        $this->load->view('merchant/merchant/wMerchantAdd', $aDataAdd);
    }

    //Functionality : Function CallPage SupplierLevel Edits
    //Parameters : Ajax Call View Add
    //Creator : 09/10/2018 witsarut
    //Return : String View
    //Return Type : View
    public function FSvCSLVEditPage()
    {
        try {
            $tSlvCode       = $this->input->post('tSlvCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aData  = array(
                'FTSlvCode' => $tSlvCode,
                'FNLngID'   => $nLangEdit
            );

            $aSlvData            = $this->Supplierlev_model->FSaMSLVGetDataByID($aData);
            $aDataSupplierLevel  = array(
                'nStaAddOrEdit' => 1,
                'aSlvData'      => $aSlvData
            );
            $this->load->view('supplier/supplierlev/wSupplierLevAdd', $aDataSupplierLevel);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Event Add Merchant
    //Parameters : Ajax Event
    //Creator : 11/06/2019 Sarun
    //Update : 17/03/2020 Saharat(Golf)
    //Return : Status Add Event
    //Return Type : String
    public function FSaMCNAddEvent()
    {
        try {

            $tImgInputMerchantOld = $this->input->post('oetImgInputMerchantOld');
            $tImgInputMerchant = $this->input->post('oetImgInputMerchant');

            $aDataMaster = array(
                'tIsAutoGenCode'        => $this->input->post('ocbMerchantAutoGenCode'),
                'FTMcnCode'             => $this->input->post('oetMcnCode'),
                'FTPplCode'             => $this->input->post('oetMerPriceGroupCode'),
                'FTMcnName'             => $this->input->post('oetMcnName'),
                'FTMerRefCode'          => $this->input->post('oetRefMerCode'),
                'FTMcnEmail'            => $this->input->post('oetMcnEmail'),
                'FTMcnTel'              => $this->input->post('oetMcnTel'),
                'FTMcnFax'              => $this->input->post('oetMcnFax'),
                'FTMcnMo'               => $this->input->post('oetMcnMo'),
                'FTMcnRmk'              => $this->input->post('otaMcnRemark'),
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FNLngID'               => $this->session->userdata("tLangEdit"),
            );

            if ($aDataMaster['tIsAutoGenCode'] == '1') { 
                $aStoreParam = array(
                    "tTblName"   => 'TCNMMerchant',                           
                    "tDocType"   => 0,                                          
                    "tBchCode"   => "",                                 
                    "tShpCode"   => "",                               
                    "tPosCode"   => "",                     
                    "dDocDate"   => date("Y-m-d")       
                );
                $aAutogen   		        = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTMcnCode']   = $aAutogen[0]["FTXxhDocNo"];
            }
            $oCountDup  = $this->Merchant_model->FSoMMCNCheckDuplicate($aDataMaster['FTMcnCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if ($nStaDup == 0) {

                $this->db->trans_begin();

                $this->Merchant_model->FSaMMCNAddUpdateMaster($aDataMaster);
                $this->Merchant_model->FSaMMCNAddUpdateLang($aDataMaster);

                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                } else {
                    $this->db->trans_commit();
                    if ($tImgInputMerchant != $tImgInputMerchantOld) {
                        $aImageUplode = array(
                            'tModuleName'       => 'merchant',
                            'tImgFolder'        => 'merchant',
                            'tImgRefID'         => $aDataMaster['FTMcnCode'],
                            'tImgObj'           => $tImgInputMerchant,
                            'tImgTable'         => 'TCNMMerchant',
                            'tTableInsert'      => 'TCNMImgObj',
                            'tImgKey'           => 'main',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1
                        );
                        FCNnHAddImgObj($aImageUplode);
                    }
                    $aReturn = array(
                        'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'    => $aDataMaster['FTMcnCode'],
                        'nStaEvent'        => '1',
                        'tStaMessg'        => 'Success Add Event'
                    );
                }
            } else {
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => "Data Code Duplicate"
                );
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Event Edit SupplierLevel
    //Parameters : Ajax Event
    //Creator : 09/10/2018 witsarut
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCSLVEditEvent()
    {
        try {
            $this->db->trans_begin();
            $aDataSupplierLevel   = array(
                'FTSlvCode'     => $this->input->post('oetSlvCode'),
                'FTSlvName'     => $this->input->post('oetSlvName'),
                'FTSlvRmk'      => $this->input->post('otaSlvRmk'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );
            $aStaSlvMaster  = $this->Supplierlev_model->FSaMSLVAddUpdateMaster($aDataSupplierLevel);
            $aStaSlvLang    = $this->Supplierlev_model->FSaMSLVAddUpdateLang($aDataSupplierLevel);
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit SupplierLevel"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'    => $aDataSupplierLevel['FTSlvCode'],
                    'nStaEvent'        => '1',
                    'tStaMessg'        => 'Success Edit SupplierLevel'
                );
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Event Delete SupplierLevel
    //Parameters : Ajax jReason()
    //Creator : 09/10/2018 witsarut
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCSLVDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTSlvCode' => $tIDCode
        );
        $aResDel    = $this->Supplierlev_model->FSaMSLVDelAll($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    //Functionality : Function Call Edit Page Merchant
    //Parameters : Ajax jReason()
    //Creator : 11/06/2019 Sarun
    //update : 17/03/2020 Saharat(Golf)
    //Return : String View
    //Return Type : View
    public function FSvMCNEditPage(){
        $tMcnCode       = $this->input->post('tMcnCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'FTMcnCode' => $tMcnCode,
            'FNLngID'   => $nLangEdit
        );

        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aResult       = $this->Merchant_model->FSaMMCNSearchByID($tAPIReq, $tMethodReq, $aData);
        if (isset($aResult['raItems']['rtImgObj']) && !empty($aResult['raItems']['rtImgObj'])) {
            $tImgObj        = $aResult['raItems']['rtImgObj'];
            $aImgObj        = explode("application/modules/", $tImgObj);
            $aImgObjName    = explode("/", $tImgObj);
            $tImgObjAll     = $aImgObj[1];
            $tImgName        = end($aImgObjName);
        } else {
            $tImgObjAll = "";
            $tImgName    = "";
        }

        $aDataEdit = array(
            'aResult'       => $aResult,
            'tImgName'      => $tImgName,
            'tImgObjAll'    => $tImgObjAll,
            'nStaAddOrEdit' => 1
        );
        $this->load->view('Merchant/Merchant/wMerchantAdd', $aDataEdit);
    }

    //Functionality : Event Edit Merchant
    //Parameters : Ajax jMerchant()
    //Creator : 12/06/2019 Sarun
    //update : 17/03/2020 Saharat(Golf)
    //Return : Status Add Event
    //Return Type : String
    public function FSaMCNEditEvent()
    {
        try {

            $tImgInputMerchantOld = $this->input->post('oetImgInputMerchantOld');
            $tImgInputMerchant    = $this->input->post('oetImgInputMerchant');

            $aDataMaster    = array(
                'FTMcnCode'             => $this->input->post('oetMcnCode'),
                'FTPplCode'             => $this->input->post('oetMerPriceGroupCode'),
                'FTMerRefCode'          => $this->input->post('oetRefMerCode'),
                'FTMcnName'             => $this->input->post('oetMcnName'),
                'FTMcnEmail'            => $this->input->post('oetMcnEmail'),
                'FTMcnTel'              => $this->input->post('oetMcnTel'),
                'FTMcnFax'              => $this->input->post('oetMcnFax'),
                'FTMcnMo'               => $this->input->post('oetMcnMo'),
                'FTMcnRmk'              => $this->input->post('otaMcnRemark'),
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FNLngID'               => $this->session->userdata("tLangEdit"),
            );
            $this->db->trans_begin();
            $aStaMcnMaster  = $this->Merchant_model->FSaMMCNAddUpdateMaster($aDataMaster);
            $aStaMcnLang    = $this->Merchant_model->FSaMMCNAddUpdateLang($aDataMaster);
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit Event"
                );
            } else {
                $this->db->trans_commit();
                if ($tImgInputMerchant != $tImgInputMerchantOld) {
                    $aImageUplode = array(
                        'tModuleName'       => 'merchant',
                        'tImgFolder'        => 'merchant',
                        'tImgRefID'         => $aDataMaster['FTMcnCode'],
                        'tImgObj'           => $tImgInputMerchant,
                        'tImgTable'         => 'TCNMMerchant',
                        'tTableInsert'      => 'TCNMImgObj',
                        'tImgKey'           => 'main',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1
                    );
                    FCNnHAddImgObj($aImageUplode);
                }
                $aReturn = array(
                    'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'    => $aDataMaster['FTMcnCode'],
                    'nStaEvent'        => '1',
                    'tStaMessg'        => 'Success Edit Event'
                );
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Event Delete Merchant
    //Parameters : Ajax jMerchant()
    //Creator : 12/06/2019 Sarun -
    //update  : 17/03/2020 Saharat(Golf)
    //Return : Status Delete Event
    //Return Type : String
    public function FSaMCNDeleteEvent()
    {
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTMcnCode' => $tIDCode
        );
        $tAPIReq        = 'API/Merchant/Delete';
        $tMethodReq     = 'POST';
        $aMcnDel        = $this->Merchant_model->FSnMMCNDel($tAPIReq, $tMethodReq, $aDataMaster);
        $nNumRowMcnLoc  = $this->Merchant_model->FSnMLOCGetAllNumRow();
        $aDeleteImage = array(
            'tModuleName'  => 'merchant',
            'tImgFolder'   => 'merchant',
            'tImgRefID'    => $tIDCode,
            'tTableDel'    => 'TCNMImgObj',
            'tImgTable'    => 'TCNMMerchant'
        );
        //ลบข้อมูลในตาราง         
        $nStaDelImgInDB = FSnHDelectImageInDB($aDeleteImage);
        if ($nStaDelImgInDB == 1) {
            //ลบรูปในโฟลเดอ
            FSnHDeleteImageFiles($aDeleteImage);
        }

        if ($nNumRowMcnLoc) {
            $aReturn    = array(
                'nStaEvent'     => $aMcnDel['rtCode'],
                'tStaMessg'     => $aMcnDel['rtDesc'],
                'nNumRowMcnLoc' => $nNumRowMcnLoc
            );
            echo json_encode($aReturn);
        } else {
            echo "database error";
        }
    }






    //Functionality : Function CallPage Merchant Address DataTable
    //Parameters : Ajax Call View Add
    //Creator : 09/07/2019 Sarun
    //Return : String View
    //Return Type : View
    public function FSvCMerchantAddressDataTable()
    {
        $tMerchantcode          = $this->input->post('tMerchantCode');
        $aMerchantDataAddress   = $this->Merchant_model->FSnMMCNGetDataAddress($tMerchantcode);
        $aMerchantAddress       = array(
            'aMerchantAddress' => $aMerchantDataAddress
        );
        $this->load->view('Merchant/Merchant/wMerchantAddressTable', $aMerchantAddress);
    }

    // Functionality : Function CallPage Merchant Add Address
    // Parameters : Ajax Call View Add
    // Creator : 09/07/2019 Sarun
    // LastUpdate : 09/06/2019 Wasin(Yoshi)
    // Return : String View
    // Return Type : View
    public function FSvCMerchantAddressCallPageAdd()
    {
        $tMerchantcode  = $this->input->post('ptMerchantCode');
        $aMerchantData  = $this->Merchant_model->FSaMSPLAddType();
        $aDataMerchant = array(
            'nStaCallView'          => 1, // 1 = Call View Add , 2 = Call View Edits
            'tMerchantcode'         => $tMerchantcode,
            'aDataAddressConfig'    => $aMerchantData
        );
        $this->load->view('Merchant/Merchant/wMerchantAddAddress', $aDataMerchant);
    }

    // Functionality : Function Call Page Merchant Edit Address
    // Parameters : Ajax Call View Add
    // Creator : 09/07/2019 Sarun
    // LastUpdate : 09/06/2019 Wasin(Yoshi)
    // Return : String View
    // Return Type : View
    public function FSvCMerchantAddressCallPageEdit()
    {
        $aDataWhereAddress  = [
            'FNLngID'       => $this->input->post('FNLngID'),
            'FTAddGrpType'  => $this->input->post('FTAddGrpType'),
            'FTAddRefCode'  => $this->input->post('FTAddRefCode'),
            'FNAddSeqNo'    => $this->input->post('FNAddSeqNo'),
        ];
        $aMerchantData  = $this->Merchant_model->FSaMSPLAddType();
        $aDataAddress   = $this->Merchant_model->FSaMMerchantAddressGetDataID($aDataWhereAddress);
        $aDataMerchant = array(
            'nStaCallView'          => 2, // 1 = Call View Add , 2 = Call View Edits
            'tMerchantcode'         => $aDataWhereAddress['FTAddRefCode'],
            'aDataAddressConfig'    => $aMerchantData,
            'aDataAddress'          => $aDataAddress
        );
        $this->load->view('Merchant/Merchant/wMerchantAddAddress', $aDataMerchant);
    }

    // Functionality : Event Add Merchant Address
    // Parameters : Ajax Event
    // Creator : 09/07/2019 Sarun
    // LastUpdate : 09/09/2019 Wasin(Yoshi)
    // Return : Status Add Event
    // Return Type : String
    public function FSaCMerchantAddressAddEvent()
    {
        try {
            $tMerAddrVersion  = $this->input->post('ohdMerchantVersion');
            if (isset($tMerAddrVersion) && $tMerAddrVersion == 1) {
                $aMerchantDataAddress   = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdMerchantAddrGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdMerchantCode"),
                    'FTAddName'         => $this->input->post("oetMerchantAddrName"),
                    'FTAddTaxNo'        => $this->input->post("oetMerchantAddrTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetMerchantAddrRmk"),
                    'FTAddVersion'      => $tMerAddrVersion,
                    'FTAddV1No'         => $this->input->post("oetMerchantAddrNo"),
                    'FTAddV1Soi'        => $this->input->post("oetMerchantAddrSoi"),
                    'FTAddV1Village'    => $this->input->post("oetMerchantAddrVillage"),
                    'FTAddV1Road'       => $this->input->post("oetMerchantAddrRoad"),
                    'FTAddV1SubDist'    => $this->input->post("oetMerchantAddrSubDstCode"),
                    'FTAddV1DstCode'    => $this->input->post("oetMerchantAddrDstCode"),
                    'FTAddV1PvnCode'    => $this->input->post("oetMerchantAddrPvnCode"),
                    'FTAddV1PostCode'   => $this->input->post("oetMerchantAddrPostCode"),
                    'FTAddWebsite'      => $this->input->post("oetMerchantAddrWeb"),
                    'FTAddLongitude'    => $this->input->post("oetMerchantMapLong"),
                    'FTAddLatitude'     => $this->input->post("oetMerchantMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername')
                ];
            } else {
                $aMerchantDataAddress   = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdMerchantAddrGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdMerchantCode"),
                    'FTAddName'         => $this->input->post("oetMerchantAddrName"),
                    'FTAddTaxNo'        => $this->input->post("oetMerchantAddrTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetMerchantAddrRmk"),
                    'FTAddVersion'      => $tMerAddrVersion,
                    'FTAddV2Desc1'      => $this->input->post("oetMerchantAddrV2Desc1"),
                    'FTAddV2Desc2'      => $this->input->post("oetMerchantAddrV2Desc2"),
                    'FTAddWebsite'      => $this->input->post("oetMerchantAddrWeb"),
                    'FTAddLongitude'    => $this->input->post("oetMerchantMapLong"),
                    'FTAddLatitude'     => $this->input->post("oetMerchantMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername')
                ];
            }

            $this->db->trans_begin();

            $this->Merchant_model->FSxMMerchantAddressAddData($aMerchantDataAddress);
            $this->Merchant_model->FSxMMerchantAddressUpdateSeq($aMerchantDataAddress);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => 500,
                    'tStaMessg' => "Error Unsucess Add Merchant Address."
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn'        => 1,
                    'tStaMessg'         => 'Success Add Merchant Address.',
                    'tDataCodeReturn'   => $aMerchantDataAddress['FTAddRefCode']
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaReturn'    => 500,
                'tStaMessg'     => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Event Edit Merchant Address
    // Parameters : Ajax Event
    // Creator : 09/07/2019 Sarun
    // LastUpdate : 09/09/2019 Wasin(Yoshi)
    // Return : Status Add Event
    // Return Type : String
    public function FSaCMerchantAddressEditEvent()
    {
        try {
            $tMerAddrVersion  = $this->input->post('ohdMerchantVersion');
            if (isset($tMerAddrVersion) && $tMerAddrVersion == 1) {
                $aMerchantDataAddress   = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdMerchantAddrGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdMerchantCode"),
                    'FNAddSeqNo'        => $this->input->post("ohdMerchantSeqNo"),
                    'FTAddName'         => $this->input->post("oetMerchantAddrName"),
                    'FTAddTaxNo'        => $this->input->post("oetMerchantAddrTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetMerchantAddrRmk"),
                    'FTAddVersion'      => $tMerAddrVersion,
                    'FTAddV1No'         => $this->input->post("oetMerchantAddrNo"),
                    'FTAddV1Soi'        => $this->input->post("oetMerchantAddrSoi"),
                    'FTAddV1Village'    => $this->input->post("oetMerchantAddrVillage"),
                    'FTAddV1Road'       => $this->input->post("oetMerchantAddrRoad"),
                    'FTAddV1SubDist'    => $this->input->post("oetMerchantAddrSubDstCode"),
                    'FTAddV1DstCode'    => $this->input->post("oetMerchantAddrDstCode"),
                    'FTAddV1PvnCode'    => $this->input->post("oetMerchantAddrPvnCode"),
                    'FTAddV1PostCode'   => $this->input->post("oetMerchantAddrPostCode"),
                    'FTAddWebsite'      => $this->input->post("oetMerchantAddrWeb"),
                    'FTAddLongitude'    => $this->input->post("oetMerchantMapLong"),
                    'FTAddLatitude'     => $this->input->post("oetMerchantMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername')
                ];
            } else {
                $aMerchantDataAddress   = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdMerchantAddrGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdMerchantCode"),
                    'FNAddSeqNo'        => $this->input->post("ohdMerchantSeqNo"),
                    'FTAddName'         => $this->input->post("oetMerchantAddrName"),
                    'FTAddTaxNo'        => $this->input->post("oetMerchantAddrTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetMerchantAddrRmk"),
                    'FTAddVersion'      => $tMerAddrVersion,
                    'FTAddV2Desc1'      => $this->input->post("oetMerchantAddrV2Desc1"),
                    'FTAddV2Desc2'      => $this->input->post("oetMerchantAddrV2Desc2"),
                    'FTAddWebsite'      => $this->input->post("oetMerchantAddrWeb"),
                    'FTAddLongitude'    => $this->input->post("oetMerchantMapLong"),
                    'FTAddLatitude'     => $this->input->post("oetMerchantMapLat"),
                    'FTLastUpdBy'        => $this->session->userdata('tSesUsername')
                ];
            }

            $this->db->trans_begin();

            $this->Merchant_model->FSxMMerchantAddressUpdateData($aMerchantDataAddress);
            $this->Merchant_model->FSxMMerchantAddressUpdateSeq($aMerchantDataAddress);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => 500,
                    'tStaMessg' => "Error Unsucess Add Merchant Address."
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn'        => 1,
                    'tStaMessg'         => 'Success Add Merchant Address.',
                    'tDataCodeReturn'   => $aMerchantDataAddress['FTAddRefCode']
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaReturn'    => 500,
                'tStaMessg'     => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Function Delete Merchant Address Delete
    // Parameters : Ajax Call View Add
    // Creator : 09/07/2019 Sarun
    // LastUpdate : 09/09/2019 Wasin(Yoshi) 
    // Return : String View
    // Return Type : View
    public function FSoCMerchantAddressDeleteEvent()
    {
        try {
            $this->db->trans_begin();

            $aDataWhereDelete   = [
                'FNLngID'       => $this->input->post('FNLngID'),
                'FTAddGrpType'  => $this->input->post('FTAddGrpType'),
                'FTAddRefCode'  => $this->input->post('FTAddRefCode'),
                'FNAddSeqNo'    => $this->input->post('FNAddSeqNo')
            ];

            $this->Merchant_model->FSaMMerchantAddressDelete($aDataWhereDelete);
            $this->Merchant_model->FSxMMerchantAddressUpdateSeq($aDataWhereDelete);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => 500,
                    'tStaMessg' => "Error Unsucess Delete Merchant Address."
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn'        => 1,
                    'tStaMessg'         => 'Success Delete Merchant Address.',
                    'tDataCodeReturn'   => $aDataWhereDelete['FTAddRefCode']
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaReturn'    => 500,
                'tStaMessg'     => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }
}
