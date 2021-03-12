<?php
/**************************************
Display the Tracking Information
***************************************/
function viewTrackingInformation($OrderNumber, $LineNumber, $Operator,$orderQty, $headOrder, $headOI) {
  
   $d =$headOrder['EHORDT'];
   $orderDate = substr($d, 3,2)."/".substr($d, 5,2)."/".substr($d, 1,2);
   $Customer = $headOrder['EHCT#'];
   $Item = $headOI['EIPN'];
   $ItemDesc = $headOI['EILID'];
   $OrderComm = $headOI['EIPNT'];
   $sBody = '
    <form name="trackinginformation"  action="ControllerInquiry.php" method="post" autocomplete="on">
      <div class="trackinginformation">
        <input type="hidden" name="inquiry" value="TrackingInformation">
        <input type="hidden" name="ordernumber" id = "ordernumber" value="'.$OrderNumber. '">
        <input type="hidden" name="linenumber" id="linenumber" value="'.$LineNumber.'">
        <input type="hidden" name="customer"   id="customer" value="'.$Customer.'">
        <input type="hidden" name="orderdate"  id="orderdate" value="'.$orderDate.'">
        <input type="hidden" name="orderqtty"   id="orderqtty"  value="'.$orderQty.'">
        <input type="hidden" name="item"       id="item"      value="'.$Item.'">
        <input type="hidden" id="typeuser" name="typeuser" value="supervisor"/>
        <input type="hidden" name="operator"   id="operator"  value="'.$Operator.'">
        <h3>Tracking Information</h3><br>
          <label class="label-tracking" for="barcode">Order No.: <span class="label-content">'.$OrderNumber.'/'.$LineNumber.'</span></label>
          <label class="label-tracking">Customer: <span class="label-content">'.$Customer.'</span></label>
          <label class="label-tracking">Order date: <span class="label-content">'.$orderDate.'</span></label>
          <label class="label-tracking">Order Qty: <span class="label-content">'.$orderQty.'</span></label>
          <label class="label-tracking">Item: <span class="label-content">'.$Item.'</span></label>
          <label class="label-tracking">Item Desc.: <span class="label-content">'. $ItemDesc.'</span></label>
          <label class="label-tracking">Order Comments: <span class="label-content">'.$OrderComm.'</span></label>
          <div  class="button-trackinginformation" id="button-main">
              <button type="submit" name = "linkbutton" value="home" class="btn-information btn button-info button-next">
              <img class="img-responsive  img-fluid mx-auto logo d-block" width="30%" height="30%" src="../img/home.png"  alt="Init">
              Home</button>
              <button type="submit" name = "linkbutton" value="display" class="btn-information btn button-info button-next">Display <br> Tracking</button>
              <button type="button" class="btn button-info button-next"><a id="pdftraveler" href="" target="_blank">Display <br> Traveler</a></button>
              <button id="printpdf" type="button" class="btn-information btn button-info button-next">Print <br>Traveler</button>
          </div>
      </div>
  </form><br>
   
  <script src="../js/inquiryinformation.js"></script> ';

   $sColumn ='
          <div class="container text-center">
              <span class = "prodcolumn"><br>SQ Feet per Machine</span>
              <div class="row">
                   <div id="prodlist" class="prodlist col-12"></div>
              </div>
          </div>
  ';
  Head($sBody, $sColumn); 
  $newScript = '<script src="../js/showproduction.js"></script>';
  Foot( $newScript);
}