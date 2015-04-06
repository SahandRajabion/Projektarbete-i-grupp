<?php
	

	class Posts {

		private $post;
		//private $date;
 	

		public function __construct($post) {
	
			$this->post = $post;	
			//$this->date = $date;
		} 

		/*public function getDate() {
			return $this->date;
		}*/

		public function getPost() {
			return $this->ValidateText($this->post);
		}


		private static function ValidateText($string)
		{		
			// Tar bort alla specialtecken och gör om mellanslag till br taggar
			$string = nl2br(htmlspecialchars($string));
			
			// Tar bort de mellanslag som finns kvar
			$string = str_replace(array(chr(10), chr(13)), '', $string);
		
			return $string;
		}

	}