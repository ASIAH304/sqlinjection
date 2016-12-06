<?php
date_default_timezone_set("Asia/Taipei");
session_start();
$servername = "localhost";
$username   = "";
$password   = "";
$database   = "";
$db = new mysqli($servername, $username, $password,$database);
if ($db->connect_error) {
	die("Connection failed: " . $db->connect_error);
}
$sql = "";
if( !isset($_SESSION['level']) ){
	$_SESSION['level'] = 0;
}

if( preg_match('/robot|spider|crawler|curl|^$/i', $_SERVER['HTTP_USER_AGENT']) ){
	exit("You are robot!!");
}
?>