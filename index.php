<?php
require_once('inc/config.php');

if(!isset($_GET['p'])) {
	$_GET['p'] = 'home';
}

if(isset($_POST['a'])) {
	switch($_POST['a']) {

		case 'checkin' :
			unset($_POST['a']);
			extract($_POST);

			$row = $h->db->query_first("SELECT id FROM users WHERE email = '$email' OR user_Name = '$email'");

			if($row) {
				$user_id = $row['id'];

				$h->db->query("SELECT check_In($user_id, 1)");
				$user = $h->get_user($user_id);

				echo json_encode($user);
			} else {
				echo json_encode('fail');
			}
			
			exit;
			break;

		case 'signup' :
			unset($_POST['a']);
			extract($_POST);

			// add a new user row, sign them up and check them in
			$user_id = $h->create_user($_POST);
			$h->signup($user_id, $email, $pass);
			$h->db->query("SELECT check_In($user_id, 1)");

			$user = $h->get_user($user_id);

			echo json_encode($user);
			exit;
			break;

		default :
			break;
	}
}

switch($_GET['p']) {

	case 'foursquare' :
		$h->foursquare($_POST['checkin']);
		break;

	case 'nfc' :
		$user_id = $_GET['nfc'];
		$h->nfc($user_id);

		echo 'You are now checked into the hype';

		break;

	case 'checkins' :
			$users = $h->get_users();
			include('views/checkins.php');
			
			exit;
			break;

	case 'checkin' :
		$title = 'Checkin to Hypepotamus';
		include('views/header.php');
		include('views/checkin.php');
		include('views/footer.php');

		break;

	default :
		$title = 'Welcome to Hypepotamus';
		$users = $h->get_users();
		include('views/header.php');
		include('views/home.php');
		include('views/footer.php');
		break;
}