<?php

require_once('View/HTMLView.php');
require_once('Model/ImagesModel.php');
require_once('View/BaseView.php');
require_once('Controller/LoginController.php');

class ProfileView extends BaseView
{
  private $mainView;
  private $imagesModel;
  private $pic;

  function __construct()
  {
    $this->mainView = new HTMLView();
    $this->imagesModel = new ImagesModel();
    $this->loginController = new LoginController();
  }


 public function userProfile($msg = '') {
    $responseMessages = '';

    if ($msg != '') {
      $responseMessages .= '<strong>' . $msg . '</strong>';
    }
      
    echo  $responseMessages;
    $Images = glob("imgs/*.*");

    $html = '<a href="?">Tillbaka</a>';
    $html .= '<div id="imgContainer">';

    if ($this->loginController->getId() == $this->getId()) {
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
    $user = $this->loginController->GetUserProfileDetails($this->getId());
    foreach ($Images as $value) {  
      $img = $this->imagesModel->getImages($this->loginController->getId());
      $removeImg = $this->imagesModel->getImgToRemove(basename($value));
      if ($img->getImgName() == basename($value)) {
          $html .= '<div id="imgArea"><img src="'.$value.'">';
          $this->pic = $value;
      }
    }
  
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
        <input type="submit" name="default" value="Ändra till standardbild" class="btn btn-info" id="default">
      </div>
    </div>
  </form>
</div>'; 

            $age = "";
            $birthday = $user->getBirthday();
            if (empty($birthday) == false)
            {
              $age = $this->calculateAge($user->getBirthday());
            }

            $html .= '<strong>Förnamn:</strong> ' . $user->getfName() . '<br>
            <strong>Efternamn:</strong> ' . $user->getlName() . ' <br>
            <strong>Kön:</strong> '  . $user->getSex() .  ' <br>
            <strong>Ålder:</strong> ' . $age . ' <br>
            <strong>Program:</strong> ' . $user->getInstitute() . ' <br>
            <strong>Studieform:</strong> ' . $user->getSchoolForm();
        }

        // IF NOT THE ONE WHO OWNS PROFILE
        else
        {
            foreach ($Images as $value) {  
              $img = $this->imagesModel->getImages($this->getId());
              if ($img->getImgName() == basename($value)) {
                  $html .= '<div id="imgArea"><img src="'.$value.'">';
                  $this->pic = $value;
              }
            }
          if(basename($this->pic) === "" && $user->getSex() == "Man") 
          {
            $html .= '<div id="imgArea"><img src="img/default.jpg">';
          }
         else if(basename($this->pic) === "" && $user->getSex() == "Kvinna")
         {
           $html .= '<div id="imgArea"><img src="img/kvinna.png">';
         }

          $user = $this->loginController->GetUserProfileDetails($this->getId());

            $age = "";

            if (empty($birthday) == false)
            {
              $age = $this->calculateAge($user->getBirthday());
            }

            $html .= '<strong>Förnamn:</strong>' . $user->getfName() . '<br>
            <strong>Efternamn:</strong>' . $user->getlName() . ' <br>
            <strong>Kön:</strong> '  . $user->getSex() .  ' <br>
            <strong>Ålder:</strong> ' . $age . ' <br>
            <strong>Program:</strong> ' . $user->getInstitute() . ' <br>
            <strong>Studieform:</strong> ' . $user->getSchoolForm();

        $html .='</div>
                </div>';
      }
      
      return $html;
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
}