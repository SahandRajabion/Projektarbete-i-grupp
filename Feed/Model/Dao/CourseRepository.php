<?php
	
require_once('Model/Dao/Repository.php');

 class CourseRepository extends Repository 
 {
	private $db;
	private $courseTable;
	
	public function __construct() {
		$this->dbTable = "programcourse";
		$this->courseTable = "course";

		$this->db = $this->connection();
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

	public function AddCourse($courseName, $courseCode) {
		try 
		{	
			$sql = "INSERT INTO $this->courseTable (CourseName, CourseCode) VALUES (?, ?)";
			$params = array($courseName, $courseCode);
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
 }