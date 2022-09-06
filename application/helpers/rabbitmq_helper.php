<?php
require_once(APPPATH.'libraries/rabbitmq/vendor/autoload.php');
require_once(APPPATH.'config/rabbitmq.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * 
 * @param array $paParams
 * 
 * $paParams = [
        "queueName" => "", 
        "params" => [
            "ptBchCode" => "", "ptDocNo" => "", "ptUsrCode" => ""
        ]
    ];
 */
function FCNxCallRabbitMQ($paParams,$pbStaUse = true) {
    $tQueueName             = $paParams['queueName'];
    $aParams                = $paParams['params'];
    $tVhostType = (isset($paParams['tVhostType'])) ?$paParams['tVhostType']:'D';
    if($pbStaUse == true){
        $aParams['ptConnStr']   = DB_CONNECT;
    }
    $tExchange              = EXCHANGE; // This use default exchange
    
    switch($tVhostType){
        case 'M': {
            $oConnection = new AMQPStreamConnection(MQ_LOCKER_HOST, MQ_LOCKER_PORT, MQ_LOCKER_USER, MQ_LOCKER_PASS, MQ_LOCKER_VHOST);
            // $aParams['ptData']['ptConnStr'] = DB_CONNECT;
            // $bDurable = true;
            break;
        }
        default : {
            $oConnection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
            // $bDurable = false;
        }
    }

    // $oConnection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
    $oChannel = $oConnection->channel();
    // $oChannel->queue_declare($tQueueName, false, false, false, false);
    // $oMessage = new AMQPMessage(json_encode($aParams));
    $oChannel->queue_declare($tQueueName, false, true, false, false);
    $oMessage = new AMQPMessage(json_encode($aParams,JSON_UNESCAPED_UNICODE));
    // print_r($oMessage);
    $oChannel->basic_publish($oMessage, "", $tQueueName);
    $oChannel->close();
    $oConnection->close();
    return 1; /** Success */

    
    
    /*$tQueueName = $paParams['queueName'];
    $aParams = $paParams['params'];
    $aParams['ptConnStr'] = DB_CONNECT;
    $tExchange = EXCHANGE;
    
    $oConnection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
    $oChannel = $oConnection->channel();
    $oChannel->queue_declare($tQueueName, false, false, false, false);
    $oChannel->exchange_declare($tExchange, 'direct', false, false, false);
    $oChannel->queue_bind($tQueueName, $tExchange);
    $oMessage = new AMQPMessage(json_encode($aParams));
    $oChannel->basic_publish($oMessage, $tExchange);

    echo "[x] Sent $tQueueName Success";

    $oChannel->close();
    $oConnection->close();*/
}

/**
 * 
 * @param array $paParams
 * 
 * $paParams = [
        "prefixQueueName" => "", 
        "params" => [
            "ptBchCode" => "", "ptDocNo" => "", "ptUsrCode" => ""
        ]
    ];
 */
function FCNxRabbitMQDeleteQName($paParams) {
    $tPrefixQueueName = $paParams['prefixQueueName'];
    $aParams = $paParams['params'];
    $tQueueName = $tPrefixQueueName . '_' . $aParams['ptDocNo'] . '_' . $aParams['ptUsrCode'];
    // $oConnection = new AMQPStreamConnection('172.16.30.28', '5672', 'admin', '1234', 'Pandora_PPT1');
    $oConnection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
    $oChannel = $oConnection->channel();
    $oChannel->queue_delete($tQueueName);
    $oChannel->close();
    $oConnection->close();
    return 1; /** Success */

    
}


function FSaHRabbitMQUpdateStaDelQnameHD($paData){
    try{
        $tDocTableName      = $paData['tDocTableName'];
        $tDocFieldDocNo     = $paData['tDocFieldDocNo'];
        $tDocFieldStaApv    = $paData['tDocFieldStaApv'];
        $tDocFieldStaDelMQ  = $paData['tDocFieldStaDelMQ'];
        $tDocStaDelMQ       = $paData['tDocStaDelMQ'];
        $tDocNo             = $paData['tDocNo'];
            
        $ci = &get_instance();
        $ci->load->database();

        // Update HD
        $ci->db->set($tDocFieldStaDelMQ , 1);
        $ci->db->where($tDocFieldDocNo , $tDocNo);
        $ci->db->update($tDocTableName);

        
        if($ci->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Master Success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add/Edit Master.',
            );
        }
        return $aStatus;
    }catch(Exception $Error){
        return $Error;
    }

}
    function FCNxRabbitMQGetMassage($paData){

        /*$tQname = $paData['tQname'];
		$connection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
		$channel = $connection->channel();
        $channel->queue_declare($tQname, false, true, false, false);
        $message = $channel->basic_get($tQname);
        if(!empty($message)){
            $channel->basic_ack($message->delivery_info['delivery_tag']);
            $nProgress = intval($message->body);
        }else{
            $nProgress = 'false' ;
        }
        $channel->close();
        $connection->close();
        return $nProgress;*/

        try{
            $tQname     = $paData['tQname'];
            $connection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
            $channel    = $connection->channel();
            $channel->queue_declare($tQname, false, true, false, false);
            $message    = $channel->basic_get($tQname);

            if(!empty($message)){
                if(!empty($message->body)){
                    $channel->basic_ack($message->delivery_info['delivery_tag']);
                    $nProgress = intval($message->body);
                }else{
                    $nProgress = 'end' ;
                }
            }else{
                $nProgress = 'false';
            }

            $channel->close();
            $connection->close();
            return $nProgress;
        }catch(Exception $Error){
            return $Error;
        }
    }


    function FCNxRabbitMQGetMassageCurrentDaily($paData){

        /*$tQname = $paData['tQname'];
		$connection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
		$channel = $connection->channel();
        $channel->queue_declare($tQname, false, true, false, false);
        $message = $channel->basic_get($tQname);
        if(!empty($message)){
            $channel->basic_ack($message->delivery_info['delivery_tag']);
            $nProgress = intval($message->body);
        }else{
            $nProgress = 'false' ;
        }
        $channel->close();
        $connection->close();
        return $nProgress;*/

        try{
            $tQname     = $paData['tQname'];
            $connection = new AMQPStreamConnection(MQ_LOCKER_HOST, MQ_LOCKER_PORT, MQ_LOCKER_USER, MQ_LOCKER_PASS, MQ_LOCKER_VHOST);
            $channel    = $connection->channel();
            $channel->queue_declare($tQname, false, true, false, false);
            $message    = $channel->basic_get($tQname);

            if(!empty($message)){
                if(!empty($message->body)){
                    $channel->basic_ack($message->delivery_info['delivery_tag']);
                    $aArrayProgress = json_decode($message->body);
                    $nProgress = intval($aArrayProgress->rnProg);
                }else{
                    $nProgress = 'end' ;
                }
            }else{
                $nProgress = 'false';
            }

            $channel->close();
            $connection->close();
            return $nProgress;
        }catch(Exception $Error){
            return $Error;
        }
    }

