<?php

require_once('Model/Dao/Repository.php');
require_once('Model/Comment.php');

class CommentRepository extends Repository {

	private static $comment = "body";
	private static $id = "id";
	private static $commentId = "CommentId";
	private static $userId = "UserId";

	public function __construct() 
	{
		$this->db = $this->connection();
		$this->dbTable = "comments";
	}

	public function GetUsersComments($id) 
	{
		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$userId . "= ?";
		$params = array($id);
		$query = $this->db->prepare($sql);
		$query->execute($params);

		$results = $query->fetchAll();

		return $results;
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

	public function InsertComment($comment, $id, $userId) 
	{
		try 
		{
	        $sql = "INSERT INTO $this->dbTable (" . self::$comment . ", " . self::$id . ", " . self::$userId . ") VALUES (?, ?, ?)";
			$params = array($comment, $id, $userId);
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

