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
</head>
<body class="fixed-sn  white">

  <!-- Start your project here-->
  
<header>
  <!-- Logo -->
 <li class="logo-sn waves-effect">

              <div class=" text-center">
                  <a href="#" class="pl-0">
                      <img src="img/flexiblematerial-bl.png" width = "30%" class="img-fluid">
                  </a>
              </div>
 </li>
 
 

</header>


<!--Main layout-->
<main class ="pl-1 pt-3">
  <div class="container-fluid">

      
      <!--Section: Modals-->
        <section>

            <!--Modal: modalConfirmDelete-->
            <div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
                    <!--Content-->
                    <div class="modal-content text-center">
                        <!--Header-->
                        <div class="modal-header d-flex justify-content-center">
                            <p class="heading">Are you sure?</p>
                        </div>

                        <!--Body-->
                        <div class="modal-body">

                            <i class="fas fa-times fa-4x animated rotateIn"></i>

                        </div>

                        <!--Footer-->
                        <div class="modal-footer flex-center">
                            <a href="https://mdbootstrap.com/pricing/jquery/pro/" class="btn btn-danger">Yes</a>
                            <a type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">No</a>
                        </div>
                    </div>
                    <!--/.Content-->
                </div>
            </div>
            <!--Modal: modalConfirmDelete-->

        </section>
        <!--Section: Modals-->
      

      <!--Section: Main panel-->
      <section class="card card-cascade narrower  mb-5">

         <!--Grid row-->
            <div class="row">
           <!-- Table -->
           <!--Top Table UI-->
                <!--Card-->
                <div class=" col-md-5 card p-2 card-cascade narrower">

                    <!--Card header-->
                       <div  class="view view-cascade py-3 gradient-card-header indigo darken-4 mx-4 d-flex justify-content-between align-items-center">

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
                                      <tr>
                                          <th>Machine</th>
                                          <th>Orders</th>
                                          <th>Machine Time</th>
                                          <th>Qty Produced</th>
                                      </tr>
                                    </thead>
                                  <tbody id = "dashboardrow">
                                     
                                  </tbody>
                              </table>
                            </div>
                            <hr class="my-0">
                        </div>
                        <!--/.Card content-->

                </div>
                <!--/.Card-->
              <!-- Table-->

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
  </div>
</main>
<!--Main layout-->

<!-- Footer -->
<footer class="page-footer font-small indigo darken-4 fixed-bottom pl-0 ">

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">&copy; 2020 Inquiry System 2.0 &amp;
    <a id="user-nav" href="//www.minimaxinfo.com" target="_blank">mini-MAX Information Systems, Inc.</a>       
  </div>
  <!-- Copyright -->
</footer>
<!-- Footer -->


  
  <!-- End your project here-->

  <!-- jQuery -->
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="js/mdb.min.js"></script>
  <script type="text/javascript" src="js/dashboard.js"> </script>
  

</body>
</html>
