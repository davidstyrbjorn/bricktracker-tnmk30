<?php

require_once("php/config.php");

$host = $config["db"]["special_admin"]["host"];
$dbname = $config["db"]["special_admin"]["dbname"]; 
$username = $config["db"]["special_admin"]["username"]; 
$password =	$config["db"]["special_admin"]["password"];

$db = mysqli_connect($host, $username, $password, $dbname) or die();
//mysqli_query($db, "INSERT INTO users(username, email, pword) VALUES('bitch-emil', 'davidstyrbjorn@gmail.com', 'nonhashedpword')");
$result = mysqli_query($db, "SELECT * FROM users");

while($row = mysqli_fetch_array($result)){
	echo $row["username"] . "<br/>";
}

//
////$dsn = "mysql:host=$host;dbname:$dbname";
////$pdo = null;
////try{
////	$pdo = new PDO($dsn, $username, $password);
////} catch(PDOException $e){
////	echo $e->getMessage();
////	die();
////}
//
//$db = mysqli_connect($host, $username, $password, $dbname) or die("oof");
//$query = "CREATE TABLE users_sets(
//user_id INTEGER NOT NULL,
//set_id VARCHAR(255) NOT NULL 
//)";
//$result = mysqli_query($db, $query);
//if(!$result){
//	echo "Error description " . mysqli_error($db) . "<br/>";
//}
//
//$describe = mysqli_query($db, "DESCRIBE users");
//while($row = mysqli_fetch_array($describe)){
//	echo "{$row['Field']} - {$row['Type']}\n";
//}
//
////try{
////	$query = "CREATEdWADwadd TABdwadwadLEdwadwa tewdawdst (id INT)";
////	
////	// Perform query
////	$x = $pdo->prepare($query);
////	$x->execute();	 
////	
////} catch(PDOException $e){ 
////    echo $e->getMessage();
////	die();
////} 
//
//
////$query2 = $pdo->prepare("DESCRIBE test");
////$query2->execute();
////$table_fields = $query2->fetchAll(PDO::FETCH_COLUMN);

?>