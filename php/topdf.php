<?php
require_once 'FPDF/fpdf.php';

class PDF extends FPDF
{
  // Load data
function LoadData()
{
    $totalRow = htmlspecialchars( $_POST['totalrow'] ) ; 
    $data = array();
    for( $i=0; $i< $totalRow; $i++) {
     //
      //echo "i:".$rows;
        $columindex = "Mach". $i;
        $Descript = htmlspecialchars( $_POST[$columindex] ) ; 
        $columindex = "Sqf". $i;
        $sqfProduced = htmlspecialchars( $_POST[$columindex] ) ; 
        $hourindex = "Hour". $i;
        $Hour = htmlspecialchars( $_POST[$hourindex] );
        $minutesindex = "Min". $i;
        $Min = htmlspecialchars( $_POST[$minutesindex] );
        $Time = $Hour.":". $Min;
        
        $Cost = producedCost($sqfProduced, $Hour, $Min);
       // echo "Des:".  $Descript. "  Sqf:".$sqfProduced. "T: ". $Time. "Cost:". $Cost. "<br>";
        $rows = $rows. '<tr><td>' . $Descript .'</td><td>'. $sqfProduced . '</td><td>'. $Time . '</td><td>'. $Cost . '</td></tr>';
        $data[] = explode(';', $Descript .';'. $sqfProduced . ';' . $Time . ';' . $Cost);

    }
    return $data;
}
// Simple table
function BasicTable($header, $data)
{
    // Header
    foreach($header as $col)
        $this->Cell(40,7,$col,1, 0,'C');
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,trim($col),1, 0,'C');
        $this->Ln();
    }
}	
// Page header
	
function Header()
{
	// Logo
	$this->Image('../img/flexiblematerial-bl.png',60,10,60);
	// Arial bold 15
	$this->SetFont('Arial','B',15);
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
	$this->SetFont('Arial', 'I', 8);
	$Supervisor = 'User name: '.htmlspecialchars( $_POST['Supervisor'] ) ; 
	//$this->Cell(0, 10, $Supervisor, 0, 0);
	$mydate=getdate(date("U"));
	$dDate = " Date: ". date('m/d/Y h:i:s a', time());//"$mydate[weekday], $mydate[month] $mydate[mday], $mydate[year]";
	//$this->Cell(0, 10, $dDate, 0, 0);
	// Page number
	$this->Cell(0, 10,$Supervisor.'           ' .$dDate.'           Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
} 
}

?>
