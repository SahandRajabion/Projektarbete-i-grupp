<?php

class User 
{
	private $username;
	private $password;
	private $email;
	private $fName;
	private $lName;
	private $sex;
	private $birthday;
	private $schoolForm;
	private $institute;


	public function __construct($username, $password, $email, $fName, $lName,  $sex,  $birthday, $schoolForm, $institute) 
	{
		$this->username = $username;
		$this->password = $password;
		$this->email = $email;
		$this->fName = $fName;
		$this->lName = $lName;
		$this->sex = $sex;
		$this->birthday = $birthday;
		$this->schoolForm = $schoolForm;
		$this->institute = $institute;
		

	}

	public function getUsername() {
		return $this->username;
	}

	public function getPassword() {
		return $this->password;
	}	

	public function getEmail() {
		return $this->email;
	}	

	public function getfName() {
		return $this->fName;
	}	

	public function getlName() {
		return $this->lName;
	}	

	public function getSex() {
		return $this->sex;
	}	

	public function getBirthday() {
		return $this->birthday;
	}	

	public function getSchoolForm() {
		return $this->schoolForm;
	}	
	public function getInstitute() {
		return $this->institute;
	}
}
