<?php include("db_con.php");
      session_start();
  if(isset($_SESSION['email'])){
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8"/>
    <title>Admin Interface</title>
    <link rel="stylesheet" href="css/adminStyle.css"/>
    <link rel="shortcut icon" href="img/favicon.ico"/>
    <script type="text/javascript" src="js/jquery.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous"/>
    <link rel="stylesheet" href="css/bootstrap-theme.min.css" crossorigin="anonymous"/>
    <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/admin.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      
      $(document).ready(function(){
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
      });

      function drawChart() {
        function refreshData () {
          $.post("ajax.php",{
            initCharts : 1,
          },function(data,status){
            data = JSON.parse(data);
            var resultHumidity = [],resultTemperature = [],resultButan = [],resultAtm = [],resultMotion = [],resultCo = [];
            resultHumidity[0] = resultTemperature[0] = resultButan[0] = resultAtm[0] = resultMotion[0] = resultCo[0] = ['Secunde','Valoare Senzor'];
            for(i = 0; i < 60; i++){
              resultHumidity.push([String(i+1),Number(data[i]["humidity"])]);
              resultTemperature.push([String(i+1),Number(data[i]["temp"])]);
              resultButan.push([String(i+1),Number(data[i]["butan_gas"])]);
              resultAtm.push([String(i+1),Number(data[i]["atm_quality"])]);
              resultMotion.push([String(i+1),Number(data[i]["motion"])]);
              resultCo.push([String(i+1),Number(data[i]["co"])]);
            }
            var dataHumidity = google.visualization.arrayToDataTable(resultHumidity);
            var dataTemperature = google.visualization.arrayToDataTable(resultTemperature);
            var dataButan = google.visualization.arrayToDataTable(resultButan);
            var dataAtm = google.visualization.arrayToDataTable(resultAtm);
            var dataMotion = google.visualization.arrayToDataTable(resultMotion);
            var dataCo = google.visualization.arrayToDataTable(resultCo);
            var optionsHumidity = {
              title: 'Umiditate',
              curveType: 'function'
            };
            var optionsTemperature = {
              title: 'Temperatură',
              curveType: 'function',
              colors : ['red','#004411']
            };
            var optionsButan = {
              title: 'Gaz butan',
              curveType: 'function',
              colors : ['grey','#d3d3d3']
            };
            var optionsAtm = {
              title: 'Calitatea aerului',
              curveType: 'function',
              colors : ['green','#f1ca3a']
            };
            var optionsMotion = {
              title: 'Mișcare/Vibrații',
              curveType: 'function',
              colors : ['orange','#1c91c0']
            };
            var optionsCo = {
              title: 'Monoxid de carbon',
              curveType: 'function',
              colors : ['black','#fff']
            };
            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            var chart1 = new google.visualization.LineChart(document.getElementById('curve_chart1'));
            var chart2 = new google.visualization.LineChart(document.getElementById('curve_chart2'));
            var chart3 = new google.visualization.LineChart(document.getElementById('curve_chart3'));
            var chart4 = new google.visualization.LineChart(document.getElementById('curve_chart4'));
            var chart5 = new google.visualization.LineChart(document.getElementById('curve_chart5'));
            chart.draw(dataHumidity, optionsHumidity);
            chart1.draw(dataTemperature, optionsTemperature);
            chart2.draw(dataButan,optionsButan);
            chart3.draw(dataAtm,optionsAtm);
            chart4.draw(dataMotion,optionsMotion);
            chart5.draw(dataCo,optionsCo);
          });
        }

        refreshData();
        setInterval(refreshData, 1000);
                                     
      }
    </script>
  </head>
  <body>
      <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Home Alert</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <div class="navbar-form navbar-right" id="defaultValues" style="display:none;">
            <div class="form-group">
              <input id="addValues" type="text" class="form-control" required=""/>
            </div>
            <button id="go" onclick="setValues()" type="submit" class="btn btn-default">Go</button>
          </div>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Meniu<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="register.php">Adăugați utilizator(Înregistrare)</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#" id="edit" onclick="appear()">Editați valorile default ale senzorilor</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#" onclick="changeToken()">Schimbați aparamentul</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <center>
      <h2>Bine ați venit în interfața de administrare !</h2>
      <br />
      <div>
        <input readonly="" id="humidity" style="padding: 20px 10px; line-height: 28px; text-align: center; border-radius: 15px;"/>
        <input readonly="" id="temperature" style="padding: 20px 10px; line-height: 28px; text-align: center; border-radius: 15px;"/>
        <input readonly="" id="butan" style="padding: 20px 10px; line-height: 28px; text-align: center; border-radius: 15px;"/>
        <input readonly="" id="air" style="padding: 20px 10px; line-height: 28px; text-align: center; border-radius: 15px;"/>
        <input readonly="" id="motion" style="padding: 20px 10px; line-height: 28px; text-align: center; border-radius: 15px;"/>
        <input readonly="" id="co" style="padding: 20px 10px; line-height: 28px; text-align: center; border-radius: 15px;"/>
      </div>
      <hr />
      <div id="control" class="btn-group" role="group">
        <button id="on_off1" onclick="on_off(1,'1')" type="button" class="btn btn-default"><span class="glyphicon glyphicon-off"></span> Curent</button>
        <button id="on_off2" onclick="on_off(2,'1')" type="button" class="btn btn-default"><span class="glyphicon glyphicon-off"></span> Gaz</button>
        <button id="on_off3" onclick="on_off(3,'1')" type="button" class="btn btn-default"><span class="glyphicon glyphicon-off"></span> Stingător</button>
        <button id="on_off4" onclick="on_off(4,'1')" type="button" class="btn btn-default"><span class="glyphicon glyphicon-off"></span> Ventilație</button>
        <button id="on_off5" onclick="on_off(5,'1')" type="button" class="btn btn-default"><span class="glyphicon glyphicon-off"></span> Alarmă</button>
      </div>
      <hr />
      <div id="alerts"></div>
      <div>
        <div id="curve_chart" style="width: 650px; height: 400px; float: left;"></div>
        <div id="curve_chart1" style="width: 650px; height: 400px; float: left;"></div>
        <div id="curve_chart2" style="width: 650px; height: 400px; float: left;"></div>
        <div id="curve_chart3" style="width: 650px; height: 400px; float: left;"></div>
        <div id="curve_chart4" style="width: 650px; height: 400px; float: left;"></div>
        <div id="curve_chart5" style="width: 650px; height: 400px; float: left;"></div>
      </div>
      <button style="position:fixed;bottom:15px;right:10%;margin:0;padding:5px 3px; width:80%;" class="btn btn-default navbar-btn" onclick="logout()"><strong>Logout</strong></button>
    </center>
  </body>
</html>
<?php } else{
  session_start();
  session_destroy();
  header("Location: login.php");
} ?>