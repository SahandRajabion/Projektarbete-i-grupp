<?php
	
	require_once('View/ContactView.php');
	require_once('Validation/Validation.php');
	require_once('Model/ContactModel.php');

	class ContactController {
		private $validation;
		private $contact;
		private $emailContact;
		public $validationErrors = 0;


		public function __construct(ContactView $contact) {
			$this->contact = $contact;
			$this->validation = new Validation();
			$this->emailContact = new ContactModel();
		}
		//funcations for contact from 
		private function getContctName() {
			return $this->contact->getName();
		}
		private function getContactEmail() {
			return $this->contact->getEmail();
		}
		private function getContactMsg() {
			return $this->contact->getMsg();
		}
		private function didPressSend() {
			return $this->contact->hasSubmitToSend();
		}
		//Send input to validation method.
		private function sendContactFormInfo() {
			$Name = $this->getContctName();
			$Email = $this->getContactEmail();
			$Message = $this->getContactMsg();
			$this->validation->ContactFormValidation($Name,$Email,$Message);
		}

		//Render contact form and make sure that all is right to make a contact message.
		public function doContact() {
			$Name = $this->getContctName();
			$Email = $this->getContactEmail();
			$Message = $this->getContactMsg(); 
			if ($this->didPressSend() == true) {

				 if (isset($_POST["recaptcha_challenge_field"])) 
           	    {

            $resp = recaptcha_check_answer (Settings::$SECRET_KEY,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
        	   

        	   
                    if (!$resp->is_valid) 
                    {
                        $msgId = 14;
                        $this->validationErrors++;
                        $this->loginMessage = new LoginMessage($msgId);        
		                $message = $this->loginMessage->getMessage();
		                $this->contact->setMessage($message);
		                return  $this->contact->ContactForm();                
                    }
                
				
				if ($this->validation->ContactFormValidation($Name,$Email,$Message) === true && $resp->is_valid && $this->validationErrors === 0) {
						// parameters to send to mail function .
			    		$messages = "Namn:\r\n" .$Name."\r\nEpost:\r\n". $Email."\r\nMeddelande:\r\n".$Message;
						$headers  = "From:".$Email."\r\n";
			    		$headers .= "Reply-To:" .$Email;
						$msgId = 45;
    				    $this->emailContact->EmailContact($messages,$headers);
    				    $this->loginMessage = new LoginMessage($msgId);        
		                $message = $this->loginMessage->getMessage();
		                $this->contact->setMessage($message);
		                return  $this->contact->ContactForm();

				}
				else {
					$msgId = $this->validation->ContactFormValidation($Name,$Email,$Message);
					$this->loginMessage = new LoginMessage($msgId);        
	                $message = $this->loginMessage->getMessage();
	                $this->contact->setMessage($message);
	                return  $this->contact->ContactForm();
				}
				
			}
			else{

				 $msgId = 55;

				 $this->loginMessage = new LoginMessage($msgId);        
		                $message = $this->loginMessage->getMessage();
		                $this->contact->setMessage($message);
		                return  $this->contact->ContactForm();

			}
		}
	}
}