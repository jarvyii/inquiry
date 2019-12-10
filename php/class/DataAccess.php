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
    $Data = $this->conn->fetchRow('SELECT MACHDESC FROM CATPACDBF.MACHLIST WHERE MACHINEID=?', $idMachine);
    return $Data['MACHDESC'];

 }
 /******************************************
    
    return the Description of one specific Item from the table   
    CATPACDBF.PMMM -> Inventory Item Master
 ********************************************/

function getItemDesc( $codeItem){
  $Data = $this->conn->fetchRow('SELECT PMDESC FROM CATPACDBF.PMMM WHERE PMPN=?', $codeItem);
    return $Data['PMDESC'];
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
    $sql = "SELECT EHCT#, EHORD, EHORDT FROM CATPACDBF.EHM WHERE EHORD='$Order' and EHLLN='$Line'";
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

    $sql = "SELECT EHCT#, EHORDT FROM CATPACDBF.EHM WHERE EHORD='$Order' and EHLLN='$Line'";
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
    $sql = "SELECT EIOCQ,EICCQ,EIPN,EILID,EIPNT FROM CATPACDBF.EIM WHERE EIORD='$Order' and EILIN='$Line'";
    $Data = $this->conn->fetchRow($sql);
    return $Data;

 }

 /**********************************************
      function getTrackLocHistory()
      Return all rows value from the historic of one specific Order from the Table FLEXWEB.FMLOCHIST
  **********************************************/
 function getTrackLocHistory($OrderNumber, $Line){
    $Line = (int) $Line;
    $sql = "SELECT LHLIN, LHOPER, LHQTY, LHSTRDTTIM, LHSTPDTTIM,LHSOVR,LHCOMM, MACHDESC FROM CATPACDBF.FMLOCHIST INNER JOIN CATPACDBF.MACHLIST ON  CATPACDBF.FMLOCHIST.LHMACH = CATPACDBF.MACHLIST.MACHINEID WHERE LHORD='$OrderNumber' and LHLIN='$Line' ORDER BY LHSTRDTTIM, LHMACH, LHOPER";
   //$Data = $this ->conn->query('SELECT LHLIN, LHOPER, LHQTY, LHSTRDTTIM, LHSTPDTTIM,LHSOVR,LHCOMM, MACHDESC FROM CATPACDBF.FMLOCHIST INNER JOIN CATPACDBF.MACHLIST ON  CATPACDBF.FMLOCHIST.LHMACH = CATPACDBF.MACHLIST.MACHINEID WHERE LHORD=? ORDER BY LHSTRDTTIM, LHMACH, LHOPER', $OrderNumber);
     $Data = $this ->conn->query($sql);
     $Rows = $Data->fetchAll();
     return $Rows; 
 }
 /**********************************************
      function insertHistoric($Param)
      Inserts rows in the Table FMLOCHIST
 ***********************************************/
 function insertHistoric($Param){
       $row = array( 'LHORD'=> $Param['order'], 'LHLIN'=>(int)$Param['line'], 'LHMACH'=>$Param['machine'], 
                     'LHOPER'=>$Param['operator'], 'LHQTY'=>$Param['qty'],'LHSTRDTTIM'=>$Param['starttime'],
                     'LHSTPDTTIM'=>$Param['endtime'], 'LHCOMM'=>$Param['comment'], 
                     'LHSOVR'=>$Param['override']
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
 function qtyCompleted($Order, $Line){
    $Line = (int) $Line;
   // $Data = $this ->conn->query('SELECT SUM(LHQTY) FROM CATPACDBF.FMLOCHIST WHERE LHORD=?', $Order);
    $sql = "SELECT SUM(LHQTY) FROM CATPACDBF.FMLOCHIST WHERE LHORD=$Order and LHLIN='$Line'";
    $Data = $this ->conn->query($sql);
    $Rows = $Data->fetch();
     foreach( $Rows as $index=>$content) {
       return empty($content)? 0: $content;
     }
 }

}
?>
