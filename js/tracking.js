$(document).ready(function(){

 /*************************************************************
  Add Value to the Machine Input Menue in the Tracking Form
   Using DB2 File in as400
  /************************************************************/
  
function AddMachines() {
   if (window.XMLHttpRequest) {
               xmlhttp = new XMLHttpRequest();
      }else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
             if (this.responseText === "") {
                 alert("Sorry. Error creating the Machine Menue");
               } else {
                 myObj = JSON.parse(this.responseText);
                 for (x in myObj) {
                    $('#machine').append($('<option>', {
                        value: myObj[x]. MACHFLTRQ + myObj[x]. MACHINEID,
                        text : myObj[x].MACHDESC


                    }));
                    document.getElementById("machine").selectedIndex = document.getElementById("selectindex").value;
                   // alert("Id:"+ myObj[x]. MACHINEID +" Des:"+ myObj[x].MACHDESC + " GR:" + myObj[x]. MACHFLTRQ );
                  }
                  // To show how many SQ Feet has been produced in this machine.
                   myProduction();
                }
          }
      }
      para = "Machines";
      xmlhttp.open("GET","../php/ControllerInquiry.php?q="+para,true);
      xmlhttp.send();  
  
}


AddMachines(); // Add value element to the SELECT Machine



  })

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
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
             if (this.responseText === "") {
                 document.getElementById("prod").innerHTML = "0";
               } else {
                  document.getElementById("prod").innerHTML = this.responseText;
              }
          }
      }
    
      var idMachine = document.getElementById("machine").value.substr(1);
    
      para = "Production&idmachine="+idMachine;
      xmlhttp.open("GET","../php/ControllerInquiry.php?q="+para,true);
      xmlhttp.send();  
  
}



  
