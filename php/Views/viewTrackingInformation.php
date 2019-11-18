<?php
/**************************************
Display the Tracking Information
***************************************/
function viewTrackingInformation($OrderNumber, $LineNumber, $Operator, $headOrder, $headOI) {
   Head(); 
   ?>
   <div class="trackinginformation">
      <form name="trackinginformation"  action="ControllerInquiry.php" method="post" autocomplete="on">
        <input type="hidden" name="inquiry" value="TrackingInformation">
        <input type="hidden" name="ordernumber" id = "ordernumber" value="<?php echo $OrderNumber?>">
        <input type="hidden" name="linenumber" id = "linenumber" value="<?php echo $LineNumber?>">
        <input type="hidden" id="typeuser" name="typeuser" value="supervisor"/>
        <h3>Tracking Information</h3><br>
        <label class="label-information flex">Order/Line Number:</label>
        <input class="quantity" type="text" disabled value="<?php echo $OrderNumber, " / ", $LineNumber?>"><br>
        <label class="label-information flex">Operator:</label>
        <input class="quantity" type="text" disabled value="<?php echo $Operator?>"><br>
        <label class="label-information flex">Customer:</label>
        <input class="quantity" type="text" id="input-customer" disabled value="<?php echo $headOrder['EHCT#']?>"><br>
        <label class="label-information flex">Order date:</label>
        <input class="quantity" type="text" id="input-orderdate" disabled value="<?php echo $headOrder['EHORDT']?>"><br>
        <div class="datecolumn">
            <label class="label-information flex">Order Qty:</label>
            <input class="quantity" type="text" id="input-orderqty" disabled value="<?php echo $headOI['EIOCQ']?>">
        </div>
        <div class="datecolumn">
             <label class="label-information flex" for="input-ordercmpted" >Qty Completed:</label>
            <input class="quantity" type="text" id="input-ordercmpted" disabled value="<?php echo $headOI['EICCQ']?>">
        </div>
        <div class="datecolumn">
            <label class="label-information flex">Qty Needed:</label>
            <input class="quantity" type="text" id="input-orderneeded" disabled>
        </div>
        <br>
        <label class="label-information flex">Item:</label>
        <input class="quantity" type="text" id="input-item" disabled value="<?php echo $headOI['EIPN']?>"><br>
        <label class="label-information flex">Line Item Comments:</label>
        <input class="quantity" type="text"  id="icomments" size="30" disabled value="<?php echo $headOI['EILID']?>"><br>
        <label class="label-information flex">Order Comments:</label>
        <input class="quantity" type="text"  id="ocomments" size="30" disabled value="<?php echo $headOI['EIPNT']?>"><br>
        <div  class="button-tracking " id="button-main">
              <button type="submit" class="btn button-info button-next">Display <br> Tracking</button>
              <button type="button" class="btn button-info button-next"><a id="pdftraveler" href="" target="_blank">Display <br> Traveler</a></button>
             <button id="printpdf" type="button" class="btn button-info button-next">Print <br>Traveler</button>
        </div>
    </form>
       
    <?php
    // tiBody();
   ?>

  </div>
  <script src="../js/inquiryinformation.js"></script>
   <?php
  Foot();
}