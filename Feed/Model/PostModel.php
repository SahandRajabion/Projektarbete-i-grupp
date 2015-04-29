<?php
	
require_once('Model/Dao/PostRepository.php');

class PostModel 
{
	private $postRepository;

	public function __construct() 
	{
		$this->postRepository = new PostRepository();
	}

	public function addImage(Image $image) {
		return $this->postRepository->AddImage($image);
	}	

	public function addVideo(Youtube $video) 
	{
		return $this->postRepository->AddVideo($video);
	}

	public function addPost(Post $post) 
	{
		return $this->postRepository->AddPost($post);
	}

	public function getPosts($post) 
	{
		return $this->postRepository->getPosts($post);
	}
}