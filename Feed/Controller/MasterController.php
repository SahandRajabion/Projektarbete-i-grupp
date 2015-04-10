<?php

require_once('View/FeedView.php');
require_once('View/Navigation.php');


class MasterController extends Navigation
{
	private $feedView;

	function __construct()
	{
		$this->feedView = new FeedView();
	}

		public function doControll() 
		{			
			try 
			{		
				switch (Navigation::GetPage()) {	

					case Navigation::$FeedView:
						return $this->feedView->GetFeedHTML();
						break;
					}
			} 
			catch (Exception $e) {

			}
		}
}