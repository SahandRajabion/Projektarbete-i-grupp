<?php

class PostItems
{

//Post Items
	private $userId;
	private $imgName;
	private $post;
	private $Ptitle;
	private $code;

//RSS-Items
	private $link; 
	private $creator;
	private $id;
	public $date; 


	
	public function __construct($id,$userId, $imgName, $post, $Ptitle, $code, $date, $link, $creator) 
	{
		$this->userId = $userId;
		$this->imgName = $imgName;
		$this->post = $post;
		$this->Ptitle = $Ptitle;
		$this->code = $code;
		$this->id = $id;
		$this->link = $link;
		$this->date = $date;
		$this->creator = $creator;

	} 


	public function getid() 
	{
		return $this->id;
	}

	public function getUserId() 
	{
		return $this->userId;
	}

	public function getImgName() 
	{
		return $this->imgName;
	}

	public function getPost() 
	{

		return $this->ValidateText($this->post);
	}

	public function getPTitle() 
	{
		return $this->Ptitle;
	}

	public function getCode() 
	{
		return $this->code;
	}


	public function getLink() 
	{
		return $this->link;
	}

	public function getCreator() 
	{
		return $this->creator;
	}

	public function getDate() 
	{
		return $this->date;
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

