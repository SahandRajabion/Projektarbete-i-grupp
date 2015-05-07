<?php 

	require_once('View/HTMLView.php');
	require_once('Model/Messages.php');
	require_once('View/BaseView.php');
	require_once('Model/LoginModel.php');
	require_once('helper/time.php');
	require_once('Model/Dao/MessagesRepository.php');
	require_once('Model/Dao/UserRepository.php');

	/**
	* inbox
	*/
	class InboxView extends BaseView
	{
		  private $mainView;
		  private $messages;
		  private $loginModel;
		  private $messagesRepository;
		
		public function __construct()
		{
			# code...
			$this->mainView = new HTMLView();
		    $this->messages = new Messages();
		    $this->loginModel = new LoginModel();
		    $this->messagesRepository = new MessagesRepository();
		    $this->userRepository = new UserRepository();
		}


		public function InboxHTML() {
			$inboxes = $this->messages->getMsgForUser($this->loginModel->getId());
			//$total = $this->messagesRepository->GetNrOfMsg();

			
			$html = '</br>'.
					'<script type="text/javascript" src="js/jquery.js"></script>'.
					'<link rel="stylesheet" href="css/bootstrap.min.css">'.
					'<script type="text/javascript" src="js/inboxJS.js"></script>'.
					'<link rel="stylesheet" href="css/styles.css">'.
					'<a href=?>Back</a>'.
					'</br>'.
					'</br>';

			$html .= 
					'<div id="msg">'.
					'<table>'.
					'<tr>'.
					'<td>From</td>'.
					'<td>Subject</td>'.
					'<td>Date</td>'.
					'<td>Time</td>'.
					'<td>Seen</td>'.
					'</tr>'.
					'</table>';		
					if ($inboxes != null) {
						# code...

						foreach ($inboxes as $inbox) {
						
							# code...
							if ($inbox->getOpen() == 0) {
							# code...
							$open = '<img src="img/not_open.png" alt="NotOpened" title="NotOpened" />';
							}
							else {
								$open ='<img src="img/open.png" alt="Opened" title="Opened" />';
							}
						
						    $html .= 
								'<div id="msg">'.
								'<table>'.
								'<td><strong>'.$inbox->getFromName().'</strong></td>'.
								'<td><strong>'.$inbox->getSubject().'</strong></td>'.
								'<td><strong>'.$inbox->getDate().'</strong></td>'.
								'<td><strong>'.time_passed($inbox->getTime()).'</strong></td>'.
								'<td><strong><a href="?'.$this->msgLocation.'&'.$this->id.'='.$inbox->getMsgId().'">'.$open.'</a></strong></td>'.
								'</table>'.
								'</div>';

						}
					}
					else
					{
						$html .= '<div id="msg">'.
								 '<h3>There is no message right now!</h3>'.
								 '</div">';

					}
			
					

			return $html;
		}



		public function SendHTML() {
			//$total = $this->messagesRepository->GetNrOfMsg();

			$UserName = $this->userRepository->getUsernameFromId($this->loginModel->getId());
						
			$sendMsgs  =  $this->messagesRepository->getMsgByUserName($UserName);

			
			$html = '</br>'.
				'<script type="text/javascript" src="js/jquery.js"></script>'.
				'<link rel="stylesheet" href="css/bootstrap.min.css">'.
					'<script type="text/javascript" src="js/inboxJS.js"></script>'.
					'<link rel="stylesheet" href="css/styles.css">'.
					'<a href=?>Back</a>'.
					'</br>'.
					'</br>';

			$html .= 
					'<div id="msg">'.
					'<table>'.
					'<tr>'.
					'<td>To</td>'.
					'<td>Date</td>'.
					'<td>Time</td>'.
					'<td>Message</td>'.
					'</tr>'.
					'</table>';		
					if ($sendMsgs != null) {
						# code...

						foreach ($sendMsgs as $sendMsg) {	

						$ToUserName = $this->userRepository->getUsernameFromId($sendMsg->getUserId());

						    $html .= 
								'<div id="msg">'.
								'<table>'.
								'<td><strong>'.$ToUserName.'</strong></td>'.
								'<td><strong>'.$sendMsg->getDate().'</strong></td>'.
								'<td><strong>'.time_passed($sendMsg->getTime()).'</strong></td>'.
								'<td><strong><a href="?'.$this->sentMsgLocation.'&'.$this->id.'='.$sendMsg->getMsgId().'">Message</a></strong></td>'.
								'</table>'.
								'</div>';

						}
					}
					else
					{
						$html .= '<div id="msg">'.
								 '<h3>You do not have any send messages right now!</h3>'.
								 '</div">';

					}
			
					

			return $html;
		}

		public function showMsg() {

			$msg = $this->messages->getMessage($this->getId());
			$FromUser = $this->loginModel->getUsername();
			$replayMsgs = $this->messages->getReplayMessage($this->getId());
			$toUser = $this->userRepository->getUserIdByUserName($msg->getFromName());

			$html = 
					'</br>'.
						'<script type="text/javascript" src="js/jquery.js"></script>'.
						'<link rel="stylesheet" href="css/bootstrap.min.css">'.
					'<script type="text/javascript" src="js/inboxJS.js"></script>'.
					'<link rel="stylesheet" href="css/styles.css">'.
					'<a href="?'.$this->inboxLocation.'&id='. $this->loginModel->getId() .'">Back</a>'.
					'</br>'.
					'</br>'.
					'<a class="remove btn danger" href="?'.$this->removeLocation.'&'.$this->id.'='.$this->getId().'">Delete this message</a>'.
					'<div id="msg">'.
					'<strong>From: </strong>'.
					'<strong>'.$msg->getFromName().'</strong>'.
					'</br>'.
					'<strong>Date: </strong>'.
					'<strong>'.$msg->getDate().'</strong>'.
					'</br>'.
					'<strong>Time: </strong>'.
					'<strong>'.time_passed($msg->getTime()).'</strong>'.
					'<pre><strong>'.$msg->getDate().'</strong> - <strong>'.time_passed($msg->getTime()).'</strong></br><strong>'.$msg->getFromName()."</strong> wrote : ".$msg->getMessages().'</pre>'.'</div>';
					if ($replayMsgs != null ) {
						# code...
						foreach ($replayMsgs as $replayMsg) {

						//	if ($replayMsg->getNewMsgId() != null || $replayMsg->getNewMsgId() != "" || $replayMsg->getNewMsgId() != 0) {
								# code...
								 $html .=	
									'<div id="msg">'.
									'<pre><strong>'.$replayMsg->getReplayDate().'</strong> - <strong>'.time_passed($replayMsg->getReplayTime()).'</strong></br><strong>'.$replayMsg->getName()."</strong> wrote : ".$replayMsg->getMessages().'</pre>'.
									'</div>';
							//}
						
						}
					}
					
			$html .= '</br>'.
				'<div id="msg">'.
				  "<form action='' class='form-horizontal' method=post enctype=multipart/form-data>";
				  foreach ($toUser as $key) {
				  	# code...
				  	$html .= "<div class='form-group'>
						         <div class='col-sm-10'>
						           <input class='form-control' name='$this->toUserIdLocation' value='".$key."' type='hidden'>
						         </div>
						      </div>";
				  }
				    
				   $html .= "<div class='form-group'>
						         <div class='col-sm-10'>
						           <input class='form-control' name='$this->usernameLocation' value='".$FromUser."' type='hidden'>
						         </div>
						      </div>
						      <div class='form-group'>
						         <label class='col-sm-2 control-label' for='$this->sendMessageLocation'>Message: </label>
						         <div class='col-sm-10'>
						           <textarea rows='10' cols='5' class='form-control' name='$this->sendMessageLocation' type='text' maxlength='500'></textarea>
						         </div>
						      </div>
						         <input class='btn btn-default' name='$this->submitSendMsgLocation' type='submit' value='Replay' />
						       </div>
						     </div>
						   </fieldset>
				       </form>".
				       '</div>';		
			return $html;
		}



		public function showSentMsg() {

			$msg = $this->messages->getMessage($this->getId());
			$FromUser = $this->loginModel->getUsername();
			$replayMsgs = $this->messages->getReplayMessage($this->getId());
			$toUser = $this->userRepository->getUserIdByUserName($msg->getFromName());

			$html = 
					'</br>'.
					'<script type="text/javascript" src="js/jquery.js"></script>'.
					'<link rel="stylesheet" href="css/bootstrap.min.css">'.
					'<script type="text/javascript" src="js/inboxJS.js"></script>'.
					'<link rel="stylesheet" href="css/styles.css">'.
					'<a href="?'.$this->sendLocation.'&id='. $this->loginModel->getId() .'">Back</a>'.
					'</br>'.
					'</br>'.
					'<a class="remove btn danger" href="?'.$this->removeSentLocation.'&'.$this->id.'='.$this->getId().'">Delete this message</a>'.
					'<div id="msg">'.
					'</br>'.
					'<pre><strong>'.$msg->getDate().'</strong> - <strong>'.time_passed($msg->getTime()).'</strong></br><strong>'.$msg->getFromName()."</strong> wrote : ".$msg->getMessages().'</pre>'.'</div>';
					if ($replayMsgs != null) {
						# code...
						foreach ($replayMsgs as $replayMsg) {
						 $html .=	
							'<div id="msg">'.
							'<pre><strong>'.$replayMsg->getReplayDate().'</strong> - <strong>'.time_passed($replayMsg->getReplayTime()).'</strong></br><strong>'.$replayMsg->getName()."</strong> wrote : ".$replayMsg->getMessages().'</pre>'.
							'</div>';
						}
					}
							
			return $html;
		}

		public function didUserPressToReplayMsg() {
		
			if (isset($_POST[$this->submitSendMsgLocation])) {
				return true;
			}

			return false;
		}


		public function getUserReplayMsg() {
			if (isset($_POST[$this->sendMessageLocation])) {
				return $_POST[$this->sendMessageLocation];
			}
		}
		public function rednerInbox() {

			return $this->InboxHTML();
		}

		public function rednerSendMsg() {

			return $this->SendHTML();
		}

		public function getReplayUserName() {
			if (isset($_POST[$this->usernameLocation])) {
				return $_POST[$this->usernameLocation];
			}
		}


		public function getToUserId() {
			if (isset($_POST[$this->toUserIdLocation])) {
				return $_POST[$this->toUserIdLocation];
			}
		}
		public function rednerMsg() {

			return $this->showMsg();
		}

		public function rednerShowMsg() {

			return $this->showSentMsg();
		}

		public function didUserPressToInbox() {
			if (isset($_GET[$this->inboxLocation])) {
				return true;
			}

			return false;
		}


		public function didUserPressToSend() {
			if (isset($_GET[$this->sendLocation])) {
				return true;
			}

			return false;
		}


		public function didUserPressToSeeMsg() {
		
			if (isset($_GET[$this->msgLocation])) {
				return true;
			}

			return false;
		}


		public function didUserPressToSeeSentMsg() {
		
			if (isset($_GET[$this->sentMsgLocation])) {
				return true;
			}

			return false;
		}

		public function didUserPressToRemoveMsg() {
		
			if (isset($_GET[$this->removeLocation])) {
				return true;
			}

			return false;
		}

		public function didUserPressToRemoveSentMsg() {
		
			if (isset($_GET[$this->removeSentLocation])) {
				return true;
			}

			return false;
		}

	}