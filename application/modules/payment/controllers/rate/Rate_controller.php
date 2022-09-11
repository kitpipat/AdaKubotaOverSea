<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rate_controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('payment/rate/Rate_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    /**
     * Functionality : Vate list
     * Parameters : $nBrowseType: 
     * Creator : dd/mm/yyyy {name}
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    public function index($nBrowseType, $tBrowseOption)
    {

        $aData['nBrowseType']       = $nBrowseType;
        $aData['tBrowseOption']     = $tBrowseOption;
        $aData['aAlwEventRate']     = FCNaHCheckAlwFunc('rate/0/0'); // Control Event
        $aData['vBtnSave']          = FCNaHBtnSaveActiveHTML('rate/0/0'); // oad Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน

        $this->load->view('payment/rate/wRate', $aData);
    }

    /**
     * Functionality : {description}
     * Parameters : {params}
     * Creator : dd/mm/yyyy {name}
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    public function FSxCRTEAddPage()
    {

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $nOptDecimalShow    = FCNxHGetOptionDecimalCurrencyShow();
        $nDecimalShow 		= FCNxHGetOptionDecimalShow();
        $aData  = array(
            'FNLngID'   => $nLangEdit,
        );

        $aDataAdd = array(
            'aResult'   => array('rtCode' => '99'),
            'nOptDecimalShow'    => $nOptDecimalShow,
            'nDecimalShow'      => $nDecimalShow,
        );

        $this->load->view('payment/rate/wRateAdd', $aDataAdd);
    }

    public function FSxCRTEFormSearchList()
    {
        $this->load->view('payment/rate/wRateFormSearchList');
    }

    //Functionality : Event Add Rate
    //Parameters : Ajax jRate()
    //Creator : 03/07/2018 Krit(Krit)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaCRTEAddEvent()
    {
        try {
            // *** Image Data
            $tRateImage     = trim($this->input->post('oetImgInputRate'));
            $tRateImageOld  = trim($this->input->post('oetImgInputRateOld'));
            // *** Image Data
            $oetRteRate     = $this->input->post('oetRteRate');
            $oetRteFraction = $this->input->post('oetRteFraction');
            $aRtuFac        = $this->input->post('oetRtuFac');
            $oetRteMaxChg = $this->input->post('oetRteMaxChg');
            
            $nDecimalCurrentcySave = FCNxHGetOptionDecimalCurrencySave();
            if (isset($oetRteRate) && !empty($oetRteRate)) {
                $cRateRate    = $oetRteRate;
            } else {
                $cRateRate    = 0;
            }

            if (isset($oetRteFraction) && !empty($oetRteFraction)) {
                $cRteFraction    = $oetRteFraction;
            } else {
                $cRteFraction    = 0;
            }

            if (isset($oetRteMaxChg) && !empty($oetRteMaxChg)) {
                $cRteMaxChg    = $oetRteMaxChg;
            } else {
                $cRteMaxChg    = 0;
            }

            if (!empty($this->input->post('ocmRteStaUse'))) {
                $cmRteStaUse = 1;
            } else {
                $cmRteStaUse = 2;
            }

            if (!empty($this->input->post('ocmRteStaLocal'))) {
                $cRteStaLocal = 1;
            } else {
                $cRteStaLocal = 2;
            }

            if (!empty($this->input->post('ocmRteStaAlwChange'))) {
                $cRteStaAlwChange = 1;
            } else {
                $cRteStaAlwChange = 2;
            }

            $tRteAgnCode = $this->input->post('ohdRteAgnCode');
            if(isset($tRteAgnCode) && !empty($tRteAgnCode)){
                $tRteAgnCode = $this->input->post('ohdRteAgnCode');
            }else{
                $tRteAgnCode = ' ';
            }

            $aDataMaster = array(
                'tIsAutoGenCode' => $this->input->post('ocbRateAutoGenCode'),
                'FTAgnCode'     => $tRteAgnCode,
                'FTRteCode'     => $this->input->post('oetRteCode'),
                'FCRteRate'     => number_format($cRateRate,$nDecimalCurrentcySave, '.', ''),
                'FCRteFraction' => number_format($cRteFraction,FCNxHGetOptionDecimalSave(), '.', ''),
                'FCRteMaxUnit'  => number_format($cRteMaxChg,FCNxHGetOptionDecimalSave(), '.', ''),
                'FTRteType'     => $this->input->post('ocmRteType'),
                'FTRteSign'     => $this->input->post('oetRteSign'),
                'FTRteName'     => $this->input->post('oetRteName'),
                'FTRteStaUse'   => $cmRteStaUse,
                'FTRteStaLocal' => $cRteStaLocal,
                'FTRteStaAlwChange' => $cRteStaAlwChange,
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTRteIsoCode'     => $this->input->post('oetRteIsoCode'),
                'FTRteTypeChg'  => $this->input->post('ocmRteTypeChg'),
            );


            if ($aDataMaster['tIsAutoGenCode'] == '1') { // Check Auto Gen Department Code?
                // Auto Gen Department Code
                $aStoreParam = array(
                    "tTblName"   => 'TFNMRate',
                    "tDocType"   => 0,
                    "tBchCode"   => "",
                    "tShpCode"   => "",
                    "tPosCode"   => "",
                    "dDocDate"   => date("Y-m-d")
                );
                $aAutogen                   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTRteCode']   = $aAutogen[0]["FTXxhDocNo"];
            }
            $aDataUnitFac = [
                'FTAgnCode' => $tRteAgnCode,
                'FTRteCode' => $aDataMaster['FTRteCode'],
                'aRtuFac' => $aRtuFac
            ];
            $oCountDup  = $this->Rate_model->FSnMRTECheckDuplicate($aDataMaster['FTRteCode'],$aDataMaster['FTAgnCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if ($nStaDup == 0) {
                $this->db->trans_begin();
                $aStaEventMaster  = $this->Rate_model->FSaMRTEAddUpdateMaster($aDataMaster);
                $aStaEventLang    = $this->Rate_model->FSaMRTEAddUpdateLang($aDataMaster);
                $aStaEventRateUnitFact  = $this->Rate_model->FSaMRTEAddUpdateRateUnitFact($aDataUnitFac);
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                } else {
                    $this->db->trans_commit();
                    if ($tRateImage != $tRateImageOld) {
                        $aImageUplode   = array(
                            'tModuleName'       => 'payment',
                            'tImgFolder'        => 'rate',
                            'tImgRefID'         => $aDataMaster['FTAgnCode'].$aDataMaster['FTRteCode'],
                            'tImgObj'           => $tRateImage,
                            'tImgTable'         => 'TFNMRate',
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
                        'tCodeReturn'    => $aDataMaster['FTRteCode'],
                        'tAgnCode'    => $aDataMaster['FTAgnCode'],
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


    //Functionality : Event Edit Rate
    //Parameters : Ajax jRate()
    //Creator : 02/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaCRTEEditEvent()
    {
        try {
            // *** Image Data
            $tRateImage     = trim($this->input->post('oetImgInputRate'));
            $tRateImageOld  = trim($this->input->post('oetImgInputRateOld'));
            // *** Image Data
            $oetRteRate     = $this->input->post('oetRteRate');
            $oetRteFraction = $this->input->post('oetRteFraction');
            $oetRteMaxChg = $this->input->post('oetRteMaxChg');

            $aRtuFac        = $this->input->post('oetRtuFac');
            $nDecimalCurrentcySave = FCNxHGetOptionDecimalCurrencySave();
            if (isset($oetRteRate) && !empty($oetRteRate)) {
                $cRateRate    = $oetRteRate;
                if($this->input->post('oetRteRateDef')){
                    $cRateRate  = $this->input->post('oetRteRateDef');
                }
            } else {
                $cRateRate    = 0;
            }
            if (isset($oetRteFraction) && !empty($oetRteFraction)) {
                $cRteFraction    = $oetRteFraction;
                if($this->input->post('oetRteFractionDef')){
                    $cRteFraction  = $this->input->post('oetRteFractionDef');
                }
            } else {
                $cRteFraction    = 0;
            }
            if (isset($oetRteMaxChg) && !empty($oetRteMaxChg)) {
                $cRteMaxChg    = $oetRteMaxChg;
                if($this->input->post('oetRteMaxChgDef')){
                    $cRteMaxChg  = $this->input->post('oetRteMaxChgDef');
                }
            } else {
                $cRteMaxChg    = 0;
            }

            if (!empty($this->input->post('ocmRteStaUse'))) {
                $cmRteStaUse = 1;
            } else {
                $cmRteStaUse = 2;
            }

            if (!empty($this->input->post('ocmRteStaLocal'))) {
                $cRteStaLocal = 1;
            } else {
                $cRteStaLocal = 2;
            }

            if (!empty($this->input->post('ocmRteStaAlwChange'))) {
                $cRteStaAlwChange = 1;
            } else {
                $cRteStaAlwChange = 2;
            }

            $tRteAgnCode = $this->input->post('ohdRteAgnCode');
            if(isset($tRteAgnCode) && !empty($tRteAgnCode)){
                $tRteAgnCode = $this->input->post('ohdRteAgnCode');
            }else{
                $tRteAgnCode = ' ';
            }
            // print_r($cRateRate);
            // echo ' :: ';
            // print_r(number_format($cRateRate,$nDecimalCurrentcySave, '.', ''));
            // echo ' :: ';

            // print_r(floatval(number_format($cRateRate,$nDecimalCurrentcySave, '.', '')));
            
            $aDataMaster    = [
                'FTRteCode'     => $this->input->post('oetRteCode'),
                'FTImgObj'      => $this->input->post('oetImgInputrate'),
                'FTAgnCode'     => $tRteAgnCode,
                'FCRteRate'     => number_format($cRateRate,$nDecimalCurrentcySave, '.', ''),
                'FCRteFraction' => number_format($cRteFraction,FCNxHGetOptionDecimalSave(), '.', ''),
                'FCRteMaxUnit'  => number_format($cRteMaxChg,FCNxHGetOptionDecimalSave(), '.', ''),
                'FTRteType'     => $this->input->post('ocmRteType'),
                'FTRteSign'     => $this->input->post('oetRteSign'),
                'FTRteName'     => $this->input->post('oetRteName'),
                'FTRteStaUse'   => $cmRteStaUse,
                'FTRteStaLocal' => $cRteStaLocal,
                'FTRteStaAlwChange' => $cRteStaAlwChange,
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTRteIsoCode'  => $this->input->post('oetRteIsoCode'),
                'FTRteTypeChg'  => $this->input->post('ocmRteTypeChg'),
            ];

            $aDataUnitFac = [
                'FTAgnCode' => $tRteAgnCode,
                'FTRteCode' => $this->input->post('oetRteCode'),
                'aRtuFac' => $aRtuFac
            ];
            
            $this->db->trans_begin();
            $aStaEventMaster  = $this->Rate_model->FSaMRTEAddUpdateMaster($aDataMaster);
            $aStaEventLang    = $this->Rate_model->FSaMRTEAddUpdateLang($aDataMaster);
            $aStaEventRateUnitFact  = $this->Rate_model->FSaMRTEAddUpdateRateUnitFact($aDataUnitFac);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            } else {
                $this->db->trans_commit();
                if ($tRateImage != $tRateImageOld) {
                    $aImageUplode   = array(
                        'tModuleName'       => 'payment',
                        'tImgFolder'        => 'rate',
                        'tImgRefID'         => $aDataMaster['FTAgnCode'].$aDataMaster['FTRteCode'],
                        'tImgObj'           => $tRateImage,
                        'tImgTable'         => 'TFNMRate',
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
                    'tCodeReturn'    => $aDataMaster['FTRteCode'],
                    'tAgnCode'    => $aDataMaster['FTAgnCode'],
                    'nStaEvent'        => '1',
                    'tStaMessg'        => 'Success Add Event'
                );
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Event Delete Rate
    //Parameters : Ajax jRate()
    //Creator : 03/07/2018 Krit(Copter)
    //Last Modified : 12/08/2019 Saharat(Golf)
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCRTEDeleteEvent()
    {
        $tIDCode = $this->input->post('tIDCode');
        $tAgnCode = $this->input->post('tAgnCode');
        if(isset($tAgnCode) && !empty($tAgnCode)){
            $tAgnCode = $this->input->post('tAgnCode');
        }else{
            $tAgnCode = ' ';
        }
        $aDataMaster = array(
            'FTRteCode' => $tIDCode,
            'FTAgnCode' => $tAgnCode
        );
        //ลบข้อมูล
        // print_r($aDataMaster);
        $aResDel  = $this->Rate_model->FSnMRTEDel($aDataMaster);
        // $aResDel = '';
        //เช็คแถวข้อมูลถ้า <= 10 ให้เปลี่ยนหน้า
        $nNumRow  = $this->Rate_model->FSnMRTEGetAllNumRow();
        //ลบรูป
        $aDeleteImage = array(
            'tModuleName'  => 'payment',
            'tImgFolder'   => 'rate',
            'tImgRefID'    => $tIDCode,
            'tTableDel'    => 'TCNMImgObj',
            'tImgTable'    => 'TFNMRate'
        );
        $nDelectImageInDB =  FSnHDelectImageInDB($aDeleteImage);
        if ($nDelectImageInDB == 1) {
            FSnHDeleteImageFiles($aDeleteImage);
        }
        if ($nNumRow !==  false) {
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
                'nNumRow'   => $nNumRow
            );
            echo json_encode($aReturn);
        } else {
            echo "database error!";
        }
    }

    public function FSvCRTEEditPage()
    {
        $aAlwEventRate      = FCNaHCheckAlwFunc('rate/0/0'); //Controle Event
        $nOptDecimalShow    = FCNxHGetOptionDecimalCurrencyShow();
        $nDecimalShow 		= FCNxHGetOptionDecimalShow();

        $tRteCode           = $this->input->post('tRteCode');
        $tAgnCode           = $this->input->post('tAgnCode');
        $nLangResort        = $this->session->userdata("tLangID");
        $nLangEdit          = $this->session->userdata("tLangEdit");
        $aData  = array(
            'FTRteCode' => $tRteCode,
            'FNLngID'   => $nLangEdit,
            'FTAgnCode' => $tAgnCode
        );
        $aResult       = $this->Rate_model->FSaMRTESearchByID($aData);
        $aRateUnit     = $this->Rate_model->FSaMRTERateUnit($aData);
        //split path ของรูป
        if (isset($aResult['raItems']['rtImgObj']) && !empty($aResult['raItems']['rtImgObj'])) {
            $tImgObj        = $aResult['raItems']['rtImgObj'];
            $aImgObj        = explode("application/modules/", $tImgObj);
            $aImgObjName    = explode("/", $tImgObj);
            $tImgObjAll     = $aImgObj[1];
            $tImgName        = end($aImgObjName);
        } else {
            $tImgObjAll     = "";
            $tImgName       = "";
        }
        $aDataEdit  = array(
            'nOptDecimalShow'   => $nOptDecimalShow,
            'aResult'           => $aResult,
            'aAlwEventRate'     => $aAlwEventRate,
            'tImgObjAll'        => $tImgObjAll,
            'tImgName'          => $tImgName,
            'aRateUnit'         => $aRateUnit,
            'nDecimalShow'     => $nDecimalShow
        );
        $this->load->view('payment/rate/wRateAdd', $aDataEdit);
    }


    //Functionality : Function Call DataTables Rate
    //Parameters : Ajax jRate()
    //Creator : 03/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSxCRTEDataTable()
    {
        $aAlwEvent = FCNaHCheckAlwFunc('rate/0/0'); //Controle Event
        $nPage = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }
        if (!$tSearchAll) {
            $tSearchAll = '';
        }
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );
        $nOptDecimalShow    = FCNxHGetOptionDecimalCurrencyShow();
        $aResList   = $this->Rate_model->FSaMRTEList($aData);
        $aGenTable  = array(
            'nOptDecimalShow'    => $nOptDecimalShow,
            'aAlwEvent'         => $aAlwEvent,
            'aDataList'         => $aResList,
            'nPage'             => $nPage,
            'tSearchAll'        => $tSearchAll
        );
        $this->load->view('payment/rate/wRateDataTable', $aGenTable);
    }
}
