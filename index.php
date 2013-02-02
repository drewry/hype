<?php
require_once('inc/config.php');

if(!isset($_GET['p'])) {
	$_GET['p'] = 'home';
}

switch($_GET['p']) {

	case 'foursquare' :
		$h->foursquare($_POST['checkin']);
		break;

	case 'checkin' :
		if(isset($_POST['checkin'])) {
			unset($_POST['checkin']);
			extract($_POST);

			$h->db->query("SELECT check_In($user_id, 1)");

			$user = $h->get_user($user_id);

			$output = json_encode($user);
		} else {
			$output = 'Checkin Function';
		}
		
		echo $output;
		exit;
		break;

	case 'signup' :
		if(isset($_POST['signup'])) {
			unset($_POST['signup']);
			extract($_POST);

			// add a new user row, sign them up and check them in
			$user_id = $h->create_user($_POST);
			$h->signup($user_id, $email, $pass);
			$h->db->query("SELECT check_In($user_id, 1)");

			$user = $h->get_user($user_id);

			$output = json_encode($user);
		} else {
			$output = 'Signup Function';
		}

		echo $output;
		exit;
		break;

	default :
		echo 'Welcome to the Hype!';
		break;

}