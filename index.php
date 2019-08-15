<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <title>Inquiry System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/inquiry.css">
    <link rel="stylesheet" href="css/login.css">
  </head>
<body id="home">
      <div class="header">
        <!-- Main jumbotron for a  Logo Image about the Company-->
            <div class="container">
              <div class="jumbotron bg-white" id="jumbotron">
                  <img class="img-responsive img-fluid mx-auto d-block" width="60%" height="52" src="img/flexiblematerial-bl.png"  alt="Flexible Material">
              </div> <!-- /jumbotron -->
            </div> <!-- /Container-->
      </div>
      <div class="container">
            <!-- Login form. It validate the User and password with the file USERS.JSON -->
            <form id="loginform" method="post" action="php/inquiry.php" runat="server">
                  <input type="hidden" name="inquiry" value="Login"/>
                  <div class="imgcontainer">
                      <img src="img\login.jpg" alt="Login now" class="avatar">
                  </div>
                  <div class="row logininput">
                      <div>
                        <label for="user-name"><b>User name:</b></label>
                        <input id="user-name"  autocomplete="username" type="text" placeholder="Enter User Name" name="username" required>
                      </div>
                      <div>
                        <label for="user-password"><b>Password:</b></label>
                        <input id="user-password" autocomplete="current-password" type="password" placeholder="Enter Password" name="psw" required>
                      </div>
                    </div>
                    <div class="container d-flex justify-content-center" style="background-color:#f1f1f1">
                        <button id="buttonlogin" class="btn" type="submit">Login</button>
                        <button id="buttoncancel" class="btn cancelbtn" type="button">Cancel</button>
                    </div>
            </form>
            <!-- Body -->
      </div>      
      <div class="footer">
           <!-- Copyright -->
            &copy; 2019 Inquiry Sysemt 1.0 <a id="user-nav" href="//www.minimaxinfo.com" target="_blank"> &amp; <bold>mini-MAX Information Systems, Inc.</bold></a>
           <!-- Copyright -->
      </footer>
    <script src="js/inquiry.js"></script>
  </body>
</html>
