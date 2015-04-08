<?php
	

	class Youtube {

		private $videoTitle;
		private $videoURL;
 	

		public function __construct($videoTitle, $videoURL) {
	
			$this->videoTitle = $videoTitle;	
			$this->videoURL = $videoURL;
		} 

		public function getvideoURL() {
			return $this->videoURL;
		}

		public function getvideoTitle() {
			return $this->ValidateText($this->videoTitle);
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