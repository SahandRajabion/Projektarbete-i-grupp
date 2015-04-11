<?php

require_once('View/FeedView.php');
require_once('View/Navigation.php');
require_once('View/UploadView.php');

class MasterController extends Navigation
{
	private $feedView;
	private $uploadView;

	function __construct()
	{
		$this->feedView = new FeedView();
		$this->uploadView = new UploadView();
	}

		public function doControll() 
		{			
			try 
			{		
				switch (Navigation::GetPage()) {	

					case Navigation::$FeedView:
						$this->uploadView->RenderUploadForm();
						return $this->feedView->GetFeedHTML();
						break;
					}
			} 
			catch (Exception $e) {

			}
		}
}