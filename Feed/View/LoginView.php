<?php

require_once("HTMLView.php");
require_once("./Model/LoginModel.php");
require_once("./helper/CookieStorage.php");
require_once("View/BaseView.php");

class LoginView extends BaseView {

    private $username;
    private $password;
    private $encryptedPassword;
    private $htmlView;
    private $model;
    private $cookiePassword;
    private $cookieExpireTime;
    private $register = false;
    private $submitLocation = "submit";
    private $checkBoxLocation = "checkbox";

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
            $username = htmlspecialchars($this->username);
        }

        if ($this->hasCookieMessage()) 
        {
            $this->message = $this->renderCookieMessage($this->messageLocation);
        }

        $html = "<!DOCTYPE html>
                <html>
                <head>
                <title>LSN</title>
                <meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1'>
                </head>
                <body>
                 <div class='container'>";

        $html .= "</br>
        <a href='?$this->registerLocation' name='$this->registerLocation'>Registrera användare</a>
        <br/>
        <a href='?$this->forgetPasswordLocation' name='$this->forgetPasswordLocation'>Glömt lösenord</a>
        <h1>LSN</h1>
        <br/>
                    <form action=?login class='form-horizontal' method=post enctype=multipart/form-data>
                       <fieldset>
                          $this->message
                          <div class='form-group'>
                            <label class='col-sm-2 control-label' for='$this->usernameLocation'>Användarnamn: </label>
                            <div class='col-sm-10'>
                              <input id='$this->usernameLocation' class='form-control' value='$username' name='$this->usernameLocation' type='text' size='20' maxlength='20'/>
                            </div>
                          </div>
                          <div class='form-group'>
                             <label class='col-sm-2 control-label' for='$this->passwordLocation'>Lösenord: </label>
                             <div class='col-sm-10'>
                               <input id='$this->passwordLocation' class='form-control' name='$this->passwordLocation' type='password' maxlength='20' size='20'>
                             </div>
                          </div>
                          <div class='form-group'>
                             <div class='col-sm-offset-2 col-sm-10'>
                               <div class='checkbox'>
                                  <label>
                                  <input class='$this->checkBoxLocation' type='checkbox' name='$this->checkBoxLocation'/> Kom ihåg mig
                                  </label>
                               </div>
                             </div>
                          </div>
                         <div class='form-group'>
                           <div class='col-sm-offset-2 col-sm-10'>
                             <input class='btn btn-default' name='$this->submitLocation' type='submit' value='Logga in' />
                           </div>
                         </div>
                       </fieldset>
                   </form>";

            $html .= "</div>
                </body>
                </html>";            

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
        $this->password = strip_tags($_POST[$this->passwordLocation]);

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
        $this->username = $username;
    }    
}