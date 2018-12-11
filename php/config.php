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
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);