<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="css/loginStyle.css"/>
    <link rel="shortcut icon" href="img/favicon.ico"/>
    <script type="text/javascript" src="js/jquery.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous"/>
    <link rel="stylesheet" href="css/bootstrap-theme.min.css" crossorigin="anonymous"/>
    <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/login.js"></script>
  </head>
  <body>
    <div class="jumbotron vertical-center">
      <div class="container text-center" style="width: 40%;">
        <h2 style="font-family: Verdana;">Login</h2>
        <div class="input-group">
          <span class="input-group-addon" id="addonEmail"><span class="glyphicon glyphicon-user"></span></span>
          <input type="email" class="form-control" placeholder="Email" aria-describedby="addonEmail" id="email" required=""/>
        </div>
        <div class="input-group">
          <span class="input-group-addon" id="addonLock"><span class="glyphicon glyphicon-lock"></span></span>
          <input type="password" class="form-control" placeholder="Password" aria-describedby="addonLock" id="password" required=""/>
        </div><hr />
        <button type="button" class="btn btn-default" style="margin-bottom: 15px; width: 50%;" onclick="sendData()"><strong>Go</strong></button>
      </div>
    </div>
  </body>
</html>