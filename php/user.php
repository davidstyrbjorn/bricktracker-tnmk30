<?php

class User{
	
	private static $username = "none";
	private static $user_id = -1;
	private static $logged_in = false;
	private static $initalized = false;
	
	// This prevents instancing of this class since it's purpose is to be a static class!
	private function __construct() {}
	
	private static function initalize()
	{
		if(self::$initalized)
			return;
		
		self::$initalized = true;
	}

	public static function logIn($username, $user_id)
	{
		self::$username = $username;
		self::$user_id = $user_id;
		self::$logged_in = true;
	}
	
	public static function logOut()
	{
		self::$logged_in = false;
	}
	
	public static function getUsername()
	{
		return self::$username;
	}
	
	public static function getUserID()
	{
		return self::$user_id;
	}
	
}

?>