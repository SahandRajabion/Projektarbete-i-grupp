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
	private static $date = 'Date';
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

	public function search($search) {
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


	public function searchCourse($search) {
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


	public function getCourseIdByName($course) {
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
	public function getUserIdByName($user) {
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


	public function getUserIdByUserName($user) {
		$sql = "SELECT userid FROM $this->dbTable WHERE " . self::$username . "= ?";
		$params = array($user);
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$result = $query->fetch();

		return $result;
	}

	public function editUserDetails(User $user, $userId) 
	{
		$sql = "UPDATE $this->dbTableDetails SET " . self::$firstName . "= ?, " . self::$lastName . "= ?, " . self::$sex . "= ?, " . self::$birthday . "= ?, " . self::$schoolForm . "= ?, " . self::$institute . "= ? WHERE " . self::$userId . "= ?";
		$params = array($user->getfName(), $user->getlName(), $user->getSex(), $user->getBirthday(), $user->getSchoolForm(), $user->getInstitute(), $userId);
		$query = $this->db->prepare($sql);
		$query->execute($params);
	}

	public function GetUserProfileDetails($id) 
	{
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

	public function getEmailFromId($id) 
	{
		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$userId . "= ?";
		$params = array($id);
		$query = $this->db->prepare($sql);
		$query->execute($params);

		$result = $query->fetch();

		return $result['email'];
	}

	public function getUsernameFromId($id) 
	{

		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$userId . "= ?";
		$params = array($id);
		$query = $this->db->prepare($sql);
		$query->execute($params);

		$result = $query->fetch();
		
		return $result['Username'];
	}




	public function add(User $user) {
			$sql = "INSERT INTO $this->dbTable (". self::$username .", ". self::$hash .", ". self::$email .") VALUES (?,?,?)";
			$params = array($user->getUsername(), $user->getPassword(), $user->getEmail());
			$query = $this->db->prepare($sql);
			$query->execute($params);
			$id = $this->db->lastInsertId(); 
			
			return $id;
	}

	public function addDetails(User $user, $id) {
			$sql = "INSERT INTO $this->dbTableDetails (". self::$userId .", ". self::$firstName .", ". self::$lastName .", ". self::$sex . ", ". self::$birthday .", ". self::$schoolForm .", ". self::$institute .") VALUES (?,?,?,?,?,?,?)";
			$params = array($id, $user->getfName(), $user->getlName(), $user->getSex(), $user->getBirthday(), $user->getSchoolForm(), $user->getInstitute());
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


	public function existsEmail($email) 
	{
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



		public function getEmailForResetPassword($email) {
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



		public function getDateForResetPassword($code) {
			$sql = "SELECT * FROM $this->dbTable WHERE " . self::$code . "= ?";
			$params = array($code);
			$query = $this->db->prepare($sql);
			$query->execute($params);

			$results = $query->fetch();

			if ($results == true) 
			{
				while ($results) {
					# code...
					$date = $results['Date'];
					return new UserDate($date);
				}
			}
			else
			{
				return NULL;
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
			die('An unknown error has occured in database');
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