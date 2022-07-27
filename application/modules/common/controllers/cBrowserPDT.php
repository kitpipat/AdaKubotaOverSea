<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cBrowserPDT extends MX_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('common/mBrowserPDT');
    }

    //List PDT Serach
    public function index()
    {
        //hidden filter search
        $Qualitysearch  = $this->input->post('Qualitysearch');

        //price type
        $PriceType      = $this->input->post('PriceType');

        //Select Tier : เลือกระดับไหน [PDT,Barcode]
        $SelectTier     = $this->input->post('SelectTier');
        if (isset($SelectTier)) {
            if (($PriceType[0] == 'Pricesell' || $PriceType[0] == 'Price4Cst') && $SelectTier[0] == 'PDT') {
                $SelectTier = 'PDT';
            } else {
                $SelectTier = 'Barcode';
            }
        } else {
            $SelectTier = 'Barcode';
        }

        //element return input
        $tElementreturn  = $this->input->post('Elementreturn');

        //ShowCountRecord
        $nShowCountRecord  = $this->input->post('ShowCountRecord');

        //name NextFunc
        $tNameNextFunc  = $this->input->post('NextFunc');

        //Return type S,M
        $tReturnType    = $this->input->post('ReturnType');

        //Parameter SPL
        $tParameterSPL    = $this->input->post('SPL');

        //Parameter BCH
        $tParameterBCH    = $this->input->post('BCH');

        //Parameter MCH
        $tParameterMCH    = $this->input->post('MCH');

        //Parameter SHP
        $tParameterSHP    = $this->input->post('SHP');

        //Get Time for localstorage
        $tTimeLocalstorage = $this->input->post('TimeLocalstorage');

        //Get Time for localstorage
        $tPagename = $this->input->post('PageName');
        if (isset($tPagename)) {
            $tPagename = $tPagename;
        } else {
            $tPagename = '';
        }

        //Not in Item
        $aNotinItem = $this->input->post('NOTINITEM');

        $aData = array(
            'nShowCountRecord'  => $nShowCountRecord,
            'aQualitysearch'    => $Qualitysearch,
            'aPriceType'        => $PriceType,
            'tSelectTier'       => $SelectTier,
            'tElementreturn'    => $tElementreturn,
            'tNameNextFunc'     => $tNameNextFunc,
            'tReturnType'       => $tReturnType,
            'SesBch'            => $this->session->userdata("tSesUsrBchCode"),
            'SesShp'            => $this->session->userdata("tSesUsrShpCode"),
            'SesMer'            => $this->session->userdata("tSesUsrMerCode"),
            'tParameterSPL'     => $tParameterSPL,
            'tParameterMCH'     => $tParameterMCH,
            'tParameterBCH'     => $tParameterBCH,
            'tParameterSHP'     => $tParameterSHP,
            'tTimeLocalstorage' => $tTimeLocalstorage ,
            'tPagename'         => $tPagename,
            'aNotinItem'        => $aNotinItem
        );
        $this->load->view('common/wBrowsePDT', $aData);
    }

    //get product datatable
    public function FSxGetProductfotPDT(){
        $nPage              =  $this->input->post("nPage");
        $nRow               =  $this->input->post("nRow");
        $tNamePDT           =  trim($this->input->post("NamePDT"));
        $tCodePDT           =  trim($this->input->post("CodePDT"));
        $tSPLCode           =  $this->input->post("SPL");
        $aBCH               =  $this->input->post("BCH");
        $aMCH               =  $this->input->post("MCH");
        $aSHP               =  $this->input->post("SHP");
        $aPGP               =  $this->input->post("PGP");
        $aPTY               =  $this->input->post("PTY");
        $tMerchant          =  $this->input->post("Merchant");
        $tSelectTier        =  $this->input->post("SelectTier");
        $tReturnType        =  $this->input->post("ReturnType");
        $tPagename          =  $this->input->post("tPagename");
        $aNotinItem         =  $this->input->post("aNotinItem");
        $nPDTMoveon         =  $this->input->post("PDTMoveon");
        $tBarcode           =  trim($this->input->post("tBarcode"));
        $tPurchasingManager =  trim($this->input->post("tPurchasingManager"));
        $tPDTLOGSEQ         =  $this->input->post("tPDTLOGSEQ"); 
        $tMerchantGroup     = $this->input->post("tMerchantGroup");
        print_r($aMCH);
        $aDataSearch = array(
            'FNLngID'               => $this->session->userdata("tLangEdit"),
            'nPage'                 => $nPage,
            'nRow'                  => $nRow,
            'tNamePDT'              => $tNamePDT,
            'tCodePDT'              => $tCodePDT,
            'tSPLCode'              => $tSPLCode,
            'aBCH'                  => $aBCH,
            'aMCH'                  => $aMCH,
            'aSHP'                  => $aSHP,
            'aPGP'                  => $aPGP,
            'aPTY'                  => $aPTY ,
            'tMerchant'             => $tMerchant,
            'tSelectTier'           => $tSelectTier,
            'tPagename'             => $tPagename,
            'aNotinItem'            => $aNotinItem,
            'nPDTMoveon'            => $nPDTMoveon,
            'tBarcode'              => $tBarcode,
            'tPurchasingManager'    => $tPurchasingManager,
            'tPDTLOGSEQ'            => $tPDTLOGSEQ,
            'tMerchantGroup'        => $tMerchantGroup
        );
        $aProduct  = $this->mBrowserPDT->FSnMGetProduct($aDataSearch);
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $aDataHTML  = array(
            'nPage'             => $this->input->post("nPage"),
            'aPriceType'        => json_decode($this->input->post("aPriceType")),
            'tSelectTier'       => $tSelectTier,
            'nOptDecimalShow'   => $nOptDecimalShow,
            'tReturnType'       => $tReturnType,
            'aProduct'          => $aProduct
        );

        $this->load->view('common/wBrowsePDTTable', $aDataHTML);
    }

    //get barcode datatable
    public function FSxGetBarcodeforPDT()
    {
        $tParamPDTcode      = $this->input->post('pnCode');
        $aNotinItem         = $this->input->post('aNotinItem');
        $tSelectTier        = $this->input->post('SelectTier');
        $tParamCodeSpl      = '';
        if ($this->input->post('ptConfig') == '' || $this->input->post('ptConfig') == null) { //printSell
            $tParamSysconfig    = '';

            //parameter where case price sell
            $aSendBarcode = array(
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTPdtCode'         => $tParamPDTcode
            );
            $aBarcode       = $this->mBrowserPDT->FSnMGetBarcodePriceSELL($aSendBarcode,$aNotinItem);
            $aCheckPrice    = '';
            $tPriceType     = 'Pricesell';
        } else {
            $tParamSysconfig    = json_decode($this->input->post('ptConfig')); //cost
            //หาประเภทราคา ใช้ต้นทุนแบบไหน [1,2,3,4];
            $aCheckPrice = $this->mBrowserPDT->FSnMGetTypePrice($tParamSysconfig[1], $tParamSysconfig[2], $tParamSysconfig[3]);
            if ($tParamCodeSpl == '' || $tParamCodeSpl == null) { //ไม่ส่ง spl มา
                $aGetInorEx    = $this->mBrowserPDT->FSaMGetWhsInorExIncompany();
                $tVatInorEx    = $aGetInorEx[0]['FTCmpWhsInOrEx'];
            } else {
                $aGetInorEx    = $this->mBrowserPDT->FSaMGetWhsInorExInSupplier($tParamCodeSpl);
                if (empty($aGetInorEx)) {
                    $tVatInorEx    = 1;
                } else {
                    $tVatInorEx    = $aGetInorEx[0]['FTSplStaVATInOrEx'];
                }
            }

            //parameter where case cost
            $aSendBarcode = array(
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTPdtCode'         => $tParamPDTcode,
                'tVatInorEx'        => $tVatInorEx
            );
            $aBarcode       = $this->mBrowserPDT->FSnMGetBarcodeCOST($aSendBarcode,$aNotinItem);
            $tPriceType     = 'Cost';
        }

        //Get Option Show Decimal  
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $aDataHTML = array(
            'aPdtBarcode'       => $aBarcode,
            'aTSysconfig'       => $aCheckPrice,
            'tPriceType'        => $tPriceType,
            'nOptDecimalShow'   => $nOptDecimalShow
        );

        $this->load->view('common/wBrowsePDTBarcode', $aDataHTML);
    }
}
