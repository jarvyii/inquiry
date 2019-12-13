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
         <input type="hidden" id="typeuser" name="typeuser" value="operator"/>
        <div class="tracking">
          <div class="trackingheader">
              <h5 class="showuser">User: <?php echo $UserName?></h5><br>
              <h3>Tracking</h3><br>
              <!--  Bar Code -->
              <label class="label-tracking" for="barcode">Order No.:</label>
              <input class="input-tracking" type="text" name= "barcode"  id="barcode" size = "15" placeholder="Scan Bar Code" autofocus required><br>
              <!-- Dynamic List of Machine -->
              <label class="label-tracking" for="machine">Machine:</label>
              <select name="machine" id="machine" required>
              </select><br> 
        </div> 
          <!-- To Introduce Operator Info
          <label class="label-tracking" for="operator">Operator:</label>
          <input class="input-tracking" type="text" name = "operator" id="operator" size ="15" placeholder="Operator" required><br>
        -->
          <div class="container row button-tracking">
            <div class="col">
                <button type="submit" id="produce" class="btn button-next"> Produce </button>
                 <button type="button" id="travelerbutton"class="btn button-info button-next"><a id="pdftraveler" href="" target="_blank">Display <br> Traveler</a></button>
                 <button type="reset" class="btn button-reset">Reset</button>
            </div>
            
          </div>
        </div>
  </form>
  <?php
  $newScript = '<script src="../js/operator.js"></script>';
  Foot($newScript);
}