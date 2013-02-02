<?php
class Hype {  

	public $db;
	
	public function Hype() {
		$this->db = Database::obtain();
	}

	public function get_user($user_id) {
		$row = $this->db->query_first("SELECT id, email, firstname, lastname, avatar, created FROM users WHERE id = '$user_id'");

		// if avatar is empty check gravatar and update
		if($row['avatar'] == '') {
			$avatar = $this->get_gravatar($row['email']);
			$row['avatar'] = $avatar;
			$this->db->update('users', array('avatar' => $avatar), "id = '$user_id'");
		}

		return $row;
	}

	// this is the real sign up process which sends an email and saves a password
	public function signup($user_id, $email, $pass = '') {
		if($pass == '') {
			$pass = $this->random_password();
		}
		
		// updates
		$this->db->update('users', array('email' => $email), "id = '$user_id'");
		$this->db->query("SELECT save_Password($user_id, $pass, uuid())");

		// send email
		$to = $email;
		$subject = "Welcome to Hypepotamus";
		$txt = "You're now checked in at the Hype!  Here is your password to login to the website: $pass";
		$headers = "From: no-reply@hypepotamus.com";

		mail($to,$subject,$txt,$headers);

	}

	// this function just quickly creates a user with avatar name and stuff
	public function create_user($data) {
		$data['created'] = 'NOW()';
		$user = $this->db->insert('users', $data);

		return $user;
	}

	public function foursquare($raw) {
		$data = json_decode($raw);

		// check if user exists
		$row = $this->db->query_first("SELECT id FROM users WHERE id = '$foursquare'");
		if($row) {
			$user_id = $row['id'];
			$checkin = $this->db->query("SELECT check_In( $user_id, 2)");
		} else {
			$create_user = array(
				'firstname' => $data->user->firstName,
				'lastname' => $data->user->lastName,
				'avatar' => $data->user->photo
			);
			$user_id = $this->create_user($create_user);
			$checkin = $this->db->query("SELECT check_In( $user_id, 2)");
		}

		return $checkin;
	}
	
	public function random_password() {
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, count($alphabet)-1);
			$pass[$i] = $alphabet[$n];
		}

		return $pass;
	}

	public function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
		$url = 'http://www.gravatar.com/avatar/';
		$url .= md5( strtolower( trim( $email ) ) );
		$url .= "?s=$s&d=$d&r=$r";
		if ( $img ) {
			$url = '<img src="' . $url . '"';
			foreach ( $atts as $key => $val )
				$url .= ' ' . $key . '="' . $val . '"';
			$url .= ' />';
		}
		return $url;
	}

} 