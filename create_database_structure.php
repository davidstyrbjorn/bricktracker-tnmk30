<?php

require_once("php/config.php");

$host = $config["db"]["special_admin"]["host"];
$dbname = $config["db"]["special_admin"]["dbname"]; 
$username = $config["db"]["special_admin"]["username"]; 
$password =	$config["db"]["special_admin"]["password"];


require_once("php/script.php");
displayOwnedSets();

/*

$db = mysqli_connect($host, $username, $password, $dbname) or die("cant connect");
//mysqli_query($db, "INSERT INTO users(username, email, pword) VALUES('bitch-emil', 'davidstyrbjorn@gmail.com', 'nonhashedpword')");
$result = mysqli_query($db, "SELECT * FROM users");
//$result = mysqli_query($db, "DELETE FROM users");

while($row = mysqli_fetch_array($result)){
	echo $row["username"] . ", " . $row["email"] . $row["user_id"] . "<br/>";
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
$db = mysqli_connect($host, $username, $password, $dbname) or die("oof");
$query = "CREATE TABLE users_sets(
user_id INTEGER NOT NULL,
set_id VARCHAR(255) NOT NULL 
)";
//$result = mysqli_query($db, $query);
//if(!$result){
//	echo "Error description " . mysqli_error($db) . "<br/>";
//}

$describe = mysqli_query($db, "SELECT * FROM users_sets WHERE users_sets.user_id = '11'");
while($row = mysqli_fetch_array($describe)){
	echo $row['user_id'] . " : " . $row['set_id'] . '<br/>';
}

/*		
// INSERT INTO TABLE	
$query = "INSERT INTO users_sets (user_id, set_id) VALUES('11', '5812-1')";

if(mysqli_query($db, $query)){
	echo "Inserted set!";
}
else{
	echo "Error: " . $sql . "<br>" . mysqli_error($db);
}
*/

////$query2 = $pdo->prepare("DESCRIBE test");
////$query2->execute();
////$table_fields = $query2->fetchAll(PDO::FETCH_COLUMN);

?>