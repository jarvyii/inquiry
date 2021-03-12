<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>FLEX Tracking System</title>
  <!-- MDB icon -->
  <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <!-- Google FLo onts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Material Design Bootstrap -->
  <link rel="stylesheet" href="css/mdb.min.css">
  <!-- Your custom styles (optional) -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/inquiry.css">
</head>
<body class="fixed-sn  white">

  <!-- Start your project here-->
  
<header>
  <!-- Logo -->
 <div class="logo-sn waves-effect">
    <div class="text-center pt-2">
        <a href="#" class="pl-0">
            <img src="img/flexiblematerial-bl.png" width = "30%" class="img-fluid">
        </a>
    </div>
 </div>
</header>
<!-- Modal -->
<div
  class="modal fade"
  id="modalMachineOrders"
  tabindex="-1"
  aria-labelledby="modalMachineOrdersLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header flexcolor text-white">
        <h5 class="fw-bold modal-title  center " id="modalMachineOrdersLabel">Modal title</h5>
        <button
          type="button"
          class="btn-close button-next"
          data-mdb-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <div class = "row">
           <div  class="col-3 text-center"><strong>Operator</strong><hr><div id="operator"></div></div>
           <div  class="col-3 text-center"><strong>Order</strong><hr><div id ="order"></div></div>
           <div class="col-3 text-center"><strong>Qty</strong><hr><div id="qty" ></div></div>
           <div  class="col-3 text-center"><strong>Time</strong><hr><div  id="time"></div></div>

        </div>  
     
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<!--Main layout-->
<main class ="pl-1 pt-3">
  <div class="container-fluid">
      <!--Section: Main panel-->
      <section class="card card-cascade narrower  mb-5">

         <!--Grid row-->
            <div class="row">
           <!-- Table -->
           <!--Top Table UI-->
                <!--Card-->
                <div class=" col-md-5 card p-2 card-cascade narrower">

                    <!--Card header-->
                       <div  class="view view-cascade flexcolor py-3 gradient-card-header  mx-4 d-flex justify-content-between align-items-center">

                            <div>
                                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2">
                                    <i class="fas fa-th-large mt-0"></i>
                                </button>
                                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2">
                                    <i class="fas fa-columns mt-0"></i>
                                </button>
                            </div>

                            <a href="" class="white-text mx-3">Table name</a>

                            <div>
                                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2">
                                    <i class="fas fa-pencil-alt mt-0"></i>
                                </button>
                                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2" data-toggle="modal" data-target="#modalConfirmDelete">
                                    <i class="fas fa-times mt-0"></i>
                                </button>
                                <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2">
                                    <i class="fas fa-info-circle mt-0"></i>
                                </button>
                            </div>

                          </div>
                          <!--/Card header-->
                    <!--/Card header-->

                    <!--Card content-->
                        <div class="card-body">
                           <div class="table-responsive">
                            <table class="table text-nowrap">
                                  <thead>
                                      <tr >
                                          <th class = "text-center pt-0 pb-0">Machine</th>
                                          <th class = "text-center pt-0 pb-0">Orders</th>
                                          <th class = "text-center pt-0 pb-0">Machine Time</th>
                                          <th class = "text-center pt-0 pb-0">Qty Produced</th>
                                      </tr>
                                    </thead>
                                  <tbody id = "dashboardrow">
                                     
                                  </tbody>
                              </table>
                            </div>
                            <hr class="my-0">
                        </div>
                        <!--/.Card content-->
                <!--/.Card-->
              <!-- Table-->
                   
                  </div>   
             <!-- Table -->
            <!--Grid column-->
            <div class="col-md-7">

                <!--Grid column Graph Chart-->
                <!--Panel Header-->
                <!--class="view view-cascade py-3 gradient-card-header info-color-dark mb-4" -->
                    <div class="view view-cascade py-3 gradient-card-header  mb-4 " >

                      <canvas id="barChart"></canvas>


                    </div> 
                    <!--/Card image-->
                <!--Grid column   Graph Chart-->
            </div>
            <!--Grid column-->
            </div>
            <!--Grid row-->
      </section>
      <!--Section: Main panel-->
    <!-- Modal to show all orders in one specific Machine  -->
  </div>
  <!-- The Modal -->
</main>
<!--Main layout-->

<!-- Footer -->
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
<!-- Footer -->
  <!-- End your project here-->

  <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script> <!-- jQuery -->
  <script src="https://cdn.rawgit.com/JDMcKinstry/JavaScriptDateFormat/master/Date.format.min.js"></script>
 
  <script type="text/javascript" src="js/popper.min.js"></script> <!-- Bootstrap tooltips -->
 
  <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
  <script type="text/javascript" src="js/bootstrap.min.js"></script>  <!-- Bootstrap core JavaScript -->
 
  <script type="text/javascript" src="js/mdb.min.js"></script>    <!-- MDB core JavaScript --> 
 
  <script type="text/javascript" src="js/dashboard.js"> </script>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>
</body>
</html>
