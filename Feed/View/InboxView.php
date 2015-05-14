<?php 

	require_once('View/BaseView.php');
	require_once('helper/time.php');
	require_once('Model/ImagesModel.php');

	/**
	* inbox
	*/
	class InboxView extends BaseView
	{
		  private $mainView;
		  private $messages;
		  protected $imagesModel;
		  protected $loginModel;
		  private $messagesRepository;
		
		public function __construct(LoginModel $model,Messages $messages,HTMLView $mainView,UserRepository $userRepository,MessagesRepository $messagesRepository)
		{
			# code...
			$this->imagesModel = new ImagesModel();
			$this->mainView = $mainView;
		    $this->messages = $messages;
		    $this->loginModel = $model;
		    $this->messagesRepository = $messagesRepository;
		    $this->userRepository = $userRepository;
		}


	   public function setMessage($message) {
      	  $this->message = $message;
    	}

		public function InboxHTML() {
			    $inboxes = $this->messages->getMsgForUser($this->loginModel->getId());

			    $html = $this->cssView("Inbox");

			    $open = $this->messagesRepository->getIfOpenOrNot($this->loginModel->getId());

		            
		                  if ($open != null) {
		                        # code...
		                       if ($open == 1) {
		                                              # code...
                         $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox <span class="badge">1</span></a></li>';
                       }
                       else {
                           $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox  <span class="badge">' . $open . '</span></a></li>';
                       }
		                  }
		                  else {
		                      $html .= '<li class="active"><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox</a></li><span class="sr-only">(current)</span></a></li>';
		                  }
		                 
		              $html .= '<li><a name="Inbox" href="?' . $this->sendLocation ."&".$this->id."=".$this->loginModel->getId().'">Sent Messages</a></li>'.
		              '<li><a href="?' . $this->changePasswordLocation . '">Change Password</span></a></li>
		              </ul>
		            </div>';


		            $html .= '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		            ' . $this->message . '';


				$html .= '</br>'.
					'<script type="text/javascript" src="js/jquery.js"></script>'.
					'<script type="text/javascript" src="js/LoadMoreMessages.js"></script>'.
					'<script type="text/javascript">var user_id = ' . $this->getId() . ';</script>' .
					'<script type="text/javascript" src="js/inboxJS.js"></script>'.
					'<link rel="stylesheet" href="css/customCss.css">'.
					'</br>';
                



			$html .= 
					'<div id="msg">';	
					if ($inboxes != null) {
						# code...

						foreach ($inboxes as $inbox) {
						
							# code...
							if ($inbox->getOpen() == 0) {
							# code...
							$open = '<img src="img/msg.png" alt="NotOpened" title="NotOpened" />';
							}
							else {
								$open ='<img src="img/new.png" alt="Opened" title="Opened" />';
							}
						
						    $html .= 

								'<div id="msg'.$inbox->getMsgId().'" class="msg">'.
								'<div class="panel panel-info">
           						 <div class="panel-heading">
           					   <h3 class="panel-title"><a href="?'.$this->msgLocation.'&'.$this->id.'='.$inbox->getMsgId().'">'.$open.'</a></h3>
          					  </div>
          					  <div class="panel-body">
          					    <div class="row">
			                <div class=" col-md-9 col-lg-9 "> 
			                  <table class="table table-user-information">
			                    <tbody>
			                      <tr><td><strong>From: </strong> '.$inbox->getFromName().'</td>'.
								'<td><strong>Subject: </strong> '.$inbox->getSubject().'</td>'.
								'<td><strong>Date: </strong> '.$inbox->getDate().'</td>'.
								'<td><strong>Time: </strong> '.time_passed($inbox->getTime()).'</td>'.
								'</tr>
			                    </tbody>
			                  </table>
			                </div>
			                </div>
			              </div>
			            </div>'.
					'</div>';

						}
					}
					else
					{
						$html .= '<div id="msg">'.
								 '<h3>There is no message right now!</h3>'.
								 '</div">';

					}
				



			     $html .= '</div><p id="loader"><img src="images/ajax-loader.gif"></p>
			     <script src="js/jquery.min.js"></script>
			        <script src="js/bootstrap.min.js"></script>
			        <script src="js/ie10-viewport-bug-workaround.js"></script>
			      </body>
			    </html>';	
					

			return $html;
		}



		public function SendHTML() {
			//$total = $this->messagesRepository->GetNrOfMsg();

			$UserName = $this->userRepository->getUsernameFromId($this->loginModel->getId());
						
			$sendMsgs  =  $this->messagesRepository->getMsgByUserName($UserName);

			$inboxes = $this->messages->getMsgForUser($this->loginModel->getId());
			//$total = $this->messagesRepository->GetNrOfMsg();
			$html = $this->cssView("Sent Messages");


			$open = $this->messagesRepository->getIfOpenOrNot($this->loginModel->getId());

		            
		                  if ($open != null) {
		                        # code...
		                       if ($open == 1) {
		                                            # code...
                         $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox <span class="badge">1</span></a></li>';
                       }
                       else {
                           $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox  <span class="badge">' . $open . '</span></a></li>';
                       }
		                  }
		                  else {
		                      $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox</a></li>';
		                  }
		                 
		              $html .= '<li class="active"><a name="Inbox" href="?' . $this->sendLocation ."&".$this->id."=".$this->loginModel->getId().'">Sent Messages</a></li><span class="sr-only">(current)</span></a></li>'.
		              '<li><a href="?' . $this->changePasswordLocation . '">Change Password</span></a></li>
		              </ul>
		            </div>';


		            $html .= '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		            ' . $this->message . '';

            $html .= '</br>'.
				'<link href="css/customCss.css" rel="stylesheet">'.
				'<script type="text/javascript" src="js/jquery.js"></script>'.
				'<script type="text/javascript">var user_id = ' . $this->loginModel->getId() . ';</script>' .
					'<script type="text/javascript" src="js/inboxJS.js"></script>'.
			
					'</br>';

				$html .= 
					'<div id="msg">';	
					if ($sendMsgs != null) {
						# code...

						foreach ($sendMsgs as $sendMsg) {	

						$ToUserName = $this->userRepository->getUsernameFromId($sendMsg->getUserId());
						$sentMsgImg = '<img src="img/send.png" alt="Sent message" title="Sent Message" />';
						    $html .= 
								'<div id="msg'.$sendMsg->getMsgId().'" class="msg">'.
								'<div class="panel panel-info">
           						 <div class="panel-heading">
           					   <h3 class="panel-title"><a href="?'.$this->sentMsgLocation.'&'.$this->id.'='.$sendMsg->getMsgId().'">'.$sentMsgImg.'</a></h3>
          					  </div>
          					  <div class="panel-body">
          					    <div class="row">
			                <div class=" col-md-9 col-lg-9 "> 
			                  <table class="table table-user-information">
			                    <tbody>
			                      <tr><td><strong>To: </strong>'.$ToUserName.'</td>'.
								'<td><strong>Subject: </strong>'.$sendMsg->getSubject().'</td>'.
								'<td><strong>Date: </strong>'.$sendMsg->getDate().'</td>'.
								'<td><strong>Time: </strong>'.time_passed($sendMsg->getTime()).'</td>'.
								'</tr>
			                    </tbody>
			                  </table>
			                </div>
			                </div>
			              </div>
			            </div>'.
					'</div>';

						}
					}
					else
					{
						$html .= '<div id="msg">'.
								 '<h3>You do not have any sent messages right now!</h3>'.
								 '</div">';

					}			


        

			     $html .= '</div>
			     <p id="loader"><img src="images/ajax-loader.gif"></p>
			     <script src="js/jquery.min.js"></script>
			        <script src="js/bootstrap.min.js"></script>
			        <script src="js/ie10-viewport-bug-workaround.js"></script>
			      </body>
			    </html>';	

			return $html;
		}

		public function showMsg() {
			
			$html = $this->cssView("Show Message");
			$msg = $this->messages->getMessageForInbox($this->getId());
			$FromUser = $this->loginModel->getUsername();
			$replayMsgs = $this->messages->getReplayMessage($this->getId());
			$toUser = $this->userRepository->getUserIdByUserName($msg->getFromName());


			 $open = $this->messagesRepository->getIfOpenOrNot($this->loginModel->getId());

		            
		                  if ($open != null) {
		                        # code...
		                       if ($open == 1) {
		                                               # code...
                         $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox <span class="badge">1</span></a></li>';
                       }
                       else {
                           $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox  <span class="badge">' . $open . '</span></a></li>';
                       }
		                  }
		                  else {
		                      $html .= '<li class="active"><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox</a></li><span class="sr-only">(current)</span></a></li>';
		                  }
		                 
		              $html .= '<li><a name="Inbox" href="?' . $this->sendLocation ."&".$this->id."=".$this->loginModel->getId().'">Sent Messages</a></li>'.
		              '<li><a href="?' . $this->changePasswordLocation . '">Change Password</span></a></li>
		              </ul>
		            </div>';



		            $html .= '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		            ' . $this->message . '';

			$html .= 
					'</br>'.
						'<script type="text/javascript" src="js/jquery.js"></script>'.
					'<script type="text/javascript" src="js/inboxJS.js"></script>'.
					'<link rel="stylesheet" href="css/customCss.css">'.
					'<a class="btn btn-default" href="?'.$this->inboxLocation.'&id='. $this->loginModel->getId() .'">Back</a>'.
					'</br>'.
					'</br>'.
					 '<div class="panel panel-info">'.
					'<div class="panel-heading">
           				 <h3 class="panel-title">Receive Messages</h3>
          			 </div>'.
          			  '</div>'.
					'<a class="btn btn-danger" href="?'.$this->removeLocation.'&'.$this->id.'='.$this->getId().'">Delete</a>'.
					'</br>'.
					'</br>'.
					'<div class="jumbotron">'.
					'<strong>From: </strong>'.$msg->getFromName().
					'</br>'.
					'<strong>Date: </strong>'.$msg->getDate().
					'</br>'.
					'<strong>Time: </strong>'.time_passed($msg->getTime()).
					'</br>'.
					'</br>'.
					'<pre><strong>'.$msg->getDate().'</strong> - <strong>'.time_passed($msg->getTime()).'</strong></br><strong>'.$msg->getFromName()."</strong> said : ".$msg->getMessages().'</pre>';
					if ($replayMsgs != null ) {
						# code...
						foreach ($replayMsgs as $replayMsg) {

					
								 $html .=	
									'<div id="msg">'.
									'<pre><strong>'.$replayMsg->getReplayDate().'</strong> - <strong>'.time_passed($replayMsg->getReplayTime()).'</strong></br><strong>'.$replayMsg->getName()."</strong> said : ".$replayMsg->getMessages().'</pre>'.
									'</div>';
						
						}
					}
					
			$html .= '</br>'.
				'<div id="msg">'.
				  "<form action='' class='form-horizontal' method=post enctype=multipart/form-data>";
				  if ($toUser > 1) {
				  	# code...
					  	foreach ($toUser as $key) {
					  	# code...
					  	$html .= "<div class='form-group'>
							         <div class='col-sm-10'>
							           <input class='form-control' name='$this->toUserIdLocation' value='".$key."' type='hidden'>
							         </div>
							      </div>";
					 	}
				  }
				  else
				  {
					  	$html .= "<div class='form-group'>
							         <div class='col-sm-10'>
							           <input class='form-control' name='$this->toUserIdLocation' value='".$toUser."' type='hidden'>
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
				       '</div>
				       </div>';		

				        $html .= '<script src="js/jquery.min.js"></script>
					        <script src="js/bootstrap.min.js"></script>
					        <script src="js/ie10-viewport-bug-workaround.js"></script>
					      </body>
					    </html>';	

			return $html;
		}



		public function showSentMsg() {

			$msg = $this->messages->getMessage($this->getId());
			$FromUser = $this->loginModel->getUsername();
			$replayMsgs = $this->messages->getReplayMessage($this->getId());
			$toUser = $this->userRepository->getUserIdByUserName($msg->getFromName());
			$html = $this->cssView("Sent Message");

				$open = $this->messagesRepository->getIfOpenOrNot($this->loginModel->getId());

		            
		                  if ($open != null) {
		                        # code...
		                       if ($open == 1) {
		                                             # code...
                         $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox <span class="badge">1</span></a></li>';
                       }
                       else {
                           $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox  <span class="badge">' . $open . '</span></a></li>';
                       }
		                  }
		                  else {
		                      $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox</a></li>';
		                  }
		                 
		              $html .= '<li class="active"><a name="Inbox" href="?' . $this->sendLocation ."&".$this->id."=".$this->loginModel->getId().'">Sent Messages</a></li><span class="sr-only">(current)</span></a></li>'.
		              '<li><a href="?' . $this->changePasswordLocation . '">Change Password</span></a></li>
		              </ul>
		            </div>';



		            $html .= '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		            ' . $this->message . '';
			$html .= 
					'</br>'.
						'<script type="text/javascript" src="js/jquery.js"></script>'.
						'<link rel="stylesheet" href="css/customCss.css">'.
					'<script type="text/javascript" src="js/inboxJS.js"></script>'.
					'<a class="btn btn-default" href="?'.$this->sendLocation.'&id='. $this->loginModel->getId() .'">Back</a>'.
					'</br>'.
					'</br>'.
					 '<div class="panel panel-info">'.
					'<div class="panel-heading">
           			<h3 class="panel-title">Sent Message</h3>
          			 </div>'.
          			  '</div>'.
					'<a class="btn btn-danger" href="?'.$this->removeSentLocation.'&'.$this->id.'='.$this->getId().'">Delete</a>'.
					'</br>'.
					'</br>'.
					'<div class="jumbotron">'.
					'<div class="alert alert-info">'.
					'<strong>From: </strong>'.$msg->getFromName().
					'</br>'.
					'<strong>Date: </strong>'.$msg->getDate().
					'</br>'.
					'<strong>Time: </strong>'.time_passed($msg->getTime()).
					'</div>'.
					'<pre><strong>'.$msg->getDate().'</strong> - <strong>'.time_passed($msg->getTime()).'</strong></br><strong>'.$msg->getFromName()."</strong> said : ".$msg->getMessages().'</pre>'.'</div>';
					if ($replayMsgs != null) {
						# code...
						foreach ($replayMsgs as $replayMsg) {
						 $html .=	
							'<div id="msg">'.
							'<pre><strong>'.$replayMsg->getReplayDate().'</strong> - <strong>'.time_passed($replayMsg->getReplayTime()).'</strong></br><strong>'.$replayMsg->getName()."</strong> said : ".$replayMsg->getMessages().'</pre>'.
							'</div>';
						}
					}
							
						 $html .= '<script src="js/jquery.min.js"></script>
					        <script src="js/bootstrap.min.js"></script>
					        <script src="js/ie10-viewport-bug-workaround.js"></script>
					      </body>
					    </html>';		

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