<?php
	
	require_once('Model/Dao/Repository.php');	

 	class PostRepository extends Repository {
 		private static $id  = "id";
 		private static $post = "Post";
 		private static $date = "Date";

 		public function __construct() {
 			$this->table = "feed";
 		}
 	
 		public function GetMorePostItems($last_id) {
		
		try 
		{
			$db = $this->connection();
			$sql = "SELECT * FROM $this->table WHERE " . self::$date  ." > ? ORDER BY " . self::$date . " DESC LIMIT 0, 4";
			$query = $db->prepare($sql);
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

	public function EditPost($feedId, $postContent, $postTitle) {
		try 
		{
			$db = $this->connection();
			$sql = "UPDATE feed SET Post = ?, Title = ? WHERE id = ?";
			$params = array($postContent, $postTitle, $feedId);
			$query = $db->prepare($sql);
			$query->execute($params);
		}
		catch (PDOException $e) 
		{
			die('An unknown error has occured in database');
		}
		
	}

	public function AddPost(Posts $post) 
	{
		try 
		{	
			$db = $this->connection();
			$sql = "INSERT INTO $this->table (".self::$post. ")VALUES(?)";
			$params = array($post->getPost());
			$query = $db->prepare($sql);
			$query->execute($params);	
		} 
		catch (PDOException $ex) 
		{
			die('An unknown error hase happened');
		}
	}

		//Get all Posts.
		public function getPosts() {
			
		try 
		{ 
			$db = $this->connection();
			$sql = "SELECT * FROM $this->table ORDER BY (" .  self::$date . ") DESC LIMIT 0, 4";
			$query = $db->prepare($sql);
			$query->execute();
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
			$db = $this->connection();
			$sql = "DELETE FROM $this->table WHERE " . self::$id  ."= ?";
			$params = array($id);
			$query = $db->prepare($sql);
			$query->execute($params);

			return;
 		}
 		catch (Exception $e) 
 		{
 			die('An unknown error has happened');
 		}
 	}
 }