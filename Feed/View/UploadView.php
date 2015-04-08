<?php

require_once('HTMLView.php');

class uploadView {
	private $mainView;
	private $upload = "upload";
	private $images = "images";
	private $show;
	private $title = "message";
	private $videoTitle = "videoTitle";
	private $code = "url";
	private $uploadVideo = "uploadVideo";

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
			'<textarea name="'.$this->title.'" cols="35" rows="5"  maxlength="255" placeholder="Dela med dig... " wrap="hard"></textarea>' .
			'<br>'.
			'<br>'.
			'<input id="'.$this->upload.'" type="submit" name="'.$this->upload.'" value="Ladda upp" class="btn btn-info" ></br>' .

			'<textarea name="'.$this->videoTitle.'" cols="10" rows="5"  maxlength="50" placeholder="Video Titel " wrap="hard"></textarea>' .
			'<textarea name="'.$this->code.'" cols="10" rows="5"  maxlength="43" placeholder="URL " wrap="hard"></textarea></br>' .
			'<input id="'.$this->uploadVideo.'" type="submit" name="'.$this->uploadVideo.'" value="Ladda upp video" class="btn btn-info" >'.


			'</fieldset>'.
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



	public function getVideoTitle() {

		if (isset($_POST[$this->videoTitle])) {

		 	return $_POST[$this->videoTitle];
		}
	}

		public function getUrlCode() {
		if (isset($_POST[$this->code])) {
		 	return $_POST[$this->code];

		 	
		}
	}


	public function hasSubmitVideoUpload() {
		if (isset($_POST[$this->uploadVideo])){
			return true;
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