<?php
require_once '/PHP/library/Db/Adapter/Db2.php'; //Zend_Db_Adapter_Db2
class DataAccess {
	private $db_name = "";
	private $user_name = "";
	private $user_password = "";
	private $os = "i5";
	protected $user, $registered, $server, $FileHandler;
	private $pass, $hash, $tkitConn, $conn, $config;
	

	function __construct( $user=false, $pass=false ) {
		$this->user 	= ( isset( $user ) && $user != '' && $user != false ? $user: false );
		$this->pass 	= ( isset( $pass ) && $pass != '' && $pass != false ? $pass: false );
		$this->server	= 'C702B9F0'; // Change this based of AS400 System value
		$this->debug 	= array();
		$this->error 	= false;
	}

	/************************************************
        function connect()
	************************************************/
	function connect()
	{ 	
	  $config =  array(   'dbname'   => '*LOCAL',
				                      'username' => '',
				                      'password' => '',
				                      'os'=>'i5',
				                      'driver_options'=> array( 
				                      													"i5_commit" =>DB2_I5_TXN_READ_UNCOMMITTED,
				                                                "autocommit"=>DB2_AUTOCOMMIT_OFF,
				                                              ) );

  	$conn = new Zend_Db_Adapter_Db2( $config );

		if ( !$conn)  return false;
		echo "Thx God. We are connected";
		openTKitConnect();
		    
	} 

	/**************************************************
		   private function openTKitConnect()
	**************************************************/
	private function openTKitConnect()
	{ 
		
	   /************************* DB Connection *******************************/ 
	   //       Setup Database Connection to Login to AS/400 
		$db = db2_connect( $server, $user, $pass, array( 'i5_naming' => DB2_I5_NAMING_ON ) );  

		try 
		{
       // Connect to toolkit using existing DB2 conn
      $this->tkitConn = ToolkitService::getInstance( $db, DB2_I5_NAMING_ON );
		} 
		catch (Exception $e) 
		{
	    switch ( $e->getCode() ) 
	    {
            // "Authorization failure on distributed database connection attempt"
	        case 8001: // Usually means a wrong DB2 user or password		            
	            $this->debug['ERROR'][] = 'Could not connect due to wrong user or password.';
	            break;
	        case 42705:
	            $this->debug['ERROR'][] = 'Database not found. Please check your connection to DB.';
	            break; 
	        default:
	            $this->debug['ERROR'][] = 'Could not connect. Error: ' . $e->getCode() . ' ' . $e->getMessage();
	            break;
	    }
			$this->catchError( 'log', $e, $this, false );
		}
		if ( !$this->testConnection( $this->tkitConn ) )
		{ 
			$this->error = true;
			$this->debug['ERROR'][] = "Connection to main database could be established. Toolkit Services was not instantiated. Please check dependencies";
			return false;
		}		
		return true;
	} 
}
?>
