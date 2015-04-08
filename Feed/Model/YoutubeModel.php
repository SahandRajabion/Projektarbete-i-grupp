<?php
	
	require_once('Model/Dao/YoutubeRepository.php');
 	
 	class YoutubeModel {

 		private $youtubeRepository;

 		public function __construct() {

 			$this->youtubeRepository = new YoutubeRepository();
 		}

 		/*public function removeImages($img) {
 			$this->imagesRepository->delete($img);
						 
 		}*/


 		public function addVideo(Youtube $video) {
 			 $this->youtubeRepository->AddVideo($video);
 		}



 		/*public function EditImagesInformation(Images $img) {
 			$this->imagesRepository->SaveEdit($img);
 		}

 		public function getImages($name) {
			return $this->imagesRepository->getImagesInformation($name);
		}*/
 	}