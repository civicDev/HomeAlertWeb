function sendData(){
  var email = $('#email').val();
  var password = $('#password').val();
  $.post("ajax.php",{
    sendLoginData : 1,
    email : email,
    password : password
  },function(data,status){
    if(data != '0'){
      window.location.replace('./admin.php');
    } else alert("Utilizator inexistent !");
  });
}