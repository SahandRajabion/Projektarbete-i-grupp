<?php

require_once('Model/Dao/Repository.php');
require_once('Model/Comment.php');

class CommentRepository extends Repository {

	private static $id = "id";
	private static $comment = "body";

	public function __construct() 
	{
		$this->db = $this->connection();
		$this->dbTable = "comments";
	}

	public function InsertComment($comment) 
	{
		try 
		{
	        $sql = "INSERT INTO $this->dbTable (" . self::$comment . ") VALUES (?)";
			$params = array($comment);
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

