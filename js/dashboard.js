 $(document).ready(function(){ 


// Tooltip Initialization
 $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })


/**********************************
 Update the Content of the Bar Graph using the Info in the Database system
***********************************/

function  updateGraphInfo( myObj ) {
  
     if ( (myObj == "") || ( myObj == null)) {
          return;
      }

       // Array of Colors
      var Color = [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(0, 0, 102, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(0, 51, 0, 0.2)',
                    'rgba(112, 219, 112, 0.2)',
                    'rgba(255, 255, 77, 0.2)',
                    'rgba(122, 31, 31, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                    ];
      //To Update the Content of the Graph Chart;
       var i = 0;

       for (x in myObj) {
           myBarChart.config.data.labels[i] =  myObj[x].MACHDESC;
           myBarChart.config.data.datasets[0].data[i] =  myObj[x].PRODUCTION;
           myBarChart.config.data.datasets[0].backgroundColor[i] = Color[i];
           myBarChart.config.data.datasets[0].borderColor[i]= Color[i];
            i++;
         }
        
        myBarChart.update(); // Update the Content.
}


function getAJAX( myUrl ) {
  
   return new Promise( (resolve, reject) => {

           if (window.XMLHttpRequest) {
              xmlhttp = new XMLHttpRequest();
           } else {
               xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
           }

          xmlhttp.onreadystatechange = function() {
                 
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              
                 if (this.responseText != "") {

                       let myObj = JSON.parse(this.responseText);
                      
                       resolve( myObj);
                  }
              }  
              if ( xmlhttp.status >= 300 && xmlhttp.status <=599 ) {
                   reject("Connection error.");
              }

          }

          xmlhttp.open("GET", myUrl,true);

          xmlhttp.send();  

       });
   
}

/***********************************************
 Add new row to the information Table on the Dashboard,
 from the historic table.
 ***********************************************/
 function createLink( Text, machineId){

    const Element = document.createElement("button");
    Element.innerHTML = Text.trim(); 
    Element.setAttribute("type", "button"); 
   // Element.id = "exampleModal";
    Element.className = "btn  pt-1 pb-1";
    Element.setAttribute("data-mdb-toggle", "modal"); 
    Element.setAttribute("data-mdb-target", "#modalMachineOrders"); 
    Element.addEventListener("focus", () => { 
             const dDate = new Date();
             document.getElementById('modalMachineOrdersLabel').innerHTML = "Machine: <strong>" + Text.trim() + "</strong> Date: <strong>"+ dDate.format("m-d-Y")+ "</strong>";   
             getAJAX("../php/dailyOrders.php?idmachine="+ machineId)
                   .then( addOrders )
                   .catch( err => alert( err ) );  
            });

   return Element;
 }


function differenceDateTime( startTime, endTime){
  
  let eTime = endTime.substr(0, 10) + "T"+ endTime.substr(11, 2) + ":"+ endTime.substr(14, 2)+ ":"+ endTime.substr(17,2);
  let sTime = startTime.substr(0, 10) + "T"+ startTime.substr(11, 2) + ":"+ startTime.substr(14, 2)+ ":"+ startTime.substr(17,2);
  
    var delta = Date.parse(eTime) - Date.parse(sTime); // milliseconds elapsed since start
   
    intTime= Math.round(delta / 1000); // Seconds
    // txtSec =  twoChars(intTime % 60);
    Minutes = Math.trunc((intTime/60)%60);
    Hours = Math.trunc(intTime/(60*60));
   
    let Difference = { };
    Difference.Hours = Hours,
    Difference.Minutes = Minutes;

    return Difference;
}

function addOrders( myObj ){

   let Operator = "";
   let Order = "";
   let Qty = "";
   let Time = "";
   let timeWorked ="";

  myObj.forEach( (row) =>{
        Operator += row.LHOPER + "<br>";
        Order += row.LHORD.trim()+"/"+ row.LHLIN.trim()+ "<br>";
        Qty +=   row.LHQTY + "<br>";
        timeWorked = differenceDateTime( row.LHSTRDTTIM, row.LHSTPDTTIM)
        Time +=  timeWorked.Hours +":" + timeWorked.Minutes+ "<br>";

        })
  document.getElementById("operator").innerHTML =  Operator;
  document.getElementById("order").innerHTML =  Order;
  document.getElementById("qty").innerHTML =  Qty;
  document.getElementById("time").innerHTML =  Time;

}

 function addRow( myObj ){
      var newRow = ""; 
      var Qtty = 0
     
      document.getElementById("dashboardrow").innerHTML = "";
      for( x in myObj ) {

        Qtty = (myObj[x].QTY === null) ? 0: myObj[x].QTY;
        newRow += "<tr><th class='pt-0 pb-0' scope='row'><div  id = '"+ myObj[x].MACHINEID.trim() + "'></div></th><td class='text-center pt-2 pb-0'>"+ myObj[x].ORDERS + "</td><td class='text-center pt-2 pb-0'>"+ "  "+"</td><td class='text-center pt-2 pb-0'>"+ Qtty+ "</td></tr>";   
       // newRow += "<tr><th scope='row'>"+ myObj[x].MACHDESC + "</th><td>"+ myObj[x].ORDERS + "</td><td>"+ "  "+"</td><td>"+ Qtty+ "</td></tr>";

      }
      document.getElementById("dashboardrow").innerHTML += newRow;

       let machineDescription;
      for( x in myObj ) {
        
          machineDescription =  createLink( myObj[x].MACHDESC, myObj[x].MACHINEID.trim() );
          $("#"+myObj[x].MACHINEID.trim() ).append( machineDescription);

      }

  } 

/*******************************
Every 3 minutes call myProduction(); to update the INFO in the Bar Chart Diagram.
******************************/  

function  updatemyProduction() {

      setInterval(function() {

              getAJAX( "../php/ControllerInquiry.php?q=Dailyprod")
                     .then(updateGraphInfo);

              getAJAX( "../php/ControllerInquiry.php?q=Machprod")
                     .then(addRow);  
                 
        }, 120000); // update SQ Feet Production every 2 Minutes

}

function addMachineSqft (myObj) {

  for( Record in myObj ) {
    document.getElementById("machinesqft").innerHTML += '<div class= "pt-0 pb-0">' + myObj[Record].MACHDESC + "</div><hr>";
    document.getElementById("sqftsqft").innerHTML += '<div class= "pt-0 pb-0">' + myObj[Record].PRODUCTION + "</div><hr>";
  
  }

}

function showSQFT () {

  getAJAX( "../php/ControllerInquiry.php?q=Dailyprod" )
                 .then(addMachineSqft); 

}

 getAJAX( "../php/ControllerInquiry.php?q=Dailyprod")
                 .then(updateGraphInfo)
                  .catch( err => console.dir( err ) );

 getAJAX( "../php/ControllerInquiry.php?q=Machprod")
                 .then(addRow); 

 updatemyProduction();

 showSQFT ();


});
 
  var ctxB = document.getElementById("barChart").getContext('2d');
  var myBarChart = new Chart(ctxB, {
                                        type: 'bar',
                                        data: {
                                                labels: ["End Trim 1", "End Trim 2", "Glue Spreader", "Itale Press", "Sennersko Press", "Side Trime", "Splicer 1","Splicer 2","Splicer 3"],

                                                
                                               //   labels : [ ],
                                                datasets: [{
                                                              label: "SQ Feet Production",
                                                            //  fillColor: "#fff",
                                                              backgroundColor : [
                                                                                    'rgba(255, 99, 132, 0.2)',
                                                                                    'rgba(54, 162, 235, 0.2)',
                                                                                    'rgba(255, 206, 86, 0.2)',
                                                                                    'rgba(0, 0, 102, 0.2)',
                                                                                    'rgba(153, 102, 255, 0.2)',
                                                                                    'rgba(0, 51, 0, 0.2)',
                                                                                    'rgba(112, 219, 112, 0.2)',
                                                                                    'rgba(255, 255, 77, 0.2)',
                                                                                    'rgba(122, 31, 31, 0.2)',
                                                                                    'rgba(75, 192, 192, 0.2)',
                                                                                    'rgba(153, 102, 255, 0.2)',
                                                                                    'rgba(255, 159, 64, 0.2)'
                                                                                    ],
                                                              //backgroundColor: 'rgba(255, 255, 255, .3)',
                                                              borderColor : [
                                                                                'rgba(255, 99, 132, 0.2)',
                                                                                'rgba(54, 162, 235, 0.2)',
                                                                                'rgba(255, 206, 86, 0.2)',
                                                                                'rgba(0, 0, 102, 0.2)',
                                                                                'rgba(153, 102, 255, 0.2)',
                                                                                'rgba(0, 51, 0, 0.2)',
                                                                                'rgba(112, 219, 112, 0.2)',
                                                                                'rgba(255, 255, 77, 0.2)',
                                                                                'rgba(122, 31, 31, 0.2)',
                                                                                'rgba(75, 192, 192, 0.2)',
                                                                                'rgba(153, 102, 255, 0.2)',
                                                                                'rgba(255, 159, 64, 0.2)'
                                                                                ],
                                                              // borderColor: 'rgba(255, 255, 255)',
                                                              data: [0, 0, 0, 0, 0, 0, 0, 0, 0],
                                                            }]
                                                },    
                                        options:  {
                                                              scales: {
                                                                        yAxes: [{
                                                                                  ticks: {
                                                                                            beginAtZero: true
                                                                                          }
                                                                                }]
                                                                      }
                                                  }
                                       });
 