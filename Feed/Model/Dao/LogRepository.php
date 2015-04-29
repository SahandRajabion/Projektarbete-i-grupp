<?php
require_once('Model/Dao/Repository.php');
class LogRepository extends Repository 
{

	private static $ipAddress = "IpAddress";
	private static $attemptTime = "AttemptTime";
	private static $result = "Result";
	private static $username = "Username";
	private $db;

	public function __construct() 
	{
		$this->db = $this->connection();
		
		$this->dbLogTable = "attempts";
	}

	public function checkAuthenticationAttempts($ip) 
	{
		$sql = "SELECT COUNT(*) FROM $this->dbLogTable  WHERE " . self::$ipAddress . " = ? AND " . self::$attemptTime . " > DATE_SUB(NOW(), INTERVAL 5 MINUTE) AND " . self::$result . " = false";
		$params = array($ip);
		$query = $this->db->prepare($sql);
		$query->execute($params);
		$result = $query->fetch();

		return $result[0];
	}

	public function logAuthenticationAttempt($ip, $username, $loginResult)
	{	
		$sql = "INSERT INTO $this->dbLogTable (" . self::$ipAddress . ", " . self::$result . ", " . self::$username . ") VALUES (?, ?, ?)";
		$params = array($ip, $loginResult, $username);
		$query = $this->db->prepare($sql);
		$query->execute($params);
	}
}