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

   
   //$db = new DataAccess($user, $pass);
   //$db->connect();

	tracking($user);

}// end connection test
else{
	echo "No db connection!";
}
exit();
?>