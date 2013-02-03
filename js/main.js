// GLOBALS
jQuery(document).ready(function($) {

  if(typeof(autoCheckin) == "function") {
    autoCheckin();
  }

  $('#signup button').click( function(){
    var formData = $("#signup").serializeJSON();

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