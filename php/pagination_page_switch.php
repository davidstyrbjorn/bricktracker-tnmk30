<?php

session_start();

$go_back_to_search = false;
$go_back_to_mypage = false;

if(isset($_POST["pagination_left_sets"])){
	// Decrease current page
	if($_SESSION["sets_page"] > 1){
		$_SESSION["sets_page"]--;
	}
	$go_back_to_search = true;
}
else if(isset($_POST["pagination_right_sets"])){
	// Increase current page

	include "config.php";

	// Get max page number
	$max_page_number = 0;
	if($_SESSION['search_count'] < $items_per_page){
		$max_page_number = 1;
	}
	else{
		$max_page_number = (int)($_SESSION['search_count'] / $items_per_page);
	}	

	if($_SESSION["sets_page"] <= $max_page_number) {
		$_SESSION["sets_page"]++;
	}
	$go_back_to_search = true;
}
else if(isset($_POST["pagination_left_mypage"])){
	$go_back_to_mypage = true;
	if($_SESSION["mypage_page"] > 1){
		$_SESSION["mypage_page"]--;
	}
}
else if(isset($_POST["pagination_right_mypage"])){

	include "config.php";

	$max_page_number = 0;
	if($_SESSION['user_set_count'] <= $items_per_page){
		$max_page_number = 1;
	}
	else{
		$max_page_number = (int)(round(($_SESSION['user_set_count'] / $items_per_page)+0.5));
	}

	if($_SESSION["mypage_page"] < $max_page_number){
		$_SESSION["mypage_page"]++;
	}
	$go_back_to_mypage = true;
}

if($go_back_to_search){
	$last_search = $_SESSION['last_search'];
	header("location:../site/add.php? search_string=" . $last_search);
}
else{
	header("location:../site/mypage.php");
}

?>