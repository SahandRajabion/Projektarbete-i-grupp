<?php
	
	class StartProfileImg {
		private $imgName;
 		private $username;
		public function __construct($imgName,$username) {
	
			$this->imgName = $imgName;	
			$this->username = $username;
		} 
		public function getImg() {
			return $this->imgName;
		}

		public function getUserName() 
		{
	 		return $this->username;
		}
	}