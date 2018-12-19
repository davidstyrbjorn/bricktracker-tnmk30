<?php

require_once("config.php");

$username = $_POST["username"];
$password = $_POST["password"];
$password_repeat = $_POST["password-repeat"];
$email = $_POST["email"];

$authentication_msg = "authentication=";
$authentication_error = false;

// Simple username & passowrd authentication!
if(strlen($password) < $password_min_length){
	$authentication_msg .= '_password_';
	$authentication_error = true;
}
if($password != $password_repeat){
	$authentication_msg .= '_passr_';
	$authentication_error = true;
}
if(strlen($username) < $username_min_length){
	$authentication_msg .= '_username_';
	$authentication_error = true;
}
// There was authentication error
if($authentication_error == true){
	// Redirect back with appropiate error message
	header("location: ../site/register.php?$authentication_msg");
}

// Hash the password
$hashed_pasword = hash($hash, $password);

// Insert into database!
include "db.php";
$host = $config["db"]["special_edit"]["host"];
$dbname = $config["db"]["special_edit"]["dbname"]; 
$username = $config["db"]["special_edit"]["username"]; 
$password =	$config["db"]["special_edit"]["password"];
 
$dsn = "mysql:host=$host;dbname:$dbname";
try{
	$pdo = new PDO($dsn, $username, $password);
} catch(PDOException $e){
	echo $e->getMessage();
	die();
}

echo "Register went through!";

?>
