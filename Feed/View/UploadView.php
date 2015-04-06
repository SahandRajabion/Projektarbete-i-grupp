<?php

require_once('HTMLView.php');

class uploadView {
	private $mainView;
	private $upload = "upload";
	private $images = "images";
	private $show;
	private $msg = "message";

	public function __construct() {
		$this->mainView = new HTMLView();
	}

	//render upload form.
	public function imageUpload($msg = '') {
			
			$responseMessages = '';
			if ($msg != '') {
				$responseMessages .= '<strong>' . $msg . '</strong>';
			}
			
			echo  $responseMessages;
			$uploadForm =
			'<div id=upload>'.
			'<form id="imageform" class="form-horizontal" enctype="multipart/form-data" method="post" action="">' .
			'<fieldset class="upload">' .
			'<input type="File" name="'.$this->images.'"" >'.
			'<br>'.
			'<br>'.
			'<textarea name="'.$this->msg.'" cols="35" rows="5"  maxlength="80" placeholder="Dela med dig... " wrap="hard">'.$this->getComments().'</textarea>' .
			'<br>'.
			'<br>'.
			'<input id="'.$this->upload.'" type="submit" name="'.$this->upload.'" value="Ladda upp" class="btn btn-info" >'.
			'</fieldset>'.
			'</form>'.
			'</div>';
			return $uploadForm;
	}

	public function renderAllImages($imgRoot) {
		$this->show = $imgRoot;
	}


	public function getComments() {
		if (isset($_POST[$this->msg])) {
		 	return $_POST[$this->msg];
		}
	}



	public function RenderUploadForm($errorMessage = '') {

		$uploadForm = $this->imageUpload($errorMessage);
		echo $this->mainView->echoHTML($uploadForm);
	}

	public function GetImgName() {
		if (isset($_FILES[$this->images])) {
			return $this->images;
		}
		
	}

	public function hasSubmitToUpload() {
		if (isset($_POST[$this->upload])){
			return true;
		}
	}

}