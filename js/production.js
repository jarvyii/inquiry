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
 Call a (PHP) Backend function to save data with the specific URL.
********************************************/
function postAJAX( Url ){
    
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
      
      xmlhttp.open("post", Url, true);
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
  if ( isflitch.trim() == "Y" ) {
    
    var flitchCode = document.getElementById("flitch").value;
    if (flitchCode == "") {
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
                
                 postAJAX( "../php/updateProduction.php");

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
            
            postAJAX( "../php/updateProduction.php" );
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
    postAJAX( "../php/updateProduction.php" );

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

function checkFlitch(){

   const isFlitch = document.getElementById("isflitch").value.trim();

   if ( isFlitch == "N" ) {
    return;
   }

   let label = document.createElement( "label" ); 

    label.id= "flitchlabel";
    label.innerHTML = "Flitch #: ";
    label.htmlFor = "flitch";
    
    let input = document.createElement( "input" );
    input.className =  "formProd quantityproduced" ;
    input.setAttribute("type", "text"); 
    input.setAttribute("name", "flitch"); 
    input.id = "flitch";
   
    input.size = 7;
    input.maxLength = 5;
    input.setAttribute("placeholder", "Number");

    $("#divflitch").append( label );
    $("#divflitch").append( input );

    if ( isFlitch == "Y" ) {
      return;
    }

    // If isFlitch != Y and != N then isFlitch will be = to a preview enter Flitch number and it's no necesary type again
      input.setAttribute("value", isFlitch); 

    let button = document.createElement( "input" );
    button.setAttribute("type", "button");
    button.className =  "btn button-next formProd quantityproduced" ;
    button.setAttribute("name", "updateflitch");
    button.id = "updateflitch";
   
    button.setAttribute("value", "Update Flitch #");
    button.disabled = true;
    button.addEventListener("click", () => {
           postAJAX("../php/updateFlitch.php");
           button.disabled = true;
          })

    $("#divflitch").append( button ); 

    input.addEventListener("input", () => {
          document.getElementById("isflitch").value = "U"; // Must update an existing Flitch #
           button.disabled = false;
          });
      

}

/****************************************************/
	//Begining of the JavaScript body
	
  document.getElementById("override").onblur= overrideCode;

 
  
  document.getElementById("qtyproduced").disabled = true;

  checkFlitch();

 // Check if qty Produced is equal or  greater than qty Ordered
  if ( parseInt(document.getElementById("qtycmpted").value) >= parseInt(document.getElementById("orderqty").value)) {   
    addWarning("ALERT: The quantity completed is greater than or equal to the quantity ordered."); 
    
  }



})