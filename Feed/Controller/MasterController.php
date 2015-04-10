<?php

require_once('View/BaseView.php');
require_once('View/FeedView.php');
require_once('View/UploadView.php');

/**
* Master controller class
*/
class MasterController extends BaseView
{

	private $baseView;
	private $feedView;
	private $uploadPage;
	
	function __construct()
	{
		# code...
		$this->baseView = new BaseView();
		$this->feedView = new FeedView();
		$this->uploadPage = new UploadView();	
	}


		//Render menu.
		public function doControll() {
					
			$this->baseView->renderShowMenu();
			try {
					
				switch ($this->baseView->getPage()) {	

					case BaseView::$FeedView:
								$this->uploadPage->RenderUploadForm();
								return $this->feedView->GetFeedHTML();
						break;
					}
			} 
			catch (Exception $e) {

			}

		
		}

}