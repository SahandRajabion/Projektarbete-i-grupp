<?php

class Token 
{
	public static function generate() 
	{
		$token = md5(uniqid(rand(), TRUE));
		$_SESSION['CSRFToken'] = $token;

		return $token;
	}

	public static function check($token) 
	{
		if (isset($_SESSION['CSRFToken']) && $token === $_SESSION['CSRFToken']) 
		{
			unset($_SESSION['CSRFToken']);
			return true;
		}
		
		return false;
	}
}