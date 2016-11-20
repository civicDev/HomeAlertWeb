function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

function sendData(){
  var email = $('#email').val();
  var phone = $('#phone').val();
  var password = $('#password').val();
  var confirmPassword = $('#confirmPassword').val();
  if(validateEmail(email) && (email.length > 3)){
    if(phone.length >= 10){
      if(password.length > 0 && confirmPassword.length > 0){
        if(password == confirmPassword){
          $.post("ajax.php",{
            sendRegistrationData : 1,
            email : email,
            phone : phone,
            password : password
          },function(data,status){
            if(data == '1'){
              window.location.replace('./admin.php');
            } else {
              alert('This username already exists or some error has occured !');
            }
          });
        } else {
          $('#password').css('background-color','green');
          $('#confirmPassword').css('background-color','red');
          $('#confirmPassword').attr('placeholder','Passwords do not match !');
          $('#confirmPassword').val('');
        }
      }
    } else {
      $('#phone').css('background-color','red');
      $('#phone').attr('placeholder','Phone number should have 10 characters !');
      $('#phone').val('');
    }
  } else {
    $('#email').css('background-color','red');
    $('#email').attr('placeholder','Enter a valid email !');
    $('#email').val('');
  }
}