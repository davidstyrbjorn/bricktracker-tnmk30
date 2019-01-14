<?php

// Log the user out from the site
session_start();

// Reset session
$_SESSION["user_id"] = -1;
$_SESSION["logged_in"] = false;

// Redirect back to home.php
header("location:../site/home.php");
exit();

?>