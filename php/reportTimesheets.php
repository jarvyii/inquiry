<?php
require_once 'FPDF/fpdf.php';

class PDF extends FPDF
{

  // Load data
    function LoadData()
    { 
        $totalRow = (int) htmlspecialchars( $_POST['totalrow'] ) ; 
       
        
        $data = array();

        for( $i=1; $i<= $totalRow; $i++) 
        {
          $number =  $i < 10  ? "0". $i: $i;
          $Machine = "MACH".$number;
          $data[ $i ]['machine'] = htmlspecialchars( $_POST[$Machine] );
          $machineTotal = ( int ) htmlspecialchars( $_POST[$Machine."machineTotal"] );
          $data[$i]['Operators'] = array();



          for( $j = 0; $j <  $machineTotal; $j++  ) 
          {
            $Operator = $_POST[$Machine.'operator'.$j];
            $Starttime = $_POST[$Machine.'starttime'.$j];
            $Worked = $_POST[$Machine.'worked'.$j];
            $Difined = $_POST[$Machine.'difined'.$j];
            $Notes = $_POST[$Machine.'Notes'.$j];
              
            $data[$i]['Operators'][] = explode(';',  $Operator.';'. $Starttime.';'.  $Worked .';'.$Difined.';'. $Notes);
             /*
            echo "JJJ:".$data[$i]['Operators'];
            foreach ($data[$i]['Operators'] as $value ){
              foreach ($value as $v )
              echo $v."<br>";
            }
            */
          } 
          

        }
        
        return $data;   
          
    }

 function createHeader( $header )
 { 
    // Header
        $this->SetFont('Arial','B',8);

        for( $i=0; $i < 2; $i++) {

           foreach($header[$i] as $index => $col)
            {
              // $this->MultiCell(30,7,trim($col),0, 'J', false);
              
               switch(  $index)
               {
                case 0 :
                  $Width = 25;
                  break;
                case 1 :
                  $Width = 24;
                  break;
                case 2 :
                  $Width = 17;
                  break; 
                case 3 :
                  $Width = 21;
                  break; 
                case 5 :
                  $Width = 54;
                  break;
                default  :
                  $Width = 45;
                 
               }

              $this->Cell( $Width, 4, trim($col), 0, 0, 'C');
            }
             $this->Ln(3);
        }

  }
    
// Simple table
function BasicTable($header, $data)
{
   
    // Data
   

    foreach( $data as $Machine) 
    {
      $this->createHeader( $header );
      $this->Ln(1);
       $this->SetFont('Arial','',8);
      $this->Cell( 25, 5, trim($Machine['machine']), 1, 0, 'C');
      $firstOperator = true;

      foreach( $Machine['Operators'] as $Operators ) 
      {
         
       // foreach ($Operators as $Operator ) 
        //{
          foreach( $Operators as $Colum => $Value)
          {
           // echo $Value;
            switch(  $Colum)
             {
              case 0 :
                $Width = 24;
                break;
              case 1 :
                $Width = 17;
                break; 
              case 2 :
                $Width = 21;
                break; 
              case 3 :
                $Width = 45;
                break;
              case 4 :
                $Width = 54;
                break;
                
             }
             if ( $firstOperator )
             {

              $firstOperator = false;
              
             } else 
             {
               if ( $Colum == 0 ) 
               {
                $this->Cell( 25, 6, "", 0, 0, 'C');
               }
               
             }
              $this->Cell( $Width, 6, trim($Value), 1, 0, 'C');

            
          }
          
      //  }
        $this->Ln();
      }
      $this->Ln(); 
    }

    $this->Ln();

   
/*
 
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

    */
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
	$this->Cell(30,10,'Timesheet Report',0,0,'C');
	// Line break
	$this->Ln();  
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
  $header = array( 
        array('',   '',        'Scheduled',   'Hours', 'Ask Each: Did you avoid a', 'If No, Who? (and other' ),
        array( '', 'Employee', 'Start Time', 'Worked', "difined under 6' event?",   'notes)' )
      ); 

  $data = $pdf->LoadData();


  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Arial','',10);
  $pdf->BasicTable($header,$data);
  
  $pdf->Output(); 
 /* */
  
}


 createPDF();

  echo json_encode("OK");
  // echo  $P;
  return ;

?>
