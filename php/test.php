<?php

require_once("config.php");
require_once("db.php");
require_once("user.php");

$test = new PDODatabseConnection("mysql.itn.liu.se", "blog", "blog", "");

User::logIn("david", "1337");
echo User::getUsername();


?>