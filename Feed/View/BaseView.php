<?php

require_once("Settings.php");

abstract class BaseView 
{
	protected $createNewCourseLocation = "createNewCourse";
	protected $logOutLocation = 'logout';
	protected $ContactLocation = 'ContactUs';
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
    protected $youtubeCode = "code";
    protected $code = 'gjaQwrA';
    protected $userProfileLocation = 'profile';
    protected $editProfileLocation = 'editProfile';
    protected $UDCourseLocation = 'UDCourseLocation';
    protected $WPCourseLocation = 'WPCourseLocation';
    protected $IDCourseLocation = 'IDCourseLocation';
    protected $PUCourseLocation = 'PUCourseLocation';


    protected $emailRegLocation='emailRegLocation';
    protected $emailConfirmLocation='emailConfirmLocation';
    protected $fNameLocation='fNameLocation';
    protected $lNameLocation='LNameLocation';
    protected $sexLocation='sexLocation';
    protected $birthdayLocation='birthdayLocation';
	protected $schoolLocation='schoolLocation';
    protected $instituteLocation='instituteLocation';

    public static function escape($string) 
    {
    	return htmlspecialchars($string, ENT_QUOTES, 'utf-8');   
    }
    public function getToken() 
    {
    	if (isset($_POST['CSRFToken'])) {
	      return $_POST['CSRFToken'];
	   }	
    }

	public function getId() {
	   if (isset($_GET[$this->id])) {
	      return $_GET[$this->id];
	   }
	   return NULL;
	 }

	public function getEmail() {
		if (isset($_POST[$this->emailRegLocation])) {
			return $_POST[$this->emailRegLocation];
		}
	}

	public function getConfirmEmail() {
		if (isset($_POST[$this->emailConfirmLocation])) {
			return $_POST[$this->emailConfirmLocation];
		}
	}

	public function getFname() {
		if (isset($_POST[$this->fNameLocation])) {
			return $_POST[$this->fNameLocation];
		}
	}

	public function getLname() {
		if (isset($_POST[$this->lNameLocation])) {
			return $_POST[$this->lNameLocation];
		}
	}

	public function getSex() {
		if (isset($_POST[$this->sexLocation])) {
			return $_POST[$this->sexLocation];
		}
	}

	public function getBirthday() {
		if (isset($_POST[$this->birthdayLocation])) {
			return $_POST[$this->birthdayLocation];
		}
	}

		public function getSchoolForm() {
		if (isset($_POST[$this->schoolLocation])) {
			return $_POST[$this->schoolLocation];
		}
	}

	public function getInstitute() {
		if (isset($_POST[$this->instituteLocation])) {
			return $_POST[$this->instituteLocation];
		}
	}	 

	public function getPassword() {
		if (isset($_POST[$this->passwordLocation])) {
			return $_POST[$this->passwordLocation];
		}
	}

	public function didUserPressGoToUserProfilePage() {
        if (isset($_GET[$this->userProfileLocation])) {
            return true;
        }
        return false;
    }

    public function redirectToErrorPage() {
        header("Location: /". Settings::$ROOT_PATH . "/error.html");
    }

	public function redirectToChangePassword() {
		header("Location: ?" . $this->changePasswordLocation . "");
	}

	public function redirectToProfilePage($id) {
		header("Location: ?" . $this->userProfileLocation . "&" . $this->id . "=" . $id);
	}

	public function redirectToResetPassword() {
		header("Location: ?" . $this->code ."=".$this->getCode()."&kjAmsdNg");
	}

	public function redirectToLoginPage() {
		header("Location: ?");
	}
}