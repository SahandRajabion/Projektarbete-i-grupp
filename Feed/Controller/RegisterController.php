<?php

	
	require_once('View/RegisterView.php');
	require_once("Validation/ValidateUsername.php");
	require_once("Validation/ValidatePassword.php");
	require_once("Validation/ValidateNewUser.php");
	/**
	* Register controll
	*/
	class RegisterController
	{
		public $registerView;
		public $validationErrors = 0;
		private $validateUsername;
		private $validatePassword;
		private $model;
		public $showRegisterPage;
		public $showForgetPasswordPage;
		public $showResetPasswordPage;
		public $showContactPage;
		private $loginView;
		private $validateNewUser;
		private $hash;
		private $userRepository;
		private $resetPassword;
		public $showProfilePage;
		private $programView;
		private $profileView;
		private $contactPage;
		private $forgetPasswordView;

		function __construct(ForgetPasswordView $forgetPasswordView,ContactView $contactPage,ProfileView $profileView,ValidateUsername $validateUsername,ValidatePassword $validatePassword,ValidateNewUser $validateNewUser,LoginModel $model, UserRepository $userRepository, Hash $hash, ResetPasswordView $resetPasswordView, ProgramView $programView,LoginView $loginView)
		{
			# code...
			$this->model = $model;
			$this->registerView = new RegisterView();
			$this->validateUsername = $validateUsername;
			$this->validatePassword = $validatePassword;
			$this->loginView = $loginView;
			$this->validateNewUser = $validateNewUser;
			$this->hash = $hash;
			$this->userRepository = $userRepository;
			$this->resetPassword = $resetPasswordView;
			$this->programView = $programView;
			$this->profileView = $profileView;
			$this->contactPage = $contactPage;
			$this->forgetPasswordView = $forgetPasswordView;
		}






		 /**
     * register a user
     */
    public function registerNewUser() {
        if ($this->registerView->didUserPressSubmit()) {

            if (isset($_POST["recaptcha_challenge_field"])) 
            {

            $resp = recaptcha_check_answer (Settings::$SECRET_KEY,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
            $username = $this->registerView->getUsername(); 
            $email = $this->registerView->getEmail(); 
            $confirmEmail = $this->registerView->getConfirmEmail(); 
            $fName = $this->registerView->getFname(); 
            $lName = $this->registerView->getLname(); 
            $sex = $this->registerView->getSex();
            $birthday = $this->registerView->getBirthday();
            
            $schoolForm = $this->registerView->getSchoolForm();
            $institute = $this->registerView->getInstitute(); 
            $password = $this->registerView->getPassword();
            $confirmPassword = $this->registerView->getConfirmPassword();
            $token = $this->registerView->getToken();

            if (Token::check($token)) 
            {
                if ($this->validationErrors == 0) 
                {
                    if($this->validateUsername->validateUsernameLength($username) == false) 
                    {
                        $msgId = 8;
                        $this->validationErrors++;
                        $this->model->setMessage($msgId);
                        $this->setMessage();
                    }
                }
                
                if ($this->validationErrors == 0) {
                    if($this->validateUsername->validateCharacters($username) == false || preg_match(Settings::$REGEX, $username)) {
                        $msgId = 4;
                        $this->validationErrors++;
                        $this->model->setMessage($msgId);
                        $this->setMessage();                    
                    }   
                }

                if ($this->validationErrors == 0) {
                    if ($this->validatePassword->validatePasswordLength($password, $confirmPassword) == false) {
                        $msgId = 7;
                        $this->validationErrors++;
                        $this->model->setMessage($msgId);
                        $this->setMessage();
                    }
                    else {
                        if($this->validatePassword->validateIfSamePassword($password, $confirmPassword) == false) {
                            $msgId = 6;
                            $this->validationErrors++;
                            $this->model->setMessage($msgId);
                            $this->setMessage();
                        }
                    }
                }
                if ($this->validationErrors == 0) {
                    if($this->validateUsername->validateCharacters($password) == false || preg_match(Settings::$REGEX, $password)) {
                        $msgId = 23;
                        $this->validationErrors++;
                        $this->model->setMessage($msgId);
                        $this->setMessage();                    
                    }   
                }            
                if ($this->validationErrors == 0) {
                    if($this->validateNewUser->validateIfSameEmail($email, $confirmEmail) == false) {
                            $msgId = 25; 
                            $this->validationErrors++;
                            $this->model->setMessage($msgId);
                            $this->setMessage();
                    }
                }
                 if ($this->validationErrors == 0) {
                    if($this->validateNewUser->validateEmail($email, $confirmEmail)==false) {
                            $msgId = 28; 
                            $this->validationErrors++;
                            $this->model->setMessage($msgId);
                            $this->setMessage();
                    }
                }
                  if ($this->validationErrors == 0) {
                    if($this->validateNewUser->validateNames($fName, $lName) == false) {
                            $msgId = 29; 
                            $this->validationErrors++;
                            $this->model->setMessage($msgId);
                            $this->setMessage();
                    }
                }
                  if ($this->validationErrors == 0) {
                    if($this->validateNewUser->validateSex($sex) == false) {
                            $msgId = 30; 
                            $this->validationErrors++;
                            $this->model->setMessage($msgId);
                            $this->setMessage();
                    }
                }
                  if ($this->validationErrors == 0) 
                  {
                    if($this->validateNewUser->validateBirthday($birthday) == false) {
                        if (isset($birthday) && empty($birthday) == false) {
                            $msgId = 31; 
                            $this->validationErrors++;
                            $this->model->setMessage($msgId);
                            $this->setMessage();
                        }
                    }
                }
                 if ($this->validationErrors == 0) {
                    if($this->validateNewUser->validateSchoolForm($schoolForm) == false) {
                            $msgId = 32; 
                            $this->validationErrors++;
                            $this->model->setMessage($msgId);
                            $this->setMessage();
                    }
                }
                  if ($this->validationErrors == 0) {
                    if($this->validateNewUser->validateInstitute($institute) == false) {
                            $msgId = 33; 
                            $this->validationErrors++;
                            $this->model->setMessage($msgId);
                            $this->setMessage();
                    }
                }
                if ($this->validationErrors == 0) 
                {
                    if (!$resp->is_valid) 
                    {
                        $msgId = 14;
                        $this->validationErrors++;
                        $this->model->setMessage($msgId);
                        $this->setMessage();                
                    }
                }
                  
                if($this->validationErrors == 0 && $resp->is_valid) {
                   $hash = $this->hash->crypt($password);
                   $newUser = new User($username, $hash, $email, $fName, $lName, $sex, $birthday, $schoolForm, $institute);
                   if ($this->userRepository->exists($username) == false) 
                   {
                 
                       if($this->userRepository->existsEmail($email) == false){
                        $id = $this->userRepository->add($newUser);
                        $this->userRepository->addDetails($newUser, $id);
                        $msgId = 12;
                        $this->model->setMessage($msgId);
                        $this->showRegisterPage = false;
                        $this->setMessage();
                        $this->loginView->setRegister($username);                
                       }
                       else 
                       {
                             $msgId = 57;
                    $this->model->setMessage($msgId);
                    $this->setMessage();
                     }
                }
                
                 else {
                    $msgId = 5;
                    $this->model->setMessage($msgId);
                    $this->setMessage();
                   }    
         
                }
            }

            }

            else 
            {
                    $msgId = 55;
                    $this->model->setMessage($msgId);
                    $this->setMessage();
            }

        }
    }


     public function setMessage() {

        $message = new LoginMessage($this->model->getMessage());

        if (!$this->model->isLoggedIn()) 
        {
        
            if ($this->showRegisterPage) {

                $this->registerView->setMessage($message->getMessage());
            }

            else if ($this->showForgetPasswordPage) 
            {
                $this->forgetPasswordView->setMessage($message->getMessage());
            }

            else if($this->showResetPasswordPage) {
                $this->resetPassword->setMessage($message->getMessage());
            }

            else if ($this->showContactPage) 
            {
                $this->contactPage->setMessage($message->getMessage());
            }

            else 
            {
                $this->loginView->setMessage($message->getMessage());
            }
        }
        else
        { 
            if ($this->showProfilePage) 
            {
                $this->profileView->setMessage($message->getMessage());
            }

            else 
            {
                $this->programView->setMessage($message->getMessage());
            }
        }
    }




     public function didGetResetPasswordPage() {
               
                 if ($this->resetPassword->issetCode()) {

                    $date = date("Y-m-d H:i:s");
                    $userEmail = $this->userRepository->getDateForResetPassword($this->getCode());

                    if ($userEmail !== null && isset($userEmail)) { 

                        $fastDate = date("Y-m-d H:i:s",strtotime(date($userEmail->getDate())." +20 minutes"));
                    if ($fastDate > $date) {
                        # code...
                    
                    $this->registerController->showResetPasswordPage = true;
                    $this->registerController->showForgetPasswordPage = false;
                    $this->showLoginpage = false;
                    $code = $this->resetPassword->getCode();
                    if ($this->userRepository->getAllUserInfoForPassUpdate($code) == true) {
                        # code...
                        if ($this->resetPassword->didUserPressSubmit()) {
                        # code...
                            $newConfirmPassword = $this->resetPassword->getNewPassword();
                            $newPassword = $this->resetPassword->getNewConfirmPassword();      

                            if ($this->registerController->validationErrors  == 0) 
                            {
                                if ($this->validatePassword->validatePasswordLength($newPassword, $newConfirmPassword) == false) {
                                        $msgId = 18; 
                                        $this->registerController->validationErrors ++;
                                        $this->model->setMessage($msgId);
                                        $this->registerController->setMessage();
                                }
                                else 
                                {
                                    if ($this->validatePassword->validateIfSamePassword($newPassword, $newConfirmPassword) == false) 
                                    {
                                            $msgId = 6; 
                                            $this->registerController->validationErrors ++;
                                            $this->model->setMessage($msgId);
                                            $this->registerController->setMessage(); 
                                    }
                                }
                            }

                            if ($this->registerController->validationErrors  == 0) {
                                if($this->validateUsername->validateCharacters($password) == false || preg_match(Settings::$REGEX, $password)) {
                                        $msgId = 43; 
                                        $this->registerController->validationErrors ++;
                                        $this->model->setMessage($msgId);
                                        $this->registerController->setMessage();             
                                }   
                            }                

                            if($this->registerController->validationErrors  == 0) 
                            {

                                $hash = $this->hash->crypt($newPassword);
                                $user = new UserReset($code, $hash);
                                $this->userRepository->editForgotPassword($user);

                                $msgId = 44; 
                                $this->model->setMessage($msgId);
                                $this->registerController->setMessage();
                            }               
                         
                        }
                    }
                  }



                    } 
                }
            }

 
  

   
    }
