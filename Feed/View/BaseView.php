<?php

require_once('HTMLView.php');

/**
* Base view class
*/
class BaseView
{
	public static $FeedView = "FeedView";
	private static $page = "page";
	
	public function showMenu() {	
		    $html = "<ul class='nav navbar-nav'>
		    <li>
		    <a href='?" . self::$page . "=" . self::$FeedView . "'>Hem</a>
		    </li>
		    </ul>";
			return $html;
	}

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