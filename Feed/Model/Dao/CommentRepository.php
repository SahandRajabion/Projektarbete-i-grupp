<?php

require_once('Model/Dao/Repository.php');
require_once('Model/Comment.php');

class CommentRepository extends Repository {

	private static $id = "id";
	private static $comment = "body";
	private $comments;

	public function __construct() 
	{
		$this->db = $this->connection();
		$this->dbTable = "comments";
		$this->comments = array();
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

	public function GetComments() 
	{
		try 
		{
			$sql = "SELECT * FROM $this->dbTable ORDER BY " .  self::$id . " ASC";
			$query = $this->db->prepare($sql);
			$query->execute();
			$results = $query->fetchAll();

			foreach ($results as $result) 
			{
				$this->comments[] = new Comment($result);
			}

			return $this->comments;
		} 
		
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}	
}

