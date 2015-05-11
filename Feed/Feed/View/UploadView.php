<?php

require_once('View/BaseView.php');

class UploadView extends BaseView
{

	public function ImageUpload($courseId) 
	{		
			$uploadForm =
			'<div id="upload-wrapper">
			 <div align="center">'.
			'<form action="UploadPost.php" method="post" enctype="multipart/form-data" id="MyUploadForm">' .
			'<input name="FileInput" id="FileInput" type="file" />
			<input type="hidden" name="courseid" id="courseid" value="' . $courseId . '" /> '.
			'<br>'.
			'<br>'.
			'<textarea name="Message" id="Message" cols="35" rows="5"  maxlength="255" placeholder="Dela ett Inlägg / Skriv en bildtitel eller ladda upp en youtube länk i rutan!" wrap="hard"></textarea>' .
			'<br>'.
			'<br>'.
			'<input type="submit"  id="submit" value="Dela" />' .
			'<div id="output"></div>' . 
			'<img src="images/ajax-load.gif" id="loading-img" style="display:none;" alt="Var vänlig vänta..."/>'.
			'</form>'.
			'<div id="progressbox" ><div id="progressbar"></div ><div id="statustxt">0%</div></div>'.
			'</div>'.
			'</div>';
			return $uploadForm;
	}

	public function getTitle() {
		if (isset($_POST['Message'])) {
		 	return $_POST['Message'];
		}
	}

	public function RenderUploadForm($courseId) 
	{
		return $this->ImageUpload($courseId);
	}


}