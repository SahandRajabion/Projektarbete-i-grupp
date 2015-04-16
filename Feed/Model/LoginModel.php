<?php

require_once('./Controller/LoginController.php');
require_once('Model/Dao/UserRepository.php');
require_once('Model/Dao/LogRepository.php');


class LoginModel{
    private $username;
    private $hash;
    private $messageId;
    private $cookieExpireTime;
    private $userRepository;
    private $role;
    private $adminRoleNr = 1;
    private $id;
    private $logRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
        $this->logRepository = new LogRepository();
    }

    public function getId() 
    {
        return $_SESSION['id'];
    }

    public function isCorrectPassword($password) 
    {
        $this->get($this->getUsername());

        if (crypt($password, $this->hash) === $this->hash) 
        {
            return true;
        }

        return false;
    }

    /**
     * @param $username
     * @param $password
     * @param $messageId mixed if an error occurs the messageId will be set
     * @return bool true if user is authenticated, else false
     */
    public function doLogIn($username, $password, $messageId, $ip){
       if (!empty($username)) {
           $this->get($username);
       }

       if (empty($username) || empty($username) && empty($password)) {
           $this->messageId = 0;

        }
        else if (empty($password)) {
            $this->messageId = 1;

        }

        else if($username !== $this->username || crypt($password, $this->hash) !== $this->hash){
            $this->messageId = 2;
            $this->logRepository->logAuthenticationAttempt($ip, $username, false);
        }

        if ($username === $this->username && crypt($password, $this->hash) === $this->hash) {          
            if (isset($_SESSION['loggedIn']) == false) {
                $_SESSION['loggedIn'] = $username;

                if ($this->role == $this->adminRoleNr) 
                {
                    $this->setAdmin();
                }

                $this->logRepository->logAuthenticationAttempt($ip, $username, true);

                $this->setId();
            }

            $this->messageId = $messageId;

            return true;

        }

        return false;
    }

    /**
     * @return bool true if we have a session with the user, else false
     */
    public function isLoggedIn(){
        if (isset($_SESSION['loggedIn'])){
            return true;
        }
        return false;
    }

    /**
     * logs out the user
     */
    public function doLogOut(){
        if (isset($_SESSION['loggedIn'])) {
            $this->messageId = 11;
            session_unset("loggedIn");
            session_unset("admin");
            session_unset("id");
        }
    }

    /**
     * @return mixed messageId
     */
    public function getMessage(){
        return $this->messageId;
    }

    /**
     * sets the messageId
     * @param $msgId
     */
    public function setMessage($msgId){
        $this->messageId = $msgId;
    }

    /**
     * @return mixed the username
     */
    public function getUsername(){
        return $_SESSION['loggedIn'];
    }

    /**
     * @param $ua string containing user agent
     * @return bool true if the user agent($ua) is the logged in user agent, else someone is trying to hack the session
     */
    public function checkUserAgent($ua){
        if(isset($_SESSION['userAgent'])){
            if($ua === $_SESSION['userAgent']){
            return true;
            }
        }
        return false;

    }

    /**
     * if the user has logged in
     * save his user agent in session
     * @param $userAgent string containing the user agent
     */
    public function setUserAgent($userAgent){
        if(isset($_SESSION['userAgent']) == false){
            $_SESSION['userAgent'] = $userAgent;
        }
    }

    /**
     * @return mixed the saved user agent
     */
    public function getUserAgent(){
        return $_SESSION['userAgent'];
    }

    public function setCookieExpireTime(){
        $this->cookieExpireTime = time()+3600*24;
    }

   public function getCookieExpireTime(){
        return $this->cookieExpireTime;
    }

    public function encryptedPassword($pwd){
        return base64_encode($pwd);
    }

    public function decryptPassword($pwd) {
        return base64_decode($pwd);
    }

    public function writeCookieExpireTimeToFile() {
        file_put_contents("expire.txt", $this->cookieExpireTime);
    }

    public function getCookieExpireTimeFromFile() {
        return file_get_contents("expire.txt");
    }

    public function setAdmin() {
        if (isset($_SESSION['admin']) == false) {
            $_SESSION['admin'] = $this->adminRoleNr;
        }        
    }

    public function isAdmin() {
        if (isset($_SESSION['admin'])) {
            return true;
        }
        return false;
    }

    public function setId() {
        if (isset($_SESSION['id']) == false) {
            $_SESSION['id'] = $this->id;
        }       
    }

    public function get($username) {
        $data = $this->userRepository->get($username);

        $this->id = $data['UserId'];
        $this->username = $data['Username'];
        $this->hash = $data['Hash'];
        $this->role = $data['Role'];
    }


    public function checkAttemptedLoginTries($ip){

        if($this->logRepository->checkAuthenticationAttempts($ip) >= 5){

            return false;
        }
        return true;
    }

}