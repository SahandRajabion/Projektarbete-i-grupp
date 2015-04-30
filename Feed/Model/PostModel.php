<?php
	
require_once('Model/Dao/PostRepository.php');

class PostModel 
{
	private $postRepository;

	public function __construct() 
	{
		$this->postRepository = new PostRepository();
	}

	public function addImage(Image $image, $courseId) {
		return $this->postRepository->AddImage($image, $courseId);
	}	

	public function addVideo(Youtube $video, $courseId) 
	{
		return $this->postRepository->AddVideo($video, $courseId);
	}

	public function addPost(Post $post, $courseId) 
	{
		return $this->postRepository->AddPost($post, $courseId);
	}

	public function getPosts($post) 
	{
		return $this->postRepository->getPosts($post);
	}
}