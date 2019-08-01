$(document).ready(function(){

  /**************************************************************
 Read Order Number Info from the JSON File
 FUNCTION setTimesheetHead()
***************************************************************/
function readOrderNumber(){
      /* SETUP.JSON  Structure Example
       { "Company":"Code-Louisville Training",
         "activePeriod": "18001",
         "Logo":"img/codelouisville.jpg",
         "Web":"www.codelouisville.org"
       }       */
    var jsonURL ="../data/ehm.json";
    var usersFormat ={
                      format: "json"
                     };
      // /FUNCTION getHead()
     function getHead(data) {
       $.each(data,function(i, Order) {
         /*
         alert(Order.EHORD);
         alert(Order.EHORDT);*/
            /*
                document.getElementById("user-nav").innerHTML=Setup.Company;
                document.getElementById("user-nav").href= Setup.Web;
                document.getElementById("image-exit-nav").src= "img/exit.png";
                document.getElementById("idPeriod").value = Setup.activePeriod;
            */
                //alert(document.getElementById("idPeriod").value);
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
  function setOrderHeader(){
     //Add the Number of the Order input type='Number'
     //Add the Order Value
    function addOrderHeader(Data){
      var p = document.createElement("LABEL");
      var t = document.createTextNode(Data.label);
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
             ];
    //addOrderValue(Value);
     Value.forEach(addOrderHeader);
  } // \FUNCTION setOrderHeader()
  /************************************************************************
  Main Block
***********************************************************************/
setOrderHeader();
}); // End ready
