<?php

require_once('View/FeedView.php');
require_once('View/Navigation.php');
require_once('View/UploadView.php');

require_once("Model/LoginModel.php");
require_once("Settings.php");
require_once("View/BaseView.php");
require_once("View/ChangePasswordView.php");
require_once("Controller/LoginController.php");
require_once("View/HTMLView.php");
require_once("View/LoggedInView.php");


class MasterController extends Navigation
{
	private $feedView;
	private $uploadView;

	private $loginController;
    private $htmlView;
    private $loggedInView;    
    private $model;

	function __construct()
	{
		$this->feedView = new FeedView();
		$this->uploadView = new UploadView();

		$this->model = new LoginModel();
		$this->loginController = new LoginController();
        $this->changePasswordView = new ChangePasswordView();
        $this->htmlView = new HTMLView();
      
	
	}

		public function doControll() 
		{			
			try 
			{		

			 if ($this->loginController->isAuthenticated() && $this->changePasswordView->didUserPressToChangePassword())
              {
                if ($this->changePasswordView->didUserPressSubmit()) 
                {
                    $this->loginController->changePassword();
                }
                
                else 
                {
                    $this->htmlView->echoHTML($this->changePasswordView->showChangePasswordForm());
                }   
            }

            // REGISTER OR LOGIN
            else 
            {
                $this->loginController->doControll();
            }
        

       
				switch (Navigation::GetPage()) {	

					case Navigation::$FeedView:
						if($this->loginController->isAuthenticated()){
						$this->uploadView->RenderUploadForm();
						return $this->feedView->GetFeedHTML();
						}
						break;
					}
				}
			 
			catch (Exception $e) {

				error_log($e->getMessage() . "\n", 3, Settings::$ERROR_LOG);
            if (Settings::$DO_DEBUG) {
                throw $e;

			}
		}
	}
}
