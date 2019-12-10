<?php
require_once 'class/DataAccess.php';
//require_once 'Views/viewInquiry.php';
/**************************************************************
    function  viewProduction($UserName)
**************************************************************/
function  viewProduction($BarCode, $idMachine, $descMachine,$Operator, $qtyCmpted, $headOrder, $headOI){ 
   Head();
   $Pos = strpos($BarCode, "/");
   $Order= substr($BarCode,0, $Pos);
   $LineNumber = substr($BarCode,$Pos+1);
   $d =$headOrder['EHORDT'];
   $Date = substr($d, 3,2)."/".substr($d, 5,2)."/".substr($d, 1,2);
   $processTime = 5;
   $codeItem = $headOI['EIPN'];
   $orderQty = $headOI['EIOCQ'];
   $neededQty = $headOI['EICCQ'];
   $maxNeeded = $orderQty - $qtyCmpted; // Quantity to produce
   $objOrder = new DataAccess();
   $itemDesc = $objOrder ->getItemDesc( $codeItem);
    ?>

  <form name="production"  action="ControllerInquiry.php" method="post" autocomplete="on">
        <input type="hidden" name="inquiry" value="Production"/>
        <input type="hidden" name="operator" id = "operator" value="<?php echo $Operator?>"/>
        <input type="hidden" name="barcode" id = "barcode" value="<?php echo $BarCode?>"/>
        <input type="hidden" name="machine" id = "machine" value="<?php echo $idMachine?>"/>
        <input type="hidden" name="orderqty" id = "orderqty" value="<?php echo $orderQty?>"/>
        <input type="hidden" name="qtycmpted" id = "qtycmpted" value="<?php echo $qtyCmpted?>"/>
        <input type="hidden" name="code" id = "code"/>
        <input type="hidden" name="supervisor" id = "supervisor"/>
        <input type="hidden" id="typeuser" name="typeuser" value="operator"/>
        <input type="hidden" name="starttime" id = "starttime"/>
        <input type="hidden" name="endtime" id = "endtime"/>
        <div class="production-info">
          <h5 class="showuser">Operator: <?php echo $Operator?></h5>
          <h3 class= "titlecenter">Production Process</h3>
          <!--  Bar Code -->
          <label class="label-tracking" for="barcode">Order No.: <span class="label-content"><?php echo $BarCode?></span></label>
          <label class="label-tracking">Machine: <span class="label-content"><?php echo $descMachine?></span></label>
          <label class="label-tracking">Customer: <span class="label-content"><?php echo $headOrder['EHCT#']?></span></label>
          <label class="label-tracking">Order date: <span class="label-content"><?php echo $Date?></span></label>
          <label class="label-tracking">Order Qty: <span class="label-content"><?php echo $orderQty?></span></label>
          <label class="label-tracking">Qty Needed: <span class="label-content"><?php echo $neededQty?></span></label>
          <label class="label-tracking">Qty Completed: <span class="label-content"><?php echo $qtyCmpted?></span></label>
          
          <label class="label-tracking">Item: <span class="label-content"><?php echo $codeItem?></span></label>
          <label class="label-tracking">Item Desc.: <span class="label-content"><?php echo $itemDesc?></span></label><br><br>
        </div>

        <div class="processing container justify-content-center">
            <div class="producecontent col">
              <label  for="processtime">Processing:</label>
              <input class="processing_color titlecenter blinking" name="processtime" id="processedtime" size="10" type="text" disabled value="<?php echo "00h:00m:00s" ?>"><br>
              <label  for="qtyproduced">Qty Produced:</label>
              <input class="quantityproduced" type="number" name="qtyproduced" id="qtyproduced"  min="0" max="<?php echo $maxNeeded?>" value="<?php echo "0"?>">
              <label  for="comment">Comment: 
                <input  class="comment" type="text" name="comment" size= "50" id="comment" placeholder="Write comments if order incomplete."></label>
              <br>
            </div>
          <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
              <button id="startprod" class="btn_lg startbutton"  type="button">Start</button>
              <button id="stopprod" class="btn_lg button-reset " type="submit">Stop</button>
            </div>
            <div class="col-4"></div>
          </div>
        </div>
  
</form>

<form>
<!-- The Modal --> 
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Supervisor Override</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          The quantity produced is less than the quantity in the order.<br>
             <label>Supervisor CODE: 
                <input  class="comment" name="override" id="override" autofocus type="password"  required placeholder="Type the code."></label>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer"> 
          <button type="button" class="btn startbutton" data-dismiss="modal">Submit</button>
        </div>
        
      </div>
    </div>
  </div>  

</form>


  <?php
   $newScript = '<script src="../js/production.js"></script>';
  Foot($newScript);
}