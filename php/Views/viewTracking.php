<?php
//require_once 'Views/viewInquiry.php';
/**************************************************************
    Form  bodyTracking($UserName)
**************************************************************/
function  viewTracking($UserName, $selectIndex,  $Production){ 
 
    
  $sBody = '
  <form name="tracking"  action="ControllerInquiry.php" method="post" autocomplete="on">
        <input type="hidden" name="inquiry" value="Tracking"/>
        <input type="hidden" name="operator" id = "operator" value="'. $UserName. '"/>
        <input type="hidden" id="typeuser" name="typeuser" value="operator"/>
        <input type="hidden" id="selectindex" name="selectindex" value="'. $selectIndex. '"/>
        <div class="tracking">
         <div class ="info row container">
          <div class="trackingheader">
              <h5 class="showuser">User:'. $UserName. '</h5><br>
              <h3>Tracking</h3><br>
              <!--  Bar Code -->
              <label class="label-tracking" for="barcode">Order No.:</label>
              <input class="input-tracking" type="text" name= "barcode"  id="barcode" size = "20" placeholder="Scan Bar Code" autofocus required><br>
              <!-- Dynamic List of Machine -->
              <label class="label-tracking" for="machine">Machine:</label>
              <select name="machine" id="machine" required  onchange="myProduction()">
              </select><br> 
              <div id ="panelselect">
                  <label class="label-tracking"  for="panel">Panel:
                    <select name="panel" id="panel" required>
                        <option value="F">Face Grade</option>
                        <option value="B">Back Grade</option>
                    </select> 
                  </label><br> 
              </div>

        </div> 
      </div>
          <div class="container row button-tracking">
            <div class="col">
                <button type="submit" id="produce" class="btn-tracking btn button-next"> Produce </button>
                 <button type="button" id="travelerbutton"class="btn-tracking btn button-info button-next"><a id="pdftraveler" href="" target="_blank">Display <br> Traveler</a></button>
                 <button type="reset" class="btn-tracking btn button-reset">Reset</button>
            </div>
            
          </div>
        </div>
  </form>';
  $sColumn = '
         <div class="produced  p-3 my-3 border  mx-auto mw-100 shadow">
              <h4 class ="button-reset"> Total SQ Feet </h4>
              <div class="align-middle  font-weight-bold">
               <h1 id= "prod" class = "text-body ">'. $Production. '</h1>
              </div>
         </div>';
  Head($sBody, $sColumn);
  $newScript = '<script src="../js/operator.js"></script>
                <script src="../js/tracking.js"></script> ';
  Foot($newScript);
}