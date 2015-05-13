<?php

require_once('Model/Dao/MessagesRepository.php');
require_once('Model/Dao/CourseRepository.php');
require_once('Model/Dao/PostRepository.php');
require_once('View/BaseView.php');
require_once('Model/LoginModel.php');
require_once('Model/ImagesModel.php');


class CourseView extends BaseView
{
    private $courseRepository;
    private $loginModel;
    private $key;
    private $postRepository;
    private $messageRepository;
    private $imagesModel;
    private $pic;

    public function __construct() 
    {
        $this->courseRepository = new CourseRepository();
        $this->postRepository = new PostRepository();
        $this->loginModel = new LoginModel();
        $this->imagesModel = new ImagesModel();
        $this->messageRepository = new MessagesRepository();
    }

    public function getProgramName($id) 
    {
      if ($id === 1) 
      {
        return "Webbprogrammerare";
      }
      else if ($id === 2)
      {
        return "Utvecklare av digitala tjänster";
      }
      else if ($id === 3)
      {
        return "Interaktionsdesigner";
      }
    }
     

     public function GetCourseHTML($id)
     {    
          $programName = $this->getProgramName($id);
          $adminMenu = "";

    // BEHÖVS
    $Images = glob("imgs/*.*");

          $username = $this->loginModel->getUsername();
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
        <title> Courses for ' . $programName.  ' | LSN</title>
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
              '<li><a href="?' . $this->changePasswordLocation . '">Change Password</span></a></li>
              </ul>
            </div>';

            $html .= '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            ' . $this->message . '


            <h2 class="sub-header">Courses for ' . $programName . '</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Course Code</th>
                  <th>Course Name</th>
                </tr>
              </thead>
              <tbody>';

                $nrcourses = $this->courseRepository->GetAllCourseNr($id);

                if (isset($nrcourses) && empty($nrcourses) == false) 
                {
                    foreach ($nrcourses as $key) 
                    {
                        $courses[] = $this->courseRepository->getCourses($key);
                    }

                    if ($courses != null && empty($courses) == false) 
                    {
                        foreach ($courses as $course) 
                        {

                            foreach ($course as $key) 
                            {
                                $courseId = $this->courseRepository->getCourseID($key);
                                $courseCode = $this->courseRepository->getCourseCode($courseId);

                                $html .= 
                                        '<tr>
                                          <td>' . $courseCode . '</td>
                                          <td>' . $key . '</td>
                                          <td>
                                          <a href="?' . $this->course . '&' . $this->id . '=' . $courseId. '"> <span class="glyphicon glyphicon-home" aria-hidden=true></span> Visit Course Feed</a>
                                          </td>
                                        </tr>';
                            }
                        }
                    }
                }
                
                  $html .= '</tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    ';

     $html .= '<script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/ie10-viewport-bug-workaround.js"></script>
      </body>
    </html>';

    return $html;
    }

    public function hasSubmitAcourse() {
         if (isset($_GET[$this->course])) {
            return true;
        }

        return false;
    }

}