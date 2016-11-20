<?php include("db_con.php");
      session_start();

  if(isset($_POST["sendLoginData"])){
    $email = mysqli_real_escape_string($con,$_POST["email"]);
    $password = mysqli_real_escape_string($con,$_POST["password"]);
    $select_user = mysqli_query($con,"SELECT * FROM `user` WHERE `email` = '$email' AND `password` = '$password'");
    if(mysqli_num_rows($select_user)){
      $user = mysqli_fetch_assoc($select_user);
      $_SESSION['token'] = $user['token'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['phone'] = $user['phone'];
    } else echo 0;
  }
  
  if(isset($_POST["logout"])){
    session_start();
    session_destroy();
  }
  
  if(isset($_POST["generateToken"])){
    $token = "@".rand(1000,9999);
    $select_token = mysqli_query($con,"SELECT * FROM `user` WHERE `token` = '$token'");
    echo mysqli_num_rows($select_token) == 0 ? $token : 0;
  }
  
  if(isset($_POST["validToken"])){
    $token = mysqli_real_escape_string($con,$_POST["token"]);
    mysqli_query($con,"UPDATE `user` SET `token`='$token' WHERE `email`='".$_SESSION["email"]."'");
    $_SESSION["token"] = $token;
  }
  
  if(isset($_POST["sendRegistrationData"])){
    $email = mysqli_real_escape_string($con,$_POST["email"]);
    $phone = mysqli_real_escape_string($con,$_POST["phone"]);
    $password = mysqli_real_escape_string($con,$_POST["password"]);
    $token = $_SESSION["token"];
    $registered = 1;
    $select_user = mysqli_query($con,"SELECT * FROM `user` WHERE `email` = '$email'");
    if(mysqli_num_rows($select_user) == 0){
      if(!mysqli_query($con,"INSERT INTO `user` (`token`,`email`,`password`,`phone`)
                                       VALUES ('$token','$email','$password','$phone')")){
        $registered = 0;
       }
    } else $registered = 0;
    echo $registered;
  }
  
  if(isset($_POST["getSensorValues"])){
    $sensorValues = array();
    $selectSensorValues = mysqli_query($con,"SELECT * FROM `data` WHERE `token`='".$_SESSION['token']."' ORDER BY `Id` DESC LIMIT 1");
    $val = mysqli_fetch_assoc($selectSensorValues);
    $sensorValues["humidity"] = $val["humidity"];
    $sensorValues["temperature"] = $val["temp"];
    $sensorValues["butan"] = $val["butan_gas"];
    $sensorValues["air"] = $val["atm_quality"];
    $sensorValues["motion"] = $val["motion"];
    $sensorValues["co"] = $val["co"];
    echo json_encode($sensorValues);
  }
  
  if(isset($_POST["editDefaultValues"])){
    $crtValueName = mysqli_real_escape_string($con,$_POST["crtValueName"]);
    switch($crtValueName){
      case "Humidity" : $fieldName = "humidity";
      break;
      case "Temperature" : $fieldName = "temp";
      break;
      case "Butan Gas" : $fieldName = "butan_gas";
      break;
      case "Atmosphere Quality" : $fieldName = "atm_quality";
      break;
      case "Motion" : $fieldName = "motion";
      break;
      case "CO" : $fieldName = "co";
    }
    $crtValue = mysqli_real_escape_string($con,$_POST["crtValue"]);
    mysqli_query($con,"UPDATE `default_values` SET `$fieldName`='$crtValue'");
  }
  
  if(isset($_POST["initCharts"])){
    $selectSensorValues = mysqli_query($con,"SELECT * FROM `data` WHERE `token`='".$_SESSION['token']."' ORDER BY `Id` DESC LIMIT 60");
    $result = array();
    while($rowSensorValues = mysqli_fetch_array($selectSensorValues)){
      $result[] = $rowSensorValues;
    }
    echo json_encode($result);
  }
  
  if(isset($_POST["on_off"])){
    $index = mysqli_real_escape_string($con,$_POST["index"]);
    $value = mysqli_real_escape_string($con,$_POST["value"]);
    switch($index){
      case '1':{
        mysqli_query($con,"UPDATE `control` SET `curent`='$value'");
      } break;
      case '2':{
        mysqli_query($con,"UPDATE `control` SET `gaz`='$value'");
      } break;
      case '3':{
        mysqli_query($con,"UPDATE `control` SET `stingator`='$value'");
      } break;
      case '4':{
        mysqli_query($con,"UPDATE `control` SET `ventilatie`='$value'");
      } break;
      case '5':{
        mysqli_query($con,"UPDATE `control` SET `alarm`='$value'");
      } break;
    }
  }
  
  if(isset($_POST["on_off_live"])){
    $select_control = mysqli_query($con,"SELECT * FROM `control` WHERE `Id`='1'");
    $row_control = mysqli_fetch_assoc($select_control);
    echo json_encode($row_control);
  }
  
  if(isset($_POST["getAlerts"])){
    $selectAlerts = mysqli_query($con,"SELECT * FROM `log_alert` WHERE `token`='".$_SESSION['token']."'");
    if(mysqli_num_rows($selectAlerts)){
      echo "<hr/>";
        while($rowAlert = mysqli_fetch_array($selectAlerts)){
          echo '<div class="container">
                  <div class="col-md-12">
                      <div id="errorsViewAndAck">
                          <div class="alert alert-danger">
                              <div>
                                  <span><strong>'.$rowAlert["m_sms"].'</strong></span>
                                  <p onclick="delAlert('.$rowAlert["Id"].')" style="margin-left: 12px;" class="btn btn-danger">Șterge alerta</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>';
          }
        }
      echo "<hr/>";
  }
  
  if(isset($_POST["delAlert"])){
    $Id = mysqli_real_escape_string($con,$_POST["Id"]);
    mysqli_query($con,"DELETE FROM `log_alert` WHERE `Id`='$Id'");
  }  

?>