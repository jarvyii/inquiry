$(document).ready(function(){

    function  showHistoric(){
               
          if (window.XMLHttpRequest) {
               xmlhttp = new XMLHttpRequest();
            }else {
               xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
               if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                 // document.getElementById("output").innerHTML = xmlhttp.responseText;
                 sLabel = "<span class="; // beginning of the span
                 sTitle ="'displaycolumn'>"; //Name of the class for the column Title
                 gContent ="'grillecolumn'>"; // Name of the Class for grille conetnt
                 eLabel = "<br></span>";  // closing SPAN Tag
                 myObj = JSON.parse(this.responseText);
                 txtLHMACH=sLabel+ sTitle+"Machine"+eLabel+sLabel+gContent;
                 txtLHOPER = sLabel+sTitle+"Operator"+eLabel+sLabel+gContent;
                 txtLHQTY=sLabel+sTitle+"Qty."+eLabel+sLabel+gContent;
                 //"<span class="+"'displaycolumn'"+">Quantity</span><br>"; 
                 txtLHSTRDTTIM=sLabel+sTitle+"Start Time"+eLabel+sLabel+gContent;
                 txtElapsedTime= sLabel+sTitle+"E. Time"+eLabel+sLabel+gContent;
                 txtLHSTPDTTIM=sLabel+sTitle+"Stop Time"+eLabel+sLabel+gContent;
                 txtLHSOVR =sLabel+sTitle+"Override"+eLabel+sLabel+gContent;
                txtLHCOMM = sLabel+sTitle+"Comments"+eLabel+sLabel+gContent;
                 for (x in myObj) {
                      txtLHMACH += myObj[x].MACHDESC + "<br>";
                      txtLHOPER += myObj[x].LHOPER+ "<br>";
                      txtLHQTY += myObj[x].LHQTY+ "<br>";
                      txtLHSTRDTTIM += myObj[x].LHSTRDTTIM.substr(0,19)+ "<br>";
                      txtLHSTPDTTIM += myObj[x].LHSTPDTTIM.substr(0,19)+ "<br>";
                      txtLHSOVR += myObj[x].LHSOVR+ "<br>";
                      txtLHCOMM += myObj[x].LHCOMM+ "<br>";
                      s= myObj[x].LHSTRDTTIM;
                      var startDate = new Date(s.substr(0,10)+" "+s.substr(11,2)+":"+s.substr(14,2)+":"+s.substr(17,2));
                      s= myObj[x].LHSTPDTTIM;
                      var stopDate = new Date(s.substr(0,10)+" "+s.substr(11,2)+":"+s.substr(14,2)+":"+s.substr(17,2));
                     // var elapsedtime = (stopDate.getTime() - startDate.getTime())/(1000*60*60*24);
                     //var Days = Math.round(((stopDate.getTime() - startDate.getTime())/1000)/60/60/24);
                     var Hours = Math.round(((stopDate.getTime() - startDate.getTime())/1000)/60/60);
                     var Minutes = Math.round(((stopDate.getTime() - startDate.getTime())/1000)/60);
                     var Seconds = Math.trunc( Math.round(((stopDate.getTime() - startDate.getTime())/1000)) % 60);
                     var elapsedtime = Hours+"h:"+Minutes+"m:"+Seconds+"s";
                     txtElapsedTime += elapsedtime+ "<br>";

                      
                  }
                 document.getElementById("machinecolumn").innerHTML += txtLHMACH+ eLabel;
                document.getElementById("operator").innerHTML += txtLHOPER+ eLabel;
                document.getElementById("qty").innerHTML += txtLHQTY+ eLabel;
                document.getElementById("startdate").innerHTML += txtLHSTRDTTIM+ eLabel;
                document.getElementById("stopdate").innerHTML += txtLHSTPDTTIM+ eLabel;
                document.getElementById("elapsedtime").innerHTML += txtElapsedTime+ eLabel;
                document.getElementById("override").innerHTML += txtLHSOVR+ eLabel;
                document.getElementById("comment").innerHTML += txtLHCOMM+ eLabel;
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
            var Order = document.getElementById("ordernumber").value;
            Order = Order+"&line="+ document.getElementById("linenumber").value;
            
         //  var str = "http:../php/ControllerInquiry.php?q=Display&order="+Order;
           //var url = new URL(str);
           xmlhttp.open("GET","../php/ControllerInquiry.php?q=Display&order="+Order,true);
       //   xmlhttp.open("GET",url,true);
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
