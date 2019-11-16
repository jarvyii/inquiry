<?php
require_once 'class/DataAccess.php';
//require_once 'Views/viewInquiry.php';
/**************************************************************
    function  viewProduction($UserName)
**************************************************************/
function  viewProduction($BarCode, $idMachine, $descMachine,$Operator){ 
   Head();
   $Pos = strpos($BarCode, "/");
   $Order= substr($BarCode,0, $Pos);
   $LineNumber = substr($BarCode,$Pos+1);
   $objOrder = new DataAccess(); 
   $headOrder = $objOrder -> getOrderHeader($Order, $LineNumber, $Operator);
   //Order Item info.
   $headOI = $objOrder ->getOrderItem($Order, $LineNumber, $Operator);
   //$Yestarday = 
   //echo date("Y-m-d",$t);
  // $rightNow = date_create("2013-03-15"); //time();
   $d =$headOrder['EHORDT'];
   $Date = substr($d, 3,2)."/".substr($d, 5,2)."/".substr($d, 1,2);
   
   $processTime = 5;
   $qtyNeeded = (int)$headOI['EIOCQ'] - (int)$headOI['EICCQ'];
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
          <label class="label-tracking" for="barcode">Bar Code: <span class="label-content"><?php echo $BarCode?></span></label>
          <label class="label-tracking">Machine: <span class="label-content"><?php echo $descMachine?></span></label>
          <label class="label-tracking">Customer: <span class="label-content"><?php echo $headOrder['EHCT#']?></span></label>
          <label class="label-tracking">Order date: <span class="label-content"><?php echo $Date?></span></label>
          <label class="label-tracking">Order Qty: <span class="label-content"><?php echo $headOI['EIOCQ']?></span></label>
          <label class="label-tracking">Qty Completed: <span class="label-content"><?php echo $headOI['EICCQ']?></span></label>
          <label class="label-tracking">Qty Needed: <span class="label-content"><?php echo $qtyNeeded?></span></label>
          <label class="label-tracking">Item: <span class="label-content"><?php echo $headOI['EIPN']?>"</span></label>
          <label class="label-tracking">Line Item Comments: <span class="label-content"><?php echo $headOI['EILID']?></span></label><br><br>
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