<?php

require_once("View/BaseView.php");
require_once("Model/ImagesModel.php");
require_once('Model/Token.php');

class CreateCourseView extends BaseView
{
	private $loginModel;
	private $imagesModel;
	private $pic;
	private $messageRepository;

	public function __construct(LoginModel $model,MessagesRepository $messageRepository) 
	{
		$this->imagesModel = new ImagesModel();
		$this->loginModel = $model;
		$this->messageRepository = $messageRepository;
	}


    /**
    * Function to render message
    */
    public function setMessage($message) {
        $this->message .= $message;
    }

	public function DidUserPressToCreateCourse() {
		if (isset($_GET[$this->createNewCourseLocation])) {
			return true;
		}

		return false;
	}

	public function DidUserPressSubmitNewCourse() 
	{
		if (isset($_POST[$this->submitNewCourseLocation])) 
		{
			return true;			
		}

		return false;
	}	

	public function GetCheckedBoxes() 
	{
		if (isset($_POST[$this->programCheckBoxLocation])) 
		{
			$checkedBoxes = array();

			foreach ($_POST[$this->programCheckBoxLocation] as $checked) 
			{
				$checkedBoxes[] = $checked;
			}

			return $checkedBoxes;
		}
	}

	public function GetCourseName() 
	{
		if (isset($_POST[$this->courseNameLocation])) 
		{
			return $_POST[$this->courseNameLocation];
		}
	}

	public function GetCourseCode() 
	{
		if (isset($_POST[$this->courseCodeLocation])) 
		{
			return $_POST[$this->courseCodeLocation];
		}
	}

	public function GetRSSUrl() 
	{
		if (isset($_POST[$this->rssUrlLocation])) 
		{
			return $_POST[$this->rssUrlLocation];
		}
	}	
	

	public function ShowCreateCourseForm() 
	{
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
        <title>Create Course | LSN</title>
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
              <a class="navbar-brand" href="?">LSN</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">

              <form class="navbar-form navbar-right" role="search" method="post" enctype="multipart/form-data">
              <div class="form-group">
              <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
             
              <div class="input_container">
                <input type="text" id="course_id" onkeyup="autocomplet()" name="' . $this->searchLocation . '" size="20" maxlength="20" class="form-control1" placeholder="Search">
                <ul id="course_list_id"></ul>
                </div>
              </div>
              </div>
              <button type="submit" name="' . $this->submitSearchLocation . '" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
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
                <li><a href="?">Available Programmes</a></li>
                                ';
           
                $open = $this->messageRepository->getIfOpenOrNot($this->loginModel->getId());

            
                  if ($open != null) {
                        # code...
                       if ($open == 1) {
                                               # code...
                         $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox <span class="badge">1</span></a></li>';
                       }
                       else {
                           $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox  <span class="badge">' . $open . '</span></a></li>';
                       }
                  }
                  else {
                      $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox</a></li>';
                  }
                 
              $html .= '<li><a name="Inbox" href="?' . $this->sendLocation ."&".$this->id."=".$this->loginModel->getId().'">Sent Messages</a></li>'.
              '<li><a href="?' . $this->changePasswordLocation . '">Change Password</a></li></ul>
            </div>';


            $html .= '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            ' . $this->message . '


      <form role="form" action="" class="form-horizontal" method="post" enctype="multipart/form-data">
          <h2 class="sub-header">Create Course</h2> 

              <div class="form-group">
                  <input type="text" placeholder="Course Name" name="' . $this->courseNameLocation . '" size="40" maxlength="40" class="form-control input-lg" >                    
                </div>

              <div class="form-group">
                    <input type="text" placeholder="Course Code" size="6" maxlength="6" name="' . $this->courseCodeLocation . '" class="form-control input-lg" >                            
              </div>

              <div class="form-group">
              <em>(optional)</em>
                    <input type="text" placeholder="RSS Feed Url" size="40" maxlength="255" name="' . $this->rssUrlLocation . '" class="form-control input-lg" >                            
              </div>

              <div class="form-group">
              <label>Course should be under</label>
              <div class="checkbox">
              <label>
                <input type="checkbox" name="' . $this->programCheckBoxLocation . '[]" value="1">
                  Webbprogrammerare
              </label>
              </div>

              <div class="checkbox">
              <label>
                <input type="checkbox" name="' . $this->programCheckBoxLocation . '[]" value="2">
                  Utvecklare av digitala tjänster
              </label>
              </div>

              <div class="checkbox">
              <label>
                <input type="checkbox" name="' . $this->programCheckBoxLocation . '[]" value="3">
                  Interaktionsdesigner
              </label>
              </div>
              </div>

              <div class="row">
                <div class="col-xs-12 col-md-6">
                  <input type="hidden" name="CSRFToken" value="' . Token::generate() . '" />
                  <input type="submit" name="' . $this->submitNewCourseLocation . '" value="Create Course" class="btn btn-primary btn-block btn-lg">
                </div>
              </div>
            </form>
            </div>
            ';

     $html .= '<script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/ie10-viewport-bug-workaround.js"></script>
      </body>
    </html>';	

    return $html;	
	}
}
