$(document).ready(function(){
  
 function activeButton (){
       document.getElementById("search").disabled =false;

  }
/**************************************************************
      checkOrder()
  Search for the order and Line number, if the order don't 
  exist don't allow to produce the ITEM.
  in othercase the operator can produce it.
****************************************************************/
 function checkOrder(){
     Barcode = document.getElementById("barcode").value;
     if (Barcode == ""){
         alert("Sorry. The order number can not be empty.");
      return;
     }
     Pos = Barcode.indexOf("/");
     if (Pos == -1 ) {
       alert("Sorry. The order number: "+ document.getElementById("barcode").value+ " needs the / and the Line number.");
      return;
     }
     Order= Barcode.substr(0, Pos);
     LineNumber =  Barcode.substr(Pos+1);
     if (LineNumber ==""){
         alert("Sorry. The order number: "+ document.getElementById("barcode").value+ " needs the Line number.");
      return;
     }
   	if (window.XMLHttpRequest) {
               xmlhttp = new XMLHttpRequest();
      }else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
		            // document.getElementById("output").innerHTML = xmlhttp.responseText;
		          // myObj = //JSON.parse(this.responseText);
		          if (this.responseText === "") {
                  document.getElementById("search").disabled =true;
		          		alert("Sorry. The order number: "+ document.getElementById("barcode").value+ " is not in the registry.");
		          } else {
		          	// 	document.getElementById("search").disabled =false;
		          	//  alert ("Gooood.");
		          }


		           //txtLHMACH=txtLHOPER = txtLHQTY=txtLHSTRDTTIM=txtElapsedTime= txtLHSTPDTTIM="";
		             //  document.getElementById("machinecolumn").innerHTML += txtLHMACH;
              }
            }
      str = "Checkorder&barcode="+document.getElementById("barcode").value;
      xmlhttp.open("GET","../php/ControllerInquiry.php?q="+str,true);
      xmlhttp.send();
  }
  document.getElementById("barcode").onblur=checkOrder;
  document.getElementById("barcode").onfocus=activeButton;
})