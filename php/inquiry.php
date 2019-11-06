<?php 
require_once 'Views/viewInquiry.php';
require_once 'Views/ViewTracking.php';
require_once 'Views/viewTrackingInquiry.php'; 
require_once 'Views/viewTrackingInformation.php';
require_once 'Views/viewTrackingDisplay.php';
require_once 'class/DataAccess.php';


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

function TrackingInformation ($OrderNumber, $LineNumber, $Machine, $Operator) {
   
   $Order = new DataAccess(); 
   $headOrder = $Order -> getOrderHeader($OrderNumber, $LineNumber, $Machine, $Operator);
   //Order Item info.
   $headOI = $Order ->getOrderItem($OrderNumber, $LineNumber, $Machine, $Operator);
   viewTrackingInformation($OrderNumber, $LineNumber, $Machine, $Operator, $headOrder, $headOI);
      
      
}//TrackingInformation ()

/*******************************************************
Get this Variable  $BarCode, $Machine, $Operator from Operator to be use
********************************************************/

function TrackingInquiry( $BarCode, $Machine, $Operator){
 
  viewTrackingInquiry($BarCode, $Machine, $Operator); 
}


/**************************************
       function Tracking($UserName)
***************************************/
function Tracking($UserName) {
   viewTracking($UserName);
  
}
?>
