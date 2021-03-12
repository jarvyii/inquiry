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
/*
function myCost() {
 alert($(this).value());
 }
*/

/******************************************************************************
 Fill all info of the JSON  File to create the scaque in the Sheet
 FUNCTION writeDays()
******************************************************************************/

function writeDays( Timesheet){
  var columnTotal=0;
  var rowTotal =0;
  // /Function: This internal function add to the timesheet Form evry day of the weeke
  function addDay(i, j, value, disabledValue){
         var p = document.createElement("INPUT");
         p.id= "Data"+i+j;
         if ( (i == totalWayPayments) || (j == 8) ) {
               p.className="form-control totalInfo";
           } else {
               p.className="form-control";
           }
         p.setAttribute("type", "number");
         p.setAttribute("value", value);
        p.min="0";
        p.max="24";
        p.step="0.5";
        p.addEventListener("input", updateTotalOnChange);
        p.disabled = disabledValue;
        document.getElementById("column-"+j).appendChild(p);
     }
  // \Function   addDay ()
  for(var i=1; i < Description.length; i++ ){
      columnTotal =0;
      for(var j=1; j<8; j++){
          addDay(i, j, Timesheet["Data"+i+j], !document.getElementById("activePeriod").value )
          columnTotal += Number(Timesheet["Data"+i+j]);
        }
      addDay(i, j, columnTotal, true); // Fill the Info in the TOTAL  of the i row
    }
  var grantTotal = 0; // Total of hour worked in the week.
  for(var j=1; j<8; j++){
        rowTotal=0;
        for(var i=1; i < Description.length; i++ ){
          rowTotal += Number(Timesheet["Data"+i+j])
        }
        addDay(i, j, rowTotal, true);// Fill the Info in the TOTAL of the i row
        grantTotal += rowTotal;
    }
    addDay(i, j, grantTotal, true);
  //  var p = document.createElement("INPUT");
}// \FUNTION    writeDays()




/***********************************************
 Add new row to the information Table on the Modal,
 to introduce the time per Machine at the end of the Shift.
 ***********************************************/
 function addRow( myObj ){

     function initialCost( Hours, Min, Produced ) {
      var Minutes = parseInt( Hours)*60 + parseInt(Min);
      var Prod = parseInt( Produced);
      var Cost = 0.0;
      if (( Minutes != 0 ) &&   ( Prod != 0 ) ){
           Cost = 60 / ( Minutes / Prod );
        }
       return Cost.toFixed(2);
     }

      var newRow = ""; 
      var Qtty = 0
      document.getElementById("dashboardrow").innerHTML = "";
      var i = 0;
      for( x in myObj ) {
       // Qtty = (myObj[x].QTY === null) ? 0: myObj[x].QTY;
       idHourValue = "'Hour"+ i + "'";
       sIdHour = 'id = "'+ 'Hour'+i+ '"';
       nameHour = 'name = "'+ 'Hour'+i+ '"';
       idMinValue = "'Min"+ i + "'";
       sIdMin = 'id = "'+ 'Min'+i+ '"';
       nameMin = 'name = "'+ 'Min'+i+ '"';
       idCostValue = "'Cost"+ i + "'";
       sIdCost = 'id = "'+ 'Cost'+i+ '"';
       nameCost = 'id = "'+ 'Cost'+i+ '"';
       idSqf =  'id = "'+ 'Sqf'+i+ '"';
       nameSqf =  'name = "'+ 'Sqf'+i+ '"';
       idSqfValue = "'Sqf"+ i + "'";
       CostValue = initialCost("8", "30", myObj[x].PRODUCTION) ;
       nameMach = 'name = "'+ 'Mach'+i+ '"';
       hideInput = '<input type ="hidden"' + nameMach+' value = "'+ myObj[x].MACHDESC +  '">';
       hideInput += '<input type="hidden"'+ nameSqf +' value ='+ myObj[x].PRODUCTION + '> ';

       

       var nHoras ='<input '+ sIdHour+ nameHour + 'type="number" min= "0" max ="24" size = "2"  maxlength = "2" value = "8"  onchange="myCost('+ idHourValue+','+ idMinValue + ','+idCostValue + ','+ idSqfValue  + ')">' ;
       var nMinutes = '<input ' + sIdMin + nameMin + ' type="number" min= "0" max ="59" size = "2"  maxlength = "2" value = "30"  onchange="myCost('+ idHourValue+','+ idMinValue + ','+idCostValue + ','+ idSqfValue + ')">' ;
       var nCost = '<label  ' + sIdCost+ nameCost +' > ' + CostValue + ' </label>';
       var sqfProduce = '<input '+ idSqf + nameSqf +'type="text" size = "5" maxlength = "5" readonly disabled  value ='+myObj[x].PRODUCTION + '>';
        newRow += "<tr><td scope='row'>"+ myObj[x].MACHDESC + "</td><td>"+ sqfProduce + "</td><td>"+  nHoras+ ":" + nMinutes+"</td><td>"+ nCost + "</td></tr>";
        newRow += hideInput;
        i++;
      }
       totalRow = '<input type ="hidden" name = "totalrow" value = "'+ i +  '">';
        newRow += totalRow;
      document.getElementById("dashboardrow").innerHTML += newRow;
  } 



/*************************************************************
  Update the Value of the Square Feet Production 
  per Machine per Shifts 
************************************************************/
function db_myProduction() {
   
    if (window.XMLHttpRequest) {
               xmlhttp = new XMLHttpRequest();
      }else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
           
             if (this.responseText === "") {
                  return;
               } else {
                
                    myObj = JSON.parse(this.responseText);
                    addRow( myObj ); // To update the Content of the Table in the Modal to introduce Hours per Machine
                 
              }
          }
      }
    
      para = "Dailyprod"; // To know the Daily Production per machine
      xmlhttp.open("GET","../php/ControllerInquiry.php?q="+para,true);
      xmlhttp.send();  
}

$('#btn-endshift').click(function (){

   db_myProduction();
})

/*
$("#contact_form").on("submit", function(e) {
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function(data, textStatus, jqXHR) {
               // $('#endShiftModal .modal-header .modal-title').html("Result");
                $('#endShiftModal .modal-body').html(data);
               // $("#submitForm").remove();
            },
            error: function(jqXHR, status, error) {
                //console.log(status + ": " + error);
                alert(status + ":"+ error);
            }
        });
        e.preventDefault();
    });
   


    $("#submitForm").on('click', function() {
        $("#contact_form").submit();
    });
*/
  document.getElementById("barcode").onblur = checkOrder;
  document.getElementById("barcode").oninput = checkOninput;
  document.getElementById("barcode").onfocus = activeButton;
  document.getElementById("assignlocation").disabled = true;
  document.getElementById("assignment").checked = false;

  


  
})
   