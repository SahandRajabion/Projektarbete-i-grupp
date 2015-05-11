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
  private $mainView;
  private $imagesModel;
  private $pic;
  private $pic2;
  private $loginModel;

  function __construct()
  {
    $this->mainView = new HTMLView();
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

 public function userProfile($msg = '') {
    $responseMessages = '';

    if ($msg != '') {
      $responseMessages .= '<strong>' . $msg . '</strong>';
    }    

    echo $responseMessages;   

    $Images = glob("imgs/*.*");

    if ($this->loginModel->getId() == $this->getId()) {

    $html = '<!DOCTYPE html>
        <html>
        <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/custom.css" /> 
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LSN</title>
        </head>

        <body>
        <div class="container">
        </br>

        <a href="?">Tillbaka</a>
        ';

    $html .= '<div id="imgContainer">';


       $html .= "
        <br><br>
        <nav class='navbar navbar-default' role='navigation'>
        <div class='navbar-header'>
          <button type='button' class='navbar-toggle' data-toggle='collapse' 
             data-target='#example-navbar-collapse'>
             <span class='sr-only'>Toggle navigation</span>
             <span class='icon-bar'></span>
             <span class='icon-bar'></span>
             <span class='icon-bar'></span>
          </button>
       </div>
       <div class='collapse navbar-collapse' id='example-navbar-collapse'>
          <ul class='nav navbar-nav'>
             <li><a name='changePassword' href='?" . $this->changePasswordLocation . "'>Ändra lösenord</a></li>
          </ul>
       </div>
    </nav>";

    $html .='<form  class="form-horizontal" enctype="multipart/form-data" action="" method="post" name="image_upload_form" id="image_upload_form">';
    foreach ($Images as $value) {  

      $img = $this->imagesModel->getImages($this->loginModel->getId());
      $removeImg = $this->imagesModel->getImgToRemove(basename($value));

      if ($img->getImgName() == basename($value)) {
          $html .= '<div id="imgArea"><img src="'.$value.'">';
          $this->pic = $value;
      }
    }


    $user = $this->loginModel->GetUserProfileDetails($this->getId());
  
    if(basename($this->pic) === "" && $user->getSex() == "Man") 
    {
      $html .= '<div id="imgArea"><img src="img/default.jpg">';
    }
    else if(basename($this->pic) === "" && $user->getSex() == "Kvinna")
    {
      $html .= '<div id="imgArea"><img src="img/kvinna.png">';
    }

    $html .= '<div class="progressBar">
        <div class="bar"></div>
        <div class="percent">0%</div>
      </div>
      <div id="imgChange"><span>Bläddra</span></br>
        <input type="File" accept="imgs/*" name="image_upload_file" id="image_upload_file">
        <input type="submit" name="change" value="Byt" class="btn btn-info" id="change">
        <input type="submit" name="default" value="Ändra till standard" class="btn btn-info" id="default">
      </div>
    </div><br/><br/>
    <br/><br/><br/>
    <br/><br/></form>
</div>'; 

            $age = "";

            $sex = $user->getSex();
            $birthday = $user->getBirthday();
            $studyForm = $user->getSchoolForm();
            $institute = $user->getInstitute();
            $email = $user->getEmail();

            $firstName = htmlspecialchars($user->getfName());
            $lastName = htmlspecialchars($user->getlName());

            if (empty($birthday) == false)
            {
                $age = $this->calculateAge($user->getBirthday());
            }
            
            $html .=    "<form action='' class='form-horizontal' method=post enctype=multipart/form-data>
                       <fieldset>
                       $this->message

                 <div class='form-group'>
                  <label class='col-sm-2 control-label1' for='$this->fNameLocation'>Förnamn: </label>
                  <div class='col-sm-10'>
                  <div style='color: #FF0000;'>*</div>
                    <input id='fName' class='form-control1'  name='$this->fNameLocation' value='" . $firstName . "' type='text' size='20' maxlength='20'/>
                  </div>
                </div>


                 <div class='form-group'>
                  <label class='col-sm-2 control-label1' for='$this->lNameLocation'>Efternamn: </label>
                  <div class='col-sm-10'>
                  <div style='color: #FF0000;'>*</div>
                    <input id='lName' class='form-control1'  name='$this->lNameLocation' value='". $lastName . "' type='text' size='20' maxlength='20'/>
                  </div>
                </div>

                <div class='form-group'>
                  <label class='col-sm-2 control-label1' for='$this->sexLocation'>Kön: </label>
                  <div class='col-sm-10'>
                  <div style='color: #FF0000;'>*</div>";

                  if ($sex == "Man") 
                  {
                    $html .= "
                    <select name='$this->sexLocation'>
                    <option value=''>VÄLJ KÖN</option>
                  <option value='Man' selected>Man</option>
                  <option value='Kvinna'>Kvinna</option>
                </select>
                    </div>
                  </div>";
              }

              else 
              {
                                   $html .= "
                    <select name='$this->sexLocation'>
                    <option value=''>VÄLJ KÖN</option>
                  <option value='Man'>Man</option>
                  <option value='Kvinna' selected>Kvinna</option>
                </select>
                    </div>
                  </div>"; 
              }


              if ($birthday == "0000-00-00") 
              {
                  $birthday = "";
              }

                $html .= "<div class='form-group'>
                  <label class='col-sm-2 control-label1' for='$this->birthdayLocation'>Födelsedag: </label>
                  <div class='col-sm-10'>
                  <input id='birthday' name='$this->birthdayLocation' type='date' value='" . $birthday . "' placeholder='1992-05-12'/> 
              </div>
                </div>";

                if ($studyForm == "Campus") {
                  $html .= "<div class='form-group'>
                  <label class='col-sm-2 control-label1' for='$this->schoolLocation'>Välj din studieform: </label>
                  <div class='col-sm-10'>
                  <div style='color: #FF0000;'>*</div>
                  <select name='$this->schoolLocation'>
                  <option value=''>VÄLJ STUDIEFORM</option>
                <option value='Campus' selected>Campus</option>
                <option value='Distans'>Distans</option>
              </select>
                  </div>
                </div>";
              }

              else 
              {
                  $html .= "<div class='form-group'>
                          <label class='col-sm-2 control-label1' for='$this->schoolLocation'>Välj din studieform: </label>
                          <div class='col-sm-10'>
                          <div style='color: #FF0000;'>*</div>
                          <select name='$this->schoolLocation'>
                          <option value=''>VÄLJ STUDIEFORM</option>
                        <option value='Campus'>Campus</option>
                        <option value='Distans' selected>Distans</option>
                      </select>
                          </div>
                        </div>";
              }

              if ($institute == "2") 
              {
                  $html .= "<div class='form-group'>
                  <label class='col-sm-2 control-label1' for='$this->instituteLocation'>Vad läser du för program? </label>
                  <div class='col-sm-10'>
                  <div style='color: #FF0000;'>*</div>

                  <select name='$this->instituteLocation'>
                  <option value=''>VÄLJ PROGRAM</option>
                <option value='2' selected>Utveckling av digitala tjänster</option>
                <option value='1'>Webbprogrammering</option>
                <option value='3'>Iteraktionsdesign</option>
              </select>
                  </div>
                </div>";
              }

              else if ($institute == "1") 
              {
                  $html .= "<div class='form-group'>
                  <label class='col-sm-2 control-label1' for='$this->instituteLocation'>Vad läser du för program? </label>
                  <div class='col-sm-10'>
                  <div style='color: #FF0000;'>*</div>

                  <select name='$this->instituteLocation'>
                  <option value=''>VÄLJ PROGRAM</option>
                <option value='2'>Utveckling av digitala tjänster</option>
                <option value='1' selected>Webbprogrammering</option>
                <option value='3'>Iteraktionsdesign</option>
              </select>
                  </div>
                </div>";
              }

              else 
              {
                  $html .= "<div class='form-group'>
                  <label class='col-sm-2 control-label1' for='$this->instituteLocation'>Vad läser du för program? </label>
                  <div class='col-sm-10'>
                  <div style='color: #FF0000;'>*</div>

                  <select name='$this->instituteLocation'>
                  <option value=''>VÄLJ PROGRAM</option>
                <option value='2'>Utveckling av digitala tjänster</option>
                <option value='1'>Webbprogrammering</option>
                <option value='3' selected>Iteraktionsdesign</option>
              </select>
                  </div>
                </div>";
              }

              $html .= "<div class='form-group'>
                   <div class='col-sm-offset-2'>
                   <input type='hidden' name='CSRFToken' value='" . Token::generate() . "' />
                   <input class='btn btn-default' name='$this->editProfileLocation' type='submit' value='Redigera användaruppgifter' />
                 </div>
               </div>
             </fieldset>
             </form>";
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
              $adminMenu .= "<li><a name='newCourse' href='?". $this->createNewCourseLocation . "'>Create course</a></li>";
          }

    /// PROFIL BILD FÖR NAV 
    $users = $this->loginModel->GetUserProfileDetails($this->loginModel->getId());
    $Images = glob("imgs/*.*");
    
    foreach ($Images as $value) 
    {  
        $img = $this->imagesModel->getImages($this->loginModel->getId());
        if ($img->getImgName() == basename($value)) 
        {        
          $userPic .= '<div><img id="profileImage" src="'.$value.'" > <label id="profileName">' . $username . '</label></div>';
          $this->pic = $value;
        }
    }

    if (basename($this->pic) === "" && $users->getSex() == "Man") 
    {
        $userPic .= '<div><img id="profileImage" src="img/default.jpg"> <label id="profileName">' . $username . '</label></div>';
    }
    else if (basename($this->pic) === "" && $users->getSex() == "Kvinna")
    {
        $userPic .= '<div><img id="profileImage" src="img/kvinna.png" <label id="profileName">' . $username . '</label></div>';
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
                <li><a name="profile" href="?' . $this->userProfileLocation . "&id=".$this->loginModel->getId(). '">My profile</a></li>
                <li><a name="logOut" href="?' . $this->logOutLocation . '">Log out</a></li>
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
              '</ul>
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
