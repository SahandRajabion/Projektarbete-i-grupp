<?php

 /**
 * 
 */
 require_once("helper/CookieStorage.php");
 require_once("View/BaseView.php");
 class ResetPasswordView extends BaseView
 {
 	
 	function __construct()
 	{
 		$this->cookie = new CookieStorage();
 	}

 	public function showResetPasswordPage() {
 		$this->message = $this->renderCookieMessage($this->messageLocation);
		$html = "
		</br>
		<h1>LSN (Linnéuniversitetet social network)</h1>
		<br/>
                    <form action='' class='form-horizontal' method=post enctype=multipart/form-data>
                       <fieldset>
					      <legend>Ändra lösenordet</legend>
						      $this->message
					      <div class='form-group'>
					         <label class='col-sm-2 control-label' for='$this->newPasswordLocation'>Ny lösenord: </label>
					         <div class='col-sm-10'>
					           <input id='password' class='form-control' name='$this->newPasswordLocation' type='password' size='20' maxlength='20'>
					         </div>
					      </div>
					      <div class='form-group'>
					         <label class='col-sm-2 control-label' for='$this->newConfirmPasswordLocation'>Reptera lösenordet: </label>
					         <div class='col-sm-10'>
					           <input id='password2' class='form-control' name='$this->newConfirmPasswordLocation' type='password' size='20' maxlength='20'>
					         </div>
					      </div>

					     <div class='form-group'>
				           <div class='col-sm-offset-2 col-sm-10'>
					         <input class='btn btn-default' name='$this->submitNewPasswordLocation' type='submit' value='Uppdatera lösenordet' />
					       </div>
					     </div>
					   </fieldset>
			       </form>";
		return $html;
	}

 	public function issetCode() {

		if (isset($_GET[$this->code])) {
			# code...
			return true;
		}
	}

	public function issetUsername() {
		if (isset($_GET[$this->usernameLocation])) {
			# code...
			return true;
		}
	}


	 public function getCode() {

		if (isset($_GET[$this->code])) {
			# code...
			return $_GET[$this->code];
		}
	}

	public function getUsername() {
		if (isset($_GET[$this->usernameLocation])) {
			# code...
			return $_GET[$this->usernameLocation];
		}
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
 }