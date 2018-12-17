<?php

require_once("config.php");
require_once("db.php");
require_once("user.php");

//$test = new PDODatabseConnection("mysql.itn.liu.se", "emibe986", "emibe986", "");
$db = mysqli_connect("mysql.itn.liu.se", 'emibe986', "", 'emibe986') or die("error:");

//User::logIn("david", "1337");
//echo User::getUsername();

?>