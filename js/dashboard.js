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
                    updateGraphInfo( myObj ); // To update the Content of the Bar Graph
                 
              }
          }
      }
    
      para = "Dailyprod"; // To know the Daily Production per machine
      xmlhttp.open("GET","../php/ControllerInquiry.php?q="+para,true);
      xmlhttp.send();  
}



/***********************************************
 Add new row to the information Table on the Dashboard,
 from the historic table.
 ***********************************************/
 function addRow( myObj ){
      var newRow = ""; 
      var Qtty = 0
      document.getElementById("dashboardrow").innerHTML = "";
      for( x in myObj ) {
        Qtty = (myObj[x].QTY === null) ? 0: myObj[x].QTY;
        newRow += "<tr><th scope='row'>"+ myObj[x].MACHDESC + "</th><td>"+ myObj[x].ORDERS + "</td><td>"+ "  "+"</td><td>"+ Qtty+ "</td></tr>";

      }
      document.getElementById("dashboardrow").innerHTML += newRow;
  } 

 /**************************************
 call a PHP Function and return Total of Orders, Total Machine Time and Total Qty Produced 
 per Machine 
 ***************************************/ 
function updateTable() {
   
     if (window.XMLHttpRequest) {
          xmlhttp = new XMLHttpRequest();
        } else {
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            // alert(this.responseText);
             if (this.responseText === "") {
                  return ;
               } else {
                    myObj = JSON.parse(this.responseText);
                    addRow(myObj);
              }
          }
      }
    
      para = "Machprod"; // To know Total of Orders, Total Machine Time and Total Qty Produced  per Machine 
      xmlhttp.open("GET","../php/ControllerInquiry.php?q="+para,true);
      xmlhttp.send();    
} 
/*******************************
Every 3 minutes call myProduction(); to update the INFO in the Bar Chart Diagram.
******************************/  

function  updatemyProduction() {

      setInterval(function() {
           db_myProduction(); 
           updateTable();  
      }, 120000); // update SQ Feet Production every 2 Minutes

}

 db_myProduction(); //To update de Graph
 updateTable();
 //  document.getElementById("prodlist").innerHTML =  fullList;
 updatemyProduction();

})
 
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
 