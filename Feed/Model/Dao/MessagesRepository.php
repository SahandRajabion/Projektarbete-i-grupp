<?php
	
require_once('Model/Dao/Repository.php');
require_once('Model/MessageModel.php');
require_once('Model/MsgModel.php');
require_once('Model/MessagesSent.php');

 class MessagesRepository extends Repository 
 {
	private static $MsgId  = "MsgId";
	private static $FromName = "FromName";
	private static $UserId = "UserId";
	private static $Subject = "Subject";
	private static $Date = "Date";
	private static $Time = "Time"; 
	private static $Messages = "Messages";
	private static $Open = "Open";
	private static $MSGID = "MSGID";
	private static $MESSAGE ="MESSAGE";
	private static $Name ="Name";
	private static $TIME ="TIME";
	private static $DATE ="DATE";
	private static $SPCMSGID = "SPCMSGID";
	private static $NEWMSGID = "NEWMSGID";
	private static $userId = "UserId";
	private $db;
	private $table;
	private $limit;
	
	public function __construct() {
		$this->table = "messages";
		$this->db = $this->connection();
		$this->limit = 8;
	}

	public function GetMoreMessages($last_id, $user_id) 
	{
		try 
		{
			$array = array();
			$sql = "SELECT * FROM $this->table WHERE " . self::$MsgId  ." < ? AND " .  self::$UserId . " = ? ORDER BY " . self::$MsgId . " DESC LIMIT 0, 4";
			$query = $this->db->prepare($sql);
			$params = array($last_id, $user_id);
			$query->execute($params);
			$messages = $query->fetchAll();

 			  foreach($messages as $result) {

					$array[] = new MessageModel($result[self::$MsgId],$result[self::$FromName],$result[self::$Subject],$result[self::$Date],$result[self::$Time],$result[self::$Messages],$result[self::$Open],$result[self::$UserId]);
			  }

			return $array;
		}
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}



 	public function GetMessagesForUser($userId) {	

		try 
		{
			$array = array();
			$sql = "SELECT * FROM $this->table  WHERE ".self::$UserId."= ? ORDER BY " . self::$MsgId . " DESC LIMIT 0,5";
			$query = $this->db->prepare($sql);
			$params = array($userId);
			$query->execute($params);
			$results = $query->fetchAll();
 			if ($results) {
 				# code...
 			  foreach($results as $result) {

					$array[] = new MessageModel($result[self::$MsgId],$result[self::$FromName],$result[self::$Subject],$result[self::$Date],$result[self::$Time],$result[self::$Messages],$result[self::$Open],$result[self::$UserId]);
			  }

			  return $array;
 			}
			return NULL;
		}
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}



	public function getMsgByUserName($username) {

		try 
		{
			$array = array();
			$sql = "SELECT * FROM sentmsg WHERE ".self::$FromName."= ? ORDER BY " . self::$MsgId . " DESC LIMIT 0,9";
			$query = $this->db->prepare($sql);
			$params = array($username);
			$query->execute($params);
			$results = $query->fetchAll();
 			if ($results) {
 				# code...
 			  foreach($results as $result) {

					$array[] = new MessagesSent($result[self::$MsgId],$result[self::$Date],$result[self::$Time],$result[self::$Messages],$result[self::$UserId],$result[self::$Subject]);
			  }

			  return $array;
 			}
			return NULL;
		}
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}


	public function getUsernameFromId($id) 
	{

		$sql = "SELECT * FROM user WHERE " . self::$userId . "= ?";
		$params = array($id);
		$query = $this->db->prepare($sql);
		$query->execute($params);

		$result = $query->fetch();
		
		return $result['Username'];
	}

	public function GetMoreSentMessages($last_id, $user_id) 
	{
		$user_name = $this->getUsernameFromId($user_id);
		try 
		{
			$array = array();
			$sql = "SELECT * FROM sentmsg WHERE " . self::$MsgId  ." < ? AND " .  self::$FromName . " = ? ORDER BY " . self::$MsgId . " DESC LIMIT 0, 4";
			$query = $this->db->prepare($sql);
			$params = array($last_id, $user_name);
			$query->execute($params);
			$messages = $query->fetchAll();

 			  foreach($messages as $result) {

					$array[] = new MessagesSent($result[self::$MsgId],$result[self::$Date],$result[self::$Time],$result[self::$Messages],$result[self::$UserId],$result[self::$Subject]);
			  }

			return $array;
		}
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}

	public function IfOpenTheMsg($open,$msgId) 
	{
		try 
		{
			$sql = "UPDATE $this->table SET Open = ? WHERE ".self::$MsgId."= ?";
			$params = array($open,$msgId);
			$query = $this->db->prepare($sql);
			$query->execute($params);
		}
		catch (PDOException $e) 
		{
			die('An unknown error has occured in database');
		}	
	}



	public function GetAspcMsg($msgid) {	
		try 
		{
			$sql = "SELECT * FROM sentmsg WHERE ".self::$MsgId."= ?";
			$query = $this->db->prepare($sql);
			$params = array($msgid);
			$query->execute($params);
			$result = $query->fetch();
 			if ($result) {
 			
					 return new MessageModel($result[self::$MsgId],$result[self::$FromName],$result[self::$Subject],$result[self::$Date],$result[self::$Time],$result[self::$Messages],$result[self::$Open],$result[self::$UserId]);			
			  
 			}
			return NULL;
		}
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}


	public function GetAspcMsgForInbox($msgid) {	
		try 
		{
			$sql = "SELECT * FROM $this->table WHERE ".self::$MsgId."= ?";
			$query = $this->db->prepare($sql);
			$params = array($msgid);
			$query->execute($params);
			$result = $query->fetch();
 			if ($result) {
 			
					 return new MessageModel($result[self::$MsgId],$result[self::$FromName],$result[self::$Subject],$result[self::$Date],$result[self::$Time],$result[self::$Messages],$result[self::$Open],$result[self::$UserId]);			
			  
 			}
			return NULL;
		}
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}

	public function getReplayMessage($id) {	

		try 
		{
			$array = array();
			$sql = "SELECT * FROM spcmsg  WHERE ".self::$MSGID."= ? ORDER BY " . self::$SPCMSGID . " ASC";
			$query = $this->db->prepare($sql);
			$params = array($id);
			$query->execute($params);
			$results = $query->fetchAll();
 			if ($results) {
 				# code...
 			  foreach($results as $result) {

					$array[] = new MsgModel($result[self::$MESSAGE],$result[self::$Name],$result[self::$TIME],$result[self::$DATE],$result[self::$NEWMSGID]);
			  }
			  return $array;
 			}
			return NULL;
		}
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}



	public function getMsgIdFromUserId($id) {

		try 
		{
			$array = array();
			$sql = "SELECT * FROM $this->table  WHERE ".self::$UserId."= ?";
			$query = $this->db->prepare($sql);
			$params = array($id);
			$query->execute($params);
			$results = $query->fetchAll(); 
 			if ($results) {
 				# code...
 			  foreach($results as $result) {

					$array[] = $result[self::$MsgId];
			  }
		
			  return $array;
 			}
			return NULL;
		}
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}


	public function getMsgIdFromUserName($name) {

		try 
		{
			$array = array();
			$sql = "SELECT * FROM sentmsg  WHERE ".self::$FromName."= ?";
			$query = $this->db->prepare($sql);
			$params = array($name);
			$query->execute($params);
			$results = $query->fetchAll(); 
 			if ($results) {
 				# code...
 			  foreach($results as $result) {

					$array[] = $result[self::$MsgId];
			  }
		
			  return $array;
 			}
			return NULL;
		}
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}

	public function DeleteMsg($msgid) {
 		try 	
 		{
			$sql = "DELETE FROM $this->table WHERE " . self::$MsgId  ."= ?";
			$params = array($msgid);
			$query = $this->db->prepare($sql);
			$query->execute($params);

			return;
 		}
 		catch (Exception $e) 
 		{
 			die('An unknown error has happened');
 		}
 	}


 	public function DeleteSentMsg($msgid) {
 		try 	
 		{
			$sql = "DELETE FROM sentmsg WHERE " . self::$MsgId  ."= ?";
			$params = array($msgid);
			$query = $this->db->prepare($sql);
			$query->execute($params);

			return;
 		}
 		catch (Exception $e) 
 		{
 			die('An unknown error has happened');
 		}
 	}

 	public function addMessage($name, $sub, $date, $time,$MSG, $open,$id,$newMsgId) {
 		try 	
 		{
			$sql = "INSERT INTO $this->table (" . self::$FromName . ","  . self::$Subject . ", "  . self::$Date . " ," . self::$Time . ", " . self::$Messages .  ", " . self::$Open .", " .  self::$UserId .", " .  self::$NEWMSGID .") VALUES (?, ?, ?, ?, ?, ?, ?,?)";
			$params = array($name, $sub, $date, $time,$MSG, $open,$id,$newMsgId);
			$query = $this->db->prepare($sql);
			$query->execute($params);
 		}
 		catch (Exception $e) 
 		{
 			die('An unknown error has happened');
 		}
 	}

 	public function addSentMessage($name, $sub, $date, $time,$MSG, $open,$id,$newMsgId) {
 		try 	
 		{
			$sql = "INSERT INTO sentmsg (" . self::$FromName . ","  . self::$Subject . ", "  . self::$Date . " ," . self::$Time . ", " . self::$Messages .  ", " . self::$Open .", " .  self::$UserId .", " .  self::$NEWMSGID .") VALUES (?, ?, ?, ?, ?, ?, ?,?)";
			$params = array($name, $sub, $date, $time,$MSG, $open,$id,$newMsgId);
			$query = $this->db->prepare($sql);
			$query->execute($params);
 		}
 		catch (Exception $e) 
 		{
 			die('An unknown error has happened');
 		}
 	}
 	 public function addReplayMessage($msgID,$msg,$name,$time,$date,$newMsgId) {
 		try 	
 		{
			$sql = "INSERT INTO spcmsg (" . self::$MSGID . ","  . self::$MESSAGE . ","  . self::$Name .  ","  . self::$TIME .  ","  . self::$DATE .","  . self::$NEWMSGID .") VALUES (?, ?,?,?,?,?)";
			$params = array($msgID, $msg,$name,$time,$date,$newMsgId);
			$query = $this->db->prepare($sql);
			$query->execute($params);
 		}
 		 catch (Exception $e) 
 		 {
 		 	die('An unknown error has happened');
 		 }
 	}

 	public function getIfOpenOrNot($userId) {

 		try 
		{
			$array = array();
			$sql = "SELECT * FROM $this->table WHERE ".self::$UserId."= ?";
			$query = $this->db->prepare($sql);
			$params = array($userId);
			$query->execute($params);
			$results = $query->fetchAll();
 			if ($results) {
 				$counter = 0;
 				# code...
 			  foreach($results as $result) {
 					
 					if ($result[self::$Open] == 0) {

						$counter++;
					}
					
			  }

			 
					return $counter;

 			}
 			return NULL;
			
		}
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
 	}

	public function GetNrOfMsg() {	
		try 
		{
			$sql = "SELECT * FROM $this->table";
			$query = $this->db->prepare($sql);
			$query->execute();
			$results = $query->fetchAll();
 			
 			return $results;
		}
		catch (PDOException $e) 
		{
			echo "PDOException : " . $e->getMessage();
		}
	}

 }