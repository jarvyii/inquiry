<?php
function BarCode ()
 {
    echo 'Testing the Value of the Tracking for Flexible Materials<br>';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // collect value of input field
        if (empty($_POST['barcode'])) {
            echo "The BarCode value  is empty";
        } else {
          echo 'Bar Code is:', $_POST['barcode'];
        }
        if (empty($_POST['machine'])){
          echo '<br> The Machine Code is Empty';
        }
        else{
          echo '<br> The Machine Code is: ', $_POST['machine'];
        }
        if (empty($_POST['operator'])){
          echo '<br> The Operator Code is Empty';
        }
        else{
          echo '<br> The Operator Code is: ', $_POST['operator'];
        }
    }
}
function TrackingInquiry(){
  echo 'Testing the Value of the Tracking for Flexible Materials<br>';
 foreach ($_POST as $key => $value) {
   // code...
   echo $key,"=>",$value,'<br>';
 }
}
if (isset($_POST['formname'])) {
  switch($_POST['formname']){
    case 'tracking'       : barcode();
                            break;
    case 'trackinginquiry': TrackingInquiry();
                            break;
  }
}
?>
