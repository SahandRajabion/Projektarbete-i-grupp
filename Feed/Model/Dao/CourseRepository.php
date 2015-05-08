<?php
	
require_once('Model/Dao/Repository.php');

 class CourseRepository extends Repository 
 {
	private $db;
	private $courseTable;
 	private static $programID = "ProgramId";
 	private static $courseID = "CourseId";
 	private static $courseName = "CourseName";
 	private static $courseCode = "CourseCode";
 	private static $rssUrl = "RssUrl";
 	private $key;

	public function __construct() {
		$this->dbTable = "programcourse";
		$this->courseTable = "course";

		$this->db = $this->connection();
	}

	public function doIdExist($id) 
	{
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

			foreach ($nrcourses as $key) {
				$this->key = $key;
			}
			
			$sql ="SELECT * FROM $this->courseTable WHERE " . self::$courseID . " = ?";
			$query = $this->db->prepare($sql);
			$params = array($this->key);

			$query->execute($params);

			$results = $query->fetchAll();
			if ($results) {
				# code...
				foreach ($results as $result) 
				{
					if ($result['CourseId'] == $this->key) {
						# code...
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

	public function getCourseName($id) 
	{
		$sql = "SELECT * FROM $this->courseTable  WHERE " . self::$courseID . " = ?";
		$params = array($id);
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$result = $query->fetch();

		return $result['CourseName'];
	}
	
	public function CourseNameExists($courseName) 
	{	
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
	
	public function CourseCodeExists($courseCode) 
	{
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
		$sql = "SELECT RssUrl FROM $this->courseTable  WHERE " . self::$courseID . "= ?";
		$params = array($courseId);
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$result = $query->fetch();

		return $result['RssUrl'];
	}


	public function getCourseID($courseName) 
	{
			
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

	public function checkIfRSSUrlExists($courseId) 
	{	
		$sql = "SELECT RssUrl FROM $this->courseTable WHERE " . self::$courseID . "= ?";
		$params = array($courseId);
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$results = $query->fetch();
		return $results['RssUrl'];
	}



 }