<?php

// Start session, since we're using session to get user info
session_start();

// Include needed php files
require "config.php";
include "script.php";

// Get set/user id from post and session
$SetID = $_POST["SetID"];
$UserID = $_SESSION["user_id"];

// Get login data from config file
$host = $config["db"]["special_edit"]["host"];
$dbname = $config["db"]["special_edit"]["dbname"]; 
$db_username = $config["db"]["special_edit"]["username"]; 
$password =	$config["db"]["special_edit"]["password"];

// Used when entering the row
$date = date("Y-m-d H:i:s");
 
// Connect to database
$db = mysqli_connect($host, $db_username, $password, $dbname) or die("Failed to connect to database");

// Perform the query to insert the set 
$query = "INSERT INTO users_sets (user_id, set_id, add_time) VALUES('$UserID', '$SetID', '$date')";
mysqli_query($db, $query);

// Update how many sets the user has
$_SESSION["user_set_count"] = getUserSetCount();

if(isset($_POST["SetPage"])){
	header("location:../site/set.php? set_id=$SetID");
	exit();
}

// Redirect back to add page + the last search 
$last_search = $_SESSION["last_search"];
header("location:../site/add.php? search_string=$last_search");

?>