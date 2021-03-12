$(document).ready(function(){ 

  	function  showDailyProd( myObj ) {
       if ( (myObj == "") || ( myObj == null)) {
            return;
        }
    sLabel = "<span class= 'machinename'>"; // beginning of the span
    sTitle ="'shiftsrow'>"; //Name of the class for the column Title
    gContent ="<span class= 'machineprod'>"; // Name of the Class for grille conetnt
    eLabel = "</span>";  // closing SPAN Tag
    fullList ="";
   for (x in myObj) {
        fullList  +=  sLabel + myObj[x].MACHDESC + ": " + eLabel;
        fullList +=  gContent+ myObj[x].PRODUCTION + eLabel+"<br>";
    }
    document.getElementById("prodlist").innerHTML =  fullList;
  }


/*************************************************************
  Update the Value of the Square Feet Production 
  per Machine per Shifts 
************************************************************/
function myProduction() {
  
   if (window.XMLHttpRequest) {
               xmlhttp = new XMLHttpRequest();
      }else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      
      xmlhttp.onreadystatechange = function() {

        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
             
             if (this.responseText === "") {
                  //document.getElementById("prod").innerHTML = "0";
               } else {
                    myObj = JSON.parse(this.responseText);
                    showDailyProd( myObj );
                 
              }
          }
      }
    
      // var idMachine = document.getElementById("machine").value.substr(1);
    
      para = "Dailyprod"; // To know the Daily Production per machine
      xmlhttp.open("GET","../php/ControllerInquiry.php?q="+para,true);
      
      xmlhttp.send();  
  
}

function  updatemyProduction() {

  setInterval(function() {
    
       myProduction();   
      }, 120000); // update SQ Feet Production every 2 Minutes

}

myProduction();
updatemyProduction();

})