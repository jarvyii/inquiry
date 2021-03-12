<?php
// Login Query 
 require_once '/PHP/FLEX/class/Class.Login.php';
require_once 'inquiry.php'; 
require_once 'class/DataAccess.php';
require_once '/PHP/library/ToolkitService.php'; 

error_reporting(E_ALL|E_STRICT);

ini_set('display_errors', 'on');

$user = $_POST['username'];
$pass = $_POST['psw'];

$Login = new Login( $user, $pass );

if ( !$Login->error ) 
{

	if ($_POST["typeuser"] == "operator") {
		  
		  	Tracking($user, 0);
	} else 	{
		 	TrackingInquiry($user, "");
	}

}
else{
	echo "No db connection!";
}
exit();
?>