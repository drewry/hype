<div class="row-fluid">
	<div class="span6">
		<form id="checkin">
	        <fieldset>
	            <label>E-mail or Username</label>
	            <input name="email" type="text" placeholder="E-mail or Username">
	            <button type="button" class="btn btn-success btn-large">
	                Checkin
	            </button>
	        </fieldset>
	    </form>
	</div>
	<div class="span6">
		<form id="signup">
	        <fieldset>
	            <label>E-mail</label>
	            <input name="email" type="text" placeholder="E-mail">
	            <label>First Name</label>
	            <input name="firstname" type="text" placeholder="First Name">
	            <label>Last Name</label>
	            <input name="lastname" type="text" placeholder="Last Name">
	            <label>Username</label>
	            <input name="username" type="text" placeholder="Username">
	            <label>Password</label>
	            <input name="pass1" type="password" placeholder="Password">
	            <label>Confirm Password</label>
	            <input name="pass2" type="password" placeholder="Confirm Password">
	            <br>
	            <button type="button" class="btn btn-success btn-large">
	                Get Involved
	            </button>
	        </fieldset>
	    </form>
	</div>
</div>
<script type="text/javascript">
function autoCheckin() {
if(localStorage.email != undefined) {
    $.post('index.php', {
        a: 'checkin',
        email: localStorage.email,
      }, function(json) {
        var response = JSON.parse(json);
        $('#main-content-box').html('<h2>Thank you, you are now checked in!</h2>');
        localStorage.email = response.email;
      }
    );
  }
}
</script>