function logout(){
  $.post("ajax.php",{
    logout : 1
  },function(data,status){
    window.location.reload();
  });
}
var sensors = ["Umiditate","Temperatură","Gaz butan","Calitatea Aerului","Mișcare","Monoxid de carbon"];
function setValues(){
  if($('#addValues').val() != ''){
    $('#addValues').attr('placeholder',sensors[Number($('#go').attr('data'))+1]);
    if(Number($('#go').attr('data')) < 5){
      $.post("ajax.php",{
        editDefaultValues : 1,
        crtValueName : sensors[Number($('#go').attr('data'))],
        crtValue : $('#addValues').val()
      },function(data,status){
        $('#addValues').val('');
      });
      $("#go").attr('data',String(Number($('#go').attr('data'))+1));
    } else if(Number($('#go').attr('data')) == 5){
      $.post("ajax.php",{
        editDefaultValues : 1,
        crtValueName : sensors[Number($('#go').attr('data'))],
        crtValue : $('#addValues').val()
      },function(data,status){
        $('#addValues').val('');
      });
      disappear();
    }
  }
}
function appear(){
  $('#addValues').val('');
  $("#addValues").attr('placeholder','Umiditate');
  $("#go").attr('data','0');
  $('#defaultValues').show();
  $('#edit').html('Am terminat editarea');
  $('#edit').attr('onclick','disappear()');
}
function disappear(){
  $('#defaultValues').hide();
  $('#edit').html('Edit default sensor values');
  $('#edit').attr('onclick','appear()');
}

function changeToken(){
  var repeat = window.setInterval(function(){
    $.post("ajax.php",{
      generateToken : 1
    },function(data,status){
      if(data != '0'){
        $.post("ajax.php",{
          validToken : 1,
          token : data
        });
        clearInterval(repeat);
      }
    });
  },100);
  window.setTimeout(function(){
    window.location.reload();
  },60100);
  alert('Vă rugăm să așteptați aproximativ un minut până terminarea setărilor !');
}

function on_off(index,turn){
  var index = index;
  $.post("ajax.php",{
    on_off : 1,
    index : index,
    value : turn
  },function(data,status){
    if(turn == '1'){
      $('#on_off'+index).css('opacity','0.75');
      $('#on_off'+index).attr('onclick','on_off('+index+',\'0\')');
    } else {
      $('#on_off'+index).css('opacity','1');
      $('#on_off'+index).attr('onclick','on_off('+index+',\'1\')');
    }
  });
}

function delAlert(Id){
  $.post("ajax.php",{
    delAlert : 1,
    Id : Id
  });
}

$(document).ready(function(){
  window.setInterval(function(){
    $.post("ajax.php",{
      getSensorValues : 1
    },function(data,status){
      var sensorValues = JSON.parse(data);
      var humidity = sensorValues['humidity'];
      var temperature = sensorValues['temperature'];
      var butan = sensorValues['butan'];
      var air = sensorValues['air'];
      var motion = sensorValues['motion'];
      var co = sensorValues['co'];
      $("#humidity").attr('value',"Umiditate : "+humidity);
      $("#temperature").attr('value',"Temperatură : "+temperature);
      $("#butan").attr('value',"Gaz butan : "+butan);
      $("#air").attr('value',"Calitatea aerului : "+air);
      $("#motion").attr('value',"Mișcare/Vibrații : "+motion);
      $("#co").attr('value',"Monoxid de carbon : "+co);
    });
  },800);
  $.post("ajax.php",{
      on_off_live : 1
    },function(data,status){
      data = JSON.parse(data);
      var curent = data["curent"];
      var gaz = data["gaz"];
      var stingator = data["stingator"];
      var ventilatie = data["ventilatie"];
      var alarm = data["alarm"];
      $("#control").html('<button id="on_off1" onclick="on_off(1,\''+Number(!Number(curent))+'\')" type="button" class="btn btn-default"><span class="glyphicon glyphicon-off"></span> Curent</button><button id="on_off2" onclick="on_off(2,\''+Number(!Number(gaz))+'\')" type="button" class="btn btn-default"><span class="glyphicon glyphicon-off"></span> Gaz</button><button id="on_off3" onclick="on_off(3,\''+Number(!Number(stingator))+'\')" type="button" class="btn btn-default"><span class="glyphicon glyphicon-off"></span> Stingător</button><button id="on_off4" onclick="on_off(4,\''+Number(!Number(ventilatie))+'\')" type="button" class="btn btn-default"><span class="glyphicon glyphicon-off"></span> Ventilație</button><button id="on_off5" onclick="on_off(5,\''+Number(!Number(alarm))+'\')" type="button" class="btn btn-default"><span class="glyphicon glyphicon-off"></span> Alarmă</button>');
      if(curent == '0') $('#on_off1').css('opacity','0.75');
      else $('#on_off1').css('opacity','1');
      if(gaz == '0') $('#on_off2').css('opacity','0.75');
      else $('#on_off2').css('opacity','1');
      if(stingator == '0') $('#on_off3').css('opacity','0.75');
      else $('#on_off3').css('opacity','1');
      if(ventilatie == '0') $('#on_off4').css('opacity','0.75');
      else $('#on_off4').css('opacity','1');
      if(alarm == '0') $('#on_off5').css('opacity','0.75');
      else $('#on_off5').css('opacity','1');
    });
  window.setInterval(function(){
    $.post("ajax.php",{
      on_off_live : 1
    },function(data,status){
      data = JSON.parse(data);
      var curent = data["curent"];
      var gaz = data["gaz"];
      var stingator = data["stingator"];
      var ventilatie = data["ventilatie"];
      var alarm = data["alarm"];
      $("#control").html('<button id="on_off1" onclick="on_off(1,\''+Number(!Number(curent))+'\')" type="button" class="btn btn-default"><span class="glyphicon glyphicon-off"></span> Curent</button><button id="on_off2" onclick="on_off(2,\''+Number(!Number(gaz))+'\')" type="button" class="btn btn-default"><span class="glyphicon glyphicon-off"></span> Gaz</button><button id="on_off3" onclick="on_off(3,\''+Number(!Number(stingator))+'\')" type="button" class="btn btn-default"><span class="glyphicon glyphicon-off"></span> Stingător</button><button id="on_off4" onclick="on_off(4,\''+Number(!Number(ventilatie))+'\')" type="button" class="btn btn-default"><span class="glyphicon glyphicon-off"></span> Ventilație</button><button id="on_off5" onclick="on_off(5,\''+Number(!Number(alarm))+'\')" type="button" class="btn btn-default"><span class="glyphicon glyphicon-off"></span> Alarmă</button>');
      if(curent == '0') $('#on_off1').css('opacity','0.75');
      else $('#on_off1').css('opacity','1');
      if(gaz == '0') $('#on_off2').css('opacity','0.75');
      else $('#on_off2').css('opacity','1');
      if(stingator == '0') $('#on_off3').css('opacity','0.75');
      else $('#on_off3').css('opacity','1');
      if(ventilatie == '0') $('#on_off4').css('opacity','0.75');
      else $('#on_off4').css('opacity','1');
      if(alarm == '0') $('#on_off5').css('opacity','0.75');
      else $('#on_off5').css('opacity','1');
    });
  },3000);
  window.setInterval(function(){
    $.post("ajax.php",{
      getAlerts : 1
    },function(data,status){
      $("#alerts").html(data);
    });
  },500);
});