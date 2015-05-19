<?php
 
require_once('View/Navigation.php');
require_once("Model/LoginModel.php");
require_once("Model/Dao/UserRepository.php");
require_once("Model/Dao/CourseRepository.php");
require_once("Settings.php");
require_once("View/BaseView.php");
require_once("View/ChangePasswordView.php");
require_once("Controller/LoginController.php");
require_once("View/HTMLView.php");
require_once("View/ForgetPasswordView.php");
require_once("View/ResetPasswordView.php"); 
require_once("View/ContactView.php");
require_once("View/CreateCourseView.php");
require_once("Controller/ContactController.php");
require_once('Controller/UploadController.php');
require_once('Controller/AdminController.php'); 
require_once('View/ProfileView.php');
require_once("View/InboxView.php");
require_once('Model/Messages.php');
require_once('Model/Dao/MessagesRepository.php');
require_once('View/MessageFormView.php');
require_once('View/ProgramView.php');
require_once('View/AdminPanelView.php');
require_once('Controller/ChangeUserController.php');


class MasterController extends Navigation
{
	private $contactController;
	private $adminController;
	private $contactView;
	private $loginController;
    private $htmlView;
    private $model;
    private $forgetPasswordView;
    private $userRepository;
    private $code;
    private $adminPanelView;
    private $resetPasswordView;
    private $emailExp;
    private $uploadController;
    private $profileView;
    private $feed;
    private $renderContact = false;
    private $createCourseView;
    private $courseRepository;
    private $inboxView;
    private $messages;
    private $messageRepository;
    private $messageFormView;
    private $programView;
    private $name;
    private $co;
    private $changeUserController;


    private static $Error_Sub_TYPE = "<div class='alert alert-danger alert-error'>
					   <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
					   <a href='#' class='close' data-dismiss='alert'>&times;</a>        
					  <span id='sizeOfPTag'>Subject is required</span>
					  </div>";

  	private static $Error_Msg_TYPE = "<div class='alert alert-danger alert-error'>
					   <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
					   <a href='#' class='close' data-dismiss='alert'>&times;</a>        
					  <span id='sizeOfPTag'>Message is required</span>
					  </div>";

	private static $UpgradeUser = "<div class='alert alert-success'>
					   <span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span>
					   <a href='#' class='close' data-dismiss='alert'>&times;</a>        
					  <span id='sizeOfPTag'>User has been upgraded</span>
					  </div>";


  	private static $DowngradeUser = "<div class='alert alert-success'>
					   <span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span>
					   <a href='#' class='close' data-dismiss='alert'>&times;</a>        
					  <span id='sizeOfPTag'>User has been downgraded</span>
					  </div>";

  	private static $removeUser = "<div class='alert alert-success'>
					   <span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span>
					   <a href='#' class='close' data-dismiss='alert'>&times;</a>        
					  <span id='sizeOfPTag'>User has been removed</span>
					  </div>";

	function __construct()
	{

      	$this->userRepository = new UserRepository();
      	$this->courseRepository = new CourseRepository();
      	$this->messageRepository = new MessagesRepository();
      	
      	$this->messages = new Messages();
      	$this->model = new LoginModel();
      	
		$this->forgetPasswordView = new ForgetPasswordView();
		$this->htmlView = new HTMLView();
		$this->resetPassword = new ResetPasswordView();
		$this->contactView = new ContactView();
		$this->profileView = new ProfileView();
		$this->changePasswordView = new ChangePasswordView();

		
		$this->inboxView = new InboxView($this->model,$this->messages,$this->htmlView,$this->userRepository,$this->messageRepository);
      	$this->createCourseView = new CreateCourseView($this->model,$this->messageRepository);
      	$this->messageFormView = new MessageFormView($this->htmlView,$this->model,$this->messageRepository);
      	$this->programView = new ProgramView($this->model,$this->messageRepository);
      	$this->adminPanelView = new AdminPanelView($this->model,$this->messageRepository,$this->userRepository,$this->courseRepository);

      	$this->contactController = new ContactController($this->contactView);
      	$this->uploadController = new UploadController($this->profileView,$this->model);
      	$this->adminController = new AdminController($this->model,$this->createCourseView,$this->htmlView);
      	$this->loginController = new LoginController();
      	$this->changeUserController = new ChangeUserController($this->model,$this->userRepository,$this->profileView);

      	$this->feed = new FeedView($this->model); 
      	
      	$this->emailExp = "/^[a-z0-9\å\ä\ö._-]+@[a-z0-9\å\ä\ö.-]+\.[a-z]{2,6}$/i";
	}

		public function doControll()  
		{			
			try 
			{	

				if ($this->forgetPasswordView->pressSubmitToSend() && !$this->resetPassword->issetCode()) 
				{
					if (!preg_match($this->emailExp, $this->getEmail())) 
					{	
						$msgId = 22;
    				    $this->loginMessage = new LoginMessage($msgId);        
		                $message = $this->loginMessage->getMessage();
		                $this->forgetPasswordView->setMessage($message);
		                return  $this->forgetPasswordView->showForgetPasswordPage();
					}

					else
					{			
						$userEmail = $this->userRepository->getEmailForResetPassword($this->getEmail());

					  if($userEmail != ""){
						
						if($this->getEmail() == $userEmail->getEmail()) {
							$date = date('Y-m-d H:i:s');
							$this->code = rand(10000,1000000);
							$to = $userEmail->getEmail();
							$subject = "LSN/ Forgot password";
							$message = "Hej!
							(Det här meddelandet går inte att svara på).
							OBS// Länken är endast aktiv i 20 minuter.
							För att ändra lösenordet klicka på länken nedan:
							http://www.sahibsahib.com/LSN/Feed/?gjaQwrA=$this->code&kjAmsdNg";

							$headers = 'From: LSN@sahibsahib.com' . "\r\n" .
									   'X-Mailer: PHP/' . phpversion();

							$this->userRepository->resetPassword($this->code,$this->getEmail());
							$this->userRepository->resetPasswordTime($date,$this->getEmail());
							
							if (mail($to, $subject, $message,$headers)) 
							{
								$msgId = 42;
								$this->loginMessage = new LoginMessage($msgId);        
				                $message = $this->loginMessage->getMessage();
				                $this->forgetPasswordView->setMessage($message);
				                return  $this->forgetPasswordView->showForgetPasswordPage();
							 }
							}
								
						 
					}
					else
						  {
								$msgId = 42;
								$this->loginMessage = new LoginMessage($msgId);        
				                $message = $this->loginMessage->getMessage();
				                $this->forgetPasswordView->setMessage($message);
				                return  $this->forgetPasswordView->showForgetPasswordPage();
						}	

					 }
				}	

				

				else if ($this->loginController->isAuthenticated() && $this->programView->hasSubmitToSearch())
    	        {
    	        
	                $names = $this->userRepository->search($this->programView->getSearchValue());
	                $courses = $this->userRepository->searchCourse($this->programView->getSearchValue());
	                $html = $this->getCssViewForMaster("Search");

			   		 $open = $this->messageRepository->getIfOpenOrNot($this->model->getId());

		            
		                  if ($open != null) {
		                        # code...
		                       if ($open == 1) {
		                                              # code...
                         $html .= '<li><a name="Inbox"  href="?Inbox&id='.$this->model->getId().'">Inbox <span class="badge">1</span></a></li>';
                       }
                       else {
                           $html .= '<li><a name="Inbox"  href="?Inbox&id='.$this->model->getId().'">Inbox  <span class="badge">' . $open . '</span></a></li>';
                       }
		                  }
		                  else {
		                      $html .= '<li><a name="Inbox" href="?Inbox&id='.$this->model->getId().'">Inbox</a></li><span class="sr-only">(current)</span></a></li>';
		                  }
		                 
		              $html .= '<li><a name="Inbox"  href="?send&id='.$this->model->getId().'">Sent Messages</a></li>'.
		              '<li><a href="?changepassword">Change Password</span></a></li>
		              </ul>
		            </div>';


		            $html .= '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">';


	                if ($names != null) {
	                	# code...
	                	$html .= ' <div class="row"><div class="panel panel-info"> <div class="panel-heading"><h4>Available Users</h4></div></div></div>';
		                foreach ($names as $usernames) {
		                	# code...
		                	foreach ($usernames as $name) {
		                	
		                		$this->name = $name;
		                	}	  



		                	$userId = $this->userRepository->getUserIdByName($this->name);
		                	if ($userId != 0) {
		                		# code...
		                		$html .= '<ul class="list-group"><a class="list-group-item" href="?profile&id='. $userId .'">'.$this->name.'</a></ul>';
		                	}
		               		
		           		}
	                }
	               
	                 if ($courses != null) {
		                 		$html .= '<div class="panel panel-info"> <div class="panel-heading">
	                 			<h4>Available Courses</h4>
          					  </div></div>';
		           		foreach ($courses as $course) {
		                	# code...
		                	foreach ($course as $co) {
		                	
		                		$this->co = $co;
		                	}	 

		                	$courseId = $this->userRepository->getCourseIdByName($this->co);
		                	if ($courseId != 1) {
		               			$html .= '<ul class="list-group"><a class="list-group-item" href="?Course&id='. $courseId .'">'.$this->co.'</a></h3></ul>';
		               		}
		           		}
		           	}
		           	else {

		           		if ($names == null) {
		           			# code...
		           			$html .= '<a href="?">Back</a></br><h2>Sorry, but nothing matched your search terms. Please try again with different keywords</h2>';
		           		}
		           	}

	             return $html;  
             	}

				else if ($this->loginController->isAuthenticated() && $this->changePasswordView->didUserPressToChangePassword())
	            {
	                if ($this->changePasswordView->didUserPressSubmit()) 
	                {
	                    $this->changeUserController->changePassword();
	                }
	                
	                else 
	                {
	                    return $this->changePasswordView->showChangePasswordForm();
	                }   
	            }

	             else if ($this->loginController->isAuthenticated() && $this->inboxView->didUserPressToInbox())
	             {

	    
	            			if ($this->inboxView->getId() == $this->model->getId()) {
	            				# code...
	            				 return $this->inboxView->rednerInbox();
	            			}
	            		
	              
	            }


	            else if ($this->loginController->isAuthenticated() && $this->inboxView->didUserPressToSend())
	            {


	            			if ($this->inboxView->getId() == $this->model->getId()) {
	            				
	            				 return $this->inboxView->rednerSendMsg();
	            			}
	            			
	            }


	            else if ($this->loginController->isAuthenticated() && $this->inboxView->didUserPressToSeeSentMsg()) {
	            		$UserName = $this->userRepository->getUsernameFromId($this->model->getId());
	            		$ids = $this->messageRepository->getMsgIdFromUserName($UserName);	
	            
	            		foreach ($ids as $id) {
	         
	            			if ($this->inboxView->getId() == $id) {
	            				return $this->inboxView->rednerShowMsg();
	            			}

	            		}
	            		
	            }

	            else if ($this->loginController->isAuthenticated() && $this->inboxView->didUserPressToRemoveMsg()) {
	            		$this->messages->deleteMessage($this->inboxView->getId());
	            		return $this->inboxView->rednerInbox();
	            }	

	            else if ($this->loginController->isAuthenticated() && $this->inboxView->didUserPressToRemoveSentMsg()) {
	            		$this->messages->DeleteSentMsg($this->inboxView->getId());
	            		return $this->inboxView->rednerSendMsg();
	            }	

	           else if ($this->loginController->isAuthenticated() && $this->profileView->didUserPressToSendAnewMsg()) {
	           			if ($this->loginController->isAuthenticated() && $this->messageFormView->didUserPressToSendMsg()) {
				         
				           			$name = $this->messageFormView->getUserName();
				           			$id = $this->messageFormView->getToUserId();
				           			$sub = $this->messageFormView->getUserSubject();
				           			$date = date("M/d/Y");
				           			$time = time();
				           			$MSG = $this->messageFormView->getUserMsg();
				           			$open = 0;
				           			if ($sub == "" || $sub == null || empty($sub)) {
				           				# code...
				           				$this->messageFormView->setMessage(self::$Error_Sub_TYPE);
				           				
				           			}
				           			else if ($MSG == "" || $MSG == null || empty($MSG)) {
				           				# code...
				           				$this->messageFormView->setMessage(self::$Error_Msg_TYPE);
				           			}
				           			else
				           			{
				           				$this->messages->AddMessage($name, $sub, $date, $time,$MSG, $open,$id,$newMsgId='');
				           				$this->messages->AddSentMessage($name, $sub, $date, $time,$MSG, $open,$id,$newMsgId='');
				            			header("Location: ?send&id=" . $this->model->getId());
				           			}
				            		
				         }	
	            		return $this->messageFormView->rednerMessageFormView();
	            }	

	            else if ($this->loginController->isAuthenticated() && $this->inboxView->didUserPressToSeeMsg()) {

	            		$open = 1;
	            		$this->messageRepository->IfOpenTheMsg($open,$this->inboxView->getId());
	            		if ($this->inboxView->didUserPressToReplayMsg()) {
	            			# code...
	            			$sub = $this->inboxView->getReplayUserName(). " Replied to you";
	            			$time = time();
	            			$date = date("M/d/Y");
	            			$open = 0;
	            			$replayMsg = $this->inboxView->getUserReplayMsg();
	            			if ($replayMsg == "" || $replayMsg == null || empty($replayMsg)) {
	            				# code...
	                     		$this->inboxView->setMessage(self::$Error_Msg_TYPE);
	            			}
	            			else
	            			{
	            				$this->messages->AddReplayMessage($this->inboxView->getId(),$this->inboxView->getUserReplayMsg(),$this->inboxView->getReplayUserName(),$time,$date,$this->inboxView->getId());
	            				$this->messages->AddMessage($this->inboxView->getReplayUserName(), $sub, $date, $time,$this->inboxView->getUserReplayMsg(),$open,$this->inboxView->getToUserId(),$this->inboxView->getId());
	            				$this->messages->AddSentMessage($this->inboxView->getReplayUserName(), $sub, $date, $time,$this->inboxView->getUserReplayMsg(),$open,$this->inboxView->getToUserId(),$this->inboxView->getId());
	            			}

	            		}

	            		$ids = $this->messageRepository->getMsgIdFromUserId( $this->model->getId());	
	            
	            		foreach ($ids as $id) {
	         
	            			if ($this->inboxView->getId() == $id) {
	            				# code...
	            				return $this->inboxView->rednerMsg();
	            			}

	            		}
	            		
	            }

            	else if ($this->contactView->didUserPressToContact() && $this->contactView->hasSubmitToSend())
    	        {
	                return $this->contactController->doContact();
             	}

				else if ($this->loginController->isAuthenticated() && $this->model->isAdmin() && $this->createCourseView->DidUserPressToCreateCourse())
    	        {
    	        	if ($this->createCourseView->DidUserPressSubmitNewCourse()) 
    	        	{
    	        		return $this->adminController->CreateNewCourse();
    	        	}
    	        	else 
    	        	{
	             		return $this->createCourseView->ShowCreateCourseForm();
	             	}

             	}



             	else if ($this->loginController->isAuthenticated() && $this->model->isAdmin() && $this->adminPanelView->DidUserPressAdminPanel())
    	        {

	             	return $this->adminPanelView->renderAdminPanel();
             	}

             	else if ($this->loginController->isAuthenticated() && $this->model->isAdmin() && $this->adminPanelView->DidUserPressCourseList()) 
             	{
    	        	if ($this->adminPanelView->DidUserPressToRemoveCourse()) {
    	        		$courseid = $this->adminPanelView->getCourseToRemove();
    	        	    $this->courseRepository->removeCourse($courseid);
    	        		$this->adminPanelView->setMessage("<div class='alert alert-success'>
					   <span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span>
					   <a href='#' class='close' data-dismiss='alert'>&times;</a>        
					  <span id='sizeOfPTag'>Course has been removed</span>
					  </div>");
    	        	}

	             	return $this->adminPanelView->renderCourseList();             		
             	}



             	else if ($this->loginController->isAuthenticated() && $this->model->isAdmin() && $this->adminPanelView->DidUserPressUserList())
    	        {

    	        	if ($this->adminPanelView->DidUserPressToUppgradeUser()) {
    	        		# code...
    	        		$userid = $this->adminPanelView->getUserToUppgrade();
    	        		$dbRole = $this->userRepository->getRole($userid);

    	        	
    	        		if($dbRole == 3) {
    	        			# code...
    	        			$role = 1; 
    	        			$this->userRepository->uppGradeUser($role,$userid);
    	        			$this->adminPanelView->setMessage(self::$UpgradeUser);
    	        		}
    	        		else
    	        		{
    	        			$role = 3;
    	        			$this->userRepository->uppGradeUser($role,$userid);
    	        			$this->adminPanelView->setMessage(self::$DowngradeUser);
    	        		}
    	        		
    	        		
    	        	}


    	        	if ($this->adminPanelView->DidUserPressToRemoveUser()) {
    	        		# code...
    	        		$userid = $this->adminPanelView->getUserToRemove();
    	        	    $this->userRepository->removeUser($userid);
    	        		$this->adminPanelView->setMessage(self::$removeUser);
    	        	}

	             	return $this->adminPanelView->renderUserList();
             	}


             	else if ($this->loginController->isAuthenticated() && $this->profileView->didUserPressToShowProfile())
    	        {
    	        	if ($this->profileView->didUserPressToEditProfile()) 
    	        	{

    	        		return $this->changeUserController->editUserDetails();
    	        	}
    	        	
    	        	else 
    	        	{
	             		return $this->uploadController->imgUpload();
	             	}
             	}

             	// KOLLAR OM ID FINNS SAMT OM IDN FINNS I DATABASEN
				else if ($this->loginController->isAuthenticated() && $this->feed->hasSubmitAcourse() 
							&& $this->feed->checkIfIdInUrl() && $this->courseRepository->doIdExist($this->feed->getId()) && $this->feed->isValidId($this->feed->getId())) {

             		return $this->feed->showCourseFeed($this->feed->getId());
             		
             	}

	            // REGISTER OR LOGIN
	            else 
	            {
	                $this->loginController->doControll();
	            }
			}
			 
			catch (Exception $e) 
			{
				error_log($e->getMessage() . "\n", 3, Settings::$ERROR_LOG);
            	if (Settings::$DO_DEBUG) 
            	{
                	throw $e;
                }
                else
                {
                	return $this->inboxView->redirectToErrorPage();
                }
			}
	}

	public function getUsername() {
		return $this->forgetPasswordView->getUsername();	
	}

	public function getEmail() {
		return $this->forgetPasswordView->getEmail();
	}

	public function getCssViewForMaster($title = null) {
		return $this->inboxView->cssView($title);
	}
}
