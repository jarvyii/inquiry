$(document).ready(function(){

  /********************************
      Set the Header  Content of the Tracking Information screen
      seTIBody()
  ************************************/
  function setOrderHeader( ){ 
      var jsonURL ="../data/ehm.json";
      var usersFormat ={
                        format: "json"
                       };
        // /FUNCTION getHead()
       function getHead(Data) {
            $.each(Data,function(i, Order) {
                 if (document.getElementById("ordernumber").value !=Order["EHORD"]){
                    // Return until find the correct order number
                   return false;
                  }
                  document.getElementById("input-customer").value =  Order["EHCT#"];
                  document.getElementById("input-orderdate").value =  Order["EHORDT"];
                  return false;
              })
          }  //  \FUNCTION getHead()

        $.getJSON(jsonURL, usersFormat,  getHead );

        return false; 
     }   // \FUNCTION setOrderHeader()
  /***********************************
         function setOrderItem( )
  ***********************************/
  function setOrderItem( ){
         var jsonURL ="../data/eim.json";
         var usersFormat ={
                           format: "json"
                          };
           // /FUNCTION getHead()
          function getHead(Data) {
                $.each(Data,function(i, Order) {
                    if (document.getElementById("ordernumber").value !=Order["EIORD"]){
                       // Return until find the correct order number
                      return false;
                     }
                  
                     document.getElementById("input-orderqty").value = Order["EIOCQ"];
                     document.getElementById("input-ordercmpted").value = Order["EICCQ"];
                     document.getElementById("input-orderneeded").value = Order["EICCQ"];
                     document.getElementById("input-item").value = Order["EIPN"];
                     document.getElementById("icomments").value = Order["EILID"];
                     document.getElementById("ocomments").value = Order["EIPNT"];
                     return false;
                 })
             }  //  \FUNCTION getHead()

           $.getJSON(jsonURL, usersFormat,  getHead );

           return false;
        }   // \FUNCTION setOrderHeader()

  /*********************************************************************************
  Write in the DOM the Content of the Tracking
  FUNCTION TrackingInformation()().
  *********************************************************************************/
  function TrackingInformation(){
     //setOrderHeader();
     //setOrderItem();
     nameTraveler = document.getElementById("ordernumber").value;
     document.getElementById("pdftraveler").href = "../pdf/"+nameTraveler+".pdf";
  } // \FUNCTION TrackingInformation()

   /**********************
   * Print the PDF to the default Printer
   */
  $('#printpdf').click(function () {
     var pdfName = document.getElementById("ordernumber").value+'.pdf';
    printJS({printable:'/pdf/'+pdfName, type:'pdf', showModal:true})
  })// /('#printpdf').click(function())

  /************************************************************************
  Main Block
***********************************************************************/

TrackingInformation();
//Asign the physical URL of the specific pdf Traveler to the Button
var pdfNameLink = '../pdf/'+document.getElementById("ordernumber").value+'.pdf';
document.getElementById("pdftraveler").href = pdfNameLink;
}); // End ready
