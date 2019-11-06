<?php
//require_once 'Views/viewInquiry.php';
/**************************************************************
    Form  bodyTracking($UserName)
**************************************************************/
function  viewTracking($UserName){ 
   Head();
    ?>

  <form name="tracking"  action="ControllerInquiry.php" method="post" autocomplete="on">
        <input type="hidden" name="inquiry" value="Tracking"/>
        <input type="hidden" name="operator" id = "operator" value="<?php echo $UserName?>"/>
        <div class="tracking">
        <div class="tracking">
          <h5 class="showuser">User: <?php echo $UserName?></h5><br>
          <h3>Tracking</h3><br>
          <!--  Bar Code -->
          <label class="label-tracking" for="barcode">Scan Bar Code:</label>
          <input class="input-tracking" type="text" name= "barcode"  id="barcode" size = "15" placeholder="Bar Code" autofocus><br>
          <!-- Dynamic List of Machine -->
          <label class="label-tracking" for="machine">Machine:</label>
          <select name="machine" id="machine" required>
          </select><br> 
          <!-- To Introduce Operator Info
          <label class="label-tracking" for="operator">Operator:</label>
          <input class="input-tracking" type="text" name = "operator" id="operator" size ="15" placeholder="Operator" required><br>
        -->
          <div class="row button-tracking">
            <div class="col">
                <button type="submit" class="btn button-next">Next</button>
            </div>
            <div class="col">
              <button type="reset" class="btn button-reset">Reset</button>
            </div>
          </div>
        </div>
  </form>
  <?php
  Foot();
}