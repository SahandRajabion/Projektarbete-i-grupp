<?php
	require_once('View/HTMLView.php');
	require_once('Validation/Validation.php');
	require_once('View/BaseView.php');
	class contactView extends BaseView{
		private $name = "name";
		private $email = "email";
		private $msg = "message";
		private $send = "send";
		private $GetName;
		private $GetMeg;
		private $GetEmail;
		private $mainView;	
		private $validation;
		public function __construct() {
			$this->mainView = new HTMLView();
			$this->validation = new Validation();
		}
		//render contact form.
		public function ContactForm($message = '') {
			if($this->validation->ContactFormValidation($this->getName(),$this->getEmail(),$this->getMsg()) !== true ){
				$this->GetName = $this->getName();
				$this->GetMeg = $this->getMsg();
				$this->GetEmail = $this->getEmail();
			}
			$responseMessages = ''; 
			if ($message != '') {
					
				$responseMessages .= '<strong>' . $message . '</strong>';
			}
			
                $contactUs = "<!DOCTYPE html>
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
			echo $responseMessages;
			$contactUs .=
			'<a href="?">Tillbaka</a>'.
			'<h3>Var vänlig och kontakta oss</h3>'.
			'<form class="form-horizontal"  method="post" action="">'.
			'<label><strong>Ditt namn</strong> : </label>'.
			'<input type="text" name="'.$this->name.'" maxlength="30" value="'.$this->GetName.'"  class="form-control" placeholder="Namnet krävs">' .
			'<label><strong>Din epost</strong> : </label>'.
			'<input type="text" name="'.$this->email.'" maxlength="50" class="form-control" placeholder="Epost krävs" value="'.$this->GetEmail.'">' .
		 	'<label><strong>Ditt meddelande</strong> : </label>'.
			'<textarea name="'.$this->msg.'" cols="45" rows="5" maxlength="500" class="form-control" placeholder="Skriv ditt meddelande här..." wrap="hard">'.$this->GetMeg.'</textarea>' .
			'<input type="submit" name="'.$this->send.'" value="Skicka" class="btn btn-default">'.
			'</form>';
			 $contactUs .= "</div>
                </body>
                </html>"; 
			return $contactUs;
		}
		public function RenderContactForm($errorMessage = '') {
			return $this->mainView->echoHTML($this->ContactForm($errorMessage));
		}
		public function getName() {
			if (isset($_POST[$this->name])) {
				return htmlentities($_POST[$this->name]);
			}
		}
		public function getEmail() {
	 		if (isset($_POST[$this->email])) {
				return htmlentities($_POST[$this->email]);
			}
		}
		public function getMsg() {
			if (isset($_POST[$this->msg])) {
				$message = nl2br($_POST[$this->msg]);
				return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $message);
			}
		}
		public function hasSubmitToSend() {
			if (isset($_POST[$this->send])) {
				return true;
			}
			return false;
		}

		public function didUserPressToContact() {
		if (isset($_GET[$this->ContactLocation])) {
			return true;
		}

		return false;
	}
	}