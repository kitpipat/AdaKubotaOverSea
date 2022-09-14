<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Settingdairycurrency_controller extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('settingconfig/settingdairycurrency/Settingdairycurrency_model');
    }

    public function index($nBrowseType, $tBrowseOption){
        $aData['nBrowseType']       = $nBrowseType;
        $aData['tBrowseOption']     = $tBrowseOption;
        $aData['aAlwEvent']         = FCNaHCheckAlwFunc('settingconfig/0/0');
        $aData['vBtnSave']          = FCNaHBtnSaveActiveHTML('settingconfig/0/0');
        $aData['nOptDecimalShow']   = FCNxHGetOptionDecimalShow();
        $aData['nOptDecimalSave']   = FCNxHGetOptionDecimalSave();
        $this->load->view('settingconfig/settingdairycurrency/wSettingdairycurrency', $aData);
    }

    //Get Page List (Tab : ตั้งค่าระบบ , รหัสอัตโนมัติ)
    public function FSvSETGetDairyCurrencyPageList(){
        $this->load->view('settingconfig/settingdairycurrency/wSettingdairycurrencyList');
    }

    /////////////////////////////////////////////////////////////////////////////////////////////// แท็บตั้งค่าระบบ

    //Get Page List (Content : แท็บตั้งค่าระบบ)
    public function FSvSETGetDairyCurrencyPageListSearch(){
        $aOption = $this->Settingdairycurrency_model->FSaMSETGetAppTpye();
        $aReturn = array(
            'aOption' => $aOption,
            'tTypePage' => $this->input->post('ptTypePage')
        );
        $this->load->view('settingconfig/settingdairycurrency/config/wDairycurrencyList',$aReturn);
    }

    //Get Table (แท็บตั้งค่าระบบ)
    public function FSvSETDairyCurrencyGetTable(){
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
            'FTAgnCode'     => $this->session->userdata('tSesUsrAgnCode'),
            'tAgnCode'      => $this->input->post("ptAgnCodeChk")
        );

        $aListRate       = $this->Settingdairycurrency_model->FSaMSETConfigDataTableByCurrentcy($aData,'checkbox');
        $aGetUpdateTime  = $this->Settingdairycurrency_model->FSaMCurentcyGetLastUpdate($aData);
        // print_r($aListRate);

        if($aListRate ['rtCode'] == '800'){
            $JobDate = '';
        }else{
            $JobDate = $aListRate['raItems'][0]['FDJobDateCfm'];
        }

        if($aGetUpdateTime['rtCode'] == '800'){
            $ApiTime = '';
        }else{
            $ApiTime = $aGetUpdateTime['raItems'][0]['FDRteLastUpdOn'] ;
        }
        $aGenTable  = array(
            'tTypePage'             => $this->input->post("ptTypePage"),
            'aAlwEvent'             => $aAlwEvent,
            'aListRate'             => $aListRate,
            'nDecimalShow'          => $nDecimalShow,
            'dJobDate'              => $JobDate,
            'FTAgnCode'             => $this->session->userdata('tSesUsrAgnCode'),
            'ApiTime'               => $ApiTime,
        );

        $this->load->view('settingconfig/settingdairycurrency/config/wDairycurrencyDatatable',$aGenTable);
    }

    //Event Save (แท็บตั้งค่าระบบ)
    public function FSxSETDailyCurrencyEventSave(){
        $aAllitems = $this->input->post('aGetItem');
        echo '<pre>';
        print_r($aAllitems);
        echo '</pre>';        
        if(isset($aAllitems)){
            foreach($aAllitems as $nKey => $aVal){
                if($aVal['FCRteRate'] > 0){
                    if($aVal['FCRteRate'] == $aVal['nRteLast']){
                        $aVal['FCRteRate'] = $aVal['nRte'];
                    }else{
                        $aVal['FCRteRate'] = 1/(str_replace(',','',$aVal['FCRteRate'])); // 0.23 > 420
                    }
                }
                $this->Settingdairycurrency_model->FSaMCurentcyUpdate($aVal);
                $this->Settingdairycurrency_model->FSaMCurentcyTashUpdate($aVal);
            }
        }
    }

    //Event Use Default value ใช้แม่แบบ (แท็บตั้งค่าระบบ)
    public function FSxSETSettingUseDefaultValue(){
        $aReturn = $this->Settingdairycurrency_model->FSaMSETUseValueDefult();
        echo $aReturn;
    }

    //Event Save (แท็บตั้งค่าระบบ)
    public function FSxSETDailyCurrencyRefresh(){
        try{
            $tAgnCode           = $this->input->post('tAgnCode');
            $tUsrCode           = $this->input->post('tUsrCode');

            $aMQParams = [
                "queueName" => "CN_QTask",
                "tVhostType" => "M",
                "params"    => [
                    'ptFunction'        => 'SYNCEXCHANGERATE',
                    'ptSource'          => 'AdaStoreBack',
                    'ptDest'            => 'MQReceivePrc',
                    'ptFilter'          => '',
                    'ptData'            => json_encode([
                        "ptAgnCode"     => $tAgnCode,
                        "ptUsrCode"     => $this->session->userdata("tSesUsername"),
                    ]),
                    'ptConnStr'          => NULL,
                ]
            ];

            // print_r($aMQParams);
            // exit();

            // เชื่อม Rabbit MQ
            $nStaSendMQ = FCNxCallRabbitMQ($aMQParams);

            // print_r($nStaSendMQ);

            if ($nStaSendMQ == 1) {
                $aReturnData = array(
                    'nStaEvent'    => '1',
                );
            }else{
                $aReturnData = array(
                    'nStaEvent'    => '900',
                );
            }
            
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
            );
        }
        echo json_encode($aReturnData);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////// แท็บรหัสอัตโนมัติ

    //Get Page List (Content : แท็บรหัสอัตโนมัติ)
    public function FSvSETAutonumberGetPageListSearch(){
        $aOption = $this->Settingdairycurrency_model->FSaMSETGetAppTpye();
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

        $aItemRecord    = $this->Settingdairycurrency_model->FSaMSETConfigDataTableAutoNumber($aData);
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
        $aAllowItem  = $this->Settingdairycurrency_model->FSaMSETConfigGetAllowDataAutoNumber($aWhere);

        $aGenTable   = array(
            'aAlwEvent'         => $aAlwEvent,
            'aAllowItem'        => $aAllowItem,
            'nMaxFiledSizeBCH'  => $this->Settingdairycurrency_model->FSaMSETGetMaxLength('TCNMBranch'),
            'nMaxFiledSizePOS'  => $this->Settingdairycurrency_model->FSaMSETGetMaxLength('TCNMPos')
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
            $tResult = $this->Settingdairycurrency_model->FSaMSETAutoNumberDelete($aDelete);
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
            $this->Settingdairycurrency_model->FSaMSETAutoNumberDelete($aIns);

            //Insert
            $aResultInsert = $this->Settingdairycurrency_model->FSaMSETAutoNumberInsert($aIns);
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
        $aPackDataTsysconfig  = $this->Settingdairycurrency_model->FSaMSETExportDetailTsysconfig();

        //Get Data Tsysconfig_L
        $aPackDataTsysconfig_L = $this->Settingdairycurrency_model->FSaMSETExportDetailTSysConfig_L();

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
                $aDataDeleteTSysConfigTmp = $this->Settingdairycurrency_model->FSaMSETDeleteTSysConfigTmp();
                $aDataInsToTmpTSysConfig = $this->Settingdairycurrency_model->FSaMSETInsertToTmpTSysConfig();
                $aDataDeleteTSysConfig = $this->Settingdairycurrency_model->FSaMSETDeleteTSysConfig();
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

                    $aDataInsTSysConfig = $this->Settingdairycurrency_model->FSaMSETInsertTSysConfig($aDataInsTSysConfig);
                    }
                }

                if (!empty($tDataJSon[1]['tItem'])) {
                    $aDataDeleteTSysConfig_LTmp = $this->Settingdairycurrency_model->FSaMSETDeleteTSysConfig_LTmp();
                    $aDataInsToTmpTSysConfig_L = $this->Settingdairycurrency_model->FSaMSETInsertToTmpTSysConfig_L();
                    $aDataDeleteTSysConfig_LTmp = $this->Settingdairycurrency_model->FSaMSETDeleteTSysConfig_L();
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

                        $aDataInsTSysConfig_L = $this->Settingdairycurrency_model->FSaMSETInsertTSysConfig_L($aDataInsTSysConfig_L);
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
