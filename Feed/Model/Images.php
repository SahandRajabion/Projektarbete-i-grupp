<?php
	

	class Images {

		private $imgName;
		private $msg;
 	

		public function __construct($imgName,$msg) {
	
			$this->imgName = $imgName;	
			$this->msg = $msg;
		} 

		public function getImgName() {
			return $this->imgName;
		}

		public function GetMSG() {
			return $this->ValidateText($this->msg);
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