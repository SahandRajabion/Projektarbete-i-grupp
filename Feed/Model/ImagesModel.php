<?php
	require_once('Model/Dao/ImagesRepository.php');
 	
 	class ImagesModel {
 		private $imagesRepository;
 		public function __construct() {
 			$this->imagesRepository = new ImagesRepository();
 		}
 	
 		public function updateImage(ProfilePic $img) {
 			 $this->imagesRepository->updateImage($img);
 		}
 	
 		public function getImages($userId) {
			return $this->imagesRepository->getImagesInformation($userId);
		}

		public function getImgs($username) {
			return $this->imagesRepository->getImagesName($username);
		}


		public function getImgToRemove($name) {
			return $this->imagesRepository->getImagesToRemove($name);
		}
 	}