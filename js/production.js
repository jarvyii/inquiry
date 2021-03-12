$(document).ready(function(){

$('#qtyproduced').keypress(function (event){
  var keycode = (event.keyCode ? event.keyCode: event.wich);
  if( keycode == '13'){
     checkProduction();
  } 
})

$('#qtyproduced').click(function (){
   document.getElementById("stopprod").disabled =false;
   //document.getElementById("travelerbutton").disabled =false;

})
/*******************************************
 endProduction() Call a (PHP) Backend function the save the production value in the Database.
********************************************/
function endProduction(){
    
     if (window.XMLHttpRequest) {
               xmlhttp = new XMLHttpRequest();
      }else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }

      var nDate = new Date();
      document.getElementById("endtime").value = nDate.format("Y-m-d H:i:s.u");

     var elements = document.getElementsByClassName("formProd");
      var formData = new FormData(); 
      for(var i=0; i<elements.length; i++)
      {
          formData.append(elements[i].name, elements[i].value);
      }
      
      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
               
              if (this.responseText != "OK") {
                 alert("Sorry. No updated");
              } else {
                  
              }

          }
      }
      
      xmlhttp.open("post","../php/updateProduction.php",true);
      xmlhttp.send(formData);  

}




/***********************************
   Stop the Production process
***********************************/
$('#stopprod').click(function (){
     
      document.getElementById("startprod").style.display = "block";
      document.getElementById("stopprod").style.display = "none";

})
/**************************************************/
$('#stopprod').mousedown(function (){
  
  var isflitch = document.getElementById("isflitch").value;
  if ( isflitch.trim() === "Y" ) {
    
    var flitchCode = document.getElementById("flitch").value;
    if (flitchCode === "") {
      alert("Error: The Flitch # field can not be empty.");
      return;
    }

  } 

  checkProduction();
 

})

/*************************************************
         overrideCode()
   To check the Supervisor Overrride Code. Its used in the view_production(), modal form.
**************************************************/
function overrideCode(){

     if ( document.getElementById("override").value === ""){
       return;
     }

     if (window.XMLHttpRequest) {
               xmlhttp = new XMLHttpRequest();
      }else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }

      xmlhttp.onreadystatechange = function() {

        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
               
              if (this.responseText === "") {
                 alert("Sorry. Wrong CODE");
                document.getElementById("stopprod").disabled = true;
                
              } else {
                 myObj = JSON.parse(this.responseText);

                 document.getElementById("code").value = myObj['CODE'];
                 document.getElementById("supervisor").value = myObj['SUPERVISOR'];
                 document.getElementById("stopprod").disabled = false;
                
                 endProduction();

                 $('#stopprod').click();
              }
          }
      }
      
      str = "Override&code="+document.getElementById("override").value;
      
      xmlhttp.open("GET","../php/ControllerInquiry.php?q="+str,true);
      xmlhttp.send();  

}
/**************************************************/
//Modal form to Override
dialogoOverride =  $( "#myOverride" ).dialog({
        autoOpen: false,
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons: {
          "Submit":  function() {
            $( this ).dialog( "close" );
          }
        }
      });
/*************************************************/
//  Modal form to Warning;
 dialogoWarning =  $( "#dialog-confirm" ).dialog({
          autoOpen: false,
          resizable: false,
          height: "auto",
          width: 400,
          modal: true,
          buttons: {
            "Yes":
            function() {
              dialogoOverride.dialog( "open" );
              $( this ).dialog( "close" );
            },
            "No": function() {
            
            endProduction();
            $('#stopprod').click();
           
            $( this ).dialog( "close" );
            }
          }
        });
 /************************************************/
 function checkProduction(){

    var qtyProduced = parseInt(document.getElementById("qtyproduced").value);
    var qtycmpted = parseInt(document.getElementById("qtycmpted").value);
    var qtyOrder = parseInt(document.getElementById("orderqty").value);

    if (((qtyProduced + qtycmpted) > qtyOrder) && (document.getElementById("comment").value == "") ){
        alert("You have to write a comment when the quantity produced is more  than the quantity in the order.");
        document.getElementById("stopprod").disabled = true;
       return ;
     }

    if ((qtyProduced + qtycmpted) < qtyOrder){
        dialogoWarning.dialog( "open" ); 
        return;     
      }
    endProduction();

    $('#stopprod').click();
}
function addWarning(Text) {
     let labelWarning = document.createElement('p');
     labelWarning.innerHTML = Text;
     labelWarning.style.color = '#8e2938';
     labelWarning.style.fontWeight = 'bold';
     let Label =   document.getElementById("divProccesing");
     Label.insertBefore(labelWarning, Label.childNodes[0]);

}

/****************************************************/
	//Begining of the JavaScript body
	
  document.getElementById("override").onblur= overrideCode;

 
  
  document.getElementById("qtyproduced").disabled = true;

  if ( document.getElementById("isflitch").value.trim() == "Y"){
      document.getElementById("flitchlabel").style.display = "block";
     } else{
        document.getElementById("flitchlabel").style.display = "none";
    }
    
 // Check if qty Produced is equal or  greater than qty Ordered
  if ( parseInt(document.getElementById("qtycmpted").value) >= parseInt(document.getElementById("orderqty").value)) {   
    addWarning("ALERT: The quantity completed is greater than or equal to the quantity ordered."); 
    
  }



})