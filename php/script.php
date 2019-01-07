<?php
/*
Use session to get user_id and to check if user is logged in
*/

// Echoes username etc on the mypage
function displayUserInfo()
{
	// Format 
	// User name is <h3>
	// Description is <h5>
	
	include "config.php";
	
	$username = "";
	$description = "Welcome to your personal collection! Here you can se your collection of sets and bricks! if your list is empty go to the add page to add sets that you own!";
		
	// Get user name
	if(!isset($_SESSION["logged_in"])){
		return;
	}
	if($_SESSION["logged_in"]){
		
		$user_id = $_SESSION["user_id"];
		
		// open DB
        $host = $config["db"]["special_edit"]["host"];
        $dbname = $config["db"]["special_edit"]["dbname"]; 
        $db_username = $config["db"]["special_edit"]["username"]; 
        $password =	$config["db"]["special_edit"]["password"];
		$db = mysqli_connect($host, $db_username, $password, $dbname) or die("Failed to estabish database connection!");
	
		$query = "SELECT * FROM users WHERE users.user_id = '$user_id'";
		$result = mysqli_query($db, $query);
		$row = mysqli_fetch_array($result);
		$username = $row["username"];
	}
	
	$set_count = getUserSetCount();
	echo "<h1>" . $username . "</h1>";
	echo "<h3>" . "You own " . $set_count . " sets!" . "<h3>";
	echo "<h5>" . $description . "</h3>";
}

// Echo html tables of the current users owned sets
function displayOwnedSets()
{
    // Make sure the user is logged in!
    if(!isset($_SESSION["logged_in"])) {
        return;
	}
    if($_SESSION["logged_in"]){
		// We are logged in, proceed with retrieving the sets
        $user_id = $_SESSION["user_id"];
		
		include "config.php";
		
		if(!isset($_SESSION["user_set_count"])){
			$_SESSION["user_set_count"] = getUserSetCount();
		}

        // open DB
        $host = $config["db"]["special_edit"]["host"];
        $dbname = $config["db"]["special_edit"]["dbname"]; 
        $db_username = $config["db"]["special_edit"]["username"]; 
        $password =	$config["db"]["special_edit"]["password"];
        $db = mysqli_connect($host, $db_username, $password, $dbname) or die("Failed to estabish database connection!");
        
		$page_number = $_SESSION["mypage_page"];
		$offset = ($page_number-1)*$items_per_page;		
        // Get all the sets id the user has
		$query = "SELECT * FROM users_sets WHERE '$user_id' = users_sets.user_id  ORDER BY add_time DESC LIMIT $offset, $items_per_page";
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
			// Toggle row class!		
			if($table_row_class == "dark-tr")
				$table_row_class = "light-tr";
			else
				$table_row_class = "dark-tr";
			
			// Get set from database	
			$result = mysqli_query($db, "SELECT s.SetID, s.Setname, s.Year, i.ItemTypeID, i.has_gif, i.has_jpg FROM sets s, images i WHERE '$set_id' = s.SetID AND '$set_id' = i.ItemID");
			$row = mysqli_fetch_array($result);
			
			$SetID = $row['SetID'];
			
			// Display the row
			echo "<tr class='$table_row_class'>";
			echo "<td>" . $SetID . 	"</td>";
			echo "<td>" . $row['Setname'] . "</td>";
			echo "<td>" . $row['Year'] . 	"</td>";
			$url  = "http://www.itn.liu.se/~stegu76/img.bricklink.com/" . getSetImageURL($row['has_gif'], $row['has_jpg'], $row['ItemTypeID'], $row['SetID']);
			echo "<td class='set-image'>" . "<img src='$url'>" . "</td>";
			
			echo "<td>"; 
			echo "<form action='../php/removeset.php' method='post'>";
			echo "<input type='hidden' value='$SetID' name='SetID'>";
			echo "<button type='submit' class='add-button'>-</button>";
			echo "</form>";
			echo "</td>";
			
			echo "</tr>";
		}
	}
}

// Given a search strings echoes a bunch of sets
function searchForSetAndDisplay($search_string, $newSearch){
	
	include "config.php";
	
	// Open DB
	$host = $config["db"]["big_lego_database"]["host"];
	$dbname = $config["db"]["big_lego_database"]["dbname"]; 
	$db_username = $config["db"]["big_lego_database"]["username"]; 
	$password =	$config["db"]["big_lego_database"]["password"];
	$db = mysqli_connect($host, $db_username, $password, $dbname) or die("Failed to estabish database connection!" . "<br/>HOST:$host");
	
	// First a query for the total amount of rows in the search
	if($newSearch){
		$query = "SELECT s.SetID, s.Setname, s.Year, i.ItemTypeID, i.has_jpg, i.has_gif FROM sets s, images i WHERE (s.SetID = '$search_string' OR s.Setname = '$search_string' OR s.Year = '$search_string') AND i.ItemID = s.SetID";
		$result = mysqli_query($db, $query);
		$_SESSION["search_count"] = $result->num_rows;
	}

	$page_number = $_SESSION["sets_page"];
	$offset = ($page_number-1)*$items_per_page;

	// Get sets form database
	$query = "SELECT s.SetID, s.Setname, s.Year, i.ItemTypeID, i.has_jpg, i.has_gif FROM sets s, images i WHERE (s.SetID = '$search_string' OR s.Setname = '$search_string' OR s.Year = '$search_string') AND i.ItemID = s.SetID LIMIT $offset,$items_per_page";
	$result = mysqli_query($db, $query);
	
	$table_row_class = "dark-tr";
	
	while($row = mysqli_fetch_array($result)) {
		// Toggle row class!		
		if($table_row_class == "dark-tr")
			$table_row_class = "light-tr";
		else
			$table_row_class = "dark-tr";
		
		$SetID = $row["SetID"]; // We use this more than once
		
		// Check if the user has set
		$hasSet = userHasSet($SetID);
		if($hasSet == true){
			$table_row_class .= " has"; 
		}

		// Display the row
		echo "<tr class='$table_row_class'>";
		
		echo "<td>" . $SetID . 	"</td>";
		echo "<td>" . $row['Setname'] . "</td>";
		echo "<td>" . $row['Year'] . 	"</td>";
		$url  = "http://www.itn.liu.se/~stegu76/img.bricklink.com/" . getSetImageURL($row['has_gif'], $row['has_jpg'], $row['ItemTypeID'], $row['SetID']);
		echo "<td class='set-image'>" . "<img src='$url'>" . "</td>";
		echo "<td>"; 
		echo "<form action='../php/addset.php' method='post'>";
		echo "<input type='hidden' value='$SetID' name='SetID'>";
		echo "<button type='submit' class='add-button'>+</button>";
		echo "</form>";
		echo "</td>";
		
		echo "</tr>";
	}	
}

/* UGLY PAGINATION FUNCTIONS */

function displayPaginationAddSets()
{
	include "config.php";

	$page_number = $_SESSION["sets_page"];
	$max_page_number = 0;
	if($_SESSION['search_count'] <= $items_per_page){
		$max_page_number = 1;
	}
	else{
		$max_page_number = (int)(round($_SESSION['search_count'] / $items_per_page));
	}
	
	echo "<form action='../php/pagination_page_switch.php' method='POST'>";
	echo "<table class='pagination'>";
	echo "<tr>";
	echo "<td> <input type='submit' class='pagination-button' name='pagination_left_sets' value='<' </td>";
	echo "<td>$page_number / " . $max_page_number . "</td>";
	echo "<td> <input type='submit' class='pagination-button' name='pagination_right_sets' value='>'/> </td> ";
	echo "</tr> ";
	echo "</table> ";
	echo "</form>";
}

function resetPageNumber()
{
	$_SESSION["sets_page"] = 1;
}

function displayPaginationMypage()
{
	include "config.php";

	$page_number = $_SESSION["mypage_page"];

	$max_page_number = 0;
	if($_SESSION['user_set_count'] <= $items_per_page){
		$max_page_number = 1;
	}
	else{
		$max_page_number = (int)(round(($_SESSION['user_set_count'] / $items_per_page)+0.5));
	}

	echo "<form action='../php/pagination_page_switch.php' method='POST'>";
	echo "<table class='pagination'>";
	echo "<tr>";
	echo "<td> <input type='submit' class='pagination-button' name='pagination_left_mypage' value='<'/> </td> ";
	echo "<td>$page_number / " . $max_page_number . "</td>";
	echo "<td> <input type='submit' class='pagination-button' name='pagination_right_mypage' value='>'/> </td> ";
	echo "</tr> ";
	echo "</table> ";
	echo "</form>";
}

// Helper for getting image url for a set given a set of parameters
function getSetImageURL($has_gif, $has_jpg, $item_type_id, $set_id)
{
	$url = "$item_type_id/$set_id";
	$url .= ($has_gif) ? ".gif" : ".jpg";
	
	return $url;
}

// Check if the user has a set in his/hers inventory
function userHasSet($set_id)
{
	include "config.php";

	// Query our database and check if the user has $set_id 
    // open DB
    $host = $config["db"]["special_edit"]["host"];
    $dbname = $config["db"]["special_edit"]["dbname"]; 
    $db_username = $config["db"]["special_edit"]["username"]; 
    $password =	$config["db"]["special_edit"]["password"];
    $db = mysqli_connect($host, $db_username, $password, $dbname) or die("Failed to estabish database connection!");

	$user_id = $_SESSION["user_id"];
	$query = "SELECT * FROM users_sets WHERE users_sets.user_id = '$user_id' AND users_sets.set_id = '$set_id' LIMIT 1";

	$result = mysqli_query($db, $query);

	if($result->num_rows > 0){
		return true;
	}
	return false;
}

function getUserSetCount()
{
	include "config.php";

	// Query our database and check if the user has $set_id 
    // open DB
    $host = $config["db"]["special_edit"]["host"];
    $dbname = $config["db"]["special_edit"]["dbname"]; 
    $db_username = $config["db"]["special_edit"]["username"]; 
    $password =	$config["db"]["special_edit"]["password"];
    $db = mysqli_connect($host, $db_username, $password, $dbname) or die("Failed to estabish database connection!");

	$user_id = $_SESSION["user_id"];
	$query = "SELECT * FROM users_sets WHERE users_sets.user_id = '$user_id'";
	$result = mysqli_query($db, $query);
	$num_of_rows = $result->num_rows;

	return $num_of_rows;
}

?>