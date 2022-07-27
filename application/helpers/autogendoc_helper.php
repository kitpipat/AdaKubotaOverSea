<?php

  function FCNaHAUTGenDocNo($paParam){

    $ci = &get_instance();
    $ci->load->database();

    $tSP = "SP_CNtAUTAutoDocNo ?,?,?,?,?,?,?"; //No exec or call needed

    //No @ needed.  Codeigniter gets it right either way
    $aSPParams = array(
      'ptTblName' => $paParam['tTblName'],
      'ptDocType' => $paParam['tDocType'],
      'ptBchCode' => $paParam['tBchCode'],
      'ptShpCode' => $paParam['tShpCode'],
      'ptPosCode' => $paParam['tPosCode'],
      'pdDocDate' => $paParam['dDocDate'],
      'ptResult' => ''
    );

    $oQuery = $ci->db->query($tSP,$aSPParams);

    return $oQuery->result_array();

  }
?>
