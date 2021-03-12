<?php

/*************************************
 Read the Production per Machines from the Database
 Input the Time used per Machine from the Supervisor. 
**************************************/

function getTimeProduction() {
  $listMachines = getdailyProd();
  foreach( $listMachines as $Index => $Row ) {
    // $listMachines[$Index]['PRODUCTION'] =  dailyProduction( $objData, $Row['MACHINEID'] );
    echo $Row['MACHINEID'] + " PROD "+$listMachines[$Index]['PRODUCTION'];
  }

}

/*******************************************************
   View
   Get this Variable  $BarCode, $Machine, $Operator from Operator to be use
********************************************************/

function viewTrackingInquiry( $Operator, $Order ){
   // arguments ( $BarCode, $Machine, $Operator)
  $sColumn ='
          <div class="container text-center">
              <span class = "prodcolumn"><br>SQ Feet per Machine</span>
              <div class="row">
                   <div id="prodlist" class="prodlist col-12"></div>
              </div>
          </div>
  ';
  $Table ='
            <!--Grid row-->
            <div class="row">
           <!-- Table -->
           <!--Top Table UI-->
                <!--Card-->
                <div class="card  p-2 card-cascade narrower">
                    <!--Card content-->
                        <div class="card-body">
                           <div class="table-responsive">
                            <table class="table text-nowrap">
                                  <thead>
                                      <tr>
                                          <th>Machine</th>
                                          <th>QTY PRODUCED</th>
                                          <th>  HOURS  PER MACHINE  </th>
                                          <th>  TOTAL COST  </th>
                                      </tr>
                                    </thead>
                                  <tbody id = "dashboardrow">
                                     
                                  </tbody>
                              </table>
                            </div>
                            <hr class="my-0">
                        </div>
                        <!--/.Card content-->

                </div>
                <!--/.Card-->
              <!-- Table-->';

  $sBody =' 
        <section>
          <!-- Modal -->
          <div class="modal fade" id="endShiftModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header text-center">
                  <h5 class="modal-title" id="endShiftLabel">End of Shift</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                  </button>
                </div>

                  

                <div class="modal-body ml-5 text-center">
                  <form id="contact_form" action="ControllerInquiry.php" method="POST">
                    <input type="hidden" name="inquiry" value="TrackingInquiry">
                    <input type="hidden" name="linkbutton" value="sendemail"> 
                    <input type="hidden" name="Supervisor" value='.$Operator.'>
                    <label for="email">Enter the email address:</label>
                    <input type = "email" id = "email" name = "email">
                    '.$Table.'
                    <div class="modal-footer button-trackinginquiry ">
                         <button type="button" class="btn btn-inquiry button-next" data-dismiss="modal"> Close </button>
                         <button type="reset" id="printForm"  class="btn btn-inquiry button-next"> Reset </button>
                         <button type="submit" id="submitForm" formtarget="_blank" class="btn btn-inquiry button-next"> Print Report </button>
                    </div>
                  </form>
                </div>

                
                
              </div>
            </div>
          </div>
        </section>
        <form name="trackinginquiry"  action="ControllerInquiry.php" method="post" autocomplete="on">
        <input type="hidden" name="inquiry" value="TrackingInquiry"/>
        <!-- <input type="hidden" name="machine" id = "machine" value="<?php echo $Machine?>">
        -->
        <input type="hidden" name="operator" id = "operator" value= "' . $Operator . '"/>
        <input type="hidden" id="typeuser" name="typeuser" value="supervisor">
        <div class="trackinginquiry">
         <br><br><h3>Tracking Inquiry</h3><br>
          <!-- Order Number--> <!--
          <label class="label-inquiry" for="ordernumber">Order Number:</label>
          <input class="input-tracking" type="text" name= "ordernumber"  id="ordernumber"  value = "' . $Order . '" placeholder="Order Number/Line" autofocus><br> -->

          <!--  Bar Code -->
          <div class = " container row">
              <label class="label-inquiry" for="barcode">Order Number:</label>
              <input class="input-tracking" type="text" name= "barcode"  id="barcode" value = "' . $Order . '"  size = "20" placeholder="Bar Code/Line number" autofocus required >
             <label  for="assignment"> <input type="checkbox" id="assignment" name="assignment" value="N"> Assign location?</label>
             <label class = "location" for="location"><input type="text" id="location" name="location" size= "10" maxlength = "10" placeholder="Type Location" disabled ></label>
              
          </div>
          <br><br>
          <!-- Line Number--> <!--
          <label class="label-inquiry" for="linenumber">Line Number:</label>
          <input class="input-tracking" type="number" name = "linenumber" id="linenumber"  placeholder="Enter Line Number" required><br><br> -->
          <!-- Buttons-->
          <div class="button-trackinginquiry row">
              <div class ="col">
                <button type="button" id ="assignlocation" class="btn-inquiry btn button-reset">Assign Location</button>
              </div>
             <div class ="col">
                <button id="search"  type="submit" class="btn-inquiry btn button-next">Search order ...</button>
             </div>
              <div class ="col">
                <button  id = "reset" type="reset" class="btn-inquiry btn button-reset">Reset</button>
              </div>
                  <!-- Button trigger modal -->
                  <button id="btn-endshift" type="button" class="btn  btn-inquiry button-next" data-toggle="modal" data-target="#endShiftModal">End of Shift </button>
          </div>
        </div>
  </form>
  <br>
 <div class="container row text-center">
       <div class="col-md-2"></div>
       <div class="col-md-3">
         <div class="row">
            <div  id="startdate" class="col"></div>
         </div>
       </div>
       <div class="col-md-3">
         <div class="row">
            <div id="qty" class="col-4"></div>
            <div id="machine" class="col-8"></div>
         </div>
        </div>
       <div class="col-md-2">
        <div class="row">
           <div id="columnlocation" class="col-6"></div>
           <div id="grade"    class="col-6"></div>
        </div>
      </div>
      <div class="col-md-2"></div>
    </div>

  '  ;
  Head( $sBody, $sColumn );
  
  $newScript = '<script src="../js/trackinginquiry.js"></script>
                <script src="../js/showproduction.js"></script>
  ';
  Foot($newScript);
}