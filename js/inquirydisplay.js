$(document).ready(function(){

  /**************************************************************
 Read Order Number Info from the JSON File
 FUNCTION setTimesheetHead()
***************************************************************/
function setOrderHeader( ){
    var jsonURL ="../data/ehm.json";
    var usersFormat ={
                      format: "json"
                     };
      // /FUNCTION getHead()
     function getHead(Data) {
          $.each(Data,function(i, Order) {
               if (document.getElementById("ordernumber").value !=Order["EHORD"]){
                  // Return until find the correct order number
                 return false;
                }
               var labelOrder = document.createElement("LABEL");
               var inputOrder = document.createElement("INPUT");
               var breakLine = document.createElement("BR");
               //Order Number
               var t = document.createTextNode("Order Number :");
                   //p.setAttribute("for", "male");
                   labelOrder.appendChild(t);
                   document.getElementById("tracking-label").appendChild(labelOrder);
                   document.getElementById("tracking-label").appendChild(breakLine);
                   //Value
                   inputOrder.style.margin =0;
                   inputOrder.setAttribute("type", "text");
                   inputOrder.setAttribute("value", Order["EHORD"]);
                   inputOrder.disabled = true;
                   document.getElementById("tracking-value").appendChild(inputOrder);
                   // Insert Break Line
                   var p = document.createElement("BR");
                   document.getElementById("tracking-value").appendChild(p);
                   // Line Number
                  t = document.createTextNode("Line Number :");
                  var labelLineN= document.createElement("LABEL"); //Label Line Number
                  labelLineN.appendChild(t);
                  document.getElementById("tracking-label").appendChild(labelLineN);
                  var p = document.createElement("BR");
                  document.getElementById("tracking-label").appendChild(p);

                  var inputLineN= document.createElement("INPUT"); // Value Line Number
                  inputLineN.style.margin =0;
                  inputLineN.setAttribute("type", "text");
                  lineNumber = document.getElementById("linenumber").value
                  inputLineN.setAttribute("value", lineNumber);// Need be fixed
                  inputLineN.disabled = true;
                  document.getElementById("tracking-value").appendChild(inputLineN);
                  // Insert Break Line
                  var p = document.createElement("BR");
                  document.getElementById("tracking-value").appendChild(p);

                 //Customer Rows
                 t = document.createTextNode("Customer :");
                 var labelCustomer= document.createElement("LABEL"); //Label Customer
                 labelCustomer.appendChild(t);
                 document.getElementById("tracking-label").appendChild(labelCustomer);
                 var p = document.createElement("BR");
                 document.getElementById("tracking-label").appendChild(p);

                 var inputCustomer= document.createElement("INPUT"); // Value Line Number
                 inputCustomer.style.margin =0;
                 inputCustomer.setAttribute("type", "text");
                 inputCustomer.setAttribute("value", Order["EHCT#"]);
                 inputCustomer.disabled = true;
                 document.getElementById("tracking-value").appendChild(inputCustomer);
                 // Insert Break Line
                 var p = document.createElement("BR");
                 document.getElementById("tracking-value").appendChild(p);
                //Order Date Rows
                t = document.createTextNode("Order Date :");
                var labelDate= document.createElement("LABEL"); //Label Customer
                labelDate.appendChild(t);
                labelDate.style.textAlign ="right";
                document.getElementById("tracking-label").appendChild(labelDate);
                document.getElementById("tracking-label").appendChild(breakLine);

                var inputDate= document.createElement("INPUT"); // Value Line Number
                //inputDate.style.margin =0;
                inputDate.setAttribute("type", "text");
                inputDate.setAttribute("value", Order["EHORDT"]);
                inputDate.disabled = true;
                document.getElementById("tracking-value").appendChild(inputDate);
                // Insert Break Line
               document.getElementById("tracking-value").appendChild(breakLine);
               //Quantity Rows
               t = document.createTextNode("  Quantity :");
               var labelQty= document.createElement("LABEL"); //Label Customer
               labelQty.style.margin ="0px 10px 0px 30px";
               labelQty.appendChild(t);
               document.getElementById("tracking-value").appendChild(labelQty);

               var inputQty= document.createElement("INPUT"); // Value Line Number
               //inputDate.style.margin =0;
               inputQty.setAttribute("type", "text");
               inputQty.setAttribute("value", "5"); // Need be fixed
               inputQty.disabled = true;
               document.getElementById("tracking-value").appendChild(inputQty);
               // Insert Break Line
              document.getElementById("tracking-value").appendChild(breakLine);
              return false;
            })
        }  //  \FUNCTION getHead()

      $.getJSON(jsonURL, usersFormat,  getHead );

      return false;
   }   // \FUNCTION setOrderHeader()
  /********************************
      Set the Body  Content of the order
  ************************************/
  function setOrderBody(){
    var jsonURL ="../data/fmlochist.json";
    var usersFormat ={
                      format: "json"
                     };
      // /FUNCTION getHead()
     function getBody(Data) {
          $.each(Data,function(i, Order) {
            if (document.getElementById("ordernumber").value !=Order["LHORD"]){
                  // Return until find the correct order number
                 return false;
               }
               var inputMachine = document.createElement("INPUT");
               //inputDate.style.margin =0;
               inputMachine.setAttribute("type", "text");
               inputMachine.setAttribute("value", Order["LHMACH"]);
               inputMachine.disabled = true;
               document.getElementById("machine").appendChild(inputMachine);
               var p = document.createElement("BR");
               document.getElementById("machine").appendChild(p);

               //operator
               var inputOperator = document.createElement("INPUT");
               inputOperator.setAttribute("type", "text");
               inputOperator.setAttribute("value", Order["LHOPER"]);
               inputOperator.disabled = true;
               document.getElementById("operator").appendChild(inputOperator);
               // Quantity
               var inputQty = document.createElement("INPUT");
               inputQty.setAttribute("type", "text");
               inputQty.setAttribute("value", Order["LHQTY"]);
               inputQty.disabled = true;
               document.getElementById("qty").appendChild(inputQty);
               // Start Date/setTimeout(function () {
               var inputDate = document.createElement("INPUT");
               inputDate.setAttribute("type", "text");
               inputDate.setAttribute("value", Order["LHSTRDTTIM"]);
               inputDate.disabled = true;
               document.getElementById("startdate").appendChild(inputDate);
               // Stop Date/Time
               var inputStopDate = document.createElement("INPUT");
               inputStopDate.setAttribute("type", "text");
               inputStopDate.setAttribute("value", Order["LHSTPDTTIM"]);
               inputStopDate.disabled = true;
               document.getElementById("stopdate").appendChild(inputStopDate);
               // Elapsed setTimeout(function () {
               var inputElapsedTime = document.createElement("INPUT");
               inputElapsedTime.setAttribute("type", "text");
               strDate =""+Order["LHSTPDTTIM"];
               var d1 = new Date(Order["LHSTPDTTIM"].substring(0,10));
               s = Order["LHSTPDTTIM"];
               var d = new Date(s.substr(0,10)+" "+s.substr(11,2)+":"+s.substr(14,2)+":"+s.substr(17,2));
               d = " ";
               inputElapsedTime.setAttribute("value", d);
               inputElapsedTime.disabled = true;
               document.getElementById("elapsedtime").appendChild(inputElapsedTime);

               // Insert Break Line
              //document.getElementById("machine").appendChild(breakLine);
              //return false;

            })

        }  //  \FUNCTION getHead()
      $.getJSON(jsonURL, usersFormat,  getBody );

      return false;
  } // / function setOrderBody()

  /*********************************************************************************
  Write in the DOM the Content of Number of  Order
  FUNCTION setOrderHeader().
  *********************************************************************************/
  function displayOrder(){
     setOrderHeader();
     setOrderBody();
      //addOrderValue(Value);
    // Value.forEach(addOrderHeader);
  } // \FUNCTION setOrderHeader()
  /************************************************************************
  Main Block
***********************************************************************/

displayOrder();
}); // End ready
