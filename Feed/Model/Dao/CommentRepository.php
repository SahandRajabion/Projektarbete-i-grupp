<?php

require_once('Model/Dao/Repository.php');
require_once('Model/Comment.php');

class CommentRepository extends Repository {

	private static $comment = "body";
	private static $postId = "PostId";

	public function __construct() 
	{
		$this->db = $this->connection();
		$this->dbTable = "comments";
	}

	public function InsertComment($comment, $postId) 
	{
		try 
		{
	        $sql = "INSERT INTO $this->dbTable (" . self::$comment . ", " . self::$postId . ") VALUES (?, ?)";
			$params = array($comment, $postId);
			$query = $this->db->prepare($sql);
			$query->execute($params);

			// Måste finnas för annars så kommer inte posten att visas efter lagts in
			return;
		} 
		
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}

	public function GetCommentsForPost($postId) 
	{
		$comments = array();

		try 
		{
			$sql = "SELECT * FROM $this->dbTable WHERE " .  self::$postId . " = ?";
			$params = array($postId);
			$query = $this->db->prepare($sql);
			$query->execute($params);
			$results = $query->fetchAll();

			foreach ($results as $result) 
			{
				$comments[] = new Comment($result);
			}

			return $comments;
		} 
		
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}	
}

