<?php
	
require_once('Model/Dao/Repository.php');

 class CourseRepository extends Repository 
 {
	private $db;
	private $courseTable;
 	private static $programID = "ProgramId";
 	private static $courseID = "CourseId";
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
			
			$sql ="SELECT * FROM $this->courseTable WHERE CourseId = ?";
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
		$sql = "SELECT * FROM $this->courseTable  WHERE CourseId = ?";
		$params = array($id);
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$result = $query->fetch();

		return $result['CourseName'];
	}
	
	public function CourseNameExists($courseName) 
	{	
		$sql = "SELECT * FROM $this->courseTable WHERE CourseName = ?";
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
		$sql = "SELECT * FROM $this->courseTable WHERE CourseCode = ?";
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
			$sql = "INSERT INTO $this->courseTable (CourseName, CourseCode, RssUrl) VALUES (?, ?, ?)";
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
			$sql = "INSERT INTO $this->dbTable (ProgramId , CourseId) VALUES (?, ?)";
			$params = array($programId, $courseId);
 			$query = $this->db->prepare($sql);
			$query->execute($params);
		}

		catch (PDOException $ex) 
		{
			die('An unknown error has happened');
		}
	}


	public function getCourseID($courseName) 
	{

		
			
			$sql ="SELECT * FROM $this->courseTable WHERE CourseName = ?";
			$query = $this->db->prepare($sql);
			$params = array($courseName);

			$query->execute($params);

			$results = $query->fetchAll();
			if ($results) {
				# code...
				foreach ($results as $result) 
				{
					if ($result['CourseName'] == $courseName) {
						# code...
						$courseid =  $result['CourseId'];
					}
				
				}
				return $courseid;

			}
			else {
				return null;
			}
			

	}



 }