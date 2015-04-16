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
require_once("View/ForgetPasswordView.php");
require_once("View/ResetPasswordView.php");


class MasterController extends Navigation
{
	private $feedView;
	private $uploadView;
	private $loginController;
    private $htmlView;
    private $loggedInView;    
    private $model;
    private $forgetPasswordView;
    private $userRepository;
    private $code;
    private $resetPasswordView;

	function __construct()
	{
		$this->feedView = new FeedView();
		$this->uploadView = new UploadView();	
		$this->forgetPasswordView = new ForgetPasswordView();
		$this->model = new LoginModel();
		$this->loginController = new LoginController();
        $this->changePasswordView = new ChangePasswordView();
        $this->htmlView = new HTMLView();
      	$this->userRepository = new UserRepository();
      	$this->resetPassword = new ResetPasswordView();
	}

		public function doControll() 
		{			
			try 
			{	

			if ($this->forgetPasswordView->pressSubmitToSend() && !$this->resetPassword->issetCode()) {
					# code...
					$userEmail = $this->userRepository->getEmailForResetPassword($this->getUsername());
					
					if($this->getEmail() == $userEmail->getEmail()) {

						$this->code = rand(10000,1000000);
						$to = $userEmail->getEmail();
						$subject = "LSN/ Forget password";
						$message = "(Det här meddelandet går inte att svara på).

								 För att ändra lösenordet klicka på länken nedan:
								 
								 http://www.sahibsahib.com/LSN/Feed/?code=$this->code&username=".$this->getUsername();

						$this->userRepository->resetPassword($this->code,$this->getUsername());
						
 						echo("Ett meddelande med information om din inloggning uppgifter har skickat till <strong>".$this->getEmail()."</strong>.");
						mail($to, $subject, $message);		 
					}	

				}	

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


	public function getUsername() {
		return $this->forgetPasswordView->getUsername();	
	}

	public function getEmail() {
		return $this->forgetPasswordView->getEmail();
	}
}
