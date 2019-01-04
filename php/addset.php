<?php

session_start();

require "config.php";

$SetID = $_POST["SetID"];
$UserID = $_SESSION["user_id"];

$host = $config["db"]["special_edit"]["host"];
$dbname = $config["db"]["special_edit"]["dbname"]; 
$db_username = $config["db"]["special_edit"]["username"]; 
$password =	$config["db"]["special_edit"]["password"];
 
$db = mysqli_connect($host, $db_username, $password, $dbname) or die("Failed to connect to database");

$query = "INSERT INTO users_sets (user_id, set_id) VALUES('$UserID', '$SetID')";
mysqli_query($db, $query);

// Redirect back to add page
$last_search = $_SESSION["last_search"];
header("location:../site/add.php? search_string=$last_search");

?>