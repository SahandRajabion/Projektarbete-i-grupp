<?php
	
	class MessagesSent {

		private  $Date;
		private  $Time; 
		private  $Messages;
		private  $userid;	
		private  $MsgId;
		private  $sub;

		public function __construct($MsgId,$Date,$Time,$Messages,$userid,$sub) {
			
			$this->Date = $Date;
			$this->Time = $Time;
			$this->Messages = $Messages;			
			$this->userid = $userid;
			$this->MsgId = $MsgId;
			$this->sub = $sub;
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

		public function getSubject() {
			return $this->sub;
		}

	
	}