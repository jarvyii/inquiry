<?php
//require_once 'Views/viewInquiry.php';
/**************************************************************
    function  viewProduction($UserName)
**************************************************************/
function  viewProduction($BarCode, $idMachine, $descMachine,$Operator){ 
   Head();
   //$Yestarday = 
   //echo date("Y-m-d",$t);
  // $rightNow = date_create("2013-03-15"); //time();
   $processTime = 5;
   //$elapsedTime =  date_add($rightNow,date_interval_create_from_date_string("11 days"));
    ?>

  <form name="production"  action="ControllerInquiry.php" method="post" autocomplete="on">
        <input type="hidden" name="inquiry" value="Production"/>
        <input type="hidden" name="operator" id = "operator" value="<?php echo $Operator?>"/>
        <input type="hidden" name="barcode" id = "barcode" value="<?php echo $BarCode?>"/>
        <input type="hidden" name="machine" id = "machine" value="<?php echo $idMachine?>"/>
         <input type="hidden" id="typeuser" name="typeuser" value="operator"/>
        <input type="hidden" name="starttime" id = "starttime"/>
        <input type="hidden" name="endtime" id = "endtime"/>
        <div class="tracking">
          <h5 class="showuser">Operator: <?php echo $Operator?></h5><br>
          <h3 class= "titlecenter">Production Process</h3><br>
          <!--  Bar Code -->
          <label class="label-tracking" for="barcode">Bar Code:</label>
          <label class="input-tracking"><?php echo $BarCode?></label>
          <label class="label-tracking">Machine:</label>
          <label class="input-tracking"><?php echo $descMachine ?></label><br><br><br>
        </div>
        <div class="processing container justify-content-center">
              <label  for="processtime">Processing:</label>
              <input class="processing_color titlecenter blinking" name="processtime" id="processedtime" size="10" type="text" disabled value="<?php echo "00h:00m:00s" ?>"><br><br>
          <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
              <button id="startprod" class="btn_lg startbutton"  type="button">Start</button>
              <button id="stopprod" class="btn_lg button-reset " type="submit" onclick="stopprod">Stop</button>
            </div>
            <div class="col-4"></div>
          </div>
        </div>
  </form>
  <?php
  Foot();
}