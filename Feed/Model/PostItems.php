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
	private $rssPost;
	private $rssTitle;

	
	public function __construct($id, $userId, $imgName, $post, $Ptitle, $code, $date, $link, $creator, $rssPost, $rssTitle) 
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

		$this->rssPost = $rssPost;
		$this->rssTitle = $rssTitle;

	} 


	public function getRSSPost() 
	{
		return $this->rssPost;
	}

	public function getRssTitle() 
	{
		return $this->rssTitle;
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

		return $this->post;
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
}

