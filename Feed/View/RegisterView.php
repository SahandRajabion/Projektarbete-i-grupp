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
			return $_POST[$this->usernameLocation];
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
            $username .= htmlspecialchars($usernameInput);
        }

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

		$html .= "
		</br>
		<a href='?$this->loginLocation'>Tillbaka</a>
                    <form action='' class='form-horizontal' method=post enctype=multipart/form-data>
                       <fieldset>
					      <h1>Registrera användare</h1>
					      $this->message
					      <div class='form-group'>
					        <label class='col-sm-2 control-label' for='$this->usernameLocation'>Användarnamn: </label>
					        <div class='col-sm-10'>
					          <input id='username' class='form-control' value='$username' name='$this->usernameLocation' type='text' size='20' maxlength='20'/>
					        </div>
					      </div>
					      <div class='form-group'>
					         <label class='col-sm-2 control-label' for='$this->passwordLocation'>Lösenord: </label>
					         <div class='col-sm-10'>
					           <input id='password' class='form-control' name='$this->passwordLocation' type='password' size='20' maxlength='20'>
					           <span id='result'></span>
					         </div>
					      </div>
					      <div class='form-group'>
					         <label class='col-sm-2 control-label' for='$this->confirmPasswordLocation'>Bekräfta lösenord: </label>
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
					         <input class='btn btn-default' name='$this->registerLocation' type='submit' value='Registrera' />
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
