<?php




require_once 'class/DataAccess.php';

if (! isset($_GET['idmachine']) or $_GET['idmachine'] == "" ) 
{
	echo "";
	return;
}



$idMachine = htmlspecialchars( $_GET['idmachine'] ) ;  

$objData = new DataAccess();

date_default_timezone_set("America/New_York");

$Shift = $objData -> getShift();

$dstartDateTime = $objData -> startShiftTime( $Shift );

 $P = $objData -> dailyOrders( $idMachine, $dstartDateTime  );

  echo json_encode($P);
  
  return $P; 

 
?>