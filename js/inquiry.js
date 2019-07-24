$(document).ready(function(){
  /***************************************************************************
  INQUIRY TRACKING FORM.
  Switch the Radio Button to Scan Bar Code or Enter Order
  ****************************************************************************/
  $('#radio-order').click(function () {
     if (document.getElementById("radio-order").checked) {
        document.getElementById("input-barcode").disabled = true;
        document.getElementById("input-barcode").style.display = "none";
        document.getElementById("input-ordercode").disabled = false;
        document.getElementById("input-ordercode").style.display = "inline";
      }
    }); // /$('#radio-order').click(function ())
    /***************************************************************************
    INQUIRY TRACKING FORM.
    Switch the Radio Button to Scan Bar Code or Enter Order
    ****************************************************************************/
    $('#radio-code').click(function () {
      if (document.getElementById("radio-code").checked) {
          document.getElementById("input-barcode").disabled = false;
          document.getElementById("input-barcode").style.display = "inline";
          document.getElementById("input-ordercode").disabled = true;
          document.getElementById("input-ordercode").style.display = "none";
        }
      }); // /$('#radio-code').click(function ())
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
  }); // \FUNCTION  $('#buttonlogin').click(function ())


    document.getElementById("loginform").style.display = "block";
    document.getElementById("input-ordercode").style.display = "none";

})
