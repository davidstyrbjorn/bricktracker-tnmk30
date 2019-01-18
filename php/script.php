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
	$description = "Welcome to your personal collection! Here you can see a collection of sets and bricks that you own. If your list is empty, you can go to the add page to add sets that you own.";
		
	// Get user name
	if(!isset($_SESSION["logged_in"])){
		return;
	}
	if($_SESSION["logged_in"]){
		
		$user_id = $_SESSION["user_id"];
		
		$username = getUserName($user_id);
	}
	
	$set_count = getUserSetCount();
	echo "<h1>" . $username . "</h1>";
	echo "<h3>" . "You own " . $set_count . " sets!" . "</h3>";
	echo "<h5>" . $description . "</h5>";
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
			echo "<td><a href='../site/set.php?set_id=$SetID'>" . $row['Setname'] . "</a></td>";
			echo "<td>" . $row['Year'] . 	"</td>";
			$url  = "http://www.itn.liu.se/~stegu76/img.bricklink.com/" . getSetImageURL($row['has_gif'], $row['has_jpg'], $row['ItemTypeID'], $row['SetID']);
			echo "<td class='set-image'>" . "<a href='../site/set.php?set_id=$SetID'><img src='$url' alt='". $row['Setname'] ."'>" . "</a></td>";
			
			echo "<td>"; 
			echo "<form action='../php/removeset.php' method='post'>";
			echo "<input type='hidden' value='$SetID' name='SetID'>";
			echo "<button type='submit' class='remove-button'>-</button>";
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
	
	// Safe search
	$_search_string = mysqli_escape_string($db, $search_string);
	
	// First a query for the total amount of rows in the search
	if($newSearch){
		$query = "SELECT * FROM sets s, images i 
		WHERE (s.SetID = '$_search_string' OR s.Setname LIKE '%". $_search_string ."%' OR s.Year = '$_search_string') AND i.ItemID = s.SetID";
		$result = mysqli_query($db, $query);
		
		$_SESSION["search_count"] = $result->num_rows;
	}

	$page_number = $_SESSION["sets_page"];
	$offset = ($page_number-1)*$items_per_page;
	
	// Get sets form database
	$query = "SELECT s.SetID, s.Setname, s.Year, i.ItemTypeID, i.has_jpg, i.has_gif FROM sets s, images i 
	WHERE (s.SetID = '$_search_string' OR s.Setname LIKE '%". $_search_string ."%' OR s.Year = '$_search_string') AND i.ItemID = s.SetID 
	ORDER BY s.Setname LIKE CONCAT('$_search_string', '%') DESC, 
	IFNULL(NULLIF(INSTR(s.Setname, CONCAT(' ', '$_search_string')), 0), 99999),
	IFNULL(NULLIF(INSTR(s.Setname, '$_search_string'), 0), 99999),
	s.Setname, s.Year DESC
	LIMIT $offset,$items_per_page";                                            
	$result = mysqli_query($db, $query);

	$table_row_class = "dark-tr";	
	
	if($result->num_rows == 0){
		emptySearch();
	}
	else{
		echo "<table class='lego-table'>";
		echo "<tr>";
		echo "<th>ID</th>";
		echo "<th>NAME</th>";
		echo "<th>YEAR</th>";
		echo "<th>IMAGE</th>";
		echo "<th>ADD</th>";
		echo "</tr>";
		
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
				
			$set_name = $row["Setname"];
			$set_id = $row["SetID"];
				
			// Display the row
			echo "<tr class='$table_row_class'>";
			echo "<td>" . $SetID . 	"</td>";
			echo "<td><a href='../site/set.php?set_id=$SetID'>" . $row['Setname'] . "</a></td>";
			echo "<td>" . $row['Year'] . 	"</td>";
			$url  = "http://www.itn.liu.se/~stegu76/img.bricklink.com/" . getSetImageURL($row['has_gif'], $row['has_jpg'], $row['ItemTypeID'], $row['SetID']);
			echo "<td class='set-image'>" . "<img src='$url' alt='$set_id'>" . "</td>";
			echo "<td>"; 
			
			echo "<form action='../php/addset.php' method='post'>";
			echo "<input type='hidden' value='$SetID' name='SetID'>";
			echo "<button type='submit' class='add-button'>+</button>";
			echo "</form>";
			echo "</td>";
			
			echo "</tr>";
			
			if($hasSet)
				$table_row_class = substr($table_row_class, 0, strlen($table_row_class)-4);
		}	
		
		echo "</table>";
	}
}

// Used at set.php
function displaySetInfo($set_id)
{
	include "config.php";
	// Open DB
	$host = $config["db"]["big_lego_database"]["host"];
	$dbname = $config["db"]["big_lego_database"]["dbname"]; 
	$db_username = $config["db"]["big_lego_database"]["username"]; 
	$password =	$config["db"]["big_lego_database"]["password"];
	$db = mysqli_connect($host, $db_username, $password, $dbname) or die("Failed to estabish database connection!" . "<br/>HOST:$host");
	
	$query = "SELECT * FROM sets, images, categories WHERE sets.SetID = '$set_id' AND images.ItemID = '$set_id' AND sets.CatID = categories.CatID LIMIT 1";
	$result = mysqli_query($db, $query);
	$row = mysqli_fetch_array($result);
	
	// Get image url & maybe display if there is an image 
	$image_suffix = "none";
	if($row["has_largejpg"]) {
		$image_suffix = ".jpg";
	}
	else if($row["has_largegif"]) {
		$image_suffix = ".gif";
	}
	// Was there an image?
	if($image_suffix != "none") {
		$url = "http://www.itn.liu.se/~stegu76/img.bricklink.com/" . $row["ItemTypeID"] . "L/" . $row["ItemID"] . $image_suffix;
		echo "<div><img class='set-img' src='$url' alt='$set_id'></div>";
	}
	
	echo "<div class='header-window-text'>";
	echo "<h2>" . $row["Setname"] . "</h2>";
	
	echo "<ul>";
	
	echo "<li>ID: " . $set_id . "</li>";
	echo "<li>Year: " . $row["Year"] . "</li>";
	echo "<li>Category: " . $row["Categoryname"] . "</li>";
	
	echo "</ul>";
    
    echo "<form action='../php/addset.php' method='post'>";
    echo "<input type='hidden' value='$set_id' name='SetID'>";
    echo "<input type='hidden' name='SetPage' value='true'>";
    echo "<button type='submit' class='add-button'>+</button>";
    echo "</form>";
	
	echo "</div>";
}

// Used at set.php
function displaySetPieces($set_id) 
{
	include "config.php";
	// Open DB
	$host = $config["db"]["big_lego_database"]["host"];
	$dbname = $config["db"]["big_lego_database"]["dbname"]; 
	$db_username = $config["db"]["big_lego_database"]["username"]; 
	$password =	$config["db"]["big_lego_database"]["password"];
	$db = mysqli_connect($host, $db_username, $password, $dbname) or die("Failed to estabish database connection!" . "<br/>HOST:$host");
	
	// Page set?	
	if(!isset($_SESSION["bricks_page"])){
		$_SESSION["bricks_page"] = 1;
	}
	if(!isset($_SESSION["bricks_count"])){
		$query = "SELECT * FROM inventory,parts,images,colors WHERE 
		inventory.SetID = '$set_id' AND
		inventory.ItemtypeID = 'P' AND
		colors.ColorID = inventory.ColorID AND
		parts.PartID = inventory.ItemID AND
		images.ItemID = inventory.ItemID AND
		images.ColorID = inventory.ColorID";
		
		$result = mysqli_query($db, $query);
		
		$_SESSION["bricks_count"] = $result->num_rows;
	}	
	
	$page_number = $_SESSION["bricks_page"];
	$offset = ($page_number-1)*$items_per_page;	

	$query = "SELECT * FROM inventory,parts,images,colors WHERE 
	inventory.SetID = '$set_id' AND
	inventory.ItemtypeID = 'P' AND
	colors.ColorID = inventory.ColorID AND
	parts.PartID = inventory.ItemID AND
	images.ItemID = inventory.ItemID AND
	images.ColorID = inventory.ColorID 
	LIMIT $offset,$items_per_page";
	
	$result = mysqli_query($db, $query);

	$table_row_class = "dark-tr";
	
	while($row = mysqli_fetch_array($result)){
		// Toggle row class!		
		if($table_row_class == "dark-tr")
			$table_row_class = "light-tr";
		else
			$table_row_class = "dark-tr";

		echo "<tr class = '$table_row_class'>";
		
		// SetID
		echo "<td>" . $set_id . "</td>";
		// Name
		echo "<td>" . $row["Partname"] . "</td>";
		// Quantity
		echo "<td>" . $row["Quantity"] . "</td>";
		// Image
		$image_suffix = "none";
		if($row["has_gif"]) { 
			$image_suffix = ".gif";
		}
		elseif($row["has_jpg"]) {
			$image_suffix = ".jpg";
		}
		if($row["ItemTypeID"] == 'P'){
			$url = "http://www.itn.liu.se/~stegu76/img.bricklink.com/" . $row["ItemTypeID"] . "/" . $row["ColorID"] . "/" . $row["ItemID"];
		}		
		echo "<td>" . "<img src='$url' alt='$set_id'>" . "</td>";
		
		echo "</tr>";
	}
	
}

/* UGLY PAGINATION FUNCTIONS */
function displayPaginationAddSets()
{
	// Page related
	$page_number = $_SESSION["sets_page"];
	$max_page_number = getNumberOfPages($_SESSION['search_count']);
	
	echo "<form action='../php/pagination_page_switch.php' method='POST'>";
	echo "<table class='pagination'>";
	echo "<tr>";
	echo "<td> <input type='submit' class='pagination-button' name='pagination_left_sets' value='<' /> </td>";
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

function resetMyPage()
{
	$_SESSION["mypage_page"] = 1;
}

function resetBricksPage()
{
	unset($_SESSION["bricks_count"]);
	$_SESSION["bricks_page"] = 1;
}

function displayPaginationMypage()
{
	// Page related
	$page_number = $_SESSION["mypage_page"];
	$max_page_number = getNumberOfPages($_SESSION['user_set_count']);

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

function displayPagenationBricks($set_id)
{
	$page_number = $_SESSION["bricks_page"];
	$max_page_number = getNumberOfPages($_SESSION["bricks_count"]);
	
	echo "<form action='../php/pagination_page_switch.php?set_id=$set_id' method='POST'>";
	echo "<table class='pagination'>";
	
	echo "<tr>";
	echo "<td> <input type='submit' class='pagination-button' name='pagination_left_bricks' value='<'/> </td> ";
	echo "<td>$page_number / " . $max_page_number . "</td>";
	echo "<td> <input type='submit' class='pagination-button' name='pagination_right_bricks' value='>'/> </td> ";
	echo "</tr>";
	
	echo "</table>";
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

// Given a total, calculates number of pages using config values for items per page
function getNumberOfPages($total_item_count){
	
	include "config.php";
	
	$page_number = 0;
	if($total_item_count <= $items_per_page){
		$page_number = 1;
	}
	else{
		$page_number = ceil($total_item_count / $items_per_page);
	}
	
	return $page_number;
}

function getUserName($user_id){
	
	include "config.php";
	
	$host = $config["db"]["special_edit"]["host"];
    $dbname = $config["db"]["special_edit"]["dbname"]; 
    $db_username = $config["db"]["special_edit"]["username"]; 
    $password =	$config["db"]["special_edit"]["password"];
    $db = mysqli_connect($host, $db_username, $password, $dbname) or die("Failed to estabish database connection!");

	$query = "SELECT * FROM users WHERE users.user_id = '$user_id'";
	$result = mysqli_query($db, $query);
	$row = mysqli_fetch_array($result);
	$username = $row["username"];
	
	return $username;
}

// Echoes the footer as is, for simplicity instead of copy pasting all over
function displayFooter()
{
	$footer = "        
	<footer>  
	<div class='wrapper'>
		<div class='footer-sections'>
			<div class='footer-section'>
				<ul>
					<li class='list-header'>BrickTracker</li>
					<li><a>©2019 BrickTracker</a></li>
					<li><a>David Styrbjörn, Emil Bertholdsson, Linus Karlsson, Max Benecke</a></li>
				</ul>
			</div>
			<div class='footer-section'>
				<ul>
					<li class='list-header'>Help</li>
					<li><a href='../site/terms.php' class='footer-link'>Terms & Privacy</a></li>
				</ul>
			</div>
			<div class='footer-section'>
				<ul>
					<li class='list-header'>Contact</li>
					<li><a>For any site or account related questions, please </a><a class='footer-link' href = 'mailto:brick_tracker_team@gmail.com'>contact us.</a></li>
				</ul>
			</div>
		</div>
	</div>
	</footer>";

	echo $footer;
}

function emptyMyPage()
{
	echo '<h3 class="feedback-text">Go to the "Add" page via the navbar to add sets to your collection!</h3>';
}

function emptySearch()
{
	echo "<h3 class='feedback-text'>Sorry we couldn't find anything with that searchword.</h3>";
}

function noSearch()
{
	echo "<h3 class='feedback-text'>Go ahead, type a searchword</h3>";
}

function echoModal()
{
	$modal_html = "
	<div id='modal'>
	<p>You're gonna be logged out in a minute, cause: IDLE</p>
	</div>
	";
	echo $modal_html;
}

?>