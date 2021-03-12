<?php
  require_once 'class/DataAccess.php';
  require_once 'inquiry.php';

  $Shift = htmlspecialchars( $_GET['shift'] ) ;
  if ( $Shift === "") 
  {
     echo "";
     return;
  }

  $EmployeesPerMachine =  getEmployeesPerMachine( $Shift );

  echo json_encode($EmployeesPerMachine);

  return;
  



/**************************************
    Return Daily Production per MAchine
****************************************/
function getEmployeesPerMachine( $Shift ) {
  


  $objDB = new DataAccess();

  $machinesList = $objDB -> getMachines();
  $startTime = $objDB->startShiftTime( $Shift );

  foreach( $machinesList as $Index => $Machine ) {

     
      $machinesList[$Index]['SCHEDULEDSTARTTIME'] =  $startTime ;

      $machineOperators =  $objDB->machinesOperators( $Machine['MACHINEID'], $startTime );
     
      $machinesList[$Index]['OPERATOR'] =   $machineOperators;
     
     // $listMachines[$Index]['STARTTIME'] =  $machineOperators['Starttime'];
     // LHOPER, LHSTRDTTIM, LHSTPDTTIM
    
  }
  
  return $machinesList; 

}




?>