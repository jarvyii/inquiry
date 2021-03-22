const idMach = "Mach";
const idQty = "Qty";
const idSqFt = "SqFt";
const idBoards = "Boards";
const idSheets = "Sheets";
const idHours = "Hours";
const idMinutes = "Min";
const idHourRate = "HourRate";
const idTtlCost = "TtlCost"; 
const idMachDesc = "MachDesc";

const  reportTimesheets = "reportTimesheets.php";
const  reportEndshift = "reportEndshift.php";

const hourRate = 21.00;


function createDiv(Type, Id, className, Text)
{
   let Div = document.createElement( Type ); 

   if( Id != "" ) {
    Div.id= Id;
   }
    
  Div.innerHTML = Text;

  if ( className != "" )
    {
        Div.className =  className;
    }

    Div.style.textAlign = "center";

    return Div;
}
function createFormHeader(form)
{
  const divEndshift = createDiv( "div","divEndshift", "row trackinginquiry font-weight-bold", "");

  const divOperation = createDiv( "div", "divOperation", "col-2 font-weight-bold", "Operation");
  const divQty = createDiv( "div", "divQty", "col-1  font-weight-bold", "Qty");
  const divSqFt = createDiv( "div", "divSqFt", "col-1  font-weight-bold", "SqFt");
  const divBoards =  createDiv( "div", "divBoards", "col-1  font-weight-bold", "Boards");
  const divSheets =  createDiv( "div", "divSheets", "col-1  font-weight-bold", "Sheets");
  const divHours =createDiv( "div", "divHours", "col-1  font-weight-bold", "HOURS");
  const divMinutes =createDiv( "div", "divMinutes", "col-1  font-weight-bold", "Min");
  const divHRate = createDiv( "div", "divHRate", "col-2 font-weight-bold", "Hrly Rate");
  const divTtlCost = createDiv( "div", "divTtlCost", "col-2  font-weight-bold", "TTL Cost<br>");

  divEndshift.appendChild( divOperation ); 
  divEndshift.appendChild( divQty );   
  divEndshift.appendChild( divSqFt );
  divEndshift.appendChild( divBoards );
  divEndshift.appendChild( divSheets ); 
  divEndshift.appendChild( divHours ); 
  divEndshift.appendChild( divMinutes ); 
  divEndshift.appendChild( divHRate );
  divEndshift.appendChild( divTtlCost ); 

  form.appendChild( divEndshift );
 
}

function createFormElement(Element, Type, className, Id, Name, Text, Status, Min, Max, Position )
{
  const Input = document.createElement("input"); 
  Input.setAttribute("type", Type); 
  Input.setAttribute("name", Name); 
  Input.id = Id;
  Input.readOnly = Status;
  

   if (Text != "") {
    Input.setAttribute("value", Text); 
   }
  
  if ( className != "") {
      Input.className =  className;
  }

  if (Type == "number" )
  {
    Input.min = Min;
    Input.max = Max;
  

    Line = Id.match(/\d+$/)[0];

    let callFuntion = 'myCost("'+idHours+Line + '", "' + idMinutes+Line + '", "'+ idHourRate+Line+'","' + idTtlCost+Line + '", "' + idSqFt+Line + '")';

    Input.setAttribute('onchange', callFuntion);
  }

 if (Type === "text" )
  {
    Input.size = Min;
    Input.maxLength = Max;
  }
  
  Input.style.textAlign = Position;
  return Input;
}

/***********************************************
 Add new row to the information Table on the Modal,
 to introduce the time per Machine at the end of the Shift.
 ***********************************************/
 function addRow( myObj ){

     function initialCost( Hours, Min, HourRate, SqFt ) {
      var Minutes = parseInt( Hours)*60 + parseInt(Min);
      var Rate = parseInt( HourRate);

      var prodSqFt = parseInt( SqFt);

      var Value = Minutes * Rate;

      var Cost = 0.0;
      if (( prodSqFt != 0 ) ){
           Cost = (Value / prodSqFt) / 60;
        }
       return Cost.toFixed(2);
     }

      
      var Qtty = 0
      const divInput = document.getElementById("divInput");
      

      const divOperation = document.getElementById( "divOperation");
      const divQty = document.getElementById( "divQty");
      const divSqFt = document.getElementById( "divSqFt");
      const divBoards = document.getElementById( "divBoards");
      const divSheets = document.getElementById( "divSheets");
      const divHours =document.getElementById( "divHours");
      const divMinutes =document.getElementById( "divMinutes");
      const divHRate =document.getElementById( "divHRate");
      const divTtlCost = document.getElementById( "divTtlCost");

      let i = 0;

      let Operation, Qty ="";

      for( x in myObj ) {
         Qty = ( myObj[x].QTY === null) ? "0": myObj[x].QTY.toString().trim();

         Operation = createFormElement("input","text", "rowTimesheet", idMach+i, idMach+i, myObj[x].MACHDESC.trim(), true, 11, 11,"left");
         Qty = createFormElement("input", "text", "rowTimesheet", idQty + i, idQty + i, Qty, true, 4, 4, "center" );

         let Production = parseFloat( myObj[x].PRODUCTION ).toFixed(2);
         SqFt = createFormElement("input", "text", "rowTimesheet", idSqFt + i, idSqFt + i, Production, true, 7, 7, "center" );
         Boards = createFormElement("input", "text", "rowTimesheet", idBoards + i, idBoards + i, myObj[x].BOARDS, true, 5, 5, "center" );
         Sheets = createFormElement( "input", "text", "rowTimesheet", idSheets + i, idSheets +i, myObj[x].SHEETS, true, 6,6, "center" );
         Hours = createFormElement( "input","number", "rowTimesheet", idHours + i, idHours + i, 8, false, 0, 999, "center" );
         Minutes = createFormElement( "input", "number", "rowTimesheet", idMinutes + i, idMinutes + i, 0, false, 0, 59 ,"center" );
        
         hourlyRate = createFormElement( "input", "text", "rowTimesheet", idHourRate + i, idHourRate + i,"$ "+ hourRate, true, 7, 7, "center" );

        CostValue = initialCost(8, 0 , hourRate, myObj[x].PRODUCTION) ;
        TtlCost = createFormElement( "input", "text", "rowTimesheet", idTtlCost + i, idTtlCost + i, CostValue, true, 7, 7,"center" ); 
        TtlCost.title = "( Hours * HrlyRate ) / SqFt";

        MachDesc = createFormElement( "input", "HIDDEN", "", idMachDesc + i, idMachDesc + i,  myObj[x].MACHDESC); 

       
       //hideInput += '<input type="hidden"'+ nameSqf +' value ='+ myObj[x].PRODUCTION + '> ';

       //var nHoras ='<input '+ sIdHour+ nameHour + 'type="number" min= "0" max ="24" size = "2"  maxlength = "2" value = "8"  onchange="myCost('+ idHourValue+','+ idMinValue + ','+idCostValue + ','+ idSqfValue  + ')">' ;
      // var nMinutes = '<input ' + sIdMin + nameMin + ' type="number" min= "0" max ="59" size = "2"  maxlength = "2" value = "30"  onchange="myCost('+ idHourValue+','+ idMinValue + ','+idCostValue + ','+ idSqfValue + ')">' ;
      
      
      divOperation.appendChild( Operation ); 
      divQty.appendChild( Qty );   
      divSqFt.appendChild( SqFt ); 
      divBoards.appendChild( Boards ); 
      divSheets.appendChild( Sheets); 
      divHours.appendChild( Hours );

      divHRate.appendChild( hourlyRate );
      divTtlCost.appendChild( TtlCost ); 
       divMinutes.appendChild( Minutes );
     // Minutes.onchange = myCost("Hours"+i,"Min"+i,"TtlCost"+i,"SqFt"+i);
     

      // Hours.onchange = myCost("Hours"+i,"Min"+i,"TtlCost"+i,"SqFt"+i);
     
      
        i++;
      }
      totalRow = createFormElement( "input", "HIDDEN", "", "totalrow", "totalrow", i); 
      divInput .appendChild( totalRow );
      // totalRow = '<input type ="hidden" name = "totalrow" value = "'+ i +  '">';

     // return Promise.all();
  } 


/*************************************************************
  Update the Value of the Qty and Square Feet Production 
  per Machine per Shifts 
************************************************************/
function myProduction( myUrl ) {
  
   return new Promise( (resolve, reject) => {

           if (window.XMLHttpRequest) {
              xmlhttp = new XMLHttpRequest();
           } else {
               xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
           }

          xmlhttp.onreadystatechange = function() {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              
                 if (this.responseText === "") {
                  

                      reject("No operation at this moment");

                   } else {
                       
                       let myObj = JSON.parse(this.responseText);
                      
                       resolve( myObj);
                  }
              } 
          }

          xmlhttp.open("GET", myUrl,true);

          xmlhttp.send();  

       });
   
}

/*******************************************
 AJAX-POST
********************************************/
function ajaxPOST( myURL){


   return new Promise( (resolve, reject) => {

           if (window.XMLHttpRequest) {
              xmlhttp = new XMLHttpRequest();
           } else {
               xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
           }

           var elements = document.getElementsByTagName("input");
           var formData = new FormData(); 
           for(var i=0; i<elements.length; i++)
            {
                formData.append(elements[i].name, elements[i].value);
            }

          xmlhttp.onreadystatechange = function() {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              
                 if (this.responseText === "") {
                      reject("No operation at this moment") ;
                   } else {
                       
                      let myObj = JSON.parse(this.responseText);
                       resolve( myObj);
                                   
                  }
              } 
          }

        xmlhttp.open("POST", myURL,true);
 
         xmlhttp.send(formData); 

       });
      

}

function createFormBody(form, Shift)
{
  const Input = createDiv( "DIV", "divInput", "" , "");
  form.appendChild(Input);

  myProduction( "../php/dailyProduction.php?shift="+Shift )
    .then( addRow )
    .catch( err => alert( err ) )
    //.then(  setOnchange )
}

function createFormButtons(form, Shift = 0 )
{
  const Div = createDiv( "div", "divButton", "trackinginquiry modal-footer button-trackinginquiry" , "");

  //To create the buttons

  const Preview = createFormElement("BUTTON", "button", "btn btn-inquiry button-next", "btnPreview", "btnPreview", "Preview", false, 7, 7,"center" ); 

  const Reset = createFormElement("BUTTON", "reset", "btn btn-inquiry button-next", "btnReset", "btnReset", "Reset", false, 7, 7,"center" );

  const Report = createFormElement("BUTTON", "submit", "btn btn-inquiry button-next", "btnReport", "btnReport", "Report", false, 7, 7,"center" );
  Report.formTarget="_blank"; 
  /*
  Report.addEventListener("click", ()=>{
     //myProduction( "../php/topdf.php" );
     //ajaxPOST( "../php/topdf.php")
  }); */

  const Next = createFormElement("BUTTON", "button", "btn btn-inquiry button-next", "btnNext", "btnNext", "Next", false, 7, 7,"center" );

  Next.addEventListener("click", ( ) => { 

      viewTimesheet(Shift);

   });
  
  Div.appendChild(Preview);
  Div.appendChild(Reset);
  Div.appendChild(Report);
  Div.appendChild(Next);

  form.appendChild(Div);
}

function createFormEndshift( Action )
{
  const form = document.createElement("form");
  form.setAttribute("method", "POST"); 
  form.setAttribute("action", Action );
  form.id = "Endshift";
  form.name = "Endshift";

  const inquiry = createFormElement( "input", "hidden", "", "inquiry", "inquiry", "Endshift"); 
  const Operator = createFormElement("input","hidden", "", "operator", "operator", document.getElementById("operator").value); 
  
  form.appendChild(inquiry);
  form.appendChild(Operator);
  
  return form;
  

}
 

function viewEndshift( Shift )
{

 
  const form = createFormEndshift( reportEndshift );

  formDiv = headForm( "Endshift");
  form.appendChild( formDiv );

  createFormHeader(form);
  createFormBody(form, Shift);
  createFormButtons(form, Shift);
  

  //let oldForm = document.getElementById("trackinginquiry");
  
  let oldForm = document.getElementsByTagName("form")[1];
 
  oldForm.insertAdjacentElement("beforebegin", form );

   document.getElementById("btnPreview").addEventListener("click", () => {

       document.getElementById('inquiry').value = "homeSupervisor";
        document.getElementById('Endshift').action = "ControllerInquiry.php";
        $("#Endshift").submit();
    
     });

  oldForm.remove();
    
}

function differenceDateTime( startTime, endTime){
  
  let eTime = endTime.substr(0, 10) + "T"+ endTime.substr(11, 2) + ":"+ endTime.substr(14, 2)+ ":"+ endTime.substr(17,2);
  let sTime = startTime.substr(0, 10) + "T"+ startTime.substr(11, 2) + ":"+ startTime.substr(14, 2)+ ":"+ startTime.substr(17,2);
 
  //eTime = new Date(eTime);
  //sTime = new Date(sTime);
  
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

function createSchemeTimesheet( form, Machine){
  

  <!-- Grid main row -->
  const rowDiv =  createDiv( "DIV", "", "container row" , "");

      <!-- Grid First column -->
      const col1Div = createDiv( "DIV", "", "col-lg-1 d-flex  p-0 m-0 border border-dark" , "");
       //  const Section = createDiv( "SECTION", "", "p-2 dark-grey-text" , "");
             const MachineColumn =  createFormElement("input", "text", "rowTimesheet d-flex font-weight-bold m-0", Machine.MACHINEID.trim(), Machine.MACHINEID.trim(), Machine.MACHDESC.trim(), true, 10, 10, "center" );
             

          //   const MachineLabel = createDiv( "p", "", "rowTimesheet rotated font-weight-bold p-1 m-l-1 " , Machine.MACHDESC.trim());

       //  Section.appendChild( MachineColumn);
     // col1Div.appendChild( MachineLabel );
      col1Div.appendChild( MachineColumn );//Section);
     
  
  rowDiv.appendChild( col1Div );
 
  <!-- Grid second column -->
  const col2Div = createDiv( "DIV", "", "col-lg-11 text-center text-lg-left" , "");
      const Row = createDiv( "DIV", "", "row mb-3" , "");

           <!-- Grid First column -->
            const col1 = createDiv( "DIV", "", "col-2 border border-dark" , "");
            const Employee =   createDiv( "h6", "", "font-weight-bold" , "<br>Employee");
            col1.appendChild( Employee);
      Row.appendChild( col1);

             <!-- Grid Second column -->
            const col2 = createDiv( "DIV", "", "col-2 border border-dark" , "");
            const Scheduled = createDiv( "h6", "", "font-weight-bold" , "Scheduled <br> Start Time" );
            col2.appendChild( Scheduled);
      Row.appendChild( col2);

            <!-- Grid Third column -->
            const col3 = createDiv( "DIV", "", "col-2 border border-dark" , "");
            const Worked =   createDiv( "h6", "", "font-weight-bold" , "<br>Worked" );
            col3.appendChild( Worked);
      Row.appendChild( col3);

             <!-- Grid Forth column -->
            const col4 = createDiv( "DIV", Machine.MACHDESC.trim().replace(/ /g,''), "col-3 border border-dark" , "");
            const Difined =  createDiv( "h6", "", "font-weight-bold" , "Ask Each: Did you avoid a <br> difined under 6'event?" ); 
            col4.appendChild( Difined);
      Row.appendChild( col4);

             <!-- Grid Fith column -->
            const col5 = createDiv( "DIV","" , "col-3 border border-dark" , "");
            const Notes = createDiv( "h6", "", "font-weight-bold mb-3 " , "If No, Who? (and other notes)" );
            col5.appendChild( Notes );
      Row.appendChild( col5);

    let idMachine = Machine.MACHINEID.trim(); 
    let j = 0;   
    Machine.OPERATOR.forEach( (Operator, Index)=> {

        let divEmployee = createDiv( "DIV","" , "d-block p-0" , "");
            let Employee = createFormElement("input", "text", "rowTimesheet m-0  p-0", idMachine+"operator"+Index, idMachine+"operator"+ Index, Operator.LHOPER.trim(), true, 7, 7, "center" );
        divEmployee.appendChild(  Employee );

        let divstartTime = createDiv( "DIV","" , "d-block p-0" , "");
          let startTime = createFormElement("input", "text", "rowTimesheet m-0  p-0", idMachine+"starttime"+Index, idMachine+"starttime"+Index, Operator.STARTTIME.substr(11, 5), true, 5, 5, "center" );
        divstartTime.appendChild( startTime );

        let divWorked = createDiv( "DIV","" , "d-block p-0" , "");
            let  hWorked = differenceDateTime( Operator.STARTTIME, Operator.ENDTIME );
            let Worked =  createFormElement( "input", "text", "rowTimesheet  m-0  p-0", idMachine+"worked" + Index, idMachine+"worked" + Index, hWorked.Hours.toString()+"h:"+hWorked.Minutes.toString()+"m", false, 7, 7 ,"center" );
         divWorked.appendChild( Worked );
            Worked.title = "Pattern = 00h:00m";
            Worked.pattern = "[0-9]{1,2}h:[0-9]{1,2}m";

        let divDifined = createDiv( "DIV","" , "d-block p-0" , "");
            let Difinedyes =  createFormElement( "input", "radio", "rowTimesheet", idMachine+"difinedyes" + Index, idMachine+"difined" + Index, "YES", false, 0, 59 ,"center" );
            Difinedyes.checked = "checked";
            let DifinedlabelYes = createDiv( "LABEL", "", "rowTimesheet pl-1 pr-2 m-0" , "Yes ");

            let Difinedno =  createFormElement( "input", "radio", "", idMachine+"difinedno" + Index, idMachine+"difined" + Index, "NO", false, 0, 59 ,"center" );
            let DifinedlabelNo = createDiv( "LABEL", "", "rowTimesheet pl-1 m-0" , " No<br>");

        divDifined.appendChild(  Difinedyes );
        divDifined.appendChild(  DifinedlabelYes );
        divDifined.appendChild(  Difinedno );
        divDifined.appendChild(  DifinedlabelNo );
        
        let divNotes = createDiv( "DIV","" , "d-block p-0" , "");
          let Notes = createFormElement("input", "text", "rowTimesheet  m-0  p-0", idMachine+"Notes" + Index, idMachine+"Notes" + Index, "", false, 30, 40, "left" );
        divNotes.appendChild(  Notes );


        col1.appendChild( divEmployee );
        col2.appendChild( divstartTime );
        col3.appendChild( divWorked );

        col4.appendChild(  divDifined );
        col5.appendChild( divNotes );

       

        j++;

       
    }); 

  let labelTotalEmployees = createDiv( "LABEL", "", "rowTimesheet font-weight-bold pl-1 pr-2 m-0" , "Total employees: ");
  let machineTotal = createFormElement("input", "text", "font-weight-bold mr-5", idMachine+"machineTotal", idMachine+"machineTotal", j.toString().trim(), true, 4, 4, "left" );
  
  col2Div.appendChild( Row );
  col2Div.appendChild( labelTotalEmployees );
  col2Div.appendChild( machineTotal );

  bttnAddEmployee = createButtonAddEmployee( idMachine, Machine.OPERATOR.length, col1, col2, col3, col3, col4, col5 );
  col2Div.appendChild(  bttnAddEmployee );

  bttnRemoveEmployee = createButtonRemoveEmployee( idMachine );
  col2Div.appendChild(   bttnRemoveEmployee );

  rowDiv.appendChild( col2Div );
 // rowDiv.appendChild( machineTotal );

  form.appendChild( rowDiv );

  return form;
}

function addColumn(Type, idMachine, Index, nameColumn, Text, isReadonly, Size, maxSize){

    let divColumn = createDiv( "DIV","div" + idMachine + nameColumn + Index, "d-block p-0" , "");

    
    if ( Type == "radio") {

             let Difinedyes = createFormElement("input", Type, "rowTimesheet m-0  p-0", idMachine+nameColumn+Index, idMachine+ "difined"+Index, Text, isReadonly, Size, maxSize, "center" );
             Difinedyes .checked = "checked";
             let DifinedlabelYes = createDiv( "LABEL", "", "rowTimesheet pl-1 pr-2 m-0" , "Yes ");

             let Difinedno =  createFormElement( "input", "radio", "", idMachine+"difinedno" + Index, idMachine+"difined" + Index, "NO", false, 0, 59 ,"center" );
             let DifinedlabelNo = createDiv( "LABEL", "", "rowTimesheet pl-1 m-0" , " No<br>");

             divColumn.appendChild(  Difinedyes );
             divColumn.appendChild(  DifinedlabelYes );
             divColumn.appendChild(  Difinedno );
             divColumn.appendChild(  DifinedlabelNo );
             return divColumn; 

        } 
    
     let Column = createFormElement("input", Type, "rowTimesheet m-0  p-0", idMachine+nameColumn+Index, idMachine+nameColumn+Index, Text, isReadonly, Size, maxSize, "center" );


    if( nameColumn === "starttime") {
       Column.title = "Pattern = h:m";
       Column.pattern = "[0-9]{1,2}:[0-9]{1,2}";
       Column.placeholder = "h:m";

    }
    if (nameColumn === "worked" )
    {
      Column.title = "Pattern = 00h:00m";
      Column.pattern = "[0-9]{1,2}h:[0-9]{1,2}m";
      Column.placeholder = "Xh:Xm";

    }
 
    divColumn .appendChild(  Column );
    return divColumn;

}

function removeColumn(idMachine, Index) {

  $("#div"+idMachine + "operator" + Index).remove();
  $("#div"+idMachine + "starttime" + Index).remove();
  $("#div"+idMachine + "worked" + Index).remove();
  $("#div"+idMachine + "difinedyes" + Index).remove();
  $("#div"+idMachine + "notes" + Index).remove();
}

function  createButtonRemoveEmployee( idMachine ){

  let buttonRemove = document.createElement("button");
  buttonRemove.innerHTML = "Remove Employee";
  buttonRemove.setAttribute( "type", "button");
  buttonRemove.setAttribute("Class", "button-next" );

  buttonRemove.addEventListener("click", ()=> {

            let Index = parseInt(document.getElementById(idMachine+"machineTotal").value) - 1 ;
            removeColumn(idMachine, Index)
            document.getElementById(idMachine+"machineTotal").value = parseInt(Index);

           });

  return   buttonRemove;

}

function createButtonAddEmployee( idMachine, TotalEmployee, col1, col2, col3, col3, col4, col5 ){

  let buttonAdd = document.createElement("button");
  buttonAdd.innerHTML = "add Employee";
  buttonAdd.setAttribute( "type", "button");
  buttonAdd.setAttribute("Class", "button-next mr-3" );

  buttonAdd.addEventListener("click", ()=> {

         let Index = document.getElementById(idMachine+"machineTotal").value ;

         const divEmployee = addColumn( "text", idMachine, Index, "operator", "", false, 7, 7);
         col1.appendChild( divEmployee ); 

         const divstartTime =  addColumn( "text", idMachine, Index, "starttime", "", false, 5, 5);
         col2.appendChild( divstartTime );

         const divWorked = addColumn( "text", idMachine, Index, "worked", "", false, 7, 7);
          col3.appendChild( divWorked );

         const divDifined = addColumn( "radio", idMachine, Index, "difinedyes", "YES", false, 0, 59);
         col4.appendChild( divDifined );

         const divNotes = addColumn( "text", idMachine, Index, "notes", "", false, 30, 40);
          col5.appendChild( divNotes );

          document.getElementById(idMachine+"machineTotal").value = parseInt(Index) + 1;
    /*
        let divNotes = createDiv( "DIV","" , "d-block p-0" , "");
          let Notes = createFormElement("input", "text", "rowTimesheet  m-0  p-0", idMachine+"Notes" + Index, idMachine+"Notes" + Index, "", false, 30, 40, "left" );
        divNotes.appendChild(  Notes );
    */
  })  

  return buttonAdd;

}

function headForm( Text ){

  const mainDiv =  createDiv( "DIV", "", "container my-0 p-0 z-depth-1" , "");
  const Section = createDiv( "SECTION", "", "dark-grey-text" , "");

   <!-- Section heading -->
  const h = createDiv("h3", "", "text-center font-weight-bold mb-4 pb-2", Text );

  Section.appendChild(h);
   mainDiv.appendChild( Section );
   return ( mainDiv );

}

function unittestMachineOperators( myObj)
{
  myObj = [
      {  
         MACHINEID: "MACH01    ",
         MACHDESC: "End Trim 1               ",
         MACHFLTRQ: "Y",
         SCHEDULEDSTARTTIME: "2021-02-27-04.00.00",
         OPERATOR:  [ 
                      { ENDTIME: "2021-02-27-10.57.07.814000", LHOPER: "jareynaldo", STARTTIME: "2021-02-27-09.55.54.150000" },
                      { ENDTIME: "2021-02-27-11.56.04.688000", LHOPER: "Jose      ", STARTTIME: "2021-02-27-09.56.41.978000" },
                      { ENDTIME: "2021-02-27-12.57.07.814000", LHOPER: "Operator1 ", STARTTIME: "2021-02-27-09.55.54.150000" },
                      { ENDTIME: "2021-02-27-13.58.04.688000", LHOPER: "Operator2 ", STARTTIME: "2021-02-27-09.56.41.978000" },
                      { ENDTIME: "2021-02-27-14.57.07.814000", LHOPER: "jareynald1", STARTTIME: "2021-02-27-09.55.54.150000" },
                      { ENDTIME: "2021-02-27-09.58.04.688000", LHOPER: "Jose111111", STARTTIME: "2021-02-27-09.56.41.978000" },
                      { ENDTIME: "2021-02-27-09.57.07.814000", LHOPER: "Operator61", STARTTIME: "2021-02-27-09.55.54.150000" },
                      { ENDTIME: "2021-02-27-09.58.04.688000", LHOPER: "Operator9 ", STARTTIME: "2021-02-27-09.56.41.978000" }
                    ]  
                    
      },
      { 
        MACHINEID: "MACH02    ", 
        MACHDESC: "End Trim 2               ", 
        MACHFLTRQ: "Y", 
        SCHEDULEDSTARTTIME: "2021-02-27-04.00.00",
        OPERATOR:  [ 
                      { ENDTIME: "2021-02-27-09.57.07.814000", LHOPER: "jareynaldo", STARTTIME: "2021-02-27-09.55.54.150000" },
                      { ENDTIME: "2021-02-27-09.58.04.688000", LHOPER: "Jose      ", STARTTIME: "2021-02-27-09.56.41.978000" },
                      { ENDTIME: "2021-02-27-09.57.07.814000", LHOPER: "Operator1 ", STARTTIME: "2021-02-27-09.55.54.150000" },
                      { ENDTIME: "2021-02-27-09.58.04.688000", LHOPER: "Operator2 ", STARTTIME: "2021-02-27-09.56.41.978000" },
                      { ENDTIME: "2021-02-27-09.57.07.814000", LHOPER: "jareynald1", STARTTIME: "2021-02-27-09.55.54.150000" },
                      { ENDTIME: "2021-02-27-09.58.04.688000", LHOPER: "Jose111111", STARTTIME: "2021-02-27-09.56.41.978000" },
                      { ENDTIME: "2021-02-27-09.57.07.814000", LHOPER: "Operator61", STARTTIME: "2021-02-27-09.55.54.150000" },
                      { ENDTIME: "2021-02-27-09.58.04.688000", LHOPER: "Operator9 ", STARTTIME: "2021-02-27-09.56.41.978000" }
                    ] 
      },
      {
        MACHINEID: "MACH03    ",
        MACHDESC: "Glue Spreader            ", 
        MACHFLTRQ: "N",
        SCHEDULEDSTARTTIME: "2021-02-27-04.00.00",
        OPERATOR: Array()
      },
      {
        MACHINEID: "MACH04    ", 
        MACHDESC: "Itale Press              ", 
        MACHFLTRQ: "N", 
        SCHEDULEDSTARTTIME: "2021-02-27-04.00.00",
        OPERATOR: Array() 
      },
      {
        MACHINEID: "MACH05    ", 
        MACHDESC: "Sennersko Press          ", 
        MACHFLTRQ: "N", 
        SCHEDULEDSTARTTIME: "2021-02-27-04.00.00",
        OPERATOR: Array() 
      },
      {
        MACHINEID: "MACH06    ", 
        MACHDESC: "Side Trime               ", 
        MACHFLTRQ: "N", 
        SCHEDULEDSTARTTIME: "2021-02-27-04.00.00",
        OPERATOR: Array() 
      },
      {
        MACHINEID: "MACH07    ", 
        MACHDESC: "Splicer 1                ", 
        SCHEDULEDSTARTTIME: "2021-02-27-04.00.00",
        MACHFLTRQ: "N", OPERATOR: Array()
      },
      {
        MACHINEID: "MACH08    ", 
        MACHDESC: "Splicer 2                ", 
        SCHEDULEDSTARTTIME: "2021-02-27-04.00.00",
        MACHFLTRQ: "N", OPERATOR: Array()
     },
     {
        MACHINEID: "MACH09    ", 
        MACHDESC: "Splicer 3                ", 
        SCHEDULEDSTARTTIME: "2021-02-27-04.00.00",
        MACHFLTRQ: "N", OPERATOR: Array()
     }
 ];

 return myObj;
}


function addbodyTimesheet( machinesEmployees) {

   // Unit Testing 
     machinesEmployees = unittestMachineOperators( machinesEmployees );
  
  
   const form = createFormEndshift( reportTimesheets );
   formDiv = headForm( "Timesheet");
   form.appendChild( formDiv );

   for( Machine in machinesEmployees )
   {
      createSchemeTimesheet(form, machinesEmployees[Machine] );
      Break =  createDiv( "BR", "", "" , "");
      form.appendChild( Break );

   }
  const  machinesTotal = machinesEmployees.length; 
  const  totalRow = createFormElement( "input", "HIDDEN", "", "totalrow", "totalrow", machinesTotal); 
   form.appendChild( totalRow );

  createFormButtons(form);

  let oldForm = document.getElementById("Endshift");
  oldForm.insertAdjacentElement("beforebegin",  form );

 document.getElementById("btnPreview").addEventListener("click", viewEndshift);

  document.getElementById("btnNext").value = "Home";
  document.getElementById("btnNext").addEventListener("click", () => {
       document.getElementById('inquiry').value = "homeSupervisor";
        document.getElementById('Endshift').action = "ControllerInquiry.php";
        $("#Endshift").submit();
     });

  oldForm.remove();
}

// Show the Timesheet form at the end of the shift.

function viewTimesheet( Shift) {
   function updateBtnPrview() {

      document.getElementById("btnPreview").addEventListener("click", () => { 
          
           viewEndshift( Shift )

       })

   }

      myProduction( "../php/dailyEmployees.php?shift="+Shift)
        .then( addbodyTimesheet )
        .then(updateBtnPrview)
        .catch( err => alert( err ) );

    /*
    Next = document.getElementById("btnPreview");
    Next.addEventListener("click", ( ) => { 

          viewEndshift(Shift1);

       });  */

}





$(document).ready(function(){

      
      
})