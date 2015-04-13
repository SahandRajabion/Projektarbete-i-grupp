<?php

class ValidatePassword {

	/**
  	* Validate length of password
  	*
  	* @param string password input of user
  	*
  	* @return bool true or false based on length
  	*/	
	public function validatePasswordLength($password, $confirmPassword) {
		if(mb_strlen($password) && mb_strlen($confirmPassword) < 6 || empty($password) && empty($confirmPassword) ) {
			return false;
		} 
		return true;
	}

	/**
  	* Validate if both password is same
  	*
  	* @param string password input of user
  	*
  	* @param string confirm password input of user
  	*
  	* @return bool true or false based on if password is same
  	*/
	public function validateIfSamePassword($password, $confirmPassword) {
		if ($password != $confirmPassword) {
			return false;
		}
		return true;	
	}	
}