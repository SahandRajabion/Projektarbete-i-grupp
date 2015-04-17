<?php
	class ContactModel {
		private static $to = "sahib@hotmail.se";
		private static $subj = "Nytt Meddelande";
		private static $succesMessageMail = '<div class="alert alert-success alert-dismissible" role="alert">
  							 				 <button type="button" class="close" data-dismiss="alert">
  											 <span aria-hidden="true">&times;</span><span class="sr-only">Stäng</span></button>
  										     <strong>Meddelandet har skickats!</strong></div>';
		public function __construct() {
		}
		// Mail function to send a message by contact from.
		public function EmailContact($message, $header) {
			if (mail(self::$to, self::$subj, $message, $header)) {
				echo self::$succesMessageMail; 
			}
		}
	}