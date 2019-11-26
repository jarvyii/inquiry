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
function getLocHistory($Order){
   $db_conn = new DataAccess(); 
   $tracksLoc = $db_conn ->getTrackLocHistory($Order);
   echo json_encode($tracksLoc);
   //return $tracksLoc; 

}

/********************************************
     checkOrder($Order)
    Return if the one specific order exist the Database.
*********************************************/
function checkOrder($Order){
   $db_conn = new DataAccess(); 
   $tracksLoc = $db_conn ->checkOrder($Order);
   if( $tracksLoc) {
      echo json_encode($tracksLoc);
   } else {
     echo "";
   }

   //return $tracksLoc; 

}


/******************************************************
Display all info using the Variable:
$BarCode, $OrderCode, $LineNumber
*******************************************************/
function TrackingDisplay($OrderNumber, $LineNumber, $Customer, $orderDate, $orderQtty, $Item) {

    viewTrackingDisplay($OrderNumber, $LineNumber);
    $Order = new DataAccess(); 
    //$headOrder = $Order -> getOrderHeader($OrderNumber, $LineNumber, $Machine);
   // $headOI = $Order ->getOrderItem($OrderNumber, $LineNumber);
    $tracksLoc = $Order ->getTrackLocHistory($OrderNumber);
    viewHead( $OrderNumber, $LineNumber, $Customer, $orderDate, $orderQtty, $Item);//$headOI);//$headOrder, $headOI);
   

} //TrackingDisplay

/**************************************
Display the Tracking Information
***************************************/

function TrackingInformation ($OrderNumber, $LineNumber, $Operator) {
   
   $objData = new DataAccess(); 
   $headOrder = $objData -> getOrderHeader($OrderNumber);
   //Order Item info.
   $headOI = $objData ->getOrderItem($OrderNumber);
   $qtyCmpted = $objData->qtyCompleted($OrderNumber);
   viewTrackingInformation($OrderNumber, $LineNumber, $Operator,$qtyCmpted, $headOrder, $headOI);
      
      
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
   $Order= substr($BarCode,0, $Pos);
   $objData = new DataAccess();
   $descMachine = $objData->getMachineDesc($idMachine);
   $qtyCmpted = $objData->qtyCompleted($Order);
   $headOrder = $objData->getOrderHeader($Order);
   //Order Item info.
   $headOI = $objData ->getOrderItem($Order);
   viewProduction($BarCode, $idMachine, $descMachine,$Operator, $qtyCmpted, $headOrder, $headOI);
  
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
