<?php
require_once("Model/Dao/Repository.php");
require_once("Model/StartProfileImg.php");
 	class ImagesRepository extends Repository  {
 		private static $imgName = "imgName";
 		private static $userId = "UserId";
 		private static $username = 'username';
 		public function __construct() {
 			$this->tabel = "user";
 		}

		public function getImagesInformation($userId) {
			 try {
				$f = new ImagesRepository();
				$db = $f->connection();
				$sql = "SELECT * FROM  $this->tabel WHERE UserId = ?";
				$params = array($userId);
				$query = $db->prepare($sql);
				$query->execute($params);
				$results = $query->fetchAll();
				if($results) {
					foreach($results as $result) {
						return new ProfilePic($result[self::$imgName],$result[self::$userId]);
					}
				}
				return NULL;
			}
			catch (Exception $e) {
				die('An unknown error hase happened');
			}
		}
		

		public function getImagesName($username) {
			 try {
				$f = new ImagesRepository();
				$db = $f->connection();
				$sql = "SELECT * FROM  $this->tabel WHERE username = ?";
				$params = array($username);
				$query = $db->prepare($sql);
				$query->execute($params);
				$results = $query->fetchAll();
				if($results) {
					foreach($results as $result) {
						return new StartProfileImg($result[self::$imgName],$result[self::$userId]);
					}
				}
				return NULL;
			}
			catch (Exception $e) {
				die('An unknown error hase happened');
			}
		}


		public function getImagesToRemove($name) {
			 try {
				$f = new ImagesRepository();
				$db = $f->connection();
				$sql = "SELECT * FROM  $this->tabel  WHERE " . self::$imgName . "= ?";
				$params = array($name);
				$query = $db->prepare($sql);
				$query->execute($params);
				$result = $query->fetch();
				if($result == false) {
					if ($name != $result) {

						unlink("imgs/".basename($name));
					}
				}
			}
			catch (Exception $e) {
				die('An unknown error hase happened');
			}
		}



		// save updating image .
 		public function updateImage(ProfilePic $img) {
			try {
				$db = $this->connection();
				$sql = "UPDATE $this->tabel SET " . self::$imgName . " = ? WHERE ".  self::$userId ."= ? LIMIT 1";
				$params = array($img->getImgName(),$img->getUserId());
				$query = $db->prepare($sql);
				$query->execute($params);
			}
			catch (Exception $e) {
				die('An unknown error hase happened');
			}
		}
 }