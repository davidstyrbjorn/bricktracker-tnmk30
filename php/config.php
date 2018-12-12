<?php

$config = array(
    "db" => array(
        "big_lego_databse" => array(
            "dbname" => "database1",
            "username" => "dbUser",
            "password" => "pa$$",
            "host" => "localhost"
        ),
        "users_database" => array(
            "dbname" => "database2",
            "username" => "dbUser",
            "password" => "pa$$",
            "host" => "localhost"
        )
    )
);

// Enable error reporting
error_reporting(E_ALL);
ini_set("display_errors",1);

// Hashing 
$hash = "md5";