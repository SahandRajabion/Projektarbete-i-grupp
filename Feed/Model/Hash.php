<?php

class Hash {

	/**
    * Using hashing password method from http://alias.io/2010/01/store-passwords-safely-with-php-and-mysql/
    */
    
	public function crypt($password) {
        $cost = 10;

        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

        $salt = sprintf("$2a$%02d$", $cost) . $salt;

        $hash = crypt($password, $salt);

        return $hash;
	}
}