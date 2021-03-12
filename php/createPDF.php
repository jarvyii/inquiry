<?php
require_once 'inquiry.php';
require_once 'topdf.php';

function createPDF()
{ 
  $pdf = new PDF('P','mm','Letter');

  // Column headings
  $header = array('Machine', 'QTY', 'HOURS', 'TOTAL COST');

  $data = $pdf->LoadData();

  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Arial','',12);
  $pdf->BasicTable($header,$data);
  
  $pdf->Output(); 
}


createPDF();






 
  echo json_encode("OK");
  // echo  $P;
  return ;
?>