<?php

/**
* 
*/
require_once('View/HTMLView.php');
require_once('Model/ImagesModel.php');
require_once('View/BaseView.php');
require_once('Controller/LoginController.php');
class upload extends BaseView
{
  private $mainView;
  private $imagesModel;
  private $pic;

  function __construct()
  {
    # code...
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
                # code...
             $html .='<form  class="form-horizontal" enctype="multipart/form-data" action="" method="post" name="image_upload_form" id="image_upload_form">';

                foreach ($Images as $value) {  
                  $img = $this->imagesModel->getImages($this->loginController->getId());
                  $removeImg = $this->imagesModel->getImgToRemove(basename($value));
                  if ($img->getImgName() == basename($value)) {
                      $html .= '<div id="imgArea"><img src="'.$value.'">';
                      $this->pic = $value;
                  }
                }
              
              if(basename($this->pic) === "") {
               $html .= '<div id="imgArea"><img src="img/default.jpg">';
              }


            $html .= '<div class="progressBar">
                <div class="bar"></div>
                <div class="percent">0%</div>
              </div>
              <div id="imgChange"><span>Ändra profilbild</span></br>
                <input type="File" accept="imgs/*" name="image_upload_file" id="image_upload_file">
                <input type="submit" name="change" value="Byt" class="btn btn-info" id="change">
                <input type="submit" name="default" value="Ändra till standardbild" class="btn btn-info" id="default">
              </div>
            </div>
          </form>
        </div>';
        }
        else
        {
            foreach ($Images as $value) {  
              $img = $this->imagesModel->getImages($this->getId());
              if ($img->getImgName() == basename($value)) {
                  $html .= '<div id="imgArea"><img src="'.$value.'">';
                  $this->pic = $value;
              }
            }
          
          if(basename($this->pic) === "") {
           $html .= '<div id="imgArea"><img src="img/default.jpg">';
          }


        $html .='
    </div>
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
}