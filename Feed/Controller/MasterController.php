<?php

require_once('View/FeedView.php');
require_once('View/BaseView.php');


class MasterController extends BaseView
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
				switch (BaseView::GetPage()) {	

					case BaseView::$FeedView:
						return $this->feedView->GetFeedHTML();
						break;
					}
			} 
			catch (Exception $e) {

			}
		}
}