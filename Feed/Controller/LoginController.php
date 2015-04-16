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
require_once("Model/Hash.php");
require_once("Model/Dao/UserRepository.php");
require_once("Model/User.php");
require_once("Model/UserReset.php");
require_once("Settings.php");
require_once('recaptchalib.php');
require_once("View/RegisterView.php");

class LoginController 
{
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
    private $changePasswordView;
    private $validationErrors = 0;
    private $loginMessage;
    private $hash;
    private $topic;
    private $author;
    private $forgetPasswordView;

    public function __construct() {
        $this->loginView = new LoginView();
        $this->htmlView = new HTMLView();
        $this->loggedInView = new LoggedInView();
        $this->model = new LoginModel();
        $this->registerView = new RegisterView();
        $this->changePasswordView = new ChangePasswordView();
        $this->validateUsername = new ValidateUsername();
        $this->validatePassword = new ValidatePassword();
        $this->userRepository = new UserRepository();
        $this->forgetPasswordView = new ForgetPasswordView();
        $this->hash = new Hash();
        $this->resetPassword = new ResetPasswordView();
    }

    /**
     *Call controlfunctions
     */
    public function doControll() {
         $this->doGoToRegisterPage();
            $this->registerNewUser();
            $this->doGoToForgetPasswordPage();
            $this->didGetResetPasswordPage();
            $this->doReturnToLoginPage();
            $this->doLogInCookie();
            $this->isLoggedIn();
            $this->doLogOut();
            $this->doLogIn();
            $this->renderPage();
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

                //if user can log in with cookies
                if ($this->model->doLogIn($this->username, $this->password, $msgId)) {
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
                                        echo("Lösenordet måste vara minst 6 tecken");
                                }
                                else 
                                {
                                    if ($this->validatePassword->validateIfSamePassword($newPassword, $newConfirmPassword) == false) {
                                            echo("Lösenordet matchar inte");
                                    }
                                }
                            }

                            if ($this->validationErrors == 0) {
                                if($this->validateUsername->validateCharacters($password) == false || preg_match(Settings::$REGEX, $password)) {
                                    echo("Lösenordet av fel format");                  
                                }   
                            }                

                            if($this->validationErrors == 0) 
                            {

                                $hash = $this->hash->crypt($newPassword);
                                $user = new UserReset($code, $hash);
                                $this->userRepository->editForgotPassword($user);

                                echo("Lösenordet har återskapat <a href='?login'>Logga in</a>");



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
            $this->htmlView->echoHTML($this->loggedInView->showLoggedInPage());  
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
               $newUser = new User($username, $hash);

               if ($this->userRepository->exists($username) == false) {
                $this->userRepository->add($newUser);
                $msgId = 12;
                $this->model->setMessage($msgId);
                $this->setMessage();
                $this->showRegisterPage = false;
                $this->loginView->setRegister($username);                
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


    
        
    