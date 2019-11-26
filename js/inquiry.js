$(document).ready(function(){

  // Blinking TEXT
  function blinker(){
    $('.blinking').fadeOut(500);
    $('.blinking').fadeIn(500);
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
  
/**********************************************************************************
 Check valid the User and password introduced in Login Form. And setup all INFO in the System.
 FUNCTION  $('#buttonlogin').click(function ())
**********************************************************************************/
$('#buttonlogin').click(function () {//function validate() {
    var username = document.getElementById("user-name").value;
    var password = document.getElementById("user-password").value;
    if (username == null || username == "" ) {
        alert("Please enter the username.");
        return false;
      } else if (password == null || password == "") {
          alert("Please enter the password.");
          return false;
      }
    document.getElementById("jumbotron").style.display = "block";
    document.getElementById("loginform").style.display = "none";

    /* This code is to validate the User INformation*/
    //getUser(username, password);
    // Execute the Bar Code and Machine reading
  }) // \FUNCTION  $('#buttonlogin').click(function ())

/************************************************
 Add one cero at the beginning for number with one digit
*************************************************/
function twoChars( Value){
      return  (Value < 10 ) ?  "0"+Value.toString() : Value.toString();
}
/***********************************
   Initiate the Production process
***********************************/
//function startProd() 
$('#startprod').click(function (){
      setInterval(blinker,1000);
      document.getElementById("startprod").style.display = "none";
      document.getElementById("stopprod").style.display = "block";
      document.getElementById("qtyproduced").value = document.getElementById("orderqty").value;
      document.getElementById("qtyproduced").disabled = false;
      var startDate = new Date();
      document.getElementById("starttime").value = startDate.format("Y-m-d H:i:s.u");
      setInterval(function() {
          
      //var delta = Date.now() - start; // milliseconds elapsed since start
      var nowDate = new Date();
      var delta = nowDate - startDate; // milliseconds elapsed since start
      //intTime= Math.floor(delta / 1000);
      intTime= Math.round(delta / 1000); // Seconds
      txtSec =  twoChars(intTime % 60);
      txtMin =  twoChars(Math.trunc(intTime/60));
      txtHours = twoChars(Math.trunc(intTime/(60*60)));
      txtTime = txtHours.toString()+"h:"+txtMin.toString() +"m:"+ txtSec+"s"
      document.getElementById("processedtime").value = txtTime;
      //txtDays.toString()+"d:"+txtHours.toString()+"h:"; // in seconds
      // alternatively just show wall clock time:
      //alert(new Date().toUTCString());
      }, 1000); // update about every seconds
})
/***********************************
   Stop the Production process
***********************************/
$('#stopprod').click(function (){
  var nDate = new Date();
      document.getElementById("endtime").value = nDate.format("Y-m-d H:i:s.u");
      document.getElementById("startprod").style.display = "block";
      document.getElementById("stopprod").style.display = "none";
      if (document.getElementById("qtyproduced").value = document.getElementById("orderqty").value){
        alert("Insuficient production");
         $("#myModal").modal("show");
      }
     // document.getElementById("qtyproduced").disabled = true;
})
  /************************************************************************
  Main Block
  ***********************************************************************/

  //  document.getElementById("loginform").style.display = "block";
  //  document.getElementById("input-ordercode").style.display = "none";
  AddMachines(); // Add value element to the SELECT Machine
  //setInterval(blinker,1000);
  if (document.getElementById("typeuser").value == "operator"){
      document.getElementById("exit-nav").href = "../index.php";
      document.getElementById("qtyproduced").disabled = true;

  } else {
      document.getElementById("exit-nav").href = "../supervisor.php";
  }

 });
