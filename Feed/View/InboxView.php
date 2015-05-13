<?php 

	require_once('View/HTMLView.php');
	require_once('Model/Messages.php');
	require_once('View/BaseView.php');
	require_once('Model/LoginModel.php');
	require_once('helper/time.php');
	require_once('Model/Dao/MessagesRepository.php');
	require_once('Model/Dao/UserRepository.php');
	require_once('Model/ImagesModel.php');

	/**
	* inbox
	*/
	class InboxView extends BaseView
	{
		  private $mainView;
		  private $messages;
		  private $imagesModel;
		  private $loginModel;
		  private $messagesRepository;
		  private $pic; 
		
		public function __construct()
		{
			# code...
			$this->imagesModel = new ImagesModel();
			$this->mainView = new HTMLView();
		    $this->messages = new Messages();
		    $this->loginModel = new LoginModel();
		    $this->messagesRepository = new MessagesRepository();
		    $this->userRepository = new UserRepository();
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
		                         $html .= '<li class="active"><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox (One new message)</a></li><span class="sr-only">(current)</span></a></li>';
		                       }
		                       else {
		                           $html .= '<li class="active"><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox ('.$open.' new messages)</a></li><span class="sr-only">(current)</span></a></li>';
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
		                         $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox (One new message)</a></li>';
		                       }
		                       else {
		                           $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox ('.$open.' new messages)</a></li>';
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
								 '<h3>You do not have any send messages right now!</h3>'.
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
		                         $html .= '<li class="active"><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox (One new message)</a></li><span class="sr-only">(current)</span></a></li>';
		                       }
		                       else {
		                           $html .= '<li class="active"><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox ('.$open.' new messages)</a></li><span class="sr-only">(current)</span></a></li>';
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
		                         $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox (One new message)</a></li>';
		                       }
		                       else {
		                           $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox ('.$open.' new messages)</a></li>';
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


		public function cssView($title = null) {

			    // BEHÖVS
    	  $Images = glob("imgs/*.*");

          $username = $this->loginModel->getUsername();

          $adminMenu = "";
          $userPic = "";
          $userPicProfile = "";


        
          if ($this->loginModel->isAdmin()) 
          {
          	  $adminMenu .= "<li><a name='AdminPanel' href='?". $this->AdminPanelLocation . "'>Admin Panel</a></li>";
          }

		   	    /// PROFIL BILD FÖR NAV 
			    $users = $this->loginModel->GetUserProfileDetails($this->loginModel->getId());
			    
			    foreach ($Images as $value) 
			    {  
			        $img = $this->imagesModel->getImages($this->loginModel->getId());
			        if ($img->getImgName() == basename($value)) 
			        {        
			          $userPic .= '<div><img id="profileImage" src="'.$value.'" > <label id="profileName"><a name="profile" href="?' . $this->userProfileLocation . "&id=".$this->loginModel->getId(). '">' . $username . '</a></label></div>';
			          $this->pic = $value;
			        }
			    }

			    if (basename($this->pic) === "" && $users->getSex() == "Man") 
			    {
			        $userPic .= '<div><img id="profileImage" src="img/default.jpg"> <label id="profileName"><a name="profile" href="?' . $this->userProfileLocation . "&id=".$this->loginModel->getId(). '">' . $username . '</a></label></div>';
			    }
			    else if (basename($this->pic) === "" && $users->getSex() == "Kvinna")
			    {
			        $userPic .= '<div><img id="profileImage" src="img/kvinna.png" <label id="profileName"><a name="profile" href="?' . $this->userProfileLocation . "&id=".$this->loginModel->getId(). '">' . $username . '</a></label></div>';
			    }

		     $html = 
		    '<!DOCTYPE html>
		    <html lang="en">
		      <head>
		        <meta charset="utf-8">
		        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		        <meta name="viewport" content="width=device-width, initial-scale=1">
		        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		        <link rel="icon" href="../../favicon.ico">
		        <title> ' . $title . ' | LSN</title>
		        <link href="css/bootstrap.min.css" rel="stylesheet">
		        <link href="css/customCss.css" rel="stylesheet">
		        <script type="text/javascript" src="jquery.min.js"></script>
		        <script type="text/javascript" src="script.js"></script>

		        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

		      </head>

		      <body>

		        <nav class="navbar navbar-inverse navbar-fixed-top">
		          <div class="container">
		            <div class="navbar-header">
		              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		                <span class="sr-only">Toggle navigation</span>
		                <span class="icon-bar"></span>
		                <span class="icon-bar"></span>
		                <span class="icon-bar"></span>
		              </button>
		              <a class="navbar-brand" href="?">LSN</a>
		            </div>
		            <div id="navbar" class="navbar-collapse collapse">

		              <form class="navbar-form navbar-right" role="search" method="post" enctype="multipart/form-data">
		              <div class="form-group">
		              <div class="input-group">
		              <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
		             
		              <div class="input_container">
		                <input type="text" id="course_id" onkeyup="autocomplet()" name="' . $this->searchLocation . '" size="20" maxlength="20" class="form-control1" placeholder="Search">
		                <ul id="course_list_id"></ul>
		                </div>
		              </div>
		              </div>
		              <button type="submit" name="' . $this->submitSearchLocation . '" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
		            </form>
		              

		              <ul class="nav navbar-nav navbar-right">
		              <li>' . $userPic . '</li>
		                ' . $adminMenu . '
		                <li><a name="logOut" href="?' . $this->logOutLocation . '">Log Out</a></li>
		              </ul>
		              
		            </div>
		          </div>
		        </nav>

		        <div class="container-fluid">
		          <div class="row">
		            <div class="col-sm-3 col-md-2 sidebar">
		              <ul class="nav nav-sidebar">
		                <li><a href="?">Available Programmes</a></li>';
		           
		                


		        
			

		    return $html;
				}







		public function getCssViewForMaster($title = null) {

			    // BEHÖVS
    	  $Images = glob("imgs/*.*");

          $username = $this->loginModel->getUsername();

          $adminMenu = "";
          $userPic = "";
          $userPicProfile = "";


        
          if ($this->loginModel->isAdmin()) 
          {
          	  $adminMenu .= "<li><a name='AdminPanel' href='?". $this->AdminPanelLocation . "'>Admin Panel</a></li>";
          }

		   	    /// PROFIL BILD FÖR NAV 
			    $users = $this->loginModel->GetUserProfileDetails($this->loginModel->getId());
			    
			    foreach ($Images as $value) 
			    {  
			        $img = $this->imagesModel->getImages($this->loginModel->getId());
			        if ($img->getImgName() == basename($value)) 
			        {        
			          $userPic .= '<div><img id="profileImage" src="'.$value.'" > <label id="profileName"><a name="profile" href="?' . $this->userProfileLocation . "&id=".$this->loginModel->getId(). '">' . $username . '</a></label></div>';
			          $this->pic = $value;
			        }
			    }

			    if (basename($this->pic) === "" && $users->getSex() == "Man") 
			    {
			        $userPic .= '<div><img id="profileImage" src="img/default.jpg"> <label id="profileName"><a name="profile" href="?' . $this->userProfileLocation . "&id=".$this->loginModel->getId(). '">' . $username . '</a></label></div>';
			    }
			    else if (basename($this->pic) === "" && $users->getSex() == "Kvinna")
			    {
			        $userPic .= '<div><img id="profileImage" src="img/kvinna.png" <label id="profileName"><a name="profile" href="?' . $this->userProfileLocation . "&id=".$this->loginModel->getId(). '">' . $username . '</a></label></div>';
			    }

		     $html = 
		    '<!DOCTYPE html>
		    <html lang="en">
		      <head>
		        <meta charset="utf-8">
		        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		        <meta name="viewport" content="width=device-width, initial-scale=1">
		        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		        <link rel="icon" href="../../favicon.ico">
		        <title> ' . $title .  ' | LSN</title>
		        <link href="css/bootstrap.min.css" rel="stylesheet">
		        <link href="css/customCss.css" rel="stylesheet">
		        <script type="text/javascript" src="jquery.min.js"></script>
		        <script type="text/javascript" src="script.js"></script>

		        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

		      </head>

		      <body>

		        <nav class="navbar navbar-inverse navbar-fixed-top">
		          <div class="container">
		            <div class="navbar-header">
		              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		                <span class="sr-only">Toggle navigation</span>
		                <span class="icon-bar"></span>
		                <span class="icon-bar"></span>
		                <span class="icon-bar"></span>
		              </button>
		              <a class="navbar-brand" href="?">LSN</a>
		            </div>
		            <div id="navbar" class="navbar-collapse collapse">

		              <form class="navbar-form navbar-right" role="search" method="post" enctype="multipart/form-data">
		              <div class="form-group">
		              <div class="input-group">
		              <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
		             
		              <div class="input_container">
		                <input type="text" id="course_id" onkeyup="autocomplet()" name="' . $this->searchLocation . '" size="20" maxlength="20" class="form-control1" placeholder="Search">
		                <ul id="course_list_id"></ul>
		                </div>
		              </div>
		              </div>
		              <button type="submit" name="' . $this->submitSearchLocation . '" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
		            </form>
		              

		              <ul class="nav navbar-nav navbar-right">
		              <li>' . $userPic . '</li>
		                ' . $adminMenu . '
		                <li><a name="logOut" href="?' . $this->logOutLocation . '">Log Out</a></li>
		              </ul>
		              
		            </div>
		          </div>
		        </nav>

		        <div class="container-fluid">
		          <div class="row">
		            <div class="col-sm-3 col-md-2 sidebar">
		              <ul class="nav nav-sidebar">
		                <li><a href="?">Available Programmes</a></li>';
		           
		                

		                $open = $this->messagesRepository->getIfOpenOrNot($this->loginModel->getId());
		        
		                  if ($open != null) {
		                        # code...
		                       if ($open == 1) {
		                         # code...
		                         $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox (One new message)</a></li>';
		                       }
		                       else {
		                           $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox ('.$open.' new messages)</a></li>';
		                       }
		                  }
		                  else {
		                      $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox</a></li>';
		                  }
		                 
		              $html .= '<li><a name="Inbox" href="?' . $this->sendLocation ."&".$this->id."=".$this->loginModel->getId().'">Sent Messages</a></li>'.
		              '<li><a href="?' . $this->changePasswordLocation . '">Change Password</span></a></li>
		              </ul>
		            </div>';



		            $html .= '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		            ' . $this->message . '';
			

		    return $html;
				}
	}