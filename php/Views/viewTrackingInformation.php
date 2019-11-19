<?php
/**************************************
Display the Tracking Information
***************************************/
function viewTrackingInformation($OrderNumber, $LineNumber, $Operator, $headOrder, $headOI) {
   Head(); 
   $d =$headOrder['EHORDT'];
   $orderDate = substr($d, 3,2)."/".substr($d, 5,2)."/".substr($d, 1,2);
   $Customer = $headOrder['EHCT#'];
   $Item = $headOI['EIPN'];
   $orderQty = (int)$headOI['EIOCQ'];
   $qtyNeeded = $orderQty - (int)$headOI['EICCQ'];
   ?>
    <form name="trackinginformation"  action="ControllerInquiry.php" method="post" autocomplete="on">
      <div class="trackinginformation">
        <input type="hidden" name="inquiry" value="TrackingInformation">
        <input type="hidden" name="ordernumber" id = "ordernumber" value="<?php echo $OrderNumber?>">
        <input type="hidden" name="linenumber" id="linenumber" value="<?php echo $LineNumber?>">
        <input type="hidden" name="customer"   id="customer" value="<?php echo $Customer?>">
        <input type="hidden" name="orderdate"  id="orderdate" value="<?php echo $orderDate?>">
        <input type="hidden" name="orderqtty"   id="orderqtty"  value="<?php echo $orderQty?>">
        <input type="hidden" name="item"       id="item"      value="<?php echo $Item?>">
        <input type="hidden" id="typeuser" name="typeuser" value="supervisor"/>
        <h3>Tracking Information</h3><br>
          <label class="label-tracking" for="barcode">Order No.: <span class="label-content"><?php echo $OrderNumber, " / ", $LineNumber?></span></label>
          <label class="label-tracking">Customer: <span class="label-content"><?php echo $Customer?></span></label>
          <label class="label-tracking">Order date: <span class="label-content"><?php echo $orderDate?></span></label>
          <label class="label-tracking">Order Qty: <span class="label-content"><?php echo $orderQty?></span></label>
          <label class="label-tracking">Qty Completed: <span class="label-content"><?php echo $headOI['EICCQ']?></span></label>
          <label class="label-tracking">Qty Needed: <span class="label-content"><?php echo $qtyNeeded?></span></label>
          <label class="label-tracking">Item: <span class="label-content"><?php echo $Item?></span></label>
          <label class="label-tracking">Item Desc.: <span class="label-content"><?php echo $headOI['EILID']?></span></label>
          <label class="label-tracking">Order Comments: <span class="label-content"><?php echo $headOI['EIPNT']?></span></label>
        <!--
        <label class="flex">Order No.: <input  type="text" disabled value="<?php echo $OrderNumber, " / ", $LineNumber?>"></label>
        <label class="flex">Customer: <input type="text" disabled value="<?php echo $Customer?>"></label><br>
        <label class="flex">Order date: <input  type="text" disabled value="<?php echo $orderDate?>"></label>
        <label class="flex">Order Qty: <input  type="text" id="input-orderqty" disabled value="<?php echo $orderQty?>"></label><br>
        <label class="flex" for="input-ordercmpted" >Qty Completed: <input  type="text" id="input-ordercmpted" disabled value="<?php echo $headOI['EICCQ']?>"></label>
        <label class="flex">Qty Needed: <input type="text" id="input-orderneeded" disabled value="<?php echo $qtyNeeded?>"></label> <br>
        <label class="flex">Item: <input type="text" id="input-item" disabled value="<?php echo $Item?>"></label>
        <label class="flex">Item Desc.: <input type="text"  id="icomments" size="30" disabled value="<?php echo $headOI['EILID']?>"></label>
        <label class="flex">Order Comments: <input type="text"  id="ocomments" size="30" disabled value="<?php echo $headOI['EIPNT']?>"></label><br>
      -->
        <div  class="button-trackinginformation" id="button-main">
              <button type="submit" class="btn button-info button-next">Display <br> Tracking</button>
              <button type="button" class="btn button-info button-next"><a id="pdftraveler" href="" target="_blank">Display <br> Traveler</a></button>
             <button id="printpdf" type="button" class="btn button-info button-next">Print <br>Traveler</button>
        </div>
      </div>
  </form><br>
   
  <script src="../js/inquiryinformation.js"></script>
   <?php
  Foot();
}