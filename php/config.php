<?php

$config = array(
    "db" => array(
        "big_lego_databse" => array(
            "dbname" => "database1",
            "username" => "dbUser",
            "password" => "pa$$",
            "host" => "localhost"
        ),
        "special_select" => array(
            "dbname" => "emibe986",
            "username" => "emibe986",
            "password" => "",
            "host" => "mysql.itn.liu.se"
        ),
		"special_edit" => array(
			"dbname" => "emibe986",
			"username" => "emibe986_edit",
			"password" => "Goobergeeber",
			"host" => "mysql.itn.liu.se"
		),
		"special_admin" => array(
			"dbname" => "emibe986",
			"username" => "emibe986_admin",
			"password" => "Wooberweever",
			"host" => "mysql.itn.liu.se"
		)
    )
);

// Enable error reporting
error_reporting(E_ALL);
ini_set("display_errors",1);

// Hashing & password related
$password_min_length = 6;
$username_min_length = 3;
$hash = "md5";