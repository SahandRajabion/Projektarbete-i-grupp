<?php


	
	class CookieStorage {

		private static $cookieMsg = "msg";
		
		public function __construct() {
			
		}


		public function SaveMessageCookie($Message) {
			setcookie(self::$cookieMsg, $Message, time() + 60, "/");
		}

		public function DeleteMessageCookie() {
			setcookie(self::$cookieMsg, "", 1, "/");
		}

		public function GetMessageCookie() {
			if(isset($_COOKIE[self::$cookieMsg])) {
				return $_COOKIE[self::$cookieMsg];
			}
		}	
	}