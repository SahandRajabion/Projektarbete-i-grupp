<?php

include('Model/Dao/Repository.php');

class FeedRepository extends Repository {

	private static $id = "id";

	public function __construct() 
	{
		$this->db = $this->connection();
		$this->dbTable = "items";
	}

	public function GetFeedItems() 
	{
		try 
		{
			$sql = "SELECT * FROM $this->dbTable ORDER BY " .  self::$id . " ASC LIMIT 0, 8";
			$query = $this->db->prepare($sql);
			$query->execute();
			$feedItems = $query->fetchAll();

			return $feedItems;
		} 
		
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}
 
	public function GetMoreFeedItems($last_id) 
	{
		try 
		{
			$sql = "SELECT * FROM $this->dbTable WHERE " . self::$id  ." > ? ORDER BY " . self::$id . " ASC LIMIT 0, 9";
			$query = $this->db->prepare($sql);
			$params = array($last_id);
			$query->execute($params);
			$feedItems = $query->fetchAll();

			return $feedItems;
		}

		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}
}

