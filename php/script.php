<?php
/*
Functions implemented here:
- Getting all the sets a user(user_id) has in his/hers possession
- Adding a set to a user 
- Removing a set from a user

Uses session to get user_id and to check if user is logged in
*/

require_once("config.php");

class Set{
    public $set;
    public $name;
    public $img_url;
}

function getOwnedSets()
{
    session_start(); // Start session assuming it hasn't already been done

    // Make sure the user is logged in!
    if(!isset($_SESSION["logged_in"]))
        return;
    if($_SESSION["logged_in"]){
        // We are logged in, proceed with retrieving the sets
        $user_id = $_SESSION["user_id"];

        // open DB
        $host = $config["db"]["special_edit"]["host"];
        $dbname = $config["db"]["special_edit"]["dbname"]; 
        $db_username = $config["db"]["special_edit"]["username"]; 
        $password =	$config["db"]["special_edit"]["password"];
        $db = mysqli_connect($host, $db_username, $password, $dbname) or die("Failed to estabish database connection!");
        
        // Get all the sets id the user has
        $query = "SELECT * FROM users_sets WHERE '$user_id' = users_sets.user_id";
        $result = mysqli_query($db, $query);
        for($row = mysqli_fetch_array($db)){
            // What do we do here? @@@
        }
    }
}

function addSet($set_id)
{

}

function removeSet($set_id)
{

}

?>