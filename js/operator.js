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
      document.getElementById("produce").disabled = true;
      document.getElementById("travelerbutton").disabled = true;
      document.getElementById("pdftraveler").disabled = true;
      document.getElementById("pdftraveler").href = "";
      Barcode = document.getElementById("barcode").value;
      if (Barcode == ""){
         // alert("Sorry. The order number can not be empty.");
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
		          	document.getElementById("produce").disabled = true;
		          	document.getElementById("travelerbutton").disabled = true;
		          	document.getElementById("pdftraveler").disabled = true;
		          	document.getElementById("pdftraveler").href = "";
		          	alert("Sorry. The order number: "+ document.getElementById("barcode").value+ " is not in our Database registry.");
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
  // Add Value to the Machine Input in the Tracking Form
function AddMachines(){

       var jsonURL ="../data/machines.json";
      var usersFormat ={
                        format: "json"
                       };
        // /FUNCTION getHead()
       function getHead(Data) {
            $.each(Data,function(i, Order) {
                $('#machine').append($('<option>',
                  {
                     value: Order["machineid"],
                     text : Order["machdesc"]
                 }));


              })
          }  //  \FUNCTION getHead()
       $.getJSON(jsonURL, usersFormat,  getHead );

      return false;

  } //function AddMachines()
  AddMachines(); // Add value element to the SELECT Machine
 //alert("voyyyy");
	//Begining of the JavaScript body
	document.getElementById("barcode").onblur=checkOrder;
})
