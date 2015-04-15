<?php


class Users 
{
	private $users;

	private $userRepository;

	public function __construct() 
	{
		$this->users = array();
	}

	public function getUsers() 
	{
		return $this->users;
	}
}