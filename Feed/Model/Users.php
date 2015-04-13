<?php

class Users 
{
	private $users;

	public function __construct() 
	{
		$this->users = array();
	}

	public function getUsers() 
	{
		return $this->users;
	}


}