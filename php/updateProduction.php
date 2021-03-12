<?php
require_once 'inquiry.php';

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

if (! isset($_POST['starttime']) or $_POST['starttime'] == "") {
    echo "Error: Missing start time  or empty";
    return;
}

if (! isset($_POST['endtime']) or $_POST['endtime'] == "") {
    echo "Error: Missing end time  or empty";
    return;
}

if (! isset($_POST['qtyproduced']) or $_POST['qtyproduced'] == "") {
    echo "Error: Missing quantity produced";
    return;
}



$isFlitch = isset($_POST['isflitch']) ? htmlspecialchars($_POST['isflitch']): "N";
$Flitch = "";

if (strtoupper($isFlitch) == "Y" or strtoupper($isFlitch) == "U" ) {
      if (! isset($_POST['flitch']) or $_POST['flitch'] == "") {
        echo "Error: Missing flitch number";
        return;
      }
     $Flitch =  htmlspecialchars($_POST['flitch']);

} 
                                           
 $Param = array("operator" => $_POST['operator'],
                "order"     => $_POST['order'],
                "line"      => $_POST['line'],
                "idmachine"  => $_POST['idmachine'],
                "starttime"=> $_POST['starttime'],
                "endtime"  => $_POST['endtime'],
                "qty"      =>(int)$_POST['qtyproduced'],
                "flitch"   => $Flitch,
                "panelfacbck" => $_POST['panelfacbck'],
                "comment"  => $_POST['comment'],
                "override" => $_POST['supervisor'],
                "itemnumber" => $_POST['itemnumber'],
                "shortageTicket" => $_POST['code'] == ""? false:true,
                "ïsflitch" => $isFlitch
              );
                         
 endProduction( $Param );
echo "OK";
?>