<?php
	
require_once('Model/Dao/Repository.php');

 class CourseRepository extends Repository 
 {
	private $db;
	private $courseTable;
	private $feedTable;
 	private static $programID = "ProgramId";
 	private static $courseID = "CourseId";
 	private static $courseName = "CourseName";
 	private static $courseCode = "CourseCode";
 	private static $rssUrl = "RssUrl";
 	private static $rssTitleLink = "RssLink";

 	private $key;

	public function __construct() {
		$this->dbTable = "programcourse";
		$this->courseTable = "course";
		$this->feedTable = "feed";


		$this->db = $this->connection();
	}

	public function doIdExist($id) 
	{

	try{
		$sql = "SELECT * FROM $this->courseTable WHERE " . self::$courseID . "= ?";
		$params = array($id);
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
			echo "PDOException : " . $e->getMessage();
		}
	}

	public function GetAllCourseNr($programId) 
	{
		$sql = "SELECT CourseId FROM $this->dbTable WHERE " . self::$programID . "= ?";
		$params = array($programId);
		$query = $this->db->prepare($sql);
		$query->execute($params);

		$results = $query->fetchAll();

		return $results;


	}


	public function getCourses($nrcourses) 
	{
		try{
			foreach ($nrcourses as $key) {
				$this->key = $key;
			}
			
			$sql ="SELECT * FROM $this->courseTable WHERE " . self::$courseID . " = ?";
			$query = $this->db->prepare($sql);
			$params = array($this->key);

			$query->execute($params);

			$results = $query->fetchAll();
			if ($results) {

				foreach ($results as $result) 
				{
					if ($result['CourseId'] == $this->key) {

						$courseName[] =  $result['CourseName'];
					}
				
				}
				return $courseName;

			}
			else 
			{
				return null;
			}
	}

		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}


	public function getCourseName($id) 
	{
		try{
		$sql = "SELECT * FROM $this->courseTable  WHERE " . self::$courseID . " = ?";
		$params = array($id);
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$result = $query->fetch();

		return $result['CourseName'];
	}

		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}
	
	public function CourseNameExists($courseName) 
	{	
		try{
		$sql = "SELECT * FROM $this->courseTable WHERE " . self::$courseName . " = ?";
		$params = array($courseName);
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
			echo "PDOException : " . $e->getMessage();
		}
	}	
	
	public function CourseCodeExists($courseCode) 
	{
		try{
		$sql = "SELECT * FROM $this->courseTable WHERE " . self::$courseCode . " = ?";
		$params = array($courseCode);
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
			echo "PDOException : " . $e->getMessage();
		}
	}

	public function AddCourse($courseName, $courseCode, $rssFeedUrl) {
		try 
		{	
			$sql = "INSERT INTO $this->courseTable (" . self::$courseName . ", " . self::$courseCode . ", " . self::$rssUrl . ") VALUES (?, ?, ?)";
			$params = array($courseName, $courseCode, $rssFeedUrl);
 			$query = $this->db->prepare($sql);
			$query->execute($params);

			$id = $this->db->lastInsertId();
			return $id;
		}

		catch (PDOException $ex) 
		{
			die('An unknown error has happened');
		}
	}

public function checkIfRSSLinkExists($link) 
	{
		try{
		$sql = "SELECT * FROM $this->feedTable WHERE " . self::$rssTitleLink . " = ?";
		$params = array($link);
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
			echo "PDOException : " . $e->getMessage();
		}
	}

	public function addRSSTitle($rssTitleLink) {
		try 
		{	
			$sql = "INSERT INTO $this->feedTable (" . self::$rssTitleLink . ") VALUES (?)";
			$params = array($rssTitleLink);
 			$query = $this->db->prepare($sql);
			$query->execute($params);

		}

		catch (PDOException $ex) 
		{
			die('An unknown error has happened');
		}
	}

	public function getRSSData($link) 
	{
		try{
		$sql = "SELECT id FROM $this->feedTable  WHERE " . self::$rssTitleLink . " = ?";
		$params = array($link);
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$result = $query->fetch();

		return $result;
	}

		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}

	public function AddCourseToProgram($programId, $courseId) {
		try 
		{	
			$sql = "INSERT INTO $this->dbTable (" . self::$programID . " , " . self::$courseID . ") VALUES (?, ?)";
			$params = array($programId, $courseId);
 			$query = $this->db->prepare($sql);
			$query->execute($params);
		}

		catch (PDOException $ex) 
		{
			die('An unknown error has happened');
		}
	}


	public function getRSSLink($courseId) 
	{
		try{
		$sql = "SELECT RssUrl FROM $this->courseTable  WHERE " . self::$courseID . "= ?";
		$params = array($courseId);
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$result = $query->fetch();

		return $result['RssUrl'];
	}
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}


	public function getCourseID($courseName) 
	{
			try{
			$sql ="SELECT * FROM $this->courseTable WHERE " . self::$courseName . " = ?";
			$query = $this->db->prepare($sql);
			$params = array($courseName);

			$query->execute($params);

			$results = $query->fetchAll();
			if ($results) {

				foreach ($results as $result) 
				{
					if ($result['CourseName'] == $courseName) {
						
						$courseid =  $result['CourseId'];
					}
				
				}
				return $courseid;

			}
			else {
				return null;
			}
	}
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}

	public function checkIfRSSUrlExists($courseId) 
	{	
		try{
		$sql = "SELECT RssUrl FROM $this->courseTable WHERE " . self::$courseID . "= ?";
		$params = array($courseId);
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$results = $query->fetch();
		return $results['RssUrl'];
	}

		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}


	public function searchAutoComplete($keyword)
	{
		try{
		$sql = "SELECT CourseName FROM course WHERE CourseName LIKE (:keyword) ORDER BY CourseId ASC LIMIT 0, 7";
		$query = $this->db->prepare($sql);
		$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
		$query->execute();
		$list = $query->fetchAll();

		return $list;

	}

		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}



 }