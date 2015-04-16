<?php

require_once("Model/User.php");
require_once("Model/UserForget.php");
require_once("Model/Users.php");
require_once("Model/Dao/Repository.php");

class UserRepository extends Repository 
{
	private static $username = 'username';
	private static $hash = 'hash';
	private static $code = 'passreset';
	private $db;
	private $users;

	public function __construct() 
	{
		$this->dbTable = 'user';
		$this->db = $this->connection();
		$this->users = new Users();
	}


	public function add(User $user) {
			$sql = "INSERT INTO $this->dbTable (". self::$username .", ". self::$hash .") VALUES (?,?)";
			$params = array($user->getUsername(), $user->getPassword());
			$query = $this->db->prepare($sql);
			$query->execute($params);
	}
	
	public function exists($username) 
	{
		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$username . "= ?";
		$params = array($username);
		$query = $this->db->prepare($sql);
		$query->execute($params);

		$results = $query->fetch();

		if ($results == false) 
		{
			return false;
		}

		return true;
	}


	public function get($username) {
			$sql = "SELECT * FROM $this->dbTable WHERE (" . self::$username . ") = ?";
			$params = array($username);
			$query = $this->db->prepare($sql);
			$query->execute($params);
			$result = $query->fetch();
			return $result;
	}

	public function editPassword(User $user)
	{
		try 
		{
			$sql = "UPDATE $this->dbTable SET " . self::$hash ."= ? WHERE " . self::$username ."= ?";
			$params = array($user->getPassword(), $user->getUsername());
			$query = $this->db->prepare($sql);
			$query->execute($params);
		}

		catch (PDOException $e) 
		{
			die('An unknown error has occured in database');
		}
	}


	public function editForgotPassword(UserReset $user)
	{
		try 
		{
			$sql = "UPDATE $this->dbTable SET " . self::$hash ."= ? WHERE " . self::$code ."= ?";
			$params = array($user->getPassword(), $user->getCode());
			$query = $this->db->prepare($sql);
			$query->execute($params);
		}

		catch (PDOException $e) 
		{
			die('An unknown error has occured in database');
		}
	}

	public function getAll() 
	{
		try 
		{
			$sql = "SELECT * FROM $this->dbTable";

			$query = $this->db->prepare($sql);
			$query->execute();

			foreach ($query->fetchAll as $user) 
			{
				$username = $user[self::$username];
				$password = $user[self::$hash];

				$newUser = new User($username, $password);

				$this->users->addUser($newUser);
			}

			return $this->users;
		}

		catch (PDOException $e) 
		{
			die('An unknown error has occured in database');
		}
	}



		public function getEmailForResetPassword($username) {
			$sql = "SELECT * FROM $this->dbTable WHERE " . self::$username . "= ?";
			$params = array($username);
			$query = $this->db->prepare($sql);
			$query->execute($params);

			$results = $query->fetch();

			if ($results == true) 
			{
				while ($results) {
					# code...
					$email = $results['email'];
					return new UserForget($email);
				}
			}
			else
			{
				return NULL;
			}
			
		}




	public function resetPassword($code, $username)
	{
		try 
		{
			$sql = "UPDATE $this->dbTable SET " . self::$code ."= ? WHERE " . self::$username ."= ?";
			$params = array($code, $username);
			$query = $this->db->prepare($sql);
			$query->execute($params);
		}

		catch (PDOException $e) 
		{
			die('An unknown error has occured in database');
		}
	}



	public function getAllUserInfoForPassUpdate($code) {
			
			$sql = "SELECT * FROM $this->dbTable WHERE " . self::$code . "= ?";

			$params = array($code);

			$query = $this->db->prepare($sql);

			$query->execute($params);

			$result = $query->fetch();
			if ($result == true) 
			{
		
					# code...

					$db_code = $result['passreset'];

				if ($db_code = $code) {
					# code...
					return true;
				}
				else
				{
					return false;
				}

			}
		
	}
}