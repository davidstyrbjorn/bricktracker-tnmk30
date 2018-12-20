<?php

require_once("config.php");
session_start();

// Get the log in post data
$identification = $_POST["identification"];
$password = $_POST["password"];
$hashed_password = hash($hash, $hashed_password);

// Open DB connection
$host = $config["db"]["special_edit"]["host"];
$db_name = $config["db"]["special_edit"]["dbname"]; 
$db_username = $config["db"]["special_edit"]["username"]; 
$db_password =	$config["db"]["special_edit"]["password"];
$db = mysqli_connect($host, $db_username, $db_password, $db_name) or die("Failed to connect to database");

// Get the user from the database
$result = mysqli_query($db, "SELECT * FROM users WHERE users.username = '$identification' OR users.email = '$identification' ");

// Check if we got anything back from the query
$user_found = (mysqli_num_rows($result)) ? TRUE:FALSE;

if($user_found){
	// User found check that password matches the users password!
	$database_pword = mysqli_fetch_array($result)["pword"];
	if($hashed_password == $database_pword){
		// Set session to be logged in and redirect to mypage.php
		$_SESSION["logged_in"] = true;
		$_SESSION["user_id"] = mysqli_fetch_array($result)["user_id"];
		header("location:../site/mypage.php");
	}
} 

// If we made it here, we failed to log in
echo "failed to log in!";

?>