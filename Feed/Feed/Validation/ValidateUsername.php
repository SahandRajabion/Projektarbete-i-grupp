<?php

class ValidateUsername {

	/**
  	* Validate length of username
  	*
  	* @param string username input of user
  	*
  	* @return bool true or false based on length
  	*/	
	public function validateUsernameLength($username) {
		if (mb_strlen($username) < 3 || empty($username)) {
			return false;
		}
		return true;		
	}

	/**
  	* Check if username has illegal chars
  	*
  	* @param string username input of user
  	*
  	* @return bool true or false based on if username is illegal
  	*/
	public function validateCharacters($username) {
		if($username != strip_tags($username)) {
			return false;
		}
		return true;
	}
}