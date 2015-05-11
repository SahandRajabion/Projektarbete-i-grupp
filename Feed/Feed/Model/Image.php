<?php
	

class Image
{
	private $imgName;
	private $title;
	private $userId;

	public function __construct($imgName, $title, $userId) 
	{
		$this->imgName = $imgName;	
		$this->title = $title;
		$this->userId = $userId;
	} 

	public function getImageName() {
		return $this->imgName;
	}

	public function getUserId() 
	{
		return $this->userId;
	} 

	public function GetTitle() {
		return $this->ValidateText($this->title);
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