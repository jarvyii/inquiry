<?php
require_once 'class/DataAccess.php';

if(!isset($_POST['inquiry']) or $_POST['inquiry'] <> "Production"){
  echo "Error: Wrong access.";
  return;
}

if(!isset($_POST['operator']) or $_POST['operator'] == "") {
  echo "Error: You need to be logged to the system.";
  return;
}

if (! isset($_POST['order']) or $_POST['order'] == "" ) {
  echo "Error: Missing order number or empty";
  return;
}

if (! isset($_POST['line']) or $_POST['line'] == "") {
    echo "Error: Missing line number or empty";
    return;
}

if (! isset($_POST['idmachine']) or $_POST['idmachine'] == "") {
    echo "Error: Missing id machine  or empty";
    return;
}

if (! isset($_POST['isflitch']) or $_POST['isflitch'] == "") {
    echo "Error: It's not necesary the flitch #.";
    return;
}

$isFlitch = htmlspecialchars($_POST['isflitch']);
$Flitch = "";

if (strtoupper($isFlitch) == "Y" or  strtoupper($isFlitch) != "U" ) 
{
   echo "Error: It's not necesary to update the flitch #.";
  return;
}

if (! isset($_POST['flitch']) or $_POST['flitch'] == "") 
{
  echo "Error: Missing flitch number";
  return;
}

 $Flitch =  htmlspecialchars($_POST['flitch']);
                                           
 $Param = array("operator" => $_POST['operator'],
                "order"     => $_POST['order'],
                "line"      => $_POST['line'],
                "flitch"   => $Flitch,
                "itemnumber" => $_POST['itemnumber']
              );
                         
  $objData = new DataAccess();

  $objData -> updateFlitch($Param);
  echo "OK";
?>