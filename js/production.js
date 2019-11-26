$(document).ready(function(){
$('#barcode').click(function (){
   document.getElementById("produce").disabled =false;
   document.getElementById("travelerbutton").disabled =false;

})
/**************************************************************
      checkOrder()
      if the order don't exist don't allow to produce the ITEM.
        in othercase the operator can produce it.
****************************************************************/
  function checkOrder(){
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
		          	document.getElementById("produce").disabled = true;
		          	document.getElementById("travelerbutton").disabled = true;
		          	document.getElementById("pdftraveler").disabled = true;
		          	document.getElementById("pdftraveler").href = "";
		          	alert("Sorry. The order number: "+ document.getElementById("barcode").value+ " is not in the registry.");
		          } else {
		          	 	document.getElementById("produce").disabled =false;
		          	 	document.getElementById("travelerbutton").disabled =false;
		          		var barCode = document.getElementById("barcode").value;
		          		var Pos = barCode.indexOf("/");
		          		var Order= barCode.substr(0, Pos);
		          		var pdfNameLink = '../pdf/'+Order+'.pdf';
                  document.getElementById("pdftraveler").href = pdfNameLink;
		          }


		           //txtLHMACH=txtLHOPER = txtLHQTY=txtLHSTRDTTIM=txtElapsedTime= txtLHSTPDTTIM="";
		             //  document.getElementById("machinecolumn").innerHTML += txtLHMACH;
              }
            }
      str = "Checkorder&barcode="+document.getElementById("barcode").value;
      xmlhttp.open("GET","../php/ControllerInquiry.php?q="+str,true);
      xmlhttp.send();
  }
  function checkProduction(){
  	if (document.getElementById("qtyproduced").value != document.getElementById("orderqty").value){
        alert("The quantity produced is less than the quantity in the order.");
      }
  }
	//Begining of the JavaScript body
	document.getElementById("barcode").onblur=checkOrder;
	document.getElementById("qtyproduced").onblur=checkProduction;
	})