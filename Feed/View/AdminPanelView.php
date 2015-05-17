<?php
	
	require_once('Model/ImagesModel.php');
	/**
	* Admin panel
	*/
	class AdminPanelView extends BaseView
	{
		
		protected $loginModel;
		private $user;
		private $messagesRepository;
		private $userRepository;
		protected $imagesModel;
		private $courseRepository;


		function __construct(LoginModel $model,MessagesRepository $messagesRepository,UserRepository $userRepository,CourseRepository $courseRepository)
		{
			# code...
			$this->loginModel = $model;
			$this->messagesRepository = $messagesRepository;
			$this->userRepository = $userRepository;
			$this->imagesModel = new ImagesModel(); 
			$this->courseRepository = $courseRepository;
		}


		  public function AdminPanel() {
			
				 $html = $this->cssView("UserList");

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
		                      $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox</a></li><span class="sr-only">(current)</span></a></li>';
		                  }
		                 
		              $html .= '<li><a name="Inbox" href="?' . $this->sendLocation ."&".$this->id."=".$this->loginModel->getId().'">Sent Messages</a></li>'.
		              '<li><a href="?' . $this->changePasswordLocation . '">Change Password</span></a></li>
		              </ul>
		            </div>';


		            $html .= '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		            ' . $this->message . '';
				$html .= '<div class="row"><div class="panel panel-info"> <div class="panel-heading"><h4>Admin Panel</h4></div></div></div>';

			  if ($this->loginModel->isAdmin()) 
		          {
		          	$html .= "<ul class='list-group'><a class='list-group-item' href='?". $this->CourseListLocation . "'>Manage Courses</a></ul>";
		          	  $html .= "<ul class='list-group'><a class='list-group-item' href='?". $this->UserListLocation . "'>Manage Users</a></ul>";
		              $html .= "<ul class='list-group'><a class='list-group-item' name='newCourse' href='?". $this->createNewCourseLocation . "'>Create Course</a></ul>";
		          }
		      return $html;
  		  }


  		  public function CourseList() 
  		  {
  		  	$courses = $this->courseRepository->GetAllCourses();

			 $html = $this->cssView("CourseList");

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
		                      $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox</a></li><span class="sr-only">(current)</span></a></li>';
		                  }
		                 
		              $html .= '<li><a name="Inbox" href="?' . $this->sendLocation ."&".$this->id."=".$this->loginModel->getId().'">Sent Messages</a></li>'.
		              '<li><a href="?' . $this->changePasswordLocation . '">Change Password</span></a></li>
		              </ul>
		            </div>';


		            $html .= '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		            ' . $this->message . '';

	   	     if ($courses != null) {
                	$html .= ' <div class="row"><div class="panel panel-info"> <div class="panel-heading"><h4>List of all courses</h4></div></div></div>';
	                foreach ($courses as $course) {

	                	if ($course['CourseId'] !== "1") {
 
	   					$html .= '<div class="panel panel-info">
	   							<div class="panel-body">	
	   						    <ul class="list-group"><a class="list-group-item" href="?' . $this->course . '&id='. $course['CourseId'] .'">'.$course['CourseName'].'</a></ul>
	               				<form role="form" action="" method="post">
	               				<td>
	               				<input type="hidden" name="' . $this->removeCourseLocation . '" id="' . $this->removeCourseLocation . '" value="'. $course['CourseId'] .'"></td>
	               				<td><button type="submit" name="' . $this->submitRemoveCourseLocation . '" class="btn btn-danger">Delete ' .$course['CourseName'].'</button></td></tr></br></br></form></div></div>';
	           		}
	           		}
                }

		      
		      return $html;











  		  }


  		   public function UserList() {
		    
		     $users = $this->userRepository->getAllUser();

		   	 
			    $html = $this->cssView("UserList");

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
		                      $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox</a></li><span class="sr-only">(current)</span></a></li>';
		                  }
		                 
		              $html .= '<li><a name="Inbox" href="?' . $this->sendLocation ."&".$this->id."=".$this->loginModel->getId().'">Sent Messages</a></li>'.
		              '<li><a href="?' . $this->changePasswordLocation . '">Change Password</span></a></li>
		              </ul>
		            </div>';


		            $html .= '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		            ' . $this->message . '';

		
    	        		

	   	     if ($users != null) {
                	$html .= ' <div class="row"><div class="panel panel-info"> <div class="panel-heading"><h4>List of all users</h4></div></div></div>';
	                foreach ($users as $usernames) {
	                	foreach ($usernames as $user) {
	                	
	                		$this->user = $user;
	                	}	 

	                	$userId = $this->userRepository->getUserIdByName($this->user);

	                	$dbRole = $this->userRepository->getRole($userId);

    	        	
			    		if($dbRole == 3) {
			    			# code...
			    			$role = "Upgrade";
			    		}
			    		else
			    		{
			    			$role = "Downgrade";
			    		}


	   					

	   						if ($userId != 0) {
	   								$html .= '<div class="panel panel-info">
	   							<div class="panel-body">';
	   								# code...
	   								  $html .= '<ul class="list-group"><a class="list-group-item" href="?profile&id='. $userId .'">'.$this->user.'</a></ul>';
	   								  	$html .= '<form role="form" action="" method="post"><tr>						
							    <td>
	               				<input type="hidden" name="' . $this->uppgradeLocation . '" id="' . $this->uppgradeLocation . '" value="'. $userId .'"></td>
	               				<td><button type="submit" name="' . $this->uppgradeUserLocation . '" class="btn btn-primary">'.$role." " .$this->user.'</button></td></br></br></form>
	               				<form role="form" action="" method="post">
	               				<td>
	               				<input type="hidden" name="' . $this->removeUserLocation . '" id="' . $this->removeUserLocation . '" value="'. $userId .'"></td>
	               				<td><button type="submit" name="' . $this->submitRemoveUserLocation . '" class="btn btn-danger">Delete ' .$this->user.'</button></td></tr></br></br></form></div></div>';
	   						}
	   						  
	   				
	           		}
                }

		      
		      return $html;
  		  }


  		    public function DidUserPressAdminPanel() {
		        if (isset($_GET[$this->AdminPanelLocation])) {
		            return true;
		        }
		        return false;
		    }

		     public function DidUserPressToUppgradeUser() {
		        if (isset($_POST[$this->uppgradeUserLocation])) {
		            return true;
		        }
		        return false;
		    }

		     public function DidUserPressToRemoveUser() {
		        if (isset($_POST[$this->submitRemoveUserLocation])) {
		            return true;
		        }
		        return false;
		    }

		     public function DidUserPressToRemoveCourse() {
		        if (isset($_POST[$this->submitRemoveCourseLocation])) {
		            return true;
		        }
		        return false;
		    }

   public function getCourseToRemove() {
		        if (isset($_POST[$this->removeCourseLocation])) {
		            return $_POST[$this->removeCourseLocation];
		        }
		    }


		    public function getUserToRemove() {
		        if (isset($_POST[$this->removeUserLocation])) {
		            return $_POST[$this->removeUserLocation];
		        }
		      
		    }


		    public function getUserToUppgrade() {
		        if (isset($_POST[$this->uppgradeLocation])) {
		            return $_POST[$this->uppgradeLocation];
		        }
		      
		    }

		     public function setMessage($message) {
      		  $this->message = $message;
    		}


		    public function DidUserPressCourseList() {
		        if (isset($_GET[$this->CourseListLocation])) {
		            return true;
		        }
		        return false;
		    }


		    public function DidUserPressUserList() {
		        if (isset($_GET[$this->UserListLocation])) {
		            return true;
		        }
		        return false;
		    }



		     public function renderAdminPanel() { 		
			    $Panel = $this->AdminPanel();


			    return $Panel;
			  }


	 		public function renderCourseList() {
			    $courseList = $this->CourseList();

			    	           	  $courseList .= '
			      </body>
			    </html>';
			    return $courseList;
			  }

			 public function renderUserList() {
			    $userList = $this->UserList();

			    $userList .= '
			      </body>
			    </html>';

			    return $userList;
			  }

	}