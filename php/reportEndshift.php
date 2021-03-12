<?php
require_once 'FPDF/fpdf.php';

class PDF extends FPDF
{
  // Load data
function LoadData()
{
    $totalRow = (int) htmlspecialchars( $_POST['totalrow'] ) ; 
    $data = array();
    //$rows = "";

    for( $i=0; $i< $totalRow; $i++) {
     
        $machIndex = "Mach". $i;
        $Descript =  htmlspecialchars( $_POST[$machIndex] ) ; 


        $QtyIndex = "Qty". $i;
        $Qty = htmlspecialchars( $_POST[$QtyIndex] ) ; 

        $sqftIndex = "SqFt". $i;
        $SqFt = htmlspecialchars( $_POST[$sqftIndex] );

        $boardsIndex = "Boards". $i;
        $Boards = htmlspecialchars( $_POST[$boardsIndex] );

        $sheetsIndex = "Sheets". $i;
        $Sheets = htmlspecialchars( $_POST[$sheetsIndex] );        

        $HoursIndex = "Hours". $i;
        $Hours = htmlspecialchars( $_POST[$HoursIndex] );

        $MinIndex = "Min". $i;
        $Min = htmlspecialchars( $_POST[$MinIndex] );
        $Time = $Hours.":". $Min;

        $hourrateIndex = "HourRate". $i;
        $HourRate = htmlspecialchars( $_POST[$hourrateIndex] );

        $ttlcostIndex = "TtlCost". $i;
        $TtlCost = htmlspecialchars( $_POST[$ttlcostIndex] );
        
      //  $rows = $rows. '<tr><td>' . $Descript .'</td><td>'. $Qty . '</td><td>'. $SqFt . '</td><td>'. $Boards . '</td><td>'. $Sheets . '</td><td>'. $Time . '</td><td>'. $HourRate . '</td><td>'. $TtlCost . '</td></tr>';

        $data[] = explode(';', $Descript .';'. $Qty . ';' . $SqFt . ';' . $Boards. ';' . $Sheets. ';' . $Time. ';' . $HourRate. ';' . $TtlCost);

    }
    
    return $data;
}
// Simple table
function BasicTable($header, $data)
{
    // Header
    $this->SetFont('Arial','B',10);

    foreach($header as $index => $col)
    {
      if ( $index == 0 ) {

         $this->Cell(30,7,trim($col),1, 0,'C');

       } elseif  ( $index == 7 ) {

          $this->Cell(30,7,trim($col),1, 0,'C');

       } else {

          $this->Cell(22,7,trim($col),1, 0,'C');

       }
    }

    $this->Ln();
    // Data
    $this->SetFont('Arial','',10);

    foreach($data as $row)
    {
        foreach($row as $index => $col)
          if ( $index == 0) {

            $this->Cell(30,6,trim($col),1, 0,'C');

          } elseif ( $index == 7 ) {

             $this->Cell(30,6,trim($col),1, 0,'C');

          } else {

             $this->Cell(22,6,trim($col),1, 0,'C');
          }

        $this->Ln();
    }
}	
// Page header
	
function Header()
{
	// Logo
	$this->Image('../img/flexiblematerial-bl.png',60,10,60);
	// Arial bold 15
	$this->SetFont('Arial','B',16);
	// Move to the right
	$this->Ln(20); 
	$this->Cell(80);
	// Title
	$this->Cell(30,10,'End of shift Report',0,0,'C');
	// Line break
	$this->Ln(20);  
}

// Page footer
function Footer()
{ 
	// Position at 1.5 cm from bottom
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial', 'I', 10);
	$Supervisor = 'User name: '.htmlspecialchars( $_POST['operator'] ) ; 
	//$this->Cell(0, 10, $Supervisor, 0, 0);
	$mydate=getdate(date("U"));
	$dDate = " Date: ". date('m/d/Y h:i:s a', time());//"$mydate[weekday], $mydate[month] $mydate[mday], $mydate[year]";
	//$this->Cell(0, 10, $dDate, 0, 0);
	// Page number
	$this->Cell(0, 10,$Supervisor.'           ' .$dDate.'           Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
} 
}


function createPDF()
{ 
  $pdf = new PDF('P','mm','Letter');

  // Column headings
  $header = array('Operation', 'Qty', 'SqFt', 'Boards', 'Sheets', 'Hours', 'Hrly Rate', 'TTL Cost');

  $data = $pdf->LoadData();


  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Arial','',10);
  $pdf->BasicTable($header,$data);
  
  $pdf->Output(); 
  
}


createPDF();
  echo json_encode("OK");
  // echo  $P;
  return ;

?>
