<?php

require_once('recaptchalib.php');


class RegisterView extends BaseView {

	/**
  	* Function to render message
  	*/
    public function setMessage($message) {
        $this->message .= $message;
    }

    /**
  	* Function to see where user wants to go and do
  	*/	
	public function didUserPressReturnToLoginPage() {
		if (isset($_GET[$this->loginLocation])) {
			return true;
		}
		return false;
	}

	public function didUserPressSubmit() {
		if (isset($_POST[$this->registerLocation])) {
			return true;
		}
		return false;
	}

    /**
  	* Functions to get register information
  	*/	
	public function getUserName() {
		if (isset($_POST[$this->usernameLocation])) {
			return strip_tags($_POST[$this->usernameLocation]);
		}
	}

	public function getConfirmPassword() {
		if (isset($_POST[$this->confirmPasswordLocation])) {
			return strip_tags($_POST[$this->confirmPasswordLocation]);
		}
	}

	/**
  	* Show register page
  	*
  	* @return string Returns String HTML
  	*/	
	public function showRegisterPage() {
        $username = "";
        if(isset($_POST[$this->registerLocation])){
            $usernameInput = $this->getUserName();
            $username .= strip_tags($usernameInput);
        }

		$html = "
		</br>
		<a href='?$this->loginLocation'>Back</a>
			   <h1>It Security Forum</h1>
                    <form action='' class='form-horizontal' method=post enctype=multipart/form-data>
                       <fieldset>
					      <legend>Register a new user</legend>
					      $this->message
					      <div class='form-group'>
					        <label class='col-sm-2 control-label' for='$this->usernameLocation'>Username: </label>
					        <div class='col-sm-10'>
					          <input id='username' class='form-control' value='$username' name='$this->usernameLocation' type='text' size='20' maxlength='20'/>
					        </div>
					      </div>
					      <div class='form-group'>
					         <label class='col-sm-2 control-label' for='$this->passwordLocation'>Password: </label>
					         <div class='col-sm-10'>
					           <input id='password' class='form-control' name='$this->passwordLocation' type='password' size='20' maxlength='20'>
					         </div>
					      </div>
					      <div class='form-group'>
					         <label class='col-sm-2 control-label' for='$this->confirmPasswordLocation'>Confirm password: </label>
					         <div class='col-sm-10'>
					           <input id='password2' class='form-control' name='$this->confirmPasswordLocation' type='password' size='20' maxlength='20'>
					         </div>
					      </div>

					      <div class='form-group'>
					         <div class='col-sm-10'>
					                " . recaptcha_get_html(Settings::$SITE_KEY) . "
					         </div>
					      </div>

					     <div class='form-group'>
				           <div class='col-sm-offset-2 col-sm-10'>
					         <input class='btn btn-default' name='$this->registerLocation' type='submit' value='Register' />
					       </div>
					     </div>
					   </fieldset>
			       </form>";

		return $html;
	}
}
