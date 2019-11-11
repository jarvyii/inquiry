$(document).ready(function(){

  /**************************************************************
 Read Order Number Info from the JSON File
 FUNCTION setOrderHeader()
***************************************************************/
function setOrderHeader( ){
  /********************************************************  

    =====>  This is for JavaScript

              Query to access the data in JSON Format
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
                           document.getElementById("customer").value =Order["EHCT#"];
                           document.getElementById("orderdate").value =Order["EHORDT"];
                           return false;
                        })
                    }  //  \FUNCTION getHead()

                        $.getJSON(jsonURL, usersFormat,  getHead );
     ******************************************/

     /*************************************

       ====> This is for PHP

         
      if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getuser.php?q="+str,true);
        xmlhttp.send();

             return false;
       ****************************************************/
   }   // \FUNCTION setOrderHeader()

   /**************************************************************
   Read Order  Info from the JSON File EIM.JSON
   FUNCTION setOrderHeader2()
   ***************************************************************/
   function setOrderHeader2( ){
     var jsonURL ="../data/eim.json";
     var usersFormat ={
                       format: "json"
                      };
       // /FUNCTION getHead()
      function getHead(Data) {
           $.each(Data,function(i, Order) {
                if (document.getElementById("ordernumber").value !=Order["EIORD"]){
                   // Return until find the correct order number
                  return false;
                 }
                 document.getElementById("quantity").value = Order["EIOCQ"];
                document.getElementById("item").value = Order["EIPN"];
                return false;
             })
         }  //  \FUNCTION getHead()
         $.getJSON(jsonURL, usersFormat,  getHead );

     return false;
   }   // \FUNCTION setOrderHeader2()

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
               document.getElementById("machinecolumn").appendChild(inputMachine);
               var p = document.createElement("BR");
               document.getElementById("machinecolumn").appendChild(p);

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

function  showHistoric(){
               
          if (window.XMLHttpRequest) {
               xmlhttp = new XMLHttpRequest();
            }else {
               xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
               if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                 // document.getElementById("output").innerHTML = xmlhttp.responseText;
                 myObj = JSON.parse(this.responseText);
                 txtLHMACH=txtLHOPER = txtLHQTY=txtLHSTRDTTIM=txtElapsedTime= txtLHSTPDTTIM="";
                 for (x in myObj) {
                      txtLHMACH += myObj[x].MACHDESC + "<br>";
                      txtLHOPER += myObj[x].LHOPER+ "<br>";
                      txtLHQTY += myObj[x].LHQTY+ "<br>";
                      txtLHSTRDTTIM += myObj[x].LHSTRDTTIM.substr(0,16)+ "<br>";
                      txtLHSTPDTTIM += myObj[x].LHSTPDTTIM.substr(0,16)+ "<br>";
                      s= myObj[x].LHSTRDTTIM;
                      var startDate = new Date(s.substr(0,10)+" "+s.substr(11,2)+":"+s.substr(14,2)+":"+s.substr(17,2));
                      s= myObj[x].LHSTPDTTIM;
                      var stopDate = new Date(s.substr(0,10)+" "+s.substr(11,2)+":"+s.substr(14,2)+":"+s.substr(17,2));
                     // var elapsedtime = (stopDate.getTime() - startDate.getTime())/(1000*60*60*24);
                     var Days = Math.round(((stopDate.getTime() - startDate.getTime())/1000)/60/60/24);
                     var Hours = Math.round(((stopDate.getTime() - startDate.getTime())/1000)/60/60);
                     var Minutes = Math.round(((stopDate.getTime() - startDate.getTime())/1000)/60);
                      var elapsedtime = Days+"d:"+Hours+"h:"+Minutes+"m";
                      txtElapsedTime += elapsedtime+ "<br>";

                      
                  }
                 document.getElementById("machinecolumn").innerHTML += txtLHMACH;
                document.getElementById("operator").innerHTML += txtLHOPER;
                document.getElementById("qty").innerHTML += txtLHQTY;
                document.getElementById("startdate").innerHTML += txtLHSTRDTTIM;
                document.getElementById("stopdate").innerHTML += txtLHSTPDTTIM;
                document.getElementById("elapsedtime").innerHTML += txtElapsedTime;
                // alert( myObj);
                 /*
                 console.log('My object : ' + Values);
                 var output = '';
                  for (var property in Values) {
                      output += property + ': ' + Values[property]+'; ';
                    }
                  alert(output);*/
               }
            }
            str = "Display&order="+document.getElementById("ordernumber").value;
            xmlhttp.open("GET","../php/ControllerInquiry.php?q="+str,true);
            xmlhttp.send();
}

  /*********************************************************************************
  Write in the DOM the Content of Number of  Order
  FUNCTION setOrderHeader().
  *********************************************************************************/
  function displayOrder(){
   //  setOrderHeader();
    // setOrderHeader2();
     //setOrderBody();
     showHistoric();
      //addOrderValue(Value);
    // Value.forEach(addOrderHeader);
  } // \FUNCTION setOrderHeader()
  /************************************************************************
  Main Block
***********************************************************************/

displayOrder();
}); // End ready
