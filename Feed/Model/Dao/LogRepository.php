<?php

class LogRepository extends Repository 
{

	private static $ipAddress = "IpAddress";
	private static $attemptTime = "AttemptTime";
	private static $result = "Result";
	private static $username = "Username";
	private $db;
	private $dbLogTable;

	public function __construct() 
	{
		$this->db = $this->connection();
		
		$this->dbLogTable = "attempts";
	}

	public function checkAuthenticationAttempts($ip) 
	{	
		try{
		$sql = "SELECT COUNT(*) FROM $this->dbLogTable  WHERE " . self::$ipAddress . " = ? AND " . self::$attemptTime . " > DATE_SUB(NOW(), INTERVAL 5 MINUTE) AND " . self::$result . " = false";
		$params = array($ip);
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$result = $query->fetch();

		return $result[0];
	}
	catch (Exception $e) {
				die('An unknown error hase happened');
			}
		}

	public function logAuthenticationAttempt($ip, $username, $loginResult)
	{	
		try{
		$sql = "INSERT INTO $this->dbLogTable (" . self::$ipAddress . ", " . self::$result . ", " . self::$username . ") VALUES (?, ?, ?)";
		$params = array($ip, $loginResult, $username);
		$query = $this->db->prepare($sql);
		$query->execute($params);
	}

	catch (Exception $e) {
				die('An unknown error hase happened');
			}
		}
}