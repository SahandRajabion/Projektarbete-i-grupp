<?php
	
	class MsgModel {

	
		private  $Messages;
		private $Name;
		private $date;
		private $time;
		private $NewMsgId;

		public function __construct($Messages,$Name,$time,$date,$NewMsgId) {

			$this->Messages = $Messages;
			$this->Name = $Name;	
			$this->time = $time;
			$this->date = $date;	
			$this->NewMsgId = $NewMsgId;	
		} 

		public function getNewMsgId() {
			return $this->NewMsgId;
		}

		public function getMessages() {
			return $this->Messages;
		}

		public function getName() {
			return $this->Name;
		}

		public function getReplayDate() {
			return $this->date;
		}

		public function getReplayTime() {
			return $this->time;
		}
	
	}