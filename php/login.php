<?php
// Login Query 
require_once '/PHP/FLEX/class/Class.Login.php';
require_once 'inquiry.php';
require_once 'class/DataAccess.php';
require_once '/PHP/library/ToolkitService.php'; 
//echo "script started\n\n";
error_reporting(E_ALL|E_STRICT);

ini_set('display_errors', 'on');


// $user = 'minimax'; //"OS400 C702B9F0 3 7 00780002B9F0"
// $pass = 'prog';    //HASH: $2y$10$WTEm/v6cavUrd/izR/bneedODBUyuXllGDOjW4qrBjIpvojdjoegC
//$user = 'jareynaldo'; //"OS400 C702B9F0 3 7 00780002B9F0"
//$pass = 'Catalijo3';  //HASH: $2y$10$i8oM79MiOa/n83NoJIoYfOJyekyzrjPP86Ps6P/HmNKZA0rNxonb6
                        //      $2y$10$0/LZ0bHAjxtz6eq0QV/fYO98gYJymySaUyRbdgtj4Vw58TMxnUl7u
                        //HASH: $2y$10$WTEm/v6cavUrd/izR/bneedODBUyuXllGDOjW4qrBjIpvojdjoegC
$user = $_POST['username'];
$pass = $_POST['psw'];
//echo "<br>User:". $user;
//echo "<br>Pass:". $pass;
$Login = new Login( $user, $pass );



if ( !$Login->error ) 
{
// Pull in ToolKit
  // require_once 'Library/ToolkitService.php'; 


// Setup Database Connection to Login to AS/400 
	// $db = db2_pconnect('S10BD612', $user, $pass, array('i5_naming' => DB2_I5_NAMING_ON));  
 /*******************************************
     To check User INFO
	    echo json_encode( php_uname() , JSON_PRETTY_PRINT);
      echo "<br>Goingggggggggggggggggg";
	    echo "<br> HASH: " .$Login->getHash();
	    echo "<br>Going";
	*****************************************/

   echo "Solo para probar";
  // $db = db2_pconnect('', $user, $pass, array('i5_naming' => DB2_I5_NAMING_ON));

    $config =  array(   'dbname'   => "flexweb",
                              'username' => "jareynaldo",
                              'password' => "Catalijo3",
                              'os'=>'i5',
                              'driver_options'=> array( 
                                                        "i5_commit" =>DB2_I5_TXN_READ_UNCOMMITTED,
                                                        "autocommit"=>DB2_AUTOCOMMIT_OFF,
                                                      ) );
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
    $db = new Zend_Db_Adapter_Db2( $config );
   // $db = db2_connect("FLEXWEB", "jareynaldo", "Catalijo3");

   if ($db) {
     echo "Connected";
     //var_dump($db);
     $data = $db->listTables();
     var_dump($data);
     //print($data);
     $size = count($data);
     echo $size;
     for( $i=0; $i<$size; $i++)
       echo "<BR>", $data[$i];
     //$db->query("select * from EIM;");
     $Data = $db ->query('SELECT * FROM FLEXWEB.EIM');
     //var_dump($Data);
     $row = $db->fetchRow('SELECT EIORD FROM FLEXWEB.EIM');
     var_dump($row);
   }
    else
      echo "Connecting error";
   //$db = new DataAccess($user, $pass);
   //$db->connect();

	//tracking($user);

}// end connection test
else{
	echo "No db connection!";
}
exit();
?>