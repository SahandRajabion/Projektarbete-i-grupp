<?php

require_once("View/LoginView.php");
require_once("View/LoggedInView.php");
require_once("View/LoginMessage.php");
require_once("helper/UserAgent.php");
require_once("Validation/ValidatePassword.php");
require_once("Validation/ValidateUsername.php");
require_once("Validation/ValidateNewUser.php");
require_once("Model/Hash.php");
require_once("Model/User.php");
require_once("Model/UserReset.php");
require_once("Settings.php");
require_once('recaptchalib.php');
require_once("Model/Token.php");
require_once("View/CourseView.php");
require_once('Controller/RegisterController.php');

class LoginController 
{
    private $profileView;
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
    private $resetPassword;
    private $validateUsername;
    private $validatePassword;
    private $validateNewUser;
    private $loginMessage;
    private $hash;
    private $topic;
    private $author;
    private $forgetPasswordView;
    private $contactPage;
    private $registerController;

    public function __construct(ContactView $contactPage,HTMLView $htmlView,LoginModel $model,UserRepository $userRepository,ForgetPasswordView $forgetPasswordView,ResetPasswordView $resetPassword,ProfileView $profileView,ProgramView $programView) {
        $this->contactPage = $contactPage;
        $this->loginView = new LoginView();
        $this->htmlView = $htmlView;
        $this->loggedInView = new LoggedInView();
        $this->model = $model;
        $this->validateUsername = new ValidateUsername();
        $this->validatePassword = new ValidatePassword();
        $this->validateNewUser = new ValidateNewUser();
        $this->userRepository = $userRepository;
        $this->forgetPasswordView = $forgetPasswordView;
        $this->hash = new Hash();
        $this->resetPassword = $resetPassword;
        $this->loginMessage = new LoginMessage($msg='');
        $this->profileView = $profileView;
        $this->programView = $programView;
        $this->courseView = new CourseView();
        $this->registerController = new RegisterController($this->forgetPasswordView,$this->contactPage,$this->profileView,$this->validateUsername,$this->validatePassword,$this->validateNewUser,$this->model,$this->userRepository,$this->hash,$this->resetPassword,$this->programView,$this->loginView);
    }

    /**
     *Call controlfunctions
     */
    public function doControll() 
    {
        $this->doGoToContactPage();
        $this->doGoToRegisterPage();
        $this->registerController->registerNewUser();
        $this->doGoToForgetPasswordPage();
        $this->doGoToForgetPasswordPageFromRegisterView();
        $this->registerController->didGetResetPasswordPage();
        $this->doReturnToLoginPage();
        $this->doLogInCookie();
        $this->isLoggedIn();
        $this->doLogOut();
        $this->doLogIn();
        $this->renderPage();
        $this->didUserPressUD();
        $this->didUserPressWP();
        $this->didUserPressID();
        $this->didUserPressPU();
    }

  public function didUserPressUD()
  {
        if ($this->programView->didUserPressUD())
        {
            return true;
        }

        return false;
    }

    public function didUserPressWP()
    {
        if ($this->programView->didUserPressWP())
        {
            return true;
        }

        return false;
    }

    public function didUserPressID()
    {
        if ($this->programView->didUserPressID())
        {
            return true;
        }
        return false;
    }

    public function didUserPressPU(){
        if($this->programView->didUserPressPU()){
            return true;
        }
        return false;
    }


    public function GetUserProfileDetails($id) 
    {
        return $this->model->GetUserProfileDetails($id);
    }

  
    public function getId() {
        return $this->model->getId();
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

                    $this->registerController->setMessage();
                    $this->showLoggedInPage = true;
                }
                //if the password or username in the cookie was wrong
                else {
                    $msgId = 3;
                    $this->model->setMessage($msgId);
                    $this->registerController->setMessage();
                    $this->loginView->unsetCookies();
                }

            }
            //if the cookie had expired
            else {
                $msgId = 3;
                $this->model->setMessage($msgId);
                $this->registerController->setMessage();
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
                $this->registerController->setMessage();
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
                        $this->registerController->setMessage();
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
                        $this->registerController->setMessage();
                        $this->showLoggedInPage = false;
                    }
                }

                else 
                {
                    $msgId = 15;
                    $this->model->setMessage($msgId);
                    $this->registerController->setMessage();   
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
            $this->registerController->showRegisterPage = true;
        }
    }

    public function doGoToForgetPasswordPage() {
        if ($this->loginView->didUserPressGoToForgetPasswordPage()) {
            $this->registerController->showForgetPasswordPage = true;
            $this->showLoginpage = false;
        }
    }

    public function doGoToContactPage() 
    {
        if ($this->contactPage->didUserPressToContact()) {
            $this->registerController->showContactPage = true;
        }        
    }


     public function doGoToForgetPasswordPageFromRegisterView() {
        if ($this->didUserPressGoToForgetPasswordPage()) {
            $this->registerController->showForgetPasswordPage = true;
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

   

    public function doReturnToLoginPage() {
        if ($this->forgetPasswordView->didUserPressReturnToLoginPage()) {
            $this->registerController->showForgetPasswordPage = false;
            $this->showLoginpage = true;
        }
    }


    /**
     * decides which view that should be rendered
     */
    public function renderPage() 
    {
        if ($this->showLoggedInPage) 
        {
            if ($this->didUserPressWP()) 
            {
                $this->programId = 1;
                $this->htmlView->echoHTML($this->courseView->GetCourseHTML($this->programId));
            }
            else if ($this->didUserPressUD()) 
            {
                $this->programId = 2;
                $this->htmlView->echoHTML($this->courseView->GetCourseHTML($this->programId));
            }
            else if ($this->didUserPressID()) 
            {
                $this->programId = 3;
                $this->htmlView->echoHTML($this->courseView->GetCourseHTML($this->programId));
            }
            else if ($this->didUserPressPU()) 
            {
                $this->htmlView->echoHTML($this->loggedInView->showPublicCourseFeed());
            }

            else 
            {
                $this->htmlView->echoHTML($this->programView->showCoursePage());
            }

        }
        else 
        {   
            if ($this->registerController->showForgetPasswordPage) 
            {
                $this->htmlView->echoHTML($this->forgetPasswordView->showForgetPasswordPage());
            }

            else if($this->registerController->showResetPasswordPage) {
                $this->htmlView->echoHTML($this->resetPassword->showResetPasswordPage());
            }

            else if ($this->registerController->showContactPage) 
            {
                $this->htmlView->echoHTML($this->contactPage->ContactForm());   
            }

            else  if ($this->registerController->showRegisterPage) {

                $this->htmlView->echoHTML($this->registerController->registerView->showRegisterPage());
            }

            else if ($this->registerController->showProfilePage) 
            {
                $this->htmlView->echoHTML($this->profileView->userProfile());
            }

            else 
            {
                 $this->htmlView->echoHTML($this->loginView->showLoginpage()); 
            }
          }
        }
    

    public function encryptPassword() {
        $this->loginView->setEncryptedPassword($this->model->encryptedPassword($this->loginView->getPassword()));
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

    

    public function getCookieExpireTime() {
        $this->loginView->setCookieExpireTime($this->model->getCookieExpireTime());
    }


      


    

}


    
        
    