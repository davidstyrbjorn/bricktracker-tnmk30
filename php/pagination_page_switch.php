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
	$_SESSION["sets_page"]++;
	$go_back_to_search = true;
}
else if(isset($_POST["pagination_left_mypage"])){
	$go_back_to_mypage = true;
	if($_SESSION["mypage_page"]){
		$_SESSION["mypage_page"]--;
	}
}
else if(isset($_POST["pagination_right_mypage"])){
	$go_back_to_mypage = true;
	$_SESSION["mypage_page"]++;
}

if($go_back_to_search){
	$last_search = $_SESSION['last_search'];
	header("location:../site/add.php? search_string=" . $last_search);
}
else{
	header("location:../site/mypage.php");
}

?>