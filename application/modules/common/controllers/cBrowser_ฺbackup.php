<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cBrowser extends MX_Controller {

    public function __construct() {

        parent::__construct ();
        $this->load->helper('url');
        //$this->load->model ('common/mBrowser','mBrowser');

    }

    public function index() {
           $tIDCurrent  = '';
           $oPtions     = $this->input->post('paOptions');
       
           if($oPtions != '' || $oPtions !='undefined'):

           $tLangPath = $oPtions['Title'][0]; //โฟลเดอร์ภาษา
           $tLangKey = $oPtions['Title'][1];//Key ภาษา

           $tPopupTitle = language($tLangPath,$tLangKey); //Popup Title Bar

           $tMasterTable = $oPtions['Table']['Master']; // Master Table
           $tMasterPK = $oPtions['Table']['PK']; // Master PK
           @$tMasterPKName = $oPtions['Table']['PKName']; // Master PK
           $tMasterFK = (isset($oPtions['Table']['FK']))? $oPtions['Table']['FK'] : ''; // Master PK
           $CallBackType = $oPtions['CallBack']['ReturnType'];


           $tColPk= $tMasterTable.".".$tMasterPK;
       
           if($this->input->post('nCurentPage') !=''):
              $nCurentPage = $this->input->post('nCurentPage');
           else: 
              $nCurentPage = 1;
           endif;

           if($this->input->post('tOptions') !=''):
            $tOptions = $this->input->post('tOptions');
           else: 
                echo 'Error: Do not set options';
                exit();
           endif;
     
           
           $tOldCallBackVal = $this->input->post('tCallVal');
           if(isset($tOldCallBackVal)):
               $tOldCallBackVal = $tOldCallBackVal;
           else: 
               $tOldCallBackVal = '';
           endif;

           $tOldCallBackText = $this->input->post('tCallText');
           if(isset($tOldCallBackText)):
              $tOldCallBackText = $tOldCallBackText;
           else: 
              $tOldCallBackText = '';
           endif;

        
           if(isset($oPtions['CallBack']['Text'])):
              $tCallBackTextColumn = explode('.',$oPtions['CallBack']['Text'][1]);
           else: 
              $tCallBackTextColumn = '';
           endif;

           $tCallBackColumn = $tCallBackTextColumn[1];

           
           
           
           if($oPtions['GrideView']['Perpage']):
             $nPerPage = $oPtions['GrideView']['Perpage'];
           else: 
             $nPerPage = 5;
           endif;

           $aRowLen = FCNaHCallLenData($nPerPage,$nCurentPage); //Parameter [1] = Limit/Page [2] = PageNo

            $tSQL = "SELECT top 15000 Result.* FROM (";
            $tSQL.= "SELECT ROW_NUMBER() OVER(ORDER BY $tColPk ASC) AS rtRowID , ";
            
            //Select Column From Options
            if(isset($oPtions['GrideView'])):
                if(isset($oPtions['GrideView']['DataColumns'])):
                   $aColumns = $oPtions['GrideView']['DataColumns']; // Return Column

                    if(is_array($aColumns)):
                        $tColumns = implode(',',$aColumns);
                        $tSQL.=" $tColumns ";  
                    else: 
                        echo  "Error:No column select.";
                        exit();
                    endif;
                else: 
                        echo  "Error:No column select.";
                        exit();
                endif;

            else: 
                    echo  "Error: No column select.";
                    exit();

            endif;

            //end select column

            $tSQL.= " FROM $tMasterTable "; // select from master table
            
            //Join Table if Has Join Options
            if(isset($oPtions['Join']['Table'])):
                for($j = 0; $j<count($oPtions['Join']['Table']);$j++){
                    $tSQL.= " LEFT JOIN ".$oPtions['Join']['Table'][$j]." On ".$oPtions['Join']['On'][$j]." ";
                }
            endif;

            // if(isset($oPtions['GrideView']['WhereSearch'])):
            //     $tWhereSearch = $oPtions['GrideView']['WhereSearch'];
            // else: 
            //     $tWhereSearch = '';
            // endif;
            
            $tSQL.= " WHERE 1=1 ";

            //Where
            //Filter Where In Statement
            if(isset($oPtions['Where'])):
                    if($oPtions['Where']['Condition']):
                        for($w = 0; $w<count($oPtions['Where']['Condition']);$w++){
                            $tSQL.= " ".$oPtions['Where']['Condition'][$w];
                        }
                    endif;
           
            endif;
            
            //Filter Data From Selector Browse
            if(isset($oPtions['Filter'])):
                $tFilter = $this->input->post('tFileter');
                if($tFilter != ''):
                    if($oPtions['Filter']['Table'] != '' and $oPtions['Filter']['Key'] != ''):
                        $tTableFilter = $oPtions['Filter']['Table'].".".$oPtions['Filter']['Key'];
                        $tSQL.= " AND $tTableFilter = '".$tFilter."'";
                    endif;
                endif;
            endif;
            
            

            $tFilerGride = $this->input->post('tFilerGride'); //Filter Value
            
            //Filter Data From Filter Element
            if(isset($tFilerGride)):
                if($tFilerGride != ''):
                    $tSQL.= " AND ( $tColPk LIKE '$tFilerGride%' ";
                    for($fc = 0; $fc<count($oPtions['GrideView']['DataColumns']);$fc++):
                        $tFilterCol = $oPtions['GrideView']['DataColumns'][$fc];
                    
                        $tSQL.= "  OR $tFilterCol LIKE '$tFilerGride%' ";
                    endfor;
                    $tSQL.= " ) ";
                endif;
            endif;

            $tSQL.= " ) AS Result ";
            
            $tFinalQuery = $tSQL;
            $tFinalQuery.= " WHERE  Result.rtRowID > ".$aRowLen[0]." AND Result.rtRowID <=". $aRowLen[1];
            
            if(isset($oPtions['NotIn'])):
                $tNotIn = $this->input->post('tNotIn');
                if($tNotIn != ''):
                    if($oPtions['NotIn']['Table'] != '' and $oPtions['NotIn']['Key'] != ''):
                        $tTableFilter = "Result".".".$oPtions['NotIn']['Key'];
                        $tFinalQuery.= " AND $tTableFilter NOT IN ('".$tNotIn."')";
                    endif;
                endif;
            endif;

            //echo $tSQL."<hr>";
            //echo $tFinalQuery."<hr>";

            $oQuery = $this->db->query($tFinalQuery);
            
            //Get Total Record From Query
            $nTotalRecord = ceil($this->FMnCBWSGetRecord($tSQL)); //Total Record From Qurey


            $aDataTable = $oQuery->result();

                //Display Grid Table
                //$tDataTable = "<div class='container'>";
                
                /*Fix By Krit 28/06/2018*/
                /*เพื่อเก็บ Route ก่อนหน้าที่มา จะได้เอาไปเช็คว่ามาจากหน้าอ่ะไร? */
                if(isset($oPtions['RouteFrom'])){
                    $tRouteFromName = $oPtions['RouteFrom'];
                }else{
                    $tRouteFromName = 'EmptyRouteFrom';
                }

                if(isset($oPtions['RouteAddNew'])){ 
                    $tFormAddRouteName = $oPtions['RouteAddNew'];
                }else{ $tFormAddRouteName = 'EmptyRoute'; }

                $tInformation = language('common/main/main','tShowData');  
                $tConfirm     = language('common/main/main','tModalConfirm');
                $tCancel      = language('common/main/main','tCancel');

                // Modal Header
                $tDataTable = '<div class="modal-header xCNModalHead">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;">'.$tInformation.' : '.$tPopupTitle.'</label>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JCNxConfirmSelected('."'".$tOptions."'".')">'.$tConfirm.'</button>
                                            <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal">'.$tCancel.'</button>
                                        </div>
                                    </div>
                                </div>';
                // Start Modal Body         
                $tDataTable .= '<div class="modal-body">';
                $tDataTable .= '<div class="row">';
                //Search bar
                $tDataTable .= "<div class='col-xs-6 col-sm-6 col-md-5 col-lg-5'>";
                $tDataTable .= "<div class='form-group'>";
                $tDataTable .= "<div class='input-group'>";
                $tDataTable .= '<input class="form-control oetTextFilter" type="text" id="oetSearchTable" value="'.$tFilerGride.'" onkeypress="Javascript:if(event.keyCode==13 ) JCNxSearchBrowse('."'1',"."'".$tOptions."'".')" autocomplete="off" placeholder="Search">';
                $tDataTable .= "<span class='input-group-btn'>";
                $tDataTable .= '<button id="" class="btn xCNBtnSearch" type="button" onclick="JCNxSearchBrowse('."'1',"."'".$tOptions."'".')">';
                $tDataTable .= '<i class="fa fa-search"></i>';
                $tDataTable .= "</button>";
                $tDataTable .= "</span>";
                $tDataTable .= "</div>";
                $tDataTable .= "</div>";
                $tDataTable .= "</div>";
                if(isset($oPtions['BrowseLev'])){
                    if($oPtions['BrowseLev'] != 1){
                        $tDataTable .= "<div class='col-xs-6 col-sm-6 col-md-7 col-lg-7 text-right'>
                                            <button class='xCNBtnPushModalBrowse' onclick=JCNxAddNewData('".$tFormAddRouteName."',1,'".$tOptions."','".$tRouteFromName."')>+</button>
                                        </div>";
                    }
                }else{
                    // ซ่อนปุ่ม Add ของ เครื่องจุดขาย 
                    // $tDataTable .= "<div class='col-xs-6 col-sm-6 col-md-7 col-lg-7 text-right'>
                    //                     <button class='btn xCNBTNPrimery' onclick=JCNxAddNewData('".$tFormAddRouteName."',1,'".$tOptions."','".$tRouteFromName."')>
                    //                         <i class='fa fa-plus' style='font-size: 10px;'>
                    //                             <span> ".language('common/main/main','tAdd').$tPopupTitle."<span>
                    //                         </i>
                    //                     </button> 
                    //                 </div>";
                }
                $tDataTable .= "</div>";

                //Grid Table
                $tDataTable .= "<div class='row'>";
                $tDataTable .= "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";
                $tDataTable .= "<div class='table-responsive'>"; // Start Table Reponsive
                $tDataTable .= "<table id='otbBrowserList' class='table table-striped' style='width:100%'>";
                $tDataTable .= "<thead>"; // Start tHeard
                $tDataTable .= "<tr>";
                //$tDataTable .= "<th class='xCNTextBold' style='width:15%;text-align:center'>".language('common/main/main','tCMNChoose')."</th>";
                    for($c = 0; $c<count($oPtions['GrideView']['DataColumns']);$c++):
                     

                            if(isset($oPtions['GrideView']['ColumnsSize'][$c])){ 
                                $nColumnSize = $oPtions['GrideView']['ColumnsSize'][$c];
                            }else{ $nColumnSize = ''; }

                            $tCollangPath = $oPtions['GrideView']['ColumnPathLang'];

                            if(isset($oPtions['GrideView']['ColumnKeyLang'][$c])):
                                
                                $tCollangKey = $oPtions['GrideView']['ColumnKeyLang'][$c];
                                //$tCollangKey = $tCollangKey;
                            else: 
                                $tCollangKey = "N/A";
                            endif;
                            if(isset($oPtions['GrideView']['DisabledColumns'])):
                                if($this->JCNtColDisabled($c,$oPtions['GrideView']['DisabledColumns']) == false):
                                // $tDataTable.= "<td>".$tDataDisPlay."</td>";
                                
                                    $tDataTable.= "<th class='xCNTextBold' style='text-align:center' width='$nColumnSize'>".language($tCollangPath,$tCollangKey)."</th>";
                            

                                endif;
                            else :
                                    $tDataTable.= "<th class='xCNTextBold' style='text-align:center' width='$nColumnSize'>".language($tCollangPath,$tCollangKey)."</th>";
                            endif;
                        
                    endfor;
                $tDataTable .= "</tr>";
                $tDataTable .= "</thead>";// End Thead
                
                if ($oQuery->num_rows() > 0) :
                    $nIdx = 0;
                    $tRowActive = '';
                    
                    if($tMasterFK != ''){
                        $tMasterPK = $tMasterFK;
                    }

                    foreach($aDataTable as $key=>$val):
                            
                        if($tIDCurrent != $val->$tMasterPK):

                            if(isset($oPtions['CallBack']['StaSingItem'])){

                                if($oPtions['CallBack']['StaSingItem'] == '1'){
                                    $tIDCurrent        = $val->$tMasterPK;
                                }

                            }
                        // $tIDCurrent        = $val->$tMasterPK;

                        $tCallBackTextData = $val->$tCallBackColumn;
                       
                        if($CallBackType == 'S'):
                        
                            if ($val->$tMasterPK == $tOldCallBackVal) {
                                //Option Sta Doc
                                if(isset($oPtions['CallBack']['StaDoc'])){
                                    $CallBackStaDoc = $oPtions['CallBack']['StaDoc'];
                                    if($CallBackStaDoc == 1){
                                        $tRowActive = "xCNHide";
                                    }else{
                                        $tRowActive = "active";
                                    }
                                }else{
                                    $tRowActive = "active";
                                }
                            }else{
                                $tRowActive = "";
                            }

                            $tDataTable.= '<tr class="xCNTextDetail2 '.$tRowActive.'" onclick="JCNxPushSelection('."'".$val->$tMasterPK."',this".')">';
                           
                        elseif($CallBackType == 'M'):
                            if(is_array($tOldCallBackVal)){
                                if (in_array($val->$tMasterPK, $tOldCallBackVal)) {
                                   
                                    //Option Sta Doc
                                    if(isset($oPtions['CallBack']['StaDoc'])){
                                        $CallBackStaDoc = $oPtions['CallBack']['StaDoc'];
                                        if(($CallBackStaDoc == 1) || ($CallBackStaDoc == 2)){
                                            if($CallBackStaDoc == 1){ // Hide for select
                                                $tRowActive = "xCNHide";
                                            }
                                            if($CallBackStaDoc == 2){ // Show with unactive
                                                $tRowActive = "";
                                            }
                                        }else{
                                            $tRowActive = "active";
                                        }
                                    }else{
                                        $tRowActive = "active";
                                    }

                                }
                                else{
                                    $tRowActive = "";
                                }
                            }else{
                                $tRowActive = "";
                            }
                            
                            $tDataTable.= '<tr class="xCNTextDetail2 '.$tRowActive.' " onclick="JCNxPushMultiSelection('."'".$val->$tMasterPK."','".$tCallBackTextData."',this".')">';
                        else: 
                            $tDataTable.= '<tr class="xCNTextDetail2" onclick="JCNxPushSelection('."'".$val->$tMasterPK."',this".')">';
                        endif;

                        if(isset($oPtions['NextFunc']['ArgReturn'])):
                            //echo $oPtions['NextFunc']['ArgReturn'][0];
                            $aArgRet = array();
                            for($g = 0;$g<count($oPtions['NextFunc']['ArgReturn']);$g++){
                                $tAgrCol = $oPtions['NextFunc']['ArgReturn'][$g];
                                $aArgRet[$g] =  $val->$tAgrCol;
                            }
                           
                            $tDataTable.= "<input type='text' style='display:none' id='ohdCallBackArg".$val->$tMasterPK."' value='".json_encode($aArgRet)."'".">";
                        endif;

                        $tDataTable.= "<input type='text' style='display:none' id='ohdCallBackText".$val->$tMasterPK."' value='".$val->$tCallBackColumn."'".">";
                        
                        $tDataTable.= "</td>";
                        for($f = 0; $f<count($oPtions['GrideView']['DataColumns']);$f++):

                            $aColumnVal = explode('.',$oPtions['GrideView']['DataColumns'][$f]);
                            $tColumnVal = $aColumnVal[1];

                            if(isset($oPtions['GrideView']['DataColumnsFormat'])):
                                  if(isset($oPtions['GrideView']['DataColumnsFormat'][$f])):
                                      if($oPtions['GrideView']['DataColumnsFormat'][$f] !=''):
                                        $aColumnFormat = explode(":",$oPtions['GrideView']['DataColumnsFormat'][$f]);
                                        $tFomatType = $aColumnFormat[0];
                                        $tFomatVal = $aColumnFormat[1];
                                      else: 
                                        $tFomatType = '';
                                        $tFomatVal = '';
                                      endif;

                                      switch($tFomatType){
                                         case '':
                                               $tDataDisPlay = $val->$tColumnVal;
                                               $tTextAlign = "left!important";
                                         break;

                                         case 'Text':
                                               $tDataDisPlay = $this->JCNtFormatText($tFomatVal,$val->$tColumnVal);
                                               $tTextAlign = "left!important";
                                         break;

                                         case 'Date':
                                               $tDataDisPlay = $this->JCNtFormatDate($tFomatVal,$val->$tColumnVal);
                                               $tTextAlign = "left!important";
                                         break;

                                         case 'Currency':
                                               if(isset($aColumnFormat[2])):
                                                  $tCurrencySign = $aColumnFormat[2];
                                               else: 
                                                  $tCurrencySign = '&#3647;';
                                               endif;

                                               
                                               $tDataDisPlay = $this->JCNtFormatCurrency($tFomatVal,$val->$tColumnVal,$tCurrencySign);
                                               $tTextAlign = "right!important";
                                         break;

                                         case 'Number':
                                               $tDataDisPlay = number_format($val->$tColumnVal);
                                               $tTextAlign = "right!important";
                                         break;

                                         default: 
                                               $tDataDisPlay = $val->$tColumnVal;
                                               $tTextAlign = "left!important";
                                         break;
                                      }
                                  else:
                                   
                                  endif;
                            else:

                                 $tDataDisPlay = $val->$tColumnVal;
                                 $tTextAlign = "left!important";
                            endif;

                            if(isset($oPtions['GrideView']['DisabledColumns'])){
                                    if($this->JCNtColDisabled($f,$oPtions['GrideView']['DisabledColumns']) == false){
                                        
                                            //($tDataDisPlay == '' or $tDataDisPlay == null ? "-" : $tDataDisPlay)
                                           

                                            $tDataTable.= "<td style='text-align:$tTextAlign'>".$this->JCNtColChkNull($tDataDisPlay)."</td>";
                                     
                                    
                                    }
                            }else{
                                $tDataTable.= "<td style='text-align:$tTextAlign'>".$this->JCNtColChkNull($tDataDisPlay)."</td>";
                            }
                            
                        endfor;

                        $tDataTable.= "</tr>";

                        $nIdx++;

                    endif;   
                    endforeach;
                else:
                    $nCountColData = count($oPtions['GrideView']['DataColumns']);
                    $nColspan =  $nCountColData +1;

                    $tDataTable.= "<tr><td colspan='".$nColspan."' style='text-align:center';>";
                    $tDataTable.=language('common/main/main','tCMNNotFoundData');
                    $tDataTable.= "</td></tr>";
                endif;
                $tDataTable .= "</table>"; //end Table
                $tDataTable .= "</div>"; // End Div class Table Reponsive
                $tDataTable .= "</div>"; //end col-12
                $tDataTable .= "</div>"; //end row grid table

                //Row Pagination
                $tDataTable.= "<div class='row'>";

                 //PageNation show info
                $nTotalPage = ceil($nTotalRecord / $nPerPage);

                if($nCurentPage == 1):
                    $nPrvPage = 1;
                else: 
                    $nPrvPage = $nCurentPage - 1;
                endif;

                if($nCurentPage == $nTotalPage):
                    $nNextPage = $nTotalPage;
                else: 
                    $nNextPage = $nCurentPage +1;
                endif;

                $tDataTable.="<div class='col-xs-12 col-md-6'>";
                $tDataTable.=language('common/main/main','tResultTotalRecord');
                $tDataTable.=" ".number_format($nTotalRecord)." ";
                $tDataTable.=language('common/main/main','tRecord');
                $tDataTable.=" ";
                $tDataTable.=language('common/main/main','tCurrentPage');
                $tDataTable.=" ".($nCurentPage == "" ? "1" : $nCurentPage)." / ".$nTotalPage;
                $tDataTable.="</div>"; 
                //end page info

                if($nTotalPage > 0):
    
                //PageNation page number
                if($nCurentPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '';}
                $tDataTable.="<div class='col-xs-12 col-md-6 text-right'>";
                $tDataTable.='<div class="btn-toolbar pull-right">';
                $tDataTable.='<button onclick="JCNxSearchBrowse('."'".$nPrvPage."',"."'".$tOptions."'".')" class="btn btn-white btn-sm" '.$tDisabledLeft.'>';
                $tDataTable.='<i class="fa fa-chevron-left f-s-14 t-plus-1"></i>';
                $tDataTable.='</button>';    
                        
                for($p = 1;$p<=$nTotalPage;$p++):

                    //Set Page Active
                    if($p == $nCurentPage):
                        $tActived = "active";
                    else:
                        $tActived = "";
                    endif;
                    //End Page Active
                    
                    //Get  Limit Display Page
                    if($nCurentPage == 1):
                       $nStartPage = 1;
                       $nEndPage = 3;
                    else:
                        if($nCurentPage == $nTotalRecord):
                            $nStartPage = $nTotalRecord - 2;
                            $nEndPage = $nTotalRecord;
                        else: 
                            $nStartPage = $nCurentPage - 1;
                            $nEndPage = $nCurentPage + 1;
                        endif;
                    endif;
                    //Get  Limit Display Page
                    
                    //Set  Limit Display Page
                    if($p >= $nStartPage and $p<=$nEndPage):
                        $tDataTable.='<button onclick="JCNxSearchBrowse('.$p.",'".$tOptions."'".')" type="button" class="page-item btn xCNBTNNumPagenation '.$tActived.'">'.$p.'</button>';   
                    endif;
                    //End Set Limit Display Page

                endfor;
                //End Page Number
 
                if($nCurentPage >= $nTotalPage){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '';  }
                $tDataTable.='<button onclick="JCNxSearchBrowse('."'".$nNextPage."',"."'".$tOptions."'".')" class="btn btn-white btn-sm" '.$tDisabledRight.'>';
                $tDataTable.='<i class="fa fa-chevron-right f-s-14 t-plus-1"></i>';
                $tDataTable.='</button>';    
                $tDataTable.="</div>";
                $tDataTable.="</div>";
                //End PageNation page number

                endif; //End Check Total Page
                $tDataTable .= "</div>"; //end row pagenation
                $tDataTable .= "<div id='odvDataMultiSelection'>";
                    //multi Browse เลือก master ที่ทำการเลือก ลงใน Modal Browse เพื่อกดยืนยันแล้วข้อมูลไม่หาย
                    //Adj : Copter 
                    //Date : 03/12/2018 
                    foreach($aDataTable as $key=>$val){
                        if(is_array($tOldCallBackVal)){
                            if (in_array($val->$tMasterPK, $tOldCallBackVal)) {
                                $tDataTable .= '<span class="olbVal'.$val->$tMasterPK.'" data-val="'.$val->$tMasterPK.'" data-text="'.$val->$tMasterPKName.'"></span>';
                            }
                        }
                    }
                $tDataTable .= " </div>";
                $tDataTable .= "</div>"; //end Modal Body
                //CallBack
                if($CallBackType == 'S'){
                $tDataTable.= '<input type="text" id="oetCallBackVal" style="display:none" value="'.$tOldCallBackVal.'">';
                $tDataTable.= '<input type="text" id="oetCallBackText" style="display:none" value="'.$tOldCallBackText.'">';
                }

             
                //$tDataTable.= "</div>"; //end containner

               

                echo $tDataTable; //Display Grid Table   
            else: 
                echo 'Error: Invarid Options';
            endif;

            if(isset($oPtions['DebugSQL'])):
                if($oPtions['DebugSQL'] == true):
                   echo $tSQL;
                endif;
            endif;
     
    }

    private function  FMnCBWSGetRecord($ptQuery){

            $oQuery = $this->db->query($ptQuery);
            return $oQuery->num_rows();
    } 

    private function JCNtFormatText($paFomatSetVal,$ptOriData){
            
            if($paFomatSetVal != ''):
               return substr($ptOriData,0,$paFomatSetVal);
            else: 
               return $ptOriData;
            endif;
    }

    private function JCNtFormatDate($paFomatSetVal,$ptOriData){
            
            if($paFomatSetVal != ''):
               switch($paFomatSetVal){

                   case 'YYYY-MM-DD':
                         return substr($ptOriData,0,10);
                   break;

                   case 'DD-MM-YYYY':

                        $tNewDataFormat =  substr($ptOriData,0,10);

                        $aNewDataFormat = explode("-",$tNewDataFormat);

                        return $aNewDataFormat[2]."-".$aNewDataFormat[1]."-".$aNewDataFormat[0];

                   break;

                   case 'MM-DD-YYYY':

                        $tNewDataFormat =  substr($ptOriData,0,10);

                        $aNewDataFormat = explode("-",$tNewDataFormat);

                        return $aNewDataFormat[1]."-".$aNewDataFormat[2]."-".$aNewDataFormat[0];
                   break;

                   case 'YYYY/MM/DD':
                         $tNewDataFormat =  substr($ptOriData,0,10);

                         $aNewDataFormat = explode("-",$tNewDataFormat);

                         return $aNewDataFormat[0]."/".$aNewDataFormat[1]."/".$aNewDataFormat[2];

                   break;

                   case 'DD/MM/YYYY':
                         $tNewDataFormat =  substr($ptOriData,0,10);

                         $aNewDataFormat = explode("-",$tNewDataFormat);

                         return $aNewDataFormat[2]."/".$aNewDataFormat[1]."/".$aNewDataFormat[0];

                   break;

                   case 'MM/DD/YYYY':
                         $tNewDataFormat =  substr($ptOriData,0,10);

                         $aNewDataFormat = explode("-",$tNewDataFormat);

                         return $aNewDataFormat[1]."/".$aNewDataFormat[2]."/".$aNewDataFormat[0];

                   break;

                   default: 
                        return substr($ptOriData,0,10);
                   break;
               }
               
            else: 
               return $ptOriData;
            endif;
    }

    private function JCNtFormatCurrency($paFomatSetVal,$ptOriData,$ptCurrencySign){
            
        if($paFomatSetVal != ''):
            $cCurrency = number_format($ptOriData,$paFomatSetVal);
            return $ptCurrencySign.' '.$cCurrency;
        else: 
            $cCurrency = number_format($ptOriData);
           return $ptCurrencySign.' '.$cCurrency;
        endif;
    }

    private function JCNtColDisabled($pnInx,$paDisable){
         
        if (in_array($pnInx, $paDisable)){
            return true;
        }else{
            return false;
         }
        
    }

    private function JCNtColChkNull($ptData){
         
        if ($ptData != '' || $ptData != null){
            return $ptData;
        }else{
            return '-';
         }
        
    }
} 

//New Version


