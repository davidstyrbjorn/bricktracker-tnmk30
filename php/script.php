<?php
/*
Functions implemented here:
- Getting all the sets a user(user_id) has in his/hers possession
- Adding a set to a user 
- Removing a set from a user

Uses session to get user_id and to check if user is logged in
*/

function displayOwnedSets()
{
    session_start(); // Start session assuming it hasn't already been done

    // Make sure the user is logged in!
    //if(!isset($_SESSION["logged_in"]))
    //    return;
    //if(!$_SESSION["logged_in"]){
	if(1 == 1){
		// We are logged in, proceed with retrieving the sets
        //$user_id = $_SESSION["user_id"];
		$user_id = 11;
		
		include "config.php";
		
        // open DB
        $host = $config["db"]["special_edit"]["host"];
        $dbname = $config["db"]["special_edit"]["dbname"]; 
        $db_username = $config["db"]["special_edit"]["username"]; 
        $password =	$config["db"]["special_edit"]["password"];
        $db = mysqli_connect($host, $db_username, $password, $dbname) or die("Failed to estabish database connection!");
        
        // Get all the sets id the user has
		$query = "SELECT * FROM users_sets WHERE '$user_id' = users_sets.user_id";
        $result = mysqli_query($db, $query);
		$set_id_list = array();
        while($row = mysqli_fetch_array($result)){
            array_push($set_id_list, $row['set_id']);
        }		
		mysqli_close($db);
		
		// Get the sets from the lego database using the set_id_list
		// Open database connection to lego database
		$host = $config["db"]["big_lego_database"]["host"];
		$dbname = $config["db"]["big_lego_database"]["dbname"]; 
        $db_username = $config["db"]["big_lego_database"]["username"]; 
        $password =	$config["db"]["big_lego_database"]["password"];
		$db = mysqli_connect($host, $db_username, $password, $dbname) or die("Failed to estabish database connection!" . "<br/>HOST:$host");
		
		$table_row_class = "dark-tr";	
		foreach($set_id_list as $set_id){			
			if($table_row_class == "dark-tr")
				$table_row_class = "light-tr";
			else
				$table_row_class = "dark-tr";
			
			// Get set from database	
			$result = mysqli_query($db, "SELECT s.SetID, s.Setname, s.Year, i.ItemTypeID, i.has_gif, i.has_jpg FROM sets s, images i WHERE '$set_id' = s.SetID AND '$set_id' = i.ItemID");
			$row = mysqli_fetch_array($result);
			echo "<tr class='$table_row_class'>";
			echo "<td>" . $row['SetID'] . 	"</td>";
			echo "<td>" . $row['Setname'] . "</td>";
			echo "<td"> . $row['Year'] . 	"</td>";
			$url  = getSetImageURL($row['has_gif'], $row['has_jpg'], $row['ItemTypeID'], $row['SetID']);
			echo "<td class='set-image'>" . "<img src=''>" . "</td>";
			echo "</tr>"
		}
	}
}

function addSet($set_id)
{
	
}

function removeSet($set_id)
{

}

function getSetImageURL($has_gif, $has_jpg, $item_type_id, $set_id)
{
	$url = "$item_type_id/$set_id";
	$url .= ($has_gif) ? ".gif" : ".jpg";
	
	return $url;
}

?>