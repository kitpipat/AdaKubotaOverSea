<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Roomnew_controller extends MX_Controller {
	
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'ticket/room/mRoom', 'mRoom' );
		$this->load->library ( "session" );
	}
	
	// แสดงห้อง
	public function FSxCROM($nLocID, $nZneID) {
		$oAuthen = $this->Room_model->FSxMROMAuthen ();
		$oHeader = $this->Room_model->FSxMROMHeader ( $nLocID );
		$oArea = $this->Room_model->FSxMROMArea ( $nLocID );
		$oZne = $this->Room_model->FSxMROMZone ( $nZneID );
		$this->load->view ( 'ticket/room/wRoomNew', array (
				'oAuthen' => $oAuthen,
				'oHeader' => $oHeader,
				'oArea' => $oArea,
				'nLocID' => $nLocID,
				'nZneID' => $nZneID,
				'oZne' => $oZne 
		));
	}
	public function FSxCROMList() {
		$tFTRomName = $this->input->post ( 'tFTRoomName' );
		$tLocID = $this->input->post ( 'tLocID' );
		$tZneID = $this->input->post ( 'tZneID' );
		$nPageNo = $this->input->post ( 'nPageNo' );
		$nPageActive = $nPageNo;
		$oRomList = $this->Room_model->FSxMROM ( $tFTRomName, $tLocID, $tZneID, $nPageActive );
		$oAuthen = $this->Room_model->FSxMROMAuthen ();
		$this->load->view ( 'ticket/room/wRoomList', array (
				'oAuthen' => $oAuthen,
				'oRomList' => $oRomList 
		) );
	}
	public function FSxCROMCount() {
		$tFTRomName = $this->input->post ( 'tFTRoomName' );
		$tLocID = $this->input->post ( 'tLocID' );
		$tZneID = $this->input->post ( 'tZneID' );
		$oRomCntSh = $this->Room_model->FStMROMCount ( $tFTRomName, $tLocID, $tZneID );
		$tRomCount = $oRomCntSh [0]->counts;
		echo $tRomCount;
	}
	
	// เพิ่มห้อง
	public function FSxCROMAdd($nLocID, $nZneID) {
		$oLev = $this->Room_model->FSxMROMLev ( $nLocID );
		$oTcg = $this->Room_model->FSxMROMTcg ( $nLocID );
		$oPdtTcg = $this->Room_model->FSxMROMPdtTcg ();
		$this->load->view ( 'ticket/room/wAdd', array (
				'nLocID' => $nLocID,
				'nZneID' => $nZneID,
				'oLev' => $oLev,
				'oTcg' => $oTcg,
				'oPdtTcg' => $oPdtTcg 
		) );
	}
	public function FSxCROMAddAjax() {
		if ($this->input->post ( 'ohdFNLocID' )) {
			$tCopyAmount = $this->input->post ( 'ohdCopyAmount' );
			$aPdtCode = $this->Room_model->FSxMROMPdtCode ();
			for($i = 0; $i < $tCopyAmount; $i ++) {
				$nAmount = $i + 1;
				$tFTRoomImg = $this->input->post ( 'ohdRoomImg' );
				$aPic = explode ( 'base64,', $tFTRoomImg );
				
				if (@$aPdtCode [0]->FTPdtCode == '') {
					$tNum = 000001 + $i;
					$tPad = str_pad ( $tNum, 6, '0', STR_PAD_LEFT );
					$tPad = 'PDT-' . $tPad;
				} else {
					$tNum = str_replace ( "PDT-", "", $aPdtCode [0]->FTPdtCode );
					$tNum = $tNum + $i + 1;
					$tPad = str_pad ( $tNum, 6, '0', STR_PAD_LEFT );
					$tPad = 'PDT-' . $tPad;
				}
				$aData = array (
						'FTPdtCode' => $tPad,
						'FNLocID' => $this->input->post ( 'ohdFNLocID' ),
						'FNTcgID' => $this->input->post ( 'ocmFNTcgID' ),
						'FNLevID' => $this->input->post ( 'ocmFNLevID' ),
						'FNZneID' => $this->input->post ( 'ohdFNZneID' ),
						'FTRomName' => $this->input->post ( 'oetFTRomName' ),
						'FTRomLatitude' => $this->input->post ( 'oetFTRomLatitude' ),
						'FTRomLongitude' => $this->input->post ( 'oetFTRomLongitude' ),
						'FTRomSeqNo' => $this->input->post ( 'oetFTRomSeqNo' ) . ($this->input->post ( 'ohdCopyAmount' ) == '1' ? "" : '-' . $nAmount),
						'FNRomQtyBRoom' => $this->input->post ( 'onbFNRomQtyBRoom' ),
						'FNRomQtyTRoom' => $this->input->post ( 'onbFNRomQtyTRoom' ),
						'FNRomMaxPerson' => $this->input->post ( 'onbFNRomMaxPerson' ),
						'FNRomMinDayBook' => $this->input->post ( 'onbFNRomMinDayBook' ),
						'FNRomDayBooking' => $this->input->post ( 'onbFNRomDayBooking' ),
						'FNRomDayPreBooking' => $this->input->post ( 'onbFNRomDayPreBooking' ),
						'FTRomFacility' => $this->input->post ( 'otaFTRomFacility' ),
						'FTRomRemark' => $this->input->post ( 'otaFTRomRemark' ),
						'FTRomStaAlw' => $this->input->post ( 'ocmFTRomStaAlw' ),
						'FTRomStaAir' => ($this->input->post ( 'ocbFTRomStaAir' ) == "" ? "2" : "1"),
						'FTRomStaFan' => ($this->input->post ( 'ocbFTRomStaFan' ) == "" ? "2" : "1"),
						'FTRomStaHeater' => ($this->input->post ( 'ocbFTRomStaHeater' ) == "" ? "2" : "1"),
						'FTRomStaWifi' => ($this->input->post ( 'ocbFTRomStaWifi' ) == "" ? "2" : "1"),
						'FTRomStaBreakfast' => ($this->input->post ( 'ocbFTRomStaBreakfast' ) == "" ? "2" : "1"),
						'FTRomStaAlwAddBed' => ($this->input->post ( 'ocbFTRomStaAlwAddBed' ) == "" ? "2" : "1"),
						'FTImgObj' => @$aPic [1] 
				);
				$this->Room_model->FSxMROMAdd ( $aData );
				if ($tFTRoomImg != "") {
					$this->Room_model->FSxMROMAddImg ( $aData );
				}
			}
		}
	}
	
	// แก้ไขห้อง
	public function FSxCROMEdit($nRoomID, $nLocID) {
		$oEdit = $this->Room_model->FSxMROMShowEdit ( $nRoomID );
		$oLev = $this->Room_model->FSxMROMLev ( $oEdit [0]->FNLocID );
		$oTcg = $this->Room_model->FSxMROMTcg ( $nLocID );
		$this->load->view ( 'ticket/room/wEdit', array (
				'nRoomID' => $nRoomID,
				'oLev' => $oLev,
				'oEdit' => $oEdit,
				'oTcg' => $oTcg 
		) );
	}
	public function FSxCROMEditAjax() {
		if ($this->input->post ( 'ohdRomID' )) {
			$tFTRomImg = $this->input->post ( 'ohdRoomImg' );
			$tData = array (
					'FNRomID' => $this->input->post ( 'ohdRomID' ),
					'FNTcgID' => $this->input->post ( 'ocmFNTcgID' ),
					'FNPdtID' => $this->input->post ( 'ohdFNPdtID' ),
					'FNLevID' => $this->input->post ( 'ocmFNLevID' ),
					'FTRomName' => $this->input->post ( 'oetFTRomName' ),
					'FTRomLatitude' => $this->input->post ( 'oetFTRomLatitude' ),
					'FTRomLongitude' => $this->input->post ( 'oetFTRomLongitude' ),
					'FTRomSeqNo' => $this->input->post ( 'oetFTRomSeqNo' ),
					'FNRomQtyBRoom' => $this->input->post ( 'onbFNRomQtyBRoom' ),
					'FNRomQtyTRoom' => $this->input->post ( 'onbFNRomQtyTRoom' ),
					'FNRomMaxPerson' => $this->input->post ( 'onbFNRomMaxPerson' ),
					'FNRomMinDayBook' => $this->input->post ( 'onbFNRomMinDayBook' ),
					'FNRomDayBooking' => $this->input->post ( 'onbFNRomDayBooking' ),
					'FNRomDayPreBooking' => $this->input->post ( 'onbFNRomDayPreBooking' ),
					'FTRomFacility' => $this->input->post ( 'otaFTRomFacility' ),
					'FTRomRemark' => $this->input->post ( 'otaFTRomRemark' ),
					'FTRomStaAlw' => $this->input->post ( 'ocmFTRomStaAlw' ),
					'FTRomStaAir' => ($this->input->post ( 'ocbFTRomStaAir' ) == "" ? "2" : "1"),
					'FTRomStaFan' => ($this->input->post ( 'ocbFTRomStaFan' ) == "" ? "2" : "1"),
					'FTRomStaHeater' => ($this->input->post ( 'ocbFTRomStaHeater' ) == "" ? "2" : "1"),
					'FTRomStaWifi' => ($this->input->post ( 'ocbFTRomStaWifi' ) == "" ? "2" : "1"),
					'FTRomStaBreakfast' => ($this->input->post ( 'ocbFTRomStaBreakfast' ) == "" ? "2" : "1"),
					'FTRomStaAlwAddBed' => ($this->input->post ( 'ocbFTRomStaAlwAddBed' ) == "" ? "2" : "1") 
			);
			$this->Room_model->FSxMROMEdit ( $tData );
			if ($tFTRomImg != "") {
				$aPic = explode ( 'base64,', $tFTRomImg );
				$tImg = array (
						'FNRomID' => $this->input->post ( 'ohdRomID' ),
						'FNPdtID' => $this->input->post ( 'ohdFNPdtID' ),
						'FTImgObj' => $aPic [1] 
				);
				$this->Room_model->FSxMROMImgEdit ( $tImg );
			}
		}
	}
	
	// ลบห้อง
	public function FSxCROMDel() {
		if ($this->input->post ( 'nRomID' )) {
			$nRomID = $this->input->post ( 'nRomID' );
			$nPdtID = $this->input->post ( 'nPdtID' );
			$this->Room_model->FSxMROMDel ( $nRomID, $nPdtID );
		}
	}
}
