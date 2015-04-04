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
			return $this->msg;
		}

	}