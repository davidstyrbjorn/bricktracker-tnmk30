<?php

$username = $_POST["username"];
$unhashed_password = $_POST["password"];
$password_repeat = $_POST["password-repeat"];
$email = $_POST["email"];

$authentication_msg = "authentication=";
$authentication_error = false;

// Simple username & passowrd authentication!
if(strlen($unhashed_password) < $password_min_length){
	$authentication_msg .= '_password_';
	$authentication_error = true;
}
if($unhashed_password!= $password_repeat){
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
$hashed_pasword = hash($hash, $unhashed_password);

// Insert into database!
include "db.php";
$host = $config["db"]["special_edit"]["host"];
$dbname = $config["db"]["special_edit"]["dbname"]; 
$db_username = $config["db"]["special_edit"]["username"]; 
$password =	$config["db"]["special_edit"]["password"];
 
$db = mysqli_connect($host, $db_username, $password, $dbname) or die("Failed to connect to database");

$email_result = mysqli_query($db, "SELECT * FROM users WHERE users.email = '$email'");
$username_result = mysqli_query($db, "SELECT * FROM users WHERE users.username = '$username'");
$email_exists = (mysqli_num_rows($email_result))?TRUE:FALSE;
$username_exists = (mysqli_num_rows($username_result))?TRUE:FALSE;
if(!$email_exists && !$username_exists){
	$query = "INSERT INTO users(username, email, pword) VALUES ('$username', '$email', '$hashed_pasword')";
	$result = mysqli_query($db, $query);
	
	// Login the user_error
	$query = "SELECT users.user_id FROM users WHERE users.email = '$email'";
	$result = mysqli_query($db, $query);
	$userid = mysqli_fetch_assoc($result);
	session_start(); // Start session 
	$_SESSION["logged_in"] = true;
	$_SESSION["user_id"] = $userid;
	
	header("location:../site/mypage.php");
}
else{
	header("location:../site/register.php?authentication=_exists_");
}

mysqli_close($db);
?>
