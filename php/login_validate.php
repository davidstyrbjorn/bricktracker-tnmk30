<?php

require_once("config.php");

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
$user_found = (mysqli_num_rows($result))?TRUE:FALSE;
if($user_found){
	// User found check that password matches the user!
	if($hashed_password == $result[0]["pword"]){
		
	}
} else {
	// User not found! What do we do?
}

?>