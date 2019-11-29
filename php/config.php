<?php

// Big array mainly for database login info
$config = array(
    "db" => array(
        "big_lego_database" => array(
            "dbname" => "lego",
            "username" => "lego",
            "password" => "",
            "host" => "mysql.itn.liu.se"
        ),
        "special_select" => array(
            "dbname" => "emibe986",
            "username" => "emibe986",
            "password" => "",
            "host" => "mysql.itn.liu.se"
        )
    )
);

// Enable error reporting
error_reporting(E_ALL);
ini_set("display_errors",1);

// Hashing & password related
$username_max_length = 50;
$password_min_length = 6;
$username_min_length = 3;
$hash = "md5";

// Display values
$items_per_page = 15;

// DEBUG USER
// Username: lego_grabben
// Email: lego_grabben@lego.com
// Lösenord: majsmajsmajs
