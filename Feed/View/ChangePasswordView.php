<?php

require_once("helper/CookieStorage.php");
require_once("View/BaseView.php");
//require_once('Model/LoginModel.php');
class ChangePasswordView extends BaseView
{
	//private $model;

	public function __construct() 
	{
		$this->cookie = new CookieStorage();
		//$this->model = new LoginModel();
	}

	public function didUserPressToChangePassword() {
		if (isset($_GET[$this->changePasswordLocation])) {
			return true;
		}

		return false;
	}

	public function saveCookieMessage($value) {
        $this->cookie->save($this->messageLocation, $value, time()+3600);
    }

	public function renderCookieMessage($string) {
		$value = $this->cookie->load($string);
		$this->unsetMessage($string);
		return $value;
	}

	public function unsetMessage($name) {
			$this->cookie->save($name, null, time()-1);
	}

	public function getNewPassword() {
		if (isset($_POST[$this->newPasswordLocation])) {
			return strip_tags($_POST[$this->newPasswordLocation]);
		}
	}

	public function getNewConfirmPassword() {
		if (isset($_POST[$this->newConfirmPasswordLocation])) {
			return strip_tags($_POST[$this->newConfirmPasswordLocation]);
		}
	}	

	public function didUserPressSubmit() 
	{
		if (isset($_POST[$this->submitNewPasswordLocation])) 
		{
			return true;			
		}

		return false;
	}	

	public function showChangePasswordForm() 
	{
		$this->message = $this->renderCookieMessage($this->messageLocation);

                $html = "<!DOCTYPE html>
                <html>
                <head>
                <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
				<link rel='stylesheet' type='text/css' href='css/styleVal.css' />		
				<script src='js/script.js'></script>
                <title>LSN</title>                
                <meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1'>
                </head>
                <body>
                 <div class='container'>";		
//                 var_dump($this->model->getId());

		$html .= "
		</br>
		<a href='?'>Tillbaka</a>
                    <form action='' class='form-horizontal' method=post enctype=multipart/form-data>
                       <fieldset>
						<h1>Byt lösenord</h1>
						      $this->message

						       <div class='form-group'>
					         <label class='col-sm-2 control-label' for='$this->passwordLocation'>Nuvarande lösenord: </label>
					         <div class='col-sm-10'>
					           <input id='password1' class='form-control' name='$this->passwordLocation' type='password' size='20' maxlength='20'>
					         </div>
					      </div>

					      <div class='form-group'>
					         <label class='col-sm-2 control-label' for='$this->newPasswordLocation'>Nytt lösenord: </label>
					         <div class='col-sm-10'>
					           <input id='password' class='form-control' name='$this->newPasswordLocation' type='password' size='20' maxlength='20'>
					           <span id='result'></span>
					         </div>
					      </div>
					      <div class='form-group'>
					         <label class='col-sm-2 control-label' for='$this->newConfirmPasswordLocation'>Bekräfta lösenord: </label>
					         <div class='col-sm-10'>
					           <input id='password2' class='form-control' name='$this->newConfirmPasswordLocation' type='password' size='20' maxlength='20'>
					         </div>
					      </div>

					     <div class='form-group'>
				           <div class='col-sm-offset-2 col-sm-10'>
					         <input class='btn btn-default' name='$this->submitNewPasswordLocation' type='submit' value='Byt lösenord' />
					       </div>
					     </div>
					   </fieldset>
			       </form>";

		            $html .= "</div>
                </body>
                </html>";     	       
		
		return $html;
	}
}
