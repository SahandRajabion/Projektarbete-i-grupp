<?php
	

	class Youtube {

		private $videoURL;
 	

		public function __construct($videoURL) {
	
			$this->videoURL = $videoURL;
		} 

		public function getvideoURL() {
			return $this->videoURL;
		}

		
	}