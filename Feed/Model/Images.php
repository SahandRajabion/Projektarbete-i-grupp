<?php
	

class Images 
{
	private $imgName;
	private $title;
	
	public function __construct($imgName,$title) 
	{
		$this->imgName = $imgName;	
		$this->title = $title;
	} 

	public function getImgName() {
		return $this->imgName;
	}

	public function GetTITLE() {
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