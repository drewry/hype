// GLOBALS
jQuery(document).ready(function($) {

  if(typeof(autoCheckin) == "function") {
    autoCheckin();
  }

  funciton validateEmail(enteredemail){
    var input = document.getElementById("email").value;
    input.type = "email";
    input.value = enteredemail;
    return input.checkValidity();
  }

  $('#signup button').click( function(){
    var formData = $("#signup").serializeJSON();
    var fname = document.getElementById("firstname").value;
    if(fname == '' || fname == null){
      $("#fnameerror").show("fast");
    }
    var lname = document.getElementById('lastname').value;
    if(lname == '' || lname == null){
      $("#lnameerror").show("fast");
    }
    var email = document.getElementById("email").value;
    if(validateEmail(email) == false){
      #("#emailerror").show("fast");
    }
    var username = document.getElementById("username").value;
    if(username == '' || username == null){
      $("#usernameerror").show("fast");
    }
    var pw1 = document.getElementById("pass1").value;
    if(pw1 == '' || pw1 == null){
      $("#pw1error").show("fast");
    }
    var pw2 = document.getElementById("pass2").value;
    if(pw2 == '' || pw2 == null){
      $("#pw2error").show("fast");
    }
    if(pw1 != pw2){
      $("#pwmatcherror").show("fast");
    }
    if(fname != '' && fname != null && lname != '' && lname != null && validateEmail(email) != true && username != '' && username != null && 
    pw1 != '' && pw1 != null && pw2 != '' && pw2 != null && pw1 == pw2){
    $.post('index.php', {
        a: 'signup',
        firstname: formData.firstname,
        lastname: formData.lastname,
        user_Name: formData.username,
        email: formData.email,
        pass: formData.pass1
      }, function(json) {
        var response = JSON.parse(json);
        $('#main-content-box').html('<h2>Thank you, you are now checked in!</h2>');
        localStorage.email = response.email;
      }
    );
    }
  });

  $('#checkin button').click( function(){
    var formData = $("#checkin").serializeJSON();

    $.post('index.php', {
        a: 'checkin',
        email: formData.email
      }, function(json) {
        var response = JSON.parse(json);
        $('#main-content-box').html('<h2>Thank you, you are now checked in!</h2>');
        localStorage.email = response.email;
      }
    );

  });

});
