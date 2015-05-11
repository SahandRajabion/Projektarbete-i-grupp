<?php
	require_once('Model/Dao/MessagesRepository.php');
 	
 	class Messages {
 		private $messagesRepository;
 		public function __construct() {
 			$this->messagesRepository = new MessagesRepository();
 		}
 	
 	
 		public function getMsgForUser($userId) {
			return $this->messagesRepository->GetMessagesForUser($userId);
		}


		public function getMessage($msgID) {
			return $this->messagesRepository->GetAspcMsg($msgID);
		}


		public function getMessageForInbox($msgID) {
			return $this->messagesRepository->GetAspcMsgForInbox($msgID);
		}


		public function deleteMessage($msgID) {
			return $this->messagesRepository->DeleteMsg($msgID);
		}

		public function DeleteSentMsg($msgID) {
			return $this->messagesRepository->DeleteSentMsg($msgID);
		}


		public function AddMessage($name, $sub, $date, $time,$MSG, $open,$id,$newMsgID) {
			return $this->messagesRepository->addMessage($name, $sub, $date, $time,$MSG, $open,$id,$newMsgID);
		}

		public function AddSentMessage($name, $sub, $date, $time,$MSG, $open,$id,$newMsgID) {
			return $this->messagesRepository->addSentMessage($name, $sub, $date, $time,$MSG, $open,$id,$newMsgID);
		}

		public function AddReplayMessage($id,$msg,$name,$time,$date,$newMsgID) {
			return $this->messagesRepository->addReplayMessage($id, $msg,$name,$time,$date,$newMsgID);
		}

		public function getReplayMessage($msgID) {
			return $this->messagesRepository->getReplayMessage($msgID);
		}


 	}