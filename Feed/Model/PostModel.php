<?php
	
	require_once('Model/Dao/PostRepository.php');

 	class PostModel {

 		private $postRepository;

 		public function __construct() {

 			$this->postRepository = new PostRepository();
 		}

 		public function removePost($post) {
 			$this->postRepository->delete($post);
						 
 		}

 		public function addPost(Posts $post) {
 			 $this->postRepository->AddPost($post);
 		}

 		public function getPosts($post) {
			return $this->postRepository->getPosts($post);
		}
 	}