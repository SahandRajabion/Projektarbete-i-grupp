<?php

require_once('View/BaseView.php');
require_once('Controller/UploadController.php');
require_once('View/FeedView.php');

/**
* Master controller class
*/
class MasterController extends BaseView
{

	private $baseView;
	private $uploadController;
	private $feedView;
	
	function __construct()
	{
		# code...
		$this->baseView = new BaseView();
		$this->uploadController = new UploadController();
		$this->feedView = new FeedView();
	}


	//Render menu.
		public function doControll() {
					
			$this->baseView->renderShowMenu();
			try {
					 
					
				switch ($this->baseView->getPage()) {
					

					case BaseView::$FeedView:
								$this->uploadController->imgUpload();
						return $this->feedView->renderAllPicsForUsers();
					
								   

						break;
					}
				
			} 
			catch (Exception $e) {

			}

			
	ob_flush();

		}

}