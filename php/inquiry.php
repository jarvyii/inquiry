<?php 
require_once 'class/DataAccess.php';
require_once 'Views/viewProduction.php';
require_once 'Views/viewInquiry.php';
require_once 'Views/ViewTracking.php';
require_once 'Views/viewTrackingDisplay.php';
require_once 'Views/viewTrackingInquiry.php'; 
require_once 'Views/viewTrackingInformation.php';



function getLocHistory($Order){
   $db_conn = new DataAccess(); 
   $tracksLoc = $db_conn ->getTrackLocHistory($Order);
   echo json_encode($tracksLoc);
   //return $tracksLoc; 

}

/******************************************************
Display all info using the Variable:
$BarCode, $OrderCode, $LineNumber
*******************************************************/
function TrackingDisplay($OrderNumber, $LineNumber) {

    viewTrackingDisplay($OrderNumber, $LineNumber);
    $Order = new DataAccess(); 
    $headOrder = $Order -> getOrderHeader($OrderNumber, $LineNumber, $Machine, $Operator);
    $headOI = $Order ->getOrderItem($OrderNumber, $LineNumber, $Machine, $Operator);
    $tracksLoc = $Order ->getTrackLocHistory($OrderNumber);
    viewHead( $OrderNumber, $LineNumber, $headOrder, $headOI);
   

} //TrackingDisplay

/**************************************
Display the Tracking Information
***************************************/

function TrackingInformation ($OrderNumber, $LineNumber, $Operator) {
   
   $Order = new DataAccess(); 
   $headOrder = $Order -> getOrderHeader($OrderNumber, $LineNumber, $Operator);
   //Order Item info.
   $headOI = $Order ->getOrderItem($OrderNumber, $LineNumber, $Operator);
   viewTrackingInformation($OrderNumber, $LineNumber, $Operator, $headOrder, $headOI);
      
      
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
function Production($BarCode, $Machine, $Operator) {
   viewProduction($BarCode, $Machine, $Operator);
  
}
function endProduction($Operator, $Barcode, $Machine, $startTime, $stopTime){
   $Pos = strpos($Barcode, "/");
   $OrderNumber = substr($Barcode,0, $Pos);
   $LineNumber =  substr($Barcode, $Pos+1);
   $Order  = new DataAccess(); 
   $Order -> insertHistoric($OrderNumber, $LineNumber, $Machine, $Operator,$startTime, $stopTime, 1);
}
?>
