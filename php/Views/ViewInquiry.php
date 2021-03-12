<?php

/******************************
  View  function Head()
*******************************/
function Head(  $sBody ="" , $sColumn ="")
 { ?>
   <!DOCTYPE html>
   <html lang="en">
   <head>
   <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
   <title>Inquiry System</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- Forced the browser not to use cache memory -->
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <!-- End  -->
   <script src="//printjs-4de6.kxcdn.com/print.min.js"></script>
   <link rel="stylesheet" type="text/css" href="https://printjs-4de6.kxcdn.com/print.min.css"> 
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
   <script src="https://cdn.rawgit.com/JDMcKinstry/JavaScriptDateFormat/master/Date.format.min.js"></script>
   <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <link rel="stylesheet" href="../css/inquiry.css">
    </head>
   <body id="home">
     <!-- Main jumbotron for a  Logo Image about the Company-->
     <div class="container">
      <div class="row">
       <div class=" col-9 jumbotron bg-white" id="jumbotron">
           <img class="img-responsive  img-fluid mx-auto logo d-block" width="50%" height="52" src="../img/flexiblematerial-bl.png"  alt="Flexible Material">
          <?php
          echo $sBody;
          ?> 
       </div> <!-- /jumbotron -->
       <div class="col-3">
     <?php    
        echo $sColumn;
     ?>   
       </div> 
      </div>
     </div> <!-- /Container-->
<?php
}

/*****************************************
   Foot function Foot()
*****************************************/
function Foot( $newScript="")
{
  ?>
  <div class="footer">
           <div class=" row">
             <div class="col-1">
             </div>
             <div class="col-10">
               <!-- Copyright -->
                &copy; 2021 Inquiry System 2.0 &amp; <a id="user-nav" href="//www.minimaxinfo.com" target="_blank">mini-MAX Information Systems, Inc.</a>
               <!-- Copyright -->
             </div>
             <div class="col-1">
               <a id="exit-nav" class="exit-image navbar-brand order-1" href="index.php" target="_blank">
                        <img id="image-exit-nav" src="..\img\Exit.png" width="30" height="30" alt="Exit"></a>
             </div>
           </div>
      </div>

  
 
 <script>
  
  function myCost( sIdHour, sIdMin,sidHourRate, sIdCost, sIdSqf ) {
     
    var Minutes = parseInt( document.getElementById(sIdHour).value)*60 + parseInt(document.getElementById(sIdMin).value);
    var Rate = parseFloat(document.getElementById(sidHourRate).value.trim().substr(1));

    var Value = Minutes * Rate;


     var sqftProduce = parseFloat( document.getElementById(sIdSqf).value);
     var Cost = 0.00;

     if ( sqftProduce != 0 ){

      Cost = ( Value/sqftProduce  ) / 60;
  
     }
     
    document.getElementById(sIdCost).value =  Cost.toFixed(2);
 }
 </script>
 <!-- <script src="https://code.jquery.com/jquery-3.1.0.js"></script> -->
<script src="../js/inquiry.js"></script> <?php
echo $newScript; ?>
   
</body>
</html> <?php
} 