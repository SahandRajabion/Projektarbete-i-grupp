<?php
	
	require_once('Model/Dao/PostRepository.php');

 	class PostModel {

 		private $postRepository;

 		public function __construct() {

 			$this->postRepository = new PostRepository();
 		}

 		/*public function removeImages($img) {
 			$this->imagesRepository->delete($img);
						 
 		}*/

 		public function addPost(Posts $post) {
 			 $this->postRepository->AddPost($post);
 		}
/*
 		public function EditImagesInformation(Images $img) {
 			$this->imagesRepository->SaveEdit($img);
 		}*/

 		public function getPosts($post) {
			return $this->postRepository->getPosts($post);
		}
 	}