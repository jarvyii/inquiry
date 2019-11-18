<?php
require_once 'inquiry.php';
if (isset($_POST['inquiry']) && ! isset($_GET['q'])) {
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
    case 'Checkorder': return(checkOrder());  
    case 'Production': if(isset($_POST['operator'])) {
                          var_dump($_POST['qtyproduced']);
                          endProduction($_POST['operator'], $_POST['barcode'], $_POST['machine'],  
                                         $_POST['starttime'], $_POST['endtime'], (int)$_POST['qtyproduced']);  
                          tracking($_POST['operator']);
                        }
                        
                       break;

     }
  } else {
      switch($_GET['q']) {
          case 'Display'   :  return getLocHistory($_GET['order']);
          case 'Checkorder':  if (isset($_GET['barcode'])) {
                                 $Barcode = $_GET['barcode'];
                                 $Pos = strpos($Barcode, "/");
                                 $Order= substr($Barcode,0, $Pos);
                                 return checkOrder($Order);
                                } 
          }
        
      }



?>