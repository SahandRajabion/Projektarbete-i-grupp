<?php
	
	class MessageModel {

		private $MsgId;
		private  $FromName;
		private  $Subject;
		private  $Date;
		private  $Time; 
		private  $Messages;
		private  $Open;
		private $userid;	

		public function __construct($MsgId,$FromName,$Subject,$Date,$Time,$Messages,$Open,$userid) {
			
			$this->MsgId = $MsgId;
			$this->FromName = $FromName;
			$this->Subject = $Subject;
			$this->Date = $Date;
			$this->Time = $Time;
			$this->Messages = $Messages;			
			$this->Open = $Open;
			$this->userid = $userid;
		} 

		public function getUserId() {
			return $this->userid;
		}

		public function getMsgId() {

			return $this->MsgId;
		}

		public function getFromName() {

			return $this->FromName;
		}


		public function getSubject() {
			return $this->Subject;
		}

		public function getDate() {
			return $this->Date;
		}

		public function getTime() {
			return $this->Time;
		}

		public function getMessages() {
			return $this->Messages;
		}

		public function getOpen() {
			return $this->Open;
		}

	
	}