<?php
 
require_once("Model/User.php");
require_once("Model/UserForget.php");
require_once("Model/Users.php");
require_once("Model/UserDate.php");
require_once("Model/Dao/Repository.php");

class UserRepository extends Repository 
{
	private static $username = 'username';
	private static $hash = 'hash';
	private static $code = 'passreset';
	private static $userId = 'userid';
	private static $date = 'date';
	private static $email = 'email';
	private static $firstName = 'firstname';
	private static $lastName = 'lastname';
	private static $sex = 'sex';
	private static $schoolForm = 'schoolForm';
	private static $institute = 'ProgramId';
	private static $birthday = 'birthday';
	private static $CourseName = "CourseName";
	private $db;
	private $users;
	private $dbTableDetails;

	public function __construct() 
	{
		$this->dbTable = 'user';
		$this->dbTableDetails = 'userdetails';
		$this->db = $this->connection();
		$this->users = new Users();
	}



	public function getAllUser() {
		try{
		$sql = "SELECT username FROM $this->dbTable";
		$query = $this->db->prepare($sql);
		$query->execute();
		$result = $query->fetchALL();

		if ($result) {

			return $result;
		}
		return null;
	}
	catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}


	public function getRole($userid) {
	try{
		$sql = "SELECT Role FROM $this->dbTable WHERE userid = ?";
		$query = $this->db->prepare($sql);
		$params = array($userid);
		$query->execute($params);
		$result = $query->fetch();

		return $result['Role'];
		
	}
	catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}


public function removeUser($id) {
 		try 	
 		{
			$sql = "DELETE FROM $this->dbTable WHERE " . self::$userId  ."= ?";
			$params = array($id);
			$query = $this->db->prepare($sql);
			$query->execute($params);

			return;
 		}
 		catch (Exception $e) 
 		{
 			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
 		}
 	}



	public function uppGradeUser($role,$userid) 	
	{
		try 
		{
			$sql = "UPDATE $this->dbTable SET Role = ? WHERE ".self::$userId."= ?";
			$params = array($role,$userid);
			$query = $this->db->prepare($sql);
			$query->execute($params);
		}
		catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}	
	}

	
	public function search($search) {
		try{
		$sql = "SELECT username FROM $this->dbTable WHERE username like ?";
		$params = array($search."%");
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$result = $query->fetchALL();
		if ($result) {

			return $result;
		}
		return null;
	}
	catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}


	public function searchCourse($search) {
		try{
		$sql = "SELECT CourseName FROM course WHERE CourseName like ?";
		$params = array($search."%");
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$result = $query->fetchALL();
		if ($result) {

			return $result;
		}
		return null;
	}

	catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}


	public function getCourseIdByName($course) {
		try{
		$sql = "SELECT CourseId FROM course WHERE " . self::$CourseName . "= ?";
		$params = array($course);
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$result = $query->fetchALL();
		if ($result) {
			# code...
			foreach ($result as $key) {
				# code...
				return $key['CourseId'];
			}
		}
		return null;
	}

	catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}

	public function getUserIdByName($user) {
		try{
		$sql = "SELECT userid FROM $this->dbTable WHERE " . self::$username . "= ?";
		$params = array($user);
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$result = $query->fetchALL();
		if ($result) {
			# code...
			foreach ($result as $key) {
				# code...
				return $key['userid'];
			}
		}
		return null;
	}

	catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}


	public function getUserIdByUserName($user) {
		try{
		$sql = "SELECT userid FROM $this->dbTable WHERE " . self::$username . "= ?";
		$params = array($user);
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$result = $query->fetch();

		return $result;
	}
	catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}

	public function editUserDetails(User $user, $userId) 
	{
		try{
		$sql = "UPDATE $this->dbTableDetails SET " . self::$firstName . "= ?, " . self::$lastName . "= ?, " . self::$sex . "= ?, " . self::$birthday . "= ?, " . self::$schoolForm . "= ?, " . self::$institute . "= ? WHERE " . self::$userId . "= ?";
		$params = array($user->getfName(), $user->getlName(), $user->getSex(), $user->getBirthday(), $user->getSchoolForm(), $user->getInstitute(), $userId);
		$query = $this->db->prepare($sql);
		$query->execute($params);
	}
	catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}

	public function GetUserProfileDetails($id) 
	{
		try{
		$sql = "SELECT * FROM $this->dbTableDetails WHERE " . self::$userId . "= ?";
		$params = array($id);
		$query = $this->db->prepare($sql);
		$query->execute($params);

		$result = $query->fetch();

		$email = $this->getEmailFromId($id);

		if ($result) {
			$user = new User(null, null, $email, $result[self::$firstName], $result[self::$lastName],  $result[self::$sex],  $result[self::$birthday], $result[self::$schoolForm], $result[self::$institute]);
			return $user;
		}
		
		return null;
	}
	catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}

	public function getEmailFromId($id) 
	{
		try{
		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$userId . "= ?";
		$params = array($id);
		$query = $this->db->prepare($sql);
		$query->execute($params);

		$result = $query->fetch();

		return $result['email'];
	}
	catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}

	public function getUsernameFromId($id) 
	{
		try{
		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$userId . "= ?";
		$params = array($id);
		$query = $this->db->prepare($sql);
		$query->execute($params);

		$result = $query->fetch();
		
		return $result['Username'];
	}
	catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}




	public function add(User $user) {
		try{
			$sql = "INSERT INTO $this->dbTable (". self::$username .", ". self::$hash .", ". self::$email .") VALUES (?,?,?)";
			$params = array($user->getUsername(), $user->getPassword(), $user->getEmail());
			$query = $this->db->prepare($sql);
			$query->execute($params);
			$id = $this->db->lastInsertId(); 
			
			return $id;
	}
	catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}

	public function addDetails(User $user, $id) {
		try{
			$sql = "INSERT INTO $this->dbTableDetails (". self::$userId .", ". self::$firstName .", ". self::$lastName .", ". self::$sex . ", ". self::$birthday .", ". self::$schoolForm .", ". self::$institute .") VALUES (?,?,?,?,?,?,?)";
			$params = array($id, $user->getfName(), $user->getlName(), $user->getSex(), $user->getBirthday(), $user->getSchoolForm(), $user->getInstitute());
			$query = $this->db->prepare($sql);
			$query->execute($params);
	}
	catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}
	
	
	public function exists($username) 
	{
		try{
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
	catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}


	public function existsEmail($email) 
	{
		try{
		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$email . "= ?";
		$params = array($email);
		$query = $this->db->prepare($sql);
		$query->execute($params);

		$results = $query->fetch();

		if ($results == false) 
		{
			return false;
		}

		return true;
	}
	catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}


	public function get($username) {
		try{
			$sql = "SELECT * FROM $this->dbTable WHERE (" . self::$username . ") = ?";
			$params = array($username);
			$query = $this->db->prepare($sql);
			$query->execute($params);
			$result = $query->fetch();
			return $result;
	}
	catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
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
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
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
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
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
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}



		public function getEmailForResetPassword($email) {
			try{
			$sql = "SELECT * FROM $this->dbTable WHERE " . self::$email . "= ?";
			$params = array($email);
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

		catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}



		public function getDateForResetPassword($code) {
			try{
			$sql = "SELECT * FROM $this->dbTable WHERE " . self::$code . "= ?";
			$params = array($code);
			$query = $this->db->prepare($sql);
			$query->execute($params);

			$results = $query->fetch();

			if ($results == true) 
			{
				while ($results) {
					# code...
					$date = $results['date'];
					return new UserDate($date);
				}
			}
			else
			{
				return NULL;
			}
			
		}
		catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}




	public function resetPassword($code, $email)
	{
		try 
		{
			$sql = "UPDATE $this->dbTable SET " . self::$code ."= ? WHERE " . self::$email ."= ?";
			$params = array($code, $email);
			$query = $this->db->prepare($sql);
			$query->execute($params);
		}

		catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}


	public function resetPasswordTime($date, $email)
	{
		try 
		{
			$sql = "UPDATE $this->dbTable SET " . self::$date ."= ? WHERE " . self::$email ."= ?";
			$params = array($date, $email);
			$query = $this->db->prepare($sql);
			$query->execute($params);
		}

		catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}



	public function getAllUserInfoForPassUpdate($code) {
		try{
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
	catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}


	public function searchAutoCompleteUserNames($keyword){
		try{
		$sql = "SELECT Username FROM user WHERE Username LIKE (:keyword) ORDER BY UserId ASC LIMIT 0, 7";
		$query = $this->db->prepare($sql);
		$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
		$query->execute();
		$list = $query->fetchAll();

		return $list;

	}
	catch (PDOException $e) 
		{
			header("Location: /". Settings::$ROOT_PATH . "/error.html");
			die('An unknown error has happened');
		}
	}
}