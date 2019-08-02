<?php
function Head()
 { ?>
   <!DOCTYPE html>
   <html lang="en">
   <head>
   <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
   <title>Inquiry System</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="../css/inquiry.css">

   </head>
   <body id="home">
     <!-- Main jumbotron for a  Logo Image about the Company-->
     <div class="container">
       <div class="jumbotron bg-white" id="jumbotron">
           <img class="img-responsive img-fluid" width="60%" height="52" src="../img/flexiblematerial-bl.png"  alt="Flexible Material">
       </div> <!-- /jumbotron -->
     </div> <!-- /Container-->
<?php
}
/*************************************************
Display the Header of the Tracking and the Column Header for the INformation
**************************************************/
function TrackingDisplayHead( $OrderNumber, $LineNumber ){
  ?>
  <input type="hidden" name="ordernumber" id = "ordernumber" value="<?php echo $OrderNumber?>"/>
  <input type="hidden" name="linenumber" id = "linenumber" value="<?php echo $LineNumber?>"/>
  <h3>Tracking Inquiry Display</h3><br>
  <div class="row">
       <div id="tracking-label" class="col-2 "></div>
       <div id="tracking-value" class="col-10"></div>
  </div>
  <label>Item:</label><br>
  <div class="row">
    <div id="machine" class="col-2">
      <label>Machine</label>
    </div>
    <div id="operator" class="col-2">
      <label>Operator</label>
    </div>
    <div id="qty" class="col-2">
      <label>Qty</label>
    </div>
    <div id="startdate" class="col-2">
      <label>Sart Date/Time</label><br>
    </div>
    <div id="stopdate" class="col-2">
      <label>Stop Date/Time</label>
    </div>
    <div id="elapsedtime" class="col-2">
      <label>Elapsed Time</label>
    </div>
  </div>
  <label></label><br>
  <script src="../js/inquirydisplay.js"></script>
</body>
</html>
 <?php
}
/******************************************************
Display all info using the Variable:
$BarCode, $OrderCode, $LineNumber
*******************************************************/
function TrackingDisplay($OrderNumber, $LineNumber) {
    Head();
    TrackingDisplayHead($OrderNumber, $LineNumber);

}
/*******************************************************
Get this Variable  $BarCode, $Machine, $Operator from Operator to be use
********************************************************/
function TrackingInquiry( $BarCode, $Machine, $Operator){
  Head();
  ?>
  <form name="trackinginquiry"  action="inquiry.php" method="post" autocomplete="on">
        <input type="hidden" name="inquiry" value="TrackingInquiry"/>
        <div class="tracking">
          <h3>Tracking Inquiry</h3><br>
          <label class="label-inquiry" for="ordernumber">Order Number:</label>
          <input class="input-tracking" type="text" name= "ordernumber"  id="ordernumber" size = "15" placeholder="Enter Order Number" autofocus><br>
          <label class="label-inquiry" for="linenumber">Line Number:</label>
          <input class="input-tracking" type="number" name = "linenumber" id="linenumber"  placeholder="Enter Line Number" required><br>
          <div class="button-tracking row">
             <div class ="col">
                <button type="submit" class="btn btn-success ">Submit</button>
             </div>
              <div class ="col">
                <button type="reset" class="btn button-reset">Reset</button>
              </div>
          </div>
        </div>
  </form>
  <script src="../js/inquiry.js"></script>
</body>
</html>
<?php
}
function Tracking($UserName) {
  Head();
  ?>
  <form name="tracking"  action="inquiry.php" method="post" autocomplete="on">
        <input type="hidden" name="inquiry" value="Tracking"/>
        <div class="tracking">
          <h5 class="showuser">User: <?php echo $UserName?></h5><br>
          <h3>Tracking</h3><br>
          <label class="label-tracking" for="barcode">Scan Bar Code:</label>
          <input class="input-tracking" type="text" name= "barcode"  id="barcode" size = "15" placeholder="Bar Code" autofocus><br>
          <label class="label-tracking" for="machine">Machine:</label>
          <input class="input-tracking" type="text" name="machine"  id="machine" size="15" placeholder="Machine"><br>
          <label class="label-tracking" for="operator">Operator:</label>
          <input class="input-tracking" type="text" name = "operator" id="operator" size ="15" placeholder="Operator" required><br>
          <div class="row button-tracking">
            <div class="col">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
            <div class="col">
              <button type="reset" class="btn button-reset">Reset</button>
            </div>
          </div>
        </div>
  </form>
</body>
</html>
  <?php
}
function InquiryControl() {
  ?>
  <div class="inquiry">
  <form  action="php/inquiry.php" method="post" autocomplete="on">
    <input type="hidden" name="formname" value="tracking"/>
    <select name="inquiry" >
        <option value="tracking">Tracking</option>
        <option value="tracking-inquiry">Tracking Inquiry</option>
        <option value="tracking-display">Tracking Inquiry Display</option>
    </select>
    <div class="row button-inquiry">
        <div class="col">
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </div>
  </form>
</div>
  <?php
}
if (isset($_POST['inquiry'])) {
  switch($_POST['inquiry']){
    case 'Login': tracking($_POST['username']);
                  break;
    case 'Tracking': TrackingInquiry($_POST['barcode'], $_POST['machine'],$_POST['operator']);
                     break;
    case 'TrackingInquiry': if(isset($_POST['ordernumber']) and isset($_POST['linenumber'])){
                              $OrderNumber = $_POST['ordernumber'];
                              $LineNumber = $_POST['linenumber'];
                              TrackingDisplay( $OrderNumber,$LineNumber);
                            }
                            break;
  }
}

?>
