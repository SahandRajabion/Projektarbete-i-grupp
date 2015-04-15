<?php
	
class Post
{
	private $post;
	private $userId;

	public function __construct($post, $userId) 
	{
		$this->post = $post;
		$this->userId = $userId;		
	} 

	public function getPost() 
	{
		return $this->ValidateText($this->post);
	}

	public function getUserId() 
	{
		return $this->userId;
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