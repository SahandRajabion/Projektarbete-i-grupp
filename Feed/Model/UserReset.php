<?php

class UserReset 
{
	private $code;
	private $password;

	public function __construct($code, $password) 
	{
		$this->code = $code;
		$this->password = $password;
	}

	public function getCode() {
		return $this->code;
	}

	public function getPassword() {
		return $this->password;
	}	
}