<?php

require_once("View/ChangePasswordView.php");
require_once("View/LoginView.php");
require_once("View/LoggedInView.php");
require_once("View/HTMLView.php");
require_once("View/LoginMessage.php");
require_once("Model/LoginModel.php");
require_once("View/ForgetPasswordView.php");
require_once("helper/UserAgent.php");
require_once("Validation/ValidatePassword.php");
require_once("Validation/ValidateUsername.php");
require_once("Model/Hash.php");
require_once("Model/Dao/UserRepository.php");
require_once("Model/User.php");
require_once("Settings.php");
require_once('recaptchalib.php');

class LoginController 
{
    private $htmlView;
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
        $this->changePasswordView = new ChangePasswordView();
        $this->validateUsername = new ValidateUsername();
        $this->validatePassword = new ValidatePassword();
        $this->userRepository = new UserRepository();
        $this->forgetPasswordView = new ForgetPasswordView();
        $this->hash = new Hash();
    }

    /**
     *Call controlfunctions
     */
    public function doControll() {
            $this->doGoToForgetPasswordPage();
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


    public function doGoToForgetPasswordPage() {
        if ($this->loginView->didUserPressGoToForgetPasswordPage()) {
            $this->showForgetPasswordPage = true;
            $this->showLoginpage = false;
        }
    }

    public function doReturnToLoginPage() {
        if ($this->forgetPasswordView->didUserPressReturnToLoginPage()) {
            echo("sahinbbbbbbbbbbbbbbbbbbbbb");
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
}


    
        
    
