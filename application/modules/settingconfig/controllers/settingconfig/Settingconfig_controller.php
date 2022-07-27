<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Settingconfig_controller extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('settingconfig/settingconfig/Settingconfig_model');
    }

    public function index($nBrowseType, $tBrowseOption){
        $aData['nBrowseType']       = $nBrowseType;
        $aData['tBrowseOption']     = $tBrowseOption;
        $aData['aAlwEvent']         = FCNaHCheckAlwFunc('settingconfig/0/0');
        $aData['vBtnSave']          = FCNaHBtnSaveActiveHTML('settingconfig/0/0');
        $aData['nOptDecimalShow']   = FCNxHGetOptionDecimalShow();
        $aData['nOptDecimalSave']   = FCNxHGetOptionDecimalSave();
        $this->load->view('settingconfig/settingconfig/wSettingconfig', $aData);
    }

    //Get Page List (Tab : ตั้งค่าระบบ , รหัสอัตโนมัติ)
    public function FSvSETGetPageList(){
        $this->load->view('settingconfig/settingconfig/wSettingconfigList');
    }

    /////////////////////////////////////////////////////////////////////////////////////////////// แท็บตั้งค่าระบบ

    //Get Page List (Content : แท็บตั้งค่าระบบ)
    public function FSvSETGetPageListSearch(){
        $aOption = $this->Settingconfig_model->FSaMSETGetAppTpye();
        $aReturn = array(
            'aOption' => $aOption,
            'tTypePage' => $this->input->post('ptTypePage')
        );
        $this->load->view('settingconfig/settingconfig/config/wConfigList',$aReturn);
    }

    //Get Table (แท็บตั้งค่าระบบ)
    public function FSvSETSettingGetTable(){
        $aAlwEvent      = FCNaHCheckAlwFunc('settingconfig/0/0');
        $tAppType       = $this->input->post('tAppType');
        $tSearch        = $this->input->post('tSearch');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $nDecimalSave = FCNxHGetOptionDecimalSave();
        $nDecimalShow = FCNxHGetOptionDecimalShow();

        $aData  = array(
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearch,
            'tAppType'      => $tAppType,
            'tTypePage'     => $this->input->post("ptTypePage"),
            'FTAgnCode'     => $this->input->post("ptAgnCode")
        );


        $aResListCheckbox       = $this->Settingconfig_model->FSaMSETConfigDataTableByType($aData,'checkbox');
        $aResListInputText      = $this->Settingconfig_model->FSaMSETConfigDataTableByType($aData,'input');

        $aGenTable  = array(
            'tTypePage'             => $this->input->post("ptTypePage"),
            'aAlwEvent'             => $aAlwEvent,
            'aResListCheckbox'      => $aResListCheckbox,
            'aResListInputText'     => $aResListInputText,
            'nDecimalShow'          => $nDecimalShow
        );

        $this->load->view('settingconfig/settingconfig/config/wConfigDatatable',$aGenTable);
    }

    //Event Save (แท็บตั้งค่าระบบ)
    public function FSxSETSettingEventSave(){
        $aMergeArray = $this->input->post('aMergeArray');
        $tTypePage   = $this->input->post('ptTypePage');
        $tAgnCode    = $this->input->post('ptAgnCode');
        if(count($aMergeArray) >= 1){
            for($i=0; $i<count($aMergeArray); $i++){

                //Type
                if($aMergeArray[$i]['tType'] == 'checkbox'){
                    $tType = '4';
                }else{
                    $tType = $aMergeArray[$i]['tType'];
                }

                //Packdata
                $aUpdate = array(
                    'FTSysCode'             =>  $aMergeArray[$i]['tSyscode'],
                    'FTSysApp'              =>  $aMergeArray[$i]['tSysapp'],
                    'FTSysKey'              =>  $aMergeArray[$i]['tSyskey'],
                    'FTSysSeq'              =>  $aMergeArray[$i]['tSysseq'],
                    'FTSysStaDataType'      =>  $tType,
                    'nValue'                =>  $aMergeArray[$i]['nValue'],
                    'tKind'                 =>  $aMergeArray[$i]['tKind'],
                    'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                    'tTypePage'             => $tTypePage,
                    'FTAgnCode'             => $tAgnCode
                );

                //Update
                $aResList   = $this->Settingconfig_model->FSaMSETUpdate($aUpdate);
            }
        }
    }

    //Event Use Default value ใช้แม่แบบ (แท็บตั้งค่าระบบ)
    public function FSxSETSettingUseDefaultValue(){
        $aReturn = $this->Settingconfig_model->FSaMSETUseValueDefult();
        echo $aReturn;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////// แท็บรหัสอัตโนมัติ

    //Get Page List (Content : แท็บรหัสอัตโนมัติ)
    public function FSvSETAutonumberGetPageListSearch(){
        $aOption = $this->Settingconfig_model->FSaMSETGetAppTpye();
        $aReturn = array(
            'aOption' => $aOption
        );
        $this->load->view('settingconfig/settingconfig/autonumber/wAutonumberList',$aReturn);
    }

    //Get Table (แท็บรหัสอัตโนมัติ)
    public function FSvSETAutonumberSettingGetTable(){
        $aAlwEvent      = FCNaHCheckAlwFunc('settingconfig/0/0');
        $tAppType       = $this->input->post('tAppType');
        $tSearch        = $this->input->post('tSearch');
	    $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearch,
            'tAppType'      => $tAppType
        );

        $aItemRecord    = $this->Settingconfig_model->FSaMSETConfigDataTableAutoNumber($aData);
        $aGenTable      = array(
            'aAlwEvent'        => $aAlwEvent,
            'aItemRecord'      => $aItemRecord
        );

        $this->load->view('settingconfig/settingconfig/autonumber/wAutonumberDatatable',$aGenTable);
    }

    //Load Page Edit
    public function FSvSETAutonumberPageEdit(){
        $aAlwEvent   = FCNaHCheckAlwFunc('settingconfig/0/0');
        $tTable      = $this->input->post('ptTable');
        $nSeq        = $this->input->post('pnSeq');

        $aWhere      = array(
            'FTSatTblName'      => $tTable,
            'FTSatStaDocType'   => $nSeq
        );
        $aAllowItem  = $this->Settingconfig_model->FSaMSETConfigGetAllowDataAutoNumber($aWhere);

        $aGenTable   = array(
            'aAlwEvent'         => $aAlwEvent,
            'aAllowItem'        => $aAllowItem,
            'nMaxFiledSizeBCH'  => $this->Settingconfig_model->FSaMSETGetMaxLength('TCNMBranch'),
            'nMaxFiledSizePOS'  => $this->Settingconfig_model->FSaMSETGetMaxLength('TCNMPos')
        );
        $this->load->view('settingconfig/settingconfig/autonumber/wAutonumberPageAdd',$aGenTable);
    }

    //บันทึก
    public function FSvSETAutonumberEventSave(){
        $tTypedefault   = $this->input->post('tTypedefault');
        $aPackData      = $this->input->post('aPackData');
        if($tTypedefault == 'default'){
            $aDelete = array(
                'FTAhmTblName'      => $aPackData[0],
                'FTAhmFedCode'      => $aPackData[1],
                'FTSatStaDocType'	=> $aPackData[2]
            );
            $tResult = $this->Settingconfig_model->FSaMSETAutoNumberDelete($aDelete);
        }else{
            $aIns = array(
                'FTAhmTblName'      => $aPackData[0],
                'FTAhmFedCode'      => $aPackData[1],
                'FTSatStaDocType'   => $aPackData[2],
                'FTAhmFmtAll'       => $aPackData[3]['FTAhmFmtAll'],
                'FTAhmFmtPst'       => $aPackData[3]['FTAhmFmtPst'],
                'FNAhmFedSize'      => $aPackData[3]['FNAhmFedSize'],
                'FTAhmFmtChar'      => $aPackData[3]['FTAhmFmtChar'],
                'FTAhmStaBch'       => $aPackData[3]['FTAhmStaBch'],
                'FTAhmFmtYear'      => $aPackData[3]['FTAhmFmtYear'],
                'FTAhmFmtMonth'     => $aPackData[3]['FTAhmFmtMonth'],
                'FTAhmFmtDay'       => $aPackData[3]['FTAhmFmtDay'],
                'FTSatStaAlwSep'    => $aPackData[3]['FTSatStaAlwSep'],
                'FNAhmLastNum'      => $aPackData[3]['FNAhmLastNum'],
                'FNAhmNumSize'      => $aPackData[3]['FNAhmNumSize'],
                'FTAhmStaReset'     => $aPackData[3]['FTAhmStaReset'],
                'FTAhmFmtReset'     => $aPackData[3]['FTAhmFmtReset'],
                'FTAhmLastRun'      => $aPackData[3]['FTAhmLastRun'],
                'FTSatUsrNum'       => $aPackData[3]['FTSatUsrNum'],
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
            );

            //Delete ก่อน
            $this->Settingconfig_model->FSaMSETAutoNumberDelete($aIns);

            //Insert
            $aResultInsert = $this->Settingconfig_model->FSaMSETAutoNumberInsert($aIns);
        }
    }

    //Function InsertData Config
    //Create By Sooksanti(Non) 05-11-2020
    public function FSxSETSettingConfigExport(){

        $tfile_pointer = 'application/modules/settingconfig/views/settingconfig/config/export';
        if (!file_exists($tfile_pointer)) {
            mkdir($tfile_pointer);
        }
        //GetData Tsysconfig
        $aPackDataTsysconfig  = $this->Settingconfig_model->FSaMSETExportDetailTsysconfig();

        //Get Data Tsysconfig_L
        $aPackDataTsysconfig_L = $this->Settingconfig_model->FSaMSETExportDetailTSysConfig_L();

        $aItemTsysconfig       = $aPackDataTsysconfig['raItems'];
        $aItemTsysconfig_L     = $aPackDataTsysconfig_L['raItems'];

        $aWriteData      = array();
        $nKeyIndexImport = 0;
        $nCntModCode     = 999;

        $aDataArrayTsysconfig  = array(
            'tTable'  => 'TSysConfig',
            'tItem'    => array(),
        );

        for($i=0; $i<count($aItemTsysconfig); $i++){
                $aParam = [
                    'tTable'            => 'TSysConfig',
                    'FTSysCode'         => $aItemTsysconfig[$i]['FTSysCode'],
                    'FTSysApp'          => $aItemTsysconfig[$i]['FTSysApp'],
                    'FTSysKey'          => $aItemTsysconfig[$i]['FTSysKey'],
                    'FTSysSeq'          => $aItemTsysconfig[$i]['FTSysSeq'],
                    'FTGmnCode'         => $aItemTsysconfig[$i]['FTGmnCode'],
                    'FTSysStaAlwEdit'   => $aItemTsysconfig[$i]['FTSysStaAlwEdit'],
                    'FTSysStaDataType'  => $aItemTsysconfig[$i]['FTSysStaDataType'],
                    'FNSysMaxLength'    => $aItemTsysconfig[$i]['FNSysMaxLength'],
                    'FTSysStaDefValue'  => $aItemTsysconfig[$i]['FTSysStaDefValue'],
                    'FTSysStaDefRef'    => $aItemTsysconfig[$i]['FTSysStaDefRef'],
                    'FTSysStaUsrValue'  => $aItemTsysconfig[$i]['FTSysStaUsrValue'],
                    'FTSysStaUsrRef'    => $aItemTsysconfig[$i]['FTSysStaUsrRef'],
                    'FDLastUpdOn'       => $aItemTsysconfig[$i]['FDLastUpdOn'],
                    'FTLastUpdBy'       => $aItemTsysconfig[$i]['FTLastUpdBy'],
                    'FDCreateOn'        => $aItemTsysconfig[$i]['FDCreateOn'],
                    'FTCreateBy'        => $aItemTsysconfig[$i]['FTCreateBy'],

                ];

            array_push($aDataArrayTsysconfig['tItem'], $aParam);
        }

        $aDataArrayTsysconfig_L = array(
            'tTable'  => 'TSysConfig_L',
            'tItem'    => array(),
        );

        for($j=0; $j<count($aItemTsysconfig_L); $j++){
            $aParam = [
                'tTable'            => 'TSysConfig_L',
                'FTSysCode'         => $aItemTsysconfig_L[$j]['FTSysCode'],
                'FTSysApp'          => $aItemTsysconfig_L[$j]['FTSysApp'],
                'FTSysKey'          => $aItemTsysconfig_L[$j]['FTSysKey'],
                'FTSysSeq'          => $aItemTsysconfig_L[$j]['FTSysSeq'],
                'FNLngID'           => $aItemTsysconfig_L[$j]['FNLngID'],
                'FTSysName'         => $aItemTsysconfig_L[$j]['FTSysName'],
                'FTSysDesc'         => $aItemTsysconfig_L[$j]['FTSysDesc'],
                'FTSysRmk'          => $aItemTsysconfig_L[$j]['FTSysRmk']
            ];

            array_push($aDataArrayTsysconfig_L['tItem'], $aParam);
        }

        array_push($aWriteData,$aDataArrayTsysconfig,$aDataArrayTsysconfig_L);

        $aResultWrite   = json_encode($aWriteData, JSON_PRETTY_PRINT);
        $tFileName      = "ExportConfig".$this->session->userdata('tSesUsername').date('His');

        $tPATH          = APPPATH . "modules/settingconfig/views/settingconfig/config/export//".$tFileName.".json";

        $handle         = fopen($tPATH, 'w+');

        if($handle){
            if(!fwrite($handle, $aResultWrite))  die("couldn't write to file.");
        }

        //ส่งชื่อไฟล์ออกไป
        $aReturn = array(
            'tStatusReturn' => '1',
            'tFilename'     => $tFileName
        );
        echo json_encode($aReturn);

    }


    //Function InsertData Config
    //Create By Sooksanti(Non) 05-11-2020
    function FSxSETConfigInsertData()
    {
        try {
            $tDataJSon = $this->input->post('aData');

            $this->db->trans_begin();

            //Insert ตาราง TSysConfig
            if (!empty($tDataJSon[0]['tItem'])) {
                $aDataDeleteTSysConfigTmp = $this->Settingconfig_model->FSaMSETDeleteTSysConfigTmp();
                $aDataInsToTmpTSysConfig = $this->Settingconfig_model->FSaMSETInsertToTmpTSysConfig();
                $aDataDeleteTSysConfig = $this->Settingconfig_model->FSaMSETDeleteTSysConfig();
                foreach ($tDataJSon[0]['tItem'] as $key => $aValue) {
                    $aDataInsTSysConfig = array(
                        'FTSysCode'         => $aValue['FTSysCode'],
                        'FTSysApp'          => $aValue['FTSysApp'],
                        'FTSysKey'          => $aValue['FTSysKey'],
                        'FTSysSeq'          => $aValue['FTSysSeq'],
                        'FTGmnCode'         => $aValue['FTGmnCode'],
                        'FTSysStaAlwEdit'   => $aValue['FTSysStaAlwEdit'],
                        'FTSysStaDataType'  => $aValue['FTSysStaDataType'],
                        'FNSysMaxLength'    => $aValue['FNSysMaxLength'],
                        'FTSysStaDefValue'  => $aValue['FTSysStaDefValue'],
                        'FTSysStaDefRef'    => $aValue['FTSysStaDefRef'],
                        'FTSysStaUsrValue'  => $aValue['FTSysStaUsrValue'],
                        'FTSysStaUsrRef'    => $aValue['FTSysStaUsrRef'],
                        'FDLastUpdOn'       => $aValue['FDLastUpdOn'],
                        'FTLastUpdBy'       => $aValue['FTLastUpdBy'],
                        'FDCreateOn'        => $aValue['FDCreateOn'],
                        'FTCreateBy'        => $aValue['FTCreateBy'],
                    );

                    $aDataInsTSysConfig = $this->Settingconfig_model->FSaMSETInsertTSysConfig($aDataInsTSysConfig);
                    }
                }

                if (!empty($tDataJSon[1]['tItem'])) {
                    $aDataDeleteTSysConfig_LTmp = $this->Settingconfig_model->FSaMSETDeleteTSysConfig_LTmp();
                    $aDataInsToTmpTSysConfig_L = $this->Settingconfig_model->FSaMSETInsertToTmpTSysConfig_L();
                    $aDataDeleteTSysConfig_LTmp = $this->Settingconfig_model->FSaMSETDeleteTSysConfig_L();
                    foreach ($tDataJSon[1]['tItem'] as $key => $aValue) {
                        $aDataInsTSysConfig_L = array(
                            'FTSysCode'         => $aValue['FTSysCode'],
                            'FTSysApp'          => $aValue['FTSysApp'],
                            'FTSysKey'          => $aValue['FTSysKey'],
                            'FTSysSeq'          => $aValue['FTSysSeq'],
                            'FNLngID'           => $aValue['FNLngID'],
                            'FTSysName'         => $aValue['FTSysName'],
                            'FTSysDesc'         => $aValue['FTSysDesc'],
                            'FTSysRmk'          => $aValue['FTSysRmk']
                        );

                        $aDataInsTSysConfig_L = $this->Settingconfig_model->FSaMSETInsertTSysConfig_L($aDataInsTSysConfig_L);
                    }
                }
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Unsucess Import",
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaEvent'        => '1',
                    'tStaMessg'        => 'Success Import'
                );
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }


}
