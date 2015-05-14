<?php
	require_once("View/ChangePasswordView.php");
	require_once("Validation/ValidatePassword.php");
	require_once("Validation/ValidateUsername.php");
	require_once("Model/Hash.php");
    require_once("Validation/ValidateNewUser.php");
    require_once("Controller/LoginController.php");
	/**
	* change password
	*/
	class ChangeUserController 
	{
		private $changePasswordView;
		private $model;
		private $validationErrors = 0;
		private $validatePassword;
		private $validateUsername;
		private $password;
		private $hash;
		private $userRepository;
        private $profileView;
        private $validateNewUser;
		
		function __construct(LoginModel $model,UserRepository $userRepository,ProfileView $profileView)
		{
			# code...
			$this->changePasswordView = new ChangePasswordView();
			$this->model = $model;
            $this->validateNewUser = new ValidateNewUser();
			$this->validatePassword = new ValidatePassword();
			$this->validateUsername = new ValidateUsername();
			$this->hash = new Hash();
			$this->userRepository = $userRepository;
            $this->profileView = $profileView;
		}


		 public function changePassword() 
         {
        $token = $this->changePasswordView->getToken();

        if (Token::check($token)) 
        {
            $currentPassword = $this->changePasswordView->getPassword(); 
            $newConfirmPassword = $this->changePasswordView->getNewPassword();
            $newPassword = $this->changePasswordView->getNewConfirmPassword();      
            if ($this->model->isCorrectPassword($currentPassword) == false) 
            {
                $msgId = 16;
                $this->validationErrors ++;
                $this->loginMessage = new LoginMessage($msgId);        
                $message = $this->loginMessage->getMessage();
                $this->changePasswordView->saveCookieMessage($message);
                $this->changePasswordView->redirectToChangePassword();                         
            }
            if ($this->validationErrors  == 0) 
            {
                if ($this->validatePassword->validatePasswordLength($newPassword, $newConfirmPassword) == false) {
                    $msgId = 18;
                    $this->validationErrors ++;
                    $this->loginMessage = new LoginMessage($msgId);        
                    $message = $this->loginMessage->getMessage();
                    $this->changePasswordView->saveCookieMessage($message);
                    $this->changePasswordView->redirectToChangePassword();     
                }
                else 
                {
                    if ($this->validatePassword->validateIfSamePassword($newPassword, $newConfirmPassword) == false) {
                        $msgId = 6;
                        $this->validationErrors ++;
                        $this->loginMessage = new LoginMessage($msgId);        
                        $message = $this->loginMessage->getMessage();
                        $this->changePasswordView->saveCookieMessage($message);
                        $this->changePasswordView->redirectToChangePassword();     
                    }
                }
            }
            if ($this->validationErrors  == 0) 
            {
                if ($this->validatePassword->validateIfSamePassword($newPassword, $currentPassword)) {
                        $msgId = 19;
                        $this->validationErrors ++;
                        $this->loginMessage = new LoginMessage($msgId);        
                        $message = $this->loginMessage->getMessage();
                        $this->changePasswordView->saveCookieMessage($message);
                        $this->changePasswordView->redirectToChangePassword();     
                    }
            }
            if ($this->validationErrors  == 0) {
                if($this->validateUsername->validateCharacters($password) == false || preg_match(Settings::$REGEX, $password)) {
                    $msgId = 23;
                    $this->validationErrors ++;
                    $this->model->setMessage($msgId);
                    $this->setMessage();
                    $this->saveCookieMessage($message);
                    $this->redirectToChangePassword();                 
                }   
            }                
            if($this->validationErrors  == 0) 
            {
                $hash = $this->hash->crypt($newPassword);
                $user = new User($this->model->getUsername(), $hash);
                $this->userRepository->editPassword($user);
                $msgId = 17;
                $this->loginMessage = new LoginMessage($msgId);        
                $message = $this->loginMessage->getMessage();
                $this->changePasswordView->saveCookieMessage($message);
                $this->model->doLogOut();
                $this->changePasswordView->redirectToLoginPage();              
            }   
        }
        else 
        {
            $this->changePasswordView->redirectToChangePassword();   
        }         
    }


      public function getId() {

        return $this->model->getId();
    }


      public function editUserDetails() 
      {
        $token = $this->profileView->getToken();
        
        if (Token::check($token))
        {
            $fName = $this->profileView->getFname(); 
            $lName = $this->profileView->getLname(); 
            $sex = $this->profileView->getSex();
            $birthday = $this->profileView->getBirthday();
            
            $schoolForm = $this->profileView->getSchoolForm();
            $institute = $this->profileView->getInstitute(); 

            if ($this->validationErrors == 0) {

                if($this->validateNewUser->validateNames($fName, $lName) == false) {
                        $msgId = 29; 
                        $this->loginMessage = new LoginMessage($msgId);        
                        $message = $this->loginMessage->getMessage();
                        $this->validationErrors ++;
                        $this->profileView->setMessage($message);
                return  $this->profileView->userProfile();
                }
            }

              if ($this->validationErrors  == 0) {
                if($this->validateNewUser->validateSex($sex) == false) {
                        $msgId = 30; 
                        $this->loginMessage = new LoginMessage($msgId);        
                        $message = $this->loginMessage->getMessage();
                        $this->validationErrors ++;
                        $this->profileView->setMessage($message);
                return  $this->profileView->userProfile();
                }
            }

              if ($this->validationErrors  == 0) {
                if (isset($birthday) && empty($birthday) == false) {
                    if ($birthday != "0000-00-00") {
                        if($this->validateNewUser->validateBirthday($birthday) == false) {
                                $msgId = 31; 
                                $this->loginMessage = new LoginMessage($msgId);        
                                 $message = $this->loginMessage->getMessage();
                                $this->validationErrors ++;
                                $this->profileView->setMessage($message);
                             return $this->profileView->userProfile();
                        }
                    }
                }
            }

             if ($this->validationErrors  == 0) {
                if($this->validateNewUser->validateSchoolForm($schoolForm) == false) 
                {
                    $msgId = 32; 
                    $this->loginMessage = new LoginMessage($msgId);        
                        $message = $this->loginMessage->getMessage();
                    $this->validationErrors ++;
                    $this->profileView->setMessage($message);
                  $this->profileView->userProfile();
                }
            }

            if ($this->validationErrors  == 0) 
            {
                if($this->validateNewUser->validateInstitute($institute) == false) 
                {
                    $msgId = 33; 
                    $this->loginMessage = new LoginMessage($msgId);        
                        $message = $this->loginMessage->getMessage();
                    $this->validationErrors ++;
                    $this->profileView->setMessage($message);
                return  $this->profileView->userProfile();
                }
            }
    
            if($this->validationErrors  == 0) 
            {
                $editUser = new User(null, null, null, $fName, $lName, $sex, $birthday, $schoolForm, $institute);
                $this->userRepository->editUserDetails($editUser, $this->getId());

                $msgId = 21;
                $this->loginMessage = new LoginMessage($msgId);        
                $message = $this->loginMessage->getMessage();
                $this->profileView->setMessage($message);
                return  $this->profileView->userProfile();
            }
        }
    }

  

}