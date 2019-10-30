<?
/**
 * 
 * Class.FileHandler.php
 * 
 * 
 * 
 * - Setup to handle already defined files
 * 
 * 
 * 
 * @link 				/PHP/FLEX/class/Class.FileHandler.php
 * @copyright   Copyright (c) 2019 Mini-MAX Information Systems
 * @author      Jess Speed
 * @license    
 * 
 */
if (!class_exists('ErrorHandler'))  require_once '/PHP/FLEX/class/Class.ErrorHandler.php';
class FileHandler
{
	public $file, $prog, $record, $dataEnvir, $today,
						$debug, $error;
	protected $user, $col, $vals, $setUpdVals, $select, $where, $groupBy, $having, $orderBy, $limit, $tempFile;
	private $fileCheck, $conn, $conn2;
	///////////////////////////////////////////////////////////////////////////////////////
	function __construct( $conn, $dataEnvir, $file, $prog, $user='AS400', $added=false )
	{
	///////////////////////////////////////////////////////////////////////////////////////
		$this->conn 		= $conn;
		$this->dataEnvir= ( $dataEnvir == 'Prod' )? 'FLEXWEB': 'FLEXWEB'; // One production library, one development
		$this->user 		= $user; // Optional, Default to AS400
		$this->today 		= ( !$added || $added == null || $added == '' )? $added: date("Ymd"); // Optional, Default to Today
		$this->file 		= $file; // System File
		$this->prog 		= $prog; // Program Calling
		$this->debug 		= array();
		$this->error 		= false;
		$this->setUp();
	///////////////////////////////////////////////////////////////////////////////////////
	}
	///////////////////////////////////////////////////////////////////////////////////////
	private function setUp()
	{
	///////////////////////////////////////////////////////////////////////////////////////
		$this->setupTempFile();
		$this->col = '';
		$this->vals = '';
		$this->setUpdVals = '';
		$this->select = '';
		$this->where = '';
		$this->record = '';
		$this->limit = '';
		return;		
	///////////////////////////////////////////////////////////////////////////////////////
	}
	///////////////////////////////////////////////////////////////////////////////////////
	// public function clearFile( $file='' )
	// {
	// ///////////////////////////////////////////////////////////////////////////////////////
	// 	$this->setFile( $file );

	// 	if ( !$this->file ) return false;

	// 	$deleteSQL = 'DELETE '. $this->dataEnvir .'."' . $this->file . '" WITH NONE;';
	// 	$this->debug['STMT']['deleteSQL'] = $deleteSQL;
	// 	try 
	// 	{
 //    	$clearFile = $this->conn->query($deleteSQL);
	// 	} 
	// 	catch (Exception $e) {
	// 	//////////////////////////////////////////////////////////////////////////////////
	// 		// if (!$deleteSQL) return false;
	// 		$this->catchError( $e, $deleteSQL, true );
	// 	//////////////////////////////////////////////////////////////////////////////////
	// 	}
	// 	return true;		
	// ///////////////////////////////////////////////////////////////////////////////////////
	// }
	///////////////////////////////////////////////////////////////////////////////////////
	public function insertRecord()
	{
	///////////////////////////////////////////////////////////////////////////////////////
		if ($this->col == '')  
		{
			$this->error = true;
			$this->debug['ERROR'] = 'Column are not set for insert. Please specify the Columns to Insert!';
			return false;
		}
		if ($this->vals == '')  
		{
			$this->error = true;
			$this->debug['ERROR'] = 'Column Values are not set for insert! Record was not saved.';
			return false;
		}
				
		$insrtSQL = 'INSERT INTO '. $this->dataEnvir .'."' . $this->file . '" '. $this->col .' VALUES '. $this->vals .' WITH NONE;';
		$this->debug['STMT']['insrtSQL'] = $insrtSQL;
		try 
		{
    	$insertRec = $this->conn->query($insrtSQL);
		} 
		catch (Exception $e) {
		//////////////////////////////////////////////////////////////////////////////////
			$this->catchError( $e, $insrtSQL, true );
		//////////////////////////////////////////////////////////////////////////////////
		}
		return true;		
	///////////////////////////////////////////////////////////////////////////////////////
	}
	///////////////////////////////////////////////////////////////////////////////////////
	public function updateRecord()
	{
	///////////////////////////////////////////////////////////////////////////////////////
		if ($this->setUpdVals == '')  
		{
			$this->error = true;
			$this->debug['ERROR'] = 'Values are not set for updating. Please specify the Columns and new Values to Update!';
			return false;
		}
		if ($this->where == '')  
		{
			$this->error = true;
			$this->debug['ERROR'] = 'Where clause is not set for Updating! Nothing was Updated.';
			return false;
		}

		/////////////////////////////////////////////////////////////////////////////////////
		$recordExists = $this->hitFile(); // confirm record found

		if ( !$recordExists )
		{
			$this->error = true;
			$this->debug['ERROR'] = 'Unable to find a match with values provided for updating. Please specify the record you wish to update!';
			return false;
		}
		/////////////////////////////////////////////////////////////////////////////////////
				
		$updateSQL = 'UPDATE '. $this->dataEnvir .'."' . $this->file . '" SET '. $this->setUpdVals .' WHERE '. $this->where .' WITH NONE;';
		$this->debug['STMT']['updateSQL'] = $updateSQL;

    if ( !$this->conn2 ) $this->openConnection(); // Open Second Connection to handle Update commit

		try 
		{
     	$this->conn2->beginTransaction();
      $updRec = $this->conn2->prepare($updateSQL); // prepare update
      if ( $updRec ) 
      {
       // Success. Commit Update
        $this->conn2->query($updateSQL);                
        $this->conn2->commit();         
      } 
      else 
      { // *** Error roll update back ***
	    	$this->conn2->rollback();
				$this->error = true;
				$this->debug['ERROR'] = 'There was an Error updating record! Nothing was Updated.'; 
				return false; 
			}
		} 
		catch (Exception $e) 
		{
		//////////////////////////////////////////////////////////////////////////////////
			$this->catchError( $e, $updateSQL, true );
		//////////////////////////////////////////////////////////////////////////////////
		}
		return true;		
	///////////////////////////////////////////////////////////////////////////////////////
	}
	///////////////////////////////////////////////////////////////////////////////////////
	public function getRecord( $record )
	{
	///////////////////////////////////////////////////////////////////////////////////////
		if ( !isset( $this->file ) || $this->file == false ) 
		{
			$this->record = ( isset($record) && $record !== false && $record !== '' && $record !== null )?  $record: false; // filter invalid formats
			$this->file = ( $this->record !== false )? $record: false; // Verify File is mapped
			if ( !$this->file )  
			{
				$this->error = true;
				$this->debug['ERROR'] = 'No File specified for Querying! Nothing was Queried.';
				return false;
			}
		}// If File not set
				
		$querySQL = ( $this->select !== '' )? 	'SELECT '. $this->select .' FROM '. $this->dataEnvir .'."' . $this->file .'"': 
																						'SELECT * FROM '. $this->dataEnvir .'."' . $this->file .'"';
		$querySQL .= ( $this->where !== false && $this->where !== '' )? ' WHERE '. $this->where: '';
		$querySQL .= ( $this->groupBy !== false && $this->groupBy !== '' )? ' GROUP BY '. $this->groupBy: '';
		$querySQL .= ( $this->having !== false && $this->having !== '' )? ' HAVING '. $this->having: '';
		$querySQL .= ( $this->orderBy !== false && $this->orderBy !== '' )? ' ORDER BY '. $this->orderBy: '';
		$querySQL .= ( $this->limit !== false && $this->limit !== '' )? ' LIMIT '. $this->limit: '';

		$querySQL .= ';';

		$this->debug['STMT']['querySQL'] = $querySQL;

		try 
		{
    	$queryFile = $this->conn->query($querySQL);
		} 
		catch (Exception $e) {
		//////////////////////////////////////////////////////////////////////////////////
			$this->catchError( $e, $querySQL, true );
		//////////////////////////////////////////////////////////////////////////////////
		}
		$dataArr = array();
		$row=0;
    while ( ($queriedData = $queryFile->fetch(Zend_Db::FETCH_ASSOC)) !== false) 
    {
      foreach ($queriedData as $k => $v) 
      {
      	$v = trim($v);
      	$dataArr[$row][ $k ] = $v;
      }//foreach loop		
      $row++;		                
    }// While Loop
		return $dataArr;		
	///////////////////////////////////////////////////////////////////////////////////////
	}
	///////////////////////////////////////////////////////////////////////////////////////
	public function hitFile()
	{
	///////////////////////////////////////////////////////////////////////////////////////
	///
		if ( !$this->file )  
		{
			$this->error = true;
			$this->debug['ERROR'] = 'No File specified to check for a hit! Nothing was Queried.';
			return false;
		}
				
		$hitFileSQL = ( $this->select !== '' )? 'SELECT '. $this->select .' FROM '. $this->dataEnvir .'."' . $this->file .'"': 
												'SELECT * FROM '. $this->dataEnvir .'."' . $this->file .'"';
												
		$hitFileSQL .= ( $this->where !== '' )? ' WHERE '. $this->where .' ;' : ' ;';

		$this->debug['STMT']['hitFileSQL'] = $hitFileSQL;

		try 
		{
    	$queryFile = $this->conn->query($hitFileSQL);
		} 
		catch (Exception $e) {
		//////////////////////////////////////////////////////////////////////////////////
			$this->catchError( $e, $hitFileSQL, true );
		//////////////////////////////////////////////////////////////////////////////////
		}
		$hit = false;
    while ( ( $queriedData = $queryFile->fetch(Zend_Db::FETCH_ASSOC)) !== false) 
    		foreach ($queriedData as $row => $cnt ) $hit = ( trim($cnt) > 0 )? true: false;  // While Loop  
    if ( !$hit ) return false;
    else return true;	
	///////////////////////////////////////////////////////////////////////////////////////
	}
	///////////////////////////////////////////////////////////////////////////////////////
	public function setUpdateVals( $vals='' )
	{
		$this->setUpdVals = ( $vals !== false && $vals !== '' && $vals !== null )? $vals: '';
		return;
	///////////////////////////////////////////////////////////////////////////////////////
	}
	///////////////////////////////////////////////////////////////////////////////////////
	public function setSelect( $sel='' )
	{
		$this->select = ( strtoupper($sel) == 'COUNT' )? 'count(*)': $sel; // default to all
		return;
	///////////////////////////////////////////////////////////////////////////////////////
	}
	///////////////////////////////////////////////////////////////////////////////////////
	public function setWhere( $where='' )
	{
		$this->where = ( $where !== false && $where !== '' && $where !== null )? $where: '';
		return;
	///////////////////////////////////////////////////////////////////////////////////////
	}
	///////////////////////////////////////////////////////////////////////////////////////
	public function getTempF()
	{
		return $this->tempFile;
	///////////////////////////////////////////////////////////////////////////////////////
	}
	///////////////////////////////////////////////////////////////////////////////////////
	public function setupTempFile()
	{
		$uniqueFile = 'TmpFile_'. uniqid();
		$this->tempFile = $uniqueFile;
		return;
	///////////////////////////////////////////////////////////////////////////////////////
	}
	///////////////////////////////////////////////////////////////////////////////////////
	public function setCols( $col='' )
	{
		$this->col = $col;
		return;
	///////////////////////////////////////////////////////////////////////////////////////
	}
	///////////////////////////////////////////////////////////////////////////////////////
	public function setVals( $vals='' )
	{
		$this->vals = ( $vals !== false && $vals !== '' && $vals !== null )? $vals: '';
		return;
	///////////////////////////////////////////////////////////////////////////////////////
	}
	///////////////////////////////////////////////////////////////////////////////////////
	public function setGroupBy( $grp='' )
	{
		$this->groupBy = ( $grp !== '' && $grp !== null )? $grp: false; // System File
		return;
	///////////////////////////////////////////////////////////////////////////////////////
	}
	///////////////////////////////////////////////////////////////////////////////////////
	public function setHaving( $having='' )
	{
		$this->having = ( $having !== '' && $having !== null )? $having: false; // System File
		return;
	///////////////////////////////////////////////////////////////////////////////////////
	}
	///////////////////////////////////////////////////////////////////////////////////////
	public function setOrderBy( $order='' )
	{
		$this->orderBy = ( $order !== '' && $order !== null )? $order: false; // System File
		return;
	///////////////////////////////////////////////////////////////////////////////////////
	}
	///////////////////////////////////////////////////////////////////////////////////////
	public function setLimit( $limit )
	{
		$this->limit = ( $limit !== '' && $limit !== null )? $limit: false; // System File
		return;
	///////////////////////////////////////////////////////////////////////////////////////
	}
	///////////////////////////////////////////////////////////////////////////////////////
	public function setFile( $file='' )
	{
		$this->file = ( $file !== '' && $file !== null )? $file: false; // System File
		return;
	///////////////////////////////////////////////////////////////////////////////////////
	}
	///////////////////////////////////////////////////////////////////////////////////////
	private function openConnection()
	{
		if (!class_exists( "Zend_Db_Adapter_Db2" ) ) include '/PHP/library/Db/Adapter/Db2.php';

    $config =  array(   'dbname'   => '*LOCAL',
                        'username' => '',
                        'password' => '',
                        'os'=>'i5',
                        'driver_options'=> array(
                        													"i5_commit" =>DB2_I5_TXN_READ_UNCOMMITTED,
											                            "autocommit"=>DB2_AUTOCOMMIT_OFF,
											                            "i5_naming" => DB2_I5_NAMING_ON 
											                          ) );

    $this->conn2 = new Zend_Db_Adapter_Db2($config); 
		return;
	///////////////////////////////////////////////////////////////////////////////////////
	}	
	///////////////////////////////////////////////////////////////////////////////////////

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