$(document).ready(function(){

  // Blinking TEXT
  function blinker(){
    $('.blinking').fadeOut(500);
    $('.blinking').fadeIn(500);
  }
    
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
      document.getElementById("stopprod").style.display = "inline";
      document.getElementById("qtyproduced").disabled = false;
      /* 
          Write orderqty value to qtyproduced
          document.getElementById("qtyproduced").value = document.getElementById("orderqty").value;
      */
     var startDate = new Date();
      document.getElementById("starttime").value = startDate.format("Y-m-d H:i:s.u");
      
      setInterval(function() {
          
            var nowDate = new Date();
            var delta = nowDate - startDate; // milliseconds elapsed since start

            intTime= Math.round(delta / 1000); // Seconds
            txtSec =  twoChars(intTime % 60);
            txtMin =  twoChars(Math.trunc((intTime/60)%60));
            txtHours = twoChars(Math.trunc(intTime/(60*60)));
            txtTime = txtHours.toString()+"h:"+txtMin.toString() +"m:"+ txtSec+"s"

            document.getElementById("processedtime").value = txtTime;
            
      }, 1000); // update about every seconds
    document.getElementById("qtyproduced").focus();  
})
  /************************************************************************
  Main Block
  ***********************************************************************/

  //  document.getElementById("loginform").style.display = "block";
  //  document.getElementById("input-ordercode").style.display = "none";
   //setInterval(blinker,1000);
  if (document.getElementById("typeuser").value == "operator"){
      document.getElementById("exit-nav").href = "../index.php";
      //document.getElementById("qtyproduced").disabled = true;

  } else {
      document.getElementById("exit-nav").href = "../supervisor.php";
  }

 });
