<?php

class Navigation
{
	public static $FeedView = "FeedView";
	private static $page = "page";

	public function RedirectToRoot() {
		header('Location:' . $_SERVER['PHP_SELF']);
	}

	public static function GetPage() {
		if (isset($_GET[self::$page])) {
			return $_GET[self::$page];
		}
		return self::$FeedView;
	}

}