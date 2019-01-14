<?php

// Start sessions
session_start();

// Include needed php scripts
require "config.php";
include "script.php";

// Get user and set id from post and session
$SetID = $_POST["SetID"];
$UserID = $_SESSION["user_id"];

// Get database login from config file
$host = $config["db"]["special_edit"]["host"];
$dbname = $config["db"]["special_edit"]["dbname"]; 
$db_username = $config["db"]["special_edit"]["username"]; 
$password =	$config["db"]["special_edit"]["password"];
 
// Connect to database
$db = mysqli_connect($host, $db_username, $password, $dbname) or die("Failed to connect to database");

// Query to delete set with SetID
$query = "DELETE FROM users_sets WHERE users_sets.set_id = '$SetID' AND users_sets.user_id = '$UserID' LIMIT 1";
mysqli_query($db, $query);

// Update user set count 
$_SESSION["user_set_count"] = getUserSetCount();

// Make sure we're not "overeaching" a page now that we've removed something
$page_number = $_SESSION["mypage_page"];
$max_page_number = getNumberOfPages($_SESSION['user_set_count']);
if($page_number > $max_page_number){
	$_SESSION["mypage_page"]--;
}

// Redirect back to add page
header("location:../site/mypage.php");


?>