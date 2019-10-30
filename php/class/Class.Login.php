<?php
/**
 * Class.Login.php
 *
 *
 *
 * 
 * @link        /PHP/FLEX/class/Class.Login.php
 * @category    MIA Systems
 * @copyright   Copyright (c) 2019 Mini-MAX Information Systems
 * @author      Jess Speed
 * 
 */
if ( !function_exists("password_hash") ) require_once '/PHP/library/assets/password.php';
if ( !class_exists("Zend_Db_Adapter_Db2") ) require_once '/PHP/library/Db/Adapter/Db2.php';
if ( !class_exists("ToolkitService") ) require_once '/PHP/library/ToolkitService.php'; 
if ( !class_exists("FileHandler") ) require_once '/PHP/FLEX/class/Class.FileHandler.php'; 
if ( !class_exists('ErrorHandler') )  require_once '/PHP/FLEX/class/Class.ErrorHandler.php';
class Login
{
	public $sessid, $TIMEI, $TIMEX, $TIMEO, // Current running values
					$DTTIMEI, $DTTIMEX, $DTTIMEO, $ACTIVITY, // Perm. Set Values
				// Object variables
					$Log, 
				// Class variables 
					$debug, $error;
	protected $user, $registered, $server, $FileHandler;
	private $pass, $hash, $tkitConn, $conn, $config;
	/////////////////////////////////////////////////////////////////////////
	function __construct( $user=false, $pass=false )
	{
		$this->user 	= ( isset( $user ) && $user != '' && $user != false ? $user: false );
		$this->pass 	= ( isset( $pass ) && $pass != '' && $pass != false ? $pass: false );
		$this->server	= 'C702B9F0'; // Change this based of AS400 System value
		$this->debug 	= array();
		$this->error 	= false;
		$this->setUp();
	}
	/////////////////////////////////////////////////////////////////////////
	protected function setUp()
	{ 
		$this->registered	= false;
		if ( !$this->user || !$this->pass ) { $this->error=true; $this->debug['ERROR'][] = 'Could not connect due to wrong user or password.'; }

		$this->hash = password_hash( $this->pass, PASSWORD_BCRYPT );

	// Open Connection to database
		if ( !$this->connect() ) { $this->catchError( 'log', false, $this, false ); $this->error=true; return false; }

	// Open Toolkit to validate user
		if ( !$this->openTKitConnect() ) { $this->catchError( 'log', false, $this, false ); $this->error=true; return false; }

	// Log User login
		if ( !$this->logUser() ) { $this->catchError( 'log', false, $this, false ); $this->error=true; return false; }

		return;
	}
	/////////////////////////////////////////////////////////////////////////
	private function connect()
	{ 	
	  $this->config =  array(   'dbname'   => '*LOCAL',
				                      'username' => '',
				                      'password' => '',
				                      'os'=>'i5',
				                      'driver_options'=> array( 
				                      													"i5_commit" =>DB2_I5_TXN_READ_UNCOMMITTED,
				                                                "autocommit"=>DB2_AUTOCOMMIT_OFF,
				                                              ) );

  	$this->conn = new Zend_Db_Adapter_Db2( $this->config );

		if ( !$this->testConnection( $this->conn ) ) return false;
		return true;
	} 
	/////////////////////////////////////////////////////////////////////////
	private function openTKitConnect()
	{ 
		if ( !$this->testConnection( $this->conn ) ) return false;

	/************************* DB Connection *******************************/ 
	// Setup Database Connection to Login to AS/400 
		$db = db2_connect( $this->server, $this->user, $this->pass, array( 'i5_naming' => DB2_I5_NAMING_ON ) );  

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
	/////////////////////////////////////////////////////////////////////////
	protected function testConnection( $conn )
	{ 
		if ( !is_object( $conn ) || $conn === false )
		{ 
			$this->error = true;
			$this->debug['ERROR'][] = "Server error: Connection to the database could not be established! Please check log file and debug output for diagnosis.";
			return false;
		}
		return true;
	}
	/////////////////////////////////////////////////////////////////////////
	protected function logUser()
	{ 

		$this->FileHandler = new FileHandler( $this->conn, 'DEV', 'DBLOGUSER', basename( $_SERVER["SCRIPT_FILENAME"], '.php' ) );


  	$this->FileHandler->setCols( '( DTTIMEI, DTTIMEX, DTTIMEO, ACTIVITY, SESSID, USER, DATAENVR, ATTEMPTS, MACHINEID ) ' );

  	// check if user is already registered
  	$this->FileHandler->setSelect( 'USER' );  
  	$this->FileHandler->setWhere( 'USER = \''. $this->user .'\'' );  	

		// User is not registered already update flag to prep for new insert
  	if ( !$this->FileHandler->hitFile() ) $this->registered	= true;// turn on flag

  	if ( !$this->registered )
		{
			// Register new User record 
			$this->registerUser();
		}// Check if user is registered

  		// $this->FileHandler->setSelect( '' );
  	
  		// If hash pw match 
  		// Update Last Action and Time Expired with new time, Machine ID reset Login attempts

  	// If user has match but session has expired 
  		// If hash pw match reset all variables

  	// if user not already signed in and not match for user found
  		// create new sign in, new expired params




		if ( $this->FileHandler->error )
		{ 
			$this->error = true;
			$this->debug['ERROR'][] = "Server error: Connection to the database could not be established! Please check log file and debug output for diagnosis.";
			return false;
		}
		return true;
	}
 	/////////////////////////////////////////////////////////////////////////
	protected function registerUser()
	{ 
		// Get Time Stamp of Now
		$this->timeStamp();

		return;
	}	
 	/////////////////////////////////////////////////////////////////////////
	protected function timeStamp( $strTime=0 )
	{ 
		// Generate all User time stamp values for Insert or Update
		$this->DTTIMEI = '1000-01-01-00.00.00.000000';// Example 1000-01-01-00.00.00.000000
		$this->DTTIMEO = '1000-01-01-00.00.00.000000';
		$this->DTTIMEX = '1000-01-01-00.00.00.000000';

		$this->ACTIVITY = $strTime;	// Current Start time
		return;
	}	
 	/////////////////////////////////////////////////////////////////////////
	protected function updateTime()
	{ 
		// Generate all User time stamp values for Insert or Update
		$this->DTTIMEI = '1000-01-01-00.00.00.000000';// Example 1000-01-01-00.00.00.000000
		$this->DTTIMEO = '1000-01-01-00.00.00.000000';
		$this->DTTIMEX = '1000-01-01-00.00.00.000000';

		$this->ACTIVITY = $strTime;	// Current Start time
		return;
	}	
 	/////////////////////////////////////////////////////////////////////////
	public function getHash()
	{ 
		return $this->hash;
	}	
	///////////////////////////////////////////////////////////////////////////////////////
	protected function catchError( $e, $data, $sendAlert )
	{
	///////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////
		$ErrorHandler = new ErrorHandler ( 'email', $e, $data, $sendAlert );
		if ( $ErrorHandler->error ) 
		{
			Echo "\n\nAn Error occured on the ErrorHandler Class function. Full Program dump:  ". json_encode( $this, JSON_PRETTY_PRINT );
			exit();
		}// 
	 	die();
	///////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////
	}
}
?>