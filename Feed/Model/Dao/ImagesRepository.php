<?php
	
	require_once('Model/Dao/Repository.php');

 	class ImagesRepository extends Repository {


 		private static $imgId  = "imgId";
 		private static $imgName = "imgName";
 		private static $Title = "Title";



 		public function __construct() {
 			$this->tabel = "pictures";
 		}

 		//Added image name and title to db.
 		public function AddPics(Images $img) {
 			try {	
 					$db = $this->connection();
 					$sql = "INSERT INTO $this->tabel (".self::$imgName. ", " .self::$Title. ")VALUES(?,?)";
 					$params = array($img->getImgName(),$img->GetTITLE());
 					$query = $db->prepare($sql);
 					$query->execute($params);
						
 			} catch (PDOException $ex) {

 				die('An unknown error hase happened');
 			}
 		}


		//Get everything from tabel Image.
		public function getImagesInformation($name) {
			
			try {
				$f = new ImagesRepository();
				$db = $f->connection();
				$sql = "SELECT * FROM  $this->tabel WHERE imgName = ?";
				$params = array($name);
				$query = $db->prepare($sql);
				$query->execute($params);
				$results = $query->fetchAll();
				if($results) {
					foreach($results as $result) {
						return new Images($result[self::$imgName], $result[self::$Title]);
					}
				}
				return NULL;
			}
			catch (Exception $e) {
				die('An unknown error hase happened');
			}
		}




 		// delete image name and title from db.
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
 		}


 		// save updating image title.
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
	
 }