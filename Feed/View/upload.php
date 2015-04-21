<?php

/**
* 
*/
require_once('View/HTMLView.php');
require_once('Model/ImagesModel.php');
class upload 
{
  private $mainView;
  private $imagesModel;
  function __construct()
  {
    # code...
    $this->mainView = new HTMLView();
    $this->imagesModel = new ImagesModel();
  }


  public function uploadProfImg($msg = '') {
    $responseMessages = '';
      if ($msg != '') {
        $responseMessages .= '<strong>' . $msg . '</strong>';
      }
      
    echo  $responseMessages;
    $Images = glob("img/*.*");
      $html = '<div id="imgContainer">';
      $html .='<form  class="form-horizontal" enctype="multipart/form-data" action="" method="post" name="image_upload_form" id="image_upload_form">';
      //   if ($Images != NULL) {
            foreach ($Images as $value) {  
              $img = $this->imagesModel->getImages(basename($value));
                 $html .= '<div id="imgArea"><img src="'.$value.'">';
            }
      //     }
      // else {
            //     $html .= '<div id="imgArea"><img src="'.$value.'">';
         //  }
        $html .= '<div class="progressBar">
            <div class="bar"></div>
            <div class="percent">0%</div>
          </div>
          <div id="imgChange"><span>Ändra profilbild</span></br>
            <input type="File" accept="image/*" name="image_upload_file" id="image_upload_file">
            <input type="submit" name="change" value="Byt" class="btn btn-info" id="change">
          </div>
        </div>
      </form>
    </div>';
return $html;
  }

  public function hasSubmitToUpload() {
    if (isset($_POST['change'])) {
      return true;
    }
  }



  public function GetImgName() {
    if (isset($_FILES['image_upload_file'])) {
      return $_FILES['image_upload_file'];
    }
    
  }

  public function RenderUploadForm($errorMessage = '') {
    $uploadForm = $this->uploadProfImg($errorMessage);
    echo $this->mainView->echoHTML($uploadForm);
  }
}