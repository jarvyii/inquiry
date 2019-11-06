<?php
function viewTrackingDisplay($OrderNumber, $LineNumber){

		Head();
	}
/*************************************************
Display the Header of the Tracking and the Column Header for the INformation
**************************************************/

function viewHead($OrderNumber, $LineNumber, $headOrder, $headOI) { ?>
      <input type="hidden" name="ordernumber" id = "ordernumber" value="<?php echo $OrderNumber?>"/>
      <input type="hidden" name="linenumber" id = "linenumber" value="<?php echo $LineNumber?>"/>
      <h3>Tracking Inquiry Display</h3><br>
      <label class="label-display flex">Order:</label>
      <input class="quantity" type="text" disabled value="<?php echo $OrderNumber?>"><br>
      <label class="label-display flex">Line Number:</label>
      <input class="quantity" type="text" disabled value="<?php echo $LineNumber?>"><br>
      <label class="label-display flex">Customer:</label>
      <input class="quantity"type="text" id="customer" disabled value="<?php echo $headOrder['EHCT#']?>"><br>
      <label class="label-display flex">Order Date:</label>
      <input class="quantity"type="text" id="orderdate" disabled value="<?php echo $headOrder['EHORDT']?>"><br>
      <label class="label-display flex">Quantity:</label>
      <input class="quantity"type="text" id="quantity" disabled value="<?php echo $headOI['EIOCQ']?>" ><br>
      <label class="label-display flex">Item:</label>
      <input class="quantity"type="text" id="item" disabled value="<?php echo $headOI['EIPN']?>" ><br>

      <div class="container row text-center">
       <div class="col-md-4">
         <div class="row">
             <div  id="machinecolumn" class="col-6">
                 <label class="displaycolumn">Machine</label><br>
              </div>
            <div id="operator" class="col-6">
                <label class="displaycolumn">Operator</label><br>
            </div>
         </div>
       </div>
       <div class="col-md-4">
         <div class="row">
            <div id="qty" class="col-6">
                <label class="displaycolumn">Quantity</label><br>
            </div>
            <div id="startdate" class="col-6">
                 <label class="displaycolumn">Start Date/Time</label><br>
            </div>
          </div>
        </div>
     <div class="col-md-4">
        <div class="row">
           <div id="stopdate" class="col-6">
               <label class="displaycolumn">Stop Date/Time</label><br>
           </div>
           <div id="elapsedtime" class="col-6">
               <label class="displaycolumn">Elapsed Time</label><br>
           </div>
         </div>
       </div>
    </div>
    <label></label><br>
    <?php
    Foot();?>
		    <script src="../js/inquirydisplay.js"></script>
		<?php

   }

?>