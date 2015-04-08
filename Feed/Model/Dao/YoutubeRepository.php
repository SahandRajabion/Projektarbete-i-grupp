<?php
	
	require_once('Model/Dao/Repository.php');

 	class YoutubeRepository extends Repository {

 		private static $urlId  = "id";
 		private static $urlName = "name";
 		private static $urlCode = "code";

 		public function __construct() {
 			$this->table = "videos";
 		}
 	
 		


 		//Get all stored Videos.
		public function getVideos() {
			
		try { 

			$db = $this->connection();

			$sql = "SELECT * FROM $this->table ORDER BY (" .  self::$urlId . ") ASC LIMIT 0, 4";
			$query = $db->prepare($sql);
			$query->execute();
			$videoItems = $query->fetchAll();

			return $videoItems;
		} 
		
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}





 		public function AddVideo(Youtube $video) {
 			try {	
 					$db = $this->connection();
 					$sql = "INSERT INTO $this->table (".self::$urlName. "," .self::$urlCode. ")VALUES(?,?)";
 					$params = array($video->getvideoTitle(), $video->getvideoURL());
 					$query = $db->prepare($sql);
 					$query->execute($params);
						
 			} catch (PDOException $ex) {

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