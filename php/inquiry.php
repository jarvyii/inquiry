<?php 
require_once 'class/DataAccess.php';
require_once 'Views/viewProduction.php';
require_once 'Views/viewInquiry.php';
require_once 'Views/ViewTracking.php';
require_once 'Views/viewTrackingDisplay.php';
require_once 'Views/viewTrackingInquiry.php'; 
require_once 'Views/viewTrackingInformation.php';
require_once 'PHPMailer/PHPMailerAutoload.php';
require_once 'topdf.php';
//PHP Mailer Library
// require_once  'PHPMailer/PHPMailer.php';
// require_once  'PHPMailer/SMTP.php';
// require_once  'PHPMailer/Exception.php';



//require_once '/PHP/Library/ToolkitService.php';

function jess() {


 

  //Create a new PHPMailer instance

    $mail = new PHPMailer;  

   $mail->SMTPDebug = 1;

    $mail->IsSMTP(); 
   

    //$mail->setFrom('no-reply@miains.com', "Midwestern Insurance Alliance");

    $mail->setFrom('no-reply@miains.com', "Midwestern Insurance Alliance");

    $dateChecked = date_create();

    $dateCheckRan = date_format( $dateChecked,"m/d/Y" );

 

    $mail->addAddress('jareynaldo@outlook.com', '');

    $mail->addCC('jareynaldov@gmail.com', ' ');

    // $mail->addCC('kerisen@midwesterninsurance.com', ' ');

 

  // Setup attachment

  //  $mail->addAttachment( $xlsx_Report );

 

  //Set the subject line
    $reportTitle = 'Testing from MminiMAX';
    $mail->Subject = 'Testing from MminiMAX';//$reportTitle . ' Ran on ' . $dateCheckRan;

 

    $mail->isHTML(true); // Set email format to HTML

 

    $mail->Body  = "<br>Attached is your <b> ". $reportTitle .".</b><br>\n<br>\n";

 

    $mail->Body  .=  "<br>\n<br>\n<br> **** This is an automated email. Please do not reply to this email **** ";

 

  //send the message, check for errors

    if (!$mail->send() )

    {                     

      echo " Mailer Error: " . $mail->ErrorInfo;

      exit();

    }

    else

    {

      $data = "Message emailed successfully!";

      unlink( $xlsx_Report );

      // exit();

    }

    unset($mail);
}

// To know the Cost of the Shift.
function producedCost($Produced, $Hours, $Min){
    $Minutes = (intval( $Hours))*60 + intval($Min);
    $Prod = intval( $Produced);
    $Cost = 0.0;
    if (( $Minutes != 0 ) &&   ( $Prod != 0 ) ){
        $Cost = 60 / ( $Minutes / $Prod );
    }
         return round( $Cost, 2); 
}

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
/*******************************
Send Email at the end of the Shift
********************************/

function  sendEmail(){

  // the message
  $msg = "First line of text\nSecond line of text";

  // use wordwrap() if lines are longer than 70 characters
 // $msg = wordwrap($msg,70);
/*  $msg =  "
<html>
  <head>
  <title>Cost per Machine at the end of the Shift</title>
  </head>
  <body>
*/
  $msg =  '
    <table style="width:100%">
      <thead>
        <tr>
          <th> Machine </th><th> QTY </th><th>  HOURS </th><th>  TOTAL COST  </th>
        </tr>
      </thead>
      <tbody>';
       // For Loop
     $totalRow = htmlspecialchars( $_POST['totalrow'] ) ; 
     $rows = '';
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

    }
   // $rows = $rows.  '<\tr>';

   $msg = $msg. $rows . "</tbody></table>"; //</body></html>";

   echo  $msg;
 /*
foreach($_POST as $i => $C) {
   echo "I:". $i. "=".$C. "C:<br>";
  }
  */
  // send email

 // $mailAddress =  htmlspecialchars( $_POST['email'] ) ;

 // $subj = "End Shift Report";
 // mail($mailAddress, $subj, $msg);
  echo "Enviado";


    // Instantiation and passing `true` enables exceptions
 



}



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
 Access to DB2 Files to get the Machines Info
    Id & Description
/********************************************/
function Machines(){
   $db_conn = new DataAccess(); 
   $Machines = $db_conn ->getMachines();
   //echo "Line:". $Line;
   echo json_encode($Machines);
}


function checkPanel($EIFGD, $EIBGD) {
    if ( trim($EIFGD) == trim($EIBGD) ) {
        return "N";
      } else {
        return "Y";
    }

}
/********************************************
     checkOrder($Order)
    Return if the one specific order exist the Database.
*********************************************/
function checkOrder($Order, $Line){
   $db_conn = new DataAccess(); 
   $tracksLoc = $db_conn ->checkOrder($Order, $Line);
   // To get Item Number
   $headOI = $db_conn ->getOrderItem($Order, $Line);
   $codeItem = $headOI['EIPN'];

   $product =  $db_conn->getItemDesc(trim($codeItem)); 
   $pmClas = $product['PMCLAS']; 
   // To know if the product is a Panel ( Face & Back)
   if (trim($pmClas) == '08' or trim($pmClas) == '09') {

        $tracksLoc['PANEL'] = checkPanel( $headOI['EIFGD'], $headOI['EIBGD']);
       } else {
         $tracksLoc['PANEL'] = "N";
       }


   if( $tracksLoc) {
      echo json_encode($tracksLoc);
   } else {
     echo "";
   }
}
/****************************************************
 Print Traveler Print Queue R3
/*****************************************************/
function callCLTraveler( $Order, $Line ) {
	 require_once '/PHP/Library/ToolkitService.php';
    // Setup Database Connection to Call RPG/CLLE
    $db = db2_connect( '*LOCAL', '', '', array( 'i5_naming' => '1' ) );
        // Connect to toolkit using existing DB2 conn
    $tkitConn = ToolkitService::getInstance( $db );
    // Toolkit will share job with DB2
    $tkitConn->setOptions( array('stateless' => true) );
   // Call commandline to ENABLE User profile
    $Para = " PARM(  '$Order'  '$Line' 'R' )";
    //$rBoolean =  $tkitConn->CLCommand( 'CALL PGM(FLEXWEB/TRAVSHCL )'.$Para );  
    $rBoolean =  $tkitConn->CLCommand( 'CALL PGM(FLEXLIB/TRAVSHCL )'.$Para );  
    // CLCommand( 'CALL PGM(FLEXWEB/TRAVSHCL )  PARM( '678695' ' 1' 'R' ) );
    // CLCommand( 'CALL PGM(FLEXLIB/TRAVSHCL )  PARM( '678695' ' 1' 'R' ) );
    $tkitConn->setToolkitServiceParams( array( 'InternalKey'=>"/PHP/bin/ZendUser",
                                               // 'debug' => true,
                                               'plug'  => "iPLUG1M" ) ); 
  // unset connection
    unset( $tkitConn ); 
}
function callPrintTraveler( $Order, $Line ) { 
    callCLTraveler( $Order, $Line );
    echo "Sent";
 }
/***********************************************
Print Shortage Ticket in R4 Printer Queue
/************************************************/
function callCL($Order, $Line, $Machine )  {
  
    require_once '/PHP/Library/ToolkitService.php';
    
    // Setup Database Connection to Call RPG/CLLE
    $db = db2_connect( '*LOCAL', '', '', array( 'i5_naming' => '1' ) ); /* array( 'i5_commit' => DB2_I5_NAMING_ON ) */
        // Connect to toolkit using existing DB2 conn
    // $tkitConn = ToolkitService::getInstance( $db, DB2_I5_NAMING_ON );
    $tkitConn = ToolkitService::getInstance( $db );
  // Toolkit will share job with DB2
    $tkitConn->setOptions( array('stateless' => true) );
  // Call commandline to ENABLE User profile
    // $tkitConn->CLCommand( 'CHGUSRPRF USRPRF('. $this->user .') STATUS(*ENABLED) ' );
    $Para = " PARM(  '$Order'  '$Line' 'S' '$Machine' )"; //
    // Example of command Line $Para = " PARM( '678695' ' 1' 'MACH02')" ;

     $rBoolean =  $tkitConn->CLCommand( 'CALL PGM(FLEXLIB/TRAVSHRTCL )'.$Para );
       


     $tkitConn->setToolkitServiceParams( array( 'InternalKey'=>"/PHP/bin/ZendUser",
                                               // 'debug' => true,
                                               'plug'  => "iPLUG1M" ) ); 
  // unset connection
    unset( $tkitConn );
    return $rBoolean;
    /*
    $this->updated = true;
    $this->Results = "User Profile $this->user was flagged as *DISABLED by MIA Systems and Triggered through the Message Montior in WRKMSG QSYSMSG Outq. Program has successfully re-enabled ". $this->name . "'s Profile.";
    return $this->Results; */
  //////////////////////////////////////////////////////////////////////////////////////////////
  }



/****************************************
        checkOverrideCode($Code)
 Access the Database to validate the Code to override the production
 Its called from ControllerInquiry.php
******************************************/
function checkOverrideCode($Code){

   $db_conn = new DataAccess(); 

   // Return the code and the name of supervisor (CODE, SUPERVISOR) or False.
   $Supervisor = $db_conn ->checkOverrideCode($Code); 

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
function TrackingDisplay($OrderNumber, $LineNumber, $Customer, $orderDate, $orderQtty, $Item, $Operator) {

    viewTrackingDisplay($OrderNumber, $LineNumber);
   // $objData = new DataAccess(); 
    //$headOrder = $Order -> getOrderHeader($OrderNumber, $LineNumber, $Machine);
   // $headOI = $Order ->getOrderItem($OrderNumber, $LineNumber);
   // $tracksLoc = $objData ->getTrackLocHistory($OrderNumber);
    viewHead( $OrderNumber, $LineNumber, $Customer, $orderDate, $orderQtty, $Item, $Operator);//$headOI);//$headOrder, $headOI);
   
//testing
  //     $objData = new DataAccess(); 
  //    $objData -> testFMLOCHIST($OrderNumber, $LineNumber);


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
             $codeItem = $headOI['EIPN'];
             $headDesc = $objData ->getItemDesc( $codeItem);
             $itemDesc =  $headDesc['PMDESC'];//$objData ->getItemDesc( $codeItem);
             $orderQty = (int) $headOI['EICCQ'];
             $orderQty = calculateOrderQty( $headDesc['PMCLAS'], $headOI['EIFGD'], $headOI['EIBGD'], $orderQty);

             viewTrackingInformation($Order, $LineNumber, $Operator,$orderQty, $headOrder, $headOI);
             return;
          }
        }
     }
   TrackingInquiry($Operator);
   
      
}//TrackingInformation ()


/********************************************
 Asign a Locaction to an specific order
*********************************************/
function assignLoc(  $Order, $Line, $Location ){
  
  $dDate = date("Y-m-d-00.00.00");
  $objData = new DataAccess();
  //echo "L:".$line;
  $updateLoc = $objData -> assignLocation($Order, $Line, $Location, $dDate);   
  echo  $updateLoc;

}


/*********************************************
 return all production for an specific Order in one Shifts
**********************************************/
function shiftsOrder( $Order, $Line){

 $dDate = date("Y-m-d-00.00.00");
 $objData = new DataAccess();
 $shiftsOrder = $objData -> shiftsOrder($Order, $Line, $dDate); 

  echo json_encode($shiftsOrder);



}
/*******************************
 Return the Start of the Shifts
  Depending of the Machine ID
********************************/
function ShiftsHour($idMachine) {
     date_default_timezone_set("America/New_York");
     
    $hHour = date("H");
    $hmTime = ""; // date("H:i");
    $dDate = "";  
    
    if ( (trim(  $idMachine ) == "MACH04") || ( trim(  $idMachine ) == "MACH05" ) ) {
       // Itale Press && Sennersko Press
            if ( ($hHour >= "07") && ($hmTime < "15:30")  ) {
                  $dDate = date("Y-m-d-07.00.00") ; //
               } else { 
                   if ( ($hmTime >= "15:30") && ($hmTime < "23:45")  ) {
                      $dDate = date("Y-m-d-15.30.00") ; 
                     }
               }
          
      } else { 
       if ( ($hHour >= "07") && ($hHour < "18")  ) {
           $dDate = date("Y-m-d-07.00.00") ; //
        } else {
          if ( ($hHour >= "18") && ($hHour < "24")  ) {
              $dDate = date("Y-m-d-18.00.00") ; 
            }
        }
      } 
    Return $dDate;
}
 /**************************************
 call a PHP Function (DataAccess ), to acces DB2 Database, and return Total of Orders, Total Machine Time and Total Qty Produced 
 per Machine 
 ***************************************/ 

function MachinesProd() {
 
 // $dDate = date("Y-m-d-00.00.00");
 $objData = new DataAccess();

 // $MachProd = $objData -> getMachProd($dDate); 

 // echo json_encode($MachProd); 



//Testing
 
  $listMachines = $objData -> getMachines();

  if ( $listMachines === "") {

    return 0;
  }

  foreach( $listMachines as $Index => $Row ) {
     $dDate =  ShiftsHour($Row['MACHINEID']);
     $machProduction = $objData -> getMachProd( $Row['MACHINEID'], $dDate );
     $listMachines[$Index]['QTY'] =  $machProduction['QTY'] === "" ? 0 : $machProduction['QTY'];
     $listMachines[$Index]['ORDERS'] = $machProduction['ORDERS'] === "" ? 0 : $machProduction['ORDERS'];
  }

 
 
 //return $machinesList;

 echo json_encode($listMachines);





}

/*******************************************************
Get this Variable  $BarCode, $Machine, $Operator from Operator to be use
*******************************************************/

function TrackingInquiry( $Operator, $Order ){
   //( $BarCode, $Machine, $Operator)
 
  viewTrackingInquiry( $Operator, $Order); //($BarCode, $Machine, $Operator); 
}


/**************************************
       function Tracking($UserName)
***************************************/
function Tracking($UserName, $selectIndex ) {
 
   viewTracking($UserName, $selectIndex, 0);
  
}
/* *****************************************
    Calculo the quantity to produce checking if this is a Panel
 ********************************************/
function calculateOrderQty( $PMCLAS, $EIFGD, $EIBGD, $orderQty ){
    if (( $PMCLAS == '08') or ( $PMCLAS == '09')) {
          if ( trim($EIFGD) == trim($EIBGD) ) {
             $orderQty *= 2;
          }
        }
    return $orderQty;
}

function dailyProduction( $objData, $idMachine ) {
 
  $Orders = $objData -> dailyOrders( $idMachine );
  if ($Orders == ""){
    return 0;
  }
  $shiftsProduction = 0;
  
  foreach ( $Orders as $Index=> $Order) {
       $shiftsProduction += $Order['LHQTY'] * $objData -> qttyPMSLU( $Order['LHPN']) ;
     }
 
 return $shiftsProduction;
}
function getdailyOrders( $idMachine ) {
   $objData = new DataAccess();
    
  return dailyProduction( $objData, $idMachine );
}

/**************************************
    Return Daily Production per MAchine
****************************************/
function getdailyProd() {

 // Enviar();


  $objData = new DataAccess();
  $listMachines = $objData -> getMachines();
  foreach( $listMachines as $Index => $Row ) {
    $listMachines[$Index]['PRODUCTION'] =  dailyProduction( $objData, $Row['MACHINEID'] );
  }

  // echo json_encode($listMachines);
  return $listMachines;

}

function Production($BarCode, $idMachine, $Operator, $selectindex, $Panel) {
  
   $Pos = strpos($BarCode, "/"); 
   if ( ($Pos >= 0) and !empty($Pos) ) {
        $Order= substr($BarCode,0, $Pos);
        $LineNumber =  substr($BarCode, $Pos+1);
        $isFlitch =  strtoupper(substr($idMachine, 0, 1));
        $idMachine = substr($idMachine, 1);
      if (!empty($LineNumber)) {  
        
          $objData = new DataAccess();


          if ( !empty($objData->checkOrder($Order, $LineNumber))) {  
             switch ($Panel) {
               case "F": $typePart = "Panel Face";
                          break;
               case "B": $typePart = "Panel Back";
                          break;
               default : $typePart ="";
             }

             $Machine = $objData->getMachineDesc($idMachine);
             $descMachine =  $Machine['MACHDESC'];

             // Total quantity per Machine in the same group
             $qtyCmpted =  $objData->qtyCompleted($Order, $LineNumber, $idMachine,  $Machine['MACHGRPID'], $Panel);
             $qtyCmpted = empty( $qtyCmpted) ? 0:  $qtyCmpted;
             $headOrder = $objData->getOrderHeader($Order, $LineNumber);
             $d =$headOrder['EHORDT'];
             $Date = substr($d, 3,2)."/".substr($d, 5,2)."/".substr($d, 1,2);
             //Order Item info.
             $headOI = $objData ->getOrderItem($Order, $LineNumber);
             $codeItem = $headOI['EIPN'];

             $headDesc = $objData ->getItemDesc( $codeItem);
             $itemDesc = $headDesc['PMDESC'];//$objData ->getItemDesc( $codeItem);
    
             $orderQtyToShow = (int)$headOI['EICCQ'];
             // To trace and test this Vars.
            // echo " PMCLAS:". $headDesc['PMCLAS']. " EIFGD:".$headOI['EIFGD']."EIBGD: ".$headOI['EIBGD']. "Qtty:".$orderQty;
             $totalQty = calculateOrderQty( $headDesc['PMCLAS'], $headOI['EIFGD'], $headOI['EIBGD'], $orderQtyToShow);
             $neededQty = $totalQty - $qtyCmpted;
          
             $Production =  dailyProduction( $objData, $idMachine);

            viewProduction($BarCode,$Order, $LineNumber,$Date,$idMachine, $descMachine, $isFlitch, $Operator, $qtyCmpted, $headOrder['EHCT#'], $totalQty, $neededQty, $orderQtyToShow, $selectindex, $codeItem, $itemDesc, $typePart, $Panel, $Production );
 
             return;
         }  
      }
    }   
   viewTracking( $Operator, $selectindex, 0);
  
}
/**************************************************************************
$Param[] => ["operator","order", "line", "idmachine", "starttime", "endtime",
             "qty", "flitch", "panelfacbck", "comment", "override", "itemnumber", 
            "shortageTicket" ]
 ************************************************************************/
function endProduction($Param ){
 
   $objData  = new DataAccess();

   if ( $Param['flitch'] <> "" ) {
    $objData -> insertFlitch($Param);
   } 
   
   $objData -> insertHistoric($Param);

   if ($Param['shortageTicket']) {

    callCL( $Param['order'], $Param['line'], $Param['idmachine'] );

   }

  }
?>
