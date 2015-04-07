<?php
	
	require_once('Model/Dao/Repository.php');

 	class PostRepository extends Repository {
 		private static $postId  = "PostId";
 		private static $post = "Post";
 		private static $date = "Date";

 		public function __construct() {
 			$this->table = "posts";
 		}
 	
 		public function GetMorePostItems($last_id) {
		
		try 
		{
			$db = $this->connection();
			$sql = "SELECT * FROM $this->table WHERE " . self::$postId  ." > ? ORDER BY " . self::$postId . " ASC LIMIT 0, 9";
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

 		public function AddPost(Posts $post) {
 			try {	
 					$db = $this->connection();
 					$sql = "INSERT INTO $this->table (".self::$post. ")VALUES(?)";
 					$params = array($post->getPost());
 					$query = $db->prepare($sql);
 					$query->execute($params);
						
 			} catch (PDOException $ex) {

 				die('An unknown error hase happened');
 			}
 		}



		//Get all Posts.
		public function getPosts() {
			
		try { 

			$db = $this->connection();

			$sql = "SELECT * FROM $this->table ORDER BY (" .  self::$postId . ") ASC LIMIT 0, 8";
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




 	/*	// delete image name and title from db.
 		public function delete($img) {
 			try {
 					$db = $this->connection();
 					$sql = "DELETE FROM $this->tabel WHERE imgName = ?";
 					$params = array($img);
 					$query = $db->prepare($sql);
					$query->execute($params);
				
 			} catch (Exception $e) {
 				die('An unknown error hase happened');
				
 			}
 		}*/


 	/*	// save updating image title.
 		public function saveEdit(Images $img) {
			try {
				$db = $this->connection();
				$sql = "UPDATE $this->tabel SET " . self::$Title . " = ? WHERE imgName = ?";
				$params = array($img->GetTITLE(),$img->getImgName());
				$query = $db->prepare($sql);
				$query->execute($params);
			}
			catch (Exception $e) {
				die('An unknown error hase happened');
			}
		}
	*/
 }