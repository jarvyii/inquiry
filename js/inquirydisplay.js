$(document).ready(function(){

  /**************************************************************
 Read Order Number Info from the JSON File
 FUNCTION setTimesheetHead()
***************************************************************/
function readOrderNumber( ){
    var jsonURL ="../data/ehm.json";
    var usersFormat ={
                      format: "json"
                     };
      // /FUNCTION getHead()
     function getHead(Data) {
          $.each(Data,function(i, Order) {
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
                  inputLineN.setAttribute("value", "4");// Need be fixed
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

  /*********************************************************************************
  Write in the DOM the Content of Number of  Order
  FUNCTION setOrderHeader().
  *********************************************************************************/
  function setOrderHeader( orderNumber){
     //Add the Number of the Order input type='Number'
     //Add the Order Value
    function addOrderHeader(Data){
      var p = document.createElement("LABEL");
      var t = document.createTextNode(Data[0]);
      p.setAttribute("for", "male");
      p.appendChild(t);
      //document.getElementById("myForm").insertBefore(x,document.getElementById("male"));
      document.getElementById("tracking-label").appendChild(p);
      var p = document.createElement("BR");
      document.getElementById("tracking-label").appendChild(p);
      // Insert the Content
      var p = document.createElement("INPUT");
      p.style.margin =0;
      p.setAttribute("type", "text");
      p.setAttribute("value", Data.value);
      p.disabled = true;//"label-order"
      document.getElementById("tracking-value").appendChild(p);
      // Insert Break Line
      var p = document.createElement("BR");
      document.getElementById("tracking-value").appendChild(p);

    } // \FUNCTION addDescrption()
    // document.getElementById("label-order").innerHTML =" Order number: ";
     readOrderNumber();
     /*
     Value = [
              { label : "Order Number :",
                  value: "256895564-25"
              },
              { label :"Line Number :",
                  value: 12
              },
              { label :"Customer :",
                  value: 12
              },
              { label :"Order Date :",
                  value: "1180511"
              },
              { label :"Order Qty :",
                  value: 5
              }
            ]; */
    readOrderNumber( orderNumber);
    //addOrderValue(Value);
    // Value.forEach(addOrderHeader);
  } // \FUNCTION setOrderHeader()
  /************************************************************************
  Main Block
***********************************************************************/

readOrderNumber();
}); // End ready
