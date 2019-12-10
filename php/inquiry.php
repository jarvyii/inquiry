<?php 
require_once 'class/DataAccess.php';
require_once 'Views/viewProduction.php';
require_once 'Views/viewInquiry.php';
require_once 'Views/ViewTracking.php';
require_once 'Views/viewTrackingDisplay.php';
require_once 'Views/viewTrackingInquiry.php'; 
require_once 'Views/viewTrackingInformation.php';

/*************************************************
       getLocHistory($Order)
    Return the historic of one order from the table FMLOCHIST
**************************************************/
function getLocHistory($OrderNumber, $Line ){
   
   $db_conn = new DataAccess(); 
   $tracksLoc = $db_conn ->getTrackLocHistory($OrderNumber, $Line);
   //echo "Line:". $Line;
   echo json_encode($tracksLoc);
   //return $tracksLoc; 

}

/********************************************
     checkOrder($Order)
    Return if the one specific order exist the Database.
*********************************************/
function checkOrder($Order, $Line){
   $db_conn = new DataAccess(); 
   $tracksLoc = $db_conn ->checkOrder($Order, $Line);
   if( $tracksLoc) {
      echo json_encode($tracksLoc);
   } else {
     echo "";
   }

   

}
/****************************************
        checkOverrideCode($Code)
 Access the Database to validate the Code to override the production
 Its called from ControllerInquiry.php
******************************************/
function checkOverrideCode($Code){
   $db_conn = new DataAccess(); 
   $Supervisor = $db_conn ->checkOverrideCode($Code); // Return True if the name of supervisor.
   if( $Supervisor) {
      echo json_encode($Supervisor);
   } else {
     echo "";
   }
}

/******************************************************
Display all info using the Variable:
$BarCode, $OrderCode, $LineNumber
*******************************************************/
function TrackingDisplay($OrderNumber, $LineNumber, $Customer, $orderDate, $orderQtty, $Item) {

    viewTrackingDisplay($OrderNumber, $LineNumber);
   // $objData = new DataAccess(); 
    //$headOrder = $Order -> getOrderHeader($OrderNumber, $LineNumber, $Machine);
   // $headOI = $Order ->getOrderItem($OrderNumber, $LineNumber);
   // $tracksLoc = $objData ->getTrackLocHistory($OrderNumber);
    viewHead( $OrderNumber, $LineNumber, $Customer, $orderDate, $orderQtty, $Item);//$headOI);//$headOrder, $headOI);
   

} //TrackingDisplay

/**************************************
Display the Tracking Information
***************************************/

function TrackingInformation ($OrderNumber, $Operator) {
   $Pos = strpos($OrderNumber, "/");;//strpos($Barcode, "/");
   if ( ($Pos >= 0) and !empty($Pos) ){
       $Order = substr($OrderNumber,0, $Pos);
       $LineNumber =  substr($OrderNumber, $Pos+1);

       if (!empty($LineNumber)){ 
           $objData = new DataAccess(); 
           if ( !empty($objData->checkOrder($Order, $LineNumber))) {  
             $headOrder = $objData -> getOrderHeader($Order, $LineNumber);
             //Order Item info.
             $headOI = $objData ->getOrderItem($Order, $LineNumber);
             $qtyCmpted = $objData->qtyCompleted($Order, $LineNumber );
             viewTrackingInformation($Order, $LineNumber, $Operator,$qtyCmpted, $headOrder, $headOI);
             return;
          }
        }
     }
   TrackingInquiry($Operator);
   
      
}//TrackingInformation ()

/*******************************************************
Get this Variable  $BarCode, $Machine, $Operator from Operator to be use
********************************************************/

function TrackingInquiry( $Operator){
   //( $BarCode, $Machine, $Operator)
 
  viewTrackingInquiry( $Operator); //($BarCode, $Machine, $Operator); 
}


/**************************************
       function Tracking($UserName)
***************************************/
function Tracking($UserName) {
   viewTracking($UserName);
  
}
function Production($BarCode, $idMachine, $Operator) {
   $Pos = strpos($BarCode, "/");
   if ( ($Pos >= 0) and !empty($Pos) ) {
        $Order= substr($BarCode,0, $Pos);
        $LineNumber =  substr($BarCode, $Pos+1);
      if (!empty($LineNumber)) {
          $objData = new DataAccess();
          if ( !empty($objData->checkOrder($Order, $LineNumber))) {  
             $descMachine = $objData->getMachineDesc($idMachine);
             $qtyCmpted = $objData->qtyCompleted($Order, $LineNumber);
             $headOrder = $objData->getOrderHeader($Order, $LineNumber);
             //Order Item info.
             $headOI = $objData ->getOrderItem($Order, $LineNumber);
             viewProduction($BarCode, $idMachine, $descMachine,$Operator, $qtyCmpted, $headOrder, $headOI);
             return;
         }
      }
    }
   viewTracking($Operator);
  
}
function endProduction($Param /*$Operator, $Barcode, $Machine, $startTime, $stopTime, $Qtty*/){
   $Pos = strpos($Param["barcode"], "/");;//strpos($Barcode, "/");
   $Order = substr($Param["barcode"],0, $Pos);
   $LineNumber =  substr($Param["barcode"], $Pos+1);
   $Param["order"] =  $Order;
   $Param["line"] = $LineNumber;
   $objData  = new DataAccess(); 
   $objData -> insertHistoric($Param);
  }
?>
