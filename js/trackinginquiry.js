$(document).ready(function(){

  function callAssignLoc( Order, Line, Location ){

     if (window.XMLHttpRequest) {
               xmlhttp = new XMLHttpRequest();
      } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                
             // alert (this.responseText);

              if (this.responseText === "" || parseInt( this.responseText ) == 0 ) {
                 // document.getElementById("search").disabled =true;

                  alert("Warning. We have not assigned new location to the order number: "+  Barcode );
              } else {
                  initDisplayOrder();
                  alert ("Successfull. We have updated "+ this.responseText + " records with a new assigned location.");
              }


               
              }
            }
      str = "assignloc&order=" + Order+"&line="+Line+"&loc="+ Location;
    

     xmlhttp.open("GET","../php/ControllerInquiry.php?q="+str,true);
     xmlhttp.send();
  }

  /****************************

  *****************************/
  $('#assignlocation').click(function (){

    var Barcode = document.getElementById("barcode").value;


     if (Barcode == ""){
        // alert("Sorry. The order number can not be empty.");
      return;
     }
    var Pos = Barcode.indexOf("/");
     if (Pos == -1 ) {
       alert("Sorry. The order number: "+ document.getElementById("barcode").value+ " needs the / and the Line number.");
      return;
     }
    var Order= Barcode.substr(0, Pos);
    var Line =  Barcode.substr(Pos+1);
     if (Line ==""){
         alert("Sorry. The order number: "+ document.getElementById("barcode").value+ " needs the Line number.");
      return;
     }
     var Loc = document.getElementById("location").value
    callAssignLoc( Order, Line, Loc );
  })

  /**********************

  ***********************/

  $('#assignment').click(function (){
    if ( document.getElementById("location").disabled ) {
          document.getElementById("location").disabled = false;
          document.getElementById("assignlocation").disabled = false;
           checkOninput();
    } else {
          document.getElementById("location").disabled = true;
          document.getElementById("assignlocation").disabled = true;
          initDisplayOrder();
    }

})
  
 function activeButton (){
       document.getElementById("search").disabled =false;

  }

  $('#reset').click(function (){

  initDisplayOrder();
})

/***********************
***********************/
$('#barcode').click(function (){

  //checkOrder();  
})

/***************************
 Reset to empty the Screen who show the daily work production
***************************/
function initDisplayOrder() {
    document.getElementById("startdate").innerHTML ="";
    document.getElementById("qty").innerHTML = "";
    document.getElementById("machine").innerHTML = "";
    document.getElementById("columnlocation").innerHTML = "";
    document.getElementById("grade").innerHTML ="";
}

/********************************
 Check for any change in the Order Caption
********************************/
function checkOninput(){
 
  initDisplayOrder();
  Barcode = document.getElementById("barcode").value;
     if (Barcode == ""){
        // alert("Sorry. The order number can not be empty.");
      return;
     }
     Pos = Barcode.indexOf("/");
     if (Pos == -1 ) {
       // alert("Sorry. The order number: "+ document.getElementById("barcode").value+ " needs the / and the Line number.");
      return;
     }
     Order= Barcode.substr(0, Pos);
     LineNumber =  Barcode.substr(Pos+1);
     if (LineNumber ==""){
       //  alert("Sorry. The order number: "+ document.getElementById("barcode").value+ " needs the Line number.");
      return;
     }
 
   checkOrder();     

}

/**************************************************************
      checkOrder()
  Search for the order and Line number, if the order don't 
  exist don't allow to produce the ITEM.
  in othercase the operator can produce it.
****************************************************************/
 function checkOrder(){
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
                  document.getElementById("search").disabled =true;
		          		alert("Sorry. The order number: "+ document.getElementById("barcode").value+ " is not in the registry.");
		          } else {
		          	// 	document.getElementById("search").disabled =false;
		          	//  alert ("Gooood.");
               
                if (document.getElementById("assignment").checked ) {
                  //alert (  LineNumber);
                 displayOrder( Order, LineNumber);
                }
		          }


		           //txtLHMACH=txtLHOPER = txtLHQTY=txtLHSTRDTTIM=txtElapsedTime= txtLHSTPDTTIM="";
		             //  document.getElementById("machinecolumn").innerHTML += txtLHMACH;
              }
            }
      str = "Checkorder&barcode="+document.getElementById("barcode").value;
      xmlhttp.open("GET","../php/ControllerInquiry.php?q="+str,true);
      xmlhttp.send();
  }


/******************************
 Display on screen the Orders produced in work day
 *******************************/
function  showShiftsOrders( myObj ) {
  if ( (myObj == "") || ( myObj == null)) {
    initDisplayOrder();
    return;
  }
  sLabel = "<span class="; // beginning of the span
  sTitle ="'shiftsrow'>"; //Name of the class for the column Title
  gContent ="'shiftscolumn'>"; // Name of the Class for grille conetnt
  eLabel = "<br></span>";  // closing SPAN Tag
  txtLHSTRDTTIM=sLabel+ sTitle+"Start Time"+eLabel+sLabel+gContent;
  txtLHQTY =sLabel+sTitle+"Qty."+    eLabel+sLabel+gContent;
  txtLHMACH=sLabel+sTitle+"Machine"+ eLabel+sLabel+gContent;
  txtLHLOC= sLabel+sTitle+"Location"+eLabel+sLabel+gContent;
  txtLHFACBCK=sLabel+sTitle+"Grade"+ eLabel+sLabel+gContent;
 for (x in myObj) {
     txtLHSTRDTTIM += myObj[x].LHSTRDTTIM.substr(0,19)+ "<br>";
     txtLHQTY +=    myObj[x].LHQTY+ "<br>";
     txtLHMACH +=   myObj[x].MACHDESC + "<br>";
     txtLHLOC +=    myObj[x].LHLOC+ "<br>";
     if ( myObj[x].LHFACBCK == "F") {
         txtLHFACBCK += " Face "+ "<br>";
        } else {
          txtLHFACBCK += " Back "+ "<br>";
        }
     
   }
  document.getElementById("startdate").innerHTML = txtLHSTRDTTIM+ eLabel;
  document.getElementById("qty").innerHTML = txtLHQTY+ eLabel;
  document.getElementById("machine").innerHTML = txtLHMACH+ eLabel;
  document.getElementById("columnlocation").innerHTML = txtLHLOC+ eLabel;
  document.getElementById("grade").innerHTML = txtLHFACBCK+ eLabel;
} 


/************************************
Display the get and display the an specific order in work day
************************************/ 
function  displayOrder(Order, Line){
    Barcode = document.getElementById("barcode").value;
    
    if (window.XMLHttpRequest) {
               xmlhttp = new XMLHttpRequest();
      }else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // document.getElementById("output").innerHTML = xmlhttp.responseText;
              myObj = JSON.parse(this.responseText);
            
              if (this.responseText === "") {
                 // document.getElementById("search").disabled =true;

                  alert("The order number: "+  Barcode+ " does not have production today.");
              } else {
                
                showShiftsOrders( myObj );
                
              }


               //txtLHMACH=txtLHOPER = txtLHQTY=txtLHSTRDTTIM=txtElapsedTime= txtLHSTPDTTIM="";
                 //  document.getElementById("machinecolumn").innerHTML += txtLHMACH;
              }
            }
      str = "Shiftsorder&order=" + Order+"&line="+Line;
     
      xmlhttp.open("GET","../php/ControllerInquiry.php?q="+str,true);
      xmlhttp.send();

}


document.getElementById("btn-endshift1").addEventListener("click",  function (){

  viewEndshift("0");  // 0 -> First Shift

});

document.getElementById("btn-endshift2").addEventListener("click",  function (){

  viewEndshift("1"); // 1 -> Second Shift
  
});

 document.getElementById("barcode").onblur = checkOrder;
 document.getElementById("barcode").oninput = checkOninput;
  document.getElementById("barcode").onfocus = activeButton;
  document.getElementById("assignlocation").disabled = true;
  document.getElementById("assignment").checked = false;

  


  
})
   