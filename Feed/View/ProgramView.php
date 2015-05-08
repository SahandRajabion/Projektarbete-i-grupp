<?php
require_once('View/BaseView.php');
require_once('Model/Dao/MessagesRepository.php');
require_once("./Model/LoginModel.php");
require_once("./Model/ImagesModel.php");

class ProgramView extends baseView {
    private $model;
    private $pic;
    private $messageRepository;
    private $imagesModel;

    public function __construct() 
    {
      $this->model = new LoginModel();
      $this->imagesModel = new ImagesModel();
      $this->messageRepository = new MessagesRepository();
    }

    public function showCoursePage() {
    $this->username = $this->model->getUsername();
    $adminMenu = "";
    $userPic = "";

    if ($this->model->isAdmin()) 
    {
        $adminMenu .= "<li><a name='newCourse' href='?". $this->createNewCourseLocation . "'>Create course</a></li>";
    }
 

    $user = $this->model->GetUserProfileDetails($this->model->getId());
    $Images = glob("imgs/*.*");
    
    foreach ($Images as $value) 
    {  
        $img = $this->imagesModel->getImgs($this->username);
        if ($img->getImg() == basename($value)) 
        {        
          $userPic .= '<div><img id="profileImage" src="'.$value.'" > <label id="profileName">' . $this->username . '</label></div>';
          $this->pic = $value;
        }
    }

    if (basename($this->pic) === "" && $user->getSex() == "Man") 
    {
        $userPic .= '<div><img id="profileImage" src="img/default.jpg"> <label id="profileName">' . $this->username . '</label></div>';
    }
    else if (basename($this->pic) === "" && $user->getSex() == "Kvinna")
    {
        $userPic .= '<div><img id="profileImage" src="img/kvinna.png" <label id="profileName">' . $this->username . '</label></div>';
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

        <title>Progams | LSN</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/customCss.css" rel="stylesheet">

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
              <a class="navbar-brand" href="?">Linnéus Social Network</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav navbar-right">
              <li>' . $userPic . '</li>
                ' . $adminMenu . '
                <li><a name="profile" href="?' . $this->userProfileLocation . "&id=".$this->model->getId(). '">My profile</a></li>
                <li><a name="logOut" href="?' . $this->logOutLocation . '">Log out</a></li>
              </ul>
            </div>
          </div>
        </nav>

        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
              <ul class="nav nav-sidebar">
                <li class="active"><a href="?">Available Programs <span class="sr-only">(current)</span></a></li>';
           
                $open = $this->messageRepository->getIfOpenOrNot($this->model->getId());

            
                  if ($open != null) {
                        # code...
                       if ($open == 1) {
                         # code...
                         $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->model->getId().'">Inbox (One new message)</a></li>';
                       }
                       else {
                           $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->model->getId().'">Inbox ('.$open.' new messages)</a></li>';
                       }
                  }
                  else {
                      $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->model->getId().'">Inbox</a></li>';
                  }
                 
                


              
                   
               
              
              $html .= '<li><a name="Inbox" href="?' . $this->sendLocation ."&".$this->id."=".$this->model->getId().'">Sent Messages</a></li>'.
              '</ul>
            </div>
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            ' . $this->message . '
              <h1 class="page-header">Available Programs</h1>

              <div class="row placeholders">
                <div class="col-xs-6 col-sm-3 placeholder">
                  <a href="?' . $this->UDCourseLocation . '">
                  <img src="img/ud2.png" class="img-thumbnail">
                  </a>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                  <a href="?' . $this->WPCourseLocation . '">
                  <img src="img/wp2.png" class="img-thumbnail">
                  </a>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                  <a href="?' . $this->IDCourseLocation . '">
                  <img src="img/id2.png" class="img-thumbnail">
                  </a>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                  <a href="?' . $this->PUCourseLocation . '">
                  <img src="img/public2.png" class="img-thumbnail">
                  </a>
                </div>
              </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/ie10-viewport-bug-workaround.js"></script>
      </body>
    </html>';


    return $html;
  }


   public function didUserPressUD() {
        if (isset($_GET[$this->UDCourseLocation])) {
            return true;
        }
        return false;

    }

     public function didUserPressID() {
        if (isset($_GET[$this->IDCourseLocation])) {
            return true;
        }
        return false;

    }

     public function didUserPressWP() {
        if (isset($_GET[$this->WPCourseLocation])) {
            return true;
        }
        return false;

    }

     public function didUserPressPU() {
        if (isset($_GET[$this->PUCourseLocation])) {
            return true;
        }
        return false;
    }

        /**
     * @param $message string containing feedback
     */
    public function setMessage($message) {
        $this->message = $message;
    }
}