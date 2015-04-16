<?php
	
	require_once('Model/Dao/YoutubeRepository.php');
 	
 	class YoutubeModel {

 		private $youtubeRepository;

 		public function __construct() {

 			$this->youtubeRepository = new YoutubeRepository();
 		}

 	
 		public function addVideo(Youtube $video) {
 			 $this->youtubeRepository->AddVideo($video);
 		}

 	}