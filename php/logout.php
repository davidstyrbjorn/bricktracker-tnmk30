<?php

// Log the user out from the site
session_start();

$_SESSION["user_id"] = -1;
$_SESSION["logged_in"] = false;

header("location:../site/home.php");

?>