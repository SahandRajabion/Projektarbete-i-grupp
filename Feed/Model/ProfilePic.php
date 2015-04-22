<?php
	
	class ProfilePic {
		private $imgName;
 		private $userId;
		public function __construct($imgName,$userId) {
	
			$this->imgName = $imgName;	
			$this->userId = $userId;
		} 
		public function getImgName() {
			return $this->imgName;
		}

		public function getUserId() 
		{
	 		return $this->userId;
		}
	}