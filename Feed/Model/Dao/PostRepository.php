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
	private $db;
	
	public function __construct() {
		$this->table = "feed";
		$this->db = $this->connection();
	}


	public function getAllPostIds() 
	{		
		try 
		{ 
			$arrayOfIds = array();
			
			$sql = "SELECT id FROM $this->table ORDER BY (" .  self::$id . ") DESC";
			$query = $this->db->prepare($sql);
			$query->execute();
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
		$sql = "SELECT * FROM $this->table WHERE " . self::$userId . "= ?";
		$params = array($id);
		$query = $this->db->prepare($sql);
		$query->execute($params);

		$results = $query->fetchAll();

		return $results;
	}

 	public function GetLatestPostItems($first_id) {	
		try 
		{
			$sql = "SELECT * FROM $this->table WHERE " . self::$id  ." > ? ORDER BY " . self::$id . " DESC";
			$query = $this->db->prepare($sql);
			$params = array($first_id);
			$query->execute($params);
			$feedItems = $query->fetchAll();
 
			return $feedItems;
		}
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}

 	public function GetMorePostItems($last_id) {	
		try 
		{
			$sql = "SELECT * FROM $this->table WHERE " . self::$id  ." < ? ORDER BY " . self::$id . " DESC LIMIT 0, 4";
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

	public function AddPost(Post $post) 
	{
		try 
		{	
			$sql = "INSERT INTO $this->table (" . self::$post . ", " .  self::$userId . ") VALUES (?, ?)";
			$params = array($post->getPost(), $post->getUserId());
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

	public function getPost($id) 
	{		
		try 
		{ 
			$sql = "SELECT * FROM $this->table WHERE " . self::$id . " = ?";
			$params = array($id);
			$query = $this->db->prepare($sql);
			$query->execute($params);
			$feedItem = $query->fetch();
			return $feedItem;
		} 
		
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}

	public function getPosts() 
	{		
		try 
		{ 
			$sql = "SELECT * FROM $this->table ORDER BY (" .  self::$id . ") DESC LIMIT 0, 4";
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

 	public function AddVideo(Youtube $youtube) 
 	{
		try 
		{	
			$sql = "INSERT INTO $this->table (" . self::$urlCode . ", " .  self::$userId . ") VALUES(?, ?)";
			$params = array($youtube->getVideoURL(), $youtube->getUserId());
			$query = $this->db->prepare($sql);
			$query->execute($params);

			$id = $this->db->lastInsertId();
			return $id;
		} 
		catch (PDOException $ex) {
			die('An unknown error hase happened');
		}
 	}

	public function AddImage(Image $image) {
		try 
		{	
			$sql = "INSERT INTO $this->table (".self::$imgName. ", " .self::$Title. ", " .  self::$userId . ") VALUES (?, ?, ?)";
			$params = array($image->getImageName(), $image->GetTitle(), $image->getUserId());
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