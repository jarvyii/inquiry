<?php
  require_once 'inquiry.php';

  $Shift = htmlspecialchars( $_GET['shift'] ) ;

  $P =  getdailyProd(  $Shift );

  echo json_encode($P);
  // echo  $P;
  return $P;
?>