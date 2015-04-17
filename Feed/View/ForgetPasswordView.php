<?php

require_once("View/BaseView.php");

class ForgetPasswordView extends BaseView {




		public function __construct() {
			
		}

		public function showForgetPasswordPage() {

		$html = "<!DOCTYPE html>
				<html>
				<head>
                <title>LSN</title>				
				<meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1'>
				</head>
				<body>
				 <div class='container'>";
				 	
		$html .= "
		</br>
		<h1>LSN</h1>
		<br/>
		<a href='?$this->loginLocation'>Back</a>
                    <form action='' class='form-horizontal' method=post enctype=multipart/form-data>
                       <fieldset>
					      <div class='form-group'>
					         <label class='col-sm-2 control-label' for='$this->emailLocation'>E-post: </label>
					         <div class='col-sm-10'>
					           <input id='email' class='form-control' name='$this->emailLocation' type='email' size='40' maxlength='40'>
					         </div>
					      </div>
					     <div class='form-group'>
				           <div class='col-sm-offset-2 col-sm-10'>
					         <input class='btn btn-default' name='$this->forgetPasswordLocation' type='submit' value='Skicka' />
					       </div>
					     </div>
					   </fieldset>
			       </form>";


		$html .= "</div>
				</body>
				</html>";

		return $html;
	}


	public function didUserPressReturnToLoginPage() {
		if (isset($_POST[$this->loginLocation])) {
			return true;
		}
		return false;
	}


	public function pressSubmitToSend() {
		if (isset($_POST[$this->forgetPasswordLocation])) {
			# code...
			return true;
		}
		return false;
	}



	public function getEmail() {
		if (isset($_POST[$this->emailLocation])) {
		
				return htmlentities($_POST[$this->emailLocation]);
			
			
		}
	}
}