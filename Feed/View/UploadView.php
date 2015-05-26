<?php

require_once('View/BaseView.php');

class UploadView extends BaseView
{

	public function ImageUpload($courseId) 
	{		 
			$uploadForm =
			'<div id="upload-wrapper">
			<script type="text/javascript" src="js/bootstrap-filestyle.min.js"> </script>
			 <div align="center">'.
			'<link href="css/customCss.css" rel="stylesheet">'.
			'<form action="UploadPost.php" method="post" enctype="multipart/form-data" id="MyUploadForm">' .
			'<input name="FileInput" id="FileInput" type="file" class="filestyle" data-buttonName="btn-primary" />
			 <input type="hidden" name="courseid" id="courseid" value="' . $courseId . '" /> '.
			'<br>'.
			'<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>'.
			'<textarea class="form-control2" name="Message" id="Message" cols="35" rows="4"  maxlength="255" placeholder="Share a post, upload an image with a relating title or type your youtube URL in the textbox and press share!" wrap="hard"></textarea>' .
			'<br>'.
			'<div id="share">'.
			'<input class="btn btn-primary btn-lg btn-block" type="submit"  id="submit" value="Press to share" /></div>' .
			'<div id="output"></div>' . 
			'<img src="View/DefaultImages/ajax-load.gif" id="loading-img" style="display:none;" alt="Var vänlig vänta..."/>'.
			'</form>'.
			' <div class="progress" id="progressbox">
  			<div class="progress-bar" id="progressbar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
  			</div>
			</div>'.
			'</div>'.
			'</div><br><br>';
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