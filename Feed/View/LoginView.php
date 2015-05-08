<?php

require_once("HTMLView.php");
require_once("./Model/LoginModel.php");
require_once("./helper/CookieStorage.php");
require_once("View/BaseView.php");

class LoginView extends BaseView 
{
    private $password;
    private $encryptedPassword;
    private $htmlView;
    private $model;
    private $cookiePassword;
    private $cookieExpireTime;

    public function __construct() {
        $this->htmlView = new HTMLView();
        $this->model = new LoginModel();
        $this->cookie = new CookieStorage();
    }

    public function saveCookieMessage($value) {
        $this->cookie->save($this->messageLocation, $value, time()+3600);
    }

    public function renderCookieMessage($string) {
        $value = $this->cookie->load($string);
        $this->unsetMessage($string);
        return $value;
    }

    public function unsetMessage($name) {
            $this->cookie->save($name, null, time()-1);
    }

    public function didUserPressGoToForgetPasswordPage() {
        if (isset($_GET[$this->forgetPasswordLocation])) {
            return true;
        }
        return false;
    }

    public function hasCookieMessage() 
    {
        $value = $this->cookie->load($this->messageLocation);

        if (empty($value)) 
        {
            return false;
        }

        return true;
    }
    
    /**
     * @return string with html-code
     */
    public function showLoginpage() {
        $username = "";
        
        if (isset($_POST[$this->submitLocation]) || $this->register == true) 
        {
            $username = $this->escape($this->username);
        }

        if ($this->hasCookieMessage()) 
        {
            $this->message = $this->renderCookieMessage($this->messageLocation);
        }

        $html = 
        '<!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="../../favicon.ico">

        <title>LSN</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/customCss.css" rel="stylesheet">
        
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
        </head>

        <body>

        <nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="?">Linnaéus Social Network</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <form action="?" method="post" class="navbar-form navbar-right" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="input-group">
                       <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                       <input type="text" value="' . $username . '" name="' . $this->usernameLocation . '" size="20" maxlength="20" placeholder="Username" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                      <input type="password" name="' . $this->passwordLocation . '" size="20" maxlength="20" placeholder="Password" class="form-control">
                    </div>
                </div>

                <div class="checkbox">
                <label class="text-muted">
                <input type="checkbox" name="' . $this->checkBoxLocation . '"> Remember me
                </label>
                </div>

                <button type="submit" name="' . $this->submitLocation . '" class="btn btn-primary">Sign in</button>

              </form>
            </div>
            <!--/.navbar-collapse -->
          </div>
        </nav>
        <div class="jumbotron">
          <div class="container">
            ' . $this->message . '
            <img src="img/lnu-logo.png" class="img-rounded"> <h1>Linnaéus Social Network</h1>
            <p>Are you a student at the Linnéus university, studying one of our computer science programs and are interested to get to know your future/current classmates better and at the same time get the latast course updates?</br> Press the button below and get started !</p>
            <p><a class="btn btn-primary btn-lg" href="?' . $this->registerLocation . '" name="' . $this->registerLocation . '" role="button">
            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
            Sign up here</a></p>
          </div>
        </div>

        <div class="container">
          <div class="row">
            <div class="col-md-4">
              <h2>Contact us</h2>
              <p>If you have any suggestions or questions about Linnéus Social Network, do not hesitate to contact. </p>
              <p>
              <a class="btn btn-default" name="ContactUs" href="?' . $this->ContactLocation . '" role="button">
              <span class="glyphicon glyphicon-envelope" aria-hidden="true" /></span>
              Contact us
              </a>
              </p>
            </div>
            <div class="col-md-4">
              <h2>Forgot password</h2>
              <p>If you have forgot your password to your account, just click the button below to restore your password.</p>
              <p>
              <a class="btn btn-default" href="?' . $this->forgetPasswordLocation . '" name="' . $this->forgetPasswordLocation . '" role="button">
              <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
              Forgot password
              </a>
              </p>
           </div>
          </div>

          <hr>

          <footer>
            <p>&copy; Linnaéus Social Network 2015</p>
          </footer>
        </div> 
        <!-- /container -->

        <script src="js/jquery.min.js"></script>

        <script src="js/bootstrap.min.js"></script>
        <script src="js/ie10-viewport-bug-workaround.js"></script>
        </body>
        </html>';        

        return $html;
    }

    /**
     * @return bool true uf user has pressed login else false
     */
    public function didUserPressLogin() {
        if (isset($_POST[$this->submitLocation])) {
            return true;
        }
        return false;
    }

    public function didUserPressGoToRegisterPage() {
        if (isset($_GET[$this->registerLocation])) {
            return true;
        }
        return false;
    }

    /**
     * @return bool true if user has checked remember me else false
     */
    public function userHasCheckedKeepMeLoggedIn() {
        if (isset($_POST[$this->checkBoxLocation])){
            return true;
        }
        return false;
    }

    public function getUserIpAddress() 
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    public function getAuthentication() {
        $this->username = $_POST[$this->usernameLocation];
        $this->password = $_POST[$this->passwordLocation];

    }

    public function setCookie(){
        if (isset($_POST[$this->checkBoxLocation])) {
            $this->cookie->save($this->usernameLocation, $this->username, $this->cookieExpireTime);
            $this->cookie->save($this->passwordLocation, $this->encryptedPassword, $this->cookieExpireTime);
        }

    }

    /**
     * @return bool true if there is cookie to load, else false
     */
    public function loadCookie() {
        if (isset($_COOKIE[$this->usernameLocation])) {
            $cookieUser = $this->cookie->load($this->usernameLocation);
            $this->cookiePassword = $this->cookie->load($this->passwordLocation);
            $this->username = $cookieUser;

            return true;
        }
        return false;
    }

    /**
     * Delete cookies
     */
    public function unsetCookies() {
        $this->cookie->save($this->usernameLocation, null, time()-1);
        $this->cookie->save($this->passwordLocation, null, time()-1);
    }

    /**
     * @param $message string message with feedback
     */
    public function setMessage($message) {
        $this->message = $message;

    }

    /**
     * @return string username
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return string password
     */
    public function getPassword() {
        return $this->password;
    }

    public function getEncryptedPassword() {
        return $this->encryptedPassword;
    }

    public function setEncryptedPassword($pwd) {
        $this->encryptedPassword = $pwd;

    }

    public function setDecryptedPassword($pwd) {
        $this->password = $pwd;
    }

    public function setCookieExpireTime($expireTime) {
        $this->cookieExpireTime = $expireTime;
    }

    public function getCookiePassword() {
        return $this->cookiePassword;
    }

    public function setRegister($username) {
        $this->register = true;
        $this->username = $this->escape($username);
    }    
}