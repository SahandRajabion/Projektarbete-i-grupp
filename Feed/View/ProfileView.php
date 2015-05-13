<?php

require_once('View/HTMLView.php');
require_once('Model/ImagesModel.php');
require_once('View/BaseView.php');
require_once('Model/LoginModel.php');
require_once('Model/Token.php');
require_once('Model/Dao/MessagesRepository.php');


class ProfileView extends BaseView
{
  private $messageRepository;
  private $imagesModel;
  private $pic;
  private $pic2;
  private $loginModel;

  function __construct()
  {
    $this->imagesModel = new ImagesModel();
    $this->loginModel = new LoginModel();
    $this->messageRepository = new MessagesRepository();
  }

  public function didUserPressToEditProfile() 
  {
      if (isset($_POST[$this->editProfileLocation])) 
      {
          return true;
      }
 
      return false;
  }

  /**
    * Function to render message
    */
    public function setMessage($message) {
        $this->message .= $message;
    }



 public function userProfile() {

    // BEHÖVS
    $Images = glob("imgs/*.*");

    if ($this->loginModel->getId() == $this->getId()) {


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
              $userPic .= '<div><img id="profileImage" src="img/kvinna.png" <label id="profileName"><a name="profile" href="?' . $this->userProfileLocation . "&id=".$this->loginModel->getId(). '">' . $username . '</a></label></div>';
          }


            foreach ($Images as $value) 
            { 
            $img = $this->imagesModel->getImages($this->getId());

            if ($img !== null && empty($img) == false) {
              if ($img->getImgName() == basename($value)) {
                  $userPicProfile .= $value;
                  $this->pic2 = $value;
              }
            }
          }


          if(basename($this->pic2) === "" && $users->getSex() == "Man") 
          {
            $userPicProfile .= 'img/default.jpg';
          }
         else if(basename($this->pic2) === "" && $users->getSex() == "Kvinna")
         {
           $userPicProfile .= 'img/kvinna.png';
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
        <title>My Profile | LSN</title>
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
             ' . $adminMenu .'
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
                         $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox (One new message)</a></li>';
                       }
                       else {
                           $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox ('.$open.' new messages)</a></li>';
                       }
                  }
                  else {
                      $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox</a></li>';
                  }
                 
              $html .= '<li><a name="Inbox" href="?' . $this->sendLocation ."&".$this->id."=".$this->loginModel->getId().'">Sent Messages</a></li>'.
              '<li><a href="?' . $this->changePasswordLocation . '">Change Password</span></a></li></ul>
            </div>';


            $html .= '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            ' . $this->message . '';

            $birthday = $users->getBirthday();
            $studyForm = $users->getSchoolForm();
            $institute = $users->getInstitute();
            $email = $users->getEmail();

            $firstName = $users->getfName();
            $lastName = $users->getlName();

              if ($birthday == "0000-00-00") 
              {
                  $birthday = "";
              }

          $html .= '<div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">My Profile</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <img alt="Profile Picture" src="' . $userPicProfile . '" height="100" width="100">
        
        <form  class="form-horizontal" enctype="multipart/form-data" action="" method="post" name="image_upload_form" id="image_upload_form">
        <div class ="form-group">
                <input type="File" accept="imgs/*" name="image_upload_file" id="image_upload_file">
        </div>

        <div class="form-group">
                <input type="submit" name="change" value="Change Picture" class="btn btn-success" id="change">

        </div>

        <div class="form-group">
          <input type="submit" name="default" value="Remove Picture" class="btn btn-danger" id="default">
        </div>
          
        </form>

        </div>
                

                <div class=" col-md-9 col-lg-9 "> 
                <form action="" method="post">
                  <table class="table table-user-information">
                    <tbody>

                      <tr>
                        <td>
                       <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="fName" class="form-control input-lg" name="' . $this->fNameLocation . '" value="' . $firstName . '" type="text" size="20" maxlength="20" placeholder="First Name" />
                        </div>
                        </td>
                      </tr>

                      <tr>
                      <td>
                      <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="lName" class="form-control input-lg" name="' . $this->lNameLocation . '" value="' . $lastName . '" type="text" size="20" maxlength="20" placeholder="Last Name" />
                        
                         </div>
                         </td>
                      </tr>

                      <tr>
                        <td>
                                             <em>(optional)</em>
                      <div class="input-group">

                      <span class="input-group-addon"><i class="glyphicon glyphicon-gift"></i></span>

                        <input id="birthday" class="form-control input-lg"   name="' . $this->birthdayLocation . '" type="date" value="' . $birthday . '" placeholder="yyyy-mm-dd"/>

                        </div>
                        </td>
                      </tr>';

                  if ($users->getSex() == "Man") 
                  {
                    $html .= '<tr><td>
                    <select class="form-control input-lg" name="' . $this->sexLocation . '">
                    <option value="" disabled>Choose Gender</option>
                  <option value="Man" selected>Man</option>
                  <option value="Kvinna">Woman</option>
                </select>
                    </div>
                  </div></td></tr>';
              }

              else 
              {
                    $html .= '<tr><td>
                    <select class="form-control input-lg" name="' . $this->sexLocation . '">
                    <option value="" disabled>Choose Gender</option>
                  <option value="Man">Man</option>
                  <option value="Kvinna" selected>Woman</option>
                </select>
                    </div>
                  </div></td></tr>';
              }


              if ($studyForm == "Campus") {
                  $html .= '
                  <tr><td><select class="form-control input-lg" name="' . $this->schoolLocation . '">
                  <option value="" disabled>Choose Study Form</option>
                <option value="Campus" selected>Campus</option>
                <option value="Distans">Distance</option>
              </select></td></tr>';
              }

              else 
              {
                  $html .= '
                  <tr><td><select class="form-control input-lg" name="' . $this->schoolLocation . '">
                  <option value="" disabled>Choose Study Form</option>
                <option value="Campus">Campus</option>
                <option value="Distans" selected>Distance</option>
              </select></td></tr>';
              }


            if ($institute == "2") 
              {
                  $html .= '<tr><td><select class="form-control input-lg" name="' . $this->instituteLocation . '">
                  <option value="" disabled>Choose Program</option>
                <option value="2" selected>Utveckling av digitala tjänster</option>
                <option value="1">Webbprogrammerare</option>
                <option value="3">Interaktionsdesigner</option>
              </select></td></tr>';
              }

              else if ($institute == "1") 
              {
                $html .= '<tr><td><select class="form-control input-lg" name="' . $this->instituteLocation . '">
                  <option value="" disabled>Choose Program</option>
                <option value="2">Utveckling av digitala tjänster</option>
                <option value="1" selected>Webbprogrammerare</option>
                <option value="3">Interaktionsdesigner</option>
              </select></td></tr>';
              }

              else 
              {
                $html .= '<tr><td><select class="form-control input-lg" name="' . $this->instituteLocation . '">
                  <option value="" disabled>Choose Program</option>
                <option value="2">Utveckling av digitala tjänster</option>
                <option value="1">Webbprogrammerare</option>
                <option value="3" selected>Interaktionsdesigner</option>
              </select></td></tr>';
              }

                      $html .= '
                      <tr>
                      <td>
                    <input type="hidden" name="CSRFToken" value="' . Token::generate() . '" />
                    <input class="btn btn-primary" name="' . $this->editProfileLocation . '" type="submit" value="Update Profile" />
                    </td>
                     
                    </tbody>
                  </table>
                  </div>
                </div>
              </div>
            </div>';
          
        

     $html .= '<script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/ie10-viewport-bug-workaround.js"></script>
      </body>
    </html>';



        }

        // IF NOT THE ONE WHO OWNS PROFILE
        else
        {

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
              $userPic .= '<div><img id="profileImage" src="img/kvinna.png" <label id="profileName"><a name="profile" href="?' . $this->userProfileLocation . "&id=".$this->loginModel->getId(). '">' . $username . '</a></label></div>';
          }



      if ($this->loginModel->GetUserProfileDetails($this->getId()) !== NULL) {

      // PROFIL SIDANS USERS BILD
            foreach ($Images as $value) 
            { 
            $img = $this->imagesModel->getImages($this->getId());

            if ($img !== null && empty($img) == false) {
              if ($img->getImgName() == basename($value)) {
                  $userPicProfile .= $value;
                  $this->pic2 = $value;
              }
            }
          }

         $user = $this->loginModel->GetUserProfileDetails($this->getId());

          if(basename($this->pic2) === "" && $user->getSex() == "Man") 
          {
            $userPicProfile .= 'img/default.jpg';
          }
         else if(basename($this->pic2) === "" && $user->getSex() == "Kvinna")
         {
           $userPicProfile .= 'img/kvinna.png';
         }


            $birthday = $user->getBirthday();

            $age = "";

            if ($birthday != "0000-00-00" && $birthday !== NULL) 
            {
              $age = $this->calculateAge($birthday);
            }
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

        ';

        if ($this->loginModel->GetUserProfileDetails($this->getId()) !== NULL) {
          $html .= '<title> ' .  $this->escape($this->loginModel->GetUserNameById($this->getId())) . '´s Profile | LSN</title>';
        }
        else 
        {
          $html .= '<title>This user does not exist | LSN</title>';
        }

        $html .= '<link href="css/bootstrap.min.css" rel="stylesheet">
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
                <li><a href="?">Available Programmes</a></li>';
           
                $open = $this->messageRepository->getIfOpenOrNot($this->loginModel->getId());

            
                  if ($open != null) {
                        # code...
                       if ($open == 1) {
                         # code...
                         $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox (One new message)</a></li>';
                       }
                       else {
                           $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox ('.$open.' new messages)</a></li>';
                       }
                  }
                  else {
                      $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox</a></li>';
                  }
                 
                


              
                   
               
              
              $html .= '<li><a name="Inbox" href="?' . $this->sendLocation ."&".$this->id."=".$this->loginModel->getId().'">Sent Messages</a></li>'.
              '<li><a href="?' . $this->changePasswordLocation . '">Change Password</span></a></li></ul>
            </div>';


            $html .= '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            ' . $this->message . '';

        if ($this->loginModel->GetUserProfileDetails($this->getId()) !== NULL) {
          $html .= '<div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">' . $this->escape($this->loginModel->GetUserNameById($this->getId())) . '´s Profile</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <img alt="Profile Picture" src="' . $userPicProfile . '" height="100" width="100"> </div>
                

                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>First Name</td>
                        <td>'. $this->escape($user->getfName()) . '</td>
                      </tr>

                      <tr>
                        <td>Last Name</td>
                        <td>' . $this->escape($user->getlName()) . '</td>
                      </tr>

                      <tr>
                        <td>Age</td>
                        <td> ' . $age . '</td>
                      </tr>
                   
                      <tr>
                        <td>Gender</td>
                        <td> ' . $user->getSex() . '</td>
                      </tr>

                      <tr>
                        <td>Program</td>
                        <td>' . $this->programToString($user->getInstitute()) . '</td>
                      </tr>


                      <tr>
                        <td>Study Form</td>
                        <td>' . $user->getSchoolForm(). '</td>
                      </tr>
                     
                    </tbody>
                  </table>
                  
                  <a href="?'.$this->msgFormLocation.'&'.$this->id.'='.$this->getId().'" class="btn btn-primary"><i class="glyphicon glyphicon-envelope"></i> Send message</a>
                </div>
              </div>
            </div>';
          }
          else 
          {
             $html .= "<h4>This user does not exist</h4>";
          }

     $html .= '<script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/ie10-viewport-bug-workaround.js"></script>
      </body>
    </html>';

      }
      
      return $html;
  }


  public function didUserPressToSendAnewMsg() {
    
      if (isset($_GET[$this->msgFormLocation])) {
        return true;
      }

      return false;
    }
  public function hasSubmitToUpload() {
    if (isset($_POST['change'])) {
      return true;
    }
  }

  public function hasSubmitToDefault() {
    if (isset($_POST['default'])) {
      return true;
    }
  }


  public function GetImgName() {
    if (isset($_FILES['image_upload_file'])) {
      return $_FILES['image_upload_file'];
    }
    
  }


  public function RenderUserProfile($errorMessage = '') {
    $userProfile = $this->userProfile($errorMessage);
    return $userProfile;
  }

  public function didUserPressToShowProfile() {
    if (isset($_GET[$this->userProfileLocation])) {
      return true;
    }
  }

  public function calculateAge($birthdate) 
  {
    $birthday = new DateTime($birthdate);
    $today   = new DateTime('today');

    return $age = $birthday->diff($today)->y;
  }

  public function programToString($id) 
  {
    if ($id === "2") 
    {
        return "Utvecklare av digitala tjänster";
    }
    else if ($id === "1") 
    {
      return "Webbprogrammerare";
    }

    else if ($id === "3")
    {
      return "Interaktionsdesigner";
    }
  }
 }
