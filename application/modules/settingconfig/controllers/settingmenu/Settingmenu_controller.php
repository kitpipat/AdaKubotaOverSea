<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settingmenu_controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('settingconfig/settingmenu/Settingmenu_model');
    }

    public function index($nSettingMenuBrowseType, $tSettingMenuBrowseOption)
    {
        $aDataConfigView = [
            'nSettingMenuBrowseType' => $nSettingMenuBrowseType,
            'tSettingMenuBrowseOption' => $tSettingMenuBrowseOption,
            'aAlwEvent' => FCNaHCheckAlwFunc('settingmenu/0/0'),
            'vBtnSave' => FCNaHBtnSaveActiveHTML('settingmenu/0/0'),
            'nOptDecimalShow' => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave' => FCNxHGetOptionDecimalSave(),
        ];
        $this->load->view('settingconfig/settingmenu/wSettingmenuAndReport', $aDataConfigView);
    }

    //Functionality : Function CallPage Settingmenu
    //Parameters : -
    //Creator : 14/08/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSMUGetPageSettingmenu()
    {
        try {
            $nLangEdit = $this->session->userdata("tLangEdit");
            $aParams = array(
                'FNLngID' => $nLangEdit,
            );

            $aDataMenuList = $this->Settingmenu_model->FSaMSMUGetListMenu($aParams);

            $aData = [
                'aDataMenuList' => $aDataMenuList,
            ];
            // print_r($aData);
            $this->load->view('settingconfig/settingmenu/menu/wSettingmenuTable', $aData);
            $aReturnData = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Success',
            );

        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage(),
            );
        }

    }

    //Functionality : Function CheckDupCode
    //Parameters : -
    //Creator : 10/09/2020 Sooksanti(Nont)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSMUCheckDupCode()
    {
        try {
            $nLangEdit = $this->session->userdata("tLangEdit");
            $tTableName = $this->input->post('tTableName');
            $ptFieldName = $this->input->post('tFieldName');
            $tCode = $this->input->post('tCode');
            $aParams = array(
                'tTableName' => $this->input->post('tModCode'),
                'tTableName' => $this->input->post('tModName'),
                'ptFieldName' => 1,
                'tCode' => $this->input->post('tModSeq'),
                'FNLngID' => $nLangEdit,
            );

            $this->db->trans_begin();
            $aDataModdule = $this->Settingmenu_model->FSaMSMUEditModule($aParams);
            $aDataModdule_L = $this->Settingmenu_model->FSaMSMUEditModule_L($aParams);
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Unsucess Add Event",
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success Add Event',
                );
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Function Add Module
    //Parameters : -
    //Creator : 21/08/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSMUAddEditModule()
    {
        try {
            $nLangEdit = $this->session->userdata("tLangEdit");
            $aParams = array(
                'FTGmnModCode' => $this->input->post('tModCode'),
                'FTGmnModName' => $this->input->post('tModName'),
                'FTGmnModStaUse' => 1,
                'FNGmnModShwSeq' => $this->input->post('tModSeq'),
                'FTGmmModPathIcon' => $this->input->post('tModPathIcon'),
                'FTGmmModColorBtn' => '',
                'FNLngID' => $nLangEdit,
            );

            $this->db->trans_begin();
            $this->Settingmenu_model->FSaMSMUAddEditModule($aParams);
            $this->Settingmenu_model->FSaMSMUAddEditModule_L($aParams);
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Unsucess Add Event",
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success Add Event',
                );
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Function Get Editmodule
    //Parameters : -
    //Creator : 21/08/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSMUCallModalEditModule()
    {
        try {
            $nLangEdit = $this->session->userdata("tLangEdit");
            $aParams = array(
                'FTGmnModCode' => $this->input->post('tModCode'),
                'FNLngID' => $nLangEdit,
            );

            $aDataModdule = $this->Settingmenu_model->FSaMSMUCallModalEditModule($aParams);

            $aData = $aDataModdule;
            echo json_encode($aData);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Function Delete Module
    //Parameters : -
    //Creator : 21/08/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSMUDelModule()
    {
        try {
            $aParams = array(
                'FTGmnModCode' => $this->input->post('tCode'),
            );

            $aStaDelModule = $this->Settingmenu_model->FSaMSMUModuleDeleteData($aParams);
            if ($aStaDelModule['rtCode'] == '1') {
                $aReturnData = array(
                    'nStaEvent' => $aStaDelModule['rtCode'],
                    'tStaMessg' => $aStaDelModule['rtDesc'],
                );
            } else {
                throw new Exception(array(
                    'tCodeReturn' => $aStaDelModule['rtCode'],
                    'tTextStaMessg' => $aStaDelModule['rtDesc'],
                ));
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => $Error['tCodeReturn'],
                'tStaMessg' => $Error['tTextStaMessg'],
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality : Function AddEdit MenuGrp
    //Parameters : -
    //Creator : 21/08/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSMUAddEditMenuGrp()
    {
        try {
            $nLangEdit = $this->session->userdata("tLangEdit");
            $aParams = array(
                'FTGmnCode' => $this->input->post('tMenuGrpCode'),
                'FNLngID' => $nLangEdit,
                'FTGmnName' => $this->input->post('tMenuGrpName'),
                'FNGmnShwSeq' => $this->input->post('tMenuGrpSeq'),
                'FTGmnStaUse' => 1,
                'FTGmnModCode' => $this->input->post('tModCode'),
            );
            $this->db->trans_begin();
            $this->Settingmenu_model->FSaMSMUAddEditMenuGrp($aParams);
            $this->Settingmenu_model->FSaMSMUUpdateTSysMenuGrp($aParams);
            $this->Settingmenu_model->FSaMSMUAddEditMenuGrp_L($aParams);
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Unsucess Add Event",
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success Add Event',
                );
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Function Get EditMenuGrp
    //Parameters : -
    //Creator : 21/08/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSMUCallModalEditMenuGrp()
    {
        try {
            $nLangEdit = $this->session->userdata("tLangEdit");
            $aParams = array(
                'FTGmnCode' => $this->input->post('tMenuGrpCode'),
                'FNLngID' => $nLangEdit,
            );

            $aDataModdule = $this->Settingmenu_model->FSaMSMUCallModalEditMenuGrp($aParams);

            $aData = $aDataModdule;
            echo json_encode($aData);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Function Delete MenuGrp
    //Parameters : -
    //Creator : 21/08/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSMUDelMenuGrp()
    {
        try {
            $aParams = array(
                'FTGmnCode' => $this->input->post('tCode'),
            );

            $aStaDelModule = $this->Settingmenu_model->FSaMSMUMenuGrpDeleteData($aParams);
            if ($aStaDelModule['rtCode'] == '1') {
                $aReturnData = array(
                    'nStaEvent' => $aStaDelModule['rtCode'],
                    'tStaMessg' => $aStaDelModule['rtDesc'],
                );
            } else {
                throw new Exception(array(
                    'tCodeReturn' => $aStaDelModule['rtCode'],
                    'tTextStaMessg' => $aStaDelModule['rtDesc'],
                ));
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => $Error['tCodeReturn'],
                'tStaMessg' => $Error['tTextStaMessg'],
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality : Function AddEdit MenuList
    //Parameters : -
    //Creator : 21/08/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSMUAddEditMenuList()
    {
        try {
            $nLangEdit = $this->session->userdata("tLangEdit");
            $tSesUsrRoleCodeMulti = $this->session->userdata('tSesUsrRoleCodeMulti');
            $aParams = array(
                'FTRolCode' => $tSesUsrRoleCodeMulti,
                'FTMnuCode' => $this->input->post('tMnuCode'),
                'FTMnuName' => $this->input->post('tMnuName'),
                'FTMnuRmk' => $this->input->post('tMnuRmk'),
                'FTGmnCode' => $this->input->post('tGmnCode'),
                'FTGmnModCode' => $this->input->post('tModCode'),
                'FTMnuCtlName' => $this->input->post('tMnuCtlName'),
                'FNMnuSeq' => $this->input->post('tMnuSeq'),
                'FNMnuLevel' => $this->input->post('nMnuLevel'),
                'FNLngID' => $nLangEdit,

                'FTAutStaRead' => $this->input->post('nAutStaRead'),
                'FTAutStaAdd' => $this->input->post('nAutStaAdd'),
                'FTAutStaDelete' => $this->input->post('nAutStaDelete'),
                'FTAutStaEdit' => $this->input->post('nAutStaEdit'),
                'FTAutStaCancel' => $this->input->post('nAutStaCancel'),
                'FTAutStaAppv' => $this->input->post('nAutStaAppv'),
                'FTAutStaPrint' => $this->input->post('nAutStaPrint'),
                'FTAutStaPrintMore' => $this->input->post('nAutStaPrintMore'),
            );

            $this->db->trans_begin();
            $this->Settingmenu_model->FSaMSMUAddEditMenuList($aParams);
            $this->Settingmenu_model->FSaMSMUAddEditMenuList_L($aParams);
            $this->Settingmenu_model->FSaMSMUAddEditTSysMenuAlbAct($aParams);
            $this->Settingmenu_model->FSaMSMUAddEditTCNTUsrMenu($aParams);
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Unsucess Add Event",
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success Add Event',
                );
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Function Get EditMenuList
    //Parameters : -
    //Creator : 21/08/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSMUCallModalEditMenuList()
    {
        try {
            $nLangEdit = $this->session->userdata("tLangEdit");
            $aParams = array(
                'FTMnuCode' => $this->input->post('tMenuListCode'),
                'FNLngID' => $nLangEdit,
            );

            $aDataModdule = $this->Settingmenu_model->FSaMSMUCallModalEditMenuList($aParams);

            $aData = $aDataModdule;
            echo json_encode($aData);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Function Delete Menulist
    //Parameters : -
    //Creator : 21/08/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSMUDelMenuList()
    {
        try {
            $aParams = array(
                'FTMnuCode' => $this->input->post('tCode'),
            );

            $aStaDelModule = $this->Settingmenu_model->FSaMSMUMenuListDeleteData($aParams);
            if ($aStaDelModule['rtCode'] == '1') {
                $aReturnData = array(
                    'nStaEvent' => $aStaDelModule['rtCode'],
                    'tStaMessg' => $aStaDelModule['rtDesc'],
                );
            } else {
                throw new Exception(array(
                    'tCodeReturn' => $aStaDelModule['rtCode'],
                    'tTextStaMessg' => $aStaDelModule['rtDesc'],
                ));
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => $Error['tCodeReturn'],
                'tStaMessg' => $Error['tTextStaMessg'],
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality : Function Update StaUse
    //Parameters : -
    //Creator : 21/08/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSMUUpdateStaUse()
    {
        try {
            $aParams = array(
                'tTableName' => $this->input->post('tTableName'),
                'tFieldWhere' => $this->input->post('tFieldWhere'),
                'tFieldName' => $this->input->post('tFieldName'),
                'tCode' => $this->input->post('tCode'),
                'nValue' => $this->input->post('nValue'),
            );
            $aData = $this->Settingmenu_model->FSaMSMUUpdateStaUse($aParams);

            if ($aData['rtCode'] == '1') {
                $aReturnData = array(
                    'nStaEvent' => $aData['rtCode'],
                    'tStaMessg' => $aData['rtDesc'],
                );
            } else {
                throw new Exception(array(
                    'tCodeReturn' => $aData['rtCode'],
                    'tTextStaMessg' => $aData['rtDesc'],
                ));
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => $Error['tCodeReturn'],
                'tStaMessg' => $Error['tTextStaMessg'],
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality : Get MaxSequence
    //Parameters : -
    //Creator : 21/08/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSMUCallMaxSequence()
    {
        try {
            $aParams = array(
                'tTableName' => $this->input->post('tTableName'),
                'tFieldWhere' => $this->input->post('tFieldWhere'),
                'tFieldName' => $this->input->post('tFieldName'),
                'tCode' => $this->input->post('tCode'),
            );
            $aData = $this->Settingmenu_model->FSaMSMUCallMaxSequence($aParams);

            if ($aData['rtCode'] == '1') {
                $aReturnData = array(
                    'aData' => $aData['raItems'],
                    'nStaEvent' => $aData['rtCode'],
                    'tStaMessg' => $aData['rtDesc'],
                );
            } else {
                throw new Exception(array(
                    'tCodeReturn' => $aData['rtCode'],
                    'tTextStaMessg' => $aData['rtDesc'],
                ));
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => $Error['tCodeReturn'],
                'tStaMessg' => $Error['tTextStaMessg'],
            );
        }
        echo json_encode($aReturnData);
    }
}
