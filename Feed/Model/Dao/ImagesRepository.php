<?php
	
 	class ImagesRepository extends Repository  {
 		private static $imgName = "imgName";
 		private static $userId = 'userid';
 		private static $username = 'username';
 		public function __construct() {
 			$this->tabel = "img";
 		}
 		//Added image name and comment to db.
 		public function AddPics(Images $img) {
 			try {	
 					$db = $this->connection();
 					$sql = "INSERT INTO $this->tabel (".self::$imgName.")VALUES(?)";
 					$params = array($img->getImgName());
 					$query = $db->prepare($sql);
 					$query->execute($params);
						
 			} catch (PDOException $ex) {
 				die('An unknown error hase happened');
 			}
 		}

		public function getImagesInformation($imgname) {
			try {
				$f = new ImagesRepository();
				$db = $f->connection();
				$sql = "SELECT * FROM  $this->tabel WHERE imgName = ?";
				$params = array($imgname);
				$query = $db->prepare($sql);
				$query->execute($params);
				$results = $query->fetchAll();
				if($results) {
					foreach($results as $result) {
						return new Images($result[self::$imgName]);
					}
				}
				return NULL;
			}
			catch (Exception $e) {
				die('An unknown error hase happened');
			}
		}



		// save updating image .
 		public function updateImage(Images $img) {
			try {
				$db = $this->connection();
				$sql = "UPDATE $this->tabel SET " . self::$imgName . " = ? WHERE username = ? LIMIT 1";
				$params = array($img->getImgName(),$img->GetUsername());
				$query = $db->prepare($sql);
				$query->execute($params);
			}
			catch (Exception $e) {
				die('An unknown error hase happened');
			}
		}
 }