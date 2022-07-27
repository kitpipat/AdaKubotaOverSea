<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settingreport_controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('settingconfig/settingmenu/Settingreport_model');
    }

    //Functionality : Function CallTable Settingreport
    //Parameters : -
    //Creator : 15/09/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSRTGetPageSettingreport()
    {
        try {
            $nLangEdit = $this->session->userdata("tLangEdit");
            $aParams = array(
                'FNLngID' => $nLangEdit,
            );

            $aDataMenuList = $this->Settingreport_model->FSaMSMUGetListReport($aParams);

            $aData = [
                'aDataMenuList' => $aDataMenuList,
                'nStaEvent' => '1',
                'tStaMessg' => 'Success',
            ];

            $this->load->view('settingconfig/settingmenu/report/wSettingreportTable', $aData);

        } catch (Exception $Error) {
            $aData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage(),
            );
        }

    }

    //Functionality : Get MaxSequence And GenCode Report
    //Parameters : -
    //Creator : 15/09/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSRTCallMaxSequence()
    {
        try {
            $aParams = array(
                'tTableName' => $this->input->post('tTableName'),
                'tFieldWhere' => $this->input->post('tFieldWhere'),
                'tFieldSeq' => $this->input->post('tFieldSeq'),
                'tCode' => $this->input->post('tCode'),
                // 'tFieldCode' => $this->input->post('tFieldCode'),
            );

            $aData = $this->Settingreport_model->FSaMSRTCallMaxSequenceRpt($aParams);

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

    //Functionality : Function AddEdit Module Report
    //Parameters : -
    //Creator : 16/09/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSRTReportAddUpdateModule()
    {
        try {
            $nLangEdit = $this->session->userdata("tLangEdit");
            $aParams = array(
                'FTGrpRptModCode' => $this->input->post('tRptModCode'),
                'FNGrpRptModName' => $this->input->post('tRptModName'),
                'FTGrpRptModStaUse' => 1,
                'FNGrpRptModShwSeq' => $this->input->post('tRptModShwSeq'),
                'FTGrpRptModRoute' => $this->input->post('tRptModUrl'),
                'FNLngID' => $nLangEdit,
            );

            $this->db->trans_begin();
            $this->Settingreport_model->FSaMSRTAddEditModuleRpt($aParams);
            $this->Settingreport_model->FSaMSRTAddEditModuleRpt_L($aParams);
            $this->Settingreport_model->FSaMSRTAddEditMenuList($aParams);
            $this->Settingreport_model->FSaMSRTAddEditMenuList_L($aParams);
            $this->Settingreport_model->FSaMSRTAddEditTSysMenuAlbAct($aParams);
            $this->Settingreport_model->FSaMSRTAddEditTCNTUsrMenu($aParams);
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

    //Functionality : Function Call Edit Modal Module Report
    //Parameters : -
    //Creator : 16/09/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSRTReportCallMoalEditModulRpt()
    {
        try {
            $nLangEdit = $this->session->userdata("tLangEdit");
            $aParams = array(
                'tCode' => $this->input->post('tCode'),
                'FNLngID' => $nLangEdit,
            );

            $aData = $this->Settingreport_model->FSaMSRTReportCallEdit($aParams);

            if ($aData['rtCode'] == '1') {
                $aReturnData = array(
                    'nStaEvent' => $aData['rtCode'],
                    'tStaMessg' => $aData['rtDesc'],
                    'raItems' => $aData['raItems'],
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

    //Functionality : Function Delete ModuleReport
    //Parameters : -
    //Creator : 17/09/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSRTDelModuleReport()
    {
        try {
            $aParams = array(
                'FTGrpRptModCode' => $this->input->post('tCode'),
            );

            $aStaDelModule = $this->Settingreport_model->FSaMSRTModuleDeleteData($aParams);
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

    //Functionality : Function AddEdit ReportGrp
    //Parameters : -
    //Creator : 17/09/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSRTAddEditRptGrp()
    {
        try {
            $nLangEdit = $this->session->userdata("tLangEdit");
            $aParams = array(
                'FTGrpRptCode' => $this->input->post('tRptGrpCode'),
                'FNLngID' => $nLangEdit,
                'FTGrpRptName' => $this->input->post('tRptGrpName'),
                'FNGrpRptShwSeq' => $this->input->post('tRptGrpShwSeq'),
                'FTGrpRptStaUse' => 1,
                'FTGrpRptModCode' => $this->input->post('tModCode'),
            );
            $this->db->trans_begin();
            $this->Settingreport_model->FSaMRRTAddEditReportGrp($aParams);
            $this->Settingreport_model->FSaMRRTUpdateReportGrp($aParams);
            $this->Settingreport_model->FSaMRRTAddEditReportGrp_L($aParams);
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

    //Functionality : Function Get EditRptGrp
    //Parameters : -
    //Creator : 17/09/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSRTCallModalEditRptGrp()
    {
        try {
            $nLangEdit = $this->session->userdata("tLangEdit");
            $aParams = array(
                'FTGrpRptCode' => $this->input->post('tCode'),
                'FNLngID' => $nLangEdit,
            );

            $aData = $this->Settingreport_model->FSaMSRTReportGrpCallEdit($aParams);
            echo json_encode($aData);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Function Delete ReportGrp
    //Parameters : -
    //Creator : 17/09/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSRTDelReportGrp()
    {
        try {
            $aParams = array(
                'FTGrpRptCode' => $this->input->post('tCode'),
            );

            $aStaDelModule = $this->Settingreport_model->FSaMSRTRptGrpDeleteData($aParams);
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

    //Functionality : Function AddEdit menu Report
    //Parameters : -
    //Creator : 18/09/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSRTReportAddUpdateMenu()
    {
        try {
            $nLangEdit = $this->session->userdata("tLangEdit");
            $aParams = array(
                'FTGrpRptModCode' => $this->input->post('tModCode'),
                'FTGrpRptCode' => $this->input->post('tMenuGrpCode'),
                'FTRptCode' => $this->input->post('tRptMenuCode'),
                'FTRptName' => $this->input->post('tRptMenuName'),
                'FTRptRoute' => $this->input->post('tRptMenuUrl'),
                'FTRptFilterCol' => $this->input->post('tRptFilter'),
                'FTRptStaUse' => 1,
                'FTRptSeqNo' => $this->input->post('tRptMenuSeq'),
                'FNLngID' => $nLangEdit,
            );

            $this->db->trans_begin();
            $this->Settingreport_model->FSaMSMUAddEditTSysReport($aParams);
            $this->Settingreport_model->FSaMSMUAddEditTSysReport_L($aParams);
            $this->Settingreport_model->FSaMRRTAddEditUsrFuncRpt($aParams);
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

    //Functionality : Function Get EditRptMenu
    //Parameters : -
    //Creator : 18/09/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSRTCallModalEditRptMenu()
    {
        try {
            $nLangEdit = $this->session->userdata("tLangEdit");
            $aParams = array(
                'FTRptCode' => $this->input->post('tCode'),
                'FNLngID' => $nLangEdit,
            );

            $aDataRptMenu = $this->Settingreport_model->FSaMSRTReportMenuCallEdit($aParams);
            $aDataRptFilter = $this->Settingreport_model->FSaMSRTReportFilterCallEdit($aParams);

            $aData = array(
                'oReport' => $aDataRptMenu,
                'oReportFilter' => $aDataRptFilter,
            );
            echo json_encode($aData);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Function Delete MenuReport
    //Parameters : -
    //Creator : 18/09/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSRTDelMenuReport()
    {
        try {
            $aParams = array(
                'FTRptCode' => $this->input->post('tCode'),
            );

            $aStaDel = $this->Settingreport_model->FSaMSRTMenuReportDeleteData($aParams);
            if ($aStaDel['rtCode'] == '1') {
                $aReturnData = array(
                    'nStaEvent' => $aStaDel['rtCode'],
                    'tStaMessg' => $aStaDel['rtDesc'],
                );
            } else {
                throw new Exception(array(
                    'tCodeReturn' => $aStaDel['rtCode'],
                    'tTextStaMessg' => $aStaDel['rtDesc'],
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


    //Functionality : Get GenCode Report
    //Parameters : -
    //Creator : 15/09/2020 Sooksanti(Non)
    //Last Modified :-
    //Return :-
    //Return Type : -
    public function FSxCSRTGencode()
    {
        try {
            $aParams = array(
                'tTableName' => $this->input->post('tTableName'),
                'tFieldWhere' => $this->input->post('tFieldWhere'),
                'tCode' => $this->input->post('tCode'),
                'tFieldCode' => $this->input->post('tFieldCode'),
            );
            
            $aData = $this->Settingreport_model->FSaMSRTGencode($aParams);

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
