<?php

require_once('HTMLView.php');

class uploadView {
	private $mainView;
	private $upload = "upload";
	private $images = "images";
	private $show;
	private $title = "message";
	

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
			'<input type="File" name="'.$this->images.'"" id="images" >'.
			'<br>'.
			'<br>'.
			'<textarea name="'.$this->title.'" cols="35" rows="5"  maxlength="255" placeholder="Dela ett Inlägg / Skriv en bildtitel eller ladda upp en youtube länk i rutan!" wrap="hard"></textarea>' .
			'<br>'.
			'<br>'.
			'<input id="submit" type="submit" name="'.$this->upload.'" value="Ladda upp"></br>' .
			'</form>'.
			'</div>';
			return $uploadForm;
	}

	public function renderAllImages($imgRoot) {
		$this->show = $imgRoot;
	}


	public function getTitle() {
		if (isset($_POST[$this->title])) {
		 	return $_POST[$this->title];
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