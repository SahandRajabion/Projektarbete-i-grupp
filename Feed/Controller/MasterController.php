<?php
 
require_once('View/FeedView.php');
require_once('View/Navigation.php');
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
	private $loginController;
    private $htmlView;
    private $loggedInView;    
    private $model;
    private $forgetPasswordView;
    private $userRepository;
    private $code;
    private $resetPasswordView;
    private $emailExp;
	private static $ErrorEmailMessage = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 	         <button type="button" class="close" data-dismiss="alert">
  							   	         <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  								         <strong>Eposten var fel formlerat!</strong></div>';

	function __construct()
	{
		$this->feedView = new FeedView();
		$this->forgetPasswordView = new ForgetPasswordView();
		$this->model = new LoginModel();
		$this->loginController = new LoginController();
        $this->changePasswordView = new ChangePasswordView();
        $this->htmlView = new HTMLView();
      	$this->userRepository = new UserRepository();
      	$this->resetPassword = new ResetPasswordView();
      	$this->emailExp = "/^[a-z0-9\å\ä\ö._-]+@[a-z0-9\å\ä\ö.-]+\.[a-z]{2,6}$/i";
	}

		public function doControll() 
		{			
			try 
			{	

			if ($this->forgetPasswordView->pressSubmitToSend() && !$this->resetPassword->issetCode()) {
					# code...
				if (!preg_match($this->emailExp, $this->getEmail())) {
					# code...
					echo self::$ErrorEmailMessage;
				}
				else
				{
					
					$userEmail = $this->userRepository->getEmailForResetPassword($this->getEmail());

				  if($userEmail != ""){
					
					if($this->getEmail() == $userEmail->getEmail()) {
						$date = date('Y-m-d H:i:s');
						$this->code = rand(10000,1000000);
						$to = $userEmail->getEmail();
						$subject = "LSN/ Forgot password";
						$message = "Hej!
						(Det här meddelandet går inte att svara på).
						OBS// Länken är endast aktiv i 20 minuter.

						För att ändra lösenordet klicka på länken nedan:
								 
						http://www.sahibsahib.com/LSN/Feed/?gjaQwrA=$this->code&kjAmsdNg";

						$headers = 'From: lsn@sahibsahib.com' . "\r\n" .
								   'X-Mailer: PHP/' . phpversion();

						$successMSG = '<div class="alert alert-success alert-dismissible" role="alert">
  							 				 <button type="button" class="close" data-dismiss="alert">
  											 <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										     Ett meddelande med information om din inloggning uppgifter har skickat till <strong>'.$this->getEmail().'</strong></div>';

						$this->userRepository->resetPassword($this->code,$this->getEmail());
						$this->userRepository->resetPasswordTime($date,$this->getEmail());
						
						if (mail($to, $subject, $message,$headers)) {
							# code...
							echo $successMSG;
						 }
						}
							
					 
				  }
				else
					  {
						$successMSG = '<div class="alert alert-success alert-dismissible" role="alert">
  							 				 <button type="button" class="close" data-dismiss="alert">
  											 <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										     Ett meddelande med information om din inloggning uppgifter har skickat till <strong>'.$this->getEmail().'</strong></div>';
  						echo $successMSG;
					}	

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
                    return $this->changePasswordView->showChangePasswordForm();
                }   
            }

            // REGISTER OR LOGIN
            else 
            {
                $this->loginController->doControll();
            }
        

       
				switch (Navigation::GetPage()) {	

					case Navigation::$FeedView:
						if($this->loginController->isAuthenticated())
						{
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
