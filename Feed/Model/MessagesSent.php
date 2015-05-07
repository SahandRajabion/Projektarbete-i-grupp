<?php
	
	class MessagesSent {

		private  $Date;
		private  $Time; 
		private  $Messages;
		private $userid;	
		private $MsgId;

		public function __construct($MsgId,$Date,$Time,$Messages,$userid) {
			
			$this->Date = $Date;
			$this->Time = $Time;
			$this->Messages = $Messages;			
			$this->userid = $userid;
			$this->MsgId = $MsgId;
		} 

		public function getUserId() {
			return $this->userid;
		}

		public function getMsgId() {

			return $this->MsgId;
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

	
	}