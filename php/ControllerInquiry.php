<?php
require_once 'inquiry.php';
 
if (isset($_POST['inquiry']) && ! isset($_GET['q'])) {

  switch($_POST['inquiry']){
    case 'Login': Tracking($_POST['username'], 0);
                  break;
    case 'Tracking':
                  	  if ( isset($_POST['panel']) ) {
                  	  	$Panel = $_POST['panel'];
                  	  } else {
                  	  	$Panel ="";
                  	  }
                  	
                     Production($_POST['barcode'], $_POST['machine'],$_POST['operator'], $_POST['selectindex'], $Panel);
                            
                      //TrackingInquiry($_POST['barcode'], $_POST['machine'],$_POST['operator']);
                     break;
    case 'homeSupervisor' : 
                              TrackingInquiry($_POST['operator'], '' );
                              break;                
    case 'TrackingInquiry':   $sLink = htmlspecialchars( $_POST['linkbutton'] ) ;
                              /* echo  $sLink;
                              foreach ( $_POST as $i => $C ) {
                                 echo "i:".$i. "c:". $C;
                              } */
                              if ( $sLink == 'sendemail') {
                                  //sendEmail();
                                  createPDF();
                                  return;
                              }

                            if(isset($_POST['barcode'])){
                              $OrderNumber = $_POST['barcode'];
                              //$Machine = $_POST['machine'];
                              $Operator = $_POST['operator'];
                              TrackingInformation( $OrderNumber,$Operator);
                              //TrackingDisplay( $OrderNumber,$LineNumber);
                            }
                            break;
    case 'TrackingInformation':
                              $OrderNumber = htmlspecialchars($_POST['ordernumber']);
                              $LineNumber = htmlspecialchars( $_POST['linenumber']);
                              $Operator = htmlspecialchars($_POST['operator']);
                              $Link = htmlspecialchars( $_POST['linkbutton'] ) ;
                              $Order =  $OrderNumber."/". $LineNumber;
                              if ( $Link == 'home') {
                                  TrackingInquiry(  $Operator,  $Order);
                              } else {
                                    if(isset($OrderNumber) and isset($LineNumber)){
                                       $Customer = $_POST['customer'];
                                        $orderDate = $_POST['orderdate'];
                                        $orderQtty = $_POST['orderqtty'];
                                        $Item =  $_POST['item'];
                                         
                                     
                                        TrackingDisplay( $OrderNumber,$LineNumber, $Customer, $orderDate, $orderQtty, $Item, $Operator);
                                      }
                              }
                              
                            break;
    case 'TrackingDisplay'  :
                              $Order = htmlspecialchars( $_POST['order'] ) ;
                              $Operator = htmlspecialchars($_POST['operator']) ;
                              $Link = htmlspecialchars( $_POST['linkbutton'] ) ;
                              if ( $Link == 'home') {
                                 TrackingInquiry( $_POST['operator'], $_POST['order']);
                              } else {
                                  TrackingInformation( $Order,$Operator);
                              }
                             
                             break;                        
    case 'Display': return ( getLocHistory());  

    case 'Checkorder': return(checkOrder()); 

    case 'Production':  
                        if( ! isset($_POST['operator']) ) {
                           echo "Error: No user logged to the system.";
                            return;
                        }
                        $userName = $_POST['operator'];
                        $Operator = $_POST['operator'];

                        $selectedIndex = isset( $_POST['selectindex'] ) ? $_POST['selectindex']: 0 ;
                        
                        tracking($userName, $selectedIndex);
                        break;
  }                     
} else {

        switch($_GET['q']) {

          
          case 'Machprod'  :
                            MachinesProd(); // return all Production info per machine;
                            break;
                           
          case  	'Home'	:
              						TrackingInquiry($_GET['operator'], $_GET['order'] );
              						break; 
          case 'assignloc'	: 
                              return assignLoc(  $_GET['order'], $_GET['line'], $_GET['loc'] );
          					      break;
          case 'Shiftsorder':  
                  					  return shiftsOrder(  $_GET['order'], $_GET['line'] );

                   					  break ;	
          case 'Dailyprod': // To know the Daily Production per machine


                             $db = new DataAccess();
                             $Shift = $db->getShift();

                             
                             
                             $P =  getdailyProd( $Shift );

                             echo json_encode($P);
                             // echo  $P;
                             return $P;
                      
          case 'Production': 

                              $P =  getdailyOrders( $_GET['idmachine'] );
                             echo  $P;
                             return $P;
          case 'Machines'  :
                            return Machines();
                            break;
          case 'Traveler'  :
                            
                            callPrintTraveler( $_GET['order'], $_GET['line']);
                            break;
          case 'Display'   :  
                              return getLocHistory($_GET['order'], $_GET['line']);
          case 'Checkorder':  if (isset($_GET['barcode'])) {
                                 $Barcode = $_GET['barcode'];
                                 $Pos = strpos($Barcode, "/");
                                 $Order= substr($Barcode,0, $Pos);
                                 $LineNumber =  substr($Barcode, $Pos+1);
                                 return checkOrder($Order, $LineNumber);
                                }
                                break;
           case 'Override' :  
                              if (! isset($_GET['code'])) {
                                 return "";
                              }

                              $Code = htmlspecialchars($_GET['code']);
                            
                             return checkOverrideCode($Code);                   
          }
        
      }



?>