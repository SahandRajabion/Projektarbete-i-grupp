<?php

require_once('View/HTMLView.php');
require_once('Model/ImagesModel.php');
require_once('View/BaseView.php');
require_once('Model/LoginModel.php');

class ProfileView extends BaseView
{
  private $mainView;
  private $imagesModel;
  private $pic;

  function __construct()
  {
    $this->mainView = new HTMLView();
    $this->imagesModel = new ImagesModel();
    $this->loginModel = new LoginModel();
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

    $html = '<!DOCTYPE html>
        <html>
        <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/custom.css" /> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LSN</title>
        </head>

        <body>
        <div class="container">
        </br>

        <a href="?">Tillbaka</a>
        ';

    $html .= '<div id="imgContainer">';

    if ($this->loginModel->getId() == $this->getId()) {

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
        <input type="submit" name="default" value="Ändra till standardbild" class="btn btn-info" id="default">
      </div>
    </div>
  </form>
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
                   <input class='btn btn-default' name='$this->editProfileLocation' type='submit' value='Redigera användaruppgifter' />
                 </div>
               </div>
             </fieldset>
             </form>";
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

         $user = $this->loginModel->GetUserProfileDetails($this->getId());
          if(basename($this->pic) === "" && $user->getSex() == "Man") 
          {
            $html .= '<div id="imgArea"><img src="img/default.jpg">';
          }
         else if(basename($this->pic) === "" && $user->getSex() == "Kvinna")
         {
           $html .= '<div id="imgArea"><img src="img/kvinna.png">';
         }


            $birthday = $user->getBirthday();

            $age = "";

            if ($birthday != "0000-00-00") 
            {
              $age = $this->calculateAge($birthday);
            }
          

            $html .= '
            <strong>Förnamn:</strong> <br>' . $user->getfName() . '<br>
            <strong>Efternamn:</strong> <br>' . $user->getlName() . ' <br>
            <strong>Kön:</strong> <br> '  . $user->getSex() .  ' <br>
            <strong>Ålder:</strong> <br> ' . $age . ' <br>
            <strong>Program:</strong> <br> ' . $user->getInstitute() . ' <br>
            <strong>Studieform:</strong> ' . $user->getSchoolForm();

        $html .='</div>
                </div>
                </div>
        </body>
        </html>';
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