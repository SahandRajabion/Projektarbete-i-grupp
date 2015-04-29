<?php

class PostCourse
{
	private $post;
	private $userId;
	private $courseid;

	public function __construct($post, $userId,$courseid) 
	{
		$this->post = $post;
		$this->userId = $userId;
		$this->courseid = $courseid;
	} 

	public function getPost() 
	{
		return $this->ValidateText($this->post);
	}

	public function getUserId() 
	{
		return $this->userId;
	}

	public function getCourseId() 
	{
		return $this->courseid;
	}

	private static function ValidateText($string)
	{		
		// Tar bort alla specialtecken och gör om mellanslag till br taggar
		$string = nl2br(htmlspecialchars($string));
		
		// Tar bort de mellanslag som finns kvar
		$string = str_replace(array(chr(10), chr(13)), '', $string);
	
		return $string;
	}
}