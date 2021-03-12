<?php
require_once '/PHP/library/Db/Adapter/Db2.php'; //Zend_Db_Adapter_Db2
class DataAccess {
	private $db_name = "";
	private $user_name = "";
	private $user_password = "";
	private $os = "i5";
	protected $user, $registered, $server, $FileHandler;
	private $pass, $hash, $tkitConn, $config;
  //$DB_NAME = "CATPACDBF";
  
  private $conn;  //Database connector	

	function __construct( $user=false, $pass=false ) {
		$this->user 	= ( isset( $user ) && $user != '' && $user != false ? $user: false );
		$this->pass 	= ( isset( $pass ) && $pass != '' && $pass != false ? $pass: false );
		$this->server	= 'C702B9F0'; // Change this based of AS400 System value
		$this->debug 	= array();
		$this->error 	= false;
		$this->connect();
	}

	/************************************************
        function connect()
	************************************************/
	function connect()
	{ 	
	   $config = $_config = array(
                                  'dbname' => null,
                                  'username' => null,
                                  'password' => null,
                                  'host' => 'localhost',
                                  'port' => '50000',
                                  'protocol' => 'TCPIP',
                                  'persistent' => false,
                                  'os' => 'i5',
                                  'schema' => 'CATPACDBF' 
                                  ) ;
    $this -> conn = new Zend_Db_Adapter_Db2( $config );

		if ( !$this ->conn)  {
			   echo "Connecting error";
			  return false;
			 }
		//echo "<br>Thx God. We are connected<br>";

    //Only to Test
   /* $data = $this ->conn->listTables();
    var_dump($data);
    print($data);
    $size = count($data);
    echo $size;
    for( $i=0; $i<$size; $i++)
       echo "<BR>", $data[$i];
    $db->query("select * from EIM;");
    $Data = $this ->conn ->query('SELECT * FROM FLEXWEB.EIM');
    var_dump($Data);
    $row = $this ->conn->fetchRow('SELECT EIORD FROM FLEXWEB.EIM');
    var_dump($row);
   
   $db = new DataAccess($user, $pass);
   $db->connect();

	tracking($user);
		 */   
	} 
/**********************************************
      getMachineName($OrderNumber, $LineNumber, $Operator)
  Return the Description of the one machine with specific Id Code
**********************************************/
  function getMachineDesc($idMachine) {
    $Data = $this->conn->fetchRow('SELECT MACHDESC, MACHGRPID FROM CATPACDBF.MACHLIST WHERE MACHINEID=?', $idMachine);

    // To check MACHLIST Content
    /*
    foreach( $Data as $F => $C) {
      echo "<br>F:".$F. "  C:".$C; 
    }

    */
    return $Data;  //$Data['MACHDESC'];

 }
 /****************************************************
   Return a list with all Id & Machines Description
 /**************************************************/
function getMachines(){
   $sql = "SELECT MACHINEID, MACHDESC, MACHFLTRQ FROM CATPACDBF.MACHLIST";
   $Data = $this ->conn->query($sql);
   $Rows = $Data->fetchAll();

   // To check MACHLIST Content
   /*
    foreach( $Rows as $I => $R) {
      foreach ($R as $F => $C) {
        echo "F:".$F. "  C:".$C; 
      }
      echo "<br>";
    } */

   return $Rows; 
}

 /******************************************
    
    return the Description of one specific Item from the table   
    CATPACDBF.PMMM -> Inventory Item Master
 ********************************************/

function getItemDesc( $codeItem){
  $Data = $this->conn->fetchRow('SELECT PMDESC, PMCLAS FROM CATPACDBF.PMMM WHERE PMPN=?', $codeItem);
    return $Data; //return $Data['PMDESC'];
}    
 /****************************************
        checkOrder($Order)
   Check if the order exist in the table  CATPACDBF.EHM
 ****************************************/
function checkOrder($Order, $pLine){
  $Line = (int) $pLine;
  $Order = $Order;
   // $Data = $this->conn->fetchRow('SELECT EHCT#, EHORDT FROM CATPACDBF.EHM WHERE EHORD=?', $Order);
   //$Data = $this->conn->fetchRow($sql);
   // return $Data;
    $sql = "SELECT EIORD FROM CATPACDBF.EIM WHERE EIORD='$Order' and EILIN='$Line'";
    $Data = $this ->conn->query($sql);
    $Rows = $Data->fetchAll();
    return $Rows; 
 }
/****************************************
    checkOverrideCode($Code)
    Return the Supervisor Name or "" 
******************************************/
function checkOverrideCode($Code){

  $Code = trim($Code);
  // Table Name SUPER   :: Fields  CODE  char(10),  SUPERVISOR CHAR(25)

  $Data = $this->conn->fetchRow('SELECT CODE, SUPERVISOR FROM CATPACDBF.SUPER  WHERE  CODE=?', $Code);

   return  $Data;
}
  /**********************************************
      function getOrderHeader()
      Return the  row value for an specific Order from the Table FLEXWEB.EHM
  **********************************************/
 function getOrderHeader($Order, $Line) {
   $Line = (int)$Line;
   /* $Data = $this ->conn->query('SELECT 'EHCT#', EHORDT FROM FLEXWEB.EHM');
      $Data = $this->conn->fetchRow('SELECT EHCT#, EHORDT FROM CATPACDBF.EHM WHERE EHORD=? EHLLN=?', $Order, $Line); */

    $sql = "SELECT EHCT#, EHORDT FROM CATPACDBF.EHM WHERE EHORD='$Order'";
    $Data = $this->conn->fetchRow($sql);
    return $Data;

 }

 /**********************************************
      function getOrderItem()
      Return the row value for an specific Order from the Table FLEXWEB.EIM
  **********************************************/
 function getOrderItem($Order, $Line) {
     $Line = (int)$Line;
     //  $Data = $this->conn->fetchRow('SELECT EIOCQ,EICCQ,EIPN,EILID,EIPNT FROM CATPACDBF.EIM WHERE EIORD=?', $OrderNumber);
    $sql = "SELECT EICCQ,EIPN,EILID,EIPNT,EIFGD,EIBGD FROM CATPACDBF.EIM WHERE EIORD='$Order' and EILIN='$Line'";
    $Data = $this->conn->fetchRow($sql);
    return $Data;

 }

 /**********************************************
      function getTrackLocHistory()
      Return all rows value from the historic of one specific Order from the Table FLEXWEB.FMLOCHIST
  **********************************************/
 function getTrackLocHistory($OrderNumber, $Line){
    $Line = (int) $Line;
    $sql = "SELECT LHLIN, LHOPER, LHQTY, LHSTRDTTIM, LHSTPDTTIM,LHSOVR,LHCOMM, MACHDESC, LHFLCH FROM CATPACDBF.FMLOCHIST INNER JOIN CATPACDBF.MACHLIST ON  CATPACDBF.FMLOCHIST.LHMACH = CATPACDBF.MACHLIST.MACHINEID WHERE LHORD='$OrderNumber' and LHLIN='$Line' ORDER BY LHMACH, LHSTRDTTIM, LHOPER";
   //$Data = $this ->conn->query('SELECT LHLIN, LHOPER, LHQTY, LHSTRDTTIM, LHSTPDTTIM,LHSOVR,LHCOMM, MACHDESC FROM CATPACDBF.FMLOCHIST INNER JOIN CATPACDBF.MACHLIST ON  CATPACDBF.FMLOCHIST.LHMACH = CATPACDBF.MACHLIST.MACHINEID WHERE LHORD=? ORDER BY LHSTRDTTIM, LHMACH, LHOPER', $OrderNumber);
     $Data = $this ->conn->query($sql);
     $Rows = $Data->fetchAll();
     return $Rows; 
 }

 function checkFaceBack( $Order, $Line){

   $headOI = $this ->getOrderItem( $Order, $Line);
   $EIFGD = $headOI['EIFGD'];
   $EIBGD =  $headOI['EIBGD'];
   //Face and Back are Equal
   if ( ( (trim($EIFGD) == "AA") and (trim($EIBGD) == "AA" )) or
               ( (trim($EIFGD) == "A/B") and (trim($EIBGD) == "A/B" )) or
               ( (trim($EIFGD) == "A") and (trim($EIBGD) == "A")) or 
               ( (trim($EIFGD) == "B") and (trim($EIBGD) == "B")) or
               ( (trim($EIFGD) == "C") and (trim($EIBGD) == "C"))  ) 
                  {
                      return '';
                  }

    // Face
    if ( ( trim($EIFGD) == "AA") or ( trim($EIFGD) == "A/B") or ( trim($EIFGD) == "A") or ( trim($EIFGD) == "B") or
         ( trim($EIFGD) == "C")  ) 
          {
             return 'F';
          }
    // Back
     if ( ( trim($EIBGD) == "AA") or ( trim($EIBGD) == "A/B") or ( trim($EIBGD) == "A") or ( trim($EIBGD) == "B") or
         ( trim($EIBGD) == "C") or  ( trim($EIBGD) == "1") or ( trim($EIBGD) == "2") ) 
          {
             return 'B';
          }
      return "";    
 }


 function TestFlitch($Order, $LineNumber){

 //Only to Test
  /*
    $data = $this ->conn->listTables();
    var_dump($data);
    print($data);
    $size = count($data);
    echo $size;
    for( $i=0; $i<$size; $i++)
       echo "<BR>", $data[$i];

*/

 $Line = (int)$Line;
     
    $sql = "SELECT * FROM CATPACDBF.FMFLITCH";
    $Data = $this->conn->fetchAll($sql);
    foreach( $Data as $In => $Co) {
    foreach ( $Co as $I => $C) {
     echo  "I:".$I."C:".$C;
    } 
    echo "<br>";
  }
    return $Data;


 }

/*****************************************
 Insert in File FMFLITCH in CATPACDBF library

******************************************/ 

function insertFlitch($Param) {
    $row = array( 'FLORD'=> $Param['order'], 'FLLIN'=>(int)$Param['line'],'FLPN'=>$Param['itemnumber'], 'FLFLCH'=>$Param['flitch'] );
    $Data = $this ->conn->insert( 'CATPACDBF.FMFLITCH',$row);
}

 /**********************************************
      function insertHistoric($Param)
      Inserts rows in the Table FMLOCHIST
 ***********************************************/
 function insertHistoric($Param){

      /* 
       $product = $this->getItemDesc(trim($Param['itemnumber'])); 
       $pmClas = $product['PMCLAS']; 
       $checkFacBck = ""; 
      
       if (trim($pmClas) == '08' or trim($pmClas) == '09') {
      
           $checkFacBck = $this->checkFaceBack( $Param['order'], $Param['line']);
       } 
    */
       $row = array( 'LHORD'=> $Param['order'], 'LHLIN'=>(int)$Param['line'], 'LHMACH'=>$Param['idmachine'], 
                     'LHOPER'=>$Param['operator'], 'LHQTY'=>$Param['qty'],'LHSTRDTTIM'=>$Param['starttime'],
                     'LHSTPDTTIM'=>$Param['endtime'], 'LHCOMM'=>$Param['comment'], 
                     'LHSOVR'=>$Param['override'], 'LHFLCH'=>$Param['flitch'], 'LHPN'=>$Param['itemnumber'], 'LHFACBCK'=>$Param['panelfacbck']
                   );

      //  $startTime = date("Y-m-d H:i:s.u", time($startTime));
      //  $stopTime = date("Y-m-d H:i:s.u", time($stopTime));
      /*  $row = array( 'LHORD'=> $OrderNumber, 'LHLIN'=>$LineNumber, 'LHMACH'=>$Machine, 'LHOPER'=>$Operator,
         'LHQTY'=>$Qtty,'LHSTRDTTIM'=>$startTime, 'LHSTPDTTIM'=>$stopTime);*/


       $Data = $this ->conn->insert( 'CATPACDBF.FMLOCHIST',$row);


       // $stmt = $this->query($sql, $bind);
        //$result = $stmt->rowCount();

 }
 /***********************************************
          function qtyCompleted($OrderNumber)
    Rteurn how many quantity has beeen completed for one specific order.      
 ************************************************/
 function qtyCompleted($Order, $Line, $idMachine, $Group, $Panel){
    $Line = (int) $Line;
   // $Data = $this ->conn->query('SELECT SUM(LHQTY) FROM CATPACDBF.FMLOCHIST WHERE LHORD=?', $Order);
    //$sql = "SELECT SUM(LHQTY) FROM CATPACDBF.FMLOCHIST WHERE LHORD=$Order and LHLIN='$Line' and LHMACH = '$idMachine'";

    if ( $Panel == "") {
      $sql = "SELECT SUM(LHQTY) FROM CATPACDBF.FMLOCHIST  INNER JOIN CATPACDBF.MACHLIST ON  CATPACDBF.FMLOCHIST.LHMACH = CATPACDBF.MACHLIST.MACHINEID WHERE LHORD='$Order' and LHLIN='$Line' and MACHGRPID = '$Group'";
    } else {
      $sql = "SELECT SUM(LHQTY) FROM CATPACDBF.FMLOCHIST  INNER JOIN CATPACDBF.MACHLIST ON  CATPACDBF.FMLOCHIST.LHMACH = CATPACDBF.MACHLIST.MACHINEID WHERE LHORD='$Order' and LHLIN='$Line' and MACHGRPID = '$Group' and LHFACBCK = '$Panel'";
    }
    
    $Data = $this ->conn->query($sql);
    $Rows = $Data->fetch();
     foreach( $Rows as $index=>$content) {
       return empty($content)? 0: $content;
     }
 }

// To check the FMLOCHIST File Content

function testFMLOCHIST($OrderNumber, $Line){
    $Line = (int) $Line;
   // $sql = "SELECT * FROM CATPACDBF.FMLOCHIST WHERE LHORD='$OrderNumber' and LHLIN='$Line' ORDER BY LHMACH, LHSTRDTTIM, LHOPER";
     $sql = "SELECT  LHORD, LHLIN, LHMACH,LHSTRDTTIM, LHFACBCK FROM CATPACDBF.FMLOCHIST WHERE LHORD='$OrderNumber' and LHLIN='$Line' ORDER BY LHMACH, LHSTRDTTIM, LHOPER";


   //$Data = $this ->conn->query('SELECT LHLIN, LHOPER, LHQTY, LHSTRDTTIM, LHSTPDTTIM,LHSOVR,LHCOMM, MACHDESC FROM CATPACDBF.FMLOCHIST INNER JOIN CATPACDBF.MACHLIST ON  CATPACDBF.FMLOCHIST.LHMACH = CATPACDBF.MACHLIST.MACHINEID WHERE LHORD=? ORDER BY LHSTRDTTIM, LHMACH, LHOPER', $OrderNumber);
     
     

      $Data = $this ->conn->query($sql);
     $Rows = $Data->fetchAll();
     echo $Rows;
      foreach( $Rows as $index=>$Array) {
        foreach( $Array as $Column=>$content) {
         echo "C::".$Column."=".$content."  ";
        }
        echo "<br>";
       
      } 
    // return $Rows; 
 }

 /***************************
 Assign a location to an specific Order/line in FMLOCHIST File
 *************************/
function assignLocation( $Order, $Line, $Location, $dDate ){
  
  $Where = "LHSTRDTTIM >= '$dDate' and LHORD = '$Order' and  LHLIN = '$Line'";
  $Table = "CATPACDBF.FMLOCHIST";
  $Fields = array('LHLOC' => $Location );
   
   $Data = $this ->conn->update($Table, $Fields, $Where);
  echo $Data;
 
}

/**************************************
  Acces a DB2 Database, and return Total of Orders, Total Machine Time and Total Qty Produced 
 per Machine 
 ***************************************/ 

function getMachProd( $idMachine , $dDate){
  

     if ( $dDate == "") {
        return "";
     }

    $sql = "SELECT  SUM(LHQTY) as QTY, COUNT(LHORD) as ORDERS
            FROM CATPACDBF.FMLOCHIST
            WHERE CATPACDBF.FMLOCHIST.LHMACH = '$idMachine' AND CATPACDBF.FMLOCHIST.LHSTRDTTIM >= '$dDate'";
      
       $Data = $this ->conn->query($sql);
     
      $Rows = $Data->fetchAll();
      return $Rows[0];  

 }

/***********************************************
 return all Orders produced in Shifts
 ***********************************************/
 function dailyOrders( $idMachine ){
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
 
 if ( $dDate == "") {
    return "";
 }
 
  $sql = "SELECT LHSTRDTTIM, LHQTY, LHORD, LHLIN, LHPN FROM CATPACDBF.FMLOCHIST WHERE LHSTRDTTIM >= '$dDate' and LHMACH ='$idMachine' ";
  
   $Data = $this ->conn->query($sql);
 
  $Rows = $Data->fetchAll();
  
  return $Rows; 
 }


 /**********************************
    Return an specific Order and Line produced in a work day 
 ************************************/


 function shiftsOrder( $Order, $Line, $dDate ) {
  
   $sql = "SELECT LHSTRDTTIM, LHQTY, LHORD, LHLIN, LHLOC, LHFACBCK, LHMACH, MACHDESC FROM CATPACDBF.FMLOCHIST INNER JOIN CATPACDBF.MACHLIST ON  CATPACDBF.FMLOCHIST.LHMACH = CATPACDBF.MACHLIST.MACHINEID WHERE LHSTRDTTIM >= '$dDate' and LHORD = '$Order' and  LHLIN = '$Line'";
  
   $Data = $this ->conn->query($sql);
 
   $Rows = $Data->fetchAll();
/*
    echo $Rows;
      foreach( $Rows as $index=>$Array) {
        foreach( $Array as $Column=>$content) {
         echo "C::".$Column."=".$content."  ";
        }
        echo "<br>";
       
      } 

*/

  return  $Rows;

 }   


 /***************************************
  Return de Quantity in the Field PMSLU of the File PMMM
 ****************************************/
  function qttyPMSLU( $pmitem ){
  
    $sql = "SELECT PMSLU FROM CATPACDBF.PMMM WHERE PMPN='$pmitem'"; 
    $Data = $this->conn-> query($sql);
    $Rows = $Data-> fetchAll();
    $valuePMSLU = 0;
    foreach($Rows as $Index=> $Row) {
      $valuePMSLU = $Row['PMSLU'];
      /*
      foreach( $Rows as $In => $C){
        echo "<br> I:".$In."C:".$C ;
      } */
    }
    return $valuePMSLU;
  }

}
?>
