<?php

require_once('recaptchalib.php');


class RegisterView extends BaseView {

	private $emailRegEx; 		


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

        $this->emailRegEx = "/^[a-z0-9\å\ä\ö._-]+@[a-z0-9\å\ä\ö.-]+\.[a-z]{2,6}$/i";
        $email = $this->getEmail();
        if(!preg_match($this->emailRegEx, $email)){

        	 $email = "";

        }

                $html = "<!DOCTYPE html>
                <html>
                <head>
                <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
				<link rel='stylesheet' type='text/css' href='css/styleVal.css' />	
				<link rel='stylesheet' type='text/css' href='css/custom.css' />	
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
					        <label class='col-sm-2 control-label1' for='$this->usernameLocation'>Användarnamn: </label>
					        <div class='col-sm-10'>					          
					        <div style='color: #FF0000;'>*</div>
					          <input id='username' class='form-control1' value='$username' name='$this->usernameLocation' type='text' size='20' maxlength='20'/>
					        </div>
					      </div>

					       <div class='form-group'>
					        <label class='col-sm-2 control-label1' for='$this->fNameLocation'>Förnamn: </label>
					        <div class='col-sm-10'>
					        <div style='color: #FF0000;'>*</div>
					          <input id='fName' class='form-control1'  name='$this->fNameLocation' value='". htmlspecialchars($this->getFname())."' type='text' size='20' maxlength='20'/>
					        </div>
					      </div>


					       <div class='form-group'>
					        <label class='col-sm-2 control-label1' for='$this->lNameLocation'>Efternamn: </label>
					        <div class='col-sm-10'>
					        <div style='color: #FF0000;'>*</div>
					          <input id='lName' class='form-control1'  name='$this->lNameLocation' value='". htmlspecialchars($this->getLname())."' type='text' size='20' maxlength='20'/>
					        </div>
					      </div>

					      <div class='form-group'>
					        <label class='col-sm-2 control-label1' for='$this->sexLocation'>Kön: </label>
					        <div class='col-sm-10'>
					        <div style='color: #FF0000;'>*</div>

					        <select name='$this->sexLocation'>
					        <option value=''>VÄLJ KÖN</option>
    						<option value='Man'>Man</option>
    						<option value='Kvinna'>Kvinna</option>
							</select>
					        </div>
					      </div>
					  
					      <div class='form-group'>
					        <label class='col-sm-2 control-label1' for='$this->birthdayLocation'>Födelsedag: </label>
					        <div class='col-sm-10'>
					        <input id='birthday' name='$this->birthdayLocation' type='date' value='' placeholder='1992-05-12'/> 
							</div>
					      </div>

					      <div class='form-group'>
					        <label class='col-sm-2 control-label1' for='$this->emailRegLocation'>Epost: </label>
					        <div class='col-sm-10'>
					         <div style='color: #FF0000;'>*</div>
					          <input id='email1' class='form-control1'  name='$this->emailRegLocation' value='".htmlspecialchars($email)."' type='text' size='20' maxlength='40'/>
					        </div>
					      </div>

					       <div class='form-group'>
					        <label class='col-sm-2 control-label1' for='$this->emailConfirmLocation'>Bekräfta epost: </label>
					        <div class='col-sm-10'>
					        <div style='color: #FF0000;'>*</div>
					          <input id='email2' class='form-control1'  name='$this->emailConfirmLocation' type='text' size='20' maxlength='40'/>
					        </div>
					      </div>

					        <div class='form-group'>
					        <label class='col-sm-2 control-label1' for='$this->schoolLocation'>Välj din studieform: </label>
					        <div class='col-sm-10'>
					        <div style='color: #FF0000;'>*</div>
					        <select name='$this->schoolLocation'>
					        <option value=''>VÄLJ STUDIEFORM</option>
    						<option value='Campus'>Campus</option>
    						<option value='Distans'>Distans</option>
							</select>
					        </div>
					      </div>


					        <div class='form-group'>
					        <label class='col-sm-2 control-label1' for='$this->instituteLocation'>Vad läser du för program? </label>
					        <div class='col-sm-10'>
					        <div style='color: #FF0000;'>*</div>

					        <select name='$this->instituteLocation'>
					        <option value=''>VÄLJ PROGRAM</option>
    						<option value='UD'>Utveckling av digitala tjänster</option>
    						<option value='WP'>Webbprogrammering</option>
    						<option value='ID'>Iteraktionsdesign</option>
							</select>
					        </div>
					      </div>



					      <div class='form-group'>
					         <label class='col-sm-2 control-label1' for='$this->passwordLocation'>Lösenord: </label>
					         <div class='col-sm-10'>
					         <div style='color: #FF0000;'>*</div>
					           <input id='password' class='form-control1' name='$this->passwordLocation' type='password' size='20' maxlength='20'>
					           <span id='result'></span>
					         </div>
					      </div>
					      <div class='form-group'>
					         <label class='col-sm-2 control-label1' for='$this->confirmPasswordLocation'>Bekräfta lösenord: </label>
					         <div class='col-sm-10'>
					          <div style='color: #FF0000;'>*</div>
					           <input id='password2' class='form-control1' name='$this->confirmPasswordLocation' type='password' size='20' maxlength='20'>
					         </div>
					      </div>

					      <div class='form-group'>
					      <label class='col-sm-2 control-label1'>Skriv in ReCaptcha text: </label>
					         <div class='col-sm-10'>
					         <div style='color: #FF0000;'>*</div>

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
