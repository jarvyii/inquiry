$(document).ready(function(){

$('#qtyproduced').keypress(function (event){
  var keycode = (event.keyCode ? event.keyCode: event.wich);
  if( keycode == '13'){
    //event.stopPropagation();
    //alert('Enterrrrrrrr:'+document.getElementById("qtyproduced").value);
    
    checkProduction();
  } 
})


$('#qtyproduced').click(function (){
   document.getElementById("stopprod").disabled =false;
   //document.getElementById("travelerbutton").disabled =false;

})
/*************************************************
         overrideCode()
   To check the Supervisor Overrride Code. Its used in the view_production(), modal form.
**************************************************/
function overrideCode(){
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
                 alert("Sorry. Wrong CODE");
                document.getElementById("stopprod").disabled = true;
              } else {
                 myObj = JSON.parse(this.responseText);
                 document.getElementById("code").value = myObj['CODE'];
                 document.getElementById("supervisor").value = myObj['SUPERVISOR'];
                 document.getElementById("stopprod").disabled = false;
                 //alert("Gooooooood:"+this.responseText);
              }
          }
      }
      str = "Override&code="+document.getElementById("override").value;
      xmlhttp.open("GET","../php/ControllerInquiry.php?q="+str,true);
      xmlhttp.send();  

}

 function checkProduction(){
    var qtyProduced = parseInt(document.getElementById("qtyproduced").value);
    var qtycmpted = parseInt(document.getElementById("qtycmpted").value);
    var qtyOrder = parseInt(document.getElementById("orderqty").value);
    
    if ((qtyProduced + qtycmpted) > qtyOrder){
        alert("The quantity produced is more  than the quantity in the order.");
        document.getElementById("stopprod").disabled = true;
       return;
     }
    if ((qtyProduced + qtycmpted) < qtyOrder){
        //alert("The quantity produced is less than the quantity in the order.");
        document.getElementById("stopprod").disabled = true;
        $("#myModal").modal("show");
      }
    // document.getElementById("stopprod").disabled = false; 
  }


	//Begining of the JavaScript body
	//document.getElementById("barcode").onblur=checkOrder;
	document.getElementById("qtyproduced").onblur=checkProduction;
  document.getElementById("override").onblur= overrideCode;
  // Check if qty Produced is equal or  greater than qty Ordered
  if ( parseInt(document.getElementById("qtycmpted").value) >= parseInt(document.getElementById("orderqty").value)) {
    document.getElementById("startprod").disabled = true;
    alert("You can't process this order bcecause the quantity completed is greater than or equal to the quantity ordered.");
  }
  //document.getElementById("stopprod").disabled = true;
  document.getElementById("qtyproduced").disabled = true;
})