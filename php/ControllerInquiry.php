<?php
require_once 'inquiry.php';
if (isset($_POST['inquiry'])) {
  switch($_POST['inquiry']){
    case 'Login': tracking($_POST['username']);
                  break;
    case 'Tracking':  Production($_POST['barcode'], $_POST['machine'],$_POST['operator']);
                      //TrackingInquiry($_POST['barcode'], $_POST['machine'],$_POST['operator']);
                     break;
    case 'TrackingInquiry': if(isset($_POST['ordernumber']) and isset($_POST['linenumber'])){
                              $OrderNumber = $_POST['ordernumber'];
                              $LineNumber = $_POST['linenumber'];
                              //$Machine = $_POST['machine'];
                              $Operator = $_POST['operator'];
                              TrackingInformation( $OrderNumber,$LineNumber, $Operator);
                              //TrackingDisplay( $OrderNumber,$LineNumber);
                            }
                            break;
    case 'TrackingInformation':if(isset($_POST['ordernumber']) and isset($_POST['linenumber'])){
                              $OrderNumber = $_POST['ordernumber'];
                              $LineNumber = $_POST['linenumber'];
                              TrackingDisplay( $OrderNumber,$LineNumber);
                             }
                            break;
    case 'Display': return ( getLocHistory());    
    case 'Production': if(isset($_POST['operator'])) {
                          endProduction($_POST['operator'], $_POST['barcode'], $_POST['machine'],  
                                         $_POST['starttime'], $_POST['endtime']);  
                          tracking($_POST['operator']);
                        }
                        
                       break;

     }
  } else {
    
         if (isset($_GET['q'])) {
           return getLocHistory($_GET['order']);

          //return ( getLocHistory($_GET['order']));

         }
       //echo "Voyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy";
      // var_dump($_GET);
  }



?>