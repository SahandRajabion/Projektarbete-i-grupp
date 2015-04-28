<?php

require_once("View/LoginView.php");
require_once("View/LoggedInView.php");
require_once("View/ChangePasswordView.php");
require_once("View/HTMLView.php");
require_once("View/ResetPasswordView.php");
require_once("View/LoginMessage.php");
require_once("Model/LoginModel.php");
require_once("View/ForgetPasswordView.php");
require_once("helper/UserAgent.php");
require_once("Validation/ValidatePassword.php");
require_once("Validation/ValidateUsername.php");
require_once("Validation/ValidateNewUser.php");
require_once("Model/Hash.php");
require_once("Model/Dao/UserRepository.php");
require_once("Model/User.php");
require_once("Model/UserReset.php");
require_once("Settings.php");
require_once('recaptchalib.php');
require_once("View/RegisterView.php");
require_once("View/ProfileView.php");
require_once("View/ProgramView.php");
require_once("View/CourseView.php");

class LoginController 
{
    private $profileView;
    private $htmlView;
    private $registerView;
    private $showRegisterPage;
    private $loggedInView;
    private $loginView;
    private $model;
    private $username;
    private $password;
    private $ip;
    private $userAgent;
    private $userAgent2;
    private $showLoggedInPage;
    private $showForgetPasswordPage;
    private $resetPassword;
    private $showResetPasswordPage;
    private $validateUsername;
    private $validatePassword;
    private $validateNewUser;
    private $changePasswordView;
    private $validationErrors = 0;
    private $loginMessage;
    private $hash;
    private $topic;
    private $author;
    private $forgetPasswordView;
    private $programView;
    private $courseView;
    private $programId;

    public function __construct() {
        $this->loginView = new LoginView();
        $this->htmlView = new HTMLView();
        $this->loggedInView = new LoggedInView();
        $this->model = new LoginModel();
        $this->registerView = new RegisterView();
        $this->changePasswordView = new ChangePasswordView();
        $this->validateUsername = new ValidateUsername();
        $this->validatePassword = new ValidatePassword();
        $this->validateNewUser = new ValidateNewUser();
        $this->userRepository = new UserRepository();
        $this->forgetPasswordView = new ForgetPasswordView();
        $this->hash = new Hash();
        $this->resetPassword = new ResetPasswordView();
        $this->loginMessage = new LoginMessage($msg='');
        $this->profileView = new ProfileView();
        $this->programView = new ProgramView();
        $this->courseView = new CourseView();

    }

    /**
     *Call controlfunctions
     */
    public function doControll() {
         $this->doGoToRegisterPage();
            $this->registerNewUser();
            $this->doGoToForgetPasswordPage();
            $this->doGoToForgetPasswordPageFromRegisterView();
            $this->didGetResetPasswordPage();
            $this->doReturnToLoginPage();
            $this->doLogInCookie();
            $this->isLoggedIn();
            $this->doLogOut();
            $this->doLogIn();
            $this->renderPage();
            $this->didUserPressUD();
    }

    public function didUserPressUD(){

        if($this->programView->didUserPressUD()){

            return true;
        }

        return false;
    }

    public function GetUserProfileDetails($id) 
    {
        return $this->model->GetUserProfileDetails($id);
    }

    public function editUserDetails() 
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
                        $this->validationErrors++;
                        $this->loginMessage = new LoginMessage($msgId);        
                        $message = $this->loginMessage->getMessage();

                        echo $message;  
                }
            }

              if ($this->validationErrors == 0) {
                if($this->validateNewUser->validateSex($sex) == false) {
                        $msgId = 30; 
                        $this->validationErrors++;
                        $this->loginMessage = new LoginMessage($msgId);        
                        $message = $this->loginMessage->getMessage();

                        echo $message;  
                }
            }

              if ($this->validationErrors == 0) {
                if (isset($birthday) && empty($birthday) == false) {
                    if ($birthday != "0000-00-00") {
                        if($this->validateNewUser->validateBirthday($birthday) == false) {
                                $msgId = 31; 
                                $this->validationErrors++;
                                $this->loginMessage = new LoginMessage($msgId);        
                                $message = $this->loginMessage->getMessage();

                                echo $message;  
                        }
                    }
                }
            }

             if ($this->validationErrors == 0) {
                if($this->validateNewUser->validateSchoolForm($schoolForm) == false) 
                {
                    $msgId = 32; 
                    $this->validationErrors++;
                    $this->loginMessage = new LoginMessage($msgId);        
                    $message = $this->loginMessage->getMessage();
                    
                    echo $message;                           
                }
            }

            if ($this->validationErrors == 0) 
            {
                if($this->validateNewUser->validateInstitute($institute) == false) 
                {
                    $msgId = 33; 
                    $this->validationErrors++;
                    $this->loginMessage = new LoginMessage($msgId);        
                    $message = $this->loginMessage->getMessage();

                    echo $message;                  
                }
            }
    
            if($this->validationErrors == 0) 
            {
                $editUser = new User(null, null, null, $fName, $lName, $sex, $birthday, $schoolForm, $institute);
                $this->userRepository->editUserDetails($editUser, $this->getId());

                $msgId = 21;
                $this->loginMessage = new LoginMessage($msgId);  
                $message = $this->loginMessage->getMessage();
                echo $message;
            }
    }
 
    /**
     * test to login with cookie
     */
    public function doLogInCookie() {
        if (!$this->model->isLoggedIn() && !$this->loggedInView->didUserPressLogOut() && !$this->loginView->didUserPressLogin() && $this->loginView->loadCookie()) {
            if (time() < $this->model->getCookieExpireTimeFromfile()) {
                $this->setUsername();
                $this->setDecryptedPassword();
                $msgId = 13;

                $this->setIp();

                //if user can log in with cookies
                if ($this->model->doLogIn($this->username, $this->password, $msgId, $this->ip)) {
                    $userAgent = new UserAgent();
                    $this->userAgent = $userAgent->getUserAgent();
                    $this->model->setUserAgent($this->userAgent);

                    $this->setMessage();
                    $this->showLoggedInPage = true;
                }
                //if the password or username in the cookie was wrong
                else {
                    $msgId = 3;
                    $this->model->setMessage($msgId);
                    $this->setMessage();
                    $this->loginView->unsetCookies();
                }

            }
            //if the cookie had expired
            else {
                $msgId = 3;
                $this->model->setMessage($msgId);
                $this->setMessage();
                $this->loginView->unsetCookies();

            }
        }

    }

    /**
     * Checks if the user has pressed log out
     */
    public function doLogOut() {

        if ($this->model->isLoggedIn()) {
            if ($this->loggedInView->didUserPressLogOut()) {
                if ($this->loginView->loadCookie()) {
                    $this->loginView->unsetCookies();                   
                }

                $this->model->doLogOut();
                $this->setMessage();
            }
        }
    }

    /**
     * try to login
     */
    public function doLogIn(){
        //If not already logged in
        if (!$this->model->isLoggedIn()) {
            if ($this->loginView->didUserPressLogin()) {
                $this->loginView->getAuthentication();
                if($this->loginView->userHasCheckedKeepMeLoggedIn()) {
                    $msgId = 9;
                }
                else {
                    $msgId = 10;
                }

                $this->setUsername();
                $this->setPassword();
                $this->setIp();

                if ($this->model->checkAttemptedLoginTries($this->ip)) 
                {
                    if ($this->model->doLogIn($this->username, $this->password,$msgId, $this->ip)) 
                    {
                        $this->userRepository->get($this->username);
                        $this->setMessage();
                        $userAgent = new UserAgent();
                        $this->userAgent = $userAgent->getUserAgent();
                        $this->encryptPassword();
                        $this->model->setCookieExpireTime();
                        $this->getCookieExpireTime();
                        $this->model->writeCookieExpireTimeToFile();
                        $this->loginView->setCookie();
                        $this->model->setUserAgent($this->userAgent);
                        $this->showLoggedInPage = true;

                    }

                    else 
                    {
                        $this->setMessage();
                        $this->showLoggedInPage = false;
                    }
                }

                else 
                {
                    $msgId = 15;
                    $this->model->setMessage($msgId);
                    $this->setMessage();   
                }
            }
             else {
                $this->showLoggedInPage = false;
            }
        }
    }

    public function getUsersUsername() 
    {
        return $this->model->getUsername();
    }

    /**
     * checks if is logged in
     */
    public function isAuthenticated() {
        if ($this->model->isLoggedIn()) {
            return true;
        }
        return false;
    }

    /**
     * checks if we have logged in session and checks so the session isnt hacked
     */
    public function isLoggedIn() {
        $userAgent = new UserAgent();
        $this->userAgent2 = $userAgent->getUserAgent();
        if($this->model->isLoggedIn() && $this->model->checkUserAgent($this->userAgent2)) {
            $this->showLoggedInPage = true;
        }
    }


    public function doGoToRegisterPage() {
        if ($this->loginView->didUserPressGoToRegisterPage()) {
            $this->showRegisterPage = true;
        }
    }

    public function doGoToForgetPasswordPage() {
        if ($this->loginView->didUserPressGoToForgetPasswordPage()) {
            $this->showForgetPasswordPage = true;
            $this->showLoginpage = false;
        }
    }


     public function doGoToForgetPasswordPageFromRegisterView() {
        if ($this->didUserPressGoToForgetPasswordPage()) {
            $this->showForgetPasswordPage = true;
            $this->showLoginpage = false;
        }
    }

      public function didUserPressGoToForgetPasswordPage() {
        if (isset($_GET['forgetPassword'])) {
            return true;
        }
        return false;
    }


    public function getCode() {
        return $this->resetPassword->getCode();
    }

    public function didGetResetPasswordPage() {
               
                 if ($this->resetPassword->issetCode()) {

                    $date = date("Y-m-d H:i:s");
                    $userEmail = $this->userRepository->getDateForResetPassword($this->getCode());
                    $fastDate = date("Y-m-d H:i:s",strtotime(date($userEmail->getDate())." +20 minutes"));

                 if ($fastDate > $date) {
                        # code...
                    
                    $this->showResetPasswordPage = true;
                    $this->showForgetPasswordPage = false;
                    $this->showLoginpage = false;
                    $code = $this->resetPassword->getCode();
                    if ($this->userRepository->getAllUserInfoForPassUpdate($code) == true) {
                        # code...
                        if ($this->resetPassword->didUserPressSubmit()) {
                        # code...
                            $newConfirmPassword = $this->resetPassword->getNewPassword();
                            $newPassword = $this->resetPassword->getNewConfirmPassword();      

                            if ($this->validationErrors == 0) 
                            {
                                if ($this->validatePassword->validatePasswordLength($newPassword, $newConfirmPassword) == false) {
                                        $this->validationErrors++;
                                        $errorMessage = '<div class="alert alert-danger alert-dismissible" role="alert">
                                         <button type="button" class="close" data-dismiss="alert">
                                         <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                         <strong>Lösenordet måste vara minst 6 tecken!.</strong></div>';

                                        echo $errorMessage;
  
                                }
                                else 
                                {
                                    if ($this->validatePassword->validateIfSamePassword($newPassword, $newConfirmPassword) == false) {
                                            $this->validationErrors++;
                                            $errorMessage = '<div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <strong>Lösenordet matchar ej!.</strong></div>';

                                            echo $errorMessage;  
                                    }
                                }
                            }

                            if ($this->validationErrors == 0) {
                                if($this->validateUsername->validateCharacters($password) == false || preg_match(Settings::$REGEX, $password)) {
                                    $this->validationErrors++;
                                       $errorMessage = '<div class="alert alert-danger alert-dismissible" role="alert">
                                         <button type="button" class="close" data-dismiss="alert">
                                         <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                         <strong>Lösenordet inneåller otillåtet tecken!.</strong></div>';

                                        echo $errorMessage;                
                                }   
                            }                

                            if($this->validationErrors == 0) 
                            {

                                $hash = $this->hash->crypt($newPassword);
                                $user = new UserReset($code, $hash);
                                $this->userRepository->editForgotPassword($user);

                                $successMessage = '<div class="alert alert-success alert-dismissible" role="alert">
                                             <button type="button" class="close" data-dismiss="alert">
                                             <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                             Lösenordet har återskapat <strong><a href="?login">Logga in</a></strong></div>';


                                echo $successMessage;  

                            }               
                         
                        }
                    }
                  }
                         
                }
    }

    public function doReturnToLoginPage() {
        if ($this->forgetPasswordView->didUserPressReturnToLoginPage()) {
            $this->showForgetPasswordPage = false;
            $this->showLoginpage = true;
        }
    }


    /**
     * decides which view that should be rendered
     */
    public function renderPage() {

        if ($this->showLoggedInPage) {

            if ($this->didUserPressUD()) {
                $this->programId = 2;
                $this->htmlView->echoHTML($this->courseView->GetCourseHTML($this->programId));
            }
              else {

                $this->htmlView->echoHTML($this->programView->showCoursePage());
              }
            }
        
        else {
            if ($this->showForgetPasswordPage) {
                $this->htmlView->echoHTML($this->forgetPasswordView->showForgetPasswordPage());
            }

            else if($this->showResetPasswordPage) {
                $this->htmlView->echoHTML($this->resetPassword->showResetPasswordPage());
            }

            else  if ($this->showRegisterPage) {
                $this->htmlView->echoHTML($this->registerView->showRegisterPage());
            }

            else {
                 $this->htmlView->echoHTML($this->loginView->showLoginpage()); 
            }
          }
        }
    

    public function encryptPassword() {
        $this->loginView->setEncryptedPassword($this->model->encryptedPassword($this->loginView->getPassword()));
    }

    public function setMessage() {
        $message = new LoginMessage($this->model->getMessage());

        if (!$this->model->isLoggedIn()) {
            if ($this->showRegisterPage) {
                $this->registerView->setMessage($message->getMessage());
            }             
            $this->loginView->setMessage($message->getMessage());
        }
        else{ 
            $this->loggedInView->setMessage($message->getMessage());
        }
    }

    public function setUsername() {
        $this->username = $this->loginView->getUsername();
    }

    /**
     * checks if is admin
     */
    public function isAdmin() {
        if ($this->model->isAdmin()) {
            return true;
        }
        return false;
    }

    public function setPassword() {
        $this->password = $this->loginView->getPassword();
    }

    public function setIp() 
    {
        $this->ip = $this->loginView->getUserIpAddress();
    }

    public function setDecryptedPassword() {
        $this->password = $this->model->decryptPassword($this->loginView->getCookiePassword());
    }

    public function getUserAgent() {
        return $this->userAgent;
    }

    public function getUserAgent2() {
        return $this->userAgent2;
    }

    public function getId() {
        return $this->model->getId();
    }

    public function getCookieExpireTime() {
        $this->loginView->setCookieExpireTime($this->model->getCookieExpireTime());
    }

    public function changePassword() 
    {
        $currentPassword = $this->changePasswordView->getPassword(); 
        $newConfirmPassword = $this->changePasswordView->getNewPassword();
        $newPassword = $this->changePasswordView->getNewConfirmPassword();      

        if ($this->model->isCorrectPassword($currentPassword) == false) 
        {
            $msgId = 16;
            $this->validationErrors++;
            $this->loginMessage = new LoginMessage($msgId);        
            $message = $this->loginMessage->getMessage();

            $this->changePasswordView->saveCookieMessage($message);
            $this->changePasswordView->redirectToChangePassword();                         
        }

        if ($this->validationErrors == 0) 
        {
            if ($this->validatePassword->validatePasswordLength($newPassword, $newConfirmPassword) == false) {
                $msgId = 18;
                $this->validationErrors++;
                $this->loginMessage = new LoginMessage($msgId);        
                $message = $this->loginMessage->getMessage();

                $this->changePasswordView->saveCookieMessage($message);
                $this->changePasswordView->redirectToChangePassword();     
            }

            else 
            {
                if ($this->validatePassword->validateIfSamePassword($newPassword, $newConfirmPassword) == false) {
                    $msgId = 6;
                    $this->validationErrors++;
                    $this->loginMessage = new LoginMessage($msgId);        
                    $message = $this->loginMessage->getMessage();

                    $this->changePasswordView->saveCookieMessage($message);
                    $this->changePasswordView->redirectToChangePassword();     
                }
            }
        }

        if ($this->validationErrors == 0) 
        {
            if ($this->validatePassword->validateIfSamePassword($newPassword, $currentPassword)) {
                    $msgId = 19;
                    $this->validationErrors++;
                    $this->loginMessage = new LoginMessage($msgId);        
                    $message = $this->loginMessage->getMessage();

                    $this->changePasswordView->saveCookieMessage($message);
                    $this->changePasswordView->redirectToChangePassword();     
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

        if($this->validationErrors == 0) 
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


     /**
     * register a user
     */
    public function registerNewUser() {
        if ($this->registerView->didUserPressSubmit()) {

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

            if($this->validateUsername->validateUsernameLength($username) == false) {
                $msgId = 8;
                $this->validationErrors++;
                $this->model->setMessage($msgId);
                $this->setMessage();
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

               if ($this->userRepository->exists($username) == false) {
             
               if($this->userRepository->existsEmail($email) == false){
                $id = $this->userRepository->add($newUser);
                $this->userRepository->addDetails($newUser, $id);

                $msgId = 12;
                $this->model->setMessage($msgId);
                $this->setMessage();
                $this->showRegisterPage = false;
                $this->loginView->setRegister($username);                
               }

               else {

                $errorMsgForgetEmail = '<div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert">
                                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <strong>Eposten finns redan registrerad, välj <a href=?forgetPassword>Glömt lösenord</a>
                                             för att återställa lösenordet</strong></div>';

                                            echo $errorMsgForgetEmail;


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


}


    
        
    