<?php

require_once('Model/Dao/Repository.php');
require_once('Model/Comment.php');

class CommentRepository extends Repository {

	private static $comment = "body";
	private static $id = "id";
	private static $commentId = "CommentId";
	private static $userId = "UserId";
	private static $courseId ="CourseId";
	private $db;

	public function __construct() 
	{
		$this->db = $this->connection();
		$this->dbTable = "comments";
	}

 	public function GetLatestCommentItem($first_id, $course_id) {	
		try 
		{
			$sql = "SELECT * FROM $this->dbTable WHERE " . self::$commentId  ." > ? AND " . self::$courseId  ." = ? ORDER BY " . self::$commentId . " DESC";
			$query = $this->db->prepare($sql);
			$params = array($first_id, $course_id);
			$query->execute($params);
			$result = $query->fetch();

			if ($result == null) {
				return null;
			}

			$comment = new Comment($result, $result['UserId']);
 
			return $comment;
		}
		catch (Exception $e) {
				die('An unknown error hase happened');
			}
		}	

	public function GetUsersComments($id) 
	{
	 
	 try {
		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$userId . "= ?";
		$params = array($id);
		$query = $this->db->prepare($sql);
		$query->execute($params);

		$results = $query->fetchAll();

		return $results;
		}
		
		catch (Exception $e) {
				die('An unknown error hase happened');
			}
		}

	public function DeleteComment($commentId) 
	{
		try 
		{
			$sql = "DELETE FROM $this->dbTable WHERE " . self::$commentId . "= ?";
			$params = array($commentId);
			$query = $this->db->prepare($sql);
			$query->execute($params);

			return;
		}

		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();			
		}
	}

	public function InsertComment($comment, $id, $userId, $courseId) 
	{
		try 
		{
	        $sql = "INSERT INTO $this->dbTable (" . self::$comment . ", " . self::$id . ", " . self::$userId . ", " . self::$courseId  .") VALUES (?, ?, ?, ?)";
			$params = array($comment, $id, $userId, $courseId);
			$query = $this->db->prepare($sql);
			$query->execute($params);
			$commentId = $this->db->lastInsertId();

			return $commentId;
		} 
		
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}

	public function GetCommentsForPost($id) 
	{
		$comments = array();

		try 
		{
			$sql = "SELECT * FROM $this->dbTable WHERE " .  self::$id . " = ?";
			$params = array($id);
			$query = $this->db->prepare($sql);
			$query->execute($params);
			$results = $query->fetchAll();

			foreach ($results as $result) 
			{
				$comments[] = new Comment($result, $result['UserId']);
			}

			return $comments;
		} 
		
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}	
}

