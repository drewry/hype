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

	case 'clear' :
		session_start();
		session_destroy();
		header('Location: index.php?p=checkin');
		break;

	case 'twitter' :
		$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
		
		$screen_name = str_replace('@','',$_POST['screen_name']);
		$email = $_POST['email'];
		$user = $twitter->get("users/show", array('screen_name' => $screen_name));
		$name_parts = explode(" ", $user->name);
		if(count($name_parts) == 2) {
			$firstname = $name_parts[0];
			$lastname = $name_parts[1];
		} elseif(count($name_parts) == 3) {
			$firstname = $name_parts[0].' '.$name_parts[1];
			$lastname = $name_parts[2];
		} else {
			$firstname = $user->name;
		}
		
		$insert_data = array(
			'firstname' => $firstname,
			'lastname' => $lastname,
			'twitter' => $screen_name,
			'user_Name' => $screen_name,
			'avatar' => $user->profile_image_url
		);

		$user_id = $h->create_user($insert_data);
		$h->signup($user_id, $email);
		$h->db->query("SELECT check_In($user_id, 1)");

		$user = $h->get_user($user_id);

		include('views/header.php');
		include('views/twitter.php');
		include('views/footer.php');

		break;

	case 'welcome' :
		$user = $h->get_most_recent();
		if($user) {
			echo "<img src='{$user['avatar']}'><h2>Welcome {$user['firstname']} {$user['lastname']} to Hypepotamus</h2>";
		} else {
			echo 0;
		}
		exit;
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