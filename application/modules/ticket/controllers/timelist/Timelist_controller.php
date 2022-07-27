<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Timelist_controller extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ticket/timelist/mTimeList', 'mTimeList');
        $this->load->library("session");
    }

    public function FSxCTLTHD($nEvnID, $nLocID) {
        $oEvent = $this->Timelist_model->FSxMTLTEvent($nEvnID);
        $oLoc = $this->Timelist_model->FSxMTLTLoc($nLocID);
        $oHD = $this->Timelist_model->FSxMTLTHD();
        $oAuthen = FCNaHCheckAlwFunc('EticketEvent');
        $this->load->view('ticket/timelist/wTimeList', array(
            'oAuthen' => $oAuthen,
            'nEvnID' => $nEvnID,
            'nLocID' => $nLocID,
            'oEvent' => $oEvent,
            'oLoc' => $oLoc,
            'oHD' => $oHD
        ));
    }

    public function FSxCTLTPickList() {
        if ($this->input->post('orbFNTmhID')) {
            $nFNTmhID = $this->input->post('orbFNTmhID');
            $oPickList = $this->Timelist_model->FSxMTLTPickList($nFNTmhID);
            if (@$oPickList [0]->FNTmdID != "") {
                echo '<p style="font-size: 18px;">' . language('ticket/event/event', 'tEventInformation') . '</p>';
                foreach (@$oPickList as $key => $oValue) {
                    echo '<div style="padding-top: 5px; padding-bottom: 5px;">' . $oValue->FTTmdName . ' &nbsp; ' . $oValue->FTTmdStartTime . ' - ' . $oValue->FTTmdEndTime . '</div>';
                }
            } else {
                echo '';
            }
        }
    }

    // รอบปกติ
    public function FSxCTLTTimeTableSTAjaxList() {
        $tFTTmhName = $this->input->post('tFTTmhName');
        $nEventId = $this->input->post('nEventId');
        $nLocId = $this->input->post('nLocId');
        $nPageNo = $this->input->post('nPageNo');
        $nPageActive = $nPageNo;
        $oList = $this->Timelist_model->FSxMTLTTimeTableSTAjaxList($tFTTmhName, $nEventId, $nLocId, $nPageActive);
        $oAuthen = FCNaHCheckAlwFunc('EticketEvent');
        $this->load->view('ticket/timelist/wTimeTableList', array(
            'oAuthen' => $oAuthen,
            'oList' => $oList
        ));
    }

    public function FStCTLTTimeTableSTCount() {
        $tFTTmhName = $this->input->post('tFTTmhName');
        $nEventId = $this->input->post('nEventId');
        $nLocId = $this->input->post('nLocId');
        $oCnt = $this->Timelist_model->FStMTLTTimeTableSTCount($tFTTmhName, $nEventId, $nLocId);
        $tCount = $oCnt [0]->counts;
        echo $tCount;
    }

    public function FSxCTLTTimeTableSTAdd($nEvnID, $nLocID) {
        $oEvent = $this->Timelist_model->FSxMTLTEvent($nEvnID);
        $oLoc = $this->Timelist_model->FSxMTLTLoc($nLocID);
        $oHD = $this->Timelist_model->FSxMTLTHD();
        $this->load->view('ticket/timelist/wAddST', array(
            'nEvnID' => $nEvnID,
            'nLocID' => $nLocID,
            'oEvent' => $oEvent,
            'oHD' => $oHD,
            'oLoc' => $oLoc
        ));
    }

    public function FSxCTLTTimeTableSTAddAjax() {
        if ($this->input->post('ocmFNTmhID')) {
            $nFNTmhID = $this->input->post('ocmFNTmhID');
            $ohdGetEventId = $this->input->post('ohdEventId');
            $ohdGetLocId = $this->input->post('ohdLocId');
            $onbFNShwCallB4Start = $this->input->post('onbFNShwCallB4Start');
            $onbFNShwDuration = $this->input->post('onbFNShwDuration');
            $oPickList = $this->Timelist_model->FSxMTLTPickList($nFNTmhID);
            $oTimeTableDT = $this->Timelist_model->FSxMTLTTimeTableDT($nFNTmhID);
            $oTimeTable = $this->Timelist_model->FSxMTLTTimeTable($ohdGetEventId, $ohdGetLocId);
            $oShowTimes = $this->Timelist_model->FSxMTLTCheckShowTime($ohdGetEventId, $ohdGetLocId);
            $aData = array(
                'FNTmhID' => $nFNTmhID,
                'FNEvnID' => $ohdGetEventId,
                'FNLocID' => $ohdGetLocId,
                'FNShwCallB4Start' => $onbFNShwCallB4Start,
                'FNShwDuration' => $onbFNShwDuration,
                'FTTmdStartTime' => $oTimeTableDT [0]->FTTmdStartTime,
                'FTTmdEndTime' => $oTimeTableDT [0]->FTTmdEndTime,
                'FDShwStartDate' => FsxDate($this->input->post('oetFDShwStartDate')),
                'FDShwEndDate' => FsxDate($this->input->post('oetFDShwEndDate'))
            );
            if ($oShowTimes [0]->FDShwEndDate == '') {
                $this->Timelist_model->FSxMTLTUpdateShowTime($aData);
            } else {
                $this->Timelist_model->FSxMTLTAddShowTime($aData);
            }
        }
    }

    public function FSxCTLTTimeTableSTEdit($nEvnID, $nLocID, $nFNTmhID) {
        $oEvent = $this->Timelist_model->FSxMTLTEvent($nEvnID);
        $oLoc = $this->Timelist_model->FSxMTLTLoc($nLocID);
        $oHD = $this->Timelist_model->FSxMTLTHD();
        $oView = $this->Timelist_model->FSxMTLTSTViewShowTime($nEvnID, $nLocID, $nFNTmhID);
        $this->load->view('ticket/timelist/wEditST', array(
            'nEvnID' => $nEvnID,
            'nLocID' => $nLocID,
            'oEvent' => $oEvent,
            'oView' => $oView,
            'oHD' => $oHD,
            'oLoc' => $oLoc
        ));
    }

    public function FSxCTLTTimeTableSTEditAjax() {
        if ($this->input->post('ocmFNTmhID')) {
            $nFNTmhID = $this->input->post('ocmFNTmhID');
            $ohdGetEventId = $this->input->post('ohdEventId');
            $ohdGetLocId = $this->input->post('ohdLocId');
            $onbFNShwCallB4Start = $this->input->post('onbFNShwCallB4Start');
            $onbFNShwDuration = $this->input->post('onbFNShwDuration');
            $oPickList = $this->Timelist_model->FSxMTLTPickList($nFNTmhID);
            $oTimeTableDT = $this->Timelist_model->FSxMTLTTimeTableDT($nFNTmhID);
            $oTimeTable = $this->Timelist_model->FSxMTLTTimeTable($ohdGetEventId, $ohdGetLocId);
            $oShowTimes = $this->Timelist_model->FSxMTLTCheckShowTime($ohdGetEventId, $ohdGetLocId);
            $aData = array(
                'FNTmhID' => $nFNTmhID,
                'FNEvnID' => $ohdGetEventId,
                'FNLocID' => $ohdGetLocId,
                'FNShwCallB4Start' => $onbFNShwCallB4Start,
                'FNShwDuration' => $onbFNShwDuration,
                'FTTmdStartTime' => $oTimeTableDT [0]->FTTmdStartTime,
                'FTTmdEndTime' => $oTimeTableDT [0]->FTTmdEndTime,
                'FDShwStartDate' => FsxDate($this->input->post('oetFDShwStartDate')),
                'FDShwEndDate' => FsxDate($this->input->post('oetFDShwEndDate')),
                'FNTmhIDOld' => $this->input->post('ohdFNTmhIDOld')
            );
            $this->Timelist_model->FSxMTLTUpdateShowTime2($aData);
        }
    }

    public function FSxCTLTSTPickList() {
        if ($this->input->post('nFNTmhID')) {
            $nFNTmhID = $this->input->post('nFNTmhID');
            $oPickList = $this->Timelist_model->FSxMTLTPickList($nFNTmhID);
            if (@$oPickList [0]->FNTmdID != "") {
                $TimeTableDT = $this->Timelist_model->FSxMTLTTimeTableDT($nFNTmhID);
                $o = FsxCheckTime($TimeTableDT[0]->FTTmdStartTime, $TimeTableDT[0]->FTTmdEndTime);
                echo '<input type="hidden" id="oCheckTime" value="' . $o . '">';
                echo '<table class="table table-responsive table-bordered" style="margin-bottom: 15px;">
					  <thead>
                          <tr>
                          <th style="width: 50px;">' . language('ticket/zone/zone', 'tNo') . '</th>
                          <th>' . language('ticket/zone/zone', 'Name') . '</th>
                          <th>' . language('ticket/event/event', 'tFromTime') . '</th>
                          <th>' . language('ticket/event/event', 'tToTime') . '</th>
                          </tr>
                          </thead>
                          <tbody>
						';
                foreach (@$oPickList as $key => $oValue) {
                    $n = $key + 1;
                    echo '
						  <tr>
	                        <td scope="row">' . $n . '</td>
	                        <td>' . $oValue->FTTmdName . '</td>
	                        <td class="xWTimeFrom">' . $oValue->FTTmdStartTime . '</td>
	                        <td class="xWTimeTo">' . $oValue->FTTmdEndTime . '</td>
	                      </tr>	
                          ';
                }
                echo '</tbody></table>';
            } else {
                echo '';
            }
        }
    }

    public function FSxCTLTTimeTableSTDel() {
        if ($this->input->post('nFNEvnID')) {
            $aData = array(
                'FNTmhID' => $this->input->post('nFNTmhID'),
                'FNEvnID' => $this->input->post('nFNEvnID'),
                'FNLocID' => $this->input->post('nFNLocID'),
                'FDShwStartDate' => $this->input->post('tDateStart'),
                'FDShwEndDate' => $this->input->post('tDateEnd'),
            );
            $this->Timelist_model->FSxMTLTTimeTableSTDel($aData);
        }
    }

    // -------------------------------------------------------------//
    // รอบตามวัน / สัปดาห์
    public function FSxCTLTTimeDOWAddList() {
        if ($this->input->post('orbFNTmhID')) {
            $nFNTmhID = $this->input->post('orbFNTmhID');
            $ohdGetEventId = $this->input->post('ohdGetEventId');
            $ohdGetLocId = $this->input->post('ohdGetLocId');
            $ohdFNTmeDayOfWeek = $this->input->post('ohdFNTmeDayOfWeek');
            $onbFNShwCallB4Start = $this->input->post('onbFNShwCallB4Start');
            $onbFNShwDuration = $this->input->post('onbFNShwDuration');
            $oPickList = $this->Timelist_model->FSxMTLTPickList($nFNTmhID);
            $oTimeTableDT = $this->Timelist_model->FSxMTLTTimeTableDT($nFNTmhID);
            $oEvent = $this->Timelist_model->FSxMTLTEvent($ohdGetEventId);
            $aData = array(
                'FNTmhID' => $nFNTmhID,
                'FNEvnID' => $ohdGetEventId,
                'FNLocID' => $ohdGetLocId,
                'FNStdDayOfWeek' => $ohdFNTmeDayOfWeek,
                'FNShwCallB4Start' => $onbFNShwCallB4Start,
                'FNShwDuration' => $onbFNShwDuration
            );
            $oPickList = $this->Timelist_model->FSxMTLTTimeDOWAddList($aData);
        }
    }

    public function FSxCTLTDelTimeDOW() {
        if ($this->input->post('nFNEvnID')) {
            $aData = array(
                'FNEvnID' => $this->input->post('nFNEvnID'),
                'FNLocID' => $this->input->post('nFNLocID'),
                'FNStdDayOfWeek' => $this->input->post('nDayOfWeek')
            );
            $oPickList = $this->Timelist_model->FSxMTLTDelTimeDOW($aData);
        }
    }

    // ------------------------------------------------------------//
    // รอบตามวันหยุด
    public function FSxCTLTTimeHolidayAddList() {
        if ($this->input->post('orbFNTmhID')) {
            $nFNTmhID = $this->input->post('orbFNTmhID');
            $ohdGetEventId = $this->input->post('ohdGetEventId');
            $ohdGetLocId = $this->input->post('ohdGetLocId');
            $ohdFDSthCheckIn = $this->input->post('ohdFDSthCheckIn');
            $onbFNShwCallB4Start = $this->input->post('onbFNShwCallB4Start');
            $onbFNShwDuration = $this->input->post('onbFNShwDuration');
            $oPickList = $this->Timelist_model->FSxMTLTPickList($nFNTmhID);
            $oTimeTableDT = $this->Timelist_model->FSxMTLTTimeTableDT($nFNTmhID);
            $oEvent = $this->Timelist_model->FSxMTLTEvent($ohdGetEventId);
            $aData = array(
                'FNTmhID' => $nFNTmhID,
                'FNEvnID' => $ohdGetEventId,
                'FNLocID' => $ohdGetLocId,
                'FDSthCheckIn' => $ohdFDSthCheckIn,
                'FNShwCallB4Start' => $onbFNShwCallB4Start,
                'FNShwDuration' => $onbFNShwDuration
            );
            $this->Timelist_model->FSxMTLTTimeHolidayAddList($aData);
        }
    }

    public function FSxCTLTFullCalendarEvent() {
        if ($this->input->post('nEvnID')) {
            $nEvnID = $this->input->post('nEvnID');
            $nLocID = $this->input->post('nLocID');
            $oHoliday = $this->Timelist_model->FSxMTLTHoliday($nEvnID, $nLocID);
            if (@$oHoliday [0]->FDSthCheckIn != "") {
                $aEvents = array();
                foreach ($oHoliday as $tValue) {
                    $a = array();
                    $a ['id'] = $tValue->FNTmhID;
                    $a ['datetime'] = $tValue->FDSthCheckIn;
                    $a ['title'] = language('ticket/event/event', 'tShowTime') . date("d-m-Y", strtotime($tValue->FDSthCheckIn));
                    $a ['start'] = date("Y-m-d", strtotime($tValue->FDSthCheckIn));
                    // $e['end'] = $row['end'];
                    $a ['color'] = "#087380";
                    $a ['textColor'] = "#FFFFFF";
                    array_push($aEvents, $a);
                }

                echo json_encode($aEvents);
            }
        }
    }

    public function FSxCTLTFullCalendarEventList() {
        if ($this->input->post('nFNTmhID')) {
            $nFNTmhID = $this->input->post('nFNTmhID');
            $nFNEvnID = $this->input->post('nFNEvnID');
            $nFNLocID = $this->input->post('nFNLocID');
            $tDate = $this->input->post('tDate');
            $oPickList = $this->Timelist_model->FSxMTLTPickList($nFNTmhID);
            if (@$oPickList [0]->FNTmdID != "") {
                echo '<p style="font-size: 18px;">' . language('ticket/event/event', 'tShowTime') . '     <a style="color: #000; float: right;" onclick="JSxTLTDelTimeHoliday(\'' . $nFNEvnID . '\', \'' . $nFNLocID . '\', \'' . $nFNTmhID . '\', \'' . $tDate . '\');"><i class="fa fa-remove"></i></a></p>';
                foreach (@$oPickList as $key => $oValue) {
                    echo '<div style="padding-top: 5px; padding-bottom: 5px;">' . $oValue->FTTmdStartTime . ' - ' . $oValue->FTTmdEndTime . '</div>';
                }
            } else {
                echo '';
            }
        }
    }

    public function FSxCTLTDelTimeHoliday() {
        if ($this->input->post('nFNEvnID')) {
            $aData = array(
                'FNEvnID' => $this->input->post('nFNEvnID'),
                'FNLocID' => $this->input->post('nFNLocID'),
                'FNTmhID' => $this->input->post('nFNTmhID'),
                'FDSthCheckIn' => $this->input->post('tDate')
            );
            $oPickList = $this->Timelist_model->FSxMTLTDelTimeHoliday($aData);
        }
    }

}
