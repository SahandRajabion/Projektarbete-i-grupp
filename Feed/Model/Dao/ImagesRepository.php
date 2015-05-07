<?php
require_once("Model/Dao/Repository.php");
require_once("Model/StartProfileImg.php");

 class ImagesRepository extends Repository  {
 		private static $imgName = "imgName";
 		private static $userId = "UserId";
 		private static $username = 'username';
 		private $db;
 		private $tabel;
 		
 		public function __construct() {
 			$this->tabel = "user";
 			$this->db = $this->connection();
 		}

		public function getImagesInformation($userId) {
			 try 
			 {
				$sql = "SELECT * FROM  $this->tabel WHERE " . self::$userId . " = ?";
				$params = array($userId);
				$query = $this->db->prepare($sql);
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

				$sql = "SELECT * FROM  $this->tabel WHERE " . self::$username . " = ?";
				$params = array($username);
				$query = $this->db->prepare($sql);
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
				$sql = "SELECT * FROM  $this->tabel  WHERE " . self::$imgName . "= ?";
				$params = array($name);
				$query = $this->db->prepare($sql);
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
				$sql = "UPDATE $this->tabel SET " . self::$imgName . " = ? WHERE ".  self::$userId ."= ? LIMIT 1";
				$params = array($img->getImgName(),$img->getUserId());
				$query = $this->db->prepare($sql);
				$query->execute($params);
			}
			catch (Exception $e) {
				die('An unknown error hase happened');
			}
		}
 }