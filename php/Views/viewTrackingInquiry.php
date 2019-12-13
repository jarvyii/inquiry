<?php
/*******************************************************
   View
   Get this Variable  $BarCode, $Machine, $Operator from Operator to be use
********************************************************/
function viewTrackingInquiry( $Operator){
   // arguments ( $BarCode, $Machine, $Operator)
  Head();
  ?>
  <form name="trackinginquiry"  action="ControllerInquiry.php" method="post" autocomplete="on">
        <input type="hidden" name="inquiry" value="TrackingInquiry"/>
        <!-- <input type="hidden" name="machine" id = "machine" value="<?php echo $Machine?>"/>
        -->
        <input type="hidden" name="operator" id = "operator" value="<?php echo $Operator?>"/>
        <input type="hidden" id="typeuser" name="typeuser" value="supervisor"/>
        <div class="trackinginquiry">
         <br><br><h3>Tracking Inquiry</h3><br>
          <!-- Order Number--> <!--
          <label class="label-inquiry" for="ordernumber">Order Number:</label>
          <input class="input-tracking" type="text" name= "ordernumber"  id="ordernumber" placeholder="Order Number/Line" autofocus><br> -->

          <!--  Bar Code -->
          <label class="label-inquiry" for="barcode">Order Number:</label>
          <input class="input-tracking" type="text" name= "barcode"  id="barcode" size = "15" placeholder="Bar Code/Line number" autofocus required ><br><br>

          <!-- Line Number--> <!--
          <label class="label-inquiry" for="linenumber">Line Number:</label>
          <input class="input-tracking" type="number" name = "linenumber" id="linenumber"  placeholder="Enter Line Number" required><br><br> -->
          <!-- Buttons-->
          <div class="button-trackinginquiry row">
             <div class ="col">
                <button id="search"  type="submit" class="btn button-next">Search</button>
             </div>
              <div class ="col">
                <button type="reset" class="btn button-reset">Reset</button>
              </div>
          </div>
        </div>
  </form> <?php
  $newScript = '<script src="../js/trackinginquiry.js"></script>';
  Foot($newScript);
}