<?php

require_once("config.php");
session_start();

// Get the log in post data
$identification = $_POST["identification"];
$password = $_POST["password"];
$hashed_password = hash($hash, $password);

// Open DB connection
$host = $config["db"]["special_edit"]["host"];
$db_name = $config["db"]["special_edit"]["dbname"]; 
$db_username = $config["db"]["special_edit"]["username"]; 
$db_password =	$config["db"]["special_edit"]["password"];
$db = mysqli_connect($host, $db_username, $db_password, $db_name) or die("Failed to connect to database");

// Get the user from the database
$result = mysqli_query($db, "SELECT * FROM users WHERE users.username = '$identification' OR users.email = '$identification' ");
$row = mysqli_fetch_array($result);

// Check if we got anything back from the query
$user_found = (mysqli_num_rows($result)) ? TRUE:FALSE;

$fail_string = "fail_message=";

if($user_found){
	// User found check that password matches the users password!
	$database_pword = $row["pword"];
	if($hashed_password == $database_pword){
		// Set session to be logged in and redirect to mypage.php
		$_SESSION["logged_in"] = true;
		$_SESSION["user_id"] = $row["user_id"];
		header("location:../site/mypage.php");
		exit();
	}
	else{
		$fail_string .= "wrong_password";
	}
} 
else {
	// User not found!
	$fail_string .= "user_not_found";
}

// Redirect back with the fail string in the url
header("location:../site/login.php?$fail_string");

/*
select id, name
from subjects
where name like concat('%', @search, '%')?>
order by 
	name like concat(@search, '%') desc,
	ifnull(nullif(instr(name, concat(' ', @search)), 0), 99999),
	ifnull(nullif(instr(name, @search), 0), 99999),
	name;
*/