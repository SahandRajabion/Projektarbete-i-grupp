<?php


require_once('HTMLView.php');

/**
* Base view class
*/
class BaseView
{
	private $mainView;
	public static $FeedView = "FeedView";
	private static $page = "page";
	
	function __construct()
	{
		# code...
		$this->mainView = new HTMLView();
	}



		//Show menu
		public function showMenu() {	
			    $html = "<ul class='nav navbar-nav'>";
			    $html .= "<li><a href='?".self::$page."=".self::$FeedView."'>Hem</a></li>";
				$html .= "</ul>";
				$html .= "</div>";
				$html .="</nav>";
				return $html;

		}

		// render show menu
		public function renderShowMenu() {

			$html = $this->showMenu();
			echo $this->mainView->echoHTML($html);
		}


		public function RedirectToHomePage() {
			header('Location:' .$_SERVER['PHP_SELF']);
		}



		public function getPage() {
			if (isset($_GET[self::$page])) {
				return $_GET[self::$page];
			}
			return self::$FeedView;
		}


}