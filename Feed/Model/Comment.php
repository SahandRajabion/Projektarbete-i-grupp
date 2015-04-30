<?php

require_once("Model/LoginModel.php");
require_once("Model/Dao/UserRepository.php");

class Comment
{
	private $data = array();
	private $userId;
	private $loginModel;
	private $userRepository;

	public function __construct($data, $userId)
	{
		$this->data = $data;
		$this->userId = $userId;

		$this->loginModel = new LoginModel();
		$this->userRepository = new UserRepository();
	}

	public function GetData() 
	{
		return $this->data;
	}

	public function GetUserId() 
	{
		return $this->userId;
	}

	public function GetUsernameOfCreator() 
	{
		return $this->userRepository->getUsernameFromId($this->userId);
	}
	
	public static function validate(&$values)
	{
		$errors = array();
		$data	= array();

		$data['id'] = $_POST['id'];
		$data['courseid'] = $_POST['courseid'];
		
		if(!($data['body'] = filter_input(INPUT_POST, 'body', FILTER_CALLBACK, array('options'=>'Comment::ValidateText'))))
		{
			$errors['body'] = 'Vänligen skriv en kommentar';
		}

		if(!empty($errors))
		{	
			// Om några fel hittas så lägg in de i referens variabeln
			$values = $errors;
			return false;
		}
		
		// Om inga fel hittas så lägg värderna i referens variabeln
		foreach($data as $key => $value){
			$values[$key] = $value;
		}
		
		return true;
	}

	// Metoden används som FILTER_CALLBACK
	private static function ValidateText($string)
	{
		// Ser till att man har skrivit något
		if(mb_strlen($string, 'utf8') < 1)
			return false;
	
		// Tar bort alla specialtecken och gör om mellanslag till br taggar
		$string = nl2br(htmlspecialchars($string));
		
		// Tar bort de mellanslag som finns kvar
		$string = str_replace(array(chr(10), chr(13)), '', $string);
		
		return $string;
	}
}
