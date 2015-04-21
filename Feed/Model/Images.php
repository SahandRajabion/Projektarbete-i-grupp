<?php
	
	class Images {
		private $imgName;
 	
		public function __construct($imgName) {
	
			$this->imgName = $imgName;	
		} 
		public function getImgName() {
			return $this->imgName;
		}

	}