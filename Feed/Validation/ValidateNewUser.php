<?php

class ValidateNewUser {

//Regex validation.
	private $emailRegEx;
	private $nameRegEx;
	private $birthdayRegEx;


	function __construct()
	{
		# code...
		//Regx took from http://www.phpportalen.net/.
		$this->emailRegEx = "/^[a-z0-9\å\ä\ö._-]+@[a-z0-9\å\ä\ö.-]+\.[a-z]{2,6}$/i";
		$this->nameRegEx = "/^([a-zA-ZÅÄÖåäö]{2,10})([- ]{1})?([a-zA-ZÅÄÖåäö]{2,10})?$/";
		$this->birthdayRegEx ="/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";
	}


	/**
  	* Validate if both email is same
  	*
  	* @param string email input of user
  	*
  	* @param string confirm email input of user
  	*
  	* @return bool true or false based on if email is same
  	*/
	public function validateIfSameEmail($email, $confirmEmail) {
		if ($email != $confirmEmail) {
			return false;
		}
		return true;	
	}


	public function validateEmail($email, $confirmEmail){

	  if ($email == NULL) {
		    return false;
	   }

	 else if ($confirmEmail == NULL) {
			return false;
		}

	 else if(!preg_match($this->emailRegEx, $email)) {
			return false;
		}

		return true;
	}

	public function validateNames($fName, $lName){

	  	if($fName == NULL) {
			return false;
		}
		else if ($lName == NULL) {
			return false;
		}
		
		else if(!preg_match($this->nameRegEx, $fName)) {
		     return false;
		}
		else if(!preg_match($this->nameRegEx, $lName)) {
			return false;
		}

		return true;
	}


	public function validateSex($sex){

	    if ($sex == NULL) {
			return false;
		}
		return true;
	}

	public function validateBirthday($birthday){

		 if ($birthday == NULL) {
			return false;
		}

	    else if(!preg_match($this->birthdayRegEx, $birthday)) {
			return false;
		}

		return true;
	}


	public function validateSchoolForm($schoolForm){

	     if ($schoolForm == NULL) {
			return false;
		}

		return true;
	}

	public function validateInstitute($institute){

	     if ($institute == NULL) {
			return false;
		}

		return true;
	}



}