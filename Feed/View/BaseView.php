<?php

require_once("Settings.php"); 
require_once('Model/LoginModel.php');
require_once('Model/ImagesModel.php');

abstract class BaseView 
{
protected $submitRemoveCourseLocation ="SubmitRemoveCourse";
	protected $removeCourseLocation = "removeCourse";
	protected $editCourseLocation  = "SubmiteditCourseLocation";
	protected $CourseId ="CourseId";
	protected $courseCodesLocation ="courseCodeLocation";
	protected $courseNamesLocation = "courseNameLocation";
	protected $submitRemoveUserLocation ="SubmitRemoveUser";
	protected $removeUserLocation = "removeUser";
	protected $uppgradeLocation = "Uppgrade";
	protected $uppgradeUserLocation = "UppgradeUser";
	protected $UserListLocation = "UserList";
	protected $CourseListLocation = "CourseList";
	protected $AdminPanelLocation = "AdminPanel";
	protected $searchLocation = "Serach";
	protected $submitSearchLocation = "SubmitSearch";
	protected $inboxLocation = 'Inbox';
	protected $removeLocation = 'remove';
	protected $removeSentLocation = 'removeSent';
	protected $msgFormLocation = 'NewMsg';
	protected $subjectLocation = 'SendSubject';
	protected $sendMessageLocation = 'sendMsg';
	protected $submitSendMsgLocation = 'submitAnewMsg';
	protected $sendLocation = "send";
	protected $msgLocation = 'msg';
	protected $sentMsgLocation = 'SentMsg';
	protected $toUserIdLocation = 'toUserId';
	protected $username;
	protected $register = false;
	protected $submitLocation = "submit";
    protected $checkBoxLocation = "checkbox";
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
    protected $code = 'gjaQwrA';
    protected $userProfileLocation = 'profile';
    protected $editProfileLocation = 'editProfile';
    protected $schemaLocation = "schema";
    protected $emailRegLocation='emailRegLocation';
    protected $emailConfirmLocation='emailConfirmLocation';
    protected $fNameLocation='fNameLocation';
    protected $lNameLocation='LNameLocation';
    protected $sexLocation='sexLocation';
    protected $birthdayLocation='birthdayLocation';
	protected $schoolLocation='schoolLocation';
    protected $instituteLocation='instituteLocation';
    protected $youtubeCode = 'code';

    protected $course = 'Course';
    protected $UDCourseLocation = 'UDCourseLocation';
    protected $WPCourseLocation = 'WPCourseLocation';
    protected $IDCourseLocation = 'IDCourseLocation';
    protected $PUCourseLocation = 'PUCourseLocation';

    protected $rssUrlLocation = "rssUrlLocation";
    protected $courseCodeLocation = "courseCode";
	protected $courseNameLocation = "courseName";
	protected $programCheckBoxLocation = "programCheckBox";
	protected $submitNewCourseLocation = "submitNewCourse";
	protected $rssFeedLocation = "rssFeedLocation";
	protected $backToFeedLocation ="backToFeedLocation";
	protected $imagesModel;
	  protected $loginModel;
	  protected $pic;

	public function __construct() {
		$this->loginModel = new LoginModel();
		$this->imagesModel = new ImagesModel();
	}


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

  public function hasSubmitAcourse() {
         if (isset($_GET[$this->course])) {
            return true;
        }
        return false;
    }    

	public function checkIfIdInUrl() {
	   if (isset($_GET[$this->id])) {
	      return true;
	   }
	   return false;
	 }

	public function getId() {
	   if (isset($_GET[$this->id])) {
	      return $_GET[$this->id];
	   }
	   return NULL;
	 }


	public function isValidId($id) {
		if (preg_match('/^[0-9]+$/', $id)) 
		{
			return true;
		}

		return false;
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
		if (isset($_POST[$this->sexLocation]) && $_POST[$this->sexLocation] === "Kvinna" || $_POST[$this->sexLocation] === "Man") {
			return $_POST[$this->sexLocation];
		}
	}

	public function getBirthday() {
		if (isset($_POST[$this->birthdayLocation])) {
			return $_POST[$this->birthdayLocation];
		}
	}

		public function getSchoolForm() {
		if (isset($_POST[$this->schoolLocation]) && $_POST[$this->schoolLocation] === "Distans" || $_POST[$this->schoolLocation] === "Campus") {
			return $_POST[$this->schoolLocation];
		}
	}

	public function getInstitute() {
		if (isset($_POST[$this->instituteLocation]) && $_POST[$this->instituteLocation] === "1" || $_POST[$this->instituteLocation] === "2" || $_POST[$this->instituteLocation] === "3") {
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




	
	public function cssView($title = null, $checked = null, $master = false) {

			    // BEHÖVS

    	  $Images = glob("imgs/*.*");

          $username = $this->loginModel->getUsername();

          $adminMenu = "";
          $userPic = "";
          $userPicProfile = "";


        
          if ($this->loginModel->isAdmin()) 
          {
          	  $adminMenu .= "<li><a name='AdminPanel' href='?". $this->AdminPanelLocation . "'>Admin Panel</a></li>";
          }

		   	    /// PROFIL BILD FÖR NAV 
			    $users = $this->loginModel->GetUserProfileDetails($this->loginModel->getId());
			    
			    foreach ($Images as $value) 
			    {  
			        $img = $this->imagesModel->getImages($this->loginModel->getId());
			        $removeImg = $this->imagesModel->getImgToRemove(basename($value));
			        if ($img->getImgName() == basename($value)) 
			        {        
			          $userPic .= '<div><img id="profileImage" src="'.$value.'" > <label id="profileName"><a name="profile" href="?' . $this->userProfileLocation . "&id=".$this->loginModel->getId(). '">' . $username . '</a></label></div>';
			          $this->pic = $value;
			        }
			    }

			    if (basename($this->pic) === "" && $users->getSex() == "Man") 
			    {
			        $userPic .= '<div><img id="profileImage" src="img/default.jpg"> <label id="profileName"><a name="profile" href="?' . $this->userProfileLocation . "&id=".$this->loginModel->getId(). '">' . $username . '</a></label></div>';
			    }
			    else if (basename($this->pic) === "" && $users->getSex() == "Kvinna")
			    {
        $userPic .= '<div><img id="profileImage" src="img/kvinna.png"> <label id="profileName"><a name="profile" href="?' . $this->userProfileLocation . "&id=".$this->loginModel->getId(). '">' . $username . '</a></label></div>';
			    }

		     $html = 
		    '<!DOCTYPE html>
		    <html lang="en">
		      <head>
		        <meta charset="utf-8">
		        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		        <meta name="viewport" content="width=device-width, initial-scale=1">
		        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		        <link rel="icon" href="../../favicon.ico">
		        <link rel="apple-touch-icon-precomposed" href="../img/lnu-logo.png" />
				<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../img/lnu-logo.png" />
				<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../img/lnu-logo.png" />
				<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../img/nu-logo.png" />
		        <title> ' . $title . ' | LSN</title>
		        <link href="css/bootstrap.min.css" rel="stylesheet">
		        <link href="css/customCss.css" rel="stylesheet">
		        <script type="text/javascript" src="jquery.min.js"></script>
		        <script type="text/javascript" src="script.js"></script>
		        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

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
		               <div id="logolsn">
             			<a class="navbar-brand" href="?"><img id="logo" src="images/lsnlogo.png"></a>
              		   </div>
		            </div>
		            <div id="navbar" class="navbar-collapse collapse">

		              <form class="navbar-form navbar-right" role="search" method="post" enctype="multipart/form-data">
		              <div class="form-group">
		              <div class="input-group">
		             
		              <div class="input_container">
		                <input type="text" id="course_id" onkeyup="autocomplet()" name="' . $this->searchLocation . '" size="20" maxlength="20" class="form-control1" placeholder="Search">
		                <ul id="course_list_id"></ul>
		                </div>

		                <div class="input-group-btn">
				              <button type="submit" name="' . $this->submitSearchLocation . '" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
				        </div>
		              </div>
		              </div>
		            </form>


		              <ul class="nav navbar-nav navbar-right">
		              <li>' . $userPic . '</li>
		                ' . $adminMenu . '
		                <li><a name="logOut" href="?' . $this->logOutLocation . '">Log Out</a></li>
		              </ul>
		              
		            </div>
		          </div>
		        </nav>

		        <div class="container-fluid">
		          <div class="row">
		            <div class="col-sm-3 col-md-2 sidebar">
		              <ul class="nav nav-sidebar">
		                <li '. $checked . '><a href="?">Available Programmes</a></li>';
		           
		                $html .= ' <script src="js/jquery.min.js"></script>
			    <script src="js/bootstrap.min.js"></script>
			    <script src="js/ie10-viewport-bug-workaround.js"></script>';

			     $html .= '
      </body>
    </html>';

		        
			

		    return $html;
				}



}