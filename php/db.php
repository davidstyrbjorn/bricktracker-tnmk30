<?php

class PDODatabseConnection {
	public $pdo;
	
	function __construct($host, $dbname, $username, $password) {
		// Open PDO connection
		try{
			$dsn = "mysql:host=$host;dbname=$dbname";
			$pdo = new PDO($dsn, $username, $password);
		} catch(PDOException $e){
			echo "PDO Conn ERROR: " . $e->getMessage() . "<br/>";
			die();
		}
	}
	
	function __destruct() {
		// Close PDO connection
		 $pdo = null;
	}
}

?>