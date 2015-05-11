<?php
	
require_once('Model/Dao/Repository.php');
require_once('Model/Image.php');

 class PostRepository extends Repository 
 {
	private static $id  = "id";
	private static $post = "Post";
	private static $date = "Date";
	private static $userId = "UserId";
	private static $urlCode = "code";
	private static $imgName = "imgName"; 
	private static $Title = "Title";
	private static $courseId ="CourseId";
	private $db;
	private $table;
	
	public function __construct() {
		$this->table = "feed";
		$this->db = $this->connection();
	}


	public function getAllPostIds($course_id) 
	{		
		try 
		{ 
			$arrayOfIds = array();
			
			$sql = "SELECT id FROM $this->table WHERE " .  self::$courseId . " = ? ORDER BY (" .  self::$id . ") DESC";
			$query = $this->db->prepare($sql);
			$params = array($course_id);
			$query->execute($params);
			$postIds = $query->fetchAll();

			foreach ($postIds as $id) 
			{
				$arrayOfIds[] = $id['id'];
			}
			return $arrayOfIds;
		} 
		
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}	

	public function GetUsersPosts($id) 
	{
		try{
		$sql = "SELECT * FROM $this->table WHERE " . self::$userId . "= ?";
		$params = array($id);
		$query = $this->db->prepare($sql);
		$query->execute($params);

		$results = $query->fetchAll();

		return $results;
	}

	catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}

 	public function GetLatestPostItems($first_id, $course_id) {	
		try 
		{
			$sql = "SELECT * FROM $this->table WHERE " . self::$id  ." > ? AND CourseId = ? ORDER BY " . self::$id . " DESC";
			$query = $this->db->prepare($sql);
			$params = array($first_id, $course_id);
			$query->execute($params);
			$feedItems = $query->fetchAll();
 
			return $feedItems;
		}
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}

 	public function GetMorePostItems($last_id, $course_id) {	
		try 
		{
			$sql = "SELECT * FROM $this->table WHERE " . self::$id  ." < ? AND " .  self::$courseId . " = ? ORDER BY " . self::$id . " DESC LIMIT 0, 4";
			$query = $this->db->prepare($sql);
			$params = array($last_id, $course_id);
			$query->execute($params);
			$feedItems = $query->fetchAll();
 
			return $feedItems;
		}
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}

	public function EditPost($feedId, $postContent, $postTitle) 
	{
		try 
		{
			$sql = "UPDATE feed SET Post = ?, Title = ? WHERE id = ?";
			$params = array($postContent, $postTitle, $feedId);
			$query = $this->db->prepare($sql);
			$query->execute($params);
		}
		catch (PDOException $e) 
		{
			die('An unknown error has occured in database');
		}	
	}

	public function AddPost( $courseId,PostItems $post) 
	{

			$sql = "INSERT INTO $this->table (" . self::$post . ", " .  self::$userId . ", " .  self::$courseId . ") VALUES (?, ?, ?)";
				$params = array($post->getPost(),$post->getUserId(),$courseId);

			$query = $this->db->prepare($sql);
			$query->execute($params);

	
	
	}

	public function getPosts($courseId) 
	{		
		try 
		{ 
			$sql = "SELECT * FROM $this->table WHERE CourseId = ? ORDER BY (" .  self::$id . ") DESC LIMIT 0, 4";
			$query = $this->db->prepare($sql);
			$params = array($courseId);
			$query->execute($params);
			$feedItems = $query->fetchAll();
			return $feedItems;
		} 
		
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}

 	public function DeletePost($id) {
 		try 	
 		{
			$sql = "DELETE FROM $this->table WHERE " . self::$id  ."= ?";
			$params = array($id);
			$query = $this->db->prepare($sql);
			$query->execute($params);

			return;
 		}
 		catch (Exception $e) 
 		{
 			die('An unknown error has happened');
 		}
 	}

 	public function AddVideo(Youtube $youtube, $courseId) 
 	{
		try 
		{	
			$sql = "INSERT INTO $this->table (" . self::$urlCode . ", " .  self::$userId . ", " .  self::$courseId . ") VALUES(?, ?, ?)";
			$params = array($youtube->getVideoURL(), $youtube->getUserId(), $courseId);
			$query = $this->db->prepare($sql);
			$query->execute($params);

			$id = $this->db->lastInsertId();
			return $id;
		} 
		catch (PDOException $ex) {
			die('An unknown error hase happened');
		}
 	}

	public function AddImage(Image $image, $courseId) {
		try 
		{	
			$sql = "INSERT INTO $this->table (".self::$imgName. ", " .self::$Title. ", " .  self::$userId . ", " .  self::$courseId . ") VALUES (?, ?, ?, ?)";
			$params = array($image->getImageName(), $image->GetTitle(), $image->getUserId(), $courseId);
 			$query = $this->db->prepare($sql);
			$query->execute($params);

			$id = $this->db->lastInsertId();
			return $id;
		}
		catch (PDOException $ex) 
		{
			die('An unknown error hase happened');
		}
	}
 }

 