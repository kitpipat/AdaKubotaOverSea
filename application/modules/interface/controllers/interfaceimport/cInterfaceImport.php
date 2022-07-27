<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'libraries/rabbitmq/vendor/autoload.php');
require_once(APPPATH . 'config/rabbitmq.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class cInterfaceimport extends MX_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('interface/interfaceimport/mInterfaceImport');
    }

    public function index($nBrowseType, $tBrowseOption)
    {

        $aData['nBrowseType']                   = $nBrowseType;
        $aData['tBrowseOption']                 = $tBrowseOption;
        $aData['aAlwEventInterfaceImport']      = FCNaHCheckAlwFunc('interfaceimport/0/0'); //Controle Event
        $aData['vBtnSave']                      = FCNaHBtnSaveActiveHTML('interfaceimport/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $tLangEdit                              = $this->session->userdata("tLangEdit");

        $aData['aDataMasterImport'] = $this->mInterfaceImport->FSaMINMGetHD($tLangEdit);


        // $this->mInterfaceImport->FSaMINMGetDataConfig($tLangEdit);

        // echo '<pre>';
        // print_r($aData['aDataMasterImport']);
        // echo '</pre>';

        $tUserCode = $this->session->userdata('tSesUserCode');

        $aParams = [
            'prefixQueueName' => 'LK_RPTransferResponseSAP',
            'ptUsrCode' => $tUserCode
        ];

        $this->FSxCINMRabbitMQDeleteQName($aParams);
        $this->FSxCINMRabbitMQDeclareQName($aParams);

        $this->load->view('interface/interfaceimport/wInterfaceImport', $aData);
    }


    // public function FSxCINMCallRabitMQ(){

    //    $aINMImport = $this->input->post('ocmINMImport');

    //         for ($i=0;$i<=2;$i++){
    //             $aMQParams = $this->FSaCIMNGetFormatParamSAP($i);
    //             FCNxCallRabbitMQ($aMQParams,false);
    //         }

    //     return;
    // }

    public function FSxCINMCallRabitMQ()
    {
        $tLangEdit  = $this->session->userdata("tLangEdit");
        $tTypeEvent = $this->input->post('ptTypeEvent');
        if ($tTypeEvent == 'getpassword') {
            $aResult = $this->mInterfaceImport->FSaMINMGetDataConfig($tLangEdit);
            $aConnect = array(
                'tHost'      => $aResult[1]['FTCfgStaUsrValue'],
                'tPort'      => $aResult[2]['FTCfgStaUsrValue'],
                'tPassword'  => $aResult[3]['FTCfgStaUsrValue'],
                'tUser'      => $aResult[5]['FTCfgStaUsrValue'],
                'tVHost'     => $aResult[6]['FTCfgStaUsrValue']
            );
            echo json_encode($aConnect);
        } else {
            $tPassword      = $this->input->post('tPassword');
            $aINMImport     = $this->input->post('ocmINMImport');
            for ($i=0;$i<count($aINMImport);$i++){
                switch ($aINMImport[$i]) {
                    case "00006":
                        $this->FSaCIMNGetFormatParamMASTER($tPassword);
                        echo "Send Import ptFunction:MASTER<br>";
                    break;
                    case "00007":
                        $this->FSaCIMNGetFormatParamEMPLO($tPassword);
                        echo "Send Import ptFunction:EMPLO<br>";
                    break;
                    case "00012":
                        $this->FSxCIMNSendMQPromotion($tPassword);
                        echo "Send Import ptFunction:TCNTPdtPmtHD<br>";
                    break;
                }
            }
            // $this->FSaCIMNGetFormatParamADJPRI($tPassword);
            exit;
        }
    }

    function FSxCINMRabbitMQDeclareQName($paParams)
    {

        $tPrefixQueueName = $paParams['prefixQueueName'];
        $tQueueName = $tPrefixQueueName;

        $oConnection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
        $oChannel = $oConnection->channel();
        $oChannel->queue_declare($tQueueName, false, true, false, false);
        $oChannel->close();
        $oConnection->close();
        return 1;
        /** Success */
    }


    function FSxCINMRabbitMQDeleteQName($paParams)
    {

        $tPrefixQueueName = $paParams['prefixQueueName'];
        $tQueueName = $tPrefixQueueName;
        // $oConnection = new AMQPStreamConnection('172.16.30.28', '5672', 'admin', '1234', 'Pandora_PPT1');
        $oConnection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
        $oChannel = $oConnection->channel();
        $oChannel->queue_delete($tQueueName);
        $oChannel->close();
        $oConnection->close();
        return 1;
        /** Success */
    }


    // {
    //     "ptFunction":"MASTER"
    //     ,"ptSource":"HQ.AdaStoreBack"
    //     ,"ptDest":"BQ Process"
    //      ,"ptData": {
    //                   "ptFilter":"2",       --1=Auto  2=Manual  (AdaStoreBack)
    //                    "ptDateFrm": "",
    //                    "ptDateTo": "", 
    //                }
    //    }


    //    {
    //     "ptFunction":"EMPLO"
    //     ,"ptSource":"HQ.AdaStoreBack"
    //     ,"ptDest":"BQ Process"
    //      ,"ptData": {
    //                  "ptFilter":"2",    --1=Auto  2=Manual  (AdaStoreBack)
    //                    "ptDateFrm": "",
    //                    "ptDateTo": "", 
    //                }
    //    }
    public function FSaCIMNGetFormatParamMASTER($ptPasswordMQ)
    {

        $aMQParams = [
            "queueName" => "LK_QImportMaster",
            "exchangname" => "",
            "params" => [
                "ptFunction"    => "MASTER",
                "ptSource"      => "HQ.AdaStoreBack",
                "ptDest"        => "BQ Process",
                "ptData" => [
                    "ptFilter"      => "2",
                    "ptDateFrm"     => "",
                    "ptDateTo"      => ""
                ]
            ]
        ];

        $this->FCNxCallRabbitMQMaster($aMQParams, false, $ptPasswordMQ);
    }

    public function FSaCIMNGetFormatParamEMPLO($ptPasswordMQ)
    {
        $aMQParams = [
            "queueName" => "LK_QImportMaster",
            "exchangname" => "",
            "params" => [
                "ptFunction"    => "EMPLO",
                "ptSource"      => "HQ.AdaStoreBack",
                "ptDest"        => "BQ Process",
                "ptData" => [
                    "ptFilter"      => "2",
                    "ptDateFrm"     => "",
                    "ptDateTo"      => ""
                ]
            ]
        ];


        $this->FCNxCallRabbitMQMaster($aMQParams, false, $ptPasswordMQ);
    }

    public function FSaCIMNGetFormatParamADJPRI($ptPasswordMQ)
    {
        $aMQParams = [
            "queueName" => "LK_QImportMaster",
            "exchangname" => "",
            "params" => [
                "ptFunction"    => "TCNTPdtAdjPriHD",
                "ptSource"      => "HQ.AdaStoreBack",
                "ptDest"        => "MQAdaLink",
                "ptData" => [
                    "ptFilter"      => "",
                    "ptDateFrm"     => "",
                    "ptDateTo"      => ""
                ]
            ]
        ];
        $this->FCNxCallRabbitMQMaster($aMQParams, false, $ptPasswordMQ);
    }

    public function FSxCIMNSendMQPromotion($ptPasswordMQ){
        $aMQParams = [
            "queueName" => "LK_QImportMaster",
            "exchangname" => "",
            "params" => [
                "ptFunction"    => "PROMO",
                "ptSource"      => "HQ.AdaStoreBack",
                "ptDest"        => "MQAdaLink",
                "ptData" => [
                    "ptFilter"      => "",
                    "ptDateFrm"     => "",
                    "ptDateTo"      => ""
                ]
            ]
        ];
        $this->FCNxCallRabbitMQMaster($aMQParams, false, $ptPasswordMQ);
    }


    function FCNxCallRabbitMQMaster($paParams, $pbStaUse = true, $ptPasswordMQ)
    {

        $tLangEdit  = $this->session->userdata("tLangEdit");
        $aVal       = $this->mInterfaceImport->FSaMINMGetDataConfig($tLangEdit);
        $tHost      = $aVal[1]['FTCfgStaUsrValue'];
        $tPort      = $aVal[2]['FTCfgStaUsrValue'];
        $tPassword  = $aVal[3]['FTCfgStaUsrValue'];
        // $tQueueName = $aVal[4]['FTCfgStaUsrValue'];
        $tUser      = $aVal[5]['FTCfgStaUsrValue'];
        $tVHost     = $aVal[6]['FTCfgStaUsrValue'];

        $tQueueName = $paParams['queueName'];
        $aParams    = $paParams['params'];
        if ($pbStaUse == true) {
            $aParams['ptConnStr']   = DB_CONNECT;
        }
        $tExchange              = EXCHANGE; // This use default exchange

        $oConnection = new AMQPStreamConnection($tHost, $tPort, $tUser, $ptPasswordMQ, $tVHost);

        $oChannel = $oConnection->channel();
        $oChannel->queue_declare($tQueueName, false, false, false, false);
        $oMessage = new AMQPMessage(json_encode($aParams));
        $oChannel->basic_publish($oMessage, "", $tQueueName);

        $oChannel->close();
        $oConnection->close();

        return 1;
        /** Success */
    }




    // public function FSaCIMNGetFormatParamSAP($nNumber){
    //     $tUserCode = $this->session->userdata('tSesUserCode');

    //         switch ($nNumber) {
    //             case 0:
    //               // สินค้า
    //                 $aMQParams = [
    //                     "queueName" => "LK_QImportMaster",
    //                     "exchangname" => "",
    //                     "params" => [
    //                         "ptFunction"    => "TCNMPdt",
    //                         "ptSource"      => "HQ.AdaStoreBack",
    //                         "ptDest"        => "MQAdaLink",
    //                         "ptData" => [
    //                             "ptFilter"      => "",
    //                             "ptDateFrm"     => "",
    //                             "ptDateTo"      => ""
    //                         ]
    //                     ]
    //                 ];
    //             break;
    //             case 1:
    //                // ใบปรับราคา
    //                 $aMQParams = [
    //                     "queueName" => "LK_QImportMaster",
    //                     "exchangname" => "",
    //                     "params" => [
    //                         "ptFunction"    => "TCNTPdtAdjPriHD",
    //                         "ptSource"      => "HQ.AdaStoreBack",
    //                         "ptDest"        => "MQAdaLink",
    //                         "ptData" => [
    //                             "ptFilter"      => "",
    //                             "ptDateFrm"     => "",
    //                             "ptDateTo"      => ""
    //                         ]
    //                     ]
    //                 ];
    //             break;
    //             case 2:
    //                 //พนักงาน (User)
    //                 $aMQParams = [
    //                     "queueName" => "LK_QImportMaster",
    //                     "exchangname" => "",
    //                     "params" => [
    //                         "ptFunction"    => "TCNMUser",
    //                         "ptSource"      => "HQ.AdaStoreBack",
    //                         "ptDest"        => "MQAdaLink",
    //                         "ptData" => [
    //                             "ptFilter"      => "",
    //                             "ptDateFrm"     => "",
    //                             "ptDateTo"      => ""
    //                         ]
    //                     ]
    //                 ];
    //              break;
    //         }

    //     return $aMQParams;
    // }

    // สินค้า
    // {
    //  "ptFunction":"ImpPdt" //ชื่อ Function
    //  ,"ptSource":"HQ.AdaStoreBack"      //ต้นทาง
    //  ,"ptDest":"BQ Process"        //ปลายทาง
    //   "ptData": {
    //                                                      }
    // }

    // ใบปรับราคา
    //  "ptFunction":"ImpAdj" //ชื่อ Function
    //  ,"ptSource":"HQ.AdaStoreBack"      //ต้นทาง
    //  ,"ptDest":"BQ Process"        //ปลายทาง
    //   "ptData": {
    //                                                      }
    // }

    // การขาย
    // {
    //  "ptFunction":"ExpSale" //ชื่อ Function
    //  ,"ptSource":"BQ Process"      //ต้นทาง
    //  ,"ptDest":"HQ.AdaStoreBack"        //ปลายทาง
    //   "ptData": {
    //                 "ptDateFrm": "20200303",   //จากวันที่
    //                 "ptDateTo": "20200303",   //ถึงวันที่
    //                  "ptDocFrm": "S0000120000-000000001",   //จากวันที่
    //                 "ptDocTo": "S0000120000-000000003",   //ถึงวันที่
    //                                                      }
    // }

    // การเงิน
    // {
    //  "ptFunction":"ExpFin" //ชื่อ Function
    //  ,"ptSource":"BQ Process"      //ต้นทาง
    //  ,"ptDest":"HQ.AdaStoreBack"        //ปลายทาง
    //   "ptData": {
    //                 "ptDateFrm": "20200303",   //จากวันที่
    //                 "ptDateTo": "20200303",   //ถึงวันที่
    //                                                      }
    // }


}
