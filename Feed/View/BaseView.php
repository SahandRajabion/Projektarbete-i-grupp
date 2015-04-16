<?php

require_once("Settings.php");

abstract class BaseView 
{
	protected $logOutLocation = 'logout';
	protected $changePasswordLocation = 'changepassword';
	protected $usernameLocation = "username";
	protected $passwordLocation = "password";
	protected $emailLocation = "email";
	protected $newPasswordLocation = "newPassword";
	protected $newConfirmPasswordLocation = "newConfirmPassword";
	protected $submitNewPasswordLocation = 'submitNewPassword';
	protected $confirmPasswordLocation = 'confirmPassword';
	protected $registerLocation = 'register';
	protected $forgetPasswordLocation = 'forgetPassword';
	protected $loginLocation = 'login';
	protected $messageLocation = "CookieMessage";
	protected $message;
    protected $adminPanelLocation = 'adminPanel';
    protected $id = 'id';
    protected $cookie;
    protected $code = 'code';

	public function getId() {
	   if (isset($_GET[$this->id])) {
	      return $_GET[$this->id];
	   }
	   return NULL;
	 }


	public function getPassword() {
		if (isset($_POST[$this->passwordLocation])) {
			return strip_tags($_POST[$this->passwordLocation]);
		}
	}

    public function redirectToErrorPage() {
        header("Location: /". Settings::$ROOT_PATH . "/error.html");
    }

	public function redirectToChangePassword() {
		header("Location: ?" . $this->changePasswordLocation . "");
	}



	public function redirectToLoginPage() {
		header("Location: ?");
	}



}