<?php

/******************************
  View  function Head()
*******************************/
function Head()
 { ?>
   <!DOCTYPE html>
   <html lang="en">
   <head>
   <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
   <title>Inquiry System</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <script src="//printjs-4de6.kxcdn.com/print.min.js"></script>
   <link rel="stylesheet" type="text/css" href="https://printjs-4de6.kxcdn.com/print.min.css"> 
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="../css/inquiry.css">
  
    </head>
   <body id="home">
     <!-- Main jumbotron for a  Logo Image about the Company-->
     <div class="container">
       <div class="jumbotron bg-white" id="jumbotron">
           <img class="img-responsive  img-fluid mx-auto d-block" width="60%" height="52" src="../img/flexiblematerial-bl.png"  alt="Flexible Material">
       </div> <!-- /jumbotron -->
     </div> <!-- /Container-->
<?php
}

/*****************************************
   Foot function Foot()
*****************************************/
function Foot()
{
  ?>
  <div class="footer">
           <!-- Copyright -->
           &copy; 2019 Inquiry System 1.0 &amp; <a id="user-nav" href="//www.minimaxinfo.com" target="_blank">mini-MAX Information Systems, Inc.</a>
           <!-- Copyright -->
      </footer>
  <script src="../js/inquiry.js"></script>
</body>
</html> <?php
} 