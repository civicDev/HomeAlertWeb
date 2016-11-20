<?php include("db_con.php");
      session_start();
  if(isset($_SESSION['email'])){
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8"/>
    <title>Register</title>
    <link rel="stylesheet" href="css/registerStyle.css"/>
    <link rel="shortcut icon" href="img/favicon.ico"/>
    <script type="text/javascript" src="js/jquery.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous"/>
    <link rel="stylesheet" href="css/bootstrap-theme.min.css" crossorigin="anonymous"/>
    <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/register.js"></script>
  </head>
  <body>
    <div class="jumbotron vertical-center">
      <div class="container text-center" style="width: 40%;">
        <h2 style="font-family: Verdana;">Register</h2>
        <div class="input-group">
          <span class="input-group-addon" id="addonEnvelope"><span class="glyphicon glyphicon-envelope"></span></span>
          <input type="email" class="form-control" placeholder="Your email here" aria-describedby="addonEnvelope" id="email"/>
        </div>
        <div class="input-group">
          <span class="input-group-addon" id="addonPhone"><span class="glyphicon glyphicon-phone"></span></span>
          <input type="text" class="form-control" placeholder="Enter your phone number" aria-describedby="addonPhone" id="phone"/>
        </div>
        <div class="input-group">
          <span class="input-group-addon" id="addonLock"><span class="glyphicon glyphicon-lock"></span></span>
          <input type="password" class="form-control" placeholder="Set a password" aria-describedby="addonLock" id="password"/>
        </div>
        <div class="input-group">
          <span class="input-group-addon" id="addonLock1"><span class="glyphicon glyphicon-lock"></span></span>
          <input type="password" class="form-control" placeholder="Confirm password" aria-describedby="addonLock1" id="confirmPassword"/>
        </div><hr />
        <button type="button" class="btn btn-default" style="margin-bottom: 15px; width: 50%;" onclick="sendData()"><strong>Go</strong></button>
      </div>
    </div>
  </body>
</html>
<?php } else{
  session_start();
  session_destroy();
  header("Location: login.php");
} ?>