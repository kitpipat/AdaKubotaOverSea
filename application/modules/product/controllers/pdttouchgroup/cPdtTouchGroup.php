<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class cPdtTouchGroup extends MX_Controller {
    
    /**
     * ภาษาที่เกี่ยวข้อง
     * @var array
    */
    public $aTextLang   = [];

    /**
     * Role User
     * @var array
    */
    public $aAlwEvent   = [];

    /**
     * Text Html Button Save
     * @var string
     * 
    */
    public $tBtnSave    = [];

    /**
     * Option Decimal Show
     * @var int
    */
    public $nOptDecimalShow = 0;

    /**
     * Option Decimal Save
     * @var int
    */
    public $nOptDecimalSave = 0;

    /**
     * Status Select Lang In DB
     * @var int
    */
    public $nLangEdit   = 1;

    /**
     * Text Html Button Save
     * @var string
     * 
    */
    public $tSesUserName = '';

    /**
     * Text Html Button Save
     * @var string
     * 
    */
    public $tBtnSaveStaActive   = '';


    public function __construct() {
        $this->FSxCInitParams();
        $this->load->model('product/pdttouchgroup/mPdtTouchGroup');
        parent::__construct();
    }

    // Init Params Lang
    private function FSxCInitParams(){
        // Text Lang Center
        $this->aTextLang  = [
            // Center  Main Lang
            'tBack'                 => language('common/main/main','tBack'),
            'tSave'                 => language('common/main/main','tSave'),
            'tShowData'             => language('common/main/main','tShowData'),
            'tPlaceholder'          => language('common/main/main','tPlaceholder'),
            'tCMNOption'            => language('common/main/main','tCMNOption'),
            'tDelAll'               => language('common/main/main','tDelAll'),
            'tCMNActionDelete'      => language('common/main/main','tCMNActionDelete'),
            'tCMNActionEdit'        => language('common/main/main','tCMNActionEdit'),
            'tCMNNotFoundData'      => language('common/main/main','tCMNNotFoundData'),
            'tResultTotalRecord'    => language('common/main/main','tResultTotalRecord'),
            'tRecord'               => language('common/main/main','tRecord'),
            'tCurrentPage'          => language('common/main/main','tCurrentPage'),
            'tModalDelete'          => language('common/main/main','tModalDelete'),
            'tModalConfirm'         => language('common/main/main','tModalConfirm'),
            'tModalCancel'          => language('common/main/main','tModalCancel'),
            'tGenerateAuto'         => language('common/main/main', 'tGenerateAuto'),
            // Lang Touch Group
            'tTCGTitleMenu'         => language('product/pdttouchgroup/pdttouchgroup','tTCGTitleMenu'),
            'tTCGTitleAdd'          => language('product/pdttouchgroup/pdttouchgroup','tTCGTitleAdd'),
            'tTCGTitleEdit'         => language('product/pdttouchgroup/pdttouchgroup','tTCGTitleEdit'),
            'tTCGSearch'            => language('product/pdttouchgroup/pdttouchgroup','tTCGSearch'),
            // Data Lang Table
            'tTCGTBChoose'          => language('product/pdttouchgroup/pdttouchgroup','tTCGTBChoose'),
            'tTCGTBCode'            => language('product/pdttouchgroup/pdttouchgroup','tTCGTBCode'),
            'tTCGTBName'            => language('product/pdttouchgroup/pdttouchgroup','tTCGTBName'),
            'tTCGTBStatus'          => language('product/pdttouchgroup/pdttouchgroup','tTCGTBStatus'),
            'tTCGTBStatus1'         => language('product/pdttouchgroup/pdttouchgroup','tTCGTBStatus1'),
            'tTCGTBStatus2'         => language('product/pdttouchgroup/pdttouchgroup','tTCGTBStatus2'),
            // Data Lang Form
            'tTCGCode'              => language('product/pdttouchgroup/pdttouchgroup','tTCGCode'),
            'tTCGCodePaceholder'    => language('product/pdttouchgroup/pdttouchgroup','tTCGCodePaceholder'),
            'tTCGPlsEnterOrRunCode' => language('product/pdttouchgroup/pdttouchgroup','tTCGPlsEnterOrRunCode'),
            'tTCGPlsCodeDuplicate'  => language('product/pdttouchgroup/pdttouchgroup','tTCGPlsCodeDuplicate'),
            'tTCGName'              => language('product/pdttouchgroup/pdttouchgroup','tTCGName'),
            'tTCGNamePaceholder'    => language('product/pdttouchgroup/pdttouchgroup','tTCGNamePaceholder'),
            'tTCGPlsEnterOrRunName' => language('product/pdttouchgroup/pdttouchgroup','tTCGPlsEnterOrRunName'),
            'tTCGRemark'            => language('product/pdttouchgroup/pdttouchgroup','tTCGRemark'),
            'tTCGStatusUse'         => language('product/pdttouchgroup/pdttouchgroup','tTCGStatusUse'),
            'tTCGLogo'              => language('product/pdttouchgroup/pdttouchgroup','tTCGLogo'),
        ];
        $this->aAlwEvent            = FCNaHCheckAlwFunc('pdtTouchGroup/0/0');
        $this->tBtnSave             = FCNaHBtnSaveActiveHTML('pdtTouchGroup/0/0');
        $this->nOptDecimalShow      = FCNxHGetOptionDecimalShow();
        $this->nOptDecimalSave      = FCNxHGetOptionDecimalSave();
        $this->nLangEdit            = $this->session->userdata("tLangEdit");
        $this->tSesUserName         = $this->session->userdata('tSesUsername');
        $this->tBtnSaveStaActive    = $this->session->userdata('tBtnSaveStaActive');
    }

    public function index($nTCGBrowseType,$tTCGBrowseOption){
        $aDataConfigView    = [
            'nTCGBrowseType'    => $nTCGBrowseType,
            'tTCGBrowseOption'  => $tTCGBrowseOption,
            'vBtnSave'          => $this->tBtnSave,
            'aAlwEvent'         => $this->aAlwEvent,
            'aTextLang'         => $this->aTextLang
        ];
        $this->load->view('product/pdttouchgroup/wPdtTouchGroup',$aDataConfigView);
    }

    // Functionality: Function Call Page List
    // Parameters: Ajax and Function Parameter
    // Creator: 06/01/2020 wasin(Yoshi)
    // Return: String View
    // ReturnType: View
    public function FSvCTCGCallPageMain(){
        $aDataConfigView    =  [
            'nOptDecimalShow'   => $this->nOptDecimalShow,
            'nOptDecimalSave'   => $this->nOptDecimalSave,
            'aAlwEvent'         => $this->aAlwEvent,
            'aTextLang'         => $this->aTextLang
        ];
        $this->load->view('product/pdttouchgroup/wPdtTouchGroupMain',$aDataConfigView);
    }

    // Functionality : Function Call Page Data Table
    // Parameters : Ajax and Function Parameter
    // Creator : 06/01/2020 wasin(Yoshi)
    // Return : Object View Data Table
    // Return Type : object
    public function FSvCTCGCallPageDataTable() {
        try{
            $tSearchAll = $this->input->post('ptSearchAll');
            $nPage      = $this->input->post('pnPageCurrent');
            // Check Page Current 
            if($nPage == '' || $nPage == null){$nPage = 1;} else {$nPage = $this->input->post('pnPageCurrent');}
            // Data Codition Where Table List
            $aDataCondition = [
                'nLngID'        => $this->nLangEdit,
                'nPage'         => $nPage,
                'nRow'          => 10,
                'tSearchAll'    => $tSearchAll,
            ];
            $aDataList  = $this->mPdtTouchGroup->FSaMTCGDataTableList($aDataCondition);
            $aConfigView    = [
                'nPage'     => $nPage,
                'aAlwEvent' => $this->aAlwEvent,
                'aTextLang' => $this->aTextLang,
                'aDataList' => $aDataList,
            ];
            $tTCGViewDataTableList  = $this->load->view('product/pdttouchgroup/wPdtTouchGroupDataTable',$aConfigView,true);
            $aReturnData = array(
                'tTCGViewDataTableList' => $tTCGViewDataTableList,
                'nStaEvent' => '1',
                'tStaMessg' => 'Success'
            );
        }catch (Exception $Error) {
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        unset($tSearchAll);
        unset($nPage);
        unset($aDataCondition);
        unset($aDataList);
        unset($aConfigView);
        unset($tTCGViewDataTableList);
        echo json_encode($aReturnData);
    }

    // Functionality : Function Call Page Add
    // Parameters : Ajax and Function Parameter
    // Creator : 07/01/2020 wasin(Yoshi)
    // Return : Object View Page Add
    // Return Type : object
    public function FSvCTCGCallPageAdd(){
        $aDataConfigViewAdd = [
            'aTextLang'     => $this->aTextLang,
            'aAlwEvent'     => $this->aAlwEvent,
            'aDataResult'   => array('rtCode' => '800'),
        ];
        $tTCGViewPageAdd    = $this->load->view('product/pdttouchgroup/wPdtTouchGroupPageForm',$aDataConfigViewAdd,true);
        $aReturnData        = [
            'tTCGViewPageAdd'   => $tTCGViewPageAdd,
            'nStaEvent'         => '1',
            'tStaMessg'         => 'Success'
        ];
        unset($aDataConfigViewAdd);
        unset($tTCGViewPageAdd);
        echo json_encode($aReturnData);
    }

    // Functionality : Function Call Page Edit
    // Parameters : Ajax and Function Parameter
    // Creator : 07/01/2020 wasin(Yoshi)
    // Return : Object View Page Add
    // Return Type : object
    public function FSvCTCGCallPageEdit(){
        $aDataWhere = array(
            'tTcgCode'  => $this->input->post('ptTcgCode'),
            'nLngID'    => $this->nLangEdit
        );
        $aDataResult    = $this->mPdtTouchGroup->FSaMTCGGetDataByID($aDataWhere);
        if(isset($aDataResult['raItems']['FTImgObj']) && !empty($aDataResult['raItems']['FTImgObj'])){
            $tImgObj        = $aDataResult['raItems']['FTImgObj'];
            $aImgObj		= explode("application/modules/",$tImgObj);
            $aImgObjName	= explode("/",$tImgObj);
            $tImgObjAll     = $aImgObj[1];
            $tImgName		= end($aImgObjName);
        }else{
            $tImgObjAll     = "";
            $tImgName       = "";
        }
        $aDataConfigViewEdit = [
            'tImgObj'       => $tImgObjAll,
            'tImgName'      => $tImgName,
            'aTextLang'     => $this->aTextLang,
            'aAlwEvent'     => $this->aAlwEvent,
            'aDataResult'   => $aDataResult
        ];
        $tTCGViewPageEdit   = $this->load->view('product/pdttouchgroup/wPdtTouchGroupPageForm',$aDataConfigViewEdit,true);
        $aReturnData        = [
            'tTCGViewPageEdit'  => $tTCGViewPageEdit,
            'nStaEvent'         => '1',
            'tStaMessg'         => 'Success'
        ];
        unset($aDataWhere);
        unset($aDataResult);
        unset($tImgObj);
        unset($aImgObjName);
        unset($tImgObjAll);
        unset($tImgName);
        unset($aDataConfigViewEdit);
        unset($tTCGViewPageEdit);
        echo json_encode($aReturnData);
    }
    
    // Functionality : Event Add
    // Parameters : Ajax and Function Parameter
    // Creator : 07/01/2020 wasin(Yoshi)
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCTCGEventAdd(){
        $this->db->trans_begin();
        $tTCGImage      = trim($this->input->post('oetImgInputTCG'));
        $tTCGImageeOld  = trim($this->input->post('oetImgInputTCGOld'));
        $tIsAutoGenCode = (!empty($this->input->post('ocbTCGStaAutoGenCode')))? 1 : 0;
        $tTCGCode       = "";
        if(isset($tIsAutoGenCode) && $tIsAutoGenCode == '1'){
            $aGenCode = FCNaHGenCodeV5('TCNMPdtTouchGrp');
            if($aGenCode['rtCode'] == '1'){
                $tTCGCode   = $aGenCode['rtTcgCode'];
            }
        }else{
            $tTCGCode   = $this->input->post('oetTCGCode');
        }
        $aDataMaster    = [
            'FTImgObj'      => $this->input->post('oetImgInputTCG'),
            'FTTcgCode'     => $tTCGCode,
            'FTTcgStaUse'   => (!empty($this->input->post('ocbTCGStatusUse')))? 1 : 2,
            'FTTcgName'     => $this->input->post('oetTCGName'),
            'FTTcgRmk'      => $this->input->post('otaTCGRemark'),
            'FNLngID'       => $this->nLangEdit,
            'FTLastUpdBy'   => $this->tSesUserName,
            'FTCreateBy'    => $this->tSesUserName,
        ];
        $this->mPdtTouchGroup->FSaMTCGAddDataMaster($aDataMaster);
        if($this->db->trans_status() === false){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess Insert"
            );
        }else{
            $this->db->trans_commit();
            // Check Image New Compare Image Old (เช็คข้อมูลรูปภาพใหม่ต้องไม่ตรงกับรูปภาพเก่าในระบบ)
            if($tTCGImage != $tTCGImageeOld){
                $aImageUplode   = array(
                    'tModuleName'       => 'product',
                    'tImgFolder'        => 'pdttouchgroup',
                    'tImgRefID'         => $aDataMaster['FTTcgCode'],
                    'tImgObj'           => $tTCGImage,
                    'tImgTable'         => 'TCNMPdtTouchGrp',
                    'tTableInsert'      => 'TCNMImgObj',
                    'tImgKey'           => 'master',
                    'dDateTimeOn'       => date('Y-m-d H:i:s'),
                    'tWhoBy'            => $this->tSesUserName,
                    'nStaDelBeforeEdit' => 1
                );
                FCNnHAddImgObj($aImageUplode);
            }
            $aReturn = array(
                'nStaCallBack'	=> $this->tBtnSaveStaActive,
                'tCodeReturn'	=> $aDataMaster['FTTcgCode'],
                'nStaEvent'	    => '1',
                'tStaMessg'		=> 'Success Insert'
            );
        }
        unset($tTCGImage);
        unset($tTCGImageeOld);
        unset($tIsAutoGenCode);
        unset($tTCGCode);
        unset($aGenCode);
        unset($aDataMaster);
        unset($aImageUplode);
        echo json_encode($aReturn);
    }

    // Functionality : Event Edit
    // Parameters : Ajax and Function Parameter
    // Creator : 07/01/2020 wasin(Yoshi)
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCTCGEventEdit(){
        $this->db->trans_begin();
        $tTCGImage      = trim($this->input->post('oetImgInputTCG'));
        $tTCGImageeOld  = trim($this->input->post('oetImgInputTCGOld'));
        $tTCGCode       = $this->input->post('oetTCGCode');
        $aDataMaster    = [
            'FTImgObj'      => $this->input->post('oetImgInputTCG'),
            'FTTcgCode'     => $tTCGCode,
            'FTTcgStaUse'   => (!empty($this->input->post('ocbTCGStatusUse')))? 1 : 2,
            'FTTcgName'     => $this->input->post('oetTCGName'),
            'FTTcgRmk'      => $this->input->post('otaTCGRemark'),
            'FNLngID'       => $this->nLangEdit,
            'FTLastUpdBy'   => $this->tSesUserName,
            'FTCreateBy'    => $this->tSesUserName,
        ];
        $this->mPdtTouchGroup->FSaMTCGUpdateDataMaster($aDataMaster);
        if($this->db->trans_status() === false){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess Update"
            );
        }else{
            $this->db->trans_commit();
            // Check Image New Compare Image Old (เช็คข้อมูลรูปภาพใหม่ต้องไม่ตรงกับรูปภาพเก่าในระบบ)
            if($tTCGImage != $tTCGImageeOld){
                $aImageUplode   = array(
                    'tModuleName'       => 'product',
                    'tImgFolder'        => 'pdttouchgroup',
                    'tImgRefID'         => $aDataMaster['FTTcgCode'],
                    'tImgObj'           => $tTCGImage,
                    'tImgTable'         => 'TCNMPdtTouchGrp',
                    'tTableInsert'      => 'TCNMImgObj',
                    'tImgKey'           => 'master',
                    'dDateTimeOn'       => date('Y-m-d H:i:s'),
                    'tWhoBy'            => $this->tSesUserName,
                    'nStaDelBeforeEdit' => 1
                );
                FCNnHAddImgObj($aImageUplode);
            }
            $aReturn = array(
                'nStaCallBack'	=> $this->tBtnSaveStaActive,
                'tCodeReturn'	=> $aDataMaster['FTTcgCode'],
                'nStaEvent'	    => '1',
                'tStaMessg'		=> 'Success Update'
            );
        }
        unset($tTCGImage);
        unset($tTCGImageeOld);
        unset($tTCGCode);
        unset($aDataMaster);
        unset($aImageUplode);
        echo json_encode($aReturn);
    }

    // Functionality : Event Edit
    // Parameters : Ajax and Function Parameter
    // Creator : 07/01/2020 wasin(Yoshi)
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCTCGEventDelete(){
        try{
            $tIDCode    = $this->input->post('ptIDCode');
            $aDataWhere = array(
                'FTTcgCode' => $tIDCode
            );
            $aStaDelete     = $this->mPdtTouchGroup->FSnMTCGEventDelete($aDataWhere);
            if($aStaDelete['rtCode'] == 1){
                $aDeleteImage = array(
                    'tModuleName'   => 'product',
                    'tImgFolder'    => 'pdttouchgroup',
                    'tImgRefID'     => $tIDCode,
                    'tTableDel'     => 'TCNMImgObj',
                    'tImgTable'     => 'TCNMPdtTouchGrp'
                );
                $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
                if($nStaDelImgInDB == 1){
                    FSnHDeleteImageFiles($aDeleteImage);
                }
            }
            $aReturn    = array(
                'nStaEvent' => $aStaDelete['rtCode'],
                'tStaMessg' => $aStaDelete['rtDesc'],
            );
        }catch(Exception $Error){
            $aReturn    = array(
                'nStaEvent' => '500',
                'tStaMessg' => 'Error Delete Product Touch Group.'
            );
        }
        unset($tIDCode);
        unset($aDataWhere);
        unset($aStaDelete);
        unset($aDeleteImage);
        unset($nStaDelImgInDB);
        echo json_encode($aReturn);
    }


}
