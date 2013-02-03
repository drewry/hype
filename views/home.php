<div class="row-fluid">
	<div class="span8">
		<h2>Who's Here</h2>
		<div id="checkins"><?php include('views/checkins.php'); ?></div>
	</div>
	<div class="span4">
		<h2>Scan to Checkin</h2>
		<img src="img/qrcode.png">
		<h2>Or Use Foursquare</h2>
	</div>
</div>
<div id="welcome"></div>
<script type="text/javascript">
function loadCheckins() {
	$('#checkins').load('index.php?p=checkins');

	$.get('index.php', { p: 'welcome' }, function(response) {
		if(response == '0') {
			$('#mask').hide();
			$('#welcome').hide();
		} else {
			$('#welcome').html(response).show();
			$('#mask').show();
		}
	});
}
setInterval(loadCheckins, (5*1000));
</script>