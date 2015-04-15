<?php
	
class Youtube {

	private $videoURL;
	private $userId;

	public function __construct($videoURL, $userId) 
	{
		$this->videoURL = $videoURL;
		$this->userId = $userId;
	} 

	public function getVideoURL() {
		return $this->videoURL;
	}

	public function getUserId() 
	{
		return $this->userId;
	}
}