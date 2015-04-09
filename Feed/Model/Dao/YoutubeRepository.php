<?php
	
	require_once('Model/Dao/Repository.php');

 	class YoutubeRepository extends Repository {

 		private static $id  = "id";
 		private static $urlName = "name";
 		private static $urlCode = "code";

 		public function __construct() {
 			$this->table = "feed";
 		}
 

 		//Get all stored Videos.
		public function getVideos() {
			
		try { 
			$db = $this->connection();
			$sql = "SELECT * FROM $this->table ORDER BY (" .  self::$id . ") ASC LIMIT 0, 4";
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

 }