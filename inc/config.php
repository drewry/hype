<?php
ob_start();
session_start();
error_reporting(0);

define('DB_SERVER', "");
define('DB_USER', "");
define('DB_PASS', "");
define('DB_DATABASE', "");

require_once('class.db.php');
$db = Database::obtain(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect();

require_once('class.hype.php');
$h = new Hype();

if((!isset($_SESSION['uid'])) OR ($_SESSION['uid'] == 0)) {
	define("LOGGEDIN", false);
} else {
	define("LOGGEDIN", true);
}