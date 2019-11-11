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
        <div class="tracking">
          <h3>Tracking Inquiry</h3><br>
          <!-- Order Number-->
          <label class="label-inquiry" for="ordernumber">Order Number:</label>
          <input class="input-tracking" type="text" name= "ordernumber"  id="ordernumber" placeholder="Enter Order Number" autofocus><br>
          <!-- Line Number-->
          <label class="label-inquiry" for="linenumber">Line Number:</label>
          <input class="input-tracking" type="number" name = "linenumber" id="linenumber"  placeholder="Enter Line Number" required><br>
          <!-- Buttons-->
          <div class="button-tracking row">
             <div class ="col">
                <button type="submit" class="btn button-next">Next</button>
             </div>
              <div class ="col">
                <button type="reset" class="btn button-reset">Reset</button>
              </div>
          </div>
        </div>
  </form> <?php
  Foot();
}