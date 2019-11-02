$(document).ready(function(){
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
  
  /************************************************************************
  Main Block
  ***********************************************************************/

  //  document.getElementById("loginform").style.display = "block";
  //  document.getElementById("input-ordercode").style.display = "none";
  AddMachines(); // Add value element to the SELECT Machine
});
