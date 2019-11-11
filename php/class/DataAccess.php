<?php
require_once '/PHP/library/Db/Adapter/Db2.php'; //Zend_Db_Adapter_Db2
class DataAccess {
	private $db_name = "";
	private $user_name = "";
	private $user_password = "";
	private $os = "i5";
	protected $user, $registered, $server, $FileHandler;
	private $pass, $hash, $tkitConn, $config;
  
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
                                  'schema' => 'FLEXWEB' 
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
      function getOrderHeader()
      Return the  row value for an specific Order from the Table FLEXWEB.EHM
  **********************************************/
 function getOrderHeader($OrderNumber, $LineNumber, $Operator) {
   // $Data = $this ->conn->query('SELECT 'EHCT#', EHORDT FROM FLEXWEB.EHM');
    //var_dump($Data);
    $Data = $this->conn->fetchRow('SELECT EHCT#, EHORDT FROM FLEXWEB.EHM WHERE EHORD=?', $OrderNumber);
    return $Data;

 }

 /**********************************************
      function getOrderItem()
      Return the row value for an specific Order from the Table FLEXWEB.EIM
  **********************************************/
 function getOrderItem($OrderNumber, $LineNumber, $Operator) {
       $Data = $this->conn->fetchRow('SELECT EIOCQ,EICCQ,EIPN,EILID,EIPNT FROM FLEXWEB.EIM WHERE EIORD=?', $OrderNumber);
    return $Data;

 }

 /**********************************************
      function getTrackLocHistory()
      Return all rows value from the historic of one specific Order from the Table FLEXWEB.FMLOCHIST
  **********************************************/
 function getTrackLocHistory($OrderNumber){
   $Data = $this ->conn->query('SELECT LHLIN, LHOPER, LHQTY, LHSTRDTTIM, LHSTPDTTIM, MACHDESC FROM FLEXWEB.FMLOCHIST INNER JOIN FLEXWEB.MACHLIST ON  FLEXWEB.FMLOCHIST.LHMACH = FLEXWEB.MACHLIST.MACHINEID WHERE LHORD=?', $OrderNumber);

     $Rows = $Data->fetchAll();
     return $Rows; 
 }
 /**********************************************
      function insertHistoric()
      Inserts rows in the Table FMLOCHIST
 ***********************************************/
 function insertHistoric($OrderNumber, $LineNumber, $Machine, $Operator,$startTime, $stopTime, $Qtty){

        $startTime = date("Y-m-d H:i:s.u", time($startTime));
        $stopTime = date("Y-m-d H:i:s.u", time($stopTime));
        $row = array( 'LHORD'=> $OrderNumber, 'LHLIN'=>$LineNumber, 'LHMACH'=>$Machine, 'LHOPER'=>$Operator,
         'LHQTY'=>$Qtty,'LHSTRDTTIM'=>$startTime, 'LHSTPDTTIM'=>$stopTime);
       /*
        $sqlQuery = 'INSERT INTO FLEXWEB.MACHLIST (LHORD, LHLIN, LHMACH, LHOPER, LHQTY, LHSTRDTTIM, LHSTPDTTIM) values  ('..','. .','. .','. .','. .','. .','. .')'; */
        $Data = $this ->conn->insert( 'FLEXWEB.FMLOCHIST',$row);
       // $stmt = $this->query($sql, $bind);
        //$result = $stmt->rowCount();

 }

}
?>
