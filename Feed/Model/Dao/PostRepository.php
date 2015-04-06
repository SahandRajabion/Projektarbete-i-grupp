<?php
	
	require_once('Model/Dao/Repository.php');

 	class PostRepository extends Repository {


 		private static $postId  = "PostId";
 		private static $post = "Post";
 		private static $date = "Date";



 		public function __construct() {
 			$this->tabel = "posts";
 		}

 		

 		public function AddPost(Posts $post) {
 			try {	
 					$db = $this->connection();
 					$sql = "INSERT INTO $this->tabel (".self::$post. ")VALUES(?)";
 					$params = array($post->getPost());
 					$query = $db->prepare($sql);
 					$query->execute($params);
						
 			} catch (PDOException $ex) {

 				die('An unknown error hase happened');
 			}
 		}

		//Get all Posts.
		public function getPosts($post) {
			
			try {
				$db = $this->connection();
				$sql = "SELECT * FROM  $this->tabel WHERE Post = ?";
				$params = array($name);
				$query = $db->prepare($sql);
				$query->execute($params);
				$results = $query->fetchAll();
				if($results) {
					foreach($results as $result) {
						return new Posts($result[self::$imgName], $result[self::$Title]);
					}
				}
				return NULL;
			}
			catch (Exception $e) {
				die('An unknown error hase happened');
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