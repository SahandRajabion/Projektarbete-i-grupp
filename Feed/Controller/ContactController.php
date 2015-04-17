<?php
	
	require_once('View/ContactView.php');
	require_once('Validation/Validation.php');
	require_once('Model/ContactModel.php');

	class ContactController {
		private $validation;
		private $contact;
		private $emailContact;
		public function __construct() {
			$this->contact = new ContactView();
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
			$this->contact->RenderContactForm();
			$Name = $this->getContctName();
			$Email = $this->getContactEmail();
			$Message = $this->getContactMsg();
			if ($this->didPressSend() == true) {
				
				if ($this->validation->ContactFormValidation($Name,$Email,$Message) === true) {
						// parameters to send to mail function .
			    		$messages = "Namn:\r\n" .$Name."\r\nEpost:\r\n". $Email."\r\nMeddelande:\r\n".$Message;
						$headers  = "From:".$Email."\r\n";
			    		$headers .= "Reply-To:" .$Email;
			    		$headers .= "MIME-Version: 1.0\r\n";
			    		$headers .= "Content-type: text/plain; charset=utf-8\r\n";
    				    $this->emailContact->EmailContact($messages,$headers);
				}
				else {
					return $this->contact->ContactForm($this->validation->ContactFormValidation($Name,$Email,$Message));
				}
				
			}
		}
	}